<?php
include_once 'db_connect.php';
include_once 'psl-config.php';
 
$error_msg = "";
 
if (isset($_POST['username'], $_POST['email'], $_POST['p'], $_POST['gender'], $_POST['month'],
    $_POST['day'], $_POST['year'], $_POST['phone'], $_POST['first_name'], $_POST['last_name'])) {

    // Sanitize and validate the data passed in
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $email = filter_var($email, FILTER_VALIDATE_EMAIL);
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Not a valid email
        $error_msg .= '<p class="error">The email address you entered is not valid</p>';
    }
 
    $password = filter_input(INPUT_POST, 'p', FILTER_SANITIZE_STRING);
    if (strlen($password) != 128) {
        // The hashed pwd should be 128 characters long.
        // If it's not, something really odd has happened
        $error_msg .= '<p class="error">Invalid password configuration.</p>';
    }

    $first_name = filter_input(INPUT_POST, 'first_name', FILTER_SANITIZE_STRING);



    $last_name = filter_input(INPUT_POST, 'last_name', FILTER_SANITIZE_STRING);
    $gender = filter_input(INPUT_POST, 'gender', FILTER_SANITIZE_STRING);
    if(!(!strcmp($gender, 'MALE') || !strcmp($gender, 'FEMALE')))
    {
        $error_msg .= '<p class="error">Something went wrong [#0xGEND]. Try again.<p>';
    }


    $month = filter_input(INPUT_POST, 'month', FILTER_SANITIZE_STRING);
    $possible_months = array('01', '02', '03', '04',
                        '05', '06', '07', '08', '09',
                        '10', '11', '12');
    $flag = FALSE;
    for($i = 0; $i < 12; $i++)
    {
        if(!strcmp($month, $possible_months[$i]))
        {
            $flag = TRUE;
        }
    }

    if(!$flag)
    {
        $error_msg .= '<p class="error">Something went wrong [#0xMONTH]. Try again.<p>';
    }



    $day_options = array("options" => array("min_range" => 1, "max_range" => 31));
    $day = filter_input(INPUT_POST, 'day', FILTER_SANITIZE_NUMBER_INT);
    if(!filter_input(INPUT_POST, 'day', FILTER_VALIDATE_INT, $day_options))
    {
        $error_msg .= '<p class="error">Something went wrong [#0xDAY]. Try again.<p>';
    }
    $day_n = "";
    if($day > 0 && $day < 10)
    {
        $day_n = "0" . $day;
    }


    $year_options = array("options" => array("min_range" => 1905, "max_range" => 2015));
    $year = filter_input(INPUT_POST, 'year', FILTER_SANITIZE_NUMBER_INT);
    if(!filter_input(INPUT_POST, 'year', FILTER_VALIDATE_INT, $year_options))
    {
        $error_msg .= '<p class="error">Something went wrong [#0xYEAR]. Try again.<p>';
    }
    error_log("Year {$year}");
    $phone_no = filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_NUMBER_INT);

    // Username validity and password validity have been checked client side.
    // This should should be adequate as nobody gains any advantage from
    // breaking these rules.
    //
 
    $prep_stmt = "SELECT id FROM members WHERE email = ? LIMIT 1";
    $stmt = $mysqli->prepare($prep_stmt);
 
   // check existing email  
    if ($stmt) {
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $stmt->store_result();
 
        if ($stmt->num_rows == 1) {
            // A user with this email address already exists
            $error_msg .= '<p class="error">A user with this email address already exists.</p>';
            //$stmt->close();
        }
        $stmt->close();
    } else {
        $error_msg .= '<p class="error">Database error Line 39</p>';
                $stmt->close();
    }
 
    // check existing username
    $prep_stmt = "SELECT id FROM members WHERE username = ? LIMIT 1";
    $stmt = $mysqli->prepare($prep_stmt);
 
    if ($stmt) {
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $stmt->store_result();
 
                if ($stmt->num_rows == 1) {
                        // A user with this username already exists
                        $error_msg .= '<p class="error">A user with this username already exists</p>';
                        //$stmt->close();
                }
                $stmt->close();
        } else {
                $error_msg .= '<p class="error">Database error line 55</p>';
                $stmt->close();
        }
 
    // TODO: 
    // We'll also have to account for the situation where the user doesn't have
    // rights to do registration, by checking what type of user is attempting to
    // perform the operation.
 
    if (empty($error_msg)) {

        // Create a random salt
        //$random_salt = hash('sha512', uniqid(openssl_random_pseudo_bytes(16), TRUE)); // Did not work
        $random_salt = hash('sha512', uniqid(mt_rand(1, mt_getrandmax()), true));
 
        // Create salted password 
        $password = hash('sha512', $password . $random_salt);
    
        $dob = $day . '-' . $month . '-' . $year;

        // Insert the new user into the database 
        if ($insert_stmt = $mysqli->prepare("INSERT INTO
                members (username, email, password, salt, first_name,
                last_name, gender, dob, phone_no)
                VALUES
                (?, ?, ?, ?, ?, ?, ?, ?, ?)")) {
            $insert_stmt->bind_param("sssssssss", $username, $email, $password,
                $random_salt, $first_name, $last_name, $gender,
                $dob, $phone_no);

            error_log($username . " " . $email . " " . $password . " " . 
                $random_salt . " " . $first_name . " " . $last_name . " " . $gender . " " .
                $dob . " " . $phone_no);

            // Execute the prepared query.
            if (!$insert_stmt->execute()) {
                header('Location: ../error.php?err=Registration failure: INSERT');
            }
        }
        header('Location: ./register_success.php');
    }
}