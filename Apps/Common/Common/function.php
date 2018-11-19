<?php
/**
* 检测变量是否为空  当 $value = ('' null array() false 0)  返回false
**/
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
//检测字符串是否utf
function is_utf8($string) //函数一
{
    return preg_match('%^(?:
    [\x09\x0A\x0D\x20-\x7E] 
    | [\xC2-\xDF][\x80-\xBF] 
    | \xE0[\xA0-\xBF][\x80-\xBF] 
    | [\xE1-\xEC\xEE\xEF][\x80-\xBF]{2} 
    | \xED[\x80-\x9F][\x80-\xBF] 
    | \xF0[\x90-\xBF][\x80-\xBF]{2} 
    | [\xF1-\xF3][\x80-\xBF]{3} 
    | \xF4[\x80-\x8F][\x80-\xBF]{2}
    )*$%xs', $string);
}
//判断是否属手机
function is_mobile() {
    $user_agent = $_SERVER['HTTP_USER_AGENT'];
    $mobile_agents = array('iphone', 'android', 'phone', 'mobile', 'wap', 'netfront', 'java', 'opera mobi', 'opera mini','ucweb', 'windows ce', 'symbian', 'series', 'webos', 'sony', 'blackberry', 'dopod', 'nokia', 'samsung','palmsource', 'xda', 'pieplus', 'meizu', 'midp', 'cldc', 'motorola', 'foma', 'docomo', 'up.browser','up.link', 'blazer', 'helio', 'hosin', 'huawei', 'novarra', 'coolpad', 'webos', 'techfaith', 'palmsource','alcatel', 'amoi', 'ktouch', 'nexian', 'ericsson', 'philips', 'sagem', 'wellcom', 'bunjalloo', 'maui', 'smartphone','iemobile', 'spice', 'bird', 'zte-', 'longcos', 'pantech', 'gionee', 'portalmmm', 'jig browser', 'hiptop','benq', 'haier', '^lct', '320x320', '240x320', '176x220');
    $is_mobile = false;
    foreach ($mobile_agents as $device) {
        if (stristr($user_agent, $device)) {
            $is_mobile = true;
            break;
        }
    }
    return $is_mobile;
}
/**
* gb2312 转utf8 编码
**/
function get_gb_to_utf8($value,$toutf=1){
    $value_1= $value;
    $value_2   =   @iconv( "GBK", "utf-8//IGNORE",$value_1);
    $value_3   =   @iconv( "utf-8", "GBK//IGNORE",$value_1);
    if($toutf==1)
    {
        return   $value_2;
    }else{
        return   $value_3;
    }

}

/**
  针对微信emoji表情 将emoji的unicode留下，其他不动 用于存入 db
 */
function wxuserTextEncode($str){
    if(!is_string($str))return $str;
    if($str=='')return '';
    $text = json_encode($str); //暴露出unicode
    $text = preg_replace_callback("/(\\\u[ed][0-9a-f]{3})/i",function($str){
        return addslashes($str[0]);
    },$text); //将emoji的unicode留下，其他不动，
    return json_decode($text);
}

/**
  针对微信emoji表情 将两条斜杠变成一条，其他不动 用于从db取出 还原
 */
function wxuserTextDecode($str){
    $text = json_encode($str); //暴露出unicode
    $text = preg_replace_callback('/\\\\\\\\/i',function($str){
        return '\\';
    },$text); //将两条斜杠变成一条，其他不动
    return json_decode($text);
}

/**
  针对微信emoji表情 先将emoji unicode 换成空格 将两条斜杠变成一条，其他不动
 */
function wxuserTextDecode2($str){
    $text = json_encode($str); //暴露出unicode
    $text = preg_replace_callback('/(\\\u[ed][0-9a-f]{3})/i',function($str){
        return '\u3000';
    },$text); //换成空格
	
	$text = preg_replace_callback('/\\\\\\\\/i',function($str){
        return '\\';
    },$text); //将两条斜杠变成一条，其他不动
    return json_decode($text);
}


/**
* 获取产品类型的所有子类,包括该类"1,2,3,5"
**/
function get_son_type_id($tid){
    $Protype = M('Protype');
    $map4['protype_unitcode']=session('unitcode');
    $map4['protype_iswho'] = $tid;
    $res4 = $Protype->where($map4)->order('protype_order ASC')->select();
    $select_type_id='';
    if($res4 && count($res4)>0){
        foreach($res4 as $k=>$v){
            $select_type_id.=get_son_type_id($v['protype_id']).',';
        }
        $select_type_id.=$tid;
    }else{
        $select_type_id=$tid;
    }
    return $select_type_id; 
}

/**
 * 截取UTF-8编码下字符串的函数
 *
 * @param   string      $str        被截取的字符串
 * @param   int         $length     截取的长度
 * @param   bool        $append     是否附加省略号
 *
 * @return  string
 */
function sub_str($str, $length = 0, $append = true)
{
    $str = trim($str);
    $strlength = str_len($str);

    if ($length == 0 || $length >= $strlength)
    {
        return $str;
    }
    elseif ($length < 0)
    {
        $length = $strlength + $length;
        if ($length < 0)
        {
            $length = $strlength;
        }
    }

    if (function_exists('mb_substr'))
    {
        $newstr = mb_substr($str, 0, $length, 'utf-8');
    }
    elseif (function_exists('iconv_substr'))
    {
        $newstr = iconv_substr($str, 0, $length, 'utf-8');
    }
    else
    {
        $newstr = substr($str, 0, $length);
    }

    if ($append && $str != $newstr)
    {
        $newstr .= '...';
    }

    return $newstr;
}
/**
 * 计算字符串的长度（汉字按照两个字符计算）
 *
 * @param   string      $str        字符串
 *
 * @return  int
 */
function str_len($str)
{
    $length = strlen(preg_replace('/[\x00-\x7F]/', '', $str));

    if ($length)
    {
        return strlen($str) - $length + intval($length / 3) * 2;
    }
    else
    {
        return strlen($str);
    }
}

/**
 * 写入日志
 *
 * @param  
 *
 */
function save_log($data=array())
{   
    if(count($data)>0){
        $Log= M('Log');
        $Log->create($data,1);
        $Log->add(); 
    }
}
/**
 * 获得用户的真实IP地址
 *
 * @access  public
 * @return  string
 */
function real_ip()
{
    static $realip = NULL;

    if ($realip !== NULL)
    {
        return $realip;
    }

    if (isset($_SERVER))
    {
        if (isset($_SERVER['HTTP_X_FORWARDED_FOR']))
        {
            $arr = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);

            /* 取X-Forwarded-For中第一个非unknown的有效IP字符串 */
            foreach ($arr AS $ip)
            {
                $ip = trim($ip);

                if ($ip != 'unknown')
                {
                    $realip = $ip;

                    break;
                }
            }
        }
        elseif (isset($_SERVER['HTTP_CLIENT_IP']))
        {
            $realip = $_SERVER['HTTP_CLIENT_IP'];
        }
        else
        {
            if (isset($_SERVER['REMOTE_ADDR']))
            {
                $realip = $_SERVER['REMOTE_ADDR'];
            }
            else
            {
                $realip = '0.0.0.0';
            }
        }
    }
    else
    {
        if (getenv('HTTP_X_FORWARDED_FOR'))
        {
            $realip = getenv('HTTP_X_FORWARDED_FOR');
        }
        elseif (getenv('HTTP_CLIENT_IP'))
        {
            $realip = getenv('HTTP_CLIENT_IP');
        }
        else
        {
            $realip = getenv('REMOTE_ADDR');
        }
    }

    preg_match("/[\d\.]{7,15}/", $realip, $onlineip);
    $realip = !empty($onlineip[0]) ? $onlineip[0] : '0.0.0.0';

    return $realip;
}
/**
 * 根据物流条码对应包装信息
 *
 * @param   $wlcode-物流条码 $unitcode-企业代号 $packtype-包装类型
 *
 * @return  array
 */

