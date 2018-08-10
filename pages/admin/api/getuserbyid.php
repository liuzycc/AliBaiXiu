<?php

include_once "fn.php";

//实际项目中要先校验参数

//传入id 返回json格式的用户信息

$user_id = $_GET["id"];
$sql = "select * from users where id='$user_id'";
$user_info = query($sql);

header("Content-Type:application/json;charset=utf-8");
echo json_encode(array(
  "success" => count($user_info)>0,
  "result" => count($user_info)>0?$user_info[0]:array()
));

?>