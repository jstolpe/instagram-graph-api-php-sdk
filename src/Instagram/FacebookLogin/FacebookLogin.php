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
namespace Instagram\FacebookLogin;

// other classes we need to use
use Instagram\Instagram;
use Instagram\Request\Request;
use Instagram\Request\Params;
use Instagram\Request\ResponseTypes;

/**
 * FacebookLogin
 *
 * Core functionality for login dialog.
 *     - Facebook Docs: https://developers.facebook.com/docs/facebook-login/guides/advanced/manual-flow/
 *
 * @package     instagram-graph-api-php-sdk
 * @author      Justin Stolpe
 * @link        https://github.com/jstolpe/instagram-graph-api-php-sdk
 * @license     https://opensource.org/licenses/MIT
 * @version     1.0
 */
class FacebookLogin extends Instagram {
    /**
     * @const debug token endpoint
     */
    const ENDPOINT = 'dialog/oauth';

    /**
     * @var integer $appId Facebook application id.
     */
    protected $appId;

    /**
     * @var integer $appId Facebook application secret.
     */
    protected $appSecret;

    /**
     * Contructor for instantiating a new object.
     *
     * @param array $config for the class.
     * @return void
     */
    public function __construct( $config = array() ) {
        // call parent for setup
        parent::__construct( $config );

        // set the application id
        $this->appId = $config['app_id'];

        // set the application secret
        $this->appSecret = $config['app_secret'];
    }

    /**
     * Get the url for a user to prompt them with the login dialog.
     *
     * @param string $redirectUri uri the user gets sent to after logging in with facebook.
     * @param array $permissions array of the permissions you want to request from the user.
     * @param string $state this gets passed back from facebook in the redirect uri.
     * @return Instagram response.
     */
    public function getLoginDialogUrl( $redirectUri, $permissions, $state = '' ) {
        $params = array( // params required to generate the login url
            Params::CLIENT_ID => $this->appId,
            Params::REDIRECT_URI => $redirectUri,
            Params::STATE => $state,
            Params::SCOPE => Params::commaImplodeArray( $permissions ),
            Params::RESPONSE_TYPE => ResponseTypes::CODE,
        );

        // return the login dialog url
        return Request::BASE_AUTHORIZATION_URL . '/' . $this->graphVersion . '/' . self::ENDPOINT . '?' . http_build_query( $params );;
    }    
}

?>