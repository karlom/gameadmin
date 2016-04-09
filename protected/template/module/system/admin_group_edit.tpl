<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>添加/修改用户组</title>
<link rel="stylesheet" href="/static/css/base.css" type="text/css">
<link rel="stylesheet" href="/static/css/style.css" type="text/css">

<script type="text/javascript" src="../js/prototype.js"></script>
<script>

selectAllCheckBox = function() {
	var items = document.getElementsByTagName('input');

	if (items.length <= 0)
		return;

	for (var i = 0; i < items.length; i++){
		if (items[i].getAttribute("type") != 'checkbox' )
			continue;

		items[i].checked = true;
	}
};

selectNoneCheckBox = function() {
	var items = document.getElementsByTagName('input');

	if (items.length <= 0)
		return;

	for (var i = 0; i < items.length; i++){
		if (items[i].getAttribute("type") != 'checkbox' )
			continue;

		items[i].checked = false;
	}
};

selectRRCheckBox = function() {
	var items = document.getElementsByTagName('input');

	if (items.length <= 0)
		return;

	for (var i = 0; i < items.length; i++){
		if (items[i].getAttribute("type") != 'checkbox' )
			continue;

		items[i].checked = (! items[i].checked);
	}
};

selectOutterCheckBox = function() {
	var items = document.getElementsByTagName('input');

	if (items.length <= 0)
		return;

	for (var i = 0; i < items.length; i++){
		if (items[i].getAttribute("type") != 'checkbox' )
			continue;

		if (items[i].getAttribute("title") != '1' )
			items[i].checked = false;
		else
			items[i].checked = true;
	}
};

</script>

</head>

<body>
<div id="position"><b>后台管理：后台用户组设置</b></div>
<h4><{if $action=='add'}>添加<{/if}><{if $action=='modify'}>修改<{/if}>用户组</h4>

<div class='divOperation'>

</div>

<form name="myform" method="post" action="<{$URL_SELF}>">
	<input type='hidden' name='action' value='<{$action}>_submit' />
<{if $action=='modify'}><input type='hidden' name='id' value='<{$group.id}>' /><{/if}>

<table cellspacing="1" cellpadding="3" border="0" class='table_list' >
	<tr class='table_list_head'>
		<td width='80px'>权限组名称</td>
			<td>
<{if $action=='add'}>
	<input type='textbox' name='name' value='' />
<{/if}><{if $action=='modify'}>
	<{$group.name}>
<{/if}>
		</td>
	</tr>
	<tr class='table_list_head'>
		<td width='80px'>备注说明</td>
		<td>
	<input type='textbox' name='comment' size='60' value='<{$group.comment}>' />
	&nbsp;&nbsp;对这个权限组进行详细说明（200字以内）
		</td>
	</tr>
	<tr class='table_list_head'>
		<td colspan=2>设置哪些功能的操作权限&nbsp;&nbsp;&nbsp;&nbsp;
		<input type='button' class='button' value='全部选中' onclick="javascript:selectAllCheckBox();" />
		&nbsp;&nbsp;
		<input type='button' class='button' value='全部取消' onclick="javascript:selectNoneCheckBox();" />
		&nbsp;&nbsp;
		<input type='button' class='button' value='反选' onclick="javascript:selectRRCheckBox();" />
		&nbsp;&nbsp;
		<input type='button' class='button' value='常用对外权限' onclick="javascript:selectOutterCheckBox();" />
		</td>
	</tr>
<{foreach key=page_class item=page_data from=$page_list}>
	<{if $page_data.index % 2 == 0}>
	<tr  class='trEven'>
	<{else}>
	<tr  class='trOdd'>
	<{/if}>
		<td ><b><{$page_class}></b>
		</td>
		<td >
			<table>
<{foreach key=key item=item from=$page_data.func}>
	<{if $key % 6 == 0}><tr><{/if}>
	<td width='130px'>
<{if $action=='add'}>
		<input type='checkbox' name='cb_<{$item.id}>' <{if $item.desc=='可对外'}>title='1'<{/if}> />
<{elseif $action=='modify'}>
		<input type='checkbox' name='cb_<{$item.id}>' <{if $item.desc=='可对外'}>title='1'<{/if}>  <{if $item.access}>checked<{/if}> />
<{/if}>
		<{$item.name}><{if $item.desc!=''}><br/><font color=blue>(<{$item.desc}>)</font><{/if}></td>
	<{if $key % 6 == 5}></tr><{/if}>
<{/foreach}>
			</table>
		</td>
	</tr>
<{/foreach}>
	<tr class='table_list_head'>
		<td colspan=2 align=center>
	<input type='submit' name='submit' value='保存' />
		</td>
	</tr>
</table>
</form>
</body>
</html>