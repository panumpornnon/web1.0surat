<?php
/**
 * @package    DPCalendar
 * @author     Digital Peak http://www.digital-peak.com
 * @copyright  Copyright (C) 2007 - 2018 Digital Peak. All rights reserved.
 * @license    http://www.gnu.org/licenses/gpl.html GNU/GPL
 */
defined('_JEXEC') or die();

?>
<div class="com-dpcalendar-map__map dp-map"
	 data-width="<?php echo $this->params->get('map_view_width', '100%'); ?>"
	 data-height="<?php echo $this->params->get('map_view_height', '600px'); ?>"
	 data-zoom="<?php echo $this->params->get('map_view_zoom', 4); ?>"
	 data-latitude="<?php echo $this->params->get('map_view_lat', 47); ?>"
	 data-longitude="<?php echo $this->params->get('map_view_long', 4); ?>">
</div>
