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

		$('.show-ip').click(function(){
			var ip = $(this).text();
			queryIP(ip);
		})
	});
</script>

<title><{$lang->menu->userData}></title>

</head>

<body>
<div id="position"><{$lang->menu->class->userInfo}>：<{$lang->menu->userData}></div>
<form action="?action=search" id="frm" method="post" >
	<table cellspacing="1" cellpadding="5" class="SumDataGrid" width="800">
		<tr>
			<input type="hidden" id="action" name="action" value="search"/>
			<td align="right"><{$lang->page->roleName}>：</td>
			<td><input type="text" name="role_name" id="role_name" value="<{$role.roleName}>" /></td>
			<td align="right"><{$lang->page->accountName}>：</td>
			<td><input type="text" name="account_name" id="account_name" value="<{$role.accountName}>" /></td>
			<td><input type="image" name='search' src="/static/images/search.gif" class="input2"  /></td>
		</tr>
	</table>
	<br />

</form>
<{if $strMsg}>
<table cellspacing="1" cellpadding="5" class="DataGrid">
	<tr>
		<td><span style="color:red;"><{$strMsg}></span></td>
	</tr>
</table>
<br />
<{/if}>

<{if $role}>
<table class="DataGrid" style="width:800px">
	<tr>
		<th><{$lang->page->accountName}></th>
		<th><{$lang->page->roleName}></th>
		<th><{$lang->page->level}></th>
	</tr>
	<tr align="center">
		<td><{$role.accountName}></td>
		<td><{$role.roleName}></td>
		<td><{$role.level}></td>
	</tr>
</table>
<br />
<{/if}>

<{if $userData}>
<table cellspacing="1" cellpadding="5" class="DataGrid">
	<tr>
		<td><{$userData}></td>
	</tr>
</table>
<br />
<{/if}>

</body>
</html>