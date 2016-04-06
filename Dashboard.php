<?php

session_start();

// If no current session user, logout
if (!isset($_SESSION['id'])) {
	header("Location: logout.php");
}

// Connect to MySql
include_once 'mysql_connect.php';

// Get user to view
$user = $_SESSION['email'];
$id = $_SESSION['id'];
$user_table = $_SESSION['table'];

mysqli_select_db($conn, "MESSAGES");

// Make select query
$sql = "SELECT * FROM $user_table";
$result = mysqli_query($conn, $sql);

if (isset($_POST['send_msg'])) {
	$sender = $user;
	$recipient = mysqli_real_escape_string($conn, $_POST['recipient']);
	$msg_text = mysqli_real_escape_string($conn, $_POST['msg_text']);
	$date = time();

	// Check if recipient exists
	if(mysqli_num_rows(mysqli_query($conn, "SHOW TABLES LIKE '".$recipient."'"))<0) {
		?><script>alert("Recipient does not exist");</script><?php
	} else {
		$sql = "INSERT INTO $recipient (recipient, sender, msg_text, time_sent)
				VALUES ('$recipient', '$sender', '$msg_text', '$date')";
		$send_result = mysqli_query($conn, $sql);
		if ($send_result) {
			?><script>alert("Message sent!");</script><?php
		} else {
			?><script>alert("Message not sent!");</script><?php
		}
	}

}

	$user_id = $_SESSION['id'];
	$table_name = "table_" . $user_id;

	mysqli_select_db($conn, "schedules");

	$sql = "SELECT * FROM $table_name";
	$cal_result = mysqli_query($conn, $sql);
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
	$profile_picture_sm = "'http://sharedseeker.com/file/profile_image/default_profile.jpg'";
	$profile_picture_lg = "'http://sharedseeker.com/file/profile_image/default_profile.jpg'";
} else {
	$profile_picture_sm = "'$picture'";
	$profile_picture_lg = "'$picture'";
}


?>

<!DOCTYPE html>

<html>
	<head>
		<link rel="stylesheet" type="text/css" href="Sceleton.css">
		<link href='http://fonts.googleapis.com/css?family=Oswald' rel='stylesheet' type='text/css'>
		<meta charset="utf-8"/>

		<TITLE></TITLE>
		<script 
		src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
	<script>
		
		function show(){
			document.getElementById("imgdropdown").style.visibility="visible";
		}
		function hide(){
		document.getElementById("imgdropdown").style.visibility="hidden";
		
		}
		$(document).on("click","#tick", function (e) {
		  e.preventdefault;
		  $(this).parents('.email').fadeOut(300);
		      $.ajax({
		        method: 'get',
		        url: 'delete_message.php',
		        data: {
		            'id': $(this).parents('.email').val()
		        },
		        success: function(data) {
		            alert(data);
		        }
    });
});
	</script>
	<style>
	
	
 
#BOX{
	position: relative;
	height: 30%;
	width : 70%;
	top : 50px;
	left : 350px;
	margin : 20px 20px;
	
	padding-top: 40px;
	background-color: #3498db ;
  font-family: "Helvetica", sans serif;
}

.content {
  width: 800px;
  background-color: #fff;
  margin: auto;
  box-shadow: 0 1px 3px rgba(0, 0, 0, .35);
}

.email {
  padding: 20px 30px;
  display: flex;
  justify-content: space-between;
  align-items: center;
  font-size: 12px;
  color: #ff6839;
  border-bottom: 1px solid #CFCFCF;
  box-sizing: border-box;
}



.email-content {
  color: #888888;
  position: relative;
  width: 400px;
}

.subject-container {
  width: 200px;
}

.email .subject-container i {
  font-size: 20px;
  margin-right: 25px;
}

.update {
  color: #ff6839;
}

.promo {
  color: #00bcd4;
}

.social {
  color: #689f38;
}

#tick{
 position: absolute;
 height: 30px;
 width: auto;
 right: 20px;
 top: -7px;
 opacity: 0.8;

}

#cross{
 position: absolute;
 height: 30px;
 width: auto;
 right: -20px;
 top: -7px;
 opacity: 0.8;

}


