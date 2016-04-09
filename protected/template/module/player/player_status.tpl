<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset='UTF-8'" />
<link rel="stylesheet" href="/static/css/base.css" type="text/css">
<link rel="stylesheet" href="/static/css/style.css" type="text/css" />
<script type="text/javascript" src="/static/js/jquery.min.js"></script>
<script type="text/javascript" src="/static/js/ip.js"></script>
<script type="text/javascript" src="/static/js/global.js"></script>
<script language="javascript">
	$(document).ready(function(){

		//==========start  role form =====
		$("#role_id").keydown(function(){
			$("#role_name").val('');
			$("#account_name").val('');
		});
		$("#role_name").keydown(function(){
			$("#role_id").val('');
			$("#account_name").val('');
		});
		$("#account_name").keydown(function(){
			$("#role_id").val('');
			$("#role_name").val('');
		});
		//===============end role form =================
		$("#btnSendReturnHome").click(function(){
			if(confirm('<{$lang->page->sendPlayerToPeaceVillage}>?')){
				$("#frm").attr("action",'?action=sendPlayerToPeaceVillage').submit();
			}
		});
		$("#btnKick").click(function(){
			if(confirm('<{$lang->page->setPlayerOffLine}>?')){
//				$("#frm").attr("action",'?action=setPlayerOffLine').submit();
				$("#action").val("setPlayerOffLine");
				$("#frm").submit();
			}
		});
		$("#btnKickStall").click(function(){
			if(confirm('<{$lang->page->setPlayerShopOffLine}>?')){
				$("#frm").attr("action",'?action=setPlayerShopOffLine').submit();
			} else {alert("No!");}
		});
		$('.show-ip').click(function(){
			var ip = $(this).text();
			queryIP(ip);
		})
	});
</script>
<script type="text/javascript">
	isShow = 0;
	showKey = "";
	showType = "";
	
	function showRank(key,tp){
		var aid = "#pet_"+tp+"-"+key;
		var rid = "#pet_"+tp+"_show-"+key; 
	
		if( $(rid).length <= 0 ) {
			var rid = "#no_data";
		}
		
		if( isShow == 0 ){
								
			$(rid).show();
			
			isShow = 1;
			showKey = key;
			showType = tp;
			var offsetDayRank = $(aid).offset();
			$(rid).css("top",offsetDayRank.top+20).css("left",offsetDayRank.left);
		} else {
			if( showKey == key && showType == tp) {
				$(rid).hide();
				isShow = 0;
			} else {
				$("div.rank").hide();
				$("div.score").hide();
				$(rid).show();
				isShow = 1;
				showKey = key;
				showType = tp;
				var offsetDayRank = $(aid).offset();
				$(rid).css("top",offsetDayRank.top+20).css("left",offsetDayRank.left);
			}
		}
	}
	
	function hideRank() {
		$("div.rank").hide();
		$("div.score").hide();
		isShow = 0;
	}
</script>

<title><{$lang->menu->playerStatus}></title>

</head>

<body>
<div id="position"><{$lang->menu->class->userInfo}>：<{$lang->menu->playerStatus}></div>
<form action="?action=search" id="frm" method="get" >
	<table cellspacing="1" cellpadding="5" class="SumDataGrid" width="800">
		<tr>
			<input type="hidden" id="action" name="action" value="search"/>
			<td align="right"><{$lang->page->roleName}>：</td>
			<td><input type="text" name="role[role_name]" id="role_name" value="<{$role.role_name}>" /></td>
			<td align="right"><{$lang->page->accountName}>：</td>
			<td><input type="text" name="role[account_name]" id="account_name" size="40" value="<{$role.account_name}>" /></td>
			<td><input type="image" name='search' src="/static/images/search.gif" class="input2"  /></td>
		</tr>
	</table>
	<br />
	<{if 1 == $roleInfo.is_online}>
	<table class="DataGrid" cellspacing="0">
		<tr>
			<th><input type="button" name="btnKick" id="btnKick" value="<{$lang->page->offLine}>" /></th>
	    </tr>
	</table>
	<br />
	<{/if}>
</form>
<{if $strMsg}>
<table cellspacing="1" cellpadding="5" class="DataGrid">
	<tr>
		<td><span style="color:red;"><{$strMsg}></span></td>
	</tr>
</table>
<br />
<{/if}>

