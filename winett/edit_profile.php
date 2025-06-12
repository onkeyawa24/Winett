<?php

	require_once("session.php");
	
	require_once("class.user.php");
	$auth_user = new USER();
	
	$user_id = $_SESSION['user_session'];
	
	$stmt = $auth_user->runQuery("SELECT * FROM users WHERE user_id=:user_id");
	$stmt->execute(array(":user_id"=>$user_id));
	
	$usersRow=$stmt->fetch(PDO::FETCH_ASSOC);

   

  if(isset($_POST['btn-signup']))
{
  $username = strip_tags($_POST['txt_username']);
  $user_firstname = strip_tags($_POST['txt_firstname']);
  $user_lastname = strip_tags($_POST['txt_lastname']);
  $bio = strip_tags($_POST['bio']);
  $gender = $_POST['gender'];
   
  $upass = strip_tags($_POST['txt_upass']);



  if($user_lastname=="")  {
    $error[] = "Provide lastname !";  
  }
  else if($user_firstname == "")
  {
    $error[] = "Provide firstname !";
  }
  else if($username=="") {
    $error[] = "provide email id !";  
  }
  else if(!filter_var($username, FILTER_VALIDATE_EMAIL)) {
      $error[] = 'Please enter a valid email address !';
  }
  else if($upass=="") {
    $error[] = "provide password !";
  }
  else if(strlen($upass) < 6){
    $error[] = "Password must be atleast 6 characters"; 
  }
  else
  {
    try
    {
      $stmt = $auth_user->runQuery("SELECT * FROM users WHERE username='$username'");
      $stmt->execute();
      $row=$stmt->fetch(PDO::FETCH_ASSOC);
      echo "<br>";  
      if($auth_user->update($user_id, $username, $user_firstname, $user_lastname, $gender,$upass, $bio))
      { 
          $auth_user->redirect('profile.php');
      } 
    }
    catch(PDOException $e)
    {
      echo $e->getMessage();
    }
  } 
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="./bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
<link href="./bootstrap/css/bootstrap-theme.min.css" rel="stylesheet" media="screen">
<script type="./js/javascript" src="jquery-1.11.3-jquery.min.js"></script>
<link rel="stylesheet" href="style.css" type="text/css"  />

<title>Edit Profile - <?php echo ($usersRow['user_firstname']); ?></title>

<style type="text/css">
  .edit_profile{
    background-color: #2c3539;
    color: grey;
  }
</style>
</head>

<body>

  
    <div class="clearfix">
      <div class="edit_profile">
    <h1 class="text-center"><i class="glyphicon glyphicon-user"></i>Edit Profile</h1>
    	<div class="container">
      
        <form method="post" class="">
          
              <?php
        if(isset($error))
        {
          foreach($error as $error)
          {
             ?>
                       <div class="alert alert-danger">
                          <i class="glyphicon glyphicon-warning-sign"></i> &nbsp; <?php echo $error; ?>
                       </div>
                       <?php
          }
        }
        else if(isset($_GET['joined']))
        {
           ?>
                   <div class="alert alert-info">
                        <i class="glyphicon glyphicon-log-in"></i> &nbsp; Successfully registered <a href='login.php'>login</a> here
                   </div>
                   <?php
        }
        ?>
              <div class="form-group">
              <input type="text" class="form-control" name="txt_firstname" placeholder="Enter firstname" value="<?php echo $usersRow['user_firstname'];?>" />
              </div>
              <div class="form-group">
              <input type="text" class="form-control" name="txt_lastname" placeholder="Enter lastname" value="<?php echo $usersRow['user_lastname'];?>" />
              </div>
              <div class="form-group">
              <input type="text" class="form-control" name="txt_username" placeholder="Enter E-Mail ID" value="<?php echo $usersRow['username'];?>" />
              </div>
              <div class="form-group">
                Male <input type="radio" name="gender" value="m" checked/>
                Female <input type="radio"  name="gender"value="f"/>
              </div>
                 
              <div class="form-group">
                <input type="password" class="form-control" name="txt_upass" placeholder="Enter Password" />
              </div>
              <div class="form-group">
                <textarea class="form-control" name="bio" placeholder="Enter your BIO here"><?php if(strlen($usersRow['bio']) > 0){ echo $usersRow['bio']; }?></textarea>
              </div>
              <div class="clearfix"></div>
              <div class="form-group">
                <button type="submit" class="btn btn-primary" name="btn-signup">
                    <i class="glyphicon glyphicon-save"></i>&nbsp;SAVE CHANGES
                  </button>
              </div>
              <br />
        </form>
       </div>
     </div>
</div>

<script src="bootstrap/js/bootstrap.min.js"></script>

</body>
</html>