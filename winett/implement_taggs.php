<?php

$posted_content = $row['post_content'];

if (isset($row['contains']) && $row['contains'] == 'img') {
    $img_id = $row['post_id'];
    $posted_content = '<a href="#" data-toggle="modal" data-target="#modal_'.$img_id.'"><center><img id="'.$img_id.'" '.$posted_content.'</center></a>';
}

if (isset($row['contains']) && $row['contains'] == 'vid') {
    $posted_content = "<center><video id='vid_".$row['post_id']."' ".$posted_content."<br>";
}
    /*$posted_content= $row['post_content'];
    if($row['contains'] == 'img')
    {
        $img_id = $row['post_id'];
        $posted_content = '<a href="#" data-toggle="modal" data-target="#modal_'.$id.'"><center><img id="'.$img_id.'" '.$posted_content.'</center></a>';
    }
    if($row['contains'] == 'vid')
    {
        $posted_content = "<center><video id='vid_".$row['post_id']."' ".$posted_content."<br>";
    }
*/
    $str2 = $posted_content;
    $up_to = str_word_count($str2); 
    $str1 = explode(" ", $str2);
    $c=0;
    $original = array(); $myArray = array();
    for($go = 0 ; $go < $up_to ; $go++)
    {
        if(strpos($str1[$go], '#') !== false)
        {  /*
            $original[$c] = $str1[$go]; 
            $myArray[$c] = '<span data-usertag="'.$original[$c].'" class="usertags"><a href="Posts.php"> '.$original[$c].' </a></span>';
            $str2 = str_ireplace($original, $myArray, $str2);
            $c++;
*/
            $original[$c] = $str1[$go];
            $myArray[$c] = '<a href="#">'.$str1[$go].'</a>';
            $str2 = str_ireplace($original, $myArray, $str2);
            $c++; 
        }  
        else
        {
            $go = $up_to;
        }
    }
    $original = NULL; $myArray = NULL;
    echo $str2;
?>
