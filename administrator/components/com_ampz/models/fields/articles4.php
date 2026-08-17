<?php
/**
 * Element: Articles  for Joomla 4.x
 * Displays a list of articles
 *
 * @package  AMPZ
 * @copyright  2022 roosterz.nl
 * @ All rights reserved
 * @ Joomla! is Free Software
 * @ Released under GNU/GPL v3.0 License : http://www.gnu.org/licenses/gpl-3.0.html
 **/

defined('_JEXEC') or die;

JFormHelper::loadFieldClass('list');

class JFormFieldRH_Articles4 extends JFormFieldList
{
    public $type    = 'Articles4';
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

        $articles = $this->getArticles();

        if ($articles !== false) {
            foreach ($articles as $article)
            {
                $art_title_id = $article->title . " [" . $article->ctitle . "]" . " [" . $article->id . "]";
                $options[]    = JHtml::_('select.option', $article->id, $art_title_id);
            }

            return $options;
        }

        return "";
    }

    public function getArticles()
    {
        $this->db = JFactory::getDBO();

        $query = $this->db->getQuery(true)
            ->select('COUNT(*)')
            ->from('#__content AS a')
            ->where('a.access > -1');
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
            ->select('a.title, a.id, c.title as ctitle')
            ->from('#__content AS a, #__categories AS c')
            ->where('a.access > -1')
            ->where('a.state > 0')
            ->where('a.catid = c.id');
        $this->db->setQuery($query);
        $articles = $this->db->loadObjectList();

        return $articles;
    }

    private function get($val, $default = '')
    {
        return (isset($this->params[$val]) && (string) $this->params[$val] != '') ? (string) $this->params[$val] : $default;
    }
}
