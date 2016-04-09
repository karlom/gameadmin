<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>
	<{$lang->menu->firstGoldUseStatistics}>
</title>
<link rel="stylesheet" href="/static/css/base.css" type="text/css" />
<link rel="stylesheet" href="/static/css/style.css" type="text/css" />
<link rel="stylesheet" href="/static/js/autolist/autolist.css" type="text/css" />
<script type="text/javascript" src="/static/js/jquery.min.js"></script>	
<script type="text/javascript" src="/static/js/My97DatePicker/WdatePicker.js"></script>
<script type="text/javascript" src="/static/js/autolist/autolist.js"></script>
<script type="text/javascript" src="/static/js/sorttable.js"></script>
<script type="text/javascript" src="/static/js/flowtitle.js"></script>
<script type="text/javascript" src="/static/js/colResizable-1.3.min.js"></script>
<script type="text/javascript" src="/static/js/global.js"></script>
</head>

<body>
<div id="position">
<b><{$lang->menu->class->spendData}>：<{$lang->menu->firstGoldUseStatistics }></b>
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
<{*
<div class='divOperation'>
<form id="myform" name="myform" method="get" action="" style="display: inline;">
<{$lang->page->beginTime}>：<input type="text" size="13" class="Wdate" name="start_day" id="start_day" onfocus="WdatePicker({el:'start_day',dateFmt:'yyyy-MM-dd',minDate:'<{$minDate}>',maxDate:'#F{$dp.$D(\'end_day\')}'})" value="<{ $startDay }>">
<{$lang->page->endTime}>：<input type="text" size="13" class="Wdate" name="end_day" id="end_day" onfocus="WdatePicker({el:'end_day',dateFmt:'yyyy-MM-dd',minDate:'#F{$dp.$D(\'start_day\')}',maxDate:'<{$maxDate}>'})"  value="<{ $endDay }>">
&nbsp;<{$lang->player->roleName}>:<input type="text" id="role_name" name="role_name" size="15" value="<{$roleName}>" />
&nbsp;<{$lang->player->accountName}>:<input type="text" id="account_name" name="account_name" size="15" value="<{$accountName}>" />
<input type="hidden" name="search" value="1"/>
<input type="hidden" name="pageSize" value="100"/>
<input type="submit" name='search' value="搜索" class="input2 submitbtn"  />
&nbsp;&nbsp;
</form>
<form id="myform2" name="myform2" method="post" action="<{$current_uri}>" style="display: inline;">
	<input type="submit" class="button submitbtn" name="dateToday" value="<{$lang->page->today}>" >&nbsp;&nbsp;
	<input type="submit" <{if $selectedDay and $selectedDay <= $minDate }> disabled="disabled" <{/if}> class="button submitbtn" name="datePrev" value="<{$lang->page->prevTime}>">&nbsp;&nbsp;
	<input type="submit" <{if $selectedDay and $selectedDay >= $maxDate }> disabled="disabled" <{/if}> class="button submitbtn" name="dateNext" value="<{$lang->page->nextTime}>">&nbsp;&nbsp;
	<input type="submit" class="button submitbtn" name="dateAll" value="<{$lang->page->fromOnlineDate}>" >
	<input type="hidden" class="button" name="selectedDay" value="<{$selectedDay}>" >
	<input type="hidden" id="role_name" name="role_name" size="15" value="<{$roleName}>" />
	<input type="hidden" id="account_name" name="account_name" size="15" value="<{$accountName}>" />
</form>
</div>
*}>
<div>
<{$lang->sys->betweenCountTime}>: <{$lang->page->fromOnlineDate}>
(<{ $startDay }> -> <{ $endDay }>)
</div>
<br class="clear" />
<div class="main-container">
<{if $viewData.data}>
	<table class="DataGrid sortable" cellspacing="0" style="margin-bottom:20px;">
		<caption class="table_list_head">
			<{$lang->menu->firstGoldUseStatistics}>
			<{$lang->page->statistics}>
			<font style="color:#f00;">
			<{if $roleName}>
				<{$roleName}>
			<{else}>
				<{$lang->page->allPlayer}>
			<{/if}>
			</font>
			<{$lang->gold->firstUsageOfGold}>
			
			<{$lang->sys->betweenCountTime}>: 
			
			<{$startTime|date_format:'%Y-%m-%d %H:%M:%S'}>&nbsp;<{$lang->page->to}> &nbsp;<{$endTime|date_format:'%Y-%m-%d %H:%M:%S'}> 
		</caption>
		<tr class="table_list_head" align="center">
			<th width="100"><{$lang->gold->op_id}></th>
			<th width="100"><{$lang->gold->op_type}></th>
			<th width="100" class="gold"><{$lang->gold->used_gold_count}></th>
			<th width="100" class="op_count"><{$lang->gold->op_count}></th>
			<!--<th width="120" class="item_count"><{$lang->gold->actualCount}></th>-->
		</tr>
		<{ if $viewData.data.byType.gold }>
			<!--  Start  元宝消耗-->
			<{assign var=count_of_gold value=0}>
			<{assign var=count_of_bind_gold value=0}>
			<{assign var=count_of_item value=0}>
			<{assign var=count_of_op value=0}>
			<{assign var=rowspan_1 value=$gold_decrease_statistics|@count}>
			
			<{foreach from=$viewData.data.byType.gold item=log name=gold_decrease_statistics_loop }>
		    <tr align="center" <{ if $smarty.foreach.gold_decrease_statistics_loop.index is odd }> class="odd"<{ /if }>>
							<{assign var=count_of_gold value=$count_of_gold+$log.all_gold}>
				<{assign var=count_of_bind_gold value=$count_of_bind_gold+$log.all_bind_gold}>
				<{assign var=count_of_item value=$count_of_item+$log.item_count}>
				<{assign var=count_of_op value=$count_of_op+$log.op_count}>
				<td><{ $log.type }>&nbsp;</td>
				<td><{ $op_type[$log.type] }>&nbsp;</td>
		        <td class="gold"><{ $log.all_gold}>&nbsp;</td>
		        <td class="op_count"><{ $log.op_count}>&nbsp;</td>
		        <!--<td class="item_count"><{ $log.item_count}>&nbsp;</td>-->
			</tr>
			<{/foreach}>
			<tfoot>
			<tr align="center" <{ if $smarty.foreach.gold_decrease_statistics_loop.index is even }> class="odd"<{ /if }> >
				<td colspan="2">-- <{$lang->page->summary }> --</td>
				<td class="gold"><{$count_of_gold}></td>
				<td class="op_count"><{$count_of_op}></td>
				<!--<td class="item_count"><{$count_of_item}></td>-->
			</tr>
			</tfoot>
			<!--  End  元宝消耗-->
		<{/if}>
	</table>
	
	<table class="DataGrid sortable" cellspacing="0" style="margin-bottom:20px;">
		<caption class="table_list_head" align="center">
			<{$lang->gold->itemSalse}>   
			<{$lang->sys->betweenCountTime}>: 
			<{$startTime|date_format:'%Y-%m-%d %H:%M:%S'}>&nbsp;<{$lang->page->to}> &nbsp;<{$endTime|date_format:'%Y-%m-%d %H:%M:%S'}> 
		</caption>
		<tr class="table_list_head" align="center">
			<th width="60"><{$lang->gold->item_id}> </th>
			<th width="90"><{$lang->gold->item_name}></th>
			<th width="100"><{$lang->gold->buy_count}></th>
			<th width="100" class="gold"><{$lang->gold->used_gold_count}></th>
			<th width="100" class="op_count"><{$lang->gold->op_count}></th>
		</tr>
		
			<!--  Start  道具购买统计-->
			<{assign var=count_of_item value=0}>
			<{assign var=count_of_gold value=0}>
			<{assign var=count_of_bind_gold value=0}>
			<{assign var=count_of_op value=0}>
			
			<{foreach from=$viewData.data.byItem.gold item=log name=gold_of_item_statistics_loop }>
		    <tr align="center" <{ if $smarty.foreach.gold_of_item_statistics_loop.index is odd }> class="odd"<{ /if }>>
		    	<{assign var=count_of_item value=$count_of_item+$log.item_count}>
				<{assign var=count_of_gold value=$count_of_gold+$log.all_gold}>
				<{assign var=count_of_bind_gold value=$count_of_bind_gold+$log.all_bind_gold}>
				<{assign var=count_of_op value=$count_of_op+$log.op_count}>
				
				<td><{$log.item_id}></td>
				<td><{ $arrItemsAll[$log.item_id].name }>&nbsp;</td>
				<td><{ $log.item_count }>&nbsp;</td>
		        <td class="gold"><{$log.all_gold}>&nbsp;</td>
		        <td class="op_count"><{ $log.op_count}>&nbsp;</td>
			</tr>
			<{/foreach}>
			<tfoot>
			<tr align="center" <{ if $smarty.foreach.gold_of_item_statistics_loop.index is even }> class="odd"<{ /if }>>
				<td colspan="2">-- <{$lang->page->summary }> --</td>
				<td><{$count_of_item}></td>
				<td class="gold"><{$count_of_gold}></td>
				<td class="op_count"><{$count_of_op}></td>
			</tr>
			</tfoot>
			<!--  End  道具购买统计-->
	</table>
	<{if $viewData.data.byLevel.gold.data|@count}>
