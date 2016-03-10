<?php
/*==================================
*   Copyright (C) 2015 Baidu.com, Inc. All rights reserved.
*   
*   filename	:changeCamelStyle.php
*   author		:	zhouping01
*   create_time	:2015-01-08
*   desc		:
*
===================================*/

$str = $_SERVER['argv'][1];
$type = $_SERVER['argv'][2];

if(strlen($type)){
	$str = $type."_".$str;
}

if(empty($str)){
	echo "=========\n";
	echo "usage php ".basename(__FILE__)."  abc_def str/int";
	echo "\n=========\n";
	exit();
}
echo camelStyle::run($str);



class camelStyle {

	private static $_arrHumpStyleWhiteList;

	public static function run($str){
		return self::_camelStyle($str);
	}

    //将下划线分隔，改为驼峰
    private static function _camelStyle($str){

		//这些不改驼峰
		if(isset(self::$_arrHumpStyleWhiteList[$str])){
			return $str;
		}
    
        $arr = explode("_",$str);
		//not need change
		if(1 == count($arr)){
			return $str;
		}

        foreach($arr as $key => $val){
            if($key > 0){
                $newArr[] = ucfirst(strtolower($val));
            }else{
                $newArr[] = strtolower($val);
            }
        }        
        $str2 = implode("",$newArr);

        return $str2;
    }


}
