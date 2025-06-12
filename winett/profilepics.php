<?php

require_once("preSession.php");
	

require_once("class.preschools.php");

$user = new USER();

$user_id = $_SESSION['user_session'];
//$user="sanjay"; //you can fetch username here
 $stmt1 = $user->runQuery("SELECT * FROM preschools WHERE admin_id=:user_id");
	$stmt1->execute(array(":user_id"=>$user_id));
	
	$userRow1=$stmt1->fetch(PDO::FETCH_ASSOC);




$pull="SELECT * FROM userimage  where user_id='$user_id'";
$allowedExts = array("jpg", "jpeg", "gif", "png","jpg");
$extension = @end(explode(".", $_FILES["file"]["name"]));
if(isset($_POST['pupload'])){
if ((($_FILES["file"]["type"] == "image/gif")
|| ($_FILES["file"]["type"] == "image/jpeg")
|| ($_FILES["file"]["type"] == "image/jpj")
|| ($_FILES["file"]["type"] == "image/png")
|| ($_FILES["file"]["type"] == "image/pjpeg"))
&& ($_FILES["file"]["size"] < 1000000)
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
				move_uploaded_file($_FILES["file"]["tmp_name"],"upload/". $user_id.$userRow1['id'].".".$ext);
				echo "Stored in as: " . "upload/".$user_id.$userRow1['id'].".".$ext;
				$url=$user_id.$userRow1['id'].".".$ext;
				$now=date("Y-m-d H-i-s");
				$sql="UPDATE userimage SET url='$url' WHERE user_id='user_id'";
				if($stmt=$user->runQuery($sql)){
				$stmt->execute();
				echo "<br/>Saved to Database successfully";
				header("Location: loadschools.php");
			}
			}
			catch(PDOException $e)
			{
				echo "Error: ".$e->getMessage();
			}
		}
	}
}else{
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