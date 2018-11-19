<?php
/**
 * 浏览各个用户图片
 */
error_reporting(7);
define('IN_WWW', true);

require_once 'Funcrypt.class.php';
require_once 'JSON.php';

$cfg_key='9da23Zx65dS9d40Gc1Ke02cHe5b72Rsc';
$ttamp = (isset($_GET['ttamp']) && is_not_null($_GET['ttamp'])) ? trim($_GET['ttamp']):'';
$sture = (isset($_GET['sture']) && is_not_null($_GET['sture'])) ? trim($_GET['sture']):'';
$uid = (isset($_GET['uid']) && is_not_null($_GET['uid'])) ? trim($_GET['uid']):'';

$path = '';//(isset($_GET['path']) && is_not_null($_GET['path'])) ? trim($_GET['path']):'';
$order = (isset($_GET['order']) && is_not_null($_GET['order'])) ? trim($_GET['order']):'NAME';
$dir = (isset($_GET['dir']) && is_not_null($_GET['dir'])) ? trim($_GET['dir']):'';
if($sture=='' || $uid=='' || $ttamp=='' ){
	echo "Please login1!";
	exit;
}

$uid=Funcrypt::authcode($uid,'DECODE',$cfg_key,0);

if($uid=='' ){
	echo "Please login2!";
	exit;
}
if(!preg_match("/^[0-9]{4,8}$/",$uid)){
	echo "Please login3!";
	exit;
}
$nowtime=time();
if(MD5($uid.$ttamp)!=$sture){
	echo "Please login4!";
	exit;
}
if(($nowtime - $ttamp) > 3600) {
	echo "Please login5!";
	exit;
}



function is_not_null($value) {
    if (is_array($value)) {
        if (sizeof($value) > 0) {
            return true;
        } else {
            return false;
        }
    } else {
        if(is_null($value)){
             return false;
        }else{
            if (($value != '')  && (strlen(trim($value)) > 0)) {
               return true;
            } else {
               return false;
            }
        }

    }
}
//=====================================================================================
$php_path = dirname(__FILE__) . '/';
$php_url = dirname($_SERVER['PHP_SELF']) . '/';

//根目录路径，可以指定绝对路径，比如 /var/www/attached/
$root_path = $php_path . '../../uploads/mobi/';
//根目录URL，可以指定绝对路径，比如 http://www.yoursite.com/attached/
$root_url = $php_url . '../../uploads/mobi/';
//图片扩展名
$ext_arr = array('gif', 'jpg', 'jpeg', 'png', 'bmp');

//目录名
$dir_name=$uid;

if ($dir_name !== '') {
	$root_path .= $dir_name . "/";
	$root_url .= $dir_name . "/";
	if (!file_exists($root_path)) {
		mkdir($root_path);
	}
}

//根据path参数，设置各路径和URL
if ($path=='') {
	$current_path = realpath($root_path) . '/';
	$current_url = $root_url;
	$current_dir_path = '';
	$moveup_dir_path = '';
} else {
	$current_path = realpath($root_path) . '/' . $path;
	$current_url = $root_url . $path;
	$current_dir_path = $path;
	$moveup_dir_path = preg_replace('/(.*?)[^\/]+\/$/', '$1', $current_dir_path);
}
//echo realpath($root_path);
//排序形式，name or size or type
$order = empty($order) ? 'name' : strtolower($order);

//不允许使用..移动到上一级目录
if (preg_match('/\.\./', $current_path)) {
	echo 'Access is not allowed.';
	exit;
}
//最后一个字符不是/
if (!preg_match('/\/$/', $current_path)) {
	echo 'Parameter is not valid.';
	exit;
}
//目录不存在或不是目录
if (!file_exists($current_path) || !is_dir($current_path)) {
	echo 'Directory does not exist.';
	exit;
}

//遍历目录取得文件信息
$file_list = array();
if ($handle = opendir($current_path)) {
	$i = 0;
	while (false !== ($filename = readdir($handle))) {
		if ($filename{0} == '.') continue;
		$file = $current_path . $filename;
		if (is_dir($file)) {
			$file_list[$i]['is_dir'] = true; //是否文件夹
			$file_list[$i]['has_file'] = (count(scandir($file)) > 2); //文件夹是否包含文件
			$file_list[$i]['filesize'] = 0; //文件大小
			$file_list[$i]['is_photo'] = false; //是否图片
			$file_list[$i]['filetype'] = ''; //文件类别，用扩展名判断
		} else {
			$file_list[$i]['is_dir'] = false;
			$file_list[$i]['has_file'] = false;
			$file_list[$i]['filesize'] = filesize($file);
			$file_list[$i]['dir_path'] = '';
			$file_ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
			$file_list[$i]['is_photo'] = in_array($file_ext, $ext_arr);
			$file_list[$i]['filetype'] = $file_ext;
		}
		$file_list[$i]['filename'] = $filename; //文件名，包含扩展名
		$file_list[$i]['datetime'] = date('Y-m-d H:i:s', filemtime($file)); //文件最后修改时间
		$i++;
	}
	closedir($handle);
}

//排序
function cmp_func($a, $b) {
	global $order;
	if ($a['is_dir'] && !$b['is_dir']) {
		return -1;
	} else if (!$a['is_dir'] && $b['is_dir']) {
		return 1;
	} else {
		if ($order == 'size') {
			if ($a['filesize'] > $b['filesize']) {
				return 1;
			} else if ($a['filesize'] < $b['filesize']) {
				return -1;
			} else {
				return 0;
			}
		} else if ($order == 'time') {
            if (strtotime($a['datetime']) < strtotime($b['datetime'])) {
				return 1;
			} else if (strtotime($a['datetime']) > strtotime($b['datetime'])) {
				return -1;
			} else {
				return 0;
			}
		} else if ($order == 'type') {
			return strcmp($a['filetype'], $b['filetype']);
		} else {
			return strcmp($a['filename'], $b['filename']);
		}
	}
}
usort($file_list, 'cmp_func');

$result = array();
//相对于根目录的上一级目录
$result['moveup_dir_path'] = $moveup_dir_path;
//相对于根目录的当前目录
$result['current_dir_path'] = $current_dir_path;
//当前目录的URL
$result['current_url'] = $current_url;
//文件数
$result['total_count'] = count($file_list);
//文件列表数组
$result['file_list'] = $file_list;

//输出JSON字符串
header('Content-type: application/json; charset=UTF-8');
$json = new Services_JSON();
echo $json->encode($result);
