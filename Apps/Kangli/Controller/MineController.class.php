<?php
namespace Kangli\Controller;
use Think\Controller;
class MineController extends CommController {
    //首页
    public function index(){
        if(!$this->is_jxuser_login()){
			$qy_fwkey=$this->qy_fwkey;
			$qy_fwsecret=$this->qy_fwsecret;
            $ttamp2=time();
		    $sture2=MD5($qy_fwkey.$ttamp2.$qy_fwsecret);
		    $tagpage='http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
			header('location:'.WWW_WEBROOT.'Kangli/Dealer/login/ttamp/'.$ttamp2.'/sture/'.$sture2.'/tagpage/'.base64_encode($tagpage).'');
			// $this->redirect('Chuangsu/Dealer/login/ttamp/'.$ttamp2.'/sture/'.$sture2.'/tagpage/'.base64_encode($tagpage).'','' , 0, '');
        }
        $Dealer=M("Dealer");
        $Dltype=M("Dltype");
        $Fanlidetail= M('Fanlidetail');
        $Orders=M('Orders');
        $map=array();
		$map['dl_id']=session('jxuser_id');
		$map['dl_unitcode']=$this->qy_unitcode;
		$Dealer= M('Dealer');
		$data=$Dealer->where($map)->field('dl_id,dl_username,dl_name,dl_belong,dl_type,dl_level,dl_wxheadimg')->find();

		if($data){
			$dl_level=$data['dl_level'];
			//上级代理
			if (intval($data['dl_belong'])>0){
				$mapbl=array();
				$mapbl['dl_unitcode']=$this->qy_unitcode;
				$mapbl['dl_id']=$data['dl_belong'];
				$databl=$Dealer->where($mapbl)->field('dl_id,dl_username,dl_name,dl_belong')->find();
				if($databl){
					$data['dl_belong_name']=$databl['dl_name'];
				}
			}else
			{
				$data['dl_belong_name']='总公司';
			}

			//代理级别
			$mapt=array();
			$mapt['dlt_unitcode']=$this->qy_unitcode;
			$mapt['dlt_id']=$data['dl_type'];
			$mapt['dlt_level']=$dl_level;
			$datat=$Dltype->where($mapt)->field('dlt_id,dlt_name')->find();
			// var_dump($datat);
			if($datat){
				$data['dl_level_name']=$datat['dlt_name'];
			}

			
			//应收返利求和-待收款
			$mapfl=array();
			$mapfl['fl_dlid']=session('jxuser_id');//dlid为接受返利的经销商id
			$mapfl['fl_unitcode']=$this->qy_unitcode;
			//$map3['fl_type'] = array('in','1,2,3,4,5,6,7,8,9,10'); //返利分类 1-推荐返利 2-订单返利  11-提现减少返利 (1-10 增加返利 11-20 减少返利)
			$mapfl['fl_state']=0;  //0-待收款 1-已收款 2-收款中  9-已取消
			$addfl=0;
			$flsum1 = $Fanlidetail->where($mapfl)->sum('fl_money');
			if($flsum1){
				$data['dl_fanlitotal']=$flsum1;
			}else
			{
				$data['dl_fanlitotal']=0;
			}
			//更新返利
			$data3=array();
			$data3['dl_fanli'] = $addfl;
			$Dealer->where($map)->data($data3)->save();

			//代理总库存;      
			$dl_totalstock=0;
			$dl_totalstock=$this->mystock('',session('jxuser_id'));
			$data['dl_totalstock']=$dl_totalstock;

			//总销售业绩
			$dl_totalmoney=0;
			$dataz=array();
			$dataz['od_unitcode']=$this->qy_unitcode;
			$dataz['od_rcdlid']=session('jxuser_id');//od_rcdlid上级接单经销商
			// $datam['od_oddlid']=session('jxuser_id');
			$dataz['od_state']=array('in','3,8');
			$dataz['od_virtualstock']=1;
			$dl_totalmoney_z=$Orders->where($dataz)->sum('od_total');
			$od_expressfee_z=$Orders->where($dataz)->sum('od_expressfee');
			if ($od_expressfee_z)
				$dl_totalmoney_z=$dl_totalmoney_z+$od_expressfee_z;
			    $data['dl_totalmoney_z']=$dl_totalmoney_z;


			//月度下单业绩
			$dl_totalmoney=0;
			$datam=array();
			$datam['od_unitcode']=$this->qy_unitcode;
			// $datam['od_rcdlid']=session('jxuser_id');
			$datam['od_oddlid']=session('jxuser_id');//od_oddlid下单经销商
			$datam['od_state']=array('in','3,8');
			$datam['od_virtualstock']=1;
			$datam['od_fugou']=1;
			$start=strtotime(date('Y-m-01 00:00:00'));
			$end = strtotime(date('Y-m-d H:i:s'));		
			$datam['od_addtime'] = array('between',array($start,$end));

			$od_total_m=$Orders->where($datam)->sum('od_total');
			$od_expressfee_m=$Orders->where($datam)->sum('od_expressfee');
			if ($od_total_m)
				$dl_totalmoney=$od_total_m+$od_expressfee_m;
			$data['dl_totalmoney']=$dl_totalmoney;

			//下级代理待审订单数量
	        $dlsodcount=0;//待确认0
			$mapdls=array();
			$mapdls['od_unitcode']=$this->qy_unitcode;
			$mapdls['od_rcdlid']=session('jxuser_id');
			$mapdls['od_virtualstock']=1;
			$mapdls['od_state']=0;
			$dlsodcount= $Orders->where($mapdls)->count();
			if($dlsodcount){
				$data['dl_dlsodcount']=$dlsodcount;
			}else
			{
				$data['dl_dlsodcount']=0;
			}
			//待发货od_status=array('in','1,2');
			$dlmodcount=0;//待发货1，2
			$mapdlm=array();
			$mapdlm['od_unitcode']=$this->qy_unitcode;
			$mapdlm['od_rcdlid']=session('jxuser_id');
			$mapdlm['od_state']=array('in','1,2');
			$mapdlm['od_virtualstock']=1;
			$dlmodcount= $Orders->where($mapdlm)->count();
			if($dlsodcount){
				$data['dl_dlmodcount']=$dlmodcount;
			}else
			{
				$data['dl_dlmodcount']=0;
			}

			//联合创始人是否在前1000名
			//
			$mapnum=array();
			// $map['dl_id']=session('jxuser_id');
			$mapnum['dl_unitcode']=$this->qy_unitcode;
			$mapnum['dl_level']=$dl_level;
			$datanum=$Dealer->where($mapnum)->field('dl_id,dl_username,dl_name,dl_belong,dl_type,dl_level,dl_wxheadimg')->limit('1000')->select();
			$isHasStock=false;
			foreach ($datanum as $k => $v) {
				if ($v['dl_id']==session('jxuser_id'))
				{
					$isHasStock=true;
					$data['isHasStock']=$isHasStock;
				}
			}
		}
		$this->assign('userinfo',$data);
        $this->display('index');
    }

