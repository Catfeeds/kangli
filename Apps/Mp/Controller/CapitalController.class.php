<?php
namespace Mp\Controller;
use Think\Controller;
use Think\Db;

//资金管理
class CapitalController extends CommController {
	//资金管理
    public function index(){
        $this->check_qypurview('18001',1);
		
        $keyword=trim(strip_tags(htmlspecialchars_decode(I('param.keyword',''))));
		$dl_type=intval(I('param.dl_type',0));

		$parameter=array();
		
		if($dl_type>0){
			$map['dl_type']=$dl_type;
			$parameter['dl_type']=$dl_type;
		}
		
	
		
        if($keyword!=''){
            $keyword=str_replace('[','',$keyword);
            $keyword=str_replace(']','',$keyword);
            $keyword=str_replace('%','',$keyword);
            $keyword=str_replace('_','',$keyword);
            $keyword=sub_str($keyword,20,false);
            $where['dl_name']=array('LIKE', '%'.$keyword.'%');
            $where['dl_number']=array('LIKE', '%'.$keyword.'%');
            $where['dl_tel']=array('LIKE', '%'.$keyword.'%');
            $where['dl_weixin']=array('LIKE', '%'.$keyword.'%');
			$where['dl_contact']=array('LIKE', '%'.$keyword.'%');
            $where['_logic'] = 'or';
            $map['_complex'] = $where;
			
			$parameter['keyword']=$keyword;
        }

        $map['dl_unitcode']=session('unitcode');
        $Dealer = M('Dealer');
		$Dltype = M('Dltype');
		$Yufukuan= M('Yufukuan');
		$Balance= M('Balance');
		
        $count = $Dealer->where($map)->count();
        $Page = new \Think\Page($count, C('PAGE_SIZE'),$parameter);
        $show = $Page->show();
        $list = $Dealer->where($map)->order('dl_type ASC,dl_id DESC')->limit(($Page->firstRow . ',') . $Page->listRows)->select();
		
		foreach($list as $k=>$v){
			
			//经销商级别
			$map2=array();
			$map2['dlt_id']=$v['dl_type'];
			$map2['dlt_unitcode']=session('unitcode');
			$data2 = $Dltype->where($map2)->find();
			if($data2){
				$list[$k]['dl_type_str']=$data2['dlt_name'];
			}else{
				$list[$k]['dl_type_str']='-';
			}
			
			//上家代理
			if($v['dl_belong']>0){
				$map2=array();
				$map2['dl_id']=$v['dl_belong'];
				$map2['dl_unitcode']=session('unitcode');
				$data2=$Dealer->where($map2)->find();
				if($data2){
					$list[$k]['dl_belong_str']=$data2['dl_name'].'('.$data2['dl_username'].')';
				}else{
					$list[$k]['dl_belong_str']='-';
				}
			}else{
				$list[$k]['dl_belong_str']='直属公司';
			}
			
			//推荐人
			if($v['dl_referee']>0){
				$map2=array();
				$map2['dl_id']=$v['dl_referee'];
				$map2['dl_unitcode']=session('unitcode');
				$data2=$Dealer->where($map2)->find();
				if($data2){
					$list[$k]['dl_referee_str']=$data2['dl_name'].'('.$data2['dl_username'].')';
				}else{
					$list[$k]['dl_referee_str']='-';
				}
			}else{
				$list[$k]['dl_referee_str']='直属公司';
			}
			
		
			//预付款 增加(有效的)--->公司手动增加的
			$yfkaddsum=0;
			$map2=array();
			$map2['yfk_receiveid']=$v['dl_id'];   //收款代理
			$map2['yfk_unitcode']=session('unitcode');
			$map2['yfk_type']=array('IN','1,2,3');  //预付款分类 1-公司手动增减 2-订单返利增减  3-推荐返利增减 (对于收方则是增，对于发方则是减) 
			$map2['yfk_state']=1;  //状态 1-有效 0-无效 2-冻结
			$yfkaddsum = $Yufukuan->where($map2)->sum('yfk_money'); 
            if($yfkaddsum){
				$list[$k]['yfkaddsum']=$yfkaddsum;
			}else{
				$list[$k]['yfkaddsum']=0;
			}
			
			//预付款 增加(冻结)
			$yfkfreezesum=0;
			$map2=array();
			$map2['yfk_receiveid']=$v['dl_id'];   //收款代理
			$map2['yfk_unitcode']=session('unitcode');
			$map2['yfk_type']=array('IN','1,2,3');  //预付款分类 1-公司手动增减 2-订单返利增减  3-推荐返利增减 (对于收方则是增，对于发方则是减) 
			$map2['yfk_state']=2;  //状态 1-有效 0-无效 2-冻结
			$yfkfreezesum = $Yufukuan->where($map2)->sum('yfk_money'); 
            if($yfkfreezesum){
				$list[$k]['yfkfreezesum']=$yfkfreezesum;
			}else{
				$list[$k]['yfkfreezesum']=0;
			}
			
			//预付款 减少(冻结)
			$yfkfreezeminussum=0;
			$map2=array();
			$map2['yfk_sendid']=$v['dl_id'];   //收款代理
			$map2['yfk_unitcode']=session('unitcode');
			$map2['yfk_type']=array('IN','1,2,3');  //预付款分类 1-公司手动增减 2-订单返利增减  3-推荐返利增减 (对于收方则是增，对于发方则是减) 
			$map2['yfk_state']=2;  //状态 1-有效 0-无效 2-冻结
			$yfkfreezeminussum = $Yufukuan->where($map2)->sum('yfk_money'); 
            if($yfkfreezeminussum){
				$list[$k]['yfkfreezeminussum']=$yfkfreezeminussum;
			}else{
				$list[$k]['yfkfreezeminussum']=0;
			}
			
			
			//预付款 减少(有效的)--->公司手动减少的
			$yfkminussum=0;
			$map2=array();
			$map2['yfk_sendid']=$v['dl_id'];   //付款代理
			$map2['yfk_unitcode']=session('unitcode');
			$map2['yfk_type']=array('IN','1,2,3');  //预付款分类 1-公司手动增减 2-订单返利增减 3-推荐返利增减  (对于收方则是增，对于发方则是减) 
			$map2['yfk_state']=1;  //状态 1-有效 0-无效 2-冻结
			$yfkminussum = $Yufukuan->where($map2)->sum('yfk_money'); 
            if($yfkminussum){
				$list[$k]['yfkminussum']=$yfkminussum;
			}else{
				$list[$k]['yfkminussum']=0;
			}
			//预付款TO余额 减少(冻结)
			$yfk2yuefreezesum=0;
			$map2=array();
			$map2['bl_sendid']=$v['dl_id'];
			$map2['bl_unitcode']=session('unitcode');
			$map2['bl_type']=array('IN','1,2,3');  
			$map2['bl_state']=2;  //状态 1-有效 0-无效 2-冻结
			$map2['bl_isyfk']=1;  //是否预付款支付
			$yfk2yuefreezesum = $Balance->where($map2)->sum('bl_money'); 
			if($yfk2yuefreezesum){
				$list[$k]['yfk2yuefreezesum']=$yfk2yuefreezesum;
			}else{
				$list[$k]['yfk2yuefreezesum']=0;
			}
			
			//预付款TO余额 减少(有效的)
			$yfk2yueminussum=0;
			$map2=array();
			$map2['bl_sendid']=$v['dl_id'];
			$map2['bl_unitcode']=session('unitcode');
			$map2['bl_type']=array('IN','1,2,3');  
			$map2['bl_state']=1;  //状态 1-有效 0-无效 2-冻结
			$map2['bl_isyfk']=1;  //是否预付款支付
			$yfk2yueminussum = $Balance->where($map2)->sum('bl_money'); 
			if($yfk2yueminussum){
				$list[$k]['yfk2yueminussum']=$yfk2yueminussum;
			}else{
				$list[$k]['yfk2yueminussum']=0;
			}


//            余额=预付款 增加(有效的)--->公司手动增加的-//预付款 减少(有效的)--->公司手动减少的-//预付款 减少(冻结)-//预付款TO余额 减少(冻结)-//预付款TO余额 减少(有效的)
			$list[$k]['yfksurplus']=$list[$k]['yfkaddsum']-$list[$k]['yfkminussum']-$list[$k]['yfkfreezeminussum']-$list[$k]['yfk2yuefreezesum']-$list[$k]['yfk2yueminussum']; //剩余预付款
			
			
            //余额 增加(有效的)
			$yueaddsum=0;
			$map2=array();
			$map2['bl_receiveid']=$v['dl_id'];
			$map2['bl_unitcode']=session('unitcode');
			$map2['bl_type']=array('IN','1,2,3');  //余额分类 1-公司手动增减 2-订单增减  3-提现增减 (对于收方则是增，对于发方则是减) 
			$map2['bl_state']=1;  //状态 1-有效 0-无效 2-冻结
			$yueaddsum = $Balance->where($map2)->sum('bl_money'); 
			if($yueaddsum){
				$list[$k]['yueaddsum']=$yueaddsum;
			}else{
				$list[$k]['yueaddsum']=0;
			}
			
			//余额 增加(冻结)
			$yuefreezesum=0;
			$map2=array();
			$map2['bl_receiveid']=$v['dl_id'];
			$map2['bl_unitcode']=session('unitcode');
			$map2['bl_type']=array('IN','1,2,3');  //余额分类 1-公司手动增减 2-订单增减  3-提现增减 (对于收方则是增，对于发方则是减) 
			$map2['bl_state']=2;  //状态 1-有效 0-无效 2-冻结
			$yuefreezesum = $Balance->where($map2)->sum('bl_money'); 
			if($yuefreezesum){
				$list[$k]['yuefreezesum']=$yuefreezesum;
			}else{
				$list[$k]['yuefreezesum']=0;
			}
			
			//余额 减少(冻结)
			$yuefreezeminussum=0;
			$map2=array();
			$map2['bl_sendid']=$v['dl_id'];
			$map2['bl_unitcode']=session('unitcode');
			$map2['bl_type']=array('IN','1,2,3');  //余额分类 1-公司手动增减 2-订单增减  3-提现增减 (对于收方则是增，对于发方则是减) 
			$map2['bl_state']=2;  //状态 1-有效 0-无效 2-冻结
			$map2['bl_isyfk']=0;  //是否预付款支付
			$yuefreezeminussum = $Balance->where($map2)->sum('bl_money'); 
			if($yuefreezeminussum){
				$list[$k]['yuefreezeminussum']=$yuefreezeminussum;
			}else{
				$list[$k]['yuefreezeminussum']=0;
			}
			
			//余额 减少(有效的)
			$yueminussum=0;
			$map2=array();
			$map2['bl_sendid']=$v['dl_id'];
			$map2['bl_unitcode']=session('unitcode');
			$map2['bl_type']=array('IN','1,2,3');  //余额分类 1-公司手动增减 2-订单增减  3-提现增减 (对于收方则是增，对于发方则是减) 
			$map2['bl_state']=1;  //状态 1-有效 0-无效 2-冻结
			$map2['bl_isyfk']=0;  //是否预付款支付
			$yueminussum = $Balance->where($map2)->sum('bl_money'); 
			if($yueminussum){
				$list[$k]['yueminussum']=$yueminussum;
			}else{
				$list[$k]['yueminussum']=0;
			}
			$list[$k]['yuesurplus']=$list[$k]['yueaddsum']-$list[$k]['yueminussum']-$list[$k]['yuefreezeminussum']; //剩余余额
			
		}

		
		
        //分类列表
		$map2=array();
        $map2['dlt_unitcode']=session('unitcode');
        $list2 = $Dltype->where($map2)->order('dlt_level ASC,dlt_id ASC')->select();
        $this->assign('dltypelist', $list2);
		
		$this->assign('dl_type', $dl_type);
        $this->assign('dl_status', $dl_status);
	
        $this->assign('list', $list);
        $this->assign('page', $show);
		$this->assign('pagecount', $count);
        $this->assign('curr', 'capital');
        $this->display('list');
    }
	
