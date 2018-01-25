<?php
error_reporting(E_ALL); ini_set('display_errors', 1);

session_start();

if(isset($_SESSION['uid'])) {
	header("Location: index.php");
}

include_once 'includes/dbconnect.php';

//set validation error flag as false
$error = false;

//check if form is submitted
if (isset($_POST['signup'])) {
	$name = mysqli_real_escape_string($link, $_POST['name']);
	$email = mysqli_real_escape_string($link, $_POST['email']);
	$password = mysqli_real_escape_string($link, $_POST['password']);
	$cpassword = mysqli_real_escape_string($link, $_POST['cpassword']);
	$loc = mysqli_real_escape_string($link, $_REQUEST  ['loc']);
	$dob = mysqli_real_escape_string($link, $_REQUEST  ['dob']);
	$desc = mysqli_real_escape_string($link, $_REQUEST  ['desc']);
	$exp = mysqli_real_escape_string($link, $_REQUEST  ['exp']);
	$gender = mysqli_real_escape_string($link, $_REQUEST  ['gender']);
	
	//name can contain only alpha characters and space
	if (!preg_match("/^[a-zA-Z ]+$/",$name)) {
		$error = true;
		$name_error = "Name must contain only alphabets and space";
	}
	//Email can contain a valid email only
	if(!filter_var($email,FILTER_VALIDATE_EMAIL)) {
		$error = true;
		$email_error = "Please Enter Valid Email ID";
	}
	//Password must be 6 or more letters
	if(strlen($password) < 6) {
		$error = true;
		$password_error = "Password must be minimum of 6 characters";
	}
	//passwords must match
	if($password != $cpassword) {
		$error = true;
		$cpassword_error = "Password and Confirm Password doesn't match";
	}
	
	if(empty($loc) && strlen($loc) < 8) {
		$error = true;
		$loc_error = "Please enter a valid Postcode!";
	}
	if(empty($dob)) {
		$error = true;
		$dob_error = "Please enter your date of birth";
	}
	if(empty($desc)) {
		$error = true;
		$desc_error = "Please enter a short description of yourself";
	}
	if(empty($exp)) {
		$error = true;
		$exp_error = "Please enter your experience level";
	}
	if(empty($gender)) {
		$error = true;
		$gender_error = "Please enter your gender";
	}
	
		
	//continue with insert into DB
	if (!$error) {
		if(mysqli_query($con, "INSERT INTO users(experience,description,gender,dob,loc,name,email,password) VALUES('" . $exp . "', '" . $desc . "', '" . $gender . "', '" . $dob. "', '" . $loc . "','" . $name . "', '" . $email . "', '" . md5($password) . "')")) {
			$successmsg = "Successfully Registered! <a href='login.html'>Click here to Login</a>";
		} else {
			$errormsg = "Error in registering...Please try again later!";
		}
	}
}
?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<head>
 <!--
        Customize this policy to fit your own app's needs. For more guidance, see:
            https://github.com/apache/cordova-plugin-whitelist/blob/master/README.md#content-security-policy
        Some notes:
            * gap: is required only on iOS (when using UIWebView) and is needed for JS->native communication
            * https://ssl.gstatic.com is required only on Android and is needed for TalkBack to function properly
            * Disables use of inline scripts in order to mitigate risk of XSS vulnerabilities. To change this:
                * Enable inline JS: add 'unsafe-inline' to default-src
        -->
 

    <!-- Required meta tags-->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=no, minimal-ui">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="format-detection" content="telephone=no">
    <meta name="msapplication-tap-highlight" content="no">
    
	<script src="http://code.jquery.com/jquery-1.11.3.min.js"></script>
    <script src="jQuery/jqueryMobile/jquery.mobile-1.4.5.js"></script>
    <link rel="stylesheet" type="text/css" href="jQuery/jqueryMobile/jquery.mobile-1.4.5.css">
    <script src="jQuery/jquery-ui-1.12.1/jquery-ui.js"></script>
    <link rel="stylesheet" type="text/css" href="jQuery/jquery-ui-1.12.1/jquery-ui.css">
    
<title>Come Climb With Me</title>
<script type="text/javascript" src="cordova.js"></script>
<script src="JS/slidetabs.js" type="text/javascript"></script>
<link rel="stylesheet" href="CSS/CCWM.css" type="text/css">
</head>
</head>

