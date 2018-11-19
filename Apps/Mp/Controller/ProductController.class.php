<?php
namespace Mp\Controller;
use Think\Controller;
//产品管理
class ProductController extends CommController {
	//产品列表
    public function index(){
        $this->check_qypurview('20001',1);
        $pro_typeid=intval(I('param.pro_typeid',0));
        $keyword=trim(strip_tags(htmlspecialchars_decode(I('param.keyword',''))));

        if($pro_typeid>0){
            $son_type_id=get_son_type_id($pro_typeid);
            if(strpos($son_type_id,',')>0){
               $map['pro_typeid']=array('IN',explode(',',$son_type_id));
            }else{
               $map['pro_typeid']=$pro_typeid;
            }
			$parameter['pro_typeid']=$pro_typeid;
        }
        if($keyword!=''){
            $keyword=str_replace('[','',$keyword);
            $keyword=str_replace(']','',$keyword);
            $keyword=str_replace('%','',$keyword);
            $keyword=str_replace('_','',$keyword);
            
            $keyword=sub_str($keyword,20,false);
            $where['pro_name']=array('LIKE', '%'.$keyword.'%');
            $where['pro_number']=array('LIKE', '%'.$keyword.'%');
            $where['_logic'] = 'or';
            $map['_complex'] = $where;
			
			$parameter['keyword']=$keyword;
        }

        $Product = M('Product');
        $map['pro_unitcode']=session('unitcode');
        $count = $Product->where($map)->count();
        $Page = new \Think\Page($count, C('PAGE_SIZE'),$parameter);
        $show = $Page->show();
        $list = $Product->where($map)->order('pro_id DESC')->limit(($Page->firstRow . ',') . $Page->listRows)->select();
        
        $Protype = M('Protype');
        $imgpath = BASE_PATH.'/Public/uploads/product/';

        foreach($list as $k=>$v){ 
            if(is_not_null($v['pro_pic']) && file_exists($imgpath.$v['pro_pic'])){
                $arr=getimagesize($imgpath.$v['pro_pic']);
                if(false!=$arr){
                    $w=$arr[0];
                    $h=$arr[1];
                    if($h>60){
                       $hh=60;
                       $ww=($w*60)/$h;
                    }else{
                       $hh=$h;
                       $ww=$w;
                    }
                    if($ww>60){
                       $ww=60;
                       $hh=($h*60)/$w;
                    }
                    $list[$k]['pro_pic_str']='<img src="'.__ROOT__.'/Public/uploads/product/'.$v['pro_pic'].'" width="'.$ww.'"  height="'.$hh.'"  border="0">';
                }
                else{
                    $list[$k]['pro_pic_str']='-';
                }
            }else{
                $list[$k]['pro_pic_str']='-';
            }

            $map2=array();
            $map2['protype_unitcode']=session('unitcode');
            $map2['protype_id'] = $v['pro_typeid'];
            $protypeinfo = $Protype->where($map2)->find();
            if($protypeinfo){
                  $list[$k]['pro_typeid_str']=$protypeinfo['protype_name'];
            }else{
                  $list[$k]['pro_typeid_str']='未知';
            }
			
            //积分
            if($v['pro_jftype']==1){
				if($v['pro_jifen']<=0){
					$list[$k]['pro_jifen_str']='-';
				}else{
                    $list[$k]['pro_jifen_str']='固定积分<br>'.$v['pro_jifen'];
				}
            }else{
				if($v['pro_jifen']<=0){
                    $list[$k]['pro_jifen_str']='-';
				}else{
					$list[$k]['pro_jifen_str']='随机积分<br>'.$v['pro_jifen'].'--'.$v['pro_jfmax'];
				}
            }
			
        }
        $this->assign('list', $list);
        
		$map3=array();
        $map3['protype_unitcode']=session('unitcode');
        $map3['protype_iswho'] = 0;
        $Protype = M('Protype');
        $list3 = $Protype->where($map3)->order('protype_order ASC')->select();
        foreach($list3 as $k=>$v){ 
            $map4['protype_unitcode']=session('unitcode');
            $map4['protype_iswho'] = $v['protype_id'];

            if($v['protype_id']==$pro_typeid){
                $list3[$k]['selected']='selected';
            }else{
                $list3[$k]['selected']='';
            }

            $list4 = $Protype->where($map4)->order('protype_order ASC')->select();
            foreach($list4 as $kk=>$vv){ 
                if($vv['protype_id']==$pro_typeid){
                    $list4[$kk]['selected']='selected';
                }else{
                    $list4[$kk]['selected']='';
                }
            }
            $list3[$k]['subarr']=$list4;
        }
        $this->assign('typelist', $list3);


        $this->assign('keyword', $keyword);
        $this->assign('page', $show);
        $this->assign('curr', 'pro_list');

        $this->display('list');
    }
   
   //添加产品
    public function add(){
        $this->check_qypurview('20002',1);

        $data['pro_id']=0;
        $data['pro_jftype']=1;
        $this->assign('curr', 'pro_list');
        $this->assign('atitle', '添 加');
        $this->assign('proinfo', $data);
        //分类
        $map['protype_unitcode']=session('unitcode');
        $map['protype_iswho'] = 0;
        $Protype = M('Protype');
        $list = $Protype->where($map)->order('protype_order ASC')->select();
        foreach($list as $k=>$v){ 
             $map2['protype_unitcode']=session('unitcode');
             $map2['protype_iswho'] = $v['protype_id'];
             $list2 = $Protype->where($map2)->order('protype_order ASC')->select();
             $list[$k]['subarr']=$list2;
        }
		$this->assign('colorlist', array());
        $this->assign('typelist', $list);
		//editor
		$ttamp=time();
		$sture=MD5(session('unitcode').$ttamp);
		$this->assign('ttamp', URLEncode($ttamp));
        $this->assign('sture', URLEncode($sture));
        $this->assign('uid', URLEncode(\Org\Util\Funcrypt::authcode(session('unitcode'),'ENCODE',C('WWW_AUTHKEY'),0)));
        $this->display('add');
    }
    //修改产品
    public function edit(){
        $this->check_qypurview('20002',1);

        $map['pro_id']=intval(I('get.pro_id',0));
        $map['pro_unitcode']=session('unitcode');
        $Product= M('Product');
        $data=$Product->where($map)->find();
        if($data){

        }else{
            $this->error('没有该记录');
        }
        $imgpath = BASE_PATH.'/Public/uploads/product/';
		
        if(is_not_null($data['pro_pic']) && file_exists($imgpath.$data['pro_pic'])){

            $data['pro_pic_str']='<img src="'.__ROOT__.'/Public/uploads/product/'.$data['pro_pic'].'"  border="0" style="vertical-align:middle;width:5%" >';

        }else{
            $data['pro_pic_str']='';
        }
		if(is_not_null($data['pro_pic2']) && file_exists($imgpath.$data['pro_pic2'])){

            $data['pro_pic2_str']='<img src="'.__ROOT__.'/Public/uploads/product/'.$data['pro_pic2'].'"  border="0" style="vertical-align:middle;width:5%" >';

        }else{
            $data['pro_pic2_str']='';
        }
		if(is_not_null($data['pro_pic3']) && file_exists($imgpath.$data['pro_pic3'])){

            $data['pro_pic3_str']='<img src="'.__ROOT__.'/Public/uploads/product/'.$data['pro_pic3'].'"  border="0" style="vertical-align:middle;width:5%" >';

        }else{
            $data['pro_pic3_str']='';
        }
		if(is_not_null($data['pro_pic4']) && file_exists($imgpath.$data['pro_pic4'])){

            $data['pro_pic4_str']='<img src="'.__ROOT__.'/Public/uploads/product/'.$data['pro_pic4'].'"  border="0" style="vertical-align:middle;width:5%" >';

        }else{
            $data['pro_pic4_str']='';
        }
		if(is_not_null($data['pro_pic5']) && file_exists($imgpath.$data['pro_pic5'])){

            $data['pro_pic5_str']='<img src="'.__ROOT__.'/Public/uploads/product/'.$data['pro_pic5'].'"  border="0" style="vertical-align:middle;width:5%" >';

        }else{
            $data['pro_pic5_str']='';
        }
		
		
        //分类
        $map2['protype_unitcode']=session('unitcode');
        $map2['protype_iswho'] = 0;
        $Protype = M('Protype');
        $list2 = $Protype->where($map2)->order('protype_order ASC')->select();
        foreach($list2 as $k=>$v){ 
            $map3['protype_unitcode']=session('unitcode');
            $map3['protype_iswho'] = $v['protype_id'];

            if($v['protype_id']==$data['pro_typeid']){
                $list2[$k]['selected']='selected';
            }else{
                $list2[$k]['selected']='';
            }

            $list3 = $Protype->where($map3)->order('protype_order ASC')->select();
            foreach($list3 as $kk=>$vv){ 
                if($vv['protype_id']==$data['pro_typeid']){
                    $list3[$kk]['selected']='selected';
                }else{
                    $list3[$kk]['selected']='';
                }
            }

            $list2[$k]['subarr']=$list3;
        }
        $this->assign('typelist', $list2);
		
		$map2=array();
        $map2['attr_unitcode']=session('unitcode');
        $map2['attr_proid'] = $data['pro_id'];
        $Yifuattr = M('Yifuattr');
        $colorlist = $Yifuattr->where($map2)->order('attr_id ASC')->select();

		$this->assign('colorlist', $colorlist);
    
        $this->assign('proinfo', $data);
        $this->assign('curr', 'pro_list');
        $this->assign('atitle', '修 改');
		
		//editor
		$ttamp=time();
		$sture=MD5(session('unitcode').$ttamp);
		$this->assign('ttamp', URLEncode($ttamp));
        $this->assign('sture', URLEncode($sture));
        $this->assign('uid', URLEncode(\Org\Util\Funcrypt::authcode(session('unitcode'),'ENCODE',C('WWW_AUTHKEY'),0)));
		
		$this->display('add');
    }
   
