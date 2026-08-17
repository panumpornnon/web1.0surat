<?php
/**
 * @version    4.1.1
 * @package    AMPZ
 * @author     roosterz.nl <roy@roosterz.nl>
 * @copyright  2022 roosterz.nl
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access
defined('_JEXEC') or die;

JHtml::addIncludePath(JPATH_COMPONENT . '/helpers/html');
JHtml::_('bootstrap.tooltip');
JHtml::_('behavior.multiselect');

// Import CSS & JS
AmpzHelper::addBackendCSS();
AmpzHelper::addBackendJS();
AmpzHelper::addBackendJSDashboard();

$percentages_positions = AmpzHelper::getAmpzPositionPercentages();

$joomla_version = substr(JVERSION,0,1);
$class = "joomla" . $joomla_version;
?>

<form action="<?php echo JRoute::_('index.php?option=com_ampz&view=dashboard'); ?>" method="post" name="adminForm" id="adminForm">

<div id="rh_wrapper_outer" class="<?php echo $class; ?>">
	<div id="rh_wrapper">
	    <header class="rh_header">
	        <nav class="rh_navbar rh_blue_navbar">
	            <div class="rh_navbar-header bg-darker">
	                <a class="rh_navbar-icon rh_text-brand">
	                    <span class="rh_icon_text"></span>
	                </a>
	            </div>
	            <a href="https://www.roosterz.nl" target="_blank" rel="noopener" id="rh_logo_full" class="rh_logo fadeInTopBig animated_slow"></a>
				<!-- <div id="rh_stay_up_to_date">
					<a class="twitter-follow-button" href="https://twitter.com/roosterznl" data-show-count="true" data-lang="en">Follow @roosterznl</a>
					<iframe src="//www.facebook.com/plugins/like.php?href=https%3A%2F%2Fwww.facebook.com%2Froosterznl&amp;width&amp;layout=button_count&amp;action=like&amp;show_faces=false&amp;share=false&amp;height=21&amp;appId=289303551204896" scrolling="no" frameborder="0" style="border:none; overflow:hidden; height:21px; width: 120px; float: right; margin-top: 21px;" allowTransparency="true" class="facebook-like-button"></iframe>
				</div> -->
	        </nav>
	    </header>

		<div id="rh_wrapper_sides" class="rh_tabs">
			<aside class="rh_left-side">
				<section class="rh_sidebar">
					<ul class="rh_sidebar-menu rh_sidebar-menu-blue rh_tab-links">
						<li class=""><a href="<?php echo AmpzHelper::getAmpzPluginUrl() ?>"><i class="rh_icon-configure"></i><span>configure</span></a></li>
						<li class=""><a href="index.php?option=com_ampz&view=shortcodes"><i class="rh_icon-code"></i><span>shortcodes</span></a></li>
						<li class="active"><a href="#statistics"><i class="rh_icon-stats"></i><span><?php echo JText::_("COM_AMPZ_STATISTICS") ?></span></a></li>
						<li class=""><a target="_blank" rel="noopener" href="https://docs.roosterz.nl/ampz"><i class="rh_icon-doc"></i><span>manual</span></a></li>
						<li class=""><a target="_blank" rel="noopener" href="https://www.roosterz.nl/support/forum"><i class="rh_icon-forum"></i><span>forum</span></a></li>
						<li class=""><a target="_blank" rel="noopener" href="http://extensions.joomla.org/write-review/review/add?extension_id=7133"><i class="rh_icon-love" style="color:#FF69B4!important;"></i><span>review</span></a></li>
						<?php if (AmpzHelper::checkTAGZNotInstalled()) {
    echo '<a target="_blank" rel="noopener" href="https://www.roosterz.nl/joomla-extensions/tagz" id="rh_tagz_ad"></a>';
} ?>
					</ul>
				</section>
			</aside>
			<aside class="rh_right-side">
				<div class="rh_tab-content fadeInLeft animated">

					<div style="display: block;" id="statistics" class="rh_tab active">
						<div class="rh_tab-title"><h2>AMPZ STATISTICS<a target="_blank" rel="noopener" href="https://docs.roosterz.nl/ampz/statistics"><i class="rh_icon-documentation small"></i></a></h2></div>
						<div class="row" style="margin-left:0;">
							<div class="span5 col-lg-4" style="margin-left: 0px; padding-left: 0px;">
								<div class="bs-callout subHeader bs-callout-primary"><h4><?php echo JText::_("COM_AMPZ_ALL_TIME_CLICKS") ?></h4>
									<span class="all-time"><?php echo AmpzHelper::getTotalAmpzClicks() ?></span>
								</div>
								<div class="bs-callout subHeader bs-callout-primary"><h4><?php echo JText::_("COM_AMPZ_ALL_TIME_POSITIONS") ?></h4>
									<div class="skillbar clearfix " data-percent="<?php echo $percentages_positions["inline_top"] ?>%">
										<div class="skillbar-title" style="background: rgba(150, 150, 150, 0.5) none repeat scroll 0% 0%;;"><span>INLINE TOP</span></div>
										<div class="skillbar-bar" style="background: #00a8ff;"></div>
										<div class="skill-bar-percent"><?php echo $percentages_positions["inline_top"] ?>%</div>
									</div>
									<div class="skillbar clearfix " data-percent="<?php echo $percentages_positions["inline_bottom"] ?>%">
										<div class="skillbar-title" style="background: rgba(150, 150, 150, 0.5) none repeat scroll 0% 0%;"><span>INLINE BOTTOM</span></div>
										<div class="skillbar-bar" style="background: #00a8ff;"></div>
										<div class="skill-bar-percent"><?php echo $percentages_positions["inline_bottom"] ?>%</div>
									</div>
									<div class="skillbar clearfix " data-percent="<?php echo $percentages_positions["sidebar"] ?>%">
										<div class="skillbar-title" style="background: rgba(150, 150, 150, 0.5) none repeat scroll 0% 0%;"><span>SIDEBAR</span></div>
										<div class="skillbar-bar" style="background: #00a8ff;"></div>
										<div class="skill-bar-percent"><?php echo $percentages_positions["sidebar"] ?>%</div>
									</div>
									<div class="skillbar clearfix " data-percent="<?php echo $percentages_positions["flyin"] ?>%">
										<div class="skillbar-title" style="background: rgba(150, 150, 150, 0.5) none repeat scroll 0% 0%;"><span>FLYIN</span></div>
										<div class="skillbar-bar" style="background: #00a8ff;"></div>
										<div class="skill-bar-percent"><?php echo $percentages_positions["flyin"] ?>%</div>
									</div>
									<div class="skillbar clearfix " data-percent="<?php echo $percentages_positions["inline_mobile"] ?>%">
										<div class="skillbar-title" style="background: rgba(150, 150, 150, 0.5) none repeat scroll 0% 0%;"><span>MOBILE</span></div>
										<div class="skillbar-bar" style="background: #00a8ff;"></div>
										<div class="skill-bar-percent"><?php echo $percentages_positions["inline_mobile"] ?>%</div>
									</div>
									<div class="skillbar clearfix " data-percent="<?php echo $percentages_positions["shortcode"] ?>%">
										<div class="skillbar-title" style="background: rgba(150, 150, 150, 0.5) none repeat scroll 0% 0%;"><span>SHORTCODES</span></div>
										<div class="skillbar-bar" style="background: #00a8ff;"></div>
										<div class="skill-bar-percent"><?php echo $percentages_positions["shortcode"] ?>%</div>
									</div>
								</div>
							</div>
							<div class="span7 col-lg-8" style="padding-left: 0px;">
								<div class="bs-callout subHeader bs-callout-primary"><h4><?php echo JText::_("COM_AMPZ_ALL_TIME_NETWORKS") ?></h4>
									<?php echo AmpzHelper::getAmpzNetworkPercentages() ?>
								</div>
							</div>
						</div>
						<div>
							<div class="bs-callout subHeader bs-callout-primary"><h4><?php echo JText::_("COM_AMPZ_LAST_MONTH_CLICKS") ?></h4>
								<span class="share_count"><?php echo AmpzHelper::getAmpzLastMonthShareCount() . " " . JText::_("COM_AMPZ_SHARES") ?></span>
								<?php echo AmpzHelper::getAmpzLastMonthShareStats() ?>
								<?php echo AmpzHelper::loadCharts() ?>
							</div>
						</div>
						<div>
							<div class="bs-callout subHeader bs-callout-primary"><h4><?php echo JText::_("COM_AMPZ_TOP_CONTENT_ALL_TIME") ?></h4>
								<span class="share_count share_count_small"><?php echo AmpzHelper::getAmpzTopContentAllTime() ?></span>
							</div>
						</div>
						<div>
							<div class="bs-callout subHeader"><h4><?php echo JText::_("COM_AMPZ_RESET_STATISTICS") ?></h4>
								<?php echo JText::_('COM_AMPZ_RESET_STATISTICS_NOTE'); ?>
								<div class="" style="margin: 10px 0;"><a href="<?php echo JRoute::_('index.php?option=com_ampz&task=dashboard.reset'); ?>" title="<?php echo JText::_('JACTION_DELETE'); ?>" class="rh-button"><span class="icon-undo"> </span>	RESET STATS</a>
								</div>
                                </a>
							</div>
						</div>
						<div class="row" style="margin-left:0;">
							<div class="span6 col-lg-6" style="margin-left: 0px; padding-left: 0px;">
								<div class="bs-callout subHeader"><h4><?php echo JText::_("COM_AMPZ_EXPORT_CONFIGURATION") ?></h4>
									<?php echo JText::_('COM_AMPZ_EXPORT_CONFIGURATION_NOTE'); ?>
									<div class="" style="margin: 10px 0;"><a href="<?php echo JRoute::_('index.php?option=com_ampz&task=dashboard.export'); ?>" title="<?php echo JText::_('JACTION_DELETE'); ?>" class="rh-button"><span class="icon-download"> </span> EXPORT AMPZ CONFIG</a>
									</div>
	                                </a>
								</div>
							</div>
							<div class="span6 col-lg-6" style="margin-left: 0px; padding-left: 0px;">
								<div class="bs-callout subHeader"><h4><?php echo JText::_("COM_AMPZ_IMPORT_CONFIGURATION") ?></h4>
									<?php echo JText::_('COM_AMPZ_IMPORT_CONFIGURATION_NOTE'); ?>
									<div class="" style="margin: 10px 0;"><a href="<?php echo JRoute::_('index.php?option=com_ampz&task=dashboard.import'); ?>" title="<?php echo JText::_('JACTION_DELETE'); ?>" class="rh-button"><span class="icon-upload"> </span> IMPORT AMPZ CONFIG</a>
									</div>
	                                </a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</aside>
		</div>
	</div>
</div>
<div>
	<input type="hidden" name="task" value="" />
    <input type="hidden" name="boxchecked" value="0" />
    <?php echo JHtml::_('form.token'); ?>
</div>
</form>
