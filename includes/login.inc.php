<?php
include_once 'db_connect.php';
include_once 'functions.php';
 
sec_session_start();
$error_msg = "";

if(isset($_POST['email'], $_POST['p']))
{
	$email = $_POST['email'];
	$password = $_POST['p'];

	if(login($email, $password, $mysqli) == true)
	{
		header('Location: ../index.html');
	}
	else
	{
		$error_msg = "<p class='error'>Wrong email or password.</p>";
		error_log("Wrong email or password.");
	}
}