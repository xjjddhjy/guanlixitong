<?php

use PhpMyAdmin\SqlParser\Utils\Query;

include_once('function.php');
include_once('config_sql.php');
include_once('function_sql.php');
if ($_POST) {
  $class_id = $_POST['class_id'];
  $name = $_POST['name'];
  if (isset($class_id) &&  !isset($name)) {
    // $sql = "SELECT * FROM department WHERE class_id =" . " '$class_id'";
    // $admin = getone($sql);
    $admin = $DB->select()->from('department')->where("id ='$class_id'")->getOne();
    // var_dump($admin);
    if ($admin) {
      echo 'class_id已存在';
      exit;
    } else {
      echo 'class_id可以';
    }
  }
  if (!isset($class_id) &&  isset($name)) {
    $admin = $DB->select()->from('department')->where("name ='$name'")->getOne();
    if ($admin) {
      echo 'name已存在';
      exit;
    } else {
      echo 'name可以';
    }
  }
  if (isset($class_id) &&  !isset($name)) {
    // $sql = "SELECT * FROM department WHERE class_id =" . " '$class_id'";
    // $admin = getone($sql);
    $admin = $DB->select()->from('department')->where("id ='$class_id'")->getOne();
    // var_dump($admin);
    if ($admin) {
      echo 'class_id已存在';
      exit;
    } else {
      echo 'class_id可以';
    }
  }
  if (!isset($class_id) &&  isset($name)) {
    $admin = $DB->select()->from('department')->where("name ='$name'")->getOne();
    if ($admin) {
      echo 'name已存在';
      exit;
    } else {
      echo 'name可以';
    }
  }
  if (isset($class_id) &&  isset($name)) {
    $data = [
      'id' => $class_id,
      'name' => $name
    ];
    // $res = insert('department', $data);
    $res = $DB->insert('department', $data)->query();
    // var_dump($res) ;exit;
    if (!($res > 0)) {
      //show_msg('新增失败');
      echo '新增失败';
    } else {
      //show_msg('新增成功', '', -2);
      echo '新增成功';
      exit;
    }
  }
}
