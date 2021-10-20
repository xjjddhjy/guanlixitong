<?php
include_once('function.php');
include_once('config_sql.php');
include_once('function_sql.php');
$dep_id = $_POST['id'];
// $row = delete('department',"dep_id=$dep_id");
$rows=$DB->delete('chengji',"id='$dep_id'")->query();
if($rows>0){
  echo '删除dep_id'. $dep_id.'成功';
}

?>