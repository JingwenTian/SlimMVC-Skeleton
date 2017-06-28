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

class IMedoo extends Medoo
{

    protected $read_conf = null;

    /**
     * @var PDO
     */
    protected $read_pdo = null;

    protected $use_write_pdo = false;

    protected $write_pdo = null;

    public function useWritePdo()
    {
        $this->use_write_pdo = true;
        return $this;
    }

    public function setReadPdoConf($conf)
    {
        $this->read_conf = $conf;
        return $this;
    }

    public function getReadPdo()
    {
        if (is_null($this->read_conf)) {
            return $this->pdo;
        }
        if (!is_null($this->read_pdo)) {
            return $this->read_pdo;
        }
        $option = $this->read_conf;
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
            $this->read_pdo = new PDO(
                $dsn,
                $option['username'],
                $option['password'],
                $this->option
            );
            foreach ($commands as $value) {
                $this->read_pdo->exec($value);
            }
            return $this->read_pdo;
        } catch (PDOException $e) {
            throw new \Exception($e->getMessage());
        }

    }

    public function exec($query, $map = [])
    {
        $parser = new Parser($query);
        $stmt = $parser->statements[0];
        if ($stmt instanceof SelectStatement) {
            if (!$this->use_write_pdo) {
                $this->write_pdo = $this->pdo;
                $this->pdo = $this->getReadPdo();
            }
        }

        $res = parent::exec($query, $map);

        $this->use_write_pdo = false;
        !is_null($this->write_pdo) && $this->pdo = $this->write_pdo;
        return $res;
    }
}