<?php
namespace Mp\Controller;
use Think\Controller;
     
    class CommController extends Controller
    {
        public function _initialize()
        {
            if(!$this->is_qiye_login())
            {
                $this->redirect('Mp/Login/index','' , 0, '');
            }
            $isSub=false;
            $qybindwx=false;
        	if (strpos(session('qyuser'),':')!==false)
        	{
            	$isSub=true;
            	$qy_username_arr=explode(":",session('qyuser'));
				reset($qy_username_arr);
				$qy_username=current($qy_username_arr);
				$qy_subusername=end($qy_username_arr);
        	}
           	if($isSub){
				$Qysubuser=M('Qysubuser');
				$map=array();
				$map['su_unitcode']=session('unitcode');
				$map['su_username']=$qy_subusername;
				$data=$Qysubuser->where($map)->find();
				if ($data)
				{
					if ($data['su_openid']!=''&&$data['su_openid']!=null)
					{
						 $qybindwx=true;
					}
				}
			}else{
				$Qyinfo=M('Qyinfo');
				$map=array();
				$map['qy_unitcode']=session('unitcode');
				$map['qy_id']=session('qyid');
				$map['qy_username']=session('qyuser');
				$data=$Qyinfo->where($map)->find();
				if ($data)
				{
					if ($data['qy_openid']!=''&&$data['qy_openid']!=null)
					{
						 $qybindwx=true;
					}
				}
			}
            $this->assign('qyuser', session('qyuser'));
            $this->assign('qypurview', session('qy_purview'));
			$this->assign('qyname', session('qyname'));
			$this->assign('qypic', session('qypic'));
			$this->assign('qybindwx',$qybindwx);
        }
        //判断登录
        public function is_qiye_login(){
            $cookie_check=cookie('qiye_check');
            $session_check=session('qiye_check');

            if(session('qyid')=='' || session('qyuser')=='' || session('qyname')=='' || session('unitcode')==''){
                return false;
            }
            if($cookie_check=='' || $session_check==''){
                return false;
            }else{
              if($cookie_check==$session_check){
                  return true;
              }else{
                  return false;
              }
            }
        }

        //验证管理员权限  '10001' 
        public function check_qypurview($ac='',$re=0)
        {
            $qy_purview=session('qy_purview');

            if(is_array($qy_purview) && count($qy_purview)>0 && is_not_null($ac)){
                if(isset($qy_purview[$ac])){
                    if($re==0){
                        return true;
                    }else{
                    }
                }else{
                    if($re==0){
                        return false;
                    }else{
                        $this->error('对不起，没有该权限！','',1);
                    }
                }
            }else{
                if($re==0){
                    return false;
                }else{
                    $this->error('对不起，没有该权限！','',1);
                }
                
            }
        }
		
		//返回上家ID 根据申请的级别和推荐人的上家 $jxid-推荐人的上家  $apply_level-申请级别 
		public function get_dlbelong($jxid,$apply_level){
			$Dltype = M('Dltype');
			$Dealer = M('Dealer');
			//上家信息-1
			$map=array();
			$data=array();
			$map['dl_id']=intval($jxid);
			$map['dl_unitcode']=session('unitcode');
			$data=$Dealer->where($map)->find();

			if($data){
				if($data['dl_status']==1){
					//上家的级别-1
					$map2=array();
					$data2=array();
					$map2['dlt_id']=$data['dl_type'];
					$map2['dlt_unitcode']=session('unitcode');
					$data2=$Dltype->where($map2)->find();
					if($data2){
						if($apply_level<=$data2['dlt_level']){  //如果申请的级别高于 或 同级 
						    if($data['dl_belong']>0){
							    return $this->get_dlbelong($data['dl_belong'],$apply_level);
							}else{
								return 0;
							}
						}else{
							return $data['dl_id'];
						}
					}else{
						return false;
					}
				}else{  //上家的上家
					if($data['dl_belong']>0){
						return $this->get_dlbelong($data['dl_belong'],$apply_level);
					}else{
						return 0;
					}
				}
			}else{
				return false;
			}
		}
		
        //返回有效上家arr
		public function get_dlbelongarr($jxid,$dl_level){
			$Dealer = M('Dealer');
			//上家信息-1
			$map=array();
			$data=array();
			$map['dl_id']=intval($jxid);
			$map['dl_unitcode']=session('unitcode');
			$data=$Dealer->where($map)->find();

			if($data){
				if($data['dl_status']==1){
					if($dl_level>$data['dl_level']){ 
						$this->belong_arrs[]=array('id'=>$data['dl_id'],'name'=>$data['dl_name']);
						if($data['dl_belong']>0){
						   $this->get_dlbelongarr($data['dl_belong'],$dl_level);
						}
					}else if($dl_level==$data['dl_level']){
						if($data['dl_belong']>0){
						   $this->get_dlbelongarr($data['dl_belong'],$dl_level);
						}
					}
				}else{
					if($data['dl_belong']>0){
						$this->get_dlbelongarr($data['dl_belong'],$dl_level);
					}
				}
			}
		}

		//递归返回推荐人数组 $dlid--代理id
		public function get_dltjarray($dlid){
			$Dealer = M('Dealer');
			//
			$map=array();
			$data=array();
			$map['dl_id']=intval($dlid);
			$map['dl_unitcode']=session('unitcode');
			$data=$Dealer->where($map)->find();
			if($data){
				if($data['dl_referee']>0){//排除推荐人为总公司
					$map2=array();
					$data2=array();
					$map2['dl_id'] = $data['dl_referee'];
					$map2['dl_unitcode']=session('unitcode');
					$data2 = $Dealer->where($map2)->find();
					if($data2){//当前经销商的推荐人
						if ($data2['dl_status']==1)
						{ 
							$this->dltj_arrs[]=array('id'=>$data2['dl_id'],'name'=>$data2['dl_name'],'level'=>$data2['dl_level']);
							if($data2['dl_referee']!=$data['dl_id']){
						    	$this->get_dltjarray($data2['dl_id']);	
							}
						}
					}
				}
				// else
				// {
				// 	$this->dltj_arrs[]=array('id'=>'0','name'=>'总公司','level'=>'0');
				// }
			}
		}
		
		
		//递归返回推荐人路线 $dlid--推荐人的id
		public function get_dlrefereelines($dlid){
			$Dltype = M('Dltype');
			$Dealer = M('Dealer');
					
			$map=array();
			$data=array();
			$map['dl_id']=intval($dlid);
			$map['dl_unitcode']=session('unitcode');
			$data=$Dealer->where($map)->find();
			if($data){
				if($data['dl_referee']>0){
					$map2=array();
					$data2=array();
					$map2['dl_id'] =  $data['dl_referee'];
					$map2['dl_unitcode']=session('unitcode');
					$data2 = $Dealer->where($map2)->find();
					if($data2){
						//推荐人状态
						$dl_referee_status='';
						if($data2['dl_status']==0){
							$dl_referee_status='新';
						}else if($data2['dl_status']==1){
							$dl_referee_status='正常';
						}else if($data2['dl_status']==9){
							$dl_referee_status='禁用';
						}else{
							$dl_referee_status='未知';
						}
						
						//推荐人级别
						$map3=array();
						$map3['dlt_unitcode']=session('unitcode');
						$map3['dlt_id'] = $data2['dl_type'];
						$data3 = $Dltype->where($map3)->find();
						if($data3){
							$dl_referee_type=$data3['dlt_name'];
						}else{
							$dl_referee_type='-';
						}
						
					    $this->referee_lines.=' <- '.$data2['dl_name'].' ('.$data2['dl_username'].')('.$dl_referee_type.')['.$dl_referee_status.']';
					    
						if($data2['dl_referee']!=$data['dl_id']){
						    $this->referee_lines.=$this->get_dlrefereelines($data2['dl_id']);	
						}
					}
				}else{
					$this->referee_lines.=' <- 总公司';
				}
			}
		}
		

        //库存查询
        /*@probean  产品信息
          @dl_id    代理id
         */
        public function mystock($probean,$dl_id){
            //--------------------------------
            $Model=M();
            //库存订货总量  有效订货（订单状态 已发货 已完成）
            $map4=array();
            $map4['a.od_unitcode'] =session('unitcode');
            $map4['a.od_state'] = array('in', '3,8');  //完成的订单 
            if ($dl_id>0)
            {
                $map4['a.od_oddlid'] =$dl_id; //下单代理session('jxuser_id')
                $map4['a.od_id'] = array('exp','=b.oddt_odid');
                $map4['a.od_virtualstock']=1; //0--非虚拟库存订单 1--虚拟库存订单
            }
            if ($probean)
            {
                $map4['b.oddt_proid']=$probean['pro_id'];
            }
            $list4 = $Model->table('fw_orders a,fw_orderdetail b')->where($map4)->order('a.od_addtime DESC')->select();
            $oddt_totalqty = 0; //虚拟订货总量
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

            // var_dump($dl_id);
            // var_dump($oddt_totalqty);
            //下级代理订货总量(包括有效的和未处理的)
            $map4=array();
            $map4['a.od_unitcode'] =session('unitcode');
            $map4['a.od_state'] = array('in', '0,1,2,3,8');  //完成的订单 
            if ($dl_id>0)
            {
                $map4['a.od_rcdlid'] = $dl_id; //下单代理session('jxuser_id')
                $map4['a.od_id'] = array('exp','=b.oddt_odid');
                $map4['a.od_virtualstock']=1; //0--非虚拟库存订单 1--虚拟库存订单
            }
            if ($probean)
            {
                $map4['b.oddt_proid']=$probean['pro_id'];
                // $map4['b.oddt_attrid']=$probean['sc_attrid'];
            }

            $list4 = $Model->table('fw_orders a,fw_orderdetail b')->where($map4)->order('a.od_addtime DESC')->select();
            
            $virtualshipoddt_totalqty = 0; //下订货总量
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
         

            //实际发货总量(包括有效的和未处理的)
            $map4=array();
            $map4['a.od_unitcode'] =session('unitcode');
            $map4['a.od_state'] = array('in', '0,1,2,3,8');  //完成的订单
            if ($dl_id>0) 
            {
                $map4['a.od_oddlid'] =$dl_id; //下单代理session('jxuser_id')
                $map4['a.od_id'] = array('exp','=b.oddt_odid');
                $map4['a.od_virtualstock']=0; //0--非虚拟库存订单 1--虚拟库存订单
            }
            if ($probean)
            {
                $map4['b.oddt_proid']=$probean['pro_id'];
                // $map4['b.oddt_attrid']=$probean['sc_attrid'];
            }

            $list4 = $Model->table('fw_orders a,fw_orderdetail b')->where($map4)->order('a.od_addtime DESC')->select();
            $shipoddt_totalqty = 0; //实际发货总量
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
            // var_dump($oddt_totalqty);
            // var_dump($virtualshipoddt_totalqty);
            // var_dump($shipoddt_totalqty);
            // exit;
            $surplusqty=$oddt_totalqty-$virtualshipoddt_totalqty-$shipoddt_totalqty;
            if (intval($surplusqty)<0)
            $surplusqty=0;
            return intval($surplusqty);
        }
        public function _empty()
        {
          header('HTTP/1.0 404 Not Found');
          echo'error:404';
          exit;
        }

}