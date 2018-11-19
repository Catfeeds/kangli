<?php
namespace Mp\Controller;
use Think\Controller;
//经销商管理
class DealerController extends CommController {
    public $list_html; 
	public $referee_lines; //推荐路线
	public $belong_arrs; //有效上家列表上家
	public $dltj_arrs; //有效推荐人列表

	//经销商列表
    public function index(){
        $this->check_qypurview('10001',1);

        $keyword=trim(strip_tags(htmlspecialchars_decode(I('param.keyword',''))));
		$dl_type=intval(I('param.dl_type',0));
		$dl_status=I('param.dl_status','');
		$parameter=array();
		if($dl_status!=''){
			$dl_status=intval($dl_status);
			$map['dl_status']=$dl_status;
			$parameter['dl_status']=$dl_status;
		}
		if($dl_type>0){
			$map['dl_type']=$dl_type;
			$parameter['dl_type']=$dl_type;
		}
        if($keyword!=''){
            $keyword=str_replace('[','',$keyword);
            $keyword=str_replace(']','',$keyword);
            $keyword=str_replace('%','',$keyword);
            $keyword=str_replace('_','',$keyword);
            $keyword=sub_str($keyword,20,false);
            $where['dl_name']=array('LIKE', '%'.$keyword.'%');
            $where['dl_number']=array('LIKE', '%'.$keyword.'%');
            $where['dl_tel']=array('LIKE', '%'.$keyword.'%');
            $where['dl_weixin']=array('LIKE', '%'.$keyword.'%');
			$where['dl_contact']=array('LIKE', '%'.$keyword.'%');
            $where['_logic'] = 'or';
            $map['_complex'] = $where;//搜索框的搜索条件
			$parameter['keyword']=$keyword;
        }
        $map['dl_unitcode']=session('unitcode');
        $Dealer = M('Dealer');
		$Dltype = M('Dltype');
		$Dlsttype = M('Dlsttype');
        $count = $Dealer->where($map)->count();
        $Page = new \Think\Page($count, C('PAGE_SIZE'),$parameter);//$parameter,确保分页之后能够保持原先的查询条件
        $show = $Page->show();
        $list = $Dealer->where($map)->order('dl_id ASC')->limit(($Page->firstRow . ',') . $Page->listRows)->select();
		foreach($list as $k=>$v){
			//经销商级别
			$map2=array();
			$map2['dlt_id']=$v['dl_type'];
			$map2['dlt_unitcode']=session('unitcode');
			$data2 = $Dltype->where($map2)->find();
			if($data2){
				$list[$k]['dl_type_str']=$data2['dlt_name'];
			}else{
				$list[$k]['dl_type_str']='-';
			}
			//级别2
			if($v['dl_sttype']>0){
				
				$map4=array();
				$map4['dlstt_unitcode']=session('unitcode');
				$map4['dlstt_id']=$v['dl_sttype'];
				$data4 = $Dlsttype->where($map4)->find();
				if($data4){
					$list[$k]['dlstt_name']='('.$data4['dlstt_name'].')';
				}else{
					$list[$k]['dlstt_name']='';
				}
			}else{
				$list[$k]['dlstt_name']='';
			}
			//上家代理
			if($v['dl_belong']>0){
				$map2=array();
				$map2['dl_id']=$v['dl_belong'];
				$map2['dl_unitcode']=session('unitcode');
				$data2=$Dealer->where($map2)->find();
				if($data2){
					$list[$k]['dl_belong_str']=$data2['dl_name'].'('.$data2['dl_username'].')';
				}else{
					$list[$k]['dl_belong_str']='-';
				}
			}else{
				$list[$k]['dl_belong_str']='总公司';
			}
			//有效时间
			if($v['dl_startdate']>0 && $v['dl_enddate']>0){
				if(($v['dl_enddate']-time())<3600*24*30){
				    $list[$k]['dl_date_str']=date('Y-m-d',$v['dl_startdate']).'<br><span style="color:#FF0000">'.date('Y-m-d',$v['dl_enddate']).'</span>';
				}else{
					$list[$k]['dl_date_str']=date('Y-m-d',$v['dl_startdate']).'<br>'.date('Y-m-d',$v['dl_enddate']);
				}
			}else{
				$list[$k]['dl_date_str']='-';
			}
			 //0-待审 1-已审 2-代理已审(预留) 9-禁用
			if($v['dl_status']==0){
				$list[$k]['dl_status_str']='<img src="'.__ROOT__.'/public/mp/static/new.gif" />';
			}else if($v['dl_status']==1){
				$list[$k]['dl_status_str']='<img src="'.__ROOT__.'/public/mp/static/yes.gif" />';
			}else if($v['dl_status']==2){
				$list[$k]['dl_status_str']='代理已审';
			}else if($v['dl_status']==9){
				$list[$k]['dl_status_str']='<img src="'.__ROOT__.'/public/mp/static/no.gif" />';
			}else{
				$list[$k]['dl_status_str']='-';
			}

			$list[$k]['dl_wxnickname']=wxuserTextDecode2($v['dl_wxnickname']);
		}
		
		
        //分类列表
		$map2=array();
        $map2['dlt_unitcode']=session('unitcode');
        $list2 = $Dltype->where($map2)->order('dlt_level ASC,dlt_id ASC')->select();
        $this->assign('dltypelist', $list2);
		$this->assign('dl_type', $dl_type);
        $this->assign('dl_status', $dl_status);
        $this->assign('list', $list);
        $this->assign('page', $show);
		$this->assign('pagecount', $count);
        $this->assign('curr', 'dealer_list');
        $this->display('list');
    }
    //经销商架构树
    public function tree(){
        $this->check_qypurview('90003',1);
        $map['dl_belong']=0;
        $map['dl_unitcode']=session('unitcode');
        $Dealer = M('Dealer');
        $count = $Dealer->where($map)->count();
        $Page = new \Think\Page($count,200);
        $show = $Page->show();
        $list = $Dealer->where($map)->order('dl_type ASC,dl_id ASC')->limit(($Page->firstRow . ',') . $Page->listRows)->select();
        $Dltype = M('Dltype');
        foreach($list as $k=>$v){	
            //经销商分类级别
			$map2=array();
			$map2['dlt_id']=$v['dl_type'];
			$map2['dlt_unitcode']=session('unitcode');
			$data2 = $Dltype->where($map2)->find();
			if($data2){
				$list[$k]['dl_type_str']='('.$data2['dlt_name'].')';
			}else{
				$list[$k]['dl_type_str']='';
			}
            //直接下线数

            $map3=array();
            $map3['dl_belong']=$v['dl_id'];
            $map3['dl_unitcode']=session('unitcode');
            $count3 = $Dealer->where($map3)->count();
            $list[$k]['dl_subcount']=$count3;
           //当前状态
            if($v['dl_status']==0){
				$list[$k]['dl_status_str']='[<span style="color:#009900" >新</span>]';
			}else if($v['dl_status']==1){
				$list[$k]['dl_status_str']='[正常]';
			}else if($v['dl_status']==2){
				$list[$k]['dl_status_str']='[代理已审]';
			}else if($v['dl_status']==9){
				$list[$k]['dl_status_str']='[<span style="color:#FF0000" >禁用</span>]';
			}else{
				$list[$k]['dl_status_str']='[未知]';
			}
        }
//        dump($list);die();
		//按dl_subcount从大到小排序
//        count($list)=3;
		$flag=false;
		for($i=1;$i<count($list);$i++){
			for($j=0;$j<count($list)-$i;$j++){
				if($list[$j]['dl_subcount']<$list[$j+1]['dl_subcount']){
					$temp=$list[$j];
					$list[$j]=$list[$j+1];
					$list[$j+1]=$temp;
					$flag=true;
				}
			}
			if(!$flag){
				break;
			}
			$flag=false;
		}
//		dump($list);die();
//      dump(count($list));die();
        foreach($list as $k=>$v){
            $this->list_html.='<li>';
            //下线记录
            if($v['dl_subcount']>0){
                $this->list_html.='<img  src="'.__ROOT__.'/Public/mp/static/menu_plus.gif"  onClick="toggleCollapse(\'#s'.$v['dl_id'].'\',this)"   /> <a href="'.U('Mp/Dealer/treedetail?dl_id='.$v['dl_id']).'"  target="dealerframe"  >'.htmlspecialchars($v['dl_name']).'('.htmlspecialchars($v['dl_username']).')</a>'.htmlspecialchars($v['dl_type_str']).$v['dl_status_str'].' ('.$v['dl_subcount'].')';
                $this->list_html.='<ul id="s'.$v['dl_id'].'" class="treeitem">';
                $this->treesub($v['dl_id']);
                $this->list_html.='</ul>';
            }else{
                $this->list_html.='<img  src="'.__ROOT__.'/Public/mp/static/menu_arrow.gif"  /> <a href="'.U('Mp/Dealer/treedetail?dl_id='.$v['dl_id']).'"  target="dealerframe"  >'.htmlspecialchars($v['dl_name']).'('.htmlspecialchars($v['dl_username']).')</a>'.htmlspecialchars($v['dl_type_str']).$v['dl_status_str'].'';         
            }
            $this->list_html.='</li>';
        }
        $this->assign('list_html', $this->list_html);
        $this->assign('page', $show);
        $this->assign('curr', 'dealer_list');
        $this->display('tree');
    }
   //经销商架构树递归
    public function treesub($dlid){
        $this->check_qypurview('90003',1);
        $map=array();
        $map['dl_belong']=intval($dlid);
        $map['dl_unitcode']=session('unitcode');
        $Dealer = M('Dealer');
        $list = $Dealer->where($map)->order('dl_type ASC,dl_id DESC')->select();
        $Dltype = M('Dltype');
		
        foreach($list as $k=>$v){	
            //直接下线数
            $map3=array();
            $map3['dl_belong']=$v['dl_id'];
            $map3['dl_unitcode']=session('unitcode');
            $count3 = $Dealer->where($map3)->count();
            $list[$k]['dl_subcount']=$count3;
			$list[$k]['dl_wxnickname']=wxuserTextDecode2($v['dl_wxnickname']);
            //当前状态
            if($v['dl_status']==0){
				$list[$k]['dl_status_str']='[<span style="color:#009900" >新</span>]';
			}else if($v['dl_status']==1){
				$list[$k]['dl_status_str']='[正常]';
			}else if($v['dl_status']==2){
				$list[$k]['dl_status_str']='[代理已审]';
			}else if($v['dl_status']==9){
				$list[$k]['dl_status_str']='[<span style="color:#FF0000" >禁用</span>]';
			}else{
				$list[$k]['dl_status_str']='[未知]';
			}
			
			//经销商分类
			$map2=array();
			$map2['dlt_id']=$v['dl_type'];
			$map2['dlt_unitcode']=session('unitcode');
			$data2 = $Dltype->where($map2)->find();
			if($data2){
				$list[$k]['dl_type_str']=' ('.$data2['dlt_name'].')';
			}else{
				$list[$k]['dl_type_str']='';
			}
			
        }
		
		//按dl_subcount从大到小排序
		$flag=false;
		for($i=1;$i<count($list);$i++){
			for($j=0;$j<count($list)-$i;$j++){
				if($list[$j]['dl_subcount']<$list[$j+1]['dl_subcount']){
					$temp=$list[$j];
					$list[$j]=$list[$j+1];
					$list[$j+1]=$temp;
					$flag=true;
				}
			}
			if(!$flag){
				break;
			}
			$flag=false;
		}
        foreach($list as $k=>$v){
            $this->list_html.='<li>';
             //下线记录
            if($v['dl_subcount']>0){
                $this->list_html.='<img  src="'.__ROOT__.'/Public/mp/static/menu_plus.gif"  onClick="toggleCollapse(\'#s'.$v['dl_id'].'\',this)"   /> <a href="'.U('Mp/Dealer/treedetail?dl_id='.$v['dl_id']).'"  target="dealerframe"  >'.htmlspecialchars($v['dl_name']).'('.htmlspecialchars($v['dl_username']).')</a>'.htmlspecialchars($v['dl_type_str']).$v['dl_status_str'].' ('.$v['dl_subcount'].')';
                $this->list_html.='<ul id="s'.$v['dl_id'].'" class="treeitem">';
                $this->treesub($v['dl_id']);
                $this->list_html.='</ul>';
                
            }else{
                $this->list_html.='<img  src="'.__ROOT__.'/Public/mp/static/menu_arrow.gif"  /> <a href="'.U('Mp/Dealer/treedetail?dl_id='.$v['dl_id']).'"  target="dealerframe"  >'.htmlspecialchars($v['dl_name']).'('.htmlspecialchars($v['dl_username']).')</a>'.htmlspecialchars($v['dl_type_str']).$v['dl_status_str'].'';         
            }

            $this->list_html.='</li>';
            
        }
    }
   
   //经销商结构树-经销商详细
    public function treedetail(){
        $this->check_qypurview('90003',1);
        $map['dl_id']=intval(I('get.dl_id',0));
        $map['dl_unitcode']=session('unitcode');
        $Dealer= M('Dealer');
        $data=$Dealer->where($map)->find();
        if($data){
             if(!is_not_null($data['dl_openid'])){
                 $data['dl_openid']='';
             }
             if(!is_not_null($data['dl_weixin'])){
                 $data['dl_weixin']='';
             }
             if(!is_not_null($data['dl_wxnickname'])){
                 $data['dl_wxnickname']='';
             }
             if(!is_not_null($data['dl_username'])){
                 $data['dl_username']='';
             }
			 $data['dl_wxnickname']=wxuserTextDecode2($data['dl_wxnickname']);
			//经销商分类
			$map2=array();
			$map2['dlt_unitcode']=session('unitcode');
			$map2['dlt_id'] = $data['dl_type'];
			$Dltype = M('Dltype');
			$dltypeinfo = $Dltype->where($map2)->find();
			if($dltypeinfo){
				$data['dl_type_str']=$dltypeinfo['dlt_name'];
			}else{
				$data['dl_type_str']='-';
			}
			
			//级别2
			if($data['dl_sttype']>0){
				$Dlsttype = M('Dlsttype');
				$map4=array();
				$map4['dlstt_unitcode']=session('unitcode');
				$map4['dlstt_id']=$data['dl_sttype'];
				$data4 = $Dlsttype->where($map4)->find();
				if($data4){
					$data['dlstt_name']=$data4['dlstt_name'];
				}else{
					$data['dlstt_name']='';
				}
			}else{
				$data['dlstt_name']='';
			}
			//上级经销商
			if($data['dl_belong']>0){
				$map2=array();
				$map2['dl_id'] =  $data['dl_belong'];
				$map2['dl_unitcode']=session('unitcode');
				$data2 = $Dealer->where($map2)->find();
				if($data2){
					$map3=array();
					$map3['dlt_unitcode']=session('unitcode');
					$map3['dlt_id'] = $data2['dl_type'];
					$data3 = $Dltype->where($map3)->find();
					if($data3){
						$data['dl_belong_name']=$data2['dl_name'].' ('.$data2['dl_username'].') ('.$data3['dlt_name'].')';
					}else{
						$data['dl_belong_name']=$data2['dl_name'].' ('.$data2['dl_username'].')';
					}
					
					
				}else{
					$data['dl_belong_name']='-';
				}
			}else{
				$data['dl_belong_name']='总公司';
			}
			
			//推荐人
			if($data['dl_referee']>0){
				$map2=array();
				$map2['dl_id'] =  $data['dl_referee'];
				$map2['dl_unitcode']=session('unitcode');
				$data2 = $Dealer->where($map2)->find();
				if($data2){
                    $map3=array();
					$map3['dlt_unitcode']=session('unitcode');
					$map3['dlt_id'] = $data2['dl_type'];
					$data3 = $Dltype->where($map3)->find();
					if($data3){
						$data['dl_referee_name']=$data2['dl_name'].' ('.$data2['dl_username'].') ('.$data3['dlt_name'].')';
					}else{
						$data['dl_referee_name']=$data2['dl_name'].' ('.$data2['dl_username'].')';
					}
				}else{
					$data['dl_referee_name']='-';
				}
			}else{
				$data['dl_referee_name']='总公司';
			}
			
			
			//身份证图片
			$imgpath = BASE_PATH.'/Public/uploads/dealer/';
			if(is_not_null($data['dl_idcardpic']) && file_exists($imgpath.$data['dl_idcardpic'])){
				$arr=getimagesize($imgpath.$data['dl_idcardpic']);
				if(false!=$arr){
					$w=$arr[0];
					$h=$arr[1];
					if($h>100){
					   $hh=100;
					   $ww=($w*100)/$h;
					}else{
					   $hh=$h;
					   $ww=$w;
					}
					if($ww>100){
					   $ww=100;
					   $hh=($h*100)/$w;
					}
					$data['dl_idcardpic_str']='<img src="'.__ROOT__.'/Public/uploads/dealer/'.$data['dl_idcardpic'].'" width="'.$ww.'"  height="'.$hh.'"  border="0" style="vertical-align:middle" >';
				}
				else{
					$data['dl_idcardpic_str']='';
				}
			}else{
				$data['dl_idcardpic_str']='';
			}
			
			if(is_not_null($data['dl_idcardpic2']) && file_exists($imgpath.$data['dl_idcardpic2'])){
				$arr=getimagesize($imgpath.$data['dl_idcardpic2']);
				if(false!=$arr){
					$w=$arr[0];
					$h=$arr[1];
					if($h>100){
					   $hh=100;
					   $ww=($w*100)/$h;
					}else{
					   $hh=$h;
					   $ww=$w;
					}
					if($ww>100){
					   $ww=100;
					   $hh=($h*100)/$w;
					}
					$data['dl_idcardpic2_str']='<img src="'.__ROOT__.'/Public/uploads/dealer/'.$data['dl_idcardpic2'].'" width="'.$ww.'"  height="'.$hh.'"  border="0" style="vertical-align:middle" >';
				}
				else{
					$data['dl_idcardpic2_str']='';
				}
			}else{
				$data['dl_idcardpic2_str']='';
			}
			
			//授权证书
			if(is_not_null($data['dl_pic']) && file_exists($imgpath.$data['dl_pic'])){
				$arr=getimagesize($imgpath.$data['dl_pic']);
				if(false!=$arr){
					$w=$arr[0];
					$h=$arr[1];
					if($h>100){
					   $hh=100;
					   $ww=($w*100)/$h;
					}else{
					   $hh=$h;
					   $ww=$w;
					}
					if($ww>100){
					   $ww=100;
					   $hh=($h*100)/$w;
					}
					$data['dl_pic_str']='<img src="'.__ROOT__.'/Public/uploads/dealer/'.$data['dl_pic'].'" width="'.$ww.'"  height="'.$hh.'"  border="0" style="vertical-align:middle" >';
				}
				else{
					$data['dl_pic_str']='';
				}
			}else{
				$data['dl_pic_str']='';
			}
			
            if($data['dl_startdate']>0 && $data['dl_enddate']>0){
				if(($data['dl_enddate']-time())<3600*24*30){
				    $data['dl_date_str']=date('Y-m-d',$data['dl_startdate']).' --- <span style="color:#FF0000">'.date('Y-m-d',$data['dl_enddate']).'</span>';
				}else{
					$data['dl_date_str']=date('Y-m-d',$data['dl_startdate']).' --- '.date('Y-m-d',$data['dl_enddate']);
				}
			}else{
				$data['dl_date_str']='-';
			}
			

        }else{
            echo '';
            exit;
        }
    
        $this->assign('dealerinfo', $data);

        $this->display('treedetail');


    }
  
