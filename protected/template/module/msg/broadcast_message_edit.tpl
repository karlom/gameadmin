<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>消息广播管理</title>
<link rel="stylesheet" href="/static/css/base.css" type="text/css">
<style type="text/css">
body {
	font-size: 14px;
	font-family: "Courier New", Courier, monospace;
	text-align: center;
	margin: auto;
}

#all {
	text-align: left;
	margin-left: 4px;
}

#nodes {
	width: 100%;
	border: 1px #ccc solid;
}

#result {
	width: 100%;
	height: 100%;
	clear: both;
	border: 1px #ccc solid;
}
</style>
<script type="text/javascript" src="/static/js/jquery.min.js"></script>
<script type="text/javascript" src="/static/js/My97DatePicker/WdatePicker.js"></script> 
<script type="text/javascript" src="/static/js/MValidate.js"></script> 
<script type="text/javascript">
	$(document).ready(function(){
		$("#msgCenter").click(function(){
			if($(this).attr("checked")==true) {
				$("#notice").show("normal");
				$("#content").show();
				$("#richTextEditorDiv").hide();
			} else {
				$("#notice").hide("normal");
			}
		});
		$("#editor").click(function(){
			$("#richTextEditor").remove();
			$("#richTextEditorDiv").append("<div id='flashContent'></div>");
			loadswf();
			$("#content").hide();
			$("#richTextEditorDiv").show();
		});
		$("#textarea").click(function(){
			$("#content").show();
			$("#richTextEditorDiv").hide();
		});
	});

</script>
<!-- start 支持as3 的富文本编辑器	-->
		<link rel="stylesheet" type="text/css" href="/static/richTextEditor/richTextEditor.css" />
        <script type="text/javascript" src="/static/richTextEditor/history/history.js"></script>
        <script type="text/javascript" src="/static/richTextEditor/swfobject.js"></script>
        <script type="text/javascript">
        	function loadswf(){
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
			}

			
			function setHtmlToEditor(){
//				var str = '<{$content}>';
				var str = document.getElementById("content").value;
				return str;
			}
			
			function getHtmlFromEditor(strHtml){
				document.getElementById("content").value = strHtml;
			}
			
			loadswf();
			
        </script>
<!-- end 支持as3 的富文本编辑器 -->
</head>

<body>
	<div id="position">消息管理：消息广播列表</div>
