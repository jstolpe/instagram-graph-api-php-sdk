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
namespace Instagram;

// other classes to use
use Instagram\Request\Request;
use Instagram\Request\Curl;
use Instagram\Request\Params;
use Instagram\Request\Fields;

/**
 * Instagram
 *
 * Core functionality for talking to the Instagram Graph API.
 *
 * @package     instagram-graph-api-php-sdk
 * @author      Justin Stolpe
 * @link        https://github.com/jstolpe/instagram-graph-api-php-sdk
 * @license     https://opensource.org/licenses/MIT
 * @version     1.0
 */
class Instagram {
    /**
     * @const string Default Graph API version for requests.
     */
    const DEFAULT_GRAPH_VERSION = 'v14.0';

    /**
     * @var string $graphVersion the graph version we want to use.
     */
    protected $graphVersion;

    /**
     * @var object $client the Instagram client service.
     */
    protected $client;

    /**
     * @var string $accessToken access token to use with requests.
     */
    protected $accessToken;

    /**
     * @var Request $request the request to the api.
     */
    protected $request = '';

    /**
     * @var string $pagingNextLink Instagram next page link.
     */
    public $pagingNextLink = '';

    /**
     * @var string $pagingPreviousLink Instagram previous page link.
     */
    public $pagingPreviousLink = '';

    /**
     * Contructor for instantiating a new Instagram object.
     *
     * @param array $config for the class.
     * @return void
     */
    public function __construct( $config ) {
        // set our access token
        $this->setAccessToken( isset( $config['access_token'] ) ? $config['access_token'] : '' );

        // instantiate the client
        $this->client = new Curl();

        // set graph version
        $this->graphVersion = isset( $config['graph_version'] ) ? $config['graph_version'] : self::DEFAULT_GRAPH_VERSION;
    }

    /**
     * Sends a GET request to Graph and returns the result.
     *
     * @param array $params params for the GET request.
     * @return Instagram response.
     */
    public function get( $params ) {
        // check for params
        $endpointParams = isset( $params['params'] ) ? $params['params'] : array();

        // perform GET request
        return $this->sendRequest( Request::METHOD_GET, $params['endpoint'], $endpointParams );
    }

    /**
     * Sends a POST request to Graph and returns the result.
     *
     * @param array $params params for the POST request.
     * @return Instagram response.
     */
    public function post( $params ) {
        // check for params
        $endpointParams = isset( $params['params'] ) ? $params['params'] : array();

        // perform POST request
        return $this->sendRequest( Request::METHOD_POST, $params['endpoint'], $endpointParams );
    }

    /**
     * Sends a DELETE request to Graph and returns the result.
     *
     * @param array $params params for the DELETE request.
     * @return Instagram response.
     */
    public function delete( $params ) {
        // check for params
        $endpointParams = isset( $params['params'] ) ? $params['params'] : array();

        // perform DELETE request
        return $this->sendRequest( Request::METHOD_DELETE, $params['endpoint'], $endpointParams );
    }

    /**
     * Send a request to the Instagram Graph API and returns the result.
     *
     * @param string $method HTTP method.
     * @param string $endpoint endpoint for the request.
     * @param string $params parameters for the endpoint.
     * @return Instagram response.
     */
    public function sendRequest( $method, $endpoint, $params ) {
        // create our request
        $this->request = new Request( $method, $endpoint, $params, $this->graphVersion, $this->accessToken );

        // send the request to the client for processing
        $response = $this->client->send( $this->request );

        // set prev and next links
        $this->setPrevNextLinks( $response );

        // append the request to the response
        $response['debug'] = $this;

        // return the response
        return $response;
    }

    /**
     * Send a custom GET request to the Instagram Graph API and returns the result.
     *
     * @param string $customUrl the entire url for the request.
     * @return Instagram response.
     */
    public function sendCustomRequest( $customUrl ) {
        // create our request
        $this->request = new Request( Request::METHOD_GET );

        // set our custom url for the request
        $this->request->setUrl( $this->graphVersion, $customUrl );

        // return the response
        $response = $this->client->send( $this->request );

        // set prev and next links
        $this->setPrevNextLinks( $response );

        // append the request to the response
        $response['debug'] = $this;

        // return the response
        return $response;
    }

    /**
     * Request previous or next page data.
     *
     * @param string $page specific page to request.
     * @return array of previous or next page data..
     */
    public function getPage( $page ) {
        // get the page to use
        $pageUrl = Params::NEXT == $page ? $this->pagingNextLink : $this->pagingPreviousLink;

        // return the response from the request
        return $this->sendCustomRequest( $pageUrl );
    }

    /**
     * Set previous and next links from the response.
     *
     * @param array &$response response from the api.
     * @return void.
     */
    public function setPrevNextLinks( &$response ) {
        // set paging next/previous links
        $this->pagingNextLink = $response['paging_next_link'] = isset( $response[Fields::PAGING][Params::NEXT] ) ? $response[Fields::PAGING][Params::NEXT] : '';
        $this->pagingPreviousLink = $response['paging_previous_link'] = isset( $response[Fields::PAGING][Params::PREVIOUS] ) ? $response[Fields::PAGING][Params::PREVIOUS] : '';
    }

    /**
     * Set the access token.
     *
     * @param string $accessToken set the access token.
     * @return void.
     */
    public function setAccessToken( $accessToken ) {
        $this->accessToken = $accessToken;
    }

    /**
     * Calculate next link based on the cursors.
     *
     * @param string $type type of link after or before.
     * @param array $response Instagram api response.
     * @param string $endpoint endpoint for the request.
     * @param array $params specific request params.
     * @return void
     */
    public function calcLinkFromCursor( $type, &$response, $endpoint, $params ) {
        if ( isset( $response[Fields::PAGING][Fields::CURSORS][$type] ) ) { // we have paging
            // set the after cursor
            $params[$type] = $response[Fields::PAGING][Fields::CURSORS][$type];

            // create our request
            $request = new Request( Request::METHOD_GET, $endpoint, $params, $this->graphVersion, $this->accessToken );

            // set paging type based
            $pagingOrder = Params::AFTER == $type ? Params::NEXT : Params::PREVIOUS;

            // set paging next to the url for the next request
            $response[Fields::PAGING][$pagingOrder] = $request->getUrl();
        }
    }
}

?>