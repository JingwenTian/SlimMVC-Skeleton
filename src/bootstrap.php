<?php 

if (PHP_SAPI == 'cli-server') {
    $url  = parse_url($_SERVER['REQUEST_URI']);
    $file = __DIR__ . $url['path'];
    if (is_file($file)) {
        return false;
    }
}

require __DIR__ . '/../vendor/autoload.php';

session_start();

/*
|--------------------------------------------------------------------------
| Create The Application
|--------------------------------------------------------------------------
*/
$settings = require __DIR__ . '/src/settings.php';
$app = new \Slim\App($settings);

/*
|--------------------------------------------------------------------------
| Set up Util functions
|--------------------------------------------------------------------------
*/
require __DIR__ . '/src/utils.php';

/*
|--------------------------------------------------------------------------
| Set up Dependencies
|--------------------------------------------------------------------------
*/
require __DIR__ . '/src/dependencies.php';

/*
|--------------------------------------------------------------------------
| Register Middleware
|--------------------------------------------------------------------------
*/
require __DIR__ . '/src/middleware.php';


/*
|--------------------------------------------------------------------------
| Load The Application Routes
|--------------------------------------------------------------------------
*/
$routers = glob(__DIR__ . '/../routers/*.router.php');
foreach ($routers as $router) {
    require $router;
}

return $app;