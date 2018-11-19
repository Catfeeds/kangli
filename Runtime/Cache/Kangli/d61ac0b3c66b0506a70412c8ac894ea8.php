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
			<?php echo (C("QY_COMPANY")); ?>-订单详情</title>
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
			.modal-button {
        		font-size: .5rem;
      		}
		</style>
	</head>

	<body ontouchstart="" style="background-color:#FAFAFA">
		<div class="page">
			<header class="bar bar-nav" style="background-color:#006db2;">
<!-- 				<?php if($ly_status > 0): ?><a href="<?php echo U('./Kangli/Orders/index/ly_status/1');?>" class="icon icon-left pull-left" style="color:#fff"></a>
				<?php else: ?>
					<a href="javascript:;" onClick="javascript :history.back(-1);" class="icon icon-left pull-left" style="color:#fff"></a><?php endif; ?> -->
				<?php if($ly_status == 1): ?><a href="<?php echo U('./Kangli/Orders/index/ly_status');?>/<?php echo ($ly_status); ?>/od_state/<?php echo ($od_state); ?>" class="icon icon-left pull-left" style="color:#fff"></a>
				<?php else: ?>
					<a href="<?php echo U('./Kangli/Orders/dlycorders');?>" class="icon icon-left pull-left" style="color:#fff"></a><?php endif; ?>
				<h1 class="title" style="color:#fff">订单详情</h1>
			</header>
			<div class="content">
				<div class="kl-layout-horizontally" style="width:100%;padding:.5rem;background: #75787f;">
					<i class="iconfont icon-dingdan" style="font-size:1rem;color: #fff"></i>
					<div style="width: 100%;color:#fff">
						<div class="kl-layout-horizontally-between">
							<div class="pro_name" style="padding: .0 .3rem .3rem .3rem">
								订单号：
								<?php echo ($ordersinfo["od_orderid"]); ?>
							</div>
							<div class="order-price" style="padding: .0 0 .3rem 0">
								<?php echo ($ordersinfo["od_state_str"]); ?>
							</div>
						</div>
						<div class="pro_name" style="padding: .0 .3rem .3rem .3rem">
							<?php if($ordersinfo["od_expressname"] != ''): ?>物流信息：
								<?php echo ($ordersinfo["od_expressname"]); ?>
									<?php if($ordersinfo["od_expressnum"] != ''): ?>单号
										<?php echo ($ordersinfo["od_expressnum"]); endif; endif; ?>
						</div>
						<div class="pro_name" style="padding: .0 .3rem 0rem .3rem;font-size: 0.3rem; color: #c1c1c1">
							<?php echo (date('Y-m-d h:i:s' ,$ordersinfo["od_addtime"])); ?>
						</div>
					</div>
				</div>
				<div class="kl-layout-horizontally-vcenter" id="dl_address" style="background:#fff;margin-top:0.3rem;">
					<i class="iconfont icon-hongjiuchengicondizhi" style="font-size:1.5rem;margin:.3rem 0.5rem;color: #7e7e7e"></i>
					<div class="kl-layout-horizontally-vcenter" style="width:100%;margin-right:0.3rem;padding:.3rem 0;">
						<div style="margin: 0 .3rem 0 0;width:100%;">
							<div class="kl-layout-horizontally-between">
								<div class="pro_name">
									<?php echo ($ordersinfo["od_contact"]); ?></div>
								<div class="order-price">
									<?php echo ($ordersinfo["od_tel"]); ?>
								</div>
							</div>
							<div class="pro_name" style="color: #c1c1c1;padding:.2rem 0;max-height:2rem">
								<?php echo ($ordersinfo["od_address"]); ?>
							</div>
						</div>
					</div>
				</div>
				<div class="list-block media-list" style="margin:.3rem 0 0 0; ">
					<ul>
						<li>
							<div class="order-list all_odlist">
								<?php if(is_array($ordersinfo['orderdetail'])): foreach($ordersinfo['orderdetail'] as $key=>$item): ?><div class="order-content" style="padding-bottom: 0.2rem">
										<div class="item-media"><img src="/Kangli/Public/uploads/mobi/<?php echo ($item["oddt_propic"]); ?>" style="width:3.5rem;" onerror="this.src='/Kangli/Public/Kangli/static/logo_icon.png'"></div>
										<div class="order-inner">
											<div class="item-subtitle" style="font-size: 0.5rem">
												<?php echo ($item["oddt_proname"]); ?>
											</div>
											<div class="order-remark">
												<div class="kl-layout-horizontally-between">
													<div>
														<div class="pro_name" style="color: red;">￥<span style="font-size:.75rem"><?php echo (number_format($item["oddt_dlprice"],2,'.','')); ?></span>
															<?php if($item["oddt_price"] > 0): ?><span style="padding-right:.2rem; text-decoration:line-through;color:#c1c1c1">￥<?php echo (number_format($item["oddt_price"],2,'.','')); ?></span><?php endif; ?>
														</div>
														<div class="pro_name">订购：
															<?php echo ($item["oddt_qty"]); ?>
																<?php echo ($item["oddt_prounits"]); ?>
																	<?php echo ($item["oddt_totalqty"]); ?>　已发：
																		<?php echo ($item["oddt_shipqty"]); ?>
														</div>
													</div>
													<!-- <?php if(($item["od_state"] == 1) or ($item["od_state"] == 2)): ?><i class="iconfont icon-saomiao all_odsaomian" style="font-size: 2rem;color: #167abe;"></i><?php endif; ?> -->
												</div>
											</div>
											<div class="order-type">
												<?php if($item["oddt_color"] != '' ): ?>颜色尺码：
													<?php echo ($item["oddt_color"]); ?>
														<?php echo ($item["oddt_size"]); endif; ?>
											</div>
										</div>
									</div><?php endforeach; endif; ?>
								<div class="order-number">
									<div class="kl-layout-horizontally-vcenter"><i class="iconfont icon-user" style="font-size:1rem;color: #7e7e7e"></i><span style="margin:0 0.2rem;"><?php echo ($ordersinfo["od_dl_name"]); ?></span><span><?php echo (date('Y-m-d',$ordersinfo["od_addtime"])); ?></span></div>
									<span style="color:#000">共<span style="color: red"> <?php echo ($ordersinfo["odtotalqty"]); ?> </span>件商品，合计：<span style="color:#000">￥<?php echo (number_format($ordersinfo["od_total"],2,'.','')); ?></span></span>
								</div>
								<div class="order-bottom">
									<div class="order-button-type">
										<?php if($ordersinfo["od_state"] == 0): ?><a href="#" class="button button-light button-round order-button" id="dtl_odcancel" style="color:#ccc;margin-left:.5rem; border-radius:0.2rem;">删除订单</a><?php endif; ?>
										<?php if($ordersinfo["od_state"] == 3): ?><a href="#" class="button button-warning button-round order-button" id="dtl_odshouhuo" style="margin-left:.5rem;border-radius:0.2rem;">确定收货</a><?php endif; ?>
										<?php if($ordersinfo["od_state"] < 3): ?><a href="#" class="button button-warning button-round order-button" id="dtl_odpingzheng" style="margin-left:.5rem;border-radius:0.2rem;">上传凭证</a><?php endif; ?>
									</div>
								</div>
							</div>
						</li>

					</ul>
				</div>
				<div style="background: #fff; margin-top:0.25rem;padding: .5rem">
					 <div style="margin: 0.3rem 0"><h1>下单代理</h1></div>
					 <div ><span style="color: #c1c1c1">微信：<?php echo ($ordersinfo["od_dl_weixin"]); ?></span></div>
					 <div ><span style="color: #c1c1c1">姓名：<?php echo ($ordersinfo["od_dl_name"]); ?></span></div>
					 <div ><span style="color: #c1c1c1">电话：<?php echo ($ordersinfo["od_dl_tel"]); ?></span></div>
					 <div style="margin: 0.3rem 0"><h1>支付凭证：</h1></div>
					 <?php if($ordersinfo["od_paypic_str"] != ''): ?><div class="item-input" style="margin: 0.3rem 0"><img class="kl-img-thumbnail" id="img_file" src="<?php echo ($ordersinfo["od_paypic_str"]); ?>" style="width:4rem;margin-top:.2rem;"></div><?php endif; ?>
					<div><span style="color: #c1c1c1"><?php echo ($ordersinfo["od_remark"]); ?></span></div>
				</div>

				<div style="background: #fff; margin-top:0.25rem;padding: .5rem">
					 <div style="margin: 0.3rem 0"><h1>操作日记</h1></div>
					    <?php if(is_array($orderlogs)): foreach($orderlogs as $key=>$item): ?><p style="color:#c1c1c1"><b><?php echo ($item["odlg_action"]); ?></b>　<?php echo ($item["odlg_dlname"]); ?>　<?php echo (date('Y-m-d H:i:s',$item["odlg_addtime"])); ?></p><?php endforeach; endif; ?>
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
			var odObject=<?php echo json_encode($ordersinfo);?>;
			var ly_status="<?php echo ($ly_status); ?>"
			// console.log(JSON.stringify(odObject));
			$("#dtl_odpingzheng").click(function(){
				if($.isPlainObject(odObject))
				{
					window.location.href="<?php echo U('./Kangli/Orders/uploadpaypic/od_id');?>/"+odObject['od_id']+"/ly_status/"+ly_status;
				}
			});
			$("#dtl_odcancel").click(function(){
				if ($.isPlainObject(odObject))
				{
					 $.confirm('是否确定取消该订单?',function () {
					 	// $.toast("取消");
		               window.location.href="<?php echo U('./Kangli/Orders/canceldlorder/od_id');?>/"+odObject['od_id']+"/state/9/od_state/10/ly_status/1";
		            });
				}
			});
			$("#dtl_odshouhuo").click(function(){
				if ($.isPlainObject(odObject))
				{
					 $.confirm('是否确定收货?',function () {
					 	// $.toast("取消");
		               window.location.href="<?php echo U('./Kangli/Orders/confirmreceipt/od_id');?>/"+odObject['od_id']+"/od_state/10/ly_status/1";
		            });
				}
			});
		});
	</script>

</html>