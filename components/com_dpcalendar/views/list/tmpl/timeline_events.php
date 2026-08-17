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
<div class="com-dpcalendar-timeline__events">
	<div class="com-dpcalendar-timeline__container">
		<?php foreach ($this->events as $event) { ?>
			<?php $startDate = $this->dateHelper->getDate($event->start_date, $event->all_day); ?>
			<?php $this->displayData['event'] = $event; ?>
			<?php $calendar = DPCalendarHelper::getCalendar($event->catid); ?>
			<div class="dp-event">
				<div class="dp-event__dot">
					<span class="dp-event__dot-date"><?php echo $startDate->format('j M', true); ?></span>
				</div>
				<div class="dp-event__information">
					<h3 class="dp-event__title" style="background-color: #<?php echo $event->color; ?>;">
						<a href="<?php echo $this->router->getEventRoute($event->id, $event->catid); ?>" class="dp-link">
							<?php echo $event->title; ?>
						</a>
					</h3>
					<?php if ($event->images->image_intro) { ?>
						<div class="dp-event__image">
							<figure class="dp-figure">
								<img class="dp-image" src="<?php echo $event->images->image_intro; ?>"
									 alt="<?php echo $event->images->image_intro_alt; ?>">
								<?php if ($event->images->image_intro_caption) { ?>
									<figcaption class="dp-figure__caption"><?php echo $event->images->image_intro_caption; ?></figcaption>
								<?php } ?>
							</figure>
						</div>
					<?php } ?>
					<div class="dp-event__details">
						<?php if ($calendar->canEdit || $calendar->canDelete || ($calendar->canEditOwn && $event->created_by == $this->user->id)) { ?>
							<span class="dp-event__actions">
								<?php if ($calendar->canEdit || ($calendar->canEditOwn && $event->created_by == $this->user->id)) { ?>
									<a href="<?php echo $this->router->getEventFormRoute($event->id, $this->return); ?>" class="dp-link">
										<?php echo $this->layoutHelper->renderLayout(
											'block.icon',
											['icon' => \DPCalendar\HTML\Block\Icon::EDIT, 'title' => $this->translate('JACTION_EDIT')]
										); ?>
									</a>
								<?php } ?>
								<?php if ($calendar->canDelete || ($calendar->canEditOwn && $event->created_by == $this->user->id)) { ?>
									<a href="<?php echo $this->router->getEventDeleteRoute($event->id, $this->return); ?>" class="dp-link">
										<?php echo $this->layoutHelper->renderLayout(
											'block.icon',
											['icon' => \DPCalendar\HTML\Block\Icon::DELETE, 'title' => $this->translate('JACTION_DELETE')]
										); ?>
									</a>
								<?php } ?>
							</span>
						<?php } ?>
						<span class="dp-event__date">
							<?php echo $this->layoutHelper->renderLayout(
								'block.icon',
								['icon' => \DPCalendar\HTML\Block\Icon::CLOCK, 'title' => $this->translate('COM_DPCALENDAR_DATE')]
							); ?>
							<?php echo $this->dateHelper->getDateStringFromEvent($event, $this->params->get('event_date_format'),
								$this->params->get('event_time_format')); ?>
						</span>
						<span class="dp-event__calendar">
							<?php echo $this->layoutHelper->renderLayout(
								'block.icon',
								['icon' => \DPCalendar\HTML\Block\Icon::CALENDAR, 'title' => $this->translate('COM_DPCALENDAR_CALENDAR')]
							); ?>
							<?php echo $calendar != null ? $calendar->title : $event->catid; ?>
						</span>
						<?php if (!empty($event->locations)) { ?>
							<span class="dp-event__locations">
								<?php echo $this->layoutHelper->renderLayout(
									'block.icon',
									['icon' => \DPCalendar\HTML\Block\Icon::LOCATION, 'title' => $this->translate('COM_DPCALENDAR_LOCATION')]
								); ?>
								<?php foreach ($event->locations as $location) { ?>
									<span class="dp-location">
										<span class="dp-location__details"
											  data-latitude="<?php echo $location->latitude; ?>"
											  data-longitude="<?php echo $location->longitude; ?>"
											  data-title="<?php echo $location->title; ?>"
											  data-color="<?php echo $event->color; ?>"></span>
										<a href="<?php echo $this->router->getLocationRoute($location); ?>" class="dp-location__url dp-link">
											<?php echo $location->title; ?>
										</a>
										<span class="dp-location__description">
											<?php echo $this->layoutHelper->renderLayout('event.tooltip', $this->displayData); ?>
										</span>
									</span>
								<?php } ?>
							</span>
						<?php } ?>
						<?php if ($event->capacity === null || $event->capacity > 0) { ?>
							<span class="dp-event__capacity">
								<?php echo $this->layoutHelper->renderLayout(
									'block.icon',
									[
										'icon'  => \DPCalendar\HTML\Block\Icon::USERS,
										'title' => $this->translate('COM_DPCALENDAR_FIELD_CAPACITY_LABEL')
									]
								); ?>
								<?php if ($event->capacity === null) { ?>
									<?php echo $this->translate('COM_DPCALENDAR_FIELD_CAPACITY_UNLIMITED'); ?>
								<?php } else { ?>
									<?php echo ($event->capacity - $event->capacity_used) . '/' . (int)$event->capacity; ?>
								<?php } ?>
							</span>
							<span class="dp-event__price">
								<?php echo $this->layoutHelper->renderLayout(
									'block.icon',
									['icon' => \DPCalendar\HTML\Block\Icon::MONEY, 'title' => $this->translate('COM_DPCALENDAR_FIELD_PRICE_LABEL')]
								); ?>
								<?php echo $this->translate($event->price ? 'COM_DPCALENDAR_VIEW_BLOG_PAID_EVENT' : 'COM_DPCALENDAR_VIEW_BLOG_FREE_EVENT'); ?>
							</span>
						<?php } ?>
						<?php if ($this->params->get('list_show_hits')) { ?>
							<span class="dp-event__hits">
								<?php echo $this->layoutHelper->renderLayout('block.icon', ['icon' => \DPCalendar\HTML\Block\Icon::BULLSEYE,]); ?>
								<?php echo $event->hits . ' ' . $this->translate('COM_DPCALENDAR_FIELD_CONFIG_EVENT_LABEL_HITS'); ?>
							</span>
						<?php } ?>
					</div>
					<?php if ($this->params->get('list_show_booking', 1) && \DPCalendar\Helper\Booking::openForBooking($event)) { ?>
						<a href="<?php echo $this->router->getBookingFormRouteFromEvent($event, $this->return); ?>"
						   class="dp-link dp-link_cta dp-button">
							<?php echo $this->layoutHelper->renderLayout(
								'block.icon',
								['icon' => \DPCalendar\HTML\Block\Icon::PLUS, 'title' => $this->translate('COM_DPCALENDAR_BOOK')]
							); ?>
							<?php echo $this->translate('COM_DPCALENDAR_VIEW_EVENT_TO_BOOK_TEXT'); ?>
						</a>
					<?php } ?>
					<div class="dp-event__description">
						<?php echo $event->truncatedDescription; ?>
					</div>
				</div>
				<?php echo $this->layoutHelper->renderLayout('schema.event', $this->displayData); ?>
			</div>
		<?php } ?>
	</div>
</div>
