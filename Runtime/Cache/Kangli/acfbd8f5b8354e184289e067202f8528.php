<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>

	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
		<link rel="shortcut icon" href="/Kangli/Public/Kangli/static/chuanshu_min.png">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-status-bar-style" content="black">
		<meta name="format-detection" content="telephone=no,email=no,adress=no">
		<title><?php echo (C("QY_COMPANY")); ?>-代理查询</title>
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
			
			.between-horizontally {
				box-sizing: border-box;
				display: -webkit-box;
				display: -webkit-flex;
				display: flex;
				-webkit-justify-content: space-between;
				justify-content: space-between;
				-webkit-box-align: center;
				-webkit-align-items: center;
				align-items: center;
			}
		</style>
	</head>

	<body ontouchstart="" style="background-color:#FAFAFA">
		<div class="page">
			<header class="bar bar-nav" style="background-color:#006db2;">
				<?php if($backtag > 0): ?><a href="javascript :;" onClick="javascript :history.back(-1);" class="icon icon-left pull-left" style="color:#fff"></a>
				<?php else: ?>
					<a href="<?php echo U('./Kangli/Dealer');?>" class="icon icon-left pull-left" style="color:#fff"></a><?php endif; ?>
				<h1 class="title" style="color:#fff">代理查询</h1>
			</header>
			<div class="content">
				<!-- searchbar -->
					<div class="searchbar" style="margin:0 0.5rem;">
						<a class="searchbar-cancel">搜索</a>
						<div class="search-input">
							<label class="icon icon-search" for="search"></label>
							<input type="search" id='search' placeholder='输入代理商微信号或手机号查询' />
						</div>
					</div>
					<div class="list-block media-list" style="line-height:1rem; margin-top:0rem;margin-bottom: 0rem;">
									<ul>
										<?php if(is_array($dl_slist)): foreach($dl_slist as $key=>$item): if($item["dl_status"] > 0): ?><li>
												<div class="order-list dl_search" style="border-bottom:.2rem solid #EFEFF4;">
													<div class="order-content">
														<div class="item-media"><img class="kl-circle kl-img-thumbnail" src="/Kangli/Public/uploads/mobi/<?php echo ($item["dl_wxheadimg"]); ?>" style="width:2.5rem; border-radius: 50%;" onerror="this.src='/Kangli/Public/Kangli/static/head_icon.png'"></div>
														<div class="order-inner">
															<div class="item-subtitle between-horizontally"><?php echo ($item["dl_name"]); ?><span style="color:#c1c1c1"><?php echo (date('Y-m-d h:m',$item["dl_addtime"])); ?></span></div>
															<div class="order-remark">
																<div class="item-title" style="color:#c1c1c1">级别：<span style="color:red"><?php echo ($item["dlt_name"]); ?></span> 代理团队</div>
																<div class="item-title between-horizontally" style="color:#c1c1c1">手机：<?php echo ($item["dl_tel_s"]); ?><span style="color:#c1c1c1">微信：<?php echo ($item["dl_weixin_s"]); ?></span></div>
															</div>
															<div class="order-type" style="border:0;color:#c1c1c1">地址：<?php echo ($item["dl_address"]); ?></div>
														</div>
													</div>
													<div class="order-number" style="display: none;">
														<span style="color:#c1c1c1">时间：<?php echo (date('Y-m-d',$item["dl_addtime"])); ?></span>
															<div class="order-button-type" >
																<a href="#" class="button button-light button-round order-button dl_delete" style="color:#ccc;">删除</a>
																<a href="#" class="button button-warning button-round order-button dl_confirm" style="margin-right: .3rem;">通过</a>
															</div>
													</div>
												</div>
											</li>
											<?php else: ?>
											<li>
												<div class="order-list dl_search" style="border-bottom:.2rem solid #EFEFF4;">
													<div class="order-content">
														<div class="item-media"><img class="kl-circle kl-img-thumbnail" src="/Kangli/Public/uploads/mobi/<?php echo ($item["dl_wxheadimg"]); ?>" style="width:2.5rem; border-radius: 50%;" onerror="this.src='/Kangli/Public/Kangli/static/head_icon.png'"></div>
														<div class="order-inner">
															<div class="item-subtitle between-horizontally"><?php echo ($item["dl_name"]); ?><i class="iconfont icon-xin1" style="font-size:1.5rem; color:#f08519;line-height: 2rem;"></i></div>
															<div class="order-remark">
																<div class="item-title" style="color:#c1c1c1">申请加入<span style="color:red"><?php echo ($item["dlt_name"]); ?></span>代理团队</div>
																<div class="item-title between-horizontally" style="color:#c1c1c1">手机：<?php echo ($item["dl_tel_s"]); ?><span style="color:#c1c1c1">微信：<?php echo ($item["dl_weixin_s"]); ?></span></div>
															</div>
															<div class="order-type" style="color:#c1c1c1">地址：<?php echo ($item["dl_address"]); ?></div>
														</div>
													</div>
													<div class="order-number">
														<span style="color:#c1c1c1">时间：<?php echo (date('Y-m-d',$item["dl_addtime"])); ?></span>	
															<div class="order-button-type">
																<a href="#" class="button button-light button-round order-button dl_delete" onClick="event.cancelBubble=true" style="color:#ccc;">删除</a>
																<a href="#" class="button button-warning button-round order-button dl_confirm" onClick="event.cancelBubble=true" style="margin-right: .3rem;">通过</a>
															</div>
													</div>
												</div>
											</li><?php endif; endforeach; endif; ?>
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
		var dlsArray = <?php echo json_encode($dl_slist);?>||[];
			$('.order-list.dl_search').each(function(index) {
				// console.log('li %d is:%o',index,this);
				$(this).click(function(){
					if ($.isArray(dlsArray)&&dlsArray.length>index)
					{
						var dlsObject=dlsArray[index];
						if ($.isPlainObject(dlsObject))
						{
							window.location.href="<?php echo U('./Kangli/Dealer/dealerdetail/dlid');?>/"+dlsObject['dl_id'];
						}
					}
				});
			});

			$('.dl_delete').each(function(index) {
				// console.log('li %d is:%o',index,this);
				$(this).click(function(){
					$.confirm('确定删除该代理吗?', function () {
        				var dldObject=dlsArray[index];
        				if ($.isPlainObject(dldObject))
						{
							// $.toast("确定删除"+dldObject['dl_id']);
							window.location.href="<?php echo U('./Kangli/Dealer/applydelete/dlid');?>/"+dldObject['dl_id'];
						}
            		});
				});
			});

			$('.dl_confirm').each(function(index) {
				// console.log('li %d is:%o',index,this);
				$(this).click(function(){
					$.confirm('确定通过该代理吗?', function () {
        				var dlcObject=dlsArray[index];
        				if ($.isPlainObject(dlcObject))
						{
							// $.toast("确定删除"+dldObject['dl_id']);
							window.location.href="<?php echo U('./Kangli/Dealer/applyactive/dlid');?>/"+dlcObject['dl_id'];
						}
            		});
				});
			});


			$('.searchbar-cancel').click(function() {
				var keyword=$("#search").val();
				if (!isEmpty(keyword))
				{
					 window.location.href="<?php echo U('./Kangli/Agent/index/keyword');?>/"+keyword;
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