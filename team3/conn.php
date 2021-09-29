
<?php
    //MySQLi Procedural

$conn = new PDO("mysql:host=localhost;dbname=under_world", "root", "");
    if (!$conn) {
    	die("Connection failed: " . mysqli_connect_error());
    }
     
?>