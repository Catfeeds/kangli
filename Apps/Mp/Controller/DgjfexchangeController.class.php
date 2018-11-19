<?php
namespace Mp\Controller;
use Think\Controller;
//导购礼品兑换
class DgjfexchangeController extends CommController {
	//礼品兑换列表
    public function index(){
        $this->check_qypurview('12007',1);

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

        $Dgjfexchange = M('Dgjfexchange');
        $map['exch_unitcode']=session('unitcode');
        $count = $Dgjfexchange->where($map)->count();
        $Page = new \Think\Page($count, C('PAGE_SIZE'));
        $show = $Page->show();
        $list = $Dgjfexchange->where($map)->order('exch_id DESC')->limit(($Page->firstRow . ',') . $Page->listRows)->select();
        
        $Dgjfexchdetail = M('Dgjfexchdetail');
        foreach($list as $k=>$v){ 
            $map2=array();
            $map2['detail_unitcode']=session('unitcode');
            $map2['detail_exchid'] = $v['exch_id'];
            $exchdetail = $Dgjfexchdetail->where($map2)->select();
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
                $list[$k]['exch_state_str']='<span style="color:#00FF00">无效</span>';
            }
        }
        $this->assign('list', $list);

        $this->assign('page', $show);
		$this->assign('pagecount', $count);
        $this->assign('curr', 'dgjfexchange_list');

        $this->display('list');
    }

    public function view(){
        $this->check_qypurview('12007',1);

        $map['exch_id']=intval(I('get.exch_id',0));
        $map['exch_unitcode']=session('unitcode');
        $Dgjfexchange= M('Dgjfexchange');
        $data=$Dgjfexchange->where($map)->find();
        $Dgjfexchdetail = M('Dgjfexchdetail');
        if($data){
            $map2=array();
            $map2['detail_unitcode']=session('unitcode');
            $map2['detail_exchid'] = $data['exch_id'];
            $exchdetail = $Dgjfexchdetail->where($map2)->select();

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
        $this->assign('curr', 'jfexchange_list');

        $this->display('view');
    }

    //处理
    public function deal(){
        $this->check_qypurview('12007',1);

        $map['exch_id']=intval(I('get.exch_id',0));
        $map['exch_unitcode']=session('unitcode');
        $Dgjfexchange= M('Dgjfexchange');
        $data=$Dgjfexchange->where($map)->find();
        $Dgjfexchdetail = M('Dgjfexchdetail');
        if($data){
            $map2=array();
            $map2['detail_unitcode']=session('unitcode');
            $map2['detail_exchid'] = $data['exch_id'];
            $exchdetail = $Dgjfexchdetail->where($map2)->select();

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
        $this->assign('curr', 'jfexchange_list');

        $this->display('deal');
    }


    //保存处理
    public function deal_save(){
        $this->check_qypurview('12007',1);

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
            $Dgjfexchange= M('Dgjfexchange');
            $rs=$Dgjfexchange->where($map)->data($data)->save();
           
            if($rs){
                //记录日志 begin
                $log_arr=array(
                            'log_qyid'=>session('qyid'),
                            'log_user'=>session('qyuser'),
                            'log_qycode'=>session('unitcode'),
                            'log_action'=>'处理导购兑换',
							'log_type'=>1, //0-系统 1-企业 2-经销商 3-消费者
                            'log_addtime'=>time(),
                            'log_ip'=>real_ip(),
                            'log_link'=>__SELF__,
                            'log_remark'=>json_encode(array_merge($data,$map))
                            );
                save_log($log_arr);
                //记录日志 end
                $this->success('处理成功',U('Mp/Dgjfexchange/view/exch_id/'.$map['exch_id']),1);
            }else{
               $this->error('处理失败','',1);
            }

        }else{
            $this->error('没有该记录','',2);
        }

    }

    //=====================================================================================


}