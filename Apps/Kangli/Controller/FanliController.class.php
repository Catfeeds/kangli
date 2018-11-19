<?php
namespace Kangli\Controller;
use Think\Controller;
class FanliController extends CommController {
    //返利首页
    public function index(){
        if(!$this->is_jxuser_login()){
			$qy_fwkey=$this->qy_fwkey;
			$qy_fwsecret=$this->qy_fwsecret;
            $ttamp2=time();
		    $sture2=MD5($qy_fwkey.$ttamp2.$qy_fwsecret);
 			$tagpage='http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
			header('location:'.WWW_WEBROOT.'Kangli/Dealer/login/ttamp/'.$ttamp2.'/sture/'.$sture2.'/tagpage/'.base64_encode($tagpage).'');
        }
		$state=intval(I('get.state',0));
		$ly_status=intval(I('get.ly_status',0));

        $Dealer= M('Dealer');
        $Dltype= M('Dltype');
		$map=array();
		$map['dl_id']=session('jxuser_id');
		$map['dl_unitcode']=$this->qy_unitcode;
		$map['dl_status']=1;
		$data=$Dealer->where($map)->find();
		if($data){
			$dl_name=wxuserTextDecode2($data['dl_name']);
			$dl_weixin=$data['dl_weixin'];
			$dl_number=$data['dl_number'];
			$dl_tel=$data['dl_tel'];
			$dl_lastflid=$data['dl_lastflid'];
			$dl_fanli=$data['dl_fanli'];
			$dl_level=$data['dl_level'];

			// //代理级别
			// $mapt=array();
			// $mapt['dl_unitcode']=$this->qy_unitcode;
			// $mapt['dlt_id']=$data['dl_type'];
			// $mapt['dlt_level']=$data['dl_level'];
			// $datat=$Dltype->where($mapt)->field('dlt_id,dlt_name')->find();
			// // var_dump($datat);
			// if($datat){
			// 	$data['dl_level_name']=$datat['dlt_name'];
			// }
		}else{
			session('jxuser_id',null);
			session('jxuser_unitcode',null);
			$this->error('授权已过期，请重新登录',U('Kangli/Index/index'),1);
			exit;
		}
		$Fanlidetail= M('Fanlidetail');

		//返利总余额
		$balance_total=0;



		//应收返利求和-待收款
		$map3=array();
		$map3['fl_dlid']=session('jxuser_id');
		$map3['fl_unitcode']=$this->qy_unitcode;
		//$map3['fl_type'] = array('in','1,2,3,4,5,6,7,8,9,10'); //返利分类 1-推荐返利 2-订单返利  11-提现减少返利 (1-10 增加返利 11-20 减少返利)
		$map3['fl_state']=0;  //0-待收款 1-已收款 2-收款中  9-已取消
		$addfl=0;
		$flsum1 = $Fanlidetail->where($map3)->sum('fl_money');
		if($flsum1){
			$addfl=$flsum1;
		}
		$balance_total=$addfl;





		//经销商表中更新返利
		$data3=array();
		$data3['dl_fanli'] = $addfl;
		$Dealer->where($map)->data($data3)->save();







		$mapls=array();
		$parameter=array();
		$parameter['state']=$state;
        $mapls['fl_unitcode']=$this->qy_unitcode;
		if($state==1){ //已收款
			$mapls['fl_dlid']=session('jxuser_id');
			$mapls['fl_state']=1;
		}else if($state==2){ //待付款 付款中
			$mapls['fl_senddlid']=session('jxuser_id');
			$mapls['fl_state']=array('in','0,2');
		}else if($state==3){  //已付款
			$mapls['fl_senddlid']=session('jxuser_id');
			$mapls['fl_state']=1;
		}else if($state==9){
			$where=array();
			$where['fl_dlid']=session('jxuser_id');
			$where['fl_senddlid']=session('jxuser_id');
			$where['_logic'] = 'or';
			$mapls['_complex'] = $where;
			$mapls['fl_state']=9;
		}else{  //$state==0           //待收款 收款中
			$mapls['fl_dlid']=session('jxuser_id');
			$mapls['fl_state']=array('in','0,2');
		}
        $count = $Fanlidetail->where($mapls)->count();
        $Page = new \Think\Page($count,50,$parameter);
        $show = $Page->show();
		if($show=='<div>    </div>'){
            $show='';
        }
        $list = $Fanlidetail->where($mapls)->order('fl_id DESC')->limit(($Page->firstRow . ',') . $Page->listRows)->select();
		foreach($list as $k=>$v){ 
		    //返利分类 1-推荐返利 2-订单返利  11-提现减少返利 (1-10 增加返利 11-20 减少返利) 
		    if($v['fl_type']>=1 && $v['fl_type']<=10){
				$list[$k]['fl_moneystr']='<span style="color:#000000; font-size:1rem;">'.number_format($v['fl_money'], 2,'.','').'</span>';
			}else if($v['fl_type']>=11 && $v['fl_type']<=20){
				$list[$k]['fl_moneystr']='<span style="color:#009900;font-size:1rem;">'.number_format($v['fl_money'], 2,'.','').'</span>';
			}else{
				$list[$k]['fl_moneystr']='<span font-size:1rem;">'.number_format($v['fl_money'], 2,'.','').'</span>';
			}

		}

		
		// //应付返利求和-待付款
		// $map3=array();
		// $map3['fl_senddlid']=session('jxuser_id');
		// $map3['fl_unitcode']=$this->qy_unitcode;
		// //$map3['fl_type'] = array('in','1,2,3,4,5,6,7,8,9,10'); //返利分类 1-推荐返利 2-订单返利  11-提现减少返利 (1-10 增加返利 11-20 减少返利)
		// $map3['fl_state']=0;  //0-待收款 1-已收款 2-收款中  9-已取消
		// $addf2=0;
		// $flsum2 = $Fanlidetail->where($map3)->sum('fl_money');
		// if($flsum1){
		// 	$addf2=$flsum2;
		// }
		

		
		// $map=array();
		// $map['dl_id']=session('jxuser_id');
		// $map['dl_unitcode']=$this->qy_unitcode;
		// $map['dl_status']=1;
		// $data=$Dealer->where($map)->find();
		// if($data){
		// 	$dl_fanli=$data['dl_fanli'];
		// }else{
		// 	session('jxuser_id',null);
		// 	session('jxuser_unitcode',null);
		// 	$this->error('授权已过期，请重新登录',U('Kangli/Index/index'),1);
		// 	exit;
		// }
		
		// $this->assign('dl_level', $dl_level);
		// $this->assign('addfl', $addfl);
		// $this->assign('addf2', $addf2);
		// $this->assign('dl_name', $dl_name);
		// $this->assign('dl_weixin', $dl_weixin);
		// $this->assign('dl_number', $dl_number);
		$this->assign('dl_level', $dl_level);
		$this->assign('balance_total', $balance_total);
        $this->assign('list', $list);
        $this->assign('state', $state);
        $this->assign('ly_status', $ly_status);
		$this->assign('page', $show);
		$this->assign('pagecount', $count);
        $this->display('index');
    }
	
	//返利明细
    public function fanlilist(){
        if(!$this->is_jxuser_login()){
			$qy_fwkey=$this->qy_fwkey;
			$qy_fwsecret=$this->qy_fwsecret;
            $ttamp2=time();
		    $sture2=MD5($qy_fwkey.$ttamp2.$qy_fwsecret);
 			$tagpage='http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
			header('location:'.WWW_WEBROOT.'Kangli/Dealer/login/ttamp/'.$ttamp2.'/sture/'.$sture2.'/tagpage/'.base64_encode($tagpage).'');
        }
		//--------------------------------
		
		$state=intval(I('get.state',0));

		
		$Fanlidetail= M('Fanlidetail');

        $map=array();
		$parameter=array();
		$parameter['state']=$state;
        $map['fl_unitcode']=$this->qy_unitcode;
		   
		if($state==1){  //已收款
			$map['fl_dlid']=session('jxuser_id');
			$map['fl_state']=1;
		}else if($state==2){ //待付款 付款中
			$map['fl_senddlid']=session('jxuser_id');
			$map['fl_state']=array('in','0,2');
		}else if($state==3){  //已付款
			$map['fl_senddlid']=session('jxuser_id');
			$map['fl_state']=1;
		}else if($state==9){
			$where=array();
			$where['fl_dlid']=session('jxuser_id');
			$where['fl_senddlid']=session('jxuser_id');
			$where['_logic'] = 'or';
			$map['_complex'] = $where;
			$map['fl_state']=9;
		}else{              //待收款 收款中
			$map['fl_dlid']=session('jxuser_id');
			$map['fl_state']=array('in','0,2');
		}

        $count = $Fanlidetail->where($map)->count();
        $Page = new \Think\Page($count,50,$parameter);
        $show = $Page->show();
		if($show=='<div>    </div>'){
            $show='';
        }
        $list = $Fanlidetail->where($map)->order('fl_id DESC')->limit(($Page->firstRow . ',') . $Page->listRows)->select();

		foreach($list as $k=>$v){ 
		    //返利分类 1-推荐返利 2-订单返利  11-提现减少返利 (1-10 增加返利 11-20 减少返利) 
		    if($v['fl_type']>=1 && $v['fl_type']<=10){
				$list[$k]['fl_moneystr']='<span style="color:#000000; font-size:1rem;">'.number_format($v['fl_money'], 2,'.','').'</span>';
			}else if($v['fl_type']>=11 && $v['fl_type']<=20){
				$list[$k]['fl_moneystr']='<span style="color:#009900;font-size:1rem;">'.number_format($v['fl_money'], 2,'.','').'</span>';
			}else{
				$list[$k]['fl_moneystr']='<span font-size:1rem;">'.number_format($v['fl_money'], 2,'.','').'</span>';
			}

		}
        $this->assign('list', $list);
        $this->assign('state', $state);
		$this->assign('page', $show);
		$this->assign('pagecount', $count);
        $this->display('fanlilist');
		
	}	
    
	//返利详细
    public function fanlidetail(){
        if(!$this->is_jxuser_login()){
			$qy_fwkey=$this->qy_fwkey;
			$qy_fwsecret=$this->qy_fwsecret;
            $ttamp2=time();
		    $sture2=MD5($qy_fwkey.$ttamp2.$qy_fwsecret);
 			$tagpage='http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
			header('location:'.WWW_WEBROOT.'Kangli/Dealer/login/ttamp/'.$ttamp2.'/sture/'.$sture2.'/tagpage/'.base64_encode($tagpage).'');
        }
		//--------------------------------
        $fl_id=intval(I('get.fl_id',0));
		$state=intval(I('get.state',0));
		$ly_status=intval(I('get.ly_status',0));
		$map=array();
		$map['fl_id']=$fl_id;
		$map['fl_unitcode']=$this->qy_unitcode;
		$map['fl_dlid']=session('jxuser_id');
		$Fanlidetail= M('Fanlidetail');
		$data=$Fanlidetail->where($map)->find();
		if($data){
		    //返利分类 1-推荐返利 2-订单返利  11-提现减少返利 (1-10 增加返利 11-20 减少返利) 
		    if($data['fl_type']>=1 && $data['fl_type']<=10){
				$data['fl_moneystr']='<span style="color:#000000">'.number_format($data['fl_money'], 2,'.','').'</span>';
			}else if($data['fl_type']>=11 && $data['fl_type']<=20){
				$data['fl_moneystr']='<span style="color:#009900">'.number_format($data['fl_money'], 2,'.','').'</span>';
			}else{
				$data['fl_moneystr']=number_format($data['fl_money'], 2,'.','');
			}
			if(isset(C('FANLI_TYPE')[$data['fl_type']])){
			    $data['fl_typestr']=C('FANLI_TYPE')[$data['fl_type']];
			}else{
				$data['fl_typestr']='其他';
			}
			$Dealer= M('Dealer');
			//收款代理
			$map3=array();
			$data3=array();
			$map3['dl_id']=$data['fl_dlid'];
			$map3['dl_unitcode']=$this->qy_unitcode;
			$data3=$Dealer->where($map3)->find();
			if($data3){
				$data['fl_rdl_name']=$data3['dl_name'];
				$data['fl_rdl_username']=$data3['dl_username'];
			}else{
				$data['fl_rdl_name']='';
				$data['fl_rdl_username']='';
			}
			//付款代理
			if($data['fl_senddlid']==0){
				$data['fl_sdl_name']='总公司';
				$data['fl_sdl_username']='';
			}else{
				$map3=array();
				$data3=array();
				$map3['dl_id']=$data['fl_senddlid'];
				$map3['dl_unitcode']=$this->qy_unitcode;
				$data3=$Dealer->where($map3)->find();
				if($data3){
					$data['fl_sdl_name']=$data3['dl_name'];
					$data['fl_sdl_username']=$data3['dl_username'];
				}else{
					$data['fl_sdl_name']='';
					$data['fl_sdl_username']='';
				}
			}
			//状态
			if($state==1 && $data['fl_state']==1){  
				$data['fl_state_str']='已收款';
			}else if($state==2 && $data['fl_state']==0){ 
				$data['fl_state_str']='待付款';
			}else if($state==2 && $data['fl_state']==2){ 
			    $data['fl_state_str']='付款中';
			}else if($state==3 && $data['fl_state']==1){  
				$data['fl_state_str']='已付款';
			}else if($state==9 && $data['fl_state']==9){
				$data['fl_state_str']='已取消';
			}else if($state==0 && $data['fl_state']==0){
				$data['fl_state_str']='待收款';
			}else if($state==0 && $data['fl_state']==2){
				$data['fl_state_str']='收款中';
			}else{                                    
				$data['fl_state_str']='';
			}
			
		}else{
			$this->error('没有该记录','',2);
		}

        $this->assign('state', $state);
        $this->assign('ly_status', $ly_status);
        $this->assign('fanliinfo', $data);

        $this->display('fanlidetail');
	}	
	
