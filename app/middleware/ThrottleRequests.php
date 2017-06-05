<?php 

namespace App\middleware;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;


class ThrottleRequests
{
	public function __construct() 
	{
	}

	/**
     * Execute the middleware.
     *
     * @param ServerRequestInterface $request
     * @param ResponseInterface      $response
     * @param callable               $next
     *
     * @return ResponseInterface
     */
	public function __invoke(RequestInterface $request, ResponseInterface $response, callable $next)
    {
    	
        
    }
}
