<?php
namespace Kangli\Controller;
use Think\Controller;
class ZhengceController extends CommController {
    //政策
    public function index(){
        $map['bas_unitcode']=$this->qy_unitcode;
        $Jfmobasic= M('Jfmobasic');
        $data=$Jfmobasic->where($map)->find();
        if($data){
        	$bas_profile=$data['bas_ppzc'];
        }else{
            $bas_profile='';
        }
       $this->assign('bas_content', $bas_profile);
       // $this->assign('bas_content','申请政策');
       $this->display('index');
    }
}