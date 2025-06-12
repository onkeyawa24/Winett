<?php 
include_once('conn.php'); include_once('session.php'); include_once ('database_connections.php');
//Check connection
if (MySQLi_connect_errno())  
{
   echo "Failed to connect to the server: " . MySQLi_connect_error();
}
//Getting value of "search" variable from "script.js".
if (isset($_POST['name']) && isset($_POST['to_user'])) 
{
    //Search box value assigning to $Name variable.
    $Name = $_POST['name']; $to_user_id = $_POST['to_user'];

    $sql = mysqli_query($conn,"
	SELECT * FROM live_chat WHERE from_user_id = '".$_SESSION['user_id']."' AND to_user_id = $to_user_id ");
	if (mysqli_num_rows($sql) > 0)
	{
		if($sqla = mysqli_query($conn, "UPDATE live_chat SET chat_message = '$Name' WHERE from_user_id = '".$_SESSION['user_id']."' AND to_user_id = $to_user_id") or die(mysqli_error()))
		{
			$sql1 = mysqli_query($conn," SELECT * FROM live_chat WHERE from_user_id = '".$_SESSION['user_id']."' AND to_user_id = $to_user_id "); $rowx = mysqli_fetch_array($sql1); $Name = $rowx['chat_message']; echo $Name." "."Updated!";
		}
	}
	else
	{
	    $data = array(
		 ':to_user_id'  => $_POST['to_user'],
		 ':from_user_id'  => $_SESSION['user_id'],
		 ':chat_message'  => $Name
		);

		$query = "INSERT INTO live_chat (to_user_id, from_user_id, chat_message) VALUES (:to_user_id, :from_user_id, :chat_message)";
		$statement = $connect->prepare($query);

		if($statement->execute($data)){echo $Name." "."First charecter.";}
	}
}             
else{ echo "Nothing to show"; }
?>
 
 