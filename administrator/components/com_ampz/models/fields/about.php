<?php
/**
 * About FormField
 * @package  AMPZ
 * @copyright  2022 roosterz.nl
 * @ All rights reserved
 * @ Joomla! is Free Software
 * @ Released under GNU/GPL v3.0 License : http://www.gnu.org/licenses/gpl-3.0.html
 **/

defined('JPATH_BASE') or die;
jimport('joomla.form.formfield');
class JFormFieldAbout extends JFormField
{
    protected $type = 'About';
    protected function getInput()
    {
        return '
            <div class="tile tile-white">
                <div class="tile_image_ampz"></div>
                <div class="inner">
                    <div class="tile_title"><h2>Social Sharing Like a Boss!</h2>
                        <span class="tile_title_version">(' . JText::_("AMPZ_VERSION") . ' 4.1.1)</span>
                    </div>
                    <div class="tile_desc">
                        <p>' . JText::_("AMPZ_ABOUT_1") . '<br /><br />' . JText::_("AMPZ_ABOUT_2") . ':<br /><br />' . JText::_("AMPZ_ABOUT_3") . '<br />' . JText::_("AMPZ_ABOUT_4") . '<br />' . JText::_("AMPZ_ABOUT_5") . '<br />' . JText::_("AMPZ_ABOUT_6") . '<br />' . JText::_("AMPZ_ABOUT_7") . '<br />' . JText::_("AMPZ_ABOUT_8") . '<br /><br />' . JText::_("AMPZ_ABOUT_9") . '<br /><br />' . JText::_("AMPZ_ABOUT_11") . '<br /><br />' . JText::_("AMPZ_ABOUT_12") . '
                        </p>
                    </div>
                </div>
                <div class="tile_links">
                    <ul class="clearfix">
                        <li class="tile-link first"><a href="https://extensions.joomla.org/extensions/extension/social-web/social-share/ampz-social-sharing/" style="outline: none;"><span><i class="icon_rate"></i>' . JText::_("AMPZ_ABOUT_13") . '</span></a></li>
                        <li class="tile-link last"><a href="http://www.roosterz.nl/support/forum" style="outline: none;"><i class="icon_support"></i><span>' . JText::_("AMPZ_ABOUT_14") . '</span></a></li>
                    </ul>
                </div>
            </div>

        ';
    }
}
