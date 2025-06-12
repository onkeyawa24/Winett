

    <?php
    	error_reporting( ~E_NOTICE );
    	

        $conn = MySQLi_connect(
 
   "localhost", //Server host name.
 
   "root", //Database username.
 
   "", //Database password.
 
   "winett" //Database name or anything you would like to call it.
 
);
 
     
    	if(isset($_GET['admin_id']) && !empty($_GET['admin_id']))
    	{
    		$id = $_GET['admin_id'];
    		$stmt_edit = $DB_con->prepare('SELECT name, email, price FROM preschools WHERE admin_id =:uid');
    		$stmt_edit->execute(array(':uid'=>$id));
    		$edit_row = $stmt_edit->fetch(PDO::FETCH_ASSOC);
    		extract($edit_row);
    	}
    	else
    	{
    		header("Location: index.php");
    	}
    	if(isset($_POST['btn-signup']))
    	{
    		$user_name = $_POST['txt_name'];
    		$email = $_POST['txt_umail'];		
    		$phone = $_POST['txt_phone'];
    	 
    		if(!isset($errMSG))
    		{
    			$stmt = $conn->prepare('UPDATE preschools SET name=:uname, email=:udes, phone=:upic WHERE admin_id=:uid');
    			$stmt->bindParam(':uname',$user_name);
    			$stmt->bindParam(':udes',$email);
    			$stmt->bindParam(':upic',$phone);
    			$stmt->bindParam(':uid',$id);
     
    			if($stmt->execute()){
    				?>
                    <script>
    				alert('Successfully Updated...');
    				window.location.href='home.php';
    				</script>
                    <?php
    			}
    			else{
    				$errMSG = "Sorry User Could Not Be Updated!";
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
<title>Edit Profile - <?php print($usersRow['user_email']); ?></title>

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
              <input type="text" class="singn_form" name="txt_name" placeholder="Name"  required="required" data-error="Preschool name is required."/>
              </div>
              <div class="form-group">
              <input type="text" class="singn_form" name="txt_umail" placeholder="Email" required="required" data-error="Email is required." />
              </div>
              <div class="form-group">
              <input type="text" class="singn_form" name="txt_phone" placeholder="Phone number" required="required" data-error="Phone number is required." />
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