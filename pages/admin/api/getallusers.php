<?php
include_once "fn.php";
//获取当前所有用户
$sql = "select * from users";
$list = query($sql);

// header("Content-type:application/json;charset=utf-8");

echo json_encode(array(
  "success"=>true,
  "result"=>$list
))

?>