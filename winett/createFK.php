<?php 

	$dbhost = "localhost";
 	$dbname = "nazoke";
 	$dbuser = "root";
 	$dbpass = "";

 	$conn = new mysqli($dbhost, $dbuser, $dbpass, $dbname); 
 	if(!$conn)
 	{
 		die(" Could not connect: " . mysqli_error());
 	}

 	$sql = " ALTER TABLE user_preschool ADD  FOREIGN KEY (preschool_id)  REFERENCES preschools(preschool_id)  ";
 	$retval = $conn -> query($sql);

 	if(!$retval)
 	{

 		die("Could not modify table 1 " );
 		
 	}
 	echo "successfully created 1 ";
 	mysqli_close($conn);
?>
