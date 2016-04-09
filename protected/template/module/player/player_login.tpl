<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset='UTF-8'" />
<link rel="stylesheet" href="/static/css/base.css" type="text/css">
<link rel="stylesheet" href="/static/css/style.css" type="text/css" />
<script type="text/javascript" src="/static/js/jquery.min.js"></script>
<script type="text/javascript" src="/static/js/sorttable.js"></script>
<script type="text/javascript" src="/static/js/My97DatePicker/WdatePicker.js"></script>
<script language="javascript">
	$(document).ready(function(){
		$("#role_name").keydown(function(){
			$("#role_id").val('');
			$("#account_name").val('');
		});
		$("#account_name").keydown(function(){
			$("#role_id").val('');
			$("#role_name").val('');
		});
	});
</script>

<title><{$lang->menu->playerLogin}></title>

</head>

<body>
<div id="position"><{$lang->menu->class->userInfo}>：<{$lang->menu->playerLogin}></div>

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

<!-- Start 账号和角色名搜索  -->
<form action="?action=search" id="frm" method="GET" >
	<table cellspacing="1" cellpadding="5" class="SumDataGrid" width="800">
		<tr>
			<td>
				<{$lang->page->beginTime}>:<input id='starttime' name='starttime' type="text" class="Wdate" onfocus="WdatePicker({el:'starttime',dateFmt:'yyyy-MM-dd',minDate:'<{$minDate}>',maxDate:'#F{$dp.$D(\'endtime\')}'})" size='12' value='<{$startDate}>' /> 
			</td>
			<td>
				<{$lang->page->endTime}>:<input id='endtime' name='endtime' type="text" class="Wdate" onfocus="WdatePicker({el:'endtime',dateFmt:'yyyy-MM-dd',minDate:'#F{$dp.$D(\'starttime\')}',maxDate:'<{$maxDate}>'})" size='12' value='<{$endDate}>' /> 
			</td>
		<{* 暂时不需要角色ID
			<td align="right"><{$lang->page->roleId}>：</td>
			<td><input type="text" name="role[role_id]" id="role_id" value="<{$role.role_id}>" /></td>
		*}>
			<td align="right"><{$lang->page->accountName}>：</td>
			<td><input type="text" name="role[account_name]" id="account_name" value="<{$role.account_name}>" /></td>
			<td align="right"><{$lang->page->roleName}>：</td>
			<td><input type="text" name="role[role_name]" id="role_name" value="<{$role.role_name}>" /></td>
			<td><input type="image" name='search' src="/static/images/search.gif" class="input2"  /></td>
		</tr>
	</table>
</form>
<br />
<!-- End 账号和角色名搜索  -->

<{ if $login_log_list }>

	<!-- 分页 -->
	<{include file='file:pager.tpl' pages=$pages assign=page_html}>
	<{$page_html}>
	<!--  Start  登录信息-->
	<table class="DataGrid sortable table_list" cellspacing="0" style="margin-bottom:20px;">
		
		<tr>
			<th width="20%"><{$lang->page->accountName}></th>
			<th width="20%"><{$lang->page->roleName}></th>
			<th width="10%"><{$lang->page->level}></th>
			<th width="25%"><{$lang->page->loginIp}></th>
	        <th width="25%"><{$lang->page->loginTime}></th>
		</tr>
	
			<{foreach from=$login_log_list item=login_log name=login_log_loop}>
		    <tr align="center" <{ if $smarty.foreach.task_loop.index is odd }> class="odd"<{ /if }>>
		
				<td><{ $login_log.account_name}>&nbsp;</td>
				<td><{ $login_log.role_name}>&nbsp;</td>
		        <td><{ $login_log.level}>&nbsp;</td>
				<td><{ $login_log.ip}>&nbsp;</td>
		        <td><{ $login_log.mtime|date_format:'%Y-%m-%d %H:%M:%S'}>&nbsp;</td>
			</tr>
			<{/foreach}>
	</table>
	<!--  End  登录信息-->
	<{$page_html}>
<{ else }>
	<div><{$lang->page->noData}></div>
<{ /if }>
</body>
</html>