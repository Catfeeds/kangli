<?php
namespace Klapi\Controller;
use Think\Controller;
use klapi\controller\BaseApiController;
class DealerController extends BaseApiController{
   protected $header;
	protected $params;
    protected $ImagePath;
	public function __construct($params = null)
    {
    	 parent::__construct($params);
    	 // $this->_initialize();//tp5.0
    	 $this->params = $params;
    	 $this->ImagePath='http://'.DLPATH;
    }
    public function index(){
		isset($this->params["userid"])?$user_id = $this->params["userid"]:$user_id = ''; //用户名
 		if(!$this->is_jxuser_login($user_id)){
			$this->err_get(5);
        }else
        {
        	//下级代理级别列表
        	$dlblongls=$this->dlblong_list_get();
        	//未审核代理列表
			$dealerls=$this->unreviewed_list_get();
			count($dealerls)>0?$dl_count=count($dealerls):$dl_count=0;
			$ret = array("dlblongls" =>$dlblongls,"dealerls"=>$dealerls,"dl_count"=>$dl_count);
        	return $ret;
        }
    }

	/**
	 * 获取下级代理级别列表
	 */
	public function dlblong_list_get(){
		//--------------------------------
		isset($this->params["userid"])?$user_id = $this->params["userid"]:$user_id = ''; //用户名
        $Dltype =M('Dltype');
        $Dealer =M('Dealer');
		$map=array();
		$data=array();
		$map['dlt_unitcode']=$this->qy_unitcode;
		$data = $Dltype->where($map)->field('dlt_id,dlt_name,dlt_level')->order('dlt_level ASC,dlt_id ASC')->select();
		foreach($data as $k=>$v){
			$map2=array();
			$count=0;
			$map2['dl_unitcode']=$this->qy_unitcode;
			$map2['dl_belong']=$user_id;
			$map2['dl_type']=$v['dlt_id'];
			$map2['dl_status']=1;
			$count = $Dealer->where($map2)->count();
			$data[$k]['count']=$count;
		}
		return $data;
	}

	/**
	 * 获取未审核代理列表
	 */
	public function unreviewed_list_get(){
		//未审核经销商
		isset($this->params["userid"])?$user_id = $this->params["userid"]:$user_id = ''; //用户名
		$Dltype =M('Dltype');
		$Dealer =M('Dealer');
		$map=array();
		$data=array();
		$map['dl_unitcode']=$this->qy_unitcode;
		$map['dl_belong']=$user_id;
		$map['dl_status']=0;
		$data= $Dealer->where($map)->field('dl_id,dl_name,dl_weixin,dl_wxheadimg,dl_tel,dl_address,dl_addtime,dl_level')->order('dl_id DESC')->select();
		foreach($data as $kk=>$vv){
			$map2=array();
			$map2['dlt_unitcode']=$this->qy_unitcode;
			$map2['dlt_level']=$vv['dl_level'];
			$data2 = $Dltype->where($map2)->order('dlt_level ASC,dlt_id ASC')->find();
			if ($data2)
			{
				$data[$kk]['dlt_name']=$data2['dlt_name'];
				if (is_not_null($data[$kk]['dl_wxheadimg']))
				{
					$data[$kk]['avatarUrl']=$this->ImagePath.$data2['dl_wxheadimg'];
				}else
				{
					$data[$kk]['avatarUrl']='';
				}
			}
		}
		return $data;
	}	

	/**
	 * 获取代理已推荐列表
	 */
	public function dealer_recommendls_get(){
		isset($this->params["userid"])?$user_id = $this->params["userid"]:$user_id = ''; //用户名
 		if(!$this->is_jxuser_login($user_id)){
			$this->err_get(5);
        }else
        {
        	//--------------------------------
			$Dltype =M('Dltype');
			$Dealer =M('Dealer');
			$map=array();
			$data=array();
			$map['dlt_unitcode']=$this->qy_unitcode;
			$data = $Dltype->where($map)->field('dlt_id,dlt_name,dlt_level')->order('dlt_level ASC,dlt_id ASC')->select();
			foreach($data as $k=>$v){
				$map2=array();
				$count2=0;
				$map2['dl_unitcode']=$this->qy_unitcode;
				$map2['dl_referee']=$user_id;
				$map2['dl_level']=$v['dlt_level'];
				$map2['dl_status']=array('in','0,1,2');
				$count2 = $Dealer->where($map2)->count();
				$data[$k]['count']=$count2;
			}
			$ret= array('dl_recommendls' =>$data);
			return $ret;
        }
	}

	/**
	 * 获取代理级别列表
	 */
	public function dealer_list_get(){
		isset($this->params["userid"])?$user_id = $this->params["userid"]:$user_id = ''; //用户名
		isset($this->params["dltid"])?$dltid = $this->params["dltid"]:$dltid = ''; //代理类型ID
		isset($this->params["dtype"])?$dtype = $this->params["dtype"]:$dtype =0; //dtype 0下级，1推荐
 		if(!$this->is_jxuser_login($user_id)){
			$this->err_get(5);
        }else
        {
        	if($dltid>0){
        		//分类
				$map=array();
				$Dltype =M('Dltype');
				$map['dlt_unitcode']=$this->qy_unitcode;
				$map['dlt_id']=$dltid;
				$dltinfo = $Dltype->where($map)->find();
				if($dltinfo){

				}else{
					$this->err_get(30);
				}	
				$Dealer =M('Dealer');
	            $map=array();
				$map['dl_unitcode']=$this->qy_unitcode;
				$map['dl_type']=$dltid;
				if ($dtype==1)
				{
					$map['dl_referee']=$user_id;
					$map['dl_status']=array('in','0,1,2');
				}
				else
				{
					$map['dl_belong']=$user_id;
					$map['dl_status']=1;
				}
				$dllist = $Dealer->where($map)->field('dl_id,dl_name,dl_weixin,dl_wxheadimg,dl_tel,dl_address,dl_addtime,dl_level,dl_status')->order('dl_id DESC')->select();	
				foreach($dllist as $k=>$v){
					if($v['dl_weixin']!=''){
						$dllist[$k]['dl_weixin']=substr($v['dl_weixin'],0,1).'****'.substr($v['dl_weixin'],-4);
					}
					if($v['dl_tel']!=''){
						$dllist[$k]['dl_tel']=substr($v['dl_tel'],0,3).'****'.substr($v['dl_tel'],-4);
					}
					if (is_not_null($dllist[$k]['dl_wxheadimg']))
					{
						$dllist[$k]['avatarUrl']=$this->ImagePath.$v['dl_wxheadimg'];
					}else
					{
						$dllist[$k]['avatarUrl']='';
					}
					if($v['dl_addtime']>0){
						// $item['dl_addtime_str']=date('Y-m-d',$v['dl_addtime']);
						$dllist[$k]['dl_addtime_str']=date('Y-m-d H:i:s',$v['dl_addtime']);
					}
					 
				    $dllist[$k]['dl_name']=wxuserTextDecode2($v['dl_name']);
				}
				$ret = array('dealerls'=>$dllist,'dlt_name'=>$dltinfo["dlt_name"]);
				return $ret;
        	}else
        	{
        		$this->err_get(30);
        	}
        }
	}


/**
	 * 搜索代理级别列表
	 */
	public function dealer_list_search(){
		isset($this->params["userid"])?$user_id = $this->params["userid"]:$user_id = ''; //用户名
		isset($this->params["keyword"])?$keyword = $this->params["keyword"]:$keyword = ''; //搜索关键词
 		if(!$this->is_jxuser_login($user_id)){
			$this->err_get(5);
        }else
        {
			$Dealer =M('Dealer');
            $map=array();
			$map['dl_unitcode']=$this->qy_unitcode;
			if(!preg_match("/^[a-zA-Z0-9_-]{4,30}$/",$keyword)){
				$this->err_get(33);
			}
			// $where['dl_tel']=array('like',"%$keyword%");
			// $where['dl_weixin']=array('like',"%$keyword%");
			// $where['_logic'] = 'or';
			// $map['_complex'] = $where;
			$map['dl_tel|dl_weixin']=array('like',"%$keyword%"); //tp5.0		
			$map['dl_belong|dl_referee']=array('eq',$user_id); //tp5.0
			$dllist = $Dealer->where($map)->field('dl_id,dl_name,dl_weixin,dl_wxheadimg,dl_tel,dl_address,dl_addtime,dl_level,dl_status')->order('dl_id DESC')->select();	
			// var_dump($Dealer->getlastsql());
			foreach($dllist as $k=>$v){
				if($v['dl_weixin']!=''){
					$dllist[$k]['dl_weixin']=substr($v['dl_weixin'],0,1).'****'.substr($v['dl_weixin'],-4);
				}
				if($v['dl_tel']!=''){
					$dllist[$k]['dl_tel']=substr($v['dl_tel'],0,3).'****'.substr($v['dl_tel'],-4);
				}
				if (is_not_null($dllist[$k]['dl_wxheadimg']))
				{
					$dllist[$k]['avatarUrl']=$this->ImagePath.$v['dl_wxheadimg'];
				}else
				{
					$dllist[$k]['avatarUrl']='';
				}
				if($v['dl_addtime']>0){
					// $item['dl_addtime_str']=date('Y-m-d',$v['dl_addtime']);
					$dllist[$k]['dl_addtime_str']=date('Y-m-d H:i:s',$v['dl_addtime']);
				}
				 
			    $dllist[$k]['dl_name']=wxuserTextDecode2($v['dl_name']);
			}
			$ret = array('dealerls'=>$dllist);
			return $ret;
        }
	}

