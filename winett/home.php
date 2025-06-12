<?php

	require_once("session.php");
	require_once("class.user.php");

	$auth_user = new USER();      //Object of class user
	$user_id = $_SESSION['user_session'];      //set user id to current user session.

	$stmt = $auth_user->runQuery("SELECT * FROM users WHERE user_id=:user_id");
	$stmt->execute(array(":user_id"=>$user_id));
	$userRow=$stmt->fetch(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
	<link href="bootstrap/css/bootstrap-theme.min.css" rel="stylesheet" media="screen">
	<script type="text/javascript" src="jquery-1.11.3-jquery.min.js"></script>
	<link rel="stylesheet" href="style.css" type="text/css"  />
</head>
<style type="text/css">
	.post_content{
		background-color: white;
		
	}
	body{
		background-color: red;
	}
	html{
		background-color: red;
	}
</style>
<body>
    <div class="clearfix"></div>
	<div class="container-fluid" style="margin-top:80px;">	
	    <div class="container">	   
			<?php
		 		include_once "class.post.php";
				$post = new POST();
			?>
			<div class="post_content"><?php
				foreach ($post->index() as $me) 
				{
				    echo  $me->PrintMe()."<hr>";
				}
				;
				?>  
			</div>
		</div>
	</div>
	<script src="bootstrap/js/bootstrap.min.js"></script>
	<script>
	$(document).ready(function(){
            setInterval(function(){ 
                update_posts();
            }, 1000);
            
            do_this();
                repeat_this();

            function update_posts()
             {
              $.ajax({
               url:"post_history.php",
               method:"POST",
               success:function(data){
                $('.user_history').html(data);
               }
              })
             }

            function do_this(){
            $(document).on('click', '.like', function(){
                var id=$(this).val();
                var $this = $(this);
                $this.toggleClass('like');
                if($this.hasClass('like')){
                    
                } else {
                    $this.text('Unlike');
                     
                }
                    $.ajax({
                        type: "POST",
                        url: "like.php",
                        data: {
                            id: id,
                            like: 1,
                        },
                        success: function(){
                            showLike(id);
                        }
                    });

            });
            }
        });
</script>
</body>
</html>