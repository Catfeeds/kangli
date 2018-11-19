<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>订货订单</title>
<link rel="stylesheet" type="text/css" href="/Kangli/Public/mp/css/style.css" />
<link rel="stylesheet" type="text/css" href="/Kangli/Public/mp/css/jquery-confirm.min.css"/>
<script type="text/javascript" src="/Kangli/Public/mp/js/jquery.min.js"></script>
<script type="text/javascript" src="/Kangli/Public/mp/js/jquery-confirm.min.js"></script>
<link rel="stylesheet" type="text/css" href="/Kangli/Public/mp/css/jquery-confirm.min.css" />
<script type="text/javascript" src="/Kangli/Public/mp/js/jquery-confirm.min.js"></script>
<script type="text/javascript" src="/Kangli/Public/mp/js/jquery.form.min.js"></script>
<script type="text/javascript" language="javascript">
        $(document).ready(function() {
		
			$("#odfinishship").click(function() {
				var options = {
					url:"<?php echo U('Mp/Orders/xnodfinishship');?>",
					type:"post",
					dataType:"json", 
					beforeSubmit:function (){
						
						return true;
                    }, 
					success:function (data){
					    var msg="";
						var stat=0;
						stat=parseInt(data.stat);
						if(stat==9){
							$.confirm({
								title: '提示!',
								content: '该订单还没完成出货，点击[确认]将强行完成发货',
	
								boxWidth: '25%',
								useBootstrap: false,
								buttons: {
									 confirm: {
										text: '确认完成发货',
										btnClass: 'btn-blue',
										action: function () {
									         self.location.href='<?php echo U('Mp/Orders/xnodfinishship?od_id='.$od_id.'&odbl_id='.$odbl_id.'&isok=1');?>'; 
										}
									},
									cancel: {
										text: '取消发货',
										action: function () {
										
										}
									}
								}
							});	  
						  
						}else if(stat==1){
						    self.location.href='<?php echo U('Mp/Orders/xnodfinishship?od_id='.$od_id.'&odbl_id='.$odbl_id.'&isok=1');?>'; 
						}else{
							
							 $.alert({
								title: '提示!',
								boxWidth: '25%',
								useBootstrap: false,
								content: data.msg,
                                buttons: {
									cancel:{
										text: '关闭',
									}
								}
							});
						}
                    }
				};
				$("#fwfm").ajaxForm(options);
	 
			 }); 
			 
			 $("#odfinishship2").click(function() {
			     self.location.href='<?php echo U('Mp/Orders/xnodfinishship?od_id='.$od_id.'&odbl_id='.$odbl_id.'&isok=1');?>'; 
			 }); 
			 

	   }); 
