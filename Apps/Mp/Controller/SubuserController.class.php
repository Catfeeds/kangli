<?php
namespace Mp\Controller;
use Think\Controller;
//子用户管理
class SubuserController extends CommController {
   //子用户列表 用于APP出货扫描 或 管理
    public function index(){
        // $this->check_qypurview('17001',1);

        $map['su_unitcode']=session('unitcode');
		$map['su_belong']=0;
		$map['su_username']=array('neq','');
        $Qysubuser = M('Qysubuser');
        $list = $Qysubuser->where($map)->order('su_id DESC')->select();
        $this->assign('qysubuserlist', $list);

		$this->assign('qyuser', session('qyuser'));
        $this->assign('curr', 'subuser');
        $this->display('index');
    }
	
	//子用户添加 
	public function subuseradd(){
//        dump(session('qy_purview'));die();
		$this->check_qypurview('17001',1);
		$purview_arr=array();
		$hide_arr=array();
		if($this->check_qypurview('10000',0)){  //经销商管理
		    $purview_arr['10000']=array('pname'=>'经销商管理','value'=>'10000','sub'=>array());
			$sub_arr=array();
		    if($this->check_qypurview('10001',0)){
				$sub_arr[]=array('pname'=>'经销商列表','value'=>'10001');
			}
			if($this->check_qypurview('10002',0)){
				$sub_arr[]=array('pname'=>'添加经销商','value'=>'10002');
			}
			if($this->check_qypurview('10003',0)){
			    $sub_arr[]=array('pname'=>'删除经销商','value'=>'10003');
			}
			if($this->check_qypurview('10004',0)){
				$sub_arr[]=array('pname'=>'修改经销商','value'=>'10004');
			}
			if($this->check_qypurview('10005',0)){
			    $sub_arr[]=array('pname'=>'经销商级别','value'=>'10005');
			}
			
			//隐藏的
			if($this->check_qypurview('10008',0)){
				$hide_arr[]=array('pname'=>'','value'=>'10008');
			}
			if($this->check_qypurview('10009',0)){
				$hide_arr[]=array('pname'=>'','value'=>'10009');
			}
			if($this->check_qypurview('10010',0)){
			    $hide_arr[]=array('pname'=>'','value'=>'10010');
			}

			$ids='';
			foreach($sub_arr as $kk=>$vv){ 
			    if($kk==0){
					$ids=$vv['value'];
				}else{
					$ids=$ids.','.$vv['value'];
				}
			}
            $purview_arr['10000']['ids']=$ids;
			$purview_arr['10000']['sub']=$sub_arr;
			
		}
		
		if($this->check_qypurview('90000',0)){  //经销商登录
            //隐藏的
			if($this->check_qypurview('90000',0)){
				$hide_arr[]=array('pname'=>'','value'=>'90000');
			}
			if($this->check_qypurview('90001',0)){
				$hide_arr[]=array('pname'=>'','value'=>'90001');
			}
			if($this->check_qypurview('90002',0)){
				$hide_arr[]=array('pname'=>'','value'=>'90002');
			}
			if($this->check_qypurview('90003',0)){
			    $hide_arr[]=array('pname'=>'','value'=>'90003');
			}
			if($this->check_qypurview('90004',0)){
			    $hide_arr[]=array('pname'=>'','value'=>'90004');
			}
			if($this->check_qypurview('90005',0)){
			    $hide_arr[]=array('pname'=>'','value'=>'90005');
			}
		}
		
		if($this->check_qypurview('20000',0)){  //产品管理
		    $purview_arr['20000']=array('pname'=>'产品管理','value'=>'20000','sub'=>array());
			
			$sub_arr=array();
		    if($this->check_qypurview('20001',0)){
				$sub_arr[]=array('pname'=>'产品列表','value'=>'20001');
			}
			if($this->check_qypurview('20002',0)){
				$sub_arr[]=array('pname'=>'添加/修改产品','value'=>'20002');
			}
			if($this->check_qypurview('20003',0)){
			    $sub_arr[]=array('pname'=>'删除产品','value'=>'20003');
			}
			if($this->check_qypurview('20004',0)){
				$sub_arr[]=array('pname'=>'产品分类','value'=>'20004');
			}
			if($this->check_qypurview('20005',0)){
			    $sub_arr[]=array('pname'=>'价格体系','value'=>'20005');
			}
			
			//隐藏的
			if($this->check_qypurview('20006',0)){
				$hide_arr[]=array('pname'=>'','value'=>'20006');
			}
			if($this->check_qypurview('20007',0)){
				$hide_arr[]=array('pname'=>'','value'=>'20007');
			}
			if($this->check_qypurview('20008',0)){
			    $hide_arr[]=array('pname'=>'','value'=>'20008');
			}
			if($this->check_qypurview('20009',0)){
			    $hide_arr[]=array('pname'=>'','value'=>'20009');
			}
			if($this->check_qypurview('20010',0)){
			    $hide_arr[]=array('pname'=>'','value'=>'20010');
			}
			if($this->check_qypurview('20011',0)){
			    $hide_arr[]=array('pname'=>'','value'=>'20011');
			}
			if($this->check_qypurview('20012',0)){
			    $hide_arr[]=array('pname'=>'','value'=>'20012');
			}

			$ids='';
			foreach($sub_arr as $kk=>$vv){ 
			    if($kk==0){
					$ids=$vv['value'];
				}else{
					$ids=$ids.','.$vv['value'];
				}
			}
            $purview_arr['20000']['ids']=$ids;
			$purview_arr['20000']['sub']=$sub_arr;
			
		}
		if($this->check_qypurview('11000',0)){  //仓库管理
		   $purview_arr['11000']=array('pname'=>'仓库管理','value'=>'11000','sub'=>array());
		   
		    $sub_arr=array();
		    if($this->check_qypurview('11001',0)){
				$sub_arr[]=array('pname'=>'仓库列表','value'=>'11001');
			}
			if($this->check_qypurview('11002',0)){
				$sub_arr[]=array('pname'=>'删除修改仓库','value'=>'11002');
			}
			
			$ids='';
			foreach($sub_arr as $kk=>$vv){ 
			    if($kk==0){
					$ids=$vv['value'];
				}else{
					$ids=$ids.','.$vv['value'];
				}
			}
            $purview_arr['11000']['ids']=$ids;
			
			$purview_arr['11000']['sub']=$sub_arr;
			
		}
		
		if($this->check_qypurview('30000',0)){  //出货管理
		    $purview_arr['30000']=array('pname'=>'出货管理','value'=>'30000','sub'=>array());
			
			$sub_arr=array();
		    if($this->check_qypurview('30001',0)){
				$sub_arr[]=array('pname'=>'出货列表','value'=>'30001');
			}
			if($this->check_qypurview('30002',0)){
				$sub_arr[]=array('pname'=>'出货扫描','value'=>'30002');
			}
			if($this->check_qypurview('30003',0)){
			    $sub_arr[]=array('pname'=>'出货导入','value'=>'30003');
			}
			if($this->check_qypurview('30004',0)){
				$sub_arr[]=array('pname'=>'微信出货','value'=>'30004');
			}
			if($this->check_qypurview('30005',0)){
			    $sub_arr[]=array('pname'=>'出货修改','value'=>'30005');
			}
			if($this->check_qypurview('30006',0)){
			    $sub_arr[]=array('pname'=>'PDA出货','value'=>'30006');
			}
			if($this->check_qypurview('30007',0)){
			    $sub_arr[]=array('pname'=>'出货统计','value'=>'30007');
			}
			if($this->check_qypurview('30008',0)){
			    $sub_arr[]=array('pname'=>'出货删除','value'=>'30008');
			}
			
			//隐藏的
			if($this->check_qypurview('16004',0)){
			    $sub_arr[]=array('pname'=>'','value'=>'16004');
			}
			


			$ids='';
			foreach($sub_arr as $kk=>$vv){ 
			    if($kk==0){
					$ids=$vv['value'];
				}else{
					$ids=$ids.','.$vv['value'];
				}
			}
            $purview_arr['30000']['ids']=$ids;
			
			$purview_arr['30000']['sub']=$sub_arr;
		}
		
		if($this->check_qypurview('13000',0)){
		   $purview_arr['13000']=array('pname'=>'订单管理','value'=>'13000','sub'=>array());
		   
		    $sub_arr=array();
		    if($this->check_qypurview('13001',0)){
				$sub_arr[]=array('pname'=>'公司订单','value'=>'13001');
			}
			if($this->check_qypurview('13002',0)){
				$sub_arr[]=array('pname'=>'所有订单','value'=>'13002');
			}
			if($this->check_qypurview('13003',0)){
				$sub_arr[]=array('pname'=>'发货地址','value'=>'13003');
			}
			if($this->check_qypurview('13005',0)){
				$sub_arr[]=array('pname'=>'代理业绩','value'=>'13005');
			}
			if($this->check_qypurview('13006',0)){
				$sub_arr[]=array('pname'=>'退换货管理','value'=>'13006');
			}			
			if($this->check_qypurview('13010',0)){
				$sub_arr[]=array('pname'=>'订货订单','value'=>'13010');
			}
			
			//隐藏的
			if($this->check_qypurview('13004',0)){
				$hide_arr[]=array('pname'=>'','value'=>'13004');
			}
			
			$ids='';
			foreach($sub_arr as $kk=>$vv){ 
			    if($kk==0){
					$ids=$vv['value'];
				}else{
					$ids=$ids.','.$vv['value'];
				}
			}
            $purview_arr['13000']['ids']=$ids;
			
			$purview_arr['13000']['sub']=$sub_arr;
		}
		
		if($this->check_qypurview('14000',0)){
		   $purview_arr['14000']=array('pname'=>'返利管理','value'=>'14000','sub'=>array());
		   
		    $sub_arr=array();
		    if($this->check_qypurview('14001',0)){
				$sub_arr[]=array('pname'=>'代理返利','value'=>'14001');
			}
			if($this->check_qypurview('14002',0)){
				$sub_arr[]=array('pname'=>'返利明细','value'=>'14002');
			}
			if($this->check_qypurview('14003',0)){
				$sub_arr[]=array('pname'=>'返利提现','value'=>'14003');
			}
			if($this->check_qypurview('14004',0)){
				$sub_arr[]=array('pname'=>'销售累计奖','value'=>'14004');
			}
			
			$ids='';
			foreach($sub_arr as $kk=>$vv){ 
			    if($kk==0){
					$ids=$vv['value'];
				}else{
					$ids=$ids.','.$vv['value'];
				}
			}
            $purview_arr['14000']['ids']=$ids;
			
			$purview_arr['14000']['sub']=$sub_arr;
		}
		
		if($this->check_qypurview('18000',0)){
		   $purview_arr['18000']=array('pname'=>'资金管理','value'=>'18000','sub'=>array());
		   
		    $sub_arr=array();
		    if($this->check_qypurview('18001',0)){
				$sub_arr[]=array('pname'=>'代理资金','value'=>'18001');
			}
			if($this->check_qypurview('18002',0)){
				$sub_arr[]=array('pname'=>'预付款明细','value'=>'18002');
			}
			if($this->check_qypurview('18003',0)){
				$sub_arr[]=array('pname'=>'增减预付','value'=>'18003');
			}
			if($this->check_qypurview('18004',0)){
				$sub_arr[]=array('pname'=>'余额明细','value'=>'18004');
			}
			if($this->check_qypurview('18005',0)){
				$sub_arr[]=array('pname'=>'增减余额','value'=>'18005');
			}
			if($this->check_qypurview('18006',0)){
				$sub_arr[]=array('pname'=>'提现记录','value'=>'18006');
			}
			if($this->check_qypurview('18007',0)){
				$sub_arr[]=array('pname'=>'充值记录','value'=>'18007');
			}
			
			$ids='';
			foreach($sub_arr as $kk=>$vv){ 
			    if($kk==0){
					$ids=$vv['value'];
				}else{
					$ids=$ids.','.$vv['value'];
				}
			}
            $purview_arr['18000']['ids']=$ids;
			
			$purview_arr['18000']['sub']=$sub_arr;
		}
		
		//代理积分
		if($this->check_qypurview('15000',0)){
		   $purview_arr['15000']=array('pname'=>'积分管理','value'=>'15000','sub'=>array());
		   
		    $sub_arr=array();
		    if($this->check_qypurview('15001',0)){
				$sub_arr[]=array('pname'=>'积分明细','value'=>'15001');
			}
			
			if($this->check_qypurview('15002',0)){
				$sub_arr[]=array('pname'=>'兑换管理','value'=>'15002');
			}
			
			if($this->check_qypurview('15003',0)){
				$sub_arr[]=array('pname'=>'礼品管理','value'=>'15003');
			}
			
			if($this->check_qypurview('15004',0)){
				$sub_arr[]=array('pname'=>'手动积分','value'=>'15004');
			}
			
			$ids='';
			foreach($sub_arr as $kk=>$vv){ 
			    if($kk==0){
					$ids=$vv['value'];
				}else{
					$ids=$ids.','.$vv['value'];
				}
			}
            $purview_arr['15000']['ids']=$ids;
			
			$purview_arr['15000']['sub']=$sub_arr;
		}
		
		if($this->check_qypurview('70000',0)){
		   $purview_arr['70000']=array('pname'=>'前端设置','value'=>'70000','sub'=>array());
		   
		    $sub_arr=array();
		    if($this->check_qypurview('70001',0)){
				$sub_arr[]=array('pname'=>'基本设置','value'=>'70001');
			}
			
			if($this->check_qypurview('70010',0)){
				$sub_arr[]=array('pname'=>'基本信息','value'=>'70010');
			}
			
			if($this->check_qypurview('70011',0)){
				$sub_arr[]=array('pname'=>'公司简介','value'=>'70011');
			}
			
			if($this->check_qypurview('70012',0)){
				$sub_arr[]=array('pname'=>'联系方式','value'=>'70012');
			}
			
			if($this->check_qypurview('70002',0)){
				$sub_arr[]=array('pname'=>'积分说明','value'=>'70002');
			}
			
			if($this->check_qypurview('70003',0)){
				$sub_arr[]=array('pname'=>'帮助中心','value'=>'70003');
			}
			
			if($this->check_qypurview('70004',0)){
				$sub_arr[]=array('pname'=>'注册协议','value'=>'70004');
			}
			
			if($this->check_qypurview('70005',0)){
				$sub_arr[]=array('pname'=>'产品展示','value'=>'70005');
			}
			
			if($this->check_qypurview('70008',0)){
				$sub_arr[]=array('pname'=>'产品分类','value'=>'70008');
			}
			
			if($this->check_qypurview('70006',0)){
				$sub_arr[]=array('pname'=>'企业动态','value'=>'70006');
			}
			
			if($this->check_qypurview('70007',0)){
				$sub_arr[]=array('pname'=>'图片管理','value'=>'70007');
			}
			
			if($this->check_qypurview('70009',0)){
				$sub_arr[]=array('pname'=>'留言反馈','value'=>'70009');
			}
			
			if($this->check_qypurview('70013',0)){
				$sub_arr[]=array('pname'=>'买家秀','value'=>'70013');
			}
			
			if($this->check_qypurview('70014',0)){
				$sub_arr[]=array('pname'=>'调查问卷','value'=>'70014');
			}
			
			if($this->check_qypurview('70015',0)){
				$sub_arr[]=array('pname'=>'招商政策','value'=>'70015');
			}
			
			if($this->check_qypurview('70018',0)){
				$sub_arr[]=array('pname'=>'海报设置','value'=>'70018');
			}
			if($this->check_qypurview('70017',0)){
				$sub_arr[]=array('pname'=>'LOGO设置','value'=>'70017');
			}
			if($this->check_qypurview('70019',0)){
				$sub_arr[]=array('pname'=>'底部图片','value'=>'70019');
			}
			if($this->check_qypurview('70020',0)){
				$sub_arr[]=array('pname'=>'图片素材','value'=>'70020');
			}
			if($this->check_qypurview('70021',0)){
				$sub_arr[]=array('pname'=>'商家活动','value'=>'70021');
			}
			if($this->check_qypurview('70022',0)){
				$sub_arr[]=array('pname'=>'线下实体店','value'=>'70022');
			}
			if($this->check_qypurview('70023',0)){
				$sub_arr[]=array('pname'=>'培训机构','value'=>'70023');
			}
			
			//隐藏的
			if($this->check_qypurview('70016',0)){
				$hide_arr[]=array('pname'=>'','value'=>'70016');
			}
			
			$ids='';
			foreach($sub_arr as $kk=>$vv){ 
			    if($kk==0){
					$ids=$vv['value'];
				}else{
					$ids=$ids.','.$vv['value'];
				}
			}
            $purview_arr['70000']['ids']=$ids;
			
			$purview_arr['70000']['sub']=$sub_arr;
		}
		
		if($this->check_qypurview('80000',0)){
		   $purview_arr['80000']=array('pname'=>'查询','value'=>'80000','sub'=>array());
		   
		    $sub_arr=array();
		    if($this->check_qypurview('80001',0)){
				$sub_arr[]=array('pname'=>'防窜货查询','value'=>'80001');
			}
			
			if($this->check_qypurview('80002',0)){
				$sub_arr[]=array('pname'=>'防伪码查询记录','value'=>'80002');
			}
			//隐藏的
			if($this->check_qypurview('80003',0)){
				$hide_arr[]=array('pname'=>'','value'=>'80003');
			}
			
			if($this->check_qypurview('80004',0)){
				$hide_arr[]=array('pname'=>'','value'=>'80004');
			}
			
			$ids='';
			foreach($sub_arr as $kk=>$vv){ 
			    if($kk==0){
					$ids=$vv['value'];
				}else{
					$ids=$ids.','.$vv['value'];
				}
			}
            $purview_arr['80000']['ids']=$ids;
			
			$purview_arr['80000']['sub']=$sub_arr;
		}


		
		$data2=array();
		$data2['su_id']=0;
		$this->assign('mtitle', '添加子用户');
        $this->assign('curr', 'subuser');
		$this->assign('purview_arr', $purview_arr);
		$this->assign('hide_arr', $hide_arr);
		$this->assign('subuserinfo', $data2);
		
        $this->display('subuseradd');
	}
	
