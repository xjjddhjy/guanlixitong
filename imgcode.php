<?php
    // 定义随机输出字符串的函数
    function get_str($length = 1){
        $chars = '1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $size = str_shuffle($chars);// 随机打乱字符串
        $str = substr($size,0,$length);
        return $str;
    }

    $width = 80;
    $height = 35;

    // 创建画布
    $img = imagecreatetruecolor($width,$height);

    // 设置背景色 注意这里必须要rgb模式
    $bgcolor = imagecolorallocate($img,238,238,238);
    // 设置字体颜色 
    $textcolor = imagecolorallocate($img,255,0,0);
    //绘制图片背景,把背景颜色加入图片
    imagefilledrectangle($img,0,0,$width,$height,$bgcolor);
    // 写四个随机数
    $get_code1 = get_str();
    $get_code2 = get_str();
    $get_code3 = get_str();
    $get_code4 = get_str();

    $font = 'texb.ttf';

    imagettftext($img,16,mt_rand(-30,30),1,26,$textcolor,$font,$get_code1);

    imagettftext($img,16,mt_rand(-30,30),20,26,$textcolor,$font,$get_code2);

    imagettftext($img,16,mt_rand(-30,30),40,26,$textcolor,$font,$get_code3);

    imagettftext($img,16,mt_rand(-30,30),60,26,$textcolor,$font,$get_code4);

    for($i=0;$i<10;$i++){
        imagesetpixel($img,mt_rand(0,$width),mt_rand(0,$height),imagecolorallocate($img,mt_rand(0,255),mt_rand(0,255),mt_rand(0,255)));
    }

    for($j=0;$j<5;$j++){
        imageline($img,mt_rand(0,$width),mt_rand(0,$height),mt_rand(0,$width),mt_rand(0,$height),imagecolorallocate($img,mt_rand(0,255),mt_rand(0,255),mt_rand(0,255)));
    }

    session_start();
    $imgcode = $get_code1.$get_code2.$get_code3.$get_code4;
    $_SESSION['imgcode'] = $imgcode;

    header('Content-Type:image/png');
    // 创建一张png的图片
    imagepng($img);