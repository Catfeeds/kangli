<?php
namespace Mp\Controller;
use Think\Controller;
//经销商管理
class TongjiController extends CommController {
    public $option_str;
	//出货统计
    public function index(){
        $this->check_qypurview('30007',1);
		
		$dlid=intval(I('param.dlid',0));
        $begintime=I('param.begintime','');
        $endtime=I('param.endtime','');
		
        $Dealer = M('Dealer');
        $Shipment = M('Shipment');
		$Dltype = M('Dltype');
		
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
		
		//出货方 
		if($dlid<=0){
			$dlid=0;
		    $map['dl_belong']=0;
			$parameter['dlid']=0;
			$dealer_chuhuo='总公司';
		}else{
			$map['dl_belong']=$dlid;
			$parameter['dlid']=$dlid;
			
            $map2=array();
            $map2['dl_unitcode']=session('unitcode');
            $map2['dl_id'] = $dlid;
            $Dealerinfo = $Dealer->where($map2)->find();
            if($Dealerinfo){
                $dealer_chuhuo=$Dealerinfo['dl_name'].'('.$Dealerinfo['dl_username'].')';
            }else{
                $this->error('该经销商不存在','',1);
            }
			
			//经销商分类
            $map2=array();
            $map2['dlt_id']=$Dealerinfo['dl_type'];
            $map2['dlt_unitcode']=session('unitcode');
            $data2 = $Dltype->where($map2)->find();
            if($data2){
                $dealer_chuhuo.='('.$data2['dlt_name'].')';
            }
		}
		
        $map['dl_unitcode']=session('unitcode');
        $count = $Dealer->where($map)->count();
        $Page = new \Think\Page($count, 100,$parameter);
        $show = $Page->show();
        $list = $Dealer->where($map)->order('dl_type ASC,dl_id DESC')->limit(($Page->firstRow . ',') . $Page->listRows)->select();

		foreach($list as $k=>$v){
            //统计出货给收货方数量
            $map2=array();
            $map2['ship_unitcode']=session('unitcode');
            $map2['ship_deliver'] = $dlid;   //ship_deliver -发货方    ship_dealer--收货方
			$map2['ship_dealer'] = $v['dl_id'];
			$map2['ship_date']=array('between',array($begintime,$endtime));
            $count1 = $Shipment->where($map2)->sum('ship_proqty');
			if($count1>0){
			    $list[$k]['count1']=$count1;
			}else{
				$list[$k]['count1']=0;
			}
			
			//统计收货方出货给下级数量
            $map2=array();
            $map2['ship_unitcode']=session('unitcode');
            $map2['ship_deliver'] = $v['dl_id'];
			$map2['ship_date']=array('between',array($begintime,$endtime));
            $count2 = $Shipment->where($map2)->sum('ship_proqty');
			if($count2>0){
			    $list[$k]['count2']=$count2;
			}else{
				$list[$k]['count2']=0;
			}
			
            //经销商分类
            $map2=array();
            $map2['dlt_id']=$v['dl_type'];
            $map2['dlt_unitcode']=session('unitcode');
            $data2 = $Dltype->where($map2)->find();
            if($data2){
                $list[$k]['dl_type_str']='('.$data2['dlt_name'].')';
            }else{
                $list[$k]['dl_type_str']='';
            }
		}
		
        //经销商树
		$dealerinfotree = S('dealerinfotree'.session('unitcode')); //缓存
		if($dealerinfotree==false){
			$map2=array();
			$map2['dl_belong']=0;
			$map2['dl_unitcode']=session('unitcode');
			$list2 = $Dealer->where($map2)->order('dl_type ASC,dl_id DESC')->select();
			foreach($list as $k=>$v){
				//直接下线数
				$map3=array();
				$map3['dl_belong']=$v['dl_id'];
				$map3['dl_unitcode']=session('unitcode');
				$count3 = $Dealer->where($map3)->count();
				$list[$k]['dl_subcount']=$count3;
			}
			//按dl_subcount从大到小排序
			$flag=false;
			for($i=1;$i<count($list2);$i++){
				for($j=0;$j<count($list2)-$i;$j++){
					if($list2[$j]['dl_subcount']<$list2[$j+1]['dl_subcount']){
						$temp=$list2[$j];
						$list2[$j]=$list2[$j+1];
						$list2[$j+1]=$temp;
						$flag=true;
					}
				}
				if(!$flag){
					break;
				}
				$flag=false;
			}
			//递归下级
			foreach($list2 as $k=>$v){
				$this->option_str.='<option value='.$v['dl_id'].' >'.$v['dl_name'].'('.$v['dl_username'].') </option>';
				$this->treesub($v['dl_id']);
			}
			$dealerinfotree=$this->option_str;
			//写入缓存
            S('dealerinfotree'.session('unitcode'),$dealerinfotree,array('type'=>'file','expire'=>3600));
			
		}
		//经销商树end
		
		
		$this->assign('begintime', date('Y-m-d',$begintime));
		$this->assign('endtime', date('Y-m-d',$endtime));
        $this->assign('list', $list);
		$this->assign('dlid', $dlid);
		$this->assign('dealer_chuhuo', $dealer_chuhuo);
		$this->assign('option_str', $dealerinfotree);

        $this->assign('page', $show);

		$this->assign('pagecount', $count);
        $this->assign('curr', 'tongji_list');
        $this->display('list');
    }

