<?php
namespace Zxapi\Controller;
use Think\Controller;
    class CommController extends Controller
    {
		protected $qycode='';
		protected $subusername='';
		protected $subuserid='';
		protected $qysu_purview='';
		
        public function _initialize()
        {

            if(!$this->is_user_login()){
				$msg=array('login'=>'0','stat'=>'0','msg'=>'登录已过期');
				echo json_encode($msg);
				exit;
            }

			if($this->qycode=='' || $this->subuserid=='' || $this->subusername==''){
				$msg=array('login'=>'0','stat'=>'0','msg'=>'登录已过期');
				echo json_encode($msg);
				exit;
			}
        }
        //判断登录
        public function is_user_login(){
			$uname=trim(I('post.uname',''));
			$uttamp=trim(I('post.uttamp',''));
			$usture=trim(I('post.usture',''));
			
			if($uname=='' || $uttamp=='' || $usture==''){
				return false;
			}else{
				if((time()-$uttamp)>600){
					return false;
				}
				if(!preg_match("/[a-zA-Z0-9_:]{6,20}$/",$uname)){
                    return false;
                }
                $Qysubuser = M('Qysubuser');
				$Applogin = M('Applogin');
				$map=array();
				$map['lg_username']=$uname;
				$data=$Applogin->where($map)->find();
				if($data){
					if((time()-$data['lg_time'])<172800){
						if($usture==MD5($data['lg_token'].$data['lg_imei'].$uttamp)){
							$this->qycode = $data['lg_unitcode'];
							$this->subuserid = $data['lg_userid'];
							$this->subusername = $data['lg_username'];
							$map2=array();
							$map2['su_unitcode']=$data['lg_unitcode'];
							$map2['su_id']=$data['lg_userid'];
							$data2=$Qysubuser->where($map2)->find(); 
							if($data2){
								$this->qysu_purview=$data2['su_purview'];
							}
							return true;
						}else{
							return false;
						}
					}else{
						return false;
					}
				}else{
					return false;
				}
			}
        }

		//验证管理权限 
        public function checksu_qypurview($ac='',$re=0)
        {
        	$qysu_purview=$this->qysu_purview;
		if(strpos($qysu_purview,',')===false){
		   if($qysu_purview==$ac)
		   {
		   	  if($re==0){
                        return true;
                    }else{
                    }
		   }else
		   {
		   		if($re==0){
                    return false;
                }else{
                    $this->error('对不起，没有该权限！','',1);
                }
		   }
		}else{
			$su_purviewarr=explode($ac, $qysu_purview);
			if(count($su_purviewarr)>0 && is_not_null($ac)){
                    if($re==0){
                        return true;
                    }else{
                    }
 
            }else{
                if($re==0){
                    return false;
                }else{
                    $this->error('对不起，没有该权限！','',1);
                }
                
            }
		}
        }
		
		
        public function _empty()
        {
          header('HTTP/1.0 404 Not Found');
          echo'error:404';
          exit;
        }

}