<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>
		<{$lang->menu->npcSellItems}>
	</title>
	<link rel="stylesheet" href="/static/css/base.css" type="text/css">
	<link rel="stylesheet" href="/static/css/style.css" type="text/css">
	<script type="text/javascript" src="/static/js/jquery.min.js"></script>	
	<script type="text/javascript" src="/static/js/My97DatePicker/WdatePicker.js"></script>
	<script type="text/javascript" src="/static/js/ip.js"></script>
	<script type="text/javascript" src="/static/js/colResizable-1.3.min.js"></script>
	<script type="text/javascript" src="/static/js/global.js"></script>
	<script type="text/javascript" >
		function changePage(page){
			$("#page").val(page);
			$("#myform").submit();
		}
		$(document).ready(function(){
			$("#account_name").keydown(function(){
				$("#role_name").val('');
		
			});
			$("#role_name").keydown(function(){
				$("#account_name").val('');
		
			});
	
		});
		
	</script>
</head>

<body>
	
	<div id="position">
	<b><{$lang->menu->class->economySystem}>：<{$lang->menu->npcSellItems}></b>
	</div>

	<form id="myform" name="myform" method="post" action="">
	<div class='divOperation'>
	<{$lang->page->beginTime}>:<input id='starttime' name='starttime' type="text" class="Wdate" onfocus="WdatePicker({el:'starttime',dateFmt:'yyyy-MM-dd',minDate:'<{$minDate}>',maxDate:'#F{$dp.$D(\'endtime\')}'})" size='12' value='<{$dateStart}>' /> 
		<{$lang->page->endTime}>:<input id='endtime' name='endtime' type="text" class="Wdate" onfocus="WdatePicker({el:'endtime',dateFmt:'yyyy-MM-dd',minDate:'#F{$dp.$D(\'starttime\')}',maxDate:'<{$maxDate}>'})" size='12' value='<{$dateEnd}>' /> 
	
	&nbsp;<{$lang->player->roleName}>:<input type="text" id="role_name" name="role_name" size="10" value="<{$role_name}>" />
	&nbsp;<{$lang->player->accountName}>:<input type="text" id="account_name" name="account_name" size="10" value="<{$account_name}>" />
	<input type="image" src="/static/images/search.gif" class="input2" align="absmiddle"  />
	
	<input type="submit" name="today" id="today" class="submitbtn" value="<{$lang->page->today}>" />
	<input type="submit" name="preday" id="preday" class="submitbtn" value="<{$lang->page->preday}>" />
	<input type="hidden" name="lookingday" id="lookingday" class="submitbtn" value="<{$lookingday}>" />
	<input type="submit" name="nextday" id="nextday" class="submitbtn" value="<{$lang->page->afterday}>" />
	<input type="submit" name="all" id="all" class="submitbtn" value="<{$lang->page->allTime}>" />
	</div>
	<br />

	
	<table width="100%"  border="0" cellspacing="0" cellpadding="0" class='table_page_num'>
	  <tr>
	    <td height="30" class="even">
	 <{foreach key=key item=item from=$pagelist}>
	 <a id="pageUrl" href="javascript:void(0);" onclick="changePage('<{$item}>');"><{$key}></a><span style="width:5px;"></span>
	 <{/foreach}>
	<{$lang->page->record}>(<{$counts}>)&nbsp;&nbsp;&nbsp;<{$lang->page->totalPage}>(<{$pageCount}>)
	<{$lang->page->everyPage}><input type="text" id="record" name="record" size="4" style="text-align:center;" value="<{$record}>"><{$lang->page->row}>
	  <{$lang->page->dang}><input id="page" name="page" type="text" class="text" size="3" maxlength="6" style="text-align:center;" value="<{$pageno}>" ><{$lang->page->page}>&nbsp;<input id="btnGo" type="submit" class="button" name="Submit" value="GO">
<{*
	<input type="submit" id="excel" name="excel" class="submitbtn" value="<{$lang->page->excel}>"/>
*}>
	    </td>
	  </tr>
	</table>
	
	<{if $viewData}>
	<table cellspacing="1" cellpadding="3" border="0" class='table_list' >
		<tr>
			<th colspan="16" class='table_list_head'>
			<{$lang->menu->npcSellItems}>&nbsp;&nbsp;<{$lang->sys->betweenCountTime}>:&nbsp;<font color="blue"><{$dateStart}></font>&nbsp;<{$lang->page->to}>&nbsp;<font color="blue"><{$dateEnd}></font>&nbsp;<{if $role_name}>&nbsp;<{$lang->player->roleName}>:&nbsp;<font color="red"><{$role_name}></font><{/if}>
			</th>
		</tr>
		<tr align="center" class='table_list_head'>
			<td rowspan="2">NPC ID</td>
			<td rowspan="2">NPC<{$lang->page->name}></td>
			<td rowspan="2"><{$lang->item->itemID}></td>
			<td rowspan="2"><{$lang->item->itemName}></td>
			<td colspan="3"><{$lang->currency->yuanbao}></td>
			<td colspan="3"><{$lang->currency->liquan}></td>
			<td colspan="3"><{$lang->currency->money}></td>
			<td colspan="3"><{$lang->currency->jieriXianbi}></td>
		</tr>
		<tr align="center" class='table_list_head'>
			<td><{$lang->item->tatolCost}></td>
			<td><{$lang->item->buyNumber}></td>
			<td><{$lang->item->buyCount}></td>
			<td><{$lang->item->tatolCost}></td>
			<td><{$lang->item->buyNumber}></td>
			<td><{$lang->item->buyCount}></td>
			<td><{$lang->item->tatolCost}></td>
			<td><{$lang->item->buyNumber}></td>
			<td><{$lang->item->buyCount}></td>
			<td><{$lang->item->tatolCost}></td>
			<td><{$lang->item->buyNumber}></td>
			<td><{$lang->item->buyCount}></td>
		</tr>
		
		<{foreach name=loop from=$viewData item=item}>
		<tr align="center" class='<{cycle values="trEven,trOdd"}>'>
			<td title="<{$dictNpc[$item.shop_npc_id].desc}>"><{$item.shop_npc_id}></td>
			<td title="<{$dictNpc[$item.shop_npc_id].desc}>"><{$dictNpc[$item.shop_npc_id].name}></td>
			<td><{$item.item_id}></td>
			<td><{$arrItemsAll[$item.item_id].name}></td>
			<td><{$item.all_cost_g}></td>
			<td><{$item.item_cnt_g}></td>
			<td><{$item.buy_cnt_g}></td>
			<td><{$item.all_cost_b}></td>
			<td><{$item.item_cnt_b}></td>
			<td><{$item.buy_cnt_b}></td>
			<td><{$item.all_cost_m}></td>
			<td><{$item.item_cnt_m}></td>
			<td><{$item.buy_cnt_m}></td>
			<td><{$item.all_cost_i}></td>
			<td><{$item.item_cnt_i}></td>
			<td><{$item.buy_cnt_i}></td>
		</tr>
		<{/foreach}>
	</table>
	<{else}>
	<font color='red'><{$lang->page->noData}></font>
	<{/if}>
	</div>
	</form>
	
</body>
</html>
