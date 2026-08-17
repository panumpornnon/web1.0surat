<?php

use Joomla\CMS\Component\ComponentHelper;
use Joomla\CMS\Editor\Editor;
use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Session\Session;
use YOOtheme\Widgetkit\Application;
use YOOtheme\Framework\Joomla\Option;

global $widgetkit;

if ($widgetkit) {
    return $widgetkit;
}

$loader = require __DIR__ . '/vendor/autoload.php';
$config = require __DIR__ . '/config.php';

$app = new Application($config);
$app['autoloader']  = $loader;
$app['path.cache']  = rtrim(JPATH_SITE, '/').'/media/widgetkit';
$app['component']   = 'com_'.$app['name'];
$app['permissions'] = array('core.manage' => 'manage_widgetkit');
$app['templates']   = function () {
    $db = Factory::getDbo();
    $db->setQuery( 'SELECT id,template FROM #__template_styles WHERE client_id=0 AND home=1');
    $template = $db->loadObject()->template;

    return file_exists($path = rtrim(JPATH_ROOT, '/')."/templates/".$template."/widgetkit") ? array($path) : array();
};
$app['option'] = function ($app) {
    return new Option($app['db'], 'pkg_widgetkit');
};

$app['locator']->addPath('assets', rtrim(JPATH_ROOT, '/').'/media/com_widgetkit');

$app->on('init', function ($event, $app) {

    $controller = $app['joomla']->input->get('controller');
    $option = $app['joomla']->input->get('option');

    if ($option == 'com_config' && $controller == 'config.display.modules') {
        $app['scripts']->add('widgetkit-joomla', 'assets/js/joomla.js', array('widgetkit-application'));
    }

    $app['config']->add(ComponentHelper::getParams($app['component'])->toArray());

    $app->on('init.site', function($event, $app) {

        // check theme support for UIkit
        $template = $app['joomla']->getTemplate(true);

        $app['config']->set('theme.support', $app['config']->get('theme_support'));

        if ($template->params->get('uikit3')) {
            $app['config']->set('theme.support', 'uikit3');
            // Legacy Widgetkit 2
        } elseif (Factory::getConfig()->get('widgetkit')
            || Factory::getConfig()->get('widgetkit-noconflict')
            || file_exists(sprintf('%s/%s/warp.php', JPATH_THEMES, $template->template))
        ) {
            $app['config']->set('theme.support', 'noconflict');
        } else if (!$app['config']->get('theme.support')) {
            $app['config']->set('theme.support', 'scoped');
        }

        $app->on('view', function($event, $app) {
            if ($app['config']->get('theme.support') === 'noconflict') {
                $app['locator']->addPath('assets/lib/uikit', rtrim(JPATH_ROOT, '/')."/media/com_widgetkit/lib/wkuikit");
            }
        });

    });

    if ($app['admin'] && $app['component'] === $app['joomla']->input->get('option')) {
        $app->trigger('init.admin', array($app));
    }

});

$app->on('init.admin', function ($event, $app) {
    HTMLHelper::_('behavior.keepalive');
    HTMLHelper::_('jquery.framework');

    $app['angular']->addTemplate('media', 'views/media.php', true);
    $app['angular']->set('token', Session::getFormToken());

    $app['styles']->add('widgetkit-joomla', 'assets/css/joomla.css');
    $app['scripts']->add('widgetkit-joomla', 'assets/js/joomla.js', array('widgetkit-admin'));
    $app['scripts']->add('widgetkit-joomla-media', 'assets/js/joomla.media.js', array('widgetkit-joomla'));

    $app['config']->set('settings-page', 'index.php?option=com_config&view=component&component=com_widgetkit');

    // load JEditor
    if (in_array($editor = Factory::getConfig()->get('editor'), array('tinymce', 'jce'))) {

        $app['scripts']->add('widgetkit-joomla-tinymce', 'assets/js/joomla.tinymce.js', array('widgetkit-joomla'));

        HTMLHelper::_('behavior.modal');

        $editor = Editor::getInstance($editor);
        $editor->display('wk_dummy_editor', '', '', '', '', '', false);
    }

}, 10);

$app->boot();

return $widgetkit = $app;
