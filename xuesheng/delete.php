<?php
include_once('function.php');
include_once('config_sql.php');
include_once('function_sql.php');
$id = $_POST['id'];
// $row = delete('staff',"id=$id");
// $row = delete('staff',"id=$id");
$rows=$DB->delete('student',"id=$id")->query();
if($rows>0){
  echo '删除id'. $id.'成功';;
}
?>