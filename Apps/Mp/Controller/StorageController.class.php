<?php
namespace Mp\Controller;
use Think\Controller;
//出货管理
class StorageController extends CommController {
	//入库列表
    public function index(){
        $this->check_qypurview('30001',1);   
		$pro_id=intval(I('param.proid',0));
		$czid=intval(I('param.czid',0));
		$begintime=I('param.begintime','');
        $endtime=I('param.endtime','');
        $keyword=trim(strip_tags(htmlspecialchars_decode(I('param.keyword',''))));
		$parameter=array();
		
        if($pro_id>0){
            $map['stor_pro']=$pro_id;
			$parameter['proid']=$pro_id;
        }
		if($czid>0){
            $map['stor_czid']=$czid;
			$parameter['czid']=$czid;
        }
		
        if($keyword!=''){
            $keyword=str_replace('[','',$keyword);
            $keyword=str_replace(']','',$keyword);
            $keyword=str_replace('%','',$keyword);
            $keyword=str_replace('_','',$keyword);

            $keyword=sub_str($keyword,20,false);
            $where['stor_number']=array('LIKE', '%'.$keyword.'%');
            $where['stor_barcode']=array('LIKE', '%'.$keyword.'%');
            $where['_logic'] = 'or';
            $map['_complex'] = $where;
			$parameter['keyword']=$keyword;
        }
		
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
			
			$map['stor_date']=array('between',array($begintime,$endtime));
			
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
		
        $map['stor_unitcode']=session('unitcode');
        // $map['stor_deliver']=0;
        $Storage = M('Storage');
        $count = $Storage->where($map)->count();
        $Page = new \Think\Page($count, C('PAGE_SIZE'),$parameter);
        $show = $Page->show();
        $list = $Storage->where($map)->order('stor_date DESC,stor_id DESC')->limit(($Page->firstRow . ',') . $Page->listRows)->select();
        $Product = M('Product');
        $Dealer = M('Dealer');
		$Warehouse = M('Warehouse');
        foreach($list as $k=>$v){ 
            $map2=array();
            $map2['pro_unitcode']=session('unitcode');
            $map2['pro_id'] = $v['stor_pro'];
            $Proinfo = $Product->where($map2)->find();

            if($Proinfo){
                  $list[$k]['pro_name']=$Proinfo['pro_name'];
                  $list[$k]['pro_number']=$Proinfo['pro_number'];
            }else{
                  $list[$k]['pro_name']='-';
                  $list[$k]['pro_number']='-';
            }
            $map2=array();
            $map2['dl_unitcode']=session('unitcode');
            $map2['dl_id'] = $v['stor_dealer'];
            $Dealerinfo = $Dealer->where($map2)->find();
            if($Dealerinfo){
                $list[$k]['dl_name']=$Dealerinfo['dl_name'].'('.$Dealerinfo['dl_username'].')';
            }else{
                $list[$k]['dl_name']='-';
            }
			
            $map2=array();
            $map2['wh_unitcode']=session('unitcode');
            $map2['wh_id'] = $v['stor_whid'];
            $warehouse = $Warehouse->where($map2)->find();

            if($warehouse){
                  $list[$k]['warehouse']=$warehouse['wh_name'];
            }else{
                  $list[$k]['warehouse']='-';
            }			
        }

		//操作员列表
		$map2=array();
        $map2['stor_unitcode']=session('unitcode');
        $list2 =$Storage->where($map2)->field('stor_czid,stor_czuser')->group('stor_czid,stor_czuser')->select();
        $this->assign('czuserlist', $list2);
		$this->assign('stor_czid',$czid);
		
        //产品列表
		$map2=array();
        $map2['pro_unitcode']=session('unitcode');
        $map2['pro_active'] = 1;
        $list2 = $Product->where($map2)->order('pro_number ASC')->select();
        $this->assign('productlist', $list2);
		$this->assign('pro_id', $pro_id);
        $this->assign('keyword', $keyword);
        $this->assign('list', $list);
        $this->assign('page', $show);
        $this->assign('curr', 'storage_list');
        $this->display('storagelist');
    }
    
	//出货扫描
    public function add(){
        $this->check_qypurview('13001',1);

		//产品
        $map2['pro_unitcode']=session('unitcode');
        $map2['pro_active'] = 1;
        $Product = M('Product');
        $list2 = $Product->field('pro_id,pro_name')->where($map2)->order('pro_number ASC')->select();
//        dump(json_encode($list2));die();
        // $this->assign('productlist', $list2);
        $this->assign('productlist',json_encode($list2));
       
		//仓库
		$map2=array();
        $map2['wh_unitcode']=session('unitcode');
        $Warehouse = M('Warehouse');
        $list3 = $Warehouse->where($map2)->order('wh_id ASC')->select();
        $this->assign('warehouselist', $list3);
		//获取产品颜色尺码
		$proattrlist=array();
		$levelattr=1;
		$mapyf=array();
		$mapyf['attr_unitcode']=session('unitcode');
		$Yifuattr = M('Yifuattr');
		$proidArry=$Yifuattr->where($mapyf)->field('attr_proid')->group('attr_proid')->select();
		if ($proidArry)
		{
			foreach ($proidArry as $k => $v) {
				$mapyf['attr_proid']=$v['attr_proid'];
				$proidcolorArry = $Yifuattr->where($mapyf)->field('attr_color')->group('attr_color')->select();
				$proattrArry=array();
				if ($proidcolorArry){
					$prokey=$v['attr_proid'];
					foreach ($proidcolorArry as $kk => $vv) {
						$mapyfs['attr_unitcode']=session('unitcode');
						$mapyfs['attr_proid']=$v['attr_proid'];
						$mapyfs['attr_color']=$vv['attr_color'];
						$Yifuattrs= M('Yifuattr');
						$alldata = $Yifuattrs->where($mapyfs)->order('attr_id ASC')->select();
						// var_dump($alldata);
						if ($alldata){
							$prosizelist=array();
							$levelattr=2;
							foreach($alldata as $kkk=>$vvv){ 
		   						$prosizelist[$kkk]['value']=$vvv['attr_id'];
		   						$prosizelist[$kkk]['text']=$vvv['attr_size'];
							}
							$proattrArry[$kk]['value']=$prokey;
		   					$proattrArry[$kk]['text']=$vv['attr_color'];
		   					$proattrArry[$kk]['children']=$prosizelist;
						}
					}
					$proattrlist[$k][$prokey]=$proattrArry;
				}
			}
		}
		// var_dump($proattrlist);
		$data['proattrlist']=json_encode($proattrlist); //转为json方便javascript接收
		$data['stor_datestr']='';
		$data['stor_id']=0;
        $this->assign('storageinfo', $data);
		$this->assign('mtitle', '添加入库');
        $this->assign('curr', 'storage_add');
        $this->display('add');
    }
   
