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
class AmpzViewShortcode extends JViewLegacy
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
		// get the Data
        $form = $this->get('Form');
        $item = $this->get('Item');

        // Check for errors.
        if (count($errors = $this->get('Errors'))) 
        {
            JFactory::getApplication()->enqueueMessage($errors, 'error');
            return false;
        }

        // Assign the Data
        $this->form = $form;
        $this->item = $item;
        $this->isnew = (!isset($_REQUEST["id"])) ? true : false;

		// Set the toolbar
        $this->addToolBar();

		parent::display($tpl);
	}

	/**
     * Setting the toolbar
     */
    protected function addToolBar() 
    {
        $input = JFactory::getApplication()->input;
        $input->set('hidemainmenu', true);
        $isNew = ($this->item->id == 0);

        JToolBarHelper::title($isNew ? JText::_('New AMPZ Shortcode') : JText::_('Edit AMPZ Shortcode: ' . $this->item->name . " - ". $this->item->id));

        JToolbarHelper::apply('shortcode.apply');
        JToolBarHelper::save('shortcode.save');
        JToolbarHelper::save2new('shortcode.save2new');
        JToolBarHelper::cancel('shortcode.cancel', $isNew ? 'JTOOLBAR_CANCEL' : 'JTOOLBAR_CLOSE');
    }
}
