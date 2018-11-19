<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>

	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
		<link rel="shortcut icon" href="/Kangli/Public/Kangli/static/chuanshu_min.png">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-status-bar-style" content="black">
		<meta name="format-detection" content="telephone=no,email=no,adress=no">
		<title><?php echo (C("QY_COMPANY")); ?>-购物车</title>
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
				<?php if($back == 1): ?><a href="<?php echo U('./Kangli/Product/index/');?>/stock/<?php echo ($stock); ?>/back/<?php echo ($back); ?>" class="icon icon-left pull-left" style="color:#fff"></a>
				<?php else: ?>
					<a href="<?php echo U('./Kangli/Product/index/');?>/stock/<?php echo ($stock); ?>" class="icon icon-left pull-left" style="color:#fff"></a><?php endif; ?>
				<h1 class="title" style="color:#fff"><?php if($stock == 1): ?>预充<?php else: ?>提货<?php endif; ?>购物车</h1>
			</header>
			<div class="content">
					<div class="list-block media-list" style="line-height:1rem; margin-top:.25rem;margin-bottom: 0rem; background: #fff;">
						<ul>
							<?php if(is_array($shopcartlist)): foreach($shopcartlist as $key=>$item): if($item["pro_dlprice"] != '' ): ?><li>
								<div class="kl-layout-horizontally-vcenter">
									<?php if($item["sc_status"] != 0): ?><i class="iconfont icon-xuanze1 checkbtn" style="font-size:1rem;margin:.5rem;color: #7e7e7e"></i>
									<?php else: ?>
										<i class="iconfont icon-xuanze checkbtn" style="font-size:1rem;margin:.5rem;color: #7e7e7e"></i><?php endif; ?>
									<div class="kl-layout-horizontally-vcenter" style="width: 100%;border-bottom:0.05rem solid #d5d5d5;margin-right:0.3rem;padding:.3rem 0;">
										<img src="/Kangli/Public/uploads/mobi/<?php echo ($item["pro_pic"]); ?>" style="width:3rem;margin:.5rem .5rem .5rem 0" onerror="this.src='/Kangli/Public/Kangli/static/logo_icon.png'">
										<div style="margin: 0 .3rem 0 0;width:100%">
											<div class="kl-layout-horizontally-between">
												 <div class="pro_name"><?php echo ($item["pro_name"]); ?></div>
												 <div class="order-price" style="color: #f00">￥<?php echo (number_format($item["pro_dlprice"],2,'.','')); ?></div>
											</div>
											<div class="pro_name " style="color: #c1c1c1;max-height:2rem"><?php echo ($proinfo["pro_remark"]); ?></div>
											<div class="kl-layout-horizontally-between">
											    <div style="color: #c1c1c1;">
											    	<?php if(($item["pri_minimum"] != '') AND ($item["pri_minimum"] != '0') ): ?><div>最低补货:<?php echo ($item["pri_minimum"]); ?></div><?php endif; ?>
											    	<div>库存剩余:<?php if(($dl_belong == 0) AND ($stock == 1) ): ?>充足<?php else: echo ($item["pro_stock"]); endif; ?></div>	
											    </div>
												<div class="kl-numbox">
													<button class="kl-btn kl-btn-numbox-minus" type="button">-</button>
													<input class="kl-input-numbox" style="height:100%;font-size: 0.6rem" value="<?php echo ($item["sc_qty"]); ?>" name="num" type="text"/>
													<button class="kl-btn kl-btn-numbox-plus" type="button">+</button>
												</div>
											</div>
											<div style="color: #c1c1c1;"><?php if($item["sc_color"] != '' ): ?>颜色尺码：<?php echo ($item["sc_color"]); ?>  <?php echo ($item["sc_size"]); endif; ?></div>
										</div>
									</div>
								</div>
							</li><?php endif; endforeach; endif; ?>
						</ul>
						<div class="kl-layout-horizontally-right">
							<div style="padding: 0.3rem">
								<div style="color: #7e7e7e;display: none;">物流费用：</div>
								<div style="color: #7e7e7e">共<span style="color: red"> <?php echo ($totalqty); ?> </span>件商品，合计：<span style="color:#000">￥<?php echo (number_format($total,2,'.','')); ?></span></div></div>
							</div>
						</div>
			</div>
			<footer class="kl-foot-fixed" style="background: #fff;width: 100%;height:3rem; overflow: hidden;">
			<div class="kl-layout-horizontally" style="margin: 0rem;">
				<div class="kl-layout-center" id="checkAllbtn" style="width:20%;height:3rem;">
						<?php if($allcheck == true): ?><i class="iconfont icon-xuanze" style="font-size:1rem;padding: .3rem;color: #7e7e7e;"></i>
						<?php else: ?>
							<i class="iconfont icon-xuanze1" style="font-size:1rem;padding: .3rem;color: #7e7e7e;"></i>
							<!--iconfont icon-xuanze1没有对勾--><?php endif; ?>
						<div style="color:#c1c1c1;font-size:0.2rem;">全选</div>
				</div>
				<div class="kl-layout-horizontally-right" id="shopcar_add" style="width:55%;height:3rem;font-size:0.75rem;">
					<div style="padding: 0.5rem">
							<div style="font-size:0.75rem;">
								合计：<span style="color: red; font-size:0.3rem;">￥<span style="font-size:1rem;"><?php echo (number_format($total,2,'.','')); ?></span></span>
							</div>
							<div style="display: none;">
								<span style="color:#c1c1c1;">物流：￥<?php echo (number_format($total,2,'.','')); ?></span>
							</div>
					</div>
				</div>
				<div class="kl-layout-center" id="orderlist_add" style="width:25%;height:3rem;background:#f08519;font-size:0.75rem;color: #fff;margin:0rem;"><?php if($stock == 0): ?>提货<?php else: ?>结算<?php endif; ?>(<?php echo ($totalqty); ?>)</div>
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

	<script type="text/javascript">
	$.init();
	$(function() {
		var stock="<?php echo ($stock); ?>";
		var scArray=<?php echo json_encode($shopcartlist);?>||[];
		$('.checkbtn').each(function(index) {
			// console.log('li %d is:%o',index,this);
			if ($.isArray(scArray)&&scArray.length>index)
			{
				var scObject=scArray[index];
				$(this).click(function(){
					if ($.isPlainObject(scObject))
					{
						window.location.href="<?php echo U('./Kangli/Orders/checkcart/sc_id');?>/"+scObject['sc_id']+"/stock/"+stock;
					}
				});
			}
		});

		$('.kl-btn.kl-btn-numbox-minus').each(function(index) {
			// console.log('li %d is:%o',index,this);
		
			if ($.isArray(scArray)&&scArray.length>index)
			{
				var minusObject=scArray[index];
				$(this).click(function(){
					if ($.isPlainObject(minusObject))
					{		
						    var sc_qty=parseInt($(".kl-input-numbox").eq(index).val());
							var sc_id=parseInt(minusObject['sc_id']);
							if(sc_qty<=1){
	    						sc_qty=1;
							}else{
	    						sc_qty=sc_qty-1;
							}
						window.location.href="<?php echo U('./Kangli/Orders/modifycart/sc_id');?>/"+sc_id+'/sc_qty/'+sc_qty+"/stock/"+stock;
					}
				});
			}
		});

		$('.kl-btn.kl-btn-numbox-plus').each(function(index) {	
			if ($.isArray(scArray)&&scArray.length>index)
			{
				var plusObject=scArray[index];
				$(this).click(function(){
					if ($.isPlainObject(plusObject))
					{

 						var sc_qty=parseInt($(".kl-input-numbox").eq(index).val());
						var sc_id=parseInt(plusObject['sc_id']);
    					if (sc_qty>=plusObject['pro_stock'])
    					{
    						$.toast("该产品库存不足");
							return false; 
    					}
						sc_qty=sc_qty+1;
						window.location.href="<?php echo U('./Kangli/Orders/modifycart/sc_id');?>/"+sc_id+'/sc_qty/'+sc_qty+"/stock/"+stock;
					}
				});
			}
		});

		$('.kl-input-numbox').each(function(index) {
			if ($.isArray(scArray)&&scArray.length>index)
			{
				var numObject=scArray[index];
				$(this).change(function(){
					if ($.isPlainObject(numObject))
					{
 						var sc_qty=parseInt($(this).val());
						var sc_id=parseInt(numObject['sc_id']);
    					if (sc_qty>=numObject['pro_stock'])
    					{
    						$.toast("该产品库存不足");
							return false; 
    					}
    					if(sc_qty<=1){
	    					sc_qty=1;
						}
						window.location.href="<?php echo U('./Kangli/Orders/modifycart/sc_id');?>/"+sc_id+'/sc_qty/'+sc_qty+"/stock/"+stock;
					}
				});
			}
		});

		$("#checkAllbtn").click(function(){
				var checkall=0;
				var allcheck="<?php echo ($allcheck); ?>";
				if (allcheck)
					checkall=1; //1为取消全选
				window.location.href="<?php echo U('./Kangli/Orders/checkcart/checkall');?>/"+checkall+"/stock/"+stock;
		});

		$("#orderlist_add").click(function(){
			$.confirm('是否确认提交？',function () {
               	window.location.href="<?php echo U('./Kangli/Orders/checkshopcart');?>"+"/stock/"+stock;
            });
		});

	});
	</script>	
</html>