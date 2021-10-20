<?php
include_once('function.php');
include_once('config_sql.php');
include_once('function_sql.php');
$id = $_POST['id'];
// $row = delete('position',"id=$id");
$row =$DB->delete('subject',"id=$id")->query();
if($row>0){
  echo '删除id'. $id.'成功';
}

?>