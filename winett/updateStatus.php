<?php

//fetch_user.php

include('database_connections.php');

session_start();
 
$query = "
SELECT * FROM users 
WHERE user_id != '".$_SESSION['user_id']."' 
";

$statement = $connect->prepare($query);

$statement->execute();

$result = $statement->fetchAll();
$user_id = $_SESSION['user_session'];
$id = $_SESSION['user_id'];
$sql = "SELECT * FROM users WHERE user_id != '$id'";
$stmt = $connect->prepare($sql);
$stmt->execute();

$userRow=$stmt->fetch(PDO::FETCH_ASSOC);
$count = $stmt->rowCount();
$output = '
<table class="table table-bordered table-striped">
 <tr>
  <th width="50%" style="background-color: #25383c;color:white;">Contacts(<small>'.$count.'</small>)</td>
    </tr>
';

foreach($result as $row)
{
 $status = '';
 $current_timestamp = strtotime(date("Y-m-d H:i:s") . '- 10 seconds');
 $current_timestamp = date('Y-m-d H:i:s', $current_timestamp);
 $user_last_activity = fetch_user_last_activity($row['user_id'], $connect);
 if($user_last_activity > $current_timestamp)
 {
  $status = '<span class="status">Online</span>';
 }
 else
 {
  	$status = '<span class="label label-danger">Offline'.$user_last_activity.'<br>'.$current_timestamp.'</span>';
 }
 $output .= '
 <tr>
  <td><button style="color:black; background-color:transparent; width:100%;text-align:left; border:none;" type="button" class="btn btn-info btn-xs start_chat" data-touserid="'.$row['user_id'].'" data-tousername="'.$row['username'].'"><img id="image" src="./upload/'.$row['user_id'].'.jpg" alt="X" width="30" height="30" style="border-radius:100%;"><b>'.' '.$row['user_firstname'].' '.$row['user_lastname'].'</b> '.count_unseen_message($row['user_id'], $_SESSION['user_id'], $connect).' '.fetch_is_type_status($row['user_id'], $connect).'</button></td>
  

 </tr>
 ';
}

$output .= '</table>';

echo $status;

?>