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

    protected static $instance = [];

    private function __construct()
    {
    }

    public static function getInstance( $master = true, $dbname = '' )
    {
        $settings = app('settings')['database'];

        $dbname = $dbname ? : $settings['default'];
        $options = $settings['connection'][$dbname];

        $clusterNode = ($master || !$options['cluster']) ? 'masters' : 'slaves';

        $nodeIndex = rand(0, count($options[$clusterNode]) - 1);
        $nodeOption = $options[$clusterNode][$nodeIndex];

        try {

            if (!$nodeOption) throw new \Exception;

            $nodeFlag = $nodeOption['server'];

            if (
                !isset(static::$instance[$nodeFlag]) ||
                empty(static::$instance[$nodeFlag])
            ) {
                static::$instance[$nodeFlag] = static::setInstance($nodeOption);
            }

            return static::$instance[$nodeFlag];

        } catch (\Exception $e)
        {
            throw new \Exception('database connect failed', 500);
        }

    }

    private static function setInstance(array $option = []){
        return new \Medoo\Medoo($option);
    }

}