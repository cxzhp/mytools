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


$strRootPath	=	dirname(__FILE__).'/';
include_once($strRootPath.'getcodes.class.php');


$strToolsPath = $strRootPath;
$strTmpDataPath = $strRootPath.'/tmpdata/app/easywireless/';
system('mkdir -p '.$strTmpDataPath);


//idl to array -----//
/////////////////////////////////////////////////

$strTmpDataFileName = basename($idl_file,'.idl').'.json';
$strCmd = $strToolsPath.'/mcy --idl-json --language idl '.$idl_file.' > '.$strTmpDataPath.'/'.$strTmpDataFileName;
echo $strCmd."\n";
system($strCmd);

$strJsonFile = $strTmpDataPath.'/'.$strTmpDataFileName;
$strIdljson = trim(file_get_contents($strJsonFile));
$strIdljson = str_replace("'", '"',$strIdljson);
$strIdljson = preg_replace('/,\s*([\]}])/m', '$1',$strIdljson);
        
//var_dump($strJsonFile,$strIdljson,__FILE__,__LINE__);
$arrJson = json_decode($strIdljson,true);
/////////////////////////////////////////////////


//get structs from idl array
////////////////////////////////////////////////
foreach($arrJson['structs']  as $key => $val){
	if('struct' == $val['type']){
		$arrStructs[$val['name']]	 = $val['children'];
	}

}

if(3 == $cmd[0] || empty($cmd)){
		//pass
		//not need "force camel style"
}else{
	if(false == generateCodes::checkStructs($arrStructs)){
		echo generateCodes::getErrMsg();
		exit();
	}
	//var_dump($arrStructs,__FILE__,__LINE__);
}
////////////////////////////////////////////////


//generateCodes
////////////////////////////////////////////////
$strContentUi = generateCodes::getCodesUiAction($action_name,$module_name,$author,$arrStructs,$strRootPath.'../tpl/','uiAction.php',$service_name,$method_name);
$action_file_name = strtolower($action_name).'Action.php';
$dest_file_name = $new_codes_dir.'/app/'.$module_name."/".$action_path."/".$action_file_name;
file_put_contents($dest_file_name,$strContentUi);


$arrInterfaceUrlTmp = explode("/",$url);
$arrInterfaceUrl = array_pop($arrInterfaceUrlTmp);
$strInterfaceUrl = implode("/",$arrInterfaceUrlTmp)."/". strtolower($action_name);
$strInterfaceCode = "'/".implode("/",$arrInterfaceUrlTmp)."/". strtolower($action_name)."',";

if('cq01-rdqa-dev010.cq01.baidu.com' == $_SERVER['HOSTNAME']){
	$strHostName = 'HOST';
}else{
	$strHostName = $_SERVER['HOSTNAME'];
}
$strTestUrl = $strHostName.":8080/".$strInterfaceUrl."?sign=123456tbclient654321&";
foreach(generateCodes::$arrTestReqParams as $key => $val){
	$strTestUrl .= $key.'='.$val.'&';
}

if(strlen($_SERVER['PWD'])>0){
	$strPwd = $_SERVER['PWD']."/";
}

echo '1. generate files:'."\n";
echo $strPwd.$dest_file_name;
echo "\n";
echo "\n";
echo "2. test url:\n";
echo "http://".$strTestUrl;
echo "\n";
echo "\n";
echo "3. pls add codes to webroot/client/DoneUrl.php:\n";
echo $strInterfaceCode;
echo "\n";
echo "4. lcc:\n";
echo $cmd.' '.json_encode(array('data'=>generateCodes::$arrTestReqParams));
echo "\n";
////////////////////////////////////////////////
