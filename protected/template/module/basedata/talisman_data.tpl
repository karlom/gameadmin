<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title><{$lang->menu->talismanData}></title>
		<link rel="stylesheet" href="/static/css/base.css" type="text/css">
		<link rel="stylesheet" href="/static/css/style.css" type="text/css">
		<script type="text/javascript" src="/static/js/My97DatePicker/WdatePicker.js"></script>
		<script type="text/javascript" src="/static/js/jquery.min.js"></script>
	</head>
	<body>
		<div id="position"><{$lang->menu->class->userInfo}>：<{$lang->menu->talismanData}></div>
		
		<form method="get">
			<{$lang->page->beginTime}>: <input type="text" id="startDate" name="startDate" class="Wdate" size="12" value="<{$startDate}>" onfocus="WdatePicker({el:'startDate',dateFmt:'yyyy-MM-dd',minDate:'<{$minDate}>',maxDate:'#F{$dp.$D(\'endDate\')}'})" />
			<{$lang->page->endTime}>: <input type="text" id="endDate" name="endDate" class="Wdate" size="12" value="<{$endDate}>" onfocus="WdatePicker({el:'endDate',dateFmt:'yyyy-MM-dd',minDate:'#F{$dp.$D(\'startDate\')}',maxDate:'<{$maxDate}>'})" />
			<input type="submit" id="search" name="search" value="<{$lang->page->serach}>" />
		</form>
		<br />
		
		<{$lang->talisman->upgradeData}>: 
		<table class="DataGrid" style="width:750px;">
			<tr>
				<th align="center" colspan="5"><{$lang->talisman->upgradeData}>: <{$startDate}> ~ <{$endDate}></th>
			</tr>
			<{if $viewData}>
			<tr align="center" >
				<th><{$lang->talisman->name}></th>
				<th><{$lang->talisman->upgradeCount}></th>
				<th><{$lang->talisman->failCount}></th>
				<th><{$lang->talisman->successCount}></th>
				<th><{$lang->talisman->successRate}></th>
			</tr>
			<{foreach from=$viewData.upgrade item=log key=key name=out}>
			<tr align="center" class='<{cycle values="trEven,trOdd"}>' >
				<td><{$log.name}></td>
				<td><{if $log.all_count}><{$log.all_count}><{else}>0<{/if}></td>
				<td><{if $log.failed}><{$log.failed}><{else}>0<{/if}></td>
				<td><{if $log.success}><{$log.success}><{else}>0<{/if}></td>
				<td><{if $log.rate}><{$log.rate}><{else}>0<{/if}>%</td>
			</tr>
			<{/foreach}>
			<{else}>
			<tr><td colspan="4"><b><{$lang->page->noData}></b></td></tr>
			<{/if}>
		</table>
		<br />
		
		<{$lang->talisman->illusionData}>: 
		<table class="DataGrid" style="width:750px;">

			<{if $viewData}>
			<tr align="center" >
				<th><{$lang->talisman->name}></th>
				<th><{$lang->talisman->illusionCount}></th>
			</tr>
			<{foreach from=$viewData.illusion item=log key=key name=out}>
			<tr align="center" class='<{cycle values="trEven,trOdd"}>' >
				<td><{$log.name}></td>
				<td><{if $log.active_count}><{$log.active_count}><{else}>0<{/if}></td>
			</tr>
			<{/foreach}>
			<{else}>
			<tr><td colspan="4"><b><{$lang->page->noData}></b></td></tr>
			<{/if}>
		</table>

	</body>
</html>