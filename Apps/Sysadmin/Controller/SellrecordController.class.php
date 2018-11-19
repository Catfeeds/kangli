<?php
namespace Sysadmin\Controller;
use Think\Controller;
//发行记录
class SellrecordController extends CommController {
    public function index(){
        $keyword=trim(strip_tags(htmlspecialchars_decode(I('param.keyword',''))));
        $parameter=array();
        $map=array();
        if($keyword!=''){
            $keyword=str_replace('[','',$keyword);
            $keyword=str_replace(']','',$keyword);
            $keyword=str_replace('%','',$keyword);
            $keyword=str_replace('_','',$keyword);

            $keyword=sub_str($keyword,20,false);
            $where['unitcode']=array('LIKE', ''.$keyword.'%');
            $where['_logic'] = 'or';
            $map['_complex'] = $where;
            $parameter['keyword']=urlencode($keyword);
        }


        $Sellrecord = M('Sellrecord');
        $count = $Sellrecord->where($map)->count();
        $Page = new \Think\Page($count, C('PAGE_SIZE'),$parameter);
        $show = $Page->show();
        $list = $Sellrecord->where($map)->order('unitcode DESC,fid ASC')->limit(($Page->firstRow . ',') . $Page->listRows)->select();
        $Qyinfo = M('Qyinfo');

        foreach($list as $k=>$v){
            $map2=array();
            $map2['qy_code']=$v['unitcode'];
            $data2 = $Qyinfo->where($map2)->find();
            if($data2){
                  $list[$k]['qy_name']=$data2['qy_name'];
            }else{
                  $list[$k]['qy_name']='';
            }
            $list[$k]['selldatetime']=str_replace('00:00:00','',$v['selldatetime']);
        }
        $this->assign('list', $list);

        $this->assign('keyword', $keyword);

        $this->assign('page', $show);
        $this->assign('curr', 'sellrecord');
        $this->display('index');
    }
	
    //修改备注
    public function remark(){
        if (IS_POST){
            $action=I('post.action','');
        }else{
            $action='';
        }
		if($action=='save'){
			$map['fid']=intval(I('post.fid',0));
			$Sellrecord = M('Sellrecord');
			if($map['fid']>0){
				$data['remark']=I('post.remark','');
				$rs=$Sellrecord->where($map)->data($data)->save();
				if($rs){
					$this->success('修改成功',U('Sysadmin/Sellrecord/index'),1);
				}else{
					$this->error('修改失败','',1);
				}	
			}else{
				$this->error('没有该记录');
			}
			
		}else{
			$map['fid']=intval(I('get.fid',0));
			$Sellrecord = M('Sellrecord');
			$data=$Sellrecord->where($map)->find();
			if($data){

			}else{
				$this->error('没有该记录');
			}
			
			
			$this->assign('srinfo', $data);
			$this->assign('curr', 'sellrecord');
			$this->display('remark');
		}
    }



    //=====================================================================================

}