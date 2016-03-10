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

class generateCodes{

	const NEW_LINE = "\n";
	const NEW_TAB = "\t";

	public static $errMsg = array();
	public static $arrTestReqParams = array();
	public static $strCodeInputForService = '';

	private static $_intLoopMaxTimes = 20;
	private static $_arrHumpStyleWhiteList = array(
			'error_code' => 1,
			'error_msg'	 => 1,
			'name_show'  => 1,
	);


	public function getErrMsg(){
		$str = '';
		foreach(self::$errMsg as $key => $val){
			$str .= $val;
			$str .= "\n";
		}

		return $str;
	}

	public function checkStructs($arrStructs){

		foreach($arrStructs as $key => $arrParams){
			foreach($arrParams as $tmpKey => $arrParamInfo ){
				if(self::_camelStyle($arrParamInfo['name']) != $arrParamInfo['name']){

					self::$errMsg[] = 'field_name: '.$arrParamInfo["name"]."\n".'pls use camel style! like varStyle.'."\n".' right: varStyle'."\n".'error:var_style';
					return false;
				}
			}
		}
		return true;
	}


	public function getCodesUiAction($strActionName,$strModuleName,$strAuthor,$arrStructs,$strTplDir,$strTplFileName,$strServiceName='',$strMethod=''){

		$strFileName = strtolower($strActionName).'Action.php';
		$strCreateTime = date('Y-m-d H:i:s');
		$strActionClassName = strtolower($strActionName).'Action';
		$strCodesReq = self::_getReq($arrStructs);
		$strCodesCheckReq = self::_getCheckReq($arrStructs);
		$strCodesLogicReq = self::_getReqLogic($arrStructs);

		$strLogicClassName = 'Actions_'.ucfirst($strModuleName).'_Logic_'.ucfirst($strActionName).'logic';

		//get codes 1 -----//
		$strTplContent = self::getTplContent($strTplDir,$strTplFileName);

		$arrReplaceFrom = array('%filename%','%author%','%create_time%','%action_name%','%codes_req%','%codes_check_req%','%code_logic_req%',"\r");
		$arrReplaceTo 	= array($strFileName,$strAuthor,$strCreateTime,$strActionClassName,$strCodesReq,$strCodesCheckReq,$strCodesLogicReq,"");
		$strTplContent = str_replace($arrReplaceFrom, $arrReplaceTo, $strTplContent);
		//----- get codes 1//

		//get codes 2 -----//
		if(strlen($strServiceName)>0 && strlen($strMethod)>0){
		
			$strCodesResServiceCall = generateCodes::_getResServiceCall($arrStructs);

			$strTplContentServiceCall = self::getTplContent($strTplDir,'servicecall.php');
			$arrReplaceFrom = array('%service_name%','%method_name%','%code_res%','%arr_input%',"\r");
			$arrReplaceTo 	= array($strServiceName,$strMethod,$strCodesResServiceCall,self::$strCodeInputForService,'');
			$strCodesServiceCall = str_replace($arrReplaceFrom, $arrReplaceTo, $strTplContentServiceCall);


			$pattern = array("/^/","/\n/");
			$replacement = array(str_repeat(self::NEW_TAB,2),"\n".str_repeat(self::NEW_TAB,2));
			$strCodesServiceCall = preg_replace($pattern, $replacement, $strCodesServiceCall);


		}else{
			$strCodesServiceCall = '';
		}

		$arrReplaceFrom = array('%service_call%');
		$arrReplaceTo 	= array($strCodesServiceCall);
		$strTplContent = str_replace($arrReplaceFrom, $arrReplaceTo, $strTplContent);
		//----- get codes 2//


		$strCodes .= $strTplContent;
		$strCodes .= self::NEW_LINE;


		return $strCodes;

	}



