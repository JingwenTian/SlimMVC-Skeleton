<?php

use lib\Config;
use lib\Common;
use lib\Tools;

// GET index route
$app->get('/', function () use ($app) {
    $model = new models\User();
    $data = $model->getUsers();
    
    $app->log->info('this is index router');

    //Common::p($data);
    $app->render('index.html', array('hello' => 'hello slim :-)'));
});

//UPLOAD DEMO
$app->get('/upload', function() use ($app) {
	
	$app->render('upload.html');
});
