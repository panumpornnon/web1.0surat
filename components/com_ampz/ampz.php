<?php
/**
 * @version    4.1.1
 * @package    AMPZ
 *
 * @author     roosterz.nl <roy@roosterz.nl>
 * @copyright  2022 roosterz.nl
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') || die;

// Include dependancies
jimport('joomla.application.component.controller');

JLoader::registerPrefix('Ampz', JPATH_COMPONENT);
JLoader::register('AmpzController', JPATH_COMPONENT . '/controller.php');

// Execute the task.
$controller = JControllerLegacy::getInstance('Ampz');
$controller->execute(JFactory::getApplication()->input->get('task'));
$controller->redirect();
