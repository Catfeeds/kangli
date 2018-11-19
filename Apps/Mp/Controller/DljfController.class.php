<?php
namespace Mp\Controller;
use Think\Controller;
//代理积分管理
class DljfController extends CommController {
	
	//代理积分
    public function index(){
        $this->check_qypurview('15001',1);
		
        $keyword=trim(strip_tags(htmlspecialchars_decode(I('param.keyword',''))));
		$dl_type=intval(I('param.dl_type',0));
		$dl_status=I('param.dl_status','');
		
		$parameter=array();
		
		if($dl_status!=''){
			$dl_status=intval($dl_status);
			$map['dl_status']=$dl_status;
			$parameter['dl_status']=$dl_status;
		}

		if($dl_type>0){
			$map['dl_type']=$dl_type;
			$parameter['dl_type']=$dl_type;
		}
		
	
		
        if($keyword!=''){
            $keyword=str_replace('[','',$keyword);
            $keyword=str_replace(']','',$keyword);
            $keyword=str_replace('%','',$keyword);
            $keyword=str_replace('_','',$keyword);
            $keyword=sub_str($keyword,20,false);
            $where['dl_name']=array('LIKE', '%'.$keyword.'%');
            $where['dl_number']=array('LIKE', '%'.$keyword.'%');
            $where['dl_tel']=array('LIKE', '%'.$keyword.'%');
            $where['dl_weixin']=array('LIKE', '%'.$keyword.'%');
			$where['dl_contact']=array('LIKE', '%'.$keyword.'%');
            $where['_logic'] = 'or';
            $map['_complex'] = $where;
			
			$parameter['keyword']=$keyword;
        }

        $map['dl_unitcode']=session('unitcode');
        $Dealer = M('Dealer');
		$Dltype = M('Dltype');
		$Dljfdetail= M('Dljfdetail');
		
        $count = $Dealer->where($map)->count();
        $Page = new \Think\Page($count, C('PAGE_SIZE'),$parameter);
        $show = $Page->show();
        $list = $Dealer->where($map)->order('dl_type ASC,dl_id DESC')->limit(($Page->firstRow . ',') . $Page->listRows)->select();
		foreach($list as $k=>$v){
			
			//经销商级别
			$map2=array();
			$map2['dlt_id']=$v['dl_type'];
			$map2['dlt_unitcode']=session('unitcode');
			$data2 = $Dltype->where($map2)->find();
			if($data2){
				$list[$k]['dl_type_str']=$data2['dlt_name'];
			}else{
				$list[$k]['dl_type_str']='-';
			}
			
			//上家代理
			if($v['dl_belong']>0){
				$map2=array();
				$map2['dl_id']=$v['dl_belong'];
				$map2['dl_unitcode']=session('unitcode');
				$data2=$Dealer->where($map2)->find();
				if($data2){
					$list[$k]['dl_belong_str']=$data2['dl_name'].'('.$data2['dl_username'].')';
				}else{
					$list[$k]['dl_belong_str']='-';
				}
			}else{
				$list[$k]['dl_belong_str']='直属公司';
			}
			
			//推荐人
			if($v['dl_referee']>0){
				$map2=array();
				$map2['dl_id']=$v['dl_referee'];
				$map2['dl_unitcode']=session('unitcode');
				$data2=$Dealer->where($map2)->find();
				if($data2){
					$list[$k]['dl_referee_str']=$data2['dl_name'].'('.$data2['dl_username'].')';
				}else{
					$list[$k]['dl_referee_str']='-';
				}
			}else{
				$list[$k]['dl_referee_str']='直属公司';
			}

			//累计增加积分
			$totaljf=0;
			$map2=array();
			$map2['dljf_dlid']=$v['dl_id'];
			$map2['dljf_unitcode']=session('unitcode');
			$map2['dljf_type']=array('in','1,2,3,4,5');  //积分分类 1-5增加积分     6-9 消费积分
			$totaljf = $Dljfdetail->where($map2)->sum('dljf_jf'); 
            if($totaljf){
			   $list[$k]['dl_totaljf']=$totaljf;
			}else{
			    $totaljf=0;
			   $list[$k]['dl_totaljf']=$totaljf;
			}
            //消费积分
			$decjf=0;
			$map2=array();
			$map2['dljf_dlid']=$v['dl_id'];
			$map2['dljf_unitcode']=session('unitcode');
			$map2['dljf_type']=array('in','6,7,8,9');
			$decjf = $Dljfdetail->where($map2)->sum('dljf_jf');
			if($decjf){
			   $list[$k]['dl_decjf']=$decjf;
			}else{
			    $decjf=0;
			   $list[$k]['dl_decjf']=$decjf;
			}
			//剩余积分
			if($totaljf>=$decjf){
			    $surplusjf=$totaljf-$decjf;
			}else{
				$surplusjf=0;
			}
			$list[$k]['dl_surplusjf']=$surplusjf;
		}
        //分类列表
		$map2=array();
        $map2['dlt_unitcode']=session('unitcode');
        $list2 = $Dltype->where($map2)->order('dlt_level ASC,dlt_id ASC')->select();
        $this->assign('dltypelist', $list2);
		
		$this->assign('dl_type', $dl_type);
        $this->assign('dl_status', $dl_status);
	
        $this->assign('list', $list);
        $this->assign('page', $show);
		$this->assign('pagecount', $count);
        $this->assign('curr', 'dljflist');
        $this->display('list');
    }
	
	
	//积分明细
    public function dljflist(){
        $this->check_qypurview('15001',1);
        
		$dlusername=trim(I('param.dlusername',''));
		$begintime=I('param.begintime','');
        $endtime=I('param.endtime','');
		$parameter=array();
		
        $Dealer = M('Dealer');
		$Dljfdetail= M('Dljfdetail');
		$back=0;
		if($dlusername!='' && $dlusername!='请输入代理账号'){
            if(!preg_match("/[a-zA-Z0-9_-]{4,20}$/",$dlusername)){
                $this->error('代理账号不正确','',1);
            }
			
			$map2=array();
            $map2['dl_username']=$dlusername;
            $map2['dl_unitcode']=session('unitcode');
            $data22=$Dealer->where($map2)->find();
            if($data22){

			}else{
				$this->error('代理账号不正确','',1);
			}
			
            $map['dljf_dlid']=$data22['dl_id'];
			$parameter['dlusername']=$dlusername;
			$this->assign('dlusername', $dlusername);
        }else{
			$this->assign('dlusername', '请输入代理账号');
		}
		$this->assign('back', $back);
		
		
		if($begintime!='' && $endtime!=''){
            $begintime=strtotime($begintime);
			$endtime=strtotime($endtime);
			if($begintime===FALSE || $endtime===FALSE){
				$this->error('请选择查询日期','',1);
			}
			$endtime=$endtime+3600*24-1;
			if($begintime>=$endtime){
				$this->error('查询结束日期要大于开始日期','',1);
			}	
			
			$map['dljf_addtime']=array('between',array($begintime,$endtime));
			
			$parameter['begintime']=urlencode(date('Y-m-d',$begintime));
			$parameter['endtime']=urlencode(date('Y-m-d',$endtime));
			
			$this->assign('begintime', date('Y-m-d',$begintime));
			$this->assign('endtime', date('Y-m-d',$endtime));
		}else{
            $begintime='';
            $endtime='';
		    $this->assign('begintime', '');
		    $this->assign('endtime', '');
		}
        $map['dljf_unitcode']=session('unitcode');

        $count = $Dljfdetail->where($map)->count();
        $Page = new \Think\Page($count, C('PAGE_SIZE'),$parameter);
        $show = $Page->show();
        $list = $Dljfdetail->where($map)->order('dljf_id DESC')->limit(($Page->firstRow . ',') . $Page->listRows)->select();

        foreach($list as $k=>$v){
			//积分代理
			if($v['dljf_dlid']>0){
				$map2=array();
				$map2['dl_id']=$v['dljf_dlid'];
				$map2['dl_unitcode']=session('unitcode');
				$data2=$Dealer->where($map2)->find();
				if($data2){
					$list[$k]['dl_name_str']=$data2['dl_name'].'('.$data2['dl_username'].')';
					$list[$k]['dl_number']=$data2['dl_number'];
				}else{
					$list[$k]['dl_name_str']='未知';
					$list[$k]['dl_number']='-';
				}
			}else{
				$list[$k]['dl_name_str']='未知';
				$list[$k]['dl_number']='-';
			}
			
		
            //dljf_type 积分类型 1--5增加积分  6-9消费积分
            if($v['dljf_type']==1){
                $list[$k]['dljf_typestr']='订购产品积分';
                $list[$k]['dljf_jfstr']='+'.$v['dljf_jf'];
			}elseif($v['dljf_type']==2){	
                $list[$k]['dljf_typestr']='手动增加积分';
                $list[$k]['dljf_jfstr']='+'.$v['dljf_jf'];
            }elseif($v['dljf_type']==6){
                $list[$k]['dljf_typestr']='兑换礼品积分';
                $list[$k]['dljf_jfstr']='<span style="color:#009900">-'.$v['dljf_jf'].'</span>';
				
			}elseif($v['dljf_type']==7){
                $list[$k]['dljf_typestr']='手动减少积分';
                $list[$k]['dljf_jfstr']='<span style="color:#009900">-'.$v['dljf_jf'].'</span>';
            }else{
                $list[$k]['dljf_typestr']='其他';
                $list[$k]['dljf_jfstr']=$v['dljf_jf'];
            }

        }
        $this->assign('list', $list);

        $this->assign('page', $show);
		$this->assign('pagecount', $count);
        $this->assign('curr', 'dljdetail');

        $this->display('dljflist');
    }

