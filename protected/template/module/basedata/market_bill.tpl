<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<title><{$lang->menu->marketBill}></title>
		<link rel="stylesheet" href="/static/css/base.css" type="text/css">
		<link rel="stylesheet" href="/static/css/style.css" type="text/css">
		<script type="text/javascript" src="/static/js/jquery.min.js"></script>
		<script type="text/javascript" src="/static/js/My97DatePicker/WdatePicker.js"></script>
		<script type="text/javascript" src="/static/js/global.js"></script>
		<script type="text/javascript">
			function setType( n ){
				if( n == 6 ) {
					document.getElementById("type").value = 3;
					document.getElementById("state").value = 1;
				} else if ( n == 7 ){
					document.getElementById("type").value = 3;
					document.getElementById("state").value = 2;
				}else {
					document.getElementById("type").value = n;
				}	
				
				document.myform.submit();
			}
				
			$(document).ready(function(){
				$("select[name=type]").change(function(){
					if (this.value == "4"){
						$("#state option:eq(0)").attr('disabled', 'desabled');
						$("#state option:eq(2)").attr('disabled', 'desabled');
						$("#state option:eq(1)").attr('selected', 'selected');
					} else {
						$("#state option:eq(0)").removeAttr('disabled', 'desabled');
						$("#state option:eq(2)").removeAttr('disabled', 'desabled');
					}
				})
				
				/*
				$('#sell_item').click(function(){
					//$('#myform type').val('3');
					x=document.getElementById("type").value;
					//$("#myform").submit();
					document.write(x);
				})
				
				$('#sell_money').click(function(){
					$('#data_table tr[class!="alwaysdisplay"]').hide();
					$('#data_table tr.sell_money').show();
				})
				
				$('#sell_gold').click(function(){
					$('#data_table tr[class!="alwaysdisplay"]').hide();
					$('#data_table tr.sell_gold').show();
				})
				*/
			})
		</script>
	</head>

	<body style="margin:20px">
		<div id="position"><{$lang->menu->class->baseData}>：<{$lang->menu->marketBill}> </div>
		<div class='divOperation'>
			<form name="myform" method="get" action="<{$URL_SELF}>">
				<{*
				<{$lang->page->type}>：
				<select name="type" id="type">
					<{html_options options=$billType selected=$type}>
				</select>
				<{$lang->player->status}>：
				<select name="state" id="state">
					<{html_options options=$billState selected=$state}>
				</select>
				*}>
				<{$lang->page->beginTime}>：<input type="text" size="13" class="Wdate" name="dateStart" id="dateStart" onfocus="WdatePicker({el:'dateStart',dateFmt:'yyyy-MM-dd',minDate:'<{$dateOnline}>',maxDate:'#F{$dp.$D(\'dateEnd\')}'})" value="<{ $dateStart }>" />
				<{$lang->page->endTime}>：<input type="text" size="13" class="Wdate" name="dateEnd" id="dateEnd" onfocus="WdatePicker({el:'dateEnd',dateFmt:'yyyy-MM-dd',minDate:'#F{$dp.$D(\'dateStart\')}',maxDate:'<{$maxDate}>'})"  value="<{ $dateEnd }>" />
				
				<input type="hidden" name="type" id="type" value="2">
				<input type="hidden" name="state" id="state" value="0">
				
				<span style='margin-left:20px;'><{$lang->item->roleName}>: <input type='text' id='roleName' name='roleName' size='12' value='<{ $roleName }>' title='指定角色查询' /></span>
			<!--	<input type="submit" name='search' value="<{$lang->page->serach}>" />
				<br/>
				
				<input type="button" class="button" name="datePrev" value="<{$lang->page->today}>" onclick="javascript:location.href='<{$URL_SELF}>?dateStart=<{$dateStrToday}>&dateEnd=<{$dateStrToday}>&role_name=<{$role_name}>&type=<{$type}>&state=<{$state}>';">
				<input type="button" class="button" name="datePrev" value="<{$lang->page->prevTime}>" onclick="javascript:location.href='<{$URL_SELF}>?dateStart=<{$dateStrPrev}>&dateEnd=<{$dateStrPrev}>&role_name=<{$role_name}>&type=<{$type}>&state=<{$state}>';">
				<input type="button" class="button" name="dateNext" value="<{$lang->page->nextTime}>" onclick="javascript:location.href='<{$URL_SELF}>?dateStart=<{$dateStrNext}>&dateEnd=<{$dateStrNext}>&role_name=<{$role_name}>&type=<{$type}>&state=<{$state}>';">
				<input type="button" class="button" name="dateAll" value="<{$lang->page->fromOnlineDate}>" onclick="javascript:location.href='<{$URL_SELF}>?dateStart=ALL&dateEnd=ALL&role_name=<{$role_name}>&type=<{$type}>&state=<{$state}>';">
				-->
				<br/>
				<br/>
				<input type="button" class="sell_item" id="sell_item" value="<{$lang->market->sellItem}>" onclick="setType(3)" >
				<input type="button" class="sell_money" id="sell_money" value="<{$lang->market->sellMoney}>" onclick="setType(5)">
				<input type="button" class="sell_gold" id="sell_gold" value="<{$lang->market->sellGold}>" onclick="setType(2)">
				<input type="button" class="sell_finished" id="sell_finished" value="<{$lang->market->sellFinished}>" onclick="setType(6)">
				<input type="button" class="sell_cancelled" id="sell_cancelled" value="<{$lang->market->sellCancelled}>" onclick="setType(7)">
				
			</form>
		</div>
		<br/>
		
		<{include file='file:pager.tpl' pages=$pager assign=pager_html}>
		<{$pager_html}>
		<table id="data_table" cellspacing="0" class="DataGrid">
		<{if $rs}>
		<form id="form1" name="form1" method="post" action="">
		<{if $type eq 1 or $type eq 2 }>
			<span style="color:#00F"><{$lang->market->sellGold}>:</span>
			<tr class="sell_gold">
				<!--th><{$lang->market->order}></th-->
				<th><{ if $type eq 1 }><{$lang->market->buyGold}><{ elseif $type eq 2 }><{$lang->market->sellNum}><{ /if }></th>
				<th><{$lang->market->price}></th>
				<th><{$lang->market->roleName}></th>
				<th><{$lang->player->status}></th>
				<th><{$lang->page->time}></th>
			</tr>
			<{section name=loop loop=$rs}>
				<{if $smarty.section.loop.rownum % 2 == 0}>
				<tr align="center" class='sell_gold odd'>
				<{else}>
				<tr align="center" class="sell_gold">
				<{/if}>
					<!--td><{ $rs[loop].market_id }></td-->
					<td><{ if $type eq 1 }><{ $rs[loop].sell_money }> <{$lang->market->money}><{ elseif $type eq 2 }><{ $rs[loop].sell_rmb }> <{$lang->market->gold}><{ /if }></td>
					<td><{ if $type eq 1 }><{ $rs[loop].rmb }> <{$lang->market->gold}><{ elseif $type eq 2 }><{ $rs[loop].money }> <{$lang->market->money}><{ /if }></td>
					<td class="cmenu" title="<{ $rs[loop].role_name }>"><{ $rs[loop].role_name }></td>
					<td><{ if $state eq 0}><{$lang->market->onSale}><{ elseif $state eq 1}><{$lang->market->sold}><{ else if $state eq 2 }><{$lang->market->cancel}><{ /if }></td>
					<td><{ $rs[loop].mdate }></td>
				</tr>
			<{/section}>
		
		<{elseif $type eq 3 or $type eq 4}>	
			<span style="color:#00F"><{$lang->market->sellItem}>:</span>
			<tr class="sell_item">
				<!--th><{$lang->market->order}></th-->
				<th><{$lang->market->itemID}></th>
				<th><{$lang->market->itemName}></th>
				<th><{$lang->market->itemNum}></th>
				
				<th><{$lang->item->qualityLv}></th>
				<th><{$lang->item->strengthenLv}></th>
				<th><{$lang->item->refineCnt}></th>
				<!--th><{$lang->market->other}></th-->
				
				<th><{$lang->market->sellType}></th>
				<th><{$lang->market->price}></th>
				<th><{$lang->market->roleName}></th>
				<{if $state eq 1}><th><{$lang->market->buyRoleName}></th><{/if}>
				<th><{$lang->player->status}></th>
				<th><{$lang->page->time}></th>
			</tr>
			<{section name=loop loop=$rs}>
				<{if $smarty.section.loop.rownum % 2 == 0}>
				<tr align="center" class='sell_item odd'>
				<{else}>
				<tr align="center" class="sell_item">
				<{/if}>
					<!--td><{ $rs[loop].market_id }></td-->
					<td><{ $rs[loop].item_id }></td>
					<td><{ $rs[loop].item_name }></td>
					<td><{ $rs[loop].item_num }></td>
					
					<td><{if $rs[loop].item_detail.quality}><{$rs[loop].item_detail.quality}><{else}>-<{/if}></td>
					<td><{if $rs[loop].item_detail.strengthen}><{$rs[loop].item_detail.strengthen}><{else}>-<{/if}></td>
					<td><{if $rs[loop].item_detail.jinglian}><{$rs[loop].item_detail.jinglian}><{else}>-<{/if}></td>
					
					<!--td><{$rs[loop].item_detail.hole}>,<{$rs[loop].item_detail.gem}></td-->
					
					<td><{$rs[loop].sell_type}></td>
					<td><{ if $rs[loop].sell_money }><{ $rs[loop].sell_money }> <{$lang->market->money}><{ elseif $rs[loop].sell_rmb }><{ $rs[loop].sell_rmb }> <{$lang->market->gold}><{ /if }></td>
					<td class="cmenu" title="<{ $rs[loop].role_name }>"><{ $rs[loop].role_name }></td>
					<{if $state eq 1}><td class="cmenu" title="<{ $rs[loop].b_role_name }>"><{ $rs[loop].b_role_name }></td><{/if}>
					<td><{ if $state eq 0}><{$lang->market->onSale}><{ elseif $state eq 1}><{$lang->market->sold}><{ else if $state eq 2 }><{$lang->market->cancel}><{ /if }></td>
					<{ if $type eq 3 }>
						<td><{ if $state eq 0 }><{ $rs[loop].onSaleDate }><{ else }><{ $rs[loop].dealDate }><{ /if }></td>
					<{ else }>
						<td><{ $rs[loop].mdate }></td>
					<{ /if }>
				</tr>
			<{/section}>
			<{elseif $type eq 5}>
				<span style="color:#00F"><{$lang->market->sellMoney}>:</span>
				<tr class="sell_money">
					<!--th><{$lang->market->order}></th-->
					<th><{$lang->market->sellNum}></th>
					<th><{$lang->market->price}></th>
					<th><{$lang->market->roleName}></th>
					<th><{$lang->player->status}></th>
					<th><{$lang->page->time}></th>
				</tr>
				<{section name=loop loop=$rs}>
					<{if $smarty.section.loop.rownum % 2 == 0}>
					<tr align="center" class='sell_money odd'>
					<{else}>
					<tr align="center" class="sell_money">
					<{/if}>
						<!--td><{ $rs[loop].market_id }></td-->
						<td><{ $rs[loop].sell_money }> <{$lang->market->money}></td>
						<td><{ $rs[loop].rmb }> <{$lang->market->gold}></td>
						<td class="cmenu" title="<{ $rs[loop].role_name }>"><{ $rs[loop].role_name }></td>
						<td><{ if $state eq 0}><{$lang->market->onSale}><{ elseif $state eq 1}><{$lang->market->sold}><{ else if $state eq 2 }><{$lang->market->cancel}><{ /if }></td>
						<td><{ $rs[loop].mdate }></td>
					</tr>
				<{/section}>
		<{/if}>	
		</form>
		<{else}>
		<tr>
			<th colspan='6'><{$lang->market->notFind}></th>
		</tr>
		<{/if}>
		</table>
		<{$pager_html}>
	</body>
</html>