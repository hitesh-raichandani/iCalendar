<?php

// Log out if there had been a user in session
session_start();
session_unset();

if(isset($_SESSION['user']) != "") {
	header("Location: landing_page.php");
}
// Set up the database structure in case
include_once 'setup_db.php';

// Connect to database
include_once 'mysql_connect.php';

// When the submit new user button is clicked
if(isset($_POST['submit_button']) && false) {
	// Grab all values
	$email = mysqli_real_escape_string($conn, $_POST['email']);
	$fullname = mysqli_real_escape_string($conn, $_POST['fullname']);
	$password = mysqli_real_escape_string($conn, $_POST['password']);
	$address = mysqli_real_escape_string($conn, $_POST['address']);
	$zipcode = mysqli_real_escape_string($conn, $_POST['zipcode']);
	$phone = mysqli_real_escape_string($conn, $_POST['phone']);
	$mobile = mysqli_real_escape_string($conn, $_POST['mobile']);

	mysqli_select_db($conn, 'users');

	$sql = "SELECT * FROM USERS
			WHERE email = '$email'";
	$result = mysqli_query($conn, $sql);

	if ($result && mysqli_num_rows($result) > 0) {
    	header("Location: invalid_login.php");
    	exit();
	}

	// Insert user into table: this method also adds the required tables associated
	// to the new user (messages, schedule)
	insert_user($email, md5($password), $fullname, $address, $zipcode, $phone, $mobile, $conn);
}

// When the user clicks the log in button
if(isset($_POST['login_button'])) {
	// Grab username and password
    $email = mysqli_real_escape_string($conn, $_POST['loginEmail']);
    $password = mysqli_real_escape_string($conn, $_POST['loginPsw']);
    
    // Select users database
    mysqli_select_db($conn, 'users');

    // Grab the user with the specified username
    $sql = "SELECT * FROM USERS WHERE email = '$email'";
    $result = mysqli_query($conn, $sql);
    $user = mysqli_fetch_array($result);

    $md5_pass = md5($password);
    // Check input with stored values
    if($user['password'] == $md5_pass) {
    	$_SESSION['email'] = $user['email'];
    	$_SESSION['fullname'] = $user['fullname'];
    	$_SESSION['address'] = $user['address'];
    	$_SESSION['zipcode'] = $user['zipcode'];
    	$_SESSION['phone'] = $user['phone'];
    	$_SESSION['mobile'] = $user['mobile'];
    	$_SESSION['id'] = $user['id'];
    	$_SESSION['table'] = "table_" . $user['id'];
    	$_SESSION['position'] = $user['position'];
    	$_SESSION['workplace'] = $user['workplace'];
        header("Location: Dashboard.php");
        exit();
    } else {
    	?><script>alert("Invalid Username or Password!");
    	window.location.href = "home.php"</script><?php
    	exit();
    }
}
?>

<!DOCTYPE html>
<html lang ="en">
<head>
<title> i Calendar</title>
<meta charset="UTF-8">
<meta name="I Calendar" content="HomePage">
<link rel="stylesheet" href="Homepage.css" type="text/css" />
<link rel="stylesheet" href="styles.css" type="text/css" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
<script src="pop_up.js"></script>
</head>
<body>
<div id="bcg">

<img class = "cone" src = "calendar-background.jpg" alt = "png">
	<img class = "ctwo" src = "calendar-background3.jpg" alt = "png">
     <img class = "cthree" src = "calendar-background2.jpg" alt = "png"> 
	      <img class = "cfour" src = "calendar-background1.jpg" alt = "png"> 
		     <img class = "cfive" src = "calendar-background4.jpg" alt = "png"> 
</div>
<div class="First">
	<div class="conatiner">
		<img src="img/12.gif" alt="LOGO">
		
		<div id="bar">
			<a href="">
			<div class="square"	id="login">
					LOGIN
			</div></a>
			<a href=""><div class="square" id="getstarted">
					GET STARTED
			</div></a>
		</div>
		
		<div id="mainText">
		<h1 class="large">Incredibly Easy to Use Scheduling Web Application</h1>		
		<p class="medium">iCalendar will save your 80% time on workforce managment and Scheduling</p>
		</div>
	</div>
</div>

<div id ="pop_background"></div>

			
			