	//我应付返利--下级提现
    public function paylist(){
        if(!$this->is_jxuser_login()){
			$qy_fwkey=$this->qy_fwkey;
			$qy_fwsecret=$this->qy_fwsecret;
            $ttamp2=time();
		    $sture2=MD5($qy_fwkey.$ttamp2.$qy_fwsecret);
 			$tagpage='http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
			header('location:'.WWW_WEBROOT.'Kangli/Dealer/login/ttamp/'.$ttamp2.'/sture/'.$sture2.'/tagpage/'.base64_encode($tagpage).'');
        }
		//--------------------------------
		$Recash= M('Recash');
        $map=array();
		$parameter=array();
        $map['rc_unitcode']=$this->qy_unitcode;
		$map['rc_sdlid']=session('jxuser_id');   
		
        $count = $Recash->where($map)->count();
        $Page = new \Think\Page($count,50,$parameter);
        $show = $Page->show();
		if($show=='<div>    </div>'){
            $show='';
        }
        $list = $Recash->where($map)->order('rc_id DESC')->limit(($Page->firstRow . ',') . $Page->listRows)->select();
        $Dealer= M('Dealer');
		foreach($list as $k=>$v){ 
            $list[$k]['rc_moneystr']='<span style="color:#009900">'.number_format($v['rc_money'], 2,'.','').'</span>';
			if(isset(C('FANLI_BANKS')[$v['rc_bank']])){
				$list[$k]['rc_str']='申请提现到 '.C('FANLI_BANKS')[$v['rc_bank']];
			}else{
				$list[$k]['rc_str']='申请提现';
			}
			if(MD5($v['rc_unitcode'].$v['rc_dlid'].number_format($v['rc_money'],2,'.','').$v['rc_bankcard'].$v['rc_addtime'])==$v['rc_verify']){
				if($v['rc_state']==0){
					$list[$k]['rc_statestr']='新提交';
				}else if($v['rc_state']==1){
					$list[$k]['rc_statestr']='提现成功';
				}else if($v['rc_state']==2){
					$list[$k]['rc_statestr']='提现失败';
				}else{
					$list[$k]['rc_statestr']='异常';
				}
            }else{
				if($v['rc_state']==0){
					$list[$k]['rc_statestr']='新提交[异常]';
				}else if($v['rc_state']==1){
					$list[$k]['rc_statestr']='提现成功[异常]';
				}else if($v['rc_state']==2){
					$list[$k]['rc_statestr']='提现失败[异常]';
				}else{
					$list[$k]['rc_statestr']='异常';
				}
			}
			
            //收款代理
			$map3=array();
			$data3=array();
			$map3['dl_id']=$v['rc_dlid'];
			$map3['dl_unitcode']=$this->qy_unitcode;
			$data3=$Dealer->where($map3)->find();
			if($data3){
				$list[$k]['fl_rdl_name']=$data3['dl_name'];
				$list[$k]['fl_rdl_username']=$data3['dl_username'];
			}else{
				$list[$k]['fl_rdl_name']='';
				$list[$k]['fl_rdl_username']='';
			}
		}
		

        $this->assign('list', $list);
        $this->assign('page', $show);
		$this->assign('pagecount', $count);
        $this->display('paylist');
	}
	
	//我应付返利详细
    public function paydetail(){
        if(!$this->is_jxuser_login()){
			$qy_fwkey=$this->qy_fwkey;
			$qy_fwsecret=$this->qy_fwsecret;
            $ttamp2=time();
		    $sture2=MD5($qy_fwkey.$ttamp2.$qy_fwsecret);
 			$tagpage='http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
			header('location:'.WWW_WEBROOT.'Kangli/Dealer/login/ttamp/'.$ttamp2.'/sture/'.$sture2.'/tagpage/'.base64_encode($tagpage).'');
        }
		//--------------------------------
		
        $rc_id=intval(I('get.rc_id',0));
		$map=array();
		$map['rc_id']=$rc_id;
		$map['rc_unitcode']=$this->qy_unitcode;
		$map['rc_sdlid']=session('jxuser_id');
		
		$Recash= M('Recash');
		$data=$Recash->where($map)->find();
		if($data){
            $data['rc_moneystr']=number_format($data['rc_money'],2,'.','');
			
			if(isset(C('FANLI_BANKS')[$data['rc_bank']])){
				$data['rc_bankstr']=C('FANLI_BANKS')[$data['rc_bank']];
			}else{
				$data['rc_bankstr']='';
			}

			$data['rc_bankcardstr']=\Org\Util\Funcrypt::authcode($data['rc_bankcard'],'DECODE',C('WWW_AUTHKEY'),0);
			
            if(MD5($data['rc_unitcode'].$data['rc_dlid'].number_format($data['rc_money'],2,'.','').$data['rc_bankcard'].$data['rc_addtime'])==$data['rc_verify']){
				if($data['rc_state']==0){
					$data['rc_statestr']='处理中';
				}else if($data['rc_state']==1){
					$data['rc_statestr']='提现成功';
				}else if($data['rc_state']==2){
					$data['rc_statestr']='提现失败';
				}else{
					$data['rc_statestr']='异常';
				}
            }else{
				if($data['rc_state']==0){
					$data['rc_statestr']='新提交[异常]';
				}else if($data['rc_state']==1){
					$data['rc_statestr']='付款成功[异常]';
				}else if($data['rc_state']==2){
					$data['rc_statestr']='付款失败[异常]';
				}else{
					$data['rc_statestr']='异常';
				}
			}
			
			//提现代理信息
			if($data['rc_dlid']>0){
				$map2=array();
				$Dealer= M('Dealer');
				$map2['dl_id']=$data['rc_dlid'];
				$map2['dl_unitcode']=$this->qy_unitcode;
				$data2=$Dealer->where($map2)->find();
				if($data2){
					if($data2['dl_status']==1){
						$data['dl_name_str']=$data2['dl_name'].'('.$data2['dl_username'].')';
					}else{
					    $data['dl_name_str']=$data2['dl_name'].'('.$data2['dl_username'].')[已禁用]';
					}
				}else{
					$data['dl_name_str']='未知';
				}
			}else{
				$data['dl_name_str']='未知';
			}
			
			//付款代理
			if($data['rc_sdlid']>0){
				$map2=array();
				$map2['dl_id']=$data['rc_sdlid'];
				$map2['dl_unitcode']=$this->qy_unitcode;
				$data2=$Dealer->where($map2)->find();
				if($data2){
					$data['dl_sendname_str']=$data2['dl_name'].'('.$data2['dl_username'].')';
				}else{
					$data['dl_sendname_str']='未知';
				}
			}else{
				$data['dl_sendname_str']='总公司';
			}
			
			$imgpath = BASE_PATH.'/Public/uploads/orders/';
			//图片
            if(is_not_null($data['rc_pic']) && file_exists($imgpath.$data['rc_pic'])){
                $data['rc_pic_str']='<a href="'.__ROOT__.'/Public/uploads/orders/'.$data['rc_pic'].'"  target="_blank" ><img src="'.__ROOT__.'/Public/uploads/orders/'.$data['rc_pic'].'"  border="0" style="vertical-align:middle;width;10%"  ></a>';
            }else{
                $data['rc_pic_str']='';
            }
			
		}else{
			$this->error('没有该记录','',2);
		}
		
		$qy_fwkey=$this->qy_fwkey;
		$qy_fwsecret=$this->qy_fwsecret;
		$ttamp=time();
		$sture=MD5($qy_fwkey.$ttamp.$qy_fwsecret);
		$this->assign('ttamp', $ttamp);
		$this->assign('sture', $sture);

        $this->assign('recashinfo', $data);
        $this->display('paydetail');
	}	
	
