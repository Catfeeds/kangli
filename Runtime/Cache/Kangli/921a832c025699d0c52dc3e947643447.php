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
			<?php echo (C("QY_COMPANY")); ?>-扫描出货</title>
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
			
			div.panel,
			p.flip {
				margin: 0px;
				padding: 5px;
				text-align: center;
				background: #e5eecc;
				border: solid 1px #c3c3c3;
			}
			
			div.panel {
				height: 220px;
				display: none;
			}

      .modal-button {
        font-size: .5rem;
      }
		</style>
	</head>

	<body ontouchstart="" style="background-color:#FAFAFA">
		<div class="page">
			<header class="bar bar-nav" style="background-color:#006db2;">
				<!-- <a href="javascript:;" onClick="javascript :history.back(-1);" class="icon icon-left pull-left" style="color:#fff"></a> -->
				<a href="<?php echo U('./Kangli/Orders/dlorders/');?>" class="icon icon-left pull-left" style="color:#fff"></a>
				<h1 class="title" style="color:#fff">扫描出货</h1>
				<button class="button button-link button-nav pull-right" id="scanQRCode1">
            	<span class="iconfont icon-saoyisao1" style="color: #fff;font-size: 1.5rem"></span>
        		</button>
			</header>
			<div class="content">
				<div class="order-number" style="padding:.5rem;font-size: 1rem;color:#fff;background:#75787f">
					<span>订单号：<?php echo ($ordersinfo["oddt_orderid"]); ?></span>
					<span style="color: #f08519"><?php echo ($item["od_state_str"]); ?></span>
				</div>
				<div class="list-block media-list" style="margin-top:0rem;margin-bottom:0rem;">
					<ul>
						<li>
							<div class="order-list all_odlist" style="border-bottom:.2rem solid #EFEFF4;">
								<div class="order-content" style="padding-bottom: 0.5rem">
									<div class="item-media"><img src="/Public/uploads/mobi/<?php echo ($item2["oddt_propic"]); ?>" style="width:3.5rem;" onerror="this.src='/Public/Kangli/static/logo_icon.png'"></div>
									<div class="order-inner">
										<div class="item-subtitle" style="font-size: 0.5rem">
											<?php echo ($ordersinfo["oddt_proname"]); ?>
										</div>
										<div class="order-remark">
											<div class="kl-layout-horizontally-between">
												<div>
													<div class="pro_name" style="color: red;">￥<span style="font-size:.75rem"><?php echo (number_format($ordersinfo["oddt_dlprice"],2,'.','')); ?></span>
														<?php if($ordersinfo["oddt_price"] > 0): ?><span style="padding-right:.2rem; text-decoration:line-through;color:#c1c1c1">￥<?php echo (number_format($ordersinfo["oddt_price"],2,'.','')); ?></span><?php endif; ?>
													</div>
                          <?php if($ordersinfo["oddt_color"] != ''): ?><div class="pro_name">颜色尺码：<?php echo ($ordersinfo["oddt_color"]); ?> <?php echo ($ordersinfo["oddt_size"]); ?>
                          </div><?php endif; ?>
													<div class="pro_name">订购数量:
														<?php echo ($ordersinfo["oddt_qty"]); ?>
															<?php echo ($ordersinfo["oddt_prounits"]); ?>
																<?php echo ($ordersinfo["oddt_totalqty"]); ?>
													</div>
													<div class="pro_name">已发数量：
														<?php echo ($ordersinfo["oddt_shipqty"]); ?>
													</div>
                         <?php if($scancount > 0): ?><div class="pro_name">已扫条码：
                             <?php echo ($scancount); ?>
                          </div>
                          <div class="pro_name">已扫数量：
                                <?php echo ($scanprocount); ?>
                          </div><?php endif; ?>
												</div>
											</div>
										</div>
									</div>
						</li>
					</ul>
					</div>
					<!-- searchbar -->
					<div class="searchbar" style="margin:.3rem 0.5rem;">
						<a class="button button-fill button-primary searchbar-cancel" style="background:#005fa8;color: #fff">添加</a>
						<div class="search-input">
							<label class="icon icon-code" for="search"></label>
							<input type="search" id='search' name="search" placeholder='手动输入条码' />
						</div>
					</div>
          <?php if(($success != 1) and ($msg != '')): ?><div class="item-inner" style="padding: 0 0.75rem 0 1.75rem;color: red;"><?php echo ($msg); ?></div><?php endif; ?>
          <?php if($scancount > 0): ?><div class="list-block" style="margin-top:0.5rem;">
						<ul>
							<li class="item-content" id="record_code_title">
								<div class="item-inner">
									<div class="item-title">扫描记录(<?php echo ($scancount); ?>)</div>
									<div class="item-after"><span class="icon icon-down" id="record_code_icon"></span></div>
								</div>
							</li>
							<li id="record_code" style="display:none;">
                <?php if(is_array($list)): foreach($list as $key=>$item): ?><div class="item-inner item-title" style="padding:0 .75rem"><?php echo ($jishu++); ?>、<?php echo ($key); ?></span><span><?php echo ($item); ?></span><span class="iconfont icon-shanchu recode_code_del" style="font-size: 1.2rem;color: c1c1c1;"></span></div><?php endforeach; endif; ?>
							</li>
						</ul>
					</div><?php endif; ?>
          <div class="content-block" id="odshipscan_sumbit" style="margin-top:1rem;margin-bottom:0.5rem;">
            <p>
              <a href="#" class="button button-fill" style="color: #fff; height:2rem;padding:.4rem;background-color:#006db2;">下一步出货</a>
            </p>
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
			$('.searchbar-cancel').click(function() {
        var od_id="<?php echo ($ordersinfo["oddt_odid"]); ?>";
        var oddt_id="<?php echo ($ordersinfo["oddt_id"]); ?>";
				var keyword = $("#search").val();
				if(!isEmpty(keyword)) {
					window.location.href ="<?php echo U('./Kangli/Orders/odshipscanres/od_id');?>/" +od_id+"/oddt_id/"+oddt_id+"/brcode/"+keyword;
				}
			});

			//回车提交事件
			$("body").keydown(function() {
				if(event.keyCode == "13") { //keyCode=13是回车键
					$('.searchbar-cancel').click();
				}
			});

			var flag =0;
			$("#record_code_title").click(function() {
          if (0==flag)
          {
              flag=1;
              $(this).css("background","#e9e9e9");
              if($("#record_code_icon").hasClass("icon-down"))
              {
                $("#record_code_icon").removeClass("icon-down");
                $("#record_code_icon").addClass("icon-up");
              }
          }else
          {
              flag=0;
              $(this).css("background","#fff");
              if($("#record_code_icon").hasClass("icon-up"))
              {
                $("#record_code_icon").removeClass("icon-up");
                $("#record_code_icon").addClass("icon-down");
              }
          }
					$("#record_code").toggle();
			});

      var codeObject=<?php echo json_encode($list);?>||{};
      var codeArray=[];
      $.each(codeObject, function(key, value) {
          codeArray.push(key);
      });
      $('.recode_code_del').each(function(index) {
          if ($.isArray(codeArray)&&codeArray.length>index)
          {
              var brcode=codeArray[index];
               $(this).click(function(){
                  var od_id="<?php echo ($ordersinfo["oddt_odid"]); ?>";
                  var oddt_id="<?php echo ($ordersinfo["oddt_id"]); ?>";
                  window.location.href="<?php echo U('./Kangli/Orders/odshipremove/brcode');?>/"+brcode+"/od_id/"+od_id+"/oddt_id/"+oddt_id;
              });
          }
      });

      $('#odshipscan_sumbit').click(function() {
          var scancount="<?php echo ($scancount); ?>";
          if (parseInt(scancount)>0)
          {
            $.confirm('是否已核对订单信息，确定出货吗?',function () {
                var od_id="<?php echo ($ordersinfo["oddt_odid"]); ?>";
                var oddt_id="<?php echo ($ordersinfo["oddt_id"]); ?>";
                window.location.href ="<?php echo U('./Kangli/Orders/odshipping/od_id');?>/" +od_id+"/oddt_id/"+oddt_id+"/step/1";
            });
          }else
          {
            $.toast('请扫描条码再出货！');
          }
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
    timestamp:<?php echo ($signPackage["timestamp"]); ?>,
    nonceStr: '<?php echo ($signPackage["nonceStr"]); ?>',
    signature: '<?php echo ($signPackage["signature"]); ?>',
    jsApiList: [
      'checkJsApi',
    'scanQRCode'
      // 所有要调用的 API 都要加到这个列表中
    ]
  });
  
