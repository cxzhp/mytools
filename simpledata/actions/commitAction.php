<?php
/**
 * @copyright Copyright (c) www.baidu.com
 * @author forum
 * @date 2013-01-05 14:23:53
 * @version
 */
class commitAction extends Util_Actionbase{


	function init(){
		self::setUiAttr('COMMIT_UI');
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

		$strAccord   = trim(Bingo_Http_Request::get("accord",''));
		$strQuery   = trim(Bingo_Http_Request::get("query",''));
		$strKeyword  = urldecode(trim(Bingo_Http_Request::get("keyword",'')));
		$strKeyword  = Bingo_Encode::convert($strKeyword,Bingo_Encode::ENCODE_GBK ,Bingo_Encode::ENCODE_UTF8);
		$intMultiple = trim(Bingo_Http_Request::get("multiple",''));

		$arrQueryKey = array(
				'user_id'   ,
				'user_name' ,
				'forum_id'  ,
				'forum_name',
				);

		if(!in_array($strAccord,$arrQueryKey)){
			$this->_arrTplVar['errno']  = Tieba_Errcode::ERR_MO_PARAM_INVALID;
			$this->_arrTplVar['errmsg'] = 'error accord';
			return true;
		}
		if(empty($strKeyword)){
			$this->_arrTplVar['errno']  = Tieba_Errcode::ERR_MO_PARAM_INVALID;
			$this->_arrTplVar['errmsg'] = 'error keyword';
			return true;
		}



		if(1 == $intMultiple){
			if(strstr($strKeyword,"\n")){//支持每行一个的提交(回车符分隔)
				$arrKeyword = explode("\n",$strKeyword);	
			}else{
				$arrKeyword = explode(',',$strKeyword);	
			}

		}else{
			$arrKeyword = array($strKeyword);
		}

		$arrData = array();
		foreach($arrKeyword  as $tmpKeyword){
			$tmpKeyword = trim($tmpKeyword);
			if('user_id' == $strAccord && 'user_name' == $strQuery){
				$strUname  = Util_Userhandle::getUnameByUid($tmpKeyword);
				$arrData[] =  array('keyword'=>$tmpKeyword, 'text'=>$strUname);
			}elseif('user_name' == $strAccord && 'user_id' == $strQuery){
				$intUserId  = Util_Userhandle::getUidByUname($tmpKeyword);
				$arrData[] =  array('keyword'=>$tmpKeyword, 'text'=>$intUserId);
			}elseif('forum_name' == $strAccord && 'forum_id' == $strQuery){//Fname转Fid
				$intForumId = Util_Forumhandle::getFidByFname($tmpKeyword);
				$arrData[] =  array('keyword'=>$tmpKeyword, 'text'=>$intForumId);
			}elseif('forum_id' == $strAccord && 'forum_name' == $strQuery){//Fid转Fname
				$intForumId = $tmpKeyword;
				$strForumName = Util_Forumhandle::getFnameByBid($intForumId);
				$arrData[] =  array('keyword'=>$tmpKeyword, 'text'=>$strForumName);
			}else{
				$arrData[] =  array('keyword'=>$tmpKeyword, 'text'=>$strAccord.'_result_'.$tmpKeyword);
			}

		}

		$Data = $arrData;


		$this->_arrTplVar['errno'] = Tieba_Errcode::ERR_SUCCESS;
		$this->_arrTplVar['errmsg'] = 'success';
		$this->_arrTplVar['data'] = $Data;


		Bingo_Page::getView()->setOnlyDataType("json");
		Bingo_Page::setTpl("simpledata/Page.php");///home/forum/tieba-odp/template/mis/control/simpledata/Page.php
		return true;

	}

}

?>
