<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset='UTF-8'" />
	<link rel="stylesheet" href="/static/css/base.css" type="text/css" />
	<link rel="stylesheet" href="/static/css/style.css" type="text/css" />
	<link rel="stylesheet" href="/static/js/autolist/autolist.css" type="text/css" />
	<script type="text/javascript" src="/static/js/jquery.min.js"></script>
	<script type="text/javascript" src="/static/js/My97DatePicker/WdatePicker.js"></script>
	<script type="text/javascript" src="/static/js/global.js"></script>
	<title><{$lang->menu->moneySaveAndConsume}></title>
	<script type="text/javascript">
	$(document).ready(function(){
		$('#display_all').click(function(){
			$('#gold').show();
			$('#liquan').show();
			$('#money').show();
			$('#market_sell_fee').show();
		})
		
		$('#btn_all_gold').click(function(){
			$('#gold').show();
			$('#liquan').hide();
			$('#money').hide();
			$('#market_sell_fee').hide();
		})
		
		$('#btn_all_liquan').click(function(){
			$('#gold').hide();
			$('#liquan').show();
			$('#money').hide();
			$('#market_sell_fee').hide();
			
		})
		
		$('#btn_all_money').click(function(){
			$('#gold').hide();
			$('#liquan').hide();
			$('#money').show();
			$('#market_sell_fee').hide();
		})
		
		$('#btn_fee').click(function(){
			$('#gold').hide();
			$('#liquan').hide();
			$('#money').hide();
			$('#market_sell_fee').show();
		})
	})
</script>
</head>
<body>


<div id="position"><{$lang->menu->class->spendData}>：<{$lang->menu->moneySaveAndConsume}></div>

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
<!-- Start 日期搜索  -->
<table>
<tr>
<td>
	<form action="?action=search" id="frm" method="get"  style="display:inline;">
		<table cellspacing="1" cellpadding="5" class="SumDataGrid" >
			<tr>
				<td>
					<{$lang->page->beginTime}>:<input id='starttime' name='starttime' type="text" class="Wdate" onfocus="WdatePicker({el:'starttime',dateFmt:'yyyy-MM-dd',minDate:'<{$minDate}>',maxDate:'<{$maxDate}>'})" size='12' value='<{$startTime|date_format:'%Y-%m-%d' }>' /> 
				</td>
				<!--td>
					<{$lang->page->endTime}>:<input id='endtime' name='endtime' type="text" class="Wdate" onfocus="WdatePicker({el:'endtime',dateFmt:'yyyy-MM-dd',minDate:'#F{$dp.$D(\'starttime\')}',maxDate:'<{$maxDate}>'})" size='12' value='<{$endTime|date_format:'%Y-%m-%d'}>' /> 
				</td-->
				<td width="100px"><input type="submit" name='search' value="搜索" class="input2 submitbtn"  /></td>
			</tr>
		</table>
	</form>
</td>

</tr>
</table>
<br />
<!-- End 日期搜索  -->

<div>
<{$lang->page->onlineDate}>：<span style="color:#00F"><{$minDate}>&nbsp;</span>
<{$lang->page->onlineDays}>：<span style="color:#00F"><{$onlineDays}>&nbsp;</span>
<span><{$lang->page->today}>：<{$startTime|date_format:"%Y-%m-%d"}>&nbsp;</span>
</div>
<br/>
<{if $statistics}>
<input type="button" id="display_all" style="width:85px" value="<{$lang->gold->displayAll}>"/>
<input type="button" id="btn_all_gold" style="width:85px" value="<{$lang->currency->yuanbao}>"/>
<input type="button" id="btn_all_liquan" style="width:85px" value="<{$lang->currency->liquan}>"/>
<input type="button" id="btn_all_money" style="width:85px" value="<{$lang->currency->copper}>"/>
<input type="button" id="btn_fee" style="width:85px" value="<{$lang->currency->fee}>"/>
<br />

