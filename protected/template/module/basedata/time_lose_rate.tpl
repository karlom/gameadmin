<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>
	<{$lang->menu->timeLoseRate}>
</title>
<link rel="stylesheet" href="/static/css/base.css" type="text/css">
<link rel="stylesheet" href="/static/css/style.css" type="text/css">
<script type="text/javascript" src="/static/js/sorttable.js"></script>
<script type="text/javascript" src="/static/js/My97DatePicker/WdatePicker.js"></script>
</head>

<body>
<div id="position">
<b><{$lang->menu->class->baseData}>：<{$lang->menu->timeLoseRate}></b>
</div>
<form id="myform" name="myform" method="post" action="">
<span style="font-weight: bold;"><{$lang->page->lastLogoutTimeDistribution}></span>
<div class='divOperation'>
	<input id='starttime' name='starttime' type="text" class="Wdate" onfocus="WdatePicker({el:'starttime',dateFmt:'yyyy-MM-dd',minDate:'<{$minDate}>',maxDate:'#F{$dp.$D(\'endtime\')}'})" size='12' value='<{$startDate}>' />
	<{$lang->page->to}> 
	<input id='endtime' name='endtime' type="text" class="Wdate" onfocus="WdatePicker({el:'endtime',dateFmt:'yyyy-MM-dd',minDate:'#F{$dp.$D(\'starttime\')}',maxDate:'<{$maxDate}>'})" size='12' value='<{$endDate}>' />
	<{$lang->page->registPlayer}> 
<input type="image" src="/static/images/search.gif" class="input2" align="absmiddle" />
</div>
<div class="clearfix" style="margin-top: 10px;">
<table cellspacing="1" cellpadding="3" border="0" class='table_list sortable' style="width: 50%; float: left;" >
	<caption class='table_list_head'>
		<{$lang->page->firstDay}>
	</caption>
	<tr class='table_list_head'>
        <th width="6%"><{$lang->page->lastLogoutTimeReduceRegistTime}></th>
        <th width="6%"><{$lang->page->pepole}></th>
        <th width="5%"><{$lang->page->percentage}></th>
	</tr>
	<{foreach name=loop from=$viewData.arrMinutes item=item}>
	<tr class='<{cycle values="trEven,trOdd"}>'>
		<td><{$item.desc}></td>
		<td><{$item.num}></td>
		<td><{if 0 < $totalMinuteNum}><{math equation="x/y*100" x=$item.num y=$totalMinuteNum format="%.2f"}>%<{else}>N/A<{/if}></td>
	</tr>
	<{foreachelse}>
	<font color='red'><{$lang->page->noData}></font>
	<{/foreach}>
	<tfoot>
	<tr class='<{cycle values="trEven,trOdd"}>'>
		<td align="right"><{$lang->page->totalNum}>:</td>
		<td colspan="2"><{$totalMinuteNum}></td>
	</tr>
	</tfoot>
</table>
<table cellspacing="1" cellpadding="3" border="0" class='table_list sortable' style="width: 49%; float: right;" >
	<caption class='table_list_head'>
		<{$lang->page->firstMonth}>
	</caption>
	<tr class='table_list_head'>
        <th width="6%"><{$lang->page->lastLogoutTimeReduceRegistTime}></th>
        <th width="6%"><{$lang->page->pepole}></th>
        <th width="5%"><{$lang->page->percentage}></th>
	</tr>
	<{foreach name=loop from=$viewData.arrDays item=item}>
	<tr class='<{cycle values="trEven,trOdd"}>'>
		<td><{$item.desc}></td>
		<td><{$item.num}></td>
		<td><{if 0 < $totalDayNum}><{math equation="x/y*100" x=$item.num y=$totalDayNum format="%.2f"}>%<{else}>N/A<{/if}></td>
	</tr>
	<{foreachelse}>
	<font color='red'><{$lang->page->noData}></font>
	<{/foreach}>
	<tfoot>
	<tr class='<{cycle values="trEven,trOdd"}>'>
		<td align="right"><{$lang->page->totalNum}>:</td>
		<td colspan="2"><{$totalDayNum}></td>
	</tr>
	</tfoot>
</table>
</div>
</form>
</body>
</html>
