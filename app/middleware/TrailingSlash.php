<?php 

namespace App\middleware;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Middleware to remove the trailing slash.
 */
class TrailingSlash
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
    	$uri = $request->getUri();
	    $path = $uri->getPath();
	    if ($path != '/' && substr($path, -1) == '/') {
	        // permanently redirect paths with a trailing slash
	        // to their non-trailing counterpart
	        $uri = $uri->withPath(substr($path, 0, -1));
	        
	        if($request->getMethod() == 'GET') {
	            return $response->withRedirect((string)$uri, 301);
	        }
	        else {
	            return $next($request->withUri($uri), $response);
	        }
	    }

	    return $next($request, $response);
        
    }
}
