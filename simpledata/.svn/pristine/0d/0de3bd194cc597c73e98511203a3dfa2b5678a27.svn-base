<?php
///*==================================
//*   Copyright (C) 2014 Baidu.com, Inc. All rights reserved.
//*   
//*   filename	:getprobuf.php
//*   author		:	zhouping01
//*   create_time	:2014-10-07
//*   desc		:
//*
//===================================*/


class generateProbuf{

	const NEW_LINE = "\n";
	const NEW_TAB = "\t";

	private static $_arrDefineStructs = array();
	private static $_arrDefineStructsDetail = array();
	private static $_arrProbufsTmpPool = array();

	private static $_intLoopMaxTimes = 20;


	private static $_arrIgnoreFieldName = array(
												'error_code' => 1,
												'error_msg' => 1,
											);


	private static $_arrTypesWhiteList = array(
												'Error' => 1,
											);

	private static $_arrHumpStyleWhiteList = array(
			'error_code' => 1,
			'error_msg'	 => 1,
			'name_show'  => 1,
	);

	//cat client.proto  | grep message |awk '{print $2;}' | sed s/{//g  | sed s/\\r//g | sed s/\\n//g | awk '{print "\""$0"\" => 1,"}'
	private static $_commonStructs = array(
		"Error" => 1,
		"CommonReq" => 1,
		"Page" => 1,
		"Anti" => 1,
		"string" => 1,
		"Terminal" => 1,
		"Position" => 1,
		"Icon" => 1,
		"TshowInfo" => 1,
		"Abstract" => 1,
		"Media" => 1,
		"Voice" => 1,
		"Props" => 1,
		"ParrProps" => 1,
		"AvatarFrame" => 1,
		"Level" => 1,
		"Portrait" => 1,
		"MparrProps" => 1,
		"WapRn" => 1,
		"ParrScores" => 1,
		"NoticeMask" => 1,
		"Rpgoldicon" => 1,
		"TbmallMonthIcon" => 1,
		"Equipment" => 1,
		"Avatar" => 1,
		"SignatureInfo" => 1,
		"GameAttr" => 1,
		"Global" => 1,
		"NewUser" => 1,
		"Balv" => 1,
		"PayMemberInfo" => 1,
		"UserPics" => 1,
		"PrivSets" => 1,
		"LikeForumInfo" => 1,
		"MyGroupInfo" => 1,
		"GiftInfo" => 1,
		"User" => 1,
		"Zan" => 1,
		"MediaNum" => 1,
		"AnchorInfo" => 1,
		"PostList" => 1,
		"Topic" => 1,
		"ThreadInfo" => 1,
		"ThreadPicList" => 1,
		"GoodsInfo" => 1,
		"App" => 1,
		"BannerList" => 1,
		"SimpleForum" => 1,
		"PbContent" => 1,
		"SubPostList" => 1,
		"SubPost" => 1,
		"AddPostList" => 1,
		"SignatureContent" => 1,
		"SignatureData" => 1,
		"TailInfo" => 1,
		"Post" => 1,
		"Guess" => 1,
		"Lbs" => 1,
		"Superscript" => 1,
		"GameCategory" => 1,
		"GameInfo" => 1,
		"LbsInfo" => 1,
		"Quote" => 1,
		"PostInfoContent" => 1,
		"PostInfoList" => 1,
	);



	public static function getResCodes($strResFileName,$strPackageName,$strUrl,$strCmd,$strDesc,$arrStructs){
	
		$arrProbufs = generateProbuf::getAllProbufByKey($arrStructs,'Res');
		$strCodes = '';
		foreach($arrProbufs as $key => $val){
			if('Res' == $key){
				$val = str_replace(' DataRes ',' '.$strPackageName.'ResIdl ',$val);
			}
			$strCodes = $val.$strCodes;
		}

		//$strPreTxt = "//". mb_convert_encoding($strDesc,'GBK','UTF-8')." cmd:".$strCmd."\n";
		$strPreTxt = "//". $strDesc." cmd:".$strCmd."\n";
		//$strPreTxt .=  "//url:".$strUrl."\n";
		$strPreTxt .= "package tbclient.".$strPackageName.";\n";
		$strPreTxt .= "import \"client.proto\";\n";

		$strCodes = $strPreTxt."\n".$strCodes;


//		$strTailTxt = "\n"."
//message ".$strPackageName."ResIdl {
//	optional Error       error   = 1;
//	optional DataRes     data    = 2;
//}"."\n";
//
//
//		$strTailTxt = str_replace("\r","",$strTailTxt);
//		$strCodes .= $strTailTxt;
		file_put_contents($strResFileName,$strCodes);
	
		return true;
	}


