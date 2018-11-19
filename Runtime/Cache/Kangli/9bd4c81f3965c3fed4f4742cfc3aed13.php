<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>

	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
		<link rel="shortcut icon" href="/Kangli/Public/Kangli/static/chuanshu_min.png">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-status-bar-style" content="black">
		<meta name="format-detection" content="telephone=no,email=no,adress=no">
		<title><?php echo (C("QY_COMPANY")); ?>-申请调级</title>
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
			.kl-file {
			    position: relative;
			    display: inline-block;
			    background:transparent;
			    border:.05rem solid #c1c1c1;
			    /*border-radius: 4px;*/
			    margin: .5rem;
			    padding:1.2rem;
			    overflow: hidden;
			    color: #c1c1c1;
			    text-decoration: none;
			    text-indent: 0;
			    line-height: 1.5rem;
			}
			.kl-file input {
			    position: absolute;
			    font-size: 5rem;
			    right: 0;
			    top: 0;
			    opacity: 0;
			}
			.kl-file:hover {
			    background:transparent;
			    border-color: #c1c1c1;
			    color: #c1c1c1;
			    text-decoration: none;
			}

		</style>
	</head>

	<body ontouchstart="" style="background-color:#FAFAFA">
		<div class="page">
			<header class="bar bar-nav" style="background-color:#006db2;">
				<!-- <a href="javascript:;" onClick="javascript :history.back(-1);" class="icon icon-left pull-left" style="color:#fff"></a> -->
				 <a href="<?php echo U('./Kangli/Dealer/updatedltypeindex');?>" class="icon icon-left pull-left" style="color:#fff"></a>
				<h1 class="title" style="color:#fff">申请调级</h1>
			</header>
			<div class="content">
			<form action="<?php echo U('./Kangli/Dealer/updatedltype_save');?>" action="" enctype="multipart/form-data" method="post" id="fmmm" name="fmmm" >
			<input type="hidden" name="ttamp" id="ttamp" value="<?php echo ($ttamp); ?>">
			<input type="hidden" name="sture" id="sture" value="<?php echo ($sture); ?>">
			<input type="hidden" name="file_name" id="file_name"  value="" >
			<input type="hidden" name="okk" id="okk" value="0">

					<div class="list-block" style="margin-top:0.25rem;margin-bottom:1rem;">
						<ul style="background: transparent;">
							<li>
								<div class="item-content">
									<div class="item-media"><i class="icon icon-form-name"></i></div>
									<div class="item-inner">
										<div class="item-title label">
											<h1>当前级别</h1></div>
										<div class="item-input">
											<input id="dl_name" name="dl_name" type="text" value="<?php echo ($dealerinfo["original_name"]); ?>" readonly style="font-size: 0.5rem">
										</div>
									</div>
								</div>
							</li>
							<li>
								<div class="item-content">
									<div class="item-media"><i class="icon icon-form-name"></i></div>
									<div class="item-inner">
										<div class="item-title label">
											<h1>当前上家</h1></div>
										<div class="item-input">
											<input id="dl_name" name="dl_name" type="text" value="<?php echo ($dealerinfo["dl_belong_name"]); ?>" readonly style="font-size: 0.5rem">
										</div>
									</div>
								</div>
							</li>
							<li>
								<div class="item-content">
									<div class="item-media"><i class="icon icon-form-name"></i></div>
									<div class="item-inner">
										<div class="item-title label">
											<h1>当前推荐人</h1></div>
										<div class="item-input">
											<input id="dl_name" name="dl_name" type="text" value="<?php echo ($dealerinfo["dl_referee_name"]); ?>" readonly style="font-size: 0.5rem">
										</div>
									</div>
								</div>
							</li>
							<li style="background:#fff;">
								<div class="item-content" id="dl_level_item">
									<div class="item-media"><i class="icon icon-form-email"></i></div>
									<div class="item-inner">
										<div class="item-title label">
											<h1>申请级别</h1></div>
										<div class="item-input">
											<input type="hidden" name="dlt_id" id="dlt_id">
											<input id="dl_level" type="text" placeholder="请选择代理级别" style="font-size: 0.5rem" readonly>
										</div>
										<i class="iconfont icon-down-copy" style="font-size:1rem;"></i>
									</div>
								</div>
							</li>
							<li style="background:#fff; display: none;" id="dl_belong">
								<div class="item-content">
									<div class="item-media"><i class="icon icon-form-name"></i></div>
									<div class="item-inner">
										<div class="item-title label">
											<h1 style="color:#c1c1c1">备  注</h1></div>
										<div class="item-input">
											<span id="belongtxt" style="color:#c1c1c1"></span>
										</div>
									</div>
								</div>
							</li>
							<li style="background:#fff;">
								<div class="item-content">
									<div class="item-media"><i class="icon icon-form-name"></i></div>
									<div class="item-inner">
										<div class="item-title label">
											<h1>上传凭证</h1></div>
										<div class="item-input">
											<span style="font-size: 0.5rem; color: #c1c1c1">(文件小于2M)</span>
										</div>
									</div>
								</div>
							</li>
							<li style="background:#fff;">
								<div class="item-content">
									<div class="item-media"><i class="icon icon-form-name"></i></div>
									<div class="item-inner">
										<img class="kl-img-thumbnail" id="img_file" src="/Kangli/Public/uploads/temp/59fd948f50b685485.jpeg" style="width:4rem;display: none;">
										<div class="item-input">	  
											<a href="javascript:;" class="kl-file" style="margin-top:.8rem;">凭证
    											<input id="pic_file" name="pic_file" class="kl-img-thumbnail"  type="file"  accept="image/gif,image/jpeg,image/jpg,image/png" >
											</a>
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

	<script type="text/javascript" src="/Kangli/Public/Kangli/js/lrz.all.bundle.js"></script>
	<script type="text/javascript">
	$.init();
	$(function() {
			var listArray = <?php echo json_encode($dltypelist);?>||[]; //注意，这里不要用双引号或单引号；
		// console.log(listArray);
			var nTypeArry=[];
			var idTypeArry=[];
				if($.isArray(listArray)&&listArray.length>0){
					console.log(JSON.stringify(listArray));
					listArray.forEach(function(val,index) {
						nTypeArry.push(val.dlt_name);
						idTypeArry.push(val.dlt_id);
					});
				}
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
				}],
				onClose:function(e)
				{
					var dltype=$("#dlt_id").val();
					try {
					$.ajax({
					type: 'POST',
					url: '<?php echo U('./Kangli/Dealer/belongjson');?>',
					data: {dltype:dltype},
					dataType: 'json',
					timeout: 30000,
					success: function (data) {
						var stat=0;
						stat=parseInt(data.stat);
						if (stat == 1) {
						     $("#belongtxt").html('').append(data.msg);
							 $("#dl_belong").show();
							 $("#okk").val('1');
						     return false;
						}else if(stat == 2){
						     $("#belongtxt").html("");
							 $("#dl_belong").hide();
							 $("#okk").val('0');
							 $.toast(data.msg);
							 // location.href = "<?php echo U('./Kangli/Index/index');?>";
						}else{
						     $("#belongtxt").html("");
							 $("#dl_belong").hide();
							 $("#okk").val('0');
							 $.toast(data.msg);
							 return false;
						}
					},
					error: function (xhr, type) {
					   $.toast("超时或服务错误");
						return false;
					}
				});

			} catch (e) {
				$.toast(e);
				return false; 
			}
				}
			});

			 $(".kl-file").on("change","input[type='file']",function(){
			 	//  var filePath=$(this).val();
			 	// $.toast(filePath);
            	 lrz(this.files[0], {width: 800}).then(function (rst) {
                    // console.log(rst);
					$.showIndicator();
                    $.ajax({
                        url: '<?php echo U('./Kangli/Dealer/uploadpic');?>',
                        type: 'post',
                        data: {"pic_file":rst.base64,"ttamp":"<?php echo ($ttamp); ?>","sture":"<?php echo ($sture); ?>"},
                        dataType: 'json',
                        timeout: 200000,
                        success: function (response) {
	          				$.hideIndicator();
                            if (response.stat == '0') {
								$("#file_name").val(response.filename);
								$("#img_file").attr('src',"/Kangli/Public/uploads/temp/"+response.filename); 
								$("#img_file").show();
                                 return true;
                            } else {
								alert('图片提交失败,请刷新后提交');
								return false;
                            }
                            // setTimeout(function () {

      						// }, 2000);
                        },

                        error: function (jqXHR, textStatus, errorThrown) {
                            $.hideIndicator();
                            if (textStatus == 'timeout') {
                            	$.toast("请求超时");
                                return false;
                            }
                            alert(jqXHR.responseText);
                        }
                    });
                        
                })
                .catch(function (err) {
                	$.hideIndicator();
                })
                .always(function () {
                	$.hideIndicator();
                });
        });

		//点击提交
    $("#dealer_sumbit").click(function(){
			if(parseInt($("#dlt_id").val()) <=0) {
				$.toast("请选择申请级别"); 
				return false; 
			}			
            if($("#file_name").val()=="") {
            	$.toast("请上传凭证");  
				return false; 
			} 			
			if(parseInt($("#okk").val()) <=0) {
				$.toast("所申请级别上家有误，请与公司联系");   
				return false; 
			}
			$("#fmmm").submit();  		
		});
	});
	</script>	
</html>