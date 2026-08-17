<?php

/**
 * @version    4.1.1
 * @package    AMPZ
 * @author     roosterz.nl <roy@roosterz.nl>
 * @copyright  2022 roosterz.nl
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */
// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.view');

/**
 * View class for a list of Ampz.
 *
 * @since  1.6
 */
class AmpzViewShortcodes extends JViewLegacy
{
	protected $items;

	protected $pagination;

	protected $state;

	/**
	 * Display the view
	 *
	 * @param   string  $tpl  Template name
	 *
	 * @return void
	 *
	 * @throws Exception
	 */
	public function display($tpl = null)
	{
		if ($this->getLayout() == 'button')
		{
			// Load plugin language file

			$basePath = JPATH_SITE . '/plugins/editors-xtd/ampz/';
			JFactory::getLanguage()->load("plg_editors-xtd_ampz", $basePath);

			// Get editor name
			$eName = JFactory::getApplication()->input->getCmd('e_name');

			// Get form fields
			$xml = JPATH_PLUGINS . "/editors-xtd/ampz/form.xml";
			$form = new JForm("com_ampz.button", array('control' => 'jform'));
	        $form->loadFile($xml, false);

	        // Template properties
	        $this->eName = preg_replace('#[^A-Z0-9\-\_\[\]]#i', '', $eName);
            $this->form = $form;

			parent::display($tpl);
			return;
		}

		$this->state = $this->get('State');
		$this->items = $this->get('Items');
		$this->pagination = $this->get('Pagination');

		// Check for errors.
		if (count($errors = $this->get('Errors')))
		{
			throw new Exception(implode("\n", $errors));
		}

		// Set the toolbar
        $this->addToolBar();

		parent::display($tpl);
	}

	/**
     *  Add Toolbar to layout
     */
    protected function addToolBar()
    {

        JToolBarHelper::title(JText::_('AMPZ Shortcodes'));

        JToolbarHelper::addNew('shortcode.add');

    }

}