	public function getCodesLogic($strActionName,$strModuleName,$strAuthor,$arrStructs,$strTplDir,$strTplFileName,$strServiceName='',$strMethod=''){

		$strFileName = ucfirst($strActionName).'logic.php';
		$strCreateTime = date('Y-m-d H:i:s');

		$strLogicClassName = 'Actions_'.ucfirst($strModuleName).'_Logic_'.ucfirst($strActionName).'logic';
		$strCodesLogicReq = self::_getReqLogic($arrStructs);

		$strCodesRes = generateCodes::_getRes($arrStructs);

		//get codes 1 -----//
		$strTplContent = self::getTplContent($strTplDir,$strTplFileName);

		$arrReplaceFrom = array('%filename%','%author%','%create_time%','%logic_class_name%','%code_logic_req%','%code_res%',"\r");
		$arrReplaceTo 	= array($strFileName,$strAuthor,$strCreateTime,$strLogicClassName,$strCodesLogicReq,$strCodesRes,'');
		$strTplContent = str_replace($arrReplaceFrom, $arrReplaceTo, $strTplContent);
		//----- get codes 1//


		//get codes 2 -----//
		if(strlen($strServiceName)>0 && strlen($strMethod)>0){
		
			$strCodesResServiceCall = generateCodes::_getResServiceCall($arrStructs);

			$strTplContentServiceCall = self::getTplContent($strTplDir,'servicecall.php');
			$arrReplaceFrom = array('%service_name%','%method_name%','%code_res%',"\r");
			$arrReplaceTo 	= array($strServiceName,$strMethod,$strCodesResServiceCall,'');
			$strCodesServiceCall = str_replace($arrReplaceFrom, $arrReplaceTo, $strTplContentServiceCall);


			$pattern = array("/^/","/\n/");
			$replacement = array(str_repeat(self::NEW_TAB,2),"\n".str_repeat(self::NEW_TAB,2));
			$strCodesServiceCall = preg_replace($pattern, $replacement, $strCodesServiceCall);


		}else{
			$strCodesServiceCall = '';
		}

		$arrReplaceFrom = array('%service_call%');
		$arrReplaceTo 	= array($strCodesServiceCall);
		$strCodes .= str_replace($arrReplaceFrom, $arrReplaceTo, $strTplContent);
		//----- get codes 2//

		$strCodes .=  self::NEW_LINE;
		return $strCodes;

	}



	public function getTplContent($strDir,$strFileName){
		$strContent = file_get_contents($strDir.$strFileName);
		return $strContent;
	}


	function _getRes($arrStructs){

		$strCodes =  self::NEW_LINE;
		$strCodes .=  str_repeat(self::NEW_TAB,2).'//structs from res'.self::NEW_LINE;
		$strCodes .=  str_repeat(self::NEW_TAB,2).'///////////////////////////////////////////////////'.self::NEW_LINE;


				foreach($arrStructs as $key => $arrParams){
					if('Res' == $key){

						foreach($arrParams as $tmpKey => $arrParamInfo ){

							//not need getCodes
							//error_code and error_msg  is already in tpl -----//
							if('error_code' == $arrParamInfo['name']){
								continue;
							}
							if('error_msg' == $arrParamInfo['name']){
								continue;
							}
							//----- error_code and error_msg  is already in tpl//

							if(self::_isIntType($arrParamInfo['type'])){
								$strCodes .= str_repeat(self::NEW_TAB,2).'$arrRet[\''.$arrParamInfo['name'].'\'] = intval($'.self::_camelStyle($arrParamInfo['name']).');';
								
							}elseif(self::_isStringType($arrParamInfo['type'])){
								$strCodes .= str_repeat(self::NEW_TAB,2).'$arrRet[\''.$arrParamInfo['name'].'\'] = strval($'.self::_camelStyle($arrParamInfo['name']).');';

							}elseif(self::_isComplicatedType($arrParamInfo['type'])){
								$strCodes .= self::NEW_LINE.
									str_repeat(self::NEW_TAB,2).'//'.$arrParamInfo['name'].' -----//'
									.self::NEW_LINE;
								$strCodes .= self::_getComplicatedCodes($arrStructs,$arrParamInfo['type']);
								self::_resetLoopTimes();
								if('array' == $arrParamInfo['attributes'][0]['name']){
									$strCodes .= str_repeat(self::NEW_TAB,2).'$arrRet[\''.$arrParamInfo['name'].'\'][] = $'.$arrParamInfo['type'].';';
								}else{
									$strCodes .= str_repeat(self::NEW_TAB,2).'$arrRet[\''.$arrParamInfo['name'].'\'] = $'.$arrParamInfo['type'].';';
								}
								$strCodes .= self::NEW_LINE.
									str_repeat(self::NEW_TAB,2).'//----- '.$arrParamInfo['name'].'//'
									.self::NEW_LINE;
							}else{
								$strCodes .= str_repeat(self::NEW_TAB,2).'$arrRet[\''.$arrParamInfo['name'].'\'] = $'.self::_camelStyle($arrParamInfo['name']).';';
							}

							$strCodes .=  self::NEW_LINE;

						}

					}

				}
		$strCodes .=  str_repeat(self::NEW_TAB,2).'///////////////////////////////////////////////////'.self::NEW_LINE;

		return $strCodes;
	}


