<?php
namespace Kangli\Controller;
use Think\Controller;
class VideoController extends CommController {
    //买家秀
    public function index(){
        $Jfproduct = M('Jfproduct');
        $map['pro_unitcode']=$this->qy_unitcode;
        $map['pro_active']=1;
        $count = $Jfproduct->where($map)->count();
        $Page = new \Think\Page($count, 20);
        $show = $Page->show();
        if($show=='<div>    </div>'){
            $show='';
        }
        $list = $Jfproduct->where($map)->order('pro_addtime DESC')->limit(($Page->firstRow . ',') . $Page->listRows)->select();

        foreach($list as $k=>$v){ 
            $list[$k]['pro_pic_str']='<img src="'.__ROOT__.'/Public/uploads/mobi/'.$v['pro_pic'].'"  border="0">';
        }
        $this->assign('list', $list);
        $this->assign('page', $show);

        $this->display('index');
    }


}