<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>基本设置</title>
<link rel="stylesheet" type="text/css" href="/Kangli/Public/mp/css/style.css" />
<link rel="stylesheet" type="text/css" href="/Kangli/Public/mp/css/jquery-confirm.min.css"/>
<script type="text/javascript" src="/Kangli/Public/mp/js/jquery.min.js"></script>
<script type="text/javascript" src="/Kangli/Public/mp/js/jquery-confirm.min.js"></script>
<link rel="stylesheet" type="text/css" href="/Kangli/Public/kedt4110/themes/default/default.css" />
<script type="text/javascript" src="/Kangli/Public/kedt4110/kindeditor-min.js"></script>
<script type="text/javascript" src="/Kangli/Public/kedt4110/lang/zh_CN.js"></script>
<script type="text/javascript" >
KindEditor.lang({
		shipin : '插入视频外链'
});

			var editor;
			KindEditor.ready(function(K) {
				editor = K.create('#econtent', {
					resizeType : 1,
					allowPreviewEmoticons : false,
					allowImageUpload : false,
					allowFlashUpload : false,
					allowMediaUpload : false,
					allowFileUpload : false,
					allowFileManager : true,
					filterMode : true,
					fileManagerJson : '/Kangli/Public/kedt4110/php/mobi_file_manager_json.php?sture=<?php echo ($sture); ?>&ttamp=<?php echo ($ttamp); ?>&uid=<?php echo ($uid); ?>',
					afterCreate : function() {
					var self = this;
					K.ctrl(document, 13, function() {
						self.sync();
						K('form[name=fmmm]')[0].submit();
					});
					K.ctrl(self.edit.doc, 13, function() {
						self.sync();
						K('form[name=fmmm]')[0].submit();
					});
				    },
					items : [
						'undo', 'redo','|','preview','plainpaste','|','fontname', 'fontsize', '|', 'forecolor', 'hilitecolor', 'bold', 'italic', 'underline',
						'removeformat', '|', 'justifyleft', 'justifycenter', 'justifyright', 'insertorderedlist',
						'insertunorderedlist', '|','table', 'image', 'link','unlink','shipin'],
						
					htmlTags:{
						font : ['color', 'size', 'face', '.background-color'],
						span : [
								'.color', '.background-color', '.font-size', '.font-family', '.background',
								'.font-weight', '.font-style', '.text-decoration', '.vertical-align', '.line-height'
						],
						div : [
								'align', '.border', '.margin', '.padding', '.text-align', '.color',
								'.background-color', '.font-size', '.font-family', '.font-weight', '.background',
								'.font-style', '.text-decoration', '.vertical-align', '.margin-left'
						],
						table: [
								'border', 'cellspacing', 'cellpadding', 'width', 'height', 'align', 'bordercolor',
								'.padding', '.margin', '.border', 'bgcolor', '.text-align', '.color', '.background-color',
								'.font-size', '.font-family', '.font-weight', '.font-style', '.text-decoration', '.background',
								'.width', '.height', '.border-collapse'
						],
						'td,th': [
								'align', 'valign', 'width', 'height', 'colspan', 'rowspan', 'bgcolor',
								'.text-align', '.color', '.background-color', '.font-size', '.font-family', '.font-weight',
								'.font-style', '.text-decoration', '.vertical-align', '.background', '.border'
						],
						a : ['href', 'target', 'name'],
						embed : ['src', 'width', 'height', 'type', 'loop', 'autostart', 'quality', '.width', '.height', 'align', 'allowscriptaccess'],
						img : ['src','align','width','height'],
						'p,ol,ul,li,blockquote,h1,h2,h3,h4,h5,h6' : [
								'align', '.text-align', '.color', '.background-color', '.font-size', '.font-family', '.background',
								'.font-weight', '.font-style', '.text-decoration', '.vertical-align', '.text-indent', '.margin-left'
						],
						pre : ['class'],
						hr : ['class', '.page-break-after'],
						'br,tbody,tr,strong,b,sub,sup,em,i,u,strike,s,del' : [],
						iframe : ['src', 'frameborder','width','height']
						
				    }

				});
				
			});
