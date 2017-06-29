<?php 

namespace App\model\Users;

use App\model\Manager\Model;
use App\model\Connectors\SlimConnection;

class Users extends SlimConnection
{
	protected $_table = 'users';

}  