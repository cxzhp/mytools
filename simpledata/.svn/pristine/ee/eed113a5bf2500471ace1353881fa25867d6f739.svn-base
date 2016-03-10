<?php
/*==================================
*   Copyright (C) 2014 Baidu.com, Inc. All rights reserved.
*   
*   filename	:	getcodes.php
*   author		:	zhouping01
*   create_time	:2014-10-03
*   desc		:
*
===================================*/
if($argc < 2){
	echo 'usage: php '.basename(__FILE__).' $idl_file $service_name $method_name';
	echo "\n";
	echo 'sample: php '.basename(__FILE__).' tmp/clientidl/moccommit/game/updatetimes.idl game setDownload';
	echo "\n";
	echo  '$idl_file: '.mb_convert_encoding('idl文件的绝对路径','gbk','utf-8');
	echo "\n";
	die("bye\n");
}


$idl_file = $argv[1];
if(!file_exists($idl_file)){
	echo 'err. idl_file:'.$idl_file.' is not exsits.';
	echo "\n";
	exit;
}


include_once(dirname(__FILE__).'/getVarFromIdl.class.php');
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
$module_name	= $arr['module_name'];
$action_path	= $arr['action_path'];
$action_name	= $arr['action_name'];
$new_codes_dir	= $arr['new_codes_dir'];
$url 			= $arr['url'];

if(empty($author)){
	echo 'pls set "@author:xxx" in idl file"';
	echo "\n";
	exit;
}

if(empty($module_name) || empty($action_path) || empty($action_name) || empty($new_codes_dir)){
	echo 'pls set like "@url: c/f/frs/page" in idl file"';
	echo "\n";
	echo 'module_name:'.$module_name."\n";
	echo 'action_path:'.$action_path."\n";
	echo 'action_name:'.$action_name."\n";
	echo 'new_codes_dir:'.$new_codes_dir."\n";
	exit;
}

$service_name 		= $argv[2];
$method_name		= $argv[3];


include_once(dirname(__FILE__).'/init_codes.php');
include_once(dirname(__FILE__).'/getcodes.exec.php');