	//修改出货扫描
    public function edit(){
        $this->check_qypurview('30005',1);
        $map['stor_id']=intval(I('get.stor_id',0));
        $map['stor_unitcode']=session('unitcode');
        $Shipment= M('Shipment');
        $Chaibox= M('Chaibox');
		$data=$Shipment->where($map)->find();
		if($data){
		    //在还没有向下级出货时可以修改
            $map2=array();
            $map2['stor_unitcode']=session('unitcode');
            $map2['stor_deliver']=array('gt',0);
            $map2['stor_id'] = array('NEQ',$data['stor_id']);
            $where=array();
            $where['stor_barcode']=array('EQ',$data['stor_barcode']);
            $where['stor_tcode']=array('EQ',$data['stor_barcode']);
            $where['stor_ucode']=array('EQ',$data['stor_barcode']);
            $where['_logic'] = 'or';
            $map2['_complex'] = $where;
            $data2=$Shipment->where($map2)->find();
            if($data2){
               $this->error('该出货记录已被下级经销商重新出货，不能修改','',3);
            }
			$map2=array();
			$map2['dl_unitcode']=session('unitcode');
			$map2['dl_status'] = 1;
			$map2['dl_belong'] = 0;
			$Dealer = M('Dealer');
			$list = $Dealer->where($map2)->order('dl_number ASC')->select();
			foreach($list as $k=>$v){	
				//直接下线数
				$map3=array();
				$map3['dl_belong']=$v['dl_id'];
				$map3['dl_unitcode']=session('unitcode');
				$count3 = $Dealer->where($map3)->count();
				$list[$k]['dl_subcount']=$count3;
				$list[$k]['dl_wxnickname']=wxuserTextDecode2($v['dl_wxnickname']);
			}
			$this->assign('dealerlist', $list);
			
			//产品
			$map2=array();
			$map2['pro_unitcode']=session('unitcode');
			$map2['pro_active'] = 1;
			$Product = M('Product');
			$list2 = $Product->where($map2)->order('pro_number ASC')->select();
			$this->assign('productlist', $list2);
			
			//仓库
			$map2=array();
			$map2['wh_unitcode']=session('unitcode');
			$Warehouse = M('Warehouse');
			$list3 = $Warehouse->where($map2)->order('wh_id ASC')->select();
			$this->assign('warehouselist', $list3);
			
			//原经销商
            $map2=array();
            $map2['dl_unitcode']=session('unitcode');
            $map2['dl_id'] = $data['stor_dealer'];
            $Dealerinfo = $Dealer->where($map2)->find();
            if($Dealerinfo){
                $data['old_dl_name']=$Dealerinfo['dl_contact'].'('.$Dealerinfo['dl_name'].')';
            }else{
                $data['old_dl_name']='';
            }
			
			$data['stor_datestr']=date('Y-m-d',$data['stor_date']);
			$this->assign('shipmentinfo', $data);
			
		}else{
			$this->error('没有该记录','',2);
		}
	
        $this->assign('mtitle', '修改出货');
		$this->assign('action', 'update');
        $this->assign('curr', 'shipment_list');

        $this->display('add');
    }
      
	//返回下级经销商数组 json方式
    public function subdealerarr(){
        $this->check_qypurview('30002',1);
        
		$dl_id=intval(I('post.dl_id',0));
		if($dl_id>0){
			$map['dl_unitcode']=session('unitcode');
			$map['dl_status'] = 1;
			$map['dl_belong'] = $dl_id;
			$Dealer = M('Dealer');
			$list = $Dealer->where($map)->order('dl_number ASC')->select();
			$arr=array();
			foreach($list as $k=>$v){	
				//直接下线数
				$map3=array();
				$map3['dl_belong']=$v['dl_id'];
				$map3['dl_unitcode']=session('unitcode');
				$count3 = $Dealer->where($map3)->count();
				$list[$k]['dl_subcount']=$count3;
				$list[$k]['dl_wxnickname']=wxuserTextDecode2($v['dl_wxnickname']);
				
				$arr[$k]['dl_id']=$v['dl_id'];
				$arr[$k]['dl_number']=$v['dl_number'];
				$arr[$k]['dl_name']=$v['dl_name'];
				$arr[$k]['dl_contact']=$v['dl_contact'];
				$arr[$k]['dl_subcount']=$count3;
				$arr[$k]['dl_wxnickname']=wxuserTextDecode2($v['dl_wxnickname']);
			}
			
			echo json_encode($arr);
			exit;
		}else{
			$arr=array();
			echo json_encode($arr);
			exit;
		}
    }
   