</script>
</head>
<body>
<div class="header">
<div class="bound">
<div class="logo">
<?php if(!empty($qypic)): ?><img src="/Kangli/Public/uploads/product/<?php echo ($qypic); ?>"  height="40" style="vertical-align:middle" />
<?php else: ?> 
<img src="/Kangli/Public/mp/static/logo0.png"  height="40" style="vertical-align:middle" /><?php endif; ?>
</div>
<div class="topright">您好,<?php echo (session('qyuser')); ?><a href="<?php echo U('Mp/Login/quit');?>" style="color:#fff;" >退出系统</a> </div>
</div>
</div>
<div class="main" >
<div class="bound" >
<div class="leftmenu">
<div class="menu_list">
	<div class="menu_top">
		<div  style="line-height:51px; height:51px;"><img src="/Kangli/Public/mp/static/home2.png"   style="vertical-align:middle; width:20px; height:20px; margin:0 3px 4px 10px" /> <A href="<?php echo U('Mp/Index/index');?>" style="color:#06c; font-size:14px" >首页</A></div>
	</div>
	<?php if(($qypurview["10000"]) == "10000"): ?><div class="menu_parent">
			<ul class="menu_sontitle" id="fu01"  onClick="nemuclose('#zi01',this)" >基本资料</ul>
			<ul class="menu_son" id="zi01" >
				<?php if(($qypurview["10001"]) == "10001"): ?><li><A href="<?php echo U('Mp/Dealer/index');?>"   class="<?php echo ($curr =='dealer_list' ?'curr':''); ?>" >经销商管理</A></li><?php endif; ?>
				<?php if(($qypurview["20001"]) == "20001"): ?><li><A href="<?php echo U('Mp/Product/index');?>"  class="<?php echo ($curr =='pro_list' ?'curr':''); ?>" >产品管理</A></li><?php endif; ?>
				<?php if(($qypurview["20005"]) == "20005"): ?><li><A href="<?php echo U('Mp/Product/proprice');?>"  class="<?php echo ($curr =='pro_price' ?'curr':''); ?>" >价格体系</A></li><?php endif; ?>
				<?php if(($qypurview["11001"]) == "11001"): ?><li><A href="<?php echo U('Mp/Warehouse/index');?>"  class="<?php echo ($curr =='warehouse_list' ?'curr':''); ?>" >仓库管理</A></li><?php endif; ?>
			</ul>
		</div><?php endif; ?>
	<?php if(($qypurview["13001"]) == "13001"): ?><div class="menu_parent">
			<ul class="menu_sontitle" id="fu20" onClick="nemuclose('#zi20',this)" >虚拟库存管理</ul>
			<ul class="menu_son" id="zi20">
				<?php if(($qypurview["13001"]) == "13001"): ?><li><A href="<?php echo U('Mp/Dlkucun/xnkclist');?>" class="<?php echo ($curr =='xnkclist' ?'curr':''); ?>">代理库存</A></li><?php endif; ?>
			</ul>
		</div><?php endif; ?>
	<?php if(($qypurview["13001"]) == "13001"): ?><div class="menu_parent">
			<ul class="menu_sontitle" id="fu19" onClick="nemuclose('#zi19',this)" >入库管理</ul>
			<ul class="menu_son" id="zi19">
				<?php if(($qypurview["13001"]) == "13001"): ?><li><A href="<?php echo U('Mp/Storage/add');?>" class="<?php echo ($curr =='storage_add' ?'curr':''); ?>">入库扫描</A></li><?php endif; ?>
				<?php if(($qypurview["13002"]) == "13002"): ?><li><A href="<?php echo U('Mp/Storage/index');?>" class="<?php echo ($curr =='storage_list' ?'curr':''); ?>">入库记录</A></li><?php endif; ?>
				<?php if(($qypurview["30007"]) == "30007"): ?><li><A href="<?php echo U('Mp/Storage/stortongji');?>" class="<?php echo ($curr =='storage_tongji' ?'curr':''); ?>">入库统计</A></li><?php endif; ?>
				<?php if(($qypurview["30007"]) == "30007"): ?><li><A href="<?php echo U('Mp/Storage/stocktongji');?>" class="<?php echo ($curr =='stock_tongji' ?'curr':''); ?>">库存统计</A></li><?php endif; ?>
			</ul>
		</div><?php endif; ?>
	<?php if(($qypurview["30000"]) == "30000"): ?><div class="menu_parent">
			<ul class="menu_sontitle" id="fu07" onClick="nemuclose('#zi07',this)" >出货管理</ul>
			<ul class="menu_son" id="zi07">
				<?php if(($qypurview["30001"]) == "30001"): ?><li><A href="<?php echo U('Mp/Shipment/index');?>" class="<?php echo ($curr =='shipment_list' ?'curr':''); ?>">总公司出货</A></li><?php endif; ?>
				<?php if(($qypurview["90004"]) == "90004"): ?><li><A href="<?php echo U('Mp/Shipment/dlshiplist');?>" class="<?php echo ($curr =='dealer_shiplist' ?'curr':''); ?>">经销商出货</A></li><?php endif; ?>
				<?php if(($qypurview["30007"]) == "30007"): ?><li><A href="<?php echo U('Mp/Tongji/index');?>" class="<?php echo ($curr =='tongji_list' ?'curr':''); ?>">出货统计</A></li><?php endif; ?>
			</ul>
		</div><?php endif; ?>

	<?php if(($qypurview["13000"]) == "13000"): ?><div class="menu_parent">
			<ul class="menu_sontitle" id="fu13" onClick="nemuclose('#zi13',this)" >订单管理</ul>
			<ul class="menu_son" id="zi13">
				<?php if(($qypurview["13001"]) == "13001"): ?><li><A href="<?php echo U('Mp/Orders/cporders');?>" class="<?php echo ($curr =='cporders' ?'curr':''); ?>" >发货订单</A></li><?php endif; ?>
				<?php if(($qypurview["13002"]) == "13002"): ?><li><A href="<?php echo U('Mp/Orders/xnorders');?>" class="<?php echo ($curr =='xnorders' ?'curr':''); ?>" >订货订单</A></li><?php endif; ?>
				<!--<?php if(($qypurview["13008"]) == "13008"): ?>-->
					<!--<li><A href="<?php echo U('Mp/Orders/qborders');?>" class="<?php echo ($curr =='qborders' ?'curr':''); ?>" >所有订单</A></li>-->
				<!--<?php endif; ?>-->
				<?php if(($qypurview["13005"]) == "13005"): ?><li><A href="<?php echo U('Mp/Orders/dlordersum');?>" class="<?php echo ($curr =='dlordersum' ?'curr':''); ?>" >代理业绩</A></li><?php endif; ?>
				<?php if(($qypurview["13003"]) == "13003"): ?><li><A href="<?php echo U('Mp/Orders/addresslist');?>" class="<?php echo ($curr =='address' ?'curr':''); ?>" >发货地址</A></li><?php endif; ?>
				<!--<?php if(($qypurview["13006"]) == "13006"): ?>-->
					<!--<li><A href="<?php echo U('Mp/Returnable/index');?>" class="<?php echo ($curr =='returnable' ?'curr':''); ?>" >公司退换货</A></li>-->
				<!--<?php endif; ?>-->
				<!--<?php if(($qypurview["13006"]) == "13006"): ?>-->
					<!--<li><A href="<?php echo U('Mp/Returnable/dlreturn');?>" class="<?php echo ($curr =='dlreturn' ?'curr':''); ?>" >代理退换货</A></li>-->
				<!--<?php endif; ?>-->
			</ul>
		</div><?php endif; ?>

	<?php if(($qypurview["14000"]) == "14000"): ?><div class="menu_parent">
			<ul class="menu_sontitle" id="fu14" onClick="nemuclose('#zi14',this)" >返利管理</ul>
			<ul class="menu_son" id="zi14">
				<?php if(($qypurview["14001"]) == "14001"): ?><li><A href="<?php echo U('Mp/Fanli/index');?>" class="<?php echo ($curr =='fanlidllist' ?'curr':''); ?>" >代理返利</A></li><?php endif; ?>
				<?php if(($qypurview["14002"]) == "14002"): ?><li><A href="<?php echo U('Mp/Fanli/fanlilist');?>" class="<?php echo ($curr =='fanlilist' ?'curr':''); ?>" >返利明细</A></li><?php endif; ?>
				<?php if(($qypurview["14003"]) == "14003"): ?><li><A href="<?php echo U('Mp/Fanli/paylist');?>" class="<?php echo ($curr =='paylist' ?'curr':''); ?>" >我应付返利</A></li><?php endif; ?>
				<?php if(($qypurview["14003"]) == "14003"): ?><li><A href="<?php echo U('Mp/Fanli/recashlist');?>" class="<?php echo ($curr =='recashlist' ?'curr':''); ?>" >提现记录</A></li><?php endif; ?>
				<?php if(($qypurview["14005"]) == "14005"): ?><li><A href="<?php echo U('Mp/Fanli/salemonthly');?>" class="<?php echo ($curr =='salemonthly' ?'curr':''); ?>" >月度销售奖</A></li><?php endif; ?>
				<?php if(($qypurview["14006"]) == "14006"): ?><li><A href="<?php echo U('Mp/Fanli/saleyear');?>" class="<?php echo ($curr =='saleyear' ?'curr':''); ?>" >年度销售奖</A></li><?php endif; ?>
				<?php if(($qypurview["14004"]) == "14004"): ?><li><A href="<?php echo U('Mp/Fanli/salesreward');?>" class="<?php echo ($curr =='salesreward' ?'curr':''); ?>" >销售累计奖</A></li><?php endif; ?>
			</ul>
		</div><?php endif; ?>

	<?php if(($qypurview["18000"]) == "18000"): ?><div class="menu_parent">

			<ul class="menu_sontitle" id="fu18" onClick="nemuclose('#zi18',this)" >资金管理</ul>
			<ul class="menu_son" id="zi18">

				<?php if(($qypurview["18001"]) == "18001"): ?><li><A href="<?php echo U('Mp/Capital/index');?>" class="<?php echo ($curr =='capital' ?'curr':''); ?>" >代理资金</A></li><?php endif; ?>
				<?php if(($qypurview["18002"]) == "18002"): ?><li><A href="<?php echo U('Mp/Capital/yufukuan');?>" class="<?php echo ($curr =='yufukuan' ?'curr':''); ?>" >预付款明细</A></li><?php endif; ?>
				<?php if(($qypurview["18004"]) == "18004"): ?><li><A href="<?php echo U('Mp/Capital/dlbalance');?>" class="<?php echo ($curr =='dlbalance' ?'curr':''); ?>" >余额明细</A></li><?php endif; ?>
				<!--<?php if(($qypurview["18006"]) == "18006"): ?>-->
					<!--<li><A href="<?php echo U('Mp/Capital/recashlist');?>" class="<?php echo ($curr =='recashlist2' ?'curr':''); ?>" >提现记录</A></li>-->
				<!--<?php endif; ?>-->
				<?php if(($qypurview["18007"]) == "18007"): ?><li><A href="<?php echo U('Mp/Capital/payinlist');?>" class="<?php echo ($curr =='payinlist' ?'curr':''); ?>" >充值记录</A></li><?php endif; ?>
			</ul>

		</div><?php endif; ?>

	<?php if(($qypurview["15000"]) == "15000"): ?><div class="menu_parent">
			<ul class="menu_sontitle" id="fu15" onClick="nemuclose('#zi15',this)" >积分管理</ul>
			<ul class="menu_son" id="zi15">
				<?php if(($qypurview["15001"]) == "15001"): ?><li><A href="<?php echo U('Mp/Dljf/index');?>" class="<?php echo ($curr =='dljflist' ?'curr':''); ?>" >代理积分</A></li><?php endif; ?>
				<?php if(($qypurview["15001"]) == "15001"): ?><li><A href="<?php echo U('Mp/Dljf/dljflist');?>" class="<?php echo ($curr =='dljdetail' ?'curr':''); ?>" >积分明细</A></li><?php endif; ?>
				<?php if(($qypurview["15002"]) == "15002"): ?><li><A href="<?php echo U('Mp/Dljf/dljfexch');?>" class="<?php echo ($curr =='dljfexch' ?'curr':''); ?>" >兑换管理</A></li><?php endif; ?>
				<?php if(($qypurview["15003"]) == "15003"): ?><li><A href="<?php echo U('Mp/Dljf/dljfgift');?>" class="<?php echo ($curr =='dljfgift' ?'curr':''); ?>" >礼品管理</A></li><?php endif; ?>
			</ul>
		</div><?php endif; ?>

	<?php if(($qypurview["40000"]) == "40000"): ?><div class="menu_parent">
			<ul class="menu_sontitle" id="fu02" onClick="nemuclose('#zi02',this)" >会员积分管理</ul>
			<ul class="menu_son" id="zi02">
				<?php if(($qypurview["40001"]) == "40001"): ?><li><A href="<?php echo U('Mp/Jfuser/index');?>" class="<?php echo ($curr =='jfuser_list' ?'curr':''); ?>" >会员管理</A></li><?php endif; ?>
				<?php if(($qypurview["50001"]) == "50001"): ?><li><A href="<?php echo U('Mp/Jfdetail/index');?>"  class="<?php echo ($curr =='jfdetail_list' ?'curr':''); ?>" >积分明细</A></li><?php endif; ?>
				<?php if(($qypurview["50002"]) == "50002"): ?><li><A href="<?php echo U('Mp/Jfexchange/index');?>" class="<?php echo ($curr =='jfexchange_list' ?'curr':''); ?>">礼品兑换</A></li><?php endif; ?>
				<?php if(($qypurview["50003"]) == "50003"): ?><li><A href="<?php echo U('Mp/Jfgift/index');?>" class="<?php echo ($curr =='jfgift_list' ?'curr':''); ?>" >礼品管理</A></li><?php endif; ?>
			</ul>
		</div><?php endif; ?>
	<?php if(($qypurview["12000"]) == "12000"): ?><div class="menu_parent">
			<ul class="menu_sontitle" id="fu12" onClick="nemuclose('#zi12',this)" >导购管理</ul>
			<ul class="menu_son" id="zi12">
				<?php if(($qypurview["12001"]) == "12001"): ?><li><A href="<?php echo U('Mp/Dguser/index');?>" class="<?php echo ($curr =='dguser_list' ?'curr':''); ?>" >导购员列表</A></li><?php endif; ?>
				<?php if(($qypurview["12006"]) == "12006"): ?><li><A href="<?php echo U('Mp/Dgjfdetail/index');?>"  class="<?php echo ($curr =='dgjfdetail_list' ?'curr':''); ?>" >积分明细</A></li><?php endif; ?>
				<?php if(($qypurview["12007"]) == "12007"): ?><li><A href="<?php echo U('Mp/Dgjfexchange/index');?>" class="<?php echo ($curr =='dgjfexchange_list' ?'curr':''); ?>">礼品兑换</A></li><?php endif; ?>
				<?php if(($qypurview["12008"]) == "12008"): ?><li><A href="<?php echo U('Mp/Dgjfgift/index');?>" class="<?php echo ($curr =='dgjfgift_list' ?'curr':''); ?>" >礼品管理</A></li><?php endif; ?>
			</ul>
		</div><?php endif; ?>
	<?php if(($qypurview["70000"]) == "70000"): ?><div class="menu_parent">
			<ul class="menu_sontitle" id="fu04" onClick="nemuclose('#zi04',this)" >前台设置</ul>
			<ul class="menu_son" id="zi04" >
				<?php if(($qypurview["70001"]) == "70001"): ?><li><A href="<?php echo U('Mp/Jfmobi/basic');?>" class="<?php echo ($curr =='jfmo_basic' ?'curr':''); ?>" >基本设置</A></li><?php endif; ?>
				<?php if(($qypurview["70017"]) == "70017"): ?><li><A href="<?php echo U('Mp/Jfmobi/setlogo');?>" class="<?php echo ($curr =='jfmo_logo' ?'curr':''); ?>" >Logo设置</A></li><?php endif; ?>
				<?php if(($qypurview["70019"]) == "70019"): ?><li><A href="<?php echo U('Mp/Jfmobi/setfoot');?>" class="<?php echo ($curr =='jfmo_foot' ?'curr':''); ?>" >底部图片</A></li><?php endif; ?>
				<?php if(($qypurview["70018"]) == "70018"): ?><li><A href="<?php echo U('Mp/Jfmobi/haibaolist');?>" class="<?php echo ($curr =='jfmo_haibao' ?'curr':''); ?>" >海报设置</A></li><?php endif; ?>
				<?php if(($qypurview["70006"]) == "70006"): ?><li><A href="<?php echo U('Mp/Jfmobi/newslist?news_type=1');?>" class="<?php echo ($curr =='jfmo_news' ?'curr':''); ?>" >企业动态</A></li><?php endif; ?>
				<?php if(($qypurview["70015"]) == "70015"): ?><li><A href="<?php echo U('Mp/Jfmobi/newslist?news_type=4');?>" class="<?php echo ($curr =='jfmo_sucai' ?'curr':''); ?>" >素材圈</A></li><?php endif; ?>
				<?php if(($qypurview["70022"]) == "70022"): ?><li><A href="<?php echo U('Mp/Jfmobi/newslist?news_type=8');?>" class="<?php echo ($curr =='jfmo_shiti' ?'curr':''); ?>" >线下实体店</A></li><?php endif; ?>
				<?php if(($qypurview["70023"]) == "70023"): ?><li><A href="<?php echo U('Mp/Jfmobi/newslist?news_type=6');?>" class="<?php echo ($curr =='jfmo_peixun' ?'curr':''); ?>" >培训机构</A></li><?php endif; ?>
				<?php if(($qypurview["70013"]) == "70013"): ?><li><A href="<?php echo U('Mp/Jfmobi/newslist?news_type=2');?>" class="<?php echo ($curr =='jfmo_buyer' ?'curr':''); ?>" >买家秀</A></li><?php endif; ?>
				<?php if(($qypurview["70021"]) == "70021"): ?><li><A href="<?php echo U('Mp/Jfmobi/newslist?news_type=7');?>" class="<?php echo ($curr =='jfmo_huodong' ?'curr':''); ?>" >商家活动</A></li><?php endif; ?>
				<?php if(($qypurview["70005"]) == "70005"): ?><li><A href="<?php echo U('Mp/Jfmobi/product');?>" class="<?php echo ($curr =='jfmo_pro' ?'curr':''); ?>">产品展示</A></li><?php endif; ?>
				<?php if(($qypurview["70007"]) == "70007"): ?><li><A href="<?php echo U('Mp/Jfmobi/piclist');?>" class="<?php echo ($curr =='jfmo_pics' ?'curr':''); ?>">图片管理</A></li><?php endif; ?>
				<?php if(($qypurview["70007"]) == "70007"): ?><li><A href="<?php echo U('Mp/Jfmobi/feedback');?>" class="<?php echo ($curr =='jfmo_feedback' ?'curr':''); ?>">留言反馈</A></li><?php endif; ?>
				<?php if(($qypurview["70014"]) == "70014"): ?><li><A href="<?php echo U('Mp/Jfmobi/feedback');?>" class="<?php echo ($curr =='jfmo_survey'?'curr':''); ?>">调查问卷</A></li><?php endif; ?>
			</ul>
		</div><?php endif; ?>
	<?php if(($qypurview["80000"]) == "80000"): ?><div class="menu_parent">
			<ul class="menu_sontitle2"  id="fu05"  onClick="nemuclose('#zi05',this)" >查询</ul>
			<ul class="menu_son" id="zi05"  style="display:none">
				<?php if(($qypurview["80001"]) == "80001"): ?><li><A href="<?php echo U('Mp/Chaxun/fangcuan');?>" class="<?php echo ($curr =='fangcuan' ?'curr':''); ?>" >防窜货查询</A></li><?php endif; ?>
				<?php if(($qypurview["80002"]) == "80002"): ?><li><A href="<?php echo U('Mp/Chaxun/fwlist');?>"  class="<?php echo ($curr =='fwlist' ?'curr':''); ?>" >防伪码查询记录</A></li><?php endif; ?>
			</ul>
		</div><?php endif; ?>
	<?php if(($qypurview["100000"]) == "100000"): ?><div class="menu_parent">
			<ul class="menu_sontitle2"  id="fu21"  onClick="nemuclose('#zi21',this)" >大数据统计</ul>
			<ul class="menu_son" id="zi21"  style="display:none">
				<?php if(($qypurview["100001"]) == "100001"): ?><li><A href="<?php echo U('Mp/Echarts/index');?>" class="<?php echo ($curr =='echarts' ?'curr':''); ?>" >大屏统计展示</A></li><?php endif; ?>
			</ul>
		</div><?php endif; ?>
	<div class="menu_parent">
		<ul class="menu_sontitle2" id="fu06" onClick="nemuclose('#zi06',this)" >系统管理</ul>
		<ul class="menu_son" id="zi06"  style="display:none" >
			<li><A href="<?php echo U('Mp/Subuser/index');?>" class="<?php echo ($curr =='subuser' ?'curr':''); ?>" >子用户管理</A></li>
			<?php if(($qypurview["90002"]) == "90002"): ?><li>
					<?php if($qybindwx == true): ?><A href="javascript:void(0);" class="<?php echo ($curr =='bindwx' ?'curr':''); ?>" id='unbindwx'>解绑微信</A>
						<?php else: ?>
						<A href="<?php echo U('Mp/Bindwx/index');?>" class="<?php echo ($curr =='bindwx' ?'curr':''); ?>" id='bindwx'>绑定微信</A><?php endif; ?>
				</li><?php endif; ?>
			<li><A href="<?php echo U('Mp/Index/updatepwd');?>" class="<?php echo ($curr =='updatepwd' ?'curr':''); ?>">修改密码</A></li>
			<li><A href="<?php echo U('Mp/Login/quit');?>"  >退出系统</A></li>
		</ul>
	</div>
