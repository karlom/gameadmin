<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><{$lang->menu->giveGoldRecord}></title>
<link rel="stylesheet" href="/static/css/base.css" type="text/css">
<link rel="stylesheet" href="/static/css/style.css" type="text/css">
<script type="text/javascript" src="/static/js/My97DatePicker/WdatePicker.js"></script>
<script type="text/javascript" src="/static/js/jquery.min.js"></script>
<script type="text/javascript" src="/static/js/global.js"></script>

</head>

<body>
<!-- 
	<div id="position"><b><{$lang->menu->class->payAndSpand}>：<{$lang->menu->giveGoldRecord}></b></div>
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
	
	
	<form action="" method="GET" id="myform">
	<table style="margin:20px;">
		<tr>
			<td><{$lang->page->beginTime}>：<input type="text" size="13" class="Wdate" name="startDay" id="startDay" onfocus="WdatePicker({el:'startDay',dateFmt:'yyyy-MM-dd',minDate:'<{$minDate}>',maxDate:'#F{$dp.$D(\'endDay\')}'})" value="<{ $startDay }>"></td>
			<td><{$lang->page->endTime}>：<input type="text" size="13" class="Wdate" name="endDay" id="endDay" onfocus="WdatePicker({el:'endDay',dateFmt:'yyyy-MM-dd',minDate:'#F{$dp.$D(\'startDay\')}',maxDate:'<{$maxDate}>'})"  value="<{ $endDay }>"></td>
			<td><{$lang->page->applyID}>: <input id="applyID" name="applyID" value="<{$applyID}>" /></td>
			<td><{$lang->player->roleName}>: <input id="roleName" name="roleName" value="<{$roleName}>" /></td>
			<td><input type="image" name='search' src="/static/images/search.gif" class="input2" align="absmiddle"  /></td>
		</tr>
	</table>
	</form>
	
	
	<{ if $viewData.data }>
	
	<{if $applyID or $roleName}>
	<form action="<{$smarty.server.PHP_SELF}>" method="POST" id="lbform">
		<input type="hidden" name="startDay"  value="<{ $startDay }>">
		<input type="hidden" name="endDay"  value="<{ $endDay }>">
		<input type="hidden" name="applyID" value="<{$applyID}>" />
		<input type="hidden" name="roleName" value="<{$roleName}>" />
		<input type="hidden" name="action" value="deleteRecord" />
		&nbsp;&nbsp;<input type="submit" name='delete' value="删除搜索结果"  />
	</form>
	<{/if}>
	<br>
		<{include file='file:pager.tpl' pages=$pager assign=pager_html}>
		<{$pager_html}>
		<table id="mainTable" class="SumDataGrid" cellspacing="0" style="margin:5px;" width="100%">
		<caption class="table_list_head" align="center">
			<{$lang->page->from}> <{ $startDay }> <{$lang->page->to}> <{ $endDay }> 
		</caption>

		<tr class="alwaysdisplay">
			<th align="center" width="10%"><{ $lang->page->applyID }></th>
			<th width="15%"><{$lang->page->date}></th>
			<th align="center" width="15%"><{ $lang->page->accountName }></th>
			<th align="center" width="15%"><{ $lang->page->roleName }></th>
			<th align="center" width="40%"><{ $lang->page->items }></th>
		</tr>

		
		<{foreach from=$viewData.data item=item key=key name=mainLoop}>
			
			<tr <{ if $smarty.foreach.mainLoop.index is odd }> class="odd"<{ /if }> >
				<td align="center"><{$item.applyID}></td> 
				<td align="center"><{$item.mtime|date_format:"%Y-%m-%d %H:%M:%S"}></td>
				<td align="center"><{$item.account_name}></td>
				<td align="center" class="cmenu" title="<{$item.role_name}>"><{$item.role_name}></td>
				<td ><{$item.items}></td> 
				<!--
				<td>	
					<{if $item.item_id gt 0 and $item.num > 0}>
						<span class="label"><{$arrItemsAll[$item.item_id].name}></span>: <{$item.num}>
					<{else}>
						N/A
					<{/if}>
				</td> 
				-->
			</tr>
		<{/foreach}>
		</table>
		<{$pager_html}>
	<{ else }>
		 <{$lang->page->noRecord}>
	<{ /if }>
</body>
</html>