<span id="gold">
<br/>
<div style="color:#04F"><{$lang->gold->gold}>:<br/></div>
<!-- Start 元宝统计  -->
<table id="gold_remain" class="SumDataGrid" style="width:550px;" >
	<thead>
	<tr align="center" >
		<th colspan="5">
		<span style="color:#848"><{$lang->gold->goldRemainRank}></span>
		<br/>
		<{$lang->gold->allRemain}>: <span style="color:#F00"><{$statistics.gold.gold_remain.allRemainGold}></span>&nbsp;
		<{$lang->gold->activeGoldRemain}>: <span style="color:#F00"><{$statistics.gold.gold_remain.activeGold}></span>
		</th>
	</tr>
	<tr align="center">
		<th><{$lang->page->accountName}></th>
		<th><{$lang->page->roleName}></th>
		<th><{$lang->page->level}></th>
		<th><{$lang->gold->balance}></th>
		<th><{$lang->page->lastLoginTime}></th>
	</tr>
	</thead>

	<tbody>
	<{if $statistics.gold.gold_remain.remainList}>
		<{foreach from=$statistics.gold.gold_remain.remainList item=list name=gold_remain}>
		<tr align="center" <{if $currentTime-$list.last_login_time > 604800}>  style="color:#F00" title="超过7天未登录" <{/if}>>
			<td><{$list.account_name}></td>
			<td><{$list.role_name}></td>
			<td><{$list.level}></td>
			<td><{$list.remain_gold}></td>
			<td><{$list.last_login_time|date_format:"%Y-%m-%d %H:%M:%S"}></td>
		</tr>
		<{/foreach}>
	<{else}>
		<tr><td colspan="4" style="color:#00F"><{$lang->page->noData}></td></tr>
	<{/if}>
	</tbody>
</table>

<br/>

<table id="gold_cost" class="SumDataGrid" style="width:550px;" >
	<thead>
	<tr align="center" >
		<th colspan="5">
		<span style="color:#848"><{$lang->gold->goldConsumeRank}></span>
		<br/>
		<{$lang->page->date}>: <span style="color:#00F"><{$startTime|date_format:"%Y-%m-%d"}></span>
		<{$lang->gold->allCost}>: <span style="color:#F00"><{$statistics.gold.gold_cost.allCostGold}></span>
		</th>
	</tr>
	<tr align="center">
		<th><{$lang->page->accountName}></th>
		<th><{$lang->page->roleName}></th>
		<th><{$lang->page->level}></th>
		<th><{$lang->gold->goldConsumeCount}></th>
	</tr>
	</thead>

	<tbody>
	<{ if $statistics.gold.gold_cost.consumeList }>
		<{foreach from=$statistics.gold.gold_cost.consumeList item=list name=gold_consume}>
		<tr align="center">
			<td><{$list.account_name}></td>
			<td><{$list.role_name}></td>
			<td><{$list.level}></td>
			<td><{$list.all_consume_gold}></td>
		</tr>
		<{/foreach}>
	<{else}>
		<tr><td colspan="4" style="color:#00F"><{$lang->page->noData}></td></tr>
	<{/if}>
	</tbody>

</table>
</span>
<!-- End 元宝统计 -->

<span id="liquan">
<br/>
<div style="color:#04F"><{$lang->liquan->liquan}>:<br/></div>
<!-- Start 礼券统计  -->
<table id="liquan_remain" class="SumDataGrid" style="width:550px;" >
	<thead>
	<tr align="center" >
		<th colspan="5">
		<span style="color:#848"><{$lang->liquan->liquanRemainRank}></span>
		<br/>
		<{$lang->liquan->allRemain}>: <span style="color:#F00"><{$statistics.liquan.liquan_remain.allRemainLiquan}></span>&nbsp;
		<{$lang->liquan->activeLiquanRemain}>: <span style="color:#F00"><{$statistics.liquan.liquan_remain.activeGold}></span>
		</th>
	</tr>
	<tr align="center">
		<th><{$lang->page->accountName}></th>
		<th><{$lang->page->roleName}></th>
		<th><{$lang->page->level}></th>
		<th><{$lang->gold->balance}></th>
		<th><{$lang->page->lastLoginTime}></th>
	</tr>
	</thead>

	<tbody>
	<{if $statistics.liquan.liquan_remain.remainList}>
		<{foreach from=$statistics.liquan.liquan_remain.remainList item=list name=liquan_remain}>
		<tr align="center" >
			<td><{$list.account_name}></td>
			<td><{$list.role_name}></td>
			<td><{$list.level}></td>
			<td><{$list.remain_liquan}></td>
			<td><{$list.last_login_time|date_format:"%Y-%m-%d %H:%M:%S"}></td>
		</tr>
		<{/foreach}>
	<{else}>
		<tr><td colspan="4" style="color:#00F"><{$lang->page->noData}></td></tr>
	<{/if}>
	</tbody>
