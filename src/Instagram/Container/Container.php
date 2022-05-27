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
namespace Instagram\Container;

// other classes we need to use
use Instagram\Instagram;
use Instagram\Request\Params;
use Instagram\Request\Fields;

/**
 * Container
 *
 * Get info on a container.
 *     - Endpoint Format: GET /{ig-container-id}/?fields={fields}&access_token={access-token}
 *     - Facebook docs: https://developers.facebook.com/docs/instagram-api/reference/ig-container
 * 
 * @package     instagram-graph-api
 * @author      Justin Stolpe
 * @link        https://github.com/jstolpe/instagram-graph-api
 * @license     https://opensource.org/licenses/MIT
 * @version     1.0
 */
class Container extends Instagram {
    /**
     * @var integer $containerId Instagram container id for publishing media.
     */
    protected $containerId;

     /**
     * @var array $fields a list of all the fields we are requesting to get back.
     */
    protected $fields = array(
        Fields::ID,
        Fields::STATUS,
        Fields::STATUS_CODE
    );

    /**
     * Contructor for instantiating a new object.
     *
     * @param array $config for the class.
     * @return void
     */
    public function __construct( $config ) {
        // call parent for setup
        parent::__construct( $config );
        
        // store the user id
        $this->containerId = $config['container_id'];
    }

    /**
     * Get the status of a container.
     *
     * @param array $params params for the GET request.
     * @return Instagram response.
     */
    public function getSelf( $params = array() ) {
        $getParams = array( // parameters for our endpoint
            'endpoint' => '/' . $this->containerId,
            'params' => $params ? $params : Params::getFieldsParam( $this->fields )
        );

        // ig get request
        $response = $this->get( $getParams );

        // return response
        return $response;
    }
}

?>