<?php
// 开启session会话
session_start();
// 打印数组的函数
function p($data)
{
  echo '<pre>';
  print_r($data);
  echo '</pre>';
}
function get_str($length = 1){
  $chars = '1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZ';
  $size = str_shuffle($chars);// 随机打乱字符串
  $str = substr($size,0,$length);
  return $str;
}
/* 
        带跳转的提示函数
        msg  提示信息
        url  要跳转的地址
    */
// empty 判断某个变量的值是否为空
// exit 停止后面代码执行
// die  停止后面代码执行
function show_msg($msg, $url = null,$gonums=-1)
{
  if (!empty($url)) {
    echo "<script>alert('" . $msg . "');location.href='" . $url . "';</script>;";
    exit;
  } else {
    echo "<script>alert('" . $msg . "');window.history.go($gonums);</script>";
    exit;
  }
}
/* 
        msg 提示信息 
        result 状态  根据返回的状态去判断该操作是否成功 如果返回的是true 那么就是操作成功 否则失败
        data  返回请求的数据

    */

function result($msg, $result = false, $data = null)
{
  $data = [
    'msg' => $msg,
    'result' => $result,
    'data' => $data
  ];

  echo json_encode($data);
  exit;
}
/* 
        上传图片函数
        $name 提交过来的名称
        type  可以上传图片类型
        size  上传图片最大的值
        upload 上传成功后存放的文件夹
    */
function upload($name, $upload = 'upload', $type = ['png', 'jpg', 'gif', 'jpeg'], $size = 1048576)
{
  // 判断错误码
  $error = $_FILES[$name]['error'];
  switch ($error) {
    case 1:
      return '上传大小不能超过upload_max_filesize设置的值';
      break;
    case 2:
      return '上传大小不能超过MAX_FILE_SIZE设置的值';
      break;
    case 3:
      return '图片上传不完整';
      break;
    case 4:
      return '没有选择图片';
      break;
  }
  // 判断上传过的图片类型跟定义的类型数组是否一致
  $pre_type = pathinfo($_FILES[$name]['name'], PATHINFO_EXTENSION);

  // $file = fopen('jilu.txt', 'w+');
  // fwrite($file, $pre_type);
  // fwrite($file, $_FILES[$name]['name']);
  // fwrite($file,json_encode(var_dump($_FILES))  );
  // fclose($file);
  if (!in_array($pre_type, $type)) {
    return '上传的图片类型错误';
  }
  // 判断图片的大小
  $Size = $_FILES[$name]['size'];
  if ($Size > $size) {
    return '图片过大,请压缩后上传';
  }
  // 保存图片 随机数 为了防止后面的图片把前面的图片覆盖掉
  // 自定义图片名称 当前时间+两个随机数
  $prename = date('YmdHis', time()) . mt_rand(1000, 9999) . mt_rand(1000, 9999) . '.' . $pre_type;
  if (is_uploaded_file($_FILES[$name]['tmp_name'])) {
    // 把上传文件里面的临时文件保存到目标目录  第一个参数是临时文件，第二个参数是要保存到的目录 路径/文件名 upload/2021073110005744101525.png
    move_uploaded_file($_FILES[$name]['tmp_name'], $upload . '/' . $prename);
    return '图片上传成功,' . $upload . '/' . $prename;
  } else {
    return '图片上传错误';
  }
}


/* 
        上传多图片函数
        $name 提交过来的名称
        $files 代替$_FILES超全局变量
        type  可以上传图片类型
        size  上传图片最大的值
        upload 上传成功后存放的文件夹
    */
function uploads($name, $files, $type = ['png', 'jpg', 'gif', 'jpeg'], $size = 1048576, $upload = 'upload')
{
  // 判断错误码
  $error = $files[$name]['error'];
  switch ($error) {
    case 1:
      return '上传大小不能超过upload_max_filesize设置的值';
      break;
    case 2:
      return '上传大小不能超过MAX_FILE_SIZE设置的值';
      break;
    case 3:
      return '图片上传不完整';
      break;
    case 4:
      return '没有选择图片';
      break;
  }
  // 判断上传过的图片类型跟定义的类型数组是否一致
  $pre_type = pathinfo($files[$name]['name'], PATHINFO_EXTENSION);
  // echo $files[$name]['name'];
  // exit;
  if (!in_array($pre_type, $type)) {
    return '上传的图片类型错误';
  }
  // 判断图片的大小
  $Size = $files[$name]['size'];
  if ($Size > $size) {
    return '图片过大,请压缩后上传';
  }
  // 保存图片 随机数 为了防止后面的图片把前面的图片覆盖掉
  // 自定义图片名称 当前时间+两个随机数
  $prename = date('YmdHis', time()) . mt_rand(1000, 9999) . mt_rand(1000, 9999) . '.' . $pre_type;
  if (is_uploaded_file($files[$name]['tmp_name'])) {
    // 把上传文件里面的临时文件保存到目标目录  第一个参数是临时文件，第二个参数是要保存到的目录 路径/文件名 upload/2021073110005744101525.png
    move_uploaded_file($files[$name]['tmp_name'], $upload . '/' . $prename);
    return '图片上传成功,' . $prename . ',';
  } else {
    return '图片上传错误';
  }
}
