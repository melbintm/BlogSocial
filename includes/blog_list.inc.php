<?php

include_once 'db_connect.php';
include_once 'functions.php';

if (login_check($mysqli) == true)
{
    $login = true;
}
else
{
    $login = false;
}

$overview_class = "";
$remove_class = "";
$new_class = "";
$insight_class = "";

$header = "";

$result = "";



if(!$login)
{
	if(isset($_GET['link']))
	{
		//$link id either OVERVIEW, NEW REMOVE or INSIGHT
		$link = filter_input(INPUT_GET, 'link', FILTER_SANITIZE_STRING);
		if($link == "INSIGHT")
		{
			//Goto Insights page
			$insight_class = "class='active'";
			$header = "Insights";


		}
		else if($link == 'REMOVE')
		{
			//Goto Remove blog page
			$remove_class = "class='active'";
			$header = "Remove a blog";
		}
		else if($link == 'NEW')
		{
			//Goto create new blog page
			$new_class = "class='active'";
			$header = "Create a new blog";
		}
		else
		{
			//Goto Overview page
			$link = "OVREVIEW";
			$overview_class = "class='active'";
			$header = "Overview";
			$result = call_overview();
		}
	}
	else
	{
		$link = "OVERVIEW";
		$overview_class = "class='active'";
		$result = call_overview();
	}
}
else
{
	header('Location: ./index.php');
}

function call_overview()
{
	//Goto Overview page


	$blog_id = "";
	$blog_name = "Blog Name ";
	$result = "";
	for($i = 1; $i <= 6; $i++)
	{
		$blog_name_temp = $blog_name . $i;
		$blog_id = $i;
		$result .= "	<a href='#'' id='{$blog_id}''>
						<div class='tile double bg-green'>
							<div class='tile-content icon'>
								<i class='icon-grid-view'></i>
							</div>
							<div class='brand bg-black'>
								<span class='label fg-white'>{$blog_name_temp}</span>
							</div>
						</div>
					</a>";
	}


	return $result;
}

?>