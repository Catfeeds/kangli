<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>

	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
		<link rel="shortcut icon" href="/Kangli/Public/Kangli/static/chuanshu_min.png">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-status-bar-style" content="black">
		<meta name="format-detection" content="telephone=no,email=no,adress=no">
		<title><?php echo (C("QY_COMPANY")); ?>-应付返利</title>
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
				<a href="<?php echo U('./Kangli/Fanli');?>" class="icon icon-left pull-left" style="color:#fff"></a>
				<h1 class="title" style="color:#fff">应付返利</h1>
			</header>
			<div class="content">
				<div class="list-block media-list" style="margin: 0.3rem 0;">
				    <ul style="background: transparent;">
					<?php if(is_array($list)): foreach($list as $key=>$item): ?><li class="paylist_item">
				            <div class="kl-layout-horizontally-between" style="width: 100%;margin-bottom: 0.2rem; background: #fff">
				            	<div class="kl-layout-horizontally-between" style="width: 93%;">
	              				    <div class="item-content item-inner">
	              						<div class="item-subtitle" style="margin: .3rem 0"><?php echo ($item["rc_moneystr"]); ?> <span style="font-size:0.7em; font-style:normal; color:#666666">元　　<?php echo (date('Y-m-d H:i:s',$item["rc_addtime"])); ?></span></div>
	            						<div class="item-title"><?php if(!empty($item["fl_rdl_name"])): echo ($item["fl_rdl_name"]); endif; ?> <?php if(!empty($item["fl_rdl_username"])): ?>(<?php echo ($item["fl_rdl_username"]); ?>)<?php endif; ?> <?php echo ($item["rc_str"]); ?></div>
	          						</div>
					 				<p><a href="#" class="button button-fill button-warning button-round" style="padding:0 0.5rem;font-size: .3rem;"><?php echo ($item["rc_statestr"]); ?></a></p>
				           		</div>
				           		<span class="icon icon-right" style="margin: .3rem;"></span>
				            </div>
				      </li><?php endforeach; endif; ?>
				    </ul>
			    </div>
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
		    var payArray = <?php echo json_encode($list);?>;
            $('.paylist_item').each(function(index) {
                // console.log('li %d is:%o',index,this);
                if ($.isArray(payArray)&&payArray.length>index)
                {
                    var payObject=payArray[index];
                    $(this).click(function(){
                        if($.isPlainObject(payObject))
                        {
                            window.location.href="<?php echo U('./Kangli/Fanli/paydetail');?>/"+"rc_id/"+payObject['rc_id'];
                        }
                    }); 
                }
            });
	});
	</script>	
</html>