  ////////////////////////////////////////////////////////////////////////////
    //添加经销商
    public function add(){
        $this->check_qypurview('10002',1);
        $data['dl_id']=0;
        //经销商分类
        $map['dlt_unitcode']=session('unitcode');
        $Dltype = M('Dltype');
        $list = $Dltype->where($map)->order('dlt_level ASC,dlt_id ASC')->select();
        $this->assign('typelist', $list);
        //上级经销商
        $map2['dl_level'] = array('LT',4);//最大3级
        $map2['dl_unitcode']=session('unitcode');
        $Dealer = M('Dealer');
        $dllist = $Dealer->where($map2)->order('dl_number ASC,dl_id DESC')->select();
        $this->assign('dllist', $dllist);
        $this->assign('curr', 'dealer_list');
        $this->assign('atitle', '添 加');
        $this->assign('dealerinfo', $data);
        $this->display('add');
    }
   //添加直属经销商 扫二维码 微信添加
    public function addzs(){
        $this->check_qypurview('90003',1);
		$map['qy_code']=session('unitcode');
        $Qyinfo = M('Qyinfo');
		$data=$Qyinfo->where($map)->find();
        if($data){
			$qy_folder=$data['qy_folder'];
		}else{
            $this->error('没有该记录');
        }
        //生成二维码
		$timestamp=time();
		$qy_fwkey=$data['qy_fwkey'];
		$qy_fwsecret=$data['qy_fwsecret'];
		$signature=MD5($qy_fwkey.$timestamp.$qy_fwsecret);
		$filepath = BASE_PATH.'/Public/uploads/product/'.session('unitcode').'/qyshare.png';
		if (@is_dir(BASE_PATH.'/Public/uploads/product/'.session('unitcode').'/') === false){
	       @mkdir(BASE_PATH.'/Public/uploads/product/'.session('unitcode').'/');
	    }
	    $http_host=strtolower(htmlspecialchars('http://'.$_SERVER['HTTP_HOST'])).WWW_WEBROOT;
		$link=$http_host.$qy_folder.'/dealer/qyshare/ttamp/'.$timestamp.'/sture/'.$signature;
		make_ercode($link,$filepath,'','');
		$qyshare_pic_str='<img src="'.__ROOT__.'/Public/uploads/product/'.session('unitcode').'/qyshare.png"  border="0"   >';
        $this->assign('curr', 'dealer_list');
        $this->assign('atitle', '添 加');
        $this->assign('qyshare_pic_str', $qyshare_pic_str);
        $this->display('addzs');
    }
    //修改经销商
    public function edit(){
        $this->check_qypurview('10004',1);
		
		$dl_type=intval(I('get.dl_type',0));
		$dl_status=I('get.dl_status','');
		if($dl_status!=''){
			$dl_status=intval($dl_status);
		}
		
		
        $map['dl_id']=intval(I('get.dl_id',0));
        $map['dl_unitcode']=session('unitcode');
        $Dealer= M('Dealer');
        $data=$Dealer->where($map)->find();
        if($data){
             if(!is_not_null($data['dl_openid'])){
                 $data['dl_openid']='';
             }
             if(!is_not_null($data['dl_weixin'])){
                 $data['dl_weixin']='';
             }
             if(!is_not_null($data['dl_wxnickname'])){
                 $data['dl_wxnickname']='';
             }
             if(!is_not_null($data['dl_username'])){
                 $data['dl_username']='';
             }
			 $data['dl_wxnickname']=wxuserTextDecode2($data['dl_wxnickname']);
        }else{
            $this->error('没有该记录');
        }

        //经销商分类
		$map2=array();
        $map2['dlt_unitcode']=session('unitcode');
		$map2['dlt_id'] = $data['dl_type'];
        $Dltype = M('Dltype');
        $dltypeinfo = $Dltype->where($map2)->find();
		if($dltypeinfo){
			$data['dlt_name']=$dltypeinfo['dlt_name'];
		}else{
			$data['dlt_name']='-';
		}
		
        //级别2
		if($data['dl_sttype']>0){
			$Dlsttype = M('Dlsttype');
			$map4=array();
			$map4['dlstt_unitcode']=session('unitcode');
			$map4['dlstt_id']=$data['dl_sttype'];
			$data4 = $Dlsttype->where($map4)->find();
			if($data4){
				$data['dlstt_name']=$data4['dlstt_name'];
			}else{
				$data['dlstt_name']='';
			}
		}else{
			$data['dlstt_name']='';
		}
	
        
        //上级经销商
		if($data['dl_belong']>0){
			$map2=array();
			$map2['dl_id'] =  $data['dl_belong'];
			$map2['dl_unitcode']=session('unitcode');
			$data2 = $Dealer->where($map2)->find();
			if($data2){
				$data['dl_belong_name']=$data2['dl_name'].' ('.$data2['dl_username'].')';
			}else{
				$data['dl_belong_name']='-';
			}
		}else{
			$data['dl_belong_name']='总公司';
		}
		
		//推荐人
		if($data['dl_referee']>0){
			$map2=array();
			$map2['dl_id'] =  $data['dl_referee'];
			$map2['dl_unitcode']=session('unitcode');
			$data2 = $Dealer->where($map2)->find();
			if($data2){
				$data['dl_referee_name']=$data2['dl_name'].' ('.$data2['dl_username'].')';
			}else{
				$data['dl_referee_name']='-';
			}
		}else{
			$data['dl_referee_name']='总公司';
		}
		
		
        //身份证图片
        $imgpath = BASE_PATH.'/Public/uploads/dealer/';
        if(is_not_null($data['dl_idcardpic']) && file_exists($imgpath.$data['dl_idcardpic'])){
            $arr=getimagesize($imgpath.$data['dl_idcardpic']);
            if(false!=$arr){
                $w=$arr[0];
                $h=$arr[1];
                if($h>100){
                   $hh=100;
                   $ww=($w*100)/$h;
                }else{
                   $hh=$h;
                   $ww=$w;
                }
                if($ww>100){
                   $ww=100;
                   $hh=($h*100)/$w;
                }
                $data['dl_idcardpic_str']='<img src="'.__ROOT__.'/Public/uploads/dealer/'.$data['dl_idcardpic'].'" width="'.$ww.'"  height="'.$hh.'"  border="0" style="vertical-align:middle" >';
            }
            else{
                $data['dl_idcardpic_str']='';
            }
        }else{
            $data['dl_idcardpic_str']='';
        }
		
		if(is_not_null($data['dl_idcardpic2']) && file_exists($imgpath.$data['dl_idcardpic2'])){
            $arr=getimagesize($imgpath.$data['dl_idcardpic2']);
            if(false!=$arr){
                $w=$arr[0];
                $h=$arr[1];
                if($h>100){
                   $hh=100;
                   $ww=($w*100)/$h;
                }else{
                   $hh=$h;
                   $ww=$w;
                }
                if($ww>100){
                   $ww=100;
                   $hh=($h*100)/$w;
                }
                $data['dl_idcardpic2_str']='<img src="'.__ROOT__.'/Public/uploads/dealer/'.$data['dl_idcardpic2'].'" width="'.$ww.'"  height="'.$hh.'"  border="0" style="vertical-align:middle" >';
            }
            else{
                $data['dl_idcardpic2_str']='';
            }
        }else{
            $data['dl_idcardpic2_str']='';
        }
		
		//授权证书
		if(is_not_null($data['dl_pic']) && file_exists($imgpath.$data['dl_pic'])){
            $arr=getimagesize($imgpath.$data['dl_pic']);
            if(false!=$arr){
                $w=$arr[0];
                $h=$arr[1];
                if($h>100){
                   $hh=100;
                   $ww=($w*100)/$h;
                }else{
                   $hh=$h;
                   $ww=$w;
                }
                if($ww>100){
                   $ww=100;
                   $hh=($h*100)/$w;
                }
                $data['dl_pic_str']='<img src="'.__ROOT__.'/Public/uploads/dealer/'.$data['dl_pic'].'" width="'.$ww.'"  height="'.$hh.'"  border="0" style="vertical-align:middle" >';
            }
            else{
                $data['dl_pic_str']='';
            }
        }else{
            $data['dl_pic_str']='';
        }

        //股权证书
		if(is_not_null($data['dl_stockpic']) && file_exists($imgpath.$data['dl_stockpic'])){
            $arr=getimagesize($imgpath.$data['dl_stockpic']);
            if(false!=$arr){
                $w=$arr[0];
                $h=$arr[1];
                if($h>100){
                   $hh=100;
                   $ww=($w*100)/$h;
                }else{
                   $hh=$h;
                   $ww=$w;
                }
                if($ww>100){
                   $ww=100;
                   $hh=($h*100)/$w;
                }
                $data['dl_stockpic_str']='<img src="'.__ROOT__.'/Public/uploads/dealer/'.$data['dl_stockpic'].'" width="'.$ww.'"  height="'.$hh.'"  border="0" style="vertical-align:middle" >';
            }
            else{
                $data['dl_stockpic_str']='';
            }
        }else{
            $data['dl_stockpic_str']='';
        }
		
        $this->assign('dl_type', $dl_type);
		$this->assign('dl_status', $dl_status);
		
        $this->assign('dealerinfo', $data);
        $this->assign('curr', 'dealer_list');
        $this->assign('atitle', '修 改');
        if ($data['dl_openid']!='')
        {
        	$this->assign('atitle2', '解绑微信');
        }
        $this->display('edit');
    }
   
   //浏览经销商
    public function view(){
        $this->check_qypurview('10001',1);

        $map['dl_id']=intval(I('get.dl_id',0));
        $map['dl_unitcode']=session('unitcode');
        $Dealer= M('Dealer');
        $data=$Dealer->where($map)->find();
        if($data){
             if(!is_not_null($data['dl_openid'])){
                 $data['dl_openid']='';
             }
             if(!is_not_null($data['dl_weixin'])){
                 $data['dl_weixin']='';
             }
             if(!is_not_null($data['dl_wxnickname'])){
                 $data['dl_wxnickname']='';
             }
             if(!is_not_null($data['dl_username'])){
                 $data['dl_username']='';
             }
            $data['dl_wxnickname']=wxuserTextDecode2($data['dl_wxnickname']);


			//经销商分类
			$map2=array();
			$map2['dlt_unitcode']=session('unitcode');
			$map2['dlt_id'] = $data['dl_type'];
			$Dltype = M('Dltype');
			$dltypeinfo = $Dltype->where($map2)->find();
			if($dltypeinfo){
				$data['dl_type_str']=$dltypeinfo['dlt_name'];
			}else{
				$data['dl_type_str']='-';
			}
			
			//级别2
			if($data['dl_sttype']>0){
				$Dlsttype = M('Dlsttype');
				$map4=array();
				$map4['dlstt_unitcode']=session('unitcode');
				$map4['dlstt_id']=$data['dl_sttype'];
				$data4 = $Dlsttype->where($map4)->find();
				if($data4){
					$data['dlstt_name']=$data4['dlstt_name'];
				}else{
					$data['dlstt_name']='';
				}
			}else{
				$data['dlstt_name']='';
			}
		
			
			//上级经销商
			if($data['dl_belong']>0){
				$map2=array();
				$map2['dl_id'] =  $data['dl_belong'];
				$map2['dl_unitcode']=session('unitcode');
				$data2 = $Dealer->where($map2)->find();
				if($data2){
					$map3=array();
					$map3['dlt_unitcode']=session('unitcode');
					$map3['dlt_id'] = $data2['dl_type'];
					$data3 = $Dltype->where($map3)->find();
					if($data3){
						$data['dl_belong_name']=$data2['dl_name'].' ('.$data2['dl_username'].') ('.$data3['dlt_name'].')';
					}else{
						$data['dl_belong_name']=$data2['dl_name'].' ('.$data2['dl_username'].')';
					}
					
					
				}else{
					$data['dl_belong_name']='-';
				}
			}else{
				$data['dl_belong_name']='总公司';
			}
			
			//推荐人
			if($data['dl_referee']>0){
				$map2=array();
				$map2['dl_id'] =  $data['dl_referee'];
				$map2['dl_unitcode']=session('unitcode');
				$data2 = $Dealer->where($map2)->find();
				if($data2){
                    $map3=array();
					$map3['dlt_unitcode']=session('unitcode');
					$map3['dlt_id'] = $data2['dl_type'];
					$data3 = $Dltype->where($map3)->find();
					if($data3){
						$data['dl_referee_name']=$data2['dl_name'].' ('.$data2['dl_username'].') ('.$data3['dlt_name'].')';
					}else{
						$data['dl_referee_name']=$data2['dl_name'].' ('.$data2['dl_username'].')';
					}
				}else{
					$data['dl_referee_name']='-';
				}
			}else{
				$data['dl_referee_name']='总公司';
			}
			
			
			//身份证图片
			$imgpath = BASE_PATH.'/Public/uploads/dealer/';
			if(is_not_null($data['dl_idcardpic']) && file_exists($imgpath.$data['dl_idcardpic'])){
				$arr=getimagesize($imgpath.$data['dl_idcardpic']);
				if(false!=$arr){
					$w=$arr[0];
					$h=$arr[1];
					if($h>100){
					   $hh=100;
					   $ww=($w*100)/$h;
					}else{
					   $hh=$h;
					   $ww=$w;
					}
					if($ww>100){
					   $ww=100;
					   $hh=($h*100)/$w;
					}
					$data['dl_idcardpic_str']='<img src="'.__ROOT__.'/Public/uploads/dealer/'.$data['dl_idcardpic'].'" width="'.$ww.'"  height="'.$hh.'"  border="0" style="vertical-align:middle" >';
				}
				else{
					$data['dl_idcardpic_str']='';
				}
			}else{
				$data['dl_idcardpic_str']='';
			}
			
			if(is_not_null($data['dl_idcardpic2']) && file_exists($imgpath.$data['dl_idcardpic2'])){
				$arr=getimagesize($imgpath.$data['dl_idcardpic2']);
				if(false!=$arr){
					$w=$arr[0];
					$h=$arr[1];
					if($h>100){
					   $hh=100;
					   $ww=($w*100)/$h;
					}else{
					   $hh=$h;
					   $ww=$w;
					}
					if($ww>100){
					   $ww=100;
					   $hh=($h*100)/$w;
					}
					$data['dl_idcardpic2_str']='<img src="'.__ROOT__.'/Public/uploads/dealer/'.$data['dl_idcardpic2'].'" width="'.$ww.'"  height="'.$hh.'"  border="0" style="vertical-align:middle" >';
				}
				else{
					$data['dl_idcardpic2_str']='';
				}
			}else{
				$data['dl_idcardpic2_str']='';
			}
			
			
			
			//授权证书
			if(is_not_null($data['dl_pic']) && file_exists($imgpath.$data['dl_pic'])){
				$arr=getimagesize($imgpath.$data['dl_pic']);
				if(false!=$arr){
					$w=$arr[0];
					$h=$arr[1];
					if($h>100){
					   $hh=100;
					   $ww=($w*100)/$h;
					}else{
					   $hh=$h;
					   $ww=$w;
					}
					if($ww>100){
					   $ww=100;
					   $hh=($h*100)/$w;
					}
					$data['dl_pic_str']='<img src="'.__ROOT__.'/Public/uploads/dealer/'.$data['dl_pic'].'" width="'.$ww.'"  height="'.$hh.'"  border="0" style="vertical-align:middle" >';
				}
				else{
					$data['dl_pic_str']='';
				}
			}else{
				$data['dl_pic_str']='';
			}
			
            if($data['dl_startdate']>0 && $data['dl_enddate']>0){
				if(($data['dl_enddate']-time())<3600*24*30){
				    $data['dl_date_str']=date('Y-m-d',$data['dl_startdate']).' --- <span style="color:#FF0000">'.date('Y-m-d',$data['dl_enddate']).'</span>';
				}else{
					$data['dl_date_str']=date('Y-m-d',$data['dl_startdate']).' --- '.date('Y-m-d',$data['dl_enddate']);
				}
			}else{
				$data['dl_date_str']='-';
			}
			
			//代理商操作日志
			$Dealerlogs= M('Dealerlogs');
			$map2=array();
			$map2['dlg_unitcode']=session('unitcode');
			$map2['dlg_dlid']=$data['dl_id'];
			$logslist = $Dealerlogs->where($map2)->order('dlg_id DESC')->select();
			foreach($logslist as $k=>$v){
				if($v['dlg_type']==0){
					$logslist[$k]['dlg_operatstr']=$v['dlg_dlusername'].'(公司)';
				}else if($v['dlg_type']==1){
					$logslist[$k]['dlg_operatstr']=$v['dlg_dlusername'].'(代理)';
				}else{
					$logslist[$k]['dlg_operatstr']=$v['dlg_dlusername'];
				}
			}
			$this->assign('logslist', $logslist);
			
        }else{
            $this->error('没有该记录');
        }
	
    
        $this->assign('dealerinfo', $data);
        $this->assign('curr', 'dealer_list');

        $this->display('view');
    }
   