<{if $role}>
<!--  Start  账号信息-->
<table class="DataGrid" cellspacing="0" style="margin-bottom:20px;">
	<tr><th colspan="14" style="font-size:14px; color:#F00;"><b><{$lang->page->accountInfo}></b></th></tr>
	<{ if $roleInfo }>
	<tr>
		<th><{$lang->page->accountName}></th>
		<th><{$lang->page->roleName}></th>
		<th><{$lang->page->sex}></th>
		<th><{$lang->page->job}></th>
		<th><{$lang->page->level}></th>
		<th>VIP<{$lang->page->level}></th>
		<th><{$lang->page->sign}></th>
		<th><{$lang->page->mateName}></th>
		<th><{$lang->page->map}></th>
		<th><{$lang->page->ordinate}></th>
		<th><{$lang->player->registerTime}></th>
		<th><{$lang->page->lastLoginTime}></th>
		<th><{$lang->page->lastLogoutTime}></th>
        <th><{$lang->page->lastLoginIp}></th>
  <{*      <th><{$lang->page->lastLoginPoint}></th> *}>

	</tr>
    <tr align="center" <{ if 0==$smarty.section.i.index %2 }> class="odd"<{ /if }>>

		<td class="cmenu" title="<{$roleInfo.rolename}>"><{$roleInfo.account}></td>
		<td class="cmenu" title="<{$roleInfo.rolename}>"><{$roleInfo.rolename}></td>
		<td><{$roleInfo.sex}></td>
		<td><{$roleInfo.job}></td>
		<td><{$roleInfo.level}></td>
		<td><{$roleInfo.vipLevel}></td>
		<td><{$roleInfo.sign}></td>
		<td><{$roleInfo.mateName}></td>
		<td><{ $dictMap[$roleInfo.mapid].name}></td>
		<td>x:<{$roleInfo.x}>, y:<{$roleInfo.y}></td>
		<td><{$roleInfo.register_time|date_format:'%Y-%m-%d %H:%M:%S' }></td>
		<td><{$roleInfo.login_time|date_format:'%Y-%m-%d %H:%M:%S' }></td>
		<td><{$roleInfo.logout_time|date_format:'%Y-%m-%d %H:%M:%S'}></td>
        <td><a href="javascript:void(0)" class="show-ip"><{$roleInfo.login_ip}></a></td>
    <{*       <td><a href="http://www.ip138.com/ips.asp?ip=<{$roleInfo.login_ip}>"><{$lang->page->clickHere}></a></td>*}>
	</tr>

	<{ else }>
    <tr><td colspan="11"><{$lang->page->noData}></td></tr>
    <{ /if }>
</table>
<!--  End  账号信息-->

<!--  Start  玩家在线信息-->
<table class="DataGrid" cellspacing="0" style="margin-bottom:20px;">
	<tr><th colspan="13" style="font-size:14px; color:#F00;"><b><{$lang->page->onlineTime}></b></th></tr>
	<{ if $roleInfo }>
	<tr>
        <th><{$lang->page->onlineStatus}></th>
		<th><{$lang->page->durLoginDays}></th>
		<th><{$lang->page->onlineTotalTime}></th>
        <th><{$lang->page->onlineSevenDayTime}></th>
        <{foreach from=$arrOnlineTime item=item key=key}>
        <th><{$key}></th>
        <{/foreach}>

	</tr>
    <tr align="center" <{ if 0==$smarty.section.i.index %2 }> class="odd"<{ /if }>>
		<td><{if 1 == $roleInfo.is_online}><font color="green"><{$lang->page->online}></font><{ elseif $roleInfo.in_middle == 1 }><font color="blue"><{$lang->page->middle}></font><{else}><font color="red"><{$lang->page->offline}></font><{/if}></td>
		<td><{$roleInfo.onlineDays}></td>
		<td><{$roleInfo.all_online_time|string_format:'%.2f'}>(min)</td>
        <td><{$roleInfo.online_time|string_format:'%.2f'}>(min)</td>
        <{foreach from=$arrOnlineTime item=item key=key}>
		<td><{$item|string_format:'%.2f'}>(min)</td>
        <{/foreach}>
	</tr>

	<{ else }>
    <tr><td colspan="11"><{$lang->page->noData}></td></tr>
    <{ /if }>
</table>
<!--  End  玩家在线信息-->

