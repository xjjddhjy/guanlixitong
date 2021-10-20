<?php
include_once('function.php');
include_once('config_sql.php');
include_once('function_sql.php');
$id = $_GET['id']; // 接收地址栏的id
// $sql = "SELECT * FROM position WHERE id =" . " '$id'";
// $admin = getone($sql);
$admin = $DB->select()->from('subject')->where("id = '$id'")->getOne();
//echo $username;
//var_dump($admin);
$name = $admin['name']; // 原来的
$credit= $admin['credit'];
$teacher= $admin['teacher'];
if ($_POST) {
  $id= $_POST['id'];
  $name = $_POST['name'];
  $credit= $_POST['credit'];
  // 封装数据的数组
  
  $data = [
    'id' => "'$id'",
    'name'=>"'$name'",
    'credit'=>"'$credit'"
  ];
  if($_POST['teacher']){
    $teacher=$_POST['teacher'];
    $data['teacher']="'$teacher'";
  }
  // $res=save('position', $data, "id=$id");
  $res=$DB->save('subject', $data, "id=$id")->query();
  // $res=$DB->save('subject', $data, "id=$id")->getSql();
      // var_dump($res);exit;
  if ($res < 0) {
    show_msg('新增失败'."$res");
  } else {
    show_msg('新增成功'."$res",'',-2);
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <title>admin</title>
  <meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="">
  <meta name="author" content="">

  <link rel="stylesheet" type="text/css" href="../lib/bootstrap/css/bootstrap.css">

  <link rel="stylesheet" type="text/css" href="../stylesheets/theme.css">
  <link rel="stylesheet" href="../lib/font-awesome/css/font-awesome.css">

  <script src="../lib/jquery-1.7.2.min.js" type="text/javascript"></script>
</head>

<body>
  <div class="navbar">
    <div class="navbar-inner">
      <ul class="nav pull-right">
        <li>
          <a href="#" role="button">
            <i class="icon-user"></i><span id="title"></span>
          </a>
        </li>
        <li>
          <a href="../logout.php" class="hidden-phone visible-tablet visible-desktop" role="button">Logout</a>
        </li>
      </ul>
      <a class="brand" href="index.html"><span class="second">Admin</span></a>
    </div>
  </div>

  <div class="sidebar-nav">
    <a href="#dashboard-menu" class="nav-header" data-toggle="collapse"><i class="icon-dashboard"></i>控制面板</a>
    <ul id="dashboard-menu" class="nav nav-list collapse in">
    <li><a href="index.html">首页</a></li>
      <li><a href="../list.html">文章管理</a></li>
      <li><a href="../bumen/list.html">部门管理</a></li>
      <li><a href="../yuangong/list.html">员工管理</a></li>
      <li><a href="list.html">职位管理</a></li>
    </ul>
  </div>

  <div class="content">
    <div class="header">
      <h1 class="page-title">发布文章</h1>
    </div>
    <ul class="breadcrumb">
      <li><a href="../index.html">Home</a> <span class="divider">/</span></li>
      <li class="active">Index</li>
    </ul>

    <div class="container-fluid">
      <div class="row-fluid">

        <div class="btn-toolbar">
          <button class="btn btn-primary" onClick="location='list.html'"><i class="icon-list"></i> 文章列表</button>
          <div class="btn-group">
          </div>
        </div>

        <div class="well">
          <div id="myTabContent" class="tab-content">
            <div class="tab-pane active in" id="home">
              <form id="form" method="POST" enctype="multipart/form-data">
                <label>id</label>
                <input type="text" readonly='readonly'  name="id" id="id" value="<?php echo $id; ?>" class="input-xxlarge">
                <label>科目</label>
                <input type="text" id="name"  name="name" value="<?php echo $name; ?>" class="input-xxlarge">
                <label>学分</label>
                <input type="text" id="credit"  name="credit" value="<?php echo $credit; ?>" class="input-xxlarge">
                <label>老师</label>
                <input type="text" id="teacher"  name="teacher" value="<?php echo $teacher; ?>" class="input-xxlarge">
                <input type="submit" value="提交">
              </form>

            </div>
          </div>
        </div>

        <div class="modal small hide fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h3 id="myModalLabel">Delete Confirmation</h3>
          </div>
          <div class="modal-body">

            <p class="error-text"><i class="icon-warning-sign modal-icon"></i>Are you sure you want to delete the user?
            </p>
          </div>
          <div class="modal-footer">
            <button class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button>
            <button class="btn btn-danger" data-dismiss="modal">Delete</button>
          </div>
        </div>

        <footer>
          <hr>
          <p>&copy; 2017 <a href="#" target="_blank">copyright</a></p>
        </footer>

      </div>
    </div>
  </div>

  <script src="../lib/bootstrap/js/bootstrap.js"></script>
  <script type="text/javascript">
    $("[rel=tooltip]").tooltip();
    $(function() {
      $('.demo-cancel-click').click(function() {
        return false;
      });
    });

    function post(url, data, callback) {
      const xhr = new XMLHttpRequest();
      xhr.open('post', url);
      xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
      xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
          callback(xhr.responseText);
          // if (xhr.responseText == '登录成功') {
          //   alert('登录成功！'); location.href = 'index.html';
          // }
          //console.log(xhr.responseText);
          //console.log(JSON.parse(xhr.responseText));
          //return xhr.responseText;
        }
      }
      xhr.send(data);
    }
    post('getsession.php', '', function(f) {
      $('#title').html(f);
    })
    // $('#submit').click(function() {
    //       post('bianji.php', 'username=' + $('#username').val() +
    //         '&&' + 'pwd=' + $('#pwd').val() + '&&' +
    //         'img=' + $('#file').val(),
    //         function(f) {
    //           $('#title').html(f);
    //         }
    //       )
    //       $.ajax({
    //         type: 'post',
    //         url: 'bianji.php',
    //         data: new FormData($('#form')[0]),
    //         // 配置processData为false相当于配置表单中enctype="multipart/form-data"
    //         // 如果不配置,ajax则会以默认的enctype="application/x-www-form-urlencoded"方式提交
    //         processData: false,
    //         // contentType正常应该是一个字符串,如'text/html'
    //         // 此处给false的原因是告诉ajax,不需要ajax进行处理和干预
    //         contentType: false,
    //         // 以上两个属性只有在上传文件的时候需要配置
    //         // 省略...
    //       })
    //     })
    

  </script>

</body>

</html>