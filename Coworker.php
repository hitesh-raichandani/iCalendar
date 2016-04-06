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
        $picture = $row['picture'];
        $workplace = $row['workplace'];
    }
} else {
    echo "No results";
}

if (is_null($picture)) {
	$profile_picture_sm = "'img/corner.jpg'";
	$profile_picture_lg = "'http://sharedseeker.com/file/profile_image/default_profile.jpg'";
} else {
	$profile_picture_sm = "'$picture'";
	$profile_picture_lg = "'$picture'";
}

?>

<html>
	<head>
		<link rel="stylesheet" type="text/css" href="Sceleton.css">
		<link rel="stylesheet" type="text/css" href="co-workers-new.css">
		<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js">
		</script>
		<title>Co-workers</title>
		
	</head>

	<body  onload="createEmployee()">
		<script src="co-workers.js">
		</script>
		
	<div class="header">
	
	<div id="logo"> </div>
	
	<nav><ul>
			<a href="Dashboard.php"><li>Dashboard</li></a>
			<a href="Schedule.php" ><li> Schedule</li></a>
			<a href="SearchAvail.php"><li>Search Avail</li></a>
			<a href="#"><li class="active">Co-Workers</li></a>
			<a href="profile-page-new.php"><img src=<?php echo $profile_picture_sm?> style="width:50px; height:50px;"> </img></a>
			
		</ul></nav>
	
	
	</div>
		<div class = "container">
			<div id = "page-info-display" class = "effect2">
				<h2 style = "color:white">Co-workers</h2>
			</div>
			<div id = "all-workplace-display" class = "effect2">
			</div>
		</div>
	</body>
</html>