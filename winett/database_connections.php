<style>
  .speech-bubble:after { content: ''; position: absolute; left: 0; top: 5%; width: 0; height: 0; border: 10px solid transparent; border-right-color: #00aabb; border-left: 0; border-bottom: 0; margin-top: -5px; margin-left: -10px; }
</style>
<?php
//database_connection.php
$conn = mysqli_connect("localhost","root","","wenett");
$connect = new PDO("mysql:host=localhost;dbname=wenett; charset = utf8mb4", "root", "");

function delete_live_chat($connect)
{
   $to_user_id = $_POST['to_user_id'];
   $from_user_id = $_SESSION['user_id'];

  $query = " DELETE FROM live_chat WHERE  from_user_id = '".$from_user_id."' AND to_user_id = '".$to_user_id."'";

  $statement = $connect->prepare($query);

  $statement->execute();
}

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
  $query = "SELECT * FROM chat_message WHERE to_user_id = '0' ORDER BY time_stamp DESC";

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
            -<small><em>'.$row['time_stamp'].'</em></small>
          </div>
        </p>
      </li>
    ';
  }
  $output .= '</ul>';
  return $output;
}
/*
function sort_user_by_chat($this_user, $connect)
{
  $id = $_SESSION['user_id'];
  $q_uery = " SELECT * FROM chat_message WHERE from_user_id = '".$id."' AND to_user_id = '".$this_user."' OR from_user_id = '".$this_user."' AND to_user_id = '".$id."' ORDER BY chat_message_id DESC limit 1";
  $s_tatement = $connect->prepare($q_uery);
  $s_tatement->execute();
  $r_esult = $s_tatement->fetchAll();
  foreach($r_esult as $u_serRow)
  {
    $status = $u_serRow['status'];
    if (empty($last_chat)) {
        $last_chat = 0; // or any default valid chat_id value
    }
    $last_chat = $u_serRow['time_stamp'];
  }
  
  $count_message = $s_tatement->rowCount();
  if($count_message > 0)
  {
    return true;  
  }
  else
  {
    return false;
  }
}*/
function sort_user_by_chat($this_user, $connect)
{
    // Get the current user id from session
    $id = $_SESSION['user_id'];

    // Prepare SQL to fetch the latest chat message between $id and $this_user
    $q_uery = "SELECT * FROM chat_message 
               WHERE (from_user_id = :id AND to_user_id = :this_user) 
                  OR (from_user_id = :this_user AND to_user_id = :id)
               ORDER BY chat_message_id DESC 
               LIMIT 1";

    $s_tatement = $connect->prepare($q_uery);

    // Bind parameters to avoid SQL injection
    $s_tatement->bindParam(':id', $id, PDO::PARAM_INT);
    $s_tatement->bindParam(':this_user', $this_user, PDO::PARAM_INT);
    $s_tatement->execute();

    $r_esult = $s_tatement->fetch(PDO::FETCH_ASSOC);

    // Initialize $status and $last_chat with default values to avoid nulls
    $status = 'pending';     // Default status if none found
    $last_chat = 0;          // Default timestamp (or you can use a valid timestamp)

    if ($r_esult !== false) {
        // Assign actual values from query result, fallback to defaults if empty
        $status = !empty($r_esult['status']) ? $r_esult['status'] : $status;
        $last_chat = !empty($r_esult['time_stamp']) ? $r_esult['time_stamp'] : $last_chat;
    }

    // Return true if a chat message exists, false otherwise
    return ($s_tatement->rowCount() > 0);
}

