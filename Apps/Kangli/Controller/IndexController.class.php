<?php
namespace Kangli\Controller;
use Think\Controller;
class IndexController extends CommController {
    //首页
    public function index(){
		//公告
		$map=array();
        $map['news_isgg']=1;
        $map['news_unitcode']=$this->qy_unitcode;
        $Jfmonews= M('Jfmonews');
        $gonggao=$Jfmonews->where($map)->field('news_id,news_title')->order('news_addtime DESC')->select();

        if($gonggao){
              
        }else{
			$gonggao[0]['news_title']='新闻公告';
			$gonggao[0]['news_id']='0';
		}
//        dump($gonggao);die();
		
		// //logo 和 底部图片
		// $map=array();
		// $Jfmobasic= M('Jfmobasic');
		// $map['bas_unitcode']=$this->qy_unitcode;
  //       $data=$Jfmobasic->where($map)->find();
  //       if($data){
		// 	$imgpath = BASE_PATH.'/Public/uploads/mobi/';
		// 	if(file_exists($imgpath.$data['bas_logopic'])){
		// 		$bas_logopic='<img src="'.__ROOT__.'/public/uploads/mobi/'.$data['bas_logopic'].'">';
		// 	}else{
		// 		if(strpos($data['bas_logopic'], 'logo')===false && strpos($data['bas_logopic'], '.')===false ){
		// 			$bas_logopic=$data['bas_logopic'];
		// 		}else{
		// 			$bas_logopic='';
		// 		}
		// 	}
			
		// 	if(file_exists($imgpath.$data['bas_footpic'])){
		// 		$bas_footpic='<img src="'.__ROOT__.'/public/uploads/mobi/'.$data['bas_footpic'].'" style="width:100%" >';
		// 	}else{

		// 		$bas_footpic='';
		// 	}
			
		// 	$bas_content=$data['bas_website'];
			
  //       }else{
  //           $bas_footpic='';
		// 	$bas_logopic='';
		// 	$bas_content='';
  //       }
		
		//海报
		$map=array();
		$map['ad_unitcode']=$this->qy_unitcode;//企业编号
        $Adinfo= M('Adinfo');
		$adlist = $Adinfo->where($map)->order('ad_addtime DESC')->limit(5)->select();
// dump($adlist);die();
 		$wvsh='100%';//滚图宽高比
		if($adlist){
			$imgpath = BASE_PATH.'/Public/uploads/mobi/';
//			echo BASE_PATH;die();
            if(is_not_null($adlist[0]['ad_pic']) && file_exists($imgpath.$adlist[0]['ad_pic'])){
                $arr=getimagesize($imgpath.$adlist[0]['ad_pic']);
                if(false!=$arr){
                    $w=$arr[0];
                    $h=$arr[1];
                    $wvsh=(($h/$w)*100).'%';
                }
            }
        }
        //买家秀	
		$mapmjx=array();
        $mapmjx['news_type']=2;
        $mapmjx['news_unitcode']=$this->qy_unitcode;
		$datamjx=$Jfmonews->where($mapmjx)->order('news_addtime DESC')->limit(2)->select();
		$imgpath = BASE_PATH.'/Public/uploads/mobi/';
//		dump($datamjx);die();
		if ($datamjx)
		{
			$index=0;
			foreach ($datamjx as $k => $v) {
				$datamjx[$k]['news_index']=$index;
				$index++;
				if(is_not_null($v['news_pic']) && file_exists($imgpath.$v['news_pic'])){
					$datamjx[$k]['news_pic_str']=__ROOT__.'/Public/uploads/mobi/'.$v['news_pic'];
				}else{
					$datamjx[$k]['news_pic_str']='';
				}
			}
		}
		//代理类型统计
		$Dealer=M('Dealer');
		$Dltype=M('Dltype');
		$map3=array();
		$map3['dlt_unitcode']=$this->qy_unitcode;
		$map3['dlt_status']=1;
		$dlt_list= $Dltype->where($map3)->field('dlt_name,dlt_level')->group('dlt_name,dlt_level')->order('dlt_level ASC')->select();
//		dump($dlt_list);die();
		$dlalllist=array();
		$dlallcount=0;
		foreach ($dlt_list as $k => $v) {
			if (session('jxuser_id')>0)//登陆后的操作
			{
				$mapdl=array();
				$datadl=array();
				$mapdl['dl_id']=session('jxuser_id');
				$mapdl['dl_unitcode']=$this->qy_unitcode;
				$datadl=$Dealer->where($mapdl)->find();
				if($datadl){
					//我的团队
					$this->dllower_arrs=array();
					$this->dllower_arrs[]=array('id'=>$datadl['dl_id'],'name'=>$datadl['dl_name'],'level'=>$datadl['dl_level'],'typeid'=>$datadl['dl_type']);  //当前团队的第一个上级
					//下级与其下级代理
					$this->get_dllowerarray(session('jxuser_id'));//递归返回下级所有代理数组 $dlid--代理id
//                    dump();die();
                    $dllowerarray=$this->dllower_arrs; //团队所有代理的数组，在get_dllowerarray()中不断向$this->dllower_arrs[]压入代理及代理下级数据
//                    dump($dllowerarray);die();
					$dltcount=0;
					foreach ($dllowerarray as $kk => $vv) {
						if ($vv['level']==$v['dlt_level'])//层级相同的放在一起，例如总代的为2，这个团队共2个总代
						{
							$dltcount++;
						}
					}
					$dlalllist[$k]['value']=$dltcount;
                    $dlalllist[$k]['name']=$v['dlt_name'];
//                    dump($dlalllist);die();
					$dlallcount+=$dltcount;
				}else//无团队
				{
					$dlallcount=0;
					$dlalllist[$k]['value']=0;
					$dlalllist[$k]['name']=$v['dlt_name'];
				}
			}else//未登录
			{
				$dlallcount=0;
				$dlalllist[$k]['value']=0;
				$dlalllist[$k]['name']=$v['dlt_name'];
			}
			// $map3=array();
			// $map3['dl_unitcode']=$this->qy_unitcode;
			// $map3['dl_level']=$v['dlt_level'];
			// $map3['dl_referee']=session('jxuser_id');
			// $dltcount=$Dealer->where($map3)->count('dl_level');
			// if ($dltcount)
			// {
			// 	$dlallcount+=$dltcount;
			// 	$dlalllist[$k]['value']=$dltcount;
			// 	$dlalllist[$k]['name']=$v['dlt_name'];
			// }else
			// {
			// 	$dltcount=0;
			// 	$dlalllist[$k]['value']=0;
			// 	$dlalllist[$k]['name']=$v['dlt_name'];
			// }
		}
//        dump($dlallcount);die();
//        dump( $dlalllist);die();
		// var_dump($dlallcount);
		// exit;
		//下级代理新的订单
		$Orders = M('Orders');
		$Product = M('Product');
		$Orderdetail = M('Orderdetail');
		$Shipment = M('Shipment');
		$mapdl=array();
		$mapdl['od_unitcode']=$this->qy_unitcode;
		$mapdl['od_rcdlid']=session('jxuser_id');
		$mapdl['od_virtualstock']=1;
		$mapdl['od_state']=0;
		$list =$Orders->where($mapdl)->field('od_id,od_state,od_orderid,od_total,od_addtime')->order('od_addtime DESC')->select();

		$imgpath = BASE_PATH.'/Public/uploads/product/';
		foreach($list as $k=>$v){
			//订单详细
			$odtotalqty=0; //订单总数量
			$list[$k]['od_shipall']=0; //是否已全出货
			$map2=array();
			$data2=array();
			$map2['oddt_unitcode']=$this->qy_unitcode;
			$map2['oddt_odid']=$v['od_id'];
			$data2 = $Orderdetail->where($map2)->order('oddt_id DESC')->limit(100)->select();
			foreach($data2 as $kk=>$vv){
				//产品
				$map3=array();
				$data3=array();
				$map3['pro_id']=$vv['oddt_proid'];
				$map3['pro_unitcode']=$this->qy_unitcode;
				$data3=$Product->where($map3)->field('pro_id,pro_pic')->find();
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
				
				$odtotalqty+=$oddt_totalqty; 

				if($oddt_totalqty==0 || $oddt_totalqty==$vv['oddt_qty']){
					$data2[$kk]['oddt_totalqty']='';
				}else{
					$data2[$kk]['oddt_totalqty']='('.$oddt_totalqty.'件)';
				}
				//已发数量
				$map3=array();
				$data3=array();
				$map3['ship_pro']=$vv['oddt_proid'];
				$map3['ship_unitcode']=$this->qy_unitcode;
				$map3['ship_odid']=$vv['oddt_odid'];
				$map3['ship_deliver']=session('jxuser_id'); //发货方
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
				//已全部出货
				if (intval($data2[$kk]['oddt_shipqty'])>=intval($oddt_totalqty))
				{
					$list[$k]['od_shipall']=1;
				}
			}
			$list[$k]['odtotalqty']=$odtotalqty;
			$list[$k]['odoneself']=1;
			$list[$k]['orderdetail']=$data2;
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
		}

		//未审核经销商
		$map3=array();
		$map3['dl_unitcode']=$this->qy_unitcode;
		$map3['dl_belong']=session('jxuser_id');
		$map3['dl_status']=0;
		$dl_list= $Dealer->where($map3)->field('dl_id,dl_name,dl_weixin,dl_wxheadimg,dl_tel,dl_address,dl_addtime,dl_level')->order('dl_id DESC')->select();
		foreach($dl_list as $kk=>$vv){
			$map['dlt_level']=$vv['dl_level'];
			$data2 = $Dltype->where($map)->order('dlt_level ASC,dlt_id ASC')->find();
			if ($data2)
			{
				$dl_list[$kk]['dlt_name']=$data2['dlt_name'];
			}
		}
		// session('access_token',null);
		// $oauth=true;
		//session是否过期
		$oauth=false;
		if(session('access_token')!='')
		{
			$oauth=true;
		}
		if(C('IS_ONLYWEIXIN')==0){
		   $oauth=true;
		}
        $this->assign('wvsh', $wvsh);
        $this->assign('bas_content', $bas_content);
        $this->assign('adlist', $adlist);
	    $this->assign('bas_logopic', $bas_logopic);
		$this->assign('bas_footpic', $bas_footpic);
	    $this->assign('gonggao', $gonggao);
	    $this->assign('datamjx', $datamjx);
	    $this->assign('prolist', $list);
	    $this->assign('dllist', $dl_list);
	    $this->assign('dlalllist', $dlalllist);
	    $this->assign('dlallcount', $dlallcount);//当前经销商的下级代理总数（包括自己）
	    $this->assign('oauth', $oauth);
        $this->display('index');
    }
}