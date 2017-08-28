<?php

namespace Getunik\Campaign;

use BaseField;
use C;
use Constructs\Construct;
use Constructs\Util\Dir;
use F;


class WidgetModules
{
	/**
	 * Controller action for the widget module select field.
	 *
	 * @param BaseField $field
	 *   The (panel) field for which the options are retrieved.
	 *
	 * @return array
	 */
	public static function listOptions(BaseField $field)
	{
		$options = [];
		$defaults = static::defaultModules();

		foreach (static::moduleLocations() as $path) {
			$dir = new Dir($path);
			foreach ($dir->find(Dir::filterByExtension('js')) as $moduleFile) {
				$name = basename($moduleFile->name(), '.js');
				if (!in_array($name, $defaults)) {
					$options[$name] = static::readModuleName($moduleFile->path(), $moduleFile->name());
				}
			}
		}

		return $options;
	}

	/**
	 * Gets the configured paths in which widget modules can be found.
	 *
	 * @return array
	 */
	public static function moduleLocations()
	{
		/** @var Construct $construct */
		$construct = kirby()->get('construct', 'widget');
		$modulesRelative = 'js' . DS . 'widget-modules';

		return C::get('widget.moduleLocations', [$construct->assetsPath() . DS . $modulesRelative, kirby()->roots()->assets() . DS . $modulesRelative]);
	}

	/**
	 * Gets the default (not customizable by the user) modules for this widget.
	 *
	 * @return array
	 */
	public static function defaultModules()
	{
		return C::get('widget.defaultModules', ['amount-options']);
	}

	protected static function readModuleName($moduleFile, $default)
	{
		$content = F::read($moduleFile);

		if (preg_match('/@name\s+(.*)$/m', $content, $matches)) {
			return $matches[1];
		}

		return $default;
	}
}
