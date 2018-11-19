<?php
namespace Kangli\Controller;
use Think\Controller;
class TokenController extends CommController {
	public function index(){
		echo "授权页";
		exit;
	}
    //授权
    public function startOauth(){
		$code=trim(I('get.code',''));
		$tag=trim(I('get.tag',''));
		// var_dump(urldecode(base64_decode($tag)));
		// exit;
		$msg='';
		if ($code!='')
		{
			$tokenJson=$this->getOauthAccessToken();
			if ($tokenJson)
			{
				$this->user_openid=$tokenJson['openid'];
				$Accesstoken =M('Accesstoken');
				$map2=array();
				$map2['at_unitcode']=$this->qy_unitcode;
				$map2['at_unitopenid']=C('QY_WXAPPID');
				$map2['at_openid']=$tokenJson['openid'];
				$data2=$Accesstoken->where($map2)->find();
				if($data2){
					//已授权
					$data3=array();
					$data3['at_token']=$tokenJson['access_token'];
					$data3['at_retoken']=$tokenJson['refresh_token'];
					$data3['at_retime']=time();
					$data3['at_clentip']=real_ip();
					$data3['at_addtime']=time();
					$Accesstoken->where($map2)->data($data3)->save();
					//写入session
					session('access_token',$tokenJson['access_token']);
					$this->redirect(urldecode(base64_decode($tag)),'',0,'');
					exit; 
				}else{
					if ($tokenJson['scope']=='snsapi_userinfo')
					{
						$data3=array();
						$data3['at_unitcode']=$this->qy_unitcode;
						$data3['at_unitopenid']=C('QY_WXAPPID');
						$data3['at_openid']=$tokenJson['openid'];
						$data3['at_token']=$tokenJson['access_token'];
						$data3['at_retoken']=$tokenJson['refresh_token'];
						$data3['at_retime']=time();
						$data3['at_userid']='';
						$data3['at_username']='';
						$data3['at_clentip']=real_ip();
						$data3['at_addtime']=time();
						$data3['at_status']=0;
						$Accesstoken->create($data3,1);
						$Accesstoken->add();
						//写入session
						session('access_token',$tokenJson['access_token']);
						$this->redirect(urldecode(base64_decode($tag)),'',0,'');
						// $this->success('授权成功','javascript:window.location.href='.urldecode(base64_decode($tag)),1);
	    				exit;
	    			}else
	    			{
		    			$callback='http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
						if ($tag)
						{
							$http_host=strtolower(htmlspecialchars('http://'.$_SERVER['HTTP_HOST'])).WWW_WEBROOT;
							$callback=$http_host.WWW_WEBROOT.CONTROLLER_NAME.'/'.ACTION_NAME.'/tag/'.$tag;
						}
						$state='STATE';
						$scope='snsapi_userinfo';//弹出授权
						$url =$this->getOauthRedirect($callback,$state,$scope);
						header("Location:".$url);
					}
				}
			}else
			{
				// $msg='授权失败或取消授权';
				// goto gotoEND;
				$this->error('授权失败或取消授权','javascript:window.location.href='.urldecode(base64_decode($tag)),1);
                exit;
			}
		}else
		{
			$callback='http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
			if ($tag)
			{
				$http_host=strtolower(htmlspecialchars('http://'.$_SERVER['HTTP_HOST'])).WWW_WEBROOT;
				$callback=$http_host.WWW_WEBROOT.CONTROLLER_NAME.'/'.ACTION_NAME.'/tag/'.$tag;
			}
			// var_dump($callback);
			// exit;
			$state='STATE';
			$scope='snsapi_base';//不弹出授权
			$url =$this->getOauthRedirect($callback,$state,$scope);
			header("Location:".$url);
		}
    }	
}