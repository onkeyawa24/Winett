<?php 
    include('database_connections.php');
    include('conn.php');
    if(isset($_POST['id']))
    {
        $id = $_POST['id'];
    }
        $comment=mysqli_query($conn,"SELECT * from comment where post_id='$id' ORDER BY comment_id DESC")or die(mysqli_error());
        //get comments
        while($comment_row=mysqli_fetch_array($comment))
        { 
            $uid = $comment_row['commenter_id'];
            $date_commented=$comment_row['date_commented'];
            $commenter=mysqli_query($conn,"SELECT * from users where user_id='$uid'")or die(mysqli_error());
            $usr=mysqli_fetch_array($commenter);
            $her="<a href='my_profile.php?my_id=".$uid."'>".$usr['user_firstname']." ".$usr['user_lastname']."</a>";?>
            <div class="commenty"><p style="font-size:120%;  color: black"><img class="image1" src="./upload/<?php echo $uid;?>.jpg" alt="X" width="30" height="30"><?php echo $her." <br>"; include("taggs_on_comment.php");?>
                <br><i class="glyphicon  glyphicon-heart" style="margin-right:30px;color:#A7342F;"></i><i style="margin-right:30px;color:#A7342F;">Reply</i>  <small><i style="color:brown;text-align: right;margin-left: 50%;margin-right: 1%;"><?php include('formatted_dates.php');?></i></small>
            </div><?php 
        }
     
    ?>