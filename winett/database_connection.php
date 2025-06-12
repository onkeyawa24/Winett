<?php
//database_connection.php

$connect = new PDO("mysql:host=localhost;dbname=winett", "root", "");

function get_user_name($user_id, $connect)
{
 $query = "SELECT username FROM users WHERE user_id = '$user_id'";
 $statement = $connect->prepare($query);
 $statement->execute();
 $result = $statement->fetchAll();
 foreach($result as $row)
 {
  return $row['username'];
 }
}

function fetch_is_type_status($user_id, $connect)
{
 $query = "
 SELECT is_type FROM login_details 
 WHERE user_id = '".$user_id."' 
 ORDER BY last_activity DESC 
 LIMIT 1
 "; 
 $statement = $connect->prepare($query);
 $statement->execute();
 $result = $statement->fetchAll();
 $output = '';
 foreach($result as $row)
 {
  if($row["is_type"] == 'yes')
  {
   $output = ' - <small><em><span class="text-muted" style="color:green">Typing...</span></em></small>';
  }
 }
 return $output;
}
 function fetch_notifications($connect)
{
 $query = "
    SELECT * FROM users 
    WHERE user_id != '".$_SESSION['user_session']."' 
    ";
    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    $count = $statement->rowCount();
    static $kiloe = 0; 
    foreach($result as $row)
    {
      $a=$row['user_id'];
      $b=$_SESSION['user_session'];
      $query = "
      SELECT * FROM notifications 
      WHERE to_user_id = '$b' AND status = '1'";
      $statement = $connect->prepare($query);
      $statement->execute();
      $count = $statement->rowCount();
      $output = '';
      if($count > 0)
      {
          $output = 'Notifications<small><span class="label label-success" style="border-radius:100%; color:orange; background-color:transparent; border: 2px solid orange;">'.$count.'</span></small>';
      }
      else
      {
          $output = 'Notifications';
      }
    }
    return $output;
}

?>