	//预付款明细
    public function yufukuan(){
        $this->check_qypurview('18002',1);
		
		$dlusername=trim(I('param.dlusername',''));
		$begintime=I('param.begintime','');
        $endtime=I('param.endtime','');
		$parameter=array();
		$dl_id=0;
		
        $Dealer = M('Dealer');
		$Yufukuan= M('Yufukuan');
		$back=0;
		if($dlusername!='' && $dlusername!='请输入代理账号'){
            if(!preg_match("/[a-zA-Z0-9_-]{4,20}$/",$dlusername)){
                $this->error('代理账号不正确','',1);
            }
			
			$map2=array();
            $map2['dl_username']=$dlusername;
            $map2['dl_unitcode']=session('unitcode');
            $data22=$Dealer->where($map2)->find();
            if($data22){

			}else{
				$this->error('代理账号不正确','',1);
			}
			
			$where=array();
			$where['yfk_sendid']=$data22['dl_id'];
			$where['yfk_receiveid']=$data22['dl_id'];
			$where['_logic'] = 'or';
			$map['_complex'] = $where;
			$dl_id=$data22['dl_id'];
			
			$parameter['dlusername']=$dlusername;
			$this->assign('dlusername', $dlusername);
        }else{
			$this->assign('dlusername', '请输入代理账号');
		}
		$this->assign('back', $back);
		
		
		if($begintime!='' && $endtime!=''){
            $begintime=strtotime($begintime);
			$endtime=strtotime($endtime);
			if($begintime===FALSE || $endtime===FALSE){
				$this->error('请选择查询日期','',1);
			}
			$endtime=$endtime+3600*24-1;
			if($begintime>=$endtime){
				$this->error('查询结束日期要大于开始日期','',1);
			}	
			
			$map['yfk_addtime']=array('between',array($begintime,$endtime));
			
			$parameter['begintime']=urlencode(date('Y-m-d',$begintime));
			$parameter['endtime']=urlencode(date('Y-m-d',$endtime));
			
			$this->assign('begintime', date('Y-m-d',$begintime));
			$this->assign('endtime', date('Y-m-d',$endtime));
		}else{
            $begintime='';
            $endtime='';
		    $this->assign('begintime', '');
		    $this->assign('endtime', '');
		}
        $map['yfk_unitcode']=session('unitcode');


        $count = $Yufukuan->where($map)->count();
        $Page = new \Think\Page($count, C('PAGE_SIZE'),$parameter);
        $show = $Page->show();
        $list = $Yufukuan->where($map)->order('yfk_id DESC')->limit(($Page->firstRow . ',') . $Page->listRows)->select();
		
		foreach($list as $k=>$v){
			//收款代理信息
			if($v['yfk_receiveid']>0){
				$map2=array();
				$map2['dl_id']=$v['yfk_receiveid'];
				$map2['dl_unitcode']=session('unitcode');
				$data2=$Dealer->where($map2)->find();
				if($data2){
					$list[$k]['dl_name_str']=$data2['dl_name'].'('.$data2['dl_username'].')';
					$list[$k]['dl_number']=$data2['dl_number'];
				}else{
					$list[$k]['dl_name_str']='未知';
					$list[$k]['dl_number']='-';
				}
			}else{
				$list[$k]['dl_name_str']='-';
				$list[$k]['dl_number']='-';
			}
			
			//付款代理信息
			if($v['yfk_sendid']>0){
				$map2=array();
				$map2['dl_id']=$v['yfk_sendid'];
				$map2['dl_unitcode']=session('unitcode');
				$data2=$Dealer->where($map2)->find();
				if($data2){
					$list[$k]['dl_sendname_str']=$data2['dl_name'].'('.$data2['dl_username'].')';
				}else{
					$list[$k]['dl_sendname_str']='未知';
				}
			}else{
				$list[$k]['dl_sendname_str']='-';
			}
			
			
		    if($dl_id>0){
				if($v['yfk_sendid']==$dl_id){
					$list[$k]['yfk_moneystr']='<span style="color:#009900">-'.number_format($v['yfk_money'], 2,'.','').'</span>';
				}
				
				if($v['yfk_receiveid']==$dl_id){
				    $list[$k]['yfk_moneystr']='<span style="color:#000000">+'.number_format($v['yfk_money'], 2,'.','').'</span>';
				}
				
			}else{
				$list[$k]['yfk_moneystr']=number_format($v['yfk_money'], 2,'.','');
			}
			
			
		    //预付款分类 1-公司手动增减 2-订单返利增减  3-推荐返利增减 (对于收方则是增，对于发方则是减) 
			if($v['yfk_type']==1){
				if($v['yfk_sendid']>0){
				    $list[$k]['yfk_typestr']='公司手动减少';
				}
				if($v['yfk_receiveid']>0){
				    $list[$k]['yfk_typestr']='公司手动增加';
				}
			}else if($v['yfk_type']==2){
				$list[$k]['yfk_typestr']='订单返利增减';
			}else if($v['yfk_type']==3){
				$list[$k]['yfk_typestr']='推荐返利增减';
			}else{
				$list[$k]['yfk_typestr']='未知';
			}
			if($v['yfk_state']==0){
				$list[$k]['yfk_state_str']='无效';
			}else if($v['yfk_state']==1){
				$list[$k]['yfk_state_str']='有效';
			}else if($v['yfk_state']==2){
				$list[$k]['yfk_state_str']='冻结';
			}else{
				$list[$k]['yfk_state_str']='未知';
			}
		}
	
        $this->assign('list', $list);
        $this->assign('page', $show);
		$this->assign('pagecount', $count);
        $this->assign('curr', 'yufukuan');
        $this->display('yufukuan');
    }
	