</script>
<style>
.ke-icon-shipin {
	background-position: 0px -528px;
	width: 16px;
	height: 16px;
}
</style>

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
				<?php if(($qypurview["13008"]) == "13008"): ?><li><A href="<?php echo U('Mp/Orders/qborders');?>" class="<?php echo ($curr =='qborders' ?'curr':''); ?>" >所有订单</A></li><?php endif; ?>
				<?php if(($qypurview["13005"]) == "13005"): ?><li><A href="<?php echo U('Mp/Orders/dlordersum');?>" class="<?php echo ($curr =='dlordersum' ?'curr':''); ?>" >代理业绩</A></li><?php endif; ?>
				<?php if(($qypurview["13003"]) == "13003"): ?><li><A href="<?php echo U('Mp/Orders/addresslist');?>" class="<?php echo ($curr =='address' ?'curr':''); ?>" >发货地址</A></li><?php endif; ?>
				<?php if(($qypurview["13006"]) == "13006"): ?><li><A href="<?php echo U('Mp/Returnable/index');?>" class="<?php echo ($curr =='returnable' ?'curr':''); ?>" >公司退换货</A></li><?php endif; ?>
				<?php if(($qypurview["13006"]) == "13006"): ?><li><A href="<?php echo U('Mp/Returnable/dlreturn');?>" class="<?php echo ($curr =='dlreturn' ?'curr':''); ?>" >代理退换货</A></li><?php endif; ?>
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
				<?php if(($qypurview["18006"]) == "18006"): ?><li><A href="<?php echo U('Mp/Capital/recashlist');?>" class="<?php echo ($curr =='recashlist2' ?'curr':''); ?>" >提现记录</A></li><?php endif; ?>
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
<div class="nav_l"><a href="<?php echo U('Mp/Index/index');?>">首页</a>　&gt;　<A href="<?php echo U('Mp/Jfmobi/basic');?>">基本设置</A></div>
<div class="nav_r"></div>
</div>
<div class="height20"></div>
<div class="content">
<form action="<?php echo U('Mp/Jfmobi/edit_save/action/contact');?>"   method="post" name="fmmm"  >
<input type="hidden" value="<?php echo ($basicinfo["bas_id"]); ?>" name="bas_id" />
<table width="100%" border="0" cellspacing="0" cellpadding="0" >
     <tr>     
				  <td class="txtcenter" colspan="2" height="40" ><?php if(($qypurview["70010"]) == "70010"): ?><a href="<?php echo U('Mp/Jfmobi/basic');?>" class="abotton" >基本信息</a><?php endif; if(($qypurview["70011"]) == "70011"): ?>　<a href="<?php echo U('Mp/Jfmobi/basic/action/profile');?>" class="abotton" >公司简介</a><?php endif; if(($qypurview["70012"]) == "70012"): ?>　<a href="<?php echo U('Mp/Jfmobi/basic/action/contact');?>" class="abotton" >联系方式</a><?php endif; if(($qypurview["70002"]) == "70002"): ?>　<a href="<?php echo U('Mp/Jfmobi/basic/action/rule');?>" class="abotton" >积分说明</a><?php endif; if(($qypurview["70003"]) == "70003"): ?>　<a href="<?php echo U('Mp/Jfmobi/basic/action/help');?>" class="abotton" >帮助中心</a><?php endif; if(($qypurview["70004"]) == "70004"): ?>　<a href="<?php echo U('Mp/Jfmobi/basic/action/agreement');?>" class="abotton" >注册协议</a><?php endif; ?> <?php if(($qypurview["70015"]) == "70015"): ?>　<a href="<?php echo U('Mp/Jfmobi/basic/action/zhengce');?>" class="abotton" >政策</a><?php endif; ?></td>
			  </tr>
             <tr>     
                  <td height="40"   width="25%" class="txtright"  style="font-size:14px; font-weight:bold; padding-top:20px" >编辑联系方式:</td>
				  <td width="75%" class="txtleft" ></td>
			  </tr>
			   <tr>     
                  <td height="40"  class="txtright" > </td>
				  <td  class="txtleft" >
				  <textarea name="econtent" id="econtent" style="width:640px;height:500px;visibility:hidden;"><?php echo (htmlspecialchars($basicinfo["bas_contact"])); ?></textarea>
				  </td>
			  </tr>

			  <tr>  <td height="60" ></td>
              <td  class="txtleft"  >
             <input type="submit" name="Submit" value="确认修改" class="botton" >
            </td>
			  </tr>
			</table>
</form>
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