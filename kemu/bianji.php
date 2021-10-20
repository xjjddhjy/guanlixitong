<?php
include_once('function.php');
include_once('config_sql.php');
include_once('function_sql.php');
if ($_POST) {
  $id = $_POST['id'];
  $name = $_POST['name'];
  $credit= $_POST['credit'];
  if (isset($id) &&  !isset($name)) {
    // $sql = "SELECT * FROM subject WHERE id =" . " '$id'";
    // $admin = getone($sql);
    $admin = $DB->select()->from('subject')->where("id ='$id'")->getOne();
    if ($admin) {
      echo 'id已存在';
      exit;
    } else {
      echo 'id可以';
    }
  }
  if (!isset($id) &&  isset($name)) {
    // $sql = "SELECT * FROM subject WHERE name =" . " '$name'";
    // $admin = getone($sql);
    $admin = $DB->select()->from('subject')->where("name = '$name'")->getOne();
    if ($admin) {
      echo 'name已存在';
      exit;
    } else {
      echo 'name可以';
    }
  }
  if (isset($id) &&  isset($name)) {
    // $sql = "SELECT * FROM subject WHERE id =" . " '$id'";
    // $admin = getone($sql);
    $admin = $DB->select()->from('subject')->where("id ='$id'")->getOne();
    if ($admin) {
      echo 'id已存在';
      exit;
    } else {

    }
    // $sql = "SELECT * FROM subject WHERE name =" . " '$name'";
    // $admin = getone($sql);
    $admin = $DB->select()->from('subject')->where("name = '$name'")->getOne();
    if ($admin) {
      echo 'name已存在';
      exit;
    } else {

    }
    
    $data = [
      'id' => $id,
      'name' => $name,
      'credit'=>$credit
    ];
    if($_POST['teacher']){
      $data['teacher']=$_POST['teacher'];
    }
    // $res = insert('subject', $data);
    $res=$DB->insert('subject', $data)->query();
    // $res=$DB->insert('subject', $data)->getSql();
    // var_dump($res);exit;
    if ($res < 0) {
      //show_msg('新增失败');
      echo '新增失败'."$res";
    } else {
      //show_msg('新增成功', '', -2);
      echo '新增成功'."$res";
      exit;
    }
  }

}
