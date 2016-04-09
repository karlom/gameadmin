<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>
	<{$lang->menu->loginPlayer}>
</title>
<link rel="stylesheet" href="/static/css/base.css" type="text/css">
<link rel="stylesheet" href="/static/css/style.css" type="text/css">
</head>
<body>
<div id="position">
<b><{$lang->menu->class->userInfo}>：<{$lang->menu->loginPlayer}></b>
</div>
<div class="msg">
<{foreach from=$msg item=item}>
<div class="red"><{$item}></div>
<{/foreach}>
</div>

<form method="post" action="<{$smarty.const.URL_SELF}>">
	<{$lang->page->roleName}>:<input type="text" name="role_name" id="role_name" value="" /> 
	<{$lang->page->or}> 
	<{$lang->page->accountName}>:<input type="text" name="account_name" id="account_name" value="" />
	<input name="action" type="hidden" value="loginplayer" />
	<select name="pf">
	<{html_options options=$dictPf}>
	</select>
	<input type="submit" class="button" name="banButton" value="<{$lang->page->loginPlayerBtn1}>" style="height:30px">
</form>
<br />
<br />
<br />
<br />
<{$lang->page->loginPlayer1}>
<br />
<br />
<br />
<hr></hr>
<br />
<div>
<div><b><{$lang->page->imitationLogin}></b></div>
<form method="post" action="<{$smarty.const.URL_SELF}>">
	<{$lang->page->accountName}>:<input type="text" name="account_name" id="account_name" value="" />
	<input name="action" type="hidden" value="imitation" />
	<input type="submit" class="button" name="banButton" value="<{$lang->page->loginPlayerBtn2}>" style="height:30px">
</form>
<br />
<br />
<{$lang->page->loginPlayer2}>
</div>
</body>
</html>
