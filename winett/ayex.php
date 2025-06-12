<?php

   $conn = MySQLi_connect(
 "localhost","root","","wenett" //Database name or anything you would like to call it.
);
  
//Check connection
if (MySQLi_connect_errno()) 
{
   echo "Failed to connect to MySQL: " . MySQLi_connect_error();
} 
else{  
//Getting value of "search" variable from "script.js".

if (isset($_POST['touser'])) {
   
//Search box value assigning to $Name variable.
   $Name = $_POST['touser'];
//Search query. 
   
   //$Query = "SELECT Name FROM  preschools WHERE name = Name";
//Query execution
  $Query = "SELECT * FROM  users WHERE user_firstname LIKE '%$Name%' LIMIT 5";
   //$Query = "SELECT Name FROM  preschools WHERE name = Name";
//Query execution
   $ExecQuery = MySQLi_query($conn, $Query);
//Creating unordered list to display result.
  
   //Fetching result from database.
   while ($Result = MySQLi_fetch_array($ExecQuery)) {
     echo "*********************************************************************************************************************************************************************************************************************************************";  ?>

   <!-- Creating unordered list items.
        Calling javascript function named as "fill" found in "script.js" file.
        By passing fetched result as parameter. -->
   <li onclick='fill("<?php echo $Result['user_firstname']; ?>")'>
    <?php  $name = $Result['user_firstname'];?>
   <!-- Assigning searched result in "Search box" in "search.php" file. -->
       <?php echo $Result['user_firstname']; ?>
   </li>
   <!-- Below php code is just for closing parenthesis. Don't be confused. -->
   <?php
}}
else
{
  echo "DID NOT GET HERE";
}
}
 ?>
 
 