	//预付款明细详细
    public function yfkdetail(){
        $this->check_qypurview('18002',1);
		
        $yfk_id=intval(I('get.yfk_id',0));
		$map=array();
		$map['yfk_id']=$yfk_id;
		$map['yfk_unitcode']=session('unitcode');
		$Yufukuan= M('Yufukuan');
		$Dealer= M('Dealer');
		$data=$Yufukuan->where($map)->find();
		if($data){
		    //预付款分类 1-公司手动增减 2-订单返利增减  3-推荐返利增减 (对于收方则是增，对于发方则是减) 
			if($data['yfk_type']==1){
				if($data['yfk_sendid']>0){
				    $data['yfk_typestr']='公司手动减少';
				}
				if($data['yfk_receiveid']>0){
				    $data['yfk_typestr']='公司手动增加';
				}
			}else if($data['yfk_type']==2){
				$data['yfk_typestr']='订单返利增减';
			}else if($data['yfk_type']==3){
				$data['yfk_typestr']='推荐返利增减';
			}else{
				$data['yfk_typestr']='未知';
			}
			
			$data['yfk_moneystr']=number_format($data['yfk_money'], 2,'.','');
			
			//收款代理信息
			if($data['yfk_receiveid']>0){
				$map2=array();
				
				$map2['dl_id']=$data['yfk_receiveid'];
				$map2['dl_unitcode']=session('unitcode');
				$data2=$Dealer->where($map2)->find();
				if($data2){
					$data['dl_name_str']=$data2['dl_name'].'('.$data2['dl_username'].')';
				}else{
					$data['dl_name_str']='未知';
				}
			}else{
				$data['dl_name_str']='-';
			}
			
            //付款代理信息
			if($data['yfk_sendid']>0){
				$map2=array();
				$map2['dl_id']=$data['yfk_sendid'];
				$map2['dl_unitcode']=session('unitcode');
				$data2=$Dealer->where($map2)->find();
				if($data2){
					$data['dl_sendname_str']=$data2['dl_name'].'('.$data2['dl_username'].')';
				}else{
					$data['dl_sendname_str']='未知';
				}
			}else{
				$data['dl_sendname_str']='-';
			}
			
            if($data['yfk_state']==0){
				$data['yfk_state_str']='无效';
            }else if($data['yfk_state']==1){
				$data['yfk_state_str']='有效';
			}else if($data['yfk_state']==2){
				$data['yfk_state_str']='冻结';
			}else{
				$data['yfk_state_str']='未知';
			}
			
		}else{
			$this->error('没有该记录','',2);
		}

        $this->assign('yfkinfo', $data);
		
        $this->assign('curr', 'yufukuan');
        $this->display('yfkdetail');
	}
	
	//增减预付
    public function yufukuanadd(){
        $this->check_qypurview('18003',1);
		
        $dl_id=intval(I('get.dl_id',0));
		$Dealer= M('Dealer');
		$map=array();
		$map['dl_id']=$dl_id;
		$map['dl_unitcode']=session('unitcode');

		$data=$Dealer->where($map)->find();
		if($data){
			if($data['dl_status']==1){
				$data['dl_name_str']=$data['dl_name'].'('.$data['dl_username'].')';
			}else{
				$this->error('该代理还没审核或已禁用','',2);
			}
		}else{
			$this->error('该代理不存在','',2);
		}

        $this->assign('dealerinfo', $data);
		
		
        $this->assign('curr', 'capital');
        $this->display('yufukuanadd');
	}
	
    //增减预付保存
    public function yufukuanadd_save(){
        $this->check_qypurview('18003',1);

		$dl_id=intval(I('post.dl_id',0));

		if($dl_id>0){
			$Dealer= M('Dealer');
			$Yufukuan= M('Yufukuan');
			$Balance= M('Balance');
			$map=array();
			$map['dl_id']=$dl_id;
			$map['dl_unitcode']=session('unitcode');
			$map['dl_status']=1;
			$data=$Dealer->where($map)->find();
			if($data){
			}else{
				$this->error('没有该记录','',2);
			}
			
			$yfk_add=intval(I('post.yfk_add',0));
			$yfk_money=trim(I('post.yfk_money',''));
			$yfk_remark=trim(I('post.yfk_remark',''));
			$pwd=trim(I('post.pwd',''));
			
            if($yfk_add<=0){
				$this->error('请选择增减','',2);
			}
			
			if($yfk_money==''){
				$this->error('请填写金额','',2);
			}
			
			if(!preg_match("/^[0-9.]{1,8}$/",$yfk_money)){
				$this->error('填写金额必须为数字');
			}
			
			if($yfk_money<=0){
				$this->error('填写金额必须大于0');
			}
				
			if($yfk_remark==''){
				$this->error('请填写备注','',2);
			}
			
			if($pwd==''){
				$this->error('密码不能为空','',2);
			}
			
			
			//密码是否正确
			$Qyinfo= M('Qyinfo');
			$md5_qy_pwd=MD5(MD5(MD5($pwd)));
			//是否子用户登录
			$qy_username=session('qyuser');
			if(strpos($qy_username,':')===false){
				$qy_username2=$qy_username;
				$qy_subusername2='';
			}else{
				$qy_username_arr=explode(":", $qy_username);
				reset($qy_username_arr);
				$qy_username2 = current($qy_username_arr);
				$qy_subusername2= end($qy_username_arr);
			}
			if($qy_subusername2==''){
				$map2=array();
				$map2['qy_username']=$qy_username2;
				$map2['qy_code']=session('unitcode');
				$data2=$Qyinfo->where($map2)->find();
				if($data2){
					if($data2['qy_pwd']==$md5_qy_pwd){
						
					}else{
						$this->error('密码不正确','',2);
					}
				}else{
					$this->error('密码不正确','',2);
				}
			}else{
				$Qysubuser= M('Qysubuser');
				$map2=array();
				$map2['su_username']=$qy_subusername2;
				$map2['su_unitcode']=session('unitcode');
				
				$data2=$Qysubuser->where($map2)->find();
                if($data2){
					if($data2['su_pwd']==$md5_qy_pwd){
						
					}else{
						$this->error('密码不正确','',2);
					}
				}else{
					$this->error('密码不正确','',2);
				}
			}
            ////密码是否正确 end 
			
			
			
			$data=array();
			$data['yfk_unitcode']=session('unitcode');
			$data['yfk_type']=1;  //预付款分类 1-公司手动增减 2-订单返利增减 3-推荐返利增减  (对于收方则是增，对于发方则是减) 
			
			if($yfk_add==1){  //增加
				$data['yfk_sendid']=0;   //发款id
				$data['yfk_receiveid']=$dl_id;  //收款id
				$dlg_action='手动增加预付款：'.$yfk_money;
			}else if($yfk_add==2){ //减少
				$data['yfk_sendid']=$dl_id;   //发款id
				$data['yfk_receiveid']=0;  //收款id
				$dlg_action='手动减少预付款：'.$yfk_money;
				
				//检测剩余的预付款是否够减少
				
	            //预付款 增加(有效的)
				$yfkaddsum=0;
				$map2=array();
				$map2['yfk_receiveid']=$dl_id;   //收款代理
				$map2['yfk_unitcode']=session('unitcode');
				$map2['yfk_type']=array('IN','1,2,3');  //预付款分类 1-公司手动增减 2-订单返利增减  3-推荐返利增减 (对于收方则是增，对于发方则是减) 
				$map2['yfk_state']=1;  //状态 1-有效 0-无效 2-冻结
				$yfkaddsum = $Yufukuan->where($map2)->sum('yfk_money'); 
				if($yfkaddsum){
				}else{
					$yfkaddsum=0;
				}
				
				
				//预付款 减少(冻结)
				$yfkfreezeminussum=0;
				$map2=array();
				$map2['yfk_sendid']=$dl_id;   //收款代理
				$map2['yfk_unitcode']=session('unitcode');
				$map2['yfk_type']=array('IN','1,2,3');  //预付款分类 1-公司手动增减 2-订单返利增减  3-推荐返利增减 (对于收方则是增，对于发方则是减) 
				$map2['yfk_state']=2;  //状态 1-有效 0-无效 2-冻结
				$yfkfreezeminussum = $Yufukuan->where($map2)->sum('yfk_money'); 
				if($yfkfreezeminussum){
				}else{
					$yfkfreezeminussum=0;
				}
				
				
				//预付款 减少(有效的)
				$yfkminussum=0;
				$map2=array();
				$map2['yfk_sendid']=$dl_id;   //付款款代理
				$map2['yfk_unitcode']=session('unitcode');
				$map2['yfk_type']=array('IN','1,2,3');  //预付款分类 1-公司手动增减 2-订单返利增减 3-推荐返利增减  (对于收方则是增，对于发方则是减) 
				$map2['yfk_state']=1;  //状态 1-有效 0-无效 2-冻结
				$yfkminussum = $Yufukuan->where($map2)->sum('yfk_money'); 
				if($yfkminussum){
				}else{
					$yfkminussum=0;
				}
				
				//预付款TO余额 减少(冻结)
				$yfk2yuefreezesum=0;
				$map2=array();
				$map2['bl_sendid']=$dl_id;
				$map2['bl_unitcode']=session('unitcode');
				$map2['bl_type']=array('IN','1,2,3');  
				$map2['bl_state']=2;  //状态 1-有效 0-无效 2-冻结
				$map2['bl_isyfk']=1;  //是否预付款支付
				$yfk2yuefreezesum = $Balance->where($map2)->sum('bl_money'); 
				if($yfk2yuefreezesum){
				}else{
					$yfk2yuefreezesum=0;
				}
				
				//预付款TO余额 减少(有效的)
				$yfk2yueminussum=0;
				$map2=array();
				$map2['bl_sendid']=$dl_id;
				$map2['bl_unitcode']=session('unitcode');
				$map2['bl_type']=array('IN','1,2,3');  
				$map2['bl_state']=1;  //状态 1-有效 0-无效 2-冻结
				$map2['bl_isyfk']=1;  //是否预付款支付
				$yfk2yueminussum = $Balance->where($map2)->sum('bl_money'); 
				if($yfk2yueminussum){
				}else{
					$yfk2yueminussum=0;
				}
				

				$yfksurplus=$yfkaddsum-$yfkminussum-$yfkfreezeminussum-$yfk2yuefreezesum-$yfk2yueminussum; //剩余预付款
				

				if($yfksurplus<$yfk_money){
					$this->error('减少的金额大于预付款的余额','',3);
				}
			}else{
				$this->error('请选择增减','',2);
			}

			
			$data['yfk_money']=$yfk_money;
			$data['yfk_refedlid']=0;
			$data['yfk_oddlid']=0;
			$data['yfk_odid']=0;
			$data['yfk_orderid']='';
			$data['yfk_odblid']=0;
			$data['yfk_qty']=0;
			$data['yfk_level']=0;
			$data['yfk_addtime']=time();
			$data['yfk_remark']=$yfk_remark;
			$data['yfk_state']=1;
			
			$rs=$Yufukuan->create($data,1);
			if($rs){
				$result = $Yufukuan->add(); 
				if($result){
					
                    //代理操作日志 begin
					$odlog_arr=array(
								'dlg_unitcode'=>session('unitcode'),  
								'dlg_dlid'=>$dl_id,
								'dlg_operatid'=>session('qyid'),
								'dlg_dlusername'=>session('qyuser'),
								'dlg_dlname'=>session('qyuser'),
								'dlg_action'=>$dlg_action,
								'dlg_type'=>0, //0-企业 1-经销商
								'dlg_addtime'=>time(),
								'dlg_ip'=>real_ip(),
								'dlg_link'=>__SELF__
								);
					$Dealerlogs= M('Dealerlogs');
					$rs3=$Dealerlogs->create($odlog_arr,1);
					if($rs3){
						$Dealerlogs->add();
					}
					//代理操作日志 end
					
                    //记录日志 begin
                    $log_arr=array(
                                'log_qyid'=>session('qyid'),
                                'log_user'=>session('qyuser'),
                                'log_qycode'=>session('unitcode'),
                                'log_action'=>$dlg_action,
								'log_type'=>1, //0-系统 1-企业 2-经销商 3-消费者
                                'log_addtime'=>time(),
                                'log_ip'=>real_ip(),
                                'log_link'=>__SELF__,
                                'log_remark'=>json_encode($data)
                                );
                    save_log($log_arr);
                    //记录日志 end
					
					$this->success('操作成功',U('Mp/Capital/index'));
				}else{
					$this->error('操作失败','',2);
				}
			}else{
				$this->error('操作失败','',2);
			}
		}else{
			$this->error('没有该记录','',2);
		}
	}
	
