<?php
include_once('function.php');
//echo $_SESSION['is_login'];// 输出$_session的值
//echo $_COOKIE['is_login'];
if (!empty($_COOKIE['is_login'])) { //判断$_session不为空时
  if ($_COOKIE['is_login'] != 1) { //判断$_session的值不等于1时
    show_msg('请先登录！','login.html');
  }
} else { //为空
  show_msg('请先登录！','login.html');
}
// if($_POST){
// 假如我们现在是做用户新增功能 个人资料  头像
// }
if ($_FILES) {
  //p($_FILES);// 打印出来上传的数组
  $data = [];
  foreach ($_FILES as $key => $value) {
    foreach ($value as $ke => $val) {
      foreach ($val as $k => $v) {
        $data[$k][$key][$ke] = $v;
      }
    }
  }
  //     Array
  // (
  //     [photo] => Array
  //         (
  //             [name] => Array
  //                 (
  //                     [0] => ~_709MSZOPR$JBBCU{E$M~Q.png
  //                     [1] => 58CWDAD288NUKI5V)(UF`7S.png
  //                 )

  //             [type] => Array
  //                 (
  //                     [0] => image/png
  //                     [1] => image/png
  //                 )

  //             [tmp_name] => Array
  //                 (
  //                     [0] => C:\Users\xjj\AppData\Local\Temp\php8E89.tmp
  //                     [1] => C:\Users\xjj\AppData\Local\Temp\php8E99.tmp
  //                 )

  //             [error] => Array
  //                 (
  //                     [0] => 0
  //                     [1] => 0
  //                 )

  //             [size] => Array
  //                 (
  //                     [0] => 14263
  //                     [1] => 23049
  //                 )

  //         )

  // )
  // p($data);
  // exit;
  // 如果当前文件的目录没有上传文件夹，那么创建
  if (!is_dir('upload')) {
    mkdir('upload');
  }
  // 调用上传函数 只需一个参数 就是input的名字
  // $photo = upload('photo');
  // $i = 0;
  $photo='';
  foreach ($data as $v) {
    $photo = $photo . uploads('photo', $v);
  }
  // var_dump($photo);// /上传成功返回一个字符串 图片上传成功,图片名
  $arr = explode(',', $photo); //字符串转化数组
  // $arr1 = array_values($arr);
  // foreach($arr as $v){
  //     if($v == ' '){
  //         continue;
  //     }
  // }
  // p($arr);// 打印数组
  if ($arr[0] == '图片上传成功') { // 判断$arr[0]的值是否等于图片上传成功
    show_msg('上传成功', 'index.php'); // 调用一个带跳转的提示函数
  } else {
    show_msg('上传失败');
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>

<body>
  <h1>欢迎，<?php echo $_COOKIE['user_name']; ?></h1>
  <a href="out.php">退出</a>
  <a href="clear.php">清除cookie</a>
  <form method="post" enctype="multipart/form-data">
    <!-- 
            在input里的name属性加[] multiple多选属性
         -->
    <input type="file" name="photo[]" multiple>
    <input type="submit" value="上传">
  </form>
</body>

</html>