<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>登录</title>
<link rel="stylesheet" type="text/css" href="/Public/mp/css/style.css" />
<link rel="stylesheet" type="text/css" href="/Public/mp/css/jquery-confirm.min.css"/>
<script type="text/javascript" src="/Public/mp/js/jquery.min.js"></script>
<script type="text/javascript" src="/Public/mp/js/jquery-confirm.min.js"></script>
<!--&lt;!&ndash;<script type="text/javascript" language="javascript">&ndash;&gt;-->
        <!--&lt;!&ndash;$(document).ready(function() {&ndash;&gt;-->
            <!--&lt;!&ndash;$("#verifyImg").click(function(){&ndash;&gt;-->
				<!--&lt;!&ndash;$("#verifyImg").attr("src","<?php echo U('Mp/Login/verify');?>?"+ Math.random());&ndash;&gt;-->
			<!--&lt;!&ndash;&ndash;&gt;-->
			 <!--&lt;!&ndash;});&ndash;&gt;-->
		 <!--&lt;!&ndash;});&ndash;&gt;-->
<!--</script>-->
</head>
<body>
<div class="header">
<div class="bound">
<div class="logo">
<?php if(!empty($qypic)): ?><img src="/Public/uploads/product/<?php echo ($qypic); ?>"  height="40" style="vertical-align:middle" />
<?php else: ?> 
<img src="/Public/mp/static/logo0.png"  height="40" style="vertical-align:middle" /><?php endif; ?>
</div>
<div class="topright">您好,<?php echo (session('qyuser')); ?><a href="<?php echo U('Mp/Login/quit');?>" style="color:#fff;" >退出系统</a> </div>
</div>
</div>
<div class="main" >
<div class="bound" >
<div  style="height:80px; line-height:80px"></div>
<div style="width:500px; margin:0 auto; border:solid 1px #eeeeee; padding:40px">
<form action="<?php echo U('Mp/Login/logining');?>"   method="post" name="fmmm" >
 <input type="hidden"  value="<?php echo ($ttamp); ?>"  name="ttamp"  />
  <input type="hidden"  value="<?php echo ($sture); ?>"  name="sture"  />
<table width="100%" border="0">
  <tr>
    <td  width="30%" style="text-align:right"  height="50" >用户名：</td>
    <td width="70%"><input    type="text" size="25" maxlength="30"  name="username"  class="input"  value=""  id="username"    ></td>
  </tr>
  <tr>
    <td  style="text-align:right" height="50"  >密　码：</td>
    <td><input    type="password" size="25" maxlength="30"  name="pwd"  class="input"  value=""  id="pwd"    ></td>
  </tr>
      <tr>
    <td  style="text-align:right" height="50"  >验证码：</td>
    <td><input    type="text" size="4" maxlength="4"  name="checkcode"  class="input"  value=""  id="checkcode"    > <img  alt="点击换另一个" title="点击换另一个"  style="vertical-align:middle; cursor:pointer"  id="verifyImg" src="<?php echo U('Mp/Login/verify');?>" onclick="this.src='<?php echo U('Mp/Login/verify');?>?'+Math.random();"  /></td>
  </tr>
  <tr>
    <td height="50"  >&nbsp;</td>
    <td><input type="submit" name="Submit" value="登 录" class="botton"   id="submit" ></td>
  </tr>

</table>
</form>
</div>
</div>
</div>
<div class="clear"></div>
<div class="footer">
<div class="bound">
<div class="f1"> &copy; <span id="cyear" ></span></div>
<script>var myDate = new Date();$("#cyear").html(myDate.getFullYear());</script>
</div>
</div>
</body>
</html>