	function _getResServiceCall($arrStructs){

		$strCodes =  self::NEW_LINE;


		foreach($arrStructs as $key => $arrParams){
			if('Res' == $key){

				foreach($arrParams as $tmpKey => $arrParamInfo ){

					//not need getCodes
					//error_code and error_msg  is already in tpl -----//
					if('error_code' == $arrParamInfo['name']){
						continue;
					}
					if('error_msg' == $arrParamInfo['name']){
						continue;
					}
					//error need replace with "error_code and error_msg", and "error_code and error_msg" is already in tpl
					if('error' == $arrParamInfo['name']){
						continue;
					}
					//----- error_code and error_msg  is already in tpl//

					if(self::_isIntType($arrParamInfo['type'])){
						$strCodes .= str_repeat(self::NEW_TAB,2).'$arrRet[\''.$arrParamInfo['name'].'\'] = intval($'.self::_camelStyle($arrParamInfo['name']).');';

					}elseif(self::_isStringType($arrParamInfo['type'])){
						$strCodes .= str_repeat(self::NEW_TAB,2).'$arrRet[\''.$arrParamInfo['name'].'\'] = strval($'.self::_camelStyle($arrParamInfo['name']).');';

					}elseif(self::_isComplicatedType($arrParamInfo['type'])){
						$strCodes .= self::NEW_LINE.
							str_repeat(self::NEW_TAB,1).'//'.$arrParamInfo['name'].' -----//'
							.self::NEW_LINE;
						$strCodes .= self::_getComplicatedCodes($arrStructs,$arrParamInfo['type']);
						self::_resetLoopTimes();
						if('array' == $arrParamInfo['attributes'][0]['name']){
							$strCodes .= str_repeat(self::NEW_TAB,1).'$arrRet[\''.$arrParamInfo['name'].'\'][] = $'.$arrParamInfo['type'].';';
						}else{
							if('data' == $arrParamInfo['name']){
								$strCodes .= str_repeat(self::NEW_TAB,1).'$arrRet = array_merge($arrRet,$'.$arrParamInfo['type'].');';
							}else{
								$strCodes .= str_repeat(self::NEW_TAB,1).'$arrRet[\''.$arrParamInfo['name'].'\'] = $'.$arrParamInfo['type'].';';
							}
						}
						$strCodes .= self::NEW_LINE.
							str_repeat(self::NEW_TAB,1).'//----- '.$arrParamInfo['name'].'//'
							.self::NEW_LINE;
					}else{
						$strCodes .= str_repeat(self::NEW_TAB,1).'$arrRet[\''.$arrParamInfo['name'].'\'] = $'.self::_camelStyle($arrParamInfo['name']).';';
					}

					$strCodes .=  self::NEW_LINE;

				}

			}

		}


		return $strCodes;
	}

