<?php
require_once '../database/config.php';
require_once 'PHPUnit/Framework.php';

$conn = Doctrine_Manager :: connection(DSN);

class ArtistTest extends PHPUnit_Framework_TestCase {

	/**
	 * Sets up each test case
	 */
	public function setUp() {
		//Create an artist for the Read, Update, and Delete Operations
		$artist = new Artist();
		
		$artist['name'] = 'testartist';
		$artist['added_by_user_id'] = 1; //SYSTEM user
		
		$artist->save();
	}
	
	/**
	 * Cleans up after each test case
	 */
	public function tearDown() {
		//Clean up the fake artists/artists we created
		Doctrine_Query :: create()
								->delete()
								->from('Artist a')
								->where('a.name=? OR a.name=?', array('testartist', 'testartist2'))
								->execute();
	}

	/** 
	 * TC12: Create operation on Artists
	*	Test to verify that the database can save new artists
	*	The test is performed by creating an artist object with the required input fields
	*	Once the test is complete no errors will appear and the artist will be in the database
	*/
	public function testCreateArtist() {
		//Create the artist
		$artist = new Artist();
		
		$artist['name'] = 'testartist2';
		$artist['added_by_user_id'] = 1; //SYSTEM user

		$artist->save();
		
		//Verify it exist now
		$this->assertTrue($artist->exists());
	}
	
	/**
	 * TC12: Read operation on Artists
	 * Test to verify that the database can read existing artists
	 * The test is performed by loading an artist object and verifying the information
	 * Once the test is complete no errors will appear
	 */
	public function testReadArtist() {
		$artist = Doctrine_Query :: create()
								->from('Artist a')
								->where('a.name=?', array('testartist'))
								->fetchOne();
		$this->assertEquals($artist['name'], 'testartist');
		$this->assertTrue($artist->exists());
	}
	
	/**
	 * TC12: Update operation on Artists
	 * Test to verify that the database can load, update, and save existing artists
	 * The test is performed by loading an artist object, updating the information, and verfying it
	 * Once the test is complete no errors will appear and the information is updated
	 */
	public function testUpdateArtist() {
		//Load the artist
		$artist = Doctrine_Query :: create()
								->from('Artist a')
								->where('a.name=?', array('testartist'))
								->fetchOne();
		//Change some attributes
		$artist['name'] = 'testartist2';
		
		//Save & Verify
		$artist->save();
		
		$this->assertEquals($artist['name'], 'testartist2');
		$this->assertTrue($artist->exists());
	}
	
	/**
	 * TC12: Delete operation on Artists
	 * Test to verify that the database can delete existing artists
	 * The test is performed by deleting an artist object
	 * Once the test is complete no errors will appear and the artist no longer exists
	 */
	public function testDeleteArtist() {
		//Delete the artist
		$number_deleted = Doctrine_Query :: create()
								->delete('a')
								->from('Artist a')
								->where('a.name=?', array('testartist'))
								->execute();
		
		$this->assertEquals($number_deleted, 1);
	}
}