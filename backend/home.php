<!DOCTYPE html>
<html lang="en">

<head>
    <title>Solarizr</title>
    <link rel="stylesheet" type="text/css" href="css/landingCSS.css">
    <link type="image/x-icon" rel="shortcut icon" href="images/icon1.png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
</head>

<body>
    <?php
    session_start();
    if (!isset($_SESSION['loggedin'])) {
        header('Location: ../index.html');
        exit();
    }
    ?>
    <div id="intro-nav">
        <div id="intro-nav-company">
            <img src="images/icon1.png" class="company-logo-small" alt="blue tri-leaf vivix logo">
            <span id="intro-nav-company-name">Solarizr</span>
        </div>


        <div id="intro-nav-sections">
            <!-- Use 'onclick' to redirect -->
            <div class="intro-nav-sections-buttons">Sign up</div>
            <div class="intro-nav-sections-buttons">Login</div>
            <div class="intro-nav-sections-buttons">Help</div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-12">
            <h2>Home Page</h2>
            <a href="logout.php">Logout</a>
            <hr />
            <p>Welcome back, <?= $_SESSION['name'] ?>!</p>
        </div>

        <div class="col-lg-6 col-md-6 col-sm-12 img-container">
            <h1>
                design.co
            </h1>
        </div>
    </div>


    <div id="body-footer">
        <div id="body-footer-sections">
            <div>
                <p>NAVIGATION</p>
                <a href="">Sign up</a><br>
                <a href="">Login</a><br>
                <a href="">Categories</a><br>
                <a href="">Appliances</a><br>
            </div>
            <div>
                <p>RESOURCES</p>
                <a href="">About us</a><br>
                <a href="">Going Solar</a><br>
                <a href="">Help</a>
            </div>
            <div>
                <p>SOCIALS</p>
                <img src="images/Social brands/facebook-f.svg" class="social-brand-icons" alt="fblogo" height="15px" width="15px"> &nbsp; <label class="contact-labels"> Solarizr_ng</label><br>
                <img src="images/Social brands/twitter.svg" class="social-brand-icons" alt="twitterlogo" height="15px" width="15px"> &nbsp; <label class="contact-labels"> @solariz_r</label><br>
                <img src="images/Social brands/yahoo.svg" class="social-brand-icons" alt="emaillogo" height="15px" width="15px"> &nbsp; <label class="contact-labels"> info@solar.com</label><br>
                <img src="images/Social brands/google-plus-g.svg" class="social-brand-icons" alt="gpluslogo" height="15px" width="15px"> &nbsp; <label class="contact-labels"> Solarizr Inc</label><br>
                <img src="images/Social brands/phone.svg" class="social-brand-icons" alt="phonelogo" height="15px" width="15px"> &nbsp; <label class="contact-labels"> +234 00000000</label>

            </div>
        </div>
        <p id="footer-text">All rights reserved &copy;2019 Team Aeolus <br> HNG Internship 6.0</p>
    </div>
</body>


</html>