	/**
	 * 获取代理详情
	 */
	public function dealer_detail_get(){
		isset($this->params["userid"])?$user_id = $this->params["userid"]:$user_id = ''; //用户名
		isset($this->params["dlid"])?$dlid = $this->params["dlid"]:$dlid = ''; //代理ID
 		if(!$this->is_jxuser_login($user_id)){
			$this->err_get(5);
        }else
        {
        	//--------------------------------
			$Dealer =M('Dealer');
			$map=array();
			$map['dl_id']=$dlid;
			$map['dl_unitcode']=$this->qy_unitcode;
			// $map['dl_belong']=session('jxuser_id');
			// $map['dl_status']=1;
			$Dltype =M('Dltype');
			
			$data=$Dealer->where($map)->find();
			if($data){
	   //          $imgpath = BASE_PATH.'/Public/uploads/dealer/';
				// if(is_not_null($data['dl_idcardpic']) && file_exists($imgpath.$data['dl_idcardpic'])){
				// 	$data['dl_idcardpic_str']='<img src="'.__ROOT__.'/Public/uploads/dealer/'.$data['dl_idcardpic'].'"   border="0"  style="width:40%;"  >';
				// }else{
				// 	$data['dl_idcardpic_str']='';
				// }
				
				// if(is_not_null($data['dl_idcardpic2']) && file_exists($imgpath.$data['dl_idcardpic2'])){
				// 	$data['dl_idcardpic2_str']='<img src="'.__ROOT__.'/Public/uploads/dealer/'.$data['dl_idcardpic2'].'"   border="0"  style="width:40%;"  >';
				// }else{
				// 	$data['dl_idcardpic2_str']='';
				// }
				// 
				if (is_not_null($data['dl_wxheadimg']))
				{
					$data['avatarUrl']=$this->ImagePath.$v['dl_wxheadimg'];
				}else
				{
					$data['avatarUrl']='';
				}

				if($data['dl_weixin']!=''){
					$data['dl_weixin']=substr($data['dl_weixin'],0,1).'****'.substr($data['dl_weixin'],-4);
				}
				if($data['dl_tel']!=''){
					$data['dl_tel']=substr($data['dl_tel'],0,3).'****'.substr($data['dl_tel'],-4);
				}				
				if($data['dl_idcard']!=''){
					$data['dl_idcard']=substr($data['dl_idcard'],0,6).'********'.substr($data['dl_idcard'],-4);
				}

				//推荐人
				if($data['dl_referee']>0){
					$map2=array();
					$map2['dl_id']=$data['dl_referee'];
					$map2['dl_unitcode']=$this->qy_unitcode;
					$data2 = $Dealer->where($map2)->find();
					if($data2){
						if ($data2['dl_id']==$user_id)
							$data['dl_referee_str']='我';
						else
							$data['dl_referee_str']=$data2['dl_name'].' ('.$data2['dl_username'].')';
					}else{
						$data['dl_referee_str']='';
					}
				}else{
					$data['dl_referee_str']='';
				}
				
				//上家代理
				if($data['dl_belong']>0){
					$map2=array();
					$map2['dl_id']=$data['dl_belong'];
					$map2['dl_unitcode']=$this->qy_unitcode;
					$data2 = $Dealer->where($map2)->find();
					if($data2){
						if ($data2['dl_id']==$user_id)
						{
							$data['dl_belong_str']='我';
							$data['dl_oneself']=1;
						}
						else
						{
							$data['dl_belong_str']=$data2['dl_name'].' ('.$data2['dl_username'].')';
							$data['dl_oneself']=0;
						}
					}else{
						$data['dl_belong_str']='';
					}
				}else{
					$data['dl_belong_str']='总公司';
					$data['dl_oneself']=0;
				}
				
				//状态
				if($data['dl_status']==1){
					$data['dl_status_str']='(正常)';
				}else if($data['dl_status']==2){
					$data['dl_status_str']='(上家已审)';
				}else if($data['dl_status']==0){
					$data['dl_status_str']='(待审核)';
				}else{
					$data['dl_status_str']='';
				}

				//级别1
				$map5=array();
				$map5['dlt_unitcode']=$this->qy_unitcode;
				$map5['dlt_id']=$data['dl_type'];
				$data5 = $Dltype->where($map5)->find();
				if($data5){
					$data['dlt_name']=$data5['dlt_name'];
				}else{
					$data['dlt_name']='';
				}

				//开户银行
				$bankarr=$this->fanli_banks;
				$data['dl_bankname']=$bankarr[intval($data['dl_bank'])];
				$dl_bankcardstr=Funcrypt::authcode($data['dl_bankcard'],'DECODE',$this->www_authkey,0);
				$data['dl_bankcardstr']=substr($dl_bankcardstr,0,3).'*********'.substr($dl_bankcardstr,-3);

				$ret = array('dlinfo' =>$data);
				return $ret;
			}else{
				$this->err_get(30);
			}
	    }
	}

	/**
	 * 获取代理调级申请列表
	 */
	public function dealer_transferls_get(){
		isset($this->params["userid"])?$user_id = $this->params["userid"]:$user_id = ''; //用户名
		isset($this->params["dtype"])?$dtype = $this->params["dtype"]:$dtype =0; //dtype 0下级申请，1我的申请
		if(!$this->is_jxuser_login($user_id)){
			$this->err_get(5);
        }else
        {
			$Dealer =M('Dealer');
	        $Dltype =M('Dltype');
			$Applydltype =M('Applydltype');			
	        $map=array();
	        $map['apply_unitcode']=$this->qy_unitcode;
	        if ($dtype==1)
				$map['apply_dlid']=$user_id;
			else
				$map['apply_afterbelong']=$user_id;
	        $list = $Applydltype->where($map)->order('apply_id DESC')->select();
			foreach($list as $k=>$v){
				//申请后上家
				if($v['apply_afterbelong']>0){
					$map2=array();
					$map2['dl_id']=$v['apply_afterbelong'];
					$map2['dl_unitcode']=$this->qy_unitcode;
					$data2=$Dealer->where($map2)->find();
					if($data2){
						$list[$k]['apply_afterbelong_str']=$data2['dl_name'].'('.$data2['dl_username'].')';
					}else{
						$list[$k]['apply_afterbelong_str']='未知';
					}
				}else{
					$list[$k]['apply_afterbelong_str']=' 总公司';
				}
				
				//申请后级别
				if($v['apply_afterdltype']>0){
					$map2=array();
					$map2['dlt_unitcode']=$this->qy_unitcode;
					$map2['dlt_id']=$v['apply_afterdltype'];
					$dltinfo = $Dltype->where($map2)->find();
					if($dltinfo){
						$list[$k]['apply_afterdltype_str']='申请调级到：'.$dltinfo['dlt_name'];
					}else{
						$list[$k]['apply_afterdltype_str']='';
					}
				}else{
					$list[$k]['apply_afterdltype_str']='';
				}
				
	            if($v['apply_state']==0){
	                $list[$k]['apply_state_str']='待处理';
	            }elseif($v['apply_state']==1){
	                $list[$k]['apply_state_str']='已调整级别';
	            }elseif($v['apply_state']==2){
	                $list[$k]['apply_state_str']='申请无效';
	            }				
			}
			$ret = array('dl_transferls' =>$list);
			return $ret;
        }
	}

	/**
	 * 获取代理调级申请列表
	 */
	public function dealer_transfer_detail_get(){
		isset($this->params["userid"])?$user_id = $this->params["userid"]:$user_id = ''; //用户名
		isset($this->params["applyid"])?$apply_id = $this->params["applyid"]:$apply_id ='';
		if(!$this->is_jxuser_login($user_id)){
			$this->err_get(5);
        }else
        {
        	$Applydltype=M('Applydltype');
        	$Dealer=M('Dealer');
			$Dltype=M('Dltype');

        	$map= array();
        	$data= array();
        	$map['apply_id']=$apply_id;
			$map['apply_unitcode']=$this->qy_unitcode;
			// $map['apply_dlid']=$user_id;
			$data=$Applydltype->where($map)->find();
			if($data){
				//申请代理
				if($data['apply_dlid']>0){
					$map2=array();
					$map2['dl_id']=$data['apply_dlid'];
					$map2['dl_unitcode']=$this->qy_unitcode;
					$data2=$Dealer->where($map2)->find();
					if($data2){
						$data['dl_name_str']=$data2['dl_name'].'('.$data2['dl_username'].') ('.$data2['dl_tel'].')';
					}else{
						$data['dl_name_str']='未知';
					}
				}else{
					$data['dl_name_str']='未知';
				}
				
				//申请前上家
				if($data['apply_agobelong']>0){
					$map2=array();
					$map2['dl_id']=$data['apply_agobelong'];
					$map2['dl_unitcode']=$this->qy_unitcode;
					$data2=$Dealer->where($map2)->find();
					if($data2){
						$data['apply_agobelong_str']=$data2['dl_name'].'('.$data2['dl_username'].')';
					}else{
						$data['apply_agobelong_str']='未知';
					}
				}else{
					$data['apply_agobelong_str']=' 总公司';
				}
				
				//申请前级别
				if($data['apply_agodltype']>0){
					$map2=array();
					$map2['dlt_unitcode']=$this->qy_unitcode;
					$map2['dlt_id']=$data['apply_agodltype'];
					$dltinfo = $Dltype->where($map2)->find();
					if($dltinfo){
						$data['apply_agodltype_str']=$dltinfo['dlt_name'];
					}else{
						$data['apply_agodltype_str']='类型不存在';
					}
				}else{
					$data['apply_agodltype_str']='类型不存在';
				}
				
				//申请后上家
				if($data['apply_afterbelong']>0){
					$map2=array();
					$map2['dl_id']=$data['apply_afterbelong'];
					$map2['dl_unitcode']=$this->qy_unitcode;
					$data2=$Dealer->where($map2)->find();
					if($data2){
						$data['apply_afterbelong_str']=$data2['dl_name'].'('.$data2['dl_username'].') ('.$data2['dl_tel'].')';
					}else{
						$data['apply_afterbelong_str']='未知';
					}
				}else{
					$data['apply_afterbelong_str']=' 总公司';
				}
				
				//申请后级别
				if($data['apply_afterdltype']>0){
					$map2=array();
					$map2['dlt_unitcode']=$this->qy_unitcode;
					$map2['dlt_id']=$data['apply_afterdltype'];
					$dltinfo = $Dltype->where($map2)->find();
					if($dltinfo){
						$data['apply_afterdltype_str']=$dltinfo['dlt_name'];
					}else{
						$data['apply_afterdltype_str']='类型不存在';
					}
				}else{
					$data['apply_afterdltype_str']='类型不存在';
				}
				
				//状态
				if($data['apply_state']==0){
					$data['apply_state_str']='待处理';
				}elseif($data['apply_state']==1){
					$data['apply_state_str']='已调整级别';
				}elseif($data['apply_state']==2){
					$data['apply_state_str']='申请无效';
				}
				//凭证
				// if(is_not_null($data['apply_pic']) && file_exists($imgpath.$data['apply_pic'])){
				if(is_not_null($data['apply_pic'])){
					$data['apply_pic_str']=$this->ImagePath.$data['apply_pic'];
				}else{
					$data['apply_pic_str']='';
				}

				if($data['apply_addtime']>0){
					// $item['dl_addtime_str']=date('Y-m-d',$v['dl_addtime']);
					$data['apply_addtime_str']=date('Y-m-d H:i:s',$data['apply_addtime']);
				}				

				if($data['apply_dealtime']>0){
					// $item['dl_addtime_str']=date('Y-m-d',$v['dl_addtime']);
					$data['apply_dealtime_str']=date('Y-m-d H:i:s',$data['apply_dealtime']);
				}

				$ret = array('dltfinfo' =>$data);
				return $ret;
			}else{
				$this->err_get(30);
			}
        }
	}

