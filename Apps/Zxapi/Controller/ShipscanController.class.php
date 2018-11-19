<?php
namespace Zxapi\Controller;
use Think\Controller;
class ShipscanController extends CommController {
    //APP调用接口 检测扫描数据 返回json格式
    public function index(){
        $brcode=trim(I('post.brcode',''));
        if($brcode==''){
			$msg=array('login'=>'1','stat'=>'0','msg'=>'条码为空');
			echo json_encode($msg);
			exit;
		}
        if(!preg_match("/^[a-zA-Z0-9]{4,30}$/",$brcode)){
			$msg=array('login'=>'1','stat'=>'0','msg'=>'条码信息不正确');
			echo json_encode($msg);
			exit;
        }

		$map=array();
		$data=array();
		$Shipment= M('Shipment');
		$Chaibox= M('Chaibox');
        $barcode=array();

		//检测该条码是否已录入
		$map['ship_unitcode']=$this->qycode;
		$map['ship_deliver']=0;   //ship_deliver--出货方   ship_dealer--收货方
		$map['ship_barcode'] = $brcode;
		$data=$Shipment->where($map)->find();
		if(is_not_null($data)){
            $msg='条码 '.$brcode.' 已存在';
			goto gotoEND;
			exit;
        }
		
        //检测是否已发行
        $barcode=wlcode_to_packinfo($brcode,$this->qycode);
        if(!is_not_null($barcode)){
            $msg='条码 '.$brcode.' 不存在或还没发行';
			goto gotoEND;
			exit;
        }
		
        //是否已已录入
        $map=array();
        $where=array();
		
		if($barcode['code']!=''){
			$where[]=array('EQ',$barcode['code']);
		}
		if($barcode['tcode']!='' && $barcode['ucode']!=$barcode['tcode']){
			$where[]=array('EQ',$barcode['tcode']);
		}
		if($barcode['ucode']!='' &&  $barcode['ucode']!=$barcode['tcode']){
			$where[]=array('EQ',$barcode['ucode']);
		}
		if($barcode['ucode']!='' &&  $barcode['ucode']==$barcode['tcode']){
			$where[]=array('EQ',$barcode['ucode']);
		}
		
        $where[]='or';
        $map['ship_barcode'] = $where;
        $map['ship_unitcode']=$this->qycode;
        $map['ship_deliver']=0; //ship_deliver--出货方   ship_dealer--收货方
        $data=$Shipment->where($map)->find();
        if(is_not_null($data)){
            $msg='条码 '.$brcode.' 已存在';
			$barcode=array();
			goto gotoEND;
			exit;
        }

        $Storage= M('Storage');	
        $map2=array();
		$map2['stor_unitcode']=$this->qycode;
		$map2['stor_barcode'] = $where;
		$dataStro=$Storage->where($map2)->find();
        if(!is_not_null($dataStro)){
        	$msg='条码 '.$brcode.'还没入库，请先入库';
			$barcode=array();
			goto gotoEND;
			exit;
        }

        //检测是否拆箱
		$map2=array();
        $map2['chai_unitcode']=$this->qycode;
        $map2['chai_barcode'] = $brcode;
        $map2['chai_deliver'] = 0;
        $data2=$Chaibox->where($map2)->find();

        if(is_not_null($data2)){
			$msg='条码 '.$brcode.' 已经拆箱录入';
			$barcode=array();
			goto gotoEND;
			exit;
        }
		if(is_not_null($barcode)){
			
			$msg=array('login'=>'1','stat'=>'1','brcode'=>$barcode['code'],'tcode'=>$barcode['tcode'],'ucode'=>$barcode['ucode'],'qty'=>$barcode['qty']);
			echo json_encode($msg);
			exit;
		}else{
			$msg='条码 '.$brcode.' 不存在或还没发行';
			goto gotoEND;
			exit;
		}
		
		/////////////
		gotoEND:
		
		$msg=array('login'=>'1','stat'=>'0','msg'=>$msg);
		echo json_encode($msg);
		exit;	
   }
	
	//获取仓库
	public function getwarehouse(){
		$map=array();
		$map['wh_unitcode']=$this->qycode;
		$Warehouse = M('Warehouse');
		$list = $Warehouse->where($map)->order('wh_id ASC')->select();
		$warehouselist=array();
		foreach($list as $k=>$v){ 
		   $warehouselist[$k]['value']=$v['wh_id'];
		   $warehouselist[$k]['text']=$v['wh_name'];
		}
		$msg=array('login'=>'1','stat'=>'1','list'=>$warehouselist);
		echo json_encode($msg);
		exit;
	}
	
