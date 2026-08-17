<?php
/**
 * @package     LOGman
 * @copyright   Copyright (C) 2011 Timble CVBA. (http://www.timble.net)
 * @license     GNU GPLv3 <http://www.gnu.org/licenses/gpl.html>
 * @link        http://www.joomlatools.com
 */

/**
 * LOGman Koowa Plugin.
 *
 * Loads LOGman plugin group and its dependencies.
 *
 * @author  Arunas Mazeika <https://github.com/amazeika>
 * @package Joomlatools\Plugin\Koowa
 */
class PlgKoowaLogman extends PlgKoowaAbstract
{
	protected $_error_handler = null;

    function __construct($dispatcher, $config = array())
    {
        if (version_compare($this->_getLogmanVersion(), '3.0.0-beta1', '>='))
        {
            $classes = array(
                'administrator/components/com_logman/activity/interface.php',
                'administrator/components/com_logman/plugin/interface.php',
                'administrator/components/com_logman/plugin/logger/interface.php',
                'administrator/components/com_logman/plugin/abstract.php',
                'administrator/components/com_logman/plugin/logger.php',
                'administrator/components/com_logman/plugin/joomla.php',
                'administrator/components/com_logman/plugin/koowa.php',
                'administrator/components/com_logman/plugin/notifier.php',
                'administrator/components/com_logman/activity/notifier/interface.php',
                'administrator/components/com_logman/activity/notifier/abstract.php',
                'administrator/components/com_logman/activity/notifier/email.php',
                'administrator/components/com_logman/plugin/notifier.php',
                'administrator/components/com_logman/controller/behavior/loggable.php',
                'administrator/components/com_logman/model/entity/activity.php',
                'administrator/components/com_logman/activity/logger/logger.php',
                'administrator/components/com_logman/activity/translator.php'
            );

            $path = defined('JOOMLATOOLS_PLATFORM') ? JPATH_APP : JPATH_ROOT;

            // Make sure files exist as otherwise whole site will go down with a fatal error
            $files_exist = true;
            foreach ($classes as $class)
            {
                if (!file_exists($path . '/' . $class))
                {
                    $files_exist = false;
                    break;
                }
            }

            if ($files_exist)
            {
                // Load LOGman base plugin classes.
                foreach ($classes as $class) {
                    require_once $path . '/' . $class;
                }

                // Load LOGman plugin group.
                JPluginHelper::importPlugin('logman');
            }
        }

        if ($handler = JError::getErrorHandling(E_ERROR)) {
			$this->_error_handler = $handler;
		}

        JError::setErrorHandling(E_ERROR, 'callback', array($this, 'handleError'));

        parent::__construct($dispatcher, $config);
    }

	protected function _handleError(Exception $exception)
	{
		if ($handler = $this->_error_handler)
		{
			// Reset error handler

			JError::setErrorHandling(E_ERROR, $handler['mode'], $handler['options']);

			$function = 'handle' . ucfirst($handler['mode']);

			// We cannot simply raise the error again, JError::throwError keeps track of a previously
			// thrown errors in a static funcion variable which prevents the error page from rendering
			// again. Below we try making the error handling call ourselves, or raise the error which will
			// result on error being rendered outside the template

			if (is_callable(array('JError', $function))) {
				call_user_func_array(array('JError', $function), array(&$exception, isset($handler['options']) ? $handler['options'] : array()));
			} else {
				JError::raiseError($exception->getCode(), $exception->getMessage());
			}
		}
	}

    /**
     * Initializes the options for the object
     *
     * Called from {@link __construct()} as a first step of object instantiation.
     *
     * @param   KObjectConfig $config Configuration options.
     * @return  void
     */
    protected function _initialize(KObjectConfig $config)
    {
        $config->append(array(
            'auto_connect' => false
        ));
    }

    public function handleError(Exception $je)
    {
        if ($je->getCode() == 404)
		{
		    if (!$this->getObject('com://admin/logman.controller.route')->redirect()) {
                $this->_handleError($je);
            }
        }
        else $this->_handleError($je);
	}

    /**
     * LOGman version getter.
     *
     * @return string|null The extension version, null if couldn't be determined.
     */
    protected function _getLogmanVersion()
    {
        $version = null;

        $query = "SELECT manifest_cache FROM #__extensions WHERE element = 'com_logman'";
        if ($result = JFactory::getDBO()->setQuery($query)->loadResult())
        {
            $manifest = new JRegistry($result);
            $version  = $manifest->get('version', null);
        }

        return $version;
    }
}

