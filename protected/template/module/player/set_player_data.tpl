<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link rel="stylesheet" href="/static/css/base.css" type="text/css">
<link rel="stylesheet" href="/static/css/style.css" type="text/css">
<script type="text/javascript" src="/static/js/jquery.min.js"></script>
<script language="javascript">
	$(document).ready(function(){

		//==========start  role form =====
//		$("#role_id").keydown(function(){
//			$("#role_name").val('');
//			$("#account_name").val('');
//		});
		$("#role_name").keydown(function(){
			$("#role_id").val('');
			$("#account_name").val('');
		});
		$("#account_name").keydown(function(){
			$("#role_id").val('');
			$("#role_name").val('');
		});
		//===============end role form =================
		$("#btnSetLoginDays").click(function(){
			if("" == $("input[name=login_days]").val()){
				alert("<{$lang->page->durLoginDays}><{$lang->verify->isNotNull}>");
				$("input[name=login_days]").focus();
				return false;
			}else if(0 > $("input[name=login_days]").val()){
				alert("<{$lang->verify->outOfValue}>");
				$("input[name=login_days]").val("");
				$("input[name=login_days]").focus();
				return false;
			}
			if(!confirm('<{$lang->verify->changeLoginDaysSure}>?')){
				return false;
			}
		});
		$("#btnSetFcm").click(function(){
			if(!confirm('<{$lang->verify->changeFCMStatusSure}>?')){
				return false;
			}
		});
		$("input[id*=btnSetTaskTime_]").click(function(){
			var pvalue = $(this).attr("pvalue");
			var obj = $("input[id=task_" + pvalue + "]");
			var name = $("td[id=task_name_" + pvalue + "]").html();
			if("" == obj.val() || 0 > obj.val() || obj.attr("maxtime")< obj.val()){
				alert("<{$lang->msg->range}>");
				obj.focus();
				return false;
			}
			if(!confirm(<{$lang->verify->changeSure}>)){
				return false;
			}
		});
		$("input[id*=btnSetSceneTime_]").click(function(){
			var pvalue = $(this).attr("pvalue");
			var obj = $("input[id=scene_"+pvalue+"]");
			var name = $("td[id=scene_name_" + pvalue + "]").html();
			if("" == obj.val() || 0 > obj.val() || parseInt(obj.attr("maxtime")) < parseInt(obj.val())){
				alert("<{$lang->msg->range}>");
				obj.focus();
				return false;
			}
			if(!confirm(<{$lang->verify->changeSure}>)){
				return false;
			}
		});
		$("input[id=btnSetZCJB]").click(function(){
			var zcjb = $("input[name=zcjb]").val();
			var maxtimes = $(this).attr("maxtimes");
			if("" == zcjb || 0 > zcjb || zcjb > maxtimes){
				alert("<{$lang->msg->range}>");
				$("input[name=zcjb]").focus();
				return false;
			}
			if(!confirm('<{$lang->verify->changeZCJBStatusSure}>?')){
				return false;
			}
		});
		$("input[id=btnSetHunt]").click(function(){
			var hunt1Cnt = $("input[name=hunt1Cnt]").val();
			var hunt2Cnt = $("input[name=hunt2Cnt]").val();
			var hunt3Cnt = $("input[name=hunt3Cnt]").val();
			hunt1Cnt = hunt1Cnt ? hunt1Cnt : 0;
			hunt2Cnt = hunt2Cnt ? hunt2Cnt : 0;
			hunt3Cnt = hunt3Cnt ? hunt3Cnt : 0;
			var total = parseInt(hunt1Cnt) + parseInt(hunt2Cnt) + parseInt(hunt3Cnt);
			var maxtimes = $(this).attr("maxtimes");
			if(total > maxtimes || 0 > total){
				alert("<{$lang->msg->range}>");
				return false;
			}
			if(!confirm('<{$lang->verify->changeWuhunStatusSure}>?')){
				return false;
			}
		});
		$("input[id=btnSetPKValue]").click(function(){
			var pkvalue = $("input[name=pkvalue]").val();
			if("" == pkvalue || 0 > pkvalue){
				alert("<{$lang->msg->range}>");
				$("input[name=pkvalue]").focus();
				return false;
			}
			if(!confirm('<{$lang->verify->changePKValueStatusSure}>?')){
				return false;
			}
		});
		$("input[id=btnSetJJCTimes]").click(function(){
			var jjctimes = $("input[name=jjctimes]").val();
			if("" == jjctimes || 0 > jjctimes){
				alert("<{$lang->msg->range}>");
				$("input[name=jjctimes]").focus();
				return false;
			}
			if(!confirm('<{$lang->verify->changeJJCTimesStatusSure}>?')){
				return false;
			}
		});
		$("input[id=btnSetLevel]").click(function(){
			var level = parseInt($("input[name=level]").val());
			var maxLevel = parseInt($(this).attr("maxlevel"));
			if("" == level || 0 > level || level > maxLevel){
				alert("<{$lang->msg->range}>");
				$("input[name=level]").focus();
				return false;
			}
			if(!confirm('<{$lang->verify->changeLevelStatusSure}>?')){
				return false;
			}
		});
	});
