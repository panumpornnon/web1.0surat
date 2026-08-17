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
 * Knownip HTML class.
 *
 * @since  2.5
 */
abstract class JHtmlKnownip {

    /**
     * Returns a counted state on a grid
     *
     * @param   integer  $value     The state value.
     * @param   integer  $i         The row index
     * @param   boolean  $enabled   An optional setting for access control on the action.
     * @param   string   $checkbox  An optional prefix for checkboxes.
     *
     * @return  string   The Html code
     */
    public static function counted($value, $i, $enabled = true, $checkbox = 'cb') {
        $states = array(
            1 => array(
                'count_unpublish',
                'COM_CWTRAFFIC_KNOWNIPS_UNCOUNTED',
                'COM_CWTRAFFIC_KNOWNIPS_HTML_UNCOUNT_ITEM',
                'COM_CWTRAFFIC_KNOWNIPS_UNCOUNTED',
                true,
                'publish',
                'publish'
            ),
            0 => array(
                'count_publish',
                'COM_CWTRAFFIC_KNOWNIPS_COUNTED',
                'COM_CWTRAFFIC_KNOWNIPS_HTML_COUNT_ITEM',
                'COM_CWTRAFFIC_KNOWNIPS_COUNTED',
                true,
                'unpublish',
                'unpublish'
            ),
        );

        return JHtml::_('jgrid.state', $states, $value, $i, 'knownips.', $enabled, true, $checkbox);
    }

}