</div>
<script type="text/javascript" >
    $(document).ready(function() {
        $("#unbindwx").click(function(){
            $.confirm({
                title: '<div style="font-size:16px;width:100%;text-align:center;">温馨提示</div>',
                content:'是否确认解绑微信？',
                boxWidth: '25%',
                useBootstrap:false,
                buttons: {
                    confirm: {
                        text: '确认解绑',
                        btnClass: 'btn-blue',
                        action: function () {
                            window.location.href="<?php echo U('./Mp/Bindwx/unbindwx');?>";
                        }
                    },
                    cancel: {
                        text: '取  消',
                        action: function () {
                            return false
                        }
                    }
                }
            });
        });
    });
    function nemuclose(z,obj){
        $(z).toggle();
        if($(z).css("display")=="none"){
            $(obj).removeClass();
            $(obj).addClass("menu_sontitle2");
        }else{
            $(obj).removeClass();
            $(obj).addClass("menu_sontitle");
        }
    }
</script>
</div>
<div class="rightcontent">
<div class="content_nav" >
<div class="nav_l"><a href="<?php echo U('Mp/Index/index');?>">首页</a>　&gt;　<A href="<?php echo U('Mp/Orders/xnorders');?>">订货订单</A>　&gt;　<A href="#">订单详细</A></div>
<div class="nav_r"><?php if($back == '1' ): ?><a href="<?php echo U('Mp/Orders/xnorders');?>" >&lt;&lt; 返 回</a><?php else: ?><a href="javascript:window.history.go(-1);" >&lt;&lt; 返 回</a><?php endif; ?></div>
</div>
<div class="height20"></div>
<div class="content">
<div class="detail" >
<div class="detail_t">订单号：<?php echo ($ordersinfo["od_orderid"]); ?><span  style="float:right"><?php echo ($ordersinfo["od_state_str"]); ?></span></div>
<table border="0" class="detail_c" width="100%" cellpadding="0" cellspacing="0"  >
  <tr>
    <td  style="width:10%" class="txtright txtbold" >&nbsp;收货人：</td>
    <td style="width:40%" >&nbsp;<?php echo ($ordersinfo["od_contact"]); ?></td>
    <td style="width:10%" class="txtright txtbold" >&nbsp;联系电话：</td>
    <td style="width:40%" >&nbsp;<?php echo ($ordersinfo["od_tel"]); ?></td>
  </tr>
  <tr>
    <td class="txtright txtbold"  >&nbsp;收货地址：</td>
    <td>&nbsp;<?php echo ($ordersinfo["od_address"]); ?></td>
    <td colspan="2" >&nbsp;</td>
  </tr>
