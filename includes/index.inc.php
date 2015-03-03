<?php
include_once 'db_connect.php';
include_once 'functions.php';

$status = "";
$content = "";
$login = "";

if (login_check($mysqli) == true)
{
    $login = true;
}
else
{
    $login = false;
}




if(isset($_GET['status']))
{
	$status = filter_input(INPUT_GET, 'status', FILTER_SANITIZE_STRING);
}

if(!$login)
{
	if($status == 'BOOK')
	{
		//Perform a query to find the Bookmarked pages
		$result = append_posts('BOOK', 0);
		//$result ="Melbin";
	}

	else if($status == 'TREND') 
	{
		//Perform a query to find the Trending posts
		$result = append_posts('TREND', 0);
	}
	else //Only the TImeline even after its a wrong post request
	{
		//Perform to find the TImeline posts
		$status = "TIMELINE";
		$result = append_posts('TIMELINE', 0);
	}
}
else
{
	$status = "TREND";
	$result = append_posts('TREND', 0);
}

//echo $status;
?>