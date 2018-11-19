<?php
namespace Home\Behaviors;
class DenyipsBehavior extends \Think\Behavior{ 
    //禁用IP 行为
    public function run(&$params){
		$denyips = trim(S('denyips'));
		$denyiparr=array();
		if($denyips==false){
			$Denyip = M('Denyip');
			$res=$Denyip->select(); 
			foreach($res as $k=>$v){
				$denyiparr[$v['deny_ip']]=$v['deny_ip'];
			}
			if(is_not_null($denyiparr)){
				//写入缓存
				S('denyips',json_encode($denyiparr),array('type'=>'file','expire'=>3600000));
			}
			$denyips='';
		}
		if($denyips!=''){
			$denyiparr=json_decode($denyips,true); 
		}
		$uip=trim(I('param.ip',''));
		
		if($uip==''){
			$uip=real_ip();
		}else{
			if(strpos(strtolower(__SELF__),'fwapi')=== false){
				$uip=real_ip();
			}
		}
		if($uip!=''){
			if(!isset($denyiparr['127.0.0.1'])){
				if(isset($denyiparr[$uip])){
					@header('HTTP/1.1 403 Forbidden'); 
					exit;
				}
			}
		}
		
		if(strpos(strtolower(__SELF__),'fwapi')=== false){
			$uip=get_client_ip();
            if(!isset($denyiparr['127.0.0.1'])){
				if(isset($denyiparr[$uip])){
					@header('HTTP/1.1 403 Forbidden'); 
					exit;
				}
			}
		}
    }
}

