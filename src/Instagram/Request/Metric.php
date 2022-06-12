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
 * Metric
 *
 * Functionality and defines for the Instagram Graph API metric query parameter.
 *
 * @package     instagram-graph-api-php-sdk
 * @author      Justin Stolpe
 * @link        https://github.com/jstolpe/instagram-graph-api-php-sdk
 * @license     https://opensource.org/licenses/MIT
 * @version     1.0
 */
class Metric {
    const AUDIENCE_CITY = 'audience_city';
    const AUDIENCE_COUNTRY = 'audience_country';
    const AUDIENCE_GENDER_AGE = 'audience_gender_age';
    const AUDIENCE_LOCALE = 'audience_locale';
    const CAROUSEL_ALBUM_ENGAGEMENT = 'carousel_album_engagement';
    const CAROUSEL_ALBUM_IMPRESSIONS = 'carousel_album_impressions';
    const CAROUSEL_ALBUM_REACH = 'carousel_album_reach';
    const CAROUSEL_ALBUM_SAVED = 'carousel_album_saved';
    const CAROUSEL_ALBUM_VIDEO_VIEWS = 'carousel_album_video_views';
    const EMAIL_CONTACTS = 'email_contacts';
    const ENGAGEMENT = 'engagement';
    const EXITS = 'exits';
    const FOLLOWER_COUNT = 'follower_count';
    const GET_DIRECTIONS_LINK = 'get_directions_clicks';
    const IMPRESSIONS = 'impressions';
    const MEDIA_TYPE_CAROUSEL_ALBUM = 'carousel_album';
    const MEDIA_TYPE_IMAGE = 'image';
    const MEDIA_TYPE_STORY = 'story';
    const MEDIA_TYPE_VIDEO = 'video';
    const ONLINE_FOLLOWERS = 'online_followers';
    const PHONE_CALL_CLICKS = 'phone_call_clicks';
    const PROFILE_VIEWS = 'profile_views';
    const REACH = 'reach';
    const REPLIES = 'replies';
    const SAVED = 'saved';
    const TAPS_BACK = 'taps_back';
    const TAPS_FORWARD = 'taps_forward';
    const TEXT_MESSAGE_CLICKS = 'text_message_clicks';
    const VIDEO_VIEWS = 'video_views';
    const WEBSITE_CLICKS = 'website_clicks';
}

?>