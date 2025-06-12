
<style>
            .row{
                width: 100%;
            }
            .image1{
                border-radius: 100%;
                margin-right:5px;
            }
            .pagecontrol{
                background-color: white;
                padding: 6px;
                width: 100%;
                border-radius: 6px;
                margin-bottom: 3px;
            }
            .col-md-12{ 
                width:100%;
                padding:5px;
            }
            .col-md-4{
                margin-right: 4%;
                width:4px;
                margin-bottom: -4px;
            }
            .myModals{
                background-color: #25383c;
                
            }
            .myModal{
                background-color: white;
            }
            .my{
                
                margin-left: 10%;
                margin-right: 30%;

            }
            .container{
                background-color: transparent;
            }
            .user_history{
                width: 100%;
                color: black;
                background-color: transparent;
            }
            .myMenu{
                background-color: transparent;
            }
            .panel{
                background-color: transparent;
            }
            .sharing{
                color:black;
                margin-left: 5%;
                margin-right: 5%;
                margin-top: 2%;
                margin-bottom: 2%;
                border-left:2px solid silver;
                padding: 12px;
                background-color:white;
                width:auto;
            }
            .actual{
                padding-left: 5px;
                color: black;
            }
            .commenti{
                padding-top:1px;border-bottom: 1px solid grey;
            background-color: white;
            margin:1px;
            border-radius: 3px;
            }
            .mi{
                padding: 3px;
                margin-right: 50px;
            }
            .myDrops{
                margin-left: 95%;
                text-align: right;
                margin-right: 1px;
            }
            .texts{
                background-color: white;
                border: 1px solid silver;
                color: black;
                border-radius: 5px;
                padding: 3px;
            }
</style>
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
            $hey = $_SESSION['user_session'];
            
            $people = array();
            $sort_pinned_id=array(); 
            $sorted_posts=array(); 

    /**/    $sql = mysqli_query($conn, "SELECT * FROM pinned_user WHERE pinner_id = '$hey'");
            if(mysqli_num_rows($sql) > 0){
                while($rows1 = mysqli_fetch_assoc($sql)){
                    $sort_pinned_id[] = $rows1['pinned_id'];
                }
            }

          $query = mysqli_query($conn, "SELECT * FROM post_table ORDER BY post_id DESC");
$total_posts = mysqli_num_rows($query); // Get count BEFORE using while

$counting = 0;
$sorted_posts = array(); // store skipped/unpinned post IDs

while ($row = mysqli_fetch_assoc($query)) {
    $id = $row['post_id'];
    $poster = $row['poster_id'];

    if (!empty($sort_pinned_id) && in_array($poster, $sort_pinned_id)) {
        $counting++;
        include('set_posts.php');  // Show pinned post
    } else {
        $sorted_posts[] = $id;     // Save for later if needed
    }
}

echo "**ONLY** $counting **POSTED** WHILE **" . count($sorted_posts) . "** POSTS ARE NOT POSTED **OUT OF** $total_posts **IN TOTAL**";
?>