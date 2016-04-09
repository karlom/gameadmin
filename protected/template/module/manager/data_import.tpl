<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset='UTF-8'" />
<link rel="stylesheet" href="/static/css/base.css" type="text/css">
<link rel="stylesheet" href="/static/css/style.css" type="text/css" />
<script type="text/javascript" src="/static/js/jquery.min.js"></script>
<script type="text/javascript" src="/static/js/ip.js"></script>
<script type="text/javascript" src="/static/js/global.js"></script>
<script language="javascript">
	$(document).ready(function(){

		//==========start  role form =====

		$("#role_name").keydown(function(){
			$("#account_name").val('');
		});
		$("#account_name").keydown(function(){
			$("#role_name").val('');
		});
		
		$("#insert").click(function(){
			var sel_ser = $("#server").val();
			var sel_day = $("#date").val();
			var sel_time = $("#time").val();
			var sel_minute = $("#minute").val();
			
			var v_ser=$("#server option[value="+sel_ser+"]").html();
			var v_day=$("#date option[value="+sel_day+"]").html();
			var v_time=$("#time option[value="+sel_time+"]").html();
			var v_minute=$("#minute option[value="+sel_minute+"]").html();
			
			if( sel_ser == "select" ) {
				alert('请选择服务器');
				return false;
			}
			if( sel_day == "select"  ) {
				alert('请选择日期');
				return false;
			}
			if( sel_time == "select" ) {
				alert('请选择时间');
				return false;
			}
			
			if(confirm('确定导入【' + v_ser + '】服【' + v_day + '】【' + v_time +'】【' + v_minute +'】'+'的数据？')){
				$("#lbform").submit();
			} else {
				return false;
			}
		});
		
		$("#server").change(function(){
			var v=$("#server").val();

			$("div.server").hide();
			$("div[name="+v+"]").show();
		});
	});
</script>

<title><{$lang->menu->dataRestore}></title>

</head>

<body>
<{*
<div id="position"><{$lang->menu->class->dataManager}>：<{$lang->menu->dataRestore}></div>
*}>
<br />

<span class="red" style="font-size: 30px;"><{$attention}></span>

<br />
<br />

<{if $strMsg}>
<table cellspacing="1" cellpadding="5" class="DataGrid">
	<{foreach from=$strMsg item=item}>
	<tr><td><span style="color:red;"><{$item}></span></td></tr>
	<{/foreach}>
</table>
<br />
<{/if}>

<br />
<{if $serverList}>

&nbsp;&nbsp;请选择要导入数据的服务器和日期时间：
<form id="lbform" method="post" action="">
<table class="DataGrid" style="width:800px">
	<tr>
		<td align="center">
			<{$lang->page->server}>:
			<select name="server" id="server">
				<option value="select" >请选择</option>
				<{foreach from=$serverList item=server key=name}>
				<option value="<{$server.id}>" ><{$server.name}></option>
				<{/foreach}>
			</select> 
		</td>
			
		<td align="left" >
			<{foreach from=$serverList item=server key=name}>
			<div class="server" name='<{$server.id}>'  style="display:none">s<{$server.id}></div>
			<{/foreach}>
		</td>
			
		<td align="center">
			<{$lang->page->date}>:
			<select name="date" id="date">
				<option value="select" >请选择</option>
				<{foreach from=$dateArr item=day key=key}>
				<option value="<{$key}>" ><{$day}></option>
				<{/foreach}>
			</select> 
		</td>
		<td align="center">
			<{$lang->time->hour}>:
			<select name="time" id="time">
				<option value="select" >请选择</option>
				<{foreach from=$timeArr item=hour key=key}>
				<option value="<{$key}>" ><{$hour}></option>
				<{/foreach}>
			</select> 
		</td>
		<td align="center">
			<{$lang->time->minute}>:
			<select name="minute" id="minute">
				<{foreach from=$minuteArr item=minute key=key}>
				<option value="<{$key}>" ><{$minute}></option>
				<{/foreach}>
			</select> 
		</td>
		<td>
			<input type="submit" name="insert" id="insert" value="开始导入"/>
		</td>
	</tr>
</table>
<br />
<div>PS: 一次只能导入一个服一个时间段的数据，如有需要，请分多次来导入</div>
</form>
<br />
<{else}>
	<div class="blue">没有可用服务器</div>
<{/if}>

<{if $list}>
<table class="DataGrid" style="width:800px">
	<tr>
		<th>id</th>
		<th>服务器</th>
		<th>ip</th>
		<th>日期</th>
		<th>小时</th>
		<th>分钟</th>
		<th>添加时间</th>
		<th>操作人</th>
		<th>状态</th>
		<th>执行结果</th>
	</tr>
	<{foreach from=$list item=item key=key}>
	<tr align="center">
		<td><{$item.id}></td>
		<td><{$item.server}></td>
		<td><{$item.ip}></td>
		<td><{$item.date}></td>
		<td><{$item.hour}></td>
		<td><{$item.minute}></td>
		<td><{$item.mdate}></td>
		<td><{$item.admin_name}></td>
		<td><{if $item.executed == 1 }>已执行<{else}>执行中<{/if}></td>
		<td><{if $item.result }><{$item.result}><{else}>-<{/if}></td>
	</tr>
	<{/foreach}>
</table>
<{/if}>

</body>
</html>