    //删除经销商
    public function delete(){
        $this->check_qypurview('10003',1);

        $map['dl_id']=intval(I('get.dl_id',0));
        $map['dl_unitcode']=session('unitcode');
        $Dealer= M('Dealer');
        $data=$Dealer->where($map)->find();

        if($data){
            //验证是否要删除 要保持数据完整性 
            //是否有下级
			$map2=array();
            $map2['dl_belong']=$data['dl_id'];
            $map2['dl_unitcode']=session('unitcode');
            $data2 = $Dealer->where($map2)->find();
            if($data2){
                $this->error('该经销商含有下级，暂不能删除','',2);
            }
			
			//是否有推荐
			$map2=array();
            $map2['dl_referee']=$data['dl_id'];
            $map2['dl_unitcode']=session('unitcode');
            $data2 = $Dealer->where($map2)->find();
            if($data2){
                $this->error('该经销商含有推荐的代理，暂不能删除','',2);
            }

            //是否有出货记录
            $Shipment = M('Shipment');
			$map3=array();
            $map3['ship_unitcode']=session('unitcode');
            $map3['ship_dealer'] = $data['dl_id'];   //ship_deliver--出货方   ship_dealer--收货方
            $data3=$Shipment->where($map3)->find();
            if($data3){
                $this->error('该经销商含有出货记录，暂不能删除','',2);
            }
			
			//是否有出货记录
			$map3=array();
            $map3['ship_unitcode']=session('unitcode');
            $map3['ship_deliver'] = $data['dl_id'];
            $data3=$Shipment->where($map3)->find();
            if($data3){
                $this->error('该经销商含有出货记录，暂不能删除','',2);
            }
			
			//是否有订单
			$Orders = M('Orders');
			$map3=array();
            $map3['od_unitcode']=session('unitcode');
            $map3['od_oddlid'] = $data['dl_id'];
            $data3=$Orders->where($map3)->find();
            if($data3){
                $this->error('该经销商含有订单，暂不能删除','',2);
            }
			
			//是否有预付款
			$Yufukuan = M('Yufukuan');
			$map3=array();
            $map3['yfk_unitcode']=session('unitcode');
			$where=array();
			$where['yfk_sendid']=$data['dl_id'];
			$where['yfk_receiveid']=$data['dl_id'];
			$where['_logic'] = 'or';
			$map3['_complex'] = $where;
            $data3=$Yufukuan->where($map3)->find();
            if($data3){
                $this->error('该经销商含有预付款记录，暂不能删除','',2);
            }
			
			//是否有余额
			$Balance = M('Balance');
			$map3=array();
            $map3['bl_unitcode']=session('unitcode');
			$where=array();
			$where['bl_sendid']=$data['dl_id'];
			$where['bl_receiveid']=$data['dl_id'];
			$where['_logic'] = 'or';
			$map3['_complex'] = $where;
            $data3=$Balance->where($map3)->find();
            if($data3){
                $this->error('该经销商含有余额记录，暂不能删除','',2);
            }
			
			//删除充值申请
			$Payin = M('Payin');
			$map5=array();
			$map5['pi_unitcode']=session('unitcode');
			$map5['pi_dlid']=$data['dl_id'];
			$data5 = $Payin->where($map5)->select();
			foreach($data5 as $k=>$v){
				@unlink('./Public/uploads/dealer/'.$v['pi_pic']); 
				
				$map6=array();
				$map6['pi_id']=$v['pi_id'];
				$Payin->where($map6)->delete(); 
			}
			
			//删除授权品牌记录
			$Brandattorney = M('Brandattorney');
			$map5=array();
			$map5['ba_unitcode']=session('unitcode');
			$map5['ba_dealerid']=$data['dl_id'];
			$data5 = $Brandattorney->where($map5)->select();
			foreach($data5 as $k=>$v){
				@unlink($upload->rootPath.$v['ba_pic']); 
				
				$map6=array();
				$map6['ba_id']=$v['ba_id'];
				$Brandattorney->where($map6)->delete(); 
			}
			
			//删除邀请记录
			$Sharelinks = M('Sharelinks');
			$map6=array();
			$map6['sl_unitcode']=session('unitcode');
			$map6['sl_dealerid']=$data['dl_id'];
			$Sharelinks->where($map6)->delete(); 
			
			//删除地址
			$Dladdress = M('Dladdress');
			$map6=array();
			$map6['dladd_unitcode']=session('unitcode');
			$map6['dladd_dlid']=$data['dl_id'];
			$Dladdress->where($map6)->delete(); 
			
            @unlink('./Public/uploads/dealer/'.$data['dl_pic']); 
			@unlink('./Public/uploads/product/'.$data['dl_tbsqpic']); 
			@unlink('./Public/uploads/dealer/'.$data['dl_idcardpic']); 
            $Dealer->where($map)->delete(); 

            //记录日志 begin
            $log_arr=array(
                        'log_qyid'=>session('qyid'),
                        'log_user'=>session('qyuser'),
                        'log_qycode'=>session('unitcode'),
                        'log_action'=>'删除经销商',
                        'log_type'=>1, //0-系统 1-企业 2-经销商 3-消费者
						'log_addtime'=>time(),
                        'log_ip'=>real_ip(),
                        'log_link'=>__SELF__,
                        'log_remark'=>json_encode($data)
                        );
            save_log($log_arr);
            //记录日志 end

            $this->success('删除成功','',2);
        }else{
            $this->error('没有该记录','',2);
        }     
    
    }
    
	//审核/设置 经销商
	public function review(){
		$this->check_qypurview('10004',1);
		$dl_type=intval(I('get.dl_type',0));
		$dl_status=I('get.dl_status','');
		if($dl_status!=''){
			$dl_status=intval($dl_status);
		}
        $map['dl_id']=intval(I('get.dl_id',0));
        $map['dl_unitcode']=session('unitcode');
        $Dealer= M('Dealer');
        $data=$Dealer->where($map)->find();
        if($data){
             if(!is_not_null($data['dl_openid'])){
                 $data['dl_openid']='';
             }
             if(!is_not_null($data['dl_weixin'])){
                 $data['dl_weixin']='';
             }
             if(!is_not_null($data['dl_wxnickname'])){
                 $data['dl_wxnickname']='';
             }
             if(!is_not_null($data['dl_username'])){
                 $data['dl_username']='';
             }
            $data['dl_wxnickname']=wxuserTextDecode2($data['dl_wxnickname']);

           //当前状态
            if($data['dl_status']==0){
				$data['dl_status_str']='新注册';
			}else if($data['dl_status']==1){
				$data['dl_status_str']='正常';
			}else if($data['dl_status']==2){
				$data['dl_status_str']='代理已审';
			}else if($data['dl_status']==9){
				$data['dl_status_str']='已禁用';
			}else{
				$data['dl_status_str']='未知';
			}

			//经销商分类级别
			$map2=array();
			$map2['dlt_unitcode']=session('unitcode');
			$map2['dlt_id'] = $data['dl_type'];
			$Dltype = M('Dltype');
			$dltypeinfo = $Dltype->where($map2)->find();
			if($dltypeinfo){
				$data['dl_type_str']=$dltypeinfo['dlt_name'];
			}else{
				$data['dl_type_str']='-';
			}
		
			//当前上家经销商
			if($data['dl_belong']>0){//非总公司
				$map2=array();
				$map2['dl_id'] =  $data['dl_belong'];
				$map2['dl_unitcode']=session('unitcode');
				$data2 = $Dealer->where($map2)->find();
				if($data2){
					$data['dl_belong_name']=$data2['dl_name'].' ('.$data2['dl_username'].')';
				}else{
					$data['dl_belong_name']='-';
				}
			}else{
				$data['dl_belong_name']='总公司';
			}
			
			//推荐人
			$this->referee_lines='';
			if($data['dl_referee']>0){//推荐人非总公司
				$map2=array();
				$map2['dl_id'] = $data['dl_referee'];
				$map2['dl_unitcode']=session('unitcode');
				$data2 = $Dealer->where($map2)->find();
				if($data2){//推荐人存在
					$data['dl_referee_name']=$data2['dl_name'].' ('.$data2['dl_username'].')';
					//推荐人状态
					if($data2['dl_status']==0){
						$dl_referee_status='新';
					}else if($data2['dl_status']==1){
						$dl_referee_status='正常';
					}else if($data2['dl_status']==9){
						$dl_referee_status='禁用';
					}else{
						$dl_referee_status='未知';
					}
					//推荐人级别
					$map2=array();
					$map2['dlt_unitcode']=session('unitcode');
					$map2['dlt_id'] = $data2['dl_type'];
					$dltypeinfo2 = $Dltype->where($map2)->find();
					if($dltypeinfo){
						$dl_referee_type=$dltypeinfo2['dlt_name'];
					}else{
						$dl_referee_type='-';
					}
//					$data为当前经销商，$data2为当前经销商推荐人
					$this->referee_lines=$data['dl_name'].' ('.$data['dl_username'].')('.$data['dl_type_str'].')['.$data['dl_status_str'].'] <- '.$data2['dl_name'].' ('.$data2['dl_username'].')('.$dl_referee_type.')['.$dl_referee_status.']';

					$this->referee_lines.=$this->get_dlrefereelines($data2['dl_id']);

				}else{
					$data['dl_referee_name']='推荐人不存在';
				}
			}else{
				$data['dl_referee_name']='总公司';
			}
			$data['referee_lines']=$this->referee_lines;
			
			$this->belong_arrs=array();
			//有效上家列表
			if($data['dl_referee']>0){
				$map2=array();
				$map2['dl_id'] =  $data['dl_referee'];
				$map2['dl_unitcode']=session('unitcode');
				$data2 = $Dealer->where($map2)->find();
				if($data2){
					if($data2['dl_status']==1){
                        if($data['dl_level']>$data2['dl_level']){ 
						    $this->belong_arrs[]=array('id'=>$data2['dl_id'],'name'=>$data2['dl_name']);
						    if($data2['dl_belong']>0){
							   $this->get_dlbelongarr($data2['dl_belong'],$data['dl_level']);
							}
						}else if($data['dl_level']==$data2['dl_level']){
							if($data2['dl_belong']>0){
							   $this->get_dlbelongarr($data2['dl_belong'],$data['dl_level']);
							}
						}
					}else{
						if($data2['dl_belong']>0){
							$this->get_dlbelongarr($data2['dl_belong'],$data['dl_level']);
						}
					}
				}
				
			}
			$this->belong_arrs[]=array('id'=>0,'name'=>'总公司');
		    krsort($this->belong_arrs);
			$this->assign('belong_arrs', $this->belong_arrs);
            
			
            //有效时间
			if($data['dl_startdate']>0 && $data['dl_enddate']>0){
				
				if(($data['dl_enddate']-time())<3600*24*30){
				    $data['dl_date_str']=date('Y-m-d',$data['dl_startdate']).'<br><span style="color:#FF0000">'.date('Y-m-d',$data['dl_enddate']).'</span>';
				}else{
					$data['dl_date_str']=date('Y-m-d',$data['dl_startdate']).'<br>'.date('Y-m-d',$data['dl_enddate']);
				}
			}else{
				$data['dl_date_str']='-';
			}
			
		    if($data['dl_startdate']>0){
				$begintime=date('Y-m-d',$data['dl_startdate']);
			}else{
				$begintime=date('Y-m-d',time());
			}
			
        //保证金图片
        $imgpath = BASE_PATH.'/Public/uploads/dealer/';
        if(is_not_null($data['dl_depositpic']) && file_exists($imgpath.$data['dl_depositpic'])){
            $arr=getimagesize($imgpath.$data['dl_depositpic']);
            if(false!=$arr){
                $w=$arr[0];
                $h=$arr[1];
                if($h>100){
                   $hh=100;
                   $ww=($w*100)/$h;
                }else{
                   $hh=$h;
                   $ww=$w;
                }
                if($ww>100){
                   $ww=100;
                   $hh=($h*100)/$w;
                }
                $data['dl_depositpic_str']='<img src="'.__ROOT__.'/Public/uploads/dealer/'.$data['dl_depositpic'].'" width="'.$ww.'"  height="'.$hh.'"  border="0" style="vertical-align:middle" >';
            }
            else{
                $data['dl_depositpic_str']='';
            }
        }else{
            $data['dl_depositpic_str']='';
        }
			
        }else{
            $this->error('没有该记录');
        }
		//分类列表
		$map2=array();
        $map2['dlt_unitcode']=session('unitcode');
        $dltypelist = $Dltype->where($map2)->order('dlt_level ASC,dlt_id ASC')->select();
        $this->assign('dltypelist', $dltypelist);
		$this->assign('dl_type', $dl_type);
        $this->assign('dl_status', $dl_status);
		$this->assign('begintime', $begintime);
        $this->assign('dealerinfo', $data);
        $this->assign('curr', 'dealer_list');
		$this->display('review');
	}
	//激活禁用经销商
    public function active(){
        $this->check_qypurview('10004',1);
        $map['dl_id']=intval(I('post.dl_id',0));
        $this->dltj_arrs=array();
		$this->get_dltjarray($map['dl_id']);//传入当前经销商的id，获取推荐人信息及推荐人的推荐人的信息。。。。继续找
		$dltjarray=$this->dltj_arrs; //所有推荐人的数组
		// krsort($this->dltj_arrs);
       	// var_dump($dltjarray);
       	// exit;
        $map['dl_unitcode']=session('unitcode');
        $Dealer= M('Dealer');
        $Fanlidetail=M('Fanlidetail');
        $data=$Dealer->where($map)->find();//当前申请经销商
        if($data){
            $active=intval(I('post.dl_status',0));//要修改成的状态
//            dump($active);die();
            if($active==1){
			    $startdate=time();
				$data2['dl_status']=1;   //0-待审 1-已审 2-代理已审 9-禁用
				if($data['dl_startdate']<=0){
				    $data2['dl_startdate']=$startdate;  //代理开始时间，从审核当天算起
				    $data2['dl_enddate']=$startdate+3600*24*365;    //代理结束时间，从审核当天加1年
				}
			}else if($active==9){
				$data2['dl_status'] = 9;
            }else{
                $data2['dl_status'] = 0;
            }
            $Dealer->where($map)->save($data2);
			//如果新的审核 计算返利
			if($active==1&& $data['dl_startdate']<=0 ){
					$map3=array();
					$map3['dlt_unitcode']=session('unitcode');
					$map3['dlt_id']=$data['dl_type'];
					$Dltype = M('Dltype');
					$data3 = $Dltype->where($map3)->find();//申请人的等级信息
					if($data3){
					}else{
						$this->error('申请代理级别不存在','',2);
					}
					//推荐返利 begin
					//审核通过后 检测是否有推荐返
					//如果有推荐人 并设置了返利
					$dltjarray_lenght=count($dltjarray);//推荐人信息及推荐人的推荐人的信息。。。。继续找
//					dump($dltjarray);die();
					if($data['dl_referee']>0 && $data3['dlt_fanli1']>0 &&$dltjarray_lenght>0){
					    $dl_level=$data['dl_level'];//申请代理级别
				   		$map4=array();
						$map4['dl_id']=$data['dl_referee'];
						$map4['dl_unitcode']=session('unitcode');
						$map4['dl_status']=1;
						$data4 = $Dealer->where($map4)->find();
						if($data4){//申请经销商的推荐人
						   switch (intval($data['dl_level'])){//当前申请经销商等级
								case 1: //当前申请经销商级别--总代
						   				switch ($dltjarray_lenght)
						   				{
						   					case 1://推荐人长度为1，只有1级返利（此时$dltj_id1为$data的推荐人）
						   							$dltj_id1=$dltjarray[0]['id'];
								   					$dltj_level1=$dltjarray[0]['level'];
						   							$dltj_name1=$dltjarray[0]['name'];
						   					break;
						   					case 2://推荐人长度为2，有2级返利（此时$dltj_id1为$data的推荐人，$dltj_id2为$dltj_id1的推荐人）
						   							$dltj_id1=$dltjarray[0]['id'];
								   					$dltj_level1=$dltjarray[0]['level'];
						   							$dltj_name1=$dltjarray[0]['name'];
						   							$dltj_id2=$dltjarray[1]['id'];
								   					$dltj_level2=$dltjarray[1]['level'];
						   							$dltj_name2=$dltjarray[1]['name'];
						   					break;
						   				}
						   		break;
						   		default:
						   			 if (intval($data['dl_level'])<4&&intval($data['dl_level'])>1)//当前申请经销商级别-省代、市代
						   			 {
						   			 	switch ($dltjarray_lenght)
						   				{
						   					case 1://推荐人长度为1，只有1级返利（此时$dltj_id1为$data的推荐人）
						   							$dltj_id1=$dltjarray[0]['id'];
								   					$dltj_level1=$dltjarray[0]['level'];
						   							$dltj_name1=$dltjarray[0]['name'];
						   					break;
						   					case 2://推荐人长度为2，有2级返利（此时$dltj_id1为$data的推荐人，$dltj_id2为$dltj_id1的推荐人）
						   							$dltj_id1=$dltjarray[0]['id'];
								   					$dltj_level1=$dltjarray[0]['level'];
						   							$dltj_name1=$dltjarray[0]['name'];

						   							$dltj_id2=$dltjarray[1]['id'];
								   					$dltj_level2=$dltjarray[1]['level'];
						   							$dltj_name2=$dltjarray[1]['name'];
						   					break;
											default:
													if ($dltjarray_lenght>=3)//推荐人长度为3，有2级返利（此时$dltj_id1为$data的推荐人，$dltj_id2为$dltj_id1的推荐人，$dltj_id3为$dltj_id2的推荐人）
													{
														$dltj_id1=$dltjarray[0]['id'];
								   						$dltj_level1=$dltjarray[0]['level'];
						   								$dltj_name1=$dltjarray[0]['name'];

							   							$dltj_id2=$dltjarray[1]['id'];
									   					$dltj_level2=$dltjarray[1]['level'];
							   							$dltj_name2=$dltjarray[1]['name'];

							   							$dltj_id3=$dltjarray[$dltjarray_lenght-1]['id'];
									   					$dltj_level3=$dltjarray[$dltjarray_lenght-1]['level'];
							   							$dltj_name3=$dltjarray[$dltjarray_lenght-1]['name'];
						   							}
											break;
						   				}
						   			 }
						   		break;
						   }
						}
					}
					//写入第一层返利
					if ($dltj_id1>0)
					{
						if ($dltj_level1>=$dl_level){//推荐人等级大于申请人的等级
//							if (==1)
//							{
								$datafl1=array();
								$datafl1['fl_unitcode'] = session('unitcode');
								$datafl1['fl_dlid'] = $dltj_id1; //获得返利的代理
								$datafl1['fl_senddlid'] =0;  //发放返利的代理$data['dl_belong']; 0为公司发放
								$datafl1['fl_type'] = 1; // 返利分类 1-推荐返利 2-订单返利  11-提现减少返利 (1-10 增加返利 11-20 减少返利) 
								$datafl1['fl_money'] = $data3['dlt_fanli1']+$data3['dlt_butie'];//$data3为申请人等级信息
								$datafl1['fl_refedlid'] = $data['dl_id']; //推荐返利中被推荐的代理（申请人）
								$datafl1['fl_oddlid'] = 0; //订单返利中 下单的代理
								$datafl1['fl_odid'] = 0;  //订单返利中 订单流水id
								$datafl1['fl_orderid']  = ''; //订单返利中 订单id
								$datafl1['fl_proid']  = 0;  //订单返利中 产品id
								$datafl1['fl_odblid']  = 0;  //订单返利中 订单关系id
								$datafl1['fl_qty']  = 0;  //订单返利中 产品数量
								$datafl1['fl_level']  = 1;  //返利的层次，1-第一层返利 2-第二层返利
								$datafl1['fl_addtime']  = time();
								$datafl1['fl_remark'] ='邀请 '.$data['dl_username'].' 成为 '.$data3['dlt_name'].' 公司补贴 '.$data3['dlt_butie'];
								$mapfl1=array();
								$mapfl1['fl_unitcode'] = session('unitcode');
								$mapfl1['fl_dlid'] =$dltj_id1;
								$mapfl1['fl_type'] = 1;
								$mapfl1['fl_refedlid'] = $data['dl_id'];
								$fl1rs =$Fanlidetail->where($mapfl1)->find();
								if(!$fl1rs){
									$rsfl1data=$Fanlidetail->create($datafl1,1);
									if($rsfl1data){
										$rsfl1id = $Fanlidetail->add();
									}
								}
//							}
						}else//推荐人等级小于或等于申请人的等级
						{
							$datafl1=array();
							$datafl1['fl_unitcode'] = session('unitcode');
							$datafl1['fl_dlid'] = $dltj_id1; //获得返利的代理
							$datafl1['fl_senddlid'] =0;  //发放返利的代理$data['dl_belong']; 0为公司发放
							$datafl1['fl_type'] = 1; // 返利分类 1-推荐返利 2-订单返利  11-提现减少返利 (1-10 增加返利 11-20 减少返利) 
							$datafl1['fl_money'] = $data3['dlt_fanli1'];//$data3为申请人等级信息
							$datafl1['fl_refedlid'] = $data['dl_id']; //推荐返利中被推荐的代理
							$datafl1['fl_oddlid'] = 0; //订单返利中 下单的代理
							$datafl1['fl_odid'] = 0;  //订单返利中 订单流水id
							$datafl1['fl_orderid']  = ''; //订单返利中 订单id
							$datafl1['fl_proid']  = 0;  //订单返利中 产品id
							$datafl1['fl_odblid']  = 0;  //订单返利中 订单关系id
							$datafl1['fl_qty']  = 0;  //订单返利中 产品数量
							$datafl1['fl_level']  = 1;  //返利的层次，1-第一层返利 2-第二层返利
							$datafl1['fl_addtime']  = time();
							$datafl1['fl_remark'] ='邀请 '.$data['dl_username'].' 成为 '.$data3['dlt_name'];
							
							$mapfl1=array();
							$mapfl1['fl_unitcode'] = session('unitcode');
							$mapfl1['fl_dlid'] =$dltj_id1;
							$mapfl1['fl_type'] = 1;
							$mapfl1['fl_refedlid'] = $data['dl_id'];
							$fl1rs =$Fanlidetail->where($mapfl1)->find();
							if(!$fl1rs){
								$rsfl1data=$Fanlidetail->create($datafl1,1);
								if($rsfl1data){
									$rsfl1id = $Fanlidetail->add();
								}
							}
						}

					}

					//写入第二层返利
					if ($dltj_id2>0)
					{				
						$datafl2=array();
						$datafl2['fl_unitcode'] = session('unitcode');
						$datafl2['fl_dlid'] = $dltj_id2; //获得返利的代理
						$datafl2['fl_senddlid'] =0;  //发放返利的代理$data['dl_belong']; 0为公司发放
						$datafl2['fl_type'] = 1; // 返利分类 1-推荐返利 2-订单返利  11-提现减少返利 (1-10 增加返利 11-20 减少返利) 
						$datafl2['fl_money'] = $data3['dlt_fanli2'];
						$datafl2['fl_refedlid'] = $data['dl_id']; //推荐返利中被推荐的代理
						$datafl2['fl_oddlid'] = 0; //订单返利中 下单的代理
						$datafl2['fl_odid'] = 0;  //订单返利中 订单流水id
						$datafl2['fl_orderid']  = ''; //订单返利中 订单id
						$datafl2['fl_proid']  = 0;  //订单返利中 产品id
						$datafl2['fl_odblid']  = 0;  //订单返利中 订单关系id
						$datafl2['fl_qty']  = 0;  //订单返利中 产品数量
						$datafl2['fl_level']  = 2;  //返利的层次，1-第一层返利 2-第二层返利
						$datafl2['fl_addtime']  = time();
						$datafl2['fl_remark'] ='你邀请的 '.$data4['dl_username'].' 再邀请'.$data['dl_username'].' 成为 '.$data3['dlt_name'];
						
						$mapfl2=array();
						$mapfl2['fl_unitcode'] = session('unitcode');
						$mapfl2['fl_dlid'] =$dltj_id2;
						$mapfl2['fl_type'] = 1;
						$mapfl2['fl_refedlid'] = $data['dl_id'];
						$fl2rs =$Fanlidetail->where($mapfl2)->find();
						if(!$fl2rs){
							$rsfl2data=$Fanlidetail->create($datafl2,1);
							if($rsfl2data){
								$rsfl2id = $Fanlidetail->add();
							}
						}
					}

					//写入最顶层返利
					if ($dltj_id3>0)
					{					
						$datafl3=array();
						$datafl3['fl_unitcode'] = session('unitcode');
						$datafl3['fl_dlid'] = $dltj_id3; //获得返利的代理
						$datafl3['fl_senddlid'] =0;  //发放返利的代理$data['dl_belong']; 0为公司发放
						$datafl3['fl_type'] = 1; // 返利分类 1-推荐返利 2-订单返利  11-提现减少返利 (1-10 增加返利 11-20 减少返利) 
						$datafl3['fl_money'] = $data3['dlt_fanli2'];
						$datafl3['fl_refedlid'] = $data['dl_id']; //推荐返利中被推荐的代理
						$datafl3['fl_oddlid'] = 0; //订单返利中 下单的代理
						$datafl3['fl_odid'] = 0;  //订单返利中 订单流水id
						$datafl3['fl_orderid']  = ''; //订单返利中 订单id
						$datafl3['fl_proid']  = 0;  //订单返利中 产品id
						$datafl3['fl_odblid']  = 0;  //订单返利中 订单关系id
						$datafl3['fl_qty']  = 0;  //订单返利中 产品数量
						$datafl3['fl_level']  = 1;  //返利的层次，1-第一层返利 2-第二层返利
						$datafl3['fl_addtime']  = time();
						$datafl3['fl_remark'] ='你间接邀请的 '.$data4['dl_username'].' 再邀请'.$data['dl_username'].' 成为 '.$data3['dlt_name'];
						
						$mapfl3=array();
						$mapfl3['fl_unitcode'] = session('unitcode');
						$mapfl3['fl_dlid'] =$dltj_id3;
						$mapfl3['fl_type'] = 1;
						$mapfl3['fl_refedlid'] = $data['dl_id'];
						$fl3rs =$Fanlidetail->where($mapfl3)->find();
						if(!$fl3rs){
							$rsfl3data=$Fanlidetail->create($datafl3,1); 
							if($rsfl3data){
								$rsfl3id = $Fanlidetail->add();
							}
						}
					}
     
				//返利 end
			}
			
            
			//代理操作日志 begin
			$odlog_arr=array(
						'dlg_unitcode'=>session('unitcode'),  
						'dlg_dlid'=>$map['dl_id'],
						'dlg_operatid'=>session('qyid'),
						'dlg_dlusername'=>session('qyuser'),
						'dlg_dlname'=>session('qyuser'),
						'dlg_action'=>'审核/禁用经销商-'.$active,
						'dlg_type'=>0, //0-企业 1-经销商
						'dlg_addtime'=>time(),
						'dlg_ip'=>real_ip(),
						'dlg_link'=>__SELF__
						);
			$Dealerlogs = M('Dealerlogs');
			$rs3=$Dealerlogs->create($odlog_arr,1);
			if($rs3){
				$Dealerlogs->add();
			}
			//代理操作日志 end
			
            $this->success('审核/禁用成功','',1);
        }else{
            $this->error('没有该记录','',1);
        }
    }
	