   //浏览产品
    public function view(){
        $this->check_qypurview('20001',1);

        $map['pro_id']=intval(I('get.pro_id',0));
        $map['pro_unitcode']=session('unitcode');
        $Product= M('Product');
        $data=$Product->where($map)->find();
        if($data){

        }else{
            $this->error('没有该记录');
        }
        $imgpath = BASE_PATH.'/Public/uploads/product/';
        if(is_not_null($data['pro_pic']) && file_exists($imgpath.$data['pro_pic'])){
            $arr=getimagesize($imgpath.$data['pro_pic']);
            if(false!=$arr){
                $w=$arr[0];
                $h=$arr[1];
                if($h>60){
                   $hh=60;
                   $ww=($w*60)/$h;
                }else{
                   $hh=$h;
                   $ww=$w;
                }
                if($ww>60){
                   $ww=60;
                   $hh=($h*60)/$w;
                }
                $data['pro_pic_str']='<img src="'.__ROOT__.'/Public/uploads/product/'.$data['pro_pic'].'" width="'.$ww.'"  height="'.$hh.'"  border="0" style="vertical-align:middle" >';
            }
            else{
                $data['pro_pic_str']='';
            }
        }else{
            $data['pro_pic_str']='';
        }
        //分类
        $map2['protype_unitcode']=session('unitcode');
        $map2['pro_typeid'] = $data['pro_typeid'];
        $Protype = M('Protype');
        $data2 = $Protype->where($map2)->find();
        if($data2){
            $data['pro_type_str']=$data2['protype_name'];
        }else{
            $data['pro_type_str']='';
        }
        

    
        $this->assign('proinfo', $data);
        $this->assign('curr', 'pro_list');

        $this->display('view');
    }
    
	//删除产品
    public function delete(){
        $this->check_qypurview('20003',1);

        $map['pro_id']=intval(I('get.pro_id',0));
        $map['pro_unitcode']=session('unitcode');
        $Product= M('Product');
        $data=$Product->where($map)->find();

        if($data){
            //验证是否要删除 要保持数据完整性 
			$map2=array();
            $map2['ship_pro']=$data['pro_id'];
            $map2['ship_unitcode']=session('unitcode');
            $Shipment= M('Shipment');
            $data2=$Shipment->where($map2)->find();
            if($data2){
                $this->error('该产品已应用到出货记录，暂不能删除','',2);
            }
			
			//产品订单
			$Orderdetail= M('Orderdetail');
			$map2=array();
            $map2['oddt_proid']=$data['pro_id'];
            $map2['oddt_unitcode']=session('unitcode');
			$data2=$Orderdetail->where($map2)->find();
            if($data2){
                $this->error('该产品已有订单，暂不能删除','',2);
            }
			
			
			//产品返利
			$Fanlidetail= M('Fanlidetail');
			$map2=array();
            $map2['fl_proid']=$data['pro_id'];
            $map2['fl_unitcode']=session('unitcode');
			$data2=$Fanlidetail->where($map2)->find();
            if($data2){
                $this->error('该产品已有返利记录，暂不能删除','',2);
            }
			
			//产品积分
			$Dljfdetail= M('Dljfdetail');
			$map2=array();
            $map2['dljf_proid']=$data['pro_id'];
            $map2['dljf_unitcode']=session('unitcode');
			$data2=$Dljfdetail->where($map2)->find();
            if($data2){
                $this->error('该产品已设置产品积分，暂不能删除','',2);
            }
			
			
			//预付款返利
			$Yufukuan= M('Yufukuan');
			$map2=array();
            $map2['yfk_proid']=$data['pro_id'];
            $map2['yfk_unitcode']=session('unitcode');
			$data2=$Yufukuan->where($map2)->find();
            if($data2){
                $this->error('该产品已有返利记录，暂不能删除','',2);
            }
			
			$map2=array();
			$map2['pri_proid']=$data['pro_id'];
            $map2['pri_unitcode']=session('unitcode');
			$Proprice= M('Proprice');
			$Proprice->where($map2)->delete(); 
			
			$map2=array();
			$map2['pfl_proid']=$data['pro_id'];
            $map2['pfl_unitcode']=session('unitcode');
			$Profanli= M('Profanli');
			$Profanli->where($map2)->delete(); 
			
			$Yifuattr= M('Yifuattr');
			$map3=array();
			$map3['attr_unitcode']=session('unitcode');
			$map3['attr_proid'] = $data['pro_id'];
			$Yifuattr->where($map3)->delete(); 
			
            @unlink('./Public/uploads/product/'.$data['pro_pic']); 
			@unlink('./Public/uploads/product/'.$data['pro_pic2']); 
			@unlink('./Public/uploads/product/'.$data['pro_pic3']); 
			@unlink('./Public/uploads/product/'.$data['pro_pic4']); 
			@unlink('./Public/uploads/product/'.$data['pro_pic5']); 
            $Product->where($map)->delete(); 

            //记录日志 begin
            $log_arr=array(
                        'log_qyid'=>session('qyid'),
                        'log_user'=>session('qyuser'),
                        'log_qycode'=>session('unitcode'),
                        'log_action'=>'删除产品',
						'log_type'=>1, //0-系统 1-企业 2-经销商 3-消费者
                        'log_addtime'=>time(),
                        'log_ip'=>real_ip(),
                        'log_link'=>__SELF__,
                        'log_remark'=>json_encode($data)
                        );
            save_log($log_arr);
            //记录日志 end
            $this->success('删除成功','',1);
        }else{
            $this->error('没有该记录');
        }     
    
    }
    
	
	//删除产品图片
    public function delpic(){
        $this->check_qypurview('20002',1);
		
        $pic=intval(I('get.pic',0));
		
        $map['pro_id']=intval(I('get.proid',0));
        $map['pro_unitcode']=session('unitcode');
        $Product= M('Product');
        $data=$Product->where($map)->find();

        if($data){
			$data2=array();
            if($pic==2){
				$data2['pro_pic2']='';
				@unlink('./Public/uploads/product/'.$data['pro_pic2']); 
			}else if($pic==3){
				$data2['pro_pic3']='';
				@unlink('./Public/uploads/product/'.$data['pro_pic3']); 
			}else if($pic==4){
				$data2['pro_pic4']='';
				@unlink('./Public/uploads/product/'.$data['pro_pic4']); 
			}else if($pic==5){
			   $data2['pro_pic5']='';
			   @unlink('./Public/uploads/product/'.$data['pro_pic5']); 
			}
			
			$Product->where($map)->data($data2)->save();
          
			$this->success('删除成功',U('Mp/Product/edit/pro_id/'.$map['pro_id'].''),1);

        }else{
            $this->error('没有该记录');
        }     
    
    }
    
	
	//激活禁用产品
    public function active(){
        $this->check_qypurview('20002',1);

        $map['pro_id']=intval(I('get.pro_id',0));
        $map['pro_unitcode']=session('unitcode');
        $Product= M('Product');
        $data=$Product->where($map)->find();
        if($data){
            $active=intval(I('get.pro_active',0));

            if($active==1){
                $data2['pro_active'] = 0;
            }else{
                $data2['pro_active'] = 1;
            }
            
            $Product->where($map)->save($data2);
            $this->success('激活/禁用成功','',1);
        }else{
            $this->error('没有该记录');
        }
    }

