<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>经销商详情</title>
<style>
<!--
html,body
{
width:100%;
height:100%;
margin:0;
padding:0;
font-size:12px;
}
.txtright{ text-align:right; font-weight:bold}
.txtleft{ text-align:left}
-->
</style>
</head>
<body>
<div class="bound" >
<table width="100%" border="0" cellspacing="0" cellpadding="0" >
             <tr>     
                  <td height="10"   width="25%" class="txtright" ></td>
				  <td width="75%" class="txtleft" ></td>
			  </tr>
			 <?php if($qypurview["90002"] == '90002'): if(!empty($dealerinfo["dl_openid"])): ?><tr>     
                  <td height="35"   class="txtright" >已绑定微信</td>
				  <td class="txtleft" ></td>
			  </tr>
			   <tr>     
                  <td height="35"   class="txtright" >OpenID：</td>
				  <td class="txtleft" ><?php echo ($dealerinfo["dl_openid"]); ?></td>
			  </tr><?php endif; ?>
			   <?php if(!empty($dealerinfo["dl_wxnickname"])): ?><tr>     
                  <td height="35"   class="txtright" >微信名称：</td>
				  <td class="txtleft" ><?php echo ($dealerinfo["dl_wxnickname"]); ?></td>
			  </tr><?php endif; ?>
               <?php if(!empty($dealerinfo["dl_wxheadimg"])): ?><tr>
				  <td height="35"   class="txtright" >头像：</td>
				  <td  class="txtleft" > <img src="<?php echo ($dealerinfo["dl_wxheadimg"]); ?>"    style="width:60px; height:60px" />
				  </td>
			  </tr><?php endif; endif; ?>
			   <?php if($qypurview["90001"] == '90001'): if(($dealerinfo["dl_username"]) != ""): ?><tr>
						  <td height="35"  class="txtright" > 登录账户：</td>
						  <td  class="txtleft" ><?php echo ($dealerinfo["dl_username"]); ?>
						  </td>
					  </tr><?php endif; endif; ?>

			  <tr>     
                  <td height="35"   class="txtright" >经销商编号：</td>
				  <td class="txtleft" ><?php echo ($dealerinfo["dl_number"]); ?></td>
			  </tr>
			   <tr>     
                  <td height="35"  class="txtright" > 经销商名称：</td>
				  <td  class="txtleft" ><?php echo ($dealerinfo["dl_name"]); ?></td>
			  </tr>
			  
			   <?php if(($qypurview["10005"]) == "10005"): ?><tr>     
                  <td height="35"  class="txtright" >经销商级别：</td>
				  <td  class="txtleft" >
				   <?php echo ($dealerinfo["dl_type_str"]); ?>
				  </td>
			  </tr><?php endif; ?>
               <?php if(($dealerinfo["dlstt_name"]) != ""): ?><tr>     
					  <td height="35"  class="txtright" >门店级别：</td>
					  <td  class="txtleft" >
					   <?php echo ($dealerinfo["dlstt_name"]); ?>
					  </td>
				  </tr><?php endif; ?>
			   
			   <?php if(($qypurview["90003"]) == "90003"): ?><tr>     
                  <td height="35"  class="txtright" >上家经销：</td>
				  <td  class="txtleft" >
				    <?php echo ($dealerinfo["dl_belong_name"]); ?>
				  </td>
			  </tr>
			  <tr>     
                  <td height="40"  class="txtright" >推荐人：</td>
				  <td  class="txtleft" >
				    <?php echo ($dealerinfo["dl_referee_name"]); ?>
				  </td>
			  </tr><?php endif; ?>
			    <tr>     
                  <td height="35"  class="txtright" >联系人：</td>
				  <td  class="txtleft" ><?php echo ($dealerinfo["dl_contact"]); ?></td>
			  </tr>
			  <tr>     
                  <td height="35"  class="txtright" >电话：</td>
				  <td  class="txtleft" ><?php echo ($dealerinfo["dl_tel"]); ?></td>
			  </tr>
			   <tr>     
                  <td height="35"  class="txtright" >传真：</td>
				  <td  class="txtleft" ><?php echo ($dealerinfo["dl_fax"]); ?></td>
			  </tr>
			   <tr>     
                  <td height="35"  class="txtright" >地址：</td>
				  <td  class="txtleft" ><?php echo ($dealerinfo["dl_address"]); ?></td>
			  </tr>
			   <tr>     
                  <td height="35"  class="txtright" >Email：</td>
				  <td  class="txtleft" ><?php echo ($dealerinfo["dl_email"]); ?></td>
			  </tr>
			  
			   <tr>     
                  <td height="35"  class="txtright" >QQ：</td>
				  <td  class="txtleft" ><?php echo ($dealerinfo["dl_qq"]); ?></td>
			  </tr>
			   <tr>     
                  <td height="35"  class="txtright" >微信号：</td>
				  <td  class="txtleft" ><?php echo ($dealerinfo["dl_weixin"]); ?></td>
			  </tr>
			    <tr>     
                  <td height="40"  class="txtright" >身份证：</td>
				  <td  class="txtleft" ><?php echo ($dealerinfo["dl_idcard"]); ?></td>
			  </tr>
			   <tr>     
                  <td height="40"  class="txtright" >身份证图：</td>
				  <td  class="txtleft"  style="padding:10px 0 10px 0">
				  <?php if(($dealerinfo["dl_idcardpic_str"]) != ""): ?><a href="/Kangli/Public/uploads/dealer/<?php echo ($dealerinfo["dl_idcardpic"]); ?>" target="_blank" ><?php echo ($dealerinfo["dl_idcardpic_str"]); ?></a><?php endif; ?>
				  <?php if(($dealerinfo["dl_idcardpic2_str"]) != ""): ?><a href="/Kangli/Public/uploads/dealer/<?php echo ($dealerinfo["dl_idcardpic2"]); ?>" target="_blank" ><?php echo ($dealerinfo["dl_idcardpic2_str"]); ?></a><?php endif; ?>
				  </td>
			  </tr>

			  <tr>     
                  <td height="40"  class="txtright" >授权证书：</td>
				  <td  class="txtleft"  style="padding:10px 0 10px 0">
				  <?php if(($dealerinfo["dl_pic_str"]) != ""): ?><a href="/Kangli/Public/uploads/dealer/<?php echo ($dealerinfo["dl_pic"]); ?>" target="_blank" ><?php echo ($dealerinfo["dl_pic_str"]); ?></a><?php endif; ?>
				  </td>
			  </tr>

			   <tr>     
                  <td height="35"  class="txtright" >备注：</td>
			     <td  class="txtleft" ><?php echo ($dealerinfo["dl_remark"]); ?></td>
			  </tr>
              <tr>     
                  <td height="40"  class="txtright" >注册时间：</td>
				  <td  class="txtleft" ><?php echo (date('Y-m-d H:i:s',$dealerinfo["dl_addtime"])); ?></td>
			  </tr>
			   <tr>     
                  <td height="40"  class="txtright" >有效时间：</td>
				  <td  class="txtleft" ><?php echo ($dealerinfo["dl_date_str"]); ?></td>
			  </tr>
			</table>
</div>
</body>
</html>