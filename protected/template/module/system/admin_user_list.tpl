<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>管理后台用户</title>
<script type="text/javascript" src="/static/js/jquery.min.js"></script>
<link rel="stylesheet" href="/static/css/base.css" type="text/css">
<link rel="stylesheet" href="/static/css/style.css" type="text/css">
<script type="text/javascript">

$(document).ready(function(){
	$("#select_sync").click(function(){
		if($("#select_sync").attr("checked") == true ) {
			$("#table_adminlist").show();
		} else {
			$("#table_adminlist").hide();
		}
	});
	$("#selectAll").click(function(){
		if($("#selectAll").attr("checked") == true ) {
			$("input:checkbox[name='selectItem[]']").attr("checked",true);
		} else {
			$("input:checkbox[name='selectItem[]']").attr("checked",false);
		}
	});
	$("#select_all_admin").click(function(){
		if($("#select_all_admin").attr("checked") == true ) {
			$("input:checkbox[name='adminList[]']").attr("checked",true);
		} else {
			$("input:checkbox[name='adminList[]']").attr("checked",false);
		}
	});
	$("#bt_sync").click(function(){
		$("#lbform").submit();
	});
});

</script>
</head>

<body style="margin:10px">
<div id="position"><b>后台权限管理：用户管理</b></div>

<{if $msg}>
<table cellspacing="1" cellpadding="5" class="DataGrid">
	<{foreach from=$msg item=msgStr }>
	<tr>
		<td><span style="color:red;"><{$msgStr}></span></td>
	</tr>
	<{/foreach}>
</table>
<br />
<{/if}>

<div class='divOperation'>
	<input type='button' class='button' value='添加' onclick="javascript:location.href='<{$URL_SELF}>?action=add';" />
</div>

<form id="lbform" name="lbform" method="post" action="<{$smarty.const.URL_SELF}>">
<table cellspacing="1" cellpadding="3" border="0" class='table_list' style='width:800;' >
<{section name=loop loop=$enum}>
	<{if $smarty.section.loop.rownum % 20 == 1}>
	<tr class='table_list_head'>
		<td width="20"><input type="checkbox" id="selectAll" value="" /></td>
		<td align="center">操作</td>
		<td align="center">ID</td>
		<td align="center">用户名</td>
		<td align="center">备注</td>
		<td align="center">组</td>
		<td align="center">最后登录时间</td>
		<td align="center">状态</td>
	</tr>
	<{/if}>
	<{if $smarty.section.loop.rownum % 2 == 0}>
	<tr class='trEven'>
	<{else}>
	<tr class='trOdd'>
	<{/if}>
		<td><input type="checkbox" name="selectItem[]" value="<{$enum[loop].uid}>" /> </td>
		<td align="center">
			<{if 0==$enum[loop].user_status}>
			<a style="color:red;" href='<{$URL_SELF}>?action=enabled&id=<{$enum[loop].uid}>&username=<{$enum[loop].username}>' onclick="javasrcipt:return confirm('确认要重新启用 <{$enum[loop].username}> 吗？');"> 重新启用 </a>
			<{elseif 1==$enum[loop].user_status}>
			<a style="color:red;" href='<{$URL_SELF}>?action=disabled&id=<{$enum[loop].uid}>&username=<{$enum[loop].username}>' onclick="javasrcipt:return confirm('确认要禁用 <{$enum[loop].username}> 吗？');"> 禁用 </a>
			<{elseif 2==$enum[loop].user_status}>
			<a style="color:red;" href='<{$URL_SELF}>?action=enabled&id=<{$enum[loop].uid}>&username=<{$enum[loop].username}>' onclick="javasrcipt:return confirm('确认要重新启用 <{$enum[loop].username}> 吗？');"> 重新启用 </a>
			<{/if}>
			<a style="color:blue;" href='<{$URL_SELF}>?action=modify&id=<{$enum[loop].uid}>&username=<{$enum[loop].username}>' > 修改 </a>
		</td>
		<td align="center">
			<{$enum[loop].uid}>
		</td>
		<td align="center">
			<{$enum[loop].username}>
		</td>
		<td align="center">
			<{$enum[loop].comment}>
		</td>
		<td>
			<{$enum[loop].groupname}>
		</td>
		<td>
			<{$enum[loop].last_login_time}>
		</td>
		<td>
			<{$enum[loop].user_status_str}>
		</td>
	</tr>
<{/section}>
</table>

<{if $adminList }>
	<input type='checkbox' class='checkbox' id="select_sync" name="select_sync" value="yes"/>同步到其他后台
	<div id="table_adminlist" style="display:none;">
	
	<div><input type='checkbox' id="select_all_admin" />全选</div>
	
	<div>
		<{foreach from=$adminList item=admin }>
		<input type="checkbox" name="adminList[]" value="<{$admin.id}>" />&nbsp;<{$admin.name}><br />
		<{/foreach}>
		<input type='button' id="bt_sync" value='同步到其他后台'  />
	</div>
	
	</div>
<{/if}>

</form>
<br />

</body>
</html>