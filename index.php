<?php
session_start();
ini_set('display_errors', 1);

include('controller/controller.php');

$controller = new Controller();
$controller->invoke($_REQUEST);

?>

