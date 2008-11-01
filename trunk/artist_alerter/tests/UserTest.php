<?php
require_once '../database/config.php';
require_once 'PHPUnit/Framework.php';

$conn = Doctrine_Manager :: connection(DSN);

class UserTest extends PHPUnit_Framework_TestCase {

	/**
	 * Tests registering a new user
	 */
	public function testRegisterNewUser() {
		$user = new User();

		$user['username'] = 'test';
		$user['first_name'] = 'test';
		$user['last_name'] = 'test';
		$user['password'] = md5('test');
		$user['email_address'] = 'test';

		$user->save();
	}

}