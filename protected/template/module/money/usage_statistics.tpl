<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset='UTF-8'" />
<link rel="stylesheet" href="/static/css/base.css" type="text/css">
<link rel="stylesheet" href="/static/css/style.css" type="text/css" />
<script type="text/javascript" src="/static/js/jquery.min.js"></script>
<script type="text/javascript" src="/static/js/My97DatePicker/WdatePicker.js"></script>
<script type="text/javascript" src="/static/js/sorttable.js"></script>
<script type="text/javascript" src="/static/js/colResizable-1.3.min.js"></script>
<script type="text/javascript" src="/static/js/global.js"></script>
<title><{$lang->menu->moneyUserAnalyse}></title>
</head>
<script type="text/javascript">
$(document).ready(function(){
	$('table.table_list').css('width', '');
	$('input.filter_display').each(function(){
		$(this).click(function(){
			if($(this).attr('checked'))
				$('.' + $(this).attr('name')).show();
			else
				$('.' + $(this).attr('name')).hide();
		})
	})
})
</script>
<body>

<div id="position"><{$lang->menu->class->spendData}>：<{$lang->menu->moneyUserAnalyse}></div>

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
	<form action="?action=search" id="frm" method="GET"  style="display:inline;">
		<table cellspacing="1" cellpadding="5" class="SumDataGrid" width="900">
			<tr>
				<td>
					<{$lang->page->beginTime}>:<input id='starttime' name='starttime' type="text" class="Wdate" onfocus="WdatePicker({el:'starttime',dateFmt:'yyyy-MM-dd',minDate:'<{$minDate}>',maxDate:'#F{$dp.$D(\'endtime\')}'})" size='12' value='<{$startTime|date_format:'%Y-%m-%d' }>' /> 
				</td>
				<td>
					<{$lang->page->endTime}>:<input id='endtime' name='endtime' type="text" class="Wdate" onfocus="WdatePicker({el:'endtime',dateFmt:'yyyy-MM-dd',minDate:'#F{$dp.$D(\'starttime\')}',maxDate:'<{$maxDate}>'})" size='12' value='<{$endTime|date_format:'%Y-%m-%d'}>' /> 
				</td>
				<td align="right"><{$lang->page->roleName}>：</td>
				<td><input type="text" name="role[role_name]" id="role_name" value="<{$role.role_name}>" /></td>
				<td align="right"><{$lang->page->accountName}>：</td>
				<td><input type="text" name="role[account_name]" id="account_name" value="<{$role.account_name}>" /></td>
				<td width="100px"><input type="submit" name='search' value="搜索" class="input2 submitbtn"  /></td>
			</tr>
		</table>
	</form>
</td>
<td>
	<form action="?action=search"  method="GET"  style="display:inline;">
	<table cellspacing="1" cellpadding="5" class="SumDataGrid" width="300">
			<tr>
				<td>
					<input type="submit" name="today" id="today" class="submitbtn" value="<{$lang->page->today}>" />
					<input type="submit" name="preday" id="preday" class="submitbtn" value="<{$lang->page->preday}>" />
					<input type="hidden" name="lookingday" id="lookingday" class="submitbtn" value="<{$lookingDay}>" />
					<input type="submit" name="nextday" id="nextday" class="submitbtn" value="<{$lang->page->afterday}>" />
					<input type="submit" name="showAll" id="showAll" class="submitbtn" value="<{$lang->page->allTime}>" />
				</td>
			</tr>
		</table>
	</form>
