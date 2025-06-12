<?php
if(isset($_POST['edite'])){
    $edited=strip_tags($_POST['txt_edits']);
    $stmty = $auth_user->runQuery("UPDATE post_table SET post_content='$edited' WHERE post_id=:id");
    $stmty->execute(array(":id"=>$tagged_id));
    $auth_user->redirect('Posts.php');
}
$hey = $_SESSION['user_session'];
/* Query language to get the person posted this post*/
$query2=mysqli_query($conn,"SELECT * from users WHERE user_id='$poster' limit 1" );
$user=mysqli_fetch_assoc($query2);
$userId=$poster;
$query3=mysqli_query($conn,"SELECT * from reactions WHERE post_id='$tagged_id'");
/*Check to see whether anyone has reacted on this.*/
while($irow=mysqli_fetch_array($query3))
{ 
    $query4=mysqli_query($conn,"SELECT * from users WHERE user_id='".$irow['poster_id']."'");
    $raw=mysqli_fetch_assoc($query4); /*Get users who reacted on post*/
    $my_profile=$raw['user_id'];/* User id that liked this post*/
    $people[]="<a href='my_home.php?my_id=".$my_profile."'>".$raw['user_firstname']." ".$raw['user_lastname']."</a>";/*PUT LIKERS IN AN ARRAY*/
}  
        /* CHECK IF ANY COMMENT EXISTS FOR THIS POST*/