<?php if(is_array($ordersinfo['orderdetail'])): foreach($ordersinfo['orderdetail'] as $key=>$item): ?><tr>
    <td class="txtright"   style=" padding-right:6px">
<?php if($item["oddt_propic"] == '' ): ?><img src="/Kangli/Public/mp/static/nophoto.jpg" style="vertical-align:middle; width:50%" />
<?php else: ?>
<img src="/Kangli/Public/uploads/product/<?php echo ($item["oddt_propic"]); ?>" style="vertical-align:middle; width:50%" /><?php endif; ?>
	</td>
    <td>&nbsp;<?php echo ($item["oddt_proname"]); ?> (<?php echo ($item["oddt_pronumber"]); ?>) <?php if($item["oddt_dlprice"] != '' ): ?>单价:<?php echo (number_format($item["oddt_dlprice"],2,'.','')); ?> 元<?php endif; ?></td>
    <td colspan="2">&nbsp; 订购：<?php echo ($item["oddt_qty"]); echo ($item["oddt_prounits"]); echo ($item["oddt_totalqty"]); ?></td>
  
  </tr><?php endforeach; endif; ?>
  
  <tr>
    <td class="txtright txtbold"  >&nbsp;订单留言：</td>
    <td>&nbsp;<?php echo ($ordersinfo["od_remark"]); ?></td>
    <td class="txtright txtbold"  >&nbsp;合计：</td>
    <td>&nbsp;<?php echo ($ordersinfo["od_total"]); ?> 元</td>
  </tr>
  <tr>
    <td class="txtright txtbold"   >&nbsp;支付凭证：</td>
    <td>&nbsp;<?php echo ($ordersinfo["od_paypic_str"]); ?></td>
    <td class="txtright"  >&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td class="txtright txtbold"  >&nbsp;下单时间：</td>
    <td>&nbsp;<?php echo (date('Y-m-d H:i:s',$ordersinfo["od_addtime"])); ?></td>
    <td class="txtright"  >&nbsp;</td>
    <td>&nbsp;<?php echo ($custinfo["cust_email"]); ?></td>
  </tr>
  <tr>
    <td class="txtright txtbold"  >&nbsp;下单代理：</td>
    <td colspan="3" >&nbsp;<?php echo ($ordersinfo["od_dl_name"]); ?> (<?php echo ($ordersinfo["od_dl_username"]); ?>) (<?php echo ($ordersinfo["od_dl_tel"]); ?>)</td>
  </tr>
  <tr>
    <td class="txtright txtbold"  >&nbsp;接单代理：</td>
    <td colspan="3" >&nbsp;<?php echo ($ordersinfo["od_rcdl_name"]); ?> <?php if($ordersinfo["od_rcdl_username"] != '' ): ?>(<?php echo ($ordersinfo["od_rcdl_username"]); ?>)<?php endif; ?> <?php if($ordersinfo["od_rcdl_tel"] != '' ): ?>(<?php echo ($ordersinfo["od_rcdl_tel"]); ?>)<?php endif; ?></td>
  </tr>
  <tr>
    <td class="txtright txtbold"  >&nbsp;处理时间/备注：</td>
    <td>
	<?php if(($ordersinfo["od_expressdate"] != '') AND ($ordersinfo["od_expressdate"] != 0 )): ?>&nbsp;时间：<?php echo (date('Y-m-d H:i:s',$ordersinfo["od_expressdate"])); ?><br><?php endif; ?>
	<?php if($ordersinfo["od_remark"] != '' ): ?>&nbsp;备注：<?php echo ($ordersinfo["od_remark"]); ?><br><?php endif; ?>
	</td>
    <td class="txtright"  >&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  