function wlcode_to_packinfo($wlcode='',$unitcode=''){
    $barcode=array();
    if($wlcode=='' || $unitcode==''){
       return false;
    }
    $map['unitcode']=$unitcode;
    $Cust= M('Cust');
    $custdata=$Cust->where($map)->find();
    if(!$custdata){
        return false;   
    }


    //现从缓存表获得 如没有再执行下面

    //物流码类型 （0-无物流码 1-1码两用 2-双码流水号 3-双码乱码 4-双码流水号2）
    $mysntype = substr($custdata['sntype'],0,1);
    $mysnpr = $custdata['snpr']; //前缀
    $mlength = $custdata['mlength'];
    $msnlength = $custdata['msnlength'];
    $mysnprlen =strlen($mysnpr);
    $wlcodelen=strlen($wlcode);

    switch ($mysntype){
         case '1':    //1-1码两用
              $num = fwcode_to_k($wlcode, $unitcode, $mlength);
              $barcode = wlcode_to_wlinfo($wlcode,$unitcode, $num, $mysntype, $mysnpr,$msnlength,0);
              break;
         case '2':    //2-双码流水号
              $num = 1;
              if (($wlcodelen - $mysnprlen) == 8)
              {
                  if (substr($wlcode,$mysnprlen,1) == "9")
                  {
                      $barcode = wlcode_to_wlinfo($wlcode,$unitcode, $num, $mysntype, $mysnpr,$msnlength, 1);
                  }
                  else if (substr($wlcode,$mysnprlen,1) == "9")
                  {
                      $barcode = wlcode_to_wlinfo($wlcode,$unitcode, $num, $mysntype, $mysnpr,$msnlength, 2);
                  }
                  else
                  {
                      $barcode = wlcode_to_wlinfo($wlcode,$unitcode, $num, $mysntype, $mysnpr,$msnlength, 3);
                  }
              }
              break;
         case '3':    //3-双码乱码
              $num = wlcode_to_k(substr($wlcode,$mysnprlen, $wlcodelen - $mysnprlen),$unitcode,$msnlength);
              $barcode = wlcode_to_wlinfo($wlcode,$unitcode, $num, $mysntype, $mysnpr,$msnlength, 0);
              break;
         case '4':    //4-双码流水号2
            $num = 1;
            $barcode = wlcode_to_wlinfo($wlcode,$unitcode, $num, $mysntype, $mysnpr,$msnlength, 4);
            break;
    }
    if (($barcode) && $barcode['qty'] > 0){
        $barcode['unitcode'] = $unitcode;
        return $barcode;
    }else{
        return false;
    }
  
}
/**
 * 根据物流条码返回条码信息
 *
 * @param   $wlcode-物流条码 $unitcode-企业代号  ucode-大标 tcode-中标 code-当前条码
 *
 * @return  array
 */