    //设置
	public function setting(){
		$isbind=intval(I('get.isbind',0));	
		if(!$this->is_jxuser_login()){
			$qy_fwkey=$this->qy_fwkey;
			$qy_fwsecret=$this->qy_fwsecret;
            $ttamp2=time();
		    $sture2=MD5($qy_fwkey.$ttamp2.$qy_fwsecret);
		    $tagpage='http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
			header('location:'.WWW_WEBROOT.'Kangli/Dealer/login/ttamp/'.$ttamp2.'/sture/'.$sture2.'/tagpage/'.base64_encode($tagpage).'');
        }

        $Dealer=M("Dealer");
		$map=array();
		$map['dl_id']=session('jxuser_id');
		$map['dl_unitcode']=$this->qy_unitcode;
		$data=$Dealer->where($map)->field('dl_openid')->find();
		$isbindwx=false;
		if($data){
			if ($data['dl_openid']!='')
			{
				$isbindwx=true;
			}else
			{
				//绑定微信
				if ($isbind==1&&session('access_token')!=''&&C('IS_ONLYWEIXIN')==1)
				{	
					$Accesstoken=M('Accesstoken');
	                $atmap=array();
	                $atmap['at_unitcode']=$this->qy_unitcode;
	                $atmap['at_token']=session('access_token');
	                $atdata=$Accesstoken->where($atmap)->find();
	                if ($atdata)
	                {
	                	$openID=$atdata['at_openid'];
	                	if ($data['dl_openid']==''||$data['dl_openid']==null||$data['dl_openid']==$openID)
	                	{
		                	$updata=array();
		                    //是否需要更新access_token
		                    if (time()-$atdata['at_retime']>7200)
		                    {
		                        $tokenJson=$this->getOauthRefreshToken($atdata['at_retoken']);
		                        if ($tokenJson)
		                        {
		                        	session("access_token",$tokenJson['access_token']);
		                        	$openID=$tokenJson['openid'];
		                            // $updata=array();
		                            $updata['at_openid']=$tokenJson['openid'];
		                            $updata['at_token']=$tokenJson['access_token'];
		                            $updata['at_retoken']=$tokenJson['refresh_token'];
		                            $updata['at_retime']=time();
		                            $updata['at_clentip']=real_ip();
		                     		//$Accesstoken->where('at_id='.$atdata['at_id'])->save($updata);
		                        }
		                    }
		                    $updata['at_userid']=$data['dl_id'];
		                    $updata['at_username']=$data['dl_name'];
		                    $updata['at_status']=1;
		                    $Accesstoken->where('at_id='.$atdata['at_id'])->save($updata);
		                    if ($openID!='')
		                    {
		                    	$date2=array();
		                    	$date2['dl_openid']=$openID;
			                    $userInfo=$this->getOauthUserinfo($data['at_retoken'],$openID);
			                    if ($userInfo!='')
								{	
									$date2['dl_wxnickname']=$userInfo['nickname'];
									$date2['dl_wxsex']=$userInfo['sex'];
									$date2['dl_wxprovince']=$userInfo['province'];
									$date2['dl_wxcity']=$userInfo['city'];
									$date2['dl_wxcountry']=$userInfo['country'];
									$date2['dl_wxheadimg']=$userInfo['headimgurl'];
								}
								$Dealer->where($map)->data($date2)->save();
		                	}
	                	}
	                }	
				}
			}
		}
		$this->assign('isbindwx',$isbindwx);
		$this->display('setting');
	}

