<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>

	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
		<link rel="shortcut icon" href="/Public/Kangli/static/chuanshu_min.png">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-status-bar-style" content="black">
		<meta name="format-detection" content="telephone=no,email=no,adress=no">
		<title><?php echo (C("QY_COMPANY")); ?>-我</title>
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
			
			.top-img .mine-top {
				top: 0;
				left: 0;
				width: 100%;
				height: 7rem;
				position: absolute;
			}
			
			.top-img .mine-top .head-icon {
				width: 7rem;
				height: 7rem;
				margin: auto;
				position: absolute;
				left: 50%;
				top: 50%;
				margin-left: -3.5rem;
				margin-top: -3.5rem;
				box-sizing: border-box;
				display: -webkit-box;
				display: -webkit-flex;
				display: flex;
				flex-direction: column;
				-webkit-flex-direction: column;
				-webkit-justify-content: center;
				justify-content: center;
				-webkit-box-align: center;
				-webkit-align-items: center;
				align-items: center;
			}
			
			.modal-button {
				font-size: .5rem;
			}
		</style>
	</head>

	<body ontouchstart="" style="background-color:#FAFAFA">
		<div class="page">
			<nav class="bar bar-tab clear">
				<ul class="icon_lists clear">
					<li>
						<a class="tab-item" href="<?php echo U('./Kangli/Index');?>">
							<i class="iconfont icon-shouye-copy-copy-copy-copy"></i>
							<div class="name">首页</div>
						</a>
					</li>
					<li>
						<a class="tab-item" href="<?php echo U('./Kangli/Dealer');?>">
							<i class="iconfont icon-tuandui3"></i>
							<div class="name">团队</div>
						</a>
					</li>
					<li>
						<a class="create-prompt" id="fw_search" href="#">
							<img src="/Public/Kangli/static/fangwei_icon.png">
						</a>
					</li>
					<li>
						<a class="tab-item" href="<?php echo U('./Kangli/Orders');?>">
							<i class="iconfont icon-icon"></i>
							<div class="name">订单</div>
						</a>
					</li>
					<li>
						<a class="tab-item active" href="#">
							<i class="iconfont active icon-user2"></i>
							<div class="name">我</div>
						</a>
					</li>
				</ul>
			</nav>
			<div class="content">
				<!-- minetop -->
				<div class="top-img" style="height:7rem;">
					<img src="/Public/Kangli/static/mine_top.jpg" style="width:100%;height:7rem;">
					<div class="mine-top">
						<div class="head-icon">
							<!-- <i class="iconfont icon-weibiaoti--copy" style="font-size:3rem; color: #fff;line-height: 3rem;margin-top:.3rem;"></i> -->
							<img class="kl-circle kl-img-thumbnail" src="/Public/uploads/mobi/<?php echo ($item["dl_wxheadimg"]); ?>" style="width:3rem;height:3rem;border-radius: 50%;margin-top:.3rem;" onerror="this.src='/Public/Kangli/static/head_icon.png'">
							<span style="line-height:1rem;font-size:0.5rem;color: #fff"><?php echo ($userinfo["dl_name"]); ?></span>
							<div style="line-height:.5rem;padding: .3rem"><i class="iconfont icon-diamond" style="font-size:.5rem; color: #fff;"></i><span style="font-size:.75rem;color: #fff;padding: .2rem"><?php echo ($userinfo["dl_level_name"]); ?></span></div>
						</div>
					</div>
				</div>
				<div class="kl-layout" style="padding: 0.25rem">
					<div class="center-horizontally">
						<a class="tab-item" href="#">
							<div>
								<div style="text-align: center;font-size:0.75rem;color: red;"><?php echo (number_format($userinfo["dl_fanlitotal"],2,'.','')); ?></div>
								<div style="text-align: center;color:#7e7e7e;">返利</div>
							</div>
						</a>
						<a class="tab-item" href="#">
							<div>
								<div style="text-align: center;font-size:0.75rem;color:#ff9600;"><?php echo ($userinfo["dl_totalstock"]); ?></div>
								<div style="text-align: center;color:#7e7e7e;">库存</div>
							</div>
						</a>
						<a class="tab-item" href="#">
							<div>
								<div style="text-align: center;font-size:0.75rem;color:#0068b4;"><?php echo (number_format($userinfo["dl_totalmoney_z"],2,'.','')); ?></div>
								<div style="text-align: center;color:#7e7e7e;">总销售额</div>
							</div>
						</a>
						<a class="tab-item" href="#">
							<div>
								<div style="text-align: center;font-size:0.75rem;color:#0068b4;"><?php echo (number_format($userinfo["dl_totalmoney"],2,'.','')); ?></div>
								<div style="text-align: center;color:#7e7e7e;">当月业绩</div>
							</div>
						</a>
					</div>
				</div>
				<div class="list-block" style="margin-top:.25rem;margin-bottom: 0rem;">
					<ul>
						<li class="item-content item-link">
							<div class="item-inner" id="dlorders_all">
								<div class="item-title">
									<h1>我的订单</h1></div>
								<div class="item-after" style="color:#7e7e7e;">查看全部订单</div>
							</div>
						</li>
					</ul>
					<div class="kl-layout" style="padding: 0.25rem">
						<div class="center-horizontally">
							<div id="dlorders_s">
								<i class="iconfont icon-SevenIcon_iconxiugai" style="font-size:1rem;color:#7e7e7e;line-height:1rem;"></i>
								<div style="text-align: center;color:#7e7e7e;position: relative;">审核<?php if($userinfo["dl_dlsodcount"] > 0): ?><span class="order-circle order-number-thumbnail" style="position: absolute;top:-1.2rem;right:-.3rem; color: red;padding: 0.2rem"><?php echo ($userinfo["dl_dlsodcount"]); ?></span><?php endif; ?></div>
							</div>
							<div id="dlorders_m">
								<i class="iconfont icon-daifahuo" style="font-size:1rem;color:#7e7e7e;line-height:1rem;"></i>
								<div style="text-align: center;color:#7e7e7e;position: relative;">待发<?php if($userinfo["dl_dlmodcount"] > 0): ?><span class="order-circle order-number-thumbnail" style="position: absolute;top:-1.2rem;right:-.3rem; color: red;padding: 0.2rem"><?php echo ($userinfo["dl_dlmodcount"]); ?></span><?php endif; ?></div>
							</div>
							<div id="myorder_add">
								<i class="iconfont icon-dingdan" style="font-size:1rem;color:#7e7e7e;line-height:1rem;position: relative;"></i>
								<div style="text-align: center;color:#7e7e7e;">提货</div>
							</div>
							<div id="mystock_add">
								<i class="iconfont icon-chongzhi" style="font-size:1rem;color:#7e7e7e;line-height:1rem;"></i>
								<div style="text-align: center;color:#7e7e7e;">预充</div>
							</div>
						</div>
					</div>
					<div class="list-block" style="margin-top:.25rem;margin-bottom: 0rem;">
						<ul>
							<li class="item-content item-link">
								<div class="item-media"><i class="iconfont icon-yaoqinghaoyou" style="font-size:1.2rem; color: #0068b4;line-height:1rem;"></i></div>
								<div class="item-inner">
									<div class="item-title">
										<h1>邀请代理</h1></div>
									<div class="item-subtitl" style="color:#c1c1c1;">查看我的邀请链接</div>
								</div>
							</li>
							<li class="item-content item-link">
								<div class="item-media"><i class="iconfont icon-zhengshu" style="font-size:1.2rem; color: #0068b4;line-height:1rem;"></i></div>
								<div class="item-inner">
									<div class="item-title">
										<h1>授权证书</h1></div>
									<div class="item-subtitl" style="color:#c1c1c1;">查看我的授权证书</div>
								</div>
							</li>
							<li class="item-content item-link" style="display: none;">
								<div class="item-media"><i class="iconfont icon-guquanbao" style="font-size:1.2rem; color: #0068b4;line-height:1rem;"></i></div>
								<div class="item-inner">
									<div class="item-title">
										<h1>股权证书</h1></div>
									<div class="item-subtitl" style="color:#c1c1c1;">查看我的股权证书</div>
								</div>
							</li>
							<li class="item-content item-link">
								<div class="item-media"><i class="iconfont icon-yixiangjibieshenpi-" style="font-size:1.2rem; color: #0068b4;line-height:1rem;"></i></div>
								<div class="item-inner">
									<div class="item-title">
										<h1>调级申请</h1></div>
									<div class="item-subtitl" style="color:#c1c1c1;">查看升降级别申请</div>
								</div>
							</li>
							<li class="item-content">
								<div class="item-media"><i class="iconfont icon-wodeshangji" style="font-size:1.2rem; color: #0068b4;line-height:1rem;"></i></div>
								<div class="item-inner">
									<div class="item-title">
										<h1>我的上级</h1></div>
									<div class="item-subtitl" style="color:#c1c1c1;"><?php echo ($userinfo["dl_belong_name"]); ?></div>
								</div>
							</li>
						</ul>
					</div>

					<div class="list-block" style="margin-top:.25rem;margin-bottom: 0rem;">
						<ul>
							<li class="item-content item-link">
								<div class="item-media"><i class="iconfont icon-dizhi-copy" style="font-size:1.2rem; color: #f08519;line-height:1rem;"></i></div>
								<div class="item-inner">
									<div class="item-title">
										<h1>收货地址</h1></div>
									<div class="item-subtitl" style="color:#c1c1c1;">查看我的收货地址</div>
								</div>
							</li>
							<li class="item-content item-link">
								<div class="item-media"><i class="iconfont icon-discount_rule" style="font-size:1.2rem; color: #f08519;line-height:1rem;"></i></div>
								<div class="item-inner">
									<div class="item-title">
										<h1>我的返利</h1></div>
									<div class="item-subtitl" style="color:#c1c1c1;">查看我的返利奖励</div>
								</div>
							</li>
						</ul>
					</div>

					<div class="list-block" style="margin-top:.25rem;margin-bottom: 0rem;">
						<ul>
							<li class="item-content item-link">
								<div class="item-media"><i class="iconfont icon-bianji" style="font-size:1.2rem; color: #7e7e7e;line-height:1rem;"></i></div>
								<div class="item-inner">
									<div class="item-title" style="color: #7e7e7e">
										<h1>反馈</h1></div>
								</div>
							</li>
							<li class="item-content item-link">
								<div class="item-media"><i class="iconfont icon-shezhi" style="font-size:1.2rem; color: #7e7e7e;line-height:1rem;"></i></div>
								<div class="item-inner">
									<div class="item-title" style="color: #7e7e7e">
										<h1>设置</h1></div>
								</div>
							</li>
						</ul>
					</div>
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
			$("#dlorders_all").click(function(){
				window.location.href="<?php echo U('./Kangli/Orders/dlorders/od_state/10/back/1');?>";
			});
			$("#dlorders_s").click(function(){
				window.location.href="<?php echo U('./Kangli/Orders/dlorders/od_state/0/back/1');?>";
			});
			$("#dlorders_m").click(function(){
				window.location.href="<?php echo U('./Kangli/Orders/dlorders/od_state/1/back/1');?>";
			});
			$("#myorder_add").click(function(){
				window.location.href="<?php echo U('./Kangli/Product/index/back/1');?>";
			});
			$("#mystock_add").click(function(){
				window.location.href="<?php echo U('./Kangli/Product/index/stock/1/back/1');?>";
			});
			$(".item-content.item-link").each(function(index) {
				// console.log('input %d is:%o',index,this);
				$(this).click(function(){
					switch(index)
					{
						case 0:

						break;	
						case 1:
							  window.location.href="<?php echo U('./Kangli/Dealer/invite');?>"
						break;						
						case 2:
 							 window.location.href="<?php echo U('./Kangli/Dealer/authorization');?>"
						break;						
						case 3:
							 window.location.href="<?php echo U('./Kangli/Dealer/stockcertificate');?>"
						break;						
						case 4:
 							  window.location.href="<?php echo U('./Kangli/Dealer/updatedltypeindex/up_status/0/back/1');?>"
						break;						
						case 5:
							  window.location.href="<?php echo U('./Kangli/Orders/dladdress/');?>"
						break;						
						case 6:
							   window.location.href="<?php echo U('./Kangli/Fanli');?>"
						break;						
						case 7:
							    window.location.href="<?php echo U('./Kangli/Feedback');?>"
						break;						
						case 8:
							   // window.location.href="login.jsp?backurl="+window.location.href;//有参
							   window.location.href="<?php echo U('./Kangli/Mine/setting');?>"
						break;						
						default:

						break;

					}
				});
			});

			$('#fw_search').click(function() {
				location.href = "<?php echo U('./Kangli/Query');?>";
			});
		});
	</script>

</html>