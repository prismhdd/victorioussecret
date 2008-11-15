<?php
require_once '../database/config.php';
require_once 'PHPUnit/Framework.php';

$conn = Doctrine_Manager :: connection(DSN);

class UserTest extends PHPUnit_Framework_TestCase {

	/**
	 * Sets up each test case
	 */
	public function setUp() {
		//Create a user for the Read, Update, and Delete Operations
		$user = new User();

		$user['username'] = 'unittest2';
		$user['first_name'] = 'test';
		$user['last_name'] = 'test';
		$user['password'] = md5('test');
		$user['email_address'] = 'test2';

		$user->save();
	}
	
	/**
	 * Cleans up after each test case
	 */
	public function tearDown() {
		//Clean up the fake users we created
		Doctrine_Query :: create()
								->delete()
								->from('User u')
								->where('u.username=? OR u.username=?', array('unittest', 'unittest2'))
								->execute();
	}

	/** 
	 * TC12: Create operation on Users
	*	Test to verify that the database can save new users
	*	The test is performed by creating a user object with the required input fields
	*	Once the test is complete no errors will appear and the user will be in the database
	*/
	public function testCreateUser() {
		//Create the user
		$user = new User();

		$user['username'] = 'unittest';
		$user['first_name'] = 'test';
		$user['last_name'] = 'test';
		$user['password'] = md5('test');
		$user['email_address'] = 'test';

		$user->save();
		
		//Verify they exist now
		$this->assertTrue($user->exists());
	}
	
	/**
	 * TC12: Read operation on Users
	 * Test to verify that the database can read existing users
	 * The test is performed by loading a user object and verifying the information
	 * Once the test is complete no errors will appear
	 */
	public function testReadUser() {
		$user = Doctrine_Query :: create()
								->from('User u')
								->where('u.username=?', 'unittest2')
								->fetchOne();
		$this->assertEquals($user['username'], 'unittest2');
		$this->assertTrue($user->exists());
	}
	
	/**
	 * TC12: Update operation on Users
	 * Test to verify that the database can load, update, and save existing users
	 * The test is performed by loading a user object, updating the information, and verfying it
	 * Once the test is complete no errors will appear and the information is updated
	 */
	public function testUpdateUser() {
		//Load the user
		$user = Doctrine_Query :: create()
								->from('User u')
								->where('u.username=?', 'unittest2')
								->fetchOne();
		//Change some attributes
		$user['first_name'] = 'testing';
		$user['last_name'] = 'testing2';
		
		//Save & Verify
		$user->save();
		
		$this->assertTrue($user->exists());
		$this->assertEquals($user['first_name'], 'testing');
		$this->assertEquals($user['last_name'], 'testing2');
	}
	
	/**
	 * TC12: Delete operation on Users
	 * Test to verify that the database can delete existing users
	 * The test is performed by deleting a user object
	 * Once the test is complete no errors will appear and the user no longer exists
	 */
	public function testDeleteUser() {
		//Delete the user
		$number_deleted = Doctrine_Query :: create()
								->delete()
								->from('User u')
								->where('u.username=?', 'unittest2')
								->execute();
		
		$this->assertEquals($number_deleted, 1);
	}
}