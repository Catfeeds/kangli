<?php
namespace Kangli\Controller;
use Think\Controller;
class QingchuController extends CommController {
    //清理数据
    public function index(){

		exit;
		
		$qycdoe='2981';
		$dlid='11';
		$imgpath = BASE_PATH.'/public/uploads/dealer/';
		$imgpath2 = BASE_PATH.'/public/uploads/orders/';
		$imgpath3 = BASE_PATH.'/public/uploads/product/';
		
		if($qycdoe!='2981'){
			echo 'err1';
			exit;
		}
		// echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
		// //清除代理信息
		// $map=array();
  //       $map['dl_unitcode']=$qycdoe;
  //       $Dealer= M('Dealer');
  //       $list=$Dealer->where($map)->select();
  //       foreach($list as $kk=>$vv){
		// 	@unlink($imgpath.$vv['dl_idcardpic']); 
		// 	@unlink($imgpath.$vv['dl_idcardpic2']); 
		// 	@unlink($imgpath.$vv['dl_pic']); 
            
		// 	$map2=array();
		// 	$map2['dl_unitcode']=$qycdoe;
		// 	$map2['dl_id']=$vv['dl_id'];
		// 	$Dealer->where($map2)->delete(); 
		// }
		// echo '删除代理信息--ok<br>';
		
		// //清除代理商日志
		// $map=array();
  //       $map['dlg_unitcode']=$qycdoe;
  //       $Dealerlogs= M('Dealerlogs');
  //       $Dealerlogs->where($map)->delete(); 
		// echo '清除代理商日志--ok<br>';
		
		// //清除代理商地址
		// $map=array();
  //       $map['dladd_unitcode']=$qycdoe;
  //       $Dladdress= M('Dladdress');
  //       $Dladdress->where($map)->delete(); 
		// echo '清除代理商地址--ok<br>';
		
		// //清除代理商调级信息
		// $map=array();
  //       $map['apply_unitcode']=$qycdoe;
  //       $Applydltype= M('Applydltype');
		// $list=$Dealer->where($map)->select();
		// foreach($list as $kk=>$vv){
		// 	@unlink('./Public/uploads/dealer/'.$vv['apply_pic']); 
		// }
  //       $Applydltype->where($map)->delete(); 
		// echo '清除代理商调级信息--ok<br>';
		
		//出货记录
		$map=array();
        $map['ship_unitcode']=$qycdoe;
        $map['ship_dealer']=$dlid;
        $Shipment= M('Shipment');
        $Shipment->where($map)->delete(); 
	    echo '清除代理id'.$dlid.'出货记录--ok<br>';
		
		// //拆箱记录
		// $map=array();
  //       $map['chai_unitcode']=$qycdoe;
  //       $Chaibox= M('Chaibox');
  //       $Chaibox->where($map)->delete(); 
		// echo '清除拆箱记录--ok<br>';
		
		//清除订单信息
		$map=array();
        $map['od_unitcode']=$qycdoe;
        $map['od_oddlid']=$dlid;
        $Orders= M('Orders');
		$Orderdetail= M('Orderdetail');
        $dataOR=$Orders->where($map)->select();
        if (is_not_null($dataOR))
        {
        	foreach ($dataOR as $k => $v) {
        		//清除订单详细
				$mapdt=array();
			  	$mapdt['oddt_unitcode']=$qycdoe;
			  	$mapdt['oddt_odid']=$v['od_id'];
			  	$Orderdetail= M('Orderdetail');
				$Orderdetail->where($mapdt)->delete();
				echo '清除代理id'.$dlid.'--'.$v['od_orderid'].'订单详细--ok<br>';
        	}
        	$Orders->where($map)->delete();
			echo '清除代理id'.$dlid.'订单信息--ok<br>';
        }

		
		//清除订单日志
		$map=array();
        $map['odlg_unitcode']=$qycdoe;
        $map['odlg_dlid']=$dlid;
        $Orderlogs= M('Orderlogs');
		$Orderlogs->where($map)->delete();
		echo '清除代理id'.$dlid.'订单日志--ok<br>';
		
		// //清除订单详细
		// $map=array();
  //       $map['oddt_unitcode']=$qycdoe;
  //       $Orderdetail= M('Orderdetail');
		// $Orderdetail->where($map)->delete();
		// echo '清除订单详细--ok<br>';
		
		//清除订单关系
		$map=array();
        $map['odbl_unitcode']=$qycdoe;
        $map['odbl_oddlid']=$dlid;
        $Orderbelong= M('Orderbelong');
		$list=$Orderbelong->where($map)->select();
		foreach($list as $kk=>$vv){
			@unlink('./Public/uploads/orders/'.$vv['odbl_paypic']); 
		}
		$Orderbelong->where($map)->delete();
		echo '清除代理id'.$dlid.'订单关系--ok<br>';
		
		
		//清除返利
		$map=array();
        $map['fl_unitcode']=$qycdoe;
        $map['fl_oddlid']=$dlid;
        $Fanlidetail= M('Fanlidetail');
		$Fanlidetail->where($map)->delete();
		echo '清除代理id'.$dlid.'返利--ok<br>';
		
		//清除积分
		$map=array();
        $map['dljf_unitcode']=$qycdoe;
        $map['dljf_dlid']=$dlid;
        $Dljfdetail= M('Dljfdetail');
		$Dljfdetail->where($map)->delete();
		echo '清除代理id'.$dlid.'积分--ok<br>';
		
		// //清除兑换
		// $map=array();
  //       $map['exch_unitcode']=$qycdoe;
  //       $map['exch_dlid']=$dlid;
  //       $Dljfexchange= M('Dljfexchange');
		// $Dljfexchange->where($map)->delete();
		// echo '清除代理id'.$dlid.'兑换--ok<br>';
		
		// //清除兑换详细
		// $map=array();
  //       $map['detail_unitcode']=$qycdoe;
  //       $Dljfexchdetail= M('Dljfexchdetail');
		// $Dljfexchdetail->where($map)->delete();
		// echo '清除兑换详细--ok<br>';
		
		// //清除提现记录
		// $map=array();
  //       $map['rc_unitcode']=$qycdoe;
  //       $Recash= M('Recash');
		// $list=$Recash->where($map)->select();
		// foreach($list as $kk=>$vv){
		// 	@unlink('./Public/uploads/orders/'.$vv['rc_pic']); 
		// }
		// $Recash->where($map)->delete();
		// echo '清除提现记录--ok<br>';
    }
}