<?php
include_once "fn.php";
$list = check_login();
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <title>Categories &laquo; Admin</title>
  <link rel="stylesheet" href="../assets/vendors/bootstrap/css/bootstrap.css">
  <link rel="stylesheet" href="../assets/vendors/font-awesome/css/font-awesome.css">
  <link rel="stylesheet" href="../assets/vendors/nprogress/nprogress.css">
  <link rel="stylesheet" href="../assets/css/admin.css">
  <link rel="stylesheet" href="../assets/layui/css/layui.css">
  
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
        <h1>分类目录</h1>
      </div>
      <!-- 有错误信息时展示 -->
      <div id="msg" class="alert" style="display:none">
        <strong>错误！</strong><span></span>
      </div>
      <div class="row">
        <div class="col-md-4">
          <form id="addorupdate">
              <!-- 使用模板  添加列表 和 更新列表 -->
          </form>
        </div>
        <div class="col-md-8">
          <div class="page-action">
            <!-- show when multiple checked -->
            <a id="pishan" class="btn btn-danger btn-sm" href="javascript:;" style="display: none">批量删除</a>
          </div>
          <table id='categories' class="table table-striped table-bordered table-hover">
            <thead>
              <tr>
                <th class="text-center" width="40"><input type="checkbox"></th>
                <th>名称</th>
                <th>Slug</th>
                <th class="text-center" width="100">操作</th>
              </tr>
            </thead>
            <tbody>
                <!-- 使用模板添加分类信息 -->
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>


  <!-- 引入左侧导航栏 -->
  <?php include_once "inc/left_menu.html"; ?>
  <!-- 引入左侧导航栏结束 -->

  <!-- 分类列表模板 -->
  <script type='text/template' id='categoriesTpl'>
    {{each list}}
      <tr data-id="{{$value.id}}">
        <td class="text-center"><input type="checkbox"></td>
        <td>{{$value.name}}</td>
        <td>{{$value.slug}}</td>
        <td class="text-center">
          <a href="javascript:;" class="btn btn-info btn-xs edit">编辑</a>
          <a href="javascript:;" class="btn btn-danger btn-xs remove">删除</a>
        </td>
      </tr>
      {{/each}}
  </script>
  <!-- 左侧模板 -->
  <script type="text/template" id="addorupdateTpl">
      <h2>{{id?'更新分类目录':'添加新分类目录'}}</h2>
      <div style="display:none;">
        <p id="msgp">{{id?'更新成功':'添加成功'}}</p>
        <input id="urcc" type="text" value="{{id?'api/updateCategories.php' : 'api/addCategories.php'}}">
      </div>
      {{if id}}
      <input type="hidden" name='id' value="{{id}}">
      {{/if}}
      <div class="form-group">
        <label for="name">名称</label>
        <input id="name" class="form-control" name="name" type="text" placeholder="分类名称" value="{{name}}">
      </div>
      <div class="form-group">
        <label for="slug">别名</label>
        <input id="slug" class="form-control" name="slug" type="text" placeholder="slug" value="{{slug}}">
        <p class="help-block">https://zce.me/category/<strong>{{slug || 'slug'}}</strong></p>
      </div>
      <div class="form-group">
        <button id="addAndupdate" class="btn btn-primary" type="submit">{{id?'更新':'添加'}}</button>
        {{if id}}
        <input id="cancelEdit" class="btn btn-warning" type="button" value="取消更新">
        {{/if}}
      </div>
  </script>

  <script src="../assets/vendors/jquery/jquery.js"></script>
  <script src="../assets/vendors/bootstrap/js/bootstrap.js"></script>
  <script src='../assets/vendors/art-template/template-web.js'></script>
  <script src='../assets/js/common.js?v=cc'></script>
  <script src='../assets/vendors/layui/layui.all.js'></script>
  <script>NProgress.done()</script>

  <script>
    //加载分类数据
    function load_categories(){
      $.get('api/getCategories.php',function(res){
        res = JSON.parse(res);
        if(res.success)
        {
          $('#categories tbody').html(template('categoriesTpl',{list:res.result}));
        }
      })
    }
    $(function(){
      //加载数据
      load_categories();
      //添加列表
      $('#addorupdate').html(template('addorupdateTpl',{}));
    })
    

    //单挑删除
    $(function(){
      $('#categories').on('click','.remove',function(){
        var id = $(this).closest('tr').attr('data-id');
        //使用layui
        var cc = layui.layer;
        cc.open({
          title:'警告',
          icon:0,
          content:'确定要删除吗？',
          btn:['确定','取消'],
          yes:function(index){
            //开始删除
            $.get('api/delCategories.php',{id:id},function(res){
              res = JSON.parse(res);
              if(res.success)
              {
                cc.close(index);//关闭窗口
                cc.msg('数据删除成功');
                load_categories();
              }
            })
          }
        });
        return false;
      })
    })
    
    //编辑
    $(function(){
      //键入事件
      $('#addorupdate').on('input','#slug',function(){
        $(this).next().find('strong').text(this.value || 'slug');
      })
      // 切换编辑
      $('#categories').on('click','.edit',function(){
        var id = $(this).closest('tr').attr('data-id');
        //获取数据
        $.get('api/getCategoriesInfo.php',{id:id},function(res){
          res = JSON.parse(res);
          if(res.success)
          {
            $('#addorupdate').html(template('addorupdateTpl',res.result[0]));
          }
        })
      })
      //取消编辑
      $('#addorupdate').on('click','#cancelEdit',function(){
        $('#addorupdate').html(template('addorupdateTpl',{}));
      })
    })

    //添加与更新
    $(function(){
      $('#addorupdate').on('submit',function(){
        //获取参数
        var params = $(this).serialize();
        //转换成对象 kv
        if(!I.checkUrlSearch(params))
        {
          alertMsg("#msg",'请输入完整!');
          return false;
        }
        var obj = I.paramToObj(params);
        //开始添加或更新操作
        var url = $("#urcc").val();
        var msg = $("#msgp").text();
        $.post(url,obj,function(res){
          res = JSON.parse(res);
          if(res.success)
          {
            I.alertMsg("#msg",msg);
            $('#addorupdate').html(template('addorupdateTpl',{}));
            load_categories();//重新加载数据
          }
        })
        return false;
      })
    })

    //批量删除
    $(function(){
      var remove_ids = [];
      $('#categories thead :checkbox').on('change',function(){
        $('#categories tbody :checkbox').prop('checked',this.checked).trigger('change');
      })
      $('#categories tbody').on('change',':checkbox',function(){

        //获取当前数据的id
        var index = $(this).closest('tr').attr('data-id');
        if($(this).prop('checked'))
        {
          //从数组中添加
          if(remove_ids.indexOf(index) == -1)
          {
            remove_ids.push(index);
          }
        }
        else {
          //从数组中删除
          if(remove_ids.indexOf(index) != -1)
          {
            remove_ids.splice(remove_ids.indexOf(index),1);
          }
        }
        
        //判断是否取消全选按钮的选中状态
        if(remove_ids.length == $('#categories tbody :checkbox').length)
        {
          $('#categories thead :checkbox').prop('checked',true);
        }
        else{
          $('#categories thead :checkbox').prop('checked',false);
        }
        //是否显示批删按钮
        if(remove_ids.length>0)
        {
          $('#pishan').fadeIn(200);
        }
        else{
          $('#pishan').fadeOut(500);
        }
        console.log(remove_ids);
      })

      //开始批量删除ajax
      $('#pishan').on('click',function(){
        var that = this;
        layui.layer.open({
          title:'警告',
          icon:0,
          content:'确定要批量删除吗',
          btn:['确定','取消'],
          yes:function(index){
            $.get('api/delCategories.php',{id:remove_ids.join()},function(res){
              res = JSON.parse(res);
              if(res.success)
              {
                $(that).fadeOut(500);
                load_categories();
                layui.layer.close(index);
              }
            })
          }
        });
      })
    })

  </script>
</body>
</html>
