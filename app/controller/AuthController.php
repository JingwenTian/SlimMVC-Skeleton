<?php 

namespace App\controller;

use Interop\Container\ContainerInterface;
use Ramsey\Uuid\Uuid;
use Firebase\JWT\JWT;
use Tuupola\Base62;

class AuthController
{
    protected $container;
    
    public function __construct( ContainerInterface $container ) 
    {
        $this->container = $container;
    }

    public function auth($request, $response, $args) 
    {
    	$settings = $this->container->get('settings')['jwtAuthentication'];

    	$requested_scopes = $request->getParsedBody();
	    
	    $mobile = isset($requested_scopes['mobile']) ? $requested_scopes['mobile'] : '';
	    $password = isset($requested_scopes['password']) ? $requested_scopes['password'] : '';

	    //  START 验证用户账号信息 : 此处需要替换为查询操作
	    $userId = 1;
	    $scopes = [
	    			'userId'	=> $userId,
	    			'mobile'	=> $mobile
	    		  ];
	    // END
	    
	    if (empty($scopes)) {
	    	return $response->withStatus(401)
		        ->withHeader("Content-Type", "application/json")
	            ->withJson(['code' => 401, 'message' => 'invalid credentials']);
	    }

	    $now = new \DateTime();
	    $future = new \DateTime("now +{$settings['expires']}");
	    $server = $request->getServerParams();
	    $jti = (new Base62)->encode(random_bytes(16));

	    $payload = [
	        "iat" => $now->getTimeStamp(), // Issued At - When the token was issued (unix timestamp)
	        "exp" => $future->getTimeStamp(), // Expiry - The token expiry date (unix timestamp)
	        "jti" => $jti, // JWT Id - A unique identifier for the token (md5 of the sub and iat claims)
	        "sub" => $userId, // Subject - This holds the identifier for the token (defaults to user id)
	        "scope" => $scopes
	    ];

	    $secret = $settings['secret'];
	    $token = JWT::encode($payload, $secret, "HS256");

	    $data["token"] = $token;
	    $data["expires"] = $future->getTimeStamp();

	    return $response->withStatus(201)
	        ->withHeader("Content-Type", "application/json")
            ->withJson($data);
	}

	public function dump($request, $response, $args)
	{
		print_r($this->container->token->getScope());
	}

}