<?php
namespace Klapi\Controller;
use Think\Controller;
use Klapi\Common\Util\Token;
class ApiController extends BaseApiController
    {
		private $controllerName;
	    private $actionName;
	    private $controller;
	    private $params;
	    private $access_lucency=false;
	/**
    * 前置条件 检查参数是否满足条件
    */
    public function _before_index()
    {
    	// $access_lucency=$_SERVER['HTTP_ACCESS_LUCENCY']; //原始
    	// $unit_uuid=$_SERVER['HTTP_UNIT_UUID']; //原始
    	// $ttamp=$_SERVER['HTTP_TTAMP']; //原始
    	// $time = I('server.HTTP_TIME');   //tp
    	// foreach (getallheaders() as $name => $value) {
     //        echo "$name: $value\n";
     //    }
    	$headerArr=$this->request['header'];
        if (isset($headerArr['access_lucency'])){
            if ($headerArr['access_lucency']=='true'||$headerArr['access_lucency']=='True'||$headerArr['access_lucency']=='TRUE'||$headerArr['access_lucency']===true)
            {
                $this->access_lucency=true;
            }
        }
        if ($this->access_lucency)
        {
        	$api_obj=$this->request['param'];//请示参数
        }else
        {
        	$paramsArr=$this->request['param'];//请示参数
            if (isset($paramsArr['param']))
            {   
                $paramStr=$paramsArr['param'];
                // $api_obj=json_decode(base64_decode(mb_substr($paramStr,8,mb_strlen($paramStr)-8,'utf-8')),TRUE);
                // var_dump($aes->decrypt($paramStr));
                $api_obj=json_decode($this->aes->decrypt($paramStr),TRUE);
            }
            else
            {
                // var_dump($paramsArr);
                $api_obj=json_decode($this->aes->decrypt(array_keys($paramsArr)[0]),TRUE);
                // var_dump($api_obj);
                // exit;
            }
        }
        if (!$api_obj) {
            //默认给首页
            $this->controllerName = "index";
            $this->actionName = "index";
        } else {
            if (!is_array($api_obj)){
                $ret = array(
                    "status" =>lang("err_status"),
                    "msg" =>lang("err_words")
                );
                exit(json_encode($ret));
            }
        }

        !isset($api_obj["mod"]) ? $this->controllerName = "index" : $this->controllerName = $api_obj["mod"];
        !isset($api_obj["act"]) ? $this->actionName = "index" : $this->actionName = $api_obj["act"];
        !isset($api_obj["params"]) ? $this->params = array() : $this->params = $api_obj["params"];
        
        if (!isset($headerArr['token'])){
            if(isset($headerArr['unit_token'])){
               $ttamp= $headerArr['ttamp'];
               $randomchar= $headerArr['randomchar'];
               $unit_uuid= $headerArr['unit_uuid'];
               $unit_uuid_str=$this->aes->decrypt($unit_uuid);
               $qy_unit_uuid=mb_substr($unit_uuid_str,mb_strlen($this->qy_appname),mb_strlen($unit_uuid_str)-mb_strlen($this->qy_appname),'utf-8');
               if ($qy_unit_uuid!=$this->qy_unitcode)
               	$this->err_get(3); 
               $unit_token= $headerArr['unit_token'];
               // var_dump(phpinfo());
               // exit;
               $unit_token_cache=S($this->qy_appname.$qy_unit_uuid);
               if ($unit_token_cache)
               {
                   $qy_unit_token=MD5($ttamp.$randomchar.$unit_token_cache);
                   if($unit_token!=$qy_unit_token)
                     $this->err_get(3);
               }else
               {
                    $Qyinfo=M('Qyinfo');
                    $map['qy_code']=$this->qy_unitcode;
                    $data=$Qyinfo->where($map)->field('qy_fwkey')->find();
                    if($data){
                        if (isset($data['qy_fwkey']))
                        {
                            $unit_ssid=strtoupper($this->aes->encrypt($this->qy_appname.$this->qy_unitcode));
                            $unit_Token=strtoupper($this->aes->encrypt($data['qy_fwkey']));
                            S($this->qy_appname.$this->qy_unitcode,$unit_Token,72000);
                        }
                        else
                             $this->err_get(4);
                    }else
                    {
                        $this->err_get(3);
                    }
               }
            }else
            {
                $this->err_get(3);
            }
        }

        //获取对应的控制器
        // $controller=\Think\Loader::parseName($this->controllerName,1);
        // $c_layer=ucfirst(C("DEFAULT_C_LAYER"));
        // $ctrName=ucfirst($this->controllerName);
        $ctrName =ucfirst($this->controllerName).ucfirst(C("DEFAULT_C_LAYER"));
        $controller =A($this->controllerName);//tp3.2
        // $controller=controller($ctrName,'klapi\controller\\'); //tp5.0
        $dir_path = str_replace("\\", "/", dirname(__FILE__)).'/';
        // define("APIROOT",dirname(__FILE__));
        // define("APIACTION",dirname(__FILE__). "/action/");
        // define("APILIB",dirname(__FILE__). "/lib/");
        $con_path = $dir_path. $ctrName . ".class.php";
        if (!is_file($con_path)) {
            $ret = array(
                "status" => -1,
                "msg" => L("file_err"),
            );
            exit(json_encode($ret));
        }
     	require_once($con_path);
     	// Vendor($con_path);
   //      var_dump($ctrName);
	 	// var_dump($actionName);

        //如果对应的控制器不存在
        if (!class_exists('klapi\controller\\'.$ctrName)) {
            $ret = array(
                "status" => -1,
                "msg" =>L("class_err"),
            );
            exit(json_encode($ret));
        }
        if (!method_exists($controller,$this->actionName)){
            $ret = array(
                "status" => -1,
                "msg" =>L("method_err"),
            );
           exit(json_encode($ret));
        }
        $this->controller = new $controller($this->params);
    }

     public function index()
    {
        $ret = call_user_func(array($this->controller, $this->actionName));
        $ret ? $ret = array("status" => 1, "result" => $ret, "msg" => null) : $ret = array("status" => 0, "msg" => "暂无数据");
        exit(json_encode($ret));
        // if ($this->access_lucency==true)
        //     exit(json_encode($ret));
        // else{
        //     // exit($this->getRandChar(4).base64_encode(json_encode($ret)));
        // }
    }
}