<!--  Start  玩家货币信息-->
<table class="DataGrid" cellspacing="0" style="margin-bottom:20px;">
	<tr><th colspan="12" style="font-size:14px; color:#F00;"><b><{$lang->currency->moneyInfo}></b></th></tr>
	<{ if $roleInfo }>
	<tr>
		<th><{$lang->page->totalConsumeMoney}></th>
		<th><{$lang->page->totalConsumePubacct}></th>
        <th><{$lang->currency->yuanbao}></th>
		<th><{$lang->currency->totalBuyXianshi}></th>
		<th><{$lang->currency->historyTotalYBUsed}></th>
		<th><{$lang->currency->liquan}></th>
		<th><{$lang->currency->historyTotalLQ}></th>
		<th><{$lang->currency->historyTotalLQUsed}></th>
		<th><{$lang->currency->paySilverUnbind}></th>
        <th><{$lang->currency->lingqi}></th>
        <th><{$lang->currency->tiancheng}></th>
        <th><{$lang->player->xianzunExp}></th>

	</tr>
    <tr align="center" <{ if 0==$smarty.section.i.index %2 }> class="odd"<{ /if }>>

		<td><{$roleInfo.total_pay_rmb}></td>
		<td><{$roleInfo.total_use_pubacct}></td>
        <td><{$roleInfo.money}></td>
		<td><{$roleInfo.total_buy_xianshi}></td>
		<td><{$roleInfo.total_use_gold}></td>
		<td><{$roleInfo.liquan}></td>
		<td><{$roleInfo.total_get_liquan}></td>
		<td><{$roleInfo.total_use_liquan}></td>
		<td><{$roleInfo.silver}></td>
        <td><{$roleInfo.lingqi}></td>
        <td><{$roleInfo.tiancheng}></td>
        <td><{$roleInfo.xianzunExp}></td>
	</tr>

	<{ else }>
    <tr><td colspan="11"><{$lang->page->noData}></td></tr>
    <{ /if }>
</table>
<!--  End  玩家货币信息-->

<!--  Start  玩家炼体信息-->
<table class="DataGrid" cellspacing="0" style="margin-bottom:20px;">
	<tr><th colspan="13" style="font-size:14px; color:#F00;"><b><{$lang->page->lianti}></b></th></tr>
	<{ if $roleInfo }>
	<tr>
        <th><{$lang->page->alchemyLv}></th>
		<th><{$lang->page->subLv}></th>
		<th><{$lang->page->veinLv}></th>

	</tr>
    <tr align="center" <{ if 0==$smarty.section.i.index %2 }> class="odd"<{ /if }>>
		<td><{$roleInfo.alchemyLv}></td>
		<td><{$roleInfo.subLv}></td>
		<td><{$roleInfo.veinLv}></td>

	</tr>

	<{ else }>
    <tr><td colspan="11"><{$lang->page->noData}></td></tr>
    <{ /if }>
</table>
<table class="DataGrid" cellspacing="0" style="margin-bottom:20px;">
	<tr><th colspan="13" style="font-size:14px; color:#F00;"><b><{$lang->page->huntlife}></b></th></tr>
	<{ if $roleInfo.huntlife }>
	<{*
	<tr align="center" >
		<th width="15%" ><{$lang->page->huntlife}>ID</th>
		<{foreach from=$roleInfo.huntlife key=key item=item}>
			<td><{$item.id}></td>
		<{/foreach}>
	</tr>
	*}>
	<tr align="center" >
        <th><{$lang->page->huntlifeName}></th>
		<{foreach from=$roleInfo.huntlife key=key item=item}>
			<td><{$item.name}></td>
		<{/foreach}>
	</tr>
	<tr align="center" >
		<th><{$lang->page->level}></th>
		<{foreach from=$roleInfo.huntlife key=key item=item}>
			<td><{$item.lv}></td>
		<{/foreach}>
	</tr>

	<{ else }>
    <tr><td colspan="11"><{$lang->page->noData}></td></tr>
    <{ /if }>
</table>
<!--  End  玩家炼体信息-->

<!--  Start  角色属性信息-->
<font color="#FF0000"></font>
<table class="DataGrid" cellspacing="0" style="margin-bottom:20px;">
	<tr><th colspan="11" style="font-size:14px; color:#F00;"><b><{$lang->player->roleBaseInfo}></b></th></tr>
	<{ if $attribute }>
	
	<{ foreach from=$attribute key=key item=value }>
		<{ if ($key%4 == 1) }> 
			<tr align="center">
		<{/if}>
			<th><{ $value.name }></th><td><{ $value.value }></td>
		<{ if (($key)%4 == 0) }> 
			</tr>
		<{/if}>
	<{/foreach}>
		<th></th><td></td>
		<th></th><td></td>
	</tr>


	<{ else }>
    <tr><td colspan="11"><{$lang->page->noData}></td></tr>
    <{ /if }>