	function _getReq($arrStructs){


		$strCodes = 
'public function _getPrivateInfo(){
			$arrPrivateInfo = array();
			$arrPrivateInfo[\'check_login\'] = true; //todo
			$arrPrivateInfo[\'need_login\'] = true; //todo';
				$strCodes .=  self::NEW_LINE;

				foreach($arrStructs as $key => $arrParams){
					if('Req' == $key){

						foreach($arrParams as $tmpKey => $arrParamInfo ){

							if(self::_isIntType($arrParamInfo['type'])){
								$strCodes .= str_repeat(self::NEW_TAB,3).'$arrPrivateInfo[\''.$arrParamInfo['name'].'\'] = intval($this->_getInput(\''.$arrParamInfo['name'].'\', 0));';
								self::$arrTestReqParams[$arrParamInfo['name']] = mt_rand(111,999);
								
							}elseif(self::_isStringType($arrParamInfo['type'])){
								$strCodes .= str_repeat(self::NEW_TAB,3).'$arrPrivateInfo[\''.$arrParamInfo['name'].'\'] = strval($this->_getInput(\''.$arrParamInfo['name'].'\', ""));';
								self::$arrTestReqParams[$arrParamInfo['name']] = 'string_'.mt_rand(111,999);

							}else{
								$strCodes .= str_repeat(self::NEW_TAB,3).'$arrPrivateInfo[\''.$arrParamInfo['name'].'\'] = $this->_getInput(\''.$arrParamInfo['name'].'\', 0);';
								self::$arrTestReqParams[$arrParamInfo['name']] = 'val'.mt_rand(1111,9999);
							
							}

							$strCodes .=  self::NEW_LINE;

						}

					}

				}

				$strCodes .= str_repeat(self::NEW_TAB,3).'$arrPrivateInfo[\'ispv\'] = 0; //todo
			return $arrPrivateInfo;
		}';
				$strCodes .=  self::NEW_LINE;

		return $strCodes;
	}


	function _getCheckReq($arrStructs){


		$strCodes = 'protected function _checkPrivate() {';
		$strCodes .=  self::NEW_LINE;

				foreach($arrStructs as $key => $arrParams){
					if('Req' == $key){

						foreach($arrParams as $tmpKey => $arrParamInfo ){

							if(self::_isIntType($arrParamInfo['type'])){

								$strHumpVarName = 'int'.ucfirst(self::_camelStyle($arrParamInfo['name']));

								$strCodesTmp = str_repeat(self::NEW_TAB,3).'
			$intGameId = $this->_objRequest->getPrivateAttr("game_id");
			if($intGameId < 0){
				$arrRet = $this->_error(Tieba_Errcode::ERR_PARAM_ERROR, Molib_Client_Error::getErrMsg(Tieba_Errcode::ERR_PARAM_ERROR));
				Bingo_Log::warning("err game_id. [game_id:".serialize($intGameId)."]");
				return false;
			}';
								$arrReplaceFrom = array('intGameId','game_id');
								$arrReplaceTo 	= array($strHumpVarName,$arrParamInfo['name']);
								$strCodes .= str_replace($arrReplaceFrom, $arrReplaceTo, $strCodesTmp);
								$strCodes .=  self::NEW_LINE;
								
							}elseif(self::_isStringType($arrParamInfo['type'])){

								$strHumpVarName = 'str'.ucfirst(self::_camelStyle($arrParamInfo['name']));

								$strCodesTmp = str_repeat(self::NEW_TAB,3).'
			$strContent = $this->_objRequest->getPrivateAttr("content");
			if(strlen($strContent) <= 0){
				$arrRet = $this->_error(Tieba_Errcode::ERR_PARAM_ERROR, Molib_Client_Error::getErrMsg(Tieba_Errcode::ERR_PARAM_ERROR));
				Bingo_Log::warning("err content. [content:".serialize($strContent)."]");
				return false;
			}';
								$arrReplaceFrom = array('strContent','content');
								$arrReplaceTo 	= array($strHumpVarName,$arrParamInfo['name']);
								$strCodes .= str_replace($arrReplaceFrom, $arrReplaceTo, $strCodesTmp);
								$strCodes .=  self::NEW_LINE;

							}else{
							
							}

							$strCodes .=  self::NEW_LINE;

						}

					}

				}

		$strCodes .= str_repeat(self::NEW_TAB,3).'return true;
		}';
		$strCodes .=  self::NEW_LINE;

		return $strCodes;
	}

