<?php 

$app->group('/management', function () {
	$this->get('', 'App\controller\backend\HomeController:dashboard')->setName('backend.home');
    $this->get('/dashboard', 'App\controller\backend\HomeController:dashboard')->setName('backend.dashboard');

});