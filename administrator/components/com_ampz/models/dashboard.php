<?php

/**
 * @version    4.1.1
 * @package    AMPZ
 * @author     roosterz.nl <roy@roosterz.nl>
 * @copyright  2022 roosterz.nl
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

jimport('joomla.application.component.modellist');

/**
 * Methods supporting a list of Ampz records.
 *
 * @since  1.6
 */
class AmpzModelDashboard extends JModelList
{
    /**
        * Constructor.
        *
        * @param   array  $config  An optional associative array of configuration settings.
        *
        * @see        JController
        * @since      1.6
        */
    public function __construct($config = array())
    {
        parent::__construct($config);
    }

    /**
     * Build an SQL query to load the list data.
     *
     * @return   JDatabaseQuery
     *
     * @since    1.6
     */
    protected function getListQuery()
    {
        // Create a new query object.
        $db    = $this->getDbo();
        $query = $db->getQuery(true);

        // Select the required fields from the table.
        $query->select(
            $this->getState(
                'list.select',
                'DISTINCT a.*'
            )
        );
        $query->from('`#__ampz_stats` AS a');


        // Filter by search in title
        $search = $this->getState('filter.search');

        if (!empty($search)) {
            if (stripos($search, 'id:') === 0) {
                $query->where('a.id = ' . (int) substr($search, 3));
            } else {
                $search = $db->Quote('%' . $db->escape($search, true) . '%');
            }
        }

        // Add the list ordering clause.
        $orderCol  = $this->state->get('list.ordering');
        $orderDirn = $this->state->get('list.direction');

        if ($orderCol && $orderDirn) {
            $query->order($db->escape($orderCol . ' ' . $orderDirn));
        }

        return $query;
    }

    /**
     * Get an array of data items
     *
     * @return mixed Array of data items on success, false on failure.
     */
    public function getItems()
    {
        $items = parent::getItems();

        return $items;
    }

    /**
     * Export Method
     * Export the Configuration of AMPZ
     */
    public function export()
    {
        $db    = $this->getDbo();
        $query = $db->getQuery(true)
            ->select('params')
            ->from('#__extensions')
            ->where($db->quoteName('type') . ' = ' . $db->quote('plugin'))
            ->where($db->quoteName('folder') . ' = ' . $db->quote('system'))
            ->where($db->quoteName('element') . ' = ' . $db->quote('ampz'));
        $db->setQuery($query);
        $result = $db->loadResult();

        $configuration = json_encode($result);

        $filename = 'AMPZ_Config';

        // SET DOCUMENT HEADER
        if (preg_match('#Opera(/| )([0-9].[0-9]{1,2})#', $_SERVER['HTTP_USER_AGENT'])) {
            $UserBrowser = "Opera";
        } elseif (preg_match('#MSIE ([0-9].[0-9]{1,2})#', $_SERVER['HTTP_USER_AGENT'])) {
            $UserBrowser = "IE";
        } else {
            $UserBrowser = '';
        }
        $mime_type = ($UserBrowser == 'IE' || $UserBrowser == 'Opera') ? 'application/octetstream' : 'application/octet-stream';
        @ob_end_clean();
        ob_start();

        header('Content-Type: ' . $mime_type);
        header('Expires: ' . gmdate('D, d M Y H:i:s') . ' GMT');

        if ($UserBrowser == 'IE') {
            header('Content-Disposition: inline; filename="' . $filename . '.ampz"');
            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
            header('Pragma: public');
        } else {
            header('Content-Disposition: attachment; filename="' . $filename . '.ampz"');
            header('Pragma: no-cache');
        }

        echo $configuration;
        die;
    }

    /**
     * Import Method
     * Import the selected AMPZ configuration
     * and set Redirection to the dashboard
     */
    public function import()
    {
        $app = JFactory::getApplication();
        $file = $app->input->files->get("file");

        if (!is_array($file) || !isset($file['name'])) {
            $msg = JText::_('COM_AMPZ_PLEASE_CHOOSE_A_VALID_FILE');
            JFactory::getApplication()->redirect('index.php?option=com_ampz&view=dashboard&layout=import', $msg);
        }

        $ext = explode(".", $file['name']);

        if (!in_array($ext[count($ext) - 1], array("ampz"))) {
            $msg = JText::_('COM_AMPZ_PLEASE_CHOOSE_A_VALID_FILE');
            JFactory::getApplication()->redirect('index.php?option=com_ampz&view=dashboard&layout=import', $msg);
        }

        jimport('joomla.filesystem.file');

        $data = file_get_contents($file['tmp_name']);

        if (empty($data)) {
            JFactory::getApplication()->redirect('index.php?option=com_ampz&view=dashboard', JText::_('File is empty!'));

            return;
        }

        $configuration = json_decode($data, true);

        $db    = $this->getDbo();
        $query = $db->getQuery(true)
            ->update($db->quoteName('#__extensions'))
            ->set($db->quoteName('params') . ' = ' . $db->quote($configuration))
            ->where($db->quoteName('type') . ' = ' . $db->quote('plugin'))
            ->where($db->quoteName('folder') . ' = ' . $db->quote('system'))
            ->where($db->quoteName('element') . ' = ' . $db->quote('ampz'));
        $db->setQuery($query);
        $result = $db->execute();

        $msg = JText::_('COM_AMPZ_CONFIG_IMPORTED');
        $app->enqueueMessage($msg);
        JFactory::getApplication()->redirect('index.php?option=com_ampz&view=dashboard');
    }
}