	function _getReqLogic($arrStructs){


				foreach($arrStructs as $key => $arrParams){
					if('Req' == $key){

						foreach($arrParams as $tmpKey => $arrParamInfo ){

							if(self::_isIntType($arrParamInfo['type'])){
								$strVarName = str_repeat(self::NEW_TAB,2).'$int'.ucfirst(self::_camelStyle($arrParamInfo['name']));
								$strCodes .= $strVarName.' = intval($this->_objRequest->getPrivateAttr(\''.$arrParamInfo['name'].'\'));';

							}elseif(self::_isStringType($arrParamInfo['type'])){
								$strVarName = str_repeat(self::NEW_TAB,2).'$str'.ucfirst(self::_camelStyle($arrParamInfo['name']));
								$strCodes .= $strVarName.' = strval($this->_objRequest->getPrivateAttr(\''.$arrParamInfo['name'].'\'));';

							}else{
								$strVarName = str_repeat(self::NEW_TAB,2).'$'.self::_camelStyle($arrParamInfo['name']);
								$strCodes .= $strVarName.' = $this->_objRequest->getPrivateAttr(\''.$arrParamInfo['name'].'\');';
							
							}

							$strCodes .=  self::NEW_LINE;

							self::$strCodeInputForService .= str_repeat(self::NEW_TAB,2).'"'.$arrParamInfo['name'].'" => '.$strVarName.', ';
							self::$strCodeInputForService .=  self::NEW_LINE;

						}

					}

				}

		return $strCodes;
	}




