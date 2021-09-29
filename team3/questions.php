<?php
	/*************************CONNECTION**********************/
	session_start();
	$conn = new PDO("mysql:host=localhost;dbname=under_world", "root", "");
    if (!$conn) {
    	die("Connection failed: " . mysqli_connect_error());
    }
    /*********************************************************/
    if(isset($_POST['btn-cancel']))
	{
		header("Location: index.php");
	}
	if(!($_SESSION['user_id']==3))
	{
		header("location: home.php");
	}
	if(isset($_POST['btn-add']))
	{
		$question = strip_tags($_POST['question']);

		$answer1= strip_tags($_POST['answer1']);
		$score1= $_POST['score1'];
		$answer2= strip_tags($_POST['answer2']);
		$score2= $_POST['score2'];
		$answer3= strip_tags($_POST['answer3']);
		$score3= $_POST['score3'];
		$answer4= strip_tags($_POST['answer4']);
		$score4= $_POST['score4'];

		$advice= strip_tags($_POST['advice']);

		/****************************************************/
		
		try
		{
			$query = "INSERT into questions (question) values ('$question')";
			$statement = $conn->prepare($query);
 			$statement->execute();

			$result = "SELECT * FROM questions WHERE question='$question' limit 1";
			$statement2 = $conn->prepare($result);
 			$statement2->execute();
 			$rows = $statement2->fetchAll();
 			foreach($rows as $row)
			{
			  	$que_id = $row['question_id'];
			}
			
			$sql1 = "INSERT into table_options (options, question_id, score) values ('$answer1', '$que_id', '$score1')";
			$statement3 = $conn->prepare($sql1);
 			$statement3->execute();

			$sql2 = "INSERT into table_options (options, question_id, score) values ('$answer2', '$que_id', '$score2')";
			$statement4 = $conn->prepare($sql2);
 			$statement4->execute();
			$sql3 = "INSERT into table_options (options, question_id, score) values ('$answer3', '$que_id', '$score3')";
			$statement5 = $conn->prepare($sql3);
 			$statement5->execute();
			$sql4 = "INSERT into table_options (options, question_id, score) values ('$answer4', '$que_id', '$score4')";
			$statement6 = $conn->prepare($sql4);
 			$statement6->execute();
			$sql5 = "INSERT into advices (question_id, advice) values ('$que_id', '$advice')";
			$statement7 = $conn->prepare($sql5);
 			$statement7->execute();
 			echo '
                <div class="alert alert-success">
				  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
				  Successfully added the question.
				</div>
 			';
 			header("Location: admin_survey.php");
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
		}
	}
?>
<!DOCTYPE html  >
 
<head>
	<title>Set questions</title>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="./js/jquery-ui.css">
      <link rel="stylesheet" href="./js/bootstrap.min.css">
      <script src="./js/jquery-1.12.4.js"></script>
      <script src="./js/jquery-ui.js"></script>

<style type="text/css">
html{
	width: 100%;
}
	body{
		margin-top: 25px;
        background-color: grey;
    }
  	.sign_form{
		color: black;
		background-color: #DCDCDC;
		width: 100%;
		padding-left: 2%;
		 
	}
	.form-group1{
		
	}
	label{
		color: black;
		background-color: grey;
		width: 100%;
		padding:1%;
	}
	.rad-butns{
		color: white;
	}
	.signup{
		background-color: #2F4F4F;
		margin-top: 5%;
		padding: 2%;
	}
	.select-user-type{
		margin-top: 2%;
		margin-bottom: 2%;
		margin-left: -2%;
	}
	.singn_form_date{
		/*border:none;
		border-bottom: solid;
		border-width: 1px;
		border-color: #DA6501;*/
		width: 32%;
	}
	h2{
		color: #DA6501;
		font-style: bold;
	}
	.date-of-birth{
		margin-top: 2%;
		margin-bottom: 2%;
	}
	.score{
		width: 100px;
	}
	.btn{
		width: 49%;
	}
	.back{
		color: black;
		padding-left: 20px;
		font-size: 140%;
	}
	.cols{
			column-count: 4;
		}
		.navbar{
			height: 30px;
			background-color: white/*#009973*/;
			margin-left: 0px;
			margin-right: 0px;
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
		.Imgs{
			position: absolute; left:0px; top: 1px;max-width: 120px min-height:33px;
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
.admin{
	position: absolute; right: 60px;
	text-align: center;
	border:1px solid black;
	padding-left:10px;  
	border-radius: 15px;
	padding-right: 10px;
	font-size:120%; color:black;
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
		<a href="admin.php"><img class="Imgs" src="admin_pic.jpg" alt="Admin" width="150" height="47"></a>
		<div class="dropdown">
		  	<form method="post">
		    <button class="admin" name="logout">Logout</button>
		</form>
		</div>
	</nav>
<div class="col-md-12">
    <div class="col-md-3">
    	
    </div>
    <div class="col-md-6">
		 
			 
		    	<div class="signup">
		        	<form method="post">
				            <label>Enter the survey question bellow</label>
				            <div class="form-group">
				            	<textarea type="text" class="sign_forms" name="question" placeholder="Enter the question here." required="required" data-error="Please add a qusetion" cols="93" rows="1"></textarea>
				        	</div>
				        	 
				            <div class="form-group">
					            <label>Enter answers to this question </label>
					            <div class="form-group1">
						            <textarea type="text" class="sign_form" name="answer1" placeholder="Option 1" rows="1" required="required" data-error="Please add a option"></textarea>
						            <input type="number" class="score" name="score1" placeholder="Score"  required="required" data-error="The score is required." /><br><br>
						            <textarea type="text" class="sign_form" name="answer2" placeholder="Option 2" rows="1" required="required" data-error="Please add a qusetion"></textarea>
						            <input type="number" class="score" name="score2" placeholder="Score "  required="required" data-error="The score is required." /><br><br>
						            <textarea type="text" class="sign_form" name="answer3" placeholder="Option 3" rows="1" required="required" data-error="Please add a qusetion"></textarea>
						            <input type="number" class="score" name="score3" placeholder="Score"  required="required" data-error="The score is required." /><br><br>
						            <textarea type="text" class="sign_form" name="answer4" placeholder="Option 4" rows="1" required="required" data-error="Please add a qusetion"></textarea>
						            <input type="number" class="score" name="score4" placeholder="Score " required="required" data-error="Please score this answer"/><br><br>
						           
						        </div>
						        <label>Suggest an advice or tip for this question</label>
						        <textarea type="text" class="sign_form" name="advice" placeholder="Enter advice here." rows="1" required="required" data-error="Please add suggestion"></textarea>
				        	</div>
				            <div class="clearfix"></div>
				            <div class="form-group">
				            	<button type="submit" class="btn btn-success" name="btn-add">
				                	&nbsp;SUBMIT THIS QUESTION
				                </button> <button type="exit" class="btn btn-danger" name="btn-cancel">
				                	&nbsp;CANCEL
				                </button>
				            </div>
		        	</form>
		        </div>
		     
	</div>
	<div class="col-md-6">
    </div>
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