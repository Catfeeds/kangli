<?php
namespace Kangli\Controller;
use Think\Controller;
class QueryController extends CommController {    
	//防伪显示 产品信息  非彩码
    public function index(){
        //防止频繁刷新 1000毫秒
        if(requ_security(1,1000,'','','')){
            $this->error('页面已过期，请刷新页面重新查询',U('./'),2);
        }
        if (IS_POST) {
            $fwcode=trim(I('post.fwcode',''));
        }else{
            $fwcode=trim(I('get.fwcode',''));
        }

        $msg='';
        $is_checkcode=0;
		$ischuhuo=0; 
        if($fwcode!=''){
            if(!preg_match("/^[0-9]{10,27}$/",$fwcode)){
                $msg='请正确输入防伪码或扫二维码查询';
                $fwcode='';
            }
        }
        if($fwcode!=''){
            //查询次数访问限制 判断是否要输入验证码
            if(requ_security('4|8','','',15,20)){
                $is_checkcode=1;
            }

            //对同一qycode 6小时内调用接口限制  判断是否要输入验证码
            $qycode=substr($fwcode,0,4);
            $Templist = M("Templist");
            $map=array();
            $map['tmp_unitcode']=$qycode;
            $map['tmp_state']=1;
            $map['tmp_addtime']=array('EGT',time()-3600*6); 
            $tlcount = $Templist->where($map)->count();
            
            $map=array();
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
                $msnlength=$qydata['msnlength'];
                $sntype = substr($qydata['sntype'],0,1);
                $snpr = $qydata['snpr']; //前缀

                if($qydata['qy_querytimes']<$tlcount){
                    $is_checkcode=1;
                }
            }else{
                $msg='请正确输入防伪码或扫二维码查询';
                goto gotoEND;
                exit;
            }
			
            //检测验证码
            if($is_checkcode==1){
                $msg='请正确输入验证码，再点击查询按钮查询';
                goto gotoEND;
                exit;
            }
            //由防伪码找k
            $myk=fwcode_to_k($fwcode,$qycode,$mlength);
            if($myk===false || $myk<=0){
                $msg='<b>您查询的防伪码：</b>'.$fwcode.'<br><b>查询结果：</b>'.C('SEND_MESSAGE')['msg03'];
                goto gotoEND;
                exit;
            }
			
            //由防伪码找物流信息
            $wlinfo=fw_to_wlinfo($fwcode,$myk,$sntype,$snpr,$msnlength);
            if($wlinfo===false){
                $msg='没有该防伪码或还没发行，谨防假冒或者重新核对输入';
                goto gotoEND;
                exit;
            }
            if($wlinfo['qty']<=0){
                $msg='没有该防伪码或还没发行，谨防假冒或者重新核对输入';
                goto gotoEND;
                exit;
            }
			
            //是否扫码出货
            $map=array();
            $where=array();
            $Shipment= M('Shipment');
            if($wlinfo['code']!=''){
                $where[]=array('EQ',$wlinfo['code']);
            }
            if($wlinfo['tcode']!='' && $wlinfo['tcode']!=$wlinfo['code']){
                $where[]=array('EQ',$wlinfo['tcode']);
            }
            if($wlinfo['ucode']!='' && $wlinfo['ucode']!=$wlinfo['code'] && $wlinfo['ucode']!=$wlinfo['tcode']){
                $where[]=array('EQ',$wlinfo['ucode']);
            }
            $where[]='or';
            $map['ship_barcode'] = $where;
            $map['ship_unitcode']=$qycode;
            $shdata=$Shipment->where($map)->order('ship_id DESC')->find();
            
			$prodata=array();
			if($shdata){
                $Product = M('Product');
                $Dealer = M('Dealer');

                $map2=array();
                $map2['pro_unitcode']=$qycode;
                $map2['pro_id'] = $shdata['ship_pro'];
                $Proinfo = $Product->where($map2)->find();

                if($Proinfo){
                    $prodata['pro_name']=$Proinfo['pro_name'];
                    $prodata['pro_number']=$Proinfo['pro_number'];
                    $prodata['pro_desc']=nl2br($Proinfo['pro_desc']);
                    $prodata['pro_pic']=$Proinfo['pro_pic'];
					$prodata['pro_price']=$Proinfo['pro_price'];
                    $prodata['pro_pic_str']='<img src="'.__ROOT__.'/Public/uploads/product/'.$Proinfo['pro_pic'].'"  border="0">'; 
                }
				
                $map2=array();
                $map2['dl_unitcode']=$qycode;
                $map2['dl_id'] = $shdata['ship_dealer'];
                $Dealerinfo = $Dealer->where($map2)->find();
                if($Dealerinfo){
                        $prodata['dl_name']=$Dealerinfo['dl_name'];
                        $prodata['dl_weixin']=$Dealerinfo['dl_weixin'];
						$prodata['dl_number']=$Dealerinfo['dl_number'];
					  
						$Dltype= M('Dltype');
						$map4=array();
						$map4['dlt_unitcode']=$qycode;
						$map4['dlt_id']=$Dealerinfo['dl_type'];
						$data4 = $Dltype->where($map4)->find();
						if($data4){
							$prodata['dlt_name']=$data4['dlt_name'];
						}
                }
				$ischuhuo=1; 
			}
			
			
		
            //从接口获取数据
			$referer=trim(I('server.HTTP_REFERER','')).'_'.trim(I('server.HTTP_USER_AGENT',''));
			$referer=substr($referer,0,300).'_Kangli';

			//从接口获取数据
			$ip=real_ip();
			$timestamp=time();

			$signature=MD5($this->qy_fwkey.$fwcode.$timestamp.$this->qy_fwsecret);
			$url='http://www.cn315fw.com/fwapi/Getres?fwkey='.urlencode($this->qy_fwkey).'&ip='.urlencode($ip).'&fwcode='.urlencode($fwcode).'&signature='.urlencode($signature).'&timestamp='.urlencode($timestamp).'&referer='.urlencode($referer);  
				
			$data=@file_get_contents($url);
			if($data===FALSE){
				$msg='请正确输入防伪码或扫二维码查询';
                goto gotoEND;
                exit;
			}else{
				$data_arr=json_decode($data,true); 
				if(!is_array($data_arr)){
					$msg='请正确输入防伪码或扫二维码查询';
					goto gotoEND;
                    exit;
				}else{

					$msg='<b>您查询的防伪码：</b>'.$fwcode.'<br><b>查询结果：</b>'.$data_arr['msg'];

					//记录查询次数 cookie
					$requesttimes=floor(\Org\Util\Funcrypt::authcode(cookie('requesttimes'),'DECODE',C('WWW_AUTHKEY'),0));
					cookie('requesttimes',\Org\Util\Funcrypt::authcode($requesttimes+1,'ENCODE',C('WWW_AUTHKEY'),0),1800);
				}
			} 
			
        }else{
           $referer=trim(I('server.HTTP_REFERER',''));
           $this->assign('referer', $referer);
        }
		
