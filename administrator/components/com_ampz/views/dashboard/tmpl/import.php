<?php

/**
 * @version    4.1.1
 * @package    AMPZ
 * @author     roosterz.nl <roy@roosterz.nl>
 * @copyright  2022 roosterz.nl
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;

?>
<form onsubmit="return submitform();" action="<?php echo JRoute::_('index.php?option=com_ampz&view=dashboard'); ?>" method="post" enctype="multipart/form-data" name="import-form" id="import-form">
	<fieldset class="form-horizontal">
		<legend><?php echo JText::_('COM_AMPZ_IMPORT_CONFIGURATION'); ?></legend>
		<div class="control-group">
			<label for="file" class="control-label"><?php echo JText::_('COM_AMPZ_CHOOSE_FILE'); ?></label>
			<div class="controls">
				<input class="input_box" id="file" name="file" type="file" size="57" />
			</div>
		</div>
		<div class="form-actions">
			<input class="btn btn-primary" type="submit" value="<?php echo JText::_('COM_AMPZ_IMPORT_CONFIGURATION'); ?>" />
		</div>
	</fieldset>

	<input type="hidden" name="task" value="dashboard.import" />
	<?php echo JHtml::_('form.token'); ?>
</form>

<script language="javascript" type="text/javascript">
	/**
	 * Submit the admin form
	 *
	 * small hack: let task decides where it comes
	 */
	function submitform() {
		var file = jQuery('#file').val();
		if (file) {
			var dot = file.lastIndexOf(".");
			if (dot != -1) {
				var ext = file.substr(dot, file.length);
				if ((ext == '.ampz')) {
					return true;
				}
			}
		}
		alert('<?php echo JText::_('COM_AMPZ_PLEASE_CHOOSE_A_VALID_FILE'); ?>');
		return false;
	}
</script>
