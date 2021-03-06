<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>

	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
		<link rel="shortcut icon" href="/Public/Kangli/static/chuanshu_min.png">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-status-bar-style" content="black">
		<meta name="format-detection" content="telephone=no,email=no,adress=no">
		<title><?php echo (C("QY_COMPANY")); ?>-设置</title>
		<link rel="stylesheet" type="text/css" href="/Public/Kangli/css/iconfont.css"/>
<link rel="stylesheet" type="text/css" href="/Public/Kangli/css/sm.min.css">
<link rel="stylesheet" type="text/css" href="/Public/Kangli/css/swiper.min.css"/>
<link rel="stylesheet" type="text/css" href="/Public/Kangli/css/demo.css"/>


		<style type="text/css">
			.icon_lists {
				width: 100% !important;
			}
			
			.icon_lists li {
				float: left;
				width: 20%;
				height: 180px;
				text-align: center;
				list-style: none !important;
			}
			
			.icon_lists li img {
				width: 2rem;
				margin: 0.3rem;
			}
			
			.icon_lists li a {
				text-decoration: none;
			}
			
			.icon_lists .iconfont {
				font-size: 25px;
				line-height: 30px;
				margin: 10px 0;
				color: #7e7e7e;
				-webkit-transition: font-size 0.25s ease-out 0s;
				-moz-transition: font-size 0.25s ease-out 0s;
				transition: font-size 0.25s ease-out 0s;
			}
			
			.icon_lists .iconfont.active,
			.icon_lists .iconfont:active {
				font-size: 25px;
				color: #f08519;
			}
			
			.icon_lists .name {
				font-size: 12px;
			}
			
			.bar-tab .tab-item.active,
			.bar-tab .tab-item:active {
				color: #f08519;
			}
		</style>
	</head>

	<body ontouchstart="" style="background-color:#FAFAFA">
		<div class="page">
			<header class="bar bar-nav" style="background-color: #006db2;">
				<!-- <a href="#" onclick="self.location=document.referrer;" class="icon icon-left pull-left" style="color:#fff"></a> -->
				<a href="<?php echo U('./Kangli/Index');?>" class="icon icon-left pull-left" style="color:#fff"></a>
				<h1 class="title" style="color:#fff">设置</h1>
			</header>
			<div class="content">
				<div class="list-block" style="margin-top:.25rem;margin-bottom: 0rem;">
						<ul>
							<li class="item-content item-link">
								<div class="item-media"><i class="iconfont icon-verification-code" style="font-size:1.2rem; color: #7e7e7e;line-height:1rem;"></i></div>
								<div class="item-inner">
									<div class="item-title" style="color: #7e7e7e">
										<h1><?php if($isbindwx == true): ?>解绑微信<?php else: ?>绑定微信<?php endif; ?></h1></div>
								</div>
							</li>
							<li class="item-content item-link">
								<div class="item-media"><i class="iconfont icon-xiugaimima" style="font-size:1.2rem; color: #7e7e7e;line-height:1rem;"></i></div>
								<div class="item-inner">
									<div class="item-title" style="color: #7e7e7e">
										<h1>修改密码</h1></div>
								</div>
							</li>
							<li class="item-content item-link">
								<div class="item-media"><i class="iconfont icon-esc" style="font-size:1.2rem; color: #7e7e7e;line-height:1rem;"></i></div>
								<div class="item-inner">
									<div class="item-title" style="color: #7e7e7e">
										<h1>退出登录</h1></div>
								</div>
							</li>
						</ul>
					</div>
			</div>
		</div>
	</body>
	 <script type='text/javascript' src='/Public/Kangli/js/app.js' charset='utf-8'></script>
 <script type='text/javascript' src='/Public/Kangli/js/swiper.min.js' charset='utf-8'></script>
 <script type='text/javascript' src='/Public/Kangli/js/zepto.min.js' charset='utf-8'></script>
 <script type='text/javascript' src='/Public/Kangli/js/sm.min.js' charset='utf-8'></script>
 <script type='text/javascript' src='/Public/Kangli/js/jquery.base64.js' charset='utf-8'></script>
<!--  <script type="text/javascript">
 	$(document).on('click','.create-prompt', function () {
      	$.prompt('全国商品防伪查询',function (value) {
          	// $.alert('Your name is "' + value + '". You clicked Ok button');
      	});
  	});
 </script> -->

	<script type="text/javascript">
		$.init();
		$(function() {
			var isbindwx="<?php echo ($isbindwx); ?>"||false;
			$(".item-content.item-link").each(function(index) {
				// console.log('input %d is:%o',index,this);
				$(this).click(function(){
					switch(index)
					{
						case 0:
							if (isbindwx)
							{
								window.location.href="<?php echo U('./Kangli/Mine/unbindwx/');?>"
							}
							else{
								var url=window.location.href+'/isbind/1';
								var base = new Base64();
								window.location.href="<?php echo U('./Kangli/Token/startOauth/tag');?>/"+base.encode(urlencode(url));
							}

						break;	
						case 1:
							   window.location.href="<?php echo U('./Kangli/Mine/forgot/etype/1');?>"
						break;	
						case 2:
							   window.location.href="<?php echo U('./Kangli/Mine/quit');?>"
						break;					
						default:
						break;

					}
				});
			})
		});
		function urlencode (str) {  
		    str = (str + '').toString();
		    return encodeURIComponent(str).replace(/!/g, '%21').replace(/'/g, '%27').replace(/\(/g, '%28').  
		    replace(/\)/g, '%29').replace(/\*/g, '%2A').replace(/%20/g, '+');  
		}
	</script>
	</script>

</html>