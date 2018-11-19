<?php
namespace Klapi\Controller;
use Think\Controller;
use klapi\controller\BaseApiController;

class MineController extends BaseApiController{
protected $header;
	protected $params;
	public function __construct($params = null)
    {
    	 parent::__construct($params);//tp3.2
    	 // $this->_initialize(); //tp5.0
    	 $this->params =$params;
    }
    public function index(){
    	isset($this->params["userid"])?$user_id = $this->params["userid"] : $user_id = ''; //用户名
 		if(!$this->is_jxuser_login($user_id)){
			// $qy_fwkey=$this->qy_fwkey;
			// $qy_fwsecret=$this->qy_fwsecret;
   			// $ttamp=time();
		 	// $sture=MD5($qy_fwkey.$ttamp.$qy_fwsecret);
		 	// $ret = array("status" =>0, "msg" =>'请先登录', "ttamp" =>$ttamp, "sture" =>$sture);
			// exit(json_encode($ret);
			$this->err_get(5);
        }
        $Dealer=M("Dealer");
        $Dltype=M("Dltype");
        $Fanlidetail=M('Fanlidetail');
        $Orders=M('Orders');
        $map=array();
		$map['dl_id']=$user_id;
		$map['dl_unitcode']=$this->qy_unitcode;
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
			$mapfl['fl_dlid']=$user_id;
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
			$dl_totalstock=$this->mystock('',$user_id);
			$data['dl_totalstock']=$dl_totalstock;

			//总销售业绩
			$dl_totalmoney=0.00;
			$dataz=array();
			$dataz['od_unitcode']=$this->qy_unitcode;
			$dataz['od_rcdlid']=$user_id;
			//$datam['od_oddlid']=session('jxuser_id');
			$dataz['od_state']=array('in','3,8');
			$dataz['od_virtualstock']=1;
			$dl_totalmoney_z=$Orders->where($dataz)->sum('od_total');
			$od_expressfee_z=$Orders->where($dataz)->sum('od_expressfee');
			if ($od_expressfee_z)
				$dl_totalmoney_z=$dl_totalmoney_z+$od_expressfee_z;
			if ($dl_totalmoney_z)
				$data['dl_totalmoney_z']=$dl_totalmoney_z;
			else
				$data['dl_totalmoney_z']=0.00;

			//月度下单业绩
			$dl_totalmoney=0.00;
			$datam=array();
			$datam['od_unitcode']=$this->qy_unitcode;
			// $datam['od_rcdlid']=session('jxuser_id');
			$datam['od_oddlid']=$user_id;
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
			if ($dl_totalmoney)
				$data['dl_totalmoney']=$dl_totalmoney;
			else
				$data['dl_totalmoney']=0.00;

			//下级代理待审订单数量
	        $dlsodcount=0;//待确认0
			$mapdls=array();
			$mapdls['od_unitcode']=$this->qy_unitcode;
			$mapdls['od_rcdlid']=$user_id;
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
			$mapdlm['od_rcdlid']=$user_id;
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
				if ($v['dl_id']==$user_id)
				{
					$isHasStock=true;
					$data['isHasStock']=$isHasStock;
				}
			}
		}
		return $data;
    }
   
    //账户登录
	public function jx_user_login(){
        isset($this->params["account"]) ? $account = $this->params["account"] : $account = ''; //用户名
        isset($this->params["password"]) ? $password = $this->params["password"] : $password = ''; //用户密码

		if(mb_strlen($account,"UTF8")<6||!preg_match("/^[a-zA-Z0-9_-]{4,20}$/",$account)){
        	exit (json_encode(array("status" =>0,"msg" =>"帐号或密码有误")));
		}

		if(mb_strlen($password,"UTF8")<6){
        	exit (json_encode(array("status" =>0,"msg" =>"帐号或密码有误")));
		}
		$at_openid='';
		$at_wxopenid='';
		$Dealer=M('Dealer');
		$md5_pwd=MD5(MD5(MD5($password)));
		$map['dl_username']=$account;
		$map['dl_unitcode']=$this->qy_unitcode;
		$data=$Dealer->where($map)->field('dl_id,dl_unitcode,dl_openid,dl_username,dl_name,dl_type,dl_level,dl_pwd,dl_tel,dl_status')->find();
		if($data){
			if($data['dl_pwd']==$md5_pwd){
				if($data['dl_status']==1){
					//代理级别名称
					$Dltype=M('Dltype');
			        $dltmap=array();
			        $dltmap['dlt_id']=$data['dl_type'];
			        $dltmap['dlt_unitcode']=$this->qy_unitcode;
			        $dtldata=$Dltype->where($dltmap)->find();
			        if($dtldata){
			            $data['dl_level_name']=$dtldata['dlt_name'];
			        }else
			        {
			        	$data['dl_level_name']='';
			        }

					// $jxuser_id=real_ip();
					$jxuser_time=time();
					$jxuser_check=MD5($this->qy_fwkey.$jxuser_time.$this->qy_fwsecret).MD5($jxuser_time);
					$Accesstoken =M('Accesstoken');
					$map2=array();
					$map2['at_unitcode']=$data['dl_unitcode'];
					$map2['at_unitopenid']=$this->qy_mpwxappid;
					$map2['at_userid']=$data['dl_id'];
					$data2=$Accesstoken->where($map2)->find();
					if($data2){
						//更新登录状态
						$data3=array();
						$data3['at_token']=$jxuser_check;
						$data3['at_addtime']=$jxuser_time;
						$data3['at_status']=1;
						$Accesstoken->where($map2)->data($data3)->save();
						// $Accesstoken->where('at_id',$data2['at_id'])->save($data3);
					}else{
					   //增加登录状态
						$data3=array();
						$data3['at_unitcode']=$data['dl_unitcode'];
						$data3['at_unitopenid']=$this->qy_mpwxappid;
						$data3['at_userid']=$data['dl_id'];
						$data3['at_username']=$data['dl_username'];
						$data3['at_openid']=$data['dl_openid'];
						$data3['at_token']=$jxuser_check;
						$data3['at_clentip']=real_ip();
						$data3['at_addtime']=$jxuser_time;
						$data3['at_status']=1;
						// $Accesstoken->data($data3)->insert();tp5.0
						$Accesstoken->create($data3,1);
						$Accesstoken->add();
					}

					$loginArr=array(
						'jxuser_time'=>$jxuser_time,
						'jxuser_id'=>$data['dl_id'],
						'jxuser_unitcode'=>$data['dl_unitcode'],
						'jxuser_username'=>$data['dl_username'],
						// 'jxuser_dlname'=>wxuserTextDecode2($data['dl_name']),
						'jxuser_check'=>$jxuser_check
					);

					$user_ssid=$this->qy_appname.$jxuser_time.$data['dl_id'];
					S($user_ssid,$loginArr,72000);
			
					//记录日志 begin
					$log_arr=array(
					'log_qyid'=>session('jxuser_id'),  //操作者 id
					'log_user'=>session('jxuser_username'),
					'log_qycode'=>session('jxuser_unitcode'),
					'log_action'=>'经销商账号登录',
					'log_type'=>2, //0-系统 1-企业 2-经销商 3-消费者
					'log_addtime'=>time(),
					'log_ip'=>real_ip(),
					'log_link'=>$_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"],
					'log_remark'=>''
					);
					save_log($log_arr);
					//记录日志 end
					
					//改变登录时间
					$date2=array();
					$date2['dl_logintime']=time();
					$Dealer->where($map)->save($date2);		
					$data['user_token']=array('uttamp'=>$jxuser_time,'ussid'=>strtoupper($this->aes->encrypt($user_ssid)),'utoken'=>$jxuser_check);
					exit (json_encode(array("status" =>1,"result"=>$data,"msg" =>"登录成功")));
				}else{
					exit (json_encode(array("status" =>0,"msg" =>"该账户还没审核或已禁用")));
				}
			}else{
				exit (json_encode(array("status" =>0,"msg" =>"账号或密码有误2")));
			}
		}else{
			exit (json_encode(array("status" =>0,"msg" =>"账号或密码有误1")));
		}
	}

	/**
	 * 忘记密码
	 * @return [type] [description]
	 */
    public function user_forgot(){
		isset($this->params["userid"])?$user_id = $this->params["userid"]:$user_id = ''; //用户名
		isset($this->params["oldpwd"])?$oldpwd = $this->params["oldpwd"]:$oldpwd = ''; //旧密码
        isset($this->params["newpwd"])?$newpwd = $this->params["newpwd"]:$newpwd = ''; //新密码
 		if(!$this->is_jxuser_login($user_id)){
			$this->err_get(5);
        }

		if($oldpwd=='' || $newpwd==''){
			$this->err_get(7);
		}

		$md5_oldpwd=MD5(MD5(MD5($oldpwd)));
		$md5_newpwd=MD5(MD5(MD5($newpwd)));
		$map['dl_id']=$user_id;
		$map['dl_unitcode']=$this->qy_unitcode;
		$Dealer=M('Dealer');
		$data=$Dealer->where($map)->find();
		if($data){
			if($data['dl_pwd']==$md5_oldpwd){
				$data2['dl_pwd']=$md5_newpwd;
			    $rs=$Dealer->where($map)->data($data2)->save();
				if($rs){
					$ret=array('status'=>'1','msg'=>'修改密码成功');
					exit (json_encode($ret));
				}else{
					$ret=array('status'=>'0','msg'=>'修改密码失败');
					exit (json_encode($ret));
				}
			}else{
				$ret=array('status'=>'0','msg'=>'输入旧密码有误');
				exit (json_encode($ret));
			}
		}else{
			$this->err_get(9);
		}
    }

	/**
	 * 获取this
	 * @return [type] [description]
	 */
    public function unit_token_get(){
      $headerArr=$this->request->header();
      if (isset($headerArr['token'])){
        if ($headerArr['token']=='true'||$headerArr['token']=='True'||$headerArr['token']=='TRUE'||$headerArr['token']===true)
        {
            $unitcodeStr=$headerArr['unitcode'];
            if (is_not_null($unitcodeStr))
            {
              $ttamp=$headerArr['ttamp'];
              $unitcode=$this->aes->decrypt($unitcodeStr);
              $unit_code_time=mb_substr($unitcode,0,mb_strlen($ttamp),'utf-8');
              $unit_code=mb_substr($unitcode,mb_strlen($ttamp),mb_strlen($unitcode)-mb_strlen($ttamp),'utf-8');
              if ($ttamp!=$unit_code_time)
              $this->err_get(2);
              if ($unit_code!=$this->qy_unitcode)
              $this->err_get(3);
              $token=$this->api_unit_token_get();
            }else
            {
              $this->err_get(3);
            }
            return array(
            "token" =>$token
            );
        }else
        {
        	$this->err_get(3);
        }
      }else
      {
      	$this->err_get(3);
      }
    }

    /**
     * [feedback description]
     * @return [type] [description]
     */
	public function feedback(){
		isset($this->params["userid"])?$jxuser_id = $this->params["userid"]:$jxuser_id = ''; //用户姓名
		isset($this->params["username"])?$jxuser_username = $this->params["username"]:$jxuser_username = ''; //电话
		isset($this->params["name"])?$fb_contact = $this->params["name"]:$fb_contact = ''; //用户姓名
		isset($this->params["phone"])?$fb_tel = $this->params["phone"]:$fb_tel = ''; //电话
        isset($this->params["qq"])?$fb_qq = $this->params["qq"]:$fb_qq = ''; //腾讯
        isset($this->params["email"])?$fb_email = $this->params["email"]:$fb_email = ''; //邮箱
        isset($this->params["content"])?$fb_content = $this->params["content"]:$fb_content = ''; //内容
        isset($this->params["code"])?$check_code = $this->params["code"]:$check_code = ''; //验证码
        isset($this->params["codeid"])?$code_id = $this->params["codeid"]:$code_id = ''; //验证码cacheid
        $ip=real_ip();
		// $rule = [
		// 	'name'  => 'require|max:25',
		// 	'phone'   => 'number|length:7,11',
		// 	'email' => 'email',
		// 	'content' => 'require',
		// 	'code' => 'require|alphaNum|length:4'
		// ];

		// $msg = [
		// 	'name.require' => '请填写用户名称',
		// 	'name.max'     => '用户名最多不能超过25个字符',
		// 	'phone.number'   => '电话必须是数字',
		// 	'phone.length'  => '请正确填写电话号码',
		// 	'email'        => '邮箱格式错误',
		// 	'content.require' => '请填写您的反馈意见',
		// 	'code.require'   => '请填验证码',
		// 	'code.alphaNum'   => '验证码只能是数字或字母',
		// 	'code.length'  => '请正确填写长度为4的验证码'
		// ];

		// $data = [
		// 	'name'  =>$fb_contact,
		// 	'phone'   =>$fb_tel,
		// 	'email' =>$fb_email,
		// 	'content' =>$fb_content,
		// 	'code' =>$check_code
		// ];
		if($fb_contact==''){
			$this->err_get('请填写您的姓名');
		}
		if($fb_tel==''){
			$this->err_get('请填写联系电话');
		}
		if($fb_content==''){
			$this->err_get('请填写反馈内容');
		}
		if($check_code==''){
			$this->err_get('请填写验证码');
		}
		
		$Jffeedback=M('Jffeedback');
		// $validate = new Validate($rule,$msg);
		// $result = $validate->check($data);
		// if(!$validate->check($data)){
  //   		// dump($validate->getError());
  //   		$ret = array("status" => 0, "msg" =>$validate->getError());
  //   		exit(json_encode($ret));
		// }else
		// {	
			$verifycharId='';
	        if ($code_id)
	        {
	            $verifycharId=strtoupper(MD5($code_id.$this->qy_unitcode));
	        }
	        $verify = new \Think\Verify();
	        if ($verify->check($check_code,$verifycharId))
	        {
				$data=array();
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
					$rsID=$Jffeedback->add();
					if ($rsID>0)
					{
						$ret=array('status'=>1,'msg'=>'提交反馈成功');
						return $ret;
					}else
					{
						$this->err_get('提交反馈失败');
					}
				}else{
					$this->err_get('提交反馈失败');
				}
			}else
			{
				$ret=array('status'=>0,'refresh'=>1,'msg'=>'请输入正确的验证码');
				exit(json_encode($ret));
			}
		// }
	}


	 /**
     * [address_list_get description]
     * @return [type] [description]
     */
	public function address_list_get(){
		isset($this->params["user_id"])?$user_id = $this->params["user_id"]:$user_id = ''; //用户ID
     	if(!$this->is_jxuser_login($user_id)){
			$this->err_get(5);
        }else
        {  
 			$Dladdress =M('Dladdress');
			$map=array();
	        $map['dladd_unitcode']=$this->qy_unitcode;
	        $map['dladd_dlid'] =$user_id;
	        $data = $Dladdress->where($map)->order('dladd_default DESC,dladd_id DESC')->select();
	       	return $ret=array('addressls' =>$data);
	    }
	}

	/**
     * [address_get description]
     * @return [type] [description]
     */
	public function address_get(){
		isset($this->params["user_id"])?$user_id = $this->params["user_id"]:$user_id = ''; //用户ID
		isset($this->params["dladd_id"])?$dladd_id = $this->params["dladd_id"]:$dladd_id = ''; //地址ID
		isset($this->params["nhad"])?$nhad = $this->params["nhad"]:$nhad = false; //是否要返回省市区数据
  		if ($nhad)
  		$areaArr=$this->area_list_get();
     	if(!$this->is_jxuser_login($user_id)){
			$this->err_get(5);
        }else
        {  
 			$Dladdress =M('Dladdress');
			$map=array();
	        $map['dladd_unitcode']=$this->qy_unitcode;
	        $map['dladd_dlid'] =$user_id;
	        $map['dladd_id'] =$dladd_id;
	        $data = $Dladdress->where($map)->order('dladd_default DESC,dladd_id DESC')->find();
	        if ($data)
	        {
	        	$data['dladd_tel']=preg_replace('/(\d{3})\d{4}(\d{4})/', '$1****$2',$data['dladd_tel']);
	        	$data['dladd_sheng']=str_pad($data['dladd_sheng'],6,"0",STR_PAD_RIGHT);
	        	$data['dladd_shi']=str_pad($data['dladd_shi'],6,"0",STR_PAD_RIGHT);
	        	$data['dladd_qu']=str_pad($data['dladd_qu'],6,"0",STR_PAD_RIGHT);
	        }
	        $ret=array();
			if ($nhad)
				$ret=array('addressinfo' =>$data,'areals' =>$areaArr);
			else
				$ret=array('addressinfo' =>$data);
	  		return $ret;
	    }
	}

	/**
     * [address_edit description]
     * @return [type] [description]
     */
	public function address_edit(){
		isset($this->params["user_id"])?$user_id = $this->params["user_id"]:$user_id = ''; //用户ID
		isset($this->params["dladd_id"])?$dladd_id = $this->params["dladd_id"]:$dladd_id =0; //地址ID
  		isset($this->params["dl_name"])?$dl_name = $this->params["dl_name"]:$dl_name =''; //代理姓名
  		isset($this->params["dl_tel"])?$dl_tel = $this->params["dl_tel"]:$dl_tel ='';//代理电话
  		isset($this->params["dl_prov"])?$dl_prov = $this->params["dl_prov"]:$dl_prov =''; //代理所在省
  		isset($this->params["dl_city"])?$dl_city = $this->params["dl_city"]:$dl_city =''; //代理所在市
  		isset($this->params["dl_area"])?$dl_area = $this->params["dl_area"]:$dl_area =''; //代理所在区
  		isset($this->params["dl_area_all"])?$dl_area_all = $this->params["dl_area_all"]:$dl_area_all =''; //代理所在地区
  		isset($this->params["dl_address"])?$dl_address = $this->params["dl_address"]:$dl_address =''; //代理收货地址
  		isset($this->params["dl_default"])?$dl_default = $this->params["dl_default"]:$dl_default =0;//默认为0
  		if(!$this->is_jxuser_login($user_id)){
			$this->err_get(5);
        }else
        { 
	  		// str_pad('PQ',4,0,STR_PAD_RIGHT);
	  		$dl_phone='';
	  		if ($dladd_id>0)
	  		{
		  		$Dladdress=M('Dladdress');
		  		$map=array();
				$map['dladd_unitcode']=$this->qy_unitcode;
				$map['dladd_dlid']=$user_id;
				$map['dladd_id']=$dladd_id;
				$data=$Dladdress->where($map)->find();
				if ($data)
				{
					$dl_phone=$data['dladd_tel'];
				}
			}

			if($dl_name==''){
				$this->err_get('请填写收货人姓名');
			}
			if($dl_area_all==''){
				$this->err_get('请选择地区');
			}
			if($dl_address==''){
				$this->err_get('请填写收货地址');
			}
			if($dl_tel==''){
				$this->err_get('请填写电话');
			}

			//tp5.0 认证
			// $data = [
			// 	'dladd_contact'  =>$dl_name,
			// 	'dladd_tel'   =>$dl_tel,
			// 	'dladd_address'   =>$dl_address,
			// ];
			// if (is_not_null($dl_phone)&&$dl_tel==preg_replace('/(\d{3})\d{4}(\d{4})/','$1****$2',$dl_phone))
			// 	$result =validate('klapi/AddressValidate')->scene('edit')->check($data);
			// else
			// 	$result =validate('klapi/AddressValidate')->scene('add')->check($data);
			// $result = $this->validate($data,'klapi/AddressValidate');

			// if (!M()->validate($rules)->create()){
   //   			// 如果创建失败 表示验证没有通过 输出错误提示信息
   //   			var_dump(M()->getError());
   //   			exit($User->getError());
			// }else{
   //   			// 验证通过 可以进行其他数据操作
   //   			exit;
			// }

			// if(true !== $result){
			// 	// 验证失败 输出错误信息
			// 	// $ret = array("status" => 0, "msg" =>$validate->getError());
			// 	$ret = array("status" => 0, "msg" =>$result);
	  //   		exit(json_encode($ret));
			// }else
			// {
				$Dladdress=M('Dladdress');
				if($dladd_id>0){  //修改地址
					$map2=array();
					$map2['dladd_unitcode']=$this->qy_unitcode;
					$map2['dladd_dlid']=$user_id;
					$data2=$Dladdress->where($map2)->count();
					if($data2){
						$data=array();
						$data['dladd_unitcode']=$this->qy_unitcode;
						$data['dladd_dlid']=$user_id;
						$data['dladd_contact']=$dl_name;
						$data['dladd_sheng']=$dl_prov;
						$data['dladd_shi']=$dl_city;
						$data['dladd_qu']=$dl_area;
						$data['dladd_diqustr']=$dl_area_all;
						$data['dladd_address']=$dl_address;
						if (!is_not_null($dl_phone)||$dl_tel!=preg_replace('/(\d{3})\d{4}(\d{4})/', '$1****$2',$dl_phone))
						$data['dladd_tel']=$dl_tel;

						if (intval($data2)>1)
						{
							if ($dl_default==1)
							{
								$map3=array();
								$map3['dladd_unitcode']=$this->qy_unitcode;
								$map3['dladd_dlid']=$user_id;
								$map3['dladd_default']=1;
								$data3=$Dladdress->where($map3)->find();
								if ($data3)
								{
									$map4=array();
									$data4=array();
		            				$map4['dladd_unitcode']=$this->qy_unitcode;
		           					$map4['dladd_dlid'] =$user_id;
									$map4['dladd_id']=$data3['dladd_id'];
									$data4['dladd_default'] =0;
									$rs=$Dladdress->where($map4)->save($data4);

									$map=array();
		            				$map['dladd_unitcode']=$this->qy_unitcode;
		           					$map['dladd_dlid'] =$user_id;
									$map['dladd_id'] =$dladd_id;
									$data['dladd_default'] =1;
									$rs=$Dladdress->where($map)->save($data);
								}else
								{
									$map=array();
		            				$map['dladd_unitcode']=$this->qy_unitcode;
		           					$map['dladd_dlid'] =$user_id;
									$map['dladd_id'] = $dladd_id;
									$data['dladd_default'] =1;
									$rs=$Dladdress->where($map)->save($data);
								}
							}
							else
							{   
								$map3=array();
								$map3['dladd_unitcode']=$this->qy_unitcode;
								$map3['dladd_dlid']=$user_id;
								$map3['dladd_default']=1;
								$data3=$Dladdress->where($map3)->find();
								if (is_not_null($data3)&&$dladd_id!=$data3['dladd_id'])
								{
									$map=array();
			            			$map['dladd_unitcode']=$this->qy_unitcode;
			           				$map['dladd_dlid'] =$user_id;
									$map['dladd_id'] = $dladd_id;
									$data['dladd_default'] =0;
									$rs=$Dladdress->where($map)->save($data);
								}
								else
								{
									$this->err_get(31);	
								}
							}
						}
						else
						{
							if ($dl_default==1)
							{
								$map=array();
			            		$map['dladd_unitcode']=$this->qy_unitcode;
			           			$map['dladd_dlid'] =$user_id;
								$map['dladd_id'] = $dladd_id;
								$data['dladd_default'] =1;
								$rs=$Dladdress->where($map)->save($data);	
							}else
							{
								$this->err_get(31);	
							}		
						}
						if($rs>=0){
							$ret=array('status'=>1,'msg'=>'地址修改成功');
							exit(json_encode($ret));
						}else{
							$this->err_get(27);
						}
					}else
					{
						$this->err_get(27);
					}
				}else{    //添加地址
					$data=array();
					$data['dladd_unitcode']=$this->qy_unitcode;
					$data['dladd_dlid']=$user_id;
					$data['dladd_contact']=$dl_name;
					$data['dladd_tel']=$dl_tel;
					$data['dladd_sheng']=$dl_prov;
					$data['dladd_shi']=$dl_city;
					$data['dladd_qu']=$dl_area;
					$data['dladd_diqustr']=$dl_area_all;
					$data['dladd_address']=$dl_address;	
					$rs=$Dladdress->create($data,1);
					if($rs){
						$retID=$Dladdress->add();
						if ($retID>0){
							$map2=array();
							$map2['dladd_unitcode']=$this->qy_unitcode;
							$map2['dladd_dlid']=$user_id;
							$map2['dladd_default']=1;
							$data2=$Dladdress->where($map2)->find();
							if($data2){
								if ($dl_default==1)
								{
									$map3=array();
									$map3['dladd_unitcode']=$this->qy_unitcode;
							    	$map3['dladd_dlid']=$user_id;
							    	$map3['dladd_id']=$data2['dladd_id'];						
		                       		$updata['dladd_default']=0;
		                        	$Dladdress->where($map3)->save($updata);

		                        	$map4=array();
									$map4['dladd_unitcode']=$this->qy_unitcode;
							    	$map4['dladd_dlid']=$user_id;
							    	$map4['dladd_id']=$retID;						
		                       		$updata['dladd_default']=1;
		                        	$Dladdress->where($map4)->save($updata);
								}
							}else{
								$map3=array();
								$map3['dladd_unitcode']=$this->qy_unitcode;
							    $map3['dladd_dlid']=$user_id;
							    $map3['dladd_id']=$retID;						
		                        $updata['dladd_default']=1;
		                        $Dladdress->where($map3)->save($updata);
							}
							$ret=array('status'=>1,'msg'=>'地址新增成功');
							exit(json_encode($ret));
						}else
						{
							$this->err_get('地址新增失败');
						}
					}else{
						$this->err_get(29);
					}
				}

			// }
		}
	}
    /** 
     * 删除地址
     */
	public function address_del(){
		isset($this->params["user_id"])?$user_id = $this->params["user_id"]:$user_id = ''; //用户ID
		isset($this->params["dladd_id"])?$dladd_id = $this->params["dladd_id"]:$dladd_id =0; //地址ID
		if(!$this->is_jxuser_login($user_id)){
			$this->err_get(5);
        }else
        { 
        	//--------------------------------
			$Dladdress=M('Dladdress');
			if($dladd_id>0){
				$map=array();
				$map['dladd_unitcode']=$this->qy_unitcode;
				$map['dladd_dlid']=$user_id;
				$map['dladd_id']=$dladd_id;
				$map['dladd_default']=1;
				$data=$Dladdress->where($map)->find();
				if($data){
					$this->err_get(32);
				}
				
				$map3=array();
				$map3['dladd_unitcode']=$this->qy_unitcode;
				$map3['dladd_dlid']=$user_id;
				$map3['dladd_id']=$dladd_id;		
				$Dladdress->where($map3)->delete();
				$ret=array('status'=>1,'msg'=>'删除成功');
				exit(json_encode($ret));
			}else{
				$this->err_get(30);
			}
        }
	}

    /** 
     * 退出登录
     */
	public function jx_user_quit(){
		isset($this->params["userid"])?$user_id = $this->params["userid"] : $user_id = ''; //用户名
 		if($this->is_jxuser_login($user_id)){
 			 $Accesstoken=M('Accesstoken');
             $map['at_unitcode']=$this->qy_unitcode;
             $map['at_status']=1;
             $map['at_userid']=$user_id;
             $data=$Accesstoken->where($map)->find();
             if ($data)
             {
             	//更新登录状态
				$data3=array();
				$data3['at_status']=0;
				$Accesstoken->where($map)->data($data3)->save();

             	$jxuser_time=$data['at_addtime'];
				$user_ssid=$this->qy_appname.$jxuser_time.$user_id;
				// Cache::store('redis')->clear($user_ssid);//tp5.0
				S($user_ssid,null);//tp5.0
             }
        }
        $ret = array("status" =>1, "msg" =>'退出成功');
		exit(json_encode($ret));
	}
}