 <?php
	require_once("session.php");
	require_once("class.user.php");
	include_once("conn.php");
	$auth_user = new USER();      //Object of class user
	$session_id = $_SESSION['user_session'];      //set user id to current user session.
?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
	<link href="bootstrap/css/bootstrap-theme.min.css" rel="stylesheet" media="screen">
	<script type="text/javascript" src="jquery-1.11.3-jquery.min.js"></script>
	<link rel="stylesheet" href="style.css" type="text/css"  />

	<style type="text/css">
		 body{
		 	background-color: #25383c;;
		 }
		 html{
		 	background-color: #25383c;
		 	color: black;
		 }
		/*.mi{
                padding: 3px;
                margin-right: 50px;
            }*/
        .myDrops{
            margin-left: 95%;
            text-align: right;
            margin-right: 1px;
        }
        .pagecontrol{
        	background-color: white;
            padding: 6px;
            width: 100%;
            border-radius: 6px;
            margin-bottom: 3px;
        }
        /*.container-fluid{
        	background-color: #d1d0ce;
        }*/
	</style>
</head>
<body>
	    <?php	
	    if(isset($_GET['my_id']))
		{
			$profile_for_id=$_GET['my_id'];
		}
		else
		{
			header("Location: posts.php");
		}
		$people = array();
            $sort_pinned_id[]=array(); $sorted_posts=array(); $sort_pinned_id=NULL; $sorted_posts=NULL; echo $sorted_posts{NULL};
		/*Get user details for this profile */
		$query2=mysqli_query($conn,"SELECT * from users WHERE user_id='$profile_for_id'");
		$user=mysqli_fetch_assoc($query2);
		/* Select posts for this user */
	    $query=mysqli_query($conn,"SELECT * from post_table WHERE poster_id ='$profile_for_id' ORDER BY post_id DESC");
        while($row=mysqli_fetch_array($query))
        {   
            $id=$row['post_id'];     
			$userId=$profile_for_id; $j='k';$p='p';$share_this=$row['post_content'];
                $share =$row['post_id'].$p;$d =$row['post_id'].$j;
			$query3=mysqli_query($conn,"SELECT * from reactions WHERE post_id='$id'");
			/*Check to see whether anyone has reacted on this.*/
			while($irow=mysqli_fetch_array($query3))
			{ 
			    $query4=mysqli_query($conn,"SELECT * from users WHERE user_id='".$irow['poster_id']."'");
			    $raw=mysqli_fetch_assoc($query4); /*Get users who reacted on post*/
			    $my_profile=$raw['user_id'];/* User id that liked this post*/
			    $people[]="<a href='my_home.php?my_id=".$my_profile."'>".$raw['user_firstname']." ".$raw['user_lastname']."</a>";/*PUT LIKERS IN AN ARRAY*/
			}  
			        /* CHECK IF ANY COMMENT EXISTS FOR THIS POST*/
			$comment_query=mysqli_query($conn,"SELECT * from comment where post_id='$id'")or die(mysqli_error());
			$count=mysqli_num_rows($comment_query);/*NUMBER OF COMMENTS*/
			?>
			    <!--Start of the post section-->
			    <div class="pagecontrol">
			        <div class="posts" style="height:auto;">
			            <a href="my_home.php?my_id=<?php echo $userId;?>">
			                <img id="image" class="image1" src="./upload/<?php echo $userId;?>.jpg" alt="PICTURE" width="30" height="30" style="border-radius:100%;"><?php echo $user["user_firstname"].' '.$user["user_lastname"];?>
			            </a>
			            <div class="dropdown myDrops">
			                <a href="#<?php echo $id;?>" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
			                <span class="caret"></span></a>
			                <ul class="dropdown-menu mi" id="<?php echo $id;?>">
			                    <li><a href="edited.php?edit=<?php echo $id;?>">Edit</a></li>
			                    <li><a href="delete_post.php?id=<?php echo $id;?>">Delete</a></li>
			                    <li><a href="report_post.php?id=<?php echo $id;?>">Report</a></li>
			                </ul>
			            </div>
			        </div>       
			        <p style="font-size: 140%; color: black; padding-left:10px;padding-right:10px;"><?php echo $row['post_content']; ?>
			        	
			        </p><hr>

			        <div>
			            <?php                 
			            $this_user = mysqli_query($conn,"SELECT * from users where user_id='".$session_id."'");
			            $my_name=mysqli_fetch_array($this_user);
			            $names="<a href='my_home.php?my_id=".$session_id."'>".$my_name['user_firstname']." ".$my_name['user_lastname']."</a>";
			            $query1=mysqli_query($conn,"SELECT * from reactions where post_id='".$row['post_id']."' and poster_id='".$_SESSION['user_session']."'");
			            if (mysqli_num_rows($query1)>0)
			            {
			                ?>    
			                    <!--p data-toggle="collapse" data-target="#post<?php/* echo*/ $id;?>" style=" padding-left: 2%;padding-right: 2%; width: 95%; background-color: khaki;">
			                        <marquee><i class="glyphicon  glyphicon-heart" style="padding-right: 10%; padding-left: 1%;color: gray;"></i><i class="glyphicon  glyphicon-share" style="padding-right: 10%; padding-left: 1%;color: gray;"></i><i class="glyphicon  glyphicon-comment" style="padding-right: 10%; padding-left: 1%;color: gray;"></i>
			                        </marquee>
			                    </p--> 
			                    
			                    <div class="like_section" >
			                        
			                            <button value="<?php echo $row['post_id']; ?>" class="unlike" style="background-color: transparent; border-color: transparent;margin-right:8%">
			                            <i id="myId<?php echo $row['post_id']; ?>" class="glyphicon  glyphicon-heart" style="color: #000099;"></i>
			                            </button>

			                            <button value="<?php echo $row['post_id']; ?>" class="comment" style="background-color: transparent; border-color: transparent;margin-right:8%">
			                                <i class="glyphicon  glyphicon-comment" style="color:gray;"></i>
			                            </button>
			                            
			                            <button value="<?php echo $row['post_id']; ?>" class="seen" style="background-color: transparent; border-color: transparent;margin-right:8%">
			                                <i class="glyphicon  glyphicon-eye-open" style="color:gray;"></i>
			                            </button>
			                        
			                            <i value="<?php echo $row['post_id']; ?>" class="share" style="background-color: transparent; border-color: transparent;margin-right:8%">
			                                <i class="glyphicon  glyphicon-share-alt" style="color:gray;"></i><a href="<?php echo $share;?>" data-toggle="modal" data-target="#<?php echo $share;?>" style="margin-left:5px;">SHARE
			                                </a>
			                            </i>
			                        
			                    </div>        
			                    <div>
			                        <i style="margin-right:8%;"><?php   $query3=mysqli_query($conn,"SELECT * from reactions where post_id='".$row['post_id']."'");
			                            if(mysqli_num_rows($query3) > 0){?>
			                                <a href="#<?php echo $d; ?>" data-toggle="modal" style="margin-left:5px;">
			                            <?php echo mysqli_num_rows($query3);?></a><?php
			                    
			                            }else{
			                            echo "";
			                            }?>
			                        </i>  
			                    <a href="#<?php echo $id; ?>" data-toggle="modal" data-target="#<?php echo $id;?>" style="margin-left:3%;"><i class="icon-comments-alt"></i>&nbsp;<?php if($count>0){echo $count;}else{echo "";} ?></a> 
			                    </div>  
			                
			                <?php
			            }
			            else
			            {
			                ?>
			                
			                    <div class="like_section">
			                        
			                            <button value="<?php echo $row['post_id']; ?>" class="like" style="background-color: transparent; border-color: transparent;margin-right:8%">
			                                <i class="glyphicon  glyphicon-heart" style="color: gray;"></i>
			                            </button>
			                           
			                            <button value="<?php echo $row['post_id']; ?>" class="comment" style="background-color: transparent; border-color: transparent;margin-right:8%">
			                                <i class="glyphicon  glyphicon-comment" style="color:gray;"></i>
			                            </button>
			                          
			                            <button value="<?php echo $row['post_id']; ?>" class="seen" style="background-color: transparent; border-color: transparent;margin-right:8%">
			                                <i class="glyphicon  glyphicon-eye-open" style="color:gray; margin-right: 8%;"></i>
			                            </button>
			                            <i value="<?php echo $row['post_id']; ?>" class="share" style="background-color: transparent; border-color: transparent;margin-right:8%">
			                                <i class="glyphicon  glyphicon-share-alt" style="color:gray;"></i>
			                                <a href="<?php echo $share;?>" data-toggle="modal" data-target="#<?php echo $share;?>" style="margin-left:5px;">SHARE</a>
			                            </i>          
			                    </div>
			                    <div class="like_">
			                            <i style=" margin-right: 8%;"><?php $query3=mysqli_query($conn,"SELECT * from reactions where post_id='".$row['post_id']."'");
			                                if(mysqli_num_rows($query3) > 0)
			                                {
			                                    ?><a href="#<?php echo $d; ?>" data-toggle="modal" style="margin-left:5px;">
			                                    <?php echo mysqli_num_rows($query3);?></a>
			                                    <?php
			                                }
			                                else
			                                {
			                                    echo "";
			                                }?>
			                            </i>
			                            <a href="#<?php echo $id; ?>" data-toggle="modal" data-target="#<?php echo $id;?>" style="margin-left:3%;"><i class="icon-comments-alt"></i>&nbsp;<?php if($count>0){echo $count;}else{echo "";} ?></a>
			                            
			                        
			                    </div>
			                
			                <?php
			            }
			            ?>
			            <div class="modal" id="<?php echo $id;?>" style="">
			                <div class="modal-dialog" style="">
			                    <div class="modal-content ">
			                        <div class="modal-header"></div>
			                        <div class="modal-body myModals">
			                            <form method="POST">
			                                <input type="hidden" name="id" value="<?php echo $id; ?>">
			                                <textarea rows="3" name="comment_content" class="span6" placeholder="Your Comment Here"></textarea>
			                                <br>
			                                <button name="comment" type="submit" class="btn btn-info" style="margin-top: 5px;"><i class="icon-share"></i>&nbsp;Comment</button>
			                            </form><br><br>
			                            <div class="panel-group" id="accordion">
			                                <div class="panel">
			                                    <div class="panel-heading">
			                                        <h3 class="panel-title">
			                                            <a href="#collapse<?php echo $id;?>" data-toggle="collapse" data-parent="accordion"><span class="texts"> Here to read comments <i class="glyphicon  glyphicon-arrow-down" style="color:gray;"></i></span></a>
			                                        </h3>
			                                    </div>
			                                    <div id="collapse<?php echo $id;?>" class="panel-collapse collapse">
			                                        <div class="panel-body myMenu">
			                                            <div class="comment"> 
			                                                <?php $comment=mysqli_query($conn,"SELECT * from comment where post_id='$id' ORDER BY comment_id DESC")or die(mysqli_error());
			                                                while($comment_row=mysqli_fetch_array($comment))
			                                                { 
			                                                    ?><?php
			                                                    $uid = $comment_row['commenter_id'];
			                                                    $date_commented=$comment_row['date_commented'];
			                                                    $commenter=mysqli_query($conn,"SELECT * from users where user_id='$uid'")or die(mysqli_error());
			                                                    $usr=mysqli_fetch_array($commenter);
			                                                    $her="<a href='my_profile.php?my_id=".$uid."'>".$usr['user_firstname']." ".$usr['user_lastname']."</a>";

			                                                    ?>
			                                                    <div class="commenti">
			                                                    	<p style="font-size:120%;  color: black"><img class="image1" src="./upload/<?php echo $uid;?>.jpg" alt="X" width="30" height="30"><?php echo $her.' <b class="actual">'.$comment_row["comment_content"].'</b>'; ?>
			                                                    	</p>
			                                                        <br><i class="glyphicon  glyphicon-heart" style="margin-right:30px;color:gray;"></i><i style="margin-right:30px;color:gray;">Reply</i>  <small><i style="color:brown;text-align: right;margin-left: 50%;margin-right: 1%;"><?php echo $date_commented;?></i></small>
			                                                    </div>
			                                                    <?php 
			                                                } 
			                                                ?>
			                                            </div>
			                                        </div>
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
			                        <div class="modal-body myModals">
			                            <form method="POST">
			                                <input type="hidden" name="id" value="<?php echo $id; ?>">
			                                <textarea rows="3" name="post_content" class="span6" placeholder="Say something about this."></textarea><br>
			                                <p class="sharing"><img class="image1" src="./upload/<?php echo $his;?>.jpg" alt="X" width="30" height="30"><?php echo $him.'<br><br>'.$share_this; ?>
			                            	</p><br>
			                                <button name="share" type="submit" class="btn btn-info" style="margin-top: 5px;"><i class="icon-share"></i>&nbsp;Share</button>
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
			                                echo $people[$a]."<br>";                    
			                            }?>
			                        </div>
			                    </div>
			                </div>
			            </div>
			            <span id="show_like<?php echo $row['post_id']; ?>" style="padding-left:2%">
			                <?php
			                                
			                                 ?><?php
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
			                                    
			                                    }   if($count == 1){
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
			                <small><i style="color: brown; padding-left: 2%;"><?php echo date('d-M-Y h:i A',strtotime($row['date_posted'])); ?></i>
			                </small>
			            </span>
			        </div>
			    </div><?php
			}?>
	
	<script src="bootstrap/js/bootstrap.min.js"></script>
</body>
</html>