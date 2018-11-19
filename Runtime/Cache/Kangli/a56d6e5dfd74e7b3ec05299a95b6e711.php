<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
		<link rel="shortcut icon" href="/Kangli/Public/Kangli/static/chuanshu_min.png">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-status-bar-style" content="black">
		<meta name="format-detection" content="telephone=no,email=no,adress=no">
		<title><?php echo (C("QY_COMPANY")); ?>-返利详情</title>
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
				<a href="javascript:;" onClick="javascript :history.back(-1);" class="icon icon-left pull-left" style="color:#fff"></a>
				<!-- <a href="<?php echo U('./Kangli/Fanli/index');?>/state/<?php echo ($state); ?>/ly_status/<?php echo ($ly_status); ?>" class="icon icon-left pull-left" style="color:#fff"></a> -->
				<h1 class="title" style="color:#fff">返利详情</h1>
			</header>
			<div class="content">
				 <div class="list-block" style="margin: 0.3rem 0;">
				    <ul>
				      <!-- Text inputs -->
				      <li>
				        <div class="item-content">
				          <div class="item-inner">
				            <div class="item-title">返利类型：<span style="color:#f08519;"><?php echo ($fanliinfo["fl_typestr"]); ?></span></div>
				          </div>
				        </div>
				      </li>
				      <li>
				        <div class="item-content">
				          <div class="item-inner">
				            <div class="item-title">金额：<span style="color: red; font-size:1rem;">￥<?php echo (number_format($fanliinfo["fl_money"],2,'.','')); ?></span></div>
				          </div>
				        </div>
				      </li>
				      <?php if(!empty($fanliinfo["fl_orderid"])): ?><li>
				         <div class="item-content">
				          <div class="item-inner">
				            <div class="item-title">相关订单：<?php echo ($fanliinfo["fl_orderid"]); ?></div>
				          </div>
				        </div>
				      </li><?php endif; ?>
				      <li>
				         <div class="item-content">
				          <div class="item-inner">
				            <div class="item-title">时间：<?php echo (date('Y-m-d H:i:s',$fanliinfo["fl_addtime"])); ?></div>
				          </div>
				        </div>
				      </li>
				      <?php if($fanliinfo["fl_rdl_name"] != '' or $fanliinfo["fl_rdl_username"] != ''): ?><li>
							 <div class="item-content">
					          <div class="item-inner">
					            <div class="item-title">收款方：<?php if(!empty($fanliinfo["fl_rdl_name"])): echo ($fanliinfo["fl_rdl_name"]); endif; ?> <?php if(!empty($fanliinfo["fl_rdl_username"])): ?>(<?php echo ($fanliinfo["fl_rdl_username"]); ?>)<?php endif; ?></div>
					          </div>
					        </div>
					      </li><?php endif; ?>
				      <!-- Switch (Checkbox) -->
				      <?php if($fanliinfo["fl_sdl_name"] != '' or $fanliinfo["fl_sdl_name"] != ''): ?><li>
					         <div class="item-content">
					          <div class="item-inner">
					            <div class="item-title">付款方：<?php if(!empty($fanliinfo["fl_sdl_name"])): echo ($fanliinfo["fl_sdl_name"]); endif; ?> <?php if(!empty($fanliinfo["fl_sdl_username"])): ?>(<?php echo ($fanliinfo["fl_sdl_username"]); ?>)<?php endif; ?></div>
					          </div>
					        </div>
					      </li><?php endif; ?>
				      <li>
				         <div class="item-content">
				          <div class="item-inner">
				            <div class="item-title">状态：<?php echo ($fanliinfo["fl_state_str"]); ?></div>
				          </div>
				        </div>
				      </li>
				      <li class="align-top">
				        <div class="item-content">
				          <div class="item-inner">
				            <div class="item-input">
				              <textarea style="font-size: .5rem;color:#c1c1c1;padding-left: 0;">说明：<?php echo ($fanliinfo["fl_remark"]); ?></textarea>
				            </div>
				          </div>
				        </div>
				      </li>
				    </ul>
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