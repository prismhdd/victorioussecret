<?php
require_once('config.php');
	
	$conn = Doctrine_Manager :: connection(DSN);

	$artists = Doctrine_Query::create()
		          ->from('Artist a')
		          ->execute();
		          
	foreach($artists as $artist) {
		print($artist['name']);
	}