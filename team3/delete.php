<?php
session_start();
include_once('users.php');
include_once('conn.php');

if(!($_SESSION['user_id']==3))
{
	header("location: index.php");
}

$ids=$_SESSION['user_id'];
if(isset($_GET['delete']))
{ 
	$delete_id = $_GET['delete'];
 
	$sqly = "DELETE FROM questions WHERE question_id=$delete_id";
	$stmty = $conn->prepare($sqly);
	$stmty->execute();
	$rowy=$stmty->fetch(PDO::FETCH_ASSOC);
	header("location: admin_survey.php");
}
?>