   //保存入库扫描
    public function add_save(){
        if (!IS_POST) {
             header('HTTP/1.0 404 Not Found');
             echo'error:404';
             exit;
        }
		$map['stor_id']=intval(I('post.stor_id',0));	
		if($map['stor_id']>0){
			$this->check_qypurview('13001',1);
			$map['stor_unitcode']=session('unitcode');
			$Storage= M('Storage');
			$data=$Storage->where($map)->find();
			if($data){
				$stor_number=I('post.stor_number','');
				$stor_pro=intval(I('post.stor_pro',0));
				$stor_remark=I('post.stor_remark','');
				$stor_whid=intval(I('post.stor_whid',0));
				
				$stor_date=strtotime($stor_date);
				if($stor_number==''){
					$this->error('请填写入库单号','',2);
				}
				if($stor_dealer3>0){
					$stor_dealer=$stor_dealer3;
				}else if($stor_dealer2>0){
					$stor_dealer=$stor_dealer2;
				}
				if($stor_pro<=0){
					$this->error('请选择入库产品','',2);
				}
				if($stor_whid<=0){
					$this->error('请选择入库仓库','',2);
				}
				
				//保存入存记录
				$insert=array();
				$insert['stor_unitcode']=session('unitcode');
				$insert['stor_number']=$stor_number;
				$insert['stor_pro']=$stor_pro;
				$insert['stor_attrid']=$stor_attrid;
				$insert['stor_color']=$stor_attrcolor;
				$insert['stor_size']=$stor_attrsize;
				$insert['stor_whid']=$stor_whid;
				$insert['stor_proqty']=$barcode['qty'];
				$insert['stor_barcode']=$stor_barcode;
				$insert['stor_date']=$stor_time;
				$insert['stor_ucode']=$barcode['ucode'];
				$insert['stor_tcode']=$barcode['tcode'];
				$insert['stor_remark']=$stor_remark;
				$insert['stor_cztype']=1;//操作类型 0-企业主账户  1-企业子管理用户  2-经销商
				$insert['stor_czid']=session('qyid');
				$insert['stor_czuser']=session('qyuser');
				$insert['stor_prodate']=$stor_prodate;
				$insert['stor_batchnum']=$stor_batchnum;
				$insert['stor_isship']=0;
				
				$rs=$Storage->where($map)->data($insert)->save();
				
				if($rs){
					//记录日志 begin
                    $log_arr=array(
						'log_qyid'=>session('qyid'),
						'log_user'=>session('qyuser'),
						'log_qycode'=>session('unitcode'),
						'log_action'=>'修改入库',
						'log_type'=>1, //0-系统 1-企业 2-经销商 3-消费者
						'log_addtime'=>time(),
						'log_ip'=>real_ip(),
						'log_link'=>__SELF__,
						'log_remark'=>json_encode($insert)
						);
					save_log($log_arr);
					//记录日志 end

					$this->success('修改成功',U('Mp/Storage/index'),1);
				}elseif($rs===0){
					$this->success('修改成功',U('Mp/Storage/index'),1);
				}else{
					$this->error('修改失败','',1);
				}
			}else{
				$this->error('没有该记录','',2);
			}
		}else{
			$this->check_qypurview('13001',1);		
			$stor_number=I('post.stor_number','');//入库单号
			$stor_pro=intval(I('post.stor_pro',0));//入库产品
			$stor_barcode=I('post.stor_barcode','');//条码扫描
			$stor_remark=I('post.stor_remark','');//备注
			$stor_whid=intval(I('post.stor_whid',0));//仓库
			$stor_attrid=intval(I('post.stor_size',0));
			$stor_attrcolor=I('post.pro_attrcolor',0);
			$stor_attrsize=I('post.pro_attrsize',0);
			$stor_prodate=I('post.stor_prodate',0);
			$stor_batchnum=I('post.stor_batchnum',0);
			$stor_time=time();
			$stor_date=strtotime($stor_date);
			if($stor_number==''){
				$this->error('请填写入库单号','',2);
			}
			if($stor_pro<=0){
				$this->error('请选择入库产品','',2);
			}
			if($stor_whid<=0){
				$this->error('请选择入库仓库','',2);
			}
			// if($stor_attrid<=0){
			// 	$this->error('请选择颜色尺码','',2);
			// }
			if($stor_barcode==''){
				$this->error('请扫描或填写条码','',2);
			}
			if(!preg_match("/^[a-zA-Z0-9]{4,30}$/",$stor_barcode)){
				$this->error('条码由数字字母组成','',2);
			}
			$map=array();
			$data=array();
			$Storchaibox= M('Storchaibox');
			$Storage= M('Storage');
       	 	$barcode=array();
			//检测该条码是否已录入
			$map['stor_unitcode']=session('unitcode');
			$map['stor_barcode'] = $stor_barcode;
			$data=$Storage->where($map)->find();
			if(is_not_null($data)){
				$this->error('条码<b>'.$stor_barcode.'</b>已录入','',2);
        	}
			//检测是否已发行
        	$barcode=wlcode_to_packinfo($stor_barcode,session('unitcode'));
//			dump($barcode);die();
//            array(7) {
//                ["code"] => string(10) "160000010403"
//                ["ucode"] => string(8) "16000001" 大标
//                ["tcode"] => string(8) "1600000104"中标
//                ["qty"] => string(2) "10"
//                ["snk"] => int(1)
//                ["sellrecordid"] => string(4) "2666"
//                ["unitcode"] => string(4) "9999"
//                fw_swllrecord为条码表
//}
        	if(!is_not_null($barcode)){
            	$this->error('条码<b>'.$stor_barcode.'不存在或还没发行','',2);
        	}
        	//是否已入库 ucode-大标  	tcode-中标 
       		$map=array();
        	$where=array();
        	if($barcode['code']!=''){
           		$where[]=array('EQ',$barcode['code']);
        	}
        	if($barcode['tcode']!='' && $barcode['tcode']!=$barcode['code']){
            	$where[]=array('EQ',$barcode['tcode']);
       		}
        	if($barcode['ucode']!='' && $barcode['ucode']!=$barcode['code'] && $barcode['ucode']!=$barcode['tcode']){
            	$where[]=array('EQ',$barcode['ucode']);
        	}
        	$where[]='or';
        	$map['stor_barcode'] =$where;
       	 	$map['stor_unitcode']=session('unitcode');
       	 	$data=$Storage->where($map)->find();
        	if(is_not_null($data)){
        		$this->error('条码<b>'.$stor_barcode.'</b>已录入','',2);
        	}
        	//检测是否拆箱
			$map2=array();
        	$map2['chai_unitcode']=session('unitcode');
        	$map2['chai_barcode'] =$stor_barcode;
        	$data2=$Storchaibox->where($map2)->find();
        	if(is_not_null($data2)){
        		$this->error('条码<b>'.$stor_barcode.'</b>已经拆箱，不能再使用','',2);
        	}
			//保存入存记录
			$insert=array();
			$insert['stor_unitcode']=session('unitcode');
			$insert['stor_number']=$stor_number;//入库单号
			$insert['stor_pro']=$stor_pro;
			$insert['stor_attrid']=$stor_attrid;
			$insert['stor_color']=$stor_attrcolor;
			$insert['stor_size']=$stor_attrsize;
			$insert['stor_whid']=$stor_whid;
			$insert['stor_proqty']=$barcode['qty'];
			$insert['stor_barcode']=$stor_barcode;
			$insert['stor_date']=$stor_time;
			$insert['stor_ucode']=$barcode['ucode'];
			$insert['stor_tcode']=$barcode['tcode'];
			$insert['stor_remark']=$stor_remark;
			$insert['stor_cztype']=1;//操作类型 0-企业主账户  1-企业子管理用户  2-经销商
			$insert['stor_czid']=session('qyid');
			$insert['stor_czuser']=session('qyuser');
			$insert['stor_prodate']=$stor_prodate;
			$insert['stor_batchnum']=$stor_batchnum;
			$insert['stor_isship']=0;
            $rs=$Storage->create($insert,1);
			if($rs){
				$result = $Storage->add(); 
				if($result){
					//记录拆箱
					if($barcode['tcode']!='' && $barcode['tcode']!=$barcode['code']){
						$insert2=array();
						$data3=array();
						$insert2['chai_unitcode']=$qycode;
						$insert2['chai_barcode']=$barcode['tcode'];
						$data3=$Storchaibox->where($insert2)->find();
						if(!$data3){
							$insert2['chai_addtime']=$stor_time;
							$Storchaibox->create($insert2,1);
							$Storchaibox->add(); 
						}
					}
					if($barcode['ucode']!='' && $barcode['ucode']!=$barcode['code'] && $barcode['ucode']!=$barcode['tcode']){
						$insert3=array();
						$data4=array();
						$insert3['chai_unitcode']=$qycode;
						$insert3['chai_barcode']=$barcode['ucode'];
						$data4=$Storchaibox->where($insert3)->find();
						if(!$data4){
							$insert3['chai_addtime']=$stor_time;
							$Storchaibox->create($insert3,1);
							$Storchaibox->add(); 
						}
					}

					//记录日志 begin
					$log_arr=array();
					$log_arr=array(
					'log_qyid'=>session('qyid'),
					'log_user'=>session('qyuser'),
					'log_qycode'=>$qycode,
					'log_action'=>'企业子用户入库',
					'log_type'=>1, //0-系统 1-企业 2-经销商 3-消费者
					'log_addtime'=>$stor_time,
					'log_ip'=>real_ip(),
					'log_link'=>__SELF__,
					'log_remark'=>json_encode($insert)
					);
					save_log($log_arr);
					//记录日志 end
				  	$this->success('添加成功',U('Mp/Storage/add'),1);
				}else{
					$this->error('条码<b>'.$stor_barcode.'</b>出错。条码不正确','',2);
				}
			}else{
				$this->error('条码<b>'.$stor_barcode.'</b>出错。条码不正确','',2);
			}	
		}

    }

