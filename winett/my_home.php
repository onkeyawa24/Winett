<?php
include('database_connection.php');
	require_once("session.php");
	include_once('conn.php');
	require_once("class.user.php");
	$auth_user = new USER();
	$user_id = $_SESSION['user_session'];
	$stmt1 = $auth_user->runQuery("SELECT * FROM users WHERE user_id=:user_id");
	$stmt1->execute(array(":user_id"=>$user_id));
	$userRow1=$stmt1->fetch(PDO::FETCH_ASSOC); 
	/********************************************/	 
	$id=$_GET['my_id'];
	$stmt = $auth_user->runQuery("SELECT * FROM users WHERE user_id=:id");
	$stmt->execute(array(":id"=>$id));
	$userRow=$stmt->fetch(PDO::FETCH_ASSOC);
	$Display_name = $userRow['user_firstname']." ".$userRow['user_lastname'];
	/********************************************/
	$stmt2 = $auth_user->runQuery("SELECT * FROM user_details WHERE user_id=:id");
	$stmt2->execute(array(":id"=>$id));
	$userRow2=$stmt2->fetch(PDO::FETCH_ASSOC); 
?>
 
<!DOCTYPE html5>
<html>
<head>
	<title><?php echo $Display_name;?></title>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="./boot/jquery-ui.css">
        <link rel="stylesheet" href="./boot/bootstrap.min.css">
        <script src="./boot/jquery-1.12.4.js"></script>
        <script src="./boot/jquery-ui.js"></script>
        <script type="text/javascript" src="./boot/jquery.js"></script>
		<script type="text/javascript" src="./boot/jquery.min.js"></script>
		<script type="text/javascript" src="./js/bootstrap.min.js"></script>
		<link rel="stylesheet" type="text/css" href="my_home.css">
		<script type="text/javascript" src="scriptz.js"></script>
    </head>
    <script src=".hi/js/jquery.js" type="text/javascript"></script>
    <script src=".hi/js/bootstrap.js" type="text/javascript"></script>
	<body>
		<nav class="navbar  navbar-fixed-top">
			<a href="Posts.php"><img class="logoImage" src="./images/wilogo.png"></a>	
			<span class="userdetails">	 
			<a href="profile.php"><b class="user_name"><?php echo $userRow1['user_firstname']." ".$userRow1['user_lastname']; ?></b></a>
			</span>
			<i class="glyphicon  glyphicon-bell" style="color:white;"></i><input class="searche" type="text" id="search" placeholder="Search Winett" />	
	    </nav>
	    <br><br><br><div class="display" id="display"></div>
		<!---------------------------------------------------------------> 			
		<div class="sandie"> 
			<img id="image_<?php echo $userRow['user_id']?>" src="./upload/<?php echo $userRow['user_id']?>.jpg" alt="Profile" >
			<a href="profile.php"><p5 class="user_name"><b><?php echo $userRow['user_firstname']." ".$userRow['user_lastname']; ?></b></p5></a><?php
			$query1=mysqli_query($conn,"SELECT * from pinned_user where pinned_id='".$id."' and pinner_id='".$_SESSION['user_session']."'");
            if (mysqli_num_rows($query1)>0)
            {?>
            <button value="<?php echo $id; ?>" class="unpin">UNPIN</button><?php
        	}
            else
            {?>
			<button value="<?php echo $id; ?>" class="pin">PIN</button>
            <?php
        	}
            ?><br>
			<!--p class="bio"> <?php/* echo $userRow2['bio'];*/?></p-->
		</div>
		   <!-------------------------------------------->
		<ul class="w3-navbar lists">
		    <a href="my_home.php?my_id=<?php echo $id;?>"><h8 class="btnz2">Posts</h8></a>&nbsp;
			<a href="#"><h8 class="btnz">About</h8></a>&nbsp;
			<a href="#"><h8 class="btnz">Chats</h8></a>&nbsp;
			<a href="#"><h8 class="btnz">Gallery<br></h8></a>&nbsp;<br>
		</ul>
			<div class="col-md-12">
				<div class="col-md-3"></div>
				<div class="col-md-6"><?php
					include('my_profile.php');
					?>
				</div>
				<div class="col-md-3"></div>
			</div>
		<script src="bootstrap/js/bootstrap.min.js"></script>
		<!--  JAVASCRIPT FOR MODAL POPUP -->
		<script src = "./boot/jquery-1.12.4.js"></script>
		<!--  JAVASCRIPT FOR MODAL POPUP -->
		<script type="text/javascript">
			$(document).ready(function(){
			$(document).on('click', '.pin', function(){
	            var id=$(this).val();
	            var $this = $(this);
	            $this.toggleClass('pin');
	            if($this.hasClass('pin')){
	            } else {
	                $this.text('UNPIN');   
	            }
	            $.ajax({
	                type: "POST",
	                url: "pin.php",
	                data: {
	                    id: id,
	                    pin: 1,
	                },
	                success: function(){
	                    showPin(id);
	                }
	            });
	        });
			$(document).on('click', '.unpin', function(){
	            var id=$(this).val();
	            var $this = $(this);
	            $this.toggleClass('unpin');
	            if($this.hasClass('unpin')){
	            } else {
	                $this.text('PIN');
	            }
	            $.ajax({
	                type: "POST",
	                url: "pin.php",
	                data: {
	                    id: id,
	                    pin: 1,
	                },
	                success: function(){
	                    showPin(id);
	                }
	            });
	        });
		});
			function showPin(id){
	            $.ajax({
	                url: 'showpin.php',
	                type: 'POST',
	                async: false,
	                data:{
	                    id: id,
	                    showpin: 1
	                },
	                success: function(response){
	                    $('#show_pin'+id).html(response);           
	                }
	            });
	        }
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
 