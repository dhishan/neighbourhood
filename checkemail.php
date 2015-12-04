<?php

$email=$_REQUEST['email'];

$conn = new mysqli("localhost","root","", "nextdoordb");
// Check connection
	if ($conn->connect_error) {
    	die("Connection failed: " . $conn->connect_error);
	}

	$sql="select email from user where email=?";
	$stmt = $conn->prepare($sql);
	$stmt->bind_param("s",$email);
	$stmt->execute();
	$stmt->store_result();
	$num_of_rows=$stmt->num_rows;
	$stmt->bind_result($emailid);

	if($num_of_rows == 0)
	{
		return true;
	}
	else return false;
	 
	
$stmt->close();

?>