	//获取经销商分类
	public function getdealertype(){
		$map=array();
		$map['dlt_unitcode']=$this->qycode;
		$Dltype = M('Dltype');
		$list = $Dltype->where($map)->order('dlt_id ASC')->limit(200)->select();

		$typelist=array();
		foreach($list as $k=>$v){ 
		   $typelist[$k]['value']=$v['dlt_id'];
		   $typelist[$k]['text']=$v['dlt_name'];
		}
		$msg=array('login'=>'1','stat'=>'1','list'=>$typelist);
		echo json_encode($msg);
		exit;
	}
	
	//获取经销商
	public function getdealer(){
        $typeid=intval(I('post.typeid',0));
		
		$map=array();
		$map['dl_unitcode']=$this->qycode;
		$map['dl_belong']=0;
		$map['dl_status']=1;
		
        if($typeid>0){
           $map['dl_type']=$typeid;
		}
		
		$Dealer = M('Dealer');
		$list = $Dealer->where($map)->order('dl_id DESC')->limit(1000)->select();

		$dealerlist=array();
		foreach($list as $k=>$v){ 
		   $dealerlist[$k]['value']=$v['dl_id'];
		   $dealerlist[$k]['text']=$v['dl_name'].' '.$v['dl_number'];
		}
		$msg=array('login'=>'1','stat'=>'1','list'=>$dealerlist);
		echo json_encode($msg);
		exit;
	}	
	
