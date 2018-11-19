<?php
$_SERVER['HTTP_VERSION']!=''?$version=$_SERVER['HTTP_VERSION']:$version='v1';
return array(
	 //系统信息相关
    'appbaseinfo'=> [
        'URL_HTML_SUFFIX'       =>  '',  // URL伪静态后缀设置
        'QY_APPNAME'  => 'kangli', // 企业名称
        'QY_UNITCODE'  => '9999', // 企业编号
        'QY_COMPANY'  => '康利科技', //企业名称
        'QY_FWKEY'  => '649beSeQOYDEVvZkFFwKS9mNeJuVhzIvsIKHKGRx0Au6', // 企业查询key
        'QY_FWSECRET'  => '7fd27e62f3c85cc089c1f8ba27d2168d156dd9565b10ab8da8a23039c67fe5c3', // 企业查询key
        'QY_MPWXAPPID'  => 'wx4a12f763b38355df', //小程序appid
        'QY_MPWXAPPSECRET'  => 'bb56a148e28b3e4be10d4277e234c264', //小程序的appsecret
        'QY_GZGONGZHONG'  => '', // 关注公众号链接
        'QY_KLMPWXAPPID'  => 'wx4a12f763b38355df', // 康利小程序appid
        'QY_KLMPWXAPPSECRET'  => 'bb56a148e28b3e4be10d4277e234c264', // 康利小程序appsecret
        'IS_ONLYWEIXIN'  => 1, // 是否只微信打开
        'SHARE_TITLE'  => '广州康利科技有限公司代理授权申请', // 分享页面TITLE
        'SHARE_DESC'  => '邀请您成为代理', // 分享页面简要
        'FANLI_RECASH'  => 100, // 提现最低额度
        'FANLI_JIANGETIME'  => 15, // 提现间隔时间天
        'FANLI_BANKS'  => array(1=>'中国银行',2=>'中国建设银行',3=>'中国工商银行',4=>'中国农业银行',5=>'中国招商银行',6=>'中国农村信用社',7=>'支付宝',8=>'微信'), //返利发放银行
        'WWW_AUTHKEY'  => '9da23Zx65dS9d40Gc1Ke02cHe5b72Rsc', // 通用加密串
    ],
	
 	'MODULE_ALLOW_LIST' => array('Klapi','Common'),  
     'DEFAULT_MODULE'       =>    'Klapi',  // 默认模块  
     'DEFAULT_CONTROLLER'    =>  'Api', // 默认控制器名称  
     'DEFAULT_ACTION'        =>  'index', // 默认操作名称  
     //路由规则  
    'URL_ROUTER_ON' => TRUE, 
    'URL_ROUTE_RULES'=>array(  
    	$version.'$'=>'Api/index',  
  		$version.'/mpwx'=>'Api/index',
        $version.'/upload'=>'Index/uploadimg', //上传
        $version.'/verify'=>'Query/verify', //验证码
    ),  

    //缓存
    'DATA_CACHE_KEY'=>'klmpwxcache',
    
    // 系统默认的变量过滤机制
    'DEFAULT_FILTER'        => 'htmlspecialchars'
    
);