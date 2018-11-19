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
            <?php echo (C("QY_COMPANY")); ?>-邀请直属经销商</title>
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
                <form action="<?php echo U('./Kangli/Dealer/qyjxapply');?>" action="" enctype="multipart/form-data" method="post" id="fmmm" name="fmmm">
                    <input type="hidden" name="ttamp" id="ttamp" value="<?php echo ($ttamp); ?>">    
                    <input type="hidden" name="sture" id="sture" value="<?php echo ($sture); ?>">        
                    <input type="hidden" name="action" id="action" value="save">
                    <input type="hidden" name="diqustr" id="diqustr" value="">
                    <input type="hidden" name="file_name" id="file_name"  value="" >
                    <input type="hidden" name="file_name2" id="file_name2"  value="" >
                    <div class="list-block" style="margin-top:0.25rem;margin-bottom:1rem;">
                        <ul>
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
                        </ul>
                    </div>
                </form>
                <div class="content-block" style="margin-top:0.5rem;margin-bottom:0.5rem;">
                    <p>
                        <a href="#" id="dealer_sumbit" class="button button-fill" style="color: #fff; height:2rem;padding:.4rem;background-color:#006db2;">邀请</a>
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

            //点击提交
            $("#dealer_sumbit").click(function(){
                var dlt_id=$("#dlt_id").val();
                if(dlt_id== "") {
                    $.toast("请选择邀请代理级别"); 
                    return false; 
                }      
                window.location.href="<?php echo U('./Kangli/Dealer/qyshare');?>"+"/dltid/"+dlt_id+"/ttamp/<?php echo ($ttamp); ?>/sture/<?php echo ($sture); ?>";
            });
        });
    </script>
</html>