    //子用户修改  
    public function subuseredit(){
        $this->check_qypurview('17001',1);
		
        $map['su_id']=intval(I('get.su_id',0));
		$map['su_unitcode']=session('unitcode');
		
        $Qysubuser= M('Qysubuser');
        $data=$Qysubuser->where($map)->find();
		
        if($data){
            $su_purview=$data['su_purview'];
            if(is_not_null($su_purview)){
                $su_purview_arr=explode(",", $su_purview);
            }else{
                $su_purview_arr=array();
            }
            $supurview_arr=array();
            foreach($su_purview_arr as $k=>$v){
                $supurview_arr[$v]=$v;
            }
			
			
		$purview_arr=array();
		$hide_arr=array();
		//经销商管理
		if($this->check_qypurview('10000',0)){  
		    $purview_arr['10000']=array('pname'=>'经销商管理','value'=>'10000','sub'=>array());
			if(isset($supurview_arr['10000'])){
				$purview_arr['10000']['checked']='checked';
			}
			
			$sub_arr=array();
		    if($this->check_qypurview('10001',0)){
				$sub_arr[]=array('pname'=>'经销商列表','value'=>'10001');
			}
			if($this->check_qypurview('10002',0)){
				$sub_arr[]=array('pname'=>'添加经销商','value'=>'10002');
			}
			if($this->check_qypurview('10003',0)){
			    $sub_arr[]=array('pname'=>'删除经销商','value'=>'10003');
			}
			if($this->check_qypurview('10004',0)){
				$sub_arr[]=array('pname'=>'修改经销商','value'=>'10004');
			}
			if($this->check_qypurview('10005',0)){
			    $sub_arr[]=array('pname'=>'经销商级别','value'=>'10005');
			}
			
			//隐藏的
			if($this->check_qypurview('10008',0)){
				$hide_arr[]=array('pname'=>'','value'=>'10008');
			}
			if($this->check_qypurview('10009',0)){
				$hide_arr[]=array('pname'=>'','value'=>'10009');
			}
			if($this->check_qypurview('10010',0)){
			    $hide_arr[]=array('pname'=>'','value'=>'10010');
			}
			
			$ids='';
			foreach($sub_arr as $kk=>$vv){ 
			    if($kk==0){
					$ids=$vv['value'];
				}else{
					$ids=$ids.','.$vv['value'];
				}
				
				if(isset($supurview_arr[$vv['value']])){
				    $sub_arr[$kk]['checked']='checked';
			    }
			}
			
            $purview_arr['10000']['ids']=$ids;
			$purview_arr['10000']['sub']=$sub_arr;
			
		}
		
		if($this->check_qypurview('90000',0)){  //经销商登录
            //隐藏的
			if($this->check_qypurview('90000',0)){
				$hide_arr[]=array('pname'=>'','value'=>'90000');
			}
			if($this->check_qypurview('90001',0)){
				$hide_arr[]=array('pname'=>'','value'=>'90001');
			}
			if($this->check_qypurview('90002',0)){
				$hide_arr[]=array('pname'=>'','value'=>'90002');
			}
			if($this->check_qypurview('90003',0)){
			    $hide_arr[]=array('pname'=>'','value'=>'90003');
			}
			if($this->check_qypurview('90004',0)){
			    $hide_arr[]=array('pname'=>'','value'=>'90004');
			}
			if($this->check_qypurview('90005',0)){
			    $hide_arr[]=array('pname'=>'','value'=>'90005');
			}
		}
		
		if($this->check_qypurview('20000',0)){  //产品管理
		    $purview_arr['20000']=array('pname'=>'产品管理','value'=>'20000','sub'=>array());
			if(isset($supurview_arr['20000'])){
				$purview_arr['20000']['checked']='checked';
			}
			
			$sub_arr=array();
		    if($this->check_qypurview('20001',0)){
				$sub_arr[]=array('pname'=>'产品列表','value'=>'20001');
			}
			if($this->check_qypurview('20002',0)){
				$sub_arr[]=array('pname'=>'添加/修改产品','value'=>'20002');
			}
			if($this->check_qypurview('20003',0)){
			    $sub_arr[]=array('pname'=>'删除产品','value'=>'20003');
			}
			if($this->check_qypurview('20004',0)){
				$sub_arr[]=array('pname'=>'产品分类','value'=>'20004');
			}
			if($this->check_qypurview('20005',0)){
			    $sub_arr[]=array('pname'=>'价格体系','value'=>'20005');
			}
			
			//隐藏的
			if($this->check_qypurview('20006',0)){
				$hide_arr[]=array('pname'=>'','value'=>'20006');
			}
			if($this->check_qypurview('20007',0)){
				$hide_arr[]=array('pname'=>'','value'=>'20007');
			}
			if($this->check_qypurview('20008',0)){
			    $hide_arr[]=array('pname'=>'','value'=>'20008');
			}
			if($this->check_qypurview('20009',0)){
			    $hide_arr[]=array('pname'=>'','value'=>'20009');
			}
			if($this->check_qypurview('20010',0)){
			    $hide_arr[]=array('pname'=>'','value'=>'20010');
			}
			if($this->check_qypurview('20011',0)){
			    $hide_arr[]=array('pname'=>'','value'=>'20011');
			}
			if($this->check_qypurview('20012',0)){
			    $hide_arr[]=array('pname'=>'','value'=>'20012');
			}

			$ids='';
			foreach($sub_arr as $kk=>$vv){ 
			    if($kk==0){
					$ids=$vv['value'];
				}else{
					$ids=$ids.','.$vv['value'];
				}
				
				if(isset($supurview_arr[$vv['value']])){
				    $sub_arr[$kk]['checked']='checked';
			    }
			}
            $purview_arr['20000']['ids']=$ids;
			
			$purview_arr['20000']['sub']=$sub_arr;
			
		}
		
		if($this->check_qypurview('11000',0)){  //仓库管理
		   $purview_arr['11000']=array('pname'=>'仓库管理','value'=>'11000','sub'=>array());
			if(isset($supurview_arr['11000'])){
				$purview_arr['11000']['checked']='checked';
			}
			
		    $sub_arr=array();
		    if($this->check_qypurview('11001',0)){
				$sub_arr[]=array('pname'=>'仓库列表','value'=>'11001');
			}
			if($this->check_qypurview('11002',0)){
				$sub_arr[]=array('pname'=>'删除修改仓库','value'=>'11002');
			}
			
			$ids='';
			foreach($sub_arr as $kk=>$vv){ 
			    if($kk==0){
					$ids=$vv['value'];
				}else{
					$ids=$ids.','.$vv['value'];
				}
				
				if(isset($supurview_arr[$vv['value']])){
				    $sub_arr[$kk]['checked']='checked';
			    }
			}
            $purview_arr['11000']['ids']=$ids;
			
			$purview_arr['11000']['sub']=$sub_arr;
			
		}
		
		if($this->check_qypurview('30000',0)){  //出货管理
		    $purview_arr['30000']=array('pname'=>'出货管理','value'=>'30000','sub'=>array());
			if(isset($supurview_arr['30000'])){
				$purview_arr['30000']['checked']='checked';
			}
			
			$sub_arr=array();
		    if($this->check_qypurview('30001',0)){
				$sub_arr[]=array('pname'=>'出货列表','value'=>'30001');
			}
			if($this->check_qypurview('30002',0)){
				$sub_arr[]=array('pname'=>'出货扫描','value'=>'30002');
			}
			if($this->check_qypurview('30003',0)){
			    $sub_arr[]=array('pname'=>'出货导入','value'=>'30003');
			}
			if($this->check_qypurview('30004',0)){
				$sub_arr[]=array('pname'=>'微信出货','value'=>'30004');
			}
			if($this->check_qypurview('30005',0)){
			    $sub_arr[]=array('pname'=>'出货修改','value'=>'30005');
			}
			if($this->check_qypurview('30006',0)){
			    $sub_arr[]=array('pname'=>'PDA出货','value'=>'30006');
			}
			if($this->check_qypurview('30007',0)){
			    $sub_arr[]=array('pname'=>'出货统计','value'=>'30007');
			}
			if($this->check_qypurview('30008',0)){
			    $sub_arr[]=array('pname'=>'出货删除','value'=>'30008');
			}
			
			//隐藏的
			if($this->check_qypurview('16004',0)){
			    $sub_arr[]=array('pname'=>'','value'=>'16004');
			}

			$ids='';
			foreach($sub_arr as $kk=>$vv){ 
			    if($kk==0){
					$ids=$vv['value'];
				}else{
					$ids=$ids.','.$vv['value'];
				}
				
				if(isset($supurview_arr[$vv['value']])){
				    $sub_arr[$kk]['checked']='checked';
			    }
				
			}
            $purview_arr['30000']['ids']=$ids;
			
			$purview_arr['30000']['sub']=$sub_arr;
		}
		
		if($this->check_qypurview('13000',0)){
		   $purview_arr['13000']=array('pname'=>'订单管理','value'=>'13000','sub'=>array());
			if(isset($supurview_arr['13000'])){
				$purview_arr['13000']['checked']='checked';
			}
			
		    $sub_arr=array();
		    if($this->check_qypurview('13001',0)){
				$sub_arr[]=array('pname'=>'公司订单','value'=>'13001');
			}
			if($this->check_qypurview('13002',0)){
				$sub_arr[]=array('pname'=>'所有订单','value'=>'13002');
			}
			if($this->check_qypurview('13003',0)){
				$sub_arr[]=array('pname'=>'发货地址','value'=>'13003');
			}
			if($this->check_qypurview('13005',0)){
				$sub_arr[]=array('pname'=>'代理业绩','value'=>'13005');
			}
			if($this->check_qypurview('13006',0)){
				$sub_arr[]=array('pname'=>'退换货管理','value'=>'13006');
			}
			
			//隐藏的
			if($this->check_qypurview('13004',0)){
				$hide_arr[]=array('pname'=>'','value'=>'13004');
			}
			
			$ids='';
			foreach($sub_arr as $kk=>$vv){ 
			    if($kk==0){
					$ids=$vv['value'];
				}else{
					$ids=$ids.','.$vv['value'];
				}
				
				if(isset($supurview_arr[$vv['value']])){
				    $sub_arr[$kk]['checked']='checked';
			    }
				
			}
            $purview_arr['13000']['ids']=$ids;
			
			$purview_arr['13000']['sub']=$sub_arr;
		}
		
		if($this->check_qypurview('14000',0)){
		   $purview_arr['14000']=array('pname'=>'返利管理','value'=>'14000','sub'=>array());
			if(isset($supurview_arr['14000'])){
				$purview_arr['14000']['checked']='checked';
			}
			
		    $sub_arr=array();
		    if($this->check_qypurview('14001',0)){
				$sub_arr[]=array('pname'=>'代理返利','value'=>'14001');
			}
			if($this->check_qypurview('14002',0)){
				$sub_arr[]=array('pname'=>'返利明细','value'=>'14002');
			}
			if($this->check_qypurview('14003',0)){
				$sub_arr[]=array('pname'=>'返利提现','value'=>'14003');
			}
			if($this->check_qypurview('14004',0)){
				$sub_arr[]=array('pname'=>'销售累计奖','value'=>'14004');
			}
			
			$ids='';
			foreach($sub_arr as $kk=>$vv){ 
			    if($kk==0){
					$ids=$vv['value'];
				}else{
					$ids=$ids.','.$vv['value'];
				}
				
				if(isset($supurview_arr[$vv['value']])){
				    $sub_arr[$kk]['checked']='checked';
			    }
			}
            $purview_arr['14000']['ids']=$ids;
			
			$purview_arr['14000']['sub']=$sub_arr;
		}
		
		if($this->check_qypurview('18000',0)){
		   $purview_arr['18000']=array('pname'=>'资金管理','value'=>'18000','sub'=>array());
		   	if(isset($supurview_arr['18000'])){
				$purview_arr['18000']['checked']='checked';
			}
			
		    $sub_arr=array();
		    if($this->check_qypurview('18001',0)){
				$sub_arr[]=array('pname'=>'代理资金','value'=>'18001');
			}
			if($this->check_qypurview('18002',0)){
				$sub_arr[]=array('pname'=>'预付款明细','value'=>'18002');
			}
			if($this->check_qypurview('18003',0)){
				$sub_arr[]=array('pname'=>'增减预付','value'=>'18003');
			}
			if($this->check_qypurview('18004',0)){
				$sub_arr[]=array('pname'=>'余额明细','value'=>'18004');
			}
			if($this->check_qypurview('18005',0)){
				$sub_arr[]=array('pname'=>'增减余额','value'=>'18005');
			}
			if($this->check_qypurview('18006',0)){
				$sub_arr[]=array('pname'=>'提现记录','value'=>'18006');
			}
			if($this->check_qypurview('18007',0)){
				$sub_arr[]=array('pname'=>'充值记录','value'=>'18007');
			}
			
			$ids='';
			foreach($sub_arr as $kk=>$vv){ 
			    if($kk==0){
					$ids=$vv['value'];
				}else{
					$ids=$ids.','.$vv['value'];
				}
				if(isset($supurview_arr[$vv['value']])){
				    $sub_arr[$kk]['checked']='checked';
			    }
			}
            $purview_arr['18000']['ids']=$ids;
			
			$purview_arr['18000']['sub']=$sub_arr;
		}
		
		//代理积分
		if($this->check_qypurview('15000',0)){
		   $purview_arr['15000']=array('pname'=>'积分管理','value'=>'15000','sub'=>array());
			if(isset($supurview_arr['15000'])){
				$purview_arr['15000']['checked']='checked';
			}
			
		    $sub_arr=array();
		    if($this->check_qypurview('15001',0)){
				$sub_arr[]=array('pname'=>'积分明细','value'=>'15001');
			}
			
			if($this->check_qypurview('15002',0)){
				$sub_arr[]=array('pname'=>'兑换管理','value'=>'15002');
			}
			
			if($this->check_qypurview('15003',0)){
				$sub_arr[]=array('pname'=>'礼品管理','value'=>'15003');
			}
			
			if($this->check_qypurview('15004',0)){
				$sub_arr[]=array('pname'=>'手动积分','value'=>'15004');
			}
			
			$ids='';
			foreach($sub_arr as $kk=>$vv){ 
			    if($kk==0){
					$ids=$vv['value'];
				}else{
					$ids=$ids.','.$vv['value'];
				}
				
				if(isset($supurview_arr[$vv['value']])){
				    $sub_arr[$kk]['checked']='checked';
			    }
			}
            $purview_arr['15000']['ids']=$ids;
			
			$purview_arr['15000']['sub']=$sub_arr;
		}
		
		if($this->check_qypurview('70000',0)){
		   $purview_arr['70000']=array('pname'=>'前端设置','value'=>'70000','sub'=>array());
			if(isset($supurview_arr['70000'])){
				$purview_arr['70000']['checked']='checked';
			}
			
			
		    $sub_arr=array();
		    if($this->check_qypurview('70001',0)){
				$sub_arr[]=array('pname'=>'基本设置','value'=>'70001');
			}
			
			if($this->check_qypurview('70010',0)){
				$sub_arr[]=array('pname'=>'基本信息','value'=>'70010');
			}
			
			if($this->check_qypurview('70011',0)){
				$sub_arr[]=array('pname'=>'公司简介','value'=>'70011');
			}
			
			if($this->check_qypurview('70012',0)){
				$sub_arr[]=array('pname'=>'联系方式','value'=>'70012');
			}
			
			if($this->check_qypurview('70002',0)){
				$sub_arr[]=array('pname'=>'积分说明','value'=>'70002');
			}
			
			if($this->check_qypurview('70003',0)){
				$sub_arr[]=array('pname'=>'帮助中心','value'=>'70003');
			}
			
			if($this->check_qypurview('70004',0)){
				$sub_arr[]=array('pname'=>'注册协议','value'=>'70004');
			}
			
			if($this->check_qypurview('70005',0)){
				$sub_arr[]=array('pname'=>'产品展示','value'=>'70005');
			}
			
			if($this->check_qypurview('70008',0)){
				$sub_arr[]=array('pname'=>'产品分类','value'=>'70008');
			}
			
			if($this->check_qypurview('70006',0)){
				$sub_arr[]=array('pname'=>'企业动态','value'=>'70006');
			}
			
			if($this->check_qypurview('70007',0)){
				$sub_arr[]=array('pname'=>'图片管理','value'=>'70007');
			}
			
			if($this->check_qypurview('70009',0)){
				$sub_arr[]=array('pname'=>'留言反馈','value'=>'70009');
			}
			
			if($this->check_qypurview('70013',0)){
				$sub_arr[]=array('pname'=>'买家秀','value'=>'70013');
			}
			
			if($this->check_qypurview('70014',0)){
				$sub_arr[]=array('pname'=>'调查问卷','value'=>'70014');
			}
			
			if($this->check_qypurview('70015',0)){
				$sub_arr[]=array('pname'=>'招商政策','value'=>'70015');
			}
			
			if($this->check_qypurview('70018',0)){
				$sub_arr[]=array('pname'=>'海报设置','value'=>'70018');
			}
			if($this->check_qypurview('70017',0)){
				$sub_arr[]=array('pname'=>'LOGO设置','value'=>'70017');
			}
			if($this->check_qypurview('70019',0)){
				$sub_arr[]=array('pname'=>'底部图片','value'=>'70019');
			}
			
			if($this->check_qypurview('70020',0)){
				$sub_arr[]=array('pname'=>'图片素材','value'=>'70020');
			}
			
			//隐藏的
			if($this->check_qypurview('70016',0)){
				$hide_arr[]=array('pname'=>'','value'=>'70016');
			}
			
			$ids='';
			foreach($sub_arr as $kk=>$vv){ 
			    if($kk==0){
					$ids=$vv['value'];
				}else{
					$ids=$ids.','.$vv['value'];
				}
				
				if(isset($supurview_arr[$vv['value']])){
				    $sub_arr[$kk]['checked']='checked';
			    }
				
			}
            $purview_arr['70000']['ids']=$ids;
			
			$purview_arr['70000']['sub']=$sub_arr;
		}
		
		if($this->check_qypurview('80000',0)){
		   $purview_arr['80000']=array('pname'=>'查询','value'=>'80000','sub'=>array());
			if(isset($supurview_arr['80000'])){
				$purview_arr['80000']['checked']='checked';
			}
			
		    $sub_arr=array();
		    if($this->check_qypurview('80001',0)){
				$sub_arr[]=array('pname'=>'防窜货查询','value'=>'80001');
			}
			
			if($this->check_qypurview('80002',0)){
				$sub_arr[]=array('pname'=>'防伪码查询记录','value'=>'80002');
			}
			//隐藏的
			if($this->check_qypurview('80003',0)){
				$hide_arr[]=array('pname'=>'','value'=>'80003');
			}
			
			if($this->check_qypurview('80004',0)){
				$hide_arr[]=array('pname'=>'','value'=>'80004');
			}
			
			$ids='';
			foreach($sub_arr as $kk=>$vv){ 
			    if($kk==0){
					$ids=$vv['value'];
				}else{
					$ids=$ids.','.$vv['value'];
				}
				
				if(isset($supurview_arr[$vv['value']])){
				    $sub_arr[$kk]['checked']='checked';
			    }
				
			}
            $purview_arr['80000']['ids']=$ids;
			
			$purview_arr['80000']['sub']=$sub_arr;
		}
			
			
        }else{
            $this->error('没有该记录');
        }
		
		$this->assign('purview_arr', $purview_arr);
		$this->assign('hide_arr', $hide_arr);
        $this->assign('subuserinfo', $data);
        $this->assign('curr', 'subuser');
        $this->assign('mtitle', '修改子用户');

        $this->display('subuseradd');
    }
	
