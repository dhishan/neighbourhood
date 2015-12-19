<?php
require_once 'pdofile.php';

//$uname = $_SESSION['uname']; //TODO: remove comment
$uname="dhishan"; //TODO: comment
if(!(isset($_SESSION['uname']))){
 	$nquery= "SELECT `uid` FROM `user_login` WHERE `uname`= '".$uname."'";
	$stmt=$conn->query($nquery);
  	while ($row = $stmt->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT)) {
  		$_SESSION['uid'] = $row['uid'];
	}
}
//get uid from uname
//set session variable of uid;
if(isset($_POST['userName'])){
  $uid="1"; //TODO: comment
  //$uid=$_SESSION['uid']; //TODO: remove comment
	$nequery= "SELECT `fullname` FROM `user` WHERE `uid`='".$uid."'";
  $stmt=$conn->query($nequery);
  while ($row = $stmt->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT)) {
  	$user_fullname = $row['fullname'];
  echo "$user_fullname";
  }
  die();

}

if((isset($_POST['displaypro']))){
  $uid="1"; //TODO: comment
  //$uid=$_SESSION['uid']; //TODO: remove comment
	$nexquery = "SELECT `email`,`fullname`,`intro` FROM `user` WHERE uid='".$uid."'";
  $res = $conn->query($nexquery);
  $profile= array();

  while ($row = $res->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT)) {

    $pro_email = $row['email'];
    $pro_fullname = $row['fullname'];
    $pro_intro = $row['intro'];

     $proarray = array("uname"=>"$uname","email"=>"$pro_email","fullname"=>"$pro_fullname","intro"=>"$pro_intro");
   }
   echo(json_encode($proarray));
   die();
 }

// change full name
if(isset($_POST['changePro']))
{
  //update fullname
  $newfullname=$_POST['fullname'];
  $uid="1"; //TODO: comment
  //$uid=$_SESSION['uid']; //TODO: remove comment
	$nequery= "UPDATE  `user` set fullname='".$newfullname."' WHERE `uid` ='".$uid."'";
  $stmt=$conn->query($nequery);

  //update intro
  $newintro=$_POST['intro'];
  $nequery= "UPDATE  `user` set intro='".$newintro."' WHERE `uid` ='".$uid."'";
  $stmt=$conn->query($nequery);

  die();
}







?>
