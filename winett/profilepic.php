<?php

require_once("session.php");
	
require_once("class.user.php");
$user = new USER();


//$user="sanjay"; //you can fetch username here
 
$user_id = $_SESSION['user_session'];

$pull="SELECT * FROM userimage  where user_id='$user_id'";
$allowedExts = array("jpg", "jpeg", "gif", "png","jpg");
$extension = @end(explode(".", $_FILES["file"]["name"]));
if(isset($_POST['pupload'])){
if ((($_FILES["file"]["type"] == "image/gif")
|| ($_FILES["file"]["type"] == "image/jpeg")
|| ($_FILES["file"]["type"] == "image/jpj")
|| ($_FILES["file"]["type"] == "image/png")
|| ($_FILES["file"]["type"] == "image/pjpeg"))
&& ($_FILES["file"]["size"] < 8000000)
&& in_array($extension, $allowedExts))
{
	if ($_FILES["file"]["error"] > 0)
	{
	echo "Return Code: " . $_FILES["file"]["error"] . "<br>";
	}
	else
	{
		echo '<div class="plus">';
		echo "Uploaded Successully";
		echo '</div>';echo"<br/><b><u>Image Details</u></b><br/>";

		echo "Name: " . $_FILES["file"]["name"] . "<br/>";
		echo "Type: " . $_FILES["file"]["type"] . "<br/>";
		echo "Size: " . ceil(($_FILES["file"]["size"] / 1024)) . " KB";

		if (file_exists("upload/" . $_FILES["file"]["name"]))
		{
		unlink("upload/" . $_FILES["file"]["name"]);
		}
		else{
			try{
				$pic=$_FILES["file"]["name"];
				$conv=explode(".",$pic);
				$ext=$conv['1'];
				move_uploaded_file($_FILES["file"]["tmp_name"],"upload/". $user_id.".".$ext);
				echo "Stored in as: " . "upload/".$user_id.".".$ext;
				$url=$user_id.".".$ext;
				$now=date("Y-m-d H-i-s");
				$date_modified = date("Y-m-d H-i-sa");
				$sql= "INSERT INTO userimage(user_id,url,lastUpload) VALUES(:user_id,:url,:lastUpload)";
				$stmt = $user->runQuery($sql);
				$stmt->bindparam(":user_id", $user_id);	
				$stmt->bindparam(":url", $url);	
				$stmt->bindparam(":lastUpload", $date_modified);	
				 								  
				$stmt->execute();	
				/*$_SESSION['user_session'] = $user->lastInsertId();*/

				 
				header("Location: index.php");
			}
			
			catch(PDOException $e)
			{
				echo "Error: ".$e->getMessage();
			}
		}
	}
}
else{
 echo "File Size Limit Crossed 200 KB Use Picture Size less than 200 KB";
}
}
?>
<form action="" method="post" enctype="multipart/form-data">
<?php
$res=$user->runQuery($pull);
$res->execute();
$pics=$res->fetch(PDO::FETCH_ASSOC);
echo '<div class="imgLow">';
echo "<img src='upload/$pics[url]' alt='profile picture' width='80 height='64'   class='doubleborder'/></div>";
?>
<input type="file" name="file" />
<input type="submit" name="pupload" class="button" value="Upload"/>
</form>