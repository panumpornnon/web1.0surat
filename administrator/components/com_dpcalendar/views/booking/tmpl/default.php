<?php
/**
 * @package    DPCalendar
 * @author     Digital Peak http://www.digital-peak.com
 * @copyright  Copyright (C) 2007 - 2018 Digital Peak. All rights reserved.
 * @license    http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

defined('_JEXEC') or die();

$this->dpdocument->loadLibrary(\DPCalendar\HTML\Document\HtmlDocument::LIBRARY_CORE);
$this->dpdocument->loadLibrary(\DPCalendar\HTML\Document\HtmlDocument::LIBRARY_DPCORE);
$this->dpdocument->loadLibrary(\DPCalendar\HTML\Document\HtmlDocument::LIBRARY_FORM);
$this->dpdocument->loadStyleFile('dpcalendar/views/bookingform/default.css');
$this->dpdocument->loadScriptFile('dpcalendar/views/bookingform/default.js');
?>
<div class="com-dpcalendar-bookingform">
	<form class="com-dpcalendar-bookingform__form dp-form form-validate" method="post" name="adminForm"
	      action="<?php echo $this->router->route('index.php?option=com_dpcalendar&view=booking&b_id=' . (int)$this->booking->id); ?>">
		<?php echo $this->layoutHelper->renderLayout('block.loader', $this->displayData); ?>
		<?php foreach ($this->form->getFieldsets() as $name => $fieldSet) { ?>
			<div class="com-dpcalendar-bookingform__fieldset dp-fieldset-<?php echo $name; ?>">
				<?php foreach ($this->form->getFieldset($name) as $field) { ?>
					<?php echo $field->renderField(['class' => 'dp-field-' . str_replace('_', '-', $field->fieldname)]); ?>
				<?php } ?>
			</div>
		<?php } ?>
		<input type="hidden" name="task" class="dp-input dp-input-hidden">
		<?php echo JHtml::_('form.token'); ?>
	</form>
</div>
