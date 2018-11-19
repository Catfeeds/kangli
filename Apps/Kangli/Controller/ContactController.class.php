<?php
namespace Kangli\Controller;
use Think\Controller;
class ContactController extends CommController {
    //联系我们
    public function index(){
        $map['bas_unitcode']=$this->qy_unitcode;
        $Jfmobasic= M('Jfmobasic');
        $data=$Jfmobasic->where($map)->find();
        if($data){
        	$bas_profile=$data['bas_contact'];
        }else{
            $bas_profile='';
        }
     
       $this->assign('bas_content', $bas_profile);
       $this->display('index');
    }


}