        /////////////////////
        gotoEND:
		$this->assign('ischuhuo', $ischuhuo);
        $this->assign('prodata', $prodata);
        $this->assign('msg', $msg);
        $this->assign('is_checkcode', $is_checkcode);
        $this->assign('fwcode', $fwcode);

        $this->display('index');
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

    //返回查询结果
    public function ajaxres(){
        if (IS_POST) {
            $fwcode=trim(I('post.fwcode',''));
            $referer=trim(I('post.referer',''));
        }else{
			$msg=array('fwc'=>'','stat'=>'5','msg'=>'请正确输入防伪码');
			echo json_encode($msg);
			exit;
        }

       if($referer==''){
            $referer=trim(I('server.HTTP_REFERER','')).'_'.trim(I('server.HTTP_USER_AGENT',''));
            
        }else{
            $referer=$referer.'_'.trim(I('server.HTTP_REFERER','')).'_'.trim(I('server.HTTP_USER_AGENT',''));
        }
        $referer=substr($referer,0,300).'_Kangli';

        if($fwcode==''){
			$msg=array('fwc'=>'','stat'=>'5','msg'=>'请正确输入防伪码');
			echo json_encode($msg);
			exit;
        }
		if($fwcode!=''){
			if(!preg_match("/^[0-9]{10,27}$/",$fwcode)){
				$msg=array('fwc'=>'','stat'=>'5','msg'=>'请正确输入防伪码');
				echo json_encode($msg);
				exit;
			}
		}

        //安全防御
        //防止频繁刷新 1000毫秒 二次请求时间间隔过短 2000毫秒
        if(requ_security('1|2',1000,'2000','','')){
            sleep(1);
            $msg=array('fwc'=>'','stat'=>'5','msg'=>'页面已过期，请刷新页面重新查询');
            echo json_encode($msg);
		    exit;
        }

        $is_checkcode=0;
		$ischuhuo=0; 
        //查询次数访问限制 判断是否要输入验证码
        if(requ_security('4|8','','',15,20)){
        	$is_checkcode=1;
        }

        //对同一qycode 6小时内调用接口限制  判断是否要输入验证码
        $qycode=substr($fwcode,0,4);
        $Templist = M("Templist");
        $map=array();
        $map['tmp_unitcode']=$qycode;
        $map['tmp_state']=1;
        $map['tmp_addtime']=array('EGT',time()-3600*6); 
        $tlcount = $Templist->where($map)->count();
        
		$map=array();
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
			$msnlength=$qydata['msnlength'];
			$sntype = substr($qydata['sntype'],0,1);
			$snpr = $qydata['snpr']; //前缀

			if($qydata['qy_querytimes']<$tlcount){
				$is_checkcode=1;
			}
		}else{
            $msg=array('fwc'=>$fwcode,'stat'=>'5','msg'=>'请正确输入防伪码');
            echo json_encode($msg);
		    exit;
		}
		
