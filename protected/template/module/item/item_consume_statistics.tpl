<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>
	<{$lang->menu->itemConsumeStatistics}>
</title>
<link rel="stylesheet" href="/static/css/base.css" type="text/css">
<link rel="stylesheet" href="/static/css/style.css" type="text/css">
<script type="text/javascript" src="/static/js/jquery.min.js"></script>	
<script type="text/javascript" src="/static/js/My97DatePicker/WdatePicker.js"></script>
<script type="text/javascript" src="/static/js/colResizable-1.3.min.js"></script>
<script type="text/javascript" src="/static/js/global.js"></script>
</head>

<body>
<div id="position">
<b><{$lang->menu->class->itemData}>：<{$lang->menu->itemConsumeStatistics}></b>
</div> 

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

<form id="myform2" name="myform2" method="post" action="<{$current_uri}>" style="display: inline;">
	<input type="submit" class="button" name="dateToday" value="<{$lang->page->today}>" >&nbsp;&nbsp;
	<input type="submit" <{if $selectedDay and $selectedDay <= $minDate }> disabled="disabled" <{/if}> class="button" name="datePrev" value="<{$lang->page->prevTime}>">&nbsp;&nbsp;
	<input type="submit" <{if $selectedDay and $selectedDay >= $maxDate }> disabled="disabled" <{/if}> class="button" name="dateNext" value="<{$lang->page->nextTime}>">&nbsp;&nbsp;
	<input type="submit" class="button" name="dateAll" value="<{$lang->page->fromOnlineDate}>" >
	<input type="hidden" class="button" name="selectedDay" value="<{$selectedDay}>" >
</form>
</div>
<br />
<{if $viewData}>
<{*汇总统计*}>
<table cellspacing="1" cellpadding="3" border="0" class='table_list' >
	<caption class="table_list_head">
        <{$lang->menu->itemConsumeStatistics}> <{$startDay}> - <{$endDay}> 
	</caption>
	<tr class='table_list_head'>
		<th align="center"><{$lang->item->itemID}></th>
		<th align="center"><{$lang->item->itemName}></th>
		<th align="center"><{$lang->item->consumeCount}></th>
		<th align="center"><{$lang->item->currentRank}></th>
		<th align="center"><{$lang->item->rankChange}></th>
	</tr>
	<{foreach name=loop from=$viewData key=rank item=item}>
	<tr class='<{cycle values="trEven,trOdd"}>'>
		<td align="center"><{$item.item_id}></td>
		<td align="center"><{$arrItemsAll[$item.item_id].name}></td>
		<td align="center"><{$item.consume_count}></td>
		<td align="center"><{$rank+1}></td>
		<td align="center">
			<{if $item.rank_change == 0}>
				&nbsp;
			<{elseif $item.rank_change > 0}>
				<font color="red">↑<{$item.rank_change}></font>
			<{else}>
				<font color="green">↓<{math equation="0-x" x=$item.rank_change}></font>
			<{/if}>
		</td>
	</tr>
	<{/foreach}>
</table>
<{else}>
<font color='red'><{$lang->page->noData}></font>
<{/if}>
</div>

</body>
</html>
