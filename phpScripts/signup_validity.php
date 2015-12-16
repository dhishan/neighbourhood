<?php
require_once 'pdofile.php';

if(isset($_POST['unamecheck'])){
  $query = "select uname_check('".$_POST['unamecheck']."') as val";
  $res = $conn->query($query);
  $result = $res->fetch(PDO::FETCH_ASSOC);
  if($result['val'] == 1){
      echo "false";
  }else echo "true";
}
if(isset($_POST['emailcheck'])){
  $query1 = "select check_email('".$_POST['emailcheck']."') as val1";
  $res1 = $conn->query($query1);
  $result1 = $res1->fetch(PDO::FETCH_ASSOC);
  if($result1['val1'] == 1){
      echo "false";
  }else echo "true";
}
if(isset($_POST['signup'])){
  $insq = "INSERT INTO `nextdoordb`.`user`(`uid`,`email`,`fullname`,`streetadr1`,`streetadr2`,`city`,`state`,`zip`,`intro`,`ppic`) VALUES (NULL,:email,:fullname,\"\",NULL,\"\",\"\",'0',NULL,NULL)";
  $stmp_signup = $conn->prepare($insq);
  $stmp_signup->bindParam(':email',$_POST['email'],PDO::PARAM_STR,80);
  $stmp_signup->bindParam(':fullname',$_POST['fullname'],PDO::PARAM_STR,20);
  $stmp_signup->execute();
  //get the last inserted user id and save it in session variable
  $insunq = "INSERT INTO `nextdoordb`.`user_login`(`uid`,`uname`,`password`,`last_login`) VALUES (last_insert_id(),:uname,:password,'CURRENT_TIMESTAMP')";
  $stmp_signup1 = $conn->prepare($insunq);
  $stmp_signup1->bindParam(':uname',$_POST['uname'],PDO::PARAM_STR,10);
  $stmp_signup1->bindParam(':password',$_POST['password'],PDO::PARAM_STR,20);
  $stmp_signup1->execute();
  $_SESSION['uname']=$_POST['uname'];
  die();
}

?>
