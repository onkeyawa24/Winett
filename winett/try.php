<?php 
require_once("session.php");
include('database_connections.php');
include('conn.php');
$id = $_SESSION['user_id'];
$sql = " SELECT user_id FROM users WHERE user_id != '$id'"; 
  $stmt = $connect->prepare($sql);
  $stmt->execute(); $result = $stmt->fetchAll(); $count = $stmt->rowCount(); 
  $output = '<div></div>'; $p=0; $q=0;  
  ?><p class="contact_header" id="contacts_<?php echo $id;?>"><?php echo "Chats(".$count.")";?></p><hr><?php
  foreach($result as $row)
  {
      $this_user = $row['user_id']; 
      $q_uery = " SELECT * FROM chat_message WHERE from_user_id = '".$id."' AND to_user_id = '".$this_user."' OR from_user_id = '".$this_user."' AND to_user_id = '".$id."' ORDER BY chat_message_id DESC limit 1";
      $s_tatement = $connect->prepare($q_uery); $s_tatement->execute();
      $userRow=$s_tatement->fetch(PDO::FETCH_ASSOC);
      $status = $userRow['status']; $last_chat = $userRow['chat_message_id'];
      $count_message = $s_tatement->rowCount(); 
      $sqml = mysqli_query($conn," SELECT * FROM chat_with WHERE my_id = '$id' AND from_id = $this_user");
      if (mysqli_num_rows($sqml) > 0)
      {
        $qr = "UPDATE chat_with SET chat_id = '$last_chat' WHERE my_id = '$id' AND from_id = $this_user" ;
        $s_t = $connect->prepare($qr); $s_t->execute();
      }
      else
      {
        $data = array(
       ':my_id'  => $id,
       ':from_id'  => $this_user,
       ':status'   => $status,
       ':chat_id'  => $last_chat);
        $que_ry = " INSERT INTO chat_with (my_id, from_id, status, chat_id) VALUES (:my_id, :from_id, :status, :chat_id) ";
        $stateme_nt = $connect->prepare($que_ry);
        $stateme_nt->execute($data);
      }
  }
  ?>

