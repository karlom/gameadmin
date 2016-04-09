<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title><{$lang->menu->petData}></title>
		<link rel="stylesheet" href="/static/css/base.css" type="text/css">
		<link rel="stylesheet" href="/static/css/style.css" type="text/css">
		<script type="text/javascript" src="/static/js/My97DatePicker/WdatePicker.js"></script>
		<script type="text/javascript" src="/static/js/jquery.min.js"></script>
	</head>
	<body>
		<div id="position"><{$lang->menu->class->userInfo}>：<{$lang->menu->petData}></div>
		
		<form method="get">
			<{$lang->page->beginTime}>: <input type="text" id="startDate" name="startDate" class="Wdate" size="12" value="<{$startDate}>" onfocus="WdatePicker({el:'startDate',dateFmt:'yyyy-MM-dd',minDate:'<{$minDate}>',maxDate:'#F{$dp.$D(\'endDate\')}'})" />
			<{$lang->page->endTime}>: <input type="text" id="endDate" name="endDate" class="Wdate" size="12" value="<{$endDate}>" onfocus="WdatePicker({el:'endDate',dateFmt:'yyyy-MM-dd',minDate:'#F{$dp.$D(\'startDate\')}',maxDate:'<{$maxDate}>'})" />
			<input type="submit" id="search" name="search" value="<{$lang->page->serach}>" />
		</form>
		<br />
		
		<table class="DataGrid" style="width:750px;">
			<tr>
				<th align="center" colspan="4"><{$lang->menu->petData}>: <{$startDate}> ~ <{$endDate}></th>
			</tr>
			<{if $viewData}>
			<tr align="center" >
				<th><{$lang->page->date}></th>
				<th><{$lang->pet->newPetCount}></th>
				<th><{$lang->pet->rongheCount}></th>
				<th><{$lang->pet->deleteCount}></th>
			</tr>
			<{foreach from=$viewData item=log key=date name=out}>
			<tr align="center" class='<{cycle values="trEven,trOdd"}>' >
				<td><{$date}></td>
				<td><{if $log.create}><{$log.create}><{else}>0<{/if}></td>
				<td><{if $log.ronghe}><{$log.ronghe}><{else}>0<{/if}></td>
				<td><{if $log.delete}><{$log.delete}><{else}>0<{/if}></td>
			</tr>
			<{/foreach}>
			<{else}>
			<tr><td colspan="4"><b><{$lang->page->noData}></b></td></tr>
			<{/if}>
		</table>
		<br />

	</body>
</html>