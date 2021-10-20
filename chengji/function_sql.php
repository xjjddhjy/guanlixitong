<?php
    //查询单条,返回一维数组
    //参数$sql 查询的sql语句
    function getone($sql){
        global $conn; //将$conn变成全局变量
        $res=mysqli_query($conn,$sql);
        $data=array();
        if($res && mysqli_num_rows($res)>0){
            $data=mysqli_fetch_assoc($res);
        }
        return $data;
    }

    //查询多条,返回二维数组
    //参数$sql 查询的sql语句
    function getall($sql){
        global $conn;
        $res=mysqli_query($conn,$sql);
        $data=array();
        if($res && mysqli_num_rows($res)>0){
            while($arr=mysqli_fetch_assoc($res)){
                $data[]=$arr;
            }
        }
        return $data;
    }

    //添加
    //参数$tablename 表名
    //参数$data 键值是字段名,值是对应需要添加的值
    function insert($tablename,$data){
        global $conn;
        $field= "(`" . implode('`,`', array_keys($data)) . "`)";
        $column = "('" . implode("','", $data) . "')";
        $sql = "INSERT INTO $tablename $field VALUES $column";
        $res = mysqli_query($conn, $sql);
        if($res){
            $insert_id = mysqli_insert_id($conn);
        }else{
            echo mysqli_error($conn);
            exit;
        }
        return $insert_id;
    }

    //编辑
    //参数$tablename 表名
    //参数$data 键值是字段名,值是对应需要添加的值
    //参数$conditions 条件
    function save($tablename,$data,$conditions){
        global $conn;
        $field = '';
        foreach ($data as $k => $v) {
            $field .= "`$k`='$v',";
        }
        $field = rtrim($field, ',');
        $sql = "UPDATE $tablename SET $field WHERE $conditions";
        $res = mysqli_query($conn, $sql);
        if($res){
            $affect_id = mysqli_affected_rows($conn);
        }else {
            echo mysqli_error($conn);
            exit;
        }
        return $affect_id;
    }

    //删除
    //参数$tablename 表名
    //参数$conditions 条件
    function delete($tablename,$conditions){
        global $conn;
        $sql="DELETE FROM $tablename WHERE $conditions";
        $res=mysqli_query($conn,$sql);
        if($res){
            $affect_id = mysqli_affected_rows($conn);
        }else {
            echo mysqli_error($conn);
            exit;
        }
        return $affect_id;
    }


?>
