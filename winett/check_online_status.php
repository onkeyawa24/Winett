<?php 
require_once("session.php");
include('database_connections.php');
include('conn.php');
$id = $_SESSION['user_id'];
/*
$sql = " SELECT user_id FROM users WHERE user_id != '$id'"; 
$stmt = $connect->prepare($sql);
$stmt->execute(); $result = $stmt->fetchAll(); $count = $stmt->rowCount(); */
if(isset($_POST['status']))
{
  $status = $_POST['status'];
  $time_created =  date("Y-m-d H-i-s");

  $sqml = mysqli_query($conn," SELECT * FROM loged_in WHERE user_id = '$id' ORDER BY loged_in_id DESC");

  if (mysqli_num_rows($sqml) > 0)
  {
    $qr = "UPDATE loged_in SET status = '$status', time_created = '$time_created' WHERE user_id = '$id'" ;
    $s_t = $connect->prepare($qr); 
    $s_t->execute();
  }
  else
  {
    $data = array(
      ':user_id'  => $id,
      ':time_created' => $time_created,
      ':status'   => $status);

    $que_ry = " INSERT INTO loged_in (user_id, status, time_created) VALUES (:user_id, :status, :time_created) ";
    $stateme_nt = $connect->prepare($que_ry);
    $stateme_nt->execute($data);
  }
}