	//余额明细
    public function dlbalance(){
        $this->check_qypurview('18004',1);
		
		$dlusername=trim(I('param.dlusername',''));
		$begintime=I('param.begintime','');
        $endtime=I('param.endtime','');
		$parameter=array();
		$dl_id=0;
		
        $Dealer = M('Dealer');
		$Balance= M('Balance');
		$back=0;
		if($dlusername!='' && $dlusername!='请输入代理账号'){
            if(!preg_match("/[a-zA-Z0-9_-]{4,20}$/",$dlusername)){
                $this->error('代理账号不正确','',1);
            }
			
			$map2=array();
            $map2['dl_username']=$dlusername;
            $map2['dl_unitcode']=session('unitcode');
            $data22=$Dealer->where($map2)->find();
            if($data22){

			}else{
				$this->error('代理账号不正确','',1);
			}
			
			$where=array();
			$where['bl_sendid']=$data22['dl_id'];
			$where['bl_receiveid']=$data22['dl_id'];
			$where['_logic'] = 'or';
			$map['_complex'] = $where;
			$dl_id=$data22['dl_id'];
			
			$parameter['dlusername']=$dlusername;
			$this->assign('dlusername', $dlusername);
        }else{
			$this->assign('dlusername', '请输入代理账号');
		}
		$this->assign('back', $back);
		
		
		if($begintime!='' && $endtime!=''){
            $begintime=strtotime($begintime);
			$endtime=strtotime($endtime);
			if($begintime===FALSE || $endtime===FALSE){
				$this->error('请选择查询日期','',1);
			}
			$endtime=$endtime+3600*24-1;
			if($begintime>=$endtime){
				$this->error('查询结束日期要大于开始日期','',1);
			}	
			
			$map['bl_addtime']=array('between',array($begintime,$endtime));
			
			$parameter['begintime']=urlencode(date('Y-m-d',$begintime));
			$parameter['endtime']=urlencode(date('Y-m-d',$endtime));
			
			$this->assign('begintime', date('Y-m-d',$begintime));
			$this->assign('endtime', date('Y-m-d',$endtime));
		}else{
            $begintime='';
            $endtime='';
		    $this->assign('begintime', '');
		    $this->assign('endtime', '');
		}
        $map['bl_unitcode']=session('unitcode');


        $count = $Balance->where($map)->count();
        $Page = new \Think\Page($count, C('PAGE_SIZE'),$parameter);
        $show = $Page->show();
        $list = $Balance->where($map)->order('bl_id DESC')->limit(($Page->firstRow . ',') . $Page->listRows)->select();
		
		foreach($list as $k=>$v){
			//收款代理信息
			if($v['bl_receiveid']>0){
				$map2=array();
				$map2['dl_id']=$v['bl_receiveid'];
				$map2['dl_unitcode']=session('unitcode');
				$data2=$Dealer->where($map2)->find();
				if($data2){
					$list[$k]['dl_name_str']=$data2['dl_name'].'('.$data2['dl_username'].')';
					$list[$k]['dl_number']=$data2['dl_number'];
				}else{
					$list[$k]['dl_name_str']='未知';
					$list[$k]['dl_number']='-';
				}
			}else{
				$list[$k]['dl_name_str']='-';
				$list[$k]['dl_number']='-';
			}
			
			//付款代理信息
			if($v['bl_sendid']>0){
				$map2=array();
				$map2['dl_id']=$v['bl_sendid'];
				$map2['dl_unitcode']=session('unitcode');
				$data2=$Dealer->where($map2)->find();
				if($data2){
					$list[$k]['dl_sendname_str']=$data2['dl_name'].'('.$data2['dl_username'].')';
				}else{
					$list[$k]['dl_sendname_str']='未知';
				}
			}else{
				$list[$k]['dl_sendname_str']='-';
			}
			
			
		    if($dl_id>0){
				if($v['bl_sendid']==$dl_id){
					$list[$k]['bl_moneystr']='<span style="color:#009900">-'.number_format($v['bl_money'], 2,'.','').'</span>';
				}
				
				if($v['bl_receiveid']==$dl_id){
				    $list[$k]['bl_moneystr']='<span style="color:#000000">+'.number_format($v['bl_money'], 2,'.','').'</span>';
				}
				
			}else{
				$list[$k]['bl_moneystr']=number_format($v['bl_money'], 2,'.','');
			}
			
			
		    ////余额分类 1-公司手动增减 2-订单增减  3-提现增减 (对于收方则是增，对于发方则是减) 
			if($v['bl_type']==1){
				if($v['bl_sendid']>0){
				    $list[$k]['bl_typestr']='公司手动减少';
				}
				if($v['bl_receiveid']>0){
				    $list[$k]['bl_typestr']='公司手动增加';
				}
			}else if($v['bl_type']==2){
				$list[$k]['bl_typestr']='订单款项增减';
			}else if($v['bl_type']==3){
				$list[$k]['bl_typestr']='提现款项增减';
			}else{
				$list[$k]['bl_typestr']='未知';
			}
			
			if($v['bl_state']==0){
				$list[$k]['bl_state_str']='无效';
			}else if($v['bl_state']==1){
				$list[$k]['bl_state_str']='有效';
			}else if($v['bl_state']==2){
				$list[$k]['bl_state_str']='冻结';
			}else{
				$list[$k]['bl_state_str']='未知';
			}
			
			if($v['bl_isyfk']==1){
				$list[$k]['bl_isyfk_str']='(由预付款支付)';
			}else{
				$list[$k]['bl_isyfk_str']='';
			}
		}
	
        $this->assign('list', $list);
        $this->assign('page', $show);
		$this->assign('pagecount', $count);
        $this->assign('curr', 'dlbalance');
        $this->display('dlbalance');
    }
	
