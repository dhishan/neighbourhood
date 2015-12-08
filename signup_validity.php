<?php
require_once 'pdofile.php';

if(isset($_POST['unamecheck'])){
  $query = "select uname_check('".$_POST['unamecheck']."') as val";
  $res = $conn->query($query);
  $result = $res->fetch(PDO::FETCH_ASSOC);
  if($result['val'] == 1){
      echo "false";
  }else echo "true";
}
if(isset($_POST['emailcheck'])){
  $query1 = "select check_email('".$_POST['emailcheck']."') as val1";
  $res1 = $conn->query($query1);
  $result1 = $res1->fetch(PDO::FETCH_ASSOC);
  if($result1['val1'] == 1){
      echo "false";
  }else echo "true";
}

?>
