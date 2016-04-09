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
<title><{$lang->menu->AllgoldUserAnalyse}></title>
</head>

<style type='text/css'>
.total, .gold, .bind_gold { color: #5D8AFF; font-weight:bolder; }
</style>

<script type="text/javascript">
var row_group = <{$rowGroupJson}>;

var update_summary = function(){
	$('.table_list').each(function(){
		var table = $(this);
		table.find('tfoot td').each(function(){
			if ($(this).attr('class') != ''){
				var sum = 0;
				table.find('tbody .' + $(this).attr('class')).each(function(){
					if( $(this).parents('tr').css('display') != 'none' ){
						sum += parseInt($(this).text());
					}
				});
				$(this).text(sum);
			}
		});
	});
}

var update_summary_pecentage = function(){
	$('.table_list').each(function(){
		var table = $(this);
		var total = 0;
		table.find('tfoot td.gold, tfoot td.bind_gold').each(function(){
			total += parseInt($(this).text());
		});
		if(total === 0){
			table.find('tfoot td.gold, tfoot td.bind_gold').each(function(){
				$(this).text( $(this).text() + '(0%)');
			});
		}else{
			table.find('tfoot td.gold, tfoot td.bind_gold').each(function(){
				$(this).text( $(this).text() + '(' + Math.round( parseFloat($(this).text()) * 100 / total ).toFixed(2) + '%)');
			});
		}
	})
}
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

	$('input.filter_row').each(function(){
		$(this).click(function(){
			if($(this).attr('checked')){
				var a = $(this).attr('id').split('_');
				if(a[1] == 'all'){
					$('.row').show();
				}else{
					var idList = row_group[ a[1] ].idList;
					$('.row').hide();
					$(idList).show();
				}
			}
			update_summary();
			update_summary_pecentage();
		})
	})
	update_summary_pecentage();
})
</script>
<body>

<div id="position"><{$lang->menu->class->spendData}>：<{$lang->menu->AllgoldUserAnalyse}></div>

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
		<{$lang->page->beginTime}>:<input id='starttime' name='starttime' type="text" class="Wdate" onfocus="WdatePicker({el:'starttime',dateFmt:'yyyy-MM-dd',minDate:'<{$minDate}>',maxDate:'#F{$dp.$D(\'endtime\')}'})" size='12' value='<{$startTime|date_format:'%Y-%m-%d' }>' /> 
		<{$lang->page->endTime}>:<input id='endtime' name='endtime' type="text" class="Wdate" onfocus="WdatePicker({el:'endtime',dateFmt:'yyyy-MM-dd',minDate:'#F{$dp.$D(\'starttime\')}',maxDate:'<{$maxDate}>'})" size='12' value='<{$endTime|date_format:'%Y-%m-%d'}>' /> 
		<{$lang->page->roleName}>：<input type="text" name="role[role_name]" id="role_name" value="<{$role.role_name}>" />
		<{$lang->page->accountName}>：
		<input type="text" name="role[account_name]" id="account_name" value="<{$role.account_name}>" />
	<{*	<label><input type="checkbox" name="dec_send_gold" <{if 1 == $dec_send_gold}>checked<{/if}> /><{$lang->gold->dec_send_gold}></label>
	*}>
		<input type="submit" name='search' value="搜索" class="input2 submitbtn"  />
	</form>
</td>
<td>
	<form action="?action=search"  method="GET"  style="display:inline;">
		<input type="submit" name="today" id="today" class="submitbtn" value="<{$lang->page->today}>" />
		<input type="submit" name="preday" id="preday" class="submitbtn" value="<{$lang->page->preday}>" />
		<input type="hidden" name="lookingday" id="lookingday" class="submitbtn" value="<{$lookingDay}>" />
		<input type="submit" name="nextday" id="nextday" class="submitbtn" value="<{$lang->page->afterday}>" />
		<input type="submit" name="showAll" id="showAll" class="submitbtn" value="<{$lang->page->allTime}>" />
	</form>
