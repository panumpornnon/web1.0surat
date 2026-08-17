<?php

/**
 * @version    4.1.1
 * @package    AMPZ
 *
 * @author     roosterz.nl <roy@roosterz.nl>
 * @copyright  2022 roosterz.nl
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */
// No direct access
defined('_JEXEC') || die;

jimport('joomla.application.component.controller');

/**
 * Class AmpzController
 *
 * @since  1.6
 */
class AmpzController extends JControllerLegacy
{
    /**
     * Method to display a view.
     *
     * @since    1.5
     *
     * @param  boolean     $cachable  If true, the view output will be cached
     * @param  mixed       $urlparams An array of safe url parameters and their variable types, for valid values see {@link JFilterInput::clean()}.
     * @return JController This object to support chaining.
     */
    public function display($cachable = false, $urlparams = false)
    {
        $view = JFactory::getApplication()->input->getCmd('view', 'dashboard');
        JFactory::getApplication()->input->set('view', $view);

        parent::display($cachable, $urlparams);

        return $this;
    }

    public function storeShareCount()
    {
        //JSession::checkToken() or jexit(JText::_('JINVALID_TOKEN'));

        $app      = JFactory::getApplication();
        $postData = $app->input->post;

        $network       = $postData->get('button', '', 'STRING');
        $shareposition = $postData->get('position', '', 'STRING');
        $url           = $postData->get('url', '', 'STRING');
        $title         = $postData->get('title', '', 'STRING');
        $datetime      = date('Y-m-d H:i:s');

        // Only insert if data is passed
        if ($shareposition != '' && $title != '') {
            // if( preg_match('/^4/', JVERSION ) ) $db = \Joomla\CMS\Factory::getDBO();
            //  else $db = JFactory::getDbo();
            $db    = JFactory::getDbo();
            $query = $db->getQuery(true);

            $values = [$db->quote(0), $db->quote($datetime), $db->quote($network), $db->quote($shareposition), $db->quote(urldecode($url)), $db->quote($title)];

            // Prepare the insert query.
            $query
                ->insert($db->quoteName('#__ampz_stats'))
                ->values(implode(',', $values));

            // Set the query using our newly populated query object and execute it.
            $db->setQuery($query);
            $db->execute();

            // if ($db->getErrorNum()) {
            //     return JError::raiseError("Error", $db->stderr());
            // }
        }
    }

    public function setFlyInCookie()
    {
        //JSession::checkToken() or jexit(JText::_('JINVALID_TOKEN'));

        $app      = JFactory::getApplication();
        $jinput   = $app->input;
        $postData = $app->input->post;

        $cookie = "ampz_flyin_" . md5(JPATH_SITE);

        $cookieType     = $postData->get('cookieType', '', 'STRING');
        $cookieDuration = $postData->get('cookieDuration', '', 'STRING');

        if (isset($cookieType) && isset($cookieDuration)) {
            if ($cookieType === "never") {
                $jinput->cookie->set($cookie, null, time() - 1, '/');
            } elseif ($cookieType === "ever") {
                $jinput->cookie->set($cookie, 1, time() + (10 * 365 * 24 * 60 * 60), '/');
            } elseif ($cookieType === "session") {
                $jinput->cookie->set($cookie, 1, 0, '/');
            } else { // user has specified an amount of time
                $jinput->cookie->set($cookie, 1, time() + (intval($cookieDuration) * intval($cookieType)), '/');
            }
        }
    }

    public function cacheCounts()
    {
        //JSession::checkToken() or jexit(JText::_('JINVALID_TOKEN'));

        //define( 'JPATH_BASE', realpath(dirname(__FILE__).'/../../' ));
        require_once JPATH_ROOT . '/components/com_ampz/helpers/ampzcache.class.php';

        //require_once("helpers/ampzcache.class.php");

        $app      = JFactory::getApplication();
        $postData = $app->input->post;

        $network    = $postData->get('name', '', 'STRING');
        $count      = $postData->get('count', '', 'ARRAY');
        $cacheId    = $postData->get('cacheId', '', 'STRING');
        $expiration = $postData->get('expiration', '', 'STRING');

        if (isset($network) && isset($cacheId)) {
            $cache = new AmpzCache([
                'name'      => $cacheId,
                'path'      => JPATH_BASE . '/cache/plg_ampz/',
                'extension' => '.cache'
            ]);

            $cache->store($network, $count, $expiration); // Store the count in the cache
        }
    }