    //保存产品
    public function edit_save(){
        $this->check_qypurview('20002',1);

    	if (!IS_POST) {
             header('HTTP/1.0 404 Not Found');
             echo'error:404';
             exit;
        }
        $map['pro_id']=intval(I('post.pro_id',''));
        
        if($map['pro_id']>0){
            //修改保存
            $pro_typeid=intval(I('post.pro_typeid',0));
            $pro_jifen=I('post.pro_jifen','');
            $pro_jifen2=I('post.pro_jifen2','');
            $pro_jftype=intval(I('post.pro_jftype',1));
            $pro_jfmax=I('post.pro_jfmax','');
			$pro_price=I('post.pro_price','');
			$pro_dbiao=intval(I('post.pro_dbiao',0));
			$pro_zbiao=0;
			$pro_xbiao=intval(I('post.pro_xbiao',0));
			$pro_units=I('post.pro_units','');
			$pro_dljf=I('post.pro_dljf','');
			$pro_stock=I('post.pro_stock','');
			
			$attr_color = (isset($_POST['attr_color']) && is_not_null($_POST['attr_color'])) ? $_POST['attr_color']:array();
			$attr_size = (isset($_POST['attr_size']) && is_not_null($_POST['attr_size'])) ? $_POST['attr_size']:array();
			$attr_id = (isset($_POST['attr_id']) && is_not_null($_POST['attr_id'])) ? $_POST['attr_id']:array();
			


			if($pro_price==''){
				$pro_price=0;
			}else{
				if(!preg_match("/^[0-9.]{1,9}$/",$pro_price)){
                    $this->error('输入价格必须为数字');
                }
			}
			
			if($pro_stock==''){
				$pro_stock=0;
			}else{
				if(!preg_match("/^[0-9]{1,9}$/",$pro_stock)){
                    $this->error('输入库存必须为数字');
                }
			}
			
            if($pro_typeid<=0){
                $this->error('请选择产品类别','',1);
            }
			
			if($pro_dljf==''){
                $pro_dljf=0;
			}else{
				if(!preg_match("/^[0-9]{1,9}$/",$pro_dljf)){
					$this->error('输入代理积分必须为数字');
				}
			}
			
            if($pro_jftype==1){
                if($pro_jifen==''){
                    $pro_jifen=0;
                }else{
                    if(!preg_match("/^[0-9]{1,6}$/",$pro_jifen)){
                        $this->error('输入积分必须为数字');
                    }
                }
                $pro_jfmax=0;
            }else if($pro_jftype==2){
                if($pro_jifen2==''){
                    $pro_jifen=0;
                }else{
                    if(!preg_match("/^[0-9]{1,6}$/",$pro_jifen2)){
                                    $this->error('输入积分必须为数字');
                    }
                    $pro_jifen=$pro_jifen2;
                }

                if($pro_jfmax==''){
                    $pro_jfmax=0;
                }else{
                    if(!preg_match("/^[0-9]{1,6}$/",$pro_jfmax)){
                        $this->error('输入积分必须为数字');
                    }
                }
                if($pro_jifen>$pro_jfmax){
                     $this->error('积分范围应该由小到大');
                }
            }else{
                $pro_jifen=0;
                $pro_jfmax=0;
            }

            $pro_link=I('post.pro_link','');
            if($pro_link!=''){
                if(strtolower(substr($pro_link,0,7))!='http://'){
                    $this->error('链接要以http://开头','',1);
                }
            }

            $data['pro_id']=$map['pro_id'];
            $data['pro_name']=I('post.pro_name','');
            $data['pro_number']=I('post.pro_number','');
            $data['pro_order']=intval(I('post.pro_order',0));
            $data['pro_typeid']=$pro_typeid;
            $data['pro_jftype']=$pro_jftype;
            $data['pro_jifen']=$pro_jifen;
            $data['pro_jfmax']=$pro_jfmax;
			$data['pro_dljf']=$pro_dljf;
            $data['pro_desc']=(isset($_POST['econtent']) && is_not_null($_POST['econtent'])) ? $_POST['econtent']:'';
            $data['pro_link']=$pro_link;
            $data['pro_barcode']=I('post.pro_barcode','');
            $data['pro_remark']=I('post.pro_remark','');
			$data['pro_price']=$pro_price;
			$data['pro_stock']=$pro_stock;
			$data['pro_units']=$pro_units;
			$data['pro_dbiao']=$pro_dbiao;
			$data['pro_zbiao']=$pro_zbiao;
			$data['pro_xbiao']=$pro_xbiao;

            
            if($data['pro_name']=='' ){
                $this->error('产品名称不能为空','',2);
            }
			if($data['pro_number']==''){
                $this->error('产品编号不能为空','',2);
            }
			if($data['pro_typeid']==0 ){
                $this->error('产品类别不能为空','',2);
            }
			if($data['pro_price']==0 ){
                $this->error('零售价不能为空','',2);
            }
			if($data['pro_units']=='' ){
                $this->error('产品包装单位不能为空','',2);
            }
			if($data['pro_dbiao']>1){
				$this->error('大标不能大于1','',2);
			}

            $map2['pro_unitcode']=session('unitcode');
            $map2['pro_name']=I('post.pro_name','');
            $map2['pro_number']=I('post.pro_number','');
            $map2['pro_id'] = array('NEQ',$map['pro_id']);
            $Product= M('Product');
			$Yifuattr= M('Yifuattr');
			
            $data2=$Product->where($map2)->find();
            if($data2){
                $this->error('该产品已存在','',1);
            }
            
            //上传文件 begin
            if($_FILES['pic_file']['name']==''){
                $pro_pic='';
            }else{
                $upload = new \Think\Upload();
                $upload->maxSize = 1045504 ;
                $upload->exts = array('jpg', 'gif', 'png', 'jpeg');
                $upload->rootPath   = './Public/uploads/product/';
                $upload->subName  = session('unitcode');
                $upload->saveName = time().'_'.mt_rand(1000,9999);
                
                $info   =   $upload->uploadOne($_FILES['pic_file']);

                if(!$info) {
                    $this->error($upload->getError(),'',1);
                }else{
                    $pro_pic=$info['savepath'].$info['savename'];
                }

                @unlink($upload->rootPath.I('post.old_pro_pic','')); 
                @unlink($_FILES['pic_file']['tmp_name']); 
            }
			
			if($_FILES['pic_file2']['name']==''){
                $pro_pic2='';
            }else{
                $upload = new \Think\Upload();
                $upload->maxSize = 1045504 ;
                $upload->exts = array('jpg', 'gif', 'png', 'jpeg');
                $upload->rootPath   = './Public/uploads/product/';
                $upload->subName  = session('unitcode');
                $upload->saveName = time().'2_'.mt_rand(1000,9999);
                
                $info   =   $upload->uploadOne($_FILES['pic_file2']);

                if(!$info) {
                    $this->error($upload->getError(),'',1);
                }else{
                    $pro_pic2=$info['savepath'].$info['savename'];
                }

                @unlink($upload->rootPath.I('post.old_pro_pic2','')); 
                @unlink($_FILES['pic_file2']['tmp_name']); 
            }
			
			if($_FILES['pic_file3']['name']==''){
                $pro_pic3='';
            }else{
                $upload = new \Think\Upload();
                $upload->maxSize = 1045504 ;
                $upload->exts = array('jpg', 'gif', 'png', 'jpeg');
                $upload->rootPath   = './Public/uploads/product/';
                $upload->subName  = session('unitcode');
                $upload->saveName = time().'3_'.mt_rand(1000,9999);
                
                $info   =   $upload->uploadOne($_FILES['pic_file3']);

                if(!$info) {
                    $this->error($upload->getError(),'',1);
                }else{
                    $pro_pic3=$info['savepath'].$info['savename'];
                }

                @unlink($upload->rootPath.I('post.old_pro_pic3','')); 
                @unlink($_FILES['pic_file3']['tmp_name']); 
            }
			
			if($_FILES['pic_file4']['name']==''){
                $pro_pic4='';
            }else{
                $upload = new \Think\Upload();
                $upload->maxSize = 1045504 ;
                $upload->exts = array('jpg', 'gif', 'png', 'jpeg');
                $upload->rootPath   = './Public/uploads/product/';
                $upload->subName  = session('unitcode');
                $upload->saveName = time().'4_'.mt_rand(1000,9999);
                
                $info   =   $upload->uploadOne($_FILES['pic_file4']);

                if(!$info) {
                    $this->error($upload->getError(),'',1);
                }else{
                    $pro_pic4=$info['savepath'].$info['savename'];
                }

                @unlink($upload->rootPath.I('post.old_pro_pic4','')); 
                @unlink($_FILES['pic_file4']['tmp_name']); 
            }
			
			if($_FILES['pic_file5']['name']==''){
                $pro_pic5='';
            }else{
                $upload = new \Think\Upload();
                $upload->maxSize = 1045504 ;
                $upload->exts = array('jpg', 'gif', 'png', 'jpeg');
                $upload->rootPath   = './Public/uploads/product/';
                $upload->subName  = session('unitcode');
                $upload->saveName = time().'5_'.mt_rand(1000,9999);
                
                $info   =   $upload->uploadOne($_FILES['pic_file5']);

                if(!$info) {
                    $this->error($upload->getError(),'',1);
                }else{
                    $pro_pic5=$info['savepath'].$info['savename'];
                }

                @unlink($upload->rootPath.I('post.old_pro_pic5','')); 
                @unlink($_FILES['pic_file5']['tmp_name']); 
            }
			
			
			
			
            //上传文件 end
            if($pro_pic!=''){
                $data['pro_pic']=$pro_pic;
            }
			if($pro_pic2!=''){
                $data['pro_pic2']=$pro_pic2;
            }
			if($pro_pic3!=''){
                $data['pro_pic3']=$pro_pic3;
            }
			if($pro_pic4!=''){
                $data['pro_pic4']=$pro_pic4;
            }
			if($pro_pic5!=''){
                $data['pro_pic5']=$pro_pic5;
            }
            
            $map['pro_unitcode']=session('unitcode');
            $rs=$Product->where($map)->data($data)->save();
			
			//处理颜色尺码
			$czids='';
			foreach($attr_color as $k=>$v){
				if(!isset($attr_size[$k])){
					$attr_size[$k]='';
				}
				if(!isset($attr_id[$k])){
					$attr_id[$k]=0;
				}
				if(is_not_null($v) && is_not_null($attr_size[$k]) ){
					if($attr_id[$k]>0){
						$map3=array();
						$map3['attr_unitcode']=session('unitcode');
						$map3['attr_proid'] = $map['pro_id'];
						$map3['attr_id'] = $attr_id[$k];

						$data3=$Yifuattr->where($map3)->find();
						if($data3){
							$data2=array();
							$data2['attr_color']=$attr_color[$k];
							$data2['attr_size']=$attr_size[$k];;
							$data2['attr_stock']=0;
							$data2['attr_price']=0;
							$Yifuattr->where($map3)->data($data2)->save();
							
							if($czids==''){
							   $czids=$attr_id[$k];
							}else{
							   $czids=$czids.','.$attr_id[$k];
							}
							
						}else{

							$data2=array();
							$data2['attr_unitcode']=session('unitcode');
							$data2['attr_proid']=$map['pro_id'];
							$data2['attr_color']=$attr_color[$k];
							$data2['attr_size']=$attr_size[$k];;
							$data2['attr_stock']=0;
							$data2['attr_price']=0;
							$rs2=$Yifuattr->create($data2,1);
							if($rs2){
								$rsid2=$Yifuattr->add(); 
								if($rsid2){
									if($czids==''){
									   $czids=$rsid2;
									}else{
									   $czids=$czids.','.$rsid2;
									}
								}
							}
						}
					}else{
						$data2=array();
						$data2['attr_unitcode']=session('unitcode');
						$data2['attr_proid']=$map['pro_id'];
						$data2['attr_color']=$attr_color[$k];
						$data2['attr_size']=$attr_size[$k];;
						$data2['attr_stock']=0;
						$data2['attr_price']=0;
						$rs2=$Yifuattr->create($data2,1);
						if($rs2){
							$rsid2=$Yifuattr->add(); 
							if($rsid2){
								if($czids==''){
								   $czids=$rsid2;
								}else{
								   $czids=$czids.','.$rsid2;
								}
							}
						}
						
					}
				}
			}
			

			if($czids!=''){
				$map3=array();
				$map3['attr_unitcode']=session('unitcode');
				$map3['attr_proid'] = $map['pro_id'];
				$map3['attr_id'] = array('not in',$czids);
				$Yifuattr->where($map3)->delete(); 
			}
           
            if($rs){

                //记录日志 begin
                $log_arr=array(
                            'log_qyid'=>session('qyid'),
                            'log_user'=>session('qyuser'),
                            'log_qycode'=>session('unitcode'),
                            'log_action'=>'修改产品',
							'log_type'=>1, //0-系统 1-企业 2-经销商 3-消费者
                            'log_addtime'=>time(),
                            'log_ip'=>real_ip(),
                            'log_link'=>__SELF__,
                            'log_remark'=>json_encode(array_merge($data,$attr_color,$attr_size,$attr_id))
                            );
                save_log($log_arr);
                //记录日志 end
                $this->success('修改成功',U('Mp/Product/edit/pro_id/'.$map['pro_id'].''),1);
            }elseif($rs===0){
                $this->error('修改成功',U('Mp/Product/edit/pro_id/'.$map['pro_id'].''),1);
            }else{
                $this->error('修改失败','',1);
            }
        }else{  
            //添加保存
            $map=array();
            $map['pro_unitcode']=session('unitcode');
            $map['pro_name']=I('post.pro_name','');
            $map['pro_number']=I('post.pro_number','');

			
			$attr_color = (isset($_POST['attr_color']) && is_not_null($_POST['attr_color'])) ? $_POST['attr_color']:array();
			$attr_size = (isset($_POST['attr_size']) && is_not_null($_POST['attr_size'])) ? $_POST['attr_size']:array();
			$attr_id = (isset($_POST['attr_id']) && is_not_null($_POST['attr_id'])) ? $_POST['attr_id']:array();
			

            $Product= M('Product');
			$Yifuattr= M('Yifuattr');
            $data2=$Product->where($map)->find();
            if($data2){
                $this->error('该产品已存在');
            }
            $pro_order=intval(I('post.pro_order',0));
            $pro_typeid=intval(I('post.pro_typeid',0));
            $pro_jifen=I('post.pro_jifen','');
            $pro_jifen2=I('post.pro_jifen2','');
            $pro_jftype=intval(I('post.pro_jftype',1));
            $pro_jfmax=I('post.pro_jfmax','');
			$pro_price=I('post.pro_price','');
			$pro_dbiao=intval(I('post.pro_dbiao',0));
			$pro_zbiao=0;
			$pro_xbiao=intval(I('post.pro_xbiao',0));
			$pro_units=I('post.pro_units','');
			$pro_dljf=I('post.pro_dljf','');
			$pro_stock=I('post.pro_stock','');
			
			if($pro_price==''){
				$pro_price=0;
			}else{
				if(!preg_match("/^[0-9.]{1,9}$/",$pro_price)){
                    $this->error('输入价格必须为数字');
                }
			}
			
			if($pro_stock==''){
				$pro_stock=0;
			}else{
				if(!preg_match("/^[0-9]{1,9}$/",$pro_stock)){
                    $this->error('输入库存必须为数字');
                }
			}
			
            if($pro_typeid<=0){
                $this->error('请选择产品类别');
            }
			
			if($pro_dljf==''){
                $pro_dljf=0;
			}else{
				if(!preg_match("/^[0-9]{1,6}$/",$pro_dljf)){
					$this->error('输入代理积分必须为数字');
				}
			}
			
            if($pro_jftype==1){
                if($pro_jifen==''){
                    $pro_jifen=0;
                }else{
                    if(!preg_match("/^[0-9]{1,6}$/",$pro_jifen)){
                        $this->error('输入积分必须为数字');
                    }
                }
                $pro_jfmax=0;
            }else if($pro_jftype==2){
                if($pro_jifen2==''){
                    $pro_jifen=0;
                }else{
                    if(!preg_match("/^[0-9]{1,6}$/",$pro_jifen2)){
                                    $this->error('输入积分必须为数字');
                    }
                    $pro_jifen=$pro_jifen2;
                }

                if($pro_jfmax==''){
                    $pro_jfmax=0;
                }else{
                    if(!preg_match("/^[0-9]{1,6}$/",$pro_jfmax)){
                        $this->error('输入积分必须为数字');
                    }
                }
                if($pro_jifen>$pro_jfmax){
                     $this->error('积分范围应该由小到大');
                }
            }else{
                $pro_jifen=0;
                $pro_jfmax=0;
            }

            $pro_link=I('post.pro_link','');
            if($pro_link!=''){
                if(strtolower(substr($pro_link,0,7))!='http://'){
                    $this->error('链接要以http://开头','',1);
                }
            }

            $data['pro_name']=$map['pro_name'];
            $data['pro_number']=$map['pro_number'];
            $data['pro_order']=$pro_order;
            $data['pro_unitcode']=session('unitcode');
            $data['pro_typeid']=$pro_typeid;
            $data['pro_jftype']=$pro_jftype;
            $data['pro_jifen']=$pro_jifen;
            $data['pro_jfmax']=$pro_jfmax;
			$data['pro_dljf']=$pro_dljf;
            $data['pro_desc']=(isset($_POST['econtent']) && is_not_null($_POST['econtent'])) ? $_POST['econtent']:'';
            $data['pro_link']=$pro_link;
            $data['pro_barcode']=I('post.pro_barcode','');
            $data['pro_remark']=I('post.pro_remark','');
            $data['pro_addtime']=time();
            $data['pro_active']=1;
			$data['pro_price']=$pro_price;
			$data['pro_stock']=$pro_stock;
			$data['pro_units']=$pro_units;
			$data['pro_dbiao']=$pro_dbiao;
			$data['pro_zbiao']=$pro_zbiao;
			$data['pro_xbiao']=$pro_xbiao;
            
            if($data['pro_name']=='' ){
                $this->error('产品名称不能为空','',2);
            }
			if($data['pro_number']==''){
                $this->error('产品编号不能为空','',2);
            }
			if($data['pro_typeid']==0 ){
                $this->error('产品类别不能为空','',2);
            }
			if($data['pro_price']==0 ){
                $this->error('零售价不能为空','',2);
            }
			if($data['pro_units']=='' ){
                $this->error('产品包装单位不能为空','',2);
            }
			if($data['pro_dbiao']>1){
				$this->error('大标不能大于1','',2);
			}
			
			
            //上传文件 begin
            if($_FILES['pic_file']['name']==''){
                $pro_pic='';
            }else{
                
                $upload = new \Think\Upload();
                $upload->maxSize = 1045504 ; //1M
                $upload->exts = array('jpg', 'gif', 'png', 'jpeg');
                $upload->rootPath   = './Public/uploads/product/';
                $upload->subName  = session('unitcode');
                $upload->saveName = time().'_'.mt_rand(1000,9999);
                
                $info   =   $upload->uploadOne($_FILES['pic_file']);

                if(!$info) {
                    $this->error($upload->getError());
                }else{
                    $pro_pic=$info['savepath'].$info['savename'];
                }
                @unlink($_FILES['pic_file']['tmp_name']); 
            }

			if($_FILES['pic_file2']['name']==''){
                $pro_pic2='';
            }else{
                $upload = new \Think\Upload();
                $upload->maxSize = 1045504 ;
                $upload->exts = array('jpg', 'gif', 'png', 'jpeg');
                $upload->rootPath   = './Public/uploads/product/';
                $upload->subName  = session('unitcode');
                $upload->saveName = time().'2_'.mt_rand(1000,9999);
                
                $info   =   $upload->uploadOne($_FILES['pic_file2']);

                if(!$info) {
                    $this->error($upload->getError(),'',1);
                }else{
                    $pro_pic2=$info['savepath'].$info['savename'];
                }

                @unlink($_FILES['pic_file2']['tmp_name']); 
            }
			
			if($_FILES['pic_file3']['name']==''){
                $pro_pic3='';
            }else{
                $upload = new \Think\Upload();
                $upload->maxSize = 1045504 ;
                $upload->exts = array('jpg', 'gif', 'png', 'jpeg');
                $upload->rootPath   = './Public/uploads/product/';
                $upload->subName  = session('unitcode');
                $upload->saveName = time().'3_'.mt_rand(1000,9999);
                $info   =   $upload->uploadOne($_FILES['pic_file3']);
                if(!$info) {
                    $this->error($upload->getError(),'',1);
                }else{
                    $pro_pic3=$info['savepath'].$info['savename'];
                }
                @unlink($_FILES['pic_file3']['tmp_name']); 
            }
			if($_FILES['pic_file4']['name']==''){
                $pro_pic4='';
            }else{
                $upload = new \Think\Upload();
                $upload->maxSize = 1045504 ;
                $upload->exts = array('jpg', 'gif', 'png', 'jpeg');
                $upload->rootPath   = './Public/uploads/product/';
                $upload->subName  = session('unitcode');
                $upload->saveName = time().'4_'.mt_rand(1000,9999);
                
                $info   =   $upload->uploadOne($_FILES['pic_file4']);

                if(!$info) {
                    $this->error($upload->getError(),'',1);
                }else{
                    $pro_pic4=$info['savepath'].$info['savename'];
                }

                @unlink($_FILES['pic_file4']['tmp_name']); 
            }
			
			if($_FILES['pic_file5']['name']==''){
                $pro_pic5='';
            }else{
                $upload = new \Think\Upload();
                $upload->maxSize = 1045504 ;
                $upload->exts = array('jpg', 'gif', 'png', 'jpeg');
                $upload->rootPath   = './Public/uploads/product/';
                $upload->subName  = session('unitcode');
                $upload->saveName = time().'5_'.mt_rand(1000,9999);
                
                $info   =   $upload->uploadOne($_FILES['pic_file5']);

                if(!$info) {
                    $this->error($upload->getError(),'',1);
                }else{
                    $pro_pic5=$info['savepath'].$info['savename'];
                }

                @unlink($_FILES['pic_file5']['tmp_name']); 
            }
			
			
			
			
            //上传文件 end
            if($pro_pic!=''){
                $data['pro_pic']=$pro_pic;
            }
			if($pro_pic2!=''){
                $data['pro_pic2']=$pro_pic2;
            }
			if($pro_pic3!=''){
                $data['pro_pic3']=$pro_pic3;
            }
			if($pro_pic4!=''){
                $data['pro_pic4']=$pro_pic4;
            }
			if($pro_pic5!=''){
                $data['pro_pic5']=$pro_pic5;
            }
            //上传文件 end
            $rs=$Product->create($data,1);
            if($rs){
               $result = $Product->add(); 
               if($result){
				    //处理颜色尺码
				    foreach($attr_color as $k=>$v){
				        if(is_not_null($v)){
							if(!isset($attr_size[$k])){
								$attr_size[$k]='';
							}
							if(!isset($attr_id[$k])){
								$attr_id[$k]=0;
							}
							if(is_not_null($attr_size[$k])){
								$data2=array();
								$data2['attr_unitcode']=session('unitcode');
								$data2['attr_proid']=$result;
								$data2['attr_color']=trim($attr_color[$k]);
								$data2['attr_size']=trim($attr_size[$k]);
								$data2['attr_stock']=0;
								$data2['attr_price']=0;
                                $rs2=$Yifuattr->create($data2,1);
								if($rs2){
									$Yifuattr->add(); 
								}
								
							}
						}
				    }
                    //记录日志 begin
                    $log_arr=array(
                                'log_qyid'=>session('qyid'),
                                'log_user'=>session('qyuser'),
                                'log_qycode'=>session('unitcode'),
                                'log_action'=>'添加产品',
								'log_type'=>1, //0-系统 1-企业 2-经销商 3-消费者
                                'log_addtime'=>time(),
                                'log_ip'=>real_ip(),
                                'log_link'=>__SELF__,
                                'log_remark'=>json_encode(array_merge($data,$attr_color,$attr_size,$attr_id))
                                );
                    save_log($log_arr);
                    //记录日志 end
                   $this->success('添加成功',U('Mp/Product/index'));
               }else{
                   $this->error('添加失败');
               }
            }else{
                $this->error('添加失败');
            }

        }

    }

