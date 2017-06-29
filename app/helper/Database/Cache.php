<?php 

namespace App\helper\Database;

use InvalidArgumentException;
use Predis\Client;

class Cache
{

    /**
     * The Redis connections.
     *
     * @var array
     */
    protected static $connections = [];


    /**
     * Get a Redis connection by name.
     *
     * @param  string|null  $name
     */
    public static function connection($name = null, array $extends = [])
    {
        $name = $name ? : 'default';

    	if (isset(static::$connections[$name])) {
            return static::$connections[$name];
        }

        return static::$connections = static::resolve($name, $extends);

    }

    /**
     * Resolve the given connection by name.
     *
     * @param  string|null  $name
     * @return array        $extends
     *
     * @throws \InvalidArgumentException
     */
    private static function resolve($name = null, array $extends = [])
    {
        $name = $name ? : 'default';
        $options = app('settings')['cache'];

        if (isset($options[$name])) {
            return new Client($options[$name], $extends);
        }

        throw new InvalidArgumentException(
            "Redis connection [{$name}] not configured."
        );
        
    }


    /**
     * @param $key
     * @param $value
     * @param null $time
     * @param null $unit
     */
    public static function set($key, $value, $time = null, $unit = null)
    {
        if ($time) {
            switch ($unit) {
                case 'h':
                    $time *= 3600;
                    break;
                case 'm':
                    $time *= 60;
                    break;
                case 's':
                case 'ms':
                    break;
                default:
                    throw new InvalidArgumentException('单位只能是 h m s ms');
                    break;
            }

            if ($unit == 'ms') {
                self::_psetex($key, $value, $time);
            } else {
                self::_setex($key, $value, $time);
            }

        } else {

            self::connection()->set($key, $value);

        }
    }

    /**
     * @param $key
     * @return string
     */
    public static function get($key)
    {
        return self::connection()->get($key);
    }

    /**
     * @param $key
     * @return int
     */
    public static function delete($key)
    {
        return self::connection()->del($key);
    }

    /**
     * @param $key
     * @param $value
     * @param $time
     */
    private static function _setex($key, $value, $time)
    {
        self::connection()->setex($key, $time, $value);
    }

    /**
     * @param $key
     * @param $value
     * @param $time
     */
    private static function _psetex($key, $value, $time)
    {
        self::connection()->psetex($key, $time, $value);
    }



    
}