<?php
/**
 * Created by PhpStorm.
 * User: wangliwei
 * Date: 2017/6/6
 * Time: 下午5:06
 */

namespace App\model;

use App\helper\Database\Database;
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
}