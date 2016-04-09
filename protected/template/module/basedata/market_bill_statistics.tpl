<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>
	<{$lang->menu->marketBillStatistics}>
</title>
<link rel="stylesheet" href="/static/css/base.css" type="text/css">
<link rel="stylesheet" href="/static/css/style.css" type="text/css">
<link rel="stylesheet" href="/static/js/autolist/autolist.css" type="text/css" />
<script type="text/javascript" src="/static/js/jquery.min.js"></script>	
<script type="text/javascript" src="/static/js/My97DatePicker/WdatePicker.js"></script>
<script type="text/javascript" src="/static/js/autolist/autolist.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	$.autolist({
		bind: 'item_id_widget',
		options: <{$itemList|@json_encode}>,
		onItemClick: function(key, item){
			$('#item_id_widget').val(item.text());
			$('#item_id').val(key);
		},
		onReset: function(){
			$('#item_id').val('');
		}
	});
})
</script>
</head>

<body>
<div id="position">
<b><{$lang->menu->class->baseData}>：<{$lang->menu->marketBillStatistics}></b>
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
<{$lang->basedata->billType}>: <{html_options options=$billTypeList selected=$selectedBillType name='bill_type'}>
<input type="hidden" name="search"/>
<input type="image" src="/static/images/search.gif" class="input2" align="absmiddle"  />
&nbsp;&nbsp;
</form>
</div>
<br />
<{if $viewData}>
* <{$lang->basedata->priceNotice}>
<br />
<table cellspacing="1" cellpadding="3" border="0" class='table_list' >

<tr class='table_list_head'>
		<th align="center"><{$lang->basedata->date}></th>
		<th align="center"><{$lang->basedata->billCount}></th>
		<{if $selectedBillType == 2}>
			<th align="center"><{$lang->basedata->sellRMBCount}></th>
			<th align="center"><{$lang->basedata->getMoneyCount}></th>
		<{else}>
			<th align="center"><{$lang->basedata->sellMoneyCount}></th>
			<th align="center"><{$lang->basedata->getRMBCount}></th>
		<{/if}>
		<th align="center"><{$lang->basedata->closedBillCount}></th>
		<th align="center"><{$lang->basedata->closedMoneyCount}></th>
		<th align="center"><{$lang->basedata->closedRMBCount}></th>
		<th align="center"><{$lang->basedata->avgClosedPrice}></th>
		<th align="center"><{$lang->basedata->maxClosedPrice}></th>
		<th align="center"><{$lang->basedata->minClosedPrice}></th>
	</tr>
	<{foreach name=loop from=$viewData.data item=item}>
	<tr class='<{cycle values="trEven,trOdd"}>'>
		<td align="center"><{$item.mtime|date_format:'%Y-%m-%d'}></td>
		<td align="center"><{$item.bill_count}></td>
		<{if $selectedBillType == 2}>
			<td align="center"><{$item.sell_rmb_count}></td>
			<td align="center"><{$item.get_money_count}></td>
		<{else}>
			<td align="center"><{$item.sell_money_count}></td>
			<td align="center"><{$item.get_rmb_count}></td>
		<{/if}>
		<td align="center"><{$item.closed_bill_count}></td>
		<td align="center"><{$item.closed_money_count}></td>
		<td align="center"><{$item.closed_rmb_count}></td>
		<td align="center">
			<{$item.avg_closed_rmb|string_format:"%.2f"}>
		</td>
		<td align="center">
			<{$item.max_closed_rmb|string_format:"%.2f"}>
		</td>
		<td align="center">
			<{$item.min_closed_rmb|string_format:"%.2f"}>
		</td>
	</tr>
	<{/foreach}>
</table>
<br />
<{assign var=minWidth value=1000}>
<!-- Start 挂单平均价格趋势  -->
<table class="SumDataGrid" style="min-width:<{$minWidth}>px;">
	<tr align="center">
		<th colspan="<{math equation="x+1" x=$viewData.data|@count}>">
			<{$startDay}> - <{$endDay}>  <{$lang->basedata->sellPriceTrend}>
		</th>
	</tr>
	<tr align="center" valign="bottom"  >
		<th valign="middle"><{$lang->basedata->avgPrice}></th>
		<{assign var=division value=$viewData.max_avg_closed_rmb*$highlightPercentage}>
		<{foreach from=$viewData.data item=item }>
		<td>
			<{$item.avg_sell_rmb|string_format:"%.2f"}>
			<{if $item.avg_sell_rmb >= $division }>
				<{assign var=class value='hr_red'}>
			<{else}>
				<{assign var=class value='hr_green'}>
			<{/if}>

			<hr class="<{$class}>" style=" height:<{math equation="(x/y)*120" x=$item.avg_sell_rmb y=$viewData.max_avg_closed_rmb}>px;" />
		</td>
		<{/foreach}>
	</tr>

	<tr align="center">
		<th><{$lang->page->date}></th>
		<{foreach from=$viewData.data item=item }>
		<td>
			<{if $item.weekday == 0 }>
				<{assign var=class value='red'}>
			<{else}>
				<{assign var=class value=''}>
			<{/if}>
			<span class="<{$class}>"><{$item.mtime|date_format:"%m-%d"}> 
				<{if $item.weekday == 0 }><br /><{$lang->page->sunday}> <{/if}>
			<br/>
			</span>
		</td>
		<{/foreach}>	
	</tr>
</table>
<!-- End 挂单平均价格趋势-->
<{else}>
<{*<font color='red'><{$lang->page->noData}></font>*}>
<{/if}>
</div>

</body>
</html>
