<?php include('pdofile.php');?>
<?php

$username1=$_POST['postuname'];
$password1=$_POST['postpassword'];

// $username1="dhishan";
// $password1="123";
$find_uname = "select COUNT(*) from NextdoorDB.user_login where `uname`=:uname and `password`=:pass";
try{
	$stmp_login = $conn->prepare($find_uname);
	$stmp_login->bindParam(':uname',$username1,PDO::PARAM_STR,10);
	$stmp_login->bindParam(':pass',$password1,PDO::PARAM_STR,20);
	$stmp_login->execute();
}
catch(PDOException $exception){
	return $exception->getMessage();
}
	if($stmp_login->fetchColumn()){
			echo "true";
			$_SESSION['uname'] =  $username1;
	}
	else {
			echo "false";
	}
?>
