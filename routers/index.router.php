<?php

use lib\Common;
use lib\Tools;

// GET index route
$app->get('/', function () use ($app) {
    $model = new models\User();
    $data = $model->getUsers();
    Common::p($data);
    //$app->render('index.html', array('hello' => $hello));
});
