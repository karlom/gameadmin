<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>
	<{$lang->menu->wuhunGet}>
</title>
<link rel="stylesheet" href="/static/css/base.css" type="text/css">
<link rel="stylesheet" href="/static/css/style.css" type="text/css">
<script type="text/javascript" src="/static/js/jquery.min.js"></script>	
<script type="text/javascript" src="/static/js/My97DatePicker/WdatePicker.js"></script>
</head>

<body>
<!-- 
<div id="position">
<b><{$lang->menu->class->userInfo}>：<{$lang->menu->wuhunGet}></b>
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

<div class='divOperation'>
<form id="myform" name="myform" method="get" action="" style="display: inline;">
<{$lang->page->beginTime}>：<input type="text" size="13" class="Wdate" name="start_day" id="start_day" onfocus="WdatePicker({el:'start_day',dateFmt:'yyyy-MM-dd',minDate:'<{$minDate}>',maxDate:'#F{$dp.$D(\'end_day\')}'})" value="<{ $startDay }>">
<{$lang->page->endTime}>：<input type="text" size="13" class="Wdate" name="end_day" id="end_day" onfocus="WdatePicker({el:'end_day',dateFmt:'yyyy-MM-dd',minDate:'#F{$dp.$D(\'start_day\')}',maxDate:'<{$maxDate}>'})"  value="<{ $endDay }>">
<{$lang->page->type}>: <select name="type">
	<{html_options options=$typeArr selected=$type}>
</select>
&nbsp;<{$lang->player->roleName}>:<input type="text" id="role_name" name="role_name" size="10" value="<{$roleName}>" />
&nbsp;<{$lang->player->accountName}>:<input type="text" id="account_name" name="account_name" size="10" value="<{$accountName}>" />
<{$lang->wuhun->name}>:<input type="text" id="wuhun_name" name="wuhun_name" size="10" value="<{$wuhunName}>" />
<{$lang->item->color}>:<select name="color">
	<{html_options options=$dictColor selected=$color}>
</select>
<input type="image" src="/static/images/search.gif" class="input2" align="absmiddle"  />
&nbsp;&nbsp;
</form>
</div>
<{if $viewData.data}>

<{include file='file:pager.tpl' pages=$pager assign=pager_html}>
<{$pager_html}>
<br class="clear"/>
<table style="width: 50%;" cellspacing="1" cellpadding="3" border="0" class="DataGrid table_list" >
	<tr class='table_list_head'>
        <td width="20%"><{$lang->player->accountName}></td>
        <td width="20%"><{$lang->player->roleName}></td>
        <td width="10%"><{$lang->player->level}></td>
		<td width="15%"><{$lang->page->type}></td>
		<td width="15%"><{$lang->page->detailDeal}></td>
        <td width="20%"><{$lang->page->time}></td>
	</tr>
	<{foreach name=loop from=$viewData.data item=item}>
	<tr class='<{cycle values="trEven,trOdd"}>'>
		<td><{$item.account_name}></td>
		<td><{$item.role_name}></td>
		<td><{$item.level}></td>
		<td><{if 0 == $type || 1 == $type}><{$subType[$item.type]}><{/if}><{$typeArr[$item.op_type]}></td>
		<td><span style="color: <{$dictColorValue[$item.wuhun_color]}>"><{$item.wuhun_name}></span> lv:<{$item.wuhun_lv}></td>
		<td><{$item.mtime|date_format:'%Y-%m-%d %H:%M:%S'}></td>
	</tr>
	<{/foreach}>
</table>
<br />
<{$pager_html}>
<{else}>
<font color='red'><{$lang->page->noData}></font>
<{/if}>
</div>

</body>
</html>
