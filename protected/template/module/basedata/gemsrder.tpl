<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="/static/css/base.css" type="text/css">
<link rel="stylesheet" href="/static/css/style.css" type="text/css">
<script type="text/javascript" src="/static/js/jquery-1.5.1.min.js"></script>
<script type="text/javascript" src="/static/js/My97DatePicker/WdatePicker.js"></script>

<style type="text/css">
	.hr_red{
		background-color:red;
		width:6px;
	}
</style>
</head>
<title><{$lang->menu->Gemsrder}></title>

<body>
<div id="position">
<b><{$lang->menu->class->baseData}>：<{$lang->menu->Gemsrder}></b>
</div>
<div class='divOperation'>
<form name="myform" id="myform" method="post" action="<{$smarty.const.URL_SELF}>">
	<{$lang->page->roleName}>:<input type="text" id="roleName" name="role[roleName]" size="10" value="<{$role.roleName}>" />
	<{$lang->page->accountName}>:<input type="text" id="accountName" name="role[accountName]" size="10" value="<{$role.accountName}>" />
	<input type="submit" value="<{$lang->page->submit}>" name="sub" id="sub"/>
</form>
</div>
<script type="text/javascript">
        function changePage(page){
                $("#page").val(page);
                $("#myform").submit();
        }
</script>
<table class="DataGrid" cellspacing="0" style="margin:5px;">
	<tr>
		<th><{$lang->gamsrder->account}></th>
		<th><{$lang->gamsrder->rolename}></th>
		<th><{$lang->gamsrder->rolelevel}></th>
		<th><{$lang->gamsrder->advancedtime}></th>
		<th><{$lang->gamsrder->type}></th>
		<th><{$lang->gamsrder->level}></th>
		
	</tr>
	<{foreach name=loop from=$data item=item key=key}>
		<tr class='<{cycle values="trEven,trOdd"}>' style='text-align:center;'>
			<td><{$item.account_name}></td>
			<td><{$item.role_name}></td>
			<td><{$item.level}></td>
			<td><{$item.mdate}></td>
			<td><{$item.stoned_type}></td>
			<td><{$item.stoned_lv}></td>
		</tr>
	<{/foreach}>
        <tr><td colspan="6"><{$lang->gamsrder->time}>:<{$count}></td></tr>
</table><br>
</body>
</html>

