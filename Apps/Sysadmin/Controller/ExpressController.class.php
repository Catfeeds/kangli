<?php
namespace Sysadmin\Controller;
use Think\Controller;
//快递设置
class ExpressController extends CommController {
    //列表
    public function index(){

        $Express = M('Express');
		$map=array();
        $count = $Express->where($map)->count();
        $Page = new \Think\Page($count, 50,$parameter);
        $show = $Page->show();
        $list = $Express->where($map)->order('exp_addtime DESC')->limit(($Page->firstRow . ',') . $Page->listRows)->select();
		

        
        $this->assign('curr', 'express');
        $this->assign('list', $list);
        $this->assign('dip', $dip);
        $this->assign('page', $show);
		$this->assign('pagecount', $count);
        $this->display('index');
    }
	
    //添加
    public function add(){
		$data['exp_id']=0;
        $this->assign('expressinfo', $data);
        $this->assign('curr', 'express');
        $this->assign('atitle', '添加快递');
		$this->display('add'); 
    }
	
	//保存物流快递
    public function express_save(){
        if (!IS_POST) {
             header('HTTP/1.0 404 Not Found');
             echo'error:404';
             exit;
        }
        $exp_id=intval(I('post.exp_id',0));

      
        if($exp_id>0){

            //修改保存
            $Express= M('Express');

            $data['exp_name']=trim(I('post.exp_name',''));
			$data['exp_code']=trim(I('post.exp_code',''));

            
			if($data['exp_name']==''){
                $this->error('快递名称不能为空','',1);
            }
			
            $map['exp_id']=$exp_id;
            $rs=$Express->where($map)->data($data)->save();
           
            if($rs){
                $this->success('修改成功',U('Sysadmin/Express/index'),1);
            }else{
                $this->error('修改失败','',1);
            }
        }else{  

            //添加保存
            $Express= M('Express');
			
			$exp_name=trim(I('post.exp_name',''));
			$exp_code=trim(I('post.exp_code',''));


			if($exp_name==''){
				$this->error('快递名称不能为空','',1);
			}
			$map=array();
			$map['exp_name']=$exp_name;
            
            $data2=$Express->where($map)->find();
			if($data2){
				$this->error('该快递名称已存在','',1);
			}
			if($exp_code!=''){
				$map=array();
				$map['exp_code']=$exp_code;
				$data2=$Express->where($map)->find();
				if($data2){
					$this->error('该快递代码已存在','',1);
				}
			}
			
			
			$data=array();
			$data['exp_name']=$exp_name;
			$data['exp_code']=$exp_code;
			$data['exp_addtime']=time();

			$rs=$Express->create($data,1);
			if($rs){
			   $result = $Express->add(); 
			   if($result){
				   $this->success('添加成功',U('Sysadmin/Express/index'),1);
			   }else{
				   $this->error('添加失败','',1);
			   }
			}else{
				$this->error('添加失败','',1);
			}
        }
    }

    //修改物流快递
    public function edit(){
        $map['exp_id']=intval(I('get.exp_id',0));
        $Express= M('Express');
        $data=$Express->where($map)->find();

        if($data){

        }else{
            $this->error('没有该记录');
        }

        $this->assign('expressinfo', $data);
        $this->assign('curr', 'express');
        $this->assign('atitle', '修改快递');

        $this->display('add');
    }
	
	//前移物流快递
    public function forward(){
        $map['exp_id']=intval(I('get.exp_id',0));

        $Express= M('Express');
        $data=$Express->where($map)->find();
        if($data){
			$data2['exp_addtime']=time();
            $Express->where($map)->save($data2);
			
            $this->redirect('Sysadmin/Express/index','' , 0, '');
        }else{
            $this->error('没有该记录');
        }
    }

}