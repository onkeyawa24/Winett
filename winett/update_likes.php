 

<?php
	include_once('session.php');
	include_once('conn.php');
 	include_once('session.php');
	
    $update_like[] = array();
    $sql=mysqli_query($conn,"SELECT * from post_table");
    while($row1=mysqli_fetch_array($sql)){
        $getid = $row1['post_id'];
        $update_like[] = $getid;
    }
    for ($i=0; $i < count($update_like) ; $i++) { 
		$id = $update_like[$i];
		$query2=mysqli_query($conn,"SELECT * from reactions where post_id='$id'");
		/*mysqli_num_rows($query2);*/
        $likes = mysqli_num_rows($query2);
        $querypo=mysqli_query($conn,"SELECT * from post_table where post_id='$id'");  
        $roow=mysqli_fetch_array($querypo);
        $thisuser=$roow['poster_id'];
        mysqli_query($conn,"UPDATE post_table SET likes = '$likes' WHERE poster_id = '$thisuser' AND post_id = '$id'");
    }
?>