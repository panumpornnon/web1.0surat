<?php

class pkg_widgetkitInstallerScript
{
    public function install($parent)
    {
    	$this->enablePlugins();
    }

    public function uninstall($parent) {}

    public function update($parent)
    {
        $this->enablePlugins();
    }

    public function preflight($type, $parent)
    {
        $dbo = JFactory::getDBO();
        $templ = $dbo->setQuery("SELECT template FROM `#__template_styles` WHERE client_id = 0 AND home = '1'")->loadResult();
        $params = $dbo->setQuery("SELECT manifest_cache FROM `#__extensions` WHERE `element` = 'com_widgetkit'")->loadResult();

        if (substr($templ, 0, 4) === 'yoo_') {
            JError::raiseWarning(null, 'This website is using a Warp 7 theme, and an update to Widgetkit 3 is not possible. Since <a href="https://yootheme.com/blog/2021/01/11/sunsetting-warp-7-themes" target="_blank">Warp 7 themes are being sunsetted</a>, it\'s strongly recommended to switch to YOOtheme Pro which will work perfectly with Widgetkit 3. Learn more about the <a href="https://yootheme.com/blog/2021/01/26/widgetkit-3.0-completely-rebuilt-with-uikit-3" target="_blank">Widgetkit 3 update</a>.');
            return false;
        }

        if ($params = @json_decode($params, true) and isset($params['version']) && version_compare($params['version'], '2.0.0', '<')) {
            JError::raiseWarning(null, 'Cannot install Widgetkit 2.0, please read the <a href="https://yootheme.com/support/widgetkit/migration" target="_blank">Widgetkit migration guide</a>');
            return false;
        }
    }

    public function postflight($type, $parent) {

        // updateservers url update workaround
        if ('update' == $type) {

            $db = JFactory::getDBO();

            if ($parent->manifest->updateservers) {

                $servers = $parent->manifest->updateservers->children();

                $db->setQuery(
                    "UPDATE `#__update_sites` a" .
                    " LEFT JOIN `#__update_sites_extensions` b ON b.update_site_id = a.update_site_id" .
                    " SET location = " . $db->quote(trim((string) $servers[0])) . ', enabled = 1' .
                    " WHERE b.extension_id = (SELECT `extension_id` FROM `#__extensions` WHERE `type` = 'package' AND `element` = 'pkg_widgetkit')"
                )->execute();

            }
        }
    }

    public function enablePlugins()
    {
        JFactory::getDBO()->setQuery("UPDATE `#__extensions` SET `enabled` = 1 WHERE `element` = 'widgetkit' AND `folder` IN ('content', 'editors-xtd', 'system')")->execute();
    }
}
