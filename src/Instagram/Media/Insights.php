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
namespace Instagram\Media;

// other classes we need to use
use Instagram\Instagram;
use Instagram\Request\Params;
use Instagram\Request\Fields;
use Instagram\Request\Metric;

/**
 * Insights
 *
 * Get insights on a specific media.
 *     - Endpoint Format: GET /{ig-media-id}/insights?access_token={access-token}
 *     - Facebook docs: https://developers.facebook.com/docs/instagram-api/reference/ig-media/insights
 * 
 * @package     instagram-graph-api-php-sdk
 * @author      Justin Stolpe
 * @link        https://github.com/jstolpe/instagram-graph-api-php-sdk
 * @license     https://opensource.org/licenses/MIT
 * @version     1.0
 */
class Insights extends Media {
    /**
     * @const Instagram endpoint for the request.
     */
    const ENDPOINT = 'insights';

    /**
     * @var Instagram endpoint for the request.
     */
    protected $mediaType;

    /**
     * @var array $metric a list of all the metrics we are requesting to get back on a certain media type.
     */
    protected $metrics = array(
        Metric::MEDIA_TYPE_CAROUSEL_ALBUM => array(
            Metric::IMPRESSIONS,
            Metric::REACH,
            Metric::CAROUSEL_ALBUM_ENGAGEMENT,
            Metric::CAROUSEL_ALBUM_IMPRESSIONS,
            Metric::CAROUSEL_ALBUM_REACH,
            Metric::CAROUSEL_ALBUM_SAVED,
            Metric::CAROUSEL_ALBUM_VIDEO_VIEWS,
            Metric::ENGAGEMENT,
            Metric::VIDEO_VIEWS,
            Metric::SAVED
        ),
        Metric::MEDIA_TYPE_VIDEO => array(
            Metric::IMPRESSIONS,
            Metric::REACH,
            Metric::ENGAGEMENT,
            Metric::VIDEO_VIEWS,
            Metric::SAVED
        ),
        Metric::MEDIA_TYPE_STORY => array(
            Metric::IMPRESSIONS,
            Metric::REACH,
            Metric::EXITS,
            Metric::REPLIES,
            Metric::TAPS_FORWARD,
            Metric::TAPS_BACK
        )
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

        // set media type so we know what metrics to call for
        $this->mediaType = strtolower( $config['media_type'] );
    }

    /**
     * Get insights on a media post.
     *
     * @param array $params params for the GET request.
     * @return Instagram response.
     */
    public function getSelf( $params = array() ) {
        $getParams = array( // parameters for our endpoint
            'endpoint' => '/' . $this->mediaId . '/' . self::ENDPOINT,
            'params' => $this->getParams( $params )
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
            // set the metrics param
            $params[Params::METRIC] = Params::commaImplodeArray( $this->metrics[$this->mediaType] );

            // return our params
            return $params;
        }
    } 
}

?>