<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="/static/css/base.css" type="text/css">
<link rel="stylesheet" href="/static/css/style.css" type="text/css">
<script type="text/javascript" src="/static/js/jquery-1.5.1.min.js"></script>
<script type="text/javascript" src="/static/js/My97DatePicker/WdatePicker.js"></script>
<script type="text/javascript" >
$(document).ready(function(){
	$("#accountName").keydown(function(){
    	$("#roleName").val('');
    	$("#roleId").val('');
    });
    $("#roleName").keydown(function(){
    	$("#accountName").val('');
    	$("#roleId").val('');
    });
    $("#roleId").keydown(function(){
    	$("#accountName").val('');
    	$("#roleName").val('');
    });
});
function changeDate(dateStr,dateEnd){
	if(dateEnd==''){
		$("#starttime").val(dateStr);
		$("#endtime").val(dateStr);
	}else{
		$("#starttime").val(dateStr);
		$("#endtime").val(dateEnd);
	}
	$("#myform").submit();
}
function load_out(){
		$("#excel").val('true');
		$("#myform").submit();
		$("#excel").val('');
}
</script>
<style type="text/css">
	.hr_red{
		background-color:red;
		width:6px;
	}
</style>
</head>
<title><{$lang->menu->paySort}></title>

<body>
<div id="position">
<b><{$lang->menu->class->userInfo}>：<{$lang->menu->strengthenLv}></b>
</div>
<div class='divOperation'>
<form name="myform" id="myform" method="post" action="<{$smarty.const.URL_SELF}>">
	<{$lang->page->roleName}>:<input type="text" id="roleName" name="role[roleName]" size="10" value="<{$role.roleName}>" />
	<{$lang->page->accountName}>:<input type="text" id="accountName" name="role[accountName]" size="10" value="<{$role.accountName}>" />
	<{$lang->page->beginTime}>:<input id='starttime' name='starttime' type="text" class="Wdate" onfocus="WdatePicker({el:'starttime',dateFmt:'yyyy-MM-dd',minDate:'<{$minDate}>',maxDate:'#F{$dp.$D(\'endtime\')}'})" size='12' value='<{$startDate}>' />
	<{$lang->page->endTime}>:<input id='endtime' name='endtime' type="text" class="Wdate" onfocus="WdatePicker({el:'endtime',dateFmt:'yyyy-MM-dd',minDate:'#F{$dp.$D(\'starttime\')}',maxDate:'<{$maxDate}>'})" size='12' value='<{$endDate}>' /> &nbsp;
	<label><{$lang->gold->dec_send_gold}><input type="checkbox" name="filter" <{if $filter}>checked<{/if}> /></label>
	<input id="search" name="search" type="hidden" value="search" />&nbsp;
	<input type="image" src="/static/images/search.gif" class="input2" align="absmiddle" />&nbsp;
	<input type="button" class="button" name="dateToday" value="<{$lang->page->today}>" onclick="changeDate('<{$dateStrToday}>','');">&nbsp;&nbsp;
	<input type="button" class="button" name="datePrev" value="<{$lang->page->prevTime}>" onclick="changeDate('<{$dateStrPrev}>','');">&nbsp;&nbsp;
	<input type="button" class="button" name="dateNext" value="<{$lang->page->nextTime}>" onclick="changeDate('<{$dateStrNext}>','');">&nbsp;&nbsp;
	<input type="button" class="button" name="dateAll" value="<{$lang->page->fromOnlineDate}>" onclick="changeDate('<{$dateOnline}>','<{$dateStrToday}>');"></br>
</div>
<script type="text/javascript">
        function changePage(page){
                $("#page").val(page);
                $("#myform").submit();
        }
</script>
<table width="100%"  border="0" cellspacing="0" cellpadding="0" class='table_page_num'>
	<tr>
		<td height="30" class="even">
			<{foreach key=key item=item from=$pageList}>
				<a id="pageUrl" href="javascript:void(0);" onclick="changePage('<{$item}>');"><{$key}></a><span style="width:5px;"></span>
			<{/foreach}>
			<{$lang->page->record}>(<{$recordCount}>)&nbsp;&nbsp;&nbsp;<{$lang->page->totalPage}>(<{if $pageCount}><{$pageCount}><{else}>1<{/if}>)
			<{$lang->page->everyPage}>
			<input type="text" id="pageLine" name="pageLine" size="4" style="text-align:center;" value="<{$pageLine}>">
			<{$lang->page->row}>
			<{$lang->page->dang}>
			<input id="page" name="page" type="text" class="text" size="3" style="text-align:center;" maxlength="6" value="<{$page}>">
			<{$lang->page->page}>&nbsp;
			<input type="submit" class="button" name="Submit" value="GO">&nbsp;
		</td>
	</tr>