    //处理保存
    public function paydeal_save(){
        if(!$this->is_jxuser_login()){
			$qy_fwkey=$this->qy_fwkey;
			$qy_fwsecret=$this->qy_fwsecret;
            $ttamp2=time();
		    $sture2=MD5($qy_fwkey.$ttamp2.$qy_fwsecret);
 			$tagpage='http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
			header('location:'.WWW_WEBROOT.'Kangli/Dealer/login/ttamp/'.$ttamp2.'/sture/'.$sture2.'/tagpage/'.base64_encode($tagpage).'');
        }
		//--------------------------------
		
		$rc_id=intval(I('post.rc_id',0));

		if($rc_id>0){
			
			//提交是否失效
			$ttamp=trim(I('post.ttamp',''));
			$sture=trim(I('post.sture',''));
			$fwkey=$this->qy_fwkey;
			$qy_fwsecret=$this->qy_fwsecret;
			$nowtime=time();
			if(MD5($fwkey.$ttamp.$qy_fwsecret)!=$sture){
                $this->error('提交异常',U('Kangli/Fanli/paydetail/rc_id/'.$rc_id.''),2);
			}
			if(($nowtime - $ttamp) > 1200) {
				$this->error('提交异常',U('Kangli/Fanli/paydetail/rc_id/'.$rc_id.''),2);
			}
			
			$rc_state=intval(I('post.rc_state',0));
			$rc_remark=trim(I('post.rc_remark',''));
			$rc_remark2=trim(I('post.rc_remark2',''));
			if($rc_state<=0){
				$this->error('请选择处理状态','',2);
			}
			if($rc_remark==''){
				$this->error('请填写处理备注','',2);
			}
			
			$map=array();
			$Recash= M('Recash');
		    $map['rc_id']=$rc_id;
			$map['rc_sdlid']=session('jxuser_id');
		    $map['rc_unitcode']=$this->qy_unitcode;
			$data=$Recash->where($map)->find();
			if($data){
				$data2=array();
				if($data['rc_dealtime']<=0){
				   $data2['rc_dealtime']=time();
				}
				
				//保存文件 begin 
				$file_name=I('post.file_name','');
				$rc_pic='';
				if($file_name==''){
					$this->error('请上传图片','',2);
				}else{
					$imgpath=BASE_PATH.'/Public/uploads/orders/'.$this->qy_unitcode;
					$temppath=BASE_PATH.'/Public/uploads/temp/';
					if (!file_exists($imgpath)) {
						mkdir($imgpath);
					}
					
					if(copy($temppath.$file_name,$imgpath.'/'.$file_name)) {
					    $rc_pic=$this->qy_unitcode.'/'.$file_name;
						@unlink($temppath.$file_name); 
					}else{
                        $this->error('上传图片失败','',2);
					}
				}
				//保存文件 end
				
				if($rc_pic==''){
					$this->error('请上传图片','',2);
				}else{
					$data2['rc_pic']=$rc_pic;
				}
				
                $data2['rc_state']=$rc_state;
				$data2['rc_remark']=$rc_remark;
				$data2['rc_remark2']=$rc_remark2;
				
                $rs=$Recash->where($map)->data($data2)->save();
				if($rs){
					//更改返利明细状态
					$Fanlidetail= M('Fanlidetail');
					$map3=array();
					$map3['fl_dlid']=$data['rc_dlid']; //返利收方
					$map3['fl_senddlid']=$data['rc_sdlid']; //返利发方
					$map3['fl_unitcode']=$this->qy_unitcode;
					$map3['fl_rcid']=$data['rc_id'];
					$map3['fl_state']=2;  //0-待收款 1-已收款 2-收款中  9-已取消

					$data3=array();
					if($rc_state==1){
						$data3['fl_state'] = 1;
					}else if($rc_state==2){
						$data3['fl_state'] =0;
						$data3['fl_rcid'] = 0;
					}
					$Fanlidetail->where($map3)->data($data3)->save();
					
					
	                //记录日志 begin
					$log_arr=array();
					$log_arr=array(
								'log_qyid'=>session('jxuser_id'),
								'log_user'=>session('jxuser_username'),
								'log_qycode'=>$this->qy_unitcode,
								'log_action'=>'处理提现',
								'log_type'=>2, //0-系统 1-企业 2-经销商 3-消费者
								'log_addtime'=>time(),
								'log_ip'=>real_ip(),
								'log_link'=>__SELF__,
								'log_remark'=>json_encode(array_merge($data,$data2))
								);
					save_log($log_arr);
					//记录日志 end
					
					$this->success('提交成功',U('Kangli/Fanli/paydetail/rc_id/'.$rc_id.''),1);
					
					
				}else if($rs==0){
					$this->error('提交数据没改变','',2);
				}else{
					$this->error('提交失败','',2);
				}
			}else{
				$this->error('没有该记录','',2);
			}
		}else{
			$this->error('没有该记录','',2);
		}
	}
	
	
	//我应收返利
    public function receivelist(){
        if(!$this->is_jxuser_login()){
			$qy_fwkey=$this->qy_fwkey;
			$qy_fwsecret=$this->qy_fwsecret;
            $ttamp2=time();
		    $sture2=MD5($qy_fwkey.$ttamp2.$qy_fwsecret);
 			$tagpage='http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
			header('location:'.WWW_WEBROOT.'Kangli/Dealer/login/ttamp/'.$ttamp2.'/sture/'.$sture2.'/tagpage/'.base64_encode($tagpage).'');
        }
		//--------------------------------
		$Fanlidetail= M('Fanlidetail');
		$Dealer= M('Dealer');
        $map=array();
        $map['fl_unitcode']=$this->qy_unitcode;
		$map['fl_dlid']=session('jxuser_id');//接受返利的经销商
		$list = $Fanlidetail->field('fl_senddlid')->where($map)->group('fl_senddlid')->select();
//         dump($list);die();
        foreach($list as $k=>$v){ 
		    //付款方
		    if($v['fl_senddlid']==0){//总代
				$list[$k]['fl_sdl_name']='总公司';//付款方为总公司
				$list[$k]['fl_sdl_username']='';
			}else{//非总代
				$map3=array();
				$data3=array();
				$map3['dl_id']=$v['fl_senddlid'];
				$map3['dl_unitcode']=$this->qy_unitcode;
				$data3=$Dealer->where($map3)->find();
				if($data3){
					$list[$k]['fl_sdl_name']=$data3['dl_name'];
					$list[$k]['fl_sdl_username']=$data3['dl_username'];
				}else{
					$list[$k]['fl_sdl_name']='';
					$list[$k]['fl_sdl_username']='';
				}
			}
		    //统计累计返利
			$map3=array();
			$map3['fl_dlid']=session('jxuser_id'); //返利收方
			$map3['fl_senddlid']=$v['fl_senddlid']; //返利发方
			$map3['fl_unitcode']=$this->qy_unitcode;
			$map3['fl_state']=array('neq',9);;  //0-待收款 1-已收款 2-收款中  9-已取消
			$flsum1=0;
			$flsum1 = $Fanlidetail->where($map3)->sum('fl_money');
            $list[$k]['fltotail']=$flsum1;
			
			//统计已收返利
            $map3=array();
			$map3['fl_dlid']=session('jxuser_id'); //返利收方
			$map3['fl_senddlid']=$v['fl_senddlid']; //返利发方
			$map3['fl_unitcode']=$this->qy_unitcode;
			$map3['fl_state']=1;  //0-待收款 1-已收款 2-收款中  9-已取消
			$flsum2=0;
			$flsum2 = $Fanlidetail->where($map3)->sum('fl_money');
            $list[$k]['flreceived']=$flsum2;
			
			//统计待收返利
            $map3=array();
			$map3['fl_dlid']=session('jxuser_id'); //返利收方
			$map3['fl_senddlid']=$v['fl_senddlid']; //返利发方
			$map3['fl_unitcode']=$this->qy_unitcode;
			$map3['fl_state']=0;  //0-待收款 1-已收款 2-收款中  9-已取消
			$flsum3=0;
			$flsum3 = $Fanlidetail->where($map3)->sum('fl_money');
            $list[$k]['flready']=$flsum3;
			
			//统计收款中
            $map3=array();
			$map3['fl_dlid']=session('jxuser_id'); //返利收方
			$map3['fl_senddlid']=$v['fl_senddlid']; //返利发方
			$map3['fl_unitcode']=$this->qy_unitcode;
			$map3['fl_state']=2;  //0-待收款 1-已收款 2-收款中  9-已取消
			$flsum4=0;
			$flsum4 = $Fanlidetail->where($map3)->sum('fl_money');
            $list[$k]['flreceiving']=$flsum4;
			
			//统计可提现金额
			$map3=array();
			$map3['fl_dlid']=session('jxuser_id'); //返利收方
			$map3['fl_senddlid']=$v['fl_senddlid']; //返利发方
			$map3['fl_unitcode']=$this->qy_unitcode;
			$map3['fl_state']=0;  //0-待收款 1-已收款 2-收款中  9-已取消
//			$map3['fl_addtime']=array('lt',time()-3600*24*C('FANLI_JIANGETIME'));
			$flsum5=0;
			$flsum5 = $Fanlidetail->where($map3)->sum('fl_money');
			$list[$k]['flcanrecash']=$flsum5;
		}
//		dump($list);die();
		// var_dump($list);
        $this->assign('list', $list);	
        $this->display('receivelist');
		
	}
	//返利提现
    public function recash(){
        if(!$this->is_jxuser_login()){
			$qy_fwkey=$this->qy_fwkey;
			$qy_fwsecret=$this->qy_fwsecret;
            $ttamp2=time();
		    $sture2=MD5($qy_fwkey.$ttamp2.$qy_fwsecret);
 			$tagpage='http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
			header('location:'.WWW_WEBROOT.'Kangli/Dealer/login/ttamp/'.$ttamp2.'/sture/'.$sture2.'/tagpage/'.base64_encode($tagpage).'');
        }
		//--------------------------------
		$fl_senddlid=intval(I('get.dlid',0));
		
		//收款代理
        $Dealer= M('Dealer');
		$map=array();
		$map['dl_id']=session('jxuser_id');
		$map['dl_unitcode']=$this->qy_unitcode;
		$map['dl_status']=1;
		$data=$Dealer->where($map)->find();
		if($data){
			$dl_name=$data['dl_name'];
			$dl_username=$data['dl_username'];
			$dl_number=$data['dl_number'];
			$dl_tel=$data['dl_tel'];
			$dl_lastflid=$data['dl_lastflid'];
			$dl_fanli=$data['dl_fanli'];
		}else{
			session('jxuser_id',null);
			session('jxuser_unitcode',null);
			$this->error('授权已过期，请重新登录',U('Kangli/Index/index'),1);
			exit;
		}
		//-------------
		
		//付款代理
		if($fl_senddlid==0){
			$fl_sdl_name='总公司';
			$fl_sdl_username='';
		}else{
			$map3=array();
			$data3=array();
			$map3['dl_id']=$fl_senddlid;
			$map3['dl_unitcode']=$this->qy_unitcode;
			$data3=$Dealer->where($map3)->find();
			if($data3){
				$fl_sdl_name=$data3['dl_name'];
				$fl_sdl_username=$data3['dl_username'];
			}else{
				$this->error('付款代理不存在','',2);
			}
		}
		$Fanlidetail= M('Fanlidetail');
		//统计待收返利 
		$map3=array();
		$map3['fl_dlid']=session('jxuser_id'); //返利收方
		$map3['fl_senddlid']=$fl_senddlid; //返利发方
		$map3['fl_unitcode']=$this->qy_unitcode;
		$map3['fl_state']=0;  //0-待收款 1-已收款 2-收款中  9-已取消
		$dl_fanli=0;
		$dl_fanli = $Fanlidetail->where($map3)->sum('fl_money');
		if($dl_fanli<=0){
			$this->error('待收返利为0','',2);
		}
		
		//统计可提现金额
		$map3=array();
		$map3['fl_dlid']=session('jxuser_id'); //返利收方
		$map3['fl_senddlid']=$fl_senddlid; //返利发方
		$map3['fl_unitcode']=$this->qy_unitcode;
		$map3['fl_state']=0;  //0-待收款 1-已收款 2-收款中  9-已取消
//		$map3['fl_addtime']=array('lt',time()-3600*24*C('FANLI_JIANGETIME'));
//		$dl_fanli2=0;
		$dl_fanli2 = $Fanlidetail->where($map3)->sum('fl_money');
		//if($dl_fanli2<=0){
		//	$this->error('可提现金额为0','',2);
		//}
		$bankarr=C('FANLI_BANKS');
//		dump($bankarr);die();
		$qy_fwkey=$this->qy_fwkey;
		$qy_fwsecret=$this->qy_fwsecret;
		$ttamp=time();
		$sture=MD5($qy_fwkey.$ttamp.$qy_fwsecret);
		
		$this->assign('edurecash', C('FANLI_RECASH'));
		$this->assign('jiangetime', C('FANLI_JIANGETIME'));
		$this->assign('fl_senddlid', $fl_senddlid);
		$this->assign('dl_name', $dl_name);
		$this->assign('dl_username', $dl_username);
		$this->assign('fl_sdl_name', $fl_sdl_name);
		$this->assign('fl_sdl_username', $fl_sdl_username);
		$this->assign('dl_fanli', $dl_fanli);
		$this->assign('dl_fanli2', $dl_fanli2);
		$this->assign('ttamp', $ttamp);
		$this->assign('sture', $sture);
		$this->assign('bankarr', $bankarr);
		$this->display('recash');	
	}
	
