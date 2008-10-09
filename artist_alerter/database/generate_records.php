<?php

require_once('doctrine/lib/Doctrine.php');

spl_autoload_register(array('Doctrine', 'autoload'));
$ini_array = parse_ini_file('settings.ini');
define('DSN', 'pgsql://' . $ini_array['username'] . ':'. $ini_array['password'] .'@localhost/artist_alert');
Doctrine_Manager::connection(DSN);

// import method takes one parameter: the import directory (the directory where
// the generated record files will be put in
Doctrine::generateModelsFromDb('classes');