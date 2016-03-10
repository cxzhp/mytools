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

$sub_action_path = str_replace('actions/','',$action_path);
init_codes($new_codes_dir,$module_name,$sub_action_path);

function init_codes($new_codes_dir,$module_name,$sub_action_path){

	system("mkdir -p $new_codes_dir/app/$module_name/actions/$sub_action_path");
	#system("mkdir -p $new_codes_dir/app/$module_name/actions/$sub_action_path/logic");
	system("mkdir -p $new_codes_dir/conf/app/$module_name/$sub_action_path");
	system("mkdir -p $new_codes_dir/data/app/$module_name/$sub_action_path");

	system("cp ".dirname(__FILE__)."/../codes_restore/build.sh  $new_codes_dir/");
	//echo 'init codes success!'."\n";
	//echo 'new_codes_dir:'.$new_codes_dir."\n";
}
