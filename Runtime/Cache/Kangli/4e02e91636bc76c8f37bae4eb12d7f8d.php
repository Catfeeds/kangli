<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
        <link rel="shortcut icon" href="/Kangli/Public/Kangli/static/chuanshu_min.png">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-status-bar-style" content="black">
        <meta name="format-detection" content="telephone=no,email=no,adress=no">
        <title><?php echo (C("QY_COMPANY")); ?>-支付详细</title>
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
                width:25%;
            }
        </style>
    </head>

    <body ontouchstart="" style="background-color:#FAFAFA">
        <div class="page">
            <header class="bar bar-nav" style="background-color:#006db2;">
                <!-- <a href="javascript:;" onClick="javascript :history.back(-1);" class="icon icon-left pull-left" style="color:#fff"></a> -->
                <a href="<?php echo U('./Kangli/Fanli');?>" class="icon icon-left pull-left" style="color:#fff"></a>
                <h1 class="title" style="color:#fff">支付详细</h1>
            </header>
            <div class="content">
                <form action="<?php echo U('./Kangli/Fanli/paydeal_save');?>"   method="post" name="fmmm"  id="fmmm"  >
                    <input type="hidden" value="<?php echo ($recashinfo["rc_id"]); ?>" name="rc_id" id="rc_id" />
                    <input type="hidden" name="ttamp" id="ttamp" value="<?php echo ($ttamp); ?>">
                    <input type="hidden" name="sture" id="sture" value="<?php echo ($sture); ?>">    
                    <input type="hidden" name="file_name" id="file_name"  value="" >
                 <div class="list-block" style="margin: 0.3rem 0;">
                    <ul>
                      <!-- Text inputs -->
                      <li>
                        <div class="item-content">
                          <div class="item-inner">
                            <div class="item-title">提现代理：<?php echo ($recashinfo["dl_name_str"]); ?></div>
                          </div>
                        </div>
                      </li>
                      <li>
                        <div class="item-content">
                          <div class="item-inner">
                            <div class="item-title">付款代理：<?php echo ($recashinfo["dl_sendname_str"]); ?></div>
                          </div>
                        </div>
                      </li>
                      <li>
                         <div class="item-content">
                          <div class="item-inner">
                            <div class="item-title">开户银行：<?php echo ($recashinfo["rc_bankstr"]); ?></div>
                          </div>
                        </div>
                      </li>
                      <li>
                         <div class="item-content">
                          <div class="item-inner">
                            <div class="item-title">卡号/账号：<?php echo ($recashinfo["rc_bankcardstr"]); ?></div>
                          </div>
                        </div>
                      </li>
                       <li>
                         <div class="item-content">
                          <div class="item-inner">
                            <div class="item-title">卡号姓名：<?php echo ($recashinfo["rc_name"]); ?></div>
                          </div>
                        </div>
                      </li>
                       <li>
                         <div class="item-content">
                          <div class="item-inner">
                            <div class="item-title">提取金额：<?php echo ($recashinfo["rc_moneystr"]); ?> 元</div>
                          </div>
                        </div>
                      </li>
                       <li>
                         <div class="item-content">
                          <div class="item-inner">
                            <div class="item-title">提现时间：<?php echo (date('Y-m-d H:i:s',$recashinfo["rc_addtime"])); ?></div>
                          </div>
                        </div>
                      </li>
                      <?php if(($recashinfo["rc_dealtime"] > 0)): ?><li>
                         <div class="item-content">
                          <div class="item-inner">
                            <div class="item-title">处理时间：<?php echo (date('Y-m-d H:i:s',$recashinfo["rc_dealtime"])); ?></div>
                          </div>
                        </div>
                      </li>
                       <li>
                         <div class="item-content">
                          <div class="item-inner">
                            <div class="kl-layout-horizontally-vcenter">凭证：<?php echo ($recashinfo["rc_pic_str"]); ?></div>
                          </div>
                        </div>
                      </li>
                      <li class="align-top">
                        <div class="item-content">
                          <div class="item-inner">
                            <div class="item-input">
                              <textarea style="font-size: .5rem;color:#c1c1c1;padding-left: 0;">处理备注：<?php echo (nl2br($recashinfo["rc_remark"])); ?></textarea>
                            </div>
                          </div>
                        </div>
                      </li><?php endif; ?>
                     <?php if(($recashinfo["rc_dealtime"] == 0)): ?><li style="background:#fff;">
                            <div class="item-content" id="dl_level_item">
                                <div class="item-inner">
                                    <div class="item-title label">当前状态：</div>
                                    <div class="item-input">
                                        <input type="hidden" name="rc_state" id="rc_state">
                                        <input id="rc_state_name" type="text" placeholder="请选择代理状态" style="font-size: 0.5rem" readonly>
                                    </div>
                                    <i class="iconfont icon-down-copy" style="font-size:1rem;"></i>
                                </div>
                            </div>
                        </li>
                      <li class="align-top">
                        <div class="item-content">
                          <div class="item-inner">
                             <div class="item-title label">处理备注：</div>
                            <div class="item-input">
                              <textarea id="rc_remark"  name="rc_remark" placeholder="请输入处理备注..." style="font-size: .5rem;color:#c1c1c1;padding-left: 0;"></textarea>
                            </div>
                          </div>
                        </div>
                      </li>
                      <li style="background:#fff;">
                                <div class="item-content">
                                    <div class="item-inner">
                                        <div class="item-title label">上传凭证：</div>
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
                        </li><?php endif; ?>
                    </ul>
                </div>
                </form>
                 <?php if(($recashinfo["rc_dealtime"] == 0)): ?><div class="content-block" style="margin-top:0.5rem;margin-bottom:0.5rem;">
                            <p>
                                <a href="#" id="pay_sumbit" class="button button-fill" style="color: #fff; height:2rem;padding:.4rem;background-color:#006db2;">提交</a>
                            </p>
                        </div><?php endif; ?>
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
            var nTypeArry=[];
            var idTypeArry=[];
            nTypeArry.push("处理成功");
            nTypeArry.push("处理失败");
            idTypeArry.push(1);
            idTypeArry.push(2);
            $('#rc_state_name').val('');
            $('#rc_state_name').picker({
                toolbarTemplate: '<header class="bar bar-nav">\<button class="button button-link pull-right close-picker">确定</button>\<h1 class="title">请选择处理状态</h1>\</header>',
                formatValue:function (p,values,displayValues) {
                    $("#rc_state").val(values[0]);
                    // return displayValues[0] +' '+values[0];
                    return displayValues[0];
                },
                cols: [{
                    textAlign: 'center',
                    values: idTypeArry,
                    displayValues:nTypeArry
                }]
            });

             $(".kl-file").on("change","input[type='file']",function(){
                 lrz(this.files[0], {width: 800}).then(function (rst) {
                    console.log(rst);
                    $.showIndicator();
                    $.ajax({
                        url: '<?php echo U('./Kangli/Orders/uploadpic');?>',
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
            $("#pay_sumbit").click(function(){

                if($("#rc_state_name").val() == "") {
                    $.toast("请选择处理状态"); 
                    return false; 
                } 
             
            
                if($("#rc_remark").val() == "") {
                    $.toast("请填写处理备注"); 
                    return false; 
                } 
             
                $.confirm('是否确认已正确处理？',function () {
                    $("#fmmm").submit(); 
                });
            }); 
    });
    </script>   
</html>