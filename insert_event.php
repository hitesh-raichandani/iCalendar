<?php
session_start();

// Connect to MySql
include_once 'mysql_connect.php';

$event_name = mysqli_real_escape_string($conn, $_GET['event_name']);
$start_time = mysqli_real_escape_string($conn, $_GET['start_date']);
$end_time = mysqli_real_escape_string($conn, $_GET['end_date']);

$user_id = $_SESSION['id'];

$table_name = "table_" . $user_id;

mysqli_select_db($conn, "schedules");

$sql = "INSERT INTO $table_name (id, name, start_date, end_date)
		VALUES (null, '$event_name', '$start_time', '$end_time');";

$result = mysqli_query($conn, $sql);

mysqli_select_db($conn, "updates");

$today = date("Y-m-d H:i:s");
$sql = "INSERT INTO $table_name (msg_type, msg_text, time_sent, msg_subject)
		VALUES('finance', 'Event Added- $event_name at $start_time', '$today', 'Calendar');";

$result = mysqli_query($conn, $sql);

echo mysqli_error($conn);
?>