	/**
	 * 获取代理调级申请初始化
	 */
	public function dealer_transfer_init(){
		isset($this->params["userid"])?$user_id = $this->params["userid"]:$user_id = ''; //用户名
		if(!$this->is_jxuser_login($user_id)){
			$this->err_get(5);
        }else
        {
        	//--------------------------------	
	        $Dealer=M('Dealer');
			$map=array();
			$map['dl_id']=$user_id;
			$map['dl_unitcode']=$this->qy_unitcode;
			$map['dl_status']=1;
			$data=$Dealer->where($map)->field('dl_id,dl_type,dl_belong,dl_referee')->find();
			if($data){

			}else{
				$this->err_get(4);
			}
			//--------------------------------
			
			//当前级别
			$Dltype=M('Dltype');
			$map2=array();
			$map2['dlt_unitcode']=$this->qy_unitcode;
			$map2['dlt_id']=$data['dl_type'];
			$dltinfo = $Dltype->where($map2)->field('dlt_name,dlt_level')->find();
			if($dltinfo){
				$data['original_name']=$dltinfo['dlt_name'];
				$data['original_level']=$dltinfo['dlt_level'];
			}else{
				$this->err_get(39);
			}
			
			//当前上家
			if($data['dl_belong']>0){
				$map2=array();
				$map2['dl_id'] =  $data['dl_belong'];
				$map2['dl_unitcode']=$this->qy_unitcode;
				$data2 = $Dealer->where($map2)->field('dl_name,dl_username')->find();
				if($data2){
					$data['dl_belong_name']=$data2['dl_name'].' ('.$data2['dl_username'].')';
				}else{
					$data['dl_belong_name']='-';
				}
			}else{
				$data['dl_belong_name']='总公司';
			}
			//当前推荐人
			if($data['dl_referee']>0){
				$map2=array();
				$map2['dl_id'] =  $data['dl_referee'];
				$map2['dl_unitcode']=$this->qy_unitcode;
				$data2 = $Dealer->where($map2)->field('dl_name,dl_username')->find();
				if($data2){
					$data['dl_referee_name']=$data2['dl_name'].' ('.$data2['dl_username'].')';
				}else{
					$data['dl_referee_name']='-';
				}
			}else{
				$data['dl_referee_name']='总公司';
			}
			//分类列表
			$map2=array();
	        $map2['dlt_unitcode']=$this->qy_unitcode;
			$map2['dlt_level']=array('lt',$data['original_level']);
	        $dltypels= $Dltype->where($map2)->order('dlt_level ASC,dlt_id ASC')->select();
			$ret = array('dltypels' =>$dltypels,'dlinfo'=>$data);
			return $ret;
        }
	}

/**
	 * 代理调级申请保存
	 */
	public function dealer_transfer_update(){
		isset($this->params["userid"])?$user_id = $this->params["userid"]:$user_id = ''; //用户名
		isset($this->params["dltid"])?$dlt_id = $this->params["dltid"]:$dlt_id =0; //调整级别ID
		isset($this->params["applypic"])?$apply_pic = $this->params["applypic"]:$apply_pic =''; //调整凭证路径
		if(!$this->is_jxuser_login($user_id)){
			$this->err_get(5);
        }
        //--------------------------
        $Dealer=M('Dealer');
		$map=array();
		$map['dl_id']=$user_id;
		$map['dl_unitcode']=$this->qy_unitcode;
		$map['dl_status']=1;
		$data=$Dealer->where($map)->find();
		if($data){

		}else{
			$this->err_get(4);
		}
		//--------------------------------
		//判断数据是否有效
		if($dlt_id>0){
			//是否存在没审核的高级申请
			$Applydltype=M('Applydltype');
			$upmap=array();
			$upmap['apply_unitcode']=$this->qy_unitcode;
			$upmap['apply_dlid']=$user_id;
			$upmap['apply_state']=0;
			$updata =$Applydltype->where($upmap)->find();
			if ($updata)
			{
				$this->err_get(40);
			}else
			{
			    $Dltype=M('Dltype');
				//原来级别
				$map2=array();
				$map2['dlt_unitcode']=$this->qy_unitcode;
				$map2['dlt_id']=$data['dl_type'];
				$dltinfo = $Dltype->where($map2)->find();
				if($dltinfo){
					$original_level=$dltinfo['dlt_level'];  //原来的级别
				}else{
					$original_level=$data['dl_level'];  //原来的级别
				}
				
				//修改的分类/级别
				$map2=array();
				$map2['dlt_unitcode']=$this->qy_unitcode;
				$map2['dlt_id']=$dlt_id;
				$dltinfo = $Dltype->where($map2)->find();
				if($dltinfo){
					$apply_level=$dltinfo['dlt_level'];  //修改的级别
				}else{
					$this->err_get(41);
				}
                $dlbelong_id=0;
				//如果修改的级别高于原来的级别
				if($apply_level<$original_level){
					//判断是否修改新的上家
					if($data['dl_belong']>0){
						$map2=array();
						$map2['dl_id']=$data['dl_belong'];
						$map2['dl_unitcode']=$this->qy_unitcode;
						$dlbelong=$Dealer->where($map2)->find();
						if($dlbelong){
							//上家的级别
							$map3=array();
							$map3['dlt_unitcode']=$this->qy_unitcode;
							$map3['dlt_id']=$dlbelong['dl_type'];
							$data3 = $Dltype->where($map3)->find();
							
							if($data3){
								$dlbelong_level=$data3['dlt_level']; //上家的级别
							}else{
								$dlbelong_level=$dlbelong['dl_level'];
							}
							
							if($apply_level<=$dlbelong_level){
								$dlbelong_id=$this->get_dlbelong($dlbelong['dl_id'],$apply_level);
								if($dlbelong_id===false){
									$this->err_get(42);
								}
							}else{
								$dlbelong_id=$dlbelong['dl_id'];
							}
						}else{
							$this->err_get(42);
						}
					}else{
						$dlbelong_id=0;
					}
				}else{
					$this->err_get(43);
				}
				
				//保存文件 begin 
				if($apply_pic==''){
					$this->err_get(11);
				}
				// else{
					// $imgpath=BASE_PATH.'/Public/uploads/dealer/'.$this->qy_unitcode;
					// $temppath=BASE_PATH.'/Public/uploads/temp/';
					// $apply_pic='';
					// if (!file_exists($imgpath)) {
					// 	mkdir($imgpath);
					// }
					// if(copy($temppath.$file_name,$imgpath.'/'.$file_name)) {
					//     $apply_pic=$this->qy_unitcode.'/'.$file_name;
					// 	@unlink($temppath.$file_name); 
					// }else{
     //                    $this->err_get(12);
					// }
				// }
				//保存文件 end
				
				
				//添加申请
				$data3=array();
				$data3['apply_unitcode'] = $this->qy_unitcode;
				$data3['apply_dlid'] =$user_id;
				$data3['apply_agobelong'] = $data['dl_belong'];   //原上家
				$data3['apply_agodltype'] = $data['dl_type'];  //原级别
				$data3['apply_afterbelong'] = $dlbelong_id; //申请后上家
				$data3['apply_afterdltype'] = $dlt_id;  //申请后级别
				$data3['apply_pic'] = $apply_pic;
				$data3['apply_addtime'] =time();
				$data3['apply_dealtime'] = 0;	
				$data3['apply_remark'] = '';	
				$data3['apply_state'] = 0;	
				
                $Applydltype =M('Applydltype');
                // $rs3=$Applydltype->insertGetId($data3);//tp5.0
                $rs3=$Applydltype->create($data3,1);//tp5.0
				if($rs3){
					$result3=$Applydltype->add();
					if ($result3){
						$upRet='申请提交成功，请等待审核处理';
						return $upRet;	
					}else{
						$this->err_get(44);
					}	    
				}else{
					$this->err_get(44);
				}
			}	
		}else
		{
			$this->err_get(4);
		}
	}

	/**
	 * 获取apply初始化数据
	 */
	public function apply_init(){
  		isset($this->params["nhad"])?$nhad = $this->params["nhad"]:$nhad = false; //是否要返回省市区数据
  		if ($nhad)
  		$areaArr=$this->area_list_get();
  		
  		$Dltype =M('Dltype');
		//代理级别
		$map=array();
		$map['dlt_unitcode']=$this->qy_unitcode;
		$dltypelist = $Dltype->where($map)->field('dlt_id,dlt_name,dlt_level')->order('dlt_level ASC,dlt_id ASC')->select();
		// $qy_fwkey=$this->qy_fwkey;
		// $qy_fwsecret=$this->qy_fwsecret;
		// $ttamp=time();
		// $sture=MD5($qy_fwkey.$ttamp.$qy_fwsecret);
		//银行列表
		// $bankarr=$this->fanli_banks;
		$ret=array();
		if ($nhad)
			$ret=array('dltypels' =>$dltypelist,'bankls' =>$this->fanli_banks,'areals' =>$areaArr);
		else
			$ret=array('dltypels' =>$dltypelist,'bankls' =>$this->fanli_banks);
  		return $ret;
	}

