<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
        <link rel="shortcut icon" href="/Kangli/Public/Kangli/static/chuanshu_min.png">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-status-bar-style" content="black">
        <meta name="format-detection" content="telephone=no,email=no,adress=no">
        <title><?php echo (C("QY_COMPANY")); ?>-代理调级详情</title>
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
                <a href="<?php echo U('./Kangli/Dealer/updatedltypeindex/');?>/up_status/<?php echo ($up_status); ?>" class="icon icon-left pull-left" style="color:#fff"></a>
                <h1 class="title" style="color:#fff">代理调级详情</h1>
            </header>
            <div class="content">
                    <div class="list-block" style="margin-top:0.25rem;margin-bottom:1rem;">
                        <ul >
                            <li>
                                <div class="item-content">
                                    <div class="item-media"><i class="icon icon-form-name"></i></div>
                                    <div class="item-inner">
                                        <div class="item-title label">
                                            <h1>申请代理</h1></div>
                                        <div class="item-input">
                                            <input id="dl_name" name="dl_name" type="text" value="<?php echo ($updateinfo["dl_name_str"]); ?>" readonly style="font-size: 0.5rem">
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="item-content">
                                    <div class="item-media"><i class="icon icon-form-name"></i></div>
                                    <div class="item-inner">
                                        <div class="item-title label">
                                            <h1>申请前上家</h1></div>
                                        <div class="item-input">
                                            <input id="dl_name" name="dl_name" type="text" value="<?php echo ($updateinfo["apply_agobelong_str"]); ?>" readonly style="font-size: 0.5rem">
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="item-content">
                                    <div class="item-media"><i class="icon icon-form-name"></i></div>
                                    <div class="item-inner">
                                        <div class="item-title label">
                                            <h1>申请前级别</h1></div>
                                        <div class="item-input">
                                            <input id="dl_name" name="dl_name" type="text" value="<?php echo ($updateinfo["apply_agodltype_str"]); ?>" readonly style="font-size: 0.5rem">
                                        </div>
                                    </div>
                                </div>
                            </li>
                             <li>
                                <div class="item-content">
                                    <div class="item-media"><i class="icon icon-form-name"></i></div>
                                    <div class="item-inner">
                                        <div class="item-title label">
                                            <h1>申请后上家</h1></div>
                                        <div class="item-input">
                                            <input id="dl_name" name="dl_name" type="text" value="<?php echo ($updateinfo["apply_afterbelong_str"]); ?>" readonly style="font-size: 0.5rem">
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="item-content">
                                    <div class="item-media"><i class="icon icon-form-name"></i></div>
                                    <div class="item-inner">
                                        <div class="item-title label">
                                            <h1>申请后级别</h1></div>
                                        <div class="item-input">
                                            <input id="dl_name" name="dl_name" type="text" value="<?php echo ($updateinfo["apply_afterdltype_str"]); ?>" readonly style="font-size: 0.5rem">
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="item-content">
                                    <div class="item-media"><i class="icon icon-form-name"></i></div>
                                    <div class="item-inner">
                                        <div class="item-title label">
                                            <h1>凭证</h1></div>
                                        <div class="item-input">
                                           <img class="kl-img-thumbnail" id="img_file" src="<?php echo ($updateinfo["apply_pic_str"]); ?>" style="width:4rem;margin-top:.2rem;">
                                        </div>
                                    </div>
                                </div>
                            </li>
                             <li>
                                <div class="item-content">
                                    <div class="item-media"><i class="icon icon-form-name"></i></div>
                                    <div class="item-inner">
                                        <div class="item-title label">
                                            <h1>当前状态</h1></div>
                                        <div class="item-input">
                                            <input id="dl_name" name="dl_name" type="text" value="<?php echo ($updateinfo["apply_state_str"]); ?>" readonly style="font-size: 0.5rem">
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="item-content">
                                    <div class="item-media"><i class="icon icon-form-name"></i></div>
                                    <div class="item-inner">
                                        <div class="item-title label">
                                            <h1>申请时间</h1></div>
                                        <div class="item-input">
                                            <input id="dl_name" name="dl_name" type="text" value="<?php echo (date('Y-m-d H:i:s',$updateinfo["apply_addtime"])); ?>" readonly style="font-size: 0.5rem">
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <?php if(($updateinfo["apply_dealtime"] != '') AND ($updateinfo["apply_dealtime"] != '0') ): ?><li>
                                <div class="item-content">
                                    <div class="item-media"><i class="icon icon-form-name"></i></div>
                                    <div class="item-inner">
                                        <div class="item-title label">
                                            <h1>处理时间</h1></div>
                                        <div class="item-input">
                                            <input id="dl_name" name="dl_name" type="text" value="<?php echo (date('Y-m-d H:i:s',$updateinfo["apply_dealtime"])); ?>" readonly style="font-size: 0.5rem">
                                        </div>
                                    </div>
                                </div>
                            </li><?php endif; ?>
                            <?php if($updateinfo["apply_remark"] != '' ): ?><li>
                                <div class="item-content">
                                    <div class="item-media"><i class="icon icon-form-name"></i></div>
                                    <div class="item-inner">
                                        <div class="item-title label">
                                            <h1>处理备注</h1></div>
                                        <div class="item-input">
                                            <input id="dl_name" name="dl_name" type="text" value="<?php echo (nl2br($updateinfo["apply_remark"])); ?>" readonly style="font-size: 0.5rem">
                                        </div>
                                    </div>
                                </div>
                            </li><?php endif; ?>
                        </ul>
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
    });
    </script>   
</html>