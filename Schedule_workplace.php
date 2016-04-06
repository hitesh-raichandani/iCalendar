<?php
	session_start();

	if (!isset($_SESSION['id'])) {
		header("Location: logout.php");
		exit();
	}

	// Connect to MySql
	include_once 'mysql_connect.php';
	$work = $_SESSION['workplace'];
	mysqli_select_db($conn, "users");
	$sql = "SELECT * from users
			WHERE workplace = '$work'";
	$result = mysqli_query($conn, $sql);
	$user_tables = array();
	if (mysqli_num_rows($result) > 0) {
		while($row = mysqli_fetch_assoc($result)) {
			$user_tables[] = "table_" . $row['id'];
			$user_names[] = $row['fullname'];
		}
	}
	mysqli_select_db($conn, "schedules");
	$scheds = "";
	for ($i = count($user_tables) - 1; $i >= 0; $i -= 1) {
		$sql = "SELECT * FROM $user_tables[$i]";
		$result = mysqli_query($conn, $sql);
		while($row = mysqli_fetch_assoc($result)) {
				$table_name = "table_" + $row['id'];
				$sql = "SELECT * FROM $table_name";
				$sched_result = mysqli_query($conn, $sql);
				if (mysqli_num_rows($result) > 0) {
    				while($row = mysqli_fetch_assoc($result)) {
				        $start = $row['start_date'];
				        $end = $row['end_date'];
				        $name = $row['name'];
				        $text = $user_names[$i] . " - " . $name;
				        $scheds .= "{ start_date:'$start', end_date:'$end', text:'$text'},"; 
    				}
				}
			}
		}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<head>


	<link rel="stylesheet" type="text/css" href="sss.css">
		<link href='http://fonts.googleapis.com/css?family=Oswald' rel='stylesheet' type='text/css'>
		<meta "charset=utf-8"/>
		<TITLE></TITLE>
		<script 
		src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
	
		<script>
		$(document).on("click", 'ul li', function(){
    $('ul li').removeClass('active');
    $(this).addClass('active');
});
		</script>

	<meta http-equiv="Content-type" content="text/html; charset=utf-8">
	<title>Event Calendar Demo - dhtmlxScheduler</title>
	<meta name="description" content="This demo shows a simple JavaScript event calendar where the user can browse the events in Day, Week, Month, Year, or Agenda Views.">
	<meta name="keywords" content="javascript, scheduler, event calendar, events calendar, event, calendar, ajax, google-like">	
</head>
	<script src="codebase/dhtmlxscheduler.js?v=4.1" type="text/javascript" charset="utf-8"></script>
	<script src="codebase/ext/dhtmlxscheduler_year_view.js?v=4.1" type="text/javascript" charset="utf-8"></script>
	<link rel="stylesheet" href="codebase/dhtmlxscheduler.css?v=4.1" type="text/css" media="screen" title="no title" charset="utf-8">

	
<style type="text/css" media="screen">
	html, body{
		margin:0px;
		padding:0px;
		height:100%;
		overflow:hidden;
	}	
	.dhx_cal_event_line.custom, .dhx_cal_event.custom div{
		background-color:#fd7;
		border-color:#da6;
		color:#444;
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
		var getEpochMillis = function(dateStr) {
  var r = /^\s*(\d{4})-(\d\d)-(\d\d)\s+(\d\d):(\d\d):(\d\d)\s+UTC\s*$/
    , m = (""+dateStr).match(r);
  return (m) ? Date.UTC(m[1], m[2]-1, m[3], m[4], m[5], m[6]) : undefined;
};
		window.resizeTo(950,700)
		modSchedHeight();
		scheduler.config.xml_date="%Y-%m-%d %H:%i";
		scheduler.config.first_hour = 8;
		scheduler.config.multi_day = true;
		scheduler.config.date_step = "5"
		scheduler.init('scheduler_here', new Date());
		scheduler.templates.event_class=function(s,e,ev){ return ev.custom?"custom":""; };
		scheduler.load("./xml/events.xml?v=35");

		var events = [
		<?php
			echo $scheds;
		?>
		];
		console.log(events)
 
		var eventobject =scheduler.parse(events, "json");

		var dragged_event;
		scheduler.attachEvent("onBeforeDrag", function (id, mode, e){
  		  dragged_event=scheduler.getEvent(id); //use it to get the object of the dragged event
  	 	 return true;
			});
 
		scheduler.attachEvent("onDragEnd", function(){
   		 var event_obj = dragged_event;
		});
 		scheduler.attachEvent("onEventAdded", function(id,ev){
    		insertEvent(ev.text, ev.start_date, ev.end_date)
		});
	}

</script>

<body onload="init();" onresize="modSchedHeight()">
	
	
	
	
	
	
	<!-- info block 
		href-prev
		href-next
		title
		desc-short
		desc-long
-->
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
			var headHeight = 100;
			var sch = document.getElementById("scheduler_here");
                        if (!sch) return;
			sch.style.height = (parseInt(document.body.offsetHeight)-headHeight)+"px";
			var contbox = document.getElementById("contbox");
			contbox.style.width = (parseInt(document.body.offsetWidth)-300)+"px";
		}
	</script>
	<div class="header">
	
	<div id="logo"> </div>
	
	<nav><ul class="listul">
			<a class="navA" href="Dashboard.php"><li class="list menu">Dashboard 
					<ul class="submenu">
					  <li><a href="Dashboard-inbox.php">Inbox</a></li>
					  <li><a href="profile-page-new.php">Profile</a></li>
					</ul>
				</li></a>
			<a class="navA" href="Schedule.php" ><li  class=" list active">Schedule</li></a>
			<a class="navA" href="SearchAvail.php"><li class="list">Search Avail</li></a>
			<a class="navA" href="Coworker.php"><li class="list">Co-Workers</li></a>
			<a class="navA" href="profile-page-new.php"><img src="img/corner.jpg" > </img></a>
		</ul></nav>


	
	<!-- <div style="position: relative; height:95px;background-color:#3D3D3D;border-bottom:5px solid #828282;">-->
		<!-- <a style="position: absolute; left: 25px; top: 22px; z-index: 10;" href="sample_mobile.shtml"><img src="images/btn-left.gif" alt="hell is here"></a>  -->
		<div id="contbox" style="position: relative; padding: 22px 25px 0 75px; font: normal 17px Arial, Helvetica; color:white;">
		
			<div style="padding-left: 205px; min-width: 400px;">
               
    		
            </div>
		</div>
	
	<!-- </div> -->
	<!-- end. info block -->
    <ul>
        <li>
            <a></a>
            <span></span>
        </li>
    </ul>

	
	<div id="scheduler_here" class="dhx_cal_container" style='width:90%;height:100%; margin: 0 auto'>
		<div class="dhx_cal_navline">
			<div class="dhx_cal_prev_button">&nbsp;</div>
			<div class="dhx_cal_next_button">&nbsp;</div>
			<div class="dhx_cal_today_button"></div>
			<div class="dhx_cal_group_button" onclick="location.href='Schedule.php'">Individual</div>
			<div class="dhx_cal_date"></div>
			<div class="dhx_cal_tab" name="day_tab" style="right:332px;"></div>
			<div class="dhx_cal_tab" name="week_tab" style="right:268px;"></div>
			<div class="dhx_cal_tab" name="month_tab" style="right:204px;"></div>
			<div class="dhx_cal_tab" name="year_tab" style="right:140px;"></div>
		</div>
		<div class="dhx_cal_header">
		</div>
		<div class="dhx_cal_data">
		</div>		
	</div>
	</div>
	
</body>