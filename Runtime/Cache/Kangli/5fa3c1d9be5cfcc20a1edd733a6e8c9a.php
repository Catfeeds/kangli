<?php if (!defined('THINK_PATH')) exit(); if(C('LAYOUT_ON')) { echo ''; } ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width,height=device-height,inital-scale=1.0,maximum-scale=1.0,user-scalable=no;">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<meta name="format-detection" content="telephone=no,email=no,adress=no">
<title>消息提示</title>
<style type="text/css">
*{ padding: 0; margin: 0; }
body{ background: #f8f8f8; font-family: '微软雅黑'; color: #333; font-size: 1em; }
.system-message{ padding:10% 5% 10% 5%;margin:5% 5% 0 5%; background-color:#FFFFFF; border:solid 1px #e5e5e5;box-sizing: border-box; text-align:center; min-height:100px}
.system-message h1{ font-size: 80px; font-weight: normal; line-height: 120px; margin-bottom: 12px; }
.system-message .jump{ padding-top: 40px; text-align:center}
.system-message .jump a{ color: #333;}
.system-message .success,.system-message .error{ line-height: 2em; font-size: 1.2em; text-align:center}
.system-message .detail{ font-size: 12px; line-height: 20px; margin-top: 12px; display:none}
</style>
</head>
<body>
<div style="max-width:600px; margin:0 auto">
<div class="system-message">
<?php if(isset($message)) {?>
<p class="success"><?php echo($message); ?></p>
<?php }else{?>
<p class="error"><?php echo($error); ?></p>
<?php }?>
<p class="detail"></p>

<?php if(intval($waitSecond)<0) {?>
<p class="jump" id="jump"  style="display:none" >
<a id="href" href="<?php echo($jumpUrl); ?>" ></a><b id="wait"><?php echo($waitSecond); ?></b>
</p>
<?php }else if(intval($waitSecond)==999){?>
<p class="jump" id="jump"   >
<a id="href" href="<?php echo($jumpUrl); ?>">点击返回</a><b id="wait" style="display:none" ><?php echo($waitSecond); ?></b>
</p>
<?php  }else{?>
<p class="jump" id="jump" >
页面自动 <a id="href" href="<?php echo($jumpUrl); ?>">跳转</a> 等待时间： <b id="wait"><?php echo($waitSecond); ?></b>
</p>
<?php }?>

</div>
</div>
<script type="text/javascript">
(function(){
var wait = document.getElementById('wait'),href = document.getElementById('href').href;
var interval = setInterval(function(){
	var time = --wait.innerHTML;
	if(time>=998){clearInterval(interval);}
	if(time == 0) {
		document.getElementById('jump').style.display='none';
		location.href = href;
		clearInterval(interval);
	};
	if(time < 0) {
	   document.getElementById('jump').style.display='none';
	   clearInterval(interval);
	}
}, 1000);
})();
</script>
</body>
</html>