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
					<i class="iconfont icon-weibiaoti--copy" style="font-size:4rem; color: #0068b4;line-height: 3rem;margin-top:2rem;"></i>
					<span style="padding: .8rem;font-size:.8rem;color: #7e7e7e"><?php echo (C("QY_COMPANY")); ?></span>
				</div>
				<div class="kl-layout-null" style="padding-left:1.5rem;padding-right:1.5rem;">
					<i class="iconfont icon-user" style="font-size:2rem;color: #7e7e7e;line-height:2rem;"></i>
					<div class="kl-line-bottom-main">
						<input id="user_name" class="input kl-login-input" type="text" value="<?php echo ($dl_username); ?>" readonly>
					</div>
				</div>
				<div class="kl-layout-null" style="padding-left:1.5rem;padding-right:1.5rem;">
					<i class="iconfont icon-mima-copy" style="font-size:1.3rem;color: #7e7e7e;line-height:2rem;margin-left:0.3rem;margin-right: .3rem"></i>
					<div class="kl-line-bottom-main">
						<div class="between-horizontally">
							<div class="row">
								<div class="col-85"><input id="oldpwd" class="input kl-login-psw-input" type="password" placeholder="输入您的旧密码"></div>
								<div class="col-15"><i id="showoldpwd" class="iconfont icon-biyan" style="font-size:1.3rem;color: #7e7e7e;line-height:1rem;"></i></div>
							</div>
						</div>
					</div>
				</div>
				<div class="kl-layout-null" style="padding-left:1.5rem;padding-right:1.5rem;">
					<i class="iconfont icon-mima-copy" style="font-size:1.3rem;color: #7e7e7e;line-height:2rem;margin-left:0.3rem;margin-right: .3rem"></i>
					<div class="kl-line-bottom-main">
						<div class="between-horizontally">
							<div class="row">
								<div class="col-85"><input id="newpwd" class="input kl-login-psw-input" type="password" placeholder="输入您的新密码"></div>
								<div class="col-15"><i id="shownewpwd" class="iconfont icon-biyan" style="font-size:1.3rem;color: #7e7e7e;line-height:1rem;"></i></div>
							</div>
						</div>
					</div>
				</div>
				<div class="kl-layout-null" style="padding-left:1.5rem;padding-right:1.5rem;">
					<i class="iconfont icon-querenmima" style="font-size:1.3rem;color: #7e7e7e;line-height:2rem;margin-left:0.3rem;margin-right: .3rem"></i>
					<div class="kl-line-bottom-main">
						<div class="between-horizontally">
							<div class="row">
								<div class="col-85"><input id="newpwd2" class="input kl-login-psw-input" type="password" placeholder="输入确认的密码"></div>
								<div class="col-15"><i id="shownewpwd2" class="iconfont icon-biyan" style="font-size:1.3rem;color: #7e7e7e;line-height:1rem;"></i></div>
							</div>
						</div>
					</div>
				</div>
				<div class="content-block" style="margin-top:1rem;margin-bottom:0.3rem;">
					<p>
						<a href="#" id="login_sumbit" class="button button-fill" style="color: #fff; height:2rem;padding:.4rem;background-color:#006db2;">登录</a>
					</p>
				</div>
				<div style="width: 100%;text-align: right; display: none;">
					<a class="tab-item" href="#">
						<span style="padding-left:1rem;padding-right:1rem;color: #7e7e7e">
					     	忘记密码?
						</span>
					</a>
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
			$("#login_sumbit").click(function() {
				if($("#oldpwd").val() == "") {
					$.toast("请输入旧密码");
					return false;
				}
				if($("#newpwd").val() == "") {
					$.toast("请输入新密码");
					return false;
				}else if ($("#oldpwd").val() == $("#newpwd").val())
				{
					$.toast("新密码不能与旧密码相同");
					return false;
				}

				if($("#newpwd2").val() == "") {
					$.toast("请输入确认的密码");
					return false;
				}

				if($("#newpwd2").val() != $("#newpwd").val()) {
					$.toast("两次输入新密码不一致");
					return false;
				}

				var oldpwd = $("#oldpwd").val();
				var newpwd = $("#newpwd").val();
				var newpwd2 = $("#newpwd2").val();

				try {
					$.ajax({
						type: 'POST',
						url: '<?php echo U("./Kangli/Dealer/updatepwd");?>',
						data: {
							action: 'save',
							oldpwd: oldpwd,
							newpwd: newpwd,
							newpwd2: newpwd2
						},
						dataType: 'json',
						timeout: 30000,
						success: function(data) {
							var stat = 0;
							stat = parseInt(data.stat);
							if(stat == 1) {
								$.toast('修改密码成功');
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

			$("#showoldpwd").click(function() {
				if($(this).hasClass('icon-biyan')){
           		   $(this).removeClass('icon-biyan').addClass('icon-yanjing--copy');//密码可见
           		   $("#oldpwd").prop('type','text');
       			}else{
           			$(this).removeClass('icon-yanjing--copy').addClass('icon-biyan');//密码不可见
           			$("#oldpwd").prop('type','password');
       			};
			});
			$("#shownewpwd").click(function() {
				if($(this).hasClass('icon-biyan')){
           		   $(this).removeClass('icon-biyan').addClass('icon-yanjing--copy');//密码可见
           		   $("#newpwd").prop('type','text');
       			}else{
           			$(this).removeClass('icon-yanjing--copy').addClass('icon-biyan');//密码不可见
           			$("#newpwd").prop('type','password');
       			};
			});
			$("#shownewpwd2").click(function() {
				if($(this).hasClass('icon-biyan')){
           		   $(this).removeClass('icon-biyan').addClass('icon-yanjing--copy');//密码可见
           		   $("#newpwd2").prop('type','text');
       			}else{
           			$(this).removeClass('icon-yanjing--copy').addClass('icon-biyan');//密码不可见
           			$("#newpwd2").prop('type','password');
       			};
			});
		});
	</script>

</html>