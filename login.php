<?php
include_once('function.php');
include_once('config_sql.php');
//include_once('function_sql.php');

if ($_POST) {

  $username = $_POST['username'];
  // $sql = "SELECT * FROM houtaiguanli WHERE username =" . " '$username'";
  // $admin = getone($sql);
  //echo $username;
  //var_dump($admin);
  $admin=$DB->select('*')->from('administrator')->where(" username = '$username'")->getOne();
  // var_dump($admin);exit;
  if (empty($admin)) {
    echo '用户名不存在！';
    return;
  }
$salt=$admin['salt'];
  $pwd =  $_POST['pwd'];
  if ($admin['password']!=md5($pwd.$salt) ) {
    echo '密码错误！';
    return;
  }

  if (strtolower($_SESSION['imgcode']) == strtolower($_POST['imgcode'])) {
      $_SESSION['is_login'] = 1;
      $_SESSION['username'] =  $username;
      setcookie('is_login', 1, time() + 3);
      setcookie('username', $username, time() + 3);
      if ($_POST['remember']) {
        $_SESSION['username'] =  $username;
        setcookie('is_login', 1, time() + 7 * 24 * 3600);
        setcookie('username',  $username, time() + 7 * 24 * 3600);
      }
      echo "登录成功";
  } else {
    //show_msg('验证码不正确！');
    echo '验证码不正确';
  }
}