    //批量出货导入
    public function import(){
        $this->check_qypurview('13001',1);

		//产品
        $map2['pro_unitcode']=session('unitcode');
        $map2['pro_active'] = 1;
        $Product = M('Product');
        $list2 = $Product->field('pro_id,pro_name')->where($map2)->order('pro_number ASC')->select();
        // $this->assign('productlist', $list2);
        $this->assign('productlist',json_encode($list2));
       
		//仓库
		$map2=array();
        $map2['wh_unitcode']=session('unitcode');
        $Warehouse = M('Warehouse');
        $list3 = $Warehouse->where($map2)->order('wh_id ASC')->select();
        $this->assign('warehouselist', $list3);
		
		//获取产品颜色尺码
		$proattrlist=array();
		$levelattr=1;
		$mapyf=array();
		$mapyf['attr_unitcode']=session('unitcode');
		$Yifuattr = M('Yifuattr');
		$proidArry=$Yifuattr->where($mapyf)->field('attr_proid')->group('attr_proid')->select();
		if ($proidArry)
		{
			foreach ($proidArry as $k => $v) {
				$mapyf['attr_proid']=$v['attr_proid'];
				$proidcolorArry = $Yifuattr->where($mapyf)->field('attr_color')->group('attr_color')->select();
				$proattrArry=array();
				if ($proidcolorArry){
					$prokey=$v['attr_proid'];
					foreach ($proidcolorArry as $kk => $vv) {
						$mapyfs['attr_unitcode']=session('unitcode');
						$mapyfs['attr_proid']=$v['attr_proid'];
						$mapyfs['attr_color']=$vv['attr_color'];
						$Yifuattrs= M('Yifuattr');
						$alldata = $Yifuattrs->where($mapyfs)->order('attr_id ASC')->select();
						// var_dump($alldata);
						if ($alldata){
							$prosizelist=array();
							$levelattr=2;
							foreach($alldata as $kkk=>$vvv){ 
		   						$prosizelist[$kkk]['value']=$vvv['attr_id'];
		   						$prosizelist[$kkk]['text']=$vvv['attr_size'];
							}
							$proattrArry[$kk]['value']=$prokey;
		   					$proattrArry[$kk]['text']=$vv['attr_color'];
		   					$proattrArry[$kk]['children']=$prosizelist;
						}
					}
					$proattrlist[$k][$prokey]=$proattrArry;
				}
			}
		}
		// var_dump($proattrlist);
		$data['proattrlist']=json_encode($proattrlist); //转为json方便javascript接收
		$data['stor_datestr']='';
		$data['stor_id']=0;
        $this->assign('storageinfo', $data);
		$this->assign('mtitle', '批量入库');
        $this->assign('curr', 'storage_list');
        $this->display('import');
    }

