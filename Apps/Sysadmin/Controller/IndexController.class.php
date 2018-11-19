<?php
namespace Sysadmin\Controller;
use Think\Controller;
class IndexController extends CommController {
    public function index(){
		
		//删除10小时前的临时图片
		$imgpath=BASE_PATH.'/Public/uploads/temp/';
		if ($handle = opendir($imgpath)) {
			while (false !== ($filename = readdir($handle))) {
				if ($filename{0} == '.') continue;
				$file = $imgpath . $filename;
				if (is_dir($file)) {
					 //是否文件夹
				} else {
					$file_list[$i]['filename'] = $filename; //文件名，包含扩展名
					$file_list[$i]['datetime'] = date('Y-m-d H:i:s', filemtime($file)); 
					//文件最后修改时间
					if((time()-filemtime($file))>36000){
						@unlink($file); 
					}
				}
			}
			closedir($handle);
		}
		
        $this->display('index');
    }
}