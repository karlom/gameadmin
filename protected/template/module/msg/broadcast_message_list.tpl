<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>消息广播管理</title>
<link rel="stylesheet" href="/static/css/base.css" type="text/css">
<style type="text/css">
body {font-size:14px; font-family:"Courier New", Courier, monospace; text-align:center; margin:auto;}
#all {text-align:left;margin-left:4px;}
#nodes {width:98%; float:left;border:1px #ccc solid;}
#result {width:98%; height:100%; clear:both; border:1px #ccc solid;}

</style>
<script type="text/javascript" src="/static/js/jquery.min.js"></script>
<script type="text/javascript">
</script>
</head>

<body>
	<div id="position">消息管理：消息广播列表</div>
<div id="all">
<div id="main">
<div class="box">
<div id="nodes">
<table width="100%" border="0" cellpadding="4" cellspacing="1" bgcolor="#A5D0F1">
	<tr bgcolor="#E5F9FF">
		<td colspan="7">
			<input type="button" name="add" id="add" value="新增" onclick="add();" /> 
			<input type="button" name="del" id="del" value="删除" onclick="del();" />
			<input type="button" name="post" id="post" value="同步管理后台其它服" onclick="show();" />
			<input type="button" name="sync" id="sync" value="同步到游戏服务器" onclick="sync();" />
		</td>
	</tr>
</table>
<{if $errorMsg}>
<{foreach from=$errorMsg item=item}>
<div class="red"><{$item}></div>
<{/foreach}>
<{/if}>
<table width="100%" border="0" cellpadding="4" cellspacing="1" bgcolor="#A5D0F1">
	<tr bgcolor="#E5F9FF">
		<td colspan="8" background="/static/images/wbg.gif">
			<font color="#666600" class="STYLE2"><b>◆消息广播列表</b></font>
		</td>
	</tr>
	<tr bgcolor="#E5F9FF">
		<td width="20"><input type="checkbox" id="selectAll" value="" onclick="selectAll(this);" /></td>
		<td width="30">Id</td>
		<td width="150">消息类型</td>
		<td width="80">发送类型</td>
		<td width="180">时间</td>
		<td width="100">时间间隔(秒)</td>
		<td>消息内容</td>
		<td width="80">操作</td>
	</tr>
	<{foreach from=$dataResultSet item=item}>
	<tr bgcolor="#FFFFFF">
		<td><input type="checkbox" name="selectItem" value="<{$item.id}>" /> </td>
		<td><{$item.id}></td>
		<td>
    		<{if ($item.type%2)==1 }>全服公告<{/if}><{if (($item.type/2)%2)==1 }>/ 突出高亮信息<{/if}><{if (($item.type/4)%2)==1 }>/ 浮动提示<{/if}>
    		<{if (($item.type/8)%2)==1 }>/ 鼠标<{/if}><{if (($item.type/16)%2)==1 }>/ 系统聊天频道<{/if}><{if (($item.type/32)%2)==1 }>/ 活动聊天频道<{/if}>
			<{if (($item.type/16384)%2)==1 }>/ 全频道<{/if}>
		</td>
		<td>
			<{if $item.send_type eq 0}> 立即 <{elseif $item.send_type eq 1}> 日期时间<{/if}>
		</td>
		<td><{$item.begindate}><br /><{$item.enddate}></td>
		<td><{$item.interval}></td>
		<td style="background-color:#223A3D"><{$item.content}></td>
		<td>
			<a href="?action=show&id=<{$item.id}>">查看</a>
			<a href="?action=edit&id=<{$item.id}>">修改</a>
		</td>
	</tr>
	<{foreachelse}>
	<tr bgcolor="#FFFFFF">
		<td colspan="8"><font color="#FF0000">暂无数据</font></td>
	</tr>
	<{/foreach}>
	
	
