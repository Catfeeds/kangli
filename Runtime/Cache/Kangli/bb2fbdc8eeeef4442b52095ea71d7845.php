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
			<?php echo (C("QY_COMPANY")); ?>-出货记录</title>
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
			
			div.panel,
			p.flip {
				margin: 0px;
				padding: 5px;
				text-align: center;
				background: #e5eecc;
				border: solid 1px #c3c3c3;
			}
			
			div.panel {
				height: 220px;
				display: none;
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
				<?php if($isdetail == 1): ?><a href="<?php echo U('./Kangli/Orders/dlorderdetail/od_id');?>/<?php echo ($od_id); ?>" class="icon icon-left pull-left" style="color:#fff"></a>
				<?php else: ?>
					<a href="<?php echo U('./Kangli/Orders/dlorders/');?>" class="icon icon-left pull-left" style="color:#fff"></a><?php endif; ?>
				<h1 class="title" style="color:#fff">出货记录</h1>
        </button>
			</header>
			<div class="content">
				<div class="order-number" style="padding:.5rem;font-size: 1rem;color:#fff;background:#75787f">
					<span>订单号：<?php echo ($ordersinfo["oddt_orderid"]); ?></span>
					<span style="color: #f08519"><?php echo ($item["od_state_str"]); ?></span>
				</div>
				<div class="list-block media-list" style="margin-top:0rem;margin-bottom:0rem;">
					<ul>
						<li>
							<div class="order-list all_odlist" style="border-bottom:.2rem solid #EFEFF4;">
								<div class="order-content" style="padding-bottom: 0.5rem">
									<div class="item-media"><img src="/Kangli/Public/uploads/mobi/<?php echo ($item2["oddt_propic"]); ?>" style="width:3.5rem;" onerror="this.src='/Kangli/Public/Kangli/static/logo_icon.png'"></div>
									<div class="order-inner">
										<div class="item-subtitle" style="font-size: 0.5rem">
											<?php echo ($ordersinfo["oddt_proname"]); ?>
										</div>
										<div class="order-remark">
											<div class="kl-layout-horizontally-between">
												<div>
													<div class="pro_name" style="color: red;">￥<span style="font-size:.75rem"><?php echo (number_format($ordersinfo["oddt_dlprice"],2,'.','')); ?></span>
														<?php if($ordersinfo["oddt_price"] > 0): ?><span style="padding-right:.2rem; text-decoration:line-through;color:#c1c1c1">￥<?php echo (number_format($ordersinfo["oddt_price"],2,'.','')); ?></span><?php endif; ?>
													</div>
                          							<?php if($ordersinfo["oddt_color"] != ''): ?><div class="pro_name">颜色尺码：<?php echo ($ordersinfo["oddt_color"]); ?> <?php echo ($ordersinfo["oddt_size"]); ?>
                          							</div><?php endif; ?>
													<div class="pro_name">订购数量:
														<?php echo ($ordersinfo["oddt_qty"]); ?>
															<?php echo ($ordersinfo["oddt_prounits"]); ?>
																<?php echo ($ordersinfo["oddt_totalqty"]); ?>
													</div>
													<div class="pro_name">已发数量：<?php echo ($ordersinfo["oddt_shipqty"]); ?>
													</div>
											</div>
										</div>
									</div>
						</li>
					</ul>
					</div>
					<div class="list-block" style="margin-top:0.5rem;">
						<ul>
							<li class="item-content" id="record_code_title">
								<div class="item-inner">
									<div class="item-title">出货记录</div>
									<div class="item-after"><span class="icon icon-down" id="record_code_icon"></span></div>
								</div>
							</li>
							<li class="item-content" id="record_code" style="display:none;">
                				<?php if(is_array($list)): foreach($list as $key=>$item): ?><div class="item-inner item-title">
									<div >
									   <div class="kl-layout-horizontally-between">扫描条码：<?php echo ($item["ship_barcode"]); ?></div>
									   <div><span>数量：<?php echo ($item["ship_proqty"]); ?></span></div>
									   <?php if(!empty($item["ship_dealer_from_name"])): ?><div><?php echo (date('Y-m-d',$item["ship_date_from"])); ?>  由 <b><?php echo ($item["ship_dealer_from_name"]); ?></b>  发向  <b>我</b> </div><?php endif; ?>
		 							   <?php if(!empty($item["ship_dealer_name"])): ?><div><?php echo (date('Y-m-d H:i',$item["ship_date"])); ?>  由 <b>我</b>  发向 <b><?php echo ($item["ship_dealer_name"]); ?></b></div><?php endif; ?>
			 						</div>
			 					     <?php if($od_state < 3): ?><span class="iconfont icon-shanchu recode_code_del" style="font-size: 1.2rem;color: c1c1c1;"></span><?php endif; ?>
								   	</div><?php endforeach; endif; ?>
							</li>
						</ul>
						<div class="kl-page" style="margin:.5rem">
						 <?php if($page != ''): echo ($page); endif; ?>
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
			var flag =0;
			$("#record_code_title").click(function() {
	          if (0==flag)
	          {
	              flag=1;
	              $(this).css("background","#e9e9e9");
	              if($("#record_code_icon").hasClass("icon-down"))
	              {
	                $("#record_code_icon").removeClass("icon-down");
	                $("#record_code_icon").addClass("icon-up");
	              }
	          }else
	          {
	              flag=0;
	              $(this).css("background","#fff");
	              if($("#record_code_icon").hasClass("icon-up"))
	              {
	                $("#record_code_icon").removeClass("icon-up");
	                $("#record_code_icon").addClass("icon-down");
	              }
	          }
			  $("#record_code").toggle();
			});

			 var shipArrar=<?php echo json_encode($list);?>||{};
      		$('.recode_code_del').each(function(index) {
      			// console.log('li %d is:%o',index,this);
	          	if ($.isArray(shipArrar)&&shipArrar.length>index)
	          	{
	              var shipObject=shipArrar[index];
	              $(this).click(function() {
			         	$.confirm('该操作将彻底删除该出货记录,请谨慎操作!',function () {
			                window.location.href ="<?php echo U('./Kangli/Orders/odshdelete/shid');?>/" +shipObject['ship_id']+"/od_id/"+shipObject['ship_odid']+"/oddt_id/"+shipObject['ship_oddtid'];
			            });
			       });
	          	}
	     	});
		});
	</script>
</html>