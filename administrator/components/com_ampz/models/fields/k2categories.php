<?php
/**
 * Element: K2Categories
 * Displays a list of categories
 *
 * @package  AMPZ
 * @copyright  2022 roosterz.nl
 * @ All rights reserved
 * @ Joomla! is Free Software
 * @ Released under GNU/GPL v3.0 License : http://www.gnu.org/licenses/gpl-3.0.html
 **/

defined('_JEXEC') or die;

class JFormFieldRH_K2Categories extends JFormField
{
	public $type = 'K2Categories';
	private $params = null;
	private $db = null;

	protected function getInput()
	{
		$this->params = $this->element->attributes();
		$this->db = JFactory::getDBO();

		$query = $this->db->getQuery(true)
			->select('e.enabled')
			->from('#__extensions AS e')
			->where('e.name = "com_k2"');
		$this->db->setQuery($query);
		$k2enabled = $this->db->loadResult();

		if ($k2enabled != 1) { // K2 is not installed or enabled so don't show this
			echo '<style type="text/css">
	        .k2-callout {
	            display: none;
	        }
	        </style>';

			return;
		}

		$query = $this->db->getQuery(true)
            ->select('COUNT(*)')
            ->from('#__k2_categories AS a');
        $this->db->setQuery($query);
        $total = $this->db->loadResult();

        $plugin = JPluginHelper::getPlugin('system', 'ampz');

        // Check if plugin is enabled
        if ($plugin)
        {
            $pluginParams   = new JRegistry($plugin->params);
            $max_list_count = $pluginParams->get('max_list_count', 1000);
        }

        if ($total > $max_list_count) {
            return false;
        }

		$categories = $this->getCategories();

		$options = array();

		foreach ($categories as $category)
		{
			$cat_title_id = $category->name . " [" . $category->id . "]";
			$options[] = JHtml::_('select.option', $category->id, $cat_title_id);
		}

		return JHtml::_('select.genericlist', $options, $this->name, array(
			'multiple' => 'multiple'
		), 'value', 'text', $this->value, $this->id);

	}

	function getCategories()
	{
		jimport('joomla.filesystem.file');

		// If controller.php exists, assume this is K2 v3
		(JFile::exists(JPATH_ADMINISTRATOR . '/components/com_k2/controller.php') ? $k2_version = 3 : $k2_version = 2);

		$state_field = $k2_version == 3 ? 'state' : 'published';

		$query = $this->db->getQuery(true)
			->select('c.name, c.id')
			->from('#__k2_categories AS c')
			->where('c.' . $state_field . ' > -1');
		$this->db->setQuery($query);
		$categories = $this->db->loadObjectList();

		return $categories;
	}

	private function get($val, $default = '')
	{
		return (isset($this->params[$val]) && (string) $this->params[$val] != '') ? (string) $this->params[$val] : $default;
	}
}
