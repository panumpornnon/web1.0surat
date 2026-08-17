<?php
/**
 * @version    3.6.9
 * @package    AMPZ
 * @author     roosterz.nl <roy@roosterz.nl>
 * @copyright  2022 roosterz.nl
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

/**
 * System Plugin that places an AMPZ shortcode html into the text
 */
class PlgSystemAmpzHelper
{
    public $option                   = '';
    public $params                   = null;
    public $shortcodes               = array();
    public $activeShortcodes         = array();
    public $autoWidthShortcodes      = array();
    public $autoWidthShortcodesTotal = array();
    public $allEnabledNetworks       = array();
    public $pluginInit               = false;
    public $fontStyle                = '';
    public $pluginParams             = null;
    public $languageNumber           = 0;
    public $yoothemeBuilder          = false;

    public function __construct(&$params)
    {
        $this->option = JFactory::getApplication()->input->get('option');

        $this->params                = $params;
        $this->params->comment_start = '<!-- START: AMPZ Shortcode -->';
        $this->params->comment_end   = '<!-- END: AMPZ Shortcode -->';
        $this->params->message_start = '<!--  AMPZ Message: ';
        $this->params->message_end   = ' -->';

        $this->params->tag = "ampz";

        // Tag character start and end
        $this->params->tag_character_start = '{';
        $this->params->tag_character_end   = '}';

        $this->params->regex = '/(' . $this->params->tag_character_start . $this->params->tag . '\W)(.*?)(' . $this->params->tag_character_end . ')/';

        require_once JPATH_ADMINISTRATOR . '/components/com_ampz/models/shortcodes.php';
        $shortcodes       = new AmpzModelShortcodes;
        $this->shortcodes = $shortcodes->getItems(1);
    }

    public function onAfterDispatch()
    {
        // Not in Yootheme Pro builder mode
        if (isset($_SERVER['HTTP_REFERER'])) {
            parse_str(parse_url($_SERVER['HTTP_REFERER'], PHP_URL_QUERY), $queries);
            if (isset($queries['section'])) {
                if ($queries['section'] == 'builder') {
                    $this->yoothemeBuilder = true;
                    return;
                }
            }
        }

        // only in html and feeds
        if (JFactory::getDocument()->getType() !== 'html') {
            return;
        }
        // Check the component's buffer:
        $html = JFactory::getDocument()->getBuffer('component');
        if (!empty($html) || !is_array($html)) {
            // Check if there is a tag in the component's buffer:
            (strpos($html, $this->params->tag_character_start . $this->params->tag) === false) ? $componentTagFound = false : $componentTagFound = true;
        }

        // Also check the modules content now of the modules with html content:
        $db    = JFactory::getDBO();
        $query = $db->getQuery(true);
        $query->select($db->quoteName('content'))
            ->from($db->quoteName('#__modules'))
            ->where($db->quoteName('published') . " = 1 AND " . $db->quoteName('client_id') . " = 0" . " AND " . $db->quoteName('content') . " <> ''");
        $db->setQuery($query);
        $modulesContent = implode($db->loadColumn());

        (strpos($modulesContent, $this->params->tag_character_start . $this->params->tag) === false) ? $modulesTagFound = false : $modulesTagFound = true;

        if (!$componentTagFound && !$modulesTagFound) { // No tag is found
            return;
        } elseif ($componentTagFound) {
            $this->replaceTags($html);
            JFactory::getDocument()->setBuffer($html, 'component');
        } elseif ($modulesTagFound) { // Tag found in a module. Only fill the activeShortcodes and enabledNetworks
            $this->replaceTags($modulesContent, $onlyFetchNameAndNetworks = true);
        }
    }

    public function onAfterRender()
    {
        if ((JFactory::getDocument()->getType() !== 'html') || $this->yoothemeBuilder) {
            return;
        }

        $html = JFactory::getApplication()->getBody();

        if ($html == '') {
            return;
        }

        if (strpos($html, $this->params->tag_character_start . $this->params->tag) === false) {
            return;
        }

        $this->replaceTags($html);
        JFactory::getApplication()->setBody($html);
    }

