<?php
	session_start();
	require_once('users.php');
	
	$error_message = ' ';
	$error = array();
	if(isset($_POST['btn-signup']))
	{
	
		$upass = strip_tags($_POST['txt_upass']);
		$upass2 = strip_tags($_POST['txt_upass2']);

		if(!($upass == $upass2))
		{
			echo "password dont match";
			$error_message = "Password did not match!";
			
		}
		else
		{
	
			$umail = strip_tags($_POST['txt_umail']);
			$display_name = strip_tags($_POST['display_name']);
			$gender = $_POST['gender'];
			 
			/*if($display_name=="")	{
				$error[] = "Provide lastname !";	
			}
		
			else if($umail=="")	{
				$error[] = "provide email id !";	
			}
			else if(!filter_var($umail, FILTER_VALIDATE_EMAIL))	{
			    $error[] = 'Please enter a valid email address !';
			}
			else if($upass=="")	{
				$error[] = "provide password !";
			}
			else if(strlen($upass) < 6){
				$error[] = "Password must be atleast 6 characters";	
			}
			else
			{*/
				try
				{
					$sql = "SELECT * FROM users WHERE username='$umail'";
          			$stmt = $conn->prepare($sql);
					$stmt->execute();
					$row=$stmt->fetch(PDO::FETCH_ASSOC);
					/*echo $row['display_name']." ";
 					echo $row['username'];*/
					if($row['username']==$umail) 
					{
						echo "This email address is already taken ";
						$error[] = "This email address is already taken !";
					}
					else
					{
					
						if(register_user($umail, $display_name, $gender, $upass))
						{	
							
							header("Location: login.php");
						}
						else{
							echo "RETRY!";
						}
					}
				}
				catch(PDOException $e)
				{
					echo $e->getMessage();
				}echo "TRY AGAIN";
			/*}*/
		}	
	}

?>
<!DOCTYPE html  >
 
<head>
	<title>Wirenett | Signup</title>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="./js/jquery-ui.css">
    <link rel="stylesheet" href="./js/bootstrap.min.css">
    <script src="./js/jquery-1.12.4.js"></script>
    <script src="./js/jquery-ui.js"></script>

<style type="text/css">
html{
	width: 100%;
}
	body{
        background-color: grey;
    }
  	.singn_form{
		color: black;
		background-color: #DCDCDC;
		width: 100%;
		padding-left: 3px;
	}
	 
	.rad-butns{
		color: white;
	}
	.signup{
		background-color: silver;
		margin-top: 5%;
		padding: 2%;
	}
	.select-user-type{
		margin-top: 2%;
		margin-bottom: 2%;
		margin-left: -2%;
	}
	.singn_form_date{
		 
		width: 32%;
	}
	h2{
		color: #DA6501;
		font-style: bold;
	}
	.date-of-birth{
		margin-top: 2%;
		margin-bottom: 2%;
	}

</style>

</head>

<body>
<div class="col-md-12">
    <div class="col-md-4">
    </div>
    <div class="col-md-4"> 
    	<div class="signup">
        	<form method="post">
	            <label>Display name </label>
	            <div class="form-group">
	            	<input type="text" class="singn_form" name="display_name" placeholder="Display name"  required="required" data-error="Name is required."/>
	            </div>
	            <div class="form-group">
	            	<label>Email</label>

	            	<input type="email" class="singn_form" name="txt_umail" placeholder="Email"  required="required" data-error="Lastname is required." />
	            </div>
	            <label>Select gender </label><br>
	            <div class="form-group">
	            	<label style="color:orange">Male &nbsp;</label><input type="radio" name="gender" value="m" checked />&nbsp;&nbsp;&nbsp;&nbsp;
	            	<label style="color:orange">Female&nbsp; </label><input type="radio"  name="gender"value="f"/>
	            </div> 	
	             
              	<label>Set password</label>
	            <div class="form-group">
	            	<input type="password" class="singn_form" name="txt_upass" placeholder="Enter Password" required="required" data-error="Lastname is required."/>
	            </div>
	            <label>Confirm password</label>
	            <div class="form-group">
	            	<input type="password" class="singn_form" name="txt_upass2" placeholder="Confirm Password" required="required" data-error="Lastname is required."/>
	            </div>
	            <p style="color:red;"><?php echo $error_message;?></p>
	            <div class="clearfix"></div>
	            <div class="form-group">
	            	<button type="submit" class="btn btn-primary" name="btn-signup">
	                	<i class="glyphicon glyphicon-open-file"></i>&nbsp;SIGN UP
	                </button>
	            </div>
	            <br/>
	            <label>have an account ? <a href="login.php">Sign in</a></label>
        	</form>
        </div>     
	</div>
	<div class="col-md-4">
    </div>
</div>
</body>
</html>