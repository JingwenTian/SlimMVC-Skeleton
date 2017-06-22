<?php 

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
*/

$app->group('/shared', function() use ($app) {
	$this->any('/upload', 'App\controller\shared\SharedController:upload');
	$this->any('/captcha', 'App\controller\shared\SharedController:captcha');

});