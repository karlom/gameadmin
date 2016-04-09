<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>
	<{$lang->menu->escort}>
</title>
<link rel="stylesheet" href="/static/css/base.css" type="text/css">
<link rel="stylesheet" href="/static/css/style.css" type="text/css">
<script type="text/javascript" src="/static/js/jquery.min.js"></script>	
<script type="text/javascript" src="/static/js/My97DatePicker/WdatePicker.js"></script>
<script type="text/javascript" src="/static/js/global.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	$('.foldbar').toggle(function(){
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
<!--  
<div id="position">
<b><{$lang->menu->class->userInfo}>：<{$lang->menu->escort}></b>
</div> 
-->
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
&nbsp;<{$lang->player->roleName}>:<input type="text" id="role_name" name="role_name" size="10" value="<{$roleName}>" />
&nbsp;<{$lang->player->accountName}>:<input type="text" id="account_name" name="account_name" size="10" value="<{$accountName}>" />
<input type="image" src="/static/images/search.gif" class="input2" align="absmiddle"  />
&nbsp;&nbsp;
</form>
<form id="myform2" name="myform2" method="post" action="<{$current_uri}>" style="display: inline;">
	<input type="submit" class="button" name="dateToday" value="<{$lang->page->today}>" >&nbsp;&nbsp;
	<input type="submit" <{if $selectedDay and $selectedDay <= $minDate }> disabled="disabled" <{/if}> class="button" name="datePrev" value="<{$lang->page->prevTime}>">&nbsp;&nbsp;
	<input type="submit" <{if $selectedDay and $selectedDay >= $maxDate }> disabled="disabled" <{/if}> class="button" name="dateNext" value="<{$lang->page->nextTime}>">&nbsp;&nbsp;
	<{if $roleName or $accountName}>
		<input type="submit" class="button" name="dateAll" value="<{$lang->page->fromOnlineDate}>" >
	<{/if}>
	<input type="hidden" class="button" name="selectedDay" value="<{$selectedDay}>" >
	<input type="hidden" id="role_name" name="role_name" size="15" value="<{$roleName}>" />
	<input type="hidden" id="account_name" name="account_name" size="15" value="<{$accountName}>" />
</form>
</div>
<{if $viewData.data}>

<{include file='file:pager.tpl' pages=$pager assign=pager_html}>
<{$pager_html}>
<br class="clear"/>
<table cellspacing="1" cellpadding="3" border="0" class='DataGrid table_list' >
	<tr class='table_list_head'>
        <th width="10%"><{$lang->player->roleName}></th>
        <th width="10%"><{$lang->player->accountName}></th>
        <th width="15%"><{$lang->player->taskTimes}></th>
		<th width="10%"><{$lang->player->date}></th>
	</tr>
	<{foreach name=loop1 from=$viewData.data item=itemT}>
	<tr class=' <{ if $smarty.foreach.loop1.index is odd }>trOdd<{else}>trEven<{ /if }> foldbar' style="cursor:pointer;">
		<td width="25%" class="cmenu" title="<{$itemT.meta.role_name}>"><{$itemT.meta.role_name}></td>
        <td width="25%" class="cmenu" title="<{$itemT.meta.role_name}>"><{$itemT.meta.account_name}></td>
        <td width="15%" align="center" <{if $itemT.meta.times gt 3}>style="color:red;font-weight:bold;"<{/if}> ><{$itemT.meta.times}></td>
		<td width="35%" align="center"><{$itemT.meta.date}></td>
	</tr>
	<tr style="display:none">
		<td colspan="4">
			<table cellspacing="1" cellpadding="3" border="0" class='DataGrid table_list' >
				<tr class='table_list_head'>
			        <td width="10%"><{$lang->player->roleName}></td>
			        <td width="10%"><{$lang->player->accountName}></td>
			        <td width="10%"><{$lang->player->beginTime}></td>
					<td width="5%"><{$lang->player->isRefresh}></td>
					<td width="20%"><{$lang->player->escortDetail}></td>
					<td width="10%"><{$lang->player->escortTimes}></td>
					<td width="5%"><{$lang->player->insurance}></td>
			        <td width="5%"><{$lang->player->escortColor}></td>
			        <td width="5%"><{$lang->player->escortResult}></td>
					<td width="10%"><{$lang->player->endTime}></td>
				</tr>
				
			<{foreach name=loop from=$itemT.data item=item}>
				<tr class='<{cycle values="trEven,trOdd"}>'>
					<td><{$item.role_name}></td>
					<td><{$item.account_name}></td>
					<td><{$item.mtime-$item.time_used|date_format:'%Y-%m-%d %H:%M:%S'}></td>
					<td><{if $item.refresh_times > 0}><{$lang->player->yes}><{else}><{$lang->player->no}><{/if}></td>
					<td><{$item.detail}></td>
					<td align="center"><{$item.escort_times+1}></td>
					<td align="center"><{$item.insurance}></td>
					<td><{$dictColor[$item.escort_type]}></td>
					<td><{$dictEscortStatus[$item.escort_status]}></td>
					<td><{$item.mtime|date_format:'%Y-%m-%d %H:%M:%S'}></td>
				</tr>
			<{/foreach}>
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
