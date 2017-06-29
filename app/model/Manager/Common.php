<?php 

namespace App\model\Manager;

use App\controller\exception\MassAssignmentException;
use App\controller\exception\ModelNotFoundException;
use App\model\Consts;

trait Common  
{	

	/*
    |--------------------------------------------------------------------------
    | 基础操作
    |--------------------------------------------------------------------------
    | 包括增、删、改、查行为
    */
   
	/**
	 * 数据写入
	 *
	 * @param array $params [description]
	 *
	 * @return [type] [description]
	 */
	public function insert( $params = [] )
	{
		if (!$params) {
			return false;
		}
		$lastId = $this->_dbLink->insert( $this->_table, $params );
		return $lastId;
		//return $lastId ? $this->_dbLink->id() : $lastId;
	}

	/**
	 * 数据更新
	 *
	 * @param array $condition [description]
	 * @param array $params    [description]
	 *
	 * @return [type] [description]
	 */
	public function update( $condition = [], $params = [] )
	{
		if (!$condition || !$params) {
			return false;
		}
		$result = $this->_dbLink->update( $this->_table, $params, $condition );
		return $result->rowCount();
	}
	
	/**
	 * 数据查询
	 *
	 * @param array  $condition [description]
	 * @param [type] $flag      [description]
	 * @param string $columns   [description]
	 *
	 * @return [type] [description]
	 */
	public function select( $condition = [], $flag = Consts::GET_ROW_FLAG, $columns = '*' )
	{
		$result = [];

		switch ( $flag ) {
			default:
			case Consts::GET_ROW_FLAG:
				$result = $this->_dbLink->get( $this->_table, $columns, $condition );
				break;
			case Consts::GET_ALL_FLAG:
			case Consts::GET_PAGE_FLAG:
				$result = $this->_dbLink->select( $this->_table, $columns, $condition );
				break;
			case Consts::GET_COUNT_FLAG:
				$result = $this->_dbLink->count( $this->_table, $condition );
				break;
			case Consts::GET_MAX_FLAG:
				$columns = is_array($columns) ? $columns[0] : $columns;
				$result = $this->_dbLink->max( $this->_table, $columns, $condition );
				break;
			case Consts::GET_MIN_FLAG:
				$columns = is_array($columns) ? $columns[0] : $columns;
				$result = $this->_dbLink->min( $this->_table, $columns, $condition );
				break;
			case Consts::GET_AVG_FLAG:
				$result = $this->_dbLink->avg( $this->_table, $columns, $condition );
				break;
			case Consts::GET_SUM_FLAG:
				$result = $this->_dbLink->sum( $this->_table, $columns, $condition );
				break;
			case Consts::GET_HAS_FLAG:
				$result = $this->_dbLink->has( $this->_table, $condition );
		}

		return $result;
	}

	/**
	 * 数据删除
	 *
	 * @param array $condition [description]
	 *
	 * @return [type] [description]
	 */
	public function delete( $condition = [] )
	{
		$result = $this->_dbLink->delete( $this->_table, $condition );
		return $result->rowCount();
	}

	/**
	 * 查询 SQL 执行 [NOT RECOMMENDED]
	 *
	 * @param string $sql  [description]
	 * @param [type] $flag [description]
	 *
	 * @return [type] [description]
	 */
	public function query( $sql = '', $flag = Consts::GET_ROW_FLAG )
	{
		$result = [];

		switch ( $flag ) {
			default:
			case Consts::GET_ROW_FLAG:
			case Consts::GET_COUNT_FLAG:
			case Consts::GET_MAX_FLAG: 
			case Consts::GET_MIN_FLAG: 
			case Consts::GET_AVG_FLAG: 
			case Consts::GET_SUM_FLAG: 
			case Consts::GET_HAS_FLAG: 
				$result = $this->_dbLink->query( $sql )->fetch(\PDO::FETCH_ASSOC);
				break;
			case Consts::GET_ALL_FLAG:
			case Consts::GET_PAGE_FLAG:
				$result = $this->_dbLink->query( $sql )->fetchAll(\PDO::FETCH_ASSOC);
				break;
		}

		return $result;
	}

	/*
    |--------------------------------------------------------------------------
    | 事物操作
    |--------------------------------------------------------------------------
    | 包括开启事物、提交事物、回滚事物行为, 也可以使用 medoo提供的 action 方法来实现
    */


	/**
	 * 开启事物
	 *
	 * @return [type] [description]
	 */
	public function beginTransaction()
    {
        $this->_dbLink->pdo->beginTransaction();
    }

    /**
     * 提交事物
     *
     * @return [type] [description]
     */
    public function commit()
    {
        $this->_dbLink->pdo->commit();
    }

    /**
     * 回滚事物
     *
     * @return [type] [description]
     */
    public function rollBack()
    {
        $this->_dbLink->pdo->rollBack();
    }

    /**
     * 事物流程
     *
     * @param [type] $call [description]
     *
     * @return [type] [description]
     */
    public function transaction( $call )
    {
        $this->beginTransaction();
        try {
            $call($this);
            $this->commit();
            return true;
        } catch (\Exception $exception) {
            $this->rollBack();
            throw $exception;
        }
    }

    
    /*
    |--------------------------------------------------------------------------
    | 调试操作
    |--------------------------------------------------------------------------
    | 用于打印执行的 SQL 及数据库信息等
    */
	

	/**
	 * 数据执行调试
	 *
	 * @param [type] $flag [description]
	 *
	 * @return [type] [description]
	 */
	public function trace( $flag = Consts::TRACE_LOG_FLAG )
	{
		$result = [];

		switch ($flag) {
			default:
			case Consts::TRACE_LOG_FLAG:
				$result = $this->_dbLink->log();
				break;
			case Consts::TRACE_ERROR_FLAG:
				$result = $this->_dbLink->error();
				break;
			case Consts::TRACE_LAST_FLAG:
				$result = $this->_dbLink->last();
				break;
			case Consts::TRACE_INFO_FLAG:
				$result = $this->_dbLink->info();
				break;
		}
		return $result;

	}

	/*
    |--------------------------------------------------------------------------
    | 扩展操作
    |--------------------------------------------------------------------------
    | 对基础操作的便利性封装
    */

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