<?php
header("Content-type:application/json;charset=utf-8");
include_once('function.php');
include_once('config_sql.php');
include_once('function_sql.php');
include_once('Page.class.php');
$current = !empty($_POST['page']) ? $_POST['page'] : 1;
$limit = 4;
$size = 4;
$con = ($current - 1) * $limit;

if ($_POST['search']) {
  $p = $_POST['search'];
  $sql = "SELECT s.*,d.name as 'dname',c.name as 'cname'" .
    " from (select * from student where name='$p') as s left join department as d" .
    " on s.dep_id=d.id left join class as c on s.class_id=c.id";
  $DB->editSql($sql);
  $count = $DB->count();
} else {
  $sql = "SELECT s.*,d.name as 'dname',c.name as 'cname'" .
    " from student as s left join department as d" .
    " on s.dep_id=d.id left join class as c on s.class_id=c.id";
  $DB->editSql($sql);
  $count = $DB->count();
}

$data = array();
$data['data'] = $DB->limit("$con,$limit")->getAll();

$show = new Page\page($current, $count, $limit, $size);
$data['page'] = $show->page();
echo json_encode($data);
