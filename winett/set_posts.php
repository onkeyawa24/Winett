<style>
    .this_modal {
        padding: 0px; max-width: 500px; max-height: 550px;
        left: 0;  top: 0; width: 100%; height: 100%;  overflow: hidden; /* Enable scroll if needed */
        background-color: rgb(0,0,0); background-color: rgba(0,0,0,0.9); /* Black w/ opacity */
    }
    .mi.modal-content {
        padding: 0px; margin: 0px; background-color: transparent;  overflow: hidden;
    }
     
    .mi_modal-content, .mi_caption {
        -webkit-animation-name: zoom;
        -webkit-animation-duration: 0.10s;
        animation-name: zoom;
        animation-duration: 0.10s;
    }
    .mi_modal-content > .post_image{width: 100%; max-width: 500px; height: 100%; max-height: 550px; padding: 0px; margin: 0px;  overflow: hidden;}
    .closed {
        background-color: red; position: absolute; top: 40px;
        text-align: center; width: 50px; height:50px; right: 40px; color: white;
        font-size: 40px; font-weight: bold; transition: 0.6s;
    }
    .closed:hover,
    .closed:focus {
        background: white; color: red; text-decoration: none; cursor: pointer;
    }
</style>

<?php
if(isset($_POST['edite'])){
    $edited=strip_tags($_POST['txt_edits']);
    $stmty = $auth_user->runQuery("UPDATE post_table SET post_content='$edited' WHERE post_id=:id");
    $stmty->execute(array(":id"=>$id));
    $auth_user->redirect('Posts.php');
}
/* Query language to get the person posted this post*/
$query2=mysqli_query($conn,"SELECT * from users WHERE user_id='$poster'");
$user=mysqli_fetch_assoc($query2);
$userId=$user['user_id'];
$query3=mysqli_query($conn,"SELECT * from reactions WHERE post_id='$id'");
/*Check to see whether anyone has reacted on this.*/
/*while($irow=mysqli_fetch_array($query3))
{ 
    $query4=mysqli_query($conn,"SELECT * from users WHERE user_id='".$irow['poster_id']."'");
    $raw=mysqli_fetch_assoc($query4); /*Get users who reacted on post*/
    /*$my_profile=$raw['user_id'];/* User id that liked this post*/
    /*$people[]="<a href='my_home.php?my_id=".$my_profile."'>".$raw['user_firstname']." ".$raw['user_lastname']."</a>";/*PUT LIKERS IN AN ARRAY
} */ 
        /* CHECK IF ANY COMMENT EXISTS FOR THIS POST*/
