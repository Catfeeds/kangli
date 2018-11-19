<?php
namespace Klapi\Controller;
use Think\Controller;
use klapi\controller\BaseApiController;

class FanliController extends BaseApiController{
protected $header;
	protected $params;
	public function __construct($params = null)
    {
    	parent::__construct($params);//tp3.2
    	// $this->_initialize(); //tp5.0
    	$this->params =$params;
    	$this->ImagePath='http://'.PROPATH;
     	$this->DLPath='http://'.DLPATH;
     	$this->ODPath='http://'.ODPATH;
    }
    public function index(){
    	isset($this->params["userid"])?$user_id = $this->params["userid"] : $user_id = ''; //用户名
    	isset($this->params["fl_state"])?$fl_state = $this->params["fl_state"]:$fl_state =0; //订单状态 0全部
		isset($this->params["pagenum"]) ? $pagenum = $this->params["pagenum"] : $pagenum =1;
	    isset($this->params["pagecount"]) ? $pagecount = $this->params["pagecount"] : $pagecount =20;

 		if(!$this->is_jxuser_login($user_id)){
			$this->err_get(5);
        }else
        {
        	//--------------------------------	
	        $Dealer=M('Dealer');
			$dlmap=array();
			$dlmap['dl_id']=$user_id;
			$dlmap['dl_unitcode']=$this->qy_unitcode;
			$dlmap['dl_status']=1;
			$dldata=$Dealer->where($dlmap)->field('dl_id,dl_type,dl_belong,dl_level,dl_referee')->find();
			if($dldata){
				$dl_level=$dldata['dl_level'];
			}else{
				$this->err_get(4);
			}
			$Fanlidetail= M('Fanlidetail');
			//返利总余额
			$balance_total=0;
			//应收返利求和-待收款
			$flmap=array();
			$flmap['fl_dlid']=$user_id;
			$flmap['fl_unitcode']=$this->qy_unitcode;
			//$map3['fl_type'] = array('in','1,2,3,4,5,6,7,8,9,10'); //返利分类 1-推荐返利 2-订单返利  11-提现减少返利 (1-10 增加返利 11-20 减少返利)
			$flmap['fl_state']=0;  //0-待收款 1-已收款 2-收款中  9-已取消
			$fltotal=0;
			$fanlisum= $Fanlidetail->where($flmap)->sum('fl_money');
			if($fanlisum){
				$fltotal=$fanlisum;
			}
			$balance_total=$fltotal;
			//更新返利
			$fluddata=array();
			$fluddata['dl_fanli'] = $fltotal;
			$Dealer->where('dl_id='.$user_id)->data($fluddata)->save();

			//返利明细列表
	    	$fanliInfo=$this->fanli_list_get();
			$ret = array("dl_level"=>$dl_level,"dl_fanlitotal" =>$balance_total,"fanliInfo"=>$fanliInfo);
	    	return $ret;
    	}
    }

    /**
	 * fanli_list_get 返利列表
	 * @return [type] [description]
	 */
    public function fanli_list_get(){
    	isset($this->params["userid"])?$user_id = $this->params["userid"]:$user_id = ''; //用户名
    	isset($this->params["fl_state"])?$fl_state = $this->params["fl_state"]:$fl_state =-1; //订单状态 0待收款 收款中 1、//已收款 2、//待付款 付款中3、//已付款 9、已取消
		isset($this->params["pagenum"]) ? $pagenum = $this->params["pagenum"] : $pagenum =1;
	    isset($this->params["pagecount"]) ? $pagecount = $this->params["pagecount"] : $pagecount =20;
	    // 查询状态为1的用户数据 并且每页显示10条数据 总记录数为1000
	    // $pageinit=[
	    //   'type'     => 'bootstrap',
	    //   'page' =>$pagenum,
	    //   // 'list_rows' =>$pagecount,
	    // ];
 		if(!$this->is_jxuser_login($user_id)){
			$this->err_get(5);
        }

        $Fanlidetail= M('Fanlidetail');
        $mapls=array();
        $mapls['fl_unitcode']=$this->qy_unitcode;
		if($fl_state==1){  //已收款
			$mapls['fl_dlid']=$user_id;
			$mapls['fl_state']=1;
		}else if($fl_state==2){ //待付款 付款中
			$mapls['fl_senddlid']=$user_id;
			$mapls['fl_state']=array('in','0,2');
		}else if($fl_state==3){  //已付款
			$mapls['fl_senddlid']=$user_id;
			$mapls['fl_state']=1;
		}else if($fl_state==9){
			$where=array();
			$where['fl_dlid']=$user_id;
			$where['fl_senddlid']=$user_id;
			$where['_logic'] = 'or';
			$mapls['_complex'] = $where;
			$mapls['fl_state']=9;
		}else{              //待收款 收款中
			$mapls['fl_dlid']=$user_id;
			$mapls['fl_state']=array('in','0,2');
		}

		$list=$Fanlidetail->where($mapls)->order('fl_id DESC')->page($pagenum,$pagecount)->select();

		$has_more=false;
		//是否有下页
		$nextls =$Fanlidetail->where($mapls)->order('fl_id DESC')->page($pagenum+1,$pagecount)->select(); 
	    if (is_not_null($nextls))
		{
			$has_more=true;
		}
	    $ret=array('current_page' =>$pagenum,'has_more' =>$has_more,'data'=>$list);
	    return $ret;
    }

    /**
	 * fanli_detail_get 返利详情
	 * @return [type] [description]
	 */
    public function fanli_detail_get(){
		isset($this->params["userid"])?$user_id = $this->params["userid"] : $user_id = ''; //用户名
    	isset($this->params["fl_id"])?$fl_id=$this->params["fl_id"]:$fl_id =0; //返利详情ID
 		if(!$this->is_jxuser_login($user_id)){
			$this->err_get(5);
        }else
        {
        	$Fanlidetail=M('Fanlidetail');
        	$map=array();
        	$map['fl_unitcode']=$this->qy_unitcode;
        	$map['fl_id']=$fl_id;
        	$data=$Fanlidetail->where($map)->find();
        	if ($data)
        	{
        		//返利类型
        		if(isset(C('FANLI_TYPE')[$data['fl_type']])){
			    	$data['fl_typestr']=C('FANLI_TYPE')[$data['fl_type']];
				}else{
					$data['fl_typestr']='其他';
				}
				$Dealer=M('Dealer');
        		//收款代理
				$rcmap=array();
				$rcdata=array();
				$rcmap['dl_id']=$data['fl_dlid'];
				$rcmap['dl_unitcode']=$this->qy_unitcode;
				$rcdata=$Dealer->where($rcmap)->find();
				if($rcdata){
					$data['fl_rdl_name']=$rcdata['dl_name'];
					$data['fl_rdl_username']=$rcdata['dl_username'];
				}else{
					$data['fl_rdl_name']='';
					$data['fl_rdl_username']='';
				}
				//付款代理
				if($data['fl_senddlid']==0){
					$data['fl_sdl_name']='总公司';
					$data['fl_sdl_username']='';
				}else{
					$snmap=array();
					$sndata=array();
					$snmap['dl_id']=$data['fl_senddlid'];
					$snmap['dl_unitcode']=$this->qy_unitcode;
					$sndata=$Dealer->where($snmap)->find();
					if($sndata){
						$data['fl_sdl_name']=$sndata['dl_name'];
						$data['fl_sdl_username']=$sndata['dl_username'];
					}else{
						$data['fl_sdl_name']='';
						$data['fl_sdl_username']='';
					}
				}

        		//状态
        		if ($data['fl_dlid']==$user_id)
        		{
        			//应收返利
        			switch ($data['fl_state']) {
        				case '1':
        					$data['fl_state_str']='已收款';
        					break;
        				case '2':
        					$data['fl_state_str']='收款中';
        					break;
        				case '9':
        					$data['fl_state_str']='已取消';
        					break;
        				default:
        					$data['fl_state_str']='待收款';
        					break;
        			}
        		}else if ($data['fl_senddlid']==$user_id)
        		{
        			//应付返利
        			switch ($data['fl_state']) {
        				case '1':
        					$data['fl_state_str']='已付款';
        					break;
        				case '2':
        					$data['fl_state_str']='付款中';
        					break;
        				case '9':
        					$data['fl_state_str']='已取消';
        					break;
        				default:
        					$data['fl_state_str']='待付款';
        					break;
        			}
        		}
        		return $data;
        	}else
        	{
        		$this->err_get(4);
        	}
        }
    }

    /**
	 * fanli_receivelist_get 应收返利列表
	 * @return [type] [description]
	 */
    public function fanli_receivelist_get(){
		isset($this->params["userid"])?$user_id = $this->params["userid"] : $user_id = ''; //用户名
 		if(!$this->is_jxuser_login($user_id)){
			$this->err_get(5);
        }else
        {
        	//--------------------------------
			$Fanlidetail= M('Fanlidetail');
			$Dealer= M('Dealer');
		    $map=array();
		    $map['fl_unitcode']=$this->qy_unitcode;
			$map['fl_dlid']=$user_id;   
			$list = $Fanlidetail->field('fl_senddlid')->where($map)->group('fl_senddlid')->select();
			if (is_not_null($list))
			{
				foreach($list as $k=>$v){ 
				    //付款方
				    if($v['fl_senddlid']==0){
						$list[$k]['fl_sdl_name']='总公司';
						$list[$k]['fl_sdl_username']='';
					}else{
						$map3=array();
						$data3=array();
						$map3['dl_id']=$v['fl_senddlid'];
						$map3['dl_unitcode']=$this->qy_unitcode;
						$data3=$Dealer->where($map3)->find();
						if($data3){
							$list[$k]['fl_sdl_name']=$data3['dl_name'];
							$list[$k]['fl_sdl_username']=$data3['dl_username'];
						}else{
							$list[$k]['fl_sdl_name']='';
							$list[$k]['fl_sdl_username']='';
						}
					}
					
				    //统计累计返利
					$map3=array();
					$map3['fl_dlid']=$user_id; //返利收方
					$map3['fl_senddlid']=$v['fl_senddlid']; //返利发方
					$map3['fl_unitcode']=$this->qy_unitcode;
					$map3['fl_state']=array('neq',9);;  //0-待收款 1-已收款 2-收款中  9-已取消
					$flsum1=0;
					$flsum1 = $Fanlidetail->where($map3)->sum('fl_money');
		            $list[$k]['fltotail']=$flsum1;
					
					//统计已收返利
		            $map3=array();
					$map3['fl_dlid']=$user_id; //返利收方
					$map3['fl_senddlid']=$v['fl_senddlid']; //返利发方
					$map3['fl_unitcode']=$this->qy_unitcode;
					$map3['fl_state']=1;  //0-待收款 1-已收款 2-收款中  9-已取消
					$flsum2=0;
					$flsum2 = $Fanlidetail->where($map3)->sum('fl_money');
		            $list[$k]['flreceived']=$flsum2;
					
					//统计待收返利
		            $map3=array();
					$map3['fl_dlid']=$user_id; //返利收方
					$map3['fl_senddlid']=$v['fl_senddlid']; //返利发方
					$map3['fl_unitcode']=$this->qy_unitcode;
					$map3['fl_state']=0;  //0-待收款 1-已收款 2-收款中  9-已取消
					$flsum3=0;
					$flsum3 = $Fanlidetail->where($map3)->sum('fl_money');
		            $list[$k]['flready']=$flsum3;
					
					//统计收款中
		            $map3=array();
					$map3['fl_dlid']=$user_id; //返利收方
					$map3['fl_senddlid']=$v['fl_senddlid']; //返利发方
					$map3['fl_unitcode']=$this->qy_unitcode;
					$map3['fl_state']=2;  //0-待收款 1-已收款 2-收款中  9-已取消
					$flsum4=0;
					$flsum4 = $Fanlidetail->where($map3)->sum('fl_money');
		            $list[$k]['flreceiving']=$flsum4;
					
					//统计可提现金额
					$map3=array();
					$map3['fl_dlid']=$user_id; //返利收方
					$map3['fl_senddlid']=$v['fl_senddlid']; //返利发方
					$map3['fl_unitcode']=$this->qy_unitcode;
					$map3['fl_state']=0;  //0-待收款 1-已收款 2-收款中  9-已取消
					$map3['fl_addtime']=array('lt',time()-3600*24*C('FANLI_JIANGETIME'));
					$flsum5=0;
					$flsum5 = $Fanlidetail->where($map3)->sum('fl_money');
					$list[$k]['flcanrecash']=$flsum5;

					//是否可提
					$minRecashMoney=C('FANLI_RECASH');//最小提现金额
					if ($flsum5>=$minRecashMoney)
					{
						$list[$k]['isCanRecash']=true;
					}else
					{
						$list[$k]['isCanRecash']=false;
					}
				}	
				return $list;
			}else
			{
				$this->err_get(4);
			}
        }	
    }
   
