<style>
    .row{
        width: 100%;
    }
    .image1{
        border-radius: 100%; margin-right:5px;
    }
    .pagecontrol{
        color: white; background-color: #fcfcf9; box-shadow: 2px 2px 3px #737373; 
        padding: 10px; width: 100%; border-radius: 6px; margin-bottom: 3px; 
    }
    .col-md-12{ 
        width:100%; padding:5px;
    }
    .col-md-4{
        margin-right: 4%; width:4px; margin-bottom: -4px;
    }
    .myModals{
        background-color: #silver;
    }
    .myModal{
        background-color: white;
    }
    .my{
        margin-left: 10%; margin-right: 30%;
    }
    .container{
        background-color: transparent;
    }
    .user_history{
        width: 100%; color: black; background-color: transparent;
    }
    .myMenu{
        background-color: transparent;
    }
    .panel{
        background-color: transparent;
    }
    .prev_sharing{
        color:black; margin-left: 2px;
        margin-right: 10px; margin-top: 10px; margin-bottom: 10px; border-radius: 8px;
        border: 1px solid silver; padding: 10px; background-color:white;
    }
    .sharing{
        color:black; margin-left: 2px;
        margin-right: 5%; margin-top: 10px; margin-bottom: 10px; border-radius: 8px;
        border-left:2px dashed silver; padding: 10px; background-color:white;
    }
    .actual{
        padding-left: 5px; color: black;
    }
    .commenty{
        padding: 4px 8px 4px 8px; border-bottom: 1px solid grey;
        background-color: white; margin:1px; border-radius: 3px;
    }
    .mi{
        padding: 3px; margin-right: 50px;
    }
    .myDrops{
        margin-left: 95%; text-align: right; margin-right: 1px;
    }
    .texts{
        background-color: white; border: 1px solid silver; color: black; border-radius: 5px; padding: 3px;
    }
</style>
<?php
    if(isset($_POST['edit'])){
        $post_id = $_POST['post_id'];
        $sql9 = mysqli_query($auth_user, "SELECT * FROM post_table WHERE post_id=$post_id");
        $rows9 = mysqli_fetch_array($sql9);
        $edited='I have edited this';
        mysqli_query($auth_user, "UPDATE post_table SET post_content='hello you too.' WHERE post_id=$post_id");
        $auth_user->redirect('Posts.php');
    }
    include_once('conn.php');
    include_once('header.php');
    ?>
    <body>
        <div class="user_histry">
            <?php
            if (!isset($_SESSION['user_session']) ||(trim ($_SESSION['user_session']) == '')) {
                header('location:index.php');
                exit();
            }?>
            <?php
            include_once('conn.php');
            if (!isset($_SESSION['user_session']) ||(trim ($_SESSION['user_session']) == '')) {
                header('location:index.php');
                exit();
            }

            $hey = $_SESSION['user_session'] ?? null;

            if (!$hey) {
                // Handle error: user not logged in or session missing
                die("User session not found.");
            }

            $sort_pinned_id = [];  // Initialize as empty array

            // Query pinned users for current user
            $sql = mysqli_query($conn, "SELECT * FROM pinned_user WHERE pinner_id = '$hey'");

            if (!$sql) {
                die("Database query failed: " . mysqli_error($conn));
            }

            // Check if any pinned users exist before looping
            if (mysqli_num_rows($sql) > 0) {
                while ($rows1 = mysqli_fetch_assoc($sql)) {
                    $getid = $rows1['pinned_id'];
                    $sort_pinned_id[] = $getid;  // Add pinned_id to array
                }
            } else {
                // No pinned users found
                $sort_pinned_id = [];
            }

            $query = mysqli_query($conn, "SELECT * FROM post_table ORDER BY post_id DESC");
            $total_posts = mysqli_num_rows($query); // Get count BEFORE using while

            $counting = 0;
            $sorted_posts = array(); // store skipped/unpinned post IDs

            while ($row = mysqli_fetch_assoc($query)) {
                $id = $row['post_id'];
                $poster = $row['poster_id'];


                    $counting++;
                    include('set_posts.php');  // Show pinned post
            
            }


          /*
            $que2=mysqli_query($conn,"SELECT * from post_table ORDER BY post_id DESC");
            while($row=mysqli_fetch_array($que2))
            {   
                $id=$row['post_id']; $poster=$row['poster_id'];
                $j='k';$p='p';$share_this=$row['post_content'];
                $share =$row['post_id'].$p;
                if(count($sorted_posts)>0)
                {
                    for($i=0; $i < count($sorted_posts) ; $i++)
                    {
                        $p_id=$sorted_posts[$i];
                        if($id == $p_id)
                        { ++$counting; ?>
                           <?php include('set_posts.php');?><?php 
                        }  
                    }
                }
            }*/
           echo "**ONLY** $counting **POSTED** WHILE **" . count($sorted_posts) . "** POSTS ARE NOT POSTED **OUT OF** $total_posts **IN TOTAL**";
?>
        </div>
    </body>
    </html>
      