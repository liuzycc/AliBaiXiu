<?php

include_once "fn.php";
$where = array();
if ( !empty( $_GET[ "status" ] ) ) {
  // 有参数
  $status = $_GET[ "status" ];
  $where[] = "t1.`status` = '$status'";
} 
if ( !empty( $_GET[ "categorie" ] ) ) {
  // 有参数 
  $where[] = "t1.category_id=" . $_GET[ "categorie" ];
} 
// $status=$_GET["status"];
// $categorie=$_GET["categorie"];
//获取分页参数
// $ss = $status==-1?"where 1=1":"where t1.status ='$status'";
// $cc = $categorie==-1?" and 1=1":" and t1.category_id ='$categorie'";


//获取分页数据
if ( isset( $_GET[ "pageindex" ] ) ) {
  $pageindex = $_GET[ "pageindex" ];
} else {
  $pageindex = 1;
}

if ( isset( $_GET[ "pagesize" ] ) ) {
  $pagesize = $_GET[ "pagesize" ];
} else {
  $pagesize = 10; // 如果没有提供 每页的条数, 就使用默认 10 条
}

$sql = "select 
COUNT( * ) as count
from 
posts as t1 left join users as t2 
on t1.user_id = t2.id 
left join categories t3 
on t3.id = t1.category_id
";

if ( count( $where ) > 0 ) { // 有参数
  $sql .= "WHERE " . join( " AND ", $where );
}

//处理分页的添加语句
$tmp = ( $pageindex - 1 ) * $pagesize;
$sql .= " LIMIT $tmp, $pagesize";

$list = query($sql);

echo json_encode(array(
  "success"=>true,
  "result"=>$list
))

?>