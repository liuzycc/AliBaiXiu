<?php
include_once "fn.php";
$list = check_login();
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <title>Users &laquo; Admin</title>
  <link rel="stylesheet" href="../assets/vendors/bootstrap/css/bootstrap.css">
  <link rel="stylesheet" href="../assets/vendors/font-awesome/css/font-awesome.css">
  <link rel="stylesheet" href="../assets/vendors/nprogress/nprogress.css">
  <link rel="stylesheet" href="../assets/css/admin.css">
  <script src="../assets/vendors/nprogress/nprogress.js"></script>
</head>
<body>
  <script>NProgress.start()</script>

  <div class="main">
    <!-- 公共部分顶部导航条 -->
    <?php include_once "inc/navigator.html" ?>
    <!-- 公共部分end -->
    <div class="container-fluid">
      <div class="page-title">
        <h1>用户</h1>
      </div>
      <!-- 有错误信息时展示 -->
      <div id="msg" class="alert alert-info" style="display:none">
        <strong>提示</strong><span></span>
      </div>
      <div class="row">
        <div class="col-md-4">
          <form id="userForm">
          <!-- 使用模板 -->
          </form>
        </div>
        <div class="col-md-8">
          <div class="page-action">
            <!-- show when multiple checked -->
            <a id="remove_btn" class="btn btn-danger btn-sm" href="javascript:;" style="display: none">批量删除</a>
          </div>
          <table id='user_list_table' class="table table-striped table-bordered table-hover">
            <thead>
               <tr>
                <th class="text-center" width="40"><input type="checkbox"></th>
                <th class="text-center" width="80">头像</th>
                <th>邮箱</th>
                <th>别名</th>
                <th>昵称</th>
                <th>状态</th>
                <th class="text-center" width="100">操作</th>
              </tr>
            </thead>
            <tbody>

            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <!-- 引入左侧导航栏 -->
  <?php include_once "inc/left_menu.html"; ?>
  <!-- 引入左侧导航栏结束 -->

  <script src="../assets/vendors/jquery/jquery.js"></script>
  <script src="../assets/vendors/bootstrap/js/bootstrap.js"></script>
  <script src="../assets/vendors/art-template/template-web.js"></script>
  <script src='../assets/js/common.js'></script>
  <!-- 模板 -->
  <script type='text/template' id='usersTpl'>
  {{ each list }}
    <tr data-id='{{$value.id}}'>
      <td class="text-center"><input type="checkbox"></td>
      <td class="text-center"><img class="avatar" src="{{$value.avatar|| '../assets/img/default.png'}}"></td>
      <td>{{$value.email}}</td>
      <td>{{$value.slug}}</td>
      <td>{{$value.nickname}}</td>
      <td>{{$value.status}}</td>
      <td class="text-center">
        <a href="javascript:;" class="btn btn-default btn-xs edit">编辑</a>
        <a href="javascript:;" class="btn btn-danger btn-xs remove">删除</a>
      </td>
    </tr>
    {{ /each }}
  </script>
  <!-- 添加修改模板 -->
  <script type="text/template" id="addorupdate">
    <h2>{{ id? '更新旧用户':'添加新用户' }}</h2>
    <!-- 定义ajax的路径 -->
    <div class="config" 
           style="display: none;" 
           data-url="{{ id ? './api/updateuserinfo.php' : './api/adduserinfo.php' }}" 
           data-success-text="{{ id ? '修改成功' : '新增成功' }}"
           data-fail-text="{{id? '修改失败' : '新增失败'}}"></div>
      <!-- 添加id -->
      {{ if id }}
      <input type="hidden" name="id" value="{{ id }}">
      {{ /if }}
    <div class="form-group">
      <label for="email">邮箱</label>
      <input id="email" class="form-control" name="email" type="email" placeholder="邮箱" value="{{email}}">
    </div>
    <div class="form-group">
      <label for="slug">别名</label>
      <input id="slug" class="form-control" name="slug" type="text" placeholder="slug" value="{{slug}}">
      <p class="help-block">https://zce.me/author/<strong>{{slug || 'slug'}}</strong></p>
    </div>
    <div class="form-group">
      <label for="nickname">昵称</label>
      <input id="nickname" class="form-control" name="nickname" type="text" placeholder="昵称" value="{{nickname}}">
    </div>
    <div class="form-group">
      <label for="password">密码</label>
      <input id="password" class="form-control" name="password" type="text" placeholder="密码" value="{{password}}">
    </div>
    <div class="form-group">
      <button class="btn btn-primary" type="submit">{{id?"更新":"添加"}}</button>
      {{if id}}
      <input id="cancelEdit" class="btn btn-warning"  type="button" value="取消编辑">
      {{/if}}
    </div>
  </script>
  <script>NProgress.done()</script>

  <script>
    //页面加载时，绑定数据
    function load_data(){
      $.get('api/getallusers.php',function(res){
      res = JSON.parse(res);
      if(res.success)
      {
        $('#user_list_table tbody').html(template('usersTpl',{
          list:res.result
        }))
      }
    })
    }

  $(function(){
    //页面加载时，绑定数据
    load_data();
    // 使用一个空的对象渲染模板
    $( '#userForm' ).html( template( 'addorupdate', {} ) );
  })

  //绑定删除事件
  $(function(){
    $('#user_list_table').on('click','.remove',function(){
      //获取tr中的id
      var user_id = $(this).closest('tr').attr('data-id');
      console.log(user_id);
      if(!confirm('确定要删除吗？'))
      {
        return;
      }
      //删除操作
      $.get('api/removedatabyid.php',{id:user_id},function(res){
        res = JSON.parse(res);
        if(res.success)
        {
          // 给出提示
          $( '#msg' ).fadeIn( 200 ).find( 'span' ).text( '删除成功' );
            setTimeout( function () {
              $( '#msg' ).fadeOut( 500 );
            }, 2000);

          load_data();
        }
      })
    })
  })
  
  //批量删除
  $(function(){
    //绑定单选框事件
    var remove_ids = [];
    $('#user_list_table thead').on('change',':checkbox',function(){
      //全选按钮
      var bool = $(this).prop('checked');
      //设置并获取所有的checkbox
      var obj = $('#user_list_table tbody :checkbox').prop('checked',bool);
      //添加到数组中
      // console.log(obj);
      // console.log(bool);
      remove_ids.length = 0;
      if(bool)
      {
        for(var i=0;i<obj.length;i++)
        {
        remove_ids.push(obj.eq(i).closest('tr').attr('data-id'));
        }
      }
      if(remove_ids.length > 0)
      {
        $('#remove_btn').css('display','block');
      }
      else {
        $('#remove_btn').css('display','none');
      }
      console.log(remove_ids);
    })

    $('#user_list_table tbody').on('change',':checkbox',function(){
      
      //下面的单选按钮
      var xuanzhong = $('#user_list_table tbody :checkbox:checked');
      var all = $('#user_list_table tbody :checkbox');
      if(xuanzhong.length == all.length)
      {
        $('#user_list_table thead :checkbox').prop('checked',true);
      }
      else{
        $('#user_list_table thead :checkbox').prop('checked',false);
      }
      //开始添加到数组中
      var currentId = $(this).closest('tr').attr('data-id');
      if($(this).prop('checked'))
      {
        //添加添加这个
        if(remove_ids.indexOf(currentId) == -1)
        {
          remove_ids.push(currentId);
        }
      }
      else{
        //删除这个
        if(remove_ids.indexOf(currentId) != -1)
        {
          remove_ids.splice(remove_ids.indexOf(currentId),1);
        }
      }
      if(remove_ids.length > 0)
      {
        $('#remove_btn').css('display','block');
      }
      else {
        $('#remove_btn').css('display','none');
      }
      console.log(remove_ids);
    })

    //ajax开始删除
    $('#remove_btn').on('click',function(){
      $.ajax({
        type:'get',
        url:'api/removedatabyid.php',
        data:{id:remove_ids.join()},
        success:function(res){
          res = JSON.parse(res);
          if(res.success)
          {
            $('#msg').fadeIn(200).find('span').text('批量删除成功');
            setTimeout(function(){
              $('#msg').fadeOut(500);
            },2000)
            // alert('批量删除成功');
            load_data();
          }
        }
      })
    })

  })

  //添加新用户或更新用户
  $(function(){
    $('#userForm').on('submit',function(){
      var params = $(this).serialize();
      if(!I.checkUrlSearch(params))
      {
        $('#msg').fadeIn(200).find('span').text('请填写完整');
        setTimeout(function(){
          $('#msg').fadeOut(500);
        },2000);
        return false;
      }
      var list = I.paramToObj(params);


      var url = $('.config').attr('data-url');
      var successMsg = $('.config').attr('data-success-text');
      var failMsg = $('.config').attr('data-fail-text');
      //开始添加新用户
      $.ajax({
        type:'post',
        url:url,
        data:list,
        success:function(res){
          res = JSON.parse(res);
          if(res.success)
          {
            $('#msg').fadeIn(200).find('span').text(successMsg);
            setTimeout(function(){
              $('#msg').fadeOut(500);
            },2000);
            //reset()
            $( '#userForm' ).html( template( 'addorupdate', {} ) );
            load_data();
          }
          else{
            $('#msg').fadeIn(200).find('span').text(failMsg);
            setTimeout(function(){
              $('#msg').fadeOut(500);
            },2000);
          }
        }
      })
      return false;
    })
  })

  //点击编辑
  $(function(){
    $('#user_list_table').on('click','.edit',function(){
      var id = $(this).closest('tr').attr('data-id');
      $.ajax({
        type:'get',
        url:'api/getuserbyid.php',
        data:{id : id},
        success:function(res){
          if(res.success){
            $( '#userForm' ).html( template( 'addorupdate', res.result ) );
          }
        }
      })
      return false;
    })
  })

  //取消编辑
  $(function(){
    $('#userForm').on('click','#cancelEdit',function(){
      $( '#userForm' ).html( template( 'addorupdate', {} ) );
    })
  })

  //slug事件
  $(function(){
    $('#userForm').on('input','#slug',function(){
      $(this).next().find('strong').text(this.value || 'slug');
    })
  })
  </script>
</body>
</html>
