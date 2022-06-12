<?php

/**
 * Copyright 2022 Justin Stolpe.
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */
namespace Instagram\Request;

/**
 * Request
 *
 * Responsible for setting up the request to the API.
 * 
 * @package     instagram-graph-api-php-sdk
 * @author      Justin Stolpe
 * @link        https://github.com/jstolpe/instagram-graph-api-php-sdk
 * @license     https://opensource.org/licenses/MIT
 * @version     1.0
 */
class Request {
    /**
     * @const string production Graph API URL.
     */
    const BASE_GRAPH_URL = 'https://graph.facebook.com';

    /**
     * @const string production Graph API URL.
     */
    const BASE_AUTHORIZATION_URL = 'https://www.facebook.com';

    /**
     * @const string METHOD_GET HTTP GET method.
     */
    const METHOD_GET = 'GET';

    /**
     * @const string METHOD_POST HTTP POST method.
     */
    const METHOD_POST = 'POST';

    /**
     * @const string METHOD_DELETE HTTP DELETE method.
     */
    const METHOD_DELETE = 'DELETE';

    /**
     * @var string $accessToken the access token to use for this request.
     */
    protected $accessToken;

    /**
     * @var string $method the HTTP method for this request.
     */
    protected $method;

    /**
     * @var string $endpoint the Graph endpoint for this request.
     */
    protected $endpoint;

    /**
     * @var array $params the parameters to send with this request.
     */
    protected $params = array();

    /**
     * @var string $url enptoint url.
     */
    protected $url;

    /**
     * Contructor for instantiating a request..
     *
     * @param string $method the method type for the request.
     * @param string $endpoint the endpoint for the request.
     * @param array  $params the parameters to be sent along with the request.
     * @param string $graphVersion the graph version for the request.
     * @param string $accessToken the access token to go along with the request.
     * @return void
     */
    public function __construct( $method, $endpoint = '', $params = array(), $graphVersion = '', $accessToken = '' ) {
        // set HTTP method
        $this->method = strtoupper( $method );

        // set endptoint
        $this->endpoint = $endpoint;

        // set any params
        $this->params = $params;

        // set access token
        $this->accessToken = $accessToken;

        // set url
        $this->setUrl( $graphVersion );
    }

    /**
     * Set the full url for the request.
     *
     * @param string $graphVersion the graph version we are using.
     * @param string $customUrl custom url for the request.
     * @return void
     */
    public function setUrl( $graphVersion, $customUrl = '' ) {
        // generate the full url
        $this->url = $customUrl ? $customUrl : self::BASE_GRAPH_URL . '/' . $graphVersion . $this->endpoint;

        if ( $this->getMethod() !== Request::METHOD_POST && !$customUrl ) { // not post or custom request so we have work to do
            // get the params
            $params = $this->getParams();

            // build the query string and append to url
            $this->url .= '?' . http_build_query( $params );
        }
    }

    /**
     * Returns the body of the request.
     *
     * @return string
     */
    public function getUrlBody() {
        // get params
        $params = $this->getPostParams();

        return http_build_query( $this->params );
    }  

    /**
     * Return the params for this request.
     *
     * @return array
     */
    public function getParams() {
        if ( $this->accessToken ) { // append access token to params
            $this->params['access_token'] = $this->accessToken;
        }

        // return params array
        return $this->params;
    }

    /**
     * Return the HTTP method for this request.
     *
     * @return string
     */
    public function getMethod() {
        return $this->method;
    }

    /**
     * Only return params on POST requests.
     *
     * @return array
     */
    public function getPostParams() {
        if ( $this->getMethod() === 'POST' ) { // request is a post
            // return the array of params
            return $this->getParams();
        }

        // return emtpy array
        return array();
    }

    /**
     * Return the endpoint URL this request.
     *
     * @return string
     */
    public function getUrl() {
        return $this->url;
    }
}

?>