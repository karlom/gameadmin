<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
<link rel="stylesheet" href="/static/css/base.css" type="text/css" />
<link rel="stylesheet" href="/static/css/style.css" type="text/css" />
<!-- start 支持as3 的富文本编辑器	-->
<link rel="stylesheet" type="text/css" href="/static/richTextEditor/richTextEditor.css" />
<script type="text/javascript" src="/static/richTextEditor/history/history.js"></script>
<script type="text/javascript" src="/static/richTextEditor/swfobject.js"></script>
<script type="text/javascript">
    var swfVersionStr = "10.0.0";
    var xiSwfUrlStr = "/static/richTextEditor/playerProductInstall.swf";
    var flashvars = {};
	flashvars.color = "";
	flashvars.font = "";
	flashvars.size = "";
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
        var str = "<{$flashConent}>";
        return str;
    }

    function getHtmlFromEditor(strHtml){
        document.getElementById("content").value = strHtml;
    }

</script>
<!-- end 支持as3 的富文本编辑器	-->

<script type="text/javascript" src="/static/js/jquery.min.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
        $("#richTextEditor").keyup(function(){
            $("#content").html($(this).val()).css("display","block");
        });
		$("#content").keyup(function(){
			document.getElementById("richTextEditor").setText($(this).val());
		});
		$("#save").click(function(){
			if(!confirm('确认要保存<{$agent_name}>代理<{$server_id}>服的连续登录公告？')){
				return false;
			}
			else{
				$("#frm").submit();
			}
		});
    });
</script>

</head>

<body>
<div id="position">系统管理：公告设置</div>
<form action="<{$URL_SELF}>" id="frm" method="POST" >
	<table cellspacing="1" cellpadding="5" class="SumDataGrid" width="800">
		<tr>
			<td><textarea style="display:block;float:right;" rows="17" cols="50" id="content" name="content"><{$content}></textarea>

<!-- start 支持as3 的富文本编辑器	-->
<div id="richTextEditorDiv" style="width:300px; height:340px;">
<!-- start 若版本不支持 打印提示	-->
<div id="flashContent">
    <p>
        To view this page ensure that Adobe Flash Player version
        10.0.0 or greater is installed.
    </p>
    <script type="text/javascript">
        var pageHost = ((document.location.protocol == "https:") ? "https://" :	"http://");
        document.write("<a href='http://www.adobe.com/go/getflashplayer'><img src='"
                        + pageHost + "www.adobe.com/images/shared/download_buttons/get_flash_player.gif' alt='Get Adobe Flash player' /></a>" );
    </script>
</div>
 <!-- end  若版本不支持 打印提示	-->

<noscript>
    <object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" width="100%" height="100%" id="richTextEditor">
        <param name="movie" value="/static/richTextEditor/richTextEditor.swf" />
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
			</td>
		</tr>
		<tr>
			<td colspan="2"><input type="button" style="width:100px;height:50px;" id="save" name="save" value="保存" /></td>
		</tr>
	</table>
</form>
<table class="DataGrid" width="500">
	<tr>
    	<td><p>链接范例:<br />
        	&lt;u&gt;&lt;a href='这里写网址'&gt;这里写链接&lt;/a&gt;&lt;/u&gt;<br />
            &lt;u&gt;&lt;a href='event:bbsUrl'&gt;论坛&lt;/a&gt;&lt;/u&gt;                        <br />
            &lt;u&gt;&lt;a href='event:officialWebsite'&gt;官网&lt;/a&gt;&lt;/u&gt;<br />
            &lt;u&gt;&lt;a href='http://www..com' target='_blank'&gt;网络&lt;/a&gt;&lt;/u&gt;<br />
  	    </td>
    </tr>
</table>
<{if $strMsg}>
	<table class="SumDataGrid" width="1000" style="margin-top:10px;"><tr><td><font color="#FF0000"><{$strMsg}></font></td></tr></table>
<{/if}>
</body>
</html>
