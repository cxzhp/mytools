<?php
/*==================================
*   Copyright (C) 2014 Baidu.com, Inc. All rights reserved.
*   
*   filename	:	%filename%
*   author		:	%author%
*   create_time	:	%create_time%
*   desc		:
*
===================================*/

class %action_name% extends Molib_Client_BaseAction {

		%codes_req%
		%codes_check_req%

    private function _returnErr($intErrno,$strErrmsg,$arrRet=array()){
        $this->_error($intErrno,$strErrmsg);
        $this->_objResponse->setOutData($arrRet);
        return false;
    }

	//method _errRet
	protected static function _errRet($errno,$errmsg=''){
		if(!empty($errmsg)){
			return array(       
				'error_code' => $errno,
				'error_msg' => $errmsg,
			);
		}else{
			return array(       
				'error_code' => $errno,
				'error_msg' => Tieba_Error::getErrmsg($errno),
			);
		}
	}

	protected function _execute() {

%code_logic_req%
		$intUserId 		= $this->_objRequest->getCommonAttr('user_id');

		//may be used
		/////////////////////////
		$intUserIp 		= $this->_objRequest->getCommonAttr('ip_int');

		$intClientType    = intval($this->_objRequest->getCommonAttr('client_type'));
		$strClientVersion = strval($this->_objRequest->getCommonAttr('client_version'));
		/////////////////////////
		$arrRet = array();

%service_call%

		$this->_returnErr(Tieba_Errcode::ERR_SUCCESS,Molib_Client_Error::getErrMsg(Tieba_Errcode::ERR_SUCCESS),$arrRet);
		return true;

	}

}
