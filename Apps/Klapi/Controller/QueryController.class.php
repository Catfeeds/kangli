<?php
namespace Klapi\Controller;
use Think\Controller;
use Klapi\Common\Util\Token;
class QueryController extends BaseApiController
{
	private $params;
    protected $ImagePath;
    public function __construct($params = null)
    {
        //$this->_initialize(); //tp5.0
        parent::__construct($params); //tp3.2
        $this->params=$params;
        //var_dump($this->params);
        //$this->ImagePath=$this->request->domain().'/Kangli/Public/uploads/product/';
    }
    public function index(){
        //防止频繁刷新 1000毫秒
        if(requ_security(1,1000,'','','')){
            $this->err_get('页面已过期，请刷新页面重新查询');
        }
    }
    //生成验证码
    public function verify(){
        $config = array(
                        'fontSize' =>22, // 验证码字体大小    
                        'length' => 4, // 验证码位数 
                        'useNoise' => true, // 关闭验证码杂点
                        'useImgBg' => false, //是否使用背景图片
                        'imageW' => 170,
                        'imageH' => 45,
                        'useNoise' => true,
                       );
        $verify = new \Think\Verify($config);
        $verify->entry();
        exit;
    }
    //提交和校验证码
    public function query_submit(){
        //防止频繁刷新 1000毫秒
        if(requ_security(1,1000,'','','')){
            $this->err_get('页面已过期，请刷新页面重新查询');
        }
        isset($this->params["fw_code"]) ? $fwcode = $this->params["fw_code"] : $fwcode =''; //防伪码
        isset($this->params["yz_code"]) ? $yz_code = $this->params["yz_code"] : $yz_code =''; //验证码

        if($fwcode=='' || !preg_match("/^[0-9]{10,27}$/",$fwcode)){
            $this->err_get('请正确输入防伪码1');
        }
        // //安全防御
        // //防止频繁刷新 1000毫秒 二次请求时间间隔过短 2000毫秒
        // if(requ_security('1|2',1000,'2000','','')){
        //     sleep(1);
        //     $this->err_get('页面已过期，请刷新页面重新查询1');
        // }

        $is_checkcode=0;
        $ischuhuo=0; 
        //查询次数访问限制 判断是否要输入验证码
        if(requ_security('4|8','','',15,20)){
            $is_checkcode=1;
        }

         //对同一qycode 6小时内调用接口限制  判断是否要输入验证码
        $qycode=substr($fwcode,0,4);
        $Templist = M("Templist");
        $map=array();
        $map['tmp_unitcode']=$qycode;
        $map['tmp_state']=1;
        $map['tmp_addtime']=array('EGT',time()-3600*6); 
        $tlcount = $Templist->where($map)->count();
        
        $map=array();
        $codelen=strlen($fwcode)-4;
        $Model=M();
        $map['a.qy_code']=array('exp','=b.unitcode');
        $map['a.qy_active']=1;
        $map['b.unitcode']=$qycode;
        $map['b.codelen']=$codelen;
        $qydata=$Model->field('a.qy_id,a.qy_code,a.qy_fwkey,a.qy_fwsecret,a.qy_querytimes,b.*')->table('fw_qyinfo a,fw_cust b')->where($map)->find();
        if($qydata){
            $mlength=$qydata['mlength'];
            $msnlength=$qydata['msnlength'];
            $msnlength=$qydata['msnlength'];
            $sntype = substr($qydata['sntype'],0,1);
            $snpr = $qydata['snpr']; //前缀
            if($qydata['qy_querytimes']<$tlcount){
               $is_checkcode=1;
            }
        }else{
           $this->err_get('请输入正确的验证码2');
        }
        //检测验证码
        if($is_checkcode==1){
            $verify = new \Think\Verify();
            // return $verify->check($yz_code,$id);
            if (!$verify->check($yz_code,$id))
            {
                $ret = array("status" => 0,"is_checkcode"=>$is_checkcode,"msg" =>'请输入正确的验证码3');
                exit(json_encode($ret));
            }
        }
        
        //由防伪码找k
        $myk=fwcode_to_k($fwcode,$qycode,$mlength);
        if($myk===false || $myk<=0){
            $msg2='<b>您查询的防伪码：</b>'.$fwcode.'<br><b>查询结果：</b>'.C('SEND_MESSAGE')['msg03'];
            return $msg2;
        }
        
        //由防伪码找物流信息
        $wlinfo=fw_to_wlinfo($fwcode,$myk,$sntype,$snpr,$msnlength);
        if($wlinfo===false){
            if($is_checkcode==1)
            {
                $ret = array("status" => 0,"is_checkcode"=>$is_checkcode,"msg" =>'没有该防伪码或还没发行，谨防假冒或者重新核对输入');
                exit(json_encode($ret)); 
            }
            else
            $this->err_get('没有该防伪码或还没发行，谨防假冒或者重新核对输入');
        }
        if($wlinfo['qty']<=0){
            if($is_checkcode==1)
            {
                $ret = array("status" => 0,"is_checkcode"=>$is_checkcode,"msg" =>'没有该防伪码或还没发行，谨防假冒或者重新核对输入');
                exit(json_encode($ret)); 
            }
            else
            $this->err_get('没有该防伪码或还没发行，谨防假冒或者重新核对输入');
        }
        
        //是否扫码出货
        $map=array();
        $where=array();
        $Shipment= M('Shipment');
        if($wlinfo['code']!=''){
            $where[]=array('EQ',$wlinfo['code']);
        }
        if($wlinfo['tcode']!='' && $wlinfo['tcode']!=$wlinfo['code']){
            $where[]=array('EQ',$wlinfo['tcode']);
        }
        if($wlinfo['ucode']!='' && $wlinfo['ucode']!=$wlinfo['code'] && $wlinfo['ucode']!=$wlinfo['tcode']){
            $where[]=array('EQ',$wlinfo['ucode']);
        }
        $where[]='or';
        $map['ship_barcode'] = $where;
        $map['ship_unitcode']=$qycode;
        $shdata=$Shipment->where($map)->order('ship_id DESC')->find();
        
        $prodata=array();
        if($shdata){
            $Product = M('Product');
            $Dealer = M('Dealer');

            $map2=array();
            $map2['pro_unitcode']=$qycode;
            $map2['pro_id'] = $shdata['ship_pro'];
            $Proinfo = $Product->where($map2)->find();

            if($Proinfo){
                $prodata['pro_name']=$Proinfo['pro_name'];
                $prodata['pro_number']=$Proinfo['pro_number'];
                $prodata['pro_desc']=nl2br($Proinfo['pro_desc']);
                $prodata['pro_pic']=$Proinfo['pro_pic'];
                $prodata['pro_price']=number_format($Proinfo['pro_price'],2);
                $prodata['pro_pic_str']='<img src="'.__ROOT__.'/Public/uploads/product/'.$Proinfo['pro_pic'].'"  border="0">'; 
            }
            
            $map2=array();
            $map2['dl_unitcode']=$qycode;
            $map2['dl_id'] = $shdata['ship_dealer'];
            $Dealerinfo = $Dealer->where($map2)->find();
            if($Dealerinfo){
                    $prodata['dl_name']=$Dealerinfo['dl_name'];
                    $prodata['dl_weixin']=$Dealerinfo['dl_weixin'];
                    $prodata['dl_number']=$Dealerinfo['dl_number'];
                  
                    $Dltype= M('Dltype');
                    $map4=array();
                    $map4['dlt_unitcode']=$qycode;
                    $map4['dlt_id']=$Dealerinfo['dl_type'];
                    $data4 = $Dltype->where($map4)->find();
                    if($data4){
                        $prodata['dlt_name']=$data4['dlt_name'];
                    }
            }
            $ischuhuo=1; 
        }
        //从接口获取数据
        $ip=real_ip();
        $fwkey=$this->qy_fwkey;
        $timestamp=time();
        $qy_fwsecret=$this->qy_fwsecret;

        $signature=MD5($fwkey.$fwcode.$timestamp.$qy_fwsecret);
        $url='http://www.cn315fw.com/fwapi/Getres?fwkey='.urlencode($fwkey).'&ip='.urlencode($ip).'&fwcode='.urlencode($fwcode).'&signature='.urlencode($signature).'&timestamp='.urlencode($timestamp).'&referer='.urlencode($referer);  
            
        $data=@file_get_contents($url);
        if($data===FALSE){
            if($is_checkcode==1)
            {
                $ret = array("status" => 0,"is_checkcode"=>$is_checkcode,"msg" =>'请正确输入防伪码4');
                exit(json_encode($ret)); 
            }
            else
            $this->err_get('请正确输入防伪码5');
        }else{
            $data_arr=json_decode($data,true); 
            if(!is_array($data_arr)){
                if($is_checkcode==1)
                {
                    $ret = array("status" => 0,"is_checkcode"=>$is_checkcode,"msg" =>'请正确输入防伪码6');
                    exit(json_encode($ret)); 
                }
                else
                $this->err_get('请正确输入防伪码7');
            }else{
                $data_arr['prodata']=$prodata;
                $data_arr['ischuhuo']=$ischuhuo;
                //记录查询次数 cookie
                $requesttimes=floor(\Org\Util\Funcrypt::authcode(cookie('requesttimes'),'DECODE',C('WWW_AUTHKEY'),0));
                cookie('requesttimes',\Org\Util\Funcrypt::authcode($requesttimes+1,'ENCODE',C('WWW_AUTHKEY'),0),1800);
                return $data_arr;
            }
        }   
    }
}