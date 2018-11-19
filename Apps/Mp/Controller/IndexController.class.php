<?php
namespace Mp\Controller;
use Think\Controller;
class IndexController extends CommController {
    public function index(){
		//已发货订单 15天前已发货的默认为已收货状态
		$Model=M();
		$map=array();
		$map['a.od_unitcode']=session('unitcode');
		$map['a.od_state']=3;
		$map['od_expressdate']=array('lt',time()-3600*24*15); //发货时间
		$map['a.od_id']=array('exp','=b.odbl_odid');
		$map['a.od_oddlid']=array('exp','=b.odbl_oddlid');
		
		$list = $Model->table('fw_orders a,fw_orderbelong b')->where($map)->order('a.od_expressdate ASC')->limit(100)->select();
		
		$Orders = M('Orders');
		$Orderbelong = M('Orderbelong');
		foreach($list as $k=>$v){
				$map2=array();
				$map2['od_unitcode']=session('unitcode');
				$map2['od_oddlid']=$v['od_oddlid'];
				$map2['od_id']=$v['od_id'];
				
				$updata2=array();
				$updata2['od_state']=8;
				$Orders->where($map2)->save($updata2);
				
				$map2=array();
				$updata2=array();
				$map2['odbl_unitcode']=session('unitcode');
				$map2['odbl_odid']=$v['od_id'];
				$updata2['odbl_state']=8;
				$Orderbelong->where($map2)->save($updata2);
				
				//解冻返利
				//预付款 余额 设 有效
				$Yufukuan= M('Yufukuan');
				$Balance= M('Balance');
				
				//解冻返利
				$map2=array();
				$updata2=array();
				$map2['yfk_unitcode']=session('unitcode');
				$map2['yfk_type']=2;
				$map2['yfk_oddlid']=$v['od_oddlid'];
				$map2['yfk_odid']=$v['od_id'];
				$updata2['yfk_state']=1;
				$Yufukuan->where($map2)->save($updata2);
				
				//解冻款项
				$map2=array();
				$updata2=array();
				$map2['bl_unitcode']=session('unitcode');
				$map2['bl_type']=2;
				$map2['bl_sendid']=$v['od_oddlid'];
				$map2['bl_odid']=$v['od_id'];
				$updata2['bl_state']=1;
				$Balance->where($map2)->save($updata2);

				//预付款 余额 设 有效 end
				//解冻返利 end
				
				
				//订单操作日志 begin
				$odlog_arr=array(
							'odlg_unitcode'=>session('unitcode'),  
							'odlg_odid'=>$v['od_id'],
							'odlg_orderid'=>$v['od_orderid'],
							'odlg_dlid'=>0,
							'odlg_dlusername'=>'',
							'odlg_dlname'=>'',
							'odlg_action'=>'系统确认收货',
							'odlg_type'=>0, //0-企业 1-经销商
							'odlg_addtime'=>time(),
							'odlg_ip'=>real_ip(),
							'odlg_link'=>__SELF__
							);
				$Orderlogs = M('Orderlogs');
				$rs3=$Orderlogs->create($odlog_arr,1);
				if($rs3){
					$Orderlogs->add();
				}
				//订单操作日志 end
		}
		//待审经销商
		$daishenjxs='';
		if($this->check_qypurview('10001',0)){
			$map=array();
			$map['dl_unitcode']=session('unitcode');
			$map['dl_status']=0;
            $Dealer = M('Dealer');
            $count = $Dealer->where($map)->count();
			if($count){
				$daishenjxs=$count;
			}else{
				$daishenjxs=0;
			}
		}
		$this->assign('daishenjxs', $daishenjxs);

		
		//待处理订单
		$daichuliorders='';
		if($this->check_qypurview('13002',0)){
			$map=array();
			$map['od_unitcode']=session('unitcode');
			$map['od_state']=array('in','0,1,2');
			// $map['od_rcdlid']=0;//下给公司的订单
            $Orders=M('Orders');
			$count = $Orders->where($map)->count();
			if($count){
				$daichuliorders=$count;
			}else{
				$daichuliorders=0;
			}
		}
		$this->assign('daichuliorders', $daichuliorders);
		//待处理返利
		$daichulifanli='';
		if($this->check_qypurview('14003',0)){
			$map=array();
			$map['rc_unitcode']=session('unitcode');
			$map['rc_sdlid']=0;
			$map['rc_state']=0;
            $Recash = M('Recash');
            $count = $Recash->where($map)->count();
			if($count){
				$daichulifanli=$count;
			}else{
				$daichulifanli=0;
			}
		}
		$this->assign('daichulifanli', $daichulifanli);
		
		//待处理提现
		$daichulitixian='';
		if($this->check_qypurview('18006',0)){
			$map=array();
			$map['rc_unitcode']=session('unitcode');
			$map['rc_sdlid']=0;
			$map['rc_state']=0;
            $Recash = M('Recash');
            $count = $Recash->where($map)->count();
			if($count){
				$daichulitixian=$count;
			}else{
				$daichulitixian=0;
			}
		}
		$this->assign('daichulitixian', $daichulitixian);
		
		//待处理充值
		$daichulichongzhi='';
		if($this->check_qypurview('18007',0)){
			$map=array();
			$map['pi_unitcode']=session('unitcode');
			$map['pi_state']=0;

            $Payin = M('Payin');
            $count = $Payin->where($map)->count();
			if($count){
				$daichulichongzhi=$count;
			}else{
				$daichulichongzhi=0;
			}
		}
		$this->assign('daichulichongzhi', $daichulichongzhi);
		
		//待处理兑换
		$daichuliduihuan='';
		if($this->check_qypurview('15002',0)){
			$map=array();
			$map['exch_unitcode']=session('unitcode');
			$map['exch_state']=array('in','0,1');

            $Dljfexchange = M('Dljfexchange');
            $count = $Dljfexchange->where($map)->count();
			if($count){
				$daichuliduihuan=$count;
			}else{
				$daichuliduihuan=0;
			}
		}
		$this->assign('daichuliduihuan', $daichuliduihuan);
		
		//待处理留言
		$daichuliliuyan='';
		if($this->check_qypurview('70009',0)){
			$map=array();
			$map['fb_unitcode']=session('unitcode');
			$map['fb_state']=0;

            $Jffeedback = M('Jffeedback');
            $count = $Jffeedback->where($map)->count();
			if($count){
				$daichuliliuyan=$count;
			}else{
				$daichuliliuyan=0;
			}
		}
		$this->assign('daichuliliuyan', $daichuliliuyan);
		
		
        $this->display('index');
    }

