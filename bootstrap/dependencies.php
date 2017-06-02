<?php 

// DIC configuration
$container = $app->getContainer();

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
    $database = new \Medoo\Medoo($settings);
    return $database;
};