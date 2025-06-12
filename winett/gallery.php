<?php

include('database_connections.php');

session_start();

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
   
  $stmt1 = $a_user->runQuery("SELECT * FROM preschools WHERE admin_id=:user_id");
  $stmt1->execute(array(":user_id"=>$user_id));
  
  $userRow1=$stmt1->fetch(PDO::FETCH_ASSOC);

  $stmt = $auth_user->runQuery("SELECT * FROM users WHERE user_id=:user_id");
  $stmt->execute(array(":user_id"=>$user_id));
  
  $userRow=$stmt->fetch(PDO::FETCH_ASSOC);

  $stmt3 = $auth_user->runQuery("SELECT * FROM users WHERE user_id!=:user_id");
  $stmt3->execute(array(":user_id"=>$user_id));
  
  $userRow3=$stmt3->fetch(PDO::FETCH_ASSOC);

  if($userRow['user_firstname']=="")
  {
    header("Location: logout.php?logout=true");
  }
?>
<?php

include_once('conn.php');
$thisuser = $_SESSION['user_session'];
$action_by_user;

?>
<!DOCTYPE html>
<html style="background-color: #f4f6f6;">  
<head>  
    <title>Winett | Gallery</title>  
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="bootstrap.min.css">
    <script type="text/javascript" src="jquery.min.js"></script>
    <script type="text/javascript" src="bootstrap.min.js"></script>
    <link rel="icon" sizes="192*192" href="winett.png">
    <script src="jquery.min.js" type="text/javascript"></script>
	<script src="bootstrap.min.js" type="text/javascript"></script>
	<script src=".js/bootstrap.js" type="text/css"></script>
    <link rel="stylesheet" href="jquery-min.css">
    <link rel="stylesheet" href="bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="maincss.css">
    <script type="text/javascript" src="header_update.js"></script>
    <style>
		* {
		    box-sizing: border-box; 
		}
		:root {
		    /* We just need to know these 3 values up front:*/
		    --wrapper: 100vw;
		    --gutter: 5px;
		    --noOfColumns: 4;
		    
		    /* Number of gutters is columns minus 1:*/
		    --noOfGutters: calc(var(--noOfColumns) - 1);
		    
		    /* Aspect ratio goes here, e.g. 16:9:*/
		    --ratioA: 16;
		    --ratioB: 9;
		    /* --ratio: 16/9;*/
		    /*/ Use the aspect ratio to calculate the factor for multiplication:*/
		    --factor: calc(var(--ratioB) / var(--ratioA));
		    
		    /*Calculating the row height:*/
		    --rh: calc(( (var(--wrapper) - (var(--noOfGutters) * var(--gutter))) 
		        / var(--noOfColumns)) * var(--factor));
		}

		.grid {
			background-color: #f4f6f6; padding: 6px; border-radius: 8px;
		    max-width: var(--wrapper);
		    display: grid;
		    grid-template-columns: repeat(var(--noOfColumns), 1fr);
		    grid-auto-flow: dense;
		    grid-auto-rows: minmax(var( --rh), auto); /* If the content is taller then the box will grow to fit. This is only going to work if the column value is 1fr*/
		    grid-gap: var(--gutter);
		    margin: var(--gutter);
		}

		.grid__item {
			border-radius: 8px; margin-bottom: 6px;
		  	height: 100%; position:relative; background-size: cover; margin-right: 2px;
		 	background-position: center; width: 18.9vw; min-height: 45px; margin-left: 2px;
		 	max-height: 300px; min-width: 45px; background-color: black; padding: 0px;
		}

		.grid__item--lg {
		    grid-column: span 2;
		    grid-row: span 2;
		    background-color: coral;
		}

		.grid__item--right {
		    grid-column: 3 / span 2;
		}

		.grid__item--db {
		    grid-column: span 2;
		    background-color: lightblue;
		}
		.each_photo{
		  	max-width: 100%; max-height: 100%; display: block;
		  	margin-left: auto; margin-right: auto; margin-bottom: auto; margin-top: auto;
		}
		 
		div > p:hover{
			background-color: #ecf0f1; font-weight: bold; width: 140px; cursor: pointer; 
		}
		.foruserr{display: none;}
		.foruser{position: fixed;top: 372px; left: 10px; padding: 8px; border: 1px solid grey; border-radius: 8px; width: 200px; height: 200px; background-color: #ecf0f1;}
		/*.mygallery{display: block; position: absolute; top: 2px; right: 2px; z-index: 1; width: 35px; height: 35px; border-radius: 100%; border: 1px solid silver;}*/
		.gallery{display: block; position: absolute; top: 2px; right: 2px; z-index: 1; width: 35px; height: 35px; border-radius: 100%; border: 1px solid silver;}
		.galleryfor{display: block; z-index: 1; width: 100px; height: 100px; border-radius: 100%; border: 1px solid silver;}
		@media only screen and (max-width: 600px) {
			.col-md-2{display: none;}
		  	.grid__item {
			    display: inline-flex; width: 32vw; margin: 2px; position:relative; 
			    background-size: cover; background-position: center; min-height: 130px;
			    max-height:200px; min-width: 45px; background-color: black; padding: 0px;
		  	}
		}
		@media only screen and (max-width: 449px) {
		    .grid__item {
			    display: inline-flex; width: 31vw; margin: 2px; position:relative; 
			    background-size: cover; background-position: center; min-height: 80px;
			    max-height:90px; min-width: 45px; background-color: black; padding: 0px;
		  	}
	    }
    </style>
</head>  
<body style="background-color: #f4f6f6;"> 

    <?php include_once('mainheader.php');?>
    <br>
    <div class="col-md-12 myGrid" id="grid" style=" background-color: #f4f6f6;">
    	<div class="col-md-2" style="">
    		<div class="left-gallery">
    			<div class="" style=" position: fixed; left: 0px; color: #d35400;">
    				<p style="color: #d35400; padding: 8px; "> <i class="glyphicon  glyphicon-user"></i> Profile</p>
    				<p class="mygallery" data-mygallery="<?php echo $thisuser;?>" style="color: #d35400; padding: 8px; "> <i class="glyphicon  glyphicon-picture"></i> My gallery</p>
    				<p style="color: #d35400; padding: 8px; "> <i class="glyphicon  glyphicon-heart"></i> Liked items</p>
    				<p style="color: #d35400; padding: 8px; "><i class="glyphicon  glyphicon-download-alt"></i> Saved items</p>
    				<p style="color: #d35400; padding: 8px; "><i class="glyphicon glyphicon-cog"></i> Settings</p><br>
    			</div>
    			<hr>
    			<div class="foruserr">
    				
    			</div>
    		</div>
    	</div>
    	<div class="col-md-10" style="border-left: 2px solid silver; padding-left: 4px; ">
		    <div class="grid" id="grid">
		        <?php 
		        $sql = mysqli_query($conn,"SELECT * from gallery ORDER BY gallery_id DESC") or die(mysqli_error());    
		        while($row = mysqli_fetch_array($sql))
		        {
		        	$img_id = $row['gallery_id'];
		        	if($row['type'] == 0) //file is image
		        	{
			          	$poster = $row["poster_id"];
			          	$posted_by = '<img class="gallery" src="./upload/'.$poster.'.jpg" alt="Image missing" data-gallery="'.$poster.'">';
			          	$image = $row["gallery_content"];
			          	echo '<center> <div class="grid__item grid__item--sm" id="'.$img_id.'" style="background-image: url(upload/'.$image.');">
			          	    '.$posted_by.' </div> </center>';
			        }
			        else //file is video
			        {
			        	$image = $row["gallery_content"];
			        	echo '<center><a href="upload/'.$image.'"><div class="grid__item grid__item--sm" id="'.$img_id.'" style="">
			        		<video controls loop id="" class="grid__item grid__item--sm" >
							  	<source src="upload/'.$image.'" type="video/mp4">
							</video>
			        	</div></a></center>';
			        }
		        }
				?>
		    </div>
		</div>
	</div>
	<script>
		$(document).on('click', '.mygallery', function(){
		    var mygallery = $(this).data('mygallery');
		    $.ajax({
		      	url:"my_gallery.php",
		     	method:"POST",
		     	data:{ mygallery:mygallery},
		     	success:function(data)
		      	{ 
		        	$('#grid').html(data);
		        }
		    })
		});
		$(document).on('click', '.gallery', function(){
		    var mygallery = $(this).data('gallery');
		    $.ajax({
		      	url:"my_gallery.php",
		     	method:"POST",
		     	data:{ mygallery:mygallery},
		     	success:function(data)
		      	{ 
		        	$('#grid').html(data);
		        }
		    })
		});
		(document).on('focus', '.myGrid', function(){
		    var status = '1';
		    $.ajax({
		      url:"check_online_status.php",
		      method:"POST",
		      data:{status:status},
		      success:function(){}
		    })
		  });
		  $(document).on('focus', '.grid', function(){
		      var status = '1';
		      $.ajax({
		        url:"check_online_status.php",
		        method:"POST",
		        data:{status:status},
		        success:function(){}
		      })
		    });

		   $(document).on('focus', '.foruserr', function(){
		    var status = '1';
		    $.ajax({
		      url:"check_online_status.php",
		      method:"POST",
		      data:{status:status},
		      success:function(){}
		    })
		  });
	</script>
</body>
</html>

