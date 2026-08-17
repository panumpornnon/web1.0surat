<?php
/**
 * Item FormField
 * 
 * @version    4.1.1
 * @package AMPZ
 * copyright  2022 roosterz.nl
 * @ All rights reserved
 * @ Joomla! is Free Software
 * @ Released under GNU/GPL v3.0 License : http://www.gnu.org/licenses/gpl-3.0.html
 **/

defined('JPATH_BASE') or die;
jimport('joomla.form.formfield');
class JFormFieldItem extends JFormField {
    protected $type = 'Item';
    protected function getInput() {
        $doc = JFactory::getDocument();

        if (substr(JVERSION,0,1) == "2") // Joomla 2.5
        {
            $doc->addScript(JURI::root().$this->element['path'].'js/jquery-1.11.2.min.js');
        }

        $doc->addStyleSheet(JURI::root() . 'plugins/system/ampz/ampz/admin/css/rh_admin.css');
        $doc->addScript(JURI::root() . 'plugins/system/ampz/ampz/admin/js/admin.js');
        $doc->addStyleSheet(JURI::root() . 'plugins/system/ampz/ampz/admin/vendor/labelauty/jquery-labelauty.css');
        $doc->addScript(JURI::root() . 'plugins/system/ampz/ampz/admin/vendor/labelauty/jquery-labelauty.js');
        $doc->addScript(JURI::root() . 'plugins/system/ampz/ampz/admin/vendor/nestable/jquery.nestable.js');
        $doc->addStyleSheet(JURI::root() . 'plugins/system/ampz/ampz/admin/css/multiselect.min.css');
        $doc->addScript(JURI::root() . 'plugins/system/ampz/ampz/admin/js/multiselect.min.js');

        $doc->addScriptDeclaration('
            window.twttr = (function (d, s, id) {
              var t, js, fjs = d.getElementsByTagName(s)[0];
              if (d.getElementById(id)) return;
              js = d.createElement(s); js.id = id;
              js.src= "https://platform.twitter.com/widgets.js";
              fjs.parentNode.insertBefore(js, fjs);
              return window.twttr || (t = { _e: [], ready: function (f) { t._e.push(f) } });
            }(document, "script", "twitter-wjs"));
        ');

        return null;
    }
}
