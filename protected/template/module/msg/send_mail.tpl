<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>
	<{$lang->menu->sendMail}>
</title>
<link rel="stylesheet" href="/static/css/base.css" type="text/css" />
<link rel="stylesheet" href="/static/css/style.css" type="text/css" />
<link rel="stylesheet" href="/static/js/autolist/autolist.css" type="text/css" />
<script type="text/javascript" src="/static/js/jquery.min.js"></script>	
<script type="text/javascript" src="/static/js/My97DatePicker/WdatePicker.js"></script>
<script type="text/javascript" src="/static/js/autolist/autolist.js"></script>
<script type="text/javascript" src="/static/js/sorttable.js"></script>
<script type="text/javascript" src="/static/js/flowtitle.js"></script>
<script type="text/javascript" src="/static/js/colResizable-1.3.min.js"></script>
<script type="text/javascript" src="/static/js/global.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	$('#create').toggle(function(){
		$('#hideContainer').slideDown(300);
	},
	function(){
		$('#hideContainer').slideUp(300);
	});

	$('#all').click(function(){
		if($(this).attr('checked')){
		//	$('#receiver').fadeOut();
			$('#receiver').hide();
			$('#platform').show();
		}else{
		//	$('#receiver').fadeIn();
			$('#receiver').show();
			$('#platform').hide();
		}
	});
	$('input[type=submit]').click(function(){
		$(this).val('提交中...');
		$(this).attr('disabled', 'disabled');
		$("#myform2").submit();
	})
})
</script>
<!-- start 支持as3 的富文本编辑器	-->
		<link rel="stylesheet" type="text/css" href="/static/richTextEditor/richTextEditor.css" />
        <script type="text/javascript" src="/static/richTextEditor/history/history.js"></script>
        <script type="text/javascript" src="/static/richTextEditor/swfobject.js"></script>
        <script type="text/javascript">
            var swfVersionStr = "10.0.0";
            var xiSwfUrlStr = "/static/richTextEditor/playerProductInstall.swf";
            var flashvars = {};
            var params = {};
            params.quality = "high";
            params.bgcolor = "#ffffff";
            params.allowscriptaccess = "sameDomain";
            params.allowfullscreen = "true";
            var attributes = {};
            attributes.id = "richTextEditor";
            attributes.name = "richTextEditor";
            attributes.align = "middle";
            swfobject.embedSWF(
                "/static/richTextEditor/richTextEditor.swf", "flashContent",
                "100%", "100%", 
                swfVersionStr, xiSwfUrlStr, 
                flashvars, params, attributes);
			swfobject.createCSS("#flashContent", "display:block;text-align:left;");
			
			function setHtmlToEditor(){
				var str = '<{$content}>';
				return str;
			}
			
			function getHtmlFromEditor(strHtml){
				document.getElementById("content").value = strHtml;
			}
        </script>
<!-- end 支持as3 的富文本编辑器 -->

</head>

<body>
<div id="position">
<b><{$lang->menu->class->msgManage}>：<{$lang->menu->sendMail}></b>
</div> 

<!-- Start 成功信息提示 -->
<{if $successMsg}>
<div class="success_msg_box">
	<{$successMsg}>
</div>
<{/if}>
<!-- End 成功信息提示 -->

<!-- Start 错误信息提示 -->
<{if $errorMsg}>
<div class="error_msg_box">
	<{$errorMsg}>