function wlcode_to_wlinfo($wlcode='',$unitcode='',$myk='',$mysntype=0,$mysnpr='',$mlen=0,$op=0){
    if($wlcode=='' || $unitcode==''){
       return false;
    }
    $barcode=array('code'=>'','ucode'=>'','tcode'=>'','qty'=>'','snk'=>'','sellrecordid'=>'');
    $barcode['code']=$wlcode;
    $barcode['snk']=$myk;


    $Sellrecord= M('Sellrecord');
    if($op==1){
        $map['unitcode']=$unitcode;
        $records=$Sellrecord->where($map)->order('fid DESC')->select();
        $record=array();
        foreach($records as $k=>$v){ 
            $dsnf=$v['dsnf'];
            $dsnt=$v['dsnt'];
            if(strcasecmp($dsnf,$wlcode)<=0 && strcasecmp($dsnt,$wlcode)>=0){
                $record=$v;
                break;
            }
        }
    }elseif($op==2){
        $map['unitcode']=$unitcode;
        $records=$Sellrecord->where($map)->order('fid DESC')->select();
        $record=array();
        foreach($records as $k=>$v){ 
            $zsnf=$v['zsnf'];
            $zsnt=$v['zsnt'];
            if(strcasecmp($zsnf,$wlcode)<=0 && strcasecmp($zsnt,$wlcode)>=0){
                $record=$v;
                break;
            }
        }
    }elseif($op==3){
        $map['unitcode']=$unitcode;
        $records=$Sellrecord->where($map)->order('fid DESC')->select();
        $record=array();
        foreach($records as $k=>$v){ 
            $snbegin=$v['snbegin'];
            $snend=$v['snend'];
            if(strcasecmp($snbegin,$wlcode)<=0 && strcasecmp($snend,$wlcode)>=0){
                $record=$v;
                break;
            }
        }
    }elseif($op==4){
        $map['unitcode']=$unitcode;
        $records=$Sellrecord->where($map)->order('fid DESC')->select();
        $record=array();

        foreach($records as $k=>$v){ 
            $snbegin=$v['snbegin'];
            $snend=$v['snend'];
            $pdqty=$v['pdqty'];
            $pzqty=$v['pzqty'];
            $pxqty=$v['pxqty'];
            $sxqty=$v['sxqty'];

            if(strlen($wlcode)==strlen($snbegin) && strlen($wlcode)==strlen($snend)){ //大标
                $snend2=$snend;
				$snend3=$snend;
            }else{   
                if(strlen($wlcode)>strlen($snbegin)){
                     if($pzqty>0){
                        $snend2=$snend.$pzqty.$pxqty;
						$snend3=substr($wlcode,0,strlen($snbegin)).$pzqty.$pxqty;
						
						if(strlen($wlcode)==strlen($snend2)){
							
						}else if(strlen($wlcode)==strlen($snend.$pzqty)){
							
						}else{
							continue;
						}
                     }else{
                        $snend2=$snend.$sxqty;
						$snend3=substr($wlcode,0,strlen($snbegin)).$sxqty;
						
						if(strlen($wlcode)!=strlen($snend2)){
							continue;
						}
                     }
                }else{
                    continue;
                }
            }
            if(strcasecmp($snbegin,$wlcode)<=0 && strcasecmp($snend2,$wlcode)>=0 && strcasecmp($snend3,$wlcode)>=0){
                $record=$v;
                break;
            }
        }
    }else{
        $map['unitcode']=$unitcode;
        $map['mybegin']=array('ELT',$myk);//<=
        $records=$Sellrecord->where($map)->order('mybegin DESC')->select(); 
        $record=array();
        foreach($records as $k=>$v){ 
            $mybegin=$v['mybegin'];
            $sellcount=$v['sellcount'];
            if(($mybegin+$sellcount)>=$myk){
                $record=$v;
                break;
            }
        }
    }
    if(!$record){
        return false;
    }

    $packtype=substr($record['packtype'],0,1);//包装类别（0-无需考虑 1-单个包装 2-大小包装 3-大中小包装） str
    $num4=$record['pdqty'];//包装比例 大 num4
    $num5=$record['pzqty'];//包装比例 中 num5
    $num7=$record['pxqty'];//包装比例 小 num7
    $num6=$record['sxqty'];//包装小标数量
    $myBegin=$record['mybegin'];//起始数量 num8
    $snbegin=$record['snbegin'];//起始流水码 str2
    $mqty=$record['mqty'];  //码数  num9
    $barcode['sellrecordid']=$record['fid'];  //
    
    if($packtype==0){
        return false;
    }
    $num10 = strlen($snbegin);
    $wlcodelen = strlen($wlcode);
    $mysnprlen= strlen($mysnpr);


    //物流码类型 （0-无物流码 1-1码两用 2-双码流水号 3-双码乱码 4-双码流水号2）
    if($mysntype!=1){
        //2-双码流水号
        if($mysntype==2){
            switch ($packtype){
                case '1':    //1-单个包装
                    $barcode['Qty']=1;
                    break;
                case '2':    //2-大小包装
                    if($op==1){
                        $barcode['qty']=$num6;
                    }else{
                        $barcode['qty']=1;
                        $num11 = substr($wlcode,$mysnprlen,8);
                        $num12 = ($myBegin + (($num11- $myBegin) / $num7)) + 10000000;
                        $barcode['ucode'] = $mysnpr.'9'.substr($num12,1,7);
                        $barcode['tcode'] = $barcode['ucode'];
                    }

                    break;
                case '3':    //3-大中小包装
                    if ($op == 1){
                        $barcode['qty']=$num6 * $num5 ;
                        return $barcode;
                    }elseif ($op == 2){
                        $barcode['qty']=$num6;
                        $num11 = $myBegin + substr($wlcode,$mysnprlen+1,7)/$num5;
                        $num12 = $num11 + 10000000;
                        $barcode['ucode'] = $mysnpr."9".substr($num12,1,7);
                        $barcode['tcode'] = $barcode['tcode'];
                    }else{
                        $num11 = substr($wlcode,$mysnprlen,8);
                        $barcode['qty']=1;
                        $num12 = ($myBegin + (($num11- $myBegin) / $num7)) + 10000000;
                        $barcode['tcode'] = $mysnpr."8".substr($num12,1,7);
                        $num12 = ($myBegin + (($num11- $myBegin) / ($num7*$num5))) + 10000000;
                        $barcode['ucode'] = $mysnpr."9".substr($num12,1,7);
                    }
                    break;
            }
            return $barcode;
        }
        //3-双码乱码 
        if($mysntype==3){
            switch ($packtype){
              case '1':    //1-单个包装
                  $barcode['qty']=1;
                  break;
              case '2':    //2-大小包装 floor round

                  $num = $myBegin + (($num7 + 1) * (floor(($myk - $myBegin) / ($num7 + 1))));

                  if ($num == $myk){
                      $barcode['qty'] = $num6;
                  }else{
                      $barcode['qty'] = 1;
                      $barcode['tcode'] = $mysnpr.k_to_wlcode($num, $unitcode,$mlen);
                      $barcode['ucode'] = $barcode['tcode'];
                  }
                  break;
              case '3':    //3-大中小包装
                  $num = $myBegin + (((($num7 * $num5) + $num5) + 1) * (($myk - $myBegin) / (((($num7 * $num5) + $num5) + 1))));
                  $num2 = ($num + 1) + (((($myk - $num) - 1) / (($num7 + 1))) * ($num7 + 1));
                  if ($num == $myk){
                      $barcode['qty']=$num6 * $num5 ;
                      return $barcode;
                  }
                  if ($num2 == $myk){
                      $barcode['qty'] = $num6;
                      $barcode['tcode'] = $mysnpr . k_to_wlcode($num, $unitcode,$mlen);
                      $barcode['ucode'] = $mysnpr . k_to_wlcode($num, $unitcode,$mlen);
                  }
                  else
                  {
                    $barcode['qty'] = 1;
                    $barcode['tcode'] = $mysnpr . k_to_wlcode($num2, $unitcode,$mlen);
                    $barcode['ucode'] = $mysnpr . k_to_wlcode($num, $unitcode,$mlen);
                  }
                  break;
            }
            return $barcode;

        }
        //0-无物流码 ok 
        if($mysntype!=4){  
            return false;
        }
        if ($wlcodelen < $num10){
            return false;
        }
        //4-双码流水号2
            //1-单个包装
        if ($packtype == 1){
              $barcode['qty']=1;
        }
            //2-大小包装
        if ($packtype == 2){
            if ($num10 == $wlcodelen){
                $barcode['qty']=$num6;
            }else{
                $barcode['qty']=1;
                $barcode['tcode'] = $mysnpr . substr($wlcode,0,$wlcodelen-strlen($num7));
                $barcode['ucode'] = $barcode['tcode'];
            }
        }
            //3-大中小包装
        if ($packtype == 3){
            if ($num10 == $wlcodelen){
                $barcode['qty'] = $num6 * $num5;
                return $barcode;
            }
            if (($num10 + strlen($num5)) == $wlcodelen)
            {
                $barcode['qty'] = $num6;
                $barcode['tcode'] = $mysnpr . substr($wlcode,0,$wlcodelen-strlen($num5));
                $barcode['ucode'] = $barcode['tcode'];
            }
            else
            {
                $barcode['qty'] = 1;
                $barcode['tcode'] = $mysnpr . substr($wlcode,0,$wlcodelen-strlen($num7));
                $barcode['ucode'] = $mysnpr . substr($wlcode,0,($wlcodelen-strlen($num5))-strlen($num7));
            }
        }
        return $barcode;   
    }
    //1-1码两用 
    switch ($packtype){
        case '1':    //1-单个包装
            $barcode['qty']=1;
            break;
        case '2':    //2-大小包装
            $num = $myBegin + (($num7 + 1) * (($myk - $myBegin) / (($num7 + 1))));
            if ($num == $myk)
            {
                $barcode['qty']=$num6;
            }else{
                $barcode['qty'] = 1;
                $barcode['tcode'] = k_to_fwcode($num,$unitcode,$mlen);
                $barcode['ucode'] = $barcode['tcode'];
            }
            break;
        case '3':    //3-大中小包装
            $num = $myBegin + (((($num7 * $num5) + $num5) + 1) * (($myk - $myBegin) / (((($num7 * $num5) + $num5) + 1))));
            $num2 = ($num + 1) + (((($myk - $num) - 1) / (($num7 + 1))) * ($num7 + 1));
            if ($num == $myk){
                $barcode['qty'] = $num6 * $num5;
                return $barcode;
            }
            if ($num2 == $myk)
            {
                $barcode['qty'] = $num6;
                $barcode['tcode'] = k_to_fwcode($num, $unitcode,$mlen);
                $barcode['ucode'] = k_to_fwcode($num, $unitcode,$mlen);
            }
            else
            {
                $barcode['qty'] = 1;
                $barcode['tcode'] = k_to_fwcode($num2, $unitcode,$mlen);
                $barcode['ucode'] = k_to_fwcode($num, $unitcode,$mlen);
            }
            break;
    }
    return $barcode;  
}

