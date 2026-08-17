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

jimport('joomla.filesystem.folder');
jimport('joomla.filesystem.file');
jimport('joomla.filesystem.path');

$path = JPATH_ADMINISTRATOR . '/components/com_coalawebtraffic/assets/geoip/v2/Db';

if (!class_exists('\MaxMind\Db\Reader') && JFolder::exists($path)){
    require_once $path .  '/Reader.php';
    require_once $path .  '/Reader/Decoder.php';
    require_once $path .  '/Reader/InvalidDatabaseException.php';
    require_once $path .  '/Reader/Metadata.php';
    require_once $path .  '/Reader/Util.php';
}

use MaxMind\Db\Reader;


/**
 *  CoalaWeb Traffic component helper.
 */
class CoalawebtrafficHelperLocation
{
      /**
     * Update Visitor info V2 to include country, city, continent, longitude and latitude
     * 
     * @return void
     */
    public static function location_updatev2()
    {
        $db = JFactory::getDbo();

        $query = $db->getQuery(true);
        $query->select('id, ip');
        $query->from($db->quoteName('#__cwtraffic'));
        $query->where('country_code = "" OR country_code is null');
        $db->setQuery($query);

        try {
            // If it fails, it will throw a RuntimeException
            $result = $db->loadObjectList();
        } catch (JDatabaseExceptionExecuting $e) {
            return false;
        }

        foreach ($db->loadObjectList() as $row) {
            $geo = self::geoInfo($row->ip);

            $country_code = $geo['country_code'];
            $country_name = $geo['country_name'];
            $city = $geo['city'];

                    if ($country_code != '' && $country_name != '') {

                        $query = $db->getQuery(true);
                        $query->update('#__cwtraffic');
                        $query->set('country_code = ' . $db->quote($country_code));
                        $query->set('country_name = ' . $db->quote($country_name));
                        $query->set('city = ' . $db->quote($city));
                        $query->where('id = ' . $row->id);
                        $db->setQuery($query);
                        
                        try {
                            $db->execute();
                        } catch (Exception $exc) {
                            // Nothing
                        }
                    }
                }


                $query = $db->getQuery(true);
                $query->update('#__cwtraffic');
                $query->set('city = NULL');
                $query->where('city = ""');
                $db->setQuery($query);
                
                try {
                    $db->execute();
                } catch (JDatabaseExceptionExecuting $e) {
                    return false;
                }


        return true;
    }
    
    /**
     * Checks if GeoLiteCity.dat file exists
     *
     * @param  $geo
     * @return bool
     */
    public static function geodatExist()
    {
        self::renamedb();

        $path = JPATH_ADMINISTRATOR . '/components/com_coalawebtraffic/assets/geoip/v2';
        if (JFolder::files($path, 'GeoLite2-City.mmdb', false)) {
            return true;
        }

        return false;
    }

    /**
     * Returns modified date for file
     *
     * @param  $geo
     * @param $v
     * @return false|string $mod
     */
    public static function geodatMod()
    {
        $path = JPATH_ADMINISTRATOR . '/components/com_coalawebtraffic/assets/geoip/v2';
        $mod = date("d m Y", filemtime($path . '/GeoLite2-City.mmdb'));

        return $mod;
    }

    /**
     * Read GEO info
     *
     * @param $ip
     * @return array
     */
    public static function geoInfo($ip) {

        $mmdbLocation = JPATH_ADMINISTRATOR . '/components/com_coalawebtraffic/assets/geoip/v2/GeoLite2-City.mmdb';

        try {
            $cwreader = new Reader($mmdbLocation);
        }
        // If anything goes wrong, MaxMind will raise an exception.
        catch (\Exception $e) {
            $cwreader = null;
        }

        try {
            if (!is_null($cwreader)) {
                $lookup = $cwreader->get($ip);
            } else {
                $lookup = null;
            }
        } catch (\GeoIp2\Exception\AddressNotFoundException $e) {
            $lookup = false;
        } catch (\MaxMind\Db\Reader\InvalidDatabaseException $e) {
            $lookup = null;
        }
        // GeoIp2 could throw several different types of exceptions. Let's be sure that we're going to catch them all
        catch (Exception $e) {
            $lookup = null;
        }


        if(!is_null($lookup) || $lookup != false){
            $country_code = isset($lookup['country']['iso_code']) ? strtolower($lookup['country']['iso_code']) : NULL;
            $country_name = isset($lookup['country']['names']['en']) ? $lookup['country']['names']['en'] : NULL;
            $city = isset($lookup['city']) ? $lookup['city']['names']['en'] : NULL;
        } else {
            $country_code = NULL;
            $country_name = NULL;
            $city = NULL;
        }

        return array(
            'country_code' => $country_code,
            'country_name' => $country_name,
            'city' => $city
        );

    }

    /**
     * Function to rename old lowercase GEO DB files
     */
    private static function renamedb() {

        //Rename Pro GEO DB
        $path = JPATH_ADMINISTRATOR . '/components/com_coalawebtraffic/assets/geoip/v2';
        $old = 'geolite2-city.mmdb';
        $new = 'GeoLite2-City.mmdb';

        if (JFolder::files($path, $old, false)) {
            try {
                rename($path . '/' . $old, $path . '/' . $new);
            } catch (Exception $exc) {
                // Nothing
            }
        }
    }

}