<?php
include_once "fn.php";
$id = $_GET['id'];
$sql = "delete from categories where id in ($id)";
$bool = none_query($sql);
echo json_encode(array(
  "success"=>$bool
))

?>