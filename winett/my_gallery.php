 
<style>
    .galleryfor{display: block; z-index: 1; width: 100px; height: 100px; border-radius: 100%; border: 1px solid silver;}
    .showing_gallery{font-size: 85%; color: grey; font-weight: bold; font-family: 'Times New Roman'; position: fixed;top: 350px; left: 10px;}
    .poster_name{color:  #3498db; font-size: 18px;}
</style>
<?php 
    include ('conn.php');
    include('session.php');
    include('database_connections.php');
    if (isset($_POST['mygallery']))
    {     
        $thisuser = $_SESSION['user_session'];
        $id = $_POST['mygallery'];
        $posted_for = '<img class="galleryfor" src="./upload/'.$id.'.jpg" alt="Image missing">';
        $username = get_user_name($id, $connect);
        $sql = mysqli_query($conn,"SELECT * from gallery where poster_id = $id ORDER BY gallery_id DESC") or die(mysqli_error()); 
        $sum = mysqli_num_rows($sql);
        echo' <a href="gallery.php" style="color: blue;"><i class="glyphicon  glyphicon-chevron-left"></i> Back to gallery</a>';
        echo '<div class="col-md-12" style=" background-color: #f4f6f6;">
        <div class="col-md-2" style="">
            <div class="left-gallery">
                <div class="" style=" position: fixed; left: 0px; color: #d35400;">
                    <p style="color: #d35400; padding: 8px; "> <i class="glyphicon  glyphicon-user"></i> Profile</p>
                    <p class="mygallery" data-mygallery="'.$thisuser.'" style="color: #d35400; padding: 8px; "> <i class="glyphicon  glyphicon-picture"></i> My gallery</p>
                    <p style="color: #d35400; padding: 8px; "> <i class="glyphicon  glyphicon-heart"></i> Liked items</p>
                    <p style="color: #d35400; padding: 8px; "><i class="glyphicon  glyphicon-download-alt"></i> Saved items</p>
                    <p style="color: #d35400; padding: 8px; "><i class="glyphicon glyphicon-cog"></i> Settings</p><br>
                </div>
                <span class="showing_gallery">Photos and videos posted by: <br>
                <div class="foruser"><center>
                <a href="my_home.php?my_id='.$id.'">
                <span class="poster_name">
                '.$posted_for.' '.$username.'<br></span>
                <p style="color: black; font-size: 95%;">There are '.$sum.' photos and videos found for this user.</p>
                </div></a></center>
            </div>
        </div>
        <div class="col-md-10" style="border-left: 2px solid silver; padding-left: 4px; ">
            <div class="grid" id="grid">';    
                while($row = mysqli_fetch_array($sql))
                {
                    if($row['type'] == 0) //file is image
                    {
                        $poster = $row["poster_id"];
                        $posted_by = '<img class="mygallery" src="./upload/'.$poster.'.jpg" alt="Image missing">';
                        $image = $row["gallery_content"];
                        echo '<center><a href="upload/'.$image.'"><div class="grid__item grid__item--sm" style="background-image: url(upload/'.$image.');">
                            </div></a></center>';
                    }
                    else //file is video
                    {
                        $image = $row["gallery_content"];
                        echo '<center><a href="upload/'.$image.'"><div class="grid__item grid__item--sm" style="">
                            <video controls loop id="" class="grid__item grid__item--sm" >
                                <source src="upload/'.$image.'" type="video/mp4">
                            </video>
                        </div></a></center>';
                    }
                }  
      echo '</div>
          </div>
        </div>';     
    }  

?>