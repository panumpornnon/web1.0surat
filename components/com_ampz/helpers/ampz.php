<?php

/**
 * @version    4.1.1
 * @package    AMPZ
 * @author     roosterz.nl <roy@roosterz.nl>
 * @copyright  2022 roosterz.nl
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;

/**
 * Class AmpzFrontendHelper
 *
 * @since  1.6
 */
class AmpzHelpersAmpz
{
	/**
	 * Get an instance of the named model
	 *
	 * @param   string  $name  Model name
	 *
	 * @return null|object
	 */
	public static function getModel($name)
	{
		$model = null;

		// If the file exists, let's
		if (file_exists(JPATH_SITE . '/components/com_ampz/models/' . strtolower($name) . '.php'))
		{
			require_once JPATH_SITE . '/components/com_ampz/models/' . strtolower($name) . '.php';
			$model = JModelLegacy::getInstance($name, 'AmpzModel');
		}

		return $model;
	}
}
