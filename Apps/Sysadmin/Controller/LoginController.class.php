<?php
namespace Sysadmin\Controller;
use Think\Controller;
class LoginController extends Controller {
    public function index(){
        $this->display('index');
    }

    public function verify(){
        $config = array(
                        'fontSize' =>22, // 验证码字体大小    
                        'length' => 5, // 验证码位数 
                        'useNoise' => true, // 关闭验证码杂点
                        'useImgBg' => false, //是否使用背景图片
                        'imageW' => 180,
                        'imageH' => 50,
                        'useNoise' => true,
                       );
        $verify = new \Think\Verify($config);
        $verify->entry();
        exit;
    }


    public function logining(){
        $map['admin_username']=I('post.username','');
        $checkcode=I('post.checkcode','');
        $admin_pwd=I('post.pwd','');

        if($map['admin_username']=='' || $admin_pwd==''){
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
        if(!preg_match("/^[a-zA-Z0-9_]{4,20}$/",$map['admin_username'])){
        	$this->error('用户名由 A-Z,a-z,0-9,_ 组成,4-20位','',2);
        }

        $md5_admin_pwd=MD5(MD5(MD5($admin_pwd)));
        $login_time=time();
        $admin_check=MD5($map['admin_username'].$login_time).MD5($login_time);
        $Sysadmin= M('Sysadmin');
        $data=$Sysadmin->where($map)->find();
        if($data){
			//根据记录的错误次数与时间判断是否暂时冻结 连续5次错误冻结20分钟
			if($data['admin_errtimes']>=5){
				if((time()-$data['admin_logintime'])<1200){
					$this->error('由于连续多次输入错误，暂冻结登录，请等候20分钟后再登录','',3);
				}
			}
			
            if($data['admin_pwd']==$md5_admin_pwd){

            	if($data['admin_active']==1){

	            	$admin_purview_arr=array();
	            	session('admin_name',$data['admin_username']);
	            	session('admin_truename',$data['admin_truename']);
                    session('login_time',$login_time);
	            	session('admin_purview',$admin_purview_arr);

	            	cookie('admin_check',$admin_check,36000);

                    //记录日志 begin
                    $log_arr=array(
                                'log_qyid'=>0,
                                'log_user'=>session('admin_name'),
                                'log_qycode'=>'',
                                'log_action'=>'系统登录',
								'log_type'=>0, //0-系统 1-企业 2-经销商 3-消费者
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
					$map2['admin_id']=$data['admin_id'];
					$date2['admin_logintime']=time();
					$date2['admin_errtimes']=0;
					$Sysadmin->where($map2)->data($date2)->save();
					
					$this->redirect('Sysadmin/Index/index','' , 0, '');
				}else{
					$this->error('该用户已禁用','',2);
				}

            }else{
				//记录错误次数与时间
				$map2=array();
				$date2=array();
				$map2['admin_id']=$data['admin_id'];
				$date2['admin_logintime']=time();
				$date2['admin_errtimes']=$data['admin_errtimes']+1;
				$Sysadmin->where($map2)->data($date2)->save();
				
            	$this->error('用户名或密码有误！','',2);
            }
        }else{
            $this->error('用户名或密码有误！','',2);
        }
    }

    public function quit(){
		cookie('admin_check',null);
		session('admin_name',null);
		session('admin_truename',null);
		session('login_time',null);
		session('admin_purview',null);

		$this->redirect('Sysadmin/Index/index','' , 0, '');

    }

    public function _empty()
    {
      header('HTTP/1.0 404 Not Found');
      echo'error:404';
      exit;
    }
}