<?php 

namespace App\helper\Cache;

use App\helper\Cache\Cache;
use Carbon\Carbon;

class RateLimiter
{
	/**
     * The cache store implementation.
     *
     * @var \App\helper\Cache\Cache
     */
    protected $cache;

    /**
     * Create a new rate limiter instance.
     *
     * @param  \App\helper\Cache\Cache
     * @return void
     */
    public function __construct()
    {
        $this->cache = Cache::connection();
    }

    /**
     * Determine if the given key has been "accessed" too many times.
     *
     * @param  string  $key
     * @param  int  $maxAttempts
     * @param  float|int  $decayMinutes
     * @return bool
     */
    public function tooManyAttempts($key, $maxAttempts, $decayMinutes = 1)
    {
        if ($this->cache->exists($key.':lockout')) {
            return true;
        }

        if ($this->attempts($key) >= $maxAttempts) {
            $this->lockout($key, $decayMinutes);

            $this->resetAttempts($key);

            return true;
        }

        return false;
    }

    /**
     * Add the lockout key to the cache.
     *
     * @param  string  $key
     * @param  int  $decayMinutes
     * @return void
     */
    protected function lockout($key, $decayMinutes)
    {
        $this->cache->setex(
        	$key.':lockout', $decayMinutes * 60, Carbon::now()->getTimestamp() + ($decayMinutes * 60)
        );
    }

    /**
     * Increment the counter for a given key for a given decay time.
     *
     * @param  string  $key
     * @param  float|int  $decayMinutes
     * @return int
     */
    public function hit($key, $decayMinutes = 1)
    {
    	if (!$this->cache->exists($key)) {
            $this->cache->setex($key, $decayMinutes * 60, 0);
        }

        return (int) $this->cache->incr($key);
    }

    /**
     * Get the number of attempts for the given key.
     *
     * @param  string  $key
     * @return mixed
     */
    public function attempts($key)
    {
    	$value = $this->cache->get($key);
        return !is_null($value) ? $value : 0;
    }

    /**
     * Reset the number of attempts for the given key.
     *
     * @param  string  $key
     * @return mixed
     */
    public function resetAttempts($key)
    {
        return $this->cache->del($key);
    }

    /**
     * Get the number of retries left for the given key.
     *
     * @param  string  $key
     * @param  int  $maxAttempts
     * @return int
     */
    public function retriesLeft($key, $maxAttempts)
    {
        $attempts = $this->attempts($key);

        return $maxAttempts - $attempts;
    }

    /**
     * Clear the hits and lockout for the given key.
     *
     * @param  string  $key
     * @return void
     */
    public function clear($key)
    {
        $this->resetAttempts($key);

        $this->cache->del($key.':lockout');
    }

    /**
     * Get the number of seconds until the "key" is accessible again.
     *
     * @param  string  $key
     * @return int
     */
    public function availableIn($key)
    {
    	$value = $this->cache->get($key.':lockout');
    	$accessible = !is_null($value) ? $value : 0;
        return $accessible - Carbon::now()->getTimestamp();
    }


}
