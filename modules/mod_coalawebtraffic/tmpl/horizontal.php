<?php
defined('_JEXEC') or die('Restricted access');
/**
 * @package     Joomla
 * @subpackage  CoalaWeb Traffic Module
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
?>

<div class="<?php echo $moduleclass_sfx ?>">
    <div class="cw-mod-traffic-<?php echo $cssWidth; ?>" id="cw-traffic-<?php echo $uniqueId ?>">
        <div class="cwt-hor">
            <ul class="cwt-hor-items">
                <?php $numbers = $s_today + $s_yesterday + $s_week + $s_month + $s_all - 1; ?>
                <?php if ($sDigital && $horDigital) : ?>
                    <li>
                        <div class="cwt-digi-counter">
                            <?php echo $digitalCounter; ?>
                        </div>
                    </li>
                <?php endif; ?>
                <?php if ($sHorText) : ?>
                    <li>
                        <?php echo $hor_text ?>
                    </li>
                <?php endif; ?>
                <?php if ($sDigital && !$horDigital) : ?>
                    <li>
                        <div class="cwt-digi-counter">
                            <?php echo $digitalCounter; ?>
                        </div>
                    </li>
                <?php endif; ?>
                <?php if ($s_today) : ?>
                    <li>
                        <?php echo $today . ' ' . $today_visitors ?>
                    </li>
                <?php endif; ?>
                <?php if ($numbers AND $s_today) : ?>
                    <li>
                        <?php echo $separator ?>
                        <?php $numbers-- ?>
                    </li>
                <?php endif; ?>
                <?php if ($s_yesterday) : ?>
                    <li>
                        <?php echo $yesterday . ' ' . $yesterday_visitors ?>
                    </li>
                <?php endif; ?>
                <?php if ($numbers AND $s_yesterday) : ?>
                    <li>
                        <?php echo $separator ?>
                        <?php $numbers-- ?>
                    </li>
                <?php endif; ?>
                <?php if ($s_week) : ?>
                    <li>
                        <?php echo $x_week . ' ' . $week_visitors ?>
                    </li>
                <?php endif; ?>
                <?php if ($numbers AND $s_week) : ?>
                    <li>
                        <?php echo $separator ?>
                        <?php $numbers-- ?>
                    </li>
                <?php endif; ?>
                <?php if ($s_month) : ?>
                    <li>
                        <?php echo $x_month . ' ' . $month_visitors ?>
                    </li>
                <?php endif; ?>
                <?php if ($numbers AND $s_month) : ?>
                    <li>
                        <?php echo $separator ?>
                        <?php $numbers-- ?>
                    </li>
                <?php endif; ?>	
                <?php if ($s_all) : ?>
                    <li>
                        <?php echo $all . ' ' . $all_visitors ?>
                    </li>
                <?php endif; ?>
            </ul>
            <div style='clear:both'></div>
        </div>
    </div>
</div>
