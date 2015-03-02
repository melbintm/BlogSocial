<?php
include_once 'includes/db_connect.php';
include_once 'includes/functions.php';
 
sec_session_start();

if (login_check($mysqli) == true)
{
    $login = true;
}
else
{
    $login = false;
}


	if($login == true)
	{
		// Access the TImeline dashboard
		echo print_timeline("Lorem ipsum dolor sit amet, consectetur adipisicing elit. Labore, neque.", "Lorem ipsum dolor sit amet, consectetur adipisicing elit.", 464645);
	}
	else
	{
		echo 'ERROR!!';
	}

print_timeline($content, $desc, $id)
{
	return '<div class="me_result" lstyle="background-color: green;">
        <div class="news">
            <div class="content">
                ' . $content . '
            </div>
            <div class="sub">
                ' . $desc . '
            </div>
        </div>
        <div class="options">
            <div class="toolbar transparent fg-gray">
                <button><i></i>Like</button>
                <button><i></i>Share</button>
                <button><i></i>Reblog</button>
                <button><i></i>Comment</button>
            </div>
        </div>
    </div>';
}