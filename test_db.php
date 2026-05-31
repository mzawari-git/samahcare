<?php
try {
    $pdo = new PDO('mysql:host=127.0.0.1;dbname=samahcare', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo 'Database connection successful';
} catch(PDOException $e) {
    echo 'Database connection failed: ' . $e->getMessage();
}
?>