    //查看详细
    public function dljfdetail(){
        $this->check_qypurview('15001',1);
        
        $map['dljf_id']=intval(I('get.dljf_id',0));
        $map['dljf_unitcode']=session('unitcode');
        $Dljfdetail= M('Dljfdetail');
        $data=$Dljfdetail->where($map)->find();
        $Dealer= M('Dealer');
        if($data){
			if($data['dljf_dlid']>0){
				$map2=array();
				$map2['dl_id']=$data['dljf_dlid'];
				$map2['dl_unitcode']=session('unitcode');
				$data2=$Dealer->where($map2)->find();
				if($data2){
					$data['dl_name_str']=$data2['dl_name'].'('.$data2['dl_username'].')';
				}else{
					$data['dl_name_str']='未知';
				}
			}else{
				$data['dl_name_str']='未知';
			}
            //dljf_type 积分类型 1--5增加积分  6-9消费积分
            if($data['dljf_type']==1){
                $data['dljf_typestr']='订购产品积分';
                $data['dljf_jfstr']='+'.$data['dljf_jf'];
			}elseif($data['dljf_type']==2){	
                $data['dljf_typestr']='手动增加积分';
                $data['dljf_jfstr']='+'.$data['dljf_jf'];
            }elseif($data['dljf_type']==6){
                $data['dljf_typestr']='兑换礼品积分';
                $data['dljf_jfstr']='<span style="color:#009900">-'.$data['dljf_jf'].'</span>';
				
			}elseif($data['dljf_type']==7){
                $data['dljf_typestr']='手动减少积分';
                $data['dljf_jfstr']='<span style="color:#009900">-'.$data['dljf_jf'].'</span>';
            }else{
                $data['dljf_typestr']='其他';
                $data['dljf_jfstr']=$data['dljf_jf'];
            }
        }else{
            $this->error('没有该记录');
        }

        $this->assign('dljfinfo', $data);
        $this->assign('curr', 'dljflist');

        $this->display('dljfdetail');
    }
	//=========================================================================
	
