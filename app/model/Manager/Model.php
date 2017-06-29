<?php

namespace App\model\Manager;

use App\helper\Database\Database;
use App\helper\Database\Connector;
use App\interfaces\ModelInterface;

class Model implements ModelInterface
{
    /**
     * @var Connector
     */
    public $_dbLink;

    protected $_table = '';

    protected $_dbname = '';

    protected $_primaryKey = 'id';

    use Common;

    public function useWrite()
    {
        $this->_dbLink->useMasterPdo();
        return $this;
    }

    public function __construct()
    {
        $this->_dbLink = Database::connection($this->_dbname);

    }

    


}