<!doctype html>

<?php

    include_once 'includes/functions.php';
    include_once 'includes/conversations.inc.php';

    $url = esc_url($_SERVER['PHP_SELF']);
?>
<html>
	<head>
		<title>
			Conversations
		</title>
		<link href="css/metro-bootstrap.css" rel="stylesheet">
        <link href="css/metro-bootstrap-responsive.css" rel="stylesheet">
        <link href="css/iconFont.css" rel="stylesheet">
        <!--<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">-->
        <!--<link href="js/prettify/prettify.css" rel="stylesheet">-->


        <!-- Load JavaScript Libraries -->
        <!--Conversation Bubble CSS -->

        <script type="text/JavaScript" src="js/sha512.js"></script>
        <script type="text/JavaScript" src="js/form.js"></script>

        <script src="js/jquery/jquery.min.js"></script>
        <script src="js/jquery/jquery.widget.min.js"></script>
        <script src="js/jquery/jquery.mousewheel.js"></script>
        <!--<script src="js/prettify/prettify.js"></script>-->

        <!-- Metro UI CSS JavaScript plugins -->
        <script src="js/load-metro.js"></script>
        <link rel="stylesheet" href="css/style.css">
        <link rel="stylesheet" href="css/thread.css">

	</head>
	<body class="metro">
		<header class="bg-light">
			<nav class="navigation-bar dark">
				<nav class="navigation-bar-content container">
                    <div class="element">
                        <a href="index.php">
                            <span class="icon-grid-view"></span>
                            BLOG+SOCIAL
                        </a>
                    </div>
                    <span class="element-divider"></span>

                    <?php
                        if ($login==true) {
                            echo  "
                                    <span class='element-divider place-right'></span>

                                    

                                    <div class='element place-right'>
                                        <a href='includes/logout.php'><span class='icon-switch'></span></a>
                                    </div>
                                    <div class='element place-right'>
                                        <a href='#'><span class='icon-cog'></span></a>
                                    </div>
                                    <div class='element place-right'>
                                        <a href='conversations.php'><span class='icon-mail'></span></a>
                                    </div>
                                    <a class='element brand place-right fg-blue' href='#'>Hey, {$_SESSION['first_name']}!</span></a>";
                        }
                        else
                        {
                            echo '  <div class="element place-right">
                                        <a href="login.php"><span class="icon-enter-2"></span></a>
                                    </div>';
                        }

                    ?>


                    <div class="element input-element">
                        <form>
                            <div class="input-control text">
                                <input type="text" placeholder="Search">
                                <button class="btn-search"></button>
                            </div>
                        </form>
                    </div>

                </nav>
            </nav>
            <div class="container">
                <nav class="horizontal-menu">
                    <ul>
                        <li><a href="#">Reader</a></li>
                        <li><a href="#">Blogs</a></li>
                        <li><a href="#">Following</a></li>
                        <li><a href="#">Followers</a></li>
                    </ul>
                </nav>
			</div>	
		</header>	
		<main>
			<div class="container">
                <div class="grid">
                    <div class="row">
                        <div class="span4">
                            <nav class="sidebar light">
                                <ul>
                                    <?php
                                        echo "  <li class='title'>Conversations</li>
                                                <li {$message_class}>
                                                    <a href='{$url}?link=CONV'>
                                                        Threads
                                                    </a>
                                                </li>
                                                <li {$new_class}>
                                                    <a href='{$url}?link=NEW'>
                                                        New
                                                    </a>
                                                </li>";
                                    ?>                                
                                    <!-- <li class="title">Messaging</li>
                                    <li class="active">
                                        <a href="#">
                                            Conversations
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            New
                                        </a>
                                    </li> -->
                                </ul>
                            </nav>
                        </div>
                        <div class="span8">
                        <h1>
                            <?php
                                echo $header;
                            ?>
                        </h1>
                            
                            <?php
                                echo $result;
                            ?>

                            <!-- <div class="listview-outlook">
                                <a href="#" class="list">
                                    <div class="list-content">
                                        <span class="list-title">melbin@live.com</span>
                                        <span class="list-subtitle">3/3/2015</span>
                                        <span class="list-remark">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Omnis, dicta, delectus.</span>
                                    </div>
                                </a>
                            </div> -->
                        </div>
                    </div>
                </div>
            </div>
		</main>
        <script>
            $(document).ready(function(){
                $(".me_message_holder").scrollTop(1000);
            });
        </script>
	</body>
</html> 