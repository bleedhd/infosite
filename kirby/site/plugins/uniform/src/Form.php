<?php

namespace Uniform;

use R;
use Str;
use Redirect;
use C as Config;
use ErrorException;
use Uniform\Guards\Guard;
use Uniform\Actions\Action;
use Uniform\Guards\HoneypotGuard;
use Uniform\Exceptions\Exception;
use Jevets\Kirby\Form as BaseForm;
use Uniform\Exceptions\PerformerException;
use Uniform\Exceptions\TokenMismatchException;

class Form extends BaseForm
{
    /**
     * Name of the form field containing the CSRF token.
     *
     * @var string
     */
    const CSRF_FIELD = 'csrf_token';

    /**
     * Indicates whether the validation should still be done
     *
     * @var boolean
     */
    protected $shouldValidate;

    /**
     * Indicates whether any guards should still be executed
     *
     * @var boolean
     */
    protected $shouldCallGuard;

    /**
     * Indicates whether the form should redirect on error
     *
     * @var boolean
     */
    protected $shouldRedirect;

    /**
     * Indicates whether the form should flash data or errors to the session
     *
     * @var boolean
     */
    protected $shouldFlash;

    /**
     * Indicates whether guards or actions should be silently passed over
     *
     * This happens if the form should not redirect. If a guard rejects the request or an
     * action fails, the subsequent guards or actions should be silently passed over
     * and the form returns with `$success = false`.
     *
     * @var boolean
     */
    protected $shouldFallThrough;

    /**
     * Indicates if the form was executed successfully
     *
     * @var boolean
     */
    protected $success;

    /**
     * Create a new instance
     *
     * @param  array  $rules  Form fields and their validation rules
     * @return void
     */
    function __construct($rules = [])
    {
        parent::__construct($rules);
        static::loadTranslation();
        $this->shouldValidate = true;
        $this->shouldCallGuard = true;
        $this->shouldRedirect = true;
        $this->shouldFlash = true;
        $this->shouldFallThrough = false;
        $this->success = false;
    }

    /**
     * Load the translation file for the current language
     */
    public static function loadTranslation()
    {
        if (defined('KIRBY')) {
            $site = kirby()->site();
            $code = $site->multilang()
                ? $site->language()->code()
                : Config::get('uniform.language', 'en');

            try {
                include_once __DIR__.DS.'..'.DS.'languages'.DS.$code.'.php';
            } catch (ErrorException $e) {
                throw new Exception("Uniform does not have a translation for the language '$code'.");
            }
        }
    }

    /**
     * Don't run the default guard.
     *
     * @return  Form
     */
    public function withoutGuards()
    {
        $this->shouldCallGuard = false;

        return $this;
    }

    /**
     * Don't perform a redirect if the validation, a guard or an action failed.
     *
     * @return  Form
     */
    public function withoutRedirect()
    {
        $this->shouldRedirect = false;

        return $this;
    }

    /**
     * Don't flash data or errors to the session
     *
     * @return  Form
     */
    public function withoutFlashing()
    {
        $this->shouldFlash = false;

        return $this;
    }

    /**
     * Check if the form was executed successfully.
     *
     * @return boolean
     */
    public function success()
    {
        return $this->success;
    }

    /**
     * Save the form data to the session
     */
    public function saveData()
    {
        if ($this->shouldFlash) {
            parent::saveData();
        }
    }

    /**
     * Validate the form data
     *
     * @return Form
     */
    public function validate()
    {
        $this->shouldValidate = false;

        if (csrf(R::postData(self::CSRF_FIELD)) !== true) {
            if (Config::get('debug') === true) {
                throw new TokenMismatchException('The CSRF token was invalid.');
            }

            $this->fail();
        }

        if (parent::validates()) {
            $this->success = true;
        } else {
            $this->fail();
        }

        return $this;
    }

    /**
     * Call a guard
     *
     * @param  string|Guard $guard   Guard classname or object
     * @param  array  $options Guard options
     */
    public function guard($guard = HoneypotGuard::class, $options = [])
    {
        if ($this->shouldValidate) $this->validate();
        $this->shouldCallGuard = false;
        if ($this->shouldFallThrough) return $this;

        if (is_string($guard) && !class_exists($guard)) {
            throw new Exception("{$guard} does not exist.");
        }

        if (!is_subclass_of($guard, Guard::class)) {
            throw new Exception('Guards must extend '.Guard::class.'.');
        }

        if (is_string($guard)) {
            $guard = new $guard($this, $options);
        }

        $this->perform($guard);

        return $this;
    }

    /**
     * Execute an action
     *
     * @param  string|Action  $action   Action classname or object
     * @param  array   $options Action options
     * @return Form
     */
    public function action($action, $options = [])
    {
        if ($this->shouldValidate) $this->validate();
        if ($this->shouldCallGuard) $this->guard();
        if ($this->shouldFallThrough) return $this;

        if (is_string($action) && !class_exists($action)) {
            throw new Exception("{$action} does not exist.");
        }

        if (!is_subclass_of($action, Action::class)) {
            throw new Exception('Actions must extend '.Action::class.'.');
        }

        if (is_string($action)) {
            $action = new $action($this, $options);
        }

        $this->perform($action);

        return $this;
    }

    /**
     * Forget a form field
     *
     * @param  string $key Form field name
     */
    public function forget($key)
    {
        unset($this->data[$key]);
    }

    /**
     * Call actions and gards as magic method.
     *
     * Usage:
     * $form->calcGuard(...);
     * instead of
     * $form->guard(\Uniform\Guards\CalcGuard::class, ...);
     *
     * $form->emailAction(...);
     * instead of
     * $form->action(\Uniform\Actions\EmailAction::class, ...);
     *
     * @param  string $method
     * @param  array  $parameters
     * @return Form|null
     */
    public function __call($method, $parameters = [])
    {
        if (Str::endsWith($method, 'Guard')) {
            $class = '\Uniform\Guards\\'.ucfirst($method);
            $options = array_key_exists(0, $parameters) ? $parameters[0] : [];

            return $this->guard($class, $options);
        } else if (Str::endsWith($method, 'Action')) {
            $class = '\Uniform\Actions\\'.ucfirst($method);
            $options = array_key_exists(0, $parameters) ? $parameters[0] : [];

            return $this->action($class, $options);
        }
    }

    /**
     * Redirect back to the page of the form
     */
    protected function fail()
    {
        $this->success = false;

        if ($this->shouldRedirect) {
            Redirect::back();
        } else {
            $this->shouldFallThrough = true;
        }
    }

    /**
     * Perform a performer and handle a possible exception
     *
     * @param  Performer $performer
     */
    protected function perform(Performer $performer)
    {
        try {
            $performer->perform();
        } catch (PerformerException $e) {
            $this->addError($e->getKey(), $e->getMessage());
            $this->saveData();
            $this->fail();
        }
    }

    /**
     * Save the errors to the session
     */
    protected function saveErrors()
    {
        if ($this->shouldFlash) {
            parent::saveErrors();
        }
    }
}
