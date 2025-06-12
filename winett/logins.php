
<?php
session_start();
include('conn.php');
include('database_connections.php');
require_once("class.user.php");
$login = new USER();/*
if($login->is_loggedin()!="")
{
  $login->redirect('Posts.php');
}*/
$message = '';

if(isset($_SESSION['user_id']))
{
 header('location:Posts.php');
}

if(isset($_POST["login"]))
{
  $umail = strip_tags($_POST['username']);
  $upass = strip_tags($_POST['password']);
  $query = "
   SELECT * FROM users 
    WHERE username = :username limit 1
  ";
  $statement = $connect->prepare($query);
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
        $sub_query = "
        INSERT INTO login_details(user_id) 
        VALUES ('".$row['user_id']."')
        ";
        $statement = $connect->prepare($sub_query);
        $statement->execute();
        if($login->doLogin($umail,$upass))
        {
          $id = $_SESSION['user_id'];
          $sstatus = 1;
          $time_created =  date("Y-m-d H-i-s");

          $sqml = mysqli_query($conn," SELECT * FROM loged_in WHERE user_id = '$id' ORDER BY loged_in_id DESC");

          if (mysqli_num_rows($sqml) > 0)
          {
            $qr = "UPDATE loged_in SET status = '$sstatus', time_created = '$time_created' WHERE user_id = '$id'" ;
            $s_t = $connect->prepare($qr); 
            $s_t->execute();
          }
          else
          {
            $data = array(
              ':user_id'  => $id,
              ':time_created' => $time_created,
              ':status'   => $sstatus);

            $que_ry = " INSERT INTO loged_in (user_id, status, time_created) VALUES (:user_id, :status, :time_created) ";
            $stateme_nt = $connect->prepare($que_ry);
            $stateme_nt->execute($data);
          }
          $login->redirect('Posts.php');
        }
        else
        {
          $error = "Wrong Details !";
        }
        header("location:Posts.php");
        $_SESSION['login_details_id'] = $connect->lastInsertId();
      }
      else
      {
       $message = "<label style='color:red;'>Wrong username or password</label>";
      }
    }
  }
  else
  {
    $message = "<label style='color:red;'>Wrong username or password!</label>";
  }
}

?>
<html lang="en">  
  <head>  
    <title>Winett | Login</title>  
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="./boot/jquery-ui.css">
    <link rel="stylesheet" href="./boot/bootstrap.min.css">
    <link rel="stylesheet" href="./boot/emojionearea.min.css">
    <script src="./boot/jquery-1.12.4.js"></script>
    <script src="./boot/jquery-ui.js"></script>
    <script src="./boot/emojionearea.min.js"></script>
    <style>
      body{
        background-color: #25383c;
      }
      .col-md-12{
        width: 100%;
      }
    
      label{
        color: silver;
        padding-bottom: 3px;
      }
      .form_input{
        padding:3px 3px 3px 6px;
        border-radius: 5px;
        border: 1px solid white;
      }
      .form_body{
        margin-top: 2%;
        padding:3%;
        background-color: #25383c; 
        border-radius: 20px;
        border:3px solid #2F4F4F;
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
    <p class="top_headr"><img class="logoImage" src="./images/wilogo.png" width="35" height="35">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;WiNett</p>   
    <div class="col-md-12">
      <div class="col-md-4">
      </div>
      <div class="col-md-4">
        <div class="form_body">
          <form method="post"> <!-- LOGIN FORM -->
            <center><h5 style="color: #DCDCDC;">Login to WiNett</h5></center>
            <p class="text-danger"><?php echo $message; ?></p>
            <div class="form-group">
              <label>Username</label><br>
              <input type="text" name="username" class="form-control" required placeholder="Username" />
            </div>
            <div class="form-group">
              <label>Password</label><br>
              <input type="password" name="password" class="form-control" required placeholder="Password" />
            </div>
            <div class="form-group">
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