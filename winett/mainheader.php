<style type="text/css">
	#myImg {
    border-radius: 100%; cursor: pointer; transition: 0.3s;
}
#myImg:hover {opacity: 0.7;}
/* The Modal (background) */
.modal {
    display: none; position: fixed; z-index: 1; /*Sit on top */padding-top: 50px;
    left: 0;  top: 0; width: 100%; height: 100%; overflow: auto; /* Enable scroll if needed */
    background-color: rgb(0,0,0); background-color: rgba(0,0,0,0.9); /* Black w/ opacity */
}
/* Modal Content (Image) */
.modal-content {
    margin: auto; display: block; width: 80%; max-width: 600px;
}
/* Caption of Modal Image (Image Text) - Same Width as the Image */
#caption {
    margin: auto; display: block; width: 80%; max-width: 700px; 
    text-align: center; color: #ccc; padding: 10px 0; height: 150px;
}
/* Add Animation - Zoom in the Modal */
.modal-content, #caption {
    -webkit-animation-name: zoom;
    -webkit-animation-duration: 0.10s;
    animation-name: zoom;
    animation-duration: 0.10s;
}
.myTogle{}
@-webkit-keyframes zoom {
    from {-webkit-transform:scale(0)}
    to {-webkit-transform:scale(1)}
}

@keyframes zoom {
    from {transform:scale(0)}
    to {transform:scale(1)}
}
.closed {
	background-color: red; position: absolute; top: 40px;
    text-align: center; width: 50px; height:50px; right: 40px; color: white;
    font-size: 40px; font-weight: bold; transition: 0.6s;
}
.closed:hover,
.closed:focus {
	background: white; color: red; text-decoration: none; cursor: pointer;
}

/* 100% Image Width on Smaller Screens */
@media only screen and (max-width: 700px){
    .modal-content {
        width: 100%;
    }
}
</style>
<div class="navb">
	<nav class="navbar  navbar-fixed-top">
		<div class="col-md-12">
				<div class="dropdown" style="position: absolute;right: 5%; top: 10px; ">
				    <span id="menu1" data-toggle="dropdown" style="background-color: #25383c; color: white;"><i class="fa fa-navicon" style="font-size: 22px"></i></span>
				    <ul class="dropdown-menu" role="menu" aria-labelledby="menu1">
				      	<li role="presentation">
				      		<a role="menuitem" href="logout.php">Logout</a>
				      	</li>
				    </ul>
				</div>
					
				<b class="userdetails"> 
					 
					 <img id="myImg" src="./upload/<?php echo $userRow['user_id']?>.jpg" alt="<?php echo $userRow['user_firstname']." ".$userRow['user_lastname'];?>">
					<!-- The Modal -->
					<div id="myModal" class="modal">

					  	<!-- The Close Button -->
					  	<span class="closed" onclick="document.getElementById('myModal').style.display='none'">&times;</span>

					  	<!-- Modal Content (The Image) -->
					  	<img class="modal-content" id="img01">

					  	<!-- Modal Caption (Image Text) -->
					  	<div id="caption"></div>
					</div>
					<!--a href="profile.php"><p5 class="user_name"><b><?php/* echo $userRow['user_firstname']." ".$userRow['user_lastname']; */?></b></p5></a-->
				</b>
				<!--i class="glyphicon  glyphicon-bell" style="color:white;"></i--><input class="searche" type="text" id="search" placeholder="Search Winett" />
		</div>      		
    </nav>
</div>
<div class="mainPanel">
   <!--------------------------------------------------------------------------------------------->
	<?php
	function notifications($connect){
		$logged_in_user=$_SESSION['user_session'];
		$query = "SELECT * FROM notifications WHERE to_user_id = '".$logged_in_user."' AND status = '1'";
		$statement = $connect->prepare($query);
		$statement->execute();
		$count = $statement->rowCount();
		$output = 'Alert';
		if($count > 0)
		{
		  	$output = 'Alert<small><span class="label label-success" style="border-radius:100%; color:orange; background-color:transparent; border: 2px solid orange; padding-top: 3px; padding-bottom: 3px;">'.$count.'</span></small>';
		}
		return $output;
	}
	function counters($connect){
		$logged_in_user=$_SESSION['user_session'];
		$query = "SELECT * FROM chat_message WHERE to_user_id = '".$logged_in_user."' AND status = '1'";
		$statement = $connect->prepare($query);
		$statement->execute();
		$count = $statement->rowCount();
		$output = 'Chat';
		if($count > 0)
		{
		  	$output = 'Chat<small><span class="label label-success" style="border-radius:100%; color:orange; background-color:transparent; border: 2px solid orange;">'.$count.'</span></small>';
		}
		return $output;
	}
	?>  
	<ul class="lists">
	    <a href="Posts.php" class="btnz">Home</a>&nbsp;
	    <a href="messages.php" class="header"><h8 class="btnz"><?php echo counters($connect);?></h8></a>&nbsp;
	    <a href="gallery.php"><h8 class="btnz">Gallery</h8></a>&nbsp;
	    <a href="notifications.php" class="heade_update" ><h8 id="heade_update" class="btnz"><?php echo notifications($connect);?></h8></a>&nbsp;
	</ul>
	<div class="display" id="display"></div>
</div>