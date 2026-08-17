<?php
/**
 * @version   $Id: item.php 10885 2013-05-30 06:31:41Z btowles $
 * @author    RocketTheme http://www.rockettheme.com
 * @copyright Copyright (C) 2007 - 2019 RocketTheme, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 */

/**
 * @var $item RokSprocket_Item
 */
?>
<li <?php if (!$parameters->get('lists_enable_accordion') || $index == 0): ?>class="active" <?php endif;?>data-lists-item data-lists-toggler>
	<?php if ($item->getPrimaryImage()) :?>
	<span class="portrait-image">
	<img src="<?php echo $item->getPrimaryImage()->getSource(); ?>" class="sprocket-lists-portrait-image" alt="<?php echo strip_tags((!$item->getPrimaryImage()->getAlttext()) ? $item->getTitle() : $item->getPrimaryImage()->getAlttext()); ?>" />
    </span>
	<?php endif; ?>
	<?php //var_dump($item); ?>

	<?php //if ($item->publish_up): ?>
		<?php //echo JHtml::_('date', $item->publish_up->getDate(), JText::_('DATE_FORMAT_LC2'); ?>
	<?php //endif; ?>
	

	<?php if ($item->custom_can_show_title): ?>
	<?php echo JHtml::_('date', $item->getDate(), JText::_('DATE_FORMAT_LC2')); 
	// echo JHtml::date($item->note_date, JText::_('DATE_FORMAT_LC2')); 
	
	//echo JHtml::_('date', $this->item->publish_up, JText::_('DATE_FORMAT_LC2'));
	//var_dump($item->getPublish_up());
	//var_dump($item->getPublished());
	//echo JHtml::_('date', $item->getPublished(), JText::_('DATE_FORMAT_LC2')); 
	
	//echo strftime("%A %d %B %Y, %H:%I" , strtotime($item->getPublished());
	
	//echo JHtml::_('date', $item->publish_up, 'd . m . Y g:ia');
	//var_dump($item);
	//echo JHtml::_('date', $item->publish_up(), JText::_('DATE_FORMAT_LC2')); 
	//echo JHtml::_('date', $this->item->publish_up, 'l, d F Y H:i');
	
	//JHtml::_('date', $item->publish_up, 'd . m . Y g:ia');
	
	//echo JHtml::_('date', $item->get_created(), JText::_('DATE_FORMAT_LC2')); 
	//echo $item->date_created;
	 //echo JHtml::_('date', $item->date_created(), JText::_('DATE_FORMAT_LC2')); //'d-m-Y H:i:s'); 
	 //print_r($item);
	  //$date = new JDate($article->created);
      //echo $date->format('j M Y');
	?>
	<h4 class="sprocket-lists-portrait-title">
		
		<?php if ($item->custom_can_have_link): ?><a href="<?php echo $item->getPrimaryLink()->getUrl(); ?>"><?php endif; ?>
			<?php echo $item->getTitle();?>
		<?php if ($item->custom_can_have_link): ?></a><?php endif; ?>
	</h4>
	<?php endif; ?>
	<div class="sprocket-lists-portrait-item" data-lists-content>
		<p class="portrait-text">
			<?php echo $item->getText(); ?>
		</p>
		<?php if ($item->getPrimaryLink()) : ?>
			<a href="<?php echo $item->getPrimaryLink()->getUrl(); ?>"><span><?php rc_e('READ_MORE'); ?></span></a>
		<?php endif; ?>
	</div>
</li>