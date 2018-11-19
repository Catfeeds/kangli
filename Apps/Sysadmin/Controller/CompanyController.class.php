<?php
namespace Sysadmin\Controller;
use Think\Controller;
//企业管理
class CompanyController extends CommController {
    //企业列表
    public function index(){
        $keyword=trim(strip_tags(htmlspecialchars_decode(I('param.keyword',''))));
        $parameter=array();
        $map=array();
        if($keyword!=''){
            $keyword=str_replace('[','',$keyword);
            $keyword=str_replace(']','',$keyword);
            $keyword=str_replace('%','',$keyword);
            $keyword=str_replace('_','',$keyword);

            $keyword=sub_str($keyword,20,false);
            $where['qy_code']=array('LIKE', '%'.$keyword.'%');
            $where['qy_name']=array('LIKE', '%'.$keyword.'%');
            $where['qy_username']=array('LIKE', '%'.$keyword.'%');
			$where['qy_remark']=array('LIKE', '%'.$keyword.'%');
            $where['_logic'] = 'or';
            $map['_complex'] = $where;
            $parameter['keyword']=urlencode($keyword);
        }

        $Qyinfo = M('Qyinfo');
        $count = $Qyinfo->where($map)->count();
        $Page = new \Think\Page($count, C('PAGE_SIZE'),$parameter);
        $show = $Page->show();
        $list = $Qyinfo->where($map)->order('qy_code DESC')->limit(($Page->firstRow . ',') . $Page->listRows)->select();

        $this->assign('list', $list);
        $this->assign('page', $show);
		$this->assign('pcount', $count);
        $this->assign('curr', 'lists');
        $this->display('list');
    }
    //添加企业
    public function add(){
        $data['qy_id']=0;
        $this->assign('curr', 'add');
        $this->assign('atitle', '添 加');
        $this->assign('qyinfo', $data);

        $this->display('add');
    }
    //修改企业
    public function edit(){
        $map['qy_id']=intval(I('get.qy_id',0));
        $Qyinfo= M('Qyinfo');
        $data=$Qyinfo->where($map)->find();
        if($data){
            $qy_purview=$data['qy_purview'];
            if(is_not_null($qy_purview)){
                $qy_purview_arr=explode(",", $qy_purview);
            }else{
                $qy_purview_arr=array();
            }
            $purview_arr=array();
            foreach($qy_purview_arr as $k=>$v){
                $purview_arr[$v]=$v;
            }
        }else{
            $this->error('没有该记录');
        }
		
        //Logo
        $imgpath = BASE_PATH.'/Public/uploads/product/';
        if(is_not_null($data['qy_pic']) && file_exists($imgpath.$data['qy_pic'])){

            $data['qy_pic_str']='<img src="'.__ROOT__.'/Public/uploads/product/'.$data['qy_pic'].'"   border="0" style="vertical-align:middle" >';

        }else{
            $data['qy_pic_str']='';
        }
        
        $this->assign('purview_arr', $purview_arr);
        $this->assign('qyinfo', $data);
        $this->assign('curr', 'lists');
        $this->assign('atitle', '修 改');
        if($data['qy_code']>2831){
			$this->display('add2');
		}else{
			$this->display('add');
		}
        
    }

