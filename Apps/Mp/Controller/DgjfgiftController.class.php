<?php
namespace Mp\Controller;
use Think\Controller;
//导购积分礼品管理
class DgjfgiftController extends CommController {
	//积分礼品列表
    public function index(){
        $this->check_qypurview('12008',1);

        $Dgjfgift = M('Dgjfgift');
        $map['gif_unitcode']=session('unitcode');
        $count = $Dgjfgift->where($map)->count();
        $Page = new \Think\Page($count, C('PAGE_SIZE'));
        $show = $Page->show();
        $list = $Dgjfgift->where($map)->order('gif_id DESC')->limit(($Page->firstRow . ',') . $Page->listRows)->select();
        $Dgjfexchdetail = M('Dgjfexchdetail');
        $imgpath = BASE_PATH.'/Public/uploads/product/';
        foreach($list as $k=>$v){ 
            if(is_not_null($v['gif_pic']) && file_exists($imgpath.$v['gif_pic'])){
                $arr=getimagesize($imgpath.$v['gif_pic']);
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
                    $list[$k]['gif_pic_str']='<img src="'.__ROOT__.'/Public/uploads/product/'.$v['gif_pic'].'" width="'.$ww.'"  height="'.$hh.'"  border="0">';
                }
                else{
                    $list[$k]['gif_pic_str']='-';
                }
            }else{
                $list[$k]['gif_pic_str']='-';
            }

            if($v['gif_type']==1){
                $list[$k]['gif_type_str']='实物';
            }else{
                $list[$k]['gif_type_str']='虚拟';
            }

            $map2=array();
            $map2['detail_unitcode']=session('unitcode');
            $map2['detail_giftid'] = $v['gif_id'];
            $count2 = $Dgjfexchdetail->where($map2)->sum('detail_qty');  //已经兑换数量
            $list[$k]['gif_qty2']=$count2;
        }

