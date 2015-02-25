<?php
session_start();
ini_set('display_errors', 1);

include_once('controller/controller.php');

$controller = new Controller();
$controller->invoke($_REQUEST);

?>