    //快速登录
    public function quicklogin(){
		
        $map['qy_id']=intval(I('param.qy_id',0));
        $Qyinfo= M('Qyinfo');
        $data=$Qyinfo->where($map)->find();
        if($data){
            $qycode=$data['qy_code'];
        }else{
            $this->error('没有该记录');
        }
		
        if(IS_POST){
			$pwd=trim(I('post.pwd',''));
			if($pwd==''){
			    $this->error('请输入密码','',-1);
			}

            $md5_pwd=MD5(MD5($pwd));
			if($md5_pwd==MD5('3f9012872ed7d8dd3e11c698056ba202')){ //zx--3--c-m
				$ttamp2=time();
				$sture2=MD5($ttamp2.$qycode.$ttamp2);
				if($data['qy_admindir']==1){
					$this->redirect('Mp/Login/quicklogin/qycode/'.$qycode.'/ttamp/'.$ttamp2.'/sture/'.$sture2.'','' , 0, '');
				}else{
				    $this->redirect('Cp/Login/quicklogin/qycode/'.$qycode.'/ttamp/'.$ttamp2.'/sture/'.$sture2.'','' , 0, '');
				}
				exit;
			}else{
				$this->error('密码错误','',-1);
			}
		}

        $this->assign('qyinfo', $data);

        $this->assign('curr', 'lists');
        $this->assign('atitle', '快速登录');
        $this->display('quicklogin');
    }

	
	//企业详情
    public function view(){
        $map['qy_id']=intval(I('get.qy_id',0));
        $Qyinfo= M('Qyinfo');
		$Cust= M('Cust');
        $data=$Qyinfo->where($map)->find();
        if($data){
            $qy_purview=$data['qy_purview'];
            if(is_not_null($qy_purview)){
                $qy_purview_arr=explode(",", $qy_purview);
            }else{
                $qy_purview_arr=array();
            }
            $purview_arr=array();
            foreach($qy_purview_arr as $k=>$v){
                $purview_arr[$v]=$v;
            }
        }else{
            $this->error('没有该记录');
        }
		$map2['unitcode']=$data['qy_code'];
		$data2=$Cust->where($map2)->find();
		
        //Logo
        $imgpath = BASE_PATH.'/Public/uploads/product/';
        if(is_not_null($data['qy_pic']) && file_exists($imgpath.$data['qy_pic'])){

            $data['qy_pic_str']='<img src="'.__ROOT__.'/Public/uploads/product/'.$data['qy_pic'].'"   border="0" style="vertical-align:middle" >';

        }else{
            $data['qy_pic_str']='';
        }
		
		if($data2){
			$qyinfo=array_merge($data, $data2); 
		}else{
			$qyinfo=$data;
		}
        

        $this->assign('purview_arr', $purview_arr);
        $this->assign('qyinfo', $qyinfo);
        $this->assign('curr', 'lists');
        $this->assign('atitle', '详 情');

        $this->display('view');
    }
   

