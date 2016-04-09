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
<title><{$lang->menu->qdUseAnalyse}></title>
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

<div id="position"><{$lang->menu->class->spendData}>：<{$lang->menu->qdUseAnalyse}></div>

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
		<{$lang->page->beginTime}>:<input id='startdate' name='startdate' type="text" class="Wdate" onfocus="WdatePicker({el:'startdate',dateFmt:'yyyy-MM-dd',minDate:'<{$minDate}>',maxDate:'#F{$dp.$D(\'enddate\')}'})" size='12' value='<{$startDate}>' /> 
		<{$lang->page->endTime}>:<input id='enddate' name='enddate' type="text" class="Wdate" onfocus="WdatePicker({el:'enddate',dateFmt:'yyyy-MM-dd',minDate:'#F{$dp.$D(\'startdate\')}',maxDate:'<{$maxDate}>'})" size='12' value='<{$endDate}>' /> 
		<{$lang->page->roleName}>：<input type="text" name="role_name" id="role_name" value="<{$role_name}>" />
		<{$lang->page->accountName}>：
		<input type="text" name="account_name" id="account_name" value="<{$raccount_name}>" />

		<input type="submit" name='search' value="搜索" class="input2 submitbtn"  />
	</form>
</td>
<td>
	<form action="?action=search"  method="GET"  style="display:inline;">
		<input type="submit" name="today" id="today" class="submitbtn" value="<{$lang->page->today}>" />
		<input type="submit" name="preday" id="preday" class="submitbtn" value="<{$lang->page->preday}>" />
		<input type="hidden" name="lookingday" id="lookingday" class="submitbtn" value="<{$lookingday}>" />
		<input type="submit" name="nextday" id="nextday" class="submitbtn" value="<{$lang->page->afterday}>" />
		<input type="submit" name="showAll" id="showAll" class="submitbtn" value="<{$lang->page->allTime}>" />
	</form>
</td>
</tr>
</table>

<!-- End 账号和角色名搜索  -->
</br>
<{*
<font color="blue"><b><{$lang->gold->attention}></b></font>
*}>
<div class="main-container">


<table class="DataGrid sortable table_list" cellspacing="0" style="margin-bottom:20px;">
		<caption class="table_list_head" align="center">
			<{$lang->pay->qdBuyItems}>   
			<{$lang->sys->betweenCountTime}>: 
			<{$startDate}>&nbsp;<{$lang->page->to}> &nbsp;<{$endDate}> 
		</caption>
		<{if $viewData}>
		<thead>
		<tr class="table_list_head" align="center">
			<th width="70"><{$lang->gold->item_id}> </td>
			<td width="100"> <{$lang->gold->item_name}></th>
			<th width="100"><{$lang->gold->sold_count}></th>
			<th width="100" class="col_gold"><{$lang->pay->allUse}></th>
			<th width="80" ><{$lang->page->percentage}></th>
			<th width="100" class="col_gold_op_count"><{$lang->pay->operaTimes}></th>
		</tr>
		</thead>
		<tbody>
			
			<{foreach from=$viewData item=log name=loop }>
		    <tr id="<{$log.item_id}>" align="center" class="row <{cycle values="trEven,trOdd"}> <{$log.item_id}> <{$log.type}>">
				
				<td><{$log.item_id}> </td>
				<td> <{ $arrItemsAll[$log.item_id].name }>&nbsp;</td>
				<td class="item_count"><{ $log.item_cnt }>&nbsp;</td>
				<td class="col_all_gold"><span class="total"><{ if $log.total_cost}><{$log.total_cost}><{else}>0<{/if}></span></td>
				<td><{ $log.perc }>%</td>
				<td class="col_gold_op_count"><{ if $log.op_cnt}><{ $log.op_cnt}><{else}>0<{/if}>&nbsp;</td>
			</tr>
		
			<{/foreach}>
		</tbody>
		<tfoot>
			<tr align="center" <{ if $smarty.foreach.loop.index is even }> class="odd"<{ /if }> >
				<td colspan="2">-- <{$lang->page->summary }> --</td>
				<td ><{$allItemCount}></td>
				<td ><{$allCost}></td>
				<td></td>
				<td ><{$allOpCost}></td>
			</tr>
		</tfoot>
		<{else}>
		<tr><td><{$lang->page->noData}></td></tr>
		<{/if}>
			<!--  End  道具购买统计-->
</table>
</div>
</body>
</html>