    public function replaceTags(&$string, $onlyFetchNameAndNetworks = false)
    {
        if (!is_string($string) || $string == '') {
            return;
        }

        if (strpos($string, $this->params->tag_character_start . $this->params->tag) === false) {
            return;
        }

        preg_match_all($this->params->regex, $string, $matches, PREG_SET_ORDER);

        foreach ($matches as $key => $match) {
            if (isset($matches[$key][0])) {
                $entireShortcode = "/" . $matches[$key][0] . "/"; // the entire shortcode text {ampz: TITLE}
            }
            if (isset($matches[$key][2])) {
                $shortcodeName = trim($matches[$key][2]); // the name of the shortcode
            }

            // Only change the first occurence due to unique div ids
            $string = preg_replace($entireShortcode, $this->renderShortcode($shortcodeName, $onlyFetchNameAndNetworks), $string, 1);
        }
    }

    public function getActiveShortcodes()
    {
        return array_unique($this->activeShortcodes);
    }

    public function getAllEnabledNetworks()
    {
        return array_unique($this->allEnabledNetworks);
    }

    public function setLanguageNumber($activeLanguageNumber)
    {
        $this->languageNumber = $activeLanguageNumber;
    }

    public function renderShortcode($name, $onlyFetchNameAndNetworks = false)
    {
        // is the shortcode placed by the user also defined in the backend?
        if (isset($this->shortcodes[$name])) {
            $shortcode = $this->shortcodes[$name];
        } elseif (isset($this->shortcodes[html_entity_decode($name, ENT_COMPAT, 'UTF-8')])) {
            $shortcode = $this->shortcodes[html_entity_decode($name, ENT_COMPAT, 'UTF-8')];
        } else {
            $shortcode = '';
        }

        if (!$shortcode) { // shortcode not found, let's put some comments in the HTML
                               // return $this->params->message_start . JText::_('AMPZ_SHORTCODE_NOT_DEFINED') . $this->params->message_end;
        } else {           // shortcode defined in backend, let's render it
            $shortcode_id = "inline_sc_" . $shortcode->id;
            // If there is already a shortcode that has been used once append an extra _# after the ID
            if (in_array($shortcode_id, $this->activeShortcodes)) {
                $shortcode_id = "inline_sc_" . $shortcode->id . "_" . sizeof($this->activeShortcodes);
            } else {
                $shortcode_id = "inline_sc_" . $shortcode->id;
            }

            $this->activeShortcodes[] = $shortcode_id;

            if (isset($shortcode->params->AMPZ_NETWORKS_SELECT)) {
                $enabledNetworks = $shortcode->params->AMPZ_NETWORKS_SELECT; // All networks including follow options are here
                $shortcodeNetworks = array();
                $followNetworks = array();

                foreach ($enabledNetworks as &$value) {
                    if (substr($value, 0, 4) === "btn_") {
                        $value = substr($value, 4, strpos($value, '_', 4) - strlen($value)); // only take the network name, not the preceding btn_ and   ending _#
                        $this->allEnabledNetworks[] = $value;
                        $shortcodeNetworks[] = $value;
                    } elseif (substr($value, -7) === "_follow") {
                        if (in_array(substr($value, 0, -7), $this->allEnabledNetworks)) { // Only add if the network is also in the enabled Networks since the Follow Only networks are always added
                            $followNetworks[] = substr($value, 0, -7);
                        }
                    }
                }
            } else {
                $shortcodeNetworks = [];
            }

            if ($shortcode->params->buttonWidth == "auto") {
                if (isset($shortcode->params->displayTotalShares)) {
                    $this->autoWidthShortcodesTotal[] = '#ampz_' . $shortcode_id . ' .ampz_container ul';
                } else {
                    $this->autoWidthShortcodes[] = '#ampz_' . $shortcode_id . ' .ampz_container ul';
                }
            }

            $font = $shortcode->params->fontStyle; // Get selected font
            if ($font != 'none') {
                $this->fontStyle = $this->getFontStyleAddFontCode(JFactory::getDocument(), $shortcode->params->fontStyle, "inline_sc_" . $shortcode->id);
            }

            if ($onlyFetchNameAndNetworks) {
                return;
            }

            if (!$this->pluginInit) {
                $plugin             = JPluginHelper::getPlugin('system', 'ampz');
                $this->pluginParams = new JRegistry($plugin->params);
                $this->pluginInit   = true;
            }

            $this->pluginParams->get("http_only") == 1 ? $httpOnly     = true : $httpOnly     = false;
            $this->pluginParams->get("shorten_urls") == 1 ? $shortUrls = true : $shortUrls = false;

            $totalSharesLabel = $this->pluginParams->get("label_total_shares");
            if ($this->languageNumber != 0) {
                $labelTextTotalShares = "label_total_shares_" . $this->languageNumber;
                $totalSharesLabel     = $this->pluginParams->get($labelTextTotalShares);
            }

            isset($shortcode->params->iconOnly) ? $classIconOnly                                  = ' ampz_inline_icon_only' : $classIconOnly                                  = " "; // Icon only?
            $shortcode->params->entranceEffect != "none" ? $entranceEffect                        = "animated " . $shortcode->params->entranceEffect : $entranceEffect                        = ' ';
            $shortcode->params->hoverEffect != "none" ? $hoverEffect                              = $shortcode->params->hoverEffect : $hoverEffect                              = '';
            $this->pluginParams->get("inline_disable_expand_on_hover") == 1 ? $classDisableExpand = ' ampz_inline_disable_expand' : $classDisableExpand = ""; // Disable expand for the inline position?
            isset($shortcode->params->roundedButtons) ? $roundedButtonsClass                      = 'ampz_rounded ' : $roundedButtonsClass                      = "";
            $buttonTemplate                                                                       = $shortcode->params->params_buttonTemplate;  // Get the selected design preset for the buttons
            $extraCSSClasses                                                                      = $this->getExtraCSSClasses($buttonTemplate); // add extra CSS classes if necessary
            $buttonSizeClass                                                                      = $shortcode->params->buttonSize;
            isset($shortcode->params->displayShareCounts) ? $shareCountsClass                     = '' : $shareCountsClass                     = ' ampz_no_count';
            isset($shortcode->params->displayTotalShares) ? $totalSharesDiv                       = $this->getTotalSharesDiv($shortcode->params->colorTotalShares, $totalSharesLabel, $buttonSizeClass) : $totalSharesDiv = '';

            if ($shortcode->params->buttonWidth == "auto") {
                if (isset($shortcode->params->displayTotalShares)) {
                    $shortcode->params->buttonWidth = "autototal";
                } else {
                    $shortcode->params->buttonWidth = "auto";
                }
            }

            $html = '<!-- start ampz shortcode ' . $name . ' -->';
            $html .= '<div id="ampz_' . $shortcode_id . '" style= "' . $this->fontStyle . '" class="' . $entranceEffect . $classDisableExpand . $classIconOnly . '" data-combineafter="' . $shortcode->params->combineAfterButtons . '" data-buttontemplate="' . $buttonTemplate . '" data-buttonsize="' . $buttonSizeClass . '" data-buttonwidth="' . $shortcode->params->buttonWidth . '">';

            $html .= '  <div class="' . $roundedButtonsClass . 'ampz_container' . $shareCountsClass . '">' . $totalSharesDiv .
                '<ul>';

            $this->_multiLingual = false;
            $numLanguages = intval($this->pluginParams->get("num_langs"));
            if ($numLanguages > 1) { // Multilingual website so check the active language and get right button label
                $this->_multiLingual = true;
            }

            foreach ($shortcodeNetworks as $network) {
                if (in_array($network, $followNetworks)) { // Follow button
                    // Retrieve Network Label
                    $network_label_text = "label_" . $network . "_follow";
                    if ($this->_multiLingual && $this->_activeLanguageNumber != 0) {
                        $network_label_text = "label_" . $network . "_follow_" . $this->_activeLanguageNumber;
                    }

                    $shortcode->params->displayLabels == "yes" ? $class_labels = " ampz_labels_always" : $class_labels = "";

                    $network_label = $this->pluginParams->get($network_label_text);
                    $network_follow_text = $network . "_follow";
                    $network_follow = $this->pluginParams->get($network_follow_text);

                    (strpos($network_follow, 'YOURPAGE') === false) ? $href = $network_follow : $href = '';

                    if ($href != '') {
                        $html .= '
                              <li class="'. $hoverEffect . '">
                                 <a data-sharefollow="follow" target="_blank" rel="noopener" aria-label="shortcode_'. $shortcode_id . "_" . $network .'" class="ampz_shortcode_follow '. $buttonTemplate .' ampz_btn '. $buttonSizeClass .' ampz_'. $network . ' ' . $extraCSSClasses .'" href="'. $href .'">
                                    <i class="ampz ampz-icoon ampz-icoon-'. $network .'"></i>
                              ';

                        $shortcode->params->displayLabels != "no" ? $html .= '<span class="ampz_network_label' . $class_labels . '">'. $network_label . '</span>' : '';
                        (strpos($extraCSSClasses, 'ampz_overlay') !== false) ? $html .= '<span class="ampz_icon_overlay"></span>' : '';
                        (strpos($extraCSSClasses, 'ampz_white_overlay') !== false) ? $html .= '<span class="ampz_icon_white_overlay"></span>' : '';

                        $html .= '</a>
                           ';
                    }
                } else { // Share button
                    if ($shortcode->params->displayLabels != "no") {
                        // Retrieve Network Label
                        $network_label_text = "label_" . $network;
                        if ($this->languageNumber != 0) {
                            $network_label_text = "label_" . $network . "_" . $this->languageNumber;
                        }

                        $network_label = $this->pluginParams->get($network_label_text);

                        $shortcode->params->displayLabels == "yes" ? $class_labels = " ampz_labels_always" : $class_labels = "";
                    }

                    // Get Twitter via if filled out
                    ($network == "twitter" && ($this->pluginParams->get("via_twitter") != "")) ? $data_via = 'data-via=' . $this->pluginParams->get("via_twitter") : $data_via = '';

                    // Get Flattr username if filled out
                    ($network == "flattr" && ($this->pluginParams->get("flattr_username") != "")) ? $data_flattrusername = 'data-flattrusername=' . $this->pluginParams->get("flattr_username") : $data_flattrusername = '';

                    // Get Love Title
                    ($network == "love") ? $data_lovetitle = 'data-lovetitle="' . htmlentities($this->pluginParams->get("love_title")) .'"' : $data_lovetitle = '';

                    // Get Copy Title
                    ($network == "copy") ? $data_copytitle = ' data-copytitle="' . htmlentities($this->pluginParams->get("copy_title")) . '"' : $data_copytitle = '';

                    switch ($network) {
                        case "email":
                            $href_body = $this->pluginParams->get("subject_email") . urldecode($this->getTitle()) . '&amp;body=' . urldecode($this->getUrl());
                            $href = "mailto:?subject=$href_body";
                            break;
                        case "phone":
                            $href = "tel:$this->_phoneNumber";
                            break;
                        default:
                            $href = "#";
                    }

                    $html .= '
    						<li class="'. $hoverEffect . '">
    							<a data-sharefollow="share" class="'. $buttonTemplate .' ampz_btn '. $buttonSizeClass .' ampz_'. $network . ' ' . $extraCSSClasses .'" data-url="'. $this->getUrl($debug = false, $httpOnly, $shortUrls) .'" data-basecount="0" data-shareposition="shortcode"  data-sharetype="'. $network . '" data-text="'. $this->getTitle() .'" '. $data_via . $data_flattrusername . $data_lovetitle . $data_copytitle .' href="'. $href .'">
    								<i class="ampz ampz-icoon ampz-icoon-'. $network .'"></i>
    					  ';

                    $shortcode->params->displayLabels != "no" ? $html .= '<span class="ampz_network_label' . $class_labels . '">'. $network_label . '</span>' : '';
                    isset($shortcode->params->displayShareCounts) ? $html .= '<span class="ampz_count"></span>' : '';
                    (strpos($extraCSSClasses, 'ampz_overlay') !== false) ? $html .= '<span class="ampz_icon_overlay"></span>' : '';
                    (strpos($extraCSSClasses, 'ampz_white_overlay') !== false) ? $html .= '<span class="ampz_icon_white_overlay"></span>' : '';

                    $html .=        '</a>
    					';
                }
            }

            $html .= '
	                    </ul>';

            $html .= '
					</div>
				</div>';

            $html .= '<!-- end ampz ' . $name . ' -->';

            return $html;
        }
    }

