<?php defined('_JEXEC') or die;

/**
 * File       mod_jFontSize.php
 * Created    5/9/13 8:34 PM
 * Author     Matt Thomas | matt@betweenbrain.com | http://betweenbrain.com
 * Support    https://github.com/betweenbrain/
 * Copyright  Copyright (C) 2013 betweenbrain llc. All Rights Reserved.
 * License    GNU GPL v3 or later
 */

// Application object
$app = JFactory::getApplication();
// Global document object
$doc = JFactory::getDocument();
// Module Parameters
$btnMinusMaxHits = htmlspecialchars($params->get('btnMinusMaxHits'));
$btnPlusMaxHits  = htmlspecialchars($params->get('btnPlusMaxHits'));
$sizeChange      = htmlspecialchars($params->get('sizeChange'));
$targetElement   = htmlspecialchars($params->get('targetElement'));

$js = <<<JS
<script type="text/javascript">
	(function ($) {
		$().ready(function () {
			 $('{$targetElement}').jfontsize({
			     btnMinusClasseId: '#jfontsize-minus',
			     btnDefaultClasseId: '#jfontsize-default',
			     btnPlusClasseId: '#jfontsize-plus',
			     btnMinusMaxHits: {$btnMinusMaxHits},
			     btnPlusMaxHits: {$btnMinusMaxHits},
			     sizeChange: {$sizeChange}
			 });
		});
	})(jQuery)
</script>
JS;

$doc->addCustomTag($js);

/**
 * Load CSS/JS files, first checking for template override.
 *
 * JPATH_SITE: Absolute path to the installed Joomla! site Checking absolute path helps security.
 *
 * JURI::base():  Base URI of the Joomla site. If TRUE, then only the path, trailing "/" omitted, to the Joomla site is returned;
 * otherwise the scheme, host and port are prepended to the path.
 */

if (file_exists(JPATH_SITE . '/media/jfontsize/js/jquery.jfontsize-1.0.min.js')) {
	$doc->addScript(JURI::base(TRUE) . '/media/jfontsize/js/jquery.jfontsize-1.0.min.js');
}

if (file_exists(JPATH_SITE . '/templates/' . $app->getTemplate() . '/css/jfontsize.css')) {
	$doc->addStyleSheet(JURI::base(TRUE) . '/templates/' . $app->getTemplate() . '/css/jfontsize.css');
} elseif (file_exists(JPATH_SITE . '/media/jfontsize/css/jfontsize.css')) {
	$doc->addStyleSheet(JURI::base(TRUE) . '/media/jfontsize/css/jfontsize.css');
}

// Render module output
require JModuleHelper::getLayoutPath('mod_jfontsize');