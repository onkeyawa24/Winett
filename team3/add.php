<?php
session_start();
include_once('users.php');
include_once('conn.php');

if(!($_SESSION['user_id']==3))
{
	header("location: index.php");
}

$ids=$_SESSION['user_id'];
if(isset($_GET['id']))
{ 
	$id = $_GET['id'];

	$edited='<i style="color: red;">This post has been removed. <b style="blue"></i>';
	$sqly = "UPDATE comments SET comment ='$edited' WHERE comment_id='$id'";
	$stmty = $conn->prepare($sqly);
	$stmty->execute();
	$rowy=$stmty->fetch(PDO::FETCH_ASSOC);?>
	<div id="insert_photo" class="modal" role="dialog">
          <div class="modal-dialog">
            <div class="modal-content ">
              <div class="modal-header">Insert photo from your gallery
              </div>
              <div class="modal-body myModals">
                 This post is violating the private policy of the Underworld.
              </div>
            </div>
          </div>
        </div><?
	header("Location: admin.php");
}
?>