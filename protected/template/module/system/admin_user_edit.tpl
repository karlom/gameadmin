<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>添加/修改管理后台用户</title>
<link rel="stylesheet" href="/static/css/base.css" type="text/css">
<link rel="stylesheet" href="/static/css/style.css" type="text/css">

<script type="text/javascript" src="../js/prototype.js"></script>
</head>

<body style="margin:10px">
<div id="position"><b>后台权限管理：<{if $action=='add'}>添加<{/if}><{if $action=='modify'}>修改<{/if}>用户</b></div>

<form name="myform" method="post" action="<{$URL_SELF}>">
	<input type='hidden' name='action' value='<{$action}>_submit' />
<{if $action=='modify'}><input type='hidden' name='id' value='<{$uid}>' /><{/if}>

<table cellspacing="1" cellpadding="3" border="0" class='table_list' >
	<tr class='table_list_head'>
		<td width='80px'>用户名</td>
			<td>
<{if $action=='add'}>
	<input type='textbox' name='username' value='' />
<{elseif $action=='modify'}>
	<{$udata.username}>
<{/if}>
		</td>
	</tr>
	<tr class='table_list_head'>
		<td width='100px'>密码</td>
		<td>
	<input type='textbox' name='passwd' value='' />
	<{if $action=='modify'}>&nbsp;&nbsp;如果不修改密码，则保持这里为空<{else}>&nbsp;&nbsp;密码要求至少6位<{/if}>
		</td>
	</tr>
	<tr class='table_list_head'>
		<td width='100px'>备注说明</td>
		<td>
			<input type='textbox' name='comment' size='60' value='<{$udata.comment}>' />&nbsp;&nbsp;对这个帐号进行详细说明（100字以内）
		</td>
	</tr>
	<tr class='table_list_head'>
		<td>权限组：</td>
		<td>
			<select name='groupid'>
				<{foreach key=groupid item=group from=$groups}>
					<{if $groupid eq $udata.groupid}>
						<option value='<{$groupid}>' selected='selected'><{$group.name}></option>
					<{else}>
						<option value='<{$groupid}>'><{$group.name}></option>
					<{/if}>
				<{/foreach}>
			</select>
		</td>
	</tr>
	<tr class='table_list_head'>
		<td colspan=2 align=center>
	<input type='submit' name='submit' value='保存' />
		</td>
	</tr>
</table>
</form>

</body>
</html>