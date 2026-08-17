<?php
/* ======================================================
 # Cookies Policy Notification Bar for Joomla! - v4.2.3 (pro version)
 # -------------------------------------------------------
 # For Joomla! CMS (v3.x)
 # Author: Web357 (Yiannis Christodoulou)
 # Copyright (©) 2014-2022 Web357. All rights reserved.
 # License: GNU/GPLv3, http://www.gnu.org/licenses/gpl-3.0.html
 # Website: https:/www.web357.com
 # Demo: https://demo.web357.com/joomla/browse/cookies-policy-notification-bar
 # Support: support@web357.com
 # Last modified: Wednesday 30 March 2022, 03:45:18 PM
 ========================================================= */

namespace GeoIp2\Exception;

/**
 *  This class represents an HTTP transport error.
 */
class HttpException extends GeoIp2Exception
{
    /**
     * The URI queried.
     */
    public $uri;

    public function __construct(
        $message,
        $httpStatus,
        $uri,
        \Exception $previous = null
    ) {
        $this->uri = $uri;
        parent::__construct($message, $httpStatus, $previous);
    }
}
