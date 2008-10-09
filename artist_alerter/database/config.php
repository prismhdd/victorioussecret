<?php
define('CLASS_PATH', dirname(__FILE__));
define('DOCTRINE_PATH', CLASS_PATH . DIRECTORY_SEPARATOR . 'doctrine/lib');
define('MODELS_PATH', CLASS_PATH . DIRECTORY_SEPARATOR . 'classes');
$ini_array = parse_ini_file('settings.ini');
define('DSN', 'pgsql://' . $ini_array['username'] . ':'. $ini_array['password'] .'@localhost/artist_alert');

require_once(DOCTRINE_PATH . DIRECTORY_SEPARATOR . 'Doctrine.php');

spl_autoload_register(array('Doctrine', 'autoload'));

Doctrine_Manager::getInstance()->setAttribute('model_loading', 'conservative');

Doctrine::loadModels(MODELS_PATH . DIRECTORY_SEPARATOR . 'generated');
Doctrine::loadModels(MODELS_PATH);