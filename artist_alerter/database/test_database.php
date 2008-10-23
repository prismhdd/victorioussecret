<?php
	require_once('config.php');
	$artists = Doctrine_Query::create()
		          ->from('Artist a')
		          ->execute();
		          
	foreach($artists as $artist) {
		print($artist['name']);
	}
	
	
	$conn = Doctrine_Manager :: connection(DSN);
	
	
	$user = new User();
	
	$user['first_name'] = 'test';
	$user['last_name'] = 'test2';
	$user['password'] = 'fun';
	$user['email_address'] = 'test4';
	
	$user->save();
	
	/*
	try {
		$user->save();
	} catch (Doctrine_Connection_Pgsql_Exception $e) {
		print $e;
	} 
	*/

	
	