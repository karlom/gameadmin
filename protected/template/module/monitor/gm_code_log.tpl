<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title><{$lang->menu->gmCode }></title>
		<link rel="stylesheet" href="/static/css/base.css" type="text/css">
		<link rel="stylesheet" href="/static/css/style.css" type="text/css">
		<script type="text/javascript" src="/static/js/My97DatePicker/WdatePicker.js"></script>
		<script type="text/javascript" src="/static/js/jquery.min.js"></script>
		<script type="text/javascript">
			$(document).ready(function(){
				
				$("#accountName").keydown(function(){
					$("#roleName").val('');
				});
				$("#roleName").keydown(function(){
					$("#accountName").val('');
				});
				
			});
		</script>
	</head>
	
	<body>
		<div id="position"><{$lang->menu->class->dataAlert}>：<{$lang->menu->gmCode}></div>
		
		<form action="#" method="GET" id="searchform">
			<table style="margin:20px;">
				<tr>
					<td><{$lang->page->beginTime}>：<input type="text" size="13" class="Wdate" name="startDay" id="startDay" onfocus="WdatePicker({el:'startDay',dateFmt:'yyyy-MM-dd',minDate:'<{$minDate}>',maxDate:'#F{$dp.$D(\'endDay\')}'})" value="<{ $startDay }>"></td>
					<td><{$lang->page->endTime}>：<input type="text" size="13" class="Wdate" name="endDay" id="endDay" onfocus="WdatePicker({el:'endDay',dateFmt:'yyyy-MM-dd',minDate:'#F{$dp.$D(\'startDay\')}',maxDate:'<{$maxDate}>'})"  value="<{ $endDay }>"></td>

					<td><{$lang->player->accountName}>: <input id="accountName" name="accountName" size="15" value="<{$accountName}>" 	/></td>
					<td><{$lang->player->roleName}>: <input id="roleName" name="roleName" size="15" value="<{$roleName}>" /></td>
					<td><{$lang->monitor->code}>: <input id="cmd" name="cmd" size="10" value="<{$cmd}>" /></td>
					<td><input type="image" name='search' src="/static/images/search.gif" class="input2" align="absmiddle"  /></td>
				</tr>
			</table>
		</form>
		<{include file='file:pager.tpl' pages=$pager assign=pager_html }>
		<{$pager_html}>
		<table class="DataGrid" style="width:800px;">
			<caption class="table_list_head" align="center">
				<{$lang->menu->gmCode}>
			</caption>
			
			<{if $data.data}>
			<tr>
				<th width="5%"><{$lang->monitor->id}></th>
				<th width="15%"><{$lang->page->date}></th>
				<th width="10%"><{$lang->player->accountName}></th>
				<th width="10%"><{$lang->player->roleName}></th>
				<th width="10%"><{$lang->monitor->code}></th>
				<th width="10%"><{$lang->monitor->arg}></th>
				<th width="20%"><{$lang->monitor->desc}></th>
			</tr>
			<{foreach from=$data.data item=log name=loop}>
			<tr align="center" <{ if $smarty.foreach.loop.index is odd }> class="odd"<{ /if }> >
				<td><{$log.id}></td>
				<td><{$log.mdate}></td>
				<td><{$log.account_name}></td>
				<td><{$log.role_name}></td>
				<td><{$log.cmd}></td>
				<td><{$log.arg}></td>
				<td><{$log.desc}></td>
			</tr>
			<{/foreach}>
			<{else}>
			<tr><td colspan="7"><{$lang->page->noData}></td></tr>
			<{/if}>
		</table>
		<{$pager_html}>
	</body>
</html>