<?php
session_start();

// Connect to MySql
include_once 'mysql_connect.php';

mysqli_select_db($conn, 'MESSAGES');

$message_id = $_GET['id'];
$id = $_SESSION['id'];

$message_table = 'table_' . $id;

$sql = "DELETE FROM $message_table
		WHERE id = '$id'";

mysqli_query($conn, $sql);
echo $sql;
?>