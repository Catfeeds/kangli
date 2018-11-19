<?php
namespace Klapi\Controller;
use Think\Controller;
use klapi\controller\BaseApiController;
class ProductsController extends BaseApiController{
    protected $params;
	protected $dl_type;
	protected $ImagePath;
	public function __construct($params = null)
  	{
  	 // $this->_initialize();
  	 parent::__construct($params);
     $this->params=$params;
     $this->ImagePath='http://'.PROPATH;
  	}

    public function index(){
      //获取产品相关数据
      $proTypeList = $this->goods_type_get();
      $proList = $this->goods_list_get();
	  return array(
        "proTypeList" => $proTypeList,
        "proList" => $proList
      );         
    }
	
	/**
	 * [goods_list_get description]
	 * @return [type] [description]
	 */
    public function goods_type_get(){
    	//获取产品分类
        $protypelist=array();
        $Protype =M('Protype');
	    $Product =M('Product');
        $mapt=array();
        $mapt['pro_unitcode']=$this->qy_unitcode;
        $mapt['pro_active']=1;
        $group = $Product->where($mapt)->field('pro_typeid')->group('pro_typeid')->select();
        if ($group)
        {
           foreach($group as $k=>$v){
                $maptype=array();
                $maptype['protype_unitcode']=$this->qy_unitcode;
                $maptype['protype_iswho']=0;
                $maptype['protype_id']=$v['pro_typeid'];
                $protypeobject = $Protype->where($maptype)->field('protype_id,protype_name')->order('protype_id ASC')->find();
                if ($protypeobject)
                {
                    $protypelist[$k]['protype_id']=$protypeobject['protype_id']; 
                    $protypelist[$k]['protype_name']=$protypeobject['protype_name'];
                } 
           }  
        }
        return $protypelist;
    }

