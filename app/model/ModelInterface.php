<?php 

namespace App\model;


interface ModelInterface 
{
	
	/**
	 * 写入数据
	 */
	public function insert( $params = [] );

	/**
	 * 更新数据
	 */
	public function update( $condition = [], $params = [] );


	/**
	 * 查询数据
	 */
	public function select( $condition = [], $flag = 1, $columns = [] );

	/**
	 * 删除数据
	 */
	public function delete( $condition = [] );

	/**
	 * 执行查询
	 */
	public function query( $sql = '', $flag = 1 );

}