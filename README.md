# instagram-graph-api-php-sdk

This repository contains the open source PHP SDK that allows you to access the Instagram Graph API from your PHP app.

## Installation

### Composer

Run this command:

```
composer require jstolpe/instagram-graph-api-php-sdk
```

Require the the autoloader.

```php
require_once __DIR__ . '/vendor/autoload.php'; // change path as needed
```

### No Composer

Get the repository

```
git clone git@github.com:jstolpe/instagram-graph-api-php-sdk.git
```

Require the custom autoloader.

```php
require_once '/instagram-graph-api-php-sdk/src/instagram/autoload.php'; // change path as needed
```

## Usage

Simple GET example of a user's profile and media posts.
```php
use Instagram\User\BusinessDiscovery;

$config = array( // instantiation config params
    'user_id' => '<IG_USER_ID>',
    'username' => '<USERNAME>', // string of the Instagram account username to get data on
    'access_token' => '<ACCESS_TOKEN>',
);

// instantiate business discovery for a user
$businessDiscovery = new BusinessDiscovery( $config );

// initial business discovery
$userBusinessDiscovery = $businessDiscovery->getSelf();
```

Simple POST example of posting an image to an Instagram account.
```php
use Instagram\User\Media;
use Instagram\User\MediaPublish;

$config = array( // instantiation config params
    'user_id' => '<USER_ID>',
    'access_token' => '<ACCESS_TOKEN>',
);

// instantiate user media
$media = new Media( $config );

$imageContainerParams = array( // container parameters for the image post
    'caption' => '<CAPTION>', // caption for the post
    'image_url' => '<IMAGE_URL>', // url to the image must be on a public server
);

// create image container
$imageContainer = $media->create( $imageContainerParams );

// get id of the image container
$imageContainerId = $imageContainer['id'];

// instantiate media publish
$mediaPublish = new MediaPublish( $config );

// post our container with its contents to instagram
$publishedPost = $mediaPublish->create( $imageContainerId );
```

Example of a custom request.
```php
// first we have to instantiate the core Instagram class with our access token
$instagram = new Instagram\Instagram( array(
    'access_token' => '<ACCESS_TOKEN>'
) );

/**
 * Here we are making our request to instagram and specify the endpoint along with our custom params.
 * There is a custom function for get, post, and delete.
 *     $instagram->get()
 *     $instagram->post()
 *     $instagram->delete()
 *
 * Here is the skeleton for the customized call.
 */
$response = $instagram->method( array(
    'endpoint' => '/<ENDPOINT>',
    'params' => array( // query params key/values must match what IG API is expecting for the endpoint
        '<KEY>' => '<VALUE>',
        '<KEY>' => '<VALUE>',
        // ...
    )
) );
```

## Documentation

See the [Wiki](https://github.com/jstolpe/instagram-graph-api-php-sdk/wiki) for the complete documentation.