	/**
	 * [goods_list_get description]
	 * @return [type] [description]
	 */
    public function goods_list_get(){
    	isset($this->params["order_status"]) ? $order_status = $this->params["order_status"] : $order_status = ''; //排序状态
    	isset($this->params["protype_id"]) ? $protype_id = $this->params["protype_id"] : $protype_id = ''; //排序状态
    	isset($this->params["keyword"]) ? $keyword = $this->params["keyword"] : $keyword = ''; //排序状态
     	isset($this->params["pagenum"]) ? $pagenum = $this->params["pagenum"] : $pagenum =1;
     	isset($this->params["pagecount"]) ?$pagecount = $this->params["pagecount"] : $pagecount =1;
     	isset($this->params["user_id"]) ? $user_id = $this->params["user_id"] : $user_id ='';
        if (is_not_null($user_id)&&$this->is_jxuser_login($user_id))
        {
            $this->dl_type=$this->dealer_type_get();
        }
	    $pageinit=[
	      'type'     => 'bootstrap',
	      'page' =>$pagenum,
	      // 'list_rows' =>$pagecount,
	    ];
	    $Product =M('Product');
	    $map=array();
	    $map['pro_unitcode']=$this->qy_unitcode;
	    $map['pro_active']=1;
	    if ($protype_id>0)
            $map['pro_typeid']=$protype_id;
        if ($keyword!='')
            $map['pro_name']=array('like',"%$keyword%");
        if ($order_status==1)
        {
       //   	$list =$Product->where($map)->field('pro_id,pro_typeid,pro_name,pro_number,pro_pic,pro_price')->order('pro_order DESC')->paginate($pagecount,true,$pageinit)->each(function($item,$key){
       //   		//代理价
       //   		// $ImagePath=$this->request->domain().'/Kangli/Public/uploads/product/';
	      //       $map=array();
	      //       $data=array();
	      //       $map['pri_proid']=$item['pro_id'];
	      //       $map['pri_unitcode']=$this->qy_unitcode;
	      //       $map['pri_dltype']=$this->dl_type;
	      //       $data=M('Proprice')->where($map)->find();
	      //       if($data){
	      //           $item['pro_dlprice']=$data['pri_price'];
	      //       }else{
	      //           $item['pro_dlprice']='';
	      //       }  
			    // // if(is_not_null($item['pro_pic']) && file_exists(IMGPRODUCTPATH.$item['pro_pic'])){
			    // if(is_not_null($item['pro_pic'])){
			    //     // $item['pro_pic_str']='http://'.IMGPRODUCTPATH.$item['pro_pic'];
			    //     $item['pro_pic_str']=IMGPATH.$item['pro_pic'];
			    // }else{
			    //     $item['pro_pic_str']='';
			    // }
			    // //   // $item['news_addtime_str']=date('Y-m-d H:i:s',$item['news_addtime']);
			    // //   $item['news_addtime_str']=date('Y-m-d',$item['news_addtime']);
			    //   return $item;
			    // });
			$list =$Product->where($map)->field('pro_id,pro_typeid,pro_name,pro_number,pro_pic,pro_price')->order('pro_order DESC')->page($pagenum,$pagecount)->select();
			if (is_not_null($list))
			{
				foreach ($list as $k=>$v) {
					$map=array();
		            $data=array();
		            $map['pri_proid']=$v['pro_id'];
		            $map['pri_unitcode']=$this->qy_unitcode;
		            $map['pri_dltype']=$this->dl_type;
		            $data=M('Proprice')->where($map)->find();
		            if($data){
		                $list[$k]['pro_dlprice']=$data['pri_price'];
		            }else{
		                $list[$k]['pro_dlprice']='';
		            }  
					if($v['pro_pic']!=''){
					    $list[$k]['pro_pic_str']=$this->ImagePath.$v['pro_pic'];
					}else{
					    $list[$k]['pro_pic_str']='';
					}
					$list[$k]['pro_addtime_str']=date('Y-m-d',$v['pro_addtime']);
				}
				$has_more=false;
				$nextls =$Product->where($map)->field('pro_id,pro_typeid,pro_name,pro_number,pro_pic,pro_price')->order('pro_order DESC')->page($pagenum+1,$pagecount)->select();
				if (is_not_null($nextls))
				{
					$has_more=true;
				}
			}else
			{
				$list=array();
				$has_more=false;
			}
			$data=array('current_page' =>$pagenum,'has_more' =>$has_more,'data'=>$list);
			return $data;
	    }
        else
       	{
			$list =$Product->where($map)->field('pro_id,pro_typeid,pro_name,pro_number,pro_pic,pro_price')->order('pro_order ASC')->page($pagenum,$pagecount)->select();
            if (is_not_null($list))
			{
				foreach ($list as $k=>$v) {
					$map=array();
		            $data=array();
		            $map['pri_proid']=$v['pro_id'];
		            $map['pri_unitcode']=$this->qy_unitcode;
		            $map['pri_dltype']=$this->dl_type;
		            $data=M('Proprice')->where($map)->find();
		            if($data){
		                $list[$k]['pro_dlprice']=$data['pri_price'];
		            }else{
		                $list[$k]['pro_dlprice']='';
		            }  
					if($v['pro_pic']!=''){
					    $list[$k]['pro_pic_str']=$this->ImagePath.$v['pro_pic'];
					}else{
					    $list[$k]['pro_pic_str']='';
					}
					$list[$k]['pro_addtime_str']=date('Y-m-d',$v['pro_addtime']);
				}
				$has_more=false;
				$nextls =$Product->where($map)->field('pro_id,pro_typeid,pro_name,pro_number,pro_pic,pro_price')->order('pro_order DESC')->page($pagenum+1,$pagecount)->select();
				if (is_not_null($nextls))
				{
					$has_more=true;
				}
			}else
			{
				$list=array();
				$has_more=false;
			}
			$data=array('current_page' =>$pagenum,'has_more' =>$has_more,'data'=>$list);
			return $data;
       	}
    }

