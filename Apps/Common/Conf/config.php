<?php
return array(
	'SHOW_PAGE_TRACE' =>true,
	'DEFAULT_MODULE' => 'Kangli',
  'URL_HTML_SUFFIX' =>  '',  // URL伪静态后缀设置
	'DB_TYPE'  => 'mysql', // 数据库类型
    'DB_HOST'  => '127.0.0.1', // 服务器地址
    'DB_NAME'  => 'Kangli_db', // 数据库名
    // 'DB_USER'  => 'klwskjdb', // 用户名
    // 'DB_PWD'  => 'Klfe5weP0cfbG3gok', // 密码 
    'DB_USER'  => 'root', // 用户名
    'DB_PWD'  => 'root', // 密码aWM123456db
    'DB_PORT'  => 3306, // 端口
    'DB_PREFIX' => 'fw_', // 数据库表前缀缀
    'SESSION_OPTIONS'=>array('type'=> 'db', 'expire'=>36000), //session采用数据库保存 //session过期时间，如果不设就是php.ini中设置的默认值
    'SESSION_TABLE'=>'fw_session', //session 数据库表

    'TMPL_L_DELIM'          => '<{',        // 模板引擎普通标签开始标记
    'TMPL_R_DELIM'          => '}>',        // 模板引擎普通标签结束标记
    'WWW_AUTHKEY'  => '9da23Zx65dS9d40Gc1Ke02cHe5b72Rsc', // 通用加密串
    'API_AUTHKEY'  => 'zDf23Dg65dY8dxA9as6gKoh7dyrt3F67', // api验证 本地服api的
    'QY_FWDEKEY'   => 'ZdfgC567J3Dhuol08hE410gtpxyg9GrD', // 对企业fwkey机密的key
    'QY_FWSECRET'   =>'', // 通用fwsecret
    'PAGE_SIZE'  => 8, // 每页记录数
    'URL_MODEL'  => 2, //
    'SEND_MESSAGE'=>array('msg01'=>'您查询的防伪码为正牌产品,请放心使用!',  //防伪码正确 第一次查询
                          'msg02'=>'您所查询的防伪码已被查询过，首次查询时间：@rq@,此次是第@cs@次查询,请确认首次查询时间是否一致！',     //防伪正确 多次查询 
                          'msg03'=>'没有这个防伪码，谨防假冒或者重新核对输入。Be cautious if no anti-fake code here, or please check again.',     //防伪码错误 不存在
                          'msg04'=>'您好，您所查询的防伪码因已超出可查询次数已被冻结！谨防假冒! 或与公司客服人员联系!',      //防伪码正确 超过30次查询
                          'msg11'=>'您查詢的防偽碼為正牌產品,請放心使用!',  //防伪码正确 第一次查询 繁体
                          'msg12'=>'您所查詢的防偽碼已被查詢過，首次查詢時間：@rq@,此次是第@cs@次查詢,請確認首次查詢時間是否壹致！',     //防伪正确 多次查询 ！
                          'msg13'=>'沒有這個防偽碼，謹防假冒或者重新核對輸入。Be cautious if no anti-fake code here, or please check again.',     //防伪码错误 不存在
                          'msg14'=>'您好，您所查詢的防偽碼因已超出可查詢次數已被凍結！謹防假冒! 或與公司客服人員聯系!'     //防伪码正确 超过30次查询

                          ),
	'FANLI_TYPE'  => array(1=>'推荐返利',2=>'订单返利',3=>'销售累计奖',4=>'按月销售奖',5=>'年度销售奖',11=>'提现减少返利'), // 1-推荐返利 2-订单返利  11-提现减少返利 (1-10 增加返利 11-20 减少返利) 
	'FANLI_BANKS'  => array(1=>'中国银行',2=>'中国建设银行',3=>'中国工商银行',4=>'中国农业银行',5=>'中国招商银行',6=>'中国农村信用社',7=>'支付宝',8=>'微信'), //返利发放银行
  'FANLI_RECASH'  => 100, // 提现最低额度
  'FANLI_JIANGETIME'  =>30, // 提现间隔时间天
);