<?php
	// 分页函数
	// function get_url(){
	// 	$str=$_SERVER['PHP_SELF'].'?';// 可以获取地址但是不包含参数
	// 	// 解决参数
	// 	foreach($_GET as $k=>$v){
	// 		$str.="$k=$v&";
	// 	}
	// 	return $str;
	// }
	// // echo get_url();
	// function page($current,$count,$limit,$size,$class='digg'){
	// 	$str='';
	// 	if($count>$limit){// 数据总数大于每页显示的数据才会有分页
	// 		$pages=ceil($count/$limit);// ceil向上取整
	// 		$url=get_url();// 当前页的URL包含参数
	// 		$str.='<div class="'.$class.'">';
	// 		// 第一种情况，只有首页和上一页
	// 		if($current!=1){
	// 			$str.='<a href="'.$url.'page=1">首页</a>';
	// 			$str.='<a href="'.$url.'page='.($current-1).'">上一页</a>';
	// 		}
	// 		// 第二种情况，同时有首页、尾页、上一页、下一页
	// 		if($current<ceil($size/2)){// 1 当前页在中间左侧
	// 			$start=1;
	// 			$end=$pages<$size?$pages:$size;// 谁小循环到谁为止
	// 		}else if($current-floor($size/2)){// 2 当前页在中间右侧
	// 			$start=$pages-$size+1<=0?1:$pages-$size+1;
	// 			$end=$pages;
	// 		}else{// 3 当前页在中间位置
	// 			$start=$current-floor($size/2);
	// 			$end=$current+floor($size/2);
	// 		}
	// 		// 使用for循环将页码循环出来
	// 		for($i=$start;$i<$end;$i++){
	// 			if($i==$current){//判断当前页的情况
	// 				$str.='<span class="current">'.$i.'</span>';
	// 			}else{
	// 				$str.='<a href="'.$url.'page='.$i.'">'.$i.'</a>';
	// 			}
	// 		}
	// 		// 第三种情况，只有尾页和下一页
	// 		if($current!=$pages){
	// 			$str.='<a href="'.$url.'page='.($current+1).'">尾页</a>';
	// 			$str.='<a href="'.$url.'page='.$pages.'">下一页</a>';
	// 		}
	// 		$str.='</div>';
	// 	}
	// 	return $str;
	// }
	// 分页函数
	/*
		1、当前页码
		2、共显示多少个页面,当前页码显示在中间位置（查询数据表的数据总数）
		3、当前页码在地址栏通过参数传递
		
		核心： 当前页
		获取当前的地址栏包括参数
		adminlist.php?page=5
		<a href="index.php?page=5">5</a>
		<a href="index.php?page=6">6</a>
		LIMIT
		当前页$current
		每页显示$limit条数据
		SELECT * FROM student LIMIT ($current-1)*$limit,$limit
		//如果地址栏还有别的参数
		index.php?id=10
		index.php?id=10&page=6
		index.php?page=6&page=6
		index.php?id=10&page=6
	*/
    /*
		当前页显示在中间
		[]当前页
		一共有10页(总页数)
		中间显示5页
		第一页： [1]  2   3   4   5
		第二页：  1  [2]  3   4   5
		第三页：  1   2  [3]  4   5
		第四页：  2   3  [4]  5   6
		第五页：  3   4  [5]  6   7
		第六页：  4   5  [6]  7   8
		第七页：  5   6  [7]  8   9
		第八页：  6   7  [8]  9   10
		第九页：  6   7   8  [9]  10
		第十页：  6   7   8   9  [10]
		第十一页：7 8 9 [10] 11
	*/
	// 获取当前
	function get_url(){
		$str=$_SERVER['PHP_SELF'].'?';
		foreach ($_GET as $k=> $v) {
			if($k!='page'){
				$str.="$k=$v&";
			}
		}
		// echo $str;die;
		return $str;
	}
	// print_r($_GET);
	// echo get_url();
	// 分页函数
	// 参数$current,当前页
	// 参数$count,总资源数
	// 参数$limit,每一页查询多少条
	// 参数$size,显示的页码数
	function page($current,$count,$limit,$size,$class="digg"){
		$str='';
		if($count>$limit){
			$pages=ceil($count/$limit);
			$url=get_url();
			$str.='<div class="'.$class.'">';
			// 第一种情况，只有首页和上一页
			
			if($current!=1){
				$str.='<a href="'.$url.'page=1">首页</a>';
				$str.='<a href="'.$url.'page='.($current-1).'">上一页</a>';
			}
			// 第二种情况
			if($current<ceil($size/2)){// 1、当前页在中间的左侧
				$start=1;
				$end=$pages<$size?$pages:$size; //谁小循环到谁为止
			}elseif($current>$pages-floor($size/2)){ //当前页在中间的右侧
				$start=$pages-$size+1<=0?1:$pages-$size+1;
				$end=$pages;
			}else{ //当前页在中间
				$start=$current-floor($size/2);
				$end=$current+floor($size/2);
			}
			// 使用for循环将页码循环出来
			for($i=$start;$i<=$end;$i++){
				if($i==$current){ //判断当前页的情况
					$str.='<span class="current">'.$i.'</span>';
				}else{
					$str.='<a href="'.$url.'page='.$i.'">'.$i.'</a>';
				}
			}

			// 第三种情况，只有尾页和下一页
			if($current!=$pages){
				// '<a href="'.$url.'"></a>'
				$str.='<a href="'.$url.'page='.($current+1).'">下一页</a>';
				$str.='<a href="'.$url.'page='.$pages.'">尾页</a>';
				// $str.='<a href="'.$url.'page=1">首页</a>';
			}


			$str.='</div>';
		}
		return $str;
	}
?>