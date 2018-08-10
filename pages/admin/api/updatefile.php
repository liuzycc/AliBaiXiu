<?php

//文件上传

$file = $_FILES["file"];
//MD5文件名
$filename = $file['name'];
$arr = explode('.',$filename);
$ext = array_pop($arr);
$newname = md5_file($file["tmp_name"]);
$path = "../../uploads/" . $newname . "." .$ext;
$bool = move_uploaded_file($file["tmp_name"],$path);
// header('Content-type:application/json;charset=utf-8');
echo json_encode(array(
  "success"=>$bool,
  "result"=>array(
    //返回图片的绝对路径
    "path"=>"/uploads/" . $newname . "." . $ext
  )
  
))



?>