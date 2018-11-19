<?php
namespace Mp\Controller;
use Think\Controller;
//查询
class ChaxunController extends CommController {
    public function index(){
        exit;
    }
	//防伪码查询记录
    public function fwlist(){
        $this->check_qypurview('80002',1);
        
        if (IS_POST) {
            $keyword=trim(strip_tags(htmlspecialchars_decode(I('post.keyword',''))));
        }else{
            $keyword=trim(strip_tags(htmlspecialchars_decode(I('get.keyword',''))));
        }

        if(!preg_match("/^[0-9]{4,27}$/",$keyword)){
            $keyword='';
        }

        if($keyword!=''){
            $keyword=sub_str($keyword,27,false);
            $map['fwcode']=$keyword;
            $parameter['keyword']=urlencode($keyword);
        }
		$statu=intval(I('param.statu',0));
        $begintime=I('param.begintime','');
        $endtime=I('param.endtime','');
		
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
			
            $map['querydate']=array('between',array(date('Y-m-d H:i:s',$begintime),date('Y-m-d H:i:s',$endtime)));

            $parameter['begintime']=urlencode(date('Y-m-d',$begintime));
            $parameter['endtime']=urlencode(date('Y-m-d',$endtime));
			
		}else{
            $begintime='';
            $endtime='';
		}
		
        if($statu==1){
			$map['querystatu']=array('IN','正确,合法');
			$parameter['statu']=$statu;
		}else if($statu==2){
			$map['querystatu']=array('IN','重复,多次');
			$parameter['statu']=$statu;
		}

        $Tellist = M('Tellist');
        $map['unitcode']=session('unitcode');
        $count = $Tellist->where($map)->count();
        $Page = new \Think\Page($count, C('PAGE_SIZE'),$parameter);
        $show = $Page->show();
        $list = $Tellist->where($map)->order('querydate DESC')->limit(($Page->firstRow . ',') . $Page->listRows)->select();

        foreach($list as $k=>$v){

            if($v['qutype']==1){
                $list[$k]['qutypestr']='电话';
            }elseif($v['qutype']==2){
                $list[$k]['qutypestr']='短信';
            }elseif($v['qutype']==3){
                $list[$k]['qutypestr']='网络';  
            }else{
                $list[$k]['qutypestr']='';
            }
            if($v['querystatu']=='正确' || $v['querystatu']=='合法'){
                $list[$k]['querystatu']='首次'; 
            }else{
                $list[$k]['querystatu']='重复'; 
            }

        }
        $this->assign('list', $list);
        if($begintime!=''){
			$this->assign('begintime', date('Y-m-d',$begintime));
		}else{
			$this->assign('begintime', '');
		}
		if($endtime!=''){
			$this->assign('endtime', date('Y-m-d',$endtime));
		}else{
			$this->assign('endtime', '');
		}
        
        $this->assign('keyword', $keyword);
        $this->assign('page', $show);
        $this->assign('curr', 'fwlist');
		$this->assign('statu', $statu);
		$this->assign('pagecount', $count);