	//余额明细详细
    public function balancedetail(){
        $this->check_qypurview('18004',1);
		
        $bl_id=intval(I('get.bl_id',0));
		$map=array();
		$map['bl_id']=$bl_id;
		$map['bl_unitcode']=session('unitcode');
		$Balance= M('Balance');
		$Dealer= M('Dealer');
		$data=$Balance->where($map)->find();
		if($data){
		    //余额分类 1-公司手动增减 2-订单增减  3-提现增减 (对于收方则是增，对于发方则是减) 
			if($data['bl_type']==1){
				if($data['bl_sendid']>0){
				    $data['bl_typestr']='公司手动减少';
				}
				if($data['bl_receiveid']>0){
				    $data['bl_typestr']='公司手动增加';
				}
			}else if($data['bl_type']==2){
				$data['bl_typestr']='订单款项增减';
			}else if($data['bl_type']==3){
				$data['bl_typestr']='提现款项增减';
			}else{
				$data['bl_typestr']='未知';
			}
			
			$data['bl_moneystr']=number_format($data['bl_money'], 2,'.','');
			
			//收款代理信息
			if($data['bl_receiveid']>0){
				$map2=array();
				
				$map2['dl_id']=$data['bl_receiveid'];
				$map2['dl_unitcode']=session('unitcode');
				$data2=$Dealer->where($map2)->find();
				if($data2){
					$data['dl_name_str']=$data2['dl_name'].'('.$data2['dl_username'].')';
				}else{
					$data['dl_name_str']='未知';
				}
			}else{
				$data['dl_name_str']='-';
			}
			
            //付款代理信息
			if($data['bl_sendid']>0){
				$map2=array();
				$map2['dl_id']=$data['bl_sendid'];
				$map2['dl_unitcode']=session('unitcode');
				$data2=$Dealer->where($map2)->find();
				if($data2){
					$data['dl_sendname_str']=$data2['dl_name'].'('.$data2['dl_username'].')';
				}else{
					$data['dl_sendname_str']='未知';
				}
			}else{
				$data['dl_sendname_str']='-';
			}
			
            if($data['bl_state']==0){
				$data['bl_state_str']='无效';
			}else if($data['bl_state']==1){
				$data['bl_state_str']='有效';
			}else if($data['bl_state']==2){
				$data['bl_state_str']='冻结';
			}else{
				$data['bl_state_str']='未知';
			}
			
			if($data['bl_isyfk']==1){
				$data['bl_isyfk_str']='(由预付款支付)';
			}else{
				$data['bl_isyfk_str']='';
			}
			
		}else{
			$this->error('没有该记录','',2);
		}

        $this->assign('yueinfo', $data);
		
        $this->assign('curr', 'dlbalance');
        $this->display('balancedetail');
	}
	
	
	//增减余额
    public function yueadd(){
        $this->check_qypurview('18005',1);
		
        $dl_id=intval(I('get.dl_id',0));
		$Dealer= M('Dealer');
		$map=array();
		$map['dl_id']=$dl_id;
		$map['dl_unitcode']=session('unitcode');
		$data=$Dealer->where($map)->find();
		if($data){
			if($data['dl_status']==1){
				$data['dl_name_str']=$data['dl_name'].'('.$data['dl_username'].')';
			}else{
				$this->error('该代理还没审核或已禁用','',2);
			}
		}else{
			$this->error('没有该记录','',2);
		}

        $this->assign('dealerinfo', $data);
		
		
        $this->assign('curr', 'capital');
        $this->display('yueadd');
	}
	
