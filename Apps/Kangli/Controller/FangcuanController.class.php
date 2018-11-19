<?php
namespace Kangli\Controller;
use Think\Controller;
class FangcuanController extends CommController {
    //防窜查询
    public function index(){
		// $user_agent=strtolower(I('server.HTTP_USER_AGENT'));
		// if (strpos($user_agent, 'micromessenger') === false){
		// 	$this->error('请在微信客户端打开链接','',-1);
		// 	exit;
		// }
		
        //防止频繁刷新 1000毫秒
        if(requ_security(1,500,'','','')){
            $this->error('页面已过期，请刷新页面重新查询',U('./'),3);
        }
		
        if (IS_POST) {
			$pwd=trim(I('post.pwd',''));
			$checkcode=trim(I('post.checkcode',''));
			if($pwd=='' || $checkcode==''){
			     $this->error('请输入密码和验证码',U('./'),2);
			}
			$verify = new \Think\Verify();
			if(!($verify->check($checkcode))){
				$this->error('验证码错误',U('./'),2);
			}
            $md5_pwd=MD5(MD5($pwd));
			
			$map['qy_code']=$this->qy_unitcode;
			$map['qy_active']=1;
			$Qyinfo = M('Qyinfo');
			$data=$Qyinfo->where($map)->find();
			if($data){
				$qy_fchpwd=$data['qy_fchpwd'];
			}else{
				$this->error('没有该记录');
			}
			
			if($md5_pwd==$qy_fchpwd){ 
			    $fchuser_time=time();
				$fchuser_check=MD5(MD5($this->qy_unitcode.$fchuser_time));
				session('fchuser_time',$fchuser_time);
				cookie('fchuser_check',$fchuser_check,36000);
			}else{
				$this->error('密码错误',U('./'),2);
			}
			
			$this->display('index');
			exit;
		}

		if($this->is_fchuser_login()){
			$Jssdk = new \Org\Util\Jssdk(C('QY_ZXWXAPPID'), C('QY_ZXWXAPPSECRET'),'zxfw');
			$signPackage = $Jssdk->GetSignPackage();

			$this->assign('signPackage', $signPackage);
			
			$this->display('index');
		}else{
			session('fchuser_time',null);
			cookie('fchuser_check',null);
			$this->display('login');
		}
    }

    //验证码
    public function verify(){
        $config = array(
                        'fontSize' =>22, // 验证码字体大小    
                        'length' => 4, // 验证码位数 
                        'useNoise' => true, // 关闭验证码杂点
                        'useImgBg' => false, //是否使用背景图片
                        'imageW' => 170,
                        'imageH' => 45,
                        'useNoise' => true,
                       );
        $verify = new \Think\Verify($config);
        $verify->entry();
        exit;
    }
	
	//判断登录
	public function is_fchuser_login(){
		$fchuser_check=cookie('fchuser_check');
		$fchuser_time=session('fchuser_time');
			
		if($fchuser_check=='' || $fchuser_time==''){
			return false;
		}else{
			if($fchuser_check==MD5(MD5($this->qy_unitcode.$fchuser_time))){
				return true;
			}else{
				return false;
			}
		}
	}
	
