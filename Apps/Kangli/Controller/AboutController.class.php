<?php
namespace Kangli\Controller;
use Think\Controller;
class AboutController extends CommController {
    //公司简介
    public function index(){
        $map['bas_unitcode']=$this->qy_unitcode;
        $Jfmobasic= M('Jfmobasic');
        $data=$Jfmobasic->where($map)->find();
        if($data){
        	$bas_profile=$data['bas_profile'];
        }else{
            $bas_profile='';
        }
       $this->assign('bas_content', $bas_profile);
       $this->display('index');
    }


}