<div id="all">
<div id="main">
<div class="box">
<div id="nodes">
<form id="myform" action="<{$smarty.const.URL_SELF}>" method="POST">
<table width="100%" border="0" cellpadding="4" cellspacing="1"
	bgcolor="#A5D0F1">
	<tr bgcolor="FFFFFF">
		<td width="15%">消息类型说明：</td>
		<td>【高亮信息/浮动提示/鼠标】不可以使用html代码，其他类型可以</td>
	</tr>
	<!--
	<tr bgcolor="FFFFFF">
		<td width="15%">发送类型说明：</td>
		<td>
		<li>【日期时间范围】、【按星期】、【开服后】：循环消息，在指定日期内，每天的时间段内开始循环，开始时间＜结束时间</li>
		<li>【连续时间区间】：循环消息，从开始日期 的 开始时间 到结束日期的 结束时间，不间断发布消息</li>
		</td>
	</tr>
	-->
	<td colspan="2" background="/static/images/wbg.gif">
		<font color="#666600" class="STYLE2"> <b> ◆消息广播-<{if $action == "add"}>新增<{elseif $action == "edit"}>修改<{else}>查看<{/if}> </b> </font></td>
	</tr>
	<tr bgcolor="#E5F9FF">
		<td width="15%">消息位置:</td>
		<td>
			<{* value 设置规则：2的value次方＝对应频道的值，如活动频道的值是32，这里value＝5，2E5＝32 *}>
			<input id="msgUp" name="type[]" type="checkbox" value="0" <{if 1==($type%2) }>checked<{/if}> />全服公告
			<input id="msgCenter" name="type[]" type="checkbox" value="1" <{if 1==($type/2)%2 }>checked<{/if}> />突出高亮信息
			<input id="msgDown" name="type[]" type="checkbox" value="2" <{if 1==($type/4)%2 }>checked<{/if}> />浮动提示
			<input id="msgMouse" name="type[]" type="checkbox" value="3" <{if 1==($type/8)%2 }>checked<{/if}> />鼠标
			<input id="msgChat" name="type[]" type="checkbox" value="4" <{if 1==($type/16)%2 }>checked<{/if}> />系统聊天频道
			<input id="msgActChat" name="type[]" type="checkbox" value="5" <{if 1==($type/32)%2 }>checked<{/if}> />活动聊天频道
			<input id="allChannel" name="type[]" type="checkbox" value="14" <{if 1==($type/16384)%2 }>checked<{/if}> />全频道
			(PS：全频道已包含系统和活动聊天频道)
		</td>
	</tr>
	<tr bgcolor="#E5F9FF">
		<td width="15%">发送类型:</td>
		<td>
			<input name="send_type" type="radio" value="0" <{if 0==$send_type}>checked<{/if}> />立即
			<input name="send_type" type="radio" value="1" <{if 1==$send_type}>checked<{/if}> />日期时间
	<!--
			<input name="send_type" type="radio" value="2" />星期
			<input name="send_type" type="radio" value="3" />开服后
			<input name="send_type" type="radio" value="4" />一段时间
	-->
		</td>
	</tr>
	<tr bgcolor="#E5F9FF">
		<td width="15%"><span id="start_date_label">开始日期</span>:</td>
		<td>
		<input type="text" id="start_date" name="start_date"
			style="width: 80px;" class="Wdate"
			onfocus="WdatePicker({dateFmt:'yyyy-MM-dd'});" value="<{$start_date}>" />
		<input type="text" id="start_date_time" name="start_date_time" style="width: 80px;" class="Wdate" onfocus="WdatePicker({dateFmt:'HH:mm:ss'});" value="<{$start_date_time}>" />
		</td>
	</tr>
	<tr bgcolor="#E5F9FF">
		<td width="15%"><span id="end_date_label">结束日期</span>:</td>
		<td>
		<input type="text" id="end_date" name="end_date"
			style="width: 80px;" class="Wdate"
			onfocus="WdatePicker({dateFmt:'yyyy-MM-dd'});" value="<{$end_date}>" />
		<input type="text" id="end_date_time" name="end_date_time" style="width: 80px;" class="Wdate" onfocus="WdatePicker({dateFmt:'HH:mm:ss'});" value="<{$end_date_time}>" />
		</td>
	</tr>
	<tr bgcolor="#E5F9FF">
		<td width="15%"><span id="start_time_label">开始时间</span>:</td>
		<td>
		<input type="text" id="start_time" name="start_time"
			style="width: 80px;" class="Wdate"
			onfocus="WdatePicker({dateFmt:'HH:mm:ss'});" value="<{$start_time}>" /></td>
	</tr>
	<tr bgcolor="#E5F9FF">
		<td width="15%"><span id="end_time_label">结束时间</span>:</td>
		<td>
		<input type="text" id="end_time" name="end_time"
			style="width: 80px;" class="Wdate"
			onfocus="WdatePicker({dateFmt:'HH:mm:ss'});" value="<{$end_time}>" /></td>
	</tr>
	<tr bgcolor="#E5F9FF">
		<td width="15%">间隔时间(单位:秒):</td>
		<td><input type="text" id="interval" name="interval" value="<{$interval}>" />(间隔要大于等于10秒)</td>
	</tr>
	<tr bgcolor="#E5F9FF">
		<td width="15%">
			消息内容:<br />
			<input type="button" id="editor" value="编辑器"/>
			<input type="button" id="textarea" value="文本框"/>
		</td>
		<td>
			<!-- start 支持as3 的富文本编辑器	-->
			<div id="richTextEditorDiv" style="width:514px; height:280px;">
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
			<textarea style="display:none;" rows="8" cols="60" id="content" name="content"><{$content}></textarea>
			<span id="notice" style="display:none;color:#EE0000">注意：你已选择了突出高亮信息，不能使用任何html代码！如有需要，请分条设置。</span>
		</td>
	</tr>
	<tr bgcolor="#E5F9FF">
		<td colspan="2">
			<input type="hidden" name="id" id="id" value="<{$id}>" />
			<input type="hidden" name="action" id="action" value="save" />
    		<{if $action == "add" || $action == "edit"}>
    		<input type="button" name="save" id="save" value="保存" />
    		<{/if}>
    		<input type="button" name="back" id="back" value="返回" onclick="back1();" />
		</td>
	</tr>
