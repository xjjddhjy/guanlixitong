<?php
var_dump($_FILES);
// array(1) {
//   ["file"]=>
//   array(5) {
//     ["name"]=>
//     string(27) "58CWDAD288NUKI5V)(UF`7S.png"
//     ["type"]=>
//     string(9) "image/png"
//     ["tmp_name"]=>
//     string(22) "C:\Windows\php6092.tmp"
//     ["error"]=>
//     int(0)
//     ["size"]=>
//     int(23049)
//   }
// }
move_uploaded_file($_FILES['file']['tmp_name'], 'upload' . '/' . $_FILES['file']['name']);