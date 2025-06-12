
<?php
    include_once('session.php');
    include_once('conn.php');
    include_once('session.php');
    $hey = $_SESSION['user_session'];
    $sort_pinned_id[] = array();
    $sorted_posts = array();
    $sql=mysqli_query($conn,"SELECT * from pinned_user where pinner_id = '$hey'");
    while($rows1=mysqli_fetch_array($sql)){
        $getid = $rows1['pinned_id'];
        $sort_pinned_id[] = $getid;
    }
    if(mysqli_num_rows($sql)>0)
    {
        for($i=0; $i < count($sort_pinned_id) ; $i++) 
        { 
    		$pinned_id = $sort_pinned_id[$i]; 
            $querypo=mysqli_query($conn,"SELECT * from post_table where poster_id='$pinned_id'");  
            $roow=mysqli_fetch_array($querypo);
            $sorted_posts[]=$roow['post_content'];
        }
        for($i=0; $i < count($sorted_posts) ; $i++)
        {
            echo $sorted_posts[$i]."<br><br><br>";
        }
    }
?>