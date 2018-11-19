<?php
namespace Zxapi\Controller;
use Think\Controller;
class ShiplistController extends CommController {

	//获取出货记录
	public function index(){
        $maxid=intval(I('post.maxid',0));
		$minid=intval(I('post.minid',0));
		
		$Shipment= M('Shipment');
        $map=array();
        $parameter=array();
        $map['ship_unitcode']=$this->qycode;
		$map['ship_deliver']=0;   //ship_deliver--出货方   ship_dealer--收货方
		if($maxid==0 && $minid==0){
			
		}else if($maxid>0){
			$map['ship_id']=array('GT',$maxid);
		}else if($minid>0){
			$map['ship_id']=array('LT',$minid);
		}

        $list = $Shipment->where($map)->order('ship_id DESC')->limit(20)->select();
		$Dealer = M('Dealer');
		$Product = M('Product');
		$newlist=array();
		foreach($list as $k=>$v){ 
			$newlist[$k]['ship_id']=$v['ship_id'];
		    $newlist[$k]['ship_barcode']=$v['ship_barcode'];
			$newlist[$k]['ship_date']=date('Y-m-d',$v['ship_date']);
			$newlist[$k]['ship_number']=$v['ship_number'];
		
            $map2=array();
            $map2['dl_unitcode']=$this->qycode;
            $map2['dl_id'] = $v['ship_dealer'];
            $Dealerinfo = $Dealer->where($map2)->find();
            if($Dealerinfo){
                  $newlist[$k]['dl_name']=$Dealerinfo['dl_name'];
            }else{
                  $newlist[$k]['dl_name']='';
            }
			
            $map2=array();
            $map2['pro_unitcode']=$this->qycode;
            $map2['pro_id'] = $v['ship_pro'];
            $Proinfo = $Product->where($map2)->find();

            if($Proinfo){
                $newlist[$k]['pro_name']=$Proinfo['pro_name'];
            }else{
                $newlist[$k]['pro_name']='';
            }	
		}
		
		if($maxid==0 && $minid==0 && count($newlist)>0){
			reset($newlist);
			$maxid = current($newlist)['ship_id'];
			$minid = end($newlist)['ship_id'];
		}else if($maxid>0){
			if(count($newlist)>0){
				reset($newlist);
				$maxid = current($newlist)['ship_id'];
				$minid=0;
			}else{
				$maxid=0;
				$minid=0;
			}
		}else if($minid>0){
			if(count($newlist)>0){
				reset($newlist);
				$maxid=0;
				$minid = end($newlist)['ship_id'];
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
	//获取出货详细
	public function detail(){
        $shid=intval(I('post.shid',0));
		
        if($shid<=0){
			$msg=array('login'=>'1','stat'=>'0','msg'=>'没有该记录或已删除');
			echo json_encode($msg);
			exit;
		}
		$Dealer = M('Dealer');
		$Warehouse= M('Warehouse');
		$Product = M('Product');
		$Shipment= M('Shipment');
		$map=array();
		$map['ship_unitcode']=$this->qycode;
		$map['ship_id']=$shid;
		$data=$Shipment->where($map)->find();
		if($data){
            $map2=array();
            $map2['dl_unitcode']=$this->qycode;
            $map2['dl_id'] = $data['ship_dealer'];
            $Dealerinfo = $Dealer->where($map2)->find();
            if($Dealerinfo){
                  $data['dl_name']=$Dealerinfo['dl_name'];
            }else{
                  $data['dl_name']='';
            }
			
            $map2=array();
            $map2['pro_unitcode']=$this->qycode;
            $map2['pro_id'] = $data['ship_pro'];
            $Proinfo = $Product->where($map2)->find();

            if($Proinfo){
                $data['pro_name']=$Proinfo['pro_name'];
            }else{
                $data['pro_name']='';
            }
			
			$map2=array();
            $map2['wh_unitcode']=$this->qycode;
            $map2['wh_id'] = $data['ship_whid'];
            $Warehouseinfo = $Warehouse->where($map2)->find();
            if($Warehouseinfo){
                  $data['wh_name']=$Warehouseinfo['wh_name'];
            }else{
                  $data['wh_name']='';
            }

            $data['ship_date']=date('Y-m-d',$data['ship_date']);			
			
			$msg=array('login'=>'1','stat'=>'1','list'=>$data);
			echo json_encode($msg);
			exit;
		}else{
			$msg=array('login'=>'1','stat'=>'0','msg'=>'没有该记录或已删除');
			echo json_encode($msg);
			exit;
		}
	}
	
	//出货查询
	public function shipsearch(){
		
		$brcode=I('post.brcode','');

		if($brcode!=''){
			if(!preg_match("/^[a-zA-Z0-9]{4,30}$/",$brcode)){
				$msg=array('login'=>'1','stat'=>'0','msg'=>'条码信息不正确');
				echo json_encode($msg);
				exit;
			}
			//检测是否已发行
			$barcode=wlcode_to_packinfo($brcode,$this->qycode);
			if(!is_not_null($barcode)){
				$msg=array('login'=>'1','stat'=>'0','msg'=>'条码 '.$brcode.' 不存在或还没发行');
				echo json_encode($msg);
				exit;
			}
			
			//查询条码相关信息
			$Shipment= M('Shipment');
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
			$map['ship_barcode'] = $where;
			$map['ship_unitcode']=$this->qycode;
			$map['ship_deliver']=0;   //ship_deliver--出货方   ship_dealer--收货方
			$data=$Shipment->where($map)->find();
			
			if($data){
				$Dealer= M('Dealer');
				$Product = M('Product');
				$Warehouse = M('Warehouse');

				//对应发给的经销商
				$map2=array();
				$map2['dl_id']=$data['ship_dealer'];
				$map2['dl_unitcode']=$this->qycode;
				$data2=$Dealer->where($map2)->find();
				if($data2){
					$data['dl_name']=$data2['dl_name'];
				}else{
					$data['dl_name']='';
				}
				//对应的产品
				$map2=array();
				$map2['pro_unitcode']=$this->qycode;
				$map2['pro_id'] = $data['ship_pro'];
				$Proinfo = $Product->where($map2)->find();
				if($Proinfo){
					$data['pro_name']=$Proinfo['pro_name'];
				}else{
					$data['pro_name']='';
				}
				
				//仓库
				$map2=array();
				$map2['wh_unitcode']=$this->qycode;
				$map2['wh_id'] = $data['ship_whid'];
				$warehouse = $Warehouse->where($map2)->find();

				if($warehouse){
					$data['wh_name']=$warehouse['wh_name'];
				}else{
					$data['wh_name']='';
				}
				
				$data['ship_date']=date('Y-m-d',$data['ship_date']);
				
				$data['ucode']=$barcode['ucode'];
				$data['tcode']=$barcode['tcode'];
				$data['qty']=$barcode['qty'];
				$data['brcode']=$brcode;
				
			}else{
				//检测是否拆箱
				$map2=array();
				$Chaibox= M('Chaibox');
				$map2['chai_unitcode']=$this->qycode;
				$map2['chai_barcode'] = $brcode;
				$map2['chai_deliver'] = 0;
				$data2=$Chaibox->where($map2)->find();

				if($data2){
					$msg=array('login'=>'1','stat'=>'0','msg'=>'条码 '.$brcode.' 已经拆箱录入');
					echo json_encode($msg);
					exit;
				}
				
				$msg=array('login'=>'1','stat'=>'0','msg'=>'条码 '.$brcode.' 不存在或还没发行');
				echo json_encode($msg);
				exit;
			}
			
			
			
			$msg=array('login'=>'1','stat'=>'1','list'=>$data);
			echo json_encode($msg);
			exit;
        }else{
			$msg=array('login'=>'1','stat'=>'0','msg'=>'请输入或扫入条码');
			echo json_encode($msg);
			exit;
		}
	}

	
}