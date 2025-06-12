<?php 
    $sql_sort = "SELECT * FROM users WHERE user_id = :this_user LIMIT 1";
    $stmt_sort = $connect->prepare($sql_sort);
    $stmt_sort->execute([':this_user' => $this_user]);
    $userRow_sort = $stmt_sort->fetch(PDO::FETCH_ASSOC);
    $display_name = $userRow_sort['user_firstname'] . " " . $userRow_sort['user_lastname'];

    // Initialize $prev_chat
    $prev_chat = '';

    // Fetch last chat message between users
    $chat_query = "SELECT chat_message_id FROM chat_message 
        WHERE (from_user_id = :id AND to_user_id = :this_user) 
        OR (from_user_id = :this_user AND to_user_id = :id) 
        ORDER BY chat_message_id DESC LIMIT 1";
    $chat_stmt = $connect->prepare($chat_query);
    $chat_stmt->execute([':id' => $id, ':this_user' => $this_user]);
    $chatRow = $chat_stmt->fetch(PDO::FETCH_ASSOC);

    if ($chatRow) {
        $last_chat_id = $chatRow['chat_message_id'];

        $msg_query = "SELECT chat_message, contains FROM chat_message WHERE chat_message_id = :chat_id LIMIT 1";
        $msg_stmt = $connect->prepare($msg_query);
        $msg_stmt->execute([':chat_id' => $last_chat_id]);
        $msg_row = $msg_stmt->fetch(PDO::FETCH_ASSOC);

        if ($msg_row) {
            if ($msg_row['contains'] === 'img') {
                $prev_chat = '<i class="glyphicon glyphicon-picture"></i> ' . htmlspecialchars($msg_row['chat_message']);
            } else {
                $prev_chat = htmlspecialchars($msg_row['chat_message']);
            }
        }
    }

    $staturs = "<span style='color: red;'><small> Offline </small></span>";
    if (is_online($this_user, $connect)) {
        $staturs = "<span style='color: green;'><small> Online </small></span>";
    }

    $output .= '
      <div style="background-color: white; padding: 0px; margin: 2px; border-radius: 5px;">
        <button id="btn_' . $this_user . '" style="padding-bottom: 5px; padding-top: 5px; padding-right: 10px; padding-left: 8px; color: black; width:100%; text-align:left; border:none; background-color: transparent;" type="button" class="start_chat" data-touserid="' . $this_user . '" data-tousername="' . htmlspecialchars($userRow_sort['username']) . '" data-todisplayname="' . htmlspecialchars($display_name) . '" data-fromuserid="' . $id . '">
          <img id="img_' . $this_user . '" src="./upload/' . $this_user . '.jpg" alt="' . htmlspecialchars($userRow_sort['user_firstname']) . '" width="55" height="55" style="border: 1px solid #f3f1f0; border-radius:100%; margin-right: 10px;">
          <b class="user_nm" id="txt_' . $this_user . '"> ' . $display_name . '</b>
          ' . count_unseen_message($this_user, $_SESSION['user_id'], $connect) . '
          <i class="live_chat_msg" style="color: #fa00fa;"> ' . fetch_live_chat_message($this_user, $connect) . ' </i>
          <br>
          <div class="chat" id="chat_' . $this_user . '">' . $prev_chat . '</div>
        </button>
      </div>
    ';
?>
