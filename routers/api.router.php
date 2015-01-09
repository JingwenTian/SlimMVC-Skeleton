<?php

/**
 * slim-jsonAPI
 * [example Code]
 * $app->get('/', function() use ($app) {
 *       $app->render(200,array(
 *               'msg' => 'welcome to my API!',
 *           ));
 *   });
 */

use lib\Common;
use lib\Tools;

//regular html response
$app->get('/api', function () use ($app) {
   
    $app->log->info('this is api index router');   
    $app->render('index.html', array('hello' => 'welcome to my API!'));
    
});

//this request will have full json responses
$app->get('/api/user/:id','APIrequest',function($id) use($app){

    //your code here
    
    $app->render(200,array(
        'msg' => 'user found',
    ));

    //Errors
    // $app->render(404,array(
        // 'error' => TRUE,
        // 'msg'   => 'user not found',
    // ));
    
    // if(...) {
        // throw new Exception("Something wrong with your request!");
    // }
    
    
});