wx.ready(function () {
    // 在这里调用 API
  // 1 判断当前版本是否支持指定 JS 接口，支持批量判断
    wx.checkJsApi({
	    jsApiList: [
        	'scanQRCode'
      	],
      	success: function (res) {

      	},
	    fail:function (res) {
	       alert("微信版本比较低，不支持该功能");
	    }
    });
  
    // document.querySelector('#scanQRCode1').onclick = function () {
    $('#scanQRCode1').click(function() {
	    // $.toast('调用摄像头');
	    //调用摄像头
	    wx.scanQRCode({
	      	needResult: 1,
	    	scanType: ["barCode","qrCode"], 
	      	success: function (res) {
	       	var result = res.resultStr;
	       	var od_id="<?php echo ($od_id); ?>";
	       	var oddt_id="<?php echo ($oddt_id); ?>";
	      	// self.location.href='http://Kangli.cn315fw.com/Kangli/Orders/odshipscanres?od_id=<?php echo ($od_id); ?>&odbl_id=<?php echo ($odbl_id); ?>&oddt_id=<?php echo ($oddt_id); ?>&brcode='+result; 
	        self.location.href="<?php echo U('./Kangli/Orders/odshipscanres/od_id');?>/"+od_id+"/oddt_id/"+oddt_id+"/brcode/"+result; 
	      	}
	    });
	});
  });
  wx.error(function (res) {
    alert(res.errMsg);
  });
</script>
</html>