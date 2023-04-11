<?php

try {
    $connect = new PDO('mysql:host=localhost;dbname=realbank', 'root', '');
    echo "Database connected successfully!";
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>