</table>
<!--  End  角色属性信息-->


<!--  Start  玩家BUFF信息-->
<table class="DataGrid" cellspacing="0">
	<tr><th colspan="8" style="font-size:14px; color:#F00;"><b>BUFF</b></th></tr>
	<{ if $buffers }>
	<tr>
		<th>BUFF ID</th>
		<th>BUFF Name</th>
		<th>BUFF <{$lang->page->lastingTime}></th>
        <th>BUFF <{$lang->player->total}><{$lang->page->lastingTime}></th>
		<th><{$lang->page->beginTime}></th>
		<th><{$lang->page->endTime}></th>
	</tr>
	<{foreach from=$buffers item=buffs}>
	<tr align="center" <{ if 0==$smarty.section.i.index %2 }> class="odd"<{ /if }>>
		<td><{ $buffs.id}></td>
		<td><{ $buffs.name}></td>
		<td><{ $buffs.timer}></td>
        <td><{ $buffs.keeptime}></td>
		<td><{ $buffs.starttime}></td>
		<td><{ $buffs.endtime}></td>
	</tr>
	<{ /foreach }>
	<{ else }>
    <tr><td colspan="11"><{$lang->page->noData}></td></tr>
    <{ /if }>
</table>
<br />
<!--  End  玩家BUFF信息--> 

<!-- start 装备列表 -->
<table class="DataGrid" cellspacing="0">
	<tr><th colspan="20" style="font-size:14px; color:#F00;"><{$lang->player->equipList}></th></tr>
	<{ if $equips }>
	<tr>
		<th width="45px"><{$lang->item->itemID}></th>
		<th width="140px"><{$lang->item->itemUID}></th>
		<th width="65px"><{$lang->item->itemName}></th>
		<th width="85px"><{$lang->item->pos}></th>
		<th width="65px"><{$lang->page->isBind}></th>
		<th width="65px"><{$lang->item->qualityLv}></th>
		<th width="65px"><{$lang->page->strLevel}></th>
		<th width="85px"><{$lang->item->craftLv}></th>
		<th width="85px"><{$lang->item->randAttrStar}></th>
		<th width="85px"><{$lang->item->vipAttrStar}></th>
		<th width="110px"><{$lang->item->xilianRandCnt}></th>
		<th width="110px"><{$lang->item->xilianVipCnt}></th>
		
		<th width="85px"><{$lang->item->refineCaiCnt}></th>
		<th width="85px"><{$lang->item->refineJingCnt}></th>
		<th width="85px"><{$lang->item->refineCnt}></th>
		<th width="85px"><{$lang->item->refineTongCnt}></th>
		<th width="85px"><{$lang->item->gem2ID}></th>
		
		<th width="65px"><{$lang->item->gem}></th>
		<th width="120px"><{$lang->item->randAttr}></th>
	</tr>

	<{foreach from=$equips item=row}>
    <{if $key%2==0}>
    <tr class="odd" align="center">
    <{else}>
    <tr align="center">
    <{/if}>
		<td><{$row.itemindex}></td>
		<td><{$row.uid}></td>
		<td style="color:<{$row.EquipColorValue}>"><{$row.EquipName}></td>
		<td><{$row.pos}></td>
		<td><{$row.isBind}></td>
		<td><{$row.quality}></td>
		<td><{$row.strengthen}></td>
		<td><{$row.craftLv}></td>
		<td><{$row.randAttrStar}></td>
		<td><{$row.vipAttrStar}></td>
		<td><{$row.xilianRandCnt}></td>
		<td><{$row.xilianVipCnt}></td>
		
		<td><{$row.refineCaiCnt}></td>
		<td><{$row.refineJingCnt}></td>
		<td><{$row.refineCnt}></td>
		<td><{$row.refineTongCnt}></td>
		<td><{$row.gem2ID}></td>
		
		<td><{if $row.GemCount}><{$row.GemName}><{else}><{$lang->page->null}><{/if}></td>
		<td><{ if $row.randAttrCnt!=0 }><{$row.randAttr}><{else}><{$lang->page->null}><{/if}></td>
	</tr>
    <{/foreach}>
    <{ else }>
    <tr><td colspan="11"><{$lang->page->noData}></td></tr>
    <{ /if }>