    /**
	 * [goods_detail_get 产品详情]
	 * @return [type] [description]
	 */
    public function goods_detail_get(){
		isset($this->params["user_id"])?$user_id = $this->params["user_id"]:$user_id = ''; //用户ID
     	isset($this->params["pro_id"])?$pro_id = $this->params["pro_id"]:$pro_id =0; //产品ID
     	isset($this->params["stock"])?$stock = $this->params["stock"]:$stock =0; //订单状态
 		if(!$this->is_jxuser_login($user_id)){
			$this->err_get(5);
        }else
        {
        	//--------------------------------
        	$proCarousel=array();
        	$dl_type=$this->dealer_type_get();
        	$map=array();
	        $data=array();
	        $map['pro_id']=intval($pro_id);
	        $map['pro_unitcode']=$this->qy_unitcode;
	        $map['pro_active']=1;
	        $Product =M('Product');
	        $data=$Product->where($map)->find();
	        if($data){
	            //代理价
	            $map2=array();
	            $data2=array();
	            $map2['pri_proid']=$data['pro_id'];
	            $map2['pri_unitcode']=$this->qy_unitcode;
	            $map2['pri_dltype']=$dl_type;
	            $Proprice =M('Proprice');
	            $data2=$Proprice->where($map2)->find();
	            if($data2){
	                $data['pro_dlprice']=$data2['pri_price'];
	            }else{
	                $data['pro_dlprice']='';
	            }
	            $data['pro_pic_str']=$this->ImagePath.$data['pro_pic'];

	            //产品轮播图
	            if (is_not_null($data['pro_pic2']))
	            {
	            	$proObject=(object)array();
	            	$proObject->id=$data['pro_id'];
	            	$proObject->title=$data['pro_name'];
	            	$proObject->pic_path=$this->ImagePath.$data['pro_pic2'];
	            	array_push($proCarousel,$proObject);
	            }
	            if (is_not_null($data['pro_pic3']))
	            {
	            	$proObject=(object)array();
	            	$proObject->id=$data['pro_id'];
	            	$proObject->title=$data['pro_name'];
	            	$proObject->pic_path=$this->ImagePath.$data['pro_pic3'];
	            	array_push($proCarousel,$proObject);
	            }
	            if (is_not_null($data['pro_pic4']))
	            {
	            	$proObject=(object)array();
	            	$proObject->id=$data['pro_id'];
	            	$proObject->title=$data['pro_name'];
	            	$proObject->pic_path=$this->ImagePath.$data['pro_pic4'];
	            	array_push($proCarousel,$proObject);
	            }
	            if (is_not_null($data['pro_pic5']))
	            {
	            	$proObject=(object)array();
	            	$proObject->id=$data['pro_id'];
	            	$proObject->title=$data['pro_name'];
	            	$proObject->pic_path=$this->ImagePath.$data['pro_pic5'];
	            	array_push($proCarousel,$proObject);
	            }
	        
	            //颜色尺码
	            $Yifuattr =M('Yifuattr');
	            $map2=array();
	            $map2['attr_unitcode']=$this->qy_unitcode;
	            $map2['attr_proid'] =$data['pro_id'];
	            $colorlist = $Yifuattr->where($map2)->field('attr_color')->group('attr_color')->select();
	            foreach($colorlist as $k=>$v){
	                $map3=array();
	                $map3['attr_unitcode']=$this->qy_unitcode;
	                $map3['attr_proid'] = $data['pro_id'];
	                $map3['attr_color'] = $v['attr_color'];
	                $data3 = $Yifuattr->where($map3)->field('attr_size')->group('attr_size')->select();
	                $sizestr='';
	                foreach($data3 as $kk=>$vv){
	                    if($sizestr==''){
	                        $sizestr='|'.trim($vv['attr_size']).'|';
	                    }else{
	                        $sizestr.=trim($vv['attr_size']).'|';
	                    }
	                }
	                $colorlist[$k]['sizes']=$sizestr;
	            }
	        
	            
	            $map2=array();
	            $map2['attr_unitcode']=$this->qy_unitcode;
	            $map2['attr_proid'] = $data['pro_id'];
	            $sizelist = $Yifuattr->where($map2)->field('attr_size')->group('attr_size')->select();
	            
	            foreach($sizelist as $k=>$v){
	                $map3=array();
	                $map3['attr_unitcode']=$this->qy_unitcode;
	                $map3['attr_proid'] = $data['pro_id'];
	                $map3['attr_size'] = $v['attr_size'];
	                $data3 = $Yifuattr->where($map3)->field('attr_color')->group('attr_color')->select();
	                
	                $colorstr='';
	                foreach($data3 as $kk=>$vv){
	                    if($colorstr==''){
	                        $colorstr='|'.trim($vv['attr_color']).'|';
	                    }else{
	                        $colorstr.=trim($vv['attr_color']).'|';
	                    }
	                }
	                $sizelist[$k]['colors']=$colorstr;
	            }

	            // $wvsh='100%';//滚图宽高比
	            // $imgpath = BASE_PATH.'/Public/uploads/product/';
	            // if(is_not_null($data['pro_pic']) && file_exists($imgpath.$data['pro_pic'])){
	            // if(is_not_null($data['pro_pic'])){
	            //     $arr=getimagesize($imgpath.$adlist[0]['ad_pic']);
	            //     if(false!=$arr){
	            //         $w=$arr[0];
	            //         $h=$arr[1];
	            //         $wvsh=(($h/$w)*100).'%';
	            //     }
	            // }
	            
	            //上级代理
	            //--------------------------------
		        $Dealer=M('Dealer');
				$map=array();
				$map['dl_id']=$user_id;
				$map['dl_unitcode']=$this->qy_unitcode;
				$map['dl_status']=1;
				$dldata=$Dealer->where($map)->find();
				if($dldata){
					$dl_type=$dldata['dl_type'];
					$dl_belong=$dldata['dl_belong'];
				}else{
					$this->err_get(4);
				}
	            //计算产品虚拟库存
				$pro_dummystock=0;//总虚拟库存
				if ($dl_belong==0)
				{
					if($stock==1)
					{
						$pro_dummystock=99999999;
					}
					else
					{
						$pro_dummystock=$this->mystock($data,$user_id);
					}
				}
				else
				{
					if($stock==1)
					{
						$pro_dummystock=$this->mystock($data,$dl_belong);
					}
					else
					{
						$pro_dummystock=$this->mystock($data,$user_id);
					}
				}
				$data['pro_stock']=$pro_dummystock;
	        }else{
	           $this->err_get(1);
	        }	       	
	       	$ret=array('prolunbo'=>$proCarousel,'proinfo'=>$data,'colorls'=>$colorlist,'sizels'=>$sizelist,'shopcarcount'=>$this->shopcar_count_get());
	       	return $ret;
        }
    }


