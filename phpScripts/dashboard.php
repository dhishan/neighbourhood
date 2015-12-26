<?php
require_once 'session_test.php';

$nid = $_SESSION['nid'];
$bid = $_SESSION['bid'];
$uid = $_SESSION['uid'];

if(isset($_POST['neighbourpost']) || isset($_POST['blockspost'])){//TODO:remove !


  $posts = array(); //array to contain json objects
  if(isset($_POST['neighbourpost'])){
    $nidq3="SELECT * from `NextdoorDB`.`messages` JOIN `NextdoorDB`.`threads` on `messages`.`tid`=`threads`.`tid` where `threads`.`scope`='neighbourhood' and `threads`.`scope_id`='".$nid."'";
  }else {
    $nidq3="SELECT * from `NextdoorDB`.`messages` JOIN `NextdoorDB`.`threads` on `messages`.`tid`=`threads`.`tid` where `threads`.`scope`='block' and `threads`.`scope_id`='".$bid."'";
  }
  $nidq4 = "SELECT `fullname` from `user` where `uid`=:userid";
  $stmt4=$conn->prepare($nidq4);

  $stmt2=$conn->query($nidq3);
    while ($row = $stmt2->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT)) {
      $m_mid = $row['mid'];
      $m_author = $row['author'];
      $m_body = $row['m_body'];
      $m_tid = $row['tid'];
      $m_subject = $row['subject'];
      $m_image = $row['image'];
      $m_latitude = $row['latitude'];
      $m_longitude = $row['longitude'];
      $m_readflag=$row['ReadFlag'];

      $m_fullname="";
      $uida = (int)$m_author;
      $stmt4->bindParam(':userid',$uida,PDO::PARAM_INT,6);
      $stmt4->execute();
       while ($row4 = $stmt4->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT)) {
          $m_fullname = $row4['fullname'];
      }
      $posts[] = array("tid"=>"$m_tid","mid"=>"$m_mid","m_body"=>"$m_body","image"=>"$m_image","lat"=>"$m_latitude","long"=>"$m_longitude","readflag"=>"$m_readflag","fullname"=>"$m_fullname","subject"=>"$m_subject");

     }
  echo (json_encode($posts));


  die();

}





if (isset($_POST['create_new_post'])) {


    $filename_full = "";
    $relpath="";
    $mid="999";
    $tst = false;
    $create_thread = "INSERT INTO `nextdoordb`.`threads`(`tid`,`subject`,`scope`,`scope_id`,`start_time`) VALUES (NULL,:subject,:scope,:scopeid,CURRENT_TIMESTAMP)";
    $stmp_create_thread = $conn->prepare($create_thread);
    $stmp_create_thread->bindParam(':subject',$_POST['subject'],PDO::PARAM_STR,40);
    $stmp_create_thread->bindParam(':scope',$_POST['scope'],PDO::PARAM_STR);
    if($_POST['scope'] == "neighbourhood"){
      $stmp_create_thread->bindParam(':scopeid',$_SESSION['nid'],PDO::PARAM_INT,6);
    }else if($_POST['scope'] == "personnel"){
      $stmp_create_thread->bindParam(':scopeid',$_POST['scopeid'],PDO::PARAM_INT,6);
    }else {
      $stmp_create_thread->bindParam(':scopeid',$_SESSION['bid'],PDO::PARAM_INT,6);
    }
    $stmp_create_thread->execute();

    $uid=$_SESSION['uid'];
    $m_body=$_POST['msg_body'];
    $long = $_POST['longitude'];
    $lat = $_POST['latitude'];
    $insert_msg_new = "INSERT INTO `NextdoorDB`.`messages`(`mid`,`author`,`m_body`,`tid`,`postedat`,`latitude`,`longitude`) VALUES (NULL,:user,:msg_body,last_insert_id(),CURRENT_TIMESTAMP,:lat,:lng);";
    $stmp_msg_new= $conn->prepare($insert_msg_new);
    $stmp_msg_new->bindParam(':user',$uid,PDO::PARAM_INT,6);
    $stmp_msg_new->bindParam(':msg_body',$m_body,PDO::PARAM_STR);
    $stmp_msg_new->bindParam(':lat',$lat,PDO::PARAM_STR); //ask naimesh
    $stmp_msg_new->bindParam(':lng',$long,PDO::PARAM_STR); //ask naimesh
    $stmp_msg_new->execute();

    $query_get_mid= "SELECT last_insert_id() as msgid;";
    $stmt_get_mid = $conn->query($query_get_mid);
    while ($row = $stmt_get_mid->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT)) {
      $mid = $row['msgid'];
    }

    if(isset($_FILES["img"])){
      $check = getimagesize($_FILES["img"]["tmp_name"]);
      if($check !== false) {
          $filename = "../uploads/msg_".$mid;
          $target_file = $filename . basename($_FILES["img"]["name"]);
          $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
          $filename_full = $filename.".".$imageFileType;
          $tst = move_uploaded_file($_FILES["img"]["tmp_name"], $filename_full);
          $relpath="uploads/msg_".$mid.".".$imageFileType;
      }
    }

    if($tst){
      $query_updt_msg = "UPDATE `NextdoorDB`.`messages` SET `image` = '$relpath' WHERE `mid` = $mid;";
      if(!$conn->query($query_updt_msg)){
        echo "Error:8";
        die();
      }

    }
    echo "Success";
    die();

}


if(isset($_POST['msgreply'])){
  $uid=$_SESSION['uid'];
  $m_body=$_POST['m_body'];
  $tid=$_POST['tid'];
  $insert_msg_new = "INSERT INTO `NextdoorDB`.`messages`(`mid`,`author`,`m_body`,`tid`,`postedat`) VALUES (NULL,:user,:msg_body,:tid,CURRENT_TIMESTAMP);";
  $stmp_msg_new= $conn->prepare($insert_msg_new);
  $stmp_msg_new->bindParam(':user',$uid,PDO::PARAM_INT,6);
  $stmp_msg_new->bindParam(':msg_body',$m_body,PDO::PARAM_STR);
  $stmp_msg_new->bindParam(':tid',$tid,PDO::PARAM_INT,10);
  $stmp_msg_new->execute();
}
?>