	public static function getReqCodes($strReqFileName,$strPackageName,$strUrl,$strCmd,$strDesc,$arrStructs){
	
		$arrProbufs = generateProbuf::getAllProbufByKey($arrStructs,'Req');
		$strCodes = '';
		foreach($arrProbufs as $key => $val){
			$strCodes = $val."\n".$strCodes;
		}

		//$strPreTxt = "//". mb_convert_encoding($strDesc,'GBK','UTF-8')." cmd:".$strCmd."\n";
		$strPreTxt = "//". $strDesc." cmd:".$strCmd."\n";
		$strPreTxt .=  "//url:".$strUrl."\n";
		$strPreTxt .= "package tbclient.".$strPackageName.";\n";
		$strPreTxt .= "import \"client.proto\";\n";

		$strCodes = $strPreTxt."\n".$strCodes;


		$strTailTxt = "\n"."
message ".$strPackageName."ReqIdl {
    optional DataReq    data=1;
}"."\n";

		$strTailTxt = str_replace("\r","",$strTailTxt);
		$strCodes .= $strTailTxt;

		file_put_contents($strReqFileName,$strCodes);
	
		return true;
	}



	public static function getAllProbufByKey($arrStructs,$strProbufType){

		if(isset($arrStructs[$strProbufType]) && is_array($arrStructs[$strProbufType])){

			$arrStructsTodo = $arrStructs[$strProbufType];
			if(self::_isComplicatedType($strProbufType)){
				self::$_arrProbufsTmpPool[$strProbufType] = self::getStructDetail($strProbufType);
			}

			//var_dump($strProbufType,$arrStructsTodo,__FILE__,__LINE__);
			foreach($arrStructsTodo as $key => $val){
				$strType = $val['type'];

				if(self::_isComplicatedType($strType)){
					//递归
					self::getAllProbufByKey($arrStructs,$strType);
				}
			}
		}

		return self::$_arrProbufsTmpPool;
	}


	public static function clearProbufsTmpPool(){
		self::$_arrProbufsTmpPool = array();	
	}

	public function getTplContent($strDir,$strFileName){
		$strContent = file_get_contents($strDir.$strFileName);
		return $strContent;
	}

	static function getStructList(){
		return self::$_arrDefineStructsDetail;
	}

	static function getStructDetail($type){
		if(isset(self::$_arrDefineStructsDetail[$type])){
			return self::$_arrDefineStructsDetail[$type];
		}else{
			return '';	
		}
	}


	static function _formatProbufType($type){
		if('Res' == $type){
			return 'DataRes';
		}

		if('Req' == $type){
			return 'DataReq';
		}

		return $type;
	}