     /**
	 * [shopcar_count_get 获取购物车数量]
	 * @return [type] [description]
	 */
    public function shopcar_count_get(){
    	isset($this->params["user_id"])?$user_id = $this->params["user_id"]:$user_id = ''; //用户ID
    	isset($this->params["stock"])?$stock = $this->params["stock"]:$stock =0;//购物车的类型0购买 1预充 2提货
    	//购物车数量
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
        $map['sc_virtualstock'] =$stock;
        $shopcarcount = $Shopcart->where($map)->sum('sc_qty');
        return $shopcarcount;
    }

    /**
	 * [shopcar_goods_add 添加购物车]
	 * @return [type] [description]
	 */
    public function shopcar_goods_add(){
    	isset($this->params["user_id"])?$user_id = $this->params["user_id"]:$user_id = ''; //用户ID
     	isset($this->params["pro_id"])?$pro_id = $this->params["pro_id"]:$pro_id =0; //产品ID
     	isset($this->params["stock"])?$stock = $this->params["stock"]:$stock =0; //订单类型 0购买 1预充 2 提货
     	isset($this->params["color"])?$color = $this->params["color"]:$color =''; //产品颜色
     	isset($this->params["size"])?$size = $this->params["size"]:$size =''; //产品类型
     	isset($this->params["count"])?$count = $this->params["count"]:$count =0; //产品数量
 		if(!$this->is_jxuser_login($user_id)){
			$this->err_get(5);
        }else
        {
        	//代理类型
        	$dl_type=$this->dealer_type_get();

        	if($pro_id<=0){
				$this->err_get(1);
			}
			//颜色尺码是否存在
			$map=array();
			$map['attr_unitcode']=$this->qy_unitcode;
			$map['attr_proid']=$pro_id;
			$Yifuattr =M('Yifuattr');
			$colorlist = $Yifuattr->where($map)->field('attr_color')->group('attr_color')->select();
			if($colorlist){
				if (!is_not_null($color))
					$this->err_get(18);
			}
			$sizelist = $Yifuattr->where($map)->field('attr_size')->group('attr_size')->select();
			if($sizelist){
				if (!is_not_null($size))
					$this->err_get(19);
			}
			$attr_id=0;
			if (is_not_null($color)||is_not_null($size))
			{
				$map2=array();
				$map2['attr_unitcode']=$this->qy_unitcode;
				$map2['attr_proid']=$pro_id;
				$map2['attr_color']=$color;
				$map2['attr_size']=$size;
				$data2=$Yifuattr->where($map2)->find();
				if($data2){
					$attr_id=$data2['attr_id'];
				}else{
					$this->err_get(20);
				}
			}

			$map=array();
			$data=array();
			$map['pro_id']=$pro_id;
	        $map['pro_unitcode']=$this->qy_unitcode;
	        $map['pro_active']=1;
	        $Product =M('Product');
			$data=$Product->where($map)->find();
			if($data){
			    //代理价
				$map2=array();
				$data2=array();
				$map2['pri_proid']=$data['pro_id'];
				$map2['pri_unitcode']=$this->qy_unitcode;
				$map2['pri_dltype']=$dl_type;
				$Proprice =M('Proprice');
				$data2=$Proprice->where($map2)->find();
	            if($data2){
	                $data['pro_dlprice']=$data2['pri_price'];
	            }else{
	                $data['pro_dlprice']='';
	            }
				
				if($data['pro_dlprice']==''){
					$this->err_get(21);
				}else{
					$map3=array();
				    $data3=array();
					$data4=array();
				    $map3['sc_proid']=$data['pro_id'];
				    if ($attr_id>0)
					$map3['sc_attrid']=$attr_id;
				    $map3['sc_unitcode']=$this->qy_unitcode;
					$map3['sc_dlid']=$user_id;
					$map3['sc_virtualstock'] =$stock;
					//添加购物车
					$Shopcart =M('Shopcart');
					$data3=$Shopcart->where($map3)->find();
					if($data3){ //如果购物车有 修改数量
						$data4['sc_qty']=$data3['sc_qty']+$count;
				        $Shopcart->where($map3)->save($data4);
						$ret=array("status" => 1, "msg" =>'成功加入购物车');
						exit(json_encode($ret));
					}else{ //如果购物车没 添加
						$data4['sc_unitcode']=$this->qy_unitcode;
						$data4['sc_dlid']=$user_id;
						$data4['sc_proid']=$pro_id;
						$data4['sc_attrid']=$attr_id;
						$data4['sc_color']=$color;
						$data4['sc_size']=$size;
						$data4['sc_qty']=$count;
						$data4['sc_addtime']=time();
						$data4['sc_virtualstock'] =$stock;
	                    $rs=$Shopcart->create($data4,1);
				        if($rs){
				        	if($rs){
							   $result =$Shopcart->add(); 
							   if($result){
									$ret=array("status" => 1, "msg" =>'加入购物车成功');
									exit(json_encode($ret));
								}else
								{
									$this->err_get('加入购物车失败');	
								}
							}
						}else{
							$this->err_get(22);
						}
					}
				}
			}else{
				$this->err_get(1);
			}
        }	
    }

