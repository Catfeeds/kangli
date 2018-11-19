<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2014 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用入口文件

//die();/
// 检测PHP环境
if(version_compare(PHP_VERSION,'5.3.0','<'))  die('require PHP > 5.3.0 !');
//物理根路径
define('BASE_PATH', dirname(__FILE__)) . DIRECTORY_SEPARATOR;
define('WWW_WEBROOT','/'); //该站点所在的目录 相对网站的根目录
// 开启调试模式 建议开发阶段开启 部署阶段注释或者设为false
define('APP_DEBUG',true);
// 定义应用目录
define('APP_PATH','./Apps/');
// 定义运行时目录
define('RUNTIME_PATH','./Runtime/');
//框架目录
define('THINK_PATH',realpath('./Tp').'/');
// 引入ThinkPHP入口文件
require THINK_PATH.'ThinkPHP.php';
ini_set("session.save_handler", "user");
// 亲^_^ 