	//防窜查询结果
    public function fangcuanres(){
		// $user_agent=strtolower(I('server.HTTP_USER_AGENT'));
		// if (strpos($user_agent, 'micromessenger') === false){
		// 	$this->error('请在微信客户端打开链接','',-1);
		// 	exit;
		// }
		
        if(!$this->is_fchuser_login()){
			$this->error('请登录查询',U('Kangli/Fangcuan/login'),2);
		}
		
		$brcode=I('param.brcode','');
		$barr=explode(',',$brcode);
		$brcode=end($barr);
		
		if ($brcode!='') {
			if(!preg_match("/^[a-zA-Z0-9]{4,30}$/",$brcode)){
				$this->error('条码不正确','',2);
			}

			 //检测是否已发行
			$barcode=wlcode_to_packinfo($brcode,$this->qy_unitcode);
			
			if(!is_not_null($barcode)){
				$this->error('该条码不存在或还没发行','',2);
			}

			//条码出货流向
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
			$map['ship_unitcode']=$this->qy_unitcode;
			$map['ship_deliver']=0;   //ship_deliver--出货方   ship_dealer--收货方
			$data=$Shipment->where($map)->find();
			if(is_not_null($data)){
				$Product = M('Product');
				$Dealer = M('Dealer');
				$Warehouse = M('Warehouse');

				$map2=array();
				$map2['pro_unitcode']=$this->qy_unitcode;
				$map2['pro_id'] = $data['ship_pro'];
				$Proinfo = $Product->where($map2)->find();

				if($Proinfo){
					  $data['pro_name']=$Proinfo['pro_name'];
					  $data['pro_number']=$Proinfo['pro_number'];
					  $data['pro_desc']=$Proinfo['pro_desc'];
					  $data['pro_pic']=$Proinfo['pro_pic'];
				}else{
					  $data['pro_name']='';
					  $data['pro_number']='';
					  $data['pro_desc']='';
					  $data['pro_pic']='';
				}
				
				//仓库
				$map2=array();
				$map2['wh_unitcode']=$this->qy_unitcode;
				$map2['wh_id'] = $data['ship_whid'];
				$warehouseinfo = $Warehouse->where($map2)->find();

				if($warehouseinfo){
					$data['warehouse']=$warehouseinfo['wh_name'];
				}else{
					$data['warehouse']='';
				}
				
				$map2=array();
				$map2['dl_unitcode']=$this->qy_unitcode;
				$map2['dl_id'] = $data['ship_dealer'];
				$Dealerinfo = $Dealer->where($map2)->find();
				if($Dealerinfo){
					$data['dl_name']= wxuserTextDecode2($Dealerinfo['dl_name']);

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
				$map2['ship_unitcode']=$this->qy_unitcode;
				$map2['ship_deliver']=$data['ship_dealer'];   //ship_deliver--出货方   ship_dealer--收货方
				$data2=$Shipment->where($map2)->find();
				if(is_not_null($data2)){
					$map22=array();
					$map22['dl_unitcode']=$this->qy_unitcode;
					$map22['dl_id'] = $data2['ship_dealer'];
					$Dealerinfo = $Dealer->where($map22)->find();
					if($Dealerinfo){

						$data2['dl_name']= wxuserTextDecode2($Dealerinfo['dl_name']);
					
					}else{
						$data2['dl_name']='';
					}
					$data['sub']=$data2;
				
					//下级-2
					$map3=array();
					$map3['ship_barcode'] = $where;
					$map3['ship_unitcode']=$this->qy_unitcode;
					$map3['ship_deliver']=$data2['ship_dealer'];   //ship_deliver--出货方   ship_dealer--收货方
					$data3=$Shipment->where($map3)->find();
					if(is_not_null($data3)){
						$map22=array();
						$map22['dl_unitcode']=$this->qy_unitcode;
						$map22['dl_id'] = $data3['ship_dealer'];
						$Dealerinfo = $Dealer->where($map22)->find();
						if($Dealerinfo){						  

							$data3['dl_name']= wxuserTextDecode2($Dealerinfo['dl_name']);

						}else{
							  $data3['dl_name']='';
						}
						$data['sub']['sub']=$data3;
						
							//下级-3
							$map4=array();
							$map4['ship_barcode'] = $where;
							$map4['ship_unitcode']=$this->qy_unitcode;
							$map4['ship_deliver']=$data3['ship_dealer'];   //ship_deliver--出货方   ship_dealer--收货方
							$data4=$Shipment->where($map4)->find();
							if(is_not_null($data4)){
								$map22=array();
								$map22['dl_unitcode']=$this->qy_unitcode;
								$map22['dl_id'] = $data4['ship_dealer'];
								$Dealerinfo = $Dealer->where($map22)->find();
								if($Dealerinfo){

									$data4['dl_name']= wxuserTextDecode2($Dealerinfo['dl_name']);

								}else{
									$data4['dl_name']='';
								}
								$data['sub']['sub']['sub']=$data4;
								
									//下级-4
									$map5=array();
									$map5['ship_barcode'] = $where;
									$map5['ship_unitcode']=$this->qy_unitcode;
									$map5['ship_deliver']=$data4['ship_dealer'];   //ship_deliver--出货方   ship_dealer--收货方
									$data5=$Shipment->where($map5)->find();
									if(is_not_null($data5)){
										$map22=array();
										$map22['dl_unitcode']=$this->qy_unitcode;
										$map22['dl_id'] = $data5['ship_dealer'];
										$Dealerinfo = $Dealer->where($map22)->find();
										if($Dealerinfo){

											$data5['dl_name']= wxuserTextDecode2($Dealerinfo['dl_name']);
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
				$this->error('该条码不存在或还没发行','',2);
			}
		}else{
			$this->error('请输入或扫入条码','',2);
		}
		$this->assign('shipmentinfo', $data);
		$this->assign('barcode', $barcode);

		$this->display('fangcuanres');
    }
}