</td>
</tr>
</table>
<div>
<label><input type="checkbox" name="all_money" class="filter_display" checked="checked" /><{$lang->money->all_money}></label>
<label><input type="checkbox" name="bind_money" class="filter_display" checked="checked" /><{$lang->money->bind_money}></label>
<label><input type="checkbox" name="money" class="filter_display" checked="checked" /><{$lang->money->money}></label>
<label><input type="checkbox" name="op_count" class="filter_display" checked="checked" /><{$lang->money->op_count}></label>
</div>
<font color="blue"><b><{$lang->gold->attention}></b></font>
<!-- End 账号和角色名搜索  -->
<div class="main-container">
<{ if $money_decrease_statistics || $money_increase_statistics}>
	<table class="DataGrid sortable" cellspacing="0" style="margin-bottom:20px;">
		<caption class="table_list_head">
			<{$lang->menu->moneyUserAnalyse}>   
			<{$lang->page->statistics}>
			<font style="color:#f00;">
			<{if $showName}>
				<{$showName}>
			<{else}>
				<{$lang->page->allPlayer}>
			<{/if}>
			</font>
			<{$lang->money->usageOfmoney}>
			<font style="color:#f00;">(<{$lang->money->money_decrease}>)</font>
			<{$lang->sys->betweenCountTime}>: 
			
			<{$startTime|date_format:'%Y-%m-%d %H:%M:%S'}>&nbsp;<{$lang->page->to}> &nbsp;<{$endTime|date_format:'%Y-%m-%d %H:%M:%S'}> 
		</caption>
		<tr class="table_list_head" align="center">
			<th width="150"><{$lang->money->op_id}></th>
			<th width="100"><{$lang->money->op_type}></th>
			<th width="100" class="all_money"><{$lang->money->all_money}></th>
			<th width="100" class="bind_money"><{$lang->money->bind_money}></th>
			<th width="100" class="money"><{$lang->money->money}></th>
			<th width="100" class="op_count"><{$lang->money->op_count}></th>
		</tr>
		<{ if $money_decrease_statistics }>
			<!--  Start  元宝消耗-->
			<{assign var=count_of_money value=0}>
			<{assign var=count_of_bind_money value=0}>
			<{assign var=count_of_op value=0}>
			<{assign var=rowspan_1 value=$money_decrease_statistics|@count}>
			
			<{foreach from=$money_decrease_statistics item=log name=money_decrease_statistics_loop }>
		    <tr align="center" <{ if $smarty.foreach.money_decrease_statistics_loop.index is odd }> class="odd"<{ /if }>>
			<{*
				<{ if $smarty.foreach.money_decrease_statistics_loop.first }>
					<td rowspan="<{math equation="x+2" x=$rowspan_1}>" width="20px" style="writing-mode=tb-rl; ">
						<{$lang->money->money_decrease}>
					</td>
				<{ /if }>
				*}>
				<{assign var=count_of_money value=$count_of_money+$log.all_money}>
				<{assign var=count_of_bind_money value=$count_of_bind_money+$log.all_bind_money}>
				<{assign var=count_of_op value=$count_of_op+$log.op_count}>
				<td><{ $log.type }>&nbsp;</td>
				<td><{ $op_type[$log.type] }>&nbsp;</td>
				<td class="all_money" sorttable_customkey="<{$log.all_money+$log.all_bind_money}>"><{ $log.all_money+$log.all_bind_money}>&nbsp;(<{$log.all_pecentage}>%)</td>
				<td class="bind_money" sorttable_customkey="<{$log.all_bind_money}>"><{ $log.all_bind_money}>&nbsp;(<{$log.bind_money_pecentage}>%)</td>
		        <td class="money" sorttable_customkey="<{$log.all_money}>"><{ $log.all_money}>&nbsp;(<{$log.money_pecentage}>%)</td>
		        <td class="op_count"><{$log.op_count}>&nbsp;</td>
			</tr>
			<{/foreach}>
			<tfoot>
			<tr align="center" <{ if $smarty.foreach.money_decrease_statistics_loop.index is even }> class="odd"<{ /if }> >
				<td colspan="2">-- <{$lang->page->summary }> --</td>
				<td class="all_money"><{$count_of_bind_money+$count_of_money}>&nbsp;</td>
				<td class="bind_money"><{$count_of_bind_money}>&nbsp;</td>
				<td class="money"><{$count_of_money}>&nbsp;</td>
				<td class="op_count"><{$count_of_op}></td>
			</tr>
			</tfoot>
			<!--  End  元宝消耗-->
		<{/if}>

		</table>
		
	<{ if $money_increase_statistics }>
	<table class="DataGrid sortable" cellspacing="0" style="margin-bottom:20px;">
		<caption class="table_list_head">
			<{$lang->menu->moneyUserAnalyse}>   
			<{$lang->page->statistics}>
			<font style="color:#f00;">
			<{if $showName}>
				<{$showName}>
			<{else}>
				<{$lang->page->allPlayer}>
			<{/if}>
			</font>
			<{$lang->money->usageOfmoney}>
			<font style="color:#f00;">(<{$lang->money->money_increase}>)</font>
			<{$lang->sys->betweenCountTime}>: 
			
			<{$startTime|date_format:'%Y-%m-%d %H:%M:%S'}>&nbsp;<{$lang->page->to}> &nbsp;<{$endTime|date_format:'%Y-%m-%d %H:%M:%S'}> 
		</caption>
		<tr class="table_list_head" align="center">
			<th width="150"><{$lang->money->op_id}></th>
			<th width="100"><{$lang->money->op_type}></th>
			<th width="100" class="all_money"><{$lang->money->all_money}></th>
			<th width="100" class="bind_money"><{$lang->money->bind_money}></th>
			<th width="100" class="money"><{$lang->money->money}></th>
			<th width="100" class="op_count"><{$lang->money->op_count}></th>
		</tr>

			<!--  Start  元宝新增-->
			<{assign var=count_of_money value=0}>
			<{assign var=count_of_bind_money value=0}>
			<{assign var=count_of_op value=0}>
			<{assign var=rowspan_1 value=$money_increase_statistics|@count}>
			
			<{foreach from=$money_increase_statistics item=log name=money_increase_statistics_loop }>
		    <tr align="center" <{ if $smarty.foreach.money_increase_statistics_loop.index is odd }> class="odd"<{ /if }>>
			<{*
				<{ if $smarty.foreach.money_increase_statistics_loop.first }>
					<td rowspan="<{math equation="x+2" x=$rowspan_1}>" width="20px" style="writing-mode=tb-rl; ">
						<{$lang->money->money_increase}>
					</td>
				<{ /if }>
				*}>
				<{assign var=count_of_money value=$count_of_money+$log.all_money}>
				<{assign var=count_of_bind_money value=$count_of_bind_money+$log.all_bind_money}>
				<{assign var=count_of_op value=$count_of_op+$log.op_count}>
				<td><{ $log.type}>&nbsp;</td>
				<td><{ $op_type[$log.type] }>&nbsp;</td>
				<td class="all_money" sorttable_customkey="<{$log.all_money+$log.all_bind_money}>"><{math equation="-x" x=$log.all_money+$log.all_bind_money}>&nbsp;(<{$log.all_pecentage}>%)</td>
				<td class="bind_money" sorttable_customkey="<{$log.all_bind_money}>"><{if $log.all_bind_money>0}><{math equation="-x" x=$log.all_bind_money}><{else}>0<{/if}>&nbsp;(<{$log.bind_money_pecentage}>%)</td>
		        <td class="money" sorttable_customkey="<{$log.all_money}>"><{if $log.all_money>0}><{math equation="-x" x=$log.all_money}><{else}>0<{/if}>&nbsp;(<{$log.money_pecentage}>%)</td>
		        <td class="op_count"><{ $log.op_count}>&nbsp;</td>
			</tr>
			<{/foreach}>
			<tfoot>
			<tr align="center" <{ if $smarty.foreach.money_increase_statistics_loop.index is even }> class="odd"<{ /if }>>
				<td colspan="2">-- <{$lang->page->summary }> --</td>
				<td class="all_money"><{if $count_of_bind_money>0 || $count_of_money>0}><{math equation="-x" x=$count_of_bind_money+$count_of_money}><{else}>0<{/if}>&nbsp;</td>
				<td class="bind_money"><{if $count_of_bind_money>0}><{math equation="-x" x=$count_of_bind_money}><{else}>0<{/if}>&nbsp;</td>
				<td class="money"><{if $count_of_money>0}><{math equation="-x" x=$count_of_money}><{else}>0<{/if}>&nbsp;</td>
				<td class="op_count"><{$count_of_op}></td>
			</tr>
			</tfoot>
			<!--  End  元宝新增-->
		<{/if}>
	</table>
	

