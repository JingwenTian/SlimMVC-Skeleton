<?php 

namespace App\helper\Database;

class Cache
{

    protected static $instance = null;

    private function __construct()
    {
    }

    public static function getInstance(array $options = [], array $extends = [])
    {
    	if (!is_null(static::$instance)) {
            return static::$instance;
        }

    	if (empty($options)) {
    		$settings = require ROOT . '/bootstrap/settings.php';
    		$options  = isset($settings['settings']['cache']) ? $settings['settings']['cache'] : [];
    	}

        static::$instance = static::setInstance($options, $extends);

        return static::$instance;
    }

    private static function setInstance(array $options = [], array $extends = [])
    {
        return new \Predis\Client($options, $extends);
    }

    
}