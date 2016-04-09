<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>
	<{$lang->menu->roleName}>
</title>
<link rel="stylesheet" href="/static/css/base.css" type="text/css">
<link rel="stylesheet" href="/static/css/style.css" type="text/css">
<script type="text/javascript" src="/static/js/jquery.min.js"></script>	
<script type="text/javascript" src="/static/js/My97DatePicker/WdatePicker.js"></script>
<script type="text/javascript" src="/static/js/ip.js"></script>
<script type="text/javascript" src="/static/js/colResizable-1.3.min.js"></script>
<script type="text/javascript" src="/static/js/global.js"></script>
</head>

<body>
<div id="position">
<b><{$lang->menu->class->userInfo}>：<{$lang->menu->roleName}></b>
</div>
<form id="myform" name="myform" method="post" action="">
<div class='divOperation'>
输入角色名:<input type="text" id="role_name" name="role_name" size="20" value="<{$roleName}>" />
<input type="image" src="/static/images/search.gif" class="input2" align="absmiddle"  />
</div>
<br/>
<{if $result}>
<table cellspacing="1" cellpadding="3" border="0" class='table_list' style=" width: 600px;" >
	<tr class='table_list_head' align="center">
        <td>角色名</td>
        <td>玩家状态查询</td>
	</tr>
	
<{foreach  from=$result item=item key=key}>
	<tr class='<{cycle values="trEven,trOdd"}>' align="center">
		<td class="cmenu" title="<{$item.role_name}>"><{$item.role_name}></td>
        <td><a id="playerStatus" name="role[role_name]"  href="player_status.php?action=playerStatus&role_name=<{$item.role_name}>">查看详情</a></td>
	</tr>
<{/foreach}>
</table>
<{else}>
<font color='red'><{$lang->page->noData}></font>
<{/if}>
</div>
</form>
</body>
</html>
