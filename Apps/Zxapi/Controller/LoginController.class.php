<?php
namespace Zxapi\Controller;
use Think\Controller;
class LoginController extends Controller {
    //APP调用接口 返回json格式
    public function index(){
        $username=trim(I('post.username',''));
        $pwd=trim(I('post.pwd',''));
		$imei=trim(I('post.imei',''));
        $autologin=intval(I('post.autologin',0));
        $qysu_purview='';	
        if($username=='' || $pwd==''){
            $msg=array('stat'=>'0','msg'=>'用户名或密码不能为空');
            echo json_encode($msg);
            exit;
        }
		if($imei==''){
            $msg=array('stat'=>'0','msg'=>'请授权允许读取本机识别码');
            echo json_encode($msg);
            exit;
		}

        if(!preg_match("/^[a-zA-Z0-9_:]{6,30}$/",$username)){
            $msg=array('stat'=>'0','msg'=>'用户名或密码有误');
            echo json_encode($msg);
            exit;
        }
		
		//是否有冒号 有冒号是新方式 没冒号是以前的方式 目前是兼容，迟点会取消以前方式
		if(strpos($username,':')===false){
			$qy_username='';
			$sub_username=$username;
		}else{
			$qy_username_arr=explode(":", $username);
			reset($qy_username_arr);
			$qy_username = current($qy_username_arr);
			$sub_username= end($qy_username_arr);
		}
		
		$qydata=array();
		if($qy_username!=''){
			$map=array();
			$map['qy_username']=$qy_username;
			$Qyinfo= M('Qyinfo');
			$qydata=$Qyinfo->where($map)->find();
			if($qydata){
				
			}else{
				$msg=array('stat'=>'0','msg'=>'用户名或密码有误');
				echo json_encode($msg);
				exit;
			}
		}

        $map=array();
        $map['su_username']=$sub_username;
		if($qydata){
			$map['su_unitcode']=$qydata['qy_code'];
		}
		$map['su_belong']=0;
        $Qysubuser = M('Qysubuser');
        $data=$Qysubuser->where($map)->find(); 
		$md5_su_pwd=MD5(MD5(MD5($pwd)));

		if($data){
			//根据记录的错误次数与时间判断是否暂时冻结 连续5次错误冻结20分钟
			if($data['su_errtimes']>=5){
				if((time()-$data['su_errlogintime'])<1200){
					$msg=array('stat'=>'0','msg'=>'由于连续多次输入错误，暂冻结登录，请等候20分钟后再登录');
					echo json_encode($msg);
					exit;
				}
			}
			
			if($qydata){
				$login_su_username=$qydata['qy_username'].':'.$data['su_username'];
			}else{
				$login_su_username=$data['su_username'];
			}
			
			
			if($data['su_pwd']==$md5_su_pwd){
				if($data['su_status']==1){
					$qysu_purview=$data['su_purview'];

					$ip=real_ip();
					$useragent=trim($_SERVER['HTTP_USER_AGENT']);
					
					$Applogin = M('Applogin');
					$map2=array();
					$map2['lg_username']=$login_su_username;
					$data2=$Applogin->where($map2)->find(); 
					$lg_time=time();
					$token=MD5($login_su_username.$imei.$useragent.$lg_time);
					if($autologin==1){
						$pwd_token=MD5($md5_su_pwd.$lg_time);
					}else{
						$pwd_token='';
					}
					
					
					if($data2){
						//更新登录状态
						$data3=array();
						$data3['lg_unitcode']=$data['su_unitcode'];
						$data3['lg_token']=$token;
						$data3['lg_imei']=$imei;
						$data3['lg_time']=$lg_time;
						$data3['lg_ip']=$ip;
						// $data3['lg_useragent']=$useragent;
						
						$Applogin->where($map2)->data($data3)->save();
					}else{
					   //增加登录状态
						$data3=array();
						$data3['lg_unitcode']=$data['su_unitcode'];
						$data3['lg_userid']=$data['su_id'];
						$data3['lg_username']=$login_su_username;
						$data3['lg_token']=$token;
						$data3['lg_imei']=$imei;
						$data3['lg_time']=$lg_time;
						$data3['lg_ip']=$ip;
						// $data3['lg_useragent']=$useragent;

						$Applogin->create($data3,1);
						$Applogin->add();
					}
					
					$data3=array();
					$data3['su_logintime']=$lg_time;
					$data3['su_errlogintime']=$lg_time;
					$data3['su_errtimes']=0;
					$Qysubuser->where($map)->data($data3)->save();
					
					//记录日志 begin
					$log_arr=array();
					$log_arr=array(
								'log_qyid'=>$data['su_id'],
								'log_user'=>$login_su_username,
								'log_qycode'=>$data['su_unitcode'],
								'log_action'=>'企业APP子用户登录',
								'log_type'=>1, //0-系统 1-企业 2-经销商 3-消费者
								'log_addtime'=>time(),
								'log_ip'=>real_ip(),
								'log_link'=>__SELF__,
								'log_remark'=>json_encode($data)
								);
					save_log($log_arr);
					//记录日志 end
					
					$msg=array('stat'=>'1','uname'=>$login_su_username,'upwd'=>$pwd_token,'utoken'=>$token,'uttamp'=>$lg_time,'qysu_purview'=>$qysu_purview,'msg'=>'登录成功');
					echo json_encode($msg);
					exit;
					
				}else{
					$msg=array('stat'=>'0','msg'=>'该用户还没审核或已禁用');
					echo json_encode($msg);
					exit;
				}
			}else{
				//记录错误次数与时间
				$map2=array();
				$date2=array();
				$map2['su_id']=$data['su_id'];
				$date2['su_errlogintime']=time();
				$date2['su_errtimes']=$data['su_errtimes']+1;
				$Qysubuser->where($map2)->data($date2)->save();
				
				$msg=array('stat'=>'0','msg'=>'用户名或密码有误');
				echo json_encode($msg);
				exit;
			}
			
			
		}else{
            $msg=array('stat'=>'0','msg'=>'用户名或密码有误');
            echo json_encode($msg);
            exit;
		}
    }
	
