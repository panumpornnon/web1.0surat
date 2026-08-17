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
        
?>

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

<div id="cpanel-v2" class="span8 well">
    <div class="row-fluid">
    <?php echo JHtml::_('bootstrap.startTabSet', 'myTab', array('active' => 'tools')); ?>
        
        <?php echo JHtml::_('bootstrap.addTab', 'myTab', 'tools', JText::_('COM_CWTRAFFIC_TITLE_TOOLS', true)); ?>
        
        <div style="float:<?php echo ($lang->isRTL()) ? 'right' : 'left'; ?>;">
            <div class="icon">
                <a class="red-dark purge-traffic" href="<?php echo JRoute::_('index.php?option=com_coalawebtraffic&task=manage.purge&'. JSession::getFormToken() .'=1' ); ?>">
                    <img alt="<?php echo JText::_('COM_CWTRAFFIC_TITLE_PURGE'); ?>" src="<?php echo JURI::root() ?>media/coalaweb/components/generic/images/icons/icon-48-cw-trash-v2.png" />
                    <span><?php echo JText::_('COM_CWTRAFFIC_TITLE_VISITORS'); ?></span>
                </a>
            </div>
        </div>

        <div style="float:<?php echo ($lang->isRTL()) ? 'right' : 'left'; ?>;">
            <div class="icon">
                <a class="red-dark purge-logs" href="<?php echo JRoute::_('index.php?option=com_coalawebtraffic&task=manage.purgeLogs&'. JSession::getFormToken() .'=1' ); ?>">
                    <img alt="<?php echo JText::_('COM_CWTRAFFIC_TITLE_PURGE_LOGS'); ?>" src="<?php echo JURI::root() ?>media/coalaweb/components/generic/images/icons/icon-48-cw-trash-v2.png" />
                    <span><?php echo JText::_('COM_CWTRAFFIC_TITLE_LOGS'); ?></span>
                </a>
            </div>
        </div>

        <?php echo JHtml::_('bootstrap.endTab'); ?>
        
        <?php echo JHtml::_('bootstrap.addTab', 'myTab', 'reports', JText::_('COM_CWTRAFFIC_TITLE_REPORTS', true)); ?>

        <div id="reports" class="well">
            <div class="row-fluid">

                <form name="exportcsv" action="index.php" method="post" class="form-inline">

                   <?php foreach ($this->form->getFieldset('csv_elements') as $field) : ?>
                    <div class="control-group">
                        <?php echo $field->label; ?>
                        <div class="controls">
                            <?php echo $field->input; ?>
                        </div>
                    </div>
                    <?php endforeach; ?>

                    <button type="submit" class="btn btn-info">
                        <span class="icon icon-download"></span>
                        <?php echo JText::_('COM_CWTRAFFIC_TITLE_REPORT') ?>
                    </button>
                    <input type="hidden" name="option" value="com_coalawebtraffic" />
                    <input type="hidden" name="view" value="manage" />
                    <input type="hidden" name="task" value="visitors.csvReport" />
                    <?php echo JHtml::_( 'form.token' ); ?>
                </form>
            </div>
        </div>

        <?php echo JHtml::_('bootstrap.endTab'); ?>
        
    <?php echo JHtml::_('bootstrap.endTabSet'); ?>
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

    <?php echo JHtml::_('sliders.panel', JText::_('COM_CWTRAFFIC_SLIDER_TITLE_SUPPORT'), 'slider_1_id'); ?>
    <div class="well well-large">
        <?php echo JText::_('COM_CWTRAFFIC_SUPPORT_DESCRIPTION'); ?>
    </div>
        
    <?php echo JHtml::_('sliders.panel', JText::_('COM_CWTRAFFIC_SLIDER_TITLE_UPGRADE'), 'slider_2_id'); ?>
     <div class="well well-large">
         <div class="alert alert-danger">
             <span class="icon-power-cord"></span> <?php echo JText::_('COM_CWTRAFFIC_MSG_UPGRADE'); ?>
         </div>
    </div>
        
    <?php echo JHtml::_('sliders.end'); ?>
</div>
</div>
</div>
        <script>
            jQuery.noConflict();

            jQuery('a.purge-traffic').click(function(e) {
                e.preventDefault(); // Prevent the href from redirecting directly
                var linkURL = jQuery(this).attr("href");
                warnBeforePurge(linkURL);
            });

            jQuery('a.purge-logs').click(function(e) {
                e.preventDefault(); // Prevent the href from redirecting directly
                var linkURL = jQuery(this).attr("href");
                warnBeforePurgeLogs(linkURL);
            });

            function warnBeforePurge(linkURL) {
                swal({
                    title: "<?php echo JText::_('COM_CWTRAFFIC_PURGE_POPUP_TITLE'); ?>",
                    text: "<?php echo JText::_('COM_CWTRAFFIC_PURGE_POPUP_MSG'); ?>",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                    .then((willPurge) => {
                        if(willPurge) {
                            // Redirect the user
                            window.location.href = linkURL;
                        }
                    });
            }

            function warnBeforePurgeLogs(linkURL) {
                swal({
                    title: "<?php echo JText::_('COM_CWTRAFFIC_PURGE_LOGS_POPUP_TITLE'); ?>",
                    text: "<?php echo JText::_('COM_CWTRAFFIC_PURGE_LOGS_POPUP_MSG'); ?>",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                    .then((willPurge) => {
                        if(willPurge) {
                            // Redirect the user
                            window.location.href = linkURL;
                        }
                    });
            }

        </script>