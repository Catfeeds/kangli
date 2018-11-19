<?php
namespace Kangli\Controller;
use Think\Controller;
class NewsController extends CommController {
    //企业动态
    public function index(){

        $news_type==intval(I('get.news_type',1));

        $Jfmonews = M('Jfmonews');
        $map['news_unitcode']=$this->qy_unitcode;
        $map['news_type']=1;
        $count = $Jfmonews->where($map)->count();
        $Page = new \Think\Page($count, 20);
        $show = $Page->show();
         if($show=='<div>    </div>'){
            $show='';
        }
        $list = $Jfmonews->where($map)->order('news_addtime DESC')->limit(($Page->firstRow . ',') . $Page->listRows)->select();
        $imgpath = BASE_PATH.'/public/uploads/mobi/';
//		dump($list);die();
        foreach($list as $k=>$v){ 

			if($v['news_pic']!='' && file_exists($imgpath.$v['news_pic']) ){
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

    //动态详情
    public function detail(){
        $map['news_id']=intval(I('get.news_id',0));
        $map['news_unitcode']=$this->qy_unitcode;
        $Jfmonews= M('Jfmonews');
        $data=$Jfmonews->where($map)->find();
        $news_type=0;
        if($data){
            $news_type=$data['news_type'];
			$imgpath = BASE_PATH.'/public/uploads/mobi/';
           if($data['news_pic']!='' && file_exists($imgpath.$data['news_pic']) ){
                $data['news_pic_str']='<img src="'.__ROOT__.'/Public/uploads/mobi/'.$data['news_pic'].'"  border="0"  style="width:100%" >';
            }else{
                $data['news_pic_str']='';
            }   
            
        }

        if ($news_type==7)
            $title='活动详情';
        else if ($news_type==2)
            $title='买家秀';
        else if ($news_type==4)
             $title='素材圈';
        else
             $title='新闻动态';
        $this->assign('title',$title);
        $this->assign('newsinfo', $data);
        $this->display('detail');
    }

    //动态列表
    public function getNewList()
    {
        $pageNum=intval(I('post.page',1));
        $pageCount=intval(I('post.count',20));
        $Jfmonews = M('Jfmonews');
        $map['news_unitcode']=$this->qy_unitcode;
        $map['news_type']=1;
        // $count = $Jfmonews->where($map)->count();
        // $Page = new \Think\Page($count, 20);
        // $show = $Page->show();
        //  if($show=='<div>    </div>'){
        //     $show='';
        // }
        $list = $Jfmonews->where($map)->order('news_addtime DESC')->limit(($pageNum-1)*$pageCount,$pageNum*$pageCount)->select();
        $imgpath = BASE_PATH.'/public/uploads/mobi/';
        if($list){
            foreach($list as $k=>$v){ 
                if($v['news_pic']!='' && file_exists($imgpath.$v['news_pic']) ){
                    $list[$k]['news_pic_str']='<img src="'.__ROOT__.'/Public/uploads/mobi/'.$v['news_pic'].'"  border="0">';
                }else{
                    $list[$k]['news_pic_str']='';
                }

                $list[$k]['news_content_s']='　　'.sub_str(str_replace("\s",'',str_replace("\r",'',str_replace(' ','',str_replace("\n",'',str_replace('    ','',str_replace('&nbsp;','',str_replace('　','',strip_tags($v['news_content'])))))))),150);
            }
            $msg=array('stat'=>'1','msg'=>'','list'=>$list);
            echo json_encode($msg);
            exit;
        }
        else
        {
            $msg=array('stat'=>'1','msg'=>'暂无数据','list'=>'[]');
            echo json_encode($msg);
            exit;
        }
    }

    //活动列表
    public function huodong()
    {
        $news_type=intval(I('get.news_type',1));
        if ($news_type==7)
        {
            $title="商家活动";
            if(!$this->is_jxuser_login()){
            $qy_fwkey=$this->qy_fwkey;
            $qy_fwsecret=$this->qy_fwsecret;
            $ttamp2=time();
            $sture2=MD5($qy_fwkey.$ttamp2.$qy_fwsecret);
            $tagpage='http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
            header('location:'.WWW_WEBROOT.'Kangli/Dealer/login/ttamp/'.$ttamp2.'/sture/'.$sture2.'/tagpage/'.base64_encode($tagpage).'');
            }
        }else if ($news_type==2)
        {
            $title="买家秀";
        }else if ($news_type==4)
        {
            $title="素材圈";
            if(!$this->is_jxuser_login()){
            $qy_fwkey=$this->qy_fwkey;
            $qy_fwsecret=$this->qy_fwsecret;
            $ttamp2=time();
            $sture2=MD5($qy_fwkey.$ttamp2.$qy_fwsecret);
            $tagpage='http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
            header('location:'.WWW_WEBROOT.'Kangli/Dealer/login/ttamp/'.$ttamp2.'/sture/'.$sture2.'/tagpage/'.base64_encode($tagpage).'');
            }
        }else
        {
            $title="新闻动态";
        }

        $Jfmonews = M('Jfmonews');
        $map['news_unitcode']=$this->qy_unitcode;
        $map['news_type']=$news_type;
        $count = $Jfmonews->where($map)->count();
        $Page = new \Think\Page($count, 20);
        $show = $Page->show();
         if($show=='<div>    </div>'){
            $show='';
        }
        $list = $Jfmonews->where($map)->order('news_addtime DESC')->limit(($Page->firstRow . ',') . $Page->listRows)->select();
        $imgpath = BASE_PATH.'/public/uploads/mobi/';
        $index=0;
        foreach($list as $k=>$v){ 
            $list[$k]['news_index']=$index;
            $index++;
            if(is_not_null($v['news_pic']) && file_exists($imgpath.$v['news_pic'])){
                    $list[$k]['news_pic_str']=__ROOT__.'/Public/uploads/mobi/'.$v['news_pic'];
            }else{
                    $list[$k]['news_pic_str']='';
            }
            $list[$k]['news_content_s']='　　'.sub_str(str_replace("\s",'',str_replace("\r",'',str_replace(' ','',str_replace("\n",'',str_replace('    ','',str_replace('&nbsp;','',str_replace('　','',strip_tags($v['news_content'])))))))),150);
        }
        $this->assign('title', $title);
        $this->assign('news_type', $news_type);
        $this->assign('list', $list);
        $this->assign('page', $show);
        $this->display('huodong');
    }
}