	//积分礼品列表
    public function dljfgift(){
        $this->check_qypurview('15003',1);

        $Dljfgift = M('Dljfgift');
        $map['gif_unitcode']=session('unitcode');
        $count = $Dljfgift->where($map)->count();
        $Page = new \Think\Page($count, C('PAGE_SIZE'));
        $show = $Page->show();
        $list = $Dljfgift->where($map)->order('gif_id DESC')->limit(($Page->firstRow . ',') . $Page->listRows)->select();
        $Dljfexchdetail = M('Dljfexchdetail');
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
            $count2 = $Dljfexchdetail->where($map2)->sum('detail_qty');  //已经兑换数量
			if($count2){
                $list[$k]['gif_qty2']=$count2;
			}else{
				$list[$k]['gif_qty2']=0;
			}
        }

        $this->assign('list', $list);
        $this->assign('page', $show);
        $this->assign('curr', 'dljfgift');
        $this->display('dljfgift');
    }
   
   //添加礼品
    public function dljfgift_add(){
        $this->check_qypurview('15003',1);

        $data['gif_id']=0;
        $data['gif_type']=1;
        $this->assign('curr', 'dljfgift');
        $this->assign('atitle', '添加礼品');
        $this->assign('jfgiftinfo', $data);

        $this->display('dljfgift_add');
    }
	
    //修改礼品
    public function dljfgift_edit(){
        $this->check_qypurview('15003',1);

        $map['gif_id']=intval(I('get.gif_id',0));
        $map['gif_unitcode']=session('unitcode');
        $Dljfgift= M('Dljfgift');
        $data=$Dljfgift->where($map)->find();
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
        $this->assign('curr', 'dljfgift');
        $this->assign('atitle', '修改礼品');

        $this->display('dljfgift_add');
    }
    
	//删除礼品
    public function dljfgift_delete(){
        $this->check_qypurview('15003',1);

        $map['gif_id']=intval(I('get.gif_id',0));
        $map['gif_unitcode']=session('unitcode');
        $Dljfgift= M('Dljfgift');
        $data=$Dljfgift->where($map)->find();

        if($data){
            //验证是否要删除或删除相关信息 要保持数据完整性 

            //该礼品已有兑换
            $map2=array();
            $Dljfexchdetail = M('Dljfexchdetail');
            $map2['detail_unitcode']=session('unitcode');
            $map2['detail_giftid'] = $data['gif_id'];
            $data2 = $Dljfexchdetail->where($map2)->find();
            if($data2){
                $this->error('该礼品已有兑换礼品,暂不能删除','',2);
            }


            @unlink('./Public/uploads/product/'.$data['gif_pic']); 
            $Dljfgift->where($map)->delete(); 
            //记录日志 begin
            $log_arr=array(
                        'log_qyid'=>session('qyid'),
                        'log_user'=>session('qyuser'),
                        'log_qycode'=>session('unitcode'),
                        'log_action'=>'删除代理礼品',
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
    public function dljfgift_active(){
        $this->check_qypurview('15003',1);

        $map['gif_id']=intval(I('get.gif_id',0));
        $map['gif_unitcode']=session('unitcode');
        $Dljfgift= M('Dljfgift');
        $data=$Dljfgift->where($map)->find();
        if($data){
            $active=intval(I('get.gif_active',0));

            if($active==1){
                $data2['gif_active'] = 0;
            }else{
                $data2['gif_active'] = 1;
            }
            
            $Dljfgift->where($map)->save($data2);
            
            //记录日志 begin
            $log_arr=array(
                        'log_qyid'=>session('qyid'),
                        'log_user'=>session('qyuser'),
                        'log_qycode'=>session('unitcode'),
                        'log_action'=>'激活/禁用代理礼品',
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
    public function dljfgift_save(){
        $this->check_qypurview('15003',1);
		
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
            $Dljfgift= M('Dljfgift');

            $rs=$Dljfgift->where($map)->data($data)->save();
           
            if($rs){
                //记录日志 begin
                $log_arr=array(
                            'log_qyid'=>session('qyid'),
                            'log_user'=>session('qyuser'),
                            'log_qycode'=>session('unitcode'),
                            'log_action'=>'修改代理礼品',
							'log_type'=>1, //0-系统 1-企业 2-经销商 3-消费者
                            'log_addtime'=>time(),
                            'log_ip'=>real_ip(),
                            'log_link'=>__SELF__,
                            'log_remark'=>json_encode($data)
                            );
                save_log($log_arr);
                //记录日志 end
                $this->success('修改成功',U('Mp/Dljf/dljfgift'),1);
            }else{
                $this->error('修改失败','',1);
            }

        }else{  
            //添加保存
            $map=array();
            $map['gif_unitcode']=session('unitcode');
            $map['gif_name']=I('post.gif_name','');

            $Dljfgift= M('Dljfgift');
            $data2=$Dljfgift->where($map)->find();
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


            $rs=$Dljfgift->create($data,1);
            if($rs){
               $result = $Dljfgift->add(); 
               if($result){
                    //记录日志 begin
                    $log_arr=array(
                                'log_qyid'=>session('qyid'),
                                'log_user'=>session('qyuser'),
                                'log_qycode'=>session('unitcode'),
                                'log_action'=>'添加代理礼品',
								'log_type'=>1, //0-系统 1-企业 2-经销商 3-消费者
                                'log_addtime'=>time(),
                                'log_ip'=>real_ip(),
                                'log_link'=>__SELF__,
                                'log_remark'=>json_encode($data)
                                );
                    save_log($log_arr);
                    //记录日志 end
                   $this->success('添加成功',U('Mp/Dljf/dljfgift'),1);
               }else{
                   $this->error('添加失败','',1);
               }
            }else{
                $this->error('添加失败','',1);
            }

        }

    }
    //==========================================================================
	
	//礼品兑换列表
    public function dljfexch(){
        $this->check_qypurview('15002',1);

        $keyword=trim(strip_tags(htmlspecialchars_decode(I('post.keyword',''))));
        if($keyword!=''){
            $keyword=str_replace('[','',$keyword);
            $keyword=str_replace(']','',$keyword);
            $keyword=str_replace('%','',$keyword);
            $keyword=str_replace('_','',$keyword);
            
            $keyword=sub_str($keyword,20,false);
            $where['exch_username']=array('LIKE', '%'.$keyword.'%');
            $where['exch_contact']=array('LIKE', '%'.$keyword.'%');
			$where['exch_tel']=array('LIKE', '%'.$keyword.'%');
            $where['exch_id']=$keyword;
            $where['_logic'] = 'or';
            $map['_complex'] = $where;
        }

        $Dljfexchange = M('Dljfexchange');
        $map['exch_unitcode']=session('unitcode');
        $count = $Dljfexchange->where($map)->count();
        $Page = new \Think\Page($count, C('PAGE_SIZE'));
        $show = $Page->show();
        $list = $Dljfexchange->where($map)->order('exch_id DESC')->limit(($Page->firstRow . ',') . $Page->listRows)->select();
        
        $Dljfexchdetail = M('Dljfexchdetail');
		$Dealer = M('Dealer');
        foreach($list as $k=>$v){ 
		    //兑换产品
            $map2=array();
            $map2['detail_unitcode']=session('unitcode');
            $map2['detail_exchid'] = $v['exch_id'];
            $exchdetail = $Dljfexchdetail->where($map2)->select();
            $exchdetail_str='';
            foreach($exchdetail as $kk=>$vv){ 
                $exchdetail_str=$exchdetail_str.$vv['detail_giftname'].'<br>';
            }
            $list[$k]['exchdetail']=$exchdetail_str;

            if($v['exch_state']==0){
                $list[$k]['exch_state_str']='<span style="color:#FF0000">待处理</span>';
            }elseif($v['exch_state']==1){
                $list[$k]['exch_state_str']='待发货';
            }elseif($v['exch_state']==2){
                $list[$k]['exch_state_str']='已发货';
            }elseif($v['exch_state']==9){
                $list[$k]['exch_state_str']='<span style="color:#FF0000">无效</span>';
            }
			
			//兑换代理
			
			if($v['exch_dlid']>0){
				$map2=array();
				$map2['dl_id']=$v['exch_dlid'];
				$map2['dl_unitcode']=session('unitcode');
				$data2=$Dealer->where($map2)->find();
				if($data2){
					$list[$k]['dl_name_str']=$data2['dl_name'].'('.$data2['dl_username'].')';
				}else{
					$list[$k]['dl_name_str']='未知';
				}
			}else{
				$list[$k]['dl_name_str']='未知';
			}
        }
        $this->assign('list', $list);

        $this->assign('page', $show);
		$this->assign('pagecount', $count);
        $this->assign('curr', 'dljfexch');

        $this->display('dljfexch');
    }
    
	//兑换详细
    public function dljfexch_view(){
        $this->check_qypurview('15002',1);
        $back=intval(I('get.back',0));
		
        $map['exch_id']=intval(I('get.exch_id',0));
        $map['exch_unitcode']=session('unitcode');
        $Dljfexchange= M('Dljfexchange');
        $data=$Dljfexchange->where($map)->find();
        $Dljfexchdetail = M('Dljfexchdetail');
		$Dealer = M('Dealer');
        if($data){
            $map2=array();
            $map2['detail_unitcode']=session('unitcode');
            $map2['detail_exchid'] = $data['exch_id'];
            $exchdetail = $Dljfexchdetail->where($map2)->select();

            if($data['exch_state']==0){
                $data['exch_state_str']='<span style="color:#FF0000">待处理</span>';
            }elseif($data['exch_state']==1){
                $data['exch_state_str']='待发货';
            }elseif($data['exch_state']==2){
                $data['exch_state_str']='已发货';
            }elseif($data['exch_state']==9){
                $data['exch_state_str']='<span style="color:#FF0000">无效</span>';
            }
			
			//兑换代理
			
			if($data['exch_dlid']>0){
				$map2=array();
				$map2['dl_id']=$data['exch_dlid'];
				$map2['dl_unitcode']=session('unitcode');
				$data2=$Dealer->where($map2)->find();
				if($data2){
					$data['dl_name_str']=$data2['dl_name'].'('.$data2['dl_username'].')';
				}else{
					$data['dl_name_str']='未知';
				}
			}else{
				$data['dl_name_str']='未知';
			}
        }else{
            $this->error('没有该记录');
        }
        $this->assign('exchdetail', $exchdetail);
        $this->assign('jfexchangeinfo', $data);
        $this->assign('curr', 'dljfexch');
		$this->assign('back', $back);

        $this->display('dljfexch_view');
    }

    //兑换处理
    public function dljfexch_deal(){
        $this->check_qypurview('15002',1);

        $map['exch_id']=intval(I('get.exch_id',0));
        $map['exch_unitcode']=session('unitcode');
        $Dljfexchange= M('Dljfexchange');
        $data=$Dljfexchange->where($map)->find();
        $Dljfexchdetail = M('Dljfexchdetail');
        if($data){
            $map2=array();
            $map2['detail_unitcode']=session('unitcode');
            $map2['detail_exchid'] = $data['exch_id'];
            $exchdetail = $Dljfexchdetail->where($map2)->select();

            if($data['exch_state']==0){
                $data['exch_state_str']='<span style="color:#FF0000">待处理</span>';
            }elseif($data['exch_state']==1){
                $data['exch_state_str']='待发货';
            }elseif($data['exch_state']==2){
                $data['exch_state_str']='已发货';
            }elseif($data['exch_state']==9){
                $data['exch_state_str']='<span style="color:#00FF00">无效</span>';
            }

        }else{
            $this->error('没有该记录');
        }
        $this->assign('exchdetail', $exchdetail);
        $this->assign('jfexchangeinfo', $data);
        $this->assign('curr', 'dljfexch');

        $this->display('dljfexch_deal');
    }


    //保存处理
    public function dljfexch_dealsave(){
        $this->check_qypurview('15002',1);

    	if (!IS_POST) {
             header('HTTP/1.0 404 Not Found');
             echo'error:404';
             exit;
        }
        $map['exch_id']=intval(I('post.exch_id',''));
        
        if($map['exch_id']>0){
       
            $data['exch_kuaidi']=I('post.exch_kuaidi','');
            $data['exch_kdhao']=I('post.exch_kdhao','');
            $data['exch_state']=I('post.deal',0);
            $data['exch_remark']=I('post.exch_remark','');

            $map['exch_unitcode']=session('unitcode');
            $Dljfexchange= M('Dljfexchange');
            $rs=$Dljfexchange->where($map)->data($data)->save();
           
            if($rs){
                //记录日志 begin
                $log_arr=array(
                            'log_qyid'=>session('qyid'),
                            'log_user'=>session('qyuser'),
                            'log_qycode'=>session('unitcode'),
                            'log_action'=>'处理代理兑换',
							'log_type'=>1, //0-系统 1-企业 2-经销商 3-消费者
                            'log_addtime'=>time(),
                            'log_ip'=>real_ip(),
                            'log_link'=>__SELF__,
                            'log_remark'=>json_encode(array_merge($data,$map))
                            );
                save_log($log_arr);
                //记录日志 end
                $this->success('处理成功',U('Mp/Dljf/dljfexch_view/back/1/exch_id/'.$map['exch_id']),1);
            }else{
               $this->error('处理失败','',1);
            }

        }else{
            $this->error('没有该记录','',2);
        }

    }


    //=====================================================================================
	
	    //增减积分
    public function changedjf(){
        $this->check_qypurview('15004',1);

        $map['dl_id']=intval(I('get.dl_id',0));
        $map['dl_unitcode']=session('unitcode');
        $Dealer= M('Dealer');
        $data=$Dealer->where($map)->find();
        if($data){
        }else{
            $this->error('没有该记录');
        }

        $this->assign('dealerinfo', $data);
        $this->assign('curr', 'dljflist');
        $this->assign('atitle', '增减积分');

        $this->display('changedjf');
    }
	
	//增减积分 保存
    public function changedjf_save(){
		$this->check_qypurview('15004',1);
		
    	if (!IS_POST) {
             header('HTTP/1.0 404 Not Found');
             echo'error:404';
             exit;
        }
		$ip=real_ip();
        $map['dl_id']=intval(I('post.dl_id',0));
		$map['dl_unitcode']=session('unitcode');
        $map['dl_status']=1;
		
		$Dljfdetail= M('Dljfdetail');
		$Dealer= M('Dealer');
        $dealerinfo=$Dealer->where($map)->find();
        if($dealerinfo){
			
        }else{
            $this->error('该用户不存在或已禁用');
        }
        
        $zengjian=intval(I('post.zengjian',0));
		$jf=intval(I('post.jf',0));
		$remark=I('post.remark','');
		
		if($zengjian==1){
			$jf_type=2;  //手动增加积分
		}else if($zengjian==2){
			$jf_type=7;  //手动减少积分
		}else{
			$this->error('请选择增减积分','',2);
		}
		
		if(!preg_match("/^[0-9]{1,5}$/",$jf)){
			$this->error('请填写积分','',2);
		}
		if($jf<=0){
			$this->error('请填写积分','',2);
		}
		if($remark==''){
			$this->error('请填写备注','',2);
		}
		
		if($zengjian==2 && $jf>0){
			//累计增加积分
			$totaljf=0;
			$map2=array();
			$map2['dljf_dlid']=$dealerinfo['dl_id'];
			$map2['dljf_unitcode']=session('unitcode');
			$map2['dljf_type']=array('in','1,2,3,4,5');  //积分分类 1-5增加积分     6-9 消费积分
			$totaljf = $Dljfdetail->where($map2)->sum('dljf_jf'); 
            if($totaljf){
			}else{
			    $totaljf=0;
			}
			
            //消费积分
			$decjf=0;
			$map2=array();
			$map2['dljf_dlid']=$dealerinfo['dl_id'];
			$map2['dljf_unitcode']=session('unitcode');
			$map2['dljf_type']=array('in','6,7,8,9');
			$decjf = $Dljfdetail->where($map2)->sum('dljf_jf'); 
			
			if($decjf){
			}else{
			    $decjf=0;
			}
			
			//剩余积分
			if($totaljf>=$decjf){
			    $surplusjf=$totaljf-$decjf;
			}else{
				$surplusjf=0;
			}
			
			if($surplusjf<$jf){
				$this->error('减少的积分大于该用户剩余积分','',2);
			}
		}
		
		//增减积分

		$data=array();
		$data['dljf_unitcode']=session('unitcode');
		$data['dljf_dlid']=$dealerinfo['dl_id'];
		$data['dljf_username']=$dealerinfo['dl_username'];
		$data['dljf_type']=$jf_type;
		$data['dljf_jf']=$jf;
		$data['dljf_addtime']=time();
		$data['dljf_ip']=$ip;
		$data['dljf_actionuser']=session('qyuser');
		$data['dljf_odid']=0;
		$data['dljf_orderid']='';
		$data['dljf_odblid']=0;
		$data['dljf_proid']=0;
		$data['dljf_qty']=0;
		$data['dljf_remark']=$remark;
        
		$rs=$Dljfdetail->create($data,1);
		if($rs){
			$result = $Dljfdetail->add(); 
			if($result){
	
				//记录日志 begin
				$log_arr=array(
							'log_qyid'=>session('qyid'),
							'log_user'=>session('qyuser'),
							'log_qycode'=>session('unitcode'),
							'log_action'=>'手动增减积分',
							'log_type'=>1, //0-系统 1-企业 2-经销商 3-消费者
							'log_addtime'=>time(),
							'log_ip'=>real_ip(),
							'log_link'=>__SELF__,
							'log_remark'=>json_encode($data)
							);
				save_log($log_arr);
				//记录日志 end
				$this->success('增减积分成功',U('Mp/Dljf/dljflist?dlusername='.$item['dl_username'].''),1);
			}else{
				 $this->error('增减积分失败','',2);
			}
		}else{
			 $this->error('增减积分失败','',2);
		}
	}

}