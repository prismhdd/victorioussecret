<?php
require_once('config.php');
	
	$conn = Doctrine_Manager :: connection(DSN);
	
	
	$user = new User();
	
	//$user['first_name'] = 'test';
	$user['last_name'] = 'test2';
	$user['password'] = md5('fun');
	$user['email_address'] = 'test4';
	
	try {
		$user->save();
	} catch (Doctrine_Connection_Pgsql_Exception $e) {
		print $e;
	} 

	$artists = Doctrine_Query::create()
		          ->from('Artist a')
		          ->execute();
		          
	foreach($artists as $artist) {
		print($artist['name']);
	}