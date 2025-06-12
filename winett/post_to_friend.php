<?php

	require_once("session.php");
	require_once('class.post.php');
	require_once("class.user.php");
	$auth_user = new USER();
	
	
	$user_id = $_SESSION['user_session'];
	
	$stmt = $auth_user->runQuery("SELECT * FROM users WHERE user_id=:user_id");
	$stmt->execute(array(":user_id"=>$user_id));
	
	$userRow=$stmt->fetch(PDO::FETCH_ASSOC);

  if(isset($_POST['submit_post']))
  {
      $postObj = new POST();
      $poster_id = $user_id;
      
      $post_content = $_POST['editer'];
      
      if($postObj->store($poster_id, $post_content))
      {
        header("Location: Posts.php");
      }
      else
      {
        echo "<div class='alert alert-danger'>Error! Could not post, try again.</div>";
      }
  }

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
<link href="bootstrap/css/bootstrap-theme.min.css" rel="stylesheet" media="screen">
<script type="text/javascript" src="jquery-1.11.3-jquery.min.js"></script>
<link rel="stylesheet" href="style.css" type="text/css"  />
<title>Post</title>
</head>
<style type="text/css">
  .container2{
    height: 50px;
  }
  textarea{
    background-color: white;
    border-radius: 10px;
    padding-left: 5px;
    padding-right: 5px;
    border:1px solid white; 
  }
   #bun{
    background-color: silver;
    border-radius: 5px;
  }

</style>

<body>

  <div class="container2">
      <form data-parsley-validate method="post" action="writesef.php">   
        <textarea class="ckeditor" name="editer" required placeholder="Write ?." cols="40" rows="2"></textarea><br>
        <input type="submit" name="submit_post" id="bun" value="Share" class=" ">
      </form>
  </div>
 
<script src="bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/jquery.min.js"></script>
  <script type="text/javascript" src="js/bootstrap.min.js"></script>
  <script type="text/javascript" src="js/js/ckeditor_4.9.2_full/ckeditor/ckeditor.js"></script>
  <script type="text/javascript" src="js/parsley.min.js"></script>

</body>
</html>