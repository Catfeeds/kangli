<?php
namespace Klapi\Controller;
use Think\Controller;
use think\Cache;
use Klapi\Common\Util\McryptAES;
//虚拟主机路径
define('BASEHOST',$_SERVER["HTTP_HOST"]);
define('IMGTEMP',BASEHOST.'/Kangli/Public/uploads/temp/');
define('IMGPATH',BASEHOST.'/Kangli/Public/uploads/mobi/');
define('PROPATH',BASEHOST.'/Kangli/Public/uploads/product/');
define('DLPATH',BASEHOST.'/Kangli/Public/uploads/dealer/');
define('ODPATH',BASEHOST.'/Kangli/Public/uploads/orders/');
class BaseApiController extends Controller
    {
    	protected $request;
    	protected $param;
    	protected $aes; //加解密类
    	protected $appbaseinfo; //app信息
    	protected $qy_unitcode;
	    protected $qy_mpwxappid;
	    protected $qy_fwkey;
	    protected $qy_fwsecret;
	    protected $qy_appname;
	    protected $randchar='';
	    protected $captcha;
	    private $msg;
        public function _initialize()
        {
        	$header=getallheaders();
            $param=I('param.');
            if (!is_not_null($param)&&IS_POST)
            {
               $param_str=file_get_contents("php://input"); //php7.0已移除这个$GLOBALS['HTTP_RAW_POST_DATA']全局变量
               $param[$param_str]='';
            }
            // var_dump($_FILES);
        	$this->request['header']=$header;
        	$this->request['param']=$param;
        	$appbaseinfo=C('appbaseinfo');
        	$this->qy_unitcode=$appbaseinfo['QY_UNITCODE'];
	        $this->qy_mpwxappid=$appbaseinfo['QY_MPWXAPPID'];
	        $this->qy_fwkey=$appbaseinfo['QY_FWKEY'];
	        $this->qy_fwsecret=$appbaseinfo['QY_FWSECRET'];
	        $this->qy_appname=$appbaseinfo['QY_APPNAME'];
	        $this->fanli_banks=$appbaseinfo['FANLI_BANKS'];
	        $this->www_authkey=$appbaseinfo['WWW_AUTHKEY'];
	        $this->randchar=$this->getRandChar(8);
	        $this->aes=new McryptAES('Kanglimpwx@9999.','klmpwx9999999999');
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

    //判断登录 经销商 用户名登录  
    public function is_jxuser_login($user_id=''){
        $headerArr=$this->request['header'];
        $ttamp= $headerArr['ttamp'];
        $randomchar= $headerArr['randomchar'];
        $user_time= $headerArr['uttamp'];
        $user_uuid= $headerArr['user_uuid'];
        $user_token= $headerArr['user_token'];
        if($user_id==''|| $user_time==''||$user_uuid=='' ||$user_token==''){
            return false;
        }else{

            $jxuser_uuid=$this->aes->decrypt($user_uuid);
            $jxuser_id=mb_substr($jxuser_uuid,mb_strlen($this->qy_appname.$user_time),mb_strlen($jxuser_uuid)-mb_strlen($this->qy_appname.$user_time),'utf-8');
            if ($user_id!=$jxuser_id)
                return false;
            if (time()-$user_time>7200)
                return false;
            $loginArr=S($jxuser_uuid);
            if (is_not_null($loginArr))
            {
                if (isset($loginArr['jxuser_check']))
                {
                    $jx_user_token_cache=$loginArr['jxuser_check'];
                    if ($user_token!=MD5($ttamp.$randomchar.$jx_user_token_cache))
                    return false;  
                }
                else
                {
                    return false;
                }
            }else
            {
                $Accesstoken=M('Accesstoken');
                $map['at_unitcode']=$this->qy_unitcode;
                $map['at_status']=1;
                $data=$Accesstoken->where($map)->find();
                if($data){
                    if (isset($data['jxuser_check']))
                    {
                        if ($user_token!=MD5($ttamp.$randomchar.$jx_user_token_cache))
                        return false;
                        $loginArr=array(
                        'jxuser_time'=>$data['at_addtime'],
                        'jxuser_id'=>$data['at_userid'],
                        'jxuser_unitcode'=>$data['at_unitcode'],
                        'jxuser_username'=>$data['at_username'],
                        'jxuser_check'=>$data['at_token']
                        );
                        $user_ssid=$this->qy_appname.$data['at_addtime'].$user_id;
                        S($user_ssid,$loginArr,72000);
                    }
                    else
                        return false;
                }else
                {
                    return false;
                }
            }
        }
        return true;
    }

	

	/**
    * 获取apiAccessToken
    */
    public function api_unit_token_get()
    {
        $Qyinfo=M('Qyinfo');
        $map['qy_code']=$this->qy_unitcode;
        $data=$Qyinfo->where($map)->field('qy_fwkey')->find();
        if($data){
            if (isset($data['qy_fwkey']))
            {
                $unit_ssid=strtoupper($this->aes->encrypt($this->qy_appname.$this->qy_unitcode));
                $unit_Token=strtoupper($this->aes->encrypt($data['qy_fwkey']));
				// 缓存数据72000秒
                S($this->qy_appname.$this->qy_unitcode,$unit_Token,72000);
                return array('unit_ssid'=>$unit_ssid,'unit_token'=>$unit_Token);
            }
            else
                err_get(4);
        }else
        {
           err_get(3);
        }
    }
    
    /**
    * 获取apiAccessToken
    */
    public function apiAccessTokenGet()
    {

      $ttamp=time();
      $sture=MD5($this->qy_fwkey.$ttamp.$this->qy_fwsecret);
      session('jxuser_time',$ttamp);
      session('jxuser_sture',$sture);
      $ret=array('ttamp'=>$ttamp,'token'=>$sture);
      return $ret;
      // exit(json_encode($ret));
    }
	

	/**
     *获取随机字符串
     *使用时间戳作为原始字符串，再随机生成五个字符随机插入任意位置，生成新的字符串，保证不重复
     */
    public function getRandChar($length)
    {
       $str = null;
       $strPol = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz";
       $max = strlen($strPol)-1;
       for($i=0;$i<$length;$i++){
        $str.=$strPol[rand(0,$max)];//rand($min,$max)生成介于min和max两个数之间的一个随机整数
       }
       return $str;
    }

    /**
     *获取随机字符串
     *使用时间戳作为原始字符串，再随机生成五个字符随机插入任意位置，生成新的字符串，保证不重复
     */
    public function getSoleRandChar($len)
     {
         $chars='ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz';
         $string=time();
         for(;$len>=1;$len--)
         {
             $position=rand()%strlen($chars);
             $position2=rand()%strlen($string);
             $string=substr_replace($string,substr($chars,$position,1),$position2,0);
         }
         return $string;
    }

     /**
     * dealer_type_get 获取代理类型
     * @param $code
     * @return bool
     */
    public function dealer_type_get()
    {
        isset($this->params["user_id"])?$user_id = $this->params["user_id"]:$user_id = ''; //用户ID
        $Dealer=M('Dealer');
        $map=array();
        $map['dl_id']=$user_id;
        $map['dl_unitcode']=$this->qy_unitcode;
        $map['dl_status']=1;
        $data=$Dealer->where($map)->find();
        if($data){
            return $data['dl_type'];
        }else{
            $this->err_get(4);
        }
    }

    //返回上家ID 根据申请的级别和推荐人的上家 $jxid-推荐人的上家  $apply_level-申请级别 
    public function get_dlbelong($jxid,$apply_level){
        $Dltype = M('Dltype');
        $Dealer = M('Dealer');
        //上家信息-1
        $map=array();
        $data=array();
        $map['dl_id']=intval($jxid);
        $map['dl_unitcode']=$this->qy_unitcode;
        $data=$Dealer->where($map)->find();
        if($data){
            if($data['dl_status']==1){
                //上家的级别-1
                $map2=array();
                $data2=array();
                $map2['dlt_id']=$data['dl_type'];
                $map2['dlt_unitcode']=$this->qy_unitcode;
                $data2=$Dltype->where($map2)->find();
                if($data2){
                    if($apply_level<=$data2['dlt_level']){  //如果申请的级别高于 或 同级 
                        if($data['dl_belong']>0){
                            return $this->get_dlbelong($data['dl_belong'],$apply_level);
                        }else{
                            return 0;
                        }
                    }else{
                        return $data['dl_id'];
                    }
                }else{
                    return false;
                }
            }else{  //上家的上家
                if($data['dl_belong']>0){
                    return $this->get_dlbelong($data['dl_belong'],$apply_level);
                }else{
                    return 0;
                }
            }
        }else{
            return false;
        }
    }
        

    /**
     * 获取全国城市列表
     * 
     */
    public function area_list_get(){
        // $file =file(arealist.json'); //file_get_contents
        // var_dump($file);
        // exit;
        // $files = array();  
        // foreach($file as $v){  
        //   $f = explode('    ',$v);  
        //   //这里用trim()函数去除头尾的空格不起效果，因为是全角格式。所以用功能更强大的正则来去除空格  
        //   $f[1] = mb_ereg_replace('^(　| )+', '', $f[1]);  
        //   array_push($files,$f);  
        // }
        // $file =file_get_contents(APP_PATH.'klapi/libs/arealist.json'); //tp5.0
        $file =file_get_contents(BASE_PATH.'/Public/kangli/js/arealist.json');
        $areaData=json_decode($file,true);
        $proArr=array();
        $propos=-1;
        $citypos=-1;
        $isCity=true;

        foreach($areaData as $key => $value){
            if (isset($areaData[$key]))
            {
                if (mb_substr($key,2,mb_strlen($key)-2,'utf-8')=='0000')
                {
                    $propos++;
                    $citypos=-1;
                    // $cityArr=array('prokey'=>$key,'prov'=>$value,$key=>$cityArr);
                    array_push($proArr,array('prokey'=>$key,'prov'=>$value,'prochild'=>array()));
                }
                else if(mb_substr($key,4,mb_strlen($key)-4,'utf-8')=='00')
                {
                    $citypos++;
                    $isCity=true;
                    array_push($proArr[$propos]['prochild'],array('prokey'=>$key,'prov'=>$value,'prochild'=>array()));
                }else
                {
                    if (is_not_null($proArr[$propos]['prochild'])&&$isCity)
                    {
                        array_push($proArr[$propos]['prochild'][$citypos]['prochild'],array('prokey'=>$key,'prov'=>$value,'prochild'=>array()));
                    }else
                    {
                        $isCity=false;
                        $areaArr=array();
                        array_push($proArr[$propos]['prochild'],array('prokey'=>$key,'prov'=>$value,'prochild'=>array()));
                    }
                }
            }
        }
        return $proArr;
    }


    /*
        upload_files上传图片
     */
	public function upload_files($files,$temppath,$saveType)
    {
        $upload = new \Think\Upload();// 实例化上传类
        $upload->maxSize = 3145728;
        $upload->rootPath = './Public/uploads/'; //临时上传文件夹
        $upload->savePath = '/temp/';
        $upload->saveName = array('uniqid','');
        $upload->exts     = array('jpg', 'gif', 'png', 'jpeg');
        $upload->autoSub  = false; //默认为true 是否生成子目录
        $upload->subName  = array('date','Ymd'); //生成时间的子目录文件夹
        // 上传文件 
        $info=false;
        if (count($files)>1)
        {
            $info =$upload->upload($files);
        }
        else
        {
            $info =$upload->uploadOne($files['file']);     
        }
        if(!$info) {// 上传错误提示错误信息
            // $this->error($upload->getError());
            $this->err_get($upload->getError());
        }else{// 上传成功 获取上传文件信息
            $udloadfiles=array();
            if(count($info) == count($info,1)){
                $filesOjbect=array();  
                $filesOjbect['files_path']=$info['savepath'].$info['savename'];
                $filesOjbect['files_name']=$info['savename'];
                array_push($udloadfiles,$filesOjbect);
            }else{  
                 foreach($info as $k => $v){
                    $udloadfiles['files_path']=$v['savepath'].$v['savename'];
                    $udloadfiles['files_name']=$v['savename'];
                }
            }
            $ret= array("status" => 1, "result" => $udloadfiles, "msg" => null);
            exit(json_encode($ret));
            // $ret=array("data" => $udloadfiles);
            // return $ret;
        }
    }   

    //库存查询
    /*@probean  产品信息
      @dl_id    代理id
     */
    public function mystock($probean='',$dl_id){
        //--------------------------------
        $Model=M();
        //库存订货总量  有效订货（订单状态 已发货 已完成）
        $map4=array();
        $map4['a.od_unitcode'] =$this->qy_unitcode;
        $map4['a.od_state'] = array('in', '3,8');  //完成的订单 
        if ($dl_id>0)
        {
            $map4['a.od_oddlid'] =$dl_id; //下单代理session('jxuser_id')
            $map4['a.od_id'] = array('exp','=b.oddt_odid');
            $map4['a.od_virtualstock']=1; //0--非虚拟库存订单 1--虚拟库存订单
        }
        if ($probean)
        {
            $map4['b.oddt_proid']=$probean['pro_id'];
            // $map4['b.oddt_attrid']=$probean['sc_attrid'];
        }
        $list4 = $Model->table('fw_orders a,fw_orderdetail b')->where($map4)->order('a.od_addtime DESC')->select();
        $oddt_totalqty = 0; //虚拟订货总量
        foreach($list4 as $kk=>$vv){
            //订购数量
            $oddt_unitsqty=0; //每单位包装的数量
            if($vv['oddt_prodbiao']>0){
                $oddt_unitsqty=$vv['oddt_prodbiao'];
                
                if($vv['oddt_prozbiao']>0){
                    $oddt_unitsqty=$oddt_unitsqty*$vv['oddt_prozbiao'];
                }
                
                if($vv['oddt_proxbiao']>0){
                    $oddt_unitsqty=$oddt_unitsqty*$vv['oddt_proxbiao'];
                }
                
                $oddt_totalqty += $oddt_unitsqty*$vv['oddt_qty'];
            }else{
                $oddt_totalqty += $vv['oddt_qty'];
            }
        }

        // var_dump($dl_id);
        // var_dump($oddt_totalqty);
        //下级代理订货总量(包括有效的和未处理的)
        $map4=array();
        $map4['a.od_unitcode'] =$this->qy_unitcode;
        $map4['a.od_state'] = array('in', '0,1,2,3,8');  //完成的订单 
        if ($dl_id>0)
        {
            $map4['a.od_rcdlid'] = $dl_id; //下单代理session('jxuser_id')
            $map4['a.od_id'] = array('exp','=b.oddt_odid');
            $map4['a.od_virtualstock']=1; //0--非虚拟库存订单 1--虚拟库存订单
        }
        if ($probean)
        {
            $map4['b.oddt_proid']=$probean['pro_id'];
            // $map4['b.oddt_attrid']=$probean['sc_attrid'];
        }
        $list4 = $Model->table('fw_orders a,fw_orderdetail b')->where($map4)->order('a.od_addtime DESC')->select();
        
        $virtualshipoddt_totalqty = 0; //下订货总量
        foreach($list4 as $kk=>$vv){
            //订购数量
            $oddt_unitsqty=0; //每单位包装的数量
            if($vv['oddt_prodbiao']>0){
                $oddt_unitsqty=$vv['oddt_prodbiao'];
                
                if($vv['oddt_prozbiao']>0){
                    $oddt_unitsqty=$oddt_unitsqty*$vv['oddt_prozbiao'];
                }
                
                if($vv['oddt_proxbiao']>0){
                    $oddt_unitsqty=$oddt_unitsqty*$vv['oddt_proxbiao'];
                }
                
                $virtualshipoddt_totalqty += $oddt_unitsqty*$vv['oddt_qty'];
            }else{
                $virtualshipoddt_totalqty += $vv['oddt_qty'];
            }
        } 
     
        //实际发货总量(包括有效的和未处理的)
        $map4=array();
        $map4['a.od_unitcode'] = $this->qy_unitcode;
        $map4['a.od_state'] = array('in', '0,1,2,3,8');  //完成的订单
        if ($dl_id>0) 
        {
            $map4['a.od_oddlid'] =$dl_id; //下单代理session('jxuser_id')
            $map4['a.od_id'] = array('exp','=b.oddt_odid');
            $map4['a.od_virtualstock']=0; //0--非虚拟库存订单 1--虚拟库存订单
        }
        if ($probean)
        {
            $map4['b.oddt_proid']=$probean['pro_id'];
            // $map4['b.oddt_attrid']=$probean['sc_attrid'];
        }

        $list4 = $Model->table('fw_orders a,fw_orderdetail b')->where($map4)->order('a.od_addtime DESC')->select();
        $shipoddt_totalqty = 0; //实际发货总量
        foreach($list4 as $kk=>$vv){
                //订购数量
                $oddt_unitsqty=0; //每单位包装的数量
                if($vv['oddt_prodbiao']>0){
                    $oddt_unitsqty=$vv['oddt_prodbiao'];
                    
                    if($vv['oddt_prozbiao']>0){
                        $oddt_unitsqty=$oddt_unitsqty*$vv['oddt_prozbiao'];
                    }
                    
                    if($vv['oddt_proxbiao']>0){
                        $oddt_unitsqty=$oddt_unitsqty*$vv['oddt_proxbiao'];
                    }
                    
                    $shipoddt_totalqty += $oddt_unitsqty*$vv['oddt_qty'];
                }else{
                    $shipoddt_totalqty += $vv['oddt_qty'];
                }

        }
        //剩余库存
        $surplusqty=$oddt_totalqty-$virtualshipoddt_totalqty-$shipoddt_totalqty;
        if (intval($surplusqty)<0)
        $surplusqty=0;
        return intval($surplusqty);
    }

     /**
     * 错误类型提示
     * @param  [type] $errtype [description]
     * @return [type]          [description]
     */
    public function err_get($errtype=0,$msg='')
    {
        $errtype>0?$msg=$msg:$msg!=''?$msg=$msg:$msg=$errtype;
        // $ret = array("status" => 0, "msg" =>'网络有误,请重试');
        switch ($errtype) {
            case 1:
                $ret = array("status" => 0, "msg" =>'暂无数据');
                break;
            case 2:
                $ret = array("status" => 0, "msg" =>'对不起，该链接已超时');
            break;
            case 3:
                $ret = array("status" => 0, "msg" =>'对不起,您没有该权限');
            break;
            case 4:
                $ret = array("status" => 0, "msg" =>'参数或企业信息配置有误');
            break;
            case 5:
                $ret = array("status" => 0, "msg" =>'请先登录',"isout"=>1);
            break;
            case 6:
                $ret = array("status" => 0, "msg" =>'登录已超时，请重试',"isout"=>1);
            break;
            case 7:
                $ret = array("status" => 0, "msg" =>'请正确输入密码');
            break;
            case 8:
                $ret = array("status" => 0, "msg" =>'两次新密码输入不一致');
            break;
            case 9:
                $ret = array("status" => 0, "msg" =>'用户不存在');
            break;
            case 10:
                $ret = array("status" => 0, "msg" =>'请输入正确的验证码');
            break;
            case 11:
                $ret = array("status" => 0, "msg" =>'请选择上传文件');
            break;
            case 12:
                $ret = array("status" => 0, "msg" =>'上传图片失败');
            break;
            case 13:
                $ret = array("status" => 0, "msg" =>'该邀请级别不存在');
            break;            
            case 14:
                $ret = array("status" => 0, "msg" =>'所填写推荐人还没审核或不存在');
            break;
            case 15:
                $ret = array("status" => 0, "msg" =>'该代理上家不存在');
            break;
            case 16:
                $ret = array("status" => 0, "msg" =>'代理申请提交失败');
            break;            
            case 17:
                $ret = array("status" => 0, "msg" =>'该邀请链接已失效');
            break;
            case 18:
                $ret = array("status" => 0, "msg" =>'请选择颜色');
            break;
            case 19:
                $ret = array("status" => 0, "msg" =>'请选择尺码');
            break;
            case 20:
                $ret = array("status" => 0, "msg" =>'选择颜色尺码不存在');
            break;
            case 21:
                $ret = array("status" => 0, "msg" =>'该产品还没设置代理价格，暂不能订购');
            break;            
            case 22:
                $ret = array("status" => 0, "msg" =>'添加入购物车失败');
            break;
            case 23:
                $ret = array("status" => 0, "msg" =>'该购物车记录已移除');
            break;
            case 24:
                $ret = array("status" => 0, "msg" =>'购物车不能为空');
            break;
            case 25:
                $ret = array("status" => 0, "msg" =>'请选择收货地址');
            break;
            case 26:
                $ret = array("status" => 0, "msg" =>'提交订单失败');
            break;            
            case 27:
                $ret = array("status" => 0, "msg" =>'地址修改失败');
            break;           
            case 28:
                $ret = array("status" => 0, "msg" =>'地址修改记录');
            break;
            case 29:
                $ret = array("status" => 0, "msg" =>'地址新增失败');
            break;              
            case 30:
                $ret = array("status" => 0, "msg" =>'没有该记录');
            break;
            case 31:
                $ret = array("status" => 0, "msg" =>'必须保持唯一的默认地址');
            break;            
            case 32:
                $ret = array("status" => 0, "msg" =>'默认地址，暂不能删除');
            break;             
            case 33:
                $ret = array("status" => 0, "msg" =>'请正确输入代理商微信号/手机号');
            break;  
            case 34:
                $ret = array("status" => 0, "msg" =>'申请代理级别不存在');
            break; 
            case 35:
                $ret = array("status" => 0, "msg" =>'推荐代理级别不存在');
            break; 
            case 36:
                $ret = array("status" => 0, "msg" =>'审核失败');
            break;              
            case 37:
                $ret = array("status" => 0, "msg" =>'该经销商含有下级，暂不能删除');
            break;            
            case 38:
                $ret = array("status" => 0, "msg" =>'该经销商含有出货记录，暂不能删除');
            break; 
            case 39:
                $ret = array("status" => 0, "msg" =>'原级别记录不存在');
            break;              
            case 40:
                $ret = array("status" => 0, "msg" =>'您还有调级的申请没审批，暂时无法再次申请');
            break;              
            case 41:
                $ret = array("status" => 0, "msg" =>'请选择调整级别');
            break;           
            case 42:
                $ret = array("status" => 0, "msg" =>'上家级别不存在，请与公司联系');
            break;               
            case 43:
                $ret = array("status" => 0, "msg" =>'申请调整的级别要高于原来的级别');
            break; 
            case 44:
                $ret = array("status" => 0, "msg" =>'提交失败');
            break;              
            case 45:
                $ret = array("status" => 0, "msg" =>'该订单已处理，不能取消');
            break;
            case 46:
                $ret = array("status" => 0, "msg" =>'该订单还没发货，不能确认收货');
            break;  
            case 47:
                $ret = array("status" => 0, "msg" =>'请输入正确的条码');
            break;             
            case 48:
                $ret = array("status" => 0, "msg" =>'该订单暂不能出货');
            break;               
            case 49:
                $ret = array("status" => 0, "msg" =>'扫描产品数大于要发货的产品数');
            break;
            case 50:
                $ret = array("status" => 0, "msg" =>'已扫产品数量已够');
            break;   
            case 51:
                $ret = array("status" => 0, "msg" =>'没有扫描纪录');
            break;  
            case 52:
                $ret = array("status" => 0, "msg" =>'下单代理商已被停用');
            break;             
            case 53:
                $ret = array("status" => 0, "msg" =>'该订单还没完成出货');
            break;                
            case 54:
                $ret = array("status" => 0, "msg" =>'该订单出货的数量大于订购数量');
            break;              
            case 55:
                $ret = array("status" => 0, "msg" =>'对不起,购物车为空');
            break;  
            case 56:
                $ret = array("status" => 0, "msg" =>'该出货记录对应订单已发货，暂不能删除');
            break; 
            case 57:
                $ret = array("status" => 0, "msg" =>'该出货记录对应订单已发货，暂不能删除');
            break;     
            case 58:
                $ret = array("status" => 0, "msg" =>'该出货记录对应订单已确认收货，暂不能删除');
            break;             
            case 59:
                $ret = array("status" => 0, "msg" =>'该出货记录已被下级经销商重新出货，暂不能删除');
            break;      
            default:
                $ret = array("status" => 0, "msg" => $msg!=''?$msg=$msg:$msg='网络有误,请重试');
            break;
        }
        exit(json_encode($ret));
    }

    public function _empty()
    {
      header('HTTP/1.0 404 Not Found');
      echo'error:404';
      exit;
    }

}