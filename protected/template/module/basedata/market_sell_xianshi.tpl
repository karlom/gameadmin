<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<title><{$lang->menu->marketSellXianshi}></title>
		<link rel="stylesheet" href="/static/css/base.css" type="text/css">
		<link rel="stylesheet" href="/static/css/style.css" type="text/css">
		<script type="text/javascript" src="/static/js/jquery.min.js"></script>
		<script type="text/javascript" src="/static/js/My97DatePicker/WdatePicker.js"></script>
		<script type="text/javascript" src="/static/js/sorttable.js"></script>
		<script type="text/javascript" src="/static/js/global.js"></script>
		<script type="text/javascript">
				
			$(document).ready(function(){

			})
		</script>
	</head>

	<body style="margin:20px">
		<div id="position"><{$lang->menu->class->economySystem}>：<{$lang->menu->marketSellXianshi}> </div>
		<div class='divOperation'>
			<form name="myform" method="get" action="<{$URL_SELF}>">

				<{$lang->page->beginTime}>：<input type="text" size="13" class="Wdate" name="dateStart" id="dateStart" onfocus="WdatePicker({el:'dateStart',dateFmt:'yyyy-MM-dd',minDate:'<{$dateOnline}>',maxDate:'#F{$dp.$D(\'dateEnd\')}'})" value="<{ $dateStart }>" />
				<{$lang->page->endTime}>：<input type="text" size="13" class="Wdate" name="dateEnd" id="dateEnd" onfocus="WdatePicker({el:'dateEnd',dateFmt:'yyyy-MM-dd',minDate:'#F{$dp.$D(\'dateStart\')}',maxDate:'<{$maxDate}>'})"  value="<{ $dateEnd }>" />
								
				<input type="submit" class="submit" id="submit" value="<{$lang->sys->search}>" >
				
			</form>
		</div>
		<br/>
		

		<table id="data_table" cellspacing="0" class="DataGrid sortable">
		<{if $rs}>
		
		<span style="color:#00F"><{$lang->market->sellItem}>:<{if $item_id}><{$lang->market->itemID}>: <{$item_id}>, <{$lang->market->itemName}>: <{$item_name}><{/if}></span>
		<{if $item_id}>
			<tr class="sell_item">
				<th><{$lang->market->itemID}></th>
				<th><{$lang->market->itemName}></th>
				<th><{$lang->market->itemNum}></th>
				<th><{$lang->market->price}></th>
				<th><{$lang->market->roleName}></th>
				<th><{$lang->market->buyAccountName}></th>
				<th><{$lang->market->buyRoleName}></th>
				<th><{$lang->page->time}></th>
			</tr>
			<{foreach from=$rs item=item key=key}>
				<tr align="center">
					<td><{$item.item_id}></td>
					<td><{$item.item_name}></td>
					<td><{$item.item_num}></td>
					<td><{$item.sell_rmb}></td>
					<td><{$item.s_role_name}></td>
					<td><{$item.account_name}></td>
					<td><{$item.role_name}></td>
					<td><{$item.mdate}></td>
				</tr>
			<{/foreach}>
		<{else}>
			<tr class="sell_item">
				<th><{$lang->market->itemID}></th>
				<th><{$lang->market->itemName}></th>
				<th><{$lang->market->itemNum}></th>
								
				<th><{$lang->pay->total}></th>
				<th><{$lang->pay->price}></th>
			</tr>
			<{foreach from=$rs item=item key=key}>
				<tr align="center">
					<td><a href="<{$smarty.const.URL_SELF}>?dateStart=<{$dateStart}>&dateEnd=<{$dateEnd}>&itemid=<{$item.item_id}>" target="_blank"><{$item.item_id}></a></td>
					<td><{$item.item_name}></td>
					<td><{$item.item_num}></td>
					<td><{$item.sell_rmb}></td>
					<td><{$item.price}></td>
				</tr>
			<{/foreach}>
		<{/if}>
		<{else}>
			<tr>
				<th colspan='6'><{$lang->page->noData}></th>
			</tr>
		<{/if}>
		</table>

	</body>
</html>