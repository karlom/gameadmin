<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>
		<{$lang->menu->marry}>
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
	<b><{$lang->menu->class->userInfo}>：<{$lang->menu->marry}></b>
	</div>

	<form id="myform" name="myform" method="post" action="">
	<div class='divOperation'>
	<{$lang->page->beginTime}>:<input id='starttime' name='starttime' type="text" class="Wdate" onfocus="WdatePicker({el:'starttime',dateFmt:'yyyy-MM-dd',minDate:'<{$minDate}>',maxDate:'#F{$dp.$D(\'endtime\')}'})" size='12' value='<{$dateStart}>' /> 
		<{$lang->page->endTime}>:<input id='endtime' name='endtime' type="text" class="Wdate" onfocus="WdatePicker({el:'endtime',dateFmt:'yyyy-MM-dd',minDate:'#F{$dp.$D(\'starttime\')}',maxDate:'<{$maxDate}>'})" size='12' value='<{$dateEnd}>' /> 
	<{*
	&nbsp;<{$lang->player->roleName}>:<input type="text" id="role_name" name="role_name" size="10" value="<{$role_name}>" />
	&nbsp;<{$lang->player->accountName}>:<input type="text" id="account_name" name="account_name" size="10" value="<{$account_name}>" />
	*}>
	<input type="image" src="/static/images/search.gif" class="input2" align="absmiddle"  />
	
	<input type="submit" name="today" id="today" class="submitbtn" value="<{$lang->page->today}>" />
	<input type="submit" name="preday" id="preday" class="submitbtn" value="<{$lang->page->preday}>" />
	<input type="hidden" name="lookingday" id="lookingday" class="submitbtn" value="<{$lookingday}>" />
	<input type="submit" name="nextday" id="nextday" class="submitbtn" value="<{$lang->page->afterday}>" />
	<input type="submit" name="all" id="all" class="submitbtn" value="<{$lang->page->allTime}>" />
	
	</div>
	
	<br />
	<{ if $statisticsData }>
	
	&nbsp;<div style="font-size:large;color:#0070C0"><{$lang->marry->propose}>:</div>
		<{ if $statisticsData.propose}>
	<table height="" cellspacing="0" border="0" class="DataGrid" style="width:960px">
		<tr>
			<th width="30%"><{$lang->marry->proposeCount}></th>
			<th width="30%"><{$lang->marry->proposeSuccessCount}></th>
			<th width="30%"><{$lang->marry->proposeSuccessRate}></th>
		</tr>
		<tr align="center">
			<td ><{$statisticsData.propose.proposeCnt}></td>
			<td ><{$statisticsData.propose.proposeSucc}></td>
			<td ><{$statisticsData.propose.proposeRate}></td>
		</tr>
	</table>
	<{else}>
		<div><font color='red'><{$lang->page->noData}></font></div>
	<{/if}>
	<br />
	
	&nbsp;<div style="font-size:large;color:#0070C0"><{$lang->marry->weddingReserve}>:</div>
		<{ if $statisticsData.weddingReserve}>
	<table height="" cellspacing="0" border="0" class="DataGrid" style="width:960px">
		<tr>
			<th width="25%"><{$lang->marry->biddingField}></th>
			<th width="25%"><{$lang->marry->biddingCount}></th>
			<th width="25%"><{$lang->marry->finalBid}></th>
			<th width="25%"><{$lang->marry->bid}></th>
		</tr>
		<{foreach name=loop from=$statisticsData.weddingReserve item=item}>
		<tr align="center" class='<{cycle values="trEven,trOdd"}>'>
			<td ><{$item.field}></td>
			<td ><{$item.count}></td>
			<td ><{$item.finalPrice}></td>
			<td ><{$item.bid}></td>
		</tr>
		<{/foreach}>
	</table>
	<{$lang->marry->historyMaxBid}>:&nbsp;<{$statisticsData.maxPrice}>&nbsp;<{$lang->money->money}>
	<{else}>
		<div><font color='red'><{$lang->page->noData}></font></div>
	<{/if}>
	<br />
	
	&nbsp;<div style="font-size:large;color:#0070C0"><{$lang->marry->givePaper}>:</div>
		<{ if $statisticsData.givePaper}>
	<table height="" cellspacing="0" border="0" class="DataGrid" style="width:960px">
		<tr>
			<th width="25%"><{$lang->marry->weddingField}></th>
			<th width="25%"><{$lang->marry->newlyWed}></th>
			<th width="25%"><{$lang->marry->givePaperRoleCount}></th>
			<th width="25%"><{$lang->marry->giveMoneyCount}></th>
			<th width="25%"><{$lang->marry->giveXianshiCount}></th>
			<th width="25%"><{$lang->marry->moneyReclaim}></th>
			<th width="25%"><{$lang->marry->xianshiReclaim}></th>
		</tr>
		<{foreach name=loop from=$statisticsData.givePaper item=item}>
		<tr align="center" class='<{cycle values="trEven,trOdd"}>'>
			<td ><{$item.datetime}></td>
			<td ><{$item.role_name1}> + <{$item.role_name2}></td>
			<td ><{$item.role_count}></td>
			<td ><{$item.sum_money}></td>
			<td ><{$item.sum_gold}></td>
			<td ><{$item.sum_money*0.1 }></td>
			<td ><{$item.sum_gold*0.1 }></td>
		</tr>
		<{/foreach}>
	</table>
	<{else}>
		<div><font color='red'><{$lang->page->noData}></font></div>
	<{/if}>
	<br />
	
	&nbsp;<div style="font-size:large;color:#0070C0"><{$lang->marry->banquetRecord}>:</div>
		<{ if $statisticsData.banquet }>
	<table height="" cellspacing="0" border="0" class="DataGrid" style="width:960px">
		<tr>
			<th><{$lang->marry->number}></th>
			<th><{$lang->marry->banquetTime}></th>
			<th><{$lang->page->roleName}></th>
			<th ><{$lang->marry->banquetType}></th>
			<th><{$lang->marry->costMoney}></th>
			<th><{$lang->marry->costXianshi}></th>
		</tr>
		<{foreach name=loop from=$statisticsData.banquet item=item}>
		<tr align="center" class='<{cycle values="trEven,trOdd"}>'>
			<td ><{$item.id}></td>
			<td ><{$item.mdate}></td>
			<td ><{$item.role_name}></td>
			<td ><{$item.name}></td>
			<td ><{$item.money}></td>
			<td ><{$item.gold}></td>
		</tr>
		<{/foreach}>
		
		<tr align="center">
			<td colspan="4" ></td>
			<td><{$lang->money->money}><{$lang->page->summary}>: <{$statisticsData.banquet_sum.sum_money}></td>
			<td><{$lang->gold->gold}><{$lang->page->summary}>: <{$statisticsData.banquet_sum.sum_gold}></td>
		</tr>
	</table>
	<{else}>
		<div><font color='red'><{$lang->page->noData}></font></div>
	<{/if}>
	<br />
	
	&nbsp;<div style="font-size:large;color:#0070C0"><{$lang->marry->paradeRecord}>:</div>
		<{ if $statisticsData.parade }>
	<table height="" cellspacing="0" border="0" class="DataGrid" style="width:960px">
		<tr>
			<th><{$lang->marry->number}></th>
			<th><{$lang->marry->paradeTime}></th>
			<th><{$lang->page->roleName}></th>
			<th><{$lang->marry->paradeType}></th>
			<th><{$lang->marry->costMoney}></th>
			<th><{$lang->marry->costXianshi}></th>
		</tr>
		<{foreach name=loop from=$statisticsData.parade item=item}>
		<tr align="center" class='<{cycle values="trEven,trOdd"}>'>
			<td ><{$item.id}></td>
			<td ><{$item.mdate}></td>
			<td ><{$item.role_name}> + <{$item.target_role_name}></td>
			<td ><{$item.name}></td>
			<td ><{$item.money}></td>
			<td ><{$item.gold}></td>
		</tr>
		<{/foreach}>
		<tr align="center">
			<td colspan="4" ></td>
			<td><{$lang->money->money}><{$lang->page->summary}>: <{$statisticsData.parade_sum.sum_money}></td>
			<td><{$lang->gold->gold}><{$lang->page->summary}>: <{$statisticsData.parade_sum.sum_gold}></td>
		</tr>
	</table>
	<{else}>
		<div><font color='red'><{$lang->page->noData}></font></div>
	<{/if}>
	<br />
	
	&nbsp;<div style="font-size:large;color:#0070C0"><{$lang->marry->divorceCount}>:</div>
		<{ if $statisticsData.divorce}>
	<table height="" cellspacing="0" border="0" class="DataGrid" style="width:960px">
		<tr>
			<th width="25%"><{$lang->marry->divorceCount}></th>
			<th width="25%"><{$lang->marry->peaceDivorceCount}></th>
			<th width="25%"><{$lang->marry->enforeDivorceCount}></th>
			<th width="25%"><{$lang->marry->costXianshi}></th>
		</tr>
		<tr align="center" class='<{cycle values="trEven,trOdd"}>'>
			<td ><{$statisticsData.divorce.divorce_cnt}></td>
			<td ><{$statisticsData.divorce.peace}></td>
			<td ><{$statisticsData.divorce.force}></td>
			<td ><{$statisticsData.divorce.sum_all_xs}></td>
		</tr>
	</table>
	<{else}>
		<div><font color='red'><{$lang->page->noData}></font></div>
	<{/if}>
	<br />
	
	
	<{else}>
		<div><font color='red'><{$lang->page->noData}></font></div>
	<{/if}>
	
	</div>
	</form>
	
</body>
</html>