</table>
</form>
</div>
</div>
</div>

</div>
<div id="tipsDiv">
<table width="100%" border="0" cellpadding="4" cellspacing="1" bgcolor="#A5D0F1">
	<tr><td align="left" style="color:#880000;background-color:#FFFFFF">【注意】：不清楚消息广播位置请不要随便设置！</td></tr>
	<tr align="left" valign="top" bgcolor="FFFFFF">
		<td>【小提示】： <br />
		超级链接：&lt;a href=&quot;这里写网址&quot;
		target=&quot;_blank&quot;&gt;&lt;U&gt;这里写链接描述&lt;/U&gt;&lt;/a&gt;<br>
		文字颜色：&lt;font color=&quot;#FF0000&quot;&gt;这里写文字&lt;/font&gt;<br>
		文字粗体：&lt;B&gt;文字是粗体&lt;/B&gt;<br> 换行标签：&lt;br&gt;<br> <font
			color="#FF0000">红色：</font>#FF0000 &nbsp;&nbsp;&nbsp;&nbsp; <font
			color="#0000FF">蓝色：</font>#0000FF &nbsp;&nbsp;&nbsp;&nbsp; <font
			color="#00FF00">绿色：</font>#00FF00 &nbsp;&nbsp;&nbsp;&nbsp; <font
			color="#FF00FF">紫色：</font>#FF00FF &nbsp;&nbsp;&nbsp;&nbsp; <font
			color="#000000">黑色：</font>#000000 &nbsp;&nbsp;&nbsp;&nbsp; <font
			color="#FFFF00" style="background-color: black">黄色：</font>&nbsp;
		#FFFF00 &nbsp;&nbsp;&nbsp;&nbsp; <font color="#FFFFFF"
			style="background-color: black">白色：</font>&nbsp; #FFFFFF
		&nbsp;&nbsp;&nbsp;&nbsp; <font color="#FF7F00">橙色：</font>&nbsp;
		#FF7F00 &nbsp;&nbsp;&nbsp;&nbsp;<br />
		也可以到<a href="http://www.114la.com/other/rgb.htm" target="_blank"><font color="#0000FF">RGB颜色查询对照表</font></a>查询，使用你喜欢的颜色
		</td>
	</tr>
</table>
</div>


<script language="JavaScript" type="text/JavaScript">
var id = <{if $id}><{$id}><{else}>0<{/if}>;
var send_type = "<{$send_type}>";
var action = "<{$action}>";
$(document).ready(function(){
	if(0 == send_type){
    	$("#start_date").val("").attr("disabled", true);
    	$("#end_date").val("").attr("disabled", true);
    	$("#start_date_time").val("").attr("disabled", true);
    	$("#end_date_time").val("").attr("disabled", true);
    	$("#start_time").val("").attr("disabled", true);
    	$("#end_time").val("").attr("disabled", true);
    	$("#interval").val("").attr("disabled", true);
	}
	if("show" == action){
    	$("#start_date").attr("disabled", true);
    	$("#end_date").attr("disabled", true);
    	$("#start_date_time").val("").attr("disabled", true);
    	$("#end_date_time").val("").attr("disabled", true);
    	$("#start_time").attr("disabled", true);
    	$("#end_time").attr("disabled", true);
    	$("#interval").attr("disabled", true);
		$("input[name=type[]]").attr("disabled", "disabled");
		$("input[name=send_type]").attr("disabled", "disabled");
		$("textarea[id=content]").attr("disabled", "disabled");
	}
	
	$("input[name=send_type]").click(function(){
		if(0 == $("input[name=send_type]:checked").val()){
    		$("#start_date").val("").attr("disabled", true);
    		$("#end_date").val("").attr("disabled", true);
	    	$("#start_date_time").val("").attr("disabled", true);
	    	$("#end_date_time").val("").attr("disabled", true);
    		$("#start_time").val("").attr("disabled", true);
    		$("#end_time").val("").attr("disabled", true);
    		$("#interval").val("").attr("disabled", true);
		}else{
    		$("#start_date").val("").attr("disabled", "");
    		$("#end_date").val("").attr("disabled", "");
	    	$("#start_date_time").val("").attr("disabled", "");
	    	$("#end_date_time").val("").attr("disabled", "");
    		$("#start_time").val("").attr("disabled", "");
    		$("#end_time").val("").attr("disabled", "");
    		$("#interval").val("").attr("disabled", "");
		}
	});
	$("input[id=save]").click(function(){
		var action = "<{$action|trim}>";
		var foreign_id = $("#foreign_id").val();
		var interval = $("#interval").val();
//		var type = $("input[name=type]:checked").val();
		var send_type = $("input[name=send_type]:checked").val();
		var start_date = $("#start_date").val();
		var end_date = $("#end_date").val();
		var start_time = $("#start_time").val();
		var end_time = $("#end_time").val();
		var content = $.trim($("#content").val());
		var type;
		//检查是否已选有消息类型
		$("input[name=type[]]").each(function(){
			if($(this).attr("checked") == true ) {
				type = true;
			}
		});
		if(!type){
			alert("请选择消息类型！");
			return;
		}
		if(0 != send_type){
	    	var NowDate = getNowDate();
	    	if(!MValidate.isDate(start_date,"yyyy-MM-dd")){
	    		alert("请输入合法的开始日期");
	    		return;
	    	}
	    	if(!MValidate.isDate(end_date,"yyyy-MM-dd")){
	    		alert("请输入合法的结束日期");
	    		return;
	    	}
	    	if(!MValidate.isTime(start_time,"HH:mm:ss")){
	    		alert("请输入合法的开始时间");
	    		return;
	    	}
	    	if(!MValidate.isTime(end_time,"HH:mm:ss")){
	    		alert("请输入合法的结束时间");
	    		return;
	    	}
	    	if(!(MValidate.compareToDate(end_date,start_date) >= 0)){
	    		 	alert("结束日期不能大于开始日期");
	    			return;
	    	}
	    	if(!(MValidate.compareToTime(end_time,start_time) >= 0)){
	    	 	alert("结束时间不能大于开始时间");
	    		return;
	    	}
			if(10 > interval){
				alert("间隔时间必须为大于10秒!");
				$("#interval").focus();
				return;
			}
		}
		if(content == ""){
			alert("请输入消息内容！");
			$("#content").focus();
			return;
		}
//		if(type == "2"){
//			if(MValidate.bigLength(content,180)){
//				alert("中央广播消息长度不可以超过180");
//				$("#content").focus();
//				return;
//			}
//		}
		if(action == "add"){
			id = 0;
		}else if(action == "edit"){
			if(id == 0 || id == ""){
				alert("此记录修改操作出错，请返回列表重新操作");
				return;
			}
		}
		$("form[id=myform]").submit();
	});
	
});
function back1(){
	location.href = "<{$smarty.const.URL_SELF}>";
}
function getNowDate(){
	var d = new Date();
	var s = "";
	s += d.getFullYear() + "-";
	s += (d.getMonth() + 1) + "-";
	s += d.getDate() + " ";
	s += d.getHours() + ":";
	s += d.getMinutes() + ":";
	s += d.getSeconds();
	return s;      
}
</script>

</body>
</html>
