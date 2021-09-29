<?php
session_start();
include_once('users.php');
include_once('conn.php');
$ids=$_SESSION['user_id'];
if(isset($_GET['id']))
{ 
	$id = $_GET['id'];
	$sql = "DELETE from comments WHERE comment_id='$id'";
	$stmt = $conn->prepare($sql);
	$stmt->execute();
	$row=$stmt->fetch(PDO::FETCH_ASSOC);

	header("Location: home.php");
}
	 
	?>