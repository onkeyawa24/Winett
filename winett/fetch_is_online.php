<?php

//fetch_user_chat_history.php
include('conn.php');
include('database_connections.php');

session_start();
$is_online = "<span style='color: white; position: absolute; right: 50px; top: 25px;'><small> Offline </small></span>";

if(is_online($_POST['to_user_id'], $connect))
{
	$is_online = "<span style='color: #7CFC00; position: absolute; right: 50px; top: 25px;'><small> Online </small></span>";
}
echo $is_online;
?>