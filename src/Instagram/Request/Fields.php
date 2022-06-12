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

// other classes we need to use
use Instagram\Request\Params;

/**
 * Fields
 *
 * Functionality and defines for the Instagram Graph API fields query parameter.
 *
 * @package     instagram-graph-api-php-sdk
 * @author      Justin Stolpe
 * @link        https://github.com/jstolpe/instagram-graph-api-php-sdk
 * @license     https://opensource.org/licenses/MIT
 * @version     1.0
 */
class Fields {
	const BIOGRAPHY = 'biography';
	const BUSINESS_DISCOVERY = 'business_discovery';
	const CAPTION = 'caption';
	const CHILDREN = 'children';
	const COMMENT_ID = 'comment_id';
	const COMMENTS = 'comments';
	const COMMENTS_COUNT = 'comments_count';
	const CONFIG = 'config';
	const CURSORS = 'cursors';
	const FOLLOWERS_COUNT = 'followers_count';
	const FOLLOWS_COUNT = 'follows_count';
	const FROM = 'from';
	const HIDDEN = 'hidden';
	const ID = 'id';
	const IG_ID = 'ig_id';
	const INSTAGRAM_BUSINESS_ACCOUNT = 'instagram_business_account';
	const IS_COMMENT_ENABLED = 'is_comment_enabled';
	const LIKE_COUNT = 'like_count';
	const MEDIA = 'media';
	const MEDIA_COUNT = 'media_count';
	const MEDIA_ID = 'media_id';
	const MEDIA_PRODUCT_TYPE = 'media_product_type';
	const MEDIA_TYPE = 'media_type';
	const MEDIA_URL = 'media_url';
	const MENTIONED_COMMENT = 'mentioned_comment';
	const MENTIONED_MEDIA = 'mentioned_media';
	const NAME = 'name';
	const OWNER = 'owner';
	const PAGING = 'paging';
	const PARENT_ID = 'parent_id';
	const PERMALINK = 'permalink';
	const PROFILE_PICTURE_URL = 'profile_picture_url';
	const QUOTA_USAGE = 'quota_usage';
	const REPLIES = 'replies';
	const SHORTCODE = 'shortcode';
	const STATUS = 'status';
	const STATUS_CODE = 'status_code';
	const TEXT = 'text';
	const THUMBNAIL_URL = 'thumbnail_url';
	const TIMESTAMP = 'timestamp';
	const USER = 'user';
	const USERNAME = 'username';
	const VIDEO_TITLE = 'video_title'; 
	const WEBSITE = 'website';

	/**
     * Return a list of all the fields we are requesting to get back for each comment.
     * 
     * @param boolean $commaImplode defaults to always returning a comma imploded list of fields.
     * @return array of fields to request.
     */
    public static function getDefaultCommentFields( $commaImplode = true ) {
    	$defaultFields = array( // fields we can request
	        self::FROM,
	        self::HIDDEN,
	        self::ID,
	        self::LIKE_COUNT,
	        self::MEDIA,
	        self::PARENT_ID,
	        self::TEXT,
	        self::TIMESTAMP,
	        self::USER,
	        self::USERNAME
	    );

    	// return default fields based on flag
	    return $commaImplode ? Params::commaImplodeArray( $defaultFields ) : $defaultFields;
	}

	/**
     * Return a list of all the fields we are requesting to get back for a media post.
     * 
     * @param boolean $commaImplode defaults to always returning a comma imploded list of fields.
     * @return array of fields to request.
     */
    public static function getDefaultMediaFields( $commaImplode = true ) {
    	$defaultFields = array( // fields we can request
	        self::ID,
	        self::CAPTION,
	        self::COMMENTS_COUNT,
	        self::LIKE_COUNT,
	        self::MEDIA_TYPE,
	        self::MEDIA_URL,
	        self::PERMALINK,
	        self::TIMESTAMP,
	        self::THUMBNAIL_URL
	    );

	    // return default fields based on flag
	    return $commaImplode ? Params::commaImplodeArray( $defaultFields ) : $defaultFields;
	}

	/**
     * Return a list of all the fields we are requesting to get back for each of the media objects children.
     * 
     * @param boolean $commaImplode defaults to always returning a comma imploded list of fields.
     * @return array of fields to request.
     */
    public static function getDefaultMediaChildrenFields( $commaImplode = true ) {
    	$defaultFields = array( // fields we can request
	        self::ID,
	        self::MEDIA_TYPE,
	        self::MEDIA_URL
	    );

    	// return default fields based on flag
	    return $commaImplode ? Params::commaImplodeArray( $defaultFields ) : $defaultFields;
	}

	/**
     * Return a list of all the fields we are requesting to get back for each replies.
     * 
     * @param boolean $commaImplode defaults to always returning a comma imploded list of fields.
     * @return array of fields to request.
     */
    public static function getDefaultRepliesFields( $commaImplode = true ) {
    	$defaultFields = array( // fields we can request
	        self::FROM,
	        self::HIDDEN,
	        self::ID,
	        self::LIKE_COUNT,
	        self::MEDIA,
	        self::PARENT_ID,
	        self::TEXT,
	        self::TIMESTAMP,
	        self::USER,
	        self::USERNAME
	    );

    	// return default fields based on flag
	    return $commaImplode ? Params::commaImplodeArray( $defaultFields ) : $defaultFields;
	}

	/**
     * Return a string with all the media fields params for the request.
     * 
     * @return string for the fields parameter.
     */
    public static function getDefaultMediaFieldsString() {
    	return self::getDefaultMediaFields() . ',' .
            self::CHILDREN . '{' .
                self::getDefaultMediaChildrenFields() .
            '},' . 
            self::COMMENTS . '{' .
                self::getDefaultCommentFields() . ',' .
                self::REPLIES . '{' .
                    self::getDefaultRepliesFields() .
                '}' .
            '}'
        ;
	}
}

?>