<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>
	<{$lang->menu->goldTypeConfig}>
</title>
<link rel="stylesheet" href="/static/css/base.css" type="text/css" />
<link rel="stylesheet" href="/static/css/style.css" type="text/css" />
<script type="text/javascript" src="/static/js/jquery.min.js"></script>	
<script type="text/javascript">
$('document').ready(function(){
	$('input.add').click(function(){
		if($(this).attr('id') == 'addDecrease'){
			var name1 = 'decreasenames[]', name2 = 'decreaseids[]';
		}else{
			var name1 = 'increasenames[]', name2 = 'increaseids[]';
		}
		var html = '<tr class="">' +
						'<td><input type="text" name="' + name1 + '" size="40"  value="" /></td>' +
						'<td align="center"><input type="text" name="' + name2 + '" value="" /></td>' +
						'<td align="center"><a href="javascript:void(0);" class="del"><{$lang->variables->del}></a></td>' +
				   '</tr>';
		$(this).parent().parent().before(html);
	});

	$('a.del').live('click', function(){
		if(!confirm('确认删除？'))return false;
		$(this).parent().parent().remove();
	})
});
</script>
</head>

<body>

<div id="position">
<b><{$lang->menu->class->variablesConfig}>：<{$lang->menu->goldTypeConfig }></b>
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
<{if $goldType.1}>
	<div id="" style="width: 40%; height: 80%; float:left;">
		<table cellspacing="1" cellpadding="3" border="0" class="table_list sortable"  >
			<caption class='table_list_head'>
				<{$lang->variables->goldDecrease}>
			</caption>
			<tr class='table_list_head'>
		        <th width="20%"><{$lang->variables->goldTypeName}></th>
		        <th width="25%"><{$lang->variables->goldTypeId}></th>
		        <th width="25%"><{$lang->variables->del}></th>
			</tr>
			<{foreach name=loop1 from=$goldType.1 item=item key=id}>
			<tr class='<{cycle values="trEven,trOdd"}>'>
				<td><input type="text" name="decreasenames[]" size="40" value="<{$item}>" /></td>
				<td align="center"><input type="text" name="decreaseids[]" value="<{$id}>" /></td>
				<td align="center"><a href="javascript:void(0);" class="del"><{$lang->variables->del}></a></td>
			</tr>
			<{foreachelse}>
			<font color='red'><{$lang->page->noData}></font>
			<{/foreach}>
			<tr>
				<td colspan="3" align="right"><input id="addDecrease" class="add" value="添加" type="button" /></td>
			</tr>
		</table>
	</div>
<{else}>
<{*<font color='red'><{$lang->page->noData}></font>*}>
<{/if}>

<{if $goldType.2}>
	<div id="" style="width: 40%; height: 80%; float:left;">
		<table cellspacing="1" cellpadding="3" border="0" class="table_list sortable"  >
			<caption class='table_list_head'>
				<{$lang->variables->goldIncrease}>
			</caption>
			<tr class='table_list_head'>
		        <th width="20%"><{$lang->variables->goldTypeName}></th>
		        <th width="25%"><{$lang->variables->goldTypeId}></th>
		        <th width="25%"><{$lang->variables->del}></th>
			</tr>
			<{foreach name=loop2 from=$goldType.2 item=item key=id}>
			<tr class='<{cycle values="trEven,trOdd"}>'>
				<td><input type="text" name="increasenames[]" size="40" value="<{$item}>" /></td>
				<td align="center"><input type="text" name="increaseids[]" value="<{$id}>" /></td>
				<td align="center"><a href="javascript:void(0);" class="del"><{$lang->variables->del}></a></td>
			</tr>
			<{foreachelse}>
			<font color='red'><{$lang->page->noData}></font>
			<{/foreach}>
			<tr>
				<td colspan="3" align="right"><input id="addincrease" class="add" value="添加" type="button" /></td>
			</tr>
		</table>
	</div>
<{else}>
<{*<font color='red'><{$lang->page->noData}></font>*}>
<{/if}>
<input type="submit" name="save" value="保存" />
</form>
</div>
</body>
</html>
