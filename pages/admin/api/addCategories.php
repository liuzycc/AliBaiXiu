<?php
include_once "fn.php";
//添加信息
$name = $_POST["name"];
$slug = $_POST["slug"];
$sql = "insert into categories (name,slug)values('$name','$slug')";
$bool = none_query($sql);
echo json_encode(array(
  "success"=>$bool
))

?>