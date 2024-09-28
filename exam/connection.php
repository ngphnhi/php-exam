<?php
$host = "mysql:host=localhost:3306;dbname=v_store";
$username = 'root';
$password = '';

try {
    $pdo = new PDO($host, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $ex) {
    echo "connection failed: " . $ex->getMessage();
}
?>