        //检测验证码
        if($is_checkcode==1){
            $checkcode=trim(I('post.checkcode',''));
            if($checkcode==''){
                $msg=array('fwc'=>$fwcode,'stat'=>'9','msg'=>'请正确输入验证码');
                echo json_encode($msg);
                exit;
            }else{
                $verify = new \Think\Verify();
                if(!($verify->check($checkcode))){
                    $msg=array('fwc'=>$fwcode,'stat'=>'9','msg'=>'请正确输入验证码');
                    echo json_encode($msg);
                    exit;
                }
            }
        }
		
		//由防伪码找k
		$myk=fwcode_to_k($fwcode,$qycode,$mlength);
		if($myk===false || $myk<=0){
			$msg2='<b>您查询的防伪码：</b>'.$fwcode.'<br><b>查询结果：</b>'.C('SEND_MESSAGE')['msg03'];
            $msg=array('fwc'=>$fwcode,'stat'=>'5','msg'=>$msg2);
            echo json_encode($msg);
		    exit;
		}
		
		//由防伪码找物流信息
		$wlinfo=fw_to_wlinfo($fwcode,$myk,$sntype,$snpr,$msnlength);
		if($wlinfo===false){
            $msg=array('fwc'=>$fwcode,'stat'=>'5','msg'=>'没有该防伪码或还没发行，谨防假冒或者重新核对输入');
            echo json_encode($msg);
		    exit;
		}
		if($wlinfo['qty']<=0){
            $msg=array('fwc'=>$fwcode,'stat'=>'5','msg'=>'没有该防伪码或还没发行，谨防假冒或者重新核对输入');
            echo json_encode($msg);
		    exit;
		}
		
