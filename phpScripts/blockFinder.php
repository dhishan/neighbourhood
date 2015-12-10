<?php
require_once 'pdofile.php';
require_once 'point-in-polygon.php';

$latitude = $_POST['lat'];
$longitude = $_POST['long'];
// $latitude = "40.754610";
// $longitude = "-73.990017";

$point ="$longitude $latitude";
//Remember that x is longitude (East/West), and y is latitude (North/South)

$pointLocation = new pointLocation();


if(!(isset($_POST['hood']))){
  $nquery = "SELECT * FROM neighbourhood;";
  $res = $conn->query($nquery);
  $hoods = array();
  while ($row = $res->fetch(PDO::FETCH_NUM, PDO::FETCH_ORI_NEXT)) {

    $nid = $row[0];
    $name = $row[1];
    $ne_lat = $row[2];
    $ne_long = $row[3];
    $sw_long = $row[4];
    $sw_lat = $row[5];
    $nw_lat = $row[6];
    $nw_long = $row[7];
    $se_lat = $row[8];
    $se_long = $row[9];

    $polygon = array("$ne_long $ne_lat","$se_long $se_lat","$sw_long $sw_lat","$nw_long $nw_lat","$ne_long $ne_lat");
    $lies = $pointLocation->pointInPolygon($point, $polygon);
    if($lies == "inside" or $lies == "boundary" or $lies == "vertex"){
      $hoods[] = array("nid"=>"$nid","name"=>"$name","lies"=>"$lies");
    }
  }
  echo (json_encode($hoods));
}else{
  //find block in the selected neighbourhood
  $hoodid = $_POST['hoodid'];
  $bquery = "SELECT * FROM `blocks` where nid = ".$hoodid;
  $bres = $conn->query($bquery);
  $blocks = array();
  $blockres = $bres->fetchAll(PDO::FETCH_BOTH);
  foreach($blockres as $row){
    $nid = $row['bid'];
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
      $blocks[] = array("nid"=>"$nid","name"=>"$name","lies"=>"$lies");
    }
    }
    echo json_encode($blocks);
}
?>
