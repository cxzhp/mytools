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

$strRootPath	=	dirname(__FILE__).'/';

include_once($strRootPath."getprobuf.class.php");

$strToolsPath = $strRootPath;
$strTmpDataPath = $strRootPath.'/tmpdata/app/easywireless/';
system('mkdir -p '.$strTmpDataPath);

if(!file_exists($idl_file)){
	echo 'err. idl_file:'.$idl_file.' is not exsits.';
	exit;
}



//----- idl to array//
///////////////////////////////////////////////////////
$strTmpDataFileName = basename($idl_file,'.idl').'.json';
$strCmd = $strToolsPath.'/mcy --idl-json --language idl '.$idl_file.' > '.$strTmpDataPath.'/'.$strTmpDataFileName;
//var_dump($strCmd,__FILE__,__LINE__);
system($strCmd);


$strPackageName = ucfirst($package_name);
$lowerFirstPackageName = strtolower(substr($strPackageName,0,1)).substr($strPackageName,1);
$new_codes_dir = $lowerFirstPackageName;

$strDesc = mb_convert_encoding($desc,'utf-8','gbk');
$strCmd = $cmd;

if('/' != $url{0}){
	$url =  '/'.$url;
}
$strUrl = $url;

system("mkdir -p ".$new_codes_dir);

$strReqFileName = $new_codes_dir."/".$lowerFirstPackageName.'Req.proto';
$strResFileName = $new_codes_dir."/".$lowerFirstPackageName.'Res.proto';

$strJsonFile = $strTmpDataPath.'/'.$strTmpDataFileName;
$strIdljson = trim(file_get_contents($strJsonFile));
$strIdljson = str_replace("'", '"',$strIdljson);
$strIdljson = preg_replace('/,\s*([\]}])/m', '$1',$strIdljson);
        
//var_dump($strJsonFile,$strIdljson,__FILE__,__LINE__);
$arrJson = json_decode($strIdljson,true);

//var_dump($arrJson);
///////////////////////////////////////////////////////


//get structs from idl array
////////////////////////////////////////////////
foreach($arrJson['structs']  as $key => $val){
	if('struct' == $val['type']){
		$arrStructs[$val['name']]	 = $val['children'];
	}

}
////////////////////////////////////////////////

//generateCodes
////////////////////////////////////////////////
echo 'generate files:'."\n";

//
$strCodesRes = generateProbuf::getAllStructs($arrStructs);
//
generateProbuf::getResCodes($strResFileName,$strPackageName,$strUrl,$strCmd,$strDesc,$arrStructs);
echo $strResFileName."\n";
//
generateProbuf::clearProbufsTmpPool();
//
generateProbuf::getReqCodes($strReqFileName,$strPackageName,$strUrl,$strCmd,$strDesc,$arrStructs);
echo $strReqFileName."\n";

echo "\n";
////////////////////////////////////////////////