    //保存出货导入
    public function import_save(){
        $this->check_qypurview('13001',1);

        if (!IS_POST) {
             header('HTTP/1.0 404 Not Found');
             echo'error:404';
             exit;
        }	
		$stor_number=I('post.stor_number','');
		$stor_pro=intval(I('post.stor_pro',0));
		$stor_remark=I('post.stor_remark','');
		$stor_whid=intval(I('post.stor_whid',0));
		$stor_attrid=intval(I('post.stor_size',0));
		$stor_attrcolor=I('post.pro_attrcolor',0);
		$stor_attrsize=I('post.pro_attrsize',0);
		$stor_prodate=I('post.stor_prodate',0);
		$stor_batchnum=I('post.stor_batchnum',0);

		$stor_time=time();

     	$stor_date=strtotime($stor_date);
		if($stor_number==''){
			$this->error('请填写入库单号','',2);
		}
		
		if($stor_pro<=0){
			$this->error('请选择入库产品','',2);
		}
		if($stor_whid<=0){
			$this->error('请选择入库仓库','',2);
		}
		if($stor_attrid<=0){
			$this->error('请选择颜色尺码','',2);
		}
        //上传文件 begin
       	 if($_FILES['barcode_file']['name']==''){
            $this->error('请选择条码文件','',2);
        }else{
            if($_FILES['barcode_file']['size']==0){
               	 $this->error('条码文件为空','',2);
            }
            $upload = new \Think\Upload();
            $upload->maxSize = 3145728 ;
            $upload->exts = array('txt');
            $upload->rootPath   = './Public/uploads/tempfile/';
            $upload->subName  = session('unitcode');
            $upload->saveName = $stor_time.'_'.mt_rand(1000,9999);
            $info   =   $upload->uploadOne($_FILES['barcode_file']);
           	if(!$info) {
                $this->error($upload->getError(),'',1);
            }else{
                $barcode_filename=$info['savepath'].$info['savename'];
            }

            @unlink($_FILES['barcode_file']['tmp_name']); 
        }
        //上传文件 end
        
        $lines = @file_get_contents('./Public/uploads/tempfile/'.$barcode_filename);
        if($lines){
            $lines=str_replace("\r",'',$lines);
            $lines=str_replace("chr(13)",'',$lines);
            $lines=str_replace("chr(10)",'',$lines);
            $linearr=explode("\n",$lines);
            $msgs=array();

            foreach($linearr as $key =>$li){
                $stor_barcode=trim($li);
                if($stor_barcode==''){
                     continue;
                }
                $msgs[$key]['barcode']=$stor_barcode;
                $msgs[$key]['error']='';

                if(!preg_match("/^[a-zA-Z0-9]{4,30}$/",$stor_barcode)){
                    $msgs[$key]['barcode']=$stor_barcode;
                    $msgs[$key]['error']='<span style="color:#FF0000">添加条码 '.htmlspecialchars($stor_barcode).' 出错，条码应由数字字母组成</span>';
                    continue;
                }
                //检测该条码是否已存在
                $map=array();
				$data=array();
				$Storchaibox= M('Storchaibox');
				$Storage= M('Storage');
       	 		$barcode=array();
		
				//检测该条码是否已录入
				$map['stor_unitcode']=session('unitcode');
				$map['stor_barcode'] = $stor_barcode;
				$data=$Storage->where($map)->find();
				if(is_not_null($data)){
					$msgs[$key]['error']='<span style="color:#FF0000">添加条码 '.$stor_barcode.' 出错，该条码已入库。</span>';
                    continue;
        		}

                //检测是否已发行
                $barcode=array();
                $barcode=wlcode_to_packinfo($stor_barcode,session('unitcode'));
                
                if(!is_not_null($barcode)){
                    $msgs[$key]['error']='<span style="color:#FF0000">添加条码 '.$stor_barcode.' 出错，该条码还没发行。</span>';
                    continue;
                }

                //是否已入库 ucode-大标  	tcode-中标 
       			$map=array();
        		$where=array();
        		if($barcode['code']!=''){
           			$where[]=array('EQ',$barcode['code']);
        		}
        		if($barcode['tcode']!='' && $barcode['tcode']!=$barcode['code']){
            		$where[]=array('EQ',$barcode['tcode']);
       			}
        		if($barcode['ucode']!='' && $barcode['ucode']!=$barcode['code'] && $barcode['ucode']!=$barcode['tcode']){
            		$where[]=array('EQ',$barcode['ucode']);
        		}
        		$where[]='or';
        		$map['stor_barcode'] =$where;
       	 		$map['stor_unitcode']=session('unitcode');

       	 		$data=$Storage->where($map)->find();
        		if(is_not_null($data)){
        			 $msgs[$key]['error']='<span style="color:#FF0000">添加条码 '.$stor_barcode.' 出错，该条码已入库。</span>';
                    continue;
        		}

                //检测是否拆箱
				$map2=array();
				$data2=array();
        		$map2['chai_unitcode']=session('unitcode');
        		$map2['chai_barcode'] =$stor_barcode;

        		$data2=$Storchaibox->where($map2)->find();

        		if(is_not_null($data2)){
        			 $msgs[$key]['error']='<span style="color:#FF0000">添加条码 '.$stor_barcode.' 出错，该条码此码已经拆箱，不能再使用。</span>';
                    continue;
        		}

               	//保存入存记录
				$insert=array();
				$insert['stor_unitcode']=session('unitcode');
				$insert['stor_number']=$stor_number;
				$insert['stor_pro']=$stor_pro;
				$insert['stor_attrid']=$stor_attrid;
				$insert['stor_color']=$stor_attrcolor;
				$insert['stor_size']=$stor_attrsize;
				$insert['stor_whid']=$stor_whid;
				$insert['stor_proqty']=$barcode['qty'];
				$insert['stor_barcode']=$stor_barcode;
				$insert['stor_date']=$stor_time;
				$insert['stor_ucode']=$barcode['ucode'];
				$insert['stor_tcode']=$barcode['tcode'];
				$insert['stor_remark']=$stor_remark;
				$insert['stor_cztype']=1;//操作类型 0-企业主账户  1-企业子管理用户  2-经销商
				$insert['stor_czid']=session('qyid');
				$insert['stor_czuser']=session('qyuser');
				$insert['stor_prodate']=$stor_prodate;
				$insert['stor_batchnum']=$stor_batchnum;
				$insert['stor_isship']=0;
						
            	$rs=$Storage->create($insert,1);
                if($rs){
                  $result = $Storage->add(); 
                   if($result){
                      //记录拆箱
						if($barcode['tcode']!='' && $barcode['tcode']!=$barcode['code']){
							$insert2=array();
							$data3=array();
							$insert2['chai_unitcode']=$qycode;
							$insert2['chai_barcode']=$barcode['tcode'];
							$data3=$Storchaibox->where($insert2)->find();
							if(!$data3){
								$insert2['chai_addtime']=$stor_time;
								$Storchaibox->create($insert2,1);
								$Storchaibox->add(); 
							}
						}
						if($barcode['ucode']!='' && $barcode['ucode']!=$barcode['code'] && $barcode['ucode']!=$barcode['tcode']){
							$insert3=array();
							$data4=array();
							$insert3['chai_unitcode']=$qycode;
							$insert3['chai_barcode']=$barcode['ucode'];
							$data4=$Storchaibox->where($insert3)->find();
							if(!$data4){
								$insert3['chai_addtime']=$stor_time;
								$Storchaibox->create($insert3,1);
								$Storchaibox->add(); 
							}
						}

						//记录日志 begin
						$log_arr=array();
						$log_arr=array(
						'log_qyid'=>session('qyid'),
						'log_user'=>session('qyuser'),
						'log_qycode'=>$qycode,
						'log_action'=>'企业子用户入库',
						'log_type'=>1, //0-系统 1-企业 2-经销商 3-消费者
						'log_addtime'=>$stor_time,
						'log_ip'=>real_ip(),
						'log_link'=>__SELF__,
						'log_remark'=>json_encode($insert)
						);
						save_log($log_arr);
						//记录日志 end

                        $msgs[$key]['error']='添加条码 '.$stor_barcode.' 成功。该条码包含产品数：'.$barcode['qty'];
                        continue;
                   }else{
                        $msgs[$key]['error']='<span style="color:#FF0000">添加条码 '.$stor_barcode.'出错。条码不正确</span>';
                        continue;
                   }
                }else{
                    $msgs[$key]['error']='<span style="color:#FF0000">添加条码 '.$stor_barcode.'出错。条码不正确</span>';
                    continue;
                }
            }

            $this->assign('msgslist', $msgs);

            $this->assign('curr', 'storage_list');

            $this->display('msgs');
        }else{
            $this->error('导入文件出错','',2);
        }
    }

