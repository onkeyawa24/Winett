<?php
include_once('session.php');
include_once('conn.php');
require_once('class.post.php');
require_once("class.user.php");
$poster_id = $_SESSION['user_session'];
$postObj = new POST();
if (isset($_POST['upload_img'])) 
{
    $isimage = 1;
    /*$counters=0;*/ $pics='';
    $j = 0;     // Variable for indexing uploaded image.
        // Declaring Path for uploaded images.
    for ($i = 0; $i < count($_FILES['file']['name']); $i++) 
    {
        // Loop to get individual element from the array
        $validextensions = array("jpeg", "jpg","gif", "png");      // Extensions which are allowed.
        $ext = explode('.', basename($_FILES['file']['name'][$i]));   // Explode file name from dot(.)
        $file_extension = end($ext); // Store extensions in the variable.
        $target_path = md5(uniqid()) . "." . $ext[count($ext) - 1];     // Set the target path with a new name of image.
        $post_content = $target_path;
        $move_this = '../upload/'.$target_path;
        $j = $j + 1;      // Increment the number of uploaded images according to the files in array.
        if (($_FILES["file"]["size"][$i] < 409600000)     // Approx. 100kb files can be uploaded.
        && in_array($file_extension, $validextensions)) 
        {
            if (move_uploaded_file($_FILES['file']['tmp_name'][$i], $move_this)) 
            {
                /*$counters=$counters+1;*/
                // If file moved to upload folder. 
                if($ext[count($ext) - 1] == 'mp4'){/*
                    $post_content = $target_path;*/
                    $isimage = 2;
                /*$pics = $pics.'<br>'.$post_content;*/
                }
                else
                {
                    $isimage = 1;
                    /*$post_content = $target_path;/*
                    $pics = $pics.'<br>'.$post_content;*/
                }
                continue;
            } 
            else 
            {     //  If File Was Not Moved.
                echo $j. ').<span id="error">please try again!.</span><br/><br/>';
            }
        } 
        else 
        {     //   If File Size And File Type Was Incorrect.
            echo $j. ').<span id="error">***Invalid file Size or Type***</span><br/><br/>';
        }
    }        
    $pics = $post_content;
    if($postObj->store_image($product_name, $description, $price, $img_name))
    {
        mysqli_query($conn,"INSERT INTO products(product_name, description, price, img_name) VALUES ('$product_name', '$description', '$price', '$img_name')");
        header("Location: shop.php");
    }
}
?>