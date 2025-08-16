<?php
$host = 'localhost';
$db   = 'missing_tracker';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION];
try {
    $pdo = new PDO($dsn,$user,$pass,$options);
} catch (PDOException $e) {
    die('DB connection failed: '.$e->getMessage());
}
session_start();
?>