<?php
namespace Mp\Controller;
use Think\Controller;
//仓库管理
class WarehouseController extends CommController {
    //仓库列表
    public function index(){
        $this->check_qypurview('11001',1);

        $map['wh_unitcode']=session('unitcode');
        $Warehouse = M('Warehouse');
        $count = $Warehouse->where($map)->count();
        $Page = new \Think\Page($count, C('PAGE_SIZE'));
        $show = $Page->show();
        $list = $Warehouse->where($map)->order('wh_id ASC')->limit(($Page->firstRow . ',') . $Page->listRows)->select();
 
        foreach($list as $k=>$v){ 

        }

        $this->assign('list', $list);
        $this->assign('page', $show);
        $this->assign('curr', 'warehouse_list');
        $this->display('list');
    }
    //仓库添加
    public function add(){
        $this->check_qypurview('11002',1);

        $data['wh_id']=0;
        $this->assign('curr', 'warehouse_list');
        $this->assign('atitle', '添加仓库');
        $this->assign('whinfo', $data);

        $this->display('add');
    }
    //修改仓库
    public function edit(){
        $this->check_qypurview('11002',1);

        $map['wh_id']=intval(I('get.wh_id',0));
        $map['wh_unitcode']=session('unitcode');
        $Warehouse= M('Warehouse');
        $data=$Warehouse->where($map)->find();
        if($data){

        }else{
            $this->error('没有该记录');
        }
    
        $this->assign('whinfo', $data);
        $this->assign('curr', 'warehouse_list');
        $this->assign('atitle', '修改仓库');

        $this->display('add');
    }
    //保存仓库
    public function edit_save(){
        $this->check_qypurview('11002',1);

        if (!IS_POST) {
             header('HTTP/1.0 404 Not Found');
             echo'error:404';
             exit;
        }
        $map['wh_id']=intval(I('post.wh_id',''));
        
        if($map['wh_id']>0){
            //修改保存

            $data['wh_munber']=I('post.wh_munber','');
			$data['wh_name']=I('post.wh_name','');
			$data['wh_address']=I('post.wh_address','');
			$data['wh_director']=I('post.wh_director','');
			$data['wh_remark']=I('post.wh_remark','');

            if($data['wh_munber']=='' ){
                $this->error('仓库编号不能为空');
            }
			 if($data['wh_name']=='' ){
                $this->error('仓库名称不能为空');
            }
			$Warehouse= M('Warehouse');
			
            $map2['wh_munber']=I('post.wh_munber','');
            $map2['wh_unitcode']=session('unitcode');
			$map2['wh_id']=array('NEQ',$map['wh_id']);
            $data2=$Warehouse->where($map2)->find();
            if($data2){
                $this->error('该仓库编号已存在');
            }
			
			
            $map['wh_unitcode']=session('unitcode');
            $rs=$Warehouse->where($map)->data($data)->save();

            if($rs){
				//记录日志 begin
				$log_arr=array(
							'log_qyid'=>session('qyid'),
							'log_user'=>session('qyuser'),
							'log_qycode'=>session('unitcode'),
							'log_action'=>'修改仓库',
							'log_type'=>1, //0-系统 1-企业 2-经销商 3-消费者
							'log_addtime'=>time(),
							'log_ip'=>real_ip(),
							'log_link'=>__SELF__,
							'log_remark'=>json_encode($data)
							);
				save_log($log_arr);
				//记录日志 end
				
                $this->success('修改成功',U('Mp/Warehouse/index'),'',2);
            }elseif($rs===0){
                $this->error('提交数据未改变','',1);
			}else{	
                $this->error('修改失败','',1);
            }
        }else{  
            //添加保存
            $map=array();
            $map['wh_munber']=I('post.wh_munber','');
            $map['wh_unitcode']=session('unitcode');

            $Warehouse= M('Warehouse');
            $data2=$Warehouse->where($map)->find();
            if($data2){
                $this->error('该仓库编号已存在');
            }
			
            $data['wh_unitcode']=session('unitcode');
            $data['wh_munber']=I('post.wh_munber','');
			$data['wh_name']=I('post.wh_name','');
			$data['wh_address']=I('post.wh_address','');
			$data['wh_director']=I('post.wh_director','');
			$data['wh_remark']=I('post.wh_remark','');

            if($data['wh_munber']=='' ){
                $this->error('仓库编号不能为空');
            }
			 if($data['wh_name']=='' ){
                $this->error('仓库名称不能为空');
            }
            

            $rs=$Warehouse->create($data,1);
            if($rs){
                $result = $Warehouse->add(); 
                if($result){
                   $this->success('添加成功',U('Mp/Warehouse/index'),'',2);
                }else{
                   $this->error('添加失败','',1);
                }
            }else{
                $this->error('添加失败','',1);
            }
        }
    }
    //删除仓库
    public function whdel(){
        $this->check_qypurview('11002',1);

        $map['wh_id']=intval(I('get.wh_id',0));
        $map['wh_unitcode']=session('unitcode');
        $Warehouse= M('Warehouse');
        $data=$Warehouse->where($map)->find();

        if($data){
            //验证是否要删除 要保持数据完整性 
            $Shipment = M('Shipment');
            $map2['ship_unitcode']=session('unitcode');
            $map2['ship_whid']=$data['wh_id'];
            $dcount = $Shipment->where($map2)->count();
            if($dcount>0){
                $this->error('该仓库已应用到出货上，暂不能删除','',1);
            }

            //记录日志 begin
            $log_arr=array(
                        'log_qyid'=>session('qyid'),
                        'log_user'=>session('qyuser'),
                        'log_qycode'=>session('unitcode'),
                        'log_action'=>'删除仓库',
						'log_type'=>1, //0-系统 1-企业 2-经销商 3-消费者
                        'log_addtime'=>time(),
                        'log_ip'=>real_ip(),
                        'log_link'=>__SELF__,
                        'log_remark'=>json_encode($data)
                        );
            save_log($log_arr);
            //记录日志 end

            $Warehouse->where($map)->delete(); 
            $this->success('删除成功',U('Mp/Warehouse/index'),'',2);
        }else{
            $this->error('没有该记录','',1);
        }     
    }
}