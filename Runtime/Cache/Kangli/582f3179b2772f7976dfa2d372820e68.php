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
			<?php echo (C("QY_COMPANY")); ?>防伪查询</title>
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
			
			.list-block .item-media+.item-inner {
				min-height: 2.5rem;
			}
		</style>
	</head>

	<body ontouchstart="" style="background-color:#FAFAFA">
		<div class="page">
			<header class="bar bar-nav" style="background-color: #006db2;">
				<!-- <a href="#" onclick="self.location=document.referrer;" class="icon icon-left pull-left" style="color:#fff"></a> -->
				<a href="<?php echo U('./Kangli/Index');?>" class="icon icon-left pull-left" style="color:#fff"></a>
				<h1 class="title" style="color:#fff">防伪查询</h1>
			</header>
			<div class="content">
				<div class="kl-layout-login" style="height:10rem;">
					<img src="/Kangli/Public/Kangli/static/fw_icon.png" style="width:5rem;height:5rem;line-height:5rem;margin-top:2rem;">
					<!-- <i class="iconfont icon-weibiaoti--copy" style="font-size:4rem; color: #0068b4;line-height: 3rem;margin-top:2rem;"></i> 
					<span style="padding: .8rem;font-size:.8rem;color: #7e7e7e">至信防伪</span>-->
				</div>
				<form action="#">
					<input type="hidden" name="referer" id="referer" value="<?php echo ($referer); ?>" />
					<div class="list-block">
						<ul>
							<!-- Text inputs -->
							<li>
								<div class="item-content">
									<div class="item-media"><i class="iconfont icon-123" style="font-size:1.2rem;color: #7e7e7e;line-height:1.5rem;"></i></div>
									<div class="item-inner">
										<div class="item-input">
											<input type="text" value="<?php echo ($fwcode); ?>" placeholder="请输入防伪码(12位以上的纯数字)" id="fwcode">
										</div>
									</div>
								</div>
							</li>
							<li id="checkcode_li" <?php if($is_checkcode == 0): ?>style="display:none"<?php endif; ?>>
								<div class="item-content">
									<div class="item-media"><i class="iconfont icon-verification-code" style="font-size:1.2rem;color: #7e7e7e;line-height:1.5rem;"></i></div>
									<div class="item-inner">
										<div class="item-input">
											<input type="text" placeholder="请输入验证码" name="checkcode" value="" id="checkcode">
										</div>
									</div>
									<img alt="点击换另一个" title="点击换另一个" style="width:6rem;vertical-align:middle; cursor:pointer" id="verifyImg" src="<?php echo U('Kangli/Query/verify');?>" />
								</div>
							</li>
						</ul>
					</div>
				</form>
				<div class="content-block" style="margin-top:2rem;margin-bottom:0.3rem;">
					<p>
						<a href="#" id="search_sumbit" class="button button-fill" style="color: #fff; height:2rem;padding:.4rem;background-color:#006db2;">查询</a>
					</p>
				</div>
				<div class="card">
					<div class="card-header"  id="result" style="padding:0.5rem; color:#FF0000;text-align: center;-webkit-box-align: center;margin: 0 auto;<?php if($msg == ''): ?>display:none;<?php endif; ?>"><?php echo ($msg); ?></div>
					<div class="card-content" id="prodata" <?php if($ischuhuo != '1' ): ?>style="display:none"<?php endif; ?>>
						<div class="card-content-inner">
							<div class="list-block">
								<ul>
									<li class="item-content">
										<div class="item-inner">
											<div class="item-title" id="proname">产品名称：<?php echo ($prodata["pro_name"]); ?></div>
										</div>
									</li>
									<li class="item-content">
										<div class="item-inner">
											<div class="item-title" id="dlname">代理姓名：<?php echo ($prodata["dl_name"]); ?></div>
										</div>
									</li>
									<li class="item-content">
										<div class="item-inner">
											<div class="item-title" id="dltname">代理级别：<?php echo ($prodata["dlt_name"]); ?></div>
										</div>
									</li>
									<li class="item-content">
										<div class="item-inner">
											<div class="item-title" id="dlnumber">授权编号：<?php echo ($prodata["dl_number"]); ?></div>
										</div>
									</li>
									<li class="item-content">
										<div class="item-inner">
											<div class="item-title" id="proprice">统一零售价：<?php echo (number_format($prodata["pro_price"],2,'.','')); ?> 元</div>
										</div>
									</li>
								</ul>
							</div>
						</div>
					</div>
					<div class="card-footer" id="guanzhu" <?php if($msg == '' ): ?>style="display:none"<?php endif; ?>><p style="text-align:center;margin: 0 auto"><img src="/Kangli/Public/Kangli/static/weixin.jpg" style="width:40%"><br>长按二维码关注</p></div>
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
			$("#verifyImg").click(function() {
				$("#verifyImg").attr("src", "<?php echo U('Kangli/Query/verify');?>?" + Math.random());
			});

			//点击提交
			$("#search_sumbit").click(function() {

				if($("#fwcode").val() == "") {
					$.toast("请输入防伪码");
					$("#result").html('');
					return false;
				}

				var filter = /^\s*[0-9]{12,27}\s*$/;
				if(!filter.test($("#fwcode").val())) {
					$.toast("防伪码只能填12位以上的纯数字");
					$("#result").html('');
					return false;
				}

				var fwcode = $("#fwcode").val();
				var referer = $("#referer").val();
				var checkcode = $("#checkcode").val();

				$("#result").html("正在查询......");
				$("#search_sumbit").attr("disabled", true);

				try {
					$.ajax({
						type: 'POST',
						url: '<?php echo U("./Kangli/Query/ajaxres");?>',
						data: {
							fwcode: fwcode,
							checkcode: checkcode,
							referer: referer
						},
						dataType: 'json',
						timeout: 30000,
						success: function(data) {
							var stat = 0;
							stat = parseInt(data.stat);
							msg = data.msg;
							$("#checkcode_li").css('display', 'none');
							if(stat == 9) {
								$("#checkcode_li").css('display', 'block');
								$("#checkcode").val("");
								$("#verifyImg").attr("src", "<?php echo U('Kangli/Query/verify');?>?" + Math.random());

							} else if(stat == 1) {
								if(!isEmpty(data.fwc)) {
									msg = "<b>您输入的防伪码：" + data.fwc + "</b><br><b>查询结果："+data.msg+"</b>";
								}
								$("#fwcode").val("");
							}
							if (!isEmpty(msg))
							{
								$("#result").html(msg);
								$("#result").show();
								$("#guanzhu").show();
							}else
							{
								$("#guanzhu").hide();
								$("#result").hide();
							}

							if (!isEmpty(data.ischuhuo)&&parseInt(data.ischuhuo) == 1)
							{
								$("#prodata").show();
								$("#proname").html("产品名称：" + data.prodata.pro_name + "");
								$("#dlname").html("代理名称：" + data.prodata.dl_name + "");
								$("#dltname").html("代理级别：" + data.prodata.dlt_name + "");
								$("#dlnumber").html("授权编号：" + data.prodata.dl_number + "");
								if(data.prodata.pro_price != "") {
									$("#proprice").html("统一零售价：" + data.prodata.pro_price + " 元");
								}
							}else
							{
								$("#proname").html("产品名称：");
								$("#dlname").html("代理名称：");
								$("#dltname").html("代理级别：");
								$("#dlnumber").html("授权编号：");
								$("#proprice").html("统一零售价：0.00元");
								$("#prodata").hide();
							}

							setTimeout(btnEnabled, 2000);
						},
						error: function(xhr, type) {
							$.toast("超时或服务错误");
							$("#search_sumbit").attr("disabled", null);
							$("#result").hide();
							return false;
						}
					});

				} catch(e) {
					$.toast(e);
					$("#search").attr("disabled", null);
					$("#result").hide();
					return false;
				}
			});

			function btnEnabled() {
				$("#search_sumbit").attr("disabled", null);
			}
		});
	</script>

</html>