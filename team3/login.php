
<?php
session_start();
require_once('conn.php');
include_once("users.php");
 
$message = '';

if(isset($_POST["login"]))
{
  $umail = strip_tags($_POST['username']);
  $upass = strip_tags($_POST['password']);
  $query = "
   SELECT * FROM users 
    WHERE username = :username
  ";
  $statement = $conn->prepare($query);
  $statement->execute(
    array(
      ':username' => $_POST["username"]
     )
  );
  $count = $statement->rowCount();
  if($count > 0)
  {
    $result = $statement->fetchAll();
    foreach($result as $row)
    {
      if(password_verify($_POST["password"], $row["password"]))
      {
        $_SESSION['user_id'] = $row['user_id'];
        $_SESSION['username'] = $row['username'];
        
        if(login($umail,$upass))
        {
          if($umail == 'admin@team3.com'){
            header("Location: admin.php");
          }
          else
          {
            header("Location: home.php");
          }
        }
        else
        {
          $error = "Wrong Details !";
        }
      }
      else
      {
       $message = "<label style='color:red;'>Wrong username or password</label>";
      }
    }
  }
  else
  {
    $message = "<label style='color:red;'>Wrong username or password</label>";
  }
}

?>
<html lang="en">  
  <head>  
    <title>Team3 | Login</title>  
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="./js/jquery-ui.css">
    <link rel="stylesheet" href="./js/bootstrap.min.css">
    <script src="./js/jquery-1.12.4.js"></script>
    <script src="./js/jquery-ui.js"></script>
  
    <style>
      body{
        background-color: grey;
      }
      .col-md-12{
        width: 100%;
      }
    
      label{
        color: black;
        padding-bottom: 3px;
      }
      .form_input{
        padding:3px 3px 3px 6px;
        border-radius: 5px;
        border: 1px solid white;
      }
      .form_body{
        margin-top: 10%;
        padding:0% 3% 3% 3%;
        background-color: silver; 
        border-radius: 20px;
        border:3px solid white;
      }
      .form_login{
        padding: 5px;
      } 
      .top_headr{
        color: grey; font-size:150%; background-color: #25383c;
      }
    </style>
  </head>  
  <body>
       
    <div class="col-md-12">
      <div class="col-md-4">
      </div>
      <div class="col-md-4">
        <div class="form_body">
          <form method="post"> <!-- LOGIN FORM -->
            <center><h2>Login</h2></center>
            <p class="text-danger"><?php echo $message; ?></p>
            <div class="form_login">
              <label>Username</label><br>
              <input type="text" name="username" class="form_input" required placeholder="Username" />
            </div>
            <div class="form_login">
              <label>Password</label><br>
              <input type="password" name="password" class="form_input" required placeholder="Password" />
            </div>
            <div class="form_login">
              <input type="submit" name="login" class="btn btn-info" value="Login" />
            </div>
            <label>Don't have account yet ? <a href="signup.php">Sign Up</a></label>
          </form> <!-- END OF LOGIN-->
        </div>
      </div>
      <div class="col-md-4">
      </div>
    </div>
  </body>  
</html>