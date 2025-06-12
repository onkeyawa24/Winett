<style>
  .speech-bubble:after { content: ''; position: absolute; left: 0; top: 5%; width: 0; height: 0; border: 10px solid transparent; border-right-color: #00aabb; border-left: 0; border-bottom: 0; margin-top: -5px; margin-left: -10px; }
</style>
<?php
//database_connection.php

$connect = new PDO("mysql:host=localhost;dbname=wenett; charset = utf8mb4", "root", "");

function insert_chat($connect)
{
  $data = array(
   ':to_user_id'  => $_POST['to_user_id'],
   ':from_user_id'  => $_SESSION['user_id'],
   ':chat_message'  => $_POST['chat_message'],
   ':status'   => '1');

  $query = " INSERT INTO chat_message (to_user_id, from_user_id, chat_message, status) VALUES (:to_user_id, :from_user_id, :chat_message, :status) ";

  $statement = $connect->prepare($query);

  if($statement->execute($data))
  {
   echo fetch_user_chat_history($_SESSION['user_id'], $_POST['to_user_id'], $connect);
  }
}

function fetch_group_chat_history($connect)
{
  $query = "SELECT * FROM chat_message WHERE to_user_id = '0' ORDER BY timestamp DESC";

  $statement = $connect->prepare($query);

  $statement->execute();

  $result = $statement->fetchAll();

  $output = '<ul class="list-unstyled">';
  foreach($result as $row)
  {
    $user_name = '';
    if($row["from_user_id"] == $_SESSION["user_id"])
    {
      $user_name = '<b class="text-success">You</b>';
    }
    else
    {
      $user_name = '<b class="text-danger">'.get_user_name($row['from_user_id'], $connect).'</b>';
    }

    $output .= '
      <li style="border-bottom:1px dotted #ccc">
        <p>'.$user_name.' - '.$row['chat_message'].' 
          <div align="right">
            -<small><em>'.$row['timestamp'].'</em></small>
          </div>
        </p>
      </li>
    ';
  }
  $output .= '</ul>';
  return $output;
}

function sort_user_by_chat($this_user, $connect)
{
  $id = $_SESSION['user_id'];
  $query = " SELECT * FROM chat_message WHERE WHERE from_user_id = '".$id."' AND to_user_id = '".$this_user."' OR from_user_id = '".$this_user."' AND to_user_id = '".$id."' ORDER BY chat_message_id DESC limit 1";
  $statement = $connect->prepare($query);
  $statement->execute();
  $count_message = $statement->rowCount();
  if($count_message > 0)
  {
    return true;
  }
  else
  {
    return false;
  }
}
function is_in_me($u, $arry)
{
  $num=0;
  
  for ($a1=0; $a1 < count($arry) ; $a1++) { 
    if($arry[$a1] == $u)
    {
      $num++;
    }
  }
  
  if($num != 0)
  {
    return true;
  }
  if($num == 0)
  {
    return false;
  }
}

function fetch_user($connect)
{
  $query = " SELECT * FROM users WHERE user_id != '".$_SESSION['user_id']."'";
  $statement = $connect->prepare($query);
  $statement->execute();
  $result = $statement->fetchAll(); 

  $user_id = $_SESSION['user_session']; $id = $_SESSION['user_id']; $myusrs = array();
  $n_usr = array();
  $sql = " SELECT user_id FROM users WHERE user_id != '$id'";
  $stmt = $connect->prepare($sql);
  $stmt->execute();
  $userRow=$stmt->fetch(PDO::FETCH_ASSOC);
  $count = $stmt->rowCount();
  $output = '<div></div>'; $p=0; $q=0; $prev_chat='***********************';
  ?><p class="contact_header" id="contacts_<?php echo $id;?>"><?php echo "Chats(".$count.")";?></p><hr><?php
  foreach($result as $row)
  {
    $this_user = $row['user_id']; 
    if(sort_user_by_chat($this_user, $connect)){
      if(count($myusrs)>0){
        if(!(is_in_me($this_user, $myusrs))){
          $myusrs[$p] = $this_user;
          $p++;
        }
      }
      else
      {
        $myusrs[$p] = $this_user;
        $p++;
      }
    }
    else{
      if(count($n_usr)>0){
        if(!(is_in_me($this_user, $n_usr))){
          $n_usr[$q] = $this_user;
          $q++;
        }
      }
      else
      {
        $n_usr[$q] = $this_user;
        $q++;
      }
    }
  }
  if(count($myusrs)>0){
      for ($xx=0; $xx < count($n_usr) ; $xx++) { 
        $this_user = $myusrs[$xx];
        $id = $_SESSION['user_id'];
        $msg_query = " SELECT chat_message FROM chat_message WHERE WHERE from_user_id = '$id' AND to_user_id = '$this_user' OR from_user_id = '$this_user' AND to_user_id = '$id' ORDER BY chat_message_id DESC limit 1";
        $msg_statement = $connect->prepare($msg_query);
        $msg_statement->execute();
        $result_x = $msg_statement->fetchAll();
        foreach($result_x as $msg_row_x)
        {
          $prev_chat = $msg_row_x['chat_message'];
        }
        include('chat_display.php');
      }
    }
    if(count($n_usr)>0)
    {
      for ($gg=0; $gg < count($n_usr) ; $gg++) { 
        $this_user = $n_usr[$gg];
        
        include('chat_display.php');
      }
    } 
$myusrs=NULL; $n_usr=NULL;
  return $output;
}

function fetch_user_last_activity($user_id, $connect)
{
  $query = "SELECT * FROM login_details WHERE user_id = '$user_id' ORDER BY last_activity DESC LIMIT 1";
  $statement = $connect->prepare($query);
  $statement->execute();
  $result = $statement->fetchAll();
  foreach($result as $row)
  {
    return $row['last_activity'];
  }
}

function fetch_user_chat_history($from_user_id, $to_user_id, $connect)
{
  $query = "
    SELECT * FROM chat_message WHERE (from_user_id = '".$from_user_id."' AND to_user_id = '".$to_user_id."') OR (from_user_id = '".$to_user_id."' AND to_user_id = '".$from_user_id."') ORDER BY timestamp DESC";

  $statement = $connect->prepare($query);
  $statement->execute();
  $result = $statement->fetchAll();

  $output = '';
  $count_message = $statement->rowCount();
  if($count_message > 0)
  {
    foreach($result as $row)
    {
      $chat_id = $row['chat_message_id'];
      if($row["from_user_id"] == $from_user_id)
      {  
        $output .= '
          <div class="" id="'.$chat_id.'" style="display: flex; justify-content: right; margin-bottom: 4px;">
            <div class="">
              <div class=" " style=" overflow-wrap: break-word;">
                <div class="bbc_55 x_9mv" style="">   
                  <span class="" style="">
                    '.$row["chat_message"].'
                  </span>   
                </diV>
              </div>
            </div>  
          </div>';
      }
      else
      {
        $output .= '
          <div class="" id="'.$chat_id.'" style="display: flex; justify-content: left; margin-bottom: 4px;">
            <div class="">
              <div class=" " style=" overflow-wrap: break-word;">
                <div class="bbc_55 x_9nv" style="">   
                  <span class="" style="">
                    '.$row["chat_message"].'
                  </span>   
                </diV>
              </div>
            </div>  
          </div>';
      } 
    }
  }
  else
  {
    $output .= '<p class="no_convo"> You have no conversation with this user.</p>';
  }

  $query = " UPDATE chat_message SET status = '0' WHERE from_user_id = '".$to_user_id."' AND to_user_id = '".$from_user_id."' AND status = '1'";

  $statement = $connect->prepare($query);
  $statement->execute();
  return $output;
}

function get_user_name($user_id, $connect)
{
  $query = "SELECT user_firstname, user_lastname FROM users WHERE user_id = '$user_id'";
  $statement = $connect->prepare($query);
  $statement->execute();
  $result = $statement->fetchAll();
  foreach($result as $row)
  {
    return $row['user_firstname']." ".$row['user_lastname'];
  }
}

function count_unseen_message($from_user_id, $to_user_id, $connect)
{
  $query = " SELECT * FROM chat_message WHERE from_user_id = '$from_user_id' AND to_user_id = '$to_user_id' AND status = '1'";

  $statement = $connect->prepare($query);
  $statement->execute();
  $count = $statement->rowCount();
  $output = '';
  if($count > 0)
  {
    $output = '<span class="label label-success">'.$count.'</span>';
  }
  return $output;
}

function count_group_unseen_message($to_group_id, $connect)
{
  $query = " SELECT * FROM chat_group_message WHERE to_group_id = '$to_group_id' AND status = '1'";
  $statement = $connect->prepare($query);
  $statement->execute();
  $count = $statement->rowCount();
  $output = '888';
  if($count > 0)
  {
    $output = '<span class="label label-success">'.$count.'</span>';
  }
  return $output;
}

function fetch_live_chat_message($from_user_id , $connect)
{
  $output = '';
    $query = " SELECT * FROM live_chat WHERE  from_user_id = '".$from_user_id."'"; 
    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    foreach($result as $row)
    {
      if( $row['to_user_id'] == $_SESSION['user_id'] )
      {
        $output = $row['chat_message'];
      }
    }
  return $output;
}

function fetch_is_type_status($user_id, $connect)
{
  $query = " SELECT is_type FROM login_details WHERE user_id = '".$user_id."' ORDER BY last_activity DESC LIMIT 1"; 
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

function create_group($group_display_name,$connect)
{
  try
  { 
    $group_name = $group_display_name.'_'.$_SESSION['user_id'].'_'.date("Y-m-d H-i-s");
    $admin_id = $_SESSION['user_id'];
    $status = 'active';
    $date_created = date("Y-m-d H-i-s");
    $date_modified = date("Y-m-d H-i-sa");
    $stmt = $connect->prepare("INSERT into chat_groups (group_display_name,group_name,admin_id,status,date_created,date_modified)
    VALUES (':group_display_name',':group_name',':admin_id',':status',':date_created',':date_modified') ");
    $stmt->bindparam(":group_display_name", $group_display_name);
    $stmt->bindparam(":group_name", $group_name);
    $stmt->bindparam(":admin_id", $admin_id);
    $stmt->bindparam(":status", $status);
    $stmt->bindparam(":date_created", $date_created);
    $stmt->bindparam(":date_modified", $date_modified);

    $stmt->execute();

    return $stmt;
  }
  catch(PDOException $e)
  {
    echo $e->getMessage();
  }
}

 function fetch_notifications($connect)
{
  $query = "SELECT * FROM users WHERE user_id != '".$_SESSION['user_session']."'";
  $statement = $connect->prepare($query);
  $statement->execute();
  $result = $statement->fetchAll();
  $count = $statement->rowCount(); 
  foreach($result as $row)
  {
    $a=$row['user_id'];
    $b=$_SESSION['user_session'];
    $query = " SELECT * FROM notifications WHERE to_user_id = '$b' AND status = '1'";
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
<?php
  /*************************************************/
  /*$sort_by = array(
  ':from_user_id'  => $this_user,
  ':to_user_id' => $id,
  ':date_created'  => $chatRows['timestamp'],
  ':this_status'   => $chatRows['status']);

  $sort_query = " INSERT INTO order_chat_contacts (from_user_id, to_user_id, date_created, status) VALUES (:from_user_id, :to_user_id, :date_created, :this_status) ";
  $sort_stmt = $connect->prepare($sort_query);
  $sort_stmt->execute($sort_by);
 
    $status = '<span class="label label-danger">Offline</span>';
    $current_timestamp = strtotime(date("Y-m-d H:i:s") . '- 10 second'); 
    $current_timestamp = date('Y-m-d H:i:s', $current_timestamp);
    $user_last_activity = fetch_user_last_activity($row['user_id'], $connect);
    if($user_last_activity > $current_timestamp)
    {
      $status = '<span class="label label-success">Online</span>';
    }
    */
?>