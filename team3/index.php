<?php
session_start(); 
include_once('conn.php');
include_once('users.php');
	if(isset($_SESSION['user_id']))
	{
		if($_SESSION['user_id']==3){
			header("location: admin.php");
		}
		else
	 	{
	 		header("location: home.php");
	 	}
	}
	if(isset($_POST['login']))
	{
		header("location: login.php");
	}
	if(isset($_POST['comment']))
	{
		if(!($_SESSION['user_id']))
		{
			header("Location: login.php");		
		}
		else
		{
			header("Location: home.php");
		}
		 

	}
 	if(isset($_POST['survey']))
	{
		header("Location: survey.php");
	}

?>
<!DOCTYPE html>
<html>
<head>
	<title>Team3</title>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="./js/jquery-ui.css">
	<link rel="stylesheet" href="./js/bootstrap.min.css">
	<script src="./js/jquery-1.12.4.js"></script>
	<script src="./js/bootstrap.min.js"></script>
	<script src="./js/jquery-ui.js"></script>

	<style>
		html{
			background-color: silver;
		}
		body{
			background-color: #2F4F4F;;
			color: white;
			margin-left: 5%;
			margin-right: 5%;
			margin-top: 1%;
			padding-top: 1%;
			padding-bottom: 10%; 
		}
		.cols{
			column-count: 4;
		}
		.navbar{
			height: 30px;
			background-color: white;
			margin-left: 0px;
			margin-right: 0px;
		}
		.admin{
			position: absolute;right:2%;
			text-align: center;
			border:1px solid black;
			padding-left:10px; margin-right: 1%; margin-top: 6px;
			border-radius: 15px;
			padding-right: 10px;
			font-size:120%; color:black;
		}
		.dropdown {
			margin-left: 90%; margin-right: 1%;
		    position: relative;
		    display: inline-block;
		    color:black;
		}

		.dropdown-content {
		    display: none;
		    position: absolute;
		    background-color: #f9f9f9;
		    min-width: 80px;
		    box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
		    padding: 12px 16px;
		    z-index: 1;
		}

		.dropdown:hover .dropdown-content {
		    display: block;
		}
		.comment{
			color:black;padding:2px 5px 2px 10px;
			border-radius: 10px;
		}
		.comments{
			padding:2%;
			
		}
		.commentz{
			color: white;
			padding-left: 2%;
			font-style: initial;
		}
		.commenti{
			
		}
		.delete{
			color: red;
			position: absolute;
			right:10%;
		}
		.user{
			color: orange;
		}
		.mid-view{
			background-color: white;
			/*background-image: url(images.jpg);*/
			width: 100%;
			height: 250px;	
		}
		.mid{
			color: black;
			font-family: monospace;
			font-size: 190%;
			padding: 2%;
		}
		small{
			color: black;
		}
		.dates{
			position: absolute;
			right: 10%;
			text-align: right;
		}
		i{
			font-size: 90%;
		}
		img{
			border-radius: 100%;
			position: absolute; left: 5px; top: 7px;
		}
		.admin1{
	      position: absolute; left:34px; top:5px;    
	      padding-left:10px; margin-right: 1%; margin-top: 6px;
	      width: 120px;
	      padding-right: 10px;
	      font-size:120%; color:navy;
	    }
	</style>
</head>
<body>
	<div class="container">
		<nav class="navbar  navbar-fixed-top">
			<form method="post">
			    <button class="admin" name="login">Login</button>
			</form>
			<img src="profile.jpg" alt="PIC" width="30" height="30">
          	<a href="index.php" class="admin1">Guest</a>
		</nav><br><br>
		<form method="post">
			<button class="btn btn-success" type="submit" name="survey">TAKE SURVEY</button>
		</form>
		<hr>
		<div class="mid-view">
			<p class="mid">
		    The Internet is a hostile environment, and you must be vigilant to ensure your data is not compromised. Attackers
			are creative and will attempt many different techniques to trick users. This lab helps you identify risky online
			behavior and provide tips on how to become safer online. To check your online behavior please click the bottom "Take survey" above and answer a short survey.</p><br><br>
		</div>
		<br><br>
		<p style="font-size: 130%"> Comments and feedback by the users.</p><hr>

		<div class="comments"><?php
			$sqls = "SELECT * FROM comments order by comment_id desc";
			$stmts = $conn->prepare($sqls);
			$stmts->execute();
			$rows=$stmts->fetchAll();
			foreach ($rows as $commenti) {
				$ids = $commenti['commenter_id'];
				$sqly = "SELECT * FROM users WHERE user_id='$ids'";
				$stmty = $conn->prepare($sqly);
				$stmty->execute();
				$rowy=$stmty->fetch(PDO::FETCH_ASSOC);
				echo "<p class='commenti'><b class='user'>~".$rowy['display_name']."</b><br><span class='commentz'>".$commenti['comment']."</span><br><span class='dates'> <i>Posted : </i> <small>".$commenti['date_commented']."</small></span></p><hr>";
			}
		?></div>
		<label>Leave a comment.</label><br>
		<form action="" method="post">
			<textarea class="comment" cols="70" rows="2" name="txt_comment" placeholder="How was this survey?  leave comment here."></textarea><br>
			<button type="submit" class="btn btn-success" name="comment">&nbsp;Comment
            </button>
		</form><br>

	</div>
</body>
</html>