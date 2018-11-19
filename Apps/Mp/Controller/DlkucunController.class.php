<?php
namespace Mp\Controller;
use Think\Controller;
//代理库存
class DlkucunController extends CommController {
	public function index(){
		exit;
	}
	
    //代理虚拟库存
    public function xnkclist()
    {
        if (session('unitcode') != '9999') {
            $this->error('对不起,没有该权限', '', 1);
        }
        $dlusername = trim(I('param.dlusername', ''));
        $map = array();
        $Dealer = M('Dealer');
        $Orders = M('Orders');
        $Dltype = M('Dltype');
        if ($dlusername != '' && $dlusername != '请填写代理账号') {
            if (!preg_match("/[a-zA-Z0-9_-]{4,20}$/", $dlusername)) {
                $this->error('填写代理账号不正确', '', 1);
            }
            $map['dl_username'] = $dlusername;
            $this->assign('dlusername', $dlusername);
        } else {
            $this->assign('dlusername', '请填写代理账号');
        }
        $map['dl_unitcode'] = session('unitcode');
        $count = $Dealer->where($map)->count();
        $Page = new \Think\Page($count, C('PAGE_SIZE'), $parameter);
        $show = $Page->show();
        $list = $Dealer->where($map)->order('dl_type ASC,dl_id ASC')->limit(($Page->firstRow . ',') . $Page->listRows)->select();
        $Model = M();
        foreach ($list as $k => $v) {
            //经销商级别
            $map2 = array();
            $map2['dlt_id'] = $v['dl_type'];
            $map2['dlt_unitcode'] = session('unitcode');
            $data2 = $Dltype->cache(true, 600, 'file')->where($map2)->find();
            if ($data2) {
                $list[$k]['dl_type_str'] = $data2['dlt_name'];
            } else {
                $list[$k]['dl_type_str'] = '-';
            }
            //上家代理
            if ($v['dl_belong'] > 0) {
                $map2 = array();
                $map2['dl_id'] = $v['dl_belong'];
                $map2['dl_unitcode'] = session('unitcode');
                $data2 = $Dealer->cache(true, 600, 'file')->where($map2)->find();
                if ($data2) {
                    $list[$k]['dl_belong_str'] = $data2['dl_name'] . '(' . $data2['dl_username'] . ')';
                } else {
                    $list[$k]['dl_belong_str'] = '-';
                }
            } else {
                $list[$k]['dl_belong_str'] = '直属公司';
            }
            // //库存
            // //订货总量  有效订货（订单状态 已发货 已完成）
            // $map4=array();
            // $map4['a.od_unitcode'] = session('unitcode');
            // $map4['a.od_state'] = array('in', '3,8');  //完成的订单
            // $map4['a.od_oddlid'] = $v['dl_id']; //下单代理
            // $map4['a.od_id'] = array('exp','=b.oddt_odid');
            // $map4['a.od_virtualstock']=1; //0--非虚拟库存订单 1--虚拟库存订单

            // $list4 = $Model->table('fw_orders a,fw_orderdetail b')->where($map4)->order('a.od_addtime DESC')->select();

            // $oddt_totalqty = 0; //上家虚拟订货总量
            // foreach($list4 as $kk=>$vv){
            // 	//订购数量
            // 	$oddt_unitsqty=0; //每单位包装的数量
            // 	if($vv['oddt_prodbiao']>0){
            // 		$oddt_unitsqty=$vv['oddt_prodbiao'];

            // 		if($vv['oddt_prozbiao']>0){
            // 			$oddt_unitsqty=$oddt_unitsqty*$vv['oddt_prozbiao'];
            // 		}

            // 		if($vv['oddt_proxbiao']>0){
            // 			$oddt_unitsqty=$oddt_unitsqty*$vv['oddt_proxbiao'];
            // 		}

            // 		$oddt_totalqty += $oddt_unitsqty*$vv['oddt_qty'];
            // 	}else{
            // 		$oddt_totalqty += $vv['oddt_qty'];
            // 	}
            // }


            // //下订货总量(包括有效的和未处理的)
            // $map4=array();
            // $map4['a.od_unitcode'] = session('unitcode');
            // $map4['a.od_state'] = array('in', '1,2,3,8');  //完成的订单
            // $map4['a.od_rcdlid'] = $v['dl_id']; //接单代理
            // $map4['a.od_id'] = array('exp','=b.oddt_odid');
            // $map4['a.od_virtualstock']=1; //0--非虚拟库存订单 1--虚拟库存订单

            // $list4 = $Model->table('fw_orders a,fw_orderdetail b')->where($map4)->order('a.od_addtime DESC')->select();

            // $virtualshipoddt_totalqty = 0; //下订货总量
            // foreach($list4 as $kk=>$vv){
            // 	//订购数量
            // 	$oddt_unitsqty=0; //每单位包装的数量
            // 	if($vv['oddt_prodbiao']>0){
            // 		$oddt_unitsqty=$vv['oddt_prodbiao'];

            // 		if($vv['oddt_prozbiao']>0){
            // 			$oddt_unitsqty=$oddt_unitsqty*$vv['oddt_prozbiao'];
            // 		}

            // 		if($vv['oddt_proxbiao']>0){
            // 			$oddt_unitsqty=$oddt_unitsqty*$vv['oddt_proxbiao'];
            // 		}

            // 		$virtualshipoddt_totalqty += $oddt_unitsqty*$vv['oddt_qty'];
            // 	}else{
            // 		$virtualshipoddt_totalqty += $vv['oddt_qty'];
            // 	}
            // }

            // //实际发货总量(包括有效的和未处理的)
            // $map4=array();
            // $map4['a.od_unitcode'] = session('unitcode');
            // $map4['a.od_state'] = array('in', '1,2,3,8');  //完成的订单
            // $map4['a.od_oddlid'] = $v['dl_id']; //下单代理
            // $map4['a.od_id'] = array('exp','=b.oddt_odid');
            // $map4['a.od_virtualstock']=0; //0--非虚拟库存订单 1--虚拟库存订单


            // $list4 = $Model->table('fw_orders a,fw_orderdetail b')->where($map4)->order('a.od_addtime DESC')->select();

            // $shipoddt_totalqty = 0; //实际发货总量
            // foreach($list4 as $kk=>$vv){
            // 	//订购数量
            // 	$oddt_unitsqty=0; //每单位包装的数量
            // 	if($vv['oddt_prodbiao']>0){
            // 		$oddt_unitsqty=$vv['oddt_prodbiao'];

            // 		if($vv['oddt_prozbiao']>0){
            // 			$oddt_unitsqty=$oddt_unitsqty*$vv['oddt_prozbiao'];
            // 		}

            // 		if($vv['oddt_proxbiao']>0){
            // 			$oddt_unitsqty=$oddt_unitsqty*$vv['oddt_proxbiao'];
            // 		}

            // 		$shipoddt_totalqty += $oddt_unitsqty*$vv['oddt_qty'];
            // 	}else{
            // 		$shipoddt_totalqty += $vv['oddt_qty'];
            // 	}
            // }

            // //剩余库存
            // $surplusqty=$oddt_totalqty-$virtualshipoddt_totalqty-$shipoddt_totalqty;

            $list[$k]['surplusqty'] = $this->mystock('', $v['dl_id']);
        }


        $this->assign('page', $show);
        $this->assign('dealerlist', $list);

        $this->assign('pagecount', $count);
        $this->assign('page', $show);
        $this->assign('curr', 'xnkclist');

        $this->display('xnkclist');
    }
	//代理虚拟某个产品库存
    public function xnkcprolist(){
        if(session('unitcode')!='9999'){
            $this->error('对不起,没有该权限','',1);
        }
		$pro_name=trim(I('param.pro_name',''));
		$dl_id=trim(I('param.dlid',''));
		$map=array();
		$Dealer = M('Dealer');
		$Orders = M('Orders');
		$Dltype = M('Dltype');
		$Product = M('Product');
        if($pro_name!='' && $pro_name!='请填写产品名称'){
            $map['pro_name']=$pro_name;
			$this->assign('pro_name', $pro_name);
        }else{
			$this->assign('pro_name','请填写产品名称');
		}
		$dlid=intval(I('get.dl_id',0));
		if ($dlid!='')
		{
			$dl_id=$dlid;
		}
		// 经销商
		$mapdl=array();
		$mapdl['dl_id']=$dl_id;
		$mapdl['dl_unitcode']=session('unitcode');
		$mapdl['dl_status']=1;
			// $data2 = $Dltype->cache(true,600,'file')->where($map2)->find();
		$datadl = $Dealer->where($mapdl)->find();
		if($datadl){
			$dl_name=$datadl['dl_name'];
			$dl_username=$datadl['dl_username'];
			$dl_number=$datadl['dl_number'];
		}else{
			$this->error('该代理还没审核或已禁用','',2);
		}

		$map['pro_unitcode']=session('unitcode');
		$map['pro_active']=1;	
        $count = $Product->where($map)->count();
        $Page = new \Think\Page($count, C('PAGE_SIZE'),$parameter);
        $show = $Page->show();
        $list = $Product->where($map)->order('pro_id DESC,pro_order DESC')->limit(($Page->firstRow . ',') . $Page->listRows)->select();
        $Model=M();
		foreach($list as $k=>$v){
			// //上家代理
			// if($v['dl_belong']>0){
			// 	$map2=array();
			// 	$map2['dl_id']=$v['dl_belong'];
			// 	$map2['dl_unitcode']=session('unitcode');
			// 	$data2=$Dealer->cache(true,600,'file')->where($map2)->find();
			// 	if($data2){
			// 		$list[$k]['dl_belong_str']=$data2['dl_name'].'('.$data2['dl_username'].')';
			// 	}else{
			// 		$list[$k]['dl_belong_str']='-';
			// 	}
			// }else{
			// 	$list[$k]['dl_belong_str']='直属公司';
			// }
			
			// //库存
			// //订货总量  有效订货（订单状态 已发货 已完成） 
			// $map4=array();
			// $map4['a.od_unitcode'] = session('unitcode');
			// $map4['a.od_state'] = array('in', '3,8');  //完成的订单 
			// $map4['a.od_oddlid'] = $dl_id; //下单代理
			// $map4['b.oddt_proid'] = $v['pro_id']; //产品ID
			// $map4['a.od_id'] = array('exp','=b.oddt_odid');
			// $map4['a.od_virtualstock']=1; //0--非虚拟库存订单 1--虚拟库存订单

			// $list4 = $Model->table('fw_orders a,fw_orderdetail b')->where($map4)->order('a.od_addtime DESC')->select();

			// $oddt_totalqty = 0; //上家虚拟订货总量
			// foreach($list4 as $kk=>$vv){
			// 	//订购数量
			// 	$oddt_unitsqty=0; //每单位包装的数量
			// 	if($vv['oddt_prodbiao']>0){
			// 		$oddt_unitsqty=$vv['oddt_prodbiao'];
					
			// 		if($vv['oddt_prozbiao']>0){
			// 			$oddt_unitsqty=$oddt_unitsqty*$vv['oddt_prozbiao'];
			// 		}
					
			// 		if($vv['oddt_proxbiao']>0){
			// 			$oddt_unitsqty=$oddt_unitsqty*$vv['oddt_proxbiao'];
			// 		}
					
			// 		$oddt_totalqty += $oddt_unitsqty*$vv['oddt_qty'];
			// 	}else{
			// 		$oddt_totalqty += $vv['oddt_qty'];
			// 	}
			// } 

						  
			// //下订货总量(包括有效的和未处理的)
			// $map4=array();
			// $map4['a.od_unitcode'] = session('unitcode');
			// $map4['a.od_state'] = array('in', '1,2,3,8');  //完成的订单 
			// $map4['a.od_rcdlid'] =$dl_id; //接单代理
			// $map4['b.oddt_proid'] = $v['pro_id']; //产品ID
			// $map4['a.od_id'] = array('exp','=b.oddt_odid');
			// $map4['a.od_virtualstock']=1; //0--非虚拟库存订单 1--虚拟库存订单

			// $list4 = $Model->table('fw_orders a,fw_orderdetail b')->where($map4)->order('a.od_addtime DESC')->select();
			
			// $virtualshipoddt_totalqty = 0; //下订货总量
			// foreach($list4 as $kk=>$vv){
			// 	//订购数量
			// 	$oddt_unitsqty=0; //每单位包装的数量
			// 	if($vv['oddt_prodbiao']>0){
			// 		$oddt_unitsqty=$vv['oddt_prodbiao'];
					
			// 		if($vv['oddt_prozbiao']>0){
			// 			$oddt_unitsqty=$oddt_unitsqty*$vv['oddt_prozbiao'];
			// 		}
					
			// 		if($vv['oddt_proxbiao']>0){
			// 			$oddt_unitsqty=$oddt_unitsqty*$vv['oddt_proxbiao'];
			// 		}
					
			// 		$virtualshipoddt_totalqty += $oddt_unitsqty*$vv['oddt_qty'];
			// 	}else{
			// 		$virtualshipoddt_totalqty += $vv['oddt_qty'];
			// 	}
			// } 
			
			// //实际发货总量(包括有效的和未处理的)
			// $map4=array();
			// $map4['a.od_unitcode'] = session('unitcode');
			// $map4['a.od_state'] = array('in', '1,2,3,8');  //完成的订单 
			// $map4['a.od_oddlid'] = $dl_id; //下单代理
			// $map4['b.oddt_proid'] = $v['pro_id']; //产品ID
			// $map4['a.od_id'] = array('exp','=b.oddt_odid');
			// $map4['a.od_virtualstock']=0; //0--非虚拟库存订单 1--虚拟库存订单


			// $list4 = $Model->table('fw_orders a,fw_orderdetail b')->where($map4)->order('a.od_addtime DESC')->select();
			
			// $shipoddt_totalqty = 0; //实际发货总量
			// foreach($list4 as $kk=>$vv){
			// 	//订购数量
			// 	$oddt_unitsqty=0; //每单位包装的数量
			// 	if($vv['oddt_prodbiao']>0){
			// 		$oddt_unitsqty=$vv['oddt_prodbiao'];
					
			// 		if($vv['oddt_prozbiao']>0){
			// 			$oddt_unitsqty=$oddt_unitsqty*$vv['oddt_prozbiao'];
			// 		}
					
			// 		if($vv['oddt_proxbiao']>0){
			// 			$oddt_unitsqty=$oddt_unitsqty*$vv['oddt_proxbiao'];
			// 		}
					
			// 		$shipoddt_totalqty += $oddt_unitsqty*$vv['oddt_qty'];
			// 	}else{
			// 		$shipoddt_totalqty += $vv['oddt_qty'];
			// 	}
			// }
			
			// //剩余库存
			// $surplusqty=$oddt_totalqty-$virtualshipoddt_totalqty-$shipoddt_totalqty;
			$list[$k]['surplusqty']=$this->mystock($v,$dl_id);
		}
		// var_dump($list);
		$this->assign('dl_id', $dl_id);
		$this->assign('dl_name', $dl_name);
		$this->assign('dl_username', $dl_username);
		$this->assign('dl_number', $dl_number);
		$this->assign('page', $show);
		$this->assign('prolist', $list);

        $this->assign('pagecount', $count);
        $this->assign('page', $show);
        $this->assign('curr', 'xnkclist');


        $this->display('xnkcprolist');
    }
	
	
	//增加库存
    public function xnkcadd(){
        if(session('unitcode')!='9999'){
            $this->error('对不起,没有该权限','',1);
        }
        $dl_id=intval(I('get.dl_id',0));
        $pro_id=intval(I('get.pro_id',0));
		$Dealer= M('Dealer');
		$map=array();
		$map['dl_id']=$dl_id;
		$map['dl_unitcode']=session('unitcode');
		$data=$Dealer->cache(true,600,'file')->where($map)->find();
		if($data){
			if($data['dl_status']==1){
				$data['dl_name_str']=$data['dl_name'].'('.$data['dl_username'].')';
				$dl_belong=$data['dl_belong'];
			}else{
				$this->error('该代理还没审核或已禁用','',2);
			}
		}else{
			$this->error('该代理不存在','',2);
		}
		//上家代理
		if($dl_belong>0){
			$map2=array();
			$map2['dl_id']=$data['dl_belong'];
			$map2['dl_unitcode']=session('unitcode');
			$data2=$Dealer->cache(true,600,'file')->where($map2)->find();
			if($data2){
				$data['dl_belong_str']=$data2['dl_name'].'('.$data2['dl_username'].')';
			}else{
				$data['dl_belong_str']='-';
			}
		}else{
			$data['dl_belong_str']='直属公司';
		}
		$iscompany=false;
		//产品
		$map2 = array();
        $Product = M('Product');
        $map2['pro_unitcode']=session('unitcode');
        $map2['pro_id']=$pro_id;
        $map2['pro_active']=1;
        $prolist = $Product->where($map2)->order('pro_id DESC')->limit(1)->select();
		
		if(isset($prolist[0]['pro_id']) && $prolist[0]['pro_id']>0){
				//判断订货上家的库存
				if($dl_belong==0){
					$data['dl_belong_stock']=$prolist[0]['pro_stock'];
				}else{
					//判断上家库存足不足  上家订货总数-下家订货总数-发货总数
					 //上家虚拟订货总量  有效订货（订单状态 已发货 已完成） 
		            $Model=M();
					$map4=array();
					$map4['a.od_unitcode'] = session('unitcode');
					$map4['a.od_state'] = array('in', '3,8');  //完成的订单 
					$map4['a.od_oddlid'] = $dl_belong; //下单代理
					$map4['a.od_id'] = array('exp','=b.oddt_odid');
					$map4['a.od_virtualstock']=1; //0--非虚拟库存订单 1--虚拟库存订单
					$map4['b.oddt_proid'] =$prolist[0]['pro_id'];
					
					$list4 = $Model->table('fw_orders a,fw_orderdetail b')->where($map4)->order('a.od_addtime DESC')->select();

					$oddt_totalqty = 0; //上家虚拟订货总量
					foreach($list4 as $kk=>$vv){
							//订购数量
							$oddt_unitsqty=0; //每单位包装的数量
							if($vv['oddt_prodbiao']>0){
								$oddt_unitsqty=$vv['oddt_prodbiao'];
								
								if($vv['oddt_prozbiao']>0){
									$oddt_unitsqty=$oddt_unitsqty*$vv['oddt_prozbiao'];
								}
								
								if($vv['oddt_proxbiao']>0){
									$oddt_unitsqty=$oddt_unitsqty*$vv['oddt_proxbiao'];
								}
								
								$oddt_totalqty += $oddt_unitsqty*$vv['oddt_qty'];
							}else{
								$oddt_totalqty += $vv['oddt_qty'];
							}
					} 

								  
					//上家虚拟出货总量(包括有效的和未处理的)
					$map4=array();
					$map4['a.od_unitcode'] = session('unitcode');
					$map4['a.od_state'] = array('in', '1,2,3,8');  //完成的订单 
					$map4['a.od_rcdlid'] = $dl_belong; //接单代理
					$map4['a.od_id'] = array('exp','=b.oddt_odid');
					$map4['a.od_virtualstock']=1; //0--非虚拟库存订单 1--虚拟库存订单
					$map4['b.oddt_proid'] =$prolist[0]['pro_id'];
					$list4 = $Model->table('fw_orders a,fw_orderdetail b')->where($map4)->order('a.od_addtime DESC')->select();
					
					$virtualshipoddt_totalqty = 0; //上家虚拟出货总量
					foreach($list4 as $kk=>$vv){
							//订购数量
							$oddt_unitsqty=0; //每单位包装的数量
							if($vv['oddt_prodbiao']>0){
								$oddt_unitsqty=$vv['oddt_prodbiao'];
								
								if($vv['oddt_prozbiao']>0){
									$oddt_unitsqty=$oddt_unitsqty*$vv['oddt_prozbiao'];
								}
								
								if($vv['oddt_proxbiao']>0){
									$oddt_unitsqty=$oddt_unitsqty*$vv['oddt_proxbiao'];
								}
								
								$virtualshipoddt_totalqty += $oddt_unitsqty*$vv['oddt_qty'];
							}else{
								$virtualshipoddt_totalqty += $vv['oddt_qty'];
							}

					} 
					
					//上家实际发货总量(包括有效的和未处理的)
					$map4=array();
					$map4['a.od_unitcode'] = session('unitcode');
					$map4['a.od_state'] = array('in', '1,2,3,8');  //完成的订单 
					$map4['a.od_oddlid'] = $dl_belong; //下单代理
					$map4['a.od_id'] = array('exp','=b.oddt_odid');
					$map4['a.od_virtualstock']=0; //0--非虚拟库存订单 1--虚拟库存订单
					$map4['b.oddt_proid'] =$prolist[0]['pro_id'];
					$list4 = $Model->table('fw_orders a,fw_orderdetail b')->where($map4)->order('a.od_addtime DESC')->select();
					
					$shipoddt_totalqty = 0; //上家实际发货总量
					foreach($list4 as $kk=>$vv){
							//订购数量
							$oddt_unitsqty=0; //每单位包装的数量
							if($vv['oddt_prodbiao']>0){
								$oddt_unitsqty=$vv['oddt_prodbiao'];
								
								if($vv['oddt_prozbiao']>0){
									$oddt_unitsqty=$oddt_unitsqty*$vv['oddt_prozbiao'];
								}
								
								if($vv['oddt_proxbiao']>0){
									$oddt_unitsqty=$oddt_unitsqty*$vv['oddt_proxbiao'];
								}
								
								$shipoddt_totalqty += $oddt_unitsqty*$vv['oddt_qty'];
							}else{
								$shipoddt_totalqty += $vv['oddt_qty'];
							}

					}
					
					//剩余库存
                    $surplusqty=$oddt_totalqty-$virtualshipoddt_totalqty-$shipoddt_totalqty;
					$data['dl_belong_stock']=$surplusqty;

				}

		}else{
			$this->error('没有产品','',2);
		}
        $this->assign('iscompany', $$iscompany);
        $this->assign('dealerinfo', $data);
        $this->assign('prolist', $prolist);
		
        $this->assign('curr', 'xnkclist');
        $this->display('xnkcadd');
	}
	
