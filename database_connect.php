<!-- This is a file that can be included to connect to the database-->
<?php

try {
    $connect = new PDO('mysql:host=localhost;dbname=bank', 'root', 'root');
    //echo "database connected";

} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>