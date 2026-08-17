<?php
/**
 * Element: Zoo Articles
 * Displays a list of Zoo articles
 *
 * @package  AMPZ
 * @copyright  2022 roosterz.nl
 * @ All rights reserved
 * @ Joomla! is Free Software
 * @ Released under GNU/GPL v3.0 License : http://www.gnu.org/licenses/gpl-3.0.html
 **/

defined('_JEXEC') or die;

class JFormFieldRH_ZooArticles extends JFormField
{
	public $type = 'ZooArticles';
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

		$query = $this->db->getQuery(true)
			->select('COUNT(*)')
			->from('#__zoo_item AS a')
			->where('a.state > 0');
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
			$art_title_id = $article->name . " [" . $article->id . "]";
			$options[] = JHtml::_('select.option', $article->id, $art_title_id);
		}

		return JHtml::_('select.genericlist', $options, $this->name, array(
			'multiple' => 'multiple'
		), 'value', 'text', $this->value, $this->id);

	}

	function getArticles()
	{
		jimport('joomla.filesystem.file');

		$query = $this->db->getQuery(true)
			->select('a.name, a.id')
			->from('#__zoo_item AS a')
			->where('a.state > 0');
		$this->db->setQuery($query);
		$articles = $this->db->loadObjectList();

		return $articles;
	}

	private function get($val, $default = '')
	{
		return (isset($this->params[$val]) && (string) $this->params[$val] != '') ? (string) $this->params[$val] : $default;
	}
}
