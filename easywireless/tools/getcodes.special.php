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
	echo 'usage: php '.basename(__FILE__).' $idl_file $module_name $action_path $action_name $author $new_codes_dir $service_name=optinal $method_name=optinal';
	echo "\n";
	echo 'sample: php '.basename(__FILE__).' tmp/clientidl/moccommit/game/updatetimes.idl client-commit actions/game updatetimes zhouping999 game/  game setDownload';
	echo "\n";
	echo  '$idl_file: '.mb_convert_encoding('idl文件的绝对路径','gbk','utf-8');
	echo "\n";
	die("bye\n");
}


$idl_file = $argv[1];
if(!file_exists($idl_file)){
	echo 'err. idl_file:'.$idl_file.' is not exsits.';
	exit;
}


$module_name	= $argv[2];
$action_path	= $argv[3];
$action_name	= $argv[4];
$author 		= $argv[5];
$new_codes_dir		= $argv[6];
$service_name 		= $argv[7];
$method_name		= $argv[8];

include_once(dirname(__FILE__).'/getcodes.exec.php');

class getVarFromIdl{

		private static $_arrVars = array(
										 	'url'		=> '',
										 	'desc'		=> '',
										 	'cmd'		=> '',
											'author'	=> '',
										 );
		private static $_arrAlphaToActionName = array(
				'c'	=> 'client-commit',
				'f'	=> 'client-forum',
				'u'	=> 'client-user',
				's'	=> 'client-sys',
				'm'	=> 'client-msg',
				'k'	=> 'client-sdk',
				'p'	=> 'client-proxy',
				'r'	=> 'client-friend',
		);

		private static function _getModuleNameFromUrl($strUrl){
			$arr =  explode('/',$strUrl);		
			if('f' == $arr[1] && 'frs' == $arr[2]){
				return "client-frs";
			}
			if('f' == $arr[1] && 'pb' == $arr[2]){
				return "client-pb";
			}
			return self::$_arrAlphaToActionName[$arr[1]];
		}

		private static function _getActionPathFromUrl($strUrl){
			$arr =  explode('/',$strUrl);		
			return 'actions/'.$arr[2]."/".$arr[3];
		}

		private static function _getActionNameFromUrl($strUrl){
			$arr =  explode('/',$strUrl);		
			return $arr[3];
		}

		private static function _getNewCodesDirFromUrl($strUrl){
			$arr =  explode('/',$strUrl);		
			return $arr[2];
		}

		public static function getNeedVars($strLine){

			if(empty($_arrVars['url'])){
				preg_match("/.*@(url).*:(.*)/",$strLine,$arrTmp);
				if('url' == $arrTmp[1]){
					self::$_arrVars['url'] = trim($arrTmp[2]);
					self::$_arrVars['module_name'] = self::_getModuleNameFromUrl(self::$_arrVars['url']);
					self::$_arrVars['action_path'] = self::_getActionPathFromUrl(self::$_arrVars['url']);
					self::$_arrVars['action_name'] = self::_getActionNameFromUrl(self::$_arrVars['url']);
					self::$_arrVars['new_codes_dir'] = self::_getNewCodesDirFromUrl(self::$_arrVars['url']);
				}
			}

			if(empty($_arrVars['desc'])){

				//desc 和 cmd在一行的情况
				preg_match("/.*@(description)(.*)(cmd):(.*)/",$strLine,$arrTmp);
				if('description' == $arrTmp[1]){
					preg_match("/(.*):(.*)/",$arrTmp[2],$arrTmp1);
					self::$_arrVars['desc'] = trim($arrTmp1[2]);
				}else{
					//只有desc,没有cmd的情况
					preg_match("/.*@(description)(.*)/",$strLine,$arrTmp);
					if('description' == $arrTmp[1]){
						self::$_arrVars['desc'] = trim($arrTmp[2]);
					}
				
				}
			}
			if(empty($_arrVars['cmd'])){
				preg_match("/(cmd):(.*)/",$strLine,$arrTmp);
				if('cmd' == $arrTmp[1]){
					self::$_arrVars['cmd'] = trim($arrTmp[2]);
				}
			}
			if(empty($_arrVars['author'])){
				preg_match("/@(author):(.*)/",$strLine,$arrTmp);
				if('author' == $arrTmp[1]){
					$strTmp = trim($arrTmp[2]);
					list($strAuthor,) = explode(" ",$strTmp);
					self::$_arrVars['author'] = $strAuthor;
				}
			}
		
		}

		public static function getVars(){
				return self::$_arrVars;
		}

		private static function _getUrl($arrParse){
			$strUrl = '';
			if('url' == $arrParse[1]){
				$strUrl = trim($arrParse[2]);
			}
			return $strUrl;
		}
}
