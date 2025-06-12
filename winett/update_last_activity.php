<?php

//update_last_activity.php

include('database_connections.php');

session_start();

$query = "
UPDATE login_detail 
SET last_activity = date('Y-m-d H-i-s');
WHERE login_details_id = '".$_SESSION["login_details_id"]."'
";

$statement = $connect->prepare($query);

$statement->execute();

?>