/**
 * 根据防伪码返回K
 *
 * @param   $fwcode-防伪码 $unitcode-企业代号 
 *
 * @return  str
 */
 function fwcode_to_k($fwcode='',$unitcode='',$mlength=0){
    $key='';
    $num = 0;
    if($fwcode=='' || $unitcode==''){
       return false;
    }

    $num = $mlength;
    if($num==0){
        return false; 
    }

    $ai=0; 
    $bi=0; 
    $ci=0;
    $len=strlen($fwcode)-4;
    if($len<8){
        return false; 
    }
    switch ($len){
        case 8:
           $ai=3;
           $bi=3;
           $ci=2;
           break;
        case 9:
           $ai=3;
           $bi=3;
           $ci=3;
           break;
        case 10:
           $ai=3;
           $bi=3;
           $ci=4;
           break;
        case 11:
           $ai=3;
           $bi=4;
           $ci=4;
           break;
        case 12:
           $ai=4;
           $bi=4;
           $ci=4;
           break;
        case 13:
           $ai=4;
           $bi=4;
           $ci=5;
           break;
        case 14:
           $ai=4;
           $bi=5;
           $ci=5;
           break;
        case 15:
           $ai=5;
           $bi=5;
           $ci=5;
           break;
        case 16:
           $ai=5;
           $bi=5;
           $ci=6;
           break;
        case 17:
           $ai=5;
           $bi=6;
           $ci=6;
           break;
        case 18:
           $ai=6;
           $bi=6;
           $ci=6;
           break;
        case 19:
           $ai=6;
           $bi=6;
           $ci=7;
           break;   
        case 20:
           $ai=6;
           $bi=7;
           $ci=7;
           break; 
        case 21:
           $ai=7;
           $bi=7;
           $ci=7;
           break; 
        case 22:
           $ai=7;
           $bi=7;
           $ci=8;
           break; 
        case 23:
           $ai=7;
           $bi=8;
           $ci=8;
           break; 
        case 24:
           $ai=8;
           $bi=8;
           $ci=8;
           break; 
        case 25:
           $ai=8;
           $bi=8;
           $ci=9;
           break;
        case 26:
           $ai=8; 
           $bi=9;
           $ci=9;
           break;
        case 27:
           $ai=9;
           $bi=9;
           $ci=9;
           break;              
    }

    $code_a=substr($fwcode,4,$ai);           //从第4位末起截取$ai位  
    $code_b=substr($fwcode,4+$ai,$bi);       //截取$bi位      
    $code_c=substr($fwcode,4+$ai+$bi,$ci);   //截取$ci位  

    $num3 = 0;
    $num4 = 0;
    $num5 = 0;
    $Code= M('Code');

    $map_a['unitcode']=$unitcode;
    $map_a['codea']=$code_a;
    $data_a=$Code->where($map_a)->find();
    if(!$data_a){
        return false;   
    }
    $num3=$data_a['address'];

    $map_b['unitcode']=$unitcode;
    $map_b['codeb']=$code_b;
    $data_b=$Code->where($map_b)->find();
    if(!$data_b){
        return false;   
    }
    $num4=$data_b['address'];

    $map_c['unitcode']=$unitcode;
    $map_c['codec']=$code_c;
    $data_c=$Code->where($map_c)->find();
    if(!$data_c){
        return false;   
    }
    $num5=$data_c['address'];

    if ((($num3 == 0) || ($num4 == 0)) || ($num5 == 0))
    {
        return false;
    }

    $num6 = $num4 - $num3;

    if ($num6 < 0){
        $num6 = ($num + $num4) - $num3;
    }
    $num7 = $num5 - $num3;
    if ($num7 < 0){
        $num7 = ($num + $num5) - $num3;
    }
    $key = (($num3 + ($num * $num6)) + (($num * $num) * $num7));

    return $key;
 }

/**
 * 根据k返回防伪码
 *
 * @param   $myk-k    $unitcode-企业代号 
 *
 * @return  str
 */
function k_to_fwcode($myk='',$unitcode='',$mlength=0){
    $num=$mlength;
    if($myk==0 || $num==0){
        return '';
    }
    $num2 = floor(($myk - 1) / ($num * $num));
    $num3 = (($myk - 1) - (($num * $num) * $num2))/$num;
    $num3 = floor($num3);
    $num4 = ($myk - ($num3 * $num)) - (($num2 * $num) * $num);
    $num5 = $num4 + $num3;

    if(floor($num5)>floor($num)){
       $num5 = $num5-$num;
    }
    $num6 = $num4 + $num2;
    if(floor($num6)>floor($num)){
       $num6 = $num6-$num;
    }

    $Code= M('Code');
    $map_a['unitcode']=$unitcode;
    $map_a['address']=$num4;
    $data_a=$Code->where($map_a)->order('address ASC')->find();
    if($data_a){
        $CodeA=$data_a['codea'];  
    }else{
        return '';
    }

    $map_b['unitcode']=$unitcode;
    $map_b['address']=$num5;
    $data_b=$Code->where($map_b)->order('address ASC')->find();
    if($data_b){
        $CodeB=$data_b['codeb'];  
    }else{
        return '';
    }

    $map_c['unitcode']=$unitcode;
    $map_c['address']=$num6;
    $data_c=$Code->where($map_c)->order('address ASC')->find();
    if($data_c){
        $CodeC=$data_c['codec'];  
    }else{
        return '';
    }

    return $CodeA.$CodeB.$CodeC; 
}

/**
 * 根据k返回物流码 用于双码乱码
 *
 * @param   $myk-k     $unitcode-企业代号 
 *
 * @return  str
 */
function k_to_wlcode($myk='',$unitcode='',$msnlength=0){
    $num=$msnlength;

    if($myk==0 || $num==0){
        return '';
    }

    $num2 = floor(($myk - 1) / ($num * $num));
    $num3 = (($myk - 1) - (($num * $num) * $num2))/$num;
    $num3 = floor($num3);
    $num4 = ($myk - ($num3 * $num)) - (($num2 * $num) * $num);
    $num5 = $num4 + $num3;

    if(floor($num5)>floor($num)){
       $num5 = $num5-$num;
    }
    $num6 = $num4 + $num2;
    if(floor($num6)>floor($num)){
       $num6 = $num6-$num;
    }

    $Snmm= M('Snmm');
    $map_a['unitcode']=$unitcode;
    $map_a['address']=$num4;
    $data_a=$Snmm->where($map_a)->order('address ASC')->find();
    if($data_a){
        $CodeA=$data_a['codea'];  
    }else{
        return '';
    }

    $map_b['unitcode']=$unitcode;
    $map_b['address']=$num5;
    $data_b=$Snmm->where($map_b)->order('address ASC')->find();

    if($data_b){
        $CodeB=$data_b['codeb'];  
    }else{
        return '';
    }

    $map_c['unitcode']=$unitcode;
    $map_c['address']=$num6;
    $data_c=$Snmm->where($map_c)->order('address ASC')->find();
    if($data_c){
        $CodeC=$data_c['codec'];  
    }else{
        return '';
    }
 
    return $CodeA.$CodeB.$CodeC; 
}
/**
 * 根据物流码返回 k  用于双码乱码
 *
 * @param   $wlcode     $unitcode-企业代号 
 *
 * @return  str
 */
