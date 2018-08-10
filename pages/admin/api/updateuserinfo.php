<?php
include_once "fn.php";
//首先应该先判断参数是否合法

//获取参数
$id = $_POST["id"];
if(!empty($_POST["avater"]))
{
  $avatar = $_POST["avatar"];
}
$email = $_POST["email"];
$slug = $_POST["slug"];
$nickname = $_POST["nickname"];
if(!empty($_POST["bio"]))
{
  $avatar = $_POST["bio"];
}
if(!empty($_POST["password"]))
{
  $password = $_POST["password"];
}
if(!empty($_POST["avater"]))
{
  $sql = "update users set avatar='$avatar',slug='$slug',nickname='$nickname',bio='$bio' where id=$id";
}
else {
  $sql = "update users set email='$email',slug='$slug',nickname='$nickname',password='$password' where id=$id";
}
$bool = none_query($sql);

echo json_encode(array(
  "success"=>$bool
))

?>