    /**
	 * recash_apply 提现申请初始化
	 * @return [type] [description]
	 */
    public function recash_init(){
    	isset($this->params["userid"])?$user_id = $this->params["userid"] : $user_id = ''; //用户名
    	isset($this->params["dlid"])?$fl_senddlid = $this->params["dlid"] : $fl_senddlid = ''; //发款人ID
 		if(!$this->is_jxuser_login($user_id)){
			$this->err_get(5);
        }else
        {
        	//收款代理
	        $Dealer= M('Dealer');
			$map=array();
			$map['dl_id']=$user_id;
			$map['dl_unitcode']=$this->qy_unitcode;
			$map['dl_status']=1;
			$data=$Dealer->where($map)->find();
			if($data){
				$dl_name=$data['dl_name'];
				$dl_username=$data['dl_username'];
				$dl_number=$data['dl_number'];
				$dl_tel=$data['dl_tel'];
				$dl_lastflid=$data['dl_lastflid'];
				$dl_fanli=$data['dl_fanli'];
			}else{
				$this->err_get(6);
			}
			//-------------
			//付款代理
			if($fl_senddlid==0){
				$fl_sdl_name='总公司';
				$fl_sdl_username='';
			}else{
				$map3=array();
				$data3=array();
				$map3['dl_id']=$fl_senddlid;
				$map3['dl_unitcode']=$this->qy_unitcode;
				$data3=$Dealer->where($map3)->find();
				if($data3){
					$fl_sdl_name=$data3['dl_name'];
					$fl_sdl_username=$data3['dl_username'];
				}else{
					$this->err_get('付款代理不存在');
				}
			}
			$Fanlidetail= M('Fanlidetail');
			//统计待收返利 
			$map3=array();
			$map3['fl_dlid']=$user_id; //返利收方
			$map3['fl_senddlid']=$fl_senddlid; //返利发方
			$map3['fl_unitcode']=$this->qy_unitcode;
			$map3['fl_state']=0;  //0-待收款 1-已收款 2-收款中  9-已取消
			$dl_fanli=0;
			$dl_fanli = $Fanlidetail->where($map3)->sum('fl_money');
			if($dl_fanli<=0){
				$this->err_get('待收返利为0');
			}
			
			//统计可提现金额
			$map3=array();
			$map3['fl_dlid']=$user_id; //返利收方
			$map3['fl_senddlid']=$fl_senddlid; //返利发方
			$map3['fl_unitcode']=$this->qy_unitcode;
			$map3['fl_state']=0;  //0-待收款 1-已收款 2-收款中  9-已取消
			$map3['fl_addtime']=array('lt',time()-3600*24*C('FANLI_JIANGETIME'));
			$dl_fanli2=0;
			$dl_fanli2 = $Fanlidetail->where($map3)->sum('fl_money');
			//if($dl_fanli2<=0){
			//	$this->error('可提现金额为0','',2);
			//}
			$bankarr=C('FANLI_BANKS'); //提现银行

			$qy_fwkey=$this->qy_fwkey;
			$qy_fwsecret=$this->qy_fwsecret;
			$ttamp=time();
			$sture=MD5($qy_fwkey.$ttamp.$qy_fwsecret);

			$ret=array('edurecash' =>C('FANLI_RECASH'),'jiangetime'=>C('FANLI_JIANGETIME'),'fl_senddlid'=>$fl_senddlid,'dl_name'=>$dl_name,'dl_username'=>$dl_username,'fl_sdl_name'=>$fl_sdl_name,'fl_sdl_username'=>$fl_sdl_username,'dl_fanli'=>$dl_fanli,'dl_fanli2'=>$dl_fanli2,'bankarr'=>$bankarr,'ttamp'=>$ttamp,'sture'=>$sture);
			return $ret;
        }
    }

    //返利提现 保存
    public function recash_save(){
    	isset($this->params["userid"])?$user_id = $this->params["userid"] : $user_id = ''; //用户名
    	isset($this->params["dlid"])?$fl_senddlid = $this->params["dlid"] : $fl_senddlid = ''; //发款人ID
    	isset($this->params["rc_bank"])?$rc_bank = $this->params["rc_bank"] : $rc_bank = ''; //收款银行ID
    	isset($this->params["rc_bankcard"])?$rc_bankcard = $this->params["rc_bankcard"] : $rc_bankcard = ''; //银行卡号
    	isset($this->params["rc_pwd"])?$rc_pwd = $this->params["rc_pwd"] : $rc_pwd = ''; //银行卡号
    	isset($this->params["ttamp"])?$ttamp = $this->params["ttamp"] : $ttamp = ''; //发款人ID
    	isset($this->params["sture"])?$sture = $this->params["sture"] : $sture = ''; //发款人ID
 		if(!$this->is_jxuser_login($user_id)){
			$this->err_get(5);
        }else
        {
        	$Dealer= M('Dealer');
			$map=array();
			$map['dl_id']=$user_id;
			$map['dl_unitcode']=$this->qy_unitcode;
			$map['dl_status']=1;
			$data=$Dealer->where($map)->find();
			if($data){
				$dl_name=$data['dl_name'];
				$dl_username=$data['dl_username'];
				$dl_number=$data['dl_number'];
				$dl_tel=$data['dl_tel'];
				$dl_lastflid=$data['dl_lastflid'];
				$dl_fanli=$data['dl_fanli'];
				$dl_pwd=$data['dl_pwd'];
			}else{
				$this->err_get(6);
			}

			// $fwkey=$this->qy_fwkey;
			// $qy_fwsecret=$this->qy_fwsecret;
			// $nowtime=time();
			// if(MD5($fwkey.$ttamp.$qy_fwsecret)!=$sture){
			// 	$this->err_get(2);
			// }
			// if(($nowtime - $ttamp) > 1200) {
			// 	$this->err_get(2);
			// }
			$rc_name=$dl_name;
			if($rc_bank<=0){
				$this->err_get('请选择开户银行');
			}
			if($rc_bankcard==''){
				$this->err_get('请填写卡号或支付宝账号');
			}
			if($rc_name==''){
				$this->err_get('请填写卡号/账号对应的姓名');
			}
			if($rc_pwd==''){
				$this->err_get('请填写该帐号的登录密码');
			}
			if($dl_pwd!=MD5(MD5(MD5($rc_pwd)))){
				$this->err_get('填写该帐号的登录密码错误');
			}

			//统计可提现金额
			$Fanlidetail= M('Fanlidetail');
			$oktime=time()-3600*24*C('FANLI_JIANGETIME');
			$map3=array();
			$map3['fl_dlid']=$user_id; //返利收方
			$map3['fl_senddlid']=$fl_senddlid; //返利发方
			$map3['fl_unitcode']=$this->qy_unitcode;
			$map3['fl_state']=0;  //0-待收款 1-已收款 2-收款中  9-已取消
			$map3['fl_addtime']=array('lt',$oktime);
			$rc_money=0;
			$rc_money = $Fanlidetail->where($map3)->sum('fl_money');
			if($rc_money<=0){
				$this->err_get('可提现金额为0');
			}
			
	        if(null !== C('FANLI_RECASH')){
				if($rc_money<C('FANLI_RECASH')){
				    $this->err_get('提取金额必须'.C('FANLI_RECASH').'以上');
			    }
			}else{
				if($rc_money<100){
				    $this->err_get('提取金额必须100以上');
			    }
			}
			$rc_money=number_format($rc_money,2,'.','');
	        $rc_bankcard_encode=\Org\Util\Funcrypt::authcode($rc_bankcard,'ENCODE',C('WWW_AUTHKEY'),0);

			$data2=array();
			$data2['rc_unitcode']=$this->qy_unitcode;
			$data2['rc_dlid']=$user_id;  //提现的代理id
			$data2['rc_sdlid']=$fl_senddlid;    //发放提现的代理id 0-公司
			$data2['rc_money']=$rc_money;
			$data2['rc_bank']=$rc_bank;
			$data2['rc_bankcard']=$rc_bankcard_encode;
			$data2['rc_name']=$rc_name;
			$data2['rc_addtime']=time();
			$data2['rc_dealtime']=0;
			$data2['rc_state']=0;
			$data2['rc_remark']='';
			$data2['rc_ip']=real_ip();
			$rc_verify=MD5($data2['rc_unitcode'].$data2['rc_dlid'].$data2['rc_money'].$data2['rc_bankcard'].$data2['rc_addtime']); //验证串
			$data2['rc_verify']=$rc_verify;
			$Recash= M('Recash');
			$rs=$Recash->create($data2,1);
			$result = $Recash->add();  
			if($result){
				$map3=array();
				$map3['fl_dlid']=$user_id; //返利收方
				$map3['fl_senddlid']=$fl_senddlid; //返利发方
				$map3['fl_unitcode']=$this->qy_unitcode;
				$map3['fl_state']=0;  //0-待收款 1-已收款 2-收款中  9-已取消
				$map3['fl_addtime']=array('lt',$oktime);

				$data3=array();
				$data3['fl_state'] = 2;
				$data3['fl_rcid'] = $result;
				$Fanlidetail->where($map3)->data($data3)->save();
				
				//代理操作日志 begin
				$odlog_arr=array(
							'dlg_unitcode'=>$this->qy_unitcode,  
							'dlg_dlid'=>$user_id,
							'dlg_operatid'=>$user_id,
							'dlg_dlusername'=>$dl_name,
							'dlg_dlname'=>$dl_username,
							'dlg_action'=>'代理商申请提现',
							'dlg_type'=>1, //0-企业 1-经销商
							'dlg_addtime'=>time(),
							'dlg_ip'=>real_ip(),
							'dlg_link'=>$_SERVER["HTTP_HOST"].'/klapi/controller/fanli/recash_save',
							);
				$Dealerlogs = M('Dealerlogs');
				$rs3=$Dealerlogs->create($odlog_arr,1);
				if($rs3){
					$Dealerlogs->add();
				}
				//代理操作日志 end
				$ret='提现提交成功';
				return $ret;
			}else{
				$this->err_get('提现提交失败');
			}
        }
    }

