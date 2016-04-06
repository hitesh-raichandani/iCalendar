<?php

$servername = 'localhost';
$username = 'andrew';
$password = 'pR4x8vHjcnJSEbX8';
$dbname = 'users';

$user_table = "USERS";

$USER_GROUPS = array("Library", "Cafe", "Management", "Admin", "None");

// Try to connect to MySql
$conn = mysqli_connect($servername, $username, $password);

if (mysqli_connect_errno()) {
    die("Failed to connect to mysql " . mysqli_error($conn));
}

if (!mysqli_select_db($conn, $dbname)) {
    // Create database
    $sql = "CREATE DATABASE $dbname";

    if (mysqli_query($conn, $sql)) {
        // echo "Database created";
        mysqli_select_db($conn, $dbname);
    } else {
        die("Error creating database " . mysqli_error($conn));
    }
    
} else {
    // echo "Database selected ";
}

// Create customer table
$sql = "CREATE TABLE $user_table
(
    id INT NOT NULL AUTO_INCREMENT,
    email VARCHAR(30) NOT NULL,
    password VARCHAR(32) NOT NULL,
    fullname VARCHAR(30) NOT NULL,
    address VARCHAR(50) NOT NULL,
    zipcode INT NOT NULL,
    phone VARCHAR(11) NOT NULL,
    mobile VARCHAR(11),
    picture VARCHAR(255),
    position VARCHAR(15),
    workplace VARCHAR(15),
    PRIMARY KEY(id)
);";

if (mysqli_query($conn, $sql)) {
    // echo "Customer table created\n";
  } else {
    // echo "Error creating customer table " . mysqli_error($conn);
}

$msg_db = "MESSAGES";

// Close up MySql
if (!mysqli_select_db($conn, $msg_db)) {
    // Create database
    $sql = "CREATE DATABASE $msg_db";

    if (mysqli_query($conn, $sql)) {
        // echo "Message database created";
        mysqli_select_db($conn, $msg_db);
    } else {
        die("Error creating database " . mysqli_error($conn));
    }
    
} else {
    // echo "Database selected ";
}

$group_db = "GROUPS";
if (!mysqli_select_db($conn, $group_db)) {
    // Create database
    $sql = "CREATE DATABASE $group_db";

    if (mysqli_query($conn, $sql)) {
        // echo "Message database created";
        mysqli_select_db($conn, $group_db);
    } else {
        die("Error creating database " . mysqli_error($conn));
    }
    
} else {
    // echo "Database selected ";
}
mysqli_select_db($conn, "GROUPS");

// Create all the group tables
foreach ($USER_GROUPS as $table) {
    $sql = "CREATE TABLE $table
            (
             id INT NOT NULL,
             PRIMARY KEY(id)
            );";
    mysqli_query($conn, $sql);
}

// Create a schedule table for them
$group_db = "SCHEDULES";
if (!mysqli_select_db($conn, $group_db)) {
    // Create database
    $sql = "CREATE DATABASE $group_db";

    if (mysqli_query($conn, $sql)) {
        // echo "Message database created";
        mysqli_select_db($conn, $group_db);
    } else {
        die("Error creating database " . mysqli_error($conn));
    }
    
} else {
    // echo "Database selected ";
}

// Create a schedule table for them
$group_db = "UPDATES";
if (!mysqli_select_db($conn, $group_db)) {
    // Create database
    $sql = "CREATE DATABASE $group_db";

    if (mysqli_query($conn, $sql)) {
        // echo "Message database created";
        mysqli_select_db($conn, $group_db);
    } else {
        die("Error creating database " . mysqli_error($conn));
    }
    
} else {
    // echo "Database selected ";
}

mysqli_close($conn)
?>