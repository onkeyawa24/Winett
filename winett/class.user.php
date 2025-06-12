<?php

require_once('dbconfig.php');

class USER
{	

	private $conn;
	
	public function __construct()
	{
		$database = new Database();
		$db = $database->dbConnection();
		$this->conn = $db;
    }
	
	public function runQuery($sql)
	{
		$stmt = $this->conn->prepare($sql);
		return $stmt;
	}
	public function additions($id)
	{

	}
	public function update($user_id, $username, $user_firstname, $user_lastname, $gender, $upass)
	{
		try
		{
			$date_modified = date("Y-m-d H-i-s");
			$new_password = password_hash($upass, PASSWORD_DEFAULT);
			$sql = "UPDATE users SET username = '$username', user_firstname = '$user_firstname', user_lastname='$user_lastname', gender = '$gender', date_modified ='$date_modified', password = '$new_password'  WHERE user_id='$user_id'";
			$stmt = $this->conn->prepare($sql);
		    $stmt->execute();
		    
	    	 
			    
			return $stmt;
		}
		catch(PDOException $e)
		{
			echo "Error: ".$e->getMessage();
		}
	}
	
	public function registerUser($user_id, $bio, $date_modified)
	{
		try
		{
			 $user_id = $_SESSION['user_session'];
			$date_modified = date("Y-m-d H-i-sa");

			$stmt = $this->conn->prepare("INSERT INTO user_details(user_id, bio, date_modified) 
		                                 		VALUES(:user_id, :bio, :date_modified)");
												  	
			$stmt->bindparam(":user_id", $user_id);	
			$stmt->bindparam(":bio", $bio);	
			$stmt->bindparam(":date_modified", $date_modified);	
			 								  
			$stmt->execute();	
		
			return $stmt;	
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
		}				
	}
	public function comment($commenter_id, $post_id, $comment_content,$date_modified)
	{
		try
		{
			$stmt = $this->conn->prepare("INSERT INTO comment(commenter_id, post_id, comment_content ,date_modified) 
		        VALUES(:commenter_id, :post_id,:comment_content, :date_modified)");
												  	
			$stmt->bindparam(":commenter_id", $commenter_id);	
			$stmt->bindparam(":post_id", $post_id);	
			$stmt->bindparam(":comment_content", $comment_content);
			$stmt->bindparam(":date_modified", $date_modified);	
			 								  
			$stmt->execute();	
			return $stmt;	
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
		}				
	}
	public function share($sharer_id, $post_id, $poster_id,$post_content)
	{
		try
		{
			/*$date_modified = date("Y-m-d H-i-s");*/
			$sharer_id=$_SESSION['user_session'];
			$stmt = $this->conn->prepare("INSERT INTO share(sharer_id, post_id, poster_id ,post_content) 
		                                 		VALUES(:sharer_id, :post_id,:poster_id, :post_content)");
												  	
			$stmt->bindparam(":sharer_id", $sharer_id);	
			$stmt->bindparam(":post_id", $post_id);	
			$stmt->bindparam(":poster_id", $poster_id);
			$stmt->bindparam(":post_content", $post_content);	
			/*$stmt->bindparam(":date_modified", $date_modified);  */
			$stmt->execute();	
		
			return $stmt;	
		}
		catch(PDOException $e)
		{
			echo "---YOUR GOT HERE ---";
			echo $e->getMessage();
		}				
	}
	public function register($umail, $user_firstname, $user_lastname, $gender, $country, $upass)
	{
		try
		{
			$new_password = password_hash($upass, PASSWORD_DEFAULT);
			$status = "active";
			$date_created = date("Y-m-d H-i-s");
			$date_modified = date("Y-m-d H-i-sa");

			$stmt = $this->conn->prepare("INSERT INTO users(username, user_firstname, user_lastname, gender, status, date_created, date_modified, country, password) 
		                                 		VALUES(:umail, :user_firstname, :user_lastname, :gender, :status, :date_created, :date_modified, :country, :upass)");
												  
			
			$stmt->bindparam(":umail", $umail);	
			$stmt->bindparam(":user_firstname", $user_firstname);
			$stmt->bindparam(":user_lastname", $user_lastname);
			$stmt->bindparam(":gender", $gender);			
			$stmt->bindparam(":status", $status);	
			$stmt->bindparam(":date_created", $date_created);	
			$stmt->bindparam(":date_modified", $date_modified);	
			$stmt->bindparam(":country", $country);		
			$stmt->bindparam(":upass", $new_password);								  
				
			$stmt->execute();	
			$_SESSION['user_session'] = $this->conn->lastInsertId();
			return $stmt;	
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
		}				
	}
	
	
	public function doLogin($umail,$upass)
	{
		try
		{
			$stmt = $this->conn->prepare("SELECT user_id, username, password FROM users WHERE username=:umail");
			$stmt->execute(array(':umail'=>$umail));
			$userRow=$stmt->fetch(PDO::FETCH_ASSOC);
			if($stmt->rowCount() == 1)
			{
				if(password_verify($upass, $userRow['password']))
				{
					$_SESSION['user_session'] = $userRow['user_id'];
					return true;
				}
				else
				{
					return false;
				}
			}
		}
		catch(PDOException $e)
		{
			echo "Error occured: ".$e->getMessage();
		}
	}
	
	public function is_loggedin()
	{
		if(isset($_SESSION['user_session']))
		{
			return true;
		}
	}
	
	public function redirect($url)
	{
		header("Location: $url");
		exit();
	}
	
	public function doLogout()
	{
		session_destroy();
		unset($_SESSION['user_session']);
		return true;
	}
}
?>