<?php

session_start();

if (!isset($_SESSION['id'])) {
	header("Location: logout.php");
}

// Connect to MySql
include_once 'mysql_connect.php';

// Get id to view
$id = $_SESSION['id'];

mysqli_select_db($conn, "GROUPS");

$sql = "SHOW TABLES";
$tableList = array();
$result = mysqli_query($conn,$sql);
$dropdown_list = "";
while($cRow = mysqli_fetch_array($result)) {
	$tableList[] = $cRow[0];
	$dropdown_list .= "<option value='$cRow[0]'>$cRow[0]</option>";
}

mysqli_select_db($conn, "users");

// Make select query
$sql = "SELECT * FROM USERS WHERE id = '$id'";
$result = mysqli_query($conn, $sql);

// For all of the users that come back (only one should be returned if tables are being maintained properly)
if (mysqli_num_rows($result) > 0) {
    while($row = mysqli_fetch_assoc($result)) {
        $email = $row['email'];
        $fullname = $row['fullname'];
        $address = $row['address'];
        $zipcode = $row['zipcode'];
        $phone = $row['phone'];
        $mobile = $row['mobile'];
        $picture = $row['picture'];
        $id = $row['id'];
        $position = $row['position'];
        $picture = $row['picture'];
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
		<link rel="stylesheet" type="text/css" href="profile-page.css">

		<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js">
		</script>

		<meta charset="UTF-8">
		
		<link rel="stylesheet prefetch" href="https://code.getmdl.io/1.1.1/material.green-deep_purple.min.css">
		<title>Profile</title>

		<link rel="stylesheet" type="text/css" href="Sceleton.css">
		<!-- <link rel="stylesheet" type="text/css" href="prof.css"> -->
		<link href='http://fonts.googleapis.com/css?family=Oswald' rel='stylesheet' type='text/css'>
		
		<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script> -->
		<script	src = "profedit.js" ></script>
	</head>

	<body onload="empProfile()">
	
	<div class="header">
	
	<div id="logo"> </div>
	
	<nav><ul>
			<a href="Dashboard.php"><li class="active" >Dashboard</li></a>
			<a href="Schedule.php" ><li >Schedule</li></a>
			<a href="SearchAvail.php"><li>Search Avail</li></a>
			<a href="Coworker.php"><li>Co-Workers</li></a>
			<a href="profile-page-new.php"><img src=<?php echo $profile_picture_sm ?> style="width:50px; height: 50px;"></img></a>
			
		</ul></nav>
	
	
	</div>
	
	<div class="sidebar">
		
	<nav><ul>
			<a href="Dashboard-inbox.php"><li  >Inbox</li></a>
			<a href="profile-page-new.php"  ><li class  = active>Profile</li></a>
			<a href="Support.php"  ><li>Support</li></a>
			<a href="logout.php" ><li>Logout</li></a>
			
		</ul></nav>
	
	
	</div>
	
		<script src="raphael-2.1.4.min.js"></script>
		<script src="justgage.js"></script>
		<script src="profile-page.js"></script>

		<div class="main">
			<div class="row">
		    	<div class="photo">
		        	<img src=<?php echo $profile_picture_lg?> class="image profile-picture" id="profile_image_src" style='width:200px; height:200px'>
		        	
		        	<label for="profile_image" id="upload-label">
      					<img src="24.ico" title="Update profile picture" id="upload-button-image"/>
      				</label>
      				<input type="file" id="profile_image">
		    	</div>
		    	<div class="highlights">
		        	<h2><?php echo $fullname ?></h2>
		        	<div class="row">
		          		<div id="gauge2" class="gauge"></div>
		        	</div>
		      	</div>
		  	</div>

		  	<div class="row">
		  		<div class="data">
		        	<div class="card mdl-card">
		          		<div class="mdl-card__title">
		            		<h2 class="mdl-card__title-text">Staff Information</h2>
		          		</div>

		          		<div class="mdl-card__supporting-text">

			            	<form id="my-form" action="#">
			              		<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
			              			<h6 style= "margin-top:0px; margin-bottom:0px;">Full Name</h6>
			                		<input class="mdl-textfield__input" type="text" id="fullname" value="<?php echo $fullname?>">
			              		</div>

			              		<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
			                		<h6 style= "margin-top:0px; margin-bottom:0px;">Address</h6>
			                		<input class="mdl-textfield__input" type="text" id="address" value="<?php echo $address?>">
			              		</div>

			              		<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
			                		<h6 style= "margin-top:0px; margin-bottom:0px;">Phone Number</h6>
			                		<input class="mdl-textfield__input" type="text" id="phone" value="<?php echo $phone?>">
			              		</div>

			              		<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
			                		<h6 style= "margin-top:0px; margin-bottom:0px;">Email ID</h6>
			                		<input class="mdl-textfield__input" type="text" id="email" value="<?php echo $email?>">
			              		</div>

			              		<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
			                		<h6 style= "margin-top:0px; margin-bottom:0px;">Position</h6>
			                		<input class="mdl-textfield__input" type="text" id="position" value="<?php echo $position?>">
			              		</div>

			              		<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" id="add-workplace">
			                		<h6 style= "margin-top:0px; margin-bottom:0px;">Add Workplace</h6>
			                		<div>
			                			<select id='workplace' class="style-select green semi-square">
			                				<?php echo $dropdown_list ?>
			                			</select>
			                		</div>
			                		<script>document.getElementById('workplace').value = "<?php echo $_SESSION['workplace'] ?>".toLowerCase()</script>
			              		</div>

			              		<br>
			              		<button class="mdl-button mdl-js-button mdl-button--raised mdl-button--accent" onclick="updateUser()">
			                		Update
			              		</button>
			            	</form>
		          		</div>
		  			</div>
		  		</div>
			</div>
		</div>
	</body>
</html>