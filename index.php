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
?>


<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Blog+Social</title>
        <link href="css/metro-bootstrap.css" rel="stylesheet">
        <link href="css/metro-bootstrap-responsive.css" rel="stylesheet">
        <link href="css/iconFont.css" rel="stylesheet">
        <!--<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">-->
        <!--<link href="js/prettify/prettify.css" rel="stylesheet">-->
        <link rel="stylesheet" href="css/style.css">

        <!-- Load JavaScript Libraries -->
        <script src="js/jquery/jquery.min.js"></script>
        <script src="js/jquery/jquery.widget.min.js"></script>
        <script src="js/jquery/jquery.mousewheel.js"></script>
        <!--<script src="js/prettify/prettify.js"></script>-->

        <script src="js/main.js"></script>

        <!-- Metro UI CSS JavaScript plugins -->
        <script src="js/load-metro.js"></script>

        <!-- Local JavaScript -->
        <!--<script src="js/docs.js"></script>
        <script src="js/github.info.js"></script>-->
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
                    <?php
                        if ($login==true) {
                            echo '  <div class="element place-right">
                                        <a href="includes/logout.php"><span class="icon-switch"></span></a>
                                    </div>
                                    <div class="element place-right">
                                        <a href="#"><span class="icon-cog"></span></a>
                                    </div>
                                    <div class="element place-right">
                                        <a href="#"><span class="icon-mail"></span></a>
                                    </div>';
                        }
                        else
                        {
                            echo '  <div class="element place-right">
                                        <a href="login.php"><span class="icon-enter-2"></span></a>
                                    </div>';
                        }

                    ?>
                    <!-- <div class="element place-right">
                        <a href="#"><span class="icon-switch"></span></a>
                    </div>
                    <div class="element place-right">
                        <a href="#"><span class="icon-cog"></span></a>
                    </div>
                    <div class="element place-right">
                        <a href="#"><span class="icon-mail"></span></a>
                    </div>
                     -->
                    
                    <!-- <div class="element place-right">
                        <a href="#"><span class="icon-enter-2"></span></a>
                    </div> -->


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


                                <?php
                                    if($login==true)
                                    {
                                        echo '<ul>
                                                <li class="title">Reader</li>
                                                <li class="active">
                                                    <a href="javascript:call_timeline();">
                                                        Timeline
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="#">
                                                        Trending
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="#">Bookmarked</a>
                                                </li>
                                            </ul>';
                                    }
                                    else 
                                    {
                                        echo '<ul>
                                                <li class="title">Reader</li>
                                                <li class="active"><a href="#">Trending</a></li>
                                            </ul>';
                                    }
                                ?>
                                <!-- <ul>
                                    <li class="title">Reader</li>
                                    <li class="active">
                                        <a href="#">
                                            Timeline
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            Trending
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">Bookmarked</a>
                                    </li>
                                </ul> -->

                                <!-- <ul>
                                    <li class="title">Reader</li>
                                    <li class="active"><a href="#">Trending</a></li>
                                </ul> -->
                            </nav>
                        </div>
                        <div class="span8" lstyle="background-color: red">
                            <h1>Timeline</h1>

                            <!--Results-->
                            <div class="me_result" lstyle="background-color: green;">
                                <div class="news">
                                    <div class="content">
                                        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Facere suscipit iste assumenda cupiditate dolores asperiores!
                                    </div>
                                    <div class="sub">
                                        Lorem ipsum dolor sit amet.
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
                            </div>

                            <div class="me_result" lstyle="background-color: green;">
                                <div class="news">
                                    <div class="content">
                                        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Facere suscipit iste assumenda cupiditate dolores asperiores!
                                    </div>
                                    <div class="sub">
                                        Lorem ipsum dolor sit amet.
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
                            </div>

                            <div class="me_result" lstyle="background-color: green;">
                                <div class="news">
                                    <div class="content">
                                        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Facere suscipit iste assumenda cupiditate dolores asperiores!
                                    </div>
                                    <div class="sub">
                                        Lorem ipsum dolor sit amet.
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
                            </div>


                            <div class="me_result" lstyle="background-color: green;">
                                <div class="news">
                                    <div class="content">
                                        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Facere suscipit iste assumenda cupiditate dolores asperiores!
                                    </div>
                                    <div class="sub">
                                        Lorem ipsum dolor sit amet.
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
                            </div>


                            <div class="me_result" lstyle="background-color: green;">
                                <div class="news">
                                    <div class="content">
                                        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Facere suscipit iste assumenda cupiditate dolores asperiores!
                                    </div>
                                    <div class="sub">
                                        Lorem ipsum dolor sit amet.
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
                            </div>

                            <div class="me_result" lstyle="background-color: green;">
                                <div class="news">
                                    <div class="content">
                                        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Facere suscipit iste assumenda cupiditate dolores asperiores!
                                    </div>
                                    <div class="sub">
                                        Lorem ipsum dolor sit amet.
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
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </body>
</html>