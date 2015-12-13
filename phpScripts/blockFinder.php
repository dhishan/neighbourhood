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


if(!(isset($_POST['hoodid']))){
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
}else{
  //find block in the selected neighbourhood
  $hoodid = $_POST['hoodid'];
  $hoodid = 100;
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
}
?>
