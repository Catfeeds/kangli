<?php
namespace Mp\Controller;
use Think\Controller;
//订单管理
class OrdersController extends CommController {
	//所有订单
    public function index(){
        $this->check_qypurview('13002',1);

		$dlusername=trim(I('param.dlusername',''));
		$begintime=I('param.begintime','');
        $endtime=I('param.endtime','');
        $keyword=trim(strip_tags(htmlspecialchars_decode(I('param.keyword',''))));
		$parameter=array();
		
		$od_oddlid=0; //谁下的订单
        if($dlusername!='' && $dlusername!='请填写下单代理账号'){
            if(!preg_match("/[a-zA-Z0-9_-]{4,20}$/",$dlusername)){
                $this->error('下单代理账号不正确','',1);
            }
			$map2=array();
			$Dealer = M('Dealer');
            $map2['dl_username']=$dlusername;
            $map2['dl_unitcode']=session('unitcode');
            $data2=$Dealer->where($map2)->find();
            if(!$data2){
				$this->error('经销商账号不正确','',1);
			}
            $od_oddlid=$data2['dl_id'];
			$parameter['dlusername']=$dlusername;
			$this->assign('dlusername', $dlusername);
        }else{
			$this->assign('dlusername', '请填写下单代理账号');
		}
		$Orders=M('Orders');
		$map=array();
		$map['od_unitcode']=session('unitcode');
		$map['od_virtualstock']=1; //0--非虚拟库存订单 1--虚拟库存订单
		if($od_oddlid>0){
		    $map['od_oddlid']=$od_oddlid;
		}
		$od_state=I('param.od_state',''); //订单状态
		if($od_state!=''){
			$od_state=intval($od_state);
			
			if($od_state==1 || $od_state==2){
				$map['od_state']=array('in','1,2');
			}else{
				$map['od_state']=$od_state;
			}
			$parameter['od_state']=$od_state;
		}
        if($keyword!=''){
            $keyword=str_replace('[','',$keyword);
            $keyword=str_replace(']','',$keyword);
            $keyword=str_replace('%','',$keyword);
            $keyword=str_replace('_','',$keyword);

            $keyword=sub_str($keyword,25,false);
            $map['od_orderid']=$keyword;
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
			$map['od_addtime']=array('between',array($begintime,$endtime));
			
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
		
		$count = $Orders->where($map)->count();
		$Page = new \Think\Page($count, C('PAGE_SIZE'),$parameter);
        $show = $Page->show();

		$list =$Orders->where($map)->order('od_addtime DESC')->limit(($Page->firstRow . ',') . $Page->listRows)->select();
		
		$Product = M('Product');
		$Orderdetail = M('Orderdetail');
		$Shipment = M('Shipment');
		$Dealer = M('Dealer');
		$imgpath = BASE_PATH.'/Public/uploads/product/';
        foreach($list as $k=>$v){
			//订单详细
			$map2=array();
			$data2=array();
			$map2['oddt_unitcode']=session('unitcode');
			$map2['oddt_odid']=$v['od_id'];
			$data2 = $Orderdetail->where($map2)->order('oddt_id DESC')->limit(100)->select();
			foreach($data2 as $kk=>$vv){
				//产品
				$map3=array();
				$data3=array();
				$map3['pro_id']=$vv['oddt_proid'];
				$map3['pro_unitcode']=session('unitcode');
				$data3=$Product->where($map3)->find();
				if($data3){
					if(is_not_null($data3['pro_pic']) && file_exists($imgpath.$data3['pro_pic'])){
						$data2[$kk]['oddt_propic']=$data3['pro_pic'];
					}else{
						$data2[$kk]['oddt_propic']='';
					}
				}else{
					$data2[$kk]['oddt_propic']='';
				}
				
				//订购数量
				$oddt_totalqty=0; //总订购数
				$oddt_unitsqty=0; //每单位包装的数量
				if($vv['oddt_prodbiao']>0){
					$oddt_unitsqty=$vv['oddt_prodbiao'];
					if($vv['oddt_prozbiao']>0){
						$oddt_unitsqty=$oddt_unitsqty*$vv['oddt_prozbiao'];
					}
					if($vv['oddt_proxbiao']>0){
						$oddt_unitsqty=$oddt_unitsqty*$vv['oddt_proxbiao'];
					}
					$oddt_totalqty=$oddt_unitsqty*$vv['oddt_qty'];
				}else{
					$oddt_totalqty=$vv['oddt_qty'];
				}
				if($oddt_totalqty==0 || $oddt_totalqty==$vv['oddt_qty']){
					$data2[$kk]['oddt_totalqty']='';
				}else{
					$data2[$kk]['oddt_totalqty']='('.$oddt_totalqty.'件)';
				}
				//已发数量
				$map3=array();
				$data3=array();
				$map3['ship_pro']=$vv['oddt_proid'];
				$map3['ship_unitcode']=session('unitcode');
				$map3['ship_odid']=$vv['oddt_odid'];
				$map3['ship_oddtid']=$vv['oddt_id'];
				$map3['ship_dealer']=$v['od_oddlid']; //出货接收方
				$data3=$Shipment->where($map3)->sum('ship_proqty');
				if($data3){
					if($oddt_unitsqty>0){
						$data2[$kk]['oddt_shipqty']=floor($data3/$oddt_unitsqty).$vv['oddt_prounits'].'('.$data3.'件)';
					}else{
						$data2[$kk]['oddt_shipqty']=$data3.$vv['oddt_prounits'];
					}
				}else{
					$data2[$kk]['oddt_shipqty']=0;
				}
			}
			$list[$k]['orderdetail']=$data2;
			$list[$k]['countdetail']=count($data2);
			
			//状态 我的订单状态 以fw_orders表为主
			if($v['od_state']==0){
				$list[$k]['od_state_str']='待确认';
			}else if($v['od_state']==1){
				$list[$k]['od_state_str']='待发货';
			}else if($v['od_state']==2){
				$list[$k]['od_state_str']='部分发货';
			}else if($v['od_state']==3){
				$list[$k]['od_state_str']='已发货';
			}else if($v['od_state']==8){
			    $list[$k]['od_state_str']='已完成';
			}else if($v['od_state']==9){
				$list[$k]['od_state_str']='已取消';
			}else{
				$list[$k]['od_state_str']='未知';
			}
			 
			//允许操作
			$caozuostr='<a href="'.U('./Mp/Orders/orderdetail?od_id='.$v['od_id'].'&odbl_id='.$v['odbl_id'].'').'"  >订单详细</a>　';
			
			//取消订单
			if($v['od_state']==0 || $v['od_state']==1 ){
				//$caozuostr.='<a   href="'.U('./Mp/Orders/cancelorder?od_id='.$v['od_id'].'&od_state='.$od_state.'').'"  >取消订单</a> ';
			}
			
			//删除订单 只有已取消的才能删除
			if($v['od_state']==9 ){
			    $caozuostr.='<a   href="#"  onClick="javascript:var truthBeTold = window.confirm(\'该操作将彻底删除,谨慎操作!\'); if (truthBeTold) window.location.href=\''.U('Mp/Orders/deleteorder?od_id='.$v['od_id']).'\';"  >删除</a> ';
			}
			
			$list[$k]['caozuostr']=$caozuostr;
			
            //下单代理信息
			$map3=array();
			$data3=array();
			$map3['dl_id']=$v['od_oddlid'];
			$map3['dl_unitcode']=session('unitcode');
			$data3=$Dealer->where($map3)->find();
			if($data3){
				$list[$k]['od_dl_name']=$data3['dl_name'];
				$list[$k]['od_dl_username']=$data3['dl_username'];
				$list[$k]['od_dl_tel']=$data3['dl_tel'];
			}else{
				$list[$k]['od_dl_name']='';
				$list[$k]['od_dl_tel']='';
				$list[$k]['od_dl_username']='';
			}
			
			//接单代理信息
			if($v['odbl_rcdlid']>0){
				$map3=array();
				$data3=array();
				$map3['dl_id']=$v['odbl_rcdlid'];
				$map3['dl_unitcode']=session('unitcode');
				$data3=$Dealer->where($map3)->find();
				if($data3){
					$list[$k]['od_rcdl_name']=$data3['dl_name'];
					$list[$k]['od_rcdl_username']=$data3['dl_username'];
					$list[$k]['od_rcdl_tel']=$data3['dl_tel'];
				}else{
					$list[$k]['od_rcdl_name']='';
					$list[$k]['od_rcdl_tel']='';
					$list[$k]['od_rcdl_username']='';
				}
			}else{
				$list[$k]['od_rcdl_name']='总公司';
				$list[$k]['od_rcdl_username']='';
				$list[$k]['od_rcdl_tel']='';
			}
				
		}
		

		$this->assign('page', $show);
		$this->assign('orderlist', $list);
        $this->assign('od_state', $od_state);

        $this->assign('keyword', $keyword);
        $this->assign('page', $show);
        $this->assign('curr', 'order_list');

        $this->display('list');
    }
   
    //订单详细
    public function orderdetail(){
        $this->check_qypurview('13002',1);

		$od_id=intval(I('get.od_id',0));
		// $odbl_id=intval(I('get.odbl_id',0));
		
		if($od_id>0){
			$Orders=M('Orders');
			$map=array();
			$map['od_unitcode']=session('unitcode');
			$map['od_id']=$od_id;
			$data =$Orders->where($map)->find();
			if($data){
				//订单产品详细
				$Orderdetail= M('Orderdetail');
				$Product= M('Product');
				$Shipment= M('Shipment');
				$Dealer= M('Dealer');
				
				$map2=array();
				$data2=array();
				$map2['oddt_unitcode']=session('unitcode');
				$map2['oddt_odid']=$data['od_id'];
				$data2 = $Orderdetail->where($map2)->order('oddt_id DESC')->limit(100)->select();
				$imgpath = BASE_PATH.'/Public/uploads/product/';
				foreach($data2 as $kk=>$vv){
					//产品
					$map3=array();
					$data3=array();
					$map3['pro_id']=$vv['oddt_proid'];
					$map3['pro_unitcode']=session('unitcode');
					$data3=$Product->where($map3)->find();
					if($data3){
						if(is_not_null($data3['pro_pic']) && file_exists($imgpath.$data3['pro_pic'])){
							$data2[$kk]['oddt_propic']=$data3['pro_pic'];
						}else{
							$data2[$kk]['oddt_propic']='';
						}
					}else{
						$data2[$kk]['oddt_propic']='';
					}
					
					//订购数 发货数
					$oddt_totalqty=0;
					$oddt_unitsqty=0;
					if($vv['oddt_prodbiao']>0){
						$oddt_unitsqty=$vv['oddt_prodbiao'];
						
						if($vv['oddt_prozbiao']>0){
							$oddt_unitsqty=$oddt_unitsqty*$vv['oddt_prozbiao'];
						}
						
						if($vv['oddt_proxbiao']>0){
							$oddt_unitsqty=$oddt_unitsqty*$vv['oddt_proxbiao'];
						}
						
						$oddt_totalqty=$oddt_unitsqty*$vv['oddt_qty'];
					}else{
						$oddt_totalqty=$vv['oddt_qty'];
					}
					if($oddt_totalqty==0 || $oddt_totalqty==$vv['oddt_qty']){
						$data2[$kk]['oddt_totalqty']='';
					}else{
						$data2[$kk]['oddt_totalqty']='('.$oddt_totalqty.'件)';
					}
					
					$map3=array();
					$data3=array();
					$map3['ship_pro']=$vv['oddt_proid'];
					$map3['ship_unitcode']=session('unitcode');
					$map3['ship_odid']=$vv['oddt_odid'];
					$map3['ship_oddtid']=$vv['oddt_id'];
					$map3['ship_dealer']=$data['od_oddlid']; //出货接收方
					$data3=$Shipment->where($map3)->sum('ship_proqty');
			
					if($data3){
						if($oddt_unitsqty>0){
							$data2[$kk]['oddt_shipqty']=floor($data3/$oddt_unitsqty).$vv['oddt_prounits'].'('.$data3.'件)';
						}else{
							$data2[$kk]['oddt_shipqty']=$data3.$vv['oddt_prounits'];
						}
					}else{
						$data2[$kk]['oddt_shipqty']=0;
					}
	
					
					
					
				}
				$data['orderdetail']=$data2;
				
				//下单代理信息
				$map3=array();
				$data3=array();
				$map3['dl_id']=$data['od_oddlid'];
				$map3['dl_unitcode']=session('unitcode');
				$data3=$Dealer->where($map3)->find();
				if($data3){
					$data['od_dl_name']=$data3['dl_name'];
					$data['od_dl_tel']=$data3['dl_tel'];
					$data['od_dl_username']=$data3['dl_username'];
				}else{
					$data['od_dl_name']='';
					$data['od_dl_tel']='';
					$data['od_dl_username']='';
				}
				
				//接单代理信息
				if($data['odbl_rcdlid']>0){
					$map3=array();
					$data3=array();
					$map3['dl_id']=$data['odbl_rcdlid'];
					$map3['dl_unitcode']=session('unitcode');
					$data3=$Dealer->where($map3)->find();
					if($data3){
						$data['od_rcdl_name']=$data3['dl_name'];
						$data['od_rcdl_tel']=$data3['dl_tel'];
						$data['od_rcdl_username']=$data3['dl_username'];
					}else{
						$data['od_rcdl_name']='';
						$data['od_rcdl_tel']='';
						$data['od_rcdl_username']='';
					}
				}else{
					$data['od_rcdl_name']='总公司';
					$data['od_rcdl_tel']='';
					$data['od_rcdl_username']='';
				}
				
				
				//快递物流
				if($data['od_express']>0){
				    $map3=array();
					$data3=array();
					$Express= M('Express');
					$map3['exp_id']=$data['od_express'];
					$data3=$Express->where($map3)->find();
					if($data3){
						$data['od_expressname']=$data3['exp_name'];
						//可以从快递100接口获取数据
						
						
					}else{
						$data['od_expressname']='';
					}
				}else{
					$data['od_expressname']='';
				}
				
				//状态
				if($data['od_state']==0){
					$data['od_state_str']='待确认';
				}else if($data['od_state']==1){
					$data['od_state_str']='待发货';
				}else if($data['od_state']==2){
					$data['od_state_str']='部分发货';
				}else if($data['od_state']==3){
					$data['od_state_str']='已发货';
				}else if($data['od_state']==8){
					$data['od_state_str']='已完成';
				}else if($data['od_state']==9){
					$data['od_state_str']='已取消';
				}else{
					$data['od_state_str']='未知';
				}
				
				$imgpath2 = BASE_PATH.'/Public/uploads/orders/';
				
				if(is_not_null($data['od_paypic']) && file_exists($imgpath2.$data['od_paypic'])){
					$data['od_paypic_str']='<a target="_blank" href="'.__ROOT__.'/Public/uploads/orders/'.$data['od_paypic'].'" ><img src="'.__ROOT__.'/Public/uploads/orders/'.$data['od_paypic'].'"   border="0"  style="width:20%;"  ></a>';
				}else{
					$data['od_paypic_str']='';
				}
				
				
				//允许操作
				$caozuostr='';
				if($data['od_state']==1 || $data['od_state']==2 || $data['od_state']==3 ){
					if($data['od_express']>0){
						$caozuostr='<div class="ui-btn ui-btn-primary"   data-href="'.U('./Demo82/Orders/odfinishship?od_id='.$data['od_id'].'&od_state='.$od_state.'').'"  >修改物流</div> ';
					}else{
						$caozuostr='<div class="ui-btn ui-btn-primary"   data-href="'.U('./Demo82/Orders/odfinishship?od_id='.$data['od_id'].'&od_state='.$od_state.'').'"  >完成发货</div> ';
					}
				}
				
				//取消订单
				if($data['odbl_state']==0 || $data['odbl_state']==1 ){
					$caozuostr.='<div class="ui-btn ui-btn-primary"   data-href="'.U('./Demo82/Orders/canceldlorder?state=9&od_id='.$data['od_id'].'&od_state='.$od_state.'').'"  >取消订单</div> ';
				}
				
				$data['caozuostr']=$caozuostr;	
				
				//操作日志
				$Orderlogs= M('Orderlogs');
				$map2=array();
				$map2['odlg_unitcode']=session('unitcode');
				$map2['odlg_odid']=$od_id;

				$logs = $Orderlogs->where($map2)->order('odlg_addtime DESC')->limit(50)->select();
				foreach($logs as $kkk=>$vvv){
					if($vvv['odlg_type']==0){
						 $logs[$kkk]['odlg_dlname']='总公司';
					}
				}
			
			}else{
				$this->error('没有该记录','',2);
			}
		}else{
			$this->error('没有该记录','',2);
		}
		
		$this->assign('orderlogs', $logs);
		$this->assign('ordersinfo', $data);
		$this->assign('od_id', $od_id);
		$this->assign('odbl_id', $odbl_id);
		 $this->assign('curr', 'order_list');
		
		$this->display('orderdetail');
    }
    
	//订单已发货记录
	public function odshiplist(){
		$this->check_qypurview('13002',1);
		 
		$od_id=intval(I('get.od_id',0));
		$odbl_id=intval(I('get.odbl_id',0));
		$oddt_id=intval(I('get.oddt_id',0));
		$back=intval(I('get.back',0));
		
		if($od_id>0 && $odbl_id>0 && $oddt_id>0){
            //对应订单
			$Model=M();
			$map=array();
			$order=array();
			$map['a.od_unitcode']=session('unitcode');
			$map['a.od_id']=array('exp','=b.odbl_odid');
			$map['a.od_oddlid']=array('exp','=b.odbl_oddlid');
			$map['b.odbl_id']=$odbl_id;
			$map['b.odbl_odid']=$od_id;
			$order = $Model->table('fw_orders a,fw_orderbelong b')->where($map)->find();
			if($order){
				
			}else{
				$this->error('没有该记录','',2);
			}
			
			
			//对应产品
			$Orderdetail= M('Orderdetail');
			$Shipment= M('Shipment');
			$oddetail=array();
			$map=array();
			$map['oddt_unitcode']=session('unitcode');
			$map['oddt_id']=$oddt_id;
			$map['oddt_odid']=$od_id;
			$map['oddt_odblid']=$odbl_id;
			$oddetail = $Orderdetail->where($map)->find();
			if($oddetail){
				//订购数 发货数
				$oddt_totalqty=0;
				$oddt_unitsqty=0;
				if($oddetail['oddt_prodbiao']>0){
					$oddt_unitsqty=$oddetail['oddt_prodbiao'];
					
					if($oddetail['oddt_prozbiao']>0){
						$oddt_unitsqty=$oddt_unitsqty*$oddetail['oddt_prozbiao'];
					}
					
					if($oddetail['oddt_proxbiao']>0){
						$oddt_unitsqty=$oddt_unitsqty*$oddetail['oddt_proxbiao'];
					}
					
					$oddt_totalqty=$oddt_unitsqty*$oddetail['oddt_qty'];
				}else{
					$oddt_totalqty=$oddetail['oddt_qty'];
				}
				if($oddt_totalqty==0 || $oddt_totalqty==$oddetail['oddt_qty']){
					$oddetail['oddt_totalqty']='';
				}else{
					$oddetail['oddt_totalqty']='('.$oddt_totalqty.'件)';
				}
				
				$map3=array();
				$data3=0;
				$map3['ship_pro']=$oddetail['oddt_proid'];
				$map3['ship_unitcode']=session('unitcode');
				$map3['ship_odid']=$oddetail['oddt_odid'];
				$map3['ship_oddtid']=$oddetail['oddt_id'];
				$map3['ship_dealer']=$order['od_oddlid']; //出货接收方
				$data3=$Shipment->where($map3)->sum('ship_proqty');
				if($data3){
					if($oddt_unitsqty>0){
						$oddetail['oddt_shipqty']=floor($data3/$oddt_unitsqty).$oddetail['oddt_prounits'].'('.$data3.'件)';
					}else{
						$oddetail['oddt_shipqty']=$data3.$oddetail['oddt_prounits'];
					}
				}else{
					$oddetail['oddt_shipqty']=0;
				}
				
				$oddetail['oddt_proname']=$oddetail['oddt_proname'].$oddetail['oddt_color'].$oddetail['oddt_size'];
			}else{
				$this->error('没有该记录','',2);
			}
			
			//对应订单的出货记录
			$Dealer= M('Dealer');
			$Product= M('Product');

			//出货记录
			$map=array();
			$parameter=array();
			$map['ship_unitcode']=session('unitcode');
			$map['ship_deliver']=$order['odbl_rcdlid'];   //ship_deliver--出货方   ship_dealer--收货方
			$map['ship_odid']=$od_id;
			$map['ship_odblid']=$odbl_id;
			$map['ship_pro']=$oddetail['oddt_proid'];

			$count = $Shipment->where($map)->count();
			$Page = new \Think\Page($count,50,$parameter);
			$show = $Page->show();
			if($show=='<div>    </div>'){
				$show='';
			}
			$list = $Shipment->where($map)->order('ship_id DESC')->limit(($Page->firstRow . ',') . $Page->listRows)->select();

			foreach($list as $k=>$v){ 
				//收货经销商
				$map2=array();
				$map2['dl_unitcode']=session('unitcode');
				$map2['dl_id'] = $v['ship_dealer'];
				$Dealerinfo = $Dealer->where($map2)->find();
				if($Dealerinfo){
					  $list[$k]['dl_name']=$Dealerinfo['dl_name'];
				}else{
					  $list[$k]['dl_name']='';
				}
				
				//出货经销商
				if($v['ship_deliver']>0){
					$map2=array();
					$map2['dl_unitcode']=session('unitcode');
					$map2['dl_id'] = $v['ship_deliver'];
					$Dealerinfo = $Dealer->where($map2)->find();
					if($Dealerinfo){
						  $list[$k]['dl_name_send']=$Dealerinfo['dl_name'];
					}else{
						  $list[$k]['dl_name_send']='';
					}
				}else{
					$list[$k]['dl_name_send']='总公司';
				}

				//对应的产品
				if($oddetail['oddt_proname']!=''){
					if($oddetail['oddt_pronumber']!=''){
						$list[$k]['ship_proname']=$oddetail['oddt_proname'];
						$list[$k]['ship_pronumber'] = $oddetail['oddt_pronumber'];
					}else{
						$list[$k]['ship_proname']=$oddetail['oddt_proname'];
						$list[$k]['ship_pronumber'] ='';
					}
				}else{
					$list[$k]['ship_proname']='';
					$list[$k]['ship_pronumber'] ='';
				}
				
				//操作
				if(($order['od_state']==1 || $order['od_state']==2) && $v['ship_deliver']==0 && $back==1){
					$list[$k]['ship_deletestr']='<a href="#" onClick="javascript:var truthBeTold = window.confirm(\'该操作将彻底删除该记录,请谨慎操作!\'); if (truthBeTold) window.location.href=\''.U('Mp/Shipment/delete?ship_id='.$v['ship_id'].'').'\';"  >删除</a>';
				}else{
					$list[$k]['ship_deletestr']='-';
				}
				
			}
		}else{
			$this->error('没有该记录','',2);
		}
		
		$this->assign('back', $back);
		$this->assign('od_id', $od_id);
		$this->assign('odbl_id', $odbl_id);
		$this->assign('oddt_id', $oddt_id);

        $this->assign('ordersinfo', $oddetail);
        $this->assign('list', $list);
        $this->assign('page', $show);
        $this->display('odshiplist');	
	}
	
	
	//删除订单 只有已取消的才能删除
    public function deleteorder(){
        $this->check_qypurview('13001',1);
        $od_id=intval(I('get.od_id',0));
		if($od_id==0){
			$this->error('没有该记录','',2);
		}
        $map['od_id']=$od_id;
        $map['od_unitcode']=session('unitcode');
        $Orders= M('Orders');
        $data=$Orders->where($map)->find();

        if($data){
			if($data['od_state']!=9){
				$this->error('该订单不能删除','',2);
			}
			
            //订单相关出货记录
			$map2=array();
            $map2['ship_odid']=$data['od_id'];
            $map2['ship_unitcode']=session('unitcode');
            $Shipment= M('Shipment');
            $Shipment->where($map2)->delete(); 
			

			
			//订单详细记录
			$Orderdetail= M('Orderdetail');
			$map2=array();
            $map2['oddt_odid']=$data['od_id'];
            $map2['oddt_unitcode']=session('unitcode');
			$Orderdetail->where($map2)->delete();
			
			//订单日志记录
			$Orderlogs= M('Orderlogs');
			$map2=array();
            $map2['odlg_odid']=$data['od_id'];
            $map2['odlg_unitcode']=session('unitcode');
			$Orderlogs->where($map2)->delete();
			
			
			
			//订单返利记录
			$Fanlidetail= M('Fanlidetail');
			$map2=array();
            $map2['fl_odid']=$data['od_id'];
            $map2['fl_unitcode']=session('unitcode');
            $Fanlidetail->where($map2)->delete();
			
			$Orderbelong= M('Orderbelong');
			$map2=array();
			$map2['odbl_odid']=$data['od_id'];
			$map2['odbl_unitcode'] = session('unitcode');
			$data2 = $Orderbelong->where($map2)->order('odbl_id DESC')->select();
			
			foreach($data2 as $k=>$v){
                @unlink('./Public/uploads/orders/'.$v['odbl_paypic']); 
			}
			
			//订单关系记录
			
			$map2=array();
            $map2['odbl_odid']=$data['od_id'];
            $map2['odbl_unitcode']=session('unitcode');
			$Orderbelong->where($map2)->delete(); 
			
			
			//预付款 余额 记录
			$Yufukuan= M('Yufukuan');
			$Balance= M('Balance');
			
			$map2=array();
			$map2['yfk_unitcode']=session('unitcode');
			$map2['yfk_type']=2;
			$map2['yfk_odid']=$data['od_id'];
			$map2['yfk_state']=0;
			$Yufukuan->where($map2)->delete(); 
			
			$map2=array();
			$map2['bl_unitcode']=session('unitcode');
			$map2['bl_type']=2;
			$map2['bl_odid']=$data['od_id'];
			$map2['bl_state']=0;
			$Balance->where($map2)->delete(); 
			
            $Orders->where($map)->delete(); 
			
			

            //记录日志 begin
            $log_arr=array(
                        'log_qyid'=>session('qyid'),
                        'log_user'=>session('qyuser'),
                        'log_qycode'=>session('unitcode'),
                        'log_action'=>'删除订单',
						'log_type'=>1, //0-系统 1-企业 2-经销商 3-消费者
                        'log_addtime'=>time(),
                        'log_ip'=>real_ip(),
                        'log_link'=>__SELF__,
                        'log_remark'=>json_encode($data)
                        );
            save_log($log_arr);
            //记录日志 end
            $this->success('删除成功','',1);


        }else{
            $this->error('没有该记录');
        }     
    
    }
    
	//确认/取消订单
    public function cancelorder(){
        $this->check_qypurview('13001',1);

		//--------------------------------
		// $odbl_id=intval(I('get.odbl_id',0));
		$od_id=intval(I('get.od_id',0));
		$state=intval(I('get.state',0));
		
		if($state==1){
			$state=1;
			$odlg_action='确认订单';
		}else if($state==9){
			$state=9;
			$odlg_action='取消订单';
		}else{
			$this->error('无该操作权限','',2);
		}
		
		$Orders= M('Orders');
		$Orderbelong= M('Orderbelong');
		$Orderlogs= M('Orderlogs');
		$Shipment= M('Shipment');
		
		if($od_id>0){
			//修改订单关系表状态
            $Orders=M('Orders');
			$map=array();
			$map['od_unitcode']=session('unitcode');
			$map['od_id']=$od_id;
			$data = $Orders->where($map)->find();
			if($data){
				//只有待确认才可以 确认
				if($state==1){
					if($data['od_state']!=0){
					    $this->error('该订单已确认','',2);
				    }
				}		
					
				//只有待确认、待发货的订单才能取消 确认
				if($data['od_state']==0 || $data['od_state']==1){	 
					
					//是否有出货记录 如有则不能取消
                    $map3=array();
					$data3=array();
					$map3['ship_unitcode']=session('unitcode');
					$map3['ship_odid']=$od_id;
					$map3['ship_dealer']=$data['od_oddlid']; //出货接收方
					$data3=$Shipment->where($map3)->find();
					if($data3){
						 $this->error('该订单已有出货记录，暂不能取消','',2);
					}

					$map2=array();
					$updata2=array();
					$map2['odbl_unitcode']=session('unitcode');
					$map2['odbl_odid']=$od_id;
					$map2['odbl_id']=$odbl_id;
					
					$updata2['odbl_state']=$state;
					$Orderbelong->where($map2)->save($updata2);
					
					//修改原始订单状态
					// if($data['od_oddlid']==$data['od_oddlid']){
						$map2=array();
						$updata2=array();
						$map2['od_unitcode']=session('unitcode');
						$map2['od_id']=$od_id;
						$updata2['od_state']=$state;
						$Orders->where($map2)->save($updata2);
					// }
					
					 //取消下家订单
					if($state==9){
						//预付款 余额 设 无效
						$Yufukuan= M('Yufukuan');
						$Balance= M('Balance');
						
						//取消返利
						$map2=array();
						$updata2=array();
						$map2['yfk_unitcode']=session('unitcode');
						$map2['yfk_type']=2;
						$map2['yfk_oddlid']=$data['od_oddlid'];
						$map2['yfk_odid']=$od_id;
						$updata2['yfk_state']=0;
						$Yufukuan->where($map2)->save($updata2);
						
						//取消订单款项
						$map2=array();
						$updata2=array();
						$map2['bl_unitcode']=session('unitcode');
						$map2['bl_type']=2;
						$map2['bl_sendid']=$data['od_oddlid'];
						$map2['bl_odid']=$od_id;
						$updata2['bl_state']=0;
						$Balance->where($map2)->save($updata2);

						//预付款 余额 设 无效 end
					}
					
					
					//订单操作日志 begin
					$odlog_arr=array(
								'odlg_unitcode'=>session('unitcode'),  
								'odlg_odid'=>$od_id,
								'odlg_orderid'=>$data['od_orderid'],
								'odlg_dlid'=>session('qyid'),
								'odlg_dlusername'=>session('qyuser'),
								'odlg_dlname'=>session('qyuser'),
								'odlg_action'=>$odlg_action,
								'odlg_type'=>0, //0-企业 1-经销商
								'odlg_addtime'=>time(),
								'odlg_ip'=>real_ip(),
								'odlg_link'=>__SELF__
								);
					$Orderlogs = M('Orderlogs');
					$rs3=$Orderlogs->create($odlog_arr,1);
					if($rs3){
						$Orderlogs->add();
					}
					//订单操作日志 end
					$this->success('操作成功','',2);
				}else{
				    $this->error('该订单已处理，不能取消','',2);
				}
			}else{
				$this->error('没有该记录','',2);
			}
			
		}else{
			$this->error('没有该记录','',2);
		}
    }

    
	//公司订单 发货订单
    public function cporders(){

        $this->check_qypurview('13001',1);
        $parameter=array();
		$dlusername=trim(I('param.dlusername',''));
		$begintime=I('param.begintime','');
        $endtime=I('param.endtime','');
        $keyword=trim(strip_tags(htmlspecialchars_decode(I('param.keyword',''))));
		$od_oddlid=0; //谁下的订单
        if($dlusername!='' && $dlusername!='请填写下单代理账号'){
            if(!preg_match("/[a-zA-Z0-9_-]{4,20}$/",$dlusername)){
                $this->error('下单代理账号不正确','',1);
            }
			
			$map2=array();
			$Dealer = M('Dealer');
            $map2['dl_username']=$dlusername;
            $map2['dl_unitcode']=session('unitcode');
            $data2=$Dealer->where($map2)->find();
            if(!$data2){
				$this->error('经销商账号不正确','',1);
			}
            $od_oddlid=$data2['dl_id'];
			$parameter['dlusername']=$dlusername;
			$this->assign('dlusername', $dlusername);
        }else{
			$this->assign('dlusername', '请填写下单代理账号');
		}
		$Orders=M('Orders');
		$map=array();
		$map['od_unitcode']=session('unitcode');
		// if($od_oddlid>0){
		//     $map['b.odbl_oddlid']=$od_oddlid;
		// }
		
		$od_state=I('param.od_state',''); //订单状态
		if($od_state!=''){
			$od_state=intval($od_state);
			
			if($od_state==1 || $od_state==2){
				$map['od_state']=array('in','1,2');
			}else{
				$map['od_state']=$od_state;
			}	
			$parameter['od_state']=$od_state;
		}

        if($keyword!=''){
            $keyword=str_replace('[','',$keyword);
            $keyword=str_replace(']','',$keyword);
            $keyword=str_replace('%','',$keyword);
            $keyword=str_replace('_','',$keyword);

            $keyword=sub_str($keyword,25,false);
            $map['od_orderid']=$keyword;
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
			
			$map['od_addtime']=array('between',array($begintime,$endtime));
			
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
		$map['od_rcdlid']=0;//下给公司的订单
		$map['od_virtualstock']=0; //0--非虚拟库存订单 1--虚拟库存订单
		$count = $Orders->where($map)->count();
		$Page = new \Think\Page($count, C('PAGE_SIZE'),$parameter);
        $show = $Page->show();
		$list =$Orders->where($map)->order('od_addtime DESC')->limit(($Page->firstRow . ',') . $Page->listRows)->select();
		
		$Product = M('Product');
		$Orderdetail = M('Orderdetail');
		$Shipment = M('Shipment');
		$Dealer = M('Dealer');
		$imgpath = BASE_PATH.'/Public/uploads/product/';
        foreach($list as $k=>$v){
			//订单详细
			$map2=array();
			$data2=array();
			$map2['oddt_unitcode']=session('unitcode');
			$map2['oddt_odid']=$v['od_id'];
			$data2 = $Orderdetail->where($map2)->order('oddt_id DESC')->limit(100)->select();
			foreach($data2 as $kk=>$vv){
				//产品
				$map3=array();
				$data3=array();
				$map3['pro_id']=$vv['oddt_proid'];
				$map3['pro_unitcode']=session('unitcode');
				$data3=$Product->where($map3)->find();
				if($data3){
					if(is_not_null($data3['pro_pic']) && file_exists($imgpath.$data3['pro_pic'])){
						$data2[$kk]['oddt_propic']=$data3['pro_pic'];
					}else{
						$data2[$kk]['oddt_propic']='';
					}
				}else{
					$data2[$kk]['oddt_propic']='';
				}
				//订购数量
				$oddt_totalqty=0; //总订购数
				$oddt_unitsqty=0; //每单位包装的数量
				if($vv['oddt_prodbiao']>0){
					$oddt_unitsqty=$vv['oddt_prodbiao'];
					
					if($vv['oddt_prozbiao']>0){
						$oddt_unitsqty=$oddt_unitsqty*$vv['oddt_prozbiao'];
					}
					if($vv['oddt_proxbiao']>0){
						$oddt_unitsqty=$oddt_unitsqty*$vv['oddt_proxbiao'];
					}
					
					$oddt_totalqty=$oddt_unitsqty*$vv['oddt_qty'];
				}else{
					$oddt_totalqty=$vv['oddt_qty'];
				}
				if($oddt_totalqty==0 || $oddt_totalqty==$vv['oddt_qty']){
					$data2[$kk]['oddt_totalqty']='';
				}else{
					$data2[$kk]['oddt_totalqty']='('.$oddt_totalqty.'件)';
				}
				
				//已发数量
				$map3=array();
				$data3=array();
				$map3['ship_pro']=$vv['oddt_proid'];
				$map3['ship_unitcode']=session('unitcode');
				$map3['ship_odid']=$vv['oddt_odid'];
				$map3['ship_oddtid']=$vv['oddt_id'];
				$map3['ship_dealer']=$v['od_oddlid']; //出货接收方
				$data3=$Shipment->where($map3)->sum('ship_proqty');
				if($data3){
					if($oddt_unitsqty>0){
						$data2[$kk]['oddt_shipqty']=floor($data3/$oddt_unitsqty).$vv['oddt_prounits'].'('.$data3.'件)';
					}else{
						$data2[$kk]['oddt_shipqty']=$data3.$vv['oddt_prounits'];
					}
				}else{
					$data2[$kk]['oddt_shipqty']=0;
				}
			}
			$list[$k]['orderdetail']=$data2;
			$list[$k]['countdetail']=count($data2);
			//状态 我的订单状态 以fw_orders表为主
			if($v['od_state']==0){
				$list[$k]['od_state_str']='待确认';
			}else if($v['od_state']==1){
				$list[$k]['od_state_str']='待发货';
			}else if($v['od_state']==2){
				$list[$k]['od_state_str']='部分发货';
			}else if($v['od_state']==3){
				$list[$k]['od_state_str']='已发货';
			}else if($v['od_state']==8){
			    $list[$k]['od_state_str']='已完成';
			}else if($v['od_state']==9){
				$list[$k]['od_state_str']='已取消';
			}else{
				$list[$k]['od_state_str']='未知';
			}

			//允许操作
			$caozuostr='<a href="'.U('./Mp/Orders/cporderdetail?od_id='.$v['od_id'].'').'"  >订单详细</a><br>';
			
           //确认订单
			if($v['od_state']==0){
				$caozuostr.='<a href="'.U('./Mp/Orders/cancelorder?state=1&od_id='.$v['od_id'].'').'"  >确认订单</a><br>';
			}
			
			//取消订单
			if($v['od_state']==0 || $v['od_state']==1 ){
				$caozuostr.='<a href="'.U('./Mp/Orders/cancelorder?state=9&od_id='.$v['od_id'].'').'"  >取消订单</a><br>';
			}
			
			//删除订单 只有已取消的才能删除
			if($v['od_state']==9 ){
			    $caozuostr.='<a   href="#"  onClick="javascript:var truthBeTold = window.confirm(\'该操作将彻底删除,谨慎操作!\'); if (truthBeTold) window.location.href=\''.U('Mp/Orders/deleteorder?od_id='.$v['od_id']).'\';"  >删除</a> ';
			}
			
			$list[$k]['caozuostr']=$caozuostr;
			
            //下单代理信息
			$map3=array();
			$data3=array();
			$map3['dl_id']=$v['od_oddlid'];
			$map3['dl_unitcode']=session('unitcode');
			$data3=$Dealer->where($map3)->find();
			if($data3){
				$list[$k]['od_dl_name']=$data3['dl_name'];
				$list[$k]['od_dl_username']=$data3['dl_username'];
				$list[$k]['od_dl_tel']=$data3['dl_tel'];
			}else{
				$list[$k]['od_dl_name']='';
				$list[$k]['od_dl_tel']='';
				$list[$k]['od_dl_username']='';
			}
			
			//接单代理信息

			$list[$k]['od_rcdl_name']='总公司';

				
		}

		$this->assign('page', $show);
		$this->assign('orderlist', $list);
        $this->assign('od_state', $od_state);

        $this->assign('keyword', $keyword);
        $this->assign('page', $show);
        $this->assign('curr', 'cporders');

        $this->display('cporders');
    }
   
    //公司订单详细
    public function cporderdetail(){
        $this->check_qypurview('13001',1);

		$od_id=intval(I('get.od_id',0));
		// $odbl_id=intval(I('get.odbl_id',0));
		$back=intval(I('get.back',0));
		
		if($od_id>0){
			$Orders=M('Orders');
			$map=array();
			$map['od_unitcode']=session('unitcode');
			$map['od_id']=$od_id;
			$map['od_rcdlid']=0;//下给公司的订单
			$data =$Orders->where($map)->find();
			if($data){
				//订单产品详细
				$Orderdetail= M('Orderdetail');
				$Product= M('Product');
				$Shipment= M('Shipment');
				$Dealer= M('Dealer');
				
				$map2=array();
				$data2=array();
				$map2['oddt_unitcode']=session('unitcode');
				$map2['oddt_odid']=$data['od_id'];
				$data2 = $Orderdetail->where($map2)->order('oddt_id DESC')->limit(100)->select();
				$imgpath = BASE_PATH.'/Public/uploads/product/';
				foreach($data2 as $kk=>$vv){
					//产品
					$map3=array();
					$data3=array();
					$map3['pro_id']=$vv['oddt_proid'];
					$map3['pro_unitcode']=session('unitcode');
					$data3=$Product->where($map3)->find();
					if($data3){
						if(is_not_null($data3['pro_pic']) && file_exists($imgpath.$data3['pro_pic'])){
							$data2[$kk]['oddt_propic']=$data3['pro_pic'];
						}else{
							$data2[$kk]['oddt_propic']='';
						}
					}else{
						$data2[$kk]['oddt_propic']='';
					}
					
					//订购数 发货数
					$oddt_totalqty=0;
					$oddt_unitsqty=0;
					if($vv['oddt_prodbiao']>0){
						$oddt_unitsqty=$vv['oddt_prodbiao'];
						
						if($vv['oddt_prozbiao']>0){
							$oddt_unitsqty=$oddt_unitsqty*$vv['oddt_prozbiao'];
						}
						
						if($vv['oddt_proxbiao']>0){
							$oddt_unitsqty=$oddt_unitsqty*$vv['oddt_proxbiao'];
						}
						
						$oddt_totalqty=$oddt_unitsqty*$vv['oddt_qty'];
					}else{
						$oddt_totalqty=$vv['oddt_qty'];
					}
					if($oddt_totalqty==0 || $oddt_totalqty==$vv['oddt_qty']){
						$data2[$kk]['oddt_totalqty']='';
					}else{
						$data2[$kk]['oddt_totalqty']='('.$oddt_totalqty.'件)';
					}
					
					$map3=array();
					$data3=array();
					$map3['ship_pro']=$vv['oddt_proid'];
					$map3['ship_unitcode']=session('unitcode');
					$map3['ship_odid']=$vv['oddt_odid'];
					$map3['ship_oddtid']=$vv['oddt_id'];
					$map3['ship_dealer']=$data['od_oddlid']; //出货接收方
					$data3=$Shipment->where($map3)->sum('ship_proqty');
			
					if($data3){
						if($oddt_unitsqty>0){
							$data2[$kk]['oddt_shipqty']=floor($data3/$oddt_unitsqty).$vv['oddt_prounits'].'('.$data3.'件)';
						}else{
							$data2[$kk]['oddt_shipqty']=$data3.$vv['oddt_prounits'];
						}
					}else{
						$data2[$kk]['oddt_shipqty']=0;
					}
	
					
					//出货按钮
					if($data['od_state']==1 || $data['od_state']==2 || $data['od_state']==3){
						if($oddt_totalqty>0){
							if($oddt_totalqty>$data3){
								$data2[$kk]['oddt_shipment']='<a class="abotton"  href="'.U('./Mp/Orders/odshipscan?od_id='.$data['od_id'].'&oddt_id='.$vv['oddt_id'].'').'"   >出 货</a>';
							}else{
								$data2[$kk]['oddt_shipment']='';
							}
						}else{
							if($vv['oddt_qty']>$data3){
								$data2[$kk]['oddt_shipment']='<a class="abotton"  href="'.U('./Mp/Orders/odshipscan?od_id='.$data['od_id'].'&oddt_id='.$vv['oddt_id'].'').'" >出 货</a>';
							}else{
								$data2[$kk]['oddt_shipment']='';
							}
						}
					}else{
						$data2[$kk]['oddt_shipment']='';
					}
					
				}
				$data['orderdetail']=$data2;
				
				//下单代理信息
				$map3=array();
				$data3=array();
				$map3['dl_id']=$data['od_oddlid'];
				$map3['dl_unitcode']=session('unitcode');
				$data3=$Dealer->where($map3)->find();
				if($data3){
					$data['od_dl_name']=$data3['dl_name'];
					$data['od_dl_tel']=$data3['dl_tel'];
					$data['od_dl_username']=$data3['dl_username'];
				}else{
					$data['od_dl_name']='';
					$data['od_dl_tel']='';
					$data['od_dl_username']='';
				}
				
				//接单代理信息
				if($data['odbl_rcdlid']>0){
					$map3=array();
					$data3=array();
					$map3['dl_id']=$data['odbl_rcdlid'];
					$map3['dl_unitcode']=session('unitcode');
					$data3=$Dealer->where($map3)->find();
					if($data3){
						$data['od_rcdl_name']=$data3['dl_name'];
						$data['od_rcdl_tel']=$data3['dl_tel'];
						$data['od_rcdl_username']=$data3['dl_username'];
					}else{
						$data['od_rcdl_name']='';
						$data['od_rcdl_tel']='';
						$data['od_rcdl_username']='';
					}
				}else{
					$data['od_rcdl_name']='总公司';
					$data['od_rcdl_tel']='';
					$data['od_rcdl_username']='';
				}
				
				
				//快递物流
				if($data['od_express']>0){
				    $map3=array();
					$data3=array();
					$Express= M('Express');
					$map3['exp_id']=$data['od_express'];
					$data3=$Express->where($map3)->find();
					if($data3){
						$data['od_expressname']=$data3['exp_name'];
						//可以从快递100接口获取数据
					}else{
						$data['od_expressname']='';
					}
				}else{
					$data['od_expressname']='';
				}
				
				//状态
				if($data['od_state']==0){
					$data['od_state_str']='待确认';
				}else if($data['od_state']==1){
					$data['od_state_str']='待发货';
				}else if($data['od_state']==2){
					$data['od_state_str']='部分发货';
				}else if($data['od_state']==3){
					$data['od_state_str']='已发货';
				}else if($data['od_state']==8){
					$data['od_state_str']='已完成';
				}else if($data['od_state']==9){
					$data['od_state_str']='已取消';
				}else{
					$data['od_state_str']='未知';
				}
				
				$imgpath2 = BASE_PATH.'/Public/uploads/orders/';
				
				if(is_not_null($data['od_paypic']) && file_exists($imgpath2.$data['od_paypic'])){
					$data['od_paypic_str']='<a target="_blank" href="'.__ROOT__.'/Public/uploads/orders/'.$data['od_paypic'].'" ><img src="'.__ROOT__.'/Public/uploads/orders/'.$data['od_paypic'].'"   border="0"  style="width:20%;"  ></a>';
				}else{
					$data['od_paypic_str']='';
				}
				
				
				//允许操作
				$caozuostr='';
				if($data['od_state']==1 || $data['od_state']==2 || $data['od_state']==3 ){
					if($data['od_express']>0){
						$caozuostr='<input name="odfinishship2" id="odfinishship2" class="botton"  value="修改物流" type="button"> ';
					}else{
						$caozuostr='<input name="odfinishship"  id="odfinishship" class="botton" value="完成发货" type="submit"> ';
					}
				}
				
				
				$data['caozuostr']=$caozuostr;	
				
				//操作日志
				$Orderlogs= M('Orderlogs');
				$map2=array();
				$map2['odlg_unitcode']=session('unitcode');
				$map2['odlg_odid']=$od_id;

				$logs = $Orderlogs->where($map2)->order('odlg_addtime DESC')->limit(50)->select();
				foreach($logs as $kkk=>$vvv){
					if($vvv['odlg_type']==0){
						 $logs[$kkk]['odlg_dlname']='总公司';
					}
				}
			
			}else{
				$this->error('没有该记录','',2);
			}
		}else{
			$this->error('没有该记录','',2);
		}

		$this->assign('back', $back);
		$this->assign('orderlogs', $logs);
		$this->assign('ordersinfo', $data);
		$this->assign('od_id', $od_id);
		$this->assign('odbl_id', $odbl_id);
		$this->assign('curr', 'cporders');
		
		$this->display('cporderdetail');
    }

    //所有订单 订货订单
    public function xnorders(){
        $this->check_qypurview('13010',1);
        $parameter=array();
		$dlusername=trim(I('param.dlusername',''));
		$begintime=I('param.begintime','');
        $endtime=I('param.endtime','');
        $keyword=trim(strip_tags(htmlspecialchars_decode(I('param.keyword',''))));
		
		
		$od_oddlid=0; //谁下的订单
        if($dlusername!='' && $dlusername!='请填写下单代理账号'){
            if(!preg_match("/[a-zA-Z0-9_-]{4,20}$/",$dlusername)){
                $this->error('下单代理账号不正确','',1);
            }
			
			$map2=array();
			$Dealer = M('Dealer');
            $map2['dl_username']=$dlusername;
            $map2['dl_unitcode']=session('unitcode');
            $data2=$Dealer->where($map2)->find();
            if(!$data2){
				$this->error('经销商账号不正确','',1);
			}
            $od_oddlid=$data2['dl_id'];
			$parameter['dlusername']=$dlusername;
			$this->assign('dlusername', $dlusername);
        }else{
			$this->assign('dlusername', '请填写下单代理账号');
		}
		
		$Orders=M('Orders');
		$map=array();
		$map['od_unitcode']=session('unitcode');
		if($od_oddlid>0){
		    $map['od_oddlid']=$od_oddlid;
		}
		
		$od_state=I('param.od_state',''); //订单状态
		if($od_state!=''){
			$od_state=intval($od_state);
			
			if($od_state==1 || $od_state==2){
				$map['od_state']=array('in','1,2');
			}else{
				$map['od_state']=$od_state;
			}	
			$parameter['od_state']=$od_state;
		}

        if($keyword!=''){
            $keyword=str_replace('[','',$keyword);
            $keyword=str_replace(']','',$keyword);
            $keyword=str_replace('%','',$keyword);
            $keyword=str_replace('_','',$keyword);

            $keyword=sub_str($keyword,25,false);
            $map['od_orderid']=$keyword;
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
			
			$map['od_addtime']=array('between',array($begintime,$endtime));
			
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
		$map['od_virtualstock']=1; //0--非虚拟库存订单 1--虚拟库存订单
		
		
		$count =$Orders->where($map)->count();
		$Page = new \Think\Page($count, C('PAGE_SIZE'),$parameter);
        $show = $Page->show();

		$list = $Orders->where($map)->order('od_addtime DESC')->limit(($Page->firstRow . ',') . $Page->listRows)->select();
		
		$Product = M('Product');
		$Orderdetail = M('Orderdetail');
		$Shipment = M('Shipment');
		$Dealer = M('Dealer');
		$imgpath = BASE_PATH.'/Public/uploads/product/';
        foreach($list as $k=>$v){
			//订单详细
			$map2=array();
			$data2=array();
			$map2['oddt_unitcode']=session('unitcode');
			$map2['oddt_odid']=$v['od_id'];
			$data2 = $Orderdetail->where($map2)->order('oddt_id DESC')->limit(100)->select();
			foreach($data2 as $kk=>$vv){
				//产品
				$map3=array();
				$data3=array();
				$map3['pro_id']=$vv['oddt_proid'];
				$map3['pro_unitcode']=session('unitcode');
				$data3=$Product->where($map3)->find();
				if($data3){
					if(is_not_null($data3['pro_pic']) && file_exists($imgpath.$data3['pro_pic'])){
						$data2[$kk]['oddt_propic']=$data3['pro_pic'];
					}else{
						$data2[$kk]['oddt_propic']='';
					}
				}else{
					$data2[$kk]['oddt_propic']='';
				}
				
				//订购数量
				$oddt_totalqty=0; //总订购数
				$oddt_unitsqty=0; //每单位包装的数量
				if($vv['oddt_prodbiao']>0){
					$oddt_unitsqty=$vv['oddt_prodbiao'];
					
					if($vv['oddt_prozbiao']>0){
						$oddt_unitsqty=$oddt_unitsqty*$vv['oddt_prozbiao'];
					}
					
					if($vv['oddt_proxbiao']>0){
						$oddt_unitsqty=$oddt_unitsqty*$vv['oddt_proxbiao'];
					}
					
					$oddt_totalqty=$oddt_unitsqty*$vv['oddt_qty'];
				}else{
					$oddt_totalqty=$vv['oddt_qty'];
				}
				if($oddt_totalqty==0 || $oddt_totalqty==$vv['oddt_qty']){
					$data2[$kk]['oddt_totalqty']='';
				}else{
					$data2[$kk]['oddt_totalqty']='('.$oddt_totalqty.'件)';
				}
				
				//已发数量
				$map3=array();
				$data3=array();
				$map3['ship_pro']=$vv['oddt_proid'];
				$map3['ship_unitcode']=session('unitcode');
				$map3['ship_odid']=$vv['oddt_odid'];
				$map3['ship_dealer']=$v['od_oddlid']; //出货接收方
				$data3=$Shipment->where($map3)->sum('ship_proqty');
				if($data3){
					if($oddt_unitsqty>0){
						$data2[$kk]['oddt_shipqty']=floor($data3/$oddt_unitsqty).$vv['oddt_prounits'].'('.$data3.'件)';
					}else{
						$data2[$kk]['oddt_shipqty']=$data3.$vv['oddt_prounits'];
					}
				}else{
					$data2[$kk]['oddt_shipqty']=0;
				}
			}
			$list[$k]['orderdetail']=$data2;
			$list[$k]['countdetail']=count($data2);
			
			//状态 我的订单状态 以fw_orders表为主
			if($v['od_state']==0){
				$list[$k]['od_state_str']='待确认';
			}else if($v['od_state']==1){
				$list[$k]['od_state_str']='待发货';
			}else if($v['od_state']==2){
				$list[$k]['od_state_str']='部分发货';
			}else if($v['od_state']==3){
				$list[$k]['od_state_str']='已发货';
			}else if($v['od_state']==8){
			    $list[$k]['od_state_str']='已完成';
			}else if($v['od_state']==9){
				$list[$k]['od_state_str']='已取消';
			}else{
				$list[$k]['od_state_str']='未知';
			}
			 
			//允许操作
			$caozuostr='<a href="'.U('./Mp/Orders/xnorderdetail?od_id='.$v['od_id'].$v['odbl_id'].'').'"  >订单详细</a><br>';
			
           //确认订单
			if($v['od_state']==0){
				$caozuostr.='<a href="'.U('./Mp/Orders/xncancelorder?state=1&od_id='.$v['od_id'].'').'"  >确认订单</a><br>';
			}
			
			//取消订单
			if($v['od_state']==0 || $v['od_state']==1 ){
				$caozuostr.='<a href="'.U('./Mp/Orders/xncancelorder?state=9&od_id='.$v['od_id'].'').'"  >取消订单</a><br>';
			}
			
			//删除订单 只有已取消的才能删除
			if($v['od_state']==9 ){
			    $caozuostr.='<a   href="#"  onClick="javascript:var truthBeTold = window.confirm(\'该操作将彻底删除,谨慎操作!\'); if (truthBeTold) window.location.href=\''.U('Mp/Orders/xndeleteorder?od_id='.$v['od_id']).'\';"  >删除</a> ';
			}
			
			$list[$k]['caozuostr']=$caozuostr;
			
            //下单代理信息
			$map3=array();
			$data3=array();
			$map3['dl_id']=$v['od_oddlid'];
			$map3['dl_unitcode']=session('unitcode');
			$data3=$Dealer->where($map3)->find();
			if($data3){
				$list[$k]['od_dl_name']=$data3['dl_name'];
				$list[$k]['od_dl_username']=$data3['dl_username'];
				$list[$k]['od_dl_tel']=$data3['dl_tel'];
			}else{
				$list[$k]['od_dl_name']='';
				$list[$k]['od_dl_tel']='';
				$list[$k]['od_dl_username']='';
			}
			
			//接单代理信息
			if($v['od_rcdlid']>0){
				$map3=array();
				$data3=array();
				$map3['dl_id']=$v['od_rcdlid'];
				$map3['dl_unitcode']=session('unitcode');
				$data3=$Dealer->where($map3)->find();
				if($data3){
					$list[$k]['od_rcdl_name']=$data3['dl_name'];
					$list[$k]['od_rcdl_username']=$data3['dl_username'];
					$list[$k]['od_rcdl_tel']=$data3['dl_tel'];
				}else{
					$list[$k]['od_rcdl_name']='';
					$list[$k]['od_rcdl_tel']='';
					$list[$k]['od_rcdl_username']='';
				}
			}else{
				$list[$k]['od_rcdl_name']='总公司';
				$list[$k]['od_rcdl_username']='';
				$list[$k]['od_rcdl_tel']='';
			}
		}

		$this->assign('page', $show);
		$this->assign('orderlist', $list);
        $this->assign('od_state', $od_state);

        $this->assign('keyword', $keyword);
        $this->assign('page', $show);
        $this->assign('curr', 'xnorders');

        $this->display('xnorders');
    }

    //确认/取消订货订单
    public function xncancelorder(){
        $this->check_qypurview('13010',1);

		//--------------------------------
		$od_id=intval(I('get.od_id',0));
		$state=intval(I('get.state',0));
		
		if($state==1){//确认订单按钮上传过来的state为1
			$state=1;
			$odlg_action='确认订单';
		}else if($state==9){
			$state=9;
			$odlg_action='取消订单';
		}else{
			$this->error('无该操作权限','',2);
		}
		
		$Orders= M('Orders');
		$Orderbelong= M('Orderbelong');
		$Orderlogs= M('Orderlogs');
		$Shipment= M('Shipment');
		
		if($od_id>0){
			//修改订单关系表状态
            $Orders=M('Orders');
			$map=array();
			$map['od_unitcode']=session('unitcode');
			$map['od_id']=$od_id;
			$data = $Orders->where($map)->find();
			if($data){
				//只有待确认才可以 确认
				if($state==1){
					if($data['od_state']!=0){
					    $this->error('该订单已确认','',2);
				    }
				}
				
				
				//只有待确认、待发货的订单才能取消 确认
				if($data['od_state']==0 || $data['od_state']==1){	 
					
					//是否有出货记录 如有则不能取消
                    $map3=array();
					$data3=array();
					$map3['ship_unitcode']=session('unitcode');
					$map3['ship_odid']=$od_id;
					$map3['ship_dealer']=$data['od_oddlid']; //出货接收方
					$data3=$Shipment->where($map3)->find();
					if($data3){
						 $this->error('该订单已有出货记录，暂不能取消','',2);
					}

					// $map2=array();
					// $updata2=array();
					// $map2['odbl_unitcode']=session('unitcode');
					// $map2['odbl_odid']=$od_id;
					// $map2['odbl_id']=$odbl_id;
					
					// $updata2['odbl_state']=$state;
					// $Orderbelong->where($map2)->save($updata2);
					
					//修改原始订单状态
					// if($data['od_oddlid']==$data['odbl_oddlid']){
						$map2=array();
						$updata2=array();
						$map2['od_unitcode']=session('unitcode');
						$map2['od_id']=$od_id;
						$updata2['od_state']=$state;
						$Orders->where($map2)->save($updata2);
					// }
					
					 //取消下家订单
					if($state==9){
						//预付款 余额 设 无效
						$Yufukuan= M('Yufukuan');
						$Balance= M('Balance');
						
						//取消返利
						$map2=array();
						$updata2=array();
						$map2['yfk_unitcode']=session('unitcode');
						$map2['yfk_type']=2;
						$map2['yfk_oddlid']=$data['od_oddlid'];
						$map2['yfk_odid']=$od_id;
						$updata2['yfk_state']=0;
						$Yufukuan->where($map2)->save($updata2);
						
						//取消订单款项
						$map2=array();
						$updata2=array();
						$map2['bl_unitcode']=session('unitcode');
						$map2['bl_type']=2;
						$map2['bl_sendid']=$data['od_oddlid'];
						$map2['bl_odid']=$od_id;
						$updata2['bl_state']=0;
						$Balance->where($map2)->save($updata2);

						//预付款 余额 设 无效 end
					}
					
					
					//订单操作日志 begin
					$odlog_arr=array(
								'odlg_unitcode'=>session('unitcode'),  
								'odlg_odid'=>$od_id,
								'odlg_orderid'=>$data['od_orderid'],
								'odlg_dlid'=>session('qyid'),
								'odlg_dlusername'=>session('qyuser'),
								'odlg_dlname'=>session('qyuser'),
								'odlg_action'=>$odlg_action,
								'odlg_type'=>0, //0-企业 1-经销商
								'odlg_addtime'=>time(),
								'odlg_ip'=>real_ip(),
								'odlg_link'=>__SELF__
								);
					$Orderlogs = M('Orderlogs');
					$rs3=$Orderlogs->create($odlog_arr,1);
					if($rs3){
						$Orderlogs->add();
					}
					//订单操作日志 end
					$this->success('操作成功','',2);
				}else{
				    $this->error('该订单已处理，不能取消','',2);
				}
			}else{
				$this->error('没有该记录','',2);
			}
			
		}else{
			$this->error('没有该记录','',2);
		}
    }

    //删除订货订单 只有已取消的才能删除
    public function xndeleteorder(){
        $this->check_qypurview('13010',1);
		
        $od_id=intval(I('get.od_id',0));
		if($od_id==0){
			$this->error('没有该记录','',2);
		}
        $map['od_id']=$od_id;
        $map['od_unitcode']=session('unitcode');
        $Orders= M('Orders');
        $data=$Orders->where($map)->find();

        if($data){
			if($data['od_state']!=9){
				$this->error('该订单不能删除','',2);
			}
			
            //订单相关出货记录
			$map2=array();
            $map2['ship_odid']=$data['od_id'];
            $map2['ship_unitcode']=session('unitcode');
            $Shipment= M('Shipment');
            $Shipment->where($map2)->delete(); 
			

			
			//订单详细记录
			$Orderdetail= M('Orderdetail');
			$map2=array();
            $map2['oddt_odid']=$data['od_id'];
            $map2['oddt_unitcode']=session('unitcode');
			$Orderdetail->where($map2)->delete();
			
			//订单日志记录
			$Orderlogs= M('Orderlogs');
			$map2=array();
            $map2['odlg_odid']=$data['od_id'];
            $map2['odlg_unitcode']=session('unitcode');
			$Orderlogs->where($map2)->delete();
			
			
			
			//订单返利记录
			$Fanlidetail= M('Fanlidetail');
			$map2=array();
            $map2['fl_odid']=$data['od_id'];
            $map2['fl_unitcode']=session('unitcode');
            $Fanlidetail->where($map2)->delete();
			
			$Orderbelong= M('Orderbelong');
			$map2=array();
			$map2['odbl_odid']=$data['od_id'];
			$map2['odbl_unitcode'] = session('unitcode');
			$data2 = $Orderbelong->where($map2)->order('odbl_id DESC')->select();
			
			foreach($data2 as $k=>$v){
                @unlink('./Public/uploads/orders/'.$v['odbl_paypic']); 
			}
			
			//订单关系记录
			
			$map2=array();
            $map2['odbl_odid']=$data['od_id'];
            $map2['odbl_unitcode']=session('unitcode');
			$Orderbelong->where($map2)->delete(); 
			
			
			//预付款 余额 记录
			$Yufukuan= M('Yufukuan');
			$Balance= M('Balance');
			
			$map2=array();
			$map2['yfk_unitcode']=session('unitcode');
			$map2['yfk_type']=2;
			$map2['yfk_odid']=$data['od_id'];
			$map2['yfk_state']=0;
			$Yufukuan->where($map2)->delete(); 
			
			$map2=array();
			$map2['bl_unitcode']=session('unitcode');
			$map2['bl_type']=2;
			$map2['bl_odid']=$data['od_id'];
			$map2['bl_state']=0;
			$Balance->where($map2)->delete(); 
			
            $Orders->where($map)->delete(); 
			
			

            //记录日志 begin
            $log_arr=array(
                        'log_qyid'=>session('qyid'),
                        'log_user'=>session('qyuser'),
                        'log_qycode'=>session('unitcode'),
                        'log_action'=>'删除订单',
						'log_type'=>1, //0-系统 1-企业 2-经销商 3-消费者
                        'log_addtime'=>time(),
                        'log_ip'=>real_ip(),
                        'log_link'=>__SELF__,
                        'log_remark'=>json_encode($data)
                        );
            save_log($log_arr);
            //记录日志 end
            $this->success('删除成功','',1);


        }else{
            $this->error('没有该记录');
        }     
    
    }

     //订货订单详细
    public function xnorderdetail(){
        $this->check_qypurview('13010',1);

		$od_id=intval(I('get.od_id',0));
		$back=intval(I('get.back',0));
		
		if($od_id>0){
			$Orders=M('Orders');
			$map=array();
			$map['od_unitcode']=session('unitcode');
			$map['od_id']=$od_id;
			$map['od_virtualstock']=1;//0--非虚拟库存订单 1--虚拟库存订单
			$data =$Orders->where($map)->find();
			if($data){
				//订单产品详细
				$Orderdetail= M('Orderdetail');
				$Product= M('Product');
				$Shipment= M('Shipment');
				$Dealer= M('Dealer');
				
				$map2=array();
				$data2=array();
				$map2['oddt_unitcode']=session('unitcode');
				$map2['oddt_odid']=$data['od_id'];
				$data2 = $Orderdetail->where($map2)->order('oddt_id DESC')->limit(100)->select();
				$imgpath = BASE_PATH.'/Public/uploads/product/';
				foreach($data2 as $kk=>$vv){
					//产品
					$map3=array();
					$data3=array();
					$map3['pro_id']=$vv['oddt_proid'];
					$map3['pro_unitcode']=session('unitcode');
					$data3=$Product->where($map3)->find();
					if($data3){
						if(is_not_null($data3['pro_pic']) && file_exists($imgpath.$data3['pro_pic'])){
							$data2[$kk]['oddt_propic']=$data3['pro_pic'];
						}else{
							$data2[$kk]['oddt_propic']='';
						}
					}else{
						$data2[$kk]['oddt_propic']='';
					}
					
					//订购数 发货数
					$oddt_totalqty=0;
					$oddt_unitsqty=0;
					if($vv['oddt_prodbiao']>0){
						$oddt_unitsqty=$vv['oddt_prodbiao'];
						
						if($vv['oddt_prozbiao']>0){
							$oddt_unitsqty=$oddt_unitsqty*$vv['oddt_prozbiao'];
						}
						
						if($vv['oddt_proxbiao']>0){
							$oddt_unitsqty=$oddt_unitsqty*$vv['oddt_proxbiao'];
						}
						
						$oddt_totalqty=$oddt_unitsqty*$vv['oddt_qty'];
					}else{
						$oddt_totalqty=$vv['oddt_qty'];
					}
					if($oddt_totalqty==0 || $oddt_totalqty==$vv['oddt_qty']){
						$data2[$kk]['oddt_totalqty']='';
					}else{
						$data2[$kk]['oddt_totalqty']='('.$oddt_totalqty.'件)';
					}
					
					$map3=array();
					$data3=array();
					$map3['ship_pro']=$vv['oddt_proid'];
					$map3['ship_unitcode']=session('unitcode');
					$map3['ship_odid']=$vv['oddt_odid'];
					$map3['ship_dealer']=$data['od_oddlid']; //出货接收方
					$data3=$Shipment->where($map3)->sum('ship_proqty');
			
					if($data3){
						if($oddt_unitsqty>0){
							$data2[$kk]['oddt_shipqty']=floor($data3/$oddt_unitsqty).$vv['oddt_prounits'].'('.$data3.'件)';
						}else{
							$data2[$kk]['oddt_shipqty']=$data3.$vv['oddt_prounits'];
						}
					}else{
						$data2[$kk]['oddt_shipqty']=0;
					}
					//出货按钮
					if($data['od_state']==1 || $data['od_state']==2 || $data['od_state']==3){
						if($oddt_totalqty>0){
							if($oddt_totalqty>$data3){
								$data2[$kk]['oddt_shipment']='<a class="abotton"  href="'.U('./Mp/Orders/xnodshipscan?od_id='.$data['od_id'].'&oddt_id='.$vv['oddt_id'].'').'"   >出 货</a>';
							}else{
								$data2[$kk]['oddt_shipment']='';
							}
						}else{
							if($vv['oddt_qty']>$data3){
								$data2[$kk]['oddt_shipment']='<a class="abotton"  href="'.U('./Mp/Orders/xnodshipscan?od_id='.$data['od_id'].'&oddt_id='.$vv['oddt_id'].'').'" >出 货</a>';
							}else{
								$data2[$kk]['oddt_shipment']='';
							}
						}
					}else{
						$data2[$kk]['oddt_shipment']='';
					}
					
				}
				$data['orderdetail']=$data2;
				
				//下单代理信息
				$map3=array();
				$data3=array();
				$map3['dl_id']=$data['od_oddlid'];
				$map3['dl_unitcode']=session('unitcode');
				$data3=$Dealer->where($map3)->find();
				if($data3){
					$data['od_dl_name']=$data3['dl_name'];
					$data['od_dl_tel']=$data3['dl_tel'];
					$data['od_dl_username']=$data3['dl_username'];
				}else{
					$data['od_dl_name']='';
					$data['od_dl_tel']='';
					$data['od_dl_username']='';
				}
				
				//接单代理信息
				if($data['od_rcdlid']>0){
					$map3=array();
					$data3=array();
					$map3['dl_id']=$data['od_rcdlid'];
					$map3['dl_unitcode']=session('unitcode');
					$data3=$Dealer->where($map3)->find();
					if($data3){
						$data['od_rcdl_name']=$data3['dl_name'];
						$data['od_rcdl_tel']=$data3['dl_tel'];
						$data['od_rcdl_username']=$data3['dl_username'];
					}else{
						$data['od_rcdl_name']='';
						$data['od_rcdl_tel']='';
						$data['od_rcdl_username']='';
					}
				}else{
					$data['od_rcdl_name']='总公司';
					$data['od_rcdl_tel']='';
					$data['od_rcdl_username']='';
				}
				
				
				//快递物流
				if($data['od_express']>0){
				    $map3=array();
					$data3=array();
					$Express= M('Express');
					$map3['exp_id']=$data['od_express'];
					$data3=$Express->where($map3)->find();
					if($data3){
						$data['od_expressname']=$data3['exp_name'];
						//可以从快递100接口获取数据
						
						
					}else{
						$data['od_expressname']='';
					}
				}else{
					$data['od_expressname']='';
				}
				
				//状态
				if($data['od_state']==0){
					$data['od_state_str']='待确认';
				}else if($data['od_state']==1){
					$data['od_state_str']='待发货';
				}else if($data['od_state']==2){
					$data['od_state_str']='部分发货';
				}else if($data['od_state']==3){
					$data['od_state_str']='已发货';
				}else if($data['od_state']==8){
					$data['od_state_str']='已完成';
				}else if($data['od_state']==9){
					$data['od_state_str']='已取消';
				}else{
					$data['od_state_str']='未知';
				}
				
				$imgpath2 = BASE_PATH.'/Public/uploads/orders/';
				
				if(is_not_null($data['od_paypic']) && file_exists($imgpath2.$data['od_paypic'])){
					$data['od_paypic_str']='<a target="_blank" href="'.__ROOT__.'/Public/uploads/orders/'.$data['od_paypic'].'" ><img src="'.__ROOT__.'/Public/uploads/orders/'.$data['od_paypic'].'"   border="0"  style="width:20%;"  ></a>';
				}else{
					$data['od_paypic_str']='';
				}
				//允许操作
				$caozuostr='';
				if($data['od_state']==1 || $data['od_state']==2 || $data['od_state']==3 ){
					if($data['od_express']>0){
						//$caozuostr='<input name="odfinishship2" id="odfinishship2" class="botton"  value="完成订货" type="button"> ';
					}else{
						$caozuostr='<input name="odfinishship"  id="odfinishship" class="botton" value="完成订货" type="submit"> ';
					}
				}
				
				
				$data['caozuostr']=$caozuostr;	
				
				//操作日志
				$Orderlogs= M('Orderlogs');
				$map2=array();
				$map2['odlg_unitcode']=session('unitcode');
				$map2['odlg_odid']=$od_id;

				$logs = $Orderlogs->where($map2)->order('odlg_addtime DESC')->limit(50)->select();
				foreach($logs as $kkk=>$vvv){
					if($vvv['odlg_type']==0){
						 $logs[$kkk]['odlg_dlname']='总公司';
					}
				}
			
			}else{
				$this->error('没有该记录','',2);
			}
		}else{
			$this->error('没有该记录','',2);
		}

		// var_dump($data);
		$this->assign('back', $back);
		$this->assign('orderlogs', $logs);
		$this->assign('ordersinfo', $data);
		$this->assign('od_id', $od_id);
		$this->assign('odbl_id', $odbl_id);
		$this->assign('curr', 'xnorders');
		
		$this->display('xnorderdetail');
    }
	
 	//完成订货发货 
    public function xnodfinishship(){
        $this->check_qypurview('13010',1);

		$od_id=intval(I('param.od_id',0));
		$isok=intval(I('param.isok',0));
		if($od_id>0){
			$Orders=M('Orders');
			$map=array();
			$map['od_unitcode']=session('unitcode');
			$map['od_id']=$od_id;
			$map['od_virtualstock']=1; //0--非虚拟库存订单 1--虚拟库存订单

			$data =$Orders->where($map)->find();
			if($data){
				//订单产品详细
				$Orderdetail= M('Orderdetail');
				$Product= M('Product');
				$Shipment= M('Shipment');
				$Dealer= M('Dealer');
				
				$map2=array();
				$data2=array();
				$map2['oddt_unitcode']=session('unitcode');
				$map2['oddt_odid']=$data['od_id'];
				$data2 = $Orderdetail->where($map2)->order('oddt_id DESC')->limit(100)->select();
				$imgpath = BASE_PATH.'/Public/uploads/product/';
				foreach($data2 as $kk=>$vv){
					//产品
					$map3=array();
					$data3=array();
					$map3['pro_id']=$vv['oddt_proid'];
					$map3['pro_unitcode']=session('unitcode');
					$data3=$Product->where($map3)->find();
					if($data3){
						if(is_not_null($data3['pro_pic']) && file_exists($imgpath.$data3['pro_pic'])){
							$data2[$kk]['oddt_propic']=$data3['pro_pic'];
						}else{
							$data2[$kk]['oddt_propic']='';
						}
					}else{
						$data2[$kk]['oddt_propic']='';
					}
					
					//订购数 
					$oddt_totalqty=0;
					$oddt_unitsqty=0;
					if($vv['oddt_prodbiao']>0){
						$oddt_unitsqty=$vv['oddt_prodbiao'];
						
						if($vv['oddt_prozbiao']>0){
							$oddt_unitsqty=$oddt_unitsqty*$vv['oddt_prozbiao'];
						}
						
						if($vv['oddt_proxbiao']>0){
							$oddt_unitsqty=$oddt_unitsqty*$vv['oddt_proxbiao'];
						}
						
						$oddt_totalqty=$oddt_unitsqty*$vv['oddt_qty'];
					}else{
						$oddt_totalqty=$vv['oddt_qty'];
					}
					if($oddt_totalqty==0 || $oddt_totalqty==$vv['oddt_qty']){
						$data2[$kk]['oddt_totalqty']='';
					}else{
						$data2[$kk]['oddt_totalqty']='('.$oddt_totalqty.'件)';
					}
					
					//发货数
					$map3=array();
					$data3=array();
					$map3['ship_pro']=$vv['oddt_proid'];
					$map3['ship_unitcode']=session('unitcode');
					$map3['ship_odid']=$vv['oddt_odid'];
					$map3['ship_dealer']=$data['od_oddlid']; //出货接收方
					$data3=$Shipment->where($map3)->sum('ship_proqty');
			
					if($data3){
						if($oddt_unitsqty>0){
							$data2[$kk]['oddt_shipqty']=floor($data3/$oddt_unitsqty).$vv['oddt_prounits'].'('.$data3.'件)';
						}else{
							$data2[$kk]['oddt_shipqty']=$data3.$vv['oddt_prounits'];
						}
						
                        if($oddt_totalqty==0 || $oddt_totalqty>$data3 ){
							/*
							if($this->check_qypurview('13004',0)){
								//完成订单不以完成出货为条件
								if($isok==0){
									$msg=array('stat'=>'9','msg'=>'');
									echo json_encode($msg);
									exit;
								}
							}else{
								$msg=array('stat'=>'0','msg'=>'该订单还没完成出货');
								echo json_encode($msg);
								exit;
							}
							*/
						}
						if( $oddt_totalqty<$data3){
							/*
							$msg=array('stat'=>'0','msg'=>'该订单出货的数量大于订购数量');
							echo json_encode($msg);
							exit;
							*/
						}
						
					}else{
						/*
						if($this->check_qypurview('13004',0)){
							//完成订单不以完成出货为条件
							if($isok==0){
								$msg=array('stat'=>'9','msg'=>'');
								echo json_encode($msg);
								exit;
							}
							$data2[$kk]['oddt_shipqty']=0;
						}else{
							$msg=array('stat'=>'0','msg'=>'该订单还没完成出货');
							echo json_encode($msg);
							exit;
						}
						*/
					}
				}
				$data['orderdetail']=$data2;
				
				
				//快递物流
				if($data['od_express']>0){
				    $map3=array();
					$data3=array();
					$Express= M('Express');
					$map3['exp_id']=$data['od_express'];
					$data3=$Express->where($map3)->find();
					if($data3){
						$data['od_expressname']=$data3['exp_name'];
						//可以从快递100接口获取数据
						
						
					}else{
						$data['od_expressname']='';
					}
				}else{
					$data['od_expressname']='';
				}
				
				//状态
				if($data['od_state']==0){
					$data['od_state_str']='待确认';
				}else if($data['od_state']==1){
					$data['od_state_str']='待发货';
				}else if($data['od_state']==2){
					$data['od_state_str']='部分发货';
				}else if($data['od_state']==3){
					$data['od_state_str']='已发货';
				}else if($data['od_state']==8){
					$data['od_state_str']='已完成';
				}else if($data['od_state']==9){
					$data['od_state_str']='已取消';
				}else{
					$data['od_state_str']='未知';
				}
				
				if($data['od_express']<=0){
					$title='确认完成订货';
				}else{
					$title='确认完成订货';
				}
				
			
			}else{
				$msg=array('stat'=>'0','msg'=>'没有该记录');
				echo json_encode($msg);
				exit;
			}
		}else{
			$msg=array('stat'=>'0','msg'=>'没有该记录');
			echo json_encode($msg);
			exit;
		}
		
		if($isok==0){
			$msg=array('stat'=>'1','msg'=>'');
			echo json_encode($msg);
			exit;
		}
		
		//物流快递
		$Express = M('Express');
		$map=array();
		$expresslist = $Express->where($map)->order('exp_addtime DESC')->select();
		
		$this->assign('title', $title);
		$this->assign('expresslist', $expresslist);
			
		$this->assign('ordersinfo', $data);
		$this->assign('od_id', $od_id);
		$this->assign('odbl_id', $odbl_id);
		 $this->assign('curr', 'qborders');
		
		$this->display('xnodfinishship');
    }
	
    //完成订货 保存
    public function xnodfinishship_save(){
        $this->check_qypurview('13010',1);
		
		$od_id=intval(I('post.od_id',0));
		if($od_id>0){
			$od_express=intval(I('post.od_express',0));
			$od_expressnum=I('post.od_expressnum','');
			$od_remark=I('post.od_remark','');
			if($od_express<=0){
				$this->error('请选择物流快递','',2);
				exit;
			}
			$Orders=M('Orders');
			$map=array();
			$map['od_unitcode']=session('unitcode');
			$map['od_id']=$od_id;
			$map['od_virtualstock']=1; //0--非虚拟库存订单 1--虚拟库存订单

			$data = $Orders->where($map)->find();
			if($data){	
				//检测是否能发货 //订购数 发货数
				$Orderdetail = M('Orderdetail');
				$Shipment = M('Shipment');
				$map2=array();
				$oddetail=array();
				$map2['oddt_unitcode']=session('unitcode');
				$map2['oddt_odid']=$od_id;
				$oddetail = $Orderdetail->where($map2)->order('oddt_id DESC')->limit(100)->select();
				$proids=array();
				foreach($oddetail as $kk=>$vv){
					$proids[]=$vv['oddt_proid'];
					//订购数 
					$oddt_totalqty=0;
					$oddt_unitsqty=0;
					if($vv['oddt_prodbiao']>0){
						$oddt_unitsqty=$vv['oddt_prodbiao'];
						
						if($vv['oddt_prozbiao']>0){
							$oddt_unitsqty=$oddt_unitsqty*$vv['oddt_prozbiao'];
						}
						
						if($vv['oddt_proxbiao']>0){
							$oddt_unitsqty=$oddt_unitsqty*$vv['oddt_proxbiao'];
						}
						
						$oddt_totalqty=$oddt_unitsqty*$vv['oddt_qty'];
					}
					if($oddt_totalqty==0){
						$oddt_totalqty=$vv['oddt_qty'];
					}
					
					$oddetail[$kk]['oddt_totalqty']=$oddt_totalqty;
					
					/*
					//发货数
					$map3=array();
					$data3=array();
					$map3['ship_pro']=$vv['oddt_proid'];
					$map3['ship_unitcode']=session('unitcode');
					$map3['ship_odid']=$vv['oddt_odid'];
					$map3['ship_dealer']=$data['od_oddlid']; //出货接收方
					$data3=$Shipment->where($map3)->sum('ship_proqty');
					if($data3){
						if($oddt_totalqty==0 || $oddt_totalqty>$data3 ){
							if($this->check_qypurview('13004',0)){
								//完成订单不以完成出货为条件
							}else{
								$this->error('该订单还没完成出货','',2);
								exit;
							}
						}	
                        if( $oddt_totalqty<$data3){
							$this->error('该订单出货的数量大于订购数量','',2);
							exit;
						}
					}else{
						if($this->check_qypurview('13004',0)){
							//完成订单不以完成出货为条件
						}else{
							$this->error('该订单还没完成出货','',2);
							exit;
						}
					}
					*/
				}
			}else{
                $this->error('该订单记录不存在','',2);
				exit;
			}
			
			$Orders= M('Orders');
			$Orderbelong= M('Orderbelong');
			
			//写入物流信息
			$map2=array();
			$updata2=array();
			$map2['od_unitcode']=session('unitcode');
			$map2['od_id']=$od_id;
			
			$updata2['od_express']=$od_express;
			$updata2['od_expressnum']=$od_expressnum;
			$updata2['od_remark']=$od_remark;
			if($data['od_express']<=0){
				$updata2['od_expressdate']=time();
			}
			// $Orders->where($map2)->save($updata2);
			
			// // //订单关系状态更改
			// // $map2=array();
			// // $updata2=array();
			// // $map2['odbl_unitcode']=session('unitcode');
			// // $map2['odbl_id']=$odbl_id;
			// // $updata2['odbl_state']=8; //0--待确认  1--代发货 2--部分发货 3-已发货 8-已完成 9-已取消
			// // $Orderbelong->where($map2)->save($updata2);
			// //修改原始订单状态
			// if($data['od_oddlid']==$data['od_oddlid']){
				$map2=array();
				$updata2=array();
				$map2['od_unitcode']=session('unitcode');
				$map2['od_id']=$od_id;
				$updata2['od_state']=8;
				$Orders->where($map2)->save($updata2);
			// }
			if($data['od_express']<=0||$data['od_express']==5){
				//订单返利 begin
				//康利科技返利
				$fanli_dlid1=0;
				$fanli_dlname1='';
				$fanli_dlusername1='';
				
				$Dealer = M('Dealer');
				$Dltype = M('Dltype');
				$Profanli= M('Profanli');
				$Fanlidetail=M('Fanlidetail');
				//下单人
				$map3=array();
				$orderdealer=array();
				$map3['dl_unitcode'] = session('unitcode');
				$map3['dl_id'] = $data['od_oddlid'];  //下单的代理
				$orderdealer=$Dealer->where($map3)->find();
				if($orderdealer){
					$map1 = array();
					$map1['dlt_id'] = $orderdealer['dl_type'];
					$map1['dlt_unitcode'] = session('unitcode');
					$type = $Dltype->field('dlt_level')->where($map1)->find();
					if($type){
						$order_level = $type['dlt_level'];  //下单代理级别
					}else{
						$order_level = $orderdealer['dl_level'];
					}
					$map2=array();
					$map2['pfl_unitcode'] = session('unitcode');
					$map2['pfl_dltype'] = $orderdealer['dl_type'];
					$map2['pfl_fanli1'] = array('GT',0);
					if($proids){
						$map2['pfl_proid'] = array('IN',$proids);
					}
					$data2=$Profanli->where($map2)->find(); //是否有设置返利
					if($data2){
						//下单代理的推荐人
						if($orderdealer['dl_referee']>0){//推荐人不是公司
							//下单代理的推荐人 如果正常并与发货人不同 则返利
							$map4=array();
							$data4=array();
							$map4['dl_unitcode'] = session('unitcode');
							$map4['dl_id'] = $orderdealer['dl_referee'];  //下单代理的推荐人
							$map4['dl_status'] = 1;					
							$data4=$Dealer->where($map4)->find();
							if($data4){//data4为推荐人
//							    $data为该订单
								//如果推荐人和发货人不相同 则都返利给推荐人 并同级
								if($data['od_rcdlid']!=$data4['dl_id']&&$order_level==$data4['dl_level']){//$order_level为下单代理级别
									//返利给推荐人
									$fanli_dlid1=$data4['dl_id']; //返利的代理商1
									$fanli_dlname1=$data4['dl_name'];
									$fanli_dlusername1=$data4['dl_username'];
									 //推荐人的推荐人
									if($data4['dl_referee']>0){
										$map5=array();
										$data5=array();
										$map5['dl_unitcode'] = session('unitcode');
										$map5['dl_id'] = $data4['dl_referee'];  //推荐人的推荐人
										$map5['dl_status'] = 1;
										$data5=$Dealer->where($map5)->find();
										if($data5){
											//如果推荐人的推荐人和发货人不相同 则都返利给推荐人 并同级
											if($data5['dl_id']>0 && $data4['dl_level']==$data5['dl_level']){
													$fanli_dlid2=$data5['dl_id']; //返利给的代理商2
													$fanli_dlname2=$data5['dl_name'];
													$fanli_dlname2=$data6['dl_username'];
											}
										}
									}
								}
							}
						}
						//写入返利数据
						if($fanli_dlid1>0){
							$map7=array();
							$data7=array();
							$map7['pfl_unitcode'] = session('unitcode');
							$map7['pfl_proid'] = $vv['oddt_proid'];
							$map7['pfl_dltype'] = $orderdealer['dl_type'];
							$map7['pfl_fanli1'] = array('GT',0);
							$data7=$Profanli->where($map7)->find();//根据产品id，经销商等级，返利已设置查找返利第1层
							//如果订单产品有设置返利 1层
							if($data7){
								if($data7['pfl_fanli1']>0){
									$map8=array();
									$data8=array();
									$map8['fl_unitcode'] = session('unitcode');
									$map8['fl_type'] = 2;
									$map8['fl_odid'] = $vv['oddt_odid'];
									$map8['fl_proid'] = $vv['oddt_proid'];
									$map8['fl_oddlid'] = $orderdealer['dl_id'];
									$map8['fl_level'] = 1;
									$data8 = $Fanlidetail->where($map8)->find();
									if(!$data8){
										//佣金数字在1-0间，则以下单价的百分比计算，如0.03代表以下单价的3%计算，如果大于1，则以具体多少元计算
										if($data7['pfl_fanli1']>0 && $data7['pfl_fanli1']<1){
											$pfl_fanli1sum=$data7['pfl_fanli1']*$vv['oddt_dlprice']*$vv['oddt_qty'];
										}else{
											$pfl_fanli1sum=$data7['pfl_fanli1']*$vv['oddt_qty'];
										}
										$data5=array();
										$data5['fl_unitcode'] = session('unitcode');
										$data5['fl_dlid'] = $fanli_dlid1; //获得返利的代理
										$data5['fl_senddlid'] = $data['od_rcdlid']; //发放返利的代理 0为公司发放
										$data5['fl_type'] = 2; //返利分类 1-推荐返利 2-订单返利  11-提现减少返利 (1-10 增加返利 11-20 减少返利)  
										$data5['fl_money'] = $pfl_fanli1sum;
										$data5['fl_refedlid'] = 0; //推荐返利中被推荐的代理
										$data5['fl_oddlid'] = $orderdealer['dl_id']; //订单返利中 下单的代理
										$data5['fl_odid'] = $vv['oddt_odid'];  //订单返利中 订单流水id
										$data5['fl_orderid']  = $vv['oddt_orderid']; //订单返利中 订单编号id
										$data5['fl_proid']  = $vv['oddt_proid'];  //订单返利中 产品id
										$data5['fl_odblid']  = $vv['oddt_odblid'];  //订单返利中 订单关系id
										$data5['fl_qty']  = $vv['oddt_qty'];  //订单返利中 产品数量
										$data5['fl_level']  = 1;  //返利的层次，1-第一层返利 2-第二层返利
										$data5['fl_addtime']  = time();
										$data5['fl_remark'] ='代理 '.$orderdealer['dl_username'].' 订购 '.$vv['oddt_proname'].' 数量 '.$vv['oddt_qty'] ;
										$rs5=$Fanlidetail->create($data5,1);
										if($rs5){
											$Fanlidetail->add();
										}
									}
								}
							}
							//如果有设置2层返利
							if($fanli_dlid2>0){
								$map7=array();
								$data7=array();
								$map7['pfl_unitcode'] = session('unitcode');
								$map7['pfl_proid'] = $vv['oddt_proid'];
								$map7['pfl_dltype'] = $orderdealer['dl_type'];
								$map7['pfl_fanli2'] = array('GT',0);
								$data7=$Profanli->where($map7)->find();
								if($data7){
									if($data7['pfl_fanli2']>0){
										$map8=array();
										$data8=array();
										$map8['fl_unitcode'] = session('unitcode');
										$map8['fl_type'] = 2;
										$map8['fl_odid'] = $vv['oddt_odid'];
										$map8['fl_proid'] = $vv['oddt_proid'];
										$map8['fl_oddlid'] = $orderdealer['dl_id'];
										$map8['fl_level'] = 2;
										$data8 = $Fanlidetail->where($map8)->find();
										if(!$data8){
											//佣金数字在1-0间，则以下单价的百分比计算，如0.03代表以下单价的3%计算，如果大于1，则以具体多少元计算
											if($data7['pfl_fanli2']>0 && $data7['pfl_fanli2']<1){
												$pfl_fanli2sum=$data7['pfl_fanli2']*$vv['oddt_dlprice']*$vv['oddt_qty'];
											}else{
												$pfl_fanli2sum=$data7['pfl_fanli2']*$vv['oddt_qty'];
											}
											
											$data5=array();
											$data5['fl_unitcode'] = session('unitcode');
											$data5['fl_dlid'] = $fanli_dlid2; //获得返利的代理
											$data5['fl_senddlid'] = $data['od_rcdlid']; //发放返利的代理
											$data5['fl_type'] = 2; //返利分类 1-推荐返利 2-订单返利  11-提现减少返利 (1-10 增加返利 11-20 减少返利)  
											$data5['fl_money'] = $pfl_fanli2sum;
											$data5['fl_refedlid'] = 0; //推荐返利中被推荐的代理
											$data5['fl_oddlid'] = $orderdealer['dl_id']; //订单返利中 下单的代理
											$data5['fl_odid'] = $vv['oddt_odid'];  //订单返利中 订单流水id
											$data5['fl_orderid']  = $vv['oddt_orderid']; //订单返利中 订单id
											$data5['fl_proid']  = $vv['oddt_proid'];  //订单返利中 产品id
											$data5['fl_odblid']  = $vv['oddt_odblid'];  //订单返利中 订单关系id
											$data5['fl_qty']  = $vv['oddt_qty'];  //订单返利中 产品数量
											$data5['fl_level']  = 2;  //返利的层次，1-第一层返利 2-第二层返利
											$data5['fl_addtime']  = time();
											$data5['fl_remark'] ='代理 '.$fanli_dlname1.' 的邀请代理 '.$orderdealer['dl_username'].' 订购 '.$vv['oddt_proname'].' 数量 '.$vv['oddt_qty'] ;
											$rs5=$Fanlidetail->create($data5,1);
											if($rs5){
												$Fanlidetail->add();
											}
										}
									}
								}
							}
						}
					}

				}

				//返利 end
				//减少库存 只有向公司下单的才减少
				if($this->check_qypurview('20012',0) && $orderdealer['dl_belong']==0){
					$Product= M('Product');
					foreach($oddetail as $kkk=>$vvv){
						$map2=array();
						$map2['pro_unitcode']=session('unitcode');
						$map2['pro_id'] =$vvv['oddt_proid'];
						$data2=$Product->where($map2)->find();
						if($data2){
							$data3=array();
							$data3['pro_stock']=$data2['pro_stock']-$vvv['oddt_totalqty'];
                            $Product->where($map2)->data($data3)->save();
						}
					}
				}
				//减少库存 end

				
				//订单操作日志 begin
				$odlog_arr=array(
							'odlg_unitcode'=>session('unitcode'),  
							'odlg_odid'=>$od_id,
							'odlg_orderid'=>$data['od_orderid'],
							'odlg_dlid'=>session('qyid'),
							'odlg_dlusername'=>session('qyuser'),
							'odlg_dlname'=>session('qyuser'),
							'odlg_action'=>'完成订货',
							'odlg_type'=>0, //0-企业 1-经销商
							'odlg_addtime'=>time(),
							'odlg_ip'=>real_ip(),
							'odlg_link'=>__SELF__
							);
				$Orderlogs = M('Orderlogs');
				$rs3=$Orderlogs->create($odlog_arr,1);
				if($rs3){
					$Orderlogs->add();
				}
				//订单操作日志 end
			}
			
			$this->error('完成订货提交成功',U('Mp/Orders/xnorderdetail/od_id/'.$od_id.'/back/1'),2);
			exit;
		}else{
			$this->error('该订单记录不存在','',2);
			exit;
		}
	}
   
	//递归查找推荐人 $referee 推荐人ID $num 查找的层次   //旨来脂去
	public function findreferee($referee, $num){
		$this->check_qypurview('13010',1);
		
		if($referee > 0 && $num > 0){
			static $referee_list = array();
			$Dealer = M('Dealer');
			$map = array();
			$map['dl_id'] = $referee;
			$map['dl_unitcode']=session('unitcode');
			$fields = 'dl_id,dl_referee';
			$data = $Dealer->field($fields)->where($map)->find();
			if($data){ 
				if($data['dl_referee'] > 0 ){
					$map1 = array();
					$map1['dl_id'] = $data['dl_referee'];
					$map1['dl_unitcode'] = session('unitcode');
					$fields = 'dl_id,dl_username,dl_status,dl_referee,dl_level,dl_type';
					$list = $Dealer->field($fields)->where($map1)->find();
					if($list){
						if($num > 0){
							if($list['dl_status'] == 1){
								$num--;
								$referee_list[] = $list;
							}
							if($list['dl_referee'] > 0 ){
								$this->findreferee($data['dl_referee'], $num);
							}
						}
						
					}
					
				}
			}
			return $referee_list;
		}
	}

   
	
	//按订单出货扫码 
	public function odshipscan(){
        $this->check_qypurview('13001',1);
		
		//--------------------------------
		$od_id=intval(I('get.od_id',0));
		// $odbl_id=intval(I('get.odbl_id',0));
		$oddt_id=intval(I('get.oddt_id',0));
		
		
		if($od_id>0&& $oddt_id>0){
            //对应订单
			$Orders=M('Orders');
			$map=array();
			$order=array();
			$map['od_unitcode']=session('unitcode');
			$map['od_id']=$od_id;
			$map['od_rcdlid']=0;//下给公司的订单
			$order =$Orders->where($map)->find();
			if($order){
				if($order['od_state']!=1 && $order['od_state']!=2 && $order['od_state']!=3){
					$this->error('该订单暂不能出货','',2);
				}
			}else{
				$this->error('没有该记录','',2);
			}
			
            //收货代理信息 下单代理
            $Dealer= M('Dealer');
			$map3=array();
			$data3=array();
			$map3['dl_id']=$order['od_oddlid'];
			$map3['dl_unitcode']=session('unitcode');
			$map3['dl_status']=1;
			$data3=$Dealer->where($map3)->find();

			if($data3){
				$order['od_dl_name']=$data3['dl_name'];
				$order['od_dl_username']=$data3['dl_username'];
			}else{
				$this->error('下单代理不存在或已禁用','',2);
			}
			
			//仓库
			$map2=array();
			$map2['wh_unitcode']=session('unitcode');
			$Warehouse = M('Warehouse');
			$list3 = $Warehouse->where($map2)->order('wh_id ASC')->select();
			$this->assign('warehouselist', $list3);


			//对应产品
			$Orderdetail= M('Orderdetail');
			$map=array();
			$data=array();
			$map['oddt_unitcode']=session('unitcode');
			$map['oddt_id']=$oddt_id;
			$map['oddt_odid']=$od_id;
			$data = $Orderdetail->where($map)->find();
			if($data){
				//订购数 发货数
				$oddt_totalqty=0;
				$oddt_unitsqty=0;
				if($data['oddt_prodbiao']>0){
					$oddt_unitsqty=$data['oddt_prodbiao'];
					
					if($data['oddt_prozbiao']>0){
						$oddt_unitsqty=$oddt_unitsqty*$data['oddt_prozbiao'];
					}
					
					if($data['oddt_proxbiao']>0){
						$oddt_unitsqty=$oddt_unitsqty*$data['oddt_proxbiao'];
					}
					
					$oddt_totalqty=$oddt_unitsqty*$data['oddt_qty'];
				}else{
					$oddt_totalqty=$data['oddt_qty'];
				}
				if($oddt_totalqty==0 || $oddt_totalqty==$data['oddt_qty']){
					$data['oddt_totalqty']='';
				}else{
					$data['oddt_totalqty']='('.$oddt_totalqty.'件)';
				}
				
				$Shipment= M('Shipment');
				$map3=array();
				$data3=array();
				$map3['ship_pro']=$data['oddt_proid'];
				$map3['ship_unitcode']=session('unitcode');
				$map3['ship_odid']=$data['oddt_odid'];
				$map3['ship_oddtid']=$data['oddt_id'];
				$map3['ship_dealer']=$order['od_oddlid']; //出货接收方
				$data3=$Shipment->where($map3)->sum('ship_proqty');
				if($data3){
					if($oddt_unitsqty>0){
						$data['oddt_shipqty']=floor($data3/$oddt_unitsqty).$data['oddt_prounits'].'('.$data3.'件)';
					}else{
						$data['oddt_shipqty']=$data3.$data['oddt_prounits'];
					}
				}else{
					$data['oddt_shipqty']=0;
				}
				
				$data['oddt_proname']=$data['oddt_proname'].$data['oddt_color'].$data['oddt_size'];

			}else{
				$this->error('没有该记录','',2);
			}
		}else{
			$this->error('没有该记录','',2);
		}
		
		
		$this->assign('od_id', $od_id);
		$this->assign('odbl_id', $odbl_id);
		$this->assign('oddt_id', $oddt_id);
		
		$this->assign('ordersbase', $order);
		$this->assign('ordersinfo', $data);
		$this->display('odshipscan');
	}
	
	//代理商按订单出货扫描结果
    public function odshipscanres(){
        $this->check_qypurview('13001',1);
		//--------------------------------
		$od_id=intval(I('post.od_id',0));
		// $odbl_id=intval(I('post.odbl_id',0));
		$oddt_id=intval(I('post.oddt_id',0));
		$ship_whid=intval(I('post.ship_whid',0));
		$ship_barcode=I('post.ship_barcode','');
		$ship_remark=I('post.ship_remark','');
		
		if($od_id==0 || $oddt_id==0){
			$this->error('该订单记录不存在','',2);
            exit;
		}
		if($ship_whid==0){
			$this->error('请选择出货仓库','',2);
            exit;
		}
		if($ship_barcode==''){
			$this->error('请填写产品条码','',2);
            exit;
		}
		$ship_barcode=str_replace("\r",'',$ship_barcode);
        $ship_barcode=str_replace("chr(13)",'',$ship_barcode);
        $ship_barcode=str_replace("chr(10)",'',$ship_barcode);
		$linearr=explode("\n",$ship_barcode);  //输入的条码数据
		
		if($od_id>0 && $oddt_id>0){
            //对应订单
			$Orders=M('Orders');
			$map=array();
			$order=array();
			$map['od_unitcode']=session('unitcode');
			$map['od_id']=$od_id;
			$map['od_rcdlid']=0;//下给公司的订单
			$order =$Orders->where($map)->find();
			if($order){
				if($order['od_state']!=1 && $order['od_state']!=2 && $order['od_state']!=3){
					$this->error('该订单暂不能出货','',2);
				}
			}else{
				$this->error('没有该记录','',2);
			}
			
            //收货代理信息 下单代理
            $Dealer= M('Dealer');
			$map3=array();
			$data3=array();
			$map3['dl_id']=$order['od_oddlid'];
			$map3['dl_unitcode']=session('unitcode');
			$map3['dl_status']=1;
			$data3=$Dealer->where($map3)->find();

			if($data3){
				$order['od_dl_name']=$data3['dl_name'];
				$order['od_dl_username']=$data3['dl_username'];
			}else{
				$this->error('下单代理不存在或已禁用','',2);
			}
			
			//仓库
			$map2=array();
			$map2['wh_id']=$ship_whid;
			$map2['wh_unitcode']=session('unitcode');
			$Warehouse = M('Warehouse');
			$data2=$Warehouse->where($map2)->find();
			if($data2){
				$order['od_wh_name']=$data2['wh_name'];
			}else{
				$this->error('请选择出货仓库','',2);
			}



			//对应产品
			$Orderdetail= M('Orderdetail');
			$map=array();
			$data=array();
			$map['oddt_unitcode']=session('unitcode');
			$map['oddt_id']=$oddt_id;
			$map['oddt_odid']=$od_id;
			$data = $Orderdetail->where($map)->find();
			if($data){
				//订购数 
				$oddt_totalqty=0;
				$oddt_unitsqty=0; //大标单位数
				if($data['oddt_prodbiao']>0){
					$oddt_unitsqty=$data['oddt_prodbiao'];
					
					if($data['oddt_prozbiao']>0){
						$oddt_unitsqty=$oddt_unitsqty*$data['oddt_prozbiao'];
					}
					
					if($data['oddt_proxbiao']>0){
						$oddt_unitsqty=$oddt_unitsqty*$data['oddt_proxbiao'];
					}
					
					$oddt_totalqty=$oddt_unitsqty*$data['oddt_qty'];
				}else{
					$oddt_totalqty=$data['oddt_qty'];
				}
				if($oddt_totalqty==0 || $oddt_totalqty==$data['oddt_qty']){
					$data['oddt_totalqty']='';
				}else{
					$data['oddt_totalqty']='('.$oddt_totalqty.'件)';
				}
				//发货数
				$Shipment= M('Shipment');
				$map3=array();
				$data3=array();
				$map3['ship_pro']=$data['oddt_proid'];
				$map3['ship_unitcode']=session('unitcode');
				$map3['ship_odid']=$data['oddt_odid'];
				$map3['ship_oddtid']=$data['oddt_id'];
				$map3['ship_dealer']=$order['od_oddlid']; //出货接收方
				$data3=$Shipment->where($map3)->sum('ship_proqty');
				if($data3){
					if($oddt_unitsqty>0){
						$data['oddt_shipqty']=floor($data3/$oddt_unitsqty).$data['oddt_prounits'].'('.$data3.'件)';
					}else{
						$data['oddt_shipqty']=$data3.$data['oddt_prounits'];
					}
					$oddt_shipqty=$data3;
				}else{
					$data['oddt_shipqty']=0;
					$oddt_shipqty=0;
				}
				
				$data['oddt_proname']=$data['oddt_proname'].$data['oddt_color'].$data['oddt_size'];

			}else{
				$this->error('没有该记录','',2);
			}
			
			//对产品条码处理
			$msgs=array();
			$kk=0;
			$success=0; //有效条码
			$fail=0;    //无效条码
			$ship_barcode='';
			$Chaibox= M('Chaibox');
			$Storage= M('Storage');
			$Orderdetail=M('Orderdetail');
			$successarr=array();
			$scancount=0;
			foreach($linearr as $key =>$li){
				$ship_barcode=trim($li);
                if($ship_barcode==''){
                     continue;
                }
				//检测条码是否格式正确
                if(!preg_match("/^[a-zA-Z0-9]{4,30}$/",$ship_barcode)){
                    $msgs[$kk]['barcode']=$ship_barcode;
                    $msgs[$kk]['error']='<span style="color:#FF0000">录入条码 '.htmlspecialchars($ship_barcode).' 出错，条码应由数字字母组成</span>';
					$msgs[$kk]['qty']=0;
					$kk=$kk+1;
					$fail=$fail+1;
					continue;
                }
                //检测该条码是否已存在
                $map2=array();
                $data2=array();
                $map2['ship_unitcode']=session('unitcode');
                $map2['ship_barcode'] = $ship_barcode;
                $map2['ship_deliver']=0;
                $data2=$Shipment->where($map2)->find();
                if(is_not_null($data2)){
					$msgs[$kk]['barcode']=$ship_barcode;
                    $msgs[$kk]['error']='<span style="color:#FF0000">录入条码 '.$ship_barcode.' 出错，该条码已存在。</span>';
					$msgs[$kk]['qty']=0;
					$kk=$kk+1;
					$fail=$fail+1;
                    continue;
                }
				
                //检测是否已发行
                $barcode=array();
                $barcode=wlcode_to_packinfo($ship_barcode,session('unitcode'));
                
                if(!is_not_null($barcode)){
                    $msgs[$kk]['barcode']=$ship_barcode;
					$msgs[$kk]['error']='<span style="color:#FF0000">录入条码 '.$ship_barcode.' 出错，该条码还没发行。</span>';
					$msgs[$kk]['qty']=0;
					$kk=$kk+1;
					$fail=$fail+1;
                    continue;
                }
				
                //是否出货
                $map2=array();
                $where=array();
                $data2=array();
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
                $map2['ship_barcode'] = $where;
                $map2['ship_unitcode']=session('unitcode');
                $map2['ship_deliver']=0;

                $data2=$Shipment->where($map2)->find();
                if(is_not_null($data2)){
					$msgs[$kk]['barcode']=$ship_barcode;
                    $msgs[$kk]['error']='<span style="color:#FF0000">录入条码 '.$ship_barcode.' 出错，该条码已存在。</span>';
					$msgs[$kk]['qty']=$barcode['qty'];
					$kk=$kk+1;
					$fail=$fail+1;
                    continue;
                }

 				$map3=array();
				$map3['stor_unitcode']=session('unitcode');
				$map3['stor_barcode'] = $where;
				$dataStro=$Storage->where($map3)->find();
            	if(!is_not_null($dataStro)){
					$msgs[$kk]['barcode']=$ship_barcode;
                    $msgs[$kk]['error']='<span style="color:#FF0000">录入条码 '.$ship_barcode.' 出错，该条码还没入库。</span>';
					$msgs[$kk]['qty']=$barcode['qty'];
					$kk=$kk+1;
					$fail=$fail+1;
                    continue;
            	}else
            	{
            		$mapOD=array();
					$mapOD['stor_unitcode']=session('unitcode');
					$mapOD['oddt_id'] = $oddt_id;
					$dataOD=$Orderdetail->where($mapOD)->find();
					if (is_not_null($dataOD))
					{
						$map3['stor_pro'] =$dataOD['oddt_proid'];
            			$map3['stor_attrid'] =$dataOD['oddt_attrid'];
            			$dataStro=$Storage->where($map3)->find();
            			if(!is_not_null($dataStro)){
	            			$msgs[$kk]['barcode']=$ship_barcode;
	                    	$msgs[$kk]['error']='<span style="color:#FF0000">录入条码 '.$ship_barcode.' 出错，该产品与订单产品不一致。</span>';
							$msgs[$kk]['qty']=$barcode['qty'];
							$kk=$kk+1;
							$fail=$fail+1;
	                    	continue;
	            		}
					}
           		}
                //检测是否拆箱
                $map2=array();
                $data2=array();
                $map2['chai_unitcode']=session('unitcode');
                $map2['chai_barcode'] = $ship_barcode;
                $map2['chai_deliver']=0;
                $data2=$Chaibox->where($map2)->find();
                if(is_not_null($data2)){
					$msgs[$kk]['barcode']=$ship_barcode;
                    $msgs[$kk]['error']='<span style="color:#FF0000">录入条码 '.$ship_barcode.' 出错，该条码已经拆箱，不能再使用。</span>';
					$msgs[$kk]['qty']=0;
					$kk=$kk+1;
					$fail=$fail+1;
                    continue;
                }
			    if(array_key_exists(strval($ship_barcode),$successarr)===false){
					//有效条码
					$msgs[$kk]['barcode']=$ship_barcode;
					$msgs[$kk]['error']='录入条码 <b>'.$ship_barcode.' </b> 有效。';
					$msgs[$kk]['qty']=$barcode['qty'];
					$kk=$kk+1;
					$successarr[strval($ship_barcode)]=$barcode['qty'];
					$success=$success+1;
					$scancount=$scancount+$barcode['qty'];
					
					//判断录入条码的产品数是否超出要出货的数
					if(($scancount+$oddt_shipqty)>$oddt_totalqty){
						$this->error('发货产品数超出订购产品数','',2);
						exit;
					}
					
				}else{
					$msgs[$kk]['barcode']=$ship_barcode;
                    $msgs[$kk]['error']='<span style="color:#FF0000">录入条码 '.$ship_barcode.' 出错，该条码重复录入。</span>';
					$msgs[$kk]['qty']=0;
					$kk=$kk+1;
					$fail=$fail+1;
                    continue;
				}
			}
		}else{
			$this->error('该订单记录不存在','',2);
            exit;
		}
		

		$this->assign('od_id', $od_id);
		$this->assign('oddt_id', $oddt_id);
		$this->assign('ship_barcode', json_encode($successarr));
		$this->assign('msgs', $msgs);
		$this->assign('ordersinfo', $data);
		$this->assign('ordersbase', $order);
		$this->assign('ship_remark', $ship_remark);
		$this->assign('ship_whid', $ship_whid);
		$this->assign('scancount', $scancount);
		$this->assign('fail', $fail);
		$this->assign('success', $success);

        $this->display('odshipscanres');
	}
	
	//代理商按订单出货扫描保存
    public function odshipscanres_save(){
        $this->check_qypurview('13001',1);
		//--------------------------------
		$od_id=intval(I('post.od_id',0));
		$oddt_id=intval(I('post.oddt_id',0));
		$ship_whid=intval(I('post.ship_whid',0));
		$ship_barcode = (isset($_POST['ship_barcode']) && is_not_null($_POST['ship_barcode'])) ? trim($_POST['ship_barcode']):'';
		$ship_remark = (isset($_POST['ship_remark']) && is_not_null($_POST['ship_remark'])) ? trim($_POST['ship_remark']):'';
		
		if($od_id==0 || $oddt_id==0){
			$this->error('该订单记录不存在','',2);
            exit;
		}
		if($ship_whid==0){
			$this->error('请选择出货仓库','',2);
            exit;
		}
		
		if($ship_barcode==''){
			$this->error('请正确录入产品条码','',2);
            exit;
		}

        $linearr=json_decode($ship_barcode,true);

		if(json_last_error()!=0){
			$this->error('JSON ERROR','',2);
			exit; 
		}
		if(count($linearr)<=0){
			$this->error('请正确录入产品条码','',2);
            exit;
		}

		
		if($od_id>0 && $oddt_id>0){
            //对应订单
			$Orders=M('Orders');
			$map=array();
			$order=array();
			$map['od_unitcode']=session('unitcode');
			$map['od_id']=$od_id;
			$order = $Orders->where($map)->find();
			if($order){
				if($order['od_state']!=1 && $order['od_state']!=2 && $order['od_state']!=3){
					$this->error('该订单暂不能出货','',2);
				}
			}else{
				$this->error('没有该记录','',2);
			}
			
            //收货代理信息 下单代理
            $Dealer= M('Dealer');
			$map3=array();
			$data3=array();
			$map3['dl_id']=$order['od_oddlid'];
			$map3['dl_unitcode']=session('unitcode');
			$map3['dl_status']=1;
			$data3=$Dealer->where($map3)->find();

			if($data3){
				$order['od_dl_name']=$data3['dl_name'];
				$order['od_dl_username']=$data3['dl_username'];
			}else{
				$this->error('下单代理不存在或已禁用','',2);
			}
			
			//仓库
			$map2=array();
			$map2['wh_id']=$ship_whid;
			$map2['wh_unitcode']=session('unitcode');
			$Warehouse = M('Warehouse');
			$data2=$Warehouse->where($map2)->find();
			if($data2){
				$order['od_wh_name']=$data2['wh_name'];
			}else{
				$this->error('请选择出货仓库','',2);
			}



			//对应产品
			$Orderdetail= M('Orderdetail');
			$map=array();
			$data=array();
			$map['oddt_unitcode']=session('unitcode');
			$map['oddt_id']=$oddt_id;
			$map['oddt_odid']=$od_id;
			$data = $Orderdetail->where($map)->find();
			if($data){
				//订购数
				$oddt_totalqty=0;
				$oddt_unitsqty=0;
				if($data['oddt_prodbiao']>0){
					$oddt_unitsqty=$data['oddt_prodbiao'];
					
					if($data['oddt_prozbiao']>0){
						$oddt_unitsqty=$oddt_unitsqty*$data['oddt_prozbiao'];
					}
					
					if($data['oddt_proxbiao']>0){
						$oddt_unitsqty=$oddt_unitsqty*$data['oddt_proxbiao'];
					}
					
					$oddt_totalqty=$oddt_unitsqty*$data['oddt_qty'];
				}else{
					$oddt_totalqty=$data['oddt_qty'];
				}
				
				if($oddt_totalqty==0 || $oddt_totalqty==$data['oddt_qty']){
					$data['oddt_totalqty']='';
				}else{
					$data['oddt_totalqty']='('.$oddt_totalqty.'件)';
				}
				
				//发货数
				$Shipment= M('Shipment');
				$map3=array();
				$data3=array();
				$map3['ship_pro']=$data['oddt_proid'];
				$map3['ship_unitcode']=session('unitcode');
				$map3['ship_odid']=$data['oddt_odid'];
				$map3['ship_oddtid']=$data['oddt_id'];
				$map3['ship_dealer']=$order['od_oddlid']; //出货接收方
				$data3=$Shipment->where($map3)->sum('ship_proqty');
				if($data3){
					if($oddt_unitsqty>0){
						$data['oddt_shipqty']=floor($data3/$oddt_unitsqty).$data['oddt_prounits'].'('.$data3.'件)';
					}else{
						$data['oddt_shipqty']=$data3.$data['oddt_prounits'];
					}
					$oddt_shipqty=$data3;
				}else{
					$data['oddt_shipqty']=0;
					$oddt_shipqty=0;
				}
				
				$data['oddt_proname']=$data['oddt_proname'].$data['oddt_color'].$data['oddt_size'];

			}else{
				$this->error('没有该记录','',2);
			}
			
			//对产品条码处理
			$msgs=array();
			$kk=0;
			$success=0; //有效条码
			$fail=0;    //无效条码
			$ship_barcode='';
			$Chaibox= M('Chaibox');
			$successarr=array();
			$scancount=0;
			$ship_date=time();
			foreach($linearr as $key =>$li){
				$ship_barcode=trim($key);
                if($ship_barcode==''){
                     continue;
                }
				//检测条码是否格式正确
                if(!preg_match("/^[a-zA-Z0-9]{4,30}$/",$ship_barcode)){
                    $msgs[$kk]['barcode']=$ship_barcode;
                    $msgs[$kk]['error']='<span style="color:#FF0000">添加条码 '.htmlspecialchars($ship_barcode).' 出错，条码应由数字字母组成</span>';
					$msgs[$kk]['qty']=0;
					$kk=$kk+1;
					$fail=$fail+1;
					continue;
                }
				
                //检测该条码是否已存在
                $map2=array();
                $data2=array();
                $map2['ship_unitcode']=session('unitcode');
                $map2['ship_barcode'] = $ship_barcode;
                $map2['ship_deliver']=0;
                $data2=$Shipment->where($map2)->find();
                if(is_not_null($data2)){
					$msgs[$kk]['barcode']=$ship_barcode;
                    $msgs[$kk]['error']='<span style="color:#FF0000">添加条码 '.$ship_barcode.' 出错，该条码已存在。</span>';
					$msgs[$kk]['qty']=0;
					$kk=$kk+1;
					$fail=$fail+1;
                    continue;
                }
				
                //检测是否已发行
                $barcode=array();
                $barcode=wlcode_to_packinfo($ship_barcode,session('unitcode'));
                
                if(!is_not_null($barcode)){
                    $msgs[$kk]['barcode']=$ship_barcode;
					$msgs[$kk]['error']='<span style="color:#FF0000">添加条码 '.$ship_barcode.' 出错，该条码还没发行。</span>';
					$msgs[$kk]['qty']=0;
					$kk=$kk+1;
					$fail=$fail+1;
                    continue;
                }
				
                //是否出货
                $map2=array();
                $where=array();
                $data2=array();
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
                $map2['ship_barcode'] = $where;
                $map2['ship_unitcode']=session('unitcode');
                $map2['ship_deliver']=0;
                $data2=$Shipment->where($map2)->find();
                if(is_not_null($data2)){
					$msgs[$kk]['barcode']=$ship_barcode;
                    $msgs[$kk]['error']='<span style="color:#FF0000">添加条码 '.$ship_barcode.' 出错，该条码已存在。</span>';
					$msgs[$kk]['qty']=$barcode['qty'];
					$kk=$kk+1;
					$fail=$fail+1;
                    continue;
                }
				
                //检测是否拆箱
                $map2=array();
                $data2=array();
                $map2['chai_unitcode']=session('unitcode');
                $map2['chai_barcode'] = $ship_barcode;
                $map2['chai_deliver']=0;
                $data2=$Chaibox->where($map2)->find();

                if(is_not_null($data2)){
					$msgs[$kk]['barcode']=$ship_barcode;
                    $msgs[$kk]['error']='<span style="color:#FF0000">添加条码 '.$ship_barcode.' 出错，该条码已经拆箱，不能再使用。</span>';
					$msgs[$kk]['qty']=0;
					$kk=$kk+1;
					$fail=$fail+1;
                    continue;
                }
				
			    if(array_key_exists(strval($ship_barcode),$successarr)===false){

				   $scancount=$scancount+$barcode['qty'];
					//判断录入条码的产品数是否超出要出货的数
					if(($scancount+$oddt_shipqty)>$oddt_totalqty){
						$msgs[$kk]['barcode']=$ship_barcode;
						$msgs[$kk]['error']='<span style="color:#FF0000">添加条码 '.$ship_barcode.' 出错，发货产品数已超出订购产品数。</span>';
						$msgs[$kk]['qty']=$barcode['qty'];
						$kk=$kk+1;
						$fail=$fail+1;
						continue;
					}
					
					//有效条码入库 记录拆箱 tcode-大    ucode-中
					$insert=array();
					$insert['ship_unitcode']=session('unitcode');
					$insert['ship_number']=$order['od_orderid'];
					$insert['ship_deliver']=0;
					$insert['ship_dealer']=$order['od_oddlid'];  //下单代理收货代理
					$insert['ship_pro']=$data['oddt_proid']; //产品id
					$insert['ship_odid']=$od_id;  //订单id
					$insert['ship_odblid']=$odbl_id; //订单关系id
					$insert['ship_oddtid']=$oddt_id; //订单详细id
					$insert['ship_whid']=$ship_whid;
					$insert['ship_proqty']=$barcode['qty'];
					$insert['ship_barcode']=$ship_barcode;
					$insert['ship_date']=$ship_date;
					$insert['ship_ucode']=$barcode['ucode'];
					$insert['ship_tcode']=$barcode['tcode'];
					$insert['ship_remark']=$ship_remark.$data['oddt_proname'];
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

							$msgs[$kk]['barcode']=$ship_barcode;
							$msgs[$kk]['error']='添加条码 <b>'.$ship_barcode.' </b> 成功。';
							$msgs[$kk]['qty']=$barcode['qty'];
							$kk=$kk+1;
							$successarr[strval($ship_barcode)]=$barcode['qty'];
							$success=$success+1;
							continue;
					    }else{
							$msgs[$kk]['barcode']=$ship_barcode;
							$msgs[$kk]['error']='<span style="color:#FF0000">添加条码 '.$ship_barcode.' 出错，条码不正确。</span>';
							$msgs[$kk]['qty']=0;
							$kk=$kk+1;
							$fail=$fail+1;
							continue;
					    }
					}else{
						$msgs[$kk]['barcode']=$ship_barcode;
						$msgs[$kk]['error']='<span style="color:#FF0000">添加条码 '.$ship_barcode.' 出错，条码不正确。</span>';
						$msgs[$kk]['qty']=0;
						$kk=$kk+1;
						$fail=$fail+1;
						continue;
					}

				}else{
					$msgs[$kk]['barcode']=$ship_barcode;
                    $msgs[$kk]['error']='<span style="color:#FF0000">录入条码 '.$ship_barcode.' 出错，该条码重复录入。</span>';
					$msgs[$kk]['qty']=0;
					$kk=$kk+1;
					$fail=$fail+1;
                    continue;
				}
			}
		}else{
			$this->error('该订单记录不存在','',2);
            exit;
		}
		

		$this->assign('od_id', $od_id);
		$this->assign('odbl_id', $odbl_id);
		$this->assign('oddt_id', $oddt_id);
		
		$this->assign('msgs', $msgs);
		$this->assign('ordersinfo', $data);
		$this->assign('ordersbase', $order);
		$this->assign('ship_remark', $ship_remark);
		$this->assign('scancount', $scancount);
		$this->assign('fail', $fail);
		$this->assign('success', $success);

        $this->display('odshipscanres_save');
	}
	
	
    //完成发货
    public function odfinishship(){
        $this->check_qypurview('13001',1);

		$od_id=intval(I('param.od_id',0));
		$isok=intval(I('param.isok',0));
		
		if($od_id>0){
			$Orders=M('Orders');
			$map=array();
			$map['od_unitcode']=session('unitcode');
			$map['od_id']=$od_id;
			$map['od_rcdlid']=0;//下给公司的订单
			$data = $Orders->where($map)->find();
			if($data){
				//订单产品详细
				$Orderdetail= M('Orderdetail');
				$Product= M('Product');
				$Shipment= M('Shipment');
				$Dealer= M('Dealer');
				
				$map2=array();
				$data2=array();
				$map2['oddt_unitcode']=session('unitcode');
				$map2['oddt_odid']=$data['od_id'];
				$data2 = $Orderdetail->where($map2)->order('oddt_id DESC')->limit(100)->select();
				$imgpath = BASE_PATH.'/Public/uploads/product/';
				foreach($data2 as $kk=>$vv){
					//产品
					$map3=array();
					$data3=array();
					$map3['pro_id']=$vv['oddt_proid'];
					$map3['pro_unitcode']=session('unitcode');
					$data3=$Product->where($map3)->find();
					if($data3){
						if(is_not_null($data3['pro_pic']) && file_exists($imgpath.$data3['pro_pic'])){
							$data2[$kk]['oddt_propic']=$data3['pro_pic'];
						}else{
							$data2[$kk]['oddt_propic']='';
						}
					}else{
						$data2[$kk]['oddt_propic']='';
					}
					
					//订购数 
					$oddt_totalqty=0;
					$oddt_unitsqty=0;
					if($vv['oddt_prodbiao']>0){
						$oddt_unitsqty=$vv['oddt_prodbiao'];
						
						if($vv['oddt_prozbiao']>0){
							$oddt_unitsqty=$oddt_unitsqty*$vv['oddt_prozbiao'];
						}
						
						if($vv['oddt_proxbiao']>0){
							$oddt_unitsqty=$oddt_unitsqty*$vv['oddt_proxbiao'];
						}
						
						$oddt_totalqty=$oddt_unitsqty*$vv['oddt_qty'];
					}else{
						$oddt_totalqty=$vv['oddt_qty'];
					}
					if($oddt_totalqty==0 || $oddt_totalqty==$vv['oddt_qty']){
						$data2[$kk]['oddt_totalqty']='';
					}else{
						$data2[$kk]['oddt_totalqty']='('.$oddt_totalqty.'件)';
					}
					
					//发货数
					$map3=array();
					$data3=array();
					$map3['ship_pro']=$vv['oddt_proid'];
					$map3['ship_unitcode']=session('unitcode');
					$map3['ship_odid']=$vv['oddt_odid'];
					$map3['ship_oddtid']=$vv['oddt_id'];
					$map3['ship_dealer']=$data['od_oddlid']; //出货接收方
					$data3=$Shipment->where($map3)->sum('ship_proqty');
			
					if($data3){
						if($oddt_unitsqty>0){
							$data2[$kk]['oddt_shipqty']=floor($data3/$oddt_unitsqty).$vv['oddt_prounits'].'('.$data3.'件)';
						}else{
							$data2[$kk]['oddt_shipqty']=$data3.$vv['oddt_prounits'];
						}
						
                        if($oddt_totalqty==0 || $oddt_totalqty>$data3 ){
							if($this->check_qypurview('13004',0)){
								//完成订单不以完成出货为条件
								if($isok==0){
									$msg=array('stat'=>'9','msg'=>'');
									echo json_encode($msg);
									exit;
								}
							}else{
								$msg=array('stat'=>'0','msg'=>'该订单还没完成出货');
								echo json_encode($msg);
								exit;
							}
						}
						if( $oddt_totalqty<$data3){
							$msg=array('stat'=>'0','msg'=>'该订单出货的数量大于订购数量');
							echo json_encode($msg);
							exit;
						}
						
					}else{
						if($this->check_qypurview('13004',0)){
							//完成订单不以完成出货为条件
							if($isok==0){
								$msg=array('stat'=>'9','msg'=>'');
								echo json_encode($msg);
								exit;
							}
							$data2[$kk]['oddt_shipqty']=0;
						}else{
							$msg=array('stat'=>'0','msg'=>'该订单还没完成出货');
							echo json_encode($msg);
							exit;
						}
					}
				}
				$data['orderdetail']=$data2;
				
				
				//快递物流
				if($data['od_express']>0){
				    $map3=array();
					$data3=array();
					$Express= M('Express');
					$map3['exp_id']=$data['od_express'];
					$data3=$Express->where($map3)->find();
					if($data3){
						$data['od_expressname']=$data3['exp_name'];
						//可以从快递100接口获取数据
						
						
					}else{
						$data['od_expressname']='';
					}
				}else{
					$data['od_expressname']='';
				}
				
				//状态
				if($data['od_state']==0){
					$data['od_state_str']='待确认';
				}else if($data['od_state']==1){
					$data['od_state_str']='待发货';
				}else if($data['od_state']==2){
					$data['od_state_str']='部分发货';
				}else if($data['od_state']==3){
					$data['od_state_str']='已发货';
				}else if($data['od_state']==8){
					$data['od_state_str']='已完成';
				}else if($data['od_state']==9){
					$data['od_state_str']='已取消';
				}else{
					$data['od_state_str']='未知';
				}
				
				if($data['od_express']<=0){
					$title='确认完成发货';
				}else{
					$title='确认修改物流';
				}
				
			
			}else{
				$msg=array('stat'=>'0','msg'=>'没有该记录');
				echo json_encode($msg);
				exit;
			}
		}else{
			$msg=array('stat'=>'0','msg'=>'没有该记录');
			echo json_encode($msg);
			exit;
		}
		
		if($isok==0){
			$msg=array('stat'=>'1','msg'=>'');
			echo json_encode($msg);
			exit;
		}
		
		//物流快递
		$Express = M('Express');
		$map=array();
		$expresslist = $Express->where($map)->order('exp_addtime DESC')->select();
		$this->assign('title', $title);
		$this->assign('expresslist', $expresslist);
			
		$this->assign('ordersinfo', $data);
		$this->assign('od_id', $od_id);
		 $this->assign('curr', 'cporders');
		
		$this->display('odfinishship');
    }
	
    //完成发货 保存
    public function odfinishship_save(){
        $this->check_qypurview('13001',1);
		
		$od_id=intval(I('post.od_id',0));
	
		if($od_id>0){
			$od_express=intval(I('post.od_express',0));
			$od_expressnum=I('post.od_expressnum','');
			$od_remark=I('post.od_remark','');
			if($od_express<=0){
				$this->error('请选择物流快递','',2);
				exit;
			}
			
			$Orders=M('Orders');
			$map=array();
			$map['od_unitcode']=session('unitcode');
			$map['od_id']=$od_id;
			$map['od_rcdlid']=0;//下给公司的订单
			$data =$Orders->where($map)->find();
			if($data){	
				//检测是否能发货 //订购数 发货数
				$Orderdetail = M('Orderdetail');
				$Shipment = M('Shipment');
				$map2=array();
				$oddetail=array();
				$map2['oddt_unitcode']=session('unitcode');
				$map2['oddt_odid']=$od_id;
				$oddetail = $Orderdetail->where($map2)->order('oddt_id DESC')->limit(100)->select();
				$proids=array();
				foreach($oddetail as $kk=>$vv){

					$proids[]=$vv['oddt_proid'];

					//订购数 
					$oddt_totalqty=0;
					$oddt_unitsqty=0;
					if($vv['oddt_prodbiao']>0){
						$oddt_unitsqty=$vv['oddt_prodbiao'];
						
						if($vv['oddt_prozbiao']>0){
							$oddt_unitsqty=$oddt_unitsqty*$vv['oddt_prozbiao'];
						}
						
						if($vv['oddt_proxbiao']>0){
							$oddt_unitsqty=$oddt_unitsqty*$vv['oddt_proxbiao'];
						}
						
						$oddt_totalqty=$oddt_unitsqty*$vv['oddt_qty'];
					}
					if($oddt_totalqty==0){
						$oddt_totalqty=$vv['oddt_qty'];
					}
					
					$oddetail[$kk]['oddt_totalqty']=$oddt_totalqty;
					
					//发货数
					$map3=array();
					$data3=array();
					$map3['ship_pro']=$vv['oddt_proid'];
					$map3['ship_unitcode']=session('unitcode');
					$map3['ship_odid']=$vv['oddt_odid'];
					$map3['ship_oddtid']=$vv['oddt_id'];
					$map3['ship_dealer']=$data['od_oddlid']; //出货接收方
					$data3=$Shipment->where($map3)->sum('ship_proqty');
					if($data3){
						if($oddt_totalqty==0 || $oddt_totalqty>$data3 ){
							if($this->check_qypurview('13004',0)){
								//完成订单不以完成出货为条件
							}else{
								$this->error('该订单还没完成出货','',2);
								exit;
							}
						}	
                        if( $oddt_totalqty<$data3){
							$this->error('该订单出货的数量大于订购数量','',2);
							exit;
						}
					}else{
						if($this->check_qypurview('13004',0)){
							//完成订单不以完成出货为条件
						}else{
							$this->error('该订单还没完成出货','',2);
							exit;
						}
					}
				}
			}else{
                $this->error('该订单记录不存在','',2);
				exit;
			}
			
			$Orders= M('Orders');
			$Orderbelong= M('Orderbelong');
			
			//写入物流信息
			$map2=array();
			$updata2=array();
			$map2['od_unitcode']=session('unitcode');
			$map2['od_id']=$od_id;
			
			$updata2['od_express']=$od_express;
			$updata2['od_expressnum']=$od_expressnum;
			$updata2['od_remark']=$od_remark;
			if($data['od_express']<=0){
				$updata2['od_expressdate']=time();
			}
			$Orders->where($map2)->save($updata2);
			
			// //订单关系状态更改
			// $map2=array();
			// $updata2=array();
			// $map2['odbl_unitcode']=session('unitcode');
			// $map2['odbl_id']=$odbl_id;
			// $updata2['odbl_state']=3; //0--待确认  1--代发货 2--部分发货 3-已发货 8-已完成 9-已取消
			// $Orderbelong->where($map2)->save($updata2);
			
			//修改原始订单状态
			// if($data['od_oddlid']==$data['odbl_oddlid']){

				$map2=array();
				$updata2=array();
				$map2['od_unitcode']=session('unitcode');
				$map2['od_id']=$od_id;
				$updata2['od_state']=3;
				$Orders->where($map2)->save($updata2);
			// }
			
			// if($data['od_express']<=0){

			// 	//订单返利 begin
			// 	$fanli_dlid1=0; //返利给的代理商1
			// 	$fanli_dlid2=0; //返利给的代理商2
			// 	$fanli_dlid3=0; //返利给的代理商3
			// 	$ismaiduan=0;
			// 	$fanli_dlname1='';
			// 	$fanli_dlname2='';
			// 	$fanli_dlname3='';
			// 	$Dealer = M('Dealer');
			// 	//下单人
			// 	$map3=array();
			// 	$orderdealer=array();
			// 	$map3['dl_unitcode'] = session('unitcode');
			// 	$map3['dl_id'] = $data['od_oddlid'];  //下单的代理
			// 	$orderdealer=$Dealer->where($map3)->find();
			// 	if($orderdealer){
			// 		$Profanli= M('Profanli');
			// 		$map2=array();
			// 		$map2['pfl_unitcode'] = session('unitcode');
			// 		$map2['pfl_dltype'] = $orderdealer['dl_type'];
			// 		$where=array();
			// 		$where['pfl_fanli1'] = array('GT',0);
			// 		$where['pfl_maiduan'] = array('GT',0);  //是否设置卖断返利
			// 		$where['_logic'] = 'or';
			// 		$map2['_complex'] = $where;
					
			// 		if($proids){
			// 			$map2['pfl_proid'] = array('IN',$proids);
			// 		}
			// 		$data2=$Profanli->where($map2)->find(); //是否有设置返利
					

					
			// 			//返利默认 仅平级返利 
			// 			if($data2){
			// 				if($orderdealer['dl_referee']>0){

			// 					//下单代理的推荐人 如果正常并与发货人不同 则返利
			// 					$map4=array();
			// 					$data4=array();
			// 					$map4['dl_unitcode'] = session('unitcode');
			// 					$map4['dl_id'] = $orderdealer['dl_referee'];  //推荐人
			// 					$map4['dl_status'] = 1;
								
			// 					$data4=$Dealer->where($map4)->find();
			// 					if($data4){
			// 						//如果推荐人和发货人不相同  则都返利给推荐人
			// 						if($data4['dl_id']>0){
			// 							//如果下单人与推荐人同级
			// 							if($orderdealer['dl_type']==$data4['dl_type']){
			// 								$fanli_dlid1=$data4['dl_id']; //返利给的代理商1
			// 								$fanli_dlname1=$data4['dl_username'];
			// 								//推荐人的推荐人
			// 								if($data4['dl_referee']>0){
			// 									$map6=array();
			// 									$data6=array();
			// 									$map6['dl_unitcode'] = session('unitcode');
			// 									$map6['dl_id'] = $data4['dl_referee'];  //推荐人的推荐人
			// 									$map6['dl_status'] = 1;
			// 									$data6=$Dealer->where($map6)->find();
			// 									if($data6){
			// 										//如果推荐人的推荐人和发货人不相同 则都返利给推荐人 且同级
			// 										if($data6['dl_id']>0){
			// 											if($orderdealer['dl_type']==$data6['dl_type']){
			// 												$fanli_dlid2=$data6['dl_id']; //返利给的代理商2
			// 												$fanli_dlname2=$data6['dl_username'];
															
			// 												//推荐人的推荐人的推荐人
			// 												if($data6['dl_referee']>0){
			// 													$map7=array();
			// 													$data7=array();
			// 													$map7['dl_unitcode'] = session('unitcode');
			// 													$map7['dl_id'] = $data6['dl_referee'];  //推荐人的推荐人
			// 													$map7['dl_status'] = 1;
			// 													$data7=$Dealer->where($map7)->find();
			// 													if($data7){
			// 														//如果推荐人的推荐人和发货人不相同 则都返利给推荐人 且同级
			// 														if($data7['dl_id']>0){
			// 															if($orderdealer['dl_type']==$data7['dl_type']){
			// 																$fanli_dlid3=$data7['dl_id']; //返利给的代理商3
			// 																$fanli_dlname3=$data7['dl_username'];
			// 															}
			// 														}
			// 													}
			// 												}
			// 											}
			// 										}
			// 									}
			// 								}
										
			// 							}
			// 						}
			// 					}
								
			// 					//写入返利数据
			// 					if($fanli_dlid1>0){
			// 						$Fanlidetail = M('Fanlidetail');
			// 						foreach($oddetail as $kk=>$vv){
			// 							$map7=array();
			// 							$data7=array();
			// 							$map7['pfl_unitcode'] = session('unitcode');
			// 							$map7['pfl_proid'] = $vv['oddt_proid'];
			// 							$map7['pfl_dltype'] = $orderdealer['dl_type'];
			// 							$map7['pfl_fanli1'] = array('GT',0);
			// 							$data7=$Profanli->where($map7)->find();
			// 							//如果订单产品有设置返利 1层
			// 							if($data7){
			// 								if($data7['pfl_fanli1']>0){
			// 									$map8=array();
			// 									$data8=array();
			// 									$map8['fl_unitcode'] = session('unitcode');
			// 									$map8['fl_type'] = 2;
			// 									$map8['fl_odid'] = $vv['oddt_odid'];
			// 									$map8['fl_proid'] = $vv['oddt_proid'];
			// 									$map8['fl_oddlid'] = $orderdealer['dl_id'];
			// 									$map8['fl_level'] = 1;
			// 									$data8 = $Fanlidetail->where($map8)->find();
			// 									if(!$data8){
			// 										if(session('unitcode')=='2910'){ //宝鼎红微商
			// 											$pfl_fanli1sum=$data7['pfl_fanli1']*$vv['oddt_qty'];
			// 										}else{
			// 											//佣金数字在1-0间，则以下单价的百分比计算，如0.03代表以下单价的3%计算，如果大于1，则以具体多少元计算
			// 											if($data7['pfl_fanli1']>0 && $data7['pfl_fanli1']<1){
			// 												$pfl_fanli1sum=$data7['pfl_fanli1']*$vv['oddt_dlprice']*$vv['oddt_qty'];
			// 											}else{
			// 												$pfl_fanli1sum=$data7['pfl_fanli1']*$vv['oddt_qty'];
			// 											}
			// 										}
													
			// 										$data5=array();
			// 										$data5['fl_unitcode'] = session('unitcode');
			// 										$data5['fl_dlid'] = $fanli_dlid1; //获得返利的代理
			// 										$data5['fl_senddlid'] = 0; //发放返利的代理 0为公司发放
			// 										$data5['fl_type'] = 2; //返利分类 1-推荐返利 2-订单返利  11-提现减少返利 (1-10 增加返利 11-20 减少返利)  
			// 										$data5['fl_money'] = $pfl_fanli1sum;
			// 										$data5['fl_refedlid'] = 0; //推荐返利中被推荐的代理
			// 										$data5['fl_oddlid'] = $orderdealer['dl_id']; //订单返利中 下单的代理
			// 										$data5['fl_odid'] = $vv['oddt_odid'];  //订单返利中 订单流水id
			// 										$data5['fl_orderid']  = $vv['oddt_orderid']; //订单返利中 订单id
			// 										$data5['fl_proid']  = $vv['oddt_proid'];  //订单返利中 产品id
			// 										$data5['fl_odblid']  = $vv['oddt_odblid'];  //订单返利中 订单关系id
			// 										$data5['fl_qty']  = $vv['oddt_qty'];  //订单返利中 产品数量
			// 										$data5['fl_level']  = 1;  //返利的层次，1-第一层返利 2-第二层返利
			// 										$data5['fl_addtime']  = time();
			// 										$data5['fl_remark'] ='代理 '.$orderdealer['dl_username'].' 订购 '.$vv['oddt_proname'].' 数量 '.$vv['oddt_qty'] ;
			// 										$rs5=$Fanlidetail->create($data5,1);
			// 										if($rs5){
			// 											$Fanlidetail->add();
			// 										}
			// 									}
			// 								}
			// 							}
										
			// 							//如果有设置2层返利
			// 							if($fanli_dlid2>0){
			// 								$map7=array();
			// 								$data7=array();
			// 								$map7['pfl_unitcode'] = session('unitcode');
			// 								$map7['pfl_proid'] = $vv['oddt_proid'];
			// 								$map7['pfl_dltype'] = $orderdealer['dl_type'];
			// 								$map7['pfl_fanli2'] = array('GT',0);
			// 								$data7=$Profanli->where($map7)->find();
			// 								if($data7){
			// 									if($data7['pfl_fanli2']>0){
			// 										$map8=array();
			// 										$data8=array();
			// 										$map8['fl_unitcode'] = session('unitcode');
			// 										$map8['fl_type'] = 2;
			// 										$map8['fl_odid'] = $vv['oddt_odid'];
			// 										$map8['fl_proid'] = $vv['oddt_proid'];
			// 										$map8['fl_oddlid'] = $orderdealer['dl_id'];
			// 										$map8['fl_level'] = 2;
			// 										$data8 = $Fanlidetail->where($map8)->find();
			// 										if(!$data8){
			// 											if(session('unitcode')=='2910'){ //宝鼎红微商
			// 											    $pfl_fanli2sum=$data7['pfl_fanli2']*$vv['oddt_qty'];
			// 											}else{
			// 												//佣金数字在1-0间，则以下单价的百分比计算，如0.03代表以下单价的3%计算，如果大于1，则以具体多少元计算
			// 												if($data7['pfl_fanli2']>0 && $data7['pfl_fanli2']<1){
			// 													$pfl_fanli2sum=$data7['pfl_fanli2']*$vv['oddt_dlprice']*$vv['oddt_qty'];
			// 												}else{
			// 													$pfl_fanli2sum=$data7['pfl_fanli2']*$vv['oddt_qty'];
			// 												}
			// 											}
														
			// 											$data5=array();
			// 											$data5['fl_unitcode'] = session('unitcode');
			// 											$data5['fl_dlid'] = $fanli_dlid2; //获得返利的代理
			// 											$data5['fl_senddlid'] = 0; //发放返利的代理
			// 											$data5['fl_type'] = 2; //返利分类 1-推荐返利 2-订单返利  11-提现减少返利 (1-10 增加返利 11-20 减少返利)  
			// 											$data5['fl_money'] = $pfl_fanli2sum;
			// 											$data5['fl_refedlid'] = 0; //推荐返利中被推荐的代理
			// 											$data5['fl_oddlid'] = $orderdealer['dl_id']; //订单返利中 下单的代理
			// 											$data5['fl_odid'] = $vv['oddt_odid'];  //订单返利中 订单流水id
			// 											$data5['fl_orderid']  = $vv['oddt_orderid']; //订单返利中 订单id
			// 											$data5['fl_proid']  = $vv['oddt_proid'];  //订单返利中 产品id
			// 											$data5['fl_odblid']  = $vv['oddt_odblid'];  //订单返利中 订单关系id
			// 											$data5['fl_qty']  = $vv['oddt_qty'];  //订单返利中 产品数量
			// 											$data5['fl_level']  = 2;  //返利的层次，1-第一层返利 2-第二层返利
			// 											$data5['fl_addtime']  = time();
			// 											$data5['fl_remark'] ='代理 '.$fanli_dlname1.' 的邀请代理 '.$orderdealer['dl_username'].' 订购 '.$vv['oddt_proname'].' 数量 '.$vv['oddt_qty'] ;
			// 											$rs5=$Fanlidetail->create($data5,1);
			// 											if($rs5){
			// 												$Fanlidetail->add();
			// 											}
			// 										}
			// 									}
			// 								}
			// 							}
										
			// 							//如果有设置3层返利
			// 							if($fanli_dlid3>0){
			// 								$map7=array();
			// 								$data7=array();
			// 								$map7['pfl_unitcode'] = session('unitcode');
			// 								$map7['pfl_proid'] = $vv['oddt_proid'];
			// 								$map7['pfl_dltype'] = $orderdealer['dl_type'];
			// 								$map7['pfl_fanli3'] = array('GT',0);
			// 								$data7=$Profanli->where($map7)->find();
			// 								if($data7){
			// 									if($data7['pfl_fanli3']>0){
			// 										$map8=array();
			// 										$data8=array();
			// 										$map8['fl_unitcode'] = session('unitcode');
			// 										$map8['fl_type'] = 2;
			// 										$map8['fl_odid'] = $vv['oddt_odid'];
			// 										$map8['fl_proid'] = $vv['oddt_proid'];
			// 										$map8['fl_oddlid'] = $orderdealer['dl_id'];
			// 										$map8['fl_level'] = 3;
			// 										$data8 = $Fanlidetail->where($map8)->find();
			// 										if(!$data8){
			// 											if(session('unitcode')=='2910'){ //宝鼎红微商
			// 											    $pfl_fanli3sum=$data7['pfl_fanli3']*$vv['oddt_qty'];
			// 											}else{
			// 												//佣金数字在1-0间，则以下单价的百分比计算，如0.03代表以下单价的3%计算，如果大于1，则以具体多少元计算
			// 												if($data7['pfl_fanli3']>0 && $data7['pfl_fanli3']<1){
			// 													$pfl_fanli3sum=$data7['pfl_fanli3']*$vv['oddt_dlprice']*$vv['oddt_qty'];
			// 												}else{
			// 													$pfl_fanli3sum=$data7['pfl_fanli3']*$vv['oddt_qty'];
			// 												}
			// 											}
														
			// 											$data5=array();
			// 											$data5['fl_unitcode'] = session('unitcode');
			// 											$data5['fl_dlid'] = $fanli_dlid3; //获得返利的代理
			// 											$data5['fl_senddlid'] = 0; //发放返利的代理
			// 											$data5['fl_type'] = 2; //返利分类 1-推荐返利 2-订单返利  11-提现减少返利 (1-10 增加返利 11-20 减少返利)  
			// 											$data5['fl_money'] = $pfl_fanli3sum;
			// 											$data5['fl_refedlid'] = 0; //推荐返利中被推荐的代理
			// 											$data5['fl_oddlid'] = $orderdealer['dl_id']; //订单返利中 下单的代理
			// 											$data5['fl_odid'] = $vv['oddt_odid'];  //订单返利中 订单流水id
			// 											$data5['fl_orderid']  = $vv['oddt_orderid']; //订单返利中 订单id
			// 											$data5['fl_proid']  = $vv['oddt_proid'];  //订单返利中 产品id
			// 											$data5['fl_odblid']  = $vv['oddt_odblid'];  //订单返利中 订单关系id
			// 											$data5['fl_qty']  = $vv['oddt_qty'];  //订单返利中 产品数量
			// 											$data5['fl_level']  = 3;  //返利的层次，1-第一层返利 2-第二层返利
			// 											$data5['fl_addtime']  = time();
			// 											$data5['fl_remark'] ='代理 '.$fanli_dlname2.' 的邀请代理 '.$fanli_dlname1.' 的邀请代理 '.$orderdealer['dl_username'].' 订购 '.$vv['oddt_proname'].' 数量 '.$vv['oddt_qty'] ;
			// 											$rs5=$Fanlidetail->create($data5,1);
			// 											if($rs5){
			// 												$Fanlidetail->add();
			// 											}
			// 										}
			// 									}
			// 								}
			// 							}
										
			// 						}
			// 					}	
			// 				}
			// 			}
					
		
					
			// 		//积分 begin
			// 		$Proprice= M('Proprice');
			// 		$Dljfdetail= M('Dljfdetail');
			// 		foreach($oddetail as $kk=>$vv){
			// 			//如果有积分
			// 			$map7=array();
			// 			$data7=array();
			// 			$map7['pri_unitcode'] = session('unitcode');
			// 			$map7['pri_dltype'] = $orderdealer['dl_type'];
			// 			$map7['pri_jifen'] = array('GT',0);
			// 			$map7['pri_proid'] = $vv['oddt_proid'];
			// 			$data7=$Proprice->where($map7)->find(); //是否有设置积分
							
			// 			if($data7){
			// 				//如果有积分
			// 				if($data7['pri_jifen']>0){
			// 					$map8=array();
			// 					$data8=array();
			// 					$map8['dljf_unitcode'] = session('unitcode');
			// 					$map8['dljf_type'] = 1;  //积分分类 1-5增加积分     6-9 消费积分
			// 					$map8['dljf_odid'] = $vv['oddt_odid'];
			// 					$map8['dljf_odblid'] = $vv['oddt_odblid'];
			// 					$map8['dljf_proid'] = $vv['oddt_proid'];
			// 					$map8['dljf_dlid'] = $orderdealer['dl_id'];
			// 					$data8 = $Dljfdetail->where($map8)->find();
								
			// 					if(!$data8){
			// 						$data5=array();
			// 						$data5['dljf_unitcode'] = session('unitcode');
			// 						$data5['dljf_dlid'] = $orderdealer['dl_id']; //获得积分的代理
			// 						$data5['dljf_username'] = $orderdealer['dl_username']; //获得积分的代理
			// 						$data5['dljf_type'] = 1; //积分分类 1-订购产品积分 积分分类 1-5增加积分  6-9 消费积分
									
			// 						if(session('unitcode')=='9999'){ //旨来脂去 专用积分计算
			// 						    $data5['dljf_jf'] = round(($data7['pri_jifen']*$vv['oddt_qty'])/4);
			// 						}else{
			// 							$data5['dljf_jf'] = $data7['pri_jifen']*$vv['oddt_qty'];
			// 						}
									
			// 						$data5['dljf_addtime'] = time(); 
			// 						$data5['dljf_ip'] = real_ip(); 
			// 						$data5['dljf_actionuser'] = session('qyuser');  
			// 						$data5['dljf_odid']  = $vv['oddt_odid']; 
			// 						$data5['dljf_orderid']  = $vv['oddt_orderid']; 
			// 						$data5['dljf_odblid']  = $vv['oddt_odblid'];  
			// 						$data5['dljf_proid']  = $vv['oddt_proid'];  
			// 						$data5['dljf_qty']  = $vv['oddt_qty'];  
			// 						$data5['dljf_remark'] ='订购产品 '.$vv['oddt_proname'].' 获得积分,数量 '.$vv['oddt_qty'] ;
			// 						$rs5=$Dljfdetail->create($data5,1);
			// 						if($rs5){
			// 							$Dljfdetail->add();
			// 						}
			// 					}
			// 				}
			// 			}
			// 		}
			// 		//积分 end
					
			// 	}
			// 	//返利 end
				
			// 	//减少库存
			// 	if($this->check_qypurview('20012',0)){
			// 		$Product= M('Product');
			// 		foreach($oddetail as $kkk=>$vvv){
			// 			$map2=array();
			// 			$map2['pro_unitcode']=session('unitcode');
			// 			$map2['pro_id'] =$vvv['oddt_proid'];
			// 			$data2=$Product->where($map2)->find();
			// 			if($data2){
			// 				$data3=array();
			// 				$data3['pro_stock']=$data2['pro_stock']-$vvv['oddt_totalqty'];
   //                          $Product->where($map2)->data($data3)->save();
			// 			}
			// 		}
			// 	}
			// 	//减少库存 end

				
			// 	//订单操作日志 begin
			// 	$odlog_arr=array(
			// 				'odlg_unitcode'=>session('unitcode'),  
			// 				'odlg_odid'=>$od_id,
			// 				'odlg_orderid'=>$data['od_orderid'],
			// 				'odlg_dlid'=>session('qyid'),
			// 				'odlg_dlusername'=>session('qyuser'),
			// 				'odlg_dlname'=>session('qyuser'),
			// 				'odlg_action'=>'完成发货',
			// 				'odlg_type'=>0, //0-企业 1-经销商
			// 				'odlg_addtime'=>time(),
			// 				'odlg_ip'=>real_ip(),
			// 				'odlg_link'=>__SELF__
			// 				);
			// 	$Orderlogs = M('Orderlogs');
			// 	$rs3=$Orderlogs->create($odlog_arr,1);
			// 	if($rs3){
			// 		$Orderlogs->add();
			// 	}
			// 	//订单操作日志 end
			// }
			
			$this->error('物流信息提交成功',U('Mp/Orders/cporderdetail/od_id/'.$od_id.'/odbl_id/'.$odbl_id.'/back/1'),2);
			exit;
		}else{
			$this->error('该订单记录不存在','',2);
			exit;
		}
	}
   
	
    //=====================================================================================
    //发货地址
    public function addresslist(){
        $this->check_qypurview('13003',1);

        $keyword=trim(strip_tags(htmlspecialchars_decode(I('param.keyword',''))));
		$parameter=array();
		
        if($keyword!=''){
            $keyword=str_replace('[','',$keyword);
            $keyword=str_replace(']','',$keyword);
            $keyword=str_replace('%','',$keyword);
            $keyword=str_replace('_','',$keyword);

            $keyword=sub_str($keyword,20,false);
            $where['dladd_contact']=array('LIKE', '%'.$keyword.'%');
            $where['dladd_address']=array('LIKE', '%'.$keyword.'%');
			$where['dladd_tel']=array('LIKE', '%'.$keyword.'%');
            $where['_logic'] = 'or';
            $map['_complex'] = $where;
			
			$parameter['keyword']=$keyword;
        }
        $map['dladd_unitcode']=session('unitcode');
        $Dladdress = M('Dladdress');
        $count = $Dladdress->where($map)->count();
        $Page = new \Think\Page($count, C('PAGE_SIZE'),$parameter);
        $show = $Page->show();
        $list = $Dladdress->where($map)->order('dladd_id DESC')->limit(($Page->firstRow . ',') . $Page->listRows)->select();
        $Dealer = M('Dealer');
        foreach($list as $k=>$v){ 
            $map2=array();
            $map2['dl_unitcode']=session('unitcode');
            $map2['dl_id'] = $v['dladd_dlid'];
            $Dealerinfo = $Dealer->where($map2)->find();
            if($Dealerinfo){
                $list[$k]['dl_name']=$Dealerinfo['dl_name'].'('.$Dealerinfo['dl_username'].')';
            }else{
                $list[$k]['dl_name']='-';
            }
		}
        $this->assign('list', $list);
        $this->assign('curr', 'address');
        $this->display('addresslist');
    }
	//统计代理在某时间段下单的金额
    public function dlordersum(){
        $this->check_qypurview('13005',1);

		$dlusername=trim(I('param.dlusername',''));
		$begintime=I('param.begintime','');
        $endtime=I('param.endtime','');
		$dl_type=intval(I('param.dl_type',0));

		$parameter=array();
		$map=array();
		$Dealer = M('Dealer');
		$Orders = M('Orders');
		$Dltype = M('Dltype');
		
        if($dlusername!='' && $dlusername!='请填写代理账号'){
            if(!preg_match("/[a-zA-Z0-9_-]{4,20}$/",$dlusername)){
                $this->error('填写代理账号不正确','',1);
            }
			
            $map['dl_username']=$dlusername;
			$parameter['dlusername']=$dlusername;
			$this->assign('dlusername', $dlusername);
        }else{
			$this->assign('dlusername', '请填写代理账号');
			
			if($dl_type>0){
				$map['dl_type']=$dl_type;
				$parameter['dl_type']=$dl_type;
	        }
		}


		
        if($begintime!='' && $endtime!=''){
            $begintime=strtotime($begintime.' 00:00:00');
			$endtime=strtotime($endtime.' 23:59:59');
			if($begintime===FALSE || $endtime===FALSE){
				$this->error('请选择查询日期','',1);
			}

			if($begintime>=$endtime){
				$this->error('查询结束日期要大于开始日期','',1);
			}	

			$parameter['begintime']=urlencode(date('Y-m-d',$begintime));
			$parameter['endtime']=urlencode(date('Y-m-d',$endtime));
			
			$this->assign('begintime', date('Y-m-d',$begintime));
			$this->assign('endtime', date('Y-m-d',$endtime));
		}else{
            $begintime=strtotime(date('Y-m',time()).'-1 00:00:00');
            $endtime=strtotime(date('Y-m-d',time()).' 23:59:59');
			
			$parameter['begintime']=urlencode(date('Y-m-d',$begintime));
			$parameter['endtime']=urlencode(date('Y-m-d',$endtime));
			
		    $this->assign('begintime', date('Y-m-d',$begintime));
		    $this->assign('endtime', date('Y-m-d',$endtime));
		}
		$map['dl_unitcode']=session('unitcode');
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
			
			$list[$k]['dl_minnumstr']='';
			
			if(session('unitcode')=='2976'){//清晨美季月之谜 微商特殊处理
				//该段时间内的销量
				$totalqty=0; //总订购数量
				$Model=M();
				$Orderdetail = M('Orderdetail');
				
				$map2=array();
				$map2['a.od_oddlid']=$v['dl_id'];
				$map2['a.od_unitcode']=session('unitcode');
				$map2['a.od_state']=array('IN','3,8');
				$map2['a.od_id']=array('exp','=b.odbl_odid');
				$map2['a.od_expressdate']=array('between',array($begintime,$endtime));
				$list22 = $Model->table('fw_orders a,fw_orderbelong b')->where($map2)->order('a.od_addtime DESC')->limit(1000)->select();
				foreach($list22 as $k22=>$v22){
					//订单详细
					$map22=array();
					$data22=array();
					$map22['oddt_unitcode']=session('unitcode');
					$map22['oddt_odid']=$v22['od_id'];
					$map22['oddt_odblid']=$v22['odbl_id'];
					$data22 = $Orderdetail->where($map22)->order('oddt_id DESC')->limit(100)->select();
					foreach($data22 as $kk=>$vv){
						//订购数量
						$oddt_totalqty=0; //总订购数
						$oddt_unitsqty=0; //每单位包装的数量
						if($vv['oddt_prodbiao']>0){
							$oddt_unitsqty=$vv['oddt_prodbiao'];
							
							if($vv['oddt_prozbiao']>0){
								$oddt_unitsqty=$oddt_unitsqty*$vv['oddt_prozbiao'];
							}
							
							if($vv['oddt_proxbiao']>0){
								$oddt_unitsqty=$oddt_unitsqty*$vv['oddt_proxbiao'];
							}
							
							$oddt_totalqty=$oddt_unitsqty*$vv['oddt_qty'];
						}else{
							$oddt_totalqty=$vv['oddt_qty'];
						}
						$totalqty=$totalqty+$oddt_totalqty;
					}
					
				}
				
			    $list[$k]['dl_minnumstr']='<span style="color:#333333">'.$totalqty.'</span>';
				
			    if($data2['dlt_level']==5){ 
					if((time()-$v['dl_startdate'])>3600*24*89){
						if(($endtime-$begintime)>=3600*24*89){
							//判断总订购数量 如果订购数小于最低下单数
							if($data2['dlt_minnum']>0 && $data2['dlt_minnum']>$totalqty ){
								$list[$k]['dl_minnumstr']='<span style="color:#FF0000">'.$totalqty.'</span>';
							}
						}
					}
				}
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
			
			


			//下单的金额(只统计已发货、已完成)
			$odsum=0;
			$map2=array();
			$map2['od_oddlid']=$v['dl_id'];
			$map2['od_unitcode']=session('unitcode');
			$map2['od_state']=array('IN','3,8');
			$map2['od_expressdate']=array('between',array($begintime,$endtime));
			$odsum = $Orders->where($map2)->sum('od_total'); 

			$list[$k]['dl_odsum']=$odsum;
		}

        //分类列表
		$map2=array();
        $map2['dlt_unitcode']=session('unitcode');
        $list2 = $Dltype->where($map2)->order('dlt_level ASC,dlt_id ASC')->select();
        $this->assign('dltypelist', $list2);
		
		
		$this->assign('page', $show);
		$this->assign('dealerlist', $list);

        $this->assign('pagecount', $count);
        $this->assign('page', $show);
        $this->assign('curr', 'dlordersum');
		$this->assign('unitcode', session('unitcode'));

        $this->display('dlordersum');
    }
   
   //=============================================================
  
   
}