	//修改经销商级别 降级别 上家不变 升级别上家或改变并且他推荐的代理的上家也有可能改变
    public function update_dltype(){
        $this->check_qypurview('10004',1);
        $map['dl_id']=intval(I('post.dl_id',0));
        $map['dl_unitcode']=session('unitcode');
        $Dealer= M('Dealer');
		$Dltype= M('Dltype');
        $data=$Dealer->where($map)->find();
        if($data){
            $dltypeid=intval(I('post.dl_type',0));
            if($dltypeid>0){
				$okk=0;
				if($data['dl_type']==$dltypeid){
					$this->error('选择的级别与原来级别相同','',1);
				}
				//原来级别
				$map2=array();
				$map2['dlt_unitcode']=session('unitcode');
				$map2['dlt_id']=$data['dl_type'];
				$dltinfo = $Dltype->where($map2)->find();
				if($dltinfo){
					$original_level=$dltinfo['dlt_level'];  //原来的级别
				}else{
					$original_level=$data['dl_level'];  //原来的级别
				}
			
				//修改的分类/级别
				$map2=array();
				$map2['dlt_unitcode']=session('unitcode');
				$map2['dlt_id']=$dltypeid;
				$dltinfo = $Dltype->where($map2)->find();
				if($dltinfo){
					$apply_level=$dltinfo['dlt_level'];  //修改的级别
				}else{
					$this->error('请选择经销商级别','',1);
				}
				
				//如果修改的级别高于原来的级别
				if($apply_level<=$original_level){
					//判断是否修改新的上家
					if($data['dl_belong']>0){
						$map2=array();
						$map2['dl_id']=$data['dl_belong'];
						$map2['dl_unitcode']=session('unitcode');
						$dlbelong=$Dealer->where($map2)->find();
						if($dlbelong){
							//上家的级别
							$map3=array();
							$map3['dlt_unitcode']=session('unitcode');
							$map3['dlt_id']=$dlbelong['dl_type'];
							$data3 = $Dltype->where($map3)->find();
							if($data3){
								$dlbelong_level=$data3['dlt_level']; //上家的级别
							}else{
								$dlbelong_level=$dlbelong['dl_level'];
							}

							if($apply_level<=$dlbelong_level){
								$dlbelong_id=$this->get_dlbelong($dlbelong['dl_id'],$apply_level);
								if($dlbelong_id===false){
									$this->error('上家不存在','',2);
								}
								$updatedata['dl_belong']=$dlbelong_id;
								$okk=1;
							}
						}else{
							$this->error('上家不存在','',2);
						}
					}
				}
				
				$updatedata['dl_level']=$apply_level;
				$updatedata['dl_type']=$dltypeid;
				$updatedata['dl_startdate']=time();  //更改级别后重新计算有效时间
				$updatedata['dl_enddate']=time()+3600*24*365;    //代理结束时间，默认当天加1年
				
				$Dealer->where($map)->save($updatedata);
				//代理操作日志 begin
				$odlog_arr=array(
							'dlg_unitcode'=>session('unitcode'),  
							'dlg_dlid'=>$map['dl_id'],
							'dlg_operatid'=>session('qyid'),
							'dlg_dlusername'=>session('qyuser'),
							'dlg_dlname'=>session('qyuser'),
							'dlg_action'=>'修改经销商级别-'.$apply_level,
							'dlg_type'=>0, //0-企业 1-经销商
							'dlg_addtime'=>time(),
							'dlg_ip'=>real_ip(),
							'dlg_link'=>__SELF__
							);
				$Dealerlogs = M('Dealerlogs');
				$rs3=$Dealerlogs->create($odlog_arr,1);
				if($rs3){
					$Dealerlogs->add();
				}
				//代理操作日志 end
				
				//修改他推荐的代理的上家

					$map2=array();
					$map2['dl_unitcode']=session('unitcode');
					$map2['dl_referee']=$map['dl_id'];
					$map2['dl_belong']=array('neq',$map['dl_id']);
					$map2['dl_level']=array('gt',$apply_level);
					$dealerlist = $Dealer->where($map2)->order('dl_id DESC')->select();
					foreach($dealerlist as $k=>$v){
						$updatedata=array();
						$updatedata['dl_belong']=$map['dl_id'];
						$map3=array();
						$map3['dl_id']=$v['dl_id'];
						$map3['dl_unitcode']=session('unitcode');
						$Dealer->where($map3)->save($updatedata);
						
						//代理操作日志 begin
						$odlog_arr=array(
									'dlg_unitcode'=>session('unitcode'),  
									'dlg_dlid'=>$v['dl_id'],
									'dlg_operatid'=>session('qyid'),
									'dlg_dlusername'=>session('qyuser'),
									'dlg_dlname'=>session('qyuser'),
									'dlg_action'=>'修改经销商上家-'.$map['dl_id'],
									'dlg_type'=>0, //0-企业 1-经销商
									'dlg_addtime'=>time(),
									'dlg_ip'=>real_ip(),
									'dlg_link'=>__SELF__
									);
						
						$rs3=$Dealerlogs->create($odlog_arr,1);
						if($rs3){
							$Dealerlogs->add();
						}
						//代理操作日志 end
					}

                $this->success('修改经销商级别成功','',2);
			}else{
				 $this->error('请选择经销商级别','',2);
			}
        }else{
            $this->error('没有该记录','',1);
        }
    
	}
	
	
	//修改经销商有效时间
    public function update_date(){
        $this->check_qypurview('10004',1);

        $map['dl_id']=intval(I('post.dl_id',0));
        $map['dl_unitcode']=session('unitcode');
        $Dealer= M('Dealer');
        $data=$Dealer->where($map)->find();
        if($data){
            $addyear=intval(I('post.addyear',0));
			$begintime=I('post.begintime','');
			if($begintime==''){
				$this->error('请选择起始时间','',1);
			}
			$begintime=strtotime($begintime);
			if($begintime===FALSE){
				$this->error('请选择起始时间','',1);
			}
			
			if($addyear>0){
				$data2=array();
				$data2['dl_startdate'] = $begintime;
				$data2['dl_enddate'] =time()+3600*24*365*$addyear;

				$Dealer->where($map)->save($data2);
				
				//代理操作日志 begin
				$odlog_arr=array(
							'dlg_unitcode'=>session('unitcode'),  
							'dlg_dlid'=>$map['dl_id'],
							'dlg_operatid'=>session('qyid'),
							'dlg_dlusername'=>session('qyuser'),
							'dlg_dlname'=>session('qyuser'),
							'dlg_action'=>'修改经销商有效时间-'.$addyear,
							'dlg_type'=>0, //0-企业 1-经销商
							'dlg_addtime'=>time(),
							'dlg_ip'=>real_ip(),
							'dlg_link'=>__SELF__
							);
				$Dealerlogs = M('Dealerlogs');
				$rs3=$Dealerlogs->create($odlog_arr,1);
				if($rs3){
					$Dealerlogs->add();
				}
				//代理操作日志 end
				$this->success('修改经销商有效时间成功','',1);
			}else{
				$this->error('请选择年数','',1);
			}
        }else{
            $this->error('没有该记录','',1);
        }
    }
	
