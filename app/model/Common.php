<?php 

namespace App\model;

use App\model\Consts;

trait Common  
{	
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
		return $lastId ? $this->_dbLink->id() : $lastId;
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
		!isset($params['update_date']) && $params['update_date'] = time();
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
	 * 查询 SQL 执行
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

}