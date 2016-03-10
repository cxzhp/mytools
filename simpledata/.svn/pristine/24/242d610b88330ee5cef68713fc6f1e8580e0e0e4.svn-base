<?php
/*==================================
*   Copyright (C) 2014 Baidu.com, Inc. All rights reserved.
*   
*   filename	:	getVarFromIdl.class.php
*   author		:	zhouping01
*   create_time	:2014-10-13
*   desc		:
*
===================================*/
class getVarFromIdl{

		private static $_arrVars = array(
										 	'url'		=> '',
										 	'desc'		=> '',
										 	'cmd'		=> '',
											'author'	=> '',
										 );
		private static $_arrAlphaToActionName = array(
				'c'	=> 'client-commit',
				'e'	=> 'client-mocencourage',
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
			return 'actions/'.$arr[2];
		}

		private static function _getActionNameFromUrl($strUrl){
			$arr =  explode('/',$strUrl);		
			if(strlen($arr[3])>0){
				//for url: c/f/frs/page
				return $arr[3];
			}elseif(strlen($arr[2])>0){
				//for url: c/k/cksign
				return $arr[2];
			}
			return $arr[2];
		}

		private static function _getNewCodesDirFromUrl($strUrl){
			$arr =  explode('/',$strUrl);		
			return $arr[2];
		}

		public static function getNeedVars($strLine){

			if(empty($_arrVars['url'])){
				preg_match("/.*@(url).*:(.*)/",$strLine,$arrTmp);
				if('url' == $arrTmp[1]){
					$strUrl = trim($arrTmp[2]);
					if('/' == $strUrl[0]){
						$strUrl = substr($strUrl,1);
					}
					self::$_arrVars['url'] = $strUrl;
					self::$_arrVars['module_name'] = self::_getModuleNameFromUrl(self::$_arrVars['url']);
					self::$_arrVars['action_path'] = self::_getActionPathFromUrl(self::$_arrVars['url']);
					self::$_arrVars['action_name'] = self::_getActionNameFromUrl(self::$_arrVars['url']);
					self::$_arrVars['new_codes_dir'] = self::_getModuleNameFromUrl(self::$_arrVars['url']);
				}
			}

			if(empty($_arrVars['desc'])){

				//desc 和 cmd在一行的情况
				preg_match("/.*@(description)(.*)(cmd):(.*)/",$strLine,$arrTmp);
				if('description' == $arrTmp[1]){
					preg_match("/(.*):(.*)/",$arrTmp[2],$arrTmp1);
					if(mb_detect_encoding($arrTmp1[2]) == 'UTF-8' ){
						self::$_arrVars['desc'] = mb_convert_encoding(trim($arrTmp1[2]),'gbk','utf-8');
					}else{
						//pass	
					}
					//self::$_arrVars['desc'] = trim($arrTmp1[2]);
				}else{
					//只有desc,没有cmd的情况
					preg_match("/.*@(description)(.*)/",$strLine,$arrTmp);
					if('description' == $arrTmp[1]){
						if(mb_detect_encoding($arrTmp1[2]) == 'UTF-8' ){
							self::$_arrVars['desc'] = mb_convert_encoding(trim($arrTmp1[2]),'gbk','utf-8');
						}else{
							//pass	
						}
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