	//修改经销商上家
    public function update_belong(){
        $this->check_qypurview('10004',1);

        $map['dl_id']=intval(I('post.dl_id',0));
        $map['dl_unitcode']=session('unitcode');
        $Dealer= M('Dealer');
        $data=$Dealer->where($map)->find();
        if($data){
            $belong=intval(I('post.belong',0));
			if($belong>0){
				$map2=array();
				$map2['dl_id']=$belong;
				$map2['dl_unitcode']=session('unitcode');
				$data2=$Dealer->where($map2)->find();
				if($data2){
					if($data2['dl_status']==1){
						$dl_username=$data2['dl_username'];
					}else{
						$this->error('选择上家不存在还没审核或已暂停');
					}
				}else{
					$this->error('选择上家不存在');
				}
			}else{
				$dl_username='总公司';
			}
            $data2=array();
			$data2['dl_belong'] = $belong;
            $Dealer->where($map)->save($data2);
			
			//代理操作日志 begin
			$odlog_arr=array(
						'dlg_unitcode'=>session('unitcode'),  
						'dlg_dlid'=>$map['dl_id'],
						'dlg_operatid'=>session('qyid'),
						'dlg_dlusername'=>session('qyuser'),
						'dlg_dlname'=>session('qyuser'),
						'dlg_action'=>'修改经销商上家-'.$dl_username,
						'dlg_type'=>0, //0-企业 1-经销商
						'dlg_addtime'=>time(),
						'dlg_ip'=>real_ip(),
						'dlg_link'=>__SELF__
						);
			$Dealerlogs = M('Dealerlogs');
			$rs3=$Dealerlogs->create($odlog_arr,1);
			if($rs3){
				$Dealerlogs->add();
			}
			//代理操作日志 end
			

            $this->success('修改经销商上家成功','',1);
        }else{
            $this->error('没有该记录','',1);
        }
    }
	
	
	//修改经销商推荐人 只允许上家为总公司的代理修改推荐人
    public function update_referee(){
        $this->check_qypurview('10004',1);
        $map['dl_id']=intval(I('post.dl_id',0));
        $map['dl_unitcode']=session('unitcode');
        $Dealer= M('Dealer');
        $data=$Dealer->where($map)->find();
        if($data){
			$dl_referee=I('post.dl_referee','');
			if($data['dl_belong']==0){
				if($dl_referee==''){
					$this->error('请输入推荐人的账号');
				}elseif(strval($dl_referee)=='0'){
					$dl_referee_id=0;
				}else{
					if(!preg_match("/[a-zA-Z0-9_]{4,20}$/",$dl_referee)){
                        $this->error('输入推荐人的账号不正确');
                    }
					$map2=array();
					$map2['dl_username']=$dl_referee;
					$map2['dl_unitcode']=session('unitcode');
					$data2=$Dealer->where($map2)->find();
					if($data2){
					    if($data2['dl_status']==1){
							if($data2['dl_referee']==$data['dl_id']){//当前经销商推荐人的推荐人是当前经销商
								$this->error('不能设置互为推荐人');
							}else{
								$dl_referee_id=$data2['dl_id'];
							}
						}else{
							$this->error('输入推荐人的账号还没审核或已暂停');
						}
					}else{
						$this->error('输入推荐人的账号不存在');
					}
				}
			}else{
				$this->error('只允许上家为总公司的代理修改推荐人','',3);
			}
			$data3=array();
			$data3['dl_referee'] = $dl_referee_id;

            $Dealer->where($map)->save($data3);
			
			//代理操作日志 begin
			$odlog_arr=array(
						'dlg_unitcode'=>session('unitcode'),  
						'dlg_dlid'=>$map['dl_id'],
						'dlg_operatid'=>session('qyid'),
						'dlg_dlusername'=>session('qyuser'),
						'dlg_dlname'=>session('qyuser'),
						'dlg_action'=>'修改经销商推荐人-'.$dl_referee,
						'dlg_type'=>0, //0-企业 1-经销商
						'dlg_addtime'=>time(),
						'dlg_ip'=>real_ip(),
						'dlg_link'=>__SELF__
						);
			$Dealerlogs = M('Dealerlogs');
			$rs3=$Dealerlogs->create($odlog_arr,1);
			if($rs3){
				$Dealerlogs->add();
			}
			//代理操作日志 end
			

            $this->success('修改经销商推荐人成功','',1);
        }else{
            $this->error('没有该记录','',1);
        }
    }
	
	
	//修改经销商保证金
    public function deposit_save(){
        $this->check_qypurview('10012',1);

        $map['dl_id']=intval(I('post.dl_id',0));
        $map['dl_unitcode']=session('unitcode');
        $Dealer= M('Dealer');
        $data=$Dealer->where($map)->find();
        if($data){
            $dl_deposit=I('post.dl_deposit','');
			if($dl_deposit==''){
				$dl_deposit=0;
			}else{
				if(!preg_match("/^[0-9.]{1,9}$/",$dl_deposit)){
                    $this->error('输入保证金必须为数字');
                }
			}
			
			
			
			//保证金图片
		    $dl_depositpic='';
			//上传文件 begin
            if($_FILES['pic_file']['name']==''){
                $dl_depositpic='';
            }else{
                $upload = new \Think\Upload();
                $upload->maxSize = 1045504 ;
                $upload->exts = array('jpg', 'gif', 'png', 'jpeg');
                $upload->rootPath   = './Public/uploads/dealer/';
                $upload->subName  = session('unitcode');
                $upload->saveName = time().'_'.mt_rand(1000,9999);
                
                $info   =   $upload->uploadOne($_FILES['pic_file']);

                if(!$info) {
                    $this->error($upload->getError(),'',1);
                }else{
                    $dl_depositpic=$info['savepath'].$info['savename'];
                }

                @unlink($upload->rootPath.I('post.old_depositpic','')); 
                @unlink($_FILES['pic_file']['tmp_name']); 
            }
            //上传文件 end
			
            $data2=array();
			$data2['dl_deposit'] = $dl_deposit;
			if($dl_depositpic!=''){
			    $data2['dl_depositpic'] = $dl_depositpic;
			}

            $Dealer->where($map)->save($data2);
			
			//代理操作日志 begin
			$odlog_arr=array(
						'dlg_unitcode'=>session('unitcode'),  
						'dlg_dlid'=>$map['dl_id'],
						'dlg_operatid'=>session('qyid'),
						'dlg_dlusername'=>session('qyuser'),
						'dlg_dlname'=>session('qyuser'),
						'dlg_action'=>'修改经销商保证金-'.$dl_deposit,
						'dlg_type'=>0, //0-企业 1-经销商
						'dlg_addtime'=>time(),
						'dlg_ip'=>real_ip(),
						'dlg_link'=>__SELF__
						);
			$Dealerlogs = M('Dealerlogs');
			$rs3=$Dealerlogs->create($odlog_arr,1);
			if($rs3){
				$Dealerlogs->add();
			}
			//代理操作日志 end
			

            $this->success('修改经销商保证金成功','',1);
        }else{
            $this->error('没有该记录','',1);
        }
    }
	
	
    //保存经销商
    public function edit_save(){
    	if (!IS_POST) {
             header('HTTP/1.0 404 Not Found');
             echo'error:404';
             exit;
        }
        $map['dl_id']=intval(I('post.dl_id',0));
        $submit=trim(I('post.Submit',''));
        if($map['dl_id']>0){
        	if ($submit='解绑微信')
        	{
        		$this->check_qypurview('90002',1);
        		$Dealer= M('Dealer');
        		$data=$Dealer->where($map)->field('dl_openid')->find();
        		if ($data)
        		{
        			$dl_openid=$data['dl_openid'];
        		}	
	            $updata=array();
				$updata['dl_openid']='';
				$updata['dl_wxnickname']='';
				$updata['dl_wxsex']='';
				$updata['dl_wxheadimg']='';
				$updata['dl_wxprovince']='';
				$updata['dl_wxcity']='';
				$updata['dl_wxcountry']='';
				$updata['dl_wxheadimg']='';
			    $rs=$Dealer->where($map)->data($updata)->save();
			    if($rs){
					$Accesstoken=M('Accesstoken');
					$atmap=array();
					$atmap['at_unitcode']=session('unitcode');
					$atmap['at_openid']=$dl_openid;
					$atupdata=array();
					$atupdata['at_userid']='';
					$atupdata['at_username']='';
					$atupdata['at_status']=0;
					$Accesstoken->where($atmap)->save($atupdata);
					$this->success('解绑微信成功','',1);
					// $msg=array('stat'=>'1','msg'=>'解绑微信成功');
					// echo json_encode($msg);
					exit;
				}else{
					$this->error('解绑微信失败','',1);
					// $msg=array('stat'=>'0','msg'=>'解绑微信失败');
					// echo json_encode($msg);
					exit;
				}
        	}
        	else
        	{
				$this->check_qypurview('10004',1);
	            //修改保存
	            $data['dl_id']=$map['dl_id'];
	            $data['dl_number']=I('post.dl_number','');
	            $data['dl_name']=I('post.dl_name','');
	            $data['dl_area']=I('post.dl_area','');
	            $data['dl_contact']=trim(I('post.dl_contact',''));
	            $data['dl_tel']=I('post.dl_tel','');
	            $data['dl_fax']=I('post.dl_fax','');
	            $data['dl_address']=I('post.dl_address','');
	            $data['dl_email']=I('post.dl_email','');
	            $data['dl_qq']=I('post.dl_qq','');
				$data['dl_idcard']=I('post.dl_idcard','');
	            $data['dl_remark']=I('post.dl_remark','');
				$data['dl_des']=I('post.dl_des','');

	            if($data['dl_number']=='' || $data['dl_name']=='' || $data['dl_contact']=='' || $data['dl_tel']=='' ){
	                $this->error('带"*"不能为空');
	            }
				
				//是否含有emoji 
				if(preg_match("/(\\\u[ed][0-9a-f]{3})/i",json_encode($data['dl_name']))){
					$data['dl_name']=wxuserTextEncode($data['dl_name']);
				}
	           
	            $Dealer= M('Dealer');
				
	            $map2=array();
	            $map2['dl_id']=$map['dl_id'];
	            $map2['dl_unitcode']=session('unitcode');
	            $dealerinfo=$Dealer->where($map2)->find();
	            if($dealerinfo){
					
	            }else{
	                $this->error('记录不存在','',1);
	            }
				
				//确保经销商编号唯一
				$map2=array();
	            $map2['dl_number']=$data['dl_number'];
	            $map2['dl_unitcode']=session('unitcode');
	            $map2['dl_id'] = array('NEQ',$map['dl_id']);
	            $data2=$Dealer->where($map2)->find();
	            if($data2){
	                $this->error('经销商编号已存在');
	            }
				
	            //确保微信号唯一
				$map2=array();
	            $map2['dl_weixin']=I('post.dl_weixin','');
	            $map2['dl_unitcode']=session('unitcode');
	            $map2['dl_id'] = array('NEQ',$map['dl_id']);
	            if($map2['dl_weixin']!=''){
	                if(!preg_match("/[a-zA-Z0-9_-]{6,20}$/",$map2['dl_weixin'])){
	                    $this->error('微信号由 A--Z,a--z,0--9,_- 组成,6-20位','',1);
	                }
	                $data2=$Dealer->where($map2)->find();
	                if($data2){
	                    $this->error('该微信号已存在','',1);
	                }
	                $data['dl_weixin']=I('post.dl_weixin','');
	            }
				
	            //允许设置经销商账户密码
	            if($this->check_qypurview('90001',0)){
	                $dl_username=I('post.dl_username','');
	                $dl_pwd=I('post.dl_pwd','');
	                
	                //如果已经设置账户 看是否改密
	                if(is_not_null($dealerinfo['dl_username'])){
	                    if($dl_pwd!=''){
	                        if(strlen($dl_pwd)<6){
	                            $this->error('经销商登录密码必须6位以上','',1);
	                        }
	                        $dl_pwdmd5=MD5(MD5(MD5($dl_pwd)));
	                        $data['dl_pwd']=$dl_pwdmd5;
	                    }
	                }else{

						if($dl_username=='' || $dl_pwd==''){
							$this->error('经销商账户或密码不能为空','',1);
						}
		   
						if(!preg_match("/[a-zA-Z0-9_]{4,20}$/",$dl_username)){
							$this->error('用户名由 A--Z,a--z,0--9,_ 组成,4-20位');
						}

						$map3['dl_username']=$dl_username;
						$map3['dl_unitcode']=session('unitcode');
						$data3=$Dealer->where($map3)->find();
						if($data3){
							$this->error('经销商账户已存在','',1);
						}
						if(strlen($dl_pwd)<6){
							$this->error('经销商登录密码必须6位以上','',1);
						}
						$dl_pwdmd5=MD5(MD5(MD5($dl_pwd)));

						$data['dl_username']=$dl_username;
						$data['dl_pwd']=$dl_pwdmd5;
	                    
	                }
	            }


				
				//身份证图片
			    $dl_idcardpic='';
				$dl_idcardpic2='';
				//上传单个文件 begin
				if(isset($_FILES['pic_file']['name']) &&  $_FILES['pic_file']['name']!=''){
					$upload = new \Think\Upload();
					$upload->maxSize = 1048576 ;
					$upload->exts = array('jpg', 'gif', 'png', 'jpeg');
					$upload->rootPath   = './Public/uploads/dealer/';
					$upload->subName  = session('unitcode');
					$upload->saveName = time().'_'.mt_rand(1000,9999);
					
					$info   =   $upload->uploadOne($_FILES['pic_file']);

					if(!$info) {
						$this->error($upload->getError(),'',1);
					}else{
						$dl_idcardpic=$info['savepath'].$info['savename'];
					}
					if(I('post.old_idcardpic','')!=''){
						@unlink($upload->rootPath.I('post.old_idcardpic','')); 
					}
					@unlink($_FILES['pic_file']['tmp_name']); 
				}
				
				if(isset($_FILES['pic_file2']['name']) &&  $_FILES['pic_file2']['name']!=''){
					$upload = new \Think\Upload();
					$upload->maxSize = 1048576 ;
					$upload->exts = array('jpg', 'gif', 'png', 'jpeg');
					$upload->rootPath   = './Public/uploads/dealer/';
					$upload->subName  = session('unitcode');
					$upload->saveName = time().'_'.mt_rand(1000,9999);
					
					$info   =   $upload->uploadOne($_FILES['pic_file2']);

					if(!$info) {
						$this->error($upload->getError(),'',1);
					}else{
						$dl_idcardpic2=$info['savepath'].$info['savename'];
					}
					if(I('post.old_idcardpic2','')!=''){
						@unlink($upload->rootPath.I('post.old_idcardpic2','')); 
					}
					@unlink($_FILES['pic_file2']['tmp_name']); 
				}
				
				
				//上传文件 end
				if($dl_idcardpic!=''){
					$data['dl_idcardpic']=$dl_idcardpic;
				}
				
				if($dl_idcardpic2!=''){
					$data['dl_idcardpic2']=$dl_idcardpic2;
				}

	            $map['dl_unitcode']=session('unitcode');
	            $rs=$Dealer->where($map)->data($data)->save();
	            if($rs){
	                //记录日志 begin
	                $log_arr=array(
	                            'log_qyid'=>session('qyid'),
	                            'log_user'=>session('qyuser'),
	                            'log_qycode'=>session('unitcode'),
	                            'log_action'=>'修改经销商',
								'log_type'=>1, //0-系统 1-企业 2-经销商 3-消费者
	                            'log_addtime'=>time(),
	                            'log_ip'=>real_ip(),
	                            'log_link'=>__SELF__,
	                            'log_remark'=>json_encode($data)
	                            );
	                save_log($log_arr);
	                //记录日志 end
	                $this->success('修改成功','',1);
	            }elseif($rs===0){
	                $this->success('修改成功','',1);
	            }else{
	                $this->error('修改失败','',1);
	            }
        	}
        }else{  
		    $this->check_qypurview('10002',1);
			
            //添加保存
			$Dealer= M('Dealer');
			
            $map=array();
            $map['dl_number']=I('post.dl_number','');
            $map['dl_unitcode']=session('unitcode');
			
            //确保编号唯一
            $data1=$Dealer->where($map)->find();
            if($data1){
                $this->error('经销商编号已存在','',1);
            }
            
            //确保微信号唯一
			$map2=array();
            $map2['dl_weixin']=I('post.dl_weixin','');
            $map2['dl_unitcode']=session('unitcode');
            if($map2['dl_weixin']!=''){
				if(!preg_match("/[a-zA-Z0-9_-]{6,20}$/",$map2['dl_weixin'])){
                    $this->error('微信号由 A--Z,a--z,0--9,_-组成,6-20位','',1);
                }
				
                $data2=$Dealer->where($map2)->find();
                if($data2){
                    $this->error('对不起，该微信号已存在','',1);
                }
            }
			
			//确保电话号唯一
			if(I('post.dl_tel','')!=''){
				$map2=array();
				$map2['dl_tel']=I('post.dl_tel','');
				$map2['dl_unitcode']=session('unitcode');
				$data2=$Dealer->where($map2)->find();
				if($data2){
					$this->error('对不起，该手机号已存在','',2);
				}
			}
			
            //是否设置经销商账户密码
            if($this->check_qypurview('90001',0)){
                $dl_username=I('post.dl_username','');
                $dl_pwd=I('post.dl_pwd','');
                if($dl_username=='' || $dl_pwd==''){
                    $this->error('经销商账户或密码不能为空','',1);
                }

                if(!preg_match("/[a-zA-Z0-9_]{4,20}$/",$dl_username)){
                    $this->error('用户名由 A--Z,a--z,0--9,_ 组成,4-20位');
                }
				$map3=array();
                $map3['dl_username']=$dl_username;
                $map3['dl_unitcode']=session('unitcode');
                $data3=$Dealer->where($map3)->find();
                if($data3){
                    $this->error('经销商账户已存在','',1);
                }
                if(strlen($dl_pwd)<6){
                    $this->error('经销商登录密码必须6位以上','',1);
                }
                $dl_pwdmd5=MD5(MD5(MD5($dl_pwd)));

                $data['dl_username']=$dl_username;
                $data['dl_pwd']=$dl_pwdmd5;
            }
			
            //允许经销商分类
            if($this->check_qypurview('10005',0)){
                $dl_type=intval(I('post.dl_type',0));
                if($dl_type<=0){
                    $this->error('请选择经销商级别','',1);
                }
                $data['dl_type']=$dl_type;
            }
			
            //允许设置经销商上下级
            if($this->check_qypurview('90003',0)){
                $dl_belong=intval(I('post.dl_belong',0));
                $data['dl_belong']=$dl_belong;
                
				$Dltype= M('Dltype');
				$map4=array();
                $map4['dlt_id']=$data['dl_type'];
                $map4['dlt_unitcode']=session('unitcode');
                $data4=$Dltype->where($map4)->find();
                if($data4){
                    $data['dl_level']=$data4['dlt_level'];  //经销商级别 与经销商级别表保持一致
                }else{
                    $this->error('请选择经销商级别','',1);
                }
            }

			
            $data['dl_number']=$map['dl_number'];
            $data['dl_unitcode']=session('unitcode');
            $data['dl_name']=I('post.dl_name','');
            $data['dl_area']=I('post.dl_area','');
            $data['dl_contact']=trim(I('post.dl_contact',''));
            $data['dl_tel']=I('post.dl_tel','');
            $data['dl_fax']=I('post.dl_fax','');
            $data['dl_address']=I('post.dl_address','');
            $data['dl_email']=I('post.dl_email','');
            $data['dl_weixin']=I('post.dl_weixin','');
            $data['dl_qq']=I('post.dl_qq','');
			$data['dl_idcard']=I('post.dl_idcard','');
			$data['dl_tbdian']=I('post.dl_tbdian','');
			$data['dl_tbzhanggui']=I('post.dl_tbzhanggui','');
            $data['dl_remark']=I('post.dl_remark','');
			$data['dl_des']=I('post.dl_des','');
            $data['dl_addtime']=time();
            $data['dl_status']=1;
            $data['dl_openid']='';
            $data['dl_wxnickname']='';
			$data['dl_tblevel']=0;
			$data['dl_referee']=0;
			$data['dl_pic']='';
			
            
            if($data['dl_number']=='' || $data['dl_name']=='' || $data['dl_contact']=='' || $data['dl_tel']=='' ){
                $this->error('带"*"不能为空');
            }
			
            
			//经销商图片处理
			$dl_idcardpic='';
            //上传文件 begin
            if(isset($_FILES['pic_file']['name']) &&  $_FILES['pic_file']['name']!=''){
                
                $upload = new \Think\Upload();
                $upload->maxSize = 1048576 ;
                $upload->exts = array('jpg', 'gif', 'png', 'jpeg');
                $upload->rootPath   = './Public/uploads/dealer/';
                $upload->subName  = session('unitcode');
                $upload->saveName = time().'_'.mt_rand(1000,9999);
                
                $info   =   $upload->uploadOne($_FILES['pic_file']);

                if(!$info) {
                    $this->error($upload->getError());
                }else{
                    $dl_idcardpic=$info['savepath'].$info['savename'];
                }
                @unlink($_FILES['pic_file']['tmp_name']); 
            }
            //上传文件 end
            $data['dl_idcardpic']=$dl_idcardpic;
            $rs=$Dealer->create($data,1);
            if($rs){
               $result = $Dealer->add();
               if($result){
                    //记录日志 begin
                    $log_arr=array(
                                'log_qyid'=>session('qyid'),
                                'log_user'=>session('qyuser'),
                                'log_qycode'=>session('unitcode'),
                                'log_action'=>'添加经销商',
								'log_type'=>1, //0-系统 1-企业 2-经销商 3-消费者
                                'log_addtime'=>time(),
                                'log_ip'=>real_ip(),
                                'log_link'=>__SELF__,
                                'log_remark'=>json_encode($data)
                                );
                    save_log($log_arr);
                    //记录日志 end
                   $this->success('添加成功',U('Mp/Dealer/index'));
               }else{
                   $this->error('添加失败');
               }
            }else{
                $this->error('添加失败');
            }
        }
    }

	//==========================================================================
    //经销商分类列表
    public function typelist(){
        $this->check_qypurview('10005',1);

        $map['dlt_unitcode']=session('unitcode');
        $Dltype = M('Dltype');
        $count = $Dltype->where($map)->count();
        $Page = new \Think\Page($count, C('PAGE_SIZE'));
        $show = $Page->show();
        $list = $Dltype->where($map)->order('dlt_level ASC,dlt_id ASC')->limit(($Page->firstRow . ',') . $Page->listRows)->select();
//        dump($list);die();
        $Dealer = M('Dealer');
        foreach($list as $k=>$v){ 
				$map2=array();
				$map2['dl_unitcode']=session('unitcode');
				$map2['dl_type']=$v['dlt_id'];
				$dcount = $Dealer->where($map2)->count();
				$list[$k]['dcount']=$dcount;
        }
//        dump($list);die();
        $this->assign('list', $list);
        $this->assign('page', $show);
        $this->assign('curr', 'dealer_list');
        $this->display('typelist');
    }
  
  //添加经销商分类
    public function typeadd(){
        $this->check_qypurview('10005',1);
		$this->check_qypurview('99999',1);
        $data['dlt_id']=0;
        $this->assign('curr', 'dealer_list');
        $this->assign('atitle', '添加级别');
        $this->assign('dltinfo', $data);
        $this->display('typeadd');
    }
    //修改经销商分类
    public function typeedit(){
        $this->check_qypurview('10005',1);
        $this->check_qypurview('99999',1);
		
        $map['dlt_id']=intval(I('get.dlt_id',0));
        $map['dlt_unitcode']=session('unitcode');
        $Dltype= M('Dltype');
        $data=$Dltype->where($map)->find();
        if($data){

        }else{
            $this->error('没有该记录');
        }
    
        $this->assign('dltinfo', $data);
        $this->assign('curr', 'dealer_list');
        $this->assign('atitle', '修改级别');

        $this->display('typeadd');
    }
	
    //经销商分类详细
    public function typeview(){
        $this->check_qypurview('10005',1);

        $map['dlt_id']=intval(I('get.dlt_id',0));
        $map['dlt_unitcode']=session('unitcode');
        $Dltype= M('Dltype');
        $data=$Dltype->where($map)->find();
        if($data){

        }else{
            $this->error('没有该记录');
        }
    
        $this->assign('dltinfo', $data);
        $this->assign('curr', 'dealer_list');
        $this->assign('atitle', '详细');

        $this->display('typeview');
    }
	
