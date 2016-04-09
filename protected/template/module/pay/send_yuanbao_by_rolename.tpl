<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>
	<{$lang->menu->sendYuanBaoByRoleName}>
</title>
<link rel="stylesheet" href="/static/css/base.css" type="text/css">
<link rel="stylesheet" href="/static/css/style.css" type="text/css">
</head>

<body>
<!-- 
<div id="position">
<b><{$lang->menu->class->payAndSpand}>：<{$lang->menu->sendYuanBaoByRoleName}></b>
</div> 
-->
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

<div class='divOperation' style="margin: 5px 0;">
<form id="myform" name="myform" method="get" action="" style="display: inline;">
<table>
	<tr>
		<td align="right"><{$lang->player->roleName}>:</td>
		<td><input type="text" id="role_name" name="role_name" size="16" value="" /></td>
	</tr>
	<tr>
		<td align="right"><{$lang->gold->gold}>:</td>
		<td><input type="text" id="yuanbao" name="yuanbao" size="16" value="" /></td>
	</tr>
	<tr>
		<td align="right"><{$lang->page->type}>:</td>
		<td>
			<input type="radio" name="type" value="1" /><{$lang->gold->addTotalPay}><br />
			<input type="radio" name="type" value="2" checked /><{$lang->gold->notAddTotalPay}>
		</td>
	</tr>
	<tr>
		<td colspan="2" align="center"><input type="hidden" id="action" name="action" value="send" /><input type="submit" class="input2" align="absmiddle" value="<{$lang->page->submit}>" /></td>
	</tr>
</table>
</form>
</div>
</body>
</html>