	 //修改密码
	public function forgot(){
		$etype=intval(I('get.etype',0));		//etype:0 忘记密码 1 修改密码；
		if(!$this->is_jxuser_login()){
			$qy_fwkey=$this->qy_fwkey;
			$qy_fwsecret=$this->qy_fwsecret;
            $ttamp2=time();
		    $sture2=MD5($qy_fwkey.$ttamp2.$qy_fwsecret);
		    $tagpage='http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
			header('location:'.WWW_WEBROOT.'Kangli/Dealer/login/ttamp/'.$ttamp2.'/sture/'.$sture2.'/tagpage/'.base64_encode($tagpage).'');
        }

  	    //--------------------------------
        $action=trim(I('post.action',''));		
		if($action=='save'){
			$oldpwd=trim(I('post.oldpwd',''));
			$newpwd=trim(I('post.newpwd',''));
			$newpwd2=trim(I('post.newpwd2',''));		
			if($oldpwd=='' || $newpwd=='' || $newpwd2==''){
				$msg=array('stat'=>'0','msg'=>'请输入密码');
				echo json_encode($msg);
				exit;
			}
			if($newpwd!=$newpwd2){
				$msg=array('stat'=>'0','msg'=>'输入两新密码不一致');
				echo json_encode($msg);
				exit;
			}

			$md5_oldpwd=MD5(MD5(MD5($oldpwd)));
			$md5_newpwd=MD5(MD5(MD5($newpwd)));
			$map=array();
			$map['dl_id']=session('jxuser_id');
			$map['dl_unitcode']=$this->qy_unitcode;
			$Dealer= M('Dealer');
			$data=$Dealer->where($map)->find();
			if($data){
				if($data['dl_pwd']==$md5_oldpwd){
					
					$data2['dl_pwd']=$md5_newpwd;
				    $rs=$Dealer->where($map)->data($data2)->save();
					
					if($rs){
						$msg=array('stat'=>'1','msg'=>'修改密码成功');
						echo json_encode($msg);
						exit;
					}else{
						$msg=array('stat'=>'0','msg'=>'修改密码失败');
						echo json_encode($msg);
						exit;
					}
				}else{
					$msg=array('stat'=>'0','msg'=>'输入旧密码有误');
					echo json_encode($msg);
					exit;
				}
			}else{
				$msg=array('stat'=>'0','msg'=>'输入旧密码有误');
				echo json_encode($msg);
				exit;
			}	
		}

		$dl_username='';		
		$Dealer=M("Dealer");
		$map=array();
		$map['dl_id']=session('jxuser_id');
		$map['dl_unitcode']=$this->qy_unitcode;
		$data=$Dealer->where($map)->field('dl_username')->find();
		if($data){
			$dl_username=$data['dl_username'];
		}

		if ($etype==1)
		{
			$this->assign('title','修改密码');
		}else
		{
			$this->assign('title','忘记密码');
		}
		$this->assign('dl_username',$dl_username);
		$this->display('forgot');
	}

