<?php

session_start();

if (!isset($_SESSION['id'])) {
	header("Location: logout.php");
}

// Connect to MySql
include_once 'mysql_connect.php';

// Get id to view
$id = $_SESSION['id'];

mysqli_select_db($conn, "USERS");

$sql = "SELECT * FROM USERS
		WHERE id = '$id'";
$result = mysqli_query($conn, $sql);
// For all of the users that come back (only one should be returned if tables are being maintained properly)
if (mysqli_num_rows($result) > 0) {
    while($row = mysqli_fetch_assoc($result)) {
        $picture = $row['picture'];
        $id = $row['id'];
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
mysqli_select_db($conn, "UPDATES");

$table = "table_" . $id;
$yesterday  = mktime(0, 0, 0, date("m")  , date("d")-1, date("Y"));

// Make select query
$sql = "SELECT * FROM $table 
		WHERE time_sent > SUBDATE(CURDATE(), 0)
		ORDER BY time_sent DESC
		LIMIT 25";

$result = mysqli_query($conn, $sql);
	
$today_messages = "";
if (mysqli_num_rows($result) > 0) {
	while($row = mysqli_fetch_assoc($result)) {
        $text = $row['msg_text'];
        $type = $row['msg_type'];
        $name = $row['time_sent'];
        $subject = $row['msg_subject'];
        $today_messages .= "<div class='email'>\n" .
    			   	   "<div class='subject-container'>\n" .
							"<span class='subject $type'>$subject</span>\n" .
    					"</div>\n" .
    					"<div class='email-content'>\n" .
      						"<p> $text </p>\n" .
    					"</div>\n" .
    				"</div>\n";
	}
}
// Make select query
$sql = "SELECT * FROM $table 
		WHERE time_sent < SUBDATE(CURDATE(),0) 
		AND time_sent > SUBDATE(CURDATE(),1)
		ORDER BY time_sent DESC
		LIMIT 25";

$result = mysqli_query($conn, $sql);

$yesterday_messages = "";
if (mysqli_num_rows($result) > 0) {
	while($row = mysqli_fetch_assoc($result)) {
        $text = $row['msg_text'];
        $type = $row['msg_type'];
        $subject = $row['msg_subject'];
        $name = $row['time_sent'];
        $yesterday_messages .= "<div class='email'>\n" .
    			   	   "<div class='subject-container'>\n" .
							"<span class='subject $type'>$subject</span>\n" .
    					"</div>\n" .
    					"<div class='email-content'>\n" .
      						"<p> $text </p>\n" .
    					"</div>\n" .
    				"</div>\n";
	}
}

?>

<!DOCTYPE html>

<html>
	<head>
		<link rel="stylesheet" type="text/css" href="Sceleton.css">
		<link rel="stylesheet" type="text/css" href="Dashboard-inbox.css">
		<link href='http://fonts.googleapis.com/css?family=Oswald' rel='stylesheet' type='text/css'>
		<meta charset="utf-8"/>
		<TITLE></TITLE>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
		
		<script>
		$(document).on("click", 'ul li', function(){
    $('ul li').removeClass('active');
    $(this).addClass('active');
});
		</script>
	</head>

	<body>
		
	
	<div class="header">
	
	<div id="logo"> </div>
	
	<nav><ul>
			<a href="Dashboard.php"><li class="active" >Dashboard</li></a>
			<a href="Schedule.php" ><li >Schedule</li></a>
			<a href="SearchAvail.php"><li>Search Avail</li></a>
			<a href="Coworker.php"><"><li>Co-Worers</li></a>
			
			<a href="profile-page-new.php"><img src="<?php echo $picture ?>" style="height:50px; width: 50px;"> </img></a>
			
		</ul></nav>
	
	
	</div>
	
	<div class="sidebar">
		
	<nav><ul>
			<a href="#" ><li class="active" >Inbox</li></a>
			<a href="profile-page-new.php" ><li >Profile</li></a>
			<a href="Support.php" ><li>Support</li></a>
			<a href="logout.php" ><li>Logout</li></a>
			
		</ul></nav>
	
	
	</div>
	<div id = inbox>
<h2 style = "color:red"> Messages </h2> <br><br>
	
	
	
	
	<div id ="BOX">

		<div class="day-indicator">
  <span>Today</span>
  </div>

<div class="content">

<?php echo $today_messages ?>
 
</div>


<div class="day-indicator">
  <span>Yesterday</span>
</div>

<div class="content">
<?php echo $yesterday_messages ?>
</div>

	
	</div>
	</div>
	
	
	
	</body>
	
</html>