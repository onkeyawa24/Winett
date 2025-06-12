<?php

	require_once("preSession.php");
	
	require_once("class.preschools.php");

	$auth_user = new USER();
	
	$user_id = $_SESSION['user_session'];
	
	$stmt = $auth_user->runQuery("SELECT * FROM preschools WHERE admin_id=:user_id");
	$stmt->execute(array(":user_id"=>$user_id));
	
	$usersRow=$stmt->fetch(PDO::FETCH_ASSOC);

   

  if(isset($_POST['btn-signup']))
{
  $umail = strip_tags($_POST['txt_umail']);
  $user_name = strip_tags($_POST['txt_name']);
  $user_phone = strip_tags($_POST['txt_phone']);
  $user_fax = strip_tags($_POST['txt_fax']);
  $price = strip_tags($_POST['txt_price']);
  $province = $_POST['province'];
  
  $city = strip_tags($_POST['txt_city']);
  $suburb = strip_tags($_POST['txt_suburb']);
  $street_name = strip_tags($_POST['txt_street_name']);
  $house_number = strip_tags($_POST['txt_house_number']);
  $code = strip_tags($_POST['txt_code']);
  $transport = $_POST['transport'];
  
  $number_of_kids = strip_tags($_POST['txt_number_of_kids']);
  $kids_age = $_POST['kids_age'];
  $overtime = $_POST['overtime'];
  $password = strip_tags($_POST['txt_upass']);

  
    try
    {
      $stmt = $auth_user->runQuery("SELECT * FROM preschools WHERE admin_id='$user_id'");
      $stmt->execute();
      $row=$stmt->fetch(PDO::FETCH_ASSOC);
      
    }
    catch(PDOException $e)
    {
      echo $e->getMessage();
    }
    
      try{
          $stmt = $auth_user->runQuery('UPDATE preschools SET email= :email , name=:uname, phone=:phone, fax = :fax, price = :price , povince= :province, city = :city, suburb = :suburb, street_name = :street_name, house_number = :house_number, code= :code, number_of_kids= :number_of_kids, kids_age= :kids_age, transport= :transport, overtime= :overtime WHERE admin_id=:user_id');
          $stmt->bindParam(':uname',$user_name);
          $stmt->bindParam(':email',$umail);
          $stmt->bindParam(':phone',$user_phone);
          $stmt->bindParam(':price',$price);
          $stmt->bindParam(':fax',$user_fax);
          $stmt->bindParam(':province',$province);
          $stmt->bindParam(':city',$city);
          $stmt->bindParam(':suburb',$suburb);
          $stmt->bindParam(':street_name',$street_name);
          $stmt->bindParam(':house_number',$house_number);
          $stmt->bindParam(':code',$code);
          $stmt->bindParam(':number_of_kids',$number_of_kids);
          $stmt->bindParam(':kids_age',$kids_age);
          $stmt->bindParam(':transport',$transport);
          $stmt->bindParam(':overtime',$overtime);
     
          if($stmt->execute()){
            ?>
          <script>
            alert('Successfully Updated...');
            window.location.href='home.php';
            </script>
          <?php
          }
          else{
            echo  "Sorry User Could Not Be Updated!";
          }
        }
        catch(PDOException $e)
    {
      echo $e->getMessage();
    }
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="./bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
<link href="./bootstrap/css/bootstrap-theme.min.css" rel="stylesheet" media="screen">
<script type="./js/javascript" src="jquery-1.11.3-jquery.min.js"></script>
<link rel="stylesheet" href="style.css" type="text/css"  />
<title>Edit Profile - <?php print($usersRow['user_email']); ?></title>

<style type="text/css">
  .edit_profile{
    background-color: #2c3539;
    color: grey;
  }
</style>
</head>

<body>

  
    <div class="clearfix">
      <div class="edit_profile">
    <h1 class="text-center"><i class="glyphicon glyphicon-user"></i>Edit Profile</h1>
    	<div class="container">
      
        <form method="post" class="">
          
              <?php
        if(isset($error))
        {
          foreach($error as $error)
          {
             ?>
                       <div class="alert alert-danger">
                          <i class="glyphicon glyphicon-warning-sign"></i> &nbsp; <?php echo $error; ?>
                       </div>
                       <?php
          }
        }
        else if(isset($_GET['joined']))
        {
           ?>
                   <div class="alert alert-info">
                        <i class="glyphicon glyphicon-log-in"></i> &nbsp; Successfully registered <a href='login.php'>login</a> here
                   </div>
                   <?php
        }
        ?>
              <div class="form-group">
              <input type="text" class="singn_form" name="txt_name" placeholder="Name"  required="required" data-error="Preschool name is required."/>
              </div>
              <div class="form-group">
              <input type="text" class="singn_form" name="txt_umail" placeholder="Email" required="required" data-error="Email is required." />
              </div>
              <div class="form-group">
              <input type="text" class="singn_form" name="txt_phone" placeholder="Phone number" required="required" data-error="Phone number is required." />
              </div>
              <div class="form-group">
              <input type="text" class="singn_form" name="txt_fax" placeholder="Fax number"  />
              </div>
              <div class="form-group">
              <input type="text" class="singn_form" name="txt_price" placeholder="Price per child" required="required" data-error="The price is required." />
              </div>

              <!--div class="form-group">
                <input type="password" class="singn_form" name="txt_upass" placeholder="Enter Password" required="required" data-error="Password is required."/>
              </div-->
                
                <select class="singn_form" name="province">
                  <option value="Argentina">--select province--</option>
                  <option value="Western Cape">Western Cape</option>
                  <option value="Eastern Cape">Eastern Cape</option>
                  <option value="Gauteng">Gauteng</option>
                  <option value="KwaZulu Natal">KwaZulu Natal</option>
                  <option value="Northern Cape">Northern Cape</option>
                  <option value="Free State ">Free State </option>
                  <option value="Mpumalanga">Mpumalanga</option>
                  <option value="Limpopo">Limpopo</option>
                  <option value="North West">North West</option>
                </select>

                <div class="form-group">
              <input type="text" class="singn_form" name="txt_city" placeholder="e.g Cape Town" required="required" data-error="City is required." />
              </div>

              <div class="form-group">
              <input type="text" class="singn_form" name="txt_suburb" placeholder="e.g Khayelitsha" required="required" data-error="Suburb is required." />
              </div>

               

              <div class="form-group">
              <input type="text" class="singn_form" name="txt_street_name" placeholder="Judge str" required="required" data-error="Street is required." /> 
              </div>

              <div class="form-group">
              <input type="text" class="singn_form" name="txt_house_number" placeholder="e.g 2023" required="required" data-error="House nummber is required." />
              </div>

              <div class="form-group">
              <input type="text" class="singn_form" name="txt_code" placeholder="Postal code" required="required" data-error="Postal code is required." />
              </div>

              <select class="singn_form" name="transport">
                  <option value="Argentina">--select--</option>
                  <option value="Yes">Yes</option>
                  <option value="No">No</option>
                </select>

                <select class="singn_form" name="kids_age">
                  <option value="Argentina">--select--</option>
                  <option value="Any age">Any age</option>
                  <option value="3 months and older">3 months and older</option>
                  <option value="6 months and older">6 months and older</option>
                  <option value="1 year and older">1 year and older</option>
                </select>

                <select class="singn_form" name="overtime">
                  <option value="Argentina">--select--</option>
                  <option value="Yes">Yes</option>
                  <option value="No">No</option>
                  <option value="When arranged">When arranged</option>
                </select>

                <div class="form-group">
              <input type="text" class="singn_form" name="txt_number_of_kids" placeholder="Number of kids" required="required" data-error="Number of children is required." /> 
              </div>

               
              <div class="clearfix"></div>
              <div class="form-group">
                <button type="submit" class="btn btn-primary" name="btn-signup">
                    <i class="glyphicon glyphicon-save"></i>&nbsp;SAVE CHANGES
                  </button>
              </div>
              <br />
        </form>
       </div>
     </div>
</div>

<script src="bootstrap/js/bootstrap.min.js"></script>

</body>
</html>