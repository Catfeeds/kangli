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
			<?php echo (C("QY_COMPANY")); ?>-新闻动态</title>
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
			
			.bar-nav~.pull-to-refresh-content {
				margin-top: -1.5rem;
			}
		</style>
	</head>

	<body ontouchstart="" style="background-color:#FAFAFA">
		<div class="page">
			<header class="bar bar-nav" style="background-color:#006db2;">
				<a href="<?php echo U('./Kangli/Index');?>" class="icon icon-left pull-left" style="color:#fff"></a>
				<h1 class="title" style="color:#fff">新闻动态</h1>
			</header>
			<!-- content应该拥有"pull-to-refresh-content"类,表示启用下拉刷新 -->
			<div class="content pull-to-refresh-content infinite-scroll infinite-scroll-bottom" data-distance="100" data-ptr-distance="55">
				<!-- 默认的下拉刷新层 -->
				<div class="pull-to-refresh-layer">
					<div class="preloader"></div>
					<div class="pull-to-refresh-arrow"></div>
				</div>
				<!-- 下面是正文 -->
				<div class="list-block media-list">
					<ul class="list-container">
						<?php if(is_array($list)): foreach($list as $key=>$item): ?><li>
								<a href="<?php echo U('./Kangli/News/detail?news_id='.$item['news_id'].'');?>" class="item-link item-content">
									<div class="item-media"><img src="/Kangli/Public/uploads/mobi/<?php echo ($item["news_pic"]); ?>" style="width:3rem;" onerror="this.src='/Kangli/Public/Kangli/static/logo_icon.png'"></div>
									<div class="item-inner">
										<div class="item-title-row">
											<div class="item-subtitle" style="color:#7e7e7e">
												<?php echo ($item["news_title"]); ?>
											</div>
											<div class="item-after" style="font-size:0.3rem;color:#c1c1c1">
												<?php echo (date('Y-m-d' ,$item["news_addtime"])); ?>
											</div>
										</div>
										<div class="item-text" style="font-size:0.5rem;color:#c1c1c1">
											<?php echo ($item["news_content_s"]); ?>
										</div>
									</div>
								</a>
							</li><?php endforeach; endif; ?>
					</ul>
				</div>
				<div class="infinite-scroll-preloader">
					<div class="preloader"></div>
				</div>
			</div>
			<!-- 添加 class infinite-scroll 和 data-distance  向下无限滚动可不加infinite-scroll-bottom类，这里加上是为了和下面的向上无限滚动区分-->
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
			var pageNum = 1;　　
			var windowHeight = $(this).height();
			var topHeight = $('.bar.bar-nav')[0].scrollHeight;
			topHeight += 20;
			var itemHeight = 0;
			var offsetHeight = $('.list-container')[0].scrollHeight;

			// 加载flag
			var loading = false;
			// 最多可加载的条目
			var maxItems = 30;
			// 每次加载添加多少条目
			var itemsPerLoad = 10;

			function addItems(number, lastIndex) {
				// 生成新条目的HTML
				var html = '';
				for(var i = lastIndex + 1; i <= lastIndex + number; i++) {
					html += '<li class="item-content"><div class="item-inner"><div class="item-title">Item ' + i + '</div></div></li>';
				}
				// 添加新条目
				$('.infinite-scroll-bottom .list-container').append(html);
				lastIndex += number;
				offsetHeight = $('.list-container')[0].scrollHeight;
				itemHeight = $('.item-content')[0].scrollHeight;
				console.log("topHeight=" + topHeight + "windowHeight=" + windowHeight + "offsetHeight=" + offsetHeight);
			}
			// 添加'refresh'监听器
			$(document).on('refresh', '.pull-to-refresh-content', function(e) {
				// 模拟2s的加载过程
				pageNum = 1;
				try {
					$.ajax({
						type: 'POST',
						url: '<?php echo U("./Kangli/News/getNewList");?>',
						data: {
							action: 'newlist',
							page: pageNum
						},
						dataType: 'json',
						timeout: 30000,
						success: function(data) {
							var stat = 0;
							stat = parseInt(data.stat);
							// console.log(JSON.stringify(data.list));
							if(stat == 1) {
								setTimeout(function() {
									$('.infinite-scroll-bottom .list-container')[0].innerHTML = '';
									var listArray = data.list;
									if($.isArray(listArray) && listArray.length > 0) {
										// $.toast("有数据"+listArray.length);
										var itemHtml = '';
										var imagedetaul = '\'/Kangli/Public/Kangli/static/logo_icon.png\'';
										// console.log(imagedetaul);
										listArray.forEach(function(val, index) {
											itemHtml += '<li><a href="<?php echo U("./Kangli/News/detail/news_id");?>/' + val.news_id + '" class="item-link item-content"><div class="item-media"><img src="/Kangli/Public/uploads/mobi/' + val.news_pic + '" style="width:3rem;" onerror="this.src=' + imagedetaul + '"></div><div class="item-inner"><div class="item-title-row"><div class="item-subtitle" style="color:#7e7e7e">' + val.news_title + '</div><div class="item-after" style="font-size:0.3rem;color:#c1c1c1">' + formatDate(val.news_addtime) + '</div></div><div class="item-text" style="font-size:0.5rem;color:#c1c1c1">' + val.news_content_s + '</div></div></a></li>';
										});
										$('.infinite-scroll-bottom .list-container').append(itemHtml);
									}
									$.pullToRefreshDone('.pull-to-refresh-content');
								}, 2000);
							} else {
								$.toast(data.msg);
								$.pullToRefreshDone('.pull-to-refresh-content');
								return false;
							}
						},
						error: function(xhr, type) {
							$.toast("超时或服务错误");
							setTimeout(function() {
								$.pullToRefreshDone('.pull-to-refresh-content');
							}, 1000);
							return false;
						}
					});

				} catch(e) {
					$.toast(e);
					$.pullToRefreshDone('.pull-to-refresh-content');
					return false;
				}
			});

			//预先加载20条
			// addItems(itemsPerLoad, 0);
			if(offsetHeight < windowHeight)
				$('.infinite-scroll-preloader').css('display', 'none');

			// 上次加载的序号
			var lastIndex = 10;

			// 注册'infinite'事件处理函数
			$(document).on('infinite', '.infinite-scroll-bottom', function() {
				// 如果正在加载，则退出
				if(loading) return;
				// $('.infinite-scroll-preloader').css('display', 'block');
				// // 设置flag
				// loading = true;
				// // 模拟1s的加载过程
				// setTimeout(function() {
				// 	// 重置加载flag
				// 	loading = false;
				// 	if(lastIndex >= maxItems) {
				// 		// 加载完毕，则注销无限加载事件，以防不必要的加载
				// 		$.detachInfiniteScroll($('.infinite-scroll'));
				// 		// 删除加载提示符
				// 		$('.infinite-scroll-preloader').remove();
				// 		return;
				// 	}
				// 	// 添加新条目
				// 	addItems(itemsPerLoad, lastIndex);
				// 	// 更新最后加载的序号
				// 	lastIndex = $('.list-container li').length;
				// 	//容器发生改变,如果是js滚动，需要刷新滚动
				// 	$.refreshScroller();
				// }, 1000);
				pageNum++;
				try {
					$.ajax({
						type: 'POST',
						url: '<?php echo U("./Kangli/News/getNewList");?>',
						data: {
							action: 'newlist',
							page: pageNum
						},
						dataType: 'json',
						timeout: 30000,
						success: function(data) {
							// $('.infinite-scroll-preloader').css('display', 'none');
							var stat = 0;
							stat = parseInt(data.stat);
							if(stat == 1) {
								setTimeout(function() {
									var listArray = data.list;
									if($.isArray(listArray) && listArray.length > 0) {
										// $.toast("有数据"+listArray.length);
										var itemHtml = '';
										var imagedetaul = '\'/Kangli/Public/Kangli/static/logo_icon.png\'';
										// console.log(imagedetaul);
										listArray.forEach(function(val, index) {
											itemHtml += '<li><a href="<?php echo U("./Kangli/News/detail");?>?news_id=' + val.news_id + '" class="item-link item-content"><div class="item-media"><img src="/Kangli/Public/uploads/mobi/' + val.news_pic + '" style="width:3rem;" onerror="this.src=' + imagedetaul + '"></div><div class="item-inner"><div class="item-title-row"><div class="item-subtitle" style="color:#7e7e7e">' + val.news_title + '</div><div class="item-after" style="font-size:0.3rem;color:#c1c1c1">' + formatDate(val.news_addtime) + '</div></div><div class="item-text" style="font-size:0.5rem;color:#c1c1c1">' + val.news_content_s + '</div></div></a></li>';
										});
										$('.infinite-scroll-bottom .list-container').append(itemHtml);
									} else {
										// 加载完毕，则注销无限加载事件，以防不必要的加载
										$.detachInfiniteScroll($('.infinite-scroll'));
										// 删除加载提示符
										$('.infinite-scroll-preloader').remove();
										return;
									}
									$.refreshScroller();
								}, 2000);
							} else {
								$.toast(data.msg);
								if(pageNum > 1) {
									pageNum--;
								}
								return false;
							}
						},
						error: function(xhr, type) {
							$.toast("超时或服务错误");
							// $('.infinite-scroll-preloader').css('display', 'none');
							if(pageNum > 1) {
								pageNum--;
							}
							return false;
						}
					});

				} catch(e) {
					$.toast(e);
					// $('.infinite-scroll-preloader').css('display', 'none');
					if(pageNum > 1) {
						pageNum--;
					}
					return false;
				}
			});

			function formatDate(times) {
				var now = new Date(parseInt(times)*1000);
				var year = now.getFullYear(); //getYear()
				var month = now.getMonth() + 1;
				var date = now.getDate();
				var hour = now.getHours();
				var minute = now.getMinutes();
				var second = now.getSeconds();
				// return year + "-" + month + "-" + date + " " + hour + ":" + minute + ":" + second;
				if (parseInt(month)<10)
					month="0"+month;
				if (parseInt(date)<10)
					date="0"+date;
				return year + "-" + month + "-" + date + " ";
			}
		});
	</script>

</html>