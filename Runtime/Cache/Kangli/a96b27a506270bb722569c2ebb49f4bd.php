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
			<?php echo (C("QY_COMPANY")); ?>-
				<?php echo ($addtitle); ?>
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
			
			.list-block .item-title.label {
				width: 25%;
			}
		</style>
	</head>

	<body ontouchstart="" style="background-color:#FAFAFA">
		<div class="page">
			<header class="bar bar-nav" style="background-color:#006db2;">
				<a href="javascript:;" onClick="javascript :history.back(-1);" class="icon icon-left pull-left" style="color:#fff"></a>
				<!-- <a href="<?php echo U('./Kangli/Dealer');?>" class="icon icon-left pull-left" style="color:#fff"></a> -->
				<h1 class="title" style="color:#fff"><?php echo ($addtitle); ?></h1>
			</header>
			<div class="content">
				<div class="list-block" style="margin-top:0.3rem;margin-bottom:0.3rem;">
					<ul>
						<li>
							<div class="item-content">
								<div class="item-media"><i class="icon icon-form-name"></i></div>
								<div class="item-inner">
									<div class="item-title label">
										<h1>姓名</h1></div>
									<div class="item-input">
										<input id="dl_name" name="dl_name" type="text" value="<?php echo ($addressinfo["dladd_contact"]); ?>" placeholder="请填写姓名" style="font-size: 0.5rem">
									</div>
								</div>
							</div>
						</li>
						<li>
							<div class="item-content">
								<div class="item-media"><i class="icon icon-form-name"></i></div>
								<div class="item-inner">
									<div class="item-title label">
										<h1>联系电话</h1></div>
									<div class="item-input">
										<input id="dl_tel" name="dl_tel" type="text" value="<?php echo ($addressinfo["dladd_tel"]); ?>" placeholder="请填写手机号" style="font-size: 0.5rem">
									</div>
								</div>
							</div>
						</li>
						<li>
							<div class="item-content">
								<div class="item-media"><i class="icon icon-form-name"></i></div>
								<div class="item-inner">
									<div class="item-title label">
										<h1>所在地区</h1></div>
									<div class="item-input">
										<input id="dl_prov" name="dl_prov" value="<?php echo ($addressinfo["dladd_sheng"]); ?>" type="hidden">
										<input id="dl_city" name="dl_city" value="<?php echo ($addressinfo["dladd_shi"]); ?>" type="hidden">
										<input id="dl_area" name="dl_area" value="<?php echo ($addressinfo["dladd_qu"]); ?>" type="hidden">
										<input id="dl_area_all" name="dl_area_all" value="<?php echo ($addressinfo["dladd_diqustr"]); ?>" type="text" placeholder="请选择地区" readonly style="font-size: 0.5rem">
									</div>
									<i class="iconfont icon-down-copy" style="font-size:1rem;"></i>
								</div>
							</div>
						</li>
						<li>
							<div class="item-content">
								<div class="item-media"><i class="icon icon-form-name"></i></div>
								<div class="item-inner">
									<div class="item-title label">
										<h1>收货地址</h1></div>
									<div class="item-input">
										<input id="dl_address" name="dl_address" value="<?php echo ($addressinfo["dladd_address"]); ?>" type="text" placeholder="请填写收货的详细地址" style="font-size: 0.5rem">
									</div>
								</div>
							</div>
						</li>
					</ul>
				</div>
				<!--修改-->
				<?php if($dladd_id > 0): ?><div class="kl-layout-horizontally-between" style="padding:0 0.5rem;">
					<input id="dladd_default" name="dladd_default" value="<?php echo ($addressinfo["dladd_default"]); ?>" type="hidden">
					<div class="kl-layout-horizontally-vcenter" id="address_default">
						<?php if($addressinfo["dladd_default"] == 1): ?><i class="iconfont icon-xuanze" id="address_default_icon" style="font-size:1rem;margin-left:0.75rem;margin-right:0.5rem;color: #7e7e7e"></i>
						<?php else: ?>
							<i class="iconfont icon-xuanze1" id="address_default_icon" style="font-size:1rem;margin-left:0.75rem;margin-right:0.5rem;color: #7e7e7e"></i><?php endif; ?>
						<span style="font-size: 0.3rem;color: #7e7e7e;">默认地址</span>
					</div>
					<i class="iconfont icon-shanchu" id="address_del" style="font-size:1.2rem;margin-right:0.3rem;color: #7e7e7e;"></i>
				</div>
				<?php else: ?>
					<!--增加-->
					<div class="kl-layout-horizontally-between" style="padding:0 0.5rem;">
						<input id="dladd_default" name="dladd_default" value="1" type="hidden">
						<div class="kl-layout-horizontally-vcenter" id="address_default">
							<i class="iconfont icon-xuanze" id="address_default_icon" style="font-size:1rem;margin-left:0.75rem;margin-right:0.5rem;color: #7e7e7e"></i>
							<span style="font-size: 0.3rem;color: #7e7e7e;">默认地址</span>
						</div>
						<?php if($dladd_id > 0): ?><i class="iconfont icon-shanchu" id="address_del" style="font-size:1.2rem;margin-right:0.3rem;color: #7e7e7e;"></i><?php endif; ?>
					</div><?php endif; ?>
				<div class="content-block" id="save_address" style="margin-top:2rem;margin-bottom:0.5rem;">
					<p>
						<a href="#" class="button button-fill" style="color: #fff; height:2rem;padding:.4rem;background-color:#006db2;">
							<?php if($dladd_id > 0): ?>保存地址
								<?php else: ?>新增地址<?php endif; ?>
						</a>
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

	<script type='text/javascript' src='/Kangli/Public/Kangli/js/AreaData_min.js' charset='utf-8'></script>
	<script type='text/javascript' src='/Kangli/Public/Kangli/js/sm-city-picker.min.js' charset='utf-8'></script>
	<script type="text/javascript">
		$.init();
		$(function() {
			$("#dl_area_all").cityPicker({
				toolbarTemplate: '<header class="bar bar-nav">\<button class="button button-link pull-right close-picker">确定</button>\<h1 class="title">请选择所在地区</h1>\</header>',
				formatValue: function(p, values, displayValues) {
					var provID = 0;
					var cityID = 0;
					var areaID = 0;
					// console.log(values[0]+""+values[1]+""+values[2]);
					if($.isArray(area_array) && area_array.length > 0) {
						area_array.forEach(function(val, index) {
							if(val.indexOf(values[0]) >= 0) {
								provID = index;
								console.log(values[0] + '==' + index);
							}
						});
					}

					var cityArray = sub_array[provID];
					if($.isArray(cityArray) && cityArray.length > 0) {
						cityArray.forEach(function(val, index) {
							if(!isEmpty(val) && val.indexOf(values[1]) >= 0) {
								cityID = index;
								console.log(values[1] + '==' + index);
							}
						});
					}
					var areaArray = sub_arr[cityID];
					if($.isArray(areaArray) && areaArray.length > 0) {
						areaArray.forEach(function(val, index) {
							if(!isEmpty(val) && val.indexOf(values[2]) >= 0) {
								console.log(values[2] + '==' + index);
								areaID = index;
							}
						});
					}
					$("#dl_prov").val(provID);
					$("#dl_city").val(cityID);
					$("#dl_area").val(areaID);
					$("#dl_address").val(values[0] + '' + values[1] + '' + values[2]);
					return values[0] + ' ' + values[1] + ' ' + values[2];
				},
			});







			$("#address_default").click(function() {
				var dladd_default = $('#dladd_default').val();
				if(parseInt(dladd_default) == 1) {
					$('#dladd_default').val("0");
					if($('#address_default_icon').hasClass("icon-xuanze")) {
						$('#address_default_icon').addClass("icon-xuanze1");
						$('#address_default_icon').removeClass("icon-xuanze");
					}
				} else {
					$('#dladd_default').val("1");
					if($('#address_default_icon').hasClass("icon-xuanze1")) {
						$('#address_default_icon').addClass("icon-xuanze");
						$('#address_default_icon').removeClass("icon-xuanze1");
					}
				}
				// $.toast('默认地址'+parseInt(dladd_default));
				// window.location.href="<?php echo U('./Kangli/Orders/updateaddress/fromod');?>/"+fromod;
			});
			$("#address_del").click(function() {
				$.confirm('确定删除该地址吗?', function () {
					var addid="<?php echo ($dladd_id); ?>";
					var fromod ="<?php echo ($fromod); ?>";
					window.location.href="<?php echo U('./Kangli/Orders/deleteaddress/addid');?>/"+addid+"/fromod/"+fromod;
            	});
			});
			//点击提交
			$("#save_address").click(function() {
				if($("#dl_name").val() == "") {
					$.toast("请填写姓名");
					return false;
				}
				// if($("#dl_area_all").val() == ""){
				// 	$.toast("请选择所在地区");
				// 	return false;
				// }

				if($("#dl_address").val() == "") {
					$.toast("请填写收货地址");
					return false;
				}

				if($("#dl_tel").val() == "") {
					$.toast("请填写手机号");
					return false;
				}


				var dladd_contact = $("#dl_name").val();
				var dladd_tel = $("#dl_tel").val();
				var dladd_address = $("#dl_address").val()||0;
				var dladd_id ="<?php echo ($dladd_id); ?>";
				var fromod ="<?php echo ($fromod); ?>";
				var diqustr = $("#dl_area_all").val();
				var dl_prov = $("#dl_prov").val();
				var dl_city = $("#dl_city").val();
				var dl_area =  $("#dl_area").val();
				var ad_default=$('#dladd_default').val();
				// console.log(ad_default);
				try {
					$.ajax({
						type: 'POST',
						url: '<?php echo U("./Kangli/Orders/saveaddress");?>',
						data: {
							dladd_id:dladd_id,
							dladd_contact:dladd_contact,
							dladd_tel:dladd_tel,
							dladd_address:dladd_address,
							seachprov:dl_prov,
							seachcity:dl_city,
							seachdistrict:dl_area,
							dladd_diqustr:diqustr,
							fromod:fromod,
							dladd_default:ad_default
						},
						dataType: 'json',
						timeout: 30000,
						success: function(data) {
							var stat = 0;
							stat = parseInt(data.stat);
							if(stat == 1) {
								location.href ="<?php echo U('./Kangli/Orders/dladdress/dladd_id');?>/"+dladd_id+"/fromod/"+fromod;
								return false;
							} else if(stat == 2) {
								$.toast(data.msg);
								// location.href = "<?php echo U('./Kangli/Dealer/login');?>";
								return false;
							} else {
								$.toast(data.msg);
								return false;
							}
						},
						error: function(xhr, type) {
							$.toast("超时或服务错误");
							return false;
						}
					});
				} catch(e) {
					$.toast(e);
					return false;
				}

			});
		});
	</script>

</html>