    //删除入库记录
    public function delete(){
        $this->check_qypurview('30008',1);
         //-------------------------------
		$map=array();
        $map['stor_id']=intval(I('get.stor_id',0));
        $map['stor_unitcode']=session('unitcode');
        $Storage= M('Storage');
        $Storchaibox= M('Storchaibox');
		$Shipment= M('Shipment');
        //判断是否可删 保持数据完整性 待完善
        $data=$Storage->where($map)->find();
        if($data){
            //如果经销商已处理出货
            $map2=array();
            $map2['ship_unitcode']=session('unitcode');
            $where=array();
            $where['ship_barcode']=array('EQ',$data['stor_barcode']);
            $where['ship_tcode']=array('EQ',$data['stor_barcode']);
            $where['ship_ucode']=array('EQ',$data['stor_barcode']);
            $where['_logic'] = 'or';
            $map2['_complex'] = $where;
            $data1=$Shipment->where($map2)->find();
            if($data1){
               $this->error('该入库记录已出货，暂不能删除','',3);
            }

           //判断处理拆箱记录
            if($data['stor_tcode']!='' || $data['stor_ucode']!=''){

				if($data['stor_tcode']!='' &&  $data['stor_tcode']!=$data['stor_barcode']){	
                    $map2=array();
                    $map2['stor_tcode']=$data['stor_tcode'];
                    $map2['stor_unitcode']=session('unitcode');

                    $map2['stor_id'] = array('NEQ',$data['stor_id']);
                    $data2=$Storage->where($map2)->find();
                    if(is_not_null($data2)){

                    }else{
                        $map3=array();
                        $map3['chai_barcode']=$data['stor_tcode'];
                        $map3['chai_unitcode']=session('unitcode');
                        $Storchaibox->where($map3)->delete(); 
                    }
                }
				
				if($data['stor_ucode']!='' && $data['stor_ucode']!=$data['stor_barcode'] && $data['stor_ucode']!=$data['ship_tcode']){
                    $map2=array();
                    $map2['stor_ucode']=$data['stor_ucode'];
                    $map2['stor_unitcode']=session('unitcode');

                    $map2['stor_id'] = array('NEQ',$data['stor_id']);
                    $data2=$Storage->where($map2)->find();
                    if(is_not_null($data2)){

                    }else{
                        $map3=array();
                        $map3['chai_barcode']=$data['stor_ucode'];
                        $map3['chai_unitcode']=session('unitcode');
                        $Storchaibox->where($map3)->delete(); 
                    }

                    $map22=array();
                    $map22['stor_tcode']=$data['stor_tcode'];
                    $map22['ship_unitcode']=session('unitcode');
                    $map22['stor_id'] = array('NEQ',$data['stor_id']);
                    $data22=$Storage->where($map22)->find();
                    if(is_not_null($data22)){

                    }else{
                        $map33=array();
                        $map33['chai_barcode']=$data['stor_tcode'];
                        $map33['chai_unitcode']=session('unitcode');
                        $Storchaibox->where($map33)->delete(); 
                    }
                }
            }
             
            //记录日志 begin
				$log_arr=array();
				$log_arr=array(
				'log_qyid'=>session('qyid'),
				'log_user'=>session('qyuser'),
				'log_qycode'=>session('unitcode'),
				'log_action'=>'删除入库记录',
				'log_type'=>1, //0-系统 1-企业 2-经销商 3-消费者
				'log_addtime'=>time(),
				'log_ip'=>real_ip(),
				'log_link'=>__SELF__,
				'log_remark'=>json_encode($data)
				);
				save_log($log_arr);
            //记录日志 end
            $Storage->where($map)->delete(); 
            $this->success('删除成功','',2);
        }else{
            $this->error('没有该记录','',2);
        }
    }
   //子用户列表 用于微信出货扫描 
    public function subuserlist(){
        $this->check_qypurview('30004',1);

        $map['su_unitcode']=session('unitcode');
		$map['su_belong']=0;
		$map['su_openid']=array('neq','');
        $Qysubuser = M('Qysubuser');
        $list = $Qysubuser->where($map)->order('su_id DESC')->select();
        $this->assign('qysubuserlist', $list);

  
        //生成二维码 申请子用户
		$timestamp=time();
		$signature=MD5($timestamp.session('unitcode').$timestamp);
		
		$filepath = BASE_PATH.'/Public/uploads/product/'.session('unitcode').'/qysubuser.png';
		if (@is_dir(BASE_PATH.'/Public/uploads/product/'.session('unitcode').'/') === false){
	       @mkdir(BASE_PATH.'/Public/uploads/product/'.session('unitcode').'/');
	    }

		if(session('unitcode')>2831){
			$link='http://www.cn315fw.com/wxship/index/index/qycode/'.session('unitcode').'/ttamp/'.$timestamp.'/sture/'.$signature;
		}else{
		    $link='http://www.cn315fw.com/cp/wxship/index/qycode/'.session('unitcode').'/ttamp/'.$timestamp.'/sture/'.$signature;
		}
		
		
		make_ercode($link,$filepath,'','');
		$qysubuser_pic_str='<img src="'.__ROOT__.'/Public/uploads/product/'.session('unitcode').'/qysubuser.png"  border="0"   >';
        $this->assign('qysubuser_pic_str', $qysubuser_pic_str);
		
        $this->assign('curr', 'shipment_list');
        $this->display('subuserlist');
    }
	
