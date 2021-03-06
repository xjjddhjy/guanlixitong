<?php
include_once('function.php');
include_once('config_sql.php');
include_once('function_sql.php');
$id = $_GET['id']; // 接收地址栏的id
// $sql = "SELECT * FROM houtaiguanli WHERE id =" . " '$id'";
// $admin = getone($sql);
$admin=$DB->select()->from('administrator')->where("id = '$id'")->getOne();
//echo $username;
//var_dump($admin);
// $createtime = $admin['createtime']; // 原来的注册时间
$avatar = $admin['avatar']; // 拿到原来的图片名
$pwd = $admin['password'];
$username = $admin['username'];
$salt = $admin['salt'];

if ($_POST) {
  // 创建一个存放上传图片的文件夹
  $file = 'upload';
  if (!is_dir($file)) {
    mkdir($file);
  }
  $result = upload('avatar', $file);
  $arr = explode(',', $result);
  $pwd = $_POST['pwd'];
  $username = $_POST['username'];
  $salt=get_str(4);
  $password=md5($pwd.$salt);
  // 封装数据的数组
  $data = [
    'id'=>$id,
      'username' => "'$username'",
      'password' => "'$password'",
      'salt' => "'$salt'",
    
  ];
  if ($arr[0] == '图片上传成功') {
    $data['avatar'] = "'$arr[1]'";
    if(!empty($avatar)){
      @unlink($avatar);
    }
     
  } else {
    show_msg($arr[0]);
  }
  // var_dump($data);exit;
  // $res=save('houtaiguanli', $data, "id=$id");
  $res=$DB->save('administrator', $data, "id=$id")->query();
// var_dump($res);exit;
  if ($res < 0) {
    show_msg('新增失败'.json_encode($res));
  } else {
    show_msg('新增成功','',-2);
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

  <link rel="stylesheet" type="text/css" href="lib/bootstrap/css/bootstrap.css">

  <link rel="stylesheet" type="text/css" href="stylesheets/theme.css">
  <link rel="stylesheet" href="lib/font-awesome/css/font-awesome.css">

  <script src="lib/jquery-1.7.2.min.js" type="text/javascript"></script>
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
          <a href="#" class="hidden-phone visible-tablet visible-desktop" role="button">Logout</a>
        </li>
      </ul>
      <a class="brand" href="index.html"><span class="second">Admin</span></a>
    </div>
  </div>

  <div class="sidebar-nav">
    <a href="#dashboard-menu" class="nav-header" data-toggle="collapse"><i class="icon-dashboard"></i>控制面板</a>
    <ul id="dashboard-menu" class="nav nav-list collapse in">
      <li><a href="index.html">首页</a></li>
      <li><a href="list.html">文章管理</a></li>
    </ul>
  </div>

  <div class="content">
    <div class="header">
      <h1 class="page-title">发布文章</h1>
    </div>
    <ul class="breadcrumb">
      <li><a href="index.html">Home</a> <span class="divider">/</span></li>
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
                <label>用户名</label>
                <input type="text" readonly="readonly" name="username" id="username" value="<?php echo $username; ?>" class="input-xxlarge">
                <label>密码</label>
                <input type="password" id="pwd"  name="pwd" value="<?php echo $pwd; ?>" class="input-xxlarge">
                <label>头像</label>
                <input id="avatar" type="file" name="avatar">
                <label for="avatar" style="margin-bottom:0;">
                  <?php if ($avatar) { ?>
                    <img src="<?php echo $avatar; ?>" alt="" id="img" />
                  <?php } else { ?>
                    <img src="upload.png" alt="" id="img" />
                  <?php } ?>
                </label>
                <input class="btn btn-primary" type="submit" id="submit" value="提交" />
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

  <script src="lib/bootstrap/js/bootstrap.js"></script>
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
    post('getsession.php', '', function(f) {
      $('#title').html(f);
    })
    function getObjectURL(file) {
        var url = null;
        if (window.createObjectURL != undefined) { // basic
            url = window.createObjectURL(file);
        } else if (window.URL != undefined) { // mozilla(firefox)
            url = window.URL.createObjectURL(file);
        } else if (window.webkitURL != undefined) { // webkit or chrome
            url = window.webkitURL.createObjectURL(file);
        }
        return url;
    }
    // 当id为upload选中事件
    $('#avatar').change(function() {
        var url = getObjectURL(this.files[0]);
        if (url) {
            $('#img').attr('src', url);
        }
    });
  </script>

</body>

</html>