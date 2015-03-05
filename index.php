<!DOCTYPE html>

<?php
include_once 'includes/index.inc.php';
 
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
<!-- 
        <script>
            function change_state(state, url)
            {

                var pass = document.createElement("input");
                pass.name = "status";
                pass.value = state;
                pass.type = "hidden";
                var form = document.getElementById("form");
                form.appendChild(pass);
                form.submit();
            }
        </script> -->


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
                            echo  '<div class="element place-right">
                                        <a href="includes/logout.php"><span class="icon-switch"></span></a>
                                    </div>
                                    <div class="element place-right">
                                        <a href="#"><span class="icon-cog"></span></a>
                                    </div>
                                    <div class="element place-right">
                                        <a href="conversations.php"><span class="icon-mail"></span></a>
                                    </div>' . "
                                    <a class='element brand place-right fg-blue' href='#'>Hey, {$_SESSION['first_name']}!</span></a>";
                        }
                        else
                        {
                            echo '  <div class="element place-right">
                                        <a href="login.php"><span class="icon-enter-2"></span></a>
                                    </div>';
                        }

                    ?>

                    <div class="element input-element place-right">
                        <form action="">
                            <div class="input-control text">
                                <input type="text" placeholder="Search">
                                <button class="btn-search"></button>
                            </div>
                        </form>
                    </div>
                    

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
                        <?php
                            if($login == true)
                            {
                                echo    '<li><a href="index.php">Reader</a></li>
                                        <li><a href="blog_list.php">Blogs</a></li>
                                        <li><a href="#">Following</a></li>
                                        <li><a href="#">Followers</a></li>';
                            }
                            else
                            {
                                echo '<li><a href="index.php">Reader</li>';
                            }
                        ?>
                        
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

                                    $url = esc_url($_SERVER['PHP_SELF']);
                                    //echo $status;
                                    if($login==true)
                                    {
                                        $timeline = "";
                                        $trend = "";
                                        $book = "";

                                        if($status == "BOOK")
                                        {
                                            $book = 'class="active"';
                                        }
                                        else if($status == 'TREND')
                                        {
                                            $trend = 'class="active"';
                                        }
                                        else
                                        {
                                            $timeline = 'class="active"';
                                        }
                                        $print = "<ul>
                                                <li class='title'>Reader</li>
                                                <li " . $timeline . ">
                                                    <a href='{$url}?status=TIMELINE'>
                                                        Timeline
                                                    </a>
                                                </li>
                                                <li " . $trend . ">
                                                    <a href='{$url}?status=TREND'>
                                                        Trending
                                                    </a>
                                                </li>
                                                <li " . $book . ">
                                                    <a href='{$url}?status=BOOK'>Bookmarked</a>
                                                </li>
                                            </ul>";
                                        echo $print;
                                    }
                                    else 
                                    {
                                        $print = "<ul>
                                                <li class='title'>Reader</li>
                                                <li class='active'><a href='{$url}?status=TREND'>Trending</a></li>
                                            </ul>";
                                        echo $print;
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
                        <from id="form" action=<?php echo '"' . $url . '"'; ?> method="post"></from>
                        <div class="span8" lstyle="background-color: red">
                            <h1>
                                <?php
                                    if($status == 'TREND')
                                        echo 'Trending';
                                    else if($status == 'TIMELINE')
                                        echo 'Timeline';
                                    else if ($status == 'BOOK') {
                                        echo 'Bookmarked';
                                    }
                                ?>
                            </h1>

                            <!--Results-->
                            <?php
                                echo $result;
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </body>
</html>