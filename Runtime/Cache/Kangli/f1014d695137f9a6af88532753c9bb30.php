<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>

	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
		<link rel="shortcut icon" href="/Kangli/Public/Kangli/static/chuanshu_min.png">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-status-bar-style" content="black">
		<meta name="format-detection" content="telephone=no,email=no,adress=no">
		<title>
			<?php echo (C("QY_COMPANY")); ?>-<?php echo ($addtitle); ?></title>
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
				<!-- <a href="javascript:;" onClick="javascript :history.back(-1);" class="icon icon-left pull-left" style="color:#fff"></a> -->
				<?php if($dladd_id > 0): ?><a href="<?php echo U('./Kangli/Orders/checkshopcart/');?>/dladd_id/<?php echo ($dladd_id); ?>" class="icon icon-left pull-left" style="color:#fff"></a>
				<?php else: ?>
					<a href="<?php echo U('./Kangli/Mine');?>" class="icon icon-left pull-left" style="color:#fff"></a><?php endif; ?>
				<h1 class="title" style="color:#fff"><?php echo ($addtitle); ?></h1>
			</header>
			<div class="content">
				<div class="list-block media-list" style="line-height:1rem; margin-top:.25rem;margin-bottom: 0rem;">
					<ul>
						<?php if(is_array($addresslist)): foreach($addresslist as $key=>$item): ?><li>
								<div class="kl-layout-horizontally-vcenter edit_address" style="background:#fff;margin-top:0.3rem;padding:0.3rem 0.5rem;border-bottom: 0.05rem solid #d5d5d5;">
									<i class="iconfont icon-bianji edit_icon" onClick="event.cancelBubble = true" style="font-size:1.5rem;margin-right:0.5rem;color: #7e7e7e"></i>
									<div class="kl-layout-horizontally-vcenter" style="width:100%;margin-right:0.3rem;padding:.3rem 0;">
											<div style="margin: 0 .3rem 0 0;width:100%">
												<div class="kl-layout-horizontally-between">
													<div class="pro_name">
														<?php echo ($item['dladd_contact']); ?>
													</div>
													<div class="order-price">
														<?php echo ($item['dladd_tel']); ?>
													</div>
												</div>
												<div class="pro_name" style="color: #c1c1c1;padding:.2rem 0;max-height:2rem">
													<?php if($item["dladd_default"] == 1): ?><span style="color: red">[默认]</span><?php endif; ?> <?php echo ($item['dladd_address']); ?>
												</div>
											</div>
									</div>
									<?php if($item["dladd_default"] == 1): ?><i class="iconfont icon-xuanze" style="font-size:1rem;color: #7e7e7e"></i>
									<?php else: ?>
										<i class="iconfont icon-xuanze1" style="font-size:1rem;color: #7e7e7e"></i><?php endif; ?>
								</div>
							</li><?php endforeach; endif; ?>
					</ul>
				</div>
				<div class="content-block" id="add_address" style="margin-top:2rem;margin-bottom:0.5rem;">
					<p>
						<a href="#" class="button button-fill" style="color: #fff; height:2rem;padding:.4rem;background-color:#006db2;">新增地址</a>
					</p>
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
			var fromod="<?php echo ($fromod); ?>";
			var adArray=<?php echo json_encode($addresslist);?>||[];
			$('.edit_icon').each(function(index) {
				// console.log('li %d is:%o',index,this);
				if ($.isArray(adArray)&&adArray.length>index)
				{
					var adObject=adArray[index];
					$(this).click(function(){
        			if ($.isPlainObject(adObject))
					{
						window.location.href="<?php echo U('./Kangli/Orders/updateaddress/fromod');?>/"+fromod+"/addid/"+adObject['dladd_id'];
					}    		
				});
				}
			});

			$('.kl-layout-horizontally-vcenter.edit_address').each(function(index) {
				console.log('li %d is:%o',index,this);
				if ($.isArray(adArray)&&adArray.length>index)
				{
					var adObject=adArray[index];
					$(this).click(function(){
						if ($.isPlainObject(adObject))
						{
							if (fromod==1)
								window.location.href="<?php echo U('./Kangli/Orders/checkshopcart/dladd_id/');?>/"+adObject['dladd_id'];
							else
								window.location.href="<?php echo U('./Kangli/Orders/defaultaddress/addid');?>/"+adObject['dladd_id'];
						}
					});
				}
			});

			$("#add_address").click(function() {
				window.location.href="<?php echo U('./Kangli/Orders/updateaddress/fromod');?>/"+fromod;
			});
		});
	</script>

</html>