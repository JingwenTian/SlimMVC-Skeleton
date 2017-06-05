<?php 

$app->group('/management', function () {
	$this->get('', 'App\controller\backend\HomeController:dashboard')->setName('backend.home');
    $this->get('/dashboard', 'App\controller\backend\HomeController:dashboard')->setName('backend.dashboard');
    $this->get('/components', 'App\controller\backend\HomeController:components')->setName('backend.components');
    $this->get('/icons', 'App\controller\backend\HomeController:icons')->setName('backend.icons');
    $this->get('/widgets', 'App\controller\backend\HomeController:widgets')->setName('backend.widgets');
    $this->get('/charts', 'App\controller\backend\HomeController:charts')->setName('backend.charts');
    $this->get('/pages', 'App\controller\backend\HomeController:pages')->setName('backend.pages');

});