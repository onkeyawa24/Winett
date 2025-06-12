<?php

   $conn = MySQLi_connect(
 "localhost","root","","wenett" //Database name or anything you would like to call it.
);
 
//Check connection
if (MySQLi_connect_errno())  
{
   echo "Failed to connect to MySQL: " . MySQLi_connect_error();
}   
//Getting value of "search" variable from "script.js".
if (isset($_POST['search'])) {
//Search box value assigning to $Name variable.
   $Name = $_POST['search'];
//Search query. 
   $Query = "SELECT * FROM  users WHERE user_firstname LIKE '%$Name%' or user_lastname LIKE '%$Name%' LIMIT 5";
 
   $ExecQuery = MySQLi_query($conn, $Query);
 
   //Fetching result from database.
   echo "People: ";
   while ($Result = MySQLi_fetch_array($ExecQuery)) {
       $user_id = $Result['user_id'];
       $pro_pic = '<img src="./upload/'.$user_id.'.jpg" alt="X" width="30" height="30" style="border-radius:100%; padding: 4px;">';
       $user_name = $Result['user_firstname'].' '.$Result['user_lastname'];
       $user = $pro_pic." ".$user_name;
       ?>
       <!--Calling javascript function named as "fill" found in "script.js" file.
        By passing fetched result as parameter. -->
   <li onclick='fill("<?php echo $user; ?>")'>
    <?php  $name = $user;?>
   <!-- Assigning searched result in "Search box" in "search.php" file. -->
       <?php echo "<a href='my_home.php?my_id=".$user_id."'>".$user."</a>"; ?>
   </li>
   <!-- Below php code is just for closing parenthesis. Don't be confused. -->
   <?php
  }
    $Query1 = "SELECT * FROM  post_table WHERE post_content LIKE '%$Name%' ORDER BY likes DESC LIMIT 2";
    $ExecQuery1 = MySQLi_query($conn, $Query1);
    echo "Posts: ";
    while($Result1 = MySQLi_fetch_array($ExecQuery1)) {
      $poster_id = $Result1['poster_id'];
      $Query2 = "SELECT * FROM users WHERE user_id = '$poster_id' LIMIT 1";
      $ExecQuery2 = MySQLi_query($conn, $Query2);
      $Result2 = MySQLi_fetch_array($ExecQuery2);
      $pro_pic = '<img src="./upload/'.$poster_id.'.jpg" alt="X" width="30" height="30">';
      $user_name2 = $Result2['user_firstname'].' '.$Result2['user_lastname'];
       $user2 = $pro_pic." ".$user_name2."<br>"." ".$Result1['post_content'];
       ?>
       <!--Calling javascript function named as "fill" found in "script.js" file.
        By passing fetched result as parameter. -->
   <div onclick='fill("<?php echo $user2; ?>")' style="border-left: 3px solid grey; padding: 10px; border-top-left-radius: 5px; border-bottom-left-radius: 5px; color: black; margin: 3px;">
    <?php  $name = $user2;?>
   <!-- Assigning searched result in "Search box" in "search.php" file. -->
       <?php echo $user2; ?>
   </div><br><?php
  }
}/*             
if(isset($_GET['search'])) {
//Search box value assigning to $Name variable.
   $Name = $_GET['search'];
//Search query. 
   $Query = "SELECT * FROM  users WHERE user_firstname LIKE '%$Name' or user_lastname LIKE '%$Name' LIMIT 5";
 
   $ExecQuery = MySQLi_query($conn, $Query);
 
   //Fetching result from database.
   echo "People: ";
   while ($Result = MySQLi_fetch_array($ExecQuery)) {
       $user_id = $Result['user_id'];
       $pro_pic = '<img src="./upload/'.$user_id.'.jpg" alt="X" width="30" height="30" style="border-radius:100%; padding: 4px;">';
       $user_name = $Result['user_firstname'].' '.$Result['user_lastname'];
       $user = $pro_pic." ".$user_name;
       ?>
       <!--Calling javascript function named as "fill" found in "script.js" file.
        By passing fetched result as parameter. -->
   <li onclick='fill("<?php echo $user; ?>")'>
    <?php  $name = $user;?>
   <!-- Assigning searched result in "Search box" in "search.php" file. -->
       <?php echo "<a href='my_home.php?my_id=".$user_id."'>".$user."</a>"; ?>
   </li>
   <!-- Below php code is just for closing parenthesis. Don't be confused. -->
   <?php
  }
    $Query1 = "SELECT * FROM  post_table WHERE post_content LIKE '%$Name' ORDER BY likes DESC LIMIT 2";
    $ExecQuery1 = MySQLi_query($conn, $Query1);
    echo "Posts: ";
    while($Result1 = MySQLi_fetch_array($ExecQuery1)) {
      $poster_id = $Result1['poster_id'];
      $Query2 = "SELECT * FROM users WHERE user_id = '$poster_id' LIMIT 1";
      $ExecQuery2 = MySQLi_query($conn, $Query2);
      $Result2 = MySQLi_fetch_array($ExecQuery2);
      $pro_pic = '<img src="./upload/'.$poster_id.'.jpg" alt="X" width="30" height="30">';
      $user_name2 = $Result2['user_firstname'].' '.$Result2['user_lastname'];
       $user2 = $pro_pic." ".$user_name2."<br>"." ".$Result1['post_content'];
       ?>
       <!--Calling javascript function named as "fill" found in "script.js" file.
        By passing fetched result as parameter. -->
   <div onclick='fill("<?php echo $user2; ?>")' style="border-left: 3px solid grey; padding: 10px; border-top-left-radius: 5px; border-bottom-left-radius: 5px; color: black; margin: 3px;">
    <?php  $name = $user2;?>
   <!-- Assigning searched result in "Search box" in "search.php" file. -->
       <?php echo $user2; ?>
   </div><br><?php
  }
}*/   

 ?>
 
 