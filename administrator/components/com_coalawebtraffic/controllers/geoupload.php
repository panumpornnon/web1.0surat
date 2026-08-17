<?php

/**
 * @package     Joomla
 * @subpackage  CoalaWeb Traffic
 * @author      Steven Palmer <support@coalaweb.com>
 * @link        https://coalaweb.com/
 * @license     GNU/GPL V3 or later; https://www.gnu.org/licenses/gpl-3.0.html
 * @copyright   Copyright (c) 2020 Steven Palmer All rights reserved.
 *
 * CoalaWeb Traffic is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 */

defined('_JEXEC') or die('Restricted access');

jimport('joomla.filesystem');
jimport('joomla.filesystem.file');
jimport('joomla.filesystem.folder');
jimport('joomla.filesystem.archive');

use Joomla\CMS\Factory as JFactory;
use Joomla\CMS\Http\HttpFactory as JHttpFactory;
use splitbrain\PHPArchive\Tar;

// Try to increase all relevant settings to prevent timeouts on upload/unpack
ini_set('memory_limit', '512M');
ini_set('error_reporting', 0);
ini_set('upload_max_filesize', '32M');
ini_set('post_max_size', '32M');
@set_time_limit(3600);
                
// Load version.php
$version_php = JPATH_COMPONENT_ADMINISTRATOR . '/version.php';
if (!defined('COM_CWTRAFFIC_VERSION') && JFile::exists($version_php)) {
    include_once $version_php;
}

/**
 * Geoupload controller class.
 *
 * @package    Joomla.Administrator
 * @subpackage com_coalawebtraffic
 */
class CoalawebtrafficControllerGeoupload extends JControllerLegacy
{
    
    /**
     * @var        string    The prefix to use with controller messages.
     * @since    1.6
     */
    protected $text_prefix = 'COM_CWTRAFFIC';
    private $database_name;
    private $database_file;
    private $temp_folder;
    private $package_file;
    private $license_key;

    /**
     * Constructor.
     *
     * @param array An optional associative array of configuration settings.
     * @see   JController
     */
    public function __construct() 
    {

        $this->database_name = 'GeoLite2-City';

        $this->database_file = JPATH_ADMINISTRATOR . '/components/com_coalawebtraffic/assets/geoip/v2/' . $this->database_name . '.mmdb';

        $this->temp_folder   = JFactory::getConfig()->get('tmp_path');
        $this->package_file  = $this->temp_folder . '/com_coalawebtraffic/' . $this->database_name . '.tar.gz';

        $params = JComponentHelper::getParams('com_coalawebtraffic');
        $this->license_key = $params->get('maxmind_license_key');


        parent::__construct();
    }

    /**
     * Proxy for getModel
     *
     * @param type $name
     * @param type $prefix
     *
     * @return JModel
     */
    public function getModel($name = 'Geoupload', $prefix = 'CoalawebtrafficModel', $config = array('ignore_request' => true)) {
        return parent::getModel($name, $prefix, $config);
    }

    /**
     * Upload the GeoLiteCity dat file
     * 
     * @return boolean
     */
    public function geoinstall() {
        $app = JFactory::getApplication();

        //If the file didn't get uploded correctly return an error
        if ($this->upload() === false) {
            $app->redirect('index.php?option=com_coalawebtraffic&view=geoupload', JText::_('COM_CWTRAFFIC_UPLOAD_FAILED'));
        }
        
        //If the file didn't unpack correctly delete the zipped file and return an error
        if ($this->unpack() === false) {
            JFile::delete($this->package_file);
            $app->redirect('index.php?option=com_coalawebtraffic&view=geoupload', JText::_('COM_CWTRAFFIC_UNZIP_FAILED'));
        }
        
        //All good then delete the zipped file and return successful
        JFile::delete($this->package_file);
        $app->redirect('index.php?option=com_coalawebtraffic&view=geoupload', JText::_('COM_CWTRAFFIC_INSTALL_SUCCESSFUL'));
    }

    /**
     * Remove GEO Database
     */
    function georemove() {
        // First check our token to stop any Cross Site Request Forgeries
        JSession::checkToken('request') or jexit(JText::_('JINVALID_TOKEN'));

        $msgType = '';

        if (!$this->remove()) {
            $msg = JText::_('COM_CWTRAFFIC_GEO_REMOVE_ERROR_MSG');
            $msgType = 'error';
        } else {
            $msg = JText::_('COM_CWTRAFFIC_GEO_REMOVE_SUCCESS_MSG');
        }

        $this->setRedirect('index.php?option=com_coalawebtraffic&view=geoupload', $msg, $msgType);
    }
    
