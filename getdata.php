<?php
header("Content-type:application/json;charset=utf-8");
include_once('function.php');
include_once('config_sql.php');
include_once('function_sql.php');
// $sql = "SELECT * FROM houtaiguanli";
// $res=mysqli_query($conn,$sql);
$data=$DB->select()->from('administrator')->getAll();

// if($res && mysqli_num_rows($res)>0){
//     while($arr=mysqli_fetch_assoc($res)){
//         $data[]=$arr;
//     }
// }
echo json_encode($data);