</table>
<br />
<!-- end 装备列表 -->

<!-- start 宝石列表 -->
<table class="DataGrid" cellspacing="0">
	<tr><th colspan="7" style="font-size:14px; color:#F00;"><{$lang->player->stoneList}></th></tr>
	<{ if $stones }>
	<tr>
		<th><{$lang->item->itemID}></th>
		<th><{$lang->item->itemName}></th>
		<th><{$lang->page->itemsNum}></th>
		<th><{$lang->item->pos}></th>
		<th><{$lang->page->isBind}></th>
	</tr>
	<{foreach from=$stones item=stone key=key}>
	<tr align="center" <{ if 0==$smarty.section.i.index %2 }> class="odd"<{ /if }>>
		<td><{ $stone.itemindex}></td>
		<td style="color:<{$stone.StonesColorValue}>"><{ $stone.name}></td>
		<td><{ $stone.itemcount}></td>
		<td><{ $stone.pos}></td>
		<td><{ $stone.isbind}></td>
	</tr>
	<{ /foreach }>
	<{ else }>
    <tr><td colspan="7"><{$lang->page->noData}></td></tr>
    <{ /if }>
</table>
<br />
<!-- end 宝石列表 -->

<!-- start 普通物品列表 -->
<table class="DataGrid" cellspacing="0">
	<tr><th colspan="7" style="font-size:14px; color:#F00;"><{$lang->player->itemsList}></th></tr>
	<{ if $oitems }>
	<tr>
		<th><{$lang->item->itemID}></th>
		<th><{$lang->item->itemName}></th>
		<th><{$lang->page->itemsNum}></th>
		<th><{$lang->item->pos}></th>
		<th><{$lang->page->isBind}></th>
	</tr>
	<{foreach from=$oitems item=item key=key}>
	<tr align="center"<{ if 0==$smarty.section.i.index %2 }> class="odd"<{ /if }>>
		<td><{ $item.itemindex}></td>
		<td style="color:<{$item.OitemColorValue}>"><{ $item.name  }></td>
		<td><{ $item.itemcount}></td>
		<td><{ $item.pos}></td>
		<td><{ $item.isbind}></td>
	</tr>
	<{ /foreach }>
	<{ else }>
    <tr><td colspan="7"><{$lang->page->noData}></td></tr>
    <{ /if }>
</table>
<!-- end 普通物品列表 -->
</br>
<!-- start 寄卖信息列表 -->
<table class="DataGrid" cellspacing="0">
	<tr><th colspan="7" style="font-size:14px; color:#F00;"><{$lang->player->onSaleList}></th></tr>
	<{ if $market }>
	<tr>
		<th><{$lang->item->itemName}></th>
		<th><{$lang->item->itemID}></th>
		<th><{$lang->page->itemsNum}></th>
		<th><{$lang->market->price}></th>
		<th><{$lang->market->leftTime}></th>
	</tr>
	<{foreach from=$market item=item key=key}>
	<tr align="center"<{ if 0==$smarty.section.i.index %2 }> class="odd"<{ /if }>>
		<td style="color:<{$item.OitemColorValue}>"><{ $item.name  }></td>
		<td><{ $item.id}></td>
		<td><{ $item.count}></td>
		<td><{ $item.price}> <{ $item.currencyType}></td>
		<td><{math equation="x/60/60/24" x=$item.leftTime format="%d"}>天 <{math equation="x/60/60" x=$item.leftTime format="%d"}>小时 <{math equation="x/60" x=$item.leftTime format="%d" }>分 <{math equation="x%60" x=$item.leftTime format="%d"}>秒</td>
	</tr>
	<{ /foreach }>
	<{ else }>
    <tr><td colspan="7"><{$lang->page->noData}></td></tr>
    <{ /if }>
</table>

<!-- end 寄卖信息列表 -->

