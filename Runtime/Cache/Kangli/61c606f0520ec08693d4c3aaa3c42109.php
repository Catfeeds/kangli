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
			<?php echo (C("QY_COMPANY")); ?>-代理调级</title>
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
				<?php if($back == 1): ?><a href="<?php echo U('./Kangli/Mine');?>" class="icon icon-left pull-left" style="color:#fff"></a>
				<?php else: ?>
					<a href="<?php echo U('./Kangli/Dealer');?>" class="icon icon-left pull-left" style="color:#fff"></a><?php endif; ?>	
				<h1 class="title" style="color:#fff">代理调级</h1>
				<button class="button button-link button-nav pull-right" id="dl_updateapply">
                    <span class="iconfont icon-shenqing" style="color: #fff;font-size: 1.2rem"></span>
                </button>
			</header>
			<div class="content">
				<!-- pie chart -->
				<div class="buttons-tab">
					<a href="#tab1" id="dl_shenqing" class="tab-link active button">
						<div>
							<h1>代理申请</h1></div>
					</a>
					<a href="#tab2" id="my_shenqing" class="tab-link button">
						<div>
							<h1>我的申请</h1>
						</div>
					</a>
				</div>
				<div class="content-block">
					<div class="tabs">
						<div id="tab1" class="tab active">
							<div class="list-block" style="line-height:1rem; margin-top:.25rem;margin-bottom: 0rem;">
								<ul>
									<?php if(is_array($applydltypelist)): foreach($applydltypelist as $key=>$item): ?><li class="item-content item-link dl_update_item">
                                        <div class="item-inner">
                                                <div class="item-subtitle"><h1><?php echo ($item["apply_afterdltype_str"]); ?></h1><div class="item-title" style="color: #c1c1c1">调整后上家:<?php echo ($item["apply_afterbelong_str"]); ?></div></div>
                                                <div class="item-after"><span class="kl-badge" style="padding:0.2rem;background-color: red;"><?php echo ($item["apply_state_str"]); ?></span></div>
                                        </div>
                                        </li><?php endforeach; endif; ?>
								</ul>
							</div>
						</div>
						<div id="tab2" class="tab">
							<div class="list-block" style="line-height:1rem; margin-top:.25rem;margin-bottom: 0rem;">
								<ul>
									<?php if(is_array($applymytypelist)): foreach($applymytypelist as $key=>$item): ?><li class="item-content item-link my_update_item">
                                        <div class="item-inner">
                                                <div class="item-subtitle"><h1><?php echo ($item["apply_afterdltype_str"]); ?></h1><div class="item-title" style="color: #c1c1c1">调整后上家:<?php echo ($item["apply_afterbelong_str"]); ?></div></div>
                                                <div class="item-after"><span class="kl-badge" style="padding:0.2rem;background-color: red;"><?php echo ($item["apply_state_str"]); ?></span></div>
                                        </div>
                                        </li><?php endforeach; endif; ?>
								</ul>
							</div>
						</div>
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
			// $("#dl_tuijian").click();
			var up_status = "<?php echo ($up_status); ?>" || 0;
			if(up_status == 1)
				$("#my_shenqing").click();

			$('#dl_updateapply').click(function() {
				location.href = "<?php echo U('./Kangli/Dealer/updatedltype');?>";
			});

            var dlArray = <?php echo json_encode($applydltypelist);?>||[];
            $('.item-content.item-link.dl_update_item').each(function(index) {
                console.log('li %d is:%o',index,this);
                $(this).click(function(){
                    if ($.isArray(dlArray)&&dlArray.length>index)
                    {
                        var dlObject=dlArray[index];
                        if ($.isPlainObject(dlObject))
                        {
                            // console.log(dlmObject['dl_id']);
                            window.location.href="<?php echo U('./Kangli/Dealer/updatedltypedetail2/apply_id');?>/"+dlObject['apply_id'];
                        }
                    }
                });
            });

             var myArray = <?php echo json_encode($applymytypelist);?>||[];
            $('.item-content.item-link.my_update_item').each(function(index) {
                console.log('li %d is:%o',index,this);
                $(this).click(function(){
                    if ($.isArray(myArray)&&myArray.length>index)
                    {
                        var myObject=myArray[index];
                        if ($.isPlainObject(myObject))
                        {
                            // console.log(dlmObject['dl_id']);
                            window.location.href="<?php echo U('./Kangli/Dealer/updatedltypedetail/apply_id');?>/"+myObject['apply_id'];
                        }
                    }
                });
            });
		});
	</script>

</html>