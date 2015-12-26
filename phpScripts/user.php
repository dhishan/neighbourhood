<?php
require_once 'session_test.php';

$uname = $_SESSION['uname'];
$uid=$_SESSION['uid'];

if(isset($_POST['userName'])){
  $nequery= "SELECT `fullname` FROM `user` WHERE `uid`='".$uid."'";
  $stmt=$conn->query($nequery);
  while ($row = $stmt->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT)) {
  	$user_fullname = $row['fullname'];
    echo "$user_fullname";
    die();
  }
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
    //fetch the block id from the membership table
    $nexquery_bid = "SELECT `bid` FROM `membership` WHERE uid='".$uid."'";
    $res_bid = $conn->query($nexquery_bid);
    $profile_bid= array();
    while ($row_bid = $res_bid->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT)) {
      $bid=$row_bid['bid'];
    }
    //fetch the current block name and its co-ordinates from the membership table
    $nexquery_block = "SELECT * FROM `blocks` WHERE bid='".$bid."'";
    $res_block = $conn->query($nexquery_block);
    $profile_block= array();
    while ($row_block = $res_block->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT)) {
       $bid = $row_block['bid'];
      $name = $row_block['name'];
      $ne_lat = $row_block['ne_latitude'];
      $ne_long = $row_block['ne_longitude'];
      $sw_long = $row_block['sw_longitude'];
      $sw_lat = $row_block['sw_latitude'];
      $nw_lat = $row_block['nw_latitude'];
      $nw_long = $row_block['nw_longitude'];
      $se_lat = $row_block['se_latitude'];
      $se_long = $row_block['se_longitude'];
    }

    //send it in the json array
     $proarray = array("uname"=>"$uname","email"=>"$pro_email","fullname"=>"$pro_fullname","intro"=>"$pro_intro","bid"=>"$bid","name"=>"$name","ne_long"=>"$ne_long","ne_lat"=>"$ne_lat","se_long"=>"$se_long","se_lat"=>"$se_lat","sw_long"=>"$sw_long","sw_lat"=>"$sw_lat","nw_lat"=>"$nw_lat","nw_long"=>"$nw_long");
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

if(isset($_POST['logout'])){
  $uid1 = $_SESSION['uid'];
$sqli = "UPDATE `NextdoorDB`.`user_login` SET `last_login` = CURRENT_TIMESTAMP WHERE `uid`= $uid1";
$stmt = $conn->query($sqli);
  session_unset();
}

if(isset($_POST['check_mem'])){


  $query_wait_cnt = "SELECT `m_request`.`acceptance_cnt` FROM `NextdoorDB`.`m_request` WHERE `m_request`.`uid` = $uid and `m_request`.`acceptedat` = '0000-00-00 00:00:00'";
  $stmt_wait_cnt = $conn->query($query_wait_cnt);
  while ($row1 = $stmt_wait_cnt->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT)) {
    echo "Wait-No.$row1[acceptance_cnt]";
    die();
  }

  $query_since_logout = "SELECT last_login FROM `user_login` as U JOIN `m_request` as M ON (U.uid = M.uid) WHERE U.`uid` = $uid and U.last_login < M.acceptedat;";
  $stmt_since_logout = $conn->query($query_since_logout);
  while ($row2 = $stmt_since_logout->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT)) {
    echo "Now";
    die();
  }

  $query_mem_check = "SELECT COUNT(*) as num FROM `NextdoorDB`.`membership` WHERE `uid`= $uid";
  $stmt_mem_check = $conn->query($query_mem_check);
  while ($row3 = $stmt_mem_check->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT)) {
    $present = (int)$row3['num'];
    if($present > 0){
      echo "Exist";
      die();
    }
  }


}




?>