	static function getAllStructs($arrStructs){

				$arrCodes = array();
				//$strCodes =  self::NEW_LINE;
				$strCodes = ''; 
				foreach($arrStructs as $key => $arrParams){

					if(isset(self::$_arrTypesWhiteList[$key]) && 1 == self::$_arrTypesWhiteList[$key]){//ignore
						continue;
					}

					if(isset(self::$_commonStructs[$key]) && 1 == self::$_commonStructs[$key]){//ignore
						continue;
					}

							$strCodesTmp = '';

							$strMessageKey = self::_formatProbufType($key);

							$i_1 = 0;

							//$strCodesTmp 是为了把每一个元素，收敛到一个数组里，方便以后重新组合
							$strTmp = 'message '.$strMessageKey.' {';
							if('DataReq' == $strMessageKey){
								
								$strTmp = 'message '.$strMessageKey.' {';
								$strTmp .=  self::NEW_LINE;
								$strTmp .= self::NEW_TAB.'optional CommonReq common=1;';
								$i_1++;
							}

							if('DataRes' == $strMessageKey){
								
								$strTmp = 'message '.$strMessageKey.' {';
								$strTmp .=  self::NEW_LINE;
								$strTmp .= self::NEW_TAB.'optional Error error=1;';
								$i_1++;
							}



							$strCodesTmp.= $strTmp;
							$strCodes .= $strTmp;

							$strCodes .=  self::NEW_LINE;
							$strCodesTmp.= self::NEW_LINE;

							foreach($arrParams as $key_1 => $val_1){
								if(isset(self::$_arrTypesWhiteList[$val_1['type']]) && 1 == self::$_arrTypesWhiteList[$val_1['type']]){//ignore
									continue;
								}

								$i_1++;

								if(self::_isComplicatedType($val_1['type'])){
									self::$_arrDefineStructs[$val_1['type']] = $val_1['type'];
								}

								if(isset($val_1['attributes'][0]['params'][0]['type'])  && 'literal' == $val_1['attributes'][0]['params'][0]['type']){
									$strPre = 'repeated';
								}else{
									$strPre = 'optional';
								}

								$strTypeTmp = self::_formatType($val_1['type']);

								//字段名全部为驼峰式
								//原因： app/im 有一个坑， 如果字段名为_分隔， 在输出时会自动变为驼峰式
								//		 为了避免这个坑，所有全部改为驼峰式
								///////////////////////////////////////////////////////////////////////////////
								$strFieldName = self::_camelStyle($val_1['name']);
								///////////////////////////////////////////////////////////////////////////////

								if(1 == self::$_arrIgnoreFieldName[$strFieldName]){
									//pass
								}else{
									$strTmp = self::NEW_TAB.$strPre." ".$strTypeTmp." ".$strFieldName.'='.$i_1.';';
									$strCodesTmp .= $strTmp;
									$strCodes 	.= $strTmp;

									$strCodesTmp .= self::NEW_LINE;
									$strCodes .=  self::NEW_LINE;
								}
							}

							$strTmp = '}';
							$strCodesTmp .= $strTmp;
							$strCodes .= $strTmp;

							$strCodesTmp .= self::NEW_LINE;
							$strCodes .=  self::NEW_LINE;

							self::$_arrDefineStructsDetail[$key] = $strCodesTmp;
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
								
							}elseif(self::_isStringType($arrParamInfo['type'])){
								$strCodes .= str_repeat(self::NEW_TAB,3).'$arrPrivateInfo[\''.$arrParamInfo['name'].'\'] = strval($this->_getInput(\''.$arrParamInfo['name'].'\', ""));';

							}else{
								$strCodes .= str_repeat(self::NEW_TAB,3).'$arrPrivateInfo[\''.$arrParamInfo['name'].'\'] = $this->_getInput(\''.$arrParamInfo['name'].'\', 0);';
							
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



	static function _isComplicatedType($type){
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
		//默认不改驼峰，后续加上只有im的时候，才是驼峰//todo
		return $str;
    

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
				if(1 ==  $isInLoop){
					$strCodes .= str_repeat(self::NEW_TAB,2).'$arrTmp[\''.$arrParamInfo['name'].'\'] = intval($val["'.$arrParamInfo['name'].'"],0);';
				}else{
					$strCodes .= str_repeat(self::NEW_TAB,2).'$'.$strType.'[\''.$arrParamInfo['name'].'\'] = intval($'.self::_camelStyle($arrParamInfo['name']).',0);';
				}

			}elseif(self::_isStringType($arrParamInfo['type'])){
				if(1 ==  $isInLoop){
					$strCodes .= str_repeat(self::NEW_TAB,2).'$arrTmp[\''.$arrParamInfo['name'].'\'] = strval($val["'.$arrParamInfo['name'].'"],"");';
				}else{
					$strCodes .= str_repeat(self::NEW_TAB,2).'$'.$strType.'[\''.$arrParamInfo['name'].'\'] = strval($'.self::_camelStyle($arrParamInfo['name']).',"");';
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

	private static function _formatType($type){
		if('int64_t' == $type){
			return 'int64';
		}
		if('uint64_t' == $type){
			return 'uint64';
		}
		if('int32_t' == $type){
			return 'int32';
		}
		if('uint32_t' == $type){
			return 'uint32';
		}

		return $type;
	}
}

