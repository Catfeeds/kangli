<?php
namespace Mp\Controller;
use Think\Controller;
//出货管理
class ShipmentController extends CommController {
	//出货列表
    public function index(){
        $this->check_qypurview('30001',1);
		$pro_id=intval(I('param.proid',0));
		$dl_id=intval(I('param.dlid',0));
		$begintime=I('param.begintime','');
        $endtime=I('param.endtime','');
        $keyword=trim(strip_tags(htmlspecialchars_decode(I('param.keyword',''))));
		$parameter=array();
        if($pro_id>0){
            $map['ship_pro']=$pro_id;
			$parameter['proid']=$pro_id;
        }
		if($dl_id>0){
            $map['ship_dealer']=$dl_id;
			$parameter['dlid']=$dl_id;
        }
        if($keyword!=''){
            $keyword=str_replace('[','',$keyword);
            $keyword=str_replace(']','',$keyword);
            $keyword=str_replace('%','',$keyword);
            $keyword=str_replace('_','',$keyword);

            $keyword=sub_str($keyword,20,false);
            $where['ship_number']=array('LIKE', '%'.$keyword.'%');
            $where['ship_barcode']=array('LIKE', '%'.$keyword.'%');
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
			$map['ship_date']=array('between',array($begintime,$endtime));
			
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
        $map['ship_unitcode']=session('unitcode');
        $map['ship_deliver']=0;
        $Shipment = M('Shipment');
        $count = $Shipment->where($map)->count();
        $Page = new \Think\Page($count, C('PAGE_SIZE'),$parameter);
        $show = $Page->show();
        $list = $Shipment->where($map)->order('ship_date DESC,ship_id DESC')->limit(($Page->firstRow . ',') . $Page->listRows)->select();
        $Product = M('Product');
        $Dealer = M('Dealer');
		$Warehouse = M('Warehouse');
        foreach($list as $k=>$v){ 
            $map2=array();
            $map2['pro_unitcode']=session('unitcode');
            $map2['pro_id'] = $v['ship_pro'];
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
            $map2['dl_id'] = $v['ship_dealer'];
            $Dealerinfo = $Dealer->where($map2)->find();
            if($Dealerinfo){
                $list[$k]['dl_name']=$Dealerinfo['dl_name'].'('.$Dealerinfo['dl_username'].')';
            }else{
                $list[$k]['dl_name']='-';
            }
			
            $map2=array();
            $map2['wh_unitcode']=session('unitcode');
            $map2['wh_id'] = $v['ship_whid'];
            $warehouse = $Warehouse->where($map2)->find();

            if($warehouse){
                  $list[$k]['warehouse']=$warehouse['wh_name'];
            }else{
                  $list[$k]['warehouse']='-';
            }
			
        }
		//直属经销商列表
		$map2=array();
        $map2['dl_unitcode']=session('unitcode');
        $map2['dl_belong'] = 0;
        $list2 = $Dealer->where($map2)->order('dl_number ASC')->select();
        $this->assign('dealerlist', $list2);
		$this->assign('dl_id', $dl_id);
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
        $this->assign('curr', 'shipment_list');
        $this->display('list');
    }
    
	//出货扫描
    public function add(){
        $this->check_qypurview('30002',1);

        $map['dl_unitcode']=session('unitcode');
        $map['dl_status'] = 1;
        $map['dl_belong'] = 0;
        $Dealer = M('Dealer');
        $list = $Dealer->where($map)->order('dl_number ASC')->select();
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
		
		$data['ship_datestr']='';
		$data['ship_id']=0;
        $this->assign('shipmentinfo', $data);
		
		$this->assign('mtitle', '添加出货');
        $this->assign('curr', 'shipment_list');

        $this->display('add');
    }
   
	//修改出货扫描
    public function edit(){
        $this->check_qypurview('30005',1);
        $map['ship_id']=intval(I('get.ship_id',0));
        $map['ship_unitcode']=session('unitcode');
        $Shipment= M('Shipment');
        $Chaibox= M('Chaibox');
		$data=$Shipment->where($map)->find();
		if($data){
		    //在还没有向下级出货时可以修改
            $map2=array();
            $map2['ship_unitcode']=session('unitcode');
            $map2['ship_deliver']=array('gt',0);
            $map2['ship_id'] = array('NEQ',$data['ship_id']);

            $where=array();
            $where['ship_barcode']=array('EQ',$data['ship_barcode']);
            $where['ship_tcode']=array('EQ',$data['ship_barcode']);
            $where['ship_ucode']=array('EQ',$data['ship_barcode']);
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
            $map2['dl_id'] = $data['ship_dealer'];
            $Dealerinfo = $Dealer->where($map2)->find();
            if($Dealerinfo){
                $data['old_dl_name']=$Dealerinfo['dl_contact'].'('.$Dealerinfo['dl_name'].')';
            }else{
                $data['old_dl_name']='';
            }
			
			$data['ship_datestr']=date('Y-m-d',$data['ship_date']);
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
   
   //保存出货扫描
    public function add_save(){
        
        if (!IS_POST) {
             header('HTTP/1.0 404 Not Found');
             echo'error:404';
             exit;
        }
		$map['ship_id']=intval(I('post.ship_id',0));
		
		
		if($map['ship_id']>0){
			$this->check_qypurview('30005',1);
			
			$map['ship_unitcode']=session('unitcode');
			$Shipment= M('Shipment');
			$data=$Shipment->where($map)->find();
			if($data){
				$ship_date=I('post.ship_date','');
				$ship_number=I('post.ship_number','');
				$ship_dealer=intval(I('post.ship_dealer',0));
				$ship_dealer2=intval(I('post.ship_dealer2',0));
				$ship_dealer3=intval(I('post.ship_dealer3',0));
				$ship_pro=intval(I('post.ship_pro',0));
				$ship_remark=I('post.ship_remark','');
				$ship_whid=intval(I('post.ship_whid',0));
				
				if($ship_date==''){
					$this->error('请填写出货日期','',2);
				}
				$ship_date=strtotime($ship_date);
				if($ship_number==''){
					$this->error('请填写出货单号','',2);
				}
				if($ship_dealer3>0){
					$ship_dealer=$ship_dealer3;
				}else if($ship_dealer2>0){
					$ship_dealer=$ship_dealer2;
				}
				if($ship_dealer<=0){
					$this->error('请选择出货经销商客户','',2);
				}
				if($ship_pro<=0){
					$this->error('请选择出货产品','',2);
				}
				if($ship_whid<=0){
					$this->error('请选择出货仓库','',2);
				}
				
				//入库 记录拆箱 tcode-中    ucode-大 
				$insert['ship_number']=$ship_number;
				$insert['ship_dealer']=$ship_dealer;
				$insert['ship_pro']=$ship_pro;
				$insert['ship_whid']=$ship_whid;
				$insert['ship_date']=$ship_date;
				$insert['ship_remark']=$ship_remark;
				$insert['ship_cztype']=0;//操作类型 0-企业主账户  1-企业子管理用户  2-经销商
				$insert['ship_czid']=session('qyid');
				$insert['ship_czuser']=session('qyuser');
				
				$rs=$Shipment->where($map)->data($insert)->save();
				
				if($rs){
					//记录日志 begin
                    $log_arr=array(
						'log_qyid'=>session('qyid'),
						'log_user'=>session('qyuser'),
						'log_qycode'=>session('unitcode'),
						'log_action'=>'修改出货',
						'log_type'=>1, //0-系统 1-企业 2-经销商 3-消费者
						'log_addtime'=>time(),
						'log_ip'=>real_ip(),
						'log_link'=>__SELF__,
						'log_remark'=>json_encode($insert)
						);
					save_log($log_arr);
					//记录日志 end

					$this->success('修改成功',U('Mp/Shipment/index'),1);
				}elseif($rs===0){
					$this->success('修改成功',U('Mp/Shipment/index'),1);
				}else{
					$this->error('修改失败','',1);
				}
			}else{
				$this->error('没有该记录','',2);
			}
		}else{
			$this->check_qypurview('30002',1);
			
			$ship_date=I('post.ship_date','');
			$ship_number=I('post.ship_number','');
			$ship_dealer=intval(I('post.ship_dealer',0));
			$ship_dealer2=intval(I('post.ship_dealer2',0));
			$ship_dealer3=intval(I('post.ship_dealer3',0));
			$ship_pro=intval(I('post.ship_pro',0));
			$ship_barcode=I('post.ship_barcode','');
			$ship_remark=I('post.ship_remark','');
			$ship_whid=intval(I('post.ship_whid',0));
			$ship_time=time();
			
			
			if($ship_date==''){
				$this->error('请填写出货日期','',2);
			}
			$ship_date=strtotime($ship_date);
			if($ship_number==''){
				$this->error('请填写出货单号','',2);
			}
			if($ship_dealer3>0){
				$ship_dealer=$ship_dealer3;
			}else if($ship_dealer2>0){
				$ship_dealer=$ship_dealer2;
			}

			
			if($ship_dealer<=0){
				$this->error('请选择出货经销商客户','',2);
			}
			if($ship_pro<=0){
				$this->error('请选择出货产品','',2);
			}
			if($ship_whid<=0){
				$this->error('请选择出货仓库','',2);
			}
			if($ship_barcode==''){
				$this->error('请扫描或填写条码','',2);
			}
			if(!preg_match("/^[a-zA-Z0-9]{4,30}$/",$ship_barcode)){
				$this->error('条码由数字字母组成','',2);
			}


			//检测该条码是否已存在
			$map['ship_unitcode']=session('unitcode');
			$map['ship_barcode'] = $ship_barcode;
			$map['ship_deliver']=0;
			$Shipment= M('Shipment');
			$data=$Shipment->where($map)->find();
			if(is_not_null($data)){
				$this->error('该码已存在','',2);
			}

			//检测是否已发行
			$barcode=wlcode_to_packinfo($ship_barcode,session('unitcode'));
			
			if(!is_not_null($barcode)){
				$this->error('条码还没发行','',2);
			}

			//是否出货
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
			$map['ship_barcode'] = $where;
			$map['ship_unitcode']=session('unitcode');
			$map['ship_deliver']=0;
			$data=$Shipment->where($map)->find();
			if(is_not_null($data)){
				$this->error('该码已存在','',2);
			}


			// if ($Haspurview){
            //是否已入库
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
			$map['stor_unitcode']=session('unitcode');
			$map['stor_barcode'] = $where;
            $Storage= M('Storage');
			$data=$Storage->where($map)->find();
        	if(!is_not_null($data)){
        		$this->error('该码产品还没入库','',2);
        	}
         // }

			//检测是否拆箱
			$map2['chai_unitcode']=session('unitcode');
			$map2['chai_barcode'] = $ship_barcode;
			$map2['chai_deliver'] = 0;
			$Chaibox= M('Chaibox');
			$data2=$Chaibox->where($map2)->find();

			if(is_not_null($data2)){
				$this->error('该码已经拆箱，不能再使用','',2);
			}

			$ship_proqty=$barcode['qty'];


			//入库 记录拆箱 tcode-大    ucode-中 
			$insert['ship_unitcode']=session('unitcode');
			$insert['ship_number']=$ship_number;
			$insert['ship_deliver']=0;
			$insert['ship_dealer']=$ship_dealer;
			$insert['ship_pro']=$ship_pro;
			$insert['ship_whid']=$ship_whid;
			$insert['ship_proqty']=$ship_proqty;
			$insert['ship_barcode']=$ship_barcode;
			$insert['ship_date']=$ship_date;
			$insert['ship_ucode']=$barcode['ucode'];
			$insert['ship_tcode']=$barcode['tcode'];
			$insert['ship_remark']=$ship_remark;
			$insert['ship_cztype']=0;//操作类型 0-企业主账户  1-企业子管理用户  2-经销商
			$insert['ship_czid']=session('qyid');
			$insert['ship_czuser']=session('qyuser');

			$rs=$Shipment->create($insert,1);
			if($rs){
			   $result = $Shipment->add(); 
			   if($result){
					//记录拆箱
					if($barcode['tcode']!='' && $barcode['tcode']!=$barcode['code']){

						$insert2['chai_unitcode']=session('unitcode');
						$insert2['chai_barcode']=$barcode['tcode'];
						$insert2['chai_deliver']=0;
						$data3=$Chaibox->where($insert2)->find();
						if(!$data3){
							$insert2['chai_addtime']=$ship_time;
							$Chaibox->create($insert2,1);
							$Chaibox->add(); 

						}
					}
					if($barcode['ucode']!='' && $barcode['ucode']!=$barcode['code'] && $barcode['ucode']!=$barcode['tcode']){

						$insert3['chai_unitcode']=session('unitcode');
						$insert3['chai_barcode']=$barcode['ucode'];
						$insert3['chai_deliver']=0;
						$data4=$Chaibox->where($insert3)->find();
						if(!$data4){
							$insert3['chai_addtime']=$ship_time;
							$Chaibox->create($insert3,1);
							$Chaibox->add(); 

						}
					}

					//记录日志 begin
					$log_arr=array(
								'log_qyid'=>session('qyid'),
								'log_user'=>session('qyuser'),
								'log_qycode'=>session('unitcode'),
								'log_action'=>'出货扫描',
								'log_type'=>1, //0-系统 1-企业 2-经销商 3-消费者
								'log_addtime'=>time(),
								'log_ip'=>real_ip(),
								'log_link'=>__SELF__,
								'log_remark'=>json_encode($insert)
								);
					save_log($log_arr);
					//记录日志 end
				   $this->success('添加成功',U('Mp/Shipment/add'),1);
			   }else{
				   $this->error('添加失败','',2);
			   }
			}else{
				$this->error('添加失败','',2);
			}
		}

    }

    //批量出货导入
    public function import(){
        $this->check_qypurview('30003',1);

        $map['dl_unitcode']=session('unitcode');
        $map['dl_status'] = 1;
        $map['dl_belong'] = 0;
        $Dealer = M('Dealer');
        $list = $Dealer->where($map)->order('dl_number ASC')->select();
        $this->assign('dealerlist', $list);
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
		
        $this->assign('curr', 'shipment_list');

        $this->display('import');
    }

    //保存出货导入
    public function import_save(){
        $this->check_qypurview('30003',1);

        if (!IS_POST) {
             header('HTTP/1.0 404 Not Found');
             echo'error:404';
             exit;
        }

        $ship_date=I('post.ship_date','');
        $ship_number=I('post.ship_number','');
        $ship_dealer=intval(I('post.ship_dealer',0));
		$ship_dealer2=intval(I('post.ship_dealer2',0));
		$ship_dealer3=intval(I('post.ship_dealer3',0));
        $ship_pro=intval(I('post.ship_pro',0));
		$ship_whid=intval(I('post.ship_whid',0));
		$ship_remark=I('post.ship_remark','');
        $ship_time=time();
        if($ship_date==''){
            $this->error('请填写出货日期','',2);
        }
        $ship_date=strtotime($ship_date);
        if($ship_number==''){
            $this->error('请填写出货单号','',2);
        }
	    if($ship_dealer3>0){
			$ship_dealer=$ship_dealer3;
		}else if($ship_dealer2>0){
			$ship_dealer=$ship_dealer2;
		}	
        if($ship_dealer<=0){
            $this->error('请选择出货经销商客户','',2);
        }
        if($ship_pro<=0){
            $this->error('请选择出货产品','',2);
        }
        if($ship_whid<=0){
            $this->error('请选择出货仓库','',2);
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
            $upload->saveName = $ship_time.'_'.mt_rand(1000,9999);
            
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
                $ship_barcode=trim($li);
                if($ship_barcode==''){
                     continue;
                }
                $msgs[$key]['barcode']=$ship_barcode;
                $msgs[$key]['error']='';

                if(!preg_match("/^[a-zA-Z0-9]{4,30}$/",$ship_barcode)){
                    $msgs[$key]['barcode']=$ship_barcode;
                    $msgs[$key]['error']='<span style="color:#FF0000">添加条码 '.htmlspecialchars($ship_barcode).' 出错，条码应由数字字母组成</span>';
                    continue;
                }
                //检测该条码是否已存在
                $map=array();
                $data=array();
                $map['ship_unitcode']=session('unitcode');
                $map['ship_barcode'] = $ship_barcode;
                $map['ship_deliver']=0;
                $Shipment= M('Shipment');
                $data=$Shipment->where($map)->find();
                if(is_not_null($data)){
                    $msgs[$key]['error']='<span style="color:#FF0000">添加条码 '.$ship_barcode.' 出错，该条码已存在。</span>';
                    continue;
                }

                //检测是否已发行
                $barcode=array();
                $barcode=wlcode_to_packinfo($ship_barcode,session('unitcode'));
                if(!is_not_null($barcode)){
                    $msgs[$key]['error']='<span style="color:#FF0000">添加条码 '.$ship_barcode.' 出错，该条码还没发行。</span>';
                    continue;
                }

                //是否出货
                $map=array();
                $where=array();
                $data=array();
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
                $map['ship_barcode'] = $where;
                $map['ship_unitcode']=session('unitcode');
                $map['ship_deliver']=0;
                $data=$Shipment->where($map)->find();
                if(is_not_null($data)){
                    $msgs[$key]['error']='<span style="color:#FF0000">添加条码 '.$ship_barcode.' 出错，该条码已存在。</span>';
                    continue;
                }
                // if ($Haspurview){
            		//是否具有入库权限，验证产品条码是否已经入库
       	 			$map3=array();
        			$where3=array();
					$data3=array();
					if($barcode['code']!=''){
						$where3[]=array('EQ',$barcode['code']);
					}
					if($barcode['tcode']!='' && $barcode['ucode']!=$barcode['tcode']){
						$where3[]=array('EQ',$barcode['tcode']);
					}
					if($barcode['ucode']!='' &&  $barcode['ucode']!=$barcode['tcode']){
						$where3[]=array('EQ',$barcode['ucode']);
					}
					if($barcode['ucode']!='' &&  $barcode['ucode']==$barcode['tcode']){
						$where3[]=array('EQ',$barcode['ucode']);
					}

        			$where3[]='or';
					$map3['stor_unitcode']=session('unitcode');
					$map3['stor_barcode'] =$where3;
					$Storage=M('Storage');
           			$data2=$Storage->where($map3)->find();
            		if(!is_not_null($data2)){
            			$msgs[$key]['error']='<span style="color:#FF0000">添加条码 '.$ship_barcode.' 出错，该条码产品还没入库。</span>';
						continue;
            		}
           		// }

                //检测是否拆箱
                $map2=array();
                $data2=array();
                $map2['chai_unitcode']=session('unitcode');
                $map2['chai_barcode'] = $ship_barcode;
                $map2['chai_deliver']=0;
                $Chaibox= M('Chaibox');
                $data2=$Chaibox->where($map2)->find();

                if(is_not_null($data2)){
                    $msgs[$key]['error']='<span style="color:#FF0000">添加条码 '.$ship_barcode.' 出错，该条码此码已经拆箱，不能再使用。</span>';
                    continue;
                }

                //入库 记录拆箱
                $insert=array();
                $insert['ship_unitcode']=session('unitcode');
                $insert['ship_number']=$ship_number;
                $insert['ship_deliver']=0;
                $insert['ship_dealer']=$ship_dealer;
                $insert['ship_pro']=$ship_pro;
				$insert['ship_whid']=$ship_whid;
                $insert['ship_proqty']=$barcode['qty'];
                $insert['ship_barcode']=$ship_barcode;
                $insert['ship_date']=$ship_date;
                $insert['ship_ucode']=$barcode['ucode'];
                $insert['ship_tcode']=$barcode['tcode'];
				$insert['ship_remark']=$ship_remark;
                $insert['ship_cztype']=0;//操作类型 0-企业主账户  1-企业子管理用户  2-经销商
		        $insert['ship_czid']=session('qyid');
		        $insert['ship_czuser']=session('qyuser');
				
                $rs=$Shipment->create($insert,1);
                if($rs){
                   $result = $Shipment->add(); 
                   if($result){
                        //记录拆箱
                        if($barcode['tcode']!='' && $barcode['tcode']!=$barcode['code']){
                            $insert2=array();
                            $data3=array();
                            $insert2['chai_unitcode']=session('unitcode');
                            $insert2['chai_barcode']=$barcode['tcode'];
                            $insert2['chai_deliver']=0;
                            $data3=$Chaibox->where($insert2)->find();
                            if(!$data3){
                                $insert2['chai_addtime']=$ship_time;
                                $Chaibox->create($insert2,1);
                                $Chaibox->add(); 

                            }
                        }
                        if($barcode['ucode']!='' && $barcode['ucode']!=$barcode['code'] && $barcode['ucode']!=$barcode['tcode']){
                            $insert3=array();
                            $data4=array();
                            $insert3['chai_unitcode']=session('unitcode');
                            $insert3['chai_barcode']=$barcode['ucode'];
                            $insert3['chai_deliver']=0;
                            $data4=$Chaibox->where($insert3)->find();
                            if(!$data4){
                                $insert3['chai_addtime']=$ship_time;
                                $Chaibox->create($insert3,1);
                                $Chaibox->add(); 
                            }
                        }

                        //记录日志 begin
                        $log_arr=array();
                        $insert['barcode_filename']=$barcode_filename;
                        $log_arr=array(
                                    'log_qyid'=>session('qyid'),
                                    'log_user'=>session('qyuser'),
                                    'log_qycode'=>session('unitcode'),
                                    'log_action'=>'出货导入',
									'log_type'=>1, //0-系统 1-企业 2-经销商 3-消费者
                                    'log_addtime'=>time(),
                                    'log_ip'=>real_ip(),
                                    'log_link'=>__SELF__,
                                    'log_remark'=>json_encode($insert)
                                    );
                        save_log($log_arr);
                        //记录日志 end

                        $msgs[$key]['error']='添加条码 '.$ship_barcode.' 成功。该条码包含产品数：'.$barcode['qty'];
                        continue;
                   }else{
                        $msgs[$key]['error']='<span style="color:#FF0000">添加条码 '.$ship_barcode.'出错。条码不正确</span>';
                        continue;
                   }
                }else{
                    $msgs[$key]['error']='<span style="color:#FF0000">添加条码 '.$ship_barcode.'出错。条码不正确</span>';
                    continue;
                }
            }

            $this->assign('msgslist', $msgs);

            $this->assign('curr', 'shipment_list');

            $this->display('msgs');
        }else{
            $this->error('导入文件出错','',2);
        }
    }

    //删除出货记录
    public function delete(){
        $this->check_qypurview('30008',1);

        $map['ship_id']=intval(I('get.ship_id',0));
        $map['ship_unitcode']=session('unitcode');
        $Shipment= M('Shipment');
        $Chaibox= M('Chaibox');
        //判断是否可删 保持数据完整性 待完善
        $data=$Shipment->where($map)->find();
        if($data){
			//如果是按订单出货 并且已确认收货 
			if($data['ship_odid']>0 && $data['ship_odblid']>0){
				$Model=M();
				$map2=array();
				$order=array();
				$map2['a.od_unitcode']=session('unitcode');
				$map2['a.od_id']=array('exp','=b.odbl_odid');
				$map2['a.od_oddlid']=array('exp','=b.odbl_oddlid');
				$map2['b.odbl_id']=$data['ship_odblid'];
				$map2['b.odbl_odid']=$data['ship_odid'];
				$order = $Model->table('fw_orders a,fw_orderbelong b')->where($map2)->find();
				if($order){
					if($order['odbl_state']==3){
					    $this->error('该出货记录对应订单已发货，暂不能删除','',2);
				    }
					if($order['odbl_state']==8){
						$this->error('该出货记录对应订单已确认收货，暂不能删除','',2);
					}
				}else{
					$this->error('该出货记录对应订单记录不存在，暂不能删除','',2);
				}
			}
			
            //如果经销商已处理出货
            $map2=array();
            $map2['ship_unitcode']=session('unitcode');
            $map2['ship_deliver']=array('gt',0);
            $map2['ship_id'] = array('NEQ',$data['ship_id']);

            $where=array();
            $where['ship_barcode']=array('EQ',$data['ship_barcode']);
            $where['ship_tcode']=array('EQ',$data['ship_barcode']);
            $where['ship_ucode']=array('EQ',$data['ship_barcode']);
            $where['_logic'] = 'or';
            $map2['_complex'] = $where;
            $data1=$Shipment->where($map2)->find();
            if($data1){
               $this->error('该出货记录已被下级经销商重新出货，暂不能删除','',3);
            }

           //判断处理拆箱记录
            if($data['ship_tcode']!='' || $data['ship_ucode']!=''){

				if($data['ship_tcode']!='' &&  $data['ship_tcode']!=$data['ship_barcode']){	
                    $map2=array();
                    $map2['ship_tcode']=$data['ship_tcode'];
                    $map2['ship_unitcode']=session('unitcode');
					$map2['ship_deliver']=0;  
                    $map2['ship_id'] = array('NEQ',$data['ship_id']);
                    $data2=$Shipment->where($map2)->find();
                    if(is_not_null($data2)){

                    }else{
                        $map3=array();
                        $map3['chai_barcode']=$data['ship_tcode'];
                        $map3['chai_unitcode']=session('unitcode');
						$map3['chai_deliver'] = 0;
                        $Chaibox->where($map3)->delete(); 
                    }
                }
				
				if($data['ship_ucode']!='' && $data['ship_ucode']!=$data['ship_barcode'] && $data['ship_ucode']!=$data['ship_tcode']){
                    $map2=array();
                    $map2['ship_ucode']=$data['ship_ucode'];
                    $map2['ship_unitcode']=session('unitcode');
					$map2['ship_deliver']=0;  
                    $map2['ship_id'] = array('NEQ',$data['ship_id']);
                    $data2=$Shipment->where($map2)->find();
                    if(is_not_null($data2)){

                    }else{
                        $map3=array();
                        $map3['chai_barcode']=$data['ship_ucode'];
                        $map3['chai_unitcode']=session('unitcode');
						$map3['chai_deliver'] = 0;
                        $Chaibox->where($map3)->delete(); 
                    }

                    $map22=array();
                    $map22['ship_tcode']=$data['ship_tcode'];
                    $map22['ship_unitcode']=session('unitcode');
					$map22['ship_deliver']=0;  
                    $map22['ship_id'] = array('NEQ',$data['ship_id']);
                    $data22=$Shipment->where($map22)->find();
                    if(is_not_null($data22)){

                    }else{
                        $map33=array();
                        $map33['chai_barcode']=$data['ship_tcode'];
                        $map33['chai_unitcode']=session('unitcode');
						$map33['chai_deliver'] = 0;
                        $Chaibox->where($map33)->delete(); 
                    }
                }
            }
             
            //记录日志 begin
            $log_arr=array(
                        'log_qyid'=>session('qyid'),
                        'log_user'=>session('qyuser'),
                        'log_qycode'=>session('unitcode'),
                        'log_action'=>'删除出货记录',
						'log_type'=>1, //0-系统 1-企业 2-经销商 3-消费者
                        'log_addtime'=>time(),
                        'log_ip'=>real_ip(),
                        'log_link'=>__SELF__,
                        'log_remark'=>json_encode($data)
                        );
            save_log($log_arr);
            //记录日志 end
            $Shipment->where($map)->delete(); 
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
        $this->check_qypurview('30006',1);

        $map['su_unitcode']=session('unitcode');
		$map['su_belong']=0;
		$map['su_username']=array('neq','');
        $Qysubuser = M('Qysubuser');
        $list = $Qysubuser->where($map)->order('su_id DESC')->select();
        $this->assign('qysubuserlist', $list);

		
        $this->assign('curr', 'shipment_list');
        $this->display('appsubuserlist');
    }
	//子用户添加 用于APP出货扫描 
	public function appsubuseradd(){
		$this->check_qypurview('30006',1);
		
		$data['su_id']=0;
		$this->assign('mtitle', '添加用户');
        $this->assign('curr', 'shipment_list');
		$this->assign('subuserinfo', $data);
        $this->display('appsubuseradd');
	}
	
    //子用户修改 用于APP出货扫描 
    public function appsubuseredit(){
        $this->check_qypurview('30006',1);
		
        $map['su_id']=intval(I('get.su_id',0));
		$map['su_unitcode']=session('unitcode');
		
        $Qysubuser= M('Qysubuser');
        $data=$Qysubuser->where($map)->find();
		
        if($data){
        }else{
            $this->error('没有该记录');
        }
        
        $this->assign('subuserinfo', $data);
        $this->assign('curr', 'shipment_list');
        $this->assign('mtitle', '修改用户');

        $this->display('appsubuseradd');
    }
	
    //保存子用户 用于APP出货扫描 
    public function appsubuseradd_save(){
		$this->check_qypurview('30006',1);
		
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
				$this->success('修改成功',U('Mp/Shipment/appsubuserlist'),1);
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
                   $this->success('添加成功',U('Mp/Shipment/appsubuserlist'),1);
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
        $this->check_qypurview('30006',1);

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
        $this->check_qypurview('30006',1);

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
            $map['ship_pro']=$pro_id;
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
            $map['ship_deliver']=$data2['dl_id'];
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
            $where['ship_number']=array('LIKE', '%'.$keyword.'%');
            $where['ship_barcode']=array('LIKE', '%'.$keyword.'%');
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
			
			$map['ship_date']=array('between',array($begintime,$endtime));
			
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

        $map['ship_unitcode']=session('unitcode');
		if(!isset($map['ship_deliver'])){
           $map['ship_deliver']=array('GT',0); //出货方 
		}
        $Shipment = M('Shipment');
        $count = $Shipment->where($map)->count();
        $Page = new \Think\Page($count, C('PAGE_SIZE'));
        $show = $Page->show();
        $list = $Shipment->where($map)->order('ship_date DESC')->limit(($Page->firstRow . ',') . $Page->listRows)->select();
        $Product = M('Product');
        $Dealer = M('Dealer');
        foreach($list as $k=>$v){ 
            $map2=array();
            $map2['pro_unitcode']=session('unitcode');
            $map2['pro_id'] = $v['ship_pro'];
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
            $map2['dl_id'] = $v['ship_dealer'];
            $Dealerinfo = $Dealer->where($map2)->find();
            if($Dealerinfo){
                $list[$k]['dl_name']=$Dealerinfo['dl_name'].'('.$Dealerinfo['dl_username'].')';
            }else{
                  $list[$k]['dl_name']='未知';
            }
            
			//发货代理
            $map2=array();
            $map2['dl_unitcode']=session('unitcode');
            $map2['dl_id'] = $v['ship_deliver'];
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