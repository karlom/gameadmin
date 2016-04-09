<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset='UTF-8'" />
<link rel="stylesheet" href="/static/css/base.css" type="text/css" />
<link rel="stylesheet" href="/static/css/style.css" type="text/css" />
<link rel="stylesheet" href="/static/js/autolist/autolist.css" type="text/css" />
<script type="text/javascript" src="/static/js/jquery.min.js"></script>
<script type="text/javascript" src="/static/js/My97DatePicker/WdatePicker.js"></script>
<script type="text/javascript" src="/static/js/autolist/autolist.js"></script>
<script type="text/javascript" src="/static/js/global.js"></script>
<title><{$lang->menu->goldConsumeChartsByHour}></title>
<script type="text/javascript">
$(document).ready(function(){
	$.autolist({
		bind: 'consumption_type_widget',
		options: <{$consumptionType|@json_encode}>,
		onItemClick: function(key, item){
			$('#consumption_type_widget').val(item.text());
			$('#consumption_type').val(key);
		},
		onReset: function(){
			$('#consumption_type').val('');
		}
	});
})
</script>
</head>
<body>


<!-- 
<div id="position"><{$lang->menu->class->spendData}>：<{$lang->menu->goldConsumeChartsByHour}></div>
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
<!-- Start 账号和角色名搜索  -->
<table>
<tr>
<td>
	<form action="?action=search" id="frm" method="get"  style="display:inline;">
		<table cellspacing="1" cellpadding="5" class="SumDataGrid" width="900">
			<tr>
				<td>
					<{$lang->page->beginTime}>:<input id='starttime' name='starttime' type="text" class="Wdate" onfocus="WdatePicker({el:'starttime',dateFmt:'yyyy-MM-dd',minDate:'<{$minDate}>',maxDate:'#F{$dp.$D(\'endtime\')}'})" size='12' value='<{$startTime|date_format:'%Y-%m-%d' }>' /> 
				</td>
				<td>
					<{$lang->page->endTime}>:<input id='endtime' name='endtime' type="text" class="Wdate" onfocus="WdatePicker({el:'endtime',dateFmt:'yyyy-MM-dd',minDate:'#F{$dp.$D(\'starttime\')}',maxDate:'<{$maxDate}>'})" size='12' value='<{$endTime|date_format:'%Y-%m-%d'}>' /> 
				</td>
				<td>
					<{$lang->gold->gold_type}>：<{html_options options=$dictGoldType selected=$selectGoldType name='select_gold_type'}>
				</td>
				<td>
					<{$lang->gold->consumption_type}>:<input id='consumption_type_widget' name='consumption_type_widget' type="text" size='30' value='<{if $selectConsumptionType > 0}><{$selectConsumptionType}> | <{$consumptionType[$selectConsumptionType]}><{/if}>' /> 
					<input id='consumption_type' name='consumption_type' type="hidden" size='12' value='<{$selectConsumptionType}>' /> 
				</td>
				<td width="100px"><input type="submit" name='search' value="搜索" class="input2 submitbtn"  /></td>
			</tr>
		</table>
	</form>
</td>

</tr>
</table>
<br />
<!-- End 账号和角色名搜索  -->

<{if $player_statistics}>
<div>
	<span class="hr_red" style=" height:10px" >&nbsp;</span> <{$lang->page->gt}><{$highlightPercentage*100}>%
	<span class="hr_green" style=" height:10px" >&nbsp;</span> <{$lang->page->lt}><{$highlightPercentage*100}>%
</div>
<{assign var=minWidth value=1000}>
<!-- Start 元宝日消耗  -->
<table class="SumDataGrid" >
	<tr align="center">
		<th colspan="<{math equation="x+1" x=$countOfDays}>">
			<{$startTime|date_format:"%Y-%m-%d"}> - <{$endTime|date_format:"%Y-%m-%d"}>  
			[<span style="color:#f00;"><{$dictGoldType[$selectGoldType]}></span>]<{$lang->gold->dailyConsumptionGraph}>  
			<{$lang->gold->consumption_type}> ： [<span style="color:#f00;"><{if $selectConsumptionType > 0}><{ $consumptionType[$selectConsumptionType]}><{else}><{$lang->page->unlimited}><{/if}></span>]
		</th>
	</tr>
	<tr align="center" valign="bottom"  >
		<th valign="middle" width="50"><{$lang->gold->population}></th>
		<{assign var=division value=$top_men_count*$highlightPercentage}>
		<{foreach from=$player_statistics item=log name=player_statistics_loop}>
		<td width="20">
			<{$log.men_count}>
			<{if $log.men_count >= $division }>
				<{assign var=class value='hr_red'}>
			<{else}>
				<{assign var=class value='hr_green'}>
			<{/if}>

			<hr class="<{$class}>" style=" height:<{math equation="(x/y)*120" x=$log.men_count y=$top_men_count}>px;" />
		</td>
		<{/foreach}>
	</tr>
	<tr align="center" valign="bottom"  >
		<th valign="middle"><{$lang->gold->gold_decrease}></th>
		<{assign var=division value=$top_gold_count*$highlightPercentage}>
		<{foreach from=$player_statistics item=log name=player_statistics_loop_2}>
		<td>
			<{$log.cost}>
			<{if $log.cost >= $division}>
				<{assign var=class value='hr_red'}>
			<{else}>
				<{assign var=class value='hr_green'}>
			<{/if}>

			<hr class="<{$class}>" style=" height:<{math equation="(x/y)*120" x=$log.cost y=$top_gold_count}>px;" />
		</td>
		<{/foreach}>
	</tr>
	<tr align="center">
		<th><{$lang->page->date}><br/><{$lang->page->onlineDays}></th>
		<{foreach from=$player_statistics item=log key=key name=player_statistics_loop_2}>
		<td>
			<{if $log.weekday == 0 }>
				<{assign var=class value='red'}>
			<{else}>
				<{assign var=class value=''}>
			<{/if}>
			<span class="<{$class}>"><{$log.mtime|date_format:"%m-%d"}> 
				<{if $log.weekday == 0 }><br /><{$lang->page->sunday}> <{/if}>
			<br/>(<{$key}>)
			</span>
		</td>
		<{/foreach}>	
	</tr>