</div>
<{/if}>
<!-- End 错误信息提示 -->
<div class='divOperation'>
<input type="button" id="create" value="创建新邮件"/>
<div id="hideContainer" style="<{if not $displayForm}>display:none;<{/if}> z-index:999;">
<form id="myform2" name="myform2" method="post" action="<{$current_uri}>">
	<table width="800px">
	<tr>
		<td valign="top"><label for="title">邮件标题:</label></td>
		<td><input type="text" name="title" id="title" size="120" value="<{$title}>"/></td>
	</tr>
	<tr>
		<td valign="top">收件人:</td>
		<td>
			<input type="text" name="receiver" id="receiver" size="120" value="<{$receiver}>"/>
			
			<div id="platform" style="display:none;">
			选择平台:
			<input type="radio" name="pf" value="" <{if !$pf }>checked="checked"<{/if}> />所有
			<{foreach from=$dictPlatform item=pfname key=key}>
			<input type="radio" name="pf" value="<{$key}>" <{if $key==$pf }>checked="checked"<{/if}> /><{$pfname}>
			<{/foreach}>
			</div>
			<div>发送给所有在线玩家<input type="checkbox" id="all" name="all" <{if $all}>checked="checked"<{/if}> /></div>
		</td>
	</tr>
	<tr>
		<td valign="top"><label for="content">邮件内容:</label></td>
		<td>
			<!-- start 支持as3 的富文本编辑器	-->
			<div id="richTextEditorDiv" style="width:735px; height:335px;">
        	<!-- start 若版本不支持 打印提示	-->
	        <div id="flashContent">
	        	<p>
		        	To view this page ensure that Adobe Flash Player version 
					10.0.0 or greater is installed. 
				</p>
				<script type="text/javascript"> 
					var pageHost = ((document.location.protocol == "https:") ? "https://" :	"http://"); 
					document.write("<a href='http://www.adobe.com/go/getflashplayer'><img src='"+ pageHost + "www.adobe.com/images/shared/download_buttons/get_flash_player.gif' alt='Get Adobe Flash player' /></a>" ); 
				</script> 
			</div>
			<!-- end  若版本不支持 打印提示	-->
	   	 
	       	<noscript>
	            <object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" width="100%" height="100%" id="richTextEditor">
	                <param name="movie" value="richTextEditor.swf" />
	                <param name="quality" value="high" />
	                <param name="bgcolor" value="#ffffff" />
	                <param name="allowScriptAccess" value="sameDomain" />
	                <param name="allowFullScreen" value="true" />
	                <!--[if !IE]>-->
	                <object type="application/x-shockwave-flash" data="/static/richTextEditor/richTextEditor.swf" width="100%" height="100%">
	                    <param name="quality" value="high" />
	                    <param name="bgcolor" value="#ffffff" />
	                    <param name="allowScriptAccess" value="sameDomain" />
	                    <param name="allowFullScreen" value="true" />
	                <!--<![endif]-->
	                <!--[if gte IE 6]>-->
	                	<p> 
	                		Either scripts and active content are not permitted to run or Adobe Flash Player version
	                		10.0.0 or greater is not installed.
	                	</p>
	                <!--<![endif]-->
	                    <a href="http://www.adobe.com/go/getflashplayer">
	                        <img src="http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif" alt="Get Adobe Flash Player" />
	                    </a>
	                <!--[if !IE]>-->
	                </object>
	                <!--<![endif]-->
	            </object>
		    </noscript>	
			</div>
			<!-- end 支持as3 的富文本编辑器	-->
			
			<textarea style="display:none;" rows="17" cols="50" id="content" name="content">
			</textarea>
		</td>
	</tr>

	<tr>
		<td colspan="2" align="right"><input type="submit" value="提交" /><br /></td>
	</tr>
	</table>
</form>
</div>
</div>
<br class="clear" />

<{if $viewData}>
	<table cellspacing="1" cellpadding="3" border="0" class='table_list sortable' style="width: 100%; float: left;" >
	<caption class='table_list_head'>
		<{$lang->msg->historyMsg}>
	</caption>
	<thead>
	<tr class='table_list_head'>
        <th width="2%" align="center">ID</th>
        <th width="15%" align="center"><{$lang->msg->title}></th>
        <th width="29%" align="center"><{$lang->msg->content}></th>
        <th width="10%" align="center"><{$lang->msg->sendTime}></th>
        <th width="30%" align="center"><{$lang->msg->receiver}></th>
        <th width="7%" align="center"><{$lang->msg->successCount}></th>
        <th width="7%" align="center"><{$lang->msg->failCount}></th>
        <th width="5%" align="center">&nbsp;</th>
	</tr>
	</thead>
	<tbody>
	<{foreach name=loop from=$viewData item=item}>
	<tr class='<{cycle values="trEven,trOdd"}>'>
		<td align="center"><{$item.id}></td>
		<td align="center"><{$item.title}></td>
		<td style="background: #223A3D;"><{$item.content}></td>
		<td align="center"><{$item.mtime|date_format:"%Y-%m-%d %H:%M:%I"}></td>
		<td align="center"><{if $item.receiver eq 'all'}><{$item.pf}> 所有在线玩家<{else}><{$item.receiver}><{/if}></td>
		<td align="center"><{$item.success}></td>
		<td align="center"><{if $item.fail gt 0}><font color="red" style="font-weight:bold;"><{/if}><{$item.fail}><{if $item.fail gt 0}></font><{/if}></td>
		<td align="center"><a href="?action=del&id=<{$item.id}>" onclick="return confirm('<{$lang->page->confirmDel}>');"><{$lang->page->del}></a></td>
	</tr>
	<{/foreach}>
	</tbody>
</table>
<{else}>
<{*<font color='red'><{$lang->page->noData}></font>*}>
<{/if}>

</body>
</html>
