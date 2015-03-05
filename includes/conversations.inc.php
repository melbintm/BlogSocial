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
        //error_log("ENTERED!!!!!!!!");
        $message = filter_input(INPUT_POST, 'message', FILTER_SANITIZE_STRING);
        $to_user = filter_input(INPUT_POST, 'to', FILTER_SANITIZE_STRING);

        $query = 'SELECT username, id from members
                    WHERE username = ?
                    LIMIT 1';

        //error_log($to_user . " " . $message);

        if($stmt = $mysqli->prepare($query))
        {
            //error_log("Second Entered>>>>>");
            $stmt->bind_param('s', $to_user);
            $stmt->execute();

            $stmt->store_result();
            //error_log($mysqli->error . " " . $stmt->num_rows);

            $sender_id = $_SESSION['user_id'];

            //error_log('No of users : ' . $stmt->num_rows);

            if($stmt->num_rows == 1)
            {
                //error_log("Third Entered>>>>>");
                $stmt->bind_result($reciever_username, $reciever_id);
                $stmt->fetch();

                //error_log("Reciever id : " . $reciever_id . " Sender_id : " . $sender_id);

                $query = 'INSERT INTO message(sender_id, reciever_id, message)
                            VALUES (?,?,?)';

                //$send_m = $mysqli->prepare($query);

                if($send_m = $mysqli->prepare($query))
                {
                    //error_log($send_m . "Entered");
                    $send_m->bind_param('iis', $sender_id, $reciever_id, $message);
                    //error_log($sender_id . ' ' . $reciever_id . ' ' . $message);
                    if(!$send_m->execute())
                    {
                        error_log("ERROR: " . $mysqli->error);
                        header('Location: ../error.php?err=Message cannot sent: INSERT');
                    }
                    $send_m->close();
                    //error_log("Sent a message");
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
            $stmt->close();

        }
        if(isset($_POST['conversation']))
        {
            $con_id = filter_input(INPUT_POST, 'conversation', FILTER_SANITIZE_STRING);
            header("Location: " . esc_url($_SERVER['PHP_SELF']) . "?part_id={$con_id}");
        }

    }

    if(isset($_GET['part_id']))
    {

        $chat_result = "";
        $part_id = filter_input(INPUT_GET, 'part_id', FILTER_SANITIZE_STRING);
        $header = find_name($mysqli, $part_id);
        $query = "  SELECT 
                        message_id, message, sender_id, sent_date, `read`
                    FROM
                        blogs.message
                    WHERE
                        (reciever_id = ? AND sender_id = ?)
                            OR (reciever_id = ? AND sender_id = ?) ORDER BY sent_date ASC LIMIT 20;";
        if($stmt = $mysqli->prepare($query))
        {
            $stmt->bind_param('iiii', $user_id, $part_id, $part_id, $user_id);
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($message_id, $message, $sender_id, $sent_date, $read);

            while($stmt->fetch())
            {
                read_message($mysqli, $part_id, $user_id);
                if($sender_id == $user_id)
                {
                    $sub_ = '';
                    if($read == 'READ')
                        $sub_ = "<span class='icon-glasses fg-cobalt'></span>";
                    $chat_result = $chat_result . " <div class='outgoing' id='{$message_id}'>
                                                        <div class='content-outgoing'>
                                                            <div class='message_id'>
                                                                <span class='message-o'>{$message}</span>
                                                            </div>
                                                            <div class='bubble-bottom'>
                                                                <span class='time-o'>{$sub_}&nbsp;{$sent_date}</span>
                                                            </div>
                                                            <div class='insert'></div>
                                                        </div>
                                                    </div>";
                }
                else
                {

                    $chat_result = $chat_result . "<div class='incoming' id='{$message_id}'>
                                                        <div class='content-incoming'>
                                                            <div class='message_id'>
                                                                <span class='message-i'>{$message}</span>
                                                            </div>
                                                            <div class='bubble-bottom'>
                                                                <span class='name-i'>&nbsp;</span>
                                                                <span class='time-i'>{$sent_date}</span></span>
                                                            </div>
                                                            <div class='insert'></div>
                                                        </div>
                                                    </div>";
                }
            }

            $result = "<div class='me_message_holder'>" . $chat_result;
            $result = $result . "   </div>
                                    <form action='" . esc_url($_SERVER['PHP_SELF']) . "' method='post'>
                                        <div class='grid'>
                                                <div class='row'>
                                                        <div class='span6'>
                                                            <div class='input-control text success-state'>
                                                                <input class='bg-green fg-white' type='text' name='message' id='_message' placeholder='Message'>
                                                                <button class='btn-clear'></button>
                                                            </div>
                                                            <input type='hidden' name='to' id='to' value='" . find_username($mysqli, $part_id) ."' />
                                                            <input type='hidden' name='conversation' id='conversation' value='{$part_id}' />'
                                                        </div>

                                                        <div class='span1'>
                                                            <button class='success'>
                                                                <span class='icon-arrow-right-2'></span>
                                                            </button>
                                                        </div>
                                                    <div class='span1'>
                                                        <a href='javascript:window.location.href=window.location.href' class='button info'>
                                                            <span class='icon-spin'></span>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>";


        }
        else
        {
            error_log($mysqli->error);
        }

    }

    else if(isset($_GET['link']))
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

            $header  ='Threads';
            //echo $header;
            $link = "CONV";
            $message_class = "class='active'";
            $result = call_default($mysqli, $user_id);

        }
    }
    else
    {
        $header  ='Threads';
        //echo $header;
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
    //error_log("Entered into the call_default function");
    $query = "  SELECT 
                    all_t.message_id, all_t.new_id, all_t.message, all_t.sent_date
                FROM
                    (SELECT 
                        *
                    FROM
                        (SELECT 
                        message_id, message, sender_id new_id, sent_date
                    FROM
                        message
                    WHERE
                        reciever_id = ? UNION ALL SELECT 
                        message_id, message, reciever_id AS new_id, sent_date
                    FROM
                        message
                    WHERE
                        sender_id = ?) s
                    ORDER BY s.sent_date DESC) all_t
                GROUP BY all_t.new_id
                ORDER BY all_t.sent_date DESC;
             ";

    if($stmt = $mysqli->prepare($query))
    {
        //error_log($user_id);
        //error_log("Query prepared");
        $stmt->bind_param('ii', $user_id, $user_id);
        $stmt->execute();
        $stmt->store_result();
        //error_log("Query ececuted");
        $stmt->bind_result($message_id, $part_id, $message, $sent_time);
        //error_log("Varibales are binded. " . $stmt->num_rows);
        
        $result = "<div class='listview-outlook'>";
        while($stmt->fetch())
        {
            $message_length = strlen($message);
            if($message_length > 60)
            {
                $message = substr($message, 0, 60);
                $message = $message . "...";
            }

            //error_log("Participant:  " . $part_id);

            $name = find_name(new mysqli(HOST, USER, PASSWORD, DATABASE), $part_id);   
            $count_unread = "";

            $isread = is_msg_read($mysqli, $part_id, $user_id);
            if($isread == "NOTREAD")
            {
                $isread = "marked";
                $count_unread = count_unread($mysqli, $part_id, $user_id);
            }
            else
                $isread = "";
            
            $result = $result . "<a href='" . esc_url($_SERVER['PHP_SELF']) . "?part_id={$part_id}' class='list {$isread}'>
                                        <div class='list-content'>
                                            <span class='list-title'>
                                                <span class='place-right smaller fg-cobalt'>{$count_unread}</span>
                                                {$name}
                                            </span>
                                            <span class='list-subtitle'>{$sent_time}</span>
                                            <span class='list-remark'>{$message}</span>
                                        </div>
                                </a>";
        }
    }
    else
    {
        error_log($mysqli->error);
    }

    $result = $result . "</div>";
    return $result;
}