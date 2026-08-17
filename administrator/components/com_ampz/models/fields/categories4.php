<?php
/**
 * Element: Categories  for Joomla 4.x
 * Displays a list of categories
 *
 * @package  AMPZ
 * @copyright  2022 roosterz.nl
 * @ All rights reserved
 * @ Joomla! is Free Software
 * @ Released under GNU/GPL v3.0 License : http://www.gnu.org/licenses/gpl-3.0.html
 **/

defined('_JEXEC') or die;

JFormHelper::loadFieldClass('list');

class JFormFieldRH_Categories4 extends JFormFieldList
{
    public $type    = 'Categories4';
    private $params = null;
    private $db     = null;

    /**
     * Method to get the field options.
     *
     * @return  array  The field option objects.
     *
     * @since   11.1
     */
    protected function getOptions()
    {
		$options = array();

		$categories = $this->getCategories();

        foreach ($categories as $category) {
            $cat_title_id = $category->title . " [" . $category->id . "]";
            $options[]    = JHtml::_('select.option', $category->id, $cat_title_id);
        }

		return $options;
    }

    public function getCategories()
    {
		$this->db     = JFactory::getDBO();

        $query = $this->db->getQuery(true)
            ->select('COUNT(*)')
            ->from('#__categories AS a')
            ->where('a.extension = ' . $this->db->quote('com_content'))
            ->where('a.parent_id > 0')
            ->where('a.published > -1');
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
