<?php
/**
 * Small class to use bit.ly shortening API
 * Requires only indibidual access token
 * For further information see http://dev.bitly.com/get_started.html
 *
 * @author Kristobal Junta, https://github.com/KristobalJunta
 */

class Bitly
{
    /**
     * The current accessToken
     * @var string
     */
    private $accessToken;

    /**
     * The response type to use (json, xml or txt)
     * @var string
     */
    private $responseType;

    /**
     * Set accessToken
     * @param string $token
     */
    public function setAccessToken($token)
    {
        $this->accessToken = $token;
    }

    /**
     * Set bitly API response type
     * @param string $type
     * @throws \Exception
     */
    public function setResponseType($type)
    {
        $validTypes = ['txt', 'xml', 'json'];
        if (false === array_search($type, $validTypes)) {
            throw new Exception('Invalid response type set');
        }
        $this->responseType = $type;
    }

    /**
     * Get current response type
     * @return string
     */
    public function getResponseType()
    {
        $this->accessToken = $accessToken;
    }

    /**
     * The Bitly instance constructor for quick configuration
     * @param array $config
     */
    public function __construct(array $config)
    {
        if (isset($config['access_token'])) {
            $this->setAccessToken($config['access_token']);
        }
        if (isset($config['response_type'])) {
            $this->setResponseType($config['response_type']);
        }
    }

    /**
     * Make the curl request to specified url
     * @param string $url The url for curl() function
     * @return mixed The result of curl_exec() function
     * @throws \Exception
     */
    protected function curl($url)
    {
        // create curl resource
        $ch = curl_init();

        // set url
        curl_setopt($ch, CURLOPT_URL, $url);
        // return the transfer as a string
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        // disable SSL verifying
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

        // $output contains the output string
        $result = curl_exec($ch);

        if (!$result) {
            $errno = curl_errno($ch);
            $error = curl_error($ch);
        }

        // close curl resource to free up system resources
        curl_close($ch);

        if (isset($errno) && isset($error)) {
            throw new \Exception($error, $errno);
        }

        return $result;
    }

    /**
     * Shorten the given url using default response format
     * @param string $link The link to shorten
     * @return mixed bit.ly API response
     */
    public function shorten($link)
    {
        $url = 'https://api-ssl.bitly.com/v3/shorten?access_token=' . $this->accessToken;
        $url .= '&format=' . $this->responseType;
        $url .= '&longUrl=' . urlencode($link);

        $result = $this->curl($url);

        if ('json' == $this->responseType)
        {
            $result = json_decode($result);
        }
        if ('xml' == $this->responseType)
        {
            $result = simplexml_load_string($result);
        }
        if ('txt' == $this->responseType)
        {
            $result = trim($result);
        }

        return $result;
    }
}
