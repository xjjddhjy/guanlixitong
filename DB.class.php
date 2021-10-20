<?php

namespace DB;

class DB
{
  private $host; // 连接的主机  localhost
  private $username; // 数据库使用的用户名
  private $password; // 数据库使用的密码
  private $dbname;   // 数据库名
  private $conn;     // 把mysql连接返回的信息储存到这里
  private $sql;      // sql语句
  private $dbprefix; // 表前缀

  public function __construct($host, $username, $password, $dbname, $dbprefix = '')
  {
    $this->host = $host;
    $this->username = $username;
    $this->password = $password;
    $this->dbname = $dbname;
    $this->dbprefix = $dbprefix;
    $this->connect();
  }

  private function connect()
  {
    // 数据库配置
    $this->conn = mysqli_connect($this->host, $this->username, $this->password, $this->dbname);

    // 如果数据库连接不成功
    if (!$this->conn) {
      echo '网站正在升级';
      exit;
    }

    //设置编码
    mysqli_set_charset($this->conn, 'utf8');
  }

  // 查询字段  默认查询所有的数据
  public function select($field = '*')
  {
    $this->sql = "SELECT $field ";
    return $this;
  }
  // 查询的表名
  public function from($table)
  {
    // FROM `pre_person`
    $this->sql .= "FROM `{$this->dbprefix}$table`";
    return $this;
  }
  // 连表
  /* 
            $join_table  从表
            $on  外键
            $join 连表类型
        */
  public function join($join_table, $on, $join = 'LEFT')
  {
    // from pre_person left join pre_job as j
    $this->sql .= " $join JOIN {$this->dbprefix}$join_table ON $on";
    return $this;
  }
  /* 
            条件
        */
  public function where($conditions)
  {
    // WHERE `id` = '1'
    $this->sql .= " WHERE $conditions";
    return $this;
  }
  // 分组去重
  public function group($group)
  {
    $this->sql .= " GROUP BY $group";
    return $this;
  }
  // 排序
  public function order($order)
  {
    $this->sql .= " ORDER BY $order";
    return $this;
  }
  // 查询条数
  public function limit($limit1,$limit2=0)
  {
    if(func_num_args()==1){
      $this->sql .= " LIMIT $limit1";
    }else{
      $this->sql .= " LIMIT $limit1,$limit2";
    }
    
    return $this;
  }
  // 查询总数
  public function count()
  {
    $res = mysqli_query($this->conn, $this->sql);
    if ($res && mysqli_num_rows($res) > 0) {
      return mysqli_num_rows($res);
    } else {
      return 0;
    }
  }
  // 查询所有的数据
  public function getAll()
  {
    $res = mysqli_query($this->conn, $this->sql);
    //定义新的数组存放查询的数据
    $data = [];
    // 判断语句执行并且返回的行数必须要大于0时才会执行代码
    if ($res && mysqli_num_rows($res) > 0) {
      // 把返回的二维数组赋值给$data
      $data = mysqli_fetch_all($res, MYSQLI_ASSOC);
    }
    return $data;
  }
  // 查询单条数据
  public function getOne()
  {
    $res = mysqli_query($this->conn, $this->sql);
    $data = [];
    if ($res && mysqli_num_rows($res) > 0) {
      $data = mysqli_fetch_assoc($res);
    }
    return $data;
  }
  // 新增
  public function insert($table, $data)
  {
    // 封装SQL语句
    $this->sql = "INSERT INTO `{$this->dbprefix}$table`";
    // 获取$data里键值作为字段
    $this->sql .= "(`" . implode('`,`', array_keys($data)) . "`)VALUES";
    // 获取$data里的值作为数据
    $this->sql .= "('" . implode("','", $data) . "')";

    return $this;
  }
  // 修改
  public function save($table, $data, $conditions)
  {
    $this->sql = "UPDATE `{$this->dbprefix}$table` SET";
    foreach ($data as $key => $v) {
      $this->sql .= "`$key` = $v,";
    }
    $this->sql = trim($this->sql, ',');
    $this->sql .= " WHERE $conditions";
    return $this;
  }
  //删除
  public function delete($table, $conditions)
  {
    $this->sql = "DELETE FROM {$this->dbprefix}$table WHERE $conditions";
    return $this;
  }
  // 执行SQL语句
  public function query()
  {
    $res = mysqli_query($this->conn, $this->sql);
    // if($res)
    // {
    //     return $res;
    // }else {
    //     return mysqli_error($this->conn);
    // }
    // if($res && mysqli_num_rows($res) > 0){
    //     $data = mysqli_fetch_assoc($res);
    // }
    // return $data;
    // if ($res) {
      // $affect_rows =@mysqli_num_rows($res);
      $affect_rows = @mysqli_affected_rows($this->conn);
    // }
    return $affect_rows;
  }
  //查看原生SQL语句,目的是为了排除bug
  public function getSql()
  {
    return $this->sql;
  }
  public function editSql($a)
  {
    $this->sql=$a;
    return $this;
  }
}