<{ else }>
	<div><{$lang->page->noData}></div>
<{ /if }>

<{if $money_of_item_statistics}>
<table class="DataGrid sortable" cellspacing="0" style="margin-bottom:20px;">
		<caption class="table_list_head" align="center">
			<{$lang->money->itemSalse}>   
			<{$lang->sys->betweenCountTime}>: 
			<{$startTime|date_format:'%Y-%m-%d %H:%M:%S'}>&nbsp;<{$lang->page->to}> &nbsp;<{$endTime|date_format:'%Y-%m-%d %H:%M:%S'}> 
		</caption>
		<tr class="table_list_head" align="center">
			<th width="150"><{$lang->money->item_id}> | <{$lang->money->item_name}></th>
			<th width="100"><{$lang->money->item_count}></th>
			<th width="100" class="all_money"><{$lang->money->all_money}></th>
			<th width="100" class="bind_money"><{$lang->money->bind_money}></th>
			<th width="100" class="money"><{$lang->money->money}></th>
			<th width="100" class="op_count"><{$lang->money->op_count}></th>
		</tr>
		
			<!--  Start  道具购买统计-->
			<{assign var=count_of_item value=0}>
			<{assign var=count_of_money value=0}>
			<{assign var=count_of_bind_money value=0}>
			<{assign var=count_of_op value=0}>
			
			<{foreach from=$money_of_item_statistics item=log name=money_of_item_statistics_loop }>
		    <tr align="center" <{ if $smarty.foreach.money_of_item_statistics_loop.index is odd }> class="odd"<{ /if }>>
		    	<{assign var=count_of_item value=$count_of_item+$log.item_count}>
				<{assign var=count_of_money value=$count_of_money+$log.all_money}>
				<{assign var=count_of_bind_money value=$count_of_bind_money+$log.all_bind_money}>
				<{assign var=count_of_op value=$count_of_op+$log.op_count}>
				
				<td><{$log.item_id}> | <{ $arrItemsAll[$log.item_id].name }>&nbsp;</td>
				<td><{ $log.item_count }>&nbsp;</td>
				<td class="all_money" sorttable_customkey="<{$log.all_money+$log.all_bind_money}>"><{$log.all_money+$log.all_bind_money}>&nbsp;(<{$log.all_pecentage}>%)</td>
				<td class="bind_money" sorttable_customkey="<{$log.all_bind_money}>">
					<{$log.all_bind_money}>&nbsp;(<{$log.bind_money_pecentage}>%)
				</td>
		        <td class="money" sorttable_customkey="<{$log.all_money}>">
					<{$log.all_money}>&nbsp;(<{$log.money_pecentage}>%)
				</td>
		        <td class="op_count"><{ $log.op_count}>&nbsp;</td>
			</tr>
			<{/foreach}>
			<tfoot>
			<tr align="center" <{ if $smarty.foreach.money_of_item_statistics_loop.index is even }> class="odd"<{ /if }>>
				<td>-- <{$lang->page->summary }> --</td>
				<td><{$count_of_item}></td>
				<td class="all_money"><{$count_of_bind_money+$count_of_money}>&nbsp;</td>
				<td class="bind_money"><{$count_of_bind_money}>&nbsp;</td>
				<td class="money"><{$count_of_money}>&nbsp;</td>
				<td class="op_count"><{$count_of_op}></td>
			</tr>
			</tfoot>
			<!--  End  道具购买统计-->
</table>
<{/if}>
</div>
</body>
</html>
