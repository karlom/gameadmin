<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link rel="stylesheet" href="/static/css/base.css" type="text/css">
<link rel="stylesheet" href="/static/css/style.css" type="text/css" />
<script type="text/javascript" src="/static/js/My97DatePicker/WdatePicker.js"></script>
<script src="/static/js/jquery.min.js" type="text/javascript"></script>
<script src="/static/js/highcharts/highcharts.js" type="text/javascript"></script>
<script type="text/javascript" src="/static/js/highcharts/modules/exporting.js"></script>
</head>
<title><{$lang->menu->weiduanPlayerRate}></title>

<body>
<div id="position">
<b><{$lang->menu->class->onlineAndReg}>：<{$lang->menu->weiduanPlayerRate}></b>
</div>
<div id="newPlayerRate">
<form name="myform" id="myform" method="post" action="">
	<{$lang->page->beginTime}>:<input id='starttime' name='starttime' type="text" class="Wdate" onfocus="WdatePicker({el:'starttime',dateFmt:'yyyy-MM-dd',minDate:'<{$minDate}>',maxDate:'#F{$dp.$D(\'endtime\')}'})" size='12' value='<{$NewStartDate}>' /> 
	<{$lang->page->endTime}>:<input id='endtime' name='endtime' type="text" class="Wdate" onfocus="WdatePicker({el:'endtime',dateFmt:'yyyy-MM-dd',minDate:'#F{$dp.$D(\'starttime\')}',maxDate:'<{$maxDate}>'})" size='12' value='<{$NewEndDate}>' /> 
	<input id="search" name="search" type="hidden" value="search" />
	<input type="image" src="/static/images/search.gif" class="input2" align="absmiddle" />
</form>
<table cellspacing="1" cellpadding="3" border="0" class='table_list' >
    <tr style=" background-color: #f1f1f1" align="center">
       <th colspan="4">新用户转化率</th>
	</tr>
	<tr class='table_list_head' align="center">
        <td>日期</td>
        <td>当日注册新用户</td>
        <td>当日注册并领取了下载礼包的用户</td>
        <td>新用户转化率</td>
	</tr>	
<{foreach name=loop from=$newRegisterData item=item}>
	<tr class='<{cycle values="trEven,trOdd"}>' align="center">
		<td><{$item.mtime}></td>
		<td><{$item.newRegister}></td>
		<td><{$item.newWeiduan}></td>
		<td><{$item.newPlayerRateData}>%</td>
	</tr>
<{foreachelse}>
	<tr class='<{cycle values="trEven,trOdd"}>' align="center">
        <td colspan="6"><font color='red'><{$lang->page->noData}></font></td>
	</tr>
<{/foreach}>
</table>
<br></br>
<table cellspacing="1" cellpadding="3" border="0" class='table_list' >
    <tr style=" background-color: #f1f1f1" align="center">
       <th colspan="6">老用户日转化率</th>
	</tr>
	<tr class='table_list_head' align="center">
        <td>日期</td>
        <td>当日领取了下载礼包的用户</td>
        <td>当日注册并领取了下载礼包的用户</td>
        <td>当日活跃用户(DAU)</td>
        <td>当日新增注册</td>
        <td>老用户日转化率</td>
	</tr>	
<{foreach name=loop from=$oldData item=item}>
	<tr class='<{cycle values="trEven,trOdd"}>' align="center">
		<td><{$item.mtime}></td>
        <td><{$item.itemTodayCount}></td>
        <td><{$item.newWeiduan}></td>
		<td><{$item.TodayDau}></td>
		<td><{$item.newRegister}></td>
		<td><{$item.oldRate}>%</td>
	</tr>
<{foreachelse}>
	<tr class='<{cycle values="trEven,trOdd"}>' align="center">
        <td colspan="6"><font color='red'><{$lang->page->noData}></font></td>
	</tr>
<{/foreach}>
</table>

<br></br>
<table cellspacing="1" cellpadding="3" border="0" class='table_list' >
    <tr style=" background-color: #f1f1f1" align="center">
       <th colspan="6">老用户周转化率</th>
	</tr>
	<tr class='table_list_head' align="center">
        <td>日期</td>
        <td>当周领取了下载礼包的用户</td>
        <td>当周注册并领取了下载礼包的用户</td>
        <td>当周活跃用户(DAU)</td>
        <td>当周新增注册</td>
        <td>老用户周转化率</td>
	</tr>
    <{if $oldWeekData}>
	<tr class='<{cycle values="trEven,trOdd"}>' align="center">
        <td><{$oldWeekData.mtime}></td>
        <td><{$oldWeekData.itemWeekCount}></td>
        <td><{$oldWeekData.newWeiduanWeek}></td>
        <td><{$oldWeekData.weekDau}></td>
		<td><{$oldWeekData.newRegisterWeek}></td>
		<td><{$oldWeekData.weekRate}>%</td>
	</tr>
    <{else}>
     <tr class='<{cycle values="trEven,trOdd"}>' align="center">
        <td colspan="6"><font color='red'><{$lang->page->noData}></font></td>
	</tr>
    <{/if}>
</table>
</div>
</body>
</html>