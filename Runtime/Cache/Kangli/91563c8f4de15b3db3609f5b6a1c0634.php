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
			<?php echo (C("QY_COMPANY")); ?>-代理</title>
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
			<nav class="bar bar-tab clear">
				<ul class="icon_lists clear">
					<li>
						<a class="tab-item" href="<?php echo U('./Kangli/Index');?>">
							<i class="iconfont icon-shouye-copy-copy-copy-copy"></i>
							<div class="name">首页</div>
						</a>
					</li>
					<li>
						<a class="tab-item active" href="#">
							<i class="iconfont active icon-tuandui3"></i>
							<div class="name">团队</div>
						</a>
					</li>
					<li>
						<a class="tab-item" id="fw_search" href="#">
							<img src="/Public/Kangli/static/fangwei_icon.png">
						</a>
					</li>
					<li>
						<a class="tab-item" href="<?php echo U('./Kangli/Orders');?>">
							<i class="iconfont icon-icon"></i>
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
				<!-- teamtop -->
				<div class="top-img">
					<img src="/Public/Kangli/static/team_top.jpg">
				</div>
				<!-- searchbar -->
				<div class="bar1 bar-header-secondary">
					<div class="searchbar">
						<a class="searchbar-cancel">搜索</a>
						<div class="search-input">
							<label class="icon icon-search" for="search"></label>
							<input type="search" id='search' placeholder='输入代理商微信号或手机号查询' />
						</div>
					</div>
				</div>
				<!-- dreanlist -->
				<div class="list-block" style="margin-top:.25rem;margin-bottom: 0rem;">
					<ul>
						<li class="item-content item-link" style="display: none">
							<div class="item-media"><img src="/Public/Kangli/static/dealer_up_icon.png" style="width:1rem;height:1rem;"></div>
							<div class="item-inner">
								<div class="item-title">
									<h1>已升级代理</h1></div>
							</div>
						</li>
						<li class="item-content item-link" style="display: none">
							<div class="item-media"><i class="iconfont icon-jiangjishenqing" style="font-size:1rem; color: #1afa29;line-height: 1rem;"></i></div>
							<div class="item-inner">
								<div class="item-title">
									<h1>已降级代理</h1></div>
							</div>
						</li>
						<li class="item-content item-link" id="dl_tiaoji"style="padding-left:.6rem;">
							<div class="item-media"><i class="iconfont icon-yixiangjibieshenpi-" style="font-size:1.3rem; color:#d81e06;line-height: 1.3rem;"></i></div>
							<div class="item-inner" style="margin-left:.6rem;">
								<div class="item-title">
									<h1>调级申请代理</h1></div>
							</div>
						</li>
						<li class="item-content item-link" id="dl_tuijian">
							<div class="item-media"><img src="/Public/Kangli/static/dealer_tj_icon.png" style="width:1rem;height:1rem;"></div>
							<div class="item-inner">
								<div class="item-title">
									<h1>已推荐代理</h1></div>
							</div>
						</li>
					</ul>
				</div>

				<!-- dreanlist -->
				<div class="list-block" style="margin-top:.25rem;margin-bottom: 0rem;">
					<ul>
						<?php if(is_array($dltypelist)): foreach($dltypelist as $key=>$item): if($item["count"] > 0): ?><li class="item-content item-link dl_level_item">
									<div class="item-media"><i class="iconfont icon-tuandui" style="font-size:1rem; color: #006db8;line-height: 1rem;"></i></div>
									<div class="item-inner">
										<div class="item-title">
											<h1><?php echo ($item["dlt_name"]); ?> 代理团队</h1></div>
										<div class="item-after"><span class="kl-badge" style="background-color:red;"><?php echo ($item["count"]); ?></span></div>
									</div>
								</li>
							<?php else: ?>
								<li class="item-content item-link dl_level_item">
									<div class="item-media"><i class="iconfont icon-tuandui" style="font-size:1rem; color: #006db8;line-height: 1rem; "></i></div>
									<div class="item-inner">
										<div class="item-title">
											<h1><?php echo ($item["dlt_name"]); ?> 代理团队</h1></div>
										<div class="item-after"><span class="kl-badge"><?php echo ($item["count"]); ?></span></div>
									</div>
								</li><?php endif; endforeach; endif; ?>
					</ul>
				</div>
				<h2 class="title" style="font-size:.5rem"><?php echo ($dl_count); ?>位团队待审核成员</h2>
				<div class="list-block media-list" style="line-height:1rem;">
					<ul>
						<?php if(is_array($dl_list)): foreach($dl_list as $key=>$item): ?><li>
								<a href="<?php echo U('./Kangli/Dealer/applylist/ls_status/0');?>" class="item-link item-content">
									<div class="item-media"><img class="kl-circle kl-img-thumbnail" src="/Public/uploads/mobi/<?php echo ($item["dl_wxheadimg"]); ?>" style="width:2rem; border-radius: 50%;" onerror="this.src='/Public/Kangli/static/head_icon.png'"></div>
									<div class="item-inner">
										<div class="item-subtitle between-horizontally">
											<span style="color:#7e7e7e"><h1><?php echo ($item["dl_name"]); ?></h1></span><span style="color:#c1c1c1"><?php echo (date('Y-m-d',$item["dl_addtime"])); ?></span></div>
										<div class="item-title" style="color:#c1c1c1">申请加入<span style="color:red"><?php echo ($item["dlt_name"]); ?></span>代理团队</div>
									</div>
								</a>
							</li><?php endforeach; endif; ?>
					</ul>
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
			$('#fw_search').click(function() {
				location.href = "<?php echo U('./Kangli/Query');?>";
			});
			$('#dl_tiaoji').click(function() {
				location.href = "<?php echo U('./Kangli/Dealer/updatedltypeindex/up_status/0');?>";
			});
			$('#dl_tuijian').click(function() {
				location.href = "<?php echo U('./Kangli/Dealer/referee');?>";
			});
			var dltArray = <?php echo json_encode($dltypelist);?>||[];
				// console.log(JSON.stringify(dltArray)+"=="+dltArray.length);
			$('.dl_level_item').each(function(index) {
				// console.log('li %d is:%o',index,this);
				$(this).click(function(){
					if ($.isArray(dltArray)&&dltArray.length>index)
					{
						var dltObject=dltArray[index];
						if ($.isPlainObject(dltObject))
						{
							$.each(dltObject, function(key, val) {
								if(key=="count"&&val>0) {
									 console.log('%s: %s', key, val);
									  console.log(dltObject['dlt_id']);
									 // window.location.href="<?php echo U('./Kangli/Dealer/dealerlist');?>?dltid="+dltObject['dlt_id'];
									 window.location.href="<?php echo U('./Kangli/Dealer/dealerlist/dltid');?>/"+dltObject['dlt_id'];
    							}
    						});
						}

						// $.map(dltArray[index], function(val,key) {
    		// 				if(key=="count"&&val>0) {
    		// 					console.log(JSON.stringify(dltArray[index]));
    		// 				}
						// });
					}
				});
			})


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