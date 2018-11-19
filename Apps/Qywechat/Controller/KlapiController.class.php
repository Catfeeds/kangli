<?php
namespace Qywechat\Controller;
use Think\Controller;
use Think\WeChat;
class KlapiController extends BaseApiController {
    public function index(){
		$this->wechat->responseMsg();
    }
   	public function media_list_get(){
   		$ret=$this->wechat->getForeverList("news");
   		var_dump($ret);
   		exit;
   	}
}

