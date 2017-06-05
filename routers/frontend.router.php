<?php 

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| $app->get('/hello/{name}', 'App\controller\HelloController:hello')->setName('hello');
| $app->getContainer()->get('router')->pathFor('hello', ['name' => 'world']); => /hello/world
|
*/
$app->get('/', 'App\controller\frontend\HomeController:home')->setName('frontend.home');