	/**
	 * 代理申请
	 */
	public function apply(){
  		isset($this->params["avatar"])?$avatar = $this->params["avatar"]:$avatar =''; //头像
  		isset($this->params["dlt_id"])?$dlt_id = $this->params["dlt_id"]:$dlt_id =0; //代理级别ID
  		isset($this->params["dl_name"])?$dl_name = $this->params["dl_name"]:$dl_name =''; //代理姓名
  		isset($this->params["dl_weixin"])?$dl_weixin = $this->params["dl_weixin"]:$dl_weixin =''; //代理微信
  		isset($this->params["dl_tel"])?$dl_tel = $this->params["dl_tel"]:$dl_tel ='';//代理电话
  		isset($this->params["dl_idcard"])?$dl_idcard = $this->params["dl_idcard"]:$dl_idcard =''; //代理身份证
  		isset($this->params["dl_bank"])?$dl_bank = $this->params["dl_bank"]:$dl_bank =''; //代理支付款银行
  		isset($this->params["dl_bankcard"])?$dl_bankcard = $this->params["dl_bankcard"]:$dl_bankcard =''; //代理支付款银行帐号
  		isset($this->params["dl_prov"])?$dl_prov = $this->params["dl_prov"]:$dl_prov =''; //代理所在省
  		isset($this->params["dl_city"])?$dl_city = $this->params["dl_city"]:$dl_city =''; //代理所在市
  		isset($this->params["dl_area"])?$dl_area = $this->params["dl_area"]:$dl_area =''; //代理所在区
  		isset($this->params["dl_area_all"])?$dl_area_all = $this->params["dl_area_all"]:$dl_area_all =''; //代理所在地区
  		isset($this->params["dl_address"])?$dl_address = $this->params["dl_address"]:$dl_address =''; //代理收货地址
  		isset($this->params["dl_referee"])?$dl_referee = $this->params["dl_referee"]:$dl_referee =''; //邀请人ID编号：

		$data = [
			'dlt_id'  =>$dlt_id,
			'dl_name'  =>$dl_name,
			'dl_weixin'   =>$dl_weixin,
			'dl_tel'   =>$dl_tel,
			'dl_idcard'   =>$dl_idcard,
			'dl_bank'   =>$dl_bank,
			'dl_bankcard'   =>$dl_bankcard,
			'dl_address'   =>$dl_address,
			'dl_referee'   =>$dl_referee,
		];
		// $validate = new ApplyValidate();
		// $result = $validate->scene('login')->check($data);
		$result =validate($data,'klapi/ApplyValidate');
		if(true !== $result){
			// 验证失败 输出错误信息
			// $ret = array("status" => 0, "msg" =>$validate->getError());
			$ret = array("status" => 0, "msg" =>$result);
    		exit(json_encode($ret));
		}else
		{
			//申请级别1
			$Dealer=M('Dealer');
			$Dltype=M('Dltype');
			$Dlsttype=M('Dlsttype');
			$map3=array();
			$map3['dlt_unitcode']=$this->qy_unitcode;
			$map3['dlt_id']=$dlt_id;
			$dltypeinfo = $Dltype->where($map3)->find();
			$dlsttypeid=0;
			if($dltypeinfo){
                $apply_level=$dltypeinfo['dlt_level'];  //申请的级别
			}else{
				$this->err_get(13);
			}

			// if($dl_referee>0){
				//推荐人是否有效
				$map=array();
				$map['dl_number']=$dl_referee;
				$map['dl_unitcode']=$this->qy_unitcode;
				$map['dl_status']=1;
				$dlreferee=$Dealer->where($map)->find();
				if($dlreferee){
					$dl_refereeid=$dlreferee['dl_id'];//推荐人ID
					$dlreferee_belong=$dlreferee['dl_belong']; //推荐人的上家
					$dlreferee_username=$dlreferee['dl_username'];  //推荐人
					//推荐人的级别
					$map3=array();
					$map3['dlt_unitcode']=$this->qy_unitcode;
					$map3['dlt_id']=$dlreferee['dl_type'];
					$data3 = $Dltype->where($map3)->find();
					if($data3){
						$dlreferee_level=$data3['dlt_level']; //推荐人的级别
					}else{
						$this->err_get(13);
					}
				}else{
					$this->err_get(14);
				}
			// }

			//判断上家
			$dlbelong_id=0;  //上家id
			$dlbelong_name='总公司'; //上家名称
			// if($dl_referee>0){
				if($apply_level<=$dlreferee_level){  //如果申请的级别高于推荐人的级别 或 与推荐人同级
					if($dlreferee_belong>0){
						$dlbelong_id=$this->get_dlbelong($dlreferee_belong,$apply_level);
						if($dlbelong_id===false){
							$this->err_get(15);
						}
						// else{
						// 	if($dlbelong_id>0){
						// 		$map=array();
						// 		$map['dl_id']=$dlbelong_id;
						// 		$map['dl_unitcode']=$this->qy_unitcode;
						// 		$map['dl_status']=1;
						// 		$dlbelong=$Dealer->where($map)->find();
						// 		if($dlbelong){
						// 			$dlbelong_id=$dlbelong['dl_id'];
						// 			$dlbelong_name=$dlbelong['dl_username'];
						// 		}else{
						// 			$this->error('该邀请链接已失效',U('Kangli/Index/index'),2);
						// 		}
						// 	}else{
						// 		$dlbelong_id=0;
						// 	}
						// }
					}else{
						$dlbelong_id=0;
					}
				}else{//如果申请的级别低于推荐人的级别 那上家就是推荐人
					// $map=array();
					// $map['dl_id']=$dl_refereeid;
					// $map['dl_unitcode']=$this->qy_unitcode;
					// $map['dl_status']=1;
					// $dlbelong=$Dealer->where($map)->find();
					// if($dlbelong){
					// 	$dlbelong_id=$dlbelong['dl_id'];
					// 	$dlbelong_name=$dlbelong['dl_username'];
					// }else{
					// 	$this->err_get(15);
					// }
						$dlbelong_id=$dl_refereeid;
						$dlbelong_name=$dlreferee_username;
				}
			// }
			//身份证图片
			$dl_idcardpic='';
			$dl_idcardpic2='';
			$id_bankcard_encode=Funcrypt::authcode($dl_bankcard,'ENCODE',$this->www_authkey,0);
			$md5_pwd=MD5(MD5(MD5(substr($dl_tel,-6))));
			$data2=array();
			$data2['dl_username']=$dl_weixin;
			$data2['dl_pwd']=$md5_pwd;
			$data2['dl_number']='';
			$data2['dl_unitcode']=$this->qy_unitcode;
			$data2['dl_name']=$dl_name;
			$data2['dl_contact']=$dl_name;
			$data2['dl_tel']=$dl_tel;
			$data2['dl_idcard']=$dl_idcard;
			$data2['dl_idcardpic']=$dl_idcardpic;
			$data2['dl_idcardpic2']=$dl_idcardpic2;
			$data2['dl_tbdian']='';
			$data2['dl_tbzhanggui']='';
			$data2['dl_addtime']=time();
			$data2['dl_status']=0;
			$data2['dl_level']=$apply_level;
			$data2['dl_type']=$dlt_id;   //代理等级
			$data2['dl_sttype']=$dlsttypeid;   //代理等级2
			$data2['dl_belong']=$dlbelong_id;       //上家
			$data2['dl_referee']=$dl_refereeid;  //推荐人
			$data2['dl_remark']='';
			$data2['dl_address']=$dl_address;
			$data2['dl_sheng']=$dl_prov;
			$data2['dl_shi']=$dl_city;
			$data2['dl_qu']=$dl_area;
			$data2['dl_qustr']=$dl_area_all;
			
			$data2['dl_openid']='';
			$data2['dl_weixin']=$dl_weixin;
			$data2['dl_wxnickname']='';
			$data2['dl_wxsex']=0;
			$data2['dl_wxprovince']='';
			$data2['dl_wxcity']='';
			$data2['dl_wxcountry']='';
			$data2['dl_wxheadimg']=$avatar;
			$data2['dl_brand']='';
			$data2['dl_brandlevel']='';
			
			$data2['dl_bank']=$dl_bank;
			$data2['dl_bankcard']=$id_bankcard_encode;
			$data2['dl_stockpic']='';
            $result=$Dealer->create($data2,1);
			if($result){
				$reDLID=$Dealer->add();
				if ($reDLID>0)
				{
					//添加地址
					$data3=array();
					$data3['dladd_unitcode'] = $this->qy_unitcode;
					$data3['dladd_dlid'] = $reDLID;
					$data3['dladd_contact'] = $dl_name;
					$data3['dladd_sheng'] = $dl_prov;
					$data3['dladd_shi'] = $dl_city;
					$data3['dladd_qu'] = $dl_area;
					$data3['dladd_diqustr'] = $dl_area_all;
					$data3['dladd_address'] = $dl_address;
					$data3['dladd_tel'] = $dl_tel;	
					$data3['dladd_default'] = 1;	
	                $Dladdress =M('Dladdress');
					// $Dladdress->data($data3)->insert(); //tp5.0
					$Dladdress->create($data3,1);
					$Dladdress->add();
					//代理操作日志 begin
					// $version =$this->request->header('version');
	        		// if($version==null) $version = "v1";
					$odlog_arr=array(
						'dlg_unitcode'=>$this->qy_unitcode,  
						'dlg_dlid'=>$result,
						'dlg_operatid'=>$result,
						'dlg_dlusername'=>$data2['dl_username'],
						'dlg_dlname'=>$data2['dl_name'],
						'dlg_action'=>'代理商注册 自己申请',
						'dlg_type'=>1, //0-企业 1-经销商
						'dlg_addtime'=>time(),
						'dlg_ip'=>real_ip(),
						'dlg_link'=>$_SERVER["HTTP_HOST"].'/klapi/controller/dealer/apply'
					);

					$Dealerlogs =M('Dealerlogs');
					// $Dealerlogs->data($odlog_arr)->insert();
					$Dealerlogs->create($odlog_arr,1);
					$Dealerlogs->add();
					//代理操作日志 end
					
	                //记录日志 begin  系统
					$log_arr=array();
					$log_arr=array(
								'log_qyid'=>$result,
								'log_user'=>$dl_weixin,
								'log_qycode'=>$this->qy_unitcode,
								'log_action'=>'代理商注册',
								'log_type'=>2, //0-系统 1-企业 2-经销商 3-消费者
								'log_addtime'=>time(),
								'log_ip'=>real_ip(),
								'log_link'=>$_SERVER["HTTP_HOST"].'/klapi/controller/'.$version.'/dealer/apply',
								'log_remark'=>json_encode($data2)
								);
					// trace($log_arr,'info');
					save_log($log_arr);
					//记录日志 end
					
					//添加编号
					$map=array();
					$map['dl_id']=$result;
					$map['dl_unitcode']=$this->qy_unitcode;
					$data=array();
					$data['dl_number'] ='No:'.str_pad($result,7,'0',STR_PAD_LEFT);
					$Dealer->where($map)->data($data)->save();
					$upRet='您的申请提交成功，请等待审核，用户名：'.$dl_weixin.' 密码：'.substr($dl_tel,-6).'';
					return $upRet;
				}else
				{
					$this->err_get(16);
				}
			}else{
				$this->err_get(16);
			}
		}
	}