</br>
<!-- start 境界信息列表 -->
<table class="DataGrid" cellspacing="0">
	<tr><th colspan="10"><span style="font-size:14px; color:#F00;"><{$lang->player->jingjieInfo}></span>
		<br /><{$lang->jingjie->jingjie}><{$lang->jingjie->level}>ID: <span style="color:blue;"><{$jingjie.id}></span>
	</th>
	</tr>

	<tr><td align="center" colspan="<{math equation="x+y" x=$jingjie.skills|@count y=2 }>"><{$lang->jingjie->skillInfo}></td></tr>
	
	<tr>
		<td align="right" style="width:20%;"><b><{$lang->jingjie->skill}>ID</b></td>
		<{foreach from=$jingjie.skills item=jjskill key=key name=jj}>
		<td  align="left" style="color:blue;">&nbsp;<{$jjskill.id}></td>
		<{/foreach}>
		<td>&nbsp;</td>
	</tr>

	<tr>
		<td align="right"><b><{$lang->skill->skillName}></b></td>
		<{foreach from=$jingjie.skills item=jjskill key=key name=jj}>
		<td  align="left" style="color:blue;">&nbsp;<{$jjskill.name}></td>
		<{/foreach}>
		<td>&nbsp;</td>
	</tr>
	
	<tr align="center">
		<td align="right"><b><{$lang->skill->skillLevel}></b></td>
		<{foreach from=$jingjie.skills item=jjskill key=key name=jj}>
		<td  align="left" style="color:blue;">&nbsp;<{$jjskill.lv}></td>
		<{/foreach}>
		<td>&nbsp;</td>
	</tr>
	
</table>

<!-- end 境界信息列表 -->

</br>
<!-- start 技能快捷栏信息 -->
<table class="DataGrid" cellspacing="0">
	<tr><th colspan="7" style="font-size:14px; color:#F00;"><{$lang->skill->skillBarData}></th></tr>
	<{if $skillBar}>
	<tr>
		<th style="width:10%"><{$lang->skill->skillBarId}></th>
		<th style="width:20%"><{$lang->skill->skillName}></th>
		<th style="width:20%"><{$lang->skill->skillLevel}></th>
		<th style="width:20%"><{$lang->skill->element}></th>
	</tr>
	
	<{foreach from=$skillBar item=skill key=key}>
	<tr align="center">
		<td><{$key}></td>
		<td><{$skill.name}></td>
		<td><{$skill.level}></td>
		<td><{$skill.element}></td>
	</tr>
	<{ /foreach }>
	
	<{else}>
	<tr><td colspan="7"><{$lang->page->noData}></td></tr>
	<{/if}>
</table>
<!-- end 技能快捷栏信息 -->
<br />
<!-- start 法宝信息 -->
<table class="DataGrid" cellspacing="0">
	<tr><th colspan="7" style="font-size:14px; color:#F00;"><{$lang->talisman->talismanInfo}></th></tr>
	<{if $talisman}>
	<tr>
		<th style="width:20%"><{$lang->talisman->talismanLevel}></th>
		<th style="width:80%"><{$lang->talisman->illusionTalisman}></th>
	</tr>
	
	<tr align="center">
		<td><{$talisman.level}></td>
		<td><{$talisman.list}></td>
	</tr>
	
	<{else}>
	<tr><td colspan="7"><{$lang->page->noData}></td></tr>
	<{/if}>
</table>
<!-- end 法宝信息 -->

