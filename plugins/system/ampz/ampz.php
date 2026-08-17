<?php
/**
 * @version             4.1.1
 * Joomla! is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * @package             AMPZ
 *
 * @copyright           Copyright (C) 2014 roosterz.nl. All rights reserved.
 * @license             GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */

// no direct access
defined('_JEXEC') || die('Restricted access');

jimport('joomla.plugin.plugin');

class plgSystemAmpz extends JPlugin
{
    public function __construct(&$subject, $config)
    {
        $this->_init   = false;
        $this->_helper = false;

        // Placement
        $this->_inline        = false;
        $this->_sidebar       = false;
        $this->_flyin         = false;
        $this->_mobile        = false;
        $this->_staticDisplay = false; // indicating whether at least one of the 'static' positions is active

        // Networks
        $this->_networks          = []; // networks for the the static positions
        $this->_allNetworks       = []; // networks for all positions (static and shortcodes)
        $this->_noEnabledNetworks = false;

        // FOLLOW ONLY NETWORKS:
        $this->_followOnly = ["instagram", "youtube", "spotify", "soundcloud", "phone", "tiktok"];

        //Counts
        $this->_inlineShareCounts  = true;
        $this->_sidebarShareCounts = true;
        $this->_flyinShareCounts   = true;
        $this->_mobileShareCounts  = true;

        // Threshold for total shares display
        $this->_thresholdTotalShares = 0;

        // Entrance Effect for the flyin location
        $this->_flyinEntranceEffect = "";

        // Button Size
        $this->_buttonSizeClass = "";

        // Rounded Buttons
        $this->_roundedButtons      = false;
        $this->_roundedButtonsClass = "";

        $this->_currentComponent = "";

        $this->_rtlClass = "";

        $this->_continue       = 0;
        $this->_frontpage      = 0;
        $this->_title          = "";
        $this->_emailSubject   = "";
        $this->_url            = "";
        $this->_baseUrl        = "";
        $this->_buttonFontSize = 0;
        $this->_extra_classes  = "ampz_colorbg";
        $this->_buttonTemplate = "template_amsterdam";
        $this->_fontStyle      = "";

        // Open in New Tab or Popup (default)
        $this->_openInNewTab = false;

        // Cookie variable for the Fly In position
        $this->_flyInDisabledByCookie = false;

        // Sidebar visibility
        $this->_visibilitySideBar = "inline";
        $this->_visibilityMobile  = "inline";

        $this->_sidebarStartClosed = false;

        // Used for testing purposes
        //		$this->_live = true;

        // Support Author
        $this->_disableSupportAuthor = false;

        // Language
        $this->_multiLingual         = false;
        $this->_activeLanguageNumber = 0;
        $this->_totalSharesLabel     = "Shares";

        // cookies
        $this->_cookieType     = "minutes";
        $this->_cookieDuration = "5";

        $this->_activeShortcodes = [];

        parent::__construct($subject, $config);
        $this->loadLanguage();
    }

    /************************
     * onAfterRoute
     *************************/
    public function onAfterRoute()
    {
        $this->getHelper();
    }

