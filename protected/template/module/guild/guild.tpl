<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link rel="stylesheet" href="/static/css/base.css" type="text/css">
<link rel="stylesheet" href="/static/css/style.css" type="text/css">
<script type="text/javascript" src="/static/js/jquery.min.js"></script>
<title><{$lang->menu->guildMemberList}></title>
</head>

<body>
<div id="position"><{$lang->menu->guildMemberList}>：<{$lang->menu->class->guildMessage}></div>
<{if 'list' == $action || 'search' == $action}>
<div id='input_panel' class='divOperation'>
	<form name="myform" method="get" action="<{$smarty.const.URL_SELF}>">
		<span style='margin-right:20px;'><{$lang->guild->guildName}>: <input type='text' id='guildName' name='guildName' size='12' value='<{ $guildName }>' /></span>
		<input type="hidden" name="action" value="search" />
		<input type="submit" name="search" value="<{$lang->page->serach}>" />
	</form>
</div>
<{if $guilds}>
<table class="DataGrid" cellspacing="0">
	<tr align="center">
		<th><{$lang->guild->guildId}></th>
		<th><{$lang->guild->guildName}></th>
        <th><{$lang->guild->leader}></th>
        <th><{$lang->guild->guildMoney}></th>
        <th><{$lang->guild->guildBuild}></th>
        <th><{$lang->page->level}></th>
        <th><{$lang->guild->guildMemberCount}></th>
        <th><{$lang->guild->guildNote}></th>  
        <th><{$lang->guild->memberList}></th>    
    </tr>
    <{foreach from=$guilds item=item}>
    <tr align="center" class="<{cycle values="trEven,trOdd"}>">
    	<td><{ $item.id }></td>
    	<td><{ $item.name }></td>
    	<td><{ $item.leaderName }></td>
    	<td><{ $item.money }></td>
    	<td><{ $item.build }></td>
    	<td><{ $item.level }></td>
    	<td><{ $item.memberCout }>/<{ $item.memberMaxCount }></td>
    	<td><{ $item.note }></td>
    	<td><a href="guild.php?action=detail&guid=<{$item.id}>&guildNmae=<{$item.name}>" style="color:red;"><{$lang->page->detailDeal}></a></td>
    </tr>
    <{/foreach}>
</table>
<{else}>
<{$lang->page->noRecord}>
<{/if}>
<{elseif 'detail' == $action}>
<{if $members}>
<div style="width: 98%; margin: 5px;">
<div style="float: left;"><{$lang->guild->guildName}> : <b><{$guildName}></b></div>
<div style="text-align: right; float: right;"><input type="button" value="<{$lang->page->back}>" onclick="history.back();" /></div>
</div>
<table class="DataGrid" cellspacing="0">
	<tr align="center">
		<th><{$lang->page->roleName}></th>
		<th><{$lang->guild->position}></th>
        <th><{$lang->page->level}></th>
        <th><{$lang->page->sex}></th>
        <th><{$lang->page->job}></th>
        <th><{$lang->page->isOnline}></th>
        <th><{$lang->guild->memberBuild}></th>
        <th><{$lang->guild->memberMoney}></th>
        <th><{$lang->page->lastLoginTime}></th>
    </tr>
    <{foreach from=$members item=item}>
    <tr align="center" class="<{cycle values="trEven,trOdd"}>">
    	<td><{ $item.name }></td>
    	<td><{ $item.pos }></td>
    	<td><{ $item.lv }></td>
    	<td><{ $item.sex }></td>
    	<td><{ $item.job }></td>
    	<td><{ $item.isOnline }></td>
    	<td><{ $item.build }></td>
    	<td><{ $item.money }></td>
    	<td><{ $item.loginTime }></td>
    </tr>
    <{/foreach}>
</table>
<{else}>
<{$lang->page->noRecord}>
<{/if}>
<{/if}>
</body>
</html>