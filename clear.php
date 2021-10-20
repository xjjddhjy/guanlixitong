<?php
    setcookie('is_login',1,time()+1);
    echo "<script>window.history.go(-1);</script>";
