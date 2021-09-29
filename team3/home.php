<?php 
	session_start();
	include_once('users.php');
	include_once('conn.php');
	$id=$_SESSION['user_session'];
	if(!$_SESSION['user_id'])
	{
		header("location: index.php");
	}
	if(isset($_POST['logout']))
	{
		header("location: logout.php");
	}
	if($_SESSION['user_id']==3)
	{
		header("location: admin.php");
	}
	if(isset($_POST['comment']))
	{
		$comment = strip_tags($_POST['txt_comment']);
		$from_id = $id;
		$date_commented = date("Y-m-d H-i-s");
        $sqli = "INSERT into comments(comment, commenter_id, date_commented) 
		        VALUES('$comment', '$from_id', '$date_commented')";
		$statement2 = $conn->prepare($sqli);
 		$statement2->execute();

	}
 
	$sql = "SELECT * FROM users WHERE user_id='$id'";
	$stmt = $conn->prepare($sql);
	$stmt->execute();
	$row=$stmt->fetch(PDO::FETCH_ASSOC);
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
		.colz{
			column-count: 4;
		}
		.navbar{
			height: 30px;
			background-color: white;
			margin-left: 0px;
			margin-right: 0px;
			color: black;
		}
		.admin{
	
			border:1px solid black; border-radius: 15px;
			padding-left:10px; margin-right: 1%; margin-top: 6px;
			width: 100%;
			padding-right: 10px;
			font-size:120%; color:black;
		}
		.admin1{
			position: absolute; left:34px; top:5px;		 
			padding-left:10px; margin-right: 1%; margin-top: 6px;
			width: 120px;
			padding-right: 10px;
			font-size:120%; color:navy;
		}
		.dropdown {
		    position: absolute;
		    right: 5%;
		    top:5px;
		    display: inline-block;
		    color:black;
		}

		.dropdown-content {
		    display: none;
		    position: absolute;
		    background-color: #f9f9f9;
		    min-width: 100px;
		    box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
		    padding: 12px 16px;
		    z-index: 1;
		}
		.comment{
			color:black;
		}
		.delete{
			color: red;
			position: absolute;
			right:10%;
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
		.user{
			color:orange;
		}
		.dropdown:hover .dropdown-content {
		    display: block;
		}
		.mid-view{
			background-color: white;
			width: 100%;
			height: 250px;	
		}
		.mid{
			color: black;
			font-family: fantasy;
			font-size: 180%;
			padding: 2%;
		}
		small{
			color: black;
		}
		img{
			border-radius: 100%;
			position: absolute; left: 5px; top: 7px;
		}
		.dates{
			position: absolute;
			right: 10%;
			text-align: right;
		}
		i{
			font-size: 90%;
		}
		.success{
			position: fixed;right: 5%;
			top:52px;margin-right: 2px;
		}
	</style>
</head>
<body>
	<div class="container">
		<?php if(isset($_SESSION)) ?>
		<nav class="navbar  navbar-fixed-top">
			<div class="dropdown">
				<form method="post">
				    <button class="admin" name="logout">Logout</button>
				</form>
			</div>
			<img src="profile.jpg" alt="PIC" width="30" height="30">
			<a href="home.php" class="admin1"><?php echo $row['display_name'];?></a>
		</nav><br><br>
		<form method="post" action="">
			<button class="btn btn-info success" type="submit" name="survey">TAKE SURVEY</button>
		</form>
		<hr>
		<div class="mid-view">
			<p class="mid">
			    The Internet is a hostile environment, and you must be vigilant to ensure your data is not compromised. Attackers
				are creative and will attempt many different techniques to trick users. This lab helps you identify risky online
				behavior and provide tips on how to become safer online. To check your online behavior please click the bottom "Take survey" above and answer a short survey.</p><br><br>
		</div>
		<br>
		<label>How was this survey? give us a feedback bellow.</label><br>
		<form action="" method="post">
			<textarea class="comment" cols="80" rows="2" name="txt_comment" placeholder="Your comment here."></textarea><br>
			<button type="submit" class="btn btn-success" name="comment">&nbsp;Comment
            </button>
		</form><br>Comments<hr>
		<div class="comments"><?php
			$sqls = "SELECT * FROM comments order by comment_id desc";
			$stmts = $conn->prepare($sqls);
			$stmts->execute();
			$rows=$stmts->fetchAll();
			foreach ($rows as $commenti) 
			{
				$ids = $commenti['commenter_id'];
				$sqly = "SELECT * FROM users WHERE user_id='$ids'";
				$stmty = $conn->prepare($sqly);
				$stmty->execute();
				$rowy=$stmty->fetch(PDO::FETCH_ASSOC);
				if($commenti['commenter_id'] == $id){
					echo "<a href='comment_delete.php?id=".$commenti['comment_id']."'><p class='delete'>Delete</p></a><p class='commenti'><b class='user'>~"." You "."</b><br><span class='commentz'>".$commenti['comment']."</span><br><span class='dates'> <i>Posted : </i> <small>".$commenti['date_commented']."</small></span></p><hr>";
				}
				else{
					echo "<p class='commenti'><b class='user'>~".$rowy['display_name']."</b><br><span class='commentz'>".$commenti['comment']."</span><br><span class='dates'> <i>Posted : </i> <small>".$commenti['date_commented']."</small></span></p><hr>";
				}
			}
		?></div>
	</div>
</body>
</html>