    //保存经销商分类
    public function type_save(){
        $this->check_qypurview('10005',1);
		$this->check_qypurview('99999',1);

        if (!IS_POST) {
             header('HTTP/1.0 404 Not Found');
             echo'error:404';
             exit;
        }
        
        
        if(intval(I('post.dlt_id',0))>0){
            //修改保存
			$map['dlt_id']=intval(I('post.dlt_id',0));
			$data=array();
            $data['dlt_name']=I('post.dlt_name','');
			$data['dlt_level']=intval(I('post.dlt_level',0));
			$data['dlt_fanli1']=I('post.dlt_fanli1','');
			$data['dlt_fanli2']=I('post.dlt_fanli2','');
			$data['dlt_fanli3']=I('post.dlt_fanli3','');
			$data['dlt_fanli4']=I('post.dlt_fanli4','');
			$data['dlt_fanli5']=I('post.dlt_fanli5','');
			$data['dlt_fanli6']=I('post.dlt_fanli6','');
			$data['dlt_fanli7']=I('post.dlt_fanli7','');
			$data['dlt_fanli8']=I('post.dlt_fanli8','');
			$data['dlt_fanli9']=I('post.dlt_fanli9','');
			$data['dlt_fanli10']=I('post.dlt_fanli10','');
			$data['dlt_firstquota']=I('post.dlt_firstquota','');
			$data['dlt_minnum']=I('post.dlt_minnum','');
			$data['dlt_butie']=I('post.dlt_butie','');
            if($data['dlt_name']==''){
                $this->error('级别名称不能为空');
            }
			
			if($data['dlt_level']<=0){
                $this->error('请选择级别');
            }
			
			if($data['dlt_fanli1']!=''){
				if(!preg_match("/^[0-9.]{1,10}$/",$data['dlt_fanli1'])){
					$this->error('返利必须为数字','',1);
				}
			}else{
				$data['dlt_fanli1']=0;
			}
			
			if($data['dlt_fanli2']!=''){
				if(!preg_match("/^[0-9.]{1,10}$/",$data['dlt_fanli2'])){
					$this->error('返利必须为数字','',1);
				}
			}else{
				$data['dlt_fanli2']=0;
			}
			
			if($data['dlt_fanli3']!=''){
				if(!preg_match("/^[0-9.]{1,10}$/",$data['dlt_fanli3'])){
					$this->error('返利必须为数字','',1);
				}
			}else{
				$data['dlt_fanli3']=0;
			}
			
			if($data['dlt_fanli4']!=''){
				if(!preg_match("/^[0-9.]{1,10}$/",$data['dlt_fanli4'])){
					$this->error('返利必须为数字','',1);
				}
			}else{
				$data['dlt_fanli4']=0;
			}
			
			if($data['dlt_fanli5']!=''){
				if(!preg_match("/^[0-9.]{1,10}$/",$data['dlt_fanli5'])){
					$this->error('返利必须为数字','',1);
				}
			}else{
				$data['dlt_fanli5']=0;
			}
			
			if($data['dlt_fanli6']!=''){
				if(!preg_match("/^[0-9.]{1,10}$/",$data['dlt_fanli6'])){
					$this->error('返利必须为数字','',1);
				}
			}else{
				$data['dlt_fanli6']=0;
			}
			
			if($data['dlt_fanli7']!=''){
				if(!preg_match("/^[0-9.]{1,10}$/",$data['dlt_fanli7'])){
					$this->error('返利必须为数字','',1);
				}
			}else{
				$data['dlt_fanli7']=0;
			}
			
			if($data['dlt_fanli8']!=''){
				if(!preg_match("/^[0-9.]{1,10}$/",$data['dlt_fanli8'])){
					$this->error('返利必须为数字','',1);
				}
			}else{
				$data['dlt_fanli8']=0;
			}
			
			if($data['dlt_fanli9']!=''){
				if(!preg_match("/^[0-9.]{1,10}$/",$data['dlt_fanli9'])){
					$this->error('返利必须为数字','',1);
				}
			}else{
				$data['dlt_fanli9']=0;
			}
			
			if($data['dlt_fanli10']!=''){
				if(!preg_match("/^[0-9.]{1,10}$/",$data['dlt_fanli10'])){
					$this->error('返利必须为数字','',1);
				}
			}else{
				$data['dlt_fanli10']=0;
			}
			
			if($data['dlt_firstquota']!=''){
				if(!preg_match("/^[0-9.]{1,10}$/",$data['dlt_firstquota'])){
					$this->error('返利必须为数字','',1);
				}
			}else{
				$data['dlt_firstquota']=0;
			}
			if($data['dlt_minnum']!=''){
				if(!preg_match("/^[0-9]{1,10}$/",$data['dlt_minnum'])){
					$this->error('返利必须为数字','',1);
				}
			}else{
				$data['dlt_minnum']=0;
			}
			
			if($data['dlt_butie']!=''){
				if(!preg_match("/^[0-9.]{1,10}$/",$data['dlt_butie'])){
					$this->error('公司补贴必须为数字','',1);
				}
			}else{
				$data['dlt_butie']=0;
			}
			
			
			
            $map2=array();
            $map2['dlt_name']=$data['dlt_name'];
            $map2['dlt_unitcode']=session('unitcode');
            $map2['dlt_id'] = array('NEQ',$map['dlt_id']);
            $Dltype= M('Dltype');
            $data2=$Dltype->where($map2)->find();
            if($data2){
                $this->error('该级别名称已存在');
            }
			$map2=array();
            $map2['dlt_level']=$data['dlt_level'];
            $map2['dlt_unitcode']=session('unitcode');
            $map2['dlt_id'] = array('NEQ',$map['dlt_id']);
            $data2=$Dltype->where($map2)->find();
            if($data2){
                $this->error('该级别已存在');
            }
			
            $map['dlt_unitcode']=session('unitcode');
            $rs=$Dltype->where($map)->data($data)->save();

            if($rs){
				//记录日志 begin
				$log_arr=array(
							'log_qyid'=>session('qyid'),
							'log_user'=>session('qyuser'),
							'log_qycode'=>session('unitcode'),
							'log_action'=>'修改经销商级别',
							'log_type'=>1, //0-系统 1-企业 2-经销商 3-消费者
							'log_addtime'=>time(),
							'log_ip'=>real_ip(),
							'log_link'=>__SELF__,
							'log_remark'=>json_encode($data)
							);
				save_log($log_arr);
				//记录日志 end
				
                $this->success('修改成功',U('Mp/Dealer/typelist'),'',2);
            }elseif($rs===0){
                $this->error('提交数据未改变','',1);
			}else{	
                $this->error('修改失败','',1);
            }
        }else{  
            //添加保存
			$data=array();
			$data['dlt_unitcode']=session('unitcode');
            $data['dlt_name']=I('post.dlt_name','');
			$data['dlt_level']=intval(I('post.dlt_level',0));
			$data['dlt_fanli1']=I('post.dlt_fanli1','');
			$data['dlt_fanli2']=I('post.dlt_fanli2','');
			$data['dlt_fanli3']=I('post.dlt_fanli3','');
			$data['dlt_fanli4']=I('post.dlt_fanli4','');
			$data['dlt_fanli5']=I('post.dlt_fanli5','');
			$data['dlt_fanli6']=I('post.dlt_fanli6','');
			$data['dlt_fanli7']=I('post.dlt_fanli7','');
			$data['dlt_fanli8']=I('post.dlt_fanli8','');
			$data['dlt_fanli9']=I('post.dlt_fanli9','');
			$data['dlt_fanli10']=I('post.dlt_fanli10','');
			$data['dlt_firstquota']=I('post.dlt_firstquota','');
			$data['dlt_minnum']=I('post.dlt_minnum','');
			$data['dlt_butie']=I('post.dlt_butie','');
            if($data['dlt_name']==''){
                $this->error('级别名称不能为空');
            }
			if($data['dlt_level']<=0){
                $this->error('请选择级别');
            }
			if($data['dlt_fanli1']!=''){
				if(!preg_match("/^[0-9.]{1,10}$/",$data['dlt_fanli1'])){
					$this->error('返利必须为数字','',1);
				}
			}else{
				$data['dlt_fanli1']=0;
			}

			if($data['dlt_fanli2']!=''){
				if(!preg_match("/^[0-9.]{1,10}$/",$data['dlt_fanli2'])){
					$this->error('返利必须为数字','',1);
				}
			}else{
				$data['dlt_fanli2']=0;
			}

			if($data['dlt_fanli3']!=''){
				if(!preg_match("/^[0-9.]{1,10}$/",$data['dlt_fanli3'])){
					$this->error('返利必须为数字','',1);
				}
			}else{
				$data['dlt_fanli3']=0;
			}

            if($data['dlt_fanli4']!=''){
				if(!preg_match("/^[0-9.]{1,10}$/",$data['dlt_fanli4'])){
					$this->error('返利必须为数字','',1);
				}
			}else{
				$data['dlt_fanli4']=0;
			}

			if($data['dlt_fanli5']!=''){
				if(!preg_match("/^[0-9.]{1,10}$/",$data['dlt_fanli5'])){
					$this->error('返利必须为数字','',1);
				}
			}else{
				$data['dlt_fanli5']=0;
			}
			
			if($data['dlt_fanli6']!=''){
				if(!preg_match("/^[0-9.]{1,10}$/",$data['dlt_fanli6'])){
					$this->error('返利必须为数字','',1);
				}
			}else{
				$data['dlt_fanli6']=0;
			}
			
			if($data['dlt_fanli7']!=''){
				if(!preg_match("/^[0-9.]{1,10}$/",$data['dlt_fanli7'])){
					$this->error('返利必须为数字','',1);
				}
			}else{
				$data['dlt_fanli7']=0;
			}
			if($data['dlt_fanli8']!=''){
				if(!preg_match("/^[0-9.]{1,10}$/",$data['dlt_fanli8'])){
					$this->error('返利必须为数字','',1);
				}
			}else{
				$data['dlt_fanli8']=0;
			}
			
			if($data['dlt_fanli9']!=''){
				if(!preg_match("/^[0-9.]{1,10}$/",$data['dlt_fanli9'])){
					$this->error('返利必须为数字','',1);
				}
			}else{
				$data['dlt_fanli9']=0;
			}
			
			if($data['dlt_fanli10']!=''){
				if(!preg_match("/^[0-9.]{1,10}$/",$data['dlt_fanli10'])){
					$this->error('返利必须为数字','',1);
				}
			}else{
				$data['dlt_fanli10']=0;
			}
			
			if($data['dlt_firstquota']!=''){
				if(!preg_match("/^[0-9.]{1,10}$/",$data['dlt_firstquota'])){
					$this->error('返利必须为数字','',1);
				}
			}else{
				$data['dlt_firstquota']=0;
			}
			
			if($data['dlt_minnum']!=''){
				if(!preg_match("/^[0-9]{1,10}$/",$data['dlt_minnum'])){
					$this->error('返利必须为数字','',1);
				}
			}else{
				$data['dlt_minnum']=0;
			}
			if($data['dlt_butie']!=''){
				if(!preg_match("/^[0-9]{1,10}$/",$data['dlt_butie'])){
					$this->error('公司补贴必须为数字','',1);
				}
			}else{
				$data['dlt_butie']=0;
			}

		
            $map=array();
            $map['dlt_name']=$data['dlt_name'];
            $map['dlt_unitcode']=session('unitcode');

            $Dltype= M('Dltype');
            $data2=$Dltype->where($map)->find();
            if($data2){
                $this->error('该级别名称已存在');
            }
			
			$map=array();
            $map['dlt_level']=$data['dlt_level'];
            $map['dlt_unitcode']=session('unitcode');

            $data2=$Dltype->where($map)->find();
            if($data2){
                $this->error('该级别已存在');
            }
		
            $rs=$Dltype->create($data,1);
            if($rs){
                $result = $Dltype->add(); 
                if($result){
					//记录日志 begin
					$log_arr=array(
								'log_qyid'=>session('qyid'),
								'log_user'=>session('qyuser'),
								'log_qycode'=>session('unitcode'),
								'log_action'=>'添加经销商级别',
								'log_type'=>1, //0-系统 1-企业 2-经销商 3-消费者
								'log_addtime'=>time(),
								'log_ip'=>real_ip(),
								'log_link'=>__SELF__,
								'log_remark'=>json_encode($data)
								);
					save_log($log_arr);
					//记录日志 end
					
                   $this->success('添加成功',U('Mp/Dealer/typelist'),'',2);
                }else{
                   $this->error('添加失败','',1);
                }
            }else{
                $this->error('添加失败','',1);
            }
        }
    }
	
    //删除经销商分类
    public function dltdel(){
        $this->check_qypurview('10005',1);
        $this->check_qypurview('99999',1);
		
        $map['dlt_id']=intval(I('get.dlt_id',0));
        $map['dlt_unitcode']=session('unitcode');
        $Dltype= M('Dltype');
        $data=$Dltype->where($map)->find();
        if($data){
            //验证是否要删除 要保持数据完整性 
            $Dealer = M('Dealer');
			if($this->check_qypurview('10006',0)){
				$map2=array();
				$map2['dl_unitcode']=session('unitcode');
				$map2['dl_brandlevel']=array('LIKE', '%,'.$data['dlt_id'].'|%');
				$dcount = $Dealer->where($map2)->count();
				if($dcount>0){
					$this->error('该分类已应用到经销商上，暂不能删除','',1);
				}
			}else{
				$map2=array();
				$map2['dl_unitcode']=session('unitcode');
				$map2['dl_type']=$data['dlt_id'];
				$dcount = $Dealer->where($map2)->count();
				if($dcount>0){
					$this->error('该分类已应用到经销商上，暂不能删除','',1);
				}
			}
            //记录日志 begin
            $log_arr=array(
                        'log_qyid'=>session('qyid'),
                        'log_user'=>session('qyuser'),
                        'log_qycode'=>session('unitcode'),
                        'log_action'=>'删除经销商分类',
						'log_type'=>1, //0-系统 1-企业 2-经销商 3-消费者
                        'log_addtime'=>time(),
                        'log_ip'=>real_ip(),
                        'log_link'=>__SELF__,
                        'log_remark'=>json_encode($data)
                        );
            save_log($log_arr);
            //记录日志 end
            $Dltype->where($map)->delete(); 
            $this->success('删除成功',U('Mp/Dealer/typelist'),'',2);
        }else{
            $this->error('没有该记录','',1);
        }     
    }

//===========================================================================
    //经销商分类列表--2
    public function sttypelist(){
        $this->check_qypurview('10011',1);

        $map['dlstt_unitcode']=session('unitcode');
        $Dlsttype = M('Dlsttype');
        $count = $Dlsttype->where($map)->count();
        $Page = new \Think\Page($count, C('PAGE_SIZE'));
        $show = $Page->show();
        $list = $Dlsttype->where($map)->order('dlstt_level ASC,dlstt_id ASC')->limit(($Page->firstRow . ',') . $Page->listRows)->select();
        $Dealer = M('Dealer');
        foreach($list as $k=>$v){ 
				$map2=array();
				$map2['dl_unitcode']=session('unitcode');
				$map2['dl_sttype']=$v['dlstt_id'];
				$dcount = $Dealer->where($map2)->count();
				$list[$k]['dcount']=$dcount;
        }

        $this->assign('list', $list);
        $this->assign('page', $show);
        $this->assign('curr', 'dealer_list');
        $this->display('sttypelist');
    }
  
  //添加经销商分类2
    public function sttypeadd(){
        $this->check_qypurview('10011',1);
		$this->check_qypurview('99999',1);

        $data['dlstt_id']=0;
        $this->assign('curr', 'dealer_list');
        $this->assign('atitle', '添加级别2');
        $this->assign('dlsttinfo', $data);

        $this->display('sttypeadd');
    }
	
    //修改经销商分类2
    public function sttypeedit(){
        $this->check_qypurview('10011',1);
        $this->check_qypurview('99999',1);
		
        $map['dlstt_id']=intval(I('get.dlstt_id',0));
        $map['dlstt_unitcode']=session('unitcode');
        $Dlsttype= M('Dlsttype');
        $data=$Dlsttype->where($map)->find();
        if($data){

        }else{
            $this->error('没有该记录');
        }
    
        $this->assign('dlsttinfo', $data);
        $this->assign('curr', 'dealer_list');
        $this->assign('atitle', '修改级别2');

        $this->display('sttypeadd');
    }
	
    //经销商分类详细2
    public function sttypeview(){
        $this->check_qypurview('10011',1);

        $map['dlstt_id']=intval(I('get.dlstt_id',0));
        $map['dlstt_unitcode']=session('unitcode');
        $Dlsttype= M('Dlsttype');
        $data=$Dlsttype->where($map)->find();
        if($data){

        }else{
            $this->error('没有该记录');
        }
    
        $this->assign('dlsttinfo', $data);
        $this->assign('curr', 'dealer_list');
        $this->assign('atitle', '详细');

        $this->display('sttypeview');
    }
	
