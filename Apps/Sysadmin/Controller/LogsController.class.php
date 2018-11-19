<?php
namespace Sysadmin\Controller;
use Think\Controller;
class LogsController extends CommController {

    //操作日志
    public function index(){
        if (IS_POST) {
            $qycode=I('post.qycode','');
            $begintime=I('post.begintime','');
            $endtime=I('post.endtime','');
        }else{
            $qycode=I('get.qycode','');
            $begintime=I('get.begintime','');
            $endtime=I('get.endtime','');
        }
        $parameter=array();

        if($qycode!=''){
            if(!preg_match("/^[0-9]{1,4}$/",$qycode)){
                $this->error('请正确输入企业码','',1);
            }
        }
		
        $keyword=trim(strip_tags(htmlspecialchars_decode(I('post.keyword',''))));

        if($keyword!=''){
            $keyword=str_replace('[','',$keyword);
            $keyword=str_replace(']','',$keyword);
            $keyword=str_replace('%','',$keyword);
            $keyword=str_replace('_','',$keyword);
            
            $keyword=sub_str($keyword,50,false);
            $where['log_user']=$keyword;
            $where['log_action']=$keyword;
			$where['log_remark']=array('LIKE', '%'.$keyword.'%');
            $where['_logic'] = 'or';
            $map['_complex'] = $where;
			$parameter['keyword']=urlencode($keyword);
        }
		
        if($begintime=='' || $endtime==''){
            $begintime=strtotime("24 hours ago");
            $endtime=strtotime("now");
        }else{
            $begintime=strtotime($begintime);
            $endtime=strtotime($endtime);
            if($begintime===FALSE || $endtime===FALSE){
                $this->error('请选择查询日期','',1);
            }
            $endtime=$endtime+3600*24-1;
            if($begintime>=$endtime){
                $this->error('查询结束日期要大于开始日期','',1);
            }
        }

        $Log = M('Log');
        if($qycode!=''){
            $map['log_qycode']=$qycode;
            $parameter['qycode']=urlencode($qycode);
        }
        if(I('param.begintime','')=='' || I('param.endtime','')==''){

        }else{
            $map['log_addtime']=array('between',array($begintime,$endtime));
            $parameter['begintime']=urlencode(date('Y-m-d',$begintime));
            $parameter['endtime']=urlencode(date('Y-m-d',$endtime));
        }
        
        $count = $Log->where($map)->count();
        $Page = new \Think\Page($count, C('PAGE_SIZE'),$parameter);
        $show = $Page->show();
        $list = $Log->where($map)->order('log_addtime DESC')->limit(($Page->firstRow . ',') . $Page->listRows)->select();

        foreach($list as $k=>$v){

            if($v['log_qyid']==0){
                $list[$k]['log_user']=$v['log_user'].'(系统)';
            }else{
                $list[$k]['log_user']=$v['log_user'];
            }

            if($v['log_remark']!=''){
                $list[$k]['log_remark']=json_decode($v['log_remark'],true);
            }

        }
        $this->assign('list', $list);

        $this->assign('keyword', $keyword);
		$this->assign('qycode', $qycode);
        $this->assign('begintime', date('Y-m-d',$begintime));
        $this->assign('endtime', date('Y-m-d',$endtime));


        $this->assign('page', $show);
        $this->assign('curr', 'logs');

        $this->display('index');
    }

  
}