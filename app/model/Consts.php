<?php 

namespace App\model;

class Consts
{
	/*
	|--------------------------------------------------------------------------
	| Common Config
	|--------------------------------------------------------------------------
	| 通用常量配置
	|
	*/

	// Token 配置
	const TOKEN_EXPIRES 	= 3600;
	const TOKEN_SALT 		= "eba7aa43d165fc6bf49c0549a8a55d35"; 
	const TOKEN_LENGTH 		= 64; 

	// 数据获取姿势
	const GET_ROW_FLAG  	= 1; // 获取单条记录
	const GET_ALL_FLAG  	= 2; // 获取所有记录
	const GET_COUNT_FLAG 	= 3; // 获取记录行数
	const GET_PAGE_FLAG 	= 4; // 获取分页记录
	const GET_MAX_FLAG 		= 5; // 获取最大值
	const GET_MIN_FLAG 		= 6; // 获取最小值
	const GET_AVG_FLAG 		= 7; // 获取平均数
	const GET_SUM_FLAG 		= 8; // 获取数据和
	const GET_HAS_FLAG 		= 9; // 是否存在某数据

	// 数据调试姿势
	const TRACE_ERROR_FLAG 	= 1; // 返回SQL错误信息
	const TRACE_LOG_FLAG 	= 2; // 返回所有SQL日志
	const TRACE_LAST_FLAG 	= 3; // 返回最后一条SQL日志
	const TRACE_INFO_FLAG 	= 4; // 返回数据库连接信息

	// 分页配置
	const PAGE_SIZE 		= 20;
	const M_PAGE_SIZE		= 50;

	/*
	|--------------------------------------------------------------------------
	|  Logic Config
	|--------------------------------------------------------------------------
	|  业务逻辑相关常量配置
	|
	*/

}