    /**
	 * fanli_paylist_get 应付返利列表
	 * @return [type] [description]
	 */
    public function fanli_paylist_get(){
    	isset($this->params["userid"])?$user_id = $this->params["userid"]:$user_id = ''; //用户名
		isset($this->params["pagenum"]) ? $pagenum = $this->params["pagenum"] : $pagenum =1;
	    isset($this->params["pagecount"]) ? $pagecount = $this->params["pagecount"] : $pagecount =20;
	    // 查询状态为1的用户数据 并且每页显示10条数据 总记录数为1000
	    // $pageinit=[
	    //   'type'     => 'bootstrap',
	    //   'page' =>$pagenum,
	    //   // 'list_rows' =>$pagecount,
	    // ];
 		if(!$this->is_jxuser_login($user_id)){
			$this->err_get(5);
        }
		$Dealer= M('Dealer');
       	$Recash= M('Recash');
        $map=array();
        $map['rc_unitcode']=$this->qy_unitcode;
        $map['rc_sdlid']=$user_id;
		$list=$Recash->where($map)->order('rc_id DESC')->page($pagenum,$pagecount)->select();
		foreach($list as $k=>$v){ 
			$list[$k]['rc_moneystr']=number_format($data['rc_money'],2,'.','');	
			if(isset(C('FANLI_BANKS')[$v['rc_bank']])){
				$list[$k]['rc_str']='申请提现到 '.C('FANLI_BANKS')[$v['rc_bank']];
			}else{
				$list[$k]['rc_str']='申请提现';
			}

			if(MD5($v['rc_unitcode'].$v['rc_dlid'].number_format($v['rc_money'],2,'.','').$v['rc_bankcard'].$v['rc_addtime'])==$v['rc_verify']){
				if($v['rc_state']==0){
					$list[$k]['rc_statestr']='新提交';
				}else if($v['rc_state']==1){
					$list[$k]['rc_statestr']='提现成功';
				}else if($v['rc_state']==2){
					$list[$k]['rc_statestr']='提现失败';
				}else{
					$list[$k]['rc_statestr']='异常';
				}
            }else{
				if($v['rc_state']==0){
					$list[$k]['rc_statestr']='新提交[异常]';
				}else if($v['rc_state']==1){
					$list[$k]['rc_statestr']='提现成功[异常]';
				}else if($v['rc_state']==2){
					$list[$k]['rc_statestr']='提现失败[异常]';
				}else{
					$list[$k]['rc_statestr']='异常';
				}
			}

            //收款代理
			$map3=array();
			$data3=array();
			$map3['dl_id']=$v['rc_dlid'];
			$map3['dl_unitcode']=$this->qy_unitcode;
			$data3=$Dealer->where($map3)->find();
			if($data3){
				$list[$k]['fl_rdl_name']=$data3['dl_name'];
				$list[$k]['fl_rdl_username']=$data3['dl_username'];
			}else{
				$list[$k]['fl_rdl_name']='';
				$list[$k]['fl_rdl_username']='';
			}
		}

		$has_more=false;
		//是否有下页
		$nextls =$Recash->where($map)->order('rc_id DESC')->page($pagenum+1,$pagecount)->select(); 
	    if (is_not_null($nextls))
		{
			$has_more=true;
		}
	    $ret=array('current_page' =>$pagenum,'has_more' =>$has_more,'data'=>$list);
	    return $ret;
    }

    /**
	 * fanli_paydetail_get 应付返利详情
	 * @return [type] [description]
	 */
    public function fanli_paydetail_get(){
    	isset($this->params["userid"])?$user_id = $this->params["userid"]:$user_id = ''; //用户名
    	isset($this->params["rc_id"])?$rc_id = $this->params["rc_id"]:$rc_id = ''; //用户名
		if(!$this->is_jxuser_login($user_id)){
			$this->err_get(5);
        }

        $Recash= M('Recash');
        $map=array();
		$map['rc_id']=$rc_id;
		$map['rc_unitcode']=$this->qy_unitcode;
		$map['rc_sdlid']=$user_id;
		$data=$Recash->where($map)->find();
		if($data){
			$data['rc_moneystr']=number_format($data['rc_money'],2,'.','');	
			if(isset(C('FANLI_BANKS')[$data['rc_bank']])){
				$data['rc_bankstr']=C('FANLI_BANKS')[$data['rc_bank']];
			}else{
				$data['rc_bankstr']='';
			}
			$data['rc_bankcardstr']=\Org\Util\Funcrypt::authcode($data['rc_bankcard'],'DECODE',C('WWW_AUTHKEY'),0);
			
            if(MD5($data['rc_unitcode'].$data['rc_dlid'].number_format($data['rc_money'],2,'.','').$data['rc_bankcard'].$data['rc_addtime'])==$data['rc_verify']){
				if($data['rc_state']==0){
					$data['rc_statestr']='处理中';
				}else if($data['rc_state']==1){
					$data['rc_statestr']='提现成功';
				}else if($data['rc_state']==2){
					$data['rc_statestr']='提现失败';
				}else{
					$data['rc_statestr']='异常';
				}
            }else{
				if($data['rc_state']==0){
					$data['rc_statestr']='新提交[异常]';
				}else if($data['rc_state']==1){
					$data['rc_statestr']='付款成功[异常]';
				}else if($data['rc_state']==2){
					$data['rc_statestr']='付款失败[异常]';
				}else{
					$data['rc_statestr']='异常';
				}
			}
			
			//提现代理信息
			if($data['rc_dlid']>0){
				$map2=array();
				$Dealer= M('Dealer');
				$map2['dl_id']=$data['rc_dlid'];
				$map2['dl_unitcode']=$this->qy_unitcode;
				$data2=$Dealer->where($map2)->find();
				if($data2){
					if($data2['dl_status']==1){
						$data['dl_name_str']=$data2['dl_name'].'('.$data2['dl_username'].')';
					}else{
					    $data['dl_name_str']=$data2['dl_name'].'('.$data2['dl_username'].')[已禁用]';
					}
				}else{
					$data['dl_name_str']='未知';
				}
			}else{
				$data['dl_name_str']='未知';
			}
			
			//付款代理
			if($data['rc_sdlid']>0){
				$map2=array();
				$map2['dl_id']=$data['rc_sdlid'];
				$map2['dl_unitcode']=$this->qy_unitcode;
				$data2=$Dealer->where($map2)->find();
				if($data2){
					$data['dl_sendname_str']=$data2['dl_name'].'('.$data2['dl_username'].')';
				}else{
					$data['dl_sendname_str']='未知';
				}
			}else{
				$data['dl_sendname_str']='总公司';
			}
			
			$imgpath = BASE_PATH.'/Public/uploads/orders/';
			//图片
            if(is_not_null($data['rc_pic']) && file_exists($imgpath.$data['rc_pic'])){
                $data['rc_pic_str']=$this->ODPath.$data['rc_pic'];
            }else{
                $data['rc_pic_str']='';
            }

            return $data;
		}else
		{
			$this->err_get(4);
		}
    }

