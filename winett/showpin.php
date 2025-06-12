 

    <?php
    	include_once('session.php');
    	include_once('conn.php');
     	include_once('session.php');
    	if (isset($_POST['showpin'])){
    		$id = $_POST['id'];
            echo $id;
    		$query2=mysqli_query($conn,"SELECT * from pinned_user where pinned_id='$id'");
    		echo mysqli_num_rows($query2);	
    	}
    ?>