    //=====================================================================================
    //产品分类列表
    public function typelist(){
        $this->check_qypurview('20004',1);
        $map['protype_unitcode']=session('unitcode');
        $map['protype_iswho'] = 0;
        $Protype = M('Protype');
        $list = $Protype->where($map)->order('protype_order ASC')->select();
        foreach($list as $k=>$v){ 
             $map2['protype_unitcode']=session('unitcode');
             $map2['protype_iswho'] = $v['protype_id'];
             $list2 = $Protype->where($map2)->order('protype_order ASC')->select();

             $list[$k]['subarr']=$list2;
        }
        $this->assign('list', $list);
        $this->assign('curr', 'pro_list');
        $this->display('typelist');
    }
   
   //添加产品分类
    public function typeadd(){
        $this->check_qypurview('20004',1);

        $data['protype_id']=0;
        
        $map['protype_unitcode']=session('unitcode');
        $map['protype_iswho'] = 0;
        $Parenttype = M('Protype');
        $list = $Parenttype->where($map)->order('protype_order ASC')->select();
        
        $this->assign('parenttypelist', $list);
        $this->assign('curr', 'pro_list');
        $this->assign('atitle', '添 加');
        $this->assign('protypeinfo', $data);

        $this->display('typeadd');
    }
    
	//修改产品分类
    public function typeedit(){
        $this->check_qypurview('20004',1);

        $map['protype_id']=intval(I('get.protype_id',0));
        $map['protype_unitcode']=session('unitcode');
        $Protype= M('Protype');
        $data=$Protype->where($map)->find();
        if($data){

        }else{
            $this->error('没有该记录');
        }
        $map2['protype_unitcode']=session('unitcode');
        $map2['protype_iswho'] = 0;
        $list = $Protype->where($map2)->order('protype_order ASC')->select();
        foreach($list as $k=>$v){ 
            if($v['protype_id']==$data['protype_iswho']){
                $list[$k]['selected']='selected';
            }else{
                $list[$k]['selected']='';
            }
        }

        $this->assign('parenttypelist', $list);
        $this->assign('protypeinfo', $data);
        $this->assign('curr', 'pro_list');
        $this->assign('atitle', '修 改');

        $this->display('typeadd');
    }

