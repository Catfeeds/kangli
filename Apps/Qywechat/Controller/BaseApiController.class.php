<?php
namespace Qywechat\Controller;
use Think\Controller;
use Think\WeChat;
// import('Qywechat.Controller.WeChat');
// require './Qywechat/Controller./WeChat.class.php';
define('APPID','wx095fd9abec109fc1');
define('APPSECRET','fe5c8e772b252bc04a09e64603848e74');
define('TOKEN','kangli_msfw');
//
define('APPKEY','4dbcade2238b47eab5bd2f9b7581c613'); //图灵机器人appkey
class BaseapiController extends Controller {
   	protected $wechat;
    public function _initialize()
    {
       $this->wechat = new WeChat(APPID,APPSECRET,TOKEN,APPKEY);
    }
}

