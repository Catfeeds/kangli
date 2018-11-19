<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
        <link rel="shortcut icon" href="/Kangli/Public/Kangli/static/chuanshu_min.png">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-status-bar-style" content="black">
        <meta name="format-detection" content="telephone=no,email=no,adress=no">
        <title><?php echo (C("QY_COMPANY")); ?>-代理详情</title>
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
           .modal-button {
                font-size: .5rem;
            }
        </style>
    </head>

    <body ontouchstart="" style="background-color:#FAFAFA">
        <div class="page">
            <header class="bar bar-nav" style="background-color:#006db2;">
                <a href="javascript:;" onClick="javascript :history.back(-1);" class="icon icon-left pull-left" style="color:#fff"></a>
                <h1 class="title" style="color:#fff">代理详情</h1>
            </header>
            <div class="content">
<div class="list-block" style="margin-top:0.25rem;margin-bottom:1rem;">
                        <ul>
                            <li>
                                <div class="item-content">
                                    <div class="item-media"><i class="icon icon-form-name"></i></div>
                                    <div class="item-inner">
                                        <div class="item-title label">
                                            <h1>头像</h1></div>
                                        <div class="item-input">
                                            <input id="dl_head_icon" type="hidden">
                                        </div>
                                        <img class="kl-circle kl-img-thumbnail" src="/Kangli/Public/uploads/mobi/<?php echo ($dlinfo["dl_wxheadimg"]); ?>" style="width:2.5rem; border-radius: 50%;" onerror="this.src='/Kangli/Public/Kangli/static/head_icon.png'">
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
                                            <input type="hidden" name="dlt_id" id="dlt_id">
                                            <input id="dl_level" type="text" placeholder="" style="font-size: 0.5rem" value="<?php echo ($dlinfo["dlt_name"]); echo ($dlinfo["dl_status_str"]); ?>" readonly>
                                        </div>
                                         <i class="iconfont icon-down-copy" style="font-size:1rem; display:none"></i>
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
                                            <input id="dl_name" name="dl_name" type="text" placeholder="" style="font-size: 0.5rem" value="<?php echo ($dlinfo["dl_name"]); ?>" readonly>
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
                                            <input id="dl_weixin" name="dl_weixin" type="text" placeholder="" style="font-size: 0.5rem" value="<?php echo ($dlinfo["dl_weixin"]); ?>" readonly>
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
                                            <input id="dl_tel" name="dl_tel" type="text" placeholder="" style="font-size: 0.5rem" value="<?php echo ($dlinfo["dl_tel"]); ?>" readonly>
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
                                            <input id="dl_idcard" name="dl_idcard" type="text" placeholder="" style="font-size: 0.5rem" value="<?php echo ($dlinfo["dl_idcard"]); ?>" readonly>
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
                                            <input id="dl_bankname" name="dl_bankname" type="text" placeholder="" value="<?php echo ($dlinfo["dl_bankname"]); ?>" readonly style="font-size: 0.5rem">
                                        </div>
                                        <i class="iconfont icon-down-copy" style="font-size:1rem; display:none"></i>
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
                                            <input id="dl_bankcard" name="dl_bankcard" type="text" placeholder="" value="<?php echo ($dlinfo["dl_bankcardstr"]); ?>" readonly style="font-size: 0.5rem">
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
                                            <input id="dl_area_all" name="dl_area_all" type="text" placeholder="" value="<?php echo ($dlinfo["dl_qustr"]); ?>" readonly style="font-size: 0.5rem">
                                        </div>
                                        <i class="iconfont icon-down-copy" style="font-size:1rem; display:none"></i>
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
                                            <input id="dl_address" name="dl_address" type="text" placeholder=""  value="<?php echo ($dlinfo["dl_address"]); ?>" readonly style="font-size: 0.5rem">
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="item-content">
                                    <div class="item-media"><i class="icon icon-form-name"></i></div>
                                    <div class="item-inner">
                                        <div class="item-title label">
                                            <h1>邀请人</h1></div>
                                        <div class="item-input">
                                            <input id="dl_referee" name="dl_referee" type="text" placeholder="" value="<?php echo ($dlinfo["dl_referee_str"]); ?>" readonly style="font-size: 0.5rem">
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="item-content">
                                    <div class="item-media"><i class="icon icon-form-name"></i></div>
                                    <div class="item-inner">
                                        <div class="item-title label">
                                            <h1>上家代理</h1></div>
                                        <div class="item-input">
                                            <input id="dl_referee" name="dl_referee" type="text" placeholder="" value="<?php echo ($dlinfo["dl_belong_str"]); ?>" readonly style="font-size: 0.5rem">
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
  	<div class="content-block" <?php if($dlinfo["dl_status"] > 0 or $dlinfo["dl_oneself"] == 0): ?>style="display:none"<?php endif; ?>>
    <div class="row">
      <div class="col-50"><a href="#" id="dl_delete" class="button button-big button-fill button-danger">删除</a></div>
      <div class="col-50"><a href="#" id="dl_confirm" class="button button-big button-fill button-warning">通过</a></div>
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
        var dl_id="<?php echo ($dlinfo["dl_id"]); ?>"
        $("#dl_delete").click(function() {
            $.confirm('确定删除该代理吗?', function () {
                // $.toast("确定删除");
                window.location.href="<?php echo U('./Kangli/Dealer/applydelete/dlid');?>/"+dl_id;
            });
        });
        $("#dl_confirm").click(function() {
              $.confirm('确定通过该代理吗?', function () {
                // $.toast("确定通过");
                window.location.href="<?php echo U('./Kangli/Dealer/applyactive/dlid');?>/"+dl_id;
            });
        });
    });
    </script>   
    
</html>