<?php
namespace Kangli\Controller;
use Think\Controller;
    class CommController extends Controller
    {
        protected $qy_unitcode;
        protected $qy_fwkey;
        protected $qy_fwsecret;
        protected $dltj_arrs; //有效推荐人列表
        protected $dllower_arrs; //有效下级代理列表
        protected $appid;
        protected $appsecret;
        protected $jxuser_token;//经销商
        protected $user_token;//销费者
        protected $user_openid;

        public function _initialize()
        {
            $this->qy_unitcode = is_not_null(C('QY_UNITCODE')) ? trim(C('QY_UNITCODE')):'';
            $this->qy_fwkey = is_not_null(C('QY_FWKEY')) ? trim(C('QY_FWKEY')):'';
            $this->qy_fwsecret = is_not_null(C('QY_FWSECRET')) ? trim(C('QY_FWSECRET')):'';
            $this->appid = is_not_null(C('QY_WXAPPID')) ? trim(C('QY_WXAPPID')):'';
            $this->appsecret = is_not_null(C('QY_WXAPPSECRET')) ? trim(C('QY_WXAPPSECRET')):'';
            $this->jxuser_token =session('jxuser_token');
            $this->user_token =session('access_token');
            $this->user_openid =session('openid');

            if($this->qy_unitcode=='' || $this->qy_fwkey=='' || $this->qy_fwsecret==''){
                echo 'error:No record';
                exit;
            }

            if(C('IS_ONLYWEIXIN')==1){
                $user_agent=strtolower(I('server.HTTP_USER_AGENT'));
                if (strpos($user_agent, 'micromessenger') === false){
                    $this->error('请在微信客户端打开链接','',-1);
                    exit;
                }
            }
        }
        //判断登录 消费用户 使用用户账号
        public function is_user_login(){
            $user_check=cookie('user_check');
            $user_name=session('user_name');
            $user_time=session('user_time');
            $user_id=session('user_id');
            $user_unitcode=session('user_unitcode');


            if($user_check=='' || $user_name=='' || $user_time=='' || $user_id=='' || $user_unitcode==''){
                return false;
            }else{
                if($user_unitcode==$this->qy_unitcode){
                    if($user_check==MD5($user_name.$user_time).MD5($user_time)){
                        return true;
                    }else{
                        return false;
                    }
                }else{
                    return false;
                }
            }
        }
	
	    //判断微信登录 消费用户 微信
        public function is_user_wxlogin(){
            $user_check=cookie('user_check');
            $user_name=session('user_name');
            $user_time=session('user_time');
            $user_id=session('user_id');
            $user_unitcode=session('user_unitcode');
            if(session('access_token')=='')
            {
                if($user_check=='' || $user_name=='' || $user_time=='' || $user_id=='' || $user_unitcode==''|| $user_openid==''){
                    return false;
                }else{
                    if($user_unitcode==$this->qy_unitcode){
                        if($user_check==MD5($user_openid.$user_time).MD5($user_time)){
                            return true;
                        }else{
                            return false;
                        }
                    }else{
                        return false;
                    }
                }
            }else
            {
                $Accesstoken=M('Accesstoken');
                $map=array();
                $map['at_unitcode']=$this->qy_unitcode;
                $map['at_token']=session('access_token');
                $map['at_status']=1;//1 在线状态 0离线
                $data=$Accesstoken->where($map)->find();
                if ($data)
                {
                    //是否需要更新access_token
                    if (time()-$data['at_retime']>7200)
                    {
                        $tokenJson=$this->getOauthRefreshToken($data['at_retoken']);
                        if ($tokenJson)
                        {
                            $updata=array();
                            $updata['at_token']=$tokenJson['access_token'];
                            $updata['at_retoken']=$tokenJson['refresh_token'];
                            $updata['at_retime']=time();
                            $updata['at_clentip']=real_ip();
                            $Accesstoken->where('at_id='.$data['at_id'])->save($updata);
                            session('access_token',$tokenJson['access_token']);
                        }
                    }    
                    $Dealer=M('Dealer');
                    $map=array();
                    $map['dl_unitcode']=$this->qy_unitcode;
                    $map['dl_openid']=$data['at_openid'];
                    $map['dl_status']=1;
                    $data=$Dealer->where($map)->find();
                    if ($data){
                        $jxuser_time=time();
                        $jxuser_check=MD5($data['dl_id'].$jxuser_time).MD5($jxuser_time);
                        session('jxuser_time',$jxuser_time);
                        session('jxuser_id',$data['dl_id']);
                        session('jxuser_unitcode',$data['dl_unitcode']);
                        session('jxuser_username',$data['dl_username']);
                        session('jxuser_dlname',wxuserTextDecode2($data['dl_name']));
                        cookie('jxuser_check',$jxuser_check,72000);
                        return true;
                    }else
                    {
                        return false;
                    }    
                }else
                {
                    return false;
                }
            }
        }
		
		//判断登录 经销商 用户名登录  
        public function is_jxuser_login(){
            $jxuser_check=cookie('jxuser_check');
            $jxuser_time=session('jxuser_time');
            $jxuser_id=session('jxuser_id');
            $jxuser_unitcode=session('jxuser_unitcode');
            // if(session('access_token')=='')
            // {
                if($jxuser_check=='' || $jxuser_time=='' || $jxuser_id=='' || $jxuser_unitcode==''){
                    return false;
                }else{
                    if($jxuser_unitcode==$this->qy_unitcode){
                        if($jxuser_check==MD5($jxuser_id.$jxuser_time).MD5($jxuser_time)){
                            return true;
                        }else{
                            return false;
                        }
                    }else{
                        return false;
                    }
                }
            // }else
            // {
            //     $Accesstoken=M('Accesstoken');
            //     $map=array();
            //     $map['at_unitcode']=$this->qy_unitcode;
            //     $map['at_token']=session('access_token');
            //     $map['at_status']=1;//1 在线状态 0离线
            //     $data=$Accesstoken->where($map)->find();
            //     if ($data)
            //     {
            //         //是否需要更新access_token
            //         if (time()-$data['at_retime']>7200)
            //         {
            //             $tokenJson=$this->getOauthRefreshToken($data['at_retoken']);
            //             if ($tokenJson)
            //             {
            //                 $updata=array();
            //                 $updata['at_token']=$tokenJson['access_token'];
            //                 $updata['at_retoken']=$tokenJson['refresh_token'];
            //                 $updata['at_retime']=time();
            //                 $updata['at_clentip']=real_ip();
            //                 $Accesstoken->where('at_id='.$data['at_id'])->save($updata);
            //                 session('access_token',$tokenJson['access_token']);
            //             }
            //         }    
            //         $Dealer=M('Dealer');
            //         $map=array();
            //         $map['dl_unitcode']=$this->qy_unitcode;
            //         $map['dl_openid']=$data['at_openid'];
            //         $map['dl_status']=1;
            //         $data=$Dealer->where($map)->find();
            //         if ($data){
            //             $jxuser_time=time();
            //             $jxuser_check=MD5($data['dl_id'].$jxuser_time).MD5($jxuser_time);
            //             session('jxuser_time',$jxuser_time);
            //             session('jxuser_id',$data['dl_id']);
            //             session('jxuser_unitcode',$data['dl_unitcode']);
            //             session('jxuser_username',$data['dl_username']);
            //             session('jxuser_dlname',wxuserTextDecode2($data['dl_name']));
            //             cookie('jxuser_check',$jxuser_check,72000);
            //             return true;
            //         }else
            //         {
            //             return false;
            //         }    
            //     }else
            //     {
            //         return false;
            //     }
            // }
        }
		
		//判断微信登录 经销商 微信
        public function is_jxuser_wxlogin(){
            $jxuser_check=cookie('jxuser_check');
            $jxuser_time=session('jxuser_time');
            $jxuser_id=session('jxuser_id');
            $jxuser_unitcode=session('jxuser_unitcode');
			$jxuser_openid=session('jxuser_openid');
            			
            if($jxuser_check=='' || $jxuser_time=='' || $jxuser_id=='' || $jxuser_unitcode==''|| $jxuser_openid==''){
                return false;
            }else{
                if($jxuser_unitcode==$this->qy_unitcode){
                    if($jxuser_check==MD5($jxuser_openid.$jxuser_time).MD5($jxuser_time)){
                        return true;
                    }else{
                        return false;
                    }
                }else{
                    return false;
                }
            }
        }

        /**
         * oauth 获取授权code跳转接口
         * @param string $state scope=snsapi_base 已关注，并且现在取消关注的用户，只能获取openid 未关注公众号的不能获取任何信息,scope=snsapi_userinfo 能获取用户全部信息
         * @param string $callback 回调URI
         * @return string
         */
        public function getOauthRedirect($callback,$state='STATE',$scope='snsapi_userinfo'){
            $url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=".$this->appid.'&redirect_uri='.urlencode($callback).'&response_type=code&scope='.$scope.'&state='.$state.'#wechat_redirect';
            return $url;
        }

        /**
         * 通过code获取Access Token
         * @return array {access_token,expires_in,refresh_token,openid,scope}
         */
        public function getOauthAccessToken(){
            $code = isset($_GET['code'])?$_GET['code']:'';
            if (!$code) return false;
            $url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=".$this->appid.'&secret='.$this->appsecret.'&code='.$code.'&grant_type=authorization_code';
            //向该地址发送get请求
            $result = $this->_request('get',$url);
            if ($result)
            {
                $json = json_decode($result,true);
                if (!$json || !empty($json['errcode'])) {
                    $this->errCode = $json['errcode'];
                    $this->errMsg = $json['errmsg'];
                    return false;
                }
                $this->user_token = $json['access_token'];
                return $json;
            }
            return false;
        }
		
        /**
         * 刷新access token并续期
         * @param string $refresh_token
         * @return boolean|mixed
         */
        public function getOauthRefreshToken($refresh_token){
            $url= 'https://api.weixin.qq.com/sns/oauth2/refresh_token?appid='.$this->appid.'&grant_type=refresh_token&refresh_token='.$refresh_token;
            $result = $this->_request('get',$url);
            if ($result)
            {
                $json = json_decode($result,true);
                if (!$json || !empty($json['errcode'])){
                    $this->errCode = $json['errcode'];
                    $this->errMsg = $json['errmsg'];
                    return false;
                }
                $this->user_token = $json['access_token'];
                return $json;
            }
            return false;
        }

        /**
         * 获取授权后的用户资料
         * @param string $access_token
         * @param string $openid
         * @return array {openid,nickname,sex,province,city,country,headimgurl,privilege,[unionid]}
         * 注意：unionid字段 只有在用户将公众号绑定到微信开放平台账号后，才会出现。建议调用前用isset()检测一下
         */
        public function getOauthUserinfo($access_token,$openid){
            $url='https://api.weixin.qq.com/sns/userinfo?access_token='.$access_token.'&openid='.$openid.'&lang=zh_CN';
            $result = $this->_request('get',$url);
            if ($result)
            {
                $json = json_decode($result,true);
                if (!$json || !empty($json['errcode'])) {
                    $this->errCode = $json['errcode'];
                    $this->errMsg = $json['errmsg'];
                    return false;
                }
                return $json;
            }
            return false;
        }
        /**
         * 检验授权凭证是否有效
         * @param string $access_token
         * @param string $openid
         * @return boolean 是否有效
         */
        public function getOauthAuth($access_token,$openid){
            if ($access_token==''||$openid=='')
            {
                return false;
            }else
            {
                $url = "https://api.weixin.qq.com/sns/auth?access_token=".$access_token.'&openid='.$openid;
                //向该地址发送get请求
                $result = $this->_request('get',$url);
                if ($result)
                {
                    $json = json_decode($result,true);
                    if (!$json || !empty($json['errcode'])) {
                        $this->errCode = $json['errcode'];
                        $this->errMsg = $json['errmsg'];
                        return false;
                    } else
                      if ($json['errcode']==0) return true;
                }
                return false;
            }
        }
        
        //获取access_token,并保存到文件里
        /**
         * [getAccessToken description]
         * @param int $type 0 游客 1经销商
         * @return [type] [description]
         */
        public function getAccessToken($type=0){
            $Accesstoken=M('fw_accesstoken');
            $access_token='';
            if ($type==1) 
            {
                //经销商
                if (cookie('jxrefresh_token')!='')
                {
                    if (session('jxuser_token')!='')
                    {
                        $map=array();
                        $map['at_unitcode']=$this->qy_unitcode;
                        $map['at_token']=session('jxuser_token');
                        $data=$Accesstoken->where($map)->find();
                        if ($data)
                        {
                            if (time()-$data['at_retime']<7200)
                            {
                                $access_token=session('jxuser_token');
                            }else
                            {
                                $tokenJson=$this->getOauthRefreshToken(cookie('jxrefresh_token'));
                                 if ($tokenJson)
                                 {
                                    session('jxuser_token',$tokenJson['access_token'],7200);
                                    cookie('jxrefresh_token',$tokenJson['refresh_token'],30*24*3600);
                                    $access_token=$tokenJson['access_token'];
                                    $map=array();
                                    $map['at_unitcode']=$this->qy_unitcode;
                                    $map['at_token']=cookie('jxrefresh_token');

                                    $updata=array();
                                    $updata['at_token']=$tokenJson['access_token'];
                                    $updata['at_retoken']=$tokenJson['refresh_token'];
                                    $updata['at_retime']=time();
                                    $updata['at_clentip']=real_ip();
                                    $Accesstoken->where($map)->save($updata);
                                 } 
                            }
                        }
                    }else
                    {
                         $tokenJson=$this->getOauthRefreshToken(cookie('jxrefresh_token'));
                         if ($tokenJson)
                         {
                            session('jxuser_token',$tokenJson['access_token'],7200);
                            cookie('jxrefresh_token',$tokenJson['refresh_token'],30*24*3600);
                            $access_token=$tokenJson['access_token'];
                            $map=array();
                            $map['at_unitcode']=$this->qy_unitcode;
                            $map['at_token']=cookie('jxrefresh_token');

                            $updata=array();
                            $updata['at_token']=$tokenJson['access_token'];
                            $updata['at_retoken']=$tokenJson['refresh_token'];
                            $updata['at_retime']=time();
                            $updata['at_clentip']=real_ip();
                            $Accesstoken->where($map)->save($updata);
                         }
                    }
                }
            }else
            {
                //经销商
                if (cookie('refresh_token')!='')
                {
                    if (session('user_token')!='')
                    {
                        $map=array();
                        $map['at_unitcode']=$this->qy_unitcode;
                        $map['at_token']=session('user_token');
                        $data=$Accesstoken->where($map)->find();
                        if ($data)
                        {
                            if (time()-$data['at_retime']<7200)
                            {
                                $access_token=session('user_token');
                            }else
                            {
                                $tokenJson=$this->getOauthRefreshToken(cookie('refresh_token'));
                                 if ($tokenJson)
                                 {
                                    session('user_token',$tokenJson['access_token'],7200);
                                    cookie('refresh_token',$tokenJson['refresh_token'],30*24*3600);
                                    $access_token=$tokenJson['access_token'];
                                    $map=array();
                                    $map['at_unitcode']=$this->qy_unitcode;
                                    $map['at_token']=cookie('refresh_token');

                                    $updata=array();
                                    $updata['at_token']=$tokenJson['access_token'];
                                    $updata['at_retoken']=$tokenJson['refresh_token'];
                                    $updata['at_retime']=time();
                                    $updata['at_clentip']=real_ip();
                                    $Accesstoken->where($map)->save($updata);
                                 } 
                            }
                        }
                    }else
                    {
                         $tokenJson=$this->getOauthRefreshToken(cookie('refresh_token'));
                         if ($tokenJson)
                         {
                            session('user_token',$tokenJson['access_token'],7200);
                            cookie('refresh_token',$tokenJson['refresh_token'],30*24*3600);
                            $access_token=$tokenJson['access_token'];
                            $map=array();
                            $map['at_unitcode']=$this->qy_unitcode;
                            $map['at_token']=cookie('refresh_token');

                            $updata=array();
                            $updata['at_token']=$tokenJson['access_token'];
                            $updata['at_retoken']=$tokenJson['refresh_token'];
                            $updata['at_retime']=time();
                            $updata['at_clentip']=real_ip();
                            $Accesstoken->where($map)->save($updata);
                         }
                    }
                }
            }
            return  $access_token;
        }

		//返回上家ID 根据申请的级别和申请人的上家 $jxid-申请人的上家  $apply_level-申请级别
		public function get_dlbelong($jxid,$apply_level){
			$Dltype = M('Dltype');
			$Dealer = M('Dealer');
			//上家信息-1
			$map=array();
			$data=array();
			$map['dl_id']=intval($jxid);
			$map['dl_unitcode']=$this->qy_unitcode;
			$data=$Dealer->where($map)->find();
			if($data){
				if($data['dl_status']==1){
					//上家的级别-1
					$map2=array();
					$data2=array();
					$map2['dlt_id']=$data['dl_type'];
					$map2['dlt_unitcode']=$this->qy_unitcode;
					$data2=$Dltype->where($map2)->find();
					if($data2){
						if($apply_level<=$data2['dlt_level']){  //如果申请的级别高于 或 同级 
						    if($data['dl_belong']>0){
							    return $this->get_dlbelong($data['dl_belong'],$apply_level);
							}else{
								return 0;
							}
						}else{
							return $data['dl_id'];
						}
					}else{
						return false;
					}
				}else{  //上家的上家
					if($data['dl_belong']>0){
						return $this->get_dlbelong($data['dl_belong'],$apply_level);
					}else{
						return 0;
					}
				}
			}else{
				return false;
			}
		}
		

        //递归返回推荐人数组 $dlid--代理id
        public function get_dltjarray($dlid){
            $Dealer = M('Dealer');
            //
            $map=array();
            $data=array();
            $map['dl_id']=intval($dlid);
            $map['dl_unitcode']=session('unitcode');
            $data=$Dealer->where($map)->find();
            if($data){
                if($data['dl_referee']>0){
                    $map2=array();
                    $data2=array();
                    $map2['dl_id'] = $data['dl_referee'];
                    $map2['dl_unitcode']=session('unitcode');
                    $data2 = $Dealer->where($map2)->find();
                    if($data2){
                        if ($data2['dl_status']==1)
                        { 
                            $this->dltj_arrs[]=array('id'=>$data2['dl_id'],'name'=>$data2['dl_name'],'level'=>$data2['dl_level']);
                            if($data2['dl_referee']!=$data['dl_id']){
                                $this->get_dltjarray($data2['dl_id']);  
                            }
                        }
                    }
                }
                // else
                // {
                //  $this->dltj_arrs[]=array('id'=>'0','name'=>'总公司','level'=>'0');
                // }
            }
        }

         //递归返回下级所有代理数组 $dlid--代理id
        public function get_dllowerarray($dlid){
            $Dealer = M('Dealer');
            $map=array();
            $data=array();
            $map['dl_belong']=intval($dlid);
            $map['dl_unitcode']=$this->qy_unitcode;
            $data=$Dealer->where($map)->field('dl_id,dl_name,dl_level,dl_status,dl_type')->select();
            if ($data){
                foreach ($data as $k => $v) {
                   if ($v['dl_status']==1)
                   {   
                        $this->dllower_arrs[]=array('id'=>$v['dl_id'],'name'=>$v['dl_name'],'level'=>$v['dl_level'],'typeid'=>$v['dl_type']);
                        $this->get_dllowerarray($v['dl_id']);
                   }
                }

            }
        }
        //库存查询
        /*@probean  产品信息
          @dl_id    代理id
         */
        public function mystock($probean,$dl_id){
            //--------------------------------
            $Model=M();
            //库存订货总量  有效订货（订单状态 已发货 已完成）
            $map4=array();
            $map4['a.od_unitcode'] =$this->qy_unitcode;
            $map4['a.od_state'] = array('in', '3,8');  //完成的订单 
            if ($dl_id>0)
            {
                $map4['a.od_oddlid'] =$dl_id; //下单代理session('jxuser_id')
                $map4['a.od_id'] = array('exp','=b.oddt_odid');
                $map4['a.od_virtualstock']=1; //0--非虚拟库存订单 1--虚拟库存订单
            }
            //$probean为后台列表显示
            if ($probean)
            {
                $map4['b.oddt_proid']=$probean['pro_id'];
                // $map4['b.oddt_attrid']=$probean['sc_attrid'];
            }
            $list4 = $Model->table('fw_orders a,fw_orderdetail b')->where($map4)->order('a.od_addtime DESC')->select();
//            dump($list4);die();
            $oddt_totalqty = 0; //虚拟订货总量
            foreach($list4 as $kk=>$vv){
                //订购数量
                $oddt_unitsqty=0; //每单位包装的数量
                if($vv['oddt_prodbiao']>0){
                    $oddt_unitsqty=$vv['oddt_prodbiao'];
                    if($vv['oddt_prozbiao']>0){
                        $oddt_unitsqty=$oddt_unitsqty*$vv['oddt_prozbiao'];
                    }
                    if($vv['oddt_proxbiao']>0){
                        $oddt_unitsqty=$oddt_unitsqty*$vv['oddt_proxbiao'];
                    }
                    $oddt_totalqty += $oddt_unitsqty*$vv['oddt_qty'];
                }else{
                    $oddt_totalqty += $vv['oddt_qty'];
                }
            }
            // var_dump($dl_id);
            // var_dump($oddt_totalqty);
            //下级代理订货总量(包括有效的和未处理的)
            $map4=array();
            $map4['a.od_unitcode'] =$this->qy_unitcode;
            $map4['a.od_state'] = array('in', '0,1,2,3,8');  //完成的订单 
            if ($dl_id>0)
            {
                $map4['a.od_rcdlid'] = $dl_id; //下单代理session('jxuser_id')
                $map4['a.od_id'] = array('exp','=b.oddt_odid');
                $map4['a.od_virtualstock']=1; //0--非虚拟库存订单 1--虚拟库存订单
            }
            if ($probean)
            {
                $map4['b.oddt_proid']=$probean['pro_id'];
                // $map4['b.oddt_attrid']=$probean['sc_attrid'];
            }
            $list4 = $Model->table('fw_orders a,fw_orderdetail b')->where($map4)->order('a.od_addtime DESC')->select();
            
            $virtualshipoddt_totalqty = 0; //下订货总量
            foreach($list4 as $kk=>$vv){
                //订购数量
                $oddt_unitsqty=0; //每单位包装的数量
                if($vv['oddt_prodbiao']>0){
                    $oddt_unitsqty=$vv['oddt_prodbiao'];
                    
                    if($vv['oddt_prozbiao']>0){
                        $oddt_unitsqty=$oddt_unitsqty*$vv['oddt_prozbiao'];
                    }
                    
                    if($vv['oddt_proxbiao']>0){
                        $oddt_unitsqty=$oddt_unitsqty*$vv['oddt_proxbiao'];
                    }
                    
                    $virtualshipoddt_totalqty += $oddt_unitsqty*$vv['oddt_qty'];
                }else{
                    $virtualshipoddt_totalqty += $vv['oddt_qty'];
                }
            } 
         
            //实际发货总量(包括有效的和未处理的)
            $map4=array();
            $map4['a.od_unitcode'] = $this->qy_unitcode;
            $map4['a.od_state'] = array('in', '0,1,2,3,8');  //完成的订单
            if ($dl_id>0) 
            {
                $map4['a.od_oddlid'] =$dl_id; //下单代理session('jxuser_id')
                $map4['a.od_id'] = array('exp','=b.oddt_odid');
                $map4['a.od_virtualstock']=0; //0--非虚拟库存订单 1--虚拟库存订单
            }
            if ($probean)
            {
                $map4['b.oddt_proid']=$probean['pro_id'];
                // $map4['b.oddt_attrid']=$probean['sc_attrid'];
            }
            $list4 = $Model->table('fw_orders a,fw_orderdetail b')->where($map4)->order('a.od_addtime DESC')->select();
            $shipoddt_totalqty = 0; //实际发货总量
            foreach($list4 as $kk=>$vv){
                    //订购数量
                    $oddt_unitsqty=0; //每单位包装的数量
                    if($vv['oddt_prodbiao']>0){
                        $oddt_unitsqty=$vv['oddt_prodbiao'];
                        
                        if($vv['oddt_prozbiao']>0){
                            $oddt_unitsqty=$oddt_unitsqty*$vv['oddt_prozbiao'];
                        }
                        if($vv['oddt_proxbiao']>0){
                            $oddt_unitsqty=$oddt_unitsqty*$vv['oddt_proxbiao'];
                        }
                        $shipoddt_totalqty += $oddt_unitsqty*$vv['oddt_qty'];
                    }else{
                        $shipoddt_totalqty += $vv['oddt_qty'];
                    }

            }
            //剩余库存
            $surplusqty=$oddt_totalqty-$virtualshipoddt_totalqty-$shipoddt_totalqty;
            if (intval($surplusqty)<0)
            $surplusqty=0;
            return intval($surplusqty);
        }
        //发送请求方法
        /**
         * @param  string $method 'get'|'post' 请求的方式
         * @param  string $url URL
         * @param  array|json $data post请求需要发送的数据
         * @param  bool $ssl
         */
        private function _request($method='get',$url,$data=array(),$ssl=true){
            //curl完成，先开启curl模块
            //初始化一个curl资源
            $curl = curl_init();
            //设置curl选项
            curl_setopt($curl,CURLOPT_URL,$url);//url
            //请求的代理信息
            $user_agent = isset($_SERVER['HTTP_USER_AGENT'])?$_SERVER['HTTP_USER_AGENT']: 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:38.0) Gecko/20100101 Firefox/38.0 FirePHP/0.7.4';
            curl_setopt($curl,CURLOPT_USERAGENT,$user_agent);
            //referer头，请求来源     
            curl_setopt($curl,CURLOPT_AUTOREFERER,true);
            curl_setopt($curl, CURLOPT_TIMEOUT, 30);//设置超时时间
            //SSL相关
            if($ssl){
                //禁用后，curl将终止从服务端进行验证;
                curl_setopt($curl,CURLOPT_SSL_VERIFYPEER,false);
                //检查服务器SSL证书是否存在一个公用名
                curl_setopt($curl,CURLOPT_SSL_VERIFYHOST,2);
            }
            //判断请求方式post还是get
            if(strtolower($method)=='post') {
                /**************处理post相关选项******************/
                //是否为post请求 ,处理请求数据
                curl_setopt($curl,CURLOPT_POST,true);
                curl_setopt($curl,CURLOPT_POSTFIELDS,$data);
            }
            //是否处理响应头
            curl_setopt($curl,CURLOPT_HEADER,false);
            //是否返回响应结果
            curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
            //发出请求
            $response = curl_exec($curl);
            if (false === $response) {
                echo '<br>', curl_error($curl), '<br>';
                return false;
            }
            //关闭curl
            curl_close($curl);
            return $response;
        }
    		
        public function _empty()
        {
          header('HTTP/1.0 404 Not Found');
          echo'error:404';
          exit;
        }
}