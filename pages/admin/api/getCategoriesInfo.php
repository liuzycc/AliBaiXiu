<?php
include_once "fn.php";
$id = $_GET["id"];
$list = query("select * from categories where id=$id");
echo json_encode(array(
  "success"=>count($list)>0,
  "result"=>$list
))


?>