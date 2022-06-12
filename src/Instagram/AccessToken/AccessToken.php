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
namespace Instagram\AccessToken;

// other classes we need to use
use Instagram\Instagram;
use Instagram\Request\Params;
use Instagram\Request\GrantTypes;

/**
 * AccessToken
 *
 * Core functionality for access tokens.
 *    - Endpoint Format: GET /oauth/access_token?client_id={your-app-id}&client_secret={your-app-secret}&redirect_uri={redirect-uri}&code={code-parameter}
 *    - Endpoint Format: GET /oauth/access_token?client_id={your-app-id}&client_secret={your-app-secret}&grant_type=fb_exchange_token&fb_exchange_token={access-token}
 *    - Endpoint Format: GET /debug_token?input_token={access-token}&access_token={access-token}
 *    - Endpoint Format: GET|DELETE /{ig-user-id}/permissions/{permission-name}?access_token={access-token}
 *    - Facebook Docs: https://developers.facebook.com/docs/facebook-login/guides/access-tokens
 * 
 * @package     instagram-graph-api-php-sdk
 * @author      Justin Stolpe
 * @link        https://github.com/jstolpe/instagram-graph-api-php-sdk
 * @license     https://opensource.org/licenses/MIT
 * @version     1.0
 */
class AccessToken extends Instagram {
    /**
     * @const debug token endpoint
     */
    const ENDPOINT_DEBUG = 'debug_token';

    /**
     * @const token permissions endpoint
     */
    const ENDPOINT_PERMISSIONS = 'permissions';

    /**
     * @const access token endpoint.
     */
    const ENDPOINT_TOKEN = 'oauth/access_token';

    /**
     * @var integer $appId Facebook application id.
     */
    protected $appId;

    /**
     * @var integer $appId Facebook application secret.
     */
    protected $appSecret;

    /**
     * @var integer $expiresAt time when the access token expires.
     */
    protected $expiresAt = 0;

    /**
     * @var string $userId the user id of the access token.
     */
    protected $userId;

    /**
     * @var string $value the access token.
     */
    protected $value;

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
        $this->appId = isset( $config['app_id'] ) ? $config['app_id'] : '';

        // set the application secret
        $this->appSecret = isset( $config['app_secret'] ) ? $config['app_secret'] : '';

        // set the access token
        $this->value = isset( $config['value'] ) ? $config['value'] : '';

        // set the access token expire date
        $this->expiresAt = isset( $config['expires_at'] ) ? $config['expires_at'] : $this->expiresAt;

        // set the user id
        $this->userId = isset( $config['user_id'] ) ? $config['user_id'] : '';
    }

    /**
     * Debug the access token.
     *
     * @return Instagram response.
     */
    public function debug() {
        $getParams = array( // parameters for our endpoint
            'endpoint' => '/' . self::ENDPOINT_DEBUG,
            'params' => array(
                Params::INPUT_TOKEN => $this->value
            )
        );

        // get request
        $response = $this->get( $getParams );

        // return response
        return $response;
    }

    /**
     * Get access token from a code.
     *
     * @param string $code the code from the facebook redirect.
     * @param string $redirectUri uri the user gets sent to after logging in with facebook.
     * @return Instagram response.
     */
    public function getAccessTokenFromCode( $code, $redirectUri ) {
        $getParams = array( // parameters for our endpoint
            'endpoint' => '/' . self::ENDPOINT_TOKEN,
            'params' => array(
                Params::CLIENT_ID => $this->appId,
                Params::CLIENT_SECRET => $this->appSecret,
                Params::REDIRECT_URI => $redirectUri,
                Params::CODE => $code
            )
        );

        // get request
        $response = $this->get( $getParams );

        // set class vars from response data
        $this->setDataFromResponse( $response );

        // return response
        return $response;
    }

    /**
     * Get a long lived access token.
     *
     * @param string $accessToken the access token to exchange for a long lived one.
     * @return Instagram response.
     */
    public function getLongLivedAccessToken( $accessToken ) {
        $getParams = array( // parameters for our endpoint
            'endpoint' => '/' . self::ENDPOINT_TOKEN,
            'params' => array(
                Params::CLIENT_ID => $this->appId,
                Params::CLIENT_SECRET => $this->appSecret,
                Params::FB_EXCHANGE_TOKEN => $accessToken,
                Params::GRANT_TYPE => GrantTypes::FB_EXCHANGE_TOKEN,
                
            )
        );

        // get request
        $response = $this->get( $getParams );

        // set class vars from response data
        $this->setDataFromResponse( $response );

        // return response
        return $response;
    }

    /**
     * Get the permissions a user has for the access token.
     *
     * @return Instagram response.
     */
    public function getPermissions() {
        $getParams = array( // parameters for our endpoint
            'endpoint' => '/' . $this->userId. '/' . self::ENDPOINT_PERMISSIONS
        );

        // get request
        $response = $this->get( $getParams );

        // return response
        return $response;
    }

    /**
     * Check if the access token is long lived or not.
     *
     * @return boolean
     */
    public function isLongLived() {
        // check if expires at meets long lived requirements
        return $this->expiresAt ? $this->expiresAt > time() + ( 60 * 60 * 2 ) : true;
    }

    /**
     * Revoke permissions for a users access token.
     *
     * @param string $permissionName name of the permission to revoke leave blank to revoke all permissions.
     * @return Instagram response.
     */
    public function revokePermissions( $permissionName = '' ) {
        $deleteParams = array( // parameters for our endpoint
            'endpoint' => '/' . $this->userId. '/' . self::ENDPOINT_PERMISSIONS . '/' . $permissionName
        );

        // delete request
        $response = $this->delete( $deleteParams );

        // return response
        return $response;
    }

    /**
     * Set class variables from the token response.
     *
     * @param array $response the response from the api call.
     * @return void
     */
    public function setDataFromResponse( $response ) {
        if ( isset( $response['access_token'] ) ) { // we have an access token
            // set the value from the response
            $this->value = $response['access_token'];

            // set expires at if we have it in the response
            $this->expiresAt = isset( $response['expires_in'] ) ? time() + $response['expires_in'] : 0;
        }
    }
}

?>