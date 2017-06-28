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
$app->get('/test', function () {


    $event = new \App\model\Event\Event();

    $event->update(['id' => 15], ['title' => 'qwqwqwq']);

    var_dump($event->useWrite()->find(15));
    var_dump($event->find(15));
});

$app->get('/', 'App\controller\frontend\HomeController:home')->setName('frontend.home');