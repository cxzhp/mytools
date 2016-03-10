<?php
/*==================================
*   Copyright (C) 2014 Baidu.com, Inc. All rights reserved.
*   
*   filename	:init_codes.php
*   author		:	zhouping01
*   create_time	:2014-10-06
*   desc		:
*
===================================*/

if($argc < 2){
	echo 'usage: php '.basename(__FILE__).' $new_codes_dir $module_name $action_path';
	echo "\n";
	echo 'sample: php '.basename(__FILE__).' game client-commit actions/game';
	echo "\n";
	die("bye\n");
}



$new_codes_dir = $argv[1];
$module_name = $argv[2];
$action_path = $argv[3];
$action_path = str_replace('actions/','',$action_path);
init_codes($new_codes_dir,$module_name,$action_path);

function init_codes($new_codes_dir,$module_name,$action_path){

	system("mkdir -p $new_codes_dir/app/$module_name/actions/$action_path");
	#system("mkdir -p $new_codes_dir/app/$module_name/actions/$action_path/logic");
	system("mkdir -p $new_codes_dir/conf/app/$module_name/$action_path");
	system("mkdir -p $new_codes_dir/data/app/$module_name/$action_path");

	system("cp ".dirname(__FILE__)."/../codes_restore/build.sh  $new_codes_dir/");
	echo 'init codes success!'."\n";
	echo 'new_codes_dir:'.$new_codes_dir."\n";
}