<br />
<!--  Start  角色宠物信息-->
<table class="DataGrid" cellspacing="0" style="margin-bottom:20px;">
	<tr><th colspan="20" style="font-size:14px; color:#F00;"><b><{$lang->pet->petInfo}></b></th></tr>
	<{ if $pets }>
    	<{foreach from=$pets key=key item=item}>
	<tr>
    	<th rowspan="3">ID</th>
    	<th rowspan="3"><{$lang->pet->petName}></th>
    	<th rowspan="3"><{$lang->pet->originalName}></th>
    	<th rowspan="3"><{$lang->pet->level}></th>
    	<th rowspan="3"><{$lang->pet->petId}></th>
    	<th rowspan="3"><{$lang->pet->skillData}></th>
    	<th rowspan="3"><{$lang->pet->equipData}></th>
    	<th rowspan="2"><{$lang->pet->trend}></th>
    	<th rowspan="2"><{$lang->pet->jingjieLv}></th>
    	<th rowspan="2"><{$lang->pet->jingjieCnt}></th>
    	<th rowspan="2"><{$lang->pet->tianfuLv}></th>
    	<th colspan="6"><{$lang->pet->zizhi}></th>
    </tr>
	<tr>
    	<th><{$lang->pet->liliang}></th>
    	<th><{$lang->pet->zhihui}></th>
    	<th><{$lang->pet->lingmin}></th>
    	<th><{$lang->pet->gongji}></th>
    	<th><{$lang->pet->fangyu}></th>
    	<th><{$lang->pet->tili}></th>
    </tr>
    <tr align="center" class="<{if $key%2==0}>trEven<{else}>trOdd<{/if}>">
        <td><{ $dictPetTrend[$item.qingxiang]}></td>
        <td><{ $item.jingjie_id}></td>
        <td><{ $item.jingjie_cnt}></td>
        <td><{ $item.tianfu_lv}></td>
        <td><{ $item.zizhi_liliang|string_format:"%d"}></td>
        <td><{ $item.zizhi_zhihui|string_format:"%d"}></td>
        <td><{ $item.zizhi_lingmin|string_format:"%d"}></td>
        <td><{ $item.zizhi_gongji|string_format:"%d"}></td>
        <td><{ $item.zizhi_fangyu|string_format:"%d"}></td>
        <td><{ $item.zizhi_tili|string_format:"%d"}></td>
    </tr>
	
	<tr align="center">
    	<td rowspan="3"><{ $key+1}></td>
    	<td rowspan="3"><{ $item.nickname}></td>
    	<td rowspan="3"><{ $item.name}></td>
        <td rowspan="3"><{ $item.lv}></td>
        <td rowspan="3"><{ $item.id}></td>
        <td rowspan="3"><a id="pet_skill-<{$key}>" href="javascript:showRank('<{$key}>','skill');" style="color:#215868;text-decoration:underline;"><{ $lang->pet->look }></a></td>
        <td rowspan="3"><a id="pet_equip-<{$key}>" href="javascript:showRank('<{$key}>','equip');" style="color:#215868;text-decoration:underline;"><{ $lang->pet->look }></a></td>
		
		<th rowspan="1" colspan="10"><{$lang->pet->fightAttr}></th>
	</tr>
	
	<tr>
		<th><{$lang->pet->shengming}></th>
		
		<th><{$lang->pet->liliang}></th>
    	<th><{$lang->pet->zhihui}></th>
    	<th><{$lang->pet->lingmin}></th>
		
    	<th><{$lang->pet->gongji}></th>
    	<th><{$lang->pet->mingzhong}></th>
    	<th><{$lang->pet->baoji}></th>
		
    	<th><{$lang->pet->fangyu}></th>
    	<th><{$lang->pet->shanbi}></th>
    	<th><{$lang->pet->renxing}></th>
	</tr>
	<tr align="center">
		<td><{$item.tili|string_format:"%d"}></td>
		
		<td><{$item.liliang|string_format:"%d"}></td>
		<td><{$item.zhihui|string_format:"%d"}></td>
		<td><{$item.lingmin|string_format:"%d"}></td>
		
		<td><{$item.gongji|string_format:"%d"}></td>
		<td><{$item.mingzhong|string_format:"%d"}></td>
		<td><{$item.baoji|string_format:"%d"}></td>

		<td><{$item.fangyu|string_format:"%d"}></td>
		<td><{$item.shanbi|string_format:"%d"}></td>
		<td><{$item.renxing|string_format:"%d"}></td>
	</tr>
	<tr><td colspan="20"> </td></tr>
    	<{/foreach}>
	<{else}>
	<tr><td colspan="20"><{$lang->page->noData}></td></tr>
	<{ /if }>
</table>
<!--  End  角色宠物信息-->

<br />
<!--  Start  宠物技能-->
<table class="DataGrid" cellspacing="0" style="margin-bottom:20px;" style="width:600px;">
	<tr><th colspan="4" style="font-size:14px; color:#F00;"><b><{$lang->pet->petSkillData}></b></th></tr>
	<{ if $petSkill}>
	<tr>
		<th>ID</th>
		<th><{$lang->pet->skillId}></th>
		<th><{$lang->pet->skillName}></th>
		<th><{$lang->pet->skillLv}></th>
	</tr>
    	<{foreach from=$petSkill key=key item=item}>
	<tr align="center">
		<td><{$key+1}></td>
		<td><{$item.id}></td>
		<td><{$item.name}></td>
		<td><{$item.lv}></td>
	</tr>
    	<{/foreach}>
	<{else}>
	<tr><td colspan="4"><{$lang->page->noData}></td></tr>
	<{ /if }>
</table>
<!--  End  宠物技能-->

<!--  Start  宠物装备&技能信息-->
<{foreach from=$pets item=pet name=pet_data key=key}>
	<{if $pet.equip}>
