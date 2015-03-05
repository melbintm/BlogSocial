<?php
    include_once 'includes/register.inc.php';
    include_once 'includes/functions.php';

    sec_session_start();
    if (login_check($mysqli) == true)
    {
        header('Location: ./index.html');
        error_log("Logged in");
    } else {
        error_log("Not Looged in");
    }

?>


<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset='UTF-8'>
        <title>Create new account</title>
        <link href="css/metro-bootstrap.css" rel="stylesheet">
        <link href="css/metro-bootstrap-responsive.css" rel="stylesheet">
        <link href="css/iconFont.css" rel="stylesheet">
        <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
        <!--<link href="js/prettify/prettify.css" rel="stylesheet">
        <link rel="stylesheet" href="css/style.css">-->

        <!-- Load JavaScript Libraries -->
        
        <script type="text/JavaScript" src="js/sha512.js"></script>
        <script type="text/JavaScript" src="js/form.js"></script>

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
        <div class="container">
            <header>
                <h2>Blog+Social</h2>
            </header>
            <main>
                <h1>Create an account</h1>
                <p>If you already created an account click here to login. Otherwise, create a new account.</p>
                <?php
                        echo "Eureka!";
                        if(!empty($error_msg))
                        {
                            echo($error_msg);
                        }
                ?>
                <form action="<?php echo esc_url($_SERVER['PHP_SELF']); ?>" method="post" name="registration_form">
                    <label for="Name">Name</label>
                    <div class="grid">
                        <div class="row">
                            <div class="span3">
                                <div class="input-control text">
                                    <input type="text" name="first_name"
                                    id="first_name" placeholder="First">
                                </div>    
                            </div>
                            <div class="span3">
                                <div class="input-control text">
                                    <input type="text" name="last_name"
                                    id="last_name" placeholder="Last">
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <label for="username">User name</label>
                    <div class="input-control text size6">
                        <input type="text" name="username" id="username">
                    </div>
                    <label for="email">Email</label>
                    <div class="input-control text size6">
                        <input type="text" name="email" id="email">
                    </div>
                    <label for="password">Create password</label>
                    <div class="input-control password size6">
                        <input type="password" name="password" id="password">
                    </div>

                    <label for="confirmpwd">Reenter password</label>
                    <div class="input-control password size6">
                        <input type="password" name="confirmpwd" id="confirmpwd">
                    </div>
                    
                    <label for="">Birthdate</label>
                    <div class="grid">
                        <div class="row">
                            <div class="span2">
                                <div class="input-control select">
                                    <select name="month" id="month">
                                        <option value="00">Month</option>
                                        <option value="01">January</option>
                                        <option value="02">February</option>
                                        <option value="03">March</option>
                                        <option value="04">April</option>
                                        <option value="05">May</option>
                                        <option value="06">June</option>
                                        <option value="07">July</option>
                                        <option value="08">August</option>
                                        <option value="09">September</option>
                                        <option value="10">Octobar</option>
                                        <option value="11">November</option>
                                        <option value="12">December</option>
                                    </select>
                                </div>
                            </div>
                            <div class="span2">
                                <div class="input-control select">
                                    <select name="day" id="day">
                                        <?php
                                            for($day = 1; $day < 32; $day++)
                                            {
                                                echo "<option value='{$day}'>{$day}</option>";
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="span2">
                                <div class="input-control select">
                                    <select name="year" id="year">
                                        <?php
                                            for($year = 2015; $year > 1904; $year--)
                                            {
                                                echo "<option value='{$year}'>{$year}</option>";
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <label for="gender">Gender</label>
                    <div class="input-control select size6">
                        <select name="gender" id="gender">
                            <option value="Select">Select...</option>
                            <option value="MALE">Male</option>
                            <option value="FEMALE">Female</option>
                        </select>
                    </div>
                    <label for="phone">Phone no.</label>
                    <div class="input-control text size6">
                        <input type="text" name="phone" id="phone">
                    </div>
                    <p>Click Create account to agree to the Blog+Social Agreement.</p>
                    <p>
                    <input type="button" class="primary" value="Create account" onclick="return regformhash(this.form,
                                this.form.username,
                                this.form.email,
                                this.form.password,
                                this.form.confirmpwd,
                                this.form.first_name,
                                this.form.last_name,
                                this.form.month,
                                this.form.day,
                                this.form.year,
                                this.form.gender,
                                this.form.phone);" />
                </form>
            </main>
        </div>
    </body>
</html>