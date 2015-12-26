<?php
require_once 'pdofile.php';
require_once 'point-in-polygon.php';

$latitude = $_POST['lat'];
$longitude = $_POST['long'];
// $latitude = "40.766951";
// $longitude = "-73.993143";

$point ="$longitude $latitude";
//Remember that x is longitude (East/West), and y is latitude (North/South)

$pointLocation = new pointLocation();


if((isset($_POST['nhoodid']))){
  $nquery = "SELECT * FROM neighbourhood;";
  $res = $conn->query($nquery);
  $hoods = array();
  while ($row = $res->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT)) {

    $nid = $row['nid'];
    $name = $row['name'];
    $ne_lat = $row['ne_latitude'];
    $ne_long = $row['ne_longitude'];
    $sw_long = $row['sw_longitude'];
    $sw_lat = $row['sw_latitude'];
    $nw_lat = $row['nw_latitude'];
    $nw_long = $row['nw_longitude'];
    $se_lat = $row['se_latitude'];
    $se_long = $row['se_longitude'];

    $polygon = array("$ne_long $ne_lat","$se_long $se_lat","$sw_long $sw_lat","$nw_long $nw_lat","$ne_long $ne_lat");
    $lies = $pointLocation->pointInPolygon($point, $polygon);
    if($lies == "inside" or $lies == "boundary" or $lies == "vertex"){
      $hoods[] = array("nid"=>"$nid","name"=>"$name","lies"=>"$lies");
    }
  }
  echo (json_encode($hoods));
  die();
}else if(isset($_POST['hoodid'])){
  //find block in the selected neighbourhood
  $hoodid = $_POST['hoodid'];
  $bquery = "SELECT * FROM `blocks` where nid = ".$hoodid;
  $bres = $conn->query($bquery);
  $blocks = array();
  // $blockres = $bres->fetchAll(PDO::FETCH_BOTH);
  while ($row = $bres->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT)) {
    $bid = $row['bid'];
    $name = $row['name'];
    $ne_lat = $row['ne_latitude'];
    $ne_long = $row['ne_longitude'];
    $sw_long = $row['sw_longitude'];
    $sw_lat = $row['sw_latitude'];
    $nw_lat = $row['nw_latitude'];
    $nw_long = $row['nw_longitude'];
    $se_lat = $row['se_latitude'];
    $se_long = $row['se_longitude'];

    $polygon = array("$ne_long $ne_lat","$se_long $se_lat","$sw_long $sw_lat","$nw_long $nw_lat","$ne_long $ne_lat");
    $lies = $pointLocation->pointInPolygon($point, $polygon);
    if($lies == "inside" or $lies == "boundary" or $lies == "vertex"){
      $blocks[] = array("bid"=>"$bid","name"=>"$name","ne_long"=>"$ne_long","ne_lat"=>"$ne_lat","se_long"=>"$se_long","se_lat"=>"$se_lat","sw_long"=>"$sw_long","sw_lat"=>"$sw_lat","nw_lat"=>"$nw_lat","nw_long"=>"$nw_long");
    }
  }

  echo (json_encode($blocks));
  die();
}else if(isset($_POST['join'])){
  if(!isset($_SESSION['uid'])){
    echo "Error:400";
    die();
  }
  $uid = $_SESSION['uid'];
  //check if the user already in a block
  $bquery_check = "SELECT `bid`,`since` FROM `membership` where uid = ".$uid;
  $bres_check = $conn->query($bquery_check);
  while ($row_check = $bres_check->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT)){
    // $bor =is_array($row_check);
    //It comes here only if the query returns something
      $bid = $row_check['bid'];
      $since = $row_check['since'];
      $m_history_insert = "INSERT INTO `nextdoordb`.`m_history`(`uid`,`bid`,`since`,`till`) VALUES (:uid,:bid,:since,CURRENT_TIMESTAMP)";

      $stmp_insert = $conn->prepare($m_history_insert);
      $stmp_insert->bindParam(':uid',$uid,PDO::PARAM_INT,6);
      $stmp_insert->bindParam(':bid',$bid,PDO::PARAM_INT,6);
      $stmp_insert->bindParam(':since',$since);
      $stmp_insert->execute();


      //unset session varaibles
      unset($_SESSION['nid']);
      unset($_SESSION['bid']);

      $delquery = "DELETE FROM `NextdoorDB`.`membership` WHERE `uid`=$uid and `bid`=$bid";
      if(!($conn->query($delquery))){
        echo "Error PHP";
      }


}

  $userupdate="UPDATE `nextdoordb`.`user` SET `streetadr1` = :streetadr1,`streetadr2` = :streetadr2,`city` = :city ,`state` = :state ,`zip` = :zip  WHERE `uid` = '".$uid."'";
  $stmp_signup_update= $conn->prepare($userupdate);
  $stmp_signup_update->bindParam(':streetadr1',$_POST['streetadr1'],PDO::PARAM_STR,40);
  $stmp_signup_update->bindParam(':streetadr2',$_POST['streetadr2'],PDO::PARAM_STR,40);
  $stmp_signup_update->bindParam(':city',$_POST['city'],PDO::PARAM_STR,30);
  $stmp_signup_update->bindParam(':state',$_POST['state'],PDO::PARAM_STR,20);
  $stmp_signup_update->bindParam(':zip',$_POST['zip'],PDO::PARAM_INT,5);
  $stmp_signup_update->execute();


  //find the number of members in the membership for that block
  //if 3 or more set the number of required requests to 3
  //if less than 3 set the number of required to the number of members in the group
  $_SESSION['bid']=$_POST['bid'];
  $bid = $_POST['bid'];
  $sqlf = "SELECT COUNT(*) as val FROM `NextdoorDB`.`membership` WHERE `membership`.`bid` = $bid";
  $member_check = $conn->query($sqlf);
  while ($rows = $member_check->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT)){
    $number = intval($rows['val']);

    if($number >= 3){
      $sqli = "INSERT INTO `NextdoorDB`.`m_request` (`uid`, `bid`, `acceptance_cnt`) VALUES ($uid,$bid,3)";
      if(!$conn->query($sqli)){
        echo "Error:5";
          die();
      }
      echo "Success";
    }else if($number == 0){
      $inst = "INSERT INTO `NextdoorDB`.`membership` (`uid`, `bid`, `since`) VALUES ($uid,$bid,CURRENT_TIMESTAMP);";
      if(!$conn->query($inst)){
        echo "Error:5";
          die();
      }
      echo "Success";
    }else {
      $sqli1 = "INSERT INTO `NextdoorDB`.`m_request` (`uid`, `bid`, `acceptance_cnt`) VALUES ($uid,$bid,$number)";
      if(!$conn->query($sqli1)){
        echo "Error:5";
          die();
      }
      echo "Success";
    }

  }

  die();

}

?>
