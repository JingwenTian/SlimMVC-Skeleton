<?php 

namespace App\middleware;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Doing....
 */
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
        $key = $this->resolveRequestSignature($request);
        
        
        return $next($request, $response);
    }

    /**
     * Resolve request signature.
     *
     * @param RequestInterface $request [description]
     * @return string
     */
    protected function resolveRequestSignature(RequestInterface $request)
    {
        return sha1(implode('|', [
            $request->getMethod(), $request->getServerParam('SERVER_NAME'), 
            $request->getUri()->getPath(), $request->getServerParam('REMOTE_ADDR')
        ]));
    }

    /**
     * Create a 'too many attempts' response.
     *
     * @param  string  $key
     * @param  int  $maxAttempts
     * @return Response
     */
    protected function buildResponse($key, $maxAttempts)
    {
        $response = new Response('Too Many Attempts.', 429);
        $retryAfter = $this->limiter->availableIn($key);
        return $this->addHeaders(
            $response, $maxAttempts,
            $this->calculateRemainingAttempts($key, $maxAttempts, $retryAfter),
            $retryAfter
        );
    }

    /**
     * Add the limit header information to the given response.
     *
     * @param  $response
     * @param  int  $maxAttempts
     * @param  int  $remainingAttempts
     * @param  int|null  $retryAfter
     * @return Response
     */
    protected function addHeaders(Response $response, $maxAttempts, $remainingAttempts, $retryAfter = null)
    {
        $headers = [
            'X-RateLimit-Limit' => $maxAttempts,
            'X-RateLimit-Remaining' => $remainingAttempts,
        ];
        if (! is_null($retryAfter)) {
            $headers['Retry-After'] = $retryAfter;
            $headers['X-RateLimit-Reset'] = Carbon::now()->getTimestamp() + $retryAfter;
        }
        $response->headers->add($headers);
        return $response;
    }

}