$comment_query=mysqli_query($conn,"SELECT * from comment where post_id='$id'")or die(mysqli_error());
$count=mysqli_num_rows($comment_query);/*NUMBER OF COMMENTS*/
$the_poster = $user["user_firstname"].' '.$user["user_lastname"];
?>
    <!--Start of the post section-->
    <div class="pagecontrol" id="<?php echo $id;?>">
        <div class="posts" style="height:auto;">
            <a href="my_home.php?my_id=<?php echo $userId;?>">
                <img id="image" class="image1" src="./upload/<?php echo $userId;?>.jpg" alt="X" width="40" height="40" style="border-radius:100%;"><?php echo $the_poster ;?>
            </a>
            <div class="dropdown myDrops">
                <a href="#<?php echo $id.'drp';?>" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                <span class="caret"></span></a>
                <?php
                if($poster == $hey)
                {
                    $drp = 'drp';
                    echo '
                    <ul class="dropdown-menu dropdown-menu-right" id="'.$id.''.$drp.'" style="border: 2px solid white; max-width: 80px;">
                        <li style="padding-bottom: 10px; "><span data-toggle="modal" data-target="#edit" style="color: black; padding-left: 20px;">Edit</span></li>
                        <li  style="padding-bottom: 5px; background-color: silver;"><a href="report_post.php?id='.$id.'">Report</a></li>
                        <li><a href="delete_post.php?id='.$id.'">Delete</a></li>
                    </ul>
                    ';
                }
                else
                {
                    $drp = 'drp';
                    echo '
                    <ul class="dropdown-menu dropdown-menu-right" id="'.$id.''.$drp.'" style="border: 2px solid white; max-width: 80px;">
                        <li  style="padding-bottom: 5px;"><a href="report_post.php?id='.$id.'">Report</a></li>
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
                <?php include('implement_taggs.php');?><br><?php include('formatted_date.php');?>
            <!--******************************************-->

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
                    <button value="<?php echo $row['post_id']; ?>" class="unlike" style="background-color: transparent; border-color: transparent;">
                    <i onclick="myToggleFunction(this)" id="myId<?php echo $row['post_id']; ?>" class="fa fa-heart" style="color: #21BE06; font-size: 14px"></i>
                    </button>
                    <i style="margin-right:8%;"><?php   $query3=mysqli_query($conn,"SELECT * from reactions where post_id='".$row['post_id']."'");
                        if(mysqli_num_rows($query3) > 0){?>
                            <a href="#<?php echo $d; ?>" data-toggle="modal" style="">
                            <?php echo mysqli_num_rows($query3);?></a><?php
                        }
                        else{
                            echo " ";
                        }?>
                    </i>  
                    <button value="<?php echo $row['post_id']; ?>" class="share" style="background-color: transparent; border-color: transparent;margin-right:8%; padding: 1px;">
                        <a href="<?php echo $share;?>" data-toggle="modal" data-target="#<?php echo $share;?>" style="margin-left: 5px; color: #A7342F; font-size: 15px;"><i class="glyphicon  glyphicon-repeat" style="color:#A7342F; font-size: 12px"></i>
                        </a>
                    </button>
                    <button value="<?php echo $row['post_id']; ?>" class="comment" style="background-color: transparent; border-color: transparent; margin-left: 10px;">
                        <i class="fa fa-comment-o" style="color:#A7342F; font-size: 14px"></i>
                    </button>
                    <a href="#<?php echo $id.'cmt'; ?>" data-toggle="modal" data-target="#<?php echo $id.'cmt';?>" style="margin-right:8%;"><i class="icon-comments-alt"></i>&nbsp;<?php if($count>0){echo $count;}else{echo " ";} ?></a>
                    <i value="<?php echo $row['post_id']; ?>" class="seen" style="background-color: transparent; border-color: transparent;margin-right:8%">
                        <i class="fa fa-microphone" style="color:#A7342F; font-size: 14px"></i>
                    </i>
                </div>        
                   
                <?php
            }
            else
            {?>
                <div class="like_section">
                    <button value="<?php echo $row['post_id']; ?>" class="like" style="background-color: transparent; border-color: transparent;">
                        <i onclick="myTogleFunction(this)" class="fa fa-heart-o" style="color: #A7342F; font-size: 14px"></i>
                    </button>
                    <i style="margin-right: 8%;"><?php $query3=mysqli_query($conn,"SELECT * from reactions where post_id='".$row['post_id']."'");
                        if(mysqli_num_rows($query3) > 0)
                        {?> 
                            <a href="#<?php echo $d; ?>" data-toggle="modal">
                            <?php echo mysqli_num_rows($query3);?></a><?php
                        }
                        else
                        {
                            echo " ";
                        }?>
                    </i>
                    <button value="<?php echo $row['post_id']; ?>" class="share" style="background-color: transparent; border-color: transparent;margin-right:8%; ">
                        <a href="<?php echo $share;?>" data-toggle="modal" data-target="#<?php echo $share;?>" style="margin-right: 8%; margin-left: 5px; color: #A7342F;"><i class="glyphicon  glyphicon-repeat" style="color:#A7342F; font-size: 12px"></i></a>
                    </button>
                    <button value="<?php echo $row['post_id']; ?>" class="comment" style="background-color: transparent; border-color: transparent; margin-left: 10px;">
                        <i class="fa fa-comment-o" style="color:#A7342F; font-size: 14px"></i>
                    </button>
                    <a href="#<?php echo $id.'cmt'; ?>" data-toggle="modal" data-target="#<?php echo $id.'cmt' ;?>" style=" margin-right:8%;"><i class="icon-comments-alt"></i>&nbsp;<?php if($count>0){echo $count;}else{echo " ";} ?></a>
                    <i value="<?php echo $row['post_id']; ?>" class="seen" style="background-color: transparent; border-color: transparent;margin-right:8%; margin-left: 8px;">
                        <i class="fa fa-microphone" style="color:#A7342F; font-size: 14px"></i>
                    </i>          
                </div>
                 
                <?php
            }
            ?>
            <div class="modal for_comments" id="<?php echo $id.'cmt' ;?>" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content ">
                        <div class="modal-header"><center><strong>Read comments and leave yours.</strong></center></div>
                        <div class="modal-body myModals">
                            <form method="POST">
                                <input type="hidden" name="id" value="<?php echo $id; ?>">
                                <textarea rows="2" cols="65" name="comment_content" placeholder="Your Comment Here" style="background-color: white; color: black; padding: 6px;"></textarea>
                                <br>
                                <button id="<?php echo $id.'_';?>" name="comment" type="button" class="btn btn-info comm" style="margin-top: 5px;"><i class="icon-share"></i>&nbsp;Comment</button>
                            </form><br><br>
                            <div class="panel-group" id="accordion">
                                <div class="panel">
                                    <div class="panel-heading">
                                        <!--h3 class="panel-title">
                                            <a href="#collapse<?php/* echo $id;*/?>" data-toggle="collapse" data-parent="accordion"><span class="texts">I came for comments </span></a>
                                        </h3>
                                    </div-->
                                    <!--div id="collapse<?php echo $id;?>" class="panel-collapse collapse"-->
                                        <div class="panel-body myMenu">
                                            <div id="comment_<?php echo $id; ?>" class="comment"></div>
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
                                <input type="hidden" name="id" value="<?php echo $id; ?>">
                                <div class="share_text_field">
                                    <?php
                                        if($row['contains'] == 'txt')
                                        {
                                            echo '
                                                
                                                <p class="prev_sharing"><a href="'.$id.'"><img class="image1" src="./upload/'.$his.'.jpg" alt="'.$the_poster.'" width="30" height="30">'.$him.'</a><br>'.$share_this.'</p>
                                                <textarea name="post_content" placeholder="Caption this.." class="txt_share"></textarea>
                                                <input type="submit" name="share" value="Share" class="btn_share" /> 
                                            ';
                                        }
                                        elseif($row['contains'] == 'vid')
                                        {
                                            echo '
                                                <div class="prev_sharing"><a href="'.$id.'"><img class="image1" src="./upload/'.$his.'.jpg" alt="'.$the_poster.'" width="30" height="30">'.$him.'</a><br>'.'<center><video id="vid_'.$id.'" '.$share_this.'<br></div>
                                                <textarea name="post_content" placeholder="Caption this.." class="txt_share"></textarea>
                                                <input type="submit" name="share" value="Share" class="btn_share" />
                                            ';
                                        }
                                        elseif($row['contains'] == 'img')
                                        {
                                            echo '
                                                <div class="prev_sharing"><a href="'.$id.'"><img class="image1" src="./upload/'.$his.'.jpg" alt="'.$the_poster.'" width="30" height="30">'.$him.'</a><br><img style="max-width: 220px; max-height: 220px; width: 100%; height: 100%;" id="img_'.$id.'" '.$share_this.'</div>
                                                <textarea name="post_content" placeholder="Caption this.." class="txt_share"></textarea>
                                                <input type="submit" name="share" value="Share" class="btn_share" />
                                            ';
                                        }
                                        else
                                        {
                                            echo "Sorry there was error trying to get this post. Try again.";
                                        }
                                    ?>
                                    
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal my" id="<?php echo $d;?>" style="">
                <div class="modal-dialog" style="">
                    <div class="modal-content ">
                        <div class="modal-body myModal">
                            <p style="font-size: 140%; color: black;">The following liked your post: </p>
                            <?php
                            for($a = 0; $a < count($people);$a++)
                            {
                                echo $people[$a];                    
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
                ?>
            </span>
        </div>
    </div>
    <?php 
    if (isset($row['contains']) && $row['contains'] == 'img') {
        $posted_content = $row['post_content'];
        $modal_id = "'modal_".$id."'"; 
        $display_none = "'none'";
        echo '
            <div id="modal_'.$id.'" class="modal this_modal" style="width: 100%; max-width: 500px; max-height: 550px; background-color: transparent;  overflow: hidden;"  role="dialog">
                <div class="modal-content mi_modal-content" id="content_'.$id.'">
                    '.$posted_content = '<img id="'.$img_id.'" '.$posted_content.'
                </div>
            </div>
        ';
    }
    
    ?>
    
    <!--Post section ends here-->
 
