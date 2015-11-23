<?php
session_start();

define('MYSQL_USER', 'root');
define('MYSQL_PASSWORD', 'root');
define('MYSQL_HOST', 'localhost');
define('MYSQL_DATABASE', 'NextdoorDB');

$pdo = new PDO(
    "mysql:host=" . MYSQL_HOST . ";dbname=" . MYSQL_DATABASE, //DSN
    MYSQL_USER, //Username
    MYSQL_PASSWORD, //Password
    $pdoOptions //Options
);

$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>