		//是否扫码出货
		$map=array();
		$where=array();
		$Shipment= M('Shipment');
		if($wlinfo['code']!=''){
			$where[]=array('EQ',$wlinfo['code']);
		}
		if($wlinfo['tcode']!='' && $wlinfo['tcode']!=$wlinfo['code']){
			$where[]=array('EQ',$wlinfo['tcode']);
		}
		if($wlinfo['ucode']!='' && $wlinfo['ucode']!=$wlinfo['code'] && $wlinfo['ucode']!=$wlinfo['tcode']){
			$where[]=array('EQ',$wlinfo['ucode']);
		}
		$where[]='or';
		$map['ship_barcode'] = $where;
		$map['ship_unitcode']=$qycode;
		$shdata=$Shipment->where($map)->order('ship_id DESC')->find();
		
		$prodata=array();
		if($shdata){
			$Product = M('Product');
			$Dealer = M('Dealer');

			$map2=array();
			$map2['pro_unitcode']=$qycode;
			$map2['pro_id'] = $shdata['ship_pro'];
			$Proinfo = $Product->where($map2)->find();

			if($Proinfo){
				$prodata['pro_name']=$Proinfo['pro_name'];
				$prodata['pro_number']=$Proinfo['pro_number'];
				$prodata['pro_desc']=nl2br($Proinfo['pro_desc']);
				$prodata['pro_pic']=$Proinfo['pro_pic'];
				$prodata['pro_price']=number_format($Proinfo['pro_price'],2);
				$prodata['pro_pic_str']='<img src="'.__ROOT__.'/Public/uploads/product/'.$Proinfo['pro_pic'].'"  border="0">'; 
			}
			
			$map2=array();
			$map2['dl_unitcode']=$qycode;
			$map2['dl_id'] = $shdata['ship_dealer'];
			$Dealerinfo = $Dealer->where($map2)->find();
			if($Dealerinfo){
					$prodata['dl_name']=$Dealerinfo['dl_name'];
					$prodata['dl_weixin']=$Dealerinfo['dl_weixin'];
					$prodata['dl_number']=$Dealerinfo['dl_number'];
				  
					$Dltype= M('Dltype');
					$map4=array();
					$map4['dlt_unitcode']=$qycode;
					$map4['dlt_id']=$Dealerinfo['dl_type'];
					$data4 = $Dltype->where($map4)->find();
					if($data4){
						$prodata['dlt_name']=$data4['dlt_name'];
					}
			}
			$ischuhuo=1; 
		}

        //从接口获取数据
        $ip=real_ip();
        $fwkey=$this->qy_fwkey;
        $timestamp=time();
        $qy_fwsecret=$this->qy_fwsecret;

        $signature=MD5($fwkey.$fwcode.$timestamp.$qy_fwsecret);
        $url='http://www.cn315fw.com/fwapi/Getres?fwkey='.urlencode($fwkey).'&ip='.urlencode($ip).'&fwcode='.urlencode($fwcode).'&signature='.urlencode($signature).'&timestamp='.urlencode($timestamp).'&referer='.urlencode($referer);  
            
        $data=@file_get_contents($url);
        if($data===FALSE){
            $msg=array('fwc'=>$fwcode,'stat'=>'5','msg'=>'请正确输入防伪码');
            echo json_encode($msg);
            exit;
        }else{
            $data_arr=json_decode($data,true); 
            if(!is_array($data_arr)){
                $msg=array('fwc'=>$fwcode,'stat'=>'5','msg'=>'请正确输入防伪码','$fwcode');
                echo json_encode($msg);
                exit;
            }else{
				$data_arr['prodata']=$prodata;
				$data_arr['ischuhuo']=$ischuhuo;
                echo json_encode($data_arr);
                //记录查询次数 cookie
                $requesttimes=floor(\Org\Util\Funcrypt::authcode(cookie('requesttimes'),'DECODE',C('WWW_AUTHKEY'),0));
                cookie('requesttimes',\Org\Util\Funcrypt::authcode($requesttimes+1,'ENCODE',C('WWW_AUTHKEY'),0),1800);
                exit;
            }
        }   
    } 
	
}