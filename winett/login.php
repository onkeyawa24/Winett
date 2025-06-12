<?php
session_start();
require_once("class.user.php");
$login = new USER();

if($login->is_loggedin()!="")
{
	$login->redirect('index.php');
}

if(isset($_POST['btn-login']))
{
	$umail = strip_tags($_POST['txt_uname_email']);
	$upass = strip_tags($_POST['txt_password']);
		
	if($login->doLogin($umail,$upass))
	{
		$login->redirect('index.php');
	}
	else
	{
		$error = "Wrong Details !";
	}	
}
?>
<!DOCTYPE html >
 
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Winett : Login</title>
<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
<link href="bootstrap/css/bootstrap-theme.min.css" rel="stylesheet" media="screen">
<link rel="stylesheet" href="style.css" type="text/css"  />

<style type="text/css">
    .login{
        background-color: #2c3539;
        position: center;
    }
    h2{
        color: white;
    }
    label{
        color: white;
    }
</style>
</head>
<body>

<div class="signin-form">

	<div class="container">
     
        <div class="login"><center>
       <form class="form-signin" method="post" id="login-form">
      
        <h2 class="form-signin-heading"><b><center>Winett</center></b></h2><hr />
        
        <div id="error">
        <?php
			if(isset($error))
			{
				?>
                <div class="alert alert-danger">
                   <i class="glyphicon glyphicon-warning-sign"></i> &nbsp; <?php echo $error; ?> !
                </div>
                <?php
			}
		?>
        </div>
        
        <div class="form-group">
        <input type="text" class="form-control" name="txt_uname_email" placeholder="Username or E mail ID" required />
        <span id="check-e"></span>
        </div>
        
        <div class="form-group">
        <input type="password" class="form-control" name="txt_password" placeholder="Your Password" />
        </div>
       
     	<hr />
        
        <div class="form-group">
            <button type="submit" name="btn-login" class="btn btn-default">
                	<i class="glyphicon glyphicon-log-in"></i> &nbsp; SIGN IN
            </button>
        </div>  
      	<br />
            <label>Don't have account yet ! <a href="signup.php">Sign Up</a></label>
      </form></center>
  </div>
    </div>
    
</div>

</body>
</html>