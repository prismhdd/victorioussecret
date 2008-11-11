<?php
require_once '../database/config.php';
require_once 'PHPUnit/Framework.php';

$conn = Doctrine_Manager :: connection(DSN);

class UserTest extends PHPUnit_Framework_TestCase {
	
	public function setUp() {
		//Remove the user if it exists
		Doctrine_Query :: create()
									->delete()
									->from('User u')
									->where('u.username=?','unittest')
									->execute();
	}
	
	/**
	 * Creates a user and saves it to the database
	 */
	private function createUser() {
		$user = new User();

		$user['username'] = 'unittest';
		$user['first_name'] = 'test';
		$user['last_name'] = 'test';
		$user['password'] = md5('test');
		$user['email_address'] = 'test';

		$user->save();
	}

	/**
	 * Tests registering a new user
	 */
	public function testRegisterNewUser() {
		$this->createUser();
	}
	
	/**
	 * Tests failing when creating a duplicate user
	 */
	public function testRegisterNewUserFail() {
		try {
            $this->createUser();
			$this->createUser();
        }
        catch (Doctrine_Connection_Pgsql_Exception $expected) {
            return;
        }
        $this->fail('An expected exception has not been raised.');
	}

}