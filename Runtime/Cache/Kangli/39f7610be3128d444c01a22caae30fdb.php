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
			<?php echo (C("QY_COMPANY")); ?>-出货订单</title>
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
				font-size: .1rem;
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

	<body ontouchstart="" style="background-color:#FAFAFA">
		<div class="page">
			<header class="bar bar-nav" style="background-color:#006db2;">
				<!-- <a href="javascript:;" onClick="javascript :history.back(-1);" class="icon icon-left pull-left" style="color:#fff"></a> -->
				<?php if($back == 1): ?><a href="<?php echo U('./Kangli/Mine');?>" class="icon icon-left pull-left" style="color:#fff"></a>
				<?php else: ?>
					<?php if($back == 2): ?><a href="<?php echo U('./Kangli/Index');?>" class="icon icon-left pull-left" style="color:#fff"></a>
					<?php else: ?>
						<a href="<?php echo U('./Kangli/Orders');?>" class="icon icon-left pull-left" style="color:#fff"></a><?php endif; endif; ?>
				<h1 class="title" style="color:#fff">出货订单</h1>
			</header>
			<div class="content">
				<!-- searchbar -->
				<div class="searchbar" style="margin:0 0.5rem;">
					<a class="searchbar-cancel">搜索</a>
					<div class="search-input">
						<label class="icon icon-search" for="search"></label>
						<input type="search" id='search' placeholder='输入订单号、代理商微信号或手机号查询' />
					</div>
				</div>
				<div class="content-block" style="min-height: 10rem; margin:0;">
					<div class="buttons-tab">
						<a href="#tab2_1" id="od_all" class="tab-link active button">全部</a>
						<a href="#tab2_2" id="od_sure" class="tab-link button">待确认
							<?php if($dlsodcount > 0): ?><span class="order-circle order-number-thumbnail" style="position: absolute;top:10%;right:10%; color: red"><?php echo ($dlsodcount); ?></span><?php endif; ?>
						</a>
						<a href="#tab2_3" id="od_send" class="tab-link button">待发货
							<?php if($dlmodcount > 0): ?><span class="order-circle order-number-thumbnail" style="position: absolute;top:10%;right:10%; color: red"><?php echo ($dlmodcount); ?></span><?php endif; ?>
						</a>
						<a href="#tab2_4" id="od_sended" class="tab-link button">已发货</a>
						<a href="#tab2_5" id="od_finish" class="tab-link button">已完成</a>
					</div>
					<div class="content-block">
						<div class="tabs" style="background: #FFF">
							<div id="tab2_1" class="tab active">
								<div class="content-block">
									<div class="list-block media-list" style="margin-top:0rem;">
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
																				<div class="pro_name">订购：
																					<?php echo ($item2["oddt_qty"]); ?>
																						<?php echo ($item2["oddt_prounits"]); ?>
																							<?php echo ($item2["oddt_totalqty"]); ?>　已发：
																								<?php echo ($item2["oddt_shipqty"]); ?>
																									<?php if($item2["oddt_shipqty"] > 0): ?><i class="iconfont icon-shenqing all_recode_icon" style="font-size:1rem; color: #7e7e7e;margin-left:0.25rem"></i><?php endif; ?>
																				</div>
																			</div>
																			<?php if(($item["od_state"] == 1 or $item["od_state"] == 2) and $item["od_shipall"] != 1): ?><i class="iconfont icon-saomiao all_odsaomian" style="font-size: 2rem;color: #167abe;"></i><?php endif; ?>
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
																<?php if($item["od_state"] < 2): ?><a href="#" class="button button-light button-round order-button" id="all_odcancel" style="color:#ccc;margin-left:.5rem;">取消</a><?php endif; ?>
																<?php if($item["od_state"] == 0): ?><a href="#" class="button button-warning button-round order-button" id="all_odqueren" style="margin-left:.5rem;">确认</a><?php endif; ?>
																<?php if(($item["od_state"] > 0) and ($item["od_state"] < 3)): ?><a href="#" class="button button-warning button-round order-button" id="all_odfinish" style="margin-left:.5rem;">完成发货</a><?php endif; ?>
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
																					<div class="pro_name">订购：
																						<?php echo ($item2["oddt_qty"]); ?>
																							<?php echo ($item2["oddt_prounits"]); ?>
																								<?php echo ($item2["oddt_totalqty"]); ?>　已发：
																									<?php echo ($item2["oddt_shipqty"]); ?>
																										<?php if($item2["oddt_shipqty"] > 0): ?><i class="iconfont icon-shenqing s_recode_icon" style="font-size:1rem; color: #7e7e7e;margin-left:0.25rem"></i><?php endif; ?>
																					</div>
																				</div>
																				<?php if(($item["od_state"] == 1 or $item["od_state"] == 2) and $item["od_shipall"] != 1): ?><i class="iconfont icon-saomiao s_odsaomian" style="font-size: 2rem;color: #167abe;"></i><?php endif; ?>
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
																	<?php if($item["od_state"] < 2): ?><a href="#" class="button button-light button-round order-button" id="s_odcancel" style="color:#ccc;margin-left:.5rem;">取消</a><?php endif; ?>
																	<?php if($item["od_state"] == 0): ?><a href="#" class="button button-warning button-round order-button" id="s_odqueren" style="margin-left:.5rem;">确认</a><?php endif; ?>
																	<?php if(($item["od_state"] > 0) and ($item["od_state"] < 3)): ?><a href="#" class="button button-warning button-round order-button" id="s_odfinish" style="margin-left:.5rem;">完成发货</a><?php endif; ?>
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
									<div class="list-block media-list" style="margin-top:0rem; ">
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
																					<div class="pro_name">订购：
																						<?php echo ($item2["oddt_qty"]); ?>
																							<?php echo ($item2["oddt_prounits"]); ?>
																								<?php echo ($item2["oddt_totalqty"]); ?>　已发：
																									<?php echo ($item2["oddt_shipqty"]); ?>
																										<?php if($item2["oddt_shipqty"] > 0): ?><i class="iconfont icon-shenqing m_recode_icon" style="font-size:1rem; color: #7e7e7e;margin-left:0.25rem"></i><?php endif; ?>
																					</div>
																				</div>
																				<?php if(($item["od_state"] == 1 or $item["od_state"] == 2) and $item["od_shipall"] != 1): ?><i class="iconfont icon-saomiao m_odsaomian" style="font-size: 2rem;color: #167abe;"></i><?php endif; ?>
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
																	<?php if($item["od_state"] < 2): ?><a href="#" class="button button-light button-round order-button" id="m_odcancel" style="color:#ccc;margin-left:.5rem;">取消</a><?php endif; ?>
																	<?php if($item["od_state"] == 0): ?><a href="#" class="button button-warning button-round order-button" id="m_odqueren" style="margin-left:.5rem;">确认</a><?php endif; ?>
																	<?php if(($item["od_state"] > 0) and ($item["od_state"] < 3)): ?><a href="#" class="button button-warning button-round order-button" id="m_odfinish" style="margin-left:.5rem;">完成发货</a><?php endif; ?>
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
																					<div class="pro_name">订购：
																						<?php echo ($item2["oddt_qty"]); ?>
																							<?php echo ($item2["oddt_prounits"]); ?>
																								<?php echo ($item2["oddt_totalqty"]); ?>　已发：
																									<?php echo ($item2["oddt_shipqty"]); ?>
																										<?php if($item2["oddt_shipqty"] > 0): ?><i class="iconfont icon-shenqing y_recode_icon" style="font-size:1rem; color: #7e7e7e;margin-left:0.25rem"></i><?php endif; ?>
																					</div>
																				</div>
																				<?php if(($item["od_state"] == 1 or $item["od_state"] == 2) and $item["od_shipall"] != 1): ?><i class="iconfont icon-saomiao y_odsaomian" style="font-size: 2rem;color: #167abe;"></i><?php endif; ?>
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
																	<?php if($item["od_state"] < 2): ?><a href="#" class="button button-light button-round order-button" id="y_odcancel" style="color:#ccc;margin-left:.5rem;">取消</a><?php endif; ?>
																	<?php if($item["od_state"] == 0): ?><a href="#" class="button button-warning button-round order-button" id="y_odqueren" style="margin-left:.5rem;">确认</a><?php endif; ?>
																	<?php if(($item["od_state"] > 0) and ($item["od_state"] < 3)): ?><a href="#" class="button button-warning button-round order-button" id="y_odfinish" style="margin-left:.5rem;">完成发货</a><?php endif; ?>
																	<a href="#" class="button button-warning button-round order-button" id="y_oddetail">详情</a>
																</div>
															</div>
														</div>
													</li><?php endif; endforeach; endif; ?>
								</div>
							</div>
							<div id="tab2_5" class="tab">
								<div class="content-block">
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
																			<div class="pro_name">订购：
																				<?php echo ($item2["oddt_qty"]); ?>
																					<?php echo ($item2["oddt_prounits"]); ?>
																						<?php echo ($item2["oddt_totalqty"]); ?>　已发：
																							<?php echo ($item2["oddt_shipqty"]); ?>
																								<?php if($item2["oddt_shipqty"] > 0): ?><i class="iconfont icon-shenqing f_recode_icon" style="font-size:1rem; color: #7e7e7e;margin-left:0.25rem"></i><?php endif; ?>
																			</div>
																		</div>
																		<?php if(($item["od_state"] == 1 or $item["od_state"] == 2) and $item["od_shipall"] != 1): ?><i class="iconfont icon-saomiao f_odsaomian" style="font-size: 2rem;color: #167abe;"></i><?php endif; ?>
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
															<?php if($item["od_state"] < 2): ?><a href="#" class="button button-light button-round order-button" id="f_odcancel" style="color:#ccc;margin-left:.5rem;">取消</a><?php endif; ?>
															<?php if($item["od_state"] == 0): ?><a href="#" class="button button-warning button-round order-button" id="f_odqueren" style="margin-left:.5rem;">确认</a><?php endif; ?>
															<?php if(($item["od_state"] > 0) and ($item["od_state"] < 3)): ?><a href="#" class="button button-warning button-round order-button" id="f_odfinish" style="margin-left:.5rem;">完成发货</a><?php endif; ?>
															<a href="#" class="button button-warning button-round order-button" id="f_oddetail">详情</a>
														</div>
													</div>
												</div>
											</li><?php endif; endforeach; endif; ?>
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
					var od_status = "<?php echo ($od_state); ?>" || 0;
					// $.toast(od_status);
					switch(parseInt(od_status)) {
						case 0:
							$("#od_sure").click();
							break;
						case 1:
							$("#od_send").click();
							break;
						case 2:
							$("#od_send").click();
							break;
						case 3:
							$("#od_sended").click();
							break;
						case 8:
							$("#od_finish").click();
							break;
						default:
							$("#od_all").click();
							break;
					}
			var odArray = <?php echo json_encode($list);?>||[];
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
							window.location.href="<?php echo U('./Kangli/Orders/dlorderdetail/od_id');?>/"+odObject['od_id']+"/odoneself/"+odObject['odoneself'];
						}
					});
					$(this).find("#all_odqueren").click(function(){
						if ($.isPlainObject(odObject))
						{
							window.location.href="<?php echo U('./Kangli/Orders/canceldlorder/od_id');?>/"+odObject['od_id']+"/state/1/od_state/10";
						}
					});
					$(this).find("#all_odcancel").click(function(){
						if ($.isPlainObject(odObject))
						{
							 $.confirm('是否确定取消该订单吗?',function () {
							 	// $.toast("取消");
				               window.location.href="<?php echo U('./Kangli/Orders/canceldlorder/od_id');?>/"+odObject['od_id']+"/state/9/od_state/10";
				            });
						}
					});
					$(this).find(".all_odsaomian").each(function(pos,eml){
						// console.log('li %d is:%o',index,eml);
						var oddtObject=odObject['orderdetail'][pos];
						$(eml).click(function(){
							// $.toast("扫描"+oddtObject['oddt_id']);
							if ($.isPlainObject(odObject))
							{
								window.location.href="<?php echo U('./Kangli/Orders/odshipscan/od_id');?>/"+odObject['od_id']+"/oddt_id/"+oddtObject['oddt_id'];
							}
						});
					});
					$(this).find(".all_recode_icon").each(function(pos,eml){
						// console.log('li %d is:%o',index,eml);
						var oddtObject=odObject['orderdetail'][pos];
						$(eml).click(function(){
							// $.toast("扫描"+oddtObject['oddt_id']);
							if ($.isPlainObject(odObject))
							{
								window.location.href="<?php echo U('./Kangli/Orders/odshiplist/od_id');?>/"+odObject['od_id']+"/oddt_id/"+oddtObject['oddt_id'];
							}
						});
					});

					$(this).find("#all_odfinish").click(function(){
						if ($.isPlainObject(odObject))
						{
								window.location.href="<?php echo U('./Kangli/Orders/odfinishship/od_id');?>/"+odObject['od_id'];
							// window.location.href="<?php echo U('./Kangli/Orders/canceldlorder/od_id');?>/"+odObject['od_id']+"/state/1/od_state/10";
						}
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
							window.location.href="<?php echo U('./Kangli/Orders/dlorderdetail/od_id');?>/"+odObject['od_id']+"/odoneself/"+odObject['odoneself'];
						}
					});
					$(this).find("#s_odqueren").click(function(){
						if ($.isPlainObject(odObject))
						{
							window.location.href="<?php echo U('./Kangli/Orders/canceldlorder/od_id');?>/"+odObject['od_id']+"/state/1/od_state/10";
						}
					});
					$(this).find("#s_odcancel").click(function(){
						if ($.isPlainObject(odObject))
						{
							 $.confirm('是否确定取消该订单吗?',function () {
							 	// $.toast("取消");
				               window.location.href="<?php echo U('./Kangli/Orders/canceldlorder/od_id');?>/"+odObject['od_id']+"/state/9/od_state/10";
				            });
						}
					});
					$(this).find(".s_odsaomian").each(function(pos,eml){
						// console.log('li %d is:%o',index,eml);
						var oddtObject=odObject['orderdetail'][pos];
						$(eml).click(function(){
							// $.toast("扫描"+oddtObject['oddt_id']);
							if ($.isPlainObject(odObject))
							{
								window.location.href="<?php echo U('./Kangli/Orders/odshipscan/od_id');?>/"+odObject['od_id']+"/oddt_id/"+oddtObject['oddt_id'];
							}
						});
					});
					$(this).find(".s_recode_icon").each(function(pos,eml){
						// console.log('li %d is:%o',index,eml);
						var oddtObject=odObject['orderdetail'][pos];
						$(eml).click(function(){
							// $.toast("扫描"+oddtObject['oddt_id']);
							if ($.isPlainObject(odObject))
							{
								window.location.href="<?php echo U('./Kangli/Orders/odshiplist/od_id');?>/"+odObject['od_id']+"/oddt_id/"+oddtObject['oddt_id'];
							}
						});
					});

					$(this).find("#s_odfinish").click(function(){
						if ($.isPlainObject(odObject))
						{
								window.location.href="<?php echo U('./Kangli/Orders/odfinishship/od_id');?>/"+odObject['od_id'];
							// window.location.href="<?php echo U('./Kangli/Orders/canceldlorder/od_id');?>/"+odObject['od_id']+"/state/1/od_state/10";
						}
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
							window.location.href="<?php echo U('./Kangli/Orders/dlorderdetail/od_id');?>/"+odObject['od_id']+"/odoneself/"+odObject['odoneself'];
						}
					});
					$(this).find("#m_odqueren").click(function(){
						if ($.isPlainObject(odObject))
						{
							window.location.href="<?php echo U('./Kangli/Orders/canceldlorder/od_id');?>/"+odObject['od_id']+"/state/1/od_state/10";
						}
					});
					$(this).find("#m_odcancel").click(function(){
						if ($.isPlainObject(odObject))
						{
							 $.confirm('是否确定取消该订单吗?',function () {
							 	// $.toast("取消");
				               window.location.href="<?php echo U('./Kangli/Orders/canceldlorder/od_id');?>/"+odObject['od_id']+"/state/9/od_state/10";
				            });
						}
					});
					$(this).find(".m_odsaomian").each(function(pos,eml){
						// console.log('li %d is:%o',index,eml);
						var oddtObject=odObject['orderdetail'][pos];
						$(eml).click(function(){
							// $.toast("扫描"+oddtObject['oddt_id']);
							if ($.isPlainObject(odObject))
							{
								window.location.href="<?php echo U('./Kangli/Orders/odshipscan/od_id');?>/"+odObject['od_id']+"/oddt_id/"+oddtObject['oddt_id'];
							}
						});
					});
					$(this).find(".m_recode_icon").each(function(pos,eml){
						// console.log('li %d is:%o',index,eml);
						var oddtObject=odObject['orderdetail'][pos];
						$(eml).click(function(){
							// $.toast("扫描"+oddtObject['oddt_id']);
							if ($.isPlainObject(odObject))
							{
								window.location.href="<?php echo U('./Kangli/Orders/odshiplist/od_id');?>/"+odObject['od_id']+"/oddt_id/"+oddtObject['oddt_id'];
							}
						});
					});

					$(this).find("#m_odfinish").click(function(){
						if ($.isPlainObject(odObject))
						{
								window.location.href="<?php echo U('./Kangli/Orders/odfinishship/od_id');?>/"+odObject['od_id'];
							// window.location.href="<?php echo U('./Kangli/Orders/canceldlorder/od_id');?>/"+odObject['od_id']+"/state/1/od_state/10";
						}
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
							window.location.href="<?php echo U('./Kangli/Orders/dlorderdetail/od_id');?>/"+odObject['od_id']+"/odoneself/"+odObject['odoneself'];
						}
					});
					$(this).find("#y_odqueren").click(function(){
						if ($.isPlainObject(odObject))
						{
							window.location.href="<?php echo U('./Kangli/Orders/canceldlorder/od_id');?>/"+odObject['od_id']+"/state/1/od_state/10";
						}
					});
					$(this).find("#y_odcancel").click(function(){
						if ($.isPlainObject(odObject))
						{
							 $.confirm('是否确定取消该订单吗?',function () {
							 	// $.toast("取消");
				               window.location.href="<?php echo U('./Kangli/Orders/canceldlorder/od_id');?>/"+odObject['od_id']+"/state/9/od_state/10";
				            });
						}
					});
					$(this).find(".y_odsaomian").each(function(pos,eml){
						// console.log('li %d is:%o',index,eml);
						var oddtObject=odObject['orderdetail'][pos];
						$(eml).click(function(){
							// $.toast("扫描"+oddtObject['oddt_id']);
							if ($.isPlainObject(odObject))
							{
								window.location.href="<?php echo U('./Kangli/Orders/odshipscan/od_id');?>/"+odObject['od_id']+"/oddt_id/"+oddtObject['oddt_id'];
							}
						});
					});
					$(this).find(".y_recode_icon").each(function(pos,eml){
						// console.log('li %d is:%o',index,eml);
						var oddtObject=odObject['orderdetail'][pos];
						$(eml).click(function(){
							// $.toast("扫描"+oddtObject['oddt_id']);
							if ($.isPlainObject(odObject))
							{
								window.location.href="<?php echo U('./Kangli/Orders/odshiplist/od_id');?>/"+odObject['od_id']+"/oddt_id/"+oddtObject['oddt_id'];
							}
						});
					});

					$(this).find("#y_odfinish").click(function(){
						if ($.isPlainObject(odObject))
						{
								window.location.href="<?php echo U('./Kangli/Orders/odfinishship/od_id');?>/"+odObject['od_id'];
							// window.location.href="<?php echo U('./Kangli/Orders/canceldlorder/od_id');?>/"+odObject['od_id']+"/state/1/od_state/10";
						}
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
							window.location.href="<?php echo U('./Kangli/Orders/dlorderdetail/od_id');?>/"+odObject['od_id']+"/odoneself/"+odObject['odoneself'];
						}
					});
					$(this).find("#f_odqueren").click(function(){
						if ($.isPlainObject(odObject))
						{
							window.location.href="<?php echo U('./Kangli/Orders/canceldlorder/od_id');?>/"+odObject['od_id']+"/state/1/od_state/10";
						}
					});
					$(this).find("#f_odcancel").click(function(){
						if ($.isPlainObject(odObject))
						{
							 $.confirm('是否确定取消该订单吗?',function () {
							 	// $.toast("取消");
				               window.location.href="<?php echo U('./Kangli/Orders/canceldlorder/od_id');?>/"+odObject['od_id']+"/state/9/od_state/10";
				            });
						}
					});
					$(this).find(".f_odsaomian").each(function(pos,eml){
						// console.log('li %d is:%o',index,eml);
						var oddtObject=odObject['orderdetail'][pos];
						$(eml).click(function(){
							// $.toast("扫描"+oddtObject['oddt_id']);
							if ($.isPlainObject(odObject))
							{
								window.location.href="<?php echo U('./Kangli/Orders/odshipscan/od_id');?>/"+odObject['od_id']+"/oddt_id/"+oddtObject['oddt_id'];
							}
						});
					});
					$(this).find(".f_recode_icon").each(function(pos,eml){
						// console.log('li %d is:%o',index,eml);
						var oddtObject=odObject['orderdetail'][pos];
						$(eml).click(function(){
							// $.toast("扫描"+oddtObject['oddt_id']);
							if ($.isPlainObject(odObject))
							{
								window.location.href="<?php echo U('./Kangli/Orders/odshiplist/od_id');?>/"+odObject['od_id']+"/oddt_id/"+oddtObject['oddt_id'];
							}
						});
					});

					$(this).find("#f_odfinish").click(function(){
						if ($.isPlainObject(odObject))
						{
								window.location.href="<?php echo U('./Kangli/Orders/odfinishship/od_id');?>/"+odObject['od_id'];
							// window.location.href="<?php echo U('./Kangli/Orders/canceldlorder/od_id');?>/"+odObject['od_id']+"/state/1/od_state/10";
						}
					});
				}
			});

		$('.searchbar-cancel').click(function() {
				var keyword=$("#search").val();
				if (!isEmpty(keyword))
				{
					window.location.href="<?php echo U('./Kangli/Orders/dlorderssearch/keyword');?>/"+keyword;
				}
			});

		 //回车提交事件
     	$("body").keydown(function() {
         	if (event.keyCode == "13") {//keyCode=13是回车键
             	$('.searchbar-cancel').click();
        	 }
    	 });
	});
	</script>

</html>