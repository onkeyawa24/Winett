<?php 
include('database_connections.php');
require_once("session.php");
require_once('class.post.php');
require_once("class.user.php");
$auth_user = new USER();

if(isset($_POST['comment'])){
	$comment_content=$_POST['comment'];
	if(strlen($comment_content)<1)
	{
		/*$auth_user->redirect('Posts.php#'.$post_id);*/
	}
	else
	{
		$post_id = $_POST['id'];
		$date_modified = date("Y-m-d H-i-s");
		$commenter_id = $_SESSION['user_id'];
		if($auth_user->comment($commenter_id,$post_id,$comment_content,$date_modified))
		{
			/*$auth_user->redirect('Posts.php#'.$post_id);*/
		}
		else
		{
			echo "NOT SHARED";
			/*$user->redirect('Posts.php#'.$post_id);*/
		}
	}
}
?>