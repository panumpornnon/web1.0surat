<?php
/**
 * Element: ZooCategories
 * Displays a list of Zoo categories
 *
 * @package  AMPZ
 * @copyright  2022 roosterz.nl
 * @ All rights reserved
 * @ Joomla! is Free Software
 * @ Released under GNU/GPL v3.0 License : http://www.gnu.org/licenses/gpl-3.0.html
 **/

defined('_JEXEC') or die;

class JFormFieldRH_ZooCategories extends JFormField
{
	public $type = 'ZooCategories';
	private $params = null;
	private $db = null;

	protected function getInput()
	{
		$this->params = $this->element->attributes();
		$this->db = JFactory::getDBO();

		$query = $this->db->getQuery(true)
			->select('e.enabled')
			->from('#__extensions AS e')
			->where('e.name = "com_zoo"');
		$this->db->setQuery($query);
		$zoo_enabled = $this->db->loadResult();

		if ($zoo_enabled != 1) { // Zoo is not installed or enabled so don't show this
			echo '<style type="text/css">
	        .zoo-callout {
	            display: none;
	        }
	        </style>';

			return;
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

		$query = $this->db->getQuery(true)
			->select('c.name, c.id')
			->from('#__zoo_category AS c')
			->where('c.published > 0');
		$this->db->setQuery($query);
		$categories = $this->db->loadObjectList();

		return $categories;
	}

	private function get($val, $default = '')
	{
		return (isset($this->params[$val]) && (string) $this->params[$val] != '') ? (string) $this->params[$val] : $default;
	}
}
