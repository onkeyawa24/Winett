<?php
header("Location: Posts.php");
?>
<?php
/*    include('database_connections.php');
	require_once("session.php");
	
	require_once("class.user.php");
	$auth_user = new USER();
	$a_user = new USER();

	$user_id = $_SESSION['user_session'];
	 
	$stmt1 = $a_user->runQuery("SELECT * FROM preschools WHERE admin_id=:user_id");
	$stmt1->execute(array(":user_id"=>$user_id));
	
	$userRow1=$stmt1->fetch(PDO::FETCH_ASSOC);

	$stmt = $auth_user->runQuery("SELECT * FROM users WHERE user_id=:user_id");
	$stmt->execute(array(":user_id"=>$user_id));
	
	$userRow=$stmt->fetch(PDO::FETCH_ASSOC);

	if($userRow['user_firstname']=="")
	{
		header("Location: logout.php?logout=true");
	}*/
?>
 
<!--DOCTYPE html>
<html>
<head>
	<title>WiNett</title>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		
		<script type="text/javascript" src="./js/jquery.min.js"></script>
		<link rel="stylesheet" type="text/css" href="./css/bootstrap.min.css">
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
    
    border-left:solid; 
    border-right: solid;
    border-width: 1px;
    border-color: white;
    background-color: silver;
    /*background-image: url(./images/background.jpg);*/
  }
  html{
    padding: 10px;
    /*background-color: #2c3539;*/
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
			
		 
		}
		.ikhala{
			 
			color: white;
			font-family: comic;
			font-size: 120%;
			text-align: left;
			padding-left: 2%;
			padding-right: 2%;
			 
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
	.sandie > img{	
		background-color: white;
		padding: 2px;
		border-radius: 100%;
	 	width: 10%; 
	 	margin-left: 1%;
	} 
	 .sandie  {
	 	background-color: transparent;
	 	border-top-left-radius: 25em;
	 	border-bottom-left-radius: 25em;
	 	margin-right: 1%;
	 	height: 100%;
	 }
	 

	.user_name{
		font-size: 75%;
		padding: left;
		border-bottom: solid;
		border-width: 1px;
		border-color: silver;
		padding-left: 1%;
		margin-left: 1%
		margin-right: 12%;
		color: darkgrey;
		border
	}
	.headings3 > h5 {
		text-align: center;
	}
	.headings3  {
	
		position: relative;
		color: white;
		text-align: left;
		 
		padding-bottom: 1%;
		background-color:#25383c;
		background: -moz-linear-gradient(#6c2dc7;#6c2dc7);
	}
	h5{
		color: white;
		text-align: center;
	}
	aside{
		font-size: 80%;
		text-align: right;
		padding-right: 1%;
	}
	p{
		color: white;
	}
	.mains{	
		background-color:#25383c;
		  
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
    border-top: 1px solid white;
    width: 100%;
    background-color: #25383c;
    color: white;
    height: 40px;  
  }
	.searcher{
		padding-left: 1%;
		width: 66%;
		border:solid;
		border-width: 1px;
		border-color: silver;
		border-top-left-radius: 45px;
		border-bottom-left-radius:45px;
		border-top-right-radius: 45px;
		border-bottom-right-radius:45px;
	}
	 
	.close{
		color: white;
	}
	.col-md-6{
		text-align: left;
	}
	.btn1{
	background-color: green;
    color: white;
    padding-right: 3%;
    margin-left: -3%;
    padding-left: 3%;
    height: 40px;
    font-size: 160%;
      }
	 .btnz{
    color: white;
    padding-right: 3%;
    padding-left: 3%;
    height: 36px;
    font-size: 160%;
      }
	.navb{
		background-color: #25383c !important;
	}
	.navbar{
		margin-right: 7%;
	}
</style>
<body>
	
	<div class="navb">
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
	    </nav>
	</div>

	<div class="panel" >		 
				
		<div class="mains">
			<div class="sandie"> 
				<img id="image" src="./upload/<?php/* echo $userRow['user_id']?>.jpg" alt="Profile" data-toggle="modal" data-target="#myImage"> 

				<div class="modal fade" id="myImage" role="dialog" size="">
    				<div class="modal-dialog">				
     					<!-- Modal content-->
	      					<div class="modal-content">
	        					<div class="modal-body">
	          						<button type="button" class="close" data-dismiss="modal">&times;</button>
	          						<img src="./upload/<?php echo $userRow['user_id']?>.jpg" style ="width: 400px; margin: 100px;">
								</div>
							</div>
					</div>
				</div>

				<a href="profile.php"><p5 class="user_name"><b><?php echo $userRow['user_firstname']." ".$userRow['user_lastname']; ?></b></p5></a>
			</div>
			<aside>
				<a href="index.php"><p><i><b>Wirenett</b></i></p></a>
			</aside>	 
		   <!--------------------------------------------------------------------------------------------->
    <?php
//fetch_user.php
function counters($connect){
$query = "
SELECT * FROM users 
WHERE user_id != '
".$_SESSION['user_session']."' 
";
$statement = $connect->prepare($query);
$statement->execute();
$result = $statement->fetchAll();
$count = $statement->rowCount();
 static $kiloe = 0;
 
foreach($result as $row)
{
  $a=$row['user_id'];
  $b=$_SESSION['user_session'];
  $query = "
 SELECT * FROM chat_message 
 WHERE to_user_id = '$b' AND status = '1'";
 $statement = $connect->prepare($query);
 $statement->execute();
 $count = $statement->rowCount();
 $output = '';
 if($count > 0)
 {
  $output = '<b style="color:orange;">Messages</b><small><span class="label label-success" style="border-radius:100%; color:orange; background-color:transparent; border: 1px solid orange;">'.$count.'</span></small>';
 }
 else
 {
  $output = 'Messages';
 }
}
return $output;
}
?>  
		 <?php $name = $userRow1['name']; ?>
			<ul class="w3-navbar lists">
			<a href="index.php"><h8 class="btn1">Home</h8></a>&nbsp
          <a href="Posts.php"><h8 class="btnz">World</h8></a>&nbsp
          <a href="messages.php"><h8 class="btnz">Chats</h8></a>&nbsp
          <a href="#"><h8 class="btnz">Notifications</h8></a>&nbsp
			</ul>
		 </div>
		<div class="paragraphs">
			<h5 class="headin"><center></center></h5>
		</div>
		<textarea class="searcher" type="text" id="search" placeholder="Search preschool here"></textarea>
		<div class="display" id="display"></div>

		<div class="banners">
			<button class="headings" id="views"><h4 class="ikhala">View the Pre-Schools</h4></a></button>
			<button class="headings"><div class="myPanes"><p class="ikhala">Your favourites</p></div></button>	
			<button class="headings"> <div class="myPanes"><p class="ikhala">See friend's sugestions</p></div></button>	 
			<button class="headings" id="schools">
				<div class="myPanes" >
					<p class="ikhala">Add your own here</p>
				</div>
			</button>
 			<!-- Modal -->
 				<div class="modal fade" id="myModal" role="dialog" size="">
    				<div class="modal-dialog">				
     					<!-- Modal content-->
	      					<div class="modal-content">
	        					<div class="modal-header">
	          						<button type="button" class="close" data-dismiss="modal">&times;</button>
	          						<h4 class="modal-title"><center><strong>Choose province</strong></center></h4>
	        					</div>
	        					<div class="modal-body">
	          						<div class="row">
									</div>
									<button class="headings" name="western_cape"> 
										<p>Western Cape </p>
									</button>	
									<button class="headings" name="eastern_cape"> 															 
										<p>Eastern Cape</p>
									</button>	 
									<button class="headings" name="gauteng"> 											 
										<p>Gauteng</p>	
									</button>
									<button class="headings" name=" mpumalanga"> 															 
										<p>Mpumalanga</p>
									</button>	
									<button class="headings" name="north_west"> 				 
										<p>North West</p>
									</button>	 
									<button class="headings" name="kwazulu_natal"> 
																
										<p>KwaZulu Natal</p>	
									</button>
									<button class="headings" name="limpopo"> 
																 
										<p>Limpopo</p>
									</button>	
									<button class="headings" name="northern_cape"> 
															
										<p>Northern Cape</p>
									</button>	 
									<button class="headings" name="free_state"> 
																
										<p>Free State</p>
									</button>
								</div>
							</div>
						<!--***Modal content***-->
					</div> 
				</div>
			<!--End  Modal-->
			</div>			
		<div class="headings3"> 
			<h5 class="ikhala"><b>About Wirenett</b></h5>
				<p style="margin-left: 2%;">Wirenett is a software that helps members of the society to find the pre schools of their favourites. This application is available at play store and at app stores.</p>	 
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
					$(document).ready(function()
					{
						
						$(document).on('click', '#views', function(e)
						{
							 $('html').load('schools.php');
						});
					});
				</script>
				<script src="bootstrap/js/bootstrap.min.js"></script>


</body>
</html>
 