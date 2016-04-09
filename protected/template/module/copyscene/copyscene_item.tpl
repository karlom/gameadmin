<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>
	<{$lang->menu->copySceneItem}>
</title>
<link rel="stylesheet" href="/static/css/base.css" type="text/css" />
<link rel="stylesheet" href="/static/css/style.css" type="text/css" />
<link rel="stylesheet" href="/static/js/autolist/autolist.css" type="text/css" />
<script type="text/javascript" src="/static/js/jquery.min.js"></script>	
<script type="text/javascript" src="/static/js/My97DatePicker/WdatePicker.js"></script>
<script type="text/javascript" src="/static/js/autolist/autolist.js"></script>
<script type="text/javascript" src="/static/js/sorttable.js"></script>
<script type="text/javascript" src="/static/js/flowtitle.js"></script>
<script type="text/javascript" src="/static/js/colResizable-1.3.min.js"></script>
<script type="text/javascript" src="/static/js/global.js"></script>
</head>

<body>
<div id="position">
<b><{$lang->menu->class->activityManage}>：<{$lang->menu->copySceneItem}></b>
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

<div class='divOperation'>
<form id="myform" name="myform" method="get" action="" style="display: inline;">
<{$lang->copyscene->copyType}>: <{html_options options=$copySceneTypes selected=$copysceneID name='copyscene_id'}>
&nbsp;<{$lang->player->roleName}>:<input type="text" id="role_name" name="role_name" size="15" value="<{$roleName}>" />
&nbsp;<{$lang->player->accountName}>:<input type="text" id="account_name" name="account_name" size="15" value="<{$accountName}>" />
<{$lang->page->beginTime}>：<input type="text" size="13" class="Wdate" name="start_day" id="start_day" onfocus="WdatePicker({el:'start_day',dateFmt:'yyyy-MM-dd',minDate:'<{$minDate}>',maxDate:'#F{$dp.$D(\'end_day\')}'})" value="<{ $startDay }>" />
<{$lang->page->endTime}>：<input type="text" size="13" class="Wdate" name="end_day" id="end_day" onfocus="WdatePicker({el:'end_day',dateFmt:'yyyy-MM-dd',minDate:'#F{$dp.$D(\'start_day\')}',maxDate:'<{$maxDate}>'})"  value="<{ $endDay }>" />
<input type="hidden" name="search" value="1"/>
<input type="hidden" name="pageSize" value="100"/>
<input type="image" src="/static/images/search.gif" class="input2" align="absmiddle"  />
&nbsp;&nbsp;
</form>
</div>
<div class="main-container">
<{if $viewData.data}>
<{include file='file:pager.tpl' pages=$pager assign=pager_html}>

<div class="pager">
<{$pager_html}>
</div>
<table cellspacing="1" cellpadding="3" border="0" class='table_list mini_table sortable no-resize'  style="table-layout:fixed" >
	<tr class='table_list_head flowtitle'>
		<th align="center" width="25%"><{$lang->item->itemID}></th>
		<th align="center" width="25%"><{$lang->item->itemName}></th>
		<th align="center" width="25%"><{$lang->copyscene->dropDatetime}></th>
		<th align="center" width="25%"><{$lang->copyscene->mapName}></th>
	</tr>
	<{foreach name=loop from=$viewData.data.itemList item=item}>
	<tr class='<{cycle values="trEven,trOdd"}>'>
		<td align="center" width="25%"><{$item.item_id}></td>
		<td align="center" width="25%"><{$itemList[$item.item_id]}></td>
		<td align="center" width="25%"><{$item.mtime|date_format:'%Y-%m-%d %H:%M:%S'}></td>
		<td align="center" width="25%"><{$copySceneTypes[$item.map_id]}></td>
	</tr>
	<{/foreach}>
</table>


<table cellspacing="1" cellpadding="3" border="0" class='table_list mini_table sortable'  style="table-layout:fixed" >
	<tr class='table_list_head flowtitle'>
		<th align="center" width="40%"><{$lang->item->itemID}></th>
		<th align="center" width="40%"><{$lang->item->itemName}></th>
		<th align="center" width="20%"><{$lang->copyscene->dropCount}></th>
	</tr>
	<{foreach name=loop from=$viewData.data.itemStatisticsList item=item}>
	<tr class='<{cycle values="trEven,trOdd"}>'>
		<td align="center" width="40%"><{$item.item_id}></td>
		<td align="center" width="40%"><{$itemList[$item.item_id]}></td>
		<td align="center" width="20%"><{$item.item_count}></td>
	</tr>
	<{/foreach}>
</table>

<{else}>
<{*<font color='red'><{$lang->page->noData}></font>*}>
<{/if}>
</div>
</body>
</html>
