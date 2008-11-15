<?php
require_once '../database/config.php';
require_once 'PHPUnit/Framework.php';

$conn = Doctrine_Manager :: connection(DSN);

class AlbumTest extends PHPUnit_Framework_TestCase {

	/**
	 * Sets up each test case
	 */
	public function setUp() {
		//Create an artist to use with each Album
		$this->artist = new Artist();
		
		$this->artist['name'] = 'testartist';
		$this->artist['added_by_user_id'] = 1; //SYSTEM user
		
		$this->artist->save();
		//Create an album for the Read, Update, and Delete Operations
		$album = new Album();

		$album['artist_id'] = $this->artist['artist_id'];
		$album['name'] = 'testalbum';
		$album['added_by_user_id'] = 1; //SYSTEM user

		$album->save();
	}
	
	/**
	 * Cleans up after each test case
	 */
	public function tearDown() {
		//Clean up the fake artists/albums we created
		Doctrine_Query :: create()
								->delete()
								->from('Album a')
								->where('a.name=? OR a.name=?', array('testalbum', 'testalbum2'))
								->execute();
		Doctrine_Query :: create()
								->delete()
								->from('Artist a')
								->where('a.name=?', array('testartist'))
								->execute();
	}

	/** 
	 * TC12: Create operation on Albums
	*	Test to verify that the database can save new albums
	*	The test is performed by creating an album object with the required input fields
	*	Once the test is complete no errors will appear and the album will be in the database
	*/
	public function testCreateAlbum() {
		//Create the album
		$album = new Album();

		$album['artist_id'] = $this->artist['artist_id'];
		$album['name'] = 'testalbum2';
		$album['added_by_user_id'] = 1; //SYSTEM user

		$album->save();
		
		//Verify it exist now
		$this->assertTrue($album->exists());
	}
	
	/**
	 * TC12: Read operation on Albums
	 * Test to verify that the database can read existing albums
	 * The test is performed by loading an album object and verifying the information
	 * Once the test is complete no errors will appear
	 */
	public function testReadAlbum() {
		$album = Doctrine_Query :: create()
								->from('Album a')
								->where('a.name=? AND a.Artist.name=?', array('testalbum','testartist'))
								->fetchOne();
		$this->assertEquals($album['name'], 'testalbum');
		$this->assertTrue($album->exists());
		$this->assertEquals($album['Artist']['name'], 'testartist');
	}
	
	/**
	 * TC12: Update operation on Albums
	 * Test to verify that the database can load, update, and save existing albums
	 * The test is performed by loading an album object, updating the information, and verfying it
	 * Once the test is complete no errors will appear and the information is updated
	 */
	public function testUpdateAlbum() {
		//Load the album
		$album = Doctrine_Query :: create()
								->from('Album a')
								->where('a.name=? AND a.Artist.name=?', array('testalbum','testartist'))
								->fetchOne();
		//Change some attributes
		$album['name'] = 'testalbum2';
		
		//Save & Verify
		$album->save();
		
		$this->assertEquals($album['name'], 'testalbum2');
		$this->assertTrue($album->exists());
		$this->assertEquals($album['Artist']['name'], 'testartist');
	}
	
	/**
	 * TC12: Delete operation on Albums
	 * Test to verify that the database can delete existing albums
	 * The test is performed by deleting an album object
	 * Once the test is complete no errors will appear and the album no longer exists
	 */
	public function testDeleteAlbum() {
		//Delete the album
		$number_deleted = Doctrine_Query :: create()
								->delete('a')
								->from('Album a')
								->where('a.name=?', array('testalbum'))
								->execute();
		
		$this->assertEquals($number_deleted, 1);
	}
}