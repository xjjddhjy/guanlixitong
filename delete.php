<?php
include_once('function.php');
include_once('config_sql.php');
include_once('function_sql.php');
$id = $_POST['id'];
// $sql = "SELECT * FROM houtaiguanli WHERE id =" . " '$id'";
// $admin = getone($sql);
// $avatar = $admin['avatar']; // 拿到原来的图片名
$admin =$DB->select('*')->from('administrator')->where("id=$id")->getone();
$avatar = $admin['avatar']; // 拿到原来的图片名
unlink($avatar);
// $row = delete('houtaiguanli',"id=$id");
$res=$DB->delete('administrator',"id=$id")->query();
if($res==1){
  echo '删除id'. $id.'成功';
}

?>