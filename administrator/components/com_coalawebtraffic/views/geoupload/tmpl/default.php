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

JHtml::_('jquery.framework');
JHtml::_('behavior.keepalive');
JHtml::_('behavior.formvalidator');

use CoalaWeb\Messages as CW_Messages;

$memory_limit = (int)ini_get('memory_limit');
$upload_max_filesize = (int)ini_get('upload_max_filesize');
$post_max_filesize = (int)ini_get('post_max_size');

?>

<script type="text/javascript">
    function processAction() {
        document.getElementById('cw-progress-bar').style.display = 'block';
    }
</script>
<?php if (!empty($this->sidebar)) : ?>
<!-- sidebar -->
<div id="j-sidebar-container" class="span2">
    <?php echo $this->sidebar; ?>
</div>
<!-- end sidebar -->
<div id="j-main-container" class="span10">
    <?php else : ?>
    <div id="j-main-container">
        <?php endif; ?>

        <div id="" class="span7 well">
            <div class="row-fluid">

                <?php if(!$this->config->maxmind_license_key) : ?>
                    <?php echo CwGearsHelperTools::getMessage('info', 'COM_CWTRAFFIC_MAXMIND_MSG'); ?>
                <?php endif; ?>

                <?php echo JHtml::_('bootstrap.startTabSet', 'myTab', array('active' => 'general')); ?>

                <?php echo JHtml::_('bootstrap.addTab', 'myTab', 'general', JText::_('COM_CWTRAFFIC_TITLE_GEODB_CURRENTLY', true)); ?>
                <?php echo $this->geoMessage; ?>
                <?php echo JHtml::_('bootstrap.endTab'); ?>

                <?php echo JHtml::_('bootstrap.addTab', 'myTab', 'advanced', JText::_('COM_CWTRAFFIC_TITLE_GEODB_PREREC', true)); ?>
                <table class="coalaweb">
                    <thead align="left">
                    <tr>
                        <th align="left"><?php echo JText::_('COM_CWTRAFFIC_PREREC_ITEM'); ?></th>
                        <th width="25%"><?php echo JText::_('COM_CWTRAFFIC_PREREC_MIN'); ?></th>
                        <th width="25%"><?php echo JText::_('COM_CWTRAFFIC_PREREC_CUR'); ?></th>
                    </tr>
                    </thead>

                    <tbody>
                    <tr class="row0">
                        <td><?php echo JText::_('COM_CWTRAFFIC_PREREC_ITEM_CURL'); ?></td>
                        <td><strong><?php echo JText::_('COM_CWTRAFFIC_PREREC_INSTALLED'); ?></strong></td>

                        <?php if ($this->curlInstalled()) { ?>
                            <td>
                                <strong style="color: #268413"><?php echo JText::_('COM_CWTRAFFIC_PREREC_INSTALLED'); ?></strong>
                            </td>
                        <?php } else { ?>
                            <td>
                                <strong style="color: #B1191C"><?php echo JText::_('COM_CWTRAFFIC_PREREC_NOTINSTALLED'); ?></strong>
                            </td>
                        <?php } ?>
                    </tr>

                    <tr class="row1">
                        <td><?php echo JText::_('COM_CWTRAFFIC_PREREC_ITEM_MEMLIMIT'); ?></td>
                        <td><strong><?php echo JText::_('COM_CWTRAFFIC_PREREC_MEMLIMIT_MIN'); ?></strong></td>

                        <?php if ($memory_limit >= '256') { ?>

                            <td><strong style="color: #268413"><?php echo $memory_limit . 'M'; ?></strong></td>
                        <?php } else { ?>
                            <td><strong style="color: #B1191C"><?php echo $memory_limit . 'M'; ?></strong></td>
                        <?php } ?>
                    </tr>

                    <tr class="row0">
                        <td><?php echo JText::_('COM_CWTRAFFIC_PREREC_ITEM_UPLIMIT'); ?></td>
                        <td><strong><?php echo JText::_('COM_CWTRAFFIC_PREREC_UPLIMIT_MIN'); ?></strong></td>

                        <?php if ($upload_max_filesize >= '24') { ?>

                            <td><strong style="color: #268413"><?php echo $upload_max_filesize . 'M'; ?></strong></td>
                        <?php } else { ?>
                            <td><strong style="color: #B1191C"><?php echo $upload_max_filesize . 'M'; ?></strong></td>
                        <?php } ?>
                    </tr>

                    <tr class="row0">
                        <td><?php echo JText::_('COM_CWTRAFFIC_PREREC_ITEM_POSTMAX'); ?></td>
                        <td><strong><?php echo JText::_('COM_CWTRAFFIC_PREREC_UPLIMIT_MIN'); ?></strong></td>

                        <?php if ($post_max_filesize >= '24') { ?>

                            <td><strong style="color: #268413"><?php echo $post_max_filesize . 'M'; ?></strong></td>
                        <?php } else { ?>
                            <td><strong style="color: #B1191C"><?php echo $post_max_filesize . 'M'; ?></strong></td>
                        <?php } ?>

                    </tr>

                    </tbody>
                </table>

                <?php echo CwGearsHelperTools::getMessage('info', 'COM_CWTRAFFIC_PREREC_MIN_MESSAGE'); ?>

            <?php echo JHtml::_('bootstrap.endTab'); ?>

                <?php echo JHtml::_('bootstrap.addTab', 'myTab', 'install', JText::_('COM_CWTRAFFIC_TITLE_GEODB_UPLOAD', true)); ?>
                <?php if($this->config->maxmind_license_key) : ?>
                    <form action="<?php echo JRoute::_('index.php?option=com_coalawebtraffic&view=geoupload'); ?>"
                          method="post" class="form form-validate" name="adminForm" id="adminForm"
                          enctype="multipart/form-data" onsubmit="processAction();">

                        <div id="cw-progress" class="cw-progress">

                            <?php echo CwGearsHelperTools::getMessage('info', 'COM_CWTRAFFIC_UPLOAD_MESSAGE'); ?>

                            <div id="cw-progress-bar" name="cw-progress-bar" style="display:none">
                                <?php echo JHTML::_('image', 'media/coalawebtraffic/components/traffic/progressbar/progress-bar.gif', '') ?>
                            </div>
                        </div>
                        <div class="m-b">
                            <button class="btn btn-primary btn-large btn-block margin" type="submit"
                                    onclick="Joomla.submitbutton('geoupload.geoinstall')">
                                <span class="icon-upload"></span>
                                <?php echo JText::_('COM_CWTRAFFIC_UPLOAD_BUTTON'); ?>
                            </button>

                        </div>

                        <?php echo CwGearsHelperTools::getMessage('info', 'COM_CWTRAFFIC_PREREC_ISSUES_MESSAGE'); ?>

                        <input type="hidden" name="task" value=""/>
                        <?php echo JHTML::_('form.token'); ?>
                    </form>
                <?php else : ?>
                    <?php echo CwGearsHelperTools::getMessage('danger', 'COM_CWTRAFFIC_MAXMIND_NO_KEY_MSG'); ?>
                <?php endif; ?>

                <?php echo JHtml::_('bootstrap.endTab'); ?>

                <?php if ($this->proCore == 'Pro'): ?>
                    <?php echo JHtml::_('bootstrap.addTab', 'myTab', 'refresh', JText::_('COM_CWTRAFFIC_TITLE_GEODB_REFRESH', true)); ?>

                <?php if ($this->geoExist): ?>
                    <?php echo CwGearsHelperTools::getMessage('info', 'COM_CWTRAFFIC_REFRESH_MESSAGE'); ?>

                    <a class="btn btn-success btn-large btn-block"
                       href="<?php echo JRoute::_('index.php?option=com_coalawebtraffic&task=geoupload.geoRefresh&' . JSession::getFormToken() . '=1'); ?>">
                        <span class="icon-refresh"></span>
                        <?php echo JText::_('COM_CWTRAFFIC_TITLE_GEO_REFRESH'); ?>
                    </a>
                    <?php else : ?>
                        <?php echo $this->geoMessage; ?>
                    <?php endif; ?>

                    <?php echo JHtml::_('bootstrap.endTab'); ?>
                <?php endif; ?>

                <?php echo JHtml::_('bootstrap.addTab', 'myTab', 'remove', JText::_('COM_CWTRAFFIC_TITLE_GEODB_REMOVE', true)); ?>

                <?php if ($this->geoExist): ?>
                    <?php echo CwGearsHelperTools::getMessage('info', 'COM_CWTRAFFIC_REMOVE_MESSAGE'); ?>

                    <div class="m-b">
                        <a class="btn btn-danger btn-large btn-block purge-geo"
                           href="<?php echo JRoute::_('index.php?option=com_coalawebtraffic&task=geoupload.georemove&' . JSession::getFormToken() . '=1'); ?>">
                            <span class="icon-delete"></span>
                            <?php echo JText::_('COM_CWTRAFFIC_REMOVE_BUTTON'); ?>
                        </a></div>
                <?php else : ?>
                    <?php echo $this->geoMessage; ?>
                <?php endif; ?>

                <?php echo JHtml::_('bootstrap.endTab'); ?>

                <?php echo JHtml::_('bootstrap.endTabSet'); ?>
            </div>
        </div>
        <div id="tabs" class="span5">
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

                <?php echo JHtml::_('sliders.panel', JText::_('COM_CWTRAFFIC_SLIDER_TITLE_GEOGENERAL'), 'slider_1_id'); ?>
                <div class="well well-large">
                    <?php echo JText::_('COM_CWTRAFFIC_GEODB_GENERAL'); ?>
                    <?php echo CwGearsHelperTools::getMessage('warning', 'COM_CWTRAFFIC_GEODB_WARNING'); ?>
                </div>

                <?php echo JHtml::_('sliders.panel', JText::_('COM_CWTRAFFIC_SLIDER_TITLE_GEOUPDATE'), 'slider_2_id'); ?>
                <div class="well well-large">
                    <?php echo CW_Messages::getInstance()->getMessage('info', JText::_('COM_CWTRAFFIC_MAXMIND_MSG')); ?>
                    <?php echo JText::_('COM_CWTRAFFIC_GEODB_STEPS'); ?>
                    <?php echo JText::_('COM_CWTRAFFIC_GEODB_STEPS_MANUALV2'); ?>
                </div>

                <?php echo JHtml::_('sliders.panel', JText::_('COM_CWTRAFFIC_SLIDER_TITLE_SUPPORT'), 'slider_3_id'); ?>
                <div class="well well-large">
                    <?php echo JText::_('COM_CWTRAFFIC_SUPPORT_DESCRIPTION'); ?>
                </div>

                <?php if ($this->proCore == 'Core'): ?>
                    <?php echo JHtml::_('sliders.panel', JText::_('COM_CWTRAFFIC_SLIDER_TITLE_UPGRADE'), 'slider_4_id'); ?>
                    <div class="well well-large">
                        <?php echo CwGearsHelperTools::getMessage('danger', 'COM_CWTRAFFIC_MSG_UPGRADE'); ?>
                    </div>
                <?php endif; ?>

                <?php echo JHtml::_('sliders.end'); ?>
            </div>
        </div>
    </div>
    <script>
        jQuery.noConflict();

        jQuery('a.purge-geo').click(function (e) {
            e.preventDefault(); // Prevent the href from redirecting directly
            var linkURL = jQuery(this).attr("href");
            warnBeforePurge(linkURL);
        });

        function warnBeforePurge(linkURL) {
            swal({
                title: "<?php echo JText::_('COM_CWTRAFFIC_REMOVE_GEO_POPUP_TITLE'); ?>",
                text: "<?php echo JText::_('COM_CWTRAFFIC_REMOVE_GEO_POPUP_MSG'); ?>",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
                .then((willPurge) => {
                    if (willPurge) {
                        // Redirect the user
                        window.location.href = linkURL;
                    }
                });
        }

    </script>

