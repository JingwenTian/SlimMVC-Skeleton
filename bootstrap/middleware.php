<?php 
//Application middleware

use App\helper\Authentication\Token;
use Slim\Middleware\JwtAuthentication;
use Slim\Middleware\HttpBasicAuthentication;

$container = $app->getContainer();

/*
|--------------------------------------------------------------------------
| HTTP Basic Authentication Middleware
|--------------------------------------------------------------------------
| PSR-7 HTTP Basic Authentication Middleware
|
*/
// $container["HttpBasicAuthentication"] = function ($c) {

// 	$settings = $c->get('settings')['httpBasicAuthentication'];

//     return new HttpBasicAuthentication([
//     	"secure" => $settings['secure'],
//     	"relaxed" => $settings['relaxed'],
//         "path" => $settings['path'],
//         "passthrough" => $settings['passthrough'],
//         "error" => function ($request, $response, $arguments) {
//             return $response->withStatus(401)
//                 			->withHeader("Content-type", "application/problem+json")
//                 			->withJson(['code' => 401, 'message' => $arguments["message"]]);
//         },
//         "callback" => function ($request, $response, $arguments) {
// 	    },
//         "users" => $settings['users']
//     ]);
// };
// $app->add("HttpBasicAuthentication");


/*
|--------------------------------------------------------------------------
| JWT Authentication Middleware
|--------------------------------------------------------------------------
| PSR-7 JWT Authentication Middleware
|
*/

$container["token"] = function ($c) {
    return new Token;
};

$container["JwtAuthentication"] = function ($c) {

	$settings = $c->get('settings')['jwtAuthentication'];

    return new JwtAuthentication([
    	"secure" => $settings['secure'],
    	"relaxed" => $settings['relaxed'],
        "path" 	=> $settings['path'],
        "passthrough" => $settings['passthrough'],
        "secret" => $settings['secret'],
        "cookie" => $settings['cookie'],
        "logger" => $c["logger"],
        "error" => function ($request, $response, $arguments) {
            return $response->withStatus(401)
                			->withHeader("Content-type", "application/problem+json")
                			->withJson(['code' => 401, 'message' => $arguments["message"]]);
        },
        "callback" => function ($request, $response, $arguments) use ($c) {
            $c["token"]->hydrate($arguments["decoded"]);
        }
    ]);
};
$app->add("JwtAuthentication");

