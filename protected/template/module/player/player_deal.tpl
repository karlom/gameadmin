<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>
	<{$lang->menu->playerDeal}>
</title>
<link rel="stylesheet" href="/static/css/base.css" type="text/css">
<link rel="stylesheet" href="/static/css/style.css" type="text/css">
<link rel="stylesheet" href="/static/js/autolist/autolist.css" type="text/css" />
<script type="text/javascript" src="/static/js/jquery.min.js"></script>	
<script type="text/javascript" src="/static/js/My97DatePicker/WdatePicker.js"></script>
<script type="text/javascript" src="/static/js/global.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	$('.trEven,.trOdd').toggle(function(){
		$(this).next().css('display', '');
	},
	function(){
		$(this).next().css('display', 'none');
	}
	)
})
</script>
</head>

<body>
<div id="position">
<b><{$lang->menu->class->userInfo}>：<{$lang->menu->playerDeal}></b>
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
<input type="image" src="/static/images/search.gif" class="input2" align="absmiddle"  />
&nbsp;&nbsp;
</form>
</div>
<br />
<{if $viewData.data}>
<b>温馨提示</b>：点击各行可以看到详细内容。
<{include file='file:pager.tpl' pages=$pager assign=pager_html}>
<{$pager_html}>
<table cellspacing="1" cellpadding="3" border="0" class='table_list' >

<tr class='table_list_head'>
		<th align="center" width="20%"><{$lang->player->tradeTime}></th>
		<th align="center" width="20%"><{$lang->player->selfRolename}></th>
		<th align="center" width="20%"><{$lang->player->selfMoney}></th>
		<th align="center" width="20%"><{$lang->player->targetRolename}></th>
		<th align="center" width="20%"><{$lang->player->targetMoney}></th>
	</tr>
	<{foreach name=loop from=$viewData.data item=record}>
	<tr class='<{cycle values="trEven,trOdd"}>'>
		<td align="center"><{$record.mtime|date_format:'%Y-%m-%d %H:%M:%S'}></td>
		<td align="center" class="cmenu" title="<{$record.role_name}>"><{$record.role_name}></td>
		<td align="center"><{$record.yinliang_get}></td>
		<td align="center" class="cmenu" title="<{$record.target_name}>"><{$record.target_name}></td>
		<td align="center"><{$record.yinliang_lose}></td>
	</tr>
	<tr style="display:none">
		<td colspan="5">
		<table width="100%">
			<{* 发起方获得的物品列表  *}>
			<{if $record.get_item_list|@count}>
			<tr class="detail_head"><th align="left" colspan="8"><{$lang->player->selfItem}></th></tr>
			<{foreach name=loop from=$record.get_item_list key=item_id item=item}>
			<tr>
				<td width="15%"><{$lang->item->itemName}>: <font color="red">'<{$itemList[$item.id]}>'</font></td>
				<!--<td width="15%">UID: <font color="red">'<{$item.uid}>'</font></td>-->
				<td width="10%"><{$lang->item->itemCount}>: <font color="red">'<{$item.num}>'</font></td>
				<td width="10%"><{$lang->page->isBind}>: <font color="red">'<{if $item.isBind}><{$lang->item->yes}><{else}><{$lang->item->no}><{/if}>'</font></td>
				<td width="10%"><{$lang->item->strengthen}>: <font color="red">'<{$item.detail.strengthen}>'</font></td>
				<td width="10%"><{$lang->item->quality}>: <font color="red">'<{$item.detail.quality}>'</font></td>
				<td width="10%"><{$lang->item->refineCnt}>: <font color="red">'<{$item.detail.jinglian}>'</font></td>
				<td width="10%"><{$lang->item->showColor}>: <font color="red">'<{$dictColor[$item.detail.showColor]}>'</font></td>
				<td width="20%"><{$lang->item->gems}>: <font color="red">'
					<{if $item.detail.gems|@count}>
						<{$lang->item->hole1}>:<{$itemList[$item.detail.gems.0]}>,<{$lang->item->hole2}>:<{$itemList[$item.detail.gems.1]}>
					<{/if}>
					'</font>
				</td>
			</tr>
			<{/foreach}>
			<{/if}>
			
			<{* 发起方获得的物品列表  *}>
			<{if $record.lose_item_list|@count}>
			<tr class="detail_head"><th align="left" colspan="8"><{$lang->player->targetItem}></th></tr>
			<{foreach name=loop from=$record.lose_item_list key=item_id item=item}>
			<tr>
				<td width="15%"><{$lang->item->itemName}>: <font color="red">'<{$itemList[$item.id]}>'</font></td>
				<!--<td width="15%">UID: <font color="red">'<{$item.uid}>'</font></td>-->
				<td width="10%"><{$lang->item->itemCount}>: <font color="red">'<{$item.num}>'</font></td>
				<td width="10%"><{$lang->page->isBind}>: <font color="red">'<{if $item.isBind}><{$lang->item->yes}><{else}><{$lang->item->no}><{/if}>'</font></td>
				<td width="10%"><{$lang->item->strengthen}>: <font color="red">'<{$item.detail.strengthen}>'</font></td>
				<td width="10%"><{$lang->item->quality}>: <font color="red">'<{$item.detail.quality}>'</font></td>
				<td width="10%"><{$lang->item->refineCnt}>: <font color="red">'<{$item.detail.jinglian}>'</font></td>
				<td width="10%"><{$lang->item->showColor}>: <font color="red">'<{$dictColor[$item.detail.showColor]}>'</font></td>
				<td width="20%"><{$lang->item->gems}>: <font color="red">'
					<{if $item.detail.gems|@count}>
						<{$lang->item->hole1}>:<{$itemList[$item.detail.gems.0]}>,<{$lang->item->hole2}>:<{$itemList[$item.detail.gems.1]}>
					<{/if}>
					'</font>
				</td>
			</tr>
			<{/foreach}>
			<{/if}>
		</table>
		</td>
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