function is_in_me($u, $arry)
{
  $num=0;
  for ($a1=0; $a1 < count($arry) ; $a1++) { 
    if($arry[$a1] == $u){
      $num++;
    }
  }
  if($num != 0){
    return true;
  }
  if($num == 0){
    return false;
  }
}
function fetch_user($conn, $connect)
{
    $id = $_SESSION['user_id'];
    $output = '';

    // Fetch all users except the current one
    $query = "SELECT * FROM users WHERE user_id != :id";
    $statement = $connect->prepare($query);
    $statement->bindParam(':id', $id, PDO::PARAM_INT);
    $statement->execute();
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);

    $myusrs = [];
    $n_usr = [];

    // Count users excluding current
    $count = count($result);

    $output .= '<p class="contact_header" id="contacts_' . htmlspecialchars($id) . '">Chats(' . $count . ')</p>';

    foreach ($result as $row) {
        $this_user = $row['user_id'];

        if (sort_user_by_chat($this_user, $connect)) {
            if (!in_array($this_user, $myusrs, true)) {
                $myusrs[] = $this_user;
            }
        } else {
            if (!in_array($this_user, $n_usr, true)) {
                $n_usr[] = $this_user;
            }
        }

        // Get the latest chat message between users
        $q_uery = "SELECT * FROM chat_message 
                   WHERE (from_user_id = :id AND to_user_id = :this_user) 
                      OR (from_user_id = :this_user AND to_user_id = :id) 
                   ORDER BY chat_message_id DESC LIMIT 1";

        $s_tatement = $connect->prepare($q_uery);
        $s_tatement->bindParam(':id', $id, PDO::PARAM_INT);
        $s_tatement->bindParam(':this_user', $this_user, PDO::PARAM_INT);
        $s_tatement->execute();

        $userRaw = $s_tatement->fetch(PDO::FETCH_ASSOC);

        $status = 'pending'; // default status
        $last_chat = null;

        if ($userRaw !== false) {
            $status = !empty($userRaw['status']) ? $userRaw['status'] : 'pending';
            $last_chat = $userRaw['chat_message_id'] ?? null;
        }

        // Check if chat_with record exists for this user pair
        $checkChatWith = "SELECT 1 FROM chat_with WHERE my_id = :id AND from_id = :this_user";
        $checkStmt = $connect->prepare($checkChatWith);
        $checkStmt->bindParam(':id', $id, PDO::PARAM_INT);
        $checkStmt->bindParam(':this_user', $this_user, PDO::PARAM_INT);
        $checkStmt->execute();

        if ($checkStmt->fetch()) {
            // Update existing chat_with
            $qr = "UPDATE chat_with SET chat_id = :last_chat WHERE my_id = :id AND from_id = :this_user";
            $updateStmt = $connect->prepare($qr);
            $updateStmt->bindParam(':last_chat', $last_chat, PDO::PARAM_INT);
            $updateStmt->bindParam(':id', $id, PDO::PARAM_INT);
            $updateStmt->bindParam(':this_user', $this_user, PDO::PARAM_INT);
            $updateStmt->execute();
        } else {
            // Insert new chat_with record
            $data = [
                ':my_id'   => $id,
                ':from_id' => $this_user,
                ':status'  => $status,
                ':chat_id' => $last_chat
            ];

            $que_ry = "INSERT INTO chat_with (my_id, from_id, status, chat_id) VALUES (:my_id, :from_id, :status, :chat_id)";
            $stateme_nt = $connect->prepare($que_ry);

            try {
                $stateme_nt->execute($data);
            } catch (PDOException $e) {
                // Log error or handle it accordingly
                error_log("Insert failed: " . $e->getMessage());
            }
        }
    }

    // Optionally display users with no recent chats
    if (!empty($n_usr)) {
        foreach ($n_usr as $this_user) {
            // You can prepare and set variables here if needed before including
            include('chat_display.php');
        }
    }

    // Clear user arrays (optional)
    $myusrs = null;
    $n_usr = null;

    return $output;
}


function sort_user_contacts($connect)
{
  $conn = mysqli_connect("localhost","root","","wenett");
  $id = $_SESSION['user_id'];
  $sql = " SELECT user_id FROM users WHERE user_id != '$id'"; 
  $stmt = $connect->prepare($sql);
  $stmt->execute(); $result = $stmt->fetchAll(); $count = $stmt->rowCount(); 
    
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
        $s_t = $connect->prepare($qr); 
        $s_t->execute();
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
} 