    /**
     * Upload the GeoLiteCity dat file
     * 
     * @return boolean
     */
    public function geoupdate() {
        $app = JFactory::getApplication();

        //If the file didn't get uploded correctly return an error
        if ($this->upload() === false) {
            $app->redirect('index.php?option=com_coalawebtraffic&view=controlpanel', JText::_('COM_CWTRAFFIC_UPLOAD_FAILED'));
        }
        
        //If the file didn't unpack correctly return an error
        if ($this->unpack() === false) {
            JFile::delete($this->package_file);
            $app->redirect('index.php?option=com_coalawebtraffic&view=controlpanel', JText::_('COM_CWTRAFFIC_UNZIP_FAILED'));
        }
        
        JFile::delete($this->package_file);
        $app->redirect('index.php?option=com_coalawebtraffic&view=controlpanel', JText::_('COM_CWTRAFFIC_UPDATE_SUCCESSFUL'));
    }


    /*
     * Refresh GEO location data associated with visitors
     */
    public function geoRefresh() {
        // First check our token to stop any Cross Site Request Forgeries
        JSession::checkToken('get') or die('Invalid Token');

        $model = $this->getModel();
        $msgType = '';

        if (!$model->geoRefresh()) {
            $msg = JText::_('COM_CWTRAFFIC_GEO_REFRESH_ERROR_MSG');
            $msgType = 'error';
        } else {
            $msg = JText::_('COM_CWTRAFFIC_GEO_REFRESH_SUCCESS_MSG');
        }
        $this->setRedirect('index.php?option=com_coalawebtraffic&view=geoupload', $msg, $msgType);
    }

    private function upload()
    {
        $url = 'https://download.maxmind.com/app/geoip_download'
            . '?edition_id=' . $this->database_name
            . '&suffix=tar.gz'
            . '&license_key=' . $this->license_key;

        $package = JHttpFactory::getHttp()->get($url, null, 30);

        if ( ! $package || $package->code != 200 || empty($package->body))
        {
            return $this->error($package->body ?: JText::_('GEO_MESSAGE_ERROR_UPDATE'));
        }

        $last_modified = isset($package->headers['last-modified'])
            ? $package->headers['last-modified']
            : (
            isset($package->headers['Last-Modified'])
                ? $package->headers['Last-Modified']
                : date('Y-m-d')
            );

        JFile::write($this->package_file, $package->body);

        $result = $this->unpack();

        if ($result->state == 'error')
        {
            return $result;
        }

        JFile::write($this->date_file, strtotime($last_modified));

        return $this->success();
    }

    private function unpack()
    {
        try
        {
            $tar = new Tar;
            $tar->open($this->package_file);
            $files = $tar->contents();

            $database_file = '';
            foreach ($files as $file)
            {
                if (strpos($file->getPath(), '.mmdb') === false)
                {
                    continue;
                }

                $database_file = $file->getPath();
                break;
            }

            $tar = new Tar;
            $tar->open($this->package_file);
            $tar->extract($this->temp_folder);

            rename($this->temp_folder . '/' . $database_file, $this->database_file);

            JFolder::delete(dirname($this->temp_folder . '/' . $database_file));
        }
        catch (Exception $e)
        {
            return $this->error(JText::_('GEO_MESSAGE_ERROR_UNPACK'));
        }

        return $this->success();
    }

    private function success($message = '')
    {
        return (object) [
            'state'   => 'success',
            'message' => $message,
        ];
    }

    private function error($message = '')
    {
        return (object) [
            'state'   => 'error',
            'message' => $message,
        ];
    }

    /**
     * Upload the GeoLiteCity dat file
     *
     * @return boolean
     */
    private function remove()
    {
        // Files to delete
        $dbPath = JPATH_ADMINISTRATOR . '/components/com_coalawebtraffic/assets/geoip/v2/GeoLite2-City.mmdb';
        $dbPathV2 = JPATH_ADMINISTRATOR . '/components/com_coalawebtraffic/assets/geoip/GeoLiteCity.dat';


        //Check and remove Core file
        if (JFile::exists($dbPath)) {
            try {
                JFile::delete($dbPath);
            } catch (RuntimeException $e) {
                return false;
            }

        }

        //Check and remove Pro file
        if (JFile::exists($dbPathV2)) {
            try {
                JFile::delete($dbPathV2);
            } catch (RuntimeException $e) {
                return false;
            }

        }

        return true;
    }

}
