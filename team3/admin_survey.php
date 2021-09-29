<?php

session_start();
	$conn = new PDO("mysql:host=localhost;dbname=under_world", "root", "");
    if (!$conn) {
    	die("Connection failed: " . mysqli_connect_error());
    }

    if(isset($_POST['add']))
    {
      header("Location: questions.php");
    }
    if(!($_SESSION['user_id']==3))
  {
    header("location: index.php");
  }
  if(isset($_POST['add_opt']))
  {
    $scored = $_POST['score6'];
    $questn = $_POST['ques_id'];
    $add_optn = strip_tags($_POST['answer6']);
    $sql17 = "INSERT into table_options (options, question_id, score) values ('$add_optn', '$questn', '$scored')";
    $statement17 = $conn->prepare($sql17);
    $statement17->execute();

  }
    if(isset($_POST['test']))
    {
      header("location: survey.php");  
    }  
?>

<!DOCTYPE html>
<html>  
    <head>  
      <title>The under world</title>  
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <link rel="stylesheet" href="./js/jquery-ui.css">
      <script src="./js/jquery.min.js"></script>
      <link rel="stylesheet" href="./js/bootstrap.min.css">
      <script src="./js/jquery-1.12.4.js"></script>
      <script src="./js/jquery-ui.js"></script>
      
      <style>
      body{
        margin-top: 3%;
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
          position: fixed; right: 5%; margin-right: 2px; top:52px; 
        }
        .score{
          width: 150px;
        }
        .submit_ans{
          margin-left: 80%;
          margin-right: 3%;
        }
      	label{
      		padding-left: 5px;
      	}
        .test{
          border: 1px solid black; position: absolute;right: 6%;background-color: white;
          padding:5px 10px 5px 10px; border-radius: 5px; color: black;
        }
        .dropdown1 {
      margin-left: 95%; margin-right: 1%;
        position: relative;
        display: inline-block;
        color:black;
    }
    .dropdown-content1 {
        display: none;
        position: absolute;
        background-color: #f9f9f9;
        min-width: 100px;
        box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
        padding: 12px 16px;
        z-index: 1;
    }
    .dropdown:hover .dropdown-content {
        display: block;
    }
    .dropdown1 {
      margin-left: 90%; margin-right: 1%;
        position: relative;
        display: inline-block;
        color:black;
    }
    .radios{
      margin-left: 10px;
    }
    .dropdown-content {
        display: none;
        position: absolute;
        background-color: #f9f9f9;
        min-width: 120px;
        box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
        padding: 12px 16px;
        z-index: 1;
    }
    .remove{
      color:red;
    }
    i{
      color:transparent;
    }
    u{
      color: blue;
    }
    .dropdown:hover .dropdown-content {
        display: block;
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
      position: absolute;right: 145px; top:5px;
        border-radius: 100%;
        cursor: pointer;
        transition: 0.3s;
    }
    .Imgs{
      position: absolute; left:0px; top: 1px;max-width: 120px min-height:33px;
    }
