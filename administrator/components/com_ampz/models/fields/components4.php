<?php
/**
 * Element: Components for Joomla 4.x
 * Displays a list of components
 *
 * @package  AMPZ
 * @copyright  2022 roosterz.nl
 * @ All rights reserved
 * @ Joomla! is Free Software
 * @ Released under GNU/GPL v3.0 License : http://www.gnu.org/licenses/gpl-3.0.html
 **/

defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLHelper;

use Joomla\CMS\Form\FormField;
use Joomla\CMS\Form\FormHelper;
use Joomla\CMS\Form\Field\ListField;

JFormHelper::loadFieldClass('list'); 
 
// class RH_Components4Field extends ListField
class JFormFieldRH_Components4 extends JFormFieldList
{
	protected $type = 'rh_components4';
	private $params = null;
	private $db = null;
  
	public function getOptions()
	{ 
		$options   = [];

		$this->params = $this->element->attributes();
		$this->db = JFactory::getDBO();

		$frontend = $this->get('frontend', 1);
		$admin = $this->get('admin', 1);
		$size = (int) $this->get('size');
		
		$components = $this->getComponents($frontend, $admin);

		$options = array();

		foreach ($components as $component)
		{
			$options[] = HTMLHelper::_('select.option', $component->element, $component->name);
		}

		return $options;
	}

	function getComponents($frontend = 1, $admin = 1)
	{
		jimport('joomla.filesystem.folder');
		jimport('joomla.filesystem.file');

		$query = $this->db->getQuery(true)
			->select('e.name, e.element')
			->from('#__extensions AS e')
			->where('e.type = ' . $this->db->quote('component'))
			->where('e.name != ""')
			->where('e.element != ""')
			->group('e.element')
			->order('e.element, e.name');
		$this->db->setQuery($query);
		$components = $this->db->loadObjectList();

		$comps = array();
		$lang = JFactory::getLanguage();

		foreach ($components as $i => $component)
		{
			
			// return if there is no main component folder
			/*if (!($frontend && JFolder::exists(JPATH_SITE . '/components/' . $component->element))
				&& !($admin && JFolder::exists(JPATH_ADMINISTRATOR . '/components/' . $component->element))
			)
			{
				continue;
			}

			// return if there is no views folder
			if (!($frontend && JFolder::exists(JPATH_SITE . '/components/' . $component->element . '/views'))
				&& !($admin && JFolder::exists(JPATH_ADMINISTRATOR . '/components/' . $component->element . '/views'))
			)
			{
				continue;
			}*/
			if (!empty($component->element))
			{
				// Load the core file then
				// Load extension-local file.
				$lang->load($component->element . '.sys', JPATH_BASE, null, false, false)
				|| $lang->load($component->element . '.sys', JPATH_ADMINISTRATOR . '/components/' . $component->element, null, false, false)
				|| $lang->load($component->element . '.sys', JPATH_BASE, $lang->getDefault(), false, false)
				|| $lang->load($component->element . '.sys', JPATH_ADMINISTRATOR . '/components/' . $component->element, $lang->getDefault(), false, false);
			}
			$component->name = JText::_(strtoupper($component->name));
			$comps[preg_replace('#[^a-z0-9_]#i', '', $component->name . '_' . $component->element)] = $component;
		
		}
		ksort($comps);

		return $comps;
	}

	private function get($val, $default = '')
	{
		return (isset($this->params[$val]) && (string) $this->params[$val] != '') ? (string) $this->params[$val] : $default;
	}
}