.day-indicator {
  display: flex;
  justify-content: space-between;
  width: 800px;
  margin: auto;
  color: #FFF;
  box-sizing: border-box;
  padding: 20px 20px;
  font-size: 14px;
}
	
	
	</style>

	<script src="dhtmlxscheduler.js?v=4.1" type="text/javascript" charset="utf-8"></script>
	<script src="ext/dhtmlxscheduler_year_view.js?v=4.1" type="text/javascript" charset="utf-8"></script>
	<link rel="stylesheet" href="dhtmlxscheduler.css?v=4.1" type="text/css" media="screen" title="no title" charset="utf-8">
	
	<style type="text/css" media="screen">
	html, body{
		margin:0px;
		padding:0px;
		height:100%;
		overflow:scroll;
	}	
	</style>


	<script type="text/javascript" charset="utf-8">
	DATES = {"Jan":1,"Feb":2,"Mar":3,"Apr":4,"May":5,"Jun":6,"Jul":7,"Aug":8,"Sep":9,"Oct":10,"Nov":11,"Dec":12}
	function toProperFormat(date_str) {
		date_string = "" + date_str
		words = date_string.split(' ');
		month = DATES[words[1]]
		day = words[2]
		year = words[3]
		hour = words[4].split(":")[0]
		min = words[4].split(":")[1]
		str = "" + year + "-" + month + "-" + day + " " + hour + ":" + min
		console.log(str)
		return str
	}
	function insertEvent(name, start, end) {
    $.ajax({
        method: 'get',
        url: 'insert_event.php',
        data: {
            'event_name': name,
            'start_date': toProperFormat(start),
            'end_date': toProperFormat(end),
        },
        success: function(data) {
            if (data.length != "") {
            	alert("ERROR: " + data);
            }
        }
    });
}
	function init() {

		window.resizeTo(950,700)
		modSchedHeight();
		scheduler.config.xml_date="%Y-%m-%d %H:%i";
		scheduler.config.first_hour = 8;
		scheduler.config.multi_day = true;
		scheduler.config.date_step = "5"
scheduler.init('scheduler_here',new Date(),"day");
		scheduler.templates.event_class=function(s,e,ev){ return ev.custom?"custom":""; };

		// 
		scheduler.load("./xml/events.xml?v=35");
				var events = [
		<?php
		if (mysqli_num_rows($cal_result) > 0) {
    		while($row = mysqli_fetch_assoc($cal_result)) {
		        $start = $row['start_date'];
		        $end = $row['end_date'];
		        $name = $row['name'];
		        echo "{ start_date:'$start', end_date:'$end', text:'$name'},"; 
    		}
		}?>
		];
 
		scheduler.parse(events, "json");
		var dragged_event;
		scheduler.attachEvent("onBeforeDrag", function (id, mode, e){
  	  dragged_event=scheduler.getEvent(id); //use it to get the object of the dragged event
  	  return true;
});
 
scheduler.attachEvent("onDragEnd", function(){
    var event_obj = dragged_event;
    //your custom logic
});
 scheduler.attachEvent("onEventAdded", function(id,ev){
    //any custom logic here
    insertEvent(ev.text, ev.start_date, ev.end_date)

});
	}
</script>

	
	</head>

<body onload="init();" onresize="modSchedHeight()">

		
		<style>
        a img{
            border: none;
        }
        li{
            list-style: none;
        }
    </style>
	<script>
		function modSchedHeight(){
			var headHeight = 200;
			var headWidth = 350;
			var sch = document.getElementById("scheduler_here");
                        if (!sch) return;
			sch.style.height = (parseInt(document.body.offsetHeight)-headHeight)+"px";
			sch.style.width = (parseInt(document.body.offsetWidth)-headWidth)+"px";
			
			<!-- var contbox = document.getElementById("contbox"); -->
			<!-- contbox.style.width = (parseInt(document.body.offsetWidth)-300)+"px"; -->

		}
	</script>
	
	<div class="header">
	
	<div id="logo"> </div>
	
	<nav><ul>
			<a href="#"><li class="active" >Dashboard</li></a>
			<a href="Schedule.php" ><li >Schedule</li></a>
			<a href="SearchAvail.php"><li>Search Avail</li></a>
			<a href="Coworker.php"><li>Co-Workers</li></a>
			
			
			<a href="profile-page-new.php"><img src="<?php echo $picture ?>" style="height:50px; width: 50px;"> </img></a>
			
		</ul></nav>
	
	
	</div>
	
	<div class="sidebar">
		
	<nav><ul>
			<a href="Dashboard-inbox.php" ><li >Inbox</li></a>
			<a href="profile-page-new.php" ><li >Profile</li></a>
			<a href="Support.php" ><li>Support</li></a>
			<a href="logout.php" ><li>Logout</li></a>
			
		</ul></nav>
	
 </div>
	
	 <!-- <div class = "basic">  -->
	<!-- <h1 style = "color:red"> Welcome on board </h1><br><br> -->
	<!-- <p> <b>KUSH is going to add a DAY view of Schedule </b></p> -->
	 
	 		<!-- <div id="contbox" > -->
		
			<!-- <div style="padding-left: 205px; min-width: 200px;"> -->
               
    		
            <!-- </div> -->
		<!-- </div> -->
	
	<!-- </div>  -->
	<!-- end. info block -->
    <!-- <ul> 
        <li>
            <a></a>
            <span></span>
        </li>
    </ul>
 -->
	
	<div id="scheduler_here" class="dhx_cal_container" style='width:70%;height:80% !important; margin: 0 auto;margin-top: 100px;margin-left:320px'>
		<div class="dhx_cal_navline">
			<!-- <div class="dhx_cal_prev_button">&nbsp;</div> -->
			<!-- <div class="dhx_cal_next_button">&nbsp;</div> -->
			<!-- <div class="dhx_cal_today_button"></div> -->
			<div class="dhx_cal_date"></div>
			<!-- <div class="dhx_cal_tab" name="day_tab" style="right:332px;"></div> -->
			<!-- <div class="dhx_cal_tab" name="week_tab" style="right:268px;"></div> -->
			<!-- <div class="dhx_cal_tab" name="month_tab" style="right:204px;"></div> -->
			<!-- <div class="dhx_cal_tab" name="year_tab" style="right:140px;"></div> -->
		</div>
		<div class="dhx_cal_header">
		</div>
		<div class="dhx_cal_data">
		</div>		
	</div>
	

	
	
	
	</body>
	
</html>