</table>
</div>
<div style="text-align:center; padding:30px 0 30px 0" >
<form action="#"   method="post" name="fwfm" id="fwfm"  style="padding:0; margin:0">
<input type="hidden" name="od_id" id="od_id" value="<?php echo ($ordersinfo["od_id"]); ?>" />
<input type="hidden" name="od_state" id="od_state" value="<?php echo ($od_state); ?>" />
<input type="hidden" name="isok" id="isok" value="0" />
<?php echo ($ordersinfo["caozuostr"]); ?>　　　<?php if($back == '1' ): ?><input name="back" onclick="javascript:window.self.location='<?php echo U('Mp/Orders/xnorders');?>';" id="back" class="botton" value="&lt;&lt; 返 回" type="button" ><?php else: ?><input name="back" onclick="javascript:window.history.go(-1);" id="back" class="botton" value="&lt;&lt; 返 回" type="button" ><?php endif; ?> </div>
</form>
<div class="detail" >
<div class="detail_t">操作日志：</div>
<table border="0" class="detail_c" width="100%" cellpadding="0" cellspacing="0"  >
  <tr>
    <td   class="" >
	<?php if(is_array($orderlogs)): foreach($orderlogs as $key=>$item): ?><p>&nbsp;&nbsp;<b><?php echo ($item["odlg_action"]); ?></b> 　<?php echo ($item["odlg_dlname"]); ?>　<?php echo (date('Y-m-d H:i:s',$item["odlg_addtime"])); ?></p><?php endforeach; endif; ?>  
	</td>
  </tr>
</table>  
</div>
</div>
<div class="height20"></div>
</div>
</div>
</div>
<div class="clear"></div>
<div class="footer">
<div class="bound">
<div class="f1"> &copy; <span id="cyear" ></span></div>
<script>var myDate = new Date();$("#cyear").html(myDate.getFullYear());</script>
</div>
</div>
</body>
</html>