<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title><{$lang->menu->lingqiOutputAndExpend}></title>
		<link rel="stylesheet" href="/static/css/base.css" type="text/css">
		<link rel="stylesheet" href="/static/css/style.css" type="text/css">
		<script type="text/javascript" src="/static/js/My97DatePicker/WdatePicker.js"></script>
		<script type="text/javascript" src="/static/js/jquery.min.js"></script>
	</head>
	<body>
		<div id="position"><{$lang->menu->class->spendData}>：<{$lang->menu->lingqiOutputAndExpend}></div>
		
		<form method="get">
			<{$lang->page->beginTime}>: <input type="text" id="startDate" name="startDate" class="Wdate" size="12" value="<{$startDate}>" onfocus="WdatePicker({el:'startDate',dateFmt:'yyyy-MM-dd',minDate:'<{$minDate}>',maxDate:'#F{$dp.$D(\'endDate\')}'})" />
			<{$lang->page->endTime}>: <input type="text" id="endDate" name="endDate" class="Wdate" size="12" value="<{$endDate}>" onfocus="WdatePicker({el:'endDate',dateFmt:'yyyy-MM-dd',minDate:'#F{$dp.$D(\'startDate\')}',maxDate:'<{$maxDate}>'})" />
			<input type="submit" id="search" name="search" value="<{$lang->page->serach}>" />
		</form>
		<br />
		<!-- 灵气产出统计表 -->
		<table class="DataGrid" style="width:750px;">
			<tr>
				<th align="center" colspan="6"><{$lang->lingqi->lingqi}><span style="color:#00F"><{$lang->money->output}></span><{$lang->money->statistics}>: <{$startDate}> ~ <{$endDate}></th>
			</tr>
			<{if $data.lingqiOutput}>
			<tr align="center" >
				<th><{$lang->money->date}></th>
				<th><{$lang->money->output}><{$lang->money->count}></th>
				<th><{$lang->lingqi->sit}></th>
				<th><{$lang->money->other}></th>
			</tr>
			<{foreach from=$data.lingqiOutput item=log key=date name=out}>
			<tr align="center" class='<{cycle values="trEven,trOdd"}>' >
				<td><{$date}></td>
				<td style="color:#00F"><{$log.all}></td>
				<td><{$log.sit}></td>
				<td><{$log.other}></td>
			</tr>
			<{/foreach}>
			<{else}>
			<tr><td colspan="6"><b><{$lang->page->noData}></b></td></tr>
			<{/if}>
		</table>
		<br />
		<!-- 灵气消耗统计表 -->
		<table class="DataGrid" style="width:750px;">
			<tr>
				<th align="center" colspan="6"><{$lang->lingqi->lingqi}><span style="color:#00F"><{$lang->money->expend}></span><{$lang->money->statistics}>: <{$startDate}> ~ <{$endDate}></th>
			</tr>
			<{if $data.lingqiExpend}>
			<tr align="center" >
				<th><{$lang->money->date}></th>
				<th><{$lang->money->expend}><{$lang->money->count}></th>
				<th><{$lang->money->jingjieUpgrade}><{$lang->money->expend}></th>
				<th><{$lang->money->other}></th>
			</tr>
			<{foreach from=$data.lingqiExpend item=log key=date name=use}>
			<tr align="center" class='<{cycle values="trEven,trOdd"}>' >
				<td><{$date}></td>
				<td style="color:#00F"><{$log.all}></td>
				<td><{$log.jingjieUpgrade}></td>
				<td><{$log.other}></td>
			</tr>
			<{/foreach}>
			<{else}>
			<tr><td colspan="6"><b><{$lang->page->noData}></b></td></tr>
			<{/if}>
		</table>

	</body>
</html>