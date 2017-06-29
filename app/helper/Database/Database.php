<?php
/**
 * Created by PhpStorm.
 * User: wangliwei
 * Date: 2017/6/6
 * Time: 下午4:59
 */

namespace App\helper\Database;

use InvalidArgumentException;

class Database
{

    /**
     * The MySQL connections.
     *
     * @var array
     */
    protected static $connections = [];


    /**
     * Get a MySQL connection by name.
     *
     * @param  string|null  $name
     */
    public static function connection($dbname = '')
    {
        $settings = app('settings')['database'];

        $dbname = $dbname ?: $settings['default'];
        $options = $settings['connection'][$dbname];


        $masterNodeIndex = rand(0, count($options['masters']) - 1);
        $masterNodeOption = $options['masters'][$masterNodeIndex];

        $clusterNode = !$options['cluster'] ? 'masters' : 'slaves';
        $slaveNodeIndex = rand(0, count($options[$clusterNode]) - 1);
        $slaveNodeOption = $options[$clusterNode][$slaveNodeIndex];

        try {

            if (!$masterNodeOption || !$slaveNodeOption) throw new \Exception;

            $nodeUniqueFlag = $dbname;

            if (
                !isset(static::$instance[$nodeUniqueFlag]) ||
                empty(static::$instance[$nodeUniqueFlag])
            ) {
                static::$instance[$nodeUniqueFlag] = static::resolve($slaveNodeOption, $masterNodeOption, $options['cluster']);
            }

            return static::$instance[$nodeUniqueFlag];

        } catch (\Exception $e) {
            throw new InvalidArgumentException('database connect failed', 500);
        }

    }

    /**
     * Resolve the given connection by name.
     *
     */
    private static function resolve(
        array $slaveOption = [], 
        array $masterOption = [], 
        $cluster = false
    ) {
        return (new Connector($slaveOption))->setCluster($cluster)->setMasterOption($masterOption);
    }

}