</td>
</tr>
</table>
<!-- 
<div>
<fieldset>
<legend>列过滤</legend>
<label><input type="checkbox" name="col_gold" class="filter_display" checked="checked" /><{$lang->gold->gold}></label>
<label><input type="checkbox" name="col_liquan" class="filter_display" checked="checked" /><{$lang->gold->liquan}></label>
<label><input type="checkbox" name="col_op_count" class="filter_display" checked="checked" /><{$lang->gold->op_count}></label>
</fieldset>
<br />

<fieldset>
<legend>大类过滤</legend>
<label><input id="filter_all" type="radio" name="filter_row" class="filter_row" checked="checked" />全部</label>
<{foreach from=$rowGroup item=filter key=filter_key name=row_filter_loop }>
	<label><input id="filter_<{$filter_key}>" type="radio" name="filter_row" class="filter_row" /><{$filter.name}></label>
<{/foreach}>
</fieldset>
</div>
-->
<!-- End 账号和角色名搜索  -->
</br>
<font color="blue"><b><{$lang->gold->attention}></b></font>
<div class="main-container">

<{if $gold_of_item_statistics}>
<table class="DataGrid sortable table_list" cellspacing="0" style="margin-bottom:20px;">
		<caption class="table_list_head" align="center">
			<{$lang->gold->itemSalse}>   
			<{$lang->sys->betweenCountTime}>: 
			<{$startTime|date_format:'%Y-%m-%d %H:%M:%S'}>&nbsp;<{$lang->page->to}> &nbsp;<{$endTime|date_format:'%Y-%m-%d %H:%M:%S'}> 
		</caption>
		<thead>
		<tr class="table_list_head" align="center">
			<th width="70"><{$lang->gold->item_id}> </td>
			<td width="100"> <{$lang->gold->item_name}></th>
			<th width="100"><{$lang->gold->sold_count}></th>
			<th width="100" class="col_gold"><{$lang->gold->totalUseGold}></th>
			<th width="80" ><{$lang->page->percentage}></th>
			<th width="100" class="col_liquan"><{$lang->gold->totalUseLiquan}></th>
			<th width="80" ><{$lang->page->percentage}></th>
		</tr>
		</thead>
		<tbody>
			<!--  Start  道具购买统计-->
			<{assign var=count_of_item value=0}>
			<{assign var=count_of_gold value=0}>
			<{assign var=count_of_liquan value=0}>
			
			<{foreach from=$gold_of_item_statistics item=log name=gold_of_item_statistics_loop }>
		    <tr id="<{$log.item_id}>" align="center" class="row <{cycle values="trEven,trOdd"}> <{$log.item_id}> <{$log.type}>">
		    	<{assign var=count_of_item value=$count_of_item+$log.item_count}>
				<{assign var=count_of_gold value=$count_of_gold+$log.all_gold}>
				<{assign var=count_of_liquan value=$count_of_liquan+$log.all_liquan}>
				
				<td><{$log.item_id}> </td>
				<td> <{ $arrItemsAll[$log.item_id].name }>&nbsp;</td>
				<td class="item_count"><{ $log.item_count }>&nbsp;</td>
				<td class="col_all_gold"><span class="total"><{ if $log.all_gold}><{$log.all_gold}><{else}>0<{/if}></span></td>
				<td><{ $log.gold_pecentage }>%</td>
				<td class="col_all_liquan"><span class="total"><{ if $log.all_liquan}><{$log.all_liquan}><{else}>0<{/if}></span></td>
				<td><{ $log.liquan_pecentage }>%</td>
			</tr>
		
			<{/foreach}>
		</tbody>
		<tfoot>
			<tr align="center" <{ if $smarty.foreach.gold_of_item_statistics_loop.index is even }> class="odd"<{ /if }>>
				<td colspan="2">-- <{$lang->page->summary }> --</td>
				<td class="item_count"><{$count_of_item}></td>
				<td class="col_all_gold"><{$count_of_gold}></td>
				<td></td>
				<td class="col_all_liquan"><{$count_of_liquan}></td>
				<td></td>
			</tr>
		</tfoot>
			<!--  End  道具购买统计-->
</table>
<{/if}>
</div>
</body>
</html>
