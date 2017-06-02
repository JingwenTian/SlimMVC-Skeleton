<?php 

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
*/
$app->group('/api', function() use ($app) {
	// 获取登录凭证路由
	$this->post('/auth', 'App\controller\AuthController:auth');
	// 测试鉴权路由
	$this->map(['POST', 'GET'], '/dump', 'App\controller\AuthController:dump');

});