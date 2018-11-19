<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
        <link rel="shortcut icon" href="/Kangli/Public/Kangli/static/chuanshu_min.png">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-status-bar-style" content="black">
        <meta name="format-detection" content="telephone=no,email=no,adress=no">
        <title><?php echo (C("QY_COMPANY")); ?>-我的返利</title>
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


            .top-img .fanli-top {
                top: 0;
                left: 0;
                width: 100%;
                height: 8rem;
                position: relative;
            }
            
            .top-img .fanli-top .fanli-flex{
                width: 8rem;
                height: 8rem;
                margin: auto;
                position: absolute;
                left: 50%;
                top: 50%;
                margin-left: -4rem;
                margin-top: -4rem;
                box-sizing: border-box;
                display: -webkit-box;
                display: -webkit-flex;
                display: flex;
                flex-direction: column;
                -webkit-flex-direction: column;
                -webkit-justify-content: center;
                justify-content: center;
                -webkit-box-align: center;
                -webkit-align-items: center;
                align-items: center;
            }
            
            .buttons-tab {
                margin: 0;
                background: #fff;
                position: relative;
            }
            
            .buttons-tab .button {
                font-size: .6rem;
            }
            
            .buttons-tab .button.active,
            .buttons-tab .button:active {
                font-size: .6rem;
                color: #f08519;
                border-color: #f08519;
            }
            
            .content-block {
                margin: 0rem 0;
                padding: 0rem;
                color: #6d6d72;
            }
            
            .badge {
                display: inline-block;
                padding: 0.1rem 0.25rem 0.1rem 0.25rem;
                font-size: .1rem;
                line-height: .6rem;
                color: #fff;
                background-color: rgba(0, 0, 0, .15);
                border-radius: 5rem;
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
                <a href="<?php echo U('./Kangli/Mine');?>" class="icon icon-left pull-left" style="color:#fff"></a>
                <h1 class="title" style="color:#fff">我的返利</h1>
            </header>
            <div class="content">
                <div class="top-img" style="height:8rem;">
                    <div class="fanli-top">
                        <div class="fanli-flex">
                            <!-- <i class="iconfont icon-weibiaoti--copy" style="font-size:3rem; color: #fff;line-height: 3rem;margin-top:.3rem;"></i> -->
                            <img class="kl-circle" src="/Kangli/Public/Kangli/static/balance_top_icon.png" style="position:absolute;width:6rem;height:6rem;border-radius: 50%;top:1rem;left: 50%;margin-left:-3rem" onerror="this.src='/Kangli/Public/Kangli/static/balance_top_icon.png'">
                            <div style="width:6rem;position: absolute;top:3.5rem;left:50%;;margin-left:-3rem;text-align: center;">
                                <span style="line-height:1rem;font-size:0.75rem;color: #fff">返利余额</span>
                                <div style="line-height:.5rem;padding: .2rem"><span style="font-size:.3rem;color: #fff;padding: .3rem"><?php echo (number_format($balance_total,2,'.','')); ?></span></div>
                            </div>
                        </div>
                    </div>
                </div>
                                <div class="buttons-tab">
                    <a href="#tab1" id="my_fanli" class="tab-link active button">
                        <div>
                            <h1>我的返利</h1></div>
                    </a>
                    <a href="#tab2" id="fanli_detail" class="tab-link button">
                        <div>
                            <h1>返利明细</h1></div>
                    </a>
                </div>
                <div class="content-block">
                    <div class="tabs">
                        <div id="tab1" class="tab active">
                            <div class="content-block" style="min-height: 10rem;">
                                <!-- dreanlist -->
                                <div class="list-block" style="margin-top:.25rem;margin-bottom: 0rem;">
                                    <ul>
                                        <li class="item-content item-link btn">
                                            <div class="item-media"><i class="iconfont icon-woyaoshoukuan" style="font-size:1rem; color: #006db8;line-height:1rem;"></i></div>
                                            <div class="item-inner">
                                                <div class="item-title">
                                                    <h1>应收返利</h1></div>
                                            </div>
                                        </li>
                                        <li class="item-content item-link btn">
                                            <div class="item-media"><i class="iconfont icon-fukuan" style="font-size:1rem; color: #006db8;line-height: 1rem;"></i></div>
                                            <div class="item-inner">
                                                <div class="item-title">
                                                    <h1>应付返利</h1></div>
                                            </div>
                                        </li>
                                        <?php if($dl_level == 1): ?><li class="item-content item-link btn">
                                                <div class="item-media"><img src="/Kangli/Public/Kangli/static/balance_icon.png" style="width: 1rem;height: 1rem;"></div>
                                                <div class="item-inner">
                                                    <div class="item-title">
                                                        <h1>年度业绩奖金</h1>
                                                    </div>
                                                </div>
                                            </li>
                                        <?php else: ?>
                                            <?php if($dl_level < 4): ?><li class="item-content item-link btn">
                                                    <div class="item-media"><img src="/Kangli/Public/Kangli/static/balance_icon.png" style="width: 1rem;height: 1rem;"></div>
                                                    <div class="item-inner">
                                                        <div class="item-title">
                                                            <h1>按月业绩奖金</h1>
                                                        </div>
                                                    </div>
                                                </li>
                                            <?php else: ?>
                                                <li class="item-content item-link btn" style="display: none;">
                                                    <div class="item-media"><img src="/Kangli/Public/Kangli/static/balance_icon.png" style="width: 1rem;height: 1rem;"></div>
                                                    <div class="item-inner">
                                                        <div class="item-title">
                                                            <h1>按月业绩奖金</h1>
                                                        </div>
                                                    </div>
                                                </li><?php endif; endif; ?>
                                        <?php if($dl_level == 2): ?><li class="item-content item-link btn">
                                                <div class="item-media"><img src="/Kangli/Public/Kangli/static/balance_icon.png" style="width: 1rem;height: 1rem;"></div>
                                                <div class="item-inner">
                                                    <div class="item-title">
                                                        <h1>业绩累计奖金</h1>
                                                    </div>
                                                </div>
                                            </li>
                                        <?php else: ?>
                                             <li class="item-content item-link btn" style="display: none;">
                                                <div class="item-media"><img src="/Kangli/Public/Kangli/static/balance_icon.png" style="width: 1rem;height: 1rem;"></div>
                                                <div class="item-inner">
                                                    <div class="item-title">
                                                        <h1>总业绩奖金</h1>
                                                    </div>
                                                </div>
                                            </li><?php endif; ?>
                                    </ul>
                                </div>
                                <!-- dreanlist -->
                                <div class="list-block" style="margin-top:.25rem;margin-bottom: 0rem;">
                                    <ul>
                                        <li class="item-content item-link btn">
                                            <div class="item-media"><i class="iconfont icon-kucunpandianbaobiao" style="font-size:1rem; color: #05d0c3;line-height: 1rem;"></i></div>
                                            <div class="item-inner">
                                                <div class="item-title">
                                                    <h1>提现记录</h1></div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div id="tab2" class="tab">
                            <div class="content-block" style="min-height: 10rem; margin-top: .3rem;">
                                <div class="buttons-tab">
                                    <a href="#tab2_1" id="fanli_ds" class="tab-link active button">待收款</a>
                                    <a href="#tab2_2" id="fanli_ys" class="tab-link button">已收款
                                        <?php if($mysodcount > 0): ?><span class="order-circle order-number-thumbnail" style="position: absolute;top:10%;right:10%; color: red"><?php echo ($mysodcount); ?></span><?php endif; ?>
                                    </a>
                                    <a href="#tab2_3" id="fanli_df" class="tab-link button">待付款
                                        <?php if($mymodcount > 0): ?><span class="order-circle order-number-thumbnail" style="position: absolute;top:10%;right:10%; color: red"><?php echo ($mymodcount); ?></span><?php endif; ?>
                                    </a>
                                    <a href="#tab2_4" id="fanli_yf" class="tab-link button">已付款
                                        <?php if($myyodcount > 0): ?><span class="order-circle order-number-thumbnail" style="position: absolute;top:10%;right:10%; color: red"><?php echo ($myyodcount); ?></span><?php endif; ?>
                                    </a>
                                    <a href="#tab2_5" id="fanli_qx" class="tab-link button">已取消</a>
                                </div>
                                <div class="content-block">
                                    <div class="tabs">
                                        <div id="tab2_1" class="tab active">
                                            <div class="content-block">
                                                <div class="list-block media-list" style="margin-top:0rem;">
                                                    <ul>
                                                        <?php if(is_array($list)): foreach($list as $key=>$item): ?><li class="fanli_item_ds">
                                                                <a href="<?php echo U('./Kangli/Fanli/fanlidetail/fl_id');?>/<?php echo ($item["fl_id"]); ?>/state/<?php echo ($state); ?>/ly_status/1" class="item-link item-content">
                                                                     <div class="item-inner">
                                                                        <div class="item-title-row">
                                                                          <div class="item-title"><?php echo ($item["fl_moneystr"]); ?><span style="font-size:0.5rem">元</span></div>
                                                                          <div class="item-after"><span style="padding-top:5%;"><?php echo (date('Y-m-d H:i:s',$item["fl_addtime"])); ?></span></div>
                                                                        </div>
                                                                        <div class="item-text" style="font-size: .5rem;color: #c1c1c1;"><?php echo ($item["fl_remark"]); ?></div>
                                                                      </div>
                                                                </a>
                                                            </li><?php endforeach; endif; ?>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="tab2_2" class="tab">
                                            <div class="content-block">
                                                <div class="list-block media-list" style="margin-top:0rem; ">
                                                    <ul>
                                                        <?php if(is_array($list)): foreach($list as $key=>$item): ?><li class="fanli_item_ys">
                                                              <a href="<?php echo U('./Kangli/Fanli/fanlidetail/fl_id');?>/<?php echo ($item["fl_id"]); ?>/state/<?php echo ($state); ?>/ly_status/1" class="item-link item-content">
                                                                     <div class="item-inner">
                                                                        <div class="item-title-row">
                                                                          <div class="item-title"><?php echo ($item["fl_moneystr"]); ?><span style="font-size:0.5rem">元</span></div>
                                                                          <div class="item-after"><span style="padding-top:5%;"><?php echo (date('Y-m-d H:i:s',$item["fl_addtime"])); ?></span></div>
                                                                        </div>
                                                                        <div class="item-text" style="font-size: .5rem;color: #c1c1c1;"><?php echo ($item["fl_remark"]); ?></div>
                                                                      </div>
                                                                </a>
                                                            </li><?php endforeach; endif; ?>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="tab2_3" class="tab">
                                            <div class="content-block">
                                                <div class="list-block media-list" style="margin-top:0rem;">
                                                    <ul>
                                                         <?php if(is_array($list)): foreach($list as $key=>$item): ?><li >
                                                                <a href="<?php echo U('./Kangli/Fanli/fanlidetail/fl_id');?>/<?php echo ($item["fl_id"]); ?>/state/<?php echo ($state); ?>/ly_status/1" class="item-link item-content">
                                                                     <div class="item-inner">
                                                                        <div class="item-title-row">
                                                                          <div class="item-title"><?php echo ($item["fl_moneystr"]); ?><span style="font-size:0.5rem">元</span></div>
                                                                          <div class="item-after"><span style="padding-top:5%;"><?php echo (date('Y-m-d H:i:s',$item["fl_addtime"])); ?></span></div>
                                                                        </div>
                                                                        <div class="item-text" style="font-size: .5rem;color: #c1c1c1;"><?php echo ($item["fl_remark"]); ?></div>
                                                                      </div>
                                                                </a>
                                                            </li><?php endforeach; endif; ?>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="tab2_4" class="tab">
                                            <div class="content-block">
                                                <div class="list-block media-list" style="margin-top:0rem;">
                                                    <ul>
                                                         <?php if(is_array($list)): foreach($list as $key=>$item): ?><li >
                                                                <a href="<?php echo U('./Kangli/Fanli/fanlidetail/fl_id');?>/<?php echo ($item["fl_id"]); ?>/state/<?php echo ($state); ?>/ly_status/1" class="item-link item-content">
                                                                     <div class="item-inner">
                                                                        <div class="item-title-row">
                                                                          <div class="item-title"><?php echo ($item["fl_moneystr"]); ?><span style="font-size:0.5rem">元</span></div>
                                                                          <div class="item-after"><span style="padding-top:5%;"><?php echo (date('Y-m-d H:i:s',$item["fl_addtime"])); ?></span></div>
                                                                        </div>
                                                                        <div class="item-text" style="font-size: .5rem;color: #c1c1c1;"><?php echo ($item["fl_remark"]); ?></div>
                                                                      </div>
                                                                </a>
                                                            </li><?php endforeach; endif; ?>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="tab2_5" class="tab">
                                            <div class="content-block">
                                                <div class="list-block media-list" style="margin-top:0rem;">
                                                    <ul>
                                                         <?php if(is_array($list)): foreach($list as $key=>$item): ?><li >
                                                               <a href="<?php echo U('./Kangli/Fanli/fanlidetail/fl_id');?>/<?php echo ($item["fl_id"]); ?>/state/<?php echo ($state); ?>/ly_status/1" class="item-link item-content">
                                                                      <div class="item-inner">
                                                                        <div class="item-title-row">
                                                                          <div class="item-title"><?php echo ($item["fl_moneystr"]); ?><span style="font-size:0.5rem">元</span></div>
                                                                          <div class="item-after"><span style="padding-top:5%;"><?php echo (date('Y-m-d H:i:s',$item["fl_addtime"])); ?></span></div>
                                                                        </div>
                                                                        <div class="item-text" style="font-size: .5rem;color: #c1c1c1;"><?php echo ($item["fl_remark"]); ?></div>
                                                                      </div>
                                                                </a>
                                                            </li><?php endforeach; endif; ?>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="kl-page" style="margin:.5rem">
                                    <?php if($page != ''): echo ($page); endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
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
            // $("#dl_tuijian").click();
                    var dl_level = "<?php echo ($dl_level); ?>";
                    var ly_status = "<?php echo ($ly_status); ?>";
                    if(ly_status == 1)
                        $("#fanli_detail").click();

                    var my_status = "<?php echo ($state); ?>";
                    switch(parseInt(my_status)) {
                        case 1:
                            $("#fanli_ys").click();
                            break;
                        case 2:
                            $("#fanli_df").click();
                            break;
                        case 3:
                            $("#fanli_yf").click();
                            break;
                        case 9:
                            $("#fanli_qx").click();
                            break;
                        default:
                            $("#fanli_ds").click();
                            break;
                    }

                    $("#fanli_ds").click(function(){
                        // $.toast('待收');
                        window.location.href ="<?php echo U('./Kangli/Fanli/index/state/0/ly_status/1');?>";
                    });

                    $("#fanli_ys").click(function(){
                        window.location.href ="<?php echo U('./Kangli/Fanli/index/state/1/ly_status/1');?>";
                    });

                    $("#fanli_df").click(function(){
                         window.location.href ="<?php echo U('./Kangli/Fanli/index/state/2/ly_status/1');?>";
                    });

                    $("#fanli_yf").click(function(){
                        window.location.href ="<?php echo U('./Kangli/Fanli/index/state/3/ly_status/1');?>";
                    });

                    $("#fanli_qx").click(function(){
                         window.location.href ="<?php echo U('./Kangli/Fanli/index/state/9/ly_status/1');?>";
                    });




                    $(".item-content.item-link.btn").each(function(index) {
                        console.log('li %d is:%o',index,this);
                        $(this).click(function() {
                            switch(index) {
                                case 0:
                                        //应收返利
                                        window.location.href = "<?php echo U('./Kangli/Fanli/receivelist');?>";
                                    break;
                                case 1:
                                    // 应付返利
                                        window.location.href = "<?php echo U('./Kangli/Fanli/paylist');?>";
                                    break;
                                case 2:
                                        if (dl_level!=1)
                                            window.location.href = "<?php echo U('./Kangli/Fanli/salemonthly/yj_type/0');?>";
                                        else
                                            //年度业绩奖金
                                            window.location.href = "<?php echo U('./Kangli/Fanli/salemonthly/yj_type/1');?>";
                                    break;
                                case 3:
                                    // if(!isNaN(parseInt(dlcodcount)) && parseInt(dlcodcount) != 0) {
                                    //     $.toast("已取消订单");
                                    //     // window.location.href="<?php echo U('./Kangli/Orders/dladdress/');?>";
                                    // }
                                        if (dl_level==2)
                                            window.location.href = "<?php echo U('./Kangli/Fanli/salemonthly/yj_type/2');?>";
                                    break;
                                case 4:
                                    // 提现
                                        window.location.href = "<?php echo U('./Kangli/Fanli/recashlist');?>";
                                    break;
                                default:

                                    break;

                            }
                        });
                    });

            // var flArray = <?php echo json_encode($list);?>;
            // $('.fanli_item_ds').each(function(index) {
            //     console.log('li %d is:%o',index,this);
            //     if ($.isArray(flArray)&&flArray.length>index)
            //     {
            //         var flObject=flArray[index];
            //         $(this).click(function(){
            //             if($.isPlainObject(flObject))
            //             {
            //                 window.location.href="<?php echo U('./Kangli/Fanli/fanlidetail');?>/"+"fl_id/"+flObject['fl_id']+"/state/0/ly_status/1";
            //             }
            //         }); 
            //     }
            // });
    });
    </script>   
</html>