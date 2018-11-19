<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>

	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
		<link rel="shortcut icon" href="/Kangli/Public/Kangli/static/chuanshu_min.png">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-status-bar-style" content="black">
		<meta name="format-detection" content="telephone=no,email=no,adress=no">
		<title><?php echo (C("QY_COMPANY")); ?>-
			<?php echo ($title); ?>
		</title>
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
			
			input::-ms-input-placeholder {
				color: #AFAFAF;
				font-size: .7rem;
			}
			
			input::-webkit-input-placeholder {
				color: #AFAFAF;
				font-size: .7rem;
			}
		</style>
	</head>

	<body ontouchstart="" style="background-color:#FAFAFA">
		<div class="page">
			<header class="bar bar-nav" style="background-color: #006db2;">
				<a href="#" onclick="self.location=document.referrer;" class="icon icon-left pull-left" style="color:#fff"></a>
				<!-- <a href="<?php echo U('./Kangli/Index');?>" class="icon icon-left pull-left" style="color:#fff"></a> -->
				<h1 class="title" style="color:#fff"><?php echo ($title); ?></h1>
			</header>
			<div class="content">
				<div class="kl-layout-login" style="height:10rem;">
					<?php if($userInfo["dl_wxheadimg"] != ''): ?><img class="kl-circle kl-img-thumbnail" src="<?php echo ($item["dl_wxheadimg"]); ?>" style="width:3rem;height:3rem;border-radius: 50%;margin-top:.3rem;" onerror="this.src='/Kangli/Public/Kangli/static/head_icon.png'">
					<?php else: ?>
						<i class="iconfont icon-weibiaoti--copy" style="font-size:4rem; color: #0068b4;line-height: 3rem;margin-top:2rem;"></i><?php endif; ?>
					<span style="padding: .8rem;font-size:.8rem;color: #7e7e7e"><?php if($userInfo["dl_wxnickname"] != ''): echo ($userInfo["dl_wxnickname"]); else: echo ($userInfo["dl_name"]); endif; ?></span>
				</div>
				<div class="kl-layout-null" style="padding:0.5rem 1.5rem;background-color:#fff;">
					<span style="width:35%;">用 户 名：</span>
					<input id="user_name" class="input kl-login-input" type="text" value="<?php echo ($userInfo["dl_username"]); ?>" readonly>
				</div>
				<div class="kl-line-bottom-main" style="border-color: #cacaca;margin:0 1.5rem;"></div>
				<div class="kl-layout-null" style="padding:0.5rem 1.5rem;background-color: #fff;">
					<span style="width:35%;">登录密码：</span>
					<input id="oldpwd" class="input kl-login-psw-input" type="password" placeholder="输入您登录密码">
				</div>
				<div class="content-block" style="margin-top:1rem;margin-bottom:0.3rem;">
					<p>
						<a href="#" id="unbindwx_sumbit" class="button button-fill" style="color: #fff; height:2rem;padding:.4rem;background-color:#006db2;">确认解绑</a>
					</p>
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
			$("#unbindwx_sumbit").click(function() {
				if($("#oldpwd").val() == "") {
					$.toast("请输入登录密码");
					return false;
				}
				var oldpwd = $("#oldpwd").val();
				try {
					$.ajax({
						type: 'POST',
						url: '<?php echo U("./Kangli/Mine/unbindwx");?>',
						data: {
							action: 'save',
							oldpwd: oldpwd,
						},
						dataType: 'json',
						timeout: 30000,
						success: function(data) {
							var stat = 0;
							stat = parseInt(data.stat);
							if(stat == 1) {
								$.toast('解绑微信成功');
								location.href = "<?php echo U('./Kangli/Index');?>";
							} else {
								$.toast(data.msg);
								return false;
							}
						},
						error: function(xhr, type) {
							$.toast('超时或服务错误');
							return false;
						}
					});

				} catch(e) {
					mpoptips(e, "warn", 2000);
					return false;
				}

			});
		});
	</script>

</html>