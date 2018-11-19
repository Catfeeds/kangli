<?php
namespace Sysadmin\Controller;
use Think\Controller;
//禁止ip
class DenyipController extends CommController {
    //列表
    public function index(){
        if (IS_POST) {
            $dip=I('post.dip','');
        }else{
            $dip=I('get.dip','');
        }
        if($dip!=''){
            if(!preg_match("/^[0-9.]{4,20}$/",$dip)){
                $this->error('请正确输入IP','',1);
            }
        }

        $Denyip = M('Denyip');
        $parameter=array();
        if($dip!=''){
            $map['deny_ip']=array('LIKE',''.$dip.'%');
            $parameter['dip']=urlencode($dip);
        }
        $count = $Denyip->where($map)->count();
        $Page = new \Think\Page($count, 100,$parameter);
        $show = $Page->show();
        $list = $Denyip->where($map)->order('deny_ip ASC')->limit(($Page->firstRow . ',') . $Page->listRows)->select();
		

        
        $this->assign('curr', 'denyip');
        $this->assign('list', $list);
        $this->assign('dip', $dip);
        $this->assign('page', $show);
		$this->assign('pagecount', $count);
        $this->display('index');
    }
	
    //添加
    public function add(){
        if (IS_POST){
            $action=I('post.action','');
        }else{
            $action='';
        }
        if($action=='save'){
			$deny_ip=I('post.deny_ip','');
			$deny_remark=I('post.deny_remark','');


			if(!preg_match("/^[0-9.]{4,20}$/",$deny_ip)){
				$this->error('请正确输入IP','',1);
			}
			
			$map['deny_ip']=$deny_ip;
            $Denyip= M('Denyip');
            $data2=$Denyip->where($map)->find();
			if($data2){
				$this->error('该IP已存在','',1);
			}


			//记录
			$data=array();
			$data['deny_ip']=$deny_ip;
			$data['deny_remark']=$deny_remark;

			$rs=$Denyip->create($data,1);
			if($rs){
			   $result = $Denyip->add(); 
			   if($result){
					//记录日志 begin
					$log_arr=array(
							'log_qyid'=>0,
							'log_user'=>session('admin_name'),
							'log_qycode'=>'',
							'log_action'=>'添加禁止IP',
							'log_addtime'=>time(),
							'log_ip'=>real_ip(),
							'log_link'=>__SELF__,
							'log_remark'=>json_encode($data)
							);
				   save_log($log_arr);
				   //记录日志 end

				   $this->success('添加成功',U('Sysadmin/Denyip/index'),1);
			   }else{
				   $this->error('添加失败','',1);
			   }
			}else{
				$this->error('添加失败','',1);
			}
        }else{
			$this->assign('curr', 'denyip');
			$this->display('add');  

        }
    }


    //删除
    public function del(){
        $map['deny_id']=intval(I('get.id',0));
        $Denyip= M('Denyip');
        $data=$Denyip->where($map)->find();
        
        if($data){
            $Denyip->where($map)->delete(); 

            //记录日志 begin
            $log_arr=array(
                    'log_qyid'=>0,
                    'log_user'=>session('admin_name'),
                    'log_qycode'=>'',
                    'log_action'=>'删除禁止IP',
                    'log_addtime'=>time(),
                    'log_ip'=>real_ip(),
                    'log_link'=>__SELF__,
                    'log_remark'=>json_encode($data)
                    );
            save_log($log_arr);
           //记录日志 end
            $this->success('删除成功',U('Sysadmin/Denyip/index'),1);
        }else{
            $this->error('没有该记录','',1);
        }     
    
    }
	
	public function ipcache(){
		$Denyip = M('Denyip');
		$res=$Denyip->select(); 
		$denyiparr=array();
		foreach($res as $k=>$v){
			$denyiparr[$v['deny_ip']]=$v['deny_ip'];
		}
		if(is_not_null($denyiparr)){
			//写入缓存
			S('denyips',json_encode($denyiparr),array('type'=>'file','expire'=>3600000));
		}
		
		$this->success('刷新成功',U('Sysadmin/Denyip/index'),1);
	}
	
    //================================================================

}