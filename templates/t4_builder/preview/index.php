<?php
/**
 * @package     Joomla.Site
 * @subpackage  Templates.beez3
 *
 * @copyright   Copyright (C) 2005 - 2020 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access.
defined('_JEXEC') or die;

/** @var JDocumentHtml $this */

JLoader::import('joomla.filesystem.file');


JHtml::_('behavior.framework', true);

// Get params
$color          = $this->params->get('templatecolor');
$logo           = $this->params->get('logo');
$navposition    = $this->params->get('navposition');
$headerImage    = $this->params->get('headerImage');
$config         = JFactory::getConfig();
$bootstrap      = explode(',', $this->params->get('bootstrap'));
$option         = JFactory::getApplication()->input->getCmd('option', '');

// Output as HTML5
$this->setHtml5(true);

if (in_array($option, $bootstrap))
{
    // Load optional rtl Bootstrap css and Bootstrap bugfixes
    JHtml::_('bootstrap.loadCss', true, $this->direction);
}

// Add stylesheets
JHtml::_('stylesheet', 'templates/system/css/system.css', array('version' => 'auto'));
JHtml::_('stylesheet', 'position.css', array('version' => 'auto', 'relative' => true));
JHtml::_('stylesheet', 'layout.css', array('version' => 'auto', 'relative' => true));
JHtml::_('stylesheet', 'print.css', array('version' => 'auto', 'relative' => true), array('media' => 'print'));
JHtml::_('stylesheet', 'general.css', array('version' => 'auto', 'relative' => true));
JHtml::_('stylesheet', htmlspecialchars($color, ENT_COMPAT, 'UTF-8') . '.css', array('version' => 'auto', 'relative' => true));

if ($this->direction === 'rtl')
{
    JHtml::_('stylesheet', 'template_rtl.css', array('version' => 'auto', 'relative' => true));
    JHtml::_('stylesheet', htmlspecialchars($color, ENT_COMPAT, 'UTF-8') . '_rtl.css', array('version' => 'auto', 'relative' => true));
}

if ($color === 'image')
{
    $this->addStyleDeclaration("
    .logoheader {
        background: url('" . $this->baseurl . "/" . htmlspecialchars($headerImage) . "') no-repeat right;
    }
    body {
        background: " . $this->params->get('backgroundcolor') . ";
    }");
}

JHtml::_('stylesheet', 'ie7only.css', array('version' => 'auto', 'relative' => true, 'conditional' => 'IE 7'));

// Check for a custom CSS file
JHtml::_('stylesheet', 'user.css', array('version' => 'auto', 'relative' => true));

JHtml::_('bootstrap.framework');

// Add template scripts
JHtml::_('script', 'templates/' . $this->template . '/javascript/md_stylechanger.js', array('version' => 'auto'));
JHtml::_('script', 'templates/' . $this->template . '/javascript/hide.js', array('version' => 'auto'));
JHtml::_('script', 'templates/' . $this->template . '/javascript/respond.src.js', array('version' => 'auto'));
JHtml::_('script', 'templates/' . $this->template . '/javascript/template.js', array('version' => 'auto'));

// Check for a custom js file
JHtml::_('script', 'templates/' . $this->template . '/javascript/user.js', array('version' => 'auto'));

require __DIR__ . '/jsstrings.php';

// Add html5 shiv
JHtml::_('script', 'jui/html5.js', array('version' => 'auto', 'relative' => true, 'conditional' => 'lt IE 9'));
?>
<!DOCTYPE html>
<html lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>">
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=3.0, user-scalable=yes"/>
        <meta name="HandheldFriendly" content="true" />
        <meta name="apple-mobile-web-app-capable" content="YES" />
        <jdoc:include type="head" />
    </head>
    <body id="t4builder">
        <div id="main">

            <jdoc:include type="message" />
            <jdoc:include type="component" />

        </div><!-- end main -->
        <jdoc:include type="modules" name="debug" />
    </body>
</html>
