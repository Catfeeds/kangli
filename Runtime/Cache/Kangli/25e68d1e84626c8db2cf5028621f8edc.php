<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
		<link rel="shortcut icon" href="/Public/Kangli/static/chuanshu_min.png">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-status-bar-style" content="black">
		<meta name="format-detection" content="telephone=no,email=no,adress=no">
		<title>
			<?php echo (C("QY_COMPANY")); ?>-订单</title>
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
			
			.buttons-tab {
				margin: 0;
				background: #fff;
				position: relative;
			}
			
			.buttons-tab .button {
				font-size: .6rem;
			}
			
			.buttons-tab .button.active,
			.buttons-tab .button:active {
				font-size: .6rem;
				color: #f08519;
				border-color: #f08519;
			}
			
			.content-block {
				margin: 0rem 0;
				padding: 0rem;
				color: #6d6d72;
			}
			
			.badge {
				display: inline-block;
				padding: 0.1rem 0.25rem 0.1rem 0.25rem;
				font-size: .3rem;
				line-height: .6rem;
				color: #fff;
				background-color: rgba(0, 0, 0, .15);
				border-radius: 5rem;
			}
			
			.modal-button {
				font-size: .5rem;
			}
		</style>
	</head>

	<body ontouchstart="" style="background-color:#fafafa">
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
						<a class="tab-item" id="fw_search" href="#">
							<img src="/Public/Kangli/static/fangwei_icon.png">
						</a>
					</li>
					<li>
						<a class="tab-item active" href="#">
							<i class="iconfont active icon-icon"></i>
							<div class="name">订单</div>
						</a>
					</li>
					<li>
						<a class="tab-item" href="<?php echo U('./Kangli/Mine');?>">
							<i class="iconfont icon-user2"></i>
							<div class="name">我</div>
						</a>
					</li>
				</ul>
			</nav>
			<div class="content">
				<!-- pie chart -->
				<div class="buttons-tab">
					<a href="#tab1" id="send_order" class="tab-link active button">
						<div>
							<h1>发货订单</h1></div>
					</a>
					<a href="#tab2" id="my_order" class="tab-link button">
						<div>
							<h1>提货订单</h1></div>
					</a>
				</div>
				<div class="content-block">
					<div class="tabs">
						<div id="tab1" class="tab active">
							<div class="content-block" style="min-height: 10rem;">
								<!-- dreanlist -->
								<div class="list-block" style="margin-top:.25rem;margin-bottom: 0rem;">
									<ul>
										<li class="item-content item-link">
											<div class="item-media"><i class="iconfont icon-daiqueren" style="font-size:1rem; color: #006db8;line-height:1rem;"></i></div>
											<div class="item-inner">
												<div class="item-title">
													<h1>待确认订单</h1></div>
												<?php if($dlsodcount > 0): ?><div class="item-after"><span class="kl-badge" style="background-color:red;"><?php echo ($dlsodcount); ?></span></div>
													<?php else: ?>
													<div class="item-after"><span class="kl-badge"><?php echo ($dlsodcount); ?></span></div><?php endif; ?>
											</div>
										</li>
										<li class="item-content item-link">
											<div class="item-media"><i class="iconfont icon-daifahuo" style="font-size:1rem; color: #006db8;line-height: 1rem;"></i></div>
											<div class="item-inner">
												<div class="item-title">
													<h1>待发货订单</h1></div>
												<?php if($dlmodcount > 0): ?><div class="item-after"><span class="kl-badge" style="background-color:red;"><?php echo ($dlmodcount); ?></span></div>
													<?php else: ?>
													<div class="item-after"><span class="kl-badge"><?php echo ($dlmodcount); ?></span></div><?php endif; ?>
											</div>
										</li>
										<li class="item-content item-link">
											<div class="item-media"><i class="iconfont icon-che1" style="font-size:1rem; color: #006db8;line-height: 1rem;"></i></div>
											<div class="item-inner">
												<div class="item-title">
													<h1>已发货订单</h1>
												</div>
											</div>
										</li>
										<li class="item-content item-link" style="display: none;">
											<div class="item-media"><i class="iconfont icon-203lingshoutuihuo" style="font-size:1rem; color: #f08519;line-height: 1rem;"></i></div>
											<div class="item-inner">
												<div class="item-title">
													<h1>已取消订单</h1>
												</div>
												<?php if($dlcodcount > 0): ?><div class="item-after"><span class="kl-badge" style="background-color:red;"><?php echo ($dlcodcount); ?></span></div>
													<?php else: ?>
													<div class="item-after"><span class="kl-badge"><?php echo ($dlcodcount); ?></span></div><?php endif; ?>
											</div>
										</li>
									</ul>
								</div>
								<!-- dreanlist -->
								<div class="list-block" style="margin-top:.25rem;margin-bottom: 0rem;">
									<ul>
										<li class="item-content item-link">
											<div class="item-media"><i class="iconfont icon-kucunpandianbaobiao" style="font-size:1rem; color: #05d0c3;line-height: 1rem;"></i></div>
											<div class="item-inner">
												<div class="item-title">
													<h1>预充库存订单</h1></div>
												<?php if($dlycodcount > 0): ?><div class="item-after"><span class="kl-badge" style="background-color:red;"><?php echo ($dlycodcount); ?></span></div>
													<?php else: ?>
													<div class="item-after"><span class="kl-badge"><?php echo ($dlycodcount); ?></span></div><?php endif; ?>
											</div>
										</li>
									</ul>
								</div>
							</div>
						</div>
						<div id="tab2" class="tab">
							<div class="content-block" style="min-height: 10rem; margin-top: .3rem;">
								<div class="buttons-tab">
									<a href="#tab2_1" id="my_all" class="tab-link active button">全部</a>
									<a href="#tab2_2" id="my_sure" class="tab-link button">待确认
										<?php if($mysodcount > 0): ?><span class="order-circle order-number-thumbnail" style="position: absolute;top:10%;right:10%; color: red"><?php echo ($mysodcount); ?></span><?php endif; ?>
									</a>
									<a href="#tab2_3" id="my_send" class="tab-link button">待发货
										<?php if($mymodcount > 0): ?><span class="order-circle order-number-thumbnail" style="position: absolute;top:10%;right:10%; color: red"><?php echo ($mymodcount); ?></span><?php endif; ?>
									</a>
									<a href="#tab2_4" id="my_sended" class="tab-link button">已发货
										<?php if($myyodcount > 0): ?><span class="order-circle order-number-thumbnail" style="position: absolute;top:10%;right:10%; color: red"><?php echo ($myyodcount); ?></span><?php endif; ?>
									</a>
									<a href="#tab2_5" id="my_finish" class="tab-link button">已完成</a>
								</div>
								<div class="content-block">
									<div class="tabs">
										<div id="tab2_1" class="tab active">
											<div class="content-block">
												<div class="list-block media-list" style="margin-top:0rem; ">
													<ul>
														<?php if(is_array($list)): foreach($list as $key=>$item): ?><li>
																<div class="order-list all_odlist" style="border-bottom:.2rem solid #EFEFF4;">
																	<div class="order-number">
																		<span>订单号：<?php echo ($item["od_orderid"]); ?></span>
																		<span style="color: #f08519"><?php echo ($item["od_state_str"]); ?></span>
																	</div>
																	<?php if(is_array($item['orderdetail'])): foreach($item['orderdetail'] as $key2=>$item2): ?><div class="order-content" style="padding-bottom: 0.5rem">
																			<div class="item-media"><img src="/Public/uploads/mobi/<?php echo ($item2["oddt_propic"]); ?>" style="width:3.5rem;" onerror="this.src='/Public/Kangli/static/logo_icon.png'"></div>
																			<div class="order-inner">
																				<div class="item-subtitle" style="font-size: 0.5rem">
																					<?php echo ($item2["oddt_proname"]); ?>
																				</div>
																				<div class="order-remark">
																					<div class="kl-layout-horizontally-between">
																						<div>
																							<div class="pro_name" style="color: red;">￥<span style="font-size:.75rem"><?php echo (number_format($item2["oddt_dlprice"],2,'.','')); ?></span>
																								<?php if($item2["oddt_price"] > 0): ?><span style="padding-right:.2rem; text-decoration:line-through;color:#c1c1c1">￥<?php echo (number_format($item2["oddt_price"],2,'.','')); ?></span><?php endif; ?>
																							</div>
																							<div class="pro_name">提货：
																								<?php echo ($item2["oddt_qty"]); ?>
																									<?php echo ($item2["oddt_prounits"]); ?>
																										<?php echo ($item2["oddt_totalqty"]); ?>　已发：
																											<?php echo ($item2["oddt_shipqty"]); ?>
																							</div>
																						</div>
																						<!-- 																					<?php if(($item["od_state"] == 1) or ($item["od_state"] == 2)): ?><i class="iconfont icon-saomiao all_odsaomian" style="font-size: 2rem;color: #167abe;"></i><?php endif; ?> -->
																					</div>
																				</div>
																				<div class="order-type">
																					<?php if($item2["oddt_color"] != '' ): ?>颜色尺码：
																						<?php echo ($item2["oddt_color"]); ?>
																							<?php echo ($item2["oddt_size"]); endif; ?>
																				</div>
																			</div>
																		</div><?php endforeach; endif; ?>
																	<div class="order-number">
																		<span><?php echo (date('Y-m-d h:i:s',$item["od_addtime"])); ?></span>
																		<span style="color:#000">共<span style="color: red"> <?php echo ($item["odtotalqty"]); ?> </span>件商品，合计：<span style="color:#000">￥<?php echo (number_format($item["od_total"],2,'.','')); ?></span></span>
																	</div>
																	<div class="order-bottom">
																		<div class="order-button-type">
																			<?php if($item["od_state"] == 0): ?><a href="#" class="button button-light button-round order-button" id="all_odcancel" style="color:#ccc;margin-left:.5rem;">取消</a><?php endif; ?>
																			<?php if($item["od_state"] == 3): ?><a href="#" class="button button-warning button-round order-button" id="all_odshouhuo" style="margin-left:.5rem;">收货</a><?php endif; ?>
																			<?php if($item["od_state"] < 3): ?><a href="#" class="button button-warning button-round order-button" id="all_odpingzheng" style="margin-left:.5rem;">凭证</a><?php endif; ?>
																			<a href="#" class="button button-warning button-round order-button" id="all_oddetail">详情</a>
																		</div>
																	</div>
																</div>
															</li><?php endforeach; endif; ?>
													</ul>
												</div>
											</div>
										</div>
										<div id="tab2_2" class="tab">
											<div class="content-block">
												<div class="list-block media-list" style="margin-top:0rem; ">
													<ul>
														<?php if(is_array($list)): foreach($list as $key=>$item): if($item["od_state"] == 0): ?><li>
																	<div class="order-list s_odlist" style="border-bottom:.2rem solid #EFEFF4;">
																		<div class="order-number">
																			<span>订单号：<?php echo ($item["od_orderid"]); ?></span>
																			<span style="color: #f08519"><?php echo ($item["od_state_str"]); ?></span>
																		</div>
																		<?php if(is_array($item['orderdetail'])): foreach($item['orderdetail'] as $key2=>$item2): ?><div class="order-content" style="padding-bottom: 0.5rem">
																				<div class="item-media"><img src="/Public/uploads/mobi/<?php echo ($item2["oddt_propic"]); ?>" style="width:3.5rem;" onerror="this.src='/Public/Kangli/static/logo_icon.png'"></div>
																				<div class="order-inner">
																					<div class="item-subtitle" style="font-size: 0.5rem">
																						<?php echo ($item2["oddt_proname"]); ?>
																					</div>
																					<div class="order-remark">
																						<div class="kl-layout-horizontally-between">
																							<div>
																								<div class="pro_name" style="color: red;">￥<span style="font-size:.75rem"><?php echo (number_format($item2["oddt_dlprice"],2,'.','')); ?></span>
																									<?php if($item2["oddt_price"] > 0): ?><span style="padding-right:.2rem; text-decoration:line-through;color:#c1c1c1">￥<?php echo (number_format($item2["oddt_price"],2,'.','')); ?></span><?php endif; ?>
																								</div>
																								<div class="pro_name">提货：
																									<?php echo ($item2["oddt_qty"]); ?>
																										<?php echo ($item2["oddt_prounits"]); ?>
																											<?php echo ($item2["oddt_totalqty"]); ?>　已发：
																												<?php echo ($item2["oddt_shipqty"]); ?>
																								</div>
																							</div>
																							<!-- 																					<?php if(($item["od_state"] == 1) or ($item["od_state"] == 2)): ?><i class="iconfont icon-saomiao all_odsaomian" style="font-size: 2rem;color: #167abe;"></i><?php endif; ?> -->
																						</div>
																					</div>
																					<div class="order-type">
																						<?php if($item2["oddt_color"] != '' ): ?>颜色尺码：
																							<?php echo ($item2["oddt_color"]); ?>
																								<?php echo ($item2["oddt_size"]); endif; ?>
																					</div>
																				</div>
																			</div><?php endforeach; endif; ?>
																		<div class="order-number">
																			<span><?php echo (date('Y-m-d h:i:s',$item["od_addtime"])); ?></span>
																			<span style="color:#000">共<span style="color: red"> <?php echo ($item["odtotalqty"]); ?> </span>件商品，合计：<span style="color:#000">￥<?php echo (number_format($item["od_total"],2,'.','')); ?></span></span>
																		</div>
																		<div class="order-bottom">
																			<div class="order-button-type">
																				<?php if($item["od_state"] == 0): ?><a href="#" class="button button-light button-round order-button" id="s_odcancel" style="color:#ccc;margin-left:.5rem;">取消</a><?php endif; ?>
																				<?php if($item["od_state"] == 3): ?><a href="#" class="button button-warning button-round order-button" id="s_odshouhuo" style="margin-left:.5rem;">收货</a><?php endif; ?>
																				<?php if($item["od_state"] < 3): ?><a href="#" class="button button-warning button-round order-button" id="s_odpingzheng" style="margin-left:.5rem;">凭证</a><?php endif; ?>
																				<a href="#" class="button button-warning button-round order-button" id="s_oddetail">详情</a>
																			</div>
																		</div>
																	</div>
																</li><?php endif; endforeach; endif; ?>
													</ul>
												</div>
											</div>
										</div>
										<div id="tab2_3" class="tab">
											<div class="content-block">
												<div class="list-block media-list" style="margin-top:0rem;">
													<ul>
														<?php if(is_array($list)): foreach($list as $key=>$item): if(($item["od_state"] == 1) or ($item["od_state"] == 2)): ?><li>
																	<div class="order-list m_odlist" style="border-bottom:.2rem solid #EFEFF4;">
																		<div class="order-number">
																			<span>订单号：<?php echo ($item["od_orderid"]); ?></span>
																			<span style="color: #f08519"><?php echo ($item["od_state_str"]); ?></span>
																		</div>
																		<?php if(is_array($item['orderdetail'])): foreach($item['orderdetail'] as $key2=>$item2): ?><div class="order-content" style="padding-bottom: 0.5rem">
																				<div class="item-media"><img src="/Public/uploads/mobi/<?php echo ($item2["oddt_propic"]); ?>" style="width:3.5rem;" onerror="this.src='/Public/Kangli/static/logo_icon.png'"></div>
																				<div class="order-inner">
																					<div class="item-subtitle" style="font-size: 0.5rem">
																						<?php echo ($item2["oddt_proname"]); ?>
																					</div>
																					<div class="order-remark">
																						<div class="kl-layout-horizontally-between">
																							<div>
																								<div class="pro_name" style="color: red;">￥<span style="font-size:.75rem"><?php echo (number_format($item2["oddt_dlprice"],2,'.','')); ?></span>
																									<?php if($item2["oddt_price"] > 0): ?><span style="padding-right:.2rem; text-decoration:line-through;color:#c1c1c1">￥<?php echo (number_format($item2["oddt_price"],2,'.','')); ?></span><?php endif; ?>
																								</div>
																								<div class="pro_name">提货：
																									<?php echo ($item2["oddt_qty"]); ?>
																										<?php echo ($item2["oddt_prounits"]); ?>
																											<?php echo ($item2["oddt_totalqty"]); ?>　已发：
																												<?php echo ($item2["oddt_shipqty"]); ?>
																								</div>
																							</div>
																							<!-- 																					<?php if(($item["od_state"] == 1) or ($item["od_state"] == 2)): ?><i class="iconfont icon-saomiao all_odsaomian" style="font-size: 2rem;color: #167abe;"></i><?php endif; ?> -->
																						</div>
																					</div>
																					<div class="order-type">
																						<?php if($item2["oddt_color"] != '' ): ?>颜色尺码：
																							<?php echo ($item2["oddt_color"]); ?>
																								<?php echo ($item2["oddt_size"]); endif; ?>
																					</div>
																				</div>
																			</div><?php endforeach; endif; ?>
																		<div class="order-number">
																			<span><?php echo (date('Y-m-d h:i:s',$item["od_addtime"])); ?></span>
																			<span style="color:#000">共<span style="color: red"> <?php echo ($item["odtotalqty"]); ?> </span>件商品，合计：<span style="color:#000">￥<?php echo (number_format($item["od_total"],2,'.','')); ?></span></span>
																		</div>
																		<div class="order-bottom">
																			<div class="order-button-type">
																				<?php if($item["od_state"] == 0): ?><a href="#" class="button button-light button-round order-button" id="m_odcancel" style="color:#ccc;margin-left:.5rem;">取消</a><?php endif; ?>
																				<?php if($item["od_state"] == 3): ?><a href="#" class="button button-warning button-round order-button" id="m_odshouhuo" style="margin-left:.5rem;">收货</a><?php endif; ?>
																				<?php if($item["od_state"] < 3): ?><a href="#" class="button button-warning button-round order-button" id="m_odpingzheng" style="margin-left:.5rem;">凭证</a><?php endif; ?>
																				<a href="#" class="button button-warning button-round order-button" id="m_oddetail">详情</a>
																			</div>
																		</div>
																	</div>
																</li><?php endif; endforeach; endif; ?>
													</ul>
												</div>
											</div>
										</div>
										<div id="tab2_4" class="tab">
											<div class="content-block">
												<div class="list-block media-list" style="margin-top:0rem;">
													<ul>
														<?php if(is_array($list)): foreach($list as $key=>$item): if($item["od_state"] == 3): ?><li>
																	<div class="order-list y_odlist" style="border-bottom:.2rem solid #EFEFF4;">
																		<div class="order-number">
																			<span>订单号：<?php echo ($item["od_orderid"]); ?></span>
																			<span style="color: #f08519"><?php echo ($item["od_state_str"]); ?></span>
																		</div>
																		<?php if(is_array($item['orderdetail'])): foreach($item['orderdetail'] as $key2=>$item2): ?><div class="order-content" style="padding-bottom: 0.5rem">
																				<div class="item-media"><img src="/Public/uploads/mobi/<?php echo ($item2["oddt_propic"]); ?>" style="width:3.5rem;" onerror="this.src='/Public/Kangli/static/logo_icon.png'"></div>
																				<div class="order-inner">
																					<div class="item-subtitle" style="font-size: 0.5rem">
																						<?php echo ($item2["oddt_proname"]); ?>
																					</div>
																					<div class="order-remark">
																						<div class="kl-layout-horizontally-between">
																							<div>
																								<div class="pro_name" style="color: red;">￥<span style="font-size:.75rem"><?php echo (number_format($item2["oddt_dlprice"],2,'.','')); ?></span>
																									<?php if($item2["oddt_price"] > 0): ?><span style="padding-right:.2rem; text-decoration:line-through;color:#c1c1c1">￥<?php echo (number_format($item2["oddt_price"],2,'.','')); ?></span><?php endif; ?>
																								</div>
																								<div class="pro_name">提货：
																									<?php echo ($item2["oddt_qty"]); ?>
																										<?php echo ($item2["oddt_prounits"]); ?>
																											<?php echo ($item2["oddt_totalqty"]); ?>　已发：
																												<?php echo ($item2["oddt_shipqty"]); ?>
																								</div>
																							</div>
																							<!-- 																					<?php if(($item["od_state"] == 1) or ($item["od_state"] == 2)): ?><i class="iconfont icon-saomiao all_odsaomian" style="font-size: 2rem;color: #167abe;"></i><?php endif; ?> -->
																						</div>
																					</div>
																					<div class="order-type">
																						<?php if($item2["oddt_color"] != '' ): ?>颜色尺码：
																							<?php echo ($item2["oddt_color"]); ?>
																								<?php echo ($item2["oddt_size"]); endif; ?>
																					</div>
																				</div>
																			</div><?php endforeach; endif; ?>
																		<div class="order-number">
																			<span><?php echo (date('Y-m-d h:i:s',$item["od_addtime"])); ?></span>
																			<span style="color:#000">共<span style="color: red"> <?php echo ($item["odtotalqty"]); ?> </span>件商品，合计：<span style="color:#000">￥<?php echo (number_format($item["od_total"],2,'.','')); ?></span></span>
																		</div>
																		<div class="order-bottom">
																			<div class="order-button-type">
																				<?php if($item["od_state"] == 0): ?><a href="#" class="button button-light button-round order-button" id="y_odcancel" style="color:#ccc;margin-left:.5rem;">取消</a><?php endif; ?>
																				<?php if($item["od_state"] == 3): ?><a href="#" class="button button-warning button-round order-button" id="y_odshouhuo" style="margin-left:.5rem;">收货</a><?php endif; ?>
																				<?php if($item["od_state"] < 3): ?><a href="#" class="button button-warning button-round order-button" id="y_odpingzheng" style="margin-left:.5rem;">凭证</a><?php endif; ?>
																				<a href="#" class="button button-warning button-round order-button" id="y_oddetail">详情</a>
																			</div>
																		</div>
																	</div>
																</li><?php endif; endforeach; endif; ?>
													</ul>
												</div>
											</div>
										</div>
										<div id="tab2_5" class="tab">
											<div class="content-block">
												<div class="list-block media-list" style="margin-top:0rem;">
													<ul>
														<?php if(is_array($list)): foreach($list as $key=>$item): if($item["od_state"] == 8): ?><li>
																	<div class="order-list f_odlist" style="border-bottom:.2rem solid #EFEFF4;">
																		<div class="order-number">
																			<span>订单号：<?php echo ($item["od_orderid"]); ?></span>
																			<span style="color: #f08519"><?php echo ($item["od_state_str"]); ?></span>
																		</div>
																		<?php if(is_array($item['orderdetail'])): foreach($item['orderdetail'] as $key2=>$item2): ?><div class="order-content" style="padding-bottom: 0.5rem">
																				<div class="item-media"><img src="/Public/uploads/mobi/<?php echo ($item2["oddt_propic"]); ?>" style="width:3.5rem;" onerror="this.src='/Public/Kangli/static/logo_icon.png'"></div>
																				<div class="order-inner">
																					<div class="item-subtitle" style="font-size: 0.5rem">
																						<?php echo ($item2["oddt_proname"]); ?>
																					</div>
																					<div class="order-remark">
																						<div class="kl-layout-horizontally-between">
																							<div>
																								<div class="pro_name" style="color: red;">￥<span style="font-size:.75rem"><?php echo (number_format($item2["oddt_dlprice"],2,'.','')); ?></span>
																									<?php if($item2["oddt_price"] > 0): ?><span style="padding-right:.2rem; text-decoration:line-through;color:#c1c1c1">￥<?php echo (number_format($item2["oddt_price"],2,'.','')); ?></span><?php endif; ?>
																								</div>
																								<div class="pro_name">提货：
																									<?php echo ($item2["oddt_qty"]); ?>
																										<?php echo ($item2["oddt_prounits"]); ?>
																											<?php echo ($item2["oddt_totalqty"]); ?>　已发：
																												<?php echo ($item2["oddt_shipqty"]); ?>
																								</div>
																							</div>
																							<!-- 																					<?php if(($item["od_state"] == 1) or ($item["od_state"] == 2)): ?><i class="iconfont icon-saomiao all_odsaomian" style="font-size: 2rem;color: #167abe;"></i><?php endif; ?> -->
																						</div>
																					</div>
																					<div class="order-type">
																						<?php if($item2["oddt_color"] != '' ): ?>颜色尺码：
																							<?php echo ($item2["oddt_color"]); ?>
																								<?php echo ($item2["oddt_size"]); endif; ?>
																					</div>
																				</div>
																			</div><?php endforeach; endif; ?>
																		<div class="order-number">
																			<span><?php echo (date('Y-m-d h:i:s',$item["od_addtime"])); ?></span>
																			<span style="color:#000">共<span style="color: red"> <?php echo ($item["odtotalqty"]); ?> </span>件商品，合计：<span style="color:#000">￥<?php echo (number_format($item["od_total"],2,'.','')); ?></span></span>
																		</div>
																		<div class="order-bottom">
																			<div class="order-button-type">
																				<?php if($item["od_state"] == 0): ?><a href="#" class="button button-light button-round order-button" id="f_odcancel" style="color:#ccc;margin-left:.5rem;">取消</a><?php endif; ?>
																				<?php if($item["od_state"] == 3): ?><a href="#" class="button button-warning button-round order-button" id="f_odshouhuo" style="margin-left:.5rem;">收货</a><?php endif; ?>
																				<?php if($item["od_state"] < 3): ?><a href="#" class="button button-warning button-round order-button" id="f_odpingzheng" style="margin-left:.5rem;">凭证</a><?php endif; ?>
																				<a href="#" class="button button-warning button-round order-button" id="f_oddetail">详情</a>
																			</div>
																		</div>
																	</div>
																</li><?php endif; endforeach; endif; ?>
													</ul>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="kl-page" style="margin:.5rem">
									<?php if($page != ''): echo ($page); endif; ?>
								</div>
							</div>
						</div>
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
					// $("#dl_tuijian").click();
					var ly_status = "<?php echo ($ly_status); ?>";
					if(ly_status == 1)
						$("#my_order").click();

					var my_status = "<?php echo ($my_status); ?>";
					switch(parseInt(my_status)) {
						case 0:
							$("#my_sure").click();
							break;
						case 1:
							$("#my_send").click();
							break;
						case 2:
							$("#my_send").click();
							break;
						case 3:
							$("#my_sended").click();
							break;
						case 8:
							$("#my_finish").click();
							break;
						default:
							$("#my_all").click();
							break;
					}

					$(".item-content.item-link").each(function(index) {
						// console.log('input %d is:%o',index,this);
						var dlsodcount = "<?php echo ($dlsodcount); ?>";
						var dlmodcount = "<?php echo ($dlmodcount); ?>";
						var dlfodcount = "<?php echo ($dlfodcount); ?>";
						var dlcodcount = "<?php echo ($dlcodcount); ?>";
						$(this).click(function() {
							switch(index) {
								case 0:
									if(!isNaN(parseInt(dlsodcount)) && parseInt(dlsodcount) != 0) {
										window.location.href = "<?php echo U('./Kangli/Orders/dlorders/od_state/0');?>";
									}
									break;
								case 1:
									if(!isNaN(parseInt(dlmodcount)) && parseInt(dlmodcount) != 0) {
										window.location.href = "<?php echo U('./Kangli/Orders/dlorders/od_state/1');?>";
									}
									break;
								case 2:
									// if(!isNaN(parseInt(dlmodcount)) && parseInt(dlmodcount) != 0) {
										window.location.href = "<?php echo U('./Kangli/Orders/dlorders/od_state/3');?>";
									// }
									break;
								case 3:
									if(!isNaN(parseInt(dlcodcount)) && parseInt(dlcodcount) != 0) {
										$.toast("已取消订单");
										// window.location.href="<?php echo U('./Kangli/Orders/dladdress/');?>";
									}
									break;
								case 4:
									// if(!isNaN(parseInt(dlycodcount)) && parseInt(dlycodcount) != 0) {
										// $.toast("预充订单");
										window.location.href="<?php echo U('./Kangli/Orders/dlycorders/');?>";
									// }
									break;
								default:

									break;

							}
						});
					});

			var odArray = <?php echo json_encode($list);?>;
			var odsArray=[];
			var odmArray=[];
			var odyArray=[];
			var odfArray=[];
			if($.isArray(odArray)&&odArray.length>0){
				odArray.forEach(function(val,index) {
					var odObject=odArray[index];
					if (!isNaN(parseInt(odObject['od_state'])) && parseInt(odObject['od_state']) ==0)
						odsArray.push(odObject);
					if (!isNaN(parseInt(odObject['od_state'])) && (parseInt(odObject['od_state']) ==1 || parseInt(odObject['od_state']) ==2))
						odmArray.push(odObject);
					if (!isNaN(parseInt(odObject['od_state'])) && parseInt(odObject['od_state']) ==3)
						odyArray.push(odObject);
					if (!isNaN(parseInt(odObject['od_state'])) && parseInt(odObject['od_state']) ==8)
						odfArray.push(odObject);
				});
			}

			$('.order-list.all_odlist').each(function(index) {
				// console.log('li %d is:%o',index,this);
				if ($.isArray(odArray)&&odArray.length>index)
				{
					var odObject=odArray[index];
					$(this).find("#all_oddetail").click(function(){
						if($.isPlainObject(odObject))
						{
							window.location.href="<?php echo U('./Kangli/Orders/orderdetail/od_id');?>/"+odObject['od_id']+"/ly_status/1";
						}
					});
					$(this).find("#all_odpingzheng").click(function(){
						if($.isPlainObject(odObject))
						{
							window.location.href="<?php echo U('./Kangli/Orders/uploadpaypic/od_id');?>/"+odObject['od_id']+"/ly_status/1";
						}
					});
					$(this).find("#all_odcancel").click(function(){
						if ($.isPlainObject(odObject))
						{
							 $.confirm('是否确定取消该订单?',function () {
							 	// $.toast("取消");
				               window.location.href="<?php echo U('./Kangli/Orders/canceldlorder/od_id');?>/"+odObject['od_id']+"/state/9/od_state/10/ly_status/1";
				            });
						}
					});
					$(this).find("#all_odshouhuo").click(function(){
						if ($.isPlainObject(odObject))
						{
							 $.confirm('是否确定收货?',function () {
							 	// $.toast("取消");
				               window.location.href="<?php echo U('./Kangli/Orders/confirmreceipt/od_id');?>/"+odObject['od_id']+"/od_state/10/ly_status/1";
				            });
						}
					});
					$(this).find(".all_odsaomian").each(function(pos,eml){
						// console.log('li %d is:%o',index,eml);
						var oddtObject=odObject['orderdetail'][pos];
						$(eml).click(function(){
							$.toast("扫描"+oddtObject['oddt_id']);
							// if ($.isPlainObject(odObject))
							// {
							// 	window.location.href="<?php echo U('./Kangli/Orders/checkcart/sc_id');?>/"+odObject['sc_id'];
							// }
						});
					});
				}
			});

			
			$('.order-list.s_odlist').each(function(index) {
				// console.log('li %d is:%o',index,this);
				if ($.isArray(odsArray)&&odsArray.length>index)
				{
					var odObject=odsArray[index];
					$(this).find("#s_oddetail").click(function(){
						if($.isPlainObject(odObject))
						{
							window.location.href="<?php echo U('./Kangli/Orders/orderdetail/od_id');?>/"+odObject['od_id']+"/od_state/0/ly_status/1";
						}
					});
					$(this).find("#s_odpingzheng").click(function(){
						if($.isPlainObject(odObject))
						{
							window.location.href="<?php echo U('./Kangli/Orders/uploadpaypic/od_id');?>/"+odObject['od_id']+"/od_state/0/ly_status/1";
						}
					});
					$(this).find("#s_odcancel").click(function(){
						if ($.isPlainObject(odObject))
						{
							 $.confirm('是否确定取消该订单?',function () {
							 	// $.toast("取消");
				               window.location.href="<?php echo U('./Kangli/Orders/canceldlorder/od_id');?>/"+odObject['od_id']+"/state/9/od_state/0/ly_status/1";
				            });
						}
					});
					$(this).find("#s_odshouhuo").click(function(){
						if ($.isPlainObject(odObject))
						{
							 $.confirm('是否确定收货?',function () {
							 	// $.toast("取消");
				               window.location.href="<?php echo U('./Kangli/Orders/confirmreceipt/od_id');?>/"+odObject['od_id']+"/od_state/0/ly_status/1";
				            });
						}
					});
					$(this).find(".s_odsaomian").each(function(pos,eml){
						// console.log('li %d is:%o',index,eml);
						var oddtObject=odObject['orderdetail'][pos];
						$(eml).click(function(){
							$.toast("扫描"+oddtObject['oddt_id']);
							// if ($.isPlainObject(odObject))
							// {
							// 	window.location.href="<?php echo U('./Kangli/Orders/checkcart/sc_id');?>/"+odObject['sc_id'];
							// }
						});
					});
				}
			});

			$('.order-list.m_odlist').each(function(index) {
				// console.log('li %d is:%o',index,this);
				if ($.isArray(odmArray)&&odmArray.length>index)
				{
					var odObject=odmArray[index];
					$(this).find("#m_oddetail").click(function(){
						if($.isPlainObject(odObject))
						{
							window.location.href="<?php echo U('./Kangli/Orders/orderdetail/od_id');?>/"+odObject['od_id']+"/od_state/1/ly_status/1";
						}
					});
					$(this).find("#m_odpingzheng").click(function(){
						if($.isPlainObject(odObject))
						{
							window.location.href="<?php echo U('./Kangli/Orders/uploadpaypic/od_id');?>/"+odObject['od_id']+"/od_state/1/ly_status/1";
						}
					});
					$(this).find("#m_odcancel").click(function(){
						if ($.isPlainObject(odObject))
						{
							 $.confirm('是否确定取消该订单?',function () {
							 	// $.toast("取消");
				               window.location.href="<?php echo U('./Kangli/Orders/canceldlorder/od_id');?>/"+odObject['od_id']+"/state/9/od_state/1/ly_status/1";
				            });
						}
					});
					$(this).find("#m_odshouhuo").click(function(){
						if ($.isPlainObject(odObject))
						{
							 $.confirm('是否确定收货?',function () {
							 	// $.toast("取消");
				               window.location.href="<?php echo U('./Kangli/Orders/confirmreceipt/od_id');?>/"+odObject['od_id']+"/od_state/1/ly_status/1";
				            });
						}
					});
					$(this).find(".m_odsaomian").each(function(pos,eml){
						// console.log('li %d is:%o',index,eml);
						var oddtObject=odObject['orderdetail'][pos];
						$(eml).click(function(){
							$.toast("扫描"+oddtObject['oddt_id']);
							// if ($.isPlainObject(odObject))
							// {
							// 	window.location.href="<?php echo U('./Kangli/Orders/checkcart/sc_id');?>/"+odObject['sc_id'];
							// }
						});
					});
				}
			});

			$('.order-list.y_odlist').each(function(index) {
				// console.log('li %d is:%o',index,this);
				if ($.isArray(odyArray)&&odyArray.length>index)
				{
					var odObject=odyArray[index];
					$(this).find("#y_oddetail").click(function(){
						if($.isPlainObject(odObject))
						{
							window.location.href="<?php echo U('./Kangli/Orders/orderdetail/od_id');?>/"+odObject['od_id']+"/od_state/3/ly_status/1";
						}
					});
					$(this).find("#y_odpingzheng").click(function(){
						if($.isPlainObject(odObject))
						{
							window.location.href="<?php echo U('./Kangli/Orders/uploadpaypic/od_id');?>/"+odObject['od_id']+"/od_state/3/ly_status/1";
						}
					});
					$(this).find("#y_odcancel").click(function(){
						if ($.isPlainObject(odObject))
						{
							 $.confirm('是否确定取消该订单?',function () {
							 	// $.toast("取消");
				               window.location.href="<?php echo U('./Kangli/Orders/canceldlorder/od_id');?>/"+odObject['od_id']+"/od_state/3/state/9/od_state/10/ly_status/1";
				            });
						}
					});
					$(this).find("#y_odshouhuo").click(function(){
						if ($.isPlainObject(odObject))
						{
							 $.confirm('是否确定收货?',function () {
							 	// $.toast("取消");
				               window.location.href="<?php echo U('./Kangli/Orders/confirmreceipt/od_id');?>/"+odObject['od_id']+"/od_state/3/ly_status/1";
				            });
						}
					});
					$(this).find(".y_odsaomian").each(function(pos,eml){
						// console.log('li %d is:%o',index,eml);
						var oddtObject=odObject['orderdetail'][pos];
						$(eml).click(function(){
							$.toast("扫描"+oddtObject['oddt_id']);
							// if ($.isPlainObject(odObject))
							// {
							// 	window.location.href="<?php echo U('./Kangli/Orders/checkcart/sc_id');?>/"+odObject['sc_id'];
							// }
						});
					});
				}
			});

			$('.order-list.f_odlist').each(function(index) {
				// console.log('li %d is:%o',index,this);
				if ($.isArray(odfArray)&&odfArray.length>index)
				{
					var odObject=odfArray[index];
					$(this).find("#f_oddetail").click(function(){
						if($.isPlainObject(odObject))
						{
							window.location.href="<?php echo U('./Kangli/Orders/orderdetail/od_id');?>/"+odObject['od_id']+"/od_state/8/ly_status/1";
						}
					});
					$(this).find("#f_odpingzheng").click(function(){
						if($.isPlainObject(odObject))
						{
							window.location.href="<?php echo U('./Kangli/Orders/uploadpaypic/od_id');?>/"+odObject['od_id']+"/od_state/8/ly_status/1";
						}
					});
					$(this).find("#f_odcancel").click(function(){
						if ($.isPlainObject(odObject))
						{
							 $.confirm('是否确定取消该订单?',function () {
							 	// $.toast("取消");
				               window.location.href="<?php echo U('./Kangli/Orders/canceldlorder/od_id');?>/"+odObject['od_id']+"/od_state/8/state/9/od_state/10/ly_status/1";
				            });
						}
					});
					$(this).find("#f_odshouhuo").click(function(){
						if ($.isPlainObject(odObject))
						{
							 $.confirm('是否确定收货?',function () {
							 	// $.toast("取消");
				               window.location.href="<?php echo U('./Kangli/Orders/confirmreceipt/od_id');?>/"+odObject['od_id']+"/od_state/8/ly_status/1";
				            });
						}
					});
					$(this).find(".f_odsaomian").each(function(pos,eml){
						// console.log('li %d is:%o',index,eml);
						var oddtObject=odObject['orderdetail'][pos];
						$(eml).click(function(){
							$.toast("扫描"+oddtObject['oddt_id']);
							// if ($.isPlainObject(odObject))
							// {
							// 	window.location.href="<?php echo U('./Kangli/Orders/checkcart/sc_id');?>/"+odObject['sc_id'];
							// }
						});
					});
				}
			});

			$('#fw_search').click(function()
			{
				window.location.href= "<?php echo U('./Kangli/Query');?>";
			});
			
		});
	</script>

</html>