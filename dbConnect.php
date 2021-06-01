<?php

$host = "localhost";
$dbname = "db_wordpress";
$user = "root";
$pass = "";

$dsn = 'mysql:host=' . $host . ';dbname=' . $dbname;

$options = array(
    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
);

try {
    $dbh = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
    print "Erreur de connexion : " . $e->getMessage() . "<br/>";
    die();
}
