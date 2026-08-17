<?php
/**
 * @package    DPCalendar
 * @author     Digital Peak http://www.digital-peak.com
 * @copyright  Copyright (C) 2007 - 2018 Digital Peak. All rights reserved.
 * @license    http://www.gnu.org/licenses/gpl.html GNU/GPL
 */
defined('_JEXEC') or die();

?>
<div class="com-dpcalendar-profile__footer dp-print-hide">
	<div class="dp-actions">
		<?php $link = 'index.php?option=com_dpcalendar&task=davcalendar.add&return=' . base64_encode(JUri::getInstance()) . '&c_id=0'; ?>
		<button type="button" class="dp-button dp-button-action dp-button-create" data-href="<?php echo $this->router->route($link); ?>">
			<?php echo $this->layoutHelper->renderLayout('block.icon', ['icon' => \DPCalendar\HTML\Block\Icon::PLUS]); ?>
			<?php echo $this->translate('COM_DPCALENDAR_VIEW_PROFILE_CREATE_PROFILE_CALENDAR'); ?>
		</button>
	</div>
	<div class="pagination dp-pagination ">
		<div class="dp-pagination__counter"><?php echo $this->pagination->getPagesCounter(); ?></div>
		<div class="dp-pagination__links"><?php echo $this->pagination->getPagesLinks(); ?></div>
	</div>
</div>
