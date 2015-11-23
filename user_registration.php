<?php
session_start();

require 'connect.php';

if(isset($_POST['uname'])){
  //check if the username already exists
  //echo success or fail
  $uquery = "select from `user_login` where `uname`='".$_POST['uname']."'";

  if(!($user_query = $pdo->query($uquery))){
    echo "Retrieval of data from Database Failed - #".mysql_errno().": ".mysql_error();
  }
  if($user_query->num_rows > 0){
    echo "fail";
    return false;
  }
  else {
    echo "success";
    return false;
  }
}

if(isset($_POST['register'])){
  try{
    $stmt = $pdo->prepare("INSERT INTO `NextdoorDB`.`user` VALUES (NULL, DEFAULT, DEFAULT, DEFAULT, DEFAULT, DEFAULT, DEFAULT, DEFAULT, DEFAULT, DEFAULT)");
    $stmt->execute();
    $_SESSION['uid'] = $pdo->lastInsertId();
    echo $_SESSION['uid'];
    $stmp_login = $pdo->prepare("Insert into `NextdoorDB`.`user_login` values (:uid,:uname,:pass,DEFAULT)");
    $stmp_login->bindParam(':uid',$_SESSION['uid'],PDO::PARAM_INT,6);
    $stmp_login->bindParam(':uname',$_POST['uname'],PDO::PARAM_STR,10);
    $stmp_login->bindParam(':pass',$_POST['password'],PDO::PARAM_STR,20);
    $stmp_login->execute();
  }
  catch(PDOException $exception){
    return $exception->getMessage();
  }
}

echo "exception: ".$exception;

?>
