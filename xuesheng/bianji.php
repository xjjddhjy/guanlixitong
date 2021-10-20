<?php

use PhpMyAdmin\SqlParser\Utils\Query;

include_once('function.php');
include_once('config_sql.php');
include_once('function_sql.php');
if ($_POST) {
  $id = $_POST['id'];
  $dep_id = $_POST['dep_id'];
  $name = $_POST['name'];
  $sex = $_POST['sex'];
  $class_id = $_POST['class_id'];
  $number = $_POST['number'];
  // $mobile = $_POST['mobile'];
  // $address = $_POST['address'];
  // $email = $_POST['email'];
  // $createtime = $_POST['createtime'];
  if (isset($id) && count($_POST)==1 ) {
    $sql = "SELECT * FROM student WHERE id =" . " '$id'";
    $sql=$DB->editSql($sql);
    $admin = $DB->getone();
    if (empty($admin) ) {
      echo 'id不存在ok';
      exit;
    } else {
      echo 'id存在'.json_encode($admin);
      exit;
    }
  }
  $sql = "SELECT * FROM department WHERE name =" . " '$dep_id'";$sql=$DB->editSql($sql);
  $admin = $DB->getone();
  $dep_id = $admin['id'];
  $sql = "SELECT * FROM class WHERE name =" . " '$class_id'";$sql=$DB->editSql($sql);
  $admin = $DB->getone();
  $class_id = $admin['id'];

  $file = 'upload';
  if (!is_dir($file)) {
    mkdir($file);
  }
  $result = upload('avatar', $file);
  $arr = explode(',', $result);
  // 封装数据的数组
  $data = [
    'name' => $name,
    'dep_id' => $dep_id,
    'sex' => $sex,
    'id' => $id,
    'class_id'=>$class_id,
    'number'=>$number,

    // 'mobile' => $mobile,
    // 'address' => $address,
    // 'email' => $email,
    // 'createtime' => $createtime,
  ];
  if ($arr[0] == '图片上传成功') {
    $data['avatar'] = $arr[1];
  } else {
    show_msg($arr[0]);
  }
  // $res = insert('staff', $data);
  $res=$DB->insert('student', $data)->query();
  // $sql=$DB->insert('student', $data)->getSql();
  // $sql=json_encode($sql);
// echo $sql;exit;
  if ($res < 0) {
    show_msg('修改失败');
  } else {
    show_msg('修改成功', '', -2);
  }
}
