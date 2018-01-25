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

//
//// Include config file
//error_reporting(E_ALL); ini_set('display_errors', 1);
//
//include ("includes/dbcon.php");
//
//$name = mysqli_real_escape_string($link, $_REQUEST  ['name']); 
//$loc = mysqli_real_escape_string($link, $_REQUEST  ['loc']);
//$dob = mysqli_real_escape_string($link, $_REQUEST  ['dob']);
//$desc = mysqli_real_escape_string($link, $_REQUEST  ['desc']);
//$exp = mysqli_real_escape_string($link, $_REQUEST  ['exp']);
//$gender = mysqli_real_escape_string($link, $_REQUEST  ['gender']);
//$email = mysqli_real_escape_string($link, $_REQUEST ['email']);
//$password = mysqli_real_escape_string($link, $_REQUEST ['password']);
//
///* Validation to check if Terms and Conditions are accepted */
//if(!isset($error_message)) {
//	if(!isset($_POST["terms"])) {
//	$error_message = "Accept Terms and Conditions to Register";
//	}
//}
//      
// if(!empty($name) && !empty($loc) && !empty($dob) && !empty($desc) && !empty($exp)&& !empty($gender) && !empty($demail)&& !empty($password)){
//        
//        // Prepare an insert statement
//$sql = mysqli_query($link, "INSERT INTO 'users' ('experience','gender','name','PASSWORD','dob','email','loc') 
//values ('$experience','$gender','$name', '$password' ,'$dob','$email','$loc',)");
//         if($result){
//			 
//        //if($stmt = mysqli_prepare($link, $sql)){
//            // Bind variables to the prepared statement as parameters
//          //  mysqli_stmt_bind_param($stmt, "ss", $param_email, $param_password);
//            
//            // Set parameters
//            //$param_email = $email;
//            //$param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
//            
//            // Attempt to execute the prepared statement
//            //if(mysqli_stmt_execute($stmt)){
//                // Redirect to login page
//                header("location:login.html");
//            } else{
//                 header("location:login.html");
//				//echo "Something went wrong. Please try again later.";
//            }
//		}
//	
?>