<div id="pet_equip_show-<{$key}>" class="rank" style="width:645px" >
	<div class="rank_thead" style="width:645px" >
		<table>
			<tr >
				<th style="width:80px">No.</th>
				<th style="width:80px"><{$lang->item->itemID}></th>
				<th style="width:80px"><{$lang->item->itemName}></th>
				<th style="width:80px"><{$lang->item->qualityLv}></th>
				<th style="width:80px"><{$lang->page->strLevel}></th>
				<th style="width:80px"><{$lang->item->refineCnt}></th>
				<th style="width:120px"><{$lang->item->gem}></th>
				<th style="width:45px"><input type="button" value="<{$lang->page->close}>" onclick="javascript:hideRank();" /></th>
			</tr>
		</table>
	</div>
	<div class="rank_tbody" style="width:645px" >
		<table>
			<{foreach from=$pet.equip item=rank name=rank_data key=rankKey}>
			<tr class="rank_list" align="center">
				<td style="width:80px"><{$rankKey+1}></td>
				<td style="width:80px"><{$rank.id}></td>
				<td style="width:80px"><{$arrItemsAll[$rank.id].name}></td>
				<td style="width:80px"><{$rank.quality}></td>
				<td style="width:80px"><{$rank.strengthen}></td>
				<td style="width:80px"><{$rank.refineCnt}></td>
				<td style="width:120px"><{$lang->item->hole1}>:<{if $rank.gem.0}><{$arrItemsAll[$rank.gem.0].name}><{else}>-<{/if}>,<{$lang->item->hole2}>:<{if $rank.gem.1}><{$arrItemsAll[$rank.gem.1].name}><{else}>-<{/if}></td>
				<td style="width:45px"></td>
			</tr>
			<{/foreach}>
		</table>
	</div>
</div>
	<{else}>
<div id="no_data" class="rank"><{$lang->page->noData}></div>
	<{/if}>
	
	<{if $pet.skill}>
<div id="pet_skill_show-<{$key}>" class="rank" style="width:285px" >
	<div class="rank_thead" style="width:285px" >
		<table>
			<tr >
				<th style="width:80px">No.</th>
				<th style="width:80px"><{$lang->skill->skillId}></th>
				<th style="width:80px"><{$lang->skill->skillName}></th>
				<th style="width:45px"><input type="button" value="<{$lang->page->close}>" onclick="javascript:hideRank();" /></th>
			</tr>
		</table>
	</div>
	<div class="rank_tbody" style="width:285px" >
		<table>
			<{foreach from=$pet.skill item=rank name=rank_data key=rankKey}>
			<tr class="rank_list" align="center">
				<td style="width:80px"><{$rankKey+1}></td>
				<td style="width:80px"><{$rank.id}></td>
				<td style="width:80px"><{$rank.name}></td>
				<td style="width:45px"></td>
			</tr>
			<{/foreach}>
		</table>
	</div>
</div>
	<{else}>
<div id="no_data" class="rank"><{$lang->page->noData}></div>
	<{/if}>
	
<{/foreach}>

<!--  End  宠物装备&技能信息-->


<br />
<!--  Start  仙羽信息-->
<table class="DataGrid" cellspacing="0" >
	<tr><th colspan="15" style="font-size:14px; color:#F00;"><{$lang->wing->info}></th></tr>
	
	<{ if $wing}>
	<tr><th colspan="15" >
		<{$lang->wing->level}>: <span style="color:blue;"><{$wing.lv}></span>&nbsp;<{$lang->wing->ji}>,
	 	<{$lang->wing->ownWing}>: <{if $wing.list}><{foreach from=$wing.list key=key item=item}><span style="color:blue;"><{$item.name}></span>,&nbsp;<{/foreach}><{/if}>
	 </th></tr>
	
	<tr align="center">
		<th rowspan="2" width="10%"><{$lang->wing->shentongLevel}></th>
    	<{foreach from=$wing.shentong key=key item=item}>
			<td><{$dictWingShentong[$key]}></td>
    	<{/foreach}>
	</tr>
	<tr align="center">
    	<{foreach from=$wing.shentong key=key item=item}>
			<td><{if $item == 0 }><span style="color:#F55;"><{$lang->wing->unActived}></span><{else}><{$item}>&nbsp;<{$lang->wing->ji}><{/if}></td>
    	<{/foreach}>
	</tr>
	<{else}>
	<tr><td colspan="4"><{$lang->page->noData}></td></tr>
	<{ /if }>
</table>
<br />
<!--  End  仙羽信息-->

<{/if}>
</body>
</html>