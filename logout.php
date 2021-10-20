<?php
    session_start();
    $_SESSION['username'] =  '';
    include_once('function.php');
    setcookie('username','',time()-1);
    setcookie('lasttime','',time()-1);
    setcookie('is_login',1,time()-1);
    unset($_COOKIE['is_login']);
    show_msg('退出成功！','login.html');