    //修改密码
    public function updatepwd(){
        $map['qy_id']=intval(session('qyid'));
        $map['qy_code']=session('unitcode');
        $Qyinfo= M('Qyinfo');
        $data=$Qyinfo->where($map)->find();
        if($data){

        }else{
            $this->error('没有该记录');
        }
    
        $this->assign('dealerinfo', $data);
        $this->assign('curr', 'updatepwd');
        $this->assign('atitle', '确认修改');

        $this->display('updatepwd');
    }

    public function updatepwd_save(){
        if (!IS_POST) {
             header('HTTP/1.0 404 Not Found');
             echo'error:404';
             exit;
        }
        $map['qy_id']=intval(session('qyid'));
        $map['qy_code']=session('unitcode');
        
        if($map['qy_id']>0){
            //修改保存
            $old_pwd=I('post.old_pwd','');
            $pwd1=I('post.pwd1','');
            $pwd2=I('post.pwd2','');

            if($old_pwd=='' || $pwd1=='' || $pwd2==''){
                $this->error('密码不能为空！','',2);
            }
            if($pwd1!=$pwd2){
                $this->error('两新密码不相同！','',2);
            }
            $md5_qy_pwd=MD5(MD5(MD5($old_pwd)));
            $Qyinfo= M('Qyinfo');
            $data=$Qyinfo->where($map)->find();
            if($data){
            	if($data['qy_pwd']==$md5_qy_pwd){
                    $updata['qy_id']=$map['qy_id'];
                    $updata['qy_code']=$map['qy_code'];
                    $updata['qy_pwd']=MD5(MD5(MD5(trim($pwd1))));

                    $rs=$Qyinfo->create($updata,2);
                    if($rs){
		                $result = $Qyinfo->save(); 
		                if($result){
		                    //记录日志 begin
		                    $log_arr=array(
		                                'log_qyid'=>session('qyid'),
		                                'log_user'=>session('qyuser'),
		                                'log_qycode'=>session('unitcode'),
		                                'log_action'=>'修改密码',
		                                'log_addtime'=>time(),
		                                'log_ip'=>real_ip(),
		                                'log_link'=>__SELF__,
		                                'log_remark'=>json_encode($updata)
		                                );
		                    save_log($log_arr);
		                    //记录日志 end
		                     $this->success('修改成功',U('Mp/Index/index'),2);
		               }else{
		                   $this->error('修改失败','',2);
		                }
		            }else{
		                $this->error('修改失败','',2);
		            }
            	}else{
                    $this->error('输入旧密码不正确！','',2);
            	}

            }else{
            	$this->error('登录超时，请重新登录操作！',U('Mp/Login/index'),2);
            }
        }
    }
}
//=================================end