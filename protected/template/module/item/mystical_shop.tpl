<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>
		<{$lang->menu->mysticalShop}>
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
	<b><{$lang->menu->class->economySystem}>：<{$lang->menu->mysticalShop}></b>
	</div>

	<form id="myform" name="myform" method="post" action="">
	<div class='divOperation'>
	<{$lang->page->beginTime}>:<input id='starttime' name='starttime' type="text" class="Wdate" onfocus="WdatePicker({el:'starttime',dateFmt:'yyyy-MM-dd',minDate:'<{$minDate}>',maxDate:'#F{$dp.$D(\'endtime\')}'})" size='12' value='<{$dateStart}>' /> 
	<{*
		<{$lang->page->endTime}>:<input id='endtime' name='endtime' type="text" class="Wdate" onfocus="WdatePicker({el:'endtime',dateFmt:'yyyy-MM-dd',minDate:'#F{$dp.$D(\'starttime\')}',maxDate:'<{$maxDate}>'})" size='12' value='<{$dateEnd}>' /> 
	
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

	<{* 分页显示
	<table width="100%"  border="0" cellspacing="0" cellpadding="0" class='table_page_num'>
	  <tr>
	    <td height="30" class="even">
	 <{foreach key=key item=item from=$pagelist}>
	 <a id="pageUrl" href="javascript:void(0);" onclick="changePage('<{$item}>');"><{$key}></a><span style="width:5px;"></span>
	 <{/foreach}>
	<{$lang->page->record}>(<{$counts}>)&nbsp;&nbsp;&nbsp;<{$lang->page->totalPage}>(<{$pageCount}>)
	<{$lang->page->everyPage}><input type="text" id="record" name="record" size="4" style="text-align:center;" value="<{$record}>"><{$lang->page->row}>
	  <{$lang->page->dang}><input id="page" name="page" type="text" class="text" size="3" maxlength="6" style="text-align:center;" value="<{$pageno}>" ><{$lang->page->page}>&nbsp;<input id="btnGo" type="submit" class="button" name="Submit" value="GO">

	    </td>
	  </tr>
	</table>
	*}>

	
	<br>
	<div style="color:blue;"><h2><{$lang->page->manualRefresh}>：<{$viewData.refreshCount}></h2></div>
	<br>
	
	<{if $viewData}>
	
	<h2><{$lang->page->notVipGoods}>:</h2> 
	
	<br>
	<{$lang->page->welcomeRate}>：
	<{if $viewData.buyRate }>
	<br>
	<table cellspacing="1" cellpadding="3" border="0" class='table_list' style="width:800px;" >

		<tr align="center" class='table_list_head'>
			<th><{$lang->page->welcomeRate}><{$lang->page->rank}></th>
			<th><{$lang->page->sellItem}></th>
			<th><{$lang->page->welcomeRate}></th>
		</tr>		
		<{foreach name=loop from=$viewData.buyRate item=item}>
		<tr align="center" class='<{cycle values="trEven,trOdd"}>'>
			<td><{$item.no}></td>
			<td><{$item.item_name}></td>
			<td><{$item.rate}></td>
		</tr>
		<{/foreach}>
	</table>
	<{else}>
		<font color='red'><{$lang->page->noData}></font>
		<br>
	<{/if}>
	
	<br>
	<{$lang->page->moneyCostRank}>：
	<{if $viewData.moneyBuy }>
	<br>
	<table cellspacing="1" cellpadding="3" border="0" class='table_list' style="width:800px;" >

		<tr align="center" class='table_list_head'>
			<th><{$lang->page->moneyCostRank}></th>
			<th><{$lang->page->sellItem}></th>
			<th><{$lang->page->moneyCostCount}></th>
		</tr>
		<{foreach name=loop from=$viewData.moneyBuy item=item}>
		<tr align="center" class='<{cycle values="trEven,trOdd"}>'>
			<td><{$item.no}></td>
			<td><{$item.item_name}></td>
			<td><{$item.buy_sum}></td>
		</tr>
		<{/foreach}>
	</table>
	<{else}>
		<font color='red'><{$lang->page->noData}></font>
		<br>
	<{/if}>

	<br>
	<{$lang->page->xianshiCostRank}>：
	<{if $viewData.xianshiBuy }>
	<br>
	<table cellspacing="1" cellpadding="3" border="0" class='table_list' style="width:800px;" >

		<tr align="center" class='table_list_head'>
			<th><{$lang->page->xianshiCostRank}></th>
			<th><{$lang->page->sellItem}></th>
			<th><{$lang->page->xianshiCostCount}></th>
		</tr>
		<{foreach name=loop from=$viewData.xianshiBuy item=item}>
		<tr align="center" class='<{cycle values="trEven,trOdd"}>'>
			<td><{$item.no}></td>
			<td><{$item.item_name}></td>
			<td><{$item.buy_sum}></td>
		</tr>
		<{/foreach}>
	</table>
	<{else}>
		<font color='red'><{$lang->page->noData}></font>
		<br>
	<{/if}>
	
	<br>
	<{$lang->page->currencyCostCount}>：
	<{if $viewData.buySum }>
	<br>
	<table cellspacing="1" cellpadding="3" border="0" class='table_list' style="width:800px;" >
		<tr align="center" class='trEven'>
			<th><{$lang->page->moneyCostCount}></th>
			<td><{$viewData.buySum.moneyBuySum}></td>
		</tr>
		<tr align="center" class='trOdd'>
			<th><{$lang->page->xianshiCostCount}></th>
			<td><{$viewData.buySum.xianshiBuySum}></td>
		</tr>
	</table>
	<{else}>
		<font color='red'><{$lang->page->noData}></font>
		<br>
	<{/if}>	
	
		
	<br><br>
	<h2><{$lang->page->vipGoods}>:</h2> 
	<br>
	<{$lang->page->welcomeRate}>：
	<{if $viewData.vipBuyRate }>
	<br>
	<table cellspacing="1" cellpadding="3" border="0" class='table_list' style="width:800px;" >

		<tr align="center" class='table_list_head'>
			<th><{$lang->page->welcomeRate}><{$lang->page->rank}></th>
			<th><{$lang->page->sellItem}></th>
			<th><{$lang->page->welcomeRate}></th>
		</tr>		
		<{foreach name=loop from=$viewData.vipBuyRate item=item}>
		<tr align="center" class='<{cycle values="trEven,trOdd"}>'>
			<td><{$item.no}></td>
			<td><{$item.item_name}></td>
			<td><{$item.rate}></td>
		</tr>
		<{/foreach}>
	</table>
	<{else}>
		<font color='red'><{$lang->page->noData}></font>
		<br>
	<{/if}>
	
	<br>
	<{$lang->page->moneyCostRank}>：
	<{if $viewData.vipMoneyBuy }>
	<br>
	<table cellspacing="1" cellpadding="3" border="0" class='table_list' style="width:800px;" >

		<tr align="center" class='table_list_head'>
			<th><{$lang->page->moneyCostRank}></th>
			<th><{$lang->page->sellItem}></th>
			<th><{$lang->page->moneyCostCount}></th>
		</tr>
		<{foreach name=loop from=$viewData.vipMoneyBuy item=item}>
		<tr align="center" class='<{cycle values="trEven,trOdd"}>'>
			<td><{$item.no}></td>
			<td><{$item.item_name}></td>
			<td><{$item.buy_sum}></td>
		</tr>
		<{/foreach}>
	</table>
	<{else}>
		<font color='red'><{$lang->page->noData}></font>
		<br>
	<{/if}>

	<br>
	<{$lang->page->xianshiCostRank}>：
	<{if $viewData.vipXianshiBuy }>
	<br>
	<table cellspacing="1" cellpadding="3" border="0" class='table_list' style="width:800px;" >

		<tr align="center" class='table_list_head'>
			<th><{$lang->page->xianshiCostRank}></th>
			<th><{$lang->page->sellItem}></th>
			<th><{$lang->page->xianshiCostCount}></th>
		</tr>
		<{foreach name=loop from=$viewData.vipXianshiBuy item=item}>
		<tr align="center" class='<{cycle values="trEven,trOdd"}>'>
			<td><{$item.no}></td>
			<td><{$item.item_name}></td>
			<td><{$item.buy_sum}></td>
		</tr>
		<{/foreach}>
	</table>
	<{else}>
		<font color='red'><{$lang->page->noData}></font>
		<br>
	<{/if}>
	
	<br>
	<{$lang->page->currencyCostCount}>：
	<{if $viewData.vipBuySum }>
	<br>
	<table cellspacing="1" cellpadding="3" border="0" class='table_list' style="width:800px;">
		<tr align="center" class='trEven'>
			<th><{$lang->page->moneyCostCount}></th>
			<td><{$viewData.vipBuySum.vipMoneyBuySum}></td>
		</tr>
		<tr align="center" class='trOdd'>
			<th><{$lang->page->xianshiCostCount}></th>
			<td><{$viewData.vipBuySum.vipXianshiBuySum}></td>
		</tr>
	</table>
	<{else}>
		<font color='red'><{$lang->page->noData}></font>
		<br>
	<{/if}>
	
	
	<{else}>
		<font color='red'><{$lang->page->noData}></font>
	<{/if}>
	</div>
	</form>
	
</body>
</html>
