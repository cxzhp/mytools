<?php
/*==================================
*   Copyright (C) 2014 Baidu.com, Inc. All rights reserved.
*   
*   filename	:getprobuf.php
*   author		:	zhouping01
*   create_time	:2014-10-07
*   desc		:
*
===================================*/

if($argc < 3){
	echo 'usage: php '.basename(__FILE__).' $idl_file $new_dir_name';
	echo "\n";
	echo 'sample: php '.basename(__FILE__).' tmp/clientidl/mocuser/game/getgamecategorydetail.idl getGameCategoryDetail';
	echo "\n";
	echo  '$idl_file: '.mb_convert_encoding('idl文件的绝对路径','gbk','utf-8');
	echo "\n";
	die("bye\n");
}
include_once(dirname(__FILE__).'/getVarFromIdl.class.php');

$idl_file = $argv[1];
$package_name = $argv[2];//$new_dir_name

if(!file_exists($idl_file)){
	echo 'err. idl_file:'.$idl_file.' is not exsits.';
	echo 'sample: php '.basename(__FILE__).' tmp/clientidl/mocuser/game/getgamecategorydetail.idl getGameCategoryDetail';
	echo "\n";
	exit;
}


if(empty($package_name)){
	echo 'err. pls give packName:'.$package_name.' is not exsits.';
	echo 'sample: php '.basename(__FILE__).' tmp/clientidl/mocuser/game/getgamecategorydetail.idl getGameCategoryDetail';
	echo "\n";
	exit;
}

//get need vars from idl
///////////////////////////////////////////////////////////////
$handle = fopen($idl_file, "r");
$i = 0;
while (!feof($handle)) {
	$i++;
	if($i >9){
		break;
	}
    $strLine = fgets($handle, 4096);
    $strLine = str_replace(array("\n","\r"), array("",""),$strLine);
	getVarFromIdl::getNeedVars($strLine);

}
fclose($handle);

$arr =  getVarFromIdl::getVars();
$desc 			= $arr['desc'];
$cmd 			= $arr['cmd'];
$author 		= $arr['author'];
$url 			= $arr['url'];

if(empty($url)){
	echo 'pls set like "@url: c/f/frs/page" in idl file"';
	echo "\n";
	exit;
}

if(empty($cmd)){
	echo 'pls add cmd like "@description:xxxxxxxxxxx cmd:111111" in idl file"';
	echo "\n";
	exit;
}

include_once(dirname(__FILE__)."/getprobuf.exec.php");
