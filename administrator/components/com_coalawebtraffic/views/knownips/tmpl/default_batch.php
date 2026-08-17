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

$published = $this->state->get('filter.state');
?>
<div class="modal hide fade" id="collapseModal">
	<div class="modal-header">
            <button type="button" role="presentation" class="close" data-dismiss="modal">&#215;</button>
            <h3><?php echo JText::_('COM_CWTRAFFIC_BATCH_OPTIONS'); ?></h3>
	</div>
	<div class="modal-body modal-batch">
            <p><?php echo JText::_('COM_CWTRAFFIC_BATCH_TIP'); ?></p>
            <div class="row-fluid">
                <?php if ($published >= 0) : ?>
                    <div class="control-group span6">
                        <div class="controls">
                                <?php echo JHtml::_('batch.item', 'com_coalawebtraffic'); ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
	</div>
	<div class="modal-footer">
            <button class="btn" type="button" onclick="document.id('batch-category-id').value=''" data-dismiss="modal">
                <?php echo JText::_('JCANCEL'); ?>
            </button>
            <button class="btn btn-primary" type="submit" onclick="Joomla.submitbutton('knownip.batch');">
                <?php echo JText::_('JGLOBAL_BATCH_PROCESS'); ?>
            </button>
	</div>
</div>
