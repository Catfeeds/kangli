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
			<?php echo (C("QY_COMPANY")); ?>-<?php echo ($title); ?></title>
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
			
			.bar-nav~.pull-to-refresh-content {
				margin-top: -1.5rem;
			}


			.list-block .item-content1 {
				margin-top: .15rem;
				box-sizing: border-box;
				padding-left: 0rem;
				padding-right: .5rem;
				min-height: 4rem;
				display: -webkit-box;
				display: -webkit-flex;
				display: flex;
				-webkit-box-pack: justify;
				-webkit-justify-content: space-between;
				justify-content: space-between;
				/*-webkit-box-align: center;*/
				/*-webkit-align-items: center;*/
				/*align-items: center;*/
			}
			
			.list-block.media-list .item-media1 {
				padding-top: 0rem;
				padding-bottom: 0rem;
			}
			
			.list-block.media-list .item-media2 {
				padding: .5rem;
			}
			
			.list-block.media-list .item-inner {
				padding: .5rem 0 .5rem 0;
			}
			
			.list-block .item-title {
				min-height: 2.2rem;
				color: #7e7e7e;
			}
			
			.card-footer2 {
				position: relative;
				box-sizing: border-box;
				display: -webkit-box;
				display: -webkit-flex;
				display: flex;
				-webkit-box-pack: justify;
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
				<a href="<?php echo U('./Kangli/Index');?>" class="icon icon-left pull-left" style="color:#fff"></a>
				<h1 class="title" style="color:#fff"><?php echo ($title); ?></h1>
			</header>
			<!-- content应该拥有"pull-to-refresh-content"类,表示启用下拉刷新 -->
			<div class="content">
					<?php if(is_array($list)): foreach($list as $key=>$item): ?><div class="list-block media-list" style="margin:0.3rem 0 0 0">
						<ul>
							<?php if($news_type == 2): ?><li>
								<div class="item-content1">
									<div class="item-media1"><?php if($item["news_index"] == 0 and $news_type == 2): ?><img src="/Public/Kangli/static/send_show.png" style="width:2.5rem;height:2.5rem;"><?php else: ?><img src="/Public/Kangli/static/send_show.png" style="width:2.5rem;height:2.5rem; visibility: hidden;"><?php endif; ?></div>
									<div class="item-inner">
										<div class="item-subtitle"><?php echo ($item["news_title"]); ?></div>
										<div class="item-title-row">
											<div class="item-text" style="min-height:2rem;"><?php echo ($item["news_content"]); ?></div>
										</div>
										<div class="card-footer2">
											<span style="color: #f08519"></span>
											<span><?php echo (date('Y-m-d',$item["news_addtime"])); ?></span>
										</div>
									</div>
									<div class="item-media2"><img src="<?php echo ($item["news_pic_str"]); ?>" style='width:4rem;height:3rem' onerror="this.src='/Public/Kangli/static/logo_icon.png'"></div>
								</div>
							</li>
							<?php else: ?>
								<li>
									<div class="item-content1">
										<div class="item-media2"><img src="<?php echo ($item["news_pic_str"]); ?>" style='width:4rem;height:3rem' onerror="this.src='/Public/Kangli/static/logo_icon.png'"></div>
										<div class="item-inner">
											<div class="item-title-row">
											      <div class="item-stitle"><?php echo ($item["news_title"]); ?></div>
											      <div class="item-after" style="margin-right:0.3rem"><?php echo (date('Y-m-d',$item["news_addtime"])); ?></div>
											</div>
											<div class="item-text" style="min-height:2rem;"><?php echo ($item["news_content_s"]); ?></div>
										</div>
									</div>
								</li><?php endif; ?>
						</ul>
					</div><?php endforeach; endif; ?>
				 <div class="kl-page" style="margin:.5rem">
                    <?php if($page != ''): echo ($page); endif; ?>
                </div>
			</div>
			<!-- 添加 class infinite-scroll 和 data-distance  向下无限滚动可不加infinite-scroll-bottom类，这里加上是为了和下面的向上无限滚动区分-->
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
			var hdArray = <?php echo json_encode($list);?>;
            $('.item-content1').each(function(index) {
                // console.log('li %d is:%o',index,this);
                if ($.isArray(hdArray)&&hdArray.length>index)
                {
                    var hdObject=hdArray[index];
                    $(this).click(function(){
                        if($.isPlainObject(hdObject))
                        {
                            window.location.href="<?php echo U('./Kangli//News/detail');?>/"+"news_id/"+hdObject['news_id'];
                        }
                    }); 
                }
            });
		});
	</script>

</html>