<?php 
include('database_connections.php');
include('session.php');
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
          $output = 'Alert<small><span class="label label-success" style="border-radius:100%; color:orange; background-color:transparent; border: 2px solid orange;">'.$count.'</span></small>';
      }
      else
      {
          $output = 'Alert';
      }
    }
    echo $output;

?>