<?php

namespace lib;
use lib\Config;

class Core {
    public $db; // handle of the db connexion
    private static $instance;

    private function __construct() {
        
        $this->db = new \medoo(array(
            'database_type' => Config::read('db.database_type'),
            'database_name' => Config::read('db.database_name'),
            'server' => Config::read('db.server'),
            'username' => Config::read('db.username'), 
            'password' => Config::read('db.password'), 
            'port' => Config::read('db.port'), 
        ));
        
    }

    public static function getInstance() {
        if (!isset(self::$instance))
        {
            $object = __CLASS__;
            self::$instance = new $object;
        }
        return self::$instance;
    }
    
    // others global functions
}