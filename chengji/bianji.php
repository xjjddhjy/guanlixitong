<?php

use PhpMyAdmin\SqlParser\Utils\Query;

include_once('function.php');
include_once('config_sql.php');
include_once('function_sql.php');
if ($_POST) {
  $stu_id = $_POST['stu_id'];
  $subject_id = $_POST['subject_id'];
  $achievement = $_POST['achievement'];
  if (isset($stu_id) &&  !isset($subject_id)) {
    // $sql = "SELECT * FROM chengji WHERE stu_id =" . " '$stu_id'";
    // $admin = getone($sql);
    $admin = $DB->select()->from('student')->where("id ='$stu_id'")->getOne();
    // var_dump($admin);
    if ($admin) {
      echo 'stu_id已存在,ok';
      
    } else {
      echo 'stu_id不存在';exit;
    }
  }
  if (!isset($stu_id) &&  isset($subject_id)) {
    $admin = $DB->select()->from('subject')->where("id ='$subject_id'")->getOne();
    if ($admin) {
      echo 'subect_id已存在ok';
      
    } else {
      echo 'subect_id不存在';exit;
    }
  }

  if (isset($stu_id) &&  isset($subject_id)  &&  isset($achievement)) {
    $data = [
      'stu_id' => $stu_id,
      'subject_id' => $subject_id,
      'achievement' => $achievement,

    ];
    // $res = insert('chengji', $data);
    $res = $DB->insert('chengji', $data)->query();
    // $res = $DB->insert('chengji', $data)->getSql();
    // var_dump($res) ;exit;
    if (!($res > 0)) {
      //show_msg('新增失败');
      
      echo '新增失败'.json_encode($res);
    } else {
      //show_msg('新增成功', '', -2);
      echo '新增成功';
      exit;
    }
  }
}
