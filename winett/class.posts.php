<?php
require_once('dbconfig.php');  

class PostsClass 
{
        public $post_id;
        public $post_content;
        public $date_posted;

        private $conn;
                
        public function __construct()
        {
                $database = new Database();
                $db = $database->dbConnection();
                $this->conn = $db;
        }

        public function PrintMe()
        {
                $user_id = $this->poster_id;
                $stmt = $this->conn->prepare("SELECT * FROM users WHERE user_id = '$user_id'");
                $stmt -> execute();
                $row = $stmt -> fetch(PDO::FETCH_ASSOC);
                if($stmt->rowCount() == 1)
                {
                        $poster = $row['user_firstname']." ".$row['user_lastname'];
                }
                else
                {
                        $poster = "User account is no longer available.";
                }
                $userId=$row['user_id'];
                echo '<div class="posts" style="background-color:#DCDCDC;height:auto; padding: 1%;"><a href="my_home.php?my_id='.$userId.'"><img id="image" src="./upload/'.$userId.'.jpg" alt="X" width="30" height="30" style="border-radius:100%;">'.$row["user_firstname"].' '.$row["user_lastname"].'</a></div><br>';
                echo "<p style='font-size: 130%; color:black; margin-left:2%; margin-right:2%;'> ". $this->post_content . "<br></p><br>";
                echo "<span style='margin-left: 2%; height: 1em;'> 
                        <i class='glyphicon  glyphicon-thumbs-up' style='margin-right: 10px;'></i>
                        </i> <i class='glyphicon glyphicon-comment' style='margin-right: 10px; color:grey;'></i>
                        <i class='glyphicon glyphicon-eye-open' style='margin-right: 10px; color:grey;'></i>
                        <i class='glyphicon glyphicon-share-alt' style='margin-right: 10px;'></i>
                        
                </span>";

        }
}
?>