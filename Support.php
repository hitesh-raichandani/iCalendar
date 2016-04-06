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

// For all of the users that come back (only one should be returned if tables are being maintained properly)
if (mysqli_num_rows($result) > 0) {
    while($row = mysqli_fetch_assoc($result)) {
        $fullname = $row['fullname'];
    }
} else {
    echo "No results";
}
?>

<!DOCTYPE html>

<html>
	<head>
	<link rel="stylesheet" type="text/css" href="form.css">
		<link rel="stylesheet" type="text/css" href="Support.css">
		
        <link href='https://fonts.googleapis.com/css?family=Slabo+27px' rel='stylesheet' type='text/css'>
		<link href='http://fonts.googleapis.com/css?family=Oswald' rel='stylesheet' type='text/css'>
		<meta charset="utf-8"/>
		<TITLE></TITLE>
		<script 
		src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
		<script>
		
		
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
			<a href="Coworker.php"><li>Co-Workers</li></a>
			
			<a href="profile-page-new.php"><img src="img/corner.jpg" > </img></a>
			
		</ul></nav>
	
	
	</div>
	
	<div class="sidebar">
		
	<nav><ul>
			<a href="Dashboard-inbox.php" ><li >Inbox</li></a>
			<a href="profile-page-new.php" ><li >Profile</li></a>
			<a href="Support.php" ><li class = "active">Support</li></a>
			<a href="Home Page.php" ><li>Logout</li></a>
			
		</ul></nav>
	
	
	</div>
	<div class="detail">
  <h1>Want to Add/Manage your workplace?<br></h1>
  <p><br>please fill in the details below & submit your response.</p>
</div>

<form action="mailto:icalendar@scu.edu" method="GET" class="contactUs">
  <input type="text" class="name" name="subject" value='<?php echo $fullname ?>' placeholder="   Full Name" required />
  <input type="text" class="email" placeholder="   Subject"  required/>
  <textarea class="message" placeholder="   Enter your message" name="body" required ></textarea>
  <input type="submit" value="Send"/>
</form>
	
	
	
	
	
	
	
	</body>
	
</html>