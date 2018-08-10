<?php
include_once "fn.php";
$list = check_login();
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <title>Posts &laquo; Admin</title>
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
        <h1>所有文章</h1>
        <a href="post-add.php" class="btn btn-primary btn-xs">写文章</a>
      </div>
      <!-- 有错误信息时展示 -->
      <!-- <div class="alert alert-danger">
        <strong>错误！</strong>发生XXX错误
      </div> -->
      <div class="page-action">
        <!-- show when multiple checked -->
        <a class="btn btn-danger btn-sm" href="javascript:;" style="display: none">批量删除</a>
        <form id="screen" class="form-inline">
          <select id="categorie" name="categorie" class="form-control input-sm">
            <!-- 动态添加的 -->
            <!-- 再来使用一波模板引擎 -->
          </select>
          <select id="status" name="status" class="form-control input-sm">
            <!-- 动态添加的 -->
          </select>
          <button id="shaixuan_btn" class="btn btn-default btn-sm">筛选</button>
        </form>
        <ul class="pagination pagination-sm pull-right">

          <!-- 这里使用插件 -->

          <!-- <li><a href="#">上一页</a></li>
          <li><a href="#">1</a></li>
          <li><a href="#">2</a></li>
          <li><a href="#">3</a></li>
          <li><a href="#">下一页</a></li> -->
        </ul>
      </div>
      <table id="table_list" class="table table-striped table-bordered table-hover">
        <thead>
          <tr>
            <th class="text-center" width="40"><input type="checkbox"></th>
            <th>标题</th>
            <th>作者</th>
            <th>分类</th>
            <th class="text-center">发表时间</th>
            <th class="text-center">状态</th>
            <th class="text-center" width="100">操作</th>
          </tr>
        </thead>
        <tbody>
          
        </tbody>
      </table>
    </div>
  </div>

  <!-- 引入左侧导航栏 -->
  <?php include_once "inc/left_menu.html"; ?>
  <!-- 引入左侧导航栏结束 -->

  <!-- 数据模板 -->
  <script type='text/template' id='postsTpl'>
    {{each list}}
    <tr>
      <td class="text-center"><input type="checkbox"></td>
      <td>{{$value.title}}</td>
      <td>{{$value.nickname}}</td>
      <td>{{$value.slugname}}</td>
      <td class="text-center">{{$value.created | formdata}}</td>
      <td class="text-center" data-status="{{$value.status}}">{{$value.status | fontcc}}</td>
      <td class="text-center">
        <a href="javascript:;" class="btn btn-default btn-xs edit">编辑</a>
        <a href="javascript:;" class="btn btn-danger btn-xs remove">删除</a>
      </td>
    </tr>
    {{/each}}
  </script>

  <!-- 模板：分类下拉框的模板引擎 -->
  <script type="text/template" id="categories_tpl">
    <option value="">所有分类</option>
    {{each list}}
    <option value="{{$value.id}}">{{$value.name}}</option>
    {{/each}}
  </script>


  <script src="../assets/vendors/jquery/jquery.js"></script>
  <script src="../assets/vendors/bootstrap/js/bootstrap.js"></script>
  <script src='../assets/vendors/art-template/template-web.js'></script>
  <script src="../assets/vendors/twbs-pagination/jquery.twbsPagination.js"></script>
  <script>NProgress.done()</script>
  <script>
  
  //template过滤器
  template.defaults.imports.formdata = function(created){
    var r = /(\d+)\-(\d+)\-(\d+)\s+\d+:\d+:\d+/;
      var m = r.exec( created );
      return m[ 1 ] + '/' + m[ 2 ] + '/' + m[ 3 ];
  }
  template.defaults.imports.fontcc = function(status){
    var obj = {
      published:'已发布',
      drafted:'草稿',
      trashed:'回收站'
    }
    return obj[status]?obj[status]:'未设置';
  }

  //初始化数据列表方法
  function load_posts(search){
    search = search || {};
    $.get('api/getposts.php',search,function(res){
      res = JSON.parse(res);
      if(res.success)
      {
        $('#table_list tbody').html(template('postsTpl',{list:res.result}));
      }
    })
  }
  //绑定categories下拉框
  function load_categories(){
    //获取初始化分类与状态
    
    //获取所有分类类型
    $.get('api/getCategories.php',function(res){
      res = JSON.parse(res);
      if(res.success)
      {
        $('#categorie').html(template('categories_tpl',{list:res.result}));
      }
    })
  }
  //绑定status下拉框
  function load_status(){
    var str = '<option value="">所有状态</option>';
    //获取所有数据类型
    $.get('api/getPostsStatus.php',function(res){
      res = JSON.parse(res);
      if(res.success)
      {
        for(var i=0;i<res.result.length;i++)
        {
          str += '<option value="'+ res.result[i]["status"] +'">'+ switchcc(res.result[i]["status"]) +'</option>'
        }
        
        $('#status').html(str);
      }
    })
  }
  //类型判断
  function switchcc(str)
  {
    switch(str)
    {
      case "published":
      return "已发布";
      break;
      case "drafted":
      return "草稿";
      break;
      case "trashed":
      return "回收站";
      break;
      default:
      return "未设置";
      break;
    }
  }
  $(function(){
    //初始化绑定下拉框
    load_categories();
    //初始化绑定下拉框
    load_status();
    //初始化数据列表
    load_posts();
    //初始化分页
    load_pagination();
  })

  //筛选按钮
  $(function(){
    $('#screen').on('click','#shaixuan_btn',function(){
      //获取数据
      var status = $('#status').val();
      var categorie = $('#categorie').val();
      $.get('api/getposts.php',{status:status,categorie:categorie},function(res){
      res = JSON.parse(res);
      if(res.success)
      {
        $('#table_list tbody').html(template('postsTpl',{list:res.result}));
        pageNation.twbsPagination('destroy'); // 销毁上一个分页的标签( 下面就会初始化 )
        load_pagination();
      }
    })
      return false;
    })
  })


  var pageNation = null;
  // 封装 load_pagination: 用于加载处理分页的 标签
  function load_pagination(){
    // 发送请求, 获得对应的 总数
    //获取当前筛选条件的参数
    // alert( $( '#screen' ).serialize() );
    $.get( 'api/getpostcount.php', $( '#screen' ).serialize(), function ( json ) {
        // 首先计算总页数
        json = JSON.parse(json).result[0];
        var totlepage = Math.ceil( json.count / 10 );
        var visualpage = totlepage > 5 ? 5 : totlepage;

        pageNation = $('.pagination').twbsPagination({
          totalPages: totlepage,
          visiblePages: visualpage,
          first: '首页',
          last: '末页',
          prev: '上一页',
          next: '下一页',
          onPageClick: function (event, page) {
            // 点击以后, 再次刷新数据用的
            // alert( '准备跳转到第 ' + page + ' 页' );
            var formdata = $( '#screen' ).serialize();
            load_posts( formdata + '&pageindex=' + page );
          }
        });
      } );
  }

  </script>
</body>
</html>