function wlcode_to_k($wlcode='',$unitcode='',$msnlength=0){
    $key='';
    $num = 0;
    if($wlcode=='' || $unitcode==''){
       return false;
    }

    $num = $msnlength;
    if($num==0){
        return false; 
    }

    $ai=1; 
    $bi=1; 
    $ci=1;
    $len=strlen($wlcode);
    if($len<8){
        return false; 
    }
    switch ($len){
        case 8:
           $ai=3;
           $bi=3;
           $ci=2;
           break;
        case 9:
           $ai=3;
           $bi=3;
           $ci=3;
           break;
        case 10:
           $ai=3;
           $bi=3;
           $ci=4;
           break;
        case 11:
           $ai=3;
           $bi=4;
           $ci=4;
           break;
        case 12:
           $ai=4;
           $bi=4;
           $ci=4;
           break;
        case 13:
           $ai=4;
           $bi=4;
           $ci=5;
           break;
        case 14:
           $ai=4;
           $bi=5;
           $ci=5;
           break;
        case 15:
           $ai=5;
           $bi=5;
           $ci=5;
           break;
        case 16:
           $ai=5;
           $bi=5;
           $ci=6;
           break;
        case 17:
           $ai=5;
           $bi=6;
           $ci=6;
           break;
        case 18:
           $ai=6;
           $bi=6;
           $ci=6;
           break;
        case 19:
           $ai=6;
           $bi=6;
           $ci=7;
           break;   
        case 20:
           $ai=6;
           $bi=7;
           $ci=7;
           break;            
    }

    $code_a=substr($wlcode,0,$ai);           //从第4位末起截取$ai位  
    $code_b=substr($wlcode,0+$ai,$bi);       //截取$bi位      
    $code_c=substr($wlcode,0+$ai+$bi,$ci);   //截取$ci位  

    $num3 = 0;
    $num4 = 0;
    $num5 = 0;

    $Snmm= M('Snmm');
    $map_a['unitcode']=$unitcode;
    $map_a['codea']=$code_a;
    $data_a=$Snmm->where($map_a)->find();
    if(!$data_a){
        return false;   
    }
    $num3=$data_a['address'];

    $map_b['unitcode']=$unitcode;
    $map_b['codeb']=$code_b;
    $data_b=$Snmm->where($map_b)->find();
    if(!$data_b){
        return false;   
    }
    $num4=$data_b['address'];

    $map_c['unitcode']=$unitcode;
    $map_c['codec']=$code_c;
    $data_c=$Snmm->where($map_c)->find();
    if(!$data_c){
        return false;   
    }
    $num5=$data_c['address'];

    if ((($num3 == 0) || ($num4 == 0)) || ($num5 == 0))
    {
        return false;
    }

    $num6 = $num4 - $num3;

    if ($num6 < 0){
        $num6 = ($num + $num4) - $num3;
    }
    $num7 = $num5 - $num3;
    if ($num7 < 0){
        $num7 = ($num + $num5) - $num3;
    }
    $key = (($num3 + ($num * $num6)) + (($num * $num) * $num7));

    return $key;
}
/**
 * 根据防伪码返回物流码
 *
 * @param      $fwcode-防伪码  $myk--key  $st-物流码类型 $sp-前缀
 *
 * @return  array
 */
function fw_to_wlinfo($fwcode='',$gk='',$st='',$sp='',$msnlength=0){
    $barcode=array('code'=>'','ucode'=>'','tcode'=>'','qty'=>0,'sellrecordid'=>'');
    if(strlen($fwcode)>=8 && strlen($fwcode)<=27){
        $unitcode=substr($fwcode,0,4);
        $Sellrecord= M('Sellrecord');

        $map['unitcode']=$unitcode;
        $map['mybegin']=array('ELT',$gk);//<=
        $records=$Sellrecord->where($map)->order('mybegin DESC')->select(); 
        $record=array();
        foreach($records as $k=>$v){ 
            $mybegin=$v['mybegin'];
            $sellcount=$v['sellcount'];
            if(($mybegin+$sellcount)>=$gk){
                $record=$v;
                break;
            }
        }
        if(!$record){
            return false;
        }

        $packtype=substr($record['packtype'],0,1);//包装类别（0-无需考虑 1-单个包装 2-大小包装 3-大中小包装） str
        $pdqty=$record['pdqty'];//包装比例 大 num4
        $pzqty=$record['pzqty'];//包装比例 中 num5
        $pxqty=$record['pxqty'];//包装比例 小 num6
        $myBegin=$record['mybegin'];//起始数量 num7
        $snbegin=$record['snbegin'];//起始流水码 str2
        $mqty=$record['mqty'];  //码数  num8

        $barcode['sellrecordid']=$record['fid'];

        if($packtype==0){//无需考虑包装
            return false;
        }

        $snbeginlen = strlen($snbegin);//起始流水码长度  length

        //物流码类型 （0-无物流码 1-1码两用 2-双码流水号 3-双码乱码 4-双码流水号2）
        if($st!=1){
            if($st==2){  //2-双码流水号 ok
                $num2=$gk + 100000000;
                $barcode['code']=$sp.substr($num2,1,8);

                switch ($packtype){
                case '1':    //1-单个包装
                    $barcode['qty']=1;
                    break;
                case '2':    //2-大小包装
                    $barcode['qty']=1;
                    $num2 = ($myBegin + (($gk - $myBegin) / $pxqty)) + 10000000;
                    $barcode['ucode'] = $sp.'9'.substr($num2,1,7);
                    $barcode['tcode'] = $barcode['ucode'];
                    break;
                case '3':    //3-大中小包装
                    $barcode['qty']=1;
                    $num2 = ($myBegin + ($gk - $myBegin) / $pxqty) + 10000000;
                    $barcode['tcode'] = $sp."8".substr($num2,1,7);
                    $num2 = ($myBegin + (($sp - $myBegin) / ($pxqty * $pzqty))) + 10000000;
                    $barcode['ucode'] = $sp."9".substr($num2,1,7);
                    break;
                }
                return $barcode;
            }
            if($st==3){  //3-双码乱码
                $barcode['code'] = $sp.k_to_wlcode($gk, $unitcode, $msnlength);
                
                switch ($packtype){
                case '1':    //1-单个包装
                    $barcode['qty']=1;
                    break;
                case '2':    //2-大小包装
                    $num = $myBegin + (($pxqty+ 1) * floor(($gk - $myBegin) / ($pxqty + 1)));
                    
                    if ($num == $gk)
                    {
                        $barcode['qty'] = $pxqty;
                    }
                    else
                    {
                        $barcode['qty'] = 1;
                        $barcode['tcode'] = $sp. k_to_wlcode($num, $unitcode,$msnlength);
                        $barcode['ucode'] = $barcode['tcode'];
                    }
                    break;
                case '3':    //3-大中小包装
                    $num = $myBegin + (((($pxqty * $pzqty) + $pzqty) + 1) * (($gk - $myBegin) / ((($pxqty * $pzqty) + $pzqty) + 1)));
                    $num2 = ($num + 1) + (((($gk - $num) - 1) / ($pxqty + 1)) * ($pxqty + 1));
                    if ($num == $gk)
                    {
                        $barcode['qty'] = $pxqty * $pzqty;
                        return $barcode;
                    }
                    if ($num2 == $gk)
                    {
                        $barcode['qty'] = $pxqty;
                        $barcode['tcode'] = $sp . k_to_wlcode($num,$unitcode,$msnlength);
                        $barcode['ucode'] = $sp . k_to_wlcode($num,$unitcode,$msnlength);
                    }
                    else
                    {
                        $barcode['qty'] = 1;
                        $barcode['tcode'] = $sp . k_to_wlcode($num2, $unitcode,$msnlength);
                        $barcode['ucode']= $sp . k_to_wlcode($num, $unitcode,$msnlength);
                    }
                    break;
                }
                return $barcode;
            }
            if($st!=4){  //无物流码 ok
                return $barcode;
            }

            if($snbeginlen!=0){   //4-双码流水号2 ok
                    $mqtylen =strlen($mqty);  //发行数长度
                    if ($mqtylen > $snbeginlen){
                        return $barcode;
                    }

                    $mqtylen = strlen(floor(substr($snbegin,$snbeginlen-$mqtylen, $mqtylen)) + $mqty);

                    $num12 = $gk - $myBegin;


                    if($mqtylen <= $snbeginlen){
                        $barcode['code']=substr($snbegin,0,$snbeginlen-$mqtylen).sprintf("%0".$mqtylen."d",(floor(substr($snbegin,$snbeginlen-$mqtylen,$mqtylen))+$num12));

                        switch ($packtype){
                            case '1':    //1-单个包装
                                $barcode['qty']=1;
                                break;
                            case '2':    //2-大小包装
                                if($pxqty==0){
                                    return $barcode;
                                }
                                $pxqtylen = strlen($pxqty);
                                $num13 = floor($num12 / $pxqty);
                                $num = $myBegin + ($pxqty * $num13);
                                $str6 = substr($snbegin,0,$snbeginlen-$mqtylen).sprintf("%0".$mqtylen."d",(floor(substr($snbegin,$snbeginlen-$mqtylen,$mqtylen))+$num13));
      
                   
                                $barcode['code'] = $str6.sprintf("%0".$pxqtylen."d", ($gk-$num)+1);
                                $barcode['qty'] = 1;
                                $barcode['tcode'] = $str6;
                                $barcode['ucode'] = $str6;
                                break;
                            case '3':    //3-大中小包装
                                if($pxqty==0 || $pzqty==0){
                                    return $barcode;
                                }
                                $pxqtylen = strlen($pxqty);
                                $pzqtylen = strlen($pzqty);
                                $num13 = floor($num12/($pxqty*$pzqty));
                                $num = $myBegin + (($pxqty*$pzqty)*$num13);
                                $num14 = floor(($gk - $num) / $pxqty);
                                $num15 = ($gk - $num) - ($pxqty * $num14);
                                $str6  = substr($snbegin,0,$snbeginlen-$mqtylen).sprintf("%0".$mqtylen."d",(floor(substr($snbegin,$snbeginlen-$mqtylen,$mqtylen))+$num13));
                                $barcode['code'] = $str6.sprintf("%0".$pzqtylen."d",$num14+1).sprintf("%0".$pxqtylen."d",$num15+1); 
                                $barcode['tcode'] = $str6.sprintf("%0".$pzqtylen."d",$num14+1);
                                $barcode['ucode'] = $str6;
								$barcode['qty'] = 1;
                                break;
                        }
                        return $barcode;
                    }
            }
            return $barcode;
        }
    }
    return $barcode;
}


