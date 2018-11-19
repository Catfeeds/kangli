<?php
namespace Zxapi\Controller;
use Think\Controller;
class IndexController extends Controller {
    public function index(){
       echo 'api';
       exit;
    }
	
    public function checkupdate(){
        $appid=trim(I('post.appid','')); //不同功能的app ID
		if($appid=='zx001'){
			//至信出货app
			$msg=array('vs'=>'1.0.3','lk'=>'http://www.cn315fw.com/public/uploads/app/zxapp1.0.3_20170509.apk');
			echo json_encode($msg);
			exit;
		}else if($appid=='zx002'){
			//康利app
			$msg=array('vs'=>'1.1','lk'=>'http://www.cn315fw.com/public/uploads/app/kanglikeji1.1.apk');
			echo json_encode($msg);
			exit;
		}else{
			$msg=array('vs'=>'','lk'=>'');
			echo json_encode($msg);
			exit;	
		}
    }
	
    public function _empty()
    {
      header('HTTP/1.0 404 Not Found');
      echo'error:404';
      exit;
    }
	
	
}