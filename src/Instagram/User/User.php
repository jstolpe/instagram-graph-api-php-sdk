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
namespace Instagram\User;

// other classes we need to use
use Instagram\Instagram;
use Instagram\Request\Params;
use Instagram\Request\Fields;

/**
 * User
 *
 * Get the IG Users info.
 *     - Endpoint Format: GET /{ig-user-id}?fields={fields}&access_token={access-token}
 *     - Facebook docs: https://developers.facebook.com/docs/instagram-api/reference/ig-user
 * 
 * @package     instagram-graph-api-php-sdk
 * @author      Justin Stolpe
 * @link        https://github.com/jstolpe/instagram-graph-api-php-sdk
 * @license     https://opensource.org/licenses/MIT
 * @version     1.0
 */
class User extends Instagram {
    /**
     * @const Instagram endpoint for the request.
     */
    const ENDPOINT = 'me/accounts';

    /**
     * @var string $userId Instagram user id.
     */
    protected $userId;

    /**
     * @var array $fields a list of all the fields we are requesting to get back.
     */
    protected $fields = array(
        Fields::BIOGRAPHY,
        Fields::ID,
        Fields::IG_ID,
        Fields::FOLLOWERS_COUNT,
        Fields::FOLLOWS_COUNT,
        Fields::MEDIA_COUNT,
        Fields::NAME,
        Fields::PROFILE_PICTURE_URL,
        Fields::USERNAME,
        Fields::WEBSITE
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
        $this->userId = isset( $config['user_id'] ) ? $config['user_id'] : '';
    }

    /**
     * Get the users info.
     *
     * @param array $params params for the GET request.
     * @return Instagram response.
     */
    public function getSelf( $params = array() ) {
        $getParams = array( // parameters for our endpoint
            'endpoint' => '/' . $this->userId,
            'params' => $params ? $params : Params::getFieldsParam( $this->fields )
        );

        // ig get request
        $response = $this->get( $getParams );

        // return response
        return $response;
    }

    /**
     * Get the users facebook pages.
     *
     * @param array $params params for the GET request.
     * @return Instagram response.
     */
    public function getUserPages( $params = array() ) {
        $getParams = array( // parameters for our endpoint
            'endpoint' => '/' . self::ENDPOINT,
            'params' => $params
        );

        // ig get request
        $response = $this->get( $getParams );

        // calculate the next link for paging
        $this->calcLinkFromCursor( Params::AFTER, $response, $getParams['endpoint'], $params );

        // calcuate the before link
        $this->calcLinkFromCursor( Params::BEFORE, $response, $getParams['endpoint'], $params );

        // set prev and next links
        $this->setPrevNextLinks( $response );

        // return response
        return $response;
    }
}

?>