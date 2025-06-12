<?php
	require_once('dbconfig.php');
  include_once "class.posts.php";

	class POST
	{	
		private $conn;
		
		public function __construct()
		{
			$database = new Database();
			$db = $database->dbConnection();
			$this->conn = $db;
	  }
		
	    public function index()
	    {
	   
	    }
      public function my_index($my_id)
      {
        $stmt = $this->conn->prepare("SELECT * FROM post_table WHERE poster_id='$my_id' ORDER BY post_id DESC");
        $stmt->execute();
             
        $posts = $stmt->fetchAll(\PDO::FETCH_CLASS, '\PostsClass');
        
        return $posts;
      }
		public function runQuery($sql)
		{
			$stmt = $this->conn->prepare($sql);
			return $stmt;
		}

     public function store($poster_id, $post_content) {
        $sql = "INSERT INTO post_table (poster_id, post_content, date_posted) VALUES (:poster_id, :post_content, NOW())";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':poster_id', $poster_id, PDO::PARAM_INT);
        $stmt->bindParam(':post_content', $post_content, PDO::PARAM_STR);
        return $stmt->execute();
    }
    

      public function store_image($poster_id, $post_content, $isimage)
      {
          $errorsInsertingSef = array();
          $contains = 'txt';
          if(empty($post_content))
          {
              $errorsInsertingSef[] = "Please write something.";
              return;
          }
          if($isimage == 1)
          {
            $post_content = ' class="post_image" src="./upload/'.$post_content.'" alt="Image"></center>';
            $contains = 'img';
          }
          elseif($isimage == 2)
          {
            $contains = 'vid';
            $post_content = '<center><video class="vidp" controls>
            <source src="./upload/'.$post_content.'" type="video/mp4"';
          }
          else
          {
            $post_content = "<span style='color: red;'>Error! This image/video is either deleted or was not uploaded succesful. Try uploading again</span>";
          }
          /*$post_content = '<br><a href="./upload/'.$post_content.'"><div class="post_image" style="background-image: url(upload/'.$post_content.'); height: 100%; position:relative; background-size: cover; background-position: center;"></div></a>';*/

          if(count($errorsInsertingSef)== 0)
          {
            $date_posted = date("Y-m-d h:i:s");
            $date_modified = date("Y-m-d h:i:s");
            $poster_id = $_SESSION['user_session'];
            try
            {
              $stmt = $this->conn ->prepare("INSERT INTO post_table(poster_id, post_content, contains, date_posted, date_modified)       
              VALUES(:poster_id, :post_content, :contains, :date_posted, :date_modified)");                  
              $stmt->bindparam(":poster_id", $poster_id);
              $stmt->bindparam(":post_content", $post_content); 
              $stmt->bindparam(":contains", $contains);
              $stmt->bindparam(":date_posted", $date_posted); 
              $stmt->bindparam(":date_modified", $date_modified);             
              if($stmt->execute())
              {
                return true;
              } 
            }
            catch(PDOException $e)
            {
              echo $e->getMessage();
            }
          }
          else
          {
            return $errorsInsertingSef;
          }
      }
	}
?>