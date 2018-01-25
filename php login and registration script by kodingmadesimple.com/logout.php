<?php
session_start();

if(isset($_SESSION['uid'])) {
	session_destroy();
	unset($_SESSION['uid']);
	unset($_SESSION['name']);
	header("Location: login.html");
} else {
	header("Location: index.php");
}
?>