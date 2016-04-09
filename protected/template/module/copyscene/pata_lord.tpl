<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>
	<{$lang->menu->pataLord}>
</title>
<link rel="stylesheet" href="/static/css/base.css" type="text/css" />
<link rel="stylesheet" href="/static/css/style.css" type="text/css" />
<link rel="stylesheet" href="/static/js/autolist/autolist.css" type="text/css" />
<script type="text/javascript" src="/static/js/jquery.min.js"></script>	
<script type="text/javascript" src="/static/js/My97DatePicker/WdatePicker.js"></script>
<script type="text/javascript" src="/static/js/autolist/autolist.js"></script>
<script type="text/javascript" src="/static/js/sorttable.js"></script>
<script type="text/javascript" src="/static/js/flowtitle.js"></script>
<script type="text/javascript" src="/static/js/colResizable-1.3.min.js"></script>
<script type="text/javascript" src="/static/js/global.js"></script>
<script src="/static/js/highcharts/highcharts.js" type="text/javascript"></script>
<script type="text/javascript" src="/static/js/Highcharts/modules/exporting.js"></script>
<script type="text/javascript">
	
</script>
</head>

<body>

<div id="position">
<b><{$lang->menu->class->activityManage}>：<{$lang->menu->pataLord }></b>
</div> 

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
<{$lang->activity->floor}>:<{html_options options=$floorList selected=$floor name='floor'}>
<input type="hidden" name="search" value="1"/>
<input type="hidden" name="pageSize" value="100"/>
<input type="image" src="/static/images/search.gif" class="input2" align="absmiddle"  />
&nbsp;&nbsp;
</form>
<form id="myform2" name="myform2" method="post" action="<{$current_uri}>" style="display: inline;">
	<input type="submit" class="button" name="dateToday" value="<{$lang->page->today}>" >&nbsp;&nbsp;
	<input type="submit" <{if $selectedDay and $selectedDay <= $minDate }> disabled="disabled" <{/if}> class="button" name="datePrev" value="<{$lang->page->prevTime}>">&nbsp;&nbsp;
	<input type="submit" <{if $selectedDay and $selectedDay >= $maxDate }> disabled="disabled" <{/if}> class="button" name="dateNext" value="<{$lang->page->nextTime}>">&nbsp;&nbsp;
	<input type="submit" class="button" name="dateAll" value="<{$lang->page->fromOnlineDate}>" >
	<input type="hidden" class="button" name="selectedDay" value="<{$selectedDay}>" >
	<input type="hidden" id="role_name" name="role_name" size="15" value="<{$roleName}>" />
	<input type="hidden" id="account_name" name="account_name" size="15" value="<{$accountName}>" />
</form>
</div>
<br class="clear" />

<{if $viewData.data}>
	<div id="participationcontainer" style="width: 100%; height: 80%">
		<table cellspacing="1" cellpadding="3" border="0" class="table_list sortable"  >
			<caption class='table_list_head'>
				<{$lang->menu->pataLord}>
			</caption>
			<tr class='table_list_head'>
		        <th width="20%"><{$lang->activity->date}></th>
		        <th width="25%"><{$lang->activity->accountName}></th>
		        <th width="25%"><{$lang->activity->roleName}></th>
		        <th width="15%"><{$lang->activity->level}></th>
		        <th width="15%"><{$lang->activity->floor}></th>
		        <th width="15%"><{$lang->activity->challengeWay}></th>
			</tr>
			<{foreach name=loop from=$viewData.data item=item}>
			<tr class='<{cycle values="trEven,trOdd"}>'>
				<td><{$item.mtime|date_format:"%Y-%m-%d %H:%M:%S"}></td>
				<td class="cmenu" title="<{$item.account_name}>"><{$item.account_name}></td>
				<td class="cmenu" title="<{$item.role_name}>"><{$item.role_name}></td>
				<td align="center"><{$item.level}></td>
				<td align="center"><{$item.floor}></td>
				<td align="center"><{$dictPataChallengeWay[$item.way]}></td>
			</tr>
			<{foreachelse}>
			<font color='red'><{$lang->page->noData}></font>
			<{/foreach}>
		</table>
	</div>
<{else}>
<{*<font color='red'><{$lang->page->noData}></font>*}>
<{/if}>

</body>
</html>