    /**
	 * fanli_pay_save 支付返利保存
	 * @return [type] [description]
	 */
    public function fanli_pay_save(){
    	isset($this->params["userid"])?$user_id = $this->params["userid"]:$user_id = ''; //用户名
    	isset($this->params["rc_id"])?$rc_id = $this->params["rc_id"]:$rc_id = ''; //
    	isset($this->params["rc_state"])?$rc_state = $this->params["rc_state"]:$rc_state = ''; //
    	isset($this->params["rc_remark"])?$rc_remark = $this->params["rc_remark"]:$rc_remark = ''; //
    	isset($this->params["file_name"])?$file_name = $this->params["file_name"]:$file_name = ''; //
		if(!$this->is_jxuser_login($user_id)){
			$this->err_get(5);
        }else
        {
        	$Dealer= M('Dealer');
			$map=array();
			$map['dl_id']=$user_id;
			$map['dl_unitcode']=$this->qy_unitcode;
			$map['dl_status']=1;
			$data=$Dealer->where($map)->find();
			if($data){
				$dl_name=$data['dl_name'];
				$dl_username=$data['dl_username'];
				$dl_number=$data['dl_number'];
				$dl_tel=$data['dl_tel'];
				$dl_lastflid=$data['dl_lastflid'];
				$dl_fanli=$data['dl_fanli'];
				$dl_pwd=$data['dl_pwd'];
			}else{
				$this->err_get(6);
			}

	        if($rc_state<=0){
				$this->err_get('请选择处理状态');
			}
			if($rc_remark==''){
				$this->err_get('请填写处理备注');
			}
			if($rc_id>0){	
				$map=array();
				$Recash= M('Recash');
			    $map['rc_id']=$rc_id;
				$map['rc_sdlid']=$user_id;
			    $map['rc_unitcode']=$this->qy_unitcode;
				$data=$Recash->where($map)->find();
				if($data){
					$data2=array();
					if($data['rc_dealtime']<=0){
					   $data2['rc_dealtime']=time();
					}
					
					//保存文件 begin 
					$rc_pic='';
					if($file_name==''){
						$this->err_get('请上传图片');
					}else{
						$imgpath=BASE_PATH.'/Public/uploads/orders/'.$this->qy_unitcode;
						$temppath=BASE_PATH.'/Public/uploads/temp/';
						if (!file_exists($imgpath)) {
							mkdir($imgpath);
						}
						if(copy($temppath.$file_name,$imgpath.'/'.$file_name)) {
						    $rc_pic=$this->qy_unitcode.'/'.$file_name;
							@unlink($temppath.$file_name); 
						}else{
	                        $this->err_get('上传图片失败');
						}
					}
					//保存文件 end
					if($rc_pic==''){
						$this->err_get('上传图片失败');
					}else{
						$data2['rc_pic']=$rc_pic;
					}
					
	                $data2['rc_state']=$rc_state;
					$data2['rc_remark']=$rc_remark;
					$data2['rc_remark2']=$rc_remark2;
					
	                $rs=$Recash->where($map)->data($data2)->save();
					if($rs){
						//更改返利明细状态
						$Fanlidetail= M('Fanlidetail');
						$map3=array();
						$map3['fl_dlid']=$data['rc_dlid']; //返利收方
						$map3['fl_senddlid']=$data['rc_sdlid']; //返利发方
						$map3['fl_unitcode']=$this->qy_unitcode;
						$map3['fl_rcid']=$data['rc_id'];
						$map3['fl_state']=2;  //0-待收款 1-已收款 2-收款中  9-已取消

						$data3=array();
						if($rc_state==1){
							$data3['fl_state'] = 1;
						}else if($rc_state==2){
							$data3['fl_state'] =2;
						}
						$Fanlidetail->where($map3)->data($data3)->save();				
						
		                //记录日志 begin
						$log_arr=array();
						$log_arr=array(
									'log_qyid'=>$user_id,
									'log_user'=>$dl_username,
									'log_qycode'=>$this->qy_unitcode,
									'log_action'=>'处理提现',
									'log_type'=>2, //0-系统 1-企业 2-经销商 3-消费者
									'log_addtime'=>time(),
									'log_ip'=>real_ip(),
									'log_link'=>$_SERVER["HTTP_HOST"].'/klapi/controller/fanli/fanli_pay_save',
									'log_remark'=>json_encode(array_merge($data,$data2))
									);
						save_log($log_arr);
						//记录日志 end
						$ret='处理提交成功';
						return $ret;					
					}else if($rs==0){
						$this->err_get('提交数据没改变');
					}else{
						$this->err_get('提交失败');
					}
				}else{
					$this->err_get('没有该记录');
				}
			}else{
				$this->err_get('没有该记录');
			}
		}
    }
    /**
	 * fanli_award_list_get 返利奖励列表
	 * @return [type] [description]
	 */
    public function fanli_award_list_get(){
    	isset($this->params["userid"])?$user_id = $this->params["userid"]:$user_id = ''; //用户名
    	isset($this->params["yj_type"])?$yj_type = $this->params["yj_type"]:$yj_type = ''; //0、每月业绩1、年度业绩2、总业绩
 		isset($this->params["pagenum"]) ? $pagenum = $this->params["pagenum"] : $pagenum =1;
	    isset($this->params["pagecount"]) ? $pagecount = $this->params["pagecount"] : $pagecount =20;
		if(!$this->is_jxuser_login($user_id)){
			$this->err_get(5);
        }else
        {
        	$Salemonthly= M('Salemonthly');
			$Fanlidetail= M('Fanlidetail');
			$Salemonfanlirate= M('Salemonfanlirate');
			$Dealer= M('Dealer');
			$Orders= M('Orders');
			
	        $map3=array();
			$data3=array();
			$map3['dl_id']=$user_id;
			$map3['dl_unitcode']=$this->qy_unitcode;
			$data3=$Dealer->where($map3)->find();
			if($data3){
				$Dltype= M('Dltype');
				$map2=array();
				$map2['dlt_unitcode']=$this->qy_unitcode;
				$map2['dlt_id']=$data3['dl_type'];
				$data2 = $Dltype->where($map2)->find();
				if($data2){
					$dlt_level=$data2['dlt_level'];
					// $dl_type=$data2['dl_type'];
					$dlt_type=$data3['dl_type'];
				}else{
					$dlt_level=0;
					$dlt_type=0;
				}
				$dl_referee=$data3['dl_referee'];
				$dl_belong=$data3['dl_belong'];
			}else{
	            $this->err_get(6);
			}
			
			//只有前2级才有 按月业绩奖金
		    if($dlt_level==2 || $dlt_level==3){
				//当月业绩
				$yearmonth=date('Y-m',time());
				$ndays=date("t",strtotime($yearmonth)); //天数
				$nbegintime=strtotime($yearmonth);
				$nendtime=$nbegintime+3600*24*$ndays;
				
				//自己的业绩
				// 对应订单
				$Model=M();
				$map2=array();
				$nsalesum=0;
				$nodsum=0;
				//下单的金额(只统计已发货、已完成) 
				$map2['a.od_unitcode']=$this->qy_unitcode;
				$map2['a.od_oddlid']=$user_id;
				$map2['a.od_state']=array('IN','3,8');
				$map2['a.od_virtualstock']=1;
				$map2['a.od_fugou']=1;
				$map2['a.od_expressdate']=array('between',array($nbegintime,$nendtime));
				$map2['a.od_id']=array('exp','=b.oddt_odid');
				$map2['a.od_orderid']=array('exp','=b.oddt_orderid');
				// $order = $Model->table('fw_orders a,fw_orderdetail b')->where($map2)->field('od_id,od_total,oddt_qty')->select();
				// $nodsum = $Model->table('fw_orders a,fw_orderdetail b')->where($map2)->sum('od_total'); 
				$subQuery = $Model->field('a.od_id,a.od_total,a.od_expressfee')->table('fw_orders a,fw_orderdetail b')->group('a.od_id')->where($map2)->buildSql(); //tp3.2子查询
				$nodsum =$Model->table($subQuery.'a')->sum('a.od_total');
				$nodqtysum = $Model->table('fw_orders a,fw_orderdetail b')->where($map2)->sum('oddt_qty'); 
				if($nodsum){

				}else{
					$nodsum=0;
					$nodqtysum=0;
				}

				$Model=M();
				//第一级团队业绩
				$fistteamsum=0;   
				$fistteamqtysum=0;    
				$secondteamsum=0;   
				$secondteamqtysum=0;    
				$map2=array();
				$map2['dl_unitcode']=$this->qy_unitcode;
				$map2['dl_belong']=$dl_belong;
				$map2['dl_referee']=$user_id;
				$map2['dl_level']=$dlt_level;
				$list2 = $Dealer->where($map2)->order('dl_id DESC')->select();
				foreach($list2 as $kk=>$vv){
					$dl2_id=$vv['dl_id'];
					$map2=array();
					$map2['a.od_oddlid']=$dl2_id;
					$map2['a.od_unitcode']=$this->qy_unitcode;
					$map2['a.od_state']=array('IN','3,8');
					$map2['a.od_virtualstock']=1;
					$map2['a.od_fugou']=1;
					$map2['a.od_expressdate']=array('between',array($nbegintime,$nendtime));
					$map2['a.od_id']=array('exp','=b.oddt_odid');
					$map2['a.od_orderid']=array('exp','=b.oddt_orderid');
					// $nodsum2 = $Model->table('fw_orders a,fw_orderdetail b')->where($map2)->sum('od_total'); 
					$subQuery = $Model->field('a.od_id,a.od_total,a.od_expressfee')->table('fw_orders a,fw_orderdetail b')->group('a.od_id')->where($map2)->buildSql(); //tp3.2子查询
					$nodsum2 =$Model->table($subQuery.'a')->sum('a.od_total');
					$nodqtysum2 = $Model->table('fw_orders a,fw_orderdetail b')->where($map2)->sum('oddt_qty'); 
					if($nodsum2){
						$fistteamsum+=$nodsum2;
						$fistteamqtysum+=$nodqtysum2;
					}
					$map3=array();
					$map3['dl_unitcode']=$this->qy_unitcode;
					$map3['dl_belong']=$dl_belong;
					$map3['dl_referee']=$dl2_id;
					$map2['dl_level']=$dlt_level;
					$list3 = $Dealer->where($map3)->order('dl_id DESC')->select();
					foreach($list3 as $k3=>$v3){
						$dl3_id=$v3['dl_id'];
						$map2=array();
						$map2['a.od_oddlid']=$v3['dl_id'];
						$map2['a.od_unitcode']=$this->qy_unitcode;
						$map2['a.od_state']=array('IN','3,8');
						$map2['a.od_virtualstock']=1;
						$map2['a.od_fugou']=1;
						$map2['a.od_expressdate']=array('between',array($nbegintime,$nendtime));
						$map2['a.od_id']=array('exp','=b.oddt_odid');
						$map2['a.od_orderid']=array('exp','=b.oddt_orderid');
						// $nodsum3 =$Model->table('fw_orders a,fw_orderdetail b')->where($map2)->sum('od_total'); 
						$subQuery = $Model->field('a.od_id,a.od_total,a.od_expressfee')->table('fw_orders a,fw_orderdetail b')->group('a.od_id')->where($map2)->buildSql(); //tp3.2子查询
						$nodsum3 =$Model->table($subQuery.'a')->sum('a.od_total');
						$nodqtysum3 =$Model->table('fw_orders a,fw_orderdetail b')->where($map2)->sum('oddt_qty'); 
						if($nodsum3){
							$secondteamsum+=$nodsum3;
							$secondteamqtysum+=$nodqtysum3;
						}
					}
				}

				$nsalesum=$nodsum+$fistteamsum+$secondteamsum;
				$nsaleqtysum=$nodqtysum+$fistteamqtysum+$secondteamqtysum;

				if ($yj_type==0)
				{

					//计算生成业绩及奖金 begin 前3个月
					$map2=array();
					$map2['smfr_unitcode']=$this->qy_unitcode;
					$map2['smfr_dltype']=$dlt_type;
					$map2['smfr_countdate']=1; //按月奖励
		            $fanlilist = $Salemonfanlirate->where($map2)->order('smfr_minsale ASC')->select();
					
					$yearmonth=date('Y-m',time()); //当前年月
					$yearlist=array();

					// $yearlist[]=strtotime("$nyearmonth 0 month");
					$yearlist[]=strtotime("$nyearmonth -1 month");
					$yearlist[]=strtotime("$nyearmonth -2 month");
					$yearlist[]=strtotime("$nyearmonth -3 month");
					
					foreach($yearlist as $k=>$v){
					    if($v<$yearmonth&&$v!==FALSE){
							$map7=array();
							$data7=array();
							$map7['sm_unitcode'] = $this->qy_unitcode;
							$map7['sm_dlid'] =$user_id;
							$map7['sm_date'] = $v;
							$map7['sm_yjtype'] =0;
							$data7 = $Salemonthly->where($map7)->find();
							if(!$data7){
								if(date('d',time())>=1){//当月1号后才允许生成
									$days=date("t",$v); //天数
									$nbegintime=strtotime(date('Y-m-01 00:00:00',$v));
									//$nendtime=strtotime(date('Y-m-d H:i:s',$v));
									$nendtime=$nbegintime+3600*24*$days;

									// var_dump(date('Y-m-d H:i:s',$nbegintime));
									// var_dump(date('Y-m-d H:i:s',$nendtime));
									//自己的业绩
									//下单的金额(只统计已发货、已完成) 
									$odsum=0;
									$map2=array();
									$map2['a.od_oddlid']=$user_id;
									$map2['a.od_unitcode']=$this->qy_unitcode;
									$map2['a.od_state']=array('IN','3,8');
									$map2['a.od_virtualstock']=1;
									$map2['a.od_fugou']=1;
									$map2['a.od_expressdate']=array('between',array($nbegintime,$nendtime));
									$map2['a.od_id']=array('exp','=b.oddt_odid');
									$map2['a.od_orderid']=array('exp','=b.oddt_orderid');
									// $odsum =$Model->table('fw_orders a,fw_orderdetail b')->where($map2)->sum('od_total'); 
									$subQuery = $Model->field('a.od_id,a.od_total,a.od_expressfee')->table('fw_orders a,fw_orderdetail b')->group('a.od_id')->where($map2)->buildSql(); //tp3.2子查询
									$odsum =$Model->table($subQuery.'a')->sum('a.od_total');
									$odqtysum =$Model->table('fw_orders a,fw_orderdetail b')->where($map2)->sum('oddt_qty'); 
									if($odsum){

									}else{
										$odsum=0;
										$odqtysum=0;
									}
									// var_dump($odsum);
									// exit;
									//团队业绩
									//第一级团队业绩
									$fistodsum=0;
									$fistodqtysum=0;    
									$secondodsum=0;      
									$secondodqtysum=0;    
									$map2=array();
									$map2['dl_unitcode']=$this->qy_unitcode;
									$map2['dl_belong']=$dl_belong;
									$map2['dl_referee']=$user_id;
									$map2['dl_level']=$dlt_level;
									$list2 = $Dealer->where($map2)->order('dl_id DESC')->select();
									foreach($list2 as $kk=>$vv){
										$dl2_id=$vv['dl_id'];
										$map2=array();
										$map2['a.od_oddlid']=$dl2_id;
										$map2['a.od_unitcode']=$this->qy_unitcode;
										$map2['a.od_state']=array('IN','3,8');
										$map2['a.od_virtualstock']=1;
										$map2['a.od_fugou']=1;
										$map2['a.od_expressdate']=array('between',array($nbegintime,$nendtime));
										$map2['a.od_id']=array('exp','=b.oddt_odid');
										$map2['a.od_orderid']=array('exp','=b.oddt_orderid');
										// $odsum2 =$Model->table('fw_orders a,fw_orderdetail b')->where($map2)->sum('od_total'); 
										$subQuery = $Model->field('a.od_id,a.od_total,a.od_expressfee')->table('fw_orders a,fw_orderdetail b')->group('a.od_id')->where($map2)->buildSql(); //tp3.2子查询
										$odsum2 =$Model->table($subQuery.'a')->sum('a.od_total');
										$odqtysum2 =$Model->table('fw_orders a,fw_orderdetail b')->where($map2)->sum('oddt_qty'); 
										if($odsum2){
											$fistodsum+=$odsum2;
											$fistodqtysum+=$odqtysum2;
										}
										//第二级团队业绩
										$map3=array();
										$map3['dl_unitcode']=$this->qy_unitcode;
										$map3['dl_belong']=$dl_belong;
										$map3['dl_referee']=$dl2_id;
										$map2['dl_level']=$dlt_level;
										$list3 = $Dealer->where($map3)->order('dl_id DESC')->select();
										foreach($list3 as $k3=>$v3){
											$dl3_id=$v3['dl_id'];
											$map2=array();
											$map2['a.od_oddlid']=$dl3_id;
											$map2['a.od_unitcode']=$this->qy_unitcode;
											$map2['a.od_state']=array('IN','3,8');
											$map2['a.od_virtualstock']=1;
											$map2['a.od_fugou']=1;
											$map2['a.od_expressdate']=array('between',array($nbegintime,$nendtime));
											$map2['a.od_id']=array('exp','=b.oddt_odid');
											$map2['a.od_orderid']=array('exp','=b.oddt_orderid');
											// $odsum3 =$Model->table('fw_orders a,fw_orderdetail b')->where($map2)->sum('od_total'); 
											$subQuery = $Model->field('a.od_id,a.od_total,a.od_expressfee')->table('fw_orders a,fw_orderdetail b')->group('a.od_id')->where($map2)->buildSql(); //tp3.2子查询
											$odsum3 =$Model->table($subQuery.'a')->sum('a.od_total');
											$odqtysum3 =$Model->table('fw_orders a,fw_orderdetail b')->where($map2)->sum('oddt_qty'); 
											if($odsum3){
												$secondodsum+=$odsum3;
												$secondodqtysum+=$odqtysum3;
											}
										}
									}
								
									//奖金计算
									$saletotal=$odsum+$fistodsum+$secondodsum;
									$saleqtytotal=$odqtysum+$fistodqtysum+$secondodqtysum;

									$dl_reward=0;
									$dl_reward0=0;
									$dl_reward1=0;
									$dl_reward2=0;
									foreach($fanlilist as $kkk=>$vvv){
										if ($vvv['smfr_saleunit']==1)
										{
											if($saletotal>=$vvv['smfr_minsale'] && $saletotal<$vvv['smfr_maxsale']){
												if($vvv['smfr_fanlieval']==1){
													$dl_reward=$vvv['smfr_fanlirate'];
												}else {
													$dl_reward0=$odsum*$vvv['smfr_fanlirate'];
													$dl_reward1=$fistodsum*0.03;
													$dl_reward2=$secondodsum*0.02;
													$dl_reward=$dl_reward0+$dl_reward1+$$dl_reward2;
												}
											}
										}
										else
										{
											if($saleqtytotal>=$vvv['smfr_minsale'] && $saleqtytotal9<$vvv['smfr_maxsale']){
												if($vvv['smfr_fanlieval']==1){
													$dl_reward=$vvv['smfr_fanlirate'];
												}else {
													$dl_reward=$saleqtytotal*$vvv['smfr_fanlirate'];
												}
											}
										}	
									}
									//写入返利
									//发款方
									// if($dl_referee>0){
									// 	$map2=array();
									// 	$map2['dl_unitcode'] = $this->qy_unitcode;
									// 	$map2['dl_id'] = $dl_referee;
									// 	$map2['dl_type'] = $dl_type;
									// 	$data22 = $Dealer->where($map2)->find();
									// 	if($data22){
									// 		$sm_senddlid = $dl_referee;  
									// 	}else{
									// 		$sm_senddlid=0;  
									// 	}
									// }else{
									// 	$sm_senddlid=0;  
									// }
									
									// //如果有销售有奖金
							        if($odsum>0 && ($fistodsum>0 || $secondodsum>0) && $dl_reward>0){
							        	if ($dl_reward0>0)
							        	{
											$data5=array();
											$data5['fl_unitcode'] = $this->qy_unitcode;
											$data5['fl_dlid'] =$user_id; //获得返利的代理
											$data5['fl_senddlid'] =0 ; //$sm_senddlid发放返利的代理
											$data5['fl_type'] = 4; //返利分类 1-推荐返利 2-订单返利 3-销售累计奖 4-按月销售奖 5按年度销售奖 11-提现减少返利 (1-10 增加返利 11-20 减少返利)  
											$data5['fl_money'] = $dl_reward0;
											$data5['fl_refedlid'] = 0; //推荐返利中被推荐的代理
											$data5['fl_oddlid'] = 0; //订单返利中 下单的代理
											$data5['fl_odid'] = 0;  //订单返利中 订单流水id
											$data5['fl_orderid']  = ''; //订单返利中 订单id
											$data5['fl_proid']  = 0;  //订单返利中 产品id
											$data5['fl_odblid']  = 0;  //订单返利中 订单关系id
											$data5['fl_qty']  = 0;  //订单返利中 产品数量
											$data5['fl_level']  = 0;  //返利的层次，0-自己的返利 1-第一层返利 2-第二层返利 
											$data5['fl_addtime']  = time();
											$data5['fl_remark'] ='我的'.date('Y年m月',$v).'销售奖:'.$dl_reward0;
											$rs5=$Fanlidetail->create($data5,1);
											if($rs5){
												$rsid=$Fanlidetail->add();
												if($rsid){
													//按月销售奖记录
													$data5=array();
													$data5['sm_unitcode'] = $this->qy_unitcode;
													$data5['sm_dlid'] = $user_id;;
													$data5['sm_senddlid'] = $sm_senddlid;
													$data5['sm_mysale'] = $odsum;
													$data5['sm_teamsale'] = $fistodsum+$secondodsum;
													$data5['sm_reward'] = $dl_reward0;
													$data5['sm_date'] = $v;
													$data5['sm_addtime'] = time();
													$data5['sm_flid'] = $rsid;
													$data5['sm_state'] = 1;
													$data5['sm_type'] = 0; //0、总业绩1、一级团队 2、二级团队
													$data5['sm_yjtype'] = 0;
													$data5['sm_remark'] = '我的'.date('Y年m月',$v).'销售业绩返利：'.$dl_reward;
													$Salemonthly->create($data5,1);
													$Salemonthly->add();
												}
											}
										}

										if ($dl_reward1>0)
							        	{
											$data5=array();
											$data5['fl_unitcode'] = $this->qy_unitcode;
											$data5['fl_dlid'] =$user_id; //获得返利的代理
											$data5['fl_senddlid'] =0 ; //$sm_senddlid发放返利的代理
											$data5['fl_type'] = 4; //返利分类 1-推荐返利 2-订单返利 3-销售累计奖 4-按月销售奖 5按年度销售奖 11-提现减少返利 (1-10 增加返利 11-20 减少返利)  
											$data5['fl_money'] = $dl_reward1;
											$data5['fl_refedlid'] = 0; //推荐返利中被推荐的代理
											$data5['fl_oddlid'] = 0; //订单返利中 下单的代理
											$data5['fl_odid'] = 0;  //订单返利中 订单流水id
											$data5['fl_orderid']  = ''; //订单返利中 订单id
											$data5['fl_proid']  = 0;  //订单返利中 产品id
											$data5['fl_odblid']  = 0;  //订单返利中 订单关系id
											$data5['fl_qty']  = 0;  //订单返利中 产品数量
											$data5['fl_level']  = 1;  //返利的层次，0-自己的返利 1-第一层返利 2-第二层返利 
											$data5['fl_addtime']  = time();
											$data5['fl_remark'] ='第一团队'.date('Y年m月',$v).'销售奖:'.$dl_reward1;
											$rs5=$Fanlidetail->create($data5,1);
											if($rs5){
												$rsid=$Fanlidetail->add();
												if($rsid){
													//按月销售奖记录
													$data5=array();
													$data5['sm_unitcode'] = $this->qy_unitcode;
													$data5['sm_dlid'] =$user_id;
													$data5['sm_senddlid'] = $sm_senddlid;
													$data5['sm_mysale'] = $odsum;
													$data5['sm_teamsale'] = $fistodsum;
													$data5['sm_reward'] = $dl_reward1;
													$data5['sm_date'] = $v;
													$data5['sm_addtime'] = time();
													$data5['sm_flid'] = $rsid;
													$data5['sm_state'] = 1;
													$data5['sm_type'] = 1;
													$data5['sm_yjtype'] = 0;
													$data5['sm_remark'] = '第一团队'.date('Y年m月',$v).'销售业绩返利：'.$dl_reward1;
													$Salemonthly->create($data5,1);
													$Salemonthly->add();
												}
											}
										}


										if ($dl_reward2>0)
							        	{
											$data5=array();
											$data5['fl_unitcode'] = $this->qy_unitcode;
											$data5['fl_dlid'] =$user_id; //获得返利的代理
											$data5['fl_senddlid'] =0 ; //$sm_senddlid发放返利的代理
											$data5['fl_type'] = 4; //返利分类 1-推荐返利 2-订单返利 3-销售累计奖 4-按月销售奖 5按年度销售奖 11-提现减少返利 (1-10 增加返利 11-20 减少返利)  
											$data5['fl_money'] = $dl_reward2;
											$data5['fl_refedlid'] = 0; //推荐返利中被推荐的代理
											$data5['fl_oddlid'] = 0; //订单返利中 下单的代理
											$data5['fl_odid'] = 0;  //订单返利中 订单流水id
											$data5['fl_orderid']  = ''; //订单返利中 订单id
											$data5['fl_proid']  = 0;  //订单返利中 产品id
											$data5['fl_odblid']  = 0;  //订单返利中 订单关系id
											$data5['fl_qty']  = 0;  //订单返利中 产品数量
											$data5['fl_level']  = 2;  //返利的层次，0-自己的返利 1-第一层返利 2-第二层返利 
											$data5['fl_addtime']  = time();
											$data5['fl_remark'] ='第二团队'.date('Y年m月',$v).'销售奖:'.$dl_reward2;
											$rs5=$Fanlidetail->create($data5,1);
											if($rs5){
												$rsid=$Fanlidetail->add();
												if($rsid){
													//按月销售奖记录
													$data5=array();
													$data5['sm_unitcode'] = $this->qy_unitcode;
													$data5['sm_dlid'] =$user_id;
													$data5['sm_senddlid'] = $sm_senddlid;
													$data5['sm_mysale'] = $odsum;
													$data5['sm_teamsale'] =$secondodsum;
													$data5['sm_reward'] = $dl_reward2;
													$data5['sm_date'] = $v;
													$data5['sm_addtime'] = time();
													$data5['sm_flid'] = $rsid;
													$data5['sm_state'] = 1;
													$data5['sm_type'] = 2;
													$data5['sm_yjtype'] = 0;
													$data5['sm_remark'] = '第二团队'.date('Y年m月',$v).'销售业绩返利：'.$dl_reward2;
													$Salemonthly->create($data5,1);
													$Salemonthly->add();
												}
											}
										}
										
									}else if($odsum>0 && ($fistodsum>0 || $secondodsum>0) && $dl_reward==0){ //有销售额 无奖金
										//按月销售奖记录
										$data5=array();
										$data5['sm_unitcode'] = $this->qy_unitcode;
										$data5['sm_dlid'] =$user_id;
										$data5['sm_senddlid'] = $sm_senddlid;
										$data5['sm_mysale'] = $odsum;
										$data5['sm_teamsale'] = $fistodsum+$secondodsum;
										$data5['sm_reward'] = 0;
										$data5['sm_date'] = $v;
										$data5['sm_addtime'] = time();
										$data5['sm_flid'] = 0;
										$data5['sm_state'] = 1;
										$data5['sm_type'] = 0;
										$data5['sm_yjtype'] = 0;
										$data5['sm_remark'] = '我的团队'.date('Y年m月',$v).'销售业绩返利：0,没达到返利销售额';
										$Salemonthly->create($data5,1);
										$Salemonthly->add();
									}
								}	
							}
						}
					}
					//计算生成业绩及奖金 end
				}else
				{		
					//计算生成总销量业绩及奖金 begin
					$Salemonfanlirate= M('Salemonfanlirate');
					$map2=array();
					$map2['smfr_unitcode']=$this->qy_unitcode;
					$map2['smfr_dltype']=$dlt_type;
					$map2['smfr_countdate']=2; //按年总销量
		            $fanlilist = $Salemonfanlirate->where($map2)->order('smfr_minsale ASC')->select();


		            //已经计算返利的时间   
		            $t = time(); 
					// $ystar = mktime(0,0,0,date('m',$t),date('d',$t),date('Y',$t)); //今年起点时间戳
					$yend = mktime(23,59,59,12,31,date('Y',$t)); //今年终点时间戳
		            $map2=array();
					$map2['fl_unitcode'] = $this->qy_unitcode;
					$map2['fl_dlid'] =$user_id; //获得返利的代理
					$map2['fl_senddlid'] =0 ; //$sm_senddlid发放返利的代理
					$map2['fl_type'] = 3; //返利分类 1-推荐返利 2-订单返利 3-销售累计奖 4-按月销售奖 5按年度销售奖 11-提现减少返利 (1-10 增加返利 11-20 减少返利) 
					$map2['fl_state'] =array('in','1,2');//待收和已收;
					$rs2=$Fanlidetail->where($map2)->order('fl_addtime DESC')->find();
					if ($rs2)
					{
						$ystar=$rs2['fl_addtime'];
					}

		            //自己的业绩
					//下单的金额(只统计已发货、已完成) 
					$odsum=0;
					$map2=array();
					$map2['a.od_oddlid']=$user_id;
					$map2['a.od_unitcode']=$this->qy_unitcode;
					$map2['a.od_state']=array('IN','3,8');
					$map2['a.od_virtualstock']=1;
					$map2['a.od_fugou']=1;
					if (is_not_null($ystar))
						$map2['a.od_expressdate']=array('between',array($ystar,$yend));
					else
						$map2['a.od_expressdate']=array('elt',strtotime('now'));
					$map2['a.od_id']=array('exp','=b.oddt_odid');
					$map2['a.od_orderid']=array('exp','=b.oddt_orderid');
					// $odsum=$Model->table('fw_orders a,fw_orderdetail b')->where($map2)->sum('od_total'); 
					$subQuery = $Model->field('a.od_id,a.od_total,a.od_expressfee')->table('fw_orders a,fw_orderdetail b')->group('a.od_id')->where($map2)->buildSql(); //tp3.2子查询
					$odsum =$Model->table($subQuery.'a')->sum('a.od_total');
					$odqtysum =$Model->table('fw_orders a,fw_orderdetail b')->where($map2)->sum('oddt_qty'); 
					if($odsum){

					}else{
						$odsum=0;
						$odqtysum=0;
					}
					// var_dump($odsum);
					// exit;
					//团队业绩
					//第一级团队业绩
					$fistodsum=0; 
					$fistodqtysum=0;    
					$secondodsum=0;   
					$secondodqtysum=0;    
					$map2=array();
					$map2['dl_unitcode']=$this->qy_unitcode;
					$map2['dl_belong']=$dl_belong;
					$map2['dl_referee']=session('jxuser_id');
					$map2['dl_level']=$dlt_level;
					$list2 = $Dealer->where($map2)->order('dl_id DESC')->select();
					foreach($list2 as $kk=>$vv){
						$dl2_id=$vv['dl_id'];
						$map2=array();
						$map2['a.od_oddlid']=$dl2_id;
						$map2['a.od_unitcode']=$this->qy_unitcode;
						$map2['a.od_state']=array('IN','3,8');
						$map2['a.od_virtualstock']=1;
						$map2['a.od_fugou']=1;
						if (is_not_null($ystar))
							$map2['a.od_expressdate']=array('between',array($ystar,$yend));
						else
							$map2['a.od_expressdate']=array('elt',strtotime('now'));
						$map2['a.od_id']=array('exp','=b.oddt_odid');
						$map2['a.od_orderid']=array('exp','=b.oddt_orderid');
						// $odsum2=$Model->table('fw_orders a,fw_orderdetail b')->where($map2)->sum('od_total'); 
						$subQuery = $Model->field('a.od_id,a.od_total,a.od_expressfee')->table('fw_orders a,fw_orderdetail b')->group('a.od_id')->where($map2)->buildSql(); //tp3.2子查询
						$odsum2 =$Model->table($subQuery.'a')->sum('a.od_total');
						$odqtysum2 =$Model->table('fw_orders a,fw_orderdetail b')->where($map2)->sum('oddt_qty'); 
						if($odsum2){
							$fistodsum+=$odsum2;
							$fistodqtysum+=$odqtysum2;
						}
						//第二级团队业绩
						$map3=array();
						$map3['dl_unitcode']=$this->qy_unitcode;
						$map3['dl_belong']=$dl_belong;
						$map3['dl_referee']=$dl2_id;
						$map2['dl_level']=$dlt_level;
						$list3 = $Dealer->where($map3)->order('dl_id DESC')->select();
						foreach($list3 as $k3=>$v3){
							$dl3_id=$v3['dl_id'];
							$map2=array();
							$map2['a.od_oddlid']=$dl3_id;
							$map2['a.od_unitcode']=$this->qy_unitcode;
							$map2['a.od_state']=array('IN','3,8');
							$map2['a.od_virtualstock']=1;
							$map2['a.od_fugou']=1;
							if (is_not_null($ystar))
								$map2['a.od_expressdate']=array('between',array($ystar,$yend));
							else
								$map2['a.od_expressdate']=array('elt',strtotime('now'));
							// $odsum3=$Model->table('fw_orders a,fw_orderdetail b')->where($map2)->sum('od_total'); 
							$subQuery = $Model->field('a.od_id,a.od_total,a.od_expressfee')->table('fw_orders a,fw_orderdetail b')->group('a.od_id')->where($map2)->buildSql(); //tp3.2子查询
							$odsum3 =$Model->table($subQuery.'a')->sum('a.od_total');
							$odqtysum3 =$Model->table('fw_orders a,fw_orderdetail b')->where($map2)->sum('oddt_qty'); 
							if($odsum3){
								$secondodsum+=$odsum3;
								$secondodqtysum+=$odqtysum3;
							}
						}
					}


		            $dl_reward=0;
		           //奖金计算
					$saletotal=$odsum+$fistodsum+$secondodsum;
					$saleqtyotal=$odqtysum+$fistodqtysum+$secondodqtysum;
					$dl_reward=0;
					foreach($fanlilist as $kkk=>$vvv){
						if ($vvv['smfr_saleunit']==1)
						{
							if($saletotal>=$vvv['smfr_minsale'] && $saletotal<$vvv['smfr_maxsale']){
								if($vvv['smfr_fanlieval']==1){
									$dl_reward+=$vvv['smfr_fanlirate'];
								}else {
									$dl_reward=$odsum*$vvv['smfr_fanlirate'];
								}
							}
						}
						else
						{
							if($saleqtyotal>=$vvv['smfr_minsale'] && $saleqtyotal<$vvv['smfr_maxsale']){
								if($vvv['smfr_fanlieval']==1){
									$dl_reward=$vvv['smfr_fanlirate'];
								}else {
									$dl_reward=$saleqtyotal*$vvv['smfr_fanlirate'];
								}
							}
						}	
					}

					$map7=array();
					$data7=array();
					$map7['sm_unitcode'] = $this->qy_unitcode;
					$map7['sm_dlid'] =$user_id;
					if (is_not_null($ystar))
						$map7['sm_date']=array('between',array($ystar,$yend));
					else
						$map7['sm_date']=array('elt',strtotime('now'));
					$map7['sm_jytype'] =2; //年度销售奖
					$data7 = $Salemonthly->where($map7)->find();
					if(!$data7){
						if ($saletotal>0 && $dl_reward>0){
							$data5=array();
							$data5['fl_unitcode'] = $this->qy_unitcode;
							$data5['fl_dlid'] =$user_id; //获得返利的代理
							$data5['fl_senddlid'] =0 ; //$sm_senddlid发放返利的代理
							$data5['fl_type'] = 3; //返利分类 1-推荐返利 2-订单返利 3-销售累计奖 4-按月销售奖 5按年度销售奖 11-提现减少返利 (1-10 增加返利 11-20 减少返利)  
							$data5['fl_money'] = $dl_reward;
							$data5['fl_refedlid'] = 0; //推荐返利中被推荐的代理
							$data5['fl_oddlid'] = 0; //订单返利中 下单的代理
							$data5['fl_odid'] = 0;  //订单返利中 订单流水id
							$data5['fl_orderid']  = ''; //订单返利中 订单id
							$data5['fl_proid']  = 0;  //订单返利中 产品id
							$data5['fl_odblid']  = 0;  //订单返利中 订单关系id
							$data5['fl_qty']  = 0;  //订单返利中 产品数量
							$data5['fl_level']  = 0;  //返利的层次，0-自己的返利 1-第一层返利 2-第二层返利 
							$data5['fl_addtime']  =time();
							if (is_not_null($ystar))
								$data5['fl_remark'] ='我的'.date('Y年m月d日 h:i:s',$ystar).'至'.date('Y年m月d日 h:i:s',time()).'销售累计奖:'.$dl_reward;
							else
								$data5['fl_remark'] ='我的'.date('Y年m月d日',time()).'销售累计奖:'.$dl_reward;
							$rs5=$Fanlidetail->create($data5,1);
							if($rs5){
								$rsid=$Fanlidetail->add();
								if($rsid){
									//按月销售奖记录
									$data5=array();
									$data5['sm_unitcode'] = $this->qy_unitcode;
									$data5['sm_dlid'] = $user_id;
									$data5['sm_senddlid'] = $sm_senddlid;
									$data5['sm_mysale'] = $odsum;
									$data5['sm_teamsale'] = $fistodsum+$secondodsum;
									$data5['sm_reward'] = $dl_reward;
									$data5['sm_date'] =time();
									$data5['sm_addtime'] =time();
									$data5['sm_flid'] = $rsid;
									$data5['sm_state'] = 1;
									$data5['sm_type'] = 0; //0、总业绩1、一级团队 2、二级团队
									$data5['sm_yjtype'] = 2; //0月 1年 2 总
									if (is_not_null($ystar))
										$data5['sm_remark'] ='我的'.date('Y年m月d日 h:i:s',$ystar).'至'.date('Y年m月d日 h:i:s',time()).'销售累计奖:'.$dl_reward;
									else
										$data5['sm_remark'] ='我的'.date('Y年m月d日',time()).'销售累计奖:'.$dl_reward;
									$Salemonthly->create($data5,1);
									$Salemonthly->add();
								}
							}
						}else if($saletotal>0 && $dl_reward==0){ //有销售额 无奖金
							//按月销售奖记录
							$data5=array();
							$data5['sm_unitcode'] = $this->qy_unitcode;
							$data5['sm_dlid'] = $user_id;
							$data5['sm_senddlid'] = $sm_senddlid;
							$data5['sm_mysale'] = $odsum;
							$data5['sm_teamsale'] = $fistodsum+$secondodsum;
							$data5['sm_reward'] = 0;
							$data5['sm_date'] =time();
							$data5['sm_addtime'] = time();
							$data5['sm_flid'] = 0;
							$data5['sm_state'] = 1;
							$data5['sm_type'] = 0;//0、总业绩1、一级团队 2、二级团队
							$data5['sm_yjtype'] = 2;//0月 1年 2 总
						   if (is_not_null($ystar))
								$data5['sm_remark'] ='我的'.date('Y年m月d日 h:i:s',$ystar).'至'.date('Y年m月d日 h:i:s',time()).'销售累计业绩返利：0,没达到返利销售额';
							else
								$data5['sm_remark'] ='我的'.date('Y年m月d日',time()).'销售累计业绩返利：0,没达到返利销售额';
							$Salemonthly->create($data5,1);
							$Salemonthly->add();
						}
					}else
					{
						// var_dump($saletotal.'00000000');
						if ($saletotal>0 && $dl_reward>0){
								//更新累计奖
								$dataupdate=array();
								$dataupdate['sm_mysale'] = $dl_reward;
								$dataupdate['sm_teamsale'] = $fistodsum+$secondodsum;
								$dataupdate['sm_reward'] =$sm_reward;
								$dataupdate['sm_date'] =time();
								$dataupdate['sm_addtime'] = time();
								if (is_not_null($ystar))
									$dataupdate['sm_remark'] ='我的'.date('Y年m月d日 h:i:s',$ystar).'至'.date('Y年m月d日 h:i:s',time()).'销售累计奖:'.$dl_reward;
								else
									$dataupdate['sm_remark'] ='我的'.date('Y年m月d日',time()).'销售累计奖:'.$dl_reward;
								$Salemonthly->where($map7)->data($dataupdate)->save();

								//返利;
								$map2=array();
								$map2['fl_unitcode'] = $this->qy_unitcode;
								$map2['fl_dlid'] = $user_id; //获得返利的代理
								$map2['fl_senddlid'] =0 ; //$sm_senddlid发放返利的代理
								$map2['fl_type'] = 3; //返利分类 1-推荐返利 2-订单返利 3-销售累计奖 4-按月销售奖 5按年度销售奖 11-提现减少返利 (1-10 增加返利 11-20 减少返利) 
								$map2['fl_state'] =0; //待收和已收;
								$rs2=$Fanlidetail->where($map2)->order('fl_addtime DESC')->find();
								if ($rs2)
								{
									//更新返利;
									$dataupdate=array();
									$dataupdate['fl_money'] =$dl_reward;
									$dataupdate['fl_addtime']  = time();
									if (is_not_null($ystar))
										$dataupdate['fl_remark'] ='我的'.date('Y年m月d日 h:i:s',$ystar).'至'.date('Y年m月d日 h:i:s',time()).'销售累计奖:'.$dl_reward;
									else
										$dataupdate['fl_remark'] ='我的'.date('Y年m月d日',time()).'销售累计奖:'.$dl_reward;
									$Fanlidetail->where($map2)->data($dataupdate)->save();
								}else{
									$data5=array();
									$data5['fl_unitcode'] = $this->qy_unitcode;
									$data5['fl_dlid'] = $user_id;//获得返利的代理
									$data5['fl_senddlid'] =0 ; //$sm_senddlid发放返利的代理
									$data5['fl_type'] = 3; //返利分类 1-推荐返利 2-订单返利 3-销售累计奖 4-按月销售奖 5按年度销售奖 11-提现减少返利 (1-10 增加返利 11-20 减少返利)  
									$data5['fl_money'] = $dl_reward;
									$data5['fl_refedlid'] = 0; //推荐返利中被推荐的代理
									$data5['fl_oddlid'] = 0; //订单返利中 下单的代理
									$data5['fl_odid'] = 0;  //订单返利中 订单流水id
									$data5['fl_orderid']  = ''; //订单返利中 订单id
									$data5['fl_proid']  = 0;  //订单返利中 产品id
									$data5['fl_odblid']  = 0;  //订单返利中 订单关系id
									$data5['fl_qty']  = 0;  //订单返利中 产品数量
									$data5['fl_level']  = 0;  //返利的层次，0-自己的返利 1-第一层返利 2-第二层返利 
									$data5['fl_addtime']  =time();
									if (is_not_null($ystar))
										$data5['fl_remark'] ='我的'.date('Y年m月d日 h:i:s',$ystar).'至'.date('Y年m月d日 h:i:s',time()).'销售累计奖:'.$dl_reward;
									else
										$data5['fl_remark'] ='我的'.date('Y年m月d日',time()).'销售累计奖:'.$dl_reward;
									$rs5=$Fanlidetail->create($data5,1);
									if($rs5){
										$rsid=$Fanlidetail->add();
										// if($rsid){
										// 	//按月销售奖记录
										// 	$data5=array();
										// 	$data5['sm_unitcode'] = $this->qy_unitcode;
										// 	$data5['sm_dlid'] = session('jxuser_id');
										// 	$data5['sm_senddlid'] = $sm_senddlid;
										// 	$data5['sm_mysale'] = $odsum;
										// 	$data5['sm_teamsale'] = $fistodsum+$secondodsum;
										// 	$data5['sm_reward'] = $dl_reward0;
										// 	$data5['sm_date'] =$yend;
										// 	$data5['sm_addtime'] = time();
										// 	$data5['sm_flid'] = $rsid;
										// 	$data5['sm_state'] = 1;
										// 	$data5['sm_type'] = 0; //0、总业绩1、一级团队 2、二级团队
										// 	$data5['sm_yjtype'] = 2; //0月 1年 2 总
										// 	$data5['sm_remark'] = '我的'.date('Y年m月d日',time().'销售累计奖返利：'.$dl_reward;
										// 	$Salemonthly->create($data5,1);
										// 	$Salemonthly->add();
										// }
									}
								}
						}else if($saletotal>0 && $dl_reward==0){ //有销售额 无奖金
							//更新累计奖
							$dataupdate=array();
							$dataupdate['sm_mysale'] = $odsum;
							$dataupdate['sm_teamsale'] = $fistodsum+$secondodsum;
							$dataupdate['sm_reward'] =$sm_reward;
							$dataupdate['sm_date'] =time();
							$dataupdate['sm_addtime'] = time();
						    if (is_not_null($ystar))
								$data5['sm_remark'] ='我的'.date('Y年m月d日 h:i:s',$ystar).'至'.date('Y年m月d日 h:i:s',time()).'销售累计业绩返利：0,没达到返利销售额';
							else
								$data5['sm_remark'] ='我的'.date('Y年m月d日',time()).'销售累计业绩返利：0,没达到返利销售额';
							$Salemonthly->where($map7)->data($dataupdate)->save();
						}
					}
					//计算生成总销量业绩及奖金 end
				}

				
				//列表
				$map=array();
				$parameter=array();
				$map['sm_unitcode']=$this->qy_unitcode;
				$map['sm_dlid']=$user_id;
				$map['sm_yjtype']=$yj_type;
				$list=$Salemonthly->where($map)->order('sm_id DESC')->page($pagenum,$pagecount)->select();

				$has_more=false;
				//是否有下页
				$nextls =$Salemonthly->where($map)->order('sm_id DESC')->page($pagenum+1,$pagecount)->select();
			    if (is_not_null($nextls))
				{
					$has_more=true;
				}
				foreach($list as $k=>$v){ 
					$list[$k]['sm_rewardstr']='<span style="color:#009900">'.number_format($v['sm_reward'],2,'.','').'</span>';
				}
			}else{
				if ($dlt_level==1)
				{
					//计算生成业绩及奖金 begin 前3年
					$map2=array();
					$map2['smfr_unitcode']=$this->qy_unitcode;
					$map2['smfr_dltype']=$dlt_type;
					$map2['smfr_countdate']=2; //按月奖励
		            $fanlilist = $Salemonfanlirate->where($map2)->order('smfr_minsale ASC')->select();
					
					$year=date('Y',time()); //当前年月
					$yearlist=array();

					// $yearlist[]=strtotime("$year 0 year");
					$yearlist[]=strtotime("$year -1 year");
					$yearlist[]=strtotime("$year -2 year");
					$yearlist[]=strtotime("$year -3 year");

					foreach($yearlist as $k=>$v){
					    if($v<$year&&$v!==FALSE){
							$map7=array();
							$data7=array();
							$map7['sm_unitcode'] = $this->qy_unitcode;
							$map7['sm_dlid'] =$user_id;
							$map7['sm_date'] =$v;
							$map7['sm_yjtype'] =1;
							$data7 = $Salemonthly->where($map7)->find();
							if(!$data7){
								//自己的业绩
								//下单的金额(只统计已发货、已完成) 
								// $t = strtotime("-1 year"); 
								$t=$v; 
								$nbegintime = mktime(0,0,0,1,1,date('Y',$t));
								$nendtime = mktime(23,59,59,12,31,date('Y',$t)); 
								// var_dump(date('年起点 Y-m-d H:i:s',$nbegintime).$nbegintime);
								// var_dump(date('年终点 Y-m-d H:i:s',$nendtime).$nendtime);
								$Model=M();
								$odsum=0;
								$map2=array();
								$map2['a.od_oddlid']=$user_id;
								$map2['a.od_unitcode']=$this->qy_unitcode;
								$map2['a.od_state']=array('IN','3,8');
								$map2['a.od_virtualstock']=1;
								$map2['a.od_fugou']=1;
								$map2['a.od_expressdate']=array('between',array($nbegintime,$nendtime));
								$map2['a.od_id']=array('exp','=b.oddt_odid');
								$map2['a.od_orderid']=array('exp','=b.oddt_orderid');
								$odsum=$Model->table('fw_orders a,fw_orderdetail b')->where($map2)->sum('od_total'); 
								$odqtysum =$Model->table('fw_orders a,fw_orderdetail b')->where($map2)->sum('oddt_qty'); 
								$odsum = $Orders->where($map2)->sum('od_total'); 
								if($odsum){

								}else{
									$odsum=0;
									$odqtysum=0;
								}

								//奖金计算
								$saletotal=$odsum;
								$saleqtytotal=$odqtysum;
								$dl_reward=0;
								foreach($fanlilist as $kkk=>$vvv){
									if ($vvv['smfr_saleunit']==1)
									{
										if($saletotal>=$vvv['smfr_minsale'] && $saletotal<$vvv['smfr_maxsale']){
											if($vvv['smfr_fanlieval']==1){
												$dl_reward=$vvv['smfr_fanlirate'];
											}else {
												$dl_reward=$odsum*$vvv['smfr_fanlirate'];
											}
										}
									}
									else
									{
										if($saleqtytotal>=$vvv['smfr_minsale'] && $saleqtytotal<$vvv['smfr_maxsale']){
											if($vvv['smfr_fanlieval']==1){
												$dl_reward=$vvv['smfr_fanlirate'];
											}else {
												$dl_reward=$saleqtytotal*$vvv['smfr_fanlirate'];
											}
										}
									}	
								}
								//写入返利
								//发款方
								// if($dl_referee>0){
								// 	$map2=array();
								// 	$map2['dl_unitcode'] = $this->qy_unitcode;
								// 	$map2['dl_id'] = $dl_referee;
								// 	$map2['dl_type'] = $dl_type;
								// 	$data22 = $Dealer->where($map2)->find();
								// 	if($data22){
								// 		$sm_senddlid = $dl_referee;  
								// 	}else{
								// 		$sm_senddlid=0;  
								// 	}
								// }else{
								// 	$sm_senddlid=0;  
								// }
								// //如果有销售有奖金
						        if($odsum>0  && $dl_reward>0){
									$data5=array();
									$data5['fl_unitcode'] = $this->qy_unitcode;
									$data5['fl_dlid'] = $user_id; //获得返利的代理
									$data5['fl_senddlid'] =0 ; //$sm_senddlid发放返利的代理
									$data5['fl_type'] = 5; //返利分类 1-推荐返利 2-订单返利 3-销售累计奖 4-按月销售奖 5按年度销售奖 11-提现减少返利 (1-10 增加返利 11-20 减少返利)  
									$data5['fl_money'] = $dl_reward;
									$data5['fl_refedlid'] = 0; //推荐返利中被推荐的代理
									$data5['fl_oddlid'] = 0; //订单返利中 下单的代理
									$data5['fl_odid'] = 0;  //订单返利中 订单流水id
									$data5['fl_orderid']  = ''; //订单返利中 订单id
									$data5['fl_proid']  = 0;  //订单返利中 产品id
									$data5['fl_odblid']  = 0;  //订单返利中 订单关系id
									$data5['fl_qty']  = 0;  //订单返利中 产品数量
									$data5['fl_level']  = 0;  //返利的层次，0-自己的返利 1-第一层返利 2-第二层返利 
									$data5['fl_addtime']  = time();
									$data5['fl_remark'] ='我的'.date('Y年',$v).'年度销售奖:'.$dl_reward;
									$rs5=$Fanlidetail->create($data5,1);
									if($rs5){
										$rsid=$Fanlidetail->add();
										if($rsid){
											//按月销售奖记录
											$data5=array();
											$data5['sm_unitcode'] = $this->qy_unitcode;
											$data5['sm_dlid'] =$user_id;
											$data5['sm_senddlid'] = $sm_senddlid;
											$data5['sm_mysale'] = $odsum;
											$data5['sm_teamsale'] = $odsum;
											$data5['sm_reward'] = $dl_reward;
											$data5['sm_date'] = $v;
											$data5['sm_addtime'] = time();
											$data5['sm_flid'] = $rsid;
											$data5['sm_state'] = 1;
											$data5['sm_type'] = 0; //0、总业绩1、一级团队 2、二级团队
											$data5['sm_yjtype'] = 1;
											$data5['sm_remark'] = '我的'.date('Y年',$v).'年度销售业绩返利：'.$dl_reward;
											$Salemonthly->create($data5,1);
											$Salemonthly->add();
										}
									}
								}else if($odsum>0 && $dl_reward==0){ //有销售额 无奖金
									//按月销售奖记录
									$data5=array();
									$data5['sm_unitcode'] = $this->qy_unitcode;
									$data5['sm_dlid'] =$user_id;
									$data5['sm_senddlid'] = $sm_senddlid;
									$data5['sm_mysale'] = $odsum;
									$data5['sm_teamsale'] = $odsum;
									$data5['sm_reward'] = 0;
									$data5['sm_date'] = $v;
									$data5['sm_addtime'] = time();
									$data5['sm_flid'] = 0;
									$data5['sm_state'] = 1;
									$data5['sm_type'] = 0;
									$data5['sm_yjtype'] = 1;
									$data5['sm_remark'] = '我的'.date('Y年m月',$v).'年度销售业绩返利：0,没达到返利销售额';
									$Salemonthly->create($data5,1);
									$Salemonthly->add();
								}
							}
						}
					}
					//计算生成业绩及奖金 end


					//列表
					$map=array();
					$parameter=array();
					$map['sm_unitcode']=$this->qy_unitcode;
					$map['sm_dlid']=$user_id;
					$map['sm_yjtype']=$yj_type;
					$list=$Salemonthly->where($map)->order('sm_id DESC')->page($pagenum,$pagecount)->select();

					$has_more=false;
					//是否有下页
					$nextls =$Salemonthly->where($map)->order('sm_id DESC')->page($pagenum+1,$pagecount)->select();
			    	if (is_not_null($nextls))
					{
						$has_more=true;
					}
					foreach($list as $k=>$v){ 
						$list[$k]['sm_rewardstr']='<span style="color:#009900">'.number_format($v['sm_reward'],2,'.','').'</span>';
					}				
				}
				else
				$this->err_get('对不起,没有该权限');
			}
        }
        $ret=array('nsalesum'=>$nsalesum,'nodsum'=>$nodsum,'fistteamsum'=>$fistteamsum,'secondteamsum'=>$secondteamsum,'list'=>$list,'current_page' =>$pagenum,'has_more' =>$has_more);
        return $ret;
    }
    /**
	 * fanli_award_detail_get 返利奖励详情
	 * @return [type] [description]
	 */
    public function fanli_award_detail_get(){
    	isset($this->params["userid"])?$user_id = $this->params["userid"]:$user_id = ''; //用户名
    	isset($this->params["sm_id"])?$sm_id = $this->params["sm_id"]:$sm_id=0; //
		if(!$this->is_jxuser_login($user_id)){
			$this->err_get(5);
        }else
        {
        	if($sm_id>0){
				$Salemonthly= M('Salemonthly');
			    $Dealer= M('Dealer');
				$map=array();
				$map['sm_unitcode']=$this->qy_unitcode;
				$map['sm_id']=$sm_id;  
				$map['sm_dlid']=$user_id;  
				$data = $Salemonthly->where($map)->find();
				if($data){
					//收款代理信息
					if($data['sm_dlid']>0){
						$map2=array();
						$map2['dl_id']=$data['sm_dlid'];
						$map2['dl_unitcode']=$this->qy_unitcode;
						$data2=$Dealer->where($map2)->find();
						if($data2){
							$data['dl_name_str']=$data2['dl_name'].'('.$data2['dl_username'].')';
						}else{
							$data['dl_name_str']='未知';
						}
					}else{
						$data['dl_name_str']='未知';
					}
					
					//付款代理信息
					if($data['sm_senddlid']>0){
						$map2=array();
						$map2['dl_id']=$data['sm_senddlid'];
						$map2['dl_unitcode']=$this->qy_unitcode;
						$data2=$Dealer->where($map2)->find();
						if($data2){
							$data['dl_sendname_str']=$data2['dl_name'].'('.$data2['dl_username'].')';
						}else{
							$data['dl_sendname_str']='未知';
						}
					}else{
						$data['dl_sendname_str']='总公司';
					}
					return $data;
				}else
				{
					$this->err_get(4);
				}
			}else{
				$this->err_get(30);
			}
        }
    }

