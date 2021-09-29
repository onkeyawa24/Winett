<?php
session_start();
include_once('users.php');
include_once('conn.php');

if(!($_SESSION['user_id']==3))
{
	header("location: index.php");
}

$ids=$_SESSION['user_id'];
if(isset($_GET['id']))
{ 
	$delete_id = $_GET['id'];
 
	$sqly = "DELETE FROM table_options WHERE option_id='$delete_id'";
	$stmty = $conn->prepare($sqly);
	$stmty->execute();
	$rowy=$stmty->fetch(PDO::FETCH_ASSOC);
	 
	header("Location: admin_survey.php");
}
?>