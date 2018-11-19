<?php
namespace Mp\Controller;
use Think\Controller;
class LoginController extends Controller {
    public function index(){
		
        $ttamp2=time();
		$sture2=MD5('Zxfw2fgthlk895jk'.$ttamp2);
		$this->assign('ttamp', $ttamp2);
		$this->assign('sture', $sture2);
        $this->display('index');
    }

    public function verify(){
        $config = array(
                        'fontSize' =>22, // 验证码字体大小    
                        'length' => 1, // 验证码位数
                        'useNoise' => true, // 关闭验证码杂点
                        'useImgBg' => false, //是否使用背景图片
                        'imageW' => 150,
                        'imageH' => 50,
                        'useNoise' => true,
                       );
        $verify = new \Think\Verify($config);
        $verify->entry();
        exit;
    }

    public function logining(){
		$ttamp=trim(I('post.ttamp',''));
		$sture=trim(I('post.sture',''));

		$nowtime=time();
		if(MD5('Zxfw2fgthlk895jk'.$ttamp)!=$sture){
			$this->error('操作超时,请重试',U('Mp/Login/index'),2);
		}
		if(($nowtime - $ttamp) > 600) {
			$this->error('操作超时,请重试',U('Mp/Login/index'),2);
		}
	
	
        $qy_username=I('post.username','');
        $checkcode=I('post.checkcode','');
        $qy_pwd=I('post.pwd','');
        if($qy_username=='' || $qy_pwd==''){
                $this->error('用户名或密码不能为空','',2);
        }
        
        if($checkcode==''){
            $this->error('验证码不能为空','',2);
        }else{
            $verify = new \Think\Verify();
            if(!($verify->check($checkcode))){
                $this->error('验证码不正确','',2);
            }
        }

        if(!preg_match("/^[a-zA-Z0-9_:]{4,30}$/",$qy_username)){
        	$this->error('用户名或密码有误！','',2);
        }
		
		//是否子用户登录
		if(strpos($qy_username,':')===false){
			$qy_username2=$qy_username;
			$qy_subusername2='';
		}else{
			$qy_username_arr=explode(":", $qy_username);
			reset($qy_username_arr);
			$qy_username2 = current($qy_username_arr);
			$qy_subusername2= end($qy_username_arr);
		}
		
		$map['qy_username']=$qy_username2;
        $md5_qy_pwd=MD5(MD5(MD5($qy_pwd)));
//        dump( $md5_qy_pwd);die();
        $qiye_check=MD5($md5_qy_pwd.time());
		
        $Qyinfo= M('Qyinfo');
        $data=$Qyinfo->where($map)->find();
        if($data){
			//判断用哪个后台管理
			if($data['qy_admindir']!=1){
				$this->error('登录有误','',2);
			}
			
			
			if($qy_subusername2==''){
				
				//根据记录的错误次数与时间判断是否暂时冻结 连续5次错误冻结20分钟
				if($data['qy_errtimes']>=5){
					if((time()-$data['qy_logintime'])<1200){
						$this->error('由于连续多次输入错误，暂冻结登录，请等候20分钟后再登录','',3);
					}
				}
				
				if($data['qy_pwd']==$md5_qy_pwd){

					if($data['qy_active']==1){

						$qy_purview_arr=array();
						$purview_arr=array();
						$qy_purview=$data['qy_purview'];
						if(is_not_null($qy_purview)){
							$qy_purview_arr=explode(",", $qy_purview);
							foreach($qy_purview_arr as $k =>$v){
								$purview_arr[$v]=$v;
							}
							$purview_arr[99999]=99999;
						
						}else{
							$purview_arr=array();
						}

						session('qyid',$data['qy_id']);
						session('qyuser',$data['qy_username']);
						session('unitcode',$data['qy_code']);
						session('qyname',$data['qy_name']);
						session('qiye_check',$qiye_check);
						session('qy_purview',$purview_arr);
						session('qypic',$data['qy_pic']);

						cookie('qiye_check',$qiye_check,36000);

						//记录日志 begin
						$log_arr=array(
									'log_qyid'=>session('qyid'),
									'log_user'=>session('qyuser'),
									'log_qycode'=>session('unitcode'),
									'log_action'=>'企业登录',
									'log_type'=>1, //0-系统 1-企业 2-经销商 3-消费者
									'log_addtime'=>time(),
									'log_ip'=>real_ip(),
									'log_link'=>__SELF__,
									'log_remark'=>''
									);
						save_log($log_arr);
						//记录日志 end
						
						//改变登录错误次数与时间
						$map2=array();
						$date2=array();
						$map2['qy_id']=$data['qy_id'];
						$date2['qy_logintime']=time();
						$date2['qy_errtimes']=0;
						$Qyinfo->where($map2)->data($date2)->save();
						
						$this->redirect('Mp/Index/index','' , 0, '');
					}else{
						$this->error('该用户已禁用','',2);
					}

				}else{
					//记录错误次数与时间
					$map2=array();
					$date2=array();
					$map2['qy_id']=$data['qy_id'];
					$date2['qy_logintime']=time();
					$date2['qy_errtimes']=$data['qy_errtimes']+1;
					$Qyinfo->where($map2)->data($date2)->save();
					
					$this->error('用户名或密码有误！','',2);
				}
       
		    }else{  //如果是子用户登录
			    $map2=array();
				$map2['su_username']=$qy_subusername2;
				$map2['su_unitcode']=$data['qy_code'];
				$map2['su_belong']=0;

				$Qysubuser= M('Qysubuser');
				$data2=$Qysubuser->where($map2)->find();
				if($data2){
					//根据记录的错误次数与时间判断是否暂时冻结 连续5次错误冻结20分钟
					if($data2['su_errlogintime']>=5){
						if((time()-$data2['qy_logintime'])<1200){
							$this->error('由于连续多次输入错误，暂冻结登录，请等候20分钟后再登录','',3);
						}
					}
					
		            if($data2['su_pwd']==$md5_qy_pwd){
						if($data2['su_status']==1){
							$qy_purview_arr=array();
							$purview_arr=array();
							$qy_purview=$data2['su_purview'];
							if(is_not_null($qy_purview)){
								$qy_purview_arr=explode(",", $qy_purview);
								foreach($qy_purview_arr as $k =>$v){
									$purview_arr[$v]=$v;
								}
							}else{
								$purview_arr=array();
							}

							session('qyid',$data['qy_id']);
							session('qyuser',$data['qy_username'].':'.$data2['su_username']);
							session('unitcode',$data['qy_code']);
							session('qyname',$data['qy_name']);
							session('qiye_check',$qiye_check);
							session('qy_purview',$purview_arr);
							session('qypic',$data['qy_pic']);

							cookie('qiye_check',$qiye_check,36000);

							//记录日志 begin
							$log_arr=array(
										'log_qyid'=>session('qyid'),
										'log_user'=>session('qyuser'),
										'log_qycode'=>session('unitcode'),
										'log_action'=>'企业子用户登录',
										'log_type'=>1, //0-系统 1-企业 2-经销商 3-消费者
										'log_addtime'=>time(),
										'log_ip'=>real_ip(),
										'log_link'=>__SELF__,
										'log_remark'=>''
										);
							save_log($log_arr);
							//记录日志 end
							
							//改变登录错误次数与时间
							$map3=array();
							$date3=array();
							$map3['su_id']=$data2['su_id'];
							$map3['su_unitcode']=$data['qy_code'];
							
							$date3['su_errlogintime']=time();
							$date3['su_logintime']=time();
							$date3['su_errtimes']=0;
							$Qysubuser->where($map3)->data($date3)->save();
							
							$this->redirect('Mp/Index/index','' , 0, '');
							
						}else{
							$this->error('该用户已禁用','',2);
							exit;
						}
					}else{
						//记录错误次数与时间
						$map3=array();
						$date3=array();
						$map3['su_id']=$data2['su_id'];
						$map3['su_unitcode']=$data['qy_code'];
						$date3['su_errlogintime']=time();
						$date3['su_errtimes']=$data2['su_errtimes']+1;
						$Qysubuser->where($map3)->data($date3)->save();
						
						$this->error('用户名或密码有误！','',2);
						exit;
					}
				}else{
					$this->error('用户名或密码有误！','',2);
					exit;
				}
			}
			
	    }else{
            $this->error('用户名或密码有误！','',2);
        }
    }

    public function quit(){
		cookie('qiye_check',null);
        session('qiye_check',null);
		session('qyid',null);
		session('qyuser',null);
		session('unitcode',null);
		session('qyname',null);
        session('qy_purview',null);

		$this->redirect('Mp/Index/index','' , 0, '');

    }
   

   public function _empty()
    {
      header('HTTP/1.0 404 Not Found');
      echo'error:404';
      exit;
    }
}