    public function fetchShareCount()
    {
        //JSession::checkToken('get') or jexit(JText::_('JINVALID_TOKEN'));
        // In case of CORS issue, enable the code below:
        //header("Access-Control-Allow-Origin: *");
        //header("Access-Control-Allow-Methods: PUT, GET, POST, DELETE, OPTIONS");
        //header("Access-Control-Allow-Headers: *");

        $app      = JFactory::getApplication();
        $postData = $app->input->get;

        $network = $postData->get('network', '', 'STRING');
        $url     = $postData->get('url', '', 'STRING');

        /*$allow_url_fopen = ini_get('allow_url_fopen');

        if (!$allow_url_fopen)
        {
        // Add a 666 as count if allow_url_fopen is not enabled in PHP
        echo 666;
        }*/

        if (isset($url) && isset($network)) { // && $allow_url_fopen)
            ob_end_clean();

            switch ($network) {
                case "facebook":

                    $access_token_fb = $postData->get('access_token_fb', '', 'STRING');

                    if ($access_token_fb !== '0') {
                        $fetchUrl = "https://graph.facebook.com/v6.0/?fields=engagement&id=$url&access_token=$access_token_fb";
                    } else {
                        $fetchUrl = "https://graph.facebook.com/?id=" . $url;
                    }

                    $curl = curl_init();
                    curl_setopt($curl, CURLOPT_URL, $fetchUrl);
                    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($curl, CURLOPT_HTTPHEADER, ['Content-type: application/json']);
                    $curl_results = curl_exec($curl);
                    curl_close($curl);

                    if (($curl !== false) && ($curl_results !== false)) {
                        // no cUrl issues
                        $json = json_decode($curl_results, true);
                    } else {
                        $json = json_decode(file_get_contents($fetchUrl), true);
                    }

                    if (isset($json['share']['share_count'])) {
                        $count = $json['share']['share_count'];
                    }
                    if (isset($json['engagement']['share_count']) || isset($json['engagement']['reaction_count'])) {
                        $count = intval($json['engagement']['share_count']) + intval($json['engagement']['reaction_count']) + intval($json['engagement']['comment_count']);
                    }
                    if (isset($count)) {
                        echo intval($count);
                    } else {
                        echo 0;
                    }

                    break;

                case "reddit":
                    $json_string = file_get_contents("https://www.reddit.com/api/info.json?url=$url&format=json");
                    $json        = json_decode($json_string, true);

                    if (isset($json['data']['children'][0]['data']['score'])) {
                        $count = $json['data']['children'][0]['data']['score'];
                        echo isset($count) ? intval($count) : 0;
                    } else {
                        echo 0;
                    }

                    break;

                case "pinterest":
                    $fetchUrl = "https://api.pinterest.com/v1/urls/count.json?callback=receiveCount&url=$url";

                    $curl = curl_init();
                    curl_setopt($curl, CURLOPT_URL, $fetchUrl);
                    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($curl, CURLOPT_HTTPHEADER, ['Content-type: application/json']);
                    $curl_results = curl_exec($curl);
                    curl_close($curl);

                    if (($curl !== false) && ($curl_results !== false)) {
                        // no cUrl issues
                        $pincount = json_decode(preg_replace('/^receiveCount\((.*)\)$/', "\\1", $curl_results));
                        $count    = $pincount->count;
                    }

                    echo isset($count) ? intval($count) : 0;
                    break;

                case "xing":
                    $xingcount = file_get_contents('https://www.xing-share.com/app/share?op=get_share_button;counter=top;url=' . $url);
                    preg_match('/xing-count(.+?)(\d+)(.*?)<\/span>/', $xingcount, $matches);

                    $count = $matches[2];
                    echo isset($count) ? intval($count) : 0;
                    break;

                case "stumbleupon":
                    $json_string = file_get_contents("http://www.stumbleupon.com/services/1.01/badge.getinfo?url=$url&format=json");
                    $json        = json_decode($json_string, true);

                    if (isset($json['result']['views'])) {
                        $count = $json['result']['views'];
                        echo isset($count) ? intval($count) : 0;
                    } else {
                        echo 0;
                    }

                    break;

                case "mailru":
                    // Mail.ru requires the http:// or https:// to be removed from the url:
                    $removeChar = ["https://", "http://"];
                    $url = str_replace($removeChar, "", $url);
                    $json_string = file_get_contents("https://appsmail.ru/share/count/$url&format=json");
                    $json        = json_decode($json_string, true);

                    $count = $json['share_mm'];
                    echo isset($count) ? intval($count) : 0;
                    break;

                case "tumblr":
                    $fetchUrl = "https://api.tumblr.com/v2/share/stats?url=$url";

                    $curl = curl_init();
                    curl_setopt($curl, CURLOPT_URL, $fetchUrl);
                    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($curl, CURLOPT_HTTPHEADER, ['Content-type: application/json']);
                    $curl_results = curl_exec($curl);
                    curl_close($curl);

                    if (($curl !== false) && ($curl_results !== false)) {
                        // no cUrl issues
                        $json = json_decode($curl_results, true);
                    } else {
                        $json = json_decode(file_get_contents($fetchUrl), true);
                    }

                    // $json        = json_decode($json_string, true);

                    $count = $json['response']['note_count'];
                    echo isset($count) ? intval($count) : 0;
                    break;

                case "vk":
                    $data  = file_get_contents("http://vk.com/share.php?act=count&url=$url");
                    $count = [];

                    preg_match('/^VK\.Share\.count\(\d, (\d+)\);$/i', $data, $count);
                    $count = $count[1];

                    echo isset($count) ? intval($count) : 0;
                    break;

                case "odnoklassniki":
                    $data  = file_get_contents("http://www.odnoklassniki.ru/dk?st.cmd=extLike&uid=odklcnt0&ref=$url");
                    $count = [];

                    preg_match('/^ODKL\.updateCount\(\'odklcnt0\',\'(\d+)\'\);$/i', $data, $count);
                    $count = (int) $count[1];

                    echo isset($count) ? intval($count) : 0;
                    break;

                case "buffer":
                    $json_string = file_get_contents("https://api.bufferapp.com/1/links/shares.json?url=$url&format=json");
                    $json        = json_decode($json_string, true);

                    $count = $json['shares'];
                    echo isset($count) ? intval($count) : 0;
                    break;

                default:
                    $decodedUrl = urldecode($url);

                    $db    = JFactory::getDbo();
                    $query = $db->getQuery(true)
                        ->select('COUNT(*) AS count')
                        ->from($db->quoteName('#__ampz_stats'))
                        ->where($db->quoteName('url') . ' = ' . $db->quote($decodedUrl))
                        ->where($db->quoteName('network') . ' = ' . $db->quote($network));

                    $db->setQuery($query);
                    $count = $db->loadRow('count');

                    echo isset($count[0]) ? intval($count[0]) : 0;
                    break;
            }
        }
    }
}
