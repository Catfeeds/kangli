<?php
namespace Kangli\Controller;
use Think\Controller;
class AgentController extends CommController {
    //代理商查询
    public function index(){
   //      if(!$this->is_jxuser_login()){
			// $qy_fwkey=$this->qy_fwkey;
			// $qy_fwsecret=$this->qy_fwsecret;
   //          $ttamp2=time();
		 //    $sture2=MD5($qy_fwkey.$ttamp2.$qy_fwsecret);
		 //    $tagpage='http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
			// header('location:'.WWW_WEBROOT.'Kangli/Dealer/login/ttamp/'.$ttamp2.'/sture/'.$sture2.'/tagpage/'.base64_encode($tagpage).'');
   //      }
        $keyword=trim(I('get.keyword',''));
        $backtag=intval(I('get.backtag',0));
		if ($keyword!='')
		{
			if(!preg_match("/^[a-zA-Z0-9_-]{4,30}$/",$keyword)){
				$this->error('请正确输入代理商微信号/手机号',U('Kangli/Agent/index'),'',2);
			}
			$where['dl_tel']=array('like',"%$keyword%");
			$where['dl_weixin']=array('like',"%$keyword%");
			$where['_logic'] = 'or';
			$map['_complex'] = $where;

			$map['dl_unitcode']=$this->qy_unitcode;
			// $map['dl_status']=1;
			$map['dl_belong']=session('jxuser_id');
			$Dealer= M('Dealer');
			$data=$Dealer->where($map)->field('dl_id,dl_name,dl_weixin,dl_wxheadimg,dl_tel,dl_address,dl_addtime,dl_level,dl_status')->order('dl_id DESC')->select();
			if($data){
				foreach ($data as $k => $v) {
					if($v['dl_weixin']!=''){
						$data[$k]['dl_weixin_s']=substr($v['dl_weixin'],0,1).'****'.substr($v['dl_weixin'],-4);
					}
					if($v['dl_tel']!=''){
						$data[$k]['dl_tel_s']=substr($v['dl_tel'],0,3).'****'.substr($v['dl_tel'],-4);
					}
					
					$Brandattorney = M('Brandattorney');
					$map5=array();
					$map5['ba_unitcode']=$this->qy_unitcode;
					$map5['ba_dealerid']=$data['dl_id'];
					$data5 = $Brandattorney->where($map5)->select();			
					foreach($data5 as $kk=>$vv){
	                    if($vv['ba_pic']!=''){
						    // $str.= '<li class="ui-border-t" style="text-align:center" ><p style="text-align:center" ><img src="'.__ROOT__.'/Public/uploads/product/'.$v['ba_pic'].'"  border="0"  style="vertical-align:middle;width:80%" ></p></li>';
						   $kk['ba_pic_str']=__ROOT__.'/Public/uploads/product/'.$v['ba_pic'];
				        }
				    }
				    $k['dl_brand']=$data5;
					// $msg=array('stat'=>1,'msg'=>'','dl_list'=>$data);
					// echo json_encode($msg);
					// exit;
				}
			}	
		}
		$this->assign('backtag',$backtag);
		$this->assign('dl_slist',$data);
		$this->display('index');
    }
	

	 //返回查询结果
    public function ajaxres(){
    		if(!$this->is_jxuser_login()){
				$qy_fwkey=$this->qy_fwkey;
				$qy_fwsecret=$this->qy_fwsecret;
           		$ttamp2=time();
			    $sture2=MD5($qy_fwkey.$ttamp2.$qy_fwsecret);
			    $tagpage='http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
				header('location:'.WWW_WEBROOT.'Kangli/Dealer/login/ttamp/'.$ttamp2.'/sture/'.$sture2.'/tagpage/'.base64_encode($tagpage).'');
        	}

			$keyword=I('post.keyword','');
			if($keyword==''){
				$msg=array('stat'=>0,'msg'=>'请输入代理商微信号/手机号');
				echo json_encode($msg);
				exit;
			}
			if(!preg_match("/^[a-zA-Z0-9_-]{4,30}$/",$keyword)){
				$msg=array('stat'=>0,'msg'=>'请正确输入代理商微信号/手机号');
				echo json_encode($msg);
				exit;
			}
			
			$where['dl_tel']=$keyword;
			$where['dl_weixin']=$keyword;
			$where['_logic'] = 'or';
			$map['_complex'] = $where;

			$map['dl_unitcode']=$this->qy_unitcode;
			// $map['dl_status']=1;
			$map['dl_belong']=session('jxuser_id');
			$Dealer= M('Dealer');
			$data=$Dealer->where($map)->find();
			if($data){
				$data['dl_weixin_s']='';
				$data['dl_tel_s']='';
				if($data['dl_weixin']!=''){
					$data['dl_weixin_s']=substr($data['dl_weixin'],0,1).'****'.substr($data['dl_weixin'],-4);
				}
				if($data['dl_tel']!=''){
					$data['dl_tel_s']=substr($data['dl_tel'],0,3).'****'.substr($data['dl_tel'],-4);
				}

				$str= '<li class="ui-border-t"><h4>代理商微信：'.$data['dl_weixin_s'].'</h4></li>';
				$str.= '<li class="ui-border-t"><h4>代理商名称：'.$data['dl_name'].'</h4></li>';
				$str.= '<li class="ui-border-t"><h4>代理商电话：'.$data['dl_tel_s'].'</h4></li>';

				
				$Brandattorney = M('Brandattorney');
				$map5=array();
				$map5['ba_unitcode']=$this->qy_unitcode;
				$map5['ba_dealerid']=$data['dl_id'];
				$data5 = $Brandattorney->where($map5)->select();
				
				foreach($data5 as $k=>$v){
                    if($v['ba_pic']!=''){
					    $str.= '<li class="ui-border-t" style="text-align:center" ><p style="text-align:center" ><img src="'.__ROOT__.'/Public/uploads/product/'.$v['ba_pic'].'"  border="0"  style="vertical-align:middle;width:80%" ></p></li>';
					   $v['ba_pic_str']='.__ROOT__./Public/uploads/product/'.$v['ba_pic'];
			        }
			    }

			    $data['dl_brand']=$data5;

				$msg=array('stat'=>1,'msg'=>'','dl_list'=>$data);
				echo json_encode($msg);
				exit;
			}else{
				$msg=array('stat'=>0,'msg'=>'该代理不存在，请正确输入代理商微信号/手机号');
				echo json_encode($msg);
				exit;
			}
    }
}