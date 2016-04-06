<?php

session_start();
$_SESSION = array();
session_unset();

$_POST = array();

header("Location: home.php");

?>