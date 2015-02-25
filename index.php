<?php
session_start();
ini_set('display_errors', 1);

include_once('controller/controller.php');

$controller = new Controller();
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Aston University Book Store</title>

    <link href="view/css/bootstrap.min.css" rel="stylesheet">
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script src="view/scripts/bootstrap.min.js"></script>
  </head>
  <body>
    <?php $controller->invoke($_REQUEST); ?>
  </body>
</html>