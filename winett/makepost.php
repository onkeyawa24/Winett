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
<!DOCTYPE html>
<html >
<head>
<meta name="viewport" content="width=device-width, initial-scale=1, charset=utf-8">
<link rel="icon" sizes="192*192" href="winett.png">
<link rel="stylesheet" href="./boot/jquery-ui.css">
<link rel="stylesheet" href="./boot/bootstrap.min.css">
<script src="./boot/jquery-1.12.4.js"></script>
<script src="./boot/jquery-ui.js"></script>
<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
<link href="bootstrap/css/bootstrap-theme.min.css" rel="stylesheet" media="screen">
<script type="text/javascript" src="jquery-1.11.3-jquery.min.js"></script>
<link rel="stylesheet" type="text/css" href="style.css">
<script src="script.js"></script>
<script src="jquery.min.js"></script>
<title>Post</title>
<style type="text/css">
  .md_11{
    background-color: grey;
    width: 100%;
  }
  
  
   #bun{
    background-color: silver;
    border-radius: 5px;
  }
  .txt_post{
    border-radius: 6px; padding-top: 5px; padding-right: 8px; padding-left: 8px; padding-bottom: 5px;
    background-color: green; color: white; border: 1px solid white;
    max-height: 70px; margin-left: 4px;
  }
  .frm_post{
    display: inline-flex; align-items: flex-end; max-height: 70px; justify-content: center; margin: 1px; padding: 1px;
  }
  .btn_upload{
       max-height: 70px; max-width: 100px; 
  }
</style>
</head>
<body>
  
      <form data-parsley-validate class="frm_post" method="post" action="makepost.php">   
        <textarea name="editer" placeholder="Talk here" class="form-control" required="required"></textarea>
        <input type="submit" name="submit_post" value="Share" class="txt_post">
      </form>
      <button class="btn_upload" data-toggle="modal" data-target="#insert_photo" style="background-color:  transparent; border: none; color: #00386f;"><i class="fa fa-picture-o" style="font-size: 35px;"></i></button>
      <button class="btn_upload" data-toggle="modal" data-target="#insert_photo" style="background-color:  transparent; border: none; color: #00386f;"><i class="fa fa-film" style="font-size: 32px; margin-bottom: 2px;"></i></button>
      
      <button class="btn_upload" data-toggle="modal" data-target="#insert_photo" style="background-color:  transparent; border: none; color: #00386f;"><i class="fa fa-file-pdf-o" style="font-size: 30px; margin-bottom: 2px;"></i></button>
  <div id="insert_photo" class="modal" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content ">
        <div class="modal-header">Insert photo from your gallery
        </div>
        <div class="modal-body myModals">
          <form action="upload.php" method="post" enctype="multipart/form-data">
            <input type="hidden" name="MAX_FILE_SIZE" value="409600019" />
            <div id="filediv"><input name="file[]" type="file" id="file"/></div>
            
            <button type="button" id="add_more" style="background-color:  transparent; border: none;"><i class="fa fa-plus" style="font-size: 35px; opacity: 1;"></i></button>
            <input type="submit" value="Upload" name="submit" id="upload" class="upload"/>
          </form>     
        </div>
      </div>
    </div>
  </div>
  <script src="bootstrap/js/bootstrap.min.js"></script>
  <script type="text/javascript" src="js/jquery.min.js"></script>
  <script type="text/javascript" src="js/bootstrap.min.js"></script>
  <script type="text/javascript" src="js/js/ckeditor_4.9.2_full/ckeditor/ckeditor.js"></script>
  <script type="text/javascript" src="js/parsley.min.js"></script>
</body>
</html>
              