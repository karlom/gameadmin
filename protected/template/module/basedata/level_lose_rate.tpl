<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>
	<{$lang->menu->levelLoseRate}>
</title>
<link rel="stylesheet" href="/static/css/base.css" type="text/css">
<link rel="stylesheet" href="/static/css/style.css" type="text/css">
<script type="text/javascript" src="/static/js/My97DatePicker/WdatePicker.js"></script>
</head>

<body>
<div id="position">
<b><{$lang->menu->class->baseData}>：<{$lang->menu->levelLoseRate}></b>
</div>
<form id="myform" name="myform" method="post" action="">
<span style="font-weight: bold;"><{$lang->page->lossUser}>: <{$lang->page->lossUserDefinition}></span>
<div class='divOperation'>
	<{$lang->page->createRole}><{$lang->page->beginTime}>
	<input id='starttime' name='starttime' type="text" class="Wdate" onfocus="WdatePicker({el:'starttime',dateFmt:'yyyy-MM-dd',minDate:'<{$minDate}>',maxDate:'#F{$dp.$D(\'endtime\')}'})" size='12' value='<{$startDate}>' />
	<{$lang->page->endTime}> 
	<input id='endtime' name='endtime' type="text" class="Wdate" onfocus="WdatePicker({el:'endtime',dateFmt:'yyyy-MM-dd',minDate:'#F{$dp.$D(\'starttime\')}',maxDate:'<{$maxDate}>'})" size='12' value='<{$endDate}>' />
	　<{$lang->page->level}><{$lang->page->from}>
	<input id="minlevel" name="minlevel" type="text" value="<{$minLevel}>" maxlength="3" size="6" />
	<{$lang->page->to}>
	<input id="maxlevel" name="maxlevel" type="text" value="<{$maxLevel}>" maxlength="3" size="6" />
	
	<input type="image" src="/static/images/search.gif" class="input2" align="absmiddle" />
</div>
<table cellspacing="1" cellpadding="3" border="0" class='table_list'>
	<tr class='table_list_head'>
        <td width="6%"><{$lang->page->level}></td>
        <td width="6%"><{$lang->page->level}><{$lang->page->pepole}></td>
        <td width="5%"><{$lang->page->level}><{$lang->page->percentage}></td>
        <td width="6%"><{$lang->page->lossUser}></td>
        <td width="5%"><{$lang->page->lossPercentage}></td>
	</tr>
	<{foreach name=loop from=$level key=key item=item}>
	<tr class='<{cycle values="trEven,trOdd"}>'>
		<td><{$item}></td>
		<td><{$viewData.data[$item].levelNum}></td>
		<td><{$viewData.data[$item].levelRate}></td>
		<td><{$viewData.data[$item].levelLossNum}></td>
		<td><{$viewData.data[$item].levelLossRate}></td>
	</tr>
	<{foreachelse}>
	<font color='red'><{$lang->page->noData}></font>
	<{/foreach}>
	<tr class='<{cycle values="trEven,trOdd"}>'>
		<td align="right"><{$lang->page->totalNum}>:</td>
		<td><{$viewData.totalNum}></td>
		<td align="right"><{$lang->page->totalLoseNum}>:</td>
		<td><{$viewData.totalLossNum}></td>
		<td></td>
	</tr>
</table>
</form>
</body>
</html>