<!--	
	<div>
		<span class="hr_red" style=" height:10px" >&nbsp;</span> <{$lang->page->gt}><{$highlightPercentage*100}>%
		<span class="hr_green" style=" height:10px" >&nbsp;</span> <{$lang->page->lt}><{$highlightPercentage*100}>%
	</div>
-->
	<table class="SumDataGrid" style="min-width: 300px;">
	<caption class="table_list_head" align="center">
			<{$startTime|date_format:'%Y-%m-%d %H:%M:%S'}>&nbsp;<{$lang->page->to}> &nbsp;<{$endTime|date_format:'%Y-%m-%d %H:%M:%S'}>
			<font style="color:#f00;">
			<{if $roleName}>
				<{$roleName}>
			<{else}>
				<{$lang->page->allPlayer}>
			<{/if}>
			</font>
			<{$lang->gold->firstUseLevelDistribute}>		
	</caption>
	<!--
	<tr align="center" valign="bottom"  >
		<th valign="middle" width="50"><{$lang->gold->percentage}></th>
		<{assign var=division value=$viewData.data.byLevel.gold.max_men_count*$highlightPercentage}>
		<{foreach from=$viewData.data.byLevel.gold.data item=log name=loop1}>
		<td width="20">
			<{math equation="x*100/y" x=$log.men_count y=$viewData.data.byLevel.gold.total_men_count format="%.2f"}>%
			<{if $log.men_count >= $division }>
				<{assign var=class value='hr_red'}>
			<{else}>
				<{assign var=class value='hr_green'}>
			<{/if}>

			<hr class="<{$class}>" style=" height:<{math equation="(x/y)*120" x=$log.men_count y=$viewData.data.byLevel.gold.max_men_count}>px;" />
		</td>
		<{/foreach}>
	</tr>
	<tr align="center" valign="bottom"  >
		<th valign="middle" width="50"><{$lang->gold->population}></th>
		<{assign var=division value=$viewData.data.byLevel.gold.max_men_count*$highlightPercentage}>
		<{foreach from=$viewData.data.byLevel.gold.data item=log name=loop2}>
		<td width="20">
			<{$log.men_count}>
			<{if $log.men_count >= $division }>
				<{assign var=class value='hr_red'}>
			<{else}>
				<{assign var=class value='hr_green'}>
			<{/if}>

			<hr class="<{$class}>" style=" height:<{math equation="(x/y)*120" x=$log.men_count y=$viewData.data.byLevel.gold.max_men_count}>px;" />
		</td>
		<{/foreach}>
	</tr>
	<tr align="center">
		<th><{$lang->page->level}></th>
		<{foreach from=$viewData.data.byLevel.gold.data item=log key=key name=loop3}>
		<td>
			<span><{$log.level}>
			</span>
		</td>
		<{/foreach}>	
	</tr>
	-->
	<tr align="center">
		<th width="150"><{$lang->page->level}></th>
		<th width="150"><{$lang->gold->first_consume_count}></th>
		<th width="150"><{$lang->gold->money_count}></th>
		<th width="150"><{$lang->gold->population}><{$lang->gold->percentage}></th>
		<th width="150"><{$lang->gold->money}><{$lang->gold->percentage}></th>
	</tr>
	<{ foreach from=$viewData.data.byLevel.gold.data item=log name=loop}>
		<tr align="center" <{ if $smarty.foreach.loop.index is odd }> class="odd"<{ /if }> >
			<td><{$log.level}></td>
			<td><{$log.men_count}></td>
			<td><{$log.all_gold}></td>
			<td><{math equation="(x/y)*100" x=$log.men_count y=$viewData.data.byLevel.gold.total_men_count format="%.2f"}>%</td>
			<td><{math equation="(x/y)*100" x=$log.all_gold y=$viewData.data.byLevel.gold.total_gold_count format="%.2f"}>%</td>
		</tr>
	<{/foreach}>
	<tfoot>
		<tr align="center">
		<td>-- <{$lang->page->summary }> --</td>
		<td><{$lang->gold->total_man}>: <{$viewData.data.byLevel.gold.total_men_count }></td>
		<td><{$lang->gold->total_money}>: <{$viewData.data.byLevel.gold.total_gold_count }></td>
		<td></td>
		<td></td>
		</tr>
	</tfoot>
	</table>
	<{/if}>
<{else}>
<{*<font color='red'><{$lang->page->noData}></font>*}>
<{/if}>
</div>
</body>
</html>