    //增减余额保存
    public function yueadd_save(){
        $this->check_qypurview('18005',1);

		$dl_id=intval(I('post.dl_id',0));

		if($dl_id>0){
			$Dealer= M('Dealer');
			$Balance= M('Balance');
			$map=array();
			$map['dl_id']=$dl_id;
			$map['dl_unitcode']=session('unitcode');
			$map['dl_status']=1;
			$data=$Dealer->where($map)->find();
			if($data){
			}else{
				$this->error('没有该记录','',2);
			}
			
			$bl_add=intval(I('post.bl_add',0));
			$bl_money=trim(I('post.bl_money',''));
			$bl_remark=trim(I('post.bl_remark',''));
			$pwd=trim(I('post.pwd',''));
			
			if($bl_add<=0){
				$this->error('请选择增减','',2);
			}
			
			if($bl_money==''){
				$this->error('请填写金额','',2);
			}
			
			if(!preg_match("/^[0-9.]{1,8}$/",$bl_money)){
				$this->error('填写金额必须为数字');
			}
			
			if($bl_money<=0){
				$this->error('填写金额必须大于0');
			}
				
			if($bl_remark==''){
				$this->error('请填写备注','',2);
			}
			
            if($pwd==''){
				$this->error('密码不能为空','',2);
			}
			
			//密码是否正确
			$Qyinfo= M('Qyinfo');
			$md5_qy_pwd=MD5(MD5(MD5($pwd)));
			//是否子用户登录
			$qy_username=session('qyuser');
			if(strpos($qy_username,':')===false){
				$qy_username2=$qy_username;
				$qy_subusername2='';
			}else{
				$qy_username_arr=explode(":", $qy_username);
				reset($qy_username_arr);
				$qy_username2 = current($qy_username_arr);
				$qy_subusername2= end($qy_username_arr);
			}
			if($qy_subusername2==''){
				$map2=array();
				$map2['qy_username']=$qy_username2;
				$map2['qy_code']=session('unitcode');
				$data2=$Qyinfo->where($map2)->find();
				if($data2){
					if($data2['qy_pwd']==$md5_qy_pwd){
						
					}else{
						$this->error('密码不正确','',2);
					}
				}else{
					$this->error('密码不正确','',2);
				}
			}else{
				$Qysubuser= M('Qysubuser');
				$map2=array();
				$map2['su_username']=$qy_subusername2;
				$map2['su_unitcode']=session('unitcode');
				
				$data2=$Qysubuser->where($map2)->find();
                if($data2){
					if($data2['su_pwd']==$md5_qy_pwd){
						
					}else{
						$this->error('密码不正确','',2);
					}
				}else{
					$this->error('密码不正确','',2);
				}
			}
            ////密码是否正确 end 
			
			
			$data=array();
			$data['bl_unitcode']=session('unitcode');
			$data['bl_type']=1;  //余额分类 1-公司手动增减 2-订单增减  3-提现增减 (对于收方则是增，对于发方则是减) 
			
			if($bl_add==1){  //增加
				$data['bl_sendid']=0;   //发款id
				$data['bl_receiveid']=$dl_id;  //收款id
				$dlg_action='手动增加余额：'.$bl_money;
			}else if($bl_add==2){ //减少
				$data['bl_sendid']=$dl_id;   //发款id
				$data['bl_receiveid']=0;  //收款id
				$dlg_action='手动减少余额：'.$bl_money;
				
				//检测剩余的余额是否够减少
				
				//余额 增加(有效的)
				$yueaddsum=0;
				$map2=array();
				$map2['bl_receiveid']=$dl_id;
				$map2['bl_unitcode']=session('unitcode');
				$map2['bl_type']=array('IN','1,2,3');  //余额分类 1-公司手动增减 2-订单增减  3-提现增减 (对于收方则是增，对于发方则是减) 
				$map2['bl_state']=1;  //状态 1-有效 0-无效 2-冻结
				$yueaddsum = $Balance->where($map2)->sum('bl_money'); 
				if($yueaddsum){
				}else{
					$yueaddsum=0;
				}
				
				//余额 减少(冻结)
				$yuefreezeminussum=0;
				$map2=array();
				$map2['bl_sendid']=$dl_id;
				$map2['bl_unitcode']=session('unitcode');
				$map2['bl_type']=array('IN','1,2,3');  //余额分类 1-公司手动增减 2-订单增减  3-提现增减 (对于收方则是增，对于发方则是减) 
				$map2['bl_state']=2;  //状态 1-有效 0-无效 2-冻结
				$map2['bl_isyfk']=0;  //是否预付款支付
				$yuefreezeminussum = $Balance->where($map2)->sum('bl_money'); 
				if($yuefreezeminussum){
				}else{
					$yuefreezeminussum=0;
				}
				
				//余额 减少(有效的)
				$yueminussum=0;
				$map2=array();
				$map2['bl_sendid']=$dl_id;
				$map2['bl_unitcode']=session('unitcode');
				$map2['bl_type']=array('IN','1,2,3');  //余额分类 1-公司手动增减 2-订单增减  3-提现增减 (对于收方则是增，对于发方则是减) 
				$map2['bl_state']=1;  //状态 1-有效 0-无效 2-冻结
				$map2['bl_isyfk']=0;  //是否预付款支付
				$yueminussum = $Balance->where($map2)->sum('bl_money'); 
				if($yueminussum){
				}else{
					$yueminussum=0;
				}
				
				if(($yueaddsum-$yueminussum-$yuefreezeminussum)<$bl_money){
					$this->error('减少的金额大于剩余的余额','',3);
				}
			}else{
				$this->error('请选择增减','',2);
			}

			$data['bl_money']=$bl_money;
			$data['bl_odid']=0;
			$data['bl_orderid']='';
			$data['bl_odblid']=0;
			$data['bl_addtime']=time();
			$data['bl_remark']=$bl_remark;
			$data['bl_state']=1;
			$data['bl_rcid']=0;
			
			$rs=$Balance->create($data,1);
			if($rs){
				$result = $Balance->add(); 
				if($result){
					
                    //代理操作日志 begin
					$odlog_arr=array(
								'dlg_unitcode'=>session('unitcode'),  
								'dlg_dlid'=>$dl_id,
								'dlg_operatid'=>session('qyid'),
								'dlg_dlusername'=>session('qyuser'),
								'dlg_dlname'=>session('qyuser'),
								'dlg_action'=>$dlg_action,
								'dlg_type'=>0, //0-企业 1-经销商
								'dlg_addtime'=>time(),
								'dlg_ip'=>real_ip(),
								'dlg_link'=>__SELF__
								);
					$Dealerlogs= M('Dealerlogs');
					$rs3=$Dealerlogs->create($odlog_arr,1);
					if($rs3){
						$Dealerlogs->add();
					}
					//代理操作日志 end
					
                    //记录日志 begin
                    $log_arr=array(
                                'log_qyid'=>session('qyid'),
                                'log_user'=>session('qyuser'),
                                'log_qycode'=>session('unitcode'),
                                'log_action'=>$dlg_action,
								'log_type'=>1, //0-系统 1-企业 2-经销商 3-消费者
                                'log_addtime'=>time(),
                                'log_ip'=>real_ip(),
                                'log_link'=>__SELF__,
                                'log_remark'=>json_encode($data)
                                );
                    save_log($log_arr);
                    //记录日志 end
					
					$this->success('操作成功',U('Mp/Capital/index'));
				}else{
					$this->error('操作失败','',2);
				}
			}else{
				$this->error('操作失败','',2);
			}
		}else{
			$this->error('没有该记录','',2);
		}
	}

    //提现记录
    public function recashlist(){
        $this->check_qypurview('18006',1);
		
		$map=array();
        $map['rc_unitcode']=session('unitcode');

        $Recash= M('Recash');
		$Dealer= M('Dealer');
        $count = $Recash->where($map)->count();
        $Page = new \Think\Page($count, C('PAGE_SIZE'),$parameter);
        $show = $Page->show();
        $list = $Recash->where($map)->order('rc_id DESC')->limit(($Page->firstRow . ',') . $Page->listRows)->select();
		
		foreach($list as $k=>$v){
			
			$list[$k]['rc_moneystr']='<span style="color:#009900">'.number_format($v['rc_money'], 2,'.','').'</span>';
			
			//提现代理
			if($v['rc_dlid']>0){
				$map2=array();
				$map2['dl_id']=$v['rc_dlid'];
				$map2['dl_unitcode']=session('unitcode');
				$data2=$Dealer->where($map2)->find();
				if($data2){
					$list[$k]['dl_name_str']=$data2['dl_name'].'('.$data2['dl_username'].')';
					$list[$k]['dl_number']=$data2['dl_number'];
				}else{
					$list[$k]['dl_name_str']='未知';
					$list[$k]['dl_number']='-';
				}
			}else{
				$list[$k]['dl_name_str']='未知';
				$list[$k]['dl_number']='-';
			}
			
			
			//付款代理
			if($v['rc_sdlid']>0){
				$map2=array();
				$map2['dl_id']=$v['rc_sdlid'];
				$map2['dl_unitcode']=session('unitcode');
				$data2=$Dealer->where($map2)->find();
				if($data2){
					$list[$k]['dl_sendname_str']=$data2['dl_name'].'('.$data2['dl_username'].')';
				}else{
					$list[$k]['dl_sendname_str']='未知';
				}
			}else{
				$list[$k]['dl_sendname_str']='总公司';
			}
			
			//发放方式
			if(isset(C('FANLI_BANKS')[$v['rc_bank']])){
				$list[$k]['rc_str']=C('FANLI_BANKS')[$v['rc_bank']];
			}else{
				$list[$k]['rc_str']='未知';
			}
			
            if(MD5($v['rc_unitcode'].$v['rc_dlid'].number_format($v['rc_money'],2,'.','').$v['rc_bankcard'].$v['rc_addtime'])==$v['rc_verify']){
				if($v['rc_state']==0){
					$list[$k]['rc_statestr']='未处理';
				}else if($v['rc_state']==1){
					$list[$k]['rc_statestr']='提现成功';
				}else if($v['rc_state']==2){
					$list[$k]['rc_statestr']='提现失败';
				}else{
					$list[$k]['rc_statestr']='异常';
				}
            }else{
				if($v['rc_state']==0){
					$list[$k]['rc_statestr']='未处理[异常]';
				}else if($v['rc_state']==1){
					$list[$k]['rc_statestr']='提现成功[异常]';
				}else if($v['rc_state']==2){
					$list[$k]['rc_statestr']='提现失败[异常]';
				}else{
					$list[$k]['rc_statestr']='异常';
				}
			}
		}
	
        $this->assign('list', $list);
        $this->assign('page', $show);
		$this->assign('pagecount', $count);
        $this->assign('curr', 'recashlist2');
        $this->display('recashlist');
    }
	
