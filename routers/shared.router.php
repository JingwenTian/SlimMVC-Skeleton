<?php 

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
*/
$app->group('/shared', function() use ($app) {
	$this->post('/upload', 'App\controller\shared\SharedController:upload');

});