<?php
namespace Mp\Controller;
use Think\Controller;
//导购用户管理
class DguserController extends CommController {
	//用户列表
    public function index(){
        $this->check_qypurview('12001',1);

        $keyword=trim(strip_tags(htmlspecialchars_decode(I('post.keyword',''))));

        if($keyword!=''){
            $keyword=str_replace('[','',$keyword);
            $keyword=str_replace(']','',$keyword);
            $keyword=str_replace('%','',$keyword);
            $keyword=str_replace('_','',$keyword);
            
            $keyword=sub_str($keyword,20,false);
            $where['dguser_username']=array('LIKE', '%'.$keyword.'%');
            $where['dguser_truename']=array('LIKE', '%'.$keyword.'%');
			$where['dguser_wxnickname']=array('LIKE', '%'.$keyword.'%');
			$where['dguser_weixin']=array('LIKE', '%'.$keyword.'%');
            $where['dguser_tel']=array('LIKE', '%'.$keyword.'%');
            $where['_logic'] = 'or';
            $map['_complex'] = $where;
        }

        $Dguser = M('Dguser');
        $map['dguser_unitcode']=session('unitcode');
        $count = $Dguser->where($map)->count();
        $Page = new \Think\Page($count, C('PAGE_SIZE'));
        $show = $Page->show();
        $list = $Dguser->where($map)->order('dguser_id DESC')->limit(($Page->firstRow . ',') . $Page->listRows)->select();

        foreach($list as $k=>$v){ 
		    $list[$k]['dguser_wxnickname']=wxuserTextDecode2($v['dguser_wxnickname']);
        }
        $this->assign('list', $list);

        $this->assign('keyword', $keyword);
        $this->assign('page', $show);
		$this->assign('pagecount', $count);
        $this->assign('curr', 'dguser_list');

        $this->display('list');
    }
	
