<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>

	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
		<link rel="shortcut icon" href="/Kangli/Public/Kangli/static/chuanshu_min.png">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-status-bar-style" content="black">
		<meta name="format-detection" content="telephone=no,email=no,adress=no">
		<title><?php echo (C("QY_COMPANY")); ?>-反馈</title>
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
			
			.list-block .item-title.label {
				width: 25%;
			}
			
			input::-ms-input-placeholder {
				color: #AFAFAF;
				font-size: .7rem;
			}
			
			input::-webkit-input-placeholder {
				color: #AFAFAF;
				font-size: .7rem;
			}

			textarea::-ms-input-placeholder {
				color: #AFAFAF;
				font-size: .7rem;
			}
			
			textarea::-webkit-input-placeholder {
				color: #AFAFAF;
				font-size: .7rem;
			}
		</style>
	</head>

	<body ontouchstart="" style="background-color:#FAFAFA">
		<div class="page">
			<header class="bar bar-nav" style="background-color:#006db2;">
				<!-- <a href="javascript:;" onClick="javascript :history.back(-1);" class="icon icon-left pull-left" style="color:#fff"></a> -->
				<a href="<?php echo U('./Kangli/Mine');?>" class="icon icon-left pull-left" style="color:#fff"></a>
				<h1 class="title" style="color:#fff">反馈</h1>
			</header>
			<div class="content">
				<form action="#">
<input type="hidden" name="ttamp" id="ttamp" value="<?php echo ($ttamp); ?>">
<input type="hidden" name="sture" id="sture" value="<?php echo ($sture); ?>">
				 <div class="list-block" style="margin: .3rem 0">
				    <ul>
				      <!-- Text inputs -->
				      <li>
				        <div class="item-content">
				          <div class="item-inner">
				            <div class="item-title label">你的姓名</div>
				            <div class="item-input">
				              <input type="text" placeholder="请输入你的姓名" id="fb_contact" >
				            </div>
				          </div>
				        </div>
				      </li>
				      <li>
				        <div class="item-content">
				          <div class="item-inner">
				            <div class="item-title label">联系电话</div>
				            <div class="item-input">
				              <input type="text" maxlength="11" placeholder="请输入你的联系电话" id="fb_tel">
				            </div>
				          </div>
				        </div>
				      </li>
				      <li>
				        <div class="item-content">
				          <div class="item-inner">
				            <div class="item-title label">腾讯QQ</div>
				            <div class="item-input">
				              <input type="text" placeholder="请输入你的腾讯QQ" id="fb_qq">
				            </div>
				          </div>
				        </div>
				      </li>
				 	 <li>
				        <div class="item-content">
				          <div class="item-inner">
				            <div class="item-title label">Email</div>
				            <div class="item-input">
				              <input type="Email" placeholder="请输入你的Email" id="fb_email">
				            </div>
				          </div>
				        </div>
				      </li>
				      </li>
				      <li class="align-top">
				        <div class="item-content">
				          <div class="item-inner">
				            <div class="item-title label">反馈内容</div>
				            <div class="item-input">
				              <textarea placeholder="请输入反馈内容" id="fb_content"></textarea>
				            </div>
				          </div>
				        </div>
				      </li>
				     <li class="align-top">
				        <div class="item-content">
				        	<div class="kl-layout-horizontally-vcenter">
						        <div class="item-title label">验证码</div>
								<div class="item-inner">
									<div class="item-input"><input type="text" placeholder="请输入验证码" maxlength="4" name="checkcode" value="" id="checkcode"></div>
								</div>
								<img alt="点击换另一个" title="点击换另一个" style="width:6rem;vertical-align:middle; cursor:pointer" id="verifyImg" src="<?php echo U('Kangli/Query/verify');?>"/>
							</div>
				        </div>
				      </li>
				    </ul>
				</div>
				</form>
				<div class="content-block" style="margin-top:0.5rem;margin-bottom:0.5rem;">
					<p>
						<a href="#" id="feedback" class="button button-fill" style="color: #fff; height:2rem;padding:.4rem;background-color:#006db2;">确认提交</a>
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
			//点击提交
    $("#feedback").click(function(){
	
			if($("#fb_contact").val() == "") {
				$.toast('请填写您的姓名'); 
				return false; 
			}
			
            if($("#fb_tel").val() == "") {
           	 	$.toast('请填写联系电话');  
				return false; 
			} 
			 
			if($("#fb_content").val() == "") { 
				$.toast('请填写反馈内容'); 
				return false; 
			}

			if($("#checkcode").val() == "") { 
				$.toast('请填写验证码'); 
				return false; 
			}

			
			
			var ttamp = $("#ttamp").val();
			var sture = $("#sture").val();
			var fb_contact = $("#fb_contact").val();
			var fb_tel = $("#fb_tel").val();
			var fb_qq = $("#fb_qq").val();
			var fb_email = $("#fb_email").val();
			var fb_content = $("#fb_content").val();
			var checkcode = $("#checkcode").val();
			
            try {
				$.ajax({
					type: 'POST',
					url: '<?php echo U('./Kangli/Feedback/index');?>',
					data: {action: 'save', fb_contact:fb_contact, fb_tel:fb_tel, fb_qq:fb_qq, fb_email:fb_email, fb_content:fb_content, checkcode:checkcode, ttamp:ttamp, sture:sture },
					dataType: 'json',
					timeout: 30000,
					success: function (data) {
						var stat=0;
						stat=parseInt(data.stat);
						if (stat == 1) {
							$.toast(data.msg);
						     location.href = "<?php echo U('./Kangli/Mine');?>";
						}else if(stat == 2){
							$.toast(data.msg);
							 location.href = "<?php echo U('./Kangli/index');?>";
						}else{
							$.toast(data.msg);
							 return false; 
						}
					},
					error: function (xhr, type) {
						$.toast('超时或服务错误');
						return false; 
					}
				});

			} catch (e) {
				mpoptips(e,"warn",2000);
				return false; 
			}
	
		});

    	$("#verifyImg").click(function(){
			$("#verifyImg").attr("src","<?php echo U('Kangli/Feedback/verify');?>?"+ Math.random());
		});
	});
	</script>	
</html>