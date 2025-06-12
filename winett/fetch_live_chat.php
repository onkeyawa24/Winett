<?php

//fetch_user_chat_history.php

include('database_connections.php');

session_start();

echo fetch_live_chat_message($_POST['to_user_id'], $connect);

?>