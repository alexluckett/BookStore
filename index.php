<?php
session_start();
ini_set('display_errors', 1);

include_once('controller/Controller.php');

$controller = new Controller();
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Aston University Book Store</title>

        <link href="view/css/bootstrap.min.css" rel="stylesheet">

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
        <script src="view/scripts/bootstrap.min.js"></script>

        <style type="text/css">
            body {
                padding-top: 70px; /* account for navbar */
            }
            .container {
                width: 60%;
            }
        </style>
    </head>
    <body>
        <nav class="navbar navbar-default navbar-fixed-top">
            <div class="container">
                <div class="navbar-header">
                    <a class="navbar-brand" href="index.php">Book Store</a>
                </div>

                <ul class="nav navbar-nav" id="navbar">
                <?php if (isset($_SESSION['permission'])) {
                    if ($_SESSION['permission'] == 1) {
                        ?>
                        <li role="presentation"><a href="?action=viewBooks">Manage books</a></li>
                        <li role="presentation"><a href="?action=viewUsers">Manage users</a></li>
                    <?php } else { ?>
                        <li role="presentation"><a href="?action=viewBooks">View books</a></li>
                        <li role="presentation"><a href="?action=viewBasket">View basket</a></li>
                <?php } ?>
                </ul>
                <div class="navbar-text navbar-right">
                    <a href="?action=viewAccountDetails"><b>Signed in as <?php echo $_SESSION['username'] ?></b></a>. <a href="?action=logout">Sign out?</a>
                </div>
                <?php } else { ?>
                </ul>
                
                <div class="navbar-right">
                    <ul class="nav navbar-nav" id="navbar">
                    <li role="presentation"><a href="?action=viewRegister">Register</a></li>
                    </ul>
                    <a href="?action=viewLogin"><button type="button" class="btn btn-default navbar-btn">Sign in</button></a>
                </div>
                
                <?php } ?>
            </div>
        </nav>
        
        <div class="container">
        <?php $controller->invoke($_REQUEST); // forward requests to the controller, display output ?>
        </div>
    </body>
</html>