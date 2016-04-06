<!DOCTYPE html>

<html>
	<head>
		
		<link href='http://fonts.googleapis.com/css?family=Oswald' rel='stylesheet' type='text/css'>
		<link rel="stylesheet" href="menu.css"  type="text/css" />
		<meta charset="utf-8"/>
		<TITLE></TITLE>
		<script 
		src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
		<script type="text/javascript" src='search-result.js'></script>
		<script>
			var d = new Date();
			var m = d.getMonth()+1;
			if ( m < 10)
				m = "0" + m.toString(); 
			var dt = (d.getDate()).toString();
			var y = d.getFullYear().toString();
			var h = d.getHours() % 12;
				if (h == 0)
					h = 12;
				else if ( h < 10)
					h = "0" + h;
			var min = d.getMinutes();
			if( min < 10 )
				min = "0" + min;
			if(dt <10)
				dt = "0" + dt;
			
			$( document ).ready(function(){
				document.getElementById('date-fmt').setAttribute("value", y + "-" + m + "-" + dt);
			});
			
		</script>
		
		
		
	</head>

	<body>
		
		
	<div class="header">
	
	<div id="logo"> </div>
	
		<nav><ul class="listul">
			<a class="navA" href="Dashboard.php"><li class="list menu">Dashboard 
					
				</li></a>
			<a class="navA" href="Schedule.php" ><li  class=" list">Schedule</li></a>
			<a class="navA" href="SearchAvail.php"><li class="list active">Search Avail</li></a>
			<a class="navA" href="Coworker.php"><li class="list">Co-Workers</li></a>
			<a class="navA" href="profile-page-new.php"><img src="img/corner.jpg" > </img></a>
		</ul></nav>
	
	
	</div>
	<div id = "workImage" style="border: none;">
	</div>


		<div id="TimeInterval">
			
			<label for="date-input">Date:</label>
			<input type="date" name="date-input" id="date-fmt">
			<br><br>
			<label for="from-time">From: </label>
		  	<input id = "ftime" type="time" name="from-time" value="00:00">
		  	<label for="to-time"><br>To: <br> </label>
		  	<input id = "ttime" type="time" name="to-time" value="00:00">
		  	<button type="submit" name="search_button" onclick="createEmployee()">Search</button>	

		</div>
		
		<script>
		$('#search_form :checkbox').click(function() {
    var $this = $('#comTime');
      
    if ($this.is(':checked')) {
        document.getElementById("ftime").readOnly = true;
		document.getElementById("ttime").readOnly = true;
		//attach the page onclick to search button over here
    } else {
        document.getElementById("ftime").readOnly = false;
		document.getElementById("ttime").readOnly = false;
		//attach the page onclick to search button over here
    }
});
</script>
	</body>
</html>