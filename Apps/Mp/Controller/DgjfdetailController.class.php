<?php
namespace Mp\Controller;
use Think\Controller;
//导购积分明细
class DgjfdetailController extends CommController {
	//积分明细
    public function index(){
        $this->check_qypurview('12006',1);
        
		$dguser_id=intval(I('get.dguser_id',0));
		$parameter=array();
		if($dguser_id>0){
			$map['dgjf_userid']=$dguser_id;
			$parameter['dguser_id']=$dguser_id;	
		}
		
        $keyword=trim(strip_tags(htmlspecialchars_decode(I('post.keyword',''))));
        if($keyword!=''){
            $keyword=str_replace('[','',$keyword);
            $keyword=str_replace(']','',$keyword);
            $keyword=str_replace('%','',$keyword);
            $keyword=str_replace('_','',$keyword);
            
            $keyword=sub_str($keyword,20,false);
            $where['dgjf_username']=$keyword;
            $where['dgjf_code']=array('LIKE', $keyword.'%');
            $where['_logic'] = 'or';
            $map['_complex'] = $where;
			$parameter['keyword']=$keyword;	
        }

        $Dgjfdetail = M('Dgjfdetail');
        $map['dgjf_unitcode']=session('unitcode');
        $count = $Dgjfdetail->where($map)->count();
        $Page = new \Think\Page($count, C('PAGE_SIZE'),$parameter);
        $show = $Page->show();
        $list = $Dgjfdetail->where($map)->order('dgjf_id DESC')->limit(($Page->firstRow . ',') . $Page->listRows)->select();
        $Dguser= M('Dguser');

        foreach($list as $k=>$v){
            $map2=array();
            $map2['dguser_unitcode']=session('unitcode');
            $map2['dguser_id'] = $v['dgjf_userid'];
            $data2 = $Dguser->where($map2)->find();
            if($data2){
                  $list[$k]['dgjf_user_truename']=$data2['dguser_truename'];
            }else{
                  $list[$k]['dgjf_user_truename']='用户已删';
            }
            //jf_type 积分类型 1--5增加积分  6-9消费积分
            if($v['dgjf_type']==1){
                $list[$k]['dgjf_detailstr']='销售产品获得'.$v['dgjf_jf'].'积分<br>产品：'.$v['dgjf_proname'].$v['dgjf_pronumber'];
                $list[$k]['dgjf_typestr']='销售产品积分';
                $list[$k]['dgjf_jf']='+'.$v['dgjf_jf'];
            }elseif($v['dgjf_type']==6){
                $list[$k]['dgjf_detailstr']='兑换礼品使用'.$v['dgjf_jf'].'积分<br>兑换礼品：'.$v['dgjf_proname'];
                $list[$k]['dgjf_typestr']='兑换礼品积分';
                $list[$k]['dgjf_jf']='<span style="color:#FF0000">-'.$v['dgjf_jf'].'</span>';
            }else{
                $list[$k]['dgjf_typestr']='其他';
                $list[$k]['dgjf_detailstr']='';
            }

        }
        $this->assign('list', $list);

        $this->assign('keyword', $keyword);
        $this->assign('page', $show);
		$this->assign('pagecount', $count);
        $this->assign('curr', 'dgjfdetail_list');

        $this->display('list');
    }

    //查看详细
    public function view(){
        $this->check_qypurview('12006',1);
        
        $map['dgjf_id']=intval(I('get.dgjf_id',0));
        $map['dgjf_unitcode']=session('unitcode');
        $Dgjfdetail= M('Dgjfdetail');
        $data=$Dgjfdetail->where($map)->find();
        $Dguser= M('Dguser');
        if($data){
            $map2['dguser_unitcode']=session('unitcode');
            $map2['dguser_id'] = $data['dgjf_userid'];
            $data2 = $Dguser->where($map2)->find();
            if($data2){
                  $data['dgjf_user_truename']=$data2['dguser_truename'];
            }else{
                  $data['dgjf_user_truename']='用户已删';
            }
            //dgjf_type 积分类型 1--5增加积分  6-9消费积分
            if($data['dgjf_type']==1){
                $data['dgjf_typestr']='销售产品积分';
                $data['dgjf_jf']='+'.$data['dgjf_jf'];
            }elseif($data['dgjf_type']==6){
                $data['dgjf_typestr']='兑换礼品积分';
                $data['dgjf_jf']='-'.$data['dgjf_jf'];
            }else{
                $data['dgjf_typestr']='其他';
            }
        }else{
            $this->error('没有该记录');
        }

        $this->assign('dgjfdetailinfo', $data);
        $this->assign('curr', 'dgjfdetail_list');

        $this->display('view');
    }


    //=====================================================================================


}