<?php
header("Content-type:application/json;charset=utf-8");
include_once('function.php');
include_once('config_sql.php');
include_once('function_sql.php');

$sql1 = "SELECT name   from  department  ;";
$sql = $DB->editSql($sql1);
$data1 = $DB->getAll();

$sql2 = "SELECT name   from  class   ;";
$sql = $DB->editSql($sql2);
$data2 = $DB->getAll();


$data = array();
$data[] = $data1;
$data[] = $data2;
// if ($res1 && mysqli_num_rows($res1) > 0) {
//   while ($arr = mysqli_fetch_assoc($res1)) {
//     $data[0][] = $arr;
//   }
// }
// if ($res2 && mysqli_num_rows($res2) > 0) {
//   while ($arr = mysqli_fetch_assoc($res2)) {
//     $data[1][] = $arr;
//   }
// }
echo json_encode($data);
