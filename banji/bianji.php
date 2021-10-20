<?php

use PhpMyAdmin\SqlParser\Utils\Query;

include_once('function.php');
include_once('config_sql.php');
include_once('function_sql.php');
if ($_POST) {
  $dep_id = $_POST['dep_id'];
  $name = $_POST['name'];
  if (isset($dep_id) &&  !isset($name)) {
    // $sql = "SELECT * FROM class WHERE dep_id =" . " '$dep_id'";
    // $admin = getone($sql);
    $admin = $DB->select()->from('department')->where("id='$dep_id'")->getOne();
    // var_dump($admin);
    if ($admin) {
      echo '系部已存在,可以';
      
    } else {
      echo '不可以';exit;
    }
  }
  if (!isset($dep_id) &&  isset($name)) {
    $admin = $DB->select()->from('class')->where("name ='$name'")->getOne();
    if ($admin) {
      echo 'name已存在';
      exit;
    } else {
      echo 'name可以';
    }
  }
  if (isset($dep_id) &&  isset($name)) {
    $admin = $DB->select()->from('department')->where("id='$dep_id'")->getOne();
    // var_dump($admin);
    if ($admin) {
      echo '系部已存在,可以';
      
    } else {
      echo '不可以';exit;
    }
    $admin = $DB->select()->from('class')->where("name ='$name'")->getOne();
    if ($admin) {
      echo 'name已存在';
      exit;
    } else {
      echo 'name可以';
    }
    $id=$DB->select()->from('class')->order('id desc')->limit(1)->getOne()['id']+1;

    $data = [
      'id'=>$id,
      'dep_id' => $dep_id,
      'name' => $name
    ];
    // $res = insert('class', $data);
    $res = $DB->insert('class', $data)->query();
    // $res = $DB->insert('class', $data)->getSql();
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
