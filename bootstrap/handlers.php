<?php 

// DIC configuration
$container = $app->getContainer();

/*
|--------------------------------------------------------------------------
| Custom Exception handler
|--------------------------------------------------------------------------
| Exception 的抛错方式转为 Json 形式，常用与 API开发，可以输出错误页面
|
*/
$container['errorHandler'] = function ($c) {
    return function ($request, $response, $exception) use ($c) {
        return $c['response']->withJson(['code' => $exception->getCode(), 'message' => $exception->getMessage()]);
    };
};

/*
|--------------------------------------------------------------------------
| Custom Not Found handler
|--------------------------------------------------------------------------
| 404 的抛错方式转为 Json 形式，常用与 API开发，可以输出错误页面
|
*/
$container['notFoundHandler'] = function ($c) {
    return function ($request, $response) use ($c) {
        return $c['response']->withStatus(404)
				             ->withJson(['code' => 404, 'message' => 'Route not found']);
    };
};

/*
|--------------------------------------------------------------------------
| Custom Not Allowed handler
|--------------------------------------------------------------------------
| 405 的抛错方式转为 Json 形式，常用与 API开发，可以输出错误页面
|
*/
$container['notAllowedHandler'] = function ($c) {
    return function ($request, $response, $methods) use ($c) {
        return $c['response']->withStatus(405)
				             ->withJson(['code' => 405, 'message' => 'Method not allowed. Must be one of: ' . implode(', ', $methods)]);
    };
};

/*
|--------------------------------------------------------------------------
| System Error Handler
|--------------------------------------------------------------------------
| 500 的抛错方式转为 Json 形式，常用与 API开发，可以输出错误页面
|
*/
$container['errorHandler'] = function ($c) {
    return function ($request, $response, $methods) use ($c) {
        return $c['response']->withStatus(500)
                             ->withJson(['code' => 500, 'message' => 'Something went wrong!']);
    };
};

/*
|--------------------------------------------------------------------------
| PHP Runtime Error Handler
|--------------------------------------------------------------------------
| 500 的抛错方式转为 Json 形式，常用与 API开发，可以输出错误页面
|
*/
$container['phpErrorHandler'] = function ($c) {
    return function ($request, $response, $methods) use ($c) {
        return $c['response']->withStatus(500)
                             ->withJson(['code' => 500, 'message' => 'Something went wrong!']);
    };
};
