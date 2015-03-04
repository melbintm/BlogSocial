<?php

include_once 'db_connect.php';
include_once 'psl-config.php';

sec_session_start();

if (login_check($mysqli) == true)
{
    $login = true;
}
else
{
    $login = false;
}

$user_id = "";
$email = "";
$username = "";

$header = "";

$result = "";

$new_class = "";
$message_class = "";

if($login)
{
    //echo "ENTERED";
    $user_id = $_SESSION['user_id'];
    if(isset($_POST['message'], $_POST['to']))
    {
        $message = filter_input(INPUT_POST, 'message', FILTER_SANITIZE_STRING);
        $to_user = filter_input(INPUT_POST, 'to', FILTER_SANITIZE_STRING);

        $query = 'SELECT username, id from members
                    WHERE username = ?
                    LIMIT 1';

        error_log($to_user . " " . $message);

        if($stmt = $mysqli->prepare($query))
        {
            $stmt->bind_param('s', $to_user);
            $stmt->execute();
            $stmt->store_result();

            $sender_id = $_SESSION['user_id'];

            error_log('No of users : ' . $stmt->num_rows);

            if($stmt->num_rows == 1)
            {
                $stmt->bind_result($reciever_username, $reciever_id);
                $stmt->fetch();

                error_log("Reciever id : " . $reciever_id . " Sender_id : " . $sender_id);

                $query = 'INSERT INTO message(sender_id, reciever_id, message)
                            VALUES (?,?,?)';

                //$send_m = $mysqli->prepare($query);

                if($send_m = $mysqli->prepare($query))
                {
                    //error_log($send_m . "Entered");
                    $send_m->bind_param('iis', $sender_id, $reciever_id, $message);
                    error_log($sender_id . ' ' . $reciever_id . ' ' . $message);
                    if(!$send_m->execute())
                    {   
                        error_log("ERROR: " . $mysqli->error);
                        header('Location: ../error.php?err=Message cannot sent: INSERT');
                    }
                    error_log("Sent");
                }
                else
                {
                    error_log("ERROR  " . $mysqli->error);
                }
            }
            else
            {
                header("Location: ../error.php?err=Message cannot sent: User doesn't exists");
            }

        }


    }

    if(isset($_GET['link']))
    {
        //echo 'Eureka!!';
        $link = filter_input(INPUT_GET, 'link', FILTER_SANITIZE_STRING);
        if($link == 'NEW')
        {
            //echo 'Eureka!!';
            $header = "New Message";
            $new_class = "class='active'";

            $result = "<form action='" . esc_url($_SERVER['PHP_SELF']) . "' method='post'>
                                <div class='input-control text'>
                                    <input type='text' value='' placeholder='Username' name='to' id='to'/>
                                    <button class='btn-clear'></button>
                                </div>
                                <div class='input-control textarea'>
                                      <textarea placeholder='Your message...' name='message' id='message'></textarea>
                                </div>
                                <button>Send</button>
                            </form>";
        }
        else
        {
           /* $header = "New Messages";
            $link = "CONV";
            $message_class = "class='active'";*/

            $header  ='Messages';
            $link = "CONV";
            $message_class = "class='active'";
            $result = call_default($mysqli, $user_id);

        }
    }
    else
    {
        $header  ='Messages';
        $link = "CONV";
        $message_class = "class='active'";
        $result = call_default($mysqli, $user_id);
    }

    $user_id = $_SESSION['user_id'];
    //$query = "SELECT message_id, message, sent_date, sent_user, ";
}
else
{
    header('Location: index.php');
}

function call_default($mysqli, $user_id)
{
    
    //$message_class = "class='active'";

    $result = "";
    error_log("Entered into the call_default function");
    $query = "  SELECT 
                    all_t.new_id, all_t.message, all_t.sent_date, all_t.read
                FROM
                    (SELECT 
                        *
                    FROM
                        (SELECT 
                        message_id, message, sender_id new_id, sent_date, `read`
                    FROM
                        message
                    WHERE
                        reciever_id = ? UNION ALL SELECT 
                        message_id, message, reciever_id AS new_id, sent_date, `read`
                    FROM
                        message
                    WHERE
                        sender_id = ?) s
                    ORDER BY s.sent_date DESC) all_t
                GROUP BY all_t.new_id;
             ";

    if($stmt = $mysqli->prepare($query))
    {
        error_log($user_id);
        error_log("Query prepared");
        $stmt->bind_param('ii', $user_id, $user_id);
        $stmt->execute();
        error_log("Query ececuted");
        $stmt->bind_result($part_id, $message, $sent_time, $read);
        error_log("Varibales are binded. " . $stmt->num_rows);
        
        $result = "<div class='listview-outlook'>";
        while($stmt->fetch())
        {
            $message_length = strlen($message);
            if($message_length > 60)
            {
                $message = substr($message, 0, 60);
                $message = $message . "...";
            }

            error_log("Participant:  " . $part_id);

            $name = find_name(new mysqli(HOST, USER, PASSWORD, DATABASE), $part_id);   


            $isread = "";
            if($read == "NOTREAD");
                $isread = "marked";
            $result = $result . "<a href='#' class='list {$isread}'>
                                        <div class='list-content'>
                                            <span class='list-title'>{$name}</span>
                                            <span class='list-subtitle'>{$sent_time}</span>
                                            <span class='list-remark'>{$message}</span>
                                        </div>
                                </a>";
        }
    }

    $result = $result . "</div>";
    return $result;
}