    //添加导购
    public function add(){
        $this->check_qypurview('12002',1);
        $data['dguser_id']=0;
        $this->assign('curr', 'dguser_list');
        $this->assign('atitle', '添加导购');
        $this->assign('dguserinfo', $data);

        $this->display('add');
    }
    //修改导购
    public function edit(){
        $this->check_qypurview('12003',1);

        $map['dguser_id']=intval(I('get.dguser_id',0));
        $map['dguser_unitcode']=session('unitcode');
        $Dguser= M('Dguser');
        $data=$Dguser->where($map)->find();
        if($data){
             $data['dguser_wxnickname']=wxuserTextDecode2($data['dguser_wxnickname']);
        }else{
            $this->error('没有该记录');
        }

        $this->assign('dguserinfo', $data);
        $this->assign('curr', 'dguser_list');
        $this->assign('atitle', '修改导购');

        $this->display('add');
    }
    //查看详细导购
    public function view(){
        $this->check_qypurview('12001',1);

        $map['dguser_id']=intval(I('get.dguser_id',0));
        $map['dguser_unitcode']=session('unitcode');
        $Dguser= M('Dguser');
        $data=$Dguser->where($map)->find();
        if($data){
             $data['dguser_wxnickname']=wxuserTextDecode2($data['dguser_wxnickname']);
        }else{
            $this->error('没有该记录');
        }

        $this->assign('dguserinfo', $data);
        $this->assign('curr', 'dguser_list');
        $this->assign('atitle', '导购详细');

        $this->display('view');
    }	
    //删除导购
    public function delete(){
        $this->check_qypurview('12004',1);

        $map['dguser_id']=intval(I('get.dguser_id',0));
        $map['dguser_unitcode']=session('unitcode');
        $Dguser= M('Dguser');
        $data=$Dguser->where($map)->find();

        if($data){
            //验证是否要删除或删除相关信息 要保持数据完整性 
            //该会员已有积分
            $Dgjfdetail = M('dgjfdetail');
            $map2['dgjf_unitcode']=session('unitcode');
            $map2['dgjf_userid'] = $data['dguser_id'];
            $data2 = $Dgjfdetail->where($map2)->find();
            if($data2){
                $this->error('该导购已有积分,暂不能删除','',2);
            }

            //该会员已有兑换
            $map2=array();
            $Dgjfexchange = M('Dgjfexchange');
            $map2['exch_unitcode']=session('unitcode');
            $map2['exch_userid'] = $data['dguser_id'];
            $data2 = $Dgjfexchange->where($map2)->find();
            if($data2){
                $this->error('该导购已有兑换礼品,暂不能删除','',2);
            }

            
            $Dguser->where($map)->delete(); 
            //记录日志 begin
            $log_arr=array(
                        'log_qyid'=>session('qyid'),
                        'log_user'=>session('qyuser'),
                        'log_qycode'=>session('unitcode'),
                        'log_action'=>'删除导购',
						'log_type'=>1, //0-系统 1-企业 2-经销商 3-消费者
                        'log_addtime'=>time(),
                        'log_ip'=>real_ip(),
                        'log_link'=>__SELF__,
                        'log_remark'=>json_encode($map)
                        );
            save_log($log_arr);
            //记录日志 end
            $this->success('删除成功','',1);
        }else{
            $this->error('没有该记录');
        }     
    
    }
    //激活禁用会员
    public function active(){
        $this->check_qypurview('12001',1);

        $map['dguser_id']=intval(I('get.dguser_id',0));
        $map['dguser_unitcode']=session('unitcode');
        $Dguser= M('Dguser');
        $data=$Dguser->where($map)->find();
        if($data){
            $active=intval(I('get.dguser_active',0));

            if($active==1){
                $data2['dguser_active'] = 0;
            }else{
                $data2['dguser_active'] = 1;
            }
            
            $Dguser->where($map)->save($data2);
            
            //记录日志 begin
            $log_arr=array(
                        'log_qyid'=>session('qyid'),
                        'log_user'=>session('qyuser'),
                        'log_qycode'=>session('unitcode'),
                        'log_action'=>'激活/禁用导购',
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

    //保存导购
    public function edit_save(){
    	if (!IS_POST) {
             header('HTTP/1.0 404 Not Found');
             echo'error:404';
             exit;
        }
        $map['dguser_id']=intval(I('post.dguser_id',''));
        
        if($map['dguser_id']>0){
            //修改保存
            $this->check_qypurview('12003',1);

 
            $data['dguser_truename']=I('post.dguser_truename','');
            $data['dguser_tel']=I('post.dguser_tel','');
            $data['dguser_email']=I('post.dguser_email','');
            $data['dguser_qq']=I('post.dguser_qq','');
			$data['dguser_dianpu']=I('post.dguser_dianpu','');
            $data['dguser_sheng']=I('post.seachprov','0');
            $data['dguser_shi']=I('post.seachcity','0');
            $data['dguser_qu']=I('post.seachdistrict','0');
            $data['dguser_address']=I('post.dguser_address','');
            $data['dguser_remark']=I('post.dguser_remark','');
			$data['dguser_diqustr']=I('post.dguser_diqustr','');
            
            if($data['dguser_truename']=='' || $data['dguser_tel']==''){
                $this->error('带"*"不能为空','',2);
            }
			
            if(trim(I('post.dguser_pwd',''))!=''){
                $data['dguser_pwd']=MD5(MD5(MD5(trim(I('post.dguser_pwd','')))));
            }
			
            $Dguser= M('Dguser');
			
			$map2=array();
			$map2['dguser_tel']=$data['dguser_tel'];
			$map2['dguser_unitcode']=session('unitcode');
			$map2['dguser_id']=array('neq',intval($map['dguser_id']));
			$data22=$Dguser->where($map2)->find();
			if($data22){
				$this->error('你填写的电话已存在','',2);
			}
			
			$map['dguser_unitcode']=session('unitcode');
            $rs=$Dguser->where($map)->save($data);
           
		   if($rs){
				//记录日志 begin
				$log_arr=array(
							'log_qyid'=>session('qyid'),
							'log_user'=>session('qyuser'),
							'log_qycode'=>session('unitcode'),
							'log_action'=>'修改导购',
							'log_type'=>1, //0-系统 1-企业 2-经销商 3-消费者
							'log_addtime'=>time(),
							'log_ip'=>real_ip(),
							'log_link'=>__SELF__,
							'log_remark'=>json_encode($data)
							);
				save_log($log_arr);
				//记录日志 end
				$this->success('修改成功',U('Mp/Dguser/index'),1);
				
			}elseif($rs==0){  
				$this->error('数据没有改变','',1);
			}else{
				$this->error('修改失败','',1);
			}

        }else{  
            $this->check_qypurview('12002',1);

            //添加保存


            $data['dguser_unitcode']=session('unitcode');
            $data['dguser_username']=I('post.dguser_username','');
            $data['dguser_pwd']=trim(I('post.dguser_pwd',''));
            $data['dguser_truename']=I('post.dguser_truename','');
            $data['dguser_tel']=I('post.dguser_tel','');
            $data['dguser_email']=I('post.dguser_email','');
            $data['dguser_qq']=I('post.dguser_qq','');
			$data['dguser_dianpu']=I('post.dguser_dianpu','');
            $data['dguser_sheng']=I('post.seachprov','0');
            $data['dguser_shi']=I('post.seachcity','0');
            $data['dguser_qu']=I('post.seachdistrict','0');
            $data['dguser_address']=I('post.dguser_address','');
            $data['dguser_remark']=I('post.dguser_remark','');
            $data['dguser_addtime']=time();
            $data['dguser_logintime']=0;
            $data['dguser_jf']=0;
            $data['dguser_active']=1;
			$data['dguser_diqustr']=I('post.dguser_diqustr','');


            if($data['dguser_username']=='' || $data['dguser_pwd']=='' || $data['dguser_truename']=='' || $data['dguser_tel']==''){
                $this->error('带"*"不能为空','',2);
            }

            if(!preg_match("/[a-zA-Z0-9_]{6,20}$/",$data['dguser_username'])){
                $this->error('用户名由 A--Z,a--z,0--9,_ 组成,6-20位','',2);
            }
            $data['dguser_pwd']=MD5(MD5(MD5($data['dguser_pwd'])));

            $map=array();
            $map['dguser_unitcode']=session('unitcode');
            $map['dguser_username']=$data['dguser_username'];

            $Dguser= M('Dguser');
            $data2=$Dguser->where($map)->find();
            if($data2){
                $this->error('该账号已存在');
            }

            $rs=$Dguser->create($data,1);
            if($rs){
               $result = $Dguser->add(); 
               if($result){
                    //记录日志 begin
                    $log_arr=array(
                                'log_qyid'=>session('qyid'),
                                'log_user'=>session('qyuser'),
                                'log_qycode'=>session('unitcode'),
                                'log_action'=>'添加导购',
								'log_type'=>1, //0-系统 1-企业 2-经销商 3-消费者
                                'log_addtime'=>time(),
                                'log_ip'=>real_ip(),
                                'log_link'=>__SELF__,
                                'log_remark'=>json_encode($data)
                                );
                    save_log($log_arr);
                    //记录日志 end
                   $this->success('添加成功',U('Mp/Dguser/index'),1);
               }else{
                   $this->error('添加失败','',2);
               }
            }else{
                $this->error('添加失败','',2);
            }
        }

    }

    //=====================================================================================


}