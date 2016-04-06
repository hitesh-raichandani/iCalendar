<?php
session_start();
session_unset();
$_SESSION = array();
$_POST = array();
?>
<!DOCTYPE html>

<head>
	<meta http-equiv="refresh" content="0; url=home.php" />
</head>
<body>
Invalid password
</body>
</html>
