<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<title><{$lang->menu->loginNotice}></title>
<meta http-equiv="Content-Type" content="text/html; charset='UTF-8'" />
<link rel="stylesheet" href="/static/css/base.css" type="text/css">
<link rel="stylesheet" href="/static/css/style.css" type="text/css" />
<script type="text/javascript" src="/static/js/jquery.min.js"></script>
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
		var str = '<{$loginNotice}>';
		return str;
	}
	
	function getHtmlFromEditor(strHtml){
		document.getElementById("content").value = strHtml;
	}
	$(document).ready(function(){
		$("input[id=loginNoticeBtn]").click(function(){
			var serverNum = 0;
			$("input[name*=loginNoticeServerList]:checked").each(function(){
				serverNum++;
			});
			if(0 == serverNum){
				alert("<{$lang->basedataconfig->pleaseSelectServer}>");
				return false;
			}
		});
	});
</script>
<!-- end 支持as3 的富文本编辑器 -->
<style type="text/css">
	.hoverTd{
		background-color:#D7C8EA;
	}
	#bossList{
		position: fixed; width: 200px; height: 100%; background: none repeat scroll 0 0 #FFFFFF;
	}
	#bossDetail{
		width: 70%; margin-left: 205px;
	}
	#bossList ul{
		width: 100%;
	}
	.li{
		padding: 5px 5px; margin-bottom: 2px;
	}
	.li:hover{
		background-color:#EDF2F7;
	}
	.trItem{
		background-color: #87CEEB;
	}
	.trItem2{
		background-color: #c0c0c0;
	}
</style>
<body>
<div id="position">
<b><{$lang->menu->class->baseDataConfig}>：<{$lang->menu->loginNotice}></b>
</div>
<{if $msg}>
<div style="margin: 5px; color: red; width: 60%;">
	<{foreach from=$msg item=item}>
	<div style="margin: 5px 0;"><{$item}></div>
	<{/foreach}>
</div>
<{/if}>
<form name="myform" action="<{$smarty.const.URL_SELF}>" method="POST">
<table style="width: 645px; height: 470px;">
	<tr>
		<td style="width: 100%; height: 100%;">
			<!-- start 支持as3 的富文本编辑器	-->
			<div id="richTextEditorDiv" style="width: 100%; height: 100%;">
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
	                <param name="font" value="宋体" />
	                <!--[if !IE]>-->
	                <object type="application/x-shockwave-flash" data="/static/richTextEditor/richTextEditor.swf" width="100%" height="100%">
	                    <param name="quality" value="high" />
	                    <param name="bgcolor" value="#ffffff" />
	                    <param name="allowScriptAccess" value="sameDomain" />
	                    <param name="allowFullScreen" value="true" />
	                    <param name="font" value="宋体" />
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
			
			<textarea style="display:none;" rows="17" cols="50" id="content" name="content"><{$loginNotice}></textarea>
		</td>
	</tr>
</table>
<table style="width: 645px;">
	<tr>
		<td>
			<{$lang->basedataconfig->needSyncServer}>：<br />
			<{foreach from=$serverList key=key item=item}>
			<{if 1 == $item.available}>
			<input name="loginNoticeServerList[]" type="checkbox" value="<{$key}>" <{if $key==$smarty.session.gameAdminServer}>checked<{/if}> /><{if "" != $item.name}><{$item.name}><{else}><{$key}><{/if}> 
			<{/if}>
			<{/foreach}>
		</td>
	</tr>
	<tr>
		<td align="center"><input name="action" type="hidden" value="setLoginNotice" /><input id="loginNoticeBtn" type="submit" value="<{$lang->page->submit}>" /></td>
	</tr>
</table>
</form>
</body>
</html>