    //保存经销商分类2
    public function sttype_save(){
        $this->check_qypurview('10011',1);
		$this->check_qypurview('99999',1);

        if (!IS_POST) {
             header('HTTP/1.0 404 Not Found');
             echo'error:404';
             exit;
        }
        
        
        if(intval(I('post.dlstt_id',0))>0){
            //修改保存
            
			$map['dlstt_id']=intval(I('post.dlstt_id',0));
			$data=array();
            $data['dlstt_name']=I('post.dlstt_name','');
			$data['dlstt_level']=intval(I('post.dlstt_level',0));
			$data['dlstt_fanli1']=I('post.dlstt_fanli1','');
			$data['dlstt_fanli2']=I('post.dlstt_fanli2','');

            if($data['dlstt_name']==''){
                $this->error('级别名称不能为空');
            }
			
			if($data['dlstt_level']<=0){
                $this->error('请选择级别');
            }
			
			if($data['dlstt_fanli1']!=''){
				if(!preg_match("/^[0-9.]{1,10}$/",$data['dlstt_fanli1'])){
					$this->error('返利必须为数字','',1);
				}
			}else{
				$data['dlstt_fanli1']=0;
			}
			
			if($data['dlstt_fanli2']!=''){
				if(!preg_match("/^[0-9.]{1,10}$/",$data['dlstt_fanli2'])){
					$this->error('返利必须为数字','',1);
				}
			}else{
				$data['dlstt_fanli2']=0;
			}
			
            $map2=array();
            $map2['dlstt_name']=$data['dlstt_name'];
            $map2['dlstt_unitcode']=session('unitcode');
            $map2['dlstt_id'] = array('NEQ',$map['dlstt_id']);
	
            $Dlsttype= M('Dlsttype');
            $data2=$Dlsttype->where($map2)->find();
			
            if($data2){
                $this->error('该级别名称已存在');
            }
			
			$map2=array();
            $map2['dlstt_level']=$data['dlstt_level'];
            $map2['dlstt_unitcode']=session('unitcode');
            $map2['dlstt_id'] = array('NEQ',$map['dlstt_id']);
            $data2=$Dlsttype->where($map2)->find();
            if($data2){
                $this->error('该级别已存在');
            }
			
            $map['dlstt_unitcode']=session('unitcode');
            $rs=$Dlsttype->where($map)->data($data)->save();

            if($rs){
				//记录日志 begin
				$log_arr=array(
							'log_qyid'=>session('qyid'),
							'log_user'=>session('qyuser'),
							'log_qycode'=>session('unitcode'),
							'log_action'=>'修改经销商级别2',
							'log_type'=>1, //0-系统 1-企业 2-经销商 3-消费者
							'log_addtime'=>time(),
							'log_ip'=>real_ip(),
							'log_link'=>__SELF__,
							'log_remark'=>json_encode($data)
							);
				save_log($log_arr);
				//记录日志 end
				
                $this->success('修改成功',U('Mp/Dealer/sttypelist'),'',2);
            }elseif($rs===0){
                $this->error('提交数据未改变','',1);
			}else{	
                $this->error('修改失败','',1);
            }
        }else{  
            //添加保存
			$data=array();
			$data['dlstt_unitcode']=session('unitcode');
            $data['dlstt_name']=I('post.dlstt_name','');
			$data['dlstt_level']=intval(I('post.dlstt_level',0));
			$data['dlstt_fanli1']=I('post.dlstt_fanli1','');
			$data['dlstt_fanli2']=I('post.dlstt_fanli2','');

            
            if($data['dlstt_name']==''){
                $this->error('级别名称不能为空');
            }
			
			if($data['dlstt_level']<=0){
                $this->error('请选择级别');
            }
			
			if($data['dlstt_fanli1']!=''){
				if(!preg_match("/^[0-9.]{1,10}$/",$data['dlstt_fanli1'])){
					$this->error('返利必须为数字','',1);
				}
			}else{
				$data['dlstt_fanli1']=0;
			}
			
			if($data['dlstt_fanli2']!=''){
				if(!preg_match("/^[0-9.]{1,10}$/",$data['dlstt_fanli2'])){
					$this->error('返利必须为数字','',1);
				}
			}else{
				$data['dlstt_fanli2']=0;
			}
		
            $map=array();
            $map['dlstt_name']=$data['dlstt_name'];
            $map['dlstt_unitcode']=session('unitcode');

            $Dlsttype= M('Dlsttype');
            $data2=$Dlsttype->where($map)->find();
            if($data2){
                $this->error('该级别名称已存在');
            }
			
			$map=array();
            $map['dlstt_level']=$data['dlstt_level'];
            $map['dlstt_unitcode']=session('unitcode');

            $data2=$Dlsttype->where($map)->find();
            if($data2){
                $this->error('该级别已存在');
            }
		
            $rs=$Dlsttype->create($data,1);
            if($rs){
                $result = $Dlsttype->add(); 
                if($result){
					//记录日志 begin
					$log_arr=array(
								'log_qyid'=>session('qyid'),
								'log_user'=>session('qyuser'),
								'log_qycode'=>session('unitcode'),
								'log_action'=>'添加经销商级别2',
								'log_type'=>1, //0-系统 1-企业 2-经销商 3-消费者
								'log_addtime'=>time(),
								'log_ip'=>real_ip(),
								'log_link'=>__SELF__,
								'log_remark'=>json_encode($data)
								);
					save_log($log_arr);
					//记录日志 end
					
                   $this->success('添加成功',U('Mp/Dealer/sttypelist'),'',2);
                }else{
                   $this->error('添加失败','',1);
                }
            }else{
                $this->error('添加失败','',1);
            }
        }
    }
	
    //删除经销商分类2
    public function dlsttdel(){
        $this->check_qypurview('10011',1);
        $this->check_qypurview('99999',1);
		
        $map['dlstt_id']=intval(I('get.dlstt_id',0));
        $map['dlstt_unitcode']=session('unitcode');
        $Dlsttype= M('Dlsttype');
        $data=$Dlsttype->where($map)->find();

        if($data){
            //验证是否要删除 要保持数据完整性 
            $Dealer = M('Dealer');

			$map2=array();
			$map2['dl_unitcode']=session('unitcode');
			$map2['dl_sttype']=$data['dlstt_id'];
			$dcount = $Dealer->where($map2)->count();
			if($dcount>0){
				$this->error('该分类已应用到经销商上，暂不能删除','',1);
			}



            //记录日志 begin
            $log_arr=array(
                        'log_qyid'=>session('qyid'),
                        'log_user'=>session('qyuser'),
                        'log_qycode'=>session('unitcode'),
                        'log_action'=>'删除经销商分类2',
						'log_type'=>1, //0-系统 1-企业 2-经销商 3-消费者
                        'log_addtime'=>time(),
                        'log_ip'=>real_ip(),
                        'log_link'=>__SELF__,
                        'log_remark'=>json_encode($data)
                        );
            save_log($log_arr);
            //记录日志 end

            $Dlsttype->where($map)->delete(); 
            $this->success('删除成功',U('Mp/Dealer/sttypelist'),'',2);
        }else{
            $this->error('没有该记录','',1);
        }     
    }
	
	
	
	
//===========================================================================
    //授权品牌列表
    public function brandlist(){
        $this->check_qypurview('10006',1);

        $map['br_unitcode']=session('unitcode');
        $Brand = M('Brand');
        $count = $Brand->where($map)->count();
        $Page = new \Think\Page($count, C('PAGE_SIZE'));
        $show = $Page->show();
        $list = $Brand->where($map)->order('br_id ASC')->limit(($Page->firstRow . ',') . $Page->listRows)->select();
        $Dealer = M('Dealer');
		$imgpath = BASE_PATH.'/Public/uploads/product/';
        foreach($list as $k=>$v){ 
            $map2=array();
            $map2['dl_unitcode']=session('unitcode');
            $map2['dl_brand']=array('LIKE', '%|'.$v['br_id'].'|%');
            $bcount = $Dealer->where($map2)->count();
            $list[$k]['bcount']=$bcount;
			
            if(is_not_null($v['br_pic']) && file_exists($imgpath.$v['br_pic'])){
                $arr=getimagesize($imgpath.$v['br_pic']);
                if(false!=$arr){
                    $w=$arr[0];
                    $h=$arr[1];
                    if($h>60){
                       $hh=60;
                       $ww=($w*60)/$h;
                    }else{
                       $hh=$h;
                       $ww=$w;
                    }
                    if($ww>60){
                       $ww=60;
                       $hh=($h*60)/$w;
                    }
                    $list[$k]['br_pic_str']='<img src="'.__ROOT__.'/Public/uploads/product/'.$v['br_pic'].'" width="'.$ww.'"  height="'.$hh.'"  border="0" style="vertical-align:middle" >';
                }
                else{
                    $list[$k]['br_pic_str']='';
                }
            }else{
                $list[$k]['br_pic_str']='';
            }
			
        }

        $this->assign('list', $list);
        $this->assign('page', $show);
        $this->assign('curr', 'dealer_list');
        $this->display('brandlist');
    }
    //添加授权品牌
    public function brandadd(){
        $this->check_qypurview('10006',1);

        $data['br_id']=0;
        $this->assign('curr', 'dealer_list');
        $this->assign('atitle', '添加授权品牌');
        $this->assign('brandinfo', $data);

        $this->display('brandadd');
    }
    //修改授权品牌
    public function brandedit(){
        $this->check_qypurview('10006',1);

        $map['br_id']=intval(I('get.br_id',0));
        $map['br_unitcode']=session('unitcode');
        $Brand= M('Brand');
        $data=$Brand->where($map)->find();
		$imgpath = BASE_PATH.'/Public/uploads/product/';
        if($data){
            if(is_not_null($data['br_pic']) && file_exists($imgpath.$data['br_pic'])){
                $arr=getimagesize($imgpath.$data['br_pic']);
                if(false!=$arr){
                    $w=$arr[0];
                    $h=$arr[1];
                    if($h>60){
                       $hh=60;
                       $ww=($w*60)/$h;
                    }else{
                       $hh=$h;
                       $ww=$w;
                    }
                    if($ww>60){
                       $ww=60;
                       $hh=($h*60)/$w;
                    }
                    $data['br_pic_str']='<img src="'.__ROOT__.'/Public/uploads/product/'.$data['br_pic'].'" width="'.$ww.'"  height="'.$hh.'"  border="0" style="vertical-align:middle" >';
                }
                else{
                    $data['br_pic_str']='';
                }
            }else{
                $data['br_pic_str']='';
            }
        }else{
            $this->error('没有该记录');
        }
    
        $this->assign('brandinfo', $data);
        $this->assign('curr', 'dealer_list');
        $this->assign('atitle', '修改授权品牌');

        $this->display('brandadd');
    }
   
   //保存授权品牌
    public function brand_save(){
        $this->check_qypurview('10006',1);

        if (!IS_POST) {
             header('HTTP/1.0 404 Not Found');
             echo'error:404';
             exit;
        }
        $map['br_id']=intval(I('post.br_id',''));
        
        if($map['br_id']>0){
            //修改保存

            $data['br_name']=I('post.br_name','');

            if($data['br_name']=='' ){
                $this->error('品牌名称不能为空');
            }

            //上传文件 begin
            if($_FILES['pic_file']['name']==''){
                $br_pic='';
            }else{
                $upload = new \Think\Upload();
                $upload->maxSize = 3145728 ;
                $upload->exts = array('jpg', 'gif', 'png', 'jpeg');
                $upload->rootPath   = './Public/uploads/product/';
                $upload->subName  = session('unitcode');
                $upload->saveName = time().'_'.mt_rand(1000,9999);
                
                $info   =   $upload->uploadOne($_FILES['pic_file']);

                if(!$info) {
                    $this->error($upload->getError(),'',1);
                }else{
                    $br_pic=$info['savepath'].$info['savename'];
                }

                @unlink($upload->rootPath.I('post.old_br_pic','')); 
                @unlink($_FILES['pic_file']['tmp_name']); 
            }
            //上传文件 end
            if($br_pic!=''){
                $data['br_pic']=$br_pic;
            }
			
            $Brand= M('Brand');
            $map['br_unitcode']=session('unitcode');
            $rs=$Brand->where($map)->data($data)->save();

            if($rs){
                $this->success('修改成功',U('Mp/Dealer/brandlist'),'',2);
            }elseif($rs===0){
                $this->error('提交数据未改变','',1);
			}else{	
                $this->error('修改失败','',1);
            }
        }else{  
            //添加保存
            $map=array();
            $map['br_name']=I('post.br_name','');
            $map['br_unitcode']=session('unitcode');

            $Brand= M('Brand');
            $data2=$Brand->where($map)->find();
            if($data2){
                $this->error('该品牌已存在');
            }

            $data['br_name']=$map['br_name'];
            $data['br_unitcode']=session('unitcode');

            
            if($data['br_name']==''){
                $this->error('品牌名称不能为空');
            }
            
			
			//上传文件 begin
            if($_FILES['pic_file']['name']==''){
                $br_pic='';
            }else{
                $upload = new \Think\Upload();
                $upload->maxSize = 3145728 ;
                $upload->exts = array('jpg', 'gif', 'png', 'jpeg');
                $upload->rootPath   = './Public/uploads/product/';
                $upload->subName  = session('unitcode');
                $upload->saveName = time().'_'.mt_rand(1000,9999);
                
                $info   =   $upload->uploadOne($_FILES['pic_file']);

                if(!$info) {
                    $this->error($upload->getError(),'',1);
                }else{
                    $br_pic=$info['savepath'].$info['savename'];
                }

                @unlink($upload->rootPath.I('post.old_br_pic','')); 
                @unlink($_FILES['pic_file']['tmp_name']); 
            }
            //上传文件 end
            if($br_pic!=''){
                $data['br_pic']=$br_pic;
            }

            $rs=$Brand->create($data,1);
            if($rs){
                $result = $Brand->add(); 
                if($result){
                   $this->success('添加成功',U('Mp/Dealer/brandlist'),'',2);
                }else{
                   $this->error('添加失败','',1);
                }
            }else{
                $this->error('添加失败','',1);
            }
        }
    }
  
  //删除授权品牌
    public function branddel(){
        $this->check_qypurview('10006',1);

        $map['br_id']=intval(I('get.br_id',0));
        $map['br_unitcode']=session('unitcode');
        $Brand= M('Brand');
        $data=$Brand->where($map)->find();

        if($data){
            //验证是否要删除 要保持数据完整性 
            $Dealer = M('Dealer');
            $map2['dl_unitcode']=session('unitcode');
            $map2['dl_brand']=array('LIKE', '%|'.$data['br_id'].'|%');
            $dcount = $Dealer->where($map2)->count();
            if($dcount>0){
                $this->error('该授权品牌已应用到经销商上，暂不能删除','',1);
            }

            //记录日志 begin
            $log_arr=array(
                        'log_qyid'=>session('qyid'),
                        'log_user'=>session('qyuser'),
                        'log_qycode'=>session('unitcode'),
                        'log_action'=>'删除授权品牌',
						'log_type'=>1, //0-系统 1-企业 2-经销商 3-消费者
                        'log_addtime'=>time(),
                        'log_ip'=>real_ip(),
                        'log_link'=>__SELF__,
                        'log_remark'=>json_encode($data)
                        );
            save_log($log_arr);
            //记录日志 end
            @unlink('./Public/uploads/product/'.$data['br_pic']); 
            $Brand->where($map)->delete(); 
            $this->success('删除成功',U('Mp/Dealer/brandlist'),'',2);
        }else{
            $this->error('没有该记录','',1);
        }     
    }

	//调级记录列表
    public function updatedltypelist(){
        $this->check_qypurview('10004',1);

        $Applydltype = M('Applydltype');
        $map['apply_unitcode']=session('unitcode');
        $count = $Applydltype->where($map)->count();
        $Page = new \Think\Page($count, C('PAGE_SIZE'));
        $show = $Page->show();
        $list = $Applydltype->where($map)->order('apply_id DESC')->limit(($Page->firstRow . ',') . $Page->listRows)->select();
        
        $Dltype = M('Dltype');
		$Dealer = M('Dealer');
        foreach($list as $k=>$v){ 
		
			//申请代理
			if($v['apply_dlid']>0){
				$map2=array();
				$map2['dl_id']=$v['apply_dlid'];
				$map2['dl_unitcode']=session('unitcode');
				$data2=$Dealer->where($map2)->find();
				if($data2){
					$list[$k]['dl_name_str']=$data2['dl_name'].'('.$data2['dl_username'].')';
				}else{
					$list[$k]['dl_name_str']='未知';
				}
			}else{
				$list[$k]['dl_name_str']='未知';
			}
			
			//申请前上家
			if($v['apply_agobelong']>0){
				$map2=array();
				$map2['dl_id']=$v['apply_agobelong'];
				$map2['dl_unitcode']=session('unitcode');
				$data2=$Dealer->where($map2)->find();
				if($data2){
					$list[$k]['apply_agobelong_str']=$data2['dl_name'].'('.$data2['dl_username'].')';
				}else{
					$list[$k]['apply_agobelong_str']='未知';
				}
			}else{
				$list[$k]['apply_agobelong_str']=' 总公司';
			}
			
			//申请前级别
			if($v['apply_agodltype']>0){
				$map2=array();
				$map2['dlt_unitcode']=session('unitcode');
				$map2['dlt_id']=$v['apply_agodltype'];
				$dltinfo = $Dltype->where($map2)->find();
				if($dltinfo){
					$list[$k]['apply_agodltype_str']=$dltinfo['dlt_name'];
				}else{
					$list[$k]['apply_agodltype_str']='类型不存在';
				}
			}else{
				$list[$k]['apply_agodltype_str']='类型不存在';
			}
			
			//申请后上家
			if($v['apply_afterbelong']>0){
				$map2=array();
				$map2['dl_id']=$v['apply_afterbelong'];
				$map2['dl_unitcode']=session('unitcode');
				$data2=$Dealer->where($map2)->find();
				if($data2){
					$list[$k]['apply_afterbelong_str']=$data2['dl_name'].'('.$data2['dl_username'].')';
				}else{
					$list[$k]['apply_afterbelong_str']='未知';
				}
			}else{
				$list[$k]['apply_afterbelong_str']=' 总公司';
			}
			
			//申请后级别
			if($v['apply_afterdltype']>0){
				$map2=array();
				$map2['dlt_unitcode']=session('unitcode');
				$map2['dlt_id']=$v['apply_afterdltype'];
				$dltinfo = $Dltype->where($map2)->find();
				if($dltinfo){
					$list[$k]['apply_afterdltype_str']=$dltinfo['dlt_name'];
				}else{
					$list[$k]['apply_afterdltype_str']='类型不存在';
				}
			}else{
				$list[$k]['apply_afterdltype_str']='类型不存在';
			}
			
            if($v['apply_state']==0){
                $list[$k]['apply_state_str']='待处理';
            }elseif($v['apply_state']==1){
                $list[$k]['apply_state_str']='已调整级别';
            }elseif($v['apply_state']==2){
                $list[$k]['apply_state_str']='申请无效';
            }
        }
        $this->assign('list', $list);

        $this->assign('page', $show);
		$this->assign('pagecount', $count);
        $this->assign('curr', 'dealer_list');

        $this->display('updatedltypelist');
    }
	
