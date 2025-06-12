  
  <!--------------------------------------------------------------------->
  <?php

	require_once("session.php");
	require_once("conn.php");
	require_once("class.user.php");
	$auth_user = new USER();
	$a_user = new USER();

	$user_id = $_SESSION['user_session'];
	  

	$stmt = $auth_user->runQuery("SELECT * FROM users WHERE user_id=:user_id");
	$stmt->execute(array(":user_id"=>$user_id));	
	$userRow=$stmt->fetch(PDO::FETCH_ASSOC);

	$stmt2 = $auth_user->runQuery("SELECT user_id, bio, date_modified FROM user_details WHERE user_id=:user_id");
	$stmt2->execute(array(":user_id"=>$user_id));	
	$userRow2=$stmt2->fetch(PDO::FETCH_ASSOC);
	$wrong="";
	if(isset($_POST['confirm'])){
		$pass = strip_tags($_POST['txt_pass']);
		$stmte = $auth_user->runQuery("SELECT * FROM users WHERE user_id=:user_id");
		$stmte->execute(array(":user_id"=>$user_id));	
		$userRowe=$stmte->fetch(PDO::FETCH_ASSOC);
		$count = $stmte->rowCount();
		if($count > 0)
		{
		    
	      	if(password_verify($_POST["txt_pass"], $userRowe['password']))
	        {
	        	$auth_user->redirect('edit.php');
	      	}
	      	else
	      	{	
	      		$wrong = "Sorry wrong password, you need to confirm this password to proceed.";
	      	}
	  	
		}
		else
		{
			echo "Your session has expired please login again.";
		}
	}
?>
 
<!DOCTYPE html>
<html>
<head>
	<title>WiNett</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="./css/bootstrap.min.css">
	<script type="text/javascript" src="./js/jquery.min.js"></script>
	<script type="text/javascript" src="./js/bootstrap.min.js"></script>
	<link rel="stylesheet" type="text/css" href="./css/w3.css">
	<link rel="stylesheet" type="text/css" href="./css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="./css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="./css/style.css">
	<script type="text/javascript" src="scriptz.js"></script>
	<script>
