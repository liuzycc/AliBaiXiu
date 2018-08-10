<?php
include_once "fn.php";
//更新一条分类信息

$id = $_POST["id"];
$name = $_POST["name"];
$slug = $_POST["slug"];
$sql = "update categories set name='$name',slug='$slug' where id=$id";
$bool = none_query($sql);
echo json_encode(array(
  "success"=>$bool
))

?>