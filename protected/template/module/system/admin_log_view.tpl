<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link rel="stylesheet" href="/static/css/base.css" type="text/css">
<link rel="stylesheet" href="/static/css/style.css" type="text/css">
<script type="text/javascript" src="/static/js/My97DatePicker/WdatePicker.js"></script>
<script type="text/javascript" src="/static/js/jquery.min.js"></script>
    <title>管理日志</title>
</head>

<body>
<div id="position"><b>后台权限管理：后台管理记录</b></div>
<div class='divOperation'>
	<form name="myform" method="post" action="<{$URL_SELF}>">
		管理员: <input type='text' name='admin_name' size='8' value='<{$admin_name}>' />
		统计起始时间: <input type='text' name='dateStart' id='dateStart' size='10' value='<{$dateStart}>' />
		<img onclick="WdatePicker({el:'dateStart'})" src="/static/js/My97DatePicker/skin/datePicker.gif" width="16" height="22" align="absmiddle">
		终止时间: <input type='text' name='dateEnd' id='dateEnd' size='10' value='<{$dateEnd}>' />
		<img onclick="WdatePicker({el:'dateEnd'})" src="/static/js/My97DatePicker/skin/datePicker.gif" width="16" height="22" align="absmiddle">
		<input type="checkbox" name="gulvxt" value="9001" <{if '9001'==$gulvxt}> checked="checked" <{/if}> />过滤掉登录系统的操作
			<select name=op_id>
				<{foreach key=key item=item from=$op_name}>
						<{if $key == $op_id}>
							<option value="<{$key}>" selected="selected"><{$item}></option>
						<{else}>
							<option value="<{$key}>"><{$item}></option>
						<{/if}>
				<{/foreach}>
			</select>
		<input type="image" name='search' src="/static/images/search.gif" class="input2"  />
	</form>
</div>

<table cellspacing="1" cellpadding="3" border="0" class='table_list' >
	<tr class='table_list_head'>
		<td colspan=10 >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;统计时间范围：<{$dateStart}> 0:0:0 至 <{$dateEnd}> 23:59:59</td>
	</tr>
<{section name=loop loop=$keywordlist}>
	<{if $smarty.section.loop.rownum % 20 == 1}>
	<tr class='table_list_head'>
		<td ></td>
		<td>时间</td>
		<td>管理员</td>
		<td>IP</td>
		<td>操作</td>
		<td>玩家角色名</td>
		<td>详情</td>
		<td>数量</td>
	</tr>
	<{/if}>
	<{if $smarty.section.loop.rownum % 2 == 0}>
	<tr class='trEven'>
	<{else}>
	<tr class='trOdd'>
	<{/if}>
		<td></td>
		<td>
			<{$keywordlist[loop].mtime|date_format:"%Y-%m-%d %H:%M:%S"}>
		</td>
		<td>
			<{$keywordlist[loop].admin_name}>
		</td>
		<td>
			<{$keywordlist[loop].admin_ip}>
		</td>
		<td>
			<{$keywordlist[loop].desc}>
		</td>
		<td>
			<{$keywordlist[loop].user_name}>
		</td>
		<td>
			<{if $keywordlist[loop].mdetail_str!=''}><{$keywordlist[loop].mdetail_str}><{$keywordlist[loop].mdetail}><{else}><{$keywordlist[loop].mdetail}><{/if}>
		</td>
		<td>
			<{$keywordlist[loop].number}>
		</td>
	</tr>
<{/section}>
</table>

</body>
</html>