    /**
	 * fanli_list_get 提现 列表
	 * @return [type] [description]
	 */
    public function fanli_recashlist_get(){
    	isset($this->params["userid"])?$user_id = $this->params["userid"]:$user_id = ''; //用户名
 		isset($this->params["pagenum"]) ? $pagenum = $this->params["pagenum"] : $pagenum =1;
	    isset($this->params["pagecount"]) ? $pagecount = $this->params["pagecount"] : $pagecount =20;
		if(!$this->is_jxuser_login($user_id)){
			$this->err_get(5);
        }else
        {
			//--------------------------------
			$Recash= M('Recash');
	        $map=array();
			$parameter=array();
	        $map['rc_unitcode']=$this->qy_unitcode;
			$map['rc_dlid']=$user_id;
	        $list=$Recash->where($map)->order('rc_id DESC')->page($pagenum,$pagecount)->select();
			foreach($list as $k=>$v){
				if(isset(C('FANLI_BANKS')[$v['rc_bank']])){
					$list[$k]['rc_str']='申请提现到 '.C('FANLI_BANKS')[$v['rc_bank']];
				}else{
					$list[$k]['rc_str']='申请提现';
				}

				if(MD5($v['rc_unitcode'].$v['rc_dlid'].number_format($v['rc_money'],2,'.','').$v['rc_bankcard'].$v['rc_addtime'])==$v['rc_verify']){
					if($v['rc_state']==0){
						$list[$k]['rc_statestr']='处理中';
					}else if($v['rc_state']==1){
						$list[$k]['rc_statestr']='提现成功';
					}else if($v['rc_state']==2){
						$list[$k]['rc_statestr']='提现失败';
					}else{
						$list[$k]['rc_statestr']='异常';
					}
	            }else{
					if($v['rc_state']==0){
						$list[$k]['rc_statestr']='处理中[异常]';
					}else if($v['rc_state']==1){
						$list[$k]['rc_statestr']='提现成功[异常]';
					}else if($v['rc_state']==2){
						$list[$k]['rc_statestr']='提现失败[异常]';
					}else{
						$list[$k]['rc_statestr']='异常';
					}
				}
				
	            //付款方
			    if($v['rc_sdlid']==0){
					$list[$k]['fl_sdl_name']='总公司';
					$list[$k]['fl_sdl_username']='';
				}else{
					$map3=array();
					$data3=array();
					$map3['dl_id']=$v['rc_sdlid'];
					$map3['dl_unitcode']=$this->qy_unitcode;
					$data3=$Dealer->where($map3)->find();
					if($data3){
						$list[$k]['fl_sdl_name']=$data3['dl_name'];
						$list[$k]['fl_sdl_username']=$data3['dl_username'];
					}else{
						$list[$k]['fl_sdl_name']='';
						$list[$k]['fl_sdl_username']='';
					}
				}
			}

			$has_more=false;
			//是否有下页
			$nextls =$Recash->where($map)->order('rc_id DESC')->page($pagenum+1,$pagecount)->select(); 
		    if (is_not_null($nextls))
			{
				$has_more=true;
			}
		    $ret=array('current_page' =>$pagenum,'has_more' =>$has_more,'data'=>$list);
		    return $ret;
		}
    }

