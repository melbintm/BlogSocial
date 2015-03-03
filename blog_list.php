<!DOCTYPE html>

<?php
include_once "includes/blog_list.inc.php";

$url = esc_url($_SERVER['PHP_SELF']);
?>

<html>
	<head>
		<title>Blogs</title>
		<link href="css/metro-bootstrap.css" rel="stylesheet">
        <link href="css/metro-bootstrap-responsive.css" rel="stylesheet">
        <link href="css/iconFont.css" rel="stylesheet">
        <link rel="stylesheet" href="font-awesome/css/font-awesome.min.css">

        <!--<link href="js/prettify/prettify.css" rel="stylesheet">-->
        <link rel="stylesheet" href="css/style.css">

        <!-- Load JavaScript Libraries -->
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
	                    <a href="includes/logout.php"><span class="icon-switch fg-red"></span></a>
	                </div>
	                <div class="element place-right">
	                    <a href="#"><span class="icon-cog"></span></a>
	                </div>
	                <div class="element place-right">
	                    <a href="#"><span class="icon-mail fg-green"></span></a>
	                </div>

					<div class="element input-element place-right">
                        <form action="">
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
						<li><a href="index.php">Reader</a></li>
						<li><a href="blog_list.php">Blog</a></li>
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
										echo "<li class='title'>Blogs</li>
									<li {$overview_class}><a href='{$url}?link=OVERVIEW'>Overview</a></li>
									<li {$new_class}><a href='{$url}?link=NEW'>Create a new blog</a></li>
									<li {$remove_class}><a href='{$url}?link=REMOVE'>Remove a blog</a></li>
									<li {$insight_class}><a href='{$url}?link=INSIGHT'>Insights</a></li>";
									?>

									<!-- <li class="title">Blogs</li>
									<li class="active"><a href="#">Overview</a></li>
									<li><a href="#">Create a new blog</a></li>
									<li><a href="#">Remove a blog</a></li>
									<li><a href="#">Insights</a></li> -->
								</ul>
							</nav>
						</div>
						<div class="span8">
							<h1><?php echo $header; ?></h1>
							<div class="grid">
								<?php echo $result; ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</main>
	</body>
</html>