<?php

/**
 * This is an example of User Class using Medoo
 *
 */

namespace models;
use lib\Core;

class User {

	protected $core;

	function __construct() {
		$this->core = \lib\Core::getInstance();
	}
	
	// Get all users
	public function getUsers() {
		$result = array();		
		$result = $this->core->db->select("yunbbs_users","*");
        return $result;
	}

	// Get user by the Id
	public function getUserById($id) {
		
	}

	// Get user by the Login
	public function getUserByLogin($email, $pass) {
		
	}

	// Insert a new user
	public function insertUser($data) {

		
	}

	// Update the data of an user
	public function updateUser($data) {
		
	}

	// Delete user
	public function deleteUser($id) {
		
	}

}