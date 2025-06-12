<?php
	session_start();
	require_once('class.user.php');
	$user = new USER();
	$error_message = ' ';
	$error = array();
	if($user->is_loggedin()!="")
	{
		$user->redirect('login.php');
	}

	if(isset($_POST['btn-signup']))
	{
		$upass = strip_tags($_POST['txt_upass']);
		$upass2 = strip_tags($_POST['txt_upass2']);

		if(!($upass == $upass2))
		{
			$error_message = "Password did not match!";
			
		}
		else
		{
			$umail = strip_tags($_POST['txt_umail']);
			$user_firstname = strip_tags($_POST['txt_firstname']);
			$user_lastname = strip_tags($_POST['txt_lastname']);
			$gender = $_POST['gender'];
			$country = $_POST['country'];
			/*$bio = strip_tags($_POST['txt_bio']);*/
			

			if($user_lastname=="")	{
				$error[] = "Provide lastname !";	
			}
			else if($user_firstname == "")
			{
				$error[] = "Provide firstname !";
			}
			else if($umail=="")	{
				$error[] = "provide email id !";	
			}
			else if(!filter_var($umail, FILTER_VALIDATE_EMAIL))	{
			    $error[] = 'Please enter a valid email address !';
			}
			else if($upass=="")	{
				$error[] = "provide password !";
			}
			else if(strlen($upass) < 6){
				$error[] = "Password must be atleast 6 characters";	
			}
			else
			{
				try
				{
					$stmt = $user->runQuery("SELECT * FROM users WHERE username='$umail'");
					$stmt->execute();
					$row=$stmt->fetch(PDO::FETCH_ASSOC);
 
					if($row['username']==$umail) 
					{
						$error[] = "This email address is already taken !";
					}
					else
					{
						if($user->register($umail, $user_firstname, $user_lastname, $gender, $country, $upass))
						{	
							$user->redirect('logins.php'); 
						}
					}
				}
				catch(PDOException $e)
				{
					echo $e->getMessage();
				}
			}
		}	
	}

?>
<!DOCTYPE html  >
 
<head>
	<title>WiNett | Signup</title>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="./boot/jquery-ui.css">
    <link rel="stylesheet" href="./boot/bootstrap.min.css">
    <link rel="stylesheet" href="./boot/emojionearea.min.css">
    <script src="./boot/jquery-1.12.4.js"></script>
    <script src="./boot/jquery-ui.js"></script>
    <script src="./boot/emojionearea.min.js"></script>

