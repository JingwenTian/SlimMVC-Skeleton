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

    public static function getInstance($dbname = '')
    {
        $settings = app('settings')['database'];

        $dbname = $dbname ?: $settings['default'];
        $options = $settings['connection'][$dbname];


        $nodeIndex = rand(0, count($options['masters']) - 1);
        $nodeOption = $options['masters'][$nodeIndex];

        $clusterNode = !$options['cluster'] ? 'masters' : 'slaves';
        $nodeIndex = rand(0, count($options[$clusterNode]) - 1);
        $read_conf = $options[$clusterNode][$nodeIndex];

        try {

            if (!$nodeOption) throw new \Exception;
            $nodeFlag = $dbname;

            if (
                !isset(static::$instance[$nodeFlag]) ||
                empty(static::$instance[$nodeFlag])
            ) {
                static::$instance[$nodeFlag] = static::setInstance($nodeOption, $read_conf);
            }

            return static::$instance[$nodeFlag];

        } catch (\Exception $e) {
            throw new \Exception('database connect failed', 500);
        }

    }

    private static function setInstance(array $option = [], $read_conf = null)
    {
        return (new IMedoo($option))->setReadPdoConf($read_conf);
    }

}