</table>
<!-- End 元宝日消耗  -->
<{ else }>
	<div><{$lang->page->noData}></div>
<{ /if }>
<br />

<{if $logByHourResult}>
<!-- Start 元宝时消耗  -->
<table class="SumDataGrid">
	<tr align="center">
		<th colspan="25">
			<{$startTime|date_format:"%Y-%m-%d"}> - <{$endTime|date_format:"%Y-%m-%d"}>  
			[<span style="color:#f00;"><{$dictGoldType[$selectGoldType]}></span>]<{$lang->gold->hourConsumptionGraph}>  
			<{$lang->gold->consumption_type}> ： [<span style="color:#f00;"><{if $selectConsumptionType > 0}><{ $consumptionType[$selectConsumptionType]}><{else}><{$lang->page->unlimited}><{/if}></span>]
		</th>
	</tr>
	<tr align="center" valign="bottom">
		<th valign="middle" width="50"><{$lang->gold->gold_decrease}></th>
		<{assign var=division value=$topCostByHourResult*$highlightPercentage}>
		<{foreach from=$logByHourResult item=log}>
		<td width="20">
			<{$log}>
			<{if $log >= $division }>
				<{assign var=class value='hr_red'}>
			<{else}>
				<{assign var=class value='hr_green'}>
			<{/if}>

			<hr class="<{$class}>" style=" height:<{math equation="(x/y)*120" x=$log y=$topCostByHourResult}>px;" />
		</td>
		<{/foreach}>
	</tr>
	<tr align="center">
		<th><{$lang->page->time}></th>
		<{foreach from=$logByHourResult item=log key=key}>
		<td>
			<{$key}>
		</td>
		<{/foreach}>	
	</tr>
</table>
<!-- End 元宝时消耗  -->
<{ else }>
	<div><{$lang->page->noData}></div>
<{ /if }>
<br />

<{if $logByDayHourResult}>
<!-- Start 元宝每日时消耗  -->
<table class="SumDataGrid" style="min-width:<{$minWidth}>px;">
	<tr align="center">
		<th colspan="26">
			<{$startTime|date_format:"%Y-%m-%d"}> - <{$endTime|date_format:"%Y-%m-%d"}>  
			[<span style="color:#f00;"><{$dictGoldType[$selectGoldType]}></span>]<{$lang->gold->dailyHourConsumptionGraph}>  
			<{$lang->gold->consumption_type}> ： [<span style="color:#f00;"><{if $selectConsumptionType > 0}><{ $consumptionType[$selectConsumptionType]}><{else}><{$lang->page->unlimited}><{/if}></span>]
		</th>
	</tr>
	<{foreach from=$logByDayHourResult item=log key=sinceOpenDay name=logByDayHourResult_loop}>
	<tr align="center" valign="bottom"  height="148" <{ if $smarty.foreach.logByDayHourResult_loop.index is odd }> class="odd"<{ /if }>>
		<th valign="middle" rowspan="2" width="80">
			<{if $log.weekday == 0 }>
				<{assign var=class value='red'}>
			<{else}>
				<{assign var=class value=''}>
			<{/if}>
			<span class="<{$class}>"><{$log.mtime|date_format:"%Y-%m-%d"}> 
				<{if $log.weekday == 0 }><br /><{$lang->page->sunday}> <{/if}>
			<br/>
			<{$lang->page->onlineDays}>: <{$sinceOpenDay}>
			</span>
			
		</th>
		<th valign="middle" width="64" ><{$lang->gold->gold_decrease}></th>
		<{assign var=division value=$log.max*$highlightPercentage}>
		<{foreach from=$log.data item=cost}>
		<td width="28">
			<{$cost.cost}>
			<{if $cost.cost >= $division }>
				<{assign var=class value='hr_red'}>
			<{else}>
				<{assign var=class value='hr_green'}>
			<{/if}>

			<hr class="<{$class}>" style=" height:<{math equation="(x/y)*120" x=$cost.cost y=$log.max}>px;" />
		</td>
		<{/foreach}>
	</tr>
	<tr align="center" <{ if $smarty.foreach.logByDayHourResult_loop.index is odd }> class="odd"<{ /if }>>
		<th>时间</th>
		<{foreach from=$log.data item=log key=key}>
		<td>
			<{$key}>
		</td>	
		<{/foreach}>
	</tr>
	<{/foreach}>
</table>
<!-- End 元宝每日时消耗  -->
<{ else }>
	<div><{$lang->page->noData}></div>
<{ /if }>
</body>
</html>