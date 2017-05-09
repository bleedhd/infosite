<?php

namespace Uniform\Actions;

use L;

/**
 * Action to log in a user.
 */
class LoginAction extends Action
{
    /**
     * Log in a user.
     */
    public function perform()
    {
        $userField = $this->option('user-field', 'username');
        $passwordField = $this->option('password-field', 'password');

        $user = $this->getUser($this->form->data($userField));

        if (!$user || !$user->login($this->form->data($passwordField))) {
            $this->fail(L::get('uniform-login-error'), $userField);
        }
    }

    /**
     * Get a user based on the username
     *
     * @param  string $name
     * @return User
     */
    protected function getUser($name)
    {
        return site()->user($name);
    }
}
