<?php
namespace Qywechat\Controller;
use Think\Controller;
use Think\WeChat;
class MenuController extends BaseApiController {
protected $menu = <<<JSON
{
    "button": [
        {
            "name": "官网",
            "key":"M_01",
            "type": "view",
            "url": "http://www.baibangma.com/"
        },
        {
           "name": "代理后台",
            "type": "view",
            "key":"M_02",
            "url" : "http://www.baibangma.com/kangli/",
            "sub_button": []
        },
    ]
}
JSON;
/**
 * <<<  定界符号  内容定界符号;表示“内容” 代表原本字符串内容，直接把"内容"直接解析成字符串。定界符合前边不能有任何空格。内容部分单独成行。
 * 1、以<<<End开始标记开始，以End结束标记结束，结束标记必须顶头写，不能有缩进和空格，且在结束标记末尾要有分号 。开始标记和开始标记相同，比如常用大写的EOT、EOD、EOF来表示，但是不只限于那几个，只要保证开始标记和结束标记不在正文中出现即可。
 * 2.位于开始标记和结束标记之间的变量可以被正常解析，但是函数则不可以。在heredoc中，变量不需要用连接符.或,来拼接
*/
    public function index(){
        $result =$this->wechat->menuSet($this->menu); //创建菜单
        var_dump($result);
    }
    public function menu_del(){
        $result =$this->wechat->menuDelete(); //删除菜单
        var_dump($result);
    }
 }