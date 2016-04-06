<html>
	<head>
		<link rel="stylesheet" type="text/css" href="search-result.css">
		<link rel="stylesheet" type="text/css" href="Sceleton.css">
		<title>Search Result</title>
		<script src="search-result.js"></script>
		<script type="text/javascript" 
				src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
	</head>
	<body>
	<div class="header">
		<div id="logo"></div>
		<nav><ul>
			<a href="Dashboard.php"><li class="active" >Dashboard</li></a>
			<a href="Schedule.php" ><li >Schedule</li></a>
			<a href="SearchAvail.php"><li>Search Avail</li></a>
			<a href="Coworker.php"><li>Co-Workers</li></a>
			<a href="profile-page-new.php"><img src="img/corner.jpg" onmouseover="show()" > </img></a>

			<div id="imgdropdown" onmouseover="show()" onmouseout="hide()"> </div>
		</ul></nav>
	</div>
		<div class = "container">
			<div id = "page-info-display" class="effect2"><h2>Search Result</h2></div>
			<div id = "all-employee-display" class="effect2"></div>
		</div>
	</body>
	<?php 
	session_start();

	$response = $_SESSION['response'];
	$name_str = "[";
	$pic_str = "[";

	foreach ($response as $user) {
		$name_str .= "'" . $user['name'] . "',";
		$pic_str .= "'" . $user['picture'] . "',";
	}

	$name_str .= "]";
	$pic_str .= "]";
	echo "<script type='text/javascript'>
			names = $name_str
			pics = $pic_str
		  	displayEmployees(names, pics)
		  </script>";
	?>
</html>