    //保存子用户  
    public function subuseradd_save(){
		$this->check_qypurview('17001',1);
		
    	if (!IS_POST) {
             header('HTTP/1.0 404 Not Found');
             echo'error:404';
             exit;
        }
        $map['su_id']=intval(I('post.su_id',''));
        
        if($map['su_id']>0){
            //修改保存
			$map['su_unitcode']=session('unitcode');
			
            $data['su_name']=I('post.su_name','');

            if(trim(I('post.su_pwd',''))!=''){
                $data['su_pwd']=MD5(MD5(MD5(trim(I('post.su_pwd','')))));
            }
			
			if($data['su_name']==''){
				$this->error('名称不能为空');
			}
			
            $subadmin_purview = I('post.subadmin_purview','');
			$subhide_purview = I('post.subhide_purview','');
			$admin_purview=array_merge($subadmin_purview, $subhide_purview);
			
			//检测移除不该有的权限
			foreach($admin_purview as $k=>$v){
                if(!$this->check_qypurview($v,0)){
                    unset($admin_purview[$k]);  
			    }
            }

            if(is_array($admin_purview) && count($admin_purview)>0){
                $subadmin_purview_str=implode(",", $admin_purview);
            }else{
                $subadmin_purview_str='';
            }
			
            $data['su_purview']=$subadmin_purview_str;

            $Qysubuser= M('Qysubuser');
            $rs=$Qysubuser->where($map)->data($data)->save();

            if($rs){
				//记录日志 begin
				$log_arr=array();
				$log_arr=array(
							'log_qyid'=>session('qyid'),
							'log_user'=>session('qyuser'),
							'log_qycode'=>session('unitcode'),
							'log_action'=>'修改子用户',
							'log_type'=>1, //0-系统 1-企业 2-经销商 3-消费者
							'log_addtime'=>time(),
							'log_ip'=>real_ip(),
							'log_link'=>__SELF__,
							'log_remark'=>json_encode($data)
							);
				save_log($log_arr);
				//记录日志 end
				$this->success('修改成功',U('Mp/Subuser/index'),1);
            }else{
                $this->error('修改失败','',1);
            }
        }else{  
            //添加保存
            $map=array();
            $map['su_username']=I('post.su_username','');
			
			if($map['su_username']==''){
				$this->error('用户名不能为空');
			}
			
            $Qysubuser= M('Qysubuser');
            $data2=$Qysubuser->where($map)->find();
            if($data2){
                $this->error('该用户名已存在');
            }
			
            $subadmin_purview = I('post.subadmin_purview','');
			$subhide_purview = I('post.subhide_purview','');
			$admin_purview=array_merge($subadmin_purview, $subhide_purview);
			
			//检测移除不该有的权限
			foreach($admin_purview as $k=>$v){
                if(!$this->check_qypurview($v,0)){
                     unset($admin_purview[$k]);  
			    }
            }

            if(is_array($admin_purview) && count($admin_purview)>0){
                $subadmin_purview_str=implode(",", $admin_purview);
            }else{
                $subadmin_purview_str='';
            }
			
            $data['su_purview']=$subadmin_purview_str;
            
			$data['su_unitcode']=session('unitcode');
            $data['su_username']=$map['su_username'];
            $data['su_pwd']=trim(I('post.su_pwd',''));
            $data['su_name']=I('post.su_name','');
            $data['su_belong']=0;   //子用户所属 0-公司 大于0-代理id
            $data['su_logintime']=0;
            $data['su_status']=1;
			
            if($data['su_pwd']==''){
				$this->error('密码不能为空');
			}
			if($data['su_name']==''){
				$this->error('名称不能为空');
			}
			
            if(!preg_match("/[a-zA-Z0-9_]{4,20}$/",$data['su_username'])){
                $this->error('用户名由 A--Z,a--z,0--9,_ 组成,4-20位','',4);
            }
            $data['su_pwd']=MD5(MD5(MD5($data['su_pwd'])));
			
            $rs=$Qysubuser->create($data,1);
            if($rs){
               $result = $Qysubuser->add(); 
               if($result){
                        //记录日志 begin
                        $log_arr=array();
                        $log_arr=array(
                                    'log_qyid'=>session('qyid'),
                                    'log_user'=>session('qyuser'),
                                    'log_qycode'=>session('unitcode'),
                                    'log_action'=>'添加子用户',
									'log_type'=>1, //0-系统 1-企业 2-经销商 3-消费者
                                    'log_addtime'=>time(),
                                    'log_ip'=>real_ip(),
                                    'log_link'=>__SELF__,
                                    'log_remark'=>json_encode($data)
                                    );
                        save_log($log_arr);
                        //记录日志 end
                   $this->success('添加成功',U('Mp/Subuser/index'),1);
               }else{
                   $this->error('添加失败','',2);
               }
            }else{
                $this->error('添加失败','',2);
            }
        }
    }

