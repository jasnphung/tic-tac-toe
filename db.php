<?php
$host = 'localhost';
$dbname = 'tictacdb';
$user = 'postgres';
$pass = 'admin'; //INCLUDE YOUR PASSWORD TO ACCES THE DB OR REMOVE IF NO PASSWORD IS SET

try {
    $dsn = "pgsql:host=$host;port=5432;dbname=$dbname;";
    $pdo = new PDO($dsn, $user, $pass, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
}
?>