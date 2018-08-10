<?php

include_once "fn.php";
$sql = "SELECT * FROM `options` where `key`='nav_menus'";
$list = query($sql);
echo json_encode(array(
  "success"=>true,
  "result"=>$list
))


?>