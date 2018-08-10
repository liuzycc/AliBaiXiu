<?php

require_once "fn.php";

$sql = "
SELECT
  t1.id                              -- id
  , t1.title                         -- 文章标题
  , t1.created                       -- 文章发表时间
  , t1.content                       -- 文章内容
  , t1.views                         -- 文章阅读数量
  , t1.likes                         -- 文章点赞数量
  , (SELECT 
     COUNT( * ) 
     FROM comments 
     WHERE post_id=t1.id) 
     AS commentscount                -- 文章评论数量
  , t2.name                          -- 分类名
  , t3.nickname                      -- 作者昵称
  , t1.feature
FROM
  posts AS t1
  INNER JOIN
  categories AS t2
  ON t1.category_id = t2.id
  INNER JOIN
  users AS t3
  ON t1.user_id = t3.id
LIMIT 5";

$list = query( $sql );

header( "Content-Type: application/json; charset=utf-8" );
echo json_encode(array(
    "success" => count( $list ) > 0,
    "result" => $list
));

?>