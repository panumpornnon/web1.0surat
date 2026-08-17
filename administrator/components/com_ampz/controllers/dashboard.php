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
 * Dashboard controller class.
 *
 * @since  1.6
 */
class AmpzControllerDashboard extends JControllerAdmin
{
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
     *  Resets ampz statistics
     *
     *  @return  void
     */
    public function reset()
    {
        $db = JFactory::getDbo();

        $query = $db->getQuery(true);
        $query->delete($db->quoteName('#__ampz_stats'));

        $db->setQuery($query);
        $db->execute();

        $msg = JText::sprintf('COM_AMPZ_STATISTICS_RESET');

        JFactory::getApplication()->redirect('index.php?option=com_ampz&view=dashboard', $msg);
    }

    /**
     * Export Method
     * Export the selected items specified by id
     */
    public function export()
    {
        // Get the model.
        $model = $this->getModel('Dashboard');
        $model->export();
    }

    /**
     * Import Method
     * Set layout to import
     */
    public function import()
    {
        $app = JFactory::getApplication();
        $file = $app->input->files->get("file");

        if (!empty($file)) {
            if (isset($file['name'])) {
                // Get the model.
                $model = $this->getModel('Dashboard');
                $model->import();
            } else {
                $msg = JText::_('COM_AMPZ_PLEASE_CHOOSE_A_VALID_FILE');
                $app->enqueueMessage($msg);
                $this->setRedirect('index.php?option=com_ampz&view=dashboard&layout=import');
            }
        } else {
            $this->setRedirect('index.php?option=com_ampz&view=dashboard&layout=import');
        }
    }
}