#myImg:hover {opacity: 0.7;}
.modal4 {
    display: none; 
    position: fixed;
    z-index: 1;
    padding-top: 50px; 
    left: 0;
    top: 0;
    width: 100%; 
    height: 100%; 
    overflow: auto; 
    background-color: rgb(0,0,0); 
    background-color: rgba(0,0,0,0.9); 
}
.modal-content4 {
    margin: auto;
    display: block;
    width: 80%;
    max-width: 600px;
}
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
.modal-content4, #caption {
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
.navbar{
      height: 30px;
      background-color: white;
      margin-left: 0px;
      margin-right: 0px;
    }
    .admin{
      position: absolute; right: 60px; top:6px;
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
    .drop2{
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
    .user{
      color: orange;
    }
    .manage{
      color: black;
      min-width: 150px;
      text-align: center;
      margin-right: 10px;
      padding: 6px;  /*
      position: absolute; left:15%;*/
    }
    .closes{
      
      position: absolute;
      top: 17px;
      text-align: center;
      width: 25px;
      height:25px;
      right: 395px;z-index: 1;
      color: red;
      font-size: 40px;
      font-weight: bold;
      transition: 0.6s;
    }
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
.closes:hover,
.closes:focus {
    color: black;
    text-decoration: none;
    cursor: pointer;
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
    .modal-content2 {
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
      	<div class="my_panel">
          <form action="" method="post" class="this_form">
            <button class="btn btn-info" type="submit" name="add">+ New question</button>
          </form>
       		<?php
       		$result = "SELECT * FROM questions limit 10";
			$statement2 = $conn->prepare($result);
 			$statement2->execute();
 			$rows = $statement2->fetchAll(); 
 			?>
      <form action="" method="post">
        <ol start="1"><hr><?php
     			foreach($rows as $row)
    			{
    		  	$que_id = $row['question_id'];?>
            <div class="dropdown dropdown1">
              <p>more</p>
              <div class="dropdown-content dropdown-content1">
                <a href="delete.php?delete=<?php echo $que_id ;?>">Delete</a><br>
                <a href="edit.php?id=<?php echo $que_id ;?>">Edit question</a><br>
                <a href="add.php?id=<?php echo $que_id ;?>">Add option</a>
              </div>
            </div>
            <li class="questions"><b><?php echo $row['question'];?></b></li>
            <u>Action </u> <i>---</i>|<u> Score</u> | <u>options</u><br>
            <?php
    		  	$result1 = "SELECT * FROM table_options WHERE question_id='$que_id'";
    				$statement1 = $conn->prepare($result1);
    	 			$statement1->execute();
    	 			$rows1 = $statement1->fetchAll();
            $resulti = "SELECT * FROM advices WHERE question_id='$que_id' limit 1";
            $statementi = $conn->prepare($resulti);
            $statementi->execute();
            $rowsi = $statementi->fetchAll();
    	 			foreach($rows1 as $row1)
    				{
              $opt_id = $row1['option_id'];
              echo "<a href='remove.php?id=".$opt_id."' class='remove'>Remove</a>"."<i>--</i>".$row1['score']."<i>-------</i>";?>
    					<input class="radios" type="radio"  name="rad_<?php echo $que_id;?>" value="<?php echo $row1['score']; ?>"/><label><?php echo " ".$row1['options'];?></label><br><?php
    				  	$option_id = $row1['option_id'];
    				  	
    				}?><button data-toggle="modal" class="btn btn-success" data-target="#add_option_<?php echo $que_id;?>"> + Add option</button>
            <div id="add_option_<?php echo $que_id;?>" class="modal" role="dialog">
              <span class="closes" onclick="document.getElementById('add_option_<?php echo $que_id;?>').style.display='none'">&times;</span>
              <div class="modal-dialog">
                <div class="modal-content ">
                  <div class="modal-header"><center><h4>Add option for this question</h4></center>
                  </div>
                  <div class="modal-body myModals">
                    <form method="post" action="">
                      <textarea type="text" class="form-group sign_form" name="answer6" placeholder="Add option" rows="1" cols="70" required="required" data-error="Please add a qusetion"></textarea><br>
                      <input type="number" class="form-control score" name="score6" placeholder="Score " required="required" data-error="The score is required." />
                      <input max="<?php echo $que_id;?>" min="<?php echo $que_id;?>" type="number" class="form-control score" name="ques_id" value="<?php echo $que_id;?>"/><br>
                      <button name="add_opt" class="btn btn-primary" type="submit">Add</button>
                    </form>
                  </div>
                </div>
              </div>
            </div><br>
            <?php
            foreach($rowsi as $rowss)
            {
              echo "<b>Advice</b> = ".$rowss['advice'];
            }
            ?>
            <hr><?php
    			}
    			?>
    		</ol>
        <a href="survey.php" class="test">Test survey</a>
        <br><br><br>
      </form>
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
  <script type="text/javascript" src="./js/bootstrap.min.js"></script>
	</body>
</html>
 