	//解绑微信
	public function unbindwx()
	{
		if(!$this->is_jxuser_login()){
			$qy_fwkey=$this->qy_fwkey;
			$qy_fwsecret=$this->qy_fwsecret;
            $ttamp2=time();
		    $sture2=MD5($qy_fwkey.$ttamp2.$qy_fwsecret);
		    $tagpage='http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
			header('location:'.WWW_WEBROOT.'Kangli/Dealer/login/ttamp/'.$ttamp2.'/sture/'.$sture2.'/tagpage/'.base64_encode($tagpage).'');
        }
         //--------------------------------
        $action=trim(I('post.action',''));		
		if($action=='save'){
			$oldpwd=trim(I('post.oldpwd',''));		
			if($oldpwd==''){
				$msg=array('stat'=>'0','msg'=>'请输入登录密码');
				echo json_encode($msg);
				exit;
			}
			$Dealer= M('Dealer');
			$md5_oldpwd=MD5(MD5(MD5($oldpwd)));
			$map=array();
			$map['dl_id']=session('jxuser_id');
			$map['dl_unitcode']=$this->qy_unitcode;
			$data=$Dealer->where($map)->find();
			if($data){
				if($data['dl_pwd']==$md5_oldpwd){
					$dl_openid=$data['dl_openid'];
					$updata=array();
					$updata['dl_openid']='';
					$updata['dl_wxnickname']='';
					$updata['dl_wxsex']='';
					$updata['dl_wxheadimg']='';
					$updata['dl_wxprovince']='';
					$updata['dl_wxcity']='';
					$updata['dl_wxcountry']='';
				    $rs=$Dealer->where($map)->data($updata)->save();
					if($rs){
						$Accesstoken=M('Accesstoken');
						$atmap=array();
						$atmap['at_unitcode']=$this->qy_unitcode;
						$atmap['at_openid']=$dl_openid;
						$atupdata=array();
						$atupdata['at_userid']='';
						$atupdata['at_username']='';
						$atupdata['at_status']=0;
						$Accesstoken->where($atmap)->save($atupdata);
						$msg=array('stat'=>'1','msg'=>'解绑微信成功');
						echo json_encode($msg);
						exit;
					}else{
						$msg=array('stat'=>'0','msg'=>'解绑微信失败');
						echo json_encode($msg);
						exit;
					}
				}else{
					$msg=array('stat'=>'0','msg'=>'登录密码有误');
					echo json_encode($msg);
					exit;
				}
			}else{
				$msg=array('stat'=>'0','msg'=>'帐号不存在或已被禁用');
				echo json_encode($msg);
				exit;
			}	
		}

		$dl_username='';		
		$Dealer=M("Dealer");
		$map=array();
		$map['dl_id']=session('jxuser_id');
		$map['dl_unitcode']=$this->qy_unitcode;
		$data=$Dealer->where($map)->field('dl_username,dl_wxnickname,dl_wxheadimg,dl_name')->find();
		if ($etype==1)
		{
			$this->assign('title','绑定微信');
		}else
		{
			$this->assign('title','解绑微信');
		}
		$this->assign('userInfo',$data);
        $this->display('unbindwx');
	}

	//退出
	public function quit(){
		$access_token=session('access_token');
		if ($access_token!='')
		{
			$Accesstoken=M('Accesstoken');
			$map=array();
			$map['at_unitcode']=$this->qy_unitcode;
			$map['at_token']=$access_token;
            $updata=array();
            $updata['at_status']=0;//0离线状态 1在线
            $Accesstoken->where($map)->save($updata);
		}
		echo "退出";
		session('jxuser_time','');
		session('jxuser_id','');
		session('jxuser_unitcode','');
		cookie('jxuser_check','');
		session(null);
		cookie(null);
		session('access_token',$access_token);
		$this->redirect('Index/index'.'','' , 0, '');
	}
}