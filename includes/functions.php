<?php
include_once 'psl-config.php';


///////////secure session function
function sec_session_start() {
	$session_name = 'sec_session_id';
	$secure = SECURE;
	
	$httponly = true;

	if(ini_set('session.use_only_cookies', 1) === FALSE) {
		header("Location: ..//error.php?err=Could not initiate a safe session (ini_set)");
		exit();
	}

	$cookieParams = session_get_cookie_params();
	session_set_cookie_params($cookieParams["lifetime"],
		$cookieParams["path"],
		$cookieParams["domain"],
		$secure,
		$httponly);

	session_name($session_name);
	session_start();
	session_regenerate_id(true);
}



//////////login function
function login($email, $password, $mysqli)
{

	if($stmt = $mysqli->prepare("SELECT id, username, password, salt, first_name, last_name
		FROM members
		WHERE email = ?
		LIMIT 1"))
	{

		$stmt->bind_param('s', $email);
		$stmt->execute();
		$stmt->store_result();

		$stmt->bind_result($user_id, $username, $db_password, $salt, $first_name, $last_name);
		$stmt->fetch();

		$password = hash('sha512', $password . $salt);
		if($stmt->num_rows == 1)
		{
			if(checkbrute($user_id, $mysqli) == true)
			{
				return false;
			} else {
				if ($db_password == $password) {
					//Paswword is correct

					//Get the user-agent string of the user.
					$user_browser = $_SERVER['HTTP_USER_AGENT'];
					
					//XSS protection
					$user_id = preg_replace("/[^0-9]+/", "", $user_id);
					$_SESSION['user_id'] = $user_id;

					//XSS protection 
					$username = preg_replace("/[^a-zA-Z0-9_\-]+/", "", $username);

					$first_name = preg_replace("/[^a-zA-Z0-9_\-]+/", "", $first_name);
					$last_name = preg_replace("/[^a-zA-Z0-9_\-]+/", "", $last_name);

					$_SESSION['first_name'] = $first_name;
					$_SESSION['last_name'] = $last_name;

					$_SESSION['username'] = $username;
					$_SESSION['login_string'] = hash('sha512', $password . $user_browser);
					//Login Successful
					return true;
				} else {
					//Password is not correct
					$now = time();
					$mysqli->query("INSERT INTO login_attempts(user_id, time)
						VALUES ('$user_id', '$now')");
					return false;
				}
			}
		} else {
			//No user exists.
			return false;
		}
	}
}



////////////////Brute force function
function checkbrute($user_id, $mysqli) {
	$now = time();
 
	$valid_attempts = $now - (2 * 60 * 60);

	if($stmt = $mysqli->prepare("SELECT time
		FROM login_attempts
		WHERE user_ID = ?
		AND time > '$valid_attempts'"))
	{
		$stmt->bind_param('i', $user_id);

		$stmt->execute();
		$stmt->store_result();

		if($stmt->num_rows > 5)
		{
			return true;
		} else {
			return false;
		}
	}
}


////////TO Check logged in status
function login_check($mysqli) {
	////Check session variables are set
	if(isset($_SESSION['user_id'], $_SESSION['username'], $_SESSION['login_string']))
	{
		$user_id = $_SESSION['user_id'];
		$login_string = $_SESSION['login_string'];
		$username = $_SESSION['username'];

		$user_browser = $_SERVER['HTTP_USER_AGENT'];

		if($stmt = $mysqli->prepare("SELECT password FROM members WHERE id = ? LIMIT 1"))
		{
			$stmt->bind_param('i', $user_id);
			$stmt->execute();
			$stmt->store_result();

			if ($stmt->num_rows == 1)
			{
				$stmt->bind_result($password);
				$stmt->fetch();
				$login_check = hash('sha512', $password . $user_browser);

				if($login_check == $login_string) {
					return true;
				} else {
					return false;
				}
			} else {
				return false;
			}
		} else {
			return false;
		}
	} else {
		return false;
	}
}


/////////Sanitize PHP_SELF
function esc_url($url) {
	if('' == $url) {
		return $url;
	}

	$url = preg_replace('|[^a-z0-9-~+_.?#=!&;,/:%@$\|*\'()\\x80-\\xff]|i', '', $url);

	$strip = array('%0d', '%0a', '%0D', '%0A');
	$url = (string) $url;

	$count = 1;
	while($count) {
		$url = str_replace($strip, '', $url, $count);
	}

	$url = str_replace(';//', '://', $url);

	$url = htmlentities($url);

	$url = str_replace('&amp;', '&#038;', $url);
	$url = str_replace("'", '&#039;', $url);

	if($url[0] !== '/') {
		return '';
	} else {
		return $url;
	}
}



/////////Load Posts

function append_posts($type, $start)
{
	//type should be wither TREND, TIMELINE or BOOK



	//Perform some Loop to read one by one.

	$return_stmt = "";
	$post_auther = 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Sequi, dolorum.';
	$post_title = 'Lorem ipsum dolor sit amet.';
	$post_id = '4589';
	$post_cont = 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eveniet, architecto!';


	if($type == "TREND")
	{
		$post_title = $type . ': ' . $post_title;
	}

	$return_stmt = $return_stmt . '<div class="me_result">
	        <div class="news">
	            <div class="content">
	                ' . $post_title . '
	            </div>
	            <div class="sub">
	                ' . $post_cont . '
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

	return $return_stmt;

}



/////////FInd the Name using id ////

function find_name($mysqli, $user_id)
{
	$query = "SELECT first_name, last_name FROM
				members WHERE id = ?";
	$name = "";
	//error_log("The id : " . $user_id);
	if($stmt = $mysqli->prepare($query))
	{
		$stmt->bind_param('i', $user_id);
		if($stmt->execute())
		{
			$stmt->store_result();
			//error_log("FIND NAME: " . $stmt->num_rows);
			if($stmt->num_rows == 1)
			{
				$stmt->bind_result($first_name, $last_name);
				$stmt->fetch();
				$name = $first_name . " " . $last_name;
			}
			else
			{
				$name = "ERROR1!";
			}
		}
		else
		{
			$name = "ERROR2!";
		}
	}
	else
	{
		error_log("FIND NAME " . $mysqli->error);
	}
	$stmt->close();
	return $name;
}


function read_message($mysqli, $sender_id, $reciever_id)
{
	error_log("READ_MESSAGE: {$sender_id} {$reciever_id}");
	$query = "UPDATE message set `read`='READ' WHERE reciever_id = {$reciever_id} AND sender_id = {$sender_id}";
	$mysqli->query($query);
	error_log($mysqli->error);
}

function find_username($mysqli, $user_id)
{
	$query = "SELECT username from members WHERE id=?";
	$username = '';
	if($stmt = $mysqli->prepare($query))
	{
		$stmt->bind_param('i', $user_id);
		if($stmt->execute())
		{
			$stmt->store_result();
			$stmt->bind_result($username);
			$stmt->fetch();
			error_log("FOUND USERNAME: {$username}");
		}
		$stmt->close();
	}
	return $username;
}

function is_msg_read($mysqli, $part_id, $user_id)
{
	$query = "	SELECT 
				    sender_id, reciever_id, message.read
				FROM
				    message
				WHERE
				    (sender_id = ? AND reciever_id = ?)
				        OR (sender_id = ? AND reciever_id = ?)
				ORDER BY sent_date DESC
				LIMIT 1;";
	//error_log("Called");
	if($stmt = $mysqli->prepare($query))
	{
		//error_log("Query prepared");
		$stmt->bind_param('iiii', $user_id, $part_id, $part_id, $user_id);
		$stmt->execute();
		$stmt->store_result();
		if($stmt->num_rows == 1)
		{
			//error_log("One row");
			$stmt->bind_result($sender_id, $reciever_id, $read);
			$stmt->fetch();
			//error_log($sender_id . " " . $reciever_id . " " . $read);
			if($sender_id == $user_id)
			{
				//error_log("READ1");
				return "READ";
			}
			else if($read == "READ")
			{
				//error_log("READ2");
				return "READ";
			}
			else
			{
				//error_log("NOTREAD");
				return "NOTREAD";
			}
		}

	}
	else
	{
		error_log($mysqli->error);
	}
}

function count_unread($mysqli, $part_id, $user_id)
{
	$query = "	SELECT 
					count(*)
				FROM
					message
				WHERE
					(sender_id = ? AND reciever_id = ?) AND `read`='NOTREAD'
				ORDER BY sent_date DESC;";
	//error_log("Called");
	if($stmt = $mysqli->prepare($query))
	{
		//error_log("Query prepared");
		$stmt->bind_param('ii', $part_id, $user_id);
		$stmt->execute();
		$stmt->store_result();
		if($stmt->num_rows == 1)
		{
			//error_log("One row");
			$stmt->bind_result($count);
			$stmt->fetch();
			//error_log($sender_id . " " . $reciever_id . " " . $read);
			return $count;
		}
		else
		{
			return 0;
		}

	}
	else
	{
		error_log($mysqli->error);
	}
}