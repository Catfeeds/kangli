<?php
namespace Zxapi\Controller;
use Think\Controller;
/* */
class StorageController extends CommController {
	//扫描条码
	public function index()
	{
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
		$Storage= M('Storage');
		$Storchaibox= M('Storchaibox');
        $barcode=array();

		//检测该条码是否已录入
		$map['stor_unitcode']=$this->qycode;
		$map['stor_barcode'] = $brcode;
		$data=$Storage->where($map)->find();
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
		$map['stor_unitcode']=$this->qycode;
		$map['stor_barcode'] = $brcode;
		$data=$Storage->where($map)->find();
        if(is_not_null($data)){
            $msg='条码 '.$brcode.' 已存在';
			$barcode=array();
			goto gotoEND;
			exit;
        }
        //检测是否拆箱
		$map2=array();
        $map2['chai_unitcode']=$this->qycode;
        $map2['chai_barcode'] = $brcode;
        $data2=$Storchaibox->where($map2)->find();

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


	public function storinscanset(){
		//获取仓库
		$warehouselist=array();
		$map=array();
		$map['wh_unitcode']=$this->qycode;
		$Warehouse = M('Warehouse');
		$list = $Warehouse->where($map)->order('wh_id ASC')->select();
		if ($list){
			foreach($list as $k=>$v){ 
		   		$warehouselist[$k]['value']=$v['wh_id'];
		   		$warehouselist[$k]['text']=$v['wh_name'];
			}
		}else
		{
			$msg='请添加仓库';
			goto gotoEND;
			exit;
		}	
		
		//获取产品分类
		$productlist=array();
		$level=1;
		$map=array();
		$map['protype_unitcode']=$this->qycode;
		$map['protype_iswho']=0;
		$Protype = M('Protype');
		$list = $Protype->where($map)->order('protype_id ASC')->select();

		if ($list){
		foreach($list as $k=>$v){
			$map1=array();
			$map1['pro_unitcode']=$this->qycode;
			$map1['pro_active'] = 1;
			$map1['pro_typeid']=$v['protype_id'];
   //      	if($typeid>0){
   //          	$son_type_id=get_son_type_id($typeid);
   //          	if(strpos($son_type_id,',')>0){
   //             	$map['pro_typeid']=array('IN',explode(',',$son_type_id));
   //          	}else{
   //             	$map['pro_typeid']=$typeid;
   //          	}
	// }
			$Product = M('Product');
			$list1 = $Product->where($map1)->order('pro_number ASC')->select();
			if ($list1){
				$prolist=array();
				$level=2;
				foreach($list1 as $k1=>$v1){ 
		   			$prolist[$k1]['value']=$v1['pro_id'];
		   			$prolist[$k1]['text']=$v1['pro_name'];
				}
				$productlist[$k]['value']=$v['protype_id'];
		   		$productlist[$k]['text']=$v['protype_name'];
		   		$productlist[$k]['children']=$prolist;
			}
		}

		//获取产品颜色尺码
		$proattrlist=array();
		$levelattr=1;
		$mapyf=array();
		$mapyf['attr_unitcode']=$this->qycode;
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
						$mapyfs['attr_unitcode']=$this->qycode;
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
		if ($productlist){
			$msg=array('login'=>'1','stat'=>'1','warehouse'=>$warehouselist,'products'=>$productlist,'level'=>$level,'proattrlist'=>$proattrlist,'levelattr'=>$levelattr);
			echo json_encode($msg);
			exit;
		}else
		{
			$msg='请添加产品';
			goto gotoEND;
			exit;
		}
		}else
		{
			$msg='请添加产品类型';
			goto gotoEND;
			exit;
		}

		
		/////////////
		gotoEND:
		
		$msg=array('login'=>'1','stat'=>'0','msg'=>$msg);
		echo json_encode($msg);
		exit;	
	}


	//确定入库
	public function storcomfirm(){
		$username=$this->subusername;
		 //是否有冒号 有冒号是新方式 没冒号是以前的方式 目前是兼容，迟点会取消以前方式
		if(strpos($username,':')===false){
			$qy_username='';
			$sub_username=$username;
		}else{
			$qy_username_arr=explode(":", $username);
			reset($qy_username_arr);
			$qy_username = current($qy_username_arr);
			$sub_username= end($qy_username_arr);
		}


		 $brcodeObj=I('post.scancode','',false);
		 // if (substr($brcodeObj,0,3) == pack("CCC",0xef,0xbb,0xbf)) { 
   //  		$brcodeObj =substr($brcodeObj, 3); 
		 // }
		 $json=json_decode($brcodeObj,true);
		if (!is_not_null($json))
		 {
			$msg='参数有错！';
			goto gotoEND;
			exit;
		 }
		 $stor_time=time();
		 $stornumber = $json["stornumber"];
		 $storcheck = $json["storcheck"];
		 $storcheckid = $json["storcheckid"];
		 $procheck = $json["procheck"];
		 $procheckid = $json["procheckid"];
		 $proattrcolor = $json["proattrcolor"];
		 $proattrsize = $json["proattrsize"];
		 $proattrcheckid = $json["proattrcheckid"];
		 $prodate = $json["prodate"];
		 $batchnum = $json["batchnum"];
		 $remark = $json["remark"];
 		 $codeArr = $json["codescanarr"];
		 if (!is_not_null($stornumber))
		 {
		 	$msg='请填写入库单号'.$stornumber;
			goto gotoEND;
			exit;
		 }
		  if (intval($storcheckid)<=0)
		 {
		 	$msg='请选择仓库';
			goto gotoEND;
			exit;
		 }
		 if (intval($procheckid)<=0)
		 {
		 	$msg='请选择产品';
			goto gotoEND;
			exit;
		 }
		if (!is_not_null($prodate))
		 {
		 	$prodate='';
		 }
		if (!is_not_null($batchnum))
		 {
		 	$batchnum='';
		 }

		 if (!is_not_null($codeArr)){
		 	$msg='没有扫描纪录';
			goto gotoEND;
		 	exit; 
		 }else
		 {
		 	$brcarr=array();
			$success=0; 
			$fail=0; 
			$kk=0;
			$scanprocount=0; //已扫产品数
		 	$Storchaibox= M('Storchaibox');
		    $Storage= M('Storage');
		    $brcode="";
		    foreach($codeArr as $v=>$k){
		    	if(is_not_null($k["brcode"])){
		    		$brcode=$k["brcode"];
					if(!preg_match("/^[a-zA-Z0-9]{4,30}$/",$brcode)){
                        $brcarr[$kk]['barcode']=$brcode;
                        $brcarr[$kk]['error']='<span style="color:#FF0000">添加条码 '.htmlspecialchars($brcode).' 出错，条码应由数字字母组成</span>';
						$brcarr[$kk]['qty']=0;
						$fail=$fail+1;
						$kk=$kk+1;
						continue;
					}
					//检测该条码是否已被使用
					$map2=array();
					$data2=array();
					$map2['stor_unitcode']=$this->qycode;
					$map2['stor_barcode'] = $brcode;

					$data2=$Storage->where($map2)->find();
					if($data2){
						$brcarr[$kk]['barcode']=$brcode;
						$brcarr[$kk]['error']='<span style="color:#FF0000">添加条码 '.htmlspecialchars($brcode).' 出错，该条码已使用</span>';
						$brcarr[$kk]['qty']=0;
						$fail=$fail+1;
						$kk=$kk+1;
						continue;
					}

					//检测是否已发行
					$barcode=wlcode_to_packinfo($brcode,$this->qycode);	
					if(!is_not_null($barcode)){
						$brcarr[$kk]['barcode']=$brcode;
						$brcarr[$kk]['error']='<span style="color:#FF0000">添加条码 '.htmlspecialchars($brcode).' 出错，该条码不存在或还没发行</span>';
						$brcarr[$kk]['qty']=0;
						$fail=$fail+1;
						$kk=$kk+1;
						continue;
					}

					//检测该条码是否已被使用2
					$map2=array();
					$where2=array();
					$data2=array();
					if($barcode['code']!=''){
						$where2[]=array('EQ',$barcode['code']);
					}
					if($barcode['tcode']!='' && $barcode['tcode']!=$barcode['code']){
						$where2[]=array('EQ',$barcode['tcode']);
					}
					if($barcode['ucode']!='' && $barcode['ucode']!=$barcode['code'] && $barcode['ucode']!=$barcode['tcode']){
						$where2[]=array('EQ',$barcode['ucode']);
					}
					$where2[]='or';
					$map2['stor_barcode'] = $where2;
					$map2['stor_unitcode']=$this->qycode;

					$data2=$Storage->where($map2)->find();
					if($data2){
						$brcarr[$kk]['barcode']=$brcode;
						$brcarr[$kk]['error']='<span style="color:#FF0000">添加条码 '.htmlspecialchars($brcode).' 出错，该条码已使用</span>';
						$brcarr[$kk]['qty']=0;
						$fail=$fail+1;
						$kk=$kk+1;
						continue;
					}
					
					//检测是否拆箱
					$map2=array();
					$data2=array();
					$map2['chai_unitcode']=$this->qycode;
					$map2['chai_barcode'] = $brcode;

					$data2=$Storchaibox->where($map2)->find();
					if($data2){
						$brcarr[$kk]['barcode']=$brcode;
						$brcarr[$kk]['error']='<span style="color:#FF0000">添加条码 '.htmlspecialchars($brcode).' 出错，该条码已经拆箱，不能再使用</span>';
						$brcarr[$kk]['qty']=0;
						$fail=$fail+1;
						$kk=$kk+1;
						continue;
					}

					//保存记录
					if(is_not_null($barcode)){
						$insert=array();
						$insert['stor_unitcode']=$this->qycode;
						$insert['stor_number']=$stornumber;
						$insert['stor_pro']=$procheckid;
						$insert['stor_whid']=$storcheckid;
						$insert['stor_proqty']=$barcode['qty'];
						$insert['stor_barcode']=$brcode;
						$insert['stor_date']=$stor_time;
						$insert['stor_ucode']=$barcode['ucode'];
						$insert['stor_tcode']=$barcode['tcode'];
						$insert['stor_remark']=$remark;
						$insert['stor_cztype']=1;//操作类型 0-企业主账户  1-企业子管理用户  2-经销商
						$insert['stor_czid']=$this->subuserid;
						$insert['stor_czuser']=$sub_username;
						$insert['stor_prodate']=$prodate;
						$insert['stor_batchnum']=$batchnum;
						$insert['stor_isship']=0;
						$insert['stor_attrid']=$proattrcheckid;
						$insert['stor_color']=$proattrcolor;
						$insert['stor_size']=$proattrsize;
						
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
											'log_qyid'=>session('subuser_id'),
											'log_user'=>session('subuser_name'),
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
								$brcarr[$kk]['barcode']=$brcode;
								$brcarr[$kk]['error']='添加条码 <b>'.$brcode.' </b>成功。';
								$brcarr[$kk]['qty']=$barcode['qty'];
								$success=$success+1;
								$scanprocount=$scanprocount+$barcode['qty'];
								$kk=$kk+1;
								continue;
							}else{
								$brcarr[$kk]['barcode']=$brcode;
								$brcarr[$kk]['error']='<span style="color:#FF0000">添加条码 '.$brcode.'出错。条码不正确</span>';
								$brcarr[$kk]['qty']=0;
								$fail=$fail+1;
								$kk=$kk+1;
								continue;
							}
						}else{
							$brcarr[$kk]['barcode']=$brcode;
							$brcarr[$kk]['error']='<span style="color:#FF0000">添加条码 '.$brcode.'出错。条码不正确</span>';
							$brcarr[$kk]['qty']=0;
							$fail=$fail+1;
							$kk=$kk+1;
							continue;
						}	
					}else{
						$brcarr[$kk]['barcode']=$brcode;
						$brcarr[$kk]['error']='<span style="color:#FF0000">添加条码 '.htmlspecialchars($brcode).' 出错，你没有该条码操作权限</span>';
						$brcarr[$kk]['qty']=0;
						$fail=$fail+1;
						$kk=$kk+1;
						continue;
					}
		    	}
		    }

			$msg=array('login'=>'1','stat'=>'1','success'=>$success,'fail'=>$fail,'scanprocount'=>$scanprocount,'list'=>$brcarr);
			echo json_encode($msg);
			exit; 
		 }
		 ///////////
		gotoEND:
		$msg=array('login'=>'1','stat'=>'0','msg'=>$msg);
		echo json_encode($msg);
		exit;	
	}

	public function storlist()
	{

		$maxid=intval(I('post.maxid',0));
		$minid=intval(I('post.minid',0));

		$Storage= M('Storage');
        $map=array();
        $map['stor_unitcode']=$this->qycode;
        $map['stor_cztype']=1;     //0-企业主账户  1-企业子管理用户  2-经销商
		$map['stor_czid']=$this->subuserid;

		if($maxid==0 && $minid==0){		
		}else if($maxid>0){
			$map['stor_id']=array('GT',$maxid);
		}else if($minid>0){
			$map['stor_id']=array('LT',$minid);
		}
		$list = $Storage->where($map)->order('stor_id DESC')->limit(20)->select();
		// var_dump($list);
		//-------------------------------
		$newlist=array();
		$Product = M('Product');
		$Qysubuser= M('Qysubuser');
		foreach($list as $k=>$v){ 
			$newlist[$k]['stor_id']=$v['stor_id'];
		    $newlist[$k]['stor_barcode']=$v['stor_barcode'];
			$newlist[$k]['stor_date']=date('Y-m-d',$v['stor_date']);
			$newlist[$k]['stor_number']=$v['stor_number'];

 			$map2=array();
            $map2['dl_unitcode']=$this->qycode;
            $map2['su_id'] = $v['stor_czid'];
            $Qyuserinfo = $Qysubuser->where($map2)->find();
            if($Qyuserinfo){
                  $newlist[$k]['stor_user']=$Qyuserinfo['su_name'];
            }else{
                  $newlist[$k]['stor_user']=$v['stor_czuser'];
            }

            $map2=array();
            $map2['pro_unitcode']=$this->qycode;
            $map2['pro_id'] = $v['stor_pro'];
            $Proinfo = $Product->where($map2)->find();
            if($Proinfo){
            	  $storid=$v['stor_attrid'];
            	  if (is_not_null($storid))
            	  {
                   	 $newlist[$k]['pro_name']=$Proinfo['pro_name'].'--'.$v['stor_size'].'('.$v['stor_color'].')';
            	  }
               	  else
               	  	 $newlist[$k]['pro_name']=$Proinfo['pro_name'];
            }else{
                  $newlist[$k]['pro_name']='-';
            }
		}

		if($maxid==0 && $minid==0 && count($newlist)>0){
			reset($newlist);
			$maxid = current($newlist)['stor_id'];
			$minid = end($newlist)['stor_id'];
		}else if($maxid>0){
			if(count($newlist)>0){
				reset($newlist);
				$maxid = current($newlist)['stor_id'];
				$minid=0;
			}else{
				$maxid=0;
				$minid=0;
			}
		}else if($minid>0){
			if(count($newlist)>0){
				reset($newlist);
				$maxid=0;
				$minid = end($newlist)['stor_id'];
			}else{
				$maxid=0;
				$minid=0;
			}
		}else{
			$maxid=0;
			$minid=0;
		}
		
		$msg=array('login'=>'1','stat'=>'1','list'=>$newlist,'maxid'=>$maxid,'minid'=>$minid);
		echo json_encode($msg);
		exit;	
	}

	public function stordetail()
	{
		$stor_id=intval(I('post.stor_id',0));

		 if($stor_id<=0){
			$msg=array('login'=>'1','stat'=>'0','msg'=>'没有该记录或已删除');
			echo json_encode($msg);
			exit;
		}

		$Storage= M('Storage');
        $map=array();
        $map['stor_unitcode']=$this->qycode;
		$map['stor_id']=$stor_id;
        $data=$Storage->where($map)->find();
		$Warehouse = M('Warehouse');
		$Product = M('Product');
		$Qysubuser= M('Qysubuser');
        if($data){
            $map2=array();
            $map2['pro_unitcode']=$this->qycode;
            $map2['pro_id'] = $data['stor_pro'];
            $Proinfo = $Product->where($map2)->find();

			$data['stor_date']=date('Y-m-d',$data['stor_date']);

            if($Proinfo){
					 $data['pro_name']=$Proinfo['pro_name'].'('.$Proinfo['pro_number'].')';
            }else{
                  $data['pro_name']='';
            }
			
			$map2=array();
            $map2['dl_unitcode']=$this->qycode;
            $map2['su_id'] = $data['stor_czid'];
            $Qyuserinfo = $Qysubuser->where($map2)->find();
            if($Qyuserinfo){
                  $data['stor_user']=$Qyuserinfo['su_name'];
            }else{
                  $data['stor_user']=$v['stor_czuser'];
            }
			
            $map2=array();
            $map2['wh_unitcode']=$this->qycode;
            $map2['wh_id'] = $data['stor_whid'];
            $warehouse = $Warehouse->where($map2)->find();

            if($warehouse){
                  $data['warehouse']=$warehouse['wh_name'];
            }else{
                  $data['warehouse']='';
            }
			
			// if($data['stor_isship']>0 && $this->checksu_qypurview('16005',0)){
			if($data['stor_isship']>0){
				$isstordelete=1;
			}else{
				$isstordelete=0;
			}
			
			$msg=array('login'=>'1','stat'=>'1','detail'=>$data);
			echo json_encode($msg);
			exit;	
        }else{
        	$msg='没有该记录';
			goto gotoEND;
			exit;
		}
	
		 ///////////
		gotoEND:
		$msg=array('login'=>'1','stat'=>'0','msg'=>$msg);
		echo json_encode($msg);
		exit;	
	}
}