	/**
	 * 代理团队列表
	 */
	public function apply_list_get(){
		isset($this->params["userid"])?$user_id = $this->params["userid"]:$user_id = ''; //用户名
		isset($this->params["dl_status"])?$dl_status = $this->params["dl_status"]:$dl_status =0; //用户名
		isset($this->params["keyword"])?$keyword = $this->params["keyword"]:$keyword =''; //搜索关键词
 		if(!$this->is_jxuser_login($user_id)){
			$this->err_get(5);
        }else
        {
        	$Dltype =M('Dltype');
			$Dealer =M('Dealer');
			$map=array();
			$data=array();
			//--------------------------------
			$map['dl_unitcode']=$this->qy_unitcode;
			$map['dl_belong']=$user_id;
			$map['dl_status']=$dl_status;
			if ($keyword!='')
			{
				if(!preg_match("/^[a-zA-Z0-9_-]{4,30}$/",$keyword)){
					$this->err_get(33);
				}
				// $where['dl_tel']=array('like',"%$keyword%");
				// $where['dl_weixin']=array('like',"%$keyword%");
				// $where['_logic'] = 'or';
				// $map['_complex'] = $where;
				$map['dl_tel|dl_weixin']=array('like',"%$keyword%"); //tp5.0
			}
			$map2=array();
			$map2['dlt_unitcode']=$this->qy_unitcode;
			$dl_list= $Dealer->where($map)->field('dl_id,dl_name,dl_weixin,dl_wxheadimg,dl_tel,dl_address,dl_addtime,dl_level,dl_status')->order('dl_id DESC')->select();
			// var_dump($Dealer->getlastsql());
			foreach($dl_list as $k=>$v){
				if($v['dl_weixin']!=''){
					$dl_list[$k]['dl_weixin']=substr($v['dl_weixin'],0,1).'****'.substr($v['dl_weixin'],-4);
				}
				if($v['dl_tel']!=''){
					$dl_list[$k]['dl_tel']=substr($v['dl_tel'],0,3).'****'.substr($v['dl_tel'],-4);
				}
				$map2['dlt_level']=$v['dl_level'];
				$map2['dlt_unitcode']=$this->qy_unitcode;
				$data2 = $Dltype->where($map2)->order('dlt_level ASC,dlt_id ASC')->find();
				if ($data2)
				{
					$dl_list[$k]['dlt_name']=$data2['dlt_name'];
				}
				if (is_not_null($v['dl_wxheadimg']))
				{
					$dl_list[$k]['dl_avatarUrl']=$this->ImagePath.$v['dl_wxheadimg'];
				}else
				{
					$dl_list[$k]['dl_avatarUrl']='';
				}
				if($v['dl_addtime']>0){
					// $item['dl_addtime_str']=date('Y-m-d',$v['dl_addtime']);
					$dl_list[$k]['dl_addtime_str']=date('Y-m-d H:i:s',$v['dl_addtime']);
				}
			}
			$ret= array('applyls'=>$dl_list);
			return $ret;
        }	
	}
	/**
	 * 通过代理申请
	 */
	public function apply_pass(){
		isset($this->params["userid"])?$user_id = $this->params["userid"]:$user_id = ''; //用户名
		isset($this->params["dlid"])?$dlid = $this->params["dlid"]:$dlid=''; //代理ID
 		if(!$this->is_jxuser_login($user_id)){
			$this->err_get(5);
        }else
        {
        	//--------------------------------
	        $Dealer =M('Dealer');
	        $map=array();
			$map['dl_id']=$user_id;
			$map['dl_unitcode']=$this->qy_unitcode;
			$map['dl_status']=1;
			$data=$Dealer->where($map)->find();
			if($data){
				$user_type=$data['dl_type'];
				$user_belong=$data['dl_belong'];
				$user_username=$data['dl_username'];
				$user_name=$data['dl_name'];
			}else{
				$this->err_get(4);
			}

			if($dlid>0){
				$map=array();
				$map['dl_id']=$dlid;
				$map['dl_unitcode']=$this->qy_unitcode;
				$map['dl_belong']=$user_id;
				$data = $Dealer->where($map)->find();
				if($data){
					$map3=array();
					$map3['dlt_unitcode']=$this->qy_unitcode;
					$map3['dlt_id']=$data['dl_type'];
					$Dltype =M('Dltype');
					$data3 = $Dltype->where($map3)->find();
					if($data3){
						$dlt_namestr=$data3['dlt_name'];
						$applydlt_level=$data3['dlt_level']; //申请代理的级别
					}else{
						$this->err_get(34);
					}
					
					//上家代理直接审核通过
					$startdate=time();
					$data4['dl_status']=1;   //0-待审 1-已审 2-代理已审 9-禁用
					$data4['dl_startdate']=$startdate;  //代理开始时间，从审核当天算起
					$data4['dl_enddate']=$startdate+3600*24*365;    //代理结束时间，从审核当天加1年
					$rs=$Dealer->where($map)->data($data4)->save();
					if($rs){
						//推荐返利 begin

	                    //审核通过后 检测是否有推荐返利  
						//如果有推荐人 并设置了返利
						if($data['dl_referee']>0 && $data3['dlt_fanli1']>0){
							$map4=array();
							$data4=array();
							$map4['dl_id']=$data['dl_referee'];
							$map4['dl_unitcode']=$this->qy_unitcode;
							$map4['dl_status']=1;
							$data4 = $Dealer->where($map4)->find();
							if($data4){
								$map5=array();
								$map5['dlt_unitcode']=$this->qy_unitcode;
								$map5['dlt_id']=$data4['dl_type'];
								$data5 = $Dltype->where($map5)->find();
								if($data5){
									$refedlt_level=$data5['dlt_level']; //推荐人的级别
								}else{
									$this->err_get(35);
								}
								$dl_referee_name=$data4['dl_username'];
								
								
								//默认只有推荐比自己高级的才有
								if($refedlt_level>$applydlt_level){					
									//返利
									$Fanlidetail =M('Fanlidetail');
									$data5=array();
									$data5['fl_unitcode'] = $this->qy_unitcode;
									$data5['fl_dlid'] = $data4['dl_id']; //获得返利的代理
									$data5['fl_senddlid'] =$user_id; //发放返利的代理
									$data5['fl_type'] = 1; // 返利分类 1-推荐返利 2-订单返利  11-提现减少返利 (1-10 增加返利 11-20 减少返利) 
									$data5['fl_money'] = $data3['dlt_fanli1'];
									$data5['fl_refedlid'] = $data['dl_id']; //推荐返利中被推荐的代理
									$data5['fl_oddlid'] = 0; //订单返利中 下单的代理
									$data5['fl_odid'] = 0;  //订单返利中 订单流水id
									$data5['fl_orderid']  = ''; //订单返利中 订单id
									$data5['fl_proid']  = 0;  //订单返利中 产品id
									$data5['fl_odblid']  = 0;  //订单返利中 订单关系id
									$data5['fl_qty']  = 0;  //订单返利中 产品数量
									$data5['fl_level']  = 1;  //返利的层次，1-第一层返利 2-第二层返利
									$data5['fl_addtime']  = time();
									$data5['fl_remark'] ='邀请 '.$data['dl_username'].' 成为 '.$data3['dlt_name'].' 一次性返利';
									
									$map5=array();
									$map5['fl_unitcode'] = $this->qy_unitcode;
									$map5['fl_dlid'] = $data4['dl_id'];
									$map5['fl_type'] = 1;
									$map5['fl_refedlid'] = $data['dl_id'];
									$data6 = $Fanlidetail->where($map5)->find();
									if(!$data6){
										// $Fanlidetail->data($data5)->insert();
										$Fanlidetail->create($data5,1);
										$Fanlidetail->add();
									}
								}
							}
						}
						//返利 end
						
						//代理操作日志 begin
						$version =$this->request->header('version');
		        		if($version==null) $version = "v1";		
						$odlog_arr=array(
									'dlg_unitcode'=>$this->qy_unitcode,  
									'dlg_dlid'=>$dlid,
									'dlg_operatid'=>$user_id,
									'dlg_dlusername'=>$user_username,
									'dlg_dlname'=>$user_name,
									'dlg_action'=>'审核代理商',
									'dlg_type'=>1, //0-企业 1-经销商
									'dlg_addtime'=>time(),
									'dlg_ip'=>real_ip(),
									'dlg_link'=>$_SERVER["HTTP_HOST"].'/klapi/controller/'.$version.'/dealer/apply_pass',
									);
						$Dealerlogs =M('Dealerlogs');
						// $Dealerlogs->data($odlog_arr)->insert();
						$Dealerlogs->create($odlog_arr,1);
						$Dealerlogs->add();

						//代理操作日志 end
					

						//记录日志 begin
						$log_arr=array(
									'log_qyid'=>$user_id,
									'log_user'=>$user_username,
									'log_qycode'=>$this->qy_unitcode,
									'log_action'=>'代理商审核下级',
									'log_type'=>2, //0-系统 1-企业 2-经销商 3-消费者
									'log_addtime'=>time(),
									'log_ip'=>real_ip(),
									'log_link'=>$_SERVER["HTTP_HOST"].'/klapi/controller/'.$version.'/dealer/apply_pass',
									'log_remark'=>json_encode($data)
									);
						save_log($log_arr);
						//记录日志 end
						$ret=array("status" => 1, "msg" =>'审核成功');
						exit(json_encode($ret));
					}else{
						$this->err_get(36);
					}
				}else{
					$this->err_get(30);
				}
			}else{
				$this->err_get(4);
			}
        }
	}