    //删除子用户 用于微信出货扫描 
    public function sudelete(){
        $this->check_qypurview('30004',1);

        $map['su_id']=intval(I('get.su_id',0));
        $map['su_unitcode']=session('unitcode');
		$map['su_belong']=0;
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
 
    //审核子用户 用于微信出货扫描 
    public function suactive(){
        $this->check_qypurview('30004',1);

        $map['su_id']=intval(I('get.su_id',0));
        $map['su_unitcode']=session('unitcode');
		$map['su_belong']=0;
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
  
  //======================================================================
   //子用户列表 用于APP出货扫描 
    public function appsubuserlist(){
        $this->check_qypurview('13001',1);

        $map['su_unitcode']=session('unitcode');
		$map['su_belong']=0;
		$map['su_username']=array('neq','');
        $Qysubuser = M('Qysubuser');
        $list = $Qysubuser->where($map)->order('su_id DESC')->select();
        $this->assign('qysubuserlist', $list);

		
        $this->assign('curr', 'storage_list');
        $this->display('appsubuserlist');
    }
	//子用户添加 用于APP出货扫描 
	public function appsubuseradd(){
		$this->check_qypurview('13001',1);
		
		$data['su_id']=0;
		$this->assign('mtitle', '添加用户');
        $this->assign('curr', 'storage_list');
		$this->assign('subuserinfo', $data);
        $this->display('appsubuseradd');
	}
	
    //子用户修改 用于APP出货扫描 
    public function appsubuseredit(){
        $this->check_qypurview('13001',1);
		
        $map['su_id']=intval(I('get.su_id',0));
		$map['su_unitcode']=session('unitcode');
		
        $Qysubuser= M('Qysubuser');
        $data=$Qysubuser->where($map)->find();
		
        if($data){
        }else{
            $this->error('没有该记录');
        }
        
        $this->assign('subuserinfo', $data);
        $this->assign('curr', 'storage_list');
        $this->assign('mtitle', '修改用户');

        $this->display('appsubuseradd');
    }
	
    //保存子用户 用于APP出货扫描 
    public function appsubuseradd_save(){
		$this->check_qypurview('13001',1);
		
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

            $Qysubuser= M('Qysubuser');
            $rs=$Qysubuser->where($map)->data($data)->save();

            if($rs){
				//记录日志 begin
				$log_arr=array();
				$log_arr=array(
							'log_qyid'=>session('qyid'),
							'log_user'=>session('qyuser'),
							'log_qycode'=>session('unitcode'),
							'log_action'=>'修改APP子用户',
							'log_type'=>1, //0-系统 1-企业 2-经销商 3-消费者
							'log_addtime'=>time(),
							'log_ip'=>real_ip(),
							'log_link'=>__SELF__,
							'log_remark'=>json_encode($data)
							);
				save_log($log_arr);
				//记录日志 end
				$this->success('修改成功',U('Mp/Storage/appsubuserlist'),1);
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
			
            if(!preg_match("/[a-zA-Z0-9_]{6,20}$/",$data['su_username'])){
                $this->error('用户名由 A--Z,a--z,0--9,_ 组成,6-20位','',4);
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
                                    'log_action'=>'添加APP子用户',
									'log_type'=>1, //0-系统 1-企业 2-经销商 3-消费者
                                    'log_addtime'=>time(),
                                    'log_ip'=>real_ip(),
                                    'log_link'=>__SELF__,
                                    'log_remark'=>json_encode($data)
                                    );
                        save_log($log_arr);
                        //记录日志 end
                   $this->success('添加成功',U('Mp/Storage/appsubuserlist'),1);
               }else{
                   $this->error('添加失败','',2);
               }
            }else{
                $this->error('添加失败','',2);
            }
        }
    }

