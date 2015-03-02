<?php
include_once 'includes/db_connect.php';
include_once 'includes/login.inc.php';
 
if (login_check($mysqli) == true) {
    error_log("Looged in");
    header('Location: ./index.php');
} else {
    error_log("Not Logged in");
    $logged = 'out';
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        
        <title>Login</title>
        <link href="css/metro-bootstrap.css" rel="stylesheet">
        <link href="css/metro-bootstrap-responsive.css" rel="stylesheet">
        <link href="css/iconFont.css" rel="stylesheet">
        <!--<link href="js/prettify/prettify.css" rel="stylesheet">
        <link rel="stylesheet" href="css/style.css">-->

        <!-- Load JavaScript Libraries -->
        <script type="text/JavaScript" src="js/form.js"></script>
        <script type="text/JavaScript" src="js/sha512.js"></script>


        <script src="js/jquery/jquery.min.js"></script>
        <script src="js/jquery/jquery.widget.min.js"></script>
        <script src="js/jquery/jquery.mousewheel.js"></script>
        <!--<script src="js/prettify/prettify.js"></script>-->

        <!-- Metro UI CSS JavaScript plugins -->
        <script src="js/load-metro.js"></script>

        <!-- Local JavaScript -->
        <!--<script src="js/docs.js"></script>
        <script src="js/github.info.js"></script>-->
    </head>
    <body class="metro">
        <main>
            <div class="container">
                <div class="grid" style="margin-top: 150px">
                    <div class="row">
                        <div class="span4">
                            
                        </div>
                        <div class="span4">
                            <h1 class="fg-blue">Blog+Social</h1>
                            <form method="post" action="<?php echo esc_url($_SERVER['PHP_SELF']); ?>" style="margin-top: 25px">
                                <label for="">
                                    Login to your accout
                                </label>
                                <?php
                                    if(!empty($error_msg))
                                    {
                                        error_log("Error");
                                        echo($error_msg);
                                    }
                                    else
                                    {
                                        error_log("No Error");
                                    }
                                ?>
                                <div class="input-control text size4">
                                    <input type="text" name="email" id="email" placeholder="Email"/>
                                </div>
                                <div class="input-control password size4">
                                    <input type="password" name="password" id="password" placeholder="Password"/>
                                </div>
                                <br/>
                                <br/>
                                <input type="button" class="large primary" value="Login"
                                        onclick="return loginform(this.form,
                                        this.form.email,
                                        this.form.password);" />
                                <br/>
                                <p><a href="#">Can't access your account?</a></p>
                                <br/>
                                <br/>
                                <br/>
                                <br/>
                                <p>Don't have a Blog+Social Account? <a href="./register.php">Sign up now</a>.</p>
                            </form>
                        </div>
                        <div class="span4">
                            
                        </div>
                    </div>
                </div>
                <hr/>
            </div>
        </main>
    </body>
</html>