</table>

<br/>

<table id="liquan_cost" class="SumDataGrid" style="width:550px;" >
	<thead>
	<tr align="center" >
		<th colspan="5">
		<span style="color:#848"><{$lang->liquan->liquanConsumeRank}></span>
		<br/>
		<{$lang->page->date}>: <span style="color:#00F"><{$startTime|date_format:"%Y-%m-%d"}></span>
		<{$lang->liquan->allCost}>: <span style="color:#F00"><{$statistics.liquan.liquan_cost.allCostLiquan}></span>
		</th>
	</tr>
	<tr align="center">
		<th><{$lang->page->accountName}></th>
		<th><{$lang->page->roleName}></th>
		<th><{$lang->page->level}></th>
		<th><{$lang->liquan->liquanConsumeCount}></th>
	</tr>
	</thead>

	<tbody>
	<{ if $statistics.liquan.liquan_cost.consumeList }>
		<{foreach from=$statistics.liquan.liquan_cost.consumeList item=list name=liquan_consume}>
		<tr align="center">
			<td><{$list.account_name}></td>
			<td><{$list.role_name}></td>
			<td><{$list.level}></td>
			<td><{$list.all_consume_liquan}></td>
		</tr>
		<{/foreach}>
	<{else}>
		<tr><td colspan="4" style="color:#00F"><{$lang->page->noData}></td></tr>
	<{/if}>
	</tbody>

</table>
</span>
<!-- End 礼券统计 -->

<span id="money">
<br/>
<div style="color:#04F"><{$lang->money->money}>:<br/></div>
<!-- Start 银两统计  -->
<table id="money_remain" class="SumDataGrid" style="width:550px;" >
	<thead>
	<tr align="center" >
		<th colspan="5">
		<span style="color:#848"><{$lang->money->moneyRemainRank}></span>
		<br/>
		<{$lang->money->allRemain}>: <span style="color:#F00"><{$statistics.money.money_remain.allRemainMoney}></span>&nbsp;
		<{$lang->money->activeMoneyRemain}>: <span style="color:#F00"><{$statistics.money.money_remain.activeMoney}></span>
		</th>
	</tr>
	<tr align="center">
		<th><{$lang->page->accountName}></th>
		<th><{$lang->page->roleName}></th>
		<th><{$lang->page->level}></th>
		<th><{$lang->gold->balance}></th>
		<th><{$lang->page->lastLoginTime}></th>
	</tr>
	</thead>

	<tbody>
	<{if $statistics.money.money_remain}>
		<{foreach from=$statistics.money.money_remain.remainList item=list name=money_remain}>
		<tr align="center" >
			<td><{$list.account_name}></td>
			<td><{$list.role_name}></td>
			<td><{$list.level}></td>
			<td><{$list.remain_money}></td>
			<td><{$list.last_login_time|date_format:"%Y-%m-%d %H:%M:%S"}></td>
		</tr>
		<{/foreach}>
	<{else}>
		<<tr><td colspan="4" style="color:#00F"><{$lang->page->noData}></td></tr>
	<{/if}>
	</tbody>
</table>

</span>
<!-- End 银两统计 -->

<!--  市场寄卖手续费  -->
<span id="market_sell_fee">
	<br/>
	<div style="color:#04F"><{$lang->currency->fee}>:<br/></div>
	<table class="SumDataGrid" style="width:550px;">
	
		<tr>
			<th colspan="2">
				<span style="color:#848"><{$lang->currency->marketFee}></span>
				<br />
				<{$lang->page->date}>: <span style="color:#00F"><{$startTime|date_format:"%Y-%m-%d"}></span>
			</th>
		</tr>
		<tr align="center" >
			<td width="30%"><{$lang->currency->marketFeeMoney}></td>
			<td width="70%"><{$statistics.marketSellFee.money}></td>
		</tr>
		
		<tr align="center" >
			<td width="30%"><{$lang->currency->marketFeeGold}></td>
			<td width="70%"><{$statistics.marketSellFee.gold}></td>
		</tr>
	
	</table>
</span>
<{/if}>
</body>
</html>