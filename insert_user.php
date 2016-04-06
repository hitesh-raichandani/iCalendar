<?php
	/*
	 * Called upon registering a user. Inserts the user into the USERS table
	 * and creates a table by their username in order to maintain their
	 * schedule.
	 */
	session_start();
	include_once 'mysql_connect.php';

    mysqli_select_db($conn, "USERS");

	$fullname = $_POST['fullname'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];
    $mobile = $_POST['phone'];
    $email = $_POST['email'];
    $zipcode = $_POST['zipcode'];
    $password = md5($_POST['password']);

    $response = array();

    // If we get something returned, then that user exists already
	//if(mysqli_num_rows(mysqli_query($conn, "SHOW TABLES LIKE '" . $email . "'")) > 0) { 
	//	echo "User already exists!";	
	//	exit()
	//}

	// Insert user into USERS table
	$sql = "INSERT INTO USERS (id, email, password, fullname, address, zipcode, phone, mobile, workplace, picture)
		    VALUES (null, '$email', '$password', '$fullname', '$address', '$zipcode', '$phone', '$mobile', 'None',
		    'https://www.justpark.com/media/img/misc/avatar-st.png');";
	
	// If we can insert the user into USERS
	if (mysqli_query($conn, $sql)) {
		$sql = "SELECT id FROM USERS WHERE email = '$email'";
		$result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        $user_tables = 'table_' . $row['id'];
		// Create user table in messages database
		mysqli_select_db($conn, "SCHEDULES");
		// Create a schedule table for them
		$sql = "CREATE TABLE $user_tables
			    (
			     id INT NOT NULL AUTO_INCREMENT,
			     name VARCHAR(15) NOT NULL,
			     start_date VARCHAR(25) NOT NULL,
			     end_date VARCHAR(25) NOT NULL,
		         PRIMARY KEY(id)
		        );";
		// If we can create the schedule table, we're done! Redirect to log in
		if (mysqli_query($conn, $sql)) {
			mysqli_select_db($conn, "MESSAGES");
			// Create a message table for them
			$sql = "CREATE TABLE $user_tables
			    (
			     id INT NOT NULL AUTO_INCREMENT,
		         sender VARCHAR(20) NOT NULL,
		         msg_text VARCHAR(5000) NOT NULL,
		         time_sent DATETIME NOT NULL,
		         PRIMARY KEY(id)
		        );";
		    if (mysqli_query($conn, $sql)) {
		    	// Send them the intro message
		    	$timestamp = time();
		    	$today = date("Y-m-d H:i:s");
		    	$sql = "INSERT INTO $user_tables (sender, msg_text, time_sent)
		    		    VALUES ('auto-sender', 'Welcome to iCalendar!', '$today')";
		    	mysqli_query($conn, $sql);
			}
		} else {
			
		}
		// If we can create the schedule table, we're done! Redirect to log in
		if (mysqli_query($conn, $sql)) {
			mysqli_select_db($conn, "UPDATES");
			// Create a message table for them
			$sql = "CREATE TABLE $user_tables
			    (
			     id INT NOT NULL AUTO_INCREMENT,
			     msg_type VARCHAR(255) NOT NULL,
		         msg_text VARCHAR(5000) NOT NULL,
		         time_sent DATETIME NOT NULL,
		         msg_subject VARCHAR(255) NOT NULL,
		         PRIMARY KEY(id)
		        );";
		    if (mysqli_query($conn, $sql)) {
		    	// Send them the intro message
		    	$timestamp = time();
		    	$today = date("Y-m-d H:i:s");
		    	$sql = "INSERT INTO $user_tables (msg_text, time_sent, msg_type, msg_subject)
		    		    VALUES ('Account Created - Welcome!', '$today', 'update', 'Welcome!')";
		    	mysqli_query($conn, $sql);
	        	header("Location: home.php");
	        	exit();
			}
		} else {
			echo "Failed to create schedule table for new user " . mysqli_error($conn);
			?><script>alert('Failed to create schedule table for new user');</script><?php
		}
	} else {
	}
?>