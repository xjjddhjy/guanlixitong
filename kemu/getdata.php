<?php
header("Content-type:application/json;charset=utf-8");
include_once('function.php');
include_once('config_sql.php');
include_once('function_sql.php');
include_once('Page.class.php');
$current = !empty($_POST['page']) ? $_POST['page'] : 1;
$limit = 4;
$size = 2;
$con = ($current - 1) * $limit;


if ($_POST['search']) {
  $p = $_POST['search'];
  $sql=$DB->select()->from('subject')->where("name='$p'");

  $count = $DB->count();

} else {
  $sql=$DB->select()->from('subject');

  $count = $DB->count();
}

$data = array();
$data['data'] = $DB->limit("$con,$limit")->getAll();

$show = new Page\page($current, $count, $limit, $size);
$data['page'] = $show->page();
echo json_encode($data);