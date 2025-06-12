 
<style>
 .pagecontrol{
        color: white; background-color: #CDDAD9;/*#25383c;*/
        padding: 10px; width: 100%; border-radius: 6px; margin-bottom: 3px;
    }
</style>
<?php 

    include('conn.php');
    include_once('session.php');
    include('database_connections.php');
    if (isset($_POST['usertag']))
    {     
        $people = array();
        $thisuser = $_SESSION['user_session'];
        $usertag = $_POST['usertag'];
        /*$username = get_user_name($id, $connect);*/
        $sql = mysqli_query($conn,"SELECT * from post_table where post_content LIKE '%$usertag%'  ORDER BY post_id DESC") or die(mysqli_error()); 
        $sum = mysqli_num_rows($sql);
        $tagged_posts = array();  $tagged_poster = array();
        echo '<hr><p style="color: white;">There were '.$sum.' matches found.</p><hr>' ;
        while($row = mysqli_fetch_array($sql))
        {
            $poster = $row['poster_id'];
            $tagged_id = $row['post_id'];
            include('tagged_posts.php');
        }
         
         
        echo '<br><br><p style="color: white;"> ********************* END ********************** </p><br>' ;  
        $tagged_poster=NULL; $tagged_posts=NULL;      
    }  

?>