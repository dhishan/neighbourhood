<?php
require_once 'session_test.php';

$uid = $_SESSION['uid'];
if(isset($_POST['friends'])){
  $query_get_friends = "SELECT `uid2` FROM `NextdoorDB`.`relationship` WHERE `uid1` = $uid and type='friend' UNION SELECT `uid1` FROM `NextdoorDB`.`relationship` WHERE uid2 = $uid and type='friend' ;";
  $stmt_get_friends = $conn->query($query_get_friends);
  $nidq4 = "SELECT `fullname` from `user` where `uid`=:userid";
  $stmt4=$conn->prepare($nidq4);
  $friends = array();

  while ($row = $stmt_get_friends->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT)) {

    $m_fullname="";
    $uida = $row['uid2'];
    $stmt4->bindParam(':userid',$uida,PDO::PARAM_INT,6);
    $stmt4->execute();
     while ($row4 = $stmt4->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT)) {
        $m_fullname = $row4['fullname'];
    }
    $friends[] = array("uid" => "$uida","fullname"=>"$m_fullname");
  }
  echo json_encode($friends);
  die();
}

if(isset($_POST['findfriends'])){
  $keyword = $_POST['keyword'];
  $query_find_friends = "SELECT `uid`,`fullname` FROM NextdoorDB.user WHERE fullname LIKE '%$keyword%';";
  $stmt_find_friends = $conn->query($query_find_friends);
  $friends = array();
  while ($row = $stmt_find_friends->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT)) {
    $uida = $row['uid'];
    $name = $row['fullname'];
    $friends[] = array("uid" =>"$uida" ,"fullname"=>"$name" );
  }
  echo json_encode($friends);
  die();
}

if(isset($_POST['frequest'])){
  $user  = $_SESSION['uid'];
  $friend = $_POST['frienduid'];
  $query_send_request = "INSERT INTO `NextdoorDB`.`f_request` VALUES($user,$friend,'waiting')";
  if(!$conn->query($query_send_request)){
    echo "Error10";
    die();
  }
  echo "Success";

}

if(isset($_POST['delfriends'])){
  echo "string";
  $uid = $_SESSION['uid'];
  $user = $_POST['uid'];
  $query_del_friend = "DELETE FROM `NextdoorDB`.`relationship` WHERE `uid1` = $uid;";
  if(!$conn->query($query_del_friend)){
    echo "Error15";
  }
  $query_del_friend = "DELETE FROM `NextdoorDB`.`relationship` WHERE `uid2` = $uid;";
  if(!$conn->query($query_del_friend)){
    echo "Error16";
  }
  echo "Success";
  die();
}

if(isset($_POST['requests'])){
  $uid = $_SESSION['uid'];
  $query_get_requests = "SELECT `uid_requested_by` FROM `NextdoorDB`.`f_request` WHERE `uid_requested_of`= $uid and STATUS = 'waiting'";
  $stmt_get_requests = $conn->query($query_get_requests);
  $query_req_name = "SELECT `fullname` from `user` where `uid`=:userid";
  $stmt_req_name=$conn->prepare($query_req_name);
  $friends = array();

  while ($row = $stmt_get_requests->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT)) {

    $m_fullname="";
    $uida = $row['uid_requested_by'];
    $stmt_req_name->bindParam(':userid',$uida,PDO::PARAM_INT,6);
    $stmt_req_name->execute();
     while ($row4 = $stmt_req_name->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT)) {
        $m_fullname = $row4['fullname'];
    }
    $friends[] = array("uid" => "$uida","fullname"=>"$m_fullname");
  }
  echo json_encode($friends);
  die();
}

if(isset($_POST['acceptreq'])){
  $uid=$_SESSION['uid'];;
  $userid = $_POST['uid'];
  $query_accept_friend = "UPDATE `NextdoorDB`.`f_request` SET `status` = 'accepted' WHERE `uid_requested_by` = $userid AND `uid_requested_of` = $uid;";
  if(!$conn->query($query_accept_friend)){
    echo "Error:16";
    die();
  }
  $query_accept_friend_2 = "INSERT INTO `NextdoorDB`.`relationship`(`uid1`,`uid2`,`type`,`since`)VALUES($userid,$uid,'friend',CURRENT_TIMESTAMP);";
  if(!$conn->query($query_accept_friend_2)){
    echo "Error:17";
    die();
  }
  echo "Success";

}
 ?>