    //经销商下级递归
    public function treesub($dlid){
        $this->check_qypurview('30007',1);

        $map=array();
        $map['dl_belong']=intval($dlid);
        $map['dl_unitcode']=session('unitcode');
        $Dealer = M('Dealer');
        $list = $Dealer->where($map)->order('dl_type ASC,dl_id DESC')->select();
        $Dltype = M('Dltype');
		
        foreach($list as $k=>$v){	
            //直接下线数
            $map3=array();
            $map3['dl_belong']=$v['dl_id'];
            $map3['dl_unitcode']=session('unitcode');
            $count3 = $Dealer->where($map3)->count();
            $list[$k]['dl_subcount']=$count3;
        }
		
        foreach($list as $k=>$v){
			if($v['dl_subcount']>0){
				$b='';
				for($i=1;$i<=$v['dl_level'];$i++){
					$b.='　';
				}			
				$this->option_str.='<option value='.$v['dl_id'].' >'.$b.$v['dl_name'].'('.$v['dl_username'].') </option>';
				$this->treesub($v['dl_id']);
			}
        }
    } 

	public function detail(){
		$this->check_qypurview('30007',1);
	
		$fdlid=intval(I('param.fdlid',0));
		$sdlid=intval(I('param.sdlid',0));
        $begintime=I('param.begintime','');
        $endtime=I('param.endtime','');
		
        $Dealer = M('Dealer');
        $Shipment = M('Shipment');
		$Product = M('Product');
		
        if($fdlid<=0){
		    $map['ship_deliver']=0;
			$fdealer['dl_name']='总公司';
		}else{
			$map['ship_deliver']=$fdlid;

            $map2=array();
            $map2['dl_unitcode']=session('unitcode');
            $map2['dl_id'] = $fdlid;
            $fdealer = $Dealer->where($map2)->find();
            if($fdealer){
            }else{
                $this->error('出货方不存在','',1);
            }
		}
		
		if($sdlid<=0){
		    $this->error('收货方不存在','',1);
		}else{
			$map['ship_dealer']=$sdlid;

            $map2=array();
            $map2['dl_unitcode']=session('unitcode');
            $map2['dl_id'] = $sdlid;
            $sdealer = $Dealer->where($map2)->find();
            if($sdealer){
				
            }else{
                $this->error('收货方不存在','',1);
            }
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
		}else{
            $begintime=strtotime(date('Y-m-d',time()));
            $endtime=strtotime(date('Y-m-d',time()))+3600*24-1;
		}
		
		$map['ship_unitcode']=session('unitcode');
		$map['ship_date']=array('between',array($begintime,$endtime));
		
		$list = $Shipment->where($map)->field('ship_pro,SUM(ship_proqty) as sumqty')->group('ship_pro')->select();	
		
		foreach($list as $k=>$v){
            $map2=array();
            $map2['pro_unitcode']=session('unitcode');
            $map2['pro_id'] = $v['ship_pro'];
            $Proinfo = $Product->where($map2)->find();

            if($Proinfo){
                  $list[$k]['pro_name']=$Proinfo['pro_name'];
                  $list[$k]['pro_number']=$Proinfo['pro_number'];
            }else{
                  $list[$k]['pro_name']='';
                  $list[$k]['pro_number']='';
            }
		}
		
		$this->assign('begintime', date('Y-m-d',$begintime));
		$this->assign('endtime', date('Y-m-d',$endtime));
		$this->assign('list', $list);
		$this->assign('fdealer', $fdealer);
		$this->assign('sdealer', $sdealer);
        $this->assign('curr', 'tongji_list');
        $this->display('detail');
	}

