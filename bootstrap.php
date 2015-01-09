<?php 

/**
 * Display errors
 */
error_reporting(E_ALL);
ini_set('display_errors', 1);

/**
 * Default timezone & charset
 */
date_default_timezone_set('Asia/Shanghai');
header("Content-Type:text/html;charset=utf-8");

//Flynsarmy/Slim-Monolog
$logger = new \Flynsarmy\SlimMonolog\Log\MonologWriter(array(
    'handlers' => array(
        new \Monolog\Handler\StreamHandler('../logs/'.date('Y-m-d').'.log'),
    ),
));

/**
 * Create app
 */
$app = new \Slim\Slim(array(
    'debug' => true,
    'MODE'  => 'development',
    'log.enabled' => true,
    'log.level' => \Slim\Log::EMERGENCY,
    'log.writer' => $logger,    
    'view' => new \Slim\Views\Twig(), // Setup custom Twig view  
    'templates.path' => '../templates/',
));

$app->view->parserOptions = array(
    'charset' => 'utf-8',
    'cache' => realpath('../templates/cache'),
    'auto_reload' => true,
    'strict_variables' => false,
    'autoescape' => true
);

$app->view->parserExtensions = array(new \Slim\Views\TwigExtension());

$app->add(new \Slim\Middleware\SessionCookie(array(
    'expires' => '180 minutes',
    'path' => '/',
    'domain' => null,
    'secure' => false,
    'httponly' => false,
    'name' => 'slim_session',
    'secret' => 'h5/4jc/)$3kfè4()487HD3d',
    'cipher' => MCRYPT_RIJNDAEL_256,
    'cipher_mode' => MCRYPT_MODE_CBC
)));

// Create monolog logger and store logger in container as singleton 
// (Singleton resources retrieve the same log resource definition each time)
/*$app->container->singleton('log', function () {
    $log = new \Monolog\Logger('slim-skeleton');
    $log->pushHandler(new \Monolog\Handler\StreamHandler('./logs/app.log', \Monolog\Logger::DEBUG));
    return $log;
});*/
