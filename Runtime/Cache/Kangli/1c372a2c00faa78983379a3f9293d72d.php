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
			<?php echo (C("QY_COMPANY")); ?>-产品详情</title>
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

	<body ontouchstart="" style="background-color:#fafafa">
		<div class="page">
			<header class="bar bar-nav" style="background-color:#006db2;">
				<!-- <a href="javascript:;" onClick="javascript :history.back(-1);" class="icon icon-left pull-left" style="color:#fff"></a> -->
				<?php if($back == 1): ?><a href="<?php echo U('./Kangli/Product/index/');?>/stock/<?php echo ($stock); ?>/back/<?php echo ($back); ?>" class="icon icon-left pull-left" style="color:#fff"></a>
				<?php else: ?>
					<a href="<?php echo U('./Kangli/Product/index/');?>/stock/<?php echo ($stock); ?>" class="icon icon-left pull-left" style="color:#fff"></a><?php endif; ?>
				<h1 class="title" style="color:#fff">产品详情</h1>
			</header>
			<div class="content">
				<form action="<?php echo U('./Kangli/Orders/addshopcart');?>" id="fmm" method="post">
					<input type="hidden" id="stock" name="stock" value="<?php echo ($stock); ?>">
					<input type="hidden" id="pro_id" name="pro_id" value="<?php echo ($proinfo["pro_id"]); ?>">
					<input type="hidden" id="color" name="color" value="">
					<input type="hidden" id="size" name="size" value="">
					<input type="hidden" id="qty" name="qty" value="1">
				</form>
				<div class="kl-layout-center" style="height:10rem;background: #fafafa">
					<!-- Slider -->
					<div class="swiper-container">
						<div class="swiper-wrapper">
							<!-- 						<?php if(is_array($adlist)): foreach($adlist as $key=>$item): if($item["ad_url"] == '' ): ?><div class="swiper-slide"><img style="width:100%;height:7.5rem" src="/Kangli/Public/uploads/mobi/<?php echo ($item["ad_pic"]); ?>" alt=""></div>
								<?php else: ?>
									<a href="<?php echo ($item["ad_url"]); ?>">
										<div class="swiper-slide"><img style="width:100%;height:7.5rem" src="/Kangli/Public/uploads/mobi/<?php echo ($item["ad_pic"]); ?>" alt=""></div>
									</a><?php endif; endforeach; endif; ?> -->
							<?php if($proinfo["pro_pic"] != '' ): ?><div class="swiper-slide"><img style="width:100%;height:10rem" src="/Kangli/Public/uploads/product/<?php echo ($proinfo["pro_pic"]); ?>" alt=""></div><?php endif; ?>
							<?php if($proinfo["pro_pic2"] != '' ): ?><div class="swiper-slide"><img style="width:100%;height:10rem" src="/Kangli/Public/uploads/product/<?php echo ($proinfo["pro_pic"]); ?>" alt=""></div><?php endif; ?>
							<?php if($proinfo["pro_pic3"] != '' ): ?><div class="swiper-slide"><img style="width:100%;height:10rem" src="/Kangli/Public/uploads/product/<?php echo ($proinfo["pro_pic"]); ?>" alt=""></div><?php endif; ?>
							<?php if($proinfo["pro_pic4"] != '' ): ?><div class="swiper-slide"><img style="width:100%;height:10rem" src="/Kangli/Public/uploads/product/<?php echo ($proinfo["pro_pic"]); ?>" alt=""></div><?php endif; ?>
							<?php if($proinfo["pro_pic5"] != '' ): ?><div class="swiper-slide"><img style="width:100%;height:10rem" src="/Kangli/Public/uploads/product/<?php echo ($proinfo["pro_pic"]); ?>" alt=""></div><?php endif; ?>
						</div>
						<div class="swiper-pagination"></div>
					</div>
				</div>
				<div style="padding:0.5rem;margin-top:.3rem;background: #FFF">
					<div class="kl-layout-horizontally-vcenter pro_name" style="padding:.2rem .2rem 0 .2rem">
						<?php if(($proinfo["pro_dlprice"] != '') AND ($proinfo["pro_dlprice"] != '0') ): ?><span style="color:red;font-size:.5rem;">￥<span style="font-size: 1rem"><?php echo (number_format($proinfo["pro_dlprice"],2, '.', '')); ?></span></span><?php endif; ?>
						<?php if(($proinfo["pro_price"] != '') AND ($proinfo["pro_price"] != '0') ): ?><span style="padding:0 .2rem; <?php if($login == true): ?>text-decoration:line-through; color: #c1c1c1;<?php endif; ?>">￥<?php echo (number_format($proinfo["pro_price"],2,'.','')); ?></span><?php endif; ?>
					</div>
					<div class="kl-layout-horizontally ">
						<i class="iconfont icon-chanpin-copy " style="font-size:1.5rem "></i>
						<div style="margin-top:.6rem;margin-left:0.2rem ">
							<div class="kl-layout-horizontally-vcenter "><h1><?php echo ($proinfo["pro_name"]); ?></h1><span style="margin-left:0.5rem;font-size:.3rem;color: #c1c1c1 ">编号：<?php echo ($proinfo["pro_number"]); ?></span></div>
							<div class="pro_name " style="color: #c1c1c1;max-height:5rem "><?php echo ($proinfo["pro_remark"]); ?></div>
							<?php if(count($colorlist) > 0): ?><div style="margin:.3rem 0; "><h1>颜色尺码:</h1></div>
							<div style="padding-left:20% ">
								<div class="kl-layout-horizontally-vcenter " style="flex-wrap:wrap; ">
									<?php if(is_array($colorlist)): foreach($colorlist as $key=>$item): ?><button class="button button-light colorbtn " data-value="<?php echo ($item["attr_color"]); ?>" data-sizes="<?php echo ($item["sizes"]); ?>" style="margin-left:.3rem;margin-bottom: 0.3rem;"><?php echo ($item["attr_color"]); ?></button><?php endforeach; endif; ?>
								</div>
								<div class="kl-layout-horizontally-vcenter" style="flex-wrap:wrap;">
									<?php if(is_array($sizelist)): foreach($sizelist as $key=>$item): ?><button class="button button-light sizebtn" data-value="<?php echo ($item["attr_size"]); ?>" data-colors="<?php echo ($item["colors"]); ?>" style="margin-left:.3rem;margin-bottom: 0.3rem;"><?php echo ($item["attr_size"]); ?></button><?php endforeach; endif; ?>
								</div>
							</div><?php endif; ?>
						</div>
					</div>
				</div>
				<div style="padding:3rem 0.5rem">
					<?php echo ($proinfo["pro_desc"]); ?>
				</div>
			</div>
			<footer class="kl-foot-fixed" style="background: #fff;width: 100%;height:3rem; overflow: hidden;">
				<div class="kl-layout-horizontally" style="margin: 0rem;">
					<div class="kl-layout-center" style="width:20%;height:3rem;">
						<div class="center-vertical" id="shopcar">
							<div class="kl-layout-center" style="margin: 0rem;">
								<i class="iconfont icon-gouwuche" style="font-size:1rem"></i>
								<?php if($shopcarcount > 0): ?><span class="kl-badge" style="background-color:red;position: absolute;top:10%;left:11%"><?php echo ($shopcarcount); ?></span><?php endif; ?>
							</div>
							<div style="color:#c1c1c1;font-size:0.2rem;">购物车</div>
						</div>
					</div>
					<div class="kl-layout-center" id="shopcar_add" style="width:40%;height:3rem;background:#000;font-size:0.75rem;color: #fff">加入购物车</div>
					<div class="kl-layout-center" id="orderlist_add" style="width:40%;height:3rem;background:#f08519;font-size:0.75rem;color: #fff;margin:0rem;">立即购买</div>
				</div>
			</footer>
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

	<script type='text/javascript' src='/Kangli/Public/Kangli/js/swiper.min.js' charset='utf-8'></script>
	<script type="text/javascript">
		$.init();
		$(function() {
			var stock="<?php echo ($stock); ?>";
			var swiper = new Swiper('.swiper-container', {
				spaceBetween: 0,
				pagination: {
					el: '.swiper-pagination',
					clickable: true,
					type: 'bullets',
				},
				autoplay: {
					delay: 3000,
				}
			});

			$('.colorbtn').click(function() {
				if(!$(this).hasClass("disabled")) {
					$('.colorbtn').each(function(index, domEle) {
						if(!$(domEle).hasClass("button-light")) {
							$(domEle).addClass("button-light");
							// $(domEle).removeClass("ui-btn-primary");
						}
					});

					// $(this).addClass("ui-btn-primary");
					$(this).removeClass("button-light");

					if($(this).data('value')) {
						$("#color").val($(this).data('value'));
						$("#size").val("");
					}

					if($(this).data('sizes')) {
						var sizes = $(this).data('sizes');
						$('.sizebtn').each(function(index, domEle) {
							if(sizes.indexOf($(domEle).data('value')) > 0) {
								if(!$(domEle).hasClass("button-light")) {
									$(domEle).addClass("button-light");
									// $(domEle).removeClass("ui-btn-primary");
								}

								if($(domEle).hasClass("disabled")) {
									$(domEle).addClass("button-light");
									$(domEle).removeClass("disabled");
								}
							} else {
								if($(domEle).hasClass("button-light")) {
									$(domEle).addClass("disabled");
									$(domEle).removeClass("button-light");
								}

								if(!$(domEle).hasClass("button-light")) {
									$(domEle).addClass("disabled");
									// $(domEle).removeClass("ui-btn-progress");
								}
							}
						});
					}
				}
			});

			$('.sizebtn').click(function() {
				// $.toast("尺码点击");
				if(!$(this).hasClass("disabled")) {
					$('.sizebtn').each(function(index, domEle) {
						if(!$(domEle).hasClass("button-light")) {
							$(domEle).addClass("button-light");
							// $(domEle).removeClass("ui-btn-primary");

						}
					});

					// $(this).addClass("button-light");
					$(this).removeClass("button-light");

					if($(this).data('value')) {
						$("#size").val($(this).data('value'));
					}
				}
			});
			
			$('#shopcar').click(function() {
				window.location.href = "<?php echo U('./Kangli/Orders/shopcart/stock');?>/"+stock;
			});
			$('#shopcar_add').click(function(){
				var colorArray=<?php echo json_encode($colorlist);?>;
				if ($.isArray(colorArray)&&colorArray.length>0)
				{
					if($("#color").val() == "") {
						$.toast("请选择颜色"); 
						return false; 
					} 
					if($("#size").val() == "") {
						$.toast("请选择尺码");  
						return false; 
					} 
				}			
				$("#fmm").submit();
			});
			$('#orderlist_add').click(function() {
				window.location.href="<?php echo U('./Kangli/Orders/checkshopcart');?>"+"/stock/"+stock;
			});

		});
	</script>

</html>