</script>
</head>
<style type="text/css">
	body{
		margin: 7%;	 
		background-color: #25383c;
	}
	html{
		background-image: url(./images/background.jpg);
		
	}
	   	  
	.banners{
		margin-top: 3%;
	}
	.headin{
		color: white;
	}
	.olumns{
		 background-color:#25383c;
	}
	 	 
	.headings3{
			background-color: #e5e4e2;	 
			text-align: center;
			transition: visibility 0s linear 0s, opacity 0.25s, transform 0.25s;
			
			margin-left: 1%;
			margin-right: 1%;
		}
		.ikhala{
			color: white;
			font-family: comic;
			font-size: 120%;
			text-align: left;
			padding-left: 10%;
			padding-right: 10%;
			padding-bottom: 1%;
			border-radius: 20px;
		}
	 	.headings{

		width: 100%;
		opacity: 1;
		pointer-events: auto;
		position: relative; 
		background-color:#25383c;
		background: -moz-linear-gradient(#6c2dc7;#6c2dc7);
		padding: center;
		padding-bottom: 1%;
		border-radius: 20px;

	}
	.headings > p {
		color: white;
	}
	.panel{
		background-color: transparent;
		/*background-color: #d1d0ce;*/
		padding-left: 3%;
		padding-top: 1%;
		padding-bottom: 1%;
		padding-right: 3%;
	}
	.headings2{
		
		width: 100%;
		opacity: 1;
		pointer-events: auto;
		position: relative;
		border-radius: 20px;
		background-color:#25383c;
		background: -moz-linear-gradient(#6c2dc7;#6c2dc7);
	}
	img{	
		border-radius: 100%;
		border-top-left-radius: 100%;
	 	border-bottom-left-radius: 100%;
	 	width: 10em; 
	 	margin-left: 1%;
	} 
	 .sandie  {
	 	background-color: transparent;
	 	border-top-left-radius: 25em;
	 	border-bottom-left-radius: 25em;
	 	margin-right: 1%;
	 	height: 10em;
	 }
	  
	.para{
		padding: left;
		border-bottom: solid;
		border-width: 1px;
		border-color: silver;
		padding-left: 1%;
		margin-left: 1%
		margin-right: 12%;
		color: black;
	}
	.headings3 > h5 {
		text-align: center;
	}
	.headings3  {
	
		position: relative;
		color: white;
		text-align: left;
		padding-left: 10%;
		padding-right: 10%;
		padding-bottom: 1%;
		background-color:#25383c;
		background: -moz-linear-gradient(#6c2dc7;#6c2dc7);
	}
	h4{
		padding-bottom: 1%;
		color: white;
		border-bottom: solid;
		border-width: 1px;
		border-color: white;
	}
	h5{
		color: white;
		text-align: center;
	}
	aside{
		text-align: right;
		padding-right: 1%;
	}
	p{
		color: white;
	}
	.mains{	
		background-color:#25383c;
		  
	}
	.te{
		background-color: white;
		padding: 2px;
		rotate:left;
	}
	li.a{
		list-style-type: circle;
		list-style: none;
	}
	a{
		color: white;
	}
	.display{
		color: white;
	}
	.lists{
		background-color: #25383c;
		color: white;
		margin-top: -2%;	
	}
	.searcher{
		width: 30%;
		border:solid;
		border-width: 1px;
		border-color: silver;
		border-top-left-radius: 45px;
		border-bottom-left-radius:45px;
		border-top-right-radius: 45px;
		border-bottom-right-radius:45px;
	}
	.col-md-6{
		text-align: left;
	}
	.btnz{
		color: lightgrey;
		margin-left: 1%;	}
	.navb{
		background-color: #25383c !important;
	}
	.navbar{
		margin-right: 7%;
	}
</style>
<body>
	
	 <!--div class="navb">
	<nav class="navbar  navbar-fixed-top">
      
          <ul class="nav navbar-nav navbar-right">
    
            <li class="dropdown">
              	<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
        		<span class="glyphicon glyphicon-user"></span>&nbsp;<span class="caret"></span></a>
              	<ul class="dropdown-menu">
                	<li><a href="logout.php?logout=true"><span class="glyphicon glyphicon-log-out"></span>&nbsp;Sign Out</a></li>
              	</ul>
            </li>
          </ul>
         
    </nav-->
</div>

	<div class="panel" >		 
				
		<div class="mains">
			<div class="sandie"> 
				<img id="image" class="te" src="./upload/<?php echo $userRow['user_id']?>.jpg" alt="Profile" data-toggle="modal" data-target="#myImage"> 
				<div class="modal fade" id="myImage" role="dialog" size="">
    				<div class="modal-dialog">				
     					<!-- Modal content-->
	      					<div class="modal-content">
	        					<div class="modal-body">
	          						<button type="button" class="close" data-dismiss="modal">&times;</button>
	          						<li><a href="">View photo</a></a></li>
	          						 <li><a href="profilepic.php" style="color: white;">Add new photo</a></li>
	          						 <li><a href="profiles.php">Remove photo </a></li>
								</div>
							</div>
					</div>
				</div>
				<a href="profile.php"><p5 class="para" style="color: white;"><b><?php echo $userRow['user_firstname']." ".$userRow['user_lastname']; ?></b></p5></a>
			</div>
			<aside>
				<p><i><b>Wirenett</b></i></p>
			</aside>	 
		</div> 
		 
			<ul class="w3-navbar lists">
			    <a href="index.php"><h8 class="btnz"> Home</h8></a>&nbsp
			     <h8 class="btnz" ><?php if ($userRow1['name'] != ""){echo "<a href='preschools.php'>".$userRow1['name']."</a>";}else echo "<a href='addPreschool.php'>"."Add School"."</a>"; ?></h8 class="name">&nbsp
			    <a href="messages.php"><h8 class="btnz">Messages</h8></a>&nbsp
			    <a href="schools.php"><h8 class="btnz">Schools</h8></a>&nbsp
			    <a href="capetown.html"><h8 class="btnz">Notifications</h8></a>&nbsp
			</ul>
  <!--------------------------------------------------------------------->
	
	    <div class="profiles">  

	    	<hr><h4>User details</h4>
	    	<p><?php echo "First name : ".$userRow['user_firstname']; ?></p>
	    	<p><?php echo "Last name : ".$userRow['user_lastname']; ?></p>
	        <p>Email : <?php echo $userRow['username']; ?></p>
	        <p>Gender : <?php echo $userRow['gender']; ?></p>
	        <p>Country : <?php echo $userRow['country']; ?></p>
	        <p style="border-top: 1px solid">Bio :<br><small><i> <?php echo $userRow2['bio']; ?></i></small></p>
	        <p style="border-top: 1px solid">Joined on : <?php $date_created = strtotime($userRow['date_created']); echo date("d-M-Y", $date_created); ?></p>
	        <p>Last modified : <?php $date_modified = strtotime($userRow['date_modified']); echo date("d-M-Y", $date_modified); ?></p><br>
	        <p class="text-danger"><?php echo $wrong; ?></p>
	        <button data-toggle="modal" data-target="#insert_photo">Update profile</button><br>
		        <div id="insert_photo" class="modal" role="dialog">
		          <div class="modal-dialog">
		            <div class="modal-content ">
		              <div class="modal-body myModals">
		                <form action="" method="post">
		                	<p class="text-danger"><?php echo $wrong; ?></p>
		                  	<p style="font-size: 130%; color: black;">Please confirm if this is you by entering your current password bellow.</p><hr>
		                  	<input type="password" name="txt_pass" placeholder="Enter your password">
		                  	<button type="submit" class="btn btn-primary" name="confirm">Confirm</button>
		                </form>     
		              </div>
		            </div>
		          </div>
		        </div> 
			    </div>

					<script type="text/javascript">

					$(document).ready(function()
					{
						
						$(document).on('click', '#image', function(e)
						{
							 $('html').load('localhost/www.wirenett.co.za/images/profile3.jpg');
						});
					});
	</script>
</body>
</html>