function is_online($user_id, $connect)
{
  $query = "SELECT * FROM loged_in WHERE user_id = '$user_id' AND status = '1' ";
  $statement = $connect->prepare($query);
  $statement->execute();
  $coun = $statement->rowCount();
  if($coun > 0)
  {
    return true;
  }
  else
  {
    return false;
  }
}

function fmt_time($tm, $connect)
{
  $saved_time = $tm;
  $formated_saved_time = new DateTime($saved_time);
  $current_time = new DateTime();
  $interval = $current_time->diff($formated_saved_time);

  if(date_format($formated_saved_time, "m") == 1)
  {
      $get_month = 'Jan';
  }
  elseif(date_format($formated_saved_time, "m") == 2)
  {
      $get_month = 'Feb';
  }
  elseif(date_format($formated_saved_time, "m") == 3)
  {
      $get_month = 'Mar';
  }
  elseif(date_format($formated_saved_time, "m") == 4)
  {
      $get_month = 'Apr';
  }
  elseif(date_format($formated_saved_time, "m") == 5)
  {
      $get_month = 'May';
  }
  elseif(date_format($formated_saved_time, "m") == 6)
  {
      $get_month = 'Jun';
  }
  elseif(date_format($formated_saved_time, "m") == 7)
  {
      $get_month = 'Jul';
  }
  elseif(date_format($formated_saved_time, "m") == 8)
  {
      $get_month = 'Aug';
  }
  elseif(date_format($formated_saved_time, "m") == 9)
  {
      $get_month = 'Sep';
  }
  elseif(date_format($formated_saved_time, "m") == 10)
  {
      $get_month = 'Oct';
  }
  elseif(date_format($formated_saved_time, "m") == 11)
  {
      $get_month = 'Nov';
  }
  elseif(date_format($formated_saved_time, "m") == 12)
  {
      $get_month = 'Dec';
  }
  else
  {
      $get_month = 'Error!';
  }

  if (!empty($interval->format('%a')))
  {
      $time_difference=$interval->format('%a days ago');
      if($time_difference == 1)
      {
          $time_difference = 'yesterday';
      }
      elseif($time_difference > 6 && $time_difference < 14)
      {
          $time_difference = '1 Week ago';
      }
      elseif ($time_difference >= 14 && $time_difference < 21) 
      {
          $time_difference = ' 2 Weeks ago';
      }
      elseif ($time_difference >= 21  && $time_difference < 28) 
      {
          $time_difference = ' 3 Weeks ago';
      }
      elseif ($time_difference >= 28 ) 
      {
           
              if(date_format($formated_saved_time, "y") == date_format($current_time, "y"))
              {
                  $time_difference = date('d',strtotime($tm))." ".$get_month;
              }
              else
              {
                  $time_difference = date('d',strtotime($tm))." ".$get_month." ".date_format($formated_saved_time, "y");
              } 
             
      } 
      /****************/ /*///////// /* */  /* */ /*ui*/
  } 
  elseif ($formated_saved_time->format('d') != $current_time->format('d'))
  {
      $time_difference="yesterday";
  }
  elseif (!empty($interval->format('%h')))
  {
      $time_difference=$interval->format('%h hrs ago');
  }
  elseif (!empty($interval->format('%i')))
  {
      $time_difference=$interval->format('%i min ago');
  } 
  elseif (!empty($interval->format('%s')))
  {
       $time_difference=$interval->format('%s sec ago');
  } 
  else
  {
      $time_difference = 'Now';
  }
return $time_difference;
}