    //审核子用户 用于APP出货扫描  
    public function appsuactive(){
        $this->check_qypurview('13001',1);

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
   
   //删除子用户 用于APP出货扫描 
    public function appsudelete(){
        $this->check_qypurview('13001',1);

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
                        'log_action'=>'删除APP子用户',
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

 //======================================================================
   //入库统计
    public function stortongji(){
	    $this->check_qypurview('30007',1);
	   
		$whid=intval(I('param.whid',0));
        $begintime=I('param.begintime','');
        $endtime=I('param.endtime','');
		
        $Product = M('Product');
        $Storage = M('Storage');
		$Storage = M('Storage');
		
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
		}else{
            $begintime=strtotime(date('Y-m-d',time()));
            $endtime=strtotime(date('Y-m-d',time()))+3600*24-1;
		}
		
		$parameter['begintime']=urlencode(date('Y-m-d',$begintime));
        $parameter['endtime']=urlencode(date('Y-m-d',$endtime));
		$parameter['whid']=$whid;
		

        // $count = $Product->where($map)->count();
        // $Page = new \Think\Page($count, C('PAGE_SIZE'),$parameter);
        // $show = $Page->show();
		$Model=M();
		$map=array();
        $map['a.pro_unitcode'] =session('unitcode');
		$map['a.pro_id'] = array('exp','=b.attr_proid');
		$count =$Model->table('fw_product a,fw_yifuattr b')->where($map)->count();
        $Page = new \Think\Page($count, C('PAGE_SIZE'),$parameter);
        $show = $Page->show();
        $list = $Model->table('fw_product a,fw_yifuattr b')->where($map)->order('pro_id DESC')->limit(($Page->firstRow . ',') . $Page->listRows)->select();
        // $proList=array();
		foreach($list as $k=>$v){
		 	//统计数量
            $map2=array();
            $map2['stor_unitcode']=session('unitcode');
            $map2['stor_pro'] = $v['pro_id'];
            $map2['stor_attrid'] = $v['attr_id'];
			if($whid>0){
			    $map2['stor_whid'] = $whid;
			}
			$map2['stor_date']=array('between',array($begintime,$endtime));
            $count1 = $Storage->where($map2)->sum('stor_proqty');
			if($count1){
			    $list[$k]['count1']=$count1;
			}else{
				$list[$k]['count1']=0;
			}
		}
		// var_dump($proList);
		// exit;
		//仓库
		$map2=array();
        $map2['wh_unitcode']=session('unitcode');
        $Warehouse = M('Warehouse');
        $list3 = $Warehouse->where($map2)->order('wh_id ASC')->select();
        $this->assign('warehouselist', $list3);
		
		$this->assign('begintime', date('Y-m-d',$begintime));
		$this->assign('endtime', date('Y-m-d',$endtime));

        $this->assign('whid', $whid);
	    $this->assign('list', $list);
		$this->assign('page', $show);
        $this->assign('curr', 'storage_tongji');
        $this->display('stortongji');
    }

   //库存统计
    public function stocktongji(){
	    $this->check_qypurview('30007',1);
	   
        $Product = M('Product');
		$Storage = M('Storage');
		$Shipment = M('Shipment');
		
		$Model=M();
		$map=array();
        $map['a.pro_unitcode'] =session('unitcode');
		$map['a.pro_id'] = array('exp','=b.attr_proid');
		$count =$Model->table('fw_product a,fw_yifuattr b')->where($map)->count();
        $Page = new \Think\Page($count, C('PAGE_SIZE'),$parameter);
        $show = $Page->show();
        $list = $Model->table('fw_product a,fw_yifuattr b')->where($map)->order('pro_id DESC')->limit(($Page->firstRow . ',') . $Page->listRows)->select();
		
		foreach($list as $k=>$v){ 
            //统计入库数量
            $map2=array();
            $map2['stor_unitcode']=session('unitcode');
            $map2['stor_pro'] = $v['pro_id'];
            $map2['stor_attrid'] = $v['attr_id'];
            $count1 = $Storage->where($map2)->sum('stor_proqty');
			if($count1){
			    $list[$k]['count1']=$count1;
			}else{
				$list[$k]['count1']=0;
			}
			
			//统计出货数量
			$Model=M();
			$map2=array();
        	$map2['a.ship_unitcode'] =session('unitcode');
        	$map2['a.ship_deliver'] = 0;   //ship_deliver -发货方    ship_dealer--收货方
			$map2['a.ship_oddtid'] = array('exp','=b.oddt_id');
			$map2['b.oddt_proid'] = $v['pro_id'];
			$map2['b.oddt_attrid'] = $v['attr_id'];
			$count2 =$Model->table('fw_shipment a,fw_orderdetail b')->where($map2)->sum('ship_proqty');

			if($count2){
			    $list[$k]['count2']=$count2;
			}else{
				$list[$k]['count2']=0;
			}

			$kucun=$list[$k]['count1']-$list[$k]['count2'];
			if ($kucun>0)
				$list[$k]['kucun']=$kucun;
			else
				$list[$k]['kucun']=0;
		}
		
	    $this->assign('list', $list);
		$this->assign('page', $show);
        $this->assign('curr', 'stock_tongji');
        $this->display('stocktongji');
    }

//================================================================================
    //经销商出货列表
    public function dlshiplist(){
        $this->check_qypurview('90004',1);
		
		$pro_id=intval(I('param.proid',0));
		$dlusername=trim(I('param.dlusername',''));
		$begintime=I('param.begintime','');
        $endtime=I('param.endtime','');
        $keyword=trim(strip_tags(htmlspecialchars_decode(I('param.keyword',''))));
		$parameter=array();
		
        if($pro_id>0){
            $map['stor_pro']=$pro_id;
			$parameter['proid']=$pro_id;
        }

		if($dlusername!='' && $dlusername!='请输入出货代理账号'){
            if(!preg_match("/[a-zA-Z0-9_-]{4,20}$/",$dlusername)){
                $this->error('经销商账号不正确','',1);
            }
			
			$map2=array();
			$Dealer = M('Dealer');
            $map2['dl_username']=$dlusername;
            $map2['dl_unitcode']=session('unitcode');
            $data2=$Dealer->where($map2)->find();
            if(!$data2){
				$this->error('经销商账号不正确','',1);
			}
            $map['stor_deliver']=$data2['dl_id'];
			$parameter['dlusername']=$dlusername;
			$this->assign('dlusername', $dlusername);
        }else{
			$this->assign('dlusername', '请输入出货代理账号');
		}
		
		
        if($keyword!=''){
            $keyword=str_replace('[','',$keyword);
            $keyword=str_replace(']','',$keyword);
            $keyword=str_replace('%','',$keyword);
            $keyword=str_replace('_','',$keyword);

            $keyword=sub_str($keyword,20,false);
            $where['stor_number']=array('LIKE', '%'.$keyword.'%');
            $where['stor_barcode']=array('LIKE', '%'.$keyword.'%');
            $where['_logic'] = 'or';
            $map['_complex'] = $where;
			
			$parameter['keyword']=$keyword;
        }
		
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
			
			$map['stor_date']=array('between',array($begintime,$endtime));
			
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

        $map['stor_unitcode']=session('unitcode');
		if(!isset($map['stor_deliver'])){
           $map['stor_deliver']=array('GT',0); //出货方 
		}
        $Shipment = M('Shipment');
        $count = $Shipment->where($map)->count();
        $Page = new \Think\Page($count, C('PAGE_SIZE'));
        $show = $Page->show();
        $list = $Shipment->where($map)->order('stor_date DESC')->limit(($Page->firstRow . ',') . $Page->listRows)->select();
        $Product = M('Product');
        $Dealer = M('Dealer');
        foreach($list as $k=>$v){ 
            $map2=array();
            $map2['pro_unitcode']=session('unitcode');
            $map2['pro_id'] = $v['stor_pro'];
            $Proinfo = $Product->where($map2)->find();

            if($Proinfo){
                  $list[$k]['pro_name']=$Proinfo['pro_name'];
                  $list[$k]['pro_number']=$Proinfo['pro_number'];
            }else{
                  $list[$k]['pro_name']='未知';
                  $list[$k]['pro_number']='未知';
            }
            //收货代理
            $map2=array();
            $map2['dl_unitcode']=session('unitcode');
            $map2['dl_id'] = $v['stor_dealer'];
            $Dealerinfo = $Dealer->where($map2)->find();
            if($Dealerinfo){
                $list[$k]['dl_name']=$Dealerinfo['dl_name'].'('.$Dealerinfo['dl_username'].')';
            }else{
                  $list[$k]['dl_name']='未知';
            }
            
			//发货代理
            $map2=array();
            $map2['dl_unitcode']=session('unitcode');
            $map2['dl_id'] = $v['stor_deliver'];
            $Dealerinfo = $Dealer->where($map2)->find();
            if($Dealerinfo){
                $list[$k]['dl_name_send']=$Dealerinfo['dl_name'].'('.$Dealerinfo['dl_username'].')';
            }else{
                  $list[$k]['dl_name_send']='-';
            }

        }
		
        //产品列表
		$map2=array();
        $map2['pro_unitcode']=session('unitcode');
        $map2['pro_active'] = 1;
        $list2 = $Product->where($map2)->order('pro_number ASC')->select();
        $this->assign('productlist', $list2);
		$this->assign('pro_id', $pro_id);

        $this->assign('list', $list);
        $this->assign('page', $show);
        $this->assign('curr', 'dealer_shiplist');
        $this->display('dlshiplist');
    } 

}