//按一定概率选出2个数间的随机数 $min-小数 $max-大数 $g-小数段的概率 剩下100-$g是 大数段概率
function get_rand($min=0,$max=0,$g=70){
    $mid=$min+floor(($max-$min)/2);
    $rand = mt_rand(1, 100); 
    if($rand<=$g){
        $result=mt_rand($min, $mid);
    }else{
        $result=mt_rand($mid, $max);
    }
    return $result; 
}
//获取当前时间的毫秒数
function get_millisecond() {
    list($s1, $s2) = explode(' ', microtime());     
    return (float)sprintf('%.0f', (floatval($s1) + floatval($s2)) * 1000);  
}
/**返回判断是否防御
*attackevasive_str 防御级别 0|1|2|4|8|16  0-关闭此功能  1-cookie刷新限制  2-cookie二次请求时间间隔限制  4-cookie记录查询次数访问限制 8-同IP一定时间内访问限制 16-每次查询验证
*$prm1=1000 刷新限制1000毫秒 ,$prm2=3000 二次请求间隔3000毫秒,$prm4=15 查询限制15次,$prm8=20 查询限制20次
**/
function requ_security($attackevasive_str=0,$prm1=1000,$prm2=3000,$prm4=15,$prm8=20){
    $attackevasive=0;
    if(is_string($attackevasive_str)) {
        $attackevasive_tmp = explode('|', $attackevasive_str);
        $attackevasive = 0;
        foreach($attackevasive_tmp AS $key => $value) {
            $attackevasive += intval($value);
        }
        unset($attackevasive_tmp);
    } else {
        $attackevasive = $attackevasive_str;
    }
    $nowtime=get_millisecond();

    //防止频繁刷新
    if($attackevasive & 1) {
        if(is_not_null(cookie('lastrequest'))){
            $lastrequest=floor(\Org\Util\Funcrypt::authcode(cookie('lastrequest'),'DECODE',C('WWW_AUTHKEY'),0));
            cookie('lastrequest',\Org\Util\Funcrypt::authcode($nowtime,'ENCODE',C('WWW_AUTHKEY'),0),3600);

            if($nowtime - $lastrequest < $prm1) {
                return true;
            }
        }else{
            cookie('lastrequest',\Org\Util\Funcrypt::authcode($nowtime,'ENCODE',C('WWW_AUTHKEY'),0),3600);
        }

        if(!is_not_null(cookie('lastrequest2'))){
            cookie('lastrequest2',\Org\Util\Funcrypt::authcode($nowtime,'ENCODE',C('WWW_AUTHKEY'),0),3600);
        }
    }

    //防止二次请求时间间隔过短
    if($attackevasive & 2) {
        if(is_not_null(cookie('lastrequest2'))){
            $lastrequest2=floor(\Org\Util\Funcrypt::authcode(cookie('lastrequest2'),'DECODE',C('WWW_AUTHKEY'),0));
            cookie('lastrequest2',\Org\Util\Funcrypt::authcode($nowtime,'ENCODE',C('WWW_AUTHKEY'),0),3600);
            if($nowtime - $lastrequest2 < $prm2) {
                return true;
            }
        }else{
            return true;
        }
    }

    //cookie记录查询次数访问限制 30分钟查询超出15次 要输入验证码  cookie
    if($attackevasive & 4) {
        if(is_not_null(cookie('requesttimes'))){
            $requesttimes=floor(\Org\Util\Funcrypt::authcode(cookie('requesttimes'),'DECODE',C('WWW_AUTHKEY'),0));
            if($requesttimes>$prm4){
                return true;
            }
        }
    }

    //同IP一定时间内访问限制 要输入验证码 30分钟 20次 db
    if($attackevasive & 8) {
        $uip=real_ip();
        $Templist = M("Templist");
        $map['tmp_ip']=$uip;
        $map['tmp_addtime']=array('EGT',time()-1800);
        $count = $Templist->where($map)->count();
        if($count>$prm8){
            return true;
        }
    }
    //每次要输入验证码
    if($attackevasive & 16) {
        return true;
    }
    return false;
}
//根据防伪码返回查询结果 stat---状态码 （1-正确(第一次查)  3-重复查   5-错误  9-非安全  其他码的是查询错误）
function fwcode_to_result($fwcode='',$color=0,$uip='',$cn=1){
    if($fwcode=='' || !preg_match("/^[0-9]{10,27}$/",$fwcode)){
        return false;
    }
    $color_str='';
    $qycode=substr($fwcode,0,4);
    $codelen=strlen($fwcode)-4;
    $Model=M();
    $map['a.qy_code']=array('exp','=b.unitcode');
    $map['a.qy_active']=1;
    $map['b.unitcode']=$qycode;
    $map['b.codelen']=$codelen;
    $qydata=$Model->field('a.qy_id,a.qy_code,a.qy_fwkey,a.qy_fwsecret,a.qy_querytimes,a.qy_active,b.*')->table('fw_qyinfo a,fw_cust b')->where($map)->find();
    if($qydata){
		if($qydata['qy_active']==1){
			$mlength=$qydata['mlength'];
			$msnlength=$qydata['msnlength'];
			$smsnote=$qydata['smsnote'];   //第一次查询返回
			$renote=$qydata['renote'];     //重复查询返回
			$errnote='';                   //错误查询返回
			$overnote='';                   //超30次查询返回
		}else{
			return false; 
		}
    }else{
        return false; 
    }

    $myk=fwcode_to_k($fwcode,$qycode,$mlength);
    if($myk===false || $myk<=0){
        return false;
    }
	
	//是否防伪码分批处理
    $map2=array();
    $Batch=M('Batch');
    $map2['unitcode']=$qycode;
    $map2['codebegin']=array('ELT',$myk);//<=
    $map2['codeend']=array('EGT',$myk);//>=
    $data=$Batch->where($map2)->find();
    if($data){
		if(is_not_null($data['smsnote'])){
			$smsnote=$data['smsnote'];      //第一次查询返回
		}
        if(is_not_null($data['resmsnote'])){
			$renote=$data['resmsnote'];     //重复查询返回
		}
		if(is_not_null($data['errsmsnote'])){
			$errnote=$data['errsmsnote'];    //错误查询返回
		}
		if(is_not_null($data['oversmsnote'])){
			$overnote=$data['oversmsnote'];    //超30次查询返回
		}
    }
	
	//处理查询语
	//第一次查
    if(!is_not_null($smsnote)){
		if($cn==2){ //繁体
			$smsnote=C('SEND_MESSAGE')['msg11']; 
		}elseif($cn==3){  //英文
			$smsnote=C('SEND_MESSAGE')['msg21']; 
		}else{
			$smsnote=C('SEND_MESSAGE')['msg01']; 
		}
	}
	//多次查
    if(!is_not_null($renote)){
		if($cn==2){ //繁体
			$renote=C('SEND_MESSAGE')['msg12']; 
		}elseif($cn==3){  //英文
			$renote=C('SEND_MESSAGE')['msg22']; 
		}else{
			$renote=C('SEND_MESSAGE')['msg02']; 
		}
	}
	//错误查
	if(!is_not_null($errnote)){
		if($cn==2){ //繁体
			$errnote=C('SEND_MESSAGE')['msg13']; 
		}elseif($cn==3){  //英文
			$errnote=C('SEND_MESSAGE')['msg23']; 
		}else{
			$errnote=C('SEND_MESSAGE')['msg03']; 
		}
	}
	//超过30次查询语音
	if(!is_not_null($overnote)){
		if($cn==2){ //繁体
			$overnote=C('SEND_MESSAGE')['msg14']; 
		}elseif($cn==3){  //英文
			$overnote=C('SEND_MESSAGE')['msg24']; 
		}else{
			$overnote=C('SEND_MESSAGE')['msg04']; 
		}
	}
	
    //是否已发行
    $map2=array();
    $Sellrecord=M('Sellrecord');
    $record=array();
    $map2['unitcode']=$qycode;
    $map2['mybegin']=array('ELT',$myk);//<=
    $records=$Sellrecord->where($map2)->order('mybegin DESC')->select(); 
    foreach($records as $k=>$v){ 
        $mybegin=$v['mybegin'];
        $sellcount=$v['sellcount'];
        if(($mybegin+$sellcount)>=$myk){
            $record=$v;
            break;
        }
    }

    if(count($record)<=0){
        $msg=array('fwc'=>$fwcode,'stat'=>'5','msg'=>$errnote);
		return $msg;
    }
    //是否已过期
    $ex_date=strtotime($record['ex_date']);
    if($ex_date!==false){
        if($ex_date<=time()){
            $msg=array('fwc'=>$fwcode,'stat'=>'5','msg'=>$errnote);
		    return $msg;
        }
    }
    //是否已作废
    $map2=array();
    $Overduecode=M('Overduecode');
    $map2['unitcode']=$qycode;
    $map2['fwcode']=$fwcode;
    $data=$Overduecode->where($map2)->find();
    if($data){
        $msg=array('fwc'=>$fwcode,'stat'=>'5','msg'=>$errnote);
		return $msg;
    }

    $map2=array();
    $Overdue=M('Overdue');
    $map2['unitcode']=$qycode;
    $map2['offbegin']=array('ELT',$myk);//<=
    $map2['offend']=array('EGT',$myk);//>=
    $data=$Overdue->where($map2)->find();
    if($data){
        $msg=array('fwc'=>$fwcode,'stat'=>'5','msg'=>$errnote);
		return $msg;
    }
    
    //是否查询过
    $map2=array();
    $Tellist=M('Tellist');
    $map2['unitcode']=$qycode;
    $map2['fwcode']=$fwcode;
    $scount = $Tellist->where($map2)->count(); //该防伪码查询次数

    if($uip==''){
        $uip=real_ip();
    }
    
    if($scount<=0){   //第一次查
        //记录
        $fdata=array();
        $fdata['fid']=0;
        $fdata['unitcode']=$qycode;
        $fdata['fwcode']=$fwcode;
        $fdata['querystatu']='正确';
        $fdata['querydate']=date('Y-m-d H:i:s',time());
        $fdata['callerid']=$uip;
        $fdata['upyn']='N';
        $fdata['qutype']=3;   //查询方式 1-电话 2-短信 3以上网络(3-网络输入 4-扫码 5-微信)
        $fdata['yun']=1;      //查云服
        $Tellist->create($fdata,1);
        $Tellist->add();
        //记录end
        if($color==1){
            $msg=array('fwc'=>$fwcode,'clr'=>$color_str,'stat'=>'1','msg'=>$smsnote);
        }else{
            $msg=array('fwc'=>$fwcode,'stat'=>'1','msg'=>$smsnote);
        }
        return $msg;
    }else{                //已查过
	
        //第一次查询记录
        $map2=array();
        $map2['unitcode']=$qycode;
        $map2['fwcode']=$fwcode;
        $data=$Tellist->where($map2)->order('querydate ASC')->find(); 
        if($data){
            $querydate=strtotime($data['querydate']);
        }else{
            $querydate=time();
			$data['querydate']=date('Y-m-d H:i:s',time());
        }
		//最近一次查时间
		$map2=array();
        $map2['unitcode']=$qycode;
        $map2['fwcode']=$fwcode;
        $data2=$Tellist->where($map2)->order('querydate DESC')->find(); 
        if($data2){
            $lastquerydate=strtotime($data2['querydate']);
        }else{
            $lastquerydate=time();
        }
		
        if($scount>30){   //如果超过30次查 不再记录日志
            if($color==1){
                $msg=array('fwc'=>$fwcode,'clr'=>'','stat'=>'3','msg'=>$overnote,'cs'=>$scount+1,'rq'=>$querydate);
            }else{
                $msg=array('fwc'=>$fwcode,'stat'=>'3','msg'=>$overnote,'cs'=>$scount+1,'rq'=>$querydate);
            }
            return $msg;
        }
		
        

        if((time()-$querydate)<=20){ //20秒内有查过  不记录次数
			if($color==1){
				$msg=array('fwc'=>$fwcode,'clr'=>$color_str,'stat'=>'1','msg'=>$smsnote);
			}else{
				$msg=array('fwc'=>$fwcode,'stat'=>'1','msg'=>$smsnote);
			}
			return $msg;
		}else if((time()-$querydate)<=30){ //30秒内有查过 	
            //记录
            $fdata=array();
            $fdata['fid']=0;
            $fdata['unitcode']=$qycode;
            $fdata['fwcode']=$fwcode;
            $fdata['querydate']=date('Y-m-d H:i:s',time());
            $fdata['callerid']=$uip;
            $fdata['upyn']='N';
            $fdata['qutype']=3;   //查询方式 
            $fdata['yun']=1;      //查云服
            if($scount>5){
                $fdata['querystatu']='多次';
            }else{
                $fdata['querystatu']='重复';
            }
            $Tellist->create($fdata,1);
            $Tellist->add();
            //记录end
			if($color==1){
				$msg=array('fwc'=>$fwcode,'clr'=>$color_str,'stat'=>'1','msg'=>$smsnote);
			}else{
				$msg=array('fwc'=>$fwcode,'stat'=>'1','msg'=>$smsnote);
			}
			return $msg;
			
        }else{ 
		    if((time()-$lastquerydate)<=20){ //与最近一次查询相差20秒 不记录次数
				//@cs@ 查询次数 @rq@ 查询日期 @qt@ 查询方式  @nm@ 公司名
				$renote=str_replace('@cs@',$scount+1,$renote);
				$renote=str_replace('@rq@',$data['querydate'],$renote);
				$renote=str_replace('@qt@','',$renote);
				$renote=str_replace('@nm@','',$renote);
				
				if($color==1){
					$msg=array('fwc'=>$fwcode,'clr'=>$color_str,'stat'=>'3','msg'=>$renote,'cs'=>$scount+1,'rq'=>$querydate);
				}else{
					$msg=array('fwc'=>$fwcode,'stat'=>'3','msg'=>$renote,'cs'=>$scount+1,'rq'=>$querydate);
				}
				return $msg; 
			}
			
            //记录
            $fdata=array();
            $fdata['fid']=0;
            $fdata['unitcode']=$qycode;
            $fdata['fwcode']=$fwcode;
            $fdata['querydate']=date('Y-m-d H:i:s',time());
            $fdata['callerid']=$uip;
            $fdata['upyn']='N';
            $fdata['qutype']=3;   //查询方式 
            $fdata['yun']=1;      //查云服
            if($scount>5){
                $fdata['querystatu']='多次';
            }else{
                $fdata['querystatu']='重复';
            }

            $Tellist->create($fdata,1);
            $Tellist->add();
            //记录end

            //@cs@ 查询次数 @rq@ 查询日期 @qt@ 查询方式  @nm@ 公司名
            $renote=str_replace('@cs@',$scount+1,$renote);
            $renote=str_replace('@rq@',$data['querydate'],$renote);
            $renote=str_replace('@qt@','',$renote);
            $renote=str_replace('@nm@','',$renote);
			
            if($color==1){
                $msg=array('fwc'=>$fwcode,'clr'=>$color_str,'stat'=>'3','msg'=>$renote,'cs'=>$scount+1,'rq'=>$querydate);
            }else{
                $msg=array('fwc'=>$fwcode,'stat'=>'3','msg'=>$renote,'cs'=>$scount+1,'rq'=>$querydate);
            }
            return $msg; 
        }
    }
}

