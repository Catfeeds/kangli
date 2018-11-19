<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>

	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
		<link rel="shortcut icon" href="/Kangli/Public/Kangli/static/chuanshu_min.png">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-status-bar-style" content="black">
		<meta name="format-detection" content="telephone=no,email=no,adress=no">
		<title><?php echo (C("QY_COMPANY")); ?>-产品列表</title>
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
				<?php if($back == 1): ?><a href="<?php echo U('./Kangli/Mine');?>" class="icon icon-left pull-left" style="color:#fff"></a>
				<?php else: ?>
				<a href="<?php echo U('./Kangli/Index');?>" class="icon icon-left pull-left" style="color:#fff"></a><?php endif; ?>
				<h1 class="title" style="color:#fff">产品列表</h1>
			</header>
			<div class="content">
				<!-- searchbar -->
					<div class="searchbar" style="margin:0 0.5rem;">
						<a class="searchbar-cancel">搜索</a>
						<div class="search-input">
							<label class="icon icon-search" for="search"></label>
							<input type="search" id='search' placeholder='输入产品关键字'/>
						</div>
					</div>
					<div class="row" style="background:#FFF;border-top:0.05rem solid #d5d5d5;border-bottom:0.05rem solid #d5d5d5;">
      					<div class="col-50 kl-layout-center" id="pro_order" style="padding:.5rem 0;">智能排序<?php if($order_status > 0): ?><img id="pro_order_img" src="/Kangli/Public/Kangli/static/order_icon_down.png" style="width:1rem;"><?php else: ?><img id="pro_order_img" src="/Kangli/Public/Kangli/static/order_icon_up.png" style="width:1rem;"><?php endif; ?></div>
      					<div class="col-50 kl-layout-center" id="pro_filter" style="padding:.5rem 0;"><span id="pro_filter_span"><?php echo ($protype_name); ?></span><i class="iconfont icon-shaixuan" style="padding: 0 0.3rem;font-size:0.75rem"></i></div>
    				</div>
					<!-- <div class="kl-cross"></div> -->
					<div style="padding: 0 0.5rem; background: #fff">
						<ul class="kl-products-list">
							<?php if(is_array($list)): foreach($list as $key=>$item): ?><li class="kl-products-item">
								<div class="kl-layout-center"><img src="/Kangli/Public/uploads/product/<?php echo ($item["pro_pic"]); ?>" style="width:4rem;height:4rem;margin:.5rem" onerror="this.src='/Kangli/Public/Kangli/static/logo_icon.png'"></div>
								<div class="pro_name" style="padding:.2rem .2rem 0 .2rem"><?php echo ($item["pro_name"]); ?></div>
								<div style="padding:0 .2rem .2rem .2rem">
									<?php if(($item["pro_dlprice"] != '') AND ($item["pro_dlprice"] != '0') ): ?><span style="color:red;font-size:0.3rem;">￥<span style="font-size: 1rem"><?php echo (number_format($item["pro_dlprice"],2, '.', '')); ?></span></span><?php endif; ?>
									<?php if(($item["pro_price"] != '') AND ($item["pro_price"] != '0') ): if($login == true): ?><span style="padding-right:.2rem; text-decoration:line-through"><?php endif; ?>￥<?php echo (number_format($item["pro_price"],2,'.','')); ?></span><?php endif; ?>
								</div>
								</li><?php endforeach; endif; ?>
						</ul>
					</div>
					<div class="kl-page" style="margin:.5rem"><?php if($page != ''): echo ($page); endif; ?></div>
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
		var stock="<?php echo ($stock); ?>"
		var proArray=<?php echo json_encode($list);?>||[];
		var count=proArray.length;
		$('.kl-products-item').each(function(index) {
			// console.log('item %d is:%o',index,this);
			if (index%3==2)
			{
				if (index+1!=count)
					$(this).css({"border-bottom":"0.05rem solid #ddd","border-right":"0 solid #ddd"});
			}else if(index+1>(Math.ceil(count/3)-1)*3)
			{
				if (index+1!=count)
					$(this).css({"border-bottom":"0 solid #ddd","border-right":"0.05rem solid #ddd"});
			}else
			{
				if (index+1!=count)
					$(this).css({"border-bottom":"0.05rem solid #ddd","border-right":"0.05rem solid #ddd"});
			}
			$(this).click(function(){
				if ($.isArray(proArray)&&proArray.length>index)
				{
					var proObject=proArray[index];
					if ($.isPlainObject(proObject))
					{
						window.location.href="<?php echo U('./Kangli/Product/detail/pro_id');?>/"+proObject['pro_id']+"/stock/"+stock;
					}
				}
			});
		});

		var order_status="<?php echo ($order_status); ?>";
		$('#pro_order').click(function() {
				if (order_status==1)
				{
					// $("#pro_order_img").attr('src',"/Kangli/Public/Kangli/static/order_icon_up.png"); 
					window.location.href = "<?php echo U('./Kangli/Product/index/order_status/');?>/0"+"/stock/"+stock;
				}
				else
				{
					// $("#pro_order_img").attr('src',"/Kangli/Public/Kangli/static/order_icon_down.png"); 
					window.location.href = "<?php echo U('./Kangli/Product/index/order_status/');?>/1"+"/stock/"+stock;
				}
		});

		var protype_id=0;
		var listArray = <?php echo json_encode($protypelist);?>||[]; //注意，这里不要用双引号或单引号；
		var nTypeArry=[];
		var idTypeArry=[];
			if($.isArray(listArray)&&listArray.length>0){
					// console.log(JSON.stringify(listArray));
				nTypeArry.push('全部分类');
				idTypeArry.push(0);
				listArray.forEach(function(val,index) {
					nTypeArry.push(val.protype_name);
					idTypeArry.push(val.protype_id);
				});
			}
			$('#pro_filter').picker({
				toolbarTemplate: '<header class="bar bar-nav">\<button class="button button-link pull-right close-picker">确定</button>\<h1 class="title">请选择产品分类</h1>\</header>',
				formatValue:function (p,values,displayValues) {
					protype_id=values[0];
					$('#pro_filter_span').html(displayValues[0]);
					// $("#dlt_id").val(values[0]);
        			// return displayValues[0] +' '+values[0];
        			return displayValues[0];
    			},
				cols: [{
					textAlign: 'center',
					values: idTypeArry,
					displayValues:nTypeArry
				}],
				onClose:function(e)
				{
					location.href = "<?php echo U('./Kangli/Product/index/order_status/');?>/"+order_status+"/protype_id/"+protype_id+"/stock/"+stock;;
				}
			});

		$('.searchbar-cancel').click(function() {
				var keyword=$("#search").val();
				if (!isEmpty(keyword))
				{
					 window.location.href="<?php echo U('./Kangli/Product/index/keyword');?>/"+keyword+"/stock/"+stock;;
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