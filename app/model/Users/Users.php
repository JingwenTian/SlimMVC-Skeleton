<?php 

namespace App\model\Users;

use App\model\ModelInterface;
use App\model\Common;

class User implements ModelInterface
{
	public  $_dbLink;
	private $_table = 'users';

	use Common;

}