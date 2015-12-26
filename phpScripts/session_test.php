<?php
require_once 'pdofile.php';

if(!isset($_SESSION['uname'])){
  echo "Error:2 Uname not set";
  die();
}

$uname = $_SESSION['uname'];
if(!(isset($_SESSION['uid']))){
 	$nquery= "SELECT `uid` FROM `user_login` WHERE `uname`= '".$uname."'";
	$stmt=$conn->query($nquery);
  	while ($row = $stmt->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT)) {
  		$_SESSION['uid'] = $row['uid'];
	}
}

$uid = $_SESSION['uid'];

if(!(isset($_SESSION['bid']))){
  $check = false;
  $query_mem_check = "SELECT * FROM `NextdoorDB`.`membership` WHERE `uid`= $uid";
  $stmt_mem_check = $conn->query($query_mem_check);
  while ($row = $stmt_mem_check->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT)) {
    $_SESSION['bid'] = $row['bid'];
    $check = true;
  }
  if(!$check){
    $query_bid_get = "SELECT `m_request`.`bid` FROM `NextdoorDB`.`m_request` WHERE `m_request`.`uid` = $uid and `m_request`.`acceptedat` = '0000-00-00 00:00:00'";
    $stmt_bid_get = $conn->query($query_bid_get);
    while ($row = $stmt_bid_get->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT)) {
      $_SESSION['bid'] = $row['bid'];
    }
  }

}
$bid = $_SESSION['bid'];
if(!(isset($_SESSION['nid']))){
  $query_nid_get = "SELECT `nid` FROM `NextdoorDB`.`blocks` WHERE `bid` = $bid;";
  $stmt_nid_get = $conn->query($query_nid_get);
  while ($row = $stmt_nid_get->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT)) {
    $_SESSION['nid'] = $row['nid'];
  }
}

if(!(isset($_SESSION['nid']) && isset($_SESSION['bid']) && isset($_SESSION['uid']))){
  echo "Error: Setting session variables";
  die();
}


 ?>
