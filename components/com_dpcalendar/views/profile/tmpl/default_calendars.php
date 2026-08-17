<?php
/**
 * @package    DPCalendar
 * @author     Digital Peak http://www.digital-peak.com
 * @copyright  Copyright (C) 2007 - 2018 Digital Peak. All rights reserved.
 * @license    http://www.gnu.org/licenses/gpl.html GNU/GPL
 */
defined('_JEXEC') or die();

$itemId = '&Itemid=' . $this->input->getInt('Itemid');
$return = base64_encode(JUri::getInstance());
?>
<div class="com-dpcalendar-profile__calendars">
	<ul class="dp-davcalendars dp-list">
		<?php foreach ($this->calendars as $url => $calendar) { ?>
			<li class="dp-davcalendar">
				<span class="dp-davcalendar__color" style="background-color: #<?php echo $calendar->calendarcolor; ?>"></span>
				<?php if (empty($calendar->member_principal_access)) { ?>
					<?php $link = 'index.php?option=com_dpcalendar&task=davcalendar.delete&return='
						. $return . '&c_id=' . (int)$calendar->id; ?>
					<a href="<?php echo $this->router->route($link); ?>" class="dp-link dp-davcalendar__delete">
						<?php echo $this->layoutHelper->renderLayout('block.icon', [
							'icon'  => \DPCalendar\HTML\Block\Icon::DELETE,
							'title' => $this->translate('COM_DPCALENDAR_VIEW_PROFILE_DELETE_PROFILE_CALENDAR')
						]); ?>
					</a>
					<a href="<?php echo $this->router->getEventFormRoute(0, JUri::getInstance(), 'catid=cd-' . (int)$calendar->id); ?>"
					   class="dp-link">
						<?php echo $this->layoutHelper->renderLayout('block.icon', [
							'icon'  => \DPCalendar\HTML\Block\Icon::PLUS,
							'title' => $this->translate('COM_DPCALENDAR_VIEW_PROFILE_CREATE_EVENT_IN_CALENDAR')
						]); ?>
					</a>
					<?php $link = 'index.php?option=com_dpcalendar&task=davcalendar.edit&c_id=' . (int)$calendar->id . $itemId . '&return=' . $return; ?>
					<a href="<?php echo $this->router->route($link); ?>" class="dp-link dp-davcalendar__title">
						<?php echo $calendar->displayname; ?>
					</a>
				<?php } else { ?>
					<?php $text = JText::sprintf(
						'COM_DPCALENDAR_VIEW_PROFILE_SHARED_CALENDAR',
						$calendar->member_principal_name,
						$this->translate(
							'COM_DPCALENDAR_VIEW_PROFILE_SHARED_CALENDAR_ACCESS_' . (strpos($calendar->member_principal_access,
								'/calendar-proxy-read') !== false ? 'READ' : 'WRITE'))
					); ?>
					<span class="dp-davcalendar__lock">
					<?php echo $this->layoutHelper->renderLayout('block.icon', ['icon' => \DPCalendar\HTML\Block\Icon::LOCK, 'title' => $text]); ?>
					</span>
					<span class="dp-davcalendar__name"><?php echo $calendar->displayname; ?></span>
				<?php } ?>
				<div class="dp-davcalendar__url">
					<span class="dp-text"><?php echo $this->translate('COM_DPCALENDAR_VIEW_PROFILE_TABLE_CALDAV_URL_LABEL'); ?></span>
					<a href="<?php echo JUri::base() . 'components/com_dpcalendar/caldav.php/' . $url; ?>" class="dp-link">
						<?php echo $calendar->uri; ?>
					</a>
				</div>
			</li>
		<?php } ?>
	</ul>
</div>