	//返利提现 保存
    public function recash_save(){	
        if(!$this->is_jxuser_login()){
			$qy_fwkey=$this->qy_fwkey;
			$qy_fwsecret=$this->qy_fwsecret;
            $ttamp2=time();
		    $sture2=MD5($qy_fwkey.$ttamp2.$qy_fwsecret);
 			$tagpage='http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
			header('location:'.WWW_WEBROOT.'Kangli/Dealer/login/ttamp/'.$ttamp2.'/sture/'.$sture2.'/tagpage/'.base64_encode($tagpage).'');
        }
		//--------------------------------
		
        $Dealer= M('Dealer');
		$map=array();
		$map['dl_id']=session('jxuser_id');
		$map['dl_unitcode']=$this->qy_unitcode;
		$map['dl_status']=1;
		$data=$Dealer->where($map)->find();
		if($data){
			$dl_name=$data['dl_name'];
			$dl_username=$data['dl_username'];
			$dl_number=$data['dl_number'];
			$dl_tel=$data['dl_tel'];
			$dl_lastflid=$data['dl_lastflid'];
			$dl_fanli=$data['dl_fanli'];
			$dl_pwd=$data['dl_pwd'];
		}else{
			session('jxuser_id',null);
			session('jxuser_unitcode',null);
			$this->error('授权已过期，请重新登录',U('Kangli/Index/index'),1);
			exit;
		}
		//-------------
		
		$ttamp=trim(I('post.ttamp',''));
		$sture=trim(I('post.sture',''));
		$fwkey=$this->qy_fwkey;
		$qy_fwsecret=$this->qy_fwsecret;
		$nowtime=time();
		if(MD5($fwkey.$ttamp.$qy_fwsecret)!=$sture){
			$this->error('操作超时,请重试',U('Kangli/Fanli/index'),2);
		}
		if(($nowtime - $ttamp) > 1200) {
			$this->error('操作超时,请重试',U('Kangli/Fanli/index'),2);
		}
		
		$fl_senddlid=intval(I('post.fl_senddlid',0));  //付款代理
		
		$rc_bank=intval(I('post.rc_bank',0));
		$rc_bankcard=trim(I('post.rc_bankcard',''));
		$rc_pwd=trim(I('post.rc_pwd',''));
		$rc_name=$dl_name;
		
		if($rc_bank<=0){
			$this->error('请选择开户银行','',2);
		}
		if($rc_bankcard==''){
			$this->error('请填写卡号或支付宝账号','',2);
		}
		if($rc_name==''){
			$this->error('请填写卡号/账号对应的姓名','',2);
		}
		if($rc_pwd==''){
			$this->error('请填写密码','',2);
		}

		if($dl_pwd!=MD5(MD5(MD5($rc_pwd)))){
			$this->error('填写密码不正确','',2);
		}
		
		//统计可提现金额
		$Fanlidetail= M('Fanlidetail');
//		$oktime=time()-3600*24*C('FANLI_JIANGETIME');
		$map3=array();
		$map3['fl_dlid']=session('jxuser_id'); //返利收方
		$map3['fl_senddlid']=$fl_senddlid; //返利发方
		$map3['fl_unitcode']=$this->qy_unitcode;
		$map3['fl_state']=0;  //0-待收款 1-已收款 2-收款中  9-已取消
//		$map3['fl_addtime']=array('lt',$oktime);
//		$rc_money=0;
		$rc_money = $Fanlidetail->where($map3)->sum('fl_money');
		if($rc_money<=0){
			$this->error('可提现金额为0',U('Kangli/Fanli/receivelist'),2);
		}
		
        if(null !== C('FANLI_RECASH')){
			if($rc_money<C('FANLI_RECASH')){
			    $this->error('提取金额必须'.C('FANLI_RECASH').'以上',U('Kangli/Fanli/receivelist'),2);
		    }
		}else{
			if($rc_money<100){
			    $this->error('提取金额必须100以上',U('Kangli/Fanli/receivelist'),2);
		    }
		}
		$rc_money=number_format($rc_money,2,'.','');
		

        $rc_bankcard_encode=\Org\Util\Funcrypt::authcode($rc_bankcard,'ENCODE',C('WWW_AUTHKEY'),0);

		
		$data2=array();
		$data2['rc_unitcode']=$this->qy_unitcode;
		$data2['rc_dlid']=session('jxuser_id');  //提现的代理id
		$data2['rc_sdlid']=$fl_senddlid;    //发放提现的代理id 0-公司
		$data2['rc_money']=$rc_money;
		$data2['rc_bank']=$rc_bank;
		$data2['rc_bankcard']=$rc_bankcard_encode;
		$data2['rc_name']=$rc_name;
		$data2['rc_addtime']=time();
		$data2['rc_dealtime']=0;
		$data2['rc_state']=0;
		$data2['rc_remark']='';
		$data2['rc_ip']=real_ip();
		$rc_verify=MD5($data2['rc_unitcode'].$data2['rc_dlid'].$data2['rc_money'].$data2['rc_bankcard'].$data2['rc_addtime']); //验证串
		$data2['rc_verify']=$rc_verify;
		
		$Recash= M('Recash');
		$rs=$Recash->create($data2,1);
		$result = $Recash->add();  
		if($result){
			$map3=array();
			$map3['fl_dlid']=session('jxuser_id'); //返利收方
			$map3['fl_senddlid']=$fl_senddlid; //返利发方
			$map3['fl_unitcode']=$this->qy_unitcode;
			$map3['fl_state']=0;  //0-待收款 1-已收款 2-收款中  9-已取消
			$map3['fl_addtime']=array('lt',$oktime);

			$data3=array();
			$data3['fl_state'] = 2;
			$data3['fl_rcid'] = $result;
			$Fanlidetail->where($map3)->data($data3)->save();
			
			
			
			//代理操作日志 begin
			$odlog_arr=array(
						'dlg_unitcode'=>$this->qy_unitcode,  
						'dlg_dlid'=>session('jxuser_id'),
						'dlg_operatid'=>session('jxuser_id'),
						'dlg_dlusername'=>session('jxuser_username'),
						'dlg_dlname'=>session('jxuser_dlname'),
						'dlg_action'=>'代理商申请提现',
						'dlg_type'=>1, //0-企业 1-经销商
						'dlg_addtime'=>time(),
						'dlg_ip'=>real_ip(),
						'dlg_link'=>__SELF__
						);
			$Dealerlogs = M('Dealerlogs');
			$rs3=$Dealerlogs->create($odlog_arr,1);
			if($rs3){
				$Dealerlogs->add();
			}
			//代理操作日志 end
			
			$this->success('提现提交成功，请等待处理',U('Kangli/Fanli/receivelist'),2);
		}else{
			$this->error('提现提交失败',U('Kangli/Fanli/receivelist'),2);
		}
	}
	
	//提现记录
    public function recashlist(){
        if(!$this->is_jxuser_login()){
			$qy_fwkey=$this->qy_fwkey;
			$qy_fwsecret=$this->qy_fwsecret;
            $ttamp2=time();
		    $sture2=MD5($qy_fwkey.$ttamp2.$qy_fwsecret);
 			$tagpage='http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
			header('location:'.WWW_WEBROOT.'Kangli/Dealer/login/ttamp/'.$ttamp2.'/sture/'.$sture2.'/tagpage/'.base64_encode($tagpage).'');
        }
		//--------------------------------
		$Recash= M('Recash');

        $map=array();
		$parameter=array();
        $map['rc_unitcode']=$this->qy_unitcode;
		$map['rc_dlid']=session('jxuser_id');   

        $count = $Recash->where($map)->count();
        $Page = new \Think\Page($count,50,$parameter);
        $show = $Page->show();
		if($show=='<div>    </div>'){
            $show='';
        }
        $list = $Recash->where($map)->order('rc_id DESC')->limit(($Page->firstRow . ',') . $Page->listRows)->select();
        $Dealer= M('Dealer');
		foreach($list as $k=>$v){ 
            $list[$k]['rc_moneystr']='<span style="color:#009900">'.number_format($v['rc_money'],2,'.','').'</span>';
			if(isset(C('FANLI_BANKS')[$v['rc_bank']])){
				$list[$k]['rc_str']='申请提现到 '.C('FANLI_BANKS')[$v['rc_bank']];
			}else{
				$list[$k]['rc_str']='申请提现';
			}

			if(MD5($v['rc_unitcode'].$v['rc_dlid'].number_format($v['rc_money'],2,'.','').$v['rc_bankcard'].$v['rc_addtime'])==$v['rc_verify']){
				if($v['rc_state']==0){
					$list[$k]['rc_statestr']='处理中';
				}else if($v['rc_state']==1){
					$list[$k]['rc_statestr']='提现成功';
				}else if($v['rc_state']==2){
					$list[$k]['rc_statestr']='提现失败';
				}else{
					$list[$k]['rc_statestr']='异常';
				}
            }else{
				if($v['rc_state']==0){
					$list[$k]['rc_statestr']='处理中[异常]';
				}else if($v['rc_state']==1){
					$list[$k]['rc_statestr']='提现成功[异常]';
				}else if($v['rc_state']==2){
					$list[$k]['rc_statestr']='提现失败[异常]';
				}else{
					$list[$k]['rc_statestr']='异常';
				}
			}
			
            //付款方
		    if($v['rc_sdlid']==0){
				$list[$k]['fl_sdl_name']='总公司';
				$list[$k]['fl_sdl_username']='';
			}else{
				$map3=array();
				$data3=array();
				$map3['dl_id']=$v['rc_sdlid'];
				$map3['dl_unitcode']=$this->qy_unitcode;
				$data3=$Dealer->where($map3)->find();
				if($data3){
					$list[$k]['fl_sdl_name']=$data3['dl_name'];
					$list[$k]['fl_sdl_username']=$data3['dl_username'];
				}else{
					$list[$k]['fl_sdl_name']='';
					$list[$k]['fl_sdl_username']='';
				}
			}
		}
		
        $this->assign('list', $list);
        $this->assign('page', $show);
		$this->assign('pagecount', $count);
		
        $this->display('recashlist');
		
	}	
	
