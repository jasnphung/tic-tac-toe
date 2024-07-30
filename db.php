<?php
$host = 'localhost';
$dbname = 'tictacdb';
$user = 'postgres';
$pass = '';//INCLUDE YOUR PASSWORD TO ACCES THE DB

try {
    $dsn = "pgsql:host=$host;port=5432;dbname=$dbname;";
    $pdo = new PDO($dsn, $user, $pass, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
}
?>