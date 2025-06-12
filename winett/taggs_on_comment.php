<?php
    $str2 = $comment_row["comment_content"];
    $up_to = str_word_count($str2); 
    $str1 = explode(" ", $str2);
    $c=0;
    $original = array(); $myArray = array();
    for($go = 0 ; $go < $up_to ; $go++)
    {
        if (strpos($str1[$go], '<center') !== false)
        {
            $str2.' id="'.$id.'"></video></center>';
            $go = $up_to;
        }
        elseif (strpos($str1[$go], '<br') !== false)
        {
            $go = $up_to;
        }
        elseif(strpos($str1[$go], '#') !== false)
        {  
            $original[$c] = $str1[$go];
            $myArray[$c] = '<a href="#">'.$str1[$go].'</a>';
            $str2 = str_ireplace($original, $myArray, $str2);
            $c++;
        }  
    }
    for($go = 0 ; $go < $up_to ; $go++)
    {
        
    }
    $original = NULL; $myArray = NULL;
    echo $str2;
?>