<?php

//生成彩色随机码 数据
function make_verifyzxdata($verify_file,$fwcode){
    $fwcode=$fwcode;
	$verify_file=$verify_file;
	$clen=4;    //码位数
	$linenum=0; //干扰线数
	$noisenum=0;//杂点数
	$noisetxt='';//杂点
	$imgW=300;  //图片宽度
	$imgH=85;   //图片高度   >31
	$base64str='0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
	$base64arr=array();
	for($i = 0; $i < strlen($base64str); $i++) {
		$base64arr[$base64str[$i]]=array('k'=>$i,'v'=>$base64str[$i]);
	}

	$fwcode_l=substr($fwcode,0,4); //
	$fwcode_r=substr($fwcode,4); //
	$color_codes=$ccode[0].$ccode[1].$ccode[2].$ccode[3];

	$fwcodemd_l=md5($fwcode_l);
	$fwcodemd_r=md5($fwcode_r);
	$fwcodemd_c=md5($color_codes);

	$fwcodeb64=base64_encode($fwcodemd_r.$fwcodemd_c.$fwcodemd_l);
	$fwcodeb64=str_replace("+","",$fwcodeb64);
	$fwcodeb64=str_replace("/","",$fwcodeb64);
	$fwcodeb64=str_replace("=","",$fwcodeb64);
	
	//-------------------------------------------------------
	$tsfh=array('0'=>'ㄅ','1'=>'ㄆ','2'=>'ㄇ','3'=>'ㄈ','4'=>'ㄉ','5'=>'ㄊ','6'=>'ㄋ','7'=>'ㄌ','8'=>'ㄍ','9'=>'ㄎ',
				'a'=>'ㄏ','b'=>'ㄐ','c'=>'ㄑ','d'=>'ㄒ','e'=>'ㄓ','f'=>'ㄔ','g'=>'ㄕ','h'=>'ㄖ','i'=>'ㄗ','j'=>'ㄘ',
				'k'=>'ㄙ','l'=>'ㄨ','m'=>'ㄩ','n'=>'ㄚ','o'=>'ㄛ','p'=>'ㄜ','q'=>'ㄝ','r'=>'ㄞ','s'=>'ㄟ','t'=>'ㄠ',
				'u'=>'ㄡ','v'=>'ㄢ','w'=>'ㄣ','x'=>'ㄤ','y'=>'ㄥ','z'=>'ㄦ');
	$sss=strtolower(substr($fwcodeb64,0,$clen));

	$codes=$tsfh[$sss[0]].$tsfh[$sss[1]].$tsfh[$sss[2]].$tsfh[$sss[3]];
	//$codes=substr($fwcodeb64,0,$clen);//'正品保障'; 
	$code=StringToArray($codes);   //字符串转数组
	$rcode=substr($fwcodeb64,$clen);
                            
			
	$s=0;
	//--------------------------------------------------------
	$codearr=array();
	//对码的每一个字符进行处理
	for($i = 0; $i < count($code); $i++) {
		$text=$code[$i];
	 
		//字体大小 (20,26) 26 32
		$sc=$rcode[$s];
		$scarr=$base64arr[$sc];
		if(($scarr['k']%2)==1){
			$fontsize=26;
		}else{
			$fontsize=32; 
		}

		//字体(1,2,3,4,5)
		$s=$s+1; 
		$sc=$rcode[$s];
		$scarr=$base64arr[$sc];
		$fontttf=intval($scarr['k']*(5/63)+1);

		//旋转角度     (-50---50)
		$s=$s+1; 
		$sc=$rcode[$s];    
		$scarr=$base64arr[$sc];
		$angle=intval(($scarr['k']*((50+50)/62))-50);

		//x坐标 (1---w-(w-1-5)/5-(w-1-5)/2 )
		$s=$s+1;
		$sc=$rcode[$s];    
		$scarr=$base64arr[$sc];
		$sbegin=1+(($imgW-1-5)/$clen)*$i;
		$send=1+(($imgW-1-5)/$clen)*($i+1)-(($imgW-1-5)/$clen)/2;
		$x=intval(((($send-$sbegin)/62)*$scarr['k'])+$sbegin);

		//y坐标 (26---(h-5))
		$s=$s+1; 
		$sc=$rcode[$s];    
		$scarr=$base64arr[$sc];
		$y=intval((((($imgH-5)-26)/62)*$scarr['k'])+26);

		//颜色         (1,2,3,4,5)
		$s=$s+1; 
		$sc=$rcode[$s];    
		$scarr=$base64arr[$sc];
		$color=intval($scarr['k']*(5/63)+1);

		$codearr[$i]['text']=$text;
		$codearr[$i]['fontsize']=$fontsize;  //字体大小 (20,26)
		$codearr[$i]['fontttf']=$fontttf;    //字体(1,2,3,4,5)
		$codearr[$i]['angle']=$angle;        //旋转角度     (-50---50)
		$codearr[$i]['x']=$x;                //x坐标 (5---w-(w-10)/5)
		$codearr[$i]['y']=$y;                //y坐标 (26---(h-5))
		$codearr[$i]['color']=$color;        //颜色         (1,2,3,4,5)

		$s=$s+1;
	}
	//----------------------------------------------------------------
	$linesarr=array();
	//干扰线处理
	for($i = 0; $i < $linenum; $i++) {
		//振幅  (1---H/2)
		$sc=$rcode[$s];    
		$scarr=$base64arr[$sc];
		$zf=intval(((($imgH/2)-1)/62)*$scarr['k']+1);
		
		//Y轴方向偏移量  (-H/4 , H/4)
		$s=$s+1;
		$sc=$rcode[$s];    
		$scarr=$base64arr[$sc];
		$sbegin=-($imgH/4);
		$send=$imgH/4;
		$ypy=intval(((($send-$sbegin)/62)*$scarr['k'])+$sbegin);

		//X轴方向偏移量    (-H/4 , H/4)
		$s=$s+1;
		$sc=$rcode[$s];    
		$scarr=$base64arr[$sc];
		$sbegin=-($imgH/4);
		$send=$imgH/4;
		$xpy=intval(((($send-$sbegin)/62)*$scarr['k'])+$sbegin);

		//周期              (h----w*1.5)
		$s=$s+1;
		$sc=$rcode[$s];    
		$scarr=$base64arr[$sc];
		$sbegin=$imgH;
		$send=$imgW*1.5;
		$zq=intval(((($send-$sbegin)/62)*$scarr['k'])+$sbegin);
		
		//曲线x坐标起始位置  (0--w/3)
		$s=$s+1;
		$sc=$rcode[$s];    
		$scarr=$base64arr[$sc];
		$sbegin=0;
		$send=$imgW/3;
		$xb=intval(((($send-$sbegin)/62)*$scarr['k'])+$sbegin);

		//曲线x坐标结束位置  (w/2  w*(2/3))
		$s=$s+1;
		$sc=$rcode[$s];    
		$scarr=$base64arr[$sc];
		$sbegin=$imgW/2;
		$send=$imgW*(2/3);
		$xe=intval(((($send-$sbegin)/62)*$scarr['k'])+$sbegin);

		//振幅2  (1---H/2)
		$s=$s+1;
		$sc=$rcode[$s];    
		$scarr=$base64arr[$sc];
		$sbegin=1;
		$send=$imgH/2;
		$zf2=intval(((($send-$sbegin)/62)*$scarr['k'])+$sbegin);

		//X轴方向偏移量2  (-H/4 , H/4)
		$s=$s+1;
		$sc=$rcode[$s];    
		$scarr=$base64arr[$sc];
		$sbegin=-($imgH/4);
		$send=$imgH/4;
		$xpy2=intval(((($send-$sbegin)/62)*$scarr['k'])+$sbegin);

		//周期2  (h----w*1.5)
		$s=$s+1;
		$sc=$rcode[$s];    
		$scarr=$base64arr[$sc];
		$sbegin=$imgH;
		$send=$imgW*1.5;
		$zq2=intval(((($send-$sbegin)/62)*$scarr['k'])+$sbegin);

		//曲线x坐标结束位置2  (w*(2/3) w)
		$s=$s+1;
		$sc=$rcode[$s];    
		$scarr=$base64arr[$sc];
		$sbegin=$imgW*(2/3);
		$send=$imgW;
		$xe2=intval(((($send-$sbegin)/62)*$scarr['k'])+$sbegin);

		//颜色         (1,2,3,4,5)
		$s=$s+1; 
		$sc=$rcode[$s];    
		$scarr=$base64arr[$sc];
		$color=intval($scarr['k']*(5/63)+1);


		$linesarr[$i]['zf']=$zf;     //振幅  (1---H/2)
		$linesarr[$i]['ypy']=$ypy;   //Y轴方向偏移量  (-H/4 , H/4)
		$linesarr[$i]['xpy']=$xpy;   //X轴方向偏移量    (-H/4 , H/4)
		$linesarr[$i]['zq']=$zq;     //周期              (h----w*1.5)
		$linesarr[$i]['xb']=$xb;     //曲线x坐标起始位置  (0--w/3)
		$linesarr[$i]['xe']=$xe;     //曲线x坐标结束位置  (w/2  w*(2/3))
		$linesarr[$i]['zf2']=$zf2;    //振幅2  (1---H/2)  
		$linesarr[$i]['xpy2']=$xpy2;   //X轴方向偏移量2  (-H/4 , H/4)
		$linesarr[$i]['zq2']=$zq2;    //周期2 (h----w*1.5)
		$linesarr[$i]['xe2']=$xe2;     //曲线x坐标结束位置2  (w*(2/3) w)
		$linesarr[$i]['color']=$color;    //颜色         (1,2,3,4,5)

		$s=$s+1;
	}
	//-----------------------------------------------------------------
	//杂点处理
	$noisearr=array();
	for($i = 0; $i < $noisenum; $i++) {
		////杂点x坐标
		$sc=$rcode[$s];    
		$scarr=$base64arr[$sc];
		$sbegin=0;
		$send=$imgW;
		$x=intval(((($send-$sbegin)/62)*$scarr['k'])+$sbegin);

		//杂点y坐标
		$s=$s+1;
		$sc=$rcode[$s];    
		$scarr=$base64arr[$sc];
		$sbegin=0;
		$send=$imgH-5;
		$y=intval(((($send-$sbegin)/62)*$scarr['k'])+$sbegin);

		//颜色         (1,2,3,4,5)
		$s=$s+1; 
		$sc=$rcode[$s];    
		$scarr=$base64arr[$sc];
		$color=intval($scarr['k']*(5/63)+1);

		$noisearr[$i]['txt']=$noisetxt;     //杂点
		$noisearr[$i]['x']=$x;     //杂点x坐标 (0--w)
		$noisearr[$i]['y']=$y;     //杂点y坐标 (0--h)
		$noisearr[$i]['color']=$color;     //杂点色

		$s=$s+1;
	}

	make_verifyzx($codearr,$linesarr,$noisearr,$imgW,$imgH,$verify_file,true);
}