function fetch_user_chat_history($from_user_id, $to_user_id, $connect)
{
    // Prepare the SQL with placeholders to avoid injection
    $query = "
        SELECT * FROM chat_message 
        WHERE (from_user_id = :from_user_id AND to_user_id = :to_user_id)
           OR (from_user_id = :to_user_id AND to_user_id = :from_user_id)
        ORDER BY timestamp DESC";

    $statement = $connect->prepare($query);
    $statement->execute([
        ':from_user_id' => $from_user_id,
        ':to_user_id' => $to_user_id
    ]);
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);

    $output = '';
    $count_message = $statement->rowCount();

    if ($count_message > 0) {
        foreach ($result as $row) {
            $contains = $row['contains'];
            $img = './chat_image/' . htmlspecialchars($row['image_name']);
            $chat_id = (int)$row['chat_message_id'];
            $is_from_user = ($row['from_user_id'] == $from_user_id);

            // Choose alignment and CSS classes based on sender
            $justify = $is_from_user ? 'right' : 'left';
            $bbc_class = $is_from_user ? 'bbc_55 x_9mv' : 'bbc_55 x_9nv';
            $span_style = $is_from_user ? 'color: white;' : '';
            
            // Fix style quotes and structure
            $container_style = "display: flex; justify-content: $justify; margin-bottom: 4px; padding: 0px;";

            if ($contains === 'img') {
                $output .= '
                <div id="' . $chat_id . '" style="' . $container_style . '">
                  <div>
                    <div style="overflow-wrap: break-word; padding: 0px;">
                      <div class="' . $bbc_class . '" style="padding: 0px;">
                        <span style="' . $span_style . ' padding: 0px;">
                          <img src="' . $img . '" alt="Image not found..." class="img_class" style="padding: 3px;"><br>
                          <div style="padding: 4px;">' . htmlspecialchars($row["chat_message"]) . '</div>
                        </span>
                      </div>
                    </div>
                  </div>
                </div>
                <div id="chat_id_' . $chat_id . '" class="modal this_modal" style="width: 100%; max-width: 180px; max-height: 50px; background-color: white; color: black;" role="dialog">
                  <div class="modal-content mi_modal-content" id="chat_content_' . $chat_id . '">
                    <span style="padding: 4px; border: 1px solid red; cursor: pointer;">DELETE</span>
                  </div>
                </div>';
            } else {
                $output .= '
                <div id="' . $chat_id . '" style="' . $container_style . '">
                  <div>
                    <div style="overflow-wrap: break-word;">
                      <div class="' . $bbc_class . '">
                        <span style="' . $span_style . '">
                          ' . nl2br(htmlspecialchars($row["chat_message"])) . '
                        </span>
                      </div>
                    </div>
                  </div>
                </div>
                <div id="chat_id_' . $chat_id . '" class="modal this_modal" style="width: 100%; max-width: 180px; max-height: 50px; background-color: white; color: black;" role="dialog">
                  <div class="modal-content mi_modal-content" id="chat_content_' . $chat_id . '">
                    <span style="padding: 4px; border: 1px solid red; cursor: pointer;">DELETE</span>
                  </div>
                </div>';
            }
        }
    } else {
        $output .= '<p class="no_convo">You have no conversation with this user.</p>';
    }

    // Update message status to read (0) for messages sent by to_user_id to from_user_id
    $update_query = "
        UPDATE chat_message 
        SET status = '0' 
        WHERE from_user_id = :to_user_id 
          AND to_user_id = :from_user_id 
          AND status = '1'";
    $update_stmt = $connect->prepare($update_query);
    $update_stmt->execute([
        ':to_user_id' => $to_user_id,
        ':from_user_id' => $from_user_id
    ]);

    return $output;
}

