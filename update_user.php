<?php
session_start();

// Connect to MySql
include_once 'mysql_connect.php';

$new_fullname = mysqli_real_escape_string($conn, $_GET['fullname']);
$new_email = mysqli_real_escape_string($conn, $_GET['email']);
$new_address = mysqli_real_escape_string($conn, $_GET['address']);
$new_mobile = mysqli_real_escape_string($conn, $_GET['phone']);
$new_position = mysqli_real_escape_string($conn, $_GET['position']);
$new_workplace = mysqli_real_escape_string($conn, $_GET['workplace']);
$new_picture = mysqli_real_escape_string($conn, $_GET['picture']);

if ($new_fullname == "") {
	$new_fullname = $_SESSION['fullname'];
}
if ($new_email == "") {
	$new_email = $_SESSION['email'];
}
if ($new_address == "") {
	$new_address = $_SESSION['address'];
}
if ($new_mobile == "") {
	$new_mobile = $_SESSION['mobile'];
}
if ($new_position == "") {
	$new_position = $_SESSION['position'];
}
if ($new_picture == "") {
	$new_picture = $_SESSION['picture'];
}
$id = $_SESSION['id'];

mysqli_select_db($conn, "users");

$sql = "UPDATE USERS
		SET email = '$new_email',
			fullname = '$new_fullname',
			address = '$new_address',
			mobile = '$new_mobile',
			phone = '$new_mobile',
            position = '$new_position',
            workplace = '$new_workplace',
            picture = '$new_picture'
		WHERE id = '$id'";

$result = mysqli_query($conn, $sql);

$_SESSION['email'] = $new_email;
$_SESSION['fullname'] = $new_fullname;
$_SESSION['address'] = $new_address;
$_SESSION['mobile'] = $new_mobile;
$_SESSION['position'] = $new_position;
$_SESSION['workplace'] = $new_workplace;
$_SESSION['picture'] = $new_picture;

mysqli_select_db($conn, "updates");
$table_name = "table_" . $id;
$today = date("Y-m-d H:i:s");
$sql = "INSERT INTO $table_name (msg_type, msg_text, time_sent, msg_subject)
		VALUES('social', 'Profile Updated', '$today', 'Profile');";

$result = mysqli_query($conn, $sql);

echo mysqli_error($conn);
?>