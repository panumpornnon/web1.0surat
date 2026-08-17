<?php
/**
 * @version    4.1.1
 * @package    AMPZ
 *
 * @author     roosterz.nl <roy@roosterz.nl>
 * @copyright  2022 roosterz.nl
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') || die('Restricted access');

class PlgButtonAmpz extends JPlugin
{
    /**
     *  Application Object
     *
     * @var object
     */
    protected $app;

    /**
     * Ampz Shortcode Button
     *
     * @param  string  $name The name of the shortcode to add
     * @return JObject The button object
     */
    public function onDisplay($name)
    {

        $style = '
			.ampz .icon-thumbs-up, .mce-ico.icon-thumbs-up {
			    color: #2196f3;
			}
		';

        JFactory::getDocument()->addStyleDeclaration($style);

        $basePath = $this->app->isClient('administrator') ? "" : "administrator/";
        $link     = $basePath . 'index.php?option=com_ampz&amp;view=shortcodes&amp;layout=button&amp;tmpl=component&e_name=' . $name;

        $button          = new JObject;
        $button->modal   = true;
        $button->class   = 'btn ampz';
        $button->link    = $link;
        $button->text    = 'AMPZ Shortcode';
        $button->name    = 'thumbs-up';
        $button->options = "{handler: 'iframe', size: {x: 260, y: 110}}";

        return $button;
    }
}
