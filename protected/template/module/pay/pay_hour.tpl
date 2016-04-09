<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><{$lang->menu->payAnalyseByHour}></title>
<link rel="stylesheet" href="/static/css/base.css" type="text/css">
<script type="text/javascript" src="/static/js/My97DatePicker/WdatePicker.js"></script>
<script type="text/javascript" src="/static/js/jquery.min.js"></script>
<script language="javascript">
	$(document).ready(function(){
		$("#showType").change(function(){
			$("#myform").submit();
		});
		$("#viewType").change(function(){
			$("#myform").submit();
		});
	});
	function changeDate(dateStr,endDay){
		if(endDay==''){
			$("#startDay").val(dateStr);
			$("#endDay").val(dateStr);
		}else{
			$("#startDay").val(dateStr);
			$("#endDay").val(endDay);
		}
		$("#myform").submit();
	}
</script>
</head>

<body>
<!-- 
	<div id="position"><b><{$lang->menu->class->payAndSpand}>：<{$lang->menu->payAnalyseByHour}></b></div>
 -->
	<form action="#" method='post' id="myform">
	<table style="margin:8px;">
		<tr>
            <td><{$lang->page->beginTime}>:<input id='startDay' name='startDay' type="text" class="Wdate" onfocus="WdatePicker({el:'startDay',dateFmt:'yyyy-MM-dd',minDate:'<{$minDate}>',maxDate:'#F{$dp.$D(\'endDay\')}'})" size='12' value='<{$startDay}>' /></td>
            <td><{$lang->page->endTime}>:<input id='endDay' name='endDay' type="text" class="Wdate" onfocus="WdatePicker({el:'endDay',dateFmt:'yyyy-MM-dd',minDate:'#F{$dp.$D(\'startDay\')}',maxDate:'<{$maxDate}>'})" size='12' value='<{$endDay}>' /></td>
			<td>
			<select name="viewType" id="viewType">
				<{html_options options=$arrViewType selected=$viewType}>
			</select>
			</td>
			<td>
			<select name="showType" id="showType">
				<{html_options options=$arrShowType selected=$showType}>
			</select>
			</td>
			<td><input type="image" name='search' src="/static/images/search.gif" class="input2" align="absmiddle"  /></td>
			<td>
				&nbsp;&nbsp
				<input type="button" class="button" name="dateToday" value="<{$lang->page->today}>" onclick="changeDate('<{$dateToday}>','');">&nbsp;&nbsp;
				<input type="button" class="button" name="datePrev" value="<{$lang->page->preday}>" onclick="changeDate('<{$datePrev}>','');">&nbsp;&nbsp;
				<input type="button" class="button" name="dateNext" value="<{$lang->page->afterday}>" onclick="changeDate('<{$dateNext}>','');">&nbsp;&nbsp;
				<input type="button" class="button" name="dateAll" value="<{$lang->page->fromOnlineDate}>" onclick="changeDate('<{$onlineDay }>','<{$dateToday}>');">
			</td>
		</tr>
	</table>
	</form>

	<{if $paySumHours}>
	<div style="padding:5px;border:1px solid #BBB">
	<{$lang->page->from}> <{ $startDay }> <{$lang->page->to}> <{ $endDay }> <{$lang->page->allPay}>：￥<{ $allSumTotalMoney }> ，<{$lang->page->maxPayByHour}>：￥<{ $maxSumMoney }>， <{$lang->page->avgPayByHour}>：￥<{ $avgSumMoney }>
		<table class="SumDataGrid" cellspacing="0" style="margin:5px;">
			<{if 9 == $showType || 1 == $showType }>
			<tr>
				<th><{$lang->page->showType2}>(￥)</th>
				<{ foreach from=$paySumHours item=subRow }>
					<td align="center" height="150" valign="bottom"><{ $subRow.totalMoney }><hr title="<{$subRow.tip}>" class="<{ if $maxSumMoney > 0 && $subRow.totalMoney/$maxSumMoney >= 0.75 }>hr_red<{else}>hr_green<{/if}>"  style="height:<{if $maxSumMoney > 0}><{ $subRow.totalMoney*120/$maxSumMoney|round }><{else}>0<{/if}>px;" /></td>
				<{ /foreach}>
			</tr>
			<{/if}>
			<{if 9 == $showType || 2 == $showType }>
			<tr>
				<th><{$lang->page->showType3}></th>
				<{ foreach from=$paySumHours item=subRow }>
					<td align="center" height="150" valign="bottom"><{ $subRow.totalPerson }><hr title="<{$subRow.tip}>" class="<{ if $maxSumPerson > 0 && $subRow.totalPerson/$maxSumPerson >= 0.75 }>hr_red<{else}>hr_green<{/if}>"  style="height:<{if $maxSumPerson > 0}><{ $subRow.totalPerson*120/$maxSumPerson|round }><{else}>0<{/if}>px;" /></td>
				<{ /foreach}>
			</tr>
			<{/if}>
			<{if 9 == $showType || 3 == $showType }>
			<tr>
				<th><{$lang->page->showType4}></th>
				<{ foreach from=$paySumHours item=subRow }>
					<td align="center" height="150" valign="bottom"><{ $subRow.totalPersonTime }><hr title="<{$subRow.tip}>" class="<{ if $maxSumPersonTime > 0 && $subRow.totalPersonTime/$maxSumPersonTime >= 0.75 }>hr_red<{else}>hr_green<{/if}>"  style="height:<{if $maxSumPersonTime > 0}><{ $subRow.totalPersonTime*120/$maxSumPersonTime|round }><{else}>0<{/if}>px;" /></td>
				<{ /foreach}>
			</tr>
			<{/if}>
			<{if 9 == $showType || 4 == $showType }>
			<tr>
				<th><{$lang->page->showType5}></th>
				<{ foreach from=$paySumHours item=subRow }>
					<td align="center" height="150" valign="bottom"><{ $subRow.arpu }><hr title="<{$subRow.tip}>" class="<{ if $maxSumArpu > 0 && $subRow.arpu/$maxSumArpu >= 0.75 }>hr_red<{else}>hr_green<{/if}>"  style="height:<{if $maxSumArpu > 0}><{ $subRow.arpu*120/$maxSumArpu|round }><{else}>0<{/if}>px;" /></td>
				<{ /foreach}>
			</tr>
			<{/if}>
			<tr>
				<th>&nbsp;</th>
				<{ foreach from=$paySumHours key=subkey item=any }>
					<th align="center"><{ $subkey }>时</th>
				<{ /foreach }>
			</tr>
		</table>
	</div>
	<br />
	<{else}>
		<{if 1==$viewType}>
		 <{ $startDay }> <{$lang->page->to}> <{ $endDay }> <{$lang->page->noPay}>
		 <{/if}>
	<{ /if }>




	<{ if $payHours }>
	<div style="padding:5px;border:1px solid #BBB">
	  <{$lang->page->from}> <{ $startDay }> <{$lang->page->to}> <{ $endDay }> <{$lang->page->allPay}>：￥<{ $allTotalMoney }> ，<{$lang->page->maxPayByHour}>：￥<{ $maxMoney }>，  <{$lang->page->avgPayByHour}>：￥<{ $avgMoney }>
	<{ foreach from=$payHours item=row key=key }>
		<{ if $row }>
		<table class="SumDataGrid" cellspacing="0" style="margin:5px;">
			<{if 9 == $showType || 1 == $showType }>
			<tr>
				<th width="100" rowspan="<{if 9 == $showType}>5<{else}>2<{/if}>"><{ $key }></th>
				<th><{$lang->page->showType2}>(￥)</th>
				<{ foreach from=$row item=subRow }>
					<td align="center" height="150" valign="bottom"><{ $subRow.totalMoney }><hr title="<{$subRow.tip}>" class="<{ if $maxMoney > 0 && $subRow.totalMoney/$maxMoney >= 0.75 }>hr_red<{else}>hr_green<{/if}>"  style="height:<{if $maxMoney > 0}><{ $subRow.totalMoney*120/$maxMoney|round }><{else}>0<{/if}>px;" /></td>
				<{ /foreach}>
			</tr>
			<{/if}>
			<{if 9 == $showType || 2 == $showType }>
			<tr>
				<{if  2 == $showType }><th width="100" rowspan="<{if 9 == $showType}>5<{else}>2<{/if}>"><{ $key }></th><{/if}>
				<th><{$lang->page->showType3}></th>
				<{ foreach from=$row item=subRow }>
					<td align="center" height="150" valign="bottom"><{ $subRow.totalPerson }><hr title="<{$subRow.tip}>" class="<{ if $maxPerson > 0 && $subRow.totalPerson/$maxPerson >= 0.75 }>hr_red<{else}>hr_green<{/if}>"  style="height:<{if $maxPerson > 0}><{ $subRow.totalPerson*120/$maxPerson|round }><{else}>0<{/if}>px;" /></td>
				<{ /foreach}>
			</tr>
			<{/if}>
			<{if 9 == $showType || 3 == $showType }>
			<tr>
			<{if  3 == $showType }><th width="100" rowspan="<{if 9 == $showType}>5<{else}>2<{/if}>"><{ $key }></th><{/if}>
				<th><{$lang->page->showType4}></th>
				<{ foreach from=$row item=subRow }>
					<td align="center" height="150" valign="bottom"><{ $subRow.totalPersonTime }><hr title="<{$subRow.tip}>" class="<{ if $maxPersonTime > 0 && $subRow.totalPersonTime/$maxPersonTime >= 0.75 }>hr_red<{else}>hr_green<{/if}>"  style="height:<{if $maxPersonTime > 0}><{ $subRow.totalPersonTime*120/$maxPersonTime|round }><{else}>0<{/if}>px;" /></td>
				<{ /foreach}>
			</tr>
			<{/if}>
			<{if 9 == $showType || 4 == $showType }>
			<tr>
				<{if  4 == $showType }><th width="100" rowspan="<{if 9 == $showType}>5<{else}>2<{/if}>"><{ $key }></th><{/if}>
				<th><{$lang->page->showType5}></th>
				<{ foreach from=$row item=subRow }>
					<td align="center" height="150" valign="bottom"><{ $subRow.arpu }><hr title="<{$subRow.tip}>" class="<{ if $maxArpu > 0 && $subRow.arpu/$maxArpu >= 0.75 }>hr_red<{else}>hr_green<{/if}>"  style="height:<{if $maxArpu > 0}><{ $subRow.arpu*120/$maxArpu|round }><{else}>0<{/if}>px;" /></td>
				<{ /foreach}>
			</tr>
			<{/if}>
			<tr>
				<th>&nbsp;</th>
				<{ foreach from=$row key=subkey item=any }>
					<th align="center"><{ $subkey }>时</th>
				<{ /foreach }>
			</tr>
		</table>
		<{ /if }>
	<{ /foreach }>
	</div>
	<{else}>
		<{if 2==$viewType}>
	 	<{$startDay}> <{$lang->page->to}> <{$endDay}> <{$lang->page->noPay}>
		<{/if}>
	<{ /if }>

</body>
</html>
