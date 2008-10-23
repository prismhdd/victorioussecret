<?php

$dsn = 'pgsql://'.'@127.0.0.1/artist_alerter';
$user = '';
$password = '';

try {
    $dbh = new PDO($dsn, $user, $password);
    $conn = Doctrine_Manager::connection($dbh);
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
}

?>