    //增加库存 保存
    public function xnkcadd_save(){
        if(session('unitcode')!='9999'){
            $this->error('对不起,没有该权限','',1);
        }
		
		$dl_id=intval(I('post.dl_id',0));
		$dl_belong=intval(I('post.dl_belong',0));
		$pro_id=intval(I('post.pro_id',0));
		$dl_belong_stock=intval(I('post.dl_belong_stock',0));
		$kc_add=intval(I('post.kc_add',0));
		$kc_remark=trim(I('post.kc_remark',''));
		

		if($dl_id<=0 || $pro_id<=0){
			$this->error('没有该记录','',2);
		}
		if($dl_belong_stock<$kc_add&&$dl_belong>0){
			$this->error('增加库存大于上家库存','',2);
		}
		

		if($dl_id>0){
			$Dealer= M('Dealer');
			$map=array();
			$map['dl_id']=$dl_id;
			$map['dl_unitcode']=session('unitcode');

			$Orders=M('Orders');
			$mapod=array();
			$mapod['od_unitcode'] = session('unitcode');
			$mapod['od_state'] = array('in', '0,1,2,3,8');  //完成的订单 
			$mapod['od_oddlid'] = $dl_id; //下单代理
			$mapod['od_virtualstock']=1; //0--非虚拟库存订单 1--虚拟库存订单
			$countod = $Orders->where($mapod)->order('od_addtime DESC')->count();

			$datadl=$Dealer->cache(true,600,'file')->where($map)->find();
			if($datadl){
				if($datadl['dl_status']==1){
					$datadl['dl_name_str']=$datadl['dl_name'].'('.$datadl['dl_username'].')';
					$dl_belong=$datadl['dl_belong'];
					$dl_type=$datadl['dl_type'];

					$Dladdress=M('Dladdress');
					$mapad['dladd_unitcode']=session('unitcode');
					$mapad['dladd_dlid']=$dl_id;
					$mapad['dladd_default']=1;
					$dataad=$Dladdress->where($mapad)->find();
				}else{
					$this->error('该代理还没审核或已禁用','',2);
				}
			}else{
				$this->error('该代理不存在','',2);
			}
			

			$Product = M('Product');
			$Proprice = M('Proprice');
			$total=0;
			
			$map2=array();
			$data2=array();
			$map2['pro_id']=$pro_id;
			$map2['pro_unitcode']=session('unitcode');
			$map2['pro_active']=1;
			
			//产品
			$data2=$Product->where($map2)->find();
			if($data2){
				//代理价
				$map3=array();
				$data3=array();
				$map3['pri_proid']=$data2['pro_id'];
				$map3['pri_unitcode']=session('unitcode');
				$map3['pri_dltype']=$dl_type;

				$data3=$Proprice->where($map3)->find();
				if($data3){
					$data2['pro_dlprice']=$data3['pri_price'];
					$total=$total+$data3['pri_price']*$kc_add;
				}else{
					$this->error('产品代理价没设置','',2);
				}
			}else{
                $this->error('没有产品记录','',2);
			}
			
			//判断订货上家的库存
			if($dl_belong==0){
				// if($data2['pro_stock']<$kc_add){
				// 	$this->error('对不起，上家产品'.$data2['pro_name'].' 的库存不足','',2);
				// }
			}else{
				//判断上家库存足不足  上家订货总数-下家订货总数-发货总数
				 //上家虚拟订货总量  有效订货（订单状态 已发货 已完成） 
				$Model=M();
				$map4=array();
				$map4['a.od_unitcode'] = session('unitcode');
				$map4['a.od_state'] = array('in', '3,8');  //完成的订单 
				$map4['a.od_oddlid'] = $dl_belong; //下单代理
				$map4['a.od_id'] = array('exp','=b.oddt_odid');
				$map4['a.od_virtualstock']=1; //0--非虚拟库存订单 1--虚拟库存订单
				$map4['b.oddt_proid'] =$pro_id;
				
				$list4 = $Model->table('fw_orders a,fw_orderdetail b')->where($map4)->order('a.od_addtime DESC')->select();

				$oddt_totalqty = 0; //上家虚拟订货总量
				foreach($list4 as $kk=>$vv){
						//订购数量
						$oddt_unitsqty=0; //每单位包装的数量
						if($vv['oddt_prodbiao']>0){
							$oddt_unitsqty=$vv['oddt_prodbiao'];
							
							if($vv['oddt_prozbiao']>0){
								$oddt_unitsqty=$oddt_unitsqty*$vv['oddt_prozbiao'];
							}
							
							if($vv['oddt_proxbiao']>0){
								$oddt_unitsqty=$oddt_unitsqty*$vv['oddt_proxbiao'];
							}
							
							$oddt_totalqty += $oddt_unitsqty*$vv['oddt_qty'];
						}else{
							$oddt_totalqty += $vv['oddt_qty'];
						}
				} 

							  
				//上家虚拟出货总量(包括有效的和未处理的)
				$map4=array();
				$map4['a.od_unitcode'] = session('unitcode');
				$map4['a.od_state'] = array('in', '1,2,3,8');  //完成的订单 
				$map4['a.od_rcdlid'] = $dl_belong; //接单代理
				$map4['a.od_id'] = array('exp','=b.oddt_odid');
				$map4['a.od_virtualstock']=1; //0--非虚拟库存订单 1--虚拟库存订单
				$map4['b.oddt_proid'] =$pro_id;
				$list4 = $Model->table('fw_orders a,fw_orderdetail b')->where($map4)->order('a.od_addtime DESC')->select();
				
				$virtualshipoddt_totalqty = 0; //上家虚拟出货总量
				foreach($list4 as $kk=>$vv){
						//订购数量
						$oddt_unitsqty=0; //每单位包装的数量
						if($vv['oddt_prodbiao']>0){
							$oddt_unitsqty=$vv['oddt_prodbiao'];
							
							if($vv['oddt_prozbiao']>0){
								$oddt_unitsqty=$oddt_unitsqty*$vv['oddt_prozbiao'];
							}
							
							if($vv['oddt_proxbiao']>0){
								$oddt_unitsqty=$oddt_unitsqty*$vv['oddt_proxbiao'];
							}
							
							$virtualshipoddt_totalqty += $oddt_unitsqty*$vv['oddt_qty'];
						}else{
							$virtualshipoddt_totalqty += $vv['oddt_qty'];
						}

				} 
				
				//上家实际发货总量(包括有效的和未处理的)
				$map4=array();
				$map4['a.od_unitcode'] = session('unitcode');
				$map4['a.od_state'] = array('in', '1,2,3,8');  //完成的订单 
				$map4['a.od_oddlid'] = $dl_belong; //下单代理
				$map4['a.od_id'] = array('exp','=b.oddt_odid');
				$map4['a.od_virtualstock']=0; //0--非虚拟库存订单 1--虚拟库存订单
				$map4['b.oddt_proid'] =$pro_id;
				$list4 = $Model->table('fw_orders a,fw_orderdetail b')->where($map4)->order('a.od_addtime DESC')->select();
				
				$shipoddt_totalqty = 0; //上家实际发货总量
				foreach($list4 as $kk=>$vv){
						//订购数量
						$oddt_unitsqty=0; //每单位包装的数量
						if($vv['oddt_prodbiao']>0){
							$oddt_unitsqty=$vv['oddt_prodbiao'];
							
							if($vv['oddt_prozbiao']>0){
								$oddt_unitsqty=$oddt_unitsqty*$vv['oddt_prozbiao'];
							}
							
							if($vv['oddt_proxbiao']>0){
								$oddt_unitsqty=$oddt_unitsqty*$vv['oddt_proxbiao'];
							}
							
							$shipoddt_totalqty += $oddt_unitsqty*$vv['oddt_qty'];
						}else{
							$shipoddt_totalqty += $vv['oddt_qty'];
						}

				}
				
				//剩余库存
				$surplusqty=$oddt_totalqty-$virtualshipoddt_totalqty-$shipoddt_totalqty;
				if($surplusqty<$kc_add){
					$this->error('对不起，上家产品'.$data2['pro_name'].' 的库存不足','',2);
				}
			}
			
			
			//保存订单
			if($total<=0){
				$this->error('没有产品记录','',2);
			}
			
			$nowtime=time();
			$Orders = M('Orders');
			$orderarr=array();
			$od_orderid=date('YmdHis',$nowtime).mt_rand(1000,9999);
			
			$orderarr['od_unitcode']=session('unitcode');
			$orderarr['od_orderid']=$od_orderid;
			$orderarr['od_total']=$total;
			$orderarr['od_addtime']=$nowtime;
			$orderarr['od_oddlid']=$dl_id;
			$orderarr['od_rcdlid']=$dl_belong;  //接收订单的代理id 0则为总公司
			$orderarr['od_paypic']=''; //凭证图片
			$orderarr['od_remark']=$kc_remark;
			$orderarr['od_contact']=$dataad['dladd_contact'];
			$orderarr['od_addressid']=$dataad['dladd_id'];
			$orderarr['od_sheng']=$dataad['dladd_sheng'];
			$orderarr['od_shi']=$dataad['dladd_shi'];
			$orderarr['od_qu']=$dataad['dladd_qu'];
			$orderarr['od_jie']=0;
			$orderarr['od_address']=$dataad['dladd_address'];
			$orderarr['od_tel']=$dataad['dladd_tel'];
			if ($countod>0)
				$orderarr['od_fugou']=1;
			else
				$orderarr['od_fugou']=0;
			$orderarr['od_express']=0;
			$orderarr['od_expressnum']='';
			$orderarr['od_expressdate']=0;
			$orderarr['od_state']=1; //直接改为完成状态
			$orderarr['od_virtualstock']=1; // 0--非虚拟库存订单  1--虚拟库存订单
			
			$rs=$Orders->create($orderarr,1);
			if($rs){
				$result = $Orders->add(); 
				if($result){
					// //保存订单关系 订单详细
					// $Orderbelong = M('Orderbelong');
					// $belongarr=array();
					// $belongarr['odbl_unitcode']=session('unitcode');
					// $belongarr['odbl_odid']=$result;
					// $belongarr['odbl_orderid']=$od_orderid;
					// $belongarr['odbl_total']=$total;
					// $belongarr['odbl_oddlid']=$dl_id; //下订单的代理id
					// $belongarr['odbl_rcdlid']=$dl_belong;  //接收订单的代理id 0则为总公司
					// $belongarr['odbl_paypic']=''; //凭证图片
					// $belongarr['odbl_remark']=$kc_remark;
					// $belongarr['odbl_addtime']=$nowtime;
					// $belongarr['odbl_belongship']=0; //是否转上家发货
					// $belongarr['odbl_state']=1;
					
					// $rs2=$Orderbelong->create($belongarr,1);
					// if($rs2){
					// 	$result2 = $Orderbelong->add();
					// 	if($result2){
							//订单详细
							$Orderdetail = M('Orderdetail');

								if($data2['pro_dlprice']!=''){
									$detailarr=array();
									$detailarr['oddt_unitcode']=session('unitcode');
									$detailarr['oddt_odid']=$result;
									$detailarr['oddt_orderid']=$od_orderid;
									// $detailarr['oddt_odblid']=$result2;
									$detailarr['oddt_proid']=$data2['pro_id'];
									$detailarr['oddt_proname']=$data2['pro_name'];
									$detailarr['oddt_pronumber']=$data2['pro_number'];
									$detailarr['oddt_prounits']=$data2['pro_units'];
									$detailarr['oddt_prodbiao']=$data2['pro_dbiao'];
									$detailarr['oddt_prozbiao']=$data2['pro_zbiao'];
									$detailarr['oddt_proxbiao']=$data2['pro_xbiao'];
									$detailarr['oddt_price']=$data2['pro_price'];
									$detailarr['oddt_dlprice']=$data2['pro_dlprice'];
									$detailarr['oddt_qty']=$kc_add;
									$rs3=$Orderdetail->create($detailarr,1);
									if($rs3){
										$result3 = $Orderdetail->add();
										if($result3){

										}else{
											//提交订单失败 把之前订单信息删除
											$map3=array();
											$map3['od_unitcode']=session('unitcode');
											$map3['od_id']=$result;
											$map3['od_oddlid']=$dl_id;
											$Orders->where($map3)->delete();
											
											$map3=array();
											$map3['odbl_unitcode']=session('unitcode');
											$map3['odbl_odid']=$result;
											$map3['odbl_oddlid']=$dl_id;
											$Orderbelong->where($map3)->delete();
											
											$map3=array();
											$map3['oddt_unitcode']=session('unitcode');
											$map3['oddt_odid']=$result;
											$Orderdetail->where($map3)->delete();
											
											$this->error('提交失败','',2);
										}
									}else{
										//提交订单失败 把之前订单信息删除
										$map3=array();
										$map3['od_unitcode']=session('unitcode');
										$map3['od_id']=$result;
										$map3['od_oddlid']=$dl_id;
										$Orders->where($map3)->delete();
										
										$map3=array();
										$map3['odbl_unitcode']=session('unitcode');
										$map3['odbl_odid']=$result;
										$map3['odbl_oddlid']=$dl_id;
										$Orderbelong->where($map3)->delete();
										
										$map3=array();
										$map3['oddt_unitcode']=session('unitcode');
										$map3['oddt_odid']=$result;
										$Orderdetail->where($map3)->delete();
										
										$this->error('提交失败','',2);
									}
								}
							
							//订单操作日志 begin
							$odlog_arr=array(
										'odlg_unitcode'=>session('unitcode'),  
										'odlg_odid'=>$result,
										'odlg_orderid'=>$od_orderid,
										'odlg_dlid'=>session('qyid'),
										'odlg_dlusername'=>session('qyuser'),
										'odlg_dlname'=>session('qyuser'),
										'odlg_action'=>'公司代订货(增减库存)',
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
							
							$this->success('提交成功',U('./Mp/Dlkucun/xnkcadd?dl_id='.$dl_id.'?pro_id='.$data2['pro_id'].''),2);
							exit;
					// 	}else{
					// 		//提交订单失败 把订单基本信息删除
					// 		$map3=array();
					// 		$map3['od_unitcode']=session('unitcode');
					// 		$map3['od_id']=$result;
					// 		$map3['od_oddlid']=$dl_id;
					// 		$Orders->where($map3)->delete();

					// 		$this->error('提交失败','',2);
					// 		exit;
					// 	}
					// }else{
					// 	//提交订单失败 把订单基本信息删除
					// 	$map3=array();
					// 	$map3['od_unitcode']=session('unitcode');
					// 	$map3['od_id']=$result;
					// 	$map3['od_oddlid']=$dl_id;
					// 	$Orders->where($map3)->delete();

					// 	$this->error('提交失败','',2);
					// 	exit;
					// }
				}else{
					$this->error('提交失败','',2);
				}
			}else{
				$this->error('提交失败','',2);
			}

		}else{
			$this->error('没有该记录','',2);
		}
	}
	
	
	//减少库存
    public function xnkccut(){
		if(session('unitcode')!='9999'){
            $this->error('对不起,没有该权限','',1);
        }
		
        $this->assign('curr', 'xnkclist');
        $this->display('xnkccut');
	}

}