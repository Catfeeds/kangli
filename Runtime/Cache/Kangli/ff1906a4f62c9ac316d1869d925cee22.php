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
			<?php echo (C("QY_COMPANY")); ?>-代理申请</title>
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
		</style>
	</head>

	<body ontouchstart="" style="background-color:#FAFAFA">
		<div class="page">
			<header class="bar bar-nav" style="background-color:#006db2;">
				<a href="<?php echo U('./Kangli/Index');?>" class="icon icon-left pull-left" style="color:#fff"></a>
				<h1 class="title" style="color:#fff">代理申请</h1>
			</header>
			<div class="content">
				
				<form action="<?php echo U('./Kangli/Apply/index');?>" action="" enctype="multipart/form-data" method="post" id="fmmm" name="fmmm">
					<input type="hidden" name="ttamp" id="ttamp" value="<?php echo ($ttamp); ?>">
					<input type="hidden" name="sture" id="sture" value="<?php echo ($sture); ?>">
					<input type="hidden" name="action" id="action" value="save">
					<input type="hidden" name="file_name" id="file_name" value="">
					<input type="hidden" name="file_name2" id="file_name2" value="">
					<div class="list-block" style="margin-top:0.25rem;margin-bottom:1rem;">
						<ul>
							<li style="display: none">
								<div class="item-content">
									<div class="item-media"><i class="icon icon-form-name"></i></div>
									<div class="item-inner">
										<div class="item-title label">
											<h1>头像</h1></div>
										<div class="item-input">
											<input id="dl_head_icon" type="hidden">
										</div>
										<img src="/Kangli/Public/Kangli/static/head_icon.png" style="height: 2.5rem;width: 2.5rem;line-height:3rem;">
									</div>
								</div>
							</li>
							<li>
								<div class="item-content">
									<div class="item-media"><i class="icon icon-form-email"></i></div>
									<div class="item-inner">
										<div class="item-title label">
											<h1>代理级别</h1></div>
										<div class="item-input">
											<input type="hidden" name="dlt_id" id="dlt_id" value="">
											<input id="dl_level" type="text" value="" placeholder="请选择代理级别" style="font-size: 0.5rem" readonly>
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
											<h1>姓名</h1></div>
										<div class="item-input">
											<input id="dl_name" name="dl_name" type="text" placeholder="请填写姓名" style="font-size: 0.5rem">
										</div>
									</div>
								</div>
							</li>
							<li>
								<div class="item-content">
									<div class="item-media"><i class="icon icon-form-name"></i></div>
									<div class="item-inner">
										<div class="item-title label">
											<h1>微信号</h1></div>
										<div class="item-input">
											<input id="dl_weixin" name="dl_weixin" type="text" placeholder="请填写微信号" style="font-size: 0.5rem">
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
											<input id="dl_tel" name="dl_tel" type="text" placeholder="请填写手机号" maxlength="11" style="font-size: 0.5rem">
										</div>
									</div>
								</div>
							</li>
							<li>
								<div class="item-content">
									<div class="item-media"><i class="icon icon-form-name"></i></div>
									<div class="item-inner">
										<div class="item-title label">
											<h1>身份证</h1></div>
										<div class="item-input">
											<input id="dl_idcard" name="dl_idcard" type="text" placeholder="请填写身份证" maxlength="18" style="font-size: 0.5rem">
										</div>
									</div>
								</div>
							</li>
							<li>
								<div class="item-content">
									<div class="item-media"><i class="icon icon-form-name"></i></div>
									<div class="item-inner">
										<div class="item-title label">
											<h1>开户银行</h1></div>
										<div class="item-input">
											<input type="hidden" name="dl_bank" id="dl_bank">
											<input id="dl_bankname" name="dl_bankname" type="text" value="" placeholder="请选择开户银行" readonly style="font-size: 0.5rem">
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
											<h1>帐号/卡号</h1></div>
										<div class="item-input">
											<input id="dl_bankcard" name="dl_bankcard" type="text" placeholder="帐号/卡号必须与填写的代理人对应" maxlength="19" style="font-size: 0.5rem">
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
											<input id="dl_prov" name="dl_prov" type="hidden">
											<input id="dl_city" name="dl_city" type="hidden">
											<input id="dl_area" name="dl_area" type="hidden">
											<input id="dl_area_all" name="dl_area_all" type="text" value="" placeholder="请选择地区" readonly style="font-size: 0.5rem">
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
											<input id="dl_address" name="dl_address" type="text" placeholder="请填写收货的详细地址" style="font-size: 0.5rem">
										</div>
									</div>
								</div>
							</li>
							<li>
								<div class="item-content">
									<div class="item-media"><i class="icon icon-form-name"></i></div>
									<div class="item-inner">
										<div class="item-title label">
											<h1>邀请人ID</h1></div>
										<div class="item-input">
											<input id="dl_referee" name="dl_referee" type="text" placeholder="请填写邀请人ID" style="font-size: 0.5rem">
										</div>
									</div>
								</div>
							</li>
						</ul>
					</div>
				</form>
				<div class="content-block" style="margin-top:0.5rem;margin-bottom:0.5rem;">
					<p>
						<a href="#" id="dealer_sumbit" class="button button-fill" style="color: #fff; height:2rem;padding:.4rem;background-color:#006db2;">提交</a>
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

	<script type='text/javascript' src='/Kangli/Public/Kangli/js/sm-city-picker.min.js' charset='utf-8'></script>
	<script type='text/javascript' src='/Kangli/Public/Kangli/js/AreaData_min.js' charset='utf-8'></script>
	<script type="text/javascript">
		$.init();
		$(function() {
            //级别
			var listArray = <?php echo json_encode($dltypelist);?>; //注意，这里不要用双引号或单引号；
			var nTypeArry=[];
			var idTypeArry=[];
				if($.isArray(listArray)&&listArray.length>0){
					// console.log(JSON.stringify(listArray));
					listArray.forEach(function(val,index) {
						nTypeArry.push(val.dlt_name);
						idTypeArry.push(val.dlt_id);
					});
				}
			$('#dl_level').val('');
			$('#dl_level').picker({
				toolbarTemplate: '<header class="bar bar-nav">\<button class="button button-link pull-right close-picker">确定</button>\<h1 class="title">请选择代理级别</h1>\</header>',
				formatValue:function (p,values,displayValues) {
					$("#dlt_id").val(values[0]);
        			// return displayValues[0] +' '+values[0];
        			return displayValues[0];
    			},
				cols: [{
					textAlign: 'center',
					values: idTypeArry,
					displayValues:nTypeArry
				}]
			});



			var bankObject=<?php echo json_encode($bankarr);?>; //注意，这里不要用双引号或单引号；
			var nBankArry=[];
			var idBankArry=[];
			// if (!isEmpty(bankObject)){
				// $.toast('银行');
				// console.log(JSON.stringify(bankObject));
				// if($.isArray(bankArray)&&bankArray.length>0){
				// 	bankArray.forEach(function(val,index) {
				// 		nBankArry.push(val);
				// 		idBankArry.push(index+1);
				// 	});
				// }
				for(var name in bankObject) {
						nBankArry.push(bankObject[name]);
						idBankArry.push(name);
					}
			// }
			$('#dl_bankname').val('');	
			$('#dl_bankname').picker({
				toolbarTemplate: '<header class="bar bar-nav">\<button class="button button-link pull-right close-picker">确定</button>\<h1 class="title">请选择开户银行</h1>\</header>',
				formatValue:function (p,values,displayValues) {
					$("#dl_bank").val(values[0]);
        			// return displayValues[0] +' '+values[0];
        			return displayValues[0];
    			},
				cols: [{
					textAlign: 'center',
					values: idBankArry,
					displayValues:nBankArry
				}]
			});



			$('#dl_area_all').val('');	
			$("#dl_area_all").cityPicker({
    			toolbarTemplate: '<header class="bar bar-nav">\<button class="button button-link pull-right close-picker">确定</button>\<h1 class="title">请选择所在地区</h1>\</header>',
    			formatValue:function (p,values,displayValues) {
    				var provID=0;
    				var cityID=0;
    				var areaID=0;
    				// console.log(values[0]+""+values[1]+""+values[2]);
    				if($.isArray(area_array)&&area_array.length>0){
						area_array.forEach(function(val,index) {
							if (val.indexOf(values[0])>=0)
							{
								provID=index;
								// console.log(values[0]+'=='+index);
							}
						});
					}

					var cityArray=sub_array[provID];
					if($.isArray(cityArray)&&cityArray.length>0){
						cityArray.forEach(function(val,index) {
						if (val.indexOf(values[1])>=0)
							{
								cityID=index;
								// console.log(values[1]+'=='+index);
							}
						});
					}
					var areaArray=sub_arr[cityID];
					if($.isArray(areaArray)&&areaArray.length>0){
						areaArray.forEach(function(val,index) {
						if (val.indexOf(values[2])>=0)
							{
								// console.log(values[2]+'=='+index);
								areaID=index;
							}
						});
					}
					
					$("#dl_prov").val(provID);
					$("#dl_city").val(cityID);
					$("#dl_area").val(areaID);
					$("#dl_address").val(values[0] +''+values[1] +''+values[2]);
        			return values[0] +' '+values[1] +' '+values[2];
    			},
  				});

	 		//点击提交
   	 		$("#dealer_sumbit").click(function(){
			if($("#dlt_id").val() == "") {
				$.toast("请选择代理级别"); 
				return false; 
			}
			
            if($("#dl_name").val() == "") { 
            	$.toast("请填写姓名");
				return false; 
			} 
			 
			if($("#dl_weixin").val() == "") {
				$.toast("请填写微信号");  
				return false; 
			}
			
			
			var filter=/^\s*[a-zA-Z0-9_-]{6,20}\s*$/; 
			if  (!filter.test($("#dl_weixin").val())) { 
				$.toast("请正确填写微信号,支持6-20个字母、数字、下划线和减号");  
				return false; 
			}
		
			
			if($("#dl_tel").val() == "") {
			 	$.toast("请填写手机号");  
				return false; 
			}
			var filter2=/^\s*[0-9]{10,15}\s*$/; 
			if  (!filter2.test($("#dl_tel").val())) {
				$.toast("请正确填写手机号,手机号由11位数字组成");   
				return false; 
			}
			
			
			if($("#dl_idcard").val() == "") {
				$.toast("请填写身份证号");    
				return false; 
			}
			
            var filter=/^[1-9]\d{5}(18|19|([23]\d))\d{2}((0[1-9])|(10|11|12))(([0-2][1-9])|10|20|30|31)\d{3}[0-9Xx]$/; 
			if  (!filter.test($("#dl_idcard").val())) {
				$.toast("请正确填写第二代18位身份证号");     
				return false; 
			}

			if($("#dl_bank").val() == "") {
				$.toast("请选择开户银行");   
				return false; 
			}

			if($("#dl_bankcard").val() == "") {
			 	$.toast("请填写与姓名对应的卡号/账号");
				return false; 
			}else if ($("#dl_bankcard").val().length<11||$("#dl_bankcard").val().length>20)
			{
				$.toast("请填写正确的卡号/账号");
				return false; 
			}
			
			if($("#dl_area_all").val() == "" || $("#dl_area_all").val() == 0) {
				$.toast("请选择所在地区");    
				return false; 
			}
			
			if($("#dl_address").val() == "") {
				$.toast("请填写收货地址");     
				return false; 
			}
			
			if($("#dl_referee").val() == "") {
				$.toast("请填写推荐人编号");   
				return false; 
			}
			
			$("#fmmm").submit(); 
		});

// 			//如果是undefined， null， ''， NaN，false，0，[]，{} ，空白字符串，都返回true，否则返回false
// function isEmpty(v) {
// 	switch(typeof v) {
// 		case 'undefined':
// 			return true;
// 			break;
// 		case 'string':
// 			if(v.replace(/(^[ \t\n\r]*)|([ \t\n\r]*$)/g, '').length == 0) {
// 				return true;
// 			}
// 			if(v == "{}" || v == "[]" || v == "null") {
// 				return true;
// 			}
// 			break;
// 		case 'boolean':
// 			if(!v) return true;
// 			break;
// 		case 'number':
// 			if(0 === v || isNaN(v)) return true;
// 			break;
// 		case 'object':
// 			if(null === v || v.length === 0) {
// 				return true;
// 			}
// 			for(var i in v) {
// 				if(v.hasOwnProperty(i)) {
// 					return false;
// 				}
// 			}
// 			return true;
// 			break;
// 	}
// 	return false;
// }
		});
	</script>

</html>