<?php

require('database_connections.php'); require('session.php'); require('conn.php');
if(!isset($_SESSION['user_id']))
{
    header("location:logins.php");
}
?>
<?php
    require_once("class.user.php");
    $auth_user = new USER();
  	$a_user = new USER();

  	$user_id = $_SESSION['user_session'];
   
  	$stmt = $auth_user->runQuery("SELECT * FROM users WHERE user_id=:user_id");
  	$stmt->execute(array(":user_id"=>$user_id));
  
 	$userRow=$stmt->fetch(PDO::FETCH_ASSOC);

  	$stmt3 = $auth_user->runQuery("SELECT * FROM users WHERE user_id!=:user_id");
  	$stmt3->execute(array(":user_id"=>$user_id));
  
  	$userRow3=$stmt3->fetch(PDO::FETCH_ASSOC);

    $thisuser = $_SESSION['user_session'];
    $action_by_user;
?>
<!DOCTYPE html>
<html>  
    <head>  
      	<title>Winett | Notifications</title>  
      	<meta name="viewport" content="width=device-width, initial-scale=1">
      	<link rel="icon" sizes="192*192" href="winett.png">
      	<link rel="stylesheet" href="./boot/jquery-ui.css">
	  	<link rel="stylesheet" href="./boot/bootstrap.min.css">
	  	<link rel="stylesheet" href="./boot/emojionearea.min.css">
	  	<script src="./boot/jquery-1.12.4.js"></script>
	  	<script src="./boot/jquery-ui.js"></script>
	  	<script src="./boot/emojionearea.min.js"></script>
	  	<link rel="stylesheet" type="text/css" href="maincss.css">
	  	<script type="text/javascript" src="scriptz.js"></script>
	  	<script type="text/javascript" src="header_update.js"></script>
    </head>  
    <body> 
      	<div class="my_panel on_focus_notifications">
	      	<div class="">
	        <?php include_once('mainheader.php'); 
	        
	            $sql = mysqli_query($conn,"SELECT * from notifications where to_user_id='$thisuser' ORDER BY date_notified DESC") or die(mysqli_error());
		 		while($row = mysqli_fetch_array($sql))
		 		{
		 			if($row['action'] == 'pin')
					{
						$action_by_user=' have pinned you, now he can see all of your posts.';
					}
					elseif($row['action'] == 'like')
					{
						$action_by_user=' have liked your post.';
					}
					elseif($row['action'] == 'comment')
					{
						$action_by_user=' have liked your post.';
					}
					elseif($row['action'] == 'share')
					{
						$action_by_user=' have shared your post.';
					}
					elseif($row['action'] == 'report')
					{
						$action_by_user=' have reported your post, please review this post or consider removing it.';
					}
					elseif($row['action'] == 'seen')
					{
						$action_by_user=' have seen this post before.';
					}
					else{
						$action_by_user=" did nothing.";
					}
					$from_user=$row['from_user_id'];
					$sql1 = mysqli_query($conn,"SELECT * from users where user_id='$from_user'") or die(mysqli_error());
					$row1 = mysqli_fetch_array($sql1);
					$from_username= $row1['user_firstname']." ".$row1['user_lastname'];?>
					<li><a href="Posts.php#<?php echo $row['post_id'];?>" style="color: blue;"> <?php echo $from_username." ".$action_by_user; ?></a>
					</li>
				    <?php
				}
			?>
			</div>
		</div>
	</body>
</html>
<script>
	$(document).ready(function(){
		fetch_note();
        setInterval(function()
        { 
            fetch_note();
        }, 2000);
		$(document).on('focus', '.on_focus_notifications', function(){
		  	var status = '0';
		  	$.ajax({
		   	    url:"update_onfucus_notifications.php",
		   	    method:"POST",
		   	    data:{status:status},
		   	    success:function(){}
		  	})
	 	});
	 	function fetch_note()
		{
		    $.ajax({
		        url:"header_update.php",
		        method:"POST",
		        success:function(data){
		            $('#heade_update').html(data);
		        }
		    })
		}			  
    });
</script>
<?php
	/*
	if(isset($_GET['notif_me']))
	{
	 	if($_GET['notif_me'] == $_SESSION['user_session']){
		 	$notif_id = $_SESSION['user_session']; $notif_status = 1; $zero =0;
			$sql14 = mysqli_query($conn,"SELECT * from notifications WHERE to_user_id = '$notif_id' and status = '$notif_status' ") or die(mysqli_error());
			while($row14 = mysqli_fetch_array($sql14)){
				$query14 = "
				UPDATE notifications 
				SET status = '".$zero."' WHERE notification_id = '".$row14['notification_id']."'";
				$statement14 = $connect->prepare($query14);
				$statement14->execute();
			}
		}
		else
		{
			echo "Oops! you might be trying to hack this user or something. If not, try again later.";
			header("location: Posts.php");
		}
	}
	*/
?>

