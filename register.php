<?php
error_reporting(E_ALL); ini_set('display_errors', 1);
session_start();

if(isset($_SESSION['uid'])) {
	header("Location: index.php");
}

include_once 'includes/dbcon.php';

//set validation error flag as false
$error = false;

//check if form is submitted
if (isset($_POST['signup'])) {
	$name = mysqli_real_escape_string($link, $_POST['name']);
	$email = mysqli_real_escape_string($link, $_POST['email']);
	$password = mysqli_real_escape_string($link, $_POST['password']);
	$cpassword = mysqli_real_escape_string($link, $_POST['cpassword']);
	$loc = mysqli_real_escape_string($link, $_POST['loc']);
	$dob = mysqli_real_escape_string($link, $_POST['dob']);
	$desc = mysqli_real_escape_string($link, $_POST['desc']);
	$exp = mysqli_real_escape_string($link, $_POST['exp']);
	$gender = mysqli_real_escape_string($link, $_POST['gender']);
	
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
	
		$query = "INSERT INTO users(experience,description,gender,dob,loc,name,email,password) VALUES('" . $exp . "', '" . $desc . "', '" . $gender . "', '" . $dob. "', '" . $loc . "','" . $name . "', '" . $email . "', '" . md5($password) . "')";
		
	//continue with insert into DB
	
		if(mysqli_query($link, $query)) {
			$successmsg = "Successfully Registered! <a href='login.html'>Click here to Login</a>";
		} else {
			echo $query;
			$errormsg = "Error in registering...Please try again later!";
		}
	
}
?>

<!DOCTYPE html>
<html>
<head>
	<title>User Registration</title>
	<meta content="width=device-width, initial-scale=1.0" name="viewport" >
	<link rel="stylesheet" href="css/bootstrap.min.css" type="text/css" />
</head>
<body>

<nav class="navbar navbar-default" role="navigation">
	<div class="container-fluid">
		<!-- add header -->
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar1">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="index.php">Brand</a>
		</div>
		<!-- menu items -->
		<div class="collapse navbar-collapse" id="navbar1">
			<ul class="nav navbar-nav navbar-right">
				<li><a href="login.php">Login</a></li>
				<li class="active"><a href="register.php">Sign Up</a></li>
			</ul>
		</div>
	</div>
</nav>

<div class="container">
	<div class="row">
		<div class="col-md-4 col-md-offset-4 well">
			<form role="form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" name="signupform">
				<fieldset>
					<legend>Sign Up</legend>

					<div class="form-group">
						<label for="name">Name</label>
						<input type="text" name="name" placeholder="Enter Full Name" required value="<?php if($error) echo $name; ?>" class="form-control" />
						<span class="text-danger"><?php if (isset($name_error)) echo $name_error; ?></span>
					</div>
					
					<div class="form-group">
						<label for="name">Email</label>
						<input type="text" name="email" placeholder="Email" required value="<?php if($error) echo $email; ?>" class="form-control" />
						<span class="text-danger"><?php if (isset($email_error)) echo $email_error; ?></span>
					</div>

					<div class="form-group">
						<label for="name">Password</label>
						<input type="password" name="password" placeholder="Password" required class="form-control" />
						<span class="text-danger"><?php if (isset($password_error)) echo $password_error; ?></span>
					</div>

					<div class="form-group">
						<label for="name">Confirm Password</label>
						<input type="password" name="cpassword" placeholder="Confirm Password" required class="form-control" />
						<span class="text-danger"><?php if (isset($cpassword_error)) echo $cpassword_error; ?></span>
					</div>
                    
                    <div class="form-group">
						
                        <label for="exp">EXPERIENCE</label>
                   			<select name="exp" id="exp" required class="form-control">
                   				 <option value="choice">SELECT OPTION</option>
                   				 <option value="beginner">BEGINNER</option>
                   				 <option value="intermediate">INTERMEDIATE</option>
                   				 <option value="intermediate">ADVANCED</option>
                			</select>
               				 <span class="text-danger"><?php if (isset($exp_error)) echo $exp_error; ?></span>

					</div>
                    
                    <div class="form-group">
						
                        <label for="gender">GENDER</label>
                 			<select name="gender" required class="form-control">
                    			<option value="choice">SELECT OPTION</option>
                    			<option value="female">FEMALE</option>
                   			 	<option value="male">MALE</option>
                 			</select>
                			 <span class="text-danger"><?php if (isset($gender_error)) echo $gender_error; ?></span>

					</div>
                    
                    <div class="form-group">
           				<label for="loc">Post Code</label>
           					<input type="text" name="loc" value="" id="loc" required data-clear-btn="true" class="form-control">
                			<span class="text-danger"><?php if (isset($loc_error)) echo $loc_error; ?></span>
					</div>
                    
                    <div class="form-group">
                    	<label for="dob">DATE OF BIRTH</label>
                			<input type="date" name="dob" value="" id="dob" size="20" required data-clear-btn="true" class="form-control">
                			<span class="text-danger"><?php if (isset($dob_error)) echo $dob_error; ?></span>
                    </div>
                    
                    <div class="form-group">
                 	   <label for="desc">DESCRIPTION&nbsp;&nbsp;</label>
               				<textarea name="desc" id="desc" data-clear-btn="true" required class="form-control"></textarea>
                    </div>
                    
                    <div class="form-group">
                       <label for="terms">Please confirm you have read and agree by the terms and conditions &nbsp;&nbsp;</label>
			   				<input type="checkbox" name="terms" id="terms" required class="form-control"/>
                    </div>
                    
                   
					<div class="form-group">
						<input type="submit" name="signup" value="Sign Up" class="btn btn-primary" />
					</div>
				</fieldset>
			</form>
			<span class="text-success"><?php if (isset($successmsg)) { echo $successmsg; } ?></span>
			<span class="text-danger"><?php if (isset($errormsg)) { echo $errormsg; } ?></span>
		</div>
	</div>
	<div class="row">
		<div class="col-md-4 col-md-offset-4 text-center">	
		Already Registered? <a href="php login and registration script by kodingmadesimple.com/login.php">Login Here</a>
		</div>
	</div>
</div>
<script src="php login and registration script by kodingmadesimple.com/js/jquery-1.10.2.js"></script>
<script src="php login and registration script by kodingmadesimple.com/js/bootstrap.min.js"></script>
</body>
</html>



