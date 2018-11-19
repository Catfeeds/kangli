<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<!DOCTYPE html>
<html>

	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
		<link rel="shortcut icon" href="/Kangli/Public/Kangli/static/chuanshu_min.png">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-status-bar-style" content="black">
		<meta name="format-detection" content="telephone=no,email=no,adress=no">
		<title>
			<?php echo (C("QY_COMPANY")); ?>-<?php echo ($title); ?></title>
		<link rel="stylesheet" type="text/css" href="/Kangli/Public/Kangli/css/iconfont.css"/>
<link rel="stylesheet" type="text/css" href="/Kangli/Public/Kangli/css/sm.min.css">
<link rel="stylesheet" type="text/css" href="/Kangli/Public/Kangli/css/swiper.min.css"/>
<link rel="stylesheet" type="text/css" href="/Kangli/Public/Kangli/css/demo.css"/>


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
			<header class="bar bar-nav" style="background-color:#006db2;">
				<a href="#" onclick="self.location=document.referrer;" class="icon icon-left pull-left" style="color:#fff"></a>
				<h1 class="title" style="color:#fff"><?php echo ($title); ?></h1>
			</header>
			<div class="content">
				<div class="card demo-card-header-pic">
                    <?php if($newsinfo["news_pic_str"] != ''): ?><div valign="bottom" class="card-header color-white no-border no-padding">
						<?php echo ($newsinfo["news_pic_str"]); ?>
					</div><?php endif; ?>
					<div class="card-content">
						<div class="card-content-inner">
							<p class="color-gray">发表于<?php echo (date('Y-m-d H:i:s',$newsinfo["news_addtime"])); ?></p>
							<p><?php echo ($newsinfo["news_content"]); ?></p>
						</div>
					</div>
					<div class="card-footer" style="display: none;">
						<a href="#" class="link">赞</a>
						<a href="#" class="link">更多</a>
					</div>
				</div>
			</div>
		</div>
	</body>
	 <script type='text/javascript' src='/Kangli/Public/Kangli/js/app.js' charset='utf-8'></script>
 <script type='text/javascript' src='/Kangli/Public/Kangli/js/swiper.min.js' charset='utf-8'></script>
 <script type='text/javascript' src='/Kangli/Public/Kangli/js/zepto.min.js' charset='utf-8'></script>
 <script type='text/javascript' src='/Kangli/Public/Kangli/js/sm.min.js' charset='utf-8'></script>
 <script type='text/javascript' src='/Kangli/Public/Kangli/js/jquery.base64.js' charset='utf-8'></script>
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

		});
	</script>

</html>