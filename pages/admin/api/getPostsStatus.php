<?php

include_once "fn.php";
$sql = "select status from posts  GROUP BY status";
$list = query($sql);
echo json_encode(array(
  "success"=>count($list)>0,
  "result"=>$list
))

?>