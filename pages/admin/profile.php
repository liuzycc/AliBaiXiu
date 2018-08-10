<?php
include_once "fn.php";
$list = check_login();
// var_dump($user_info);
// exit;

?>

<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <title>Dashboard &laquo; Admin</title>
  <link rel="stylesheet" href="../assets/vendors/bootstrap/css/bootstrap.css">
  <link rel="stylesheet" href="../assets/vendors/font-awesome/css/font-awesome.css">
  <link rel="stylesheet" href="../assets/vendors/nprogress/nprogress.css">
  <link rel="stylesheet" href="../assets/css/admin.css">
  <script src="../assets/vendors/nprogress/nprogress.js"></script>
</head>
<body>
  <script>NProgress.start()</script>

  <div class="main">
    <!-- 公共部分 -->
    <?php include_once "inc/navigator.html"; ?>
    <!-- 公共部分end -->
    <div class="container-fluid">
      <div class="page-title">
        <h1>我的个人资料</h1>
      </div>
      <!-- 有错误信息时展示 -->
      <!-- <div class="alert alert-danger">
        <strong>错误！</strong>发生XXX错误
      </div> -->
      <form id="profile_form" class="form-horizontal">
        <div class="form-group">
          <label class="col-sm-3 control-label">头像</label>
          <div class="col-sm-6">
            <label class="form-image">
              <input id="avatar" type="file">
              <img id='img_avatar' src="../assets/img/default.png" class="avatar">
              <i class="mask fa fa-upload"></i>
            </label>
          </div>
        </div>
        <div class="form-group">
          <label for="email" class="col-sm-3 control-label">邮箱</label>
          <div class="col-sm-6">
            <input id="email" class="form-control" name="email" type="type" value="w@zce.me" placeholder="邮箱" readonly>
            <p class="help-block">登录邮箱不允许修改</p>
          </div>
        </div>
        <div class="form-group">
          <label for="slug" class="col-sm-3 control-label">别名</label>
          <div class="col-sm-6">
            <input id="slug" class="form-control" name="slug" type="type" value="zce" placeholder="slug">
            <p class="help-block">https://zce.me/author/<strong>zce</strong></p>
          </div>
        </div>
        <div class="form-group">
          <label for="nickname" class="col-sm-3 control-label">昵称</label>
          <div class="col-sm-6">
            <input id="nickname" class="form-control" name="nickname" type="type" value="汪磊" placeholder="昵称">
            <p class="help-block">限制在 2-16 个字符</p>
          </div>
        </div>
        <div class="form-group">
          <label for="bio" class="col-sm-3 control-label">简介</label>
          <div class="col-sm-6">
            <textarea id="bio" class="form-control" placeholder="Bio" cols="30" rows="6">MAKE IT BETTER!</textarea>
          </div>
        </div>
        <div class="form-group">
          <div class="col-sm-offset-3 col-sm-6">
            <button type="submit" class="btn btn-primary" id="updateBtn">更新</button>
            <a class="btn btn-link" href="password-reset.html">修改密码</a>
          </div>
        </div>
      </form>
    </div>
  </div>

  <!-- 引入左侧导航栏 -->
  <?php include_once "inc/left_menu.html"; ?>
  <!-- 引入左侧导航栏结束 -->

  <script src="../assets/vendors/jquery/jquery.js"></script>
  <script src="../assets/vendors/bootstrap/js/bootstrap.js"></script>
  <script>NProgress.done()</script>
  <script src='../assets/js/common.js'></script>
  <script src='../assets/vendors/art-template/template-web.js'></script>

  <!-- 个人中心的模板 -->
  <script type="text/template" id="profile_tpl">
      <div class="form-group">
        <label class="col-sm-3 control-label">头像</label>
        <div class="col-sm-6">
          <label class="form-image">
            <input id="avatar" type="file">
            <img id='img_avatar' src="{{avatar}}" class="avatar">
            <input type="hidden" name="avatar" value="{{avatar}}">
            <i class="mask fa fa-upload"></i>
          </label>
        </div>
      </div>
      <div class="form-group">
        <label for="email" class="col-sm-3 control-label">邮箱</label>
        <div class="col-sm-6">
          <input id="email" class="form-control" name="email" type="type" value="{{email}}" placeholder="邮箱" readonly>
          <p class="help-block">登录邮箱不允许修改</p>
        </div>
      </div>
      <div class="form-group">
        <label for="slug" class="col-sm-3 control-label">别名</label>
        <div class="col-sm-6">
          <input id="slug" class="form-control" name="slug" type="type" value="{{slug}}" placeholder="slug">
          <p class="help-block">https://zce.me/author/<strong>{{slug}}</strong></p>
        </div>
      </div>
      <div class="form-group">
        <label for="nickname" class="col-sm-3 control-label">昵称</label>
        <div class="col-sm-6">
          <input id="nickname" class="form-control" name="nickname" type="type" value="{{nickname}}" placeholder="昵称">
          <p class="help-block">限制在 2-16 个字符</p>
        </div>
      </div>
      <div class="form-group">
        <label for="bio" class="col-sm-3 control-label">简介</label>
        <div class="col-sm-6">
          <textarea id="bio" class="form-control" placeholder="Bio" cols="30" rows="6">{{bio}}</textarea>
        </div>
      </div>
      <div class="form-group">
        <div class="col-sm-offset-3 col-sm-6">
          <button type="submit" class="btn btn-primary" id="updateBtn">更新</button>
          <a class="btn btn-link" href="password-reset.php?id={{id}}">修改密码</a>
        </div>
      </div>
  </script>

  <script>
  
  $(function(){
    //获取id
    var cc = location.search;
    var params = I.paramToObj(cc);
    var id = params.id;
    // console.log(params);

    $.get('api/getuserbyid.php',{id:id},function(res){
      console.log(res);
      if(res.success)
      {
        //请求成功，渲染页面
        var data = res.result;
        // $('.avatar').attr('src',data.avatar);
        // $('#email').val(data.email);
        // $('#slug').val(data.slug).next().find('strong').text(data.slug);
        // $('#nickname').val(data.nickname);
        // $('#bio').text(data.bio);
        
        //使用模板引擎渲染
        console.log(res.result);
        $('#profile_form').html(template('profile_tpl',res.result));
      }
      else {
        //请求失败，给出警告 或者会到主页
        // location.href = 'login.php';
        alert('请求失败无数据,返回登录页login.php');
      }
    })
          //图片上传
    $('form').on('change','#avatar',function(){
      var file = this.files[0];
      var formdata = new FormData();
      formdata.append('file',file);
      console.log(file);
      //ajax上传
      $.ajax({
        type:'post',
        url:'api/updatefile.php',
        data:formdata,

        cache: false,
        contentType: false,
        processData: false,

        success:function(res){
          
          res = JSON.parse(res);
          var data = res.result;
          console.log(res);
          if(res.success)
          {
            $('#img_avatar').attr('src',data.path);
            $('input[type=hidden]').val(data.path);
            alert('保存成功');
          }
        }
      })
    })
    //提交
    $('form').on('submit',function(){
      var formdata = $(this).serialize(); //获取表单元素，字符串的形式
      // console.log(formdata);
      // return false;
      var obj = {};
        obj.id = id;
        obj.avatar = $('.avatar').attr('src');
        obj.email = $('#email').val();
        obj.slug = $('#slug').val();
        obj.nickname = $('#nickname').val();
        obj.bio = $('#bio').val();
        console.log(obj);
        //判断参数
        for(var k in obj)
        {
          if(obj[k] == '')
          {
            alert('请填写完整');
            return false;
          }
        }
        //更新
        $.ajax({
          type:'post',
          url:'api/updateuserinfo.php',
          data:obj,
          success:function(res){
            console.log(res);
            alert('修改成功');
          }
        })
        return false;
    })



    //键入改变标签内容
    $('form').on('input','#slug',function(){
      $(this).next().find('strong').text($(this).val() || $(this).attr('name'));
    })

  })
  
  </script>
</body>
</html>