    //审核子用户   
    public function suactive(){
        $this->check_qypurview('17001',1);

        $map['su_id']=intval(I('get.su_id',0));
        $map['su_unitcode']=session('unitcode');

        $Qysubuser= M('Qysubuser');
        $data=$Qysubuser->where($map)->find();
        if($data){
            $active=intval(I('get.su_status',0));

            if($active==1){
                $data2['su_status'] = 0;
            }else{
                $data2['su_status'] = 1;
            }
            
            $Qysubuser->where($map)->save($data2);
            $this->success('激活/禁用成功','',1);
        }else{
            $this->error('没有该记录');
        }
    }	
   
   //删除子用户  
    public function sudelete(){
        $this->check_qypurview('17001',1);

        $map['su_id']=intval(I('get.su_id',0));
        $map['su_unitcode']=session('unitcode');

        $Qysubuser= M('Qysubuser');
        $data=$Qysubuser->where($map)->find();

        if($data){
            $Qysubuser->where($map)->delete(); 

            //记录日志 begin
            $log_arr=array(
                        'log_qyid'=>session('qyid'),
                        'log_user'=>session('qyuser'),
                        'log_qycode'=>session('unitcode'),
                        'log_action'=>'删除子用户',
                        'log_type'=>1, //0-系统 1-企业 2-经销商 3-消费者
						'log_addtime'=>time(),
                        'log_ip'=>real_ip(),
                        'log_link'=>__SELF__,
                        'log_remark'=>json_encode($data)
                        );
            save_log($log_arr);
            //记录日志 end

            $this->success('删除成功','',2);
        }else{
            $this->error('没有该记录','',2);
        }     
    }

}