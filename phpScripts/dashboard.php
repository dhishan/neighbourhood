<?php
require_once 'pdofile.php';

if(!(isset($_SESSION['uid']))){
 	$nquery= "SELECT `uid` FROM `user_login` WHERE `uname`= '".$_SESSION['uname']."'";
	$stmt=$conn->query($nquery);
  	while ($row = $stmt->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT)) {
  		$_SESSION['uid'] = $row['uid'];
  }
}

if(isset($_POST['neighbourpost'])){//TODO:remove !

  $uid=$_SESSION['uid'];

  $nidq1 = "SELECT `bid` FROM `membership` where `uid` ='".$uid."';";
  $stmt=$conn->query($nidq1);
  	while ($row = $stmt->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT)) {
  		$bid = $row['bid'];
    }

  $nidq2 = "SELECT `nid` from `blocks` where `bid`='".$bid."';";
  $stmt1=$conn->query($nidq2);
  	while ($row1 = $stmt1->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT)) {
  		$nid = $row1['nid'];
	}
  $posts = array(); //array to contain json objects

  $nidq3="SELECT * from `NextdoorDB`.`messages` JOIN `NextdoorDB`.`threads` on `messages`.`tid`=`threads`.`tid` where `threads`.`scope`='neighbourhood' and `threads`.`scope_id`='".$nid."'";
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
      $posts[] = array("tid"=>"$m_tid","mid"=>"$m_mid","m_body"=>"$m_body","image"=>"$m_image","latitude"=>"$m_latitude","longitude"=>"$m_longitude","readflag"=>"$m_readflag","fullname"=>"$m_fullname","subject"=>"$m_subject");

     }
  echo (json_encode($posts));


  die();

}
?>
