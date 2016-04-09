<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>
	<{$lang->menu->player}>
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
<b><{$lang->menu->class->userInfo}>：<{$lang->menu->playerMail}></b>
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
<{include file='file:pager.tpl' pages=$pager assign=pager_html}>
<{$pager_html}>
<table cellspacing="1" cellpadding="3" border="0" class='table_list' >

<tr class='table_list_head'>
		<th align="center" width="20%"><{$lang->page->time}></th>
		<th align="center" width="10%"><{$lang->player->sender}></th>
		<th align="center" width="10%"><{$lang->player->receiver}></th>
		<th align="center" width="60%"><{$lang->player->attachement}></th>
	</tr>
	<{foreach name=loop from=$viewData.data item=record}>
	<tr class='<{cycle values="trEven,trOdd"}>'>
		<td align="center"><{$record.mtime|date_format:'%Y-%m-%d %H:%M:%S'}></td>
		<td align="center" class="cmenu" title="<{$record.sender_role_name}>"><{$record.sender_role_name}></td>
		<td align="center" class="cmenu" title="<{$record.receiver_role_name}>"><{$record.receiver_role_name}></td>
		<td align="center">
			<{if $record.item_list|@count}>
			<{foreach name=loop from=$record.item_list key=item_id item=item}>
				<font color="red"><{$itemList[$item_id]}></font> 
			<{/foreach}>
			<{/if}> 
			<span style="float:right;"><a href="#"><{$lang->player->attachementDetail}>...</a></span>
		</td>
	</tr>
	<tr style="display:none">
		<td colspan="5">
		<table width="100%">
			<{* 邮件的物品列表  *}>
			<{if $record.item_list|@count}>
			<tr class="detail_head"><th align="left" colspan="8"><{$lang->player->attachementDetail}></th></tr>
			<{foreach name=loop from=$record.item_list key=item_id item=item}>
			<tr>
				<td width="15%"><{$lang->item->itemName}>: <font color="red">'<{$itemList[$item_id]}>'</font></td>
				<td width="15%">UID: <font color="red">'<{$item.uid}>'</font></td>
				<td width="10%"><{$lang->item->itemCount}>: <font color="red">'<{$item.item_count}>'</font></td>
				<td width="10%"><{$lang->item->strengthen}>: <font color="red">'<{$item.strengthen}>'</font></td>
				<td width="10%"><{$lang->item->quality}>: <font color="red">'<{$item.quality}>'</font></td>
				<td width="10%"><{$lang->item->xiulianLv}>: <font color="red">'<{$item.xiulianLv}>'</font></td>
				<td width="10%"><{$lang->item->hole}>: <font color="red">'<{$item.hole}>'</font></td>
				<td width="20%"><{$lang->item->gems}>: 
					<{if $item.gems|@count}>
						<{foreach name=loop from=$item.gems  item=gem_id}>
							<{$itemList[$gem_id]}>,
						<{/foreach}>
					<{/if}>
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