	/**
	 * 删除代理申请
	 */
	public function apply_del(){
		isset($this->params["userid"])?$user_id = $this->params["userid"]:$user_id = ''; //用户名
		isset($this->params["dlid"])?$dlid = $this->params["dlid"]:$dlid=''; //代理ID
 		if(!$this->is_jxuser_login($user_id)){
			$this->err_get(5);
        }else
        {
        	//--------------------------------
			$Dealer =M('Dealer');
			$map=array();
			$map['dl_id']=$user_id;
			$map['dl_unitcode']=$this->qy_unitcode;
			$map['dl_status']=1;
			$data=$Dealer->where($map)->find();
			if($data){
				$user_type=$data['dl_type'];
				$user_belong=$data['dl_belong'];
				$user_username=$data['dl_username'];
				$user_name=$data['dl_name'];
			}else{
				$this->err_get(4);
			}

			$map=array();
			$map['dl_id']=$dlid;
			$map['dl_unitcode']=$this->qy_unitcode;
			$map['dl_belong']=$user_id;
			$map['dl_status']=0;
			$data=$Dealer->where($map)->find();
			if($data){
				//验证是否要删除 要保持数据完整性 
				//是否有下级
				$map2=array();
				$map2['dl_belong']=$data['dl_id'];
				$map2['dl_unitcode']=$this->qy_unitcode;
				$data2 = $Dealer->where($map2)->find();
				if($data2){
					$this->err_get(37);
				}
				//是否有收货
				$Shipment =M('Shipment');
				$map3['ship_unitcode']=$this->qy_unitcode;
				$map3['ship_dealer'] =$data['dl_id'];   //ship_deliver--出货方   ship_dealer--收货方
				$data3=$Shipment->where($map3)->find();
				if($data3){
					$this->err_get(38);
				}
				
				//删除申请日志
				$Dealerlogs =M('Dealerlogs');
				$map2=array();
				$map2['dlg_unitcode']=$this->qy_unitcode;
				$map2['dlg_dlid']=$data['dl_id'];
				$Dealerlogs->where($map2)->delete(); 
				
				@unlink('./Public/uploads/dealer/'.$data['dl_pic']);   //删除授权书
				@unlink('./Public/uploads/dealer/'.$data['dl_idcardpic']);  //删除身份证件
				$Dealer->where($map)->delete(); 

				//记录日志 begin
				$version =$this->request->header('version');
		        if($version==null) $version = "v1";	
				$log_arr=array();
				$log_arr=array(
							'log_qyid'=>$user_id,
							'log_user'=>$user_username,
							'log_qycode'=>$this->qy_unitcode,
							'log_action'=>'经销商删除下级',
							'log_type'=>2, //0-系统 1-企业 2-经销商 3-消费者
							'log_addtime'=>time(),
							'log_ip'=>real_ip(),
							'log_link'=>$_SERVER["HTTP_HOST"].'/klapi/controller/'.$version.'/dealer/apply_del',
							'log_remark'=>json_encode($data)
							);
				save_log($log_arr);
				//记录日志 end
	            $ret=array("status" => 1, "msg" =>'删除成功');
				exit(json_encode($ret));
			}else{
				$this->err_get(30);
			}
        }
	}

	/**
	 * 代理邀请
	 */
	public function dealer_invite(){
		isset($this->params["userid"])?$user_id = $this->params["userid"]:$user_id = ''; //用户名
		if(!$this->is_jxuser_login($user_id)){
			$this->err_get(5);
	    }else
	    {
		    //--------------------------------
	        $Dealer=M('Dealer');
			$map=array();
			$map['dl_id']=$user_id;
			$map['dl_unitcode']=$this->qy_unitcode;
			$map['dl_status']=1;
			$data=$Dealer->where($map)->find();
			if($data){
				$dl_level=$data['dl_level'];
			}

			$sharelinks =M('sharelinks');
			
			//删除已过期
			$map2=array();
			$map2['sl_unitcode']=$this->qy_unitcode;
			$map2['sl_dealerid']=$user_id;
			$map2['sl_endtime']=array('ELT',time());
			$sharelinks->where($map2)->delete(); 
			
			
			//邀请链接列表
			$map2=array();
			$map2['sl_unitcode']=$this->qy_unitcode;
			$map2['sl_dealerid']=$user_id;
			$data2 = $sharelinks->where($map2)->order('sl_id ASC')->select();
			$Dltype =M('Dltype');
			foreach($data2 as $k=>$v){ 
			    //级别1
				$map3=array();
				$map3['dlt_unitcode']=$this->qy_unitcode;
				$map3['dlt_id']=$v['sl_level'];
				$data3 = $Dltype->where($map3)->find();
				if($data3){
					$data2[$k]['dlt_name']=$data3['dlt_name'];
				}else{

					$data2[$k]['dlt_name']='';
				}
				
				if(($v['sl_endtime']-time())>0){
					$data2[$k]['timing']=$v['sl_endtime']-time();
				}else{
					$data2[$k]['timing']=0;
				}
			}
			//邀请级别1
			$map3=array();
			$map3['dlt_unitcode']=$this->qy_unitcode;
			$dltypelist = $Dltype->where($map3)->field('dlt_id,dlt_name,dlt_level')->order('dlt_level ASC,dlt_id ASC')->select();

			$ret=array('sharelinkslist' =>$data2,'dltypelist'=>$dltypelist,'dl_level'=>$dl_level);
			return $ret;
	    }
	}

	//生成邀请链接 分享链接
	public function dealer_marklinks(){
		isset($this->params["userid"])?$user_id = $this->params["userid"]:$user_id = ''; //用户名
		isset($this->params["dltype"])?$dltype = $this->params["dltype"]:$dltype = ''; //代理级别ID
		isset($this->params["slid"])?$slid = $this->params["slid"]:$slid =0; //分享链接ID
		if(!$this->is_jxuser_login($user_id)){
			$this->err_get(5);
	    }else
	    {
	    	if ($slid>0)
	    	{

	    	}else
	    	{
	    		if($dltype>0){		
					//添加邀请链接 链接有效时间3600秒
					$data2=array();
					$endtime=time()+36000;
					$timing=36000; //计时
					$Sharelinks =M('Sharelinks');
					$data2['sl_unitcode']=$this->qy_unitcode;
					$data2['sl_brid']=0;
					$data2['sl_dealerid']=$user_id;
					$data2['sl_level']=$dltype;
					$data2['sl_endtime']=$endtime;
					$data2['sl_views']=0;
					$data2['sl_applynum']=0;

					$rs=$Sharelinks->create($data2,1);
					if ($rs>0)
					{
						$slid = $Sharelinks->add(); 
						if ($slid>0)
						{
							// $rs=$Sharelinks->insertGetId($data2);//tp5.0
							$ret=array('sl_id'=>$rs,'msg' =>'生成邀请链接成功');
							return $ret;
						}else
						{
							$this->err_get('生成邀请链接失败');
						}
					}else
					{
						$this->err_get('生成邀请链接失败');
					}
				}else{
					$this->err_get('请选择邀请级别');
				}
	    	}
	    }
	}

