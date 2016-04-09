<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset='UTF-8'" />
<link rel="stylesheet" href="/static/css/base.css" type="text/css">
<link rel="stylesheet" href="/static/css/style.css" type="text/css" />
<script type="text/javascript" src="/static/js/jquery.min.js"></script>
<script type="text/javascript" src="/static/js/sorttable.js"></script>
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

<title><{$lang->menu->playerTaskStatus}></title>

</head>

<body>
<div id="position"><{$lang->menu->class->userInfo}>：<{$lang->menu->playerTaskStatus}></div>

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
		<{* 暂时不需要角色ID
			<td align="right"><{$lang->page->roleId}>：</td>
			<td><input type="text" name="role[role_id]" id="role_id" value="<{$role.role_id}>" /></td>
		*}>
			<td align="right"><{$lang->page->roleName}>：</td>
			<td><input type="text" name="role[role_name]" id="role_name" value="<{$role.role_name}>" /></td>
			<td align="right"><{$lang->page->accountName}>：</td>
			<td><input type="text" name="role[account_name]" id="account_name" value="<{$role.account_name}>" /></td>
			<td><input type="image" name='search' src="/static/images/search.gif" class="input2"  /></td>
		</tr>
	</table>
</form>
<br />
<!-- End 账号和角色名搜索  -->

<!-- Start 设置指定任务为完成  -->
<{if ( 
		$task_list && 
		($role.role_name || $role.account_name )
	)}>
<form action="?action=setfinish" id="frm" method="POST" >
	
	<table cellspacing="1" cellpadding="5" class="SumDataGrid" width="800">
		<tr>
			<td align="left">
				<{$lang->player->finishTaskID}>: 
				<input type="text" name="task_id" class="input2" value="" /> 
				<input type="hidden" name="role[account_name]" value="<{$role.account_name}>"  />
				<input type="hidden" name="role[role_name]" value="<{$role.role_name}>"  />
				<input type="submit" name="finishtask"  class="input2"  value="<{$lang->page->set}>" />
				<span class="font_number_red"><{$lang->player->finishTaskNotice}></span>
			</td>
		</tr>
	</table>
</form>
<br />
<{/if}>
<!-- End 设置指定任务为完成  -->

<{ if $task_list }>
<!--  Start  任务信息-->
<table class="DataGrid sortable table_list" cellspacing="0" style="margin-bottom:20px;">
	<thead>
	<tr>
		<th width="15%"><{$lang->player->taskID}></th>
		<th width="20%"><{$lang->player->taskName}></th>
		<th width="10%"><{$lang->player->taskType}></th>
        <th width="15%"><{$lang->player->taskStatus}></th>
		<th width="10%"><{$lang->player->taskCount}></th>
		<th width="20%"><{$lang->player->taskTime}></th>
        <th width="10%"><{$lang->player->taskPlayerLevel}></th>

	</tr>
	</thead>
	<tbody>
		<{foreach from=$task_list item=task name=task_loop}>
	    <tr align="center" <{ if $smarty.foreach.task_loop.index is odd }> class="odd"<{ /if }>>
	
			<td><{ $task.mission_id}>&nbsp;</td>
			<td><{ $task.mission_name      }>&nbsp;</td>
	        <td><{ $taskType[$task.group_id]    }>&nbsp;</td>
			<td><{ $taskStatus[$task.status]	}>&nbsp;</td>
			<td><{ $task.mcount }>&nbsp;</td>
	        <td><{ $task.mtime|date_format:'%Y-%m-%d %H:%M:%S'       }>&nbsp;</td>
	        <td><{ $task.role_level}>&nbsp;</td>
		</tr>
		<{/foreach}>
	</tbody>
  

</table>
<!--  End  任务信息-->
<{ else }>
	<div><{$lang->page->noData}></div>
<{ /if }>
</body>
</html>