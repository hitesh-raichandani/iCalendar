<?php
session_start();

if (!isset($_SESSION['id'])) {
	header("Location: logout.php");
}

// Connect to MySql
include_once 'mysql_connect.php';

// Get id to view
$id = $_SESSION['id'];
mysqli_select_db($conn, "users");

// Make select query
$sql = "SELECT * FROM USERS WHERE id = '$id'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    while($row = mysqli_fetch_assoc($result)) {
        $id = $row['id'];
        $workplace = $row['workplace'];
    }
}
$response = array();
$response['workplace'] = $workplace;

$sql = "SELECT * FROM USERS WHERE workplace = '$workplace'";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
	$all_users = array();
    while($row = mysqli_fetch_assoc($result)) {
        $user = array();
        $user['name'] = $row['fullname'];
        $user['picture'] = $row['picture'];
        $user['position'] = $row['position'];
        $all_users[] = $user;
    }
}

$response["users"] = $all_users;

echo json_encode($response);

?>