        $this->display('list');
    }

    //防窜查询
    public function fangcuan(){
        $this->check_qypurview('80001',1);
        
        $map['qy_code']=session('unitcode');
        $Qyinfo = M('Qyinfo');
		$data=$Qyinfo->where($map)->find();
        if($data){
			$qy_folder=$data['qy_folder'];
		}else{
            $this->error('没有该记录');
        }
		$qyfangcuan_pic_str='';
		if($this->check_qypurview('80003',0)){
			//生成二维码
			$signature=MD5(MD5(session('unitcode').session('unitcode')));
			$filepath = BASE_PATH.'/Public/uploads/product/'.session('unitcode').'/qyfangcuan.png';
			if(@is_dir(BASE_PATH.'/Public/uploads/product/'.session('unitcode').'/') === false){
	           @mkdir(BASE_PATH.'/Public/uploads/product/'.session('unitcode').'/');
	        }
	        $http_host=strtolower(htmlspecialchars('http://'.$_SERVER['HTTP_HOST'])).WWW_WEBROOT;
			$link=$http_host.$qy_folder.'/fangcuan/index/qycode/'.session('unitcode').'/sture/'.$signature;
			make_ercode($link,$filepath,'','');
			
			$qyfangcuan_pic_str='<img src="'.__ROOT__.'/Public/uploads/product/'.session('unitcode').'/qyfangcuan.png"  border="0"   >';
		}
		$this->assign('qyfangcuan_pic_str', $qyfangcuan_pic_str);
        $this->assign('curr', 'fangcuan');
        $this->display('fangcuan');
    }
    
	
	//防窜密码设置
    public function fangcuan_setpwd(){
        $this->check_qypurview('80003',1);
        if (!IS_POST) {
             header('HTTP/1.0 404 Not Found');
             echo'error:404';
             exit;
        }
        $fcpwd=I('post.fcpwd','');
        if($fcpwd==''){
            $this->error('请输入设置密码','',2);
        }
		
        $map['qy_code']=session('unitcode');
        $Qyinfo = M('Qyinfo');
        $data=$Qyinfo->where($map)->find();
        if($data){
            $data2['qy_fchpwd'] =MD5(MD5($fcpwd));
            $Qyinfo->where($map)->save($data2);
            $this->success('设置成功',U('Mp/Chaxun/fangcuan'),1);
        }else{
            $this->error('没有该记录');
        }
	}
	
	//防窜查询结果 通过物流码查
    public function fangcuan_cha(){
        $this->check_qypurview('80001',1);

        if (!IS_POST) {
             header('HTTP/1.0 404 Not Found');
             echo'error:404';
             exit;
        }
        $ship_barcode=I('post.wlcode','');
        if($ship_barcode==''){
            $this->error('请输入物流码','',2);
        }

         //检测是否已发行
        $barcode=wlcode_to_packinfo($ship_barcode,session('unitcode'));
        
        if(!is_not_null($barcode)){
            $this->error('条码还没发行','',2);
        }

        //条码出货流向
        $map=array();
        $where=array();
        $Shipment= M('Shipment');
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
		$map['ship_deliver']=0;   //ship_deliver--出货方   ship_dealer--收货方
        $data=$Shipment->where($map)->find();
        if(is_not_null($data)){
            $Product = M('Product');
            $Dealer = M('Dealer');
            $Warehouse = M('Warehouse');
			
            $map2=array();
            $map2['pro_unitcode']=session('unitcode');
            $map2['pro_id'] = $data['ship_pro'];
            $Proinfo = $Product->where($map2)->find();

            if($Proinfo){
                  $data['pro_name']=$Proinfo['pro_name'];
                  $data['pro_number']=$Proinfo['pro_number'];
            }else{
                  $data['pro_name']='';
                  $data['pro_number']='';
            }
			
            //仓库
			$map2=array();
			$map2['wh_unitcode']=session('unitcode');
			$map2['wh_id'] = $data['ship_whid'];
			$warehouseinfo = $Warehouse->where($map2)->find();

			if($warehouseinfo){
				$data['warehouse']=$warehouseinfo['wh_name'];
			}else{
				$data['warehouse']='';
			}
            $map2=array();
            $map2['dl_unitcode']=session('unitcode');
            $map2['dl_id'] = $data['ship_dealer'];
            $Dealerinfo = $Dealer->where($map2)->find();
            if($Dealerinfo){
                if($this->check_qypurview('90002',0)){
					$data['dl_name']= $Dealerinfo['dl_contact'].'('.wxuserTextDecode2($Dealerinfo['dl_wxnickname']).')';
				}else{
					$data['dl_name']= $Dealerinfo['dl_name'];
				}  
            }else{
                  $data['dl_name']='';
            }
            $barcode['dabiao']='';
            if($barcode['tcode']!='' || $barcode['ucode']!=''){
                if($barcode['tcode']!=$barcode['ucode']){
                    $barcode['dabiao']=$barcode['ucode'].'/'.$barcode['tcode'];
                }else{
                    $barcode['dabiao']=$barcode['ucode'];
                }
            }else{
                $barcode['dabiao']='';
            }
			
			//下级-1
			$map2=array();
			$map2['ship_barcode'] = $where;
            $map2['ship_unitcode']=session('unitcode');
		    $map2['ship_deliver']=$data['ship_dealer'];   //ship_deliver--出货方   ship_dealer--收货方
            $data2=$Shipment->where($map2)->find();
			if(is_not_null($data2)){
				$map22=array();
				$map22['dl_unitcode']=session('unitcode');
				$map22['dl_id'] = $data2['ship_dealer'];
				$Dealerinfo = $Dealer->where($map22)->find();
				if($Dealerinfo){
					if($this->check_qypurview('90002',0)){
						$data2['dl_name']= $Dealerinfo['dl_contact'].'('.wxuserTextDecode2($Dealerinfo['dl_wxnickname']).')';
					}else{
						$data2['dl_name']= $Dealerinfo['dl_name'];
					} 
				}else{
					$data2['dl_name']='';
				}
				$data['sub']=$data2;
			
				//下级-2
				$map3=array();
				$map3['ship_barcode'] = $where;
				$map3['ship_unitcode']=session('unitcode');
				$map3['ship_deliver']=$data2['ship_dealer'];   //ship_deliver--出货方   ship_dealer--收货方
				$data3=$Shipment->where($map3)->find();
				if(is_not_null($data3)){
					$map22=array();
					$map22['dl_unitcode']=session('unitcode');
					$map22['dl_id'] = $data3['ship_dealer'];
					$Dealerinfo = $Dealer->where($map22)->find();
					if($Dealerinfo){						  
						if($this->check_qypurview('90002',0)){
						    $data3['dl_name']= $Dealerinfo['dl_contact'].'('.wxuserTextDecode2($Dealerinfo['dl_wxnickname']).')';
						}else{
							$data3['dl_name']= $Dealerinfo['dl_name'];
						} 
					}else{
						  $data3['dl_name']='';
					}
				    $data['sub']['sub']=$data3;
					
						//下级-3
						$map4=array();
						$map4['ship_barcode'] = $where;
						$map4['ship_unitcode']=session('unitcode');
						$map4['ship_deliver']=$data3['ship_dealer'];   //ship_deliver--出货方   ship_dealer--收货方
						$data4=$Shipment->where($map4)->find();
						if(is_not_null($data4)){
							$map22=array();
							$map22['dl_unitcode']=session('unitcode');
							$map22['dl_id'] = $data4['ship_dealer'];
							$Dealerinfo = $Dealer->where($map22)->find();
							if($Dealerinfo){
								if($this->check_qypurview('90002',0)){
									$data4['dl_name']= $Dealerinfo['dl_contact'].'('.wxuserTextDecode2($Dealerinfo['dl_wxnickname']).')';
								}else{
									$data4['dl_name']= $Dealerinfo['dl_name'];
								}
							}else{
								$data4['dl_name']='';
							}
							$data['sub']['sub']['sub']=$data4;
							
							    //下级-4
								$map5=array();
								$map5['ship_barcode'] = $where;
								$map5['ship_unitcode']=session('unitcode');
								$map5['ship_deliver']=$data4['ship_dealer'];   //ship_deliver--出货方   ship_dealer--收货方
								$data5=$Shipment->where($map5)->find();
								if(is_not_null($data5)){
									$map22=array();
									$map22['dl_unitcode']=session('unitcode');
									$map22['dl_id'] = $data5['ship_dealer'];
									$Dealerinfo = $Dealer->where($map22)->find();
									if($Dealerinfo){
										if($this->check_qypurview('90002',0)){
											$data5['dl_name']= $Dealerinfo['dl_contact'].'('.wxuserTextDecode2($Dealerinfo['dl_wxnickname']).')';
										}else{
											$data5['dl_name']= $Dealerinfo['dl_name'];
										}
									}else{
										  $data5['dl_name']='';
									}
									$data['sub']['sub']['sub']['sub']=$data5;
								}else{
									$data['sub']['sub']['sub']['sub']=array();
								}
						}else{
							$data['sub']['sub']['sub']=array();
						}
				}else{
				    $data['sub']['sub']=array();
			    }
			}else{
				$data['sub']=array();
			}
			
        }else{
			//检测是否拆箱
			$map2=array();
			$Chaibox= M('Chaibox');
			$map2['chai_unitcode']=session('unitcode');
			$map2['chai_barcode'] = $ship_barcode;
			$map2['chai_deliver'] = 0;
			$data2=$Chaibox->where($map2)->find();

			if($data2){
				$this->error('该条码已经拆箱出货','',2);
			}
			
            $this->error('条码还没出货','',2);
        }


        $this->assign('shipmentinfo', $data);
        $this->assign('barcode', $barcode);
        $this->assign('curr', 'fangcuan');

        $this->display('fangcuan_res');
    }

	//防窜查询结果 通过防伪码查
    public function fangcuan_fwcha(){
        $this->check_qypurview('80004',1);

        if (!IS_POST) {
             header('HTTP/1.0 404 Not Found');
             echo'error:404';
             exit;
        }
        $fwcode=I('post.fwcode','');
		
		if($fwcode!=''){
            if(!preg_match("/^[0-9]{8,30}$/",$fwcode)){
				$this->error('请正确输入防伪码','',2);
            }
        }else{
            $this->error('请输入防伪码','',2);
        }
		
		$map=array();
		$qycode=session('unitcode');
		$codelen=strlen($fwcode)-4;
		$Model=M();
		$map['a.qy_code']=array('exp','=b.unitcode');
		$map['a.qy_active']=1;
		$map['b.unitcode']=$qycode;
		$map['b.codelen']=$codelen;
		$qydata=$Model->field('a.qy_id,a.qy_code,a.qy_fwkey,a.qy_fwsecret,a.qy_querytimes,b.*')->table('fw_qyinfo a,fw_cust b')->where($map)->find();
		if($qydata){
			$mlength=$qydata['mlength'];
			$msnlength=$qydata['msnlength'];
			$sntype = substr($qydata['sntype'],0,1);
			$snpr = $qydata['snpr']; //前缀
		}else{
			$this->error('请正确输入防伪码','',2);
		}
		
		//记录日志 begin
		$log_arr=array(
			'log_qyid'=>session('qyid'),
			'log_user'=>session('qyuser'),
			'log_qycode'=>session('unitcode'),
			'log_action'=>'由防伪码查防窜',
			'log_type'=>1, //0-系统 1-企业 2-经销商 3-消费者
			'log_addtime'=>time(),
			'log_ip'=>real_ip(),
			'log_link'=>__SELF__,
			'log_remark'=>json_encode($fwcode)
			);
		save_log($log_arr);
		//记录日志 end
					
		//由防伪码找k
		$myk=fwcode_to_k($fwcode,$qycode,$mlength);
		if($myk===false || $myk<=0){
			$this->error('你输入的防伪码不存在','',2);
		}

		 //由防伪码找物流信息
		$barcode=fw_to_wlinfo($fwcode,$myk,$sntype,$snpr,$msnlength);

		if($barcode===false){
			$this->error('你输入的防伪码不存在或还没发行','',2);
		}
		if($barcode['qty']<=0){
			$this->error('你输入的防伪码不存在或还没发行','',2);
		}


        //条码出货流向 是否出货
        $map=array();
        $where=array();
        $Shipment= M('Shipment');
		
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
        $map['ship_unitcode']=session('unitcode');
		$map['ship_deliver']=0;   //ship_deliver--出货方   ship_dealer--收货方
        $data=$Shipment->where($map)->find();
		

        if(is_not_null($data)){
            $Product = M('Product');
            $Dealer = M('Dealer');
            $Warehouse = M('Warehouse');
			
            $map2=array();
            $map2['pro_unitcode']=session('unitcode');
            $map2['pro_id'] = $data['ship_pro'];
            $Proinfo = $Product->where($map2)->find();

            if($Proinfo){
                  $data['pro_name']=$Proinfo['pro_name'];
                  $data['pro_number']=$Proinfo['pro_number'];
            }else{
                  $data['pro_name']='';
                  $data['pro_number']='';
            }
			
            //仓库
			$map2=array();
			$map2['wh_unitcode']=session('unitcode');
			$map2['wh_id'] = $data['ship_whid'];
			$warehouseinfo = $Warehouse->where($map2)->find();

			if($warehouseinfo){
				$data['warehouse']=$warehouseinfo['wh_name'];
			}else{
				$data['warehouse']='';
			}
			//经销商
            $map2=array();
            $map2['dl_unitcode']=session('unitcode');
            $map2['dl_id'] = $data['ship_dealer'];
            $Dealerinfo = $Dealer->where($map2)->find();
            if($Dealerinfo){
                if($this->check_qypurview('90002',0)){
					$data['dl_name']= $Dealerinfo['dl_contact'].'('.wxuserTextDecode2($Dealerinfo['dl_wxnickname']).')';
				}else{
					$data['dl_name']= $Dealerinfo['dl_name'];
				}  
            }else{
                  $data['dl_name']='';
            }
            $barcode['dabiao']='';
            if($barcode['tcode']!='' || $barcode['ucode']!=''){
                if($barcode['tcode']!=$barcode['ucode']){
                    $barcode['dabiao']=$barcode['ucode'].'/'.$barcode['tcode'];
                }else{
                    $barcode['dabiao']=$barcode['ucode'];
                }
            }else{
                $barcode['dabiao']='';
            }
			
			//下级-1
			$map2=array();
			$map2['ship_barcode'] = $where;
            $map2['ship_unitcode']=session('unitcode');
		    $map2['ship_deliver']=$data['ship_dealer'];   //ship_deliver--出货方   ship_dealer--收货方
            $data2=$Shipment->where($map2)->find();
			if(is_not_null($data2)){
				$map22=array();
				$map22['dl_unitcode']=session('unitcode');
				$map22['dl_id'] = $data2['ship_dealer'];
				$Dealerinfo = $Dealer->where($map22)->find();
				if($Dealerinfo){
					if($this->check_qypurview('90002',0)){
						$data2['dl_name']= $Dealerinfo['dl_contact'].'('.wxuserTextDecode2($Dealerinfo['dl_wxnickname']).')';
					}else{
						$data2['dl_name']= $Dealerinfo['dl_name'];
					} 
				}else{
					$data2['dl_name']='';
				}
				$data['sub']=$data2;
			
				//下级-2
				$map3=array();
				$map3['ship_barcode'] = $where;
				$map3['ship_unitcode']=session('unitcode');
				$map3['ship_deliver']=$data2['ship_dealer'];   //ship_deliver--出货方   ship_dealer--收货方
				$data3=$Shipment->where($map3)->find();
				if(is_not_null($data3)){
					$map22=array();
					$map22['dl_unitcode']=session('unitcode');
					$map22['dl_id'] = $data3['ship_dealer'];
					$Dealerinfo = $Dealer->where($map22)->find();
					if($Dealerinfo){						  
						if($this->check_qypurview('90002',0)){
						    $data3['dl_name']= $Dealerinfo['dl_contact'].'('.wxuserTextDecode2($Dealerinfo['dl_wxnickname']).')';
						}else{
							$data3['dl_name']= $Dealerinfo['dl_name'];
						} 
					}else{
						  $data3['dl_name']='';
					}
				    $data['sub']['sub']=$data3;
					
						//下级-3
						$map4=array();
						$map4['ship_barcode'] = $where;
						$map4['ship_unitcode']=session('unitcode');
						$map4['ship_deliver']=$data3['ship_dealer'];   //ship_deliver--出货方   ship_dealer--收货方
						$data4=$Shipment->where($map4)->find();
						if(is_not_null($data4)){
							$map22=array();
							$map22['dl_unitcode']=session('unitcode');
							$map22['dl_id'] = $data4['ship_dealer'];
							$Dealerinfo = $Dealer->where($map22)->find();
							if($Dealerinfo){
								if($this->check_qypurview('90002',0)){
									$data4['dl_name']= $Dealerinfo['dl_contact'].'('.wxuserTextDecode2($Dealerinfo['dl_wxnickname']).')';
								}else{
									$data4['dl_name']= $Dealerinfo['dl_name'];
								}
							}else{
								$data4['dl_name']='';
							}
							$data['sub']['sub']['sub']=$data4;
							
							    //下级-4
								$map5=array();
								$map5['ship_barcode'] = $where;
								$map5['ship_unitcode']=session('unitcode');
								$map5['ship_deliver']=$data4['ship_dealer'];   //ship_deliver--出货方   ship_dealer--收货方
								$data5=$Shipment->where($map5)->find();
								if(is_not_null($data5)){
									$map22=array();
									$map22['dl_unitcode']=session('unitcode');
									$map22['dl_id'] = $data5['ship_dealer'];
									$Dealerinfo = $Dealer->where($map22)->find();
									if($Dealerinfo){
										if($this->check_qypurview('90002',0)){
											$data5['dl_name']= $Dealerinfo['dl_contact'].'('.wxuserTextDecode2($Dealerinfo['dl_wxnickname']).')';
										}else{
											$data5['dl_name']= $Dealerinfo['dl_name'];
										}
									}else{
										  $data5['dl_name']='';
									}
									$data['sub']['sub']['sub']['sub']=$data5;
								}else{
									$data['sub']['sub']['sub']['sub']=array();
								}
						}else{
							$data['sub']['sub']['sub']=array();
						}
				}else{
				    $data['sub']['sub']=array();
			    }
			}else{
				$data['sub']=array();
			}
			
        }else{
			$barcode['dabiao']='';
            if($barcode['tcode']!='' || $barcode['ucode']!=''){
                if($barcode['tcode']!=$barcode['ucode']){
                    $barcode['dabiao']=$barcode['ucode'].'/'.$barcode['tcode'];
                }else{
                    $barcode['dabiao']=$barcode['ucode'];
                }
            }else{
                $barcode['dabiao']='';
            }
			if($barcode['dabiao']!=''){
				$barcode['dabiao']=',大标：'.$barcode['dabiao'];
			}
			
            $this->error('该码还没出货,对应条码：'.$barcode['code'].$barcode['dabiao'],'',6);
        }


        $this->assign('shipmentinfo', $data);
        $this->assign('barcode', $barcode);
		$this->assign('fwcode', $fwcode);
        $this->assign('curr', 'fangcuan');

        $this->display('fangcuan_fwres');
    }

    //=====================================================================================


}