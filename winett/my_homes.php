  
    <?php
        include ('conn.php');
        include('session.php');
     
        if (isset($_POST['pin'])){     
     
            $id = $_POST['id'];
            $query=mysqli_query($conn,"SELECT * from pinned_user where pinned_id='$id' and pinner_id='".$_SESSION['user_session']."'") or die(mysqli_error());
     
            if(mysqli_num_rows($query)>0){
                mysqli_query($conn,"DELETE from pinned_user where pinner_id='".$_SESSION['user_session']."' and pinned_id='$id'");
            }
            else{
                mysqli_query($conn,"INSERT into pinned_user (pinner_id,pinned_id) values ('".$_SESSION['user_session']."', '$id')");
            }
        }       
    ?>