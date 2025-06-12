<?php

require('database_connections.php');

session_start();

echo delete_live_chat($connect);
?>