</script>

<title><{$lang->menu->alterPlayerData}></title>

</head>

<body>
<div id="position"><{$lang->menu->class->userInfo}>：<{$lang->menu->alterPlayerData}></div>
<form action="<{$smarty.const.URL_SELF}>" id="frm" method="POST" >
	<div class='divOperation'>
		<{$lang->player->roleName}>：<input type="text" name="role_name" id="role_name" value="<{$roleName}>" />
		<{$lang->player->accountName}>：<input type="text" name="account_name" id="account_name" value="<{$accountName}>" />
		<input type="image" name='search' src="/static/images/search.gif" class="input2" align="absmiddle"  />
	</div>
</form>
<br />
<div>
    <{if $strMsg}>
    	<tr>
    		<td colspan="4"><span style="color:red;"><{$strMsg}></span></td>
    	</tr>
    <{/if}>
</div>
<{if $result}>
<table style="width: 640px;" cellspacing="1" cellpadding="3" border="0" class="table_list" >
	<tr class='table_list_head'>
		<th width="100"><{$lang->page->options}></th>
		<th width="140"><{$lang->page->currentValue}></th>
		<th width="260"><{$lang->page->deal}></th>
		<th width="120"><{$lang->page->directions}></th>
	</tr>
	<tr class='<{cycle values="trEven,trOdd"}>'>
		<td><{$lang->page->level}></td>
		<td><{$result.level}></td>
		<td>
			<form action="<{$smarty.const.URL_SELF}>" method="POST">
				<input name="action" type="hidden" value="setLevel" />
				<input name="account_name" type="hidden" value="<{$accountName}>" />
				<input name="role_name" type="hidden" value="<{$roleName}>" />
    			<input type="text" style="text-align:center;" size="10" maxlength="4" name="level" id="level"> 
    			<input type="submit" id="btnSetLevel" value="<{$lang->page->update}>" maxlevel="<{$smarty.const.GAME_MAXLEVEL}>" />
			</form>
		</td>
		<td><{$lang->page->valueRange}>: 1 ≤ x ≤ <{$smarty.const.GAME_MAXLEVEL}></td>
	</tr>
	<tr class='<{cycle values="trEven,trOdd"}>'>
		<td><{$lang->page->durLoginDays}></td>
		<td><{$result.onLineDay}></td>
		<td>
			<form action="<{$smarty.const.URL_SELF}>" method="POST">
				<input name="action" type="hidden" value="setLoginDays" />
				<input name="account_name" type="hidden" value="<{$accountName}>" />
				<input name="role_name" type="hidden" value="<{$roleName}>" />
    			<input type="text" style="text-align:center;" size="10" maxlength="4" name="login_days" id="login_days"> 
    			<input type="submit" id="btnSetLoginDays" value="<{$lang->page->update}>"/>
			</form>
		</td>
		<td><{$lang->page->valueRange}>: 0 ≤ x</td>
	</tr>
	<tr class='<{cycle values="trEven,trOdd"}>'>
		<td><{$lang->verify->fcm}></td>
		<td><{$arrFcm[$result.fcm]}></td>
		<td>
			<form action="<{$smarty.const.URL_SELF}>" method="POST">
				<input name="action" type="hidden" value="setFcm" />
				<input name="account_name" type="hidden" value="<{$accountName}>" />
				<input name="role_name" type="hidden" value="<{$roleName}>" />
    			<input name="fcm" type="radio" value="1" <{if 1 == $result.fcm}>checked<{/if}> /><{$lang->verify->pass}>
    			<input name="fcm" type="radio" value="0" <{if 0 == $result.fcm}>checked<{/if}> /><{$lang->verify->notPass}>
    			<input type="submit" id="btnSetFcm" value="<{$lang->page->update}>"/>
			</form>
		</td>
		<td></td>
	</tr>
	<{if $result.taskTimes}>
	<{foreach from=$result.taskTimes key=key item=item}>
	<tr class='<{cycle values="trEven,trOdd"}>'>
		<td id="task_name_<{$key}>"><{$item.name}></td>
		<td><{$item.times}></td>
		<td>
			<form action="<{$smarty.const.URL_SELF}>" method="POST">
				<input name="action" type="hidden" value="setTaskTime" />
				<input name="account_name" type="hidden" value="<{$accountName}>" />
				<input name="role_name" type="hidden" value="<{$roleName}>" />
				<input name="task_id" type="hidden" value="<{$key}>" />
    			<input type="text" style="text-align:center;" size="10" maxlength="4" name="times" id="task_<{$key}>" maxtime="<{$item.maxtime}>" /> 
    			<input type="submit" id="btnSetTaskTime_<{$key}>" value="<{$lang->page->update}>" pvalue="<{$key}>" />
			</form>
		</td>
		<td><{$lang->page->valueRange}>: 0 ≤ x ≤ <{$item.maxtime}></td>
	</tr>
	<{/foreach}>
	<{/if}>
	<{if $result.sceneTimes}>
	<{foreach from=$result.sceneTimes key=key item=item}>
	<tr class='<{cycle values="trEven,trOdd"}>'>
		<td id="scene_name_<{$key}>"><{$item.name}></td>
		<td><{$item.times}></td>
		<td>
			<form action="<{$smarty.const.URL_SELF}>" method="POST">
				<input name="action" type="hidden" value="setSceneTime" />
				<input name="account_name" type="hidden" value="<{$accountName}>" />
				<input name="role_name" type="hidden" value="<{$roleName}>" />
				<input name="scene_id" type="hidden" value="<{$key}>" />
    			<input type="text" style="text-align:center;" size="10" maxlength="4" name="times" id="scene_<{$key}>" maxtime="<{$item.maxtime}>" /> 
    			<input type="submit" id="btnSetSceneTime_<{$key}>" value="<{$lang->page->update}>" pvalue="<{$key}>" />
			</form>
		</td>
		<td><{$lang->page->valueRange}>: 0 ≤ x ≤ <{$item.maxtime}></td>
	</tr>
	<{/foreach}>
	<tr class='<{cycle values="trEven,trOdd"}>'>
		<td><{$lang->page->zcjb}></td>
		<td><{$result.zcjbCount}></td>
		<td>
			<form action="<{$smarty.const.URL_SELF}>" method="POST">
				<input name="action" type="hidden" value="setZCJB" />
				<input name="account_name" type="hidden" value="<{$accountName}>" />
				<input name="role_name" type="hidden" value="<{$roleName}>" />
    			<input type="text" style="text-align:center;" size="10" maxlength="4" name="zcjb" id="zcjb"> 
    			<input type="submit" id="btnSetZCJB" value="<{$lang->page->update}>" maxtimes="20" />
			</form>
		</td>
		<td><{$lang->page->valueRange}>: 0 ≤ x ≤ 20</td>
	</tr>
	<tr class='<{cycle values="trEven,trOdd"}>'>
		<td><{$lang->page->pkvalue}></td>
		<td><{$result.pkvalue}></td>
		<td>
			<form action="<{$smarty.const.URL_SELF}>" method="POST">
				<input name="action" type="hidden" value="setPKValue" />
				<input name="account_name" type="hidden" value="<{$accountName}>" />
				<input name="role_name" type="hidden" value="<{$roleName}>" />
    			<input type="text" style="text-align:center;" size="10" maxlength="4" name="pkvalue" id="pkvalue"> 
    			<input type="submit" id="btnSetPKValue" value="<{$lang->page->update}>" maxtimes="20" />
			</form>
		</td>
		<td><{$lang->page->valueRange}>: 0 ≤ x</td>
	</tr>
	<tr class='<{cycle values="trEven,trOdd"}>'>
		<td><{$lang->page->jjc}></td>
		<td><{$result.jjctimes}>(<{$lang->page->remainTimes}>)</td>
		<td>
			<form action="<{$smarty.const.URL_SELF}>" method="POST">
				<input name="action" type="hidden" value="setJJCTimes" />
				<input name="account_name" type="hidden" value="<{$accountName}>" />
				<input name="role_name" type="hidden" value="<{$roleName}>" />
    			<input type="text" style="text-align:center;" size="10" maxlength="4" name="jjctimes" id="jjctimes"> 
    			<input type="submit" id="btnSetJJCTimes" value="<{$lang->page->update}>" maxtimes="20" />
			</form>
		</td>
		<td><{$lang->page->valueRange}>: 0 ≤ x</td>
	</tr>
	<tr class='<{cycle values="trEven,trOdd"}>'>
		<td><{$lang->wuhun->hunt}></td>
		<td colspan="2">
			<form action="<{$smarty.const.URL_SELF}>" method="POST">
			<table style="border: 0px;" cellspacing="1" cellpadding="3" border="0" class="table_list" >
				<tr>
					<td  width="140"><{$lang->wuhun->hunt1Cnt}>:<{$result.wuhunDB.hunt1Cnt}></td>
					<td><{$lang->wuhun->hunt1Cnt}>:<input type="text" style="text-align:center;" size="10" maxlength="4" name="hunt1Cnt" /><br /></td>
					<td rowspan="3" valign="center">
        				<input name="action" type="hidden" value="setHunt" />
        				<input name="account_name" type="hidden" value="<{$accountName}>" />
        				<input name="role_name" type="hidden" value="<{$roleName}>" />
    					<input type="submit" id="btnSetHunt" value="<{$lang->page->update}>" maxtimes="50" />
					</td>
				</tr>
				<tr>
					<td><{$lang->wuhun->hunt2Cnt}>:<{$result.wuhunDB.hunt2Cnt}></td>
					<td><{$lang->wuhun->hunt2Cnt}>:<input type="text" style="text-align:center;" size="10" maxlength="4" name="hunt2Cnt" /><br /></td>
				</tr>
				<tr>
					<td><{$lang->wuhun->hunt3Cnt}>:<{$result.wuhunDB.hunt3Cnt}></td>
					<td><{$lang->wuhun->hunt3Cnt}>:<input type="text" style="text-align:center;" size="10" maxlength="4" name="hunt3Cnt" /><br /></td>
				</tr>
			</table>
			</form>
		</td>
		<td>
			<{$lang->page->valueRange}>: 0 ≤ x ≤ 50<br />
			<span class="red"><{$lang->wuhun->valueRangeDesc}></span>
		</td>
	</tr>
	<{/if}>
</table>
<{/if}>
</body>
</html>