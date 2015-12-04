<?php include('pdofile.php');?>
<?php
session_start();

$username=$_REQUEST['username'];
$password1=$_REQUEST['password'];

	$sql="select uname,password from user_login where uname=? and password=?";
	$stmt = $conn->prepare($sql);
	$stmt->execute(array($username,$password1));
//	$stmt->store_result();
	$num_of_rows=$stmt->rowCount();
	$results=$stmt->fetchAll(PDO::FETCH_ASSOC);

	if($stmt->rowCount())
	{

			echo 'Name: '.$username.'<br>';
      echo 'Username: '.$password1.'<br>';

	}
		else {header("location:login1.php?flag=1");}
?>
