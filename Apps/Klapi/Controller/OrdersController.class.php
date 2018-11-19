<?php
namespace Klapi\Controller;
use Think\Controller;
use klapi\controller\BaseApiController;
/*订单管理 app 接口   Comm */
class OrdersController extends BaseApiController{
	protected $params;
	protected $use_id;
	protected $keyword;
	protected $dl_id;
	

	public function __construct($params = null)
  	{
  	 // $this->_initialize();//tp5.0
  	 parent::__construct($params);//tp3.2
     $this->params=$params;
     $this->ImagePath='http://'.PROPATH;
     $this->DLPath='http://'.DLPATH;
     $this->ODPath='http://'.ODPATH;
  	}

    public function index(){
    	isset($this->params["userid"])?$user_id = $this->params["userid"]:$user_id = ''; //用户名
 		if(!$this->is_jxuser_login($user_id)){
			$this->err_get(5);
        }

        $Orders=M('Orders');
        $dlsodcount=0;//待确定0
        $dlmodcount=0;//待发货1，2
        $dlfodcount=0;//已发货3
        $dlcodcount=0;//已取消9
        $dlycodcount=0;//最新预充数量

        //待确定od_status=0
        $maps=array();
		$maps['od_unitcode']=$this->qy_unitcode;
		$maps['od_rcdlid']=$user_id;
		$maps['od_state']=0;
 		$maps['od_virtualstock']=1;
		$dlsodcount= $Orders->where($maps)->count();
		//待发货od_status=array('in','1,2');
		$mapm=array();
		$mapm['od_unitcode']=$this->qy_unitcode;
		$mapm['od_rcdlid']=$user_id;
		$mapm['od_state']=array('in','1,2');
		$mapm['od_virtualstock']=1;
		$dlmodcount= $Orders->where($mapm)->count();
 		//已发货od_status=3
		$mapf=array();
		$mapf['od_unitcode']=$this->qy_unitcode;
		$mapf['od_rcdlid']=$user_id;
		$mapf['od_state']=array('in','3,8');
		$mapf['od_virtualstock']=1;
		$dlfodcount= $Orders->where($mapf)->count();
 		//已取消od_status=9
		$mapy=array();
		$mapy['od_unitcode']=$this->qy_unitcode;
		$mapy['od_rcdlid']=$user_id;
		$mapy['od_state']=9;
		$mapy['od_virtualstock']=1;
		$dlyodcount= $Orders->where($mapy)->count();

		 //未完成预充值订单数od_status=9
		$mapyc=array();
		$mapyc['od_unitcode']=$this->qy_unitcode;
		$mapyc['od_oddlid']=$user_id;
		$mapyc['od_state']=array('lt','8');
		$mapyc['od_virtualstock']=1;
		$dlycodcount= $Orders->where($mapyc)->count();

    	//我的提货订单列表
    	$dlthorderinfo=$this->dlthorder_list_get();
		$ret = array("dlthorderinfo" =>$dlthorderinfo,"dlsodcount"=>$dlsodcount,"dlmodcount"=>$dlmodcount,"dlfodcount"=>$dlfodcount,"dlcodcount"=>$dlcodcount,"dlycodcount"=>$dlycodcount);
    	return $ret;
    }
	