    //保存产品分类
    public function typeedit_save(){
        $this->check_qypurview('20004',1);

        if (!IS_POST) {
             header('HTTP/1.0 404 Not Found');
             echo'error:404';
             exit;
        }
        $map['protype_id']=intval(I('post.protype_id',''));
        
        if($map['protype_id']>0){
            //修改保存
            $data['protype_id']=$map['protype_id'];
            $data['protype_name']=I('post.protype_name','');
            $protype_iswho=I('post.protype_iswho','0');

            if($data['protype_name']==''){
                $this->error('带"*"不能为空');
            }

            if($protype_iswho==$data['protype_id']){
                $this->error('父类不能为自己');
            }
            $data['protype_iswho']=$protype_iswho;

            $Protype= M('Protype');
            $map2['protype_iswho']=$data['protype_id'];
            $map2['protype_unitcode']=session('unitcode');
            $data2=$Protype->where($map2)->find();
            if($data2){
                if($protype_iswho>0){
                    $this->error('该类含有子类，不能作为其他类的子类');
                }
            }

            $rs=$Protype->create($data,2);
           
            if($rs){
               $result = $Protype->save(); 
               if($result){
                    //记录日志 begin
                    $log_arr=array(
                                'log_qyid'=>session('qyid'),
                                'log_user'=>session('qyuser'),
                                'log_qycode'=>session('unitcode'),
                                'log_action'=>'修改产品类型',
								'log_type'=>1, //0-系统 1-企业 2-经销商 3-消费者
                                'log_addtime'=>time(),
                                'log_ip'=>real_ip(),
                                'log_link'=>__SELF__,
                                'log_remark'=>json_encode($data)
                                );
                    save_log($log_arr);
                    //记录日志 end
                   $this->success('修改成功',U('Mp/Product/typelist'));
               }else{
                   $this->error('修改失败');
               }
			}elseif($rs===0){
                $this->error('提交数据未改变','',1);
            }else{
                $this->error('修改失败');
            }

        }else{  
            //添加保存
            $Protype= M('Protype');

            $data['protype_unitcode']=session('unitcode');
            $data['protype_name']=I('post.protype_name','');
            $data['protype_iswho']=I('post.protype_iswho','0');
            

            if($data['protype_name']==''){
                $this->error('带"*"不能为空');
            }
            
            $rs=$Protype->create($data,1);
            if($rs){
               $result = $Protype->add(); 
               if($result){
                   $map2['protype_id'] = $result;
                   $data2['protype_order'] = $result;
                   $Protype->where($map2)->save($data2);

                    //记录日志 begin
                    $log_arr=array(
                                'log_qyid'=>session('qyid'),
                                'log_user'=>session('qyuser'),
                                'log_qycode'=>session('unitcode'),
                                'log_action'=>'添加产品类型',
								'log_type'=>1, //0-系统 1-企业 2-经销商 3-消费者
                                'log_addtime'=>time(),
                                'log_ip'=>real_ip(),
                                'log_link'=>__SELF__,
                                'log_remark'=>json_encode($data)
                                );
                    save_log($log_arr);
                    //记录日志 end
                   $this->success('添加成功',U('Mp/Product/typelist'));
               }else{
                   $this->error('添加失败');
               }
            }else{
                $this->error('添加失败');
            }

        }

    }
    //移动产品分类
    public function typeorder(){
        $this->check_qypurview('20004',1);

        $map['protype_id']=intval(I('get.protype_id',0));
        $map['protype_unitcode']=session('unitcode');
        $active=I('get.active','');

        $Protype= M('Protype');
        $data=$Protype->where($map)->find();
        if(!$data){
            $this->error('没有该记录');
        }

        if($active=='shang'){
            $map2['protype_iswho']=$data['protype_iswho'];
            $map2['protype_unitcode']=session('unitcode');
            $map2['protype_order']=array('LT',$data['protype_order']);
            $data2 = $Protype->where($map2)->order('protype_order DESC')->find();
            if($data2){
                $map3['protype_unitcode']=session('unitcode');
                $map3['protype_id']=$data2['protype_id'];
                $data3['protype_order']=$data['protype_order'];
                $Protype->where($map3)->save($data3);

                $map4['protype_unitcode']=session('unitcode');
                $map4['protype_id']=$data['protype_id'];
                $data4['protype_order']=$data2['protype_order'];
                $Protype->where($map4)->save($data4);

            }

            $this->redirect('Mp/Product/typelist','' , 0, '');

        }elseif($active=='xia'){
            $map2['protype_iswho']=$data['protype_iswho'];
            $map2['protype_unitcode']=session('unitcode');
            $map2['protype_order']=array('GT',$data['protype_order']);
            $data2 = $Protype->where($map2)->order('protype_order ASC')->find();
            if($data2){
                $map3['protype_unitcode']=session('unitcode');
                $map3['protype_id']=$data2['protype_id'];
                $data3['protype_order']=$data['protype_order'];
                $Protype->where($map3)->save($data3);

                $map4['protype_unitcode']=session('unitcode');
                $map4['protype_id']=$data['protype_id'];
                $data4['protype_order']=$data2['protype_order'];
                $Protype->where($map4)->save($data4);

            }
            $this->redirect('Mp/Product/typelist','' , 0, '');
        }
    }

