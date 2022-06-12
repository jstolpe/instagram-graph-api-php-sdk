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
namespace Instagram\HashtagSearch;

// other classes we need to use
use Instagram\Instagram;
use Instagram\Request\Params;

/**
 * Hashtag Search.
 *
 * Get the id for a hashtag.
 *     - Endpoint Format: GET /ig_hashtag_search?user_id={user-id}&q={q}&access_toke={access-token}
 *     - Facebook docs: https://developers.facebook.com/docs/instagram-api/reference/ig-hashtag-search
 * 
 * @package     instagram-graph-api-php-sdk
 * @author      Justin Stolpe
 * @link        https://github.com/jstolpe/instagram-graph-api-php-sdk
 * @license     https://opensource.org/licenses/MIT
 * @version     1.0
 */
class HashtagSearch extends Instagram {
    /**
     * @const Instagram endpoint for the request.
     */
    const ENDPOINT = 'ig_hashtag_search';

    /**
     * @var integer $userId Instagram user id making the api request.
     */
    protected $userId;

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
        $this->userId = $config['user_id'];
    }

    /**
     * Get info on a hashtag.
     *
     * @param string $hashtagName name of hashtag to get ID for.
     * @return Instagram response.
     */
    public function getSelf( $hashtagName ) {
        $getParams = array( // parameters for our endpoint
            'endpoint' => '/' . self::ENDPOINT,
            'params' => array(
                Params::USER_ID => $this->userId,
                Params::Q => $hashtagName
            )
        );

        // ig get request
        $response = $this->get( $getParams );

        // return response
        return $response;
    }
}

?>