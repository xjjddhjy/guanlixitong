<?php

use DB\DB;

include_once('function.php');
include_once('config_sql.php');
include_once('function_sql.php');
if ($_POST) {

  // 创建一个存放上传图片的文件夹
  $file = 'upload';
  if (!is_dir($file)) {
    mkdir($file);
  }
  $result = upload('avatar', $file);
  $arr = explode(',', $result);
  $pwd = $_POST['password'];
  $username = $_POST['username'];
  $createtime=time();
  $sql = "select id from administrator order by id desc limit 1";
  $id = $DB->editSql($sql)->getOne()['id']+1;
  $salt=get_str(4);
  // 封装数据的数组
  $data = [
    'id'=>$id,
      'username' => $username,
      'password' =>md5($pwd.$salt) ,
      'salt' => $salt,
    // 'createtime' => $createtime
  ];
  if ($arr[0] == '图片上传成功') {
    $data['avatar'] = $arr[1];
    // unlink($avatar);
  } else {
    show_msg($arr[0]);
  }
  // var_dump($data);exit;
  // $res=insert('houtaiguanli', $data);
  $res=$DB->insert('administrator',$data)->query();
  if (!$res) {
    show_msg('新增失败'.json_encode($res));
  } else {
    show_msg('新增成功','',-2);
  }
}
