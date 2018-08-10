<?php

include_once "config.php";

//非查询语句  返回bool
function none_query($sql){
  $conn = mysqli_connect(IP,USER,PWD,Table_Name);
  $isTrue = mysqli_query($conn,$sql);
  mysqli_close($conn);
  return $isTrue;
}

//查询语句  返回二维数组
function query($sql){
  $conn = mysqli_connect(IP,USER,PWD,Table_Name);
  $result = mysqli_query($conn,$sql);
  $arr = array();
  while($line = mysqli_fetch_assoc($result))
  {
    $arr[] = $line;
  }
  //关闭结果集  与  关闭数据库链接
  mysqli_free_result($result);
  mysqli_close($conn);
  return $arr;
}

//查询语句  返回线性数组  
function xx_query($sql){
  $conn = mysqli_connect(IP,USER,PWD,Table_Name);
  $result = mysqli_query($conn,$sql);
  $arr = array();
  while($line = mysqli_fetch_row($result))
  {
    $arr[] = $line;
  }
  //关闭结果集  与  关闭数据库链接
  mysqli_free_result($result);
  mysqli_close($conn);
  return $arr[0];
}

function check_login(){
  session_start();
  if(empty($_SESSION["current_user_login_id"]))
  {
    header("location:./login.php");
    return;
  }
  //查询数据
  $current_user_id = $_SESSION["current_user_login_id"];
  $list = query("select * from users where id={$current_user_id}")[0];
  // var_dump($list);
  // exit;
  return $list;
}