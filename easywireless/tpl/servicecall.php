//Molib_Tieba_Service:call
$strServiceName = '%service_name%';
$strMethod = '%method_name%';

$arrInput = array(
%arr_input%
);

// 打印日志 记录传递给Service内容
Bingo_Log::debug(sprintf('talk to servicename:[%s] method:[%s] input:[%s] ',$strServiceName,$strMethod, serialize($arrInput) ) );

//和service交互
Bingo_Timer::start($strServiceName."_".$strMethod);
$arrOutput = Molib_Tieba_Service::call($strServiceName,$strMethod, $arrInput);
Bingo_Timer::end($strServiceName."_".$strMethod);

if (false === $arrOutput ) {
	Bingo_Log::fatal(sprintf('Failed to call servicename:[%s] method:[%s][user_name:%s]',	$strServiceName,$strMethod, serialize($arrInput) ));
	$this->_returnErr(Tieba_Errcode::ERR_SUCCESS, Molib_Client_Error::getErrMsg(Tieba_Errcode::ERR_SUCCESS),$arrOutput);
	return true;
}

//check err_no
if ( isset($arrOutput['errno']) && (0 == intval($arrOutput['errno'])) ) {

	//success  -----//
	$arrRet = $arrOutput['data'];
	if(empty($arrOutput['data'])){
		Bingo_Log::warning(sprintf('err return data.  call servicename:[%s] method:[%s] [input:%s] [output:%s]',$strServiceName,$strMethod,serialize($arrInput),serialize($arrOutput)));
		$arrRet = array();	
	}

	//code_res
	//////////////////////////////
	%code_res%
	//////////////////////////////

	$this->_returnErr(Tieba_Errcode::ERR_SUCCESS, Molib_Client_Error::getErrMsg(Tieba_Errcode::ERR_SUCCESS),$arrRet);

	return true;
	//----- success //

} else {
	//err,print log
	Bingo_Log::fatal(sprintf('Err to call servicename:[%s] method:[%s] [input:%s] [output:%s]',$strServiceName,$strMethod,serialize($arrInput),serialize($arrOutput)));
	$this->_returnErr($arrOutput['errno'],Molib_Client_Error::getErrMsg($arrOutput['errno']));
	return true;
}