   /**
	 * fanli_list_get 返利提现详细
	 * @return [type] [description]
	 */
    public function fanli_recashdetail_get(){
		isset($this->params["userid"])?$user_id = $this->params["userid"]:$user_id = ''; //用户名
    	isset($this->params["rc_id"])?$rc_id = $this->params["rc_id"]:$rc_id = ''; //用户名
		if(!$this->is_jxuser_login($user_id)){
			$this->err_get(5);
        }

        $Recash= M('Recash');
        $map=array();
		$map['rc_id']=$rc_id;
		$map['rc_unitcode']=$this->qy_unitcode;
		$map['rc_dlid']=$user_id;
		$data=$Recash->where($map)->find();
		if ($data){
			$data['rc_moneystr']=number_format($data['rc_money'],2,'.','');
			
			if(isset(C('FANLI_BANKS')[$data['rc_bank']])){
				$data['rc_bankstr']=C('FANLI_BANKS')[$data['rc_bank']];
			}else{
				$data['rc_bankstr']='';
			}

			$data['rc_bankcardstr']=\Org\Util\Funcrypt::authcode($data['rc_bankcard'],'DECODE',C('WWW_AUTHKEY'),0);
			
            if(MD5($data['rc_unitcode'].$data['rc_dlid'].number_format($data['rc_money'],2,'.','').$data['rc_bankcard'].$data['rc_addtime'])==$data['rc_verify']){
				if($data['rc_state']==0){
					$data['rc_statestr']='处理中';
				}else if($data['rc_state']==1){
					$data['rc_statestr']='提现成功';
				}else if($data['rc_state']==2){
					$data['rc_statestr']='提现失败';
				}else{
					$data['rc_statestr']='异常';
				}
            }else{
				if($data['rc_state']==0){
					$data['rc_statestr']='处理中[异常]';
				}else if($data['rc_state']==1){
					$data['rc_statestr']='提现成功[异常]';
				}else if($data['rc_state']==2){
					$data['rc_statestr']='提现失败[异常]';
				}else{
					$data['rc_statestr']='异常';
				}
			}
			
			//付款代理
			if($data['rc_sdlid']==0){
				$data['fl_sdl_name']='总公司';
				$data['fl_sdl_username']='';
			}else{
				$map3=array();
				$data3=array();
				$map3['dl_id']=$data['rc_sdlid'];
				$map3['dl_unitcode']=$this->qy_unitcode;

				$data3=$Dealer->where($map3)->find();
				if($data3){
					$data['fl_sdl_name']=$data3['dl_name'];
					$data['fl_sdl_username']=$data3['dl_username'];
				}else{
					$data['fl_sdl_name']='';
					$data['fl_sdl_username']='';
				}
			}
			
			$imgpath = BASE_PATH.'/Public/uploads/orders/';
			//图片
            if(is_not_null($data['rc_pic']) && file_exists($imgpath.$data['rc_pic'])){
                $data['rc_pic_str']=$this->ODPath.$data['rc_pic'];
            }else{
                $data['rc_pic_str']='';
            }
            return $data;
		}else{
			$this->err_get(4);
		}
    }
}