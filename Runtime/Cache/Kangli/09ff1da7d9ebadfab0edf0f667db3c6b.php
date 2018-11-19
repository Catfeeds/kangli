<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>

	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
		<link rel="shortcut icon" href="/Kangli/Public/Kangli/static/chuanshu_min.png">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-status-bar-style" content="black">
		<meta name="format-detection" content="telephone=no,email=no,adress=no">
		<title><?php echo (C("QY_COMPANY")); ?>分享给朋友</title>
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
			#shareit {
			  -webkit-user-select: none;
			  position: absolute;
			  width: 100%;
			  height: 100%;
			  background: rgba(0,0,0,0.7);
			  text-align: center;
			  top: 0;
			  left: 0;
			  z-index: 999;
			}
		</style>
	</head>

	<body ontouchstart="" style="background-color:#FAFAFA">
		<div class="page">
			<header class="bar bar-nav" style="background-color:#006db2;">
				<!-- <a href="javascript:;" onClick="javascript :history.back(-1);" class="icon icon-left pull-left" style="color:#fff"></a> -->
				<a href="<?php echo U('./Kangli/Dealer/invite');?>" class="icon icon-left pull-left" style="color:#fff"></a>
				<h1 class="title" style="color:#fff">分享给朋友</h1>
			</header>
			<div class="content">
				<div class="kl-layout-center" style="text-align:center; padding-top:10px"><?php echo ($dlt_name); ?> 邀请链接</div>
				<div class="content-block" style="margin-top:0.5rem;margin-bottom:0.5rem;">
					<p>
						<a href="#" id="invite_sumbit" class="button button-fill" style="color: #fff; height:2rem;padding:.4rem;background-color:#006db2;">分享给朋友</a>
					</p>
				</div>
				<div class="kl-layout-center"><span class="icon icon-clock" style="color: red;margin: .3rem; font-size: 1rem;"></span> <span id="timingtxt" >链接有效倒计时：</span><span id="timing"><?php echo ($timing); ?></span></div>
			</div>
			<div id="shareit" style="display:none">
  				<img src="/Kangli/Public/Kangli/static/fenxiang.png"  style="width: 242px; height: 180px;float: right;clear: both;">
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
			var dl_level="<?php echo ($dl_level); ?>";
			console.log(dl_level);
			var listArray = <?php echo json_encode($dltypelist);?>||[]; //注意，这里不要用双引号或单引号；
			var nTypeArry=[];
			var idTypeArry=[];
				if($.isArray(listArray)&&listArray.length>0){
					console.log(JSON.stringify(listArray));
					listArray.forEach(function(val,index) {
						if (dl_level<=2)
						{
							nTypeArry.push(val.dlt_name);
							idTypeArry.push(val.dlt_id);
						}else if (val.dlt_level>=dl_level)
						{
							nTypeArry.push(val.dlt_name);
							idTypeArry.push(val.dlt_id);
						}
					});
				}
			$('#dlt_type').val('');
			$('#dlt_type').picker({
				toolbarTemplate: '<header class="bar bar-nav">\<button class="button button-link pull-right close-picker">确定</button>\<h1 class="title">请选择代理级别</h1>\</header>',
				formatValue:function (p,values,displayValues) {
					$("#dltype").val(values[0]);
        			// return displayValues[0] +' '+values[0];
        			return displayValues[0];
    			},
				cols: [{
					textAlign: 'center',
					values: idTypeArry,
					displayValues:nTypeArry
				}]
			});



		 //计时
		    var timing = $("#timing");
		    function startTime() {
				var count = parseInt(timing.text());
				if(count > 0){
					  count--;
					  timing.text(count);
				}else{
					stopTime();
					// mpoptips("该邀请链接已过期","warn",2000);
					$.toast("该邀请链接已过期");
					$("#timing").hide();
					$("#timingtxt").text('该邀请链接已过期');
					return false; 
				}
			}
			
		    var monitorInterval = null;
			monitorInterval = setInterval(startTime, 1000);
			
			//删除计时
			function stopTime() {
			  if (monitorInterval) {
				  clearInterval(monitorInterval);
				  monitorInterval = null;
			  }
			}
			
			//点击分享按钮
		    $("#sharelinks").click(function(){
			     var count = parseInt($("#timing").text());
				 if(count<=0){
					stopTime();
					$.toast("该邀请链接已过期");
					// mpoptips("该邀请链接已过期","warn",2000);
					$("#timing").hide();
					$("#timingtxt").text('该邀请链接已过期');
					return false; 
				 }
				 
			     $("#shareit").show();
			
			});
			
			$("#shareit").click(function() {
			    $("#shareit").hide();
			});
			
			var sharelinksArray = <?php echo json_encode($sharelinkslist);?>;
            $('.sharelinks_item').each(function(index) {
                // console.log('li %d is:%o',index,this);
                if ($.isArray(sharelinksArray)&&sharelinksArray.length>index)
                {
                    var sharelinksObject=sharelinksArray[index];
                    $(this).click(function(){
                        if($.isPlainObject(sharelinksObject))
                        {
                            window.location.href="<?php echo U('./Kangli/Dealer/marklinks');?>/"+"slid/"+sharelinksObject['sl_id'];
                        }
                    }); 
                }
            });

			//点击提交
   	 		$("#invite_sumbit").click(function(){
   	 			var count = parseInt($("#timing").text());
				if(count<=0){
					stopTime();
					$.toast("该邀请链接已过期"); 
					$("#timing").hide();
					$("#timingtxt").text('该邀请链接已过期');
					return false; 
				 } 
			     $("#shareit").show();
   	 		});

			$("#shareit").click(function() {
			    $("#shareit").hide();
			});

	});
	</script>
	<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
	<script type="text/javascript" language="javascript" >
	  /*
	   * 注意：
	   * 1. 所有的JS接口只能在公众号绑定的域名下调用，公众号开发者需要先登录微信公众平台进入“公众号设置”的“功能设置”里填写“JS接口安全域名”。
	   * 2. 如果发现在 Android 不能分享自定义内容，请到官网下载最新的包覆盖安装，Android 自定义分享接口需升级至 6.0.2.58 版本及以上。
	   * 3. 常见问题及完整 JS-SDK 文档地址：http://mp.weixin.qq.com/wiki/7/aaa137b55fb2e0456bf8dd9148dd613f.html
	   *
	   * 开发中遇到问题详见文档“附录5-常见错误及解决办法”解决，如仍未能解决可通过以下渠道反馈：
	   * 邮箱地址：weixin-open@qq.com
	   * 邮件主题：【微信JS-SDK反馈】具体问题
	   * 邮件内容说明：用简明的语言描述问题所在，并交代清楚遇到该问题的场景，可附上截屏图片，微信团队会尽快处理你的反馈。
	   */
	  wx.config({
	    debug:false,
	    appId: '<?php echo ($signPackage["appId"]); ?>',
	    timestamp: <?php echo ($signPackage["timestamp"]); ?>,
	    nonceStr: '<?php echo ($signPackage["nonceStr"]); ?>',
	    signature: '<?php echo ($signPackage["signature"]); ?>',
	    jsApiList: [
		    'checkJsApi',
			'onMenuShareAppMessage',
			'scanQRCode',
			'hideMenuItems'
	      // 所有要调用的 API 都要加到这个列表中
	    ]
	  });
	  
	  wx.ready(function () {
	    // 在这里调用 API
	  // 1 判断当前版本是否支持指定 JS 接口，支持批量判断
	      wx.checkJsApi({
	      jsApiList: [
	        'scanQRCode',
			'onMenuShareAppMessage',
			'hideMenuItems'
	      ],
	      success: function (res) {

	      },
		  fail:function (res) {
		     alert("微信版本比较低，不支持该功能");
		  }
	    });

	    //隐藏右上角部分菜单
		wx.hideMenuItems({
	        menuList: [
			           'menuItem:share:timeline',
					   'menuItem:share:qq',
					   'menuItem:favorite',
					   'menuItem:share:weiboApp',
					   'menuItem:share:facebook',
					   'menuItem:share:QZone',
					   'menuItem:openWithQQBrowser',
					   'menuItem:share:email',
					   'menuItem:openWithSafari',
					   'menuItem:copyUrl'
					   ] 
	    });
	  // 分享
			wx.onMenuShareAppMessage({
			title: '<?php echo ($shtitle); ?>', // 分享标题
			desc: '<?php echo ($shdesc); ?>', // 分享描述
			link: '<?php echo ($shlink); ?>', // 分享链接
			imgUrl: '<?php echo ($shimgurl); ?>', // 分享图标
			type: 'link', // 分享类型,music、video或link，不填默认为link
			dataUrl: '', // 如果type是music或video，则要提供数据链接，默认为空
			success: function () { 
				// 用户确认分享后执行的回调函数
			},
			cancel: function () { 
				// 用户取消分享后执行的回调函数
			}

			});

	  });
	  wx.error(function (res) {
			alert(res.errMsg);
		});
		


	</script>
	
</html>