<div id="background" onload="Fullname.focus()">
			<span class="close">&times;</span>
			
			<div id="SignUp"><img src="images/SignUp.png"></div>
			
			<div id="wrap">
			
			<form id="SignUpForm" method="POST">
			<ul>
			<li>
			<div id="User"><img src="images/User.png"></div>
			<div id="UserName">
			<input type = "text" name="fullname" id="Fullname" placeholder= "Full Name"  autocomplete="off" style="color:#888;" tabindex = 1 autofocus>
			</div>
			</li>	
			
			<li>
			<div id="Key"><img src="images/Key.png"></div>
			<div id="Password"><input type="password" name="password" id="password" placeholder = "Password" style="color:#888;" tabindex = 2></div>
			</li>
			
			<li>
			<div id="Email"><img src="images/Email.png"></div>
			<div id="EmailAddress"><input type="text" id="email" name="email" placeholder= "EmailAddress" style="color:#888;" tabindex = 3></div>
			</li>
			
			<li>
			<div id="Confirmemail"><img src="images/ConfirmEmail.png"></div>
			<div id="ConfirmEmail"><input type = "text" id="c_email" placeholder= "Confirm email" equalTo='#email' style="color:#888;" tabindex = 4></div>
			</li>
			
			
			<li>
			<div id="Location"><img src="images/Location.png"></div>
			<div id="Address"><input type = "text" id="address" name="address" placeholder = "Address" style="color:#888;" tabindex = 5></div>
			</li>
			
			<li>
			<div id="MailBox"><img src="images/MailBox.png"></div>
			<div id="Zipcode"><input type = "text" id="zip" name="zipcode" placeholder = "Zipcode" style="color:#888;" tabindex = 6 ></div>
			</li>
			
			<li>
			<div id="Phone"><img src="images/Phone.png"></div>
			<div id="PhoneNumber"><input type = "text" id="phone" name="phone" placeholder = "PhoneNumber" style="color:#888;" tabindex = 7></div>
			</li>
			
			<li>
			<div id="mobile"><img src="images/mobile.png"></div>
			<div id="MobileNumber"><input type = "tel" id="mob" name="mobile" placeholder= "mobile number" style="color:#888;" tabindex = 8></div>
			</li>
			
			<li>
			<div id="captcha"><img src="images/captcha.gif"></div>
			<div id="Bar"><input id="captchatext" style = "width:100px; height:20px;" type = "text" tabindex = 9></div>
			
			</li>

			<li><br><br><div id="Btn"><input id="submit" name="submit_button" style="text-align: center; width: 60px; background-color: #669900; color: #ffffff; margin: auto; clear: both;" value="Submit" readonly tabindex = 10 onclick="FormValidation()"></div></li>
			
			<li> <p id="errormessage"> </p></li>
			</ul>
			</form>
			</div>
		
	</div>
		
 <div id="login_popup" onload=LoginInput.focus()>
		<span class="close">&times;</span>
		
		
		<form id="loginform" action="#" method="POST">
		
		<h1 style="color:#ffffff;">Sign in</h1> 
		<input id="LoginInput" type="text" name="loginEmail" align= "middle" autocomplete="off" placeholder="Email ID" required autofocus>
		<br>
		<input id="LoginPassword" type="password" name="loginPsw" autocomplete="off" placeholder="Password" required>
		<br><br>
		<button type="submit" name="login_button">Sign In</button>	
		</form>
		
	
	
</div>




<div class="Second">
<div class=conatiner>
		
		<div id="SecondTxt">
		<h1 class="large">Make work simple and easy.</h1>
		<p class="medium">Designed to bring some sanity into a project manager's crazy life,<br>
our team calendar feature makes online project planning effortless.</p>
		
		</div>
		
		<div id="SecondImg">
		<img src="img/Todo.png" alt="TODO PIC">
		
		</div>
		

</div>
</div>

<div class="Third">
	<div id="ThirdImg">
		<img src="img/CalendarPic.png" alt="Calendar PIC">
		
	</div>
	
		<div id="ThirdContainer">
		<h1 class="large">		Plan.<br>
								Tweak.<br>
								Repeat.<br>

		</h1>
		<p>Simply click to modify<br> availability	</p>
		<p>See who's available and <br>who's booked	</p>
		
		<p>Filter your calendar <br> by projects	</p>
		<p>Set Public holidays	</p>
		
		
		<p>Share your calendar </p>
		<p>See availability of your <br>co-workers/employees</p>
		</div>
		
</div>

<div class="Fourth">
<div class=conatiner>
		
		<div id="FourthTxt">
		<h1 class="large">Less planning. More life.</h1>
		<p class="medium">Teamweek budgets your project manager’s hours, saving<br> you in costly overtime billing. Work smarter and enjoy<br> some me time.</p>
		
		</div>
		
		<div id="FourthImg">
		<img src="img/FourthPic.gif" alt="Fourth PIC">
		
		</div>
		

</div>



	

</div>


</body>
</html>