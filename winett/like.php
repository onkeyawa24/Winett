 

<?php
    include ('conn.php');
    include('session.php');

    if (isset($_POST['like'])){     
        $thisuser = $_SESSION['user_session'];
        $id = $_POST['id'];
        $sql=mysqli_query($conn,"SELECT * from post_table where post_id='$id'") or die(mysqli_error());
        $row = mysqli_fetch_array($sql);
        $poster = $row['poster_id'];
        $query=mysqli_query($conn,"SELECT * from reactions where post_id='$id' and poster_id='".$_SESSION['user_session']."'") or die(mysqli_error());
            $likes = mysqli_num_rows($query);
        //check if you already liked this post. if true, unlike it, else like it.
        if(mysqli_num_rows($query)>0){
            mysqli_query($conn,"DELETE from reactions where poster_id='".$_SESSION['user_session']."' and post_id='$id'");
            mysqli_query($conn,"DELETE from notifications where from_user_id='$thisuser' and post_id='$id' and action='like'");
        }
        else{
            mysqli_query($conn,"INSERT into reactions (poster_id,post_id) values ('".$_SESSION['user_session']."', '$id')");
            //Notify the poster about this action. 
            mysqli_query($conn,"INSERT into notifications (action, post_id, from_user_id, to_user_id, status ) values ('like' , '$id' , '$thisuser' , '$poster' , '1')");
        }
    }       
?>