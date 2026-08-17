<?php
/**
 * @package JMAP::CPANEL::administrator::components::com_jmap
 * @subpackage views
 * @subpackage cpanel
 * @subpackage tmpl
 * @author Joomla! Extensions Store
 * @copyright (C) 2021 - Joomla! Extensions Store
 * @license GNU/GPLv2 http://www.gnu.org/licenses/gpl-2.0.html
 */
defined ( '_JEXEC' ) or die ( 'Restricted access' );
?>
<!-- STATSCROP SEOSTATS -->
<div class="single_stat_container">
	<div class="statcircle">
		<span class="glyphicon glyphicon-align-left glyphicon-large"></span>
	</div>
	<ul class="subdescription_stats">
		<li data-bind="{global_rank}" class="es-stat-no"></li>
		<li class="es-stat-title"><?php echo JText::_('COM_JMAP_STATSCROP_GLOBAL_RANK');?></li>
	</ul>
</div>

<div class="single_stat_container">
	<div class="statcircle">
		<span class="glyphicon glyphicon-user glyphicon-large"></span>
	</div>
	<ul class="subdescription_stats">
		<li data-bind="{daily_visitors}" class="es-stat-no"></li>
		<li class="es-stat-title"><?php echo JText::_('COM_JMAP_STATSCROP_DAILY_VISITORS');?></li>
	</ul>
</div>

<div class="single_stat_container">
	<div class="statcircle">
		<span class="glyphicon glyphicon-book glyphicon-large"></span>
	</div>
	<ul class="subdescription_stats">
		<li data-bind="{daily_pageviews}" class="es-stat-no"></li>
		<li class="es-stat-title"><?php echo JText::_('COM_JMAP_STATSCROP_DAILY_PAGEVIEWS');?></li>
	</ul>
</div>

<div class="single_stat_container">
	<div class="statcircle">
		<span class="glyphicon glyphicon-transfer glyphicon-large"></span>
	</div>
	<ul class="subdescription_stats">
		<li data-bind="{page_load_time}" class="es-stat-no"></li>
		<li class="es-stat-title"><?php echo JText::_('COM_JMAP_STATSCROP_PAGE_LOAD_TIME');?></li>
	</ul>
</div>

<div class="single_stat_container">
	<div class="statcircle">
		<span class="glyphicon glyphicon-dashboard glyphicon-large"></span>
	</div>
	<ul class="subdescription_stats">
		<li data-bind="{seoscore}" class="es-stat-no"></li>
		<li class="es-stat-title"><?php echo JText::_('COM_JMAP_STATSCROP_SEOSCORE');?></li>
	</ul>
</div>

<div class="single_stat_container">
	<div class="statcircle">
		<span class="glyphicon glyphicon-star glyphicon-large"></span>
	</div>
	<ul class="subdescription_stats">
		<li data-bind="{rating}" class="es-stat-no"></li>
		<li data-bind="{rating_stars}" class="es-stat-no"></li>
		<li class="es-stat-title"><?php echo JText::_('COM_JMAP_STATSCROP_RATING');?></li>
	</ul>
</div>

<div class="single_stat_container">
	<div class="statcircle">
		<span class="glyphicon glyphicon-align-right glyphicon-large"></span>
	</div>
	<ul class="subdescription_stats">
		<li data-bind="{openpagerank}" class="es-stat-no"></li>
		<li class="es-stat-title"><?php echo JText::_('COM_JMAP_STATSCROP_OPENPAGERANK');?></li>
	</ul>
</div>

<div class="single_stat_rowseparator"></div>
	
<!-- Competitors and charts row -->

<div class="single_stat_container">
	<div class="statcircle">
		<span class="glyphicon glyphicon-th-list glyphicon-large"></span>
	</div>
	<ul class="subdescription_stats">
		<li data-bind="{google_indexed_links}" class="es-stat-no"></li>
		<li class="es-stat-title"><?php echo JText::_('COM_JMAP_STATSCROP_GOOGLE_INDEXED_LINKS');?></li>
	</ul>
</div>

<div class="single_stat_container">
	<div class="statcircle">
		<span class="glyphicon glyphicon-link glyphicon-large"></span>
	</div>
	<ul class="subdescription_stats">
		<li data-bind="{links_internal}" class="es-stat-no"></li>
		<li class="es-stat-title"><?php echo JText::_('COM_JMAP_STATSCROP_INTERNAL_LINKS');?></li>
	</ul>
</div>

<div class="single_stat_container">
	<div class="statcircle">
		<span class="glyphicon glyphicon-link glyphicon-large"></span>
	</div>
	<ul class="subdescription_stats">
		<li data-bind="{links_external}" class="es-stat-no"></li>
		<li class="es-stat-title"><?php echo JText::_('COM_JMAP_STATSCROP_EXTERNAL_LINKS');?></li>
	</ul>
</div>

<div class="single_stat_container">
	<div class="statcircle">
		<span class="glyphicon glyphicon-tag glyphicon-large"></span>
	</div>
	<ul class="subdescription_stats semrush_popovers">
		<li></li>
		<li data-bind="{keywords}" class="es-stat-no hasClickPopover"><?php echo JText::_('COM_JMAP_STATSCROP_KEYWORDS');?></li>
	</ul>
</div>

<div class="single_stat_container">
	<div class="statcircle">
		<span class="glyphicon glyphicon-globe glyphicon-large"></span>
	</div>
	<ul class="subdescription_stats semrush_popovers">
		<li></li>
		<li data-bind="{backlinkers}" class="es-stat-no hasClickPopover"><?php echo JText::_('COM_JMAP_STATSCROP_BACKLINKERS');?></li>
	</ul>
</div>

<div class="single_stat_container">
	<div class="statcircle">
		<span class="glyphicon glyphicon-tags glyphicon-large"></span>
	</div>
	<ul class="subdescription_stats semrush_popovers">
		<li></li>
		<li data-bind="{tags}" class="es-stat-no hasClickPopover"><?php echo JText::_('COM_JMAP_STATSCROP_TAGS');?></li>
	</ul>
</div>

<div class="single_stat_container">
	<ul class="subdescription_stats">
		<li data-bind="{google_page_rank}" class="es-stat-no fancybox-image"></li>
	</ul>
</div>

<div class="single_stat_container seostatschart">
	<canvas id="statscanvas"></canvas>
	<ul class="subdescription_stats seostatschart">
		<li class="es-stat-title"><?php echo JText::_('COM_JMAP_STATSCROP_TRAFFIC_GRAPH');?></li>
	</ul>
</div>