//生成二维码 png
function make_ercode($codelink='',$img_file='',$img_file_tmp='',$colorarr=array()){   
    import("Org.Util.QRcode.QRcode");
	if(count($colorarr)==4){
	    QRcode::png($codelink, $img_file_tmp, 'M', 4, 2,true);
		make_colorimg($img_file_tmp,400,400,$img_file,$colorarr);
		@unlink($img_file_tmp);
	}else{
	    QRcode::png($codelink, $img_file, 'M', 4, 2,true);
	}	
}
//生成二维码 png +彩色
function make_colorimg($path,$w,$h,$thumpath,$colorarr){
	$img = null;							     
	$img = @imagecreatefrompng($path);

	if ($img)
	{		
		$width = imagesx($img);//图片宽度
		$height = imagesy($img);//图片高度
		$scale = min($w/$width, $h/$height);
		if($w>=$width && $h>=$height){
		     $new_width=$width;
			 $new_height=$height;
		}else{
		    $new_width = floor($scale*$width);
			$new_height = floor($scale*$height);
		}
		
		$color = trim($colorarr[0],'#');
		$reg = hexdec(trim($color{0}.$color{1}));
		$green = hexdec(trim($color{2}.$color{3}));
		$blue = hexdec(trim($color{4}.$color{5}));
		imagecolorset($img,1,$reg,$green,$blue);
		$tmp_img0 = imagecreatetruecolor($new_width, $new_height);
		imagecopyresampled($tmp_img0, $img, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
		$target0 = imagecreatetruecolor($new_width/2, $new_height/2);
		imagecopy($target0, $tmp_img0, 0, 0, 0, 0, $new_width/2, $new_height/2);
		imagedestroy($tmp_img0);
		
		$color = trim($colorarr[1],'#');
		$reg = hexdec(trim($color{0}.$color{1}));
		$green = hexdec(trim($color{2}.$color{3}));
		$blue = hexdec(trim($color{4}.$color{5}));
		imagecolorset($img,1,$reg,$green,$blue);
		$tmp_img1 = imagecreatetruecolor($new_width, $new_height);
		imagecopyresampled($tmp_img1, $img, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
		$target1 = imagecreatetruecolor($new_width/2, $new_height/2);
		imagecopy($target1, $tmp_img1, 0, 0, $new_width/2, 0, $new_width/2, $new_height/2);
		imagedestroy($tmp_img1);
		
		$color = trim($colorarr[2],'#');
		$reg = hexdec(trim($color{0}.$color{1}));
		$green = hexdec(trim($color{2}.$color{3}));
		$blue = hexdec(trim($color{4}.$color{5}));
		imagecolorset($img,1,$reg,$green,$blue);
		$tmp_img2 = imagecreatetruecolor($new_width, $new_height);
		imagecopyresampled($tmp_img2, $img, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
		$target2 = imagecreatetruecolor($new_width/2, $new_height/2);
		imagecopy($target2, $tmp_img2, 0, 0, 0, $new_height/2, $new_width/2, $new_height/2);
		imagedestroy($tmp_img2);
		
		$color = trim($colorarr[3],'#');
		$reg = hexdec(trim($color{0}.$color{1}));
		$green = hexdec(trim($color{2}.$color{3}));
		$blue = hexdec(trim($color{4}.$color{5}));
		imagecolorset($img,1,$reg,$green,$blue);
		$tmp_img3 = imagecreatetruecolor($new_width, $new_height);
		imagecopyresampled($tmp_img3, $img, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
		$target3 = imagecreatetruecolor($new_width/2, $new_height/2);
		imagecopy($target3, $tmp_img3, 0, 0, $new_width/2, $new_height/2, $new_width/2, $new_height/2);
		imagedestroy($tmp_img3);
		
		$target4 = imagecreatetruecolor($new_width, $new_height);
		imagecopy($target4, $target0, 0, 0, 0, 0, $new_width/2, $new_height/2);
		imagecopy($target4, $target1, $new_width/2, 0, 0, 0, $new_width/2, $new_height/2);
		imagecopy($target4, $target2, 0, $new_height/2, 0, 0, $new_width/2, $new_height/2);
		imagecopy($target4, $target3, $new_width/2, $new_height/2, 0, 0, $new_width/2, $new_height/2);
		
		imagedestroy($img);
		imagedestroy($target0);
		imagedestroy($target1);
		imagedestroy($target2);
		imagedestroy($target3);
		imagepng($target4, $thumpath);
	  }			
}
