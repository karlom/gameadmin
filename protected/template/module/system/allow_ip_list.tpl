<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset='UTF-8'" />
<link rel="stylesheet" href="/static/css/base.css" type="text/css">
<link rel="stylesheet" href="/static/css/style.css" type="text/css" />


<title>允许登录IP列表</title>

</head>

<body>
<div id="position">后台权限管理：后台登录允许IP</div>

<div style="padding: 5px;">
说明：<br>
1、如果是要允许一个IP段的话要填前面的三个地址，像：192.168.22.<br>
2、如果要允许某个特定的IP就要填写IP的全部数字
</div>
<form action="<{$URL_SELF}>?action=add" method="post">
	<div>
	IP：<input type="text" name="ip" id="ip">
	<input type="hidden" value="add"/>
	<input type="submit" name='submit' />
	<br />
	</div>
</form>

<{if $IPLIST}>
	<table cellspacing="1" cellpadding="3" border="0" class='table_list' style='width:auto;' >
	  <tr class='table_list_head'>
	    <th>ip</th>
	    <th>操作</th>
	  </tr>
	<{section name=loop loop=$IPLIST}>
	  <{if $smarty.section.loop.rownum % 2 == 0}>
		<tr class='trEven'>
		<{else}>
		<tr class='trOdd'>
		<{/if}>
	    <td><{$IPLIST[loop].ip}></td>
	    <td><a href="<{$URL_SELF}>?action=delete&id=<{$IPLIST[loop].id}>" style="color:red;">删除</a></td>
	  </tr>
	  <{/section}>
	</table>

<{/if}>

</body>
</html>