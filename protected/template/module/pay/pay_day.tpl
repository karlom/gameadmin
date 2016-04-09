<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><{$lang->menu->payAnalyseByDay}></title>
<link rel="stylesheet" href="/static/css/base.css" type="text/css">
<link rel="stylesheet" href="/static/css/style.css" type="text/css">
<script type="text/javascript" src="/static/js/My97DatePicker/WdatePicker.js"></script>
<script type="text/javascript" src="/static/js/jquery.min.js"></script>
</head>

<body>
<!-- 
	<div id="position"><b><{$lang->menu->class->payAndSpand}>：<{$lang->menu->payAnalyseByDay}></b></div>
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
	<form action="#" method="POST" id="myform">
	<table style="margin:20px;">
		<tr>
			<td><{$lang->page->beginTime}>：<input type="text" size="13" class="Wdate" name="startDay" id="startDay" onfocus="WdatePicker({el:'startDay',dateFmt:'yyyy-MM-dd',minDate:'<{$minDate}>',maxDate:'#F{$dp.$D(\'endDay\')}'})" value="<{ $startDay }>"></td>
			<td><{$lang->page->endTime}>：<input type="text" size="13" class="Wdate" name="endDay" id="endDay" onfocus="WdatePicker({el:'endDay',dateFmt:'yyyy-MM-dd',minDate:'#F{$dp.$D(\'startDay\')}',maxDate:'<{$maxDate}>'})"  value="<{ $endDay }>"></td>
			<td><input type="image" name='search' src="/static/images/search.gif" class="input2" align="absmiddle"  /></td>
			<td>
				&nbsp;&nbsp;
				<input type="submit" class="button" name="dateToday" value="<{$lang->page->today}>" onclick="changeDate('<{$dateToday}>','');">&nbsp;&nbsp;
				<input type="submit" <{if $currentDay and $currentDay <= $minDate }> disabled="disabled" <{/if}> class="button" name="datePrev" value="<{$lang->page->prevTime}>" onclick="changeDate('<{$datePrev}>','');">&nbsp;&nbsp;
				<input type="submit" <{if $currentDay and $currentDay >= $maxDate }> disabled="disabled" <{/if}> class="button" name="dateNext" value="<{$lang->page->nextTime}>" onclick="changeDate('<{$dateNext}>','');">&nbsp;&nbsp;
				<input type="submit" class="button" name="dateAll" value="<{$lang->page->fromOnlineDate}>" onclick="changeDate('<{$dateOnline}>','<{$dateToday}>');">
			</td>
		</tr>
	</table>
	</form>
	
	<{$lang->page->from}> <{ $startDay }> <{$lang->page->to}> <{ $endDay }> 
	<{ if $viewData.data }>
	  <span class="label"><{$lang->page->allPay}></span>：<{$lang->page->currencySymbol}><{ $viewData.totalPay }>，
	  <span class="label"><{$lang->page->maxPayByDay}></span>：<{$lang->page->currencySymbol}><{ $viewData.maxPay }>， 
	  <span class="label"><{$lang->page->avgPayByDay}></span>：<{$lang->page->currencySymbol}><{ $viewData.avgPay|string_format:"%.2f"}>，
	  <span class="label"><{$lang->page->dayMaxPayer}></span>：<{$viewData.maxPayers}>，
	  <span class="label"><{$lang->page->dayMaxARPU}></span>：<{$lang->page->currencySymbol}><{$viewData.maxARPU|string_format:"%.2f"}>
	  <div>
		<span class="hr_red" style=" height:10px" >&nbsp;</span> <{$lang->page->gt}><{$highlightPercentage*100}>%
		<span class="hr_green" style=" height:10px" >&nbsp;</span> <{$lang->page->lt}><{$highlightPercentage*100}>%
		<{html_options options=$dictPayStatisticsType name='showType' id="showType"}>
	  </div>
		<table id="mainTable" class="SumDataGrid" cellspacing="0" style="margin:5px;">
		<{capture name=monthHeader}>
		<tr class="alwaysdisplay">
			<th width="30"><{$lang->page->date}></th>
			<{ foreach from=$viewData.data key=day item=record}>
				<th align="center" style="padding:0px 5px;" width="40"><{ $day|@substr:5 }></th>
			<{ /foreach }>
		</tr>
		<{/capture}>
		<{$smarty.capture.monthHeader}>
		
		<{foreach from=$keyLabelMap item=item key=key name=mainLoop}>
			<tr class="<{$key}>">
				<th width="30" ><{$item.label}></th>
				<{assign var=division value=$item.maxValue*$highlightPercentage}>
				<{ foreach from=$viewData.data item=record}>
					<td align="center" height="150" width="40" valign="bottom">
					<{if $key == 'arpu'}><{$record[$key]|string_format:"%.2f"}><{else}><{$record[$key]}><{/if}>
					<{if $record[$key] >= $division }>
						<{assign var=class value='hr_red'}>
					<{else}>
						<{assign var=class value='hr_green'}>
					<{/if}>

					<hr class="<{$class}>" style=" height:<{math equation="(x/y)*120" x=$record[$key] y=$item.maxValue}>px;" />
					</td>
				<{ /foreach}>
			</tr>
		<{/foreach}>
		<{$smarty.capture.monthHeader}>
		</table>
	<{ else }>
		 <{$lang->page->noPay}>
	<{ /if }>
</body>
</html>