    //删除产品分类
    public function typedelete(){
        $this->check_qypurview('20004',1);
        
        $map['protype_id']=intval(I('get.protype_id',0));
        $map['protype_unitcode']=session('unitcode');
        $Protype= M('Protype');
        $data=$Protype->where($map)->find();
        if($data){

        }else{
            $this->error('没有该记录');
        }
        $Product= M('Product');
        //是否有子类
        $map2['protype_iswho'] = $map['protype_id'];
        $list = $Protype->where($map2)->order('protype_order ASC')->select();
        if($list){
            $this->error('该类型含有子类，暂不能删除');
        }
        //是否应用到产品上
        $map4['pro_typeid'] = $map['protype_id'];
        $data4=$Product->where($map4)->find();
        if($data4){
            $this->error('该类型已应用到产品上，暂不能删除');
        }
        $Protype->where($map)->delete(); 
        //记录日志 begin
        $log_arr=array(
                    'log_qyid'=>session('qyid'),
                    'log_user'=>session('qyuser'),
                    'log_qycode'=>session('unitcode'),
                    'log_action'=>'删除产品类型',
					'log_type'=>1, //0-系统 1-企业 2-经销商 3-消费者
                    'log_addtime'=>time(),
                    'log_ip'=>real_ip(),
                    'log_link'=>__SELF__,
                    'log_remark'=>json_encode($data)
                    );
        save_log($log_arr);
        //记录日志 end
        $this->success('删除成功',U('Mp/Product/typelist'));
    }
	
//========================================================
	//价格体系
    public function proprice(){
        $this->check_qypurview('20001',1);
        $keyword=trim(strip_tags(htmlspecialchars_decode(I('param.keyword',''))));
        if($keyword!=''){
            $keyword=str_replace('[','',$keyword);
            $keyword=str_replace(']','',$keyword);
            $keyword=str_replace('%','',$keyword);
            $keyword=str_replace('_','',$keyword);
            $keyword=sub_str($keyword,20,false);
            $where['pro_name']=array('LIKE', '%'.$keyword.'%');
            $where['pro_number']=array('LIKE', '%'.$keyword.'%');
            $where['_logic'] = 'or';
            $map['_complex'] = $where;
			$parameter['keyword']=$keyword;
        }
        $Product = M('Product');
        $map['pro_unitcode']=session('unitcode');
        $count = $Product->where($map)->count();
        $Page = new \Think\Page($count, C('PAGE_SIZE'),$parameter);
        $show = $Page->show();
        $list = $Product->where($map)->order('pro_id DESC')->limit(($Page->firstRow . ',') . $Page->listRows)->select();
        $Dltype = M('Dltype');
        $Proprice = M('Proprice');
		$map3=array();
        $map3['dlt_unitcode']=session('unitcode');
        $list3 = $Dltype->where($map3)->order('dlt_level ASC,dlt_id ASC')->select();
//        dump($list);die();
        foreach($list as $k=>$v){
		    $price=array();
		    foreach($list3 as $kk=>$vv){
				$map2=array();
				$data2=array();
				$map2['pri_unitcode'] = session('unitcode');
				$map2['pri_proid'] = $v['pro_id'];
				$map2['pri_dltype'] = $vv['dlt_id'];
				$data2=$Proprice->where($map2)->find();
				if($data2){
					$price[]=$data2['pri_price'];
				}else{
					$price[]=0;
				}
			}
			
			$list[$k]['priprice']=$price;
        }
//        dump($list);die();
		$this->assign('list', $list);
        $this->assign('typelist', $list3);
        $this->assign('keyword', $keyword);
        $this->assign('page', $show);
        $this->assign('curr', 'pro_price');

        $this->display('proprice');
    }
   
    //修改产品价格体系
    public function propriceedit(){
        $this->check_qypurview('20002',1);

        $map['pro_id']=intval(I('get.pro_id',0));
        $map['pro_unitcode']=session('unitcode');
        $Product= M('Product');
        $data=$Product->where($map)->find();
		
        $Dltype = M('Dltype');
        $Proprice = M('Proprice');
		$map3=array();
        $map3['dlt_unitcode']=session('unitcode');
        $list3 = $Dltype->where($map3)->order('dlt_level ASC,dlt_id ASC')->select();
		
        if($data){
		    foreach($list3 as $kk=>$vv){
				$map2=array();
				$data2=array();
				$map2['pri_unitcode'] = session('unitcode');
				$map2['pri_proid'] = $data['pro_id'];
				$map2['pri_dltype'] = $vv['dlt_id'];
				$data2=$Proprice->where($map2)->find();
				if($data2){
					$list3[$kk]['priprice']=$data2['pri_price'];
					$list3[$kk]['pri_minimum']=$data2['pri_minimum'];
					$list3[$kk]['pri_jifen']=$data2['pri_jifen'];
				}else{
					$list3[$kk]['priprice']=0;
					$list3[$kk]['pri_minimum']=0;
					$list3[$kk]['pri_jifen']=0;
				}
			}
        }else{
            $this->error('没有该记录');
        }


        $this->assign('typelist', $list3);
        $this->assign('proinfo', $data);
        $this->assign('curr', 'pro_price');

        $this->display('propriceedit');
    }
	
	
    //保存产品价格体系
    public function propriceedit_save(){
        $this->check_qypurview('20004',1);
        if (!IS_POST) {
             header('HTTP/1.0 404 Not Found');
             echo'error:404';
             exit;
        }
        $map['pro_id']=intval(I('post.pro_id',0));
        if($map['pro_id']>0){
			$map['pro_unitcode']=session('unitcode');
			$Product= M('Product');
			$data=$Product->where($map)->find();
			if($data){
				$Dltype = M('Dltype');
				$Proprice = M('Proprice');
				$map3=array();
				$map3['dlt_unitcode']=session('unitcode');
				$list3 = $Dltype->where($map3)->order('dlt_level ASC,dlt_id ASC')->select();
				foreach($list3 as $kk=>$vv){
					$var='pri_price'.$vv['dlt_id'];
					$pri_price = (isset($_POST[$var]) && is_not_null($_POST[$var])) ? trim($_POST[$var]):0;
					if($pri_price!=0){
						if(!preg_match("/^[0-9.]{1,10}$/",$pri_price)){
							$this->error('价格必须为数字','',1);
						}
					}
					$var2='pri_minimum'.$vv['dlt_id'];
					$pri_minimum = (isset($_POST[$var2]) && is_not_null($_POST[$var2])) ? trim($_POST[$var2]):0;
					if($pri_minimum!=0){
						if(!preg_match("/^[0-9]{1,10}$/",$pri_minimum)){
							$this->error('最低补货必须为数字','',1);
						}
					}
					
					$var3='pri_jifen'.$vv['dlt_id'];
					$pri_jifen = (isset($_POST[$var3]) && is_not_null($_POST[$var3])) ? trim($_POST[$var3]):0;
					if($pri_jifen!=0){
						if(!preg_match("/^[0-9]{1,10}$/",$pri_jifen)){
							$this->error('积分必须为数字','',1);
						}
					}
					
					$map2=array();
					$data2=array();
					$map2['pri_unitcode'] = session('unitcode');
					$map2['pri_proid'] = $data['pro_id'];
					$map2['pri_dltype'] = $vv['dlt_id'];
					$data2=$Proprice->where($map2)->find();
					if($data2){
						$data4=array();
						$data4['pri_price']=$pri_price;
						$data4['pri_minimum']=$pri_minimum;
						$data4['pri_jifen']=$pri_jifen;
						$Proprice->where($map2)->data($data4)->save();
						
						$list3[$kk]['priprice']=$pri_price;
					}else{
						if($pri_price>0){
							$data4=array();
							$data4['pri_unitcode']= session('unitcode');
							$data4['pri_proid'] = $data['pro_id'];
							$data4['pri_dltype'] = $vv['dlt_id'];
							$data4['pri_price']=$pri_price;
							$data4['pri_minimum']=$pri_minimum;
							$data4['pri_jifen']=$pri_jifen;
							
							$rs=$Proprice->create($data4,1);
							if($rs){
							   $Proprice->add(); 
							}
							
							$list3[$kk]['priprice']=$pri_price;
						}else{
						    $list3[$kk]['priprice']=0;
						}
					}
				    $list3[$kk]['pro_id']=$data['pro_id'];
				}
				
				//记录日志 begin
				$log_arr=array(
							'log_qyid'=>session('qyid'),
							'log_user'=>session('qyuser'),
							'log_qycode'=>session('unitcode'),
							'log_action'=>'修改产品价格体系',
							'log_type'=>1, //0-系统 1-企业 2-经销商 3-消费者
							'log_addtime'=>time(),
							'log_ip'=>real_ip(),
							'log_link'=>__SELF__,
							'log_remark'=>json_encode($list3)
							);
				save_log($log_arr);
				//记录日志 end
				
				$this->success('修改成功',U('Mp/Product/proprice'),'',2);
				
			}else{
				$this->error('没有该记录','',2);
			}
        }else{  
            $this->error('没有该记录','',2);
        }
    }
	
