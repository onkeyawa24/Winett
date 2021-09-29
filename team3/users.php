<?php
	include_once('conn.php');

	function register_user($username, $display_name, $gender, $upass)
	{
		include('conn.php');
		try
		{
			$new_password = password_hash($upass, PASSWORD_DEFAULT);
			$date_created = date("Y-m-d H-i-s");
			$date_modified = date("Y-m-d H-i-sa");
			$sql = "INSERT INTO users(username, display_name, gender, date_created, date_modified, password) 
		        VALUES(:username, :display_name, :gender, :date_created, :date_modified, :upass)";
          	$stmt = $conn->prepare($sql);
			
												  
			$stmt->bindparam(":username", $username);
			$stmt->bindparam(":display_name", $display_name);
			$stmt->bindparam(":gender", $gender);				
			$stmt->bindparam(":date_created", $date_created);	
			$stmt->bindparam(":date_modified", $date_modified);
			$stmt->bindparam(":upass", $new_password);								  
				
			$stmt->execute();	
			$_SESSION['user_id'] = $conn->lastInsertId();
			return $stmt;	
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
		}				
	}

    function login($username,$upass)
	{
		include('conn.php');
		try
		{
			$stmt = $conn->prepare("SELECT user_id, username, password FROM users WHERE username=:username");
			$stmt->execute(array(':username'=>$username));
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
	function is_loggedin()
	{
		if(isset($_SESSION['user_id']))
		{
			return true;
		}
	}
	?>