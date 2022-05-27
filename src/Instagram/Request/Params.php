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
 * Params
 *
 * Functionality and defines for the Instagram Graph API query parameters.
 *
 * @package     instagram-graph-api
 * @author      Justin Stolpe
 * @link        https://github.com/jstolpe/instagram-graph-api
 * @license     https://opensource.org/licenses/MIT
 * @version     1.0
 */
class Params {
    const ACCESS_TOKEN = 'access_token';
    const AFTER = 'after';
    const CAPTION = 'caption';
    const CHILDREN = 'children';
    const COMMENT_ENABLED = 'comment_enabled';
    const COMMENT_ID = 'comment_id';
    const CREATION_ID = 'creation_id';
    const FIELDS = 'fields';
    const HIDE = 'hide';
    const IMAGE_URL = 'image_url';
    const IS_CAROUSEL_ITEM = 'is_carousel_item';
    const LIMIT = 'limit';
    const LOCATION_ID = 'location_id';
    const MEDIA_ID = 'media_id';
    const MEDIA_TYPE = 'media_type';
    const MESSAGE = 'message';
    const METRIC = 'metric';
    const NEXT = 'next';
    const PERIOD = 'period';
    const PREV = 'prev';
    const PREVIOUS = 'previous';
    const Q = 'q';
    const SINCE = 'since';
    const THUMB_OFFSET = 'thumb_offset';
    const UNTIL = 'until';
    const USER_ID = 'user_id';
    const USER_TAGS = 'user_tags';
    const VIDEO_URL = 'video_url';    

    /**
     * Get fields for a request.
     * 
     * @param array $fields list of fields for the request.
     * @param boolean $commaImplode to implode the array or not to implode the array.
     * @return array fields array with comma separated string.
     */
    public static function getFieldsParam( $fields, $commaImplode = true ) {
        return array( // return fields param
            self::FIELDS => $commaImplode ? self::commaImplodeArray( $fields ) : $fields
        );
    }

    /**
     * Turn array into a comma separated string.
     * 
     * @param array $array elements to be comma separated.
     * @return string comma separated list of fields
     */
    public static function commaImplodeArray( $array = array() ) {
        // imploded string on commas and return
        return implode( ',', $array );
    }
}

?>