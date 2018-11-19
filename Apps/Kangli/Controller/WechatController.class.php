<?php
namespace Kangli\Controller;
use Think\Controller;
class WechatController extends CommController {
    //关注微信
    public function index(){
        $map['bas_unitcode']=$this->qy_unitcode;
        $Jfmobasic= M('Jfmobasic');
        $data=$Jfmobasic->where($map)->find();
        if($data){
        	$bas_content=$data['bas_weixin'];
        }else{
            $bas_content='';
        }
     
        $this->assign('bas_content', $bas_content);

        $this->display('index');
    }


}