/*
function fetch_user_chat_history($from_user_id, $to_user_id, $connect)
{
  $from_user_id = $_SESSION['user_id'];
  $query = "
    SELECT * FROM chat_message WHERE (from_user_id = '".$from_user_id."' AND to_user_id = '".$to_user_id."') OR (from_user_id = '".$to_user_id."' AND to_user_id = '".$from_user_id."') ORDER BY time_stamp DESC";

  $statement = $connect->prepare($query);
  $statement->execute();
  $result = $statement->fetchAll();

  $output = '';
  $count_message = $statement->rowCount();
  if($count_message > 0)
  {
    foreach($result as $row)
    {
      $contains = $row['contains'];
      $img = './chat_image/'.$row['image_name'];
      $chat_id = $row['chat_message_id'];
      $chat_id = $row['chat_message_id'];
      if($contains == 'img')
      {
        if($row["from_user_id"] == $from_user_id)
        {  
          $output .= '
            <div class="" id="'.$chat_id.'" style="display: flex; justify-content: right; margin-bottom: 4px; padding: 0px;">
              <div class="">
                <div class=" " style=" overflow-wrap: break-word; padding: 0px;">
                  <div class="bbc_55 x_9mv" style="padding: 0px;">   
                    <span style="color: white; padding: 0px;">
                      <img src="'.$img.'" alt="Image not found..." class="img_class" style="padding: 3px;"><br>
                        <div style="padding: 4px; ">'.$row["chat_message"].'</div>
                    </span> 
                  </div>
                </div>
              </div>  
            </div>
            <div id="chat_id_'.$chat_id.'" class="modal this_modal" style="width: 100%; max-width: 180px; max-height: 50px; background-color: white; color: black;  "  role="dialog">
                <div class="modal-content mi_modal-content" id="chat_content_'.$chat_id.'">
                    <span style="padding: 4px; border: 1px solid red;">DELETE</span>
                </div>
            </div>
            ';
        }
        else
        {
          $output .= '
            <div class="" id="'.$chat_id.'" style="display: flex; justify-content: left; margin-bottom: 4px;" padding: 0px;>
              <div class="">
                <div class=" " style=" overflow-wrap: break-word; padding: 0px;">
                  <div class="bbc_55 x_9nv" style="padding: 0px;">   
                    <span style="padding: 0px;">
                      <img src="'.$img.'" alt="Image not found..." class="img_class" style="padding: 3px;"><br>
                      <div style="padding: 4px; ">'.$row["chat_message"].'</div>
                    </span>   
                  </div>
                </div>
              </div>  
            </div>
            <?php include("format_date.php"); ?>
            <div id="chat_id_'.$chat_id.'" class="modal this_modal" style="width: 100%; max-width: 180px; max-height: 50px; background-color: white; color: black;  "  role="dialog">
                <div class="modal-content mi_modal-content" id="chat_content_'.$chat_id.'">
                    <span style="padding: 4px; border: 1px solid red;">DELETE</span>
                </div>
            </div>
            ';
        } 
      }
      else
      {
        if($row["from_user_id"] == $from_user_id)
        {  
          $output .= '
            <div class="" id="'.$chat_id.'" style="display: flex; justify-content: right; margin-bottom: 4px;">
              <div class="">
                <div class=" " style=" overflow-wrap: break-word;">
                  <div class="bbc_55 x_9mv" style="">   
                    <span style="color: white;">
                      '.$row["chat_message"].'
                    </span>
                  </div>
                </div>
              </div>  
            </div>
            <div id="chat_id_'.$chat_id.'" class="modal this_modal" style="width: 100%; max-width: 180px; max-height: 50px; background-color: white; color: black;  "  role="dialog">
                <div class="modal-content mi_modal-content" id="chat_content_'.$chat_id.'">
                    <span style="padding: 4px; border: 1px solid red;">DELETE</span>
                </div>
            </div>
            ';
        }
        else
        {
          $output .= '
            <div class="" id="'.$chat_id.'" style="display: flex; justify-content: left; margin-bottom: 4px;">
              <div class="">
                <div class=" " style=" overflow-wrap: break-word;">
                  <div class="bbc_55 x_9nv" style="">   
                    <span style="">
                      '.$row["chat_message"].'
                    </span>   
                  </div>
                </div>
              </div>  
            </div>
            <?php include("format_date.php"); ?>
            <div id="chat_id_'.$chat_id.'" class="modal this_modal" style="width: 100%; max-width: 180px; max-height: 50px; background-color: white; color: black;  "  role="dialog">
                <div class="modal-content mi_modal-content" id="chat_content_'.$chat_id.'">
                    <span style="padding: 4px; border: 1px solid red;">DELETE</span>
                </div>
            </div>
            ';
        } 
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
*/
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
  $output = '';
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