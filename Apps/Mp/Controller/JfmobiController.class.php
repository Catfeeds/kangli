<?php
namespace Mp\Controller;
use Think\Controller;

class JfmobiController extends CommController {

    public function index(){
        exit;
    }
    //积分手机端基本设置
    public function basic(){
        $this->check_qypurview('70001',1);

        $action=I('get.action','');
        $map['bas_unitcode']=session('unitcode');
        $Jfmobasic= M('Jfmobasic');
        $data=$Jfmobasic->where($map)->find();
        
        if($data){

        }else{
            $data['bas_unitcode']=session('unitcode');
            $rs=$Jfmobasic->create($data,1);
            if($rs){
               $result = $Jfmobasic->add(); 
            }
            $this->redirect('Mp/Jfmobi/basic','' , 0, '');
        }

        $this->assign('basicinfo', $data);
        $this->assign('curr', 'jfmo_basic');
        $ttamp=time();
        $sture=MD5(session('unitcode').$ttamp);
        $this->assign('ttamp', URLEncode($ttamp));
        $this->assign('sture', URLEncode($sture));
        $this->assign('sid', URLEncode(\Org\Util\Funcrypt::authcode(session_id(),'ENCODE',C('WWW_AUTHKEY'),0)));
        $this->assign('uid', URLEncode(\Org\Util\Funcrypt::authcode(session('unitcode'),'ENCODE',C('WWW_AUTHKEY'),0)));
        
        
        if($action=='profile'){
            $this->display('profile');    //公司简介
        }elseif($action=='contact'){
            $this->display('contact');    //联系方式
        }elseif($action=='agreement'){
            $this->display('agreement');  //注册协议
        }elseif($action=='rule'){
            $this->display('rule');       //积分规则
        }elseif($action=='help'){        
            $this->display('help');       //帮助中心
        }elseif($action=='buyer'){        
            $this->display('buyer');       //买家秀
        }elseif($action=='zhengce'){        
            $this->display('zhengce');     //政策
        }else{
            $this->display('basic');      //基本设置
        }
    }

    //积分手机端基本设置保存
    public function edit_save(){
        $this->check_qypurview('70001',1);

    	if (!IS_POST) {
             header('HTTP/1.0 404 Not Found');
             echo'error:404';
             exit;
        }
        $bas_id=intval(I('post.bas_id',0));
        $action=I('get.action','');
        
        if($bas_id<=0){
             $this->error('修改失败','',1);
        }

        if($action=='basic'){
            $map['bas_unitcode']=session('unitcode');
            $map['bas_id']=$bas_id;

            $data['bas_sitename']=I('post.bas_sitename','');
            $data['bas_company']=I('post.bas_company','');
            $data['bas_address']=I('post.bas_address','');
            $data['bas_hotline']=I('post.bas_hotline','');
            $data['bas_tel']=I('post.bas_tel','');
            $data['bas_fax']=I('post.bas_fax','');
            $data['bas_website']=I('post.bas_website','');
            $data['bas_weixin']=I('post.bas_weixin','');
            $data['bas_weibo']=I('post.bas_weibo','');
            

            $Jfmobasic= M('Jfmobasic');
            $rs=$Jfmobasic->where($map)->save($data);

            if($rs){
                //记录日志 begin
                $log_arr=array(
                            'log_qyid'=>session('qyid'),
                            'log_user'=>session('qyuser'),
                            'log_qycode'=>session('unitcode'),
                            'log_action'=>'手机端基本设置',
							'log_type'=>1, //0-系统 1-企业 2-经销商 3-消费者
                            'log_addtime'=>time(),
                            'log_ip'=>real_ip(),
                            'log_link'=>__SELF__,
                            'log_remark'=>json_encode($data)
                            );
                save_log($log_arr);
                //记录日志 end
                $this->success('修改成功','',1);
            }else{
               $this->error('修改失败','',1);
            }
        }elseif($action=='profile'){
            $map['bas_unitcode']=session('unitcode');
            $map['bas_id']=$bas_id;
            $data['bas_profile'] = (isset($_POST['econtent']) && is_not_null($_POST['econtent'])) ? $_POST['econtent']:'';

            $Jfmobasic= M('Jfmobasic');
            $rs=$Jfmobasic->where($map)->save($data);
            $this->success('修改成功','',1);
        }elseif($action=='contact'){
            $map['bas_unitcode']=session('unitcode');
            $map['bas_id']=$bas_id;
            
            $data['bas_contact'] = (isset($_POST['econtent']) && is_not_null($_POST['econtent'])) ? $_POST['econtent']:'';
            $Jfmobasic= M('Jfmobasic');
            $rs=$Jfmobasic->where($map)->save($data);
            $this->success('修改成功','',1);
        }elseif($action=='agreement'){
            $map['bas_unitcode']=session('unitcode');
            $map['bas_id']=$bas_id;
            
            $data['bas_agreement'] = (isset($_POST['econtent']) && is_not_null($_POST['econtent'])) ? $_POST['econtent']:'';
            $Jfmobasic= M('Jfmobasic');
            $rs=$Jfmobasic->where($map)->save($data);
            $this->success('修改成功','',1);
        }elseif($action=='rule'){
            $map['bas_unitcode']=session('unitcode');
            $map['bas_id']=$bas_id;
            
            $data['bas_rule'] = (isset($_POST['econtent']) && is_not_null($_POST['econtent'])) ? $_POST['econtent']:'';
            $Jfmobasic= M('Jfmobasic');
            $rs=$Jfmobasic->where($map)->save($data);
            $this->success('修改成功','',1);
        }elseif($action=='help'){
            $map['bas_unitcode']=session('unitcode');
            $map['bas_id']=$bas_id;
            
            $data['bas_help'] = (isset($_POST['econtent']) && is_not_null($_POST['econtent'])) ? $_POST['econtent']:'';
            $Jfmobasic= M('Jfmobasic');
            $rs=$Jfmobasic->where($map)->save($data);
            $this->success('修改成功','',1);
        }elseif($action=='buyer'){
            $map['bas_unitcode']=session('unitcode');
            $map['bas_id']=$bas_id;
            
            $data['bas_buyer'] = (isset($_POST['econtent']) && is_not_null($_POST['econtent'])) ? $_POST['econtent']:'';
            $Jfmobasic= M('Jfmobasic');
            $rs=$Jfmobasic->where($map)->save($data);
            $this->success('修改成功','',1);
		}elseif($action=='zhengce'){
            $map['bas_unitcode']=session('unitcode');
            $map['bas_id']=$bas_id;
            
            $data['bas_ppzc'] = (isset($_POST['econtent']) && is_not_null($_POST['econtent'])) ? $_POST['econtent']:'';
            $Jfmobasic= M('Jfmobasic');
            $rs=$Jfmobasic->where($map)->save($data);
            $this->success('修改成功','',1);
        }
    }

