<?php 

if (PHP_SAPI == 'cli-server') {
    $url  = parse_url($_SERVER['REQUEST_URI']);
    $file = __DIR__ . $url['path'];
    if (is_file($file)) {
        return false;
    }
}

require __DIR__ . '/../vendor/autoload.php';

try {
    (new Dotenv\Dotenv(__DIR__."/../config/".ENV."/"))->load();
} catch (Dotenv\Exception\InvalidPathException $e) {
    die('config load faild');
}

/*
|--------------------------------------------------------------------------
| Create The Application
|--------------------------------------------------------------------------
*/
$settings = require __DIR__ . '/settings.php';
$app = new \Slim\App($settings);

/*
|--------------------------------------------------------------------------
| Set up Error Hanlers
|--------------------------------------------------------------------------
*/
require __DIR__ . '/handlers.php';

/*
|--------------------------------------------------------------------------
| Set up Dependencies
|--------------------------------------------------------------------------
*/
require __DIR__ . '/dependencies.php';

/*
|--------------------------------------------------------------------------
| Register Middleware
|--------------------------------------------------------------------------
*/
require __DIR__ . '/middleware.php';


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