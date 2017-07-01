<?php 

namespace App\middleware;

use Carbon\Carbon;
use \Psr\Http\Message\RequestInterface;
use \Psr\Http\Message\ResponseInterface;

use App\helper\Cache\RateLimiter;

/**
 * Handle an incoming request.
 */
class ThrottleRequests
{
     /**
     * The rate limiter instance.
     *
     * @var \App\helper\Cache\RateLimiter
     */
    protected $limiter;

    /**
     * The rate limiter option.
     *
     * @var array
     */
    protected $options = [
                            'max_attempts'  => 120,
                            'decay_minutes' => 1
                        ];

    /**
     * Create a new request throttler.
     *
     * @return void
     */
	public function __construct( array $options = [] ) 
	{
        $this->options = array_merge($this->options, $options);

        $this->limiter = new RateLimiter();
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

        $maxAttempts = $this->options['max_attempts'];
        $decayMinutes = $this->options['decay_minutes'];

        if ($this->limiter->tooManyAttempts($key, $maxAttempts, $decayMinutes)) {
            return $this->buildResponse($response, $key, $maxAttempts);
        }

        $this->limiter->hit($key, $decayMinutes);
        
        $response = $this->addHeaders(
            $response, $maxAttempts,
            $this->calculateRemainingAttempts($key, $maxAttempts)
        );
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
     * @param  $response
     * @param  string  $key
     * @param  int  $maxAttempts
     * @return Response
     */
    protected function buildResponse(ResponseInterface $response, $key, $maxAttempts)
    {
        $response = $response->withStatus(429);
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
    protected function addHeaders(ResponseInterface $response, $maxAttempts, $remainingAttempts, $retryAfter = null)
    {
        $headers = [
            'X-RateLimit-Limit' => $maxAttempts,
            'X-RateLimit-Remaining' => $remainingAttempts,
        ];
        if (! is_null($retryAfter)) {
            $headers['Retry-After'] = $retryAfter;
            $headers['X-RateLimit-Reset'] = Carbon::now()->getTimestamp() + $retryAfter;
        }
        foreach ($headers as $name => $value) {
            $response = $response->withHeader($name, $value);
        }
        return $response;
    }

    /**
     * Calculate the number of remaining attempts.
     *
     * @param  string  $key
     * @param  int  $maxAttempts
     * @param  int|null  $retryAfter
     * @return int
     */
    protected function calculateRemainingAttempts($key, $maxAttempts, $retryAfter = null)
    {
        if (is_null($retryAfter)) {
            return $this->limiter->retriesLeft($key, $maxAttempts);
        }
        return 0;
    }

}
