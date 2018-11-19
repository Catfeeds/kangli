<?php
namespace Kangli\Controller;
use Think\Controller;
class XiuController extends CommController {
    //买家秀
    public function index(){
        $Jfmonews = M('Jfmonews');
        $map['news_unitcode']=$this->qy_unitcode;
        $map['news_type']=2;
        $count = $Jfmonews->where($map)->count();
        $Page = new \Think\Page($count, 20);
        $show = $Page->show();
         if($show=='<div>    </div>'){
            $show='';
        }
        $list = $Jfmonews->where($map)->order('news_addtime DESC')->limit(($Page->firstRow . ',') . $Page->listRows)->select();

        foreach($list as $k=>$v){ 
            if($v['news_pic']!=''){
                $list[$k]['news_pic_str']='<img src="'.__ROOT__.'/Public/uploads/mobi/'.$v['news_pic'].'"  border="0">';
            }else{
                $list[$k]['news_pic_str']='';
            }

            $list[$k]['news_content_s']='　　'.sub_str(str_replace("\s",'',str_replace("\r",'',str_replace(' ','',str_replace("\n",'',str_replace('    ','',str_replace('&nbsp;','',str_replace('　','',strip_tags($v['news_content'])))))))),150);
        

        }

        $this->assign('list', $list);
        $this->assign('page', $show);
        $this->display('index');
    }

    //详情
    public function detail(){
        $map['news_id']=intval(I('get.news_id',0));
        $map['news_unitcode']=$this->qy_unitcode;
        $Jfmonews= M('Jfmonews');
        $data=$Jfmonews->where($map)->find();
        if($data){
           if($data['news_pic']!=''){
                $data['news_pic_str']='<img src="'.__ROOT__.'/Public/uploads/mobi/'.$data['news_pic'].'"  border="0"  style="width:100%" >';
            }else{
                $data['news_pic_str']='';
            }   
            
        }

        $this->assign('newsinfo', $data);
        $this->display('detail');
    }
}