	//提现详细
    public function recashdetail(){
        $this->check_qypurview('18006',1);
		
        $rc_id=intval(I('get.rc_id',0));
		$back=intval(I('get.back',0));
		$map=array();
		$map['rc_id']=$rc_id;
		$map['rc_unitcode']=session('unitcode');
		$Recash= M('Recash');
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
					$data['rc_statestr']='未处理';
				}else if($data['rc_state']==1){
					$data['rc_statestr']='提现成功';
				}else if($data['rc_state']==2){
					$data['rc_statestr']='提现失败';
				}else{
					$data['rc_statestr']='其他';
				}
            }else{
				if($data['rc_state']==0){
					$data['rc_statestr']='未处理[异常]';
				}else if($data['rc_state']==1){
					$data['rc_statestr']='提现成功[异常]';
				}else if($data['rc_state']==2){
					$data['rc_statestr']='提现失败[异常]';
				}else{
					$data['rc_statestr']='异常';
				}
			}
			
			//提现代理
			if($data['rc_dlid']>0){
				$map2=array();
				$Dealer= M('Dealer');
				$map2['dl_id']=$data['rc_dlid'];
				$map2['dl_unitcode']=session('unitcode');
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
				$map2['dl_unitcode']=session('unitcode');
				$data2=$Dealer->where($map2)->find();
				if($data2){
					$data['dl_payname_str']=$data2['dl_name'].'('.$data2['dl_username'].')';
				}else{
					$data['dl_payname_str']='未知';
				}
			}else{
				$data['dl_payname_str']='总公司';
			}
			
			$imgpath = BASE_PATH.'/Public/uploads/orders/';
			//图片
            if(is_not_null($data['rc_pic']) && file_exists($imgpath.$data['rc_pic'])){
                $arr=getimagesize($imgpath.$data['rc_pic']);
                if(false!=$arr){
                    $w=$arr[0];
                    $h=$arr[1];
                    if($h>80){
                       $hh=80;
                       $ww=($w*80)/$h;
                    }else{
                       $hh=$h;
                       $ww=$w;
                    }
                    if($ww>80){
                       $ww=80;
                       $hh=($h*80)/$w;
                    }
                    $data['rc_pic_str']='<img src="'.__ROOT__.'/Public/uploads/orders/'.$data['rc_pic'].'" width="'.$ww.'"  height="'.$hh.'"  border="0" style="vertical-align:middle"  >';
                }
                else{
                    $data['rc_pic_str']='';
                }
            }else{
                $data['rc_pic_str']='';
            }
			
		}else{
			$this->error('没有该记录','',2);
		}

        $this->assign('recashinfo', $data);
		$this->assign('back', $back);
		
        $this->assign('curr', 'recashlist2');
        $this->display('recashdetail');
	}
	
	//提现处理
    public function recashdeal(){
        $this->check_qypurview('18006',1);
		
        $rc_id=intval(I('get.rc_id',0));
		$map=array();
		$map['rc_id']=$rc_id;
		$map['rc_unitcode']=session('unitcode');
		$map['rc_sdlid']=0;
		$Recash= M('Recash');
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
					$data['rc_statestr']='未处理';
				}else if($data['rc_state']==1){
					$data['rc_statestr']='提现成功';
				}else if($data['rc_state']==2){
					$data['rc_statestr']='提现失败';
				}else{
					$data['rc_statestr']='异常';
				}
            }else{
				if($data['rc_state']==0){
					$data['rc_statestr']='未处理[异常]';
				}else if($data['rc_state']==1){
					$data['rc_statestr']='提现成功[异常]';
				}else if($data['rc_state']==2){
					$data['rc_statestr']='提现失败[异常]';
				}else{
					$data['rc_statestr']='异常';
				}
			}
			
			//提现代理信息
			if($data['rc_dlid']>0){
				$map2=array();
				$Dealer= M('Dealer');
				$map2['dl_id']=$data['rc_dlid'];
				$map2['dl_unitcode']=session('unitcode');
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
				$map2['dl_unitcode']=session('unitcode');
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
                $arr=getimagesize($imgpath.$data['rc_pic']);
                if(false!=$arr){
                    $w=$arr[0];
                    $h=$arr[1];
                    if($h>80){
                       $hh=80;
                       $ww=($w*80)/$h;
                    }else{
                       $hh=$h;
                       $ww=$w;
                    }
                    if($ww>80){
                       $ww=80;
                       $hh=($h*80)/$w;
                    }
                    $data['rc_pic_str']='<img src="'.__ROOT__.'/Public/uploads/orders/'.$data['rc_pic'].'" width="'.$ww.'"  height="'.$hh.'"  border="0" style="vertical-align:middle"  >';
                }else{
                    $data['rc_pic_str']='';
                }
            }else{
                $data['rc_pic_str']='';
            }
			//确认余额明细里面有没记录
			$map2=array();
			$map2['bl_unitcode']=session('unitcode');
			$map2['bl_rcid']=$data['rc_id'];
			$map2['bl_type']=3; //余额分类 1-公司手动增减 2-订单增减  3-提现增减 (对于收方则是增，对于发方则是减) 
			$map2['bl_sendid']=$data['rc_dlid'];
			$Balance= M('Balance');
			$data2=$Balance->where($map2)->find();
			if($data2){
				$balancestr='';
			}else{
				$balancestr='注：该申请记录在余额明细里面没有对应记录，请处理为失败';
			}
			
			
		}else{
			$this->error('没有该记录','',2);
		}

        $this->assign('recashinfo', $data);
		 $this->assign('balancestr', $balancestr);
		
        $this->assign('curr', 'recashlist2');
        $this->display('recashdeal');
	}

    //提现处理保存
    public function recashdeal_save(){
        $this->check_qypurview('18006',1);
		//--------------------------------
		$rc_id=intval(I('post.rc_id',0));

		if($rc_id>0){
			$rc_state=intval(I('post.rc_state',0));
			$rc_remark=trim(I('post.rc_remark',''));
			$rc_remark2=trim(I('post.rc_remark2',''));
			if($rc_state<=0){
				$this->error('请选择处理状态','',2);
			}
			
			if($rc_state!=1 &&  $rc_state!=2){
				$this->error('请选择处理状态','',2);
			}
			
			if($rc_remark==''){
				$this->error('处理备注必须填写','',2);
			}
			
			$map=array();
			$Recash= M('Recash');
		    $map['rc_id']=$rc_id;
			$map['rc_sdlid']=0;
		    $map['rc_unitcode']=session('unitcode');
			$data=$Recash->where($map)->find();
			if($data){
				$data2=array();
				if($data['rc_dealtime']<=0){
				   $data2['rc_dealtime']=time();
				}
				
				//上传文件 begin
				if($_FILES['pic_file']['name']==''){
					$rc_pic='';
				}else{
					$upload = new \Think\Upload();
					$upload->maxSize = 3145728 ;
					$upload->exts = array('jpg', 'gif', 'png', 'jpeg');
					$upload->rootPath   = './Public/uploads/orders/';
					$upload->subName  = session('unitcode');
					$upload->saveName = time().'_'.mt_rand(1000,9999);
					
					$info   =   $upload->uploadOne($_FILES['pic_file']);

					if(!$info) {
						$this->error($upload->getError(),'',1);
					}else{
						$rc_pic=$info['savepath'].$info['savename'];
					}

					@unlink($upload->rootPath.$old_rc_pic); 
					@unlink($_FILES['pic_file']['tmp_name']); 
				}
				//上传文件 end
				
				if($rc_pic!=''){
				    $data2['rc_pic']=$rc_pic;
				}
				$Balance= M('Balance');
				//确认余额明细里面有没记录
				$map3=array();
				$map3['bl_unitcode']=session('unitcode');
				$map3['bl_rcid']=$data['rc_id'];
				$map3['bl_type']=3; //余额分类 1-公司手动增减 2-订单增减  3-提现增减 (对于收方则是增，对于发方则是减) 
				$map3['bl_sendid']=$data['rc_dlid'];

				$data3=$Balance->where($map3)->find();
				if($data3){
				}else{
					if($rc_state!=2){
						$this->error('该申请记录在余额明细里面没有对应记录，请处理为失败','',2);
					}
				}
				
                $data2['rc_state']=$rc_state;
				$data2['rc_remark']=$rc_remark;
				$data2['rc_remark2']=$rc_remark2;
				
                $rs=$Recash->where($map)->data($data2)->save();
				if($rs){
					//更改余额明细状态
					
					$map3=array();
					$map3['bl_sendid']=$data['rc_dlid']; 
					$map3['bl_unitcode']=session('unitcode');
					$map3['bl_rcid']=$data['rc_id'];
					$map3['bl_type']=3;
					$map3['bl_state']=2;  //0-无效 1-有效 2-冻结  

					$data3=array();
					if($rc_state==1){
						$data3['bl_state'] = 1;
					}else if($rc_state==2){
						$data3['bl_state'] = 0;
					}
					
					$Balance->where($map3)->data($data3)->save();
					
					
                    //代理操作日志 begin
					$odlog_arr=array(
								'dlg_unitcode'=>session('unitcode'),  
								'dlg_dlid'=>$data['rc_dlid'],
								'dlg_operatid'=>session('qyid'),
								'dlg_dlusername'=>session('qyuser'),
								'dlg_dlname'=>session('qyuser'),
								'dlg_action'=>'处理提现记录-'.$rc_state,
								'dlg_type'=>0, //0-企业 1-经销商
								'dlg_addtime'=>time(),
								'dlg_ip'=>real_ip(),
								'dlg_link'=>__SELF__
								);
					$Dealerlogs= M('Dealerlogs');
					$rs3=$Dealerlogs->create($odlog_arr,1);
					if($rs3){
						$Dealerlogs->add();
					}
					//代理操作日志 end
					
					
					//记录日志 begin
					$log_arr=array();
					$log_arr=array(
								'log_qyid'=>session('qyid'),
								'log_user'=>session('qyuser'),
								'log_qycode'=>session('unitcode'),
								'log_action'=>'处理提现记录',
								'log_type'=>1, //0-系统 1-企业 2-经销商 3-消费者
								'log_addtime'=>time(),
								'log_ip'=>real_ip(),
								'log_link'=>__SELF__,
								'log_remark'=>json_encode($data)
								);
					save_log($log_arr);
					//记录日志 end
					
					$this->success('提交成功',U('Mp/Capital/recashdetail/rc_id/'.$rc_id.'/back/1'),1);
				}else if($rs==0){
					$this->error('提交数据没改变','',2);
				}else{
					$this->error('提交失败','',2);
				}
			}else{
				$this->error('没有该记录','',2);
			}
		}else{
			$this->error('没有该记录','',2);
		}
	}
	
