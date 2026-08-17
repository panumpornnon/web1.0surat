<?php
/**
 * Element: Categories
 * Displays a list of categories
 *
 * @package  AMPZ
 * @copyright  2022 roosterz.nl
 * @ All rights reserved
 * @ Joomla! is Free Software
 * @ Released under GNU/GPL v3.0 License : http://www.gnu.org/licenses/gpl-3.0.html
 **/

defined('_JEXEC') or die;

class JFormFieldRH_Categories extends JFormField
{
	public $type = 'Categories';
	private $params = null;
	private $db = null;

	protected function getInput()
	{
		$this->params = $this->element->attributes();
		$this->db = JFactory::getDBO();

		$categories = $this->getCategories();

		$options = array();

		foreach ($categories as $category)
		{
			$cat_title_id = $category->title . " [" . $category->id . "]";
			$options[] = JHtml::_('select.option', $category->id, $cat_title_id);
		}

		return JHtml::_('select.genericlist', $options, $this->name, array(
			'multiple' => 'multiple'
		), 'value', 'text', $this->value, $this->id);

	}

	function getCategories()
	{
		$query = $this->db->getQuery(true)
			->select('c.title, c.path, c.id')
			->from('#__categories AS c')
			->where('c.extension = ' . $this->db->quote('com_content'))
			->where('c.parent_id > 0')
			->where('c.published > -1');
		$this->db->setQuery($query);
		$categories = $this->db->loadObjectList();

		return $categories;
	}

	private function get($val, $default = '')
	{
		return (isset($this->params[$val]) && (string) $this->params[$val] != '') ? (string) $this->params[$val] : $default;
	}
}