$comment_query=mysqli_query($conn,"SELECT * from comment where post_id='$tagged_id'")or die(mysqli_error());
$count=mysqli_num_rows($comment_query);/*NUMBER OF COMMENTS*/
?>
    <!--Start of the post section-->
    <div class="pagecontrol" id="<?php echo $tagged_id;?>">
        <div class="posts" style="height:auto;">
            <a href="my_home.php?my_id=<?php echo $userId;?>">
                <img id="image" class="image1" src="./upload/<?php echo $userId;?>.jpg" alt="X" width="30" height="30" style="border-radius:100%;"><?php echo $user["user_firstname"].' '.$user["user_lastname"];?>
            </a>
            <div class="dropdown myDrops">
                <a href="#<?php echo $tagged_id.'drp';?>" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                <span class="caret"></span></a>
                <?php
                if($poster == $hey)
                {
                    $drp = 'drp';
                    echo '
                    <ul class="dropdown-menu dropdown-menu-right" id="'.$tagged_id.''.$drp.'" style="border: 2px solid white; max-width: 80px;">
                        <li style="padding-bottom: 10px; "><span data-toggle="modal" data-target="#edit" style="color: black; padding-left: 20px;">Edit</span></li>
                        <li  style="padding-bottom: 5px; background-color: silver;"><a href="report_post.php?id='.$tagged_id.'">Report</a></li>
                        <li><a href="delete_post.php?id='.$tagged_id.'">Delete</a></li>
                    </ul>
                    ';
                }
                else
                {
                    $drp = 'drp';
                    echo '
                    <ul class="dropdown-menu dropdown-menu-right" id="'.$tagged_id.''.$drp.'" style="border: 2px solid white; max-width: 80px;">
                        <li  style="padding-bottom: 5px;"><a href="report_post.php?id='.$tagged_id.'">Report</a></li>
                    </ul>
                    ';
                }
                ?>
                
                <div id="edit" class="modal" role="dialog">
                  <div class="modal-dialog">
                    <div class="modal-content ">
                      <div class="modal-header">Edit this post.
                      </div>
                      <div class="modal-body myModals">
                        <form method="post" action="">
                          <textarea type="text" name="txt_edits" value="<?php echo $share_this; ?>"></textarea>
                          <input type="submit" value="Edit" name="edite" id="edite" class="btn btn-primary"/>
                        </form>     
                      </div>
                    </div>
                  </div> 
                </div>
            </div>
        </div>       
        <div style="font-size: 1em; color: black; padding-left:10px;padding-right:10px;">
            <!--******************************************-->
                <?php include('implement_taggs.php'); ?>
            <!--******************************************-->
             </div><hr>
        <div>
            <?php                 
            $this_user = mysqli_query($conn,"SELECT * from users where user_id='".$hey."'");
            $my_name=mysqli_fetch_array($this_user);
            $names="<a href='my_home.php?my_id=".$hey."'>".$my_name['user_firstname']." ".$my_name['user_lastname']."</a>";
            $query1=mysqli_query($conn,"SELECT * from reactions where post_id='".$row['post_id']."' and poster_id='".$_SESSION['user_session']."'");
            if (mysqli_num_rows($query1)>0)
            {?>
                <div class="like_section" >
                    <button value="<?php echo $row['post_id']; ?>" class="unlike" style="background-color: transparent; border-color: transparent;margin-right:8%">
                    <i id="myId<?php echo $row['post_id']; ?>" class="glyphicon  glyphicon-heart" style="color: #21BE06; width: 2em !important;"></i>
                    </button>

                    <button value="<?php echo $row['post_id']; ?>" class="comment" style="background-color: transparent; border-color: transparent;margin-right:8%">
                        <i class="glyphicon  glyphicon-comment" style="color:#A7342F;"></i>
                    </button>
                    
                    <button value="<?php echo $row['post_id']; ?>" class="seen" style="background-color: transparent; border-color: transparent;margin-right:8%">
                        <i class="glyphicon  glyphicon-repeat" style="color:#A7342F;"></i>
                    </button>
                
                    <i value="<?php echo $row['post_id']; ?>" class="share" style="background-color: transparent; border-color: transparent;margin-right:8%">
                        <i class="glyphicon  glyphicon-share-alt" style="color:#A7342F;"></i><a href="<?php echo $share;?>" data-toggle="modal" data-target="#<?php echo $share;?>" style="margin-left: 5px; color: #A7342F;">SHARE
                        </a>
                    </i>
                </div>        
                <div>
                    <i style="margin-right:8%;"><?php   $query3=mysqli_query($conn,"SELECT * from reactions where post_id='".$row['post_id']."'");
                        if(mysqli_num_rows($query3) > 0){?>
                            <a href="#<?php echo $tagged_id; ?>" data-toggle="modal" style=" margin-left:5px;">
                            <?php echo mysqli_num_rows($query3);?></a><?php
                        }
                        else{
                            echo "";
                        }?>
                    </i>  
                <a href="#<?php echo $tagged_id.'cmt'; ?>" data-toggle="modal" data-target="#<?php echo $tagged_id.'cmt';?>" style="margin-left:8%;"><i class="icon-comments-alt"></i>&nbsp;<?php if($count>0){echo $count;}else{echo "";} ?></a> 
                </div>  
                <?php
            }
            else
            {?>
                <div class="like_section">
                    <button value="<?php echo $row['post_id']; ?>" class="like" style="background-color: transparent; border-color: transparent;margin-right:8%">
                        <i class="glyphicon  glyphicon-heart-empty" style="color: #A7342F;"></i>
                    </button>
                    <button value="<?php echo $row['post_id']; ?>" class="comment" style="background-color: transparent; border-color: transparent;margin-right:8%">
                        <i class="glyphicon  glyphicon-comment" style="color:#A7342F;"></i>
                    </button>
                    <button value="<?php echo $row['post_id']; ?>" class="seen" style="background-color: transparent; border-color: transparent;margin-right:8%">
                        <i class="glyphicon  glyphicon-repeat" style="color:#A7342F; margin-right: 8%;"></i>
                    </button>
                    <i value="<?php echo $row['post_id']; ?>" class="share" style="background-color: transparent; border-color: transparent;margin-right:8%">
                        <i class="glyphicon  glyphicon-share-alt" style="color:#A7342F;"></i>
                        <a href="<?php echo $share;?>" data-toggle="modal" data-target="#<?php echo $share;?>" style="margin-left: 5px; color: #A7342F;">SHARE</a>
                    </i>          
                </div>
                <div class="like_">
                    <i style=" margin-right: 8%;"><?php $query3=mysqli_query($conn,"SELECT * from reactions where post_id='".$row['post_id']."'");
                        if(mysqli_num_rows($query3) > 0)
                        {?> 
                            <a href="#<?php echo $tagged_id; ?>" data-toggle="modal" style="margin-left: 5px;">
                            <?php echo mysqli_num_rows($query3);?></a><?php
                        }
                        else
                        {
                            echo "";
                        }?>
                    </i>
                    <a href="#<?php echo $tagged_id.'cmt'; ?>" data-toggle="modal" data-target="#<?php echo $tagged_id.'cmt' ;?>" style="margin-left:8%;"><i class="icon-comments-alt"></i>&nbsp;<?php if($count>0){echo $count;}else{echo "";} ?></a>
                </div>
                <?php
            }
            ?>
            <div class="modal for_comments" id="<?php echo $tagged_id.'cmt' ;?>" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content ">
                        <div class="modal-header"><center><strong>Read comments and leave yours.</strong></center></div>
                        <div class="modal-body myModals">
                            <form method="POST">
                                <input type="hidden" name="id" value="<?php echo $tagged_id; ?>">
                                <textarea rows="2" cols="65" name="comment_content" placeholder="Your Comment Here" style="background-color: white; color: black; padding: 6px;"></textarea>
                                <br>
                                <button id="<?php echo $tagged_id.'_';?>" name="comment" type="button" class="btn btn-info comm" style="margin-top: 5px;"><i class="icon-share"></i>&nbsp;Comment</button>
                            </form><br><br>
                            <div class="panel-group" id="accordion">
                                <div class="panel">
                                    <div class="panel-heading">
                                        <!--h3 class="panel-title">
                                            <a href="#collapse<?php/* echo $tagged_id;*/?>" data-toggle="collapse" data-parent="accordion"><span class="texts">I came for comments </span></a>
                                        </h3>
                                    </div-->
                                    <!--div id="collapse<?php echo $tagged_id;?>" class="panel-collapse collapse"-->
                                        <div class="panel-body myMenu">
                                            <div id="comment_<?php echo $tagged_id; ?>" class="comment"></div>
                                        </div>
                                    <!--/div-->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div><?php 
            $his=$user['user_id'];
            $him="<a href='my_profile.php?my_id=".$his."'>".$user['user_firstname']." ".$user['user_lastname']."</a>";?>
            <div class="modal" id="<?php echo $share;?>" style="">
                <div class="modal-dialog" style="">
                    <div class="modal-content ">
                        <div class="modal-body modal-share">
                            <form method="POST">
                                <input type="hidden" name="id" value="<?php echo $tagged_id; ?>">
                                <div class="share_text_field">
                                    <p class="prev_sharing"><img class="image1" src="./upload/<?php echo $his;?>.jpg" alt="X" width="30" height="30"><?php echo $him.'<br>'.$share_this; ?>
                                    </p>
                                    <textarea name="post_content" placeholder="Caption this.." class="txt_share"></textarea>
                                    <input type="submit" name="share" value="Share" class="btn_share" />
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal my" id="<?php echo $tagged_id;?>" style="">
                <div class="modal-dialog" style="">
                    <div class="modal-content ">
                        <div class="modal-body myModal">
                            <p style="font-size: 140%; color: black;">The following liked your post: </p>
                            <?php
                            for($a = 0; $a < count($people);$a++)
                            {
                                echo $people[$a]."<br>";                    
                            }?>
                        </div>
                    </div>
                </div>
            </div>
            <span id="show_like<?php echo $row['post_id']; ?>" style="padding-left:2%">
                <?php
                if(count($people)<1){
                    echo "";
                }
                else
                {
                    $count=0;
                    for($a = 0; $a < count($people);$a++){
                        if($people[$a] == $names){
                            $count++;
                        }
                    }
                    if($count == 1){
                        if(count($people)<3){
                            if(count($people)==2){
                                echo '<b>You</b> and <b>'.$people[1].'</b> likes this';
                            }
                            else{
                                echo '<b>You</b> liked this';
                            }
                        }
                        else
                        {
                            $likes=count($people)-1;
                            echo  '<b> You</b> and '.$likes.' others likes this';
                        }
                    }
                    else
                    {
                        if(count($people)<3){
                            if(count($people)==2){
                                echo '<b style="padding-left:2%;">'.$people[0].'</b> and <b>'.$people[1].'</b> likes this';
                            }
                            else{
                                echo '<b style="padding-left:2%;">'.$people[0].'</b> likes this';
                            }
                        }
                        else{
                            $likes=count($people)-1;
                            echo  '<b style="padding-left:2%;">'.$people[0].'</b> and '.$likes.' others likes this';
                        }
                    }
                }
                $people=NULL;
                include('formatted_date.php');?>
            </span>
        </div>
    </div>
    <!--Post section ends here-->
 
