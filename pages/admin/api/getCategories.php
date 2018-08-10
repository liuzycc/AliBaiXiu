<?php
include_once "fn.php";
//获取分类数据
$sql = "select * from categories";
$list = query($sql);
echo json_encode(array(
  "success"=>count($list)>0,
  "result"=>$list
))


?>