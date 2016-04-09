<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>
	<{$lang->menu->syncConfig}>
</title>
<link rel="stylesheet" href="/static/css/base.css" type="text/css" />
<link rel="stylesheet" href="/static/css/style.css" type="text/css" />
<script type="text/javascript" src="/static/js/jquery.min.js"></script>	
</head>

<body>

<div id="position">
<b><{$lang->menu->class->variablesConfig}>：<{$lang->menu->syncConfig }></b>
</div> 

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
<div>
<form method="post" action="">
	<{foreach from=$serverList item=server}>
		<label>
			<input type="radio" name="server" value="s<{$server.id}>" />S<{$server.id}>
		</label>&nbsp;
	<{/foreach}>
	<input type="submit" name="sync" value="从选中服同步"/>
</form>
</div>
</body>
</html>
