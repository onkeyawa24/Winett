<?php

include('database_connections.php');
include('session.php');
$sql14 = mysqli_query($conn,"SELECT * from notifications WHERE to_user_id = '".$_SESSION['user_session']."' and status = 1 ") or die(mysqli_error());
	while($row14 = mysqli_fetch_array($sql14))
	{
		$query14 = "
		UPDATE notifications 
		SET status = 1 WHERE notification_id = ".$row14['notification_id'].;
		$statement14 = $connect->prepare($query14);
		$statement14->execute();
	}
?>