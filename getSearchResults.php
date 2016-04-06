<?php
session_start();

if (!isset($_SESSION['id'])) {
    header("Location: logout.php");
}

// Connect to MySql
include_once 'mysql_connect.php';

// Get id to view
$id = $_SESSION['id'];
$start = $_POST['start'];
$end = $_POST['end'];
mysqli_select_db($conn, "users");

// Make select query
$workplace = $_SESSION['workplace'];

$response = array();

$sql = "SELECT * FROM USERS WHERE workplace = '$workplace'";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
    $all_users = array();
    while($row = mysqli_fetch_assoc($result)) {
        $user = array();
        $user['name'] = $row['fullname'];
        $user['picture'] = $row['picture'];
        $user['table'] = "table_" . $row['id'];
        $all_users[] = $user;
    }
}


$find_start = substr($start, 11);
$find_end = substr($end, 11);

mysqli_select_db($conn, "SCHEDULES");
$free_users = array();
for ($i = 0; $i < count($all_users); $i += 1) {
    $add_user = 0;
    $table = $all_users[$i]['table'];
    $sql = "SELECT * FROM $table";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) == 0) {
        $user = array();
        $user['name'] = $all_users[$i]['name'];
        $user['picture'] = $all_users[$i]['picture'];
        $free_users[] = $user;
    } else {
        while ($row = mysqli_fetch_assoc($result)) {
            $start_event = substr($row['start_date'], 9, 10);
            $end_event = substr($row['end_date'], 9, 10);

            $start_event_time = $start_event;

            if ($start_event < $find_end && $end_event > $find_start) {
                $add_user = 1;
            }
        }
        if ($add_user == 0) {
            $user = array();
            $user['name'] = $all_users[$i]['name'];
            $user['picture'] = $all_users[$i]['picture'];
            $free_users[] = $user;
        }
    }
}

$response["users"] = $free_users;

$_SESSION['response'] = $free_users;

echo json_encode($free_users);
?>