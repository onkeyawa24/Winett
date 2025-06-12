<?php
include_once('session.php');
include_once('conn.php');;
$id=$_GET['id'];

$result = mysqli_query($conn,"SELECT * from post_table where post_id='$id'")or die(mysqli_error($conn));
$row = mysqli_fetch_array($result);
$poster = $row['poster_id'];
$post = $row['post_id'];
$reporter=$_SESSION['user_session'];
mysqli_query($conn,"INSERT into reported_posts (reported_content_id, reporter_id, poster_id) values ('$post', '$reporter', '$poster')"); 
mysqli_query($conn,"INSERT into notifications (action, post_id, from_user_id, to_user_id, status ) values ('report' , '$id' , '$reporter' , '$poster' , '1')");
header('location:Posts.php');
?>