	/**
	 * dlthorder_list_get 代理提货订单
	 * @return [type] [description]
	 */
    public function dlthorder_list_get(){
    	isset($this->params["userid"])?$user_id = $this->params["userid"]:$user_id = ''; //用户名
    	isset($this->params["od_state"])?$od_state = $this->params["od_state"]:$od_state =-1; //订单状态 0全部
		isset($this->params["pagenum"]) ? $pagenum = $this->params["pagenum"] : $pagenum =1;
	    isset($this->params["pagecount"]) ? $pagecount = $this->params["pagecount"] : $pagecount =20;
	    // 查询状态为1的用户数据 并且每页显示10条数据 总记录数为1000
	    $pageinit=[
	      'type'     => 'bootstrap',
	      'page' =>$pagenum,
	      // 'list_rows' =>$pagecount,
	    ];
	    $this->use_id=$user_id;
 		if(!$this->is_jxuser_login($user_id)){
			$this->err_get(5);
        }
         $Orders=M('Orders');
        //我的提货订单和状态
        $mysodcount=0;//待确定0
        $mymodcount=0;//待发货1，2
        $myfodcount=0;//已发货3
		//待确定od_status=0
		$mapmys=array();
		$mapmys['od_unitcode']=$this->qy_unitcode;
		$mapmys['od_oddlid']=$user_id;
		$mapmys['od_state']=0;
		$mapmys['od_virtualstock']=0;
		$mysodcount= $Orders->where($mapmys)->count();
		//待发货od_status=array('in','1,2');
		$mapmym=array();
		$mapmym['od_unitcode']=$this->qy_unitcode;
		$mapmym['od_oddlid']=$user_id;
		$mapmym['od_state']=array('in','1,2');
		$mapmym['od_virtualstock']=0;
		$mymodcount= $Orders->where($mapmym)->count();
		//已发货od_status=0
		$mapmyf=array();
		$mapmyf['od_unitcode']=$this->qy_unitcode;
		$mapmyf['od_oddlid']=$user_id;
		$mapmyf['od_state']=3;
		$mapmyf['od_virtualstock']=0;
		$myyodcount= $Orders->where($mapmyf)->count();


		$mapmy=array();
		$mapmy['od_unitcode']=$this->qy_unitcode;
		$mapmy['od_oddlid']=$user_id;
		$mapmy['od_virtualstock']=0;
		if ($od_state>=0)
		{	
			if ($od_state==1||$od_state==2)
				$mapmy['od_state']=array('in','1,2');
			else
				$mapmy['od_state']=$od_state;
		}

		$list=$Orders->where($mapmy)->field('od_id,od_state,od_orderid,od_total,od_addtime')->order('od_id DESC')->page($pagenum,$pagecount)->select();
		$has_more=false;
		foreach ($list as $k => $v) {
			$Orderdetail =M('Orderdetail');
        	$Product =M('Product');
			$Shipment =M('Shipment');
        	//订单详细
			$odtotalqty=0; //订单总数量
			$mapdt=array();
			$datadt=array();
			$mapdt['oddt_unitcode']=$this->qy_unitcode;
			$mapdt['oddt_odid']=$v['od_id'];
			$datadt = $Orderdetail->where($mapdt)->order('oddt_id DESC')->select();
			foreach($datadt as $kk=>$vv){
				//产品
				$mappro=array();
				$datapro=array();
				$mappro['pro_id']=$vv['oddt_proid'];
				$mappro['pro_unitcode']=$this->qy_unitcode;
				$datapro=$Product->where($mappro)->field('pro_id,pro_pic')->find();
				if($datapro){
					if(is_not_null($datapro['pro_pic'])){
						$datadt[$kk]['oddt_propic']=$this->ImagePath.$datapro['pro_pic'];
					}else{
						$datadt[$kk]['oddt_propic']='';
					}
				}else{
					$datadt[$kk]['oddt_propic']='';
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

				$datadt[$kk]['oddt_totalqty']=$oddt_totalqty;

				$odtotalqty+=$oddt_totalqty; 
				//已发数量
				$mapsum=array();
				$datasum=array();
				$mapsum['ship_pro']=$vv['oddt_proid'];
				$mapsum['ship_unitcode']=$this->qy_unitcode;
				$mapsum['ship_odid']=$vv['oddt_odid'];
				$mapsum['ship_dealer']=$this->use_id; //出货接收方
				$datasum=$Shipment->where($mapsum)->sum('ship_proqty');
				if($datasum){
					if($oddt_unitsqty>0){
						$datadt[$kk]['oddt_shiptatolqty']=$datasum;
						$datadt[$kk]['oddt_shipqty']=floor($datasum/$oddt_unitsqty);
					}else{
						$datadt[$kk]['oddt_shiptatolqty']=$datasum;
						$datadt[$kk]['oddt_shipqty']=$datasum;
					}
				}else{
					$datadt[$kk]['oddt_shiptatolqty']=0;
					$datadt[$kk]['oddt_shipqty']=0;
				}
			}
			$list[$k]['odtotalqty']=$odtotalqty;
			$list[$k]['odoneself']=1;
			$list[$k]['orderdetail']=$datadt;

			if($list[$k]['od_addtime']>0){
				$list[$k]['od_addtime_str']=date('Y-m-d',$list[$k]['od_addtime']);
				// $dllist[$k]['dl_addtime_str']=date('Y-m-d H:i:s',$v['dl_addtime']);
			}
			//状态 我的订单状态 以fw_orders表为主
			if($list[$k]['od_state']==0){
				$list[$k]['od_state_str']='待确认';
			}else if($list[$k]['od_state']==1){
				$list[$k]['od_state_str']='待发货';
			}else if($list[$k]['od_state']==2){
				$list[$k]['od_state_str']='部分发货';
			}else if($list[$k]['od_state']==3){
				$list[$k]['od_state_str']='已发货';
			}else if($list[$k]['od_state']==8){
			    $list[$k]['od_state_str']='已完成';
			}else if($list[$k]['od_state']==9){
				$list[$k]['od_state_str']='已取消';
			}else{
				$list[$k]['od_state_str']='未知';
			}
		};

		$nextls =$Orders->where($mapmy)->field('od_id,od_state,od_orderid,od_total,od_addtime')->order('od_id DESC')->page($pagenum+1,$pagecount)->select(); 
	    if (is_not_null($nextls))
		{
			$has_more=true;
		}
	    $data=array('current_page' =>$pagenum,'has_more' =>$has_more,'data'=>$list);
	    $ret = array('dlthorderls' =>$data,'mysodcount'=>$mysodcount,'mymodcount'=>$mymodcount,'myfodcount'=>$myfodcount);
	    return $ret;
    }

    /**
	 * order_list_get 订单列表
	 * @return [type] [description]
	 */
    public function order_list_get(){
    	isset($this->params["userid"])?$user_id = $this->params["userid"]:$user_id = ''; //用户名
    	isset($this->params["od_type"])?$od_type = $this->params["od_type"]:$od_type =0; //订单类型：0提货 1预充 2发货（下级）
    	isset($this->params["od_state"])?$od_state = $this->params["od_state"]:$od_state =-1; //订单状态 0全部
		isset($this->params["pagenum"]) ? $pagenum = $this->params["pagenum"] : $pagenum =1;
	    isset($this->params["pagecount"]) ?$pagecount = $this->params["pagecount"] : $pagecount =20;
	    isset($this->params["keyword"]) ? $keyword = $this->params["keyword"] : $keyword ='';
	    // 查询状态为1的用户数据 并且每页显示10条数据 总记录数为1000
	    $pageinit=[
	      'type'     => 'bootstrap',
	      'page' =>$pagenum,
	      // 'list_rows' =>$pagecount,
	    ];
	    $hasMore=false;
 		if(!$this->is_jxuser_login($user_id)){
			$this->err_get(5);
        }

        if($keyword!=''){
            $keyword=str_replace('[','',$keyword);
            $keyword=str_replace(']','',$keyword);
            $keyword=str_replace('%','',$keyword);
            $keyword=str_replace('_','',$keyword);
            $keyword=sub_str($keyword,20,false);
            $this->keyword=$keyword;
            // $where['od_orderid']=array('EQ',$keyword);
			$map=array();
			$Dealer=M('Dealer');
			$map['dl_unitcode']=$this->qy_unitcode;
			$map['dl_status']=1;
			$map['dl_tel|dl_weixin']=array('EQ',$keyword); //tp5.0	
			$data = $Dealer->where($map)->find();
			if ($data)
			{
				$this->dl_id=$data['dl_id'];
			}
        }

        $Orders=M('Orders');
        //我的提货订单和状态
        $sodcount=0;//待确定0
        $modcount=0;//待发货1，2
        $fodcount=0;//已发货3
		//待确定od_status=0
		$mapmys=array();
		$mapmys['od_unitcode']=$this->qy_unitcode;
		if ($od_type==2)
		{
			$mapmys['od_rcdlid']=$user_id;
			$mapmys['od_virtualstock']=1;	
		}else
		{
			$mapmys['od_oddlid']=$user_id;
			$mapmys['od_virtualstock']=$od_type;
		}
		$mapmys['od_state']=0;	
		
		if ($this->dl_id!='')
		{
			$searchFun=function($query){return $query->where('od_orderid','EQ',$this->keyword)->whereOr('od_oddlid','EQ',$this->dl_id);};
			$sodcount= $Orders->where($mapmys)->where($searchFun)->count();
			// var_dump($Orders->getlastsql());
		}
		else
		{
			if ($keyword!='')
			{
				$mapmys['od_orderid']=$keyword;
			}
			$sodcount= $Orders->where($mapmys)->count();
		}
		//待发货od_status=array('in','1,2');
		$mapmym=array();
		$mapmym['od_unitcode']=$this->qy_unitcode;
		if ($od_type==2)
		{
			$mapmym['od_rcdlid']=$user_id;
			$mapmym['od_virtualstock']=1;
		}else
		{
			$mapmym['od_oddlid']=$user_id;
			$mapmym['od_virtualstock']=$od_type;
		}
		$mapmym['od_state']=array('in','1,2');

		if ($this->dl_id!='')
		{
			$searchFun=function($query){return $query->where('od_orderid','EQ',$this->keyword)->whereOr('od_oddlid','EQ',$this->dl_id);};
			$modcount= $Orders->where($mapmym)->where($searchFun)->count();
			// var_dump($Orders->getlastsql());
		}
		else
		{
			if ($keyword!='')
			{
				$mapmym['od_orderid']=$keyword;
			}
			$modcount= $Orders->where($mapmym)->count();
		}
		//已发货od_status=0
		$mapmyf=array();
		$mapmyf['od_unitcode']=$this->qy_unitcode;
		if ($od_type==2)
		{
			$mapmyf['od_rcdlid']=$user_id;
			$mapmyf['od_virtualstock']=1;
		}else
		{
			$mapmyf['od_oddlid']=$user_id;
			$mapmyf['od_virtualstock']=$od_type;
		}
		$mapmyf['od_state']=3;

		if ($this->dl_id!='')
		{
			$searchFun=function($query){return $query->where('od_orderid','EQ',$this->keyword)->whereOr('od_oddlid','EQ',$this->dl_id);};
			$yodcount= $Orders->where($mapmyf)->where($searchFun)->count();
			// var_dump($Orders->getlastsql());
		}
		else
		{
			if ($keyword!='')
			{
				$mapmyf['od_orderid']=$keyword;
			}
			$yodcount= $Orders->where($mapmyf)->count();
		}

		$mapmy=array();
		$mapmy['od_unitcode']=$this->qy_unitcode;
		if ($od_type==2)
		{
			$mapmy['od_rcdlid']=$user_id;
			$mapmy['od_virtualstock']=1;
		}else
		{
			$mapmy['od_oddlid']=$user_id;
			$mapmy['od_virtualstock']=$od_type;
		}
		if ($od_state>=0)
		{	
			if ($od_state==1||$od_state==2)
				$mapmy['od_state']=array('in','1,2');
			else
				$mapmy['od_state']=$od_state;
		}
		if ($this->dl_id!='')
		{
			$searchFun=function($query){return $query->where('od_orderid','EQ',$this->keyword)->whereOr('od_oddlid','EQ',$this->dl_id);};
			$list =$Orders->where($mapmy)->where($searchFun)->field('od_id,od_state,od_orderid,od_total,od_addtime')->page($pagenum,$pagecount)->select(); 
		}
		else
		{
			if ($keyword!='')
			{
				$mapmy['od_orderid']=$keyword;
			}
			$list =$Orders->where($mapmy)->field('od_id,od_state,od_orderid,od_total,od_addtime')->order('od_id DESC')->page($pagenum,$pagecount)->select(); 
			// var_dump($Orders->getlastsql());
		}
        $Orderdetail =M('Orderdetail');
        $Product =M('Product');
	    $Shipment =M('Shipment');
	    $has_more=false;
	    foreach ($list as $k => $v) {
	    	//订单详细
			$odtotalqty=0; //订单总数量(小件)
			$odtotalshipqty=0; //订单出货总数量
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
					if(is_not_null($data3['pro_pic'])){
			            $data2[$kk]['oddt_propic']=$this->ImagePath.$data3['pro_pic'];
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
				$data2[$kk]['oddt_totalqty']=$odtotalqty;
				//已发数量
				$map3=array();
				$data3=array();
				$map3['ship_pro']=$vv['oddt_proid'];
				$map3['ship_unitcode']=$this->qy_unitcode;
				$map3['ship_odid']=$vv['oddt_odid'];
				if ($od_type==2)
				{
					$map3['ship_deliver']=$user_id; //发货方
				}else
				{
					$map3['ship_dealer']=$user_id; //接货方
				}
				$data3=$Shipment->where($map3)->sum('ship_proqty');

				if($data3){
					if($oddt_unitsqty>0){
			            $data2[$kk]['oddt_shiptatolqty']=$data3;
			            $data2[$kk]['oddt_shipqty']=floor($data3/$oddt_unitsqty);
			        }else{
			            $data2[$kk]['oddt_shiptatolqty']=$data3;
			            $data2[$kk]['oddt_shipqty']=$data3;
			        }
				}else{
					$data2[$kk]['oddt_shiptatolqty']=0;
					$data2[$kk]['oddt_shipqty']=0;
				}
				$odtotalshipqty+=$data2[$kk]['oddt_shiptatolqty'];
				
			}
			$list[$k]['odtotalqty']=$odtotalqty;
			$list[$k]['od_totalshipqty']=$odtotalshipqty;
			$list[$k]['odoneself']=1;
			$list[$k]['orderdetail']=$data2;
			if($list[$k]['od_addtime']>0){
		        $list[$k]['od_addtime_str']=date('Y-m-d',$list[$k]['od_addtime']);
		        // $dllist[$k]['dl_addtime_str']=date('Y-m-d H:i:s',$v['dl_addtime']);
      		}
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
		    //已全部出货
			if (intval($odtotalshipqty)>=intval($odtotalqty))
			{
				$list[$k]['od_shipall']=1;
			}
	    }
	    $nextls =$Orders->where($mapmy)->field('od_id,od_state,od_orderid,od_total,od_addtime')->order('od_id DESC')->page($pagenum+1,$pagecount)->select(); 
	    if (is_not_null($nextls))
		{
			$has_more=true;
		}
	    $data=array('current_page' =>$pagenum,'has_more' =>$has_more,'data'=>$list);
	    $ret = array('orderls' =>$data,'has_more'=>$hasMore,'sodcount'=>$sodcount,'modcount'=>$modcount,'fodcount'=>$fodcount);
	    return $ret;
    }

   	/**
	 * 生成订单初始化
	 * @return [type] [description]
	 */
    public function order_price_init(){
    	isset($this->params["user_id"])?$user_id = $this->params["user_id"]:$user_id = ''; //用户ID
    	isset($this->params["stock"])?$stock = $this->params["stock"]:$stock = ''; //订单类型 0购买 1预充 2 提货
     	isset($this->params["proArr"])?$proArr = $this->params["proArr"]:$proArr =[]; //产品ID、arrt、amount数量  json数组
     	if(!$this->is_jxuser_login($user_id)){
			$this->err_get(5);
        }else
        { 
        	if (is_not_null($proArr))
        	{
        		//--------------------------------
		        $Dealer=M('Dealer');
				$map=array();
				$map['dl_id']=$user_id;
				$map['dl_unitcode']=$this->qy_unitcode;
				$map['dl_status']=1;
				$data=$Dealer->where($map)->find();
				if($data){
					$dl_type=$data['dl_type'];
					$dl_name=$data['dl_name'];
					$dl_belong=$data['dl_belong'];
				}else{
					$this->err_get(4);
				}

				$tatolPrice=0.00;
				$tatolCount=0;
        		$Product=M('product');
        		$Prorice=M('Proprice');
        		foreach ($proArr as $k => $v) {
        			$proMap=array();
        			$proMap['pro_id']=$v['pro_id'];
					$proMap['pro_unitcode']=$this->qy_unitcode;
					$proMap['pro_active']=1;
					$proData=$Product->where($proMap)->find();
					if ($proData)
					{
						$sc_totalqty=0;
						$oddt_unitsqty=0; //每单位包装的数量
						if($proData['pro_dbiao']>0){
							$oddt_unitsqty=$proData['pro_dbiao'];
							if($proData['pro_zbiao']>0){
								$oddt_unitsqty=$oddt_unitsqty*$proData['pro_zbiao'];
							}
							if($proData['pro_xbiao']>0){
								$oddt_unitsqty=$oddt_unitsqty*$proData['pro_xbiao'];
							}					
							$sc_totalqty=$oddt_unitsqty*$v['num'];
						}else{
							$sc_totalqty=$v['num'];
						}
						$tatolCount+=$sc_totalqty;

						$price=0.00;
						$priMap=array();
	        			$priMap['pri_proid']=$v['pro_id'];
						$priMap['pri_unitcode']=$this->qy_unitcode;
						$priMap['pri_dltype']=$dl_type;
						$priData=$Prorice->where($priMap)->find();
						if ($priData)
						{
							$price=$priData['pri_price'];
						}else
						{
							$price=$proData['pro_price'];
						}
						$tatolPrice+=$price;

					}else
					{
						$msg='对不起，产品不存在';
						goto gotoEND;
			            exit;
					}
        		}
        		//代理收货地址
				$Dladdress =M('Dladdress');
				$adMap=array();
				$adMap['dladd_unitcode']=$this->qy_unitcode;
				$adMap['dladd_dlid'] =$user_id;
				$adData = $Dladdress->where($adMap)->order('dladd_default DESC,dladd_id DESC')->find();
				$ret=array('addressinfo' =>$adData,'tatolCount' =>$tatolCount,'tatolPrice' =>$tatolPrice,'dl_name' =>$dl_name,'od_time' =>time());
				return $ret;
        	}else
        	{
        		$this->err_get(4);
        	}
        }
        /////////////
		gotoEND:
		exit(json_encode(array('status' =>0,'msg'=>$msg)));
    }

	/**
	 * 添加订单
	 * @return [type] [description]
	 */
    public function order_add(){
    	isset($this->params["user_id"])?$user_id = $this->params["user_id"]:$user_id = ''; //用户ID
    	isset($this->params["stock"])?$stock = $this->params["stock"]:$stock = ''; //订单类型 0购买 1预充 2 提货
     	isset($this->params["dladd_id"])?$dladd_id = $this->params["dladd_id"]:$dladd_id =''; //地址ID
     	isset($this->params["od_remark"])?$od_remark = $this->params["od_remark"]:$od_remark =0; //订单备注
     	if(!$this->is_jxuser_login($user_id)){
			$this->err_get(5);
        }else
        {     
			//--------------------------------
			//代理商信息
	        $Dealer=M('Dealer');
			$map=array();
			$map['dl_id']=$user_id;
			$map['dl_unitcode']=$this->qy_unitcode;
			$map['dl_status']=1;
			$data=$Dealer->where($map)->find();
			if($data){
				$dl_type=$data['dl_type'];  //代理商级别id
				$dl_belong=$data['dl_belong'];  //上家id
				$dl_referee=$data['dl_referee'];  //推荐人id
				$dl_username=$data['dl_username'];  
				$dl_name=$data['dl_name'];  
			}else{
				$this->err_get(5);
			}
		    
			//收货地址
			$Dladdress =M('Dladdress');
			$address=array();
			if($dladd_id>0){
				$map=array();
				$data=array();
				$map['dladd_dlid']=$user_id;
				$map['dladd_unitcode']=$this->qy_unitcode;
				$map['dladd_id']=$dladd_id;
				$address=$Dladdress->where($map)->find();
				if($address){
					
				}else{
					$this->err_get(25);
				}
			}else{
				$this->err_get(25);
			}
			
			//购物车
	        $Shopcart =M('Shopcart');
			$map=array();
			$data=array();
	        $map['sc_unitcode']=$this->qy_unitcode;
	        $map['sc_dlid'] =$user_id;
	        $map['sc_virtualstock'] =$stock;
	        $data = $Shopcart->where($map)->order('sc_addtime DESC')->select();
			if(count($data)<=0){
				$this->err_get(24);
			}
			
			$Product =M('Product');
			$Proprice =M('Proprice');
			$total=0;
			
			foreach($data as $k=>$v){
				$map2=array();
				$data2=array();
				$map2['pro_id']=$v['sc_proid'];
				$map2['pro_unitcode']=$this->qy_unitcode;
				$map2['pro_active']=1;
				//产品
				$data2=$Product->where($map2)->find();
				if($data2){
					$data[$k]['pro_name']=$data2['pro_name'];
					$data[$k]['pro_number']=$data2['pro_number'];
					$data[$k]['pro_pic']=$data2['pro_pic'];
					$data[$k]['pro_price']=$data2['pro_price'];
					$data[$k]['pro_stock']=$data2['pro_stock'];
					$data[$k]['pro_units']=$data2['pro_units'];
					$data[$k]['pro_dbiao']=$data2['pro_dbiao'];
					$data[$k]['pro_zbiao']=$data2['pro_zbiao'];
					$data[$k]['pro_xbiao']=$data2['pro_xbiao'];
					
					//代理价
					$map3=array();
					$data3=array();
					$map3['pri_proid']=$data2['pro_id'];
					$map3['pri_unitcode']=$this->qy_unitcode;
					$map3['pri_dltype']=$dl_type;

					$data3=$Proprice->where($map3)->find();
					if($data3){
						$data[$k]['pro_dlprice']=$data3['pri_price'];
						$total=$total+$data[$k]['pro_dlprice']*$v['sc_qty'];
					}else{
						$data[$k]['pro_dlprice']='';
					}
				}else{
					$data[$k]['pro_name']='';
					$data[$k]['pro_number']='';
					$data[$k]['pro_pic']='';
					$data[$k]['pro_price']='';
					$data[$k]['pro_dlprice']='';
					$data[$k]['pro_stock']='';
				}
			}
			
			//保存订单
			if($total<=0){
				$this->err_get(24);
			}
			$Orders =M('Orders');
			$orderarr=array();
			$od_orderid=date('YmdHis',time()).mt_rand(1000,9999);
			
			$orderarr['od_unitcode']=$this->qy_unitcode;
			$orderarr['od_orderid']=$od_orderid;
			$orderarr['od_total']=$total;
			$orderarr['od_addtime']=time();
			$orderarr['od_contact']=$address['dladd_contact'];
			$orderarr['od_addressid']=$address['dladd_id'];
			$orderarr['od_sheng']=$address['dladd_sheng'];
			$orderarr['od_shi']=$address['dladd_shi'];
			$orderarr['od_qu']=$address['dladd_qu'];
			$orderarr['od_jie']=0;
			$orderarr['od_address']=$address['dladd_address'];
			$orderarr['od_tel']=$address['dladd_tel'];
			$orderarr['od_express']=0;
			$orderarr['od_expressnum']='';
			$orderarr['od_expressdate']=0;
			$orderarr['od_state']=0;
			$orderarr['od_paypic']=''; //凭证图片
			$orderarr['od_belongship']=0; //是否转上家发货
			$orderarr['od_remark']=$od_remark;

			if($stock==1)
			{	
				$orderarr['od_oddlid']=$user_id;
				$orderarr['od_rcdlid']=$dl_belong;  //接收订单的代理id 0则为总公司
				$orderarr['od_virtualstock']=1;//订货订单
				$orderarr['od_fugou']=1;//订货订单
			}
			else
			{
				$orderarr['od_oddlid']=$user_id;
				$orderarr['od_rcdlid']=0;  //接收订单的代理id 0则为总公司$dl_belong;
				$orderarr['od_virtualstock']=0;//发货订单
				$orderarr['od_fugou']=0;//订货订单
			}
	        $rs=$Orders->create($orderarr,1);
			if($rs){
		    	$result = $Orders->add(); 
		    	if($result){
					//订单详细
					$Orderdetail =M('Orderdetail');
					foreach($data as $k=>$v){
						if($v['pro_dlprice']!=''){
							$detailarr=array();
							$detailarr['oddt_unitcode']=$this->qy_unitcode;
							$detailarr['oddt_odid']=$result;
							$detailarr['oddt_orderid']=$od_orderid;
							// $detailarr['oddt_odblid']=$result2;
							$detailarr['oddt_proid']=$v['sc_proid'];
							$detailarr['oddt_proname']=$v['pro_name'];
							$detailarr['oddt_pronumber']=$v['pro_number'];
							$detailarr['oddt_prounits']=$v['pro_units'];
							$detailarr['oddt_prodbiao']=$v['pro_dbiao'];
							$detailarr['oddt_prozbiao']=$v['pro_zbiao'];
							$detailarr['oddt_proxbiao']=$v['pro_xbiao'];
							$detailarr['oddt_price']=$v['pro_price'];
							$detailarr['oddt_dlprice']=$v['pro_dlprice'];
							$detailarr['oddt_qty']=$v['sc_qty'];
							$detailarr['oddt_attrid']=$v['sc_attrid'];
							$detailarr['oddt_color']=$v['sc_color'];
							$detailarr['oddt_size']=$v['sc_size'];
							$rs3=$Orderdetail->create($detailarr,1);
							if($rs3){
								$result3 = $Orderdetail->add();
								if($result3){

								}else{
									//提交订单失败 把之前订单信息删除
									$map3=array();
									$map3['od_unitcode']=$this->qy_unitcode;
									$map3['od_id']=$rs;
									$map3['od_oddlid']=$user_id;
									$Orders->where($map3)->delete();
									
									// $map3=array();
									// $map3['odbl_unitcode']=$this->qy_unitcode;
									// $map3['odbl_odid']=$result;
									// $map3['odbl_oddlid']=session('jxuser_id');
									// $Orderbelong->where($map3)->delete();
									
									$map3=array();
									$map3['oddt_unitcode']=$this->qy_unitcode;
									$map3['oddt_odid']=$rs;
									$Orderdetail->where($map3)->delete();
									$this->err_get(26);
								}
							}else{
								//提交订单失败 把之前订单信息删除
								$map3=array();
								$map3['od_unitcode']=$this->qy_unitcode;
								$map3['od_id']=$rs;
								$map3['od_oddlid']=$user_id;
								$Orders->where($map3)->delete();
								
								// $map3=array();
								// $map3['odbl_unitcode']=$this->qy_unitcode;
								// $map3['odbl_odid']=$result;
								// $map3['odbl_oddlid']=session('jxuser_id');
								// $Orderbelong->where($map3)->delete();
								
								$map3=array();
								$map3['oddt_unitcode']=$this->qy_unitcode;
								$map3['oddt_odid']=$rs;
								$Orderdetail->where($map3)->delete();
								$this->err_get(26);
							}
						}
					}
					//删除购物车
					$map3=array();
					$map3['sc_unitcode']=$this->qy_unitcode;
					$map3['sc_dlid']=$user_id;
					$Shopcart->where($map3)->delete();
					
					//订单操作日志 begin
					$odlog_arr=array(
						'odlg_unitcode'=>$this->qy_unitcode,  
						'odlg_odid'=>$rs,
						'odlg_orderid'=>$od_orderid,
						'odlg_dlid'=>$user_id,
						'odlg_dlusername'=>$dl_username,
						'odlg_dlname'=>$dl_name,
						'odlg_action'=>'创建订单',
						'odlg_type'=>1, //0-企业 1-经销商
						'odlg_addtime'=>time(),
						'odlg_ip'=>real_ip(),
						'odlg_link'=>$_SERVER["HTTP_HOST"].'kangli/klapi/controller/orders/order_add'
						// 'odlg_link'=>__SELF__
					);
					$Orderlogs =M('Orderlogs');
					$rs3=$Orderlogs->create($odlog_arr,1);
					if($rs3){
						$Orderlogs->add();
					}
					//订单操作日志 end
					$ret=array('msg'=>'提交订单成功');
					return $ret;
				}else
				{
					$this->err_get('提交订单失败');
				}
			}else{
				//提交订单失败 把订单基本信息删除
				$map3=array();
				$map3['od_unitcode']=$this->qy_unitcode;
				$map3['od_id']=$rs;
				$map3['od_oddlid']=$user_id;
				$Orders->where($map3)->delete();
				$this->err_get(26);
			}
		}
    }

    /**
	 * order_detail 订单详情
	 * @return [type] [description]
	 */
    public function order_detail_get(){
    	isset($this->params["user_id"])?$user_id = $this->params["user_id"]:$user_id = ''; //用户ID
    	isset($this->params["od_id"])?$od_id = $this->params["od_id"]:$od_id =''; //订单ID
    	isset($this->params["od_type"])?$od_type = $this->params["od_type"]:$od_type =0; //订单类型 0订货(我的) 2发货(下家)
     	if(!$this->is_jxuser_login($user_id)){
			$this->err_get(5);
        }	
        if($od_id>0){
			$Dealer=M('Dealer');
			$Orders=M("Orders");
			$map=array();
			$map['od_unitcode']=$this->qy_unitcode;
			$map['od_id']=$od_id;
			$data =$Orders->where($map)->find();
			if($data){
				//订单产品详细
				$data['od_shipall']=0;
				$odtotalqty=0; //订单总数量
				$odtotalshipqty=0; //订单总出货数量
				$Orderdetail=M('Orderdetail');
				$Product=M('Product');
				$Shipment =M('Shipment');
				$Express =M('Express');
				
				$map2=array();
				$data2=array();
				$map2['oddt_unitcode']=$this->qy_unitcode;
				$map2['oddt_odid']=$data['od_id'];
				// $map2['oddt_odblid']=$data['odbl_id'];
				$data2 = $Orderdetail->where($map2)->order('oddt_id DESC')->limit(100)->select();
				foreach($data2 as $kk=>$vv){
					//产品
					$map3=array();
					$data3=array();
					$map3['pro_id']=$vv['oddt_proid'];
					$map3['pro_unitcode']=$this->qy_unitcode;
					$data3=$Product->where($map3)->find();
					if($data3){
						if(is_not_null($data3['pro_pic'])){
							$data2[$kk]['oddt_propic']=$this->ImagePath.$data3['pro_pic'];
						}else{
							$data2[$kk]['oddt_propic']='';
						}
					}else{
						$data2[$kk]['oddt_propic']='';
					}
					
					//订购数 发货数
					$oddt_totalqty=0;
					$oddt_unitsqty=0;
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
					$data2[$kk]['oddt_totalqty']=$odtotalqty;
					
					$map3=array();
					$data3=array();
					$map3['ship_pro']=$vv['oddt_proid'];
					$map3['ship_unitcode']=$this->qy_unitcode;
					$map3['ship_odid']=$vv['oddt_odid'];
					if ($od_type==2)
					{
						$map3['ship_deliver']=$user_id; //出货方
					}
					else
					{
						$map3['ship_dealer']=$user_id; //接货方
					}
					$data3=$Shipment->where($map3)->sum('ship_proqty');
					// var_dump($Shipment->getlastsql());
					// var_dump($data3);
					// exit;
					if($data3){
						$data2[$kk]['oddt_shiptatolqty']=$data3;
						if($oddt_unitsqty>0){
							$data2[$kk]['oddt_shipqty']=floor($data3/$oddt_unitsqty);
						}else{
							$data2[$kk]['oddt_shipqty']=$data3;		
						}
					}else{
						$data2[$kk]['oddt_shiptatolqty']=0;
						$data2[$kk]['oddt_shipqty']=0;
					}
					$odtotalshipqty+=$data2[$kk]['oddt_shiptatolqty'];			
				}
				$data['od_totalqty']=$odtotalqty;
				$data['od_totalshipqty']=$odtotalshipqty;
				$data['orderdetail']=$data2;

				//已全部出货
				if (intval($odtotalshipqty)>=intval($oddt_totalqty))
				{
					$data['od_shipall']=1;
				}

				//下单代理信息
				$map3=array();
				$data3=array();
				$map3['dl_id']=$data['od_oddlid'];
				$map3['dl_unitcode']=$this->qy_unitcode;
				$data3=$Dealer->where($map3)->find();
				if($data3){
					$data['od_dl_name']=$data3['dl_name'];
					$data['od_dl_tel']=substr($data3['dl_tel'],0,3).'****'.substr($data3['dl_tel'],-4);
					$data['od_dl_weixin']=substr($data3['dl_weixin'],0,1).'****'.substr($data3['dl_weixin'],-4);
				}else{
					$data['od_dl_name']='';
					$data['od_dl_tel']='';
					$data['od_dl_weixin']='';
				}

				if($data['od_addtime']>0){
					$data['od_addtime_str']=date('Y-m-d H:i:s',$data['od_addtime']);
					$data['od_addtime_str2']=date('Y-m-d',$data['od_addtime']);
				}

				//状态
				if($data['od_state']==0){
					$data['od_state_str']='待确认';
				}else if($data['od_state']==1){
					$data['od_state_str']='待发货';
				}else if($data['od_state']==2){
					$data['od_state_str']='部分发货';
				}else if($data['od_state']==3){
					$data['od_state_str']='已发货';
				}else if($data['od_state']==8){
					$data['od_state_str']='已完成';
				}else if($data['od_state']==9){
					$data['od_state_str']='已取消';
				}else{
					$data['od_state_str']='未知';
				}
						
				// if(is_not_null($data['od_paypic']) && file_exists($imgpath2.$data['od_paypic'])){
				if(is_not_null($data['od_paypic'])){
					$data['od_paypic_str']=$this->ODPath.$data['od_paypic'];
				}else{
					$data['od_paypic_str']='';
				}
				//快递物流
				if($data['od_express']>0){
				    $map3=array();
					$data3=array();
					$map3['exp_id']=$data['od_express'];
					$data3=$Express->where($map3)->find();
					if($data3){
						$data['od_expressname']=$data3['exp_name'];
						//可以从快递100接口获取数据
						
						
					}else{
						$data['od_expressname']='';
					}
				}else{
					$data['od_expressname']='';
				}
				
				//操作日志
				$Orderlogs=M('Orderlogs');
				$map2=array();
				$map2['odlg_unitcode']=$this->qy_unitcode;
				$map2['odlg_odid']=$od_id;

				$logs = $Orderlogs->where($map2)->order('odlg_addtime DESC')->limit(50)->select();
				foreach($logs as $kkk=>$vvv){
					if($vvv['odlg_type']==0){
						 $logs[$kkk]['odlg_dlname']='总公司';
					}
					if($vvv['odlg_addtime']>0){
						$logs[$kkk]['odlg_addtime_str']=date('Y-m-d H:i:s',$vvv['odlg_addtime']);
						// $data['odlg_addtime_str2']=date('Y-m-d',$data['odlg_addtime']);
					}
				}
				$ret = array('orderdt' =>$data,'orderlogs' =>$logs);
				return $ret;
			}else{
				$this->err_get(30);
			}
		}else{
			$this->err_get(30);
		}
    }


    /**
	 * order_receive 订单确认收货
	 * @return [type] [description]
	 */
    public function order_receive(){
		isset($this->params["user_id"])?$user_id = $this->params["user_id"]:$user_id = ''; //用户ID
    	isset($this->params["od_id"])?$od_id = $this->params["od_id"]:$od_id = ''; //订单ID
     	if(!$this->is_jxuser_login($user_id)){
			$this->err_get(5);
        }

        $Orders=M('Orders');
		$Orderlogs=M('Orderlogs');	
		$Dealer=M('Dealer');
		$map=array();
		$map['dl_id']=$user_id;
		$map['dl_unitcode']=$this->qy_unitcode;
		$map['dl_status']=1;
		$data=$Dealer->where($map)->field('dl_id,dl_type,dl_belong,dl_referee,dl_username,dl_name')->find();
		if($data){
			$jxuser_username=$data['dl_username'];
			$jxuser_dlname=$data['dl_name'];
		}else{
			$this->err_get(4);
		}

		if($od_id>0){
			$map=array();
			$map['od_unitcode']=$this->qy_unitcode;
			$map['od_id']=$od_id;
			$data=$Orders->where($map)->find();
			//只有待确认的订单才可以自己取消
			if($data['od_state']==3){
				$updata=array();
				$updata['od_state']=8;
				$Orders->where($map)->data($updata)->save();
				
				//订单操作日志 begin
				// $version =$this->request->header('version');
    //     		if($version==null) $version = "v1";
				$odlog_arr=array(
							'odlg_unitcode'=>$this->qy_unitcode,  
							'odlg_odid'=>$od_id,
							'odlg_orderid'=>$data['od_orderid'],
							'odlg_dlid'=>$user_id,
							'odlg_dlusername'=>$jxuser_username,
							'odlg_dlname'=>$jxuser_dlname,
							'odlg_action'=>'确认收货',
							'odlg_type'=>1, //0-企业 1-经销商
							'odlg_addtime'=>time(),
							'odlg_ip'=>real_ip(),
							'odlg_link'=>$_SERVER["HTTP_HOST"].'kangli/klapi/controller/orders/order_receive'
							// 'odlg_link'=>__SELF__,
							);
				$rs3=$Orderlogs->create($odlog_arr,1);
				if($rs3){
					$Orderlogs->add();
				}
				// $rs3=$Orderlogs->data($odlog_arr)->insert();//tp5.0
				//订单操作日志 end
				$ret=array('status' =>1 ,'msg'=>'确认收货成功');
				exit(json_encode($ret));
			}else{
				$this->err_get(45);
			}		
		}else{
			$this->err_get(4);
		}
    }

    /**
	 * order_receive 订单确认收货
	 * @return [type] [description]
	 */
    public function order_paypic_updata(){
    	isset($this->params["user_id"])?$user_id = $this->params["user_id"]:$user_id = ''; //用户ID
    	isset($this->params["od_id"])?$od_id = $this->params["od_id"]:$od_id = ''; //订单ID
    	isset($this->params["pay_pic"])?$pay_pic = $this->params["pay_pic"]:$pay_pic = ''; //支付凭证-文件名
     	if(!$this->is_jxuser_login($user_id)){
			$this->err_get(5);
        }
        $Orders=M('Orders');
		$map=array();
		$map['od_unitcode']=$this->qy_unitcode;
		$map['od_id']=$od_id;
		$data = $Orders->where($map)->find();
		if($data){
			if ($pay_pic=='')
			{
				$this->err_get(11);
			}else{			
				//保存文件 begin
				$imgpath=BASE_PATH.'/Public/uploads/orders/'.$this->qy_unitcode;
				$temppath=BASE_PATH.'/Public/uploads/temp/';

				if (!file_exists($temppath.$pay_pic)) {
					$this->err_get('上传文件不存在');
				}
				if (!file_exists($imgpath)) {
					mkdir($imgpath);
				}

				if(copy($temppath.$pay_pic,$imgpath.'/'.$pay_pic)){
					$data2=array();
				    $data2['od_paypic']=$this->qy_unitcode.'/'.$pay_pic;
				    $rs=$Orders->where($map)->save($data2);
					if($rs){
						@unlink($imgpath.'/'.$data['od_paypic']); 
						@unlink($temppath.$pay_pic); 
					}
					$ret ='上传凭证成功';
				 	return $ret;
				}else{
					$this->err_get('上传图片失败');
				}
				//保存文件 end
			}
		}else
		{
			$this->err_get(30);
		}
    }

   	/**
	 * order_state_set 订单状态设置
	 * @return [type] [description]
	 */
    public function order_state_set(){
    	isset($this->params["user_id"])?$user_id = $this->params["user_id"]:$user_id = ''; //用户ID
    	isset($this->params["od_id"])?$od_id = $this->params["od_id"]:$od_id = ''; //订单ID
    	isset($this->params["od_state"])?$od_state = $this->params["od_state"]:$od_state =0; //订单状态
     	if(!$this->is_jxuser_login($user_id)){
			$this->err_get(5);
        }

		$Dealer=M('Dealer');
		$map=array();
		$map['dl_id']=$user_id;
		$map['dl_unitcode']=$this->qy_unitcode;
		$map['dl_status']=1;
		$data=$Dealer->where($map)->field('dl_id,dl_type,dl_belong,dl_referee,dl_username,dl_name')->find();
		if($data){
			$jxuser_username=$data['dl_username'];
			$jxuser_dlname=$data['dl_name'];
		}else{
			$this->err_get(4);
		}

		$odlg_action='';
		switch ($od_state) {
			case 1:
				$odlg_action='确认订单';
				break;
			case 3:
				$odlg_action='完成发货';
				break;
			case 8:
				$odlg_action='确认收货';
			break;
			case 9:
				$odlg_action='取消订单';
				break;
		}
		if($od_id>0){
			$Orders=M('Orders');
			$Orderlogs=M('Orderlogs');	
			$map=array();
			$map['od_unitcode']=$this->qy_unitcode;
			$map['od_id']=$od_id;
			$data=$Orders->where($map)->find();
			//只有待确认的订单才可以自己取消
			if($data['od_state']==0||$data['od_state']==1){
				$updata=array();
				$updata['od_state']=$od_state;
				$Orders->where($map)->data($updata)->save();
				
				//订单操作日志 begin
				// $version =$this->request->header('version');
    //     		if($version==null) $version = "v1";
				$odlog_arr=array(
							'odlg_unitcode'=>$this->qy_unitcode,  
							'odlg_odid'=>$od_id,
							'odlg_orderid'=>$data['od_orderid'],
							'odlg_dlid'=>$user_id,
							'odlg_dlusername'=>$jxuser_username,
							'odlg_dlname'=>$jxuser_dlname,
							'odlg_action'=>$odlg_action,
							'odlg_type'=>1, //0-企业 1-经销商
							'odlg_addtime'=>time(),
							'odlg_ip'=>real_ip(),
							'odlg_link'=>$_SERVER["HTTP_HOST"].'kangli/klapi/controller/orders/order_state_set'
							// 'odlg_link'=>__SELF__,
							);
				$rs3=$Orderlogs->create($odlog_arr,1);
				if($rs3){
					$Orderlogs->add();
				}
				// $rs3=$Orderlogs->data($odlog_arr)->insert();
				//订单操作日志 end
				$ret=array('status' =>1 ,'msg'=>$odlg_action.'成功');
				exit(json_encode($ret));
			}else{
				$this->err_get(45);
			}		
		}else{
			$this->err_get(4);
		}
    }

	//核对订单
	public function checkshopcart(){
		isset($this->params["user_id"])?$user_id = $this->params["user_id"]:$user_id = ''; //用户ID
    	isset($this->params["stock"])?$stock = $this->params["stock"]:$stock =0; ////1 预充库存
     	if(!$this->is_jxuser_login($user_id)){
			$this->err_get(5);
        }	
        $Dealer=M('Dealer');
		$map=array();
		$map['dl_id']=$user_id;
		$map['dl_unitcode']=$this->qy_unitcode;
		$map['dl_status']=1;
		$data=$Dealer->where($map)->find();
		if($data){
			$dl_type=$data['dl_type'];
			$dl_name=$data['dl_name'];//下单人
			$dl_belong=$data['dl_belong'];//上级
		}else{
			$this->err_get(4);
		}
        $Shopcart =M('Shopcart');
        //删除24小时前的没下单的购物车记录
		$map2=array();
		$map2['sc_unitcode']=$this->qy_unitcode;
		$map2['sc_dlid']=$user_id;
		$map2['sc_addtime']=array('ELT',(time()-3600*24));
		$Shopcart->where($map2)->delete(); 
		$map=array();
        $map['sc_unitcode']=$this->qy_unitcode;
        $map['sc_dlid'] =$user_id;
        $map['sc_status']=0;
        $map['sc_virtualstock'] =$stock;
        $data = $Shopcart->where($map)->order('sc_addtime DESC')->select();
		if(count($data)<=0){
			$this->err_get(55);
		}
		$Product =M('Product');
		$Proprice =M('Proprice');
		$total=0;
		$totalqty=0;
		foreach($data as $k=>$v){
			$map2=array();
			$data2=array();
			$map2['pro_id']=$v['sc_proid'];
			$map2['pro_unitcode']=$this->qy_unitcode;
			$map2['pro_active']=1;
			
			//产品
			$data2=$Product->where($map2)->find();
			if($data2){
				$data[$k]['pro_name']=$data2['pro_name'];
				$data[$k]['pro_pic']=$data2['pro_pic'];
				$data[$k]['pro_price']=$data2['pro_price'];
				$data[$k]['pro_stock']=$data2['pro_stock'];

				// //计算产品虚拟库存
				$pro_dummystock=0;//总虚拟库存
				if ($dl_belong==0)
				{
					if($stock==1)
					{
						$pro_dummystock=99999999;
					}
					else
					{
						$pro_dummystock=$this->mystock($data2,$user_id);
					}
				}
				else
				{
					if($stock==1)
					{
						$pro_dummystock=$this->mystock($data2,$dl_belong);
					}
					else
					{
						$pro_dummystock=$this->mystock($data2,$user_id);
					}
				}
				// $totalcount=$totalcount+$v['sc_qty'];
				//总件数量
				$sc_totalqty=0; //总订购数
				$pro_unitsqty=0; //每单位包装的数量
				if($data2['oddt_prodbiao']>0){
						$pro_unitsqty=$vv['oddt_prodbiao'];
						if($data2['oddt_prozbiao']>0){
							$pro_unitsqty=$pro_unitsqty*$data2['oddt_prozbiao'];
						}
					
						if($data2['oddt_proxbiao']>0){
							$pro_unitsqty=$pro_unitsqty*$data2['oddt_proxbiao'];
						}	
						$sc_totalqty=$pro_unitsqty*$v['sc_qty'];
					}else{
						$sc_totalqty=$v['sc_qty'];
					}
					$totalqty+=$sc_totalqty;

				if ($pro_dummystock<$v['sc_qty'])
				{
					$msg='对不起，产品'.$v['pro_name'].'--'.$v['sc_size'].'的库存为：'.$pro_dummystock.'不足，暂不能下单';
					goto gotoEND;
		            exit;
				}
				
				//代理价
				$map3=array();
				$data3=array();
				$map3['pri_proid']=$data2['pro_id'];
				$map3['pri_unitcode']=$this->qy_unitcode;
				$map3['pri_dltype']=$dl_type;

				$data3=$Proprice->where($map3)->find();
				if($data3){
					$data[$k]['pro_dlprice']=$data3['pri_price'];
					$total=$total+$data[$k]['pro_dlprice']*$v['sc_qty'];
					
					//最低补货量判断
					if($data3['pri_minimum']>$v['sc_qty']){
						$msg='对不起，产品'.$data2['pro_name'].' 的最低补货量为：'.$data3['pri_minimum'];
						goto gotoEND;
			            exit;
					}
				}else{
					$data[$k]['pro_dlprice']='';
				}
			}else{
				$data[$k]['pro_name']='';
				$data[$k]['pro_pic']='';
				$data[$k]['pro_price']='';
				$data[$k]['pro_dlprice']='';
				$data[$k]['pro_stock']='';
			}
		}
		
		//收货地址
		$dladd_id=intval(I('get.dladd_id',0));
		$Dladdress = M('Dladdress');
		if($dladd_id<=0){
			$map=array();
			$data2=array();
			$map['dladd_unitcode']=$this->qy_unitcode;
			$map['dladd_dlid'] = session('jxuser_id');
			$data2 = $Dladdress->where($map)->order('dladd_default DESC,dladd_id DESC')->limit(1)->select();
			if(count($data2)<=0){
				$dladd_id=0;
				$dladd_address=array();
			}else{
				$dladd_id=$data2[0]['dladd_id'];
				$dladd_address=$data2[0];
			}
		}else{
			$map=array();
			$data2=array();
			$map['dladd_dlid']=session('jxuser_id');
			$map['dladd_unitcode']=$this->qy_unitcode;
			$map['dladd_id']=$dladd_id;
			$data2=$Dladdress->where($map)->find();
			if($data2){
				$dladd_id=$data2['dladd_id'];
				$dladd_address=$data2;
			}else{
				$dladd_id=0;
				$dladd_address=array();
			}
		}

		$ret=array('dl_name' =>$dl_name,'dl_addtime' =>$time(),'dladd_id' =>$dladd_id,'dladd_address' =>$dladd_address,'total' =>$total,'total' =>$total,'totalqty' =>$totalqty,'shopcartlist' =>$data);
		return $ret;

		/////////////
		gotoEND:
		exit(json_encode(array('status' =>0,'msg'=>$msg)));
	}
    //完成发货
	public function odship_finish(){
		isset($this->params["user_id"])?$user_id = $this->params["user_id"]:$user_id = ''; //用户ID
    	isset($this->params["od_id"])?$od_id = $this->params["od_id"]:$od_id =''; //订单ID
    	isset($this->params["init"])?$init = $this->params["init"]:$init =0; //0初始化 1确定完成
    	isset($this->params["od_express"])?$od_express = $this->params["od_express"]:$od_express =0; //物流ID
    	isset($this->params["od_expressnum"])?$od_expressnum = $this->params["od_expressnum"]:$od_expressnum =''; //物流号
    	isset($this->params["od_remark"])?$od_remark = $this->params["od_remark"]:$od_remark =''; //0初始化 1确定完成
     	if(!$this->is_jxuser_login($user_id)){
			$this->err_get(5);
        }
        if ($init>0)
        {
        	if ($od_id>0)
        	{
			    if(!($od_express>=0)){
					$this->err_get('请选择物流快递');
				}
				if(!preg_match("/^[a-zA-Z0-9_-]{6,20}$/",$od_expressnum)){
					$this->error('订单号仅支持6-20个字母、数字、下划线和减号');
				}	


				$Dealer=M('Dealer');
				$map=array();
				$map['dl_id']=$user_id;
				$map['dl_unitcode']=$this->qy_unitcode;
				$map['dl_status']=1;
				$data=$Dealer->where($map)->find();
				if($data){
					$dl_type=$data['dl_type'];
					$dl_name=$data['dl_name'];//发货人
					$dl_username=$data['dl_username'];//发货人
					$dl_belong=$data['dl_belong'];//发货人上级
				}else{
					$this->err_get(4);
				}

				$Orders=M('Orders');
				$map=array();
				$map['od_unitcode']=$this->qy_unitcode;
				$map['od_id']=$od_id;
				$map['od_rcdlid']=$user_id;
				$data =$Orders->where($map)->find();
				if($data){	
					//检测是否能发货 //订购数 发货数
					$Orderdetail =M('Orderdetail');
					$Shipment =M('Shipment');
					$map2=array();
					$oddetail=array();
					$map2['oddt_unitcode']=$this->qy_unitcode;
					$map2['oddt_odid']=$od_id;
					// $map2['oddt_odblid']=$odbl_id;  //订单关系id
					$oddetail = $Orderdetail->where($map2)->order('oddt_id DESC')->limit(100)->select();
					$proids=array();
					foreach($oddetail as $kk=>$vv){

						$proids[]=$vv['oddt_proid'];

						//订购数 
						$oddt_totalqty=0;
						$oddt_unitsqty=0;
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
						
						//发货数
						$map3=array();
						$data3=array();
						$map3['ship_pro']=$vv['oddt_proid'];
						$map3['ship_unitcode']=$this->qy_unitcode;
						$map3['ship_odid']=$vv['oddt_odid'];
						$map3['ship_dealer']=$data['od_oddlid']; //出货接收方
						$data3=$Shipment->where($map3)->sum('ship_proqty');
						if($data3){
							if($oddt_totalqty==0 || $oddt_totalqty>$data3 ){
								$this->err_get("该订单还没完成出货");
							}	
							
                            if( $oddt_totalqty<$data3){
                            	$this->err_get("该订单出货的数量大于订购数量");
							}
						}else{
							$this->err_get("该订单还没完成出货");
						}
					}
				}else{
					$this->err_get("该订单记录不存在");
				}
				
                $Orders=M('Orders');		
				//写入物流信息
				$map2=array();
				$updata2=array();
				$map2['od_unitcode']=$this->qy_unitcode;
				$map2['od_id']=$od_id;
				
				$updata2['od_express']=$od_express;
				$updata2['od_expressnum']=$od_expressnum;
				$updata2['od_remark']=$od_remark;
				if(!($data['od_expressdate']>0)){
				    $updata2['od_expressdate']=time();
				}
				// $Orders->where($map2)->save($updata2);
				$Orders->where($map2)->data($updata2)->save(); //tp5.0
				// //订单关系状态更改
				// $map2=array();
				// $updata2=array();
				// $map2['odbl_unitcode']=$this->qy_unitcode;
				// $map2['odbl_id']=$odbl_id;
				// $updata2['odbl_state']=3; //0--待确认  1--代发货 2--部分发货 3-已发货 8-已完成 9-已取消
				// $Orderbelong->where($map2)->save($updata2);
				
				// //修改原始订单状态
				// if($data['od_oddlid']==$data['odbl_oddlid']){
					$map2=array();
					$updata2=array();
					$map2['od_unitcode']=$this->qy_unitcode;
					$map2['od_id']=$od_id;
					$updata2['od_state']=3;
					$Orders->where($map2)->data($updata2)->save(); //tp5.0
				// }
				
				if($data['od_express']<=0){

					//订单返利 begin
					$fanli_dlid1=0; //返利给的代理商1
					$fanli_dlid2=0; //返利给的代理商2
					
					$fanli_dlname1='';
					$fanli_dlname2='';
					$Dealer =M('Dealer');
					$Fanlidetail =M('Fanlidetail');
					//下单人
					$map3=array();
					$orderdealer=array();
					$map3['dl_unitcode'] = $this->qy_unitcode;
					$map3['dl_id'] = $data['od_oddlid'];  //下单的代理
					$orderdealer=$Dealer->where($map3)->find();
					if($orderdealer){
						$Profanli=M('Profanli');
						$map2=array();
						$map2['pfl_unitcode'] = $this->qy_unitcode;
						$map2['pfl_dltype'] = $orderdealer['dl_type'];

						// $where=array();
						// $where['pfl_fanli1'] = array('GT',0);
						// $where['pfl_maiduan'] = array('GT',0);  //是否设置卖断返利
						// $where['_logic'] = 'or';
						// $map2['_complex'] = $where;
						$map2['pfl_fanli1|pfl_maiduan']=array('GT',0); //tp5.0	
						if($proids){
							$map2['pfl_proid'] = array('IN',$proids);
						}
						$data2=$Profanli->where($map2)->find(); //是否有设置返利

						if($data2){
							if($orderdealer['dl_referee']>0){
								
								//下单代理的推荐人 如果正常并与发货人不同 则返利
								$map4=array();
								$data4=array();
								$map4['dl_unitcode'] = $this->qy_unitcode;
								$map4['dl_id'] = $orderdealer['dl_referee'];  //下单代理的推荐人
								$map4['dl_status'] = 1;
								
								$data4=$Dealer->where($map4)->find();
								if($data4){
									//如果推荐人和发货人不相同 则都返利给推荐人
									if($user_id !=$data4['dl_id']){
										
										//如果下单人级别相同 仅同级返利
										if($orderdealer['dl_level'] == $data4['dl_level']){
											//如果总代或董事级别 
											$fanli_dlid1=$data4['dl_id']; //返利给的代理商1
											$fanli_dlname1=$data4['dl_username'];
											//推荐人的推荐人
											if($data4['dl_referee']>0){
												$map6=array();
												$data6=array();
												$map6['dl_unitcode'] = $this->qy_unitcode;
												$map6['dl_id'] = $data4['dl_referee'];  //推荐人的推荐人
												$map6['dl_status'] = 1;
												$data6=$Dealer->where($map6)->find();
												if($data6){
													//如果推荐人的推荐人和发货人不相同 则都返利给推荐人 并同级
													if($user_id != $data6['dl_id']){
														if($data4['dl_type']==$data6['dl_type']){
															$fanli_dlid2=$data6['dl_id']; //返利给的代理商2
															$fanli_dlname2=$data6['dl_username'];
														}
													}
												}
											}
												
										}
									}
								}
								
					
								//写入返利数据
								if($fanli_dlid1>0){									
									foreach($oddetail as $kk=>$vv){
										$map7=array();
										$data7=array();
										$map7['pfl_unitcode'] = $this->qy_unitcode;
										$map7['pfl_proid'] = $vv['oddt_proid'];
										$map7['pfl_dltype'] = $orderdealer['dl_type'];
										$map7['pfl_fanli1'] = array('GT',0);
										$data7=$Profanli->where($map7)->find();
										//如果订单产品有设置返利 1层
										if($data7){
											if($data7['pfl_fanli1']>0){
												$map8=array();
												$data8=array();
												$map8['fl_unitcode'] = $this->qy_unitcode;
												$map8['fl_type'] = 2;
												$map8['fl_odid'] = $vv['oddt_odid'];
												$map8['fl_proid'] = $vv['oddt_proid'];
												$map8['fl_oddlid'] = $orderdealer['dl_id'];
												$map8['fl_level'] = 1;
												$data8 = $Fanlidetail->where($map8)->find();
												if(!$data8){
													//佣金数字在1-0间，则以下单价的百分比计算，如0.03代表以下单价的3%计算，如果大于1，则以具体多少元计算
													if($data7['pfl_fanli1']>0 && $data7['pfl_fanli1']<1){
														$pfl_fanli1sum=$data7['pfl_fanli1']*$vv['oddt_dlprice']*$vv['oddt_qty'];
													}else{
														$pfl_fanli1sum=$data7['pfl_fanli1']*$vv['oddt_qty'];
													}
													
													$data5=array();
													$data5['fl_unitcode'] = $this->qy_unitcode;
													$data5['fl_dlid'] = $fanli_dlid1; //获得返利的代理
													$data5['fl_senddlid'] =$user_id; //0公司发放返利
													$data5['fl_type'] = 2; //返利分类 1-推荐返利 2-订单返利  11-提现减少返利 (1-10 增加返利 11-20 减少返利)  
													$data5['fl_money'] = $pfl_fanli1sum;
													$data5['fl_refedlid'] = 0; //推荐返利中被推荐的代理
													$data5['fl_oddlid'] = $orderdealer['dl_id']; //订单返利中 下单的代理
													$data5['fl_odid'] = $vv['oddt_odid'];  //订单返利中 订单流水id
													$data5['fl_orderid']  = $vv['oddt_orderid']; //订单返利中 订单id
													$data5['fl_proid']  = $vv['oddt_proid'];  //订单返利中 产品id
													$data5['fl_odblid']  = $vv['oddt_odblid'];  //订单返利中 订单关系id
													$data5['fl_qty']  = $vv['oddt_qty'];  //订单返利中 产品数量
													$data5['fl_level']  = 1;  //返利的层次，1-第一层返利 2-第二层返利
													$data5['fl_addtime']  = time();
													$data5['fl_remark'] ='代理 '.$orderdealer['dl_username'].' 订购 '.$vv['oddt_proname'].' 数量 '.$vv['oddt_qty'] ;
													// $rs5=$Fanlidetail->insertGetId($data5);//tp5.0
													$rs5=$Fanlidetail->create($data5,1);
													if($rs5){
														$Fanlidetail->add();
													}
												}
											}
										}
										
										//如果有设置2层返利
										if($fanli_dlid2>0){
											$map7=array();
											$data7=array();
											$map7['pfl_unitcode'] = $this->qy_unitcode;
											$map7['pfl_proid'] = $vv['oddt_proid'];
											$map7['pfl_dltype'] = $orderdealer['dl_type'];
											$map7['pfl_fanli2'] = array('GT',0);
											$data7=$Profanli->where($map7)->find();
											if($data7){
												if($data7['pfl_fanli2']>0){
													$map8=array();
													$data8=array();
													$map8['fl_unitcode'] = $this->qy_unitcode;
													$map8['fl_type'] = 2;
													$map8['fl_odid'] = $vv['oddt_odid'];
													$map8['fl_proid'] = $vv['oddt_proid'];
													$map8['fl_oddlid'] = $orderdealer['dl_id'];
													$map8['fl_level'] = 2;
													$data8 = $Fanlidetail->where($map8)->find();
													if(!$data8){
														//佣金数字在1-0间，则以下单价的百分比计算，如0.03代表以下单价的3%计算，如果大于1，则以具体多少元计算
														if($data7['pfl_fanli2']>0 && $data7['pfl_fanli2']<1){
															$pfl_fanli2sum=$data7['pfl_fanli2']*$vv['oddt_dlprice']*$vv['oddt_qty'];
														}else{
															$pfl_fanli2sum=$data7['pfl_fanli2']*$vv['oddt_qty'];
														}
														
														$data5=array();
														$data5['fl_unitcode'] = $this->qy_unitcode;
														$data5['fl_dlid'] = $fanli_dlid2; //获得返利的代理
														$data5['fl_senddlid'] =$user_id; //发放返利的代理
														$data5['fl_type'] = 2; //返利分类 1-推荐返利 2-订单返利  11-提现减少返利 (1-10 增加返利 11-20 减少返利)  
														$data5['fl_money'] = $pfl_fanli2sum;
														$data5['fl_refedlid'] = 0; //推荐返利中被推荐的代理
														$data5['fl_oddlid'] = $orderdealer['dl_id']; //订单返利中 下单的代理
														$data5['fl_odid'] = $vv['oddt_odid'];  //订单返利中 订单流水id
														$data5['fl_orderid']  = $vv['oddt_orderid']; //订单返利中 订单id
														$data5['fl_proid']  = $vv['oddt_proid'];  //订单返利中 产品id
														$data5['fl_odblid']  = $vv['oddt_odblid'];  //订单返利中 订单关系id
														$data5['fl_qty']  = $vv['oddt_qty'];  //订单返利中 产品数量
														$data5['fl_level']  = 2;  //返利的层次，1-第一层返利 2-第二层返利
														$data5['fl_addtime']  = time();
														$data5['fl_remark'] ='代理 '.$fanli_dlname1.' 的邀请代理 '.$orderdealer['dl_username'].' 订购 '.$vv['oddt_proname'].' 数量 '.$vv['oddt_qty'] ;
														// $rs5=$Fanlidetail->insertGetId($data5);//tp5.0
														$rs5=$Fanlidetail->create($data5,1);
														if($rs5){
															$Fanlidetail->add();
														}
													}
												}
											}
										}
									}
								}	
							}
					    }
						
						
						//积分 begin
						$Product=M('Product');
						$Dljfdetail=M('Dljfdetail');
						foreach($oddetail as $kk=>$vv){
							$map7=array();
							$data7=array();
							$map7['pro_unitcode'] = $this->qy_unitcode;
							$map7['pro_id'] = $vv['oddt_proid'];
							$map7['pro_active'] = 1;
							$data7=$Product->where($map7)->find();
							if($data7){
								//如果有积分
								if($data7['pro_dljf']>0){
									$map8=array();
									$data8=array();
									$map8['dljf_unitcode'] = $this->qy_unitcode;
									$map8['dljf_type'] = 1;  //积分分类 1-5增加积分     6-9 消费积分
									$map8['dljf_odid'] = $vv['oddt_odid'];
									$map8['dljf_odblid'] = $vv['oddt_odblid'];
									$map8['dljf_proid'] = $vv['oddt_proid'];
									$map8['dljf_dlid'] = $orderdealer['dl_id'];
									$data8 = $Dljfdetail->where($map8)->find();
									
									if(!$data8){
										$data5=array();
										$data5['dljf_unitcode'] = $this->qy_unitcode;
										$data5['dljf_dlid'] = $orderdealer['dl_id']; //获得积分的代理
										$data5['dljf_username'] = $orderdealer['dl_username']; //获得积分的代理
										$data5['dljf_type'] = 1; //积分分类 1-订购产品积分 积分分类 1-5增加积分  6-9 消费积分
										$data5['dljf_jf'] = $data7['pro_dljf']*$vv['oddt_qty'];
										$data5['dljf_addtime'] = time(); 
										$data5['dljf_ip'] = real_ip(); 
										$data5['dljf_actionuser'] =$user_id;  
										$data5['dljf_odid']  = $vv['oddt_odid']; 
										$data5['dljf_orderid']  = $vv['oddt_orderid']; 
										$data5['dljf_odblid']  = $vv['oddt_odblid'];  
										$data5['dljf_proid']  = $vv['oddt_proid'];  
										$data5['dljf_qty']  = $vv['oddt_qty'];  
										$data5['dljf_remark'] ='订购产品 '.$vv['oddt_proname'].' 获得积分,数量 '.$vv['oddt_qty'] ;
										// $rs5=$Dljfdetail->insertGetId($data5);//tp5.0
										$rs5=$Dljfdetail->create($data5,1);
										if($rs5){
											$Dljfdetail->add();
										}
									}
								}
							}
						}
						//积分 end
						
					}
					//返利 end

					//订单操作日志 begin
					// $version =$this->request->header('version');
     //    			if($version==null) $version = "v1";
					$odlog_arr=array(
								'odlg_unitcode'=>$this->qy_unitcode,  
								'odlg_odid'=>$od_id,
								'odlg_orderid'=>$data['od_orderid'],
								'odlg_dlid'=>$user_id,
								'odlg_dlusername'=>$dl_username,
								'odlg_dlname'=>$dl_name,
								'odlg_action'=>'完成发货',
								'odlg_type'=>1, //0-企业 1-经销商
								'odlg_addtime'=>time(),
								'odlg_ip'=>real_ip(),
								'odlg_link'=>$_SERVER["HTTP_HOST"].'kangli/klapi/controller/orders/odship_finish'
								// 'odlg_link'=>__SELF__,
								);
					$Orderlogs =M('Orderlogs');
					$rs3=$Orderlogs->create($odlog_arr,1);
					if($rs3){
						$Orderlogs->add();
					}
					// $rs3=$Orderlogs->data($odlog_arr)->insert();
					//订单操作日志 end
				}
				$ret=array('msg'=>'物流信息提交成功');
				return $ret;
        	}else
        	{
        		$this->err_get(30);
        	}
        }else
        {
			if ($od_id>0)
        	{
        		$Orders=M('Orders');
				$map=array();
				$map['od_unitcode']=$this->qy_unitcode;
				$map['od_id']=$od_id;
				$map['od_rcdlid']=$user_id;
				$data =$Orders->where($map)->find();
				if($data){
					//检测是否能发货 //订购数 发货数
					$Orderdetail =M('Orderdetail');
					$Shipment =M('Shipment');
					$map2=array();
					$data2=array();
					$map2['oddt_unitcode']=$this->qy_unitcode;
					$map2['oddt_odid']=$od_id;
					$data2 = $Orderdetail->where($map2)->order('oddt_id DESC')->limit(100)->select();
					
					foreach($data2 as $kk=>$vv){
						//订购数 
						$oddt_totalqty=0;
						$oddt_unitsqty=0;
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

						//发货数
						$map3=array();
						$data3=array();
						$map3['ship_pro']=$vv['oddt_proid'];
						$map3['ship_unitcode']=$this->qy_unitcode;
						$map3['ship_odid']=$vv['oddt_odid'];
						$map3['ship_oddtid']=$vv['oddt_id'];
						$map3['ship_dealer']=$data['od_oddlid']; //出货接收方
						$data3=$Shipment->where($map3)->sum('ship_proqty');
						if($data3){
							if($oddt_totalqty==0 || $oddt_totalqty>$data3 ){
								$this->err_get(53);
							}	
							if( $oddt_totalqty<$data3){
								$this->err_get(54);
							}
						}else{
							$this->err_get(53);
						}
					}
					
                    if($data['od_express']<=0){
						$title='确认完成发货';
					}else{
						$title='确认修改物流';
					}
				}else{
					$this->err_get(30);
				}
        	}else
        	{
        		$this->err_get(30);
        	}
        	//物流快递
			$Express =M('Express');
			$map=array();
			$expresslist = $Express->where($map)->order('exp_addtime DESC')->select();
			$ret=array('title' =>$title,'expresslist' =>$expresslist,'ordersinfo' =>$data);
			return $ret;
        }
	}

     /**
	 * order_scan_init 订单扫描初始化
	 * @return [type] [description]
	 */
    public function odship_scan_init(){
    	isset($this->params["user_id"])?$user_id = $this->params["user_id"]:$user_id = ''; //用户ID
    	isset($this->params["od_id"])?$od_id = $this->params["od_id"]:$od_id =''; //订单ID
    	isset($this->params["oddt_id"])?$oddt_id = $this->params["oddt_id"]:$oddt_id =0; //详情ID
     	if(!$this->is_jxuser_login($user_id)){
			$this->err_get(5);
        }	

        if($od_id!=''&&$oddt_id>0){
        	//对应订单
			$Orders=M('Orders');
			$map=array();
			$order=array();
			$map['od_unitcode']=$this->qy_unitcode;
			$map['od_id']=$od_id;
			$order = $Orders->where($map)->find();
			if($order){
				if($order['od_state']!=1 && $order['od_state']!=2){
					$this->err_get(48);
				}
			}else{
				$this->err_get(30);
			}

			$Dealer=M('Dealer');
			$map=array();
			$map['od_unitcode']=$this->qy_unitcode;
			$map['od_id']=$od_id;
			$data =$Orders->where($map)->find();
			if($data){
				//订单产品详细
				$odtotalqty=0; //订单总数量
				$Orderdetail=M('Orderdetail');
				$Product=M('Product');
				$Shipment =M('Shipment');
				$Express =M('Express');
				
				$map2=array();
				$data2=array();
				$map2['oddt_unitcode']=$this->qy_unitcode;
				$map2['oddt_odid']=$data['od_id'];
				// $map2['oddt_odblid']=$data['odbl_id'];
				$data2 = $Orderdetail->where($map2)->order('oddt_id DESC')->limit(100)->select();
				// $ImagePath=$this->request->domain().'/Kangli/Public/uploads/product/';
				foreach($data2 as $kk=>$vv){
					//产品
					$map3=array();
					$data3=array();
					$map3['pro_id']=$vv['oddt_proid'];
					$map3['pro_unitcode']=$this->qy_unitcode;
					$data3=$Product->where($map3)->find();
					if($data3){
						if(is_not_null($data3['pro_pic'])){
							$data2[$kk]['oddt_propic']=$this->ImagePath.$data3['pro_pic'];
						}else{
							$data2[$kk]['oddt_propic']='';
						}
					}else{
						$data2[$kk]['oddt_propic']='';
					}
					
					//订购数 发货数
					$oddt_totalqty=0;
					$oddt_unitsqty=0;
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
					$data2[$kk]['oddt_totalqty']=$odtotalqty;
					
					$map3=array();
					$data3=array();
					$map3['ship_pro']=$vv['oddt_proid'];
					$map3['ship_unitcode']=$this->qy_unitcode;
					$map3['ship_odid']=$vv['oddt_odid'];
					$map3['ship_deliver']=$user_id; //出货方
					$data3=$Shipment->where($map3)->sum('ship_proqty');
					if($data3){
						$data2[$kk]['oddt_shiptatolqty']=$data3;
						if($oddt_unitsqty>0){
							$data2[$kk]['oddt_shipqty']=floor($data3/$oddt_unitsqty);
						}else{
							$data2[$kk]['oddt_shipqty']=$data3;		
						}
					}else{
						$data2[$kk]['oddt_shiptatolqty']=0;
						$data2[$kk]['oddt_shipqty']=0;
					}
				}
				$data['od_totalqty']=$odtotalqty;
				$data['orderdetail']=$data2;

				//下单代理信息
				$map3=array();
				$data3=array();
				$map3['dl_id']=$data['od_oddlid'];
				$map3['dl_unitcode']=$this->qy_unitcode;
				$data3=$Dealer->where($map3)->find();
				if($data3){
					$data['od_dl_name']=$data3['dl_name'];
					$data['od_dl_tel']=substr($data3['dl_tel'],0,3).'****'.substr($data3['dl_tel'],-4);
					$data['od_dl_weixin']=substr($data3['dl_weixin'],0,1).'****'.substr($data3['dl_weixin'],-4);
				}else{
					$data['od_dl_name']='';
					$data['od_dl_tel']='';
					$data['od_dl_weixin']='';
				}

				if($data['od_addtime']>0){
					$data['od_addtime_str']=date('Y-m-d H:i:s',$data['od_addtime']);
					$data['od_addtime_str2']=date('Y-m-d',$data['od_addtime']);
				}

				//状态
				if($data['od_state']==0){
					$data['od_state_str']='待确认';
				}else if($data['od_state']==1){
					$data['od_state_str']='待发货';
				}else if($data['od_state']==2){
					$data['od_state_str']='部分发货';
				}else if($data['od_state']==3){
					$data['od_state_str']='已发货';
				}else if($data['od_state']==8){
					$data['od_state_str']='已完成';
				}else if($data['od_state']==9){
					$data['od_state_str']='已取消';
				}else{
					$data['od_state_str']='未知';
				}
						
				// if(is_not_null($data['od_paypic']) && file_exists($imgpath2.$data['od_paypic'])){
				if(is_not_null($data['od_paypic'])){
					$data['od_paypic_str']=$this->ODPath.$data['od_paypic'];
				}else{
					$data['od_paypic_str']='';
				}
				//快递物流
				if($data['od_express']>0){
				    $map3=array();
					$data3=array();
					$map3['exp_id']=$data['od_express'];
					$data3=$Express->where($map3)->find();
					if($data3){
						$data['od_expressname']=$data3['exp_name'];
						//可以从快递100接口获取数据	
					}else{
						$data['od_expressname']='';
					}
				}else{
					$data['od_expressname']='';
				}

				//统计扫描纪录 已扫产品数量 Cache 保存json数据
				$scan_cache_key=$this->qy_unitcode.$user_id.'_'.$od_id.'_'.$oddt_id;
				// $scanls=Cache::store('redis')->pull($scan_cache_key);
				// $scanls=Cache::store('redis')->get($scan_cache_key);
				$scanls=S($scan_cache_key);
				if (!is_not_null($scanls))
					$scanls=array();
				$ret = array('orderdt' =>$data,'scanls'=>$scanls);
				return $ret;
			}else{
				$this->err_get(30);
			}
		}else{
			$this->err_get(30);
		}
    }

   	//出货扫描
    public function odship_scan(){
    	isset($this->params["user_id"])?$user_id = $this->params["user_id"]:$user_id = ''; //用户ID
    	isset($this->params["od_id"])?$od_id = $this->params["od_id"]:$od_id = ''; //订单ID
    	isset($this->params["oddt_id"])?$oddt_id = $this->params["oddt_id"]:$oddt_id =0; //订单详情ID
    	isset($this->params["brcode"])?$brcode = $this->params["brcode"]:$brcode =0; //条码
    	isset($this->params["sctype"])?$sctype = $this->params["sctype"]:$sctype =0; //sctype 0 增加条码 1 删除
     	if(!$this->is_jxuser_login($user_id)){
			$this->err_get(5);
        }

        $msg='';
        $scan_cache_key=$this->qy_unitcode.$user_id.'_'.$od_id.'_'.$oddt_id;
        $success=0;
		if($brcode==''){
			$msg='条码不能为空';
			goto gotoEND;
            exit;
		}
		$barr=explode(',',$brcode);
		$brcode=end($barr);
        if(!preg_match("/^[a-zA-Z0-9]{4,30}$/",$brcode)){
			$msg='条码信息不正确';
			goto gotoEND;
            exit;
        }
		if($od_id>0 && $oddt_id>0)
		{
			if  ($sctype==0)
				{
				//==================================增加扫描条码
	            //对应订单
				$Orders=M('Orders');
				$map=array();
				$order=array();
				$map['od_unitcode']=$this->qy_unitcode;
				$map['od_id']=$od_id;
				$order =$Orders->where($map)->field('od_oddlid,od_state')->find();
				if($order){
					if($order['od_state']!=1 && $order['od_state']!=2){
						$this->err_get(48);
					}
				}else{
					$this->err_get(30);
				}
				
				//对应产品
				$Orderdetail=M('Orderdetail');
				$map=array();
				$oddetail=array();
				$map['oddt_unitcode']=$this->qy_unitcode;
				$map['oddt_id']=$oddt_id;
				$map['oddt_odid']=$od_id;
				$oddetail = $Orderdetail->where($map)->find();
				if($oddetail){
					//订购数 
					$oddt_totalqty=0;  //要发的总数
					$oddt_unitsqty=0;  //一个包装里的产品数
					if($oddetail['oddt_prodbiao']>0){
						$oddt_unitsqty=$oddetail['oddt_prodbiao'];
						
						if($oddetail['oddt_prozbiao']>0){
							$oddt_unitsqty=$oddt_unitsqty*$oddetail['oddt_prozbiao'];
						}
						
						if($oddetail['oddt_proxbiao']>0){
							$oddt_unitsqty=$oddt_unitsqty*$oddetail['oddt_proxbiao'];
						}
						
						$oddt_totalqty=$oddt_unitsqty*$oddetail['oddt_qty'];
					}else{
						$oddt_totalqty=$oddetail['oddt_qty'];
					}
					
					if($oddt_totalqty==0 || $oddt_totalqty==$oddetail['oddt_qty']){
						$oddetail['oddt_totalqty']=0;
					}else{
						$oddetail['oddt_totalqty']=$oddt_totalqty;
					}
					
					 $oddetail['oddt_proname']=$oddetail['oddt_proname'].$oddetail['oddt_color'].$oddetail['oddt_size'];
					 
					//发货数
					$Shipment=M('Shipment');
					$map3=array();
					$shipproqty=0;
					$map3['ship_pro']=$oddetail['oddt_proid'];
					$map3['ship_unitcode']=$this->qy_unitcode;
					$map3['ship_odid']=$oddetail['oddt_odid'];
					$map3['ship_oddtid']=$oddetail['oddt_id'];
					$map3['ship_dealer']=$order['od_oddlid']; //出货接收方
					$shipproqty=$Shipment->where($map3)->sum('ship_proqty');  //已发的产品数
					if($shipproqty){
						$oddetail['oddt_shiptatolqty']=$shipproqty;
						if($oddt_unitsqty>0){
							$oddetail['oddt_shipqty']=floor($shipproqty/$oddt_unitsqty);
						}else{
							$oddetail['oddt_shipqty']=$shipproqty;
						}
					}else{
						$oddetail['oddt_shiptatolqty']=0;
						$oddetail['oddt_shipqty']=0;
					}
					
					//统计扫描纪录 已扫产品数量 session 保存json数据
					$scanls=S($scan_cache_key);
					if (!is_not_null($scanls))
						$scanls=array();
					$scancount=0; //已扫标签数
					$scanprocount=0; //已扫产品数
					if(is_not_null($scanls)){
						foreach($scanls as $k=>$v){
							if(intval($v['scanNum'])>0){
								$scancount=$scancount+1;
								$scanprocount=$scanprocount+intval($v['scanNum']);
							}else{
								unset($scanls[$k]);
							}
						}
					}

					//判断出货的数量是否等于订购数量
					if($oddt_totalqty<=($scanprocount+$shipproqty)){
						$this->err_get(50);
					}
					
					//检测该条码是否属于该经销商1
					$map=array();
					$data=array();
					$Chaibox=M('Chaibox');
					$barcode=array();
					
					$map['ship_unitcode']=$this->qy_unitcode;
					$map['ship_dealer']=$user_id;   //ship_deliver--出货方   ship_dealer--收货方
					$map['ship_barcode'] = $brcode;
					$map['ship_pro'] = $oddetail['oddt_proid'];  //对应产品id
					$map3['ship_oddtid']=$oddetail['oddt_id'];
					$data=$Shipment->where($map)->find();
					if($data){
						//检测该条码是否已被使用1
						$map2=array();
						$map2['ship_unitcode']=$this->qy_unitcode;
						$map2['ship_barcode'] = $brcode;
						$map2['ship_deliver']=$user_id;
						
						$data2=$Shipment->where($map2)->find();
						if($data2){
							$msg='条码 <b>'.$brcode.'</b> 已出货';
							goto gotoEND;
							exit;
						}else{
							$barcode['code']=$data['ship_barcode'];
							$barcode['tcode']=$data['ship_tcode'];
							$barcode['ucode']=$data['ship_ucode'];
							$barcode['qty']=$data['ship_proqty'];
							$barcode['pro']=$data['ship_pro'];
							$barcode['shipnumber']=$data['ship_number'];
							$barcode['pro_name']=$oddetail['oddt_proname'];
						}
						
						//判断出货的数量是否等于订购数量 加上正在扫的
						if($oddt_totalqty<($scanprocount+$shipproqty+$barcode['qty'])){
							$this->err_get(49);
						}
					}else{
						//检测是否已发行
						$barcode=wlcode_to_packinfo($brcode,$this->qy_unitcode);
						if(!is_not_null($barcode)){
							$msg='条码 <b>'.$brcode.'</b> 不存在或还没发行';
							goto gotoEND;
							exit;
						}
						$barcode['pro_name']=$oddetail['oddt_proname'];	

						//检测该条码是否属于该经销商2
						$map=array();
						$where=array();
						
						//tcode-  中标    ucode-大标   code--当前条码
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
						$map['ship_dealer']=$user_id;   //ship_deliver--出货方   ship_dealer--收货方
						$map['ship_pro'] = $oddetail['oddt_proid'];  //对应产品id
						$map3['ship_oddtid']=$oddetail['oddt_id'];
						$data=$Shipment->where($map)->find();
						if(is_not_null($data)){
							//检测该条码是否已被使用2
							$map2=array();
							$where2=array();

							if($barcode['code']!=''){
								$where2[]=array('EQ',$barcode['code']);
							}
							if($barcode['tcode']!='' && $barcode['ucode']!=$barcode['tcode']){
								$where2[]=array('EQ',$barcode['tcode']);
							}
							if($barcode['ucode']!='' &&  $barcode['ucode']!=$barcode['tcode']){
								$where2[]=array('EQ',$barcode['ucode']);
							}
							if($barcode['ucode']!='' &&  $barcode['ucode']==$barcode['tcode']){
								$where2[]=array('EQ',$barcode['ucode']);
							}
							
							
							$where2[]='or';
							$map2['ship_barcode'] = $where2;
							$map2['ship_unitcode']=$this->qy_unitcode;
							$map2['ship_deliver']=$user_id;  //ship_deliver--出货方   ship_dealer--收货方
							$map3['ship_oddtid']=$oddetail['oddt_id'];
							$data2=$Shipment->where($map2)->find();
							if($data2){
								$msg='条码 <b>'.$brcode.'</b> 已出货';
								goto gotoEND;
								exit;
							}	
							$barcode['pro']=$data['ship_pro'];
							$barcode['shipnumber']=$data['ship_number'];

							//判断出货的数量是否等于订购数量 加上正在扫的
							if($oddt_totalqty<($scanprocount+$shipproqty+$barcode['qty'])){
								$this->err_get(49);
							}
						}else{
							$msg='对不起，你没有条码 <b>'.$brcode.'</b> 操作权限，或该条码产品与发货产品不对应';
							$barcode=array();
							goto gotoEND;
							exit;
						}	
					}
					
					//检测是否拆箱
					$map2=array();
					$map2['chai_unitcode']=$this->qy_unitcode;
					$map2['chai_barcode'] =$brcode;
					$map2['chai_deliver'] =$user_id; //ship_deliver--出货方   ship_dealer--收货方
					$data2=$Chaibox->where($map2)->find();
					if($data2){
						$msg='条码 <b>'.$brcode.'</b> 已经拆箱，不能再使用';
						$barcode=array();
						goto gotoEND;
						exit;
					}
					if(is_not_null($barcode)){
						if(is_not_null($scanls)){
							$hasMinCode=false;
							foreach ($scanls as $k => $v) {
								if ($v['scanCode']==$brcode)
								{
									$msg='条码 <b>'.$brcode.'</b> 已在扫描记录里';
									$barcode=array();
									goto gotoEND;
									exit;
								}
								if($barcode['tcode']=='' && $barcode['ucode']==''){
									$pos=strpos($v['scanCode'],$brcode);
	 								if ($pos===false) {

	 								}else
	 								{
										$hasMinCode=true;
	 								}
									// if(array_key_exists(strval($brcode.'_'),$value)===true){
									// 	$msg='条码 <b>'.$brcode.'</b> 的小标条码已在扫描记录里';
									// 	$barcode=array();
									// 	goto gotoEND;
									// 	exit;
									// }		
								}else{
									if($barcode['ucode']==$barcode['tcode']){
										if($v['scanCode']==$barcode['tcode']){	
											$msg='条码 <b>'.$brcode.'</b> 的大标条码已在扫描记录里';
											$barcode=array();
											goto gotoEND;
											exit;
										}else{
											$pos=strpos($v['scanCode'],$brcode);
			 								if ($pos===false) {

			 								}else
			 								{
												$hasMinCode=true;
			 								}
											// if(array_key_exists(strval($brcode.'_'),$value)===true){
											// 	$msg='条码 <b>'.$brcode.'</b> 的小标条码已在扫描记录里';
											// 	$barcode=array();
											// 	goto gotoEND;
											// 	exit;
											// }		
										}
									}else{
										if($v['scanCode']==$barcode['ucode']||$v['scanCode']==$barcode['tcode']){
											$msg='条码 <b>'.$brcode.'</b> 的大标条码已在扫描记录里';
											$barcode=array();
											goto gotoEND;
											exit;
										}
									}
								}
							}
							if($hasMinCode){
								$msg='条码 <b>'.$brcode.'</b> 的小标条码已在扫描记录里';
								$barcode=array();
								goto gotoEND;
								exit;
							}
						}
						$scanObj['scanCode']=$brcode;
						$scanObj['scanNum']=$barcode['qty'];
						array_push($scanls,$scanObj);
	                    // Cache::store('redis')->set($scan_cache_key,$scanls,720000);
	                    S($scan_cache_key,$scanls,720000);
						// $ret='条码 <b>'.$brcode.'</b> 扫描成功!';
						$ret=array('scanls' =>$scanls);
						return $ret;
					}else{
						$msg='对不起，你没有条码 <b>'.$brcode.'</b> 操作权限';
						$barcode=array();
						goto gotoEND;
						exit;
					}
				}else{
					$this->err_get(30);
				}
			}else
			{
				//==================================删除扫描条码
				//统计扫描纪录 已扫产品数量 Cache 保存json数据
				$scanls=S($scan_cache_key);
				if (!is_not_null($scanls))
					$scanls=array();
				foreach ($scanls as $k => $v) {
					if ($v['scanCode']==$brcode)
					{
						  unset($scanls[$k]);//函数删除的话，数组的索引值没有变化
						  // unset($scanls[$k]);//函数删除的话，数组的索引值没有变化
					}
				}
				$scanls=array_values($scanls); //array_values利用重新排序
				S($scan_cache_key,$scanls,720000);
				$ret=array('scanls' =>$scanls);
				return $ret;
			}
		}else{
			$this->err_get(30);
		}
		/////////////
		gotoEND:
		exit(json_encode(array('status' =>0,'msg'=>$msg)));
    }


    //确认出货
    public function odship_sumbit(){
    	isset($this->params["user_id"])?$user_id = $this->params["user_id"]:$user_id = ''; //用户ID
    	isset($this->params["od_id"])?$od_id = $this->params["od_id"]:$od_id = ''; //订单ID
    	isset($this->params["oddt_id"])?$oddt_id = $this->params["oddt_id"]:$oddt_id =0; //订单详情ID
    	isset($this->params["sctype"])?$sctype = $this->params["sctype"]:$sctype =0; //sctype 0 记录 1 新增
     	if(!$this->is_jxuser_login($user_id)){
			$this->err_get(5);
        }

        $scan_cache_key=$this->qy_unitcode.$user_id.'_'.$od_id.'_'.$oddt_id;
        if($od_id>0 && $oddt_id>0){
			//统计扫描纪录 已扫产品数量 Cache 保存json数据
			// $scanls=Cache::store('redis')->get($scan_cache_key);
			$scanls=S($scan_cache_key);
			$scancount=0; //已扫标签数
			$scanprocount=0; //已扫产品数
			if (!is_not_null($scanls))
				$scanls=array();
			if(is_not_null($scanls)){

				foreach ($scanls as $k => $v) {
					if(intval($v)>0){
						$scancount=$scancount+1;
						$scanprocount=$scanprocount+intval($v);
					}else{
						unset($scanls[$k]);
					}
				}
				$scanls=array_values($scanls); //array_values利用重新排序
				if(count($scanls)<=0){
					$this->err_get(51);
				}
			}else{
				$this->err_get(51);
			}
			
			//对应订单
			$Orders=M('Orders');
			$map=array();
			$order=array();
			$map['od_unitcode']=$this->qy_unitcode;
			$map['od_id']=$od_id;
			$order =$Orders->where($map)->field('od_oddlid,od_orderid,od_state')->find();
			if($order){
				if($order['od_state']!=1 && $order['od_state']!=2){
					$this->err_get(48);
				}
			}else{
				$this->err_get(30);
			}

			$ship_dealer=$order['od_oddlid']; //收货的经销商
			$od_orderid=$order['od_orderid'];
			unset($order);

			//对应产品
			$Orderdetail=M('Orderdetail');
			$Shipment=M('Shipment');
			$Chaibox=M('Chaibox');
			
			$map=array();
			$oddetail=array();
			$map['oddt_unitcode']=$this->qy_unitcode;
			$map['oddt_id']=$oddt_id;
			$map['oddt_odid']=$od_id;
			$oddetail = $Orderdetail->where($map)->find();
			if($oddetail){
				//订购数 发货数
				$oddt_totalqty=0;  //要发的总数
				$oddt_unitsqty=0;  //一个包装里的产品数
				if($oddetail['oddt_prodbiao']>0){
					$oddt_unitsqty=$oddetail['oddt_prodbiao'];
					
					if($oddetail['oddt_prozbiao']>0){
						$oddt_unitsqty=$oddt_unitsqty*$oddetail['oddt_prozbiao'];
					}
					
					if($oddetail['oddt_proxbiao']>0){
						$oddt_unitsqty=$oddt_unitsqty*$oddetail['oddt_proxbiao'];
					}
					
					$oddt_totalqty=$oddt_unitsqty*$oddetail['oddt_qty'];
				}else{
					$oddt_totalqty=$oddetail['oddt_qty'];
				}
				
				if($oddt_totalqty==0 || $oddt_totalqty==$oddetail['oddt_qty']){
					$oddetail['oddt_totalqty']='0';
				}else{
					$oddetail['oddt_totalqty']=$oddt_totalqty;
				}
				
				$oddetail['oddt_proname']=$oddetail['oddt_proname'].$oddetail['oddt_color'].$oddetail['oddt_size'];

				$map3=array();
				$shipproqty=0;  //已发的产品数
				$map3['ship_pro']=$oddetail['oddt_proid'];
				$map3['ship_unitcode']=$this->qy_unitcode;
				$map3['ship_odid']=$oddetail['oddt_odid'];
				$map3['ship_oddtid']=$oddetail['oddt_id'];
				$map3['ship_dealer']=$ship_dealer; //出货接收方
				$shipproqty=$Shipment->where($map3)->sum('ship_proqty');  //已发的产品数
				if($shipproqty){
					$oddetail['oddt_shiptatolqty']=$shipproqty;
					if($oddt_unitsqty>0){
						$oddetail['oddt_shipqty']=floor($shipproqty/$oddt_unitsqty);
					}else{
						$oddetail['oddt_shipqty']=$shipproqty;
					}
				}else{
					$oddetail['oddt_shiptatolqty']=0;
					$oddetail['oddt_shipqty']=0;
				}

				//判断出货的数量是否等于订购数量
				if($oddt_totalqty<($scanprocount+$shipproqty)){
					$this->err_get(50);
				}	
			}else{
				$this->err_get(30);
			}

			//验证经销商
			$Dealer =M('Dealer');
			$map2=array();
			$map2['dl_id']=$ship_dealer;
			$map2['dl_status']=1;
			$dealerinfo=$Dealer->where($map2)->find();
			if($dealerinfo){
				$dealerinfo['dl_name']=wxuserTextDecode2($dealerinfo['dl_name']);
			}else{
				$this->err_get(52);
			}

			//--------------------------------
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
			//保存出货记录
			$ship_time=time();
			$brcarr=array();
			$kk=0;
			$success=0;
			$fail=0;

			foreach($scanls as $key=>$v){
				$brcode=$v['scanCode'];
				if(!preg_match("/^[a-zA-Z0-9]{4,30}$/",$brcode)){
					$brcarr[$kk]['barcode']=$brcode;
					$brcarr[$kk]['error']='<span style="color:#FF0000">添加条码 '.htmlspecialchars($brcode).' 出错，条码应由数字字母组成</span>';
					$brcarr[$kk]['qty']=0;
					$kk=$kk+1;
					$fail=$fail+1;
					continue;
				}
						
				//检测该条码是否属于该经销商1
				$map=array();
				$data=array();
				$barcode=array();
				$map['ship_unitcode']=$this->qy_unitcode;
				$map['ship_dealer']=$user_id;   //ship_deliver--出货方   ship_dealer--收货方
				$map['ship_barcode'] = $brcode;
				$map['ship_pro'] = $oddetail['oddt_proid'];  //对应产品id
				$data=$Shipment->where($map)->find();
				if($data){
					//检测该条码是否已被使用1
					$map2=array();
					$data2=array();
					$map2['ship_unitcode']=$this->qy_unitcode;
					$map2['ship_barcode'] = $brcode;
					$map2['ship_deliver']=$user_id;
							
					$data2=$Shipment->where($map2)->find();
					if($data2){
						$brcarr[$kk]['barcode']=$brcode;
						$brcarr[$kk]['error']='<span style="color:#FF0000">添加条码 '.htmlspecialchars($brcode).' 出错，该条码已出货</span>';
						$brcarr[$kk]['qty']=0;
						$kk=$kk+1;
						$fail=$fail+1;
						continue;
					}else{
						$barcode['code']=$data['ship_barcode'];
						$barcode['tcode']=$data['ship_tcode'];
						$barcode['ucode']=$data['ship_ucode'];
						$barcode['qty']=$data['ship_proqty'];
						$barcode['pro']=$data['ship_pro'];
						$barcode['shipnumber']=$data['ship_number'];
					}
				}else{
					//检测是否已发行
					$barcode=wlcode_to_packinfo($brcode,$this->qy_unitcode);				
					if(!is_not_null($barcode)){
						$brcarr[$kk]['barcode']=$brcode;
						$brcarr[$kk]['error']='<span style="color:#FF0000">添加条码 '.htmlspecialchars($brcode).' 出错，该条码不存在或还没发行</span>';
						$brcarr[$kk]['qty']=0;
						$kk=$kk+1;
						$fail=$fail+1;
						continue;
					}
							
					//检测该条码是否属于该经销商2
					$map=array();
					$where=array();
					$data=array();
					
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
					$map['ship_dealer']=$user_id;   //ship_deliver--出货方   ship_dealer--收货方
					$map['ship_pro'] = $oddetail['oddt_proid'];  //对应产品id
					$data=$Shipment->where($map)->find();
					if(is_not_null($data)){
						//检测该条码是否已被使用2
						$map2=array();
						$where2=array();
						$data2=array();
						
						if($barcode['code']!=''){
							$where2[]=array('EQ',$barcode['code']);
						}
						if($barcode['tcode']!='' && $barcode['ucode']!=$barcode['tcode']){
							$where2[]=array('EQ',$barcode['tcode']);
						}
						if($barcode['ucode']!='' &&  $barcode['ucode']!=$barcode['tcode']){
							$where2[]=array('EQ',$barcode['ucode']);
						}
						if($barcode['ucode']!='' &&  $barcode['ucode']==$barcode['tcode']){
							$where2[]=array('EQ',$barcode['ucode']);
						}
						
						
						$where2[]='or';
						$map2['ship_barcode'] = $where2;
						$map2['ship_unitcode']=$this->qy_unitcode;
						$map2['ship_deliver']=$user_id;   //ship_deliver--出货方   ship_dealer--收货方
						$map2['ship_pro'] = $oddetail['oddt_proid'];  //对应产品id
						$data2=$Shipment->where($map2)->find();
						if($data2){
							$brcarr[$kk]['barcode']=$brcode;
							$brcarr[$kk]['error']='<span style="color:#FF0000">添加条码 '.htmlspecialchars($brcode).' 出错，该条码已出货</span>';
							$brcarr[$kk]['qty']=$barcode['qty'];
							$kk=$kk+1;
							$fail=$fail+1;
							continue;
						}
						$barcode['pro']=$data['ship_pro'];
						$barcode['whid']=$data['ship_whid'];
						$barcode['shipnumber']=$data['ship_number'];
					}else{
						$brcarr[$kk]['barcode']=$brcode;
						$brcarr[$kk]['error']='<span style="color:#FF0000">添加条码 '.htmlspecialchars($brcode).' 出错，你没有该条码操作权限，或该条码产品与发货产品不对应</span>';
						$brcarr[$kk]['qty']=$barcode['qty'];
						$kk=$kk+1;
						$fail=$fail+1;
						continue;
					}
				}
				//检测是否拆箱
				$map2=array();
				$data2=array();
				$map2['chai_unitcode']=$this->qy_unitcode;
				$map2['chai_barcode'] = $brcode;
				$map2['chai_deliver'] = $user_id;
				$data2=$Chaibox->where($map2)->find();
				if($data2){
					$brcarr[$kk]['barcode']=$brcode;
					$brcarr[$kk]['error']='<span style="color:#FF0000">添加条码 '.htmlspecialchars($brcode).' 出错，该条码已经拆箱，不能再使用</span>';
					$brcarr[$kk]['qty']=$barcode['qty'];
					$kk=$kk+1;
					$fail=$fail+1;
					continue;
				}
				//保存记录
				// $version =$this->request->header('version');
    			// if($version==null) $version = "v1";

				if(is_not_null($barcode)){
					$insert=array();
					$insert['ship_unitcode']=$this->qy_unitcode;
					$insert['ship_number']=$od_orderid;  //如果按订单发货 这里放订单号
					$insert['ship_deliver']=$user_id; //ship_deliver--出货方
					$insert['ship_dealer']=$ship_dealer;   //ship_dealer--收货方
					$insert['ship_pro']=$barcode['pro'];
					$insert['ship_odid']=$od_id;  //订单id
					// $insert['ship_odblid']=$odbl_id; //订单关系id
					$insert['ship_oddtid']=$oddt_id; //订单详细id
					$insert['ship_whid']=$barcode['whid'];
					$insert['ship_proqty']=$barcode['qty'];
					$insert['ship_barcode']=$brcode;
					$insert['ship_date']=$ship_time;
					$insert['ship_ucode']=$barcode['ucode'];
					$insert['ship_tcode']=$barcode['tcode'];
					$insert['ship_remark']=$oddetail['oddt_proname'];
					$insert['ship_cztype']=2;//操作类型 0-企业主账户  1-企业子管理用户  2-经销商
					$insert['ship_czid']=$user_id;
					$insert['ship_czuser']=$user_username;
						// $rs=$Shipment->insertGetId($insert);//tp5.0
						$rs=$Shipment->create($insert,1);//tp5.0
					if($rs){
						$retID=$Shipment->add();
						if ($retID>0){
							//记录拆箱
							if($barcode['ucode']!='' && $barcode['tcode']==$barcode['ucode']){
								$insert2=array();
								$data3=array();
								$insert2['chai_unitcode']=$this->qy_unitcode;
								$insert2['chai_barcode']=$barcode['ucode'];
								$insert2['chai_deliver']=session('jxuser_id');
								$data3=$Chaibox->where($insert2)->find();
								if(!$data3){
									$insert2['chai_addtime']=$ship_time;
									// $Chaibox->data($insert2)->insert(); //tp5.0
									$Chaibox->create($insert2,1);
									$Chaibox->add(); 
								}
							}
							
							if($barcode['ucode']!='' && $barcode['tcode']!=$barcode['ucode']){
								$insert3=array();
								$data4=array();
								$insert3['chai_unitcode']=$this->qy_unitcode;
								$insert3['chai_barcode']=$barcode['tcode'];
								$insert3['chai_deliver']=session('jxuser_id');
								$data4=$Chaibox->where($insert3)->find();
								if(!$data4){
									$insert3['chai_addtime']=$ship_time;
									// $Chaibox->data($insert3)->insert();//tp5.0
									$Chaibox->create($insert3,1);
									$Chaibox->add(); 
								}	
								
								$insert3=array();
								$data4=array();
								$insert3['chai_unitcode']=$this->qy_unitcode;
								$insert3['chai_barcode']=$barcode['ucode'];
								$insert3['chai_deliver']=session('jxuser_id');
								$data4=$Chaibox->where($insert3)->find();
								if(!$data4){
									$insert3['chai_addtime']=$ship_time;
									// $Chaibox->data($insert3)->insert();//tp5.0
									$Chaibox->create($insert3,1);
									$Chaibox->add(); 
								}
								
							}

							//记录日志 begin
							$log_arr=array();
							$log_arr=array(
										'log_qyid'=>$user_id,
										'log_user'=>$user_username,
										'log_qycode'=>$this->qy_unitcode,
										'log_action'=>'经销商出货',
										'log_type'=>2, //0-系统 1-企业 2-经销商 3-消费者
										'log_addtime'=>time(),
										'log_ip'=>real_ip(),
										'log_link'=>$_SERVER["HTTP_HOST"].'kangli/klapi/controller/orders/odshop_sumbit',
										// 'log_link'=>__SELF__,
										'log_remark'=>json_encode($insert)
										);
							save_log($log_arr);
							//记录日志 end
							//						
							$brcarr[$kk]['barcode']=$brcode;
							$brcarr[$kk]['error']='添加条码 <b>'.$brcode.' </b> 成功。';
							$brcarr[$kk]['qty']=$barcode['qty'];
							$kk=$kk+1;
							$success=$success+1;
							continue;
						}else
						{
							$brcarr[$kk]['barcode']=$brcode;
							$brcarr[$kk]['error']='<span style="color:#FF0000">添加条码 '.$brcode.'出错。条码不正确</span>';
							$brcarr[$kk]['qty']=0;
							$kk=$kk+1;
							$fail=$fail+1;
							continue;
						}
					}else{
						$brcarr[$kk]['barcode']=$brcode;
						$brcarr[$kk]['error']='<span style="color:#FF0000">添加条码 '.$brcode.'出错。条码不正确</span>';
						$brcarr[$kk]['qty']=0;
						$kk=$kk+1;
						$fail=$fail+1;
						continue;
					}
				}else{
					$brcarr[$kk]['barcode']=$brcode;
					$brcarr[$kk]['error']='<span style="color:#FF0000">添加条码 '.htmlspecialchars($brcode).' 出错，你没有该条码操作权限</span>';
					$brcarr[$kk]['qty']=0;
					$kk=$kk+1;
					$fail=$fail+1;
					continue;
				}
			}
			// Cache::store('redis')->rm($scan_cache_key);
			S($scan_cache_key,null);
			$ret=array('list' =>$brcarr,'success'=>$success,'fail'=>$fail);
			return $ret;
		}else
		{
			$this->err_get(4);
		}
    }
     //出货记录
    public function odship_record(){
    	isset($this->params["user_id"])?$user_id = $this->params["user_id"]:$user_id = ''; //用户ID
    	isset($this->params["od_id"])?$od_id = $this->params["od_id"]:$od_id = ''; //订单ID
    	isset($this->params["oddt_id"])?$oddt_id = $this->params["oddt_id"]:$oddt_id =0; //订单详情ID
    	isset($this->params["sctype"])?$sctype = $this->params["sctype"]:$sctype =0; //sctype 0 出货记录 1 扫描出货记录
     	if(!$this->is_jxuser_login($user_id)){
			$this->err_get(5);
        }

        if($od_id>0 && $oddt_id>0){
        	//对应订单
			$Orders=M('Orders');
			$Dealer=M('Dealer');

			$map=array();
			$order=array();
			$map['od_unitcode']=$this->qy_unitcode;
			$map['od_id']=$od_id;
			$order=$Orders->where($map)->field('od_oddlid,od_orderid,od_state,od_addtime')->find();
			if($order){
				if($order['od_state']!=1 && $order['od_state']!=2){
					$this->err_get(48);
				}
			}else{
				$this->err_get(30);
			}

			$ship_dealer=$order['od_oddlid']; //收货的经销商
			$od_orderid=$order['od_orderid'];

			//下单代理信息
			$map3=array();
			$data3=array();
			$map3['dl_id']=$order['od_oddlid'];
			$map3['dl_unitcode']=$this->qy_unitcode;
			$data3=$Dealer->where($map3)->find();
			if($data3){
				$order['od_dl_name']=$data3['dl_name'];
				$order['od_dl_tel']=substr($data3['dl_tel'],0,3).'****'.substr($data3['dl_tel'],-4);
				$order['od_dl_weixin']=substr($data3['dl_weixin'],0,1).'****'.substr($data3['dl_weixin'],-4);
			}else{
				$order['od_dl_name']='';
				$order['od_dl_tel']='';
				$order['od_dl_weixin']='';
			}

			if($order['od_addtime']>0){
				$order['od_addtime_str']=date('Y-m-d H:i:s',$order['od_addtime']);
				$order['od_addtime_str2']=date('Y-m-d',$order['od_addtime']);
			}

			//状态
			if($order['od_state']==0){
				$order['od_state_str']='待确认';
			}else if($order['od_state']==1){
				$order['od_state_str']='待发货';
			}else if($order['od_state']==2){
				$order['od_state_str']='部分发货';
			}else if($order['od_state']==3){
				$order['od_state_str']='已发货';
			}else if($order['od_state']==8){
				$order['od_state_str']='已完成';
			}else if($order['od_state']==9){
				$order['od_state_str']='已取消';
			}else{
				$order['od_state_str']='未知';
			}
			// unset($order);


			//对应产品
			$Orderdetail=M('Orderdetail');
			$Shipment=M('Shipment');
			$Chaibox=M('Chaibox');
			$Product=M('Product');
			// $ImagePath=$this->request->domain().'/Kangli/Public/uploads/product/';

			$map=array();
			$oddetail=array();
			$map['oddt_unitcode']=$this->qy_unitcode;
			$map['oddt_id']=$oddt_id;
			$map['oddt_odid']=$od_id;
			$oddetail = $Orderdetail->where($map)->find();
			if($oddetail){
				//产品
				$mappro=array();
				$datapro=array();
				$mappro['pro_id']=$oddetail['oddt_proid'];
				$mappro['pro_unitcode']=$this->qy_unitcode;
				$datapro=$Product->where($mappro)->field('pro_id,pro_pic')->find();
				if($datapro){
					if(is_not_null($datapro['pro_pic'])){
						$oddetail['oddt_propic']=$this->ImagePath.$datapro['pro_pic'];
					}else{
						$oddetail['oddt_propic']='';
					}
				}else{
					$oddetail['oddt_propic']='';
				}

				//订购数 发货数
				$oddt_totalqty=0;  //要发的总数
				$oddt_unitsqty=0;  //一个包装里的产品数
				if($oddetail['oddt_prodbiao']>0){
					$oddt_unitsqty=$oddetail['oddt_prodbiao'];
					
					if($oddetail['oddt_prozbiao']>0){
						$oddt_unitsqty=$oddt_unitsqty*$oddetail['oddt_prozbiao'];
					}
					
					if($oddetail['oddt_proxbiao']>0){
						$oddt_unitsqty=$oddt_unitsqty*$oddetail['oddt_proxbiao'];
					}
					
					$oddt_totalqty=$oddt_unitsqty*$oddetail['oddt_qty'];
				}else{
					$oddt_totalqty=$oddetail['oddt_qty'];
				}
				
				if($oddt_totalqty==0 || $oddt_totalqty==$oddetail['oddt_qty']){
					$oddetail['oddt_totalqty']='0';
				}else{
					$oddetail['oddt_totalqty']=$oddt_totalqty;
				}
				
				$oddetail['oddt_proname']=$oddetail['oddt_proname'].$oddetail['oddt_color'].$oddetail['oddt_size'];

				$map3=array();
				$shipproqty=0;  //已发的产品数
				$map3['ship_pro']=$oddetail['oddt_proid'];
				$map3['ship_unitcode']=$this->qy_unitcode;
				$map3['ship_odid']=$oddetail['oddt_odid'];
				$map3['ship_oddtid']=$oddetail['oddt_id'];
				$map3['ship_dealer']=$ship_dealer; //出货接收方
				$shipproqty=$Shipment->where($map3)->sum('ship_proqty');  //已发的产品数
				if($shipproqty){
					$oddetail['oddt_shiptatolqty']=$shipproqty;
					if($oddt_unitsqty>0){
						$oddetail['oddt_shipqty']=floor($shipproqty/$oddt_unitsqty);
					}else{
						$oddetail['oddt_shipqty']=$shipproqty;
					}
				}else{
					$oddetail['oddt_shiptatolqty']=0;
					$oddetail['oddt_shipqty']=0;
				}	
			}else{
				$this->err_get(30);
			}
			$orderdtlist=array();
			array_push($orderdtlist,$oddetail);
			$order['orderdetail']=$orderdtlist;
        	if ($sctype==1)
	        {
	        	$ret=array('orderdt' =>$order);
				return $ret;
	        }
	    	else
	    	{
	    		//出货记录
	    		$Shipment=M('Shipment');
				$Product=M('Product');
	
				$map=array();
				$parameter=array();
				$map['ship_unitcode']=$this->qy_unitcode;
				$map['ship_deliver']=$user_id;//ship_deliver--出货方   ship_dealer--收货方
				$map['ship_odid']=$od_id;
				$map['ship_pro']=$oddetail['oddt_proid'];
				$list = $Shipment->where($map)->order('ship_id DESC')->select();
				foreach($list as $k=>$v){
					//上级经销商信息
					$brcode=$v['ship_barcode'];
		            $map2=array();
					$map2['ship_unitcode']=$this->qy_unitcode;
					$map2['ship_dealer']=$user_id;   //ship_deliver--出货方   ship_dealer--收货方
					$map2['ship_barcode'] = $brcode;
					$data2=$Shipment->where($map2)->find();
				    if($data2){
		                $list[$k]['ship_dealer_from']=$data2['ship_deliver'];  
						$list[$k]['ship_date_from']=$data2['ship_date'];  
				    }else{
						//检测是否已发行
						$barcode=wlcode_to_packinfo($brcode,$this->qy_unitcode);
	
						if(!is_not_null($barcode)){
							$list[$k]['ship_dealer_from']='';
							$list[$k]['ship_date_from']='';
						}else{
							$map3=array();
							$where3=array();
							if($barcode['code']!=''){
								$where3[]=array('EQ',$barcode['code']);
							}
							if($barcode['tcode']!='' && $barcode['tcode']!=$barcode['code']){
								$where3[]=array('EQ',$barcode['tcode']);
							}
							if($barcode['ucode']!='' && $barcode['ucode']!=$barcode['code'] && $barcode['ucode']!=$barcode['tcode']){
								$where3[]=array('EQ',$barcode['ucode']);
							}
							$where3[]='or';
							$map3['ship_barcode'] = $where3;
							$map3['ship_unitcode']=$this->qy_unitcode;
							$map3['ship_dealer']=$user_id;   //ship_deliver--出货方   ship_dealer--收货方
							$data3=$Shipment->where($map3)->find();
							if(is_not_null($data3)){
		                        $list[$k]['ship_dealer_from']=$data3['ship_deliver'];  
						        $list[$k]['ship_date_from']=$data3['ship_date'];
							}else{
							    $list[$k]['ship_dealer_from']='';
							    $list[$k]['ship_date_from']='';
							}
						}
				    }

					if($list[$k]['ship_dealer_from']>=0){
						if ($list[$k]['ship_dealer_from']==0)
						{
							$list[$k]['ship_dealer_from_name']='总公司';
						}else
						{
							$map2=array();
							$map2['dl_id']=$v['ship_dealer_from'];
							$map2['dl_unitcode']=$this->qy_unitcode;
							$data2=$Dealer->where($map2)->find();
							if($data2){
								$list[$k]['ship_dealer_from_name']=wxuserTextDecode2($data2['dl_name']).'('.$data2['dl_weixin'].')';
							}else{
								$list[$k]['ship_dealer_from_name']='';
							}
						}
					}else
					{
						$list[$k]['ship_dealer_from_name']='';
					}
		
					//对应发给的经销商
				    $map2=array();
				    $map2['dl_id']=$v['ship_dealer'];
				    $map2['dl_unitcode']=$this->qy_unitcode;
				    $map2['dl_belong']=$user_id;
				    $data2=$Dealer->where($map2)->find();
					if($data2){
						$list[$k]['ship_dealer_name']=wxuserTextDecode2($data2['dl_name']).'('.$data2['dl_weixin'].')';
					}else{
					    $list[$k]['ship_dealer_name']='';
					}

					//对应的产品
					if($oddetail['oddt_proname']!=''){
						if($oddetail['oddt_pronumber']!=''){
							$list[$k]['ship_proname']=$oddetail['oddt_proname'].'('.$oddetail['oddt_pronumber'].')';
						}else{
							$list[$k]['ship_proname']=$oddetail['oddt_proname'];
						}
					}else{
						$list[$k]['ship_proname']='';
					}
				}
				$ret=array('orderdt' =>$order,'shipre'=>$list);
				return $ret;
	    	}
        }else
		{
			$this->err_get(4);
		}
    }
    //出货记录
    public function odship_del(){
    	isset($this->params["user_id"])?$user_id = $this->params["user_id"]:$user_id = ''; //用户ID
    	isset($this->params["od_id"])?$od_id = $this->params["od_id"]:$od_id = ''; //订单ID
    	isset($this->params["oddt_id"])?$oddt_id = $this->params["oddt_id"]:$oddt_id =0; //订单详情ID
    	isset($this->params["ship_id"])?$ship_id = $this->params["ship_id"]:$ship_id =0; //shid 
     	if(!$this->is_jxuser_login($user_id)){
			$this->err_get(5);
        }

        $map=array();
		$map['ship_id']=$ship_id;
		$map['ship_unitcode']=$this->qy_unitcode;
		$map['ship_deliver']=$user_id;   //ship_deliver--出货方   ship_dealer--收货方
		$Shipment=M('Shipment');
		$data=$Shipment->where($map)->find();

        //判断是否可删 保持数据完整性
        if($data){
        	//--------------------------------
	        $Dealer=M('Dealer');
			$mapdl=array();
			$mapdl['dl_id']=$user_id;
			$mapdl['dl_unitcode']=$this->qy_unitcode;
			$mapdl['dl_status']=1;
			$datadl=$Dealer->where($mapdl)->find();
			if($data){
				$dl_type=$datadl['dl_type'];
				$dl_username=$datadl['dl_username'];
			}else{
				$this->err_get(6);
			}

	        //如果确认收货 对应订单
			$Orders=M('Orders');
			$map2=array();
			$order=array();
			$map2['od_unitcode']=$this->qy_unitcode;
			$map2['od_id']=$data['ship_odid'];
			$order =$Orders->where($map2)->find();
			if($order){
				if($order['od_state']==3){
					$this->err_get(57);
				}
				if($order['od_state']==8){
					$this->err_get(58);
				}
			}else{
				$this->err_get(4);
			}
            //如果下级经销商已处理出货
            $map2=array();
            $map2['ship_unitcode']=$this->qy_unitcode;
            $map2['ship_deliver']=$data['ship_dealer'];

            // $where=array();		
            // $where['ship_barcode']=array('EQ',$data['ship_barcode']);
            // $where['ship_tcode']=array('EQ',$data['ship_barcode']);
            // $where['ship_ucode']=array('EQ',$data['ship_barcode']);
            // $where['_logic'] = 'or';
            // $map2['_complex'] = $where;
            	
	  		$map2['ship_barcode|ship_tcode|ship_ucode']=array('eq',$data['ship_barcode']); //tp5.0
            $data1=$Shipment->where($map2)->find();
            // var_dump($Shipment->getlastsql());
            // exit;
            if($data1){
               $this->err_get(59,'该出货记录已被下级经销商重新出货，暂不能删除');
            }
			
            $Chaibox=M('Chaibox');
            //判断处理拆箱记录
            if($data['ship_tcode']!='' || $data['ship_ucode']!=''){

				if($data['ship_ucode']!='' &&  $data['ship_tcode']==$data['ship_ucode']){	
                    $map2=array();
                    $map2['ship_ucode']=$data['ship_ucode'];
                    $map2['ship_unitcode']=$this->qy_unitcode;
					$map2['ship_deliver']=$user_id;
                    $map2['ship_id'] = array('NEQ',$data['ship_id']);
                    $data2=$Shipment->where($map2)->find();
                    if(is_not_null($data2)){

                    }else{
                        $map3=array();
                        $map3['chai_barcode']=$data['ship_ucode'];
                        $map3['chai_unitcode']=$this->qy_unitcode;
						$map3['chai_deliver'] =$user_id;
                        $Chaibox->where($map3)->delete(); 
                    }
                }
				
				if($data['ship_ucode']!=''  &&  $data['ship_ucode']!=$data['ship_tcode']){
                    $map2=array();
                    $map2['ship_tcode']=$data['ship_tcode'];
                    $map2['ship_unitcode']=$this->qy_unitcode;
					$map2['ship_deliver']=$user_id;
                    $map2['ship_id'] = array('NEQ',$data['ship_id']);
                    $data2=$Shipment->where($map2)->find();
                    if(is_not_null($data2)){

                    }else{
                        $map3=array();
                        $map3['chai_barcode']=$data['ship_tcode'];
                        $map3['chai_unitcode']=$this->qy_unitcode;
						$map3['chai_deliver'] =$user_id;
                        $Chaibox->where($map3)->delete(); 
                    }

                    $map22=array();
                    $map22['ship_ucode']=$data['ship_ucode'];
                    $map22['ship_unitcode']=$this->qy_unitcode;
					$map22['ship_deliver']=$user_id;
                    $map22['ship_id'] = array('NEQ',$data['ship_id']);
                    $data22=$Shipment->where($map22)->find();
                    if(is_not_null($data22)){

                    }else{
                        $map33=array();
                        $map33['chai_barcode']=$data['ship_ucode'];
                        $map33['chai_unitcode']=$this->qy_unitcode;
						$map33['chai_deliver'] = $user_id;
                        $Chaibox->where($map33)->delete(); 
                    }
                }
            }
            $Shipment->where($map)->delete(); 
            //记录日志 begin
            // $version =$this->request->header('version');
            $log_arr=array(
            'log_qyid'=>$user_id,
			'log_user'=>$dl_username,
            'log_qycode'=>$this->qy_unitcode,
            'log_action'=>'经销商删除出货记录',
			'log_type'=>2, //0-系统 1-企业 2-经销商 3-消费者
            'log_addtime'=>time(),
            'log_ip'=>real_ip(),
            'log_link'=>$_SERVER["HTTP_HOST"].'kangli/klapi/controller/orders/odship_del',
            // 'log_link'=>__SELF__,
            'log_remark'=>json_encode($data)
            );
            save_log($log_arr);
            //记录日志 end
			$ret=array('msg' =>'删除成功');
			return $ret;
        }else{
            $this->err_get(4);
        }
    }
}