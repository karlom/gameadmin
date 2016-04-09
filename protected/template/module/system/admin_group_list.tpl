<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset="UTF-8" />
<title>组管理</title>
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
<div id="position"><b>后台权限管理：组管理</b></div>

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
	<input type='button' class='button' value='新增组' onclick="javascript:location.href='<{$URL_SELF}>?action=add';" />
</div>

<form id="lbform" name="lbform" method="post" action="<{$smarty.const.URL_SELF}>">
<table cellspacing="1" cellpadding="3" border="0" class='table_list' style='width:auto;' >
<{section name=loop loop=$groups}>
	<{if $smarty.section.loop.rownum % 20 == 1}>
	<tr class='table_list_head'>
		<td width="20"><input type="checkbox" id="selectAll" value="" /></td>
		<td width='70px' align="center">操作</td>
		<td width='50px' >组名</td>
		<td width='80px'>说明</td>
		<td>权限</td>
	</tr>
	<{/if}>
	<{if $smarty.section.loop.rownum % 2 == 0}>
	<tr class='trEven'>
	<{else}>
	<tr class='trOdd'>
	<{/if}>
		<td><input type="checkbox" name="selectItem[]" value="<{$groups[loop].id}>" /> </td>
		<td align="center">
			<a style="color:blue;" href='<{$URL_SELF}>?action=modify&id=<{$groups[loop].id}>' > 修改 </a>
			| <a style="color:red;" href='<{$URL_SELF}>?action=del_submit&id=<{$groups[loop].id}>}>' onclick="javasrcipt:return confirm('确认要删除吗？删除不可修复');"> 删除 </a>
		</td>
		<td>
			<{$groups[loop].name}>
		</td>
		<td>
			<{$groups[loop].comment}>
		</td>
		<td>
			<{$groups[loop].page_access_string}>
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