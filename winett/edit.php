<?php

	require_once("session.php");
	
	require_once("class.user.php");
	$auth_user = new USER();	
	$user_id = $_SESSION['user_session'];
	
	$stmt = $auth_user->runQuery("SELECT * FROM users WHERE user_id=:user_id");
	$stmt->execute(array(":user_id"=>$user_id));
	$userRow=$stmt->fetch(PDO::FETCH_ASSOC);
 
  $cmd = $auth_user->runQuery("SELECT * FROM user_details WHERE user_id=:user_id");
  $cmd->execute(array(":user_id"=>$user_id));
  $user_detailsRow = $cmd->fetch(PDO::FETCH_ASSOC);

  if(isset($_POST['btn-signup']))
{

  $username = strip_tags($_POST['txt_umail']);
  $user_firstname = strip_tags($_POST['txt_firstname']);
  $user_lastname = strip_tags($_POST['txt_lastname']);
  $gender = $_POST['gender'];
  $bio = strip_tags($_POST['txt_bio']);
 
  $upass = strip_tags($_POST['txt_upass']);
    try
    {
      $stmt = $auth_user->runQuery("SELECT * FROM users WHERE username='$username'");
      $stmt->execute();
      $row=$stmt->fetch(PDO::FETCH_ASSOC);
       
      
      if($auth_user->update($user_id, $username, $user_firstname, $user_lastname,  $gender, $upass))
      { 
        if($auth_user->registerUser($user_id, $bio, $date_modified)){
        $auth_user->redirect('profile.php');
      }
      else
      {
        echo "Could not update";
      }
      }
      else{
        echo "Could not update ";
      }
    }
    catch(PDOException $e)
    {
      echo $e->getMessage();
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
</head>

<body>
 

    <div class="clearfix"></div>
    <h1 class="text-center"><i class="glyphicon glyphicon-user"></i>Edit Profile</h1>
    	<div class="container">
      
        <form method="post" class="">
           
              <div class="form-group">
              <input type="text" class="form-control" name="txt_firstname" placeholder="Enter firstname" value="<?php echo $userRow['user_firstname'];?>" />
              </div>
              <div class="form-group">
              <input type="text" class="form-control" name="txt_lastname" placeholder="Enter lastname" value="<?php echo $userRow['user_lastname'];?>" />
              </div>
              <div class="form-group">
              <input type="text" class="form-control" name="txt_umail" placeholder="Enter E-Mail ID" value="<?php echo $userRow['username'];?>" />
              </div>
              <div class="form-group">
                Male <input type="radio" name="gender" value="m" checked/>
                Female <input type="radio"  name="gender"value="f"/>
              </div>

              <div class="form-group">
                <textarea class="form-control" name="txt_bio" placeholder="Enter your BIO here"><?php if(strlen($user_detailsRow['bio']) > 0){ echo $user_detailsRow['bio']; }?></textarea>
              </div>
                
              <div class="form-group">
                <input type="password" class="form-control" name="txt_upass" placeholder="Enter Password" />
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

<script src="bootstrap/js/bootstrap.min.js"></script>

</body>
</html>