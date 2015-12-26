<?php
require_once 'session_test.php';

$uid=$_SESSION['uid'];
$bid=$_SESSION['bid'];

if(isset($_POST['memreq'])){//TODO:remove!

  $nidq4 = "SELECT `fullname` from `user` where `uid`=:userid";
  $stmp_find_name = $conn->prepare($nidq4);
  $newvars = array();

  $mquery = "SELECT * FROM `m_request` where `bid`='".$bid."' AND `acceptance_cnt` > 0";
  $stmt_find_users=$conn->query($mquery);

  while ($row_block = $stmt_find_users->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT)) {
    if((int)$row_block['uid1'] == 85 or (int)$row_block['uid2'] or (int)$row_block['uid3'])
    {
      continue;
    }
    $m_fullname="";
    $uida = (int)$row_block['uid'];

    $stmp_find_name->bindParam(':userid',$uida,PDO::PARAM_INT,6);
    $stmp_find_name->execute();
     while ($row4 = $stmp_find_name->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT)) {
        $m_fullname = $row4['fullname'];
    }

    $newvars[] = array('uname' => "$m_fullname",'uid' => "$uida");
  }
  echo json_encode($newvars);
  die();
}

if(isset($_POST['accept'])){
  if($_POST['accept'] == "membership_block"){

    $accept_uid=$_POST['accept_uid'];
    $sql1="SELECT * FROM `NextdoorDB`.`m_request` WHERE `uid`=".$accept_uid." AND `bid`=".$bid.";";
	  $stmt1=$conn->query($sql1);
	  while ($row = $stmt1->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT)) {
      $acnt = intval($row['acceptance_cnt']);
      if($acnt > 1){
        $acnt--;
        if($row['uid1']==""){
          $updt = "UPDATE `NextdoorDB`.`m_request` SET `uid1` = $uid, `acceptance_cnt` = $acnt WHERE `uid` = $accept_uid AND `bid` = $bid;";}
        else if($row['uid2']==""){
          $updt = "UPDATE `NextdoorDB`.`m_request` SET `uid2` = $uid, `acceptance_cnt` = $acnt WHERE `uid` = $accept_uid AND `bid` = $bid;";}
        else if($row['uid3']==""){
          $updt = "UPDATE `NextdoorDB`.`m_request` SET `uid3` = $uid, `acceptance_cnt` = $acnt WHERE `uid` = $accept_uid AND `bid` = $bid;";}

        if(!$conn->query($updt)){
          echo "Error:6";
        }
        echo "Success 1";
        die();
      } else {
          $updt = "UPDATE `NextdoorDB`.`m_request` SET `uid3` = $uid, `acceptance_cnt` = '0', `acceptedat` = CURRENT_TIMESTAMP WHERE `uid` = $accept_uid AND `bid` = $bid;";
          if(!$conn->query($updt)){
            echo "Error:6 Database";
          }
          $inst = "INSERT INTO `NextdoorDB`.`membership` (`uid`, `bid`, `since`) VALUES ($accept_uid,$bid,CURRENT_TIMESTAMP);";
          if(!$conn->query($inst)){
            echo "Error:6 Database insert into membership";
          }
          echo "Success 2";
          die();
      }
    }
  }
}

 ?>
