<?php 

// DIC configuration
$container = $app->getContainer();

// Custom Exception handler
$container['errorHandler'] = function ($c) {
    return function ($request, $response, $exception) use ($c) {
        return $c['response']->withJson(['code' => $exception->getCode(), 'message' => $exception->getMessage()]);
    };
};

// Custom Not Found handler
$container['notFoundHandler'] = function ($c) {
    return function ($request, $response) use ($c) {
        return $c['response']->withStatus(404)
				             ->withJson(['code' => 404, 'message' => 'Route not found']);
    };
};

// Custom Not Allowed handler
$container['notAllowedHandler'] = function ($c) {
    return function ($request, $response, $methods) use ($c) {
        return $c['response']->withStatus(405)
				             ->withJson(['code' => 405, 'message' => 'Method not allowed. Must be one of: ' . implode(', ', $methods)]);
    };
};

// Custom Response handler
$container["responseHandeler"] = function($c) {
	return function ($code, $message, array $data = []) use ($c) {
        return $c['response']->withJson(['code' => $code, 'message' => $message, 'data' => $data]);
    };
};

// Custom View Render handler
$container['renderer'] = function ($c) {
    $settings = $c->get('settings')['renderer'];
    return new Slim\Views\PhpRenderer($settings['template_path']);
};

// Custom Logger handler
$container['logger'] = function ($c) {
    $settings = $c->get('settings')['logger'];
    $logger = new Monolog\Logger($settings['name']);
    $logger->pushProcessor(new Monolog\Processor\UidProcessor());
    $logger->pushHandler(new Monolog\Handler\StreamHandler($settings['path'], $settings['level']));
    return $logger;
};

// Db handler
$container['db'] = function ($c) {
	$settings = $c->get('settings')['database'];
	$database = new Medoo\Medoo($settings);
	return $database;
};
