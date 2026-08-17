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

/**
 *  CoalaWeb Traffic component helper.
 */
class CoalawebtrafficHelperDetect {

    /**
     * Get browser/platform name
     * 
     * @return string
     */
    public static function getName($id) {

        switch ($id) {
            case 1:
                $name = 'Windows';
                break;
            case 2:
                $name = 'Windows Phone';
                break;
            case 3:
                $name = 'Windows CE';
                break;
            case 4:
                $name = 'Iphone';
                break;
            case 5:
                $name = 'Ipad';
                break;
            case 6:
                $name = 'Ipod';
                break;
            case 7:
                $name = 'Mac';
                break;
            case 8:
                $name = 'Blackberry';
                break;
            case 9:
                $name = 'Android';
                break;
            case 10:
                $name = 'Linux';
                break;
            case 11:
                $name = 'Trident';
                break;
            case 12:
                $name = 'Webkit';
                break;
            case 13:
                $name = 'Gecko';
                break;
            case 14:
                $name = 'Presto';
                break;
            case 15:
                $name = 'KHTML';
                break;
            case 16:
                $name = 'Amaya';
                break;
            case 17:
                $name = 'IE';
                break;
            case 18:
                $name = 'Firefox';
                break;
            case 19:
                $name = 'Chrome';
                break;
            case 20:
                $name = 'Safari';
                break;
            case 21:
                $name = 'Opera';
                break;
            case 22:
                $name = 'Android Tablet';
                break;
            default:
                $name = 'Unknown';
        }

        return $name;
    }

}