	//授权证书
	public function dealer_authorization(){
		isset($this->params["userid"])?$user_id = $this->params["userid"]:$user_id = ''; //用户名
		if(!$this->is_jxuser_login($user_id)){
			$this->err_get(5);
	    }else
	    {
	    	//--------------------------------	
	        $Dealer=M('Dealer');
			$map=array();
			$map['dl_id']=$user_id;
			$map['dl_unitcode']=$this->qy_unitcode;
			$map['dl_status']=1;
			$data=$Dealer->where($map)->find();
			if($data){
				$dl_name=wxuserTextDecode2($data['dl_name']);
				$dl_weixin=$data['dl_weixin'];
				$dl_number=$data['dl_number'];
				$dl_tel=$data['dl_tel'];
				$dl_idcard=$data['dl_idcard'];
				
				//级别1
	            $Dltype=M('Dltype');
				$map4=array();
				$map4['dlt_unitcode']=$this->qy_unitcode;
				$map4['dlt_id']=$data['dl_type'];
				$data4 = $Dltype->where($map4)->find();
				if($data4){
					$dlt_namestr=$data4['dlt_name'];
				}else{
					$dlt_namestr='';
				}

				$shouquandate=date("Y-m-d", $data['dl_startdate']).'至'.date("Y-m-d",$data['dl_enddate']);

				$imgpath =BASE_PATH.'/Public/uploads/dealer/';
				
				if($data['dl_pic']!='' && file_exists($imgpath.$data['dl_pic']) && (time()-filemtime($imgpath.$data['dl_pic']))<1800 ){
					$dl_picstr=$this->ImagePath.$data['dl_pic'];
				}else{
					@unlink($imgpath.$data['dl_pic']); //删除旧的授权证书
					//生成授权书 只支持jpg 根据每个授权证书的图片不同要调整文字坐标位置
					$ttfpath = BASE_PATH.'/Public/kangli/static/font.ttf'; 
					$temppic = BASE_PATH.'/Public/kangli/static/shouquantemp.jpg';
					$picfilename = $this->qy_unitcode.'/'.time().'_'.$data['dl_id'].'_'.mt_rand(1000,9999).'.jpg';
					$savepic =$imgpath.$picfilename;
					if(!is_dir($imgpath.$this->qy_unitcode)){
						@mkdir($imgpath.$this->qy_unitcode);
					}
					$pictext=array();
					$pictext[]=array('txt'=>$data['dl_name'].'('.$dl_idcard.')','x'=>300,'y'=>483,'color'=>array('51','51','51'),'font'=>$ttfpath,'fontsize'=>'12');
					$pictext[]=array('txt'=>$dl_number,'x'=>160,'y'=>565,'color'=>array('51','51','51'),'font'=>$ttfpath,'fontsize'=>'12');
					$pictext[]=array('txt'=>$data['dl_name'],'x'=>350,'y'=>565,'color'=>array('51','51','51'),'font'=>$ttfpath,'fontsize'=>'12');
					$pictext[]=array('txt'=>$data['dl_weixin'],'x'=>160,'y'=>598,'color'=>array('51','51','51'),'font'=>$ttfpath,'fontsize'=>'12');
					$pictext[]=array('txt'=>$shouquandate,'x'=>350,'y'=>598,'color'=>array('51','51','51'),'font'=>$ttfpath,'fontsize'=>'12');
					make_textpic($pictext,$temppic,$savepic);	
					$map3=array();
					$map3['dl_unitcode']=$this->qy_unitcode;
					$map3['dl_id']=$user_id;
					$data3=array();
					$data3['dl_pic']=$picfilename;	
					$Dealer->where($map3)->save($data3);
					$dl_picstr=$this->ImagePath.$picfilename;
				}
				//当前推荐人
				if($data['dl_referee']>0){
					$map2=array();
					$map2['dl_id']=$data['dl_referee'];
					$map2['dl_unitcode']=$this->qy_unitcode;
					$data2 = $Dealer->where($map2)->find();
					if($data2){
						$data['dl_referee_str']=$data2['dl_name'].' ('.$data2['dl_username'].')';
					}else{
						$data['dl_referee_str']='';
					}
				}else{
					$data['dl_referee_str']='总公司';
				}
				
				//当前上家
				if($data['dl_belong']>0){
					$map2=array();
					$map2['dl_id']=$data['dl_belong'];
					$map2['dl_unitcode']=$this->qy_unitcode;
					$data2 = $Dealer->where($map2)->find();
					if($data2){
						$data['dl_belong_str']=$data2['dl_name'].' ('.$data2['dl_username'].')';
					}else{
						$data['dl_belong_str']='';
					}
				}else{
					$data['dl_belong_str']='总公司';
				}

				$dealerInfo=array();
				$dealerInfo['dl_referee_str']=$data['dl_referee_str'];
				$dealerInfo['dl_belong_str']=$data['dl_belong_str'];
				$dealerInfo['dlt_namestr']=$dlt_namestr;
				$dealerInfo['dl_name']=$dl_name;
				$dealerInfo['dl_weixin']=$dl_weixin;
				$dealerInfo['dl_number']=$dl_number;
				$dealerInfo['dl_tel']=$dl_tel;
				$dealerInfo['dl_picstr']=$dl_picstr;
				$ret = array('dealerInfo'=>$dealerInfo);
				return $ret;
			}else{
				$this->err_get(6);
			}
	    }
	}


	/**
	 * dealer_upgrade_init  //代理调级
	 * @return [type] [description]
	 */
	public function dealer_upgrade_init(){
		isset($this->params["userid"])?$user_id = $this->params["userid"]:$user_id = ''; //用户名
		if(!$this->is_jxuser_login($user_id)){
			$this->err_get(5);
	    }else
	    {
	    	//--------------------------------
			//下级申请调级
			$Dealer = M('Dealer');
	        $Dltype = M('Dltype');
			$Applydltype = M('Applydltype');
			
	        $map=array();
	        $map['apply_unitcode']=$this->qy_unitcode;
			$map['apply_afterbelong']=$user_id;

	        $list = $Applydltype->where($map)->order('apply_id DESC')->select();
			
			foreach($list as $k=>$v){

				//申请后上家
				if($v['apply_afterbelong']>0){
					$map2=array();
					$map2['dl_id']=$v['apply_afterbelong'];
					$map2['dl_unitcode']=$this->qy_unitcode;
					$data2=$Dealer->where($map2)->find();
					if($data2){
						$list[$k]['apply_afterbelong_str']=$data2['dl_name'].'('.$data2['dl_username'].')';
					}else{
						$list[$k]['apply_afterbelong_str']='未知';
					}
				}else{
					$list[$k]['apply_afterbelong_str']=' 总公司';
				}
				
				//申请后级别
				if($v['apply_afterdltype']>0){
					$map2=array();
					$map2['dlt_unitcode']=$this->qy_unitcode;
					$map2['dlt_id']=$v['apply_afterdltype'];
					$dltinfo = $Dltype->where($map2)->find();
					if($dltinfo){
						$list[$k]['apply_afterdltype_str']='申请调级到：'.$dltinfo['dlt_name'];
					}else{
						$list[$k]['apply_afterdltype_str']='';
					}
				}else{
					$list[$k]['apply_afterdltype_str']='';
				}
				
	            if($v['apply_state']==0){
	                $list[$k]['apply_state_str']='待处理';
	            }elseif($v['apply_state']==1){
	                $list[$k]['apply_state_str']='已调整级别';
	            }elseif($v['apply_state']==2){
	                $list[$k]['apply_state_str']='申请无效';
	            }
				
			}

			//我的申请调级
			$mymap=array();
	        $mymap['apply_unitcode']=$this->qy_unitcode;
			$mymap['apply_dlid']=$user_id;

	        $mylist = $Applydltype->where($mymap)->order('apply_id DESC')->select();
			
			foreach($mylist as $k=>$v){

				//申请后上家
				if($v['apply_afterbelong']>0){
					$map2=array();
					$map2['dl_id']=$v['apply_afterbelong'];
					$map2['dl_unitcode']=$this->qy_unitcode;
					$data2=$Dealer->where($map2)->find();
					if($data2){
						$mylist[$k]['apply_afterbelong_str']=$data2['dl_name'].'('.$data2['dl_username'].')';
					}else{
						$mylist[$k]['apply_afterbelong_str']='未知';
					}
				}else{
					$mylist[$k]['apply_afterbelong_str']=' 总公司';
				}
				
				//申请后级别
				if($v['apply_afterdltype']>0){
					$map2=array();
					$map2['dlt_unitcode']=$this->qy_unitcode;
					$map2['dlt_id']=$v['apply_afterdltype'];
					$dltinfo = $Dltype->where($map2)->find();
					if($dltinfo){
						$mylist[$k]['apply_afterdltype_str']='申请调级到：'.$dltinfo['dlt_name'];
					}else{
						$mylist[$k]['apply_afterdltype_str']='';
					}
				}else{
					$mylist[$k]['apply_afterdltype_str']='';
				}
				
	            if($v['apply_state']==0){
	                $mylist[$k]['apply_state_str']='待处理';
	            }elseif($v['apply_state']==1){
	                $mylist[$k]['apply_state_str']='已调整级别';
	            }elseif($v['apply_state']==2){
	                $mylist[$k]['apply_state_str']='申请无效';
	            }
				
			}
			$ret = array('dlupgradels' =>$list,'myupgradels'=>$mylist);
			return $ret;
	    }
	}

	/**
	 * dealer_upgrade_apply_init  //我的调级初始化
	 * @return [type] [description]
	 */
	public function dealer_upgrade_apply_init(){
		isset($this->params["userid"])?$user_id = $this->params["userid"]:$user_id = ''; //用户名
		if(!$this->is_jxuser_login($user_id)){
			$this->err_get(5);
	    }else
	    {
	    	$Dealer= M('Dealer');
			$map=array();
			$map['dl_id']=$user_id;
			$map['dl_unitcode']=$this->qy_unitcode;
			$map['dl_status']=1;
			$data=$Dealer->where($map)->find();
			if($data){

			}else{
				$this->err_get(6);
			}
			//--------------------------------
			
			//当前级别
			$Dltype= M('Dltype');
			$map2=array();
			$map2['dlt_unitcode']=$this->qy_unitcode;
			$map2['dlt_id']=$data['dl_type'];
			$dltinfo = $Dltype->where($map2)->find();
			if($dltinfo){
				$data['original_name']=$dltinfo['dlt_name'];
				$data['original_level']=$dltinfo['dlt_level'];
			}else{
				$this->err_get('原级别记录不存在');
			}
			
			//当前上家
			if($data['dl_belong']>0){
				$map2=array();
				$map2['dl_id'] =  $data['dl_belong'];
				$map2['dl_unitcode']=$this->qy_unitcode;
				$data2 = $Dealer->where($map2)->find();
				if($data2){
					$data['dl_belong_name']=$data2['dl_name'].' ('.$data2['dl_username'].')';
				}else{
					$data['dl_belong_name']='-';
				}
			}else{
				$data['dl_belong_name']='总公司';
			}
			//当前推荐人
			if($data['dl_referee']>0){
				$map2=array();
				$map2['dl_id'] =  $data['dl_referee'];
				$map2['dl_unitcode']=$this->qy_unitcode;
				$data2 = $Dealer->where($map2)->find();
				if($data2){
					$data['dl_referee_name']=$data2['dl_name'].' ('.$data2['dl_username'].')';
				}else{
					$data['dl_referee_name']='-';
				}
			}else{
				$data['dl_referee_name']='总公司';
			}
			//分类列表
			$map2=array();
	        $map2['dlt_unitcode']=$this->qy_unitcode;
			$map2['dlt_level']=array('lt',$data['original_level']);
	        $dltypelist = $Dltype->where($map2)->order('dlt_level ASC,dlt_id ASC')->select();
			
			$ret = array('dltypelist' =>$dltypelist,'dealerinfo' =>$data);
			return $ret;
	    }
	}

