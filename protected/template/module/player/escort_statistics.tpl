<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>
	<{$lang->menu->escortStatistics}>
</title>
<link rel="stylesheet" href="/static/css/base.css" type="text/css">
<link rel="stylesheet" href="/static/css/style.css" type="text/css">
<script type="text/javascript" src="/static/js/jquery.min.js"></script>	
<script type="text/javascript" src="/static/js/My97DatePicker/WdatePicker.js"></script>
<script type="text/javascript" src="/static/js/colResizable-1.3.min.js"></script>
<script type="text/javascript" src="/static/js/global.js"></script>
</head>

<body>
<!--  
<div id="position">
<b><{$lang->menu->class->userInfo}>：<{$lang->menu->escortStatistics}></b>
</div> 
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

<div class='divOperation'>
<form id="myform" name="myform" method="get" action="" style="display: inline;">
<{$lang->page->beginTime}>：<input type="text" size="13" class="Wdate" name="start_day" id="start_day" onfocus="WdatePicker({el:'start_day',dateFmt:'yyyy-MM-dd',minDate:'<{$minDate}>',maxDate:'#F{$dp.$D(\'end_day\')}'})" value="<{ $startDay }>">
<{$lang->page->endTime}>：<input type="text" size="13" class="Wdate" name="end_day" id="end_day" onfocus="WdatePicker({el:'end_day',dateFmt:'yyyy-MM-dd',minDate:'#F{$dp.$D(\'start_day\')}',maxDate:'<{$maxDate}>'})"  value="<{ $endDay }>">
<input type="image" src="/static/images/search.gif" class="input2" align="absmiddle"  />
&nbsp;&nbsp;
</form>
</div>
<{if $viewData}>
<{*汇总统计*}>
<{$lang->player->generalStatistics}>：
<table cellspacing="1" cellpadding="3" border="0" class='DataGrid table_list' >
	<tr class='table_list_head'>
        <th><{$lang->player->acceptTimes}></th>
        <th><{$lang->player->abandonTimes}></th>
        <th><{$lang->player->hijackTimes}></th>
        <th><{$lang->player->finishTimes}></th>
		<th><{$lang->player->acceptRoleCounts}></th>
        <th><{$lang->player->finishRoleCounts}></th>
	</tr>
	<tr class='<{cycle values="trEven,trOdd"}>'>
		<td align="center"><{$viewData.general.accept_times}></td>
		<td align="center"><{$viewData.general.abandon_times}></td>
		<td align="center"><{$viewData.general.hijack_times}></td>
		<td align="center"><{$viewData.general.finish_times}></td>
		<td align="center"><{$viewData.general.accept_role_counts}></td>
		<td align="center"><{$viewData.general.finish_role_counts}></td>
	</tr>
</table>
<br />

<{*灵兽颜色分布统计：（玩家领取灵兽的颜色）*}>
<{$lang->player->initEscortColorStatistics}>：
<table cellspacing="1" cellpadding="3" border="0" class='DataGrid table_list' >
	<tr class='table_list_head'>
	<{foreach name=loop from=$dictColor item=item}>
        <th><{$item}></th>
    <{/foreach}>
	</tr>
	<tr class='<{cycle values="trEven,trOdd"}>'>
	<{foreach name=loop from=$viewData.accept_color item=item}>
		<td align="center"><{$item}></td>
	<{/foreach}>
	</tr>
</table>
<br />

<{*刷新灵兽颜色分布统计：（玩家刷新灵兽并领取的灵兽颜色）*}>
<{$lang->player->refreshEscortColorStatistics}>：
<table cellspacing="1" cellpadding="3" border="0" class='DataGrid table_list' >
	<tr class='table_list_head'>
	<{foreach name=loop from=$dictColor item=item}>
        <th><{$item}></th>
    <{/foreach}>
	</tr>
	<tr class='<{cycle values="trEven,trOdd"}>'>
	<{foreach name=loop from=$viewData.refresh_color item=item}>
		<td align="center"><{$item}></td>
	<{/foreach}>
	</tr>
</table>
<br />

<{*刷新灵兽颜色次数分布统计：（玩家刷新灵兽并领取的灵兽颜色及次数分布）*}>
<{$lang->player->refreshEscortColorTimesStatistics}>：
<table cellspacing="1" cellpadding="3" border="0" class='DataGrid table_list' >
	<tr class='table_list_head'>
		<th width="10%"><{$lang->player->refreshTimes}></th>
	<{foreach name=loop from=$dictColor item=item}>
        <th><{$item}></th>
    <{/foreach}>
	</tr>
	<{foreach name=loop from=$viewData.refresh_color_times item=item}>
		<tr class='<{cycle values="trEven,trOdd"}>'>
			<td align="center"><{$item.label}></td>
		<{foreach name=loop from=$item.data item=times}>
			<td align="center"><{$times}></td>
		<{/foreach}>
		</tr>
	<{/foreach}>
</table>
<{else}>
<font color='red'><{$lang->page->noData}></font>
<{/if}>
</div>

</body>
</html>
