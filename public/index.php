<?php

ini_set('date.timezone','Asia/Shanghai');

/**
 * Environment Config: 
 * production / release / development
 */
define("ENV", "development");

define("DS", DIRECTORY_SEPARATOR);
define("ROOT", realpath(dirname(__DIR__)) . DS);
define("TEMPLATEDIR", ROOT . "resources" . DS . "views" . DS);

/*
|--------------------------------------------------------------------------
| Create The Application
|--------------------------------------------------------------------------
*/

$app = require __DIR__ . '/../bootstrap/app.php';

/*
|--------------------------------------------------------------------------
| Run The Application
|--------------------------------------------------------------------------
*/

$app->run();