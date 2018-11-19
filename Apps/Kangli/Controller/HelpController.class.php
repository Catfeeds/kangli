<?php
namespace Kangli\Controller;
use Think\Controller;
class HelpController extends CommController {
    public function index(){

        $map['bas_unitcode']=$this->qy_unitcode;
        $Jfmobasic= M('Jfmobasic');
        $data=$Jfmobasic->where($map)->find();
        if($data){
        	$bas_help=$data['bas_help'];
        }else{
            $bas_help='';
        }
     
       $this->assign('bas_content', $bas_help);
       $this->display('index');
    }


}