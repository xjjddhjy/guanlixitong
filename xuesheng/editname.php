<?php

use PhpMyAdmin\SqlParser\Utils\Query;

include_once('function.php');
include_once('config_sql.php');
include_once('function_sql.php');
$conditions='id='.$_POST['id'];
$field=$_POST['name'];
$sql = "UPDATE student SET name= '$field'  WHERE $conditions";
$sql=$DB->editSql($sql)->query();

// UPDATE staff SET name='李四' WHERE id=3;
// $res = mysqli_query($conn, $sql);
// if ($res) {
//   $affect_id = mysqli_affected_rows($conn);
// } else {
//   echo mysqli_error($conn);
//   exit;
// }
// echo $affect_id;
if($sql>0){
  echo $_POST['name'];
}