	//返利提现详细
    public function recashdetail(){
        if(!$this->is_jxuser_login()){
			$qy_fwkey=$this->qy_fwkey;
			$qy_fwsecret=$this->qy_fwsecret;
            $ttamp2=time();
		    $sture2=MD5($qy_fwkey.$ttamp2.$qy_fwsecret);
 			$tagpage='http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
			header('location:'.WWW_WEBROOT.'Kangli/Dealer/login/ttamp/'.$ttamp2.'/sture/'.$sture2.'/tagpage/'.base64_encode($tagpage).'');
        }
		//--------------------------------
		
        $rc_id=intval(I('get.rc_id',0));
		$map=array();
		$map['rc_id']=$rc_id;
		$map['rc_unitcode']=$this->qy_unitcode;
		$map['rc_dlid']=session('jxuser_id');
		
		$Recash= M('Recash');
		$Dealer= M('Dealer');
		$data=$Recash->where($map)->find();
		if($data){
            $data['rc_moneystr']=number_format($data['rc_money'],2,'.','');
			
			if(isset(C('FANLI_BANKS')[$data['rc_bank']])){
				$data['rc_bankstr']=C('FANLI_BANKS')[$data['rc_bank']];
			}else{
				$data['rc_bankstr']='';
			}

			$data['rc_bankcardstr']=\Org\Util\Funcrypt::authcode($data['rc_bankcard'],'DECODE',C('WWW_AUTHKEY'),0);
			
            if(MD5($data['rc_unitcode'].$data['rc_dlid'].number_format($data['rc_money'],2,'.','').$data['rc_bankcard'].$data['rc_addtime'])==$data['rc_verify']){
				if($data['rc_state']==0){
					$data['rc_statestr']='处理中';
				}else if($data['rc_state']==1){
					$data['rc_statestr']='提现成功';
				}else if($data['rc_state']==2){
					$data['rc_statestr']='提现失败';
				}else{
					$data['rc_statestr']='异常';
				}
            }else{
				if($data['rc_state']==0){
					$data['rc_statestr']='处理中[异常]';
				}else if($data['rc_state']==1){
					$data['rc_statestr']='提现成功[异常]';
				}else if($data['rc_state']==2){
					$data['rc_statestr']='提现失败[异常]';
				}else{
					$data['rc_statestr']='异常';
				}
			}
			
			//付款代理
			if($data['rc_sdlid']==0){
				$data['fl_sdl_name']='总公司';
				$data['fl_sdl_username']='';
			}else{
				$map3=array();
				$data3=array();
				$map3['dl_id']=$data['rc_sdlid'];
				$map3['dl_unitcode']=$this->qy_unitcode;

				$data3=$Dealer->where($map3)->find();
				if($data3){
					$data['fl_sdl_name']=$data3['dl_name'];
					$data['fl_sdl_username']=$data3['dl_username'];
				}else{
					$data['fl_sdl_name']='';
					$data['fl_sdl_username']='';
				}
			}
			
			$imgpath = BASE_PATH.'/Public/uploads/orders/';
			//图片
            if(is_not_null($data['rc_pic']) && file_exists($imgpath.$data['rc_pic'])){
                $data['rc_pic_str']='<a href="'.__ROOT__.'/Public/uploads/orders/'.$data['rc_pic'].'"  target="_blank" ><img src="'.__ROOT__.'/Public/uploads/orders/'.$data['rc_pic'].'"  border="0" style="vertical-align:middle;width;10%"  ></a>';
            }else{
                $data['rc_pic_str']='';
            }
			
			
			
		}else{
			$this->error('没有该记录','',2);
		}

        $this->assign('recashinfo', $data);
        $this->display('recashdetail');
	}	
	
	
	//按月业绩返利
    public function salemonthly(){
        if(!$this->is_jxuser_login()){
			$qy_fwkey=$this->qy_fwkey;
			$qy_fwsecret=$this->qy_fwsecret;
            $ttamp2=time();
		    $sture2=MD5($qy_fwkey.$ttamp2.$qy_fwsecret);
 			$tagpage='http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
			header('location:'.WWW_WEBROOT.'Kangli/Dealer/login/ttamp/'.$ttamp2.'/sture/'.$sture2.'/tagpage/'.base64_encode($tagpage).'');
        }
		//--------------------------------
		$yj_type=intval(I('get.yj_type',0)); //0、每月业绩1、年度业绩2、总业绩
		if ($yj_type==1)
		{
			$title="年度业绩奖金";
		}else if ($yj_type==2){
			$title="业绩累计奖金";
		}else{
			$title="按月业绩奖金";
		}

		$Salemonthly= M('Salemonthly');
		$Fanlidetail= M('Fanlidetail');
		$Salemonfanlirate= M('Salemonfanlirate');
		$Dealer= M('Dealer');
		$Orders= M('Orders');
        $map3=array();
		$data3=array();
		$map3['dl_id']=session('jxuser_id');
		$map3['dl_unitcode']=$this->qy_unitcode;
		$data3=$Dealer->where($map3)->find();
		if($data3){
			$Dltype= M('Dltype');
			$map2=array();
			$map2['dlt_unitcode']=$this->qy_unitcode;
			$map2['dlt_id']=$data3['dl_type'];
			$data2 = $Dltype->where($map2)->find();
			if($data2){
				$dlt_level=$data2['dlt_level'];
				// $dl_type=$data2['dl_type'];
				$dlt_type=$data3['dl_type'];
			}else{
				$dlt_level=0;
				$dlt_type=0;
			}
			$dl_referee=$data3['dl_referee'];
			$dl_belong=$data3['dl_belong'];
		}else{
            $this->error('授权已过期，请重新登录',U('Kangli/Index/index'),1);
		}
		
		//只有前2级才有 按月业绩奖金
	    if($dlt_level==2 || $dlt_level==3){
			//当月业绩
			$yearmonth=date('Y-m',time());
			$ndays=date("t",strtotime($yearmonth)); //天数
			$nbegintime=strtotime($yearmonth);
			$nendtime=$nbegintime+3600*24*$ndays;
			
			//自己的业绩
			// 对应订单
			$Model=M();
			$map2=array();
			$nsalesum=0;
			$nodsum=0;
			//下单的金额(只统计已发货、已完成) 
			$map2['a.od_unitcode']=$this->qy_unitcode;
			$map2['a.od_oddlid']=session('jxuser_id');
			$map2['a.od_state']=array('IN','3,8');
			$map2['a.od_virtualstock']=1;
			$map2['a.od_fugou']=1;
			$map2['a.od_expressdate']=array('between',array($nbegintime,$nendtime));
			$map2['a.od_id']=array('exp','=b.oddt_odid');
			$map2['a.od_orderid']=array('exp','=b.oddt_orderid');
			// $order = $Model->table('fw_orders a,fw_orderdetail b')->where($map2)->field('od_id,od_total,oddt_qty')->select();
			$nodsum = $Model->table('fw_orders a,fw_orderdetail b')->where($map2)->sum('od_total'); 
			$nodqtysum = $Model->table('fw_orders a,fw_orderdetail b')->where($map2)->sum('oddt_qty'); 
			if($nodsum){

			}else{
				$nodsum=0;
				$nodqtysum=0;
			}

			$Model=M();
			//第一级团队业绩
			$fistteamsum=0;   
			$fistteamqtysum=0;    
			$secondteamsum=0;   
			$secondteamqtysum=0;    
			$map2=array();
			$map2['dl_unitcode']=$this->qy_unitcode;
			$map2['dl_belong']=$dl_belong;
			$map2['dl_referee']=session('jxuser_id');
			$map2['dl_level']=$dlt_level;
			$list2 = $Dealer->where($map2)->order('dl_id DESC')->select();
			foreach($list2 as $kk=>$vv){
				$dl2_id=$vv['dl_id'];
				$map2=array();
				$map2['a.od_oddlid']=$dl2_id;
				$map2['a.od_unitcode']=$this->qy_unitcode;
				$map2['a.od_state']=array('IN','3,8');
				$map2['a.od_virtualstock']=1;
				$map2['a.od_fugou']=1;
				$map2['a.od_expressdate']=array('between',array($nbegintime,$nendtime));
				$map2['a.od_id']=array('exp','=b.oddt_odid');
				$map2['a.od_orderid']=array('exp','=b.oddt_orderid');
				$nodsum2 = $Model->table('fw_orders a,fw_orderdetail b')->where($map2)->sum('od_total'); 
				$nodqtysum2 = $Model->table('fw_orders a,fw_orderdetail b')->where($map2)->sum('oddt_qty'); 
				if($nodsum2){
					$fistteamsum+=$nodsum2;
					$fistteamqtysum+=$nodqtysum2;
				}
				$map3=array();
				$map3['dl_unitcode']=$this->qy_unitcode;
				$map3['dl_belong']=$dl_belong;
				$map3['dl_referee']=$dl2_id;
				$map2['dl_level']=$dlt_level;
				$list3 = $Dealer->where($map3)->order('dl_id DESC')->select();
				foreach($list3 as $k3=>$v3){
					$dl3_id=$v3['dl_id'];
					$map2=array();
					$map2['a.od_oddlid']=$v3['dl_id'];
					$map2['a.od_unitcode']=$this->qy_unitcode;
					$map2['a.od_state']=array('IN','3,8');
					$map2['a.od_virtualstock']=1;
					$map2['a.od_fugou']=1;
					$map2['a.od_expressdate']=array('between',array($nbegintime,$nendtime));
					$map2['a.od_id']=array('exp','=b.oddt_odid');
					$map2['a.od_orderid']=array('exp','=b.oddt_orderid');
					$nodsum3 =$Model->table('fw_orders a,fw_orderdetail b')->where($map2)->sum('od_total'); 
					$nodqtysum3 =$Model->table('fw_orders a,fw_orderdetail b')->where($map2)->sum('oddt_qty'); 
					if($nodsum3){
						$secondteamsum+=$nodsum3;
						$secondteamqtysum+=$nodqtysum3;
					}
				}
			}

			$nsalesum=$nodsum+$fistteamsum+$secondteamsum;
			$nsaleqtysum=$nodqtysum+$fistteamqtysum+$secondteamqtysum;

			if ($yj_type==0)
			{

				//计算生成业绩及奖金 begin 前3个月
				$map2=array();
				$map2['smfr_unitcode']=$this->qy_unitcode;
				$map2['smfr_dltype']=$dlt_type;
				$map2['smfr_countdate']=1; //按月奖励
	            $fanlilist = $Salemonfanlirate->where($map2)->order('smfr_minsale ASC')->select();
				
				$yearmonth=date('Y-m',time()); //当前年月
				$yearlist=array();

				// $yearlist[]=strtotime("$nyearmonth 0 month");
				$yearlist[]=strtotime("$nyearmonth -1 month");
				$yearlist[]=strtotime("$nyearmonth -2 month");
				$yearlist[]=strtotime("$nyearmonth -3 month");
				
				foreach($yearlist as $k=>$v){
				    if($v<$yearmonth&&$v!==FALSE){
						$map7=array();
						$data7=array();
						$map7['sm_unitcode'] = $this->qy_unitcode;
						$map7['sm_dlid'] = session('jxuser_id');
						$map7['sm_date'] = $v;
						$map7['sm_yjtype'] =0;
						$data7 = $Salemonthly->where($map7)->find();
						if(!$data7){
							if(date('d',time())>=1){//当月1号后才允许生成
								$days=date("t",$v); //天数
								$nbegintime=strtotime(date('Y-m-01 00:00:00',$v));
								//$nendtime=strtotime(date('Y-m-d H:i:s',$v));
								$nendtime=$nbegintime+3600*24*$days;

								// var_dump(date('Y-m-d H:i:s',$nbegintime));
								// var_dump(date('Y-m-d H:i:s',$nendtime));
								//自己的业绩
								//下单的金额(只统计已发货、已完成) 
								$odsum=0;
								$map2=array();
								$map2['a.od_oddlid']=session('jxuser_id');
								$map2['a.od_unitcode']=$this->qy_unitcode;
								$map2['a.od_state']=array('IN','3,8');
								$map2['a.od_virtualstock']=1;
								$map2['a.od_fugou']=1;
								$map2['a.od_expressdate']=array('between',array($nbegintime,$nendtime));
								$map2['a.od_id']=array('exp','=b.oddt_odid');
								$map2['a.od_orderid']=array('exp','=b.oddt_orderid');
								$odsum =$Model->table('fw_orders a,fw_orderdetail b')->where($map2)->sum('od_total'); 
								$odqtysum =$Model->table('fw_orders a,fw_orderdetail b')->where($map2)->sum('oddt_qty'); 
								if($odsum){

								}else{
									$odsum=0;
									$odqtysum=0;
								}
								// var_dump($odsum);
								// exit;
								//团队业绩
								//第一级团队业绩
								$fistodsum=0;
								$fistodqtysum=0;    
								$secondodsum=0;      
								$secondodqtysum=0;    
								$map2=array();
								$map2['dl_unitcode']=$this->qy_unitcode;
								$map2['dl_belong']=$dl_belong;
								$map2['dl_referee']=session('jxuser_id');
								$map2['dl_level']=$dlt_level;
								$list2 = $Dealer->where($map2)->order('dl_id DESC')->select();
								foreach($list2 as $kk=>$vv){
									$dl2_id=$vv['dl_id'];
									$map2=array();
									$map2['a.od_oddlid']=$dl2_id;
									$map2['a.od_unitcode']=$this->qy_unitcode;
									$map2['a.od_state']=array('IN','3,8');
									$map2['a.od_virtualstock']=1;
									$map2['a.od_fugou']=1;
									$map2['a.od_expressdate']=array('between',array($nbegintime,$nendtime));
									$map2['a.od_id']=array('exp','=b.oddt_odid');
									$map2['a.od_orderid']=array('exp','=b.oddt_orderid');
									$odsum2 =$Model->table('fw_orders a,fw_orderdetail b')->where($map2)->sum('od_total'); 
									$odqtysum2 =$Model->table('fw_orders a,fw_orderdetail b')->where($map2)->sum('oddt_qty'); 
									if($odsum2){
										$fistodsum+=$odsum2;
										$fistodqtysum+=$odqtysum2;
									}
									//第二级团队业绩
									$map3=array();
									$map3['dl_unitcode']=$this->qy_unitcode;
									$map3['dl_belong']=$dl_belong;
									$map3['dl_referee']=$dl2_id;
									$map2['dl_level']=$dlt_level;
									$list3 = $Dealer->where($map3)->order('dl_id DESC')->select();
									foreach($list3 as $k3=>$v3){
										$dl3_id=$v3['dl_id'];
										$map2=array();
										$map2['a.od_oddlid']=$dl3_id;
										$map2['a.od_unitcode']=$this->qy_unitcode;
										$map2['a.od_state']=array('IN','3,8');
										$map2['a.od_virtualstock']=1;
										$map2['a.od_fugou']=1;
										$map2['a.od_expressdate']=array('between',array($nbegintime,$nendtime));
										$map2['a.od_id']=array('exp','=b.oddt_odid');
										$map2['a.od_orderid']=array('exp','=b.oddt_orderid');
										$odsum3 =$Model->table('fw_orders a,fw_orderdetail b')->where($map2)->sum('od_total'); 
										$odqtysum3 =$Model->table('fw_orders a,fw_orderdetail b')->where($map2)->sum('oddt_qty'); 
										if($odsum3){
											$secondodsum+=$odsum3;
											$secondodqtysum+=$odqtysum3;
										}
									}
								}
							
								//奖金计算
								$saletotal=$odsum+$fistodsum+$secondodsum;
								$saleqtytotal=$odqtysum+$fistodqtysum+$secondodqtysum;

								$dl_reward=0;
								$dl_reward0=0;
								$dl_reward1=0;
								$dl_reward2=0;
								foreach($fanlilist as $kkk=>$vvv){
									if ($vvv['smfr_saleunit']==1)
									{
										if($saletotal>=$vvv['smfr_minsale'] && $saletotal<$vvv['smfr_maxsale']){
											if($vvv['smfr_fanlieval']==1){
												$dl_reward=$vvv['smfr_fanlirate'];
											}else {
												$dl_reward0=$odsum*$vvv['smfr_fanlirate'];
												$dl_reward1=$fistodsum*0.03;
												$dl_reward2=$secondodsum*0.02;
												$dl_reward=$dl_reward0+$dl_reward1+$$dl_reward2;
											}
										}
									}
									else
									{
										if($saleqtytotal>=$vvv['smfr_minsale'] && $saleqtytotal9<$vvv['smfr_maxsale']){
											if($vvv['smfr_fanlieval']==1){
												$dl_reward=$vvv['smfr_fanlirate'];
											}else {
												$dl_reward=$saleqtytotal*$vvv['smfr_fanlirate'];
											}
										}
									}	
								}
								//写入返利
								//发款方
								// if($dl_referee>0){
								// 	$map2=array();
								// 	$map2['dl_unitcode'] = $this->qy_unitcode;
								// 	$map2['dl_id'] = $dl_referee;
								// 	$map2['dl_type'] = $dl_type;
								// 	$data22 = $Dealer->where($map2)->find();
								// 	if($data22){
								// 		$sm_senddlid = $dl_referee;  
								// 	}else{
								// 		$sm_senddlid=0;  
								// 	}
								// }else{
								// 	$sm_senddlid=0;  
								// }
								
								// //如果有销售有奖金
						        if($odsum>0 && ($fistodsum>0 || $secondodsum>0) && $dl_reward>0){
						        	if ($dl_reward0>0)
						        	{
										$data5=array();
										$data5['fl_unitcode'] = $this->qy_unitcode;
										$data5['fl_dlid'] = session('jxuser_id'); //获得返利的代理
										$data5['fl_senddlid'] =0 ; //$sm_senddlid发放返利的代理
										$data5['fl_type'] = 4; //返利分类 1-推荐返利 2-订单返利 3-销售累计奖 4-按月销售奖 5按年度销售奖 11-提现减少返利 (1-10 增加返利 11-20 减少返利)  
										$data5['fl_money'] = $dl_reward0;
										$data5['fl_refedlid'] = 0; //推荐返利中被推荐的代理
										$data5['fl_oddlid'] = 0; //订单返利中 下单的代理
										$data5['fl_odid'] = 0;  //订单返利中 订单流水id
										$data5['fl_orderid']  = ''; //订单返利中 订单id
										$data5['fl_proid']  = 0;  //订单返利中 产品id
										$data5['fl_odblid']  = 0;  //订单返利中 订单关系id
										$data5['fl_qty']  = 0;  //订单返利中 产品数量
										$data5['fl_level']  = 0;  //返利的层次，0-自己的返利 1-第一层返利 2-第二层返利 
										$data5['fl_addtime']  = time();
										$data5['fl_remark'] ='我的'.date('Y年m月',$v).'销售奖:'.$dl_reward0;
										$rs5=$Fanlidetail->create($data5,1);
										if($rs5){
											$rsid=$Fanlidetail->add();
											if($rsid){
												//按月销售奖记录
												$data5=array();
												$data5['sm_unitcode'] = $this->qy_unitcode;
												$data5['sm_dlid'] = session('jxuser_id');
												$data5['sm_senddlid'] = $sm_senddlid;
												$data5['sm_mysale'] = $odsum;
												$data5['sm_teamsale'] = $fistodsum+$secondodsum;
												$data5['sm_reward'] = $dl_reward0;
												$data5['sm_date'] = $v;
												$data5['sm_addtime'] = time();
												$data5['sm_flid'] = $rsid;
												$data5['sm_state'] = 1;
												$data5['sm_type'] = 0; //0、总业绩1、一级团队 2、二级团队
												$data5['sm_yjtype'] = 0;
												$data5['sm_remark'] = '我的'.date('Y年m月',$v).'销售业绩返利：'.$dl_reward;
												$Salemonthly->create($data5,1);
												$Salemonthly->add();
											}
										}
									}

									if ($dl_reward1>0)
						        	{
										$data5=array();
										$data5['fl_unitcode'] = $this->qy_unitcode;
										$data5['fl_dlid'] = session('jxuser_id'); //获得返利的代理
										$data5['fl_senddlid'] =0 ; //$sm_senddlid发放返利的代理
										$data5['fl_type'] = 4; //返利分类 1-推荐返利 2-订单返利 3-销售累计奖 4-按月销售奖 5按年度销售奖 11-提现减少返利 (1-10 增加返利 11-20 减少返利)  
										$data5['fl_money'] = $dl_reward1;
										$data5['fl_refedlid'] = 0; //推荐返利中被推荐的代理
										$data5['fl_oddlid'] = 0; //订单返利中 下单的代理
										$data5['fl_odid'] = 0;  //订单返利中 订单流水id
										$data5['fl_orderid']  = ''; //订单返利中 订单id
										$data5['fl_proid']  = 0;  //订单返利中 产品id
										$data5['fl_odblid']  = 0;  //订单返利中 订单关系id
										$data5['fl_qty']  = 0;  //订单返利中 产品数量
										$data5['fl_level']  = 1;  //返利的层次，0-自己的返利 1-第一层返利 2-第二层返利 
										$data5['fl_addtime']  = time();
										$data5['fl_remark'] ='第一团队'.date('Y年m月',$v).'销售奖:'.$dl_reward1;
										$rs5=$Fanlidetail->create($data5,1);
										if($rs5){
											$rsid=$Fanlidetail->add();
											if($rsid){
												//按月销售奖记录
												$data5=array();
												$data5['sm_unitcode'] = $this->qy_unitcode;
												$data5['sm_dlid'] = session('jxuser_id');
												$data5['sm_senddlid'] = $sm_senddlid;
												$data5['sm_mysale'] = $odsum;
												$data5['sm_teamsale'] = $fistodsum;
												$data5['sm_reward'] = $dl_reward1;
												$data5['sm_date'] = $v;
												$data5['sm_addtime'] = time();
												$data5['sm_flid'] = $rsid;
												$data5['sm_state'] = 1;
												$data5['sm_type'] = 1;
												$data5['sm_yjtype'] = 0;
												$data5['sm_remark'] = '第一团队'.date('Y年m月',$v).'销售业绩返利：'.$dl_reward1;
												$Salemonthly->create($data5,1);
												$Salemonthly->add();
											}
										}
									}


									if ($dl_reward2>0)
						        	{
										$data5=array();
										$data5['fl_unitcode'] = $this->qy_unitcode;
										$data5['fl_dlid'] = session('jxuser_id'); //获得返利的代理
										$data5['fl_senddlid'] =0 ; //$sm_senddlid发放返利的代理
										$data5['fl_type'] = 4; //返利分类 1-推荐返利 2-订单返利 3-销售累计奖 4-按月销售奖 5按年度销售奖 11-提现减少返利 (1-10 增加返利 11-20 减少返利)  
										$data5['fl_money'] = $dl_reward2;
										$data5['fl_refedlid'] = 0; //推荐返利中被推荐的代理
										$data5['fl_oddlid'] = 0; //订单返利中 下单的代理
										$data5['fl_odid'] = 0;  //订单返利中 订单流水id
										$data5['fl_orderid']  = ''; //订单返利中 订单id
										$data5['fl_proid']  = 0;  //订单返利中 产品id
										$data5['fl_odblid']  = 0;  //订单返利中 订单关系id
										$data5['fl_qty']  = 0;  //订单返利中 产品数量
										$data5['fl_level']  = 2;  //返利的层次，0-自己的返利 1-第一层返利 2-第二层返利 
										$data5['fl_addtime']  = time();
										$data5['fl_remark'] ='第二团队'.date('Y年m月',$v).'销售奖:'.$dl_reward2;
										$rs5=$Fanlidetail->create($data5,1);
										if($rs5){
											$rsid=$Fanlidetail->add();
											if($rsid){
												//按月销售奖记录
												$data5=array();
												$data5['sm_unitcode'] = $this->qy_unitcode;
												$data5['sm_dlid'] = session('jxuser_id');
												$data5['sm_senddlid'] = $sm_senddlid;
												$data5['sm_mysale'] = $odsum;
												$data5['sm_teamsale'] =$secondodsum;
												$data5['sm_reward'] = $dl_reward2;
												$data5['sm_date'] = $v;
												$data5['sm_addtime'] = time();
												$data5['sm_flid'] = $rsid;
												$data5['sm_state'] = 1;
												$data5['sm_type'] = 2;
												$data5['sm_yjtype'] = 0;
												$data5['sm_remark'] = '第二团队'.date('Y年m月',$v).'销售业绩返利：'.$dl_reward2;
												$Salemonthly->create($data5,1);
												$Salemonthly->add();
											}
										}
									}
									
								}else if($odsum>0 && ($fistodsum>0 || $secondodsum>0) && $dl_reward==0){ //有销售额 无奖金
									//按月销售奖记录
									$data5=array();
									$data5['sm_unitcode'] = $this->qy_unitcode;
									$data5['sm_dlid'] = session('jxuser_id');
									$data5['sm_senddlid'] = $sm_senddlid;
									$data5['sm_mysale'] = $odsum;
									$data5['sm_teamsale'] = $fistodsum+$secondodsum;
									$data5['sm_reward'] = 0;
									$data5['sm_date'] = $v;
									$data5['sm_addtime'] = time();
									$data5['sm_flid'] = 0;
									$data5['sm_state'] = 1;
									$data5['sm_type'] = 0;
									$data5['sm_yjtype'] = 0;
									$data5['sm_remark'] = '我的团队'.date('Y年m月',$v).'销售业绩返利：0,没达到返利销售额';
									$Salemonthly->create($data5,1);
									$Salemonthly->add();
								}
							}	
						}
					}
				}
				//计算生成业绩及奖金 end
			}else
			{		
				//计算生成总销量业绩及奖金 begin
				$Salemonfanlirate= M('Salemonfanlirate');
				$map2=array();
				$map2['smfr_unitcode']=$this->qy_unitcode;
				$map2['smfr_dltype']=$dlt_type;
				$map2['smfr_countdate']=2; //按年总销量
	            $fanlilist = $Salemonfanlirate->where($map2)->order('smfr_minsale ASC')->select();


	            //已经计算返利的时间   
	            $t = time(); 
				// $ystar = mktime(0,0,0,date('m',$t),date('d',$t),date('Y',$t)); //今年起点时间戳
				$yend = mktime(23,59,59,12,31,date('Y',$t)); //今年终点时间戳
	            $map2=array();
				$map2['fl_unitcode'] = $this->qy_unitcode;
				$map2['fl_dlid'] = session('jxuser_id'); //获得返利的代理
				$map2['fl_senddlid'] =0 ; //$sm_senddlid发放返利的代理
				$map2['fl_type'] = 3; //返利分类 1-推荐返利 2-订单返利 3-销售累计奖 4-按月销售奖 5按年度销售奖 11-提现减少返利 (1-10 增加返利 11-20 减少返利) 
				$map2['fl_state'] =array('in','1,2');//待收和已收;
				$rs2=$Fanlidetail->where($map2)->order('fl_addtime DESC')->find();
				if ($rs2)
				{
					$ystar=$rs2['fl_addtime'];
				}

	            //自己的业绩
				//下单的金额(只统计已发货、已完成) 
				$odsum=0;
				$map2=array();
				$map2['a.od_oddlid']=session('jxuser_id');
				$map2['a.od_unitcode']=$this->qy_unitcode;
				$map2['a.od_state']=array('IN','3,8');
				$map2['a.od_virtualstock']=1;
				$map2['a.od_fugou']=1;
				if (is_not_null($ystar))
					$map2['a.od_expressdate']=array('between',array($ystar,$yend));
				else
					$map2['a.od_expressdate']=array('elt',strtotime('now'));
				$map2['a.od_id']=array('exp','=b.oddt_odid');
				$map2['a.od_orderid']=array('exp','=b.oddt_orderid');
				$odsum=$Model->table('fw_orders a,fw_orderdetail b')->where($map2)->sum('od_total'); 
				$odqtysum =$Model->table('fw_orders a,fw_orderdetail b')->where($map2)->sum('oddt_qty'); 
				if($odsum){

				}else{
					$odsum=0;
					$odqtysum=0;
				}
				// var_dump($odsum);
				// exit;
				//团队业绩
				//第一级团队业绩
				$fistodsum=0; 
				$fistodqtysum=0;    
				$secondodsum=0;   
				$secondodqtysum=0;    
				$map2=array();
				$map2['dl_unitcode']=$this->qy_unitcode;
				$map2['dl_belong']=$dl_belong;
				$map2['dl_referee']=session('jxuser_id');
				$map2['dl_level']=$dlt_level;
				$list2 = $Dealer->where($map2)->order('dl_id DESC')->select();
				foreach($list2 as $kk=>$vv){
					$dl2_id=$vv['dl_id'];
					$map2=array();
					$map2['a.od_oddlid']=$dl2_id;
					$map2['a.od_unitcode']=$this->qy_unitcode;
					$map2['a.od_state']=array('IN','3,8');
					$map2['a.od_virtualstock']=1;
					$map2['a.od_fugou']=1;
					if (is_not_null($ystar))
						$map2['a.od_expressdate']=array('between',array($ystar,$yend));
					else
						$map2['a.od_expressdate']=array('elt',strtotime('now'));
					$map2['a.od_id']=array('exp','=b.oddt_odid');
					$map2['a.od_orderid']=array('exp','=b.oddt_orderid');
					$odsum2=$Model->table('fw_orders a,fw_orderdetail b')->where($map2)->sum('od_total'); 
					$odqtysum2 =$Model->table('fw_orders a,fw_orderdetail b')->where($map2)->sum('oddt_qty'); 
					if($odsum2){
						$fistodsum+=$odsum2;
						$fistodqtysum+=$odqtysum2;
					}
					//第二级团队业绩
					$map3=array();
					$map3['dl_unitcode']=$this->qy_unitcode;
					$map3['dl_belong']=$dl_belong;
					$map3['dl_referee']=$dl2_id;
					$map2['dl_level']=$dlt_level;
					$list3 = $Dealer->where($map3)->order('dl_id DESC')->select();
					foreach($list3 as $k3=>$v3){
						$dl3_id=$v3['dl_id'];
						$map2=array();
						$map2['a.od_oddlid']=$dl3_id;
						$map2['a.od_unitcode']=$this->qy_unitcode;
						$map2['a.od_state']=array('IN','3,8');
						$map2['a.od_virtualstock']=1;
						$map2['a.od_fugou']=1;
						if (is_not_null($ystar))
							$map2['a.od_expressdate']=array('between',array($ystar,$yend));
						else
							$map2['a.od_expressdate']=array('elt',strtotime('now'));
						$odsum3=$Model->table('fw_orders a,fw_orderdetail b')->where($map2)->sum('od_total'); 
						$odqtysum3 =$Model->table('fw_orders a,fw_orderdetail b')->where($map2)->sum('oddt_qty'); 
						if($odsum3){
							$secondodsum+=$odsum3;
							$secondodqtysum+=$odqtysum3;
						}
					}
				}


	            $dl_reward=0;
	           //奖金计算
				$saletotal=$odsum+$fistodsum+$secondodsum;
				$saleqtyotal=$odqtysum+$fistodqtysum+$secondodqtysum;
				$dl_reward=0;
				foreach($fanlilist as $kkk=>$vvv){
					if ($vvv['smfr_saleunit']==1)
					{
						if($saletotal>=$vvv['smfr_minsale'] && $saletotal<$vvv['smfr_maxsale']){
							if($vvv['smfr_fanlieval']==1){
								$dl_reward+=$vvv['smfr_fanlirate'];
							}else {
								$dl_reward=$odsum*$vvv['smfr_fanlirate'];
							}
						}
					}
					else
					{
						if($saleqtyotal>=$vvv['smfr_minsale'] && $saleqtyotal<$vvv['smfr_maxsale']){
							if($vvv['smfr_fanlieval']==1){
								$dl_reward=$vvv['smfr_fanlirate'];
							}else {
								$dl_reward=$saleqtyotal*$vvv['smfr_fanlirate'];
							}
						}
					}	
				}

				$map7=array();
				$data7=array();
				$map7['sm_unitcode'] = $this->qy_unitcode;
				$map7['sm_dlid'] = session('jxuser_id');
				if (is_not_null($ystar))
					$map7['sm_date']=array('between',array($ystar,$yend));
				else
					$map7['sm_date']=array('elt',strtotime('now'));
				$map7['sm_jytype'] =2; //年度销售奖
				$data7 = $Salemonthly->where($map7)->find();
				if(!$data7){
					if ($saletotal>0 && $dl_reward>0){
						$data5=array();
						$data5['fl_unitcode'] = $this->qy_unitcode;
						$data5['fl_dlid'] = session('jxuser_id'); //获得返利的代理
						$data5['fl_senddlid'] =0 ; //$sm_senddlid发放返利的代理
						$data5['fl_type'] = 3; //返利分类 1-推荐返利 2-订单返利 3-销售累计奖 4-按月销售奖 5按年度销售奖 11-提现减少返利 (1-10 增加返利 11-20 减少返利)  
						$data5['fl_money'] = $dl_reward;
						$data5['fl_refedlid'] = 0; //推荐返利中被推荐的代理
						$data5['fl_oddlid'] = 0; //订单返利中 下单的代理
						$data5['fl_odid'] = 0;  //订单返利中 订单流水id
						$data5['fl_orderid']  = ''; //订单返利中 订单id
						$data5['fl_proid']  = 0;  //订单返利中 产品id
						$data5['fl_odblid']  = 0;  //订单返利中 订单关系id
						$data5['fl_qty']  = 0;  //订单返利中 产品数量
						$data5['fl_level']  = 0;  //返利的层次，0-自己的返利 1-第一层返利 2-第二层返利 
						$data5['fl_addtime']  =time();
						if (is_not_null($ystar))
							$data5['fl_remark'] ='我的'.date('Y年m月d日 h:i:s',$ystar).'至'.date('Y年m月d日 h:i:s',time()).'销售累计奖:'.$dl_reward;
						else
							$data5['fl_remark'] ='我的'.date('Y年m月d日',time()).'销售累计奖:'.$dl_reward;
						$rs5=$Fanlidetail->create($data5,1);
						if($rs5){
							$rsid=$Fanlidetail->add();
							if($rsid){
								//按月销售奖记录
								$data5=array();
								$data5['sm_unitcode'] = $this->qy_unitcode;
								$data5['sm_dlid'] = session('jxuser_id');
								$data5['sm_senddlid'] = $sm_senddlid;
								$data5['sm_mysale'] = $odsum;
								$data5['sm_teamsale'] = $fistodsum+$secondodsum;
								$data5['sm_reward'] = $dl_reward;
								$data5['sm_date'] =time();
								$data5['sm_addtime'] =time();
								$data5['sm_flid'] = $rsid;
								$data5['sm_state'] = 1;
								$data5['sm_type'] = 0; //0、总业绩1、一级团队 2、二级团队
								$data5['sm_yjtype'] = 2; //0月 1年 2 总
								if (is_not_null($ystar))
									$data5['sm_remark'] ='我的'.date('Y年m月d日 h:i:s',$ystar).'至'.date('Y年m月d日 h:i:s',time()).'销售累计奖:'.$dl_reward;
								else
									$data5['sm_remark'] ='我的'.date('Y年m月d日',time()).'销售累计奖:'.$dl_reward;
								$Salemonthly->create($data5,1);
								$Salemonthly->add();
							}
						}
					}else if($saletotal>0 && $dl_reward==0){ //有销售额 无奖金
						//按月销售奖记录
						$data5=array();
						$data5['sm_unitcode'] = $this->qy_unitcode;
						$data5['sm_dlid'] = session('jxuser_id');
						$data5['sm_senddlid'] = $sm_senddlid;
						$data5['sm_mysale'] = $odsum;
						$data5['sm_teamsale'] = $fistodsum+$secondodsum;
						$data5['sm_reward'] = 0;
						$data5['sm_date'] =time();
						$data5['sm_addtime'] = time();
						$data5['sm_flid'] = 0;
						$data5['sm_state'] = 1;
						$data5['sm_type'] = 0;//0、总业绩1、一级团队 2、二级团队
						$data5['sm_yjtype'] = 2;//0月 1年 2 总
					   if (is_not_null($ystar))
							$data5['sm_remark'] ='我的'.date('Y年m月d日 h:i:s',$ystar).'至'.date('Y年m月d日 h:i:s',time()).'销售累计业绩返利：0,没达到返利销售额';
						else
							$data5['sm_remark'] ='我的'.date('Y年m月d日',time()).'销售累计业绩返利：0,没达到返利销售额';
						$Salemonthly->create($data5,1);
						$Salemonthly->add();
					}
				}else
				{
					// var_dump($saletotal.'00000000');
					if ($saletotal>0 && $dl_reward>0){
							//更新累计奖
							$dataupdate=array();
							$dataupdate['sm_mysale'] = $dl_reward;
							$dataupdate['sm_teamsale'] = $fistodsum+$secondodsum;
							$dataupdate['sm_reward'] =$sm_reward;
							$dataupdate['sm_date'] =time();
							$dataupdate['sm_addtime'] = time();
							if (is_not_null($ystar))
								$dataupdate['sm_remark'] ='我的'.date('Y年m月d日 h:i:s',$ystar).'至'.date('Y年m月d日 h:i:s',time()).'销售累计奖:'.$dl_reward;
							else
								$dataupdate['sm_remark'] ='我的'.date('Y年m月d日',time()).'销售累计奖:'.$dl_reward;
							$Salemonthly->where($map7)->data($dataupdate)->save();

							//返利;
							$map2=array();
							$map2['fl_unitcode'] = $this->qy_unitcode;
							$map2['fl_dlid'] = session('jxuser_id'); //获得返利的代理
							$map2['fl_senddlid'] =0 ; //$sm_senddlid发放返利的代理
							$map2['fl_type'] = 3; //返利分类 1-推荐返利 2-订单返利 3-销售累计奖 4-按月销售奖 5按年度销售奖 11-提现减少返利 (1-10 增加返利 11-20 减少返利) 
							$map2['fl_state'] =0; //待收和已收;
							$rs2=$Fanlidetail->where($map2)->order('fl_addtime DESC')->find();
							if ($rs2)
							{
								//更新返利;
								$dataupdate=array();
								$dataupdate['fl_money'] =$dl_reward;
								$dataupdate['fl_addtime']  = time();
								if (is_not_null($ystar))
									$dataupdate['fl_remark'] ='我的'.date('Y年m月d日 h:i:s',$ystar).'至'.date('Y年m月d日 h:i:s',time()).'销售累计奖:'.$dl_reward;
								else
									$dataupdate['fl_remark'] ='我的'.date('Y年m月d日',time()).'销售累计奖:'.$dl_reward;
								$Fanlidetail->where($map2)->data($dataupdate)->save();
							}else{
								$data5=array();
								$data5['fl_unitcode'] = $this->qy_unitcode;
								$data5['fl_dlid'] = session('jxuser_id'); //获得返利的代理
								$data5['fl_senddlid'] =0 ; //$sm_senddlid发放返利的代理
								$data5['fl_type'] = 3; //返利分类 1-推荐返利 2-订单返利 3-销售累计奖 4-按月销售奖 5按年度销售奖 11-提现减少返利 (1-10 增加返利 11-20 减少返利)  
								$data5['fl_money'] = $dl_reward;
								$data5['fl_refedlid'] = 0; //推荐返利中被推荐的代理
								$data5['fl_oddlid'] = 0; //订单返利中 下单的代理
								$data5['fl_odid'] = 0;  //订单返利中 订单流水id
								$data5['fl_orderid']  = ''; //订单返利中 订单id
								$data5['fl_proid']  = 0;  //订单返利中 产品id
								$data5['fl_odblid']  = 0;  //订单返利中 订单关系id
								$data5['fl_qty']  = 0;  //订单返利中 产品数量
								$data5['fl_level']  = 0;  //返利的层次，0-自己的返利 1-第一层返利 2-第二层返利 
								$data5['fl_addtime']  =time();
								if (is_not_null($ystar))
									$data5['fl_remark'] ='我的'.date('Y年m月d日 h:i:s',$ystar).'至'.date('Y年m月d日 h:i:s',time()).'销售累计奖:'.$dl_reward;
								else
									$data5['fl_remark'] ='我的'.date('Y年m月d日',time()).'销售累计奖:'.$dl_reward;
								$rs5=$Fanlidetail->create($data5,1);
								if($rs5){
									$rsid=$Fanlidetail->add();
									// if($rsid){
									// 	//按月销售奖记录
									// 	$data5=array();
									// 	$data5['sm_unitcode'] = $this->qy_unitcode;
									// 	$data5['sm_dlid'] = session('jxuser_id');
									// 	$data5['sm_senddlid'] = $sm_senddlid;
									// 	$data5['sm_mysale'] = $odsum;
									// 	$data5['sm_teamsale'] = $fistodsum+$secondodsum;
									// 	$data5['sm_reward'] = $dl_reward0;
									// 	$data5['sm_date'] =$yend;
									// 	$data5['sm_addtime'] = time();
									// 	$data5['sm_flid'] = $rsid;
									// 	$data5['sm_state'] = 1;
									// 	$data5['sm_type'] = 0; //0、总业绩1、一级团队 2、二级团队
									// 	$data5['sm_yjtype'] = 2; //0月 1年 2 总
									// 	$data5['sm_remark'] = '我的'.date('Y年m月d日',time().'销售累计奖返利：'.$dl_reward;
									// 	$Salemonthly->create($data5,1);
									// 	$Salemonthly->add();
									// }
								}
							}
					}else if($saletotal>0 && $dl_reward==0){ //有销售额 无奖金
						//更新累计奖
						$dataupdate=array();
						$dataupdate['sm_mysale'] = $odsum;
						$dataupdate['sm_teamsale'] = $fistodsum+$secondodsum;
						$dataupdate['sm_reward'] =$sm_reward;
						$dataupdate['sm_date'] =time();
						$dataupdate['sm_addtime'] = time();
					    if (is_not_null($ystar))
							$data5['sm_remark'] ='我的'.date('Y年m月d日 h:i:s',$ystar).'至'.date('Y年m月d日 h:i:s',time()).'销售累计业绩返利：0,没达到返利销售额';
						else
							$data5['sm_remark'] ='我的'.date('Y年m月d日',time()).'销售累计业绩返利：0,没达到返利销售额';
						$Salemonthly->where($map7)->data($dataupdate)->save();
					}
				}
				//计算生成总销量业绩及奖金 end
			}

			
			//列表
			$map=array();
			$parameter=array();
			$map['sm_unitcode']=$this->qy_unitcode;
			$map['sm_dlid']=session('jxuser_id');   
			$map['sm_yjtype']=$yj_type;
			$count = $Salemonthly->where($map)->count();
			$Page = new \Think\Page($count,50,$parameter);
			$show = $Page->show();
			if($show=='<div>    </div>'){
				$show='';
			}
			$list = $Salemonthly->where($map)->order('sm_id DESC')->limit(($Page->firstRow . ',') . $Page->listRows)->select();
			
			$Dealer= M('Dealer');
			foreach($list as $k=>$v){ 
				$list[$k]['sm_rewardstr']='<span style="color:#009900">'.number_format($v['sm_reward'],2,'.','').'</span>';
			}
		}else{
			if ($dlt_level==1)
			{
				//计算生成业绩及奖金 begin 前3年
				$map2=array();
				$map2['smfr_unitcode']=$this->qy_unitcode;
				$map2['smfr_dltype']=$dlt_type;
				$map2['smfr_countdate']=2; //按月奖励
	            $fanlilist = $Salemonfanlirate->where($map2)->order('smfr_minsale ASC')->select();
				
				$year=date('Y',time()); //当前年月
				$yearlist=array();

				// $yearlist[]=strtotime("$year 0 year");
				$yearlist[]=strtotime("$year -1 year");
				$yearlist[]=strtotime("$year -2 year");
				$yearlist[]=strtotime("$year -3 year");

				foreach($yearlist as $k=>$v){
				    if($v<$year&&$v!==FALSE){
						$map7=array();
						$data7=array();
						$map7['sm_unitcode'] = $this->qy_unitcode;
						$map7['sm_dlid'] = session('jxuser_id');
						$map7['sm_date'] =$v;
						$map7['sm_yjtype'] =1;
						$data7 = $Salemonthly->where($map7)->find();
						if(!$data7){
							//自己的业绩
							//下单的金额(只统计已发货、已完成) 
							// $t = strtotime("-1 year"); 
							$t=$v; 
							$nbegintime = mktime(0,0,0,1,1,date('Y',$t));
							$nendtime = mktime(23,59,59,12,31,date('Y',$t)); 
							// var_dump(date('年起点 Y-m-d H:i:s',$nbegintime).$nbegintime);
							// var_dump(date('年终点 Y-m-d H:i:s',$nendtime).$nendtime);
							$Model=M();
							$odsum=0;
							$map2=array();
							$map2['a.od_oddlid']=session('jxuser_id');
							$map2['a.od_unitcode']=$this->qy_unitcode;
							$map2['a.od_state']=array('IN','3,8');
							$map2['a.od_virtualstock']=1;
							$map2['a.od_fugou']=1;
							$map2['a.od_expressdate']=array('between',array($nbegintime,$nendtime));
							$map2['a.od_id']=array('exp','=b.oddt_odid');
							$map2['a.od_orderid']=array('exp','=b.oddt_orderid');
							$odsum=$Model->table('fw_orders a,fw_orderdetail b')->where($map2)->sum('od_total'); 
							$odqtysum =$Model->table('fw_orders a,fw_orderdetail b')->where($map2)->sum('oddt_qty'); 
							$odsum = $Orders->where($map2)->sum('od_total'); 
							if($odsum){

							}else{
								$odsum=0;
								$odqtysum=0;
							}

							//奖金计算
							$saletotal=$odsum;
							$saleqtytotal=$odqtysum;
							$dl_reward=0;
							foreach($fanlilist as $kkk=>$vvv){
								if ($vvv['smfr_saleunit']==1)
								{
									if($saletotal>=$vvv['smfr_minsale'] && $saletotal<$vvv['smfr_maxsale']){
										if($vvv['smfr_fanlieval']==1){
											$dl_reward=$vvv['smfr_fanlirate'];
										}else {
											$dl_reward=$odsum*$vvv['smfr_fanlirate'];
										}
									}
								}
								else
								{
									if($saleqtytotal>=$vvv['smfr_minsale'] && $saleqtytotal<$vvv['smfr_maxsale']){
										if($vvv['smfr_fanlieval']==1){
											$dl_reward=$vvv['smfr_fanlirate'];
										}else {
											$dl_reward=$saleqtytotal*$vvv['smfr_fanlirate'];
										}
									}
								}	
							}
							//写入返利
							//发款方
							// if($dl_referee>0){
							// 	$map2=array();
							// 	$map2['dl_unitcode'] = $this->qy_unitcode;
							// 	$map2['dl_id'] = $dl_referee;
							// 	$map2['dl_type'] = $dl_type;
							// 	$data22 = $Dealer->where($map2)->find();
							// 	if($data22){
							// 		$sm_senddlid = $dl_referee;  
							// 	}else{
							// 		$sm_senddlid=0;  
							// 	}
							// }else{
							// 	$sm_senddlid=0;  
							// }
							// //如果有销售有奖金
					        if($odsum>0  && $dl_reward>0){
								$data5=array();
								$data5['fl_unitcode'] = $this->qy_unitcode;
								$data5['fl_dlid'] = session('jxuser_id'); //获得返利的代理
								$data5['fl_senddlid'] =0 ; //$sm_senddlid发放返利的代理
								$data5['fl_type'] = 5; //返利分类 1-推荐返利 2-订单返利 3-销售累计奖 4-按月销售奖 5按年度销售奖 11-提现减少返利 (1-10 增加返利 11-20 减少返利)  
								$data5['fl_money'] = $dl_reward;
								$data5['fl_refedlid'] = 0; //推荐返利中被推荐的代理
								$data5['fl_oddlid'] = 0; //订单返利中 下单的代理
								$data5['fl_odid'] = 0;  //订单返利中 订单流水id
								$data5['fl_orderid']  = ''; //订单返利中 订单id
								$data5['fl_proid']  = 0;  //订单返利中 产品id
								$data5['fl_odblid']  = 0;  //订单返利中 订单关系id
								$data5['fl_qty']  = 0;  //订单返利中 产品数量
								$data5['fl_level']  = 0;  //返利的层次，0-自己的返利 1-第一层返利 2-第二层返利 
								$data5['fl_addtime']  = time();
								$data5['fl_remark'] ='我的'.date('Y年',$v).'年度销售奖:'.$dl_reward;
								$rs5=$Fanlidetail->create($data5,1);
								if($rs5){
									$rsid=$Fanlidetail->add();
									if($rsid){
										//按月销售奖记录
										$data5=array();
										$data5['sm_unitcode'] = $this->qy_unitcode;
										$data5['sm_dlid'] = session('jxuser_id');
										$data5['sm_senddlid'] = $sm_senddlid;
										$data5['sm_mysale'] = $odsum;
										$data5['sm_teamsale'] = $odsum;
										$data5['sm_reward'] = $dl_reward;
										$data5['sm_date'] = $v;
										$data5['sm_addtime'] = time();
										$data5['sm_flid'] = $rsid;
										$data5['sm_state'] = 1;
										$data5['sm_type'] = 0; //0、总业绩1、一级团队 2、二级团队
										$data5['sm_yjtype'] = 1;
										$data5['sm_remark'] = '我的'.date('Y年',$v).'年度销售业绩返利：'.$dl_reward;
										$Salemonthly->create($data5,1);
										$Salemonthly->add();
									}
								}
							}else if($odsum>0 && $dl_reward==0){ //有销售额 无奖金
								//按月销售奖记录
								$data5=array();
								$data5['sm_unitcode'] = $this->qy_unitcode;
								$data5['sm_dlid'] = session('jxuser_id');
								$data5['sm_senddlid'] = $sm_senddlid;
								$data5['sm_mysale'] = $odsum;
								$data5['sm_teamsale'] = $odsum;
								$data5['sm_reward'] = 0;
								$data5['sm_date'] = $v;
								$data5['sm_addtime'] = time();
								$data5['sm_flid'] = 0;
								$data5['sm_state'] = 1;
								$data5['sm_type'] = 0;
								$data5['sm_yjtype'] = 1;
								$data5['sm_remark'] = '我的'.date('Y年m月',$v).'年度销售业绩返利：0,没达到返利销售额';
								$Salemonthly->create($data5,1);
								$Salemonthly->add();
							}
						}
					}
				}
				//计算生成业绩及奖金 end


				//列表
				$map=array();
				$parameter=array();
				$map['sm_unitcode']=$this->qy_unitcode;
				$map['sm_dlid']=session('jxuser_id');   
				$map['sm_yjtype']=$yj_type;
				$count = $Salemonthly->where($map)->count();
				$Page = new \Think\Page($count,50,$parameter);
				$show = $Page->show();
				if($show=='<div>    </div>'){
					$show='';
				}
				$list = $Salemonthly->where($map)->order('sm_id DESC')->limit(($Page->firstRow . ',') . $Page->listRows)->select();
				
				$Dealer= M('Dealer');
				foreach($list as $k=>$v){ 
					$list[$k]['sm_rewardstr']='<span style="color:#009900">'.number_format($v['sm_reward'],2,'.','').'</span>';
				}
			}
			else
			$this->error('对不起,没有该权限',U('Kangli/Fanli/index'),1);
		}
		
		$this->assign('title', $title);
		$this->assign('yj_type', $yj_type);
		$this->assign('nsalesum', $nsalesum);
		$this->assign('nodsum', $nodsum);
		$this->assign('fistteamsum', $fistteamsum);
		$this->assign('secondteamsum', $secondteamsum);
        $this->assign('list', $list);
        $this->assign('page', $show);
		$this->assign('pagecount', $count);
		
        $this->display('salemonthly');
	}	
	
	
	//按月业绩返利-详细
    public function salemonthlydetail(){
        if(!$this->is_jxuser_login()){
			$qy_fwkey=$this->qy_fwkey;
			$qy_fwsecret=$this->qy_fwsecret;
            $ttamp2=time();
		    $sture2=MD5($qy_fwkey.$ttamp2.$qy_fwsecret);
 			$tagpage='http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
			header('location:'.WWW_WEBROOT.'Kangli/Dealer/login/ttamp/'.$ttamp2.'/sture/'.$sture2.'/tagpage/'.base64_encode($tagpage).'');
        }
		//--------------------------------
		$yj_type=intval(I('get.yj_type',0)); //0、每月业绩1、年度业绩2、总业绩
		$map=array();
		$map['sm_id']=intval(I('get.sm_id',0));
		if($map['sm_id']>0){
			$Salemonthly= M('Salemonthly');
		    $Dealer= M('Dealer');
			
			$map['sm_unitcode']=$this->qy_unitcode;
			$map['sm_dlid']=session('jxuser_id');  
			$data = $Salemonthly->where($map)->find();
			if($data){
				//收款代理信息
				if($data['sm_dlid']>0){
					$map2=array();
					$map2['dl_id']=$data['sm_dlid'];
					$map2['dl_unitcode']=$this->qy_unitcode;
					$data2=$Dealer->where($map2)->find();
					if($data2){
						$data['dl_name_str']=$data2['dl_name'].'('.$data2['dl_username'].')';
					}else{
						$data['dl_name_str']='未知';
					}
				}else{
					$data['dl_name_str']='未知';
				}
				
				//付款代理信息
				if($data['sm_senddlid']>0){
					$map2=array();
					$map2['dl_id']=$data['sm_senddlid'];
					$map2['dl_unitcode']=$this->qy_unitcode;
					$data2=$Dealer->where($map2)->find();
					if($data2){
						$data['dl_sendname_str']=$data2['dl_name'].'('.$data2['dl_username'].')';
					}else{
						$data['dl_sendname_str']='未知';
					}
				}else{
					$data['dl_sendname_str']='总公司';
				}
			
			
			
			
			}else{
				$this->error('没有该记录','',1);
			}

		}else{
			$this->error('没有该记录','',1);
		}
		
		$this->assign('sminfo', $data);
		$this->assign('yj_type', $yj_type);
		$this->display('salemonthlydetail');
		
	}
	
}