    //产品返利设置
    public function profanli(){
        $this->check_qypurview('20002',1);

        $map['pro_id']=intval(I('get.pro_id',0));
        $map['pro_unitcode']=session('unitcode');
        $Product= M('Product');
        $data=$Product->where($map)->find();
        $Dltype = M('Dltype');
        $Profanli = M('Profanli');
		$map3=array();
        $map3['dlt_unitcode']=session('unitcode');
        $list3 = $Dltype->where($map3)->order('dlt_level ASC,dlt_id ASC')->select();
        if($data){
		    foreach($list3 as $kk=>$vv){
				$map2=array();
				$data2=array();
				$map2['pfl_unitcode'] = session('unitcode');
				$map2['pfl_proid'] = $data['pro_id'];
				$map2['pfl_dltype'] = $vv['dlt_id'];
				$data2=$Profanli->where($map2)->find();
				if($data2){
					$list3[$kk]['pfl_fanli1']=$data2['pfl_fanli1'];
					$list3[$kk]['pfl_fanli2']=$data2['pfl_fanli2'];
					$list3[$kk]['pfl_fanli3']=$data2['pfl_fanli3'];
					$list3[$kk]['pfl_fanli4']=$data2['pfl_fanli4'];
					$list3[$kk]['pfl_fanli5']=$data2['pfl_fanli5'];
					$list3[$kk]['pfl_fanli6']=$data2['pfl_fanli6'];
					$list3[$kk]['pfl_fanli7']=$data2['pfl_fanli7'];
					$list3[$kk]['pfl_fanli8']=$data2['pfl_fanli8'];
					$list3[$kk]['pfl_fanli9']=$data2['pfl_fanli9'];
					$list3[$kk]['pfl_fanli10']=$data2['pfl_fanli10'];
					$list3[$kk]['pfl_maiduan']=$data2['pfl_maiduan'];
				}else{
					$list3[$kk]['pfl_fanli1']=0;
					$list3[$kk]['pfl_fanli2']=0;
					$list3[$kk]['pfl_fanli3']=0;
					$list3[$kk]['pfl_fanli4']=0;
					$list3[$kk]['pfl_fanli5']=0;
					$list3[$kk]['pfl_fanli6']=0;
					$list3[$kk]['pfl_fanli7']=0;
					$list3[$kk]['pfl_fanli8']=0;
					$list3[$kk]['pfl_fanli9']=0;
					$list3[$kk]['pfl_fanli10']=0;
					$list3[$kk]['pfl_maiduan']=0;
				}
			}
        }else{
            $this->error('没有该记录');
        }
        $this->assign('typelist', $list3);
        $this->assign('proinfo', $data);
        $this->assign('curr', 'pro_price');
        $this->display('profanli');
    }
    //产品返利设置——保存
    public function profanli_save(){
        $this->check_qypurview('20004',1);

        if (!IS_POST) {
             header('HTTP/1.0 404 Not Found');
             echo'error:404';
             exit;
        }
        $map['pro_id']=intval(I('post.pro_id',0));
        
        if($map['pro_id']>0){
			$map['pro_unitcode']=session('unitcode');
			$Product= M('Product');
			$data=$Product->where($map)->find();
			
			if($data){
				$Dltype = M('Dltype');
				$Profanli = M('Profanli');
				$map3=array();
				$map3['dlt_unitcode']=session('unitcode');
				$list3 = $Dltype->where($map3)->order('dlt_level ASC,dlt_id ASC')->select();
				
				foreach($list3 as $kk=>$vv){
					$var1='pfl_fanli1'.$vv['dlt_id'];
					$var2='pfl_fanli2'.$vv['dlt_id'];
					$var3='pfl_fanli3'.$vv['dlt_id'];
					$var4='pfl_fanli4'.$vv['dlt_id'];
					$var5='pfl_fanli5'.$vv['dlt_id'];
					$var6='pfl_fanli6'.$vv['dlt_id'];
					$var7='pfl_fanli7'.$vv['dlt_id'];
					$var8='pfl_fanli8'.$vv['dlt_id'];
					$var9='pfl_fanli9'.$vv['dlt_id'];
					$var10='pfl_fanli10'.$vv['dlt_id'];

					$var44='pfl_maiduan'.$vv['dlt_id'];
					
					$pfl_fanli1 = (isset($_POST[$var1]) && is_not_null($_POST[$var1])) ? trim($_POST[$var1]):0;
					$pfl_fanli2 = (isset($_POST[$var2]) && is_not_null($_POST[$var2])) ? trim($_POST[$var2]):0;
					$pfl_fanli3 = (isset($_POST[$var3]) && is_not_null($_POST[$var3])) ? trim($_POST[$var3]):0;
					$pfl_fanli4 = (isset($_POST[$var4]) && is_not_null($_POST[$var4])) ? trim($_POST[$var4]):0;
					$pfl_fanli5 = (isset($_POST[$var5]) && is_not_null($_POST[$var5])) ? trim($_POST[$var5]):0;
					$pfl_fanli6 = (isset($_POST[$var6]) && is_not_null($_POST[$var6])) ? trim($_POST[$var6]):0;
					$pfl_fanli7 = (isset($_POST[$var7]) && is_not_null($_POST[$var7])) ? trim($_POST[$var7]):0;
					$pfl_fanli8 = (isset($_POST[$var8]) && is_not_null($_POST[$var8])) ? trim($_POST[$var8]):0;
					$pfl_fanli9 = (isset($_POST[$var9]) && is_not_null($_POST[$var9])) ? trim($_POST[$var9]):0;
					$pfl_fanli10 = (isset($_POST[$var10]) && is_not_null($_POST[$var10])) ? trim($_POST[$var10]):0;
					
					$pfl_maiduan = (isset($_POST[$var44]) && is_not_null($_POST[$var44])) ? trim($_POST[$var44]):0;
					
					

					
					if($pfl_fanli1!=0){
						if(!preg_match("/^[0-9.]{1,10}$/",$pfl_fanli1)){
							$this->error('输入必须为数字','',1);
						}
					}
					if($pfl_fanli2!=0){
						if(!preg_match("/^[0-9.]{1,10}$/",$pfl_fanli2)){
							$this->error('输入必须为数字','',1);
						}
					}
					if($pfl_fanli3!=0){
						if(!preg_match("/^[0-9.]{1,10}$/",$pfl_fanli3)){
							$this->error('输入必须为数字','',1);
						}
					}
					
					if($pfl_fanli4!=0){
						if(!preg_match("/^[0-9.]{1,10}$/",$pfl_fanli4)){
							$this->error('输入必须为数字','',1);
						}
					}
					if($pfl_fanli5!=0){
						if(!preg_match("/^[0-9.]{1,10}$/",$pfl_fanli5)){
							$this->error('输入必须为数字','',1);
						}
					}
					if($pfl_fanli6!=0){
						if(!preg_match("/^[0-9.]{1,10}$/",$pfl_fanli6)){
							$this->error('输入必须为数字','',1);
						}
					}
					if($pfl_fanli7!=0){
						if(!preg_match("/^[0-9.]{1,10}$/",$pfl_fanli7)){
							$this->error('输入必须为数字','',1);
						}
					}
					if($pfl_fanli8!=0){
						if(!preg_match("/^[0-9.]{1,10}$/",$pfl_fanli8)){
							$this->error('输入必须为数字','',1);
						}
					}
					if($pfl_fanli9!=0){
						if(!preg_match("/^[0-9.]{1,10}$/",$pfl_fanli9)){
							$this->error('输入必须为数字','',1);
						}
					}
					if($pfl_fanli10!=0){
						if(!preg_match("/^[0-9.]{1,10}$/",$pfl_fanli10)){
							$this->error('输入必须为数字','',1);
						}
					}
					
					if($pfl_maiduan!=0){
						if(!preg_match("/^[0-9.]{1,10}$/",$pfl_maiduan)){
							$this->error('输入必须为数字','',1);
						}
					}
				
					
					$map2=array();
					$data2=array();
					$map2['pfl_unitcode'] = session('unitcode');
					$map2['pfl_proid'] = $data['pro_id'];
					$map2['pfl_dltype'] = $vv['dlt_id'];
					$data2=$Profanli->where($map2)->find();
					if($data2){
						$data4=array();
						$data4['pfl_fanli1']=$pfl_fanli1;
						$data4['pfl_fanli2']=$pfl_fanli2;
						$data4['pfl_fanli3']=$pfl_fanli3;
						$data4['pfl_fanli4']=$pfl_fanli4;
						$data4['pfl_fanli5']=$pfl_fanli5;
						$data4['pfl_fanli6']=$pfl_fanli6;
						$data4['pfl_fanli7']=$pfl_fanli7;
						$data4['pfl_fanli8']=$pfl_fanli8;
						$data4['pfl_fanli9']=$pfl_fanli9;
						$data4['pfl_fanli10']=$pfl_fanli10;
						$data4['pfl_maiduan']=$pfl_maiduan;
						$Profanli->where($map2)->data($data4)->save();
						
						$list3[$kk]['pfl_fanli1']=$pfl_fanli1;
						$list3[$kk]['pfl_fanli2']=$pfl_fanli2;
						$list3[$kk]['pfl_fanli3']=$pfl_fanli3;
						$list3[$kk]['pfl_fanli4']=$pfl_fanli4;
						$list3[$kk]['pfl_fanli5']=$pfl_fanli5;
						$list3[$kk]['pfl_fanli6']=$pfl_fanli6;
						$list3[$kk]['pfl_fanli7']=$pfl_fanli7;
						$list3[$kk]['pfl_fanli8']=$pfl_fanli8;
						$list3[$kk]['pfl_fanli9']=$pfl_fanli9;
						$list3[$kk]['pfl_fanli10']=$pfl_fanli10;
						$list3[$kk]['pfl_maiduan']=$pfl_maiduan;
					}else{
						if($pfl_fanli1>0 || $pfl_fanli2>0 || $pfl_maiduan>0){
							$data4=array();
							$data4['pfl_unitcode']= session('unitcode');
							$data4['pfl_proid'] = $data['pro_id'];
							$data4['pfl_dltype'] = $vv['dlt_id'];
							$data4['pfl_fanli1']=$pfl_fanli1;
							$data4['pfl_fanli2']=$pfl_fanli2;
							$data4['pfl_fanli3']=$pfl_fanli3;
							$data4['pfl_fanli4']=$pfl_fanli4;
							$data4['pfl_fanli5']=$pfl_fanli5;
							$data4['pfl_fanli6']=$pfl_fanli6;
							$data4['pfl_fanli7']=$pfl_fanli7;
							$data4['pfl_fanli8']=$pfl_fanli8;
							$data4['pfl_fanli9']=$pfl_fanli9;
							$data4['pfl_fanli10']=$pfl_fanli10;
							$data4['pfl_maiduan']=$pfl_maiduan;
							
							$rs=$Profanli->create($data4,1);
							if($rs){
							   $Profanli->add(); 
							}
							
							$list3[$kk]['pfl_fanli1']=$pfl_fanli1;
							$list3[$kk]['pfl_fanli2']=$pfl_fanli2;
							$list3[$kk]['pfl_fanli3']=$pfl_fanli3;
							$list3[$kk]['pfl_fanli4']=$pfl_fanli4;
							$list3[$kk]['pfl_fanli5']=$pfl_fanli5;
							$list3[$kk]['pfl_fanli6']=$pfl_fanli6;
							$list3[$kk]['pfl_fanli7']=$pfl_fanli7;
							$list3[$kk]['pfl_fanli8']=$pfl_fanli8;
							$list3[$kk]['pfl_fanli9']=$pfl_fanli9;
							$list3[$kk]['pfl_fanli10']=$pfl_fanli10;
							$list3[$kk]['pfl_maiduan']=$pfl_maiduan;
						}else{
							$list3[$kk]['pfl_fanli1']=0;
							$list3[$kk]['pfl_fanli2']=0;
						}
					}
				    $list3[$kk]['pro_id']=$data['pro_id'];
				}
				
				//记录日志 begin
				$log_arr=array(
							'log_qyid'=>session('qyid'),
							'log_user'=>session('qyuser'),
							'log_qycode'=>session('unitcode'),
							'log_action'=>'产品返利设置',
							'log_type'=>1, //0-系统 1-企业 2-经销商 3-消费者
							'log_addtime'=>time(),
							'log_ip'=>real_ip(),
							'log_link'=>__SELF__,
							'log_remark'=>json_encode($list3)
							);
				save_log($log_arr);
				//记录日志 end
				
				$this->success('修改成功',U('Mp/Product/proprice'),'',2);
				
			}else{
				$this->error('没有该记录','',2);
			}
        }else{  
            $this->error('没有该记录','',2);
        }
    }
    //产品价格体系 详细
    public function propricedetail(){
        $this->check_qypurview('20002',1);

        $map['pro_id']=intval(I('get.pro_id',0));
        $map['pro_unitcode']=session('unitcode');
        $Product= M('Product');
        $data=$Product->where($map)->find();
		
        $Dltype = M('Dltype');
        $Profanli = M('Profanli');
		$Proprice = M('Proprice');
		$map3=array();
        $map3['dlt_unitcode']=session('unitcode');
        $list3 = $Dltype->where($map3)->order('dlt_level ASC,dlt_id ASC')->select();
		
        if($data){
		    foreach($list3 as $kk=>$vv){
				$map2=array();
				$data2=array();
				$map2['pfl_unitcode'] = session('unitcode');
				$map2['pfl_proid'] = $data['pro_id'];
				$map2['pfl_dltype'] = $vv['dlt_id'];
				$data2=$Profanli->where($map2)->find();
				if($data2){
					if(session('unitcode')=='2910'){//宝鼎红微商
						$list3[$kk]['pfl_fanli1_str']=$data2['pfl_fanli1'].'元';
					}else{
						if($data2['pfl_fanli1']>0 && $data2['pfl_fanli1']<1){
							$list3[$kk]['pfl_fanli1_str']=($data2['pfl_fanli1']*100).'%';
						}else if($data2['pfl_fanli1']>=1){
							$list3[$kk]['pfl_fanli1_str']=$data2['pfl_fanli1'].'元';
						}else{
							$list3[$kk]['pfl_fanli1_str']=$data2['pfl_fanli1'].'元';
						}
					}
					
					if(session('unitcode')=='2910'){//宝鼎红微商
					    $list3[$kk]['pfl_fanli2_str']=$data2['pfl_fanli2'].'元';
					}else{
						if($data2['pfl_fanli2']>0 && $data2['pfl_fanli2']<1){
							$list3[$kk]['pfl_fanli2_str']=($data2['pfl_fanli2']*100).'%';
						}else if($data2['pfl_fanli2']>=1){
							$list3[$kk]['pfl_fanli2_str']=$data2['pfl_fanli2'].'元';
						}else{
							$list3[$kk]['pfl_fanli2_str']=$data2['pfl_fanli2'].'元';
						}
					}
					
					if(session('unitcode')=='2910'){//宝鼎红微商
					    $list3[$kk]['pfl_fanli3_str']=$data2['pfl_fanli3'].'元';
					}else{
						if($data2['pfl_fanli3']>0 && $data2['pfl_fanli3']<1){
							$list3[$kk]['pfl_fanli3_str']=($data2['pfl_fanli3']*100).'%';
						}else if($data2['pfl_fanli3']>=1){
							$list3[$kk]['pfl_fanli3_str']=$data2['pfl_fanli3'].'元';
						}else{
							$list3[$kk]['pfl_fanli3_str']=$data2['pfl_fanli3'].'元';
						}
					}
					
					if($data2['pfl_fanli4']>0 && $data2['pfl_fanli4']<1){
						$list3[$kk]['pfl_fanli4_str']=($data2['pfl_fanli4']*100).'%';
					}else if($data2['pfl_fanli4']>=1){
						$list3[$kk]['pfl_fanli4_str']=$data2['pfl_fanli4'].'元';
					}else{
						$list3[$kk]['pfl_fanli4_str']=$data2['pfl_fanli4'].'元';
					}
					
					if($data2['pfl_fanli5']>0 && $data2['pfl_fanli5']<1){
						$list3[$kk]['pfl_fanli5_str']=($data2['pfl_fanli5']*100).'%';
					}else if($data2['pfl_fanli5']>=1){
						$list3[$kk]['pfl_fanli5_str']=$data2['pfl_fanli5'].'元';
					}else{
						$list3[$kk]['pfl_fanli5_str']=$data2['pfl_fanli5'].'元';
					}
					
					if($data2['pfl_fanli6']>0 && $data2['pfl_fanli6']<1){
						$list3[$kk]['pfl_fanli6_str']=($data2['pfl_fanli6']*100).'%';
					}else if($data2['pfl_fanli6']>=1){
						$list3[$kk]['pfl_fanli6_str']=$data2['pfl_fanli6'].'元';
					}else{
						$list3[$kk]['pfl_fanli6_str']=$data2['pfl_fanli6'].'元';
					}
					
					if($data2['pfl_fanli7']>0 && $data2['pfl_fanli7']<1){
						$list3[$kk]['pfl_fanli7_str']=($data2['pfl_fanli7']*100).'%';
					}else if($data2['pfl_fanli7']>=1){
						$list3[$kk]['pfl_fanli7_str']=$data2['pfl_fanli7'].'元';
					}else{
						$list3[$kk]['pfl_fanli7_str']=$data2['pfl_fanli7'].'元';
					}
					
					if($data2['pfl_fanli8']>0 && $data2['pfl_fanli8']<1){
						$list3[$kk]['pfl_fanli8_str']=($data2['pfl_fanli8']*100).'%';
					}else if($data2['pfl_fanli8']>=1){
						$list3[$kk]['pfl_fanli8_str']=$data2['pfl_fanli8'].'元';
					}else{
						$list3[$kk]['pfl_fanli8_str']=$data2['pfl_fanli8'].'元';
					}
					
					if($data2['pfl_fanli9']>0 && $data2['pfl_fanli9']<1){
						$list3[$kk]['pfl_fanli9_str']=($data2['pfl_fanli9']*100).'%';
					}else if($data2['pfl_fanli9']>=1){
						$list3[$kk]['pfl_fanli9_str']=$data2['pfl_fanli9'].'元';
					}else{
						$list3[$kk]['pfl_fanli9_str']=$data2['pfl_fanli9'].'元';
					}
					
					if($data2['pfl_fanli10']>0 && $data2['pfl_fanli10']<1){
						$list3[$kk]['pfl_fanli10_str']=($data2['pfl_fanli10']*100).'%';
					}else if($data2['pfl_fanli10']>=1){
						$list3[$kk]['pfl_fanli10_str']=$data2['pfl_fanli10'].'元';
					}else{
						$list3[$kk]['pfl_fanli10_str']=$data2['pfl_fanli10'].'元';
					}
					
					
					
					
					if($data2['pfl_maiduan']>0 && $data2['pfl_maiduan']<1){
						$list3[$kk]['pfl_maiduan_str']=($data2['pfl_maiduan']*100).'%';
					}else if($data2['pfl_maiduan']>=1){
						$list3[$kk]['pfl_maiduan_str']=$data2['pfl_maiduan'].'元';
					}else{
						$list3[$kk]['pfl_maiduan_str']=$data2['pfl_maiduan'].'元';
					}
					
					
					
					$list3[$kk]['pfl_fanli1']=$data2['pfl_fanli1'];
					$list3[$kk]['pfl_fanli2']=$data2['pfl_fanli2'];
					$list3[$kk]['pfl_fanli3']=$data2['pfl_fanli3'];
					$list3[$kk]['pfl_fanli4']=$data2['pfl_fanli4'];
					$list3[$kk]['pfl_fanli5']=$data2['pfl_fanli5'];
					$list3[$kk]['pfl_fanli6']=$data2['pfl_fanli6'];
					$list3[$kk]['pfl_fanli7']=$data2['pfl_fanli7'];
					$list3[$kk]['pfl_fanli8']=$data2['pfl_fanli8'];
					$list3[$kk]['pfl_fanli9']=$data2['pfl_fanli9'];
					$list3[$kk]['pfl_fanli10']=$data2['pfl_fanli10'];
					
					$list3[$kk]['pfl_maiduan']=$data2['pfl_maiduan'];
					
				}else{
					$list3[$kk]['pfl_fanli1']=0;
					$list3[$kk]['pfl_fanli2']=0;
					$list3[$kk]['pfl_fanli3']=0;
					$list3[$kk]['pfl_fanli4']=0;
					$list3[$kk]['pfl_fanli5']=0;
					$list3[$kk]['pfl_fanli6']=0;
					$list3[$kk]['pfl_fanli7']=0;
					$list3[$kk]['pfl_fanli8']=0;
					$list3[$kk]['pfl_fanli9']=0;
					$list3[$kk]['pfl_fanli10']=0;
					$list3[$kk]['pfl_maiduan']=0;
				}
				
				$map2=array();
				$data2=array();
				$map2['pri_unitcode'] = session('unitcode');
				$map2['pri_proid'] = $data['pro_id'];
				$map2['pri_dltype'] = $vv['dlt_id'];
				$data2=$Proprice->where($map2)->find();
				if($data2){
					$list3[$kk]['priprice']=$data2['pri_price'];
					$list3[$kk]['pri_minimum']=$data2['pri_minimum'];
				}else{
					$list3[$kk]['priprice']=0;
					$list3[$kk]['pri_minimum']=0;
				}
				
				
			}
        }else{
            $this->error('没有该记录');
        }


        $this->assign('typelist', $list3);
        $this->assign('proinfo', $data);
        $this->assign('curr', 'pro_price');

        $this->display('propricedetail');
    }
	
}