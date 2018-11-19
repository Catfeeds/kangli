<?php
namespace Kangli\Controller;
use Think\Controller;
class FeedbackController extends CommController {
    //投诉建议
    public function index(){
        $action=trim(I('post.action',''));
		if ($action=='save') {
			$ttamp=trim(I('post.ttamp',''));
			$sture=trim(I('post.sture',''));
			$fwkey=$this->qy_fwkey;
			$qy_fwsecret=$this->qy_fwsecret;
			$nowtime=time();
			if(MD5($fwkey.$ttamp.$qy_fwsecret)!=$sture){
				$msg=array('stat'=>2,'msg'=>'提交超时');
                echo json_encode($msg);
                exit;
			}
			if(($nowtime - $ttamp) > 1200) {
				$msg=array('stat'=>2,'msg'=>'提交超时');
                echo json_encode($msg);
                exit;
			}
		    $fb_contact=trim(I('post.fb_contact',''));
			$fb_tel=trim(I('post.fb_tel',''));
			$fb_qq=trim(I('post.fb_qq',''));
			$fb_email=trim(I('post.fb_email',''));
			$fb_content=trim(I('post.fb_content',''));
			$checkcode=trim(I('post.checkcode',''));
			$ip=real_ip();
			
			if($fb_contact==''){
				$msg=array('stat'=>0,'msg'=>'请填写您的姓名');
                echo json_encode($msg);
                exit;
			}
			if($fb_tel==''){
				$msg=array('stat'=>0,'msg'=>'请填写联系电话');
                echo json_encode($msg);
                exit;
			}
			if($fb_content==''){
				$msg=array('stat'=>0,'msg'=>'请填写反馈内容');
                echo json_encode($msg);
                exit;
			}
			if($checkcode==''){
				$msg=array('stat'=>0,'msg'=>'请填写验证码');
                echo json_encode($msg);
                exit;
			}
			
            $verify = new \Think\Verify();
            if(!($verify->check($checkcode))){
                $msg=array('stat'=>0,'msg'=>'请正确输入验证码');
                echo json_encode($msg);
                exit;
            }
            if($this->is_jxuser_login()){
				$jxuser_username=session('jxuser_username');
				$jxuser_id=session('jxuser_id');
				if($jxuser_id==''){
					$jxuser_id=0;
				}
				if($jxuser_username==''){
					$jxuser_username='';
				}
				}else{
				$jxuser_id=0;
				$jxuser_username='';
            }
			
			$Jffeedback= M('Jffeedback');
			$data['fb_unitcode']=$this->qy_unitcode;
			$data['fb_type']=1; //1-反馈留言
			$data['fb_userid']=$jxuser_id;
			$data['fb_username']=$jxuser_username;
			$data['fb_contact']=$fb_contact;
			$data['fb_tel']=$fb_tel;
			$data['fb_qq']=$fb_qq;
			$data['fb_email']=$fb_email;
			$data['fb_content']=$fb_content;
			$data['fb_addtime']=time();
			$data['fb_ip']=$ip;
			$data['fb_state']=0;


			$rs=$Jffeedback->create($data,1);
			if($rs){
			   $result = $Jffeedback->add(); 
			   if($result){
					$msg=array('stat'=>1,'msg'=>'提交反馈成功');
					echo json_encode($msg);
					exit;
			   }else{
					$msg=array('stat'=>0,'msg'=>'提交反馈失败');
					echo json_encode($msg);
					exit;
			   }
			}else{
					$msg=array('stat'=>0,'msg'=>'提交反馈失败');
					echo json_encode($msg);
					exit;
			}

		}else{
			$qy_fwkey=$this->qy_fwkey;
			$qy_fwsecret=$this->qy_fwsecret;
			$ttamp2=time();
			$sture2=MD5($qy_fwkey.$ttamp2.$qy_fwsecret);
			
			$this->assign('ttamp', $ttamp2);
			$this->assign('sture', $sture2);

			$this->display('index');
		}
	
    }
    //验证码
    public function verify(){
        $config = array(
                        'fontSize' =>22, // 验证码字体大小    
                        'length' => 4, // 验证码位数 
                        'useNoise' => true, // 关闭验证码杂点
                        'useImgBg' => false, //是否使用背景图片
                        'imageW' => 170,
                        'imageH' => 45,
                        'useNoise' => true,
                       );
        $verify = new \Think\Verify($config);
        $verify->entry();
        exit;
    }

}