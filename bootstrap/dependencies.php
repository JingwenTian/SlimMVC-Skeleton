<?php

// DIC configuration
$container = $app->getContainer();

/*
|--------------------------------------------------------------------------
|  Remove the trailing slash Middleware
|--------------------------------------------------------------------------
| redirect/rewrite all URLs that end in a / to the non-trailing / equivalent
| referer: https://www.slimframework.com/docs/cookbook/route-patterns.html
|
*/
// $app->add(new App\middleware\TrailingSlash());
$app->add(new \Psr7Middlewares\Middleware\TrailingSlash(false));

/*
|--------------------------------------------------------------------------
|  IP address Middleware
|--------------------------------------------------------------------------
| The best way to retrieve the current IP address of the client 
| usage: $request->getAttribute('ip_address');
| referer: https://github.com/akrabat/rka-ip-address-middleware
|
*/
$checkProxyHeaders = true;
$trustedProxies = [];
$app->add(new \RKA\Middleware\IpAddress($checkProxyHeaders, $trustedProxies));

/*
|--------------------------------------------------------------------------
|  IP Restrict Middleware
|--------------------------------------------------------------------------
| restrict ip addresses that will access to your routes
| referer: https://github.com/DavidePastore/Slim-Restrict-Route
|
*/
$allowIpOptions = ['ip' => null]; // '192.*.*.*'
$app->add(new \DavidePastore\Slim\RestrictRoute\RestrictRoute($allowIpOptions));


/*
|--------------------------------------------------------------------------
|  HTTP Caching Middleware
|--------------------------------------------------------------------------
| create and return responses that contain Cache, Expires, ETag, and Last-Modified headers 
| that control when and how long application output is retained by client-side caches.
| 
| referer: https://www.slimframework.com/docs/features/caching.html
|
*/
$container['cache'] = function () {
    return new \Slim\HttpCache\CacheProvider();
};
$app->add(new \Slim\HttpCache\Cache('public', 86400));

/*
|--------------------------------------------------------------------------
| CSRF Protection
|--------------------------------------------------------------------------
| CSRF protection middleware
|
*/
$container['csrf'] = function ($c) {
    return new \Slim\Csrf\Guard;
};

/*
|--------------------------------------------------------------------------
| Flash Messages
|--------------------------------------------------------------------------
| Flash messages service provider
|
*/
$container['flash'] = function () {
    return new \Slim\Flash\Messages();
};

/*
|--------------------------------------------------------------------------
| Custom View Render handler
|--------------------------------------------------------------------------
| 注册视图模板
|
*/
$container['view'] = function ($c) {
    $settings = $c->get('settings')['renderer'];
    return new \Slim\Views\PhpRenderer($settings['template_path']);
};

/*
|--------------------------------------------------------------------------
| Custom Logger handler
|--------------------------------------------------------------------------
| 日志记录方式注册
|
*/

$container['logger'] = function ($c) {
    $settings = $c->get('settings')['logger'];
    $logger = new \Monolog\Logger($settings['name']);
    $logger->pushProcessor(new \Monolog\Processor\UidProcessor());
    $logger->pushHandler(new \Monolog\Handler\StreamHandler($settings['path'], $settings['level']));
    return $logger;
};

/*
|--------------------------------------------------------------------------
| Db handler
|--------------------------------------------------------------------------
| 日志记录方式注册
|
*/
$container['db'] = function ($c) {
    $settings = $c->get('settings')['database'];
    $database = \App\helper\Database\Database::getInstance($settings);
    return $database;
};

/*
|--------------------------------------------------------------------------
| Cache handler
|--------------------------------------------------------------------------
| 注册缓存, 此处应用 Redis
|
*/
$container['cache'] = function ($c) {
    $settings = $c->get('settings')['cache'];
    $extends  = [
        'prefix'    => 'cache:'
    ];
    return \App\helper\Database\Cache::getInstance($settings, $extends);
};