    /**
	 * [shopcar_get 获取购物车list]
	 * @return [type] [description]
	 */
    public function shopcar_get(){
    	isset($this->params["user_id"])?$user_id = $this->params["user_id"]:$user_id = ''; //用户ID
     	isset($this->params["stock"])?$stock = $this->params["stock"]:$stock =0; //订单类型 0购买 1预充 2 提货
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
				$dl_type=$data['dl_type'];
				$dl_belong=$data['dl_belong'];
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
	        $map['sc_virtualstock'] =$stock;
	        $data = $Shopcart->where($map)->order('sc_addtime DESC')->select();
			$Product =M('Product');
			$Proprice =M('Proprice');
			$total=0;//总费用
			$totalqty=0; //总件数量
			$allcheck=true; //是否全选
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
					if (is_not_null($data2['pro_pic']))
					{
						$data[$k]['pro_pic_str']=$this->ImagePath.$data2['pro_pic'];
					}else
					{
						$data[$k]['pro_pic_str']='';
					}
					$data[$k]['pro_price']=$data2['pro_price'];
					$data[$k]['pro_stock']=$data2['pro_stock'];
					
					//代理价
					$map3=array();
					$data3=array();
					$map3['pri_proid']=$data2['pro_id'];
					$map3['pri_unitcode']=$this->qy_unitcode;
					$map3['pri_dltype']=$dl_type;

					$data3=$Proprice->where($map3)->find();
					if($data3){
						$data[$k]['pro_dlprice']=$data3['pri_price'];
						$data[$k]['pri_minimum']=$data3['pri_minimum'];
					}else{
						$data[$k]['pro_dlprice']='';
						$data[$k]['pri_minimum']=0;
					}
		
					
					 if ($v['sc_status']==1)
					{
						$allcheck=false;	
					}else
					{
						$sc_totalqty=0; //总件数量
						// $pro_unitsqty=0; //每单位包装的数量
						// if($data2['pro_dbiao']>0){
						// 	$pro_unitsqty=$data2['pro_dbiao'];
						// 	if($data2['pro_zbiao']>0){
						// 		$pro_unitsqty=$pro_unitsqty*$data2['pro_zbiao'];
						// 	}
						
						// 	if($data2['pro_xbiao']>0){
						// 		$pro_unitsqty=$pro_unitsqty*$data2['pro_xbiao'];
						// 	}	
						// 	$sc_totalqty=$pro_unitsqty*$v['sc_qty'];
						// }else{
							$sc_totalqty=$v['sc_qty'];
						// }
						$totalqty+=$sc_totalqty;
						//总价格
						$total=$total+$data[$k]['pro_dlprice']*$v['sc_qty'];
					}
					
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
					$data[$k]['pro_stock']=$pro_dummystock;

				}else{
					$data[$k]['pro_name']='';
					$data[$k]['pro_pic']='';
					$data[$k]['pro_price']='';
					$data[$k]['pro_dlprice']='';
					$data[$k]['pro_stock']=0;
				}
				//移除没有代理价的购物记录
				if($data[$k]['pro_dlprice']==''){
					$map3=array();
					$map3['sc_unitcode']=$this->qy_unitcode;
					$map3['sc_dlid']=$user_id;
					$map3['sc_id']=$v['sc_id'];
					$Shopcart->where($map3)->delete();
				}				
			}
			$ret=array('scarls'=>$data,'allcheck'=>$allcheck,'totalqty'=>$totalqty,'total'=>$total,'stock'=>$stock,'dl_belong'=>$dl_belong);
			return $ret;
        }
    }
    /**
	 * [shopcar_set 提交购物车]
	 * @return [type] [description]
	 */
    public function shopcar_set(){
    	isset($this->params["user_id"])?$user_id = $this->params["user_id"]:$user_id = ''; //用户ID
     	isset($this->params["stock"])?$stock = $this->params["stock"]:$stock =0; //订单类型 0购买 1预充 2 提货
     	isset($this->params["scarls"])?$scarls = $this->params["scarls"]:$scarls =[]; //列表
 		if(!$this->is_jxuser_login($user_id)){
			$this->err_get(5);
        }else
        {
        	if (is_not_null($scarls))
        	{
        		$Shopcart=M('Shopcart');
        		foreach ($scarls as $k => $v) {
        			$map=array();
        			$map['sc_dlid']=$user_id;
        			$map['sc_id']=$v['sc_id'];
					$map['sc_unitcode']=$this->qy_unitcode;
					$data=$Shopcart->where($map)->find();
					if($data){
						//修改购物车数量
						$udata=array();
						$udata['sc_qty']=$v['sc_qty'];
						$udata['sc_status']=$v['sc_status'];
						$udata['sc_addtime']=time();
					    $Shopcart->where($map)->save($udata);
					}else
					{
						$ret = array("status" => 0,"update"=>1,"msg" =>'该购物车记录已移除');
						exit(json_encode($ret));
					}
        		}
        		$ret=array("status" => 1, "msg" =>'提交成功');
				exit(json_encode($ret));
        	}else
        	{
        		$this->err_get(4);
        	}
        }
    }

    /**
	 * [shopcar_check 核对购物车信息]
	 * @return [type] [description]
	 */
    public function shopcar_check(){
    	isset($this->params["user_id"])?$user_id = $this->params["user_id"]:$user_id = ''; //用户ID
     	isset($this->params["stock"])?$stock = $this->params["stock"]:$stock =0; //订单类型 0购买 1预充 2 提货
     	isset($this->params["dladd_id"])?$dladd_id = $this->params["dladd_id"]:$dladd_id =0; //收货地址ID
 		if(!$this->is_jxuser_login($user_id)){
			$this->err_get(5);
        }else
        {
        	$dl_type='';
        	$dl_name='';
        	$dl_belong=0;
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
				$this->err_get(5);
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
			if(count($data)>0){
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
						if ($data2['pro_pic']!='')
						{
							$data[$k]['pro_pic_str']=$this->ImagePath.$data2['pro_pic'];
						}else
						{
							$data[$k]['pro_pic_str']='';
						}


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
						$data[$k]['pro_stock']=$pro_dummystock;

						//总件数量
						$sc_totalqty=0; //总订购数
						$pro_unitsqty=0; //每单位包装的数量
						if($data2['pro_dbiao']>0){
								$pro_unitsqty=$vv['pro_dbiao'];
								if($data2['pro_zbiao']>0){
									$pro_unitsqty=$pro_unitsqty*$data2['pro_zbiao'];
								}
							
								if($data2['pro_xbiao']>0){
									$pro_unitsqty=$pro_unitsqty*$data2['pro_xbiao'];
								}	
								$sc_totalqty=$pro_unitsqty*$v['sc_qty'];
							}else{
								$sc_totalqty=$v['sc_qty'];
							}
							$totalqty+=$sc_totalqty;
						if ($pro_dummystock<$v['sc_qty'])
						{
							$ret= array('status'=>0,'isback'=>1,'msg' =>'亲，产品'.$data2['pro_name'].'--'.$v['sc_color'].$v['sc_size'].'的库存为：'.$pro_dummystock.'不足');
							exit(json_encode($ret));
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
							    $ret= array('status'=>0,'isback'=>1,'msg' =>'亲，产品'.$data2['pro_name'].' 的最低补货量为：'.$data3['pri_minimum'].'');
								exit(json_encode($ret));
							}
						}else{
							$data[$k]['pro_dlprice']='';
						}
					}else{
						$data[$k]['pro_name']='';
						$data[$k]['pro_pic']='';
						$data[$k]['pro_price']='';
						$data[$k]['pro_dlprice']='';
						$data[$k]['pro_stock']=0;
					}
				}
			}
			//收货地址
			$Dladdress =M('Dladdress');
			if($dladd_id<=0){
				$map=array();
				$data2=array();
				$map['dladd_unitcode']=$this->qy_unitcode;
				$map['dladd_dlid'] =$user_id;
				$data2 = $Dladdress->where($map)->order('dladd_default DESC,dladd_id DESC')->find();
				// if(count($data2)<=0){
				// 	$dladd_id=0;
				// 	$dladd_address=array();
				// }else{
				// 	$dladd_id=$data2['dladd_id'];
				// 	$dladd_address=$data2;
				// }
			}else{
				$map=array();
				$data2=array();
				$map['dladd_dlid']=$user_id;
				$map['dladd_unitcode']=$this->qy_unitcode;
				$map['dladd_id']=$dladd_id;
				$data2=$Dladdress->where($map)->find();
				// if($data2){
				// 	$dladd_id=$data2['dladd_id'];
				// 	$dladd_address=$data2;
				// }else{
				// 	$dladd_id=0;
				// 	$dladd_address=array();
				// }
			}
			$ret=array('scarls'=>$data,'totalqty'=>$totalqty,'total'=>$total,'stock'=>$stock,'dl_name'=>$dl_name,'dl_addtime'=>date('Y-m-d',time()),'addressinfo'=>$data2);
			return $ret;
        }
    }

    /**
	 * [shopcar_del 删除购物车中的产品]
	 * @return [type] [description]
	 */
    public function shopcar_del(){
    	isset($this->params["user_id"])?$user_id = $this->params["user_id"]:$user_id = ''; //用户ID
     	isset($this->params["sc_id"])?$sc_id = $this->params["sc_id"]:$sc_id =0; //购物车ID
 		if(!$this->is_jxuser_login($user_id)){
			$this->err_get(5);
        }else
        {
        	if ($sc_id>0)
        	{
        		$Shopcart=M('Shopcart');
        		$map3=array();
				$map3['sc_unitcode']=$this->qy_unitcode;
				$map3['sc_dlid']=$user_id;
				$map3['sc_id']=$sc_id;
				$Shopcart->where($map3)->delete();
        		$ret=array("status" => 1, "msg" =>'删除成功');
        		return $ret;
        	}else
        	{
        		$this->err_get(30);
        	}
        }
    }
}