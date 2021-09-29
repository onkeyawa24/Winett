<?php

session_start();
include_once('users.php');
  include_once('conn.php');
	$conn = new PDO("mysql:host=localhost;dbname=under_world", "root", "");
    if (!$conn) {
    	die("Connection failed: " . mysqli_connect_error());
    }
    if(isset($_SESSION['user_id'])){
      $id=$_SESSION['user_session'];
      $sql = "SELECT * FROM users WHERE user_id='$id'";
      $stmt = $conn->prepare($sql);
      $stmt->execute();
      $row=$stmt->fetch(PDO::FETCH_ASSOC);
    }
    if(isset($_POST['cancel']))
    {
      header("Location: index.php");
    }
    if(isset($_POST['login']))
  {
    header("location: login.php");
  }
  if(isset($_POST['logout']))
  {
    header("location: logout.php");
  }
    if(isset($_POST['submit']))
    {
      $score = 0;

      $resuls = "SELECT * FROM questions";
      $state3 = $conn->prepare($resuls);
      $state3->execute();
      $rows33 = $state3->fetchAll();
 
      foreach($rows33 as $rows44)
      {
        $id = $rows44['question_id'];

        if(isset($_POST['rad_'.$id]))
        { 
          $result3 = "SELECT * FROM advices WHERE question_id= '$id' limit 1";
          $statement3 = $conn->prepare($result3);
          $statement3->execute();
          $rows3 = $statement3->fetchAll();
        
          foreach($rows3 as $rows4)
          {
             if($_POST['rad_'.$id]>1)
            {
              $score = $score + $_POST['rad_'.$id];
              $advice[] = $rows4['advice'];
            } 
          }
        }
      }
      /*Testing to see if results appear. */
      echo "<div style='margin:4% 20% 0% 20%;border:3px dashed red;padding:20px;' ><center><h2><u>RESULTS</u></h2></center><p style='color:red;font-size:130%;'>Oops! This does not look good, you are at risk !</p><b>You have scored: <b style='font-size:180%;'>".$score."</b> points!!</b><br><br><b> Please note the following advices from our experts:</b><br><br>";  
      for($a = 0; $a < count($advice);$a++)
      {
          echo "<li>".$advice[$a]."</li>";                    
      } ?></div><hr><?php
    }
    
?>

<!DOCTYPE html>
<html>  
    <head>  
      <title>The under world</title>  
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <link rel="stylesheet" href="./js/jquery-ui.css">
      <link rel="stylesheet" href="./js/bootstrap.min.css">
      <script src="./js/jquery-1.12.4.js"></script>
      <script src="./js/jquery-ui.js"></script>
      
      <style>
      body{
        margin-top: 1%;
        margin-right: 5%;
        margin-left: 5%;
        padding-top: 1%;
        padding-right: 2%;
        border-right: 1px solid grey;
        border-left: 1px solid grey;
        padding-left: 1%;
        background-color: #d1d0ce;
      }
      html{
        background-color: grey;
      }
      	.questions{
      		font-size: 130%;
      		 
      	}
        .this_form{ 
          position: absolute; right: 5%;
        }
        .submit_ans{
          margin-left: 70%;
          margin-right: 5%;
        }
        ol{
          font-family: serif;
        }
      	label{
      		padding-left: 5px;
      	}
    h3{
      font-size: 150%;
      text-align: center;
    }
    .navbar{
      height: 30px;
      background-color: white;
      margin-left: 0px;
      margin-right: 0px;
      color: black;
    }
    .admin{
      position: absolute;right: 5%;
      border:1px solid black; border-radius: 15px;
      width: 100%;
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
      width: 80px;
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
      background-image: url(images.jpg);
      width: 100%;
      height: auto; 
    }
    .mid{
      color: black;
      font-family: impact;
      font-size: 120%;
      padding: 2%;
    }
    small{
      color: green;
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
      </style>
    </head>  

    <body><?php 
      if(!(isset($_SESSION['user_id'])))
      {     ?>
        <nav class="navbar  navbar-fixed-top">
          <div class="dropdown">
            <form method="post">
                <button class="admin" name="login">Login</button>
            </form>
          </div>
          <img src="profile.jpg" alt="PIC" width="30" height="30">
          <a href="index.php" class="admin1">Guest</a>
        </nav><?php 
      } 
      else
        {?>
      <nav class="navbar  navbar-fixed-top">
        <div class="dropdown">
          <form method="post">
              <button class="admin" name="logout">Logout</button>
          </form>
        </div>
        <img src="profile.jpg" alt="PIC" width="30" height="30">
        <a href="home.php" class="admin1"><?php echo $row['display_name'];?></a>
      </nav><?php 
      }?>
      	<div class="my_panel">
       		<?php
       		$result = "SELECT * FROM questions limit 10";
			$statement2 = $conn->prepare($result);
 			$statement2->execute();
 			$rows = $statement2->fetchAll(); 
 			?>
      <form action="" method="post">
        <h3>Please take the survey and click "Submit" at the bottom</h3>
        <ol start="1"><hr><?php
     			foreach($rows as $row)
    			{
    		  	$que_id = $row['question_id'];?>
             
            <li class="questions"><b><?php echo $row['question'];?></b></li>
            <?php
    		  	$result1 = "SELECT * FROM table_options WHERE question_id='$que_id'";
    				$statement1 = $conn->prepare($result1);
    	 			$statement1->execute();
    	 			$rows1 = $statement1->fetchAll();
    	 			foreach($rows1 as $row1)
    				{
              /*echo $row1['score'];*/?>
    					<input type="radio"  name="rad_<?php echo $que_id;?>" value="<?php echo $row1['score']; ?>" required="required" /><label><?php echo " ".$row1['options'];?></label><br><?php
    				  	$option_id = $row1['option_id'];
    				  	
    				}?><hr><?php
    			}
    			?>
    		</ol>
        <div class="submit_ans">
          <button type="submit" class="btn btn-primary" name="submit">
            &nbsp;Submit your answers
          </button>
          <button type="submit" class="btn btn-danger" name="cancel">
            &nbsp;CANCEL
          </button>
        </div>
        <br><br><br>
      </form>
	</div>
	</body>
</html>
 




