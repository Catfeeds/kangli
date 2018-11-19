<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>

	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
		<link rel="shortcut icon" href="/Public/Kangli/static/chuanshu_min.png">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-status-bar-style" content="black">
		<meta name="format-detection" content="telephone=no,email=no,adress=no">
		<title><?php echo (C("QY_COMPANY")); ?>-代理登录</title>
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
				<!-- <a href="#" onclick="self.location=document.referrer;" class="icon icon-left pull-left" style="color:#fff"></a> -->
				<a href="<?php echo U('./Kangli/Index');?>" class="icon icon-left pull-left" style="color:#fff"></a>
				<h1 class="title" style="color:#fff">登录</h1>
			</header>
			<input type="hidden" value="<?php echo ($ttamp); ?>" name="ttamp" id="ttamp">
			<input type="hidden" value="<?php echo ($sture); ?>" name="sture" id="sture">
			<div class="content">
				<div class="kl-layout-login" style="height:10rem;">
					<i class="iconfont icon-weibiaoti--copy" style="font-size:4rem; color: #0068b4;line-height: 3rem;margin-top:2rem;"></i>
					<span style="padding: .8rem;font-size:.8rem;color: #7e7e7e"><?php echo (C("QY_COMPANY")); ?></span>
				</div>
				<div class="kl-layout-null" style="padding-left:1.5rem;padding-right:1.5rem;">
					<i class="iconfont icon-user" style="font-size:2rem;color: #7e7e7e;line-height:2rem;"></i>
					<div class="kl-line-bottom-main">
						<input id="user_name" class="input kl-login-input" type="text" placeholder="输入您的帐号">
					</div>
				</div>
				<div class="kl-layout-null" style="padding-left:1.5rem;padding-right:1.5rem;">
					<i class="iconfont icon-mima-copy" style="font-size:1.3rem;color: #7e7e7e;line-height:2rem;margin-left:0.3rem;margin-right: .3rem"></i>
					<div class="kl-line-bottom-main">
						<div class="between-horizontally">
							<div class="row">
								<div class="col-85"><input id="user_psw" class="input kl-login-psw-input" type="password" placeholder="输入您的密码"></div>
								<div class="col-15"><i id="showPassword" class="iconfont icon-biyan" style="font-size:1.3rem;color: #7e7e7e;line-height:1rem;"></i></div>
							</div>
						</div>
					</div>
				</div>
				<div class="kl-layout-null" style="padding-left:1.5rem;padding-right:1.5rem;">
					<span style="padding-left:2rem;padding-right:1.5rem;color: #AFAFAF;margin-top:0.5rem">
					     默认帐号为你的微信帐号<br>
					     默认密码为你的手机号后6位数字<br>
					     首次登录后请更改你的密码
					</span>
				</div>
				<div class="content-block" style="margin-top:1rem;margin-bottom:0.3rem;">
					<p>
						<a href="#" id="login_sumbit" class="button button-fill" style="color: #fff; height:2rem;padding:.4rem;background-color:#006db2;">登录</a>
					</p>
				</div>
				<div style="width: 100%;text-align: right;display: none;">
					<a class="tab-item" href="#">
						<span style="padding-left:1rem;padding-right:1rem;color: #7e7e7e">
					     	忘记密码?
						</span>
					</a>
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
			$("#login_sumbit").click(function() {
				var username = $("#user_name").val();
				var pwd = $("#user_psw").val();
				var ttamp = $("#ttamp").val();
				var sture = $("#sture").val();
				var tagpage='<?php echo ($tagpage); ?>';
				if($("#user_name").val() == '') {
					$.toast("请输入账号");
					return false;
				}
				if($("#user_psw").val() == "") {
					$.toast("请输入密码");
					return false;
				} else {
					if($("#user_psw").val().length < 6) {
						$.toast("请输入正确密码");
						return false;
					}
				}
				try {
					$.ajax({
						type: 'POST',
						url: '<?php echo U("./Kangli/Dealer/login");?>',
						data: {
							action: 'login',
							pwd: pwd,
							username: username,
							ttamp: ttamp,
							sture: sture,
							tagpage:tagpage
						},
						dataType: 'json',
						timeout: 30000,
						success: function(data) {
							var stat = 0;
							stat = parseInt(data.stat);
							if(stat == 1) {
								// setTimeout(function (){
									if (tagpage!="")
									{
										window.location.href=window.atob(tagpage);	
									}else
									{
										window.history.back();  //返回上一页
									}
         						// },1500);
         						// 
							} 
							else {
								$.toast(data.msg);
								// console.log(window.atob(tagpage));
								return false;
							}
						},
						error: function(xhr, type) {
							console.log(xhr);
							console.log(type);
							$.toast("超时或服务错误");
							return false;
						}
					});

				} catch(e) {
					$.toast(e);
					return false;
				}

			});

			$("#showPassword").click(function() {
				if($(this).hasClass('icon-biyan')){
           		   $(this).removeClass('icon-biyan').addClass('icon-yanjing--copy');//密码可见
           		   $("#user_psw").prop('type','text');
       			}else{
           			$(this).removeClass('icon-yanjing--copy').addClass('icon-biyan');//密码不可见
           			$("#user_psw").prop('type','password');
       			};
			});
		});
	</script>

</html>