
<html>
<head>
	<title>siningining</title>
</head>
<body>

<?php

session_start();

$username=$_REQUEST['username'];
$password=$_REQUEST['password'];

$conn = new mysqli("localhost","root","", "nextdoordb");
// Check connection
	if ($conn->connect_error) {
    	die("Connection failed: " . $conn->connect_error);
	}

	$stmt = $conn->prepare("select uname,password from user_login where uname=? and password=?");
	$stmt->bind_result($user,$pass);
	while($stmt->fetch())
	{
		if($username == $user)
	{
		echo ("Welcome back to Appliance Store!");
	}			
		
	else echo ("Welcome to Appliance Store! Have a great first experience!");

	}
$stmt->close();

?>
</body>

</html>