    /************************
     * getTitle: Get the title for the page to share
     *************************/
    public function getTitle()
    {
        $doc   = JFactory::getDocument();
        $title = htmlentities($doc->getTitle(), ENT_QUOTES);
        // $title = $doc->getTitle();

        return urlencode($title);
    }

    /************************
     * getUrl
     *************************/
    public function getUrl($debug = false, $httpOnly = false, $shortUrls = false)
    {
        if ($debug) {
            $url = "https://www.roosterz.nl/joomla-extensions/ampz";

            if ($shortUrls) {
                $plugin             = JPluginHelper::getPlugin('system', 'ampz');
                $this->pluginParams = new JRegistry($plugin->params);
                $accessToken        = $this->pluginParams->get('shorten_urls_api_key');

                require_once 'ampz/includes/Bitly.php'; // include Bitly library

                $bitly = new Bitly([
                    'response_type' => 'txt',
                    'access_token'  => $accessToken
                ]);

                $url = $bitly->shorten($url);
            }
            return urlencode($url);
        } else {
            $isSecure = false;

            if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') {
                $isSecure = true;
            } elseif (!empty($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https' || !empty($_SERVER['HTTP_X_FORWARDED_SSL']) && $_SERVER['HTTP_X_FORWARDED_SSL'] == 'on') {
                $isSecure = true;
            }

            $url = $isSecure ? 'https' : 'http';

            $request_url = $_SERVER["REQUEST_URI"];
            if (strpos($request_url, 'fbclid=') !== false) { // redirected from Facebook, need to trim some part of the url
                $request_url = substr($request_url, 0, strpos($request_url, 'fbclid=') - 1);
            }
            if (strpos($request_url, 'atid=') !== false) { // Affiliate buttons, need to trim some part of the url
                $request_url = substr($request_url, 0, strpos($request_url, 'atid=')-1);
            }
            if (strpos($request_url, '?utm') !== false) { // UTM redirect, need to trim some part of the url
                $request_url = substr($request_url, 0, strpos($request_url, '?utm'));
            }

            $url .= "://" . $_SERVER["SERVER_NAME"] . $request_url;

            if ($httpOnly) {
                $doc = JFactory::getDocument();
                //$doc->addCustomTag( '<meta property="og:url" content="'.$url.'" />' );
                $doc->setMetaData('og:url', $url, 'property'); // Only works in J3.6. Set the canonical Url for the http version in order to let social networks use that as a basis.
            }

            if ($shortUrls) {
                $plugin             = JPluginHelper::getPlugin('system', 'ampz');
                $this->pluginParams = new JRegistry($plugin->params);
                $accessToken        = $this->pluginParams->get('shorten_urls_api_key');

                require_once 'ampz/includes/Bitly.php'; // include Bitly library

                $bitly = new Bitly([
                    'response_type' => 'txt',
                    'access_token'  => $accessToken
                ]);

                $url = $bitly->shorten($url);
            }

            return urlencode($url);
        }
    }

