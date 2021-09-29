<?php 
	session_start();
	include_once('conn.php');
	include_once('users.php');
	$id = $_SESSION['user_id'];
 	if(isset($_POST['survey']))
	{
		header("Location: survey.php");
	}
	if(isset($_POST['logout']))
	{
		header("location: logout.php");
	}
	if(isset($_POST['add']))
	{
		header("location: questions.php");	
	}
	if(!($_SESSION['user_id']==3))
	{
		header("location: home.php");
	}
	if(isset($_POST['comment']))
	{
		$comment = strip_tags($_POST['txt_comment']);
		
		$date_commented = date("Y-m-d H-i-s");
        $sqli = "INSERT into comments(comment, commenter_id, date_commented) 
		        VALUES('$comment', '$id', '$date_commented')";
		$statement2 = $conn->prepare($sqli);
 		$statement2->execute();
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

			background-color: #2F4F4F;
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
			background-color: white /*#009973*/;
			margin-left: 0px;
			margin-right: 0px;
		}
		.admin{
			position: absolute; right: 60px;
			text-align: center;
			border:1px solid black;
			padding-left:10px;  
			border-radius: 15px;
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
			right: 5px; top: 9%;
			font-family:monospace ;font-size: 120%;
		    position: absolute;
		    display: inline-block;
		    color:black;
		}

		.dropdown-content {
		    display: none;
		    position: absolute;
		    background-color: #f9f9f9;
		    min-width: 180px;
		    box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
		    padding: 12px 16px;
		    z-index: 1;
		}
		.comment{
			color:black;
		}
		.comments{
			padding:2%;
			border-top:1px solid silver;	
		}
		.commentz{
			color: white;
			padding-left: 2%;
			font-style: initial;
		}
		.commenti{
			
		}
		.user{
			color: orange;
		}
		.btn-primary{
			position: absolute;
			right:10%;
		}
		.manage{
			color: black;
			min-width: 150px;
			text-align: center;
			margin-right: 10px;
			padding: 6px;  /*
			position: absolute; left:15%;*/
		}
		.btn2{
			position: relative;
			left: 0px;
		}
		.delete{
			color: red;
			position: absolute;
			right:10%;
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
		.modal >img{
			 
		}
		.drop1{
			right: 20%; top: 5px;
			font-family:monospace ;font-size: 120%;
		    position: absolute;
		    display: inline-block;
		    color:black;
		}
		.drop1:hover .dropdown-content {
		    display: block;
		}
		.drop1:hover .dropdown-content {
		    display: block;
		}
		#myImg {
			position: absolute;right: 165px; top:5px;
		    border-radius: 100%;
		    cursor: pointer;
		    transition: 0.3s;
		}

#myImg:hover {opacity: 0.7;}

/* The Modal (background) */
.modal {
    display: none; /* Hidden by default */
    position: fixed; /* Stay in place */
    z-index: 1; /* Sit on top */
    padding-top: 50px; /* Location of the box */
    left: 0;
    top: 0;
    width: 100%; /* Full width */
    height: 100%; /* Full height */
    overflow: auto; /* Enable scroll if needed */
    background-color: rgb(0,0,0); /* Fallback color */
    background-color: rgba(0,0,0,0.9); /* Black w/ opacity */
}

/* Modal Content (Image) */
.modal-content {
    margin: auto;
    display: block;
    width: 80%;
    max-width: 600px;
}

/* Caption of Modal Image (Image Text) - Same Width as the Image */
#caption {
    margin: auto;
    display: block;
    width: 80%;
    max-width: 700px;
    text-align: center;
    color: #ccc;
    padding: 10px 0;
    height: 150px;
}

/* Add Animation - Zoom in the Modal */
.modal-content, #caption {
    -webkit-animation-name: zoom;
    -webkit-animation-duration: 0.10s;
    animation-name: zoom;
    animation-duration: 0.10s;
}

@-webkit-keyframes zoom {
    from {-webkit-transform:scale(0)}
    to {-webkit-transform:scale(1)}
}

