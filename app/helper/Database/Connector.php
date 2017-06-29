<?php
/**
 * Created by PhpStorm.
 * User: wangliwei
 * Date: 2017/6/28
 * Time: 下午2:34
 */

namespace App\helper\Database;


use Medoo\Medoo;
use PDO;
use PDOException;
use PhpMyAdmin\SqlParser\Parser;
use PhpMyAdmin\SqlParser\Statements\SelectStatement;
use PhpMyAdmin\SqlParser\Statements\InsertStatement;
use PhpMyAdmin\SqlParser\Statements\UpdateStatement;
use PhpMyAdmin\SqlParser\Statements\ReplaceStatement;
use PhpMyAdmin\SqlParser\Statements\DeleteStatement;

class Connector extends Medoo
{
    
    const STATEMENT_INSERT = 'insert';

    const STATEMENT_UPDATE = 'update';

    const STATEMENT_SELECT = 'select';

    const STATEMENT_REPLACE= 'replace';

    const STATEMENT_DELETE = 'delete';

    /**
     * @var boolean
     */
    protected $_clustor = false;

    /**
     * @var PDO
     */
    protected $_masterLink = null;

    /**
     * @var PDO
     */
    protected $_slaveLink = null;

    /**
     * @var array
     */
    protected $_masterOption = null;

    /**
     * @var boolean
     */
    protected $_useMasterPdo = false;


    public function setCluster($boolean)
    {
        $this->_clustor = $boolean;
        return $this;
    }

    public function useMasterPdo()
    {
        $this->_useMasterPdo = true;
        return $this;
    }

    public function setMasterOption($option)
    {
        $this->_masterOption = $option;
        return $this;
    }

    public function exec($query, $map = [])
    {
        $stmt = null;
        $this->_clustor && $this->pdoLinkHandler($query, $stmt);

        $res = parent::exec($query, $map);

        switch ($stmt)
        {   
            case self::STATEMENT_INSERT:
                $res = parent::id();
                break;
            case self::STATEMENT_DELETE:
            case self::STATEMENT_UPDATE:
                // none...
                break;
            default:;
        }

        $this->_useMasterPdo = false;
        !is_null($this->_slaveLink) && $this->pdo = $this->_slaveLink;
        return $res;
    }
 

    private function pdoLinkHandler($query, &$stmt)
    {
        $stmt = $this->parseStatement($query);
        
        if ($stmt != self::STATEMENT_SELECT) {
            $this->_useMasterPdo = true;
        } 

        // 'Write Statement' or 'Force Master Read Statement'
        
        if ( $this->_useMasterPdo ) 
        {
            $this->_masterLink = $this->getMasterPdo();
            $this->_slaveLink = $this->pdo;
            $this->pdo = $this->_masterLink;
        }

    }

    private function parseStatement( $query )
    {
        $parser = new Parser($query);
        $stmt = $parser->statements[0];

        if ($stmt instanceof SelectStatement) 
        {
            return self::STATEMENT_SELECT;
        } 
        else if ($stmt instanceof InsertStatement) 
        {
            return self::STATEMENT_INSERT;
        } 
        else if ($stmt instanceof UpdateStatement) 
        {
            return self::STATEMENT_UPDATE;
        }
        else if ($stmt instanceof ReplaceStatement) 
        {
            return self::STATEMENT_REPLACE;
        }
        else if ($stmt instanceof DeleteStatement) 
        {
            return self::STATEMENT_DELETE;
        }
        return null;

    }

    private function getMasterPdo()
    {
        if (is_null($this->_masterOption)) {
            return $this->pdo;
        }
        if (!is_null($this->_masterLink)) {
            return $this->_masterLink;
        }
        $option = $this->_masterOption;
        $commands = [];
        $commands[] = 'SET SQL_MODE=ANSI_QUOTES';
        $attr = [
            'driver' => $option['database_type'],
            'dbname' => $option['database_name']
        ];
        if (isset($option['socket'])) {
            $attr['unix_socket'] = $option['socket'];
        } else {
            $attr['host'] = $option['server'];
            if (isset($option['port'])) {
                $attr['port'] = $option['port'];
            }
        }
        // Make MySQL using standard quoted identifier
        $stack = [];
        foreach ($attr as $key => $value) {
            if (is_int($key)) {
                $stack[] = $value;
            } else {
                $stack[] = $key . '=' . $value;
            }
        }
        $dsn = $option['database_type'] . ':' . implode($stack, ';');

        if (isset($option['charset'])) {
            $commands[] = "SET NAMES '" . $option['charset'] . "'";
        }
        try {
            $this->_masterLink = new PDO(
                $dsn,
                $option['username'],
                $option['password'],
                $this->option
            );
            foreach ($commands as $value) {
                $this->_masterLink->exec($value);
            }
            return $this->_masterLink;
        } catch (PDOException $e) {
            throw new \Exception($e->getMessage());
        }
    }
   
}