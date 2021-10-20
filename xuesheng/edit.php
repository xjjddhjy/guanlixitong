<?php
include_once('function.php');
include_once('config_sql.php');
include_once('function_sql.php');
$id = $_GET['id']; // 接收地址栏的id
$sql = "SELECT s.*,d.name as 'dname',c.name as 'cname'" .
" from (select * from student where id='$id') as s left join department as d" .
" on s.dep_id=d.id left join class as c on s.class_id=c.id";
$admin=$DB->editSql($sql)->getOne();
// $res = mysqli_query($conn, $sql);
// $admin = array();
// if ($res && mysqli_num_rows($res) > 0) {
//   $admin = mysqli_fetch_assoc($res);
// }

$name = $admin['name'];
$dname = $admin['dname'];
$jname = $admin['cname'];
$sex = $admin['sex'];
// $mobile = $admin['mobile'];
// $address = $admin['address'];
$avatar = $admin['avatar'];
// $email = $admin['email'];
if ($_POST) {

  $id = $_POST['id'];
  $dep_id = $_POST['dep_id'];
  $name ="'". $_POST['name']."'";
  $sex ="'". $_POST['sex']."'";
  $class_id = $_POST['class_id'];
  $mobile = $_POST['mobile'];
  $address = "'".$_POST['address']."'";
  $email ="'". $_POST['email']."'";
  $createtime = $_POST['createtime'];

  $sql = "SELECT * FROM department WHERE name =" . " '$dep_id'";
  $admin=$DB->editSql($sql)->getOne();
  $dep_id = $admin['id'];

  $sql = "SELECT * FROM class WHERE name =" . " '$class_id'";
  $admin=$DB->editSql($sql)->getOne();
  $class_id = $admin['id'];

  $file = 'upload';
  if (!is_dir($file)) {
    mkdir($file);
  }
  $result = upload('avatar', $file);
  $arr = explode(',', $result);
  // 封装数据的数组
  $data = [
    'dep_id' => $dep_id,
    'name' => $name,
    'class_id' => $class_id,
    'sex' => $sex,
    'id' => $id,
    // 'mobile' => $mobile,
    // 'address' => $address,
    // 'email' => $email,
    // 'createtime' => $createtime,
  ];
  if ($arr[0] == '图片上传成功') {
    $data['avatar'] = "'$arr[1]'";
    if(isset($avatar)){
      unlink($avatar);
    }
  } else {
    show_msg($arr[0]);
  }

  // var_dump($data);exit;
  // $res = save('staff', $data, "id=$id");
  // $res=$DB->save('student', $data, "id=$id")->getSql();
  $res=$DB->save('student', $data, "id=$id")->query();
  // var_dump($res);exit;
  if ($res < 0) {
    show_msg('修改失败'."$res");
  } else {
    show_msg('修改成功'."$res", '', -2);
  }
  // if (!isset($dep_id) &&  !isset($name) && isset($id)) {
  //   $sql = "SELECT * FROM staff WHERE id =" . " '$id'";
  //   $admin = getone($sql);
  //   if (!$admin) {
  //     echo 'id不存在';
  //     exit;
  //   } else {
  //     echo 'id存在ok';
  //   }
  // }
  // if (isset($dep_id) &&  !isset($name) && !isset($name)) {
  //   $sql = "SELECT * FROM department WHERE name =" . " '$dep_id'";
  //   $admin = getone($sql);
  //   if ($admin) {
  //     echo 'dep存在,ok';
  //     exit;
  //   } else {
  //     echo 'dep不存在';
  //     exit;
  //   }
  // }
  // if (!isset($dep_id) &&  isset($class_id) && !isset($id)) {
  //   $sql = "SELECT * FROM position WHERE name =" . " '$class_id'";
  //   $admin = getone($sql);
  //   if ($admin) {
  //     echo 'job存在,ok';
  //     exit;
  //   } else {
  //     echo 'job不存在';
  //     exit;
  //   }
  // }
  // if (isset($dep_id) &&  isset($name) &&  isset($class_id) &&  isset($id) &&  isset($sex)) {
  //   if (isset($id)) {
  //     $sql = "SELECT * FROM staff WHERE id =" . " '$id'";
  //     $admin = getone($sql);
  //     if (!$admin) {
  //       echo 'id不存在';
  //       exit;
  //     } else {
  //     }
  //   }
  //   $sql = "SELECT * FROM department WHERE name =" . " '$dep_id'";
  //   $admin = getone($sql);
  //   if ($admin) {
  //     $dep_id = $admin['dep_id'];
  //   } else {
  //     echo 'dep不存在';
  //     exit;
  //   }

  //   $sql = "SELECT * FROM position WHERE name =" . " '$class_id'";
  //   $admin = getone($sql);
  //   if ($admin) {
  //     $class_id = $admin['class_id'];
  //   } else {
  //     echo 'job不存在';
  //     exit;
  //   }

  // $f=fopen('1.txt','w+');
  // fwrite($f,json_encode($data));
  // fclose($f);
  // echo $data;

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
      <li><a href="../list.html">文章管理</a></li>
      <li><a href="list.html">部门管理</a></li>
      <li><a href="../yuangong/list.html">员工管理</a></li>
      <li><a href="../zhiwei/list.html">职位管理</a></li>
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
              <form id="form" method="post" enctype="multipart/form-data">
                <label>id</label><span id="idcontent"></span>
                <input type="text" readonly name="id" id="id" value="<?php echo $id; ?>" class="input-xxlarge">
                <label>姓名</label><span id="namecontent"></span>
                <input type="text" id="name" name="name" value="<?php echo $name; ?>" class="input-xxlarge">
                <label>部门</label><span id="dep_idcontent"></span>
                <select id="dep_id" name="dep_id">

                </select>
                <label>职位</label><span id="class_idcontent"></span>
                <select id="class_id" name="class_id">

                </select> 
                <label for="sex">性别</label>
                <select id="sex" name="sex">
                  <option value="1" <?php
                                    if ($sex == '男') {
                                      echo 'selected';
                                    }
                                    ?>>男</option>
                  <option value="2" <?php
                                    if ($sex == '女') {
                                      echo 'selected';
                                    }
                                    ?>>女</option>
                </select>
                <!-- <label>手机</label><span id="dep_idcontent"></span>
                <input type="text" id="mobile" name="mobile" value="<?php echo $mobile; ?>" class="input-xxlarge">

                <label>邮箱</label><span id="dep_idcontent"></span>
                <input type="text" id="email" name="email" value="<?php echo $email; ?>" class="input-xxlarge">

                <label>地址</label><span id="dep_idcontent"></span>
                <input type="text" id="address" name="address" value="<?php echo $address; ?>" class="input-xxlarge"> -->

                <label>头像</label>
                <input id="avatar" type="file" name="avatar">
                <label for="avatar" style="margin-bottom:0;">
                  <?php if ($avatar) { ?>
                    <img src="<?php echo $avatar; ?>" alt="" id="img" />
                  <?php } else { ?>
                    <img src="upload.png" alt="" id="img" />
                  <?php } ?>
                </label>
                <!-- <label>创建时间</label><span id="dep_idcontent"></span>
                <input type="text" id="createtime" name="createtime" value="<?php echo $avatar; ?>" class="input-xxlarge"> -->

                <label></label>
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
    // $('#dep_id').blur(function() {
    //   if ($('#dep_id').val() != '') {
    //     post('edit.php', 'dep_id=' + $('#dep_id').val(), function(f) {
    //       $('#dep_idcontent').html(f);
    //     })
    //   }
    // })
    // $('#class_id').blur(function() {
    //   if ($('#class_id').val() != '') {
    //     post('edit.php', 'class_id=' + $('#class_id').val(), function(f) {
    //       $('#class_idcontent').html(f);
    //     })
    //   }
    // })
    post('getsession.php', '', function(f) {
      $('#title').html(f);
    })
    post('getbanjixibu.php',
      '',
      function(f) {
        f = JSON.parse(f);
        console.log(f);
        let s1 = '';
        let s2 = '';
        for (let i of f[0]) {
          if (i.name == '<?php echo $dname ?>') {
            s1 += `<option selected value='${i.name}'>${i.name}</option>`;
            continue;
          }
          s1 += `<option value='${i.name}'>${i.name}</option>`;
        }
        for (let i of f[1]) {
          if (i.name == '<?php echo $cname ?>') {
            s2 += `<option selected value='${i.name}'>${i.name}</option>`;
            continue;
          }
          s2 += `<option value='${i.name}'>${i.name}</option>`;
        }
        $('#dep_id').html(
          s1
        )
        $('#class_id').html(
          s2
        )
      }
    )
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