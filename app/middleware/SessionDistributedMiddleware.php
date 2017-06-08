<?php 

namespace App\middleware;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Session Distributed Middleware
 */
class SessionDistributedMiddleware extends \Predis\Session\Handler
{

	public function __construct( $client, array $options = [] )
	{
		parent::__construct($client, $options);

		$this->register();
	}

	public function __invoke(RequestInterface $request, ResponseInterface $response, callable $next)
	{		

		// start our session
		session_start();

		// tell slim it's ok to continue!
		return $next($request, $response);

	}

}