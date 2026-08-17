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

?>

<form action="<?php echo JRoute::_('index.php?option=com_ampz&view=shortcodes'); ?>" method="post" name="adminForm" id="adminForm">

<div id="rh_wrapper_outer">
	<div id="rh_wrapper">
	    <header class="rh_header">
	        <nav class="rh_navbar rh_blue_navbar">
	            <div class="rh_navbar-header bg-darker">
	                <a class="rh_navbar-icon rh_text-brand">
	                    <span class="rh_icon_text"></span>
	                </a>
	            </div>
	            <a href="https://www.roosterz.nl" target="_blank" rel="noopener" id="rh_logo_full" class="rh_logo fadeInTopBig animated_slow"></a>

	        </nav>
	    </header>

		<div id="rh_wrapper_sides" class="rh_tabs">
			<aside class="rh_left-side">
				<section class="rh_sidebar">
					<ul class="rh_sidebar-menu rh_sidebar-menu-blue rh_tab-links">
						<li class=""><a href="<?php echo AmpzHelper::getAmpzPluginUrl() ?>"><i class="rh_icon-configure"></i><span>configure</span></a></li>
						<li class="active"><a href="#shortcodes"><i class="rh_icon-code"></i><span>shortcodes</span></a></li>
						<li class=""><a href="index.php?option=com_ampz&view=dashboard"><i class="rh_icon-stats"></i><span><?php echo JText::_("COM_AMPZ_STATISTICS") ?></span></a></li>
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

					<div style="display: block;" id="shortcodes" class="rh_tab active">
						<div class="rh_tab-title"><h2>AMPZ SHORTCODES<a target="_blank" rel="noopener" href="https://docs.roosterz.nl/ampz/shortcodes"><i class="rh_icon-documentation small"></i></a></h2></div>
						<div>
							<?php if (count($this->items)) { ?>
                		    <?php foreach($this->items as $i => $item): ?>
                		    	<div class="table-content shortcode"><span class="table-content-text"><a href="<?php echo JRoute::_('index.php?option=com_ampz&task=shortcode.edit&id='.$item->id); ?>" title="<?php echo JText::_('JACTION_EDIT'); ?>"><?php echo $item->name; ?></a></span><div class="delete-button"><a href="<?php echo JRoute::_('index.php?option=com_ampz&task=shortcodes.delete&id='.$item->id); ?>" title="<?php echo JText::_('JACTION_DELETE'); ?>" class="btn-bordered-icon">DELETE</a></div><div class="edit-button"><a href="<?php echo JRoute::_('index.php?option=com_ampz&task=shortcode.edit&id='.$item->id); ?>" title="<?php echo JText::_('JACTION_EDIT'); ?>" class="btn-bordered-icon">EDIT</a></div></div>
            				<?php endforeach; ?>
                			<?php } else { ?>
                				No shortcodes yet. <a href="index.php?option=com_ampz&view=shortcode&layout=edit"><?php echo JText::_("COM_AMPZ_CREATE_NEW_SHORTCODE") ?></a>
                			<?php } ?>
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