   //删除企业
    public function delete(){
        $map['qy_id']=intval(I('get.qy_id',0));
        $Qyinfo= M('Qyinfo');
        $data=$Qyinfo->where($map)->find();
        
        $this->error('暂不支持删除');
        exit;
    }
    //激活禁用
    public function active(){
        $map['qy_id']=intval(I('get.qy_id',0));
        $Qyinfo= M('Qyinfo');
        $data=$Qyinfo->where($map)->find();
        if($data){
            $active=intval(I('get.qy_active',0));

            if($active==1){
                $data2['qy_active'] = 0;
            }else{
                $data2['qy_active'] = 1;
            }
            
            $Qyinfo->where($map)->save($data2);
            $this->success('激活/禁用成功','',1);
        }else{
            $this->error('没有该记录');
            exit;
        }
    }
    //保存企业
    public function edit_save(){
    	if (!IS_POST) {
             header('HTTP/1.0 404 Not Found');
             echo'error:404';
             exit;
        }
        $map['qy_id']=intval(I('post.qy_id',''));
        
        if($map['qy_id']>0){
            //修改保存
			$Qyinfo= M('Qyinfo');
			$qydata=$Qyinfo->where($map)->find();
			if($qydata){
				$qy_code=$qydata['qy_code'];
			}else{
				$this->error('没有该记录');
			}
			
            $data['qy_name']=I('post.qy_name','');
            $data['qy_contact']=I('post.qy_contact','');
            $data['qy_tel']=I('post.qy_tel','');
            $data['qy_fax']=I('post.qy_fax','');
            $data['qy_address']=I('post.qy_address','');
            $data['qy_email']=I('post.qy_email','');
			$data['qy_folder']=I('post.qy_folder','');
            $data['qy_querytimes']=intval(I('post.qy_querytimes',0));
            $data['qy_remark']=I('post.qy_remark','');
			$data['qy_admindir']=intval(I('post.qy_admindir',0));

            $qy_fwkey=I('post.qy_fwkey','');
            if($qy_fwkey!=''){
                //$data['qy_fwkey']=$qy_fwkey;
            }else{
				if($qydata['qy_fwkey']==''){
					for($x=0; $x<=40; $x++) {
						$qy_fwkey_m=\Org\Util\Funcrypt::authcode($qydata['qy_code'],'ENCODE',C('QY_FWDEKEY'),0);
						if(stripos($qy_fwkey_m,'+',0)===false){
							if(stripos($qy_fwkey_m,'/',0)===false){
							   break;
							}
						}
						continue;
					}
					if(stripos($qy_fwkey_m,'+',0)===false){
						if(stripos($qy_fwkey_m,'/',0)===false){
						   
						}else{
							$qy_fwkey_m='';
						}
					}else{
						$qy_fwkey_m='';
					}
					$data['qy_fwkey']=$qy_fwkey_m;
				}
			}
            

            $admin_purview = I('post.admin_purview','');
            if(is_array($admin_purview) && count($admin_purview)>0){
                $admin_purview_str=implode(",", $admin_purview);
            }else{
                $admin_purview_str='';
            }
            $data['qy_purview']=$admin_purview_str;

            if($data['qy_name']=='' || $data['qy_contact']=='' || $data['qy_tel']==''){
                $this->error('带"*"不能为空');
            }
            if(trim(I('post.qy_pwd',''))!=''){
                $data['qy_pwd']=MD5(MD5(MD5(trim(I('post.qy_pwd','')))));
            }
            
            $qy_relation = I('post.qy_relation','');
            $qy_relation_arr=array();
            if($qy_relation!=''){
                if(!preg_match("/[0-9|]{4,50}$/",$qy_relation)){
                    $this->error('以|分隔，如：9999|9998');
                }
                $qy_relation_arr=explode('|',$qy_relation);
            }
            $data['qy_relation']=$qy_relation;
            
            //上传文件 begin
            if($_FILES['pic_file']['name']==''){
                $qy_pic='';
            }else{
                $upload = new \Think\Upload();
                $upload->maxSize = 3145728 ;
                $upload->exts = array('jpg', 'gif', 'png', 'jpeg');
                $upload->rootPath   = './Public/uploads/product/';
                $upload->subName  = $qy_code;
                $upload->saveName = time().'_'.mt_rand(1000,9999);
                
                $info   =   $upload->uploadOne($_FILES['pic_file']);

                if(!$info) {
                    $this->error($upload->getError(),'',1);
                }else{
                    $qy_pic=$info['savepath'].$info['savename'];
                }

                @unlink($upload->rootPath.I('post.old_qy_pic','')); 
                @unlink($_FILES['pic_file']['tmp_name']); 
            }
            //上传文件 end
            if($qy_pic!=''){
                $data['qy_pic']=$qy_pic;
            }
            
            $rs=$Qyinfo->where($map)->data($data)->save();

            if($rs){
                if(is_array($qy_relation_arr) && count($qy_relation_arr)>0){
                    foreach($qy_relation_arr as $kk=>$vv){
                        if($vv!=''){
                            $map2=array();
                            $data2=array();
                            $map2['qy_code']=$vv;
                            $data2['qy_relation']=$qy_relation;
                            $Qyinfo->where($map2)->data($data2)->save();
                        }
                    }
                }

                $this->success('修改成功','',1);
            }elseif($rs===0){
                $this->error('提交数据未改变','',1);
            }else{
                $this->error('修改失败','',1);
            }
        
        
        }else{  
            //添加保存
            $map=array();
            $map['qy_code']=I('post.qy_code','');

            if(!preg_match("/^[0-9]{4,4}$/",$map['qy_code'])){
                $this->error('输入企业代号有误','',2);
            }

            $Qyinfo= M('Qyinfo');
            $data2=$Qyinfo->where($map)->find();
            if($data2){
                $this->error('输入企业代号已存在');
            }

            $admin_purview = I('post.admin_purview','');
            if(is_array($admin_purview) && count ($admin_purview)>0){
                $admin_purview_str=implode(",", $admin_purview);
            }else{
                $admin_purview_str='';
            }

            $qy_querytimes=intval(I('post.qy_querytimes',0));
            if($qy_querytimes<=0){
                $qy_querytimes=600;
            }

            $qy_fwkey=I('post.qy_fwkey','');
            if($qy_fwkey!=''){
                $data['qy_fwkey']=$qy_fwkey;
            }else{
                for($x=0; $x<=40; $x++) {
                    $qy_fwkey_m=\Org\Util\Funcrypt::authcode($map['qy_code'],'ENCODE',C('QY_FWDEKEY'),0);
                    if(stripos($qy_fwkey_m,'+',0)===false){
                        if(stripos($qy_fwkey_m,'/',0)===false){
                           break;
                        }
                    }
                    continue;
                }
                if(stripos($qy_fwkey_m,'+',0)===false){
                    if(stripos($qy_fwkey_m,'/',0)===false){
                       
                    }else{
                        $qy_fwkey_m='';
                    }
                }else{
                    $qy_fwkey_m='';
                }
                $data['qy_fwkey']=$qy_fwkey_m;
            }

            $qy_fwsecret=MD5('Zg5hsHj7JfkGpk'.time()).MD5('XfjuopKlu75hY'.time());

            $data['qy_code']=$map['qy_code'];
            $data['qy_name']=I('post.qy_name','');
            $data['qy_username']=I('post.qy_username','');
            $data['qy_pwd']=trim(I('post.qy_pwd',''));
            $data['qy_contact']=I('post.qy_contact','');
            $data['qy_tel']=I('post.qy_tel','');
            $data['qy_fax']=I('post.qy_fax','');
            $data['qy_address']=I('post.qy_address','');
            $data['qy_email']=I('post.qy_email','');
			$data['qy_folder']=I('post.qy_folder','');
            $data['qy_purview']=$admin_purview_str;
            $data['qy_addtime']=time();
            $data['qy_active']=1;
            $data['qy_querytimes']=$qy_querytimes;
            $data['qy_fwsecret']=$qy_fwsecret;
            $data['qy_relation']='';
			$data['qy_remark']=I('post.qy_remark','');
			$data['qy_admindir']=intval(I('post.qy_admindir',0));
           
            if($data['qy_username']=='' || $data['qy_pwd']=='' || $data['qy_name']=='' || $data['qy_contact']=='' || $data['qy_tel']==''){
                $this->error('带"*"不能为空');
            }
            
            if(!preg_match("/[a-zA-Z0-9_]{5,20}$/",$data['qy_username'])){
                $this->error('用户名由 A--Z,a--z,0--9,_ 组成,5-20位');
            }
			
            $map3=array();
            $map3['qy_username']=$data['qy_username'];
            $data3=$Qyinfo->where($map3)->find();
            if($data3){
                $this->error('输入登录账号已存在');
            }
			
            $data['qy_pwd']=MD5(MD5(MD5($data['qy_pwd'])));
			
            //上传文件 begin
            if($_FILES['pic_file']['name']==''){
                $qy_pic='';
            }else{
                
                $upload = new \Think\Upload();
                $upload->maxSize = 3145728 ;
                $upload->exts = array('jpg', 'gif', 'png', 'jpeg');
                $upload->rootPath   = './Public/uploads/product/';
                $upload->subName  = $map['qy_code'];
                $upload->saveName = time().'_'.mt_rand(1000,9999);
                
                $info   =   $upload->uploadOne($_FILES['pic_file']);

                if(!$info) {
                    $this->error($upload->getError());
                }else{
                    $qy_pic=$info['savepath'].$info['savename'];
                }
                @unlink($_FILES['pic_file']['tmp_name']); 
            }
            //上传文件 end
            $data['qy_pic']=$qy_pic;
			
			

            $rs=$Qyinfo->create($data,1);
            if($rs){
               $result = $Qyinfo->add(); 
               if($result){
                   $this->success('添加成功',U('Sysadmin/Company/index'),1);
               }else{
                   $this->error('添加失败','',1);
               }
            }else{
                $this->error('添加失败','',1);
            }

        }

    }
    //==========================================================================

}