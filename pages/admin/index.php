<?php
include_once "fn.php";
if($_SERVER["REQUEST_METHOD"] == "GET")
{
  $list = check_login();


  //站点内容数据获取
  //获取文章和草稿
  $post_all_count = xx_query("select COUNT(*) as count from posts");
  $post_drafted_count = xx_query("select COUNT(*) as drafted from posts where status = 'drafted'");

  //获取全部分类

  $categories_all = xx_query("select COUNT(*) as categories from categories");

  //获取评论信息

  $comments_all_count = xx_query("select COUNT(*) as comments from comments");
  $comments_held_count = xx_query("select COUNT(*) as comments FROM comments where status='held'");
}

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
    <!-- 公共部分顶部导航条 -->
    <?php include_once "inc/navigator.html" ?>
    <!-- 公共部分end -->
    <div class="container-fluid">
      <div class="jumbotron text-center">
        <h1>One Belt, One Road</h1>
        <p>Thoughts, stories and ideas.</p>
        <p><a class="btn btn-primary btn-lg" href="post-add.html" role="button">写文章</a></p>
      </div>
      <div class="row">
        <div class="col-md-4">
          <div class="panel panel-default">
            <div class="panel-heading">
              <h3 class="panel-title">站点内容统计：</h3>
            </div>
            <ul class="list-group">
              <li class="list-group-item"><strong><?php echo $post_all_count[0]; ?></strong>篇文章（<strong><?php echo $post_drafted_count[0]; ?></strong>篇草稿）</li>
              <li class="list-group-item"><strong><?php echo $categories_all[0]; ?></strong>个分类</li>
              <li class="list-group-item"><strong><?php echo $comments_all_count[0]; ?></strong>条评论（<strong><?php echo $comments_held_count[0]; ?></strong>条待审核）</li>
            </ul>
          </div>
        </div>
        <div class="col-md-4"></div>
        <div class="col-md-4"></div>
      </div>
    </div>
  </div>

  <!-- 引入左侧导航栏 -->
  <?php include_once "inc/left_menu.html"; ?>
  <!-- 引入左侧导航栏结束 -->

  <script src="../assets/vendors/jquery/jquery.js"></script>
  <script src="../assets/vendors/bootstrap/js/bootstrap.js"></script>
  <script>NProgress.done()</script>
</body>
</html>
