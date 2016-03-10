<?php
/**
 * @copyright Copyright (c) www.baidu.com
 * @author forum
 * @date 2013-01-05 14:23:53
 * @version
 */
class indexAction extends Util_Actionbase{


	function init(){
		self::setUiAttr('BROWSE_UI');
		if (false === parent::init()){
			if(0 === $this->_intErrorNo){
				$this->_intErrorNo  = Tieba_Errcode::ERR_MO_PARAM_INVALID;
				$this->_strErrorMsg = "init return error!";
				Bingo_Log::warning($this->_strErrorMsg);
			}
		}
		return true;
	}

	public function process(){       

		$strCurUserName = Util_Actionbaseext::getCurUserName();//如 返回值为 zhouping01
		$intCurUserId   = Util_Actionbaseext::getCurUserId();//如 返回值为 63851
		$intCurUserIp   = Util_Actionbaseext::getUserIp();//如返回值为 1536956076
		
		//Service_Mis:call();

		$this->_arrTplVar['content'] = 'hello world';

		Bingo_Page::setTpl("simpledata.php");// /home/work/orp001/template/mis/control/simpledata.php
        return true;

	}

}

?>