    /************************
     * onAfterDispatch: needed for the inline display
     *************************/
    public function onAfterDispatch()
    {
        $this->_currentComponent = JFactory::getApplication()->input->get("option");
        $excludeCatView          = $this->params->get("exclude_category_view");
        $this->_mobile           = $this->params->get("mobileEnable"); // Mobile Mode activated?

        // Trigger the shortcode search and replace for the shortcodes in the component's buffer or modules
        if ($this->_helper !== false) {
            $this->_helper->onAfterDispatch();
        }

        if ($this->continueOrNot($excludeCatView)) {
            $this->_continue = 1;
            if ($this->_inline || $this->_sidebar || $this->_flyin || $this->_mobile) {
                $this->_staticDisplay = true;
            }
        }

        if (!$this->_continue) {
            // stop!
            return;
        }

        // Add CSS
        $document = JFactory::getDocument();
        if (isset($this->_live)) {
            $document->addStyleSheet(JURI::root(true) . '/plugins/system/ampz/ampz/css/ampz.min.css');
        } else {
            $document->addStyleSheet(JURI::root(true) . '/plugins/system/ampz/ampz/css/ampz.css');
        }

        $mobileWidth           = $this->params->get("mobile_width");     // Activate Mobile Mode if browser is less than
        $mobileBackgroundColor = $this->params->get("mobile_color_div"); // Get the selected mobile background color

        $mobileDisplayCSS = '
        #ampz_inline_mobile { background-color: ' . $mobileBackgroundColor . ' }
        @media (min-width: ' . $mobileWidth . 'px) {
            #ampz_inline_mobile {
                display: none !important;
            }
        }
        @media (max-width: ' . $mobileWidth . 'px) {
            #ampz_inline_mobile {
                display: block !important;
            }
        }';
        $document->addStyleDeclaration($mobileDisplayCSS);

        $this->_buttonTemplate = $this->params->get("buttonTemplate");                       // Get the selected design preset for the buttons
        $this->_extra_classes  = $this->_helper->getExtraCSSClasses($this->_buttonTemplate); // add extra CSS classes if necessary

                                                 // Include Google Font
        $font = $this->params->get("fontStyle"); // Get selected font
        if ($font != 'none') {
            $this->_fontStyle = $this->_helper->getFontStyleAddFontCode($document, $font);
        }

        // Multilingual?
        $numLanguages  = intval($this->params->get("num_langs"));
        $activeLangTag = JFactory::getLanguage()->getTag();

        if ($numLanguages == 1 || $activeLangTag == JComponentHelper::getParams('com_languages')->get('site')) {
            $this->_totalSharesLabel = $this->params->get("label_total_shares");
        } elseif ($numLanguages > 1) {
            // Multilingual website so check the active language and get right button label
            $this->_multiLingual = true;

            if ($activeLangTag != JComponentHelper::getParams('com_languages')->get('site')) {
                for ($i = 2; $i <= $numLanguages; $i++) {
                    $var = "extra_lang_" . $i;
                    if ($this->params->get($var) == $activeLangTag) {
                        $this->_activeLanguageNumber = $i;
                        $labelTextTotalShares        = "label_total_shares_" . $this->_activeLanguageNumber;
                        $this->_totalSharesLabel     = $this->params->get($labelTextTotalShares);
                        $this->_helper->setLanguageNumber($this->_activeLanguageNumber);
                    }
                }
            }
        }

        $this->_buttonFontSize = $this->params->get("buttonSize"); // Get selected button size

        $this->_inlineShareCounts                                           = $this->params->get("inline_share_counts"); // Show inline share counts or not
        $this->_inlineShareCounts != "1" ? $this->_inlineShareCountsClass   = ' ampz_no_count' : $this->_inlineShareCountsClass   = '';
        $this->_flyinShareCounts                                            = $this->params->get("flyin_share_counts"); // Show flyin share counts or not
        $this->_flyinShareCounts != "1" ? $this->_flyinShareCountsClass     = ' ampz_no_count' : $this->_flyinShareCountsClass     = '';
        $this->_sidebarShareCounts                                          = $this->params->get("sidebar_share_counts"); // Show sidebar share counts or not
        $this->_sidebarShareCounts != "1" ? $this->_sidebarShareCountsClass = ' ampz_no_count' : $this->_sidebarShareCountsClass = '';
        $this->_mobileShareCounts                                           = $this->params->get("mobile_share_counts"); // Show mobile share counts or not
        $this->_mobileShareCounts != "1" ? $this->_mobileShareCountsClass   = ' ampz_no_count' : $this->_mobileShareCountsClass   = '';
        $this->_thresholdTotalShares                                        = $this->params->get("threshold_total_shares"); // Threshold Total Shares

        $positionFlyIn                                 = $this->params->get("positionFlyin");
        $positionFlyIn == "left" ? $positionFlyInClass = "ampz_flyin_left " : $positionFlyInClass = 'ampz_flyin_right ';
        $this->_flyinEntranceEffect                    = $positionFlyInClass . $this->params->get("entranceFlyIn");

        $flyInMobileDisplay   = $this->params->get("flyin_mobile_display");
        $inlineMobileDisplay  = $this->params->get("inline_mobile_display");
        $sidebarMobileDisplay = $this->params->get("sidebar_mobile_display");

        $inlineTopBottom = $this->params->get('inlineTopBottom');

        // Generic variables
        $this->_buttonSize                                           = $this->params->get("buttonSize"); // Get the selected button size
        $this->_buttonSize != "btn_normal" ? $this->_buttonSizeClass = $this->_buttonSize : $this->_buttonSizeClass = '';
        $this->_sidebarStartClosed                                   = $this->params->get("sidebar_start_closed");

        $entranceDelay = strval($this->params->get("entrance_delay")) . "s"; // Get the entrance delay
        if ($this->params->get("mobile_delay") == '1') {
            $entranceDelayMobile = strval($this->params->get("entrance_delay_mobile")) . "s";
        } // Get the entrance delay specific for mobile
        else {
            $entranceDelayMobile = $entranceDelay; // use the general entrance delay
        }

        // Get the enabled networks
        $enabledNetworks = $this->params->get("AMPZ_NETWORKS_SELECT");

        if (!empty($enabledNetworks) && ($this->_staticDisplay)) {
            foreach ($enabledNetworks as &$value) {
                $value = substr($value, 4, strpos($value, '_', 4) - strlen($value)); // only take the network name, not the preceding btn_ and ending _#
            }
            $this->_networks = $enabledNetworks;
        }

        $this->_allNetworks = array_unique(array_merge($this->_networks, $this->_helper->getAllEnabledNetworks())); // merge the enabled networks for the static and shortcode positions

        // if (empty($this->_allNetworks)) {
        //     $this->_noEnabledNetworks = true;
        //     JFactory::getApplication()->enqueueMessage('AMPZ Notice: you have enabled the AMPZ plugin, but not enabled any social networks. Please enable one or more networks in Settings -> Networks. More information can be found <a href="https://docs.roosterz.nl/ampz/configuration/networks" target="_blank" rel="noopener">here</a>.', 'message');
        //
        //     return;
        // }

        // Get url to be shared
        $this->params->get("shorten_urls") == 1 ? $shortUrls = true : $shortUrls = false;
        $this->params->get("http_only") == 1 ? $httpOnly     = true : $httpOnly     = false;
        $this->_url                                          = $this->_helper->getUrl($debug = false, $httpOnly, $shortUrls);
        $shortUrls ? $fetchUrl                               = $this->_helper->getUrl($debug = false, $httpOnly) : $fetchUrl                               = $this->_url; // needed to still use the long url for fetching share counts
        $this->_baseUrl                                      = JURI::root();

        // Start Caching
        $counts         = [];                                           // initialize the counts array
        $cache_lifetime = intval($this->params->get("cache_lifetime")) * 60; // cache lifetime in minutes
        $cached_counts  = false;

        // Fly In Triggers
        $this->params->get("flyin_trigger_bottom") ? $flyInTriggerBottom = true : $flyInTriggerBottom = false;
        $this->params->get("flyin_trigger_time") ? $flyInTriggerTime     = true : $flyInTriggerTime     = false;
        $flyInTriggerTimeSeconds                                         = intval($this->params->get("flyin_trigger_time_seconds")) * 1000;

        $this->_visibilitySideBar = $this->params->get("visibilitySideBar");
        $this->_visibilityMobile  = $this->params->get("visibilityMobile");

        if ($cache_lifetime != 0) {
            // Caching Feature enabled
            require_once JPATH_ROOT . '/components/com_ampz/helpers/ampzcache.class.php';

            $cacheId = "ampz_" . $this->_url;

            $cache = new AmpzCache([
                'name'      => $cacheId,
                'path'      => JPATH_BASE . '/cache/plg_ampz/',
                'extension' => '.cache'
            ]);

            $cache->eraseExpired();          // Erase all expired entries
            $counts = $cache->retrieveAll(); // Retrieve all the cached counts, if there are any

            !empty($counts) ? $cached_counts = true : $cached_counts = false; // if empty than either cache is expired or not cached at all
        }
        // End Caching

        if ($this->params->get("open_new_tab")) {
            $this->_openInNewTab = true;
        }

        // Facebook access token
        $facebook_access_token = $this->params->get("facebook_access_token");
        if (!isset($facebook_access_token)) {
            $facebook_access_token = "0";
        }

        // Get the Title
        $this->_title = $this->_helper->getTitle();

        $inlineDisableExpandOnHover = $this->params->get("inline_disable_expand_on_hover");

        // RTL or not?
        $this->params->get("rtl") ? $this->_rtlClass = " ampz_rtl" : $this->_rtlClass = "";

        $mobileOnlyButtons                                                     = [];
        $this->params->get("viber_show_desktop") ? $mobileOnlyButtons[]        = ".ampz_viber" : "";
        $this->params->get("telegram_show_desktop") ? $mobileOnlyButtons[]     = ".ampz_telegram" : "";
        $this->params->get("whatsapp_show_desktop") ? $mobileOnlyButtons[]     = ".ampz_whatsapp" : "";
        $this->params->get("line_show_desktop") ? $mobileOnlyButtons[]         = ".ampz_line" : "";
        $this->params->get("fb-messenger_show_desktop") ? $mobileOnlyButtons[] = ".ampz_fb-messenger" : "";

        //$userToken = JSession::getFormToken();

        // Build JS needed vars and add them into document
        $js      = "var ampzSettings = ";
        $js_vars = [
            "ampzCounts"                     => ($cached_counts ? $counts['ampz'] : ''),
            "ampzNetworks"                   => $this->_allNetworks,
            "ampzEntranceDelay"              => "$entranceDelay",
            "ampzEntranceDelayMobile"        => "$entranceDelayMobile",
            "ampzMobileOnlyButtons"          => implode(", ", $mobileOnlyButtons),
            "ampzMobileWidth"                => "$mobileWidth",
            "ampzFlyinEntranceEffect"        => "$this->_flyinEntranceEffect",
            "ampzThresholdTotalShares"       => "$this->_thresholdTotalShares",
            "ampzBaseUrl"                    => "$this->_baseUrl",
            "ampzShareUrl"                   => "$fetchUrl",
            "ampzOpenInNewTab"               => "$this->_openInNewTab",
            "ampzFbAT"                       => $facebook_access_token,
            "ampzCacheLifetime"              => "$cache_lifetime",
            "ampzCachedCounts"               => "$cached_counts",
            "ampzFlyInTriggerBottom"         => "$flyInTriggerBottom",
            "ampzFlyInTriggerTime"           => "$flyInTriggerTime",
            "ampzFlyInTriggerTimeSeconds"    => "$flyInTriggerTimeSeconds",
            "ampzActiveComponent"            => "$this->_currentComponent",
            "ampzFlyInDisplayMobile"         => "$flyInMobileDisplay",
            "ampzInlineDisplayMobile"        => "$inlineMobileDisplay",
            "ampzInlineDisableExpandOnHover" => "$inlineDisableExpandOnHover",
            "ampzSidebarDisplayMobile"       => "$sidebarMobileDisplay",
            "ampzFlyInCookieType"            => "$this->_cookieType",
            "ampzFlyInCookieDuration"        => "$this->_cookieDuration",
            "ampzSideBarVisibility"          => "$this->_visibilitySideBar",
            "ampzMobileVisibility"           => "$this->_visibilityMobile",
            "ampzSideBarStartClosed"         => "$this->_sidebarStartClosed"
            //"ampzUserToken" => "$userToken"
        ];

        JHtml::_('jquery.framework');

        $js_vars_json = $js . json_encode($js_vars) . ";";
        $document->addScriptDeclaration($js_vars_json);

        // Add other required javascripts
        if (isset($this->_live)) {
            $document->addScript(JURI::root(true) . '/plugins/system/ampz/ampz/js/ampz.min.js');
        } else {
            // use normal versions
            $document->addScript(JURI::root(true) . '/plugins/system/ampz/ampz/js/ampz.js');
            $document->addScript(JURI::root(true) . '/plugins/system/ampz/ampz/js/ampz_buttonz.js');
            $document->addScript(JURI::root(true) . '/plugins/system/ampz/ampz/js/jquery.magnific-popup.min.js');
            $document->addScript(JURI::root(true) . '/plugins/system/ampz/ampz/js/jquery.appear.js');
            $document->addScript(JURI::root(true) . '/plugins/system/ampz/ampz/js/igrowl.min.js');
        }

        $this->_roundedButtons = $this->params->get("roundedButtons"); // Rounded buttons or not?
        if ($this->_roundedButtons == "1") {
            $this->_roundedButtonsClass = 'ampz_rounded ';
            $roundedButtonsModal        = ".mfp-content ul li a {
                border-radius: 5px;
                -moz-border-radius: 5px;
                -webkit-border-radius: 5px;

            }";
            $document->addStyleDeclaration($roundedButtonsModal);
        } else {
            $this->_roundedButtonsClass = '';
        }

        // Email subject if using that button
        $this->_emailSubject = $this->params->get("subject_email");

        $this->_disableSupportAuthor = $this->params->get("disable_support_author"); // Support author or not

        // Start Inline
        if ($this->_inline) {
            $doc    = JFactory::getDocument();
            $buffer = $doc->getBuffer('component');

            $entranceInline                                  = $this->params->get("entranceInline"); // Get the selected entrance animation
            $entranceInline != "none" ? $entranceInlineClass = "animated " . $entranceInline : $entranceInlineClass = '';

            $hoverEffectInline                                     = $this->params->get("hoverEffectInline"); // Get the selected hover effect
            $hoverEffectInline != "none" ? $hoverEffectInlineClass = $hoverEffectInline : $hoverEffectInlineClass = '';

            $inlineIconOnly      = $this->params->get('inlineIconOnly');
            $inlineDisplayLabels = $this->params->get('inline_display_labels');
            if ($inlineIconOnly) {
                $inlineDisplayLabels = "no";
            }

            $totalSharesInline                         = $this->params->get("inline_total_shares"); // Display total shares or not
            $totalSharesInline ? $totalSharesInlineDiv = $this->_helper->getTotalSharesDiv($this->params->get("inline_color_total_shares"), $this->_totalSharesLabel, $this->_buttonSizeClass) : $totalSharesInlineDiv = '';

            $inlineDisplayCount                                             = $this->params->get('inline_share_counts');
            ($inlineDisplayCount && !$inlineIconOnly) ? $inlineDisplayCount = 1 : $inlineDisplayCount = 0;

            $inlineTopAboveTitle = $this->params->get('inlineTopAboveTitle');

            if (strpos($inlineTopBottom, "top") !== false) {
                $InlineTopHtml = $this->generateAmpzDiv("inline_top", $inlineDisplayLabels, $inlineDisplayCount, $totalSharesInlineDiv, $entranceInlineClass, $hoverEffectInlineClass, $this->_inlineShareCountsClass, $this->_disableSupportAuthor, $this->params->get("inline_no_buttons"));
                $pos           = stripos($buffer, '</h'); // find the position of the first closing heading tag (title)

                if ($inlineTopAboveTitle || $pos === false) {
                    // Defined to show above title or no heading tag found
                    $buffer_new = $InlineTopHtml . $buffer;
                } elseif ($pos !== false) {
                    // title tag is found so insert ampz after title
                    $pos        = $pos + 5;
                    $buffer_new = substr_replace($buffer, $InlineTopHtml, $pos, 0);
                }
            }
            if (strpos($inlineTopBottom, "bottom") !== false) {
                $InlineBottomHtml = $this->generateAmpzDiv("inline_bottom", $inlineDisplayLabels, $inlineDisplayCount, $totalSharesInlineDiv, $entranceInlineClass, $hoverEffectInlineClass, $this->_inlineShareCountsClass, $this->_disableSupportAuthor, $this->params->get("inline_no_buttons"));

                isset($buffer_new) ? $buffer = $buffer_new : '';
                $posK2Tag                    = stripos($buffer, 'K2AfterDisplayContent'); // Is there a default K2AfterDisplayContent tag?

                if ($posK2Tag !== false && !$this->isCategoryView($this->_currentComponent)) {
                    // Yes, so place it right after this tag if a single item
                    $posK2Tag = $posK2Tag + 25;

                    $buffer_new = substr_replace($buffer, $InlineBottomHtml, $posK2Tag, 0);
                } else {
                    // No K2 tag or Category View so just place it after the buffer
                    $buffer_new = $buffer . $InlineBottomHtml;
                }
            }

            // reset the buffer
            $doc->setBuffer($buffer_new, 'component');
        }
    }

    /************************
     * onBeforeCompileHead
     *************************/
    public function onBeforeCompileHead()
    {
        if (!$this->_continue) {
            return;
        }
    }

    /************************
     * onAfterRender: needed for displaying Sidebar and Flyin positions
     *************************/
    public function onAfterRender()
    {
        // Trigger the shortcode search and replace
        if ($this->_helper !== false) {
            $this->_helper->onAfterRender();
        }

        if (!$this->_continue || $this->_noEnabledNetworks) {
            return;
        }

        // Start Sidebar
        if ($this->_sidebar) {
            $html = JFactory::getApplication()->getBody();

            if ($html == '') {
                return;
            }

            $positionSidebar                                    = $this->params->get("positionSideBar");
            $positionSidebar == "right" ? $positionSideBarClass = "ampz_sidebar_right " : $positionSideBarClass = 'ampz_sidebar_left ';

            $entranceSideBar                                   = $this->params->get("entranceSideBar"); // Get the selected entrance animation
            $entranceSideBar != "none" ? $entranceSideBarClass = $positionSideBarClass . "animated " . $entranceSideBar : $entranceSideBarClass = $positionSideBarClass;

            $hoverEffectSideBar                                      = $this->params->get("hoverEffectSideBar"); // Get the selected hover effect
            $hoverEffectSideBar != "none" ? $hoverEffectSideBarClass = $hoverEffectSideBar : $hoverEffectSideBarClass = '';

            $totalSharesSideBar                          = $this->params->get("sidebar_total_shares"); // Display total shares or not
            $totalSharesSideBar ? $totalSharesSideBarDiv = $this->_helper->getTotalSharesDiv($this->params->get("sidebar_color_total_shares"), $this->_totalSharesLabel, $this->_buttonSizeClass) : $totalSharesSideBarDiv = '';

            $sidebarDisplayCount                        = $this->params->get('sidebar_share_counts');
            $sidebarDisplayCount ? $sidebarDisplayCount = 1 : $sidebarDisplayCount = 0;

            $sidebarHtml = $this->generateAmpzDiv("sidebar", 1, $sidebarDisplayCount, $totalSharesSideBarDiv, $entranceSideBarClass, $hoverEffectSideBarClass, $this->_sidebarShareCountsClass, $this->_disableSupportAuthor, $this->params->get("sidebar_no_buttons")) . "</body>";

            $html = str_replace('</body>', $sidebarHtml, $html);

            JFactory::getApplication()->setBody($html);
        }

        // Start Fly In
        if ($this->_flyin) {
            $html = JFactory::getApplication()->getBody();

            if ($html == '') {
                return;
            }

            $hoverEffectFlyIn                                    = $this->params->get("hoverEffectFlyIn"); // Get the selected hover effect
            $hoverEffectFlyIn != "none" ? $hoverEffectFlyInClass = $hoverEffectFlyIn : $hoverEffectFlyInClass = '';

            $flyInDisplayCount                      = $this->params->get('flyin_share_counts');
            $flyInDisplayCount ? $flyInDisplayCount = 1 : $flyInDisplayCount = 0;

            $flyInHtml = $this->generateAmpzDiv("flyin", 1, $flyInDisplayCount, '', '', $hoverEffectFlyInClass, $this->_flyinShareCountsClass, $this->_disableSupportAuthor, '') . "</body>";

            $html = str_replace('</body>', $flyInHtml, $html);

            JFactory::getApplication()->setBody($html);
        }

        // Start Mobile
        if ($this->_mobile) {
            $html = JFactory::getApplication()->getBody();

            if ($html == '') {
                return;
            }

            $entranceMobile                                  = $this->params->get("entranceMobile"); // Get the selected entrance animation
            $entranceMobile != "none" ? $entranceMobileClass = "animated " . $entranceMobile : $entranceMobileClass = '';

            $totalSharesMobile                         = $this->params->get("mobile_total_shares"); // Display total shares or not
            $totalSharesMobile ? $totalSharesMobileDiv = $this->_helper->getTotalSharesDiv($this->params->get("mobile_color_total_shares"), $this->_totalSharesLabel, $this->_buttonSizeClass) : $totalSharesMobileDiv = '';

            $mobileDisplayCount                       = $this->params->get('mobile_share_counts');
            $mobileDisplayCount ? $mobileDisplayCount = 1 : $mobileDisplayCount = 0;

            $mobileHtml = $this->generateAmpzDiv("inline_mobile", 0, $mobileDisplayCount, $totalSharesMobileDiv, $entranceMobileClass, '', $this->_mobileShareCountsClass, $this->_disableSupportAuthor, $this->params->get("mobile_no_buttons")) . "</body>";

            $html = str_replace('</body>', $mobileHtml, $html);

            JFactory::getApplication()->setBody($html);
        }
    }

    /************************
     * onInstallerBeforePackageDownload: needed for the securely updating the extension
     *************************/
    public function onInstallerBeforePackageDownload(&$url, &$headers)
    {
        $uri = JUri::getInstance($url);

        // I don't care about download URLs not coming from our site
        $host = $uri->getHost();
        if ($host != 'www.roosterz.nl') {
            return true;
        }

        // Get the download ID
        $dlid = trim($this->params->get('dlid', ''));

        // If the download ID is invalid, return without any further action
        if (!preg_match('/^([0-9]{1,}:)?[0-9a-f]{32}$/i', $dlid)) {
            return true;
        }

        // Append the Download ID to the download URL
        if (!empty($dlid)) {
            $uri->setVar('dlid', $dlid);
            $url = $uri->toString();
        }

        return true;
    }

    /***************************************************************************************
     * Start Helper Functions
     ****************************************************************************************/

    /************************
     * continueOrNot
     *************************/
    private function continueOrNot($excludeCatView)
    {
        $app = JFactory::getApplication();
        $doc = JFactory::getDocument();

        // Admin view or Print view:
        if ($app->isClient('administrator') || ($doc->getType() != 'html') || ($app->input->get('print') == 1) ||
            ($app->input->get('view') == "print") || ($app->input->get('view') == "composer") ||
            ($app->input->get('task') == "edit") || ($app->input->get('layout') == "itemform") ||
            ($app->input->get('ctrl') == "checkout")) {
            return false;
        }

        // Are there any shortcodes defined and found on this page?
        $this->_activeShortcodes                              = $this->_helper->getActiveShortcodes();
        empty($this->_activeShortcodes) ? $noActiveShortcodes = true : $noActiveShortcodes = false;

        $excludeIncludeUrlsSelect = $this->params->get("exclude_include_urls_select");

        // Only return if buttons should NOT be displayed
        if ($excludeIncludeUrlsSelect == "0" || $excludeIncludeUrlsSelect == "1") {

            // Create an array for the defined urls and check if there is a match with the current url
            $excludeIncludeUrls = $this->params->get("exclude_include_urls");
            $excludeIncludeUrls = explode("\n", $excludeIncludeUrls);
            $currentUrl         = $_SERVER["REQUEST_URI"];

            $urlMatch = false;
            if ($this->_helper->strposa($currentUrl, $excludeIncludeUrls) !== false) {
                $urlMatch = true;
            }

            // If url needs to be excluded and there is a match or if url needs to be included and there is no match: return
            if (($excludeIncludeUrlsSelect == "0" && $urlMatch) || ($excludeIncludeUrlsSelect == "1" && !$urlMatch)) {
                if ($noActiveShortcodes) {
                    return false;
                } elseif (!$noActiveShortcodes) {
                    return true;
                }
            }
        }

        // Stop if it is an AMP page
        $url        = $_SERVER["REQUEST_URI"];
        $ampString  = "/amp";
        $ampString2 = ".amp.html";
        if ((substr_compare($url, $ampString, strlen($url) - strlen($ampString), strlen($ampString)) === 0) || (substr_compare($url, $ampString2, strlen($url) - strlen($ampString2), strlen($ampString2)) === 0)) {
            return false;
        }

        $placement_array = $this->params->get("AMPZ_LOCATION_SELECT"); // Get the enabled locations

        $jinput = $app->input;

        // Start checking cookies for Fly In position
        $cookie      = "ampz_flyin_" . md5(JPATH_SITE);
        $flyInCookie = $jinput->cookie->get($cookie, false);

        $this->_cookieType     = $this->params->get("cookietype");
        $this->_cookieDuration = $this->params->get("cookie_duration");

        if ($flyInCookie) {
            $this->_flyInDisabledByCookie = true;
        }

        // Start Frontpage Display
        $menu    = $app->getMenu();
        $lang    = JFactory::getLanguage();
        $baseUrl = JUri::base();

        // Look for the home menu
        if (JLanguageMultilang::isEnabled()) {
            $languages    = JLanguageHelper::getLanguages('lang_code');
            $languageCode = $languages[$lang->getTag()]->sef;

            $baseUrl = $baseUrl . $languageCode;

            if ($languageCode != "") {
                $baseUrl = $baseUrl . '/';
            }
        }

        if ($menu->getActive() == $menu->getDefault($lang->getTag()) && ($baseUrl == JUri::current())) {
            // detect the true frontpage
            $this->_frontpage       = 1;
            $showOnFrontpageSidebar = $this->params->get("sidebar_frontpage_display");
            $showOnFrontpageFlyin   = $this->params->get("flyin_frontpage_display");
            $showOnFrontpageInline  = $this->params->get("inline_frontpage_display");
            $showOnFrontpageMobile  = $this->params->get("mobile_frontpage_display");

            if (!$showOnFrontpageSidebar && !$showOnFrontpageFlyin && !$showOnFrontpageInline && !$showOnFrontpageMobile && $noActiveShortcodes) {
                return false;
            } else {
                if (!empty($placement_array)) {
                    if ($showOnFrontpageSidebar && in_array("display_sidebar", $placement_array)) {
                        $this->_sidebar = true;
                    }
                    if ($showOnFrontpageFlyin && in_array("display_flyin", $placement_array) && !$this->_flyInDisabledByCookie) {
                        $this->_flyin = true;
                    }
                    if ($showOnFrontpageInline && in_array("display_inline", $placement_array)) {
                        $this->_inline = true;
                    }
                }

                if (!$showOnFrontpageMobile && $this->_mobile) {
                    $this->_mobile = false;
                }

                if (!$this->_sidebar && !$this->_inline && !$this->_flyin && !$this->_mobile && $noActiveShortcodes) {
                    return false;
                }
            }

            return true;
        }
        // End Frontpage Display

        // Not on frontpage. Let's check if the current component is enabled
        $includeComponentsArray        = $this->params->get("includeComponents");
        $includeComponentsInlineArray  = $this->params->get("includeComponentsInline");  // override display options for inline position
        $includeComponentsSidebarArray = $this->params->get("includeComponentsSidebar"); // override display options for sidebar position
        $includeComponentsFlyInArray   = $this->params->get("includeComponentsFlyIn");   // override display options for fly in position

        // Is the current component set in the default publishing assignments
        (is_array($includeComponentsArray) && (in_array($this->_currentComponent, $includeComponentsArray))) ? $defaultActive = true : $defaultActive = false;
        // Is there an override for the inline position
        $overrideInline                                                                                                  = !empty($includeComponentsInlineArray);
        ($overrideInline && (in_array($this->_currentComponent, $includeComponentsInlineArray))) ? $inlineOverrideActive = true : $inlineOverrideActive = false;
        // Is there an override for the sidebar position
        $overrideSidebar                                                                                                    = !empty($includeComponentsSidebarArray);
        ($overrideSidebar && (in_array($this->_currentComponent, $includeComponentsSidebarArray))) ? $sidebarOverrideActive = true : $sidebarOverrideActive = false;
        // Is there an override for the flyin position
        $overrideFlyIn                                                                                                = !empty($includeComponentsFlyInArray);
        ($overrideFlyIn && (in_array($this->_currentComponent, $includeComponentsFlyInArray))) ? $flyinOverrideActive = true : $flyinOverrideActive = false;

        // Current Component is Included by the User or an override component for a specific position
        if ($defaultActive || $inlineOverrideActive || $sidebarOverrideActive || $flyinOverrideActive) {
            if ($this->isCategoryView($this->_currentComponent) && $excludeCatView) {
                // In category view which is excluded
                if ($noActiveShortcodes) {
                    return false;
                } elseif (!$noActiveShortcodes) {
                    return true;
                }
            }

            // Start Check Menu Items
            $excludeMenuItems = $this->params->get("excludeMenuItems"); // Get the excluded menu items
            $excludeMenuIds   = empty($excludeMenuItems) ? [] : $excludeMenuItems;

            $app                                           = JFactory::getApplication();
            $menu                                          = $app->getMenu();
            isset($menu->getActive()->id) ? $currentMenuId = $menu->getActive()->id : $currentMenuId = 0;

            if (in_array(strval($currentMenuId), $excludeMenuIds)) {
                // Current menu item is excluded
                if ($noActiveShortcodes) {
                    return false;
                } elseif (!$noActiveShortcodes) {
                    return true;
                }
            }

            // Start Check Joomla Content
            if ($this->_currentComponent == "com_content") {
                // Joomla Native Content Component

                // Ignore ("") or exclude ("0") / incude ("1") specific content
                $excludeIncludeCategories = $this->params->get('exclude_include_categories');
                $excludeIncludeArticles   = $this->params->get('exclude_include_articles');

                if ($excludeIncludeArticles != "" || $excludeIncludeCategories != "") {
                    // At least 1 is not ignoring

                    $exIncludeCats       = $this->params->get('excludeCategories');
                    $exIncludeCategories = empty($exIncludeCats) ? [] : $exIncludeCats;

                    $exIncludeArts     = $this->params->get('excludeArticles');
                    $exIncludeArticles = empty($exIncludeArts) ? [] : $exIncludeArts;

                    if ($this->isCategoryView($this->_currentComponent)) {
                        // Category View
                        $currentCatId     = $app->input->get('id', 0, 'INT');
                        $currentArticleId = 0;
                    } else {
                        // Article View
                        $currentArticleId = $app->input->get('id', 0, 'INT');
                        // Retrieve Category ID
                        $db = JFactory::getDBO();
                        $db->setQuery("SELECT catid FROM #__content WHERE id = " . $currentArticleId);
                        $currentCatId = $db->loadResult();
                    }

                    // Only return if buttons should NOT be displayed
                    if ((($excludeIncludeArticles == "0" && in_array(strval($currentArticleId), $exIncludeArticles)) || ($excludeIncludeArticles == "1" && !in_array(strval($currentArticleId), $exIncludeArticles)))) {
                        if ($noActiveShortcodes) {
                            return false;
                        } elseif (!$noActiveShortcodes) {
                            return true;
                        }
                    }
                    if ((($excludeIncludeCategories == "0" && in_array(strval($currentCatId), $exIncludeCategories)) || ($excludeIncludeCategories == "1" && !in_array(strval($currentCatId), $exIncludeCategories)))) {
                        if ($noActiveShortcodes) {
                            return false;
                        } elseif (!$noActiveShortcodes) {
                            return true;
                        }
                    }
                }
            }
            // End Check Joomla Content

            // Start Check K2 Content
            if ($this->_currentComponent == "com_k2") {
                // K2 Component

                // Ignore ("") or exclude ("0") / incude ("1") specific content
                $excludeIncludeCategories = $this->params->get('exclude_includeK2Categories');
                $excludeIncludeArticles   = $this->params->get('exclude_includeK2Articles');

                if ($excludeIncludeArticles != "" || $excludeIncludeCategories != "") {
                    // At least 1 is not ignoring

                    $exIncludeCats       = $this->params->get('excludeK2Categories');
                    $exIncludeCategories = empty($exIncludeCats) ? [] : $exIncludeCats;

                    $exIncludeArts     = $this->params->get('excludeK2Articles');
                    $exIncludeArticles = empty($exIncludeArts) ? [] : $exIncludeArts;

                    if ($this->isCategoryView($this->_currentComponent)) {
                        // Category View
                        $currentCatId     = $app->input->get('id', 0, 'INT');
                        $currentArticleId = 0;
                    } else {
                        // Article View
                        $currentArticleId = $app->input->get('id', 0, 'INT');
                        $db               = JFactory::getDBO();
                        $db->setQuery("SELECT catid FROM #__k2_items WHERE id = " . $currentArticleId);
                        $currentCatId = $db->loadResult();
                    }

                    // Only return if buttons should NOT be displayed
                    if ((($excludeIncludeArticles == "0" && in_array(strval($currentArticleId), $exIncludeArticles)) || ($excludeIncludeArticles == "1" && !in_array(strval($currentArticleId), $exIncludeArticles)))) {
                        if ($noActiveShortcodes) {
                            return false;
                        } elseif (!$noActiveShortcodes) {
                            return true;
                        }
                    }
                    if ((($excludeIncludeCategories == "0" && in_array(strval($currentCatId), $exIncludeCategories)) || ($excludeIncludeCategories == "1" && !in_array(strval($currentCatId), $exIncludeCategories)))) {
                        if ($noActiveShortcodes) {
                            return false;
                        } elseif (!$noActiveShortcodes) {
                            return true;
                        }
                    }
                }
            }
            // End Check K2 Content

            // Start Check Zoo Content
            if ($this->_currentComponent == "com_zoo") {
                // Zoo Component
                $exIncludeCats       = $this->params->get('excludeZooCategories');
                $exIncludeCategories = empty($exIncludeCats) ? [] : $exIncludeCats;

                $exIncludeArts     = $this->params->get('excludeZooArticles');
                $exIncludeArticles = empty($exIncludeArts) ? [] : $exIncludeArts;

                if ($this->isCategoryView($this->_currentComponent)) {
                    // Category View
                    $currentCatId     = 0;
                    $currentArticleId = 0;
                } else {
                    // Article View
                    $currentArticleId = $app->input->get('item_id', 0, 'INT');
                    $db               = JFactory::getDBO();
                    $db->setQuery("SELECT `params` FROM #__zoo_item WHERE id = " . $currentArticleId);
                    $params       = json_decode($db->loadResult());
                    $currentCatId = intval($params->{'config.primary_category'});
                }

                if ((in_array(strval($currentCatId), $exIncludeCategories)) || (in_array(strval($currentArticleId), $exIncludeArticles))) {
                    // Current article is in a category which is excluded or the article itself is excluded
                    if ($noActiveShortcodes) {
                        return false;
                    } elseif (!$noActiveShortcodes) {
                        return true;
                    }
                }
            }
            // End Check Zoo Content

            if (!empty($placement_array)) {
                if (in_array("display_inline", $placement_array) && (($defaultActive && !$overrideInline) || $inlineOverrideActive)) {
                    $this->_inline = true;
                }
                if (in_array("display_sidebar", $placement_array) && (($defaultActive && !$overrideSidebar) || $sidebarOverrideActive)) {
                    $this->_sidebar = true;
                }
                if (!$this->_flyInDisabledByCookie && in_array("display_flyin", $placement_array) && (($defaultActive && !$overrideFlyIn) || $flyinOverrideActive)) {
                    $this->_flyin = true;
                }

                return true;
            } elseif (empty($placement_array) && $this->_mobile) {
                // only mobile position enabled
                return true;
            } elseif (!$noActiveShortcodes) {
                // no position at all enabled, but there is an active shortcode
                return true;
            } else {
                return false;
            }
        } elseif (!$noActiveShortcodes) {
            // there is an active shortcode
            $this->_mobile = false; // Mobile should be hidden

            return true;
        } else {
            return false;
        }
    }

    /************************
     * isCategoryView: returns true if current view is category view
     *************************/
    private function isCategoryView($currentComponent)
    {
        $app = JFactory::getApplication();

        $currentView   = $app->input->getCmd('view', '');
        $currentLayout = $app->input->getCmd('layout', '');
        $currentTask   = trim($app->input->getCmd('task', ''));

        if ($currentView == "list" || $currentView == "category" || $currentView == "products" || ($currentView == "items" && $currentLayout == "blog") || $currentView == "categories" || $currentView == "featured" || $currentView == "items" || $currentView == "itemlist" || ($currentView == "discover" && $currentComponent == "com_crowdfunding") || ($currentView == "cart" && $currentComponent == "com_virtuemart") || ($currentView == "user" && $currentComponent == "com_virtuemart") || $currentView == "latest" || $currentView == "album" || $currentLayout == "list") {
            return true;
        } elseif ($currentComponent == "com_jevents") {
            // JEvents has multiple category views
            if ($currentTask == "weeklistevents" || $currentTask == "monthcalendar" || $currentTask == "monthcalendar" || $currentTask == "yearlistevents" || $currentTask == "daylistevents" || $currentTask == "searchform") {
                return true;
            }
        } elseif ($currentComponent == "com_zoo") {
            // special things for ZOO
            $requestUrl               = $_SERVER["REQUEST_URI"];
            $regexTrailingSlashNumber = "/\\/\\d+/";

            if (((preg_match($regexTrailingSlashNumber, $requestUrl) === 1) || ($currentView == "frontpage") || ($currentTask == "category")) && ($currentTask != "item")) {
                // ZOO Category pages for some reason
                return true;
            }
        } else {
            return false;
        }
    }

    /************************
     * getHelper: returns the helper for AMPZ shortcodes
     *************************/
    private function getHelper()
    {
        $app = JFactory::getApplication();

        // Already initialized, so return
        if ($this->_init) {
            return $this->_helper;
        }

        $this->_init = true;

        jimport('joomla.filesystem.file');

        if (!JFile::exists(JPATH_ADMINISTRATOR . '/components/com_ampz/models/shortcodes.php')) {
            return false;
        }

        if (JFactory::getApplication()->isClient('administrator') || ($app->input->get('print') == 1)) {
            return false;
        }

        require_once __DIR__ . '/helper.php';
        $params        = JComponentHelper::getParams('com_ampz');
        $this->_helper = new PlgSystemAmpzHelper($params);

        return $this->_helper;
    }

    /************************
     * generateAmpzDiv
     *************************/
    private function generateAmpzDiv($position, $displayLabels, $displayCount, $totalSharesDiv, $entranceEffect, $hoverEffect, $shareCountsClass, $disableSupportAuthor, $combineAfter)
    {
        $this->params->get("inlineDisplayAs") == "click_for_buttons" ? $clickForButtons = true : $clickForButtons = false;

        (($position == "inline_top" || $position == "inline_bottom") && $this->params->get("inline_container_max_width") != "0") ? $inlineMaxWidth = 'style="max-width:' . $this->params->get("inline_container_max_width") . 'px" ' : $inlineMaxWidth = ""; // Put a max on the width of the inline container?

        (($position == "inline_top" || $position == "inline_bottom") && $this->params->get("inlineIconOnly")) ? $classInlineIconOnly = ' ampz_inline_icon_only' : $classInlineIconOnly = ""; // Icon only for the inline position?

        (($position == "inline_top" || $position == "inline_bottom") && $this->params->get("inline_disable_expand_on_hover")) ? $classInlineDisableExpand = ' ampz_inline_disable_expand' : $classInlineDisableExpand = ""; // Disable expand for the inline position?

        ($position == "inline_mobile" && $this->params->get("mobile_no_margin")) ? $classMobileNoMargin = ' ampz_mobile_no_margin' : $classMobileNoMargin = '';

        $html = '<!-- start ampz ' . $position . ' -->';

        if (($position == "inline_top" || $position == "inline_bottom") && $clickForButtons) {
            $html .= '
                <div id="click_to_show_ampz_' . $position . '" style= "' . $this->_fontStyle . '">
                    <a href="#"><span class="ampz_click_text" style="color:' . $this->params->get("colorClickToShareText") . '">' . $this->params->get("clickToShareText") . '</span><i class="ampz data-icon ampz-icoon-share" style="background:' . $this->params->get("colorClickToShareBackgroundShareIcon") . '"></i></a>
                </div>';
        }

        $inlineButtonWidth = "auto";

        if ($position == "inline_top" || $position == "inline_bottom") {
            $totalSharesDiv != "" ? $totalSharesInline         = true : $totalSharesInline  = false;
            $disableSupportAuthor != "1" ? $supportIconEnabled = true : $supportIconEnabled = false;

            $inlineButtonWidth = $this->params->get("inlineButtonWidth");

            if ($inlineButtonWidth == "auto") {
                if ($totalSharesInline && $supportIconEnabled) {
                    $inlineButtonWidth = "autototalsupport";
                } elseif ($totalSharesInline) {
                    $inlineButtonWidth = "autototal";
                } else {
                    $inlineButtonWidth = "auto";
                }
                if (!$totalSharesInline && $supportIconEnabled) {
                    $inlineButtonWidth = "autosupport";
                }
            }
        }

        $html .= '<div id="ampz_' . $position . '" style= "' . $this->_fontStyle . '" class="' . $entranceEffect . $classInlineDisableExpand . $classInlineIconOnly . $classMobileNoMargin . '"  data-combineafter="' . $combineAfter . '" data-buttontemplate="' . $this->_buttonTemplate . '" data-buttonsize="' . $this->_buttonSizeClass . '" data-buttonwidth="' . $inlineButtonWidth . '"' . $inlineMaxWidth . '>';

        $sidebarMarginClass = "";
        if ($position == "sidebar") {
            $sidebarMargin                              = $this->params->get("sidebar_margin"); // Add a margin between the sidebar buttons or not?
            $sidebarMargin == "1" ? $sidebarMarginClass = ' ampz_sidebar_margin' : $sidebarMarginClass = '';
        }

        if ($position == "flyin") {
            $flyinTitle = $this->params->get("headingFlyIn");
            if ($this->_multiLingual && $this->_activeLanguageNumber != 0) {
                $flyinTitle_text = "headingFlyIn_" . $this->_activeLanguageNumber;
                $flyinTitle      = $this->params->get($flyinTitle_text);
            }

            $flyinText = $this->params->get("textFlyIn");
            if ($this->_multiLingual && $this->_activeLanguageNumber != 0) {
                $flyinText_text = "textFlyIn_" . $this->_activeLanguageNumber;
                $flyinText      = $this->params->get($flyinText_text);
            }

            $html .= '
            <header class="ampz_flyin_header">
                <h3>' . $flyinTitle . '</h3>
                <a href="#" class="ampz_flyin_close"></a>
                <p>' . $flyinText . '</p>
	        </header>';
        }

        if ($position == "flyin" && $this->params->get("flyin_share_follow") == "follow") {
            $html .= '  <div class="' . $this->_roundedButtonsClass . 'ampz_container' . $shareCountsClass . '">' .
                '<ul>';

            foreach ($this->_networks as $network) {
                // Retrieve Network Label
                $network_label_text = "label_" . $network . "_follow";
                if ($this->_multiLingual && $this->_activeLanguageNumber != 0) {
                    $network_label_text = "label_" . $network . "_follow_" . $this->_activeLanguageNumber;
                }
                $network_label       = $this->params->get($network_label_text);
                $network_follow_text = $network . "_follow";
                $network_follow      = $this->params->get($network_follow_text);

                (strpos($network_follow, 'YOURPAGE') === false) ? $href = $network_follow : $href = '';

                if ($href != '') {
                    $html .= '
                           <li class="' . $hoverEffect . $this->_rtlClass . '">
                              <a target="_blank" rel="noopener" aria-label="flyin_' . $network . '" class="ampz_flyin_follow ' . $this->_buttonTemplate . ' ampz_btn ' . $this->_buttonSizeClass . ' ampz_' . $network . ' ' . $this->_extra_classes . '" href="' . $href . '">
                                 <i class="ampz ampz-icoon ampz-icoon-' . $network . '"></i>
                                 <span class="ampz_network_label">' . $network_label . '</span>
                           ';
                    (strpos($this->_extra_classes, 'ampz_overlay') !== false) ? $html .= '<span class="ampz_icon_overlay"></span>' : '';
                    (strpos($this->_extra_classes, 'ampz_white_overlay') !== false) ? $html .= '<span class="ampz_icon_white_overlay"></span>' : '';

                    $html .= '</a>
                       ';
                }
            }
        } elseif ($position == "sidebar" && $this->params->get("sidebar_share_follow") == "follow") {
            $html .= '  <div class="' . $this->_roundedButtonsClass . 'ampz_container' . $sidebarMarginClass . $shareCountsClass . '">' .
                '<ul>';

            foreach ($this->_networks as $network) {
                $network_follow_text = $network . "_follow";
                $network_follow      = $this->params->get($network_follow_text);

                (strpos($network_follow, 'YOURPAGE') === false) ? $href = $network_follow : $href = '';

                if ($href != '') {
                    $html .= '
                           <li class="' . $hoverEffect . $this->_rtlClass . '">
                              <a target="_blank" rel="noopener" aria-label="sidebar_follow_' . $network . '"  class="ampz_sidebar_follow ' . $this->_buttonTemplate . ' ampz_no_count ampz_btn ' . $this->_buttonSizeClass . ' ampz_' . $network . ' ' . $this->_extra_classes . '" href="' . $href . '">
                                 <i class="ampz ampz-icoon ampz-icoon-' . $network . '"></i>
                           ';
                    (strpos($this->_extra_classes, 'ampz_overlay') !== false) ? $html .= '<span class="ampz_icon_overlay"></span>' : '';
                    (strpos($this->_extra_classes, 'ampz_white_overlay') !== false) ? $html .= '<span class="ampz_icon_white_overlay"></span>' : '';

                    $html .= '</a>
                       ';
                }
            }
        } elseif ($position == "inline_mobile" && $this->params->get("mobile_share_follow") == "follow") {
            $html .= '  <div class="ampz_container">' .
                '<ul>';

            foreach ($this->_networks as $network) {
                $network_follow_text = $network . "_follow";
                $network_follow      = $this->params->get($network_follow_text);

                (strpos($network_follow, 'YOURPAGE') === false) ? $href = $network_follow : $href = '';

                if ($href != '') {
                    $html .= '
                           <li class="' . $hoverEffect . $this->_rtlClass . '">
                              <a target="_blank" rel="noopener" aria-label="mobile_follow_' . $network . '"  class="ampz_mobile_follow ' . $this->_buttonTemplate . ' ampz_no_count ampz_btn ' . $this->_buttonSizeClass . ' ampz_' . $network . ' ' . $this->_extra_classes . '" href="' . $href . '">
                                 <i class="ampz ampz-icoon ampz-icoon-' . $network . '"></i>
                           ';
                    (strpos($this->_extra_classes, 'ampz_overlay') !== false) ? $html .= '<span class="ampz_icon_overlay"></span>' : '';
                    (strpos($this->_extra_classes, 'ampz_white_overlay') !== false) ? $html .= '<span class="ampz_icon_white_overlay"></span>' : '';

                    $html .= '</a>
                       ';
                }
            }
        } else {
            $titleInlineAboveButtons = $this->params->get("title_inline_above_buttons");
            if ($this->_multiLingual && $this->_activeLanguageNumber != 0) {
                $titleInlineAboveButtons_text = "title_inline_above_buttons_" . $this->_activeLanguageNumber;
                $titleInlineAboveButtons      = $this->params->get($titleInlineAboveButtons_text);
            }

            if (($position == "inline_top" || $position == "inline_bottom") && ($titleInlineAboveButtons != "")) {
                $html .= '<div class="ampz_inline_title">' . $titleInlineAboveButtons . '</div>';
            }

            if (!$disableSupportAuthor && ($position == "inline_top" || $position == "inline_bottom")) {
                $html .= '
                <div class="ampz_support_author">
                            <a href="https://www.roosterz.nl/joomla-extensions/ampz" class="ampz_roosterz_icon" target="_blank" rel="noopener">
                  </a>
                </div>';
            }

            $html .= '  <div class="' . $this->_roundedButtonsClass . 'ampz_container' . $sidebarMarginClass . $shareCountsClass . '">' . $totalSharesDiv .
                '<ul>';

            $class_labels  = "";
            $network_label = "";

            // Generate network html
            foreach ($this->_networks as $network) {
                if (!in_array($network, $this->_followOnly)) {
                    // Only buttons that also have Sharing options
                    if ($displayLabels != "no") { // Show labels one way or the other
                        $numLanguages = intval($this->params->get("num_langs"));

                        $network_label_text = "label_" . $network; // Default label for share button
                        if ($this->_multiLingual && $this->_activeLanguageNumber != 0) {
                            $network_label_text = "label_" . $network . "_" . $this->_activeLanguageNumber;
                        }

                        $network_label                          = $this->params->get($network_label_text);
                        $displayLabels == "yes" ? $class_labels = " ampz_labels_always" : $class_labels = "";
                    }

                    // Get Twitter via if filled out
                    ($network == "twitter" && ($this->params->get("via_twitter") != "")) ? $data_via = ' data-via=' . $this->params->get("via_twitter") : $data_via = '';

                    // Get Flattr username if filled out
                    ($network == "flattr" && ($this->params->get("flattr_username") != "")) ? $data_flattrusername = ' data-flattrusername=' . $this->params->get("flattr_username") : $data_flattrusername = '';

                    // Get Love Title
                    ($network == "love") ? $data_lovetitle = ' data-lovetitle="' . htmlentities($this->params->get("love_title")) . '"' : $data_lovetitle = '';

                    // Get Copy Title
                    ($network == "copy") ? $data_copytitle = ' data-copytitle="' . htmlentities($this->params->get("copy_title")) . '"' : $data_copytitle = '';

                    switch ($network) {
                        case "email":
                            $href_body = $this->_emailSubject . urldecode($this->_title) . '&amp;body=' . urldecode($this->_url);
                            $href      = "mailto:?subject=$href_body";
                            break;
                        default:
                            $href = "#";
                    }

                    $html .= '
                            <li class="' . $hoverEffect . $this->_rtlClass . '">
        					    <a aria-label="' . $position . '_' . $network . '" class="' . $this->_buttonTemplate . ' ampz_btn ' . $this->_buttonSizeClass . ' ampz_' . $network . ' ' . $this->_extra_classes . '" data-url="' . $this->_url . '" data-basecount="0" data-shareposition="' . $position . '"  data-sharetype="' . $network . '" data-text="' . $this->_title . '" ' . $data_via . $data_flattrusername . $data_lovetitle . $data_copytitle .' href="' . $href . '">
        					        <i class="ampz ampz-icoon ampz-icoon-' . $network . '"></i>
                          ';

                    $displayLabels != "no" ? $html .= '<span class="ampz_network_label' . $class_labels . '">' . $network_label . '</span>' : '';
                    $displayCount ? $html .= '<span class="ampz_count"></span>' : '';
                    (strpos($this->_extra_classes, 'ampz_overlay') !== false) ? $html .= '<span class="ampz_icon_overlay"></span>' : '';
                    (strpos($this->_extra_classes, 'ampz_white_overlay') !== false) ? $html .= '<span class="ampz_icon_white_overlay"></span>' : '';

                    $html .= '</a>
                        ';
                }
            }
        }

        $html .= '
                    </ul>';

        if ($position == "sidebar") {
            if (!$disableSupportAuthor) {
                $html .= '
                <div class="ampz_support_author">
				    <a href="http://www.roosterz.nl/joomla-extensions/ampz" class="ampz_roosterz_icon" target="_blank" rel="noopener"></a>
                </div>';
            }

            $html .= '<span class="ampz_hide_sidebar"><i class="ampz ampz-icoon ampz-icoon-' . $this->params->get("positionSideBar") . '-open"></i></span>';
        }

        $html .= '
                </div>
            </div>';

        if ($position == "sidebar") {
            $html .= '<div class="ampz_show_sidebar"><i class="ampz ampz-icoon ampz-icoon-share"></i></div>';
        }

        $html .= '<!-- end ampz ' . $position . ' -->';

        return $html;
    }
}
