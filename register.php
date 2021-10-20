<?php
include_once('function.php');
include_once('config_sql.php');


if ($_POST) {
  if (empty($_POST['password'])) {
    $username = $_POST['username'];

    $sql = "SELECT * FROM administrator WHERE username =" . " '$username'";
    $admin = $DB->editSql($sql)->getOne();
    //echo $username;
    //var_dump($admin);
    $username = $_POST['username'];
    $pwd = md5($_POST['password']);
    if ($admin['username'] == $username) {
      echo '用户名已存在！';
      return;
    }
    exit;
  }
  $username = $_POST['username'];
  $pwd =  $_POST['password'];
  $sql = "SELECT * FROM houtaiguanli WHERE username =" . " '$username'";
  $admin = $DB->editSql($sql)->getOne();
  //echo $username;
  //var_dump($admin);
  // if ($admin['username'] == $username) {
  //   echo '用户名已存在！';
  //   return;
  // }
  if (!empty($admin)) {
    echo '用户名已存在！';
    return;
  }
  // if (!preg_match("/^(?=.*[0-9])(?=.*[a-zA-Z])(?=.*[^\w\s]).{8,16}$/", $pwd)) {
  //   echo '密码不合规';
  //   exit;
  // }

  if (strtolower($_SESSION['imgcode']) == strtolower($_POST['imgcode'])) {
    $sql = "select id from administrator order by id desc limit 1";
    $id = $DB->editSql($sql)->getOne()['id']+1;
    $salt=get_str(4);
    $data = [
      'id'=>$id,
      'username' => $username,
      'password' => md5($pwd.$salt),
      'salt' => $salt,
      // 'createtime' => time()
    ];
    // var_dump($data);exit;
    // $res = insert('administrator', $data);
    $res =$DB->insert('administrator', $data)->query();

    if ($res) {
      $_SESSION['is_login'] = 1;
      $_SESSION['username'] =  $username;
      setcookie('is_login', 1, time() + 3);
      setcookie('username', $username, time() + 3);
      if ($_POST['remember']) {
        $_SESSION['username'] =  $username;
        setcookie('is_login', 1, time() + 7 * 24 * 3600);
        setcookie('username',  $username, time() + 7 * 24 * 3600);
      }
      echo '["注册成功","list.html"]';

    } else {
      //show_msg('注册失败');
      echo '注册失败';
    }
  } else {
    //show_msg('验证码不正确！');
    echo '验证码不正确';
  }
}