    public function strposa($haystack, $needle)
    {
        if (!is_array($needle)) {
            $needle = array($needle);
        }

        foreach ($needle as $query) {
            if (strpos($haystack, rtrim($query)) !== false) {
                return true; // stop on first true result
            }
        }
        return false;
    }

    /************************
     * getExtraCSSClasses: function to get the CSS classes for the chosen button design
     *************************/
    public function getExtraCSSClasses($template)
    {
        switch ($template) {
            case "template_eindhoven":
                $extraClasses = "ampz_colorbg ampz_overlay";
                break;
            case "template_bicolor":
                $extraClasses = "ampz_colorbg ampz_white_overlay";
                break;
            case "template_amsterdam":
                $extraClasses = "ampz_colorbg";
                break;
            default:
                $extraClasses = "";
                break;
        }

        return $extraClasses;
    }

    public function getFontStyleAddFontCode($document, $font, $name = "")
    {
        if ($name === "") { // static content
            $div = ".mfp-content";
        } else { // shortcodes
            $div = "#load-btns-" . $name;
        }

        $document->addStyleSheet('//fonts.googleapis.com/css?family=' . str_replace(' ', '+', $font) . ':400,600,700');
        $this->_fontStyle = "font-family: '" . $font . "', helvetica, arial, sans-serif";
        $fontStyleModal   = $div . "{
			font-family: '" . $font . "', helvetica, arial, sans-serif;

		}";
        $document->addStyleDeclaration($fontStyleModal);

        return $this->_fontStyle;
    }

    /************************
     * getTotalSharesDiv: Get the DIV html for the total shares
     *************************/
    public function getTotalSharesDiv($color, $label, $size)
    {
        $html = '<div class="ampz_total_shares ' . $size . '" style="color: ' . $color . ';"><span class="ampz_total_shares_count">0</span><div class="ampz_total_shares_label">' . $label . '</div></div>';

        return $html;
    }
}
