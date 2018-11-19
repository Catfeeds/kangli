<?php
namespace Fwapi\Controller;
use Think\Controller;
class GetresController extends Controller {
    //普通接口 返回json格式
    public function index(){
        if (IS_POST) {
            $uip=trim(I('post.ip',''));
            $fwkey=trim(I('post.fwkey',''));
            $fwcode=trim(I('post.fwcode',''));
            $timestamp=trim(I('post.timestamp',''));
            $signature=trim(I('post.signature',''));
            $referer=trim(I('post.referer',''));
        }else{
            $uip=trim(I('get.ip',''));
            $fwkey=trim(I('get.fwkey',''));
            $fwcode=trim(I('get.fwcode',''));
            $timestamp=trim(I('get.timestamp',''));
            $signature=trim(I('get.signature',''));
            $referer=trim(I('get.referer',''));
        }
        if($referer==''){
            $referer=trim(I('server.HTTP_REFERER','')).'_'.trim(I('server.HTTP_USER_AGENT',''));
            
        }else{
            $referer=$referer.'_'.trim(I('server.HTTP_REFERER','')).'_'.trim(I('server.HTTP_USER_AGENT',''));
        }
        $referer=substr($referer,0,300);
		
		//如果是否alibaba安全监测
		if(strpos($referer,'Alibaba.Security') !== false || strpos($referer,'google.com/bot.html') !== false){
			echo '';
			exit;
		}

        if($uip==''){
           $uip=real_ip();
        }
        if(!preg_match('/^([0-9]{1,3}\.){3}[0-9]{1,3}$/',$uip)){
           $uip='';
        }

        if($fwkey=='' || $fwcode=='' || $timestamp=='' || $signature==''){
            $msg=array('fwc'=>'','stat'=>'5','msg'=>'请正确输入防伪码或扫二维码查询');
            echo json_encode($msg);
            exit;
        }

        if($fwcode!=''){
            if(!preg_match("/^[0-9]{10,27}$/",$fwcode)){
                $msg=array('fwc'=>'','stat'=>'5','msg'=>'请正确输入防伪码或扫二维码查询');
                echo json_encode($msg);
                exit;
            }
        }

        $qycode=substr($fwcode,0,4);
        if($fwkey==''){
            $msg=array('fwc'=>'','stat'=>'5','msg'=>'请正确输入防伪码或扫二维码查询');
            echo json_encode($msg);
            exit;
        }
        $deqycode=\Org\Util\Funcrypt::authcode($fwkey,'DECODE',C('QY_FWDEKEY'),0);

        $is_localquery=1;
        $map=array();
        $map['qy_active']=1;
        $map['qy_code']=$qycode;
        $Qyinfo = M('Qyinfo');
        $data=$Qyinfo->where($map)->find(); 


 
		if($data){
			$qy_querytimes=$data['qy_querytimes'];  //6小时内调用接口允许次数 超过则隔3分钟允许调用一次
			$is_localquery=0;
			$qy_relation=$data['qy_relation'];
			if($deqycode==$qycode){
				$qy_fwsecret=$data['qy_fwsecret'];      //相当密钥
			}else{
				if($qy_relation!='' && strpos($qy_relation,$deqycode)!==false){
					$map=array();
					$data=array();
					$map['qy_active']=1;
					$map['qy_code']=$deqycode;
					$data=$Qyinfo->where($map)->find(); 
					if($data){
						$qy_fwsecret=$data['qy_fwsecret'];      //相当密钥
					}else{
						$qy_fwsecret=C('QY_FWSECRET');
					}
				}else{
					$qy_fwsecret=C('QY_FWSECRET');
				}
			}
		}else{
			$qy_fwsecret=C('QY_FWSECRET');
			$qy_querytimes='1500';
		}

       

		//验证提交过来的参数
		if(MD5($fwkey.$fwcode.$timestamp.$qy_fwsecret)!=$signature){
			$msg=array('fwc'=>'','stat'=>'5','msg'=>'请正确输入防伪码或扫二维码查询');
			echo json_encode($msg);
			exit;
		}


        //对同一qycode 6小时内调用接口限制 
        $map=array();
        $Tellist = M("Tellist");
        $Templist = M("Templist");
        $map['tmp_unitcode']=$qycode;
        $map['tmp_state']=1;
        $map['tmp_addtime']=array('EGT',time()-3600*6); 
        $tlcount = $Templist->where($map)->count();

        if($qy_querytimes<$tlcount){
            //最新的查询记录
            $map2=array();
            $map2['unitcode']=$qycode;
            $map2['fwcode']=$fwcode;
            $data2=$Tellist->where($map2)->order('querydate DESC')->find(); 
            if($data2){
                $querydate=strtotime($data2['querydate']);
            }else{
                $querydate=time()-1800;
            }
            if((time()-$querydate)<180){
                $msg=array('fwc'=>'','stat'=>'5','msg'=>'对不起，因查询频繁，请稍后再试');
                echo json_encode($msg);
                exit;   
            }
        }


		//云服查询

		$fwcoders=fwcode_to_result($fwcode,0,$uip,1);
		if($fwcoders===false){
			$msg_arr=array('fwc'=>$fwcode,'stat'=>'5','msg'=>C('SEND_MESSAGE')['msg03']);
		}else{
			$msg_arr=$fwcoders;
		}

		//记录查询 db
		$data=array();
		$data['tmp_unitcode']=$qycode;
		$data['tmp_code']=$msg_arr['fwc'];
		$data['tmp_state']=$msg_arr['stat'];
		$data['tmp_ip']=$uip;
		$data['tmp_addtime']=time();
		$data['tmp_remark']=$msg_arr['msg'];
		$data['tmp_referer']=$referer.'_APIGetres';

		$Templist->create($data,1);
		$Templist->add();
	  

		echo json_encode($msg_arr);
		exit;


    }
}