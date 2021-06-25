<?php
// 这是系统自动生成的公共文件

function tree($data,$pid=0,$level=0){

		static $arr = [];
		foreach($data as $k=>$v){
			if($v['pid']==$pid){
				$v['cat_name'] = str_repeat('|----',$level).$v['cat_name'];
				$arr[] = $v;
				unset($data[$k]);
				tree($data,$v['id'],$level+1);
			}
		}
		return $arr;
		
	}
