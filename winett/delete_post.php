<?php
include_once('conn.php');
include('database_connections.php');
include_once('class.user.php');
include_once('class.post.php');
$auth_user = new USER();
$id=$_GET['id'];

$sql = $auth_user->runQuery("DELETE from post_table where post_id = '$id'");
$sql->execute(array());
header('location:Posts.php');


?>