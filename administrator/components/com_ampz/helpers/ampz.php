<?php

/**
 * @version    4.1.1
 * @package    AMPZ
 * @author     roosterz.nl <roy@roosterz.nl>
 * @copyright  2022 roosterz.nl
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */
// No direct access
defined('_JEXEC') or die;

/**
 * Ampz helper.
 *
 * @since  1.6
 */
class AmpzHelper
{
    public static function checkTAGZNotInstalled()
    {
        $tagz_path = JPATH_BASE . '/components/com_tagz';

        if (file_exists($tagz_path)) {
            if (JComponentHelper::isEnabled('com_tagz', true)) {
                return false;
            } else {
                return true;
            }
        } else {
            return false;
        }
    }

    public static function addBackendCSS()
    {
        $document = JFactory::getDocument();

        $document->addStyleSheet(JUri::root() . 'administrator/components/com_ampz/assets/css/ampz.css');
        $document->addStyleSheet(JUri::root() . 'plugins/system/ampz/ampz/admin/css/rh_admin.css');
        $document->addStyleSheet(JURI::root() . 'plugins/system/ampz/ampz/admin/vendor/labelauty/jquery-labelauty.css');
    }

    public static function addBackendJS()
    {
        $document = JFactory::getDocument();

        $document->addScript(JURI::root() . 'plugins/system/ampz/ampz/admin/js/admin.js');
        $document->addScript(JURI::root() . 'plugins/system/ampz/ampz/admin/vendor/labelauty/jquery-labelauty.js');
        $document->addScript(JURI::root() . 'plugins/system/ampz/ampz/admin/vendor/nestable/jquery.nestable.js');

        $document->addScriptDeclaration('
        	window.twttr = (function (d, s, id) {
        	  var t, js, fjs = d.getElementsByTagName(s)[0];
        	  if (d.getElementById(id)) return;
        	  js = d.createElement(s); js.id = id;
        	  js.src= "https://platform.twitter.com/widgets.js";
        	  fjs.parentNode.insertBefore(js, fjs);
        	  return window.twttr || (t = { _e: [], ready: function (f) { t._e.push(f) } });
        	}(document, "script", "twitter-wjs"));
        ');
    }

    public static function addBackendJSDashboard()
    {
        $document = JFactory::getDocument();

        $document->addScript(JUri::root() . 'administrator/components/com_ampz/assets/js/ChartNew.js');
        $document->addScript(JUri::root() . 'administrator/components/com_ampz/assets/js/annotate.js');
    }

    public static function getAmpzPluginUrl()
    {
        $db = JFactory::getDbo();

        $query = $db->getQuery(true)
            ->select('*')
            ->from($db->quoteName('#__extensions'))
            ->where($db->quoteName('type') . ' = ' . $db->quote('plugin'))
            ->where($db->quoteName('folder') . ' = ' . $db->quote('system'))
            ->where($db->quoteName('element') . ' = ' . $db->quote('ampz'));
        $db->setQuery($query);
        $plugin = $db->loadObject();

        $ampz_plugin_url = 'index.php?option=com_plugins&task=plugin.edit&extension_id=' . $plugin->extension_id;

        return $ampz_plugin_url;
    }

    public static function getTotalAmpzClicks()
    {
        $db = JFactory::getDbo();

        $query = $db->getQuery(true)
            ->select('COUNT(*)')
            ->from($db->quoteName('#__ampz_stats'));
        $db->setQuery($query);
        $total_ampz_clicks = $db->loadResult();

        return $total_ampz_clicks;
    }

    public static function getAmpzPositionPercentages()
    {
        $total_ampz_clicks = intval(AmpzHelper::getTotalAmpzClicks());

        $db = JFactory::getDbo();

        $query = $db->getQuery(true)
            ->select('position, COUNT(position) AS count')
            ->from($db->quoteName('#__ampz_stats'))
            ->group($db->quoteName('position'));
        $db->setQuery($query);
        $row = $db->loadAssocList('position');

        $inline_top_perc = isset($row['inline_top']['count']) ? round((intval($row['inline_top']['count']) / $total_ampz_clicks) * 100) : 0;
        $inline_bottom_perc = isset($row['inline_bottom']['count']) ? round((intval($row['inline_bottom']['count']) / $total_ampz_clicks) * 100) : 0;
        $sidebar_perc = isset($row['sidebar']['count']) ? round((intval($row['sidebar']['count']) / $total_ampz_clicks) * 100) : 0;
        $flyin_perc = isset($row['flyin']['count']) ? round((intval($row['flyin']['count']) / $total_ampz_clicks) * 100) : 0;
        $mobile_perc = isset($row['inline_mobile']['count']) ? round((intval($row['inline_mobile']['count']) / $total_ampz_clicks) * 100) : 0;
        $shortcode_perc = isset($row['shortcode']['count']) ? round((intval($row['shortcode']['count']) / $total_ampz_clicks) * 100) : 0;

        $percentages = array("inline_top" => $inline_top_perc, "inline_bottom" => $inline_bottom_perc, "sidebar" => $sidebar_perc, "flyin" => $flyin_perc, "inline_mobile" => $mobile_perc, "shortcode" => $shortcode_perc);

        return $percentages;
    }

    public static function getAmpzTopContentAllTime()
    {
        $db = JFactory::getDbo();

        $query = $db->getQuery(true)
            ->select('title, COUNT(url) AS count')
            ->from($db->quoteName('#__ampz_stats'))
            ->group($db->quoteName('title'))
            ->order('count DESC');
        $db->setQuery($query);
        $rows = $db->loadAssocList();

        $html = '
        <!-- Start Top Content All Time -->
            <table class="ampz_stats">
                <tr>
                    <th>Title</th>
                    <th class="count">Number of Shares</th>
                </tr>';

        if (!empty($rows)) {
            $numberOfTitles = count($rows); // Get the number of results
            $numberOfTitles > 10 ? $num_rows = 10 : $num_rows = $numberOfTitles; // Only show the top 10 or less

            for ($x = 0; $x < $num_rows; $x++) {
                $html .= '
                <tr>
                    <td>' . urldecode($rows[$x]['title']) . '</td>
                    <td class="count">' . $rows[$x]['count'] . '</td>
                </tr>';
            }
            $html .= '</table>';
        } else {
            $html = JText::_('COM_AMPZ_NO_DATA');
        }

        return $html;
    }

    public static function getNetworkColor($network)
    {
        $network_colors = array(
            'facebook' => '#3A579A',
            'twitter' => '#00abf0',
            'linkedin' => '#127bb6',
            'copy' => '#444',
            'pinterest' => '#cd1c1f',
            'whatsapp' => '#4dc247',
            'tiktok' => '#010101',
            'blogger' => '#f57c00',
            'livejournal' => '#09C',
            'mailru' => '#ff9e00',
            'yummly' => '#e26326',
            'fb-messenger' => '#0d87ff',
            'gmail' => '#dd4b39',
            'line' => '#00b900',
            'flipboard' => '#df252c',
            'viber' => '#7d539d',
            'houzz' => '#7bc043',
            'odnoklassniki' => '#EE8208',
            'telegram' => '#0088cc',
            'xing' => '#026466',
            'stumbleupon' => '#f74425',
            'reddit' => '#ff5700',
            'tumblr' => '#32506d',
            'flattr' => '#8cb55b',
            'phone' => '#6df857',
            'print' => '#999',
            'email' => '#999',
            'love' => '#f14d65',
            'pocket' => '#EE4055',
            'buffer' => '#111',
            'vk' => '#507299',
            'mix' => '#ff8226',
            'microsoft-teams' => '#595aad'
        );

        return $network_colors[$network];
    }

    public static function resetAmpzStatistics()
    {
        // $db = JFactory::getDbo();
        //
        // $query = $db->getQuery(true)
        // 	->select('network, COUNT(network) AS count')
        // 	->from($db->quoteName('#__ampz_stats'))
        //     ->group($db->quoteName('network'));
        // $db->setQuery($query);
    }

    public static function getAmpzNetworkPercentages()
    {
        $total_ampz_clicks = intval(AmpzHelper::getTotalAmpzClicks());

        $db = JFactory::getDbo();

        $query = $db->getQuery(true)
            ->select('network, COUNT(network) AS count')
            ->from($db->quoteName('#__ampz_stats'))
            ->group($db->quoteName('network'));
        $db->setQuery($query);
        $rows = $db->loadAssocList('network');

        if (!empty($rows)) {
            $script = "<script>

            var data_networks = [
            ";

            foreach ($rows as $itemrow) {
                $network = $itemrow['network'];
                $count = $itemrow['count'];
                $color = AmpzHelper::getNetworkColor($network);

                $script .= "
                    {
                        value : $count,
                        color: \"$color\",
                        title : \"$network\"
                    },";
            }

            $script .= "];

                var opt_networks = {
                      animateRotate : true,
                      legend: true,
                      legendBorders: false,
                      animationSteps : 100,
                      responsive: true,
                      inGraphDataShow : false,
                      animationEasing: \"linear\",
                      annotateDisplay : true,
                      inGraphDataFontFamily: \"Open Sans\",
                      segmentStrokeWidth: 3,
                      spaceBetweenBar : 5,
                }

                document.write('<canvas id=\"canvas_networks\" height=\"250\" width=\"600\"></canvas>');

                </script>

                ";
        } else {
            $script = JText::_('COM_AMPZ_NO_DATA');
        }

        return $script;
    }

    public static function getAmpzLastMonthShareStats()
    {
        $db = JFactory::getDbo();

        $query = $db->getQuery(true)
            ->select('DATE(date_time) AS date, network, COUNT(network) AS count')
            ->from($db->quoteName('#__ampz_stats'))
            ->where($db->quoteName('date_time') . ' >= now()-INTERVAL 30 DAY')
            ->group($db->quoteName(array('network', 'date')))
            ->order($db->quoteName('network'));
        $db->setQuery($query);
        $rows = $db->loadAssocList();

        if (!empty($rows)) {
            $last30days = array();
            for ($i = 30; $i >= 0; $i--) {
                $last30days[] = "'" . date("d M", strtotime('-'. $i .' days')) . "'";
            }

            $last30days_str = implode(",", $last30days);

            $query_networks = $db->getQuery(true)
                ->select('network')
                ->from($db->quoteName('#__ampz_stats'))
                ->group($db->quoteName('network'));
            $db->setQuery($query_networks);
            $network_rows = $db->loadAssocList('network');

            // Initialize used networks with the keys of last 30 days
            $stats = array();
            foreach ($network_rows as $network) {
                foreach ($last30days as $day) {
                    $stats[$network['network']][$day] = 0;
                }
            }

            $script = "<script>

            var data_last_month = {
                labels : [" . $last30days_str ."],
            	datasets : [";

            foreach ($rows as $itemrow) {
                $network = $itemrow['network'];
                $count = $itemrow['count'];
                $date = "'" . strval(date_format(date_create($itemrow['date']), 'd M')) . "'";

                $stats[$network][$date] = $count;
            }

            foreach ($stats as $network => $data) {
                $color = AmpzHelper::getNetworkColor($network);
                $counts = implode(",", $data);

                $script .= "
                    {
                        fillColor: \"$color\",
                        strokeColor: \"$color\",
                        pointColor: \"$color\",
                        pointStrokeColor : \"#fff\",
                        data: [$counts],
                        title : \"$network\"
                    },";
            }

            $script .= "]

            };

            var opt_last_month = {
                yAxisMinimumInterval : 1,
                annotateDisplay : true,
                annotateBackgroundColor : \"rgba(0,0,0,0.6)\",
                annotateBorderRadius: \"3px\",
                annotatePadding: \"10px\",
                annotateFontFamily: \"Open Sans\",
                annotateFontSize: \"10px\",
                animationLeftToRight: true,
                legendBorders: false,
                animationSteps : 100,
                animationEasing: \"linear\",
                inGraphDataFontFamily: \"Open Sans\",
                responsive: true,
                legend : true
            }

            document.write('<canvas id=\"canvas_last_month\" height=\"500\" width=\"1200\"></canvas>');

            </script>

            ";
        } else {
            $script = JText::_('COM_AMPZ_NO_DATA');
        }

        return $script;
    }

    public static function getAmpzLastMonthShareCount()
    {
        $db = JFactory::getDbo();

        $query = $db->getQuery(true)
            ->select('COUNT(*) AS count')
            ->from($db->quoteName('#__ampz_stats'))
            ->where($db->quoteName('date_time') . ' >= now()-INTERVAL 30 DAY');
        $db->setQuery($query);
        $count = $db->loadRow('count');

        return $count[0];
    }

    /**
     * Display field help text as tooltip in Joomla 4
     *
     * @return void
     */
    public static function fixFieldTooltips()
    {
        // Run once
        static $run;

        if ($run) {
            return;
        }

        $run = true;

        $doc = \JFactory::getDocument();

        $doc->addStyleDeclaration('
            .form-text, .form-control-feedback {
                display:none;
            }
            .tooltip .arrow:before {
                border-top-color:#444;
                border-bottom-color:#444;
            }
            .tooltip-inner {
                text-align: left;
                background-color: #444;
                padding: 7px 9px;
                max-width:300px;
            }

            label.tTooltip::before, label.hasPopover::before {
                background-color: #ffffff;
                border: 1px solid #c1c1c1;
                border-radius: 100%;
                color: #929292;
                content: "i";
                display: inline-block;
                float: left;
                font-family: georgia;
                font-size: 10px;
                font-weight: bold;
                height: 13px;
                left: 0;
                line-height: 12px;
                position: relative;
                margin-right: 5px;
                text-align: center;
                top: 2px;
                -webkit-transition: all 200ms ease 0s;
                transition: all 200ms ease 0s;
                width: 13px;
            }
        ');

        $doc->addScriptDeclaration('
            document.addEventListener("DOMContentLoaded", function() {
                initPopover();

                document.addEventListener("joomla:updated", initPopover);

                function initPopover(event) {
                    var target = event && event.target ? event.target : document;
                    var fields = target.querySelectorAll(".control-group");

                    fields.forEach(function(field) {
                        var desc = field.querySelector(".form-text");

                        if (desc) {
                            var label = field.querySelector("label");

                            if (label) {
                                label.classList.add("tTooltip");
                                label.setAttribute("title", desc.innerHTML);
                            }
                        }
                    });

                    jQuery(target).find(".tTooltip").tooltip({
                        placement: "top",
                        html: true,
                        delay: {
                            show: 200
                        }
                    });
                }
            });
        ');
    }

    public static function loadCharts()
    {
        return "
            <script>
            window.onload = function()
            {
                var pieNetworks = new Chart(document.getElementById(\"canvas_networks\").getContext(\"2d\")).Pie(data_networks,opt_networks);
                var stackedBarLastMonth = new Chart(document.getElementById(\"canvas_last_month\").getContext(\"2d\")).StackedBar(data_last_month,opt_last_month);
            }
            </script>";
    }
}
