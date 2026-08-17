<?php
/**
 * @package    DPCalendar
 * @author     Digital Peak http://www.digital-peak.com
 * @copyright  Copyright (C) 2007 - 2018 Digital Peak. All rights reserved.
 * @license    http://www.gnu.org/licenses/gpl.html GNU/GPL
 */
defined('_JEXEC') or die();

$tmpl   = $this->input->getCmd('tmpl') ? '&tmpl=' . $this->input->getCmd('tmpl') : '';
$action = 'index.php?option=com_dpcalendar&view=bookings&Itemid=' . $this->input->getInt('Itemid') . $tmpl;
?>
<div class="com-dpcalendar-bookings__actions dp-button-bar dp-print-hide">
	<div class="dp-buttons">
		<button type="button" class="dp-button dp-button-print" data-selector=".com-dpcalendar-bookings">
			<?php echo $this->layoutHelper->renderLayout('block.icon', ['icon' => \DPCalendar\HTML\Block\Icon::PRINTING]); ?>
			<?php echo $this->translate('COM_DPCALENDAR_VIEW_CALENDAR_TOOLBAR_PRINT'); ?>
		</button>
	</div>
	<form class="dp-form" action="<?php echo $this->router->route($action); ?>" method="post">
		<?php echo $this->pagination->getLimitBox(); ?>
		<input type="hidden" name="limitstart" class="dp-input dp-input-hidden">
	</form>
</div>
