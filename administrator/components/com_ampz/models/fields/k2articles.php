<?php
/**
 * Element: K2 Articles
 * Displays a list of K2 articles
 *
 * @package  AMPZ
 * @copyright  2022 roosterz.nl
 * @ All rights reserved
 * @ Joomla! is Free Software
 * @ Released under GNU/GPL v3.0 License : http://www.gnu.org/licenses/gpl-3.0.html
 **/

defined('_JEXEC') or die;

class JFormFieldRH_K2Articles extends JFormField
{
	public $type = 'K2Articles';
	private $params = null;
	private $db = null;

	protected function getInput()
	{
		jimport('joomla.filesystem.file');

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
            ->from('#__k2_items AS a')
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

		$articles = $this->getArticles();

		$options = array();

		foreach ($articles as $article)
		{
			$art_title_id = $article->title . " [" . $article->ctitle . "]" . " [" . $article->id . "]";
			$options[] = JHtml::_('select.option', $article->id, $art_title_id);
		}

		return JHtml::_('select.genericlist', $options, $this->name, array(
			'multiple' => 'multiple'
		), 'value', 'text', $this->value, $this->id);

	}

	function getArticles()
	{
		jimport('joomla.filesystem.file');

		// If controller.php exists, assume this is K2 v3
		(JFile::exists(JPATH_ADMINISTRATOR . '/components/com_k2/controller.php') ? $k2_version = 3 : $k2_version = 2);

		$state_field = $k2_version == 3 ? 'state' : 'published';

		$query = $this->db->getQuery(true)
			->select('a.title, a.id, c.title as ctitle')
			->from('#__k2_items AS a, #__categories AS c')
			->where('a.access > -1')
			->where('c.' . $state_field . ' > -1')
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