			public function _getPrivateInfo()                                             
			{                                                                             
				$strCodes = '
					$arrPrivateInfo = array();                                                
					$arrPrivateInfo[\'check_login\'] = true; //todo
					$arrPrivateInfo[\'need_login\'] = true; //todo';
				$strCodes .=  self::NEW_LINE;

				foreach($arrStructs as $key => $arrParams){
					if('Req' == $key){

						foreach($arrParams as $tmpKey => $arrParamInfo ){

							if(self::_isIntType($arrParamInfo['type'])){
								$strCodes .= str_repeat(self::NEW_TAB,3).'$arrPrivateInfo[\''.$arrParamInfo['name'].'\'] = intval($this->_getInput(\''.$arrParamInfo['name'].'\', 0));';
								
							}elseif(self::_isStringType($arrParamInfo['type'])){
								$strCodes .= str_repeat(self::NEW_TAB,3).'$arrPrivateInfo[\''.$arrParamInfo['name'].'\'] = strval($this->_getInput(\''.$arrParamInfo['name'].'\', ""));';

							}else{
								$strCodes .= str_repeat(self::NEW_TAB,3).'$arrPrivateInfo[\''.$arrParamInfo['name'].'\'] = $this->_getInput(\''.$arrParamInfo['name'].'\');';
							
							}

							$strCodes .=  self::NEW_LINE;

						}

					}

				}

				$strCodes .= '
				$arrPrivateInfo[\'ispv\'] = 0; //todo
				return $arrPrivateInfo;                                                   
			}
		';

		return $strCodes;
	}



	function _isComplicatedType($type){
		$type = strtolower($type);

		if(self::_isIntType($type)){
			return false;
		}
		if(self::_isStringType($type)){
			return false;
		}

		if( 
		   $type === 'double'
		   || $type === 'float' 
		   || $type === 'bool'
		   || $type === 'binary'
		  ){
			return false;
		}

		return true;
	}

	private static function _isIntType($type){
		$type = strtolower($type);
		if(
		   $type === 'int64_t' 
		   || $type === 'int64'
		   || $type === 'uint64_t'
		   || $type === 'uint64'
		   || $type === 'int32_t' 
		   || $type === 'int32' 
		   || $type === 'uint32_t'
		   || $type === 'uint32'
		   || $type === 'int16_t'
		   || $type === 'int16'
		   || $type === 'uint16_t'
		   || $type === 'uint16'
		   || $type === 'int8_t'
		   || $type === 'int8'
		   || $type === 'uint8_t'
		   || $type === 'uint8'
		  ){

			return true;
		}
		return false;

	}

	private static function _isStringType($type){
		$type = strtolower($type);
		if($type === 'string'){

			return true;
		}
		return false;
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

	//对于复杂变量，进行处理
	private static function _getComplicatedCodes($arrStructs,$strType,$isInLoop=0){
		self::_incrLoopTimes();

		$strCodes = '';

		foreach($arrStructs[$strType] as $tmpKey => $arrParamInfo ){


			if(self::_isIntType($arrParamInfo['type'])){

				if(isset($arrParamInfo['attributes'][0]['params'][0]['type'])  && 'literal' == $arrParamInfo['attributes'][0]['params'][0]['type']){
					if(1 ==  $isInLoop){
						$strCodes .= str_repeat(self::NEW_TAB,2).'$arrTmp[\''.$arrParamInfo['name'].'\'] = $val["'.$arrParamInfo['name'].'"];';
					}else{
						$strCodes .= str_repeat(self::NEW_TAB,2).'$'.$strType.'[\''.$arrParamInfo['name'].'\'] = $'.self::_camelStyle($arrParamInfo['name']).';';
					}

				}elseif(1 ==  $isInLoop){
					$strCodes .= str_repeat(self::NEW_TAB,2).'$arrTmp[\''.$arrParamInfo['name'].'\'] = intval($val["'.$arrParamInfo['name'].'"]);';
				}else{
					$strCodes .= str_repeat(self::NEW_TAB,2).'$'.$strType.'[\''.$arrParamInfo['name'].'\'] = intval($'.self::_camelStyle($arrParamInfo['name']).');';
				}

			}elseif(self::_isStringType($arrParamInfo['type'])){
				if(isset($arrParamInfo['attributes'][0]['params'][0]['type'])  && 'literal' == $arrParamInfo['attributes'][0]['params'][0]['type']){
					if(1 ==  $isInLoop){
						$strCodes .= str_repeat(self::NEW_TAB,2).'$arrTmp[\''.$arrParamInfo['name'].'\'] = $val["'.$arrParamInfo['name'].'"];';
					}else{
						$strCodes .= str_repeat(self::NEW_TAB,2).'$'.$strType.'[\''.$arrParamInfo['name'].'\'] = $'.self::_camelStyle($arrParamInfo['name']).';';
					}

				}elseif(1 ==  $isInLoop){
					$strCodes .= str_repeat(self::NEW_TAB,2).'$arrTmp[\''.$arrParamInfo['name'].'\'] = strval($val["'.$arrParamInfo['name'].'"]);';
				}else{
					$strCodes .= str_repeat(self::NEW_TAB,2).'$'.$strType.'[\''.$arrParamInfo['name'].'\'] = strval($'.self::_camelStyle($arrParamInfo['name']).');';
				}

			}elseif(self::_isComplicatedType($arrParamInfo['type'])){
				if(1 ==  $isInLoop){
					$strCodes .= str_repeat(self::NEW_TAB,2).'$arrTmp[\''.$arrParamInfo['name'].'\'] = $val["'.$arrParamInfo['name'].'"];';
				}else{
					$strCodes .=  str_repeat(self::NEW_TAB,1).'foreach($arrOutput["data"] as $key => $val){';
					$strCodes .= self::NEW_LINE.str_repeat(self::NEW_TAB,2).'//'.$arrParamInfo['type'].' -----//'.self::NEW_LINE;
					$strCodes .= self::_getComplicatedCodes($arrStructs,$arrParamInfo['type'],$isInLoop=1);

					//$strCodes .= str_repeat(self::NEW_TAB,2).'$'.$strType.'[\''.$arrParamInfo['name'].'\'] = $'.$arrParamInfo['name'].';';
					$strCodes .= str_repeat(self::NEW_TAB,2).'$'.$strType.'[\''.$arrParamInfo['name'].'\'][] = $arrTmp;';
					$strCodes .= self::NEW_LINE.str_repeat(self::NEW_TAB,2).'//----- '.$arrParamInfo['type'].'//'.self::NEW_LINE;
					$strCodes .=  str_repeat(self::NEW_TAB,1).'}';
				}
			}else{
				if(1 ==  $isInLoop){
					$strCodes .= str_repeat(self::NEW_TAB,2).'$arrTmp[\''.$arrParamInfo['name'].'\'] = $val["'.$arrParamInfo['name'].'"];';
				}else{
					$strCodes .= str_repeat(self::NEW_TAB,2).'$'.$strType.'[\''.$arrParamInfo['name'].'\'] = $'.self::_camelStyle($arrParamInfo['name']).';';
				}
			}

			$strCodes .=  self::NEW_LINE;

		}


		return $strCodes;
	}


	private static function _incrLoopTimes($intStep = 1){
		self::$_intLoopMaxTimes = self::$_intLoopMaxTimes + $intStep;	
	}

	private static function _resetLoopTimes(){
		self::$_intLoopMaxTimes = 0;	
	}

}
