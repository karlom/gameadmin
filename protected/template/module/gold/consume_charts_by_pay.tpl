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

<title><{$lang->menu->goldConsumeByPay}></title>
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



<div id="position"><{$lang->menu->class->spendData}>：<{$lang->menu->goldConsumeByPay}></div>

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
		<table cellspacing="1" cellpadding="5" class="SumDataGrid" width="800">
			<tr>
				<td>
					<{$lang->page->beginTime}>: <input type="text" size="13" class="Wdate" name="start_day" id="start_day" onfocus="WdatePicker({el:'start_day',dateFmt:'yyyy-MM-dd',minDate:'<{$minDate}>',maxDate:'#F{$dp.$D(\'end_day\')}'})" value="<{ $startDay }>">
				</td>
				<td>
					<{$lang->page->endTime}>: <input type="text" size="13" class="Wdate" name="end_day" id="end_day" onfocus="WdatePicker({el:'end_day',dateFmt:'yyyy-MM-dd',minDate:'#F{$dp.$D(\'start_day\')}',maxDate:'<{$maxDate}>'})"  value="<{ $endDay }>">
				</td>
				<td>
					<{$lang->gold->gold_type}>：<{html_options options=$dictGoldType selected=$selectGoldType name='select_gold_type'}>
				</td>
				<td>
					<{$lang->gold->consumption_type}>:<input id='consumption_type_widget' name='consumption_type_widget' type="text" size='30' value='<{if $selectConsumptionType > 0}><{$selectConsumptionType}> | <{$consumptionType[$selectConsumptionType]}><{/if}>' /> 
					<input id='consumption_type' name='consumption_type' type="hidden" size='12' value='<{$selectConsumptionType}>' /> 
				</td>
				<td><input type="image" name='search' src="/static/images/search.gif" class="input2"  /></td>
			</tr>
		</table>
	</form>
</td>

</tr>
</table>
<br />
<!-- End 账号和角色名搜索  -->


<{if $viewData.data}>
<div>
	<span class="hr_red" style=" height:10px" >&nbsp;</span> <{$lang->page->gt}><{$highlightPercentage*100}>%
	<span class="hr_green" style=" height:10px" >&nbsp;</span> <{$lang->page->lt}><{$highlightPercentage*100}>%
</div>

<{assign var=minWidth value=0}>
<!-- Start 元宝消耗  -->
<table class="SumDataGrid" >
	<caption class="table_list_head">
			<{$startDay}> - <{$endDay}>  
			[<span style="color:#f00;"><{$dictGoldType[$selectGoldType]}></span>]<{$lang->gold->goldConsumeByPayGraph}>  
			<{$lang->gold->consumption_type}> ： [<span style="color:#f00;"><{if $selectConsumptionType > 0}><{ $consumptionType[$selectConsumptionType]}><{else}><{$lang->page->unlimited}><{/if}></span>]
	</caption>
	<tr align="center" valign="bottom"  >
		<th valign="middle" width="100px"><{$lang->gold->allCost}></th>
		<{assign var=division value=$viewData.max_gold_count*$highlightPercentage}>
		<{foreach from=$viewData.data item=log}>
		<td>
			<{$log.all_gold}>
			<{if $log.all_gold >= $division }>
				<{assign var=class value='hr_red'}>
			<{else}>
				<{assign var=class value='hr_green'}>
			<{/if}>

			<hr class="<{$class}>" style=" height:<{math equation="(x/y)*120" x=$log.all_gold y=$viewData.max_gold_count}>px;" />
		</td>
		<{/foreach}>
	</tr>
	<tr align="center" valign="bottom"  >
		<th valign="middle" width="100px"><{$lang->gold->actualCount}></th>
		<{assign var=division value=$viewData.max_item_count*$highlightPercentage}>
		<{foreach from=$viewData.data item=log}>
		<td>
			<{$log.item_count}>
			<{if $log.item_count >= $division }>
				<{assign var=class value='hr_red'}>
			<{else}>
				<{assign var=class value='hr_green'}>
			<{/if}>

			<hr class="<{$class}>" style=" height:<{math equation="(x/y)*120" x=$log.item_count y=$viewData.max_item_count}>px;" />
		</td>
		<{/foreach}>
	</tr>
	<tr align="center" valign="bottom"  >
		<th valign="middle" width="100px"><{$lang->gold->op_count}></th>
		<{assign var=division value=$viewData.max_op_count*$highlightPercentage}>
		<{foreach from=$viewData.data item=log}>
		<td>
			<{$log.op_count}>
			<{if $log.op_count >= $division }>
				<{assign var=class value='hr_red'}>
			<{else}>
				<{assign var=class value='hr_green'}>
			<{/if}>

			<hr class="<{$class}>" style=" height:<{math equation="(x/y)*120" x=$log.op_count y=$viewData.max_op_count}>px;" />
		</td>
		<{/foreach}>
	</tr>
	<tr align="center">
		<th><{$lang->page->date}><br/><{$lang->gold->payRange}></th>
		<{foreach from=$viewData.data item=log key=key}>
		<td>
			<{$log.ranges_label}>
		</td>
		<{/foreach}>	
	</tr>
</table>
<!-- End 元宝消耗  -->
<{ else }>
	<div><{$lang->page->noData}></div>
<{ /if }>
</body>
</html>