<?php 
//Application middleware

use App\helper\Authentication\Token;

use Slim\Middleware\JwtAuthentication;
use Slim\Middleware\HttpBasicAuthentication;

use App\middleware\LocalizationMiddleware;
use App\middleware\SessionDistributedMiddleware;
use App\middleware\ThrottleRequests;

use Symfony\Component\Translation\Loader\PhpFileLoader;
use Symfony\Component\Translation\MessageSelector;
use Symfony\Component\Translation\Translator;

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


/*
|--------------------------------------------------------------------------
| Validation Middleware
|--------------------------------------------------------------------------
| Register middleware for all routes
| referer: https://github.com/DavidePastore/Slim-Validation
*/
$validators = [];
$app->add(new \DavidePastore\Slim\Validation\Validation($validators));

/*
|--------------------------------------------------------------------------
| Translation Middleware
|--------------------------------------------------------------------------
| 翻译插件注册
| 用法参考: https://github.com/symfony/translation & https://github.com/tboronczyk/localization-middleware
*/
$container["locale"] = function ($c) {
    return new \stdClass();
};

$availableLocales = ['en_US', 'zh_CN', 'zh_HK', 'zh_TW', 'zh_MO'];
$defaultLocale = $container->get('settings')['renderer']['locale_default'];
$localesMiddeleware = new LocalizationMiddleware($availableLocales, $defaultLocale);
$localesMiddeleware->setSearchOrder([
    LocalizationMiddleware::FROM_URI_PARAM,
    LocalizationMiddleware::FROM_COOKIE,
]);
$localesMiddeleware->setCallback(function (string $locale) use ($container) {
    $container['locale']->lang = $locale;
});
$app->add($localesMiddeleware);

$container["translator"] = function ($c) {

    $path = $c->get('settings')['renderer']['translations_path'];
    
    $language = $c['locale']->lang;
    $translator = new Translator($language, new MessageSelector());
    $translator->setFallbackLocales(['zh_HK']);
    $translator->addLoader('php', new PhpFileLoader());
    $translator->addResource('php', $path . 'en_US.php', 'en_US'); // English 
    $translator->addResource('php', $path . 'zh_CN.php', 'zh_CN'); // Chinese (Simplified, PRC) 
    $translator->addResource('php', $path . 'zh_HK.php', 'zh_HK'); // Chinese (Traditional, Hong Kong S.A.R.) 
    $translator->addResource('php', $path . 'zh_HK.php', 'zh_TW'); // Chinese (Traditional, Taiwan)
    $translator->addResource('php', $path . 'zh_HK.php', 'zh_MO'); // Chinese (Traditional, Macao S.A.R.)

    return $translator;
};


/*
|--------------------------------------------------------------------------
| Session Distributed Middleware
|--------------------------------------------------------------------------
| 将 session 存储方式注册为 Redis
*/
$sessionOptions = $container->get('settings')['session'];
$sessionMiddleware = new SessionDistributedMiddleware($container['cache'], $sessionOptions);
$app->add($sessionMiddleware);

/*
|--------------------------------------------------------------------------
| Rate Limit Middleware
|--------------------------------------------------------------------------
| 用于访问的速率限制, 默认最多1分钟访问120次
*/
$throttleOptions = ['max_attempts'  => 120, 'decay_minutes' => 1];
$app->add(new ThrottleRequests($throttleOptions));