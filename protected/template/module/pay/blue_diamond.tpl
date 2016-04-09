<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>
		<{$lang->menu->blueDiamondOpen}>
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
	<b><{$lang->menu->class->payAndSpand}>：<{$lang->menu->blueDiamondOpen}></b>
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
	&nbsp;<{$lang->blue->allCount}>:
	<table height="" cellspacing="0" border="0" class="DataGrid">
		<tr>
			<td width="20%"> &nbsp;<{$lang->blue->openCount}>: &nbsp; <{$statisticsData.all.open_pt_count}></td>
			<td width="20%"> &nbsp;<{$lang->blue->openYearCount}>: &nbsp; <{$statisticsData.all.open_year_count}></td>
			<td width="30%"> &nbsp;<{$lang->blue->maxOpenDayCount}>: &nbsp; <{$statisticsData.all.maxOpen.count}>, &nbsp; <{$statisticsData.all.maxOpen.date}></td>
			<td width="30%"></td>
		</tr>
		<tr>
			<td width="20%"> &nbsp;<{$lang->blue->renewCount}>: &nbsp; <{$statisticsData.all.renew_pt_role_count}></td>
			<td width="20%"> &nbsp;<{$lang->blue->renewYearCount}>: &nbsp; <{$statisticsData.all.renew_year_role_count}></td>
			<td width="30%"> &nbsp;<{$lang->blue->maxRenewDayCount}>: &nbsp; <{$statisticsData.all.maxRenew.count}>, &nbsp; <{$statisticsData.all.maxRenew.date}></td>
			<td width="30%"></td>
		</tr>
		<tr>
			<td width="20%"> &nbsp;<{$lang->blue->renewRoleCount}>: &nbsp; <{$statisticsData.all.renew_pt_count}></td>
			<td width="20%"> &nbsp;<{$lang->blue->renewYearRoleCount}>: &nbsp; <{$statisticsData.all.renew_year_count}></td>
			<td width="30%"> &nbsp;<{$lang->blue->maxRenewDayRoleCount}>: &nbsp; <{$statisticsData.all.maxRoleRenew.count}>, &nbsp; <{$statisticsData.all.maxRoleRenew.role_name}>, &nbsp; <{$statisticsData.all.maxRoleRenew.date}></td>
			<td width="30%"></td>
		</tr>
    </table>
	<br />
	
	&nbsp;<{$lang->page->betweenDate}>:
	<table height="" cellspacing="0" border="0" class="DataGrid">
		<tr>
			<td width="30%"> &nbsp;<{$lang->blue->openCount}>: &nbsp; <{$statisticsData.date.open_pt_count}></td>
			<td width="30%"> &nbsp;<{$lang->blue->openYearCount}>: &nbsp; <{$statisticsData.date.open_year_count}></td>
			<td width="40%"></td>
		</tr>
		<tr>
			<td width="30%"> &nbsp;<{$lang->blue->renewCount}>: &nbsp; <{$statisticsData.date.renew_pt_role_count}></td>
			<td width="30%"> &nbsp;<{$lang->blue->renewYearCount}>: &nbsp; <{$statisticsData.date.renew_year_role_count}></td>
			<td width="40%"></td>
		</tr>
		<tr>
			<td width="30%"> &nbsp;<{$lang->blue->renewRoleCount}>: &nbsp; <{$statisticsData.date.renew_pt_count}></td>
			<td width="30%"> &nbsp;<{$lang->blue->renewYearRoleCount}>: &nbsp; <{$statisticsData.date.renew_year_count}></td>
			<td width="40%"></td>
		</tr>
	</table>
	
	<br />
	<{if $viewData}>
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
	
	<table cellspacing="1" cellpadding="3" border="0" class='table_list' >
		<tr align="center" class='table_list_head'>
	        <td width="20%"><{$lang->player->roleName}></td>
	        <td width="20%"><{$lang->player->accountName}></td>
	        <td width="10%"><{$lang->player->level}></td>
	        <td width="10%"><{$lang->blue->isBlueDiamond}></td>
	        <td width="10%"><{$lang->blue->isBlueYearDiamond}></td> 
            <td width="10%"><{$lang->blue->BlueDiamondLevel}></td>
	        <td width="10%"><{$lang->blue->openTime}></td>
	        <td width="10%"><{$lang->blue->openType}></td>
		</tr>
		
	<{foreach name=loop from=$viewData item=item}>
		<tr align="center" class='<{cycle values="trEven,trOdd"}>'>
			<td class="cmenu" title="<{$item.role_name}>"><{$item.role_name}></td>
			<td class="cmenu" title="<{$item.role_name}>"><{$item.account_name}></td>
			<td><{$item.level}></td>
			<td><{$item.blue}></td>
			<td><{$item.blueYear}></td>
            <td><{$item.blueLv}></td>
			<td><{$item.mtime|date_format:'%Y-%m-%d %H:%M:%S'}></td>
			<td><{if $item.isYear==1}><{$lang->blue->year}><{else}><{$lang->blue->putong}><{/if}></td>
		</tr>
	<{foreachelse}>
		<font color='red'><{$lang->page->noData}></font>
	<{/foreach}>
	</table>
	<{/if}>
	</div>
	</form>
	
</body>
</html>
