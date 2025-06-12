<?php
include_once('class.user.php');
include_once('session.php');
$auth_user= new USER();
	if(isset($_GET['edit']))
	{ 
		$post_id = $_GET['edit'];
		$stmtz = $auth_user->runQuery("SELECT * FROM post_table WHERE post_id=:post_id");
		$stmtz->execute(array(":post_id"=>$post_id));
		$userRowz=$stmtz->fetch(PDO::FETCH_ASSOC);
	
		$edited='I have edited this';
		$stmty = $auth_user->runQuery("UPDATE post_table SET post_content='$edited' WHERE post_id=:post_id");
		$stmty->execute(array(":post_id"=>$post_id));
		$auth_user->redirect('Posts.php');
	}
	if(isset($_POST['delete'])){
		$post_id = $_POST['post_id'];
		$sql = mysqli_query($auth_user, "SELECT * FROM post_table WHERE post_id=$post_id");
		$rows = mysqli_fetch_array($sql);
	}
	if(isset($_POST['hide'])){
		
	}
	if(isset($_POST['report'])){

	}
	?>