<style type="text/css">
html{
	width: 100%;
}
	body{
        background-image: linear-gradient(#2F4F4F,#2F4F4F,#2F4F4F);
    }
  	 
	 
	.rad-butns{
		color: white;
	}
	.signup{
		border: 2px solid silver; border-radius: 10px;
		background-color: white;
		margin-top: 5%; 
		padding: 8%;
	}
	.select-user-type{
		margin-top: 2%;
		margin-bottom: 2%;
		margin-left: -2%;
	}
	.singn_form_date{
		/*border:none;
		border-bottom: solid;
		border-width: 1px;
		border-color: #DA6501;*/
		width: 32%;
	}
	h2{
		color: #DA6501;
		font-style: bold;
	}
	.date-of-birth{
		margin-top: 2%;
		margin-bottom: 2%;
	}

</style>

</head>

<body>
<div class="col-md-12">
    <div class="col-md-4">
    </div>
    <div class="col-md-4">
		 
			 
		    	<div class="signup">
		        	<form method="post">
		        		<center><span style="font-size: 1.3em; color: #708090; text-align: center;">Create Winett account</span></center><hr>
				            <label>First name</label>
				            <div class="form-group">
				            <input type="text" class="form-control" name="txt_firstname" placeholder="Name"  required="required" data-error="Lastname is required."/>
				            </div>
				            <div class="form-group">
				            <label>Last name</label>
				            <input type="text" class="form-control" name="txt_lastname" placeholder="Surname" required="required" data-error="Lastname is required." />
				            </div>
				            <div class="form-group">
				            <label>E-mail</label>

				            <input type="email" class="form-control" name="txt_umail" placeholder="Email"  required="required" data-error="Lastname is required." />
				            <label>Country</label>
				           	<!----------------------------------------->
				           	<?php $countries = array("ZA" => "South Africa",
				           	"AF" => "Afghanistan",
							"AX" => "Åland Islands",
							"AL" => "Albania",
							"DZ" => "Algeria",
							"AS" => "American Samoa",
							"AD" => "Andorra",
							"AO" => "Angola",
							"AI" => "Anguilla",
							"AQ" => "Antarctica",
							"AG" => "Antigua and Barbuda",
							"AR" => "Argentina",
							"AM" => "Armenia",
							"AW" => "Aruba",
							"AU" => "Australia",
							"AT" => "Austria",
							"AZ" => "Azerbaijan",
							"BS" => "Bahamas",
							"BH" => "Bahrain",
							"BD" => "Bangladesh",
							"BB" => "Barbados",
							"BY" => "Belarus",
							"BE" => "Belgium",
							"BZ" => "Belize",
							"BJ" => "Benin",
							"BM" => "Bermuda",
							"BT" => "Bhutan",
							"BO" => "Bolivia",
							"BA" => "Bosnia and Herzegovina",
							"BW" => "Botswana",
							"BV" => "Bouvet Island",
							"BR" => "Brazil",
							"IO" => "British Indian Ocean Territory",
							"BN" => "Brunei Darussalam",
							"BG" => "Bulgaria",
							"BF" => "Burkina Faso",
							"BI" => "Burundi",
							"KH" => "Cambodia",
							"CM" => "Cameroon",
							"CA" => "Canada",
							"CV" => "Cape Verde",
							"KY" => "Cayman Islands",
							"CF" => "Central African Republic",
							"TD" => "Chad",
							"CL" => "Chile",
							"CN" => "China",
							"CX" => "Christmas Island",
							"CC" => "Cocos (Keeling) Islands",
							"CO" => "Colombia",
							"KM" => "Comoros",
							"CG" => "Congo",
							"CD" => "Congo, The Democratic Republic of The",
							"CK" => "Cook Islands",
							"CR" => "Costa Rica",
							"CI" => "Cote D'ivoire",
							"HR" => "Croatia",
							"CU" => "Cuba",
							"CY" => "Cyprus",
							"CZ" => "Czech Republic",
							"DK" => "Denmark",
							"DJ" => "Djibouti",
							"DM" => "Dominica",
							"DO" => "Dominican Republic",
							"EC" => "Ecuador",
							"EG" => "Egypt",
							"SV" => "El Salvador",
							"GQ" => "Equatorial Guinea",
							"ER" => "Eritrea",
							"EE" => "Estonia",
							"ET" => "Ethiopia",
							"FK" => "Falkland Islands (Malvinas)",
							"FO" => "Faroe Islands",
							"FJ" => "Fiji",
							"FI" => "Finland",
							"FR" => "France",
							"GF" => "French Guiana",
							"PF" => "French Polynesia",
							"TF" => "French Southern Territories",
							"GA" => "Gabon",
							"GM" => "Gambia",
							"GE" => "Georgia",
							"DE" => "Germany",
							"GH" => "Ghana",
							"GI" => "Gibraltar",
							"GR" => "Greece",
							"GL" => "Greenland",
							"GD" => "Grenada",
							"GP" => "Guadeloupe",
							"GU" => "Guam",
							"GT" => "Guatemala",
							"GG" => "Guernsey",
							"GN" => "Guinea",
							"GW" => "Guinea-bissau",
							"GY" => "Guyana",
							"HT" => "Haiti",
							"HM" => "Heard Island and Mcdonald Islands",
							"VA" => "Holy See (Vatican City State)",
							"HN" => "Honduras",
							"HK" => "Hong Kong",
							"HU" => "Hungary",
							"IS" => "Iceland",
							"IN" => "India",
							"ID" => "Indonesia",
							"IR" => "Iran, Islamic Republic of",
							"IQ" => "Iraq",
							"IE" => "Ireland",
							"IM" => "Isle of Man",
							"IL" => "Israel",
							"IT" => "Italy",
							"JM" => "Jamaica",
							"JP" => "Japan",
							"JE" => "Jersey",
							"JO" => "Jordan",
							"KZ" => "Kazakhstan",
							"KE" => "Kenya",
							"KI" => "Kiribati",
							"KP" => "Korea, Democratic People's Republic of",
							"KR" => "Korea, Republic of",
							"KW" => "Kuwait",
							"KG" => "Kyrgyzstan",
							"LA" => "Lao People's Democratic Republic",
							"LV" => "Latvia",
							"LB" => "Lebanon",
							"LS" => "Lesotho",
							"LR" => "Liberia",
							"LY" => "Libyan Arab Jamahiriya",
							"LI" => "Liechtenstein",
							"LT" => "Lithuania",
							"LU" => "Luxembourg",
							"MO" => "Macao",
							"MK" => "Macedonia, The Former Yugoslav Republic of",
							"MG" => "Madagascar",
							"MW" => "Malawi",
							"MY" => "Malaysia",
							"MV" => "Maldives",
							"ML" => "Mali",
							"MT" => "Malta",
							"MH" => "Marshall Islands",
							"MQ" => "Martinique",
							"MR" => "Mauritania",
							"MU" => "Mauritius",
							"YT" => "Mayotte",
							"MX" => "Mexico",
							"FM" => "Micronesia, Federated States of",
							"MD" => "Moldova, Republic of",
							"MC" => "Monaco",
							"MN" => "Mongolia",
							"ME" => "Montenegro",
							"MS" => "Montserrat",
							"MA" => "Morocco",
							"MZ" => "Mozambique",
							"MM" => "Myanmar",
							"NA" => "Namibia",
							"NR" => "Nauru",
							"NP" => "Nepal",
							"NL" => "Netherlands",
							"AN" => "Netherlands Antilles",
							"NC" => "New Caledonia",
							"NZ" => "New Zealand",
							"NI" => "Nicaragua",
							"NE" => "Niger",
							"NG" => "Nigeria",
							"NU" => "Niue",
							"NF" => "Norfolk Island",
							"MP" => "Northern Mariana Islands",
							"NO" => "Norway",
							"OM" => "Oman",
							"PK" => "Pakistan",
							"PW" => "Palau",
							"PS" => "Palestinian Territory, Occupied",
							"PA" => "Panama",
							"PG" => "Papua New Guinea",
							"PY" => "Paraguay",
							"PE" => "Peru",
							"PH" => "Philippines",
							"PN" => "Pitcairn",
							"PL" => "Poland",
							"PT" => "Portugal",
							"PR" => "Puerto Rico",
							"QA" => "Qatar",
							"RE" => "Reunion",
							"RO" => "Romania",
							"RU" => "Russian Federation",
							"RW" => "Rwanda",
							"SH" => "Saint Helena",
							"KN" => "Saint Kitts and Nevis",
							"LC" => "Saint Lucia",
							"PM" => "Saint Pierre and Miquelon",
							"VC" => "Saint Vincent and The Grenadines",
							"WS" => "Samoa",
							"SM" => "San Marino",
							"ST" => "Sao Tome and Principe",
							"SA" => "Saudi Arabia",
							"SN" => "Senegal",
							"RS" => "Serbia",
							"SC" => "Seychelles",
							"SL" => "Sierra Leone",
							"SG" => "Singapore",
							"SK" => "Slovakia",
							"SI" => "Slovenia",
							"SB" => "Solomon Islands",
							"SO" => "Somalia",
							"GS" => "South Georgia and The South Sandwich Islands",
							"ES" => "Spain",
							"LK" => "Sri Lanka",
							"SD" => "Sudan",
							"SR" => "Suriname",
							"SJ" => "Svalbard and Jan Mayen",
							"SZ" => "Swaziland",
							"SE" => "Sweden",
							"CH" => "Switzerland",
							"SY" => "Syrian Arab Republic",
							"TW" => "Taiwan, Province of China",
							"TJ" => "Tajikistan",
							"TZ" => "Tanzania, United Republic of",
							"TH" => "Thailand",
							"TL" => "Timor-leste",
							"TG" => "Togo",
							"TK" => "Tokelau",
							"TO" => "Tonga",
							"TT" => "Trinidad and Tobago",
							"TN" => "Tunisia",
							"TR" => "Turkey",
							"TM" => "Turkmenistan",
							"TC" => "Turks and Caicos Islands",
							"TV" => "Tuvalu",
							"UG" => "Uganda",
							"UA" => "Ukraine",
							"AE" => "United Arab Emirates",
							"GB" => "United Kingdom",
							"US" => "United States",
							"UM" => "United States Minor Outlying Islands",
							"UY" => "Uruguay",
							"UZ" => "Uzbekistan",
							"VU" => "Vanuatu",
							"VE" => "Venezuela",
							"VN" => "Viet Nam",
							"VG" => "Virgin Islands, British",
							"VI" => "Virgin Islands, U.S.",
							"WF" => "Wallis and Futuna",
							"EH" => "Western Sahara",
							"YE" => "Yemen",
							"ZM" => "Zambia",
							"ZW" => "Zimbabwe");?>

				           	<select name="country" class="form-control">
							<?php
							foreach($countries as $key => $value) {?>
							<option value="<?= $key ?>" title="<?= htmlspecialchars($value) ?>"><?= htmlspecialchars($value) ?></option>
							<?php
							}
							?>
							</select>
				           	<!----------------------------------------->
				            </div>
				            <label>Select gender </label><br>
				            <div class="form-group">
				            	<label style="color:orange">Male &nbsp;</label><input type="radio" name="gender" value="m" checked />&nbsp;&nbsp;&nbsp;&nbsp;
				            	<label style="color:orange">Female&nbsp; </label><input type="radio"  name="gender"value="f"/>
				            </div> 	
				             
			              <label>Set password</label>
				            <div class="form-group">
				            	<input type="password" class="form-control" name="txt_upass" placeholder="Enter Password" required="required" data-error="Lastname is required."/>
				            </div>
				            <label>Confirm password</label>
				            <div class="form-group">
				            	<input type="password" class="form-control" name="txt_upass2" placeholder="Confirm Password" required="required" data-error="Lastname is required."/>
				            </div>
				            <p style="color:red;"><?php echo $error_message;?></p>
				            <div class="clearfix"></div>
				            <div class="form-group">
				            	<button type="submit" class="btn btn-primary" name="btn-signup">
				                	SIGN UP
				                </button>
				            </div>
				            <br/>
				            <label>have an account ? <a href="logins.php">Sign in</a></label>
		        	</form>
		        </div>
		        <br>
	</div>
	<div class="col-md-4">
    </div>
</div>
</body>
</html>