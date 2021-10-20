<?php
include_once('function.php');
// 接受提交的数据 $_POST
//echo $_POST['username'];
$name = $_POST['username'];
// 读取出JSON // string
// 转化为 PHP对象 (数组)
// string->arr
$jsonString = file_get_contents('./database/data.json');
$nameArr = json_decode($jsonString, true);
$result = 0;
foreach ($nameArr as $v) {
  if ($v["username"] == $name) {
    $result = 1;
  }
}
// echo $result, $name;
var_dump($nameArr);
//var_dump($_POST);
if ($_POST) {
  /* 
            文件操作 查询数据跟判断用户是否正正确
            数据库   条件查询该条用户数据然后再做判断
        */
  if (strtolower($_SESSION['imgcode']) == strtolower($_POST['imgcode'])) {
    $backInfo = array();
    // true false
    if ($result == 1) {
      // 用户名存在 用不了
      $backInfo['message'] = '真遗憾,已被注册';
      $backInfo['status'] = 'cannot';
      echo '真遗憾,已被注册';
    } else {
      // 如果为false 可以用
      $backInfo['message'] = '恭喜你,注册成功';
      $backInfo['status'] = 'can';
      $nd = array();
      $nd["id"] = count($nameArr) + 1;
      $nd["pwd"] = md5($_POST['pwd']);
      $nd["username"] = $_POST['username'];
      $nd["createtime"] = time();
      $nameArr[] = $nd;
      // 转化为JSON格式的字符串
      $newJsonString = json_encode($nameArr);
      // 写入 json文件中
      // 参数1 写入的文件
      // 参数2 写入的数据
      file_put_contents('./database/data.json', $newJsonString);
      // 提示用户 注册成功了
      echo '注册成功';
      // echo $v['username'];
      //$_SESSION['is_login'] = 1;
      //setcookie('username', $v['username']);
      setcookie('is_login', 1, time() + 3);
      setcookie('user_name', 'name', time() + 3);
      if ($_POST['remember']) {
        setcookie('is_login', 1, time() + 7 * 24 * 3600);
        setcookie('user_name', 'name', time() + 7 * 24 * 3600);
      }
      show_msg('登录成功', 'index.php');
    }
  } else {
    //show_msg('验证码错误');
    echo '验证码错误';
  }
}


// 准备一个 返回数据的 关系型数组

// PHP中 关系型数组
// print_r($backInfo);
// 为了 让浏览器 解析方便 把数组 转化为 JSON格式的字符串
// arr ->JSON string
// echo json_encode($backInfo);


sleep(2);

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>注册页面</title>
  <style>
    .disabled {
      /* background-color: gray !important; */
      background: gray !important;
      cursor: not-allowed !important;
    }
  </style>
</head>
<script src="./js/jquery-1.12.4.min.js"></script>

<body>
  <form method="POST">
    <table>
      <tr>
        <td align="right">用户名:</td>
        <td><input type="text" name="username" id="username"></td>
      </tr>
      <tr>
        <td align="right">密码:</td>
        <td><input type="password" name="pwd" id="pwd"></td>
      </tr>
      <tr>
        <td align="right">再次输入密码:</td>
        <td><input type="password2" name="pwd2" id="pwd2"></td>
      </tr>
      <tr>
        <td align="right">验证码:</td>
        <td><input id="imgcode" type="text" name="imgcode" maxlength="4" autocomplete="off" style="width: 50px;position: relative;top: 0px;"></td>
        <img src="imgcode.php" alt="" style="margin-left:7px;" title="点击更换图片" id="img" />
      </tr>
      <tr>
        <td></td>
        <td><input type="checkbox" name="remember" value="1">7天内自动登录</td>
      </tr>
      <tr>
        <td></td>
        <td>
          <input type="submit" value="注册" id="submit">
        </td>
      </tr>
    </table>
  </form>
</body>
<script>
  //获取验证码的id，做点击事件，点击一下就随机刷新
  var img = document.getElementById('img');
  var submit = document.getElementById('submit');
  var pwd = document.querySelector('input[type="password"]');
  var npwd = document.querySelector('input[type="password2"]');
  $('#submit').click(function() {
    //alert($('input[type="password"]').val())
    if ($('input[type="password"]').val() != $('input[type="password2"]').val()) {
      alert('密码不一致');
      return false;
    } else {
      $('#submit').attr("disabled", false)
    }
  })
  $('#pwd2').change(function(){
    if($('#username').val() && $('#pwd2').val() && $('#pwd').val() && $('#imgcode').val()){
      $('#submit').attr("disabled", false)
    }else{
      $('#submit').attr("disabled", true)
      return false;
    }
  })
  $('#username').change(function(){
    if($('#username').val() && $('#pwd2').val() && $('#pwd').val() && $('#imgcode').val()){
      $('#submit').attr("disabled", false)
    }else{
      $('#submit').attr("disabled", true)
      return false;
    }
  })
  $('#pwd').change(function(){
    if($('#username').val() && $('#pwd2').val() && $('#pwd').val() && $('#imgcode').val()){
      $('#submit').attr("disabled", false)
    }else{
      $('#submit').attr("disabled", true)
      return false;
    }
  })
  $('#imgcode').change(function(){
    if($('#username').val() && $('#pwd2').val() && $('#pwd').val() && $('#imgcode').val()){
      $('#submit').attr("disabled", false)
    }else{
      $('#submit').attr("disabled", true)
      return false;
    }
  })
  // $('submit').click(function(){
  //   if($('submit').hasClass('disabled')){
  //     return false;
  //   }
  // })
  img.onclick = function() {
    this.src = 'imgcode.php?id=' + Math.random();
  }
</script>

</html>