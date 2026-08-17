<?php
/**
 * @package    DPCalendar
 * @author     Digital Peak http://www.digital-peak.com
 * @copyright  Copyright (C) 2007 - 2018 Digital Peak. All rights reserved.
 * @license    http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

defined('_JEXEC') or die();

$this->dpdocument->loadLibrary(\DPCalendar\HTML\Document\HtmlDocument::LIBRARY_DPCORE);
$this->dpdocument->loadLibrary(\DPCalendar\HTML\Document\HtmlDocument::LIBRARY_MAP);
$this->dpdocument->loadLibrary(\DPCalendar\HTML\Document\HtmlDocument::LIBRARY_FORM);
$this->dpdocument->loadStyleFile('dpcalendar/views/ticketform/default.css');
$this->dpdocument->loadScriptFile('dpcalendar/views/ticketform/default.js');

$tmpl   = $this->input->getCmd('tmpl') ? '&tmpl=' . $this->input->getCmd('tmpl') : '';
$action = $this->router->route('index.php?option=com_dpcalendar&view=ticketform&t_id=' . (int)$this->ticket->id . $tmpl);
?>
<div class="com-dpcalendar-ticketform">
	<form class="com-dpcalendar-ticketform__form dp-form form-validate" method="post" name="adminForm" id="adminForm" action="<?php echo $action; ?>">
		<div class="com-dpcalendar-ticketform__fields">
			<?php echo JHtml::_('bootstrap.startTabSet', 'com-dpcalendar-form-', array('active' => 'general')); ?>
			<?php foreach ($this->form->getFieldsets() as $name => $fieldSet) { ?>
				<?php echo JHtml::_('bootstrap.addTab', 'com-dpcalendar-form-', $name, $this->translate($fieldSet->label)); ?>
				<?php foreach ($this->form->getFieldset($name) as $field) { ?>
					<?php if ($field->fieldname == 'remind_type') { ?>
						<?php continue; ?>
					<?php } ?>
					<?php if ($field->fieldname == 'remind_time') { ?>
						<?php $data = [
							'label' => $this->form->getLabel('remind_time'),
							'input' => $this->form->getInput('remind_time') . $this->form->getInput('remind_type')
						]; ?>
						<?php echo $this->layoutHelper->renderLayout('joomla.form.renderfield', $data); ?>
						<?php continue; ?>
					<?php } ?>
					<?php echo $field->renderField(['class' => 'dp-field-' . str_replace('_', '-', $field->fieldname)]); ?>
				<?php } ?>
				<?php echo JHtml::_('bootstrap.endTab'); ?>
			<?php } ?>
			<?php echo JHtml::_('bootstrap.endTabSet'); ?>
		</div>
		<input type="hidden" name="task" class="dp-input dp-input-hidden">
		<?php echo JHtml::_('form.token'); ?>
	</form>
</div>
