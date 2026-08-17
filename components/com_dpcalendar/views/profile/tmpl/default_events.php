<?php
/**
 * @package    DPCalendar
 * @author     Digital Peak http://www.digital-peak.com
 * @copyright  Copyright (C) 2007 - 2018 Digital Peak. All rights reserved.
 * @license    http://www.gnu.org/licenses/gpl.html GNU/GPL
 */
defined('_JEXEC') or die();

$params = $this->params;
?>
<div class="com-dpcalendar-profile__events">
	<h3 class="dp-heading"><?php echo $this->translate('COM_DPCALENDAR_VIEW_PROFILE_UPCOMING_EVENTS'); ?></h3>
	<ul class="dp-events dp-list dp-list_unordered">
		<?php foreach ($this->events as $event) { ?>
			<?php $this->displayData['event'] = $event; ?>
			<?php $calendar = DPCalendarHelper::getCalendar($event->catid); ?>
			<li class="dp-list-unordered__item dp-event">
				<?php if (\DPCalendar\Helper\Booking::openForBooking($event)) { ?>
					<a href="<?php echo $this->router->getBookingFormRouteFromEvent($event, JUri::getInstance()); ?>" class="dp-link">
						<?php echo $this->layoutHelper->renderLayout(
							'block.icon',
							['icon' => \DPCalendar\HTML\Block\Icon::PLUS, 'title' => $this->translate('COM_DPCALENDAR_BOOK')]
						); ?>
					</a>
				<?php } ?>
				<?php if ($calendar->canEdit || ($calendar->canEditOwn && $event->created_by == $user->id)) { ?>
					<a href="<?php echo $this->router->getEventFormRoute($event->id, JUri::getInstance()); ?>" class="dp-link">
						<?php echo $this->layoutHelper->renderLayout(
							'block.icon',
							['icon' => \DPCalendar\HTML\Block\Icon::EDIT, 'title' => $this->translate('JACTION_EDIT')]
						); ?>
					</a>
				<?php } ?>
				<?php if ($calendar->canDelete || ($calendar->canEditOwn && $event->created_by == $user->id)) { ?>
					<a href="<?php echo $this->router->getEventDeleteRoute($event->id, JUri::getInstance()); ?>" class="dp-link">
						<?php echo $this->layoutHelper->renderLayout(
							'block.icon',
							['icon' => \DPCalendar\HTML\Block\Icon::DELETE, 'title' => $this->translate('JACTION_DELETE')]
						); ?>
					</a>
				<?php } ?>
				<a href="<?php echo $this->router->getEventRoute($event->id, $event->catid); ?>" class="dp-event__link dp-link">
					<?php echo $event->title; ?>
				</a>
				<span class="dp-event__date">
					<?php $date = $this->dateHelper->getDateStringFromEvent($event, $params->get('date_format'), $params->get('time_format')); ?>
					(<?php echo $this->translate('COM_DPCALENDAR_DATE') . ': ' . $date; ?>)
				</span>
				<span class="dp-event__calendar">
					<?php echo $this->translate('COM_DPCALENDAR_CALENDAR'); ?>:
					<?php echo $calendar != null ? $calendar->title : $event->catid; ?>
				</span>
				<?php if (!empty($event->locations)) { ?>
					<span class="dp-event__locations dp-locations">
						<?php foreach ($event->locations as $location) { ?>
							<span class="dp-event__location dp-location">
								<span class="dp-location__details"
								      data-latitude="<?php echo $location->latitude; ?>"
								      data-longitude="<?php echo $location->longitude; ?>"
								      data-title="<?php echo $location->title; ?>"
								      data-color="<?php echo $event->color; ?>"></span>
								<a href="<?php echo $this->router->getLocationRoute($location); ?>" class="dp-location__url dp-link">
									<?php echo $location->title; ?>
								</a>
							</span>
						<?php } ?>
					</span>
				<?php } ?>
			</li>
		<?php } ?>
	</ul>
</div>