	//获取产品分类
	public function getprotype(){
		$map=array();
		$map['protype_unitcode']=$this->qycode;
		
		$Protype = M('Protype');
		$list = $Protype->where($map)->order('protype_id DESC')->limit(200)->select();

		$typelist=array();
		foreach($list as $k=>$v){ 
		   $typelist[$k]['value']=$v['protype_id'];
		   $typelist[$k]['text']=$v['protype_name'];
		}
		$msg=array('login'=>'1','stat'=>'1','list'=>$typelist);
		echo json_encode($msg);
		exit;
	}
	
	
	//获取产品
	public function getproduct(){
		$typeid=intval(I('post.typeid',0));
		
		$map=array();
		$map['pro_unitcode']=$this->qycode;
		$map['pro_active'] = 1;
		
        if($typeid>0){
            $son_type_id=get_son_type_id($typeid);
            if(strpos($son_type_id,',')>0){
               $map['pro_typeid']=array('IN',explode(',',$son_type_id));
            }else{
               $map['pro_typeid']=$typeid;
            }
		}
		
		$Product = M('Product');
		$list = $Product->where($map)->order('pro_number ASC')->select();

		$productlist=array();
		foreach($list as $k=>$v){ 
		   $productlist[$k]['value']=$v['pro_id'];
		   $productlist[$k]['text']=$v['pro_name'].' '.$v['pro_number'];
		}
		$msg=array('login'=>'1','stat'=>'1','list'=>$productlist);
		echo json_encode($msg);
		exit;
	}
	
	
	//确认出货
	public function shiping(){
        $brcodestr=trim(I('post.brcodestr',''));
		$shipnumber=trim(I('post.shipnumber',''));
		$shipdate=trim(I('post.shipdate',''));
		$shipwhid=intval(I('post.shipwhid',0));
		$dealerid=intval(I('post.dealerid',0));
		$proid=intval(I('post.proid',0));
		$remark=trim(I('post.remark',''));
        if($brcodestr==''){
			$msg=array('login'=>'1','stat'=>'0','msg'=>'扫描记录为空，请扫描条码');
			echo json_encode($msg);
			exit;
		}
		
        if($shipnumber=='' || $shipdate=='' || $shipwhid==0 || $dealerid==0 || $proid==0 ){
			$msg=array('login'=>'1','stat'=>'0','msg'=>'请完善出货信息');
			echo json_encode($msg);
			exit;
		}

		$Dealer= M('Dealer');
		$map=array();
		$map['dl_unitcode']=$this->qycode;
		$map['dl_id']=$dealerid;
		$data=$Dealer->where($map)->find();
		if(!$data){
			$msg=array('login'=>'1','stat'=>'0','msg'=>'出货经销商不存在');
			echo json_encode($msg);
			exit;
		}
		
		$Warehouse= M('Warehouse');
		$map=array();
		$map['wh_unitcode']=$this->qycode;
		$map['wh_id']=$shipwhid;
		$data=$Warehouse->where($map)->find();
		if(!$data){
			$msg=array('login'=>'1','stat'=>'0','msg'=>'出货仓库不存在');
			echo json_encode($msg);
			exit;
		}
		
		$Product= M('Product');
		$map=array();
		$map['pro_unitcode']=$this->qycode;
		$map['pro_id']=$proid;
		$data=$Product->where($map)->find();
		if(!$data){
			$msg=array('login'=>'1','stat'=>'0','msg'=>'出货产品不存在');
			echo json_encode($msg);
			exit;
		}
		$brcodearr=array();
		$brcarr=array();
		
		$brcodearr=explode('|',$brcodestr);
		
		$Storage= M('Storage');
		$Shipment= M('Shipment');
		$Chaibox= M('Chaibox');
		$ship_time=time();
		$shipok=0;
		$shipfail=0;
		
		foreach($brcodearr as $key=>$v){ 
            if($v!=''){
				$brcode=$v;
				if(!preg_match("/^[a-zA-Z0-9]{4,20}$/",$brcode)){
					$brcarr[$key]['barcode']=$brcode;
					$brcarr[$key]['msg']='条码 '.htmlspecialchars($brcode).' 应由数字字母组成';
					$brcarr[$key]['ok']=0;
					$shipfail=$shipfail+1;
					continue;
				}
							
				//检测该条码是否已被使用
				$map2=array();
				$data2=array();
				$map2['ship_unitcode']=$this->qycode;
				$map2['ship_barcode'] = $brcode;
				$map2['ship_deliver']=0;
						
				$data2=$Shipment->where($map2)->find();
				if($data2){
					$brcarr[$key]['barcode']=$brcode;
					$brcarr[$key]['msg']='条码 '.$brcode.' 已使用';
					$brcarr[$key]['ok']=0;
					$shipfail=$shipfail+1;
					continue;
				}
					
				//检测是否已发行
				$barcode=wlcode_to_packinfo($brcode,$this->qycode);
						
				if(!is_not_null($barcode)){
					$brcarr[$key]['barcode']=$brcode;
					$brcarr[$key]['msg']='条码 '.$brcode.' 不存在或还没发行';
					$brcarr[$key]['ok']=0;
					$shipfail=$shipfail+1;
					continue;
				}
							
				//检测该条码 大标 是否已被使用
				$map2=array();
				$where2=array();
				$data2=array();
				if($barcode['code']!=''){
					$where2[]=array('EQ',$barcode['code']);
				}
				if($barcode['tcode']!='' && $barcode['ucode']!=$barcode['tcode']){
					$where2[]=array('EQ',$barcode['tcode']);
				}
				if($barcode['ucode']!='' &&  $barcode['ucode']!=$barcode['tcode']){
					$where2[]=array('EQ',$barcode['ucode']);
				}
				if($barcode['ucode']!='' &&  $barcode['ucode']==$barcode['tcode']){
					$where2[]=array('EQ',$barcode['ucode']);
				}
				
				$where2[]='or';
				$map2['ship_barcode'] = $where2;
				$map2['ship_unitcode']=$this->qycode;
				$map2['ship_deliver']=0;   //ship_deliver--出货方   ship_dealer--收货方
				$data2=$Shipment->where($map2)->find();
				if($data2){
					$brcarr[$key]['barcode']=$brcode;
					$brcarr[$key]['msg']='条码 '.$brcode.' 已使用';
					$brcarr[$key]['ok']=0;
					$shipfail=$shipfail+1;
					continue;
				}
					
				$map2=array();
				$map2['stor_unitcode']=$this->qycode;
				$map2['stor_barcode'] = $where2;
				$dataStro=$Storage->where($map2)->find();
        		if(!is_not_null($dataStro)){
        			$brcarr[$key]['barcode']=$brcode;
					$brcarr[$key]['msg']='条码 '.$brcode.' 还没入库，请先入库';
					$brcarr[$key]['ok']=0;
					$shipfail=$shipfail+1;
					continue;
        		}
					
				//检测是否拆箱
				$map2=array();
				$data2=array();
				$map2['chai_unitcode']=$this->qycode;
				$map2['chai_barcode'] = $brcode;
				$map2['chai_deliver'] = 0;
				$data2=$Chaibox->where($map2)->find();
				if($data2){
					$brcarr[$key]['barcode']=$brcode;
					$brcarr[$key]['msg']='条码 '.$brcode.' 已经拆箱</span>';
					$brcarr[$key]['ok']=0;
					$shipfail=$shipfail+1;
					continue;
				}
					
				//保存记录
				if(is_not_null($barcode)){
					$insert=array();
					$insert['ship_unitcode']=$this->qycode;
					$insert['ship_number']=$shipnumber;
					$insert['ship_deliver']=0;
					$insert['ship_dealer']=$dealerid;   //ship_dealer--收货方
					$insert['ship_pro']=$proid;
					$insert['ship_whid']=$shipwhid;
					$insert['ship_proqty']=$barcode['qty'];
					$insert['ship_barcode']=$brcode;
					$insert['ship_date']=strtotime($shipdate);
					$insert['ship_ucode']=$barcode['ucode'];
					$insert['ship_tcode']=$barcode['tcode'];
					$insert['ship_remark']=$remark;
					$insert['ship_cztype']=1;//操作类型 0-企业主账户  1-企业子管理用户  2-经销商
					$insert['ship_czid']=$this->subuserid;
					$insert['ship_czuser']=$this->subusername;
					
					$rs=$Shipment->create($insert,1);
					if($rs){
					   $result = $Shipment->add(); 
					   if($result){
							//记录拆箱
							if($barcode['tcode']!='' && $barcode['tcode']!=$barcode['ucode']){
								$insert2=array();
								$data3=array();
								$insert2['chai_unitcode']=$this->qycode;
								$insert2['chai_barcode']=$barcode['tcode'];
								$insert2['chai_deliver']=0;
								$data3=$Chaibox->where($insert2)->find();
								if(!$data3){
									$insert2['chai_addtime']=$ship_time;
									$Chaibox->create($insert2,1);
									$Chaibox->add(); 
								}
							}
							if($barcode['ucode']!='' && $barcode['tcode']!=$barcode['ucode']){
								$insert2=array();
								$data3=array();
								$insert2['chai_unitcode']=$this->qycode;
								$insert2['chai_barcode']=$barcode['ucode'];
								$insert2['chai_deliver']=0;
								$data3=$Chaibox->where($insert2)->find();
								if(!$data3){
									$insert2['chai_addtime']=$ship_time;
									$Chaibox->create($insert2,1);
									$Chaibox->add(); 
								}
							}
							if($barcode['ucode']!='' && $barcode['ucode']==$barcode['tcode']){
								$insert3=array();
								$data4=array();
								$insert3['chai_unitcode']=$this->qycode;
								$insert3['chai_barcode']=$barcode['ucode'];
								$insert3['chai_deliver']=0;
								$data4=$Chaibox->where($insert3)->find();
								if(!$data4){
									$insert3['chai_addtime']=$ship_time;
									$Chaibox->create($insert3,1);
									$Chaibox->add(); 
								}
							}

							$brcarr[$key]['barcode']=$brcode;
							$brcarr[$key]['msg']='条码 '.$brcode.' 添加成功。';
							$brcarr[$key]['ok']=1;
					        $shipok=$shipok+1;
							continue;
						}else{
							$brcarr[$key]['barcode']=$brcode;
							$brcarr[$key]['msg']='条码 '.$brcode.' 添加失败。';
							$brcarr[$key]['ok']=0;
					        $shipfail=$shipfail+1;
							continue;
						}
					}else{
						$brcarr[$key]['barcode']=$brcode;
						$brcarr[$key]['msg']='条码 '.$brcode.' 添加失败。';
						$brcarr[$key]['ok']=0;
						$shipfail=$shipfail+1;
						continue;
					}	
				}else{
					$brcarr[$key]['barcode']=$brcode;
					$brcarr[$key]['msg']='条码 '.$brcode.' 添加失败。';
					$brcarr[$key]['ok']=0;
					$shipfail=$shipfail+1;
					continue;
				}
			}
		}
		
		$brcarr2=$brcarr;
		$brcarr2[]['msg']=$shipnumber.'|'.$shipdate.'|'.$dealerid.'|'.$proid.'|'.$shipwhid;
		//记录日志 begin
		$log_arr=array();
		$log_arr=array(
					'log_qyid'=>$this->subuserid,
					'log_user'=>$this->subusername,
					'log_qycode'=>$this->qycode,
					'log_action'=>'企业APP子用户出货',
					'log_type'=>1, //0-系统 1-企业 2-经销商 3-消费者
					'log_addtime'=>time(),
					'log_ip'=>real_ip(),
					'log_link'=>__SELF__,
					'log_remark'=>json_encode($brcarr2)
					);
		save_log($log_arr);
		//记录日志 end
		
		$msg=array('login'=>'1','stat'=>'1','list'=>$brcarr,'shipfail'=>$shipfail,'shipok'=>$shipok);
		echo json_encode($msg);
		exit;	
	}
}