        $this->assign('list', $list);
        $this->assign('page', $show);
        $this->assign('curr', 'dgjfgift_list');
        $this->display('list');
    }
    //添加礼品
    public function add(){
        $this->check_qypurview('12008',1);

        $data['gif_id']=0;
        $data['gif_type']=1;
        $this->assign('curr', 'dgjfgift_list');
        $this->assign('atitle', '添加礼品');
        $this->assign('jfgiftinfo', $data);

        $this->display('add');
    }
    //修改礼品
    public function edit(){
        $this->check_qypurview('12008',1);

        $map['gif_id']=intval(I('get.gif_id',0));
        $map['gif_unitcode']=session('unitcode');
        $Dgjfgift= M('Dgjfgift');
        $data=$Dgjfgift->where($map)->find();
        $imgpath = BASE_PATH.'/Public/uploads/product/';
        if($data){
            if(is_not_null($data['gif_pic']) && file_exists($imgpath.$data['gif_pic'])){
                $arr=getimagesize($imgpath.$data['gif_pic']);
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
                    $data['gif_pic_str']='<img src="'.__ROOT__.'/Public/uploads/product/'.$data['gif_pic'].'" width="'.$ww.'"  height="'.$hh.'"  border="0" style="vertical-align:middle"  >';
                }
                else{
                    $data['gif_pic_str']='-';
                }
            }else{
                $data['gif_pic_str']='-';
            }
        }else{
            $this->error('没有该记录');
        }

        $this->assign('jfgiftinfo', $data);
        $this->assign('curr', 'dgjfgift_list');
        $this->assign('atitle', '修改礼品');

        $this->display('add');
    }
    //删除礼品
    public function delete(){
        $this->check_qypurview('12008',1);

        $map['gif_id']=intval(I('get.gif_id',0));
        $map['gif_unitcode']=session('unitcode');
        $Dgjfgift= M('Dgjfgift');
        $data=$Dgjfgift->where($map)->find();

        if($data){
            //验证是否要删除或删除相关信息 要保持数据完整性 

            //该礼品已有兑换
            $map2=array();
            $Dgjfexchdetail = M('Dgjfexchdetail');
            $map2['detail_unitcode']=session('unitcode');
            $map2['detail_giftid'] = $data['gif_id'];
            $data2 = $Dgjfexchdetail->where($map2)->find();
            if($data2){
                $this->error('该礼品已有兑换礼品,暂不能删除','',2);
            }


            @unlink('./Public/uploads/product/'.$data['gif_pic']); 
            $Dgjfgift->where($map)->delete(); 
            //记录日志 begin
            $log_arr=array(
                        'log_qyid'=>session('qyid'),
                        'log_user'=>session('qyuser'),
                        'log_qycode'=>session('unitcode'),
                        'log_action'=>'删除导购礼品',
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
    //激活禁用
    public function active(){
        $this->check_qypurview('12008',1);

        $map['gif_id']=intval(I('get.gif_id',0));
        $map['gif_unitcode']=session('unitcode');
        $Dgjfgift= M('Dgjfgift');
        $data=$Dgjfgift->where($map)->find();
        if($data){
            $active=intval(I('get.gif_active',0));

            if($active==1){
                $data2['gif_active'] = 0;
            }else{
                $data2['gif_active'] = 1;
            }
            
            $Dgjfgift->where($map)->save($data2);
            
            //记录日志 begin
            $log_arr=array(
                        'log_qyid'=>session('qyid'),
                        'log_user'=>session('qyuser'),
                        'log_qycode'=>session('unitcode'),
                        'log_action'=>'激活/禁用导购礼品',
						'log_type'=>1, //0-系统 1-企业 2-经销商 3-消费者
                        'log_addtime'=>time(),
                        'log_ip'=>real_ip(),
                        'log_link'=>__SELF__,
                        'log_remark'=>json_encode($data2)
                        );
            save_log($log_arr);
            //记录日志 end

            $this->success('激活/禁用成功','',1);
        }else{
            $this->error('没有该记录');
        }
    }

    //保存礼品
    public function edit_save(){
        $this->check_qypurview('12008',1);
        if (!IS_POST) {
             header('HTTP/1.0 404 Not Found');
             echo'error:404';
             exit;
        }
        $map['gif_id']=intval(I('post.gif_id',''));
        
        if($map['gif_id']>0){
            //修改保存

            $gif_jf=I('post.gif_jf','');
            if($gif_jf==''){
                $gif_jf=0;
            }else{
                if(!preg_match("/^[0-9]{1,6}$/",$gif_jf)){
                    $this->error('输入积分必须为数字','',2);
                }
            }
            if($gif_jf<=0){
                $this->error('输入积分必须大于0','',2);
            }

            $gif_qty=I('post.gif_qty','');
            if($gif_qty==''){
                $gif_qty=0;
            }else{
                if(!preg_match("/^[0-9]{1,6}$/",$gif_qty)){
                    $this->error('输入礼品数量必须为数字','',2);
                }
            }    
            $gif_type=intval(I('post.gif_type',1));
            if($gif_type==1){
                $data['gif_qty']=$gif_qty;
            }
            $data['gif_name']=I('post.gif_name','');
            $data['gif_jf']=$gif_jf;
            
            $data['gif_des']=I('post.gif_des','');

            $old_gif_pic=I('post.old_gif_pic','');
      
            if($data['gif_name']==''){
                $this->error('礼品名称不能为空','',2);
            }
            
            //上传文件 begin
            if($_FILES['pic_file']['name']==''){
                $gif_pic='';
            }else{
                $upload = new \Think\Upload();
                $upload->maxSize = 3145728 ;
                $upload->exts = array('jpg', 'gif', 'png', 'jpeg');
                $upload->rootPath   = './Public/uploads/product/';
                $upload->subName  = session('unitcode');
                $upload->saveName = time().'_'.mt_rand(1000,9999);
                
                $info   =   $upload->uploadOne($_FILES['pic_file']);

                if(!$info) {
                    $this->error($upload->getError(),'',1);
                }else{
                    $gif_pic=$info['savepath'].$info['savename'];
                }

                @unlink($upload->rootPath.$old_gif_pic); 
                @unlink($_FILES['pic_file']['tmp_name']); 
            }
            //上传文件 end

            if($gif_pic!=''){
                $data['gif_pic']=$gif_pic;
            }
            
            $map['gif_unitcode']=session('unitcode');
            $Dgjfgift= M('Dgjfgift');

            $rs=$Dgjfgift->where($map)->data($data)->save();
           
            if($rs){
                //记录日志 begin
                $log_arr=array(
                            'log_qyid'=>session('qyid'),
                            'log_user'=>session('qyuser'),
                            'log_qycode'=>session('unitcode'),
                            'log_action'=>'修改导购礼品',
							'log_type'=>1, //0-系统 1-企业 2-经销商 3-消费者
                            'log_addtime'=>time(),
                            'log_ip'=>real_ip(),
                            'log_link'=>__SELF__,
                            'log_remark'=>json_encode($data)
                            );
                save_log($log_arr);
                //记录日志 end
                $this->success('修改成功',U('Mp/Dgjfgift/index'),1);
            }else{
                $this->error('修改失败','',1);
            }

        }else{  
            //添加保存
            $map=array();
            $map['gif_unitcode']=session('unitcode');
            $map['gif_name']=I('post.gif_name','');

            $Dgjfgift= M('Dgjfgift');
            $data2=$Dgjfgift->where($map)->find();
            if($data2){
                $this->error('该礼品名称已存在');
            }

            $gif_type=intval(I('post.gif_type',1));
            $gif_jf=I('post.gif_jf','');
            if($gif_jf==''){
                $gif_jf=0;
            }else{
                if(!preg_match("/^[0-9]{1,6}$/",$gif_jf)){
                    $this->error('输入积分必须为数字','',2);
                }
            }
            if($gif_jf<=0){
                $this->error('输入积分必须大于0','',2);
            }

            $gif_qty=I('post.gif_qty','');
            if($gif_qty==''){
                $gif_qty=0;
            }else{
                if(!preg_match("/^[0-9]{1,6}$/",$gif_qty)){
                    $this->error('输入礼品数量必须为数字','',2);
                }
            }
            if($gif_type==2){
                $gif_qty=0;
            }

            $data['gif_name']=$map['gif_name'];
            $data['gif_unitcode']=session('unitcode');
            $data['gif_jf']=$gif_jf;
            $data['gif_type']=$gif_type;
            $data['gif_qty']=$gif_qty;
            $data['gif_des']=I('post.gif_des','');
            $data['gif_addtime']=time();
            $data['gif_active']=1;
            
            if($data['gif_name']==''){
                $this->error('礼品名称不能为空');
            }
            //上传文件 begin
            if($_FILES['pic_file']['name']==''){
                $gif_pic='';
            }else{
                
                $upload = new \Think\Upload();
                $upload->maxSize = 3145728 ;
                $upload->exts = array('jpg', 'gif', 'png', 'jpeg');
                $upload->rootPath   = './Public/uploads/product/';
                $upload->subName  = session('unitcode');
                $upload->saveName = time().'_'.mt_rand(1000,9999);
                
                $info   =   $upload->uploadOne($_FILES['pic_file']);

                if(!$info) {
                    $this->error($upload->getError());
                }else{
                    $gif_pic=$info['savepath'].$info['savename'];
                }
                @unlink($_FILES['pic_file']['tmp_name']); 
            }
            //上传文件 end
            $data['gif_pic']=$gif_pic;


            $rs=$Dgjfgift->create($data,1);
            if($rs){
               $result = $Dgjfgift->add(); 
               if($result){
                    //记录日志 begin
                    $log_arr=array(
                                'log_qyid'=>session('qyid'),
                                'log_user'=>session('qyuser'),
                                'log_qycode'=>session('unitcode'),
                                'log_action'=>'添加导购礼品',
								'log_type'=>1, //0-系统 1-企业 2-经销商 3-消费者
                                'log_addtime'=>time(),
                                'log_ip'=>real_ip(),
                                'log_link'=>__SELF__,
                                'log_remark'=>json_encode($data)
                                );
                    save_log($log_arr);
                    //记录日志 end
                   $this->success('添加成功',U('Mp/Dgjfgift/index'),1);
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