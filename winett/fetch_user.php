<?php

//fetch_user.php
$conn = mysqli_connect("localhost","root","","wenett");
require('database_connections.php');

session_start();

echo fetch_user($conn, $connect);
?>