//===========================================================

    //充值记录
    public function payinlist(){
        $this->check_qypurview('18007',1);
		
		$map=array();
        $map['pi_unitcode']=session('unitcode');

        $Payin= M('Payin');
		$Dealer= M('Dealer');
        $count = $Payin->where($map)->count();
        $Page = new \Think\Page($count, C('PAGE_SIZE'),$parameter);
        $show = $Page->show();
        $list = $Payin->where($map)->order('pi_id DESC')->limit(($Page->firstRow . ',') . $Page->listRows)->select();
		
		foreach($list as $k=>$v){
			
			$list[$k]['pi_moneystr']='<span style="color:#009900">'.number_format($v['pi_money'], 2,'.','').'</span>';
			
			//充值代理
			if($v['pi_dlid']>0){
				$map2=array();
				$map2['dl_id']=$v['pi_dlid'];
				$map2['dl_unitcode']=session('unitcode');
				$data2=$Dealer->where($map2)->find();
				if($data2){
					$list[$k]['dl_name_str']=$data2['dl_name'].'('.$data2['dl_username'].')';
					$list[$k]['dl_number']=$data2['dl_number'];
				}else{
					$list[$k]['dl_name_str']='未知';
					$list[$k]['dl_number']='-';
				}
			}else{
				$list[$k]['dl_name_str']='未知';
				$list[$k]['dl_number']='-';
			}
			

			
            //状态
			if($v['pi_state']==0){
				$list[$k]['pi_statestr']='未处理';
			}else if($v['pi_state']==1){
				$list[$k]['pi_statestr']='充值成功';
			}else if($v['pi_state']==2){
				$list[$k]['pi_statestr']='充值失败';
			}else{
				$list[$k]['pi_statestr']='未知';
			}

		}
	
        $this->assign('list', $list);
        $this->assign('page', $show);
		$this->assign('pagecount', $count);
        $this->assign('curr', 'payinlist');
        $this->display('payinlist');
    }
	
	//充值记录详细
    public function payindetail(){
        $this->check_qypurview('18007',1);
		
        $pi_id=intval(I('get.pi_id',0));
		$back=intval(I('get.back',0));
		$map=array();
		$map['pi_id']=$pi_id;
		$map['pi_unitcode']=session('unitcode');
		$Payin= M('Payin');
		$data=$Payin->where($map)->find();
		if($data){
            $data['pi_moneystr']=number_format($data['pi_money'],2,'.','');

			if($data['pi_state']==0){
				$data['pi_statestr']='未处理';
			}else if($data['pi_state']==1){
				$data['pi_statestr']='充值成功';
			}else if($data['pi_state']==2){
				$data['pi_statestr']='充值失败';
			}else{
				$data['pi_statestr']='未知';
			}

			
			//充值代理
			if($data['pi_dlid']>0){
				$map2=array();
				$Dealer= M('Dealer');
				$map2['dl_id']=$data['pi_dlid'];
				$map2['dl_unitcode']=session('unitcode');
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
			

			
			$imgpath = BASE_PATH.'/Public/uploads/dealer/';
			//图片
            if(is_not_null($data['pi_pic']) && file_exists($imgpath.$data['pi_pic'])){
                $data['pi_pic_str']='<img src="'.__ROOT__.'/Public/uploads/dealer/'.$data['pi_pic'].'"   border="0" style="vertical-align:middle;width:10%"  >';
            }else{
                $data['pi_pic_str']='';
            }

			
		}else{
			$this->error('没有该记录','',2);
		}

        $this->assign('payininfo', $data);
		$this->assign('back', $back);
		
        $this->assign('curr', 'payinlist');
        $this->display('payindetail');
	}
	
	//充值记录处理
    public function payindeal(){
        $this->check_qypurview('18007',1);
		
        $pi_id=intval(I('get.pi_id',0));
		$map=array();
		$map['pi_id']=$pi_id;
		$map['pi_unitcode']=session('unitcode');
		$Payin= M('Payin');
		$data=$Payin->where($map)->find();
		if($data){
            $data['pi_moneystr']=number_format($data['pi_money'],2,'.','');

			if($data['pi_state']==0){
				$data['pi_statestr']='未处理';
			}else if($data['pi_state']==1){
				$data['pi_statestr']='充值成功';
			}else if($data['pi_state']==2){
				$data['pi_statestr']='充值失败';
			}else{
				$data['pi_statestr']='未知';
			}
			
			//充值代理
			if($data['pi_dlid']>0){
				$map2=array();
				$Dealer= M('Dealer');
				$map2['dl_id']=$data['pi_dlid'];
				$map2['dl_unitcode']=session('unitcode');
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
			
			$imgpath = BASE_PATH.'/Public/uploads/dealer/';
			//图片
            if(is_not_null($data['pi_pic']) && file_exists($imgpath.$data['pi_pic'])){
                $data['pi_pic_str']='<img src="'.__ROOT__.'/Public/uploads/dealer/'.$data['pi_pic'].'"   border="0" style="vertical-align:middle;width:10%"  >';
            }else{
                $data['pi_pic_str']='';
            }

		}else{
			$this->error('没有该记录','',2);
		}

        $this->assign('payininfo', $data);
		
        $this->assign('curr', 'payinlist');
        $this->display('payindeal');
	}

    //充值记录保存
    public function payindeal_save(){
        $this->check_qypurview('18007',1);
		//--------------------------------
		$pi_id=intval(I('post.pi_id',0));

		if($pi_id>0){
			$pi_state=intval(I('post.pi_state',0));
			$pi_dealremark=trim(I('post.pi_dealremark',''));

			if($pi_state<=0){
				$this->error('请选择处理状态','',2);
			}
			
			if($pi_state!=1 &&  $pi_state!=2){
				$this->error('请选择处理状态','',2);
			}
			
			if($pi_dealremark==''){
				$this->error('处理备注必须填写','',2);
			}
			
			$map=array();
			$Payin= M('Payin');
		    $map['pi_id']=$pi_id;
		    $map['pi_unitcode']=session('unitcode');
			$data=$Payin->where($map)->find();
			if($data){
				$data2=array();
				if($data['pi_dealtime']<=0){
				   $data2['pi_dealtime']=time();
				}
                $data2['pi_state']=$pi_state;
				$data2['pi_dealremark']=$pi_dealremark;

				
                $rs=$Payin->where($map)->data($data2)->save();
				if($rs){
                    //代理操作日志 begin
					$odlog_arr=array(
								'dlg_unitcode'=>session('unitcode'),  
								'dlg_dlid'=>$data['pi_dlid'],
								'dlg_operatid'=>session('qyid'),
								'dlg_dlusername'=>session('qyuser'),
								'dlg_dlname'=>session('qyuser'),
								'dlg_action'=>'处理充值记录-'.$pi_state,
								'dlg_type'=>0, //0-企业 1-经销商
								'dlg_addtime'=>time(),
								'dlg_ip'=>real_ip(),
								'dlg_link'=>__SELF__
								);
					$Dealerlogs= M('Dealerlogs');
					$rs3=$Dealerlogs->create($odlog_arr,1);
					if($rs3){
						$Dealerlogs->add();
					}
					//代理操作日志 end
					
					
					//记录日志 begin
					$log_arr=array();
					$log_arr=array(
								'log_qyid'=>session('qyid'),
								'log_user'=>session('qyuser'),
								'log_qycode'=>session('unitcode'),
								'log_action'=>'处理充值记录',
								'log_type'=>1, //0-系统 1-企业 2-经销商 3-消费者
								'log_addtime'=>time(),
								'log_ip'=>real_ip(),
								'log_link'=>__SELF__,
								'log_remark'=>json_encode($data)
								);
					save_log($log_arr);
					//记录日志 end
					
					$this->success('提交成功',U('Mp/Capital/payindetail/pi_id/'.$pi_id.'/back/1'),1);
				}else if($rs==0){
					$this->error('提交数据没改变','',2);
				}else{
					$this->error('提交失败','',2);
				}
			}else{
				$this->error('没有该记录','',2);
			}
		}else{
			$this->error('没有该记录','',2);
		}
	}
	
}