<?php
namespace Kangli\Controller;
use Think\Controller;
class ProductController extends CommController {
    //产品展示
    public function index(){
        if(!$this->is_jxuser_login()){
            $login=false;
            // $qy_fwkey=$this->qy_fwkey;
            // $qy_fwsecret=$this->qy_fwsecret;
            // $ttamp2=time();
            // $sture2=MD5($qy_fwkey.$ttamp2.$qy_fwsecret);
            // $tagpage='http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
            // header('location:'.WWW_WEBROOT.'Kangli/Dealer/login/ttamp/'.$ttamp2.'/sture/'.$sture2.'/tagpage/'.base64_encode($tagpage).'');
        }else
        {
            $login=true;
        }
        $back=intval(I('get.back',0)); //1 我的
        cookie('pro_page_back',$back,72000); //用cookie保存来源

        $stock=intval(I('get.stock',0)); //1 预充库存
        //--------------------------------
        
        $Dealer= M('Dealer');
        if ($login)
        {
            $map=array();
            $map['dl_id']=session('jxuser_id');
            $map['dl_unitcode']=$this->qy_unitcode;
            $map['dl_status']=1;
            $data=$Dealer->where($map)->find();
            if($data){
                $dl_type=$data['dl_type'];
            }else{
                session('jxuser_id',null);
                session('jxuser_unitcode',null);
                $this->error('授权已过期，请重新登录',U('Kangli/Index/index'),1);
                exit;
            }
        }
        $order_status=intval(I('get.order_status',0));
        $protype_id=intval(I('get.protype_id',0));
        $keyword=trim(I('get.keyword',''));

        $map = array();
        $Product = M('Product');
        $map['pro_unitcode']=$this->qy_unitcode;
        $map['pro_active']=1;
        if ($protype_id>0)
            $map['pro_typeid']=$protype_id;
         if ($keyword!='')
            $map['pro_name']=array('like',"%$keyword%");
        $count = $Product->where($map)->count();
        $Page = new \Think\Page($count,20);
        $show = $Page->show();
        if($show=='<div>    </div>'){
            $show='';
        }
        if ($order_status==1)
            $list = $Product->where($map)->order('pro_order DESC')->limit(($Page->firstRow . ',') . $Page->listRows)->select();
        else
            $list = $Product->where($map)->order('pro_order ASC')->limit(($Page->firstRow . ',') . $Page->listRows)->select();
//        dump($list);die();
        $Proprice = M('Proprice');
        foreach($list as $k=>$v){ 
            //代理价
            $map=array();
            $data=array();
            $map['pri_proid']=$v['pro_id'];
            $map['pri_unitcode']=$this->qy_unitcode;
            $map['pri_dltype']=$dl_type;
            $data=$Proprice->where($map)->find();
            if($data){
                $list[$k]['pro_dlprice']=$data['pri_price'];
            }else{
                $list[$k]['pro_dlprice']='';
            }  
        }

                       

        //获取产品分类
        $protypelist=array();
        $Protype = M('Protype');
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
                    if($protype_id==$protypeobject['protype_id'])
                    {
                        $protype_name=$protypeobject['protype_name'];
                    }
                    $protypelist[$k]['protype_id']=$protypeobject['protype_id']; 
                    $protypelist[$k]['protype_name']=$protypeobject['protype_name']; 
                } 
           }  
        }

        if (!$protype_name)
            $protype_name='全部分类';

        $this->assign('protype_name', $protype_name);
        $this->assign('order_status', $order_status);
        $this->assign('list', $list);
        $this->assign('protypelist', $protypelist);
        $this->assign('page', $show);
        $this->assign('back', $back);
        $this->assign('stock',$stock);
        $this->assign('login',$login);
        $this->display('index');
    }

    //产品详情
    public function detail(){
        // if(!$this->is_jxuser_login()){
            // $qy_fwkey=$this->qy_fwkey;
            // $qy_fwsecret=$this->qy_fwsecret;
            // $ttamp2=time();
            // $sture2=MD5($qy_fwkey.$ttamp2.$qy_fwsecret);
            // $tagpage='http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
            // header('location:'.WWW_WEBROOT.'Kangli/Dealer/login/ttamp/'.$ttamp2.'/sture/'.$sture2.'/tagpage/'.base64_encode($tagpage).'');
        // }
        //--------------------------------
        $this->is_jxuser_login()==true?$isLogin=true:$isLogin=false;
        if ($isLogin){
            $Dealer= M('Dealer');
            $map=array();
            $map['dl_id']=session('jxuser_id');
            $map['dl_unitcode']=$this->qy_unitcode;
            $map['dl_status']=1;
            $data=$Dealer->where($map)->find();
            if($data){
                $dl_type=$data['dl_type'];
            }else{
                session('jxuser_id',null);
                session('jxuser_unitcode',null);
                $this->error('授权已过期，请重新登录',U('Kangli/Index/index'),1);
                exit;
            }
        }

        //根据cookie返回原来的入口界面
        $back=cookie('pro_page_back');
        $stock=intval(I('get.stock',0)); //1 预充库存
        $map=array();
        $data=array();
        $map['pro_id']=intval(I('get.pro_id',0));
        $map['pro_unitcode']=$this->qy_unitcode;
        $map['pro_active']=1;
        $Product = M('Product');
        $data=$Product->where($map)->find();
        if($data){
            //代理价
            $map2=array();
            $data2=array();
            $map2['pri_proid']=$data['pro_id'];
            $map2['pri_unitcode']=$this->qy_unitcode;
            $map2['pri_dltype']=$dl_type;
            $Proprice = M('Proprice');
            $data2=$Proprice->where($map2)->find();
            if($data2){
                $data['pro_dlprice']=$data2['pri_price'];
            }else{
                $data['pro_dlprice']='';
            }
            $data['pro_pic_str']='<img src="'.__ROOT__.'/Public/uploads/product/'.$data['pro_pic'].'"  border="0" style="width:100%" >';
            //颜色尺码
            $Yifuattr = M('Yifuattr');
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
            
            
            $wvsh='100%';//滚图宽高比
            $imgpath = BASE_PATH.'/Public/uploads/product/';
            if(is_not_null($data['pro_pic']) && file_exists($imgpath.$data['pro_pic'])){
                $arr=getimagesize($imgpath.$adlist[0]['ad_pic']);
                if(false!=$arr){
                    $w=$arr[0];
                    $h=$arr[1];
                    $wvsh=(($h/$w)*100).'%';
                }
            }
            $this->assign('wvsh', $wvsh);
        }else{
            $this->error('没有该记录','',2);
        }

        //购物车数量
        $Shopcart = M('Shopcart');
        //删除24小时前的没下单的购物车记录
        $map2=array();
        $map2['sc_unitcode']=$this->qy_unitcode;
        $map2['sc_dlid']=session('jxuser_id');
        $map2['sc_addtime']=array('ELT',(time()-3600*24));
        $Shopcart->where($map2)->delete(); 
        
        $map=array();
        $map['sc_unitcode']=$this->qy_unitcode;
        $map['sc_dlid'] =session('jxuser_id');
        $map['sc_virtualstock'] =$stock;
        $shopcarcount = $Shopcart->where($map)->sum('sc_qty');
        // var_dump($shopcarcount);
        // exit;
        $this->assign('shopcarcount', $shopcarcount);
        $this->assign('colorlist', $colorlist);
        $this->assign('sizelist', $sizelist);
        $this->assign('proinfo', $data);
        $this->assign('stock', $stock);
        $this->assign('back', $back);
        $this->assign('login', $isLogin);
        $this->display('detail');
    }
}