	//自动登录接口
	public function autologin(){
        $uname=trim(I('post.uname',''));
        $upwd=trim(I('post.upwd',''));
		$uttamp=trim(I('post.uttamp',''));
		$usture=trim(I('post.usture',''));
	 	$qysu_purview='';

        if($uname=='' || $upwd=='' || $uttamp=='' || $usture==''){
            $msg=array('stat'=>'0','msg'=>'自动登录失败');
            echo json_encode($msg);
            exit;
        }
		
		//是否有冒号 有冒号是新方式 没冒号是以前的方式 目前是兼容，迟点会取消以前方式
		if(strpos($uname,':')===false){
			$qy_username='';
			$sub_username=$uname;
		}else{
			$qy_username_arr=explode(":", $uname);
			reset($qy_username_arr);
			$qy_username = current($qy_username_arr);
			$sub_username= end($qy_username_arr);
		}
		
		$qydata=array();
		if($qy_username!=''){
			$map=array();
			$map['qy_username']=$qy_username;
			$Qyinfo= M('Qyinfo');
			$qydata=$Qyinfo->where($map)->find();
			if($qydata){
				
			}else{
				$msg=array('stat'=>'0','msg'=>'自动登录失败');
				echo json_encode($msg);
				exit;
			}
		}
		
        $map=array();
        $map['su_username']=$uname;
		if($qydata){
			$map['su_unitcode']=$qydata['qy_code'];
		}
		$map['su_belong']=0;
        $Qysubuser = M('Qysubuser');
        $data=$Qysubuser->where($map)->find(); 
        if($data){
			if($data['su_status']==1){
				if($qydata){
					$login_su_username=$qydata['qy_username'].':'.$data['su_username'];
				}else{
					$login_su_username=$data['su_username'];
				}
				$qysu_purview=$data['su_purview'];
				$Applogin = M('Applogin');
				$map2=array();
				$map2['lg_username']=$login_su_username;
				$data2=$Applogin->where($map2)->find(); 
				if($data2){
					if(MD5($data['su_pwd'].$data2['lg_time'])==$upwd){
						if((time()-$data2['lg_time'])<259200){
							if($usture==MD5($data2['lg_token'].$data2['lg_imei'].$uttamp)){
								$ip=real_ip();
								$useragent=trim($_SERVER['HTTP_USER_AGENT']);
								$lg_time=time();
								$token=MD5($login_su_username.$data2['lg_imei'].$useragent.$lg_time);
								$pwd_token=MD5($data['su_pwd'].$lg_time);
								
								$data3=array();
								$data3['lg_unitcode']=$data['su_unitcode'];
								$data3['lg_token']=$token;
								$data3['lg_time']=$lg_time;
								$data3['lg_ip']=$ip;
								// $data3['lg_useragent']=$useragent;
								
								$Applogin->where($map2)->data($data3)->save();
								
								$data3=array();
								$data3['su_logintime']=$lg_time;
								$data3['su_errlogintime']=$lg_time;
								$data3['su_errtimes']=0;
								$Qysubuser->where($map)->data($data3)->save();
								
								//记录日志 begin
								$log_arr=array();
								$log_arr=array(
											'log_qyid'=>$data['su_id'],
											'log_user'=>$login_su_username,
											'log_qycode'=>$data['su_unitcode'],
											'log_action'=>'企业APP子用户自动登录',
											'log_type'=>1, //0-系统 1-企业 2-经销商 3-消费者
											'log_addtime'=>time(),
											'log_ip'=>real_ip(),
											'log_link'=>__SELF__,
											'log_remark'=>json_encode($data2)
											);
								save_log($log_arr);
								//记录日志 end
								
								$msg=array('stat'=>'1','uname'=>$login_su_username,'upwd'=>$pwd_token,'utoken'=>$token,'uttamp'=>$lg_time,'qysu_purview'=>$this->qysu_purview,'msg'=>'自动登录成功');
								echo json_encode($msg);
								exit;
							}else{
								$msg=array('stat'=>'0','msg'=>'自动登录失败');
								echo json_encode($msg);
								exit;	
							}
						}else{
							$msg=array('stat'=>'0','msg'=>'自动登录失败');
							echo json_encode($msg);
							exit;
						}
					}else{
						$msg=array('stat'=>'0','msg'=>'自动登录失败');
						echo json_encode($msg);
						exit;
					}
				}else{
					$msg=array('stat'=>'0','msg'=>'自动登录失败');
					echo json_encode($msg);
					exit;
				}	
			}else{
				$msg=array('stat'=>'0','msg'=>'自动登录失败');
				echo json_encode($msg);
				exit;
			}
		}else{
			$msg=array('stat'=>'0','msg'=>'自动登录失败');
			echo json_encode($msg);
			exit;
		}

		
	}
}