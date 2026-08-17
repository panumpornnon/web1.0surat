<?php
/**
 * Element: Menu Items
 * Displays a list of menu items
 *
 * @package  AMPZ
 * @copyright  2022 roosterz.nl
 * @ All rights reserved
 * @ Joomla! is Free Software
 * @ Released under GNU/GPL v3.0 License : http://www.gnu.org/licenses/gpl-3.0.html
 **/

defined('_JEXEC') or die;


class JFormFieldRH_MenuItems extends JFormField
{
	public $type = 'MenuItems';

	protected function getInput()
	{
		$this->params = $this->element->attributes();

		$size     = 0;
        $multiple = true;

		$options = $this->getMenuItems();

        require_once dirname(__DIR__) . '/fields/helpers/html.php';

		return RHHtml::selectlist($options, $this->name, $this->value, $this->id, $size, $multiple);
	}

	/**
	 * Get a list of menu links for one or all menus.
	 */
	public static function getMenuItems()
	{
		$db    = JFactory::getDbo();
		$query = $db->getQuery(true)
			->select('a.id AS value, a.title AS text, a.alias, a.level, a.menutype, a.type, a.template_style_id, a.checked_out, a.language')
			->from('#__menu AS a')
			->join('LEFT', $db->quoteName('#__menu') . ' AS b ON a.lft > b.lft AND a.rgt < b.rgt')
			->where('a.published != -2')
			->group('a.id, a.title, a.level, a.menutype, a.type, a.template_style_id, a.checked_out, a.lft')
			->order('a.lft ASC');

		// Get the options.
		$db->setQuery($query);

		try
		{
			$links = $db->loadObjectList();
		}
		catch (RuntimeException $e)
		{
			JError::raiseWarning(500, $e->getMessage());

			return false;
		}

		// Group the items by menutype.
		$query->clear()
			->select('*')
			->from('#__menu_types')
			->where('menutype <> ' . $db->quote(''))
			->order('title, menutype');
		$db->setQuery($query);

		try
		{
			$menuTypes = $db->loadObjectList();
		}
		catch (RuntimeException $e)
		{
			JError::raiseWarning(500, $e->getMessage());

			return false;
		}

		// Create a reverse lookup and aggregate the links.
		$rlu = array();
		foreach ($menuTypes as &$type)
		{
			$type->value      = 'type.' . $type->menutype;
			$type->text       = $type->title;
			$type->level      = 0;
			$type->class      = 'hidechildren';
			$type->labelclass = 'nav-header';

			$rlu[$type->menutype] = &$type;
			$type->links          = array();
		}

		// Loop through the list of menu links.
		foreach ($links as &$link)
		{
			if (isset($rlu[$link->menutype]))
			{
				if (preg_replace('#[^a-z0-9]#', '', strtolower($link->text)) !== preg_replace('#[^a-z0-9]#', '', $link->alias))
				{
					$link->text .= ' <small>[' . $link->alias . ']</small>';
				}

				if ($link->language && $link->language != '*')
				{
					$link->text .= ' <small>(' . $link->language . ')</small>';
				}

				if ($link->type == 'alias')
				{
					$link->text .= ' <small>(' . JText::_('COM_MENUS_TYPE_ALIAS') . ')</small>';
					$link->disable = 1;
				}

				$rlu[$link->menutype]->links[] = &$link;

				// Cleanup garbage.
				unset($link->menutype);
			}
		}

		return $menuTypes;
	}
}
