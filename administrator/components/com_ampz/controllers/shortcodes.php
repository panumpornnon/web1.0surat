<?php
/**
 * @version    4.1.1
 * @package    AMPZ
 * @author     roosterz.nl <roy@roosterz.nl>
 * @copyright  2022 roosterz.nl
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access.
defined('_JEXEC') or die;

jimport('joomla.application.component.controlleradmin');

use Joomla\Utilities\ArrayHelper;

/**
 * Shortcodes list controller class.
 *
 * @since  1.6
 */
class AmpzControllerShortcodes extends JControllerAdmin
{
	/**
	 * Method to clone existing Shortcodes
	 *
	 * @return void
	 */
	public function duplicate()
	{
		// Check for request forgeries
		Jsession::checkToken() or jexit(JText::_('JINVALID_TOKEN'));

		// Get id(s)
		$pks = $this->input->post->get('cid', array(), 'array');

		try
		{
			if (empty($pks))
			{
				throw new Exception(JText::_('COM_AMPZ_NO_ELEMENT_SELECTED'));
			}

			ArrayHelper::toInteger($pks);
			$model = $this->getModel();
			$model->duplicate($pks);
			$this->setMessage(Jtext::_('COM_AMPZ_ITEMS_SUCCESS_DUPLICATED'));
		}
		catch (Exception $e)
		{
			JFactory::getApplication()->enqueueMessage($e->getMessage(), 'warning');
		}

		$this->setRedirect('index.php?option=com_ampz&view=shortcodes');
	}

	/**
	 * Proxy for getModel.
	 *
	 * @param   string  $name    Optional. Model name
	 * @param   string  $prefix  Optional. Class prefix
	 * @param   array   $config  Optional. Configuration array for model
	 *
	 * @return  object	The Model
	 *
	 * @since    1.6
	 */
	public function getModel($name = '', $prefix = 'AmpzModel', $config = array())
	{
		$model = parent::getModel($name, $prefix, array('ignore_request' => true));

		return $model;
	}

	/**
     * Delete Method
     * Delete the shortcode specified by id
     * and set Redirection to the list of items
     */
    function delete()
    {
		$id = JFactory::getApplication()->input->get('id');

        $db = JFactory::getDbo();

        $query = $db->getQuery(true);
        $query
            ->delete($db->quoteName('#__ampz'))
            ->where($db->quoteName('id') . ' = ' . $id);

        $db->setQuery($query);
        $db->execute();

        $msg = JText::sprintf('Shortcode deleted', $id);
        JFactory::getApplication()->redirect('index.php?option=com_ampz&view=shortcodes', $msg);
    }

}