	/**
	 * dealer_upgrade_remark  //我的申请级别返回信息
	 * @return [type] [description]
	 */
	public function dealer_upgrade_remark(){
		isset($this->params["userid"])?$user_id = $this->params["userid"]:$user_id = ''; //用户名
		isset($this->params["dlt_id"])?$dlt_id = $this->params["dlt_id"]:$dlt_id = ''; //代理级别ID
		if(!$this->is_jxuser_login($user_id)){
			$this->err_get(5);
	    }else
	    {
	    	//--------------------------------
	        $Dealer= M('Dealer');
			$map=array();
			$map['dl_id']=$user_id;
			$map['dl_unitcode']=$this->qy_unitcode;
			$map['dl_status']=1;
			$data=$Dealer->where($map)->find();
			if($data){

			}else{
				$this->err_get(6);
			}
			//--------------------------------
			if($dlt_id>0){
			    $Dltype= M('Dltype');
				//原来级别
				$map2=array();
				$map2['dlt_unitcode']=$this->qy_unitcode;
				$map2['dlt_id']=$data['dl_type'];
				$dltinfo = $Dltype->where($map2)->find();
				if($dltinfo){
					$original_level=$dltinfo['dlt_level'];  //原来的级别
				}else{
					$original_level=$data['dl_level'];  //原来的级别
				}
				
				//修改的分类/级别
				$map2=array();
				$map2['dlt_unitcode']=$this->qy_unitcode;
				$map2['dlt_id']=$dlt_id;
				$dltinfo = $Dltype->where($map2)->find();
				if($dltinfo){
					$apply_level=$dltinfo['dlt_level'];  //修改的级别
				}else{
					$this->err_get('请选择调整级别');
				}
			
				
				//如果修改的级别高于原来的级别
				if($apply_level<$original_level){
					//判断是否修改新的上家
					if($data['dl_belong']>0){
						$map2=array();
						$map2['dl_id']=$data['dl_belong'];
						$map2['dl_unitcode']=$this->qy_unitcode;
						$dlbelong=$Dealer->where($map2)->find();
						if($dlbelong){
							//上家的级别
							$map3=array();
							$map3['dlt_unitcode']=$this->qy_unitcode;
							$map3['dlt_id']=$dlbelong['dl_type'];
							$data3 = $Dltype->where($map3)->find();
							
							if($data3){
								$dlbelong_level=$data3['dlt_level']; //上家的级别
							}else{
								$dlbelong_level=$dlbelong['dl_level'];
							}
							
							if($apply_level<=$dlbelong_level){
								$dlbelong_id=$this->get_dlbelong($dlbelong['dl_id'],$apply_level);
								if($dlbelong_id===false){
									$this->err_get('上家级别已不存在，请与公司联系');
								}
								
								if($dlbelong_id>0){
									$map2=array();
									$map2['dl_id']=$dlbelong_id;
									$map2['dl_unitcode']=$this->qy_unitcode;
									$dlbelong2=$Dealer->where($map2)->find();
									if($dlbelong2){
										$ret='调整后上家：'.$dlbelong2['dl_name'].' ('.$dlbelong2['dl_username'].') '.$dlbelong2['dl_tel'].'，请联系协商后再提交申请';
										return $ret;
									}else{
										$this->err_get('上家已不存在，请与公司联系');
									}
								}else{
									$ret='调整后上家：总公司，请与公司联系';
									return $ret;
								}
							}else{
								$ret='调整后上家：'.$dlbelong['dl_name'].' 上家没有改变，请先与你的上家联系协商后再提交申请';
								return $ret;
							}
						}else{
							$this->err_get('上家已不存在，请与公司联系');
						}
					}else{
						$this->err_get('调整后上家：总公司，请与公司联系');
					}
				}else{
					$this->err_get('申请调整的级别要高于原来的级别');
				}
			}else{
	           $this->err_get('请选择调整级别');
			}
	    }
	}

	/**
	 * dealer_upgrade_apply  //我的调级提交保存
	 * @return [type] [description]
	 */
	public function dealer_upgrade_apply(){
		isset($this->params["userid"])?$user_id = $this->params["userid"]:$user_id = ''; //用户名
		isset($this->params["dlt_id"])?$dlt_id = $this->params["dlt_id"]:$dlt_id = ''; //代理级别ID
		isset($this->params["file_name"])?$file_name = $this->params["file_name"]:$file_name = ''; //代理级别ID
		if(!$this->is_jxuser_login($user_id)){
			$this->err_get(5);
	    }else
	    {
	    	//--------------------------------	
	        $Dealer= M('Dealer');
			$map=array();
			$map['dl_id']=$user_id;
			$map['dl_unitcode']=$this->qy_unitcode;
			$map['dl_status']=1;
			$data=$Dealer->where($map)->find();
			if($data){

			}else{
				$this->err_get(6);
			}
			//--------------------------------
			if($dlt_id<=0){
				$this->err_get('请选择调整级别');
			}
				
			if($dlt_id>0){
				//是否存在没审核的高级申请
				$Applydltype=M('Applydltype');
				$upmap=array();
				$upmap['apply_unitcode']=$this->qy_unitcode;
				$upmap['apply_dlid']=$user_id;
				$upmap['apply_state']=0;
				$updata =$Applydltype->where($upmap)->find();
				if ($updata)
				{
	            	$this->err_get('您还有调级的申请没审批，暂时无法再次申请');
				}else
				{
				    $Dltype= M('Dltype');
					//原来级别
					$map2=array();
					$map2['dlt_unitcode']=$this->qy_unitcode;
					$map2['dlt_id']=$data['dl_type'];
					$dltinfo = $Dltype->where($map2)->find();
					if($dltinfo){
						$original_level=$dltinfo['dlt_level'];  //原来的级别
					}else{
						$original_level=$data['dl_level'];  //原来的级别
					}
					
					//修改的分类/级别
					$map2=array();
					$map2['dlt_unitcode']=$this->qy_unitcode;
					$map2['dlt_id']=$dltypeid;
					$dltinfo = $Dltype->where($map2)->find();
					if($dltinfo){
						$apply_level=$dltinfo['dlt_level'];  //修改的级别
					}else{
						$this->error('请选择调整级别','',1);
						exit;
					}
	                $dlbelong_id=0;
					//如果修改的级别高于原来的级别
					if($apply_level<$original_level){
						//判断是否修改新的上家
						if($data['dl_belong']>0){
							$map2=array();
							$map2['dl_id']=$data['dl_belong'];
							$map2['dl_unitcode']=$this->qy_unitcode;
							$dlbelong=$Dealer->where($map2)->find();
							if($dlbelong){
								//上家的级别
								$map3=array();
								$map3['dlt_unitcode']=$this->qy_unitcode;
								$map3['dlt_id']=$dlbelong['dl_type'];
								$data3 = $Dltype->where($map3)->find();
								
								if($data3){
									$dlbelong_level=$data3['dlt_level']; //上家的级别
								}else{
									$dlbelong_level=$dlbelong['dl_level'];
								}
								
								if($apply_level<=$dlbelong_level){
									$dlbelong_id=$this->get_dlbelong($dlbelong['dl_id'],$apply_level);
									if($dlbelong_id===false){
										$this->err_get('上家级别已不存在，请与公司联系');
									}
								}else{
									$dlbelong_id=$dlbelong['dl_id'];
								}
							}else{
								$this->err_get('上家已不存在，请与公司联系');
							}
						}else{
							$dlbelong_id=0;
						}
					}else{
						$this->err_get('申请调整的级别要高于原来的级别');
					}
					
					//保存文件 begin 	
					if($file_name==''){
						$this->err_get('请上传调级凭证');
					}else{
						$imgpath=BASE_PATH.'/Public/uploads/dealer/'.$this->qy_unitcode;
						$temppath=BASE_PATH.'/Public/uploads/temp/';
						$apply_pic='';
						if (!file_exists($imgpath)) {
							mkdir($imgpath);
						}
						if(copy($temppath.$file_name,$imgpath.'/'.$file_name)) {
						    $apply_pic=$this->qy_unitcode.'/'.$file_name;
							@unlink($temppath.$file_name); 
						}else{
	                        $this->err_get('调级凭证保存失败');
						}
					}
					//保存文件 end
					
					
					//添加申请
					$data3=array();
					$data3['apply_unitcode'] = $this->qy_unitcode;
					$data3['apply_dlid'] = $user_id;
					$data3['apply_agobelong'] = $data['dl_belong'];   //原上家
					$data3['apply_agodltype'] = $data['dl_type'];  //原级别
					$data3['apply_afterbelong'] = $dlbelong_id; //申请后上家
					$data3['apply_afterdltype'] = $dltypeid;  //申请后级别
					$data3['apply_pic'] = $apply_pic;
					$data3['apply_addtime'] =time();
					$data3['apply_dealtime'] = 0;	
					$data3['apply_remark'] = '';	
					$data3['apply_state'] = 0;	
					
	                $Applydltype = M('Applydltype');
					$rs3=$Applydltype->create($data3,1);
					if($rs3){
					    $rs4=$Applydltype->add();
					    if($rs4){
					       $ret='申请提交成功，请等待审核处理';
						   return $ret;
					    }else{
						   $this->err_get('提交失败');
					    }
					}else{
						$this->err_get('提交失败');
					}
				}	
			}
	    }
	}
	/**
     * 上传图片
     * @param $code
     * @return bool
     */
    public function uploadimg($file,$imgpath)
    {
        $imgpath=BASE_PATH.'/Public/uploads/orders/'.$this->qy_unitcode;
        $temppath=BASE_PATH.'/Public/uploads/temp/';
        if (!file_exists($imgpath)) {
            mkdir($imgpath);
        }
        if (is_not_null($file))
            $this->err_get(11);
        if(copy($temppath.$file_name,$imgpath.'/'.$file_name)) {
            $data2=array();
            $data2['od_paypic']=$this->qy_unitcode.'/'.$file_name;
            $rs=$Orders->where($map)->save($data2);
            if($rs){
                @unlink($imgpath.'/'.$data['od_paypic']); 
                @unlink($temppath.$file_name); 
            }
        }else{
            $this->error('上传图片失败','',2);
        }
    }
}