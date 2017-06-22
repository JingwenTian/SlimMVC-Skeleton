<?php

namespace App\model;

use App\helper\Database\Database;
use App\interfaces\ModelInterface;

use App\controller\exception\MassAssignmentException;
use App\controller\exception\ModelNotFoundException;

use App\model\Consts;

class Model implements ModelInterface
{
    public  $_dbLink;

    protected $_table = '';

    protected $_primaryKey = 'id';

    use Common;

    public function __construct()
    {
        $this->_dbLink = Database::getInstance();

    }

    public function first($condition, $columns = "*")
    {
        $res = $this->select($condition, Consts::GET_ROW_FLAG, $columns);
        return $res;
    }

    public function get($condition, $columns = "*")
    {
        $res = $this->select($condition, Consts::GET_ALL_FLAG, $columns);
        return $res;
    }

    public function count($condition)
    {
        $res = $this->select($condition, Consts::GET_COUNT_FLAG);
        return $res;
    }

    public function find($id, $columns = '*')
    {
        $condition = [$this->_primaryKey => $id];
        $res = $this->first($condition, $columns);
        return $res;
    }

    public function findOrFail($id, $columns = '*')
    {
        $res = $this->find($id, $columns);
        if ($res === false) {
            throw (new ModelNotFoundException())->setModel(get_class($this), $id);
        }
        return $res;
    }

    public function firstOrFail($condition, $columns = '*')
    {
        $res = $this->first($condition, $columns);
        if ($res === false) {
            throw (new ModelNotFoundException())->setModel(get_class($this));
        }
        return $res;
    }

    public function insertOrFail($params)
    {
        $id = $this->insert($params);
        if (!$id) {
            throw new MassAssignmentException('添加失败', 400);
        }
        return $id;
    }




}