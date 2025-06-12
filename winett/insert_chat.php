<?php

require('database_connections.php');

session_start();

echo insert_chat($connect);
?>