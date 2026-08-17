<?php
/**
 * @package    DPCalendar
 * @author     Digital Peak http://www.digital-peak.com
 * @copyright  Copyright (C) 2007 - 2018 Digital Peak. All rights reserved.
 * @license    http://www.gnu.org/licenses/gpl.html GNU/GPL
 */
defined('_JEXEC') or die();

if (!$googleEvent->attachments) {
	return;
}
?>
<p class="dp-google-attachments">
<p class="dp-google-attachments__title"><strong><?php echo JText::_('PLG_DPCALENDAR_GOOGLE_ATTACHMENTS'); ?></strong></p>
<?php foreach ($googleEvent->attachments as $attachment) { ?>
	<p class="dp-google-attachment">
		<img class="dp-google-attachment__image" src="<?php echo $attachment['iconLink']; ?>"/>
		<a class="dp-google-attachment__link dp-link" href="<?php echo $attachment['fileUrl']; ?>">
			<?php echo $attachment['title']; ?>
		</a>
	</p>
<?php } ?>
</p>
