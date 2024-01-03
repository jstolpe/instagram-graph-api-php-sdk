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
use Instagram\Request\MediaTypes;

/**
 * Media
 *
 * Handle reading and creating media on the IG user.
 *     - Endpoint Format: GET /{ig-user-id}/media
 *          ?fields={fields}&access_token={access-token}
 *     - Endpoint Format: POST IMAGE /{ig-user-id}/media
 *          ?image_url={image-url}&is_carousel_item={is-carousel-item}&caption={caption}&location_id={location-id}&user_tags={user-tags}&access_token={access-token}
 *     - Endpoint Format: POST VIDEO /{ig-user-id}/media
 *          ?media_type=VIDEO&video_url={video-url}&is_carousel_item={is-carousel-item}&caption={caption}&location_id={location-id}&thumb_offset={thumb-offset}&access_token={access-token}
 *     - Endpoint Format: POST CAROUSEL /{ig-user-id}/media 
 *          ?media_type={media-type}&caption={caption}&location_id={location-id}&children={children}&access_token={access-token}
 *     - Facebook docs: https://developers.facebook.com/docs/instagram-api/reference/ig-user/media
 * 
 * @package     instagram-graph-api-php-sdk
 * @author      Justin Stolpe
 * @link        https://github.com/jstolpe/instagram-graph-api-php-sdk
 * @license     https://opensource.org/licenses/MIT
 * @version     1.0
 */
class Media extends User {
    /**
     * @const Instagram endpoint for the request.
     */
    const ENDPOINT = 'media';

    /**
     * Contructor for instantiating a new object.
     *
     * @param array $config for the class.
     * @return void
     */
    public function __construct( $config ) {
        // call parent for setup
        parent::__construct( $config );
    }

    /**
     * Create a container for posting an image.
     *
     * @param array $params params for the POST request.
     * @return Instagram response.
     */
    public function create( $params ) {
        $postParams = array( // parameters for our endpoint
            'endpoint' => '/' . $this->userId . '/' . self::ENDPOINT,
            'params' => $params ? $params : array()
        );

        if ( isset( $params[Params::VIDEO_URL] ) && !isset( $postParams['params'][Params::MEDIA_TYPE] ) ) { // video container requires more params and to not overide  in case REELS is passed
            $postParams['params'][Params::MEDIA_TYPE] = MediaTypes::VIDEO;    
        } elseif ( isset( $params[Params::CHILDREN] ) ) { // carousel container requires more params
            $postParams['params'][Params::MEDIA_TYPE] = MediaTypes::CAROUSEL;
        }

        // ig get request
        $response = $this->post( $postParams );

        // return response
        return $response;
    }

    /**
     * Get the users media.
     *
     * @param array $params params for the GET request.
     * @return Instagram response.
     */
    public function getSelf( $params = array() ) {
        $getParams = array( // parameters for our endpoint
            'endpoint' => '/' . $this->userId . '/' . self::ENDPOINT,
            'params' => $this->getParams( $params ), //$params ? $params : Params::getFieldsParam( $this->fields )
        );

        // ig get request
        $response = $this->get( $getParams );

        // return response
        return $response;
    }

    /**
     * Get params for the request.
     *
     * @param array $params specific params for the request.
     * @return array of params for the request.
     */
    public function getParams( $params = array() ) {
        if ( $params ) { // specific params have been requested
            return $params;
        } else { // get all params
            // get field params
            $params[Params::FIELDS] = Fields::getDefaultMediaFieldsString();

            // return our params
            return $params;
        }
    }
}

?>
