<?php

include_once "fn.php";

function process(){
 
  if(empty($_POST["email"]) || empty($_POST["password"]))
  {
    $GLOBALS["err_msg"] = "请输入完整信息";
    return;
  }
  //获取参数
  $email = $_POST["email"];
  $password = $_POST["password"];
  //判断是否存在用户
  $sql = "select * from users where email='$email'";
  $list = query($sql);
  if( count($list) == 0 )
  {
    $GLOBALS["err_msg"] = "用户或密码错误(用户名不存在)";//不存在邮箱
    return;
  }
  if($list[0]["password"] != $password)
  {
    $GLOBALS["err_msg"] = "用户或密码错误(用户名存在但密码不正确)";//不存在邮箱
    return;
  }

  //登录成功
  //开启 session ,保存数据，跳转到 主页 (index.php)
  session_start();
  //一般在实际开发时，往session中存储的数据就是 当前用户的 id

  $_SESSION["current_user_login_id"] = $list[0]["id"];

  //跳转
  header("location:./index.php");
  exit;

}

if($_SERVER["REQUEST_METHOD"] == "POST")
{
  process();
}
if($_SERVER["REQUEST_METHOD"] == "GET")
{
  // processGet();
}
function processGet(){
  //start  进来判断是否登录过
  session_start();
  if(empty($_SESSION["current_user_login_id"]))
  {
    $cc = $_SESSION["current_user_login_id"];
    $list1 = query("select * from users where id='$cc'");
    if(count($list1) != 0)
    {
      header("location:./index.php");
    }
  }

  //end
}
?>

<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <title>Sign in &laquo; Admin</title>
  <link rel="stylesheet" href="../assets/vendors/bootstrap/css/bootstrap.css">
  <link rel="stylesheet" href="../assets/css/admin.css">
</head>
<body>
  <div class="login">
    <form id="form" class="login-wrap" method="post">
      <img class="avatar" src="../assets/img/default.png">
      <?php if(isset($err_msg)): ?>
        <div class="alert alert-danger">
          <strong>错误！</strong> <?php echo $err_msg; ?>
        </div>
      <?php endif ?>
      <!-- 有错误信息时展示 -->
      <!-- <div class="alert alert-danger">
        <strong>错误！</strong> 用户名或密码错误！
      </div> -->


      <div id="jqalert" class="alert alert-danger" style='display: none'>
          <strong>错误！</strong> 请填写完整信息
        </div>

      <div class="form-group">
        <label for="email" class="sr-only">邮箱</label>
        <input 
        id="email" 
        type="email" 
        class="form-control" 
        placeholder="邮箱" 
        name="email"
        autofocus>
      </div>
      <div class="form-group">
        <label for="password" class="sr-only">密码</label>
        <input 
        id="password" 
        type="text" 
        class="form-control" 
        name="password"
        placeholder="密码">
      </div>
      <!-- <a class="btn btn-primary btn-block" href="index.html">登 录</a> -->
      <input class="btn btn-primary btn-block" type="submit" value="登录">
    </form>
  </div>
  <script src='../assets/vendors/jquery/jquery.js'></script>
  <script>
  
  //表单提交
  $('#form').on('submit',function(){

    var formdata = $(this).serialize();
    console.log(formdata);

    //将字符串分割成数组，到一个对象中 再来进行判断
    var params = {};
    var temp_arr = formdata.split('&');
    for(var i=0;i<temp_arr.length;i++)
    {
      var temp = temp_arr[i].split('=');
      params[temp[0]] = temp[1];
    }
    console.log(params); //查看对象中的值

    for(var k in params)
    {
      if(params[k].length == 0)
      {
        $('#jqalert').fadeIn(200);
        setTimeout(function(){
          $('#jqalert').fadeOut(200);
        },2000)
        return false;
      }
    }

    // return false; //阻止默认行为 和 冒泡
  })
  
  </script>
</body>
</html>