//$codearr-显示的字符数组   $linesarr--干扰线  $noisearr--杂点
function make_verifyzx($codearr,$linesarr,$noisearr,$imgW,$imgH,$img_path,$useZh=false){
	import("Org.Util.Verifyzx.Verifyzx");
    $Verify=new Verifyzx();
    $Verify->imageW=$imgW;
    $Verify->imageH=$imgH;
    $Verify->codearr=$codearr;
    $Verify->linesarr=$linesarr;
    $Verify->noisearr=$noisearr;
    $Verify->img_path=$img_path;
    $Verify->useZh=$useZh;
    $Verify->entry();
}
/**
 * 把字符串转成数组，支持汉字，只能是utf-8格式的
 * @param $str
 * @return array
 */
function StringToArray($str){
    $result = array();
    $len = strlen($str);
    $i = 0;
    while($i < $len){
        $chr = ord($str[$i]);
        if($chr == 9 || $chr == 10 || (32 <= $chr && $chr <= 126)) {
            $result[] = substr($str,$i,1);
            $i +=1;
        }elseif(192 <= $chr && $chr <= 223){
            $result[] = substr($str,$i,2);
            $i +=2;
        }elseif(224 <= $chr && $chr <= 239){
            $result[] = substr($str,$i,3);
            $i +=3;
        }elseif(240 <= $chr && $chr <= 247){
            $result[] = substr($str,$i,4);
            $i +=4;
        }elseif(248 <= $chr && $chr <= 251){
            $result[] = substr($str,$i,5);
            $i +=5;
        }elseif(252 <= $chr && $chr <= 253){
            $result[] = substr($str,$i,6);
            $i +=6;
        }
    }
    return $result;
}

//生成授权书  只支持jpg 在图片上 打上文字
//$text[]=array('txt'=>'文字','x'=>189,'y'=>407,'color'=>array('204','204','204'),'font'=>$ttfpath,'fontsize'=>'14');

function make_textpic($text=array(),$temppic='',$savepic=''){
	if(count($text)<=0 || $temppic=='' || $savepic==''){
		exit;
	}
	$image = imagecreatefromjpeg($temppic); 
	foreach($text as $k=>$v){
		$color = imagecolorallocate($image,$v['color'][0],$v['color'][1],$v['color'][2]); // 字体颜色
	    imagettftext($image, $v['fontsize'], 0, $v['x'], $v['y'], $color, $v['font'], $v['txt']);
	}
    imagejpeg($image,$savepic);
    imagedestroy($image);
}
