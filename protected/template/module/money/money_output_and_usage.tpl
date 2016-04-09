<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title><{$lang->menu->moneyOutputAndUsage}></title>
		<link rel="stylesheet" href="/static/css/base.css" type="text/css">
		<link rel="stylesheet" href="/static/css/style.css" type="text/css">
		<script type="text/javascript" src="/static/js/My97DatePicker/WdatePicker.js"></script>
		<script type="text/javascript" src="/static/js/jquery.min.js"></script>
	</head>
	<body>
		<div id="position"><{$lang->menu->class->spendData}>：<{$lang->menu->moneyOutputAndUsage}></div>
		
		<form method="get">
			<{$lang->page->beginTime}>: <input type="text" id="startDate" name="startDate" class="Wdate" size="12" value="<{$startDate}>" onfocus="WdatePicker({el:'startDate',dateFmt:'yyyy-MM-dd',minDate:'<{$minDate}>',maxDate:'#F{$dp.$D(\'endDate\')}'})" />
			<{$lang->page->endTime}>: <input type="text" id="endDate" name="endDate" class="Wdate" size="12" value="<{$endDate}>" onfocus="WdatePicker({el:'endDate',dateFmt:'yyyy-MM-dd',minDate:'#F{$dp.$D(\'startDate\')}',maxDate:'<{$maxDate}>'})" />
			<input type="submit" id="search" name="search" value="<{$lang->page->serach}>" />
		</form>
		<br />
		<!-- 银两产出统计表 -->
		<table class="DataGrid" style="width:750px;">
			<tr>
				<th align="center" colspan="6"><{$lang->money->money}><span style="color:#00F"><{$lang->money->output}></span><{$lang->money->statistics}>: <{$startDate}> ~ <{$endDate}></th>
			</tr>
			<{if $data.moneyOutput}>
			<tr align="center" >
				<th><{$lang->money->date}></th>
				<th><{$lang->money->output}><{$lang->money->count}></th>
				<th><{$lang->money->monster}></th>
				<th><{$lang->money->itemSell}></th>
				<th><{$lang->money->task}></th>
				<th><{$lang->money->other}></th>
			</tr>
			<{foreach from=$data.moneyOutput item=log key=date name=out}>
			<tr align="center" class='<{cycle values="trEven,trOdd"}>' >
				<td><{$date}></td>
				<td style="color:#00F"><{$log.all}></td>
				<td><{$log.monster}></td>
				<td><{$log.itemSell}></td>
				<td><{$log.task}></td>
				<td><{$log.other}></td>
			</tr>
			<{/foreach}>
			<{else}>
			<tr><td colspan="6"><b><{$lang->page->noData}></b></td></tr>
			<{/if}>
		</table>
		<br />
		<!-- 银两产消耗统计表 -->
		<table class="DataGrid" style="width:750px;">
			<tr>
				<th align="center" colspan="8"><{$lang->money->money}><span style="color:#00F"><{$lang->money->expend}></span><{$lang->money->statistics}>: <{$startDate}> ~ <{$endDate}></th>
			</tr>
			<{if $data.moneyExpend}>
			<tr align="center" >
				<th><{$lang->money->date}></th>
				<th><{$lang->money->expend}><{$lang->money->count}></th>
				<th><{$lang->money->itemBuy}><{$lang->money->expend}></th>
				<th><{$lang->money->equipmentStrengthen}><{$lang->money->expend}></th>
				<th><{$lang->money->jingjieUpgrade}><{$lang->money->expend}></th>
				<th><{$lang->money->familyContribute}><{$lang->money->expend}></th>
				<th><{$lang->money->huntLite}><{$lang->money->expend}></th>
				<th><{$lang->money->other}></th>
			</tr>
			<{foreach from=$data.moneyExpend item=log key=date name=use}>
			<tr align="center" class='<{cycle values="trEven,trOdd"}>' >
				<td><{$date}></td>
				<td style="color:#00F"><{$log.all}></td>
				<td><{$log.itemBuy}></td>
				<td><{$log.equipmentStrengthen}></td>
				<td><{$log.jingjieUpgrade}></td>
				<td><{$log.familyContribute}></td>
				<td><{$log.huntLife}></td>
				<td><{$log.other}></td>
			</tr>
			<{/foreach}>
			<{else}>
			<tr><td colspan="6"><b><{$lang->page->noData}></b></td></tr>
			<{/if}>
		</table>
		<br />
		<!-- 银两产流通统计表 -->
		<table class="DataGrid" style="width:750px;">
			<tr>
				<th align="center" colspan="6"><{$lang->money->money}><span style="color:#00F"><{$lang->money->circulate}></span><{$lang->money->statistics}>: <{$startDate}> ~ <{$endDate}></th>
			</tr>
			<{if $data.moneyCirculate}>
			<tr align="center" >
				<th><{$lang->money->date}></th>
				<th><{$lang->money->circulate}><{$lang->money->count}></th>
				<th><{$lang->money->deal}><{$lang->money->count}></th>
				<th><{$lang->money->market}><{$lang->money->count}></th>
				<th><{$lang->money->buyGold}><{$lang->money->count}></th>
				<th><{$lang->money->rate}></th>
			</tr>
			<{foreach from=$data.moneyCirculate item=log key=date name=circle}>
			<tr align="center" class='<{cycle values="trEven,trOdd"}>' >
				<td><{$date}></td>
				<td style="color:#00F"><{$log.all}></td>
				<td><{$log.deal}></td>
				<td><{$log.market}></td>
				<td><{$log.buyGold}></td>
				<td><{ if $log.goleRate}><{$log.goleRate}><{else}>-<{/if}></td>
			</tr>
			<{/foreach}>
			<{else}>
			<tr><td colspan="6"><b><{$lang->page->noData}></b></td></tr>
			<{/if}>
		</table>
	</body>
</html>