 

    <?php
    	include_once('session.php');
    	include_once('conn.php');
     	include_once('session.php');
    	if (isset($_POST['showlike'])){
    		$id = $_POST['id'];
    		$query2=mysqli_query($conn,"SELECT * from reactions where post_id='$id'");
    		echo mysqli_num_rows($query2);
            $likes = mysqli_num_rows($query2);
            $querypo=mysqli_query($conn,"SELECT * from post_table where post_id='$id'");  
            $roow=mysqli_fetch_array($querypo);
            $thisuser=$roow['poster_id'];


            mysqli_query($conn,"UPDATE post_table SET likes = '$likes' WHERE poster_id = '$thisuser' AND post_id = '$id'");
    	}
    ?>