    //手机端logo设置
    public function setlogo(){
        $this->check_qypurview('70017',1);

        $action=I('post.action','');
		
		$map=array();
        $map['bas_unitcode']=session('unitcode');
        $Jfmobasic= M('Jfmobasic');
        $data=$Jfmobasic->where($map)->find();
        
        if($data){
            $imgpath = BASE_PATH.'/Public/uploads/mobi/';
			
			if($action=='save'){
				$map['bas_id']=intval(I('post.bas_id',0));
				$logo_txt='';
				$bas_logopic='';
				//上传文件 begin
				if($_FILES['pic_file']['name']==''){
					$bas_logopic='';
				}else{
					$imgpath_b=$imgpath.session('unitcode').'/';
					if (!file_exists($imgpath_b)) {
						mkdir($imgpath_b);
					}

					
					$upload = new \Think\Upload();
					$upload->maxSize = 500*1024 ;
					$upload->exts = array('jpg', 'gif', 'png', 'jpeg');
					$upload->rootPath   = './Public/uploads/mobi/';
					$upload->subName  = session('unitcode');
					$upload->saveName ='logo'.time();
					
					$info = $upload->uploadOne($_FILES['pic_file']);

					if(!$info) {
						$this->error($upload->getError());
					}else{
						$bas_logopic=$info['savepath'].$info['savename'];
						@unlink($imgpath.$data['bas_logopic']); 
					}
					@unlink($_FILES['pic_file']['tmp_name']); 
				}
				//上传文件 end
				
				if($bas_logopic==''){
					$logo_txt=I('post.logo_txt','');
				}
				$data2=array();
				$data2['bas_logopic']='';
				if($bas_logopic!=''){
					$data2['bas_logopic']=$bas_logopic;
				}
				
                if($logo_txt!=''){
					@unlink($imgpath.$data['bas_logopic']); 
					$data2['bas_logopic']=$logo_txt;
				}
				
				$rs=$Jfmobasic->where($map)->data($data2)->save();
				
				if($rs){
					$this->success('提交成功',U('Mp/Jfmobi/setlogo'),1);
					exit;
				}else{
					$this->error('提交失败','',1);
					exit;
				}
			}else{
				if(is_not_null($data['bas_logopic']) && file_exists($imgpath.$data['bas_logopic'])){
					$data['bas_logopice_str']='<a href="'.__ROOT__.'/Public/uploads/mobi/'.$data['bas_logopic'].'" target="_blank" ><img src="'.__ROOT__.'/Public/uploads/mobi/'.$data['bas_logopic'].'"  border="0" style="vertical-align:middle" ></a>';
				    $data['logo_txt']='';
				}else{
					$data['bas_logopice_str']='';
					if(strpos($data['bas_logopic'], 'logo')===false && strpos($data['bas_logopic'], '.')===false ){
						$data['logo_txt']=$data['bas_logopic'];
					}else{
						$data['logo_txt']='';
					}
				}
			}
        }else{
            $data['bas_unitcode']=session('unitcode');
            $rs=$Jfmobasic->create($data,1);
            if($rs){
               $result = $Jfmobasic->add(); 
            }
            $this->redirect('Mp/Jfmobi/setlogo','' , 0, '');
        }

        $this->assign('basicinfo', $data);
        $this->assign('curr', 'jfmo_logo');
  
       $this->display('setlogo');
    }
	
    //底部图片设置
    public function setfoot(){
        $this->check_qypurview('70019',1);

        $action=I('post.action','');
		
		$map=array();
        $map['bas_unitcode']=session('unitcode');
        $Jfmobasic= M('Jfmobasic');
        $data=$Jfmobasic->where($map)->find();
        
        if($data){
            $imgpath = BASE_PATH.'/Public/uploads/mobi/';
			
			if($action=='save'){
				$map['bas_id']=intval(I('post.bas_id',0));
				$bas_footpic='';
				//上传文件 begin
				if($_FILES['pic_file']['name']==''){
					$bas_footpic='';
				}else{
					$imgpath_b=$imgpath.session('unitcode').'/';
					if (!file_exists($imgpath_b)) {
						mkdir($imgpath_b);
					}

					
					$upload = new \Think\Upload();
					$upload->maxSize = 500*1024 ;
					$upload->exts = array('jpg', 'gif', 'png', 'jpeg');
					$upload->rootPath   = './Public/uploads/mobi/';
					$upload->subName  = session('unitcode');
					$upload->saveName ='foot'.time();
					
					$info = $upload->uploadOne($_FILES['pic_file']);

					if(!$info) {
						$this->error($upload->getError());
					}else{
						$bas_footpic=$info['savepath'].$info['savename'];
						@unlink($imgpath.$data['bas_footpic']); 
					}
					@unlink($_FILES['pic_file']['tmp_name']); 
				}
				//上传文件 end

				$data2=array();
				if($bas_footpic==''){
					@unlink($imgpath.$data['bas_footpic']); 
					$data2['bas_footpic']=$bas_footpic;
				}else{
					$data2['bas_footpic']=$bas_footpic;
				}
				
				$rs=$Jfmobasic->where($map)->data($data2)->save();
				
				if($rs){
					$this->success('提交成功',U('Mp/Jfmobi/setfoot'),1);
					exit;
				}else{
					$this->error('提交失败','',1);
					exit;
				}
			}else{
				if(is_not_null($data['bas_footpic']) && file_exists($imgpath.$data['bas_footpic'])){
					$data['bas_footpic_str']='<a href="'.__ROOT__.'/Public/uploads/mobi/'.$data['bas_footpic'].'" target="_blank" ><img src="'.__ROOT__.'/Public/uploads/mobi/'.$data['bas_footpic'].'"  border="0" style="vertical-align:middle;width:10%" ></a>';

				}else{
					$data['bas_footpic_str']='';
				}
			}
        }else{
            $data['bas_unitcode']=session('unitcode');
            $rs=$Jfmobasic->create($data,1);
            if($rs){
               $result = $Jfmobasic->add(); 
            }
            $this->redirect('Mp/Jfmobi/setfoot','' , 0, '');
        }

        $this->assign('basicinfo', $data);
        $this->assign('curr', 'jfmo_foot');
  
       $this->display('setfoot');
    }
	
	
    //海报设置
    public function haibaolist(){
        $this->check_qypurview('70018',1);

        $Adinfo = M('Adinfo');
        $map['ad_unitcode']=session('unitcode');
        $count = $Adinfo->where($map)->count();
        $Page = new \Think\Page($count, C('PAGE_SIZE'));
        $show = $Page->show();
        $list = $Adinfo->where($map)->order('ad_addtime DESC')->limit(($Page->firstRow . ',') . $Page->listRows)->select();

        $imgpath = BASE_PATH.'/Public/uploads/mobi/';
        //ad_group 1-首页滚图海报
        foreach($list as $k=>$v){ 
            if(is_not_null($v['ad_pic']) && file_exists($imgpath.$v['ad_pic'])){
                $arr=getimagesize($imgpath.$v['ad_pic']);
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
                    $list[$k]['ad_pic_str']='<a href="'.__ROOT__.'/Public/uploads/mobi/'.$v['ad_pic'].'" target="_blank" ><img src="'.__ROOT__.'/Public/uploads/mobi/'.$v['ad_pic'].'" width="'.$ww.'"  height="'.$hh.'"  border="0"></a>';
                }
                else{
                    $list[$k]['ad_pic_str']='-';
                }
            }else{
                $list[$k]['ad_pic_str']='-';
            }
        }
        
