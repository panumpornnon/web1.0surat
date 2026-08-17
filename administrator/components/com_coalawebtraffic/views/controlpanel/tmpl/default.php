<?php

/**
 * @package     Joomla
 * @subpackage  CoalaWeb Traffic
 * @author      Steven Palmer <support@coalaweb.com>
 * @link        https://coalaweb.com/
 * @license     GNU/GPL V3 or later; https://www.gnu.org/licenses/gpl-3.0.html
 * @copyright   Copyright (c) 2020 Steven Palmer, All rights reserved.
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

JHtml::_('jquery.framework');

$user = JFactory::getUser();
$lang = JFactory::getLanguage();

use CoalaWeb\Messages as CW_Messages;

$component = json_decode($this->component->manifest_cache);
?>

<div id="cpanel-v2" class="span8 well">
    <div class="row-fluid">

        <?php if (!$this->config->db_clean) : ?>
            <?php echo CwGearsHelperTools::getMessage('danger', 'COM_CWTRAFFIC_NO_CLEANUP_MSG'); ?>
        <?php endif; ?>

        <?php if (!$this->config->maxmind_license_key) : ?>
            <?php echo CwGearsHelperTools::getMessage('info', 'COM_CWTRAFFIC_MAXMIND_MSG'); ?>
        <?php endif; ?>

        <?php if (!$this->geoExist) : ?>
            <?php echo CwGearsHelperTools::getMessage('info', 'COM_CWTRAFFIC_NOGEO_CPANEL_MESSAGE'); ?>
        <?php endif; ?>

        <div style="float:<?php echo ($lang->isRTL()) ? 'right' : 'left'; ?>;">
            <div class="icon">
                <a class="green-light" href="index.php?option=com_coalawebtraffic&view=visitors">
                    <img alt="<?php echo JText::_('COM_CWTRAFFIC_TITLE_VISITORS'); ?>"
                         src="<?php echo JURI::root(true) ?>/media/coalawebtraffic/components/traffic/icons/icon-48-cw-traffic-v2.png"/>
                    <span><?php echo JText::_('COM_CWTRAFFIC_TITLE_VISITORS'); ?></span>
                </a>
            </div>
        </div>

        <div style="float:<?php echo ($lang->isRTL()) ? 'right' : 'left'; ?>;">
            <div class="icon">
                <a class="blue-dark" href="index.php?option=com_categories&extension=com_coalawebtraffic">
                    <img alt="<?php echo JText::_('COM_CWTRAFFIC_TITLE_IPCATS'); ?>"
                         src="<?php echo JURI::root() ?>media/coalaweb/components/generic/images/icons/icon-48-cw-categories-v2.png"/>
                    <span><?php echo JText::_('COM_CWTRAFFIC_TITLE_IPCATS'); ?></span>
                </a>
            </div>
        </div>

        <div style="float:<?php echo ($lang->isRTL()) ? 'right' : 'left'; ?>;">
            <div class="icon">
                <a class="orange-light" href="index.php?option=com_coalawebtraffic&view=knownips">
                    <img alt="<?php echo JText::_('COM_CWTRAFFIC_TITLE_KNOWNIPS'); ?>"
                         src="<?php echo JURI::root() ?>media/coalaweb/components/generic/images/icons/icon-48-cw-target-v2.png"/>
                    <span><?php echo JText::_('COM_CWTRAFFIC_TITLE_KNOWNIPS'); ?></span>
                </a>
            </div>
        </div>

        <div style="float:<?php echo ($lang->isRTL()) ? 'right' : 'left'; ?>;">
            <div class="icon">
                <a class="green-dark" href="index.php?option=com_coalawebtraffic&view=geoupload">
                    <img alt="<?php echo JText::_('COM_CWTRAFFIC_TITLE_GEO'); ?>"
                         src="<?php echo JURI::root() ?>media/coalaweb/components/generic/images/icons/icon-48-cw-geo-v2.png"/>
                    <span><?php echo JText::_('COM_CWTRAFFIC_TITLE_GEO'); ?></span>
                </a>
            </div>
        </div>

        <div style="float:<?php echo ($lang->isRTL()) ? 'right' : 'left'; ?>;">
            <div class="icon">
                <a class="red-light"
                   onclick="Joomla.popupWindow('https://coalaweb.com/support/documentation/item/coalaweb-traffic-guide', 'Help', 700, 500, 1)"
                   href="#">
                    <img alt="<?php echo JText::_('COM_CWTRAFFIC_TITLE_HELP'); ?>"
                         src="<?php echo JURI::root() ?>media/coalaweb/components/generic/images/icons/icon-48-cw-support-v2.png"/>
                    <span><?php echo JText::_('COM_CWTRAFFIC_TITLE_HELP'); ?></span>
                </a>
            </div>
        </div>

        <div style="float:<?php echo ($lang->isRTL()) ? 'right' : 'left'; ?>;">
            <div class="icon">
                <a class="blue-light" href="index.php?option=com_config&view=component&component=com_coalawebtraffic">
                    <img alt="<?php echo JText::_('COM_CWTRAFFIC_TITLE_OPTIONS'); ?>"
                         src="<?php echo JURI::root() ?>media/coalaweb/components/generic/images/icons/icon-48-cw-options-v2.png"/>
                    <span><?php echo JText::_('COM_CWTRAFFIC_TITLE_OPTIONS'); ?></span>
                </a>
            </div>
        </div>

        <div style="float:<?php echo ($lang->isRTL()) ? 'right' : 'left'; ?>;">
            <div class="icon">
                <a class="orange-dark" href="index.php?option=com_coalawebtraffic&view=manage">
                    <img alt="<?php echo JText::_('COM_CWTRAFFIC_TITLE_MANAGE'); ?>"
                         src="<?php echo JURI::root() ?>media/coalaweb/components/generic/images/icons/icon-48-cw-tools-v2.png"/>
                    <span><?php echo JText::_('COM_CWTRAFFIC_TITLE_MANAGE'); ?></span>
                </a>
            </div>
        </div>

        <div style="float:<?php echo ($lang->isRTL()) ? 'right' : 'left'; ?>;">
            <div class="icon">
                <a class="pink-light"
                   onclick="Joomla.popupWindow('https://coalaweb.com/extensions/joomla-extensions/coalaweb-traffic/feature-comparison', 'Help', 700, 500, 1)"
                   href="#">
                    <img alt="<?php echo JText::_('COM_CWTRAFFIC_TITLE_UPGRADE'); ?>"
                         src="<?php echo JURI::root() ?>media/coalaweb/components/generic/images/icons/icon-48-cw-upgrade-v2.png"/>
                    <span><?php echo JText::_('COM_CWTRAFFIC_TITLE_UPGRADE'); ?></span>
                </a>
            </div>
        </div>

    </div>
</div>

<div id="tabs" class="span4">
    <div class="row-fluid">

        <?php
        $options = array(
            'onActive' => 'function(title, description){
        description.setStyle("display", "block");
        title.addClass("open").removeClass("closed");
    }',
            'onBackground' => 'function(title, description){
        description.setStyle("display", "none");
        title.addClass("closed").removeClass("open");
    }',
            'startOffset' => 0, // 0 starts on the first tab, 1 starts the second, etc...
            'useCookie' => true, // this must not be a string. Don't use quotes.
            'startTransition' => 1,
        );
        ?>

        <?php echo JHtml::_('sliders.start', 'slider_group_id', $options); ?>

        <?php echo JHtml::_('sliders.panel', JText::_('COM_CWTRAFFIC_SLIDER_TITLE_ABOUT'), 'slider_1_id'); ?>

        <div class="well well-large">
            <div class="center">
                <h1><?php echo JText::_('COM_CWTRAFFIC_TITLE_CORE'); ?></h1>
            </div>

            <?php echo CW_Messages::getInstance()->getMessage('info', JText::_('COM_CWTRAFFIC_ABOUT_DESCRIPTION')); ?>

            <dl class="dl-horizontal">
                <hr class="hr-condensed">
                <dt><?php echo JText::_('COM_CWTRAFFIC_FIELD_RELEASE_CURRENT_LABEL') ?></dt>
                <dd><?php echo $component->version . ' ' . $this->proCore ?></dd>
                <hr class="hr-condensed">
                <dt><?php echo JText::_('COM_CWTRAFFIC_FIELD_RELEASE_LATEST_LABEL') ?></dt>
                <?php
                $layout = new JLayoutFile('label_unknown');
                if($this->component->new_version == '' || $this->component->new_version < $component->version){
                    $is_new = $component->version . ' ' . $this->proCore;
                } else{
                    $is_new =  '<span class="label label-danger label-important">' . $this->component->new_version . ' ' . $this->proCore . '</span>';
                }
                echo '<dd>' . $is_new  . '</dd>';
                ?>
                <hr class="hr-condensed">
                <dt><?php echo JText::_('COM_CWTRAFFIC_FIELD_RELEASE_DATE_LABEL') ?></dt>
                <dd><?php echo $component->creationDate; ?></dd>
                <hr class="hr-condensed">
                <dt>Website:</dt>
                <dd><?php echo '<a href=" ' . $component->authorUrl . '">' . parse_url($component->authorUrl, PHP_URL_HOST) . '</a>' ?></dd>
                <hr class="hr-condensed">
                <dt>License:</dt>
                <dd><?php echo $this->license; ?></dd>
                <hr class="hr-condensed">
                <dt>Copyright:</dt>
                <dd><?php echo $component->copyright; ?></dd>
                <hr class="hr-condensed">
            </dl>

        </div>

        <?php echo JHtml::_('sliders.panel', JText::_('COM_CWTRAFFIC_SLIDER_TITLE_SUPPORT'), 'slider_2_id'); ?>

        <div class="well well-large">
            <?php echo JText::_('COM_CWTRAFFIC_SUPPORT_DESCRIPTION'); ?>
        </div>

        <?php echo JHtml::_('sliders.panel', JText::_('COM_CWTRAFFIC_SLIDER_TITLE_GDPR'), 'slider_4_id'); ?>

        <div class="well well-large">
            <?php echo JText::_('COM_CWTRAFFIC_GDPR_MSG'); ?>
        </div>

        <?php echo JHtml::_('sliders.panel', JText::_('COM_CWTRAFFIC_SLIDER_TITLE_STATS'), 'slider_2_id'); ?>
        <div id="tables" class="well well-small">
            <table class="coalaweb">
                <thead>
                <tr>
                    <th width="85%">
                        <?php echo JText::_('COM_CWTRAFFIC_TITLE_VISITORS'); ?>
                    </th>
                    <th width="15%">
                        <?php echo JText::_('COM_CWTRAFFIC_HEADER_COUNT'); ?>
                    </th>
                </tr>
                </thead>

                <tr class="row0">
                    <td>
                        <?php echo JText::_('COM_CWTRAFFIC_TODAY'); ?>
                    </td>
                    <td>
                        <strong><?php echo $this->stats[1]; ?></strong>
                    </td>
                </tr>
                <tr class="row1">
                    <td>
                        <?php echo JText::_('COM_CWTRAFFIC_YESTERDAY'); ?>
                    </td>
                    <td>
                        <strong><?php echo $this->stats[2]; ?></strong>
                    </td>
                </tr>
                <tr class="row0">
                    <td>
                        <?php echo JText::_('COM_CWTRAFFIC_WEEK'); ?>
                    </td>
                    <td>
                        <strong><?php echo $this->stats[3]; ?></strong>
                    </td>
                </tr>
                <tr class="row1">
                    <td>
                        <?php echo JText::_('COM_CWTRAFFIC_MONTH'); ?>
                    </td>
                    <td>
                        <strong><?php echo $this->stats[4]; ?></strong>
                    </td>
                </tr>
                <tr class="row0">
                    <td>
                        <?php echo JText::_('COM_CWTRAFFIC_TOTAL'); ?>
                    </td>
                    <td>
                        <strong><?php echo $this->stats[0]; ?></strong>
                    </td>
                </tr>
            </table>
            <!-- Top 5 Countries -->
            <table class="coalaweb">
                <thead>
                <tr>
                    <th width="85%">
                        <?php echo JText::_('COM_CWTRAFFIC_HEADER_TOP5_COUNTRY'); ?>
                    </th>
                    <th width="15%">
                        <?php echo JText::_('COM_CWTRAFFIC_HEADER_COUNT'); ?>
                    </th>
                </tr>
                </thead>
                <?php
                $k = 0;
                for ($i = 0, $n = count($this->countries); $i < $n; $i++) {
                    $row = &$this->countries[$i];
                    ?>
                    <tr class="<?php echo "row$k"; ?>">
                        <td>
                            <?php
                            echo JHTML::_('image', 'media/coalawebtraffic/components/traffic/flags/' . $row->country_code . '.png', $row->country_code);
                            echo ' ' . $row->country_name;
                            ?>
                        </td>
                        <td align="center">
                            <strong><?php echo $row->num; ?></strong>
                        </td>
                    </tr>
                    <?php
                    $k = 1 - $k;
                }
                ?>
            </table>
            <!-- Top 5 Cities -->
            <table class="coalaweb">
                <thead>
                <tr>
                    <th width="85%">
                        <?php echo JText::_('COM_CWTRAFFIC_HEADER_TOP5_CITY'); ?>
                    </th>
                    <th width="15%">
                        <?php echo JText::_('COM_CWTRAFFIC_HEADER_COUNT'); ?>
                    </th>
                </tr>
                </thead>
                <?php
                $k = 0;
                for ($i = 0, $n = count($this->cities); $i < $n; $i++) {
                    $row = &$this->cities[$i];
                    ?>
                    <tr class="<?php echo "row$k"; ?>">
                        <td>
                            <?php
                            echo JHTML::_('image', 'media/coalawebtraffic/components/traffic/flags/' . $row->country_code . '.png', $row->country_code);
                            echo ' ' . $row->country_name . ', ';
                            echo $row->city;
                            ?>
                        </td>
                        <td>
                            <strong><?php echo $row->num; ?></strong>
                        </td>
                    </tr>
                    <?php
                    $k = 1 - $k;
                }
                ?>
            </table>
        </div>


        <?php echo JHtml::_('sliders.panel', JText::_('COM_CWTRAFFIC_SLIDER_TITLE_UPGRADE'), 'slider_4_id'); ?>
        <div class="well well-large">
            <div class="alert alert-danger">
                <span class="icon-power-cord"></span> <?php echo JText::_('COM_CWTRAFFIC_MSG_UPGRADE'); ?>
            </div>
        </div>


        <?php echo JHtml::_('sliders.end'); ?>
    </div>
</div>

