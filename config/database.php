<?php
try {
    $db_host = 'localhost';
    $db_name = 'videolingo';
    $db_user = 'root';
    $db_pass = '';
    
    $dsn = "mysql:host=$db_host;dbname=$db_name;charset=utf8mb4";
    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false
    ];
    
    $pdo = new PDO($dsn, $db_user, $db_pass, $options);
} catch(PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?> 