<!doctype html>

<?php

    include_once 'includes/functions.php';
    include_once 'includes/conversations.inc.php';

    $url = esc_url($_SERVER['PHP_SELF']);
?>
<html>
	<head>
		<title>
			Messaging Conversation
		</title>
		<link href="css/metro-bootstrap.css" rel="stylesheet">
        <link href="css/metro-bootstrap-responsive.css" rel="stylesheet">
        <link href="css/iconFont.css" rel="stylesheet">
        <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
        <!--<link href="js/prettify/prettify.css" rel="stylesheet">
        <link rel="stylesheet" href="css/style.css">-->

        <!-- Load JavaScript Libraries -->
        <!--Conversation Bubble CSS -->
        <!-- <link rel="stylesheet" href="css/conv.css"> -->

        <script type="text/JavaScript" src="js/sha512.js"></script>
        <script type="text/JavaScript" src="js/form.js"></script>

        <script src="js/jquery/jquery.min.js"></script>
        <script src="js/jquery/jquery.widget.min.js"></script>
        <script src="js/jquery/jquery.mousewheel.js"></script>
        <!--<script src="js/prettify/prettify.js"></script>-->

        <!-- Metro UI CSS JavaScript plugins -->
        <script src="js/load-metro.js"></script>

	</head>
	<body class="metro">
		<header class="bg-light">
			<nav class="navigation-bar dark">
				<nav class="navigation-bar-content container">
                    <div class="element">
                        <a href="#">
                            <span class="icon-grid-view"></span>
                            BLOG+SOCIAL
                        </a>
                    </div>
                    <span class="element-divider"></span>
                    <div class="element place-right">
                        <a href="#"><span class="icon-switch"></span></a>
                    </div>
                    <div class="element place-right">
                        <a href="#"><span class="icon-cog"></span></a>
                    </div>
                    <div class="element place-right">
                        <a href="#"><span class="icon-mail"></span></a>
                    </div>
                    <div class="element input-element place-right">
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
                                        echo "  <li class='title'>Messaging</li>
                                                <li {$message_class}>
                                                    <a href='{$url}?link=CONV'>
                                                        Conversations
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
	</body>
</html> 