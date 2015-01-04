<?php

/**
 * Define some constants
 */
define("DS", DIRECTORY_SEPARATOR);
define("ROOT", realpath(dirname(__DIR__)) . DS);
define("VENDORDIR", ROOT . "vendor" . DS);
define("ROUTEDIR", ROOT . "routers" . DS);
define("TEMPLATEDIR", ROOT . "templates" . DS);

/**
 * Include autoload file
 */
if (file_exists(VENDORDIR . "autoload.php")) {
    require VENDORDIR . "autoload.php";
} else {
    die("<pre>Run 'php composer.phar install' in root dir</pre>");
}

/**
 * Include bootstrap & config file
 */
require ROOT . DS . 'bootstrap.php';
require ROOT . 'config' . DS . 'config.php';

/**
 * If user is not logged in, he's redirected to login page
 *
 * @param $app
 * @param $settings
 * @return callable
 */
$authenticate = function($app) {
    return function() use ($app) {
        if (!isset($_SESSION['user'])) {
            $app->flash('error', 'Login required');
            $app->redirect('/admin/login');
        }
    };
};

/**
 * If user is logged in, he are not able to visit register page, login page and will be
 * redirected to admin home
 *
 * @param $app
 * @param $settings
 * @return callable
 */
$isLogged = function($app) {
    return function() use ($app) {
        if (isset($_SESSION['user'])) {
            $app->redirect('/admin');
        }
    };
};


/**
 * Include all files located in routes directory
 */
$routers = glob(ROUTEDIR . '*.router.php');
foreach ($routers as $router) {
    require $router;
}

/**
 * Run the application
 */
$app->run();