	//调级记录详细
    public function updatedltypeview(){
		$this->check_qypurview('10004',1);
			
			$map['apply_id']=intval(I('get.apply_id',0));
			$map['apply_unitcode']=session('unitcode');
			$Applydltype= M('Applydltype');
			$data=$Applydltype->where($map)->find();
		    $Dealer= M('Dealer');
			$Dltype= M('Dltype');
			if($data){
				//申请代理
				if($data['apply_dlid']>0){
					$map2=array();
					$map2['dl_id']=$data['apply_dlid'];
					$map2['dl_unitcode']=session('unitcode');
					$data2=$Dealer->where($map2)->find();
					if($data2){
						$data['dl_name_str']=$data2['dl_name'].'('.$data2['dl_username'].') ('.$data2['dl_tel'].')';
					}else{
						$data['dl_name_str']='未知';
					}
				}else{
					$data['dl_name_str']='未知';
				}
				
				//申请前上家
				if($data['apply_agobelong']>0){
					$map2=array();
					$map2['dl_id']=$data['apply_agobelong'];
					$map2['dl_unitcode']=session('unitcode');
					$data2=$Dealer->where($map2)->find();
					if($data2){
						$data['apply_agobelong_str']=$data2['dl_name'].'('.$data2['dl_username'].') ('.$data2['dl_tel'].')';
					}else{
						$data['apply_agobelong_str']='未知';
					}
				}else{
					$data['apply_agobelong_str']=' 总公司';
				}
				
				//申请前级别
				if($data['apply_agodltype']>0){
					$map2=array();
					$map2['dlt_unitcode']=session('unitcode');
					$map2['dlt_id']=$data['apply_agodltype'];
					$dltinfo = $Dltype->where($map2)->find();
					if($dltinfo){
						$data['apply_agodltype_str']=$dltinfo['dlt_name'];
					}else{
						$data['apply_agodltype_str']='类型不存在';
					}
				}else{
					$data['apply_agodltype_str']='类型不存在';
				}
				
				//申请后上家
				if($data['apply_afterbelong']>0){
					$map2=array();
					$map2['dl_id']=$data['apply_afterbelong'];
					$map2['dl_unitcode']=session('unitcode');
					$data2=$Dealer->where($map2)->find();
					if($data2){
						$data['apply_afterbelong_str']=$data2['dl_name'].'('.$data2['dl_username'].') ('.$data2['dl_tel'].')';
					}else{
						$data['apply_afterbelong_str']='未知';
					}
				}else{
					$data['apply_afterbelong_str']=' 总公司';
				}
				
				//申请后级别
				if($data['apply_afterdltype']>0){
					$map2=array();
					$map2['dlt_unitcode']=session('unitcode');
					$map2['dlt_id']=$data['apply_afterdltype'];
					$dltinfo = $Dltype->where($map2)->find();
					if($dltinfo){
						$data['apply_afterdltype_str']=$dltinfo['dlt_name'];
					}else{
						$data['apply_afterdltype_str']='类型不存在';
					}
				}else{
					$data['apply_afterdltype_str']='类型不存在';
				}
				
				//状态
				if($data['apply_state']==0){
					$data['apply_state_str']='待处理';
				}elseif($data['apply_state']==1){
					$data['apply_state_str']='已调整级别';
				}elseif($data['apply_state']==2){
					$data['apply_state_str']='申请无效';
				}
				
				$imgpath = BASE_PATH.'/Public/uploads/dealer/';
				//凭证
				if(is_not_null($data['apply_pic']) && file_exists($imgpath.$data['apply_pic'])){
					$data['apply_pic_str']='<a href="'.__ROOT__.'/Public/uploads/dealer/'.$data['apply_pic'].'"  target="_blank" ><img src="'.__ROOT__.'/Public/uploads/dealer/'.$data['apply_pic'].'"   border="0" style="vertical-align:middle;width:20%"  ></a>';

				}else{
					$data['apply_pic_str']='';
				}
				
			}else{
				$this->error('没有该记录','',1);
			}

		
		$this->assign('updateinfo', $data);
        $this->assign('curr', 'dealer_list');
        $this->display('updatedltypeview');		
	}
	
	
    //调级保存处理
    public function updatedltypedeal(){
        $this->check_qypurview('10004',1);

    	if (!IS_POST) {
             header('HTTP/1.0 404 Not Found');
             echo'error:404';
             exit;
        }
        $map['apply_id']=intval(I('post.apply_id',0));
        
        if($map['apply_id']>0){
            $apply_state=intval(I('post.apply_state',''));
			$apply_remark=I('post.apply_remark','');
			
			if($apply_state==''){
				$this->error('请选择处理状态','',1);
			}
			
			if($apply_remark==''){
				$this->error('请填写处理备注','',1);
			}
			
			$map['apply_unitcode']=session('unitcode');
			$Applydltype= M('Applydltype');
			$data=$Applydltype->where($map)->find();
			
			if($data){
				if($apply_state==1){
					$map2=array();
					$map2['dl_id']=$data['apply_dlid'];
					$map2['dl_unitcode']=session('unitcode');
					$map2['dl_status']=1;
					
					$Dealer= M('Dealer');
					$Dltype= M('Dltype');
					$data2=$Dealer->where($map2)->find();
					if($data2){
						$dltypeid=$data['apply_afterdltype']; //申请后级别
						if($dltypeid>0){
							$okk=0;
							$updatedata=array();
							
							if($data2['dl_type']==$dltypeid){
								$this->error('申请级别与该代理当前级别相同','',2);
							}
							//原来级别
							$map2=array();
							$map2['dlt_unitcode']=session('unitcode');
							$map2['dlt_id']=$data2['dl_type'];
							$dltinfo = $Dltype->where($map2)->find();
							if($dltinfo){
								$original_level=$dltinfo['dlt_level'];  //原来的级别
							}else{
								$original_level=$data2['dl_level'];  //原来的级别
							}
						
							//修改的分类/级别
							$map2=array();
							$map2['dlt_unitcode']=session('unitcode');
							$map2['dlt_id']=$dltypeid;
							$dltinfo = $Dltype->where($map2)->find();
							if($dltinfo){
								$apply_level=$dltinfo['dlt_level'];  //修改的级别
							}else{
								$this->error('申请的经销商级别不存在','',1);
							}
							
							//如果修改的级别高于原来的级别
							if($apply_level<=$original_level){
								//判断是否修改新的上家
								if($data2['dl_belong']>0){
									$map2=array();
									$map2['dl_id']=$data2['dl_belong'];
									$map2['dl_unitcode']=session('unitcode');
									$dlbelong=$Dealer->where($map2)->find();
									if($dlbelong){
										//上家的级别
										$map3=array();
										$map3['dlt_unitcode']=session('unitcode');
										$map3['dlt_id']=$dlbelong['dl_type'];
										$data3 = $Dltype->where($map3)->find();
										if($data3){
											$dlbelong_level=$data3['dlt_level']; //上家的级别
										}else{
											$dlbelong_level=$dlbelong['dl_level'];
										}

										if($apply_level<=$dlbelong_level){
											$dlbelong_id=$this->get_dlbelong($dlbelong['dl_id'],$apply_level);
											if($dlbelong_id===false){
												$this->error('调级后的上家不存在','',2);
											}
											$updatedata['dl_belong']=$dlbelong_id;
											$okk=1;
										}
									}else{
										$this->error('调级后的上家不存在','',2);
									}
								}
							}
							
							$map2=array();
							$map2['dl_id']=$data['apply_dlid'];
							$map2['dl_unitcode']=session('unitcode');
							$map2['dl_status']=1;
							
							$updatedata['dl_level']=$apply_level;
							$updatedata['dl_type']=$dltypeid;
				            $updatedata['dl_startdate']=time();  //更改级别后重新计算有效时间
				            $updatedata['dl_enddate']=time()+3600*24*365;    //代理结束时间，默认当天加1年
							
							$Dealer->where($map2)->save($updatedata);
							
							//代理操作日志 begin
							$odlog_arr=array(
										'dlg_unitcode'=>session('unitcode'),  
										'dlg_dlid'=>$data2['dl_id'],
										'dlg_operatid'=>session('qyid'),
										'dlg_dlusername'=>session('qyuser'),
										'dlg_dlname'=>session('qyuser'),
										'dlg_action'=>'申请调级-修改经销商级别-'.$apply_level,
										'dlg_type'=>0, //0-企业 1-经销商
										'dlg_addtime'=>time(),
										'dlg_ip'=>real_ip(),
										'dlg_link'=>__SELF__
										);
							$Dealerlogs = M('Dealerlogs');
							$rs3=$Dealerlogs->create($odlog_arr,1);
							if($rs3){
								$Dealerlogs->add();
							}
							//代理操作日志 end
							
							//修改他推荐的代理的上家
							$map2=array();
							$map2['dl_unitcode']=session('unitcode');
							$map2['dl_referee']=$data2['dl_id'];
							$map2['dl_belong']=array('neq',$data2['dl_id']);
							$map2['dl_level']=array('gt',$apply_level);
							$dealerlist = $Dealer->where($map2)->order('dl_id DESC')->select();
							foreach($dealerlist as $k=>$v){
								$updatedata=array();
								$updatedata['dl_belong']=$data2['dl_id'];
								$map3=array();
								$map3['dl_id']=$v['dl_id'];
								$map3['dl_unitcode']=session('unitcode');
								$Dealer->where($map3)->save($updatedata);
								
								//代理操作日志 begin
								$odlog_arr=array(
											'dlg_unitcode'=>session('unitcode'),  
											'dlg_dlid'=>$v['dl_id'],
											'dlg_operatid'=>session('qyid'),
											'dlg_dlusername'=>session('qyuser'),
											'dlg_dlname'=>session('qyuser'),
											'dlg_action'=>'因推荐人调级修改代理上家-'.$data2['dl_id'],
											'dlg_type'=>0, //0-企业 1-经销商
											'dlg_addtime'=>time(),
											'dlg_ip'=>real_ip(),
											'dlg_link'=>__SELF__
											);
								
								$rs3=$Dealerlogs->create($odlog_arr,1);
								if($rs3){
									$Dealerlogs->add();
								}
								//代理操作日志 end
							}
						}else{
							 $this->error('申请的经销商级别不存在','',2);
						}
					}else{
						$this->error('申请代理不存在或已禁用','',1);
					}
				}
    
				
				
				//更改记录状态
				$data2=array();
				$data2['apply_state']=$apply_state;
				$data2['apply_remark']=$apply_remark;
				if($data['apply_dealtime']<=0){
					$data2['apply_dealtime']=time();
				}

				$rs=$Applydltype->where($map)->data($data2)->save();
                if($rs){
					//记录日志 begin
					$log_arr=array(
								'log_qyid'=>session('qyid'),
								'log_user'=>session('qyuser'),
								'log_qycode'=>session('unitcode'),
								'log_action'=>'处理调级申请',
								'log_type'=>1, //0-系统 1-企业 2-经销商 3-消费者
								'log_addtime'=>time(),
								'log_ip'=>real_ip(),
								'log_link'=>__SELF__,
								'log_remark'=>json_encode(array_merge($data,$map))
								);
					save_log($log_arr);
					//记录日志 end
					$this->success('处理调级成功',U('Mp/Dealer/updatedltypelist'),1);
				}else{
				   $this->error('处理失败','',1);
				}
				
			}else{
				$this->error('没有该记录','',2);
			}
		
        }else{
            $this->error('没有该记录','',2);
        }
    }
	
	
	
    //导出数据
    public function dealerexport(){
        $this->check_qypurview('10013',1);
		$action=I('post.action','');
		if($action=='save'){
			$dl_status=intval(I('post.dl_status',0));
			$dl_type=intval(I('post.dl_type',0));
			$orderby=intval(I('post.orderby',0));
			$Dealer = M('Dealer');
			$Dltype= M('Dltype');
			$map=array();
			if($dl_status!=''){
				$dl_status=intval($dl_status);
				$map['dl_status']=$dl_status;
			}
			if($dl_type>0){
				$map['dl_type']=$dl_type;
			}
			$map['dl_unitcode']=session('unitcode');
			if($orderby==1){
				$orderbystr='dl_addtime DESC';
			}else{
				$orderbystr='dl_type ASC,dl_id DESC';
			}
            $list = $Dealer->where($map)->order($orderbystr)->limit(5000)->select();
//			dump($list);die();
			//导出Excel 头部
			vendor("PHPExcel18.PHPExcel");  
		    $objPHPExcel = new \PHPExcel();
			/*以下是头部设置 ，什么作者  标题啊之类的*/
			$objPHPExcel->getProperties()->setCreator(session('qyuser'))
								   ->setLastModifiedBy("代理数据")
								   ->setTitle("代理数据")
								   ->setSubject("代理数据")
								   ->setDescription("代理数据")
								   ->setKeywords("代理数据")
								  ->setCategory("代理数据");
			$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue('A1', '用户名')   
				->setCellValue('B1', '姓名')
				->setCellValue('C1', '编号')
				->setCellValue('D1', '电话')
				->setCellValue('E1', '微信')
				->setCellValue('F1', '级别')
				->setCellValue('G1', '当前上家')
				->setCellValue('H1', '当前推荐人')
				->setCellValue('I1', '地址')
				->setCellValue('J1', '身份证号')
				->setCellValue('K1', '注册时间')
				->setCellValue('L1', '开始时间')
				->setCellValue('M1', '到期时间')
				->setCellValue('N1', '当前状态')
				->setCellValue('O1', '备注');
			$num=1;
			 /*以下就是对处理Excel里的数据， 横着取数据*/
			 $Dltype = M('Dltype');
			foreach($list as $k => $v){
				//经销商分类
				$map2=array();
				$map2['dlt_unitcode']=session('unitcode');
				$map2['dlt_id'] = $v['dl_type'];
				$dltypeinfo = $Dltype->where($map2)->find();
				if($dltypeinfo){
					$dl_type_str=$dltypeinfo['dlt_name'];
				}else{
					$dl_type_str='';
				}
				//当前上家
				if($v['dl_belong']>0){
					$map2=array();
					$map2['dl_id'] =  $v['dl_belong'];
					$map2['dl_unitcode']=session('unitcode');
					$data2 = $Dealer->where($map2)->find();
					if($data2){
						$dl_belong_name=$data2['dl_name'].' ('.$data2['dl_username'].')';
					}else{
						$dl_belong_name='';
					}
				}else{
					$dl_belong_name='总公司';
				}
			
				//推荐人
				if($v['dl_referee']>0){
					$map2=array();
					$map2['dl_id'] =  $v['dl_referee'];
					$map2['dl_unitcode']=session('unitcode');
					$data2 = $Dealer->where($map2)->find();
					if($data2){
						$dl_referee_name=$data2['dl_name'].' ('.$data2['dl_username'].')';
					}else{
						$dl_referee_name='-';
					}
				}else{
					$dl_referee_name='总公司';
				}
			
			
				if($data['dl_startdate']>0 && $data['dl_enddate']>0){
					if(($data['dl_enddate']-time())<3600*24*30){
						$data['dl_date_str']=date('Y-m-d',$data['dl_startdate']).' --- <span style="color:#FF0000">'.date('Y-m-d',$data['dl_enddate']).'</span>';
					}else{
						$data['dl_date_str']=date('Y-m-d',$data['dl_startdate']).' --- '.date('Y-m-d',$data['dl_enddate']);
					}
				}else{
					$data['dl_date_str']='-';
				}
				$dl_addtimestr=date('Y-m-d',$v['dl_addtime']);
				if($v['dl_startdate']>0){
				    $dl_startdatestr=date('Y-m-d',$v['dl_startdate']);
				}else{
					$dl_startdatestr='';
				}
				if($v['dl_startdate']>0){
				    $dl_enddatestr=date('Y-m-d',$v['dl_enddate']);
				}else{
					$dl_enddatestr='';
				}
				
				//0-待审 1-已审 2-代理已审(预留) 9-禁用
				if($v['dl_status']==0){
					$dl_status_str='待审';
				}else if($v['dl_status']==1){
					$dl_status_str='已审';
				}else if($v['dl_status']==2){
					$dl_status_str='代理已审';
				}else if($v['dl_status']==9){
					$dl_status_str='禁用';
				}else{
					$dl_status_str='';
				}
				$objPHPExcel->setActiveSheetIndex(0)
				//Excel的第A列，uid是你查出数组的键值，下面以此类推
				->setCellValue('A'.$num, $v['dl_username'])    //用户名
				->setCellValue('B'.$num, $v['dl_name'])        //姓名
				->setCellValue('C'.$num, $v['dl_number'])      //编号
				->setCellValue('D'.$num, ' '.$v['dl_tel'])     //电话
				->setCellValue('E'.$num, $v['dl_weixin'])      //微信 
				->setCellValue('F'.$num, $dl_type_str)         //级别
				->setCellValue('G'.$num, $dl_belong_name)      //当前上家
				->setCellValue('H'.$num, $dl_referee_name)     //当前推荐人
				->setCellValue('I'.$num, $v['dl_address'])     //地址
				->setCellValue('J'.$num, ' '.$v['dl_idcard'])      //身份证号
				->setCellValue('K'.$num, $dl_addtimestr)       //注册时间
				->setCellValue('L'.$num, $dl_startdatestr)
				->setCellValue('M'.$num, $dl_enddatestr)
				->setCellValue('N'.$num, $dl_status_str)        //状态
				->setCellValue('O'.$num, $v['dl_remark']);
				$num=$num+1;
			}
            $filename='dealer-'.date('YmdHis',time()).'.xls';
			$objPHPExcel->getActiveSheet()->setTitle('代理数据');
			$objPHPExcel->setActiveSheetIndex(0);
			header('Content-Type: application/vnd.ms-excel');
			header('Content-Disposition: attachment;filename="'.$filename.'"');
			header('Cache-Control: max-age=0');
			$objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
			$objWriter->save('php://output');
			exit;
			
		}else{

			$Dltype= M('Dltype');
			
			$map2=array();
			$map2['dlt_unitcode']=session('unitcode');
			$list2 = $Dltype->where($map2)->order('dlt_level ASC,dlt_id ASC')->select();
			$this->assign('dltypelist', $list2);
		
		
			$this->assign('curr', 'dealer_list');
			$this->display('dealerexport');		
		}
		
		
		
	}
    //导入数据
    public function dealerimport(){
        if (IS_POST){
            if (! empty ( $_FILES ['file_stu'] ['name'] ))
            {
                $tmp_file = $_FILES ['file_stu'] ['tmp_name'];
//    var_dump($_FILES ['file_stu'] ['name'] );die();
                $file_types = explode ( ".", $_FILES ['file_stu'] ['name'] );
                $file_type = $file_types [count ( $file_types ) - 1];

                /*判别是不是.xls文件，判别是不是excel文件*/
                if (strtolower ( $file_type ) != "xls")
                {
                    $this->error ( '不是Excel文件，重新上传' );
                }

                /*设置上传路径*/
                $savePath = BASE_PATH. '/public/uploads/Excel/';

                /*以时间来命名上传的文件*/
                $str = date ( 'Ymdhis' );
                $file_name = $str . "." . $file_type;

                /*是否上传成功*/
                if (! copy ( $tmp_file, $savePath . $file_name ))
                {
                    $this->error ( '上传失败' );
                }

                /*

                   *对上传的Excel数据进行处理生成编程数据,这个函数会在下面第三步的ExcelToArray类中

                  注意：这里调用执行了第三步类里面的read函数，把Excel转化为数组并返回给$res,再进行数据库写入

                */
//                $res = Service ( 'ExcelToArray' )->read ( $savePath . $file_name );


               vendor("PHPExcel18.PHPExcel");
                $objReader = \PHPExcel_IOFactory::createReader('Excel5');
                $objReader->setReadDataOnly(true);
                $objPHPExcel = $objReader->load($savePath . $file_name);
                $objWorksheet = $objPHPExcel->getActiveSheet();
                $highestRow = $objWorksheet->getHighestRow();
                $highestColumn = $objWorksheet->getHighestColumn();
                $highestColumnIndex = \PHPExcel_Cell::columnIndexFromString($highestColumn);
                $excelData = array();
                for ($row = 1; $row <= $highestRow; $row++) {
                    for ($col = 0; $col < $highestColumnIndex; $col++) {
                        $excelData[$row][] =(string)$objWorksheet->getCellByColumnAndRow($col, $row)->getValue();
                    }
                }

//                     重要代码 解决Thinkphp M、D方法不能调用的问题
//
//                     如果在thinkphp中遇到M 、D方法失效时就加入下面一句代码


                //spl_autoload_register ( array ('Think', 'autoload' ) );

                /*对生成的数组进行数据库的写入*/
                foreach ( $excelData as $k => $v )
                {
                    if ($k != 0)
                    {
                        $data ['dl_id'] = $v [0];
                        $data ['dl_unitcode'] = $v [1];
                        $result = M ( 'dealer' )->add ($data);
                        if (! $result)
                        {
                            $this->error ( '导入数据库失败' );
                        }
                    }
                }
                $this->success( '导入数据库成功',U('Mp/Dealer/index'),'',2 );
            }
            return;
        }
            $this->display('dealerimport');
    }


}