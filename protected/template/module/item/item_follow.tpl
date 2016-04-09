<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>
	<{$lang->menu->itemFollow}>
</title>
<link rel="stylesheet" href="/static/css/base.css" type="text/css">
<link rel="stylesheet" href="/static/css/style.css" type="text/css">
<link rel="stylesheet" href="/static/js/autolist/autolist.css" type="text/css" />
<script type="text/javascript" src="/static/js/jquery.min.js"></script>	
<script type="text/javascript" src="/static/js/My97DatePicker/WdatePicker.js"></script>
<script type="text/javascript" src="/static/js/autolist/autolist.js"></script>
<script type="text/javascript" src="/static/js/colResizable-1.3.min.js"></script>
<script type="text/javascript" src="/static/js/global.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	$.autolist({
		bind: 'item_id_widget',
		options: <{$itemList|@json_encode}>,
		onItemClick: function(key, item){
			$('#item_id_widget').val(item.text());
//			$('#item_id').val(key);
		},
//		onReset: function(){
//			$('#item_id').val('');
//		}
	});
	$('.usage-filter').each(function(){
		if(!$(this).attr('checked')){
			$('#check_or_not').attr('checked', false);
		}
	})

	$('#check_or_not').click(function(){
		$('.usage-filter').attr('checked', $(this).attr('checked'))
	})
	
	$("input[type='image']").click(function(){
		if ( !$("#useItem").attr("checked") && !$("#getItem").attr("checked") ) {
		} 
	})
	
})
</script>
</head>

<body>
<div id="position">
<b><{$lang->menu->class->itemData}>：<{$lang->menu->itemFollow}></b>
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
&nbsp;<{$lang->player->roleName}>:<input type="text" id="role_name" name="role_name" size="15" value="<{$roleName}>" />
&nbsp;<{$lang->player->accountName}>:<input type="text" id="account_name" name="account_name" size="15" value="<{$accountName}>" />

<{$lang->item->itemName}>:<input id='item_id_widget' name='item_id_widget' type="text" size='30' value='<{if $itemID > 0}><{$itemID}> | <{$itemList[$itemID]}><{/if}>' /> 
<!--input id='item_id' name='item_id' type="hidden" size='12' value='<{$itemID}>' /--> 
<{html_options options=$sortArray selected=$selectedSortLine name='sortby'}>
<input type='image' src="/static/images/search.gif" class="input2" align="absmiddle"  />
&nbsp;&nbsp;
<br />
<label><input type="checkbox" id="check_or_not" name="selectAll" class="whole-line" <{if $selectedAll}> checked="checked" <{/if}> /><{$lang->item->selectAll}></label>
&nbsp;&nbsp;
<fieldset>
	<legend><{$lang->gold->consumption_type}></legend>
	<label><input type="checkbox" id="useItem" name="useItem" class="usage-filter" value="1" <{if $useItem}> checked="checked" <{/if}> /><{$lang->item->use}></label>
	<label><input type="checkbox" id="getItem" name="getItem" class="usage-filter" value="2" <{if $getItem}> checked="checked" <{/if}> /><{$lang->item->get}></label>
</fieldset>

<fieldset>
	<legend><{$lang->currency->currencyType}></legend>
	<{foreach name=loop from=$dictCurrency key=currency_id  item=label}>
		<label><input type="checkbox" class="usage-filter" name="currencyFilter[]" value="<{$currency_id}>" <{if $currency_id|@in_array:$selectedCurrency }>checked="checked"<{/if}> /><{$label}></label>
	<{/foreach}>
</fieldset>

<ul class="actionTypes">
<fieldset>
	<legend><{$lang->gold->op_type}></legend>
	<{foreach name=loop from=$dictOperation key=usage_id  item=label}>
		<li class="inline"><label><input type="checkbox" class="usage-filter" name="usageFilter[]" value="<{$usage_id}>" <{if $usage_id|@in_array:$selectedOperation }>checked="checked"<{/if}> /><{$label}></label></li>

	<{/foreach}>
</fieldset>
</ul>
</form>
</div>
<br class="clear"/>
<{if $viewData.data}>
<{include file='file:pager.tpl' pages=$pager assign=pager_html}>
<{$pager_html}>
<table cellspacing="1" cellpadding="3" border="0" class='table_list' >

<tr class='table_list_head'>
		<th align="center" style="width:10%"><{$lang->item->datetime}></th>
		<th align="center" style="width:10%"><{$lang->account->accountName}></th>
		<th align="center" style="width:10%"><{$lang->account->roleName}></th>
		<th align="center" style="width:5%"><{$lang->item->roleLevel}></th>
		<th align="center" style="width:8%"><{$lang->currency->currencyType}></th>
		<th align="center" style="width:12%"><{$lang->gold->consumption_type}></th>
		<th align="center" style="width:12%"><{$lang->item->itemName}></th>
		<th align="center" style="width:8%"><{$lang->item->itemCount}></th>
		<th align="center" style="width:5%"><{$lang->item->bind}></th>
		<th align="center" style="width:30%"><{$lang->item->detail}></th>
	</tr>
	<{foreach name=loop from=$viewData.data item=item}>
	<tr class='<{cycle values="trEven,trOdd"}>'>
		<td align="center"><{$item.mtime|date_format:'%Y-%m-%d %H:%M:%S'}></td>
		<td align="center" class="cmenu" title="<{$item.role_name}>"><{$item.role_name}></td>
		<td align="center" ><{$item.account_name}></td>
		<td align="center"><{$item.level}></td>
		<td align="center"><{ $item.cuType }></td>
		<td align="center"><{ $item.opType }></td>
		<td align="center"><{$item.item_id}> | <{$itemList[$item.item_id]}></td>
		<td align="center"><{$item.item_num}></td>
		<td align="center"><{if $item.is_bind == 1}><{$lang->item->yes}><{else}><{$lang->item->no}><{/if}></td>
		<td align="center"><{ $item.detail }></td>
	</tr>
	<{/foreach}>
</table>
<br />
<{$pager_html}>
<{else}>
<font color='red'><{$lang->page->noData}></font>
<{/if}>
</div>

</body>
</html>
