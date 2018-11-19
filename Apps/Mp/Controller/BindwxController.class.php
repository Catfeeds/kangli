<?php
namespace Mp\Controller;
use Think\Controller;
//绑定微信
class BindwxController extends CommController {
    public function index(){
    $this->check_qypurview('90002',1);
    $map['qy_code']=session('unitcode');
        $Qyinfo = M('Qyinfo');
        $data=$Qyinfo->where($map)->find();
        if($data){
            $qy_folder=$data['qy_folder'];
        }else{
            $this->error('没有该记录');
        }
        //生成二维码
        $timestamp=time();
        $qy_fwkey=$data['qy_fwkey'];
        $qy_fwsecret=$data['qy_fwsecret'];
        $signature=MD5($qy_fwkey.$timestamp.$qy_fwsecret);
        $filepath = BASE_PATH.'/Public/uploads/dealer/'.session('unitcode').'/qybindwx.png';
        if (@is_dir(BASE_PATH.'/Public/uploads/dealer/'.session('unitcode').'/') === false){
           @mkdir(BASE_PATH.'/Public/uploads/dealer/'.session('unitcode').'/');
        }
        $http_host=strtolower(htmlspecialchars('http://'.$_SERVER['HTTP_HOST'])).WWW_WEBROOT;
        $isSub=false;
        if (strpos(session('qyuser'),':')!==false)
        {
            $isSub=true;
        }
        $link=$http_host.$qy_folder.'/dealer/qybindwx/ttamp/'.$timestamp.'/sture/'.$signature.'/isSub/'.$isSub;
        make_ercode($link,$filepath,'','');
        $qybindwx_pic_str='<img src="'.__ROOT__.'/Public/uploads/dealer/'.session('unitcode').'/qybindwx.png"  border="0"   >';
        if (session('qybindwx'))
            $this->assign('atitle', '解绑微信');
        else
            $this->assign('atitle', '绑定微信');
        $this->assign('qybindwx_pic_str', $qybindwx_pic_str);
	    $this->assign('qyuser',session('qyuser'));
        $this->assign('curr', 'bindwx');
        $this->display('index');
    }
    public function unbindwx()
    {
    	$this->check_qypurview('90002',1);
        $isSub=false;
        if (strpos(session('qyuser'),':')!==false)
        {
            $isSub=true;
            $qy_username_arr=explode(":",session('qyuser'));
            reset($qy_username_arr);
            $qy_username=current($qy_username_arr);
            $qy_subusername=end($qy_username_arr);
        }
        if($isSub){
            $Qysubuser=M('Qysubuser');
            $map=array();
            $map['su_unitcode']=session('unitcode');
            $map['su_username']=$qy_subusername;
            $data=$Qysubuser->where($map)->find();
            if ($data)
            {
                $dl_openid=$data['su_openid'];
                $updata=array();
                $updata['su_openid']='';
                $updata['su_wxnickname']='';
                $updata['su_wxsex']='';
                $updata['su_wxheadimg']='';
                $updata['su_wxprovince']='';
                $updata['su_wxcity']='';
                $updata['su_wxcountry']='';
                $ret=$Qysubuser->where($map)->save($updata);
                if ($ret)
                {
                    $Accesstoken=M('Accesstoken');
                    $atmap=array();
                    $atmap['at_unitcode']=session('unitcode');
                    $atmap['at_openid']=$dl_openid;
                    $atupdata=array();
                    $atupdata['at_userid']='';
                    $atupdata['at_username']='';
                    $atupdata['at_status']=0;
                    $Accesstoken->where($atmap)->save($atupdata);
                    $this->success('解绑成功',U('./Mp/Bindwx/index'),1);
                }else
                {
                    $this->error('解绑失败','',1);
                }
            }else
            {
                $this->error('没有该记录');
            } 
        }else{
            $Qyinfo=M('Qyinfo');
            $map=array();
            $map['qy_unitcode']=session('unitcode');
            $map['qy_id']=session('qyid');
            $map['qy_username']=session('qyuser');
            $data=$Qyinfo->where($map)->find();
            if ($data)
            {
                $dl_openid=$data['qy_openid'];
                $updata=array();
                $updata['qy_openid']='';
                $ret=$Qyinfo->where($map)->save($updata);
                if ($ret)
                {
                    $Accesstoken=M('Accesstoken');
                    $atmap=array();
                    $atmap['at_unitcode']=session('unitcode');
                    $atmap['at_openid']=$dl_openid;
                    $atupdata=array();
                    $atupdata['at_userid']='';
                    $atupdata['at_username']='';
                    $atupdata['at_status']=0;
                    $Accesstoken->where($atmap)->save($atupdata);
                    $this->success('解绑成功',U('./Mp/Bindwx/index'),1);
                }else
                {
                    $this->error('解绑失败','',1);
                }
            }else
            {
                $this->error('没有该记录');
            }
        }
    }
}