@keyframes zoom {
    from {transform:scale(0)}
    to {transform:scale(1)}
}

/* The Close Button */
.closed {
	background-color: red;
    position: absolute;
    top: 40px;
    text-align: center;
    width: 50px;
    height:50px;
    right: 40px;
    color: white;
    font-size: 40px;
    font-weight: bold;
    transition: 0.6s;
}
.Imgs{
	position: absolute; left:0px; top: 1px;max-width: 120px min-height:33px;
}
.closed:hover,
.closed:focus {
	background: white;
    color: red;
    text-decoration: none;
    cursor: pointer;
}

/* 100% Image Width on Smaller Screens */
@media only screen and (max-width: 700px){
    .modal-content {
        width: 100%;
    }
}
	</style>
</head>
<body>
	<div class="container">
		<nav class="navbar  navbar-fixed-top">
			<img id="myImg" src="admin.png" alt="The Underworld" width="30" height="30">
			<div id="myModal" class="modal">
			  	<span class="closed" onclick="document.getElementById('myModal').style.display='none'">&times;</span>
			  	<img class="modal-content" id="img01">
			  	<div id="caption"></div>
			</div>
			<div class="dropdown drop1">
				<p class="manage">Manage survey &#9660;</p>
				<div class="dropdown-content">
				    <a href="questions.php">+ Add question</a><br>
				    <a href="admin_survey.php">View questions</a><br>
				</div>
			</div>
			<a href="#"> <img class="Imgs" src="admin_pic.jpg" alt="Admin" width="150" height="47"></a>
			<div class="dropdown">
			  	<form method="post">
			    <button class="admin" name="logout">Logout</button>
			</form>
			</div>
		</nav><br><br>
		<form method="post">
			<button class="btn btn-primary btn2" type="submit" name="survey">TEST SURVEY</button>
		</form>
		<hr>
		
		<label><h4>Admin post</h4></label>
		<form action="" method="post">
			<textarea class="comment" cols="80" rows="2" name="txt_comment" placeholder="Hi Admin. Want to say something to the users? leave it here." required="required"></textarea><br>
			<button type="submit" class="btn btn-success" name="comment">&nbsp;Post
            </button>
		</form><br><br>Comments
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
				if($commenti['commenter_id'] == 3){
					echo "<a href='comment_delete.php?id=".$commenti['comment_id']."'><p class='delete'>Delete</p></a><p class='commenti'><b class='user'>~".$rowy['display_name']."</b><br><span class='commentz'>".$commenti['comment']."</span><br><span class='dates'> <i>Posted : </i> <small>".$commenti['date_commented']."</small></span></p><hr>";
				}
				else
				{
					echo "<a href='delete_post.php?id=".$commenti['comment_id']."'><p class='delete'>Delete</p></a><p class='commenti'><b class='user'>~".$rowy['display_name']."</b><br><span class='commentz'>".$commenti['comment']."</span><br><span class='dates'> <i>Posted : </i> <small>".$commenti['date_commented']."</small></span></p><hr>";
				}
				
			}
		?></div>

	</div>
	<script>
		$(document).on('click', '.delete', function(){
			window.alert("One comment has been deleted!");
		});
	</script>
	
	<script type="text/javascript">
		var modal = document.getElementById('myModal');
		// Get the image and insert it inside the modal - use its "alt" text as a caption
		var img = document.getElementById('myImg');
		var modalImg = document.getElementById("img01");
		var captionText = document.getElementById("caption");
		img.onclick = function(){
		    modal.style.display = "block";
		    modalImg.src = this.src;
		    modalImg.alt = this.alt;
		    captionText.innerHTML = this.alt;
		}
		// Get the <span> element that closes the modal
		var span = document.getElementsByClassName("close")[0];
		// When the user clicks on <span> (x), close the modal
		span.onclick = function() {
		  modal.style.display = "none";
		}
	</script>
</body>
</html>