<body>

<!--LOGIN OR SIGN UP PAGE------------------>    
    <div data-role="page" id="setup">
  		
   		<div data-role="main">
            
           
           
                <h1>Sign Up</h1>
        	<p><form data-ajax="false" action="signupScript1.1.php" method="POST">
              <div class="ui-field-contain">
     <table size="450px" align="center" id="formedit"><!--cannot get id formedit to style-->
         <tr>
         	<td>
            	<?php if(!empty($success_message)) { ?>	
<div class="success-message"><?php if(isset($success_message)) echo $success_message; ?></div>
<?php } ?>
<?php if(!empty($error_message)) { ?>	
<div class="error-message"><?php if(isset($error_message)) echo $error_message; ?></div>
<?php } ?>
			</td>
         </tr>
         <tr>
            <td align="top">
                 <label for="exp">EXPERIENCE&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                   <select name="exp" id="exp">
                    <option value="choice">SELECT OPTION</option>
                    <option value="beginner">BEGINNER</option>
                    <option value="intermediate">INTERMEDIATE</option>
                    <option value="intermediate">ADVANCED</option>
                </select>
                <span class="text-danger"><?php if (isset($exp_error)) echo $exp_error; ?></span>
            </td>
         </tr>
         <tr>
           <td align="top">
               <label for="gender">GENDER&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                 <select name="gender">
                    <option value="choice">SELECT OPTION</option>
                    <option value="female">FEMALE</option>
                    <option value="male">MALE</option>
                 </select>
                 <span class="text-danger"><?php if (isset($gender_error)) echo $gender_error; ?></span>
           </td>   
       </tr>
         <tr>
            <td align="top">
                 <label for="name">NAME&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                 <input type="text" name="name" required value="" id="name" size="20" data-clear-btn="true">
                 <span class="text-danger"><?php if (isset($name_error)) echo $name_error; ?></span>
           </td>
         </tr>
          <tr>
            <td align="top">
                 <label for="loc">Post Code&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                 <input type="text" name="loc" value="" id="loc" required data-clear-btn="true">
                 <span class="text-danger"><?php if (isset($loc_error)) echo $loc_error; ?></span>
           </td>
         </tr>
          <tr>
            <td align="top">
                 <label for="email">EMAIL</label>
                <input type="email" name="email" value="" id="email" required size="30" data-clear-btn="true">
                <span class="text-danger"><?php if (isset($email_error)) echo $email_error; ?></span>
            </td>
        </tr>
          <tr>
            <td align="top">
                 <label for="password">Password</label>
                <input type="password" name="password" value="" id="password" required size="30" data-clear-btn="true">
                <span class="text-danger"><?php if (isset($password_error)) echo $password_error; ?></span>
            </td>
        </tr>
        <tr>
            <td align="top">
                 <label for="confirm_password">Confirm Password</label>
                <input type="password" name="confirm_password" value="" id="confirm_password" required size="30" data-clear-btn="true">
                <span class="text-danger"><?php if (isset($cpassword_error)) echo $cpassword_error; ?></span>
            </td>
        </tr>
         <tr>
            <td align="top">
                 <label for="dob">DATE OF BIRTH</label>
                <input type="date" name="dob" value="" id="dob" size="20" required data-clear-btn="true">
                <span class="text-danger"><?php if (isset($dob_error)) echo $dob_error; ?></span>
            </td>
        </tr>
        <tr>
           <td>
               <label for="desc">DESCRIPTION&nbsp;&nbsp;</label>
               <textarea name="desc" id="desc" data-clear-btn="true"></textarea>
           </td>   
       </tr>
        <tr>
           <td>
               <label for="terms">Please confirm you have read and agree by the terms and conditions &nbsp;&nbsp;</label>
			   <input type="checkbox" name="terms" id="terms" required/>
           </td>   
       </tr>
       <tr>
          <td>
             <input type="submit" data-inline="true" value="SAVE" data-iconpos="left" data-corners="true" id="profilebtn" re>
          </td>
      </tr>
    </table>
   </div>
</form>
                </p>
 		 
        </div>
        </div>
</body>
</html>