        $this->assign('list', $list);
        $this->assign('page', $show);
        $this->assign('curr', 'jfmo_haibao');
        $this->display('haibaolist');
    }

    //添加海报
    public function addhaibao(){
        $this->check_qypurview('70018',1);
        $data['ad_id']=0;
        $this->assign('curr', 'jfmo_haibao');
        $this->assign('atitle', '添加海报');
        $this->assign('adinfo', $data);
        $this->display('addhaibao');
    }
    
    //保存海报
    public function haibao_save(){
        $this->check_qypurview('70018',1);

        if (!IS_POST) {
             header('HTTP/1.0 404 Not Found');
             echo'error:404';
             exit;
        }

        $imgpath = BASE_PATH.'/Public/uploads/mobi/';
 
		//添加保存
		$Adinfo= M('Adinfo');

		$data['ad_unitcode']=session('unitcode');
		$data['ad_name']=I('post.ad_name','');
		$data['ad_url']=I('post.ad_url','');
		$data['ad_group']=1;
		$data['ad_addtime']=time();
		$data['ad_des']='';
		
		if($data['ad_name']==''){
			$this->error('请填写图片说明','',1);
		}
		
		//上传文件 begin
		if($_FILES['pic_file']['name']==''){
			$this->error('请上传图片','',1);
		}else{
			$imgpath_b=$imgpath.session('unitcode').'/';
			
			if (!file_exists($imgpath_b)) {
				mkdir($imgpath_b);
			}

			$saveName=time().mt_rand(1,9);
			
			$upload = new \Think\Upload();
			$upload->maxSize = 500*1024 ;
			$upload->exts = array('jpg', 'gif', 'png', 'jpeg');
			$upload->rootPath   = './Public/uploads/mobi/';
			$upload->subName  = session('unitcode');
			$upload->saveName =$saveName ;
			
			$info = $upload->uploadOne($_FILES['pic_file']);

			if(!$info) {
				$this->error($upload->getError());
			}else{
				$ad_pic=$info['savepath'].$info['savename'];
			}
			@unlink($_FILES['pic_file']['tmp_name']); 
		}
		//上传文件 end
		$data['ad_pic']=$ad_pic;



		$rs=$Adinfo->create($data,1);
		if($rs){
		   $result = $Adinfo->add(); 
		   if($result){
			   $this->success('添加成功',U('Mp/Jfmobi/haibaolist'),1);
		   }else{
			   $this->error('添加失败','',1);
		   }
		}else{
			$this->error('添加失败','',1);
		}
    }
   
   //删除海报
    public function haibaodel(){
        $this->check_qypurview('70018',1);

        $map['ad_id']=intval(I('get.ad_id',0));
        $map['ad_unitcode']=session('unitcode');
        $Adinfo= M('Adinfo');
        $data=$Adinfo->where($map)->find();

        if($data){
            @unlink('./Public/uploads/mobi/'.$data['ad_pic']); 
            $Adinfo->where($map)->delete(); 
            $this->success('删除成功','',1);
        }else{
            $this->error('没有该记录','',1);
        }     
    }
   
   
    //=====================================================================================
    //积分手机端图片管理
    public function piclist(){
        $this->check_qypurview('70007',1);

        $Jfmopics = M('Jfmopics');
        $map['pics_unitcode']=session('unitcode');
        $count = $Jfmopics->where($map)->count();
        $Page = new \Think\Page($count, C('PAGE_SIZE'));
        $show = $Page->show();
        $list = $Jfmopics->where($map)->order('pics_addtime DESC')->limit(($Page->firstRow . ',') . $Page->listRows)->select();

        $imgpath = BASE_PATH.'/Public/uploads/mobi/';
       
        foreach($list as $k=>$v){ 
            if(is_not_null($v['pics_name_s']) && file_exists($imgpath.$v['pics_name_s'])){
                $arr=getimagesize($imgpath.$v['pics_name_s']);
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
                    $list[$k]['pics_name_str']='<a href="'.__ROOT__.'/Public/uploads/mobi/'.$v['pics_name'].'" target="_blank" ><img src="'.__ROOT__.'/Public/uploads/mobi/'.$v['pics_name_s'].'" width="'.$ww.'"  height="'.$hh.'"  border="0"></a>';
                }
                else{
                    $list[$k]['pics_name_str']='-';
                }
            }else{
                $list[$k]['pics_name_str']='-';
            }
            
            $list[$k]['pics_name2']=end(explode('/',$v['pics_name']));

        }
        
        $this->assign('web_host',I('server.HTTP_HOST'));
        $this->assign('list', $list);
        $this->assign('page', $show);
        $this->assign('curr', 'jfmo_pics');
        $this->display('piclist');
    }

    //添加图片
    public function picadd(){
        $this->check_qypurview('70007',1);
        $data['pics_id']=0;
        $this->assign('curr', 'jfmo_pics');
        $this->assign('atitle', '添加图片');
        $this->assign('jfmopicsinfo', $data);
        $this->display('picadd');
    }
    
	//修改图片
    public function picedit(){
        $this->check_qypurview('70007',1);

        $map['pics_id']=intval(I('get.pics_id',0));
        $map['pics_unitcode']=session('unitcode');
        $Jfmopics= M('Jfmopics');
        $data=$Jfmopics->where($map)->find();
        $imgpath = BASE_PATH.'/Public/uploads/mobi/';
        if($data){
            if(is_not_null($data['pics_name_s']) && file_exists($imgpath.$data['pics_name_s'])){
                $arr=getimagesize($imgpath.$data['pics_name_s']);
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
                    $data['pics_name_str']='<a href="'.__ROOT__.'/Public/uploads/mobi/'.$data['pics_name'].'" target="_blank" ><img src="'.__ROOT__.'/Public/uploads/mobi/'.$data['pics_name_s'].'" width="'.$ww.'"  height="'.$hh.'"  border="0" style="vertical-align:middle" ></a>';
                }
                else{
                    $data['pics_name_str']='';
                }
            }else{
                $data['pics_name_str']='';
            }
        }else{
            $this->error('没有该记录');
        }

        $this->assign('jfmopicsinfo', $data);
        $this->assign('curr', 'jfmo_pics');
        $this->assign('atitle', '修改图片');

        $this->display('picadd');
    }
    //保存图片
    public function pic_save(){
        $this->check_qypurview('70007',1);

        if (!IS_POST) {
             header('HTTP/1.0 404 Not Found');
             echo'error:404';
             exit;
        }
        $pics_id=intval(I('post.pics_id',0));
        $imgpath = BASE_PATH.'/Public/uploads/mobi/';
        
        if($pics_id>0){
            //修改保存
            $Jfmopics= M('Jfmopics');

            $data['pics_title']=I('post.pics_title','');
            $data['pics_addtime']=time();
            
            //上传文件 begin
            if($_FILES['pic_file']['name']==''){
                $pics_name='';
                $pics_name_s='';
            }else{
                $imgpath_b=$imgpath.session('unitcode').'/';
                $imgpath_s=$imgpath.session('unitcode').'s/';
                if (!file_exists($imgpath_b)) {
                    mkdir($imgpath_b);
                }
                if (!file_exists($imgpath_s)) {
                    mkdir($imgpath_s);
                }
                $saveName=time().mt_rand(1,9);
                
                $upload = new \Think\Upload();
                $upload->maxSize = 1024*1024 ;
                $upload->exts = array('jpg', 'gif', 'png', 'jpeg');
                $upload->rootPath   = './Public/uploads/mobi/';
                $upload->subName  = session('unitcode');
                $upload->saveName =$saveName ;
                
                $info = $upload->uploadOne($_FILES['pic_file']);

                if(!$info) {
                    $this->error($upload->getError());
                }else{
                    $pics_name=$info['savepath'].$info['savename'];
                    $pics_name_s=session('unitcode').'s/'.$info['savename'];
                }
                @unlink($_FILES['pic_file']['tmp_name']); 

                $image = new \Think\Image(); 
                $image->open('./Public/uploads/mobi/'.$pics_name);
                $image->thumb(200, 200)->save('./Public/uploads/mobi/'.$pics_name_s);
            }
            //上传文件 end

            $map['pics_id']=$pics_id;
            $map['pics_unitcode']=session('unitcode');
            if($pics_name!=''){
                $data2=$Jfmopics->where($map)->find();
                @unlink('./Public/uploads/mobi/'.$data2['pics_name']); 
                @unlink('./Public/uploads/mobi/'.$data2['pics_name_s']); 
                $data['pics_name']=$pics_name;
                $data['pics_name_s']=$pics_name_s;
            }

            $rs=$Jfmopics->where($map)->data($data)->save();
           
            if($rs){
                $this->success('修改成功',U('Mp/Jfmobi/piclist'),1);
            }else{
                $this->error('修改失败','',1);
            }
        }else{  
            //添加保存
            $Jfmopics= M('Jfmopics');

            $data['pics_unitcode']=session('unitcode');
            $data['pics_title']=I('post.pics_title','');
            $data['pics_group']=0;
            $data['pics_addtime']=time();
            
            
            //上传文件 begin
            if($_FILES['pic_file']['name']==''){
                $pics_name='';
                $pics_name_s='';
            }else{
                $imgpath_b=$imgpath.session('unitcode').'/';
                $imgpath_s=$imgpath.session('unitcode').'s/';
                if (!file_exists($imgpath_b)) {
                    mkdir($imgpath_b);
                }
                if (!file_exists($imgpath_s)) {
                    mkdir($imgpath_s);
                }
                $saveName=time().mt_rand(1,9);
                
                $upload = new \Think\Upload();
                $upload->maxSize = 1024*1024 ;
                $upload->exts = array('jpg', 'gif', 'png', 'jpeg');
                $upload->rootPath   = './Public/uploads/mobi/';
                $upload->subName  = session('unitcode');
                $upload->saveName =$saveName ;
                
                $info = $upload->uploadOne($_FILES['pic_file']);

                if(!$info) {
                    $this->error($upload->getError());
                }else{
                    $pics_name=$info['savepath'].$info['savename'];
                    $pics_name_s=session('unitcode').'s/'.$info['savename'];
                }
                @unlink($_FILES['pic_file']['tmp_name']); 

                $image = new \Think\Image(); 
                $image->open('./Public/uploads/mobi/'.$pics_name);
                $image->thumb(200, 200)->save('./Public/uploads/mobi/'.$pics_name_s);
            }
            //上传文件 end
            $data['pics_name']=$pics_name;
            $data['pics_name_s']=$pics_name_s;
			
			if($data['pics_name']==''){
				$this->error('请选择图片文件','',1);
			}


            $rs=$Jfmopics->create($data,1);
            if($rs){
               $result = $Jfmopics->add(); 
               if($result){
                   $this->success('添加成功',U('Mp/Jfmobi/piclist'),1);
               }else{
                   $this->error('添加失败','',1);
               }
            }else{
                $this->error('添加失败','',1);
            }
        }
    }
   
   //删除图片
    public function delete(){
        $this->check_qypurview('70007',1);

        $map['pics_id']=intval(I('get.pics_id',0));
        $map['pics_unitcode']=session('unitcode');
        $Jfmopics= M('Jfmopics');
        $data=$Jfmopics->where($map)->find();

        if($data){
            @unlink('./Public/uploads/mobi/'.$data['pics_name']); 
            @unlink('./Public/uploads/mobi/'.$data['pics_name_s']);  
            $Jfmopics->where($map)->delete(); 
            $this->success('删除成功','',1);
        }else{
            $this->error('没有该记录','',1);
        }     
    }
   
   //=========================================================================================
    //积分手机端企业动态
    public function newslist(){

		if($this->check_qypurview('70006',0) || $this->check_qypurview('70013',0) || $this->check_qypurview('70015',0)|| $this->check_qypurview('70020',0) || $this->check_qypurview('70021',0) || $this->check_qypurview('70022',0)){
			
		}else{
			$this->error('对不起,没有该权限','',1);
		}
        
		$news_type=intval(I('get.news_type',0));
		$parameter=array();
        $Jfmonews = M('Jfmonews');
        $map['news_unitcode']=session('unitcode');
		if($news_type>0){
			if($news_type==2  && session('unitcode')=='2832' ){ //明星主角微商
				$map['news_type']=array('in','2,3');
			}else{
			    $map['news_type']=$news_type;
			}
			$parameter['news_type']=$news_type;
		}
        $count = $Jfmonews->where($map)->count();
        $Page = new \Think\Page($count, C('PAGE_SIZE'),$parameter);
        $show = $Page->show();
        $list = $Jfmonews->where($map)->order('news_id DESC')->limit(($Page->firstRow . ',') . $Page->listRows)->select();

        $imgpath = BASE_PATH.'/Public/uploads/mobi/';
       
        foreach($list as $k=>$v){ 
            if(is_not_null($v['news_pic']) && file_exists($imgpath.$v['news_pic'])){
                $arr=getimagesize($imgpath.$v['news_pic']);
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
                    $list[$k]['news_pic_str']='<a href="'.__ROOT__.'/Public/uploads/mobi/'.$v['news_pic'].'" target="_blank" ><img src="'.__ROOT__.'/Public/uploads/mobi/'.$v['news_pic'].'" width="'.$ww.'"  height="'.$hh.'"  border="0"></a>';
                }else{
                    $list[$k]['news_pic_str']='-';
                }

            }else{
                $list[$k]['news_pic_str']='-';
            }
            if($v['news_type']==1){
                $list[$k]['news_type_str']='企业动态';
			}else if($v['news_type']==2){
				$list[$k]['news_type_str']='买家秀';
			}else if($v['news_type']==3){
				$list[$k]['news_type_str']='买家秀[视频]';
			}else if($v['news_type']==4){
				$list[$k]['news_type_str']='素材圈';
            }else if($v['news_type']==5){
                $list[$k]['news_type_str']='招商政策';
            }
            else if($v['news_type']==7){
                $list[$k]['news_type_str']='商家活动';
            }else{
                $list[$k]['news_type_str']='其他';
            }
			if($this->check_qypurview('70016',0) && $v['news_type']==1){
				if($v['news_isgg']==1){
				    $list[$k]['news_isgg_str']='<a href="'.U('Mp/Jfmobi/isgg?isgg=0&news_id='.$v['news_id'].'').'"  >取消公告</a>';
			    }else{
					$list[$k]['news_isgg_str']='<a href="'.U('Mp/Jfmobi/isgg?isgg=1&news_id='.$v['news_id'].'').'" >设置为公告</a>';
				}
			}else{
				$list[$k]['news_isgg_str']='';
			}

        }
		
		if($news_type==1){
			$ntitle='企业动态';
			$curr='jfmo_news';
		}else if($news_type==2){
			$ntitle='买家秀';
			$curr='jfmo_buyer';
		}else if($news_type==4){
			$ntitle='素材圈';
			$curr='jfmo_sucai';
		}else if($news_type==5){
			$ntitle='招商政策';
			$curr='jfmo_shiti';
		}else if($news_type==6){
			$ntitle='培训机构';
			$curr='jfmo_peixun';
		}else if($news_type==7){
			$ntitle='商家活动';
			$curr='jfmo_huodong';
		}else{
            $ntitle='企业动态';
            $curr='jfmo_news';
        }
		
        $this->assign('ntitle', $ntitle);
		$this->assign('news_type', $news_type);
        $this->assign('list', $list);
        $this->assign('page', $show);
        $this->assign('curr', $curr);
        $this->display('newslist');
    }
	
	//是否设置公告
    public function isgg(){
        $this->check_qypurview('70016',1);

        $map['news_id']=intval(I('get.news_id',0));
        $map['news_unitcode']=session('unitcode');
        $Jfmonews= M('Jfmonews');
        $data=$Jfmonews->where($map)->find();
        if($data){
            $isgg=intval(I('get.isgg',0));

            if($isgg==1){
                $data2['news_isgg'] = 1;
            }else{
                $data2['news_isgg'] = 0;
            }
            
            $Jfmonews->where($map)->save($data2);
            $this->success('设置成功','',1);
        }else{
            $this->error('没有该记录');
        }
    }
	
    //添加企业动态
    public function newsadd(){
        if($this->check_qypurview('70006',0) || $this->check_qypurview('70013',0) || $this->check_qypurview('70020',0) || $this->check_qypurview('70021',0) || $this->check_qypurview('70022',0)){
			
		}else{
			$this->error('对不起,没有该权限','',1);
		}
		
		
        $news_type=intval(I('get.news_type',0));
		
		if($news_type==1){
			$ntitle='企业动态';
			$curr='jfmo_news';
		}else if($news_type==2){
			$ntitle='买家秀';
			$curr='jfmo_buyer';
		}else if($news_type==4){
			$ntitle='素材资料';
			$curr='jfmo_sucai';
		}else if($news_type==5){
			$ntitle='线下实体店';
			$curr='jfmo_shiti';
		}else if($news_type==6){
			$ntitle='培训机构';
			$curr='jfmo_peixun';
		}else if($news_type==7){
            $ntitle='商家活动';
            $curr='jfmo_huodong';
        }else{
			$ntitle='企业动态';
			$curr='jfmo_news';
		}
		
		if($news_type==2  && session('unitcode')=='2832' ){ //明星主角微商
			$newstypeselect=1;
		}else{
			$newstypeselect=0;
		}
		
        $data['news_id']=0;
		$data['news_type']=$news_type;
        $ttamp=time();
        $sture=MD5(session('unitcode').$ttamp);
        $this->assign('ttamp', URLEncode($ttamp));
        $this->assign('sture', URLEncode($sture));
        $this->assign('sid', URLEncode(\Org\Util\Funcrypt::authcode(session_id(),'ENCODE',C('WWW_AUTHKEY'),0)));
        $this->assign('uid', URLEncode(\Org\Util\Funcrypt::authcode(session('unitcode'),'ENCODE',C('WWW_AUTHKEY'),0)));
        $this->assign('curr', $curr);
        $this->assign('atitle', '添 加');
		$this->assign('ntitle', $ntitle);
		$this->assign('news_type', $news_type);
		$this->assign('newstypeselect', $newstypeselect);
        $this->assign('jfmonewsinfo', $data);
        $this->display('newsadd');
    }
     //修改动态
    public function newsedit(){
        if($this->check_qypurview('70006',0) || $this->check_qypurview('70013',0) || $this->check_qypurview('70020',0) || $this->check_qypurview('70021',0) || $this->check_qypurview('70022',0)){
			
		}else{
			$this->error('对不起,没有该权限','',1);
		}
        
		$news_type=0;
        $map['news_id']=intval(I('get.news_id',0));
        $map['news_unitcode']=session('unitcode');
        $Jfmonews= M('Jfmonews');
        $data=$Jfmonews->where($map)->find();
        $imgpath = BASE_PATH.'/Public/uploads/mobi/';
        if($data){
            if(is_not_null($data['news_pic']) && file_exists($imgpath.$data['news_pic'])){
                $arr=getimagesize($imgpath.$data['news_pic']);
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
                    $data['news_pic_str']='<a href="'.__ROOT__.'/Public/uploads/mobi/'.$data['news_pic'].'" target="_blank" ><img src="'.__ROOT__.'/Public/uploads/mobi/'.$data['news_pic'].'" width="'.$ww.'"  height="'.$hh.'"  border="0" style="vertical-align:middle" ></a>';
                }else{
                    $data['news_pic_str']='';
                }
				$news_type=$data['news_type'];
            }else{
                $data['news_pic_str']='';
            }
        }else{
            $this->error('没有该记录');
        }
		
		if($news_type==1){
			$ntitle='企业动态';
			$curr='jfmo_news';
		}else if($news_type==2){
			$ntitle='买家秀';
			$curr='jfmo_buyer';
		}else if($news_type==4){
			$ntitle='素材资料';
			$curr='jfmo_sucai';
		}else if($news_type==5){
			$ntitle='线下实体店';
			$curr='jfmo_shiti';
		}else if($news_type==6){
			$ntitle='培训机构';
			$curr='jfmo_peixun';
		}else if($news_type==7){
            $ntitle='商家活动';
            $curr='jfmo_huodong';
        }else{
			$ntitle='企业动态';
			$curr='jfmo_news';
		}
		
        $ttamp=time();
        $sture=MD5(session('unitcode').$ttamp);
        $this->assign('ttamp', URLEncode($ttamp));
        $this->assign('sture', URLEncode($sture));
        $this->assign('sid', URLEncode(\Org\Util\Funcrypt::authcode(session_id(),'ENCODE',C('WWW_AUTHKEY'),0)));
        $this->assign('uid', URLEncode(\Org\Util\Funcrypt::authcode(session('unitcode'),'ENCODE',C('WWW_AUTHKEY'),0)));

        $this->assign('jfmonewsinfo', $data);
        $this->assign('curr', $curr);
		$this->assign('ntitle', $ntitle);
		$this->assign('news_type', $news_type);
		$this->assign('newstypeselect', 0);
        $this->assign('atitle', '修 改');

        $this->display('newsadd');
    }
	
    //保存动态
    public function news_save(){
        if($this->check_qypurview('70006',0) || $this->check_qypurview('70013',0) || $this->check_qypurview('70020',0) || $this->check_qypurview('70021',0) || $this->check_qypurview('70022',0)){
			
		}else{
			$this->error('对不起,没有该权限','',1);
		}

        if (!IS_POST) {
             header('HTTP/1.0 404 Not Found');
             echo'error:404';
             exit;
        }
		
		$news_type=intval(I('post.news_type',0));
        $news_id=intval(I('post.news_id',0));
        $imgpath = BASE_PATH.'/Public/uploads/mobi/';
        
        if($news_id>0){
            //修改保存
            $Jfmonews= M('Jfmonews');

            $data['news_title']=I('post.news_title','');
            $data['news_content']=(isset($_POST['econtent']) && is_not_null($_POST['econtent'])) ? $_POST['econtent']:'';
			
			if($data['news_title']==''){
				$this->error('标题不能为空','',1);
			}
            
            //上传文件 begin
            if($_FILES['pic_file']['name']==''){
                $news_pic='';
            }else{
                $imgpath_b=$imgpath.session('unitcode').'/';
                if (!file_exists($imgpath_b)) {
                    mkdir($imgpath_b);
                }

                $saveName=time().mt_rand(1,9);
                
                $upload = new \Think\Upload();
                $upload->maxSize = 500*1024 ;
                $upload->exts = array('jpg', 'gif', 'png', 'jpeg');
                $upload->rootPath   = './Public/uploads/mobi/';
                $upload->subName  = session('unitcode');
                $upload->saveName =$saveName ;
                
                $info = $upload->uploadOne($_FILES['pic_file']);

                if(!$info) {
                    $this->error($upload->getError());
                }else{
                    $news_pic=$info['savepath'].$info['savename'];
                }
                @unlink($_FILES['pic_file']['tmp_name']); 
            }
            //上传文件 end

            $map['news_id']=$news_id;
            $map['news_unitcode']=session('unitcode');
            if($news_pic!=''){
                $data2=$Jfmonews->where($map)->find();
                @unlink('./Public/uploads/mobi/'.$data2['news_pic']); 
                $data['news_pic']=$news_pic;
            }

            $rs=$Jfmonews->where($map)->data($data)->save();
           
            if($rs){
				if(($news_type==2 || $news_type==3) && session('unitcode')=='2832' ){ //明星主角微商
					$this->success('修改成功',U('Mp/Jfmobi/newslist?news_type=2'),1);
				}else{
                   $this->success('修改成功',U('Mp/Jfmobi/newslist?news_type='.$news_type.''),1);
				}
            }else{
                $this->error('修改失败','',1);
            }
        }else{  
            //添加保存
            $Jfmonews= M('Jfmonews');

            $data['news_unitcode']=session('unitcode');
            $data['news_title']=I('post.news_title','');
            $data['news_content']=(isset($_POST['econtent']) && is_not_null($_POST['econtent'])) ? $_POST['econtent']:'';
            $data['news_type']=$news_type;
            $data['news_addtime']=time();
			
			if($data['news_title']==''){
				$this->error('标题不能为空','',1);
			}
            
            
            //上传文件 begin
            if($_FILES['pic_file']['name']==''){
                $news_pic='';
            }else{
                $imgpath_b=$imgpath.session('unitcode').'/';
                if (!file_exists($imgpath_b)) {
                    mkdir($imgpath_b);
                }
                $saveName=time().mt_rand(1,9);
                
                $upload = new \Think\Upload();
                $upload->maxSize = 600*1024 ;
                $upload->exts = array('jpg', 'gif', 'png', 'jpeg');
                $upload->rootPath   = './Public/uploads/mobi/';
                $upload->subName  = session('unitcode');
                $upload->saveName =$saveName ;
                
                $info = $upload->uploadOne($_FILES['pic_file']);

                if(!$info) {
                    $this->error($upload->getError());
                }else{
                    $news_pic=$info['savepath'].$info['savename'];
                }
                @unlink($_FILES['pic_file']['tmp_name']); 
            }
            //上传文件 end
            $data['news_pic']=$news_pic;

            $rs=$Jfmonews->create($data,1);
            if($rs){
               $result = $Jfmonews->add(); 
               if($result){
				   if(($news_type==2 || $news_type==3) && session('unitcode')=='2832' ){ //明星主角微商
					   $this->success('添加成功',U('Mp/Jfmobi/newslist?news_type=2'),1);
				   }else{
                       $this->success('添加成功',U('Mp/Jfmobi/newslist?news_type='.$news_type.''),1);
				   }
               }else{
                   $this->error('添加失败','',1);
               }
            }else{
                $this->error('添加失败','',1);
            }
        }
    }
	
    //删除动态
    public function news_delete(){
        if($this->check_qypurview('70006',0) || $this->check_qypurview('70013',0) || $this->check_qypurview('70020',0) || $this->check_qypurview('70021',0) || $this->check_qypurview('70022',0)){
			
		}else{
			$this->error('对不起,没有该权限','',1);
		}

        $map['news_id']=intval(I('get.news_id',0));
        $map['news_unitcode']=session('unitcode');
        $Jfmonews= M('Jfmonews');
        $data=$Jfmonews->where($map)->find();

        if($data){
            @unlink('./Public/uploads/mobi/'.$data['news_pic']); 
            $Jfmonews->where($map)->delete(); 
            $this->success('删除成功','',1);
        }else{
            $this->error('没有该记录','',1);
        }     
    }
    //=========================================================================================
    //留言反馈
    public function feedback(){
        $this->check_qypurview('70009',1);

        $Jffeedback = M('Jffeedback');
        $map['fb_unitcode']=session('unitcode');
        $count = $Jffeedback->where($map)->count();
        $Page = new \Think\Page($count, C('PAGE_SIZE'));
        $show = $Page->show();
        $list = $Jffeedback->where($map)->order('fb_id DESC')->limit(($Page->firstRow . ',') . $Page->listRows)->select();
       
        foreach($list as $k=>$v){ 
            if($v['fb_state']==1){
                $list[$k]['fb_state_str']='已阅';
            }else if($v['fb_state']==2){
                $list[$k]['fb_state_str']='已回复';
            }else{
                $list[$k]['fb_state_str']='<span style="color:#FF0000">新</span>';
            }
            if($v['fb_userid']>0 && $v['fb_username']!=''){
                $list[$k]['fb_username_str']=$v['fb_username'];
            }else{
                $list[$k]['fb_username_str']='-';
            }
        }
        
        $this->assign('list', $list);
        $this->assign('page', $show);
        $this->assign('curr', 'jfmo_feedback');
        $this->display('feedback');
    }
     //查看留言
    public function feedbackdetail(){
        $this->check_qypurview('70009',1);

        $map['fb_id']=intval(I('get.fb_id',0));
        $map['fb_unitcode']=session('unitcode');
        $Jffeedback= M('Jffeedback');
        $data=$Jffeedback->where($map)->find();
        if($data){
            if($data['fb_userid']>0 && $data['fb_username']!=''){
                $data['fb_username_str']=' (会员：<a href='.U('Mp/Jfuser/index?keyword='.$data['fb_username']).'>'.$data['fb_username'].'</a>)';
            }else{
                $data['fb_username_str']='';
            }
            $data2['fb_state']=1;
            $Jffeedback->where($map)->save($data2);
        }else{
            $this->error('没有该记录');
        }

        $this->assign('feedbackdetail', $data);
        $this->assign('curr', 'jfmo_feedback');

        $this->display('feedbackdetail');
    }
    //删除留言
    public function feedbackdelete(){
        $this->check_qypurview('70009',1);

        $map['fb_id']=intval(I('get.fb_id',0));
        $map['fb_unitcode']=session('unitcode');
        $Jffeedback= M('Jffeedback');
        $data=$Jffeedback->where($map)->find();

        if($data){
            $Jffeedback->where($map)->delete(); 
            $this->success('删除成功','',1);
        }else{
            $this->error('没有该记录','',1);
        }     
    }
    //=========================================================================================
    //积分手机端产品展示
    public function product(){
        $this->check_qypurview('70005',1);

        $pro_typeid=intval(I('param.pro_typeid',0));
        $keyword=trim(strip_tags(htmlspecialchars_decode(I('param.keyword',''))));

        if($pro_typeid>0){
            $son_type_id='';
            $Jfprotype = M('Jfprotype');
            $map4=array();
            $map4['protype_unitcode']=session('unitcode');
            $map4['protype_iswho'] = $pro_typeid;
            $res4 = $Jfprotype->where($map4)->order('protype_order ASC')->select();
            if($res4 && count($res4)>0){
                foreach($res4 as $k=>$v){
                    $map5=array();
                    $map5['protype_unitcode']=session('unitcode');
                    $map5['protype_iswho'] = $v['protype_id'];
                    $res5 = $Jfprotype->where($map5)->order('protype_order ASC')->select();
                    if($res5 && count($res5)>0){
                        foreach($res5 as $kk=>$vv){
                            $son_type_id.=$vv['protype_id'].',';
                        }
                        $son_type_id.=$v['protype_id'].',';
                    }else{
                        $son_type_id.=$v['protype_id'].',';   
                    }
                }
                $son_type_id.=$pro_typeid;
            }else{
                $son_type_id=$pro_typeid;
            }


            if(strpos($son_type_id,',')>0){
               $map['pro_typeid']=array('IN',explode(',',$son_type_id));
            }else{
               $map['pro_typeid']=$pro_typeid;
            }
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
        }
        //分页显示
        $Jfproduct = M('Jfproduct');
        $map['pro_unitcode']=session('unitcode');
        $count = $Jfproduct->where($map)->count();
        $Page = new \Think\Page($count, C('PAGE_SIZE'));
        $show = $Page->show();
        $list = $Jfproduct->where($map)->order('pro_id DESC')->limit(($Page->firstRow . ',') . $Page->listRows)->select();
        
        $Jfprotype = M('Jfprotype');
        $imgpath = BASE_PATH.'/Public/uploads/mobi/';

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
                    $list[$k]['pro_pic_str']='<img src="'.__ROOT__.'/Public/uploads/mobi/'.$v['pro_pic'].'" width="'.$ww.'"  height="'.$hh.'"  border="0">';
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
            $protypeinfo = $Jfprotype->where($map2)->find();
            if($protypeinfo){
                  $list[$k]['pro_typeid_str']=$protypeinfo['protype_name'];
            }else{
                  $list[$k]['pro_typeid_str']='-';
            }

        }
        $this->assign('list', $list);

        $map3=array();
        $map3['protype_unitcode']=session('unitcode');
        $map3['protype_iswho'] = 0;
        $list3 = $Jfprotype->where($map3)->order('protype_order ASC')->select();
        foreach($list3 as $k=>$v){ 
            $map4=array();
            $map4['protype_unitcode']=session('unitcode');
            $map4['protype_iswho'] = $v['protype_id'];

            if($v['protype_id']==$pro_typeid){
                $list3[$k]['selected']='selected';
            }else{
                $list3[$k]['selected']='';
            }

            $list4 = $Jfprotype->where($map4)->order('protype_order ASC')->select();
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
        $this->assign('curr', 'jfmo_pro');

        $this->display('product');
    }

    //添加产品
    public function proadd(){
        $this->check_qypurview('70005',1);

        $data['pro_id']=0;
        $data['pro_jftype']=1;

        //分类
        $map['protype_unitcode']=session('unitcode');
        $map['protype_iswho'] = 0;
        $Jfprotype = M('Jfprotype');
        $list = $Jfprotype->where($map)->order('protype_order ASC')->select();
        foreach($list as $k=>$v){ 
             $map2['protype_unitcode']=session('unitcode');
             $map2['protype_iswho'] = $v['protype_id'];
             $list2 = $Jfprotype->where($map2)->order('protype_order ASC')->select();

             $list[$k]['subarr']=$list2;
        }

        $ttamp=time();
        $sture=MD5(session('unitcode').$ttamp);
        $this->assign('ttamp', URLEncode($ttamp));
        $this->assign('sture', URLEncode($sture));
        $this->assign('sid', URLEncode(\Org\Util\Funcrypt::authcode(session_id(),'ENCODE',C('WWW_AUTHKEY'),0)));
        $this->assign('uid', URLEncode(\Org\Util\Funcrypt::authcode(session('unitcode'),'ENCODE',C('WWW_AUTHKEY'),0)));

        $this->assign('typelist', $list);
        $this->assign('curr', 'jfmo_pro');
        $this->assign('atitle', '添 加');
        $this->assign('proinfo', $data);
        $this->display('proadd');
    }
    //修改产品
    public function proedit(){
        $this->check_qypurview('70005',1);

        $map['pro_id']=intval(I('get.pro_id',0));
        $map['pro_unitcode']=session('unitcode');
        $Jfproduct= M('Jfproduct');
        $data=$Jfproduct->where($map)->find();
        if($data){

        }else{
            $this->error('没有该记录');
        }
        $imgpath = BASE_PATH.'/Public/uploads/mobi/';
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
                $data['pro_pic_str']='<img src="'.__ROOT__.'/Public/uploads/mobi/'.$data['pro_pic'].'" width="'.$ww.'"  height="'.$hh.'"  border="0" style="vertical-align:middle" >';
            }
            else{
                $data['pro_pic_str']='';
            }
        }else{
            $data['pro_pic_str']='';
        }
        //分类
        $map2['protype_unitcode']=session('unitcode');
        $map2['protype_iswho'] = 0;
        $Jfprotype = M('Jfprotype');
        $list2 = $Jfprotype->where($map2)->order('protype_order ASC')->select();
        foreach($list2 as $k=>$v){ 
            $map3['protype_unitcode']=session('unitcode');
            $map3['protype_iswho'] = $v['protype_id'];

            if($v['protype_id']==$data['pro_typeid']){
                $list2[$k]['selected']='selected';
            }else{
                $list2[$k]['selected']='';
            }

            $list3 = $Jfprotype->where($map3)->order('protype_order ASC')->select();
            foreach($list3 as $kk=>$vv){ 
                if($vv['protype_id']==$data['pro_typeid']){
                    $list3[$kk]['selected']='selected';
                }else{
                    $list3[$kk]['selected']='';
                }
            }

            $list2[$k]['subarr']=$list3;
        }

        $ttamp=time();
        $sture=MD5(session('unitcode').$ttamp);
        $this->assign('ttamp', URLEncode($ttamp));
        $this->assign('sture', URLEncode($sture));
        $this->assign('sid', URLEncode(\Org\Util\Funcrypt::authcode(session_id(),'ENCODE',C('WWW_AUTHKEY'),0)));
        $this->assign('uid', URLEncode(\Org\Util\Funcrypt::authcode(session('unitcode'),'ENCODE',C('WWW_AUTHKEY'),0)));

        $this->assign('typelist', $list2);
        $this->assign('proinfo', $data);
        $this->assign('curr', 'jfmo_pro');
        $this->assign('atitle', '修 改');

        $this->display('proadd');
    }
    //删除产品
    public function prodelete(){
        $this->check_qypurview('70005',1);

        $map['pro_id']=intval(I('get.pro_id',0));
        $map['pro_unitcode']=session('unitcode');
        $Jfproduct= M('Jfproduct');
        $data=$Jfproduct->where($map)->find();

        if($data){
            //验证是否要删除 要保持数据完整性 

            @unlink('./Public/uploads/mobi/'.$data['pro_pic']); 
            $Jfproduct->where($map)->delete(); 
            $this->success('删除成功','',1);
        }else{
            $this->error('没有该记录');
        }     
    
    }
    //激活禁用产品
    public function proactive(){
        $this->check_qypurview('70005',1);

        $map['pro_id']=intval(I('get.pro_id',0));
        $map['pro_unitcode']=session('unitcode');
        $Jfproduct= M('Jfproduct');
        $data=$Jfproduct->where($map)->find();
        if($data){
            $active=intval(I('get.pro_active',0));

            if($active==1){
                $data2['pro_active'] = 0;
            }else{
                $data2['pro_active'] = 1;
            }
            
            $Jfproduct->where($map)->save($data2);
            $this->success('激活/禁用成功','',1);
        }else{
            $this->error('没有该记录');
        }
    }

    //保存产品
    public function proedit_save(){
        $this->check_qypurview('70005',1);

        if (!IS_POST) {
             header('HTTP/1.0 404 Not Found');
             echo'error:404';
             exit;
        }
        $map['pro_id']=intval(I('post.pro_id',''));
        
        if($map['pro_id']>0){
            //修改保存
            $pro_typeid=intval(I('post.pro_typeid',0));

            $pro_link=I('post.pro_link','');
            if($pro_link!=''){
                if(strtolower(substr($pro_link,0,7))!='http://'){
                    $this->error('链接要以http://开头','',1);
                }
            }

            $data['pro_id']=$map['pro_id'];
            $data['pro_name']=I('post.pro_name','');
            $data['pro_number']=I('post.pro_number','');
            $data['pro_typeid']=$pro_typeid;
            $data['pro_link']=$pro_link;
            $data['pro_desc']=(isset($_POST['econtent']) && is_not_null($_POST['econtent'])) ? $_POST['econtent']:'';
			$data['pro_price']=I('post.pro_price','');

            if($data['pro_name']=='' || $data['pro_number']=='' ){
                $this->error('带"*"不能为空','',1);
            }
			
			if($data['pro_price']!=''){
				if(!preg_match("/^[0-9.]{1,10}$/",$data['pro_price'])){
					$this->error('产品价格必须为数字','',1);
				}
			}

            $map2['pro_unitcode']=session('unitcode');
            $map2['pro_name']=I('post.pro_name','');
            $map2['pro_number']=I('post.pro_number','');
            $map2['pro_id'] = array('NEQ',$map['pro_id']);
            $Jfproduct= M('Jfproduct');
            $data2=$Jfproduct->where($map2)->find();
            if($data2){
                $this->error('该产品已存在','',1);
            }
            
            //上传文件 begin
            if($_FILES['pic_file']['name']==''){
                $pro_pic='';
            }else{
                $upload = new \Think\Upload();
                $upload->maxSize = 3145728 ;
                $upload->exts = array('jpg', 'gif', 'png', 'jpeg');
                $upload->rootPath   = './Public/uploads/mobi/';
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
            //上传文件 end
            if($pro_pic!=''){
                $data['pro_pic']=$pro_pic;
            }
            
            $map['pro_unitcode']=session('unitcode');
            $rs=$Jfproduct->where($map)->data($data)->save();
           
            if($rs){
                $this->success('修改成功',U('Mp/Jfmobi/product'),1);

            }else{
                $this->error('修改失败','',1);
            }
        }else{  
            //添加保存
            $map=array();
            $map['pro_unitcode']=session('unitcode');
            $map['pro_name']=I('post.pro_name','');
            $map['pro_number']=I('post.pro_number','');

            $Jfproduct= M('Jfproduct');
            $data2=$Jfproduct->where($map)->find();
            if($data2){
                $this->error('该产品已存在','',1);
            }

            $pro_typeid=intval(I('post.pro_typeid',0));

            $pro_link=I('post.pro_link','');
            if($pro_link!=''){
                if(strtolower(substr($pro_link,0,7))!='http://'){
                    $this->error('链接要以http://开头','',1);
                }
            }

            $data['pro_name']=$map['pro_name'];
            $data['pro_number']=$map['pro_number'];
            $data['pro_unitcode']=session('unitcode');
            $data['pro_typeid']=$pro_typeid;
            $data['pro_link']=$pro_link;
            $data['pro_desc']=(isset($_POST['econtent']) && is_not_null($_POST['econtent'])) ? $_POST['econtent']:'';
            $data['pro_addtime']=time();
            $data['pro_active']=1;
			$data['pro_price']=I('post.pro_price','');
            
            if($data['pro_name']=='' || $data['pro_number']=='' ){
                $this->error('带"*"不能为空');
            }
			
			if($data['pro_price']!=''){
				if(!preg_match("/^[0-9.]{1,10}$/",$data['pro_price'])){
					$this->error('产品价格必须为数字','',1);
				}
			}
			
            //上传文件 begin
            if($_FILES['pic_file']['name']==''){
                $pro_pic='';
            }else{
                $imgpath = BASE_PATH.'/Public/uploads/mobi/';
                $imgpath_b=$imgpath.session('unitcode').'/';
                if (!file_exists($imgpath_b)) {
                    mkdir($imgpath_b);
                }
                
                $upload = new \Think\Upload();
                $upload->maxSize = 3145728 ;
                $upload->exts = array('jpg', 'gif', 'png', 'jpeg');
                $upload->rootPath   =  './Public/uploads/mobi/';
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
            //上传文件 end
            $data['pro_pic']=$pro_pic;


            $rs=$Jfproduct->create($data,1);
            if($rs){
               $result = $Jfproduct->add(); 
               if($result){
                   $this->success('添加成功',U('Mp/Jfmobi/product'),1);
               }else{
                   $this->error('添加失败','',1);
               }
            }else{
                $this->error('添加失败','',1);
            }

        }

    }
    //=====================================================================================
    //积分手机端产品分类列表
    public function protypelist(){
        $this->check_qypurview('70008',1);

        $map['protype_unitcode']=session('unitcode');
        $map['protype_iswho'] = 0;
        $Jfprotype = M('Jfprotype');
        $list = $Jfprotype->where($map)->order('protype_order ASC')->select();
        foreach($list as $k=>$v){ 
             $map2['protype_unitcode']=session('unitcode');
             $map2['protype_iswho'] = $v['protype_id'];
             $list2 = $Jfprotype->where($map2)->order('protype_order ASC')->select();

             $list[$k]['subarr']=$list2;
        }

        $this->assign('list', $list);
        $this->assign('curr', 'jfmo_pro');

        $this->display('protypelist');
    }
    //添加产品分类
    public function protypeadd(){
        $this->check_qypurview('70008',1);

        $data['protype_id']=0;
        
        $map['protype_unitcode']=session('unitcode');
        $map['protype_iswho'] = 0;
        $Jfprotype = M('Jfprotype');
        $list = $Jfprotype->where($map)->order('protype_order ASC')->select();
        
        $this->assign('parenttypelist', $list);
        $this->assign('curr', 'jfmo_pro');
        $this->assign('atitle', '添 加');
        $this->assign('protypeinfo', $data);

        $this->display('protypeadd');
    }
    //修改产品分类
    public function protypeedit(){
        $this->check_qypurview('70008',1);

        $map['protype_id']=intval(I('get.protype_id',0));
        $map['protype_unitcode']=session('unitcode');
        $Jfprotype= M('Jfprotype');
        $data=$Jfprotype->where($map)->find();
        if($data){

        }else{
            $this->error('没有该记录');
        }
        $map2['protype_unitcode']=session('unitcode');
        $map2['protype_iswho'] = 0;
        $list = $Jfprotype->where($map2)->order('protype_order ASC')->select();
        foreach($list as $k=>$v){ 
            if($v['protype_id']==$data['protype_iswho']){
                $list[$k]['selected']='selected';
            }else{
                $list[$k]['selected']='';
            }
        }

        $this->assign('parenttypelist', $list);
        $this->assign('protypeinfo', $data);
        $this->assign('curr', 'jfmo_pro');
        $this->assign('atitle', '修 改');

        $this->display('protypeadd');
    }

    //保存产品分类
    public function protypeedit_save(){
        $this->check_qypurview('70008',1);

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

            $Jfprotype= M('Jfprotype');
            $map2['protype_iswho']=$data['protype_id'];
            $map2['protype_unitcode']=session('unitcode');
            $data2=$Jfprotype->where($map2)->find();
            if($data2){
                if($protype_iswho>0){
                    $this->error('该类含有子类，不能作为其他类的子类');
                }
            }

            $rs=$Jfprotype->create($data,2);
           
            if($rs){
               $result = $Jfprotype->save(); 
               if($result){
                   $this->success('修改成功',U('Mp/Jfmobi/protypelist'),2);
               }else{
                   $this->error('修改失败');
               }
            }else{
                $this->error('修改失败');
            }

        }else{  
            //添加保存
            $Jfprotype= M('Jfprotype');

            $data['protype_unitcode']=session('unitcode');
            $data['protype_name']=I('post.protype_name','');
            $data['protype_iswho']=I('post.protype_iswho','0');
            

            if($data['protype_name']==''){
                $this->error('带"*"不能为空');
            }
            
            $rs=$Jfprotype->create($data,1);
            if($rs){
               $result = $Jfprotype->add(); 
               if($result){
                   $map2['protype_id'] = $result;
                   $data2['protype_order'] = $result;
                   $Jfprotype->where($map2)->save($data2);

                   $this->success('修改成功',U('Mp/Jfmobi/protypelist'),2);
               }else{
                   $this->error('添加失败');
               }
            }else{
                $this->error('添加失败');
            }

        }

    }
    //移动产品分类
    public function protypeorder(){
        $this->check_qypurview('70008',1);

        $map['protype_id']=intval(I('get.protype_id',0));
        $map['protype_unitcode']=session('unitcode');
        $active=I('get.active','');

        $Jfprotype= M('Jfprotype');
        $data=$Jfprotype->where($map)->find();
        if(!$data){
            $this->error('没有该记录');
        }

        if($active=='shang'){
            $map2['protype_iswho']=$data['protype_iswho'];
            $map2['protype_unitcode']=session('unitcode');
            $map2['protype_order']=array('LT',$data['protype_order']);
            $data2 = $Jfprotype->where($map2)->order('protype_order DESC')->find();
            if($data2){
                $map3['protype_unitcode']=session('unitcode');
                $map3['protype_id']=$data2['protype_id'];
                $data3['protype_order']=$data['protype_order'];
                $Jfprotype->where($map3)->save($data3);

                $map4['protype_unitcode']=session('unitcode');
                $map4['protype_id']=$data['protype_id'];
                $data4['protype_order']=$data2['protype_order'];
                $Jfprotype->where($map4)->save($data4);

            }

            $this->redirect('Mp/Jfmobi/protypelist','' , 0, '');

        }elseif($active=='xia'){
            $map2['protype_iswho']=$data['protype_iswho'];
            $map2['protype_unitcode']=session('unitcode');
            $map2['protype_order']=array('GT',$data['protype_order']);
            $data2 = $Jfprotype->where($map2)->order('protype_order ASC')->find();
            if($data2){
                $map3['protype_unitcode']=session('unitcode');
                $map3['protype_id']=$data2['protype_id'];
                $data3['protype_order']=$data['protype_order'];
                $Jfprotype->where($map3)->save($data3);

                $map4['protype_unitcode']=session('unitcode');
                $map4['protype_id']=$data['protype_id'];
                $data4['protype_order']=$data2['protype_order'];
                $Jfprotype->where($map4)->save($data4);

            }
            $this->redirect('Mp/Jfmobi/protypelist','' , 0, '');
        }

    }

    //删除产品分类
    public function protypedelete(){
        $this->check_qypurview('70008',1);
        
        $map['protype_id']=intval(I('get.protype_id',0));
        $map['protype_unitcode']=session('unitcode');
        $Jfprotype= M('Jfprotype');
        $data=$Jfprotype->where($map)->find();
        if($data){

        }else{
            $this->error('没有该记录');
        }
        $Jfproduct= M('Jfproduct');
        //是否有子类
        $map2['protype_iswho'] = $map['protype_id'];
        $list = $Jfprotype->where($map2)->order('protype_order ASC')->select();
        if($list){
            $this->error('该类型含有子类，暂不能删除');
        }

        $map4['pro_typeid'] = $map['protype_id'];
        $data4=$Jfproduct->where($map4)->find();
        if($data4){
            $this->error('该类型已应用到其他产品，暂不能删除');
        }
        $Jfprotype->where($map)->delete(); 
        $this->success('删除成功',U('Mp/Jfmobi/protypelist'));
    }

}