</table>
<br/>
<table width="100%" border="0" cellpadding="4" cellspacing="1" id="tb_server" bgcolor="#A5D0F1" style="display:none;" >
	<tr bgcolor="#E5F9FF">
		<td colspan="7">
		<{foreach from=$serverList item=item key=key}>
			<{if 1 == $item.available}>
			<{if $key == $smarty.session.gameAdminServer}>
			<input type="checkbox" name="servers" value="<{$key}>" disabled ><{if $item.name}><{$item.name}><{else}><{$key}>服<{/if}>
			<{else}>
			<input type="checkbox" name="servers" value="<{$key}>" ><{if $item.name}><{$item.name}><{else}><{$key}>服<{/if}>
			<{/if}>
			<{/if}>
		<{/foreach}>
		</td>
	</tr>
	<tr bgcolor="#E5F9FF">
		<td  colspan="7">
		<input type='button' value='确定' name='copy' id="copy" onclick="copy();" />
			<input type="button" name ="back" id="back" value="返回" onclick="cancel();" />
		</td>
	</tr>
</table>

</div>
</div>

</div>
</div>

<script language="JavaScript" type="text/JavaScript">
function cancel(){
	window.location.href = "?action=list";
}

function copy(){
	var msg_ids = new Array(); 
	var i = 0;
	$("input[name='selectItem']@[checked]").each(function(){
			msg_ids[i] = $(this).val();
			i++;
	});
	if(i < 1){
		alert("请选择一条或多条消息广播记录，再执行操作");
		return ;
	}
	var server_ids= new Array();
	var j=0;
	$("input[name='servers']@[checked]").each(function(){
		server_ids[j] = $(this).val();
		j++;
	});
	if(j < 1){
		alert("请选择要同步的服务器，再执行操作");
		return ;
	}
	window.location.href = "?action=copy&msg_ids=" + msg_ids + "&server_ids="+server_ids;
}

function selectAll(SelectObj){
	var selected = SelectObj.checked;
	if(selected){
		$("input:checkbox[name='selectItem']").attr("checked",true);
	}else{
	    $("input:checkbox[name='selectItem']").attr("checked",false);
	}
}
function add(){
	window.location.href = "?action=add";
}

function post(){
	var ids = new Array(); 
	var i = 0;
	$("input[name='selectItem']@[checked]").each(function(){
			ids[i] = $(this).val();
			i = i + 1;
	});
	if(ids.length < 1){
		alert("请选择一条或多条消息广播记录，再执行操作");
		return ;
	}else{
		window.location.href = "?action=post&ids=" + ids;
	}
}

function show(){
	var i = 0;
	$("input[name='selectItem']@[checked]").each(function(){
			i = i + 1;
	});
	if(i < 1){
		alert("请选择一条或多条消息广播记录，再执行操作");
		return ;
	}
	
	$("#selectAll").attr("disabled","true");
	$("input[name='selectItem']").each(function(){
		if($(this).attr('checked')==false){
			$(this).parent().parent().attr("style","display:none;"); 
		}
	});
	$("#tb_server").attr("style","");
}

function del(){
	var ids = new Array(); 
	var i = 0;
	$("input[name='selectItem']@[checked]").each(function(){
			ids[i] = $(this).val();
			i = i + 1;
	});
	if(ids.length < 1){
		alert("请选择一条或多条消息广播记录，再执行操作");
		return ;
	}else{
		if(confirm("确认删除所选择的消息广播记录？")){
//			alert(ids);
			window.location.href = "?action=del&ids=" + ids;
		}else{
			return ;
		}
	}
}

//同步到游戏服务器
function sync(){
	var msg_ids = new Array(); 
	var i = 0;
	$("input[name='selectItem']@[checked]").each(function(){
			msg_ids[i] = $(this).val();
			i++;
	});
	if(i < 1){
		alert("请选择一条或多条消息广播记录，再执行操作");
		return ;
	}
	window.location.href = "?action=sync&msg_ids=" + msg_ids;
}
</script>

</body>
</html>