	public function daifa(){
		$this->check_qypurview('30007',1);
		
		$dlid=intval(I('param.dlid',0));
        $begintime=I('param.begintime','');
        $endtime=I('param.endtime','');
		
        $Dealer = M('Dealer');
        $Shipment = M('Shipment');
		$Product = M('Product');
		$dealer_chuhuo='总公司';
		$subdlids='';
		$dlid_ids='';
		
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
		
        if($dlid<=0){
		    $this->error('收货方不存在','',1);
		}else{
            $map2=array();
            $map2['dl_unitcode']=session('unitcode');
            $map2['dl_id'] = $dlid;
            $sdealer = $Dealer->where($map2)->find();
            if($sdealer){
				
            }else{
                $this->error('收货方不存在','',1);
            }
		}

        //3级内下线经销商ID
		if($sdealer['dl_belong']>0){
			$subdlids=$dlid;
		}
			
		$map3=array();
		$map3['dl_belong']=$dlid;
		$map3['dl_unitcode']=session('unitcode');
		$dllist3 = $Dealer->where($map3)->select();
		
		foreach($dllist3 as $kk=>$vv){
			if($subdlids==''){
				$subdlids=$vv['dl_id'];
			}else{
				$subdlids=$subdlids.','.$vv['dl_id'];
			}
			$map4=array();
			$map4['dl_belong']=$vv['dl_id'];
			$map4['dl_unitcode']=session('unitcode');
			$dllist4 = $Dealer->where($map4)->select();
			foreach($dllist4 as $kkk=>$vvv){
				$subdlids=$subdlids.','.$vvv['dl_id'];	
			}
		}

		if($subdlids!=''){
			$map3=array();
			$map3['ship_unitcode']=session('unitcode');
			$map3['ship_deliver'] =0;   //ship_deliver -发货方    ship_dealer--收货方
			$map3['ship_dealer'] = array('in',strval($subdlids));
			$map3['ship_date']=array('between',array($begintime,$endtime));
			$list3 = $Shipment->field('ship_dealer')->where($map3)->group('ship_dealer')->select();
			
			foreach($list3 as $kk=>$vv){
				if($kk==0){
					$dlid_ids=$vv['ship_dealer'];
				}else{
					$dlid_ids=$dlid_ids.','.$vv['ship_dealer'];
				}
			}
		}
		$list4=array();
		if($dlid_ids!=''){
            $map4=array();
			$map4['dl_belong']=array('GT',0);
			$map4['dl_unitcode']=session('unitcode');
			$map4['dl_id']=array('in',strval($dlid_ids));
			$list4 = $Dealer->where($map4)->order('dl_level ASC,dl_id DESC')->select();
			foreach($list4 as $kk=>$vv){	
			    //出货对应产品及数量
				$map=array();
				$map['ship_unitcode']=session('unitcode');
				$map['ship_deliver'] = 0;
				$map['ship_dealer'] = $vv['dl_id'];
				$map['ship_date']=array('between',array($begintime,$endtime));
				$list = $Shipment->where($map)->field('ship_pro,SUM(ship_proqty) as sumqty')->group('ship_pro')->select();	
				foreach($list as $k=>$v){
					$map2=array();
					$map2['pro_unitcode']=session('unitcode');
					$map2['pro_id'] = $v['ship_pro'];
					$Proinfo = $Product->where($map2)->find();

					if($Proinfo){
						  $list[$k]['pro_name']=$Proinfo['pro_name'];
						  $list[$k]['pro_number']=$Proinfo['pro_number'];
					}else{
						  $list[$k]['pro_name']='';
						  $list[$k]['pro_number']='';
					}
				}
				$list4[$kk]['pro']=$list;
			}
		}
		
		$this->assign('begintime', date('Y-m-d',$begintime));
		$this->assign('endtime', date('Y-m-d',$endtime));
		$this->assign('list', $list4);
		$this->assign('dealerinfo', $sdealer);
		$this->assign('dealer_chuhuo', $dealer_chuhuo);
		$this->assign('dlid', $dlid);
        $this->assign('curr', 'tongji_list');
        $this->display('daifa');
	}
}