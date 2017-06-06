<?php
/**
 * Created by PhpStorm.
 * User: wangliwei
 * Date: 2017/6/6
 * Time: 下午4:59
 */

namespace App\helper\Database;


class Database
{

    protected static $instance = null;

    private function __construct()
    {
    }

    public static function getInstance($conf = null)
    {
        if (!is_null(static::$instance)) {
            return static::$instance;
        }

        $settings = require ROOT . '/bootstrap/settings.php';
        $conf = is_null($conf) ? $settings['settings']['database'] : $conf;
        if (is_array($conf)) {
            static::$instance = static::setInstance($conf);
            return static::$instance;
        }


        throw new \Exception('conf should be arrays');
    }

    private static function setInstance(array $conf){
        return new \Medoo\Medoo($conf);
    }
}