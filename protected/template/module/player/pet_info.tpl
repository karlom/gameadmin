<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link rel="stylesheet" href="/static/css/base.css" type="text/css">
<link rel="stylesheet" href="/static/css/style.css" type="text/css">
<script type="text/javascript" src="/static/js/jquery.min.js"></script>
<script type="text/javascript" src="/static/js/global.js"></script>
<title><{$lang->menu->petInfo}></title>
</head>

<body>
<div id="position"><{$lang->menu->class->userInfo}>：<{$lang->menu->petInfo}></div>
<div id='input_panel' class='divOperation'>
	<form name="myform" method="get" action="<{$smarty.const.URL_SELF}>">
		<input type="hidden" name='ac' value='search' />
		<span style='margin-right:20px;'><{$lang->page->accountName}>: <input type='text' id='accountName' name='accountName' size='12' value='<{ $accountName }>' onkeydown="document.getElementById('roleName').value ='';" /></span>
		<span style='margin-right:20px;'><{$lang->page->roleName}>: <input type='text' id='roleName' name='roleName' size='12' value='<{ $roleName }>' onkeydown="document.getElementById('accountName').value ='';" /></span>
		<input type="hidden" name="isPost" value="1" />
		<input type="submit" name="search" value="<{$lang->page->serach}>" />
	</form>
</div>
<br>

<{if $accountName}>
<table class="DataGrid" cellspacing="0">
	<tr align="center">
		<th><{$lang->page->itemsNum}></th>
		<th><{$lang->page->roleName}></th>
        <th><{$lang->pet->petID}></th>
        <th><{$lang->pet->petName}></th>
        <th><{$lang->pet->petDetail}></th>        
    </tr>
    <{ if $pets }>
    <{section name=i loop=$pets}>
    <tr align="center" <{ if 0==$smarty.section.i.index %2 }> class="odd"<{ /if }>>
    	<td><{ $smarty.section.i.index+1}>&nbsp;</td>
    	<td class="cmenu" title="<{$roleName}>"><{ $roleName}>&nbsp;</td>
    	<td><{ $pets[i].petid}>&nbsp;</td>
    	<td><{ $pets[i].name}>&nbsp;</td>
    	<td><a href="pet_detail.php?action=petDetail&accountName=<{$accountName}>&petUid=<{$pets[i].uid}>" style="color:red;"><{$lang->page->detailDeal}></a></td>
    </tr>
    <{/section}>
    <{ else }>
    <tr><td colspan="11"><{$lang->page->null}></td></tr>
    <{ /if }>
</table>
<br />


<{ /if }>
<{if $UserNotExist}>
<span style="color:red;"><{$lang->player->noUserExist}></span>
<{/if}>
</body>
</html>