</table>

<div><span style='color:#000; font-weight:bolder;'><{$lang->strengthenLv->roleTotal}></span><span style="color:#ff0000; font-weight:bolder;"><{$data3.totalRoles}></span></div>

<table class="DataGrid" cellspacing="0" style="margin:5px;">
	<tr>
		<th><{$lang->strengthenLv->strengthenLvRange}></th>
		<th><{$lang->strengthenLv->operateTimes}></th>
		<th><{$lang->strengthenLv->successes}></th>
		<th><{$lang->strengthenLv->failures}></th>
		<th><{$lang->strengthenLv->rolenames}></th>
		<th><{$lang->strengthenLv->equips}></th>
		<th><{$lang->strengthenLv->protects}></th>
		<th><{$lang->strengthenLv->luckys}></th>
	</tr>
	<{foreach name=loop from=$countResult item=item key=key}>
		<tr class='<{cycle values="trEven,trOdd"}>' style='text-align:center;'>
			<td><{$item.pre_strengthen}></td>
			<td><{$item.results}> | 100%</td>
			<td><{if $item.success}><{$item.success}><{else}>0<{/if}> | <{$item.successRate}>%</td>
			<td><{if $item.failure}><{$item.failure}><{else}>0<{/if}> | <{$item.failureRate}>%</td>
			<td><{$item.roleNames}></td>
			<td><{$item.equips}></td>
			<td><{$item.protects}></td>
			<td><{$item.luckys}></td>
		</tr>
	<{/foreach}>
	<{if $countResult}>
		<tr class='<{cycle values="trEven,trOdd"}>' style='text-align:center;'>
			<td><{$lang->strengthenLv->total}></td>
			<td><{$totalArr.totalOperates}> | 100%</td>
			<td><{$totalArr.totalSuccess}> | <{if $totalArr.totalOperates>0}><{math equation="x*100 / y" x=$totalArr.totalSuccess y=$totalArr.totalOperates format="%.2f"}><{else}>0<{/if}>%</td>
			<td><{$totalArr.totalFailure}> | <{if $totalArr.totalOperates>0}><{math equation="x*100 / y" x=$totalArr.totalFailure y=$totalArr.totalOperates format="%.2f"}><{else}>0<{/if}>%</td>
			<td><{$data2.totalRoles}></td>
			<td><{$totalArr.totalEquips}></td>
			<td><{$totalArr.totalProtects}></td>
			<td><{$totalArr.totalLuckys}></td>
		</tr>
	<{/if}>

</table><br>

<table class="DataGrid" cellspacing="0" style="margin:5px;">
	<tr>
		<th><{$lang->strengthenLv->equipName}></th>
		<th><{$lang->strengthenLv->equipUid}></th>
		<th><{$lang->sys->account}></th>
		<th><{$lang->page->roleName}></th>
		<th><{$lang->sys->playerLevel}></th>
		<th><{$lang->strengthenLv->mtime}></th>
		<th><{$lang->strengthenLv->strengthenPreLv}></th>
		<th><{$lang->strengthenLv->strengthenAfterLv}></th>
		<th><{$lang->strengthenLv->successOrNot}></th>
		<th><{$lang->strengthenLv->protect}></th>
		<th><{$lang->strengthenLv->lucky}></th>
		<th><{$lang->strengthenLv->successRate}></th>
		<th><{$lang->strengthenLv->randomRate}></th>
	</tr>
	<{foreach name=loop from=$viewData item=item key=key}>
		<tr class='<{cycle values="trEven,trOdd"}>' style='text-align:center;'>
			<td><{if $item.after_equip_id}><{$arrItemsAll[$item.after_equip_id].name}><{else}>0<{/if}></td>
			<td><{if $item.equip_uid}><{$item.equip_uid}><{else}>0<{/if}></td>
			<td><{$item.account_name}></td>
			<td><{$item.role_name}></td>
			<td><{$item.level}></td>
			<td><{$item.mtime|date_format:"%Y-%m-%d %H:%M:%S"}>&nbsp;</td>
			<td><{$item.pre_strengthen}>&nbsp;</td>
			<td><{$item.strengthen}>&nbsp;</td>
			<td><{if $item.result==1}><{$lang->strengthen->success}><{else}><{$lang->strengthen->failure}><{/if}>&nbsp;</td>
			<td><{if $item.protect_id>0}><{$arrItemsAll[$item.protect_id].name}><{else}>0<{/if}>&nbsp;</td>
			<td><{if $item.lucky_id>0}>√<{else}>×<{/if}>&nbsp;</td>
			<td><{$item.success_rate}>%&nbsp;</td>
			<td><{$item.rate}>%&nbsp;</td>
		</tr>
	<{/foreach}>
</table>
</form>
</body>
</html>

