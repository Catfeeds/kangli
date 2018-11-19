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
			<?php echo (C("QY_COMPANY")); ?>-核对<?php if($stock == 0): ?>提货<?php else: ?>预充<?php endif; ?>订单</title>
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
				<!-- <a href="javascript:;" onClick="javascript :history.back(-1);" class="icon icon-left pull-left" style="color:#fff"></a> -->
				<a href="<?php echo U('./Kangli/Orders/shopcart');?>/stock/<?php echo ($stock); ?>" class="icon icon-left pull-left" style="color:#fff"></a>
				<h1 class="title" style="color:#fff">核对<?php if($stock == 0): ?>提货<?php else: ?>预充<?php endif; ?>订单</h1>
			</header>
			<div class="content">
				<div class="kl-layout-horizontally-vcenter" id="dl_address" style="background:#fff;margin-top:0.3rem;padding: 0.3rem 0;">
					<i class="iconfont icon-hongjiuchengicondizhi" style="font-size:1.5rem;margin:.3rem 0.5rem;color: #7e7e7e"></i>
					<div class="kl-layout-horizontally-vcenter" style="width:100%;margin-right:0.3rem;padding:.3rem 0;">
						<?php if($dladd_id == '0' ): ?><span style="color: #7e7e7e;">请选择收货地址</span>
							<?php else: ?>
							<div style="margin: 0 .3rem 0 0;width:100%">
								<div class="kl-layout-horizontally-between">
									<div class="pro_name">
										<?php echo ($dladd_address["dladd_contact"]); ?>
									</div>
									<div class="order-price">
										<?php echo ($dladd_address["dladd_tel"]); ?>
									</div>
								</div>
								<div class="pro_name" style="color: #c1c1c1;padding:.2rem 0;max-height:2rem">
									<?php echo ($dladd_address["dladd_address"]); ?>
								</div>
							</div><?php endif; ?>
					</div>
					<?php if($stock != 1): ?><i class="iconfont icon-jiantou" style="font-size:1rem;margin-right:0.5rem;;color: #7e7e7e"></i><?php endif; ?>
				</div>
				<div class="list-block media-list" style="margin-top:.3rem; margin-bottom:.3rem">
					<ul>
						<li>
							<div class="order-list">
								<?php if(is_array($shopcartlist)): foreach($shopcartlist as $key=>$item): if($item["pro_dlprice"] != '' ): ?><div class="order-content" style="padding-bottom:.5rem">
											<div class="item-media"><img src="/Kangli/Public/uploads/mobi/<?php echo ($item["pro_pic"]); ?>" style="width:3rem;margin:.5rem .5rem .5rem 0" onerror="this.src='/Kangli/Public/Kangli/static/logo_icon.png'"></div>
											<div class="order-inner">
												<div class="item-subtitle">
													<?php echo ($item["pro_name"]); ?>
												</div>
												<div class="order-remark">
													<div class="order-price" style="color: #f00;font-size:.3rem">￥<span style="font-size: 1rem"><?php echo (number_format($item["pro_dlprice"],2, '.', '')); ?></span>
													</div>
													<div class="order-price">
														<span style="padding-right:.2rem; text-decoration:line-through;color: #c1c1c1">￥<?php echo (number_format($item["pro_price"],2,'.','')); ?></span>
													</div>
													<div class="order-price">X
														<?php echo ($item["sc_qty"]); ?>
													</div>
												</div>
												<div class="order-type">
													<?php if($item["sc_color"] != '' ): ?>颜色尺码：
														<?php echo ($item["sc_color"]); ?>
															<?php echo ($item["sc_size"]); endif; ?>
												</div>
											</div>
										</div><?php endif; endforeach; endif; ?>
								<div class="order-number">
									<div class="kl-layout-horizontally-vcenter"><i class="iconfont icon-user" style="font-size:1rem;color: #7e7e7e"></i><span style="margin:0 0.2rem;"><?php echo ($dl_name); ?></span><span><?php echo (date('Y-m-d',$dl_addtime)); ?></span></div>
									<span style="color:#000">共<span style="color: red"> <?php echo ($totalqty); ?> </span>件商品，合计：<span style="color:#000">￥<?php echo (number_format($total,2,'.','')); ?></span></span>
								</div>
							</div>
						</li>
					</ul>
				</div>
				<div class="list-block" style="margin:0.3rem 0;background: #fff;">
					<div class="item-content">
						<div class="item-inner">
							<div class="item-title label" style="width:25%;font-size:.5rem">订单备注：</div>
							<div class="item-input">
								<input type="text" name="od_remark" id="od_remark" placeholder="请输入备注内容" style="font-size:.5rem;color: 7e7e7e;">
							</div>
						</div>
					</div>
				</div>
				<div class="content-block" style="margin-top:0.5rem;margin-bottom:0.5rem;">
					<p>
						<a href="#" id="order_sumbit" class="button button-fill" style="color: #fff; height:2rem;padding:.4rem;background-color:#006db2;"><?php if($stock == 1): ?>预充<?php else: ?>购买<?php endif; ?></a>
					</p>
				</div>
				<input type="hidden" id="ttamp" value="<?php echo ($ttamp); ?>">
				<input type="hidden" id="sture" value="<?php echo ($sture); ?>">
				<input type="hidden" id="dladd_id" value="<?php echo ($dladd_id); ?>">
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
			var stock="<?php echo ($stock); ?>";
			//点击提交
			$("#order_sumbit").click(function() {

				if($("#dladd_id").val() == "" || $("#dladd_id").val() == 0) {
					$.toast("请选择收货地址");
					return false;
				}

				$.confirm('是否确定提交订单!',function () {
				    var od_remark = $("#od_remark").val();
					var ttamp = $("#ttamp").val();
					var sture = $("#sture").val();
					var dladd_id = $("#dladd_id").val();
					try {
						$.ajax({
							type: 'POST',
							url: '<?php echo U("./Kangli/Orders/submitorders");?>',
							data: {
								ttamp: ttamp,
								sture: sture,
								dladd_id: dladd_id,
								od_remark: od_remark,
								stock:stock
							},
							dataType: 'json',
							timeout: 30000,
							success: function(data) {
								var stat = 0;
								stat = parseInt(data.stat);
								if(stat == 1) {
									// $.toast(data.msg);
									if (parseInt(data.stock)==0)//我的
										location.href = "<?php echo U('./Kangli/Orders/index/ly_status/1/od_status/0');?>";
									else//预充
										location.href = "<?php echo U('./Kangli/Orders');?>";
									return false;
								} else if(stat == 2) {
									$.toast(data.msg);
									// location.href = "<?php echo U('./Kangli/Index/index');?>";
									return false;
								} else {
									$.toast(data.msg);
									return false;
								}
							},
							error: function(xhr, type) {
								$.toast("超时或服务错误");
								return false;
							}
						});

					} catch(e) {
						$.toast(e);
						return false;
					}
			    });
			});
			$("#dl_address").click(function() {
				if (stock!=1)
				{
					var dladd_id=$("#dladd_id").val();
					window.location.href="<?php echo U('./Kangli/Orders/dladdress/dladd_id');?>/"+dladd_id+"/fromod/1";
				}
			});
		});
	</script>

</html>