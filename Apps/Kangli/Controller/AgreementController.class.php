<?php
namespace Kangli\Controller;
use Think\Controller;
class AgreementController extends CommController {
    public function index(){

        $map['bas_unitcode']=$this->qy_unitcode;
        $Jfmobasic= M('Jfmobasic');
        $data=$Jfmobasic->where($map)->find();
        if($data){
        	$bas_agreement=$data['bas_agreement'];
        }else{
            $bas_agreement='';
        }
     
       $this->assign('bas_content', $bas_agreement);
       $this->display('index');
    }


}