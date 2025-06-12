<?php 
require_once('class.user.php');
	$user = new USER();
include('header.php');
?>
<body>
<br><br>
    <div class="container">
	 
    <div class="control-group">

    <div class="controls">
    <textarea rows="3" name="post_content" class="span6" placeholder="Whats on Your Mind"></textarea>
    </div>
    </div>
   
    <div class="control-group">
    <div class="controls">
    <button name="post" type="submit" class="btn btn-info"><i class="icon-share"></i>&nbsp;Post</button>
    </div>
    </div>
	
	<div class="control-group">
	
    <div class="controls">
 
 
    <table class="table table-bordered">

    <thead>
	
    </thead>
    <tbody>
	<?php
	$query=mysqli_query($conn,"SELECT * from post_table")or die(mysqli_error());
	while($row=mysqli_fetch_array($query)){
	$id=$row['post_id'];
	?>
	
	
    <tr>
    <td><?php echo $row['post_content']; ?></td>
    <td width="50">
	<?php 
	$comment_query=mysqli_query($conn,"SELECT * from comment where post_id='$id'")or die(mysqli_error());
	$count=mysqli_num_rows($comment_query);
	?>
	 <a href="#<?php echo $id; ?>" data-toggle="modal" data-target="#<?php echo $id;?>"><i class="icon-comments-alt"></i>&nbsp;<span class="badge badge-info"><?php echo $count; ?></span></a>
	</td>
    <td width="40"><a class="btn btn-danger" href="delete_post.php<?php echo '?id='.$id; ?>"><i class="icon-trash"></i></a></td>
    </tr>
	
	    <!-- Modal -->
    <!--div id="</*?php echo $id; ?>" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header">
    </div>
    <div class="modal-body">
	
	<---comment --
		 <form method="POST">
	
	  
	<input type="hidden" name="id" value="</*?php echo $id; ?>">
    <textarea rows="3" name="comment_content" class="span6" placeholder="Your Comment Here"></textarea>
	<br>
	<br>
    <button name="comment" type="submit" class="btn btn-info"><i class="icon-share"></i>&nbsp;Comment</button>
	</form>

	<br>
	<br>
	
	<?php /*$comment=mysqli_query($conn,"SELECT * from comment where post_id='$id'")or die(mysqli_error());
	while($comment_row=mysqli_fetch_array($comment)){ ?>

	<div class="alert alert-success"><?php echo $comment_row['comment_content']; ?></div>
	
	<?php } */?>
	-- end comment -->
	
	
	 
    <!-------------------------------------------------------->
    <div class="container">
			<div class="modal" id="<?php echo $id;?>">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							 
						</div>
						<div class="modal-body">
							<form method="POST">
							<input type="hidden" name="id" value="<?php echo $id; ?>">
						    <textarea rows="3" name="comment_content" class="span6" placeholder="Your Comment Here"></textarea>
							<br>
							<br>
						    <button name="comment" type="submit" class="btn btn-info"><i class="icon-share"></i>&nbsp;Comment</button>
							</form>

							<br>
							<br>
							
							<?php $comment=mysqli_query($conn,"SELECT * from comment where post_id='$id'")or die(mysqli_error());
							while($comment_row=mysqli_fetch_array($comment)){ ?>

							<div class="alert alert-success"><?php echo $comment_row['comment_content']; ?></div>
							
							<?php } ?>
							<!--- end comment -->
							
						</div>
						<div class="modal-footer">
							
						</div>
					</div>
				</div>
			</div>
		</div>
	<!-------------------------------------------------------->
	<?php  } ?>
    </tbody>
    </table>
 

    </div>
    </div>
	
    

		</div>
		<?php 
	include_once('session.php');
include_once('conn.php');
		if(isset($_POST['comment'])){
			echo "You here";
			$comment_content=$_POST['comment_content'];
			echo $comment_content; 
			$post_id=$_POST['id'];
			echo $post_id;
			$date_modified = date("Y-m-d H-i-s");
			echo $idate;
			$commenter_id = $_SESSION['user_id'];
			echo $commenter_id;
			if($user->comment($commenter_id,$post_id,$comment_content,$date_modified))
			{
				echo "Commented successfully.";
			}
			else
			{
				echo "Not commented";
			}
		}
		?>
		<script src="bootstrap/js/bootstrap.min.js"></script>
</body>
</html>