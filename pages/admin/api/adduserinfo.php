<?php
include_once "fn.php";
//要先验证参数
$slug = $_POST["slug"];
$email = $_POST["email"];
$nickname = $_POST["nickname"];
$password = $_POST["password"];
$sql = "insert into users (slug,email,nickname,password,status)values('$slug','$email','$nickname','$password','activated')";
$bool = none_query($sql);
echo json_encode(array(
  "success"=>$bool
))


?>