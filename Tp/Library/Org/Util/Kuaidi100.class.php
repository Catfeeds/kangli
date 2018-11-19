<?php
namespace Org\Util;

class Kuaidi100{
	private $appKey;       //用户key
	private $appCustomer;  //公司编号
	private $appSecret;    //验证串

	public function __construct($appKey='', $appCustomer='',$appSecret='') {
		$this->appKey = $appKey;
		$this->appCustomer = $appCustomer;
		$this->appSecret = $appSecret;
	}
	
    /*
	param={
		"com":"yuantong",           //查询的快递公司的编码，一律用小写字母，见3.3《快递公司编码》
		"num":"12345678",           //查询的快递单号，单号的最大长度是32个字符
		"from":"广东深圳",          //出发地城市
		"to":"北京朝阳"            //目的地城市，到达目的地后会加大监控频率
	}
	*/
	public function  kdQuery($param=array()){
	    if($this->appKey==''){
		   return false;
	    }
		
		if(isset($param['com'])){
			if(trim($param['com'])==''){
				return false;
			}
		}else{
			return false;
		}
		
		if(isset($param['num'])){
			if(trim($param['num'])==''){
				return false;
			}
		}else{
			return false;
		}
		
		$url ='http://poll.kuaidi100.com/poll/query.do';
		$paramstr=json_encode($param);
		$sign = strtoupper(MD5($paramstr.$this->appKey.$this->appCustomer));
		
		$post_data = array();
		$post_data["customer"]=$this->appCustomer;
		$post_data["param"]=$paramstr;
		$post_data["sign"]=$sign;
		
        //模拟 post 获取数据

        $options = array(  
            'http' => array(  
            'method' => 'POST',  
            'header' => "Content-type: application/x-www-form-urlencoded ",
            'content' => http_build_query($post_data),  
            ), 
        ); 

        $output = trim(@file_get_contents($url, false, stream_context_create($options)));  
        //模拟 post end
		
		if (($output != '') && (strtolower($output) != 'null') && (strlen(trim($output)) > 0)) {
			$outputarr=json_decode($output,true);
			if(json_last_error()!=0){
			    return false;
			}
			return $outputarr;
		}else{
			return false;
		}
	}
  
    //备用
	private function createNonceStr($length = 16) {
		$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
		$str = "";
		for ($i = 0; $i < $length; $i++) {
		  $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
		}
		return $str;
	}


    //备用
	private function httpGet($url) {
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_TIMEOUT, 500);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($curl, CURLOPT_URL, $url);

		$res = curl_exec($curl);
		curl_close($curl);

		return $res;
	}
	
    //备用
    private function httpPost($url,$post_data) {
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_TIMEOUT, 500);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_POST, 1);
		curl_setopt($curl